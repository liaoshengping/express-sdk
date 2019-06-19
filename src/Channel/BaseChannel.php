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

     protected $option=[];
    /**
     * 确认请求
     * @param $number
     */
    abstract public function query($number);

    /**
     * 转化数组
     * @return mixed
     */
    abstract public function toArray();

    /**
     * 格式化
     * @return mixed
     */
    abstract public function format();
}
