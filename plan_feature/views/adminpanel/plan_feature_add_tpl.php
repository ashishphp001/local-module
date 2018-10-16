<script type="text/javascript">

    $(document).ready(function () {
        $("#Frmplan_feature").validate({
            ignore: [],
            rules: {
                varName: {
                    required: true
                }
            },
            messages: {
                varName: {
                    required: "Please enter name."
                }
            },
            errorPlacement: function (error, element)
            {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                var Check_Session = Check_Session_Expire();
                if (Check_Session == 'N')
                {
                    var SessUserEmailId = '<?php echo USER_EMAILID; ?>'
                    SessionUpdatePopUp(SessUserEmailId);
                } else
                {
                    form.submit();
                }
            }
        });
    });
</script>
<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage plan Features</a></li>
                <li><span>
                        <?php
                        if (!empty($eid)) {
                            echo 'Edit Plan Feature - ' . $Row['varName'];
                        } else {
                            echo 'Add Plan Feature';
                        }
                        ?>
                    </span></li>
            </ul>
        </div>
       <?php
        if (validation_errors() != '') {
            echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide"><li>';
            echo validation_errors();
            echo '</li></ul></div></div>';
        }
        if ($messagebox != '') {
            echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide"><li>';
            echo $messagebox;
            echo '</li></ul></div></div>';
        }
        ?>
        <div class="uk-text-danger" style="float:right;">* Required Field</div>
        <div class="clear"></div>
        <?php
        $attributes = array('name' => 'Frmplan_feature', 'id' => 'Frmplan_feature', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
        echo form_open($action, $attributes);
        echo form_hidden('btnsaveandc_x', '');
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('eid', $Row['int_id']);
                }
                ?>
                <div class="uk-form-row">
                    <div class="uk-width-medium-1-2">
                        <label>Name *</label>
                        <?php
                        $titleBoxdata = array(
                            'name' => 'varName',
                            'id' => 'varName',
                            'value' => $Row['varName'],
                            'maxlength' => '250',
                            'class' => 'md-input'
                        );
                        echo form_input($titleBoxdata);
                        ?>
                    </div>
                </div> 
                <label class="error" for="varName"></label>
            </div>
        </div>

        <div class="md-card">
            <div class="md-card-content">
                <div class="spacer10"></div>
                <div class="inquiry-form">

                    <div class="spacer10"></div>
                    <div class="uk-form-row">
                        <div class="uk-width-medium-1-2">
                            <label>Display</label>
                            <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i></div>
                        <?php
                        if (!empty($eid)) {
                            $publishYRadio = array(
                                'name' => 'chrPublish',
                                'id' => 'chrPublishY',
                                'value' => 'Y',
                                'class' => 'form-rediobutton',
                                'checked' => ($Row['chrPublish'] == 'Y') ? TRUE : FALSE
                            );
                            echo form_input_ready($publishYRadio, 'radio');
                            ?>                                                    
                            <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishY').checked != true)
                                        document.getElementById('chrPublishY').checked = true;" href="javascript:">Yes</a>
                               <?php
                           } else {
                               $publishYRadio = array(
                                   'name' => 'chrPublish',
                                   'id' => 'chrPublishY',
                                   'value' => 'Y',
                                   'class' => 'form-rediobutton',
                                   'checked' => TRUE
                               );
                               echo form_input_ready($publishYRadio, 'radio');
                               ?>                                                    
                            <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishY').checked != true)
                                        document.getElementById('chrPublishY').checked = true;" href="javascript:">Yes</a>
                               <?php
                           }

                           if (!empty($eid)) {
                               $publishNRadio = array(
                                   'name' => 'chrPublish',
                                   'id' => 'chrPublishN',
                                   'value' => 'N',
                                   'class' => 'form-rediobutton',
                                   'checked' => ($Row['chrPublish'] == 'N') ? TRUE : FALSE
                               );
                               echo form_input_ready($publishNRadio, 'radio');
                               ?>                                                    
                            <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishN').checked != true)
                                        document.getElementById('chrPublishN').checked = true;" href="javascript:">No</a>
                               <?php
                           } else {
                               $publishNRadio = array(
                                   'name' => 'chrPublish',
                                   'id' => 'chrPublishN',
                                   'value' => 'N',
                                   'class' => 'form-rediobutton',
                                   'checked' => FALSE
                               );
                               echo form_input_ready($publishNRadio, 'radio');
                               ?>
                            <a style="text-decoration:none;" onclick="if (document.getElementById('chrPublishN').checked != true)
                                        document.getElementById('chrPublishN').checked = true;" href="javascript:">No</a>
                               <?php
                           }
                           ?>

                    </div>  
                </div>
            </div>
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-form-row">
                        <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveandc" value="btnsaveandc" id="btnsaveandc">Save &amp; Keep Editing</button>
                        <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande" id="btnsaveande">Save &amp; Exit</button>
                        <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                            <div  class="md-btn md-btn-wave">
                                Cancel
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>