<?php
global $person;
require_once __DIR__ . "/index.php";
require_once __DIR__ . "/action/viewPerson.php";
require_once __DIR__ . "/include/header.php";
session_start();

redirectIfNotAuthenticated();
?>
<?php
mainHeader("View Person");
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
                                <div class="wrappe">
                                    <a href="action/logout.php" class="nav-link active">
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
            <div class="view-person-content position-absolute px-5">
                <div class="page-header">
                    <h1 class="first-heading">View person</h1>
                </div>

                <div class="row">
                    <div class="col-xxl-12">
                        <form class="new-person-form" action="action/viewPerson.php" method="post">
                            <div class="row">
                                <div class="col-xxl-8 col-xl-8 col-lg-10 col-12">
                                    <div class="mb-3 form-input">
                                        <span class="required title">First Name</span>
                                        <p>
                                            <?= $person[PERSON_FIRST_NAME];
                                            ?>
                                        </p>
                                    </div>

                                    <div class="mb-3 form-input">
                                        <?php
                                        if($person[PERSON_LAST_NAME] != ""){
                                        ?>
                                        <span class="title">Last Name</span>
                                        <p>
                                            <?= $person[PERSON_LAST_NAME];
                                            ?>
                                        </p>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="mb-3 form-input">
                                        <span class="required title">NIK</span>
                                        <p>
                                            <?= $person[PERSON_NIK];
                                            ?>
                                        </p>

                                    </div>
                                    <div class="mb-3 form-input">
                                        <span class="required title">Email</span>
                                        <p>
                                            <?= $person[PERSON_EMAIL];
                                            ?>
                                        </p>

                                    </div>

                                    <div class="mb-3 form-input">
                                        <span class="required title">Birth Of Date</span>
                                        <p>
                                            <?= date("d F Y", $person[PERSON_BIRTH_DATE]);
                                            ?>
                                        </p>

                                    </div>

                                    <div class="mb-3 form-input">
                                        <span class="required title">Sex</span>
                                        <p>
                                            <?= $person[PERSON_SEX];
                                            ?>
                                        </p>

                                    </div>


                                    <div class="mb-3 form-input">
                                        <?php
                                        if($person[PERSON_INTERNAL_NOTE] != null){
                                        ?>
                                        <span class="title">Internal Note</span>
                                        <p>
                                            <?= $person[PERSON_INTERNAL_NOTE];
                                            ?>
                                        </p>
                                        <?php
                                        }
                                        ?>

                                    </div>

                                    <!-- ROLE -->
                                    <div class="mb-3 form-input">
                                        <span class="required title">Role</span>
                                        <p>
                                            <?= $person[PERSON_ROLE];
                                            ?>
                                        </p>

                                    </div>

                                    <div class="mb-3 form-input">
                                        <span class="required title">Status</span>
                                        <p>
                                            <?= translateBooleanToString($person[PERSON_STATUS]); ?>
                                        </p>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-8 col-xl-8 col-lg-10 col-12">
                                        <div
                                                class="btn-container d-flex column-gap-5 justify-content-between"
                                        >
                                            <div class="btn-wrapper d-flex column-gap-3">
                                                <a href="persons.php" class="btn btn-primary btn--form has-border"
                                                        type="submit"
                                                >Back
                                                </a>
                                            </div>
                                            <?php
                                            if($person[PERSON_ROLE] == ROLE_ADMIN){
                                            ?>
                                            <!-- Button trigger modal -->
                                                <button type="button"
                                                        class="btn btn-primary btn--form delete-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"
                                                >Delete</button>
                                            <?php
                                            }
                                            ?>

                                                <!-- Modal -->
                                                <div
                                                        class="modal fade"
                                                        id="exampleModal"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true"
                                                >
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title" id="exampleModalLabel">
                                                                    Are you sure want to delete this person?
                                                                </h1>
                                                                <button
                                                                        type="button"
                                                                        class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"
                                                                ></button>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button
                                                                        type="button"
                                                                        class="btn btn-secondary btn-block"
                                                                        data-bs-dismiss="modal"
                                                                >
                                                                    No
                                                                </button>
                                                                <button type="button" class="btn btn-primary" name="btnDelete">
                                                                    <a href="action/deletePerson.php">Yes</a>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
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
                                <a href="action/logout.php" class="nav-link active">
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
