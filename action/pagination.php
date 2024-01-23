<?php

/**
 * @param array $array
 * @param string $page
 * @param int $limit
 * @param int $totalPage
 * @return array
 * get paginated data that will show in each page
 */
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