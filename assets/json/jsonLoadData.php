<?php
    function saveDataIntoJson(array $array, $filename)
    {
        $json = json_encode($array, JSON_PRETTY_PRINT);
        file_put_contents($filename, $json);
    }

    function loadDataFromJson($filename)
    {
        $path = __DIR__ . "/" . $filename;
        if (file_exists($path)) {
            $data = file_get_contents($path);
            $result = json_decode($data, true);
            if ($result == null) {
                return [];
            }
            return $result;
        }
        return [];
    }
