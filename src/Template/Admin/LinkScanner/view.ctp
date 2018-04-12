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
$this->assign('title', __d('me_cms', '{0} log {1}', LINK_SCANNER, $filename));
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th><?= __d('me_cms', 'Url') ?></th>
            <th><?= __d('me_cms', 'Type') ?></th>
            <th class="text-center"><?= __d('me_cms', 'Code') ?></th>
            <th class="text-center text-nowrap"><?= __d('me_cms', 'Is external?') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><code><?= $row->url ?></code></td>
            <td class="text-nowrap"><code><?= $row->type ?></code></td>
            <td class="text-center"><?= $row->code ?></td>
            <td class="text-center"><?= $row->external ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>