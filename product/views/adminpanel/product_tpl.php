<script type="text/javascript">
    function showVal(intglcode) {
        $.ajax({
            type: "POST",
            url: "product/get_publish?pub_id=" + intglcode, async: false,
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
    <?php } ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Products</span></li>
                </ul>
            </div>
            <?php
//            $attributes = array('name' => 'FrmUplaodProduct', 'id' => 'FrmUplaodProduct', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
//            $action = ADMINPANEL_URL . "product/excel_upload";
//            echo form_open($action, $attributes);
            ?>
            <!--            <div style="float:right;">
                            <div class="uk-form-file md-btn md-btn-primary">
                                <i class="material-icons">cloud_download</i>
                                Import
                                <input id="varFileUpload" name="varFileUpload"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file">
            
                            </div>
                            <input type="submit">
                        </div>-->
            <?php
//            echo form_close();
            ?>
            <h3 class="heading_b uk-margin-bottom">Manage Products</h3>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div class="dt-uikit-header">
                        <div class="uk-grid">
                            <div class="uk-width-medium-2-3"></div>
                            <div class="uk-width-medium-1-3">
                                <div id="dt_tableExport_filter" class="dataTables_filter">
                                    <div class="md-input-wrapper">
                                           <?php echo $HeaderPanel; ?>
                                        <!--<input class="md-input" placeholder="Search:" aria-controls="dt_tableExport" type="search">-->
                                        <span class="md-input-bar "></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="uk-table" cellspacing="0" width="100%">
                        <thead>     
                            <tr>                                          
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Name</th>                  
                                <th>Category</th>
                                <th>Trade Security</th>       
                                <th>Customer</th>       
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
                            $RowCountproduct = 0;
                            if (!empty($ShowAllproductRecords)) {
                                foreach ($ShowAllproductRecords as $Row_product) {
                                    ?>           
                                    <tr>            
                                        <td>       
                                            <input type="checkbox" value="<?php echo $Row_product['int_id']; ?>" id="chkgrow" name="chkgrow">                                    
                                        </td>
                                        <td>          
                                            <?php echo $Row_product['varName']; ?>
                                        </td>
                                        <td>         
                                            <?php echo $Row_product['ParentCategoryName']; ?>
                                        </td>
                                        <td>         
                                            <?php
                                            if ($Row_product['chrTradeSecurity'] == 'Y') {
                                                echo "Yes";
                                            } else {
                                                echo "No";
                                            }
                                            ?>
                                        </td>

                                        <td>         
                                            <?php
                                            if ($Row_product['CustoName'] != '') {
                                                echo $Row_product['CustoName'] . " (" . $Row_product['varCompany'] . ")";
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_product['dtCreateDate'])); ?>       
                                        </td>
                                        <td>
                                            <?php
                                            if ($Row_product['dtModifyDate'] != '0000-00-00 00:00:00') {
                                                echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_product['dtModifyDate']));
                                            } else {
                                                echo "-";
                                            }
                                            ?>       
                                        </td>
                                        <?php
                                        if ($permissionArry['Edit'] == 'Y') {
                                            if ($Row_product['chrPublish'] == 'Y') {
                                                ?>     
                                                <?php // if ($permissionArry['Approve'] != 'Y') {   ?>
                                                <td> 
                                                    <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_product['int_id']; ?>"  title="Click here to edit."> <i class="md-icon material-icons">&#xE254;</i></a>                                       
                                                </td>                            
                                            <?php } else {
                                                ?>
                                                <td> 
                                                    <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_product['int_id']; ?>"  title="Click here to Approve."> <i class="material-icons">check_circle</i></a>                                       
                                                </td>   
                                                <?php
                                            }
                                        }
                                        ?>     
                                        <?php if ($permissionArry['Edit'] != 'Y') { ?>     
                                            <?php if ($permissionArry['Approve'] == 'Y') { ?>                                 
                                                <td> 
                                                    <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_product['int_id']; ?>"  title="Click here to Approve."> <i class="material-icons">check_circle</i></a>                                       
                                                </td>                            
                                                <?php
                                            }
                                        }
                                        ?>      
                                    </tr>                          
                                    <?php
                                    $RowCountproduct++;
                                }
                            } else {
                                ?>                   
                                <tr>             
                                    <td colspan="12" align="center">
                                        <strong>
                                            <?php echo NO_RECORDS; ?>
                                        </strong>
                                    </td> 
                                </tr>     
                            <?php } ?>      
                        </tbody>       
                    </table>
                    <input type="hidden" value="<?php echo $this->Module_Model->PageNumber; ?>" id="PageNumber" name="PageNumber">              
                    <input type="hidden" value="<?php echo $this->Module_Model->PageSize; ?>" id="PageSize" name="PageSize">           
                    <input type="hidden" value="<?php echo $RowCountproduct; ?>" id="ptrecords" name="ptrecords">               
                    <input type="hidden" value="<?php echo $Row_product['intParentCategory']; ?>" id="intParentCategory" name="intParentCategory">               


                    <div class="spacer10"></div>     
                    <?php if ($permissionArry['Delete'] == 'Y' && $this->Module_Model->NumOfRows > 0) { ?>            
                        <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                    <?php } ?>       
                    <div class="spacer10"></div>   
                    <?php echo $PagingBottom; ?>
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