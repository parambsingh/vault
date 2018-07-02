<div class="outer-content-section">
    <div class="row">
        <div class="col-lg-12"><h1 class="outer-page-heading">Login</h1></div>
    </div>
    
    <?= $this->Form->create(null, ['id' => 'loginForm', 'class' => 'fusion-login-form']) ?>
    <div class="row">
        <div class="col-sm-5 mb-20">
            <?= $this->Form->control('email', ['type' => 'text', 'class' => 'form-control f-input', 'label' => false, 'placeholder' => 'Email']); ?>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    
    <div class="row">
        <div class="col-sm-5 mb-20">
            <?= $this->Form->control('password', ['type' => 'password', 'class' => 'form-control f-input', 'label' => false, 'placeholder' => 'Password']); ?>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-sm-5 mb-20">
            <button class="btn btn-lg btn-default outer-btn" title="LOGIN">LOGIN</button>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    
    <div class="row">
        <div class="col-sm-5 text-center">
            <a title="Don't have an account? Register!" class="outer-a"
               href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'forgot_password']); ?>">Forgot
                Password?</a>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    <br />
    
    <div class="row">
        <div class="col-sm-5 text-center">
            <a title="Don't have an account? Register!" class="outer-a"
               href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']); ?>">Don't have an
                account? Register!</a>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function () {
        
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true
                }
                
            },
            messages: {
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                },
                password: {
                    required: "Please enter password."
                }
            }
        });
        
        $(document).on("click", "#register_btn", function () {
            if ($("#loginForm").valid() == true) {
                $("#loginForm").submit();
            }
            
        });
    });
</script>
