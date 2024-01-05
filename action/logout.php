<?php
require_once __DIR__ . "/utils.php";
session_start();

if(isset($_SESSION["userEmail"])) {
    $persons = getAll();
    for($i = 0; $i < count($persons); $i++) {
        if ($persons[$i][PERSON_EMAIL] == $_SESSION["userEmail"]) {
            $persons[$i][PERSON_LAST_LOGGED_IN] = time();
            saveDataIntoJson($persons, "persons.json");

        }
    }
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}