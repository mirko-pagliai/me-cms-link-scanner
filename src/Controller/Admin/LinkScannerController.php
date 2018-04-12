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
use Cake\Utility\Inflector;
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
        $path = TMP . Inflector::underscore(LINK_SCANNER);
        $logs = (new Folder($path))->find();
        $logs = collection($logs)->map(function ($log) use ($path) {
            return (object)[
                'filename' => $log,
                'filetime' => new Time(filemtime($path . DS . $log)),
            ];
        })->toList();

        $this->set(compact('logs'));
    }

    /**
     * Views a `LinkScanner` log
     * @param string $filename Filename
     * @return void
     */
    public function view($filename)
    {
        $filename = urldecode($filename);
        $LinkScanner = new LinkScanner;
        $LinkScanner->import(TMP . Inflector::underscore(LINK_SCANNER) . DS . $filename);

        $results = $LinkScanner->ResultScan->map(function ($result) {
            $result->url = preg_replace(sprintf('/^%s/', preg_quote(getConfig('App.fullBaseUrl'), '/')), null, $result->url);

            return $result;
        });

        $this->set(compact('filename', 'results'));
    }
}
