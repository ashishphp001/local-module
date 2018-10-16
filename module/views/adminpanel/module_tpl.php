<script type="text/javascript">
    function verify()
    {
        var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
        if (CheckedLength == 0) {
            UIkit.modal.alert('Please select atleast one record to be deleted.');
            return false;
        }
        UIkit.modal.confirm('Caution! The selected records will be deleted. Press OK to confirm.', function () {
            if (CheckedLength > 0) {
                SendGridBindRequest('<?php echo $this->module_model->DeletePageName ?>', 'gridbody', 'D', 'chkgrow');
            }
        });
    }

</script>
<?php if ($this->Module_Model->ajax != 'Y') { ?> 
    <div id="gridbody">
        <?php
    }
    ?>

    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Modules</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Modules</h3> 

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Title</th>
                                <th>Module Name</th>
                                <th>Listing Title</th>
                                <th>Form Title</th>
                                <th>Display Order</th>
                                <th>Publish</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowcount = 0;
                            if (!empty($ModuleArray)) {
                                foreach ($ModuleArray as $Module) {
                                    $tickimg = ($Module->chr_publish == 'Y') ? "tick.png" : "tick_cross.png";
                                    if ($Module->chr_publish == 'Y') {
                                        $title = "Hide me";
                                    } else {
                                        $title = "Display me";
                                    }
                                    ?>
                                    <tr>
                                        <td align="left" valign="top">

                                            <input type="checkbox" value="<?php echo $Module->int_id; ?>" id="chkgrow" name="chkgrow">
                                        </td>
                                        <td align="left" valign="top">
                                            <!--<div class="title-text">-->
                                            <a href="<?php echo $this->module_model->AddUrlWithPara ?>&eid=<?php echo $Module->int_id; ?>" style="color:blank;">
                                                <?php
                                                echo $Module->varModuleName;
                                                ?>
                                            </a>
                                            <!--</div>-->     
                                        </td>
                                        <td align="left" valign="top">
                                            <div class="title-text">
                                                <?php echo $Module->varTitle;
                                                ?>
                                            </div>
                                        </td>
                                        <td align="left" valign="top">
                                            <div class="title-text">  
                                                <?php
                                                if (!empty($Module->varActionListing)) {
                                                    echo $Module->varActionListing;
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td align="left" valign="top" class="numeric">  
                                            <div class="title-text">
                                                <?php
                                                if (!empty($Module->varActionAdd)) {
                                                    echo $Module->varActionAdd;
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?> </div>                              
                                        </td>

                                        <td align="left" valign="top" class="numeric" style="text-align:center;"> 
                                            <div class="title-text">
                                                <?php
                                                echo $Module->intDisplayOrder;
                                                ?>
                                                <!--                                </td>
                                                                                <td align="left" valign="top" class="numeric">  -->
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up"  
                                                <?php
                                                if ($Module->intDisplayOrder != 1) {
                                                    ?>
                                                                     style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $rowcount ?>', 'up', '<?php echo $moduleurl ?>', '<?php echo $this->module_model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Module->int_id ?>', '<?php echo $Module->fk_module ?>')" 
                                                                     <?php
                                                                 }
                                                                 ?>

                                                                 border="0" />
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" 
                                                <?php
                                                if ($Module->intDisplayOrder < $this->module_model->NumOfRows) {
                                                    ?>
                                                                     style="cursor:pointer;" onclick="DisplayOrderSpinner('displayorder<?php echo $rowcount ?>', 'down', '<?php echo $moduleurl ?>', '<?php echo $this->module_model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Module->int_id ?>', '<?php echo $Module->fk_module ?>')" 
                                                                     <?php
                                                                 }
                                                                 ?>
                                                                 border="0" />
                                                <input type="hidden"  name="displayorder<?php echo $rowcount ?>" id="displayorder<?php echo $rowcount ?>" style="width:50px; text-align:center;" onkeypress="return KeycheckOnlyNumeric(event);" value="<?php echo $Module->intDisplayOrder ?>" />      
                                                <input type="hidden" name="hdndisplayorder<?php echo $rowcount ?>" id="hdndisplayorder<?php echo $rowcount ?>" value="<?php echo $Module->intDisplayOrder ?>" />
                                                <input type="hidden" name="hdnintglcode<?php echo $rowcount ?>" id="hdnintglcode<?php echo $rowcount ?>"  value="<?php echo $Module->int_id; ?>" />
                                            </div>
                                        </td>
                                        <td align="left" valign="top" class="numeric">  
                                            <div class="title-text settings-setter">
                                                <?php
                                                if ($Module->chrPublish == 'Y') {
                                                    $BackGround = "skyblue";
                                                } else {
                                                    $BackGround = "white";
                                                }
                                                ?>
                                                <div data-val="<?php echo $Module->chrPublish == 'Y' ? true : false; ?>" id="button-<?php echo $Module->int_id ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'modules' ?>" field="chrPublish" data-id="<?php echo $Module->int_id ?>" ></div>
                                            </div>                              
                                        </td>
                                    </tr>
                                    <?php
                                    $rowcount++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8" align="center"><strong>No Records Found</strong></td>
                                </tr>
                                <?php
                            }
                            ?>
                        <input type="hidden" value="<?php echo $rowcount; ?>" id="ptrecords" name="ptrecords">
                        </tbody>
                    </table>

                    <div class="spacer10"></div> 
                    <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                </div>

                <?php if ($this->Module_Model->ajax != 'Y') { ?> 
                </div>
            <?php } ?>