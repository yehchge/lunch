<?php

namespace App\System;

class DebugConsole
{
    private float $startTime;
    public bool $strictDebug = true;

    public array $warnings = [
        'test1' => 'warnings'
    ];

    public array $fileList = [
        'test2' => 'filelist'
    ];

    public array $dynamicBlocks = [
        'test3' => 'dynamic'
    ];

    public array $parsedVars = [
        'test4' => 'parsevars'
    ];

    public function __construct()
    {
        $this->startTime = microtime(true);
    }

    public function showDebugInfo(?int $type = null): void
    {
        $elapsedTime = round(microtime(true) - $this->startTime, 4);

        if ($type === 1) {
            $this->openConsole("Debugging info: generated in {$elapsedTime} seconds");

            if ($this->strictDebug) {
                $this->writeArray($this->warnings, 'Warnings');
            }

            $this->writeArray($this->fileList, 'Templates');
            $this->writeArray($this->dynamicBlocks, 'Dynamic Blocks');
            $this->writeArray($this->parsedVars, 'Parsed Variables');

            $this->closeConsole();
        }

        if ($type === 2 && $this->strictDebug && !empty($this->warnings)) {
            $this->openConsole("Warnings only (generated in {$elapsedTime} seconds)");
            $this->writeArray($this->warnings, 'Warnings');
            $this->closeConsole();
        }
    }

    private function openConsole(string $title): void
    {
        echo <<<HTML
<script>
    const _debug_console = window.open("", "console", "width=600,height=500,resizable,scrollbars=yes,top=0,left=130");
    _debug_console.document.write(`<html><head><title>Debug Console</title></head><body style="font-family:Tahoma;">`);
    _debug_console.document.write(`<h3>{$title}</h3>`);
</script>
HTML;
    }

    private function closeConsole(): void
    {
        echo <<<HTML
<script>
    _debug_console.document.write("</body></html>");
    _debug_console.document.close();
</script>
HTML;
    }

    private function writeArray(array $data, string $caption): void
    {
        if (empty($data)) { return;
        }

        $rows = '';
        $colors = ['#EEFFEE', '#EFEFEF'];
        $i = 0;

        foreach ($data as $key => $val) {
            $color = $colors[$i % 2];
            $safeVal = htmlspecialchars($val, ENT_QUOTES);
            $rows .= "<tr bgcolor=\"{$color}\"><td>{$key}</td><td><pre>{$safeVal}</pre></td></tr>\n";
            $i++;
        }

        $tableHtml = <<<HTML
<script>
    _debug_console.document.write(`
        <div style="margin-bottom: 10px;">
            <strong style="color:#0000FF;">{$caption}</strong>
            <table border="0" width="100%" cellspacing="1" cellpadding="2" style="border:1px solid #ccc;">
                <tr bgcolor="#CCCCCC">
                    <th width="175">Key</th><th>Value</th>
                </tr>
                {$rows}
            </table>
        </div>
    `);
</script>
HTML;

        echo $tableHtml;
    }
}
