<?php

class DummyTableModel extends Model
{
    private $paginator;

    public $config = [];
    public $groups = [];

    protected $table = 'dummy_table';

    // public function links(){
    //     $router = new Router();

    //     $func = $router->func();
    //     $action = $router->action();
    //     $params = $router->params();

    //     $request = new CRequest();

    //     // 取得查詢參數
    //     $queryParams = $request->getQueryParams();

    //     // 當前頁數
    //     $currentPage = $queryParams['page'] ?? 1;
    //     $mode = 'query';

    //     if ($this->segment) {
    //         $currentPage = $this->iGetPageByURI($this->segment);
    //         $mode = 'uri';
    //     }

    //     // 總筆數
    //     $totalItems = $this->countAll();

    //     // 每頁幾筆
    //     $itemsPerPage = $this->perPage;

    //     $paginator = new Pagebar(
    //         $totalItems,
    //         $itemsPerPage,
    //         $currentPage,
    //         // BASE_URL.'loadRecord',
    //         BASE_URL.$func,
    //         $request->withoutPageParam($queryParams),
    //         ['mode' => $mode]
    //     );

    //     $this->paginator = $paginator;

    //     $this->pager = $paginator;

    //     return $paginator->links();
    // }





}
