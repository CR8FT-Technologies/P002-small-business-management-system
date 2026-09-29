<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

require_login();

$page_title = $page_title ?? 'P002';

$current_path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

function nav_active(string $path): string
{
    global $current_path;

    return $current_path === $path ? ' active' : '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="app-layout">

    <aside class="sidebar">

        <h2>P002 Business System</h2>

        <nav>

            <a
                class="<?= nav_active('/dashboard/index.php') ?>"
                href="/dashboard/index.php"
            >
                Dashboard
            </a>

            <a
                class="<?= nav_active('/products/index.php') ?>"
                href="/products/index.php"
            >
                Products
            </a>

            <a
                class="<?= nav_active('/customers/index.php') ?>"
                href="/customers/index.php"
            >
                Customers
            </a>

            <a
                class="<?= nav_active('/sales/index.php') ?>"
                href="/sales/index.php"
            >
                Sales
            </a>

            <a
                class="<?= nav_active('/invoices/index.php') ?>"
                href="/invoices/index.php"
            >
                Invoices
            </a>

            <a
                class="<?= nav_active('/reports/index.php') ?>"
                href="/reports/index.php"
            >
                Reports
            </a>

            <a
                class="<?= nav_active('/backup/index.php') ?>"
                href="/backup/index.php"
            >
                Backup
            </a>

            <a href="/auth/logout.php">
                Logout
            </a>

        </nav>

    </aside>

    <main class="main-content">
