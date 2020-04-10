<?php

$client = new Google_Client();
$client->setApplicationName("GSearch");
$client->setAccessType('offline');
$client->setClientId('206666106923-6bi9grq4qahco6f2cne0nnsksv0g24df.apps.googleusercontent.com');
$client->setClientSecret('YvQxXp8Nn1-7YcpWuLm1F7I0');
$client->setRedirectUri('http://localhost:8000/login');
$client->addScope("https://www.googleapis.com/auth/webmasters.readonly");

if (isset($_GET['code'])) {
  /**
   * SI IL Y A UN CODE D'AUTHENTIFICATION
   * ALORS ON DEMANDE LES TOKENS D'ACCÈS ET D'ACTUALISATION À GOOGLE
   * ET ON LES STOCKE DANS LE COOKIE UTILISATEUR 
   */
  $client->authenticate($_GET['code']);
  $tokens = $client->getAccessToken();
  $access_token = $tokens['access_token'];
  $refresh_token = $tokens['refresh_token'];

  setcookie('access_token', $access_token, time() + 60 * 60 * 24 * 10);
  setcookie('refresh_token', $refresh_token, time() + 60 * 60 * 24 * 10);

  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
} else if (!isset($_COOKIE['access_token'])) {
  /**
   * AUCUN TOKEN SAUVE -> IL FAUT REDIRIGER
   * L'UTILISATEUR SUR L'URL $authUrl
   */
  $authUrl = $client->createAuthUrl();
  header('Location: ' . $authUrl);
} else {
  $client->setAccessToken(array('access_token' => $_COOKIE['access_token'], 'refresh_token' => $_COOKIE['refresh_token']));
  if ($client->isAccessTokenExpired()) {
    $client->refreshToken(array('access_token' => $_COOKIE['access_token'], 'refresh_token' => $_COOKIE['refresh_token']));

    $tokens = $client->getAccessToken();
    $access_token = $tokens['access_token'];
    $refresh_token = $tokens['refresh_token'];

    setcookie('access_token', $access_token, time() + 60 * 60 * 24 * 10);
    setcookie('refresh_token', $refresh_token, time() + 60 * 60 * 24 * 10);
  }
  header('Location: http://' . $_SERVER['HTTP_HOST']);
}
