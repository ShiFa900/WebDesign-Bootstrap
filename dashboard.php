<?php
session_start();
require_once __DIR__ . "/action/actionDashboard.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";

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
						echo $_SESSION['userName'] . "!";
						?>
                    </h1>
					<?php
					if ( $_SESSION["logout"] != null ) {
						?>
                        <p class="header-sm-title">
                            You were logged in previously in
							<?php
							date_default_timezone_set( 'Asia/Singapore' );
							echo "<strong>";
							echo date( 'l, F d Y H:i', $_SESSION['logout'] );
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
                    <a class="card card-link" href="#">
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

                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="persons.php?category=<?php echo CATEGORIES_PRODUCTIVE_AGE ?>">
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
                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="#">
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
                        </div>
                    </a>
                </div>
                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="#">
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
                        </div>
                    </a>
                </div>

                <div class="dashboard-card col-12 col-xxl-4 col-xl-4 col-lg-5 col-md-6">
                    <a class="card card-link" href="#">
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
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
mainFooter( "dashboard.php" );