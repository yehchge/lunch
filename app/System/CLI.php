<?php

namespace App\System;

class CLI
{
    protected static $foreground_colors = [
        'black'        => '0;30',
        'dark_gray'    => '1;30',
        'blue'         => '0;34',
        'dark_blue'    => '0;34',
        'light_blue'   => '1;34',
        'green'        => '0;32',
        'light_green'  => '1;32',
        'cyan'         => '0;36',
        'light_cyan'   => '1;36',
        'red'          => '0;31',
        'light_red'    => '1;31',
        'purple'       => '0;35',
        'light_purple' => '1;35',
        'yellow'       => '0;33',
        'light_yellow' => '1;33',
        'light_gray'   => '0;37',
        'white'        => '1;37',
    ];

    public static function write(string $message, string $foreground = '')
    {
        $newText = '';

        if($foreground) {
            $newText = self::color($message, $foreground);
        }else{
            $newText = $message;
        }

        echo $newText.PHP_EOL;
    }

    public static function color(string $text, string $foreground, $background = null, $format = null)
    {
        return self::getColoredText($text, $foreground, $background, $format);
    }

    private static function getColoredText(string $text, string $foreground, ?string $background, ?string $format): string
    {
        $string = "\033[" . static::$foreground_colors[$foreground] . 'm';

        if ((string) $background !== '') {
            $string .= "\033[" . static::$background_colors[$background] . 'm';
        }

        if ($format === 'underline') {
            $string .= "\033[4m";
        }

        return $string . $text . "\033[0m";
    }

    public static function newLine()
    {
        echo PHP_EOL;
    }
}
