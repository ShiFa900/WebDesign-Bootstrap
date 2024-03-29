<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentUser = $_SESSION["personData"];
$currentJob = getPersonJob($currentUser[ID]);
$intDate = convertDateToTimestamp($_POST["birthDate"]);

// get user input data, data still there if page is reload when showing error input data
$userInputData = getUserInputData(
    firstName: $_POST["firstName"],
    lastName: $_POST["lastName"],
    email: $_POST["email"],
    nik: $_POST["nik"],
    role: $_POST["role"],
    status: $_POST["status"] ?? "false",
    birthDate: $intDate,
    sex: $_POST["sex"],
    note: $_POST["note"]);

// do validate person input data
$validate = validate(
    nik: $userInputData["nik"],
    email: $userInputData["email"],
    birthDate: $userInputData["birthDate"],
    password: $userInputData["newPassword"],
    confirmPassword: $userInputData["confirmPassword"],
    id: $currentUser[ID]);


if (count($validate) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["userInputData"]);

    // set person data before saving
    $person = setPersonData(
        person: $currentUser,
        firstName: ucwords($userInputData["firstName"]),
        nik: $userInputData["nik"],
        email: $userInputData["email"],
        birthDate: $intDate,
        sex: transformSexFromInput($userInputData["sex"]),
        role: transformRoleFromInput($userInputData["role"]),
        status: $userInputData["status"],
        note: $userInputData["note"] == "" ? null : $userInputData["note"]);

    $person[ID] = $currentUser[ID];
    $person[PERSON_LAST_NAME] = $userInputData["lastName"] === '' ? null : $userInputData["lastName"];
    $person[PASSWORD] = $_POST["newPassword"] == null ? $currentUser[PASSWORD] : $_POST["newPassword"];
    $person[PERSON_BIRTH_DATE] = date('Y-m-d H:i:s', $person[PERSON_BIRTH_DATE]);
    $person[PERSON_LAST_LOGGED_IN] = $currentUser[PERSON_LAST_LOGGED_IN] == null ? null :  $currentUser[PERSON_LAST_LOGGED_IN];
    $person[JOBS_NAME] = $_POST["jobName"] ?? $currentJob[JOBS_NAME];
    unset($_SESSION["personData"]);
    savePerson($person, "view-person.php");


} else {
    $_SESSION["userInputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    // redirect to edit person page if error in input data
    redirect("../edit-person.php", "person=" . $currentUser[ID]);
}




