<?php

session_start();

//require_once __DIR__ . "/../assets/json/jsonLoadData.php";
require_once __DIR__ . "/../include/db.php";
require_once __DIR__ . "/utils.php";

if (isset($_POST['login'])) { //ini
    $person = userExist($_POST["email"], $_POST["password"]);


// conditionals untuk meng-redirect page login ke dashboard jika berhasil login
    if ($person != null) {
        $_SESSION['userEmail'] = $_POST['email'];
        $_SESSION['startTime'] = time();
//        checkPersonStatus($person);
        header("Location: ../dashboard.php");
        exit();
    } else {
        redirect("../login.php", "error=1");
    }
}

/**
 * check user status, cannot login with account of Passed away status
 * @param array $person
 */
function checkPersonStatus(array $person): void
{
    //$user = getPerson(email: $userEmail);
    if ($person[PERSON_STATUS] == STATUS_PASSED_AWAY) {
        $_SESSION["userPassedAway"] = "Sorry, this person status is PASSED AWAY. Ask ADMIN for more information.";
        redirect("../login.php", "");
        die();
    }
}

/**
 * search user data for login form, user data must be existed in json file
 * @param string $email
 * @param string $password
 * @return array
 */
//function userExist(string $email, string $password): array
//{
//    $data = getAll();
//
//    for ($i = 0; $i < count($data); $i++) {
//        if ($email == $data[$i][PERSON_EMAIL] && password_verify($password, $data[$i][PASSWORD])) {
//            return $data[$i];
//        }
//    }
//    return [];
//}

function userExist(string $email, string $password): array|null
{
    // global variable for database connection
    global $PDO;

    // jika perlu sanitize $email dan $password dulu sebelum ke bawah
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    try {
        $query = 'SELECT * FROM persons WHERE email = :email LIMIT 1';
        $statement = $PDO->prepare($query);
        $statement->execute(array(
            "email" => $email
        ));
    } catch (PDOException $e) {
        echo 'Query error: ' . $e->getMessage();
        die();
    }

    // asumsinya kalau msk sini, query aman tapi datanya ada atau tidak blm tentu..
    $person = $statement->fetch(PDO::FETCH_ASSOC);
    if ($person && password_verify($password, $person[PASSWORD])) {
        return $person;
    }
    return null;
}
