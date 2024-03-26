<?php
require_once __DIR__ . "/utils.php";
session_start();

// get person data to be deleted
global $PDO;
$personWillBeDeleted = findFirstFromDb(tableName: 'persons', key: ID, value: $_GET['person']);
if ($personWillBeDeleted == null) {
    $_SESSION["error"] = "Sorry, no person found";
    redirect("../persons.php", "");
}
try {
    // hapus hobby terlebih dahulu (jika person yang akan di hapus memiliki hobi)
    $queryHobby = "DELETE FROM `hobbies` WHERE person_id = :person_id";
    $stmt = $PDO->prepare($queryHobby);
    $stmt->execute(array(
        "person_id" => $personWillBeDeleted[ID]
    ));

    // cari pekerjaan dari si person yang akan dihapus
    $queryPersonJob = "SELECT * FROM `person_job` WHERE person_id = :person_id";
    $stmt = $PDO->prepare($queryPersonJob);
    $stmt->execute(array(
        "person_id" => $personWillBeDeleted[ID]
    ));
    $personJob = $stmt->fetch(PDO::FETCH_ASSOC); // harusnya berisi id, person_id dan job_id

    $queryDeletePersonJob = "DELETE FROM `person_job` WHERE person_id = :person_id AND job_id = :job_id";
    $stmt = $PDO->prepare($queryDeletePersonJob);
    $stmt->execute(array(
        "person_id" => $personJob[PERSON_JOBS_PERSON_ID],
        "job_id" => $personJob[PERSON_JOBS_JOB_ID]
    ));

    $job = "SELECT * FROM `jobs` WHERE id = :id";
    $stmt = $PDO->prepare($job);
    $stmt->execute(array(
        "id" => $personJob[PERSON_JOBS_JOB_ID]
    ));
    $theJob = $stmt->fetch(PDO::FETCH_ASSOC);

    $queryJob = "UPDATE `jobs` SET count = :count, last_update = :last_update WHERE id = :id";
    $stmt = $PDO->prepare($queryJob);
    $stmt->execute(array(
        "count" => $theJob[JOBS_COUNT] - 1,
        "id" => $theJob[ID],
        "last_update" => date("Y-m-d H:i:s", time())

    ));
    $query = "DELETE FROM `persons` WHERE id = :id";
    $stmt = $PDO->prepare($query);
    $stmt->execute(array(
        "id" => $personWillBeDeleted[ID]
    ));

    $_SESSION["deleteSuccess"] = "Successfully delete person data of '" . $personWillBeDeleted[PERSON_FIRST_NAME] . "' !";
} catch (PDOException $e) {
    die("Query error: " . $e->getMessage());
}

redirect("../persons.php", "page=1");



