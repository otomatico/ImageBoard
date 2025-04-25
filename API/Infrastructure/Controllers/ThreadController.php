<?php
class ThreadController{
    private ThreadHandler $handler;
    public function __construct()
    {
        GLOBAL $core;
        $this->handler =  new ThreadHandler();
    }
    public function TreeByBoard($boardId){
       $model = $this->handler->GetTreeByBord($boardId);
       JSON($model);
    }
}
?>