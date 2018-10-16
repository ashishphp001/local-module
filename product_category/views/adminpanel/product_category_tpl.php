<script type="text/javascript">

//    function excelreport()
//    {
//        appendurl = 'export';
//        document.forms["exportform"].submit();
//    }

    function getSubcategoryHTML(int_id) {
        jQuery.ajax({
            type: "POST",
            url: "product_category/getSubcateHTML",
            data: {
                "intParentCategory": int_id,
                "csrf_indibizz": csrfHash
            },
            async: false,
            success: function (result)
            {
                $('#addCategory').html = '';
                $('#addCategory').html(result);
                return false;
            }
        });
    }
    function getSubcategoryHTML1(int_id) {
        jQuery.ajax({
            type: "POST",
            url: "product_category/getSubcateHTML",
            data: {
                "intParentCategory": int_id,
                "csrf_indibizz": csrfHash
            },
            async: false,
            success: function (result)
            {
                $('#addCategory1').html = '';
                $('#addCategory1').html(result);
                return false;
            }
        });
    }
    function showVal(intglcode) {
        $.ajax({
            type: "POST",
            url: "product_category/get_publish?pub_id=" + intglcode, async: false,
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

    $(document).ready(function ()
    {
        document.getElementById("varFileUpload").onchange = function () {
            document.getElementById("FrmUplaodProductCategory").submit();
        };
    });
</script>



<?php if ($this->Module_Model->ajax != 'Y') { ?> 
    <div id="gridbody">
    <?php } ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Product Categories</span></li>
                </ul>
            </div>
            <?php
            $attributes = array('name' => 'FrmUplaodProductCategory', 'id' => 'FrmUplaodProductCategory', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
            $action = ADMINPANEL_URL . "product_category/excel_upload";
            echo form_open($action, $attributes);
            ?>
            <div style="float:right;">
                <div class="uk-form-file md-btn md-btn-primary">
                    <i class="material-icons">cloud_download</i>
                    Import
                    <input id="varFileUpload" name="varFileUpload"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file">
                </div>

                <?php
                $action = MODULE_URL . "Export";
                ?>
                <a href="<?php echo $action; ?>" class="md-btn md-btn-primary">
                    <i class="material-icons">import_export</i>
                    Export
                </a>
            </div>
            <?php
            echo form_close();
            ?>
            <!--<button style="float:right;" class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande" id="btnsaveande">  <i class="material-icons">cloud_download</i>&nbsp;&nbsp;Import</button>-->

            <h3 class="heading_b uk-margin-bottom">Manage Product Categories</h3>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>     
                            <tr>                                          
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Main Category</th>                          
                                <!--<th>Image</th>-->
                                <?php if ($permissionArry['Edit'] == 'Y') { ?>                 
                                    <th>Edit</th> 
                                <?php } ?>              
                            </tr>   
                        </thead>
                        <tbody>        
                            <?php
                            $RowCountproduct_category = 0;
                            if (!empty($ShowAllproduct_categoryRecords)) {
                                foreach ($ShowAllproduct_categoryRecords as $Row_product_category) {
                                    ?>           

                                    <tr>
                                        <td>    
                                            <input type="checkbox" value="<?php echo $Row_product_category['int_id']; ?>" id="chkgrow" name="chkgrow">                                    
                                        </td>
                                        <td>          
                                            <?php echo $Row_product_category['treename']; ?>
                                        </td>
<!--                                        <td>
                                            <?php
//                                            $imagename = $Row_product_category['varImage'];
//                                            $imagepath = 'upimages/product_category/images/' . $imagename;
//
//                                            if (file_exists($imagepath) && $Row_product_category['varImage'] != '') {
//                                                $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
//                                                $image_thumb = image_thumb($imagepath, PRODUCTS_CATEGORY_WIDTH, PRODUCTS_CATEGORY_HEIGHT);
//                                            }
//                                            if ($imagename != "") {
//                                                if (file_exists($imagepath)) {
                                                    ?> 
                                                    <div class="gallery_grid_item md-card-content">
                                                        <a href="<?php echo $image_thumb; ?>" data-uk-lightbox="{group:'gallery'}">
                                                            <img src="<?php echo $image_detail_thumb; ?>" title="<?php echo $Row_product_category['varTitle']; ?>" alt="<?php echo $Row_product_category['varTitle']; ?>">
                                                        </a>  
                                                    </div>
                                                    <?php
//                                                } else {
//                                                    echo "N/A";
//                                                }
//                                            } else {
//                                                echo "N/A";
//                                            }
                                            ?>
                                        </td>-->
                                        <?php if ($permissionArry['Edit'] == 'Y') { ?>                                 
                                            <td> 
                                                <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_product_category['int_id']; ?>"  title="Click here to edit."> <i class="md-icon material-icons">&#xE254;</i></a>                                       
                                                <?php ?>            
                                            </td>                            
                                        <?php } ?>      
                                    </tr>   



                                                                                                                                                                                                                                                                                                                                                                                                <!--<tr id="pagehistory<?php echo $Row_product_category['int_id'] ?>" ></tr>-->                          
                                    <?php
//                                    exit;
                                    $RowCountproduct_category++;
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
                    <input type="hidden" value="<?php echo $RowCountproduct_category; ?>" id="ptrecords" name="ptrecords">               
                    <input type="hidden" value="<?php echo $Row_product_category['intParentCategory']; ?>" id="intParentCategory" name="intParentCategory">               


                    <div class="spacer10"></div>     
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