<?php

declare(strict_types=1);

$page_title = 'P002 - Edit Product';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /products/index.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT id, name, sku, category, price, stock_quantity, low_stock_threshold
     FROM products
     WHERE id = ?
     LIMIT 1'
);

$stmt->execute([$id]);

$product = $stmt->fetch();

if (!$product) {
    header('Location: /products/index.php');
    exit;
}

$errors = [];

$name = $product['name'];
$sku = $product['sku'];
$category = $product['category'] ?? '';
$price = $product['price'];
$stock_quantity = $product['stock_quantity'];
$low_stock_threshold = $product['low_stock_threshold'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $stock_quantity = trim($_POST['stock_quantity'] ?? '');
    $low_stock_threshold = trim($_POST['low_stock_threshold'] ?? '');

    if ($name === '') {
        $errors[] = 'Product name is required.';
    }

    if ($sku === '') {
        $errors[] = 'SKU is required.';
    }

    if ($price === '' || !is_numeric($price) || (float) $price < 0) {
        $errors[] = 'Price must be a valid non-negative number.';
    }

    if (
        $stock_quantity === '' ||
        filter_var($stock_quantity, FILTER_VALIDATE_INT) === false ||
        (int) $stock_quantity < 0
    ) {
        $errors[] = 'Stock quantity must be a non-negative whole number.';
    }

    if (
        $low_stock_threshold === '' ||
        filter_var($low_stock_threshold, FILTER_VALIDATE_INT) === false ||
        (int) $low_stock_threshold < 0
    ) {
        $errors[] = 'Low-stock threshold must be a non-negative whole number.';
    }

    if (empty($errors)) {

        $check_stmt = $pdo->prepare(
            'SELECT id
             FROM products
             WHERE sku = ?
             AND id != ?
             LIMIT 1'
        );

        $check_stmt->execute([$sku, $id]);

        if ($check_stmt->fetch()) {
            $errors[] = 'Another product with this SKU already exists.';
        }
    }

    if (empty($errors)) {

        $update_stmt = $pdo->prepare(
            'UPDATE products
             SET name = ?,
                 sku = ?,
                 category = ?,
                 price = ?,
                 stock_quantity = ?,
                 low_stock_threshold = ?
             WHERE id = ?'
        );

        $update_stmt->execute([
            $name,
            $sku,
            $category !== '' ? $category : null,
            (float) $price,
            (int) $stock_quantity,
            (int) $low_stock_threshold,
            $id
        ]);

        header('Location: /products/index.php?success=updated');
        exit;
    }
}

?>

<div class="page-header">
    <div>
        <h1>Edit Product</h1>
        <p>Update product information and inventory.</p>
    </div>

    <a class="btn btn-secondary" href="/products/index.php">
        Back to Products
    </a>
</div>

<div class="card">

    <?php if (!empty($errors)): ?>

        <div class="alert alert-error">
            <strong>Please fix the following:</strong>

            <ul>
                <?php foreach ($errors as $error): ?>
                    <li>
                        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    <?php endif; ?>

    <form method="post">

        <div class="form-group">
            <label for="name">Product Name *</label>

            <input
                type="text"
                id="name"
                name="name"
                value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
                maxlength="150"
                required
            >
        </div>

        <div class="form-group">
            <label for="sku">SKU *</label>

            <input
                type="text"
                id="sku"
                name="sku"
                value="<?= htmlspecialchars($sku, ENT_QUOTES, 'UTF-8') ?>"
                maxlength="50"
                required
            >
        </div>

        <div class="form-group">
            <label for="category">Category</label>

            <input
                type="text"
                id="category"
                name="category"
                value="<?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>"
                maxlength="100"
            >
        </div>

        <div class="form-group">
            <label for="price">Price *</label>

            <input
                type="number"
                id="price"
                name="price"
                value="<?= htmlspecialchars((string) $price, ENT_QUOTES, 'UTF-8') ?>"
                min="0"
                step="0.01"
                required
            >
        </div>

        <div class="form-group">
            <label for="stock_quantity">Stock Quantity *</label>

            <input
                type="number"
                id="stock_quantity"
                name="stock_quantity"
                value="<?= htmlspecialchars((string) $stock_quantity, ENT_QUOTES, 'UTF-8') ?>"
                min="0"
                step="1"
                required
            >
        </div>

        <div class="form-group">
            <label for="low_stock_threshold">Low Stock Threshold *</label>

            <input
                type="number"
                id="low_stock_threshold"
                name="low_stock_threshold"
                value="<?= htmlspecialchars((string) $low_stock_threshold, ENT_QUOTES, 'UTF-8') ?>"
                min="0"
                step="1"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Update Product
        </button>

        <a href="/products/index.php" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
