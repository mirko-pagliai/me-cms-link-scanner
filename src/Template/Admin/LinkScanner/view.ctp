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
$this->extend(ME_CMS . './Admin/Common/view');
$this->assign('title', __d('me_cms_link_scanner', '{0} log {1}', LINK_SCANNER, $filename));

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

<div class="mb-4">
    <div class="btn-group btn-group-sm" role="group">
        <?php
            echo $this->Html->button(
                __d('me_cms_link_scanner', 'Show all'),
                [$this->request->getParam('pass.0'), '?' => ['show' => 'all']],
                ['class' => 'btn-primary']
            );
            echo $this->Html->button(
                __d('me_cms_link_scanner', 'Show redirects'),
                [$this->request->getParam('pass.0'), '?' => ['show' => 'redirects']],
                ['class' => 'btn-primary']
            );
            echo $this->Html->button(
                __d('me_cms_link_scanner', 'Show invalid'),
                [$this->request->getParam('pass.0'), '?' => ['show' => 'invalid']],
                ['class' => 'btn-primary']
            );
        ?>
    </div>
</div>

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
                <code><?= $row->url ?></code>
                <?php if ($row->referer): ?>
                    <div><small><?= __d('me_cms_link_scanner', 'Referer: {0}', $row->referer) ?></small></div>
                <?php endif; ?>
                <?php
                    $actions = [];
                    $actions[] = $this->Html->link(I18N_OPEN, $row->getOriginal('url'), [
                        'icon' => 'external-link-alt',
                        'target' => '_blank',
                    ]);
                    if ($row->referer) {
                        $actions[] = $this->Html->link(__d('me_cms_link_scanner', 'Open referer'), $row->referer, [
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
                <?php elseif ($row->isError()) : ?>
                    <span class="badge badge-danger"><?= $row->code ?></span>
                <?php else : ?>
                    <span class="badge badge-warning"><?= $row->code ?></span>
                <?php endif; ?>
            </td>
            <td class="text-center"><?= $row->external ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>