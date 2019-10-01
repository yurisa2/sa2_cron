<?php
date_default_timezone_set('America/Sao_Paulo');
require_once __DIR__.'/include/vendor/autoload.php';
file_put_contents("cron.json",json_encode($array));

use GO\Scheduler;

$scheduler = new Scheduler();
$mc = JMathai\PhpMultiCurl\MultiCurl::getInstance();

echo "<pre>";

$file = file_get_contents(__DIR__.'/include/files/cron.json');
$file = json_decode($file);

$last_run = json_decode(file_get_contents(__DIR__."/include/files/last_run.json"));

// var_dump($last_run); //DEBUG

if($last_run > (time() - 60)) exit("Menos de um minuto " . (time() - $last_run));
else {
  file_put_contents(__DIR__."/include/files/last_run.json", json_encode(time()));
  echo "Reset Timer";
}


foreach ($file as $key => $value) {
  if($value->cron_time == "daily") {
    $scheduler->call(function () {$mcr[] = $mc->addUrl($value->url);})->daily();
  }

  if($value->cron_time == "hourly") {
    $scheduler->call(function () {$mcr[] = $mc->addUrl($value->url);})->hourly();
  }

  if($value->cron_time == "every_minute") {
    $scheduler->call(function () {$mcr[] = $mc->addUrl($value->url);})->everyMinute();
  }
}

var_dump($file);
var_dump($mc);
var_dump($mcr);
