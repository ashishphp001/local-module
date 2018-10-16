<style>
    #exportform {
        float: left;
        margin-right: 10px;
    }
</style>
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
            UIkit.modal.alert('Please select atleast one record to be deleted.');
            return false;
        }
        UIkit.modal.confirm('Caution! The selected records will be deleted. Press OK to confirm.', function () {
            if (CheckedLength > 0) {
                SendGridBindRequest('<?php echo $this->module_model->DeletePageName ?>', 'gridbody', 'D', 'chkgrow');
            }
        });
    }
</script>
<?php if ($this->module_model->ajax != 'Y') { ?>    
    <div id="gridbody">
    <?php } ?>      
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Contact Us Leads</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Contact Us Leads</h3> 

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>     
                            <tr>  
                                <th><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>                
                                <th>Name</th>
                                <th>Company Name/Website</th>
                                <th>Email ID</th>   
                                <th>Phone</th>    
                                <th>Message</th>
                                <th>Date / Time</th>                                
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
                                        <td>
                                            <input type="checkbox" value="<?php echo $row->int_id; ?>" id="chkgrow" name="chkgrow">
                                        </td>
                                        <td>
                                            <div class="title-text">
                                                <?= $row->varName; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="title-text">
                                                <?= $row->varCompanyName; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $row->varEmailId; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row->varPhone != '0' && $row->varPhone != '') {
                                                echo $row->varPhone;
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($row->txtMessage != '') { ?>
                                                <button class="md-btn" data-uk-modal="{target:'#modal_default<?php echo $row->int_id; ?>'}">Open</button>
                                                <div class="uk-modal" id="modal_default<?php echo $row->int_id; ?>">
                                                    <div class="uk-modal-dialog">
                                                        <button type="button" class="uk-modal-close uk-close"></button>
                                                        <?php
                                                        echo $row->txtMessage;
                                                        ?>
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
                                            echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($row->dtCreateDate)) . ' ' . $row->Date;
                                            ?>
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
                    <?php
                    if ($counttotal > 0) {
                        ?>   
                        <button onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</button>
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
                        <button  onclick="return excelreport();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">import_export</i>Export</button>

                        <?php
                        echo form_close();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->module_model->ajax != 'Y') { ?>  
    </div>
<?php } ?>