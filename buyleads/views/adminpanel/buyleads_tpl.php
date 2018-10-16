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

    $(document).ready(function ()
    {
        document.getElementById("varFileUpload").onchange = function () {
            document.getElementById("FrmUplaodBuyLeads").submit();
        };
    });

</script>
<?php if ($this->Module_Model->ajax != 'Y') { ?> 
    <div id="gridbody">
    <?php }
    ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Buy Leads</span></li>
                </ul>
            </div>
            <?php
            $attributes = array('name' => 'FrmUplaodBuyLeads', 'id' => 'FrmUplaodBuyLeads', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
            $action = ADMINPANEL_URL . "buyleads/excel_upload";
            echo form_open($action, $attributes);
            ?>
            <div style="float:right;">
                <div class="uk-form-file md-btn md-btn-primary">
                    <i class="material-icons">cloud_download</i>
                    Import
                    <input id="varFileUpload" name="varFileUpload"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file">
                </div>

                <?php
//                $action = MODULE_URL . "Export";
                ?>
<!--                <a href="<?php echo $action; ?>" class="md-btn md-btn-primary">
                    <i class="material-icons">import_export</i>
                    Export
                </a>-->
            </div>
            <?php
            echo form_close();
            ?>
            <h3 class="heading_b uk-margin-bottom">Manage Buy Leads</h3> 

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Name</th>
                                <th>Customer</th>
                                <th>Industry Type</th>
                                <th><center>Hits<br/>Web | Mobile</center></th>
                        <th>Image</th>
                        <th>Created Date</th>
                        <th>Modified Date</th>
                        <?php if ($permissionArry['Edit'] == 'Y') { ?>      
                            <?php if ($permissionArry['Approve'] != 'Y') { ?>
                                <th>Edit</th> 
                                <?php
                            }
                        }
                        ?>              
                        <?php if ($permissionArry['Approve'] == 'Y') { ?>                 
                            <th>Approval</th> 
                        <?php } ?>  
                        </tr>
                        </thead>

                        <tbody>        
                            <?php
                            $RowCountbuyleads = 0;
                            if (!empty($ShowAllbuyleadsRecords)) {
                                foreach ($ShowAllbuyleadsRecords as $Row_buyleads) {
                                    ?>           
                                    <tr>            
                                        <td>       
                                            <input type="checkbox" value="<?php echo $Row_buyleads['int_id']; ?>" id="chkgrow" name="chkgrow">                                    
                                        </td>   

                                        <td>          
                                            <?php echo $Row_buyleads['varName']; ?>                       
                                        </td>   
                                        <td>          
                                            <?php
                                            if ($Row_buyleads['customer_name'] != '') {
                                                echo $Row_buyleads['customer_name'] . " (" . $Row_buyleads['varCompany'] . ")";
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>                       
                                        </td>
                                        <td>          
                                            <?php echo $Row_buyleads['category_name']; ?>                       
                                        </td>           
                                        <td>          
                                <center> <?php echo $Row_buyleads['intPageHits'] . " | " . $Row_buyleads['intMobileHits']; ?></center>
                                </td>

                                <td>
                                    <?php
                                    $imagename = $Row_buyleads['varImage'];
                                    $imagepath = 'upimages/buyleads/images/' . $imagename;

                                    if (file_exists($imagepath) && $Row_buyleads['varImage'] != '') {
                                        $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                        $image_thumb = image_thumb($imagepath, BUY_LEADS_WIDTH, BUY_LEADS_HEIGHT);
                                    }
                                    if ($imagename != "") {
                                        if (file_exists($imagepath)) {
                                            ?> 
                                            <div class="gallery_grid_item md-card-content">
                                                <a href="<?php echo $image_thumb; ?>" data-uk-lightbox="{group:'gallery'}">
                                                    <img src="<?php echo $image_detail_thumb; ?>" title="<?php echo $Row_buyleads['varName']; ?>" alt="<?php echo $Row_buyleads['varName']; ?>">
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
                                    <?php echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_buyleads['dtCreateDate'])); ?>       
                                </td>
                                <td>
                                    <?php
                                    if ($Row_buyleads['dtModifyDate'] != '0000-00-00 00:00:00') {
                                        echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_buyleads['dtModifyDate']));
                                    } else {
                                        echo "-";
                                    }
                                    ?>       
                                </td>
                                <?php
                                if ($permissionArry['Edit'] == 'Y') {
                                    if ($Row_buyleads['chrPublish'] == 'Y') {
                                        ?>     
                                        <?php // if ($permissionArry['Approve'] != 'Y') {   ?>
                                        <td> 
                                            <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_buyleads['int_id']; ?>"  title="Click here to edit."> <i class="md-icon material-icons">&#xE254;</i></a>                                       
                                        </td>                            
                                    <?php } else {
                                        ?>
                                        <td> 
                                            <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_buyleads['int_id']; ?>"  title="Click here to Approve."> <i class="material-icons">check_circle</i></a>                                       
                                        </td>   
                                        <?php
                                    }
                                }
                                ?>     
                                <?php if ($permissionArry['Edit'] != 'Y') { ?>     
                                    <?php if ($permissionArry['Approve'] == 'Y') { ?>                                 
                                        <td> 
                                            <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_buyleads['int_id']; ?>"  title="Click here to Approve."> <i class="material-icons">check_circle</i></a>                                       
                                        </td>                            
                                        <?php
                                    }
                                }
                                ?>    
                                </tr>                         
                                <!--<tr id="pagehistory<?php echo $Row_buyleads['int_id'] ?>" > </tr>-->                          
                                <?php
                                $RowCountbuyleads++;
                            }
                        } else {
                            ?>                   
                            <tr>             
                                <td colspan="8" align="center">
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
                    <input type="hidden" value="<?php echo $RowCountbuyleads; ?>" id="ptrecords" name="ptrecords">               

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