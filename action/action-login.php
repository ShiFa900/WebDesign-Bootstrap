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
        if (checkPersonStatus($person)) {
            redirect("../login.php", "userPassedAway");
        } else {
            header("Location: ../dashboard.php");
        }
        exit();
    } else {
        redirect("../login.php", "error=1");
    }
}


function userExist(string $email, string $password): array
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
    return [];
}
