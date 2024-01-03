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
    $inputText = $_POST['search-form'];
    $persons = getAll();
    while (true) {
        if ($inputText == "") break;
        $inputText = preg_quote($inputText);
        $temp = [];
        for ($i = 0; $i < count($persons); $i++) {
            if (preg_match("/$inputText/i", $persons[$i]["email"])) {
                if (!in_array($persons[$i]["email"], $temp)) {
                    $temp[] = $persons[$i];
                }
            }
            if (preg_match("/$inputText/i", $persons[$i]["firstName"] . $persons[$i]['lastName'])) {
                if (!in_array($persons[$i]["email"], $temp)) {
                    $temp[] = $persons[$i];
                }
            }
        }
        if (count($temp) != 0) {
            return $temp;
        }
        break;
    }

}
