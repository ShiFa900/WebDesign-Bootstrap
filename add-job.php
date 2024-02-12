<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();
$persons = getAll();
$person = findFirstFromArray(array: $persons, key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
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
                    <div class="row">
                        <div class="col-xxl-12">
                            <form class="new-person-form" action="action/action-add-job.php" method="post"
                                  name="addJob">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="card-wrapper">
                                            <div class="form-card">
                                                <div class="card-img">
                                                    <img src="assets/properties/Work%20time-amico.svg"
                                                         alt="Person while work" class="job-img">
                                                </div>
                                                <div class="card-field">
                                                    <label for="jobName" class="form-label required">Add job</label>
                                                    <input type="text" id="jobName" class="form-control"
                                                           name="name" maxlength="30" minlength="3"
                                                           placeholder="New job" required>

                                                    <div class="btn-container d-flex column-gap-3">
                                                        <a class="btn btn-primary btn--form has-border" type="submit"
                                                           href="jobs.php">
                                                            Cancel
                                                        </a>
                                                        <button class="btn btn-primary btn--form" type="submit"
                                                                name="btn">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php mainFooter("jobs.php");
