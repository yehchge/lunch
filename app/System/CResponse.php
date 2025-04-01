<?php

// $response = new CResponse();
// $response->setHeader('Content-Type', 'application/json');
// $response->setBody('{"foo":"bar"}');
// $response->send();

class CResponse
{
    protected $headers = array();
    protected $body = '';
    protected $status = 200;
    protected $terminate = false;

    private const HTTP_CODES = [
        200 => 'OK', 201 => 'Created', 204 => 'No Content', 301 => 'Moved Permanently', 302 => 'Found',
        400 => 'Bad Request', 401 => 'Unauthorized', 403 => 'Forbidden', 404 => 'Not Found',
        405 => 'Method Not Allowed', 500 => 'Internal Server Error', 503 => 'Service Unavailable'
    ];

    public function setHeader($name, $value, $override = true)
    {
        if (!$override && isset($this->headers[$name])) {
            return $this;
        }
        $this->headers[$name] = $value;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function send()
    {
        @ob_clean();
        http_response_code($this->status);
        $this->sendHeaders();
        echo $this->body;

        if ($this->terminate) {
            exit; // 確保 API 立即終止
        }
    }

    protected function sendHeaders(): void
    {
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
    }

    public function json(array $data, int $status = 200): void
    {
        $this->setHeader('Content-Type', 'application/json; charset=UTF-8')
            ->setStatus($status)
            ->setBody(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT))
            ->send();
    }

    public function fail(string $message, int $status = 400, array $errors = []): void
    {
        $this->json(['error' => $message, 'details' => $errors], $status);
    }

    public function redirect($url, $status = 302)
    {
        if (!in_array($status, [301, 302, 307], true)) {
            throw new \InvalidArgumentException("Invalid redirect status: {$status}");
        }
        $this->setHeader('Location', $url)->setStatus($status)->send();
    }

    public function setStatus($status)
    {
        if (!isset(self::HTTP_CODES[$status])) {
            throw new \InvalidArgumentException("Invalid HTTP status code: {$status}");
        }
        $this->status = $status;
        return $this;
    }

    public function cleanHeaders()
    {
        @header_remove();
    }

    protected function getMethod(){
        return $_SERVER['REQUEST_METHOD'] ?? '';
    }

    public function setMethod(string $method = '')
    {
        $allowMethod = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

        if ( ! in_array(strtoupper($method), $allowMethod)) {
            return array(
                'message' => 'Wrong request method',
                'status' => 404
            );
        }

        if ($this->getMethod() !== strtoupper($method)) {
            return array(
                'message' => 'Method Not Allowed',
                'status' => 405
            );
        }

        return [];
    }

    public function setTerminate($boolean = true){
        $this->terminate = $boolean;
    }
}
