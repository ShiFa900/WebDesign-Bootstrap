<?php
require_once __DIR__ . "/utils.php";

session_start();

if (isset($_POST["firstName"])) {
    if (hasNikCheck($_POST["nik"]) == -1) {
        $_SESSION["errorNik"] = 1;
    }

    if (hasEmailCheck($_POST["email"]) == -1) {
        $_SESSION["errorEmail"] = 1;
    }

    if (validatePassword($_POST["password"]) == -1) {
        $_SESSION["errorPassword"] = 1;
    }

    if($_POST["confirmPass"] !== $_POST["password"]){
        $_SESSION["errorConfirm"] = 1;
    }

//    unset($_SESSION["errorNik"]);
//    unset($_SESSION["errorEmail"]);
//    unset($_SESSION["errorPassword"]);
//    unset($_SESSION["errorConfirm"]);
//    $errorData = getErrorData(
//        email: $_POST["email"],
//        password: $_POST["password"],
//        nik: $_POST["nik"]);
//
//
//    $_SESSION["errorNik"] = $errorData["nik"];
//    $_SESSION["errorEmail"] = $errorData["email"];
//    $_SESSION["errorPass"] = $errorData["password"];
//    header("addPerson.php");
//    exit();


    $persons = getAll();

    $person = [
        ID => null,
        PERSON_FIRST_NAME => ucwords($_POST["firstName"]),
        PERSON_LAST_NAME => ucwords($_POST["lastName"]),
        PERSON_NIK => $_POST["nik"],
        PERSON_EMAIL => $_POST["email"],
        PERSON_BIRTH_DATE => convertDateToTimestamp($_POST["birthDate"]),
        PERSON_SEX => $_POST["sex"],
        PERSON_INTERNAL_NOTE => $_POST["note"],
        PERSON_ROLE => $_POST["role"],
        PASSWORD => $_POST["password"],
        PERSON_STATUS => translateSwitch($_POST["status"]),
        PERSON_LAST_LOGGED_IN => null,
    ];

    savePerson($person, "persons.php");
}

/**
 * @return array
 * function untuk mengecek semua inputan untuk mencari error
 */
function getErrorData(
    string $email,
    string $password,
    string $nik,
): array
{
//    mendapatkan data yang mengandung error
    $validated = [];


    return $validated;
}

function hasNikCheck(int $nik): int
{
    $persons = getAll();
    for ($i = 0; $i < count($persons); $i++) {
        if (strlen($nik) != 16 && $persons[$i][PERSON_NIK] == $nik) return -1;
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