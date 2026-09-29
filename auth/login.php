<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/database.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
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
</head>
<body>

    <h1>P002 Small Business Management System</h1>
    <h2>Login</h2>

    <?php if ($error !== ''): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="post">
        <div>
            <label for="username">Username</label><br>
            <input
                type="text"
                id="username"
                name="username"
                required
                autocomplete="username"
            >
        </div>

        <br>

        <div>
            <label for="password">Password</label><br>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            >
        </div>

        <br>

        <button type="submit">Login</button>
    </form>

</body>
</html>
