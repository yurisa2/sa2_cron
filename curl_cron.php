<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

date_default_timezone_set('America/Sao_Paulo');
require_once __DIR__.'/include/vendor/autoload.php';

$mc = JMathai\PhpMultiCurl\MultiCurl::getInstance();

echo "<pre>";

$file = file_get_contents(__DIR__.'/include/files/cron.json');
$file = json_decode($file);

$last_run = json_decode(file_get_contents(__DIR__."/include/files/last_run.json"));

// var_dump($last_run); //DEBUG

if($last_run > (time() - 60)) exit("Menos de um minuto " . (time() - $last_run));
else {
  file_put_contents(__DIR__."/include/files/last_run.json", json_encode(time()));
  echo "Reset Timer <br> Running cURLs: ";
}

$mcr = array();
$i = 0;

foreach ($file as $key => $value) {
  if($value->cron_time == "daily" && date("d",$last_run) != date("d",time()) ) {
    // echo "inside daily <BR>"; //DEBUG
    $mcr["daily"] = $mc->addUrl($value->url);
    $i++;
  }

  if($value->cron_time == "hourly" && date("h",$last_run) != date("h",time()) ) {
    // echo "inside hour <BR>"; //DEBUG
    $mcr["hourly"] = $mc->addUrl($value->url);
    $i++;
  }

  if($value->cron_time == "every_minute") {
    // echo "inside minute"; //DEBUG
    $mcr["every_minute"] = $mc->addUrl($value->url);
    $i++;
  }
}

echo $i . " cURLs run.";

?>
