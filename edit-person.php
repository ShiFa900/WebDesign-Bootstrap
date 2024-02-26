<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";

redirectIfNotAuthenticated();

checkRole($_SESSION["userEmail"], "ROLE_ADMIN");
$persons = getAll();
$jobs = getJobs();
$person = findFirstFromArray(array: $persons, key: ID, value: $_GET['person']);
$getPersonJob = getPersonJob($person[ID]);
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
                                        <div class="mb-3 form-input">
                                            <label for="f-name" class="form-label required"
                                            >First Name</label
                                            >

                                            <input
                                                    id="f-name"
                                                    type="text"
                                                    value="<?php if (isset($_SESSION["userInputData"]["firstName"])) {
                                                        echo $_SESSION["userInputData"]["firstName"];
                                                    } else {
                                                        echo $person[PERSON_FIRST_NAME];
                                                    } ?>"
                                                    required
                                                    class="form-control"
                                                    name="firstName"
                                                    maxlength="30"

                                            />
                                        </div>
                                        <div class="mb-3 form-input">
                                            <label for="l-name" class="form-label">Last Name</label>

                                            <input
                                                    id="l-name"
                                                    type="text"
                                                    value="<?php if (isset($_SESSION["userInputData"]["lastName"])) {
                                                        echo $_SESSION["userInputData"]["lastName"];
                                                    } else {
                                                        echo $person[PERSON_LAST_NAME];
                                                    } ?>"
                                                    class="form-control"
                                                    name="lastName"
                                                    maxlength="15"
                                            />
                                        </div>
                                        <div class="mb-3 form-input">
                                            <label for="nik" class="form-label required">NIK</label>
                                            <input
                                                    id="nik"
                                                    type="text"
                                                    value="<?php if (isset($_SESSION["userInputData"]["nik"])) {
                                                        echo $_SESSION["userInputData"]["nik"];
                                                    } else {
                                                        echo $person[PERSON_NIK];
                                                    } ?>"
                                                    required
                                                    class="form-control"
                                                    name="nik"
                                                    maxlength="16"
                                                    minlength="16"
                                            />
                                            <?php
                                            if (isset($_SESSION["errorData"]["errorNik"])) {
                                                ?>

                                                <div class="alert alert-danger" role="alert">
                                                    <?= $_SESSION["errorData"]["errorNik"] ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="mb-3 form-input">
                                            <label for="staticEmail" class="form-label required"
                                            >Email</label
                                            >
                                            <input
                                                    id="staticEmail"
                                                    type="email"
                                                    value="<?php if (isset($_SESSION["userInputData"]["email"])) {
                                                        echo $_SESSION["userInputData"]["email"];
                                                    } else {
                                                        echo $person[PERSON_EMAIL];
                                                    } ?>"
                                                    required
                                                    class="form-control"
                                                    name="email"
                                            />
                                            <?php
                                            if (isset($_SESSION["errorData"]["errorEmail"])) {
                                                ?>

                                                <div class="alert alert-danger" role="alert">
                                                    <?= $_SESSION["errorData"]["errorEmail"] ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="mb-3 form-input">
                                            <label for="datePicker" class="form-label required"
                                            >Date of Birth</label
                                            >
                                            <input
                                                    id="datePicker"
                                                    type="date"
                                                    value="<?php if (isset($_SESSION["userInputData"]["birthDate"])) {
                                                        echo $_SESSION["userInputData"]["birthDate"];
                                                    } else {
                                                        echo date("Y-m-d", $person[PERSON_BIRTH_DATE]);
                                                    } ?>"
                                                    required
                                                    class="form-control"
                                                    name="birthDate"
                                            />
                                            <?php
                                            if (isset($_SESSION["errorData"]["errorBirthDate"])) {
                                                ?>

                                                <div class="alert alert-danger" role="alert">
                                                    <?= $_SESSION["errorData"]["errorBirthDate"] ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <div class="mb-3 form-input">
                                            <label class="form-label required" for="sex-dropdown"
                                            >Sex</label
                                            >
                                            <select
                                                    class="form-select form-control"
                                                    id="sex-dropdown"
                                                    required
                                                    aria-label="Small select example"
                                                    name="sex"
                                            >
                                                <?php
                                                if (isset($_SESSION["userInputData"]["sex"])) {
                                                    $arraySex = sortSex($_SESSION["userInputData"]["sex"]);
                                                    foreach ($arraySex as $sex) { ?>
                                                        <option
                                                                value="<?= $sex ?>"<?php if ($sex === $_SESSION["userInputData"]["sex"]) echo "selected" ?>>
                                                            <?= SEX_LABEL[$sex . "_LABEL"] ?></option>
                                                        }
                                                        <?php
                                                    }
                                                } else {
                                                    foreach ($arraySex as $sex) {
                                                        ?>
                                                        <option
                                                                value="<?= $sex ?>"<?php if ($sex === $person[PERSON_SEX]) echo "selected" ?>>
                                                            <?= SEX_LABEL[$sex . "_LABEL"] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>

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
                                        <a href="hobbies.php?person=<?= $person[ID] ?>" class="nav-link mt-1 mb-3">
                                            <div style="fill: #000000" class="">
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
                                                <span class="ps-2">Manage person hobby</span>
                                            </div>
                                        </a>
                                        <div class="mb-3 form-input">
                                            <label class="form-label required" for="job-dropdown">Job</label>
                                            <select id="job-dropdown" class="form-select form-control"
                                                    aria-label="Small select example" name="jobName">
                                                <!-- dropdwon pekerjaan nanti value-nya akan diisi dari database jobs, dan data dari database akan increment jika jobs di create new-->
                                                <?php
                                                foreach ($jobs as $job) {
                                                    ?>
                                                    <option value="<?= $job[JOBS_NAME] ?>" <?php if ($job[JOBS_NAME] === $getPersonJob[JOBS_NAME]) echo "selected" ?>>
                                                        <?= $job[JOBS_NAME] ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <a href="add-job.php" class="nav-link mt-1 add-icon">
                                                <div style="fill: #000000">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon"
                                                         viewBox="0 0 512 512">
                                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="32"
                                                              d="M256 112v288M400 256H112"/>
                                                    </svg>
                                                    Create new option
                                                </div>
                                            </a>
                                        </div>
                                        <div class="mb-4 form-input">
                                            <label class="form-label" for="role-dropdown"
                                            >Role</label
                                            >
                                            <select
                                                    id="role-dropdown"
                                                    class="form-select form-control"
                                                    aria-label="Small select example"
                                                    name="role"
                                            >
                                                <?php
                                                if (isset($_SESSION["userInputData"]["role"])) {
                                                    $arrayRole = sortRole($_SESSION["userInputData"]["role"]);
                                                    foreach ($arrayRole as $role) {
                                                        ?>
                                                        <option
                                                                value="<?= $role ?>"<?php if ($role === $_SESSION["inputData"]["role"]) echo "selected" ?>>
                                                            <?= ROLE_LABEL[$role . "_LABEL"] ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    foreach ($arrayRole as $role) {
                                                        ?>
                                                        <option
                                                                value="<?= $role ?>"<?php if ($role === $person[PERSON_ROLE]) echo "selected" ?>>
                                                            <?= ROLE_LABEL[$role . "_LABEL"] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 form-input-add-person">
                                            <label for="note" class="form-label"
                                            >Internal notes</label
                                            >
                                            <div class="form-floating mb-4">
                                              <textarea
                                                      class="form-control"
                                                      placeholder="Leave a comment here"
                                                      id="note"
                                                      name="note"
                                                      value="<?php if (isset($_SESSION["userInputData"]["note"])) {
                                                          echo $_SESSION["userInputData"]["note"];
                                                      } else {
                                                          echo $person[PERSON_INTERNAL_NOTE];;
                                                      } ?>"
                                              ></textarea>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="mb-3 form-input">
                                            <label for="newPass" class="form-label ">New Password</label>
                                            <input
                                                    id="newPass"
                                                    type="password"
                                                    class="form-control"
                                                    name="newPassword"
                                                    minlength="8"/>

                                            <?php
                                            if (isset($_SESSION["errorData"]["errorPassword"])) {
                                                ?>
                                                <div class="alert alert-danger errorText" role="alert">
                                                    <?= $_SESSION["errorData"]["errorPassword"] ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="mb-3 form-input">
                                            <label for="confirmPass" class="form-label">Confirm Password </label>
                                            <input
                                                    id="confirmPass"
                                                    type="password"
                                                    class="form-control"
                                                    name="confirmPassword"/>

                                            <?php
                                            if (isset($_SESSION["errorData"]["errorConfirm"])) {
                                                ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <?= $_SESSION["errorData"]["errorConfirm"] ?>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
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

