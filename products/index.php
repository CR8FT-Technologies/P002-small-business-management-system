<?php

declare(strict_types=1);

$page_title = 'P002 - Products';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->query(
    'SELECT id, name, sku, category, price, stock_quantity, low_stock_threshold
     FROM products
     ORDER BY id DESC'
);

$products = $stmt->fetchAll();

$success = $_GET['success'] ?? '';

?>

<div class="page-header">
    <div>
        <h1>Products</h1>
        <p>Manage products and inventory.</p>
    </div>

    <a class="btn btn-primary" href="/products/create.php">
        Add Product
    </a>
</div>

<?php if ($success === 'created'): ?>

    <div class="alert alert-success">
        Product created successfully.
    </div>

<?php elseif ($success === 'updated'): ?>

    <div class="alert alert-success">
        Product updated successfully.
    </div>

<?php elseif ($success === 'deleted'): ?>

    <div class="alert alert-success">
        Product deleted successfully.
    </div>

<?php elseif ($success === 'delete_blocked'): ?>

    <div class="alert alert-error">
        This product cannot be deleted because it has already been used in a sale.
    </div>

<?php endif; ?>

<div class="card">

    <?php if (count($products) === 0): ?>

        <p>No products found.</p>

    <?php else: ?>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($products as $product): ?>

                    <?php
                    $stock = (int) $product['stock_quantity'];
                    $threshold = (int) $product['low_stock_threshold'];
                    $is_low_stock = $stock <= $threshold;
                    ?>

                    <tr>

                        <td><?= (int) $product['id'] ?></td>

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
                            <?= htmlspecialchars(
                                $product['category'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= number_format(
                                (float) $product['price'],
                                2
                            ) ?>
                        </td>

                        <td>
                            <?= $stock ?>
                        </td>

                        <td>
                            <?php if ($is_low_stock): ?>
                                <strong>Low Stock</strong>
                            <?php else: ?>
                                In Stock
                            <?php endif; ?>
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    class="btn btn-secondary"
                                    href="/products/edit.php?id=<?= (int) $product['id'] ?>"
                                >
                                    Edit
                                </a>

                                <a
                                    class="btn btn-danger"
                                    href="/products/delete.php?id=<?= (int) $product['id'] ?>"
                                    onclick="return confirm('Delete this product?');"
                                >
                                    Delete
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

