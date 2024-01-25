<?php

session_start();

require_once __DIR__ . "/../assets/json/jsonLoadData.php";
require_once __DIR__ . "/utils.php";


if (isset($_POST['login'])) {
    $userExist = userExist($_POST["email"], $_POST["password"]);


// conditionals untuk meng-redirect page login ke dashboard jika berhasil login
    if ($userExist != null) {

        $_SESSION['userEmail'] = $_POST['email'];
        $_SESSION['startTime'] = time();
        if(checkPersonStatus($_SESSION["userEmail"])) {
            header("Location: ../dashboard.php");
            exit();
        }
    } else {
        redirect("../login.php", "error=1");
    }
}

/**
 * check user status, cannot login with account of Passed away status
 * @param string $userEmail
 * @return bool
 */
function checkPersonStatus(string $userEmail): bool
{
    $user = getPerson(email: $userEmail);
    if ($user[PERSON_STATUS] == STATUS_PASSED_AWAY) {
        $_SESSION["userPassedAway"] = "Sorry, this person status is PASSED AWAY. Ask ADMIN for more information.";
        redirect("../login.php", "");
    }
    return true;
}

/**
 * search user data for login form, user data must be existed in json file
 * @param string $email
 * @param string $password
 * @return array
 */
function userExist(string $email, string $password): array
{
    $data = getAll();

    for ($i = 0; $i < count($data); $i++) {
        if ($email == $data[$i][PERSON_EMAIL] && password_verify($password, $data[$i][PASSWORD])) {
            return $data[$i];
        }
    }
    return [];
}
