<?php

require_once __DIR__ . "/../include/db.php";
require_once __DIR__ . "/const.php";

//==============================
//****** CHECK AUTHORISED ******
//==============================
/**
 * @param url go to login page if it unsucces
 * @param string error message on the header
 */
function redirect($url, $getParams): void
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
 * Checks the role of signed-in user,
 * and then set 'userNotAuthenticate' label in session if the user's role is a MEMBER
 * @param string $userEmail
 * @return bool
 */
function checkRole(string $userEmail, string $role): bool
{
    $persons = getAll();
    $user = getPerson(persons: $persons, email: $userEmail);
    if ($user[PERSON_ROLE] != $role) {
        $_SESSION["user"] = "Sorry, your role is MEMBER. Only ADMIN can create, edit and delete person data.";
        redirect("persons.php", "");
    }
    return true;
}

//==============================
//****** GENERAL ******
//==============================

/**
 * @param int $limit
 * @param int $offset
 * @param string|null $search
 * @param string|null $category
 * @return array
 * [
 *   'totalPage' => 3,
 *   'currentPage' => 1,
 *   'data' => array()
 * ]
 *
 */
function getPersons(int $limit, int $page = 1, string|null $category = null, string|null $search = null): array
{
    global $PDO;
    // query data to db:
    // 'SELECT * FROM persons WHERE name like "%:search%" ORDER BY id DESC LIMIT :limit OFFSET :page'
    try {
        // 1. query untuk banyaknya data
        $queryCount = 'SELECT COUNT(*) as `total` FROM `persons` WHERE firstName like :firstName or lastName like :lastName or email like :email';
        $statement = $PDO->prepare($queryCount);
        $statement->execute(
            array(
                'firstName' => "%$search%",
                'lastName' => "%$search%",
                'email' => "%$search%",
            )
        );
        $count = $statement->fetch();
        //         ['total'] => 19

        //        todo:
        //        $page bisa berubah sesuai kondisi validasi

        $queryData = 'SELECT * FROM persons WHERE firstName like :firstName OR lastName like :lastName OR email like :email ORDER BY id DESC';
        // 2. query untuk data
        $statement = $PDO->prepare($queryData);
        $statement->execute(
            array(
                'firstName' => "%$search%",
                'lastName' => "%$search%",
                'email' => "%$search%",
                //'limit' => $limit,
                //'offset' => ($page - 1) * $limit,
            )
        );
        //$statement->debugDumpParams();
        $data = $statement->fetchAll();


        if ($count && $count['total'] > 0) {
            return array(
                'totalPage' => ceil($count['total'] / $limit),
                'currentPage' => $page,
                'data' => $data
            );
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Query error: ' . $e->getMessage();
        var_dump($e->getMessage());
        print_r($e->getTrace());
        die();
    }

    return array(
        'totalPage' => 1,
        'currentPage' => 1,
        'data' => []
    );
}

/**
 * load json data into an array
 * @return array
 */
function getAll(): array
{
    global $PDO;
    // we need to convert it into array of Person

    try {
        $query = "SELECT * FROM `persons`";
        $statement = $PDO->query($query);
        // get only associative value from query
        $persons = $statement->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Query error: " . $e->getMessage();
        var_dump($e->getMessage());
        die();
    }

    $result = [];
    for ($i = 0; $i < count($persons); $i++) {

        $person = [
            ID => $persons[$i][ID],
            PERSON_FIRST_NAME => $persons[$i][PERSON_FIRST_NAME],
            PERSON_LAST_NAME => $persons[$i][PERSON_LAST_NAME],
            PERSON_NIK => $persons[$i][PERSON_NIK],
            PERSON_EMAIL => $persons[$i][PERSON_EMAIL],
            PERSON_BIRTH_DATE => convertDateToTimestamp($persons[$i][PERSON_BIRTH_DATE]),
            // semestinya pakai adapter function: transformSexFromDb(...)
            PERSON_SEX => transformSexFromDb($persons[$i][PERSON_SEX]),
            PERSON_INTERNAL_NOTE => $persons[$i][PERSON_INTERNAL_NOTE],
            PERSON_ROLE => transformRoleFromDb($persons[$i][PERSON_ROLE]),
            PASSWORD => $persons[$i][PASSWORD],
            PERSON_STATUS => translateIntToString($persons[$i][PERSON_STATUS]),
            PERSON_LAST_LOGGED_IN => convertDateToTimestamp($persons[$i][PERSON_LAST_LOGGED_IN])
        ];

        $result[] = $person;
    }
    return $result;
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
 * @param array $person
 * @param string $location
 * @return void
 */
function savePerson(array $person, string $location): void
{
    global $PDO;

    if ($person[ID] == null) {
        try {
            $query = "INSERT INTO `persons`(firstName,lastName,nik,email, birthDate,sex,internalNote,role,password,status,lastLoggedIn
                    ) VALUES (:firstName, :lastName, :nik, :email, :birthDate, :sex, :internalNote, :role, :password, :status, :lastLoggedIn)";
            $statement = $PDO->prepare($query);
            $statement->execute(array(
                "firstName" => $person[PERSON_FIRST_NAME],
                "lastName" => $person[PERSON_LAST_NAME],
                "nik" => $person[PERSON_NIK],
                "email" => $person[PERSON_EMAIL],
                "birthDate" => $person[PERSON_BIRTH_DATE],
                "sex" => $person[PERSON_SEX],
                "internalNote" => $person[PERSON_INTERNAL_NOTE],
                "role" => $person[PERSON_ROLE],
                "password" => $person[PASSWORD],
                "status" => $person[PERSON_STATUS],
                "lastLoggedIn" => $person[PERSON_LAST_LOGGED_IN]));
            //set global PDO and statement null, to close the connection
            $PDO = null;
            $statement = null;

            $_SESSION["info"] = "Successfully add person data of " . $person[PERSON_FIRST_NAME];
            redirect("../" . $location, "person=" . $person[PERSON_EMAIL]);

        } catch (PDOException $e) {
            die('Query error: ' . $e->getMessage());
        }
    } else {
        $birthDate = date('Y-m-d H:i:s', $person[PERSON_BIRTH_DATE]);

        try {
            $personQuery = "UPDATE `persons` SET firstName= :firstName,lastName=:lastName,nik=:nik,email=:email,birthDate=:birthDate,sex=:sex,internalNote=:internalNote,role=:role,password=:password,status=:status,lastLoggedIn=:lastLoggedIn WHERE id =:id";
            $stmt = $PDO->prepare($personQuery);
            $stmt->execute(array(
                "id" => $person[ID],
                "firstName" => $person[PERSON_FIRST_NAME],
                "lastName" => $person[PERSON_LAST_NAME],
                "nik" => $person[PERSON_NIK],
                "email" => $person[PERSON_EMAIL],
                "birthDate" => $birthDate,
                "sex" => $person[PERSON_SEX],
                "internalNote" => $person[PERSON_INTERNAL_NOTE],
                "role" => $person[PERSON_ROLE],
                "password" => $person[PASSWORD],
                "status" => $person[PERSON_STATUS],
                "lastLoggedIn" => $person[PERSON_LAST_LOGGED_IN]));

            if ($person[PERSON_EMAIL] == $_SESSION["userEmail"]) {
                $_SESSION["userEmail"] = $person[PERSON_EMAIL];
                $_SESSION["editMyProfile"] = "Successfully edit your data";
            }
            $PDO = null;
            $stmt = null;

            $_SESSION["info"] = "Successfully edit person data of " . $person[PERSON_FIRST_NAME];
            redirect("../" . $location, "person=" . $person[PERSON_EMAIL]);
        } catch (PDOException $e) {
            die('Query error: ' . $e->getMessage());
        }
    }
}

//    $persons = getAll();
////    CREATE MODE
//    if ($person[ID] == null) {
//        $id = generateId($persons);
//        // generate ID for new person
//        $person[ID] = $id;
//        $persons[] = $person;
//        saveDataIntoJson($persons, "persons.json");
//        $_SESSION["addSuccess"] = $persons;
//        redirect("../" . $location, "person=" . $id);
//
//    } else {
////        EDIT MODE
//        for ($i = 0; $i < count($persons); $i++) {
//            if ($person[ID] == $persons[$i][ID]) {
//
//                $persons[$i] = [
//                    ID => $person[ID],
//                    PERSON_FIRST_NAME => ucwords($person[PERSON_FIRST_NAME]),
//                    PERSON_LAST_NAME => ucwords($person[PERSON_LAST_NAME]),
//                    PERSON_NIK => $person[PERSON_NIK],
//                    PERSON_EMAIL => $person[PERSON_EMAIL],
//                    PERSON_BIRTH_DATE => convertDateToTimestamp($person[PERSON_BIRTH_DATE]),
//                    PERSON_SEX => $person[PERSON_SEX],
//                    PERSON_INTERNAL_NOTE => $person[PERSON_INTERNAL_NOTE],
//                    PERSON_ROLE => $person[PERSON_ROLE],
//                    PASSWORD => password_hash($person[PASSWORD], PASSWORD_DEFAULT),
//                    PERSON_STATUS => $person[PERSON_STATUS],
//                    PERSON_LAST_LOGGED_IN => $persons[$i][PERSON_LAST_LOGGED_IN]
//                ];
//                saveDataIntoJson($persons, "persons.json");
//                $_SESSION["editSuccess"] = $persons;
//                if ($person[PERSON_EMAIL] == $_SESSION["userEmail"]) {
//                    $_SESSION["userEmail"] = $person[PERSON_EMAIL];
//
//                }
//                $_SESSION["personHasEdit"] = $persons[$i];
//                redirect("../" . $location, "person=" . $persons[$i][ID]);
//
//            }
//        }
//    }


/**
 * generate ID person, key ID is auto increment
 * @param array|null $persons
 * @return int
 */
function generateId(array|null $persons = null): int
{
    return is_array($persons) == null ? 1 : (end($persons)[ID]) + 1;
}

/**
 * convert given date into timestamp
 * @param string $date given data from a form
 * @return int
 */
function convertDateToTimestamp(string|null $date = null): int|null
{
    if ($date != null) {
        $date = str_replace('-', '/', $date);
        return strtotime($date);
    }
    return null;
}


/**
 * get person data by given ID or EMAIl if isn't null
 * @param string $email
 * @return array
 */
function getPerson(array $persons, string $email): array
{
    global $PDO;

    try {
        $query = "SELECT * FROM `persons` WHERE email = :email LIMIT 1";
        $statement = $PDO->prepare($query);
        $statement->execute(array(
            "email" => $email
        ));
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Query error: ' . $e->getMessage();
        var_dump($e->getMessage());
        die();
    }

    $person = $statement->fetch(PDO::FETCH_ASSOC);
    foreach ($persons as $p) {
        if ($person[PERSON_EMAIL] == $p[PERSON_EMAIL]) {
            return $p;
        }
    }

    return [];
}

/**
 * get first data from array by specific key and value
 * @param array $array
 * @param string $key
 * @param string $value
 * @param int|null $id
 * @return mixed
 */
function &findFirstFromArray(array &$array, string $key, string $value, int|null $id = null): mixed
{
    $default = [];
    for ($i = 0; $i < count($array); $i++) {
        if ($id == null) {
            if ($array[$i][$key] == $value) {
                return $array[$i];
            }
        } else {
            // do especially when ID is not null (edit)
            if ($array[$i][$key] == $value && $array[$i][ID] != $id) {
                return $array[$i];
            }
        }
    }
    return $default;
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
 * @param string|null $birthDate
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
    $person[PERSON_FIRST_NAME] = $firstName == null ? $person[PERSON_FIRST_NAME] : $firstName;
    $person[PERSON_LAST_NAME] = $lastName == null ? $person[PERSON_LAST_NAME] : $lastName;
    $person[PERSON_NIK] = $nik == null ? $person[PERSON_NIK] : $nik;
    $person[PERSON_EMAIL] = $email == null ? $person[PERSON_EMAIL] : $email;
    $person[PERSON_BIRTH_DATE] = $birthDate == null ? $person[PERSON_BIRTH_DATE] : $birthDate;
    $person[PERSON_SEX] = $sex == null ? $person[PERSON_SEX] : $sex;
    $person[PERSON_ROLE] = $role == null ? $person[PERSON_ROLE] : $role;
    $person[PERSON_STATUS] = (int)translateSwitch($status);
    $person[PERSON_INTERNAL_NOTE] = $note;
    return $person;
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
    string|null $note = null
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
        'note' => htmlspecialchars($note)
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

    $persons = getAll();
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

    //        untuk di myProfile, user tidak bisa menganti password jika current password salah, namun tetap bisa diganti dengan bantuan admin
    if ($currentPassword != null) {

        if (getValidCurrentPassword($currentPassword, $persons) == -1) {
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
function isNikExist(string $nik, int|null $id = null): int
{
    $persons = getAll();
    $result = findFirstFromArray(
        array: $persons,
        key: PERSON_NIK,
        value: $nik,
        id: $id
    );
    if (count($result) == 0) {
        return 0;
    }
    return -1;
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
    $persons = getAll();
    $result = findFirstFromArray(
        array: $persons,
        key: PERSON_EMAIL,
        value: $email,
        id: $id
    );
    if (count($result) == 0) {
        return 0;
    }
    return -1;
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
 * @param array $persons
 * @return int
 */
function getValidCurrentPassword(string $password, array $persons): int
{
    foreach ($persons as $person) {
        $password = password_verify($password, $person[PASSWORD]);
        if (!$password) {
            return -1;
        }
    }
    return 0;
}

/**
 * get persons data with age child category
 * @param array $persons
 * @return array
 * @throws Exception
 */
function getChildCategory(array $persons): array
{
    $childCategory = [];
    for ($i = 0; $i < count($persons); $i++) {
        $getAge = calculateAge($persons[$i][PERSON_BIRTH_DATE]);
        if ($getAge <= 14) {
            $childCategory[] = $persons[$i];
        }
    }
    return $childCategory;
}

/**
 * get persons data with age productive category
 * @param array $persons
 * @return array
 * @throws Exception
 */
function getProductiveCategory(array $persons): array
{
    $productiveCategory = [];
    for ($i = 0; $i < count($persons); $i++) {
        $getAge = calculateAge($persons[$i][PERSON_BIRTH_DATE]);
        if ($getAge <= 45 && $getAge >= 15) {
            $productiveCategory[] = $persons[$i];
        }
    }
    return $productiveCategory;
}

/**
 * get persons data with age elderly age category
 * @param array $persons
 * @return array
 * @throws Exception
 */
function getElderlyCategory(array $persons): array
{
    $elderlyCategory = [];
    for ($i = 0; $i < count($persons); $i++) {
        $getAge = calculateAge($persons[$i][PERSON_BIRTH_DATE]);
        if ($getAge > 50) {
            $elderlyCategory[] = $persons[$i];
        }
    }
    return $elderlyCategory;
}

/**
 * classify all person by given category
 * @param array $persons
 * @param string $category
 * @return array
 * @throws Exception
 */
function getAgeCategory(array &$persons, string $category): array
{
    $personCategory = [];

    // return all person if category = CATEGORIES_ALL
    if ($category == CATEGORIES_ALL) {
        return $persons;
    }

    if ($category == CATEGORIES_CHILD) {
        $personCategory = getChildCategory($persons);
    } elseif ($category == CATEGORIES_ELDERLY) {
        $personCategory = getElderlyCategory($persons);
    } elseif ($category == CATEGORIES_PRODUCTIVE_AGE) {
        $personCategory = getProductiveCategory($persons);
    }

    // find all person with status passed away
    if ($category == CATEGORIES_PASSED_AWAY) {
        for ($i = 0; $i < count($persons); $i++) {
            if ($persons[$i][PERSON_STATUS] == STATUS_PASSED_AWAY) {
                $personCategory[] = $persons[$i];
            }
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
