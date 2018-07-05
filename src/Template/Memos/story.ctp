<?php $this->assign('title', __('Story')); ?>
<?php $meta = json_decode($memo->meta_json, true); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<?= $this->Html->css(['fancybox/jquery.fancybox-1.3.4']) ?>

<?= $this->Html->script(['fancybox/jquery.mousewheel-3.0.4.pack', 'fancybox/jquery.fancybox-1.3.4.pack']) ?>
<div class="row heading-story">
    <div class="col-lg-11 col-md-10 col-sm-11 col-xs-12" style="padding-left:6%;">
        
        <div style="">
            <p style="text-transform: none; line-height: 30px; margin: 0 0 20px 0; text">
                <a id="single_image" href="<?= SITE_URL . str_replace("small_", "large_", $memo['thumb']) ?>">
                    <img src="<?= SITE_URL . $memo['thumb'] ?>" alt="<?= $memo['name'] ?>"
                         style=" display: inline;float: left;margin-right: 15px;">
                </a>
                <b>Title:</b> <?= $meta['title']; ?><br>
                <b>Series:</b> <?= $meta['series_name']; ?><br>
                <b>celeb:</b> <?= $meta['artist']; ?><br>
                <b>Run:</b> <?= $meta['artist']; ?><br>
                <b>Class:</b> <?= $meta['rarity']; ?>
            </p>
            <p style="text-transform: none; line-height: 30px; margin: 0 0 20px 0;"><?= strip_tags($meta['description']); ?></p>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("a#single_image").fancybox({'width': '100%', 'height': '100%'});
    });
</script>
