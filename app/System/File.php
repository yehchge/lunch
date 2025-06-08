<?php

namespace App\System;


class File extends \SplFileInfo
{
    public function getSizeByUnit(string $unit = 'b')
    {
        $bytes = $this->getSize();

        switch(strtolower($unit)){
            case 'kb':
                return number_format($bytes / 1024, 2);
                break;
            case 'mb':
                return number_format($bytes / 1048576, 2);
                break;
            default:
                return $bytes;
                break;
        }
    }

    public function guessExtension()
    {
        return $this->getExtension();
    }

    private function formatSizeUnits($bytes)
    {
            if ($bytes >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }

            return $bytes;
    }

}
