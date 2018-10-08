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
namespace MeCmsLinkScanner\Controller\Admin;

use Cake\Filesystem\Folder;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use LinkScanner\Utility\LinkScanner;
use MeCms\Controller\AppController;

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
    public function isAuthorized($user = null)
    {
        //Only admins can access this controller
        return $this->Auth->isGroup('admin');
    }

    /**
     * Lists `LinkScanner` logs
     * @return void
     */
    public function index()
    {
        $logs = collection((new Folder(LINK_SCANNER_TARGET))->find())
            ->map(function ($log) {
                $path = LINK_SCANNER_TARGET . DS . $log;

                return new Entity([
                    'filename' => $log,
                    'filetime' => new Time(filemtime($path)),
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
     * @uses LinkScanner\Utility\LinkScanner::import()
     */
    public function view($filename)
    {
        $filename = urldecode($filename);
        $LinkScanner = LinkScanner::import(LINK_SCANNER_TARGET . DS . $filename);
        $endTime = new Time($LinkScanner->endTime);
        $elapsedTime = $endTime->diffForHumans(new Time($LinkScanner->startTime), true);
        $fullBaseUrl = $LinkScanner->fullBaseUrl;

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
