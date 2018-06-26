<?php
$config = array (
		//签名方式,默认为RSA2(RSA2048)
		'sign_type' => "RSA2",

		//支付宝公钥
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjcRSOwYrwmk6tXQhjp2CgWTKeNK+PEaUslrfqg/m0ijeVhp/fRZhDcd0nA2UiflBY5A98tUcxb+99yLBOOoQAqJQ/9qsZBYEDbDxL6G0G0eMbLmD7gNS6w2b9LfB0+TmsK5XJSEbidejPsg/KdAtg5zpRONiDowybyxn8shgppx9ZIYZonzIo5V4Ynqjv7e4lawF5QRg4wd/mPrTynrQAn62oz5SQJnpY89R6+GuGj5PraF5wVuK2xjMmL4M0ipDA1tGO6qUX4Pi972NcViVh3ijLExYRmMpF3gsG/QGUuoE2/8MwJjBl2xUQOgb0o+kOVLmtPMwWkZmjZzt37RxUwIDAQAB",

		//商户私钥
		'merchant_private_key' => "MIIEogIBAAKCAQEAlnu4H0LSg9NTk/2+gralF0LQltX2ntDskguFvhbfZu6bHYCvoPpTDSSM7dDzQNBpc0McV8pzaXSlGkQ2UEo2Q+nFW0zTFVi54DkuoGFwbsLgtAuOAcH6FYKbZnKUqFpLPamnDM6dunMINpVCfhYvqh4+9z7DOPp3KzzFuUzVmqHVTOqih838WC8VXre2xjVNaHXsxrsgPoq6BlcoETw2K7BpPUmrOh0jTnvULsYQ22qqrzASrmBg3XlO5fkiOFrM6Pi2AblDTj7iCze88RJDV/2ph6Q+iGofHMCmPz8lhD+sTNi+9yv0nzFq/0DVzDeGv3wmfWFBOl2R7F+DIpF6XQIDAQABAoIBABuXM3sH1XE2HezUaUmuEzbgmT4OnNkhlT5xvmPL7coBlY8jORBa1T9jpDM2TGNl0u+/LkMqa166dEsMlqjB8pEhG35R56HSUsI5ucLOGr80G97m/3JzDldDSxrNh1QWuhTkNiyy9VhqHudjFn3ns3WNdh3+8+xOf+r9iYMgA0oGegvoPJLNrKy4DhWu/G1rv713J4fNLFxh7FHXjK6YO2Aw6dgVQvff/mFykBjTvIRZfRcWOGxlBCUf3HaXp7cGDOur59SF/TlAmFwD0KUI0NiAZcvCOEnbsDQJD25fpQmsmp+9k5gdmoHOwtaAhv49J2FdL+xdwyGtUX2x1sr9GEECgYEAxQHrs1sEgNe6NMZAAvueCt4sO5dB/RBBJGeN6ly0GrIU4j3gIyEz8TVlaX0WVSHlp1sF9FAms6qR6wQKpBDzZkSHYspUWYwIn7xV7sn9I7PAGnoxWTHXlPLHjix9KHq/uj9pVo5ELI3lfu+zQcmG3OYATWIUaFBInGTrU1cth38CgYEAw4tfkCzo2rn23OTjCL8q68K6E2F7b1WGapbdCx/NxmqwG23gQ00AlUNWINJUQ5AlMgRUDqHGG21zHd1plgsomF+87PGPfFpKVia9ZwTLBxH6Gd9CZ6MveHGzexxScshbYUHBfRUGEFivBNUw6Zjt5uX/vaH/Izzn5UXvJfoCDCMCgYAa8XdN0T3dbSOPQinQ/p6Pt/DuuXIR7R4rn2n+Sm1rVT2b74Bu7YSQEZBsC+p4/CjPaZh34FpaqhJIxQW7iIHxU5/8d9VvZcJsLjLGdKOFNXkpZdrH6xQjz8xQ+m6nkZoVG8UJTG2wdjuTz66BadFi9qXF74sA9THpCbhRbpPQewKBgGvLBbf1ebsxLktghWLJ9wAVzPtoDmI2NC3H0jwSoR2SrFfCfxC6furJPs5DA55m9IoY5rlWJl3yPLYm2tCSgCNXC09WbfFv2HCbVGdYtg7EsyjV8MYup7lufDEOUMjjd7QqSl4IW9pg+MHiP99VpTdWbF790SZ8qZyyq300zzIfAoGACcu77bRUO5tc8T1INqp7zLr+uMR4k1hhhljayOTPP9S5juLE+a1BgkO6fGme0LcTswUtt/fqfb3i/jTJDvMqc2jrO98HnpLbp6UL07t/tnO0/kKjXrUxv2uMuI3zWS34b0YssV7OTTsPR2NCZXqrd//bWJSA48ARp+ote2Gta6A=",

		//编码格式
		'charset' => "UTF-8",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//应用ID
		'app_id' => "2017061607504664",

		//异步通知地址,只有扫码支付预下单可用
		'notify_url' => "",

		//最大查询重试次数
		'MaxQueryRetry' => "10",

		//查询间隔
		'QueryDuration' => "3"
);