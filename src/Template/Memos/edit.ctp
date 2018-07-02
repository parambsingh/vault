<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Memo $memo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $memo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $memo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Memos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="memos form large-9 medium-8 columns content">
    <?= $this->Form->create($memo) ?>
    <fieldset>
        <legend><?= __('Edit Memo') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('memo_file');
            echo $this->Form->control('celebrium_file');
            echo $this->Form->control('celebrium_json');
            echo $this->Form->control('meta_json');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
