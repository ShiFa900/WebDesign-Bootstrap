<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/showPaginationButton.php";
require_once __DIR__ . "/action/action-persons.php";
require_once __DIR__ . "/action/pagination.php";

redirectIfNotAuthenticated();

//$persons = getAll();

mainHeader(cssIdentifier: "page-persons", title: "Persons View", link: "persons.php", pageStyles: ['persons.css']);
// get current user data
$userRole = getPerson(email: $_SESSION["userEmail"]);

// showing all person data if category | keyword is null or showing person data with specific category or keyword otherwise
//$persons = getAll();
//if (isset($_GET["keyword"]) || isset($_GET["category"])) {
//    $result = search(persons: $persons, category: $_GET["category"], keyword: $_GET["keyword"]);
//    // is result is null or data not found, will show img no data found
//    if (!is_null($result)) {
//        $persons = $result;
//    }
//}

// get total page for showing person data
//$totalPage = ceil((float)count($persons) / (float)PAGE_LIMIT);

// set page for paginated data, page cannot less than 1, bigger than total page and not a numeric
$page = $_GET["page"] ?? 1;
//if ($page <= 0 || !is_numeric($page) || $page > $totalPage) {
//    $page = 1;
//}

// get the data that will be displayed on each page
//$displayingData = getPaginatedData(array: $persons, page: $page, limit: PAGE_LIMIT, totalPage: $totalPage);

$result = getPersons($page, PAGE_LIMIT, null);
$persons = $result['data'];
//// previous page
//$prev = $result['currentPage'] - 1;
//// next page
//$next = $result['currentPage'] + 1;
?>
    <div class="person-content position-absolute px-5">
    <div
            class="content-wrapper d-xl-flex justify-content-between d-md-block"
    >
        <div class="left d-flex gap-4 page-header ">
            <a class="nav-link" href="persons.php">
                <h1 class="first-heading">Persons</h1>
            </a>
            <div class="add-person d-flex justify-content-end mb-0">
                <a href="add-person.php" class="nav-link btn-content">
                    <div style="fill: #000000" class="person-img-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path d="M376 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z"
                                  fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="32"/>
                            <path d="M288 304c-87 0-175.3 48-191.64 138.6-2 10.92 4.21 21.4 15.65 21.4H464c11.44 0 17.62-10.48 15.65-21.4C463.3 352 375 304 288 304z"
                                  fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="32" d="M88 176v112M144 232H32"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <div class="right">
            <!--SEARCH-->
            <form
                    class="search-form d-xl-flex column-gap-2 mt-3"
                    name="search-form"
                    action="#table"
                    method="get"
            >
                <div class="wrapper ">
                    <!-- menggunakan select -->
                    <select
                            id="form-select-catagories"
                            class="form-select form-select-lg"
                            aria-label="Select age category"
                            name="category"

                    >
                        <?php
                        // showing search category
                        if (isset($_GET["category"])) {
                            $arrayCategories = sortCategories($_GET["category"]);
                            foreach ($arrayCategories as $category) {
                                ?>
                                <option
                                        value="<?= $category ?>"<?php if ($category === $_GET["category"]) echo "selected name='category'" ?>>
                                    <?= CATEGORY_LABEL[$category . "_LABEL"] ?></option>
                                <?php
                            }
                        } else {
                            // show this for default
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

                <div class="wrapper d-xl-flex d-md-block column-gap-2">
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
                    <div class="btn-wrapper d-flex justify-content-end">
                        <button class="btn btn-outline-success d-flex align-items-center column-gap-1"
                                type="submit">
                            <span class="d-xl-none d-flex flex-column">Search</span>
                            <div style="fill: #000000" class="person-img-icon search-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z"
                                          fill="none" stroke="currentColor" stroke-miterlimit="10"
                                          stroke-width="32"/>
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                          stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"/>
                                </svg>
                            </div>
                        </button>

                        <!--btn ini hanya tampil saat filter atau keyword pencarian ada-->
                        <?php
                        if (isset($_GET["keyword"]) || isset($_GET["category"])) {
                            ?>
                            <button class="btn btn-reset ms-2" name="reset">
                                <div style="fill: #000000" class="person-img-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                        <path d="M320 146s24.36-12-64-12a160 160 0 10160 160" fill="none"
                                              stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10"
                                              stroke-width="32"/>
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-linejoin="round" stroke-width="32" d="M256 58l80 80-80 80"/>
                                    </svg>
                                </div>
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

    if (isset($_SESSION["user"])) {
        ?>
        <div class="alert alert-danger alert-popup" role="alert">
            Sorry, your role is MEMBER. Only ADMIN can create, edit and delete person data.
        </div>
        <?php
    } elseif (isset($_SESSION["deleteSuccess"])) {
        ?>
        <div class="alert alert-success" role="alert">
            Successfuly delete person data!
        </div>
        <?php
    } elseif (isset($_SESSION["personNotFound"])) {
        ?>
        <div class="alert alert-danger" role="alert">
            Sorry, no person found.
        </div>
        <?php
    }
    // show this img if person data not found
    if ($persons == null) {
        ?>
        <div class="row">
            <div class="col-xl-12 d-flex flex-column justify-content-center align-items-center mt-5">
                <div class="col-xxl-6 col-xl-8 col-lg-10 col-md-12 col-sm-12">

                    <img class="no-data-img" alt="no data found on server" src="assets/properties/no-data-pana.svg">
                </div>
            </div>
        </div>
        <?php
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
                        <th scope="col" class="text-center p-3">Role</th>
                        <th scope="col" class="text-center p-3">Status</th>
                        <th scope="col" class="text-center p-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // number is total data in database
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
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="wrapper pagination-btn d-flex justify-content-end">
                <?php
                // show pagination button
//                if (isset($_GET["category"]) || isset($_GET["keyword"])) {
//                    showPaginationButton(
//                        displayingData: $displayingData,
//                        prev: $prev,
//                        next: $next,
//                        page: $page,
//                        keyword: $_GET["keyword"],
//                        category: $_GET["category"]);
//                } else {
//                    showPaginationButton(
//                        displayingData: $displayingData,
//                        prev: $prev,
//                        next: $next,
//                        page: $page);
//                }
                ?>
            </div>
        </div>

        <?php
    }

mainFooter("persons.php");
unset($_SESSION["addSuccess"]);
unset($_SESSION["deleteSuccess"]);
unset($_SESSION["user"]);
unset($_SESSION["personNotFound"]);
