<?php $meta = json_decode($memo->meta_json, true); ?>
<div style="margin:5% 0 0 5%;">
    <p style="text-transform: none; line-height: 30px; margin: 0 0 20px 0;">
        <img src="<?= SITE_URL . $memo->thumb ?>" alt="<?=  $memo['name'] ?>" style=" display: inline;float: left;margin-right: 15px;">
        <b>Title:</b> <?= $meta['title']; ?><br>
        <b>Series:</b> <?= $meta['series_name']; ?><br>
        <b>celeb:</b> <?= $meta['artist']; ?><br>
        <b>value:</b> <br>
        <b>#Memos:</b>
    </p>
    <p style="text-transform: none; line-height: 30px; margin: 0 0 20px 0;"><?= $meta['description']; ?></p>
</div>
