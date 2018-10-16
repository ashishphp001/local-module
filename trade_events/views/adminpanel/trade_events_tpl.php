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
<?php if ($this->Module_Model->ajax != 'Y') { ?> 
    <div id="gridbody">
    <?php }
    ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Trade Events</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Trade Events</h3> 

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Title</th>
                                <th>Event Date</th>
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
                            $RowCounttrade_events = 0;
                            if (!empty($ShowAlltrade_eventsRecords)) {
                                foreach ($ShowAlltrade_eventsRecords as $Row_trade_events) {
                                    ?>           
                                    <tr>            
                                        <td>       
                                            <input type="checkbox" value="<?php echo $Row_trade_events['int_id']; ?>" id="chkgrow" name="chkgrow">                                    
                                        </td>   

                                        <td>          
                                            <?php echo $Row_trade_events['varTitle']; ?>                       
                                        </td>            
                                        <td>          
                                            <?php echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row_trade_events['dtEventDate'])); ?>       
                                        </td>            

                                        <td>
                                            <?php
                                            $imagename = $Row_trade_events['varImage'];
                                            $imagepath = 'upimages/trade_events/images/' . $imagename;

                                            if (file_exists($imagepath) && $Row_trade_events['varImage'] != '') {
                                                $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                                $image_thumb = image_thumb($imagepath, EVENT_WIDTH, EVENT_HEIGHT);
                                            }
                                            if ($imagename != "") {
                                                if (file_exists($imagepath)) {
                                                    ?> 
                                                    <div class="gallery_grid_item md-card-content">
                                                        <a href="<?php echo $image_thumb; ?>" data-uk-lightbox="{group:'gallery'}">
                                                            <img src="<?php echo $image_detail_thumb; ?>" title="<?php echo $Row_trade_events['varTitle']; ?>" alt="<?php echo $Row_trade_events['varTitle']; ?>">
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
                                            <?php if ($Row_trade_events['varShortDesc'] != "") { ?>
                                                <button class="md-btn" data-uk-modal="{target:'#modal_default<?php echo $Row_trade_events['int_id']; ?>'}">View</button>
                                                <div class="uk-modal" id="modal_default<?php echo $Row_trade_events['int_id']; ?>">
                                                    <div class="uk-modal-dialog">

                                                        <button type="button" class="uk-modal-close uk-close"></button>
                                                        <div class="uk-modal-header">
                                                            <h3 class="uk-modal-title">Short Description for <?php echo ($Row_trade_events['varTitle']); ?></h3>
                                                        </div>
                                                        <?php echo nl2br($Row_trade_events['varShortDesc']); ?>
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
                                            echo $Row_trade_events['intDisplayOrder'];

                                            if ($Row_trade_events['intDisplayOrder'] == 1) {
                                                ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" border="0" />  
                                            <?php } else { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $RowCounttrade_events ?>', 'up', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Row_trade_events['int_id'] ?>')" border="0" />
                                            <?php } ?>                                                                        

                                            <?php if ($Row_trade_events['intDisplayOrder'] < $this->Module_Model->NumOfRows) { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" style="cursor:pointer;" onclick="DisplayOrderSpinner('displayorder<?php echo $RowCounttrade_events ?>', 'down', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&OrderBy=intDisplayOrder', '<?php echo $Row_trade_events['int_id'] ?>')" border="0" />
                                            <?php } else { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" border="0" />
                                            <?php } ?>                                                     
                                            <input type="hidden" name="displayorder<?php echo $RowCounttrade_events ?>" id="displayorder<?php echo $RowCounttrade_events ?>" value="<?php echo $Row_trade_events['intDisplayOrder']; ?>" />
                                            <input type="hidden" name="hdndisplayorder<?php echo $RowCounttrade_events ?>" id="hdndisplayorder<?php echo $RowCounttrade_events ?>" value="<?php echo $Row_trade_events['intDisplayOrder']; ?>" />
                                            <input type="hidden" name="hdnintglcode<?php echo $RowCounttrade_events ?>" id="hdnintglcode<?php echo $RowCounttrade_events ?>"  value="<?php echo $Row_trade_events['intDisplayOrder']; ?>" />
                                        </td>
                                        <?php if ($permissionArry['Publish/Export'] == 'Y') { ?>                                  
                                            <td>                        
                                                <?php
                                                if ($Row_trade_events['chrPublish'] == 'Y') {
                                                    $BackGround = "skyblue";
                                                } else {
                                                    $BackGround = "white";
                                                }
                                                ?>                                           
                                                <div data-val="<?php echo $Row_trade_events['chrPublish'] == 'Y' ? true : false; ?>" id="button-<?php echo $Row_trade_events['int_id'] ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'trade_events' ?>" field="chrPublish" data-id="<?php echo $Row_trade_events['int_id'] ?>" ></div>   
                                            </td>                        
                                        <?php } ?>   

                                        <?php if ($permissionArry['Edit'] == 'Y') { ?>                                 
                                            <td> 
                                                <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row_trade_events['int_id']; ?>"> <i class="md-icon material-icons">&#xE254;</i></a>                                       
                                                <?php ?>            
                                            </td>                            
                                        <?php } ?>      
                                    </tr>                         
                                    <!--<tr id="pagehistory<?php echo $Row_trade_events['int_id'] ?>" > </tr>-->                          
                                    <?php
                                    $RowCounttrade_events++;
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
                    <input type="hidden" value="<?php echo $RowCounttrade_events; ?>" id="ptrecords" name="ptrecords">               

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