<?php

/**
 * 事件類別
 */

class Events
{
    public const PRIORITY_LOW    = 200;
    public const PRIORITY_NORMAL = 100;
    public const PRIORITY_HIGH   = 10;

    protected static $listeners = [];

    public static function on(string $eventName, callable $callback, int $priority = 100)
    {
        self::$listeners[$eventName][$priority][] = $callback;
    }

    public static function trigger(string $eventName)
    {
        if(!isset(self::$listeners[$eventName])) return;

        ksort(self::$listeners[$eventName]); // 依照 priority 排序

        foreach (self::$listeners[$eventName] as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                call_user_func($callback);
            }
        }
    }
}
