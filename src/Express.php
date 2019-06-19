<?php


namespace Liaosp\Express;

use Liaosp\Express\Channel\Baidu;
use Liaosp\Express\Channel\BaseChannel;
use Liaosp\Express\Channel\Ickd;
use Liaosp\Express\Channel\Kuaidi100;
use Liaosp\Express\Exception\Exception;

class Express
{
    /**
     * 获取成功
     */
    const SUCCESS='获取成功';
    /**
     * 获取失败
     */
    const FAILURE='获取失败';
    /**
     * @var array 渠道
     */
    public $channel_class=[
        'baidu'=>Baidu::class,
        'ickd'=>Ickd::class,
        'kuaidi100'=>Kuaidi100::class,
    ];
    /**
     * @var array 要查询的快递
     */
    public $express_name=[];
    /**
     * 设置快递信息
     * @param $name
     */
    public function setExpress($name){
        array_push($this->express_name,$name);
    }

    /**
     * @param $number
     * @throws Exception
     */
    public function number($number){
        if(empty($number)){
            throw new  Exception('code arguments cannot empty.');
        }
        if(empty($this->express_name)){
            $this->setExpress('ickd');
        }
        $results = [];
        foreach ($this->express_name as $key=>$channel){
            try {
                $results[$channel] = [
                    'channel' => $channel,
                    'status' => self::SUCCESS,
                    'result' =>$this->buildClass($channel)->query($number),
                ];
            } catch (\Exception $exception) {
                $results[$channel] = [
                    'channel' => $channel,
                    'status' => self::FAILURE,
                    'exception' =>$exception->getMessage(),
                ];
            }
        }
        return $results;
    }

    /**
     * 添加新渠道
     * @param $name
     * @param $class
     * @return mixed
     */
    public function addChannel($name, $class){
       return $this->channel_class[$name]=$class;
    }

    /**
     * 创建对象
     * @param $channel
     * @throws Exception
     * @return BaseChannel
     */
    public function buildClass($channel){
        if(!array_key_exists($channel,$this->channel_class)){
            throw new Exception('渠道不存在');
        }
        if(!class_exists($this->channel_class[$channel])){
            throw new Exception($this->channel_class[$channel].'  类不存在');
        }
        return new $this->channel_class[$channel];
    }

}


//$obj = new Express();
//$obj->setExpress('kkk');
//$obj->setExpress('baidu');
//$obj->addChannel('kkk',Kuaidi100::class);
//$obj->addChannel('ali',Baidu::class);
//$res =$obj->number('kkkss');
//var_dump($res);
//var_dump($obj->channel_class);
