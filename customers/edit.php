<?php

declare(strict_types=1);

$page_title = 'P002 - Edit Customer';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: /customers/index.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT id, name, phone, email, address
     FROM customers
     WHERE id = ?
     LIMIT 1'
);

$stmt->execute([$id]);
$customer = $stmt->fetch();

if (!$customer) {
    header('Location: /customers/index.php');
    exit;
}

$error = '';

$name = $customer['name'];
$phone = $customer['phone'] ?? '';
$email = $customer['email'] ?? '';
$address = $customer['address'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if ($name === '') {

        $error = 'Customer name is required.';

    } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = 'Please enter a valid email address.';

    } else {

        $stmt = $pdo->prepare(
            'UPDATE customers
             SET name = ?, phone = ?, email = ?, address = ?
             WHERE id = ?'
        );

        $stmt->execute([
            $name,
            $phone !== '' ? $phone : null,
            $email !== '' ? $email : null,
            $address !== '' ? $address : null,
            $id
        ]);

        header('Location: /customers/index.php?success=updated');
        exit;
    }
}

?>

<div class="page-header">

    <div>
        <h1>Edit Customer</h1>
        <p>Update customer information.</p>
    </div>

    <a class="btn btn-secondary" href="/customers/index.php">
        Back to Customers
    </a>

</div>

<?php if ($error !== ''): ?>

    <div class="alert alert-error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>

<?php endif; ?>

<div class="card">

    <form method="post">

        <div class="form-group">

            <label for="name">Name</label>

            <input
                type="text"
                id="name"
                name="name"
                value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
                required
            >

        </div>

        <div class="form-group">

            <label for="phone">Phone</label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="<?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?>"
            >

        </div>

        <div class="form-group">

            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
            >

        </div>

        <div class="form-group">

            <label for="address">Address</label>

            <textarea
                id="address"
                name="address"
                rows="3"
            ><?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8') ?></textarea>

        </div>

        <button type="submit" class="btn btn-primary">
            Update Customer
        </button>

        <a class="btn btn-secondary" href="/customers/index.php">
            Cancel
        </a>

    </form>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
