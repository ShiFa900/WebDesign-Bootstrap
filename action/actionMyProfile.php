<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
session_start();

$currentUser = $_SESSION["personData"];
if(!isset($_POST["newPassword"])){
    echo "adakah?";
}
$intDate = convertDateToTimestamp($_POST["birthDate"]);
$userInputData = getUserInputData(
    firstName: $_POST["firstName"],
    lastName: $_POST["lastName"],
    email: $_POST["email"],
    nik: $_POST["nik"],
//    kedua items ini tidak bisa diedit
    role: $currentUser[PERSON_ROLE],
    status: $currentUser[PERSON_STATUS],
    birthDate: $intDate,
    sex: $_POST["sex"]);


if($currentUser[PERSON_INTERNAL_NOTE] != null) {
    $userAdditionalData = [
        "internalNote" => htmlspecialchars($_POST["note"])
    ];
    $userInputData[] = $userAdditionalData;
}
//meng-append $userInputData dengan inputan internal note

// belum suud ni cokk
// key $_POST["newPassword"] dan confirmPassword tidak ditemukan

$validate = validate(
    nik: $_POST["nik"],
    email: $_POST["email"],
    birthDate: $_POST["birthDate"],
    id: $_SESSION["personData"][ID],
    password: $_POST["newPassword"],
    confirmPassword: $_POST["confirmPassword"],
    currentPassword: $currentUser[PASSWORD]);

if (count($validate) == 0) {
    unset($_SESSION["errorData"]);
    unset($_SESSION["userInputData"]);

    $persons = getAll();
    for ($i = 0; $i < count($persons); $i++) {
        if ($persons[$i][ID] == $currentUser[ID]) {
            setPersonData(
                $persons[$i],
                firstName: $userInputData["firstName"],
                lastName: $userInputData["lastName"],
                nik: $userInputData["nik"],
                email: $userInputData["email"],
                birthDate: $userInputData["birthDate"],
                sex: $userInputData["sex"],
                role: $userInputData["role"],
                status: $userInputData["status"]);
            $persons[$i][PASSWORD] = $_POST["newPassword"] == null ? $persons[$i][PASSWORD] : $_POST["newPassword"];

            savePerson($persons[$i], "persons.php");
        }
    }

} else {
//    echo hasEmailCheck($_POST["email"]);
    $_SESSION["userInputData"] = $userInputData;
    $_SESSION["errorData"] = $validate;
    redirect("../myProfile.php", "id=" . $_SESSION["personData"][ID]);
}





