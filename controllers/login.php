<?php

global $client;

if (isset($_GET['code'])) {
  /**
   * SI IL Y A UN CODE D'AUTHENTIFICATION
   * ALORS ON DEMANDE LES TOKENS D'ACCÈS ET D'ACTUALISATION À GOOGLE
   * ET ON LES STOCKE DANS LE COOKIE UTILISATEUR 
   */
  authenticateWithCode($_GET['code']);
} else if (!isset($_COOKIE['access_token'])) {
  /**
   * AUCUN TOKEN SAUVE -> IL FAUT REDIRIGER
   * L'UTILISATEUR SUR L'URL $authUrl
   */
  createAuth();
} else {
  $client->setAccessToken(array('access_token' => $_COOKIE['access_token'], 'refresh_token' => $_COOKIE['refresh_token'], 'expires_in' => $_COOKIE['expires_in']));
  if ($client->isAccessTokenExpired())
    refreshToken(array('access_token' => $_COOKIE['access_token'], 'refresh_token' => $_COOKIE['refresh_token'], 'expires_in' => $_COOKIE['expires_in']));

  header('Location: http://' . $_SERVER['HTTP_HOST']);
}
