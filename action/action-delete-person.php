<?php
require_once __DIR__ . "/utils.php";
session_start();

// get person data to be deleted
$persons = getAll();
global $PDO;
$personWillBeDeleted = findFirstFromArray(array: $persons,key: ID,value: $_SESSION["personId"]);
if ($personWillBeDeleted == null){
    $_SESSION["personNotFound"] = "Sorry, no person found";
    redirect("../persons.php", "");
}
try {
    $query = "DELETE FROM `persons` WHERE id = :id";
    $stmt = $PDO->prepare($query);
    $stmt->execute(array(
        "id" => $personWillBeDeleted[ID]
    ));

    $queryHobby = "DELETE FROM `hobbies` WHERE person_id = :person_id";
    $stmt = $PDO->prepare($queryHobby);
    $stmt->execute(array(
        "person_id" => $personWillBeDeleted[ID]
    ));

    $_SESSION["deleteSuccess"] = "Successfully delete person data of '" . $personWillBeDeleted[PERSON_FIRST_NAME] . "' !";
} catch (PDOException $e){
    die("Query error: " . $e->getMessage());
}

redirect("../persons.php", "page=1");



