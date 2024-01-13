<?php
require_once __DIR__ . "/utils.php";

session_start();
$intDate = convertDateToTimestamp($_POST["birthDate"]);

$inputData = [
    'firstName' => htmlspecialchars($_POST["firstName"]),
    'lastName' => htmlspecialchars($_POST["lastName"]),
    'nik' => htmlspecialchars($_POST["nik"]),
    'birthDate' => date("Y-m-d", $intDate),
    'email' => filter_var($_POST["email"], FILTER_VALIDATE_EMAIL),
    'role' => $_POST["role"],
    'sex' => $_POST["sex"],
    'status' => $_POST["status"]
];

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
        PERSON_FIRST_NAME => ucwords($_POST["firstName"]),
        PERSON_LAST_NAME => ucwords($_POST["lastName"]),
        PERSON_NIK => $_POST["nik"],
        PERSON_EMAIL => $_POST["email"],
        PERSON_BIRTH_DATE => convertDateToTimestamp($_POST["birthDate"]),
        PERSON_SEX => $_POST["sex"],
        PERSON_INTERNAL_NOTE => null,
        PERSON_ROLE => $_POST["role"],
        PASSWORD => $_POST["password"],
        PERSON_STATUS => translateSwitch($_POST["status"]),
        PERSON_LAST_LOGGED_IN => null,
    ];

    savePerson($person, "persons.php");

} else {
//    echo hasEmailCheck($_POST["email"]);
    $_SESSION["inputData"] = $inputData;
    $_SESSION["errorData"] = $validate;
    redirect("../addPerson.php", "");
}

//buat sebuah variable array yang akan menyimpan semua data-data yang error ketika mengambil input
//kemudian, cek variable tersebut di file actionAddPerson.php untuk menampilkan pesan error (jika terdapat)