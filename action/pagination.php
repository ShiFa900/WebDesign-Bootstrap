<?php

/**
 * get all people's data as much as the limit that will be shown in page 1 until last pages
 * @param array $array
 * @param string $page
 * @param int $limit
 * @param int $totalPage
 * @return array
 */
function getPaginatedData(array $array, string $page, int $limit): array
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