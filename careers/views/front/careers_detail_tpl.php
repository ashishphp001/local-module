<main class="page-content">
    <!--Section Themes Filter-->
    <section class="context-dark">
        <div class="parallax-container" data-parallax-img="<?php echo FRONT_MEDIA_URL; ?>images/backgrounds/background-44-1920x1024.jpg">
            <div class="parallax-content">
                <div class="shell section-98 section-sm-50">
                    <h2>Job Apply for <?php echo $ShowAllPagesRecords['varShortName']; ?></h2>
                    <hr class="divider bg-mantis">
                    <div class="range range-sm-center offset-top-0">
                        <div class="cell-sm-8">
                            <!-- RD Mailform-->
                            <form class="rd-mailform text-left" data-form-output="form-output-global" data-form-type="contact" method="post" action="<?php echo SITE_PATH . "career/insert"; ?>">
                                <input type="hidden" id="intCareer" name="intCareer" value="<?php echo RECORD_ID; ?>">
                                <div class="range">
                                    <div class="cell-lg-6">
                                        <div class="form-group">
                                            <label class="form-label form-label-outside" for="contact-me-name">Name:</label>
                                            <input class="form-control" id="contact-me-name" type="text" name="varName" data-constraints="@Required">
                                        </div>
                                    </div>
                                    <div class="cell-lg-6 offset-top-20 offset-lg-top-0">
                                        <div class="form-group">
                                            <label class="form-label form-label-outside" for="contact-me-email">E-Mail:</label>
                                            <input class="form-control" id="contact-me-email" type="email" name="varEmailId" data-constraints="@Required @Email">
                                        </div>
                                    </div>
                                    <div class="cell-lg-6 offset-top-30 offset-lg-top-10 ">
                                        <div class="form-group">
                                            <label class="form-label form-label-outside" for="contact-me-phone">Phone:</label>
                                            <input class="form-control" id="contact-me-phone" type="text" name="varPhone" data-constraints="@Required">
                                        </div>
                                    </div>
                                    <div class="cell-lg-6 offset-top-30 offset-lg-top-10">
                                        <div class="form-group">
                                            <label class="form-label form-label-outside" for="contact-me-website">Position:</label>
                                            <?php
                                            $getCarrerrequirement = $this->Module_Model->getPositionname();
                                            ?>
                                            <select class="form-control" id="contact-me-website" >
                                                <?php
                                                foreach ($getCarrerrequirement as $row) {
                                                    if ($row['int_id'] == RECORD_ID) {
                                                        $class = "selected='selected'";
                                                    } else {
                                                        $class = "";
                                                    }
                                                    ?>
                                                    <option <?php echo $class; ?> value="<?php echo $row['int_id']; ?>"><?php echo $row['varPositionName']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="cell-lg-12 offset-top-20">
                                        <div class="form-group">
                                            <label class="form-label form-label-outside" for="contact-me-file">CV:</label><span class="req-note avak" style="font-weight: normal;font-size: 14px;margin-left: 7px;color: #42b574;">(Only .doc, .docx, .pdf, .xls or .xlsx file formats are supported.)</span>
                                            <input type="file" name="varFile" id="contact-me-file">
                                        </div>
                                    </div>
                                    <div class="cell-lg-12 offset-top-20">
                                        <div class="form-group">
                                            <label class="form-label form-label-outside" for="contact-me-message">Message:</label>
                                            <textarea class="form-control" id="contact-me-message" name="txtMessage" data-constraints="@Required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-sm text-center text-lg-left offset-top-30">
                                    <button class="btn btn-primary" type="submit">Send</button>
                                    <button class="btn btn-default" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-66 section-top-50 bg-mantis section-triangle section-triangle-bottom context-dark">
        <div class="shell">
            <div class="range range-sm-center">
                <h2><span class="big"> <?php echo $ShowAllPagesRecords['varShortName']; ?></span></h2>
                <div class="cell-md-8">
                    <?php
                    if ($ShowAllPagesRecords['txtDescription'] != '') {
                        echo $this->mylibrary->Replace_Varible_with_Sitepath($ShowAllPagesRecords['txtDescription']);
                    } else {
                        echo nl2br($ShowAllPagesRecords['varShortDesc']);
                    }
                    ?>
                </div>
            </div>
        </div>
        <svg class="svg-triangle-bottom" xmlns="http://www.w3.org/2000/svg" version="1.1">
        <defs>
        <lineargradient id="grad2" x1="0%" y1="0%" x2="100%" y2="0%">
        <stop offset="0%" style="stop-color:rgb(99,189,98);stop-opacity:1;"></stop>
        <stop offset="100%" style="stop-color:rgb(99,189,98);stop-opacity:1;"></stop>
        </lineargradient>
        </defs>
        <polyline points="0,0 60,0 29,29" fill="url(#grad2)"></polyline>
        </svg>
    </section>
</main>