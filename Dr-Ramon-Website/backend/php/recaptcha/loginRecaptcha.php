<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] .  '/'))->load();
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/validate_email.php';

if (checkDuplicateEmail($_SESSION['email']) == true) {
    $destination =
        'https://www.workifyph.online/register.php?error=invalidEmail';
    header("Location: $destination");
    exit();
}
$_SESSION['email'] = filter_var($_POST['register_email'], FILTER_SANITIZE_EMAIL);
$Password = password_hash($_POST['register_password'], PASSWORD_BCRYPT, ['cost' => 15]);
$_SESSION['password'] = $Password;
$destination = 'one_time_password.php';
header("Location: $destination");
exit();
