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
namespace MeCmsLinkScanner\Controller\Admin;

use Cake\Filesystem\Folder;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use LinkScanner\Utility\LinkScanner;
use MeCms\Controller\Admin\AppController;

/**
 * LinkScanner controller
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
        $target = (new LinkScanner())->getConfig('target');

        $logs = collection((new Folder($target))->find())
            ->map(function (string $log) use ($target) {
                $path = $target . DS . $log;

                return new Entity([
                    'filename' => $log,
                    'filetime' => Time::createFromTimestamp(filemtime($path)),
                    'filesize' => filesize($path),
                ]);
            })
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
        $LinkScanner = $LinkScanner->import(add_slash_term($LinkScanner->getConfig('target')) . urldecode($filename));
        $endTime = Time::createFromTimestamp($LinkScanner->endTime);
        $elapsedTime = $endTime->diffForHumans(Time::createFromTimestamp($LinkScanner->startTime), true);
        $fullBaseUrl = $LinkScanner->getConfig('fullBaseUrl');

        $results = $LinkScanner->ResultScan->map(function ($result) use ($fullBaseUrl) {
            foreach (['url', 'referer'] as $property) {
                $result->$property = preg_replace(sprintf('/^%s\/?/', preg_quote($fullBaseUrl, DS)), '/', $result->$property);
            }

            return $result;
        })
        ->sortby('url', SORT_ASC, SORT_NATURAL);

        $this->set(compact('elapsedTime', 'endTime', 'filename', 'fullBaseUrl', 'results'));
    }
}
