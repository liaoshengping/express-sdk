<?php


namespace Liaosp\Express\Channel;

use Curl\Curl;
use Express\BDExpress;
use GuzzleHttp\Client;

class Baidu extends BaseChannel
{

    protected $url;

    /**
     * @var Curl
     */
    protected $curl;

    function __construct()
    {
//        $this->url= 'http://sp0.baidu.com/9_Q4sjW91Qh3otqbppnN2DJv/pae/channel/data/asyncqury?appid=4001&com=&nu=';
        $this->url= 'https://express.baidu.com/express/api/express';

        $this->curl = new Curl();

        $this->curl->setHeaders([
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:67.0) Gecko/20100101 Firefox/67.0',
        ]);
    }

    /**
     * 确认请求
     * @param $number
     */
    public function query($number)
    {
        $this->curl->setDefaultJsonDecoder(1);

        $tokenV2 = $this->getTokenV2();

        $this->curl->get($this->url, [
            'tokenV2' => $tokenV2,
            'appid' => 4001,
            'nu'    => $number,
        ]);

        $response = $this->curl->response;

        $info = $response['data']['info']??[];

        if (!empty($info) && ($info['status']??0) == 1) {

            $info['companyName'] = $this->companyList($info['com']??'');

            return $info;
        }

        return [];

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
















    /**
     * search
     * @param $number
     * @return array
     */
    private function search($number)
    {

        $this->curl->setDefaultJsonDecoder(1);

        $tokenV2 = $this->getTokenV2();

        $this->curl->get($this->url, [
            'tokenV2' => $tokenV2,
            'appid' => 4001,
            'nu'    => $number,
        ]);

        $response = $this->curl->response;

        $info = $response['data']['info']??[];

        if (!empty($info) && ($info['status']??0) == 1) {

            $info['companyName'] = $this->companyList($info['com']??'');

            return $info;
        }

        return [];
    }

    /**
     * getTokenV2
     * @return string
     */
    protected function getTokenV2()
    {
        $curl = $this->curl;
        $tokenUrl = 'https://www.baidu.com/baidu?isource=infinity&iname=baidu&itype=web&tn=02003390_42_hao_pg&ie=utf-8&wd=%E5%BF%AB%E9%80%92';
        $curl->get($tokenUrl);
        $pattern = '/tokenV2=(.*?)"/i';
        preg_match($pattern, $curl->response, $match);
        if(!empty($match[1])){
            $curl->setCookies($curl->getResponseCookies());
            return $match[1];
        }
        return null;
    }

    /**
     * companyList
     * @param $key
     * @return string
     */
    private function companyList($key)
    {
        $companyList =  [
            'shunfeng' => '顺丰',
            'yuantong' => '圆通速递',
            'shentong' => '申通',
            'yunda' => '韵达快运',
            'ems' => 'ems快递',
            'tiantian' => '天天快递',
            'zhaijisong' => '宅急送',
            'quanfengkuaidi' => '全峰快递',
            'zhongtong' => '中通速递',
            'rufengda' => '如风达',
            'debangwuliu' => '德邦物流',
            'huitongkuaidi' => '汇通快运',
            'aae' => 'aae全球专递',
            'anjie' => '安捷快递',
            'anxindakuaixi' => '安信达快递',
            'biaojikuaidi' => '彪记快递',
            'bht' => 'bht',
            'baifudongfang' => '百福东方国际物流',
            'coe' => '中国东方（COE）',
            'changyuwuliu' => '长宇物流',
            'datianwuliu' => '大田物流',
            'dhl' => 'dhl',
            'dpex' => 'dpex',
            'dsukuaidi' => 'd速快递',
            'disifang' => '递四方',
            'fedex' => 'fedex（国外）',
            'feikangda' => '飞康达物流',
            'fenghuangkuaidi' => '凤凰快递',
            'feikuaida' => '飞快达',
            'guotongkuaidi' => '国通快递',
            'ganzhongnengda' => '港中能达物流',
            'guangdongyouzhengwuliu' => '广东邮政物流',
            'gongsuda' => '共速达',
            'hengluwuliu' => '恒路物流',
            'huaxialongwuliu' => '华夏龙物流',
            'haihongwangsong' => '海红',
            'haiwaihuanqiu' => '海外环球',
            'jiayiwuliu' => '佳怡物流',
            'jinguangsudikuaijian' => '京广速递',
            'jixianda' => '急先达',
            'jjwl' => '佳吉物流',
            'jymwl' => '加运美物流',
            'jindawuliu' => '金大物流',
            'jialidatong' => '嘉里大通',
            'jykd' => '晋越快递',
            'kuaijiesudi' => '快捷速递',
            'lianb' => '联邦快递（国内）',
            'lianhaowuliu' => '联昊通物流',
            'longbanwuliu' => '龙邦物流',
            'lijisong' => '立即送',
            'lejiedi' => '乐捷递',
            'minghangkuaidi' => '民航快递',
            'meiguokuaidi' => '美国快递',
            'menduimen' => '门对门',
            'ocs' => 'OCS',
            'peisihuoyunkuaidi' => '配思货运',
            'quanchenkuaidi' => '全晨快递',
            'quanjitong' => '全际通物流',
            'quanritongkuaidi' => '全日通快递',
            'quanyikuaidi' => '全一快递',
            'santaisudi' => '三态速递',
            'shenghuiwuliu' => '盛辉物流',
            'sue' => '速尔物流',
            'shengfeng' => '盛丰物流',
            'saiaodi' => '赛澳递',
            'tiandihuayu' => '天地华宇',
            'tnt' => 'tnt',
            'ups' => 'ups',
            'wanjiawuliu' => '万家物流',
            'wenjiesudi' => '文捷航空速递',
            'wuyuan' => '伍圆',
            'wxwl' => '万象物流',
            'xinbangwuliu' => '新邦物流',
            'xinfengwuliu' => '信丰物流',
            'yafengsudi' => '亚风速递',
            'yibangwuliu' => '一邦速递',
            'youshuwuliu' => '优速物流',
            'youzhengguonei' => '邮政包裹挂号信',
            'youzhengguoji' => '邮政国际包裹挂号信',
            'yuanchengwuliu' => '远成物流',
            'yuanweifeng' => '源伟丰快递',
            'yuanzhijiecheng' => '元智捷诚快递',
            'yuntongkuaidi' => '运通快递',
            'yuefengwuliu' => '越丰物流',
            'yad' => '源安达',
            'yinjiesudi' => '银捷速递',
            'zhongtiekuaiyun' => '中铁快运',
            'zhongyouwuliu' => '中邮物流',
            'zhongxinda' => '忠信达',
            'zhimakaimen' => '芝麻开门'
        ];

        return $companyList[$key]??'';
    }









}
