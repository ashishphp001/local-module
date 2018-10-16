<script type="text/javascript">
   
    function checkForFile(id) {
        if(document.getElementById('file'+id).value != '' && !LimitAttach_Photo(document.getElementById('file'+id).value,'file'+id)){
            document.getElementById('errMsg2'+id).style.display = '';
            document.getElementById('errMsg3'+id).style.display = 'none';
            return false;
        }
        else if(document.getElementById('file'+id).value != '' && !Limit_photo(id)){
            document.getElementById('errMsg3'+id).style.display = '';
            document.getElementById('errMsg2'+id).style.display = 'none';
            return false;
        }
                
        if(document.getElementById('file'+id).value == '' && document.getElementById('title'+id).value == ''){
            document.getElementById('errMsg'+id).style.display = '';
            document.getElementById('errMsg1'+id).style.display = '';
            return false;
        }else if(document.getElementById('file'+id).value == ''){
            document.getElementById('errMsg'+id).style.display = '';
            return false;
        }else if(document.getElementById('title'+id).value == ''){
            document.getElementById('errMsg1'+id).style.display = '';
            return false;
        }
//        return false;
    }
    
    function Limit_photo(id){
        var selection = document.getElementById('file'+id);
        for (var i=0; i<selection.files.length; i++) {
            var ext = selection.files[i].name.substr(-4);

            //image upload validation
            var file = selection.files[i].size;
            var FIVE_MB = Math.round(1024*1024*5);
                       
            if(file > FIVE_MB){
                document.getElementById('file'+id).value = "";
                return false;
            }else{
                return true;
            }
            //image end
        } 
    }
    function hidepopup(id){
//        return document.getElementById('popupBottom'+id).style.display = 'none';
//        popupBottom('hide');
        location.reload();        
    }
    function LimitAttach_Photo(file,id)
    {
        var imgpath = document.getElementById(id).value;
        if(imgpath != "")
        {
            var arr1 = new Array;
            arr1 = imgpath.split("\\");
            var len = arr1.length;
            var img1 = arr1[len-1];
            var filext1 = img1.substring(img1.lastIndexOf(".")+1);
            var filext = filext1.toLowerCase();
            // Checking Extension
           
            if(filext == "jpg"  || filext == "jpeg" || filext == "png" || filext == "gif")
            {
                return true;
            }

            else
            {
                document.getElementById(id).value = "";
                return false;
            }
        }
    }
</script>
<div id="popupBottom" style="position:relative">
    <div class="spacer20"></div>
    
    <form name="fileupload" id="fileupload" action="photoalbum/update" width="1375px" height="25px" method="POST" enctype="multipart/form-data" onsubmit="return checkForFile(<?php echo $_REQUEST['id']; ?>);">
        <input type="hidden" id="fk_updatealbum" name="fk_updatealbum" value="<?php echo $_REQUEST['fk_album']; ?>" />
        <input type="hidden" id="fk_updateid" name="fk_updateid" value="<?php echo $_REQUEST['id']; ?>"/>
        
        <div class="clear"></div>
        <div class="modal-popover" id="popover<?php echo $_REQUEST['id']; ?>">
        <?php $name = $this->module_model->name($_REQUEST['id'],$_REQUEST['fk_album']); 
              foreach($name as $row) { ?>
        <div class="form_contact_title popup_filed"><b>Title:</b><font style="color:#1979AC;">&nbsp;(required)</font>
            <!--<div class="form_input form_input1">-->
            <input class="input-xlarge" style="width: 190px;" id="title<?php echo $_REQUEST['id']; ?>" type="text" name="title<?php echo $_REQUEST['id']; ?>" value='<?php echo stripslashes(quotes_to_entities($row['Var_Title'])); ?>' maxlength="70">
        </div>
        <?php }?>
        <div id="errMsg1<?php echo $_REQUEST['id']; ?>" style="display:none;font-size: 12px;color:red;margin-top:0px;">
            Please enter photo title.
        </div>
        <div class="form_input form_input1 "><b>Image:</b><font style="color:#1979AC;">&nbsp;(required)</font>
            <input id="file<?php echo $_REQUEST['id']; ?>" type="file" name="file<?php echo $_REQUEST['id']; ?>" value="<?php echo $row['Var_Image']; ?>">
        </div>
        <div id="errMsg<?php echo $_REQUEST['id']; ?>" style="display:none;font-size: 12px;color:red;margin-top:0px;">
            Please select image to upload.
        </div>
        <div class="clear"></div>
        <div id="errMsg2<?php echo $_REQUEST['id']; ?>" style="display:none;font-size: 12px;color:red;margin-top:-3px;">
            Only image files (JPG, JPEG, GIF, PNG) are allowed.
        </div>
        <div id="errMsg3<?php echo $_REQUEST['id']; ?>" style="display:none;font-size: 12px;color:red;margin-top:-3px;">
            Sorry! you reached maximum limit, Please upload up to 5 MB only.
        </div>
        </div><div class="spacer10"></div>
        <div class="form_contact_title popup_filed" style="color: #1979AC;font-size: 12px"><b>only *.jpg, *.jpeg, *.png or *.gif. Having maximum size of 5MB.</b></div>
        <!--<input id="file1" type="file" name="file1" />-->
        <div class="modal-footer">
            <!--<input style="float: left;" type="submit" value="Upload" class="sub_rev" />-->
            <button type="submit" title="Update" id="button" class="btn btn-success" onclick="return checkForFile(<?php echo $_REQUEST['id']; ?>);">Update</button>
            <!--<button type="button" onclick="return hide_popupwindow();" id="button-cancel" title="Cancel" class="btn1 btn-danger" data-dismiss="popupBottom<?= $_REQUEST['id']; ?>">Cancel</button>-->
            <button class="btn1 btn-danger" data-dismiss="popupBottom" title="Cancel" style="color:white" onclick="return hidepopup(<?php echo $_REQUEST['id']; ?>);">Cancel</button>
        </div><div class="clear"></div>
    </form>
</div>