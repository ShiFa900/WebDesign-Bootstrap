<?php
require_once __DIR__ . "/action/utils.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/footer.php";
require_once __DIR__ . "/include/showPaginationButton.php";
require_once __DIR__ . "/action/pagination.php";

redirectIfNotAuthenticated();
mainHeader(cssIdentifier: "page-hobbies", title: "Person Hobbies", link: "persons.php", pageStyles: ['hobbies.css']);
$persons = getAll();
$hobbies = getPersonHobbiesFromDb($_GET["person"]);
$person = findFirstFromArray(array: $persons, key: ID, value: $_GET["person"]);
$_SESSION["personId"] = $person[ID];
?>
    <div class="hobbies-content position-absolute px-5">
        <div class="content-wrapper d-xl-flex justify-content-between d-md-block">
            <div class="left d-flex">
                <div class="page-header d-flex gap-4">
                    <a class="nav-link" href="persons.php">
                        <!--tampilkan singular dan plural-->
                        <h1 class="first-heading"><?php if (count($hobbies) > 1) {
                                echo "Hobbies";
                            } else {
                                echo "Hobby";
                            } ?></h1>
                    </a>
                    <div class="added d-flex justify-content-end mb-0">
                        <a href="add-hobby.php" class="nav-link btn-content">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
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
        <div class="wrapper">
            <button class="btn mt-2">
                <a class="nav-link d-flex justify-content-end" href="persons.php">
                    <ion-icon src="/assets/properties/icon/chevron-back-outline.svg"
                              class="material-symbols-outlined"></ion-icon>
                    Back
                </a>
            </button>
        </div>
        <?php
        if (count($hobbies) == 0) {
            ?>
            <div class="row">
                <div class="col-xl-12 d-flex flex-column justify-content-center align-items-center mt-5">
                    <div class="col-xxl-6 col-xl-8 col-lg-10 col-md-12 col-sm-12">

                        <img class="no-data-img" alt="no data found on server" src="assets/properties/no-data-pana.svg">
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-6 col-md-6 d-flex justify-content-center">
                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="text-center p-3">No</th>
                                            <th scope="col" class="p-3">Name</th>
                                            <th scope="col" class="text-center p-3">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <?php
                                            $number = 1;
                                            foreach ($hobbies

                                            as $hobby) {
                                            ?>
                                            <td class="text-center"><?= $number++ ?></td>
                                            <td><?= $hobby[HOBBIES_NAME] ?></td>
                                            <td>
                                                <div class="person-btn d-flex justify-content-center">
                                                    <button class="btn">

                                                        <a
                                                                href="edit-hobby.php?hobby=<?=$hobby[ID]?>"
                                                                class="nav-link table-nav block-color-btn"
                                                        >Edit</a
                                                        >
                                                    </button>
                                                    <button class="btn">
                                                        <a
                                                                href="#"
                                                                class="nav-link table-nav delete-btn"
                                                        >Delete</a
                                                        >
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
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
            <?php
        }
        ?>
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
                        <h1 class="modal-title" id="exampleModalLabel">
                            Add new hobby:
                        </h1>
                        <div class="wrapper d-flex align-items-center ms-3">
                            <form method="post" class="new-hobby-form" name="addHobby">
                                <label for="hobbyName"></label>
                                <input id="hobbyName" type="text" placeholder="example"
                                       class="form-control" maxlength="30" minlength="3">

                                <div class="modal-footer">
                                    <a href="action/action-add-hobby.php">
                                        <button type="submit" class="btn btn-secondary btn-block"
                                                name="btnSave">
                                            Save
                                        </button>
                                    </a>
                                    <button
                                            type="button"
                                            class="btn btn-primary"
                                            data-bs-dismiss="modal"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                        <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                        ></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
mainFooter("persons.php");
unset($_SESSION["deleteSuccess"]);
unset($_SESSION["user"]);
unset($_SESSION["personNotFound"]);
unset($_SESSION["info"]);
