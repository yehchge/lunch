<?php

/**
 * 列表分頁 Pagebar(default)
 */
namespace App\System;

class Pagebar
{
    protected int $totalItems;
    protected int $itemsPerPage;
    protected int $currentPage;
    protected string $baseUrl;
    protected array $queryParams;
    protected array $options = [];
    protected int $surroundCount = 2; // 環繞數量

    public array $templates = [
        'custom_view' => 'app/Views/layouts/custom_pagination', // custom_pagination
    ];

    public function __construct(
        int $totalItems,
        int $itemsPerPage = 10,
        int $currentPage = 1,
        string $baseUrl = '',
        array $queryParams = [],
        array $options = []
    ) {
        $this->totalItems = $totalItems;
        $this->itemsPerPage = max(1, $itemsPerPage);
        $this->currentPage = max(1, $currentPage);
        $this->baseUrl = $baseUrl ?: $_SERVER['PHP_SELF'];
        $this->queryParams = $queryParams;
        $this->options = array_merge(
            [
            'container_class' => 'pagination',
            'active_class' => 'active',
            'disabled_class' => 'disabled',
            'dots_class' => 'dots',
            // 'prev_text' => '« Previous',
            'prev_text' => 'Previous',
            // 'next_text' => 'Next »',
            'next_text' => 'Next',
            'mode' => 'query',
            ], $options
        );
    }

    public function totalPages(): int
    {
        return (int) ceil($this->totalItems / $this->itemsPerPage);
    }

    public function offset(): int
    {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function limit(): int
    {
        return $this->itemsPerPage;
    }

    protected function buildUrl(int $page): string
    {
        $mode = $this->options['mode'];

        if ($mode === 'uri') {
            // URI 模式：如 /index.php/3
            $url = rtrim($this->baseUrl, '/') . '/' . $page;
            if (!empty($this->queryParams)) {
                $url .= '?' . http_build_query($this->queryParams);
            }
            return $url;
        } else {
            $params = array_merge($this->queryParams, ['page' => $page]);
            return $this->baseUrl . '?' . http_build_query($params);
        }
    }

    private function renderFile(string $view, array $data = [])
    {
        $data = [
            'page' => $this->page,
            'perPage' => $this->perPage,
            'total' => $this->total,
            'pager' => $this
        ];

        // 設定 views 的資料夾路徑
        $viewPath = PATH_ROOT . '/' . $view . '.php';


        if (!file_exists($viewPath)) {
            http_response_code(404);
            echo "View '{$viewPath}' not found.";
            return;
        }

        extract($data);

        ob_start();
        include $viewPath;

        // 取得緩衝內容
        $output = ob_get_clean();
        return $output;
    }

    public function render(string $view = '', array $data = []): string
    {
        if ($view) {
            return $this->renderFile($view, $data);
        }

        $totalPages = $this->totalPages();
        if ($totalPages <= 1) { return '';
        }

        $o = $this->options;
        $html = '<nav aria-label="Page navigation">';
        $html .= '<ul class="' . $o['container_class'] . '" role="list">';

        $range = $this->getVisiblePageRange($totalPages);

        if ($this->hasPrevious()) {
            // 第一頁
            $html .= sprintf(
                '<li><a href="%s" aria-label="First">First</a></li>',
                $this->buildUrl(1)
            );

            // 上一頁
            $html .= sprintf(
                '<li><a href="%s" aria-label="Previous">%s</a></li> ',
                $this->buildUrl($this->currentPage - 1),
                $o['prev_text']
            );
        }

        for ($i = $range['start']; $i <= $range['end']; $i++) {
            $html .= $this->link($i);
        }

        if ($this->hasNext()) {
            // 下一頁
            $html .= sprintf(
                '<li><a href="%s" aria-label="Next">%s</a></li> ',
                $this->buildUrl($this->currentPage + 1),
                $o['next_text']
            );

            // // 最後一頁
            // if ($range['end'] < $totalPages) {
                $html .= sprintf(
                    '<li><a href="%s" aria-label="Last">Last</a></li> ',
                    $this->buildUrl($totalPages),
                    $totalPages
                );
            // }
        }

        $html .= "</ul>";
        $html .= '</nav>';
        return $html;
    }

    public function links()
    {
        return $this->render();
    }

    public function linksCustom()
    {
        $results = [];

        $totalPages = $this->totalPages();

        if ($totalPages <= 1) {
            return [];
        }

        $range = $this->getVisiblePageRange($totalPages);

        for ($i = $range['start']; $i <= $range['end']; $i++) {

            $isActive = ($i === $this->currentPage);
            $active = '';
            if ($isActive) { $active = 'active';
            }

            $results[] = [
                'active' => $active,
                'uri' =>  $this->buildUrl($i),
                'title' => $i, // page
            ];
        }

        return $results;
    }

    protected function link(int $page): string
    {
        $o = $this->options;
        $isActive = ($page === $this->currentPage);
        if ($isActive) {
            return sprintf(
                '<li class="%s"><a href="%s">%d</a></li> ',
                $o['active_class'],
                $this->buildUrl($page),
                $page
            );
        } else {
            return sprintf(
                '<li><a href="%s">%d</a></li> ',
                $this->buildUrl($page),
                $page
            );
        }
    }


    public function setSurroundCount(?int $count = null)
    {
        $this->surroundCount = $count;

        $totalPages = $this->totalPages();
        $this->getVisiblePageRange($totalPages);

        return $this;
    }

    protected function getVisiblePageRange(int $totalPages): array
    {
        $half = (int) $this->surroundCount;
        $start = max(1, $this->currentPage - $half);
        $end = min($totalPages, $this->currentPage + $half);

        if ($end - $start + 1 < ($half * 2)) {
            $start = max(1, $end - ($half * 2) + 1);
        }

        return ['start' => $start, 'end' => $end];
    }


    /**
     * Allows for a simple, manual, form of pagination where all of the data
     * is provided by the user. The URL is the current URI.
     *
     * @param string      $template The output template alias to render.
     * @param string|null $group    optional group (i.e. if we'd like to define custom path)
     */
    public function makeLinks(int $page, ?int $perPage, int $total, string $template = 'default_full'): string
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->total = $total;

        return $this->displayLinks($template);
    }

    /**
     * Does the actual work of displaying the view file. Used internally
     * by links(), simpleLinks(), and makeLinks().
     */
    protected function displayLinks(string $template): string
    {
        return $this->render($this->templates[$template]);
    }

    public function hasPrevious()
    {
        return ($this->currentPage > ($this->surroundCount + 1))?true:false;
    }

    public function getFirst()
    {
        return $this->buildUrl(1);
    }

    public function getPrevious()
    {
        return $this->buildUrl($this->currentPage - 1);
    }

    public function hasNext()
    {
        $totalPages = $this->totalPages();
        if (($this->currentPage + $this->surroundCount) < $totalPages) {
            return true;
        }
        return false;
    }

    public function getNext()
    {
        return $this->buildUrl($this->currentPage + 1);
    }

    public function getLast()
    {
        $totalPages = $this->totalPages();
        return $this->buildUrl($totalPages);
    }

    public function getPerPageStart()
    {
        return  $this->offset() + 1;
    }

    public function getPerPageEnd()
    {
        $endItem = $this->limit() + $this->offset();
        if ($endItem > $this->totalItems) {
            $endItem = $this->totalItems;
        }

        return $endItem;
    }

    public function getTotal()
    {
        // 總筆數
        return $this->totalItems;
    }
}
