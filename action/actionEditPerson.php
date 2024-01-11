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

        savePerson($persons[$i], "persons.php");
    }
}




