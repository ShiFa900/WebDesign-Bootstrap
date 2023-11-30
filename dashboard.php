<?php
// include ("./action/dashboard-action.php");
include("/home/shifa/Programming/WebPage/02-Practice/WebDesign-Bootstrap/action/dashboard-action.php");
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://unpkg.com/@popperjs/core@2"></script>

  <!-- link icon -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <!-- link font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Open+Sans:wght@400;500;600;700&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- link styling -->
  <link rel="stylesheet" href="assets/css/general.css" />
  <link rel="stylesheet" href="assets/css/persons.css" />
  <link rel="stylesheet" href="assets/css/dashboard.css" />

  <link rel="stylesheet" href="assets/query/media-query-min.css" />

  <title>Welcome to PerMap!</title>
</head>

<body>
  <header class="header sticky-top d-flex align-items-center justify-content-between">
    <a href="#" id="logo">
      <img src="assets/properties/pma-border.png" alt="PerMap logo" class="logo" />
    </a>

    <div class="head-wrapper d-flex align-items-center">
      <button class="btn btn-primary d-xxl-none d-xl-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
        <ion-icon name="menu-outline" class="icon"></ion-icon>
      </button>
      <a class="nav-link">
        <div class="dropdown">
          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar">
              <img src="assets/properties/image.png" class="avatar-md avatar-img" alt="User profile" />

              <?php


              ?>

            </div>
          </a>

          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="my-profile.html"><ion-icon name="person-circle-outline" class="icon"></ion-icon>Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><ion-icon name="notifications-outline" class="icon"></ion-icon>Notifications</a>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <a class="dropdown-item" href="#"><ion-icon name="log-out-outline" class="icon"></ion-icon>Log
                out</a>
            </li>
          </ul>
        </div>
      </a>
    </div>
  </header>

  <main>
    <section class="dashboard-section d-flex position-relative">
      <div class="sidebar d-none d-lg-block">
        <nav class="header-nav d-flex flex-column justify-content-between">
          <ul>
            <li class="nav-item" id="dashboard-active">
              <a href="dashboard.html" class="nav-link active">
                <ion-icon name="speedometer-outline" class="icon sidebar-icon"></ion-icon>Dashboard
              </a>
            </li>

            <li class="nav-item">
              <a href="persons.html" class="nav-link active">
                <ion-icon name="person-outline" class="icon sidebar-icon"></ion-icon>Persons
              </a>
            </li>
            <li class="nav-title fourth-heading">My account</li>
            <li>
              <ul>
                <li class="nav-item">
                  <a href="my-profile.html" class="nav-link active">
                    <ion-icon name="create-outline" class="icon sidebar-icon"></ion-icon>
                    Edit profile
                  </a>
                </li>
                <li class="nav-item">
                  <div class="wrappe">
                    <a href="#" class="nav-link active">
                      <ion-icon name="log-out-outline" class="icon sidebar-icon"></ion-icon>
                      Log out
                    </a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
          <div class="sidebar-footer">
            <hr />
            <ul>
              <li class="nav-item">
                <a class="nav-link active" href="#"><ion-icon name="settings-outline" class="icon sidebar-icon"></ion-icon>Settings
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>

      <div class="w-100">
        <div class="dashboard-content px-5 position-absolute">
          <div class="page-header">
            <div class="col-xxl-8">
              <h1 class="first-heading">Hi,
                <?php
                // if (isset($_GET["name"]) == 1) {
                //   echo $_GET["nama"];
                // }

                //                $user = hasLogin();
                //                echo $user["firstName"];
                ?>
              </h1>
              <p class="header-sm-title">
                You were logged in previously in
                <strong>Sunday, 19 November 2023 10:43 PM</strong>
              </p>
            </div>
          </div>

          <div class="row dashboard">
            <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
              <div class="card">
                <div class="card-body">
                  <p class="number">153</p>
                  <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                    Number of persons
                  </h4>
                  <p class="card-text">
                    Explicabo quaerat expedita sunt nesciunt blanditiis neque
                    ratione officia, Lorem, ipsum dolor sit amet consectetur
                    adipisicing elit. Laudantium rem hic illum praesentium
                    repellat quam voluptate sapiente doloribus, odit maiores,
                    fuga magnam.
                  </p>
                  <a href="#" class="card-link">More &rarr;</a>
                </div>
              </div>
            </div>
            <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
              <div class="card">
                <div class="card-body">
                  <p class="number">87</p>
                  <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                    In productive ages
                  </h4>
                  <p class="card-text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Nam qui earum, Lorem, ipsum dolor sit amet consectetur
                    adipisicing elit. Est non, quo, nulla quasi dolores
                    accusantium assumenda dolorum sed, animi placeat maiores
                    libero eius perspiciatis nobis. Non eos assumenda
                    molestiae incidunt.
                  </p>
                  <a href="#" class="card-link">More &rarr;</a>
                </div>
              </div>
            </div>
            <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
              <div class="card">
                <div class="card-body">
                  <p class="number">29</p>
                  <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                    Children
                  </h4>
                  <p class="card-text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit
                    Reprehenderit Lorem ipsum dolor sit amet, consectetur
                    adipisicing elit. Consequatur, exercitationem eos odit,
                    velit aperiam perspiciatis atque asperiores quia
                    architecto minima quis deserunt reiciendis. Corporis
                    neque, assumenda omnis voluptate rem recusandae.
                  </p>
                  <a href="#" class="card-link">More &rarr;</a>
                </div>
              </div>
            </div>
            <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
              <div class="card">
                <div class="card-body">
                  <p class="number">22</p>
                  <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                    Elderly
                  </h4>
                  <p class="card-text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit
                    Reprehenderit Lorem ipsum dolor sit amet, consectetur
                    adipisicing elit. Ipsum quibusdam excepturi voluptatibus
                    hic eveniet, corporis quae suscipit distinctio eos quo sit
                    doloribus a rem blanditiis fugiat quis odit, nulla
                    corrupti!
                  </p>
                  <a href="#" class="card-link">More &rarr;</a>
                </div>
              </div>
            </div>

            <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
              <div class="card">
                <div class="card-body">
                  <p class="number">5</p>
                  <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                    Passed away
                  </h4>
                  <p class="card-text">
                    Explicabo quaerat expedita sunt nesciunt blanditiis neque
                    ratione officia Lorem ipsum dolor sit amet consectetur
                    adipisicing elit. Architecto, culpa error perferendis quis
                    quos voluptate nostrum nemo, omnis debitis aliquam quam
                    magni. Unde, sunt laboriosam? Provident doloribus error
                    nam dignissimos.
                  </p>
                  <a href="#" class="card-link">More &rarr;</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- sidebar -->
  <nav class="header-nav d-flex align-items-center">
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
      <div class="offcanvas-header">
        <h3 class="offcanvas-title third-heading sidebar-heading" id="offcanvasScrollingLabel">
          <a href="#" id="logo">
            <img src="assets/properties/pma-color.png" alt="PerMap logo" class="logo" />
          </a>
        </h3>

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body d-flex flex-column justify-content-between py-0 px-0">
        <div class="offcanvas-body">
          <ul>
            <li class="nav-item" id="dashboard-active">
              <a href="dashboard.html" class="nav-link active">
                <ion-icon name="speedometer-outline" class="icon sidebar-icon"></ion-icon>Dashboard
              </a>
            </li>

            <li class="nav-item nav-item-highlight">
              <a href="persons.html" class="nav-link">
                <ion-icon name="person-outline" class="icon sidebar-icon"></ion-icon>Persons
              </a>
            </li>
            <li class="nav-title fourth-heading">My account</li>
            <li>
              <ul>
                <li class="nav-item">
                  <a href="my-profile.html" class="nav-link active">
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
          <hr />
          <ul>
            <li class="nav-item">
              <a class="nav-link" href="#"><ion-icon name="settings-outline" class="icon sidebar-icon"></ion-icon>Settings
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</body>

</html>