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


function search(string $keyword, string|null $category = null): array
{
    $inputText = preg_quote($keyword);
    $persons = getAll();
    $temp = [];

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
    if (count($temp) != 0 && !is_null($category)) {
        $filteredPerson = [];
        for ($i = 0; $i < count($temp); $i++){
//            mendapatkan umur dari tiap orang
            $getPersonAge = calculateAge($temp[$i][PERSON_BIRTH_DATE]);
//            mengset category untuk tiap orang
            $personCategory = getAgeCategory($getPersonAge);
            if($personCategory == $category){
                $filteredPerson[] = $temp[$i];
            }
        }
        return $filteredPerson;
    }

    return $temp;
}


