<div class="outer-content-section">
    <div class="row">
        <div class="col-lg-12"><h1 class="outer-page-heading">Reset Password</h1></div>
    </div>
    <?= $this->Form->create(null, ['id' => 'resetPasswordForm', 'class' => 'fusion-login-form']) ?>
    <div class="row">
        <div class="col-sm-5 mb-20">
            <?= $this->Form->control('password', ['type' => 'text', 'class' => 'form-control f-input', 'label' => false, 'placeholder' => 'Password']); ?>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-sm-5 mb-20">
            <?= $this->Form->control('confirm_password', ['type' => 'text', 'class' => 'form-control f-input', 'label' => false, 'placeholder' => 'Confirm Password']); ?>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-sm-5 mb-20">
            <button class="btn btn-lg btn-default outer-btn" title="Submit" id="resetPasswordBtn"><span
                    class="fusion-button-text">Submit</span></button>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    
    <div class="row">
        <div class="col-sm-5 text-center">
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
