<script type="text/javascript">
    $(document).ready(function () {

        $(".country").click(function () {
            if ($(this).is(':checked')) {
                $("." + $(this).data('class')).prop('checked', true);
            } else {
                $("." + $(this).data('class')).prop('checked', false);
            }
            var Class = $(this).data('class');

            var ClassArray = Class.split("-");
            if (ClassArray[3] != 1) {

                var ViewClass = $(this).closest("tr").find("th.numeric").find("input[type='checkbox']").data('class');
                $("input[data-class='" + ViewClass + "']").prop("checked", true);
                $("." + ViewClass).prop('checked', true);

            }

        });

        $(".innerWebsite").click(function () {
            var Class = $(this).data('class');

            var ClassArray = Class.split("-");

            if ($(this).is(':checked')) {
                $(".innerWebsite" + $(this).data('class')).prop('checked', true);
            } else {
                $(".innerWebsite" + $(this).data('class')).prop('checked', false);
            }

            if (ClassArray[2] != 1) {

                var ViewClass = $(this).closest("tr").find("th.numeric").find("input[type='checkbox']").data('class');
                $("input[data-class='" + ViewClass + "']").prop("checked", true);
                $(".innerWebsite" + ViewClass).prop('checked', true);
            }

        });

        $(".ModuleChk").click(function () {
            if ($(this).is(':checked')) {
                $("." + $(this).data('class')).prop('checked', true);
            } else {
                $("." + $(this).data('class')).prop('checked', false);
            }
        });

        $(".selectall").click(function () {
            if ($(this).is(':checked')) {
                $("." + $(this).data('class')).prop('checked', true);
            } else {
                $("." + $(this).data('class')).prop('checked', false);
            }
        });

        $("#PUserGlCode").change(function () {
            SetBackground();
            $.ajax({
                type: "POST",
                url: "<?php echo MODULE_URL ?>groupaccess/GetAssignedAcces",
                data: "ajax=Y&PUserGlCode=" + $(this).val(),
                async: true,
                success: function (data) {
                    $('#gridbody').html(data);
                    UnsetBackground();
                }

            });
        });

        $("#useraccessform").validate({
            ignore: [],
            rules: {
                PUserGlCode: {
                    required: true
                }
            },
            messages: {
                PUserGlCode: {
                    required: "Please select user."
                }
            }
        });
    });


    function unselectallaction(checkid, ids, unceckid)
    {
        var idArray;
        var lengthArray = 0;
        var i = 0;
        if (ids != "")
        {
            idArray = ids.split(",");
            lengthArray = idArray.length;
            //if (document.getElementById(checkid).checked == false)
            if (!$('#' + checkid).is(':checked'))
            {
                for (i = 0; i < lengthArray; i++)
                {
                    $("#access-" + idArray[i]).prop("checked", false);
                }
                $("#selectall").prop("checked", false);
            }
            if (unceckid != "")
            {
                $("#" + unceckid).prop("checked", false);
            }
        }
    }

    function selectfirstaction(checkid, ids)
    {
        var idArray;
        var lengthArray = 0;
        var i = 0;
        if (ids != "")
        {
            idArray = ids.split(",");
            lengthArray = idArray.length;
            if (document.getElementById(checkid).checked == true)
            {
                for (i = 0; i < lengthArray; i++)
                {
                    $("#access-" + idArray[i]).prop("checked", "checked");
                }
            }
        }
    }

    function unselectall(checkid)
    {
        if (document.getElementById(checkid).checked == false)
        {
            $("input[name='access[]']").each(function () {
                this.checked = false;
            });
            $("input[name='chkmodule[]']").each(function () {
                this.checked = false;
            });
            $("input[name='chkaction[]']").each(function () {
                this.checked = false;
            });
        }
    }
</script>
<?php if ($ajax != 'Y') { ?>
    <div id="gridbody">
    <?php } ?>

    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><a href="<?php echo ADMINPANEL_URL . "user_management"; ?>">Manage user Access</a></li>
                </ul>
            </div>
        <?php
        if (validation_errors() != '') {
            echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide"><li>';
            echo validation_errors();
            echo '</li></ul></div></div>';
        }
        if ($messagebox != '') {
            echo '<div class="md-card-list-wrapper"><div class="md-card-list"><ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide"><li>';
            echo $messagebox;
            echo '</li></ul></div></div>';
        }
        ?>
            <?php
            $Attributes = array('name' => "useraccessform", 'id' => "useraccessform", 'method' => "POST");
            echo form_open($action, $Attributes);
            ?>
            <div class="md-card">
                <div class="md-card-content">

                    <input type="hidden" id="ehintglcode" name="ehintglcode" value="<?php echo $eid ?>" />
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <label> Select User</label> 
                                <div> <?php echo $UserDropDown ?>
                                    <label for="PUserGlCode"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-2-2">
                            <label> Access Information  </label>

                            <div id="<?php echo $Country->int_id . "-countryinfo" ?>">


                                <div class="fix_width" >


                                    <div class="fix_width" id="<?php echo $Website->int_id . "-webinfo" . $Country->int_id ?>" style=" padding: 20px;">
                                        <div class="inquiry-form">

                                            <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                                                <thead >
                                                    <tr>
                                                        <th><input class="selectall" data-class="<?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>" name="selectall" id="selectall" type="checkbox" /></th>
                                                        <th width="14%" align="left"><div class="title-text">Module Name</div></th>
                                                        <?php
                                                        foreach ($AllAction as $Action) {
                                                            ?>
                                                            <th><div class="title-text"><input class="country-<?php echo $Country->int_id ?>-Action-<?php echo $Action['ActionId'] ?> innerWebsite <?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>" data-class="<?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>-<?php echo $Action['ActionId'] ?>" name="chkaction[]" id="chkaction-<?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>-<?php echo $Action['ActionId'] ?>" type="checkbox" />&nbsp;<?php echo $Action['ActionName'] ?></div></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    $AllModule = $this->module_model->GetallModule();

                                                    foreach ($AllModule as $Module) {
                                                        ?>
                                                        <tr id="gtr-<?php echo $row['int_id'] ?>"   >
                                                            <td>
                                                                <input name="chkmodule[]" class="ModuleChk <?php echo $Country->int_id; ?>-<?php echo $Website->int_id; ?>" id="chkmodule-<?php echo $Module['ModuleId']; ?>" data-class="<?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>-<?php echo $Module['ModuleId'] ?>" type="checkbox" value="<?php echo $Module['ModuleId'] ?>" />
                                                            </td>
                                                            <td>
                                                                <?php echo $Module['varModuleName'] ?>
                                                            </td>
                                                            <?php
                                                            foreach ($AllAction as $Action) {

                                                                if ($Action['ActionId'] == 1) {
                                                                    $onclick = "unselectallaction('access-" . $Module['ModuleId'] . "-" . $Action['ActionId'] . "',$('#hidmodules-" . $Module['ModuleId'] . "').val(),'chkmodule-" . $Module['ModuleId'] . "-')";
                                                                } else {
                                                                    $onclick = "javascript:$('#access-" . $Module['ModuleId'] . "-1').prop('checked',true);";
                                                                }

                                                                if ($sel_innerwebaction[$Module['ModuleId']][$Action['ActionId']] == 'Y') {
                                                                    $checked = "checked";
                                                                } else {
                                                                    $checked = "";
                                                                }


                                                                $Disable = "";
                                                                $modulewiseids .= $Module['ModuleId'] . '-' . $Action['ActionId'] . ',';
                                                                $ModuleWiseValue = $Module['ModuleId'] . '-' . $Action['ActionId'];
                                                                $actionwiseids[$Action['ActionName']] .= $Module['ModuleId'] . '-' . $Action['ActionId'] . ',';
                                                                ?>

                                                                <td>  
                                                                    <?php if ($Module['ModuleId'] != 3) { ?>
                                                                        <input <?php echo $checked ?> class="<?php echo $Country->int_id ?>-<?php echo $Website->int_id ?> <?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>-<?php echo $Module['ModuleId'] ?>  innerWebsite<?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>-<?php echo $Action['ActionId'] ?> country-<?php echo $Country->int_id ?>-Action-<?php echo $Action['ActionId'] ?>"  name="access[]" id="access-<?php echo $Module['ModuleId'] . '-' . $Action['ActionId']; ?>" <?php echo $Disable ?> type="checkbox" value="<?php echo $ModuleWiseValue; ?>" onclick="<?php echo $onclick; ?>"/>&nbsp;  

                                                                    <?php } else {
                                                                        ?>
                                                                        <input type="hidden" checked="checked" class="<?php echo $Country->int_id ?>-<?php echo $Website->int_id ?> <?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>-<?php echo $Module['ModuleId'] ?>  innerWebsite<?php echo $Country->int_id ?>-<?php echo $Website->int_id ?>-<?php echo $Action['ActionId'] ?> country-<?php echo $Country->int_id ?>-Action-<?php echo $Action['ActionId'] ?>"  name="access[]" id="access-<?php echo $Module['ModuleId'] . '-' . $Action['ActionId']; ?>" <?php echo $Disable ?> value="<?php echo $ModuleWiseValue; ?>"/>&nbsp;  
                                                                    </td>
                                                                    <?php
                                                                }
                                                            }
                                                            ?> 
                                                    <input type="hidden" name="hidmodules[]" id="hidmodules-<?php echo $Module['ModuleId']; ?>" value="<?php echo $modulewiseids; ?>">    </tr>
                                                    <?php
                                                    $modulewiseids = "";
                                                }
                                                foreach ($AllAction as $Action) {
                                                    ?>
                                                    <input type="hidden" name="hidactions[]" id="hidactions-<?php echo $Action['ActionId']; ?>" value="<?php echo $actionwiseids[$Action['ActionName']]; ?>">
                                                <?php } ?>
                                                </tbody>
                                            </table>	
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                    </div> 
                    <div class="md-card-content">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-form-row">
                                <button value="Save &amp; Keep Editing" class="md-btn md-btn-primary md-btn-wave-light" id="btnsaveandc" name="btnsaveandc">Save &amp; Keep Editing</button>
                                <button value="Save &amp; Exit" id="btnsaveande" class="md-btn md-btn-primary md-btn-wave-light" name="btnsaveande">Save &amp; Exit</button>
                                <a href="<?php echo MODULE_URL . "accesscontrol"; ?>"><div class="md-btn md-btn-wave">Cancel</div></a>
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div>
    <?php echo form_close(); ?>
    <?php if ($ajax != 'Y') { ?>
    </div>  
    <?php
} 