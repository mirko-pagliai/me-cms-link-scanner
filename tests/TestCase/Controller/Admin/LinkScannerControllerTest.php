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

namespace MeCmsLinkScanner\Test\TestCase\Controller\Admin;

use Cake\Collection\Collection;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use LinkScanner\Utility\LinkScanner;
use MeCms\TestSuite\ControllerTestCase;
use Tools\Filesystem;

/**
 * LinkScannerControllerTest class
 */
class LinkScannerControllerTest extends ControllerTestCase
{
    /**
     * Called after every test method
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();

        (new Filesystem())->unlinkRecursive((new LinkScanner())->getConfig('target'));
    }

    /**
     * Tests for `isAuthorized()` method
     * @test
     */
    public function testIsAuthorized()
    {
        $this->assertGroupsAreAuthorized([
            'admin' => true,
            'manager' => false,
            'user' => false,
        ]);
    }

    /**
     * Tests for `index()` method
     * @test
     */
    public function testIndex()
    {
        $target = (new LinkScanner())->getConfig('target');
        (new Filesystem())->createTmpFile('log1', $target);
        (new Filesystem())->createTmpFile('log2', $target);

        $this->get($this->url + ['action' => 'index']);
        $this->assertResponseOkAndNotEmpty();
        $this->assertTemplate('Admin' . DS . 'LinkScanner' . DS . 'index.php');
        $logs = $this->viewVariable('logs');
        $this->assertContainsOnlyInstancesOf(Entity::class, $logs);
        $this->assertCount(2, $logs);

        foreach ($logs as $log) {
            $this->assertNotEmpty($log->get('filename'));
            $this->assertInstanceOf(Time::class, $log->get('filetime'));
            $this->assertGreaterThan(0, $log->get('filesize'));
        }
    }

    /**
     * Tests for `view()` method
     * @test
     */
    public function testView()
    {
        $origin = TESTS . 'examples' . DS . 'results_google.com_1579535226';
        $target = (new Filesystem())->concatenate((new LinkScanner())->getConfig('target'), basename($origin));
        copy($origin, $target);

        $this->get($this->url + ['action' => 'view', urlencode(basename($target))]);
        $this->assertResponseOkAndNotEmpty();
        $this->assertRegExp('/^\d+ seconds$/', $this->viewVariable('elapsedTime'));
        $this->assertInstanceOf(Time::class, $this->viewVariable('endTime'));
        $this->assertSame(basename($target), $this->viewVariable('filename'));
        $this->assertSame('http://google.com', $this->viewVariable('fullBaseUrl'));
        $this->assertInstanceOf(Collection::class, $this->viewVariable('results'));
    }
}
