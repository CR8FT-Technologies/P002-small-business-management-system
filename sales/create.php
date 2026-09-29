<?php

declare(strict_types=1);

$page_title = 'P002 - Create Sale';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$customers = $pdo
    ->query(
        'SELECT id, name, phone
         FROM customers
         ORDER BY name ASC'
    )
    ->fetchAll();

$products = $pdo
    ->query(
        'SELECT id, name, sku, price, stock_quantity
         FROM products
         WHERE stock_quantity > 0
         ORDER BY name ASC'
    )
    ->fetchAll();

$error = '';

$customer_id = '';
$product_id = '';
$quantity = 1;
$payment_method = 'cash';
$payment_status = 'paid';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customer_id = trim($_POST['customer_id'] ?? '');
    $product_id = filter_input(
        INPUT_POST,
        'product_id',
        FILTER_VALIDATE_INT
    );
    $quantity = filter_input(
        INPUT_POST,
        'quantity',
        FILTER_VALIDATE_INT
    );
    $payment_method = trim($_POST['payment_method'] ?? 'cash');
    $payment_status = trim($_POST['payment_status'] ?? 'paid');

    if ($product_id === false || $product_id < 1) {

        $error = 'Please select a product.';

    } elseif ($quantity === false || $quantity < 1) {

        $error = 'Quantity must be at least 1.';

    } elseif (
        !in_array(
            $payment_method,
            ['cash', 'bank', 'card', 'other'],
            true
        )
    ) {

        $error = 'Invalid payment method.';

    } elseif (
        !in_array(
            $payment_status,
            ['paid', 'pending', 'partial'],
            true
        )
    ) {

        $error = 'Invalid payment status.';

    } else {

        $customer_id_value = null;

        if ($customer_id !== '') {

            $customer_id_int = filter_var(
                $customer_id,
                FILTER_VALIDATE_INT
            );

            if ($customer_id_int === false || $customer_id_int < 1) {

                $error = 'Invalid customer selected.';

            } else {

                $stmt = $pdo->prepare(
                    'SELECT id
                     FROM customers
                     WHERE id = ?
                     LIMIT 1'
                );

                $stmt->execute([$customer_id_int]);

                if (!$stmt->fetch()) {

                    $error = 'Selected customer does not exist.';

                } else {

                    $customer_id_value = $customer_id_int;
                }
            }
        }

        if ($error === '') {

            $stmt = $pdo->prepare(
                'SELECT id, price, stock_quantity
                 FROM products
                 WHERE id = ?
                 LIMIT 1'
            );

            $stmt->execute([$product_id]);
            $product = $stmt->fetch();

            if (!$product) {

                $error = 'Selected product does not exist.';

            } elseif ((int) $product['stock_quantity'] < $quantity) {

                $error = 'Insufficient stock. Available stock: '
                    . $product['stock_quantity'];

            } else {

                $unit_price = (float) $product['price'];
                $subtotal = $unit_price * $quantity;
                $invoice_number = 'INV-' . date('YmdHis') . '-' . random_int(100, 999);

                try {

                    $pdo->beginTransaction();

                    $stmt = $pdo->prepare(
                        'INSERT INTO sales
                            (
                                customer_id,
                                invoice_number,
                                total_amount,
                                payment_method,
                                payment_status
                            )
                         VALUES (?, ?, ?, ?, ?)'
                    );

                    $stmt->execute([
                        $customer_id_value,
                        $invoice_number,
                        $subtotal,
                        $payment_method,
                        $payment_status
                    ]);

                    $sale_id = (int) $pdo->lastInsertId();

                    $stmt = $pdo->prepare(
                        'INSERT INTO sale_items
                            (
                                sale_id,
                                product_id,
                                quantity,
                                unit_price,
                                subtotal
                            )
                         VALUES (?, ?, ?, ?, ?)'
                    );

                    $stmt->execute([
                        $sale_id,
                        $product_id,
                        $quantity,
                        $unit_price,
                        $subtotal
                    ]);

                    $stmt = $pdo->prepare(
                        'UPDATE products
                         SET stock_quantity = stock_quantity - ?
                         WHERE id = ?'
                    );

                    $stmt->execute([
                        $quantity,
                        $product_id
                    ]);

                    $pdo->commit();

                    header(
                        'Location: /sales/view.php?id='
                        . $sale_id
                    );

                    exit;

                } catch (Throwable $e) {

                    if ($pdo->inTransaction()) {
                        $pdo->rollBack();
                    }

                    $error = 'Sale could not be created. Please try again.';
                }
            }
        }
    }
}

?>

<div class="page-header">

    <div>
        <h1>Create Sale</h1>
        <p>Create a new sales transaction.</p>
    </div>

    <a class="btn btn-secondary" href="/sales/index.php">
        Back to Sales
    </a>

</div>

<?php if ($error !== ''): ?>

    <div class="alert alert-error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>

<?php endif; ?>

<div class="card">

    <form method="post">

        <div class="form-group">

            <label for="customer_id">Customer</label>

            <select id="customer_id" name="customer_id">

                <option value="">Walk-in Customer</option>

                <?php foreach ($customers as $customer): ?>

                    <option
                        value="<?= (int) $customer['id'] ?>"
                        <?= (string) $customer_id === (string) $customer['id']
                            ? 'selected'
                            : '' ?>
                    >
                        <?= htmlspecialchars(
                            $customer['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                        <?php if (!empty($customer['phone'])): ?>
                            - <?= htmlspecialchars(
                                $customer['phone'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        <?php endif; ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="form-group">

            <label for="product_id">Product</label>

            <select
                id="product_id"
                name="product_id"
                required
            >

                <option value="">Select Product</option>

                <?php foreach ($products as $product): ?>

                    <option
                        value="<?= (int) $product['id'] ?>"
                        <?= (string) $product_id === (string) $product['id']
                            ? 'selected'
                            : '' ?>
                    >
                        <?= htmlspecialchars(
                            $product['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                        -
                        <?= htmlspecialchars(
                            $product['sku'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                        -
                        <?= number_format(
                            (float) $product['price'],
                            2
                        ) ?>
                        (Stock: <?= (int) $product['stock_quantity'] ?>)
                    </option>

                <?php endforeach; ?>

            </select>

        </div>

        <div class="form-group">

            <label for="quantity">Quantity</label>

            <input
                type="number"
                id="quantity"
                name="quantity"
                min="1"
                value="<?= (int) $quantity ?>"
                required
            >

        </div>

        <div class="form-group">

            <label for="payment_method">Payment Method</label>

            <select
                id="payment_method"
                name="payment_method"
                required
            >

                <option
                    value="cash"
                    <?= $payment_method === 'cash'
                        ? 'selected'
                        : '' ?>
                >
                    Cash
                </option>

                <option
                    value="bank"
                    <?= $payment_method === 'bank'
                        ? 'selected'
                        : '' ?>
                >
                    Bank
                </option>

                <option
                    value="card"
                    <?= $payment_method === 'card'
                        ? 'selected'
                        : '' ?>
                >
                    Card
                </option>

                <option
                    value="other"
                    <?= $payment_method === 'other'
                        ? 'selected'
                        : '' ?>
                >
                    Other
                </option>

            </select>

        </div>

        <div class="form-group">

            <label for="payment_status">Payment Status</label>

            <select
                id="payment_status"
                name="payment_status"
                required
            >

                <option
                    value="paid"
                    <?= $payment_status === 'paid'
                        ? 'selected'
                        : '' ?>
                >
                    Paid
                </option>

                <option
                    value="pending"
                    <?= $payment_status === 'pending'
                        ? 'selected'
                        : '' ?>
                >
                    Pending
                </option>

                <option
                    value="partial"
                    <?= $payment_status === 'partial'
                        ? 'selected'
                        : '' ?>
                >
                    Partial
                </option>

            </select>

        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Create Sale
        </button>

        <a
            class="btn btn-secondary"
            href="/sales/index.php"
        >
            Cancel
        </a>

    </form>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
