<?php
 date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__.'/include/vendor/autoload.php';

use GO\Scheduler;

// Create a new scheduler
$scheduler = new Scheduler();

// ... configure the scheduled jobs (see below) ...

$scheduler->call(function () {
    file_put_contents(time().".json",json_encode("oi gente"));
    return true;
})->everyMinute();


// Let the scheduler execute jobs which are due.
$scheduler->run();


echo "<pre>";
var_dump($scheduler);
