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
$this->extend('MeCms./Admin/Common/view');
$this->assign('title', __d('me_cms_link_scanner', '{0} log {1}', 'LinkScanner', $filename));

$isRedirectResults = $results->filter(function($row) {
    return $row->isRedirect();
});
$isNotOkResults = $results->filter(function($row) {
    return !$row->isOk() && !$row->isRedirect();
});
?>

<p class="mb-0">
    <strong><?= __d('me_cms_link_scanner', 'Full base url') ?>:</strong> <?= $fullBaseUrl ?>
</p>
<p class="mb-0">
    <strong><?= __d('me_cms_link_scanner', 'End time') ?>:</strong> <?= $endTime ?>
</p>
<p class="mb-0">
    <strong><?= __d('me_cms_link_scanner', 'Elapsed time') ?>:</strong> <?= $elapsedTime ?>
</p>
<p class="mb-0">
    <strong><?= __d('me_cms_link_scanner', 'Redirect links') ?>:</strong> <?= $isRedirectResults->count() ?>
</p>
<p class="mb-0">
    <strong><?= __d('me_cms_link_scanner', 'Invalid links') ?>:</strong> <?= $isNotOkResults->count() ?>
</p>
<p>
    <strong><?= __d('me_cms_link_scanner', 'Total scanned links') ?>:</strong> <?= $results->count() ?>
</p>

<?php
if ($this->request->getQuery('show') === 'invalid') {
    $results = $isNotOkResults;
} elseif ($this->request->getQuery('show') === 'redirects') {
    $results = $isRedirectResults;
}
?>

<?php if ($isRedirectResults->count() || $isNotOkResults->count()) : ?>
<div class="mb-4">
    <div class="btn-group btn-group-sm" role="group">
        <?php
            echo $this->Html->button(
                __d('me_cms_link_scanner', 'Show all'),
                [$this->request->getParam('pass.0'), '?' => ['show' => 'all']],
                ['class' => 'btn-primary']
            );
            if ($isRedirectResults->count()) {
                echo $this->Html->button(
                    __d('me_cms_link_scanner', 'Show redirects'),
                    [$this->request->getParam('pass.0'), '?' => ['show' => 'redirects']],
                    ['class' => 'btn-primary']
                );
            }
            if ($isNotOkResults->count()) {
                echo $this->Html->button(
                    __d('me_cms_link_scanner', 'Show invalid'),
                    [$this->request->getParam('pass.0'), '?' => ['show' => 'invalid']],
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
            <th><?= __d('me_cms_link_scanner', 'Url') ?></th>
            <th><?= __d('me_cms_link_scanner', 'Type') ?></th>
            <th class="text-center"><?= __d('me_cms_link_scanner', 'Code') ?></th>
            <th class="text-center text-nowrap"><?= __d('me_cms_link_scanner', 'External?') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <td>
                <code class="text-truncate">
                    <?= $this->Text->truncate($row->url, 100); ?>
                </code>
                <?php if ($row->referer): ?>
                    <div class="small text-truncate">
                        <?= __d('me_cms_link_scanner', 'Referer: {0}', $this->Text->truncate($row->referer, 100)) ?>
                    </div>
                <?php endif; ?>
                <?php
                    $actions = [];
                    $actions[] = $this->Html->link(I18N_OPEN, $fullBaseUrl . $row->url, [
                        'icon' => 'external-link-alt',
                        'target' => '_blank',
                    ]);
                    if ($row->referer) {
                        $actions[] = $this->Html->link(__d('me_cms_link_scanner', 'Open referer'), $fullBaseUrl . $row->referer, [
                            'icon' => 'external-link-alt',
                            'target' => '_blank',
                        ]);
                    }
                    echo $this->Html->ul($actions, ['class' => 'actions']);
                ?>
            </td>
            <td class="text-nowrap"><code><?= $row->type ?></code></td>
            <td class="text-center">
                <?php if ($row->isOk()) : ?>
                    <span class="badge badge-success"><?= $row->code ?></span>
                <?php elseif (!$row->isRedirect()) : ?>
                    <span class="badge badge-danger"><?= $row->code ?></span>
                <?php else : ?>
                    <span class="badge badge-warning"><?= $row->code ?></span>
                <?php endif; ?>
            </td>
            <td class="text-center">
                <?php if ($row->external): ?>
                    <span class="badge badge-success"><?= $this->Icon->icon('check') ?></span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>