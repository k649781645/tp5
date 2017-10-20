<?php
//配置文件
return [
    //调试模式
    'app_debug' => true,
    // 应用Trace
    'app_trace' => false,
    // 是否支持多模块
    'app_multi_module' => false,

    // 企业微信配置
    'wx' => [
        'CorpId'    => 'wxf8d1e01f1cbce6eb',
        'TxlSecret' => '8h8PyMOawNoCKjU6FWzwa3sv96HtsAQho4q5fBKssuc',
        'apps'       => [
            'AppDesc'        => 'Test',
            'AgentId'        => 1000004,
            'Secret'         => 'KR3iPFQPknve-d-Ysb_xiwQld4Yqry3UBk_Nr5v3rgY',
            'Token'          => '应用1回调模式的Token，在应用的回调模式里面设置',
            'EncodingAESKey' => '应用1回调模式的加密串，在应用的回调模式里面设置'
        ],
    ],

];