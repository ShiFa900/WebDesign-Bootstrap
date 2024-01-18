<?php

function getPaginatedData(array $array, int $page, int $limit): array
{
    $totalPage = ceil((float)count($array) / (float)$limit);
    $indexStart = ($page - 1) * $limit;
    $length = $limit;
    if (($indexStart + $limit) > count($array)) {
        $length = count($array) - $indexStart;
    }

    return [
        PAGING_TOTAL_PAGE => $totalPage,
        PAGING_DATA => array_slice($array, $indexStart, $length),
        PAGING_CURRENT_PAGE => $page,
    ];
}