<script type="text/javascript">
    function showVal(intglcode) {
        $.ajax({
            type: "POST",
            url: "careers/get_publish?pub_id=" + intglcode, async: false,
            success: function (result) {
                if (result == 'Y') {
                    document.getElementById('shar-' + intglcode).style.display = 'none';
                } else {
                    document.getElementById('shar-' + intglcode).style.display = '';
                }
            }
        });
    }

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
<?php if ($this->Module_Model->ajax != 'Y') { ?> 
    <div id="gridbody">
        <?php
    }
    if ($messagebox != '') {
        echo $messagebox;
    }
    ?>     
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Careers</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Careers</h3> 

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead> 
                            <tr>                                          
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Title</th>               
                                <th>Career Date  </th>               
                                <th>Image</th>
                                <th>Short Description</th>
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
                            $RowCountcareers = 0;
                            if (!empty($ShowAllcareersRecords)) {
                                foreach ($ShowAllcareersRecords as $Row_careers) {
                                    ?>           
                                    <tr>            
                                        <td>       
                                            <input type="checkbox" value="<?php echo $Row_careers['int_id']; ?>" id="chkgrow" name="chkgrow">                                    
                                        </td>   

                                        <td>          
                                            <?php echo $Row_careers['varTitle']; ?>
                                        </td>            
                                        <td>          
                                            <?php echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_careers['dtCareerDate'])); ?>       
                                        </td>            

                                        <td>
                                            <?php
                                            $imagename = $Row_careers['varImage'];
                                            $imagepath = 'upimages/careers/images/' . $imagename;

                                            if (file_exists($imagepath) && $Row_careers['varImage'] != '') {
                                                $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                                $image_thumb = image_thumb($imagepath, CAREERS_WIDTH, CAREERS_HEIGHT);
                                            }
                                            if ($imagename != "") {
                                                if (file_exists($imagepath)) {
                                                    ?> 
                                                    <div class="gallery_grid_item md-card-content">
                                                        <a href="<?php echo $image_thumb; ?>" data-uk-lightbox="{group:'gallery'}">
                                                            <img src="<?php echo $image_detail_thumb; ?>" title="<?php echo $Row_careers['varTitle']; ?>" alt="<?php echo $Row_careers['varTitle']; ?>">
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

                                        <td>
                                            <?php if ($Row_careers['varShortDesc'] != '') { ?>

                                                <button class="md-btn" data-uk-modal="{target:'#modal_default<?php echo $Row_careers['int_id']; ?>'}">View</button>
                                                <div class="uk-modal" id="modal_default<?php echo $Row_careers['int_id']; ?>">
                                                    <div class="uk-modal-dialog">

                                                        <button type="button" class="uk-modal-close uk-close"></button>
                                                        <div class="uk-modal-header">
                                                            <h3 class="uk-modal-title">Short Description for <?php echo ($Row_careers['varTitle']); ?></h3>
                                                        </div>
                                                        <?php echo nl2br($Row_careers['varShortDesc']); ?>
                                                    </div>
                                                </div>

                                                <?php
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            echo $Row_careers['intDisplayOrder'];

                                            if ($Row_careers['intDisplayOrder'] == 1) {
                                                ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" border="0" />  
                                            <?php } else { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountcareers ?>', 'up', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Row_careers['int_id'] ?>')" border="0" />
                                            <?php } ?>                                                                        

                                            <?php if ($Row_careers['intDisplayOrder'] < $this->Module_Model->NumOfRows) { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" style="cursor:pointer;" onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountcareers ?>', 'down', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Row_careers['int_id'] ?>')" border="0" />
                                            <?php } else { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" border="0" />
                                            <?php } ?>                                                     
                                            <input type="hidden" name="displayorder<?php echo $RowCountcareers ?>" id="displayorder<?php echo $RowCountcareers ?>" value="<?php echo $Row_careers['intDisplayOrder']; ?>" />
                                            <input type="hidden" name="hdndisplayorder<?php echo $RowCountcareers ?>" id="hdndisplayorder<?php echo $RowCountcareers ?>" value="<?php echo $Row_careers['intDisplayOrder']; ?>" />
                                            <input type="hidden" name="hdnintglcode<?php echo $RowCountcareers ?>" id="hdnintglcode<?php echo $RowCountcareers ?>"  value="<?php echo $Row_careers['intDisplayOrder']; ?>" />
                                        </td>
                                        <?php if ($permissionArry['Publish/Export'] == 'Y') { ?>                                  
                                            <td>                        
                                                <div class="title-text settings-setter" align="center">      
                                                    <?php
                                                    if ($Row_careers['chrPublish'] == 'Y') {
                                                        $BackGround = "skyblue";
                                                    } else {
                                                        $BackGround = "white";
                                                    }
                                                    ?>                                           
                                                    <div data-val="<?php echo $Row_careers['chrPublish'] == 'Y' ? true : false; ?>" id="button-<?php echo $Row_careers['int_id'] ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'careers' ?>" field="chrPublish" data-id="<?php echo $Row_careers['int_id'] ?>" onclick="return showVal('<?php echo $Row_careers['int_id'] ?>', '<?php echo $Row_careers['chrPublish'] == 'Y' ? "Y" : "N"; ?>');"></div>   
                                                </div>                         
                                            </td>                        
                                        <?php } ?>   

                                        <?php if ($permissionArry['Edit'] == 'Y') { ?>                                 
                                            <td> 
                                                <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_careers['int_id']; ?>" title="Click here to edit."> <i class="md-icon material-icons">&#xE254;</i>
                                                </a>                                       
                                                <?php ?>            
                                            </td>                            
                                        <?php } ?>      
                                    </tr>
                                    <!--<tr id="pagehistory<?php echo $Row_careers['int_id'] ?>" ></tr>-->                          
                                    <?php
                                    $RowCountcareers++;
                                }
                            } else {
                                ?>                   
                                <tr>             
                                    <td colspan="12" align="center">
                                        <strong>
                                            <?php echo NO_RECORDS ?>
                                        </strong>
                                    </td> 
                                </tr>     
                            <?php } ?>      
                        </tbody>       
                    </table>
                        <input type="hidden" value="<?php echo $this->Module_Model->PageNumber; ?>" id="PageNumber" name="PageNumber">              
                        <input type="hidden" value="<?php echo $this->Module_Model->PageSize; ?>" id="PageSize" name="PageSize">           
                        <input type="hidden" value="<?php echo $RowCountcareers; ?>" id="ptrecords" name="ptrecords">               
                    
                    <?php if ($permissionArry['Delete'] == 'Y' && $this->Module_Model->NumOfRows > 0) { ?>            
                        <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                    <?php } ?>   
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