<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
//session_start();
//membuat validasi untuk mengecek bila yang sedang view person orang yang sama dengan user atau bukan
// my profile bisa edit data person yang login

// error saat menampilkan
$person = getPerson($_GET[ID]);
if(count($person) != 0){
    return [
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
}


