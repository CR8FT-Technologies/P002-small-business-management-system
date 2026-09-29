<?php

declare(strict_types=1);

$page_title = 'P002 - Invoices';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->query(
    'SELECT
        s.id,
        s.invoice_number,
        s.total_amount,
        s.payment_method,
        s.payment_status,
        s.created_at,
        c.name AS customer_name
     FROM sales s
     LEFT JOIN customers c ON c.id = s.customer_id
     ORDER BY s.id DESC'
);

$invoices = $stmt->fetchAll();

?>

<div class="page-header">

    <div>
        <h1>Invoices</h1>
        <p>View and print customer invoices.</p>
    </div>

</div>

<div class="card">

    <?php if (count($invoices) === 0): ?>

        <p>No invoices found.</p>

    <?php else: ?>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Invoice Number</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($invoices as $invoice): ?>

                    <tr>

                        <td>
                            <?= (int) $invoice['id'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $invoice['invoice_number'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $invoice['customer_name']
                                    ?? 'Walk-in Customer',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= number_format(
                                (float) $invoice['total_amount'],
                                2
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                ucfirst($invoice['payment_method']),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                ucfirst($invoice['payment_status']),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $invoice['created_at'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    class="btn btn-secondary"
                                    href="/invoices/view.php?id=<?= (int) $invoice['id'] ?>"
                                >
                                    View
                                </a>

                            </div>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
