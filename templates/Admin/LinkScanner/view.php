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
 * @var string $elapsedTime
 * @var string $endTime
 * @var string $filename
 * @var string $fullBaseUrl
 * @var \Cake\Collection\CollectionInterface $results
 * @var \MeCms\View\View\Admin\AppView $this
 */

$this->extend('MeCms./Admin/common/view');
$this->assign('title', __d('me_cms/link_scanner', '{0} log {1}', 'LinkScanner', $filename));

$isRedirectResults = $results->filter(fn($row) => $row->isRedirect());
$isNotOkResults = $results->filter(fn($row) => !$row->isOk() && !$row->isRedirect());
?>

<p class="mb-0">
    <strong><?= __d('me_cms/link_scanner', 'Full base url') ?>:</strong> <?= $fullBaseUrl ?>
</p>
<p class="mb-0">
    <strong><?= __d('me_cms/link_scanner', 'End time') ?>:</strong> <?= $endTime ?>
</p>
<p class="mb-0">
    <strong><?= __d('me_cms/link_scanner', 'Elapsed time') ?>:</strong> <?= $elapsedTime ?>
</p>
<p class="mb-0">
    <strong><?= __d('me_cms/link_scanner', 'Redirect links') ?>:</strong> <?= $isRedirectResults->count() ?>
</p>
<p class="mb-0">
    <strong><?= __d('me_cms/link_scanner', 'Invalid links') ?>:</strong> <?= $isNotOkResults->count() ?>
</p>
<p>
    <strong><?= __d('me_cms/link_scanner', 'Total scanned links') ?>:</strong> <?= $results->count() ?>
</p>

<?php
if ($this->getRequest()->getQuery('show') === 'invalid') {
    $results = $isNotOkResults;
} elseif ($this->getRequest()->getQuery('show') === 'redirects') {
    $results = $isRedirectResults;
}
?>

<?php if ($isRedirectResults->count() || $isNotOkResults->count()) : ?>
<div class="mb-4">
    <div class="btn-group btn-group-sm" role="group">
        <?php
        echo $this->Html->button(
            __d('me_cms/link_scanner', 'Show all'),
            [$this->getRequest()->getParam('pass.0'), '?' => ['show' => 'all']],
            ['class' => 'btn-primary']
        );
        if ($isRedirectResults->count()) {
            echo $this->Html->button(
                __d('me_cms/link_scanner', 'Show redirects'),
                [$this->getRequest()->getParam('pass.0'), '?' => ['show' => 'redirects']],
                ['class' => 'btn-primary']
            );
        }
        if ($isNotOkResults->count()) {
            echo $this->Html->button(
                __d('me_cms/link_scanner', 'Show invalid'),
                [$this->getRequest()->getParam('pass.0'), '?' => ['show' => 'invalid']],
                ['class' => 'btn-primary']
            );
        }
        ?>
    </div>
</div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th><?= __d('me_cms/link_scanner', 'Url') ?></th>
            <th><?= __d('me_cms/link_scanner', 'Type') ?></th>
            <th class="text-center"><?= __d('me_cms/link_scanner', 'Code') ?></th>
            <th class="text-center text-nowrap"><?= __d('me_cms/link_scanner', 'External?') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row) : ?>
        <tr>
            <td>
                <code class="text-truncate">
                    <?= $this->Text->truncate($row->get('url'), 100); ?>
                </code>
                <?php if ($row->get('referer')) : ?>
                    <div class="small text-truncate">
                        <?= __d('me_cms/link_scanner', 'Referer: {0}', $this->Text->truncate($row->get('referer'), 100)) ?>
                    </div>
                <?php endif; ?>
                <?php
                $actions = [];
                $actions[] = $this->Html->link(I18N_OPEN, $fullBaseUrl . $row->get('url'), [
                    'icon' => 'external-link-alt',
                    'target' => '_blank',
                ]);
                if ($row->get('referer')) {
                    $actions[] = $this->Html->link(__d('me_cms/link_scanner', 'Open referer'), $fullBaseUrl . $row->get('referer'), [
                        'icon' => 'external-link-alt',
                        'target' => '_blank',
                    ]);
                }
                echo $this->Html->ul($actions, ['class' => 'actions']);
                ?>
            </td>
            <td class="text-nowrap"><code><?= $row->get('type') ?></code></td>
            <td class="text-center">
                <?php if ($row->isOk()) : ?>
                    <span class="badge badge-success"><?= $row->get('code') ?></span>
                <?php elseif (!$row->isRedirect()) : ?>
                    <span class="badge badge-danger"><?= $row->get('code') ?></span>
                <?php else : ?>
                    <span class="badge badge-warning"><?= $row->get('code') ?></span>
                <?php endif; ?>
            </td>
            <td class="text-center">
                <?php if ($row->get('external')) : ?>
                    <span class="badge badge-success"><?= $this->Icon->icon('check') ?></span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
