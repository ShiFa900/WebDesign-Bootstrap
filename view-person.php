<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/table-3-column.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();

$persons = getAll();
$jobs = getJobs();
// get person data by given person ID
//$person = getPerson($persons, id: $_GET['person']);
$person = findFirstFromArray(array: $persons, key: ID, value: $_GET["person"]);

if ($person == null) {
    $person = getPerson($persons, $_GET["person"]);
    if ($person == null) {
        $_SESSION["error"] = "Sorry, no person found.";
        redirect("persons.php", "");
    }
}
if (isset($_SESSION["personData"])) {
    $personJob = getPersonJob($_SESSION["personData"][ID]);
} else {
    $personJob = getPersonJob($person[ID]);
}

//get person sex label for showing it
$arraySex = sortSex($person[PERSON_SEX]);
$arrayRole = sortRole($person[PERSON_ROLE]);

// get person ID when user want to delete person data
$_SESSION["personId"] = $person[ID];

// get current user
$currentUser = findFirstFromArray(array: $persons, key: PERSON_EMAIL, value: $_SESSION["userEmail"]);

if (isset($_SESSION["personData"])) {
    $personHobbies = getPersonHobbiesFromDb($_SESSION["personData"][ID]);
} else {
    $personHobbies = getPersonHobbiesFromDb($person[ID]);
}

$noun = setNoun($personHobbies, 'Hobby');
mainHeader(cssIdentifier: "page-view-person", title: "View Person", link: "view-person.php", pageStyles: ["view-person.css"]);
    ?>
    <main xmlns="http://www.w3.org/1999/html">
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
                    // this alert will show if person edit or add new data was succeeded save
                    if (isset($_SESSION["info"])) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_SESSION["info"] ?>!
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
                                                foreach ($arraySex as $sex) {
                                                    if ($sex == $person[PERSON_SEX]) {
                                                        echo SEX_LABEL[$person[PERSON_SEX] . "_LABEL"];
                                                    }
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-xl-2 col-lg-5">
                                        <div class="mb-3 form-input">
                                            <span class="required title">Status</span>
                                            <p>
                                                <?php
                                                if (isset($_SESSION["personData"][PERSON_STATUS])) {
                                                    echo translateIntToString($_SESSION["personData"][PERSON_STATUS]);
                                                } else {
                                                    echo translateIntToString($person[PERSON_STATUS]);
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <div class="mb-3 form-input">
                                            <span class="required title">Job</span>
                                            <p>
                                                <?= $personJob[JOBS_NAME] ?>
                                            </p>
                                        </div>
                                        <?php
                                        if ($currentUser[PERSON_ROLE] == ROLE_ADMIN) {
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
                                                foreach ($arrayRole as $role) {
                                                    if ($role == $person[PERSON_ROLE]) {
                                                        echo ROLE_LABEL[$person[PERSON_ROLE] . "_LABEL"];
                                                    }
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($personHobbies != null) {?>
                                <div class="subheading mb-2 mt-4">
                                    <div class="col-xxl-8">
                                        <h1 class="third-heading">
                                            <?=$noun?> list
                                        </h1>
                                    </div>
                                </div>
                                <?php
                                    tableThreeColumn(identifier: 'view-person', user: $currentUser, constName: HOBBIES_NAME, modalText: "Are you sure want to delete", array: $personHobbies, noun: 'Hobbies', personId: $person[ID]);
                                }
                                ?>
                                <div class="btn-container d-flex ">
                                    <div class="btn-wrapper d-flex column-gap-3">
                                        <a href="persons.php?"
                                           class="btn btn-primary btn--form has-border"
                                           type="submit"
                                        >Back
                                        </a>

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
                                                           class="btn pop-up-btn-hover">Yes</a>
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
    unset($_SESSION["info"]);
    unset($_SESSION["personId"]);
