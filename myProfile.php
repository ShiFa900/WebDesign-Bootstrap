<?php
require_once __DIR__ . "/index.php";
require_once __DIR__ . "/action/myProfile.php";

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
    <link rel="stylesheet" href="assets/css/my-profile.css"/>

    <link rel="stylesheet" href="assets/query/mediaQuery.css"/>

    <title>PerMap &mdash; My profile</title>
</head>
<body>
<header
        class="header sticky-top d-flex align-items-center justify-content-between"
>
    <a href="#" id="logo">
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
                        <a class="dropdown-item" href="#"
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
                        <a class="dropdown-item" href="logout.php"
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
    <section class="profile-section d-flex position-relative">
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

                    <li class="nav-item">
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
                            <li class="nav-item" id="profile-active">
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
                                    <a href="logout.php" class="nav-link active">
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
            <div class="my-profile-content position-absolute px-5">
                <div class="page-header">
                    <h1 class="first-heading">My profile</h1>
                </div>

                <div class="row">
                    <div class="col-xxl-12">
                        <form class="new-person-form" action="action/myProfile.php" method="post">

                            <?php
                            $person = getPerson(null, $_SESSION["userEmail"]);
                            ?>
                            <div class="row">
                                <div class="col-xxl-8 col-xl-8 col-lg-10 col-12">
                                    <div class="mb-3 form-input">
                                        <label for="f-name" class="form-label required"
                                        >First name</label
                                        >

                                        <input
                                                id="f-name"
                                                type="text"
                                                value="<?= $_SESSION['userName'] ?>"
                                                class="form-control"
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
                                                    value="<?= $person["lastName"] ?>"
                                                    class="form-control"
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
                                                value="<?= $person["nik"] ?>"
                                                class="form-control"
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
                                                value="<?= date("Y-m-d", $person["birthDate"])?>"
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

                                        >
                                            <option selected><?= $person["sex"] ?></option>
                                            <!--opsi lainnya blum muncul-->
                                            <?php
                                            if (ctype_upper($person["sex"]) == "FEMALE") {
                                                ?>
                                                <option value="1">Male</option>
                                                <option value="2">Better not say</option>
                                                <?php
                                            } elseif (ctype_upper($person["sex"]) == "MALE") {
                                                ?>
                                                <option value="1">Female</option>
                                                <option value="2">Better not say</option>
                                                <?php
                                            }
                                            ?>


                                        </select>
                                    </div>

                                    <!-- SWITCH BUTTON -->
                                    <!-- <div class="mb-3 form-input">
                                      <div
                                        class="form-check form-switch d-flex align-items-center column-gap-3"
                                      >
                                        <input
                                          class="form-check-input"
                                          type="checkbox"
                                          role="switch"
                                          id="flexSwitchCheckDefault"
                                          style="width: 4rem; height: 2.4rem"
                                        />
                                        <label
                                          class="form-check-label"
                                          for="flexSwitchCheckDefault"
                                          >This person is alive</label
                                        >
                                      </div>
                                    </div> -->

                                    <div class="mb-3 form-input">
                                        <label for="note" class="form-label"
                                        >Internal notes</label
                                        >
                                        <div class="form-floating">
                          <textarea
                                  class="form-control"
                                  placeholder="Leave a comment here"
                                  id="note"
                          ><?= $person["internalNote"]; ?>
                          </textarea>
                                        </div>
                                    </div>

                                    <!-- ROLE -->
                                    <!-- <div class="mb-3 form-input">
                                    <label for="role-dropdown" class="form-label required">Role</label>
                                    <select
                                      class="form-select form-select-sm form-control"
                                      aria-label="Small select example"
                                    >
                                      <option selected>Admin</option>
                                      <option value="1">Member</option>
                                    </select>
                                   -->
                                </div>
                            </div>

                            <div class="btn-container d-flex column-gap-5">
                                <input
                                        class="btn btn-primary btn--form"
                                        type="submit"
                                        value="Save"
                                />

                                <input
                                        class="btn btn-primary btn--form has-border"
                                        type="submit"
                                        value="Cancel"
                                />
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

                    <li class="nav-item nav-item-highlight">
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
                            <li class="nav-item" id="profile-active">
                                <a href="myProfile.php" class="nav-link active">
                                    <ion-icon
                                            name="create-outline"
                                            class="icon sidebar-icon"
                                    ></ion-icon>
                                    Edit profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="logout.php" class="nav-link active">
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
unset($_SESSION["id"]);
unset($_SESSION["lastLoggedIn"]);
unset($_SESSION["alive"]);
unset($_SESSION["password"]);
unset($_SESSION["role"]);
?>
</body>
</html>
