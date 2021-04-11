<?php
namespace Unittest\Test;
use PHPUnit\Framework\TestCase;
include('../Testclass.php')
class Test extends TestCase
{
    public function testTrueAssetsToTrue()
    {
        $tcls = new Testclass();
        $tcls->
        $condition = true;
        $this->assertTrue($condition);
    }
}
?>