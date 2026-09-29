<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_login();

require_once __DIR__ . '/../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /products/index.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT id, name
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

$check_stmt = $pdo->prepare(
    'SELECT COUNT(*)
     FROM sale_items
     WHERE product_id = ?'
);

$check_stmt->execute([$id]);

$sale_item_count = (int) $check_stmt->fetchColumn();

if ($sale_item_count > 0) {
    header('Location: /products/index.php?success=delete_blocked');
    exit;
}

$delete_stmt = $pdo->prepare(
    'DELETE FROM products
     WHERE id = ?'
);

$delete_stmt->execute([$id]);

header('Location: /products/index.php?success=deleted');
exit;
