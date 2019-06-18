<?php


namespace Liaosp\Express\Channel;


use Liaosp\Express\HttpRequest;

abstract class BaseChannel
{
    use HttpRequest;
    /**
     * 请求地址
     * @var string
     */
    protected $url;
    /**
     * 资源返回
     * @var string
     */
     protected $response;
    /**
     * 确认请求
     * @param $number
     */
    abstract public function query($number);
}
