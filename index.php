<?php

session_start();

require_once 'vendor/autoload.php';
require_once 'helper/searchapi.php';

$request = $_SERVER['REQUEST_URI'];

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

  default:
    http_response_code(404);
    require __DIR__ . '/views/404.php';
    break;
}
