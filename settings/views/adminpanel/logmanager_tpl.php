<script type="text/javascript">
    function verify()
    {
        var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
        if (CheckedLength == 0) {
            UIkit.modal.alert('Please select atleast one record to be deleted.');
            return false;
        }
        UIkit.modal.confirm('Caution! The selected records will be deleted. Press OK to confirm.', function () {
            if (CheckedLength > 0) {
                SendGridBindRequest('<?php echo $this->Module_Model->DeletePageName ?>', 'gridbody', 'D', 'chkgrow');
            } else {
                return false;
            }
        });
    }

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
        document.getElementById('totalrecords').value = totalpagerecords;
        document.getElementById('chkids').value = ids;
        appendurl = 'Export&ptotalr=' + totalpagerecords + '&dids=' + ids;
        document.forms["exportform"].submit();
    }

    function Delete_Logs() {
        UIkit.modal.confirm('Caution! All Log records will be deleted. Press OK to confirm.', function () {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adminpanel/settings/LogsDelete?",
                async: true,
                success: function ()
                {
                    UIkit.modal.alert("Congratulation all logs are deleted successfully.");
                    location.reload();
                    return false;
                }
            });

        });
    }

</script>
<?php if ($this->input->get_post('ajax') != 'Y') {
    ?>
    <div id="gridbody">
    <?php } ?>

    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Log manager</span></li>
                </ul>
            </div>
            <h3 class="heading_b uk-margin-bottom">Manage Log manager</h3>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="uk-width-1-10 uk-text-center small_col"><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Module Name</th>   
                                <th>Title</th>   
                                <th>User Name</th>
                                <th>Date / Time</th>   
                                <th>IP Address</th>
                                <th>Operation</th>                     
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $RowCount = 0;
                            if ($CountTotal > 0) {
                                foreach ($SelectAll as $Row) {
                                    $Char = substr(htmlspecialchars_decode($Row->varName, ENT_QUOTES), 0, 55);
                                    if (strlen($Row->varName) > 55) {
                                        $Char .= '...';
                                    }
                                    ?>




                                    <tr id="gtr-<?php echo $Row->intGlcode ?>"  style="background-color: transparent;"  class="<?php echo $clsname ?>" onmouseover="this.style.backgroundColor = '#f6f6f6'" onmouseout="this.style.backgroundColor = 'transparent'" >
                                        <td width="3%" align="left" valign="middle" class="grid-td-left delete-class">
                                            <input name="chkgrow" id="chkgrow" type="checkbox" value="<?php echo $Row->intGlcode ?>" />
                                        </td>
                                        <td>
                                            <?php
                                            echo $Row->varModuleName;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            echo $Char;
                                            ?>

                                        </td>
                                        <td>
                                            <?php echo $Row->varLoginName; ?>
                                        </td>
                                        <td>
                                            <?php echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($Row->dtOperationDate)) . '&nbsp;&nbsp;&nbsp;' . $Row->Time; ?>
                                        </td>
                                        <td>
                                            <?php echo $Row->varIpAddress; ?>
                                        </td>
                                        <?php
                                        if ($Row->varOperation == 'I') {
                                            $Operation = "Insert";
                                        } else if ($Row->varOperation == 'U') {
                                            $Operation = "Update";
                                        } else if ($Row->varOperation == 'D') {
                                            $Operation = "Delete";
                                        } else if ($Row->varOperation == 'S') {
                                            $Operation = "Certificate Featured Status";
                                        }
                                        ?>
                                        <td>
                                            <?php echo $Operation; ?>
                                        </td>               
                                    </tr>
                                    <?php
                                    $RowCount++;
                                }
                            } else {
                                ?>
                                <tr style="background-color: transparent;"  class="" onmouseover="this.style.backgroundColor = '#f6f6f6'" onmouseout="this.style.backgroundColor = 'transparent'"> 
                                    <td height="25" align="center" valign="middle" colspan="8" class="form_titles">Sorry! No records are available.</td>
                                </tr>
                            <?php }
                            ?>

                        </tbody>
                    </table>
                    <input type="hidden" value="<?php echo $RowCount; ?>" id="ptrecords" name="ptrecords">
                    <div class="spacer10"></div> 
                    <?php
                    if ($CountTotal > 0) {
                        ?>
                        <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                        <?php if (USERTYPE == 'N') { ?>   
                            <a href="javascript:;"  onclick="return Delete_Logs();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete All Log Records</a>
                        <?php } ?>


                        <form name="exportform"  style="display:inline;" id="exportform" action="export?rid=<?php echo $_REQUEST['rid']; ?>&modval=<?php echo $_REQUEST['modval'] ?>&PageSize=<?php echo $_REQUEST['PageSize'] ?>"  method="post">
                            <input type="hidden" name="totalrecords" id="totalrecords" value="">
                            <input type="hidden" name="chkids" id="chkids" value="">
                            <input type="hidden" name='searchbytxt' id='searchbytxt' value="<?php echo $this->input->get_post('SearchBy'); ?>">
                            <input name="hdnvacancy_id" id="hdnvacancy_id" type="hidden" value="<?php echo $_REQUEST['rid']; ?>" />
                            <input type="hidden" name="modulename" id="modulename" value="<?php echo $_REQUEST['modulename']; ?>">

                            <?php
                            echo form_hidden('SearchTxt_ids', $this->Module_Model->SearchTxt);
                            echo form_hidden('OrderBy', $this->Module_Model->OrderBy);
                            echo form_hidden('OrderType', $this->Module_Model->OrderType);
                            ?>
                        </form>
                        <div class="spacer10"></div> 
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <?php if ($this->input->get_post('ajax') != 'Y') {
        ?>
    </div>
<?php } ?>
<!--</section>-->