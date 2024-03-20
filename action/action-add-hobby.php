<?php
require_once __DIR__ . "/utils.php";
require_once __DIR__ . "/const.php";
// jika person dihapus, maka hobby juga terhapus (agar tidak menimbulkan error nantinya)
session_start();
$newHobby = $_POST["name"];
if($newHobby === ''){
    $_SESSION['info'] = "Please write a hobby name";
    redirect("../add-hobby.php", "person=" . $_SESSION["personId"]);
}

$personHobby = getHobby(personId: $_SESSION["personId"]); // ini harusnya isinya adalah array hobby dari si person
foreach ($personHobby as $hobby){
    if(strcasecmp($hobby[HOBBIES_NAME], $newHobby) == 0){
        $_SESSION["info"] = "Sorry, this hobby is already exist!";
        redirect("../add-hobby.php", "person=" . $_SESSION["personId"]);
    }
}

$hobby = [
    ID => null,
    HOBBIES_NAME => htmlspecialchars($newHobby),
    HOBBIES_PERSON_ID => $_SESSION["personId"],
    HOBBIES_LAST_UPDATE => time()
];
saveHobby($hobby, "hobbies.php");