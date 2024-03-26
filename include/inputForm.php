<?php
function formInputValues(array $person, string $userRole, array $arraySex, array $jobs, array|null $userInputData = null, array|null $errorData = null): void
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
        <?php
        if ($userRole === ROLE_ADMIN) {
            ?>
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
            <?php
        }
        ?>
    </div>
    <?php
}

function formInputValuesOnRight(array $person, array $arrayRole, string $user, array|null $userInputData = null, array|null $errorData = null): void
{
    ?>
    <a href="../hobbies.php?person=<?= $person[ID] ?>" class="nav-link mt-1 mb-3">
        <div style="fill: #000000" class="">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon"
                 viewBox="0 0 512 512">
                <path d="M467.51 248.83c-18.4-83.18-45.69-136.24-89.43-149.17A91.5 91.5 0 00352 96c-26.89 0-48.11 16-96 16s-69.15-16-96-16a99.09 99.09 0 00-27.2 3.66C89 112.59 61.94 165.7 43.33 248.83c-19 84.91-15.56 152 21.58 164.88 26 9 49.25-9.61 71.27-37 25-31.2 55.79-40.8 119.82-40.8s93.62 9.6 118.66 40.8c22 27.41 46.11 45.79 71.42 37.16 41.02-14.01 40.44-79.13 21.43-165.04z"
                      fill="none" stroke="currentColor" stroke-miterlimit="10"
                      stroke-width="32"/>
                <circle cx="292" cy="224" r="20"/>
                <path d="M336 288a20 20 0 1120-19.95A20 20 0 01336 288z"/>
                <circle cx="336" cy="180" r="20"/>
                <circle cx="380" cy="224" r="20"/>
                <path fill="none" stroke="currentColor" stroke-linecap="round"
                      stroke-linejoin="round" stroke-width="32"
                      d="M160 176v96M208 224h-96"/>
            </svg>
            <span class="ps-2">Manage person hobby</span>
        </div>
    </a>
    <?php
    showGetRoleAndNote(arrayRole: $arrayRole, person: $person, user: $user, userInputData: $userInputData);
    ?>
    <hr/>
    <?php
    showPassForm($errorData);
}

function showGetRoleAndNote(array $arrayRole, array $person, string $user, array|null $userInputData = null): void
{ ?>
    <div class="mb-4 form-input">
        <label class="form-label" for="role-dropdown"
        >Role</label
        >
        <select
                id="role-dropdown"
                class="form-select form-control"
                aria-label="Small select example"
                name="role"
        >
            <?php
            if (isset($userInputData["role"])) {
                $arrayRole = sortRole($userInputData["role"]);
                foreach ($arrayRole as $role) {
                    ?>
                    <option
                            value="<?= $role ?>"<?php if ($role === $userInputData["role"]) echo "selected" ?>>
                        <?= ROLE_LABEL[$role . "_LABEL"] ?></option>
                    <?php
                }
            } else {
                foreach ($arrayRole as $role) {
                    ?>
                    <option
                            value="<?= $role ?>"<?php if ($role === $person[PERSON_ROLE]) echo "selected" ?>>
                        <?= ROLE_LABEL[$role . "_LABEL"] ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
    <?php
    if ($user === ROLE_ADMIN) {
        ?>
        <div class="mb-3 form-input">
            <label for="note" class="form-label"
            >Internal notes</label>
            <div class="form-floating mb-4">
              <textarea
                      class="form-control"
                      placeholder="Leave a comment here"
                      id="note"
                      name="note"
                      maxlength="360"
              ><?php
                  if (isset($userInputData)) {
                      echo $userInputData["note"];
                  } else {
                      echo $person[PERSON_INTERNAL_NOTE];
                  } ?></textarea>
            </div>
        </div>
        <?php
    }
}

function showPassForm(array|null $errorData = null): void
{
    ?>
    <div class="mb-3 form-input">
        <label for="newPass" class="form-label ">New Password</label>
        <input
                id="newPass"
                type="password"
                class="form-control"
                name="newPassword"
                minlength="8"

        />
        <?php
        if (isset($errorData["errorPassword"])) {
            ?>
            <div class="alert alert-danger errorText" role="alert">
                <?= $errorData["errorPassword"] ?>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="mb-3 form-input">
        <label for="confirmPass" class="form-label">Confirm Password </label>
        <input
                id="confirmPass"
                type="password"
                class="form-control"
                name="confirmPassword"/>
        <?php
        if (isset($errorData["errorConfirm"])) {
            ?>
            <div class="alert alert-danger errorText" role="alert">
                <?= $errorData["errorConfirm"] ?>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

function showTextValue(array $person, array $arraySex, array $arrayRole, string $personJob, string $userRole, array|null $personData = null)
{
    ?>
    <div class="col-xxl-6 col-xl-6 col-lg-6 me-4">
        <div class="mb-3 form-input">

            <span class="required title">First Name</span>
            <p>
                <?php
                if (isset($personData[PERSON_FIRST_NAME])) {
                    echo $personData[PERSON_FIRST_NAME];
                } else {
                    echo $person[PERSON_FIRST_NAME];
                }
                ?>
            </p>
        </div>

        <?php
        // showing person last name if person have it
        if ($person[PERSON_LAST_NAME] != "") {
            ?>
            <div class="mb-3 form-input">

                <span class="title">Last Name</span>
                <p>
                    <?php
                    if (isset($personData[PERSON_LAST_NAME])) {
                        echo $personData[PERSON_LAST_NAME];
                    } else {
                        echo $person[PERSON_LAST_NAME];
                    }
                    ?>
                </p>
            </div>
            <?php
        }
        ?>
        <div class="mb-3 form-input">
            <span class="required title">NIK</span>
            <p>
                <?php
                if (isset($personData[PERSON_NIK])) {
                    echo $personData[PERSON_NIK];
                } else {
                    echo $person[PERSON_NIK];
                }
                ?>
            </p>

        </div>
        <div class="mb-3 form-input">
            <span class="required title">Email</span>
            <p>
                <?php
                if (isset($personData[PERSON_EMAIL])) {
                    echo $personData[PERSON_EMAIL];
                } else {
                    echo $person[PERSON_EMAIL];
                }
                ?>
            </p>

        </div>

        <div class="mb-3 form-input">
            <span class="required title">Birth Of Date</span>
            <p>
                <?php
                if (isset($personData[PERSON_BIRTH_DATE])) {
                    echo date("d F Y", $personData[PERSON_BIRTH_DATE]);
                } else {
                    echo date("d F Y", $person[PERSON_BIRTH_DATE]);
                }
                ?>
            </p>
        </div>
        <div class="mb-3 form-input">
            <span class="required title">Sex</span>
            <p>
                <?php
                foreach ($arraySex as $sex) {
                    if ($sex == $person[PERSON_SEX]) {
                        echo SEX_LABEL[$person[PERSON_SEX] . "_LABEL"];
                    }
                }
                ?>
            </p>
        </div>
    </div>
    <div class="col-xxl-5 col-xl-2 col-lg-5">
        <div class="mb-3 form-input">
            <span class="required title">Status</span>
            <p>
                <?php
                if (isset($personData[PERSON_STATUS])) {
                    echo translateIntToString($personData[PERSON_STATUS]);
                } else {
                    echo translateIntToString($person[PERSON_STATUS]);
                }
                ?>
            </p>
        </div>
        <div class="mb-3 form-input">
            <span class="required title">Job</span>
            <p>
                <?= $personJob ?>
            </p>
        </div>
        <!-- ROLE -->
        <div class="mb-3 form-input">
            <span class="required title">Role</span>
            <p>
                <?php
                foreach ($arrayRole as $role) {
                    if ($role == $person[PERSON_ROLE]) {
                        echo ROLE_LABEL[$person[PERSON_ROLE] . "_LABEL"];
                    }
                }
                ?>
            </p>
        </div>
        <?php
        if ($userRole == ROLE_ADMIN) {
            if (isset($personData[PERSON_INTERNAL_NOTE])) {
                ?>
                <div class="mb-3 form-input">

                    <span class="title">Internal Note</span>
                    <p style="line-height: 1.5rem"><?= $personData[PERSON_INTERNAL_NOTE]; ?>
                    </p>
                </div>
                <?php
            } else {
                if (isset($person[PERSON_INTERNAL_NOTE])) {
                    ?>
                    <div class="mb-3 form-input">

                        <span class="title">Internal Note</span>
                        <p style="line-height: 1.5rem"><?= $person[PERSON_INTERNAL_NOTE]; ?>
                        </p>
                    </div>
                    <?php
                }

            }
        }
        ?>
    </div>
    <?php
}