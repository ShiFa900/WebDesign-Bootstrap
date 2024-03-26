<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/table-3-column.php";
require_once __DIR__ . "/include/inputForm.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();

$jobs = getJobs();
// get person data by given person ID
//$person = getPerson($persons, id: $_GET['person']);
$person = findFirstFromArray(tableName: 'persons', key: ID, value: $_GET["person"]);

if ($person == null) {
    $_SESSION["error"] = "Sorry, no person found.";
    redirect("persons.php", "");
} else {
    $person = setPersonValueFromDb($person);
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
$currentUser = findFirstFromArray(tableName: 'persons', key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
$currentUser = setPersonValueFromDb($currentUser);

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
                                    <?php
                                    if (isset($_SESSION["personData"])) {
                                        showTextValue(person: $person, arraySex: $arraySex, arrayRole: $arrayRole, personJob: $personJob[JOBS_NAME], userRole: $currentUser[PERSON_ROLE], personData: $_SESSION["personData"]);
                                    } else {
                                        showTextValue(person: $person, arraySex: $arraySex, arrayRole: $arrayRole, personJob: $personJob[JOBS_NAME], userRole: $currentUser[PERSON_ROLE]);
                                    }
                                    ?>

                                </div>
                                <?php
                                if ($personHobbies != null) { ?>
                                    <div class="subheading mb-2 mt-4">
                                        <div class="col-xxl-8">
                                            <h1 class="third-heading">
                                                <?= $noun ?> list
                                            </h1>
                                        </div>
                                    </div>
                                    <?php
                                    tableThreeColumn(identifier: 'page-view-person', user: $currentUser, constName: HOBBIES_NAME, modalText: "Are you sure want to delete", array: $personHobbies, noun: $noun, personId: $person[ID]);
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
                                                        <a href="action/action-delete-person.php?person=<?= $person[ID] ?>"
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
