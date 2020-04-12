<?php

function jsonToCSV($jfilename, $cfilename)
{
  if (($json = file_get_contents($jfilename)) === false)
    die('Error reading json file...');
  $data = json_decode($json, true)['rows'];

  if (file_exists($cfilename))
    unlink($cfilename);

  $fp = fopen($cfilename, 'w');
  $header = false;
  foreach ($data as $row) {
    if (empty($header)) {
      $header = array_keys($row);
      fputcsv($fp, $header, ';');
      $header = array_flip($header);
    }
    $row['keys'] = $row['keys'][0];
    fputcsv($fp, array_merge($header, $row), ';');
  }
  fclose($fp);
  return;
}
