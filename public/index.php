<?php

// [ 应用入口文件 ]

// 定义应用目录
//define('APP_PATH', __DIR__ . '/../application/');
define('APP_PATH', '../app/');

// 定义扩转类库目录
define('EXTEND_PATH', APP_PATH . 'extend');

// 定义自动生成模块
//define('APP_AUTO_BUILD',true);

// 加载框架引导文件
require  '../framework/start.php';

// 模块自动生成
//$build = include APP_PATH . '/build.php';

//\think\Build::run($build);