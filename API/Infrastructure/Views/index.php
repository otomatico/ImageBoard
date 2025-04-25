<?php
include_once("../Services/config.php");
$DIR =  explode("\\",__DIR__);
array_splice($DIR,-2);

LoadSettings(join("\\",$DIR));

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path == "/") {
    include "layout.html";
    die;
}
include __DIR__ . $path;
?>