<?php
//CORS Activate
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');    // cache for 1 day
try {
    include_once("./Infrastructure/Services/config.php");
    include_once("./Infrastructure/Services/database.php");
    require_once('./infrastructure/services/core.php');
    
    LoadSettings(__DIR__);
    $GLOBALS["Database"] = Database($GLOBALS["AppSettings"]['ConnectionString']);
    $core =  new Core(__DIR__);
    $core->Start();
} catch (Exception $exception) {
    echo  $exception->getMessage();
}

//php -S localhost:4321 index.php ->Api
//php -S localhost:4200 -t.\Infrastructure\Views\ ->Web