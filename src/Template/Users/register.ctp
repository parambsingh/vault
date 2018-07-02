<div class="outer-content-section">
    <div class="row">
        <div class="col-lg-12"><h1 class="outer-page-heading">Create Account</h1></div>
    </div>
    
    <?= $this->Form->create($user, ['id'=>'registerForm', 'class'=>'fusion-login-form']) ?>
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
        <div class="col-sm-7 ">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-sm-5 mb-20">
            <?= $this->Form->control('confirm_password',['type'=>'password','class'=>'form-control f-input', 'label'=>false, 'placeholder'=>'Confirm Password']); ?>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-sm-5 mb-20">
            <button class="btn btn-lg btn-default outer-btn" title="REGISTER">REGISTER</button>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
    
    <div class="row">
        <div class="col-sm-5 text-center">
            <a title="Don't have an account? Register!"
               href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']); ?>">I
                already have an account? Login!</a>
        </div>
        <div class="col-sm-7">&nbsp;</div>
    </div>
   
    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function () {
        
        
        $("#registerForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: SITE_URL+'/users/isUniqueEmail'
                },
                password: {
                    required: true
                },
                confirm_password: {
                    required: true
                }
                
            },
            messages: {
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote:"Email already exists"
                },
                password: {
                    required: "Please enter password."
                },
                confirm_password: {
                    required: "Please confirm password."
                },
                
            }
        });
        
        $(document).on("click", "#register_btn", function () {
            if ($("#registerForm").valid() == true) {
                $("#registerForm").submit();
            }
            
        });
    });
</script>
