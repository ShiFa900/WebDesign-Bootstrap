<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/show-pagination-btn.php";
require_once __DIR__ . "/include/footer-pagination-btn.php";
require_once __DIR__ . "/include/formHeader.php";
require_once __DIR__ . "/include/include-btn-img.php";
require_once __DIR__ . "/include/popup-alert.php";
require_once __DIR__ . "/action/pagination.php";

redirectIfNotAuthenticated();
if (isset($_GET["reset"])) {
    redirect("../persons.php", "");
}
mainHeader(cssIdentifier: "page-persons", title: "Persons View", link: "persons.php", pageStyles: ['persons.css']);

// get current user data
$userRole = findFirstFromDb(tableName: 'persons', key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
$userRole = setPersonValueFromDb($userRole);
$page = $_GET["page"] ?? 1;
// set page for paginated data, page cannot less than 1, bigger than total page and not a numeric
if ($page < 1 || !is_numeric($page)) {
    $page = 1;
}
if (isset($_GET["keyword"]) || isset($_GET["category"])) {
    if (!isset($_GET['keyword'])) {
        $_GET["keyword"] = '';
    }
    $personPaginated = getPersons(PAGE_LIMIT, $page, $_GET["category"], $_GET["keyword"]);
    if ($page > $personPaginated[PAGING_TOTAL_PAGE]) {
        $page = 1;
        $personPaginated = getPersons(PAGE_LIMIT, $page, $_GET["category"], $_GET["keyword"]);
    }
} else {
    // get default data person (all persons)
    $personPaginated = getPersons(PAGE_LIMIT, $page, CATEGORIES_ALL);
    if ($page > $personPaginated[PAGING_TOTAL_PAGE]) {
        $page = 1;
        $personPaginated = getPersons(PAGE_LIMIT, $page, CATEGORIES_ALL);
    }
}

$persons = $personPaginated[PAGING_DATA];
$prev = $personPaginated[PAGING_CURRENT_PAGE] - 1;
$next = $personPaginated[PAGING_CURRENT_PAGE] + 1;
$noun = setNoun($persons, "Person"); // set pronounce
?>
    <div class="person-content position-absolute px-5">
        <?php
        if (isset($_GET["category"])) {
            if($_GET["category"] === '') $_GET["category"] = CATEGORIES_ALL;
            formHeaderPage(identifier: 'page-persons', link: 'add-person.php', noun: $noun, category: $_GET["category"]);
        } else {
            formHeaderPage(identifier: 'page-persons', link: 'add-person.php', noun: $noun);
        }

        if (isset($_SESSION["user"])) {
            showPopUpAlert(alertName: 'alert-danger', info: $_SESSION['user']);
        } elseif (isset($_SESSION["deleteSuccess"])) {
            showPopUpAlert(alertName: 'alert-success', info: $_SESSION["deleteSuccess"]);
        } elseif (isset($_SESSION["error"])) {
            showPopUpAlert(alertName: 'alert-danger', info: $_SESSION["error"]);
        } elseif ((isset($_SESSION["info"]))) {
            showPopUpAlert(alertName: 'alert-succes', info: $_SESSION["info"]);
        }

        if (count($persons) == 0) {
            // show this img if person data not found
            showNoDataImg();
        } else {
            ?>
            <div class="table-wrapper">
                <?php
                if (isset($_GET["category"]) || isset($_GET["keyword"])) {
                    paginationButton(array: $personPaginated, prev: $prev, next: $next, page: $page, identifier: "page-persons", keyword: $_GET["keyword"], category: $_GET["category"]);
                } else {
                    paginationButton(array: $personPaginated, prev: $prev, next: $next, page: $page, identifier: "page-persons");
                }
                ?>
                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center p-3">No</th>
                            <th scope="col">Email</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center p-3">Age</th>
                            <th scope="col" class="text-center p-3">Role</th>
                            <th scope="col" class="text-center p-3">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $number = ($page - 1) * PAGE_LIMIT + 1;
                        foreach ($persons as $person) {
                            $personsRole = sortRole(transformRoleFromDb($person[PERSON_ROLE]));
                            try {
                                $personAge = calculateAge(convertDateToTimestamp($person[PERSON_BIRTH_DATE]));
                            } catch (Exception $e) {
                                die("Calculate error: " . $e->getMessage());
                            }
                            foreach ($personsRole as $role) {
                                if ($role == transformRoleFromDb($person[PERSON_ROLE])) {
                                    $personRole = ROLE_LABEL[$role . "_LABEL"];
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $number ?></td>
                                        <td><?= $person[PERSON_EMAIL] ?></td>
                                        <td><?= $person[PERSON_FIRST_NAME] . " " . $person[PERSON_LAST_NAME] ?></td>
                                        <td class="text-center"><?= $personAge ?></td>
                                        <td class="text-center"><?= $personRole ?></td>
                                        <td class="text-center"><?= translateIntToString($person[PERSON_STATUS]) ?></td>

                                        <td>
                                            <div class="person-btn d-flex justify-content-center align-items-center">
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
                                                            class="nav-link table-nav block-color-btn"
                                                    >View</a
                                                    >
                                                </button>
                                                <?php
                                                if ($userRole[PERSON_ROLE] == ROLE_ADMIN) {
                                                    ?>
                                                    <button class="btn">

                                                        <a <?php
                                                        if ($person[PERSON_EMAIL] != $_SESSION["userEmail"]) {
                                                            ?> href="edit-person.php?person=<?php echo $person[ID] ?>"
                                                            <?php
                                                        }
                                                        ?> href="my-profile.php" class="nav-link table-nav border-btn">Edit</a>
                                                    </button>
                                                    <?php
                                                }
                                                ?>
                                                <button class="btn" name="btn-view">
                                                    <a
                                                        <?php
                                                        if ($person[PERSON_EMAIL] != $_SESSION["userEmail"]) {
                                                            ?>
                                                            href="hobbies.php?person=<?php echo $person[ID] ?>"
                                                            <?php
                                                        }
                                                        ?>
                                                            class="nav-link table-nav btn-block"
                                                    >Hobby</a
                                                    >
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
            </div>
            <?php
        } ?>
    </div>
<?php
mainFooter("persons.php");
unset($_SESSION["deleteSuccess"]);
unset($_SESSION["user"]);
unset($_SESSION["error"]);
unset($_SESSION["info"]);
