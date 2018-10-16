<script type="text/javascript">
    function verify() {
        var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
        if (CheckedLength == 0) {
            UIkit.modal.alert('Please select atleast one record to be deleted.');
            return false;
        }
        UIkit.modal.confirm('Caution! The selected records will be deleted. Press OK to confirm.', function () {
            if (CheckedLength > 0) {
                SendGridBindRequest('<?php echo $this->Module_Model->DeletePageName ?>', 'gridbody', 'D', 'chkgrow');
            }
        });
    }
</script>
<?php if ($this->Module_Model->ajax != 'Y') { ?>
    <div id="gridbody">
    <?php } ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Pages</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Pages  <code>CMS</code></h3> 
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Page Name</th>
                                <th>Manage Records</th>
                                <th>Web Hits</th>
                                <th>Mobile Hits</th>
                                <th>Description</th>
                                <th>Display Order</th>
                                <?php if ($permissionArry['Publish/Export'] == 'Y') { ?> 
                                    <th>Publish</th>
                                <?php } ?>
                                <?php if ($permissionArry['Edit'] == 'Y') { ?>  
                                    <th>Edit</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalparent = $this->Module_Model->getParentRecord();    //FOR DISPLAY_ORDER
                            $parentrec = 0;
                            $RowCountPgaes = 0;

                            if (!empty($ShowAllPagesRecords)) {
                                foreach ($ShowAllPagesRecords as $Row_pages) {
                                    $a = $this->Module_Model->get_hits($Row_pages['int_id']);
                                    ?>
                                    <tr>
                                        <?php
                                        if ($Row_pages['Noofrows'] > 0 || $Row_pages['int_id'] == '1' || $Row_pages['fk_ModuleGlCode'] > 2) {
                                            ?>
                                            <td>
                                                <?php
                                                if ($Row_pages['Noofrows'] > 0) {
                                                    $Title_tooltip = "This page has child pages so cannot be deleted";
                                                } else if ($Row_pages['int_id'] == 1) {
                                                    $Title_tooltip = "This is Home page so cannot be deleted";
                                                } else if ($Row_pages['fk_ModuleGlCode'] == 2) {
                                                    $Title_tooltip = "This is CMS page so cannot be deleted";
                                                } else if ($Row_pages['fk_ModuleGlCode'] > 2) {
                                                    $Title_tooltip = "This is module so cannot be deleted";
                                                }
                                                ?>
                                                <div class="tooltip" title="<?php echo $Title_tooltip; ?>" >
                                                    <img width="16" height="16" alt="" src="<?php echo GLOBAL_ADMIN_IMAGES_PATH ?>/dialog-warning1.png">
                                                </div>
                                            </td>
                                            <?php
                                        } else {
                                            ?>  <td>
                                                <input type="checkbox" value="<?php echo $Row_pages['int_id']; ?>" id="chkgrow" name="chkgrow">
                                            </td>
                                        <?php } ?>
                                        <td><?php echo $Row_pages['treename']; ?></td>
                                        <td> <?php
                                            if ($Row_pages['fk_ModuleGlCode'] != 2 && $Row_pages['int_id'] != 27 && $Row_pages['int_id'] != 18 && $Row_pages['fk_ModuleGlCode'] != 0) {
                                                ?>
                                                <a href="<?= ADMINPANEL_URL . $Row_pages['module'] ?>" target="_blank" class="edit-link-class " style="color:#038639;">
                                                    <?php echo 'Manage Records'; ?> 
                                                </a>
                                                <?php
                                            } else {
                                                echo '-';
                                            }
                                            ?></td>
                                        <td><?php echo $a[0]->intPageHits; ?></td>

                                        <td><?php echo $a[0]->intMobileHits; ?></td>
                                        <td>
                                            <?php if ($Row_pages['txtDescription'] != '') { ?>
                                                <button class="md-btn" data-uk-modal="{target:'#modal_default<?php echo $Row_pages['int_id']; ?>'}">Open</button>
                                                <div class="uk-modal" id="modal_default<?php echo $Row_pages['int_id']; ?>">
                                                    <div class="uk-modal-dialog">
                                                        <button type="button" class="uk-modal-close uk-close"></button>
                                                        <?php
                                                        echo $this->mylibrary->Replace_Varible_with_Sitepath($Row_pages['txtDescription']);
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                        </td>
                                        <td>  <?php
                                            if (!empty($Row_pages['fk_ParentPageGlCode'])) {
                                                echo $Row_pages['DisplayOrder'];
                                            } else {
                                                echo $Row_pages['intDisplayOrder'];
                                            }

                                            if ($Row_pages['int_id'] != '1') {
                                                ?> 

                                                <input type="hidden"  name="displayorder<?= $RowCountPgaes ?>" id="displayorder<?= $RowCountPgaes ?>" style="width:50px; text-align:center;" onkeypress="return KeycheckOnlyNumeric(event);" value="<?= $Row_pages['intDisplayOrder'] ?>" />  
                                            <?php } else { ?> 
                                                <input type="hidden"  name="displayorder<?= $RowCountPgaes ?>" id="displayorder<?= $RowCountPgaes ?>" value="<?= $Row_pages['intDisplayOrder']; ?>" />
                                            <?php } ?>
                                            <input type="hidden"  name="hdndisplayorder<?= $RowCountPgaes ?>" id="hdndisplayorder<?= $RowCountPgaes ?>" style="width:50px; text-align:center;" value="<?= $Row_pages['intDisplayOrder']; ?>" />
                                            <input type="hidden" name="hdnintglcode<?= $RowCountPgaes ?>" id="hdnintglcode<?= $RowCountPgaes ?>" style="width:50px; text-align:center;" value="<?= $Row_pages['int_id'] ?>" />  


                                            <?php if ($Row_pages['int_id'] != '1') { ?> 
                                                <input type="hidden"  name="displayorder<?= $RowCountPgaes ?>" id="displayorder<?= $RowCountPgaes ?>" style="width:50px; text-align:center;" onkeypress="return KeycheckOnlyNumeric(event);" value="<?= $Row_pages['intDisplayOrder'] ?>" />  
                                                &nbsp;&nbsp;<img src="<?= ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up"  
                                                <?php
                                                if (($Row_pages['intDisplayOrder'] != 2) || ($Row_pages['fk_ParentPageGlCode'] != 0)) {
                                                    if ($Row_pages['intDisplayOrder'] != 1) {
                                                        ?>style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountPgaes ?>', 'up', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&orderby=intDisplayOrder', '<?php echo $Row_pages['int_id'] ?>', '<?php echo $Row_pages['fk_ParentPageGlCode'] ?>&PageNumber=<?php echo $this->Module_Model->PageNumber; ?>')" 
                                                                         <?php
                                                                     }
                                                                 }
                                                                 ?>                                                         
                                                                 border="0" />
                                                &nbsp;&nbsp;<img src="<?= ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" 
                                                <?php
                                                if (($parentrec == $totalparent)) {
                                                    $parentrec = $parentrec + 1;
                                                } else {
                                                    if (($Row_pages['intDisplayOrder'] < $this->Module_Model->NumOfRows)) {
                                                        ?>
                                                                         style="cursor:pointer;"    onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountPgaes ?>', 'down', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&orderby=intDisplayOrder', '<?php echo $Row_pages['int_id'] ?>', '<?php echo $Row_pages['fk_ParentPageGlCode'] ?>&PageNumber=<?php echo $this->Module_Model->PageNumber; ?>')" 
                                                                         <?php
                                                                     }
                                                                 }
                                                                 ?> border="0" />
                                                             <?php } else { ?> 
                                                <input type="hidden"  name="displayorder<?= $RowCountPgaes ?>" id="displayorder<?= $RowCountPgaes ?>" value="<?= $Row_pages['intDisplayOrder']; ?>" />
                                            <?php } ?>
                                            <input type="hidden"  name="hdndisplayorder<?= $RowCountPgaes ?>" id="hdndisplayorder<?= $RowCountPgaes ?>" style="width:50px; text-align:center;" value="<?= $Row_pages['intDisplayOrder']; ?>" />
                                            <input type="hidden" name="hdnintglcode<?= $RowCountPgaes ?>" id="hdnintglcode<?= $RowCountPgaes ?>" style="width:50px; text-align:center;" value="<?= $Row_pages['int_id'] ?>" />  
                                        </td>
                                        <?php if ($permissionArry['Publish/Export'] == 'Y') { ?> 
                                            <td >
                                                <?php if ($Row_pages['int_id'] == '1') { ?>
                                                    <div title="Record is not publish/unpublish because this is home page.">
                                                        <input style="width: 75px;border-radius: 8px;background-color: grey"  type="" value="<?php echo $Row_pages['chrPublish'] == 'Y' ? 'ON' : "OFF" ?>" id="jqxDisabledButton" role="button" class="jqx-rc-all jqx-button jqx-widget jqx-fill-state-disabled" aria-disabled="true" disabled="" aria-checked="false" >
                                                    </div>

                                                <?php } else if ($Row_pages['Noofrows'] > 0) { ?>
                                                    <div title="Record is not publish/unpublish because this page has child page.">
                                                        <input style="width: 75px;border-radius: 8px;background-color: grey"  type="" value="<?php echo $Row_pages['chrPublish'] == 'Y' ? 'ON' : "OFF" ?>" id="jqxDisabledButton" role="button" class="jqx-rc-all jqx-button jqx-widget jqx-fill-state-disabled" aria-disabled="true" disabled="" aria-checked="false" >
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="title-text settings-setter">
                                                        <?php
                                                        if ($Row_pages['chrPublish'] == 'Y') {
                                                            $BackGround = "skyblue";
                                                        } else {
                                                            $BackGround = "white";
                                                        }
                                                        ?> 
                                                        <div data-val="<?php echo $Row_pages['chrPublish'] == 'Y' ? true : false; ?>" id="button-<?php echo $Row_pages['int_id'] ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'pages' ?>" field="chrPublish" data-id="<?php echo $Row_pages['int_id'] ?>" ></div>
                                                    </div>
                                                <?php } ?>

                                            </td>
                                        <?php } ?>
                                        <?php if ($permissionArry['Edit'] == 'Y') { ?>  
                                            <td><a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_pages['int_id']; ?>"  title="Click here to edit."> <i class="md-icon material-icons">&#xE254;</i></a></td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $RowCountPgaes++;
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                    <input type="hidden" value="<?php echo $RowCountPgaes; ?>" id="ptrecords" name="ptrecords">
                    <?php if ($permissionArry['Delete'] == 'Y' && $this->Module_Model->NumOfRows > 0) { ?>             

                        <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->Module_Model->ajax != 'Y') { ?>
    </div>
<?php } ?>
<?php
$this->permission = $this->session->userdata('permissionArry');
$this->permissionArry = $this->permission[MODULE_PATH];
if ($this->permissionArry['Add'] == 'Y') {
    ?>
    <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="<?php echo MODULE_PAGE_NAME . '/add'; ?>">
            <i class="material-icons">&#xE145;</i>
        </a>
    </div>

<?php } ?>