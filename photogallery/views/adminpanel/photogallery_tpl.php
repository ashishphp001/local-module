<style>
    #header_main {
        display: none;
    }
    body{
        padding-top: unset;
    }
    .uk-grid-width-medium-1-4 > * {
        width: 16%;
        float: left !important;
        position: inherit !important;
        left: inherit !important;
        top: inherit !important;
    }
    #style_switcher {
        display: none;
    }
    #sidebar_main {
        display: none;
    }
</style>
<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL; ?>js/highslide/highslide-with-gallery.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL; ?>js/jquery.dragsort-0.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var intProject = document.getElementById('intProject').value;
        get_rec_photo(intProject);
    });
    // Select All Record
    function get_rec_photo(intProject)
    {
        var url = "photogallery/select_all_photos/" + intProject;
        $.ajax({
            type: "GET",
            url: url,
            async: true,
            success: function (data) { //alert(data);
                if (trim(data) == 'invalid') {
                    document.getElementById('galleryGrid').innerHTML = '';
                    window.location.href = "photogallery/?intProject=" + intProject;
                } else {
                    document.getElementById('galleryGrid').innerHTML = trim(data);
                    document.getElementById('intProject').value = intProject;
                }
                document.getElementById('dvprocessing').style.display = 'none';
            }
        });
        if (history.pushState)
            window.history.pushState({}, document.title, '?intProject=' + intProject);
    }
    //  Delete Photo
    function deletealbumphoto(photoID, intProject)
    {
        var intProject = document.getElementById('intProject').value;
        UIkit.modal.confirm('Are you sure you want to delete this photo?', function () {
            var url = "photogallery/delete_photo/" + photoID + "/" + intProject;
            $.ajax({
                type: "GET",
                url: url,
                async: true,
                start: SetBackground(),
                success: function (data) {
                    // alert(data);
                    get_rec_photo(intProject);
                    document.getElementById('dvprocessing').style.display = 'none';
                    UIkit.modal.alert('Photo deleted successfully.');
                    return false;
                }
            });
        });
        return false;
    }

    $(document).ready(function () {
        document.getElementById("varImage").onchange = function () {
            var selection = document.getElementById('varImage');
            if (selection.files.length == '')
            {
                alert("Please upload image")
                return false;
            }
            for (var i = 0; i < selection.files.length; i++) {
                var ext1 = selection.files[i].name.substr(-4);
                var ext = ext1.toLowerCase();
                var file = selection.files[i].size;
                //image upload validation
                var file_length = selection.files.length;
                var FIVE_MB = Math.round(1024 * 1024 * 5);
                if (file_length > 5) {
                    alert('Sorry! you reached maximum limit, Please upload up to 5 image only');
                    return false;
                }
                if (file > FIVE_MB) {
                    alert('Sorry! you reached maximum limit, Please upload up to 5 MB only');
                    return false;
                }
                //image end
                if (ext !== ".jpg" && ext !== "jpeg" && ext !== ".png" && ext !== ".gif") {
                    alert('Only image files (JPG, JPEG, GIF, PNG) are allowed.');
                    return false;
                }
            }
            $('#fileupload').submit();
        }
    });
</script>
<div id="gridbody">
    <div id="page_content_inner">
        <?php
        echo validation_errors();
        if ($messagebox != '') {
            echo $messagebox;
        }
        ?>

        <form id="fileupload" action="photogallery/upload/" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="intProject" id="intProject" value="<?php echo $_GET['intProject']; ?>" />
            <div class="uk-form-row">
                <div class="uk-form-file md-btn md-btn-primary">
                    Upload Image
                    <input id="varImage" name="varImage[]" type="file"  multiple="multiple">
                </div>
                <div class="spacer10"></div>
                <div class="gallery_grid uk-grid-width-medium-1-4 uk-grid-width-large-1-5" id="galleryGrid"></div>
                <input type="hidden" name="photogalleryID" id="photogalleryID" value="<?php echo $_GET['intProject']; ?>" />
            </div>
        </form>
    </div>
    <!--</div>-->
</div>