<script type="text/javascript">

    function push(id) {
        var chked = false;
        $('input:checkbox[name="fb"]:checked,input:checkbox[name="tw"]:checked').each(function(k,v){
            chked = true;
        });
        if (trim($('#varTitle').val())=='')
        {
            alert('Please Enter title');
            return false;
        }
        if (trim($('#txtDescription').val())=='')
        {
            alert('Please Enter description');
            return false;
        }

        if(chked){
            var postdata=$("#frmshareoption").serialize();
            $.ajax({
                type: "POST",
                url:"blog/sharedata?e_id="+id ,
                data: postdata,
                async: false,
                success: function(result){
                    alert("Pages are pushed successfully.");
                    window.location.reload();
                }
            });
        }else{
            alert("Please select social media to share.");
            return false;
        }
    
    }
</script>
<form id="frmshareoption" name="frmshareoption">
    <input type="hidden" id="action" name="action" value="sharedata">
    <input type="hidden" id="h_save" name="h_save" value="T">
    <input type="hidden" id="eid" name="eid" value="<?php echo $_GET['e_id'] ?>">
    <?php
    $id = $_GET['e_id'];
    $ImagePath = 'upimages/blog/' . $rec['varImage'];
    if ($rec['varImage'] != '' && file_exists($ImagePath)) {
        $Image = image_thumb($ImagePath, 400, 400);
    } else {
        $Image = image_thumb('admin-media/Themes/ThemeDefault/images/340X227.jpg', 400, 400);
    }
    ?>
    <div> 
        <div style="float:left">
            <table valign="top">
                <tr>
                    <td>
                        <p style="margin:0px;">Title:<span class="required"></span></p><input type="text" class="frist-name input input-bg01" name="varTitle" id="varTitle" value="<?php echo htmlentities($rec['varTitle']) ?>" style="width: 349px;" />
                    </td>
                </tr>
                <tr><td><div class="spacer10"></div></td></tr>
                <tr>
                    <td>
                        <?php
                        $description = strip_tags(substr($rec['txtDescription'], 0, 200));
                        $ShortDesc = strip_tags(substr($rec['varShortDesc'], 0, 200));
                        ?>
                        <p style="margin:0px;">Description:<span class="required"></span></p><textarea id="txtDescription" class="frist-name input-bg01" maxlength="500" style="width:350px;" name="txtDescription" ><?php echo trim($description) != '' ? trim($description) : trim($ShortDesc) ?></textarea>
                    </td>
                </tr>
                <tr><td><div class="spacer10"></div></td></tr>
                <tr>
                    <td>
                        <?php
                        $imagename = $rec['varImage'];
                        $imagepath = 'upimages/blog/' . $imagename;
                        if (file_exists($imagepath) && $rec['varImage'] != '') {
                            $image_thumb = image_thumb($imagepath, 400, 400);
                            $image_detail_thumb = image_thumb($imagepath, 400, 400);
                            ?>      
                            <a href="<?php echo $image_detail_thumb; ?>"  class="fancybox-buttons" data-fancybox-group="button">

                                <span id="varMenuIconImage<?php echo $rec['int_id']; ?>" style="display:none">

                                    <a  href="<?php echo $image_detail_thumb; ?>">
                                        <img title="<?php echo htmlentities($this->common_model->GetImageNameOnly($rec['varImage'])); ?>" src="<?php echo $image_detail_thumb; ?>" alt="View"  border="0" align="absmiddle" id="myimage" />
                                    </a>
                                </span>
                            </a> 
                            <?php
                        } else {
                            echo "";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        if (FACEBOOK_SHARE == "Y" || TWITTER_SHARE == 'Y') {
                            if (FACEBOOK_SHARE == 'Y') {
                                if (FB_APP_ID != '' && FB_APP_SECRET != '' && FB_PAGE_ID != '' && FB_ACCESS_TOKEN != '') {
                                    ?>
                                    <div style="float:left;"><label for="fb"><input class="checkboxes" type="checkbox" id="fb" name='fb' value="Y">Facebook&nbsp;</label></div>
                                    <?php
                                }
                            }
                            if (TWITTER_SHARE == 'Y') {
                                if (TW_CONSUMER_KEY != '' && TW_CONSUMER_SECRET != '' && TW_OUATH_TOKEN != '' && TW_OUATH_TOKEN_SECRET != '') {
                                    ?>
                                    <div style="float:left;"><label for="tw"><input class="checkboxes" type="checkbox" id="tw" name='tw' value="Y">Twitter</label></div>
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <font color="red">Please enable the social media share functionality or contact Administrator.</font>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <?php if (FACEBOOK_SHARE == "Y" || TWITTER_SHARE == 'Y') { ?>
                    <tr>
                        <td>
                            <input class="submit" type="button" name="Push" id="Push" value="Push" onclick='return push(<?php echo $_GET['e_id']; ?>)'>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</form>