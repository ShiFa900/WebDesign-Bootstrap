<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/index.php";

?>
<?php
mainHeader(cssIdentifier: "page-view-person", title: "View Person", link: "view-person.php", pageStyles: ["view-person.css"]);

$person = getPerson($_GET["person"]);
$_SESSION["personId"] = $person[ID];
?>

    <main>
        <section class="view-section d-flex position-relative">
            <?php
            desktopSidebar("persons.php");
            ?>

            <div class="w-100">
                <div class="view-person-content position-absolute px-5">
                    <div class="page-header content-wrapper">
                        <h1 class="first-heading">View person</h1>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12">
                            <form class="new-person-form" action="action/action-view-person.php" method="post">
                                <div class="row">
                                    <div class="col-xxl-8 col-xl-8 col-lg-10 col-12">
                                        <div class="mb-3 form-input">
                                            <span class="required title">First Name</span>
                                            <p>
                                                <?= $person[PERSON_FIRST_NAME];
                                                ?>
                                            </p>
                                        </div>

                                        <?php
                                        if ($person[PERSON_LAST_NAME] != "") {
                                            ?>
                                            <div class="mb-3 form-input">

                                                <span class="title">Last Name</span>
                                                <p>
                                                    <?= $person[PERSON_LAST_NAME];
                                                    ?>
                                                </p>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="mb-3 form-input">
                                            <span class="required title">NIK</span>
                                            <p>
                                                <?= $person[PERSON_NIK];
                                                ?>
                                            </p>

                                        </div>
                                        <div class="mb-3 form-input">
                                            <span class="required title">Email</span>
                                            <p>
                                                <?= $person[PERSON_EMAIL];
                                                ?>
                                            </p>

                                        </div>

                                        <div class="mb-3 form-input">
                                            <span class="required title">Birth Of Date</span>
                                            <p>
                                                <?= date("d F Y", $person[PERSON_BIRTH_DATE]);
                                                ?>
                                            </p>

                                        </div>

                                        <div class="mb-3 form-input">
                                            <span class="required title">Sex</span>
                                            <p>
                                                <?php
                                                $personRole = sortSex($person[PERSON_SEX]);
                                                foreach ($personRole as $role) {
                                                    if ($role == $person[PERSON_SEX]) {
                                                        echo SEX_LABEL[$role . "_LABEL"];
                                                    }
                                                }
                                                ?>
                                            </p>

                                        </div>


                                        <?php
                                        $currentUser = getPerson(email: $_SESSION["userEmail"]);
                                        if ($currentUser[PERSON_ROLE] == ROLE_ADMIN) {
                                            ?>
                                            <div class="mb-3 form-input">
                                                <?php
                                                if (isset($person[PERSON_INTERNAL_NOTE])) {
                                                    ?>
                                                    <span class="title">Internal Note</span>
                                                    <p><?= $person[PERSON_INTERNAL_NOTE]; ?>
                                                    </p>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <!-- ROLE -->
                                        <div class="mb-3 form-input">
                                            <span class="required title">Role</span>
                                            <p>
                                                <?php
                                                $personRole = sortRole($person[PERSON_ROLE]);
                                                foreach ($personRole as $role) {
                                                    if ($role == $person[PERSON_ROLE]) {
                                                        echo ROLE_LABEL[$role . "_LABEL"];
                                                    }
                                                }
                                                ?>
                                            </p>

                                        </div>

                                        <div class="mb-3 form-input">
                                            <span class="required title">Status</span>
                                            <p>
                                                <?= translateBooleanToString($person[PERSON_STATUS]); ?>
                                            </p>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xxl-8 col-xl-8 col-lg-10 col-12">
                                            <div
                                                    class="btn-container d-flex column-gap-5 justify-content-between"
                                            >
                                                <div class="btn-wrapper d-flex column-gap-3">
                                                    <a href="persons.php?page=1"
                                                       class="btn btn-primary btn--form has-border"
                                                       type="submit"
                                                    >Back
                                                    </a>
                                                </div>
                                                <?php
                                                $user = getPerson(email: $_SESSION["userEmail"]);
                                                if ($user[PERSON_ROLE] == ROLE_ADMIN) {
                                                    ?>
                                                    <!-- Button trigger modal -->
                                                    <button type="button"
                                                            class="btn btn-primary btn--form delete-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal"
                                                    >Delete
                                                    </button>
                                                    <?php
                                                }
                                                ?>

                                                <!-- Modal -->
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
                                                                <h1 class="modal-title" id="exampleModalLabel">
                                                                    Are you sure want to delete this person?
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
                                                                    No
                                                                </button>
                                                                <button type="button" class="btn btn-primary"
                                                                        name="btnDelete">
                                                                    <a href="action/action-delete-person.php"
                                                                       class="btn">Yes</a>
                                                                </button>
                                                            </div>
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

    <!-- footer -->
<?php
mainFooter("persons.php");
unset($_SESSION["personData"]);
