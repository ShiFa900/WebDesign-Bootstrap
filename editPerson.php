<?php
global $person;
session_start();
$person["personId"] = $_GET["id"];
require_once __DIR__ . "/index.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/action/actionEditPerson.php";

redirectIfNotAuthenticated();
//checkRoleAdmin("actionDashboard.php");

?>
<?php
mainHeader("Edit Person");
?>

<body>
<header
        class="header sticky-top d-flex align-items-center justify-content-between"
>
    <a href="dashboard.php">
        <img src="assets/properties/pma-border.png" alt="PerMap logo" class="logo"/>
    </a>

    <div class="head-wrapper d-flex align-items-center gap-3">
        <!-- menu sidebar belum tersedia -->
        <button
                class="btn btn-primary d-xxl-none d-xl-none d-lg-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasScrolling"
                aria-controls="offcanvasScrolling"
        >
            <ion-icon name="menu-outline" class="icon"></ion-icon>
        </button>
        <a class="nav-link">
            <div class="dropdown">
                <a
                        class="btn btn-secondary dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                >
                    <div class="avatar">
                        <?php
                        echo "<span class='profile-text d-none d-xl-block'>";
                        echo $_SESSION['userEmail'];
                        echo "</span>";
                        ?>

                        <img
                                src="assets/properties/image.png"
                                class="avatar-md avatar-img"
                                alt="User profile"
                        />
                    </div>
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="myProfile.php"
                        >
                            <ion-icon
                                    name="person-circle-outline"
                                    class="icon"
                            ></ion-icon
                            >
                            Profile</a
                        >
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"
                        >
                            <ion-icon
                                    name="notifications-outline"
                                    class="icon"
                            ></ion-icon
                            >
                            Notifications</a
                        >
                    </li>
                    <li>
                        <hr class="dropdown-divider"/>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"
                        >
                            <ion-icon name="log-out-outline" class="icon"></ion-icon>
                            Logout</a
                        >
                    </li>
                </ul>
            </div>
        </a>
    </div>
</header>

<main>
    <section class="view-section d-flex position-relative">
        <div class="sidebar d-none d-lg-block">
            <nav class="header-nav d-flex flex-column justify-content-between">
                <ul>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link active">
                            <ion-icon
                                    name="speedometer-outline"
                                    class="icon sidebar-icon"
                            ></ion-icon
                            >
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item" id="person-active">
                        <a href="persons.php" class="nav-link active">
                            <ion-icon
                                    name="person-outline"
                                    class="icon sidebar-icon"
                            ></ion-icon
                            >
                            Persons
                        </a>
                    </li>
                    <li class="nav-title fourth-heading">My account</li>
                    <li>
                        <ul>
                            <li class="nav-item">
                                <a href="myProfile.php" class="nav-link active">
                                    <ion-icon
                                            name="create-outline"
                                            class="icon sidebar-icon"
                                    ></ion-icon>
                                    Edit profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <div class="wrapper">
                                    <a href="action/actionLogout.php" class="nav-link active">
                                        <ion-icon
                                                name="log-out-outline"
                                                class="icon sidebar-icon"
                                        ></ion-icon>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <hr/>
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link active" href="#"
                            >
                                <ion-icon
                                        name="settings-outline"
                                        class="icon sidebar-icon"
                                ></ion-icon
                                >
                                Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="w-100">
            <div class="edit-person-content position-absolute px-5">
                <div class="page-header">
                    <h1 class="first-heading">Edit Person Data</h1>
                </div>

                <div class="row">
                    <div class="col-xxl-12">
                        <form class="new-person-form" action="action/actionEditPerson.php" method="post" name="editPerson">
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 me-4">
                                    <div class="mb-3 form-input">
                                        <label for="f-name" class="form-label required"
                                        >First Name</label
                                        >

                                        <input
                                                id="f-name"
                                                type="text"
                                                value="<?= $person[PERSON_FIRST_NAME] ?>"
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
                                                value="<?= $person[PERSON_LAST_NAME] ?>"
                                                class="form-control"
                                                name="lastName"
                                        />
                                    </div>
                                    <div class="mb-3 form-input">
                                        <label for="nik" class="form-label required">NIK</label>
                                        <input
                                                id="nik"
                                                type="text"
                                                value="<?= $person[PERSON_NIK] ?>"
                                                required
                                                class="form-control"
                                                name="nik"
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
                                                value="<?= $person[PERSON_EMAIL] ?>"
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
                                                value="<?= date("Y-m-d", $person[PERSON_BIRTH_DATE]) ?>"
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
                                            <option selected><?= $person[PERSON_SEX] ?></option>
                                            <!--opsi lainnya blum muncul-->

                                            <?php
                                            if ($person[PERSON_SEX] == SEX_MALE) {
                                                ?>
                                                <option value="<?=SEX_FEMALE?>"><?= SEX_FEMALE ?></option>
                                                <option value="<?=SEX_BETTER_NOT_SAY?>"><?= SEX_BETTER_NOT_SAY ?></option>

                                                <?php
                                            } elseif ($person[PERSON_SEX] == SEX_FEMALE) {
                                                ?>
                                                <option value="<?=SEX_MALE?>"><?= SEX_MALE ?></option>
                                                <option value="<?=SEX_BETTER_NOT_SAY?>"><?= SEX_BETTER_NOT_SAY ?></option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="<?=SEX_MALE?>"><?= SEX_MALE ?></option>
                                                <option value="<?=SEX_FEMALE?>"><?= SEX_FEMALE ?></option>
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
                                                if($person[PERSON_STATUS]){
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

                                <div class="col-xxl-5 col-xl-6 col-lg-6">

                                    <div class="mb-3 form-input">
                                        <label for="note" class="form-label"
                                        >Internal notes</label
                                        >
                                        <div class="form-floating">
                                          <textarea
                                                  class="form-control"
                                                  placeholder="Leave a comment here"
                                                  id="note"
                                                  name="note"
                                          ><?=filter_input(INPUT_GET, $person[PERSON_INTERNAL_NOTE], FILTER_SANITIZE_URL);
                                              ?>
                                          </textarea>
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
                                            <option selected value="<?=$person[PERSON_ROLE]?>"><?=$person[PERSON_ROLE]?></option>

                                            <?php
                                            if($person[PERSON_ROLE] == ROLE_ADMIN){
                                            ?>
                                                <option value="<?=ROLE_MEMBER?>">Member</option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?=ROLE_ADMIN?>">Admin</option>

                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
<!--                                    <div class="mb-3 form-input">-->
<!--                                        <label for="currentPass" class="form-label">Current Password</label>-->
<!--                                        <input-->
<!--                                                id="currentPass"-->
<!--                                                type="password"-->
<!--                                                class="form-control"-->
<!--                                                name="currentPassword"/>-->
<!---->
<!--                                    </div>-->
<!--                                    <div class="mb-3 form-input">-->
<!--                                        <label for="newPass" class="form-label ">New Password</label>-->
<!--                                        <input-->
<!--                                                id="newPass"-->
<!--                                                type="password"-->
<!--                                                class="form-control"-->
<!--                                                name="newPassword"/>-->
<!---->
<!--                                    </div>-->
<!--                                    <div class="mb-3 form-input">-->
<!--                                        <label for="confirmPass" class="form-label">Confirm Password</label>-->
<!--                                        <input-->
<!--                                                id="confirmPass"-->
<!--                                                type="password"-->
<!--                                                class="form-control"-->
<!--                                                name="confirmPassword"/>-->
<!---->
<!--                                    </div>-->
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
<nav class="header-nav d-flex align-items-center">
    <div
            class="offcanvas offcanvas-start"
            data-bs-scroll="true"
            data-bs-backdrop="false"
            tabindex="-1"
            id="offcanvasScrolling"
            aria-labelledby="offcanvasScrollingLabel"
    >
        <div class="offcanvas-header">
            <h3
                    class="offcanvas-title third-heading sidebar-heading"
                    id="offcanvasScrollingLabel"
            >
                <a href="dashboard.php" id="logo">
                    <img
                            src="assets/properties/pma-color.png"
                            alt="PerMap logo"
                            class="logo"
                    />
                </a>
            </h3>

            <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
            ></button>
        </div>
        <div
                class="offcanvas-body d-flex flex-column justify-content-between py-0 px-0"
        >
            <div class="offcanvas-body">
                <ul>
                    <li class="nav-item">
                        <a href="dashboard.html" class="nav-link active">
                            <ion-icon
                                    name="speedometer-outline"
                                    class="icon sidebar-icon"
                            ></ion-icon
                            >
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item nav-item-highlight" id="person-active">
                        <a href="persons.html" class="nav-link">
                            <ion-icon
                                    name="person-outline"
                                    class="icon sidebar-icon"
                            ></ion-icon
                            >
                            Persons
                        </a>
                    </li>
                    <li class="nav-title fourth-heading">My account</li>
                    <li>
                        <ul>
                            <li class="nav-item">
                                <a href="myProfile.php" class="nav-link active">
                                    <ion-icon
                                            name="create-outline"
                                            class="icon sidebar-icon"
                                    ></ion-icon>
                                    Edit profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="action/actionLogout.php" class="nav-link active">
                                    <ion-icon
                                            name="log-out-outline"
                                            class="icon sidebar-icon"
                                    ></ion-icon>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <hr/>
                <ul>
                    <li class="nav-item">
                        <a class="nav-link" href="#"
                        >
                            <ion-icon
                                    name="settings-outline"
                                    class="icon sidebar-icon"
                            ></ion-icon
                            >
                            Settings
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php
// unset $_SESSION
unset($_SESSION["firstName"]);
unset($_SESSION["lastName"]);
unset($_SESSION["internalNote"]);
unset($_SESSION["nik"]);
unset($_SESSION["email"]);
unset($_SESSION["sex"]);
unset($_SESSION["birthDate"]);
unset($_SESSION["personId"]);
unset($_SESSION["lastLoggedIn"]);
unset($_SESSION["status"]);
unset($_SESSION["password"]);
unset($_SESSION["role"]);
?>
</body>
</html>
