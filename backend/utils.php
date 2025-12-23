<?php
function style_date(string $date_str): string
{
    $timestamp = strtotime($date_str);
    return date("d/m/Y", $timestamp);
}