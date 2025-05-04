<?php

class ThreadHandler
{
    private BoardRepository $board;
    private ThreadRepository $thread;
    private PostRepository $post;
    public function __construct()
    {
        $this->board =  new BoardRepository();
        $this->thread =  new ThreadRepository();
        $this->post =  new PostRepository();
    }

    public function GetTreeByBord($id)
    {
        $threads =  $this->thread->GetByBoard($id);
        foreach ($threads as $item) {
            $item->posts = $this->post->GetByThead($item->id);
        }
        return $threads;
    }
    public function GetPaginedByBoard($boardName,$currentPage,$pageSize)
    {
        $boardItem =  $this->board->GetByName($boardName)[0];
        $Total =  $this->thread->GetTotalByBoard($boardItem->id);
        $threads =  $this->thread->GetPaginedByBoard($boardItem->id,$currentPage,$pageSize);

        foreach ($threads as $item) {
            $item->total_posts = $this->post->GetTotalByThread($item->id);
            $item->posts = $this->post->GetPaginedByThread($item->id, 1, 3);
        }

        $pagined = new Pagined(new PageInfo($currentPage,$pageSize,$Total),$threads);
        return $pagined ;
    }
}
