<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

require_login();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: /customers/index.php');
    exit;
}

$stmt = $pdo->prepare(
    'DELETE FROM customers
     WHERE id = ?'
);

$stmt->execute([$id]);

header('Location: /customers/index.php?success=deleted');
exit;
