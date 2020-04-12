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
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
  $obj = json_decode($result);

  return $obj;
}

/**
 * @param string $siteUrl
 * @param string $access_token
 */
function getSiteAnalytics($siteUrl, $access_token)
{
  $url = "https://www.googleapis.com/webmasters/v3/sites/" . urlencode($siteUrl) . "/searchAnalytics/query";

  $headers = array(
    "Authorization: Bearer $access_token",
    "Accept: application/json",
    "Content-type: application/json"
  );

  $data = array(
    "dimensions" => array(
      "query"
    ),
    "startDate" => "2020-01-01",
    "endDate" => date("Y-m-d"),
    "startRow" => 0,
    "rowLimit" => 25000
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

  $result = curl_exec($ch);
  $obj = json_decode($result);

  return $obj;
}
