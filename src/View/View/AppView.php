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
namespace MeCms\LinkScanner\View\View;

use MeCms\View\View\AppView as MeCmsAppView;

/**
 * Application view class
 */
class AppView extends MeCmsAppView
{
    /**
     * Renders a layout. Returns output from _render(). Returns false on
     *  error. Several variables are created for use in layout
     * @param string $content Content to render in a view, wrapped by the
     *  surrounding layout
     * @param string|null $layout Layout name
     * @return string Rendered output
     * @uses MeCms\View\View\AppView::renderLayout()
     */
    public function renderLayout($content, $layout = null): string
    {
        $this->plugin ?: 'MeCms';

        return parent::renderLayout($content, $layout);
    }
}
