<?php
require_once __DIR__ . "/utils.php";


if (isset($_GET["reset"])) {
    redirect("../persons.php", "page=1");
}

/**
 * search person data by given category or keyword
 * @param array $persons
 * @param string $category
 * @param string|null $keyword
 * @return array
 * @throws Exception
 */
function search(array $persons, string $category, string|null $keyword = null): array
{
    $temp = [];

    $inputText = preg_quote($keyword);

    // it's an array person with their category
    $personCategory = getAgeCategory($persons, $category);

    // search by their first name, last name or their email
    if ($keyword != null) {
        for ($i = 0; $i < count($personCategory); $i++) {
            if (preg_match("/$inputText/i", $personCategory[$i][PERSON_EMAIL])) {
                if (!in_array($personCategory[$i], $temp)) {
                    $temp[] = $personCategory[$i];
                }
            }
            if (preg_match("/$inputText/i", $personCategory[$i][PERSON_FIRST_NAME])) {
                if (!in_array($personCategory[$i], $temp)) {
                    $temp[] = $personCategory[$i];
                }
            }
            if (preg_match("/$inputText/i", $personCategory[$i][PERSON_LAST_NAME])) {
                if (!in_array($personCategory[$i], $temp)) {
                    $temp[] = $personCategory[$i];
                }
            }
        }
        if (count($temp) != 0) {
            return $temp;
        }
    } else {
        // return array person category if keyword is null
        return getAgeCategory($persons, $category);
    }
    return [];
}

/**
 * sort category for category form
 * @param string $value
 * @return array
 */
function sortCategories(string $value): array
{
    $categories = [];

    if($value == CATEGORIES_ALL){
        $categories[] = CATEGORIES_ALL;
        $categories[] = CATEGORIES_PRODUCTIVE_AGE;
        $categories[] = CATEGORIES_CHILD;
        $categories[] = CATEGORIES_ELDERLY;
        $categories[] = CATEGORIES_PASSED_AWAY;
    } elseif ($value == CATEGORIES_PRODUCTIVE_AGE){
        $categories[] = CATEGORIES_PRODUCTIVE_AGE;
        $categories[] = CATEGORIES_CHILD;
        $categories[] = CATEGORIES_ELDERLY;
        $categories[] = CATEGORIES_PASSED_AWAY;
        $categories[] = CATEGORIES_ALL;
    } elseif ($value == CATEGORIES_CHILD){
        $categories[] = CATEGORIES_CHILD;
        $categories[] = CATEGORIES_ELDERLY;
        $categories[] = CATEGORIES_PASSED_AWAY;
        $categories[] = CATEGORIES_ALL;
        $categories[] = CATEGORIES_PRODUCTIVE_AGE;
    } elseif ($value == CATEGORIES_ELDERLY){
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

function searchPersonFromDb(string $category, string|null $keyword = null){
    global $PDO;
    $temp = [];
    // cek dulu semua data dari database yang sesuai dengan category yang diberikan

    $keyword = preg_quote($keyword);
    // jika keyword tidak null, cari persons yang sesuai dengan keyword dari database
    if($keyword != null){
        try {
            // dapatkan dulu semua data dari database
            $query = "SELECT firstName, lastName, email FROM `persons` WHERE firstName LIKE :keyword OR lastName LIKE :keyword OR email LIKE :keyword";
            $stmt = $PDO->prepare($query);
            $keyword = "%$keyword%";
            $stmt->execute(array(
                "firstName" => $keyword,
                "lastName" => $keyword,
                "email" => $keyword
            ));

            $persons = $stmt->fetchAll();
            foreach ($persons as &$person){
                $person[PERSON_BIRTH_DATE] = convertDateToTimestamp($person[PERSON_BIRTH_DATE]);
                $persons[] = $person;
            }

            if(count($persons) != 0){
                return getAgeCategory($persons, $category);
            }

        } catch (PDOException|Exception $e){
            die("Query error: " . $e->getMessage());
        }
    } else {
        try {
            $query = "SELECT * FROM `persons`";
            $stmt = $PDO->prepare($query);
            $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return getAgeCategory($persons, $category);
        } catch (Exception $e) {
            die("Query error: " . $e->getMessage());
        }
    }
}




