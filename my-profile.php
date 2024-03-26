<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/table-3-column.php";
require_once __DIR__ . "/include/inputForm.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();

mainHeader(cssIdentifier: "page-my-profile", title: "My Profile", link: "my-profile.php", pageStyles: ["my-profile.css"]);

$jobs = getJobs();
// get user data by given email
//$person = getPerson(persons: $persons, email: $_SESSION["userEmail"]);
$person = findFirstFromDb(tableName: 'persons', key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
if ($person !== null) {
    $person = setPersonValueFromDb($person);
}

$_SESSION["userData"] = $person;

// get user job
$getPersonJob = getPersonJob($person[ID]);

$arraySex = sortSex($person[PERSON_SEX]);
// get user role label for role form
$arrayRole = sortRole($person[PERSON_ROLE]);
$personHobbies = getPersonHobbiesFromDb(personId: $person[ID]);
$noun = setNoun(array: $personHobbies, text: 'Hobby');
?>
    <main>
        <section class="profile-section d-flex position-relative">
            <?php
            desktopSidebar("my-profile.php");
            ?>
            <div class="w-100">
                <div class="my-profile-content position-absolute px-5">
                    <div class="page-header content-wrapper">
                        <h1 class="first-heading">My profile</h1>
                    </div>
                    <?php
                    if (isset($_SESSION["editMyProfile"])) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_SESSION["editMyProfile"] ?>
                        </div>
                        <?php
                    }
                    ?>


                    <form class="my-profile-form" action="action/action-my-profile.php" method="post">
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 me-4">
                                <?php
                                if (isset($_SESSION['userInputData']) && isset($_SESSION['errorData'])) {
                                    formInputValues(person: $person, userRole: $person[PERSON_ROLE], arraySex: $arraySex, jobs: $jobs, userInputData: $_SESSION['userInputData'], errorData: $_SESSION['errorData']);
                                } else {
                                    formInputValues(person: $person, userRole: $person[PERSON_ROLE], arraySex: $arraySex, jobs: $jobs);

                                }
                                ?>
                            </div>
                            <div class="col-xxl-5 col-xl-5 col-lg-5">
                                <?php
                                showGetRoleAndNote(arrayRole: $arrayRole, person: $person, user: $person[PERSON_ROLE], userInputData: $_SESSION["userInputData"]);
                                ?>

                                <div class="mb-3 form-input mt-4">
                                    <hr/>
                                    <label for="currentPass" class="form-label">Current Password</label>
                                    <input
                                            id="currentPass"
                                            type="password"
                                            class="form-control"
                                            name="currentPassword"
                                    />
                                    <?php
                                    if (isset($_SESSION["errorData"]["errorCurrentPassword"])) {
                                        ?>
                                        <div class="alert alert-danger errorText" role="alert">
                                            <?= $_SESSION["errorData"]["errorCurrentPassword"] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                showPassForm($_SESSION["errorData"]);
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
                                tableThreeColumn(identifier: 'page-my-profile', user: $person, constName: HOBBIES_NAME, modalText: "Are you sure want to delete", array: $personHobbies, noun: $noun, personId: $person[ID]);
                            } else {
                                ?>
                                <a href="add-hobby.php?person=<?= $person[ID] ?>" class="nav-link mt-1 mb-3">
                                    <div style="fill: #000000">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon"
                                             viewBox="0 0 512 512">
                                            <path d="M467.51 248.83c-18.4-83.18-45.69-136.24-89.43-149.17A91.5 91.5 0 00352 96c-26.89 0-48.11 16-96 16s-69.15-16-96-16a99.09 99.09 0 00-27.2 3.66C89 112.59 61.94 165.7 43.33 248.83c-19 84.91-15.56 152 21.58 164.88 26 9 49.25-9.61 71.27-37 25-31.2 55.79-40.8 119.82-40.8s93.62 9.6 118.66 40.8c22 27.41 46.11 45.79 71.42 37.16 41.02-14.01 40.44-79.13 21.43-165.04z"
                                                  fill="none" stroke="currentColor" stroke-miterlimit="10"
                                                  stroke-width="32"/>
                                            <circle cx="292" cy="224" r="20"/>
                                            <path d="M336 288a20 20 0 1120-19.95A20 20 0 01336 288z"/>
                                            <circle cx="336" cy="180" r="20"/>
                                            <circle cx="380" cy="224" r="20"/>
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                  stroke-linejoin="round" stroke-width="32"
                                                  d="M160 176v96M208 224h-96"/>
                                        </svg>
                                        <span class="ps-2">Add your first hobby</span>
                                    </div>
                                </a>
                                <?php
                            }
                            ?>
                            <div class="btn-container d-flex column-gap-3 justify-content-start">
                                <a class="btn btn-primary btn--form has-border"
                                   type="submit"
                                   href="persons.php"
                                >
                                    Cancel
                                </a>
                                <button
                                        class="btn btn-primary btn--form"
                                        type="submit" name="btn">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- sidebar -->
<?php
mainFooter("my-profile.php");
// unset all session if user switch to other page
unset($_SESSION["userInputData"]);
unset($_SESSION["errorData"]);
unset($_SESSION["editMyProfile"]);
unset($_SESSION["personData"]);