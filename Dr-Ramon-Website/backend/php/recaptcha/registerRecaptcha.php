<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] .  '/'))->load();
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/otp_email_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/validate_email.php';

$secretKey = $_ENV['RECAPTCHA_SECRET_KEY'];

if (isset($_POST['g-recaptcha-response'])) {
    $captcha = $_POST['g-recaptcha-response'];
} else {
    $captcha = false;
}
$action = "submit";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secretKey, 'response' => $captcha)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true);

if ($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.7) {
    if (checkDuplicateEmail($_SESSION['email']) == true) {
        $destination =
            'https://www.workifyph.online/register.php?error=invalidEmail';
        header("Location: $destination");
        exit();
    }
    $_SESSION['email'] = filter_var($_POST['register_email'], FILTER_SANITIZE_EMAIL);
    insertOTP();
    $Password = password_hash($_POST['register_password'], PASSWORD_BCRYPT, ['cost' => 15]);
    $_SESSION['password'] = $Password;
    $destination = 'one_time_password.php';
    header("Location: $destination");
    exit();
}