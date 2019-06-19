<?php


namespace Liaosp\Express\Channel;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Liaosp\Express\Exception\Exception;
use Liaosp\Express\Express;

class Ickd extends BaseChannel
{
    public $option = ['header' => ['referer: https://biz.trace.ickd.cn']];

    function __construct()
    {
        $this->url = 'https://biz.trace.ickd.cn/auto/';
    }
    /**
     * 生成随机码
     *
     * @return string
     */
    private function randCode(): string
    {
        $letterOfAlphabet = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $index = mt_rand(0, strlen($letterOfAlphabet) - 1);
            $code .= $letterOfAlphabet[$index];
        }
        return $code;
    }

    /**
     * @param $number
     * @return string
     * @throws Exception
     */
    public function query($number)
    {
        try{
            $urlParams = [
                'mailNo' => $number,
                'spellName' => '',
                'exp-textName' => '',
                'tk' => $this->randCode(),
                'tm' => time() - 1,
                'callback' => '_jqjsp',
                '_'.time()
            ];
            $response = $this->get($this->url.$number, $urlParams, $this->option);
            $this->response = $response;
            $this->toArray();
            $this->format();
            return $this->response;
        }catch (ClientException $exception){
            throw new Exception(base64_encode($exception->getMessage()));
        }
    }

    public function toArray()
    {
        $pattern = '/(\_jqjsp\()({.*})\)/i';
        if (preg_match($pattern, $this->response, $match)) {
            $response = \json_decode($match[2], true);
            $this->response = [
                'status'  => $response['status'],
                'message' => $response['message'],
                'error_code' => $response['errCode'] ?? '',
                'data' => $response['data'] ?? '',
                'logistics_company' => $response['expTextName'] ?? '',
                'logistics_bill_no' => $response['mailNo']
            ];
        } else {
            $this->response = [
                'status' => -1,
                'message' => '查询不到数据',
                'error_code' => -1,
                'data' => '',
                'logistics_company' => ''
            ];
        }
    }

    /**
     * 格式化
     * @return mixed
     */
    public function format()
    {
        if (!empty($this->response['data']) && is_array($this->response['data'])) {
            $formatData = [];
            foreach ($this->response['data'] as $datum) {
                $formatData[] = ['time' => $datum['time'], 'description' => $datum['context']];
            }
            $this->response['data'] = $formatData;
        }
    }
}
