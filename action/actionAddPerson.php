<?php
require_once __DIR__ . "/utils.php";

//session_start();

if (isset($_POST["firstName"])) {
    $errorData = getErrorData(
        email: $_POST["email"],
        password: $_POST["password"],
        confirm: $_POST["confirmPass"],
        nik: $_POST["nik"]);


    $_SESSION["errorNik"] = $errorData["nik"];
//    $_SESSION["errorEmail"] = $errorData["email"];
//    $_SESSION["errorConfirmPass"] = $errorData["confirmPass"];
    $_SESSION["errorPass"] = $errorData["password"];
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
    string $confirm,
    string $nik,
): array
{
//    mendapatkan data yang mengandung error
    $validated = [];

    if (!hasNikCheck($nik)) {
        $validated["nik"] = 1;
    }

    if (!hasEmailCheck($email)) {
        $validated["email"] = 1;
    }

    if ($confirm === $password) {
        $validated["confirmPass"] = 0;
    }

    if (validatePassword($password) == "") {
        $validated["password"] = 1;
    }

    return $validated;
}

function hasNikCheck(int $nik): bool
{
    $persons = getAll();
    for ($i = 0; $i < count($persons); $i++) {
        if (strlen($nik) != 16 && $persons[$i]["nik"] == $nik) return false;
    }
    return true;
}


function hasEmailCheck(string $email): bool
{
//    mengecek agar tidak ada email yang duplicate
    $persons = getAll();
    foreach ($persons as $person) {
        if ($email == $person["email"] && !filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
    }
    return true;
}

function validatePassword(string $password): string
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return "";
    }
    return $password;
}


//buat sebuah variable array yang akan menyimpan semua data-data yang error ketika mengambil input
//kemudian, cek variable tersebut di file actionAddPerson.php untuk menampilkan pesan error (jika terdapat)