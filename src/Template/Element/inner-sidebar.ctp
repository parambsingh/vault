<div class="row">
    <div class="col-lg-12 inner-logo">
        <a href="<?= SITE_URL ?>">
            <img src="<?= SITE_URL ?>/img/memo_vault_1.0_logo.png" alt="<?= SITE_TITLE ?>" />
        </a>
    </div>
    <div class="col-lg-12 memo-bank-section">
        <div style="width: 240px; height: 300px; background-color: #000000; opacity: 0.70; padding: 20px; margin: 0px; ">
            <div class="row">
                <div class="col-sm-12"><p style="color: #eebc41; font-size: 20px; font-weight: bold;">Memos™ Bank</p></div>
                <div class="col-sm-12"><img src="<?= SITE_URL ?>/img/cropped-fav-180x180.png" width="140" height="140" /></div>
                <div class="col-sm-12" style="font-weight: bold;"><h5 style="color: #eebc41; width: 120px; float: left">You Have:</h5> <span style="color: #FFFFFF; width: 70px; float: left;  margin: 5px 0 0 0;"><?= $memo_count ?> Memos</span> </div>
                 <div class="col-sm-12">
                     <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'add']); ?>"><button class="btn btn-default inner-btn add-memo-btn">Add Memos™</button></a>
                 </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <a class="btn btn-default btn-lg inner-btn shop-memo-btn"  target="_blank"  href="https://www.celebrium.com/start-collecting/">SHOP MEMOS™</a>
    </div>
</div>
