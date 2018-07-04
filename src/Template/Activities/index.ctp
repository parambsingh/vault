<?php $this->assign('title', __('Your Activity')); ?>
<div class="activities index large-9 medium-8 columns content">
    <h3><?= __('Activities') ?></h3>
    <table cellpadding="0" cellspacing="0" class="table" style="background-color: #eebc41; color: #ffffff; ">
        <tbody>
            <?php foreach ($activities as $activity): ?>
            <tr>
                <td style="padding: 20px;"><b><?= date(SHORT_DATE, strtotime($activity->created)) ?></b></td>
                <td style="padding: 20px; color: <?= $activity->activity_template->color ?>"><?= $this->Activity->readyTemplate($activity) ?></td>
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
