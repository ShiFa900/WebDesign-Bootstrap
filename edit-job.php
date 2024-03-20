<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();
checkRole($_SESSION["userEmail"], "ROLE_ADMIN");

$currentJob = findFirstFromArray(tableName: 'jobs', key: ID, value: $_GET["job"]);
if ($currentJob == null) {
    $_SESSION["error"] = "Sorry, no data found";
    redirect("jobs.php", "");
}
// dapatkan nama" orang yang menggunakan job currentJob
$_SESSION["job"] = $currentJob;

mainHeader(cssIdentifier: "page-edit-job", title: "Add Job", link: "edit-job.php", pageStyles: ["jobs.css"]);
?>
    <main>
        <section class="edit-job-section d-flex position-relative">
            <!-- desktop sidebar -->
            <?php desktopSidebar("jobs.php"); ?>

            <div class="w-100">
                <div class="edit-job-content position-absolute px-5">
                    <div class="page-header">
                        <h1 class="first-heading">Edit Job</h1>
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
                                    <form class="new-person-form" action="action/action-edit-job.php" method="post"
                                          name="addJob">
                                        <div class="card-wrapper">
                                            <div class="form-card">
                                                <div class="wrapper-card-img">
                                                    <img src="assets/properties/Work%20time-amico.svg"
                                                         alt="Person while work" class="card-img">
                                                </div>
                                                <div class="card-field">
                                                    <label for="jobName" class="form-label">Edit job</label>
                                                    <input type="text" id="jobName" class="form-control"
                                                           name="jobName" maxlength="30" minlength="3"
                                                           placeholder="New job" value="<?= $currentJob[JOBS_NAME] ?>">

                                                    <div class="btn-container d-flex column-gap-3">
                                                        <a class="btn btn-primary btn--form has-border" type="submit"
                                                           href="jobs.php">
                                                            Cancel
                                                        </a>
                                                        <?php
                                                        if ($currentJob[JOBS_COUNT] > 0) {
                                                            ?>
                                                            <button class="btn btn-primary btn--form" type="submit"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal"
                                                            ><a>Save</a>
                                                            </button>
                                                            <div
                                                                    class="modal fade"
                                                                    id="exampleModal"
                                                                    tabindex="-1"
                                                                    aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true"
                                                            >
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                The job has been used
                                                                                by <?= $currentJob[JOBS_COUNT] ?>
                                                                                persons. Are you sure to continue to
                                                                                change the job's name?
                                                                            </h1>
                                                                            <button
                                                                                    type="button"
                                                                                    class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"
                                                                            ></button>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button
                                                                                    type="button"
                                                                                    class="btn btn-secondary btn-block"
                                                                                    data-bs-dismiss="modal"
                                                                            >
                                                                                Cancel
                                                                            </button>
                                                                            <button type="submit"
                                                                                    class="btn btn-primary"
                                                                                    name="btnDelete">
                                                                                <a href="#"
                                                                                   class="btn pop-up-btn-hover">Yes</a>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <button class="btn btn-primary btn--form" type="submit"
                                                                    name="btn">
                                                                Save
                                                            </button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
