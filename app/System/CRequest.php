<?php

namespace App\System;

class CRequest
{
    public $file = [];
    protected $name; // originalName

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getPath(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    // 取得用戶端真實IP
    public static function getAddress()
    {
        $ipSources = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];

        foreach ($ipSources as $key) {
            if (!empty($_SERVER[$key])) {
                $ipList = explode(',', $_SERVER[$key]);
                foreach ($ipList as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
        }

        return 'UNKNOWN';
    }

    public function getQueryParams(): array
    {
        return $_GET;
    }

    public function withoutPageParam(array $queryParams): array
    {
        unset($queryParams['page']);
        return $queryParams;
    }

    public function getGet($name = null, $default = null)
    {
         // 若無 name，則返回過濾後的 $_GET 陣列
        if ($name === null) {
            return $this->sanitizeGetParams($_GET);
        }

        // 若 name 為陣列，獲取多個值
        if (is_array($name)) {
            $data = [];
            foreach ($name as $key) {
                if (!is_string($key)) {
                    continue; // 跳過非字串鍵
                }
                // PHP 8.1 已經標記為棄用 FILTER_SANITIZE_STRING
                $data[$key] = filter_var($_GET[$key] ?? $default, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $data;
        }

        // 若 name 為字串，獲取單一值
        if (is_string($name)) {
            return self::sanitizeInput($_GET[$name] ?? $default);
        }

        // 對於無效輸入拋出異常
        throw new \InvalidArgumentException('參數 $name 必須為字串、陣列或 null。');
    }

    private function sanitizeGetParams(array $input): array {
        $sanitized = [];
        foreach ($input as $key => $value) {
            // 只處理純量值，避免嵌套數組
            if (is_scalar($value)) {
                // 根據鍵或預期類型選擇適當的過濾器
                $filter = match ($key) {
                    'email' => FILTER_SANITIZE_EMAIL,
                    'id' => FILTER_VALIDATE_INT,
                    default => FILTER_SANITIZE_SPECIAL_CHARS, // 替代 FILTER_SANITIZE_STRING
                };
                $sanitized[$key] = filter_var($value, $filter);
            } else {
                // 對於非純量值（例如數組），可選擇跳過或遞迴處理
                $sanitized[$key] = $value; // 或者實現遞迴清理
            }
        }
        return $sanitized;
    }

    private static function sanitizeInput($input, $default = null)
    {
        // 如果輸入不存在，返回預設值
        if (!isset($input)) {
            return $default;
        }

        // 如果輸入是陣列，遞迴清理每個元素
        if (is_array($input)) {
            return array_map(
                function ($value) {
                    return is_array($value) ? self::sanitizeInput($value) : htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                }, $input
            );
        }

        // 如果輸入是字串，使用 htmlspecialchars 清理
        if (is_string($input)) {
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        }

        // 其他類型直接返回
        return $input;
    }

    public function getPost($name = null, $default = null)
    {
        // 若無 name，則返回過濾後的 $_POST 陣列
        if ($name === null) {
            return $this->sanitizeGetParams($_POST);
        }

        // 若 name 為陣列，獲取多個值
        if (is_array($name)) {
            $data = [];
            foreach ($name as $key) {
                if (!is_string($key)) {
                    continue; // 跳過非字串鍵
                }
                // PHP 8.1 已經標記為棄用 FILTER_SANITIZE_STRING
                $data[$key] = filter_var($_POST[$key] ?? $default, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $data;
        }

        // 若 name 為字串，獲取單一值
        if (is_string($name)) {
            return self::sanitizeInput($_POST[$name] ?? $default);
        }

        // 對於無效輸入拋出異常
        throw new \InvalidArgumentException('參數 $name 必須為字串、陣列或 null。');
    }

    public function getFile(string $name)
    {
        $this->file = $_FILES[$name] ?? [];
        return $this;
    }


    /**
     * Save the uploaded file to a new location.
     *
     * By default, upload files are saved in writable/uploads directory. The YYYYMMDD folder
     * and random file name will be created.
     *
     * @param string|null $folderName the folder name to writable/uploads directory.
     * @param string|null $fileName   the name to rename the file to.
     *
     * @return string file full path
     */
    public function store(?string $folderName = null, ?string $fileName = null): string
    {
        $folderName = rtrim($folderName ?? date('Ymd'), '/') . '/';
        $fileName ??= $this->getRandomName();

        $this->name = $fileName;

        // Move the uploaded file to a new location.
        $this->move(WRITEPATH . 'uploads/' . $folderName, $fileName);

        return $folderName . $this->name;
    }

    /**
     * create file target path if
     * the set path does not exist
     *
     * @return string The path set or created.
     */
    protected function setPath(string $path): string
    {
        if (! is_dir($path)) {
            mkdir($path, 0777, true);
            // create the index.html file
            if (! is_file($path . 'index.html')) {
                $file = fopen($path . 'index.html', 'x+b');
                fclose($file);
            }
        }

        return $path;
    }

    public function move($targetPath, $fileName)
    {
        $targetPath = rtrim($targetPath, '/') . '/';
        $targetPath = $this->setPath($targetPath); // set the target path

        $fullName = $targetPath.$fileName;

        if(move_uploaded_file($this->file['tmp_name'], $fullName)) {
            // $message[] = "The file ". htmlspecialchars( basename($_FILES['id-input-file-3']['name'])). " has been uploaded.";
        }else{
            // $message[] = "Sorry, there was an error uploading your file. $target_file";
        }

    }

    /**
     * Generates a random names based on a simple hash and the time, with
     * the correct file extension attached.
     */
    public function getRandomName(): string
    {
        $extension = $this->getExtension();
        $extension = empty($extension) ? '' : '.' . $extension;


        $date = new \DateTimeImmutable();
        $timeStamp = $date->getTimestamp();

        return $timeStamp . '_' . bin2hex(random_bytes(10)) . $extension;
        // return Time::now()->getTimestamp() . '_' . bin2hex(random_bytes(10)) . $extension;
    }

    public function getExtension()
    {
        $upload_filename = basename($this->file['name']);
        $sFileType = strtolower(pathinfo($upload_filename, PATHINFO_EXTENSION));
        return $sFileType;
    }

    public function getHeader(string $name)
    {
        $headers = getallheaders();
        return $headers[$name] ?? null;
    }

    public function getSession()
    {
        return session();
    }

    private static function isjQueryAjax(): bool
    {
        // 最新的 JavaScript 實作方法（例如： fetch） 並不會再發送這個標頭
        $headers = getallheaders();
        return isset($headers['X-Requested-With']) &&
               $headers['X-requested-With'] === 'XMLHttpRequest';
    }

    private static function isHeaderJson(): bool
    {
        $headers = getallheaders();
        return isset($headers['Content-Type']) &&
               $headers['Content-Type'] === 'application/json';
    }

    private static function isAjaxRequest()
    {
        // 如果 getallheaders() 不可用，可以用替代方法檢測 AJAX
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private static function isJsonRequest()
    {
        return isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json';
    }

    public function isAjax(): bool
    {
        if (self::isAjaxRequest() || self::isJsonRequest() || self::isjQueryAjax() || self::isHeaderJson()) {
            // 處理 API 請求
            // header('Content-Type: application/json');
            // echo json_encode(['status' => 'success', 'message' => 'API 請求已接收']);
            return true;
        } else {
            // 非 API 請求
            // echo "這不是 API 請求";
            return false;
        }
    }


    /**
     * Attempts to get old Input data that has been flashed to the session
     * with redirect_with_input(). It first checks for the data in the old
     * POST data, then the old GET data and finally check for dot arrays
     *
     * @return array|string|null
     */
    public function getOldInput(string $key)
    {
        // If the session hasn't been started, we're done.
        if (! isset($_SESSION)) {
            return null;
        }

        // Get previously saved in session
        $old = session('_my_old_input');

        // If no data was previously saved, we're done.
        if ($old === null) {
            return null;
        }

        // Check for the value in the POST array first.
        if (isset($old['post'][$key])) {
            return $old['post'][$key];
        }

        // Next check in the GET array.
        if (isset($old['get'][$key])) {
            return $old['get'][$key];
        }

        // helper('array');

        // // Check for an array value in POST.
        // if (isset($old['post'])) {
        //     $value = dot_array_search($key, $old['post']);
        //     if ($value !== null) {
        //         return $value;
        //     }
        // }

        // // Check for an array value in GET.
        // if (isset($old['get'])) {
        //     $value = dot_array_search($key, $old['get']);
        //     if ($value !== null) {
        //         return $value;
        //     }
        // }

        // requested session key not found
        return null;
    }


}
