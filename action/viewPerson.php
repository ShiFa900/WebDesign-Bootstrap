<?php
include __DIR__ . "/utils.php";
//membuat validasi untuk mengecek bila yang sedang view person orang yang sama dengan user atau bukan

global $person;
$person = getPerson($_GET["id"]);
if(count($person) != 0){
    return [
        "firstName" => $person["firstName"],
        "lastName" => $person["lastName"],
        "nik" => $person["nik"],
        "email" => $person["email"],
        "birthDate" => $person["birthDate"],
        "sex" => $person["sex"],
        "internalNote" => $person["internalNote"],
        "role" => $person["role"],
        "alive" => $person["alive"]
    ];
}


