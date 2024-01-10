<?php
require_once __DIR__ . "/utils.php";
session_start();

$currentUser = getPerson(email: $_SESSION["userEmail"]);

$persons = getAll();
for ($i = 0; $i < count($persons); $i++){
    if($persons[$i][ID] == $currentUser[ID]){
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

//        buat set value untuk password

//        savePerson();
//        $persons[$i][PERSON_FIRST_NAME] = $_POST["firstName"] == null ? $persons[$i][PERSON_FIRST_NAME] : $_POST["firstName"];
//        $persons[$i][PERSON_LAST_NAME] = $_POST["lastName"] == null ? $persons[$i][PERSON_LAST_NAME] : $_POST["lastName"];
//        $persons[$i][PERSON_NIK] = $_POST["nik"] == null ? $persons[$i][PERSON_NIK] : $_POST["nik"];
//        $persons[$i][PERSON_EMAIL] = $_POST["email"] == null ? $persons[$i][PERSON_EMAIL] : $_POST["email"];
//        $persons[$i][PERSON_BIRTH_DATE] = $_POST["birthDate"] == null ? $persons[$i][PERSON_BIRTH_DATE] : $_POST["birthDate"];
//        $persons[$i][PERSON_SEX] = $_POST["sex"] == null ? $persons[$i][PERSON_SEX] : $_POST["sex"];
//        $persons[$i][PERSON_ROLE] = $_POST["role"] == null ? $persons[$i][PERSON_ROLE] : $_POST["role"];
//        $persons[$i][PERSON_STATUS] = $_POST["status"] == null ? $persons[$i][PERSON_STATUS] : $_POST["status"];
    }
}

function setPersonData(
    array &$person,
    array $firstName,
    array $lastName,
    array $nik,
    array $email,
    array $birthDate,
    array $sex,
    array $role,
    array $status): void
{
    $person[PERSON_FIRST_NAME] = $firstName == null ? $person[PERSON_FIRST_NAME] : $firstName;
    $person[PERSON_LAST_NAME] = $lastName == null ? $person[PERSON_LAST_NAME] : $lastName;
    $person[PERSON_NIK] = $nik == null ? $person[PERSON_NIK] : $nik;
    $person[PERSON_EMAIL] = $email == null ? $person[PERSON_EMAIL] : $email;
    $person[PERSON_BIRTH_DATE] = $birthDate == null ? $person[PERSON_BIRTH_DATE] : $birthDate;
    $person[PERSON_SEX] = $sex == null ? $person[PERSON_SEX] : $sex;
    $person[PERSON_ROLE] = $role == null ? $person[PERSON_ROLE] : $role;
    $person[PERSON_STATUS] = $status == null ? $person[PERSON_STATUS] : $status;
}
