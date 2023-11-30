<?php

require_once __DIR__ . "/utils.php";

//function untuk mengecek user mana yang tengah login
function hasLogin(){
//    data dari user yang sudah login
    $user =  userExist();
    echo $user["email"];
    echo $user["password"];
}

hasLogin();