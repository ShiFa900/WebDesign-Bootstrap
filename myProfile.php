<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/index.php";

?>
<?php
mainHeader(cssIdentifier: "page-my-profile", title: "My Profile", link: "myProfile.php", pageStyles: ["myProfile.css"]);
?>

    <main>
        <section class="profile-section d-flex position-relative">
            <?php
            desktopSidebar("myProfile.php");
            ?>

            <div class="w-100">
                <div class="my-profile-content position-absolute px-5">
                    <div class="page-header">
                        <h1 class="first-heading">My profile</h1>
                    </div>

                    <form class="new-person-form" action="action/actionMyProfile.php" method="post">

                        <div class="row">

                            <div class="col-xxl-6 col-xl-6 col-lg-6 me-4">
                                <?php
                                $person = getPerson(email: $_SESSION["userEmail"]);
                                $_SESSION["userData"] = $person;
                                ?>
                                <div class="row">
                                    <div class="mb-3 form-input">
                                        <label for="f-name" class="form-label required"
                                        >First name</label
                                        >

                                        <input
                                                id="f-name"
                                                type="text"
                                                value="<?php if (isset($_SESSION["userInputData"]["firstName"])) {
                                                    echo $_SESSION["userInputData"]["firstName"];
                                                } else {
                                                    echo $_SESSION["userData"][PERSON_FIRST_NAME];
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
                                                        echo $_SESSION["userData"][PERSON_LAST_NAME];
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
                                                    echo $_SESSION["userData"][PERSON_NIK];
                                                } ?>"
                                                class="form-control"
                                                name="nik"
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
                                                    echo $_SESSION["userData"][PERSON_EMAIL];
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
                                                    echo date("Y-m-d", $_SESSION["userData"][PERSON_BIRTH_DATE]);
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
                                        >Sex</label
                                        >

                                        <select
                                                id="sex-dropdown"
                                                class="form-select form-control"
                                                required
                                                aria-label="Small select example"
                                                name="sex"

                                        >
                                            <option selected><?php if (isset($_SESSION["userInputData"]["sex"])) {
                                                    echo $_SESSION["userInputData"]["sex"];
                                                } else {
                                                    echo $_SESSION["userData"][PERSON_SEX];
                                                } ?></option>

                                            <?php
                                            if ($_SESSION["userData"][PERSON_SEX] == SEX_MALE) {
                                                ?>
                                                <option value="1"><?= SEX_FEMALE ?></option>
                                                <option value="2"><?= SEX_BETTER_NOT_SAY ?></option>

                                                <?php
                                            } elseif ($_SESSION["userData"][PERSON_SEX] == SEX_FEMALE) {
                                                ?>
                                                <option value="1"><?= SEX_MALE ?></option>
                                                <option value="2"><?= SEX_BETTER_NOT_SAY ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="1"><?= SEX_MALE ?></option>
                                                <option value="2"><?= SEX_FEMALE ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="mb-3 form-input">
                                        <span class="required title">Role</span>
                                        <p>
                                            <?= $person[PERSON_ROLE];
                                            ?>
                                        </p>
                                    </div>

                                </div>

                                <div class="btn-container d-flex column-gap-5">
                                    <a class="btn btn-primary btn--form has-border"
                                       type="submit"
                                       href="persons.php"
                                    >
                                        Cancel
                                    </a>
                                    <input
                                            class="btn btn-primary btn--form"
                                            type="submit"
                                            value="Save"
                                    />
                                </div>
                            </div>
                            <div class="col-xxl-5 col-xl-6 col-lg-6">
                                <?php
                                if ($person[PERSON_ROLE] == ROLE_ADMIN) {
                                    ?>
                                    <div class="mb-3 form-input">
                                        <label for="note" class="form-label"
                                        >Internal notes</label
                                        >
                                        <div class="form-floating mb-4">
                                              <textarea
                                                      class="form-control"
                                                      placeholder="Leave a comment here"
                                                      id="note"
                                                      name="note"
                                              ><?= $_SESSION["userData"][PERSON_INTERNAL_NOTE] ?></textarea>
                                        </div>
                                        <hr/>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="mb-3 form-input mt-4">
                                    <label for="currentPass" class="form-label">Current Password</label>
                                    <input
                                            id="currentPass"
                                            type="password"
                                            class="form-control"
                                            name="currentPassword"/>
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
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- sidebar -->
<?php
mainFooter("myProfile.php");
unset($_SESSION["userInputData"]);
unset($_SESSION["errorData"]);
