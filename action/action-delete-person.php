<?php
require_once __DIR__ . "/utils.php";
session_start();

// get person data to be deleted
$persons = getAll();
$personWillBeDeleted = getPerson($persons, $_SESSION["personId"]);
for ($i = 0; $i < count($persons); $i++) {
    if ($persons[$i][ID] == $personWillBeDeleted[ID]) {
        unset($persons[$i]);
        $persons = array_values($persons);
        // save array persons into json
        saveDataIntoJson($persons, "persons.json");
        $_SESSION["deleteSuccess"] = "Successfully delete person data!";

    }
}

redirect("../persons.php", "page=1");



