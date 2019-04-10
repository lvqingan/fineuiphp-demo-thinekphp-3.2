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
