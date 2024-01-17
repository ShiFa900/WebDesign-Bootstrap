<?php
require_once __DIR__ . "/utils.php";
//membuat function untuk melakukan pencarian
//hasil pencarian dapat semua data yang memiliki kriteria dari pencarian atau difilter lagi

global $persons;
if (isset($_GET["reset"])) {
    redirect("../persons.php", "");
}
function search(array $persons, string $category, string|null $keyword = null): array
{
//    mencari kategori dari person
    $temp = [];

    $inputText = preg_quote($keyword);

    $personCategory = getAgeCategory($persons, $category);

//    pencarian harusnya bisa dengan person email, person last name, person first name  (?)
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
        return getAgeCategory($persons, $category);
    }
    $_SESSION["noDataFound"] = "Sorry, we couldn't find what you looking for.";
    return [];
}

function getAgeCategory(array &$persons, string $category): array
{
//    mendapatkan orang yang statusnya meninggal
//mendapatkan umur dari tiap orang

    $personCategory = [];

    if ($category == CATEGORIES_ALL) {
        return $persons;
    }

    if($category == CATEGORIES_CHILD){
        $personCategory = getChildCategory($persons);
    } elseif ($category == CATEGORIES_ELDERLY){
        $personCategory = getElderlyCategory($persons);
    } elseif ($category == CATEGORIES_PRODUCTIVE_AGE){
        $personCategory = getProductiveCatagory($persons);
    }

    if($category == CATEGORIES_PASSED_AWAY) {
        for ($i = 0; $i < count($persons); $i++) {
            if ($persons[$i][PERSON_STATUS] == STATUS_PASSED_AWAY) {
                $personCategory[] = $persons[$i];
            }
        }
    }

    return $personCategory;
}

function getChildCategory(array $persons): array
{
    $childCategory = [];
    for($i = 0; $i < count($persons); $i++){
        $getAge = calculateAge($persons[$i][PERSON_BIRTH_DATE]);
        if($getAge <= 14){
            $childCategory[] = $persons[$i];
        }
    }
    return $childCategory;
}

function getProductiveCatagory(array $persons): array
{
    $productiveCategory = [];
    for($i = 0; $i < count($persons); $i++){
        $getAge = calculateAge($persons[$i][PERSON_BIRTH_DATE]);
        if($getAge <= 45){
            $productiveCategory[] = $persons[$i];
        }
    }
    return $productiveCategory;
}

function getElderlyCategory(array $persons): array
{
    $elderlyCategory = [];
    for($i = 0; $i < count($persons); $i++){
        $getAge = calculateAge($persons[$i][PERSON_BIRTH_DATE]);
        if($getAge > 50){
            $elderlyCategory[] = $persons[$i];
        }
    }
    return $elderlyCategory;
}


