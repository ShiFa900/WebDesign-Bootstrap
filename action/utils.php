<?php

require_once __DIR__ . "/../assets/json/jsonLoadData.php";
require_once __DIR__ . "/const.php";

/**
 * @param url go to login page if it unsucces
 * @param string error message on the header
 */
function redirect($url, $getParams): void
{
    header('Location: ' . $url . '?' . $getParams);
    die();
}

function userExist(): array
{
    $data = getAll();

    for ($i = 0; $i < count($data); $i++) {
        if ($_POST[PERSON_EMAIL] == $data[$i][PERSON_EMAIL] && $_POST[PASSWORD] == $data[$i][PASSWORD]) {
            return $data[$i];
        }
    }
    return [];
}

function getAll(): array
{
    // we need to convert it into array of Person
    $persons = loadDataFromJson("persons.json");
    $result = [];
    for ($i = 0; $i < count($persons); $i++) {
        $person = [
            ID => $persons[$i][ID],
            PERSON_FIRST_NAME => $persons[$i][PERSON_FIRST_NAME],
            PERSON_LAST_NAME => $persons[$i][PERSON_LAST_NAME],
            PERSON_NIK => $persons[$i][PERSON_NIK],
            PERSON_EMAIL => $persons[$i][PERSON_EMAIL],
            PERSON_BIRTH_DATE => $persons[$i][PERSON_BIRTH_DATE],
            PERSON_SEX => $persons[$i][PERSON_SEX],
            PERSON_INTERNAL_NOTE => $persons[$i][PERSON_INTERNAL_NOTE],
            PERSON_ROLE => $persons[$i][PERSON_ROLE],
            PASSWORD => $persons[$i][PASSWORD],
            PERSON_STATUS => $persons[$i][PERSON_STATUS],
            PERSON_LAST_LOGGED_IN => $persons[$i][PERSON_LAST_LOGGED_IN]
        ];

        $result[] = $person;
    }
    return $result;
}

function savePerson(array $person, string $location): void
{
//menyimpan data person saat melakukan penambahan atau pengeditan
    $persons = getAll();
//    CREATE MODE
    if ($person[ID] == null) {
        $id = generateId($persons);
        $person[ID] = $id;
        $persons[] = $person;
        saveDataIntoJson($persons, "persons.json");
        redirect("../" . $location, "error=0");

    } else {
//        EDIT MODE
        for ($i = 0; $i < count($persons); $i++) {
            if ($person[ID] == $persons[$i][ID]) {

                $persons[$i] = [
                    ID => $persons[$i][ID],
                    PERSON_FIRST_NAME => ucwords($person[PERSON_FIRST_NAME]),
                    PERSON_LAST_NAME => ucwords($person[PERSON_LAST_NAME]),
                    PERSON_NIK => $person[PERSON_NIK],
                    PERSON_EMAIL => $person[PERSON_EMAIL],
                    PERSON_BIRTH_DATE => convertDateToTimestamp($person[PERSON_BIRTH_DATE]),
                    PERSON_SEX => $person[PERSON_SEX],
                    PERSON_INTERNAL_NOTE => $person[PERSON_INTERNAL_NOTE],
                    PERSON_ROLE => $person[PERSON_ROLE],
                    PASSWORD => $person[PASSWORD],
                    PERSON_STATUS => translateSwitch($person[PERSON_STATUS]),
                    PERSON_LAST_LOGGED_IN => $persons[$i][PERSON_LAST_LOGGED_IN]
                ];
                saveDataIntoJson($persons, "persons.json");
                redirect("../" . $location, "error=0");

            }
        }
    }
}

function generateId(array|null $persons = null): int
{
//    return $persons == null ? 1 : (end($persons['id'])) + 1;
    return is_array($persons) == null ? 1 : (end($persons)[ID]) + 1 ;
}

function convertDateToTimestamp(string $date, string|null $format = 'd/m/Y'): int
{
    $date = str_replace('-','/', $date);
    return strtotime($date);
//    $newDate = date($format, strtotime($date));
//    $birthDate = date_create_from_format($format, $newDate);
//    if ($birthDate) {
//        return date_format($birthDate, 'U');
//    }
//    return -1;
}

function getPerson(int|null $id = null, string|null $email = null): array
{
    $persons = getAll();
    if ($id != null) {
        foreach ($persons as $person) {
            if ($person[ID] == $id) {
                return $person;
            }
        }
    } else {
        foreach ($persons as $person) {
            if ($person[PERSON_EMAIL] == $email) {
                return $person;
            }
        }
    }
    return [];
}


function translateBooleanToString(string $status): string
{
    return $status ? "Alive" : "Passed Away";
}

function translateSwitch(string $on): bool
{
    return $on == "on" ? true : false;
}

function getAgeCategory(int $age){
    if($age <= 13){
       return CATEGORIES_CHILD;
    } elseif ($age <= 45){
        return CATEGORIES_PRODUCTIVE_AGE;
    } elseif ($age >= 46){
        return CATEGORIES_ELDERLY;
    }
}
//function calculateAge(string $birthOfDate): int
//{
//    $currentDate = time();
//    if ($birthOfDate > $currentDate) {
//        return 0;
//    }
//    list($date, $month, $year) = explode('-', $birthOfDate);
//    $wasBorn = mktime(0, 0, 0, (int)$month, (int)$date, $year); //jam,menit,detik,bulan,tanggal,tahun
//    $age = ($wasBorn < 0) ? ($currentDate + ($wasBorn * -1)) : $currentDate - $wasBorn;
//    $yearCalculate = 60 * 60 * 24 * 365;
//    $wasBornOnYear = $age / $yearCalculate;
//    return floor($wasBornOnYear);
//
//
//}

function calculateAge($birth_date_ts): int
{
    $date = new DateTime('@' . $birth_date_ts);
    $now = new DateTime('now');
    $interval = $date->diff($now);
    return floor($interval->y);
}
