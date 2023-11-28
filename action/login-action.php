<?php

require_once __DIR__ . "/../assets/json/jsonLoadData.php";

function userExist(array $data): bool
{
  for ($i = 0; $i < count($data); $i++) {
    if ($_POST["email"] == $data[$i]["email"] && $_POST["password"] == $data[$i]["password"]) {

      //         echo "hello " . $_POST["password"];
      return true;
    }
  }
  return false;
}


$data = getAll();
if (userExist($data)) {
  redirect("../dashboard.php", true);
} else {
  redirect("../login.php", "error=1");
}

/**
 * @param url go to login page if it unsucces
 * @param string error message on the header
 */
function redirect($url, $getParams)
{
  header('Location: ' . $url . '?' . $getParams);
  die();
}

function getAll(): array
{
  // we need to convert it into array of Person
  $persons = loadDataFromJson("persons.json");
  $result = [];
      for ($i = 0; $i <= count($persons); $i++) {
          $person = [
              "id" => $persons[$i]["id"],
              "firstName" => $persons[$i]["firstName"],
              "lastName" => $persons[$i]["lastName"],
              "nik" => $persons[$i]["nik"],
              "email" => $persons[$i]["email"],
              "birthDate" => $persons[$i]["birthDate"],
              "sex" => $persons[$i]["sex"],
              "internalNote" => $persons[$i]["internalNote"],
              "role" => $persons[$i]["role"],
              "password" => $persons[$i]["password"]
          ];

          $result[] = $person;
      }
  return $result;
}


// NOTE
// 1. User berhasil login dan masuk ke halaman dashboard (tidak bisa kembali ke halaman login lagi harusnya)
// 2. Nama di header untuk dashboard dan nama user di header nav akan sync dengan user yang sedang login