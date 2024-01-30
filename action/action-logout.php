<?php
require_once __DIR__ . "/utils.php";
session_start();

// user logout
if(isset($_SESSION["userEmail"])) {
    $persons = getAll();
    $person = getPerson($persons, $_SESSION["userEmail"]);

    $person[PERSON_LAST_LOGGED_IN] = time();
//    try {
//        $query = "ALTER TABLE"
//    }
    // unset all current session
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}