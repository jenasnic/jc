<?php

namespace jc\ToolBundle\Service\Model;

class PaginationInformation {

    private $page;
    private $pageCount;
    private $totalCount;
    private $itemList;

    public function __construct($page, $pageCount, $totalCount, $itemList) {

        $this->page = $page;
        $this->pageCount = $pageCount;
        $this->totalCount = $totalCount;
        $this->itemList = $itemList;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {

        $this->page = $page;
        return $this;
    }

    public function getPageCount() {
        return $this->pageCount;
    }

    public function setPageCount($pageCount) {

        $this->pageCount = $pageCount;
        return $this;
    }

    public function getTotalCount() {
        return $this->totalCount;
    }

    public function setTotalCount($totalCount) {

        $this->totalCount = $totalCount;
        return $this;
    }

    public function getItemList() {
        return $this->itemList;
    }

    public function setItemList($itemList) {
        $this->itemList = $itemList;
        return $this;
    }
}
