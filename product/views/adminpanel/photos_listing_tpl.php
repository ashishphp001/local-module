
<?php
if (!empty($photosArr)) {
    foreach ($photosArr as $key => $photo) {
        $photo_thumb = $photo['varImage'];
        $thumb = 'upimages/photogallery/images/' . $photo_thumb;
        if (file_exists($thumb) && $photo_thumb != '') {
            $thumbphoto = image_thumb($thumb, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
            $thumbphoto1 = image_thumb($thumb, PHOTOGALLERY_WIDTH, PHOTOGALLERY_HEIGHT);
        }
        ?>
        <div >
            <div class="md-card md-card-hover">
                <div class="gallery_grid_item md-card-content">
                    <i class="md-icon material-icons" style="float:right;" onclick="deletealbumphoto('<?= $photo['int_id'] ?>', '<?= $intProject ?>')">highlight_off</i>
                    <a href="<?php echo $thumbphoto1 ?>" data-uk-lightbox="{group:'gallery'}">
                        <img src="<?php echo $thumbphoto1 ?>" alt="">
                    </a>

                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo '<div style="text-align: center;padding: 10px;" id="nophoto">No photos uploaded</div>';
}
?>