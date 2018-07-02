<div class="row">
    <?php foreach ($memos
    
    as $index => $memo) { ?>
    
    <div class="col-sm-3 memo-img">
        <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'story', $memo['serial_no']]); ?>">
            <img src="<?= SITE_URL . $memo['thumb'] ?>" width="300" height="214">
        </a>
        <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'story', $memo['serial_no']]); ?>">
        <div class="mouse-over-box text-center ">
            <img src="<?= SITE_URL ?>/img/collect_memo.png">
        </div>
        </a>
    </div>
    <?php if (($index + 1) % 4 === 0) { ?>
</div>
<br />
<div class="row">
    <?php } ?>
    <?php } ?>
</div>


