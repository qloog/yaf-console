## 简介

快速生成对应的module、controller、model、plugin。

## 依赖

 - yaf
 - composer
 - console文件

## 安装

` composer require "phpcasts/yaf-library:dev-master" -vvv `

## 配置

yaf配置开启 `yaf.use_namespace = true ` 和 `yaf.use_spl_autoload=1 `

## 创建Console文件

```shell
cd /path/to/app_root    //cd到项目根目录
mkdir bin
vim bin/console
```

加入以下内容：
```php
#!/usr/bin/env php
<?php

define('APP_ROOT', dirname(__DIR__));
define('APP_PATH', APP_ROOT . '/application');
require APP_ROOT . '/vendor/autoload.php';

use PHPCasts\Console\GenerateModule;
use PHPCasts\Console\GenerateController;
use PHPCasts\Console\GenerateModel;
use PHPCasts\Console\GeneratePlugin;
use PHPCasts\Console\Check;
use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new GenerateModule());
$application->add(new GenerateController());
$application->add(new GenerateModel());
$application->add(new GeneratePlugin());
$application->add(new Check());

$application->run();
```

## 使用

```shell
php bin/console  // 查看可用命令
php bin/console make:module Web	// 创建Web模块
php bin/console make:controller User	// 创建控制器
php bin/console make:controller Web/User	// 在Web模块下创建控制器
php bin/console make:model User // 创建模型
php bin/console make:plugin Test	// 创建插件
```