<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentUser = $_SESSION["userData"];

$intDate = convertDateToTimestamp($_POST["birthDate"]);
$userInputData = getUserInputData(
    firstName: $_POST["firstName"],
    lastName: $_POST["lastName"],
    email: $_POST["email"],
    nik: $_POST["nik"],
//    kedua items ini tidak bisa diedit
    birthDate: $intDate,
    sex: $_POST["sex"],
    note: $_POST["note"]
);


$validate = validate(
    nik: $_POST["nik"],
    email: $_POST["email"],
    birthDate: $_POST["birthDate"],
    password: $_POST["newPassword"],
    confirmPassword: $_POST["confirmPassword"],
    currentPassword: $currentUser[PASSWORD],
    id: $currentUser[ID]);

if (count($validate) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["userInputData"]);

    $userData = setPersonData(
        $currentUser,
        firstName: $userInputData["firstName"],
        lastName: $userInputData["lastName"],
        nik: $userInputData["nik"],
        email: $userInputData["email"],
        birthDate: $userInputData["birthDate"],
        sex: $userInputData["sex"],
        role: $currentUser[PERSON_ROLE],
        status: $currentUser[PERSON_STATUS],
        note: $_POST["note"]);
    $currentUser[PASSWORD] = $_POST["newPassword"] == null ? $currentUser[PASSWORD] : $_POST["newPassword"];
    $currentUser[PERSON_INTERNAL_NOTE] = $userInputData["note"] == null ? $currentUser[PERSON_INTERNAL_NOTE] : $userInputData["note"];
    var_dump($userData);
    die();
    savePerson($userData, "persons.php");

} else {
    $_SESSION["userInputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;

    redirect("../myProfile.php", "id=" . $currentUser[ID]);
}






