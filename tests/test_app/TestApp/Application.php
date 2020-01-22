<?php

namespace App;

use Cake\Http\BaseApplication;
use Cake\Routing\Middleware\RoutingMiddleware;
use MeCms\Plugin as MeCms;
use MeCmsLinkScanner\Plugin as MeCmsLinkScanner;

class Application extends BaseApplication
{
    public function bootstrap()
    {
        $this->addPlugin(MeCms::class, ['bootstrap' => false, 'routes' => false]);
        $this->addPlugin(MeCmsLinkScanner::class, ['bootstrap' => false, 'routes' => false]);
    }

    public function middleware($middlewareQueue)
    {
        return $middlewareQueue->add(new RoutingMiddleware($this));
    }
}
