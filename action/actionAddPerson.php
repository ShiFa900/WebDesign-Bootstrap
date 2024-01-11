<?php
require_once __DIR__ . "/utils.php";

session_start();
echo $_POST["firstName"];
if (isset($_POST["firstName"])) {
    if (hasNikCheck($_POST["nik"]) == -1) {
        $_SESSION["errorNik"] = "Sorry, your NIK is already exist";
    }

    if (hasEmailCheck($_POST["email"]) == -1) {
        $_SESSION["errorEmail"] = "Sorry, your EMAIL is already exist";
    }

    if (validatePassword($_POST["password"]) == -1) {
        $_SESSION["errorPassword"] = " Sorry, your PASSWORD is weak. Password should include at least one" .
            " UPPERCASE, one LOWERCASE, one NUMBER and one SPECIAL CHARACTER.";
    }

    if ($_POST["confirmPass"] !== $_POST["password"]) {
        $_SESSION["errorConfirm"] = "Sorry, your CONFIRMATION was wrong. Please check your PASSWORD again.";
    }

//    unset($_SESSION["errorNik"]);
//    unset($_SESSION["errorEmail"]);
//    unset($_SESSION["errorPassword"]);
//    unset($_SESSION["errorConfirm"]);

    $persons = getAll();

    $person = [
        ID => null,
        PERSON_FIRST_NAME => ucwords($_POST["firstName"]),
        PERSON_LAST_NAME => ucwords($_POST["lastName"]),
        PERSON_NIK => $_POST["nik"],
        PERSON_EMAIL => $_POST["email"],
        PERSON_BIRTH_DATE => convertDateToTimestamp($_POST["birthDate"]),
        PERSON_SEX => $_POST["sex"],
        PERSON_INTERNAL_NOTE => null,
        PERSON_ROLE => $_POST["role"],
        PASSWORD => $_POST["password"],
        PERSON_STATUS => translateSwitch($_POST["status"]),
        PERSON_LAST_LOGGED_IN => null,
    ];

    savePerson($person, "persons.php");
}

function hasNikCheck(string $nik): int
{
    $persons = getAll();
    for ($i = 0; $i < count($persons); $i++) {
        if ($persons[$i][PERSON_NIK] == $nik) return -1;
    }
    return 0;
}


function hasEmailCheck(string $email): int
{
//    mengecek agar tidak ada email yang duplicate
    $persons = getAll();
    foreach ($persons as $person) {
        if ($email == $person[PERSON_EMAIL] && !filter_var($email, FILTER_VALIDATE_EMAIL)) return -1;
    }
    return 0;
}

function validatePassword(string $password): string|int
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return -1;
    }
    return $password;
}


//buat sebuah variable array yang akan menyimpan semua data-data yang error ketika mengambil input
//kemudian, cek variable tersebut di file actionAddPerson.php untuk menampilkan pesan error (jika terdapat)