<?php
session_start();
//
require_once __DIR__ . "/action/const.php";
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";

$persons = getAll();

?>

<?php
mainHeader(cssIdentifier: "page-persons",title: "Persons View",link: "persons.php",pageStyles: ['persons.css']);
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
                                class="search-form d-flex align-items-center gap-2"
                                name="search-form"
                                action="#table"
                                method="get"
                        >
                            <!-- menggunakan select -->
                            <select
                                    id="form-select-catagories"
                                    class="form-select form-select-lg form-select-sm"
                                    aria-label="Large select example"
                                    name="category"

                            >
                                <option selected name="category" value="<?= CATEGORIES_ALL ?>">All</option>
                                <option value="<?= CATEGORIES_PRODUCTIVE_AGE ?>">Productive ages</option>
                                <option value="<?= CATEGORIES_CHILD ?>">Children</option>
                                <option value="<?= CATEGORIES_ELDERLY ?>">Elderly</option>
                                <option value="<?= CATEGORIES_PASSED_AWAY ?>">Passed away</option>
                            </select>

                            <div class="form-search d-none d-lg-block w-100 me-1">
                                <input
                                        id="search"
                                        class="form-control form-control-sm"
                                        type="search"
                                        placeholder="Search"
                                        aria-label="Search"
                                        name="keyword"
                                        value="<?=$_GET["keyword"]?>"
                                />
                            </div>
                            <button class="btn btn-outline-success" type="submit" name="search">
                                <ion-icon src="../assets/properties/icon/search-outline.svg" class="icon"></ion-icon>
                            </button>
                        </form>
                    </div>
                </div>
                <?php

                if (isset($_GET["error"]) && $_GET["error"] === "userNotAuthenticate") {
                    ?>
                    <div class="alert alert-danger alert-popup" role="alert">
                        Sorry, your role is MEMBER. Only ADMIN can create, edit and delete person data.
                    </div>
                    <?php
                }
                ?>
                <!--menampilkan pesan saat berhasil menambah data orang baru-->
                <?php
                if (isset($_GET["msg"]) && $_GET["msg"] === "addSuccess") {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?= end($persons)[PERSON_FIRST_NAME] ?> was successfully added to Person Management App!
                    </div>
                    <?php
                } elseif (isset($_GET["msg"]) && $_GET["msg"] === "editSuccess") {
                    ?>
                    <div class="alert alert-success" role="alert">
                        Successfully edit person data of <?= $_SESSION["personHasEdit"][PERSON_FIRST_NAME] ?>!
                    </div>
                    <?php
                } elseif (isset($_GET["msg"]) && $_GET["msg"] === "deleteSuccess") {
                    ?>
                    <div class="alert alert-success" role="alert">
                        Successfuly delete person data!
                    </div>
                    <?php
                }
                ?>

                <!-- EXPAND -->
                <a class="nav-link d-flex justify-content-end" href="#table">
                    <ion-icon src="/assets/properties/icon/chevron-down-outline.svg" class="material-symbols-outlined"></ion-icon>
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
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <?php
                            require_once __DIR__ . "/action/actionPersons.php";
                            if(isset($_GET["keyword"])){
                                $result = search(keyword: $_GET["keyword"],category: $_GET["category"]);
                                if(!is_null($result)){
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
                            <td></td>


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

                                                href="editPerson.php?id=<?php echo $person[ID] ?>"
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

            </div>
        </div>

<!-- sidebar -->
<?php
mainFooter("persons.php");
