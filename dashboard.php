<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();
// set default timezone
date_default_timezone_set('Asia/Singapore');

mainHeader(
    cssIdentifier: "page-dashboard",
    title: "Dashboard",
    link: "dashboard.php",
    pageStyles: ["dashboard.css"]
);

// get user data by given email
$countAllPerson = getCountAllPerson();
$jobs = getJobs();
$user = findFirstFromArray(tableName: 'persons', key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
$user[PERSON_LAST_LOGGED_IN] = convertDateToTimestamp($user[PERSON_LAST_LOGGED_IN]);
// mencari user yang dengan email yang sama dengan yang ada di database

// get count of each category
try {
    $personProductive = getProductiveCategory();
    $personChild = getChildCategory();
    $personElderly = getElderlyCategory();
} catch (Exception $e) {
    die("Query error: " . $e->getMessage());
}

// get persons data with status passed away
$personPassedAway = checkPersonStatus();
?>
    <div class="w-100">
        <div class="dashboard-content px-5 position-absolute">
            <div class="page-header">
                <div class="col-xxl-8">
                    <h1 class="first-heading">Hi,
                        <?php
                        echo $user[PERSON_FIRST_NAME] . "!";
                        ?>
                    </h1>
                    <?php
                    if ($user[PERSON_LAST_LOGGED_IN] != null) {
                        ?>
                        <p class="header-sm-title">
                            You were logged in previously in
                            <?php
                            echo "<strong>";
                            echo date('l, F d Y H:i:s', $user[PERSON_LAST_LOGGED_IN]);
                            echo "</strong>";
                            ?>
                        </p>
                        <?php
                    } else {
                        ?>
                        <p class="header-sm-title">
                            Welcome to Dashboard of <strong>Person Management App</strong>
                        </p>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="content-wrapper">
                <div class="subheading mb-3 ms-2">
                    <div class="col-xxl-8">
                        <h1 class="second-heading">
                            Cards list
                        </h1>
                    </div>
                </div>
                <div class="row dashboard">
                    <div class="dashboard-card col-12 col-xxl-3 col-xl-4 col-lg-5 col-md-6">
                        <a class="card card-link" href="persons.php?category=<?= CATEGORIES_ALL ?>">
                            <div class="card-body">
                                <div class="wrapper d-flex align-items-center column-gap-3">
                                    <p class="number"><?= $countAllPerson ?></p>
                                    <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                        Number of persons
                                    </h4>
                                </div>
                                <p class="card-text">
                                    Total number of persons.
                                </p>

                            </div>
                        </a>
                    </div>

                    <div class="dashboard-card col-12 col-xxl-3 col-xl-4 col-lg-5 col-md-6">
                        <a class="card card-link" href="persons.php?category=<?= CATEGORIES_PRODUCTIVE_AGE ?>">
                            <div class="card-body">
                                <div class="wrapper d-flex align-items-center column-gap-3">
                                    <p class="number"><?= count($personProductive) ?></p>
                                    <h4 class="card-subtitle third-heading text-body-secondary">
                                        Productive ages
                                    </h4>
                                </div>
                                <p class="card-text">
                                    Total number of persons aged more than 17 years old, and less than 65 years old.
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="dashboard-card col-12 col-xxl-3 col-xl-4 col-lg-5 col-md-6">
                        <a class="card card-link" href="persons.php?category=<?= CATEGORIES_CHILD ?>">
                            <div class="card-body">
                                <div class="wrapper d-flex align-items-center column-gap-3">
                                    <p class="number"><?= count($personChild) ?></p>
                                    <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                        Children
                                    </h4>
                                </div>
                                <p class="card-text">
                                    Total number of children, aged less than 17 years old.
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="dashboard-card col-12 col-xxl-3 col-xl-4 col-lg-5 col-md-6">
                        <a class="card card-link" href="persons.php?category=<?= CATEGORIES_ELDERLY ?>">
                            <div class="card-body">
                                <div class="wrapper d-flex align-items-center column-gap-3">
                                    <p class="number"><?= count($personElderly) ?></p>
                                    <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                        Elderly
                                    </h4>
                                </div>
                                <p class="card-text">
                                    Total number of persons aged more than 65 years old.
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="dashboard-card col-12 col-xxl-3 col-xl-4 col-lg-5 col-md-6">
                        <a class="card card-link" href="persons.php?category=<?= CATEGORIES_PASSED_AWAY ?>">
                            <div class="card-body">
                                <div class="wrapper d-flex align-items-center column-gap-3">
                                    <p class="number"><?= count($personPassedAway) ?></p>
                                    <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                        Passed away
                                    </h4>
                                </div>
                                <p class="card-text">
                                    Total number of people who have died.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row dashboard-table">
                    <div class="subheading mb-2">
                        <div class="col-xxl-8">
                            <h1 class="second-heading">
                                <a href="jobs.php" class="nav-link">Jobs list</a>
                            </h1>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-lg-12 col-md-12 p-0">
                        <div class="table-container">
                            <div class="table-responsive">
                                <div class="wrapper table-wrapper">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col">Job name</th>
                                            <th scope="col" class="text-center">Being used by people</th>
                                            <th scope="col" class="text-center">Last update</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $number = 1;
                                        foreach ($jobs as $job) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= $number ?></td>
                                                <td><?= $job[JOBS_NAME] ?></td>
                                                <td class="text-center"><?= $job[JOBS_COUNT] ?></td>
                                                <td class="text-center"><?= date("d F Y H:i", $job[JOBS_LAST_UPDATE]) ?></td>
                                            </tr>
                                            <?php
                                            $number++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
mainFooter("dashboard.php");