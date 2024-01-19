<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/index.php";

checkRoleAdmin($_SESSION["userEmail"]);

?>

<?php
mainHeader(cssIdentifier: "page-edit-person", title: "Edit Person", link: "edit-person.php", pageStyles: ["editPerson.css"]);
?>

    <main>
        <section class="edit-section d-flex position-relative">
            <?php
            desktopSidebar("persons.php");
            ?>

            <div class="w-100">
                <div class="edit-person-content position-absolute px-5">
                    <div class="page-header">
                        <h1 class="first-heading">Edit Person Data</h1>
                    </div>

                    <div class="row">
                        <div class="col-xxl-12">

                            <?php
                            $person = getPerson(id: $_GET["person"]);
                            $_SESSION["personData"] = $person;
                            ?>
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
                                                        echo $_SESSION["personData"][PERSON_FIRST_NAME];
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
                                                        echo $_SESSION["personData"][PERSON_LAST_NAME];
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
                                                        echo $_SESSION["personData"][PERSON_NIK];
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
                                                        echo $_SESSION["personData"][PERSON_EMAIL];
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
                                                        echo date("Y-m-d", $_SESSION["personData"][PERSON_BIRTH_DATE]);
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
                                                <option selected><?php if (isset($_SESSION["userInputData"]["sex"])) {
                                                        echo $_SESSION["userInputData"]["sex"];
                                                    } else {
                                                        echo $_SESSION["personData"][PERSON_SEX];
                                                    } ?></option>
                                                <!--opsi lainnya blum muncul-->

                                                <?php
                                                if ($_SESSION["personData"][PERSON_SEX] == SEX_MALE) {
                                                    ?>
                                                    <option value="<?= SEX_FEMALE ?>"><?= SEX_FEMALE ?></option>
                                                    <option value="<?= SEX_BETTER_NOT_SAY ?>"><?= SEX_BETTER_NOT_SAY ?></option>

                                                    <?php
                                                } elseif ($_SESSION["personData"][PERSON_SEX] == SEX_FEMALE) {
                                                    ?>
                                                    <option value="<?= SEX_MALE ?>"><?= SEX_MALE ?></option>
                                                    <option value="<?= SEX_BETTER_NOT_SAY ?>"><?= SEX_BETTER_NOT_SAY ?></option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?= SEX_MALE ?>"><?= SEX_MALE ?></option>
                                                    <option value="<?= SEX_FEMALE ?>"><?= SEX_FEMALE ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                        </div>

                                        <div class="form-input mt-0">
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
                                                    if ($_SESSION["personData"][PERSON_STATUS]) {
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

                                    <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4">

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
                                                <option selected
                                                        value="<?php if (isset($_SESSION["userInputData"]["role"])) {
                                                            echo $_SESSION["userInputData"]["role"];
                                                        } else {
                                                            echo $_SESSION["personData"][PERSON_ROLE];
                                                        } ?>"><?php if (isset($_SESSION["userInputData"]["role"])) {
                                                        echo $_SESSION["userInputData"]["role"];
                                                    } else {
                                                        echo $_SESSION["personData"][PERSON_ROLE];
                                                    } ?></option>

                                                <?php
                                                if ($_SESSION["personData"][PERSON_ROLE] == ROLE_ADMIN) {
                                                    ?>
                                                    <option value="<?= ROLE_MEMBER ?>">Member</option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?= ROLE_ADMIN ?>">Admin</option>

                                                    <?php
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
                                                    name="newPassword"/>

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

<!--                                                    confirm password akan required saat new password diinput-->
<!--                                                --><?php
//                                                if (isset($_SESSION["newPassword"]) && $_SESSION["newPassword"] != null) echo "required";
//                                                ?>
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
                                    <button
                                            class="btn btn-primary btn--form"
                                            type="submit"
                                            name="btn"
                                    >
                                        Save
                                    </button>

                                    <a
                                            class="btn btn-primary btn--form has-border"
                                            type="submit"
                                            href="persons.php?page=1"
                                    >
                                        Cancel
                                    </a>
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

// unset $_SESSION
