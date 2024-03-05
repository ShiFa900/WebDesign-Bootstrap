<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentJob = $_SESSION["job"];
$jobInput = $_POST["jobName"];

$jobs = getJobs();
foreach ($jobs as $job){
    if(strcasecmp($job[JOBS_NAME], $jobInput) == 0 && $job[ID] != $currentJob[ID]){
        $_SESSION["info"] = "Sorry, this job is already exist!";
        redirect("../edit-job.php", "?job=" . $currentJob[ID]);
    }
}
$job = [
    ID => $currentJob[ID],
    JOBS_NAME => $jobInput == null ? $currentJob[JOBS_NAME] : htmlspecialchars($jobInput),
    JOBS_COUNT => $currentJob[JOBS_COUNT],
    JOBS_LAST_UPDATE =>  time()
];

saveJob(array: $job, location: "jobs.php");


