<?php

function nav_menu(string $title, string $filename): string
{
    $classname = "";
    if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
        $classname .= "active";
    }
    return "<a href='$filename' class='$classname'>$title</a> ";
}
?>
