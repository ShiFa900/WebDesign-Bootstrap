<?php
function replaceSpace(string $string): string
{
    return preg_replace('/\s+/', '+', $string);
}