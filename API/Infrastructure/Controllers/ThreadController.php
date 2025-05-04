<?php
class ThreadController
{
    private ThreadHandler $handler;
    public function __construct()
    {
        global $core;
        $this->handler =  new ThreadHandler();
    }
    public function TreeByBoard($boardName, $currentPage, $pageSize)
    {
        //$model = $this->handler->GetTreeByBord($boardId);
        $model = $this->handler->GetPaginedByBoard($boardName, $currentPage, $pageSize);
        JSON($model);
    }
    public function GetByThread($boardId, $currentPage, $pageSize)
    {
        //$model = $this->handler->GetTreeByBord($boardId);
        $model = $this->handler->GetPaginedByBoard($boardName, $currentPage, $pageSize);
        JSON($model);
    }
}
