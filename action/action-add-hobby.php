<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
// jika person dihapus, maka hobby juga terhapus (agar tidak menimbulkan error nantinya)
session_start();

$hobby = [
    ID => null,
    HOBBIES_NAME => $_POST["hobbyName"],
    HOBBIES_PERSON_ID => $_SESSION["personId"]
];
saveHobby($hobby, "hobbies.php");