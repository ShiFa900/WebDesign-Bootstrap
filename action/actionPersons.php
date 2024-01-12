<?php
require_once __DIR__ . "/utils.php";
//membuat function untuk melakukan pencarian
//hasil pencarian dapat semua data yang memiliki kriteria dari pencarian atau difilter lagi

global $persons;
//if(isset($_SESSION["categoryActive"])){
//    $persons = getAll();
//    $ageCategory = [];
//    for($i = 0; $i < count($persons); $i++){
//        $getPersonAge = calculateAge($persons[$i][PERSON_BIRTH_DATE]);
//        $ageCategory[] = getAgeCategory($getPersonAge);
//    }
//
//    for ($i = 0; $i < count($ageCategory); $i++){
//        if($ageCategory[$i] == $_SESSION["categoryActive"]){
//            $persons = $ageCategory[$i];
//        }
//    }
//}


function search(string|null $keyword = null, string|null $category = null): array
{
    $persons = getAll();
    $temp = [];
    if($keyword != null) {
        $inputText = preg_quote($keyword);
        for ($i = 0; $i < count($persons); $i++) {
            if (preg_match("/$inputText/i", $persons[$i][PERSON_EMAIL])) {
                if (!in_array($persons[$i][ID], $temp)) {
                    $temp[] = $persons[$i];
                }
            }
            if (preg_match("/$inputText/i", $persons[$i][PERSON_FIRST_NAME])) {
                if (in_array($persons[$i][ID], $temp)) {
                    $temp[] = $persons[$i];
                }
            }
            if (preg_match("/$inputText/i", $persons[$i][PERSON_LAST_NAME])) {
                if (in_array($persons[$i][ID], $temp)) {
                    $temp[] = $persons[$i];
                }
            }
        }

//    how to check category for each person??
        if (count($temp) != 0) {
            if (!is_null($category)) {
                $filteredPerson = [];
                for ($i = 0; $i < count($temp); $i++) {
//            mengset category untuk tiap orang
                    $personCategory = getAgeCategory($temp[$i]);
                    if ($personCategory == $category) {
                        $filteredPerson[] = $temp[$i];
                    }
                }
                return $filteredPerson;
            }
            return $temp;
        }
    } else {
        if($category == CATEGORIES_ALL){
            return $persons;
        }
        $filteredPerson = [];
        for ($i = 0; $i < count($persons); $i++){
            $personCategory = getAgeCategory($persons[$i]);
            if($personCategory == $category){
                $filteredPerson[] = $persons[$i];
            }
        }
        return $filteredPerson;
    }
    return [];
}
//function search(string|null $keyword = null, string|null $category = null): array
//{
//    $persons = getAll();
//    $temp = [];
//    if ($keyword != null) {
//        if (!is_null($category)) {
//            $filteredPerson = [];
//            $personCategory = [];
//
//            for ($i = 0; $i < count($persons); $i++){
//                $personCategory[] = getAgeCategory($persons[$i]);
//            }
////            mengset category untuk tiap orang
//            $inputText = preg_quote($keyword);
//            for ($i = 0; $i < count($personCategory); $i++) {
//
//                if (preg_match("/$inputText/i", $persons[$i][1][PERSON_EMAIL])) {
//                    if (!in_array($persons[$i], $temp)) {
//                        $temp[] = $persons[$i];
//                    }
//                }
//                if (preg_match("/$inputText/i", $persons[$i][1][PERSON_FIRST_NAME])) {
//                    if (in_array($persons[$i], $temp)) {
//                        $temp[] = $persons[$i];
//                    }
//                }
//                if (preg_match("/$inputText/i", $persons[$i][1][PERSON_LAST_NAME])) {
//                    if (in_array($persons[$i], $temp)) {
//                        $temp[] = $persons[$i];
//                    }
//                }
//            }
//        }
//
//
////        search person
////    how to check category for each person??
//        if (count($temp) != 0) {
//            if (!is_null($category)) {
//                $filteredPerson = [];
//                for ($i = 0; $i < count($temp); $i++) {
////            mengset category untuk tiap orang
//                    if ($temp[$i][0] == $category) {
//                        $filteredPerson[] = $temp[$i];
//                    }
//                }
//                return $filteredPerson;
//            }
//            return $temp;
//        }
//    } else {
//        if ($category == CATEGORIES_ALL) {
//            return $persons;
//        }
////        $filteredPerson = [];
////        for ($i = 0; $i < count($persons); $i++){
////            $personCategory = getAgeCategory($persons[$i]);
////            if($personCategory == $category){
////                $filteredPerson[] = $persons[$i];
////            }
////        }
////        return $filteredPerson;
//    }
//    return [];
//}


