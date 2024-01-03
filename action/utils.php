<?php

require_once __DIR__ . "/../assets/json/jsonLoadData.php";

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
        if ($_POST["email"] == $data[$i]["email"] && $_POST["password"] == $data[$i]["password"]) {
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
            "id" => $persons[$i]["id"],
            "firstName" => $persons[$i]["firstName"],
            "lastName" => $persons[$i]["lastName"],
            "nik" => $persons[$i]["nik"],
            "email" => $persons[$i]["email"],
            "birthDate" => $persons[$i]["birthDate"],
            "sex" => $persons[$i]["sex"],
            "internalNote" => $persons[$i]["internalNote"],
            "role" => $persons[$i]["role"],
            "password" => $persons[$i]["password"],
            "alive" => $persons[$i]["alive"],
            "lastLoggedIn" => $persons[$i]["lastLoggedIn"]
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
    if ($person["id"] == null) {
        $id = generateId($persons);
        $person["id"] = $id;
        $persons[] = $person;
        saveDataIntoJson($persons, "persons.json");
        redirect("../" . $location, "error=0");

    } else {
//        EDIT MODE
        for ($i = 0; $i < count($persons); $i++) {
            if ($person["id"] == $persons[$i]["id"]) {

//                convert date of birth to int timestamp

                $persons[$i] = [
                    "firstName" => ucwords($person["firstName"]),
                    "lastName" => ucwords($person["lastName"]),
                    "nik" => $person["nik"],
                    "email" => $person["email"],
                    "birthDate" => convertDateToTimestamp($person["birthDate"]),
                    "sex" => $person["sex"],
                    "internalNote" => $person["internalNote"],
                    "role" => $person["role"],
                    "password" => $person["password"],
                    "alive" => $person["alive"],
                    "lastLoggedIn" => $person["lastLoggedIn"]
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
    return is_array($persons) == null ? (end($persons)['id']) + 1 : 1;
}

function convertDateToTimestamp(int|string $date, string|null $format = 'm/d/Y'): int|null
{
    if (is_string($date)) {
        $birthDate = date_create_from_format($format, $date);
        if ($birthDate) return date_format($birthDate, 'U');
    }
    return null;
}

function getPerson(int $id = null, string $email = null): array
{
    $persons = getAll();
    if ($id != null) {
        foreach ($persons as $person) {
            if ($person["id"] == $id) {
                return $person;
            }
        }
    } else {
        foreach ($persons as $person) {
            if ($person["email"] == $email) {
                return $person;
            }
        }
    }
    return [];
}

function translateIntToString(int $int): string
{
    switch ($int) {
        case 0:
            return "ADMIN";
        case 1:
            return "MEMBER";
        default:
            return "";
    }
}

function translateBooleanToString(string $status): string
{
    return $status ? "Alive" : "Passed Away";
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