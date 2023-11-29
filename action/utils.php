<?php
function userExist(): array
{
    $data = getAll();

    $result = [];
    for ($i = 0; $i < count($data); $i++) {
        if ($_POST["email"] == $data[$i]["email"] && $_POST["password"] == $data[$i]["password"]) {
            return $result[] =  $data[$i];
        }
    }
    return $result;
}

function getAll(): array
{
    // we need to convert it into array of Person
    $persons = loadDataFromJson("persons.json");
    $result = [];
    for ($i = 0; $i <= count($persons); $i++) {
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
            "password" => $persons[$i]["password"]
        ];

        $result[] = $person;
    }
    return $result;
}
