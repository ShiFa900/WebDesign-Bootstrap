<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/table-3-column.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();

mainHeader(cssIdentifier: "page-my-profile", title: "My Profile", link: "my-profile.php", pageStyles: ["my-profile.css"]);

$persons = getAll();
$jobs = getJobs();
// get user data by given email
//$person = getPerson(persons: $persons, email: $_SESSION["userEmail"]);
$person = findFirstFromArray(array: $persons, key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
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
                                <div class="mb-3 form-input">
                                    <label for="f-name" class="form-label required"
                                    >First name</label>
                                    <input
                                            id="f-name"
                                            type="text"
                                            value="<?php if (isset($_SESSION["userInputData"]["firstName"])) {
                                                echo $_SESSION["userInputData"]["firstName"];
                                            } else {
                                                echo $person[PERSON_FIRST_NAME];
                                            } ?>"
                                            class="form-control"
                                            name="firstName"
                                            maxlength="30"
                                    />
                                </div>
                                <?php
                                if (isset($person["lastName"])) {
                                    ?>

                                    <div class="mb-3 form-input">

                                        <label for="l-name" class="form-label">Last name</label>
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
                                    <?php
                                }
                                ?>
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
                                            class="form-control form-input"
                                            name="nik"
                                            maxlength="16"
                                            minlength="16"
                                    />
                                    <?php
                                    if (isset($_SESSION["errorData"]["errorNik"])) {
                                        ?>
                                        <div class="alert alert-danger errorText" role="alert">
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
                                            class="form-control"
                                            name="email"
                                    />
                                    <?php
                                    if (isset($_SESSION["errorData"]["errorEmail"])) {
                                        ?>
                                        <div class="alert alert-danger errorText" role="alert">
                                            <?= $_SESSION["errorData"]["errorEmail"] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="mb-3 form-input">
                                    <label for="datePicker" class="form-label required"
                                    >Date of birth</label
                                    >
                                    <input
                                            id="datePicker"
                                            type="date"
                                            class="form-control"
                                            value="<?php if (isset($_SESSION["userInputData"]["birthDate"])) {
                                                echo $_SESSION["userInputData"]["birthDate"];
                                            } else {
                                                echo date("Y-m-d", $person[PERSON_BIRTH_DATE]);
                                            } ?>"
                                            name="birthDate"
                                    />
                                    <?php
                                    if (isset($_SESSION["errorData"]["errorBirthDate"])) {
                                        ?>
                                        <div class="alert alert-danger errorText" role="alert">
                                            <?= $_SESSION["errorData"]["errorBirthDate"] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="mb-3 form-input">
                                    <label for="sex-dropdown" class="form-label required"
                                    >Sex</label>
                                    <select
                                            id="sex-dropdown"
                                            class="form-select form-control"
                                            required
                                            aria-label="Small select example"
                                            name="sex"

                                    >
                                        <?php
                                        if (isset($_SESSION["userInputData"])) {
                                            $arraySex = sortSex($_SESSION["userInputData"]["sex"]);
                                            foreach ($arraySex as $sex) { ?>
                                                <option
                                                        value="<?= $sex ?>"<?php if ($sex == $_SESSION["userInputData"]["sex"]) echo "selected" ?>
                                                ><?= SEX_LABEL[$sex . "_LABEL"] ?></option>
                                                }
                                                <?php
                                            }
                                        } else {
                                            foreach ($arraySex as $sex) {
                                                ?>
                                                <option
                                                        value="<?= $sex ?>"<?php if ($sex == $person[PERSON_SEX]) echo "selected" ?>
                                                ><?= SEX_LABEL[$sex . "_LABEL"] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
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
                                        <a href="add-job.php" class="nav-link mt-2 add-icon">
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
                                </div>

                            </div>
                            <div class="col-xxl-5 col-xl-5 col-lg-5">
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
                                <?php
                                if ($person[PERSON_ROLE] == ROLE_ADMIN) {
                                    if ($person[PERSON_INTERNAL_NOTE] != null) {
                                        ?>
                                        <div class="mb-3 form-input">
                                            <label for="note" class="form-label"
                                            >Internal notes</label>
                                            <div class="form-floating mb-4">
                                              <textarea
                                                      class="form-control"
                                                      placeholder="Leave a comment here"
                                                      id="note"
                                                      name="note"
                                              ><?php
                                                  if (isset($_SESSION["userInputData"])) {
                                                      echo $_SESSION["userInputData"]["note"];
                                                  } else {
                                                      echo $person[PERSON_INTERNAL_NOTE];
                                                  } ?></textarea>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
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
                                <div class="mb-3 form-input">
                                    <label for="newPass" class="form-label ">New Password</label>
                                    <input
                                            id="newPass"
                                            type="password"
                                            class="form-control"
                                            name="newPassword"
                                            minlength="8"

                                    />
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
                                        <div class="alert alert-danger errorText" role="alert">
                                            <?= $_SESSION["errorData"]["errorConfirm"] ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
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
