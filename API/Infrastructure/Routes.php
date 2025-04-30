<?php
    $app->Get("/api/test",fn() => Ok(array(5,4,3,2,1)));
    $app->Get("/board/getAll",[BoardController::class,"GetAll"]);
    $app->Get("/thread/{boardId}/{currentPage}/{pageSize}",[ThreadController::class,"TreeByBoard"]);
    $app->Put("/user/getAll/",[UserController::class,"GetAll"]);
    //$app->Get("/",fn() => View("./Infrastructure/Views/layout.html"));
?>