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
        var PageNumber = document.getElementById("PageNumber").value;
        var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
        if (CheckedLength == 0) {
            jAlert('Please select atleast one record to be deleted.');
            return false;
        }
        if (CheckedLength > 0) {
            jConfirm('Caution! The selected records will be deleted. Press OK to confirm.', 'Confirmation Dialog', function (r) {
                if (r) {
                    var catid = document.getElementById('categoryid').value;
                    // alert(catid);
                    SendGridBindRequest('<?php echo $this->Module_Model->DeletePageName ?>&PageNumber=' + PageNumber, 'gridbody', 'D', 'chkgrow', '', catid);
                } else {
                    return false;
                }
            });
        }
    }
</script>
<?php if ($this->input->get_post('ajax') != 'Y') { ?>
    <div id="gridbody" class="content-wrapper" style="min-height: 699px;">
    <?php } ?>
    <?php
    echo $HeaderPanel;
    if ($messagebox != '') {
        echo $messagebox;
    }
    ?>

    <div class="box-header">
        <?php echo $this->mylibrary->Add_module_note('Teams', 'Study'); ?>
        <div class="table_entries">
            <div id="example1_length" class="dataTables_length">
                <?php echo $PagingTop; ?>
            </div>
        </div>
    </div>
    <div class="spacer10"></div>
    <section id="flip-scroll">	
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <thead class="cf">
                    <tr>                                                
                        <th width="3%" align="left"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>                        

                        <th width="12%" align="left">
                            <div class="title-text">
                                <a href="javascript:;" onclick="SendGridBindRequest('<?php echo $this->Module_Model->UrlWithOutSort; ?>&OrderBy=varName&sorting=Y', 'gridbody', 'ST')">Name
                                    <?php echo $setsortimgvarName; ?>
                                </a>
                            </div>
                        </th>

                        <th width="3%" align="center">
                            <div class="title-text" align="center">Image</div>
                        </th>
                        <th width="8%" align="left">
                            <div class="title-text" align="center">
                                <a href="javascript:;" onclick="SendGridBindRequest('<?php echo $this->Module_Model->UrlWithOutSort; ?>&OrderBy=intDisplayOrder&sorting=Y', 'gridbody', 'ST')">Display Order
                                    <?php echo $setsortimgintDisplayOrder; ?>
                                </a>
                            </div>
                        </th>
                        <th width="3%" align="center" class="numeric">
                            <div class="title-text" align="center">
                                Publish

                            </div>
                        </th>

                        <th width="2%" align="center" class="numeric"><div class="title-text" align="center">Edit</div></th>
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
                                <td align="left" valign="top">
                                    <div class="title-text"><?php echo $Row['varName']; ?></div>
                                </td>


                                <td align="center" valign="top">
                                    <?php
                                    $imagename = $Row['varImage'];
                                    $imagepath = 'upimages/users/images/' . $imagename;
                                    if (file_exists($imagepath) && $Row['varImage'] != '') {
                                        $image_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                        $image_detail_thumb = image_thumb($imagepath, TEAM_WIDTH, TEAM_HEIGHT);
//                                         $image_thumb = SITE_PATH. 'upimages/users/images/' . $imagename;
                                    }
                                    if ($imagename != "") {
                                        if (file_exists($imagepath)) {
                                            ?>      
                                            <a href="#varMenuIconImage<?php echo $Row['int_id']; ?>"  class="fancybox-buttons" data-fancybox-group="button">
                                                <img width="15px" height="20px"  src="<?php echo $image_thumb; ?>" alt="View" title="<?php echo $Row['varImage']; ?>" border="0" align="absmiddle" id="myimage" />
                                                <span id="varMenuIconImage<?php echo $Row['int_id']; ?>" style="display:none">

                                                    <img title="<?php echo htmlentities($this->common_model->GetImageNameOnly($Row['varImage'])); ?>" src="<?php echo $image_detail_thumb; ?>" alt="View" border="0" align="absmiddle" id="myimage" />

                                                </span>
                                            </a>    
                                            <?php
                                        } else {
                                            echo "N/A";
                                        }
                                    } else {
                                        echo "N/A";
                                    }
                                    ?>
                                </td> 

                                <td align="left" valign="top">
                                    <div class="title-text" align="center">
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
                                        <input type="hidden" name="displayorder<?php echo $RowCountPgaes ?>" id="displayorder<?php echo $RowCountPgaes ?>" value="<?php echo $Row['intDisplayOrder']; ?>" />
                                        <input type="hidden" name="hdndisplayorder<?php echo $RowCountPgaes ?>" id="hdndisplayorder<?php echo $RowCountPgaes ?>" value="<?php echo $Row['intDisplayOrder']; ?>" />
                                        <input type="hidden" name="hdnintglcode<?php echo $RowCountPgaes ?>" id="hdnintglcode<?php echo $RowCountPgaes ?>"  value="<?php echo $Row['intDisplayOrder']; ?>" />
                                    </div>
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

                                <td align="left" valign="top">
                                    <div class="title-text" align="center">
                                        <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row['int_id']; ?>"> <img width="16" height="16" src="<?php echo ADMIN_MEDIA_URL_DEFAULT ?>images/edit.png" alt="Edit" title="Click here to edit."></a>
                                    </div>
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
                <input type="hidden" value="<?php echo $this->Module_Model->Appendfk_Country_Site; ?>" id="App_country_site" name="App_country_site">    
                <input type="hidden" value="<?php echo $this->Module_Model->PageNumber; ?>" id="PageNumber" name="PageNumber">
                <input type="hidden" value="<?php echo $this->Module_Model->PageSize; ?>" id="PageSize" name="PageSize">
                <input type="hidden" value="<?php echo $RowCountPgaes; ?>" id="ptrecords" name="ptrecords">
                <input type="hidden" value="<?php echo $fk_category; ?>" id="categoryid" name="categoryid">
                </tbody>
            </table>
        </div>
    </section>
    <?php // echo $PagingBottom;  ?>
    <div class="spacer10"></div> 
    <?php
    if ($this->Module_Model->NumOfRows > 0) {
        ?>   
                            <!--<a href="javascript:;" onclick="return verify();" class="fl"><span class="btn-green-ic"><b class="icon-trash"></b>Delete</span></a>-->

        <a href="javascript:;" onclick="return verify();" class="fl"><span class="btn btn_blue btn-primary"><i class="fa fa-trash"></i>Delete</span></a>
        <?php
    }
    ?>
    <div class="spacer10"></div> 
</section>
<?php if ($this->Module_Model->ajax != 'Y') { ?>
    </div>
<?php } ?>