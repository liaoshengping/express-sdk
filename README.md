<h1 align="center"> express </h1>

<p align="center">免key，可扩展快递物流查询，第三方快递100，爱查快递，百度快递</p>

## 环境需求
* PHP >= 7.0s

## 安装

```shell
$ composer require liaosp/express
```

## 使用
```php
use \Liaosp\Express\Express
$obj = new Express()
```

## 爱查快递
```php
$obj->number('71291609210123'); //默认爱查快递
```
## 使用快递100
```php
$obj->setExpress('kuaidi100');
$obj->number('71291609210123'); 
```
## 查询快递100和爱查快递
```php
$obj->setExpress('kuaidi100');
$obj->setExpress('ickd');
$obj->number('71291609210123'); 
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
