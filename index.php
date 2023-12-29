<?php
function redirectIfNotAuthenticated():void {
    if (!isset($_SESSION['userEmail'])) {
        header("Location: login.php");
        exit(); // Terminate script execution after the redirect
    }
}