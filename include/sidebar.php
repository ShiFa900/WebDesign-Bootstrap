<?php

function desktopSidebar($activeMenu)
{
    ?>
    <div class="sidebar d-none d-lg-block">
        <nav class="header-nav d-flex flex-column justify-content-between">
            <ul>
                <li class="nav-item <?php if ($activeMenu === 'dashboard.php') echo 'active'; ?>">
                    <a href="../dashboard.php" class="nav-link">
                        <ion-icon
                                src="../assets/properties/icon/speedometer-outline.svg"
                                class="icon color"

                        ></ion-icon
                        >
                        Dashboard
                    </a>
                </li>

                <li class="nav-item <?php if ($activeMenu === 'persons.php') echo 'active'; ?>">
                    <a href="../persons.php?page=1" class="nav-link">
                        <ion-icon
                                src="../assets/properties/icon/people-outline.svg"
                                class="icon color"
                        ></ion-icon
                        >
                        Persons
                    </a>
                </li>
                <li class="nav-title fourth-heading">My account</li>
                <li>
                    <ul>
                        <li class="nav-item <?php if ($activeMenu === 'my-profile.php') echo 'active'; ?>">
                            <a href="../my-profile.php" class="nav-link active">
                                <ion-icon
                                        src="../assets/properties/icon/create-outline.svg"
                                        class="icon color"
                                ></ion-icon>
                                Edit profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="wrapper">
                                <a href="../action/action-logout.php" class="nav-link active">
                                    <ion-icon
                                            src="../assets/properties/icon/log-out-outline.svg"
                                            class="icon color"
                                    ></ion-icon>
                                    Log out
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
    </div>
    <?php
}

function mobileSidebar($activeMenu)
{
    ?>
    <nav class="header-nav d-flex align-items-center">
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
             id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
            <div class="offcanvas-header">
                <h3 class="offcanvas-title third-heading sidebar-heading" id="offcanvasScrollingLabel">
                    <a href="../dashboard.php" id="logo">
                        <img src="../assets/properties/pma-color.png" alt="PerMap logo" class="logo"/>
                    </a>
                </h3>

                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between py-0 px-0">
                <div class="offcanvas-body">
                    <ul>
                        <li class="nav-item <?php if ($activeMenu === 'dashboard.php') echo 'active'; ?>">
                            <a href="../dashboard.php" class="nav-link">
                                <ion-icon src="../assets/properties/icon/speedometer-outline.svg" class="icon color"></ion-icon>
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item <?php if ($activeMenu === 'persons.php') echo 'active'; ?>">
                            <a href="../persons.php?page=1" class="nav-link">
                                <ion-icon src="../assets/properties/icon/people-outline.svg" class="icon color"></ion-icon>
                                Persons
                            </a>
                        </li>
                        <li class="nav-title fourth-heading">My account</li>
                        <li>
                            <ul>
                                <li class="nav-item">
                                    <a href="../my-profile.php" class="nav-link">
                                        <ion-icon src="../assets/properties/icon/create-outline.svg" class="icon color"></ion-icon>
                                        Edit profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../action/action-logout.php" class="nav-link">
                                        <ion-icon src="../assets/properties/icon/log-out-outline.svg" class="icon color"></ion-icon>
                                        Log out
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <?php
}