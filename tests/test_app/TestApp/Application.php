<?php
declare(strict_types=1);

namespace App;

use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\RoutingMiddleware;
use MeCms\Plugin as MeCms;
use MeCmsLinkScanner\Plugin as MeCmsLinkScanner;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        $this->addPlugin(MeCms::class, ['bootstrap' => false, 'routes' => false]);
        $this->addPlugin(MeCmsLinkScanner::class, ['bootstrap' => false, 'routes' => false]);
    }

    public function middleware(MiddlewareQueue $middleware): MiddlewareQueue
    {
        return $middleware->add(new RoutingMiddleware($this));
    }
}
