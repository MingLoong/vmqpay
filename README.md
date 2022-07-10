## How to use
1. 请确保你已经成功搭建[vmqphp](https://github.com/szvone/vmqphp)和[v2board](https://github.com/v2board/v2board)
2. 使用本仓库的文件路径替换云端同名的文件，注意不要弄错两个Index.php的路径
3. 配置vmqpay参数
    - 后台管理的系统设置
        - 同步回调：`https://pay.domain.com/public/examle/return.php`
        - 通讯密钥：`a7cc8678193ee9c70ae3d75fd04ae6a9`
    - return.php
        - 回调域名：`$notifyDomain = https://v2board.domain.com`
        - 回调路径：`$notifyPath = /api/v1/guest/payment/notify/VmqPay/ovR1wZIi`
        - 通讯密钥：`$key = a7cc8678193ee9c70ae3d75fd04ae6a9`
4. 配置v2board参数
    - 添加支付方式
        - 显示名称：`微信支付`
        - 接口文件：`VmqPay`
        - 支付后台：`https://pay.domain.com`
        - 通讯密钥：`a7cc8678193ee9c70ae3d75fd04ae6a9`
        - 混淆参数：`vone666`
        - 支付方式：`1`
    - 添加后自动生成
        - 通知地址：`https://v2board.domain.com/api/v1/guest/payment/notify/VmqPay/ovR1wZIi`
5. 以上参数仅作为示例参考，请修改成自己设定的值
## Thanks
[vmqphp](https://github.com/szvone/vmqphp)

[v2board](https://github.com/v2board/v2board)
## License
[MIT](https://github.com/zhyonchen/vmqpay/blob/main/LICENSE)
