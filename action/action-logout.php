<?php
require_once __DIR__ . "/utils.php";
session_start();
// set default timezone
date_default_timezone_set('Asia/Singapore');

// user logout
if (isset($_SESSION["userEmail"])) {
    global $PDO;
    $persons = getAll();
    $logoutPerson = findFirstFromArray(array: $persons, key: PERSON_EMAIL, value: $_SESSION["userEmail"]);

    try {
        $query = "UPDATE `persons` SET lastLoggedIn = :lastLoggedIn WHERE id = :id";
        $stmt = $PDO->prepare($query);
        $stmt->execute(array(
            "id" => $logoutPerson[ID],
            "lastLoggedIn" => date('Y-m-d H:i:s', time())
        ));

        $PDO = null;
        $stmt = null;

    } catch (PDOException $e) {
        die("Query error: " . $e->getMessage());
    }
    // unset all current session
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}