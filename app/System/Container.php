<?php

namespace App\System;

class Container
{
    // 儲存綁定（類或閉包）
    protected $bindings = [];
    // 儲存已解析的單例實例
    protected $instances = [];

    // 綁定類或閉包到容器
    public function bind($abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }
        $this->bindings[$abstract] = $concrete;
    }

    // 綁定單例
    public function singleton($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete);
        // 標記為單例，實例化後儲存
        $this->instances[$abstract] = null;
    }

    // 解析類或閉包
    public function make($abstract)
    {
        // 如果已經是單例且已解析，直接返回
        if (isset($this->instances[$abstract]) && !is_null($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // 獲取綁定
        $concrete = $this->bindings[$abstract] ?? $abstract;

        // 如果是閉包，直接執行
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        // 使用反射解析類
        $object = $this->resolveClass($concrete);

        // 如果是單例，儲存實例
        if (array_key_exists($abstract, $this->instances)) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    // 使用反射解析類及其依賴
    protected function resolveClass($class)
    {
        try {
            if (!class_exists($class)) {
                throw new \Exception("類 $class 不存在，請檢查類名或自動加載配置");
            }
            $reflector = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \Exception("無法解析類 $class: " . $e->getMessage());
        }

        // 檢查類是否可實例化
        if (!$reflector->isInstantiable()) {
            throw new \Exception("類 $class 不可實例化");
        }

        // 獲取建構函數
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            // 無建構函數，直接創建
            return new $class;
        }

        // 獲取建構函數參數
        $parameters = $constructor->getParameters();
        $dependencies = $this->resolveDependencies($parameters);

        // 創建實例並傳遞依賴
        return $reflector->newInstanceArgs($dependencies);
    }

    // 解析建構函數的依賴
    protected function resolveDependencies($parameters)
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();

            if ($dependency && !$dependency->isBuiltin()) {
                // 遞歸解析依賴類
                $dependencies[] = $this->make($dependency->getName());
            } else {
                // 處理非類型的參數（例如基本類型），這裡可以設置默認值或拋出異常
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception("無法解析參數 {$parameter->name} 的依賴");
                }
            }
        }

        return $dependencies;
    }
}
