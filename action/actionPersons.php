<?php
require_once __DIR__ . "/utils.php";
//membuat function untuk melakukan pencarian
//hasil pencarian dapat semua data yang memiliki kriteria dari pencarian atau difilter lagi

//if (isset($_POST['search-form'])) {
//    $inputText = $_POST['search'];
//
//    search($inputText);
//}


function search()
{
    if (isset($_POST["search"])) {
        $category = $_POST["category"];
        $keyWord = $_POST["keyWord"];
    }
    $inputText = preg_quote($_POST['search']);
    $persons = getAll();
    $temp = [];

    while (true) {
        if ($inputText == "") break;
        for ($i = 0; $i < count($persons); $i++) {
            if (preg_match("/$inputText/i", $persons[$i][PERSON_EMAIL])) {
                if (!in_array($persons[$i][PERSON_EMAIL], $temp)) {
                    $temp[] = $persons[$i];
                }
            }
            if (preg_match("/$inputText/i", $persons[$i][PERSON_FIRST_NAME]) || preg_match("/$inputText/i", $persons[$i][PERSON_LAST_NAME])) {
                if (!in_array($persons[$i][PERSON_FIRST_NAME], $temp) || !in_array($persons[$i][PERSON_LAST_NAME], $temp)) {
                    $temp[] = $persons[$i];
                }
            }
        }
        if (count($temp) != 0) {
            return $temp;
        }
    }


}
