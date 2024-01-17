<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/index.php";
require_once __DIR__ . "/action/action-dashboard.php";

mainHeader(
	cssIdentifier: "page-dashboard",
	title: "Dashboard",
	link: "dashboard.php",
	pageStyles: [ "dashboard.css" ]
);
?>

    <div class="w-100">
        <div class="dashboard-content px-5 position-absolute">
            <div class="page-header">
                <div class="col-xxl-8">
                    <h1 class="first-heading">Hi,
						<?php
                        $user = getPerson(email: $_SESSION["userEmail"]);
						echo $user[PERSON_FIRST_NAME] . "!";
						?>
                    </h1>
					<?php
					if ( $user[PERSON_LAST_LOGGED_IN] != null ) {
						?>
                        <p class="header-sm-title">
                            You were logged in previously in
							<?php
							date_default_timezone_set( 'Asia/Singapore' );
							echo "<strong>";
							echo date( 'l, F d Y H:i', $user[PERSON_LAST_LOGGED_IN] );
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
                    <a class="card card-link" href="persons.php?category=<?=replaceSpace(CATEGORIES_ALL)?>">
                        <div class="card-body">
                            <p class="number">153</p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                Number of persons
                            </h4>
                            <p class="card-text">
                                Number of persons in Person Management App.
                            </p>

                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?=CATEGORIES_PRODUCTIVE_AGE?>">
                        <div class="card-body">
                            <p class="number">87</p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                In productive ages
                            </h4>
                            <p class="card-text">
                                Number of persons with Productive Age category.
                            </p>
                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?=replaceSpace(CATEGORIES_CHILD)?>">
                        <div class="card-body">
                            <p class="number">29</p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                Children
                            </h4>
                            <p class="card-text">
                                Number of persons with Children category.
                            </p>
                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link"href="persons.php?category=<?=replaceSpace(CATEGORIES_ELDERLY)?>">
                        <div class="card-body">
                            <p class="number">22</p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                Elderly
                            </h4>
                            <p class="card-text">
                                Number of persons with Elderly category.
                            </p>
                        </div>
                    </a>
                </div>

                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?=replaceSpace(CATEGORIES_PASSED_AWAY)?>">
                        <div class="card-body">
                            <p class="number">5</p>
                            <h4 class="card-subtitle third-heading mb-2 text-body-secondary">
                                Passed away
                            </h4>
                            <p class="card-text">
                                Number of persons Passed Away.
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
mainFooter( "dashboard.php" );