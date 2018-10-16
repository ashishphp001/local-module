<div class="register-info">
    <div class="register-inner card">         
        <div class="thankyou">
            <div class="thanks-detail">
                <div class="check-thanks"><i class="fas fa-check-square"></i></div>
                <div class="thanks-info">
                    <?php if (RECORD_ID == '111') { ?>
                        <h1>Verification Email Sent!</h1>
                        <p>You need to verify E-mail address. It's so easy! Just click to send email link. 
                            We are simply verifying your ownership for your provided E-mail address.
                            Without verification, you will not able to use best of our services. 
                            Your profile will be on hold.</p>
                        <div class="back-to-home all-same">
                            <a href="<?php echo SITE_PATH; ?>" class="same-btn waves-effect waves-light btn">Back To Home</a>
                        </div>
                    <?php } else {
                        ?>
                        <h1>Thank you!</h1>
                        <p>We are glad to let you that know you are now verified member of <?php echo SITE_NAME; ?>. <br>Wishing you a happy selling!</p>
                        <div class="back-to-home all-same">
                            <a href="<?php echo SITE_PATH; ?>" class="same-btn waves-effect waves-light btn">Back To Home</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>