<?php
require_once __DIR__ . "/utils.php";

session_start();
$intDate = convertDateToTimestamp($_POST["birthDate"]);
// get user input data, and temp save if there are an error
$userInputData = getUserInputData(
    firstName: $_POST["firstName"],
    lastName: $_POST["lastName"],
    email: $_POST["email"],
    nik: $_POST["nik"],
    role: $_POST["role"],
    status: $_POST["status"],
    birthDate: $intDate,
    sex: $_POST["sex"],
    note: $_POST["note"]
);

// validate for input data
$validate = validate(
    nik: $_POST["nik"],
    email: $_POST["email"],
    birthDate: $_POST["birthDate"],
    password: $_POST["password"],
    confirmPassword: $_POST["confirmPass"]);
if (count($validate) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["inputData"]);

    $person = [
        ID => null,
        PERSON_FIRST_NAME => ucwords($userInputData["firstName"]),
        PERSON_LAST_NAME => ucwords($userInputData["lastName"]),
        PERSON_NIK => $userInputData["nik"],
        PERSON_EMAIL => $userInputData["email"],
        PERSON_BIRTH_DATE => $userInputData["birthDate"],
        PERSON_SEX => transformSexFromInput($userInputData["sex"]),
        PERSON_INTERNAL_NOTE => $userInputData["note"] == "" ? null : $userInputData["note"],
        PERSON_ROLE => transformRoleFromInput($userInputData["role"]),
        PASSWORD => password_hash($_POST["password"], PASSWORD_DEFAULT),
        PERSON_STATUS => (int)translateSwitch($userInputData["status"]),
        PERSON_LAST_LOGGED_IN => null,
        HOBBIES_NAME => $userInputData["hobbyName"],
        JOBS_NAME => $userInputData["jobName"]
    ];

    savePerson($person, "view-person.php");

} else {
    $_SESSION["inputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    // redirect to edit person page if error in input data
    redirect("../add-person.php", "");
}
