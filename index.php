<?php

session_start();

require_once 'vendor/autoload.php';
require_once 'helper/auth.php';
require_once 'helper/searchapi.php';

$request = $_SERVER['REQUEST_URI'];

$client = new Google_Client();
$client->setAuthConfig('client_secret.json');
$client->addScope("https://www.googleapis.com/auth/webmasters.readonly");
$client->setAccessType('offline');
$client->setIncludeGrantedScopes(true);

if (isset($_SESSION['message'])) {
  require __DIR__ . '/views/login.php';
  unset($_SESSION['message']);
  removeCookies();
  die();
} else if (isset($_COOKIE['access_token']) && isset($_COOKIE['refresh_token']) && isset($_COOKIE['expires_in'])) {
  $token = array('access_token' => $_COOKIE['access_token'], 'refresh_token' => $_COOKIE['refresh_token'], 'expires_in' => $_COOKIE['expires_in'], 'created' => $_COOKIE['created']);
  $client->setAccessToken($token);
  if ($client->isAccessTokenExpired()) {
    refreshToken($token['refresh_token']);
  }
}

switch ($request) {
  case '/':
    if (isset($_COOKIE['access_token']))
      require __DIR__ . '/views/index.php';
    else
      require __DIR__ . '/views/login.php';
    break;

  case '/about':
    require __DIR__ . '/views/about.php';
    break;

  case '/logout':
    require __DIR__ . '/controllers/logout.php';
    break;

  case (preg_match('/\/login.*/', $request) ? true : false):
    require __DIR__ . '/controllers/login.php';
    break;

  case '/getCSV':
    require __DIR__ . '/controllers/getCSV.php';
    break;

  default:
    http_response_code(404);
    require __DIR__ . '/views/404.php';
    break;
}
