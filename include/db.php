<?php
/* Host name of the MySQL server */
$host = 'localhost';

/* db user name */
$user = 'root';

/* db user password */
$passwd = 'shifa123';

/* The schema or database name */
$schema = 'personsManagementApps';

/* Global PDO object that can be used in other PHP scripts later on */
global $PDO;

/* Connection string, or "data source name" */
$dsn = 'mysql:host=' . $host . ';dbname=' . $schema;

// Try to connect to the db:
try {
    /* PDO object creation */
    $PDO = new PDO($dsn, $user,  $passwd);

    /* Enable exceptions on errors */
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    session_start();
    /* If there is an error an exception is thrown */
    $_SESSION['error'] = $e->getMessage();
    header('Location: ../error.php');
    die();
}
