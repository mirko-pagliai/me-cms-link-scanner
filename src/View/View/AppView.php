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
namespace MeCmsLinkScanner\View\View;

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
     * @return mixed Rendered output, or false on error
     * @see http://api.cakephp.org/3.4/class-Cake.View.View.html#_renderLayout
     * @uses MeCms\View\View\AppView::renderLayout()
     */
    public function renderLayout($content, $layout = null)
    {
        if (empty($this->plugin)) {
            $this->plugin = ME_CMS;
        }

        return parent::renderLayout($content, $layout);
    }
}
