<?php $this->assign('title', __('Dashboard')); ?>
<div class="row">
    <div class="col-lg-1"><img src="<?= SITE_URL ?>/img/digital-memo.png" alt="RAIDA" title="Add Memos"
                               style="margin-top: 100px;"></div>
    <div class="col-lg-11">
        <div class="row">
            <?php foreach ($memos
            
            as $index => $memo) { ?>
            
            <div class="col-sm-3 memo-img">
                <?php if ($memo['serial_no'] == 0) { ?>
                    <img src="<?= SITE_URL . $memo['thumb'] ?>" width="300" height="214">
                <?php } else { ?>
                    <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'story', $memo['serial_no']]); ?>">
                        <img src="<?= SITE_URL . $memo['thumb'] ?>" width="300" height="214">
                    </a>
                    <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'story', $memo['serial_no']]); ?>">
                        <div class="mouse-over-box text-center ">
                            <img src="<?= SITE_URL ?>/img/collect_memo.png">
                        </div>
                    </a>
                <?php } ?>
            </div>
            <?php if (($index + 1) % 4 === 0) { ?>
        </div>
        <br/>
        <div class="row">
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

