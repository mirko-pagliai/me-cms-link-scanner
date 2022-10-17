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
 *
 * @var array<array{filename: string, filetime: \Cake\I18n\FrozenTime, filesize: int}> $logs
 * @var \MeCms\LinkScanner\View\View\AppView $this
 */

$this->extend('MeCms./Admin/common/index');
$this->assign('title', __d('me_cms/link_scanner', '{0} logs', 'LinkScanner'));
?>

<table class="table table-striped">
    <tr>
        <th><?= I18N_FILENAME ?></th>
        <th class="min-width text-center"><?= __d('me_cms/link_scanner', 'Last modification') ?></th>
        <th class="min-width text-center"><?= __d('me_cms/link_scanner', 'File size') ?></th>
    </tr>
    <?php foreach ($logs as $log) : ?>
        <tr>
            <td>
                <strong>
                    <?= $this->Html->link($log['filename'], ['action' => 'view', $log['filename']]) ?>
                </strong>
            </td>
            <td class="text-nowrap text-center">
                <div class="d-none d-lg-block">
                    <?= $log['filetime']->i18nFormat() ?>
                </div>
                <div class="d-lg-none">
                    <div><?= $log['filetime']->i18nFormat(getConfigOrFail('main.date.short')) ?></div>
                    <div><?= $log['filetime']->i18nFormat(getConfigOrFail('main.time.short')) ?></div>
                </div>
            </td>
            <td class="min-width text-nowrap text-center">
                <?= $this->Number->toReadableSize($log['filesize']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
