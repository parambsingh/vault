<?php $this->assign('title', __('Forgot Password')); ?>
<div class="outer-content-section">
    <div class="row">
        <div class="col-lg-5">
            <h1 class="outer-page-heading">Forgot Password</h1>
            <p class="main-instruction" style="color: #ffffff">Registered Email Address</p>
        </div>
    </div>
    <?= $this->Form->create(null, ['id' => 'forgotPasswordForm', 'class' => 'fusion-login-form']) ?>
    <div class="row">
        <div class="col-lg-8">
            <?= $this->Form->control('email', ['type' => 'text', 'class' => 'form-control f-input', 'label' => false, 'placeholder' => 'EMAIL']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8" style="margin-top:10px;">
            <button class="btn btn-lg btn-default outer-btn" title="Submit" id="resetPasswordBtn"><span
                    class="fusion-button-text">RESET PASSWORD</span></button>
            <div class="col-sm-7">&nbsp;</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <a title="Login" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']); ?>">Login</a>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    <?= $this->Form->end() ?>
</div>
<script>
    $(document).ready(function () {
        
        $("#forgotPasswordForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                }
                
            },
            messages: {
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: SITE_URL + "/users/forgot-password-api",
                    type: "POST",
                    data: $("#forgotPasswordForm").serialize(),
                    dataType: "json",
                    success: function (response) {
                        if (response.code == 200) {
                            $('.login-input-row').html('<h3>' + response.message + '</h3>');
                            $('#resetPasswordBtn, .main-instruction').remove();
                        } else {
                            $().showFlashMessage("error", response.message);
                            $('#resetPasswordBtn').button('<Reset Password <em></em>');
                        }
                    },
                    complete: function () {
                    }
                });
                
                $('#resetPasswordBtn').button('loading');
                $("#forgotPasswordForm").find(":input").filter(function () {
                    return !this.value;
                }).attr("disabled", "disabled");
                
                return false;
            }
        });
        
        $(document).on("click", "#register_btn", function () {
            if ($("#forgotPasswordForm").valid() == true) {
                $("#forgotPasswordForm").submit();
            }
            
        });
    });
</script>
