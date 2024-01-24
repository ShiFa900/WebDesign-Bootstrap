<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/index.php";
//require_once __DIR__ . "/action/action-view-person.php";

// get person data by given person ID
$person = getPerson(id: $_GET["person"]);
if ($person == null) {
    $_SESSION["personNotFound"] = $person;
    redirect("persons.php", "");

} else {
    mainHeader(cssIdentifier: "page-view-person", title: "View Person", link: "view-person.php", pageStyles: ["view-person.css"]);

    //get person sex label for showing it
    $personSex = sortSex($person[PERSON_SEX]);
    foreach ($personSex as $sex) {
        if ($sex == $person[PERSON_SEX]) {
            $userSex = SEX_LABEL[$sex . "_LABEL"];
        }
    }

    $personRole = sortRole($person[PERSON_ROLE]);
    foreach ($personRole as $role) {
        if ($role == $person[PERSON_ROLE]) {
            $userRole = ROLE_LABEL[$role . "_LABEL"];
        }
    }
// get person ID when user want to delete person data
    $_SESSION["personId"] = $person[ID];

}
// get current user
$currentUser = getPerson(email: $_SESSION["userEmail"]);

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
                    <?php
                    // this alert will show if person edit data was succeeded save
                    if (isset($_SESSION["editSuccess"])) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            Successfully edit person data of <?= $_SESSION["personHasEdit"][PERSON_FIRST_NAME] ?>!
                        </div>
                        <?php
                    } elseif (isset($_SESSION["addSuccess"])) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            <?= $person[PERSON_FIRST_NAME] ?> was successfully added to Person Management App!
                        </div>
                        <?php
                    }
                    ?>


                    <div class="row">
                        <div class="col-xxl-12">
                            <form class="new-person-form" action="#" method="post">
                                <div class="row">

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 me-4">
                                        <div class="mb-3 form-input">

                                            <span class="required title">First Name</span>
                                            <p>
                                                <?php
                                                if (isset($_SESSION["personData"][PERSON_FIRST_NAME])) {
                                                    echo $_SESSION["personData"][PERSON_FIRST_NAME];
                                                } else {
                                                    echo $person[PERSON_FIRST_NAME];
                                                }
                                                ?>
                                            </p>
                                        </div>

                                        <?php
                                        // showing person last name if person have it
                                        if ($person[PERSON_LAST_NAME] != "") {
                                            ?>
                                            <div class="mb-3 form-input">

                                                <span class="title">Last Name</span>
                                                <p>
                                                    <?php
                                                    if (isset($_SESSION["personData"][PERSON_LAST_NAME])) {
                                                        echo $_SESSION["personData"][PERSON_LAST_NAME];
                                                    } else {
                                                        echo $person[PERSON_LAST_NAME];
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <div class="mb-3 form-input">
                                            <span class="required title">NIK</span>
                                            <p>
                                                <?php
                                                if (isset($_SESSION["personData"][PERSON_NIK])) {
                                                    echo $_SESSION["personData"][PERSON_NIK];
                                                } else {
                                                    echo $person[PERSON_NIK];
                                                }
                                                ?>
                                            </p>

                                        </div>
                                        <div class="mb-3 form-input">
                                            <span class="required title">Email</span>
                                            <p>
                                                <?php
                                                if (isset($_SESSION["personData"][PERSON_EMAIL])) {
                                                    echo $_SESSION["personData"][PERSON_EMAIL];
                                                } else {
                                                    echo $person[PERSON_EMAIL];
                                                }
                                                ?>
                                            </p>

                                        </div>

                                        <div class="mb-3 form-input">
                                            <span class="required title">Birth Of Date</span>
                                            <p>
                                                <?php
                                                if (isset($_SESSION["personData"][PERSON_BIRTH_DATE])) {
                                                    echo date("d F Y", $_SESSION["personData"][PERSON_BIRTH_DATE]);
                                                } else {
                                                    echo date("d F Y", $person[PERSON_BIRTH_DATE]);
                                                }
                                                ?>
                                            </p>

                                        </div>

                                        <div class="mb-3 form-input">
                                            <span class="required title">Sex</span>
                                            <p>
                                                <?php
                                                echo $userSex;
                                                ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxl-5 col-xl-2 col-lg-5">
                                        <?php
                                        if ($currentUser[PERSON_ROLE] == ROLE_ADMIN) {
                                            ?>
                                            <?php
                                            if (isset($_SESSION["personData"][PERSON_INTERNAL_NOTE])) {
                                                ?>
                                                <div class="mb-3 form-input">

                                                    <span class="title">Internal Note</span>
                                                    <p><?= $_SESSION["personData"][PERSON_INTERNAL_NOTE]; ?>
                                                    </p>
                                                </div>
                                                <?php
                                            } else {
                                                if (isset($person[PERSON_INTERNAL_NOTE])) {
                                                    ?>
                                                    <div class="mb-3 form-input">

                                                        <span class="title">Internal Note</span>
                                                        <p><?= $person[PERSON_INTERNAL_NOTE]; ?>
                                                        </p>
                                                    </div>
                                                    <?php
                                                }

                                            }
                                        }
                                        ?>

                                        <!-- ROLE -->
                                        <div class="mb-3 form-input">
                                            <span class="required title">Role</span>
                                            <p>
                                                <?php
                                                echo $userRole;
                                                ?>
                                            </p>

                                        </div>

                                        <div class="mb-3 form-input">
                                            <span class="required title">Status</span>
                                            <p>
                                                <?php
                                                if (isset($_SESSION["personData"][PERSON_STATUS])) {
                                                    echo translateBooleanToString($_SESSION["personData"][PERSON_STATUS]);
                                                } else {
                                                    echo translateBooleanToString($person[PERSON_STATUS]);
                                                }
                                                ?>
                                            </p>

                                        </div>
                                    </div>
                                </div>

                                <div
                                        class="btn-container d-flex column-gap-5"
                                >
                                    <div class="btn-wrapper d-flex">
                                        <a href="persons.php?page=1"
                                           class="btn btn-primary btn--form has-border"
                                           type="submit"
                                        >Back
                                        </a>
                                    </div>
                                    <div class="wrapper d-flex column-gap-3">
                                        <?php
                                        // only admin can delete person data
                                        if ($currentUser[PERSON_ROLE] == ROLE_ADMIN) {
                                            ?>
                                            <div class="btn-wrapper ">
                                                <a href="edit-person.php?person=<?= $person[ID] ?>"
                                                   class="btn btn-primary btn--form"
                                                   type="submit"
                                                >Edit
                                                </a>
                                            </div>

                                            <!-- Button trigger modal -->
                                            <button type="button"
                                                    class="btn btn-primary delete-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal"
                                            >Delete
                                            </button>

                                            <?php
                                        }
                                        ?>
                                    </div>

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
// unset all session if user switch to other page
unset($_SESSION["personData"]);
unset($_SESSION["editSuccess"]);
unset($_SESSION["personHasEdit"]);
unset($_SESSION["personNotFound"]);
