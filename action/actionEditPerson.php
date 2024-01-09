<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";

global $person;

//mendapatkan data person yang akan di edit dengan menggunakan ID person tersebut
$person = getPerson(id: $person["personId"]);
var_dump($person);

// belum suud ni cokk
if(isset($_POST["firstName"])){
    $newPersonData = [
        ID => $person["personId"],
        PERSON_FIRST_NAME => $_POST["firstName"] == null ? $person[PERSON_FIRST_NAME] : $_POST["firstName"],
        PERSON_LAST_NAME => $_POST["lastName"] == null ? $person[PERSON_LAST_NAME] : $_POST["lastName"],
        PERSON_NIK => $_POST["nik"] == null ? $person[PERSON_NIK] : $_POST["nik"],
        PERSON_EMAIL => $_POST["email"] == null ? $person[PERSON_EMAIL] : $_POST["email"],
        PERSON_BIRTH_DATE => $_POST["birthDate"] == null ? $person[PERSON_BIRTH_DATE] : $_POST["birthDate"],
        PERSON_SEX => $_POST["sex"] == null ? $person[PERSON_SEX] : $_POST["sex"],
        PERSON_INTERNAL_NOTE => $_POST["note"] == null ? $person[PERSON_INTERNAL_NOTE] : $_POST["note"],
        PERSON_ROLE => $_POST["role"] == null ? $person[PERSON_ROLE] : $_POST["role"],
        PASSWORD =>  $person[PASSWORD],
        PERSON_STATUS => $_POST["status"] == null ? $person[PERSON_STATUS] : $_POST["status"],
        PERSON_LAST_LOGGED_IN => $person[PERSON_LAST_LOGGED_IN]
    ];
    print_r($person);
    savePerson($newPersonData, "persons.php");
}
// === NOTE ===
// jika user tidak menginput data baru, maka gunakan data yang sebelumnya.
// butuh conditional 


