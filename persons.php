<?php
require_once __DIR__ . "/action/person.php";
require_once __DIR__ . "/action/const.php";
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

    <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"
    />

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

    <link rel="stylesheet" href="assets/query/mediaQuery.css"/>

    <title>PerMap &mdash; Persons</title>
</head>
<body>
<header class="header d-flex align-items-center justify-content-between">
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
    <section class="person-section d-flex position-relative">
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
                                    <a href="logout.php" class="nav-link active">
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
            <div class="person-content position-absolute px-5">
                <div
                        class="content-wrapper page-header d-flex justify-content-between"
                >
                    <div class="left d-flex gap-4">
                        <h1 class="first-heading d-flex align-items-center">Persons</h1>
                        <div class="add-person d-flex justify-content-end mb-0">
                            <a href="addPerson.php" class="nav-link btn-content">
                                <ion-icon name="person-add-outline" class="icon"></ion-icon>
                            </a>
                        </div>
                    </div>

                    <div
                            class="right d-flex gap-4 align-items-center justify-content-end"
                    >
                        <!-- menggunakan select -->
                        <select
                                id="form-select-catagories"
                                class="form-select form-select-lg form-select-sm"
                                aria-label="Large select example"

                        >
                            <option selected>All</option>
                            <option value="1">Productive ages</option>
                            <option value="2">Children</option>
                            <option value="3">Elderly</option>
                            <option value="4">Passed away</option>
                        </select>

                        <!-- menggunakan dropdown button -->
                        <!-- <div class="dropdown">
                          <button
                            class="btn btn-secondary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                          >
                            Dropdown button
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">All</a></li>
                            <li><hr class="dropdown-divider" /></li>

                            <li>
                              <a class="dropdown-item" href="#">Productive ages</a>
                            </li>
                            <li><a class="dropdown-item" href="#">Children</a></li>
                            <li><a class="dropdown-item" href="#">Elderly</a></li>
                            <li>
                              <a class="dropdown-item" href="#">Passed away</a>
                            </li>
                          </ul>
                        </div> -->

                        <!--SEARCH-->
                        <form
                                class="search-form d-flex align-items-center"
                                name="search-form"
                                action="#table"
                                method="get"
                        >
                            <div class="form-search d-none d-lg-block w-100 me-2">
                                <input
                                        id="search"
                                        class="form-control form-control-sm"
                                        type="search"
                                        placeholder="Search"
                                        aria-label="Search"
                                />
                            </div>
                            <?php
                            //                            search();
                            ?>
                            <button class="btn btn-outline-success" type="submit" name="search">
                                <ion-icon name="search-outline" class="icon"></ion-icon>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- EXPAND -->
                <a class="nav-link d-flex justify-content-end" href="#table">
                    <span class="material-symbols-outlined"> expand_more </span>
                </a>
                <div class="table-section table-responsive" id="table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Email</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">sex</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <?php
                            $persons = getAll();
                            foreach ($persons

                            as $person) {
                            ?>
                            <td><?= $person[ID] ?></td>
                            <td><?= $person[PERSON_EMAIL] ?></td>
                            <td><?= $person[PERSON_FIRST_NAME] . " " . $person[PERSON_LAST_NAME] ?></td>
                            <td><?= calculateAge($person[PERSON_BIRTH_DATE])?></td>
                            <td><?= $person[PERSON_SEX] ?></td>
                            <td><?= $person[PERSON_ROLE] ?></td>
                            <?php
                            $personStatus = translateBooleanToString($person[PERSON_STATUS]);
                            ?>
                            <td><?= $personStatus ?>
                            </td>


                            <td>
                                <button class="btn" name="btn-view">
                                    <a

                                        <?php
                                        if ($person[PERSON_EMAIL] != $_SESSION["userEmail"]){
                                        ?>
                                            href="viewPerson.php?id=<?php echo $person[ID] ?>"
                                        <?php
                                        }
                                        ?>
                                            href="myProfile.php"
                                            class="nav-link table-nav view-btn"
                                    >View</a
                                    >
                                </button>
                                <button class="btn">
                                    <a
                                            <?php
                                            if($person[PERSON_EMAIL] != $_SESSION["userEmail"]){?>

                                            href="editPerson.php?id=<?php echo $person[ID]?>"
                                            <?php
                                            }
                                            ?>
                                            href="myProfile.php"
                                            class="nav-link table-nav edit-btn"
                                    >Edit</a
                                    >
                                </button>
                            </td>

                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>


                <!-- PAGINATION -->
                <!-- <nav aria-label="Page navigation">
                  <ul class="pagination d-flex flex-row justify-content-end">
                    <li class="page-item disabled">
                      <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                      <a class="page-link" href="#">Next</a>
                    </li>
                  </ul>
                </nav> -->
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
<?php
//// unset $_SESSION
//unset($_SESSION["firstName"]);
//unset($_SESSION["lastName"]);
//unset($_SESSION["internalNote"]);
//unset($_SESSION["nik"]);
//unset($_SESSION["email"]);
//unset($_SESSION["sex"]);
//unset($_SESSION["birthDate"]);
//unset($_SESSION["id"]);
//unset($_SESSION["lastLoggedIn"]);
//unset($_SESSION["alive"]);
//unset($_SESSION["password"]);
//unset($_SESSION["role"]);
//?>
</body>
</html>
