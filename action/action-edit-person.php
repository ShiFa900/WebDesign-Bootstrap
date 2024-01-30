<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentUser = $_SESSION["personData"];
$intDate = convertDateToTimestamp($_POST["birthDate"]);

// get user input data, data still there if page is reload when showing error input data
$userInputData = getUserInputData(
    firstName: $_POST["firstName"],
    lastName: $_POST["lastName"],
    email: $_POST["email"],
    nik: $_POST["nik"],
    role: $_POST["role"],
    status: $_POST["status"],
    birthDate: $intDate,
    sex: $_POST["sex"],
    note: $_POST["note"]);

// do validate person input data
$validate = validate(
    nik: $_POST["nik"],
    email: $_POST["email"],
    birthDate: $_POST["birthDate"],
    password: $_POST["newPassword"],
    confirmPassword: $_POST["confirmPassword"],
    id: $currentUser[ID]);


if (count($validate) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["userInputData"]);


    // set person data before saving
    $currentUser = setPersonData(
        person: $currentUser,
        firstName: $userInputData["firstName"],
        lastName: $userInputData["lastName"],
        nik: $userInputData["nik"],
        email: $userInputData["email"],
        birthDate: $intDate,
        sex: transformSexFromInput($userInputData["sex"]),
        role: transformRoleFromInput($userInputData["role"]),
        status: $userInputData["status"],
        note: $userInputData["note"] == "" ? null : $userInputData["note"]);
    $currentUser[PASSWORD] = $_POST["newPassword"] == null ? $currentUser[PASSWORD] : $_POST["newPassword"];

    savePerson($currentUser, "view-person.php");


} else {
    $_SESSION["userInputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    // redirect to edit person page if error in input data
    redirect("../edit-person.php", "person=" . $currentUser[ID]);
}




