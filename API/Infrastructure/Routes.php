<?php
    $app->Get("/api/test",fn() => Ok(array(5,4,3,2,1)));
    $app->Get("/board/getAll",[BoardController::class,"GetAll"]);
    $app->Get("/thread/{boardName}/{currentPage}/{pageSize}",[ThreadController::class,"TreeByBoard"]);
    $app->Get("/post/{threadId}",[PostController::class,"GetByThread"]);
    $app->Get("/post/{threadId}/{currentPage}/{pageSize}",[PostController::class,"GetPaginedByThread"]);
    $app->Put("/user/getAll/",[UserController::class,"GetAll"]);
    //$app->Get("/",fn() => View("./Infrastructure/Views/layout.html"));
?>