<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: /auth/login.php');
        exit;
    }
}

function current_user_id(): ?int
{
    return isset($_SESSION['user_id'])
        ? (int) $_SESSION['user_id']
        : null;
}

function current_username(): ?string
{
    return $_SESSION['username'] ?? null;
}

function current_user_role(): ?string
{
    return $_SESSION['role'] ?? null;
}
