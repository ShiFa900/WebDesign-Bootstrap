<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentUser = $_SESSION["userData"];
// di page my profile, user tidak perlu menambahkan hobby pada form, link ke add hobby page
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

// get user current job
$getPersonJob = getPersonJob($currentUser[ID]);

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

    $person = setPersonData(
        $currentUser,
        firstName: $userInputData["firstName"],
        lastName: $userInputData["lastName"],
        nik: $userInputData["nik"],
        email: $userInputData["email"],
        birthDate: $intDate,
        sex: transformSexFromInput($userInputData["sex"]),
        role: transformRoleFromInput($currentUser[PERSON_ROLE]),
        note: $userInputData["note"] == null ? $currentUser[PERSON_INTERNAL_NOTE] : $userInputData["note"]);

    $person[ID] = $currentUser[ID];
    $person[PERSON_LAST_LOGGED_IN] = date('Y-m-d H:i:s', $currentUser[PERSON_LAST_LOGGED_IN]);
    $person[PASSWORD] = $_POST["newPassword"] == null ? $currentUser[PASSWORD] : $_POST["newPassword"];
    $person[PERSON_STATUS] = $currentUser[PERSON_STATUS];
    $person[PERSON_BIRTH_DATE] = date('Y-m-d H:i:s', $person[PERSON_BIRTH_DATE]);
    $person[JOBS_NAME] = $_POST["jobName"] ?? $getPersonJob[JOBS_NAME];
    unset($_SESSION["userData"]);

    // save person data if no error data
    savePerson($person, "my-profile.php");

} else {
    $_SESSION["userInputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    // redirect user to form again if it has error data
    redirect("../my-profile.php", "");
}




