<?php
require_once __DIR__ . "/action/utils.php";

redirectIfUserAlreadyLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/properties/favicon/apple-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="assets/properties/favicon/apple-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="assets/properties/favicon/apple-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/properties/favicon/apple-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="assets/properties/favicon/apple-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="assets/properties/favicon/apple-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="assets/properties/favicon/apple-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="assets/properties/favicon/apple-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/properties/favicon/apple-icon-180x180.png" />
    <link rel="icon" type="image/png" sizes="192x192" href="assets/properties/favicon/android-icon-192x192.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/properties/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="96x96" href="assets/properties/favicon/favicon-96x96.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/properties/favicon/favicon-16x16.png" />
    <link rel="manifest" href="assets/properties/favicon/manifest.json" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png" />
    <meta name="theme-color" content="#ffffff" />
    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Link for import -->
    <link rel="stylesheet" href="assets/css/general.css" />
    <link rel="stylesheet" href="assets/css/login.css" />

    <!-- Link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <title>PerMap &mdash; Login page</title>
</head>

<body class="d-flex align-item-center">
<main class="form-signin w-100 m-auto">
    <section class="login-section d-flex flex-row align-items-center justify-content-center">
        <div class="login container">
            <div class="row">
                <!-- image -->
                <div class="col-lg-6 d-none d-lg-flex">
                    <img class="login-img" alt="person login into aplication" src="assets/properties/Creative team-cuate.svg" />
                </div>

                <!-- the form -->
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="login-form-wrapper px-3">
                        <div class="wrapper ">
                            <img alt="PerMap logo" src="assets/properties/pma-color.png" class="login-icon" >

                        </div>
                        <div class="login-header">
                            <h2 class="second-heading heading-content">
                                Hello,
                                <?php
                                if (isset($_GET["nama"]) == 1) {
                                    echo "<span style='color:red;'>";
                                    echo $_GET["nama"];
                                    echo "<span>";
                                }
                                ?>
                                </br>
                                Welcome to <span>PerMap</span>
                            </h2>
                        </div>

                        <form class="login-form" action="action/action-login.php" method="post" name="login-form">
                            <div class="mb-3 row">
                                <label for="staticEmail" class="form-label">Email</label>
                                <div class="col-sm-12">
                                    <input name="email" id="staticEmail" type="email" placeholder="Email" required class="form-control" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="form-label">Password</label>

                                <div class="col-sm-12">
                                    <input name="password" id="password" type="password" placeholder="Password" required class="form-control" />
                                </div>
                            </div>

                            <?php if (isset($_GET["error"]) && $_GET["error"] == 1) { ?>
                                <div class="alert alert-danger" role="alert">
                                    Sorry, your email or password was wrong. Please check again.
                                </div>
                                <!--                --><?php
                            }
                            ?>

                            <div class="btn-container">
                                <!--                  <input class="btn btn-primary btn--form" type="submit" value="login" name="login"/>-->
                                <button class="btn--form btn btn-primary" name="login">
                                    Login
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</body>

</html>