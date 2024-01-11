<?php
require_once __DIR__ . "/action/actionAddPerson.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/sidebar.php";
require_once __DIR__ . "/index.php";

checkRoleAdmin();

?>

<?php
mainHeader("Add Person", $_SESSION["userEmail"]);
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
                    <form class="new-person-form" action="action/actionAddPerson.php" method="post" name="addPerson">
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
                                    />
                                    <?php
                                    if (isset($_SESSION["errorNik"])) {
                                        ?>

                                        <div class="alert alert-danger" role="alert">
                                            <?= $_SESSION["errorNik"] ?>>
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
                                    />

                                    <?php
                                    if (isset($_SESSION["errorEmail"])) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $_SESSION["errorEmail"] ?>
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
                                    />
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
                                    if (isset($_SESSION["errorPass"])) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $_SESSION["errorPass"] ?>
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
                                    if (isset($_SESSION["errorConfirm"])) {
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $_SESSION["errorConfirm"] ?>
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
                                        <option selected value="<?= SEX_MALE ?>">Male</option>
                                        <option value="<?= SEX_FEMALE ?>">Female</option>
                                        <option value="<?= SEX_BETTER_NOT_SAY ?>">Better not say</option>
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
                                        <option selected value="<?= ROLE_MEMBER ?>">Member</option>
                                        <option value="<?= ROLE_ADMIN ?>">Admin</option>
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

                            <button
                                    class="btn btn-primary btn--form has-border"
                                    type="submit"
                                    name="btn"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<!-- mobile sidebar -->
<?php mobileSidebar("persons.php"); ?>
<?php
// unset $_SESSION
unset($_SESSION["firstName"]);
unset($_SESSION["lastName"]);
unset($_SESSION["internalNote"]);
unset($_SESSION["nik"]);
unset($_SESSION["email"]);
unset($_SESSION["sex"]);
unset($_SESSION["birthDate"]);
unset($_SESSION["id"]);
unset($_SESSION["lastLoggedIn"]);
unset($_SESSION["status"]);
unset($_SESSION["password"]);
unset($_SESSION["role"]);

unset($_SESSION["errorNik"]);
unset($_SESSION["errorEmail"]);
unset($_SESSION["errorPassword"]);
unset($_SESSION["errorConfirm"]);
?>
</body>
