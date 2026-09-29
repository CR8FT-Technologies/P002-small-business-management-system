<?php

declare(strict_types=1);

$page_title = 'P002 - Customers';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config/database.php';

$stmt = $pdo->query(
    'SELECT id, name, phone, email, address
     FROM customers
     ORDER BY id DESC'
);

$customers = $stmt->fetchAll();

$success = $_GET['success'] ?? '';

?>

<div class="page-header">
    <div>
        <h1>Customers</h1>
        <p>Manage customer information.</p>
    </div>

    <a class="btn btn-primary" href="/customers/create.php">
        Add Customer
    </a>
</div>

<?php if ($success === 'created'): ?>

    <div class="alert alert-success">
        Customer created successfully.
    </div>

<?php elseif ($success === 'updated'): ?>

    <div class="alert alert-success">
        Customer updated successfully.
    </div>

<?php elseif ($success === 'deleted'): ?>

    <div class="alert alert-success">
        Customer deleted successfully.
    </div>

<?php endif; ?>

<div class="card">

    <?php if (count($customers) === 0): ?>

        <p>No customers found.</p>

    <?php else: ?>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($customers as $customer): ?>

                    <tr>

                        <td><?= (int) $customer['id'] ?></td>

                        <td>
                            <?= htmlspecialchars(
                                $customer['name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $customer['phone'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $customer['email'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $customer['address'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    class="btn btn-secondary"
                                    href="/customers/edit.php?id=<?= (int) $customer['id'] ?>"
                                >
                                    Edit
                                </a>

                                <a
                                    class="btn btn-danger"
                                    href="/customers/delete.php?id=<?= (int) $customer['id'] ?>"
                                    onclick="return confirm('Delete this customer?');"
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
