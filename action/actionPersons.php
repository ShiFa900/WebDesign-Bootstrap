<?php
require_once __DIR__ . "/utils.php";
//membuat function untuk melakukan pencarian
//hasil pencarian dapat semua data yang memiliki kriteria dari pencarian atau difilter lagi

global $persons;
//if(isset($_GET["reset"])){
//    redirect("../persons.php", "");
//}
function search(array $persons, string $category, string|null $keyword = null): array
{
//    mencari kategori dari person
    $temp = [];

    $inputText = preg_quote($keyword);

    $categories = getAgeCategory($persons, $category);


    if ($keyword != null) {
        for ($i = 0; $i < count($categories); $i++) {
            if (preg_match("/$inputText/i", $categories[$i][PERSON_EMAIL])) {
                if (!in_array($categories[$i][ID], $temp)) {
                    $temp[] = $categories[$i];
                }
            }
            if (preg_match("/$inputText/i", $categories[$i][PERSON_FIRST_NAME])) {
                if (in_array($categories[$i][ID], $temp)) {
                    $temp[] = $categories[$i];
                }
            }
            if (preg_match("/$inputText/i", $categories[$i][PERSON_LAST_NAME])) {
                if (in_array($categories[$i][ID], $temp)) {
                    $temp[] = $categories[$i];
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


