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
    <?php } ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Common Files</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Common Files</h3>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">    
                        <thead class="cf">
                            <tr>                                                
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Title</th>
                                <th>File</th>
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
                            $RowCountCommonFiles = 0;
                            if (!empty($ShowAllcommonfilesRecords)) {
                                foreach ($ShowAllcommonfilesRecords as $Row) {
                                    ?>
                                    <tr> 
                                        <td>
                                            <input type="checkbox" value="<?php echo $Row['int_id']; ?>" id="chkgrow" name="chkgrow">                                    
                                        </td>
                                        <td><?php echo $Row['varTitle']; ?></td>
                                        <td>
                                            <?php
                                            if ($Row['varFile'] != '') {
                                                $filepath = $Row['varFile'];
                                                $filepath1 = 'upimages/commonfiles/' . $filepath;


                                                $fileexntension = substr(strrchr($Row['varFile'], '.'), 1);
                                                $filetolowwer = strtolower($fileexntension);
                                                $p = explode('.', $Row['varFile']);
                                                if ($filetolowwer == 'doc' || $filetolowwer == 'DOC' || $filetolowwer == 'docx' || $filetolowwer == 'DOCX') {
                                                    $t = 'WORD.png';
                                                } else if ($filetolowwer == 'zip' || $filetolowwer == 'rar') {
                                                    $t = 'mime_zip.png';
                                                } else if ($filetolowwer == 'ppt' || $filetolowwer == 'pptx') {
                                                    $t = "ppt-icon.png";
                                                } else if ($filetolowwer == 'xls' || $filetolowwer == 'xlsx') {
                                                    $t = "xls-icon.png";
                                                } else {
                                                    $t = 'acrobate-readericon.png';
                                                }
                                                if (file_exists($filepath1)) {
                                                    ?>
                                                    <?php // echo MODULE_PAGE_NAME; ?>
                                                    <a href="<?php echo MODULE_PAGE_NAME; ?>/download?file=<?= $Row['varFile'] ?>">
                                                        <img id="pdficon" height="16" width="16"  title="<?php echo htmlentities($Row['varFile']); ?>" src="<?= ADMIN_MEDIA_URL; ?>images/<?= $t ?>" style="vertical-align:middle;cursor:pointer;">
                                                    </a>
                                                    <?php
                                                } else {
                                                    echo "N/A";
                                                }
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
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-up.png" title="Move Up" style="cursor:pointer;"  onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountCommonFiles ?>', 'up', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&orderby=intDisplayOrder', '<?php echo $Row['int_id'] ?>', '&PageNumber=<?php echo $this->Module_Model->PageNumber; ?>')" border="0" />
                                            <?php } ?>                                                                        

                                            <?php if ($Row['intDisplayOrder'] < $this->Module_Model->NumOfRows) { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" style="cursor:pointer;" onclick="DisplayOrderSpinner('displayorder<?php echo $RowCountCommonFiles ?>', 'down', '<?php echo $this->Module_Model->module_url ?>', '<?php echo $this->Module_Model->UrlWithoutSort ?>&orderby=intDisplayOrder', '<?php echo $Row['int_id'] ?>', '&PageNumber=<?php echo $this->Module_Model->PageNumber; ?>')" border="0" />
                                            <?php } else { ?>
                                                &nbsp;&nbsp;<img src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>images/arrow-down.png" title="Move Down" border="0" />
                                            <?php } ?>                                                     
                                            <input type="hidden" name="displayorder<?php echo $RowCountCommonFiles ?>" id="displayorder<?php echo $RowCountCommonFiles ?>" value="<?php echo $Row['intDisplayOrder']; ?>" />
                                            <input type="hidden" name="hdndisplayorder<?php echo $RowCountCommonFiles ?>" id="hdndisplayorder<?php echo $RowCountCommonFiles ?>" value="<?php echo $Row['intDisplayOrder']; ?>" />
                                            <input type="hidden" name="hdnintglcode<?php echo $RowCountCommonFiles ?>" id="hdnintglcode<?php echo $RowCountCommonFiles ?>"  value="<?php echo $Row['intDisplayOrder']; ?>" />
                                        </td>
                                        <?php if ($permissionArry['Publish/Export'] == 'Y') { ?>



                                            <td>
                                                <div class="title-text settings-setter">
                                                    <?php
                                                    if ($Row['chrPublish'] == 'Y') {
                                                        $BackGround = "skyblue";
                                                    } else {
                                                        $BackGround = "white";
                                                    }
                                                    ?> 
                                                    <div data-val="<?php echo $Row['chrPublish'] == 'Y' ? true : false; ?>" id="button-<?php echo $Row['int_id'] ?>" class="buttononoff"  tablename="<?php echo DB_PREFIX . 'commonfiles' ?>" field="chrPublish" data-id="<?php echo $Row['int_id'] ?>" ></div>
                                                </div>
                                            </td>

                                        <?php } ?>
                                        <?php if ($permissionArry['Edit'] == 'Y') { ?>
                                            <td>

                                                <a href="<?php echo $this->Module_Model->AddUrlWithPara ?>&eid=<?php echo $Row['int_id']; ?>"> <i class="md-icon material-icons">&#xE254;</i></a>
                                                <?php
                                                ?> 
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                    $RowCountCommonFiles++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="12" align="center"><strong><?php echo NO_RECORDS ?></strong></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>	

                    <input type="hidden" value="<?php echo $this->Module_Model->PageNumber; ?>" id="PageNumber" name="PageNumber">
                    <input type="hidden" value="<?php echo $this->Module_Model->PageSize; ?>" id="PageSize" name="PageSize">
                    <input type="hidden" value="<?php echo $RowCountCommonFiles; ?>" id="ptrecords" name="ptrecords">

                    <div class="spacer10"></div>
                    <?php
                    if ($permissionArry['Delete'] == 'Y' && $this->Module_Model->NumOfRows > 0) {
                        ?>   
                    <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                        <!--<a href="javascript:;" onclick="return verify();" class="fl"><span class="btn btn_blue btn-primary"><i class="fa fa-trash"></i>Delete</span></a>-->
                        <?php
                    }
                    ?>
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