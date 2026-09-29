<?php

declare(strict_types=1);

$page_title = 'P002 - Backup';

require_once __DIR__ . '/../includes/header.php';

$backup_message = null;
$backup_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mysql_dump = 'E:\xampp\mysql\bin\mysqldump.exe';

    $database = 'p002_business';
    $username = 'root';
    $password = '';

    $backup_dir = __DIR__ . DIRECTORY_SEPARATOR . 'exports';

    if (!is_dir($backup_dir)) {
        mkdir($backup_dir, 0777, true);
    }

    $filename = 'p002_business_' . date('Y-m-d_H-i-s') . '.sql';
    $filepath = $backup_dir . DIRECTORY_SEPARATOR . $filename;

    $command = '"' . $mysql_dump . '"'
        . ' --host=127.0.0.1'
        . ' --user=' . escapeshellarg($username)
        . ' --password=' . escapeshellarg($password)
        . ' ' . escapeshellarg($database)
        . ' > ' . escapeshellarg($filepath)
        . ' 2>&1';

    exec($command, $output, $return_code);

    if ($return_code === 0 && file_exists($filepath)) {

        $backup_message = $filename;

    } else {

        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $backup_error = 'Backup could not be created. Please make sure MySQL is running.';
    }
}

?>

<div class="page-header">

    <div>
        <h1>Backup</h1>
        <p>Create a downloadable backup of the P002 database.</p>
    </div>

</div>

<div class="card">

    <h2>Database Backup</h2>

    <p>
        Create an SQL backup containing the current P002 business database.
    </p>

    <?php if ($backup_message !== null): ?>

        <div class="alert alert-success">
            Backup created successfully:
            <strong>
                <?= htmlspecialchars(
                    $backup_message,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </strong>
        </div>

        <p>
            <a
                class="btn btn-primary"
                href="/backup/download.php?file=<?= urlencode($backup_message) ?>"
            >
                Download Backup
            </a>
        </p>

    <?php endif; ?>

    <?php if ($backup_error !== null): ?>

        <div class="alert alert-error">
            <?= htmlspecialchars(
                $backup_error,
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </div>

    <?php endif; ?>

    <form method="post">

        <button
            type="submit"
            class="btn btn-primary"
        >
            Create Database Backup
        </button>

    </form>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
