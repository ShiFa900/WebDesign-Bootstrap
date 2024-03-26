<?php
function formHeaderPage(string $identifier, string $link, string $noun, array|null $personData = null, string|null $category = null): void
{
    ?>
    <div class="content-wrapper d-xl-flex justify-content-between d-md-block">
        <div class="left d-flex">
            <div class="page-header d-flex gap-4 align-items-center">
                <!--tampilkan singular dan plural-->
                <?php
                if ($identifier === 'page-hobbies') {
                    ?>
                    <h1 class="first-heading"><?= $personData[PERSON_FIRST_NAME] . "'s " . $noun; ?>
                    </h1>
                    <?php
                } elseif ($identifier === 'page-persons' || $identifier === 'page-jobs') {
                    ?>
                    <h1 class="first-heading"><?= $noun ?></h1>
                    <?php
                }
                ?>

                <div class="added d-flex justify-content-end mb-0">
                    <a href="<?= $link ?>"
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
                    action="#"
                    method="get"
            >
                <?php
                if ($identifier === 'page-persons') {
                    ?>
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
                            if (isset($category)) {
                                $arrayCategories = sortCategories($category);
                                foreach ($arrayCategories as $c) {
                                    ?>
                                    <option
                                            value="<?= $c ?>"<?php if ($c === $category) echo "selected name='category'" ?>>
                                        <?= CATEGORY_LABEL[$c . "_LABEL"] ?></option>
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
                    <?php
                }
                ?>
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
}
