<?php
class PostController
{
    private PostHandler $handler;
    public function __construct()
    {
        global $core;
        $this->handler =  new PostHandler();
    }

    public function GetByThread($boardId)
    {
        $model = $this->handler->GetByThread($boardId);
        JSON($model);
    }
    public function GetPaginedByThread($threadId, $currentPage, $pageSize)
    {
        $model = $this->handler->GetByThread($threadId);
        JSON($model);
    }
}
