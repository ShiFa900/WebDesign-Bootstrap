<?php
function showPopupAlert(string $name, int $count, int $id): void
{
    if ($count === 0) {
        ?>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title"
                        id="exampleModalLabel">
                        Are you sure want to delete
                        job <?= '"' . $name . '" ' ?>
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
                        <a class="btn pop-up-btn-hover"
                           href="../action/action-delete-job.php?job=<?= $id ?>">
                            Yes</a>
                    </button>
                </div>
            </div>
        </div>
        <?php
    } else { ?>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title"
                        id="exampleModalLabel">
                        Sorry, the job <?= '"' . $name . '" ' ?> is being used by <?= $count ?>
                        persons.
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
                        Back
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
}

