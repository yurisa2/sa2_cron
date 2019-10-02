<?php

$file = file_get_contents(__DIR__.'/files/cron.json');

$labels = json_decode($file)["0"];

$labels_full = array();

foreach ($labels as $key => $value) {

$labels_full[] = $key;

}

$file_data = json_decode($file);

var_dump($file_data);

 ?>
