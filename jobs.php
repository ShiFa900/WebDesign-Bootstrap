<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/show-pagination-btn.php";
require_once __DIR__ . "/include/footer-pagination-btn.php";
require_once __DIR__ . "/include/popup-alert.php";
require_once __DIR__ . "/include/formHeader.php";
require_once __DIR__ . "/include/include-btn-img.php";
require_once __DIR__ . "/action/pagination.php";

if (isset($_GET["reset"])) {
    redirect("jobs.php", "");
}
$user = findFirstFromDb(tableName: 'persons', key: PERSON_EMAIL, value: $_SESSION["userEmail"]);
$user = setPersonValueFromDb($user);
$jobs = getJobs();
$page = $_GET["page"] ?? 1;
$totalPage = ceil((float)count($jobs) / PAGE_LIMIT);
if ($page < 1 || $page > $totalPage || !is_numeric($page)) {
    $page = 1;
}

if (isset($_GET["keyword"])) {
    $jobsPaginated = getJobsData(limit: PAGE_LIMIT, page: $page, keyword: $_GET["keyword"]);
} else {
    $jobsPaginated = getJobsData(limit: PAGE_LIMIT, page: $page);
}

$jobs = $jobsPaginated[PAGING_DATA];
$next = $jobsPaginated[PAGING_CURRENT_PAGE] + 1;
$prev = $jobsPaginated[PAGING_CURRENT_PAGE] - 1;
$noun = setNoun(array: $jobs, text: "Job");

mainHeader(cssIdentifier: "page-jobs", title: "Person Job", link: "jobs.php", pageStyles: ["jobs.css"]);
?>
    <div class="jobs-content position-absolute px-5">
        <?php
        formHeaderPage(identifier: 'page-jobs', link: 'add-job.php', noun: $noun);

        if (isset($_SESSION["deleteSuccess"])) {
            showPopUpAlert(alertName: 'alert-success', info: $_SESSION["deleteSuccess"]);
        } elseif (isset($_SESSION["info"])) {
            showPopUpAlert(alertName: 'alert-success', info: $_SESSION["info"]);
        } elseif (isset($_SESSION["error"])) {
            showPopUpAlert(alertName: 'alert-danger', info: $_SESSION["error"]);
        }

        if (count($jobs) != 0) { ?>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="table-wrapper ">
                                <div class="table-container">
                                    <?php
                                    paginationButton(array: $jobsPaginated, prev: $prev, next: $next, page: $page, identifier: "page-jobs", keyword: $_GET["keyword"]);
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table" id="table">
                                            <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col"><?= $noun ?> Name</th>
                                                <th scope="col" class="text-center">People with this job</th>
                                                <th scope="col" class="text-center">Last update</th>
                                                <?php
                                                if ($user[PERSON_ROLE] == ROLE_ADMIN) {
                                                    ?>
                                                    <th scope="col" class="text-center">Action</th>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $number = ($page - 1) * PAGE_LIMIT + 1;
                                            foreach ($jobs as $job) {
                                                $theJob = findFirstFromDb(tableName: 'jobs', key: ID, value: $job[ID]);
                                                ?>
                                                <tr>
                                                    <td class="text-center p-3"><?= $number ?></td>
                                                    <td><?= $job[JOBS_NAME] ?></td>
                                                    <td class="text-center p-3"><?= $job[JOBS_COUNT] ?></td>
                                                    <td class="text-center p-3"><?= date("d F Y H:i", $job[JOBS_LAST_UPDATE]) ?></td>
                                                    <?php
                                                    if ($user[PERSON_ROLE] == ROLE_ADMIN) {
                                                        ?>
                                                        <td>
                                                            <div class="person-btn d-flex justify-content-center align-items-center">
                                                                <button class="btn p-0">
                                                                    <a
                                                                            href="edit-job.php?job=<?= $job[ID] ?>"
                                                                            class="nav-link table-nav block-color-btn"
                                                                    >Edit</a
                                                                    >
                                                                </button>

                                                                <button class="btn" type="button"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModal<?= $job[ID] ?>"
                                                                ><a class="delete-btn nav-link table-nav"
                                                                    href="#"
                                                                    >Delete</a>
                                                                </button>
                                                                <!-- Modal -->
                                                                <div
                                                                        class="modal fade"
                                                                        id="exampleModal<?= $job[ID] ?>"
                                                                        tabindex="-1"
                                                                        aria-labelledby="exampleModalLabel"
                                                                        aria-hidden="true"
                                                                >
                                                                    <?php
                                                                    showModalAlert(name: $job[JOBS_NAME], count: $job[JOBS_COUNT], id: $job[ID]);
                                                                    ?>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            showBtnBack('persons.php');
            showNoDataImg();
        }
        ?>
    </div>

<?php
mainFooter("jobs.php");
unset($_SESSION["deleteSuccess"]);
unset($_SESSION["info"]);
unset($_SESSION["currentHobby"]);
unset($_SESSION["error"]);