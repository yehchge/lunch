<?php

/**
 * 列表分頁 Pagebar
 */

class Pagebar
{
    protected int $totalItems;
    protected int $itemsPerPage;
    protected int $currentPage;
    protected string $baseUrl;
    protected array $queryParams;
    protected int $maxVisibleLinks = 7;
    protected array $options = [];

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
        $this->options = array_merge([
            'container_class' => 'pagination',
            'active_class' => 'active',
            'disabled_class' => 'disabled',
            'dots_class' => 'dots',
            'prev_text' => '« Previous',
            'next_text' => 'Next »',
            'mode' => 'query',
        ], $options);
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

    public function render(): string
    {
        $totalPages = $this->totalPages();
        if ($totalPages <= 1) return '';

        $o = $this->options;
        $html = '<nav aria-label="Page navigation">';
        $html .= '<ul class="' . $o['container_class'] . '" role="list">';

        // 上一頁
        if ($this->currentPage > 1) {
            $html .= sprintf('<li><a href="%s" aria-label="Previous">%s</a></li> ',
                $this->buildUrl($this->currentPage - 1),
                $o['prev_text']
            );
        }

        $range = $this->getVisiblePageRange($totalPages);

        if ($range['start'] > 1) {
            if ($range['start'] > 2) {
                $html .= sprintf('<li><a href="%s" aria-label="First">1</a></li>',
                    $this->buildUrl(1)
                );

                $html .= '<span class="' . $o['dots_class'] . '">…</span> ';
            }else{
                $html .= $this->link(1);
            }
        }

        for ($i = $range['start']; $i <= $range['end']; $i++) {
            $html .= $this->link($i);
        }

        if ($range['end'] < $totalPages) {
            if ($range['end'] < $totalPages - 1) {
                $html .= '<span class="' . $o['dots_class'] . '">…</span> ';
            }
            $html .= sprintf('<li><a href="%s" aria-label="Last">%d</a></li> ',
                $this->buildUrl($totalPages),
                $totalPages
            );

        }

        // 下一頁
        if ($this->currentPage < $totalPages) {
            $html .= sprintf('<li><a href="%s" aria-label="Next">%s</a></li> ',
                $this->buildUrl($this->currentPage + 1),
                $o['next_text']
            );
        }

        $html .= "</ul>";
        $html .= '</nav>';
        return $html;
    }

    protected function link(int $page): string
    {
        $o = $this->options;
        $isActive = ($page === $this->currentPage);
        if ($isActive) {
            return sprintf('<li class="%s"><a href="%s">%d</a></li> ',
                $o['active_class'],
                $this->buildUrl($page),
                $page
            );
        } else {
            return sprintf('<li><a href="%s">%d</a></li> ',
                $this->buildUrl($page),
                $page
            );
        }
    }

    protected function getVisiblePageRange(int $totalPages): array
    {
        $half = (int) floor($this->maxVisibleLinks / 2);
        $start = max(1, $this->currentPage - $half);
        $end = min($totalPages, $start + $this->maxVisibleLinks - 1);

        if ($end - $start + 1 < $this->maxVisibleLinks) {
            $start = max(1, $end - $this->maxVisibleLinks + 1);
        }

        return ['start' => $start, 'end' => $end];
    }
}
