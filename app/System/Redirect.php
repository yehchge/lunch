<?php

class Redirect
{
    public static $routes;

    /**
     * Redirect to a specified URL
     *
     * @param string $url The URL to redirect to
     * @param int $statusCode HTTP status code for redirection (default: 302)
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
     * Get the base URL of the application
     *
     * @return string
     */
    // private function getBaseUrl(): string
    // {
    //     $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    //     $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    //     return $protocol . '://' . $host;
    // }


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

    /**
     * Redirect to a named route
     *
     * @param string $routeName The name of the route
     * @param array $params Parameters for the route (optional)
     * @param int $statusCode HTTP status code for redirection (default: 302)
     * @return void
     */
    // public function route(string $routeName, array $params = [], int $statusCode = 302): void
    // {
    //     $url = $this->resolveRoute($routeName, $params);
    //     $this->to($url, $statusCode);
    // }

    // /**
    //  * Resolve a route name to its corresponding URL
    //  *
    //  * @param string $routeName The name of the route
    //  * @param array $params Parameters for the route
    //  * @return string
    //  */
    // private function resolveRoute(string $routeName, array $params = []): string
    // {
    //     // This is a placeholder for route resolution logic
    //     // In a real framework, this would interact with the routing system
    //     // $routes = $this->getRoutes();

    //     $routes = self::$routes;

    //     if (!isset($routes[$routeName])) {
    //         throw new \Exception("Route '{$routeName}' not found.");
    //     }

    //     $url = $routes[$routeName];

    //     // Replace route parameters (e.g., {id}) with provided values
    //     foreach ($params as $key => $value) {
    //         $url = str_replace("{{$key}}", urlencode($value), $url);
    //     }

    //     return $url;
    // }

    // /**
    //  * Get the defined routes (placeholder for actual route configuration)
    //  *
    //  * @return array
    //  */
    // private function getRoutes(): array
    // {
    //     // Example routes; replace with your framework's route configuration
    //     return [
    //         'home' => '/',
    //         'user.profile' => '/user/{id}',
    //         'dashboard' => '/dashboard',
    //     ];
    // }
}

// Helper function to create Redirect instance
function redirect(): Redirect
{
    return new Redirect();
}
