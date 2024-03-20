<?php
function tableThreeColumn(
    string      $identifier,
    array       $user,
    string      $constName,
    string      $modalText,
    array|null  $array = null,
    array|null  $dataPaginated = null,
    int|null    $prev = null,
    int|null    $next = null,
    int|null    $page = null,
    int|null    $limit = null,
    string|null $noun = null,
    int|null    $personId = null,
    int|null    $keyword = null): void
{
    ?>
    <div class="row">
        <div class="col-xxl-12">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="table-wrapper ">
                        <div class="table-container">
                            <?php
                            if ($identifier == 'page-hobbies') {
                                paginationButton(array: $dataPaginated, prev: $prev, next: $next, page: $page, identifier: $identifier, personId: $personId, keyword: $keyword);
                            }
                            ?>
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col"><?= $noun ?> Name</th>
                                        <th scope="col" class="text-center">Last update</th>
                                        <?php
                                        if ($user[PERSON_ROLE] == ROLE_ADMIN || $user[ID] == $personId) {
                                            ?>
                                            <th scope="col" class="text-center">Action</th>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $number = ($page - 1) * $limit + 1;
                                    $dataArray = $dataPaginated[PAGING_DATA] ?? $array;
                                    foreach ($dataArray as $data) { ?>
                                        <tr>
                                            <td class="text-center"><?= $number ?></td>
                                            <td><?= $data[HOBBIES_NAME] ?></td>
                                            <td class="text-center"><?= date('d F Y H:i', $data[HOBBIES_LAST_UPDATE]) ?></td>
                                            <?php
                                            if ($user[PERSON_ROLE] == ROLE_ADMIN || $user[ID] == $personId) {
                                                ?>
                                                <td>
                                                    <div class="person-btn d-flex justify-content-center align-items-center">
                                                        <button class="btn p-0">
                                                            <a
                                                                    href="../edit-hobby.php?hobby=<?= $data[ID] ?>"
                                                                    class="nav-link table-nav block-color-btn"
                                                            >Edit</a
                                                            >
                                                        </button>
                                                        <button class="btn" type="button"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal<?= $data[ID] ?>"
                                                        ><a class="delete-btn nav-link table-nav">Delete</a>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div
                                                                class="modal fade"
                                                                id="exampleModal<?= $data[ID] ?>"
                                                                tabindex="-1"
                                                                aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true"
                                                        >
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title"
                                                                            id="exampleModalLabel">
                                                                            <?= $modalText . " '" . $data[$constName] . "'?" ?>
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
                                                                            <a href="../action/action-delete-hobby.php?hobby=<?= $data[ID] ?>"
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

                            <?php
                            if ($identifier !== 'page-hobbies') {
                                ?>
                                <div class="form-input">
                                    <a href="../add-hobby.php?person=<?= $personId ?>"
                                       class="nav-link mt-1 mb-3 add-icon">
                                        <div style="fill: #000000">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon"
                                                 viewBox="0 0 512 512">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round" stroke-width="32"
                                                      d="M256 112v288M400 256H112"/>
                                            </svg>
                                            <span class="ps-2">Create new hobby</span>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
