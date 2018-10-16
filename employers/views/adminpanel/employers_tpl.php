
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
                    <li><span>Manage Employers</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Employers <?php
                            if ($_REQUEST['types'] == 'p') {
                               echo " - Paid";
                            } else {
                               echo " - Free";
                            }
                            ?></h3> 
            <div class="clear"></div>
            <div class="md-card uk-margin-medium-bottom margin-top-50">
                <div class="md-card-content">
                    <div class="tab-system uk-active">
                        <?php
                        if ($_REQUEST['types'] == 'f') {
                            $class2 = "user_heading";
                            $class1 = "";
                        } else {
                            $class2 = "";
                            $class1 = "user_heading";
                        }
                        ?>
                        <a href="<?php echo MODULE_PAGE_NAME . "?types=p"; ?>" class="<?php echo $class1; ?>">Paid</a>
                        <a href="<?php echo MODULE_PAGE_NAME . "?types=f"; ?>" class="<?php echo $class2; ?>">Free</a>
                    </div>
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>                                                
                                <th width="3%" align="left"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>                        
                                <th>Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Image</th>
                                <th>Publish</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $RowCountPgaes = 0;
                            if (!empty($ShowAllPagesRecords)) {
                                foreach ($ShowAllPagesRecords as $Row) {
                                    ?>
                                    <tr>      
                                        <td>
                                            <input type="checkbox" value="<?php echo $Row['int_id']; ?>" id="chkgrow" name="chkgrow">
                                        </td>
                                        <td><?php echo $Row['varName']; ?></td>
                                        <td><?php echo $Row['varEmail']; ?></td>
                                        <td><?php echo $Row['varCompany']; ?></td>
                                        <td><?php echo $Row['varCity']." (".$Row['varCountry'].")"; ?></td>


                                        <td>
                                            <?php
                                            $imagename = $Row['varImage'];
                                            $imagepath = 'upimages/users/images/' . $imagename;

                                            if (file_exists($imagepath) && $Row['varImage'] != '') {
                                                $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                                $image_thumb = image_thumb($imagepath, USERS_WIDTH, USERS_HEIGHT);
                                            }
                                            if ($imagename != "") {
                                                if (file_exists($imagepath)) {
                                                    ?> 
                                                    <div class="gallery_grid_item md-card-content">
                                                        <a href="<?php echo $image_thumb; ?>" data-uk-lightbox="{group:'gallery'}">
                                                            <img src="<?php echo $image_detail_thumb; ?>" title="<?php echo $Row['varName']; ?>" alt="<?php echo $Row['varName']; ?>">
                                                        </a>  
                                                    </div>
                                                    <?php
                                                } else {
                                                    echo "N/A";
                                                }
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                        </td> 

                                        <td align="center" valign="top">
                                            <div class="title-text settings-setter">
                                                <?php
                                                if ($Row['chrPublish'] == 'Y') {
                                                    $BackGround = "skyblue";
                                                } else {
                                                    $BackGround = "white";
                                                }
                                                ?> 
                                                <div data-val="<?php echo $Row['chrPublish'] == 'Y' ? true : false; ?>" id="button-<?php echo $Row['int_id'] ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'users' ?>" field="chrPublish" data-id="<?php echo $Row['int_id'] ?>" ></div>
                                            </div>
                                        </td>

                                        <td>
                                            <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row['int_id']; ?>"  title="Click here to edit."><i class="md-icon material-icons">&#xE254;</i></a>
                                        </td>
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
                    <?php } ?> 
                    <div class="spacer10"></div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->Module_Model->ajax != 'Y') { ?> 
    </div>
<?php } ?>