<?php
//配置文件
return [
    //调试模式
    'app_debug' => true,
    // 应用Trace
    'app_trace' => false,
    // 是否支持多模块
    'app_multi_module' => false,

    // 企业微信配置（测试）
    'wx' => [
        'CorpId'    => 'ww76be1f123c5c4a8a',
        'TxlSecret' => '5FjqFSjduVIBx0kYPLoKDuiiD3q__hKGTYqLKr8p7-c',
        'apps'       => [
            [
                'AppDesc'        => 'Test',
                'AgentId'        => 1000002,
                'Secret'         => 'pDx4OehhZJivTvwqjc1iH_l14lFaHzTpwVdzarH7KKA',
                'Token'          => '应用1回调模式的Token，在应用的回调模式里面设置',
                'EncodingAESKey' => '应用1回调模式的加密串，在应用的回调模式里面设置'
            ],
        ],
    ],

    // 企业微信配置（公司）
    // 'wx' => [
    //     'CorpId'    => 'wxf8d1e01f1cbce6eb',
    //     'TxlSecret' => '8h8PyMOawNoCKjU6FWzwa3sv96HtsAQho4q5fBKssuc',
    //     'apps'       => [
    //         [
    //             'AppDesc'        => 'Test',
    //             'AgentId'        => 1000002,
    //             'Secret'         => 'pDx4OehhZJivTvwqjc1iH_l14lFaHzTpwVdzarH7KKA',
    //             'Token'          => '应用1回调模式的Token，在应用的回调模式里面设置',
    //             'EncodingAESKey' => '应用1回调模式的加密串，在应用的回调模式里面设置'
    //         ],
    //     ],
    // ],

];