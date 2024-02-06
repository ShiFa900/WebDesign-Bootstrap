<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();

checkRole($_SESSION["userEmail"], "ROLE_ADMIN");


mainHeader(cssIdentifier: "page-add-hobby", title: "Add Hobby", link: "add-hobby.php", pageStyles: ["hobbies.css"]);
?>
    <main>
        <section class="add-hobby-section d-flex position-relative">
            <!-- desktop sidebar -->
            <?php desktopSidebar("persons.php"); ?>

            <div class="w-100">
                <div class="add-hobby-content position-absolute px-5">
                    <div class="page-header">
                        <h1 class="first-heading">Add Hobby</h1>
                    </div>
                    <div class="row">
                        <div class="col-xxl-12">
                            <form class="new-person-form" action="action/action-add-hobby.php" method="post"
                                  name="addHobby">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card-wrapper">
                                            <div class="hobby-card">
                                                <div class="card-img">
                                                    <img src="assets/properties/About%20me-amico.svg"
                                                         alt="Person has hobbies" class="hobby-img">
                                                </div>
                                                <div class="card-field">
                                                    <label for="hobbyName" class="form-label">Add new hobby</label>
                                                    <input type="text" id="hobbyName" class="form-control"
                                                           name="hobbyName" maxlength="30" minlength="3"
                                                           placeholder="Your hobby">

                                                    <div class="btn-container d-flex column-gap-3">
                                                        <a class="btn btn-primary btn--form has-border" type="submit"
                                                           href="hobbies.php?person=" . >
                                                            Cancel
                                                        </a>
                                                        <button class="btn btn-primary btn--form" type="submit"
                                                                name="btn">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php mainFooter("persons.php");
