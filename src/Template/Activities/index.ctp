<?php $this->assign('title', __('Your Activity')); ?>
<div class="row heading-activity" >
    <!--div class="col-lg-1"><img src="<?= SITE_URL ?>/img/activity_heading.png" alt="RAIDA" title="Add Memos"
                               style="margin-top: 100px;"></div!-->
    <div class="col-lg-11 col-md-10 col-sm-10 col-xs-12" style="padding-left:5%;">
        <div class="activities index large-9 medium-8 columns content">
            <!--<h3><?= __('Activities') ?></h3!-->
            <table cellpadding="0" cellspacing="0" class="table" style="color: #ffffff; ">
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
                <ul class="pagination pg-black">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
        </div>
    </div>
</div>
