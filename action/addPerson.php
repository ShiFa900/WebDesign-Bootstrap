<?php
require_once __DIR__ . "/utils.php";

//session_start();

if(isset($_POST["add-person-form"])){
//    TEST

$person = [
    "firstName" => $_POST['add-first-name'],
    "lastName" => $_POST["add-last-name"],
    "nik" => hasNikCheck($_POST["add-nik"]),
    "email" => $_POST["add-email"],
    "birthDate" => convertDate($_POST["add-date"]),
    "sex" => $_POST["add-sex"],
    "internalNote" => $_POST["add-note"],
    "role" => $_POST["add-role"],
    "password" => $_POST["add-password"],
    "alive" => $_POST["add-switch"],
    "lastLoggedIn" => null
    ];

savePerson($person, "viewPerson.php");
}

function hasNikCheck(int $nik):bool
{
    $persons = getAll();
    for($i = 0; $i < count($persons); $i++) {
        if (strlen($nik) != 16 || $persons[$i]["nik"] == $nik) return false;
    }
    return true;
}

function hasEmailCheck(string $email): bool{
//    mengecek agar tidak ada email yang duplicate
    $persons = getAll();
    foreach ($persons as $person){
        if($email == $person["email"] && !filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
    }
    return true;
}

function confirmPassword(string $password, string $confirmPassword){
    if($confirmPassword != $password )
        return "error=1";
}

//buat sebuah variable array yang akan menyimpan semua data-data yang error ketika mengambil input
//kemudian, cek variable tersebut di fila addPerson.php untuk menampilkan pesan error (jika terdapat)