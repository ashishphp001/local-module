<script type="text/javascript">


    $(document).ready(function () {
//        $('#varEmailId').bind("cut copy paste", function (e)
//        {
//            e.preventDefault();
//        });
//
//        $('#varEmailId').on('keypress', function (e) {
//            if (e.which == 32) {
//                return false;
//            }
//        });

        $.validator.addMethod("phonenumber", function (value, element) {
            var numberPattern = /\d+/g;
            var newVal = value.replace(/\D/g, '');
            if (parseInt(newVal) <= 0)
            {
                return false;
            } else
            {
                return true;
            }
        }, "<div class='fl mgt5 mgr20'>Please enter a valid number.</div>");

        $.validator.addMethod("contactemail", function (value, element) {
            var x = document.forms["contact-form"]["varEmailId"].value;
            var atpos = x.indexOf("@");
            var dotpos = x.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
                return false;
            } else {
                return true;
            }
        }, "<label class='error' style='color:#EE1C24;'>Please enter valid email address.</lable>");
        $("#contact-form").validate({
            //            ignore: [],
            rules: {
                varName: {
                    required: true
                },
                varEmailId: {
                    required: true,
                    email: true,
                    maxlength: 50,
                    contactemail: {
                        depends: function () {
                            if (($("#varEmailId").val()) != '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                varPhone: {
                    required: true,
                    minlength: 5,
                    maxlength: 20,
                    phonenumber: {
                        depends: function () {
                            if (($("#varPhone").val()) != '') {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
            messages: {
                captchaimage1: {
                    required: "<span style='color:#da2137'>Please enter captcha code.</span>"
                }
            },
            highlight: function (input) {
                $(input).addClass('error');
            },
            errorPlacement: function (error, element) {
//                if ($(element).attr('id') == 'captchaimage1')
//                {
//                    error.insertAfter($(".replacecaptcha"));
//                }
            },
            submitHandler: function (form) { // <- pass 'form' argument in
                document.getElementById('sub').style.display = 'none';
                document.getElementById("myDiv").style.display = "block";
                //                            setTimeout("hide()", 5000);  // 5 seconds
                form.submit(); // <- use 'form' argument here.
            }
        });
    });</script>



<div  class="container">
    <div class="row">
        <?php if ($_GET['msg'] != '') { ?>
            <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">X</a>
                <strong>Success!</strong> Visitors entry successfully inserted!!!
            </div>

            <div id="blog-large" class="col-md-12 mtop50">
            <?php } else { ?>
                <div id="blog-large" class="col-md-12 mtop100">

                <?php } ?>
                <article class="post-large">
                    <div class="row" >	
                        <div class="col-md-6 col-md-offset-3" style="box-shadow:0 16px 38px -12px rgba(0, 0, 0, 0.56), 0 4px 25px 0 rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);padding: 20px;border-radius: 4px;background-color: #fff;">
                            <form action="<?php echo SITE_PATH . "event-form/insert"; ?>" id="contact-form" name="contact-form" method="post" class="input-list style-5 clearfix" enctype="multipart/form-data">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

                                    <input class="mdl-textfield__input" style="background:none;color:#747474;"  autocomplete="off" type="text" id="varName" value="<?php echo $_POST['varName']; ?>" name="varName">
                                    <label class="mdl-textfield__label" for="sample3">  <i class="fa fa-user prefix"></i> Name</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" style="background:none;color:#747474 !important;" autocomplete="off" type="text" value="<?php echo $_POST['varEmailId']; ?>" id="varEmailId" name="varEmailId">
                                    <label class="mdl-textfield__label" for="sample3"> <i class="fa fa-envelope prefix"></i> Email</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" style="background:none;color:#747474 !important;" type="text" id="varPhone" name="varPhone" onkeypress="return KeycheckOnlyNumeric(event)" >
                                    <label class="mdl-textfield__label" for="sample3">  <i class="fa fa-phone prefix"></i> Phone</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    You are : <br>
                                    <label for="int_icr1"><input type="radio" id="int_icr1" name="int_icr" value="Individual" style="margin-left: 10px;" checked="checked">&nbsp;Individual</label><br>
                                    <label for="int_icr2"><input type="radio" id="int_icr2" name="int_icr" value="Corporate" style="margin-left: 10px;">&nbsp;Corporate</label><br>
                                    <label for="int_icr3"><input type="radio" id="int_icr3" name="int_icr" value="Reseller" style="margin-left: 10px;">&nbsp;Reseller</label><br>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    Brands : <br>
                                    <label for="brands1"> <input type="checkbox" id="brands1" name="brands[]" value="Sensinova" style="margin-left: 10px;">&nbsp;Sensinova</label><br>
                                    <label for="brands2"> <input type="checkbox" id="brands2" name="brands[]" value="Steinel" style="margin-left: 10px;">&nbsp;Steinel</label><br>
                                    <label for="brands3"> <input type="checkbox" id="brands3" name="brands[]" value="Eurolite" style="margin-left: 10px;">&nbsp;Eurolite</label>
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <label> Upload Image:</label>
                                    <input name="varImage" id="varImage" type="file">
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

                                    <input class="mdl-textfield__input" style="background:none;color:#747474;"  autocomplete="off" type="text" id="varCityName" value="<?php echo $_POST['varCityName']; ?>" name="varCityName">
                                    <label class="mdl-textfield__label" for="sample3">  <i class="fa fa-map-marker prefix"></i> City</label>
                                </div>
                                <div id="map"></div>
                                <script>

                                    function initMap() {
                                        var defaultBounds = ['(administrative_area3)'];
                                        var map = new google.maps.Map(document.getElementById('map'), {
                                        });
                                        var input = (document.getElementById('varCityName'));
                                        var options = {
                                            bounds: defaultBounds,
                                            types: ['(cities)'],
                                            componentRestrictions: {country: 'in'}//Turkey only
                                        };
                                        var autocomplete = new google.maps.places.Autocomplete(input, options);
                                        autocomplete.bindTo('bounds', map);
                                    }
                                </script>
                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArhcof8qxOYByyZe_7tsxAGX1MDt9WfSc&libraries=places&callback=initMap" async defer></script>

                                <div class="mdl-textfield mdl-js-textfield  mdl-textfield--floating-label">
                                    <textarea class="mdl-textfield__input" style="background:none;color:#747474 !important;" autocomplete="off" type="text" rows= "3" id="txtMessage" name="txtMessage" ><?php echo $_POST['txtMessage']; ?></textarea>
                                    <label class="mdl-textfield__label" for="sample5"> <i class="fa fa-pencil prefix"></i> Remarks</label>
                                </div>

                                <button id="sub" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="float:right;">
                                    Submit<i class="mdi-content-send right"></i>
                                </button>

                            </form>
                        </div>
                    </div>	 
                </article>	  
            </div>
        </div>	 
    </div>
    <?php $this->common_model->get_contactusdata(); ?>
    <div class="container-fluid cadd2" >
        <div class="container" >
            <div class="row">

                <div class="col-md-3">	
                    <h3><img src="<?php echo FRONT_MEDIA_URL; ?>img/addressicon.png" class="cicon" />  <?php echo CONTACT_CITY2; ?></h3>
                    <p class="cfont">
                        <?php echo nl2br(ADDRESS_ADD2); ?>
                    </p>
                </div>
                <div class="col-md-3">	
                    <h3><img src="<?php echo FRONT_MEDIA_URL; ?>img/addressicon.png" class="cicon" /> <?php echo CONTACT_CITY1; ?></h3>
                    <p class="cfont">
                        <?php echo nl2br(ADDRESS_ADD1); ?>
                    </p>
                </div>	



                <div class="col-md-3">	
                    <h3><img src="<?php echo FRONT_MEDIA_URL; ?>img/enveloicon.png" class="cicon" /> Email</h3>
                    <p class="cfont"> <a href="mailto:<?php echo EMAIL_ADD; ?>" style="text-decoration: none;color: white;"><?php echo EMAIL_ADD; ?></a> </p>
                </div>

                <div class="col-md-3">	
                    <h3><img src="<?php echo FRONT_MEDIA_URL; ?>img/callicon.png" class="cicon" /> Quick Call</h3><br /> 
                    <span class="cfont">  <?php
                        if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {
                            ?><a style="text-decoration: none;color: white;" href="tel:<?php echo CONTACT_PHONE1; ?>"><?php echo CONTACT_PHONE1; ?></a>
                        <?php } else { ?>
                            <?php
                            echo CONTACT_PHONE1;
                        }
                        ?></span><br /> 
                    <span class="cfont">  <?php
                        if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) {
                            ?><a style="text-decoration: none;color: white;" href="tel:<?php echo CONTACT_PHONE2; ?>"><?php echo CONTACT_PHONE2; ?></a>
                        <?php } else { ?>
                            <?php
                            echo CONTACT_PHONE2;
                        }
                        ?> </span>
                </div>

            </div>	 
        </div>
    </div>

    <div class="container-fluid p0" >
        <div class="overlay" onClick="style.pointerEvents = 'none'"></div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1836.003569341447!2d72.53791726736029!3d23.0235101045433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84dca60e70f5%3A0xf9d2d4cb5a0e2b43!2sSensinova!5e0!3m2!1sen!2sin!4v1497941177715" width="100%" height="350px" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>	 

<!--<script type="text/javascript" src="<?php echo FRONT_MEDIA_URL; ?>js/validation/common.js"></script>
<script type="text/javascript" src="<?php echo FRONT_MEDIA_URL; ?>js/validation/jquery.validate.min.js"></script>-->