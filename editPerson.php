<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";


checkRoleAdmin();

?>

<?php
mainHeader(cssIdentifier: "page-edit-person",title: "Edit Person", link: "editPerson.php", pageStyles: ["editPerson.css"]);
?>

<main>
    <section class="view-section d-flex position-relative">
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
                            $person = getPerson(id: $_GET[ID]);
                            $_SESSION["personId"] = $person[ID];
                        ?>
                        <form class="new-person-form" action="action/actionEditPerson.php" method="post"
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
                                                value="<?php if(isset($_SESSION["userInputData"]["firstName"])){ echo $_SESSION["userInputData"]["firstName"];}else { echo $person[PERSON_FIRST_NAME];} ?>"
                                                required
                                                class="form-control"
                                                name="firstName"

                                        />
                                    </div>
                                    <div class="mb-3 form-input">
                                        <label for="l-name" class="form-label">Last Name</label>

                                        <input
                                                id="l-name"
                                                type="text"
                                                value="<?php if(isset($_SESSION["userInputData"]["lastName"])){ echo $_SESSION["userInputData"]["lastName"];}else { echo $person[PERSON_FIRST_NAME];} ?>"
                                                class="form-control"
                                                name="lastName"
                                        />
                                    </div>
                                    <div class="mb-3 form-input">
                                        <label for="nik" class="form-label required">NIK</label>
                                        <input
                                                id="nik"
                                                type="text"
                                                value="<?php if(isset($_SESSION["userInputData"]["nik"])){ echo $_SESSION["userInputData"]["nik"];}else { echo $person[PERSON_LAST_NAME];} ?>"
                                                required
                                                class="form-control"
                                                name="nik"
                                                maxlength="16"
                                                minlength="16"
                                        />
                                        <?php
                                        if (isset($_SESSION["addNik"]) && $_SESSION["addNik"] == 1) {
                                            ?>

                                            <div class="alert alert-danger" role="alert">
                                                Sorry, your NIK is less than 16 characters OR already exist. Please
                                                check your NIK again.
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
                                                value="<?php if(isset($_SESSION["userInputData"]["email"])){ echo $_SESSION["userInputData"]["email"];}else { echo $person[PERSON_EMAIL];} ?>"
                                                required
                                                class="form-control"
                                                name="email"
                                        />
                                    </div>

                                    <div class="mb-3 form-input">
                                        <label for="datePicker" class="form-label required"
                                        >Date of Birth</label
                                        >
                                        <input
                                                id="datePicker"
                                                type="date"
                                                value="<?php if(isset($_SESSION["userInputData"]["birthDate"])){ echo $_SESSION["userInputData"]["birthDate"];}else { echo  date("Y-m-d", $person[PERSON_BIRTH_DATE]);} ?>"
                                                required
                                                class="form-control"
                                                name="birthDate"
                                        />
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
                                            <option selected><?php if(isset($_SESSION["userInputData"]["sex"])){ echo $_SESSION["userInputData"]["sex"];}else { echo $person[PERSON_SEX];} ?></option>
                                            <!--opsi lainnya blum muncul-->

                                            <?php
                                            if ($person[PERSON_SEX] == SEX_MALE) {
                                                ?>
                                                <option value="<?= SEX_FEMALE ?>"><?= SEX_FEMALE ?></option>
                                                <option value="<?= SEX_BETTER_NOT_SAY ?>"><?= SEX_BETTER_NOT_SAY ?></option>

                                                <?php
                                            } elseif ($person[PERSON_SEX] == SEX_FEMALE) {
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
                                                    value="<?php if(isset($_SESSION["userInputData"]["role"])){ echo $_SESSION["userInputData"]["role"];}else { echo $person[PERSON_ROLE];} ?>"><?php if(isset($_SESSION["userInputData"]["role"])){ echo $_SESSION["userInputData"]["role"];}else { echo $person[PERSON_ROLE];} ?></option>

                                            <?php
                                            if ($person[PERSON_ROLE] == ROLE_ADMIN) {
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

                                    </div>
                                    <div class="mb-3 form-input">
                                        <label for="confirmPass" class="form-label">Confirm Password </label>
                                        <input
                                                id="confirmPass"
                                                type="password"
                                                class="form-control"
                                            <?php
                                            if (isset($_SESSION["newPassword"])) echo "required";
                                            ?>
                                                name="confirmPassword"/>


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
        </div>
    </section>
</main>

<!-- sidebar -->
<?php
mainFooter("persons.php");
?>
<?php
// unset $_SESSION
unset($_SESSION["firstName"]);
unset($_SESSION["lastName"]);
unset($_SESSION["internalNote"]);
unset($_SESSION["nik"]);
unset($_SESSION["email"]);
unset($_SESSION["sex"]);
unset($_SESSION["birthDate"]);
unset($_SESSION["lastLoggedIn"]);
unset($_SESSION["status"]);
unset($_SESSION["password"]);
unset($_SESSION["role"]);
?>
