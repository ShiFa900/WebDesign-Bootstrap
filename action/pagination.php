<?php

function getPaginatedData(array $array, string $page, int $limit, int $totalPage): array
{
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