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


//function search(): array
//{
    if (isset($_GET["category"])) {
        $category = $_GET["category"];
        $keyWord = $_GET["keyWord"];

        $inputText = preg_quote($keyWord);
        $persons = getAll();
        $temp = [];

        while (true) {
            if ($inputText == "") break;
            for ($i = 0; $i < count($persons); $i++) {
                if (preg_match("/$inputText/i", $persons[$i][PERSON_EMAIL])) {
                    if (!in_array($persons[$i][ID], $temp)) {
                        $temp[] = $persons[$i];
                    }
                }
                if (preg_match("/$inputText/i", $persons[$i][PERSON_FIRST_NAME])) {
                    if (!in_array($persons[$i][ID], $temp)) {
                        $temp[] = $persons[$i];
                    }
                }
                if(preg_match("/$inputText/i", $persons[$i][PERSON_LAST_NAME])){
                    if(!in_array($persons[$i][ID], $temp)){
                        $temp[] = $persons[$i];
                    }
                }
            }

            if (count($temp) != 0) {
               for ($i = 0; $i < count($temp); $i++){
                   $personAge = calculateAge($temp[$i][PERSON_BIRTH_DATE]);
                   $ageCategory = getAgeCategory($personAge);
                   if($ageCategory == $category){
                       $persons[] = $temp[$i];
                   }
               }
            }
        }
    }

//}
