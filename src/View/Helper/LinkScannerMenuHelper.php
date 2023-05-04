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
 * LinkScannerMenuHelper
 */
class LinkScannerMenuHelper extends AbstractMenuHelper
{
    /**
     * Gets the links for this menu. Each links is an array of parameters
     * @return array[]
     * @throws \ErrorException
     */
    public function getLinks(): array
    {
        //Only admins can access this controller
        if (!$this->Identity->isGroup('admin')) {
            return [];
        }

        return [
            [__d('me_cms/link_scanner', 'Link scanner'), [
                'controller' => 'LinkScanner',
                'action' => 'index',
                'plugin' => 'MeCms/LinkScanner',
                'prefix' => ADMIN_PREFIX,
            ]],
        ];
    }

    /**
     * Gets the options for this menu
     * @return array
     */
    public function getOptions(): array
    {
        return ['icon' => 'link'];
    }

    /**
     * Gets the title for this menu
     * @return string
     */
    public function getTitle(): string
    {
        return __d('me_cms/link_scanner', 'Link scanner');
    }
}
