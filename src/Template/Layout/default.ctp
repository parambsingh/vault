<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    
    <?= $this->Html->css([
        'font-awesome/css/font-awesome',
        'bootstrap.min',
        'style',
        'jquery.mobile.min',
        'jqeury.mobile.theme.min',
        'jquery.mobile.icons.min',
    ])
    ?>
    
    <?=
    $this->Html->script([
        'jquery.min.js',
        'jquery.validate.min',
        'bootstrap.js',
        'flash-message'
    ])
    ?>
    
    <script type="text/javascript">
        //var SITE_URL = '<?= $this->request->scheme() . '://' . $this->request->host() ?>';
        var SITE_URL = '<?= SITE_URL ?>';
    </script>
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<img src="<?= SITE_URL ?>/img/vault_bge.jpg" id="bg" alt="">
<div class="flach-container">
    <?= $this->Flash->render() ?>
</div>
<div id="wrapper">
    <div class="row" style="margin: 0px;">
        <div class="col-lg-1">&nbsp;</div>
        <div class="col-lg-2 text-center">
            <?= $this->element('inner-sidebar') ?>
        </div>
        <div class="col-lg-8">
            <div class="inner-header">
                <?= $this->element('inner-header') ?>
            </div>
            <div class="inner-content">
                <?= $this->fetch('content') ?>
            </div>
            <div class="inner-footer">
                <?= $this->element('inner-footer') ?>
            </div>
        </div>
    
    </div>
    <div data-role="navbar" class="ui-navbar" role="navigation">
        <ul class="ui-grid-c">
            <li class="ui-block-a">
                <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'add']); ?>" target="_parent"
                   data-icon="cloud" class="ui-link ui-btn ui-icon-cloud ui-btn-icon-top">Add</a>
            </li>
            <li class="ui-block-b">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'backupMemos']); ?>"
                   target="_parent" data-icon="grid" class="ui-link ui-btn ui-icon-grid ui-btn-icon-top">Backup</a>
            </li>
            <li class="ui-block-c">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'yourActivity']); ?>"
                   data-icon="info" target="_parent" class="ui-link ui-btn ui-icon-info ui-btn-icon-top">Activity</a>
            </li>
            <li class="ui-block-d">
                <a href="#" target="_parent" data-icon="recycle" class="ui-link ui-btn ui-icon-recycle ui-btn-icon-top">Help</a>
            </li>
        </ul>
    </div>

</div>


</body>
</html>
