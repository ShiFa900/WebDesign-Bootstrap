<?php
require_once __DIR__ . "/utils.php";

//session_start();


//    TEST

//$person = [
//    "firstName" => $_POST['add-first-name'],
//    "lastName" => $_POST["add-last-name"],
//    "nik" => hasNikCheck($_POST["add-nik"]),
//    "email" => $_POST["add-email"],
//    "birthDate" => convertDate($_POST["add-date"]),
//    "sex" => $_POST["add-sex"],
//    "internalNote" => $_POST["add-note"],
//    "role" => $_POST["add-role"],
//    "password" => $_POST["add-password"],
//    "alive" => $_POST["add-switch"],
//    "lastLoggedIn" => null
//    ];

//savePerson($person, "viewPerson.php");

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

function confirmPassword(string $password, string $confirmPassword): bool
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8 && $confirmPassword != $password) {
        return false;
    }
    return true;
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

    if (hasEmailCheck($email)) {
        $validated["email"] = 1;
    }

    if (confirmPassword($password, $confirm)) {
        $validated["confirm-pass"] = 1;
    }

    return $validated;
}

//$errorData = getErrorData(
//    email: $_POST["add-email"],
//    password: $_POST["add-password"],
//    confirm: $_POST["confirm-password"],
//    nik: $_POST["add-nik"]);
//
//$_SESSION['addNik'] = $errorData["nik"];
//$_SESSION["addEmail"] = $errorData["email"];
//$_SESSION["addPassword"] = $errorData["add-password"];
//$_SESSION["confirmPassword"] = $errorData["confirm-pass"];
//
//$_SESSION["addId"] = null;
//$_SESSION["addFirstName"] = $_POST["add-first-name"];
//$_SESSION["addLastName"] = $_POST["add-last-name"];
//$_SESSION["addSex"] = $_POST["add-sex"];
//$_SESSION["addBirthDate"] = $_POST["add-birth-date"];
//$_SESSION["internalNote"] = $_POST["add-internal-note"];
//$_SESSION["addRole"] = $_POST["add-role"];

if(isset($_POST["addPerson"])) {
    $person = [
        "id" => null,
        "firstName" => $_POST["add-first-name"],
        "lastName" => $_POST["add-last-name"],
        "nik" => $_POST["add-nik"],
        "email" => $_POST["add-email"],
        "birthDate" => $_POST["add-birth-date"],
        "sex" => $_POST["add-sex"],
        "internalNote" => $_POST["add-internal-note"],
        "role" => $_POST["add-role"],
        "password" => $_POST["add-password"],
        "alive" => $_POST["add-alive"],
        "lastLoggedIn" => null,
    ];
    savePerson($person, "../addPerson.php");
}

//buat sebuah variable array yang akan menyimpan semua data-data yang error ketika mengambil input
//kemudian, cek variable tersebut di file addPerson.php untuk menampilkan pesan error (jika terdapat)