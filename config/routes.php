<?php

/**
 * This file is part of me-cms-link-scanner.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Mirko Pagliai
 * @link        https://github.com/mirko-pagliai/me-cms-link-scanner
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::plugin('MeCmsLinkScanner', ['path' => '/me-cms-link-scanner'], function (RouteBuilder $routes) {
    $routes->prefix(ADMIN_PREFIX, function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    });
});
