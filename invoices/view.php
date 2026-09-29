<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

require_login();

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

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Invoice <?= htmlspecialchars(
            $sale['invoice_number'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </title>

    <style>

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #222;
        }

        .invoice {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 35px;
        }

        .invoice-header h1 {
            margin: 0 0 8px;
        }

        .invoice-header p {
            margin: 4px 0;
        }

        .customer-section {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f8f8f8;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-size: 18px;
            font-weight: bold;
        }

        .actions {
            margin-bottom: 20px;
            text-align: right;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border: none;
            border-radius: 6px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: #6b7280;
        }

        @media print {

            body {
                background: #fff;
                padding: 0;
            }

            .invoice {
                max-width: none;
                box-shadow: none;
                padding: 20px;
            }

            .actions {
                display: none;
            }

        }

    </style>

</head>

<body>

<div class="actions">

    <a
        class="btn btn-secondary"
        href="/sales/view.php?id=<?= (int) $sale['id'] ?>"
    >
        Back to Sale
    </a>

    <button
        class="btn"
        type="button"
        onclick="window.print()"
    >
        Print Invoice
    </button>

</div>

<div class="invoice">

    <div class="invoice-header">

        <div>

            <h1>INVOICE</h1>

            <p>
                <strong>P002 Small Business Management System</strong>
            </p>

        </div>

        <div>

            <p>
                <strong>Invoice:</strong>
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

        </div>

    </div>

    <div class="customer-section">

        <h2>Bill To</h2>

        <p>
            <strong>
                <?= htmlspecialchars(
                    $sale['customer_name'] ?? 'Walk-in Customer',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </strong>
        </p>

        <?php if (!empty($sale['customer_phone'])): ?>

            <p>
                Phone:
                <?= htmlspecialchars(
                    $sale['customer_phone'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </p>

        <?php endif; ?>

        <?php if (!empty($sale['customer_email'])): ?>

            <p>
                Email:
                <?= htmlspecialchars(
                    $sale['customer_email'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </p>

        <?php endif; ?>

        <?php if (!empty($sale['customer_address'])): ?>

            <p>
                Address:
                <?= htmlspecialchars(
                    $sale['customer_address'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </p>

        <?php endif; ?>

    </div>

    <table>

        <thead>

            <tr>

                <th>Product</th>
                <th>SKU</th>
                <th>Qty</th>
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

                <td
                    colspan="4"
                    class="text-right total-row"
                >
                    Total
                </td>

                <td class="total-row">

                    <?= number_format(
                        (float) $sale['total_amount'],
                        2
                    ) ?>

                </td>

            </tr>

        </tfoot>

    </table>

    <br>

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

</body>

</html>
