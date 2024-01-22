<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/showPaginationButton.php";
require_once __DIR__ . "/index.php";
require_once __DIR__ . "/action/action-persons.php";
require_once __DIR__ . "/action/pagination.php";

$persons = getAll();

?>

<?php
mainHeader(cssIdentifier: "page-persons", title: "Persons View", link: "persons.php", pageStyles: ['persons.css']);

$persons = getAll();
if (isset($_GET["keyword"]) || isset($_GET["category"])) {
    $result = search(persons: $persons, category: $_GET["category"], keyword: $_GET["keyword"]);
    if (!is_null($result)) {
        $persons = $result;
    }
}
$totalPage = ceil((float)count($persons) / (float)PAGE_LIMIT);

$page = $_GET["page"] ?? 1;
if($page <= 0 || !is_numeric($page) || $page > $totalPage){
    $page = 1;
}
$displayingData = getPaginatedData(array: $persons, page: $page, limit: PAGE_LIMIT, totalPage: $totalPage);
$persons = $displayingData[PAGING_DATA];
$prev = $displayingData[PAGING_CURRENT_PAGE] - 1;
$next = $displayingData[PAGING_CURRENT_PAGE] + 1;


?>
    <div class="person-content position-absolute px-5">
        <div
                class="content-wrapper d-flex justify-content-between"
        >
            <div class="left d-flex gap-4 page-header ">
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
                    class="right"
            >
                <!--SEARCH-->
                <form
                        class="search-form d-flex column gap-2"
                        name="search-form"
                        action="#table"
                        method="get"
                >
                    <div class="wrapper ">
                        <!-- menggunakan select -->
                        <select
                                id="form-select-catagories"
                                class="form-select form-select-lg mb-1"
                                aria-label="Select age category"
                                name="category"

                        >
                            <?php
                            if (isset($_GET["category"])) {
                                $arrayCategories = sortCategories($_GET["category"]);
                                foreach ($arrayCategories as $category) {
                                    ?>
                                    <option
                                            value="<?= $category ?>"<?php if ($category === $_GET["category"]) echo "selected name='category'" ?>>
                                        <?= CATEGORY_LABEL[$category . "_LABEL"] ?></option>
                                    <?php
                                }
                                ?>
                                <?php
                            } else {
                                ?>
                                <option value="<?= CATEGORIES_ALL ?>"><?= CATEGORY_LABEL["CATEGORIES_ALL_LABEL"] ?></option>
                                <option value="<?= CATEGORIES_PRODUCTIVE_AGE ?>"><?= CATEGORY_LABEL["CATEGORIES_PRODUCTIVE_AGE_LABEL"] ?></option>
                                <option value="<?= CATEGORIES_CHILD ?>"><?= CATEGORY_LABEL["CATEGORIES_CHILD_LABEL"] ?></option>
                                <option value="<?= CATEGORIES_ELDERLY ?>"><?= CATEGORY_LABEL["CATEGORIES_ELDERLY_LABEL"] ?></option>
                                <option value="<?= CATEGORIES_PASSED_AWAY ?>"><?= CATEGORY_LABEL["CATEGORIES_PASSED_AWAY_LABEL"] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="wrapper d-flex column-gap-2">
                        <div class="form-search w-100">
                            <input
                                    id="search"
                                    class="form-control form-control-sm"
                                    type="search"
                                    placeholder="Search..."
                                    aria-label="Search"
                                    name="keyword"
                                    value="<?php if (isset($_GET["keyword"])) {
                                        echo $_GET["keyword"];
                                    } else {
                                        $_GET["keyword"] = null;
                                    } ?>"
                            />
                        </div>
                        <div class="btn-wrapper d-flex">
                            <button class="btn btn-outline-success" type="submit">
                                <ion-icon src="../assets/properties/icon/search-outline.svg" class="icon"></ion-icon>
                            </button>

                            <!--btn ini hanya tampil saat filter atau keyword pencarian ada-->
                            <?php
                            if (isset($_GET["keyword"]) || isset($_GET["category"])) {
                                ?>
                                <button class="btn btn-reset ms-2" name="reset">
                                    <ion-icon src="../assets/properties/icon/refresh-outline.svg"
                                              class="icon"></ion-icon>
                                </button>
                                <?php
                            }
                            ?>
                        </div>
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
            if ($_SESSION["personHasEdit"][PERSON_EMAIL] == $_SESSION["userEmail"]) {
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
        if ($persons == null) {
            ?>
            <div class="row">
                <div class="col-xl-12 d-flex flex-column justify-content-center align-items-center mt-5">
                    <div class="col-xxl-6 col-xl-8 col-lg-10 col-md-12 col-sm-12">

                        <img class="no-data-img" alt="no data found on server" src="assets/properties/no-data-pana.svg">
                    </div>
                </div>
            </div><?php
        } else {
            ?>


            <div class="table-container">
                <div class="table-responsive ">
                    <table class="table" id="table">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center p-3">No</th>
                            <th scope="col" class="p-3">Email</th>
                            <th scope="col" class="p-3">Name</th>
                            <th scope="col" class="text-center p-3">Age</th>
                            <!--                        <th scope="col" class="text-center">sex</th>-->
                            <th scope="col" class="text-center p-3">Role</th>
                            <th scope="col" class="text-center p-3">Status</th>
                            <th scope="col" class="text-center p-3"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $number = ($page - 1) * PAGE_LIMIT + 1;
                        foreach ($persons as $person) {
                            $personsRole = sortRole($person[PERSON_ROLE]);
                            foreach ($personsRole as $role) {
                                if ($role == $person[PERSON_ROLE]) {
                                    $personRole = ROLE_LABEL[$role . "_LABEL"];
                                    ?>
                                    <tr>

                                        <td class="text-center"><?= $number ?></td>
                                        <td><?= $person[PERSON_EMAIL] ?></td>
                                        <td><?= $person[PERSON_FIRST_NAME] . " " . $person[PERSON_LAST_NAME] ?></td>
                                        <td class="text-center"><?= calculateAge($person[PERSON_BIRTH_DATE]) ?></td>
                                        <!--                            <td class="text-center">-->
                                        <?php //= $person[PERSON_SEX]
                                        ?><!--</td>-->
                                        <td class="text-center"><?= $personRole ?></td>
                                        <?php
                                        $personStatus = translateBooleanToString($person[PERSON_STATUS]);
                                        ?>
                                        <td class="text-center"><?= $personStatus ?>
                                        </td>

                                        <td>
                                            <div class="person-btn d-flex justify-content-center">
                                                <button class="btn" name="btn-view">
                                                    <a

                                                        <?php
                                                        if ($person[PERSON_EMAIL] != $_SESSION["userEmail"]) {
                                                            ?>
                                                            href="view-person.php?person=<?php echo $person[ID] ?>"
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

                                                                href="edit-person.php?person=<?php echo $person[ID] ?>"
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
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            $number++;
                            ?>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="wrapper pagination-btn d-flex justify-content-end">
                        <?php

                        if (isset($_GET["category"]) || isset($_GET["keyword"])) {
                            showPaginationButton(
                                displayingData: $displayingData,
                                prev: $prev,
                                next: $next,
                                page: $page,
                                keyword: $_GET["keyword"],
                                category: $_GET["category"]);
                        } else {
                            showPaginationButton(
                                displayingData: $displayingData,
                                prev: $prev,
                                next: $next,
                                page: $page);
                        }
                        ?>
                    </div>
                </div>
            </div>

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
