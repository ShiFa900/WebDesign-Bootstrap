<?php
require_once __DIR__ . "/utils.php";
global $PDO;
session_start();

// cari job dari database
$jobs = getJobs();
$job = findFirstFromArray(array: $jobs, key: ID, value: $_GET["job"]);
if ($job == null) {
    $_SESSION["error"] = "Sorry, no data found";
    redirect("../jobs.php", "");
}
try {
    $query = "DELETE FROM `jobs` WHERE id = :id";
    $stmt = $PDO->prepare($query);
    $stmt->execute(array(
        "id" => $job[ID]
    ));

    $_SESSION["deleteSuccess"] = "Successfully delete job of '" . $job[JOBS_NAME] . "' !";
} catch (PDOException $e) {
    die("Query error: " . $e->getMessage());
}
redirect("../jobs.php", "");

