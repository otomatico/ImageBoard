<?php

class UserController{
    private array $list;
    public function __construct()
    {
        $this->list = array(1,2,3,4,5);
    }

    public function GetAll()
    {
        JSON($this->list);
    }
    public function Get($id)
    {
        $model = $this->list[$id];
        Ok($model);
    }
}
?>