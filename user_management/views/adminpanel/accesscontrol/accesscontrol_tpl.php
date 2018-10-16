<script type="text/javascript">
    function verify() {
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

<!--<script type="text/javascript">
function verify()
{
    var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;

            if (CheckedLength == 0) {
                jAlert('Please select atleast one record to be deleted.');
                return false;
            }

            if (CheckedLength > 0) {
                jConfirm('Caution! The selected records will be deleted. Press OK to confirm.', 'Confirmation Dialog', function(r)
                {
                    if (r) {
                        SendGridBindRequest('<?php echo $this->module_model->DeletePageName ?>', 'gridbody', 'D', 'chkgrow');
                    } else {
                        return false;
                    }

                });

      }    
}
</script>-->
<?php if ($ajax != 'Y') { ?>
    <div id="gridbody">
    <?php } ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Roles Of Users </span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Roles Of Users </h3>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">  
                        <thead>
                            <tr>
                                <?php if (USERTYPE == 'N') { ?>
                                    <th><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <?php } else { ?>
                                    <th>&nbsp;</th>
                                <?php } ?>
                                <th>
                                    Name
                                </th>
                                <th>Email Id</th>
                                <th>Phone No </th>
        <!--                        <th width="12%" align="center" class="numeric">
                                    <div class="title-text">
                                        <a href="javascript:;" onclick="SendGridBindRequest('<?php echo $this->module_model->UrlWithoutSort ?>&OrderBy=intDisplayOrder&sorting=Y','gridbody','ST')">Display Order
                                <?php echo $setsortimgintDisplayOrder; ?></a>
                                    </div>
                                </th>-->
                                <th>
                                    Approve
                                </th>
                                <th>Edit</th>
                                <?php if ($permissionArry['Approve'] == 'Y' || (USERTYPE == 'N' || USERTYPE == 'C')) { ?>
                                    <th>Edit Access</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $rowcount = 0;
                            if ($counttotal > 0) {
                                foreach ($selectAll as $row) {
                                    $tickimg = ($row->chrPublish == 'Y') ? "tick.png" : "tick_cross.png";
                                    if ($row->chrPublish == 'Y') {
                                        $title = "Hide me";
                                    } else {
                                        $title = "Display me";
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <?php $totalcount = $row->servicescount + $row->packagecount + $row->listingcount; ?>
                                            <?php if ($totalcount > 0) { ?>
                                                <img border="0" src="<?php echo ADMIN_MEDIA_URL_DEFAULT ?>/images/dialog-warning1.png" onmouseout="hidediv('dvhlpvarwebsite<?php echo $rowcount ?>');" onmouseover="showDiv(event, 'dvhlpvarwebsite<?php echo $rowcount ?>')" alt="not delete" id="<?php echo $row->int_id ?>" style="padding-left: 3px;">
                                                <div style="z-index: 99999; position: absolute; background-color: rgb(213, 236, 250); width: 280px; height: 16px; padding: 10px; border: 2px solid rgb(149, 208, 242); font-family: Tahoma,Arial,Verdana; font-size: 11px; font-weight: bold; display: none;" id="dvhlpvarwebsite<?php echo $rowcount ?>">This broker/agent used so can't be deleted</div>
                                            <?php } else { ?>
                                                <input type="checkbox" value="<?php echo $row->int_id; ?>" id="chkgrow" name="chkgrow">
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($permissionArry['Edit'] == 'Y') { ?> 
                                                <a style="color:#EE1C24" href="<?php echo $this->module_model->AddUrlWithPara ?>&eid=<?php echo $row->int_id; ?>">
                                                    <?php echo $row->varName ?>
                                                </a>
                                            <?php } else { ?>
                                                <?php echo $row->varName ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php echo $row->varLoginEmail; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row->varPhoneNo != '') {
                                                echo $row->varPhoneNo;
                                            } else {
                                                echo "--";
                                            }
                                            ?>
                                        </td>

                                                                                                                                                <!--                                <td align="center" valign="top">
                                        <?php echo $row->intDisplayOrder; ?>

                                                                                                                                                                                    &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up"  
                                        <?php
                                        if ($row->intDisplayOrder != 1) {
                                            ?>
                                                                                                                                                                                                                                                                                 style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $rowcount ?>', 'up', '<?php echo $moduleurl ?>','<?php echo $this->module_model->UrlWithoutSort ?>&orderby=intDisplayOrder','<?php echo $row->int_id ?>','')" 
                                            <?php
                                        }
                                        ?>

                                                                                                                                                                                                     border="0" />
                                                                                                                                                                                    &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" 
                                        <?php
                                        if ($row->intDisplayOrder < $this->module_model->NumOfRows) {
                                            ?>
                                                                                                                                                                                                                                                                                 style="cursor:pointer;" onclick="DisplayOrderSpinner('displayorder<?php echo $rowcount ?>', 'down', '<?php echo $moduleurl ?>','<?php echo $this->module_model->UrlWithoutSort ?>&orderby=intDisplayOrder','<?php echo $row->int_id ?>','')" 
                                            <?php
                                        }
                                        ?>
                                                                                                                                                                                                     border="0" />
                                                                                                                                                                                    <input type="hidden" name="displayorder<?php echo $rowcount ?>" id="displayorder<?php echo $rowcount ?>" value="<?php echo $row->intDisplayOrder; ?>" />
                                                                                                                                                                                    <input type="hidden" name="hdndisplayorder<?php echo $rowcount ?>" id="hdndisplayorder<?php echo $rowcount ?>" value="<?php echo $row->intDisplayOrder; ?>" />
                                                                                                                                                                                    <input type="hidden" name="hdnintglcode<?php echo $rowcount ?>" id="hdnintglcode<?php echo $rowcount ?>"  value="<?php echo $row->int_id; ?>" />
                                                                                                                                                                                </td>-->
                                        <td>
                                            <?php
                                            if ($permissionArry['Publish/Export'] == 'Y') {
                                                if ($row->chrPublish == 'Y') {
                                                    $BackGround = "skyblue";
                                                } else {
                                                    $BackGround = "white";
                                                }
                                                ?> 
                                                <div data-val="<?php echo $row->chrPublish == 'Y' ? true : false; ?>" id="button-<?php echo $row->int_id ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'adminpanelusers' ?>" field="chrPublish" data-id="<?php echo $row->int_id ?>" ></div>
                                            <?php } else { ?> 
                                                <i class="md-icon material-icons">&#xE254;</i>
                                            <?php } ?>       
                                        </td>
                                        <td>
                                            <?php if ($permissionArry['Edit'] == 'Y' || (USERTYPE == 'N' || USERTYPE == 'C')) { ?>
                                                <a href="<?php echo $this->module_model->AddUrlWithPara ?>&eid=<?php echo $row->int_id; ?>" title="Click here to edit."> <i class="md-icon material-icons" >&#xE254;</i></a>
                                            <?php } else { ?> 
                                                <i class="md-icon material-icons">&#xE254;</i>
                                            <?php } ?>
                                        </td>
                                        <?php if ($permissionArry['Approve'] == 'Y' || (USERTYPE == 'N' || USERTYPE == 'C')) { ?>
                                            <td>
                                                <a href="<?php echo ADMINPANEL_URL . 'user_management/groupaccess?fk_Userid=' . $row->int_id; ?>" title="Click here to edit Access."> <i class="md-icon material-icons">&#xE254;</i></a>
                                            </td>
                                        <?php } ?>

                                    </tr>
                                    <?php
                                    $rowcount++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="12" align="center"><strong><?php echo NO_RECORDS ?></strong></td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                    <input type="hidden" value="<?php echo $rowcount; ?>" id="ptrecords" name="ptrecords">
                    <!--<div class="spacer10"></div>--> 
                    <?php
                    if ($permissionArry['Delete'] == 'Y' && $this->module_model->NumOfRows > 0) {
                        ?>   
                        <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                        <?php
                    }
                    ?>  
                </div>
            </div>
        </div>
    </div>
    <?php if ($ajax != 'Y') { ?>
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