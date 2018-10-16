<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_MEDIA_URL; ?>js/highslide/highslide.css" />
<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL; ?>js/highslide/highslide-full.js"></script>
<script type="text/javascript">
    hs.graphicsDir = '<?php echo ADMIN_MEDIA_URL; ?>js/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    hs.showCredits = false;
    hs.wrapperClassName = 'draggable-header';
    hs.align = 'center';
    hs.width = '400';
    hs.enableKeyListener = false;
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
                    <li><span>Manage Testimonials</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Testimonial</h3> 
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>                                                
                                <th><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>                        
                                <th>Name</th>
                                <th>Image</th>
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
                            $RowCountPgaes = 0;
                            if (!empty($ShowAllPagesRecords)) {
                                foreach ($ShowAllPagesRecords as $Row) {
                                    ?>
                                    <tr>      
                                        <td>
                                            <input type="checkbox" value="<?php echo $Row['int_id']; ?>" id="chkgrow" name="chkgrow">
                                        </td>
                                        <td><?php echo $Row['varName']; ?></td>


                                        <td>
                                            <?php
                                            $imagename = $Row['varImage'];
                                            $imagepath = 'upimages/testimonial/images/' . $imagename;
                                            if (file_exists($imagepath) && $Row['varImage'] != '') {
                                                $image_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                                $image_detail_thumb = image_thumb($imagepath, TESTIMONIALS_WIDTH, TESTIMONIALS_HEIGHT);
//                                         $image_thumb = SITE_PATH. 'upimages/testimonial/images/' . $imagename;
                                            }
                                            if ($imagename != "") {
                                                if (file_exists($imagepath)) {
                                                    ?>      
                                                    <div class="gallery_grid_item md-card-content">
                                                        <a href="<?php echo $image_detail_thumb; ?>" data-uk-lightbox="{group:'gallery'}">
                                                            <img src="<?php echo $image_thumb; ?>" title="<?php echo $Row['varTitle']; ?>" alt="<?php echo $Row['varTitle']; ?>">
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
                                            <?php
                                            echo $Row['intDisplayOrder'];

                                            if ($Row['intDisplayOrder'] == 1) {
                                                ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" border="0" />  
                                            <?php } else { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountPgaes ?>', 'up', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Row['int_id'] ?>')" border="0" />
                                            <?php } ?>                                                                        

                                            <?php if ($Row['intDisplayOrder'] < $this->Module_Model->NumOfRows) { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" style="cursor:pointer;" onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountPgaes ?>', 'down', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Row['int_id'] ?>')" border="0" />
                                            <?php } else { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" border="0" />
                                            <?php } ?>                                                     
                                        </td>

                                        <td>
                                            <div class="title-text settings-setter">
                                                <?php
                                                if ($Row['chrPublish'] == 'Y') {
                                                    $BackGround = "skyblue";
                                                } else {
                                                    $BackGround = "white";
                                                }
                                                ?> 
                                                <div data-val="<?php echo $Row['chrPublish'] == 'Y' ? true : false; ?>" id="button-<?php echo $Row['int_id'] ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'testimonial' ?>" field="chrPublish" data-id="<?php echo $Row['int_id'] ?>" ></div>
                                            </div>
                                        </td>

                                        <td>
                                            <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row['int_id']; ?>"> <img width="16" height="16" src="<?php echo ADMIN_MEDIA_URL_DEFAULT ?>images/edit.png" alt="Edit" title="Click here to edit."></a>
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

                    <input type="hidden" name="displayorder<?php echo $RowCountPgaes ?>" id="displayorder<?php echo $RowCountPgaes ?>" value="<?php echo $Row['intDisplayOrder']; ?>" />
                    <input type="hidden" name="hdndisplayorder<?php echo $RowCountPgaes ?>" id="hdndisplayorder<?php echo $RowCountPgaes ?>" value="<?php echo $Row['intDisplayOrder']; ?>" />
                    <input type="hidden" name="hdnintglcode<?php echo $RowCountPgaes ?>" id="hdnintglcode<?php echo $RowCountPgaes ?>"  value="<?php echo $Row['intDisplayOrder']; ?>" />

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