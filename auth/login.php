<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

if (is_logged_in()) {
    header('Location: /dashboard/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter your username and password.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT id, name, username, password_hash, role
             FROM users
             WHERE username = ?
             LIMIT 1'
        );

        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: /dashboard/index.php');
            exit;
        }

        $error = 'Invalid username or password.';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P002 - Login</title>

    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body class="login-page">

<div class="login-container">

    <div class="login-card">

        <div class="login-brand">
            <h1>P002</h1>
            <p>Small Business Management System</p>
        </div>

        <div class="login-heading">
            <h2>Welcome Back</h2>
            <p>Sign in to continue to your dashboard.</p>
        </div>

        <?php if ($error !== ''): ?>
            <div class="login-error">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="post" class="login-form">

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    autocomplete="username"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn btn-primary login-button">
                Login
            </button>

        </form>

        <div class="login-footer">
            CR8FT Technologies
        </div>

    </div>

</div>

</body>
</html>
