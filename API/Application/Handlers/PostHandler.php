<?php

class PostHandler
{
    private PostRepository $post;
    public function __construct()
    {
        $this->post =  new PostRepository();
    }

    public function GetByThread($threadId)
    {
        $posts = $this->post->GetByThead($threadId);
        return $posts;
    }
}
