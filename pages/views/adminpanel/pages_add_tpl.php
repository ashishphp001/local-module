<script type="text/javascript">

<?php if (empty($eid)) { ?>
        $(document).ready(function ()
        {
        CountLeft(document.FrmPages.varMetaTitle, document.FrmPages.metatitle_left, 200);
        CountLeft(document.FrmPages.varMetaDescription, document.FrmPages.metadescription_left, 400);
        CountLeft(document.FrmPages.varMetaKeyword, document.FrmPages.metakeyword_left, 200);
        });
        function getchanged()
        {
        var Title = document.getElementById("varTitle").value;
        //        alert(Title);
        document.getElementById("varMetaTitle").value = Title;
        document.getElementById("varMetaKeyword").value = Title;
        CountLeft(document.FrmPages.varMetaTitle, document.FrmPages.metatitle_left, 200);
        CountLeft(document.FrmPages.varMetaKeyword, document.FrmPages.metakeyword_left, 200);
        }
<?php } ?>
    /* Script for auto alias generate */
    $(document).ready(function ()
    {
    $('#varAlias').bind("cut copy paste", function (e)
    {
    e.preventDefault();
    });
    });
    function quickedit(Action)
    {
    var url = "<?php echo SITE_PATH ?>" + $("#varAlias").val();
    Quick_Edit_Alias_Ajax(Action, url, 'varTitle', encodeURIComponent('<?php echo $eid ?>'), encodeURIComponent('2'), '<?php echo COMMON_ALIAS_EXISTS_MSG ?>');
    }

</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#dt_tableExport').dataTable();
    });
    $(document).ready(function()
    {

    $.validator.addMethod("alphanumeric", function(value, element) {
    if (value.replace(/[^A-Z]/gi, "").length >= 2) {
    return true;
    } else if (value.replace(/[^0-9]/gi, "").length >= 2) {
    return true;
    } else {
    return false;
    }

    }, "Please enter atleast 2 characters.");
    // Validate signup form
    $(":hidden").addClass("ignore");
    $("#intDisplayOrder").removeClass("ignore");
    $("#FrmPages").validate({
    ignore:[],
            rules: {
<?php if ($eid == '') { ?>
                fk_ParentPageGlCode: "required",
<?php } ?>
            varTitle: {
            required:true,
                    alphanumeric:true
            },
                    varAlias: {
                    required:<?php echo ($alias_validation) ? 'true' : 'false'; ?>,
                            minlength: 2
                    },
                    txtDescription: {
                    required:false
                    },
                    btnsaveandc_x: {
                    required:false
                    },
                    chrMenuDisplay:{
                    required:false
                    }
            ,
                    varMetaTitle:{
                    required:false
                    },
                    varMetaDescription:{
                    required:false
                    },
                    varMetaKeyword:{
                    required:false
                    },
                    hidvarMetaTitle:{
                    required:false
                    },
                    hidvarMetaDescription:{
                    required:false
                    },
<?php
if ($eid != '1' && $Row_Pages['fk_ParentPageGlCode'] == '0') {
    ?>
                intDisplayOrder: {
                displayorder: ['intDisplayOrder'],
                        min: 2
                }
<?php } else { ?>
                intDisplayOrder: {
                displayorder: ['intDisplayOrder']
                }
<?php } ?>

            },
            messages: {
            fk_ParentPageGlCode: '<div class="uk-text-danger"><?php echo PAGES_PARENT_SELECT ?></div>',
                    varTitle:{
                    required: '<div class="uk-text-danger"><?php echo PAGES_TITLE_MSG ?></div>'
                    },
                    varAlias: {
                    required: '<div class="uk-text-danger"><?php echo COMMON_ALIAS_MSG ?></div>',
                            minlength : "<div class='uk-text-danger'>" + ALIAS_LIMIT + "</div>"
                    },
                    intDisplayOrder: {
                    required: GLOBAL_PROPER_DISPLAY_ORDER
                    }
            },
            submitHandler: function(form)
            {
            var Check_Session = Check_Session_Expire();
            if (Check_Session == 'N')
            {
            var SessUserEmailId = '<?php echo USER_EMAILID; ?>'
                    SessionUpdatePopUp(SessUserEmailId);
            }
            else
            {
<?php if ($alias_validation) { ?>

                if (!CheckingAlias('varAlias', '<?php echo $eid; ?>', '<?php echo (MODULE_ID) ?>', '<?php echo MODULE ?>'))
                {
                return false;
                }
                else
                {
                form.submit();
                }
<?php } else { ?>
                form.submit();
<?php } ?>
            }
            }
    });
    });</script>


<div id="page_content_inner">
    <div id="page_content">
        <div id="top_bar">
            <ul id="breadcrumbs">
                <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                <li><a href="<?php echo MODULE_PAGE_NAME; ?>">Manage Page</a></li>
                <li><span> <?php
                        if (!empty($eid)) {
                            echo 'Edit Page - ' . $Row_Pages['varTitle'];
                        } else {
                            echo "Add Page";
                        }
                        ?></span></li>
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
        $attributes = array('name' => 'FrmPages', 'id' => 'FrmPages', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');

        echo form_open($action, $attributes);
        ?>
        <div class="md-card">
            <div class="md-card-content">
                <?php
                echo form_hidden('btnsaveandc_x', '');
                if (!empty($eid)) {
                    echo form_hidden('ehintglcode', $eid);
                    echo form_hidden('Hidfk_ParentPageGlCode', $Row_Pages['fk_ParentPageGlCode']);

                    echo form_hidden('Alias_Id', $Row_Pages['Alias_Id']);
                    echo form_hidden('eid', $Row_Pages['int_id']);
                    echo form_hidden('Hid_varAlias', $Row_Pages['varAlias']);

                    echo form_hidden('Old_DisplayOrder', $Row_Pages['intDisplayOrder'], '', 'id="Old_DisplayOrder"');
                    echo form_hidden('Old_fk_ParentPageGlCode', $Row_Pages['fk_ParentPageGlCode'], '', 'id="Old_fk_ParentPageGlCode"');

                    echo form_hidden('Hid_chrFooterDisplay', $Row_Pages['chrFooterDisplay']);

                    echo form_hidden('Hid_chrDescriptionDisplay', $Row_Pages['chrDescriptionDisplay']);
                }
                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-large-1-2">
                        <?php if (ADMIN_ID == 1) { ?>
                            <div class="md-card-content">
                                <label>Module</label><span class="required"></span>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-large">
                                        <?php echo $module_combo; ?>
                                    </div> 
                                </div> 
                            </div> 
                            <?php
                        } else {
                            if (!empty($Row_Pages['fk_ModuleGlCode'])) {
                                $fk_module = $Row_Pages['fk_ModuleGlCode'];
                            } else {
                                $fk_module = '2';
                            }
                            ?>
                            <input type="hidden" name="fk_ModuleGlCode" value="<?php echo $fk_module; ?>">
                        <?php } ?>
                    </div> 
                    <?php if ($eid != 1) { ?>
                        <div class="uk-width-large-1-2">
                            <label>Parent Page</label><span class="required"></span>
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-large">
                                    <?php echo $pagetree; ?>
                                </div>
                            </div> 
                        </div> 

                    <?php } else { ?>
                        <input type="hidden" name="fk_ParentPageGlCode" value=<?php echo $Row_Pages['fk_ParentPageGlCode']; ?>>

                    <?php } ?>

                </div> 
                <div class="uk-form-row">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <label>Page Title</label>
                            <?php
                            if (!empty($eid)) {
                                $EditAlias = "Y";
                            } else {
                                $EditAlias = "N";
                            }
                            $titleBoxdata = array(
                                'name' => 'varTitle',
                                'id' => 'varTitle',
                                'value' => $Row_Pages['varTitle'],
                                'maxlength' => '100',
                                'onkeyup' => 'getchanged()',
//                                'required' => '',
                                'onblur' => "Auto_Alias('" . $EditAlias . "',this.id,'" . base64_encode($eid) . "','" . base64_encode(MODULE_ID) . "','N');",
                                'class' => 'md-input'
                            );
                            echo form_input($titleBoxdata);
                            ?>
                            <label class="error" for="varTitle"></label>
                        </div>
                    </div>
                </div>

                <div class="uk-form-row">

                    <?php
                    $param = array(
                        "name" => "varAlias",
                        'value' => set_value('varAlias', $Row_Pages['varAlias']),
                        "linkEvent" => 'onclick="CheckingAlias(\'varAlias\',\'' . base64_encode($Row_Pages['varAlias']) . '\',\'' . base64_encode(MODULE_ID) . '\',\'' . MODULE . '\')"',
                        "eid" => $eid
                    );
                    echo $aliaText = $this->mylibrary->Alias_Textbox($param);
                    ?>
                </div>

                <div class="uk-form-row">
                    <label>Description</label>
                    <?php
                    $value = (!empty($eid) ? $Row_Pages['txtDescription'] : '');
                    echo $this->mylibrary->load_ckeditor('txtDescription', $this->mylibrary->Replace_Varible_with_Sitepath($value), '100%', '200px', 'Basic');
                    ?>
                </div>

                <div class="uk-form-row">
                    <?php
                    if (empty($eid)) {
                        $Sitechecked = true;
                    } else {
                        $Sitechecked = ($Row_Pages['chrDescriptionDisplay'] == 'Y') ? "checked" : "";
                    }
                    ?>
                    <label for="chrDescriptionDisplay" class="inline-label">Display Description</label>
                    <input <?php echo $Sitechecked; ?> type="checkbox" name="chrDescriptionDisplay" id="chrDescriptionDisplay" data-md-icheck />
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display description of the page. Otherwise please select 'No'" ?>">help</i>
                </div>

                <div class="uk-form-row">
                    <?php
                    if (empty($eid)) {
                        $checked = true;
                    } else {
                        $checked = ($Row_Pages['chrMenuDisplay'] == 'Y') ? "checked" : "";
                    }
                    ?>
                    <label for="chrMenuDisplay" class="inline-label">Display in Menu</label>
                    <input <?php echo $checked; ?> type="checkbox" name="chrMenuDisplay" id="chrMenuDisplay" data-md-icheck />
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display this record in menu of website. Otherwise please select 'No'"; ?>">help</i>
                </div>

                <div class="uk-form-row">
                    <?php
                    if (empty($eid)) {
                        $Footerchecked = true;
                    } else {
                        $Footerchecked = ($Row_Pages['chrFooterDisplay'] == 'Y') ? "checked" : "";
                    }
                    ?>
                    <label for="chrFooterDisplay" class="inline-label">Display in Footer</label>
                    <input <?php echo $Footerchecked; ?> type="checkbox" name="chrFooterDisplay" id="chrMenuDisplay" data-md-icheck />
                    <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display this record in footer menu of website. Otherwise please select 'No'"; ?>">help</i>
                </div>
            </div>
        </div>


        <div class="md-card">
            <div class="md-card-content">  <?php
                $val_metatitle = (!empty($eid) ? ($Row_Pages['varMetaTitle']) : '');
                $val_metakeyword = (!empty($eid) ? ($Row_Pages['varMetaKeyword']) : '');
                $val_metadescription = (!empty($eid) ? ($Row_Pages['varMetaDescription']) : '');
                $param = array("varMetaTitle" => $val_metatitle, "varMetaKeyword" => $val_metakeyword, "varMetaDescription" => $val_metadescription);
                echo $this->mylibrary->seo_textdetails($param, '', $this->module_url, 'FrmPages');

                $DisplayInfoDivDisplay = 'style="display:none;"';
                $Displayinfo_Plus_Minus = 'plus';
                if (!empty($eid)) {
                    $DisplayInfoDivDisplay = '';
                    $Displayinfo_Plus_Minus = 'minus';
                }
                ?>  
            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">
                <?php if ($eid == 1) { ?>
                    <input type="hidden" name="intDisplayOrder" value=<?php echo $Row_Pages['intDisplayOrder']; ?>>
                    <?php
                } else {
                    ?>
                    <div class="inquiry-form">
                        <div class="uk-width-large-1-3">
                            <label>Display Order</label>
                            <?php if ($eid != 1 && $Row_Pages['fk_ParentPageGlCode'] == 0) { ?>
                                <input type="text" class="md-input" name="intDisplayOrder" id="intDisplayOrder" value="<?php echo (!empty($eid) ? $Row_Pages['intDisplayOrder'] : '2'); ?>" onkeypress="return KeycheckOnlyNumeric(event);"/>
                            <?php } else {
                                ?>
                                <input type="text" class="md-input" name="intDisplayOrder" id="intDisplayOrder" value="<?php echo (!empty($eid) ? $Row_Pages['intDisplayOrder'] : '2'); ?>" onkeypress="return KeycheckOnlyNumeric(event);"/>
                            <?php } ?>
                        </div>
                        <?php
                        if ($CountChild > 0 || $Row_Pages['Noofrows'] > 0 || $Row_Pages['TotalPage'] > 0 || $Row_Pages['int_id'] == '1' || $Row_Pages['fk_ModuleGlCode'] > 2) {
                            $style = 'style="display:none"';
                        } else {
                            $style = '';
                        }
                        ?>
                        <div class="spacer10"></div>
                        <div <?= $style; ?>> 
                            <label>Display</label> 
                            <i class="material-icons" data-uk-tooltip="{cls:'long-text'}" title="<?php echo "Note: Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'"; ?>">help</i>
                            <?php
                            if (!empty($eid)) {
                                $publishYRadio = array(
                                    'name' => 'chrPublish',
                                    'id' => 'chrPublishY',
                                    'value' => 'Y',
                                    'class' => 'data-md-icheck',
                                    'checked' => ($Row_Pages['chrPublish'] == 'Y') ? TRUE : FALSE
                                );
                                echo form_input_ready($publishYRadio, 'radio');
                                ?>                                                    
                                <label for="chrPublishY" class="inline-label" onclick="if (document.getElementById('chrPublishY').checked != true)
                                                    document.getElementById('chrPublishY').checked = true;">Yes</label>
                                       <?php
                                   } else {
                                       $publishYRadio = array(
                                           'name' => 'chrPublish',
                                           'id' => 'chrPublishY',
                                           'value' => 'Y',
                                           'class' => 'data-md-icheck',
                                           'checked' => TRUE
                                       );
                                       echo form_input_ready($publishYRadio, 'radio');
                                       ?>                                                    
                                <label for="chrPublishY" class="inline-label" onclick="if (document.getElementById('chrPublishY').checked != true)
                                                    document.getElementById('chrPublishY').checked = true;">Yes</label>
                                       <?php
                                   }

                                   if (!empty($eid)) {
                                       $publishNRadio = array(
                                           'name' => 'chrPublish',
                                           'id' => 'chrPublishN',
                                           'value' => 'N',
                                           'class' => 'data-md-icheck',
                                           'checked' => ($Row_Pages['chrPublish'] == 'N') ? TRUE : FALSE
                                       );
                                       echo form_input_ready($publishNRadio, 'radio');
                                       ?>  
                                <label for="chrPublishN" class="inline-label" onclick="if (document.getElementById('chrPublishN').checked != true)
                                                    document.getElementById('chrPublishN').checked = true;" >No</label>
                                       <?php
                                   } else {
                                       $publishNRadio = array(
                                           'name' => 'chrPublish',
                                           'id' => 'chrPublishN',
                                           'value' => 'N',
                                           'class' => 'data-md-icheck',
                                           'checked' => FALSE
                                       );
                                       echo form_input_ready($publishNRadio, 'radio');
                                       ?>
                                <label for="chrPublishN" class="inline-label" onclick="if (document.getElementById('chrPublishN').checked != true)
                                                    document.getElementById('chrPublishN').checked = true;">No</label>
                                       <?php
                                   }
                                   ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-form-row">
                            <button class="md-btn md-btn-primary md-btn-wave-light" value="btnsaveandc" name="btnsaveandc" id="btnsaveandc">Save &amp; Keep Editing</button>
                            <button class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande" id="btnsaveande">Save &amp; Exit</button>
                            <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                                <div  class="md-btn md-btn-wave">
                                    Cancel
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>      
        </div> 
        <?php echo form_close(); ?>
    </div>      
</div>    