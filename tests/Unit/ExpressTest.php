<?php

use PHPUnit\Framework\TestCase;
use \Liaosp\Express\Express;

class ExpressTest extends TestCase
{
    public function testGetExpress(){

        $obj = new Express();
        $res =$obj->number('75429500729712'); //默认百度快递，其他快递貌似没啥用了
        $this->assertTrue(!empty($res['baidu']['result']));

    }
}
