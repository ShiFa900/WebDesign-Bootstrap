<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/card.php";
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
$countAllPerson = getNumberOfPersons();
$jobs = getJobs();
$user = findFirstFromDb(tableName: 'persons', key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
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
                    <?php
                    cardDashboard(cardName: 'Number of persons', link: 'persons.php?category=' . CATEGORIES_ALL, cardText: 'Total number of person in our database. Lorem, ipsum dolor sit amet consectetur
                                    adipisicing elit.', number: $countAllPerson);
                    cardDashboard(cardName: 'Productive ages', link: 'persons.php?category=' . CATEGORIES_PRODUCTIVE_AGE, cardText: 'Total number of persons aged more than 17 years old, and less than 65 years old.', number: count($personProductive));
                    cardDashboard(cardName: 'Children', link: 'persons.php?category=' . CATEGORIES_CHILD, cardText: 'Total number of children, aged less than 17 years old, Laudantium rem hic illum praesentium
                                    repellat quam.', number: count($personChild));
                    cardDashboard(cardName: 'Elderly', link: 'persons.php?category=' . CATEGORIES_ELDERLY, cardText: 'Total number of persons aged more than 65 years old, voluptate sapiente doloribus, odit maiores,
                                    fuga magnam.', number: count($personElderly));
                    cardDashboard(cardName: 'Passed away', link: 'persons.php?category=' . CATEGORIES_PASSED_AWAY, cardText: 'Total number of people who have died, ipsum dolor sit amet consectetur.', number: count($personPassedAway));
                    ?>
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