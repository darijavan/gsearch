<?php
require_once __DIR__ . './../vendor/autoload.php';

/**
 * Retourne la liste des sites associées au token d'accès donné
 * @param string $access_token Le token d'accès pour les requêtes
 * @return mixed
 */
function getSites($access_token)
{
  $url = 'https://www.googleapis.com/webmasters/v3/sites';

  $headers = array(
    "Authorization: Bearer $access_token",
    "Accept: application/json;"
  );

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $result = curl_exec($ch);
  $obj = json_decode($result);

  return $obj;
}
