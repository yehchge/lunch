<?php

/**
 * 列表分頁 Pagebar
 */

class Paginator
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
            'link_class' => 'page-link',
            'active_class' => 'active',
            'disabled_class' => 'disabled',
            'dots_class' => 'dots',
            'prev_text' => '« 上一頁',
            'next_text' => '下一頁 »',
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
        $params = array_merge($this->queryParams, ['page' => $page]);
        return $this->baseUrl . '?' . http_build_query($params);
    }

    public function render(): string
    {
        $totalPages = $this->totalPages();
        if ($totalPages <= 1) return '';

        $o = $this->options;
        $html = '<nav class="' . $o['container_class'] . '">';

        // 上 10 頁
        if ($this->currentPage > 10) {
            $html .= sprintf('<a href="%s" class="%s">⟪ 上10頁</a> ',
                $this->buildUrl($this->currentPage - 10),
                $o['link_class']
            );
        } else {
            $html .= sprintf('<span class="%s %s">⟪ 上10頁</span> ',
                $o['link_class'],
                $o['disabled_class']
            );
        }

        // 上一頁
        if ($this->currentPage > 1) {
            $html .= sprintf('<a href="%s" class="%s">%s</a> ',
                $this->buildUrl($this->currentPage - 1),
                $o['link_class'],
                $o['prev_text']
            );
        } else {
            $html .= sprintf('<span class="%s %s">%s</span> ',
                $o['link_class'],
                $o['disabled_class'],
                $o['prev_text']
            );
        }

        $range = $this->getVisiblePageRange($totalPages);

        if ($range['start'] > 1) {
            $html .= $this->link(1);
            if ($range['start'] > 2) {
                $html .= '<span class="' . $o['dots_class'] . '">…</span> ';
            }
        }

        for ($i = $range['start']; $i <= $range['end']; $i++) {
            $html .= $this->link($i);
        }

        if ($range['end'] < $totalPages) {
            if ($range['end'] < $totalPages - 1) {
                $html .= '<span class="' . $o['dots_class'] . '">…</span> ';
            }
            $html .= $this->link($totalPages);
        }

        // 下一頁
        if ($this->currentPage < $totalPages) {
            $html .= sprintf('<a href="%s" class="%s">%s</a> ',
                $this->buildUrl($this->currentPage + 1),
                $o['link_class'],
                $o['next_text']
            );
        } else {
            $html .= sprintf('<span class="%s %s">%s</span> ',
                $o['link_class'],
                $o['disabled_class'],
                $o['next_text']
            );
        }

        // 下 10 頁
        if ($this->currentPage + 10 <= $totalPages) {
            $html .= sprintf('<a href="%s" class="%s">下10頁 ⟫</a> ',
                $this->buildUrl($this->currentPage + 10),
                $o['link_class']
            );
        } else {
            $html .= sprintf('<span class="%s %s">下10頁 ⟫</span> ',
                $o['link_class'],
                $o['disabled_class']
            );
        }

        $html .= '</nav>';
        return $html;
    }

    protected function link(int $page): string
    {
        $o = $this->options;
        $isActive = ($page === $this->currentPage);
        if ($isActive) {
            return sprintf('<span class="%s %s">%d</span> ',
                $o['link_class'],
                $o['active_class'],
                $page
            );
        } else {
            return sprintf('<a href="%s" class="%s">%d</a> ',
                $this->buildUrl($page),
                $o['link_class'],
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
