
    <div class="text-center">
        <a href="<?= SITE_URL ?>">
            <img src="<?= SITE_URL ?>/img/memo_vault_1.0_logo.png" alt="<?= SITE_TITLE ?>" />
        </a>
    </div>
    <div class="memo-bank-section text-center">
        <div class="wallet_m">
            <div class="row text-center">
			
                <h3 style="color:#eebc41; font-weight:bold;">Memos™ Wallet</h3>
                <h5 ><img src="<?= SITE_URL ?>/img/cropped-fav-180x180.png" width="54" height="54" /> You Have: <span style="color:#eebc41 "><?= $memo_count ?> <sup>Memos</sup> </span></h5> 
                 <div class="row text-center">
                     <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'add']); ?>"><button class="btn btn-default inner-btn add-memo-btn">Add Memos™</button></a>
                 </div>
            </div>
        </div>
    </div>
    <!--<div class="col-lg-12">
        <a class="btn btn-default btn-lg inner-btn shop-memo-btn"  target="_blank"  href="https://www.celebrium.com/start-collecting/">SHOP MEMOS™</a>
    </div!-->

