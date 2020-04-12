<?php

function init()
{
  global $client;

  if (isset($_COOKIE['access_token']) && isset($_COOKIE['refresh_token'])) {
    $client->setAccessToken(array('access_token' => $_COOKIE['access_token'], 'refresh_token' => $_COOKIE['refresh_token']));
    if ($client->isAccessTokenExpired()) {
      refreshToken(array('access_token' => $_COOKIE['access_token'], 'refresh_token' => $_COOKIE['refresh_token']));
      header('Location: ' . $_SERVER['HTTP_SERVER']);
    }
  }
}

/**
 * Recueillir les jetons d'accès et d'actualisation pour le code d'authentification donné
 * @param string $code
 */
function authenticateWithCode($code)
{
  global $client;

  $client->authenticate($code);
  $tokens = $client->getAccessToken();
  $access_token = $tokens['access_token'];
  $refresh_token = $tokens['refresh_token'];

  setcookie('access_token', $access_token, time() + 60 * 60 * 24 * 10);
  setcookie('refresh_token', $refresh_token, time() + 60 * 60 * 24 * 10);
  setcookie('expires_in', $tokens['expires_in'], time() + 60 * 60 * 24 * 10);

  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

/**
 * Redirige vers une connexion OAuth avec Google
 */
function createAuth()
{
  global $client;
  $authUrl = $client->createAuthUrl();
  header('Location: ' . $authUrl);
}

/**
 * Actualiser les jetons
 */
function refreshToken($token)
{
  global $client;

  $client->refreshToken($token);

  $tokens = $client->getAccessToken();
  $access_token = $tokens['access_token'];
  $refresh_token = $tokens['refresh_token'];

  setcookie('access_token', $access_token, time() + 60 * 60 * 24 * 10);
  setcookie('refresh_token', $refresh_token, time() + 60 * 60 * 24 * 10);
  setcookie('expires_in', $tokens['expires_in'], time() + 60 * 60 * 24 * 10);
}
