<?php
require_once __DIR__ . "/index.php";
require_once __DIR__ . "/action/myProfile.php";
require_once __DIR__ . "/include/header.php";

redirectIfNotAuthenticated();
?>
<?php
mainHeader("My Profile");
?>
<body>
<header
        class="header sticky-top d-flex align-items-center justify-content-between"
>
    <a href="dashboard.php" id="logo">
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
                        <a class="dropdown-item" href="action/logout.php"
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
                                    <a href="action/logout.php" class="nav-link active">
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
                                                    value="<?= $person[PERSON_LAST_NAME] ?>"
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
                                                value="<?= $person[PERSON_NIK] ?>"
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
                                                value="<?= date("Y-m-d", $person[PERSON_BIRTH_DATE]) ?>"
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
                                            <option selected><?= $person[PERSON_SEX] ?></option>
                                            <!--opsi lainnya blum muncul-->

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
                                        <label for="note" class="form-label"
                                        >Internal notes</label
                                        >
                                        <div class="form-floating">
                                              <textarea
                                                      class="form-control"
                                                      placeholder="Leave a comment here"
                                                      id="note"
                                              ><?= $person[PERSON_INTERNAL_NOTE]; ?>
                                              </textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 form-input">
                                        <span class="required title">Role</span>
                                        <p>
                                            <?= $person[PERSON_ROLE];
                                            ?>
                                        </p>

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
                                <a href="action/logout.php" class="nav-link active">
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
</body>
</html>
