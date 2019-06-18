<?php


namespace Liaosp\Express\Channel;


class Baidu extends BaseChannel
{

    function __construct()
    {
        $this->url= 'https://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv/pae/channel/data/asyncqury?cb=jQuery110204759692032715892_1499865778178&appid=4001&com=&nu=';
    }

    /**
     * 确认请求
     * @param $number
     */
    public function query($number)
    {

    }
}
