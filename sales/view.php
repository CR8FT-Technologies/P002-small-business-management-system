<?php

declare(strict_types=1);

$page_title = 'P002 - Sale Details';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: /sales/index.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT
        s.id,
        s.invoice_number,
        s.total_amount,
        s.payment_method,
        s.payment_status,
        s.created_at,
        c.name AS customer_name,
        c.phone AS customer_phone,
        c.email AS customer_email,
        c.address AS customer_address
     FROM sales s
     LEFT JOIN customers c ON c.id = s.customer_id
     WHERE s.id = ?
     LIMIT 1'
);

$stmt->execute([$id]);
$sale = $stmt->fetch();

if (!$sale) {
    header('Location: /sales/index.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT
        si.quantity,
        si.unit_price,
        si.subtotal,
        p.name AS product_name,
        p.sku
     FROM sale_items si
     INNER JOIN products p ON p.id = si.product_id
     WHERE si.sale_id = ?
     ORDER BY si.id ASC'
);

$stmt->execute([$id]);
$items = $stmt->fetchAll();

?>

<div class="page-header">

    <div>
        <h1>Sale Details</h1>
        <p>
            Invoice:
            <?= htmlspecialchars(
                $sale['invoice_number'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>
    </div>

    <div class="actions">

        <a
            class="btn btn-secondary"
            href="/sales/index.php"
        >
            Back to Sales
        </a>

        <a
            class="btn btn-primary"
            href="/invoices/view.php?id=<?= (int) $sale['id'] ?>"
        >
            View Invoice
        </a>

    </div>

</div>

<div class="card">

    <h2>Sale Information</h2>

    <p>
        <strong>Invoice Number:</strong>
        <?= htmlspecialchars(
            $sale['invoice_number'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <p>
        <strong>Date:</strong>
        <?= htmlspecialchars(
            $sale['created_at'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <p>
        <strong>Customer:</strong>
        <?= htmlspecialchars(
            $sale['customer_name'] ?? 'Walk-in Customer',
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <?php if (!empty($sale['customer_phone'])): ?>

        <p>
            <strong>Phone:</strong>
            <?= htmlspecialchars(
                $sale['customer_phone'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>

    <?php endif; ?>

    <p>
        <strong>Payment Method:</strong>
        <?= htmlspecialchars(
            ucfirst($sale['payment_method']),
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

    <p>
        <strong>Payment Status:</strong>
        <?= htmlspecialchars(
            ucfirst($sale['payment_status']),
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </p>

</div>

<div class="card">

    <h2>Items</h2>

    <?php if (count($items) === 0): ?>

        <p>No sale items found.</p>

    <?php else: ?>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $item['product_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $item['sku'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= (int) $item['quantity'] ?>
                        </td>

                        <td>
                            <?= number_format(
                                (float) $item['unit_price'],
                                2
                            ) ?>
                        </td>

                        <td>
                            <?= number_format(
                                (float) $item['subtotal'],
                                2
                            ) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

                <tfoot>

                    <tr>

                        <th colspan="4" style="text-align: right;">
                            Total
                        </th>

                        <th>
                            <?= number_format(
                                (float) $sale['total_amount'],
                                2
                            ) ?>
                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
