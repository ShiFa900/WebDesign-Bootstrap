<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

//$currentUser = $_SESSION["userEmail"];

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

