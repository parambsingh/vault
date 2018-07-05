<?php $this->assign('title', __('Dashboard')); ?>
<div class="row">
   <!--<div class=""><img src="<?= SITE_URL ?>/img/digital-memo.png" alt="RAIDA" title="Add Memos"
                               style="margin-top: 100px;"!--></div>
    <div class="heading-dashboard">
        <div class="row">
            <?php foreach ($memos
            
            as $index => $memo) { ?>
            
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 memo-img clearfix text-center">
			<div class="container-box">
                <?php if ($memo['serial_no'] == 0) { ?>
                    <img src="<?= SITE_URL . $memo['thumb'] ?>" width="300" height="214">
                <?php } else { ?>
                    <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'story', $memo['serial_no']]); ?>">
                        <img src="<?= SITE_URL . $memo['thumb'] ?>" width="300" height="214">
                    </a>
                    <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'story', $memo['serial_no']]); ?>">
                        <!--<div class=" text-center ">
                            <img src="<?= SITE_URL ?>/img/collect_memo.png">
							</div!-->
                        
                    </a>
                <?php } ?>
				</div>
            </div>
            <?php if (($index + 1) % 3 === 0) { ?>
        </div>
        <br/>
        <div class="row">
            <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

