<?php
function formInputValues(array $person, array $arraySex, array $jobs, array|null $userInputData = null, array|null $errorData = null): void
{
    $getPersonJob = getPersonJob($person[ID]);
    ?>
    <div class="mb-3 form-input">
        <label for="f-name" class="form-label required"
        >First Name</label
        >

        <input
                id="f-name"
                type="text"
                value="<?php if (isset($userInputData)) {
                    echo $userInputData["firstName"];
                } else {
                    echo $person[PERSON_FIRST_NAME];
                } ?>"
                required
                class="form-control"
                name="firstName"
                maxlength="30"

        />
    </div>
    <div class="mb-3 form-input">
        <label for="l-name" class="form-label">Last Name</label>

        <input
                id="l-name"
                type="text"
                value="<?php if (isset($userInputData)) {
                    echo $userInputData["lastName"];
                } else {
                    echo $person[PERSON_LAST_NAME];
                } ?>"
                class="form-control"
                name="lastName"
                maxlength="15"
        />
    </div>
    <div class="mb-3 form-input">
        <label for="nik" class="form-label required">NIK</label>
        <input
                id="nik"
                type="text"
                value="<?php if (isset($userInputData["nik"])) {
                    echo $userInputData["nik"];
                } else {
                    echo $person[PERSON_NIK];
                } ?>"
                required
                class="form-control"
                name="nik"
                maxlength="16"
                minlength="16"
        />
        <?php
        if (isset($errorData['errorNik'])) {
            ?>

            <div class="alert alert-danger" role="alert">
                <?= $errorData["errorNik"] ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="mb-3 form-input">
        <label for="staticEmail" class="form-label required"
        >Email</label
        >
        <input
                id="staticEmail"
                type="email"
                value="<?php if (isset($userInputData)) {
                    echo $userInputData["email"];
                } else {
                    echo $person[PERSON_EMAIL];
                } ?>"
                required
                class="form-control"
                name="email"
        />
        <?php
        if (isset($errorData['errorEmail'])) {
            ?>

            <div class="alert alert-danger" role="alert">
                <?= $errorData["errorEmail"] ?>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="mb-3 form-input">
        <label for="datePicker" class="form-label required"
        >Date of Birth</label
        >
        <input
                id="datePicker"
                type="date"
                value="<?php if (isset($userInputData["birthDate"])) {
                    echo $userInputData["birthDate"];
                } else {
                    echo date("Y-m-d", $person[PERSON_BIRTH_DATE]);
                } ?>"
                required
                class="form-control"
                name="birthDate"
        />
        <?php
        if (isset($errorData['errorBirthDate'])) {
            ?>

            <div class="alert alert-danger" role="alert">
                <?= $errorData["errorBirthDate"] ?>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="mb-3 form-input">
        <label class="form-label required" for="sex-dropdown"
        >Sex</label
        >
        <select
                class="form-select form-control"
                id="sex-dropdown"
                required
                aria-label="Small select example"
                name="sex"
        >
            <?php
            if (isset($userInputData["sex"])) {
                $arraySex = sortSex($userInputData["sex"]);
                foreach ($arraySex as $sex) { ?>
                    <option
                            value="<?= $sex ?>"<?php if ($sex === $userInputData["sex"]) echo "selected" ?>>
                        <?= SEX_LABEL[$sex . "_LABEL"] ?></option>
                    <?php
                }
            } else {
                foreach ($arraySex as $sex) {
                    ?>
                    <option
                            value="<?= $sex ?>"<?php if ($sex === $person[PERSON_SEX]) echo "selected" ?>>
                        <?= SEX_LABEL[$sex . "_LABEL"] ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="mb-3 form-input">
        <label class="form-label required" for="job-dropdown">Job</label>
        <select id="job-dropdown" class="form-select form-control"
                aria-label="Small select example" name="jobName">
            <!-- dropdwon pekerjaan nanti value-nya akan diisi dari database jobs, dan data dari database akan increment jika jobs di create new-->
            <?php
            foreach ($jobs as $job) {
                ?>
                <option value="<?= $job[JOBS_NAME] ?>" <?php if ($job[JOBS_NAME] === $getPersonJob[JOBS_NAME]) echo "selected" ?>>
                    <?= $job[JOBS_NAME] ?>
                </option>
                <?php
            }
            ?>
        </select>
        <a href="../add-job.php" class="nav-link mt-1 add-icon">
            <div style="fill: #000000">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon"
                     viewBox="0 0 512 512">
                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="32"
                          d="M256 112v288M400 256H112"/>
                </svg>
                Create new option
            </div>
        </a>
    </div>
<?php
}

