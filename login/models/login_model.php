<?php

class login_model extends CI_Model {

    public function __construct() {
        
    }

    /* AdminPanel Login Process Start */

    public function Validate() {
        $UserName = $this->security->xss_clean($this->input->post('varLoginEmail'));
        $Password = $this->security->xss_clean($this->input->post('varPassword'));

        $cond = "varLoginEmail = '" . $UserName . "' AND varPassword = '" . $this->mylibrary->cryptPass($Password) . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
        $this->db->where($cond);
        $query = $this->db->get('adminpanelusers');

        if ($query->num_rows == 1) {
            $row = $query->row();
            $id = $this->Insert_Login_Log($row->int_id);
            $Data = array(
                'UserId' => $row->int_id,
                'UserLoginEmail' => $row->varLoginEmail,
                'UserName' => $row->varName,
                'UserType' => $row->varUserType,
                'Login_Log_Id' => $id,
                'Validated' => true
            );
            $this->session->set_userdata($Data);

            if ($this->input->get_post("chkrememberme") != "") {
                $OneYear = 365 * 24 * 3600; // one year's time.
                $Usercookie_Info = array('varLoginEmail' => $UserName, 'time' => time(), 'varPassword' => $Password, 'takemeto' => $takemeto, 'chkrememberme' => '1');
                $this->mylibrary->requestSetCookie('tml_CookieLogin', $Usercookie_Info, $OneYear);
            } else {
                $this->mylibrary->requestRemoveCookie('tml_CookieLogin');
            }
            $AllmoduleAccess = $this->mylibrary->getAllmoduleAccess();
            $this->session->set_userdata('permissionArry', $AllmoduleAccess);
            $menuModuleArry = $this->mylibrary->getMenuModules();
            $this->session->set_userdata('menuModuleArry', $menuModuleArry);
            return true;
        }
        return false;
    }

    /* AdminPanel Login Process End */

    public function send_passtoken($email) {
        $email_header = $this->mylibrary->get_email_header();
        $email_footer = $this->mylibrary->get_email_footer();
        $email_Regards = $this->mylibrary->get_email_regards();
        $email_left = $this->mylibrary->get_email_left();
        if (!empty($email)) {
            $token = $this->generate_token($email);
            $query = $this->db->get_where('adminpanelusers', array('varLoginEmail' => $email, 'chrDelete' => 'N'));
            $row = $query->row();
            $bullateLogo = ADMIN_MEDIA_URL . "mailtemplates/images/site_arrow.png";
            $logo = ADMIN_MEDIA_URL;
            $siteLogo = ADMIN_MEDIA_URL . "mailtemplates/images/IndiBizz Logo new.svg";
            $socimg = SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/';
            $fb = $socimg . 'fb.png';
            $tw = $socimg . 'tw.png';
            $in = $socimg . 'in.png';
            $to = $userRow['varPersonalEmail'];
            $Regards = "Best Regards";
            if (!empty($row->varPersonalEmail)) {
                $emails = $row->varPersonalEmail;
            }

            $fp_link = ADMINPANEL_URL . 'login/resetpassword?token=' . $row->varToken;

            $subject = 'Forgot Password: Login details of ' . SITE_NAME . ' Adminpanel';
            $body_admin = '';

            $content = "The following are your AdminPanel login credentials. Please maintain its confidentiality to ensure security of information.";

            $body .= ' <tr>
                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Link : </strong><a href=' . $fp_link . ' target="_blank" style="color:#337ab7; text-decoration:none;">' . $fp_link . '</a></td>
                                                                            </tr>';
            if (FACEBOOK_LINK != '') {
                $fbFollous .= '<td align="center"><a href="' . FACEBOOK_LINK . '" style="border:none;" title="Facebook" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/fb.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
            } if (GOOGLE_PLUS_LINK != '') {
                $glFollous .= '<td align="center"><a href="' . GOOGLE_PLUS_LINK . '" style="border:none;" title="Google+" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/gplus.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
            } if (LINKEDIN_LINK != '') {
                $liFollous .= '<td align="center"><a href="' . LINKEDIN_LINK . '" style="border:none;" title="LinkIn" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/linkedin.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
            } if (YOUTUBE_LINK != '') {
                $ytFollous .= '<td align="center"><a href="' . YOUTUBE_LINK . '" style="border:none;" title="Youtube" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/ytube.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
            }

//        }
            $html_message = file_get_contents(ADMIN_MEDIA_URL . "mailtemplates/forgot_password.html");
            $html_message = str_replace("@CONTENT", $content, $html_message);
            $html_message = str_replace("@MAIL_HEADER", $email_header, $html_message);
            $html_message = str_replace("@MAIL_FOOTER", $email_footer, $html_message);
            $html_message = str_replace("@FLOLLOW", $Follous, $html_message);
            $html_message = str_replace("@MAIL_LEFT", '', $html_message);
            $html_message = str_replace("@DETAILS", $body, $html_message);
            $html_message = str_replace("@YEAR", date('Y'), $html_message);
            $html_message = str_replace("@FACEBOOK", $fbFollous, $html_message);
            $html_message = str_replace("@TWITTER", $twFollous, $html_message);
            $html_message = str_replace("@YOUTUBE", $ytFollous, $html_message);
            $html_message = str_replace("@GOOGLE+", $glFollous, $html_message);
            $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
            $html_message = str_replace("@SKYPE", $skFollous, $html_message);
            $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
            $html_message = str_replace("@NAME", "Administrator", $html_message);
            $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
            $html_message = str_replace("@MEDIA_URL", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH, $html_message);
            $html_message = str_replace("@BGLOGO", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/header_bg.png', $html_message);
//            $html_message = str_replace("@LOGO", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/websitelogo.svg', $html_message);
            $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);
            $html_message = str_replace("@LOGO", $siteLogo, $html_message);
//            echo $html_message;
//            exit;

            $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
            $headers .= "Reply-To: " . $emails . "\r\n";
            $headers .= "Content-type: text/html\r\n";

            $resp = mail($emails, $subject, $html_message, $headers);
//            $forgot_pass = $this->mylibrary->send_mail($emails, $subject, $html_message);
            $data = array(
                'chrReceiver_Type' => 'A',
                'fk_EmailType' => '1',
                'varFrom' => MAIL_FROM,
                'txtTo' => $emails,
                'txtSubject' => $subject,
                'txtBody' => $html_message,
                'chrDelete' => 'N',
                'chrPublish' => 'Y',
                'dtCreateDate' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('emails', $data);

            return true;
        }
    }

    public function generate_token($email, $adminpanel = 'Y') {
        $token = md5(uniqid(rand(), true));
        $data = array(
            'varToken' => $token,
            'tokenTimestamp' => time(),
            'chrTokenDelete' => 'N'
        );
        if ($adminpanel == 'Y') {
            $this->db->where('varLoginEmail', $email);
            $this->db->update("adminpanelusers", $data);
        } else {
            $this->db->where('varEmailId', $email);
            $this->db->update("users", $data);
        }

        return $token;
    }

    public function passvalidate($email) {
        $result = $this->db->get_where('adminpanelusers', array('varLoginEmail' => $email, 'chrDelete' => 'N', 'chrPublish' => 'Y'));
        if ($result->num_rows == 1) {
            return true;
        }
        return false;
    }

    public function reset_pass_validate($token) {
        $returnArray = array();
        $result = $this->db->get_where('adminpanelusers', array('varToken' => $token, 'chrDelete' => 'N', 'chrPublish' => 'Y'));
        $row = $result->row();

        if ($row->chrTokenDelete == 'Y') {
            /* Check if new token is not generated and already used. */
            $returnArray['resp'] = false;
            $returnArray['msg'] = RESET_PASS_LINK_ALREADY_USED;
        } else if (((time() - $row->tokenTimestamp) / 60) > 60) {
            /* Check if token is not generated before an hour. */
            $returnArray['resp'] = false;
            $returnArray['msg'] = RESET_PASS_LINK_EXPIRE_MSG;
        } else if ($result->num_rows == 1 && ($row->tokenTimestamp - time()) / 60 <= 60) {
            $returnArray['resp'] = true;
        } else {
            $returnArray['resp'] = false;
            $returnArray['msg'] = RESET_PASS_LINK_TOKEN_MISMATCH;
        }
        return $returnArray;
    }

    public function update_usserpassword($type = 'P') {

        $user_token = trim($this->input->get_post('varToken', true));
        $user_pwd = $crypted_password = $this->mylibrary->cryptPass($this->input->post('varNewPassword', true));
        $up_data = array(
            'varPassword' => $user_pwd,
            'dtModifyDate' => date('Y-m-d h:i:s'),
            'chrTokenDelete' => 'Y'
        );

        if ($type == 'F') {
            $up_data['varPassUpdateTime'] = time();
            $this->db->where(array('varToken' => $user_token, 'chrDelete' => 'N', 'chrPublish' => 'Y'));
            $this->db->update('Users', $up_data);
        } else {
            $this->db->where(array('varToken' => $user_token, 'chrDelete' => 'N', 'chrPublish' => 'Y'));
            $this->db->update('adminpanelusers', $up_data);
        }
    }

    function logincounter() {

        if ($this->session->userdata('no_tries') == 5 || $this->session->userdata('no_tries') > 5) {
            $_SESSION["pin_value"] = md5(rand(2, 99999999));
            $generated_pin = substr(md5($_SESSION["pin_value"]), 15, 4);
            $_SESSION["cpatcha_code"] = $generated_pin;
            //generate captcha 
            $path = 'upimages/logincaptcha/';
            $sessPinvalue = $_SESSION["pin_value"];
            $vals = array(
                'word' => $generated_pin,
                'img_path' => $path,
                'img_url' => SITE_PATH . 'upimages/logincaptcha/',
                'font_path' => '',
                'img_width' => '100',
                'img_height' => '30',
                'custom_font_size' => '50',
                'expiration' => 7200
            );
            $cap = create_captcha($vals);

            $captcha = '';
            $captcha .= '<div class="class="txt2-bg fl">
                            <div class="fl">' . $cap['image'] . '</div>
                            <input  class="login-textbox-new mgl10" id="enqcap" name="enqcap" type="text"  maxlength="4"/>
                            <input name="pin_value_hdn" type="hidden" class="contentfont" id="pin_value_hdn" value="' . $cap['word'] . '" size="20" />
                        
              </div>';
        }
        return $captcha;
    }

    function Insert_Login_Log($UserId) {

        $data = array(
            'PUserGlCode' => $UserId,
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'dtLoginDate' => date('Y-m-d H:i:s'),
            'chrDelete' => 'N'
        );

        $this->db->insert('loginhistory', $data);
        $id = $this->db->insert_id();

        return $id;
    }

    /* Show Love Popup */

    function loginrestapicounter($user_id) {
        $whmusername = REST_API_ADMIN_USERNAME;
        $whmpassword = REST_API_ADMIN_PASSWORD;
        $query = REST_API_LOGINCOUNTER_URL;

        $querystring = "";

        if (!empty($_POST)) {
            foreach ($_POST as $key => $val) {
                $qstr = "";
                if (is_array($_POST[$key])) {
                    $qstr .= "&" . $key . "=" . implode(",", $_POST[$key]);
                    $querystring .= $qstr;
                } else {
                    $querystring .= "&" . $key . "=" . $val;
                }
            }
        }
        $querystring .= "&rest=y";

        if (!empty($user_id)) {
            $querystring .= "&fk_user=$user_id";
        }

        $querystring .= "&var_domain=" . $_SERVER['HTTP_HOST'];
        $data['url'] = REST_API_LOGINCOUNTER_URL;
        $data['data'] = $querystring;

        $curl = curl_init();
        # Create Curl Object
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        # Allow self-signed certs
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        # Allow certs that do not match the hostname
        curl_setopt($curl, CURLOPT_HEADER, 0);
        # Do not include header in output
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        # Return contents of transfer on curl_exec 
        $header[0] = "Authorization: Basic " . base64_encode($whmusername . ":" . $whmpassword) . "";
        //echo $header[0];exit; 
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        # set the username and password
        curl_setopt($curl, CURLOPT_URL, $query);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data['data']);
        # execute the query
        $server_output = curl_exec($curl);
        $data_collection = json_decode($server_output);

        return $data_collection;
    }

}

?>