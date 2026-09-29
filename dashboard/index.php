<?php

declare(strict_types=1);

$page_title = 'P002 - Dashboard';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$product_count = (int) $pdo
    ->query('SELECT COUNT(*) FROM products')
    ->fetchColumn();

$customer_count = (int) $pdo
    ->query('SELECT COUNT(*) FROM customers')
    ->fetchColumn();

$sales_count = (int) $pdo
    ->query('SELECT COUNT(*) FROM sales')
    ->fetchColumn();

$low_stock_count = (int) $pdo
    ->query(
        'SELECT COUNT(*)
         FROM products
         WHERE stock_quantity <= low_stock_threshold'
    )
    ->fetchColumn();

?>

<div class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p>
            Welcome,
            <?= htmlspecialchars($_SESSION['name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?>.
        </p>
    </div>
</div>

<div class="stat-grid">

    <div class="stat-card">
        <h3>Products</h3>
        <p><?= $product_count ?></p>
    </div>

    <div class="stat-card">
        <h3>Customers</h3>
        <p><?= $customer_count ?></p>
    </div>

    <div class="stat-card">
        <h3>Total Sales</h3>
        <p><?= $sales_count ?></p>
    </div>

    <div class="stat-card">
        <h3>Low Stock</h3>
        <p><?= $low_stock_count ?></p>
    </div>

</div>

<div class="card">
    <h2>Quick Actions</h2>

    <p>
        <a class="btn btn-primary" href="/products/create.php">
            Add Product
        </a>

        <a class="btn btn-secondary" href="/customers/create.php">
            Add Customer
        </a>

        <a class="btn btn-primary" href="/sales/create.php">
            New Sale
        </a>
    </p>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
