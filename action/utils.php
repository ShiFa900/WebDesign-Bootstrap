<?php

use JetBrains\PhpStorm\NoReturn;

require_once __DIR__ . "/../include/db.php";
require_once __DIR__ . "/const.php";
date_default_timezone_set("Asia/Singapore");


//==============================
//****** CHECK AUTHORISED ******
//==============================
/**
 * @param string $url go to login page if it unsucces
 * @param string $getParams error message on the header
 */
#[NoReturn] function redirect(string $url, string $getParams): void
{
    header('Location: ' . $url . '?' . $getParams);
    die();
}

/**
 * Redirect rules on index page or root directory:
 * - to Login page when user is not logged in
 * - to Dashboard page when user is logged in
 */
function redirectOnIndex(): void
{
    redirectIfUserAlreadyLogin();
    redirectIfNotAuthenticated();
}

/**
 * Redirects the user to the login page when not signed in
 */
function redirectIfNotAuthenticated(): void
{
    if (!isset($_SESSION["userEmail"])) {
        header("Location: login.php");
        exit(); // Terminate script execution after the redirect
    }
}

/**
 * Redirects the user to the dashboard page when already being signed in
 */
function redirectIfUserAlreadyLogin(): void
{
    if (isset($_SESSION["userEmail"])) {
        header("Location: dashboard.php");
        exit();
    }
}

/**
 * Checks the role of signed in user,
 * and then set 'userNotAuthenticate' label in session if the user's role is a MEMBER
 * @param string $userEmail
 * @param string $role
 */
function checkRole(string $userEmail, string $role): void
{
    $user = findFirstFromArray(tableName: 'persons', key: PERSON_EMAIL, value: $userEmail);
    $user = setPersonValueFromDb($user);
    if ($user[PERSON_ROLE] != $role) {
        $_SESSION["user"] = "Sorry, your role is MEMBER. Only ADMIN can create, edit and delete data.";
        redirect("persons.php", "");
    }
}

/**
 * check user status, cannot log in with account of Passed away status
 * @param array|null $person
 * @return array|bool
 */
function checkPersonStatus(array|null $person = null): bool|array
{
    global $PDO;
    if ($person !== null) {
        if ($person[PERSON_STATUS] == STATUS_PASSED_AWAY) return true;
    } else {
        try {
            $query = "SELECT * FROM persons WHERE status = :status";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                'status' => STATUS_PASSED_AWAY
            ));
            $category = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $category;
    }
}

//==============================
//****** GENERAL ******
//==============================

/**
 * @param int $limit
 * @param int|string $page
 * @param string|null $category
 * @param string|null $search
 * @return array
 * [
 *   'totalPage' => 3,
 *   'currentPage' => 1,
 *   'data' => array()
 * ]
 */
//function getPersons(int $limit, int|string $page, string|null $category = null, string|null $search = null): array
//{
//    global $PDO;
//    // query data to db:
//    // query data tanpa category(?)
//    try {
//        if ($category === null) {
//            $str = "%$search%";
//
//            $count = getCountPerson($str);
//            // return data" yanga sesuai dengan keyword pencarian saja
//            // 1. query untuk banyaknya data
//            // mendapatkan banyak data dari database
//            $queryCount = 'SELECT COUNT(*) as `total` FROM `persons` WHERE firstName LIKE :firstName OR lastName LIKE :lastName OR email LIKE :email';
//            $statement = $PDO->prepare($queryCount);
//            $statement->execute(
//                array(
//                    'firstName' => $str,
//                    'lastName' => $str,
//                    'email' => $str,
//                )
//            );
//            $count = $statement->fetch(PDO::FETCH_ASSOC);
//
//            // ganti teknik pengambilan data dengan hanya mengambil data dengan jumlah sesuai limitnya
//            $queryData = "SELECT * FROM persons WHERE firstName LIKE :firstName OR lastName LIKE :lastName OR email LIKE :email ORDER BY id DESC";
//            // 2. query untuk data
//            // get person data by given keyword
//            $statement = $PDO->prepare($queryData);
//            $statement->execute(
//                array(
//                    'firstName' => $str,
//                    'lastName' => $str,
//                    'email' => $str
//                )
//            );
//            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
//            // get person's category for person that related to given keyword
//
//            $sort = sortingDataForPagination(page: $page, limit: $limit, array: $data);
//
//            // return information for persons page
//            if ($count && $count['total'] > 0 && is_numeric($page)) {
//                return array(
//                    PAGING_TOTAL_PAGE => ceil(count($data) / $limit),
//                    PAGING_CURRENT_PAGE => $page,
//                    PAGING_DATA => array_slice($data, $sort['indexStart'], $sort['length'])
//                );
//            }
//        } else {
//
//        }
//    } catch (PDOException $e) {
//        die('Query error: ' . $e->getMessage());
//    } catch (Exception $e) {
//        die("Query error: " . $e->getMessage());
//    }
//
//    return array(
//        PAGING_TOTAL_PAGE => 1,
//        PAGING_CURRENT_PAGE => 1,
//        PAGING_DATA => []
//    );
//}

function getPersons(int $limit, int|string $page, string|null $category = null, string|null $search = null): array
{
    global $PDO;
    $str = "%$search%";
    $count = getCountPerson($str);
    // query data to db:
    // query data tanpa category(?)
    try {
        // ganti teknik pengambilan data dengan hanya mengambil data dengan jumlah sesuai limitnya
        $queryData = "SELECT *, UNIX_TIMESTAMP(birthDate) as ts FROM persons WHERE firstName LIKE :firstName OR lastName LIKE :lastName OR email LIKE :email ORDER BY id DESC";
        // 2. query untuk data
        // get person data by given keyword
        $statement = $PDO->prepare($queryData);
        $statement->execute(
            array(
                'firstName' => $str,
                'lastName' => $str,
                'email' => $str
            )
        );
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        $personCategory = getAgeCategory(category: $category, persons: $data);
        // get person's category for person that related to given keyword
        return returnShowData(datas: $personCategory, count: $count, page: $page, limit: $limit);

//            $sort = sortingDataForPagination(page: $page, limit: $limit, array: $data);
//
//            // return information for persons page
//            if ($count && $count['total'] > 0 && is_numeric($page)) {
//                return array(
//                    PAGING_TOTAL_PAGE => ceil(count($data) / $limit),
//                    PAGING_CURRENT_PAGE => $page,
//                    PAGING_DATA => array_slice($data, $sort['indexStart'], $sort['length'])
//                );
//            }
//        } else {
//            if($category === CATEGORIES_PRODUCTIVE_AGE) {
//                getProductiveCategory();
////                $queryData = "SELECT *, UNIX_TIMESTAMP(birthDate) as ts FROM persons WHERE firstName LIKE :firstName OR lastName LIKE :lastName OR email LIKE :email AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y') <= 45 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y') >= 15 ORDER BY id DESC";
////                // 2. query untuk data
////                // get person data by given keyword
////                $statement = $PDO->prepare($queryData);
////                $statement->execute(
////                    array(
////                        'firstName' => $str,
////                        'lastName' => $str,
////                        'email' => $str
////                    )
////                );
////                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
////                // get person's category for person that related to given keyword
////                return returnShowData(datas: $data, count: $count, page: $page, limit: $limit);
//            } elseif ($category === CATEGORIES_ELDERLY){
//                getElderlyCategory();
////                $queryData = "SELECT *, UNIX_TIMESTAMP(birthDate) as ts FROM persons WHERE firstName LIKE :firstName OR lastName LIKE :lastName OR email LIKE :email AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y') > 50 ORDER BY id DESC";
////                // 2. query untuk data
////                // get person data by given keyword
////                $statement = $PDO->prepare($queryData);
////                $statement->execute(
////                    array(
////                        'firstName' => $str,
////                        'lastName' => $str,
////                        'email' => $str
////                    )
////                );
////                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
////                return returnShowData(datas: $data, count: $count, page: $page, limit: $limit);
//            } elseif ($category === CATEGORIES_CHILD){
//                $data = getChildCategory();
////                $queryData = "SELECT *, UNIX_TIMESTAMP(birthDate) as ts FROM persons WHERE DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y') <= 14 AND firstName LIKE :firstName OR lastName LIKE :lastName OR email LIKE :email ORDER BY id DESC";
////                // 2. query untuk data
////                // get person data by given keyword
////                $statement = $PDO->prepare($queryData);
////                $statement->execute(
////                    array(
////                        'firstName' => $str,
////                        'lastName' => $str,
////                        'email' => $str
////                    )
////                );
////                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
//                return returnShowData(datas: $data, count: $count, page: $page, limit: $limit);
//            } elseif ($category === CATEGORIES_PASSED_AWAY){
//                $queryData = "SELECT *, UNIX_TIMESTAMP(birthDate) as ts FROM persons WHERE firstName LIKE :firstName OR lastName LIKE :lastName OR email LIKE :email AND status = :status ORDER BY id DESC";
//                // 2. query untuk data
//                // get person data by given keyword
//                $statement = $PDO->prepare($queryData);
//                $statement->execute(
//                    array(
//                        'firstName' => $str,
//                        'lastName' => $str,
//                        'email' => $str,
//                        'status' => STATUS_PASSED_AWAY
//                    )
//                );
//                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
//                return returnShowData(datas: $data, count: $count, page: $page, limit: $limit);
//            }

    } catch (PDOException $e) {
        die('Query error: ' . $e->getMessage());
    } catch (Exception $e) {
        die("Query error: " . $e->getMessage());
    }

//    return array(
//        PAGING_TOTAL_PAGE => 1,
//        PAGING_CURRENT_PAGE => 1,
//        PAGING_DATA => []
//    );
}

function returnShowData(array $datas, array $count, int $page, int $limit)
{

    $sort = sortingDataForPagination(page: $page, limit: $limit, array: $datas);

    // return information for persons page
    if ($count && $count['total'] > 0) {
        return array(
            PAGING_TOTAL_PAGE => ceil(count($datas) / $limit),
            PAGING_CURRENT_PAGE => $page,
            PAGING_DATA => array_slice($datas, $sort['indexStart'], $sort['length'])
        );
    }
}

function getCountPerson($str)
{
    global $PDO;
    // 1. query untuk banyaknya data
    // mendapatkan banyak data dari database
    $queryCount = 'SELECT COUNT(*) as `total` FROM `persons` WHERE firstName LIKE :firstName OR lastName LIKE :lastName OR email LIKE :email';
    $statement = $PDO->prepare($queryCount);
    $statement->execute(
        array(
            'firstName' => $str,
            'lastName' => $str,
            'email' => $str,
        )
    );
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getHobbies(int $limit, int $page, int $personId, string|null $keyword = null)
{
    global $PDO;
    $keyword = "%$keyword%";
    // mencari query untuk count
    try {
        $queryCount = "SELECT COUNT(*) as total FROM `hobbies` WHERE hobbies_name LIKE :hobbies_name AND person_id = :person_id";
        $stmt = $PDO->prepare($queryCount);
        $stmt->execute(array(
            "hobbies_name" => $keyword,
            "person_id" => $personId
        ));

        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        $offset = ($page - 1) * $limit;
        $queryData = "SELECT * FROM `hobbies` WHERE hobbies_name LIKE :hobbies_name AND person_id = :person_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $stmt = $PDO->prepare($queryData);
        $stmt->execute(array(
            "hobbies_name" => $keyword,
            "person_id" => $personId
        ));

        $hobbyData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($hobbyData as $hobby) {
            $arrayHobby = [
                ID => $hobby[ID],
                HOBBIES_NAME => $hobby[HOBBIES_NAME],
                HOBBIES_PERSON_ID => $hobby[HOBBIES_PERSON_ID],
                HOBBIES_LAST_UPDATE => convertDateToTimestamp($hobby[HOBBIES_LAST_UPDATE])
            ];
            $result[] = $arrayHobby;
        }

        // return information for persons page
        if ($count && $count["total"] > 0) {
            return array(
                PAGING_TOTAL_PAGE => ceil($count['total'] / $limit),
                PAGING_CURRENT_PAGE => $page,
                PAGING_DATA => $result
            );
        }
    } catch (PDOException $e) {
        die("Query error: " . $e->getMessage());
    }

    return array(
        PAGING_TOTAL_PAGE => 1,
        PAGING_CURRENT_PAGE => 1,
        PAGING_DATA => []
    );
}

function getJobs()
{
    global $PDO;
    $result = [];
    try {
        $query = "SELECT * FROM `jobs` ORDER BY jobs_name";
        $stmt = $PDO->prepare($query);
        $stmt->execute();
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($jobs as $j) {
            $queryJob = "SELECT COUNT(*) as total FROM `person_job` WHERE job_id = :job_id";
            $stmt = $PDO->prepare($queryJob);
            $stmt->execute(array(
                "job_id" => $j[ID]
            ));
            $count = $stmt->fetch(PDO::FETCH_ASSOC);

            $job = [
                ID => $j["id"],
                JOBS_NAME => $j["jobs_name"],
                JOBS_COUNT => $count["total"],
                JOBS_LAST_UPDATE => convertDateToTimestamp($j["last_update"])
            ];
            $result[] = $job;
        }
        return $result;
    } catch (PDOException $e) {
        die("Query error: " . $e->getMessage());
    }
}

function getJobsData(int $limit, int $page, string|null $keyword = null)
{
    global $PDO;
    $keyword = "%$keyword%";

    try {
        $queryCount = "SELECT COUNT(*) as total FROM `jobs` WHERE jobs_name LIKE :jobs_name";
        $stmt = $PDO->prepare($queryCount);
        $stmt->execute(array(
            "jobs_name" => $keyword
        ));
        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM `jobs` WHERE jobs_name LIKE :jobs_name ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $stmt = $PDO->prepare($query);
        $stmt->execute(array(
            "jobs_name" => $keyword
        ));
        $getJobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($getJobs as $job) {
            $jobResult = [
                ID => $job[ID],
                JOBS_NAME => $job[JOBS_NAME],
                JOBS_COUNT => $job[JOBS_COUNT],
                JOBS_LAST_UPDATE => convertDateToTimestamp($job[JOBS_LAST_UPDATE])
            ];
            $result[] = $jobResult;
        }

        if ($count["total"] > 0 && $count) {
            return [
                PAGING_TOTAL_PAGE => ceil($count['total'] / $limit),
                PAGING_CURRENT_PAGE => $page,
                PAGING_DATA => $result,
                PAGING_TOTAL_DATA => $count['total']
            ];
        }

    } catch (PDOException $e) {
        die("Query error: " . $e->getMessage());
    }

    return array(
        PAGING_TOTAL_PAGE => 1,
        PAGING_CURRENT_PAGE => 1,
        PAGING_DATA => []
    );
}

function sortingDataForPagination(int $page, int $limit, array $array): array
{
    // sorting array person that will be shown for pagination
    $indexStart = ($page - 1) * $limit;
    $length = $limit;
    if (($indexStart + $limit) > count($array)) {
        $length = count($array) - $indexStart;
    }
    return array(
        "length" => $length,
        "indexStart" => $indexStart
    );

}

/**
 * load json data into an array
 * @return int
 */
function getCountAllPerson(): int
{
    global $PDO;

    try {
        $query = "SELECT COUNT(*) as total FROM `persons`";
        $statement = $PDO->query($query);
        $statement->execute();
        // get only associative value from query
        return $statement->fetch(PDO::FETCH_ASSOC)['total'];
    } catch (PDOException $e) {
        $_SESSION["error"] = "Query error: " . $e->getMessage();
        var_dump($e->getMessage());
        die();
    }

}

/**
 * get Person hobbies from database
 * @param string $personId
 * @return array of hobbies
 */
function getPersonHobbiesFromDb(string $personId): array
{
    global $PDO;
    try {
        $query = "SELECT * FROM `hobbies` WHERE `person_id` = :person_id ORDER BY id DESC ";
        $stmt = $PDO->prepare($query);
        $stmt->execute(array(
            "person_id" => $personId
        ));
        $personHobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query error: " . $e->getMessage());
    }

    $result = [];
    for ($i = 0; $i < count($personHobbies); $i++) {
        $hobby = [
            ID => $personHobbies[$i][ID],
            HOBBIES_NAME => $personHobbies[$i][HOBBIES_NAME],
            HOBBIES_PERSON_ID => $personHobbies[$i][HOBBIES_PERSON_ID],
            HOBBIES_LAST_UPDATE => convertDateToTimestamp($personHobbies[$i][HOBBIES_LAST_UPDATE])
        ];
        $result[] = $hobby;
    }
    return $result;
}

/**
 * return hobby that valid by given id
 * @param string|null $hobbyId
 * @param string|null $personId
 * @return array
 */
function getHobby(string|null $hobbyId = null, string|null $personId = null): array
{
    global $PDO;

    try {
        if ($hobbyId != null) {
            $query = "SELECT * FROM `hobbies` WHERE id = :id";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                "id" => $hobbyId
            ));
            $hobby = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM `hobbies` WHERE person_id = :person_id";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                "person_id" => $personId
            ));
            $hobby = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
    } catch (PDOException $e) {
        die("Query error: " . $e->getMessage());
    }

    return $hobby;
}

function getPersonJob(string $personId)
{
    global $PDO;
    try {

        $query = "SELECT * FROM `person_job` WHERE person_id = :person_id";
        $stmt = $PDO->prepare($query);
        $stmt->execute(array(
            "person_id" => $personId
        ));
        $personJob = $stmt->fetch(PDO::FETCH_ASSOC);

        // pekerjaan tidak boleh kosong
        $queryJob = "SELECT * FROM `jobs` WHERE id = :job_id";
        $stmt = $PDO->prepare($queryJob);
        $stmt->execute(array(
            "job_id" => $personJob[PERSON_JOBS_JOB_ID]
        ));

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Query error: " . $e->getMessage());
    }
}

/**
 * Converts given sex value from database into the value that the app understands (SEX constants)
 * @param string $value
 * @return string
 */
function transformSexFromDb(string $value): string
{
    return match ($value) {
        'F' => SEX_FEMALE,
        'M' => SEX_MALE,
        default => SEX_BETTER_NOT_SAY,
    };
}

function transformSexFromInput(string $value): string
{
    return match ($value) {
        SEX_FEMALE => 'F',
        SEX_MALE => 'M',
        default => 'B',
    };
}

function transformRoleFromDb(string $value): string
{
    return match ($value) {
        'A' => ROLE_ADMIN,
        default => ROLE_MEMBER
    };
}

function transformRoleFromInput(string $value): string
{
    return match ($value) {
        ROLE_ADMIN => 'A',
        default => 'M'
    };
}

/**
 * saving person data when user do create or edit
 * @param array $array
 * @param string $location
 * @return void
 */
function savePerson(array $array, string $location): void
{
    global $PDO;

    if ($array[ID] == null) {
        try {
            $query = "INSERT INTO `persons`(firstName,lastName,nik,email, birthDate,sex,internalNote,role,password,status,lastLoggedIn
                    ) VALUES (:firstName, :lastName, :nik, :email, :birthDate, :sex, :internalNote, :role, :password, :status, :lastLoggedIn)";
            $statement = $PDO->prepare($query);
            $statement->execute(array(
                "firstName" => $array[PERSON_FIRST_NAME],
                "lastName" => $array[PERSON_LAST_NAME],
                "nik" => $array[PERSON_NIK],
                "email" => $array[PERSON_EMAIL],
                "birthDate" => $array[PERSON_BIRTH_DATE],
                "sex" => $array[PERSON_SEX],
                "internalNote" => $array[PERSON_INTERNAL_NOTE],
                "role" => $array[PERSON_ROLE],
                "password" => $array[PASSWORD],
                "status" => $array[PERSON_STATUS],
                "lastLoggedIn" => $array[PERSON_LAST_LOGGED_IN]));
            $queryId = "SELECT LAST_INSERT_ID() as id FROM `persons`";
            $stmt = $PDO->prepare($queryId);
            $stmt->execute();
            $personId = $stmt->fetch(PDO::FETCH_ASSOC);

            // lakukan pengecekan jika from hobby diisi, maka simpan datanya ke table hobby
            if (isset($array[HOBBIES_NAME]) && $array[HOBBIES_NAME] != null) {
                $hobby = [
                    ID => null,
                    HOBBIES_NAME => $array[HOBBIES_NAME],
                    HOBBIES_PERSON_ID => $personId["id"],
                    HOBBIES_LAST_UPDATE => date('Y-m-d H:i:s', time())
                ];
                saveHobby(array: $hobby);
            }

            if ($array[PERSON_STATUS] == STATUS_PASSED_AWAY) {
                savePersonJobWithPassedAwayStatus($personId["id"]);
            } elseif (isset($array[JOBS_NAME])) {
                // cari data job yang dipilih user
                $queryTheJob = "SELECT * FROM `jobs` WHERE jobs_name = :jobs_name";
                $stmt = $PDO->prepare($queryTheJob);
                $stmt->execute(array(
                    "jobs_name" => $array[JOBS_NAME]
                ));
                $theJob = $stmt->fetch(PDO::FETCH_ASSOC);

                $job = [
                    ID => $theJob[ID],
                    JOBS_NAME => $theJob[JOBS_NAME],
                    JOBS_COUNT => $theJob[JOBS_COUNT] + 1,
                    JOBS_LAST_UPDATE => time()
                ];
                saveJob($job);
                // save id person dan id job ke table person_job
                $personJob = [
                    ID => null,
                    PERSON_JOBS_PERSON_ID => $personId["id"],
                    PERSON_JOBS_JOB_ID => $theJob[ID]
                ];
                savePersonJob($personJob);
            }
            $_SESSION["info"] = "Successfully add person data of '" . $array[PERSON_FIRST_NAME] . "'!";
            redirect("../" . $location, "person=" . $array[PERSON_EMAIL]);

        } catch (PDOException $e) {
            die('Query error: ' . $e->getMessage());
        }
    } else {
        try {
            $personQuery = "UPDATE `persons` SET firstName= :firstName,lastName=:lastName,nik=:nik,email=:email,birthDate=:birthDate,sex=:sex,internalNote=:internalNote,role=:role,password=:password,status=:status,lastLoggedIn=:lastLoggedIn WHERE id =:id";
            $stmt = $PDO->prepare($personQuery);
            $stmt->execute(array(
                "id" => $array[ID],
                "firstName" => $array[PERSON_FIRST_NAME],
                "lastName" => $array[PERSON_LAST_NAME],
                "nik" => $array[PERSON_NIK],
                "email" => $array[PERSON_EMAIL],
                "birthDate" => $array[PERSON_BIRTH_DATE],
                "sex" => $array[PERSON_SEX],
                "internalNote" => $array[PERSON_INTERNAL_NOTE],
                "role" => $array[PERSON_ROLE],
                "password" => password_hash($array[PASSWORD], PASSWORD_DEFAULT),
                "status" => $array[PERSON_STATUS],
                "lastLoggedIn" => $array[PERSON_LAST_LOGGED_IN]));

            if ($array[PERSON_STATUS] == STATUS_PASSED_AWAY) {
                savePersonJobWithPassedAwayStatus($array[ID]);
            } elseif (isset($array[JOBS_NAME])) {
                saveJobForPerson(job: $array[JOBS_NAME], personId: $array[ID]);
            }
            if ($array[PERSON_EMAIL] == $_SESSION["userEmail"]) {
                $_SESSION["userEmail"] = $array[PERSON_EMAIL];
                $_SESSION["editMyProfile"] = "Successfully edit your data!";
                redirect("../" . $location, "");
            }
            $_SESSION["info"] = "Successfully edit person data of '" . $array[PERSON_FIRST_NAME] . "'!";
            redirect("../" . $location, "person=" . $array[ID]);
        } catch (PDOException $e) {
            die('Query error: ' . $e->getMessage());
        }
    }
}

/**
 * @param string $job
 * @param int $personId
 * @return void
 */
function saveJobForPerson(string $job, int $personId): void
{
    global $PDO;
    // ketika person melakukan edit data dengan data jobnya diganti
    $getCurrentJob = getPersonJob($personId);
    if ($getCurrentJob[JOBS_NAME] != $job) {
        // cari nama pekerjaan baru yang diinput user
        $newJob = "SELECT * FROM `jobs` WHERE jobs_name = :jobs_name";
        $stmt = $PDO->prepare($newJob);
        $stmt->execute(array(
            "jobs_name" => $job
        ));
        // saat user mengganti pekerjaannya
        $theJob = $stmt->fetch(PDO::FETCH_ASSOC);
        $job = [
            ID => $theJob[ID],
            JOBS_NAME => $theJob[JOBS_NAME],
            JOBS_COUNT => $theJob[JOBS_COUNT] + 1,
            JOBS_LAST_UPDATE => time()
        ];
        saveJob($job);
        // update data job yang lama dari table jobs
        $oldJob = "UPDATE `jobs` SET count = :count, last_update = :last_update WHERE id = :id";
        $stmt = $PDO->prepare($oldJob);
        $stmt->execute(array(
            "id" => $getCurrentJob[ID],
            "count" => $getCurrentJob[JOBS_COUNT] - 1,
            "last_update" => date("Y-m-d H:i:s", time())
        ));
        // proses update data dari table person_job
        $oldPersonJob = "SELECT * FROM `person_job` WHERE person_id = :person_id AND job_id = :job_id";
        $stmt = $PDO->prepare($oldPersonJob);
        $stmt->execute(array(
            "person_id" => $personId,
            "job_id" => $getCurrentJob[ID]
        ));
        $prevJob = $stmt->fetch(PDO::FETCH_ASSOC);
        $personJob = "UPDATE `person_job` SET job_id = :job_id, person_id = :person_id WHERE id = :id";
        $stmt = $PDO->prepare($personJob);
        $stmt->execute(array(
            // ini nnti di set nilainya
            "id" => $prevJob[ID],
            "person_id" => $personId,
            "job_id" => $job[ID]// diisi dengan id dari job yang baru

        ));
    }
}

function saveHobby(array $array, string|null $location = null): void
{
    global $PDO;
    if ($array[ID] == null) {
        try {
            $query = "INSERT INTO `hobbies` (hobbies_name, person_id,last_update) VALUES (:hobbies_name, :person_id, :last_update)";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                "hobbies_name" => ucfirst($array[HOBBIES_NAME]),
                "person_id" => $array[HOBBIES_PERSON_ID],
                "last_update" => date('Y-m-d H:i:s', $array[HOBBIES_LAST_UPDATE])
            ));

            $_SESSION["info"] = "Successfully save new hobby '" . $array[HOBBIES_NAME] . "'!";
            if ($location != null) {
                redirect("../" . $location, "person=" . $array[HOBBIES_PERSON_ID]);
            }
        } catch (PDOException $e) {
            die("Query error: " . $e->getMessage());
        }
    } else {
        try {
            $query = "UPDATE `hobbies` SET id = :id, hobbies_name= :hobbies_name, person_id= :person_id,last_update = :last_update WHERE id = :id";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                "id" => $array[ID],
                "hobbies_name" => ucfirst($array[HOBBIES_NAME]),
                "person_id" => $array[HOBBIES_PERSON_ID],
                "last_update" => date('Y-m-d H:i:s', $array[HOBBIES_LAST_UPDATE])
            ));

            if ($location != null) {
                $_SESSION["info"] = "Successfully edit hobby of '" . $array[HOBBIES_NAME] . "'!";
                redirect("../" . $location, "person=" . $array[HOBBIES_PERSON_ID]);
            }
        } catch (PDOException $e) {
            die("Query error: " . $e->getMessage());
        }
    }
}

function saveJob(array $array, string|null $location = null): void
{
    global $PDO;
    if ($array[ID] == null) {
        try {
            $query = "INSERT INTO `jobs` (jobs_name, count, last_update) VALUES (:jobs_name, :count, :last_update)";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                "jobs_name" => ucfirst($array[JOBS_NAME]),
                "count" => $array[JOBS_COUNT],
                "last_update" => date("Y-m-d H:i:s", $array[JOBS_LAST_UPDATE])
            ));

            if ($location != null) {
                $_SESSION["info"] = "Successfully add new job '" . $array[JOBS_NAME] . "'!";
                redirect("../" . $location, "");
            }
        } catch (PDOException $e) {
            die("Query error: " . $e->getMessage());
        }
    } else {
        try {
            $query = "UPDATE `jobs` SET id = :id, jobs_name = :jobs_name, count = :count, last_update = :last_update WHERE id = :id";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                "id" => $array[ID],
                "jobs_name" => ucfirst($array[JOBS_NAME]),
                "count" => $array[JOBS_COUNT],
                "last_update" => date("Y-m-d H:i:s", $array[JOBS_LAST_UPDATE])
            ));

            if ($location != null) {
                $_SESSION["info"] = "Successfully edit job of '" . $array[JOBS_NAME] . "'!";
                redirect("../" . $location, "");
            }
        } catch (PDOException) {
            die();
        }
    }
}

function savePersonJob(array $array): void
{
    global $PDO;

    if ($array[ID] == null) {
        try {
            // simpan data ke table person job, seharusnya tidak mengarah kemana-mana
            $query = "INSERT INTO `person_job` (person_id, job_id) VALUES (:person_id,:job_id)";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                "person_id" => $array[PERSON_JOBS_PERSON_ID],
                "job_id" => $array[PERSON_JOBS_JOB_ID]
            ));
        } catch (PDOException $e) {
            die("Query error: " . $e->getMessage());
        }
    } else {
        try {
            $query = "UPDATE `person_job` SET person_id = :person_id, job_id = :job_id WHERE id = :id";
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                "id" => $array[ID],
                "person_id" => $array[PERSON_JOBS_PERSON_ID],
                "job_id" => $array[PERSON_JOBS_JOB_ID]
            ));
        } catch (PDOException $e) {
            die("Query error: " . $e->getMessage());
        }
    }
}

function savePersonJobWithPassedAwayStatus(int $personId): void
{
    global $PDO;
    // cari data person dari table person job dengan menggunakan ID person
    $queryPersonJob = "SELECT * FROM `person_job` WHERE person_id = :person_id";
    $stmt = $PDO->prepare($queryPersonJob);
    $stmt->execute(array(
        "person_id" => $personId,
    ));
    $personJobData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$personJobData) {
        $queryJob = "SELECT * FROM `jobs` WHERE jobs_name = :jobs_name";
        $stmt = $PDO->prepare($queryJob);
        $stmt->execute(array(
            "jobs_name" => JOBS_DEFAULT_NAME
        ));
        $defaultJob = $stmt->fetch(PDO::FETCH_ASSOC);

        // tambah 1 count default job (tidak bekerja)
        $updateCurrentJob = "UPDATE `jobs` SET count = :count, last_update = :last_update WHERE id = :id";
        $stmt = $PDO->prepare($updateCurrentJob);
        $stmt->execute(array(
            "count" => $defaultJob[JOBS_COUNT] + 1,
            "id" => $defaultJob[ID],
            "last_update" => date("Y-m-d H:i:s", time())
        ));

        // save new person job pada table person_job
        $personJob = [
            ID => null,
            PERSON_JOBS_PERSON_ID => $personId,
            PERSON_JOBS_JOB_ID => $defaultJob[ID],
            JOBS_LAST_UPDATE => date("Y-m-d H:i:s", time())
        ];

    } else {
        // mode edit person
        // mencari current job
        $job = getPersonJob($personId);// berupa array jobs
        // kurangi count current job dengan 1
        $updateCurrentJob = "UPDATE `jobs` SET count = :count, last_update = :last_update WHERE id = :id";
        $stmt = $PDO->prepare($updateCurrentJob);
        $stmt->execute(array(
            "count" => $job[JOBS_COUNT] - 1,
            "id" => $job[ID],
            "last_update" => date("Y-m-d H:i:s", time())
        ));

        // set untuk default job (karena person ber-status passed away)
        $query = "SELECT * FROM `jobs` WHERE jobs_name = :jobs_name";
        $stmt = $PDO->prepare($query);
        $stmt->execute(array(
            "jobs_name" => JOBS_DEFAULT_NAME
        ));
        $theJob = $stmt->fetch(PDO::FETCH_ASSOC);
        $job = [
            ID => $theJob[ID],
            JOBS_NAME => $theJob[JOBS_NAME],
            JOBS_COUNT => $theJob[JOBS_COUNT] + 1,
            JOBS_LAST_UPDATE => date("Y-m-d H:i:s", time())
        ];
        saveJob(array: $job);
        $personJob = [
            ID => $personJobData[ID],
            PERSON_JOBS_PERSON_ID => $personId,
            PERSON_JOBS_JOB_ID => $theJob[ID]
        ];
    }
    savePersonJob($personJob);
}

/**
 * convert given date into timestamp
 * @param mixed $date given data from a form
 * @return int|null
 */
function convertDateToTimestamp(mixed $date): int|null
{
    if (!is_numeric($date)) {
        $date = str_replace('-', '/', $date);
        return strtotime($date);
    }
    return null;
}

/**
 * get first data from array by specific key and value
 * @param string $key
 * @param string $value
 * @param int|null $id
 * @return mixed
 */
function &findFirstFromArray(string $tableName, string $key, string $value, int|null $id = null): mixed
{
    global $PDO;
    try {
        if ($id === null) {
            $queryFormat = 'SELECT * FROM %s WHERE %s = %s LIMIT 1';
            $query = sprintf($queryFormat, $tableName, $key, ':value');
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                'value' => $value
            ));
            $firstData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $firstData;
        } else {
            $queryFormat = 'SELECT * FROM %s WHERE %s = %s AND id != :id lIMIT 1';
            $query = sprintf($queryFormat, $tableName, $key, ':value');
            $stmt = $PDO->prepare($query);
            $stmt->execute(array(
                'value' => $value,
                'id' => $id
            ));
            $firstData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $firstData;
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }

}


/**
 * translate person status, alive for true and passed away otherwise
 * @param int $status
 * @return string
 */
function translateIntToString(int $status): string
{
    return $status == 1 ? "Alive" : "Passed Away";
}

function setPersonValueFromDb(array $array): array
{
    $array[PERSON_BIRTH_DATE] = convertDateToTimestamp($array[PERSON_BIRTH_DATE]);
    $array[PERSON_SEX] = transformSexFromDb($array[PERSON_SEX]);
    $array[PERSON_ROLE] = transformRoleFromDb($array[PERSON_ROLE]);
    return $array;
}

function setNoun(array $array, string $text): string
{
    $noun = $text;
    if (count($array) > 1) {
        if (mb_substr($text, -1) == "y") {
            $noun = str_replace("y", "ies", $text);
        } else {
            $noun = $text . "s";
        }
    }
    return $noun;
}

/**
 * translate switch 'This person is alive', true if  the switch is on
 * @param string|null $on
 * @return bool
 */
function translateSwitch(string|null $on): bool
{
    return $on === "on";
}

/**
 * @param $birth_date_ts
 * @return int age of person by given birthdate
 * @throws Exception
 *
 */
function calculateAge($birth_date_ts): int
{
    $date = new DateTime('@' . $birth_date_ts);
    $now = new DateTime('now');
    $interval = $date->diff($now);
    return floor($interval->y);
}

/**
 * setting up person data before saved into json
 * @param array $person
 * @param string|null $firstName
 * @param string|null $lastName
 * @param string|null $nik
 * @param string|null $email
 * @param int|null $birthDate
 * @param string|null $sex
 * @param string|null $role
 * @param string|null $status
 * @param string|null $note
 * @return array
 */
function setPersonData(
    array       &$person,
    string|null $firstName = null,
    string|null $lastName = null,
    string|null $nik = null,
    string|null $email = null,
    int|null    $birthDate = null,
    string|null $sex = null,
    string|null $role = null,
    string|null $status = null,
    string|null $note = null
): array
{
    $arrayPerson[PERSON_FIRST_NAME] = $firstName == null ? $person[PERSON_FIRST_NAME] : $firstName;
    $arrayPerson[PERSON_LAST_NAME] = $lastName == null ? $person[PERSON_LAST_NAME] : $lastName;
    $arrayPerson[PERSON_NIK] = $nik == null ? $person[PERSON_NIK] : $nik;
    $arrayPerson[PERSON_EMAIL] = $email == null ? $person[PERSON_EMAIL] : $email;
    $arrayPerson[PERSON_BIRTH_DATE] = $birthDate == null ? $person[PERSON_BIRTH_DATE] : $birthDate;
    $arrayPerson[PERSON_SEX] = $sex == null ? $person[PERSON_SEX] : $sex;
    $arrayPerson[PERSON_ROLE] = $role == null ? $person[PERSON_ROLE] : $role;
    $arrayPerson[PERSON_STATUS] = (int)translateSwitch($status);
    $arrayPerson[PERSON_INTERNAL_NOTE] = $note;

    return $arrayPerson;
}

/**
 * temp save person data, if there are error that will be shown
 * @param string|null $firstName
 * @param string|null $lastName
 * @param string|null $email
 * @param string|null $nik
 * @param string|null $role
 * @param string|null $status
 * @param string|null $birthDate
 * @param string|null $sex
 * @param string|null $note
 * @return array
 */
function getUserInputData(
    string|null $firstName = null,
    string|null $lastName = null,
    string|null $email = null,
    string|null $nik = null,
    string|null $role = null,
    string|null $status = null,
    string|null $birthDate = null,
    string|null $sex = null,
    string|null $note = null,
    string|null $hobbyName = null,
    string|null $jobName = null
): array
{

    return [
        'firstName' => htmlspecialchars($firstName),
        'lastName' => htmlspecialchars($lastName),
        'nik' => htmlspecialchars($nik),
        'birthDate' => date("Y-m-d", $birthDate),
        'email' => filter_var($email, FILTER_VALIDATE_EMAIL),
        'role' => $role,
        'sex' => $sex,
        'status' => $status,
        'note' => htmlspecialchars($note),
        'hobbyName' => htmlspecialchars($hobbyName),
        'jobName' => $jobName
    ];
}

/**
 * validate input and save it into temp array
 * @param string $nik
 * @param string $email
 * @param string $birthDate
 * @param string|null $password
 * @param string|null $confirmPassword
 * @param string|null $currentPassword
 * @param int|null $id
 * @return array
 */
function validate(

    string      $nik,
    string      $email,
    string      $birthDate,
    string|null $password = null,
    string|null $confirmPassword = null,
    string|null $currentPassword = null,
    int|null    $id = null
): array
{

    $validate = [];
    if (isNikExist($nik, $id) == -1) {
        $validate["errorNik"] = "Sorry, this NIK is already exist";
    }

    if (isEmailExist($email, $id) == -1) {
        $validate["errorEmail"] = "Sorry, this EMAIL is already exist";
    }

    if (!is_null($password) && $confirmPassword != null) {
        if (getValidPassword($password) == -1) {
            $validate["errorPassword"] = " Sorry, your PASSWORD is weak. Password should include at least one" .
                " UPPERCASE, one LOWERCASE, and one NUMBER.";
        }

        if ($confirmPassword !== $password) {
            $validate["errorConfirm"] = "Sorry, your CONFIRMATION was wrong. Please check again.";
        }
    }

    if (getValidBirthDate($birthDate) == -1) {
        $validate["errorBirthDate"] = "Sorry, this BIRTH DATE is not valid. Please check again.";
    }

    //untuk di myProfile, user tidak bisa menganti password jika current password salah, namun tetap bisa diganti dengan bantuan admin
    if ($currentPassword != null) {

        if (getValidCurrentPassword($currentPassword, $id) == -1) {
            $validate["errorCurrentPassword"] = "Sorry, your PASSWORD was wrong. Please check again.";
        }
    }

    return $validate;
}

/**
 * checking if given NIK is already existed
 * @param string $nik
 * @param int|null $id
 * @return int
 */
function isNikExist(string $nik, int|null $id): int
{
    $result = findFirstFromArray(
        tableName: 'persons',
        key: PERSON_NIK,
        value: $nik,
        id: $id
    );

    if ($result) {
        return -1;
    }
    return 0;
}

/**
 * check given birthdate from a form
 * @param string $birthDate
 * @return int
 */
function getValidBirthDate(string $birthDate): int
{
    $intDate = convertDateToTimestamp($birthDate);
    if (time() < $intDate || $intDate == null) {
        return -1;
    }
    return 0;
}

/**
 * checking if given email is already existed
 * @param string $email
 * @param int|null $id
 * @return int
 */
function isEmailExist(string $email, int|null $id = null): int
{
    $result = findFirstFromArray(
        tableName: 'persons',
        key: PERSON_EMAIL,
        value: $email,
        id: $id
    );
    if ($result) {
        return -1;
    }
    return 0;
}

/**
 * given password must be strict
 * @param string|null $password
 * @return string|int
 */
function getValidPassword(string|null $password = null): string|int
{
    if ($password != null) {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($password) > 16) {
            return -1;
        }
    }
    return $password;
}

/**
 * checking if given current password is true, same as password that user use for login
 * @param string $password
 * @param int $id
 * @return int
 */
function getValidCurrentPassword(string $password, int $id): int
{
    global $PDO;
    try {
        $query = 'SELECT * FROM persons WHERE id = :id';
        $stmt = $PDO->prepare($query);
        $stmt->execute(array(
            'id' => $id
        ));
        $person = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!password_verify($password, $person[PASSWORD])) {
            return -1;
        }

    } catch (PDOException $e) {
        die($e->getMessage());
    }
    return 0;
}

/**
 * get persons data with age child category
 * @return array
 */
function getChildCategory(): array
{
    global $PDO;
    try {
        $query = "SELECT * FROM persons WHERE DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y') <= 14";
//        $query = sprintf($queryFormat, $conditions, $compareNum);
        $stmt = $PDO->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

/**
 * get persons data with age productive category
 * @return array
 */
function getProductiveCategory(): array
{
    global $PDO;
    $conditions = "DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y')";
    $compareNum = [45, 15];
    try {
        $query = "SELECT * FROM persons WHERE DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y') <= 45 AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y') >= 15";
//        $query = sprintf($queryFormat, $conditions, $compareNum[0], $compareNum[1]);
        $stmt = $PDO->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

/**
 * get persons data with age elderly age category
 * @return array
 */
function getElderlyCategory(): array
{
    global $PDO;
    try {
        $query = "SELECT * FROM persons WHERE DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), birthDate)), '%Y') > 50";
        $stmt = $PDO->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}


/**
 * classify all person by given category
 * @param array $persons
 * @param string $category
 * @return array
 * @throws Exception
 */
function getAgeCategory(string $category, array $persons): array
{
    // param array persons ini akan berisi 1 field lagi, yaitu age
    $personCategory = [];
    // return all person if category = CATEGORIES_ALL
    if ($category === CATEGORIES_ALL) {
        return $persons;
    }

    for ($i = 0; $i < count($persons); $i++) {
        if ($category == CATEGORIES_CHILD && calculateAge($persons[$i]['ts']) <= 14) {
            $personCategory[] = $persons[$i];
        } elseif ($category == CATEGORIES_ELDERLY && calculateAge($persons[$i]['ts']) > 50) {
            $personCategory[] = $persons[$i];
        } elseif ($category == CATEGORIES_PRODUCTIVE_AGE && calculateAge($persons[$i]['ts']) >= 15 && calculateAge($persons[$i]['ts']) <= 45) {
            $personCategory[] = $persons[$i];
        }

        // find all person with status passed away
        if ($category == CATEGORIES_PASSED_AWAY && $persons[$i][PERSON_STATUS] === STATUS_PASSED_AWAY) {
            $personCategory[] = $persons[$i];
        }
    }

    return $personCategory;
}

/**
 * sort person sex value for form select sex
 * @param string $value
 * @return array
 */
function sortSex(string $value): array
{
    $sex = [];

    // if person sex == female, the next order of sex select will be male and better not say
    if ($value == SEX_FEMALE) {
        $sex[] = SEX_FEMALE;
        $sex[] = SEX_MALE;
        $sex[] = SEX_BETTER_NOT_SAY;
    } elseif ($value == SEX_MALE) {
        $sex[] = SEX_MALE;
        $sex[] = SEX_FEMALE;
        $sex[] = SEX_BETTER_NOT_SAY;
    } elseif ($value == SEX_BETTER_NOT_SAY) {
        $sex[] = SEX_BETTER_NOT_SAY;
        $sex[] = SEX_MALE;
        $sex[] = SEX_FEMALE;
    }
    return $sex;
}

/**
 * sort person role for form select role
 * sort person by selected role
 * @param string $value
 * @return array
 */
function sortRole(string $value): array
{
    $role = [];

    if ($value == ROLE_ADMIN) {
        $role[] = ROLE_ADMIN;
        $role[] = ROLE_MEMBER;
    } else {
        $role[] = ROLE_MEMBER;
        $role[] = ROLE_ADMIN;
    }
    return $role;
}

/**
 * sort category for category form
 * @param string $value
 * @return array
 */
function sortCategories(string $value): array
{
    $categories = [];

    if ($value == CATEGORIES_ALL) {
        $categories[] = CATEGORIES_ALL;
        $categories[] = CATEGORIES_PRODUCTIVE_AGE;
        $categories[] = CATEGORIES_CHILD;
        $categories[] = CATEGORIES_ELDERLY;
        $categories[] = CATEGORIES_PASSED_AWAY;
    } elseif ($value == CATEGORIES_PRODUCTIVE_AGE) {
        $categories[] = CATEGORIES_PRODUCTIVE_AGE;
        $categories[] = CATEGORIES_CHILD;
        $categories[] = CATEGORIES_ELDERLY;
        $categories[] = CATEGORIES_PASSED_AWAY;
        $categories[] = CATEGORIES_ALL;
    } elseif ($value == CATEGORIES_CHILD) {
        $categories[] = CATEGORIES_CHILD;
        $categories[] = CATEGORIES_ELDERLY;
        $categories[] = CATEGORIES_PASSED_AWAY;
        $categories[] = CATEGORIES_ALL;
        $categories[] = CATEGORIES_PRODUCTIVE_AGE;
    } elseif ($value == CATEGORIES_ELDERLY) {
        $categories[] = CATEGORIES_ELDERLY;
        $categories[] = CATEGORIES_PASSED_AWAY;
        $categories[] = CATEGORIES_ALL;
        $categories[] = CATEGORIES_PRODUCTIVE_AGE;
        $categories[] = CATEGORIES_CHILD;
    } else {
        $categories[] = CATEGORIES_PASSED_AWAY;
        $categories[] = CATEGORIES_ALL;
        $categories[] = CATEGORIES_PRODUCTIVE_AGE;
        $categories[] = CATEGORIES_CHILD;
        $categories[] = CATEGORIES_ELDERLY;
    }
    return $categories;
}
