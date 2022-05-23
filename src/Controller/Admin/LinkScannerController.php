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
namespace MeCms\LinkScanner\Controller\Admin;

use Cake\Filesystem\Folder;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;
use LinkScanner\ScanEntity;
use LinkScanner\Utility\LinkScanner;
use MeCms\Controller\Admin\AppController;
use Tools\Filesystem;

/**
 * LinkScanner controller
 * @property \MeCms\Controller\Component\AuthComponent $Auth
 */
class LinkScannerController extends AppController
{
    /**
     * Check if the provided user is authorized for the request
     * @param array $user The user to check the authorization of. If empty
     *  the user in the session will be used
     * @return bool `true` if the user is authorized, otherwise `false`
     * @uses MeCms\Controller\Component\AuthComponent::isGroup()
     */
    public function isAuthorized($user = null): bool
    {
        //Only admins can access this controller
        return $this->Auth->isGroup('admin');
    }

    /**
     * Lists `LinkScanner` logs
     * @return void
     */
    public function index(): void
    {
        $target = Filesystem::instance()->addSlashTerm((new LinkScanner())->getConfig('target'));

        $logs = collection((new Folder($target))->find())
            ->map(fn(string $filename): Entity => new Entity(compact('filename') + [
                'filetime' => FrozenTime::createFromTimestamp(filemtime($target . $filename) ?: 0),
                'filesize' => filesize($target . $filename),
            ]))
            ->sortBy('filetime');

        $this->set(compact('logs'));
    }

    /**
     * Views a `LinkScanner` log
     * @param string $filename Filename
     * @return void
     * @uses \LinkScanner\Utility\LinkScanner
     */
    public function view($filename): void
    {
        $LinkScanner = new LinkScanner();
        $LinkScanner = $LinkScanner->import(Filesystem::instance()->concatenate($LinkScanner->getConfig('target'), urldecode($filename)));
        $endTime = FrozenTime::createFromTimestamp($LinkScanner->endTime);
        $elapsedTime = $endTime->diffForHumans(FrozenTime::createFromTimestamp($LinkScanner->startTime), true);
        $fullBaseUrl = rtrim($LinkScanner->getConfig('fullBaseUrl'), '/');

        //Callback. Removes the full base url from some values (`url` and `referer`)
        $removeFullBase = fn(ScanEntity $result, string $key): ScanEntity => $result->set($key, str_starts_with($result->get($key) ?: '', $fullBaseUrl) ? substr($result->get($key), strlen($fullBaseUrl)) : $result->get($key));

        $results = $LinkScanner->ResultScan
            ->map(fn(ScanEntity $result): ScanEntity => $removeFullBase($result, 'url'))
            ->map(fn(ScanEntity $result): ScanEntity => $removeFullBase($result, 'referer'))
            ->sortby('url', SORT_ASC, SORT_NATURAL);

        $this->set(compact('elapsedTime', 'endTime', 'filename', 'fullBaseUrl', 'results'));
    }
}
