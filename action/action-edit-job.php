<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentJob = $_SESSION["currentJob"];
$jobInput = $_POST["jobName"];
if (ctype_space($jobInput) || $jobInput === '') {
    $_SESSION['error'] = "Please write a job name!";
    redirect("../edit-job.php", "job=" . $currentJob[ID]);
}

$job = findFirstFromDb(tableName: 'jobs', key: strtoupper('jobs_name'), value: strtoupper($jobInput), id: $currentJob[ID]);
if (is_array($job)) {
    $_SESSION["error"] = "Sorry, job '" . $jobInput . "' is already exist!";
    redirect("../edit-job.php", "job=" . $currentJob[ID]);
}
$newJob = trim($jobInput);
$job = [
    ID => $currentJob[ID],
    JOBS_NAME => htmlspecialchars($newJob),
    JOBS_COUNT => $currentJob[JOBS_COUNT],
    JOBS_LAST_UPDATE => time()
];

saveJob(array: $job, location: "jobs.php");


