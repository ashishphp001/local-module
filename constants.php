<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



/*
 *
 * Common Variables
 *  
 */
require_once( BASEPATH . 'database/DB' . EXT );
$db = & DB();
$query = $db->get('generalsettings');
foreach ($query->result() as $rowResult) {
    $row[$rowResult->varFieldName] = $rowResult->varFieldValue;
}

define('SITE_PATH', $row['varSitePath']);
define('SITE_NAME', $row['varSiteName']);

define('SITE_PATH_ALTER', $row['varSitePath']);
define('SUB_DOMAIN', 'https://___.indibizz.com');
define('DB_PREFIX', 'ib_');
define('SESSION_PREFIX', 'ib_');
define('INDIBIZZ_TAX', 10);
define('PREFIX', 'ib_');
define('GOOGLE_API_KEY', 'AIzaSyBcjXWsjflj6wkUDN-mnwvsTRUnEdmljpk');

define('MERCHANT_KEY', 'hBXbBkbb');
define('SALT', 'd2ZVod7grC');

define('ENC_KEY', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567891399268456');
//define('ENC_KEY', '8011a44fd3a334a55c77384aae4c007b');
define('API_KEY', '48c7f10ba87ecb3ab3df49caba54921a');
define('ADMINPANEL', 'adminpanel');
define('ADMINPANEL_URL', SITE_PATH . ADMINPANEL . '/');

define('ADMINPANEL_HOME_URL', SITE_PATH . ADMINPANEL . '/dashboard');
define('ADMIN_MEDIA_URL', SITE_PATH . 'admin-media/');
define('ADMIN_MEDIA_URL_COMMON', ADMIN_MEDIA_URL . 'Themes/Common/');
define('ADMIN_MEDIA_URL_DEFAULT', ADMIN_MEDIA_URL . 'Themes/ThemeDefault/');
define('GLOBAL_ADMIN_IMAGES_PATH', ADMIN_MEDIA_URL_DEFAULT . 'images/');
define('EMAIL_LOGO_PATH', ADMIN_MEDIA_URL_DEFAULT . 'images/adminpanel-logo.jpg');
define('FRONT_MEDIA_URL', SITE_PATH . 'front-media/');
define('FRONT_MEDIA_URL_DEFAULT', FRONT_MEDIA_URL . 'img/');
define('GLOBAL_FRONT_IMAGES_PATH', SITE_PATH . 'front-media/images/');
define('ADMINPANEL_MAIL_TEMPLATES_PATH', 'admin-media/mailtemplates/');
define('FRONT_GLOBAL_MAILTEMPLATES_PATH', FRONT_MEDIA_URL . 'emailtemplate/');
define('SITE_SEO', 'Y');
define('DEFAULT_CURRENCY', $row['varDefaultCurrency']);
//define('REGISTER_ADMIN_EMAILID', $row['varContcatusMailid']);
//define('ADMIN_NEWSLETTER_ID', $row['varnewsletterleadsmailid']);
define('MAIL_FROM', $row['varSenderEmail']);
define('CAPTCHA_IMAGE_PATH', FRONT_MEDIA_URL_DEFAULT . 'captcha.jpg');

define('DEFAULT_EMAILID', $row['varDefaultMailid']);
define('CONTACT_US_EMAILID', $row['varcontactusleadMailid']);

$Product_size = explode('*', $row['varProductAlbumThumb']);
define('PRODUCT_ALBUM_WIDTH', $Product_size[0]);
define('PRODUCT_ALBUM_HEIGHT', $Product_size[1]);

$Career_Thumb_size = explode('*', $row['varCareerThumb']);
define('CAREERS_WIDTH', $Career_Thumb_size[0]);
define('CAREERS_HEIGHT', $Career_Thumb_size[1]);

$Product_Category_Thumb_size = explode('*', $row['varProductCategoryThumb']);
define('PRODUCTS_CATEGORY_WIDTH', $Product_Category_Thumb_size[0]);
define('PRODUCTS_CATEGORY_HEIGHT', $Product_Category_Thumb_size[1]);

$Plan_Thumb_size = explode('*', $row['varPlanThumb']);
define('PLANS_WIDTH', $Plan_Thumb_size[0]);
define('PLANS_HEIGHT', $Plan_Thumb_size[1]);

$BuyLead_Thumb_size = explode('*', $row['varBuyLeadThumb']);
define('BUY_LEADS_WIDTH', $BuyLead_Thumb_size[0]);
define('BUY_LEADS_HEIGHT', $BuyLead_Thumb_size[1]);

$Blog_Thumb_size = explode('*', $row['varBlogThumb']);
define('BLOGS_WIDTH', $Blog_Thumb_size[0]);
define('BLOGS_HEIGHT', $Blog_Thumb_size[1]);

$Blog_Detail_Thumb_size = explode('*', $row['varBlogDetailThumb']);
define('BLOGS_DETAIL_WIDTH', $Blog_Detail_Thumb_size[0]);
define('BLOGS_DETAIL_HEIGHT', $Blog_Detail_Thumb_size[1]);

define('PAYMENT_TYPE_WIDTH', 150);
define('PAYMENT_TYPE_HEIGHT', 100);

define('EVENT_WIDTH', 390);
define('EVENT_HEIGHT', 220);

define('EVENT_DETAIL_WIDTH', 770);
define('EVENT_DETAIL_HEIGHT', 430);

define('ICON_SIZE_WIDTH', 35);
define('ICON_SIZE_HEIGHT', 35);

$Home_Banner_size = explode('*', $row['varHomeBannerThumb']);
define('HOME_BANNER_WIDTH', $Home_Banner_size[0]);
define('HOME_BANNER_HEIGHT', $Home_Banner_size[1]);

$Inner_Banner_size = explode('*', $row['varInnerBannerThumb']);
define('INNER_BANNER_WIDTH', $Inner_Banner_size[0]);
define('INNER_BANNER_HEIGHT', $Inner_Banner_size[1]);

$Service_Thumb_size = explode('*', $row['varServiceThumb']);
define('SERVICE_WIDTH', $Service_Thumb_size[0]);
define('SERVICE_HEIGHT', $Service_Thumb_size[1]);

$Product_Thumb_size = explode('*', $row['varProductThumb']);
define('PRODUCT_LISTING_WIDTH', $Product_Thumb_size[0]);
define('PRODUCT_LISTING_HEIGHT', $Product_Thumb_size[1]);

$User_Thumb_size = explode('*', $row['varUserThumb']);
define('USERS_WIDTH', $User_Thumb_size[0]);
define('USERS_HEIGHT', $User_Thumb_size[1]);

$Testimonials_Thumb_size = explode('*', $row['varTestimonialsThumb']);
define('TESTIMONIALS_WIDTH', $Testimonials_Thumb_size[0]);
define('TESTIMONIALS_HEIGHT', $Testimonials_Thumb_size[1]);

define('PHTOTOALBUM_WIDTH', 555);
define('PHTOTOALBUM_HEIGHT', 300);

$Product_Thumb_size = explode('*', $row['varProductThumb']);
define('PRODUCTGALLERY_WIDTH', $Product_Thumb_size[0]);
define('PRODUCTGALLERY_HEIGHT', $Product_Thumb_size[1]);

define('PHOTOGALLERY_WIDTH', 702);
define('PHOTOGALLERY_HEIGHT', 394);

/* for dropbox key start */
define('DROPBOX_BETA', $row['varDropboxBetaSk']);
define('DROPBOX_BETA_KEY', $row['varDropboxBetaSk']);
//define('DROPBOX_BETA_KEY', 'ymmsj6121pe9771');
define('DROPBOX_LIVE_KEY', $row['varDropboxLiveSk']);
//define('DROPBOX_LIVE_KEY', 'ymmsj6121pe9771');
/* for dropbox key done */



define('DEFAULT_DATEFORMAT', $row['varAdminpanelDateFormat']);
define('DEFAULT_TIMEFORMAT', $row['varAdminpanelTimeFormat']);
define('DEFAULT_FRONT_DATEFORMAT', $row['varFrontDateFormat']);
define('DEFAULT_FRONT_TIMEFORMAT', $row['varFrontTimeFormat']);
//define('DEFAULT_PAGESIZE', $row['varAdminpanelPagesize']);
define('DEFAULT_PAGESIZE', 20);
//define('DEFAULT_PAGESIZE', 30);

define('EMAIL_SIGNATURE', htmlspecialchars_decode(stripcslashes($row['varEmailSignature'])));
define('GITHUB_LINK', $row['varGitHubLink']);
define('FACEBOOK_LINK', $row['varFacebookLink']);
define('TWITTER_LINK', $row['varTwitterLink']);
define('GOOGLE_PLUS_LINK', $row['varGooglePlusLink']);
define('YOUTUBE_LINK', $row['varYoutubeLink']);
define('LINKEDIN_LINK', $row['varLinkedInLink']);
define('SKYPE_LINK', $row['varSkypeLink']);
define('INSTAGRAM_LINK', $row['varInstagramLink']);
//define('SITE_MAINTENANCE', $row['chrMaintenance']);
//define('DATA_URL', '/boulderdesigns/nlive/');
//define('DATA_URL', '/');  

/*
 *  
 *  Message Constants 
 * 
 */

define('NO_RECORDS', 'No records are available.');
define('GLOBAL_SELECTION_RULE_NOTE', 'Please complete your selection in order to get the related information.');
define('GLOBAL_SAVE_SUCCESS_MSG', 'Congrats! The record has been successfully saved.');
define('GLOBAL_EDIT_SUCCESS_MSG', 'Congrats! The record has been successfully edited and saved.');
/*
 * Login Module - starts 
 */
define('LOGIN_INVALID_CREDENTIAL_MSG', 'Invalid Email Id or Password.');
define('RESET_PASS_LINK_TOKEN_MISMATCH', 'The reset password link is not valid please regenerate it again.');
define('RESET_PASS_LINK_ALREADY_USED', 'You have already used the link please regenerate the link to change the password again.');
define('RESET_PASS_LINK_EXPIRE_MSG', 'The reset password link expired please regenerate again.');
define('RESET_PASS_RESTRICTED_MSG', 'You can not change the password, please contact the administrator for further assistance.');
define('RESET_PASS_SUCCESS_MSG', 'Your password has been changed successfully. Login with the updated password.');
define('FORGOT_PASSWORD_WRONG_EMAILID', 'The email address you have entered is not in our database.');
define('FORGOT_PASSWORD_EMAIL_SENTMSG', 'Email has been sent to your email address which will help you to recover your account.');
define('FORGOT_PASSWORD_EMAIL_FAILURE_MSG', 'Sorry! There is some error while sending mail. Please try again.');
define('GLOBAL_CAPTCHA_MSG', 'reCAPTCHA is mandatory.');
/*
 * Login Module - ends 
 */
/* pages module - starts */
define('GLOBAL_VALID_PHONE_MSG', 'Please enter valid phone.');
define('PAGES_TITLE_MSG', 'Please enter page title.');
define('PAGES_PARENT_SELECT', 'Please select parent page.');
/* Pages module - ends */
define('VALID_EMAIL_VALIDATION', 'Please enter valid email address.');
define('PASSWORD_VALIDATION', 'Please enter password.');
define('PASSWORD_LIMIT', 'Password must be atleast 8 characters in length.');
define('PASSWORD_MAX_LIMIT', 'Password must be maximum 20 characters in length.');
define('PASSWORD_VALID_VALIDATION', 'Password should be in between 8 to 20 characters long and must contain at least one alpha bet and numeric.');
define('CONF_PASSWORD_VALIDATION', 'Please enter Confirm Password.');
define('CONF_PASSWORD_EQUAL', 'Confirm password does not match password.');
define('SPACE_PASSWORD_VALIDATION', 'Please space is not allowed.');
define('COMMON_DISPLAY_ORDER_MSG', 'Please enter display order.');
define('COMMON_DISPLAY_ORDER_VALID_MSG', 'Please enter valid display order.');

define('ALBUM_RECORD_TITLE', 'Please enter video title.');
define('CPD_NAME_MSG', 'Please enter name.');
define('CPD_PHONE_MSG', 'Please enter phone number.');
define('CPD_EMAIL_MSG', 'Please enter email address.');
define('CPD_VALID_EMAIL_MSG', 'Please enter valid email address.');
define('CPD_FAX_MSG', 'Please enter fax.');
define('COMMON_ALIAS_MSG', 'Please enter Alias.');
define('ALERT_ENDDATE_MSG', 'Please enter end date.');
define('COMMON_ALIAS_EXISTS_MSG', 'Alias already exists. Please change the alias.');


/* Settings Module Validation Messages Start */
define('SET_SITENAME_MSG', 'Please specify your site name.');
define('SET_MARGIN_US', 'Please specify Margin between US and CI.');
define('SET_SITEPATH_MSG', 'Please specify your site path.');
define('SET_ADMINPANEL_PAGESIZE_MSG', 'Please enter AdminPanel page size.');
define('SET_FRONT_PAGESIZE_MSG', 'Please enter Front page size.');
define('SET_PRICE_MSG', 'Please specify your Commision by Price value.');
define('SET_PERC_MSG', 'Please specify your Commision by Percentage value.');
define('SET_VALID_PAGESIZE_MSG', 'Page size should be between 10 and 50.');
define('SET_VALID_PERG_MSG', 'Commision By Percentage should be between 0 and 100.');
define('SET_VALID_URL_MSG', 'Please specify valid url (i.e http://www.example.com).');
define('DROP_BETA', 'Please enter dropbox serial key for development / beta like ' . ' ' . $row['varDropboxBetaSk']);
define('DROP_LIVE', 'Please enter dropbox serial key for live.');

define('SET_MAILER_MSG', 'Please select mailer type.');
define('SET_SMTP_SERVER_MSG', 'Please enter SMTP server name.');
define('SET_SMTP_USERNAME_MSG', 'Please enter  SMTP username.');
define('SET_SMTP_USERNAME_MSG_VALID', 'Please enter valid SMTP username.');
define('SET_SMTP_PWD_MSG', 'Please enter SMTP password.');
define('SET_SMTP_PORT', 'Please enter SMTP port.');
define('SET_SMTP_PWD_MSG_LENTH', 'SMTP Password must be at least 5 characters in length.');
define('SET_SENDER_NAME_MSG', 'Please enter sender name.');
define('SET_SENDER_EMAIL_MSG', 'Please enter sender email id.');
define('SET_SENDER_EMAIL_VALID_MSG', 'Please enter valid sender email id.');

define('CP_NAME', 'Please enter name.');
define('CP_EMAIL', 'Please enter login id.');
define('CP_EMAIL_VALID', 'Please enter valid login id.');
define('CP_PEMAIL', 'Please enter personal email id.');
define('CP_PEMAIL_VALID', 'Please enter valid personal email id.');
define('CP_DEFAULT_EMAIL', 'Please enter default email id.');
define('CP_DEFAULT_EMAIL_VALID', 'Please enter valid default email id.');
define('CP_CUST_SERVICE_EMAIL_VALID', 'Please enter valid customer service email id.');
define('CP_CONTACT_US_EMAIL', 'Please enter contact us email id.');
define('CP_CONTACT_US_VALID', 'Please enter valid contact us email id.');
define('CP_PASSWORD', 'Password must contain at least one numeric,one alphabetic and one special character.');

define('CONTACT_EMAIL', 'Please enter email.');
define('CONTACT_EMAIL_VALID', 'Please enter valid email.');
define('CONTACTINFO_MINIMUM_FAX_MSG', 'Fax should be of minimum 5 characters.');
define('CONTACTINFO_MAXIMUM_FAX_MSG', 'Fax should be of maximum 20 characters.');
define('CONTACTINFO_MINIMUM_PHONE_MSG', 'Phone no should be of minimum 5 digits.');
define('CONTACTINFO_MAXIMUM_PHONE_MSG', 'Phone no should be of maximum 20 digits.');
define('CONTACTUS_CAPTCH_MSG', 'Please enter the captcha code exactly as mentioned in order to verify and continue.');
define('CONTACTUS_LEAD_EMAIL', 'Please enter contact us lead email id.');
define('APPLYNOW_LEAD_EMAIL', 'Please enter apply now lead email id.');
define('NEWSLETTER_LEAD_EMAIL', 'Please enter newsletter lead email id.');
define('BILLPAYMENT_LEAD_EMAIL', 'Please enter billpayment lead email id.');
define('PROFILE_PASSWORD', 'Please enter password.');
define('PROFILE_CONF_PASSWORD', 'Please enter confirm password.');

/* Access Control module constants */
define('QUESTIONNAIR_MESSAGE', 'Please enter message.');
define('QUESTIONNAIR_NAME', 'Please enter name.');
define('FIRST_NAME', 'Please enter your first name.');
define('EMPTY_USER_VALIDATION', 'Please enter User ID/Email ID.');
define('VALID_USER_VALIDATION', 'Please enter valid User ID/Email ID.');
define('EXIST_EMAIL_ID', 'This email id already exist in our database.');

/* Access Control module constants */

/* Website Menu module constants */
define('MENU_TITLE_MSG', 'Please enter Menu Title.');
define('MENU_TYPE_MSG', 'Please select Menu Type.');
define('EXTERNAL_LINK_MSG', 'Please enter External Link.');
define('EXTERNAL_LINK_VALID', 'Please enter a valid External Link.');
define('MENU_PARENT_SELECT', 'Please select Parent Menu.');
/* Website Menu module constants */

/* menu Link Form constants */
define('MENU_LINK_REQUIRED_MSG', 'Please select a Link.');
/* menu Link Form constants */

/* Bill Attachment Front Pagination size */
define('BILL_PAGE_SIZE', '3');
/* Bill Attachment Front Pagination size */


if (DEFAULT_DATEFORMAT == "%d/%m/%Y") {
    define('CALENDAR_DATE_FORMAT', "dd/mm/yy");
} else if (DEFAULT_DATEFORMAT == "%m/%d/%Y") {
    define('CALENDAR_DATE_FORMAT', "mm/dd/yy");
} else if (DEFAULT_DATEFORMAT == "%Y/%m/%d") {
    define('CALENDAR_DATE_FORMAT', "yy/mm/dd");
} else if (DEFAULT_DATEFORMAT == "%Y/%d/%m") {
    define('CALENDAR_DATE_FORMAT', "yy/dd/mm");
} else if (DEFAULT_DATEFORMAT == "%M/%d/%Y") {
    define('CALENDAR_DATE_FORMAT', "mm/dd/yy");
}

if (DEFAULT_FRONT_DATEFORMAT == "%d/%m/%Y") {
    define('CALENDAR_DATE_FORMAT_FRONT', "dd/mm/yy");
} else if (DEFAULT_FRONT_DATEFORMAT == "%m/%d/%Y") {
    define('CALENDAR_DATE_FORMAT_FRONT', "mm/dd/yy");
} else if (DEFAULT_FRONT_DATEFORMAT == "%Y/%m/%d") {
    define('CALENDAR_DATE_FORMAT_FRONT', "yy/mm/dd");
} else if (DEFAULT_FRONT_DATEFORMAT == "%Y/%d/%m") {
    define('CALENDAR_DATE_FORMAT_FRONT', "yy/dd/mm");
} else if (DEFAULT_FRONT_DATEFORMAT == "%M/%d/%Y") {
    define('CALENDAR_DATE_FORMAT', "mm/dd/yy");
}


/* Press Release Module Start */
define('PRESS_TITLE_MSG', 'Please enter title.');
define('PRESS_CITY_MSG', 'Please enter city.');
define('PRESS_QUESTION_MSG', 'Please enter question.');
define('PRESS_ANSWER_MSG', 'Please enter answer.');
define('PHOTOALBUM_CAT_MSG', 'Please select category.');
define('PRESS_SDESC_MSG', 'Please enter short description.');


/* Questionnery Constant */
define('COMMAN_IMAGES_MSG', 'Only .jpg, .jpeg, .png or .gif image formats are supported.');
define('QUES_FNAME_MSG', 'Please enter first name.');
define('QUES_LNAME_MSG', 'Please enter last name.');
define('QUES_EMAILID_MSG', 'Please enter email address.');
define('QUES_EMAILIDC_MSG', 'Please enter confirm email address.');
define('QUES_CITY_MSG', 'Please enter city.');
define('QUES_ZIPCODE_MSG', 'Please enter zipcode.');
define('QUES_PHONE_MSG', 'Please enter phone no.');
define('QUES_STATE_MSG', 'Please select state.');
define('QUES__MSG', 'Please select State.');

define('CHR_LINKDIN', $row['chr_linkdin']);
define('LINKDIN_LINK', $row['varLinkedinLink']);

//echo APPPATH;exit;

function check_subdomain($subdomain) {
    $subdomainarr = explode('.', $subdomain);
    if (count($subdomainarr) > 2) {
        return true;
    } else {
        return false;
    }
}

//$current_domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
//
//if (check_subdomain($current_domain)) {
//    define('IS_SUBDOMAIN', 'Y');
//    $current_domain1 = explode(".", $current_domain);
//    define('SUBDOMAIN', $current_domain1[0]);
//} else {
    define('IS_SUBDOMAIN', 'N');
    define('SUBDOMAIN', 'indibizz');
//}

