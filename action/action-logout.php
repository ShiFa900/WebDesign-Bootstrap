<?php
require_once __DIR__ . "/utils.php";
session_start();

// user logout
if(isset($_SESSION["userEmail"])) {
    $persons = getAll();
    for($i = 0; $i < count($persons); $i++) {
        if ($persons[$i][PERSON_EMAIL] == $_SESSION["userEmail"]) {
            // set user key last logged in with current time, it will show on dashboard when user login again
            $persons[$i][PERSON_LAST_LOGGED_IN] = time();
            saveDataIntoJson($persons, "persons.json");

        }
    }
    // unset all current session
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}