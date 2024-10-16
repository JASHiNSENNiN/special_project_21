<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
(Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/'))->load();
require_once $_SERVER['DOCUMENT_ROOT'] . '/backend/php/validate_email.php';

$google_oauth_client_id = $_ENV['AUTH0_CLIENT_ID'];
$google_oauth_client_secret = $_ENV['AUTH0_CLIENT_SECRET'];
$google_oauth_redirect_uri = $_ENV['AUTH0_REDIRECT_URI'];
$google_oauth_version = 'v3';

$client = new Google_Client();
$client->setClientId($google_oauth_client_id);
$client->setClientSecret($google_oauth_client_secret);
$client->setRedirectUri($google_oauth_redirect_uri);
$client->addScope("https://www.googleapis.com/auth/userinfo.email");
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");

if (isset($_GET['code']) && !empty($_GET['code'])) {

    $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($accessToken);

    if (isset($accessToken['access_token']) && !empty($accessToken['access_token'])) {

        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        if (isset($google_account_info->email)) {

            session_regenerate_id();
            $_SESSION['google_loggedin'] = TRUE;
            $_SESSION['email'] = $google_account_info->email;
            $_SESSION['google_name'] = $google_account_info->name;
            $_SESSION['google_picture'] = $google_account_info->picture;
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {

    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}