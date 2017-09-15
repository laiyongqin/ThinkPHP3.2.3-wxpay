﻿#微信支付组件（服务商模式）
<h3>包含以下组件</h3>
<ul>
    <li>刷卡支付</li>
    <li>公众号支付（jsapi）</li>
    <li>扫码支付</li>
    <li>H5支付</li>
</ul>
<p>注：支付功能开通请参照微信支付相关文档，在测试以上功能时，请务必开通相关功能</p>
<h3>配置参数位置：ThinkPHP/Library/Vendor/weixin/WxPay.Config.php，请填写一下参数。</h3>
<pre>
<code>
    ThinkPHP/Library/Vendor/weixin/WxPay.Config.php
	const APPID = '';
	const MCHID = '';
	const SUBMCHID = '';
	const KEY = '';
	const APPSECRET = '';
</code>
</pre>