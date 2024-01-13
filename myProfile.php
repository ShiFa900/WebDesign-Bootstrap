<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";
?>
<?php
mainHeader(cssIdentifier: "page-my-profile",title: "My Profile", link: "myProfile.php",pageStyles: ["myProfile.css"]);
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

                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 me-4">
                        <?php
                        $person = getPerson(email: $_SESSION["userEmail"]);
                        ?>
                        <form class="new-person-form" action="action/actionMyProfile.php" method="post">
                            <div class="row">
                                <div class="mb-3 form-input">
                                    <label for="f-name" class="form-label required"
                                    >First name</label
                                    >

                                    <input
                                            id="f-name"
                                            type="text"
                                            value="<?= $_SESSION['userName'] ?>"
                                            class="form-control"
                                            name="firstName"
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
                                                value="<?= $person[PERSON_LAST_NAME] ?>"
                                                class="form-control"
                                                name="lastName"
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
                                            value="<?= $person[PERSON_NIK] ?>"
                                            class="form-control"
                                            name="nik"
                                    />
                                </div>
                                <div class="mb-3 form-input">
                                    <label for="staticEmail" class="form-label required"
                                    >Email</label
                                    >
                                    <input
                                            id="staticEmail"
                                            type="email"
                                            value="<?= $_SESSION['userEmail'] ?>"
                                            class="form-control"
                                            name="email"
                                    />
                                </div>

                                <div class="mb-3 form-input">
                                    <label for="datePicker" class="form-label required"
                                    >Date of birth</label
                                    >
                                    <input
                                            id="datePicker"
                                            type="date"
                                            class="form-control"
                                            value="<?= date("Y-m-d", $person[PERSON_BIRTH_DATE]) ?>"
                                            name="birthDate"
                                    />
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
                                        <option selected><?= $person[PERSON_SEX] ?></option>

                                        <?php
                                        if ($person[PERSON_SEX] == SEX_MALE) {
                                            ?>
                                            <option value="1"><?= SEX_FEMALE ?></option>
                                            <option value="2"><?= SEX_BETTER_NOT_SAY ?></option>

                                            <?php
                                        } elseif ($person[PERSON_SEX] == SEX_FEMALE) {
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
                        </form>
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
                                              ><?= $person[PERSON_INTERNAL_NOTE] ?></textarea>
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

                        </div>
                        <div class="mb-3 form-input">
                            <label for="newPass" class="form-label ">New Password</label>
                            <input
                                    id="newPass"
                                    type="password"
                                    class="form-control"
                                    name="newPassword"/>

                        </div>
                        <div class="mb-3 form-input">
                            <label for="confirmPass" class="form-label">Confirm Password </label>
                            <input
                                    id="confirmPass"
                                    type="password"
                                    class="form-control"
                                <?php
                                if (isset($_SESSION["hasNewPassword"])) echo "required";
                                ?>
                                    name="confirmPassword"/>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- sidebar -->
<?php
mainFooter("myProfile.php");
?>
