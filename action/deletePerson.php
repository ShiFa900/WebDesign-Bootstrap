<?php
require_once __DIR__ . "/utils.php";


$id = $_GET[ID];
$deletePerson = delete($id);
redirect("/../person.php", "error=0");

function delete(int $id)
{
    $personWillBeDeleted = getPerson($id);
    $persons = getAll();
    foreach ($persons as $person) {
        if ($person[ID] == $personWillBeDeleted[ID]) {
            unset($person[ID]);
            return array_values($person);
        }
    }
    return [];
}

