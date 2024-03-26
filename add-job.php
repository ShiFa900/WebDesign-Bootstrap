<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/card.php";
require_once __DIR__ . "/include/popup-alert.php";

redirectIfNotAuthenticated();
$person = findFirstFromArray(tableName: 'persons', key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
checkRole($_SESSION["userEmail"], "ROLE_ADMIN");

mainHeader(cssIdentifier: "page-add-job", title: "Add Job", link: "add-job.php", pageStyles: ["jobs.css"]);
?>
    <main>
        <section class="add-job-section d-flex position-relative">
            <!-- desktop sidebar -->
            <?php desktopSidebar("jobs.php"); ?>

            <div class="w-100">
                <div class="add-job-content position-absolute px-5">
                    <div class="page-header">
                        <h1 class="first-heading">Add Job</h1>
                    </div>
                    <?php
                    if (isset($_SESSION["error"])) {
                        showPopUpAlert(alertName: 'alert-danger', info:$_SESSION["info"] );
                    }
                    ?>
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <?php
                                    cardBody(action:"action-add-job.php",location: "jobs.php", imgSrc: "Work time-amico.svg", label: "Add job");
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php mainFooter("jobs.php");
unset($_SESSION["info"]);
