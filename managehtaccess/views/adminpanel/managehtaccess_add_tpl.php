<div class="content">
       <!--start middle section-->
    <section class="MiddleSection"> 
        <div class="spacer10"></div>
        <div class="fl"> 
            <h1>
                <b class="icon-list-ul"></b>
                <?php echo "Manage Htaccess File"; ?>
            </h1>
        </div>
        <?php echo  $messagebox ?>
    <div class="spacer10"></div>
    <form action="<?php echo $action ?>" method="post" name="form_edit_lang" class="enquiry_form">   
                <input type="hidden" name="type" value="<?php echo $type ?>">
                <input type="hidden" name="file_name" value="constants_old.php">
        <div class="main-form-box">
            <div class="contact-title">Manage Htaccess File</div>
            <div class="spacer10"></div>
            <div class="fix_width">
                    <div class="inquiry-form">
                        <textarea value="" id="file_content" class="textarea" rows="15" cols="171" name="file_content" gramm="" txt_gramm_id="8ab2a22d-92bc-7b00-4e5b-d5999fc463a1" spellcheck="true" style="overflow: visible; height:350px;"><?php echo $content;?></textarea>
                    </div>
                <div class="spacer10"></div>
            </div>
            <div class="spacer10"></div>
            <div class=" pos-rel"><input id="btnsaveande" name="btnsaveande" type="submit" class="submit" value="Save & Exit"></div>
            <div class="submit-btn"><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Cancel</a></div>
            <div class="spacer10"></div>
        </div>
    </form>
    </section>
    <!--end middle section--> 
</div>     