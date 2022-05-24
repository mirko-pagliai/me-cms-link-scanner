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

namespace MeCms\LinkScanner\Test\TestCase\View\Helper;

use MeTools\TestSuite\HelperTestCase;
use MeTools\View\Helper\HtmlHelper;

/**
 * MenuHelperTest class
 * @property \MeCms\LinkScanner\View\Helper\MenuHelper $Helper
 */
class MenuHelperTest extends HelperTestCase
{
    /**
     * Internal method to write auth data on session
     * @param array $data Data you want to write
     * @return void
     */
    protected function writeAuthOnSession(array $data = []): void
    {
        $this->Helper->getView()->getRequest()->getSession()->write('Auth.User', $data);
        $this->Helper->Auth->initialize([]);
    }

    /**
     * Internal method to build links
     * @param array $links Links
     * @return string
     */
    protected function buildLinks(array $links): string
    {
        /** @var \MeTools\View\Helper\HtmlHelper $HtmlHelper */
        $HtmlHelper = $this->getMockForHelper(HtmlHelper::class, null);

        return implode(PHP_EOL, array_map(fn(array $link): string => $HtmlHelper->link($link[0], $link[1]), $links));
    }

    /**
     * Tests for `scanner()` method
     * @test
     */
    public function testScanner(): void
    {
        $this->assertEmpty($this->Helper->scanner());

        $this->writeAuthOnSession(['group' => ['name' => 'admin']]);
        [$links,,, $handledControllers] = $this->Helper->scanner();
        $links = $this->buildLinks($links);
        $this->assertTextContains('Link scanner', $links);
        $this->assertEquals(['LinkScanner'], $handledControllers);
    }
}
