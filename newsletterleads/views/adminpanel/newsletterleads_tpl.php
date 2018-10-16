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

                                <th width="15%" align="center" class="numeric">
                                    <div class="title-text"> 
                                        <a href="javascript:;" onclick="SendGridBindRequest('<?= $this->module_model->UrlWithoutSort ?>&OrderBy=varEmail&sorting=Y', 'gridbody', 'ST')">Email ID
                                            <?php echo $setsortimgvarEmail; ?>
                                        </a>
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
                                                <?php echo $row->varEmail; ?>
                                            </div>
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
                    <?php // echo $PagingBottom;  ?>
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