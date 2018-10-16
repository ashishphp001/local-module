
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
    $(document).ready(function ()
    {
        document.getElementById("varFileUpload").onchange = function () {
            document.getElementById("FrmUploadUser").submit();
        };
    });
</script>
<?php if ($this->input->get_post('ajax') != 'Y') { ?>
    <div id="gridbody">
    <?php } ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Buyer / Seller</span></li>
                </ul>
            </div>
            <?php
//            $attributes = array('name' => 'FrmUploadUser', 'id' => 'FrmUploadUser', 'enctype' => 'multipart/form-data', 'class' => 'enquiry_form');
//            $action = ADMINPANEL_URL . "buyer_seller/excel_upload";
//            echo form_open($action, $attributes);
            ?>
<!--            <div style="float:right;">
                <div class="uk-form-file md-btn md-btn-primary">
                    <i class="material-icons">cloud_download</i>
                    Import
                    <input id="varFileUpload" name="varFileUpload"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file">
                </div>

                <?php
//                $action = MODULE_URL . "Export";
                ?>
                <a href="<?php echo $action; ?>" class="md-btn md-btn-primary">
                    <i class="material-icons">import_export</i>
                    Export
                </a>
            </div>-->
            <?php
//            echo form_close();
            ?>

            <h3 class="heading_b uk-margin-bottom">Manage Buyer / Seller <?php
                if ($_GET['types'] == 'p') {
                    echo " - Paid";
                } else {
                    echo " - Free";
                }
                ?></h3> 
            <div class="clear"></div>
            <?php
            if ($_GET['msg'] == 'success') {
                echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-success" id="hierarchical-slide"><li>';
                echo "User Sheet Imported successfully.";
                echo '</li></ul></div></div>';
            }
            ?>
            <div class="clear"></div>
            <div class="md-card uk-margin-medium-bottom margin-top-50">
                <div class="md-card-content">
                    <div class="tab-system uk-active">
                        <?php
                        if ($_GET['types'] == 'f') {
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
                    
                    <!--<table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">-->
                         <table class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>                                                
                                <th width="3%" align="left"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>                        
                                <th>Name</th>
                                <th>Email</th>
                                <?php if ($_GET['types'] != 'f') { ?>
                                    <th>Membership Plan</th>
                                <?php } ?>
                                <?php if ($_GET['types'] != 'f') { ?>
                                    <th>Payment By</th>
                                <?php } ?>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Image</th>
                                <th><nobr>User Info</nobr></th>
                        <?php if ($_GET['types'] == 'f') { ?>
                            <th>Payment</th>
                        <?php } ?>
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
                                        <?php if ($_GET['types'] != 'f') { ?>
                                            <td><?php echo $Row['varPlan']; ?></td>
                                        <?php } ?>
                                        <?php if ($_GET['types'] != 'f') { ?>
                                            <td><?php
                                                if ($Row['varPaymentBy'] == '0') {
                                                    echo "Website";
                                                } else {
                                                    echo $Row['varPaymentBy'];
                                                }
                                                ?></td>
                                        <?php } ?>
                                        <td><?php echo $Row['varCompany']; ?></td>
                                        <td>

                                            <?php
                                            if ($Row['varCity'] != '' && $Row['varCountry'] != '') {
                                                echo $Row['varCity'] . " (" . $Row['varCountry'] . ")";
                                            }
                                            ?>

                                        </td>
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
                                        <td>
                                            <a href="<?php echo MODULE_PAGE_NAME; ?>/information_tpl?eid=<?php echo $Row['int_id']; ?>" title="Cancel">
                                                <div  class="md-btn md-btn-wave">
                                                    View
                                                </div>
                                            </a>
                                        </td>
                                        <?php if ($_GET['types'] == 'f') { ?>
                                            <td>
                                                <a target="_blank" class="md-btn" href="<?php echo MODULE_PAGE_NAME . "/payment?eid=" . $Row["int_id"] ?>">Payment</a>
                                            </td>
                                        <?php } ?>

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
                     <?php echo $PagingBottom; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->Module_Model->ajax != 'Y') { ?> 
    </div>
<?php } ?>