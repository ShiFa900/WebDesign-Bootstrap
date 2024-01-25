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
        array $displayingData,
        int $prev,
        int $next,
        int $page,
        string|null $keyword = null,
        string|null $category = null): void
{

    if ($page <= 1) {
        ?>
        <button class="btn" disabled>
            <a class="nav-link d-flex justify-content-end">
                <ion-icon src="/assets/properties/icon/chevron-back-outline.svg"
                          class="material-symbols-outlined"></ion-icon>
            </a>
        </button>

        <?php
    } else {
        if (isset($_GET["keyword"]) || isset($_GET["category"])) {
            ?>

            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $prev ?>&category=<?= $category ?>&keyword=<?= $keyword ?>">
                    <ion-icon src="/assets/properties/icon/chevron-back-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </a>
            </button>
            <?php
        } else {
            ?>
            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $prev ?>">
                    <ion-icon src="/assets/properties/icon/chevron-back-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
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
                <ion-icon src="/assets/properties/icon/chevron-forward-outline.svg"
                          class="material-symbols-outlined"></ion-icon>
            </a>
        </button>
        <?php
    } else {
        if (isset($category) || isset($keyword)) {
            ?>
            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $next ?>&category=<?= $category ?>&keyword=<?= $keyword ?>">

                    <ion-icon src="/assets/properties/icon/chevron-forward-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </a>
            </button>
            <?php
        } else {
            ?>
            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $next ?>">
                    <ion-icon src="/assets/properties/icon/chevron-forward-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </a>
            </button>
            <?php
        }
        ?>
        <?php
    }
}

