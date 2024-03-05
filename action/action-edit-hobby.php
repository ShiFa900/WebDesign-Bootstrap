<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();
$currentHobby = $_SESSION["currentHobby"];
$newHobby = $_POST["name"];
$personHobby = getHobby(personId: $_SESSION["personId"]); // ini harusnya isinya adalah array hobby dari si person
foreach ($personHobby as $hobby){
    if(strcasecmp($hobby[HOBBIES_NAME], $newHobby) == 0 && $hobby[ID] != $currentHobby[ID]){
        $_SESSION["info"] = "Sorry, this hobby is already exist!";
        redirect("../edit-hobby.php", "?hobby=" . $currentHobby[ID]);
    }
}
$userInput = [
    "hobbyName" => $newHobby
];

$hobby = [
    ID => $currentHobby[ID],
    HOBBIES_NAME => $userInput["hobbyName"] == null ? $currentHobby[HOBBIES_NAME] : htmlspecialchars($userInput["hobbyName"]),
    HOBBIES_PERSON_ID => $currentHobby[HOBBIES_PERSON_ID],
    HOBBIES_LAST_UPDATE => time()
];
saveHobby(array: $hobby, location: "hobbies.php");