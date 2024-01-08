<?php
require_once __DIR__ . "/action/const.php";

function redirectIfNotAuthenticated(): void
{
    if (!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit(); // Terminate script execution after the redirect
    }
}

function checkRoleAdmin(): bool
{
    $user = getPerson($_SESSION["userEmail"]);
    if ($user[PERSON_ROLE] != ROLE_ADMIN) {
        header("Location: dashboard.php");
        exit();
    }
   return true;
}