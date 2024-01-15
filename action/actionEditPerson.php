<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

//mendapatkan data person yang akan di edit dengan menggunakan ID person tersebut
//edit person data belum dicoba
$intDate = convertDateToTimestamp($_POST["birthDate"]);

$userInputData = getUserInputData(
    firstName: $_POST["firstName"],
    lastName: $_POST["lastName"],
    email: $_POST["email"],
    nik: $_POST["nik"],
    role: $_POST["role"],
    status: $_POST["status"],
    birthDate: $intDate,
    sex: $_POST["sex"]);

// belum suud ni cokk

$validate = validate(
    nik: $_POST["nik"],
    email: $_POST["email"],
    birthDate: $_POST["birthDate"],
    id: $_SESSION["personId"],
    password: $_POST["newPassword"],
    confirmPassword: $_POST["confirmPassword"]);
if (count($validate) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["userInputData"]);

    $persons = getAll();
    for ($i = 0; $i < count($persons); $i++) {
        if ($persons[$i][ID] == $_SESSION["personId"]) {
            setPersonData(
                $persons[$i],
                firstName: $userInputData["firstName"],
                lastName: $userInputData["lastName"],
                nik: $userInputData["nik"],
                email: $userInputData["email"],
                birthDate: $userInputData["birthDate"],
                sex: $userInputData["sex"],
                role: $userInputData["role"],
                status: $userInputData["status"]);
            $persons[$i][PASSWORD] = $_POST["newPassword"] == null ? $persons[$i][PASSWORD] : $_POST["newPassword"];

            savePerson($persons[$i], "persons.php");
        }
    }
//    $person = [
//        ID => null,
//        PERSON_FIRST_NAME => ucwords($userInputData["firstName"]),
//        PERSON_LAST_NAME => ucwords($userInputData["lastName"]),
//        PERSON_NIK => $userInputData["nik"],
//        PERSON_EMAIL => $userInputData["email"],
//        PERSON_BIRTH_DATE => convertDateToTimestamp($userInputData["birthDate"]),
//        PERSON_SEX => $userInputData["sex"],
//        PERSON_INTERNAL_NOTE => null,
//        PERSON_ROLE => $userInputData["role"],
//        PASSWORD => $userInputData["password"],
//        PERSON_STATUS => translateSwitch($userInputData["status"]),
//        PERSON_LAST_LOGGED_IN => null,
//    ];

//    savePerson($person, "persons.php");

} else {
//    echo hasEmailCheck($_POST["email"]);
    $_SESSION["userInputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    redirect("../test.php", "");
}




