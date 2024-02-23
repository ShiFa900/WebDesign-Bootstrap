<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentJob = $_SESSION["job"];

$jobInput = $_POST["jobName"];
$job = [
    ID => $currentJob[ID],
    JOBS_NAME => $jobInput == null ? $currentJob[JOBS_NAME] : htmlspecialchars($jobInput),
    JOBS_COUNT => $currentJob[JOBS_COUNT],
    JOBS_LAST_UPDATE => date("Y-m-d H:i:s", time())
];

saveJob(array: $job, location: "jobs.php");


