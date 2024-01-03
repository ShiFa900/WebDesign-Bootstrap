<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/login.php";
$_SESSION["lastLoggedIn"] = time();
unset($_SESSION["id"]);
unset($_SESSION["lastName"]);
unset($_SESSION["firstName"]);
unset($_SESSION["email"]);
unset($_SESSION["nik"]);
unset($_SESSION["birthDate"]);
unset($_SESSION["sex"]);
unset($_SESSION["alive"]);
unset($_SESSION["password"]);
unset($_SESSION["internalNote"]);
unset($_SESSION["role"]);
redirect("login.php", "error=0");