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
namespace MeCms\LinkScanner\View\Helper;

use MeCms\View\Helper\AbstractMenuHelper;

/**
 * Menu Helper.
 *
 * This helper contains methods that will be called automatically to generate menus for the admin layout.
 * You don't need to call these methods manually, use instead the `MenuBuilderHelper` helper.
 *
 * Each method must return an array with four values:
 *  - the menu links, as an array of parameters;
 *  - the menu title;
 *  - the options for the menu title;
 *  - the controllers handled by this menu, as an array.
 *
 * @see \MeCms\View\Helper\MenuBuilderHelper::generate() for more information
 */
class MenuHelper extends AbstractMenuHelper
{
    /**
     * Internal function to generate the menu for "scanner" actions
     * @return array Array with links, title, title options and handled controllers
     * @throws \ErrorException
     */
    public function scanner(): array
    {
        //Only admins can access this controller
        if (!$this->Identity->isGroup('admin')) {
            return [];
        }

        $links[] = [__d('me_cms/link_scanner', 'Link scanner'), [
            'controller' => 'LinkScanner',
            'action' => 'index',
            'plugin' => 'MeCms/LinkScanner',
            'prefix' => ADMIN_PREFIX,
        ]];

        return [$links, __d('me_cms/link_scanner', 'Link scanner'), ['icon' => 'link'], ['LinkScanner']];
    }
}
