<?php

class ThreadHandler
{
    private ThreadRepository $thread;
    private PostRepository $post;
    public function __construct()
    {
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
}
