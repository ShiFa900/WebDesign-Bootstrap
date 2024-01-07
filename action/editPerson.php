<?php
require_once __DIR__ . "/utils.php";
session_start();

global $person;
$person = getPerson($_SESSION["personId"]);

//if (isset($_POST["firstName"])) {

$person =  [
    PERSON_FIRST_NAME => $person[PERSON_FIRST_NAME],
    PERSON_LAST_NAME => $person[PERSON_LAST_NAME],
    PERSON_NIK => $person[PERSON_NIK],
    PERSON_EMAIL => $person[PERSON_EMAIL],
    PERSON_BIRTH_DATE => $person[PERSON_BIRTH_DATE],
    PERSON_SEX => $person[PERSON_SEX],
    PERSON_INTERNAL_NOTE => $person[PERSON_INTERNAL_NOTE],
    PERSON_ROLE => $person[PERSON_ROLE],
    PERSON_STATUS => $person[PERSON_STATUS]
];
if(isset($_POST["firstName"])){
    $person = [
        ID => $person[ID],
        PERSON_FIRST_NAME => ucwords($_POST["firstName"]),
        PERSON_LAST_NAME => ucwords($_POST["lastName"]),
        PERSON_NIK => $_POST["nik"],
        PERSON_EMAIL => $_POST["email"],
        PERSON_BIRTH_DATE => convertDateToTimestamp($_POST["birthDate"]),
        PERSON_SEX => $_POST["sex"],
        PERSON_INTERNAL_NOTE => $_POST["note"],
        PERSON_ROLE => $_POST["role"],
        PASSWORD => $_POST["newPassword"],
        PERSON_STATUS => $_POST["status"] == "on",
        PERSON_LAST_LOGGED_IN => $person[PERSON_LAST_LOGGED_IN]
    ];

    savePerson($person, "persons.php");
}
// === NOTE ===
// jika user tidak menginput data baru, maka gunakan data yang sebelumnya.
// butuh conditional 


