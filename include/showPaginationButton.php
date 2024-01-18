<?php

function showPaginationButton(int $page, array $displayingData, string|null $keyword = null, string|null $category = null)
{
    ?>
    <?php
    if ($page <= 1) {
        ?>
        <?php
        if ($keyword != null || $category != null) {
            ?>
            <button class="btn" disabled>
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $page ?>?category=<?= $category ?>&keyword=<?= $keyword ?>">
                    <ion-icon src="/assets/properties/icon/chevron-back-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </a>
            </button>
            <?php
        } else {
            ?>
            <button class="btn">
                <a class="nav-link d-flex justify-content-end"
                   href="?page=<?= $page ?>">
                    <ion-icon src="/assets/properties/icon/chevron-back-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </a>
            </button>
            <?php
        }
        ?>

        <?php
    } else {
        ?>
        <button class="btn">
            <a class="nav-link d-flex justify-content-end" href="?page=<?= $page ?>?category=<?= $category ?>?keyword=<?= $keyword ?>">
                <ion-icon src="/assets/properties/icon/chevron-back-outline.svg"
                          class="material-symbols-outlined"></ion-icon>
            </a>
        </button>
        <?php
    }
    ?>

    <div class="d-flex align-items-center">
        <?= $displayingData[PAGING_CURRENT_PAGE] . " of " . $displayingData[PAGING_TOTAL_PAGE] ?>
    </div>

    <?php
    if ($_GET["page"] >= $displayingData[PAGING_TOTAL_PAGE]) {
        ?>
        <?php
        if ($keyword != null || $category != null) {
            ?>
            <button class="btn" disabled>
                <a class="nav-link d-flex justify-content-end" href="?page=<?= $page ?>?category=<?= $category ?>?keyword=<?= $keyword ?>">
                    <ion-icon src="/assets/properties/icon/chevron-forward-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </a>
            </button>
            <?php
        } else {
            ?>
            <button class="btn">
                <a class="nav-link d-flex justify-content-end" href="?page=<?= $page ?>">
                    <ion-icon src="/assets/properties/icon/chevron-forward-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                </a>
            </button>
            <?php
        }
        ?>
        <?php
    } else {
        ?>
        <button class="btn">
            <a class="nav-link d-flex justify-content-end" href="?page=<?= $page ?>?category=<?= $category ?>?keyword=<?= $keyword ?>">

                <ion-icon src="/assets/properties/icon/chevron-forward-outline.svg"
                          class="material-symbols-outlined"></ion-icon>
            </a>
        </button>
        <?php
    }
    ?>

    <?php
}

?>
