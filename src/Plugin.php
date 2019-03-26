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
namespace MeCmsLinkScanner;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use LinkScanner\Plugin as LinkScanner;

/**
 * Plugin class
 */
class Plugin extends BasePlugin
{
    /**
     * Load all the application configuration and bootstrap logic
     * @param PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app)
    {
        if (!$app->getPlugins()->has('LinkScanner')) {
            $app->addPlugin(LinkScanner::class);
        }

        parent::bootstrap($app);
    }
}
