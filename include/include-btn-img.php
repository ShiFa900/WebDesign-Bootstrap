<?php
function showNoDataImg()
{
    ?>
    <div class="row">
        <div class="col-xl-12 d-flex flex-column justify-content-center align-items-center mt-5">
            <div class="col-xxl-6 col-xl-8 col-lg-10 col-md-12 col-sm-12">
                <img class="no-data-img" alt="no data found on server" src="../assets/properties/no-data-pana.svg">
            </div>
        </div>
    </div>
    <?php
}

function showBtnBack(string $link): void
{
    ?>
    <div class="wrapper">
        <button class="btn mt-2">
            <a class="nav-link btn-back d-flex justify-content-end"
               href="<?=$link?>">
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