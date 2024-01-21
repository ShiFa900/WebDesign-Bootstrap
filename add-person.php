<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/index.php";

checkRoleAdmin($_SESSION["userEmail"]);

?>

<?php
mainHeader(cssIdentifier: "page-add-person", title: "Add Person", link: "add-person.php", pageStyles: ["add-person.css"]);
?>
    <main>
        <section class="add-person-section d-flex position-relative">
            <!-- desktop sidebar -->
            <?php desktopSidebar("persons.php"); ?>

            <div class="w-100">
                <div class="add-person-content position-absolute px-5">
                    <div class="page-header">
                        <h1 class="first-heading">Add Person</h1>
                    </div
                </div>
                <div class="row">
                    <div class="col-xxl-12">
                        <form class="new-person-form" action="action/action-add-person.php" method="post"
                              name="addPerson">
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 new-person-form">

                                    <div class="mb-3 form-input-add-person">
                                        <label for="f-name" class="form-label required"

                                        >First Name</label
                                        >
                                        <input
                                                id="f-name"
                                                type="text"
                                                placeholder="First name"
                                                required
                                                class="form-control"
                                                name="firstName"
                                                maxlength="30"
                                                value="<?php if (isset($_SESSION["inputData"])) {
                                                    echo $_SESSION["inputData"]["firstName"];
                                                } ?>"
                                        />
                                    </div>
                                    <div class="mb-3 form-input-add-person">
                                        <label for="l-name" class="form-label">Last Name</label>

                                        <input
                                                id="l-name"
                                                type="text"
                                                placeholder="Last name"
                                                class="form-control"
                                                name="lastName"
                                                maxlength="15"
                                                value="<?php if (isset($_SESSION["inputData"])) {
                                                    echo $_SESSION["inputData"]["lastName"];
                                                } ?>"

                                        />
                                    </div>
                                    <div class="mb-3 form-input-add-person">
                                        <label for="nik" class="form-label required">NIK</label>
                                        <input
                                                id="nik"
                                                type="text"
                                                placeholder="NIK"
                                                required
                                                class="form-control"
                                                name="nik"
                                                maxlength="16"
                                                minlength="16"
                                                value="<?php if (isset($_SESSION["inputData"])) {
                                                    echo $_SESSION["inputData"]["nik"];
                                                } ?>"

                                        />
                                        <?php
                                        if (isset($_SESSION["errorData"]["errorNik"])) {
                                            ?>

                                            <div class="alert alert-danger" role="alert">
                                                <?= $_SESSION["errorData"]["errorNik"] ?>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="smallText"><em>NIK must be at least 16 characters</em></span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="mb-3 form-input-add-person">
                                        <label for="staticEmail" class="form-label required"
                                        >Email</label
                                        >
                                        <input
                                                id="staticEmail"
                                                type="email"
                                                placeholder="Email"
                                                required
                                                class="form-control"
                                                name="email"
                                                value="<?php if (isset($_SESSION["inputData"])) {
                                                    echo $_SESSION["inputData"]["email"];
                                                } ?>"

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

                                    <div class="mb-3 form-input-add-person">
                                        <label for="datePicker" class="form-label required"
                                        >Date of Birth</label
                                        >
                                        <input
                                                id="datePicker"
                                                type="date"
                                                placeholder="Date of birth"
                                                required
                                                class="form-control"
                                                name="birthDate"
                                                value="<?php if (isset($_SESSION["inputData"])) {
                                                    echo $_SESSION["inputData"]["birthDate"];
                                                } ?>"
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

                                    <div class="mb-3 form-input-add-person">
                                        <label class="form-label required" for="sex-dropdown"
                                        >Sex</label
                                        >
                                        <select
                                                class="form-select form-control "
                                                id="sex-dropdown"
                                                required
                                                aria-label="Small select example"
                                                name="sex"
                                        >
                                            <?php
                                            if (isset($_SESSION["inputData"]["sex"])) {
                                                ?>
                                                <option selected
                                                        value="<?= $_SESSION["inputData"]["sex"] ?>"><?php if ($_SESSION["inputData"]["sex"] == SEX_MALE) {
                                                        echo SEX_MALE;
                                                    } else {
                                                        echo SEX_FEMALE;
                                                    } ?></option>
                                                <?php

//                                            ?>
                                                <?php
                                            } else { ?>
                                                <option selected value="<?= SEX_MALE ?>"><?= SEX_MALE ?></option>
                                                <?php
                                            }

                                            if (isset($_SESSION["inputData"]["sex"]) == SEX_FEMALE) {
                                                ?>
                                                <option value="<?= SEX_MALE ?>"><?= SEX_MALE ?></option>
                                                <option value="<?= SEX_BETTER_NOT_SAY ?>"><?= SEX_BETTER_NOT_SAY ?></option>

                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= SEX_FEMALE ?>"><?= SEX_FEMALE ?></option>
                                                <option value="<?= SEX_BETTER_NOT_SAY ?>"><?= SEX_BETTER_NOT_SAY ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-input-add-person mt-0">
                                        <div
                                                class="form-check form-switch d-flex align-items-center column-gap-3"
                                        >
                                            <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    role="switch"
                                                    id="flexSwitchCheckDefault"
                                                    name="status"
                                            />
                                            <label
                                                    class="form-check-label"
                                                    for="flexSwitchCheckDefault"
                                            >This person is alive</label
                                            >
                                        </div>
                                    </div>

                                </div>

                                <div class="col-xxl-5 col-xl-6 col-lg-6 new-person-form">
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
                                                      aria-placeholder="Take a note here..."
                                              ></textarea>
                                        </div>
                                        <hr/>
                                    </div>

                                    <!--password-->
                                    <div class="mb-3 form-input-add-person">
                                        <label for="pass" class="form-label required">Password</label>
                                        <input
                                                id="pass"
                                                type="password"
                                                required
                                                class="form-control"
                                                name="password"/>
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

                                    <!--konfirmasi password-->
                                    <div class="mb-3 form-input-add-person">
                                        <label for="confirm-pass" class="form-label required">Confirm Your
                                            Password</label>
                                        <input
                                                id="confirm-pass"
                                                type="password"
                                                required
                                                class="form-control"
                                                name="confirmPass"
                                        />
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

                                    <div class="mb-3 form-input-add-person">
                                        <label class="form-label required" for="role-dropdown"
                                        >Role</label
                                        >
                                        <select
                                                id="role-dropdown"
                                                class="form-select form-control"
                                                required
                                                aria-label="Small select example"
                                                name="role"

                                        >
                                            <?php
                                            if (isset($_SESSION["inputData"]["role"])) {
                                                ?>
                                                <option selected
                                                        value="<?= $_SESSION["inputData"]["role"] ?>"><?= $_SESSION["inputData"]["role"]; ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option selected value="<?= ROLE_ADMIN ?>">Admin</option>

                                                <?php
                                            }
                                            if ($_SESSION["inputData"]["role"] == ROLE_MEMBER) {
                                                ?>
                                                <option value="<?= ROLE_ADMIN ?>"><?= ROLE_ADMIN ?></option>

                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?= ROLE_MEMBER ?>"><?= ROLE_MEMBER ?></option>

                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="btn-container d-flex column-gap-5">
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
                                        href="persons.php"
                                >
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- mobile sidebar -->
<?php mainFooter("persons.php"); ?>
<?php

unset($_SESSION["inputData"]);
unset($_SESSION["errorData"]);


