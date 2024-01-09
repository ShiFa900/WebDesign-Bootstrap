<?php
require_once __DIR__ . "/utils.php";

$personWillBeDeleted = getPerson($_GET[ID]);
$persons = getAll();
for ($i = 0; $i < count($persons); $i++) {
    if ($persons[$i][ID] == $personWillBeDeleted[ID]) {
        unset($persons[$i]);
        $persons = array_values($persons);
        saveDataIntoJson($persons, "persons.json");
    }
}

header("Location: ../persons.php");
exit();


