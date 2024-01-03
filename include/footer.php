<?php
require_once __DIR__ . "/header.php";
function mainFooter()
{
    ?>
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
                                src="../assets/properties/pma-color.png"
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
                            <a href="../dashboard.php" class="nav-link active">
                                <ion-icon
                                        name="speedometer-outline"
                                        class="icon sidebar-icon"
                                ></ion-icon
                                >
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item nav-item-highlight" id="person-active">
                            <a href="../persons.php" class="nav-link">
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
    <?php
}

?>
