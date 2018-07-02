<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Memo[]|\Cake\Collection\CollectionInterface $memos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Memo'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="memos index large-9 medium-8 columns content">
    <h3><?= __('Memos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('memo_file') ?></th>
                <th scope="col"><?= $this->Paginator->sort('celebrium_file') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($memos as $memo): ?>
            <tr>
                <td><?= $this->Number->format($memo->id) ?></td>
                <td><?= h($memo->name) ?></td>
                <td><?= $memo->has('user') ? $this->Html->link($memo->user->name, ['controller' => 'Users', 'action' => 'view', $memo->user->id]) : '' ?></td>
                <td><?= h($memo->memo_file) ?></td>
                <td><?= h($memo->celebrium_file) ?></td>
                <td><?= h($memo->created) ?></td>
                <td><?= h($memo->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $memo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $memo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $memo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $memo->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
