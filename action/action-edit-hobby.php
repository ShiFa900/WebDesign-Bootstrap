<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();
$currentHobby = $_SESSION["currentHobby"];
$newHobby = $_POST["name"];
if (ctype_space($newHobby) || $newHobby === '') {
    $_SESSION['error'] = "Please write a hobby name!";
    redirect("../edit-hobby.php", "hobby=" . $currentHobby[ID]);
}
$hobby = findFirstFromDb(tableName: 'hobbies', key: strtoupper('hobbies_name'), value: strtoupper($newHobby), id: $currentHobby[ID]);
if (is_array($hobby)) {
    $_SESSION["error"] = "Sorry, this " . $newHobby . "' is already exist!";
    redirect("../edit-hobby.php", "hobby=" . $currentHobby[ID]);
}

$newHobby = trim($newHobby);
$hobby = [
    ID => $currentHobby[ID],
    HOBBIES_NAME => ctype_space($newHobby) ? $currentHobby[HOBBIES_NAME] : htmlspecialchars($newHobby),
    HOBBIES_PERSON_ID => $currentHobby[HOBBIES_PERSON_ID],
    HOBBIES_LAST_UPDATE => time()
];
saveHobby(array: $hobby, location: "hobbies.php");