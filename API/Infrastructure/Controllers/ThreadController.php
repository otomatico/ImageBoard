<?php
class ThreadController
{
    private ThreadHandler $handler;
    public function __construct()
    {
        global $core;
        $this->handler =  new ThreadHandler();
    }
    public function TreeByBoard($boardId, $currentPage, $pageSize)
    {
        //$model = $this->handler->GetTreeByBord($boardId);
        $model = $this->handler->GetPaginedByBoard($boardId, $currentPage, $pageSize);
        JSON($model);
    }
}
