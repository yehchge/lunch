<?php

namespace App\System;

class Redirect
{
    public static $routes;

    /**
     * Redirect to a specified URL
     *
     * @param  string $url        The URL to redirect to
     * @param  int    $statusCode HTTP status code for redirection (default: 302)
     * @return void
     */
    public function to(string $url, int $statusCode = 302): void
    {
        // Ensure the URL is properly formatted
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = rtrim($this->getBaseUrl(), '/') . '/' . ltrim($url, '/');
        }

        header('Location: ' . $url, true, $statusCode);
        exit;
    }

    /**
     * Redirect back to the previous page
     *
     * @return void
     */
    public function back(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? $this->getFallbackUrl();
        $this->to($referer);
    }

    /**
     * Get the base URL of the application, including the project subdirectory
     *
     * @return string
     */
    private function getBaseUrl(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        // 獲取腳本路徑並提取子目錄
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = dirname($scriptName);
        if ($basePath === '/' || $basePath === '\\') {
            $basePath = '';
        }

        return $protocol . '://' . $host . $basePath;
    }

    /**
     * Get a fallback URL when HTTP_REFERER is not available
     *
     * @return string
     */
    private function getFallbackUrl(): string
    {
        return $this->getBaseUrl() . '/';
    }
}
