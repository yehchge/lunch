<?php

namespace App\System;

class Validator
{
    protected $data; // 待驗證的資料
    protected $rules; // 驗證規則
    protected $errors = []; // 錯誤訊息
    protected $messages = []; // 自訂錯誤訊息

    // 預設的錯誤訊息模板
    protected $defaultMessages = [
        'required' => 'The :field field is required.',
        'email'    => 'The :field field must be a valid email address.',
        'min'      => 'The :field field must be at least :param characters in length.',
        'max'      => 'The :field field cannot exceed :param characters in length.',
        'numeric'  => 'The :field field must be numeric.',
        'in'       => 'The :field field must be one of: :param.',
    ];

    // 建構子，傳入資料和規則
    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    // 執行驗證
    public function validate(): bool
    {
        $this->errors = []; // 清空錯誤訊息
        $session = session();
        $session->set(
            '_my_old_input', [
            'post' => $_POST,
            'get' => $_GET
            ]
        );

        foreach ($this->rules as $field => $ruleSet) {
            // 將規則字串轉為陣列（例如 'required|email' => ['required', 'email']）
            $rules = is_string($ruleSet) ? explode('|', $ruleSet) : $ruleSet;

            foreach ($rules as $rule) {
                // 解析規則參數（例如 'min:5' => ['min', '5']）
                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                $ruleParam = $ruleParts[1] ?? null;

                // 執行驗證
                if (!$this->applyRule($field, $ruleName, $ruleParam)) {
                    $this->addError($field, $ruleName, $ruleParam);
                    break;
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

    // 應用單一驗證規則
    protected function applyRule(string $field, string $rule, ?string $param): bool
    {
        $value = $this->data[$field] ?? null;

        switch ($rule) {
        case 'required':
            return !empty($value);
        case 'email':
            return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
        case 'min':
            return strlen($value) >= (int)$param;
        case 'max':
            return strlen($value) <= (int)$param;
        case 'numeric':
            return is_numeric($value);
        case 'int':
            return $this->isValidMySQLId($value);
        case 'in': // 檢查值是否在指定選項中。 Ex: 'gender' => 'required|in:male,female,other',
            $options = explode(',', $param);
            return in_array($value, $options);
        default:
            // 支援自訂規則（可以擴展）
            if (method_exists($this, $rule)) {
                return $this->$rule($value, $param);
            }
            return true; // 未知規則，默認通過
        }
    }

    private function isValidMySQLId($number)
    {
        // 檢查是否為純數字字串且無小數點
        if (!preg_match('/^\d+$/', $number)) {
            return false;
        }

        // 轉為整數
        $number = (int)$number;

        // 檢查是否為非負數 (>= 0) 或正數 (> 0)
        return $number > 0; // 非負數
        // 如果需要正數，改用 return $number > 0;
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

    // 示例自訂規則（可根據需要擴展）
    protected function customRuleExample($value, $param): bool
    {
        // 在此處實現自訂規則邏輯
        return true;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
