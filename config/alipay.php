<?php

return [
    //应用ID,您的APPID。
    'app_id' => "2016092500594759",

    //商户私钥
    'merchant_private_key' => "MIIEpAIBAAKCAQEAyCRmqVHcMAjwIoz1t21/3vgIlLaMcJm2JrsBTyIeJLT5H43y
YWmlFHdBQp7zefrfUQE4O6cYGjid0mfrt1DmP7XQ75nHIoNHKZ6cLoJ/FL2O2/lr
q5hLF8vnDlBLDonEVdaQJWmO2PrUKciQUFHy/mG27fxCK1sta3/JvD1D86tz7XyN
JqdBvhqQe2vKIftL6TAjekFpZhgsY7bm7nBYKUbXEzwHnfJLdqSwhlCmNAFEl5S4
nEO0KaUzaK0O+8i8fw3SBGBMld9aUZiUFdqtS4L0h5P+rIBR4x7qMO9+2TCXYNWW
9fqoV9o+XuZH0OkTOm+EjYJErgzzouZnImJ6uQIDAQABAoIBAQDGM/ZPHDhYgaF+
NeZo/tGxeCTXUWkHYdIXzP5g5cLAS1CjRSmR+tN2zxsb5NnuJNnfGLwdpz6hSQxS
gIPZCQ7cbSw6/ClPLn7c4qx9CtLbMVY21m0ghDNpn450iGOsRBbhgxlBU6YZj11o
+6yfPmjMLuzABh9pXGRAn06jUnDm71XXl58/gH5vxzQAwGY63GWy23Cb9RQBr2Pk
T0KafEQl1ENvY5/2BuXuVgOaXexMlEF9PydifbNO4NrXzxf19ljKp53u4Lvm60EK
VmOWsVcWOrN1L717BJR/r+KQsFErbxzE0vYQwuvPKoZaE9P3tc9ylymbT33OyBWa
eGVCmQFhAoGBAOlX7cE9vnOYklXc2+VyRXxIK3HDbMdD3TcedV53Rsv3SRYDPT+h
HBdCDEeZXvFq1ZMWOldr/MjiMWXQ2vDq4Y5Ifbk8UTUPxBkFOrhXLKTnDATTQ4VN
qhPxNt4d3Z4Kikp8kNzU7wMdfLmT63nLsplDsqBUYCyi3qvDB4ECNgg1AoGBANuT
NYP1mHtICgxYAL8xmNtc0qpZMQsHPrsJVfw0DHeKvybCMw4Y0KJ0ZntWKMBxih1G
wJu7nu1wOJtEheOC1QZ/M5UTYvp+j2kBHAzXL8v7SKlqWhqNQSMpTt53i9T5mGA0
KNo0w333CnONrtHLBJM45B0prLY4pPt2EuMlziD1AoGAXWb142kMqAbFZJswZiqU
h8f3o+T+0NBoZxzJDFQgQZqtZaNMTAD4VpL4iVxp9aa28NZv6fhuyhZIgaHVUaQj
PynjMVdkhiHWc9F1DL7QPv3BANlz6JMK5kqilMxNnmpHqsMr1UliltOhzkLYeftA
dTr08Fp12Mgk64n4ofo5mJUCgYA1M3LI+U2ruSWuHfh4WsUFiXUFjzzBxkydtsJd
rCLFKBnugykppjuO0RMvmQ2gqyHivAzY7tmv//vHKxAhssZ4n4NZAGx/8wA+WeV4
+v56tvTBD6KrQkRhB5YzctWvkZYo4Rpw3E3tjFi87LxJ2p3OKf+jTUCqmgjnYJFs
9fD+rQKBgQC4HqgVt3kaHSoHK27jlS5kxNfvGDcKXNrku9NM6LSKggUF+Oy4bxVI
CeHjV24AGe2iaTiyiebzMNELj01TB5M+6VE69XvmwL/bBr3iguhUeyHWHD7QYDcL
1HqpdUP0fTq1GUzc2Y/qblRRftCcYo5jq0lkXZ3QAsjMKX1Idk6iEQ==",

    //异步通知地址
    'notify_url' => "http://api.zhbcto.com/notify_url",

    //同步跳转
    'return_url' => "http://api.zhbcto.com/return_url",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyCRmqVHcMAjwIoz1t21/
        3vgIlLaMcJm2JrsBTyIeJLT5H43yYWmlFHdBQp7zefrfUQE4O6cYGjid0mfrt1Dm
P7XQ75nHIoNHKZ6cLoJ/FL2O2/lrq5hLF8vnDlBLDonEVdaQJWmO2PrUKciQUFHy
/mG27fxCK1sta3/JvD1D86tz7XyNJqdBvhqQe2vKIftL6TAjekFpZhgsY7bm7nBY
KUbXEzwHnfJLdqSwhlCmNAFEl5S4nEO0KaUzaK0O+8i8fw3SBGBMld9aUZiUFdqt
S4L0h5P+rIBR4x7qMO9+2TCXYNWW9fqoV9o+XuZH0OkTOm+EjYJErgzzouZnImJ6
uQIDAQAB",
];