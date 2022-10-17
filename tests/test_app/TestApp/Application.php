<?php
declare(strict_types=1);

namespace App;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\RoutingMiddleware;
use MeCms\LinkScanner\Plugin as MeCmsLinkScanner;
use MeCms\Plugin as MeCms;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        $this->addPlugin(MeCms::class, ['bootstrap' => true, 'routes' => false]);
        $this->addPlugin(MeCmsLinkScanner::class, ['bootstrap' => false, 'routes' => false]);
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue->add(new RoutingMiddleware($this));
    }
}
