<?php

use PHPUnit\Framework\TestCase;



/**
 * @covers ViewEngine
 */
class ViewEngineTest extends TestCase
{
    /**
     * @covers ::esc
     */
    public function testEsc()
    {
        $string = '<script>alert("xss");</script>';
        $expected = '&lt;script&gt;alert(&quot;xss&quot;);&lt;/script&gt;';
        $this->assertEquals($expected, esc($string));
    }
}
