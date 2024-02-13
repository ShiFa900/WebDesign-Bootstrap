<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";

$job = [
    ID => null,
    JOBS_NAME => htmlspecialchars($_POST["name"]),
    JOBS_COUNT => 0
];
saveJob($job,"jobs.php");