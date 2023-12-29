<?php

require_once __DIR__ . "/../assets/json/jsonLoadData.php";

/**
 * @param url go to login page if it unsucces
 * @param string error message on the header
 */
function redirect($url, $getParams):void
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
    if ($person["id"] == 0) {
        $id = generateId($persons);
        $person["id"] = $id;
        $persons[] = $person;
        saveDataIntoJson($persons, "persons.json");
//        redirect("../".$location, "error=0");

    } else {
//        EDIT MODE
        for ($i = 0; $i < count($persons); $i++) {
            if ($person["id"] == $persons[$i]["id"]) {
                $persons[$i] = [
                    "firstName" => ucwords($person["firstName"]),
                    "lastName" => ucwords($person["lastName"]),
                    "nik" => $person["nik"],
                    "email" => $person["email"],
                    "birthDate" => $person["birthDate"],
                    "sex" => $person["sex"],
                    "internalNote" => $person["internalNote"],
                    "role" => $person["role"],
                    "password" => $person["password"],
                ];
                saveDataIntoJson($persons, "persons.json");
                redirect("../".$location, "error=0");

            }
        }
    }
}

function generateId(array|null $persons = null): int
{
    return $persons == null ? 1 : (end($persons['id'])) + 1;
}
