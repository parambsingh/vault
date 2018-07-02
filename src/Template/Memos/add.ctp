<?php
echo $this->Html->css(['uploadfile']);
echo $this->Html->script(['jquery.uploadfile']);
?>

<br/><br/><br/>
<div class="row">
    <div class="col-lg-6">
        <div id="multipleFileUploader" style="display: none"></div>
        <h3 class="add-memo-heading">Select Secure</h3>
        <div class="file-upload-btn" id="fileUploadBtn">
            <div style="width: 85%; float: left">
                <h3>Add your purchased</h3>
                <h3>digital collectible here</h3>
            </div>
            <span class="right" style="color: #ffffff; font-size: 60px; margin-top: 20px; float: right"><i
                    class="fa fa-hand-pointer-o"></i></span>
            <h4>Choose single or multiples</h4>
        </div>
        <h4>Only JPG, JPEG, CELEBRIUM are supported files</h4>
        <div class="ajax-file-upload-container" id="ajaxContainer"></div>
    
    </div>
    <div class="col-lg-5">&nbsp;</div>
</div>

<div class="row">
    <div class="col-lg-12">&nbsp;</div>
</div>
<div class="row">
    <div class="col-lg-12" style="background: #eebc41; padding: 20px; display: none;">
        <h4>Result:</h4>
        <ul id="finalStatus" style="list-style: none">
        </ul>
    </div>
</div>

<div class="modal fade" id="processing" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #eebc41">
                <h5 class="modal-title" id="finalHeading">Please Wait..</h5>
            </div>
            <div class="modal-body">
                <h3 style="color: #000000;" id="mainLine"> Processing, Please wait...</h3>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#fileUploadBtn').click(function () {
            $('#ajax-upload-id').click();
        });
        
        var settings = {
            url: SITE_URL + "/memos/upload",
            method: "POST",
            allowedTypes: "jpg,jpeg,celebrium",
            fileName: "file",
            multiple: true,
            showQueueDiv: 'ajaxContainer',
            showError: true,
            dragdropWidth: '100%',
            statusBarWidth: '100%',
            showFileCounter: false,
            onSuccess: function (files, data, xhr) {
                
                var d = JSON.parse(data);
                $("#finalStatus").append("<li>" + d.message + "<li>");
                $("#finalStatus").parent().fadeIn();
                setTimeout(function () {
                   $('#processing').modal('hide');
                }, 1000);
            },
            onSelect: function (files) {
                $("#finalStatus").parent().hide();
                $("#finalStatus").html('');
                $('#processing').modal({
                    backdrop: 'static',
                    keyboard: false
                })
            },
            onError: function (files, status, errMsg) {
                $("#finalStatus").html("<font color='red'>Upload is Failed</font>");
            }
        }
        $("#multipleFileUploader").uploadFile(settings);
        
    });
</script>
