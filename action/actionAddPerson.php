<?php
require_once __DIR__ . "/utils.php";

session_start();
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


$validate = validate(
    nik: $_POST["nik"],
    email: $_POST["email"],
    password: $_POST["password"],
    confirmPassword: $_POST["confirmPass"],
    birthDate: $_POST["birthDate"]);
if (count($validate) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["inputData"]);

    $persons = getAll();

    $person = [
        ID => null,
        PERSON_FIRST_NAME => ucwords($userInputData["firstName"]),
        PERSON_LAST_NAME => ucwords($userInputData["lastName"]),
        PERSON_NIK => $userInputData["nik"],
        PERSON_EMAIL => $userInputData["email"],
        PERSON_BIRTH_DATE => convertDateToTimestamp($userInputData["birthDate"]),
        PERSON_SEX => $userInputData["sex"],
        PERSON_INTERNAL_NOTE => null,
        PERSON_ROLE => $userInputData["role"],
        PASSWORD => $userInputData["password"],
        PERSON_STATUS => translateSwitch($userInputData["status"]),
        PERSON_LAST_LOGGED_IN => null,
    ];

    savePerson($person, "persons.php");

} else {
//    echo hasEmailCheck($_POST["email"]);
    $_SESSION["inputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    redirect("../addPerson.php", "");
}

//buat sebuah variable array yang akan menyimpan semua data-data yang error ketika mengambil input
//kemudian, cek variable tersebut di file actionAddPerson.php untuk menampilkan pesan error (jika terdapat)