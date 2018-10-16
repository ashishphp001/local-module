<script type="text/javascript">
function CommentApproval()
{   
    var comments = $("#txt_UserReview").val();
    var pageid=  $("#Hid_intGlCode").val();
    var tablename=  $("#Hid_tablename").val();
    var fieldname=  $("#Hid_fieldname").val();
    var value=  $("#Hid_value").val();    
    var country=  $("#Hid_country").val(); 
    var website=  $("#Hid_website").val(); 
    var Module_Id =  $("#Hid_Module_Id").val(); 
    var Pendingrecord = $("#Hid_pendingrecord").val();
    
    $.ajax({
        type: "POST",
        url:"<?php echo ADMINPANEL_URL; ?>dashboard/Update_Approve",
        data:'int_id='+pageid+'&tablename='+tablename+"&fieldname="+fieldname+"&value="+value+"&comments="+encodeURIComponent(comments)+"&country="+country+"&website="+website+"&pendingrecord="+Pendingrecord+"&Module_Id="+Module_Id,
        async: false,
        success: function(data)
        {
            if(data == 1 && value == "A")
            {  
                jAlert("The request has been approved.");  
                $('#dialog-modal').dialog('destroy');
                SendGridBindRequest('<?php echo ADMINPANEL_URL; ?>dashboard?&country='+country+'&website='+website+"&pendingrecord="+Pendingrecord,'gridbody','DPR');
                return false;
            }
            else if(data == 1 && value == "D")
            {   
                jAlert("The request has been declined.");  
                $('#dialog-modal').dialog('destroy');
                SendGridBindRequest('<?php echo ADMINPANEL_URL; ?>dashboard?&country='+country+'&website='+website+"&pendingrecord="+Pendingrecord,'gridbody','DPR');
                return false;
            }
            else
            {
                jAlert("Oops! Some erorrs are occured.");
                $('#dialog-modal').dialog('destroy');
                return false;
            }
           
        }
    });
    return false;
}
</script>
<?php 
$attributes = array('name' => 'FrmContact', 'id' => 'FrmContact','onSubmit'=>'return CommentApproval();','method'=>'post','enctype' => 'multipart/form-data');
echo form_open('', $attributes);
echo form_hidden('Hid_intGlCode',$this->input->get_post('int_id'));
echo form_hidden('Hid_tablename',$this->input->get_post('tablename'));
echo form_hidden('Hid_fieldname',$this->input->get_post('fieldname'));
echo form_hidden('Hid_value',$this->input->get_post('value'));

echo form_hidden('Hid_Module_Id',$this->input->get_post('Module_Id'));
echo form_hidden('Hid_pendingrecord',$this->input->get_post('pendingrecord'));
echo form_hidden('Hid_PageSize',$this->input->get_post('PageSize')!=''?$this->input->get_post('PageSize'):$this->module_model->PageSize);
?>
<div class="main-form-box pd15">
    <div id="DIV_companyinfo pd15">
        <div class="inquiry-form">
            <div class="title-text">
                
                <strong>Comment</strong>
            </div>
            <div class="fl" style="width: 200px;">
                <textarea class="fl add-new-user-textarea"  style="width:362px;height:72px" id="txt_UserReview" rows="10" cols="40" name="txt_UserReview"></textarea>
            </div>
            <div class="spacer5"></div>
        </div>
        <div class="fl">
            <div class="fl">
                <input type="image" value="1" name="btnsaveande" id="btnsaveande" alt="save-exit" src="<?= ADMIN_MEDIA_URL_DEFAULT ?>images/save.png" >
            </div>
            <div class="fl mgl10">
                <a href="javascript:void(0);" onclick="$('#dialog-modal').dialog('close');">
                    <img src="<?php echo ADMIN_MEDIA_URL_DEFAULT ?>images/cancle.png" />
                </a>
            </div>
        </div> 
        <div class="clear"></div>
    </div>
</div>
<?php echo form_close();?>    