<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/show-pagination-btn.php";
require_once __DIR__ . "/include/footer-pagination-btn.php";
require_once __DIR__ . "/include/table-3-column.php";
require_once __DIR__ . "/include/formHeader.php";
require_once __DIR__ . "/include/include-btn-img.php";
require_once __DIR__ . "/include/popup-alert.php";
require_once __DIR__ . "/action/pagination.php";

redirectIfNotAuthenticated();
$user = findFirstFromDb(tableName: 'persons', key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
$user = setPersonValueFromDb($user);
//reset category and keyword
if (isset($_GET["reset"])) {
    redirect("hobbies.php", "person=" . $_SESSION["personId"]);
}
if (isset($_GET["person"])) {
    $hobbies = getPersonHobbiesFromDb($_GET["person"]);
    $person = findFirstFromDb(tableName: 'persons', key: ID, value: $_GET["person"]);
    if ($hobbies == null && $person == null) {
        $_SESSION["error"] = "Sorry, no data found";
        redirect("persons.php", "");
    }
    $_SESSION["personId"] = $person[ID];
    $_SESSION["currentHobby"] = $hobbies;
} else {
    $hobbies = getPersonHobbiesFromDb($_SESSION["personId"]);
}
$personData = findFirstFromDb(tableName: 'persons', key: ID, value: $_SESSION["personId"]);
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
        <?php
        formHeaderPage(identifier: 'page-hobbies', link: 'add-hobby.php?person=' . $personData[ID], noun: $noun, personData: $personData);

        if (isset($_SESSION["deleteSuccess"])) {
            showPopUpAlert(alertName: 'alert-success', info: $_SESSION["deleteSuccess"]);
        } elseif (isset($_SESSION["info"])) {
            showPopUpAlert(alertName: 'alert-success', info: $_SESSION["info"]);
        } elseif (isset($_SESSION["error"])) {
            showPopUpAlert(alertName: 'alert-danger', info: $_SESSION["error"]);
        }

        if (count($hobbies) != 0) {
            tableThreeColumn(
                identifier: 'page-hobbies',
                user: $user,
                constName: HOBBIES_NAME,
                modalText: "Are you sure want to delete",
                array: $hobbies,
                dataPaginated: $hobbyPaginated,
                prev: $prev,
                next: $next,
                page: $page,
                limit: PAGE_HOBBIES_LIMIT,
                noun: $noun,
                personId: $personData[ID],
                keyword: $_GET["keyword"]);
        } else {
            showBtnBack('persons.php');
            showNoDataImg();
        }
        ?>
    </div>


<?php
mainFooter("persons.php");
unset($_SESSION["deleteSuccess"]);
unset($_SESSION["info"]);
unset($_SESSION["currentHobby"]);
unset($_SESSION["error"]);