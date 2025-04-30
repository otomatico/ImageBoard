<?php
class PageInfo{
    public int $TotalPages;
    function __construct(public readonly int $CurrentPage,public readonly int $PageSize,public readonly int $TotalItems)
    {
        $this->TotalPages = ceil($this->TotalItems/$this->PageSize);
    }

}
class Pagined{
    function __construct(public readonly PageInfo $PageInfo, public readonly array $Items)
    {
    }
}