<?php

declare(strict_types=1);

$page_title = 'P002 - Dashboard';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$total_products = (int) $pdo->query(
    'SELECT COUNT(*) FROM products'
)->fetchColumn();

$total_customers = (int) $pdo->query(
    'SELECT COUNT(*) FROM customers'
)->fetchColumn();

$total_sales_count = (int) $pdo->query(
    'SELECT COUNT(*) FROM sales'
)->fetchColumn();

$total_revenue = (float) $pdo->query(
    'SELECT COALESCE(SUM(total_amount), 0) FROM sales'
)->fetchColumn();

$low_stock_count = (int) $pdo->query(
    'SELECT COUNT(*)
     FROM products
     WHERE stock_quantity <= low_stock_threshold'
)->fetchColumn();

$recent_sales_stmt = $pdo->query(
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
     ORDER BY s.id DESC
     LIMIT 5'
);

$recent_sales = $recent_sales_stmt->fetchAll();

$low_stock_stmt = $pdo->query(
    'SELECT
        id,
        name,
        sku,
        stock_quantity,
        low_stock_threshold
     FROM products
     WHERE stock_quantity <= low_stock_threshold
     ORDER BY stock_quantity ASC, name ASC
     LIMIT 5'
);

$low_stock_products = $low_stock_stmt->fetchAll();

?>

<div class="page-header">

    <div>
        <h1>Dashboard</h1>
        <p>
            Welcome,
            <?= htmlspecialchars(
                current_username() ?? 'User',
                ENT_QUOTES,
                'UTF-8'
            ) ?>.
        </p>
    </div>

</div>

<div class="stat-grid">

    <div class="stat-card">
        <h3>Products</h3>
        <p><?= $total_products ?></p>
    </div>

    <div class="stat-card">
        <h3>Customers</h3>
        <p><?= $total_customers ?></p>
    </div>

    <div class="stat-card">
        <h3>Sales Count</h3>
        <p><?= $total_sales_count ?></p>
    </div>

    <div class="stat-card">
        <h3>Total Revenue</h3>
        <p><?= number_format($total_revenue, 2) ?></p>
    </div>

    <div class="stat-card">
        <h3>Low Stock</h3>
        <p><?= $low_stock_count ?></p>
    </div>

</div>

<div class="card">

    <div class="page-header">

        <div>
            <h2>Quick Actions</h2>
            <p>Common tasks for daily business operations.</p>
        </div>

    </div>

    <div class="actions">

        <a
            class="btn btn-primary"
            href="/products/create.php"
        >
            Add Product
        </a>

        <a
            class="btn btn-primary"
            href="/customers/create.php"
        >
            Add Customer
        </a>

        <a
            class="btn btn-primary"
            href="/sales/create.php"
        >
            New Sale
        </a>

        <a
            class="btn btn-secondary"
            href="/reports/index.php"
        >
            View Reports
        </a>

        <a
            class="btn btn-secondary"
            href="/backup/index.php"
        >
            Backup Database
        </a>

    </div>

</div>

<div class="card">

    <div class="page-header">

        <div>
            <h2>Recent Sales</h2>
            <p>Latest transactions recorded in the system.</p>
        </div>

        <a
            class="btn btn-secondary"
            href="/sales/index.php"
        >
            View All Sales
        </a>

    </div>

    <?php if (count($recent_sales) === 0): ?>

        <p>No sales found.</p>

    <?php else: ?>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($recent_sales as $sale): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $sale['invoice_number'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $sale['customer_name']
                                    ?? 'Walk-in Customer',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= number_format(
                                (float) $sale['total_amount'],
                                2
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                ucfirst($sale['payment_method']),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                ucfirst($sale['payment_status']),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $sale['created_at'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    class="btn btn-secondary"
                                    href="/sales/view.php?id=<?= (int) $sale['id'] ?>"
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

<div class="card">

    <div class="page-header">

        <div>
            <h2>Low Stock Products</h2>
            <p>Products that have reached their low-stock threshold.</p>
        </div>

        <a
            class="btn btn-secondary"
            href="/products/index.php"
        >
            Manage Products
        </a>

    </div>

    <?php if (count($low_stock_products) === 0): ?>

        <p>No low-stock products found.</p>

    <?php else: ?>

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Current Stock</th>
                        <th>Threshold</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($low_stock_products as $product): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $product['name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $product['sku'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= (int) $product['stock_quantity'] ?>
                        </td>

                        <td>
                            <?= (int) $product['low_stock_threshold'] ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
