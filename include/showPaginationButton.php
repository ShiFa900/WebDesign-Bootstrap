<?php
/**
 * show arrow as pagination button
 * @param array $displayingData
 * @param int $prev
 * @param int $next
 * @param int $page
 * @param string|null $keyword
 * @param string|null $category
 *
 */
function showPaginationButton(
    array       $displayingData,
    int         $prev,
    int         $next,
    int         $page,
    string|null $personId = null,
    string|null $keyword = null,
    string|null $category = null): void
{

    if ($page <= 1) {
        ?>
        <button class="btn" disabled>
            <a class="nav-link d-flex justify-content-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon material-symbols-outlined" viewBox="0 0 512 512">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="48" d="M328 112L184 256l144 144"/>
                </svg>
            </a>
        </button>

        <?php
    } else {
        if (isset($_GET["keyword"]) || isset($_GET["category"])) {
            ?>

            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $prev ?>&category=<?= $category ?>&keyword=<?= $keyword ?>&person=<?=$personId?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon material-symbols-outlined"
                         viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="48" d="M328 112L184 256l144 144"/>
                    </svg>

                </a>
            </button>
            <?php
        } else {
            ?>
            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $prev ?>&person=<?=$personId?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon material-symbols-outlined"
                         viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="48" d="M328 112L184 256l144 144"/>
                    </svg>

                </a>
            </button>
            <?php
        }
        ?>
        <?php
    }
    ?>

    <div class="d-flex align-items-center">
        <?= $displayingData[PAGING_CURRENT_PAGE] . " of " . $displayingData[PAGING_TOTAL_PAGE] ?>
    </div>

    <?php
    if ($page >= $displayingData[PAGING_TOTAL_PAGE]) {
        ?>
        <button class="btn" disabled>
            <a class="nav-link d-flex justify-content-end">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon material-symbols-outlined" viewBox="0 0 512 512">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="48" d="M184 112l144 144-144 144"/>
                </svg>
            </a>
        </button>
        <?php
    } else {
        if (isset($category) || isset($keyword)) {
            ?>
            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $next ?>&category=<?= $category ?>&keyword=<?= $keyword ?>&person=<?=$personId?>">

                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon material-symbols-outlined"
                         viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="48" d="M184 112l144 144-144 144"/>
                    </svg>
                </a>
            </button>
            <?php
        } else {
            ?>
            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $next ?>&person=<?=$personId?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon material-symbols-outlined" viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="48" d="M184 112l144 144-144 144"/>
                    </svg>
                </a>
            </button>
            <?php
        }
        ?>
        <?php
    }
}

