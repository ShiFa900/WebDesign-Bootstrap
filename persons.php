<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/index.php";
require_once __DIR__ . "/action/action-persons.php";

//$persons = getAll();

?>

<?php
mainHeader(cssIdentifier: "page-persons", title: "Persons View", link: "persons.php", pageStyles: ['persons.css']);
?>
    <div class="person-content position-absolute px-5">
        <div
                class="content-wrapper page-header d-flex justify-content-between"
        >
            <div class="left d-flex gap-4">
                <a class="first-heading nav-link" href="persons.php">
                    <h1 class="first-heading">Persons</h1>
                </a>
                <div class="add-person d-flex justify-content-end mb-0">
                    <a href="add-person.php" class="nav-link btn-content">
                        <ion-icon src="../assets/properties/icon/person-add-outline.svg" class="icon"></ion-icon>
                    </a>
                </div>
            </div>

            <div
                    class="right d-flex"
            >
                <!--SEARCH-->
                <form
                        class="search-form align-items-center gap-2 d-md-flex flex-md-row-column"
                        name="search-form"
                        action="#table"
                        method="get"
                >
                    <!-- menggunakan select -->
                    <select
                            id="form-select-catagories"
                            class="form-select form-select-lg form-select-sm mb-1"
                            aria-label="Large select example"
                            name="category"

                    >
                        <?php
                        if (isset($_GET["category"])) {
                            ?>
                        <option selected name="category"
                                value="<?= $_GET["category"] == null ? CATEGORIES_ALL : $_GET["category"] ?>"> <?= $_GET["category"] == null ? CATEGORIES_ALL : $_GET["category"] ?>
                            <?php
                            if ($_GET["category"] == CATEGORIES_ALL) {
                                ?>
                                <option value="<?= CATEGORIES_PRODUCTIVE_AGE ?>">Productive ages</option>
                                <option value="<?= CATEGORIES_CHILD ?>">Children</option>
                                <option value="<?= CATEGORIES_ELDERLY ?>">Elderly</option>
                                <option value="<?= CATEGORIES_PASSED_AWAY ?>">Passed away</option>
                                <?php
                            }
                            ?>
                            <!--conditinal untuk menampilkan sisa kategori-->
                            <?php
                            if ($_GET["category"] == CATEGORIES_PRODUCTIVE_AGE) {
                                ?>
                                <option value="<?= CATEGORIES_CHILD ?>">Children</option>
                                <option value="<?= CATEGORIES_ELDERLY ?>">Elderly</option>
                                <option value="<?= CATEGORIES_PASSED_AWAY ?>">Passed away</option>
                                <option value="<?= CATEGORIES_ALL ?>">All</option>
                                <?php
                            } elseif ($_GET["category"] == CATEGORIES_CHILD) {
                                ?>
                                <option value="<?= CATEGORIES_ELDERLY ?>">Elderly</option>
                                <option value="<?= CATEGORIES_PASSED_AWAY ?>">Passed away</option>
                                <option value="<?= CATEGORIES_ALL ?>">All</option>
                                <option value="<?= CATEGORIES_PRODUCTIVE_AGE ?>">Productive ages</option>
                                <?php
                            } elseif ($_GET["category"] == CATEGORIES_ELDERLY) {
                                ?>
                                <option value="<?= CATEGORIES_PASSED_AWAY ?>">Passed away</option>
                                <option value="<?= CATEGORIES_ALL ?>">All</option>
                                <option value="<?= CATEGORIES_PRODUCTIVE_AGE ?>">Productive ages</option>
                                <option value="<?= CATEGORIES_CHILD ?>">Children</option>

                                <?php
                            } elseif ($_GET["category"] == CATEGORIES_PASSED_AWAY) {
                                ?>
                                <option value="<?= CATEGORIES_ALL ?>">All</option>
                                <option value="<?= CATEGORIES_PRODUCTIVE_AGE ?>">Productive ages</option>
                                <option value="<?= CATEGORIES_CHILD ?>">Children</option>
                                <option value="<?= CATEGORIES_ELDERLY ?>">Elderly</option>
                                <?php
                            }
                            ?>
                            <?php
                        } else {
                            ?>
                            <option value="<?= CATEGORIES_ALL ?>">All</option>
                            <option value="<?= CATEGORIES_PRODUCTIVE_AGE ?>">Productive ages</option>
                            <option value="<?= CATEGORIES_CHILD ?>">Children</option>
                            <option value="<?= CATEGORIES_ELDERLY ?>">Elderly</option>
                            <option value="<?= CATEGORIES_PASSED_AWAY ?>">Passed away</option>
                            <?php
                        }
                        ?>
                    </select>

                    <div class="wrapper d-flex">
                        <div class="form-search w-100 me-1">
                            <input
                                    id="search"
                                    class="form-control form-control-sm"
                                    type="search"
                                    placeholder="Search"
                                    aria-label="Search"
                                    name="keyword"
                                    value="<?php if (isset($_GET["keyword"])) {
                                        echo $_GET["keyword"];
                                    } else {
                                        $_GET["keyword"] = null;
                                    } ?>"
                            />
                        </div>
                        <button class="btn btn-outline-success" type="submit">
                            <ion-icon src="../assets/properties/icon/search-outline.svg" class="icon"></ion-icon>
                        </button>

                        <!--btn ini hanya tampil saat filter atau keyword pencarian ada-->
                        <?php
                        if (isset($_GET["keyword"]) || isset($_GET["category"])) {
                            ?>
                            <button class="btn" name="reset">
                                <ion-icon src="../assets/properties/icon/refresh-outline.svg"
                                          class="icon"></ion-icon>
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
        <?php

        if (isset($_SESSION["userNotAuthenticate"])) {
            ?>
            <div class="alert alert-danger alert-popup" role="alert">
                Sorry, your role is MEMBER. Only ADMIN can create, edit and delete person data.
            </div>
            <?php
        }
        ?>
        <?php
        if (isset($_SESSION["addSuccess"])) {
            ?>
            <div class="alert alert-success" role="alert">
                <?= end($persons)[PERSON_FIRST_NAME] ?> was successfully added to Person Management App!
            </div>
            <?php
        } elseif (isset($_SESSION["editSuccess"])) {
            ?>
            <?php
            if ($_SESSION["personHasEdit"][PERSON_ROLE] == ROLE_ADMIN) {
                ?>
                <div class="alert alert-success" role="alert">
                    Your edit data was successfully saved!
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-success" role="alert">
                    Successfully edit person data of <?= $_SESSION["personHasEdit"][PERSON_FIRST_NAME] ?>!
                </div>
                <?php
            }
            ?>
            <?php
        } elseif (isset($_SESSION["deleteSuccess"])) {
            ?>
            <div class="alert alert-success" role="alert">
                Successfuly delete person data!
            </div>
            <?php
        }
        ?>


        <?php
        $persons = getAll();
        if (isset($_GET["keyword"]) || isset($_GET["category"])) {
            $result = search(persons: $persons, category: $_GET["category"], keyword: $_GET["keyword"]);
            if (!is_null($result)) {
                $persons = $result;
            }
            ?>
            <?php
        }
        ?>
        <!-- EXPAND -->

        <?php
        if ($persons == null) {
            ?>
            <div class="alert alert-danger justify-content-center" role="alert">
            <?= $_SESSION["noDataFound"] ?>
            </div<?php
        } else {
            ?>
<!--            <div class="paging">-->
<!--                <nav aria-label="Search result pages">-->
<!--                    <ul class="pagination justify-content-end">-->
<!--                        <li class="page-item disabled">-->
<!--                            <a class="page-link">Previous</a>-->
<!--                        </li>-->
<!--                        <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--                        <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--                        <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                        <li class="page-item">-->
<!--                            <a class="page-link" href="#">Next</a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </nav>-->
<!--            </div>-->
            <a class="nav-link d-flex justify-content-end" href="#table">
                <button class="btn">
                    <ion-icon src="/assets/properties/icon/chevron-down-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </button>
            </a>

            <table class="table table-responsive" id="table">
                <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Email</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">sex</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <?php
                    $displayingData = function ($data, $currentIndex, $currentPage) {
                    $page = 1;
                    $no = 1;
                    $person = $data[$currentIndex];
                    ?>
                    <td><?= $currentIndex + 1 ?></td>
                    <td><?= $person[PERSON_EMAIL] ?></td>
                    <td><?= $person[PERSON_FIRST_NAME] . " " . $person[PERSON_LAST_NAME] ?></td>
                    <td><?= calculateAge($person[PERSON_BIRTH_DATE]) ?></td>
                    <td><?= $person[PERSON_SEX] ?></td>
                    <td><?= $person[PERSON_ROLE] ?></td>
                    <?php
                    $personStatus = translateBooleanToString($person[PERSON_STATUS]);
                    ?>
                    <td><?= $personStatus ?>
                    </td>


                    <td class="d-flex">
                        <button class="btn" name="btn-view">
                            <a

                                <?php
                                if ($person[PERSON_EMAIL] != $_SESSION["userEmail"]) {
                                    ?>
                                    href="view-person.php?id=<?php echo $person[ID] ?>"
                                    <?php
                                }
                                ?>
                                    href="my-profile.php"
                                    class="nav-link table-nav view-btn"
                            >View</a
                            >
                        </button>

                        <button class="btn">
                            <?php
                            $userRole = getPerson(email: $_SESSION["userEmail"]);
                            if ($userRole[PERSON_ROLE] == ROLE_ADMIN) {
                                ?>
                                <a
                                    <?php
                                    if ($person[PERSON_EMAIL] != $_SESSION["userEmail"]) {
                                        $_SESSION["personToBeEdit"] = $person[ID];
                                        ?>

                                        href="edit-person.php?id=<?php echo $person[ID] ?>"
                                        <?php
                                    }
                                    ?>
                                        href="my-profile.php"
                                        class="nav-link table-nav edit-btn"
                                >Edit</a
                                >
                                <?php
                            }
                            ?>
                        </button>
                    </td>

                </tr>
                <?php
                };
                showPaginatedData(
                    array: $persons, callback: $displayingData, limit: PAGE_LIMIT
                );
                ?>
                </tbody>
            </table>
            <?php
        }
        ?>
    </div>

    <!-- sidebar -->
<?php
mainFooter("persons.php");
unset($_SESSION["addSuccess"]);
unset($_SESSION["editSuccess"]);
unset($_SESSION["personHasEdit"]);
unset($_SESSION["deleteSuccess"]);
unset($_SESSION["userNotAuthenticate"]);
