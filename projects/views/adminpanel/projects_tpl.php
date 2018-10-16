<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_MEDIA_URL; ?>js/highslide/highslide.css" />
<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL; ?>js/highslide/highslide-full.js"></script>
<script type="text/javascript">
    hs.graphicsDir = '<?php echo ADMIN_MEDIA_URL; ?>js/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    hs.showCredits = false;
    hs.wrapperClassName = 'draggable-header';
    hs.align = 'center';
    hs.width = '400';
</script>
<script type="text/javascript">
    function showVal(intglcode) {
        $.ajax({
            type: "POST",
            url: "projects/get_publish?pub_id=" + intglcode, async: false,
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
        var PageSize = document.getElementById("PageSize").value;
        var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
        if (CheckedLength == 0) {
            jAlert('Please select atleast one record to be deleted.');
            return false;
        }
        if (CheckedLength > 0) {
            jConfirm('Caution! The selected records will be deleted. Press OK to confirm.', 'Confirmation Dialog',
                    function (r) {
                        if (r) {
                            SendGridBindRequest('<?php echo $this->Module_Model->DeletePageName ?>', 'gridbody', 'D', 'chkgrow', '', '', '&PageSize=' + PageSize);
                        } else {
                            return false;
                        }
                    });
        }
    }

</script>
<?php if ($this->Module_Model->ajax != 'Y') { ?> 
    <div id="gridbody" class="content-wrapper" style="min-height: 699px;">
        <?php
    }
    echo $HeaderPanel;
    if ($messagebox != '') {
        echo $messagebox;
    }
    ?>     
    <div class="box-header">
        <?php echo $this->mylibrary->Add_module_note('Projects', 'Project'); ?>
        <div class="table_entries">
            <div id="example1_length" class="dataTables_length">
                <?php echo $PagingTop; ?>
            </div>
        </div>
    </div>
    <section id="flip-scroll">		  
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">                 
                <thead class="cf">      
                    <tr>                                          
                        <th width="2%" align="left"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>   
                        <th width="10%" align="left">      
                            <div class="title-text">                
                                <a href="javascript:;" onclick="SendGridBindRequest('<?php echo $this->Module_Model->UrlWithOutSort; ?>&OrderBy=varShortName&sorting=Y', 'gridbody', 'ST')">Title                      
                                    <?php echo $setsortimgvarTitle; ?> 
                                </a>               
                            </div>             
                        </th>                  
                        <th width="3%" align="center">
                            <div class="title-text" align="center">Image</div>
                        </th>
                        <th width="5%" align="center">
                            <div class="title-text" align="center">Technology</div>
                        </th>
                        <th width="8%" align="center">
                            <div class="title-text" align="center">Images</div>
                        </th>
                        <th width="6%" align="left">
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


                        <?php if ($permissionArry['Edit'] == 'Y') { ?>                 
                            <th width="5%" align="center" class="numeric">
                                <div class="title-text" align="center">
                                    Edit
                                </div>
                            </th> 
                        <?php } ?>              
                    </tr>   
                </thead>  
                <tbody>        
                    <?php
                    $RowCountprojects = 0;
                    if (!empty($ShowAllprojectsRecords)) {
                        foreach ($ShowAllprojectsRecords as $Row_projects) {
                            ?>           
                            <tr>            
                                <td align="left" valign="top">       
                                    <input type="checkbox" value="<?php echo $Row_projects['int_id']; ?>" id="chkgrow" name="chkgrow">                                    
                                </td>   

                                <td align="left" valign="top">          
                                    <div class="title-text">
                                        <?php // echo $Row_projects['treename']; ?>
                                        <?php echo $Row_projects['varShortName']; ?>
                                    </div>                               
                                </td>                  

                                <td align="center" valign="top"><?php
                                    $imagename = $Row_projects['varImage'];
                                    $imagepath = 'upimages/projects/images/' . $imagename;

                                    if (file_exists($imagepath) && $Row_projects['varImage'] != '') {
                                        $image_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                        $image_thumb1 = image_thumb($imagepath, PROJECTS_WIDTH, PROJECTS_HEIGHT);
                                    }
                                    if ($imagename != "") {
                                        if (file_exists($imagepath)) {
                                            ?>      
                                            <a href="#varMenuIconImage<?php echo $Row_projects['int_id']; ?>"  class="fancybox-buttons" data-fancybox-group="button">
                                                <img width="20px" height="15px"  src="<?php echo $image_thumb; ?>" alt="View" title="<?php echo $Row_projects['varImage']; ?>" border="0" align="absmiddle" id="myimage" />
                                                <span id="varMenuIconImage<?php echo $Row_projects['int_id']; ?>" style="display:none">

                                                    <img title="<?php echo htmlentities($this->common_model->GetImageNameOnly($Row_projects['varImage'])); ?>" src="<?php echo $image_thumb1; ?>" alt="View" border="0" align="absmiddle" id="myimage" />

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


                                <td align="center" valign="top">
                                    <?php
                                    if ($Row_projects['varShortDesc'] != '') {
                                        if ($Row_projects['int_id'] == '6') {
                                            ?>
                                            <a class="fancybox-buttons" data-fancybox-group="button" href="<?php echo ADMINPANEL_URL . "photogallery?intProject=1" ?>" >
                                            <?php } else { ?>
                                                <a class="fancybox-buttons" data-fancybox-group="button" href="#test<?php echo $Row_projects['int_id'] ?>" >  
                                                <?php } ?>
                                                <span class="btn-green " title="View Information">View</span>
                                                <div id="test<?php echo $Row_projects['int_id'] ?>" style="display:none; height: 300px;width: 600px;">
                                                    <span class="detail-title">View Technologies of <?php echo ($Row_projects['varShortName']); ?></span>                                            
                                                    <div>
                                                        <?php
                                                        echo nl2br($Row_projects['varShortDesc']);
                                                        ?>

                                                    </div>
                                                </div>
                                            </a>
                                            <?php
                                        } else {
                                            echo "N/A";
                                        }
                                        ?>
                                </td>

                                <td align="left" valign="top">                       
                                    <div style="font:black;" align="center">          
                                        <a href="<?php echo ADMINPANEL_URL ?>photogallery?intProject=<?php echo ($Row_projects['int_id']) ?>"> Views & Add (<?php echo $Row_projects['totalPhotos'] ?>) 
                                        </a>                                                                         
                                    </div>                             
                                </td>

                                                                                                                                <td align="left" valign="top">
                                                                                                                                    <div class="title-text" align="center">
                                <?php
                                echo $Row_projects['intDisplayOrder'];

                                if ($Row_projects['intDisplayOrder'] == 1) {
                                    ?>
                                                                                                                                                                                            &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" border="0" />  
                                <?php } else { ?>
                                                                                                                                                                                            &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountprojects ?>', 'up', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Row_projects['int_id'] ?>')" border="0" />
                                <?php } ?>                                                                        

                                <?php if ($Row_projects['intDisplayOrder'] < $this->Module_Model->NumOfRows) { ?>
                                                                                                                                                                                            &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" style="cursor:pointer;" onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountprojects ?>', 'down', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Row_projects['int_id'] ?>')" border="0" />
                                <?php } else { ?>
                                                                                                                                                                                            &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" border="0" />
                                <?php } ?>                                                     
                                                                                                                                        <input type="hidden" name="displayorder<?php echo $RowCountprojects ?>" id="displayorder<?php echo $RowCountprojects ?>" value="<?php echo $Row_projects['intDisplayOrder']; ?>" />
                                                                                                                                        <input type="hidden" name="hdndisplayorder<?php echo $RowCountprojects ?>" id="hdndisplayorder<?php echo $RowCountprojects ?>" value="<?php echo $Row_projects['intDisplayOrder']; ?>" />
                                                                                                                                        <input type="hidden" name="hdnintglcode<?php echo $RowCountprojects ?>" id="hdnintglcode<?php echo $RowCountprojects ?>"  value="<?php echo $Row_projects['intDisplayOrder']; ?>" />
                                                                                                                                    </div>
                                                                                                                                </td>

<!--                                <td width="6%" align="center" valign="middle" class="grid-td-top">
                                    <?php
                                    if (!empty($Row_projects['intProject'])) {
                                        echo $Row_projects['DisplayOrder'];
                                    } else {
                                        echo $Row_projects['intDisplayOrder'];
                                    }

                                    if ($Row_projects['int_id'] != '1') {
                                        ?> 

                                        <input type="hidden"  name="displayorder<?= $RowCountprojects ?>" id="displayorder<?= $RowCountprojects ?>" style="width:50px; text-align:center;" onkeypress="return KeycheckOnlyNumeric(event);" value="<?= $Row_projects['intDisplayOrder'] ?>" />  
                                    <?php } else { ?> 
                                        <input type="hidden"  name="displayorder<?= $RowCountprojects ?>" id="displayorder<?= $RowCountprojects ?>" value="<?= $Row_projects['intDisplayOrder']; ?>" />
                                    <?php } ?>
                                    <input type="hidden"  name="hdndisplayorder<?= $RowCountprojects ?>" id="hdndisplayorder<?= $RowCountprojects ?>" style="width:50px; text-align:center;" value="<?= $Row_projects['intDisplayOrder']; ?>" />
                                    <input type="hidden" name="hdnintglcode<?= $RowCountprojects ?>" id="hdnintglcode<?= $RowCountprojects ?>" style="width:50px; text-align:center;" value="<?= $Row_projects['int_id'] ?>" />  


                                    <input type="hidden"  name="displayorder<?= $RowCountprojects ?>" id="displayorder<?= $RowCountprojects ?>" style="width:50px; text-align:center;" onkeypress="return KeycheckOnlyNumeric(event);" value="<?= $Row_projects['intDisplayOrder'] ?>" />  
                                    &nbsp;&nbsp;<img src="<?= ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up"  
                                    <?php
//                                    if (($Row_projects['intDisplayOrder'] != 2) || ($Row_projects['intProject'] != 0)) {
                                    if ($Row_projects['intDisplayOrder'] != 1) {
                                        ?>
                                                         style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountprojects ?>', 'up', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&orderby=intDisplayOrder', '<?php echo $Row_projects['int_id'] ?>', '<?php echo $Row_projects['intProject'] ?>&PageNumber=<?php echo $this->Module_Model->PageNumber; ?>')" 
                                                         <?php
                                                     }
//                                                     }
                                                     ?>                                                         
                                                     border="0" />
                                    &nbsp;&nbsp;<img src="<?= ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" 
                                    <?php
                                    if (($parentrec == $totalparent)) {
                                        $parentrec = $parentrec + 1;
                                    } else {
                                        if (($Row_projects['intDisplayOrder'] < $this->Module_Model->NumOfRows)) {
                                            ?>
                                                             style="cursor:pointer;"    onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountprojects ?>', 'down', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&orderby=intDisplayOrder', '<?php echo $Row_projects['int_id'] ?>', '<?php echo $Row_projects['intProject'] ?>&PageNumber=<?php echo $this->Module_Model->PageNumber; ?>')" 
                                                             <?php
                                                         }
                                                     }
                                                     ?> border="0" />

                                    <input type="hidden"  name="hdndisplayorder<?= $RowCountprojects ?>" id="hdndisplayorder<?= $RowCountprojects ?>" style="width:50px; text-align:center;" value="<?= $Row_projects['intDisplayOrder']; ?>" />
                                    <input type="hidden" name="hdnintglcode<?= $RowCountprojects ?>" id="hdnintglcode<?= $RowCountprojects ?>" style="width:50px; text-align:center;" value="<?= $Row_projects['int_id'] ?>" />  
                                </td>-->

                                <?php if ($permissionArry['Publish/Export'] == 'Y') { ?>                                  
                                    <td align="left" valign="top">                        
                                        <div class="title-text settings-setter" align="center">      
                                            <?php
                                            if ($Row_projects['chrPublish'] == 'Y') {
                                                $BackGround = "skyblue";
                                            } else {
                                                $BackGround = "white";
                                            }
                                            ?>                                           
                                            <div data-val="<?php echo $Row_projects['chrPublish'] == 'Y' ? true : false; ?>" id="button-<?php echo $Row_projects['int_id'] ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'projects' ?>" field="chrPublish" data-id="<?php echo $Row_projects['int_id'] ?>" onclick="return showVal('<?php echo $Row_projects['int_id'] ?>', '<?php echo $Row_projects['chrPublish'] == 'Y' ? "Y" : "N"; ?>');"></div>   
                                        </div>                         
                                    </td>                        
                                <?php } ?>   

                                <?php if ($permissionArry['Edit'] == 'Y') { ?>                                 
                                    <td align="center" valign="top"> 
                                        <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_projects['int_id']; ?>"> <img width="16" height="16" src="<?php echo ADMIN_MEDIA_URL_DEFAULT ?>images/edit.png" alt="Edit" title="Click here to edit.">
                                        </a>                                       
                                        <?php ?>            
                                    </td>                            
                                <?php } ?>      
                            </tr>                         
                            <tr id="pagehistory<?php echo $Row_projects['int_id'] ?>" >                
                            </tr>                          
                            <?php
                            $RowCountprojects++;
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
                <input type="hidden" value="<?php echo $this->Module_Model->PageNumber; ?>" id="PageNumber" name="PageNumber">              
                <input type="hidden" value="<?php echo $this->Module_Model->PageSize; ?>" id="PageSize" name="PageSize">           
                <input type="hidden" value="<?php echo $RowCountprojects; ?>" id="ptrecords" name="ptrecords">               
                </tbody>       
            </table>
        </div>
    </section>       
    <?php // echo $PagingBottom;      ?> 
    <div class="spacer10"></div>     
    <?php if ($permissionArry['Delete'] == 'Y' && $this->Module_Model->NumOfRows > 0) { ?>            


        <a href="javascript:;" onclick="return verify();" class="fl"><span class="btn btn_blue btn-primary"><i class="fa fa-trash"></i>Delete</span></a> 
    <?php } ?>       
    <div class="spacer10"></div>    
</section>  
<?php if ($this->Module_Model->ajax != 'Y') { ?> 
    </div>
<?php } ?>