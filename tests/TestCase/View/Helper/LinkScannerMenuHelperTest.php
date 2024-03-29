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

/**
 * LinkScannerMenuHelperTest class
 */
class LinkScannerMenuHelperTest extends MenuHelperTestCase
{
    /**
     * @ŧest
     * @uses \MeCms\LinkScanner\View\Helper\LinkScannerMenuHelper::getLinks()
     */
    public function testGetLinks(): void
    {
        $this->assertEmpty($this->getLinksAsHtml());

        $this->setIdentity(['group' => ['name' => 'manager']]);
        $this->assertEmpty($this->getLinksAsHtml());

        $this->setIdentity(['group' => ['name' => 'admin']]);
        $this->assertSame([
            '<a href="/me-cms/link-scanner/admin/link-scanner" title="Link scanner">Link scanner</a>',
        ], $this->getLinksAsHtml());
    }
}
