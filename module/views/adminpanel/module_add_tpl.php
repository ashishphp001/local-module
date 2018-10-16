<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#moduleform").validate({
            ignore: [],
            rules:
                    {
                        varModuleName: {
                            required: true
                        },
                        varTitle: {
                            required: true
                        },
                        varHeaderText: {
                            required: true
                        }
                    },
            messages:
                    {
                        varModuleName: {
                            required: Module_Name_Error
                        },
                        varTitle: {
                            required: Module_Title_Error
                        },
                        varHeaderText: {
                            required: Module_HeaderText_Error
                        }
                    }
        });
    });

</script>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <b class="icon-list-ul"></b>

            <?php if (!empty($eid)) { ?>
                Edit Module
            <?php } else { ?>
                Add Module
            <?php } ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">
                <?php
                echo '
                    <a class="fr Editable-btn" href="' . MODULE_PAGE_NAME . '">
                <span><b class="icon-caret-left"></b>Manage Blogs</span>
            </a>';
                ?>
            </li>
        </ol>
    </section>     
    <div class="spacer10"></div>
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
        ?>  <?php
    if (validation_errors() != '') {
        echo '
            <div class="dverrorcustom">
                <ul style="list-style-type: none;">' . validation_errors() . '<ul>
            </div><div class="spacer10"></div>';
    }
    if ($messagebox != '') {
        echo $messagebox;
        echo '<div class="spacer10"></div>';
    }
    /* Form Open */
    $Attributes = array("method" => "POST", "name" => "moduleform", "id" => "moduleform");
    echo form_open($action, $Attributes);
    /* Form Open End */

    /* Define All Hidden */
    $HiddenArray = array("ehintglcode" => $eid,
        "old_displayorder" => $Row['intDisplayOrder'],
        "hidden_chrPublish" => $Row['chrPublish']
    );
    echo form_hidden($HiddenArray);
    /* Hidden End */
    ?>
    <div class="main-form-box">
        <!-- general info -->
        <div class="contact-title" onclick="javascript:expandcollapsepanel('moduleinformation');">Module Information</div>
        <div class="spacer10"></div>
        <div class="fix_width" id="moduleinformation">
            <div class="inquiry-form">

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label> Parent Module</label>
                        <?php echo $SubMenuType; ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label> Module Title</label><span class="required"></span>
                        <?php
                        $ModuleNameBoxdata = array(
                            'name' => 'varModuleName',
                            'id' => 'varModuleName',
                            'maxlength' => '255',
                            'class' => 'form-control',
                            'value' => set_value('varModuleName', $Row['varModuleName']),
                            'extraDataInTD' => '<label for="varModuleName" class="error"></label>'
                        );
                        echo form_input_ready($ModuleNameBoxdata);
                        echo form_error('varModuleName', '<label class="error">', '</label>');
                        ?>

                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label> Module Name</label><span class="required"></span>
                        <?php
                        $ModuleTitleBoxdata = array(
                            'name' => 'varTitle',
                            'id' => 'varTitle',
                            'maxlength' => '255',
                            'class' => 'form-control',
                            'value' => set_value('varTitle', $Row['varTitle']),
                            'extraDataInTD' => '<label for="varTitle" class="error"></label>'
                        );
                        echo form_input_ready($ModuleTitleBoxdata);
                        echo form_error('varTitle', '<label class="error">', '</label>');
                        ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label> Header Class Name</label>
                        <?php
                        $HeaderClassBoxdata = array(
                            'name' => 'varHeaderClass',
                            'id' => 'varHeaderClass',
                            'maxlength' => '255',
                            'class' => 'form-control',
                            'value' => set_value('varHeaderClass', htmlspecialchars($Row['varHeaderClass'])),
                            'extraDataInTD' => '<label for="varHeaderClass" class="error"></label>'
                        );
                        echo form_input_ready($HeaderClassBoxdata);
                        echo form_error('varHeaderClass', '<label class="error">', '</label>');
                        ?>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label> Header Text Name</label><span class="required"></span>
                        <?php
                        $HeaderTextBoxdata = array(
                            'name' => 'varHeaderText',
                            'id' => 'varHeaderText',
                            'maxlength' => '255',
                            'class' => 'form-control',
                            'value' => set_value('varHeaderText', htmlspecialchars($Row['varHeaderText'])),
                            'extraDataInTD' => '<label for="varHeaderText" class="error"></label>'
                        );
                        echo form_input_ready($HeaderTextBoxdata);
                        echo form_error('varHeaderText', '<label class="error">', '</label>');
                        ?>

                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label> Table Name</label>
                        <?php
                        $ModuleTableNameBoxdata = array(
                            'name' => 'varTableName',
                            'id' => 'varTableName',
                            'maxlength' => '255',
                            'class' => 'form-control',
                            'value' => set_value('varTableName', htmlspecialchars($Row['varTableName'])),
                            'extraDataInTD' => '<label for="varTableName" class="error"></label>'
                        );
                        echo form_input_ready($ModuleTableNameBoxdata);
                        ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label> Module Listing Title</label>
                        <?php
                        $ListingBoxdata = array(
                            'name' => 'varActionListing',
                            'id' => 'varActionListing',
                            'maxlength' => '255',
                            'class' => 'form-control',
                            'value' => set_value('varActionListing', htmlspecialchars($Row['varActionListing'])),
                            'extraDataInTD' => '<label for="varActionListing" class="error"></label>'
                        );
                        echo form_input_ready($ListingBoxdata);
                        echo form_error('varActionListing', '<label class="error">', '</label>');
                        ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>Module Add Form Title</label>
                        <?php
                        $ModuleFormBoxdata = array(
                            'name' => 'varActionAdd',
                            'id' => 'varActionAdd',
                            'maxlength' => '255',
                            'class' => 'form-control',
                            'value' => set_value('varActionAdd', htmlspecialchars($Row['varActionAdd'])),
                            'extraDataInTD' => '<label for="varActionAdd" class="error"></label>'
                        );
                        echo form_input_ready($ModuleFormBoxdata);
                        echo form_error('varActionAdd', '<label class="error">', '</label>');
                        ?>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Module Add Form Title: </label>
                        <?php
                        if (empty($eid)) {
                            $AdminPanelModuleYes = TRUE;
                            $AdminPanelModuleNO = False;
                        } else if ($Row['chrAdminPanel'] == 'Y') {
                            $AdminPanelModuleYes = TRUE;
                            $AdminPanelModuleNO = FALSE;
                        } else {
                            $AdminPanelModuleYes = FALSE;
                            $AdminPanelModuleNO = TRUE;
                        }

                        $PPCheckBox_YesData = array("name" => "chrAdminPanel",
                            "id" => "chrAdminPanelY",
                            "value" => "Y",
                            "checked" => $AdminPanelModuleYes);
                        echo form_radio($PPCheckBox_YesData) . "<label for='chrAdminPanelY'> Yes</label>";

                        $PPCheckBox_NoData = array("name" => "chrAdminPanel",
                            "id" => "chrAdminPanelN",
                            "value" => "N",
                            "checked" => $AdminPanelModuleNO);
                        echo form_radio($PPCheckBox_NoData) . "<label for='chrAdminPanelN'> No</labe>";
                        ?>

                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Show In Menu:</label>
                        <?php
                        if (empty($eid)) {
                            $MenuYes = TRUE;
                            $MenuNO = False;
                        } else if ($Row['chrMenu'] == 'Y') {
                            $MenuYes = TRUE;
                            $MenuNO = FALSE;
                        } else {
                            $MenuYes = FALSE;
                            $MenuNO = TRUE;
                        }

                        $MenuBox_YesData = array("name" => "chrMenu",
                            "id" => "chrMenuY",
                            "value" => "Y",
                            "checked" => $MenuYes);
                        echo form_radio($MenuBox_YesData) . "<label for='chrMenuY'> Yes</label>";

                        $MenuBox_NoData = array("name" => "chrMenu",
                            "id" => "chrMenuN",
                            "value" => "N",
                            "checked" => $MenuNO);
                        echo form_radio($MenuBox_NoData) . "<label for='chrMenuN'> No</labe>";
                        ?>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Show In Group Access:</label>
                        <?php
                        if (empty($eid)) {
                            $AccessModuleYes = TRUE;
                            $AccessModuleNO = False;
                        } else if ($Row['chrDisplayAccess'] == 'Y') {
                            $AccessModuleYes = TRUE;
                            $AccessModuleNO = FALSE;
                        } else {
                            $AccessModuleYes = FALSE;
                            $AccessModuleNO = TRUE;
                        }

                        $GroupBox_YesData = array("name" => "chrDisplayAccess",
                            "id" => "chrDisplayAccessY",
                            "value" => "Y",
                            "checked" => $AccessModuleYes);
                        echo form_radio($GroupBox_YesData) . "<label for='chrDisplayAccessY'> Yes</label>";

                        $GroupBox_NoData = array("name" => "chrDisplayAccess",
                            "id" => "chrDisplayAccessN",
                            "value" => "N",
                            "checked" => $AccessModuleNO);
                        echo form_radio($GroupBox_NoData) . "<label for='chrDisplayAccessN'> No</labe>";
                        ?>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Show In Trashmanager and Logmanager (display in client login):</label>
                        <?php
                        if (empty($eid)) {
                            $TrashModuleYes = TRUE;
                            $TrashModuleNO = False;
                        } else if ($Row['chrDisplayTrash'] == 'Y') {
                            $TrashModuleYes = TRUE;
                            $TrashModuleNO = FALSE;
                        } else {
                            $TrashModuleYes = FALSE;
                            $TrashModuleNO = TRUE;
                        }

                        $TrashBox_YesData = array("name" => "chrDisplayTrash",
                            "id" => "chrDisplayTrashY",
                            "value" => "Y",
                            "checked" => $TrashModuleYes);
                        echo form_radio($TrashBox_YesData) . "<label for='chrDisplayTrashY'> Yes</label>";

                        $TrashBox_NoData = array("name" => "chrDisplayTrash",
                            "id" => "chrDisplayTrashN",
                            "value" => "N",
                            "checked" => $TrashModuleNO);
                        echo form_radio($TrashBox_NoData) . "<label for='chrDisplayTrashN'> No</labe>";
                        ?>

                    </div>
                </div>
                <div class="spacer10"></div>

            </div>  
            <div class="spacer10"></div>
            <div class="contact-title" style="cursor:pointer;" onclick="javascript:expandcollapsepanel('DIV_displayinfo');">Display Information</div>
            <div class="spacer10"></div>
            <div class="fix_width" id="DIV_displayinfo" style="display:none;">
                <div class="inquiry-form">
                    <div class="fl title-w"> 
                        <div class="title-form fl">
                            Display Order
                        </div> <span class="required"></span>
                        <div class="clear"></div>  
                        <?php
                        $DOBoxdata = array(
                            'name' => 'intDisplayOrder',
                            'id' => 'intDisplayOrder',
                            'value' => (!empty($eid) ? $Row['intDisplayOrder'] : '1'),
                            'maxlength' => '50',
                            'class' => 'form-control',
                            'onkeypress' => 'return KeycheckOnlyNumeric(event);',
                            'tdoption' => Array('TDDisplay' => 'Y')
                        );
                        echo form_input_ready($DOBoxdata);
                        ?>
                    </div>

                    <div class="spacer10"></div>
                    <div class="fl title-w"> 
                        <div class="title-form fl">
                            Display:
                        </div> 
                        <span class="fl required"></span>
                        <div class="fl mgl10">
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
                                            document.getElementById('chrPublishY').checked = true;" href="javascript:">
                                    Yes</a>
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
                                            document.getElementById('chrPublishY').checked = true;" href="javascript:">
                                    Yes</a>
                                <?php
                            }
                            ?>
                            <?php
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
                            <img width="16" height="16" alt="" onmouseout="hidediv('dvhlpvarwebsite');" onmouseover="showDiv(event, 'dvhlpvarwebsite')" src="<?php echo GLOBAL_ADMIN_IMAGES_PATH; ?>images/help.png">
                            <div style=" z-index:99999; position: absolute;background-color: #d5ecfa;width: 380px;height:35px;padding: 10px;color:#0b336a;border: #95d0f2 2px solid;display: none;font-family:Tahoma, Arial, Verdana;font-size:13px;font-weight:bold;" id="dvhlpvarwebsite">Note : Please select 'Yes' if you want to display / activate this record. Otherwise please select 'NO'. </div>
                        </div>
                    </div>
                    <?php // }      ?>
                </div>
                <div class="spacer10"></div>
            </div>
            <div class="spacer10"></div>
            <input type="submit" value="Save &amp; keep editing" class="btn btn-primary btn-flat btn_blue" id="btnsaveandc" name="btnsaveandc">      
            <input type="submit" value="Save &amp; exit" id="btnsaveande" class="btn btn-primary btn-flat btn_blue" name="btnsaveande">
            <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                <div  class="btn btn-default">
                    Cancel
                </div>
            </a> 
            <div class="spacer10"></div>
        </div> 
        <?php echo form_close(); ?>

        <div class="spacer20"></div> 
        </section>
    </div>    