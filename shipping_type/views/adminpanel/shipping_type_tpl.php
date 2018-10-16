<script type="text/javascript">
    function verify()
    {
        SendGridBindRequest('<?php echo MODULE_PAGE_NAME ?>', 'gridbody', 'D', 'chkgrow', '', '', '', '', '', '<?php echo $this->input->get_post('fk_position'); ?>');
    }
</script>
<script type="text/javascript">
    function verify() {
        var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
        if (CheckedLength == 0) {
            UIkit.modal.alert('Please select atleast one record to be deleted.');
            return false;
        }
        UIkit.modal.confirm('Caution! The selected records will be deleted. Press OK to confirm.', function () {
            if (CheckedLength > 0) {
                SendGridBindRequest('<?php echo $this->Module_Model->DeletePageName ?>', 'gridbody', 'D', 'chkgrow', '', '', '');
            }
        });
    }
</script>
<?php if ($this->input->get_post('ajax') != 'Y') { ?>
    <div id="gridbody">
    <?php } ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Shipping Type</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Shipping Type</h3>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>                                                
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Name</th>
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
                            $RowCountPgaes = 0;
                            if (!empty($ShowAllPagesRecords)) {
                                foreach ($ShowAllPagesRecords as $Row) {
                                    ?>
                                    <tr>      
                                        <td align="left" valign="top">
                                            <input type="checkbox" value="<?php echo $Row['int_id']; ?>" id="chkgrow" name="chkgrow">
                                        </td>
                                        <td>
                                            <?php echo $Row['varName']; ?>
                                        </td>
                                        <?php if ($permissionArry['Publish/Export'] == 'Y') { ?>   
                                            <td>
                                                <div class="title-text settings-setter">
                                                    <?php
                                                    if ($Row['chrPublish'] == 'Y') {
                                                        $BackGround = "skyblue";
                                                    } else {
                                                        $BackGround = "white";
                                                    }
                                                    ?> 
                                                    <div data-val="<?php echo $Row['chrPublish'] == 'Y' ? true : false; ?>" id="button-<?php echo $Row['int_id'] ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'shipping_type' ?>" field="chrPublish" data-id="<?php echo $Row['int_id'] ?>" ></div>
                                                </div>
                                            </td>
                                        <?php } ?>   

                                        <?php if ($permissionArry['Edit'] == 'Y') { ?>   
                                            <td>
                                                <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row['int_id']; ?>"> <i class="md-icon material-icons">&#xE254;</i></a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $RowCountPgaes++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="14" align="center"><strong><?php echo NO_RECORDS ?></strong></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <input type="hidden" value="<?php echo $this->Module_Model->Appendfk_Country_Site; ?>" id="App_country_site" name="App_country_site">    
                    <input type="hidden" value="<?php echo $this->Module_Model->PageNumber; ?>" id="PageNumber" name="PageNumber">
                    <input type="hidden" value="<?php echo $this->Module_Model->PageSize; ?>" id="PageSize" name="PageSize">
                    <input type="hidden" value="<?php echo $RowCountPgaes; ?>" id="ptrecords" name="ptrecords">
                    <input type="hidden" value="<?php echo $fk_category; ?>" id="categoryid" name="categoryid">

                    <?php if ($permissionArry['Delete'] == 'Y' && $this->Module_Model->NumOfRows > 0) { ?>             

                        <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div class="spacer10"></div>
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