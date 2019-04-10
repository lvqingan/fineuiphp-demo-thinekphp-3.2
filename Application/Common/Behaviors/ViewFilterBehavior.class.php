<?php

namespace Common\Behaviors;

class ViewFilterBehavior extends \Think\Behavior
{
    public function run(&$content)
    {
        \FineUIPHP\ResourceManager\ResourceManager::finish($content);
    }
}
