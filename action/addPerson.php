<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/../addPerson.php";

//session_start();

//if(isset($_POST["add-person-form"])){
//    $nik = isNikExistWithRightLength($_POST["add-nik"]);
//    TEST
//Saat menambahkan person/create, password tidak di include
//password akan di include ketika user create akun, dengan syarat user telah ada di database (create by admin)
$person = [
    "firstName" => $_POST["addFirstName"],
    "lastName" => $_POST["addLastName"],
    "nik" => $_POST["addNik"],
    "email" => $_POST["addEmail"],
    "birthDate" => $_POST["addDate"],
    "sex" => $_POST["addSex"],
    "alive" => $_POST["addSwitch"],
    "internalNote" => $_POST["addNote"],
    "role" => $_POST["addRole"],
    "lastLoggedIn" => null
    ];
var_dump($person);
//savePerson($person, "viewPerson.php");
//redirect("../viewPerson.php", "error=0");


//}

//function isNikExistWithRightLength(int $nik):int
//{
//    $persons = getAll();
//    for($i = 0; $i < count($persons); $i++) {
//        if (strlen($nik) != 16 || $persons[$i]["nik"] == $nik) {
//            redirect("../addPerson.php", "error=1");
//        }
//    }
//    return $nik;
//}