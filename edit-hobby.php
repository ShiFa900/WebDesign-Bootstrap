<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/body-card.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();
// dapatkan hobi mana yang akan di edit
$currentHobby = getHobby($_GET["hobby"]);

if ($currentHobby == null) {
    $_SESSION["error"] = "Sorry, no data found";
    redirect("hobbies.php", "person=" . $_SESSION["personId"]);
}

$_SESSION["currentHobby"] = $currentHobby;
mainHeader(cssIdentifier: "page-edit-hobby", title: "Edit Hobby", link: "edit-hobby.php", pageStyles: ["hobbies.css"]);
?>
    <main>
        <section class="edit-hobby-section d-flex position-relative">
            <!-- desktop sidebar -->
            <?php desktopSidebar("persons.php"); ?>

            <div class="w-100">
                <div class="edit-hobby-content position-absolute px-5">
                    <div class="page-header">
                        <h1 class="first-heading">Edit Hobby</h1>
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
                                <div class="col-xl-12">
                                    <?php
                                    cardBody(action: "action-edit-hobby.php", location: "jobs.php", imgSrc: "About%20me-amico.svg", label: "Hobby name", currentData: $currentHobby[HOBBIES_NAME]);
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
