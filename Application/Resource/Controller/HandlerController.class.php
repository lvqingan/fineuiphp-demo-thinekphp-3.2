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
