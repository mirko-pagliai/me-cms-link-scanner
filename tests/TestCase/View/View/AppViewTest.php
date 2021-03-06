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

namespace MeCms\LinkScanner\Test\TestCase\View\View;

use Cake\Http\ServerRequest;
use MeCms\LinkScanner\View\View\AppView;
use MeTools\TestSuite\TestCase;

/**
 * AppViewTest class
 */
class AppViewTest extends TestCase
{
    /**
     * Tests for `renderLayout()` method
     * @test
     */
    public function testRenderLayout()
    {
        $request = new ServerRequest();
        $view = new AppView($request->withEnv('REQUEST_URI', '/'));
        $view->renderLayout('', 'with_flash');
        $this->assertSame('MeCms', $view->getPlugin());
    }
}
