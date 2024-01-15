<?php
//
require_once __DIR__ . "/action/const.php";
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";

$persons = getAll();

?>

<?php
mainHeader(cssIdentifier: "page-persons", title: "Persons View", link: "persons.php", pageStyles: ['persons.css']);
?>
    <div class="w-100">
        <div class="person-content position-absolute px-5">
            <div
                    class="content-wrapper page-header d-flex justify-content-between"
            >
                <div class="left d-flex gap-4">
                    <h1 class="first-heading d-flex align-items-center">Persons</h1>
                    <div class="add-person d-flex justify-content-end mb-0">
                        <a href="addPerson.php" class="nav-link btn-content">
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

                            <!--                            btn ini hanya tampil saat filter atau keyword pencarian ada-->
                            <button class="btn btn-outline-primary" type="reset">
                                <ion-icon src="../assets/properties/icon/refresh-outline.svg" class="icon"></ion-icon>

                            </button>
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
            <!--            semua yan GET disini, bagusnya dijadikan SESSION-->
            <!--menampilkan pesan saat berhasil menambah data orang baru-->
            <?php
            if (isset($_SESSION["addSuccess"])) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?= end($persons)[PERSON_FIRST_NAME] ?> was successfully added to Person Management App!
                </div>
                <?php
            } elseif (isset($_SESSION["editSuccess"])) {
                ?>
                <div class="alert alert-success" role="alert">
                    Successfully edit person data of <?= $_SESSION["personHasEdit"][PERSON_FIRST_NAME] ?>!
                </div>
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
            if (isset($_SESSION["noDataFound"])) {
                ?>
                <?= $_SESSION["noDataFound"]?>
                <?php
            } else {
                ?>
                <!-- EXPAND -->
                <a class="nav-link d-flex justify-content-end" href="#table">
                    <ion-icon src="/assets/properties/icon/chevron-down-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </a>
                <div class="table-section table-responsive" id="table">

                    <table class="table">
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
                            require_once __DIR__ . "/action/actionPersons.php";
                            if (isset($_GET["keyword"])) {
                                $result = search(keyword: $_GET["keyword"], category: $_GET["category"]);
                                if (!is_null($result)) {
                                    $persons = $result;
                                }
                            }

                            $no = 1;
                            foreach ($persons

                            as $person) {
                            ?>
                            <td><?= $no++ ?></td>
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
                                            href="viewPerson.php?id=<?php echo $person[ID] ?>"
                                            <?php
                                        }
                                        ?>
                                            href="myProfile.php"
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
                                                ?>

                                                href="test.php?id=<?php echo $person[ID] ?>"
                                                <?php
                                            }
                                            ?>
                                                href="myProfile.php"
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
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            ?>

        </div>
    </div>

    <!-- sidebar -->
<?php
mainFooter("persons.php");
unset($_SESSION["addSuccess"]);
unset($_SESSION["editSuccess"]);
unset($_SESSION["personHasEdit"]);
unset($_SESSION["userNotAuthenticate"]);
