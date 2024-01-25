<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentUser = $_SESSION["userData"];

$intDate = convertDateToTimestamp($_POST["birthDate"]);
// get all person input or person previous data (if user not input new data)
$userInputData = getUserInputData(
    firstName: $_POST["firstName"],
    lastName: $_POST["lastName"],
    email: $_POST["email"],
    nik: $_POST["nik"],
    status: $currentUser[PERSON_STATUS],
    birthDate: $intDate,
    sex: $_POST["sex"],
    note: $_POST["note"]
);

// validate person input data
$validate = validate(
    nik: $_POST["nik"],
    email: $_POST["email"],
    birthDate: $_POST["birthDate"],
    password: $_POST["newPassword"],
    confirmPassword: $_POST["confirmPassword"],
    currentPassword: $_POST["currentPassword"],
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
        note: $userInputData["note"] == null ? $currentUser[PERSON_INTERNAL_NOTE] : $userInputData["note"]);

    $userData[PASSWORD] = $_POST["newPassword"] == null ? $currentUser[PASSWORD] : $_POST["newPassword"];
    $userData[PERSON_STATUS] = boolval($userInputData["status"]);
    // save person data if no error data
    savePerson($userData, "my-profile.php");

} else {
    $_SESSION["userInputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    // redirect user to form again if it has error data
    redirect("../my-profile.php", "");
}




