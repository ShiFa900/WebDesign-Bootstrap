<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();
// buat validasi sebelum nama job disimpan,
// job jangan sampai duplicate
$jobs = getJobs();
$newJob = $_POST["name"];
if($newJob === ''){
    $_SESSION['error'] = "Please write a job name";
    redirect("../add-job.php", "");
}
foreach ($jobs as $job){
    if(strcasecmp($job[JOBS_NAME], $newJob) == 0){
        $_SESSION["error"] = "Sorry, this job is already exist!";
        redirect("../add-job.php", "");
    }
}

$job = [
    ID => null,
    JOBS_NAME => htmlspecialchars($newJob),
    JOBS_COUNT => 0,
    JOBS_LAST_UPDATE => time()
];
saveJob($job,"jobs.php");