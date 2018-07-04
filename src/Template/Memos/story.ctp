<?php $this->assign('title', __('Story')); ?>
<?php $meta = json_decode($memo->meta_json, true); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<?= $this->Html->css(['fancybox/jquery.fancybox-1.3.4']) ?>

<?= $this->Html->script(['fancybox/jquery.mousewheel-3.0.4.pack', 'fancybox/jquery.fancybox-1.3.4.pack']) ?>


<div style="margin:5% 0 0 5%;">
    <p style="text-transform: none; line-height: 30px; margin: 0 0 20px 0;">
        <a id="single_image" href="<?= SITE_URL . $memo['file'] ?>">
            <img src="<?= SITE_URL . $memo->thumb ?>" alt="<?= $memo['name'] ?>"
                 style=" display: inline;float: left;margin-right: 15px;">
        </a>
        <b>Title:</b> <?= $meta['title']; ?><br>
        <b>Series:</b> <?= $meta['series_name']; ?><br>
        <b>celeb:</b> <?= $meta['artist']; ?><br>
        <b>value:</b> <br>
        <b>#Memos:</b>
    </p>
    <p style="text-transform: none; line-height: 30px; margin: 0 0 20px 0;"><?= $meta['description']; ?></p>
</div>

<script>
    $(document).ready(function () {
        $("a#single_image").fancybox({ 'width':'75%', 'height': '75%'});
    });
</script>
