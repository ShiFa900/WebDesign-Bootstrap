<?php

require_once __DIR__ . "/../assets/json/json-load-data.php";
require_once __DIR__ . "/utils.php";



// mencari logic untuk membedakan error ketika salah menginput pass atau email, 
// dan error ketika akun user tidak ditemukan (belum sign in)


$userExist = userExist();
if ($userExist != []) {
  redirect("../dashboard.php", true);
} else {
  redirect("../login.php", "error=1");
}

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