<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/showPaginationButton.php";
require_once __DIR__ . "/action/pagination.php";

redirectIfNotAuthenticated();
$persons = getAll();
$user = findFirstFromArray(array: $persons, key: PERSON_EMAIL, value: $_SESSION["userEmail"]);

if (isset($_GET["reset"])) {
    redirect("hobbies.php", "person=" . $_SESSION["personId"]);
}
if (isset($_GET["person"])) {
    $hobbies = getPersonHobbiesFromDb($_GET["person"]);
    $person = findFirstFromArray(array: $persons, key: ID, value: $_GET["person"]);
    if ($hobbies == null && $person == null) {
        $_SESSION["error"] = "Sorry, no data found";
      redirect("persons.php", "");
    }
    $_SESSION["personId"] = $person[ID];
    $_SESSION["currentHobby"] = $hobbies;
} else {
    $hobbies = getPersonHobbiesFromDb($_SESSION["personId"]);
}

$personData = findFirstFromArray(array: $persons, key: ID, value: $_SESSION["personId"]);
$page = $_GET["page"] ?? 1;
// set page for paginated data, page cannot less than 1, bigger than total page and not a numeric
$totalPage = ceil((float)count($hobbies) / PAGE_HOBBIES_LIMIT);
if ($page < 1 || $page > $totalPage || !is_numeric($page)) {
    $page = 1;
}

if (isset($_GET["keyword"])) {
    // get person data if keyword OR category is not null
    $hobbyPaginated = getHobbies(limit: PAGE_HOBBIES_LIMIT, page: $page, personId: $_SESSION["personId"], keyword: $_GET["keyword"]);
} else {
    // get default data person
    $hobbyPaginated = getHobbies(limit: PAGE_HOBBIES_LIMIT, page: $page, personId: $_SESSION["personId"]);
}
$hobbies = $hobbyPaginated[PAGING_DATA];
$prev = $hobbyPaginated[PAGING_CURRENT_PAGE] - 1;
$next = $hobbyPaginated[PAGING_CURRENT_PAGE] + 1;

$noun = setNoun(array: $hobbies, text: "Hobby");
mainHeader(cssIdentifier: "page-hobbies", title: "Person Hobbies", link: "persons.php", pageStyles: ['hobbies.css']);
?>
    <div class="hobbies-content position-absolute px-5">
        <div class="content-wrapper d-xl-flex justify-content-between d-md-block">
            <div class="left d-flex">
                <div class="page-header d-flex gap-4 align-items-center">
                    <!--tampilkan singular dan plural-->
                    <h1 class="first-heading"><?= $personData[PERSON_FIRST_NAME] . "'s " . $noun; ?>
                    </h1>
                    <div class="added d-flex justify-content-end mb-0">
                        <a href="add-hobby.php?person=<?= $personData[ID] ?>"
                           class="nav-link btn-content">
                            <div style="fill: #000000" class="header-page-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="32" d="M256 112v288M400 256H112"/>
                                </svg>
                            </div>
                        </a>
                    </div>
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
                                    minlength="3"
                            />
                        </div>
                        <div class="btn-wrapper d-flex justify-content-end">
                            <button class="btn btn-outline-success d-flex align-items-center column-gap-1"
                                    type="submit">
                                <span class="d-xl-none d-flex flex-column">Search</span>
                                <div style="fill: #000000" class="header-page-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon search-icon"
                                         viewBox="0 0 512 512">
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
                            if (isset($_GET["keyword"])) {
                                ?>
                                <button class="btn btn-reset ms-2" name="reset">
                                    <div style="fill: #000000" class="header-page-icon">
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
        if (isset($_SESSION["deleteSuccess"])) {
            ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION["deleteSuccess"] ?>
            </div>
            <?php
        } elseif (isset($_SESSION["info"])) {
            ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION["info"] ?>
            </div>
            <?php
        } elseif (isset($_SESSION["error"])) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION["error"] ?>
            </div>
            <?php
        }
        if (count($hobbies) != 0) {
            ?>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="table-wrapper d-xl-flex justify-content-center">
                                <div class="table-container">
                                    <div class="table-responsive">
                                        <table class="table" id="table">
                                            <thead>
                                            <tr>
                                                <th scope="col" class="text-center p-3">No</th>
                                                <th scope="col" class="p-3">Name</th>
                                                <?php
                                                if ($user[PERSON_ROLE] == ROLE_ADMIN) {
                                                    ?>
                                                    <th scope="col" class="text-center p-3">Action</th>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <?php
                                                $number = ($page - 1) * PAGE_HOBBIES_LIMIT + 1;
                                                foreach ($hobbies

                                                as $hobby) {
                                                ?>
                                                <td class="text-center"><?= $number ?></td>
                                                <td><?= $hobby[HOBBIES_NAME] ?></td>
                                                <?php
                                                if ($user[PERSON_ROLE] == ROLE_ADMIN) {
                                                    ?>
                                                    <td>
                                                        <div class="person-btn d-flex justify-content-center">
                                                            <button class="btn">

                                                                <a
                                                                        href="edit-hobby.php?hobby=<?= $hobby[ID] ?>"
                                                                        class="nav-link table-nav block-color-btn"
                                                                >Edit</a
                                                                >
                                                            </button>
                                                            <button class="btn" type="button"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal"
                                                            ><a class="delete-btn nav-link table-nav">Delete</a>
                                                            </button>
                                                            <!-- Modal -->
                                                            <div
                                                                    class="modal fade"
                                                                    id="exampleModal"
                                                                    tabindex="-1"
                                                                    aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true"
                                                            >
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Are you sure want to delete this hobby?
                                                                            </h1>
                                                                            <button
                                                                                    type="button"
                                                                                    class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"
                                                                            ></button>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button
                                                                                    type="button"
                                                                                    class="btn btn-secondary btn-block"
                                                                                    data-bs-dismiss="modal"
                                                                            >
                                                                                No
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="btn btn-primary"
                                                                                    name="btnDelete">
                                                                                <a href="action/action-delete-hobby.php?hobby=<?= $hobby[ID] ?>"
                                                                                   class="btn">Yes</a>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                            $number++;
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pagination-btn-wrapper d-flex justify-content-between">
                                        <div class="wrapper">
                                            <button class="btn mt-2">
                                                <a class="nav-link btn-back d-flex justify-content-end"
                                                   href="persons.php">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="ionicon material-symbols-outlined"
                                                         viewBox="0 0 512 512">
                                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="48"
                                                              d="M328 112L184 256l144 144"/>
                                                    </svg>
                                                    <span class="short">Back</span>
                                                    <span class="long">Back to the Persons page</span>
                                                </a>
                                            </button>
                                        </div>
                                        <div class="wrapper pagination-btn d-flex justify-content-end">
                                            <?php
                                            // show pagination button
                                            if (isset($_GET["keyword"])) {
                                                showPaginationButton(
                                                    displayingData: $hobbyPaginated,
                                                    prev: $prev,
                                                    next: $next,
                                                    page: $page,
                                                    personId: $personData[ID],
                                                    keyword: $_GET["keyword"],
                                                );
                                            } else {
                                                showPaginationButton(
                                                    displayingData: $hobbyPaginated,
                                                    prev: $prev,
                                                    next: $next,
                                                    page: $page,
                                                    personId: $personData[ID]);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="wrapper">
                <button class="btn">
                    <a class="nav-link d-flex justify-content-end" href="persons.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon material-symbols-outlined"
                             viewBox="0 0 512 512">
                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="48" d="M328 112L184 256l144 144"/>
                        </svg>
                        Back
                    </a>
                </button>
            </div>
            <div class="row">
                <div class="col-xl-12 d-flex flex-column justify-content-center align-items-center mt-5">
                    <div class="col-xxl-6 col-xl-8 col-lg-10 col-md-12 col-sm-12">
                        <img class="no-data-img" alt="no data found on server" src="assets/properties/no-data-pana.svg">
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>


<?php
mainFooter("persons.php");
unset($_SESSION["deleteSuccess"]);
unset($_SESSION["info"]);
unset($_SESSION["currentHobby"]);
unset($_SESSION["error"]);

