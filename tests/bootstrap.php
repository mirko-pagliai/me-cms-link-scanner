<?php
declare(strict_types=1);

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

use Cake\Cache\Cache;
use Cake\Core\Configure;

ini_set('intl.default_locale', 'en_US');
date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

define('ROOT', dirname(__DIR__) . DS);
const CORE_PATH = ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS;
const CAKE = CORE_PATH . 'src' . DS;
const TESTS = ROOT . 'tests' . DS;
const TEST_APP = TESTS . 'test_app' . DS;
const APP = TEST_APP . 'TestApp' . DS;
const APP_DIR = 'TestApp';
const WWW_ROOT = APP . 'webroot' . DS;
define('TMP', sys_get_temp_dir() . DS . 'me_cms_link_scanner' . DS);
const CONFIG = APP . 'config' . DS;
const CACHE = TMP . 'cache' . DS;
const LOGS = TMP . 'logs' . DS;
const SESSIONS = TMP . 'sessions' . DS;

require dirname(__DIR__) . '/vendor/autoload.php';
require CORE_PATH . 'config' . DS . 'bootstrap.php';
require dirname(__DIR__) . '/vendor/mirko-pagliai/cakephp-link-scanner/config/bootstrap.php';

foreach (array_filter([TMP, LINK_SCANNER_TMP, LOGS, SESSIONS, CACHE . 'views', CACHE . 'models'], fn(string $dir): bool => !file_exists($dir)) as $dir) {
    mkdir($dir, 0777, true);
}

Configure::write('debug', true);
Configure::write('App', [
    'namespace' => 'App',
    'encoding' => 'UTF-8',
    'base' => false,
    'baseUrl' => false,
    'dir' => APP_DIR,
    'webroot' => 'webroot',
    'wwwRoot' => WWW_ROOT,
    'fullBaseUrl' => 'http://localhost',
    'imageBaseUrl' => 'img/',
    'jsBaseUrl' => 'js/',
    'cssBaseUrl' => 'css/',
    'paths' => ['templates' => [APP . 'templates' . DS]],
]);
Configure::write('Session', ['defaults' => 'php']);
Configure::write('Assets.target', TMP . 'assets');
Configure::write('DatabaseBackup.target', TMP . 'backups');
Configure::write('pluginsToLoad', ['Thumber/Cake', 'MeCms', 'MeCms/LinkScanner']);

Cache::setConfig([
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true,
    ],
]);

$_SERVER['PHP_SELF'] = '/';
