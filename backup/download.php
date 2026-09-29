<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/auth.php';

require_login();

$filename = $_GET['file'] ?? '';

if ($filename === '') {
    http_response_code(400);
    exit('Invalid backup file.');
}

/*
 * Only allow generated P002 SQL backup filenames.
 * This prevents directory traversal and arbitrary file downloads.
 */
if (!preg_match('/^p002_business_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}\.sql$/', $filename)) {
    http_response_code(400);
    exit('Invalid backup file.');
}

$backup_dir = __DIR__ . DIRECTORY_SEPARATOR . 'exports';
$filepath = $backup_dir . DIRECTORY_SEPARATOR . $filename;

if (!is_file($filepath)) {
    http_response_code(404);
    exit('Backup file not found.');
}

header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filepath));
header('Cache-Control: no-store');

readfile($filepath);
exit;
