    <?php
require_once __DIR__ . "/utils.php";
session_start();
global $PDO;

$hobby = getHobby($_GET["hobby"]);
$personWithHobby = findFirstFromArray(tableName: 'persons', key: ID, value: $hobby[HOBBIES_PERSON_ID]);

if ($hobby == null) {
    $_SESSION["noHobbyFound"] = "Sorry, no hobby found";
    redirect("../hobbies.php", "person=" . $personWithHobby[ID]);
}
try {
    $query = "DELETE FROM `hobbies` WHERE id = :id";
    $stmt = $PDO->prepare($query);
    $stmt->execute(array(
        "id" => $hobby[ID]
    ));
    $_SESSION["deleteSuccess"] = "Successfully delete hobby of '" . $hobby[HOBBIES_NAME] . "' !";
} catch (PDOException $e) {
    die("Query error: " . $e->getMessage());
}

redirect("../hobbies.php", "person=" . $personWithHobby[ID]);
