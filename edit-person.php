<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";

redirectIfNotAuthenticated();

checkRole($_SESSION["userEmail"], "ROLE_ADMIN");
$persons = getAll();
$person = findFirstFromArray(array: $persons, key: ID, value: $_GET['person']);
// get person data to be edited
$_SESSION["personData"] = $person;

if ($person == null) {
    $_SESSION["personNotFound"] = "Sorry, no person found.";
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

                            <form class="new-person-form" action="action/action-edit-person.php" method="post"
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

