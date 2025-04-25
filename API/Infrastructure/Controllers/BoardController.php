<?php
class BoardController{
    private BoardRepository $repository;
    public function __construct()
    {
        GLOBAL $core;
        $this->repository =  new BoardRepository();
    }
    public function GetAll(){
       $model = $this->repository->GetAll();
       JSON($model);
    }
}
?>