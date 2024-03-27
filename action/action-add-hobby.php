<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();
// check jika di depan/belakang text ada space, atau hanya space kosong
$newHobby = $_POST["name"];
$newHobby = trim($newHobby);
if (ctype_space($newHobby) || $newHobby === ''){
//if (ctype_space($newHobby) ) {
    $_SESSION['error'] = "Please write a hobby name!";
    redirect("../add-hobby.php", "person=" . $_SESSION["personId"]);
}
$hobby = findFirstFromDb(tableName: 'hobbies', key: strtoupper('hobbies_name'), value: strtoupper($newHobby));
if (is_array($hobby)) {
    $_SESSION["error"] = "Sorry, this hobby is already exist!";
    redirect("../add-hobby.php", "person=" . $_SESSION["personId"]);
}

$hobby = [
    ID => null,
    HOBBIES_NAME => htmlspecialchars($newHobby),
    HOBBIES_PERSON_ID => $_SESSION["personId"],
    HOBBIES_LAST_UPDATE => time()
];
saveHobby($hobby, "hobbies.php");