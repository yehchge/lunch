<?php

/**
 * 驗證資料
 *
 * 如何自訂規則?
 *
 * 假設要新增一個 [必須大寫] 的規則：
 * $validator->extend('uppercase', function() {
 *     return strtoupper($value) === $value;
 * });
 *
 * 然後在 rules 使用:
 * 'randoomcode' => 'required|uppercase'
 *
 * 使用說明：
 *
 * $data = [
 *     'username' => 'Coder01',
 *     'email' => 'test@example.com',
 *     'age' => 20,
 *     'accept' => '1',
 *     'ip' => '127.0.0.1',
 * ];
 * $rules = [
 *     'username' => 'required|alpha_num|min:3|max:20',
 *     'email' => 'required|email',
 *     'age' => 'numeric|between:18,65',
 *     'accept' => 'boolean',
 *     'ip' => 'ip',
 * ];
 * $validator = new \App\System\Validator($data, $rules);
 * if (!$validator->validate()) {
 *     print_r($validator->getErrors());
 * }
 *
 */

namespace App\System;

class Validator
{
    protected $data; // 待驗證的資料
    protected $rules; // 驗證規則
    protected $errors = []; // 錯誤訊息
    protected $messages = []; // 自訂錯誤訊息
    protected $rulesMap = [];

    // 預設的錯誤訊息模板
    protected $defaultMessages = [
        'required'  => 'The :field field is required.',
        'email'     => 'The :field field must be a valid email address.',
        'min'       => 'The :field field must be at least :param characters in length.',
        'max'       => 'The :field field cannot exceed :param characters in length.',
        'numeric'   => 'The :field field must be numeric.',
        'int'       => 'The :field field must be an integer.',
        'string'    => 'The :field field must be a string.',
        'boolean'   => 'The :field field must be true or false.',
        'array'     => 'The :field field must be an array.',
        'url'       => 'The :field field must be a valid URL.',
        'date'      => 'The :field field must be a valid date.',
        'alpha'     => 'The :field field may only contain letters.',
        'alpha_num' => 'The :field field may only contain letters and numbers.',
        'same'      => 'The :field field must match :param.',
        'regex'     => 'The :field field format is invalid.',
        'between'   => 'The :field field must be between :param characters.',
        'json'      => 'The :field field must be a valid JOSN string.',
        'ip'        => 'The :field field must be a valid IP address.',
        'uuid'      => 'The :field field must be a valid UUID',
        'in'        => 'The :field field must be one of: :param.',
    ];

    // 建構子，傳入資料和規則
    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
        $this->registerDefaultRules();
    }

    // 動態註冊規則
    public function registerRule(string $name, callable $closure)
    {
        $this->rulesMap[$name] = $closure;
    }

    // 預設規則
    protected function registerDefaultRules()
    {
        // 應用單一驗證規則
        $this->registerRule('required', function($value) {
            return !(is_null($value) || $value === '');
        });
        $this->registerRule('email', function($value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
        });
        $this->registerRule('min', function($value, $param) {
            return is_string($value) && mb_strlen($value) >= (int)$param;
        });
        $this->registerRule('max', function($value, $param) {
            return is_string($value) && mb_strlen($value) <= (int)$param;
        });
        $this->registerRule('numeric', function($value) {
            return is_numeric($value);
        });
        $this->registerRule('int', function($value) {
            // 檢查是否為純數字字串且無小數點
            // 檢查是否為非負數 (>= 0) 或正數 (> 0)
            return preg_match('/^\d+$/', $value) && (int)$value > 0; // 正數
        });
        $this->registerRule('string', function($value) {
            return is_string($value);
        });
        $this->registerRule('boolean', function($value) {
            return $value === true || $value === false || $value === 1 || $value === 0 || $value === "1" || $value === "0";
        });
        $this->registerRule('array', function($value) {
            return is_array($value);
        });
        $this->registerRule('url', function($value) {
            return filter_var($value, FILTER_VALIDATE_URL) !== false;
        });
        $this->registerRule('date', function($value) {
            return strtotime($value) !== false;
        });
        $this->registerRule('alpha', function($value) {
            return preg_match('/^[a-zA-Z]+$/', $value);
        });
        $this->registerRule('alpha_num', function($value) {
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        });
        $this->registerRule('same', function($value, $param) {
            return $value === ($this->data[$param] ?? null);
        });
        $this->registerRule('regex', function($value, $param) {
            return preg_match($param, $value);
        });
        $this->registerRule('between', function($value, $param) {
            [$min, $max] = explode(',', $param);
            $len = is_numeric($value) ? $value : mb_strlen($value);
            return $len >= (int)$min && $len <= (int)$max;
        });
        $this->registerRule('json', function($value) {
            json_decode($value);
            return (json_last_error() === JSON_ERROR_NONE);
        });
        $this->registerRule('ip', function($value) {
            return filter_var($value, FILTER_VALIDATE_IP) !== false;
        });
        $this->registerRule('uuid', function($value) {
            return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[0-9a-f]{12}$/i', $value);
        });
        $this->registerRule('in', function($value, $param) {
            // 檢查值是否在指定選項中。 Ex: 'gender' => 'required|in:male,female,other',
            $options = explode(',', $param);
            return in_array($value, $options);
        });
    }

    // 執行驗證
    public function validate(): bool
    {
        $session = session();
        $session->set(
            '_my_old_input', [
            'post' => $_POST,
            'get' => $_GET
            ]
        );

        $this->errors = []; // 清空錯誤訊息
        foreach ($this->rules as $field => $ruleSet) {
            // 將規則字串轉為陣列（例如 'required|email' => ['required', 'email']）
            $rules = is_string($ruleSet) ? explode('|', $ruleSet) : $ruleSet;

            foreach ($rules as $rule) {
                // 解析規則參數（例如 'min:5' => ['min', '5']）
                $ruleParts = explode(':', $rule, 2);
                $ruleName = $ruleParts[0];
                $ruleParam = $ruleParts[1] ?? null;
                $closure = $this->rulesMap[$ruleName] ?? null;
                if ($closure) {
                    $result = $closure(...[
                        $this->data[$field] ?? null,
                        $ruleParam
                    ]);
                    if (!$result) {
                        $this->addError($field, $ruleName, $ruleParam);
                        break;
                    }
                }
            }
        }


        if (!empty($this->errors)) {
            $message = '';
            // 輸出錯誤訊息
            foreach ($this->errors as $errors) {
                foreach ($errors as $error) {
                    $message .= $error."<br>";
                }
            }

            $session->setFlashdata('errors', $message);
        }

        return empty($this->errors);
    }

    // 新增錯誤訊息
    protected function addError(string $field, string $rule, ?string $param): void
    {
        // 優先使用自訂訊息
        $messageKey = "$field.$rule";
        $message = $this->messages[$messageKey] ?? $this->defaultMessages[$rule] ?? 'Invalid value for :field.';

        // 替換訊息中的佔位符
        $message = str_replace(':field', $field, $message);
        $message = str_replace(':param', $param ?? '', $message);

        $this->errors[$field][] = $message;
    }

    // 獲取錯誤訊息
    public function getErrors(): array
    {
        return $this->errors;
    }

    // 檢查是否驗證通過
    public function passes(): bool
    {
        return empty($this->errors);
    }

    // 檢查是否驗證失敗
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function getData(): array
    {
        return $this->data;
    }

    // 用來讓外部註冊自訂規則
    protected function extend(string $name, callable $closure)
    {
        // 在此處實現自訂規則邏輯
        $this->registerRule($name, $closure);
    }
}
