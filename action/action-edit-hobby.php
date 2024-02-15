<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();
$currentHobby = $_SESSION["currentHobby"];

$userInput = [
    "hobbyName" => $_POST["hobbyName"]
];

$hobby = [
    ID => $currentHobby[ID],
    HOBBIES_NAME => $userInput["hobbyName"] == null ? $currentHobby[HOBBIES_NAME] : htmlspecialchars($userInput["hobbyName"]),
    HOBBIES_PERSON_ID => $currentHobby[HOBBIES_PERSON_ID]
];
saveHobby(array: $hobby, location: "hobbies.php");