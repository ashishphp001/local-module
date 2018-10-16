<?php
echo
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');
?>
<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>

        <link rel="icon" type="image/png" href="<?php echo ADMIN_MEDIA_URL; ?>assets/img/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php echo ADMIN_MEDIA_URL; ?>assets/img/favicon-32x32.png" sizes="32x32">

        <title><?php echo SITE_NAME; ?> - Forgot Password</title>

        <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

        <!-- uikit -->
        <link rel="stylesheet" href="<?php echo ADMIN_MEDIA_URL; ?>bower_components/uikit/css/uikit.almost-flat.min.css"/>

        <!-- altair admin login page -->
        <link rel="stylesheet" href="<?php echo ADMIN_MEDIA_URL; ?>assets/css/login_page.min.css" />
        <link rel="stylesheet" href="<?php echo ADMIN_MEDIA_URL; ?>assets/icons/flags/flags.min.css" media="all">

        <!-- style switcher -->
        <link rel="stylesheet" href="<?php echo ADMIN_MEDIA_URL; ?>assets/css/style_switcher.min.css" media="all">

        <!-- altair admin -->
        <link rel="stylesheet" href="<?php echo ADMIN_MEDIA_URL; ?>assets/css/main.min.css" media="all">

        <!-- themes -->
        <link rel="stylesheet" href="<?php echo ADMIN_MEDIA_URL; ?>assets/css/themes/themes_combined.min.css" media="all">


        <script src="<?php echo ADMIN_MEDIA_URL_COMMON; ?>js/jquery.js"></script> 
        <script src="<?php echo ADMIN_MEDIA_URL_COMMON; ?>js/jquery-1.11.0.min.js"></script>     
        <script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>js/error_messages.js"></script>       
        <script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>js/commonalert.js"></script>    
        <script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>js/ajaxfunctions.js"></script>        
        <script type="text/javascript"> var BASE = '<?php echo base_url(); ?>';</script>  
        <script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>js/jquery.validate.js"></script>      
        <script type="text/javascript" src="<?php echo ADMIN_MEDIA_URL_DEFAULT; ?>js/validation_additional-methods.js"></script>  

        <script type="text/javascript">
            $(document).ready(function () {

                $("#logform").validate({
                    ignore: [],
                    rules: {
                        varLoginEmail: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        varLoginEmail: {
                            required: '<div class="error-main"><label class="error-note"><span class="error-arr"></span>' + Login_Email_Error + '</label></div>',
                            email: '<div class="error-main"><label class="error-note"><span class="error-arr"></span>' + GLOBAL_PROPER_EMAIL + '</label></div>'
                        }
                    },
                    errorPlacement: function (error, element)
                    {
                        if ($(element).attr('id') == 'varLoginEmail')
                        {
                            error.appendTo('#varLoginEmailError');
                        } else
                        {
                            error.insertAfter(element);
                        }
                    }
                });

                $("#varLoginEmail").keypress(function () {
                    $(".msg-password").html('');
                });

            });

            function checkemail(str)
            {
                var testresults;
                var filter = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i;

                if (filter.test(str))
                    testresults = true
                else
                    testresults = false

                return (testresults)
            }

            function ChkValid()
            {
                if (document.getElementById('varLoginEmail').value == "")
                {

                    document.getElementById('varLoginEmail').focus();
                    return false;
                }

//                document.getElementById('h_save').value = 'T';
                return true;
            }
        </script>
    </head>
    <?php
    $LoginCookie = $this->mylibrary->requestGetCookie('tml_CookieLogin', array());
    $username = "";
    $passowrd = "";
    $chkrememberme = "";
    if (!empty($LoginCookie)) {
        $username = $LoginCookie['varLoginEmail'];
        $passowrd = $LoginCookie['varPassword'];
        $chkrememberme = $LoginCookie['chkrememberme'];
    }
    ?>     
    <body class="login_page login_page_v2">

        <div class="uk-container uk-container-center">
            <div class="md-card">
                <div class="md-card-content padding-reset">
                    <div class="uk-grid uk-grid-collapse">
                        <div class="uk-width-large-2-3 uk-hidden-medium uk-hidden-small">
                            <div class="login_page_info uk-height-1-1" style="background-image: url('<?php echo ADMIN_MEDIA_URL; ?>assets/img/others/sabri-tuzcu-331970.jpg')">
                                <div class="info_content">
                                    <h1 class="heading_b">Forgot Password Page</h1>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aut culpa cumque eaque earum error esse exercitationem fuga, fugiat harum perferendis praesentium quasi qui, repellendus sapiente, suscipit totam! Eaque, excepturi!
                                    <p>
                                        <a class="md-btn md-btn-success md-btn-small md-btn-wave" href="javascript:void(0)">More info</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="uk-width-large-1-3 uk-width-medium-2-3 uk-container-center">
                            <div class="login_page_forms">
                                <div id="login_card">
                                    <div id="login_form">
                                        <div class="login_heading">
                                            <div class="user_avatar"></div>
                                        </div>
                                        <?php
                                        $SuccessData = $this->session->flashdata('SuccessData');
                                        if (!empty($SuccessData['message'])) {
                                            echo '<div class="md-card-list-wrapper">
                        <div class="md-card-list">
                            <ul class="hierarchical_slide uk-text-success" id="hierarchical-slide">
                                                                    <li>';
                                            echo $SuccessData['message'];
                                            echo '</li></ul></div></div>';
                                        }
                                        ?>                       
                                        <?php
                                        if (!empty($message)) {
//                                              echo $message;
                                            echo '<div class="md-card-list-wrapper">
                        <div class="md-card-list">
                            <ul class="hierarchical_slide uk-text-danger" id="hierarchical-slide">
                                                                    <li>';
                                            echo $message;

                                            echo '</li></ul></div></div>';
                                        }
                                        ?>     
                                        <?php
                                        $Attribute = array('name' => 'logform', 'id' => 'logform', 'method' => 'POST', 'onSubmit' => 'return ChkValid();');
                                        echo form_open(
                                                ADMINPANEL_URL . "login/forgetpassprocess", $Attribute);
                                        if ($this->input->get('gotopath') != '') {

                                            $HiddenValuesArray = array(
                                                "h_save" => "F",
//                                                "id" => "h_save",
                                                "gotopath" => $this->input->get('gotopath')
                                            );
                                            echo form_hidden($HiddenValuesArray);
                                        }
                                        ?>
                                        <!--<form>-->

                                        <!--</div>--> 
                                        <div id="varPasswordError"></div>   
                                        <div class="uk-form-row">
                                            <!--<div class="parsley-row">-->
                                            <label for="varLoginEmail">Email<span class="req">*</span></label>
                                            <input class="md-input" type="text" id="varLoginEmail" value="<?php echo $username; ?>" autocomplete="off" name="varLoginEmail" />
                                        </div>
                                    </div>
                                    <div class="uk-margin-medium-top">
                                        <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Submit</button>
                                    </div>
                                    <div class="uk-margin-top">
                                        <a href="<?php echo ADMINPANEL_URL; ?>" class="uk-float-right">Click here to Login</a>
                                        <span class="icheck-inline"> </span>
                                    </div>
                                    <?php echo form_close(); ?>   
                                </div>
                                <div class="uk-position-relative" id="login_help" style="display: none">
                                    <button type="button" class="uk-position-top-right uk-close uk-margin-right back_to_login"></button>
                                    <h2 class="heading_b uk-text-success">Can't log in?</h2>
                                    <p>Here's the info to get you back in to your account as quickly as possible.</p>
                                    <p>First, try the easiest thing: if you remember your password but it isn't working, make sure that Caps Lock is turned off, and that your email is spelled correctly, and then try again.</p>
                                    <p>If your password still isn't working, it's time to <a href="<?php echo ADMINPANEL_URL . "login/forgotpassword"; ?>">reset your password</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- common functions -->
    <script src="<?php echo ADMIN_MEDIA_URL; ?>assets/js/common1.min.js"></script>
    <!-- uikit functions -->
    <script src="<?php echo ADMIN_MEDIA_URL; ?>assets/js/uikit_custom.min.js"></script>
    <!-- altair core functions -->
    <script src="<?php echo ADMIN_MEDIA_URL; ?>assets/js/altair_admin_common.min.js"></script>

    <!-- altair login page functions -->
    <script src="<?php echo ADMIN_MEDIA_URL; ?>assets/js/pages/login.min.js"></script>

    <script>
            // check for theme
            if (typeof (Storage) !== "undefined") {
                var root = document.getElementsByTagName('html')[0],
                        theme = localStorage.getItem("altair_theme");
                if (theme == 'app_theme_dark' || root.classList.contains('app_theme_dark')) {
                    root.className += ' app_theme_dark';
                }
            }
    </script>

</body>
</html>