<?php
require_once __DIR__ . "/utils.php";

session_start();
$intDate = convertDateToTimestamp($_POST["birthDate"]);

$inputData = [
    'firstName' => htmlspecialchars($_POST["firstName"]),
    'lastName' => htmlspecialchars($_POST["lastName"]),
    'nik' => htmlspecialchars($_POST["nik"]),
    'birthDate' => date("Y-m-d", $intDate),
    'email' => filter_var($_POST["email"], FILTER_VALIDATE_EMAIL),
    'role' => $_POST["role"],
    'sex' => $_POST["sex"],
    'status' => $_POST["status"]
];


function validate(): array
{

    $validate = [];
    if (isset($_POST["firstName"])) {
        if (hasNikCheck($_POST["nik"]) == -1) {
            $validate["errorNik"] = "Sorry, your NIK is already exist";
        }

        if (hasEmailCheck($_POST["email"]) == -1) {
            $validate["errorEmail"] = "Sorry, your EMAIL is already exist";
        }

        if (validatePassword($_POST["password"]) == -1) {
            $validate["errorPassword"] = " Sorry, your PASSWORD is weak. Password should include at least one" .
                " UPPERCASE, one LOWERCASE, and one NUMBER.";
        }

        if ($_POST["confirmPass"] !== $_POST["password"]) {
            $validate["errorConfirm"] = "Sorry, your CONFIRMATION was wrong. Please check your PASSWORD again.";
        }

        if (birthDateValidate($_POST["birthDate"]) == -1) {
            $validate["errorBirthDate"] = "Sorry, your BIRTH DATE is not valid. Please check your birth date again.";
        }

    }
    return $validate;
}

if (count(validate()) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["inputData"]);

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

} else {
//    echo hasEmailCheck($_POST["email"]);
    $_SESSION["inputData"] = $inputData;
    $_SESSION["errorData"] = validate();
    redirect("../addPerson.php", "");
}


function hasNikCheck(string $nik): int
{
    $persons = getAll();
    for ($i = 0; $i < count($persons); $i++) {
        if ($persons[$i][PERSON_NIK] == $nik) return -1;
    }
    return 0;
}

function birthDateValidate(string $birthDate)
{
    $intDate = convertDateToTimestamp($birthDate);
    if (time() < $intDate || $intDate == null) {
        return -1;
    }
    return 0;

}


function hasEmailCheck(string $email): int
{
//    mengecek agar tidak ada email yang duplicate
    $persons = getAll();
    for ($i = 0; $i < count($persons); $i++) {
        if ($email == $persons[$i][PERSON_EMAIL]) return -1;
    }
    return 0;
}

function validatePassword(string $password): string|int
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);

    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        return -1;
    }
    return $password;
}


//buat sebuah variable array yang akan menyimpan semua data-data yang error ketika mengambil input
//kemudian, cek variable tersebut di file actionAddPerson.php untuk menampilkan pesan error (jika terdapat)