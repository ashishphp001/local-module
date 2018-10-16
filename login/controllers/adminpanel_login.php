<?php

class Adminpanel_login extends Base_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('mylibrary');
       
        $this->load->helper('cookie');
        $this->load->helper(array('form', 'url'));
        $this->load->model('login_model');
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $ajax = 'Y';
        }
        if ($this->session->userdata('UserName') != '' && $ajax != 'Y') {
            redirect(SITE_PATH . 'adminpanel/dashboard');
        }
        $this->LoginPopUp = 'adminpanel/templates/loginpopup_tpl';
    }

    /* Login - Starts */

    function index() {
//echo "here";exit;
        $this->load->view('adminpanel/login_tpl');
    }
    
    function handle_captcha() 
    {

            $h_code = $this->input->get_post('enqcap');
            
            $sessionData = $_SESSION['pin_value'];
            if(trim($h_code) == '')
            {    
                $this->form_validation->set_message('handle_captcha', 'Please enter the captcha code exactly as mentioned in order to verify and continue.');
                return false;
            }
            else if($sessionData == $h_code)
            {
                 return true;
            }
            else
            {
                $this->form_validation->set_message('handle_captcha', 'Please enter the captcha code exactly as mentioned in order to verify and continue.');
                return false;
            } 
    } 
     
    public function process() {
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('varLoginEmail', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('varPassword', 'Password', 'trim|required');
       
        if ($this->form_validation->run($this) == TRUE) {
           
                $Result = $this->login_model->Validate();
            
                if ($Result == false) {
                    if ($this->session->userdata('no_tries')) {
                        $this->session->set_userdata('no_tries', ($this->session->userdata('no_tries') + 1));
                    } else {
                        $this->session->set_userdata('no_tries', 1);
                    }
               
                $data_cap = $this->login_model->logincounter();
             
                $new_data = array('captcha' => $data_cap, 'message' => LOGIN_INVALID_CREDENTIAL_MSG);
           
                $this->load->view('adminpanel/login_tpl', $new_data);
                
            }

            else {
                $gotoPath = $this->input->post('gotopath');
                
                $LoginPath = (!empty($gotoPath)) ? $gotoPath : SITE_PATH . 'adminpanel/dashboard';
//echo $this->session->userdata('UserType');exit;
//                if ($this->session->userdata('UserType') != 1) {
//                   
//                    $restapi_counter = $this->login_model->loginrestapicounter($this->session->userdata('UserId'));
//                    $setting_api_counter = $restapi_counter->logincounter;
//
//                    if ($restapi_counter->counter >= $setting_api_counter && $restapi_counter->never == 'N') {
//                      
//                        $this->session->set_userdata('ratingpopup', '1');
//                        $this->session->set_userdata('fromlogin', '1');
//                    } else {
//                        $this->session->set_userdata('ratingpopup', '0');
//                        $this->session->set_userdata('fromlogin', '0');
//                    }
//                } else {
//                    $this->session->set_userdata('ratingpopup', '0');
//                    $this->session->set_userdata('fromlogin', '0');
//                }
                redirect(urldecode($LoginPath));
            }
        } else {
            $this->index();
        }
    }

    /* Login - Ends */

    /* Forgot Password -Starts */

    function forgotpassword() {

        $this->load->view('adminpanel/forgotpassword_tpl');
    }

    function forgetpassprocess() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('varLoginEmail', 'Email ID', 'trim|required');
        if ($this->form_validation->run($this) == FALSE) {

            $this->forgotpassword();
        } else {

            $useremailid = trim($this->input->get_post('varLoginEmail', true));
            $result = $this->login_model->passvalidate($useremailid);
            if ($result == false) {

                $msg = array('message' => '<label class="error-note" style="margin: 80px -15px"><span class="error-arr"></span>' . FORGOT_PASSWORD_WRONG_EMAILID . '</label>');
            } else {

                $verify = $this->login_model->send_passtoken($this->input->get_post('varLoginEmail', true));

                if ($verify == true) {
                    $msg = array('message' => '<label class="success-note" style="margin: 80px -15px"><span class="error-arr"></span>' . FORGOT_PASSWORD_EMAIL_SENTMSG . '</span>');
                } else {
                    $msg = array('message' => '<label class="error-note" style="margin: 80px -15px"><span class="error-arr"></span>' . FORGOT_PASSWORD_EMAIL_FAILURE_MSG . '</span>');
                }
            }
            $this->load->view('adminpanel/forgotpassword_tpl', $msg);
        }
    }

    /* Forgot Password - Ends */

    /* Reset Password - Starts */

    public function resetpassword() {

        $usertoken = trim($this->input->get_post('token', true));
        if ($usertoken == '') {
            redirect(SITE_PATH . 'adminpanel/login');
        }
        $data['token'] = $usertoken;
        $this->load->view('adminpanel/resetpassword_tpl', $data);
    }

    public function resetpassprocess() 
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('varNewPassword', 'New Password', 'required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('varConfPassword', 'Confirm Password', 'required|min_length[6]|max_length[20]|matches[varNewPassword]');
        if ($this->form_validation->run($this) == FALSE) 
        {
            $usertoken = trim($this->input->get_post('varToken', true));
            if ($usertoken == '') 
            {
                redirect(SITE_PATH . 'adminpanel/login');
            }
            $errors = $this->form_validation->error_array();
            $Data = array('values' => $this->input->post(NULL), 'validation_errors' => $errors, 'token' => $usertoken);
            $this->session->set_flashdata('ErrorData', $Data);
            redirect(SITE_PATH . 'adminpanel/login/resetpassword?token=' . $usertoken);
        }
        else 
        {
            $user_token = trim($this->input->get_post('varToken', true)); 
            $result = $this->login_model->reset_pass_validate($user_token);
            if ($result == 0) 
            {
                $Data = array('message' => $result['msg'], 'validation_errors' => $errors, 'token' => $user_token);
                $this->session->set_flashdata('ErrorData', $Data);
                redirect(SITE_PATH . 'adminpanel/login/resetpassword?token=' . $user_token);
            }
            else 
            {
                $this->login_model->update_usserpassword();
                $Data = array('message' => RESET_PASS_SUCCESS_MSG);
                $this->session->set_flashdata('SuccessData', $Data);
                redirect(SITE_PATH . 'adminpanel/login');
            }
        }
    }

    /* Reset Password - Ends */

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
                    $querystring.="&" . $key . "=" . $val;
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

    /* Show Love Popup */

    function Check_Session_Expire() {

        if ($this->session->userdata('UserId') != '') {
            echo 'Y';
            exit;
        } else {
            echo 'N';
            exit;
        }
    }

    function login_popup() {
        echo $this->parser->parse($this->LoginPopUp, $this->viewData);
        exit;
    }

    function login_pop_detail() {
        echo $this->login_model->Validate();
        exit;
    }
}

?>