<script type="text/javascript">
    function excelreport()
    {
        var chkelements = document.getElementsByName('chkgrow');
        var ids = "";
        var countChecked = 0;
        for (var i = 0; i < chkelements.length; i++)
        {
            if (chkelements.item(i).checked == true)
            {
                countChecked++;
                if (ids != "")
                    ids += ",";
                ids += chkelements.item(i).value;
            }
        }
        var totalpagerecords = document.getElementById('ptrecords').value;
        var fk_Service = document.getElementById('fk_Service').value;
        document.getElementById('totalrecords').value = totalpagerecords;
        document.getElementById('chkids').value = ids;
        appendurl = 'export&ptotalr=' + totalpagerecords + '&dids=' + ids + '&fk_Service=' + fk_Service;
        document.forms["exportform"].submit();
    }
    function verify()
    {
//        var PageSize = document.getElementById("PageSize").value;
        var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
        if (CheckedLength == 0) {
            jAlert('Please select atleast one record to be deleted.');
            return false;
        }
        if (CheckedLength > 0) {
            jConfirm('Caution! The selected records will be deleted. Press OK to confirm.', 'Confirmation Dialog', function (r)
            {
                if (r) {
                    SendGridBindRequest('<?php echo $this->module_model->DeletePageName ?>', 'gridbody', 'D', 'chkgrow');
                } else {
                    return false;
                }
            });
        }
    }
</script>
<?php if ($this->module_model->ajax != 'Y') { ?>    
    <div id="gridbody" class="content-wrapper" style="min-height: 699px;">
    <?php } ?>      
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
        <?php echo "<h1>" . $HeaderPanel . "</h1>"; ?>  
    </section> <section class="content"><div class="page_wrapper">
            <?php
            if ($messagebox != '') {
                echo $messagebox;
            }
            ?>    
            <div class="box-header">
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
                                <th width="4%" align="left"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>                
                                <th width="15%" align="left"><div class="title-text">
                                        <a href="javascript:;" onclick="SendGridBindRequest('<?= $this->module_model->UrlWithoutSort ?>&OrderBy=varName&sorting=Y', 'gridbody', 'ST')">Name
                                            <?php echo $setsortimgvarName; ?>
                                        </a>
                                    </div>
                                </th>
                                <th width="15%" align="center" class="numeric">
                                    <div class="title-text"> 
                                        <a href="javascript:;" onclick="SendGridBindRequest('<?= $this->module_model->UrlWithoutSort ?>&OrderBy=varEmailId&sorting=Y', 'gridbody', 'ST')">Email ID
                                            <?php echo $setsortimgvarEmailId; ?>
                                        </a>
                                    </div>
                                </th>   
                                <th width="10%" align="center" class="numeric">
                                    <div class="title-text"> 
                                        <a href="javascript:;" onclick="SendGridBindRequest('<?= $this->module_model->UrlWithoutSort ?>&OrderBy=intCareer&sorting=Y', 'gridbody', 'ST')">Applied for
                                            <?php echo $setsortimgintCareer; ?>
                                        </a>
                                    </div>
                                </th>    
                                <th width="10%" align="center" class="numeric">
                                    <div class="title-text"> 
                                        <a href="javascript:;" onclick="SendGridBindRequest('<?= $this->module_model->UrlWithoutSort ?>&OrderBy=varPhone&sorting=Y', 'gridbody', 'ST')">Phone
                                            <?php echo $setsortimgvarPhone; ?>
                                        </a>
                                    </div>
                                </th>  
                                <th width="5%" align="center" class="numeric">
                                    <div class="title-text" align="center"> 
                                        CV
                                    </div>
                                </th>   
                                <th width="5%" align="center" class="numeric">
                                    <div class="title-text" align="center">
                                        Message
                                    </div>
                                </th>
                                <th width="15%" align="center" class="numeric"><div class="title-text" align="center">
                                        <a href="javascript:;" onclick="SendGridBindRequest('<?= $this->module_model->UrlWithoutSort ?>&OrderBy=dtCreateDate&sorting=Y', 'gridbody', 'ST')">Date / Time
                                            <?php echo $setsortimgdtCreateDate; ?>
                                        </a></div>
                                </th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowcount = 0;
                            if ($counttotal > 0) {
                                foreach ($selectAll as $row) {
                                    $tickimg = ($row->chrPublish == 'Y') ? "tick.png" : "tick_cross.png";
                                    ?>
                                    <tr>
                                        <td align="left" valign="top">
                                            <input type="checkbox" value="<?php echo $row->int_id; ?>" id="chkgrow" name="chkgrow">
                                        </td>
                                        <td align="left" valign="top">
                                            <div class="title-text">
                                                <?= $row->varName; ?>
                                            </div>
                                        </td>
                                        <td align="left" valign="top">
                                            <div class="title-text">
                                                <?php echo $row->varEmailId; ?>
                                            </div>
                                        </td>
                                        <td align="left" valign="top">
                                            <div class="title-text">
                                                <?php
                                                $getcareer = $this->module_model->getCareerName($row->intCareer);
                                                echo $getcareer['varPositionName'];
                                                ?>
                                            </div>
                                        </td>
                                        <td align="left" valign="top">
                                            <div class="title-text">
                                                <?php
                                                if ($row->varPhone != '0' && $row->varPhone != '') {
                                                    echo $row->varPhone;
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td valign="middle" align="center" class="grid-td-top">
                                            <?php
                                            if ($row->varFile != '') {
                                                $filepath = $row->varFile;
                                                $filepath1 = 'upimages/careerleads/' . $filepath;


                                                $fileexntension = substr(strrchr($row->varFile, '.'), 1);
                                                $filetolowwer = strtolower($fileexntension);
                                                $p = explode('.', $row->varFile);
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
                                                    <a href="<?php echo MODULE_PAGE_NAME; ?>/download_pdf?file=<?= $row->varFile ?>">
                                                        <img id="pdficon" height="16" width="16"  title="<?php echo htmlentities($row->varFile); ?>" src="<?= ADMIN_MEDIA_URL; ?>images/<?= $t ?>" style="vertical-align:middle;cursor:pointer;">
                                                    </a>
                                                    <?php
                                                } else {
                                                    echo "N/A";
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td align="center" valign="top">
                                            <?php if (!empty($row->txtMessage)) { ?>
                                                <a class="fancybox-buttons"  data-fancybox-group="button" href="#test<?php echo $row->int_id ?>" >
                                                    <span class="btn-green " title="View Message">View</span>
                                                    <div id="test<?php echo $row->int_id ?>" style="display:none;min-height: 180px;min-width: 370px;">
                                                        <span class="detail-title">Message of <?php echo $row->varName; ?></span>
                                                        <div>
                                                            <?php echo nl2br($row->txtMessage); ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php } else { ?>
                                                N/A
                                            <?php } ?>
                                        </td>
                                        <td align="left" valign="top">
                                            <div class="title-text" align="center">
                                                <?php
                                                echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($row->dtCreateDate)) . ' ' . $row->Date;
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $rowcount++;
                                }
                            } else {
                                ?>
                                <tr style="background-color: transparent;"  class="<?= $clsname ?>" onmouseover="this.style.backgroundColor = '#f6f6f6'" onmouseout="this.style.backgroundColor = 'transparent'"> 
                                    <td height="25px" align="center" valign="middle" colspan="8" class="form_titles">
                                        No new leads, Please find out how to get more leads.
                                    </td>
                                </tr>
                                <?php
                            }
                            echo form_hidden('ptrecords', $rowcount);
                            ?>
                        </tbody>       
                    </table>
                    <!--</div>-->
                    <?php // echo $PagingBottom;   ?>
                    <div class="spacer10"></div> 
                    <?php
                    if ($counttotal > 0) {
                        ?>   
                        <a href="javascript:;" onclick="return verify();" class="fl"><span class="btn btn_blue btn-primary"><i class="fa fa-trash"></i>Delete</span></a> 
                            <!--<a href="javascript:;" onclick="return verify();" class="fl mgr10"><span class="btn-green-ic"><b class="icon-trash"></b>Delete</span></a>-->
                        <?php
                    }
                    ?>
                    <?php
                    if ($counttotal > 0) {
                        $action = MODULE_URL . "Export?rid=" . $_REQUEST['rid'] . "&modval=" . $_REQUEST['modval'] . "&PageSize=" . $this->module_model->PageSize;
                        $attributes = array('name' => 'exportform', 'id' => 'exportform', 'enctype' => 'multipart/form-data');
                        echo form_open($action, $attributes);
                        echo form_hidden('totalrecords', '');
                        echo form_hidden('chkids', '');
                        echo form_hidden('searchtxt_ids', $_REQUEST['SearchTxt']);
                        echo form_hidden('SearchBy', $_REQUEST['SearchBy']);
                        echo form_hidden('orderby', $_REQUEST['OrderBy']);
                        echo form_hidden('ordertype', $_REQUEST['OrderType']);
                        echo form_hidden('PageSize', $_REQUEST['PageSize']);
                        echo form_hidden('fk_Service', $_REQUEST['fk_Service']);
                        ?>
                        <a href="javascript:;" style="margin-left:10px;" onclick="return excelreport();" class="fl"><span class="btn btn_blue btn-primary"><i class="fa fa-external-link"></i>Export</span></a> 
                        <?php
                        echo form_close();
                    }
                    ?>
                    <div class="spacer5"></div>
            </section>
    </section>
</div>
<?php if ($this->module_model->ajax != 'Y') { ?>  
    </div>
<?php } ?>