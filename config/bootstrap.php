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

use Cake\Core\Configure;
use MeCms\LinkScanner\View\Helper\LinkScannerMenuHelper;

Configure::write('MeCms/LinkScanner.MenuHelpers', [LinkScannerMenuHelper::class]);
