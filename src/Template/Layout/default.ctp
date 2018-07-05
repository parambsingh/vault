<!DOCTYPE html>
<html>
    <head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    <?= $this->fetch('title') ?>
    | Celebrium Memos™ Vault</title>
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
    <body class="inner_body">
<div class="flach-container">
      <?= $this->Flash->render() ?>
    </div>
<div id="wrapper">
      <div class="row">
    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 col-lg-offset-3">
          <div class="top-buttons">
        <?= $this->element('top-buttons') ?>
      </div>
        </div>
  </div>
      <div class="row">
    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 col-lg-offset-3">
          <div class="inner-header">
        <?= $this->element('inner-header') ?>
      </div>
        </div>
  </div>
      <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <?= $this->element('inner-sidebar') ?>
        </div>
    <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12" >
          <div class="inner-content">
        <?= $this->fetch('content') ?>
      </div>
        </div>
  </div>
    <div class="row">
  
  <div class="inner-footer">
        <?= $this->element('inner-footer') ?>
      </div></div>
    </div>
</div>
<div data-role="navbar" class="ui-navbar" role="navigation" style="100%;">
      <ul class="ui-grid-c">
    <li class="ui-block-a"><a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'add']); ?>"
                                  target="_parent"
                                  data-icon="plus" class="ui-link ui-btn ui-icon-plus ui-btn-icon-top">Add</a></li>
    <li class="ui-block-b"><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'backupMemos']); ?>"
                                  target="_parent" data-icon="cloud" class="ui-link ui-btn ui-icon-cloud ui-btn-icon-top">Backup</a> </li>
    <li class="ui-block-c"><a
                href="<?= $this->Url->build(['controller' => 'Activities', 'action' => 'index']); ?>"
                data-icon="grid" target="_parent" class="ui-link ui-btn ui-icon-grid ui-btn-icon-top">Activity</a></li>
    <li class="ui-block-d"><a href="https://www.celebrium.com/contact/" target="_parent" data-icon="info"
                                  class="ui-link ui-btn ui-icon-info ui-btn-icon-top">Help</a></li>
  </ul>
    </div>
</body>
</html>
