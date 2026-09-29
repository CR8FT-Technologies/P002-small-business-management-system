<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

require_login();

$page_title = $page_title ?? 'P002';
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
            <a href="/dashboard/index.php">Dashboard</a>
            <a href="/products/index.php">Products</a>
            <a href="/customers/index.php">Customers</a>
            <a href="/sales/index.php">Sales</a>
            <a href="/invoices/index.php">Invoices</a>
            <a href="/reports/index.php">Reports</a>
            <a href="/backup/index.php">Backup</a>
            <a href="/auth/logout.php">Logout</a>
        </nav>
    </aside>

    <main class="main-content">
