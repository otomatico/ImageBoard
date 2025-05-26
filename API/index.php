<?php
//CORS Activate
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS ");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');    // cache for 1 day
try {
    include_once("./Infrastructure/Services/config.php");
    include_once("./Infrastructure/Services/database.php");
    include_once("./Infrastructure/Services/functions.php");
    LoadSettings(__DIR__);
    $GLOBALS["Database"] = Database($GLOBALS["AppSettings"]['ConnectionString']);

    ////If you use Core, HTTPMethods will not be taken into account.
    //require_once('./infrastructure/services/core.php');
    ////Dependency injection
    //    $core =  new Core(__DIR__);
    //    $core->Start();

    //If you use Router, the HTTPMethod will be taken into account.
    require_once('./infrastructure/services/router.php');
    //Dependency injection
    $app = new Router(__DIR__);

    //Route will have to be declared.
    require_once('./Infrastructure/routes.php');
    $app->Resolve();

} catch (Exception $exception) {
    echo  $exception->getMessage();
}

//...ImageBoard\API> php -S localhost:4321 index.php ->Api
//    ...ImageBoard> php -S localhost:4200 -t.\Web\ ->Web