<?php
// utils.php — helpers simples

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($str)
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

function render_header()
{
    require __DIR__ . '/Vue/header.php';
}

function render_footer()
{
    require __DIR__ . '/Vue/footer.php';
}
