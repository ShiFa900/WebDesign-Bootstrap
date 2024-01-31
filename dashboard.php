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
$persons = getAll();
//$user = getPerson(persons: $persons,email: $_SESSION["userEmail"]);
$user = findFirstFromArray(array: $persons,key: PERSON_EMAIL,value: $_SESSION["userEmail"]);
// mencari user yang dengan email yang sama dengan yang ada di database

// get count of each category
try {
    $personProductive = getProductiveCategory($persons);
    $personChild = getChildCategory($persons);
    $personElderly = getElderlyCategory($persons);
} catch (Exception $e) {
    die("Query error: " . $e->getMessage());
}

// get persons data with status passed away
$personPassedAway = [];
foreach ($persons as $person) {
    if (!$person[PERSON_STATUS]) {
        $personPassedAway[] = $person;
    }
}
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

            <div class="row dashboard">
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?= CATEGORIES_ALL ?>"
                       title="Total number of persons.">
                        <div class="card-body">
                            <p class="number"><?= count($persons) ?></p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                Number of persons
                            </h4>
                            <p class="card-text">
                                Total number of persons.
                            </p>

                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?= CATEGORIES_PRODUCTIVE_AGE ?>"
                       title="Total number of persons aged more than 15 years old, and less than 45 years old.">
                        <div class="card-body">
                            <p class="number"><?= count($personProductive) ?></p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                In productive ages
                            </h4>
                            <p class="card-text">
                                Total number of persons aged more than 15 years old, and less than 45 years old.
                            </p>
                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?= CATEGORIES_CHILD ?>"
                       title="Total number of children, aged less than 15 years old.">
                        <div class="card-body">
                            <p class="number"><?= count($personChild) ?></p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                Children
                            </h4>
                            <p class="card-text">
                                Total number of children, aged less than 15 years old.
                            </p>
                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?= CATEGORIES_ELDERLY ?>"
                       title="Total number of persons aged more than 50 years old.">
                        <div class="card-body">
                            <p class="number"><?= count($personElderly) ?></p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                Elderly
                            </h4>
                            <p class="card-text">
                                Total number of persons aged more than 50 years old.
                            </p>
                        </div>
                    </a>
                </div>

                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?= CATEGORIES_PASSED_AWAY ?>"
                       title="Total number of people who have died.">
                        <div class="card-body">
                            <p class="number"><?= count($personPassedAway) ?></p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                Passed away
                            </h4>
                            <p class="card-text">
                                Total number of people who have died.
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
mainFooter("dashboard.php");