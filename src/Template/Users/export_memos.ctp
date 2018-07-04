<?php $this->assign('title', __('Export Memos™')); ?>
<h2>Export Memos™</h2>
<div class="row">
    <?php foreach ($memos as $index => $memo) { ?>
    
    <div class="col-sm-3 memo-img export-popup" id="export_<?= $memo['serial_no'] ?>" data-name="<?= $memo['name'] ?>">
        <img src="<?= SITE_URL . $memo['thumb'] ?>" width="300" height="214">
        <div class="mouse-over-box text-center ">
            <img src="<?= SITE_URL ?>/img/collect_memo.png">
        </div>
    </div>
    <?php if (($index +1) % 4 === 0) { ?>
</div>
<br />
<div class="row">
    <?php } ?>
    <?php } ?>
</div>

<div class="modal fade" id="exportMemo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #eebc41">
                <h4 class="modal-title">Backup Memo™ &nbsp; <span id="finalHeading"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 style="color: #000000;" id="mainLine">Your memo is secure in the vault, if you want to export it
                    please press export </h4>
                <h4 style=" color: #000000; display: none;" id="thanksLine">Thank you for export</h4>
            </div>
            <div class="modal-footer" id="mainFooter">
                <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'export']); ?>" target="_blank"
                   id="takeBackUp">
                    <button type="button" class="btn btn-secondary inner-btn" id="exportBtn">Export</button>
                </a>
            </div>
        </div>
    </div>
</div>

</a>

<script>
    $(function () {
        var id = 0;
        $('.export-popup').click(function () {
            id = $(this).attr('id').split('_')[1];
            var name = $(this).attr('data-name');
            $('#finalHeading').html(name);
            $('#thanksLine').hide();
            $('#mainLine, #mainFooter').fadeIn();
            $('#exportMemo').modal({
                backdrop: 'static',
                keyboard: false
            });
            
            $.get(SITE_URL + '/memos/add-export/' + id);
        });
        
        $('#exportBtn').click(function () {
            $('#mainLine, #mainFooter').hide();
            $('#thanksLine').fadeIn();
            $('#export_'+id).fadeIn().remove();
        });
    });

</script>
