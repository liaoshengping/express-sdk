<?php


namespace Liaosp\Express\Channel;

use GuzzleHttp\Client;

class Baidu extends BaseChannel
{

    function __construct()
    {
        $this->url= 'http://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv/pae/channel/data/asyncqury?appid=4001&com=&nu=';
    }

    /**
     * 确认请求
     * @param $number
     */
    public function query($number)
    {
        $client = new Client();
        $res =$client->get($this->url.$number);
        $content =$res->getBody()->getContents();
        $this->response = $content;
        $this->toArray();
        $this->format();
        return $this->response;
    }

    /**
     *  转化为数组
     */
    public function toArray()
    {
      $this->response =  json_decode($this->response,true);
    }

    /**
     * 格式化
     * @return mixed
     */
    public function format()
    {
        // TODO: Implement format() method.
    }
}
