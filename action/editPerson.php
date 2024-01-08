<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

global $person;
global $personUpdate;
$persons = getAll();
for ($i = 0; $i < count($persons); $i++){
    if($persons[$i][ID] == $_SESSION["personId"]){
        $person = $persons[$i];
    }
}

//$person = getPerson(id: $_SESSION["personId"]);

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
    $personUpdate = [
        ID => $_SESSION["personId"],
        PERSON_FIRST_NAME => $_POST["firstName"] == null ? $person[PERSON_FIRST_NAME] : $_POST["firstName"],
        PERSON_LAST_NAME => $_POST["lastName"] == null ? $person[PERSON_LAST_NAME] : $_POST["lastName"],
        PERSON_NIK => $_POST["nik"] == null ? $person[PERSON_NIK] : $_POST["nik"],
        PERSON_EMAIL => $_POST["email"] == null ? $person[PERSON_EMAIL] : $_POST["email"],
        PERSON_BIRTH_DATE => $_POST["birthDate"] == null ? $person[PERSON_BIRTH_DATE] : $_POST["birthDate"],
        PERSON_SEX => $_POST["sex"] == null ? $person[PERSON_SEX] : $_POST["sex"],
        PERSON_INTERNAL_NOTE => $_POST["note"] == null ? $person[PERSON_INTERNAL_NOTE] : $_POST["note"],
        PERSON_ROLE => $_POST["role"] == null ? $person[PERSON_ROLE] : $_POST["role"],
        PASSWORD => $_POST["newPassword"] == null ? $person[PASSWORD] : $_POST["newPassword"],
        PERSON_STATUS => $_POST["status"] == null ? $person[PERSON_STATUS] : $_POST["status"],
        PERSON_LAST_LOGGED_IN => $person[PERSON_LAST_LOGGED_IN]
    ];
    savePerson($personUpdate, "persons.php");
}
// === NOTE ===
// jika user tidak menginput data baru, maka gunakan data yang sebelumnya.
// butuh conditional 


