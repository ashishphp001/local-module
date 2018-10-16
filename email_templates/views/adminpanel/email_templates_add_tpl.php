<div class="content" id="gridbody">
    <section class="MiddleSection"> 
        <div class="spacer10"></div>
        <div class="fl"> 
            <h1>
                <b class="icon-list-ul"></b><?php echo MODULE_TITLE?>
            </h1>
        </div>
        <?php echo $messagebox ?>
        <div class="spacer10"></div>
        <div class="note-bg">
            <div class="red-note"><strong>Note:</strong>  Please do not alter text starting with @ sign in below template.</div>
        </div>
        <div class="spacer10"></div>
        <div class="main-form-box">
            <div class="contact-title">Edit <?php echo $file_name ?> [<?php echo ucwords($type) ?>]</div>
            <div class="spacer10"></div>
            <form action="<?php echo $action ?>" method="post" name="form_edit_lang">
                <input type="hidden" name="type" value="<?php echo $type ?>">
                <input type="hidden" name="file_name" value="<?php echo $file_name ?>">
                <input type="hidden" name="eid" value="<?php echo $eid ?>">
                <div class="fix_width">
                    <div class="inquiry-form">
                        <div class="fl title-w"> 
                            <div class="title-form fl">Subject</div> 
                            <!--<span class="required"></span>-->
                            <div class="clear"></div>  
                            <input type="text" class="frist-name input input-bg01" id="varSubject" value="<?php echo $subject; ?>" name="varSubject">                    
                        </div>
                        <div class="clear"></div>
                        
                        <div class="fl title-w"> 
                            <div class="title-form fl">Publish</div>
                            <div class=" fl">
                                <input type="checkbox" value="Y" id="chrPublish" name="chrPublish" <?php echo ($publish=='Y')?'checked':'' ?> >
                            </div>
                        </div>
                        <div class="clear"></div>
                        
                        <?php
                        echo $this->mylibrary->load_ckeditor1('var_description', ($content));
                        ?>
                    </div>
                </div>
                <div class="spacer10"></div>
                <!--<div class=" pos-rel"><input id="btnsaveandc" name="btnsaveandc" type="submit" class="submit" value="Save & Keep Editing"></div>-->
                <div class="pos-rel" ><input id="btnsaveande" name="btnsaveande" type="submit" class="submit" style="margin:0 0 0 10px;" value="Save & Exit"></div>
              <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                                        <div  class="btn btn-default">
                                            Cancel
                                        </div>
                                    </a>
                <div class="spacer10"></div>
            </form>
        </div>
    </section>
</div>   
