<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

// butuh refactor, jadikan function
// menyimpan inputan dari user
// untuk password tidak disimpan
$intDate = convertDateToTimestamp($_POST["birthDate"]);
$savePersonInputData = [
    'firstName' => htmlspecialchars($_POST["firstName"]),
    'lastName' => htmlspecialchars($_POST["lastName"]),
    'nik' => htmlspecialchars($_POST["nik"]),
    'birthDate' => date("Y-m-d", $intDate),
    'email' => filter_var($_POST["email"], FILTER_VALIDATE_EMAIL),
    'role' => $_POST["role"],
    'sex' => $_POST["sex"],
    'status' => $_POST["status"],
    'internalNote' => $_POST["note"]
];

$persons = getAll();
for ($i = 0; $i < count($persons); $i++) {
    if ($persons[$i][PERSON_EMAIL] == $_SESSION["userEmail"]) {
        setPersonData(
            person: $persons[$i],
            firstName: $_POST["firstName"],
            lastName: $_POST["lastName"],
            nik: $_POST["nik"],
            email: $_POST["email"],
            birthDate: $_POST["birthDate"],
            sex: $_POST["sex"],
            role: null,
            status: null,
            note: $persons[$i][PERSON_ROLE] == ROLE_MEMBER ? null : $_POST["note"]);
//        if(isset($_POST["newPassword"]) != null){
//            $_SESSION["hasNewPassword"] = $_POST["newPassword"];
////        }
//        $persons[$i][PASSWORD] = $_POST["newPassword"] == null ? $persons[$i][PASSWORD] : $_POST["newPassword"];


        savePerson($persons[$i], "persons.php");

    }
}

