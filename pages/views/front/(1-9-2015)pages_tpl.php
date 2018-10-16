<section class="Middle-Section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 animate fadeInUp cssanim">
                <div class="cms">
                    <?php
                    $CurrentPageData = $this->common_model->getpagedata(RECORD_ID, "Pages");
                    if ($CurrentPageData['txtDescription'] != '' && $CurrentPageData['chrDescriptionDisplay'] == 'Y') {
                        echo $this->mylibrary->Replace_Varible_with_Sitepath($CurrentPageData['txtDescription']);
                    } else { ?>
                    <center style="color:#005aab;">Comming Soon..!</center>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>