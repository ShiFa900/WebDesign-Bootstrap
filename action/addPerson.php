<?php
require_once __DIR__ . "/utils.php";

//session_start();

if (isset($_POST["firstName"])) {
    $persons = getAll();
    $status = $_POST["status"];

    $person = [
        ID => generateId($persons),
        PERSON_FIRST_NAME => $_POST["firstName"],
        PERSON_LAST_NAME => $_POST["lastName"],
        PERSON_NIK => $_POST["nik"],
        PERSON_EMAIL => $_POST["email"],
        PERSON_BIRTH_DATE => convertDateToTimestamp($_POST["birthDate"]),
        PERSON_SEX => $_POST["sex"],
        PERSON_INTERNAL_NOTE => $_POST["note"],
        PERSON_ROLE => $_POST["role"],
        PASSWORD => $_POST["password"],
        PERSON_STATUS => $status,
        PERSON_LAST_LOGGED_IN => null,
    ];

    $persons[] = $person;
    saveDataIntoJson($persons, "persons.json");
    redirect("../" . "persons.php", "error=0");
//    savePerson($person, "addPerson.php");

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


//buat sebuah variable array yang akan menyimpan semua data-data yang error ketika mengambil input
//kemudian, cek variable tersebut di file addPerson.php untuk menampilkan pesan error (jika terdapat)