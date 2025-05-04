<?php
DEFINE("SITE_NAME","My Image Board");
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path == "/") {
    include "layout.html";
    die;
}
include __DIR__ . $path;
?>