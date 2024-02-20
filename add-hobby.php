<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/action/utils.php";

redirectIfNotAuthenticated();
$persons = getAll();
$person = findFirstFromArray(array: $persons, key: ID, value: $_GET["person"]);
$user = findFirstFromArray(array: $persons,key: PERSON_EMAIL,value: $_SESSION["userEmail"]);
$_SESSION["personId"] = $person[ID];
if ($user[PERSON_EMAIL] != $person[PERSON_EMAIL] && $user[PERSON_ROLE] != ROLE_ADMIN) {
    checkRole($_SESSION["userEmail"], "ROLE_ADMIN");
}

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
                    <?php
                    if (isset($_SESSION["info"])) {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_SESSION["info"] ?>!
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-xxl-12">
                            <form class="new-person-form" action="action/action-add-hobby.php" method="post"
                                  name="addHobby">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="card-wrapper">
                                            <div class="form-card">
                                                <div class="card-img">
                                                    <img src="assets/properties/About%20me-amico.svg"
                                                         alt="Person has hobbies" class="hobby-img">
                                                </div>
                                                <div class="card-field">
                                                    <label for="hobbyName" class="form-label required">Add new
                                                        hobby</label>
                                                    <input type="text" id="hobbyName" class="form-control"
                                                           name="hobbyName" maxlength="30" minlength="3"
                                                           placeholder="Your hobby" required>

                                                    <div class="btn-container d-flex column-gap-3">
                                                        <a class="btn btn-primary btn--form has-border" type="submit"
                                                           href="hobbies.php?person=<?= $person[ID] ?>">
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
unset($_SESSION["info"]);
