<?php

function cardBody(string $action, string $location, string $imgSrc, string $label, string|null $currentData = null): void
{
    ?>
    <form name="form-input" class="input-form" action="action/<?=$action?>" method="post">
        <div class="card-wrapper">
            <div class="form-card">
                <div class="wrapper-card-img">
                    <img src="assets/properties/<?= $imgSrc?>"
                         alt="Card image" class="card-img" style="opacity: 75%">
                </div>
                <div class="card-field">
                    <div class="mb-3 form-input">
                        <label for="name" class="form-label required"><?= $label ?></label>
                        <input type="text" id="name" class="form-control"
                               name="name" maxlength="30" minlength="3" placeholder="<?=$label ?>"
                               value="<?php
                               if ($currentData != null) {
                                   echo $currentData;
                               } ?>">
                    </div>
                    <div class="btn-container d-flex column-gap-3">
                        <a class="btn btn-primary btn--form has-border" type="submit"
                           href="../<?=$location ?>">
                            Cancel
                        </a>
                        <button class="btn btn-primary btn--form" type="submit"
                                name="btn">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
}