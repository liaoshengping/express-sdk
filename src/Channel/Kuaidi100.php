<?php


namespace Liaosp\Express\Channel;


use Liaosp\Express\Exception\Exception;
use Wythe\Logistics\Exceptions\HttpException;

class Kuaidi100 extends BaseChannel
{
    public $res;
    private $autoGetCompanyNameByUrl = 'http://m.kuaidi100.com/autonumber/autoComNum';
    /**
     * 构造函数
     *
     * Kuaidi100Channel constructor.
     */
    public function __construct()
    {
        $this->url = 'http://m.kuaidi100.com/query';
    }

    /**
     * @param $number
     * @return string
     * @throws Exception
     */
    public function query($number)
    {
        try {
            $companyCodes = $this->getCompanyCode($number);
            $urlParams = $urls = [];
            foreach ($companyCodes as $companyCode) {
                $urlParams[] = ['type' => $companyCode, 'postid' => $number];
                $urls[] = $this->url;
            }
            $response = $this->getByQueue($urls, $urlParams, $this->option);
            $this->res = $response;
            $this->toArray();
            $this->format();
            return $this->response;
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
    /**
     * 根据运单号获取物流公司名称
     *
     * @param string $code
     * @return array
     * @throws Exception
     */
    protected function getCompanyCode(string $code): array
    {
        $params = ['resultv2' => 1, 'text' => $code];
        $response = $this->get($this->autoGetCompanyNameByUrl, $params);
        $getCompanyInfo = \json_decode($response, true);
        if (!isset($getCompanyInfo['auto'])) {
            throw new Exception('no company code');
        }
        return array_column($getCompanyInfo['auto'], 'comCode');
    }

    /**
     * @param array|string $response
     */
    public function toArray()
    {
        $response = $this->res ;
        foreach ($response as $item) {
            $data = \json_decode($item['result'], true);
            $this->response[] = [
                'status'  => $data['status'],
                'message' => $data['message'],
                'error_code' => $data['state'] ?? '',
                'data' => $data['data'] ?? '',
                'logistics_company' => $data['com'] ?? '',
                'logistics_bill_no' => $data['nu'] ?? '',
            ];
        }
    }

    /**
     * 格式化
     * @return mixed
     */
    public function format()
    {
        $formatData = [];
        foreach ($this->response as &$item) {
            if (!empty($item['data']) && is_array($item['data'])) {
                foreach ($item['data'] as $datum) {
                    $formatData[] = ['time' => $datum['time'], 'description' => $datum['context']];
                }
                $item['data'] = $formatData;
            }
        }
        unset($item);
    }
}
