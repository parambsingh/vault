<!DOCTYPE html>
<html>
    <head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Celebrium Memos™ Vault | 
    <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css([
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
<!--img src="<?= SITE_URL ?>/img/vault_bge.jpg" id="bg" alt=""> !-->
<div class="flach-container">
      <?= $this->Flash->render() ?>
    </div>

<div id="wrapper">
      <div class="row">
    <div class="col-lg-12">
          <div class="header-login"></div>
        </div>
  </div>
      <div class="row">
		<div class="col-lg-4 col-md-5 col-sm-8 col-xs-12 col-lg-offset-1  text-center">
          <div class="outer-logo"> <a href="<?= SITE_URL ?>"> <img src="<?= SITE_URL ?>/img/memo_vault_1.0_logo.png" alt="<?= SITE_TITLE ?>"
                         title="<?= SITE_TITLE ?>"/> </a> </div>


        </div>
    <div class="col-lg-6 col-md-10 col-sm-10 col-xs-12 col-lg-offset-1">
          <?= $this->fetch('content') ?>
        </div>
  </div>
      <div class="row">
    <div class="col-lg-12">

          <div class="outer-bottom-logo">
             <div class="row">
			    <div class="col-lg-7"></div>
    <div class="col-lg-5">
          <img src="<?= SITE_URL ?>/img/logo.png" alt="<?= SITE_TITLE ?>" title="<?= SITE_TITLE ?>"/>
          </div>
           </div>
        </div>
  </div>
    </div>

</body>
</html>
