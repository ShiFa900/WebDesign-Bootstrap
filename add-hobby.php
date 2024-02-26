<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/body-card.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();
$persons = getAll();
$person = findFirstFromArray(array: $persons, key: ID, value: $_GET["person"]);
$user = findFirstFromArray(array: $persons, key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
$_SESSION["personId"] = $person[ID];
if ($user[PERSON_EMAIL] != $person[PERSON_EMAIL] && $user[PERSON_ROLE] != ROLE_ADMIN) {
    checkRole($_SESSION["userEmail"], "ROLE_ADMIN");
}
mainHeader(cssIdentifier: "page-add-hobby", title: "Add Hobby", link: "add-hobby.php", pageStyles: ["hobbies.css"]);
?>
    <main>
        <section class="add-hobby-section d-flex position-relative">
            <!-- desktop sidebar -->
            <?php desktopSidebar("persons.php"); ?>

            <div class="w-100">
                <div class="add-hobby-content position-absolute px-5">
                    <div class="page-header">
                        <h1 class="first-heading">Add Hobby</h1>
                    </div>
                    <?php
                    if (isset($_SESSION["info"])) {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_SESSION["info"] ?>!
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-xxl-12">

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <?php
                                    cardBody(action: "action-add-hobby.php", location: "hobbies.php", imgSrc: "About%20me-amico.svg", label: "Add hobby");
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php mainFooter("persons.php");
unset($_SESSION["info"]);
