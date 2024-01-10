<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

//mendapatkan data person yang akan di edit dengan menggunakan ID person tersebut

// belum suud ni cokk
$persons = getAll();
for ($i = 0; $i < count($persons); $i++) {
    if ($persons[$i][ID] == $_SESSION["personId"]) {
        setPersonData(
            $persons[$i],
            firstName: $_POST["firstName"],
            lastName: $_POST["lastName"],
            nik: $_POST["nik"],
            email: $_POST["email"],
            birthDate: $_POST["birthDate"],
            sex: $_POST["sex"],
            role: $_POST["role"],
            status: $_POST["status"]);
//        $persons[$i][PERSON_FIRST_NAME] = $_POST["firstName"] == null ? $persons[$i][PERSON_FIRST_NAME] : $_POST["firstName"];
//        $persons[$i][PERSON_LAST_NAME] = $_POST["lastName"] == null ? $persons[$i][PERSON_LAST_NAME] : $_POST["lastName"];
//        $persons[$i][PERSON_NIK] = $_POST["nik"] == null ? $persons[$i][PERSON_NIK] : $_POST["nik"];
//        $persons[$i][PERSON_EMAIL] = $_POST["email"] == null ? $persons[$i][PERSON_EMAIL] : $_POST["email"];
//        $persons[$i][PERSON_BIRTH_DATE] = $_POST["birthDate"] == null ? $persons[$i][PERSON_BIRTH_DATE] : $_POST["birthDate"];
//        $persons[$i][PERSON_SEX] = $_POST["sex"] == null ? $persons[$i][PERSON_SEX] : $_POST["sex"];
//        $persons[$i][PERSON_ROLE] = $_POST["role"] == null ? $persons[$i][PERSON_ROLE] : $_POST["role"];
//        $persons[$i][PERSON_STATUS] = $_POST["status"] == null ? $persons[$i][PERSON_STATUS] : $_POST["status"];

        savePerson($persons[$i], "persons.php");
    }
}




