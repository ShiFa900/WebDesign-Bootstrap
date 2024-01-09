<?php

session_start();

require_once __DIR__ . "/../assets/json/jsonLoadData.php";
require_once __DIR__ . "/utils.php";

$userExist = userExist();

// ini apa?
if (isset($_POST['login'])) {
//    $email = $_POST['email'];


// conditionals untuk meng-redirect page login ke dashboard jika berhasil login
    if ($userExist != null) {
//  header('Location: ../actionDashboard.php');
//  die();
        $_SESSION['userEmail'] = $_POST['email'];
        $_SESSION['userName'] = $userExist['firstName'];
        $_SESSION['logout'] = $userExist['lastLoggedIn'];
        header("Location: ../actionDashboard.php");
        exit();

    } else {
        redirect("../login.php", "error=1");
    }
}

// NOTE
// 1. User berhasil login dan masuk ke halaman dashboard (tidak bisa kembali ke halaman login lagi harusnya)
// 2. Nama di header untuk dashboard dan nama user di header nav akan sync dengan user yang sedang login