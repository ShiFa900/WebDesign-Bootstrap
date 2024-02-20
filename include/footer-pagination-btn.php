<?php
require_once __DIR__ . "/show-pagination-btn.php";
function footerPaginationBtn(array $array, int $prev, int $next, int $page, string $identifier, int|null $personId = null, string|null $keyword = null, string|null $category = null): void
{
    if ($identifier == "page-hobbies" || $identifier == "page-jobs") {
        ?>

        <div class="pagination-btn-wrapper d-flex justify-content-between">
        <div class="wrapper">
            <button class="btn mt-2">
                <a class="nav-link btn-back d-flex justify-content-end"
                   href="../persons.php">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="ionicon material-symbols-outlined"
                         viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="48"
                              d="M328 112L184 256l144 144"/>
                    </svg>
                    <span class="short">Back</span>
                    <span class="long">Persons page</span>
                </a>
            </button>
        </div>
        <?php
    }
    ?>
    <div class="wrapper pagination-btn d-flex justify-content-end">
        <?php
        if ($category || $keyword) {
            showPaginationButton(
                displayingData: $array,
                prev: $prev,
                next: $next,
                page: $page,
                personId: $personId,
                keyword: $keyword,
                category: $category);
        } else {
            showPaginationButton(
                displayingData: $array,
                prev: $prev,
                next: $next,
                page: $page,
                personId: $personId);
        }
        ?>
    </div>
    </div>
    <?php
}