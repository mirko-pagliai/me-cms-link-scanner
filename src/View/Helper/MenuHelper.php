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
namespace MeCmsLinkScanner\View\Helper;

use Cake\View\Helper;

/**
 * Menu Helper.
 *
 * This helper contains methods that will be called automatically to generate
 * the menu of the admin layout.
 * You do not need to call these methods manually.
 */
class MenuHelper extends Helper
{
    /**
     * Helpers
     * @var array
     */
    public $helpers = [ME_CMS . '.Auth'];

    /**
     * Internal function to generate the menu for "scanner" actions
     * @return mixed Array with links, title and title options
     */
    public function scanner()
    {
        //Only admins access this controller
        if (!$this->Auth->isGroup('admin')) {
            return;
        }

        $links[] = [__d('me_cms_link_scanner', 'Link scanner'), [
            'controller' => 'LinkScanner',
            'action' => 'index',
            'plugin' => ME_CMS_LINK_SCANNER,
            'prefix' => ADMIN_PREFIX,
        ]];

        return [$links, __d('me_cms_link_scanner', 'Link scanner'), ['icon' => 'film']];
    }
}
