<?php

class CRequest
{
    public $file = [];
    protected $name; // originalName

    # 取得用戶端真實IP
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

    public function getGet()
    {
        return $_GET;
    }

    public function getPost(string $name = '')
    {
        if($name) return $_POST[$name] ?? '';
        return $_POST;
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

        if(move_uploaded_file($this->file['tmp_name'], $fullName)){
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


        $date = new DateTimeImmutable();
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

}
