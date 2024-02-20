<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();
// buat validasi sebelum nama job disimpan,
// job jangan sampai duplicate
$jobs = getJobs();
$newJob = $_POST["name"];
foreach ($jobs as $job){
    if(strcasecmp($job[JOBS_NAME], $newJob) == 0){
        $_SESSION["info"] = "Sorry, this job is already exist in database";
        redirect("../add-job.php", "");
    }
}

$job = [
    ID => null,
    JOBS_NAME => htmlspecialchars($newJob),
    JOBS_COUNT => 0
];
saveJob($job,"jobs.php");