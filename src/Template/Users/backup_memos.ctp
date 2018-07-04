<?php $this->assign('title', __('Backup Memos™')); ?>
<h2>Backup Memos™</h2>
<div class="row">
    <div class="col-lg-1"><img src="<?= SITE_URL ?>/img/backup-memos.png" alt="RAIDA" title="Add Memos" style="margin-top: 100px;"></div>
    <div class="col-lg-11">
        <?php if (count($memos) > 0) { ?>
            <div class="row">
                <?php foreach ($memos
                
                as $index => $memo) { ?>
                
                <div class="col-sm-3 memo-img backup-popup" id="backup_<?= $memo['serial_no'] ?>"
                     data-name="<?= $memo['name'] ?>">
                    <img src="<?= SITE_URL . $memo['thumb'] ?>" width="300" height="214">
                    <div class="mouse-over-box text-center ">
                        <img src="<?= SITE_URL ?>/img/collect_memo.png">
                    </div>
                </div>
                <?php if (($index + 1) % 4 === 0) { ?>
            </div>
        <br/>
            <div class="row">
                <?php } ?>
                <?php } ?>
            </div>
            
            <div class="modal fade" id="backupMemo" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #eebc41">
                            <h4 class="modal-title">Backup Memo™ &nbsp; <span id="finalHeading"></span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    style="margin-top: -25px">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h4 style="color: #000000;" id="mainLine">Your memo is secure in the vault, if you want to
                                take backup
                                please press backup </h4>
                            <h4 style=" color: #000000; display: none;" id="thanksLine">Thank you for backup</h4>
                        </div>
                        <div class="modal-footer" id="mainFooter">
                            <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'backup']); ?>"
                               target="_blank"
                               id="takeBackUp">
                                <button type="button" class="btn btn-secondary inner-btn" id="backupBtn">Backup</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            </a>
            
            <script>
                $(function () {
                    $('.backup-popup').click(function () {
                        var id = $(this).attr('id').split('_')[1];
                        var name = $(this).attr('data-name');
                        $('#finalHeading').html(name);
                        $('#thanksLine').hide();
                        $('#mainLine, #mainFooter').fadeIn();
                        $('#backupMemo').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        
                        $.get(SITE_URL + '/memos/add-backup/' + id);
                    });
                    
                    $('#backupBtn').click(function () {
                        $('#mainLine, #mainFooter').hide();
                        $('#thanksLine').fadeIn();
                    });
                });
            
            </script>
        
        <?php } else { ?>
            <h3>No Record Found</h3>
        <?php } ?>
    </div>
</div>
