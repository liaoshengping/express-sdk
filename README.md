<h1 align="center"> 免费快递SDK </h1>

[![Latest Stable Version](https://poser.pugx.org/liaosp/express/v/stable)](https://packagist.org/packages/liaosp/express)
[![Total Downloads](https://poser.pugx.org/liaosp/express/downloads)](https://packagist.org/packages/liaosp/express)
[![Daily Downloads](https://poser.pugx.org/liaosp/express/d/daily)](https://packagist.org/packages/liaosp/express)
[![License](https://poser.pugx.org/liaosp/express/license)](https://packagist.org/packages/liaosp/express)
[![StyleCI](https://styleci.io/repos/53163405/shield)](https://styleci.io/repos/53163405/)
[![Build Status](https://travis-ci.org/liaosp/express.svg?branch=master)](https://travis-ci.org/liaosp/express)
[![PHPUnit Status](https://github.com/liaosp/express/workflows/PHPUnit/badge.svg?branch=master)](https://github.com/liaosp/express/actions?query=branch%3Amaster)


<p align="center">免key，可扩展快递物流查询，第三方快递100，爱查快递，百度快递</p>

## 环境需求
* PHP >= 7.0

## 安装



```shell
$ composer require liaosp/express
```

## 使用
```php
use \Liaosp\Express\Express
$obj = new Express()
```

## 百度快递（默认）
```php
$obj->number('75355662900611'); //默认百度快递，其他快递貌似没啥用了
```



## 扩展

如果这些快递不满足，或者由于不稳定，在不改变原来代码，可以自行添加快递接口查询

添加的接口可继承 BaseChannel 抽象类

比如你添加了一个 快递网的渠道   /yournamespace/KuaidiWang
```php
$obj->addChannel('kuaidiwang',/yournamespace/KuaidiWang::class);
$obj->setExpress('kuaidiwang');
$obj->number('71291609210123'); 
```


## 参考
* [一个简单的查询物流信息的扩展包分享](https://learnku.com/laravel/t/22055)

## License

MIT
