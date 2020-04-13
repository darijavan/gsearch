<?php
require_once __DIR__ . './../helper/json_to_csv.php';

if (!empty($_POST)) {
  if (empty($_POST['list'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST']);
    exit();
  }
  header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);

  $toBeExported = explode(';', $_POST['list']);

  $zip_file = __DIR__ . "/../cache/" . $_COOKIE['PHPSESSID'] . ".zip";
  $zip = new ZipArchive();
  if ($zip->open($zip_file, ZipArchive::CREATE) !== TRUE) {
    exit("Unable to create zip file");
  }

  foreach ($toBeExported as $site) {
    $obj = getSiteAnalytics(urldecode($site), $_COOKIE['access_token']);
    $siteDomain = preg_replace('/^(http[s]?:\/\/)|(sc-domain:)/i', '', preg_replace('/\/$/i', '', urldecode($site)));
    $jsonPath = __DIR__ . "/../cache/$siteDomain.json";
    $csvPath = __DIR__ . "/../cache/$siteDomain.csv";

    if (file_exists($jsonPath))
      unlink($jsonPath);

    $jfile = fopen($jsonPath, 'w');
    fwrite($jfile, json_encode($obj));
    fclose($jfile);

    jsonToCSV($jsonPath, $csvPath);
    unlink($jsonPath);

    if (count($toBeExported) === 1) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="' . basename($csvPath) . '"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($csvPath));
      flush(); // Flush system output buffer
      readfile($csvPath);
      unlink($csvPath);
      exit();
    } else {
      $zip->addFile($csvPath, $siteDomain);
      $download_file = file_get_contents($csvPath);
      $zip->addFromString(basename($csvPath), $download_file);
    }
  }

  $zip->close();

  header('Content-type: application/zip');
  header('Content-Disposition: attachment; filename="' . basename($zip_file) . '"');
  header("Content-length: " . filesize($zip_file));
  header("Pragma: no-cache");
  header("Expires: 0");
  ob_clean();
  flush();
  readfile($zip_file);
  unlink($zip_file);
  exit();
}
