<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL; ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL; ?>js/validation_additional-methods.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL; ?>js/jquery.form.js"></script>

<div class="login_bg">
    <div class="login_bx">
        <h2>Member Login</h2>
        <form name="login-form" id="login-form" method="post" action="<?php echo SITE_PATH; ?>login/insert">
            <!--<input type="text" placeholder="User Name" id="user_name">-->
            <input name="varEmail" class="user-icon" id="user_name" type="text" placeholder="User Email" value="<?php echo $_REQUEST['varEmail']; ?>" maxlength="100">
            <!--<input type="text" placeholder="User Name" id="user_name" class="user-icon">-->
            <input type="password" placeholder="Password"  class="pass-icon">

            <div class="login_footer">
                <button type="submit" class="btn btn_login">Login</button>
                <a href="" class="forget_password">Forget Password ?</a>
            </div>


        </form>
    </div>
</div>