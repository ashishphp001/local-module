<script type="text/javascript">
    function selectallaction(checkid,ids)
    {
        var idArray;
        var lengthArray=0;
        var i=0;
    
        if(ids!="")
        {
            idArray=ids.split(",");

            lengthArray=idArray.length;
		
            if(document.getElementById(checkid).checked==true)
            {
                for(i=0;i<lengthArray;i++)
                {
                    $("#chkaccess-"+idArray[i]).attr("checked","checked");
                }
            }
            else
            {
                for(i=0;i<lengthArray;i++)
                {
                    $("#chkaccess-"+idArray[i]).attr("checked",false);
                }
                $("#selectall").attr("checked",false);
            }
        }
    }

    function unselectallaction(checkid,ids,unceckid)
    {
        var idArray;
        var lengthArray=0;
        var i=0;
    
        if(ids!="")
        {
            idArray=ids.split(",");
            lengthArray=idArray.length;
            if(document.getElementById(checkid).checked==false)
            {
                for(i=0;i<lengthArray;i++)
                {
                    $("#chkaccess-"+idArray[i]).attr("checked",false);
                }
                $("#selectall").attr("checked",false);
            }
            if(unceckid!="")
            {
                $("#"+unceckid).attr("checked",false);
            }
        }
    }

    function selectfirstaction(checkid,ids)
    {
        var idArray;
        var lengthArray=0;
        var i=0;
    
        if(ids!="")
        {
            idArray=ids.split(",");
            lengthArray=idArray.length;
            if(document.getElementById(checkid).checked==true)
            {
                for(i=0;i<lengthArray;i++)
                {
                    $("#chkaccess-"+idArray[i]).attr("checked","checked");
                }
            }
        }
    }

    function unselectall(checkid)
    {
        if(document.getElementById(checkid).checked==false)
        {
            $("input[name='chkaccess[]']").each(function() {
                this.checked = false;
            });
            $("input[name='chkmodule[]']").each(function() {
                this.checked = false;
            });
            $("input[name='chkaction[]']").each(function() {
                this.checked = false;
            });
        }

    }

    function selelectallchk()
    { 
        if(document.getElementById('selectall').checked==true)
        {
            $("input[name='chkaccess[]']").each(function() {
                this.checked = true;
            });
            $("input[name='chkmodule[]']").each(function() {
                this.checked = true;
            });
            $("input[name='chkaction[]']").each(function() {
                this.checked = true;
            });
        }
        else
        {
            $("input[name='chkaccess[]']").each(function() {
                this.checked = false;
            });
            $("input[name='chkmodule[]']").each(function() {
                this.checked = false;
            });
            $("input[name='chkaction[]']").each(function() {
                this.checked = false;
            });
	
        }
	
        $(".case").click(function(){
 
            if($(".case").length == $(".case:checked").length) {
                $("#selectall").attr("checked", "checked");
            } else {
                $("#selectall").removeAttr("checked");
            }
 
        });
    }

var flag_validation = true;

    function validate()
    {
        var count =0;
        $("input[name='chkaccess[]']").each(function() {
	
            if(this.checked==true)
            {
                count ++;
            }
        });
        if(count==0)
        {
            alert("Please select access rights for modules.");
            return false;
        }
        else
        {
              // prevent resubmitting of form
           if(!flag_validation){
                return false;
            }

            if(flag_validation){
                flag_validation =false;
            }
            document.advertisementform.submit();
        }
    }
</script>
<div class="content">
    <!--start middle section-->
    <section class="MiddleSection"> 
        <div class="spacer10"></div>
        <div class="fl"> <h1><b class="icon-list-ul"></b> <?php if (!empty($eid)) { ?>
               Edit Assign Action
                <?php } else { ?>
               Add Assign Action
                <?php } ?></h1></div>

        <div class="spacer10"></div>        
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
       <form method="post" name="advertisementform" id="advertisementform" action ="<?= $action ?>" onsubmit="return validate();" enctype="multipart/form-data">
        <input type="hidden" id="ehintglcode" name="ehintglcode" value="<?= $eid ?>" />
        <div class="main-form-box">
            <div class="spacer10"></div>

            <div class="contact-title" onclick="javascript:expandcollapsepanel('accessinformation');">Access Information</div>
            <div class="spacer10"></div>

            <div class="fix_width" id="accessinformation" style="padding:20px;">
                <div class="inquiry-form">
                    <table border="0" cellpadding="0" cellspacing="0" class="table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th width="4%" align="left"><input class="checkallcheckbox" name="selectall" id="selectall" type="checkbox" onclick="selelectallchk();"/></th>
                        <th width="24%" align="left"><div class="title-text">Module Name</div></th>
                        <?php
                    foreach ($AllAction as $Action) {
                        if ($Action['actionId'] == 1) {
                            $onclick = "selectallaction('chkaction-" . $Action[actionId] . "',$('#hidactions-" . $Action[actionId] . "').val());unselectall('chkaction-" . $Action[actionId] . "');";
                        } else {
                            $onclick = "selectallaction('chkaction-" . $Action[actionId] . "',$('#hidactions-" . $Action[actionId] . "').val());selectfirstaction('chkaction-" . $Action[actionId] . "',$('#hidactions-1').val());";
                        }
                        ?> 
                        <th width="12%" align="left"><div class="title-text">
                            <input class="checkallcheckbox" name="chkaction[]" id="chkaction-<?php echo $Action['actionId'] ?>" type="checkbox" onclick="<?php echo $onclick; ?>"  />&nbsp;<?php echo $Action['actionName'] ?></div></td>
                    <?php } ?>
                    </tr>
                </thead>
                <tbody>
                         <?php  $i=0; 
                    foreach ($AllModule as $Module) { 
                            if($Module['chrcustom']=='Y' && $i==0) { ?>
                    <tr>
                        <td width="100%" align="left" colspan="9"  valign="middle" class="grid-td-top">
                        <div class="grid-list-subtitle-bg" style="padding: 0px 0 0px 0px;" >
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="100%" align="left"  valign="middle" class="grid-td-left">Custom Modules</td>
                                </tr>
                            </table>
                        </div>
                        </td>
                    </tr>
                <?php  $i++ ; } ?>
                            <tr id="gtr-<?= $row['int_glcode'] ?>"   >
                                <td align="left" valign="top">
                                    <input name="chkmodule[]" id="chkmodule-<?php echo $Module['moduleId'] . '-' . $Module['chrcustom']; ?>" type="checkbox" value="<?php echo $row['int_glcode'] ?>" onclick="selectallaction('chkmodule-<?php echo $Module['moduleId'] . '-' . $Module['chrcustom']; ?>',$('#hidmodules-<?php echo $Module['moduleId'] . '-' . $Module['chrcustom']; ?>').val())"/>
                                </td>
                                <td align="left" valign="top">
                                    <div class="title-text">
                                    <?php echo $Module['chr_pro_modulename'] ?>
                                    </div>     
                                </td>
                                <?php
                            foreach ($AllAction as $Action) {

  
                                if ($Action['actionId'] == 1) {
                                    $onclick = "unselectallaction('chkaccess-" . $Module[moduleId] . "-" . $Action[actionId] . "-" . $Module[chrcustom] . "',$('#hidmodules-" . $Module[moduleId] . "-" . $Module[chrcustom] . "').val(),'chkmodule-" . $Module['moduleId'] . "-" . $Module['chrcustom'] . "')";
                                } else {
                                    $onclick = "javascript:$('#chkaccess-" . $Module['moduleId'] . "-1-" . $Module['chrcustom'] . "').attr('checked',true);";
                                }

                                if ($actionmodule[$Module['moduleId']][$Action['actionId']][$Module['chrcustom']] == $Module['moduleId'] . '-' . $Action['actionId'] . '-' . $Module['chrcustom']) {
                                    $checked = "checked";
                                } else {
                                    $checked = "";
                                } ?>
                                <td align="left" valign="top">
                                    <div class="title-text">
                                    <input <?php echo $checked ?> class="checkallcheckbox"  name="chkaccess[]" id="chkaccess-<?php echo $Module['moduleId'] . '-' . $Action['actionId'] . '-' . $Module['chrcustom']; ?>" type="checkbox" value="<?php echo $Module['moduleId'] . '-' . $Action['actionId'] . '-' . $Module['chrcustom']; ?>" onclick="<?php echo $onclick; ?>"/>&nbsp;</div></td>
                                <?php
                                $modulewiseids .= $Module['moduleId'] . '-' . $Action['actionId'] . '-' . $Module['chrcustom'] . ',';
                                $actionwiseids[$Action['actionName']] .= $Module['moduleId'] . '-' . $Action['actionId'] . '-' . $Module['chrcustom'] . ',';
                            }
                            ?>   <input type="hidden" name="hidmodules[]" id="hidmodules-<?php echo $Module['moduleId'] . '-' . $Module['chrcustom']; ?>" value="<?php echo $modulewiseids; ?>">    </tr>
                            <?php
                            $modulewiseids = "";
                        }
                         foreach ($AllAction as $Action) {
                                ?> 
                        <input type="hidden" name="hidactions[]" id="hidactions-<?php echo $Action['actionId']; ?>" value="<?php echo $actionwiseids[$Action['actionName']]; ?>">
                    <?php } ?>
                </tbody>
            </table>	
                </div>
            </div>            
            <div class="spacer10"></div>
            <div class=" pos-rel"><input type="submit" value="Save &amp; Keep Editing" class="submit" id="btnsaveandc" name="btnsaveandc"></div>
            <div class=" pos-rel"><input type="submit" value="Save &amp; Exit" id="btnsaveande" class="submit" name="btnsaveande"></div>
            <div class="fl"> <a href="<?php echo MODULE_PAGE_NAME; ?>" title="Cancel">
                                        <div  class="btn btn-default">
                                            Cancel
                                        </div>
                                    </a></div>  
            <div class="spacer10"></div>
        </div> 
        </form>    
        <div class="spacer20"></div> 

    </section>
</div>    