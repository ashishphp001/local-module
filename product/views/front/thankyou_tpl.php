<?php
$add_product = $this->common_model->getUrl("pages", "2", "50", '');
?>

<div class="register-info">
    <div class="register-inner card">         
        <div class="thankyou">
            <div class="thanks-detail">
                <div class="check-thanks"><i class="fas fa-check-square"></i></div>
                <div class="thanks-info">
                    <h1>Thank You</h1>
                    <p>Awesome! You successfully added this product. It is being reviewed by our team. <br>Once completed, it will be published to your catalogue.</p>
                    <p>Want to add one more product?</p>
                    <div class="back-to-home all-same">
                        <a href="<?php echo $add_product; ?>" class="same-btn waves-effect waves-light btn">Yes, Add One More!</a>
                        <a href="<?php echo SITE_PATH; ?>" class="same-btn waves-effect waves-light btn">No, Take Me Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>