<?php

require_once __DIR__ . "/../assets/json/jsonLoadData.php";
require_once __DIR__ . "/const.php";

//==============================
//****** CHECK AUTHORISED ******
//==============================
/**
 * @param url go to login page if it unsucces
 * @param string error message on the header
 */
function redirect($url, $getParams): void
{
    header('Location: ' . $url . '?' . $getParams);
    die();
}

function redirectIfNotAuthenticated(): void
{
    if (!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit(); // Terminate script execution after the redirect
    }
}

function checkRoleAdmin(): bool
{
    $user = getPerson(email: $_SESSION["userEmail"]);
    if ($user[PERSON_ROLE] != ROLE_ADMIN) {
        redirect("persons.php", "error=userNotAuthenticate");

    }
    return true;
}

function checkAbility(): bool
{
    $user = getPerson(email: $_SESSION["userEmail"]);
    if ($user[PERSON_STATUS] == STATUS_PASSED_AWAY) {
        redirect("login.php", "error=userStatusPassedAway");
    }
    return true;
}


//==============================
//****** GENERAL ******
//==============================

function userExist(): array
{
    $data = getAll();

    for ($i = 0; $i < count($data); $i++) {
        if ($_POST["email"] == $data[$i][PERSON_EMAIL] && $_POST["password"] == $data[$i][PASSWORD]) {
            return $data[$i];
        }
    }
    return [];
}

function getAll(): array
{
    // we need to convert it into array of Person
    $persons = loadDataFromJson("persons.json");
    $result = [];
    for ($i = 0; $i < count($persons); $i++) {
        $person = [
            ID => $persons[$i][ID],
            PERSON_FIRST_NAME => $persons[$i][PERSON_FIRST_NAME],
            PERSON_LAST_NAME => $persons[$i][PERSON_LAST_NAME],
            PERSON_NIK => $persons[$i][PERSON_NIK],
            PERSON_EMAIL => $persons[$i][PERSON_EMAIL],
            PERSON_BIRTH_DATE => $persons[$i][PERSON_BIRTH_DATE],
            PERSON_SEX => $persons[$i][PERSON_SEX],
            PERSON_INTERNAL_NOTE => $persons[$i][PERSON_INTERNAL_NOTE],
            PERSON_ROLE => $persons[$i][PERSON_ROLE],
            PASSWORD => $persons[$i][PASSWORD],
            PERSON_STATUS => $persons[$i][PERSON_STATUS],
            PERSON_LAST_LOGGED_IN => $persons[$i][PERSON_LAST_LOGGED_IN]
        ];

        $result[] = $person;
    }
    return $result;
}

function savePerson(array $person, string $location): void
{
//menyimpan data person saat melakukan penambahan atau pengeditan
    $persons = getAll();
//    CREATE MODE
    if ($person[ID] == null) {
        $id = generateId($persons);
        $person[ID] = $id;
        $persons[] = $person;
        saveDataIntoJson($persons, "persons.json");
        redirect("../" . $location, "msg=addSuccess");

    } else {
//        EDIT MODE
        for ($i = 0; $i < count($persons); $i++) {
            if ($person[ID] == $persons[$i][ID]) {

                $persons[$i] = [
                    ID => $persons[$i][ID],
                    PERSON_FIRST_NAME => ucwords($person[PERSON_FIRST_NAME]),
                    PERSON_LAST_NAME => ucwords($person[PERSON_LAST_NAME]),
                    PERSON_NIK => $person[PERSON_NIK],
                    PERSON_EMAIL => $person[PERSON_EMAIL],
                    PERSON_BIRTH_DATE => convertDateToTimestamp($person[PERSON_BIRTH_DATE]),
                    PERSON_SEX => $person[PERSON_SEX],
                    PERSON_INTERNAL_NOTE => $person[PERSON_INTERNAL_NOTE],
                    PERSON_ROLE => $person[PERSON_ROLE],
                    PASSWORD => $person[PASSWORD],
                    PERSON_STATUS => translateSwitch($person[PERSON_STATUS]),
                    PERSON_LAST_LOGGED_IN => $persons[$i][PERSON_LAST_LOGGED_IN]
                ];
                $_SESSION["personHasEdit"] = $persons[$i];
                saveDataIntoJson($persons, "persons.json");
                redirect("../" . $location, "msg=editSuccess");

            }
        }
    }
}

function generateId(array|null $persons = null): int
{
//    return $persons == null ? 1 : (end($persons['id'])) + 1;
    return is_array($persons) == null ? 1 : (end($persons)[ID]) + 1;
}

function convertDateToTimestamp(string $date): int
{
    $date = str_replace('-', '/', $date);
    return strtotime($date);

}

function getPerson(int|null $id = null, string|null $email = null): array
{
    $persons = getAll();
    if ($id != null) {
        foreach ($persons as $person) {
            if ($person[ID] == $id) {
                return $person;
            }
        }
    } else {
        foreach ($persons as $person) {
            if ($person[PERSON_EMAIL] == $email) {
                return $person;
            }
        }
    }
    return [];
}


function translateBooleanToString(string $status): string
{
    return $status ? "Alive" : "Passed Away";
}

function translateSwitch(string|null $on): bool
{
    return $on === "on";
}

function getAgeCategory(array $person): string
{
//    mendapatkan orang yang statusnya meninggal
    $category = '';
    if ($person[PERSON_STATUS] == STATUS_PASSED_AWAY) {
        return CATEGORIES_PASSED_AWAY;
    }

//mendapatkan umur dari tiap orang

    $age = calculateAge($person[PERSON_BIRTH_DATE]);
    if ($age <= 13) {
        $category = CATEGORIES_CHILD;
    } elseif ($age <= 45) {
        $category = CATEGORIES_PRODUCTIVE_AGE;
    } elseif ($age >= 46) {
        $category = CATEGORIES_ELDERLY;
    }
    return $category;
}
//function getAgeCategory(array $person): array
//{
////    mendapatkan orang yang statusnya meninggal
//    $category = '';
//    if ($person[PERSON_STATUS] == STATUS_PASSED_AWAY) {
//        return ['CATEGORIES_PASSED_AWAY', $person];
//    }
//
////mendapatkan umur dari tiap orang
//
//    $age = calculateAge($person[PERSON_BIRTH_DATE]);
//    if ($age <= 13) {
//        $category = [CATEGORIES_CHILD, $person];
//    } elseif ($age <= 45) {
//        $category = [CATEGORIES_PRODUCTIVE_AGE, $person];
//    } elseif ($age >= 46) {
//        $category = [CATEGORIES_ELDERLY, $person];
//    }
//    return $category;
//}


function calculateAge($birth_date_ts): int
{
    $date = new DateTime('@' . $birth_date_ts);
    $now = new DateTime('now');
    $interval = $date->diff($now);
    return floor($interval->y);
}

function setPersonData(
    array       &$person,
    string|null $firstName,
    string|null $lastName,
    string|null $nik,
    string|null $email,
    string|null $birthDate,
    string|null $sex,
    string|null $role,
    string|null $status,
    string|null $note = null): void
{
    $person[PERSON_FIRST_NAME] = $firstName == null ? $person[PERSON_FIRST_NAME] : $firstName;
    $person[PERSON_LAST_NAME] = $lastName == null ? $person[PERSON_LAST_NAME] : $lastName;
    $person[PERSON_NIK] = $nik == null ? $person[PERSON_NIK] : $nik;
    $person[PERSON_EMAIL] = $email == null ? $person[PERSON_EMAIL] : $email;
    $person[PERSON_BIRTH_DATE] = $birthDate == null ? $person[PERSON_BIRTH_DATE] : $birthDate;
    $person[PERSON_SEX] = $sex == null ? $person[PERSON_SEX] : $sex;
    $person[PERSON_ROLE] = $role == null ? $person[PERSON_ROLE] : $role;
    $person[PERSON_STATUS] = $status == null ? $person[PERSON_STATUS] : $status;
    $person[PERSON_INTERNAL_NOTE] = $note;
}
