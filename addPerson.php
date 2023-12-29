<?php
require_once __DIR__ . "/action/addPerson.php";
require_once __DIR__ . "/index.php";
session_start();

redirectIfNotAuthenticated();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Favicon -->
    <link
            rel="apple-touch-icon"
            sizes="57x57"
            href="assets/properties/favicon/apple-icon-57x57.png"
    />
    <link
            rel="apple-touch-icon"
            sizes="60x60"
            href="assets/properties/favicon/apple-icon-60x60.png"
    />
    <link
            rel="apple-touch-icon"
            sizes="72x72"
            href="assets/properties/favicon/apple-icon-72x72.png"
    />
    <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="assets/properties/favicon/apple-icon-76x76.png"
    />
    <link
            rel="apple-touch-icon"
            sizes="114x114"
            href="assets/properties/favicon/apple-icon-114x114.png"
    />
    <link
            rel="apple-touch-icon"
            sizes="120x120"
            href="assets/properties/favicon/apple-icon-120x120.png"
    />
    <link
            rel="apple-touch-icon"
            sizes="144x144"
            href="assets/properties/favicon/apple-icon-144x144.png"
    />
    <link
            rel="apple-touch-icon"
            sizes="152x152"
            href="assets/properties/favicon/apple-icon-152x152.png"
    />
    <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="assets/properties/favicon/apple-icon-180x180.png"
    />
    <link
            rel="icon"
            type="image/png"
            sizes="192x192"
            href="assets/properties/favicon/android-icon-192x192.png"
    />
    <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="assets/properties/favicon/favicon-32x32.png"
    />
    <link
            rel="icon"
            type="image/png"
            sizes="96x96"
            href="assets/properties/favicon/favicon-96x96.png"
    />
    <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="assets/properties/favicon/favicon-16x16.png"
    />
    <link rel="manifest" href="assets/properties/favicon/manifest.json"/>
    <meta name="msapplication-TileColor" content="#ffffff"/>
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png"/>
    <meta name="theme-color" content="#ffffff"/>

    <!-- Link Bootstrap -->
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
    />
    <link
            href="https://getbootstrap.com/docs/5.3/assets/css/docs.css"
            rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/@popperjs/core@2"></script>

    <!-- link icon -->
    <script
            type="module"
            src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
            nomodule
            src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"
    ></script>

    <!-- link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Open+Sans:wght@400;500;600;700&family=Rubik:wght@400;500;600;700&display=swap"
            rel="stylesheet"
    />

    <!-- link styling -->
    <link rel="stylesheet" href="assets/css/general.css"/>
    <link rel="stylesheet" href="assets/css/persons.css"/>
    <link rel="stylesheet" href="assets/css/add-person.css"/>

    <link rel="stylesheet" href="assets/query/mediaQuery.css"/>

    <title>PerMap &mdash; Add new person</title>
</head>
<body>
<header
        class="header sticky-top d-flex align-items-center justify-content-between"
>
    <a href="#" id="logo">
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
                        <a class="dropdown-item" href="myProfile.html"
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
                                <a href="myProfile.html" class="nav-link active">
                                    <ion-icon
                                            name="create-outline"
                                            class="icon sidebar-icon"
                                    ></ion-icon>
                                    Edit profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <div class="wrappe">
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
                    <h1 class="first-heading">Add person</h1>
                </div>
                <div class="row">
                    <div class="col-xxl-12">
                        <form class="new-person-form" action="action/addPerson.php" method="post"
                              name="add-person-form">
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 new-person-form">
                                    <div class="mb-3 form-input">
                                        <label for="f-name" class="form-label required"
                                        >First name</label
                                        >
                                        <input
                                                id="f-name"
                                                type="text"
                                                placeholder="First name"
                                                required
                                                class="form-control"
                                                name="addFirstName"
                                        />
                                    </div>
                                    <div class="mb-3 form-input">
                                        <label for="l-name" class="form-label">Last name</label>

                                        <input
                                                id="l-name"
                                                type="text"
                                                placeholder="Last name"
                                                class="form-control"
                                                name="addLastName"
                                        />
                                    </div>
                                    <div class="mb-3 form-input">
                                        <label for="nik" class="form-label required">NIK</label>
                                        <input
                                                id="nik"
                                                type="text"
                                                placeholder="NIK"
                                                required
                                                class="form-control"
                                                name="addNik"
                                        />
                                        <span><em>NIK must be at least 16 characters</em></span>
                                        <?php
                                        if (isset($_GET["error"]) && $_GET["error"] == 1) {
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
                                                placeholder="Email"
                                                required
                                                class="form-control"
                                                name="addEmail"
                                        />
                                    </div>

                                    <div class="mb-3 form-input">
                                        <label for="datePicker" class="form-label required"
                                        >Date of birth</label
                                        >
                                        <input
                                                id="datePicker"
                                                type="date"
                                                placeholder="Date of birth"
                                                required
                                                class="form-control"
                                                name="addDate"
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
                                                name="addSex"
                                        >
                                            <option selected>Male</option>
                                            <option value="1">Female</option>
                                            <option value="2">Better not say</option>
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
                                                    name="addSwitch"
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

                                    <div class="mb-3 form-input">
                                        <label for="note" class="form-label"
                                        >Internal notes</label
                                        >
                                        <div class="form-floating">
                                            <textarea class="form-control" id="note" name="addNote"></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 form-input">
                                        <label class="form-label" for="role-dropdown"
                                        >Role</label
                                        >
                                        <select
                                                id="role-dropdown"
                                                class="form-select form-control"
                                                aria-label="Small select example"
                                                name="addRole"
                                        >
                                            <option selected>Admin</option>
                                            <option value="1">Member</option>
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
                <a href="#" id="logo">
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
                        <a href="dashboard.php" class="nav-link active">
                            <ion-icon
                                    name="speedometer-outline"
                                    class="icon sidebar-icon"
                            ></ion-icon
                            >
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item nav-item-highlight" id="person-active">
                        <a href="persons.php" class="nav-link">
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
                                <a href="myProfile.html" class="nav-link active">
                                    <ion-icon
                                            name="create-outline"
                                            class="icon sidebar-icon"
                                    ></ion-icon>
                                    Edit profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <ion-icon
                                            name="log-out-outline"
                                            class="icon sidebar-icon"
                                    ></ion-icon>
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
</body>
</html>
