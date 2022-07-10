<?php

namespace App\Payments;

class VmqPay {
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function form()
    {
        return [
            'url' => [
                'label' => '支付后台',
                'description' => '末尾不要/，如https://pay.domain.com',
                'type' => 'input'
            ],
            'key' => [
                'label' => '通讯密钥',
                'description' => '填支付后台设定的值，如a7cc8678193ee9c70ae3d75fd04ae6a9',
                'type' => 'input'
            ],
            'param' => [
                'label' => '混淆参数',
                'description' => '非空任意值，如vone666',
                'type' => 'input'
            ],
            'type' => [
                'label' => '支付方式',
                'description' => '填1使用WeChatPay，填2使用Alipay',
                'type' => 'input'
            ]
        ];
    }

    public function pay($order)
    {
        try{
            $params = [
                'payId' => $order['trade_no'],
                'param' => $this->config['param'],
                'type' => $this->config['type'],
                'price' => $order['total_amount'] / 100
            ];
            //校验签名计算方式 = md5(payId + param + type + price + 通讯密钥)
            $str = '';
            foreach ($params as $key => $value) {
                $str=$str.$value;
            }
            $params['sign'] = md5($str.$this->config['key']);
            $params['isHtml'] = 1; //传入1则自动跳转到支付页面，填0则返回创建结果的json数据
            return [
                'type' => 1,  // 0:qrcode 1:url
                'data' => $this->config['url'] . '/createOrder?' . http_build_query($params)
            ];
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function notify($params)
    {
        //校验回调签名计算方式=md5(payId + param + 通讯密钥)
        try {
            $sign = md5($params['payId'] . $this->config['param'] . $this->config['key']);
            if($sign != $params['sign']){
                return false;
            }
            return [
                'trade_no' => $params['payId'],
                'callback_no' => $params['orderId']
            ];
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
            return false;
        }
    }
}