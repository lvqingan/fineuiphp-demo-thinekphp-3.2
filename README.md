# ThinkPHP 3.2

@(FineUIPHP)

[TOC]

假设文档路径为 `/var/www`，解压缩 `ThinkPHP` 代码包至该目录下，同时将`FineUIPHP`的代码也解压缩到该目录下

## 1 入口文件

修改`index.php`在`require './ThinkPHP/ThinkPHP.php';`之前添加代码

```php
// 定义应用目录
define('APP_PATH', './Application/');

include_once 'fineui-lib/autoload.php';

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
```

## 2 配置

### 2.1 模板改为 phtml

> `FineUIPHP` 需要在模板中使用原生的 PHP 代码，而不是 TP 的模板标签，所以需要将模板文件的后缀改为 `phtml`

修改Application/Common/Conf/config.php，增加配置项，将模板改为PHP

```php
<?php

return array(
    //'配置项'=>'配置值'
    'TMPL_TEMPLATE_SUFFIX' => '.phtml',
);
```

### 2.2 初级化 TP 的行为

增加 `Application/Common/Conf/tags.php`文件

```php
<?php

return array(
    'app_init'    => array('Common\\Behaviors\\AppInitBehavior'),
    'view_filter' => array('Common\\Behaviors\\ViewFilterBehavior'),
);
```
`AppInitBehavior` 用来初始化 `FineUIPHP` 的配置
```php
<?php

namespace Common\Behaviors;

class AppInitBehavior extends \Think\Behavior
{
    public function run(&$param)
    {
        // 初始化配置信息
        \FineUIPHP\Config\GlobalConfig::loadConfig(array(
            'Theme'           => 'Default',  // 默认主题
            'ResourceHandler' => '?m=Resource&c=Handler'  // 资源文件获取入口
        ));
    }
}
```
> 常用配置内容，参见附录1

`ViewFilterBehavior` 用来解析、转换网页输出内容
```php
<?php

namespace Common\Behaviors;

class ViewFilterBehavior extends \Think\Behavior
{
    public function run(&$content)
    {
        \FineUIPHP\ResourceManager\ResourceManager::finish($content);
    }
}
```

## 3 静态资源入口文件

创建 `Application\Resource\Handler\Controller\HandlerController.class.php` 文件

> 文件对应到 `AppInitBehavior` 中设置的 `?m=Resource&c=Handler`，也就是说，如果不想使用这种地址，您也可以自定其他的地址入口

```php
<?php

namespace Resource\Controller;

use Think\Controller;

class HandlerController extends Controller
{
    public function index()
    {
        $handler = new \FineUIPHP\ResourceManager\ResourceHandler();

        $handler->ProcessRequest();
    }
}
```

## 4 演示例子

修改 `Application\Home\Controller\IndexController.class.php`

```php
<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->display('index');
    }
}
```
增加模板 `Application\Home\View\Index\index.phtml`
```php
<html>
<head>
    <title>ThinkPHP 3.2 使用教程</title>
</head>
<body style="padding: 20px;">
<?php
echo \FineUIPHP\FineUIControls::textBox()->text('默认文字');
echo '<hr/>';
echo \FineUIPHP\FineUIControls::button()->text('提交');
?>
</body>
</html>
```

## 5 附录1

可用的配置项（这里列的都是默认值）:
* Theme="Default"
* Language="zh_CN"
* DebugMode="false"
* FormMessageTarget="Qtip"
* FormOffsetRight="0"
* FormLabelWidth="100"
* FormLabelSeparator="："
* FormLabelAlign="Left"
* FormRedStarPosition="AfterText"
* EnableAjax="true"
* EnableAjaxLoading="true"
* AjaxTimeout="120"
* AjaxLoadingType="Default"
* AjaxLoadingText=""
* ShowAjaxLoadingMaskText=false
* AjaxLoadingMaskText=""
* CustomTheme=""
* CustomThemeBasePath="/res/themes"
* IconBasePath="/res/icon"
* JSBasePath="/res/js"
* IEEdge="true"
* EnableShim="false"
* DisplayMode="Normal"
* MobileAdaption="true"
* EnableAnimation="false"
* LoadingImageNumber="1"
