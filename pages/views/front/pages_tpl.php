<div class="col m12 s12">

    <div class="product-multi cmspage card">
        <div class="col m12 s12 multi-top">
            <?php
            $CurrentPageData = $this->common_model->getpagedata(RECORD_ID, "pages");
            if ($CurrentPageData['txtDescription'] != '' && $CurrentPageData['chrDescriptionDisplay'] == 'Y') {
                $desc = $this->mylibrary->Replace_Varible_with_Sitepath($CurrentPageData['txtDescription']);
                echo $desc;
            } else {
                ?>
                <h5><center>Coming Soon..!</center></h5>
            <?php } ?>
        </div>
    </div>
</div>
