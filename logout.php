<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/login.php";


$_SESSION["lastLoggedIn"] = time();
session_unset();
session_destroy();
redirect("login.php", "error=0");