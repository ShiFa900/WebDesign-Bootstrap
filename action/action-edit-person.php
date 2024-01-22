<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

//mendapatkan data person yang akan di edit dengan menggunakan ID person tersebut
//edit person data belum dicoba
$currentUser = $_SESSION["personData"];
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
    password: $_POST["newPassword"],
    confirmPassword: $_POST["confirmPassword"],
    id: $currentUser[ID]);


if (count($validate) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["userInputData"]);

    $currentUser = setPersonData(
        $currentUser,
        firstName: $userInputData["firstName"],
        lastName: $userInputData["lastName"],
        nik: $userInputData["nik"],
        email: $userInputData["email"],
        birthDate: $userInputData["birthDate"],
        sex: $userInputData["sex"],
        role: $userInputData["role"],
        status: $userInputData["status"]);
    $currentUser[PASSWORD] = $_POST["newPassword"] == null ? $currentUser[PASSWORD] : $_POST["newPassword"];

    savePerson($currentUser, "persons.php?page=1");


} else {
//    echo hasEmailCheck($_POST["email"]);
    $_SESSION["userInputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    redirect("../edit-person.php", "id=" . $currentUser[ID]);
}




