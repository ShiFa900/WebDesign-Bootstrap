<?php
require_once __DIR__ . "/sidebar.php";
require_once __DIR__ . "/../action/const.php";

session_start();
function mainHeader(string $cssIdentifier, string $title, string $link, array|null $pageStyles = null): void
{
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

    <link href="assets/vendor/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/
    <!-- link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Open+Sans:wght@400;500;600;700&family=Rubik:wght@400;500;600;700&display=swap"
            rel="stylesheet"
                />

    <!-- link styling -->
    <link rel="stylesheet" href="/assets/css/general.css"/>
    <link rel="stylesheet" href="/assets/query/mediaQuery.css"/>

    <?php
        // page's specific css
        if (is_array($pageStyles)):
            foreach ($pageStyles as $style):
                echo '<link rel="stylesheet" href="/assets/css/' . $style . '"/>';
            endforeach;
        endif;
    ?>

<!--    <link rel="stylesheet" href="/assets/css/persons.css"/>-->
<!--    <link rel="stylesheet" href="/assets/css/addPerson.css"/>-->
<!--    <link rel="stylesheet" href="/assets/css/myProfile.css"/>-->
<!--    <link rel="stylesheet" href="/assets/css/editPerson.css"/>-->
<!--    <link rel="stylesheet" href="/assets/css/viewPerson.css"/>-->
<!--    <link rel="stylesheet" href="/assets/css/dashboard.css"/>-->

    <title>PerMap &mdash; <?=$title?></title>
</head>
<body class="<?= $cssIdentifier ?>">
<header
        class="header sticky-top d-flex align-items-center justify-content-between"
>
    <a href="../dashboard.php" id="logo">
        <img src="../assets/properties/pma-border.png" alt="PerMap logo" class="logo"/>
    </a>

    <div class="head-wrapper d-flex align-items-center gap-3">
        <button
                class="btn btn-primary d-xxl-none d-xl-none d-lg-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasScrolling"
                aria-controls="offcanvasScrolling"
        >
            <ion-icon src="../assets/properties/icon/menu-outline.svg" class="icon"></ion-icon>
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
                        echo "<span class='profile-text d-none d-lg-block'>";
                        echo $_SESSION["userEmail"];
                        echo "</span>";
                        ?>

                        <img
                                src="../assets/properties/image.png"
                                class="avatar-md avatar-img"
                                alt="User profile"
                        />
                    </div>
                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="../my-profile.php"
                        >
                            <ion-icon
                                    src="../assets/properties/icon/person-outline.svg"
                                    class="icon color"
                            ></ion-icon
                            >
                            Profile</a
                        >
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"
                        >
                            <ion-icon
                                    src="../assets/properties/icon/notifications-outline.svg"
                                    class="icon color"
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
                            <ion-icon src="../assets/properties/icon/log-out-outline.svg" class="icon color"></ion-icon>
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
<?php
	desktopSidebar($link);
}