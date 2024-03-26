<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/inputForm.php";

redirectIfNotAuthenticated();

checkRole($_SESSION["userEmail"], "ROLE_ADMIN");
$jobs = getJobs();
$person = findFirstFromArray(tableName: 'persons', key: ID, value: $_GET['person']);
$user = findFirstFromArray(tableName: 'persons',key: PERSON_EMAIL,value: $_SESSION["userEmail"]);
$user = setPersonValueFromDb($user);
$person = setPersonValueFromDb($person);
// get person data to be edited
$_SESSION["personData"] = $person;

if ($person == null) {
    $_SESSION["error"] = "Sorry, no person found.";
    redirect("persons.php", "");
}
mainHeader(cssIdentifier: "page-edit-person", title: "Edit Person", link: "edit-person.php", pageStyles: ["editPerson.css"]);

// sort person role when edited
$arraySex = sortSex($person[PERSON_SEX]);
$arrayRole = sortRole($person[PERSON_ROLE]);
?>
    <main>
        <section class="edit-section d-flex position-relative">
            <?php
            desktopSidebar("persons.php");
            ?>

            <div class="w-100">
                <div class="edit-person-content position-absolute px-5">
                    <div class="page-header content-wrapper">
                        <h1 class="first-heading">Edit Person Data</h1>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12">

                            <form class="edit-person-form" action="action/action-edit-person.php" method="post"
                                  name="editPerson">
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 me-4">
                                        <?php
                                        if (isset($_SESSION['userInputData']) && isset($_SESSION['errorData'])) {
                                            formInputValues(person: $person, userRole: $person[PERSON_ROLE], arraySex: $arraySex, jobs: $jobs, userInputData: $_SESSION['userInputData'], errorData: $_SESSION['errorData']);
                                        } else {
                                            formInputValues(person: $person, userRole: $person[PERSON_ROLE], arraySex: $arraySex, jobs: $jobs);
                                        }
                                        ?>
                                        <div class="form-input mt-0 mb-3">
                                            <div
                                                    class="form-check form-switch d-flex align-items-center column-gap-3"
                                            >
                                                <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        role="switch"
                                                        id="flexSwitchCheckDefault"
                                                        name="status"
                                                    <?php
                                                    if ($person[PERSON_STATUS]) {
                                                        ?>
                                                        checked
                                                        <?php
                                                    }
                                                    ?>
                                                />
                                                <label
                                                        class="form-check-label"
                                                        for="flexSwitchCheckDefault"
                                                >This person is alive</label
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-5 col-xl-5 col-lg-5">
                                        <?php
                                        if (isset($_SESSION["userInputData"]) && isset($_SESSION["errorData"])) {
                                            formInputValuesOnRight(person: $person, arrayRole: $arrayRole,  user: $user[PERSON_ROLE], userInputData: $_SESSION["userInputData"], errorData: $_SESSION["errorData"]);
                                        } else {
                                            formInputValuesOnRight(person: $person, arrayRole: $arrayRole, user: $user[PERSON_ROLE]);
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="btn-container d-flex column-gap-3">
                                    <a
                                            class="btn btn-primary btn--form has-border"
                                            type="submit"
                                            href="persons.php?page=1"
                                    >
                                        Cancel
                                    </a>

                                    <button
                                            class="btn btn-primary btn--form"
                                            type="submit"
                                            name="btn"
                                    >
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- sidebar -->
<?php
mainFooter("persons.php");
unset($_SESSION["userInputData"]);
unset($_SESSION["errorData"]);
//unset($_SESSION["personData"]);

