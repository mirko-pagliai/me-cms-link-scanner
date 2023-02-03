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

use MeCms\TestSuite\MenuHelperTestCase;
use MeTools\View\Helper\HtmlHelper;

/**
 * MenuHelperTest class
 * @property \MeCms\LinkScanner\View\Helper\MenuHelper $Helper
 */
class MenuHelperTest extends MenuHelperTestCase
{
    /**
     * @test
     * @uses \MeCms\LinkScanner\View\Helper\MenuHelper::scanner()
     */
    public function testScanner(): void
    {
        foreach (['user', 'manager'] as $name) {
            $this->setIdentity(['group' => compact('name')]);
            $this->assertEmpty($this->Helper->scanner());
        }

        $this->setIdentity(['group' => ['name' => 'admin']]);
        [$links,,, $handledControllers] = $this->Helper->scanner();
        $this->assertNotEmpty($links);
        $this->assertEquals(['LinkScanner'], $handledControllers);
    }
}
