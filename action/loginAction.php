<?php

require_once __DIR__ . "/../assets/json/jsonLoadData.php";
require_once __DIR__ . "/utils.php";



// mencari logic untuk membedakan error ketika salah menginput pass atau email, 
// dan error ketika akun user tidak ditemukan (belum sign in)

session_start();

$jsonData = loadDataFromJson("persons.json");
// var_dump($jsonData);

// ini apa?
if (isset($_POST['login'])) {
    $email = $_POST['email'];

// conditionals untuk meng-redirect page contoh dari login menuju dashboard
    if (userExist()) {
//  header('Location: ../dashboard.php');
//  die();
        $_SESSION['userEmail'] = $_POST['email'];
        $_SESSION['userName'] = userExist()['firstName'];
        $_SESSION['logout'] = userExist()['lastLoggedIn'];
        header("Location: ../dashboard.php");
        exit();

    } else {
        redirect("../login.php", "error=1");
    }
}

//if (userExist()) {
//  redirect("../dashboard.php", true);
//} else {
//  redirect("../login.php", "error=1");
//}

/**
 * @param url go to login page if it unsucces
 * @param string error message on the header
 */
function redirect($url, $getParams)
{
  header('Location: ' . $url . '?' . $getParams);
  die();
}



// NOTE
// 1. User berhasil login dan masuk ke halaman dashboard (tidak bisa kembali ke halaman login lagi harusnya)
// 2. Nama di header untuk dashboard dan nama user di header nav akan sync dengan user yang sedang login