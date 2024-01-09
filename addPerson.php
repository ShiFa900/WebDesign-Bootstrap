<?php
require_once __DIR__ . "/action/actionAddPerson.php";
require_once __DIR__ . "/index.php";
require_once __DIR__ . "/include/header.php";
session_start();

redirectIfNotAuthenticated();
?>

<?php
mainHeader("Dashboard");
?>
<body>
<header
        class="header sticky-top d-flex align-items-center justify-content-between"
>
    <a href="dashboard.php" id="logo">
        <img src="assets/properties/pma-border.png" alt="PerMap logo" class="logo"/>
    </a>

    <div class="head-wrapper d-flex align-items-center gap-3">
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
                            Log
                            out</a
                        >
                    </li>
                </ul>
            </div>
        </a>
    </div>
</header>

<main>
    <section class="add-person-section d-flex position-relative">
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
                                    <a href="#" class="nav-link active">
                                        <ion-icon
                                                name="log-out-outline"
                                                class="icon sidebar-icon"
                                        ></ion-icon>
                                        Log out
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
            <div class="add-person-content position-absolute px-5">
                <div class="page-header">
                    <h1 class="first-heading">Add Person</h1>
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
                                        />
                                        <?php
                                        if (isset($_SESSION["errorNik"])) {
                                            ?>

                                            <div class="alert alert-danger" role="alert">
                                                Sorry, your NIK is less than 16 character OR already exist. Please
                                                check your NIK again.
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
                                                Sorry, your EMAIL is already exist. Please check your EMAIL again.
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
                                                Sorry, your PASSWORD is weak. Password should include at least one
                                                UPPERCASE, one LOWERCASE, one NUMBER and one SPECIAL CHARACTER.
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
<!--                                        --><?php
//                                        if (isset($_SESSION["confirmPass"]) && $_SESSION["confirmPass"] != 0) {
//                                            ?>
<!--                                            <div class="alert alert-danger" role="alert">-->
<!--                                                Sorry, your CONFIRMATION was wrong. Please check your PASSWORD again.-->
<!--                                            </div>-->
<!--                                            --><?php
//                                        }
//                                        ?>
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
                                            <option selected value="<?=SEX_MALE?>">Male</option>
                                            <option value="<?=SEX_FEMALE?>">Female</option>
                                            <option value="<?=SEX_BETTER_NOT_SAY?>">Better not say</option>
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
                                        <div class="form-floating">
                                            <textarea class="form-control" id="note" name="note"></textarea>
                                        </div>
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
                                            <option selected value="<?=ROLE_ADMIN?>">Admin</option>
                                            <option value="<?=ROLE_MEMBER?>">Member</option>
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
<nav class="header-nav d-flex align-items-center">
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
         id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title third-heading sidebar-heading" id="offcanvasScrollingLabel">
                <a href="dashboard.php" id="logo">
                    <img src="assets/properties/pma-color.png" alt="PerMap logo" class="logo"/>
                </a>
            </h3>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between py-0 px-0">
            <div class="offcanvas-body">
                <ul>
                    <li class="nav-item" id="dashboard-active">
                        <a href="dashboard.php" class="nav-link active">
                            <ion-icon name="speedometer-outline" class="icon sidebar-icon"></ion-icon>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item nav-item-highlight">
                        <a href="persons.php" class="nav-link">
                            <ion-icon name="person-outline" class="icon sidebar-icon"></ion-icon>
                            Persons
                        </a>
                    </li>
                    <li class="nav-title fourth-heading">My account</li>
                    <li>
                        <ul>
                            <li class="nav-item">
                                <a href="myProfile.php" class="nav-link active">
                                    <ion-icon name="create-outline" class="icon sidebar-icon"></ion-icon>
                                    Edit profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <ion-icon name="log-out-outline" class="icon sidebar-icon"></ion-icon>
                                    Log out
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
                        <a class="nav-link" href="#">
                            <ion-icon name="settings-outline" class="icon sidebar-icon"></ion-icon>
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
unset($_SESSION["id"]);
unset($_SESSION["lastLoggedIn"]);
unset($_SESSION["alive"]);
unset($_SESSION["password"]);
unset($_SESSION["role"]);
?>
</body>
</html>
