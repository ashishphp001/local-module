<?php

class buyer_seller extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('buyer_seller_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/buyer_seller_tpl';
        $this->otp_tpl = 'front/otp_tpl';
        $this->load->library('session');
        $this->load->library('mylibrary');
        $this->load->helper('cookie');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index() {

//        echo "hgi";exit;
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "pages");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['DisplayContent'] = $CurrentPageData['chrDiscriptionDisplay'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);

        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];
        if (RECORD_ID == '107') {
            $getUserData = $this->common_model->getUserData($user_id);
            $this->viewData['getUserData'] = $getUserData;
            $this->viewData['UserSideBar'] = 'front/user_sidebar_tpl';
            $this->viewData['ContentPanel'] = 'front/user_dashboard_tpl';
        } else if (RECORD_ID == '110') {
            $getUserData = $this->common_model->getUserData($user_id);
            $this->viewData['getUserData'] = $getUserData;
            $this->viewData['UserSideBar'] = 'front/user_sidebar_tpl';
            $this->viewData['ContentPanel'] = 'front/user_product_tpl';
        } else if (RECORD_ID == '46') {
            $getUserData = $this->common_model->getUserData($user_id);
            $this->viewData['getUserData'] = $getUserData;
            $this->viewData['UserSideBar'] = 'front/user_sidebar_tpl';
            $this->viewData['ContentPanel'] = 'front/user_favourite_tpl';
        } else if (RECORD_ID == '94') {

            $getUserData = $this->common_model->getUserData($user_id);
            $this->viewData['getUserData'] = $getUserData;
            if ($getUserData['chrMobileVerify'] == 'N') {
                if ($this->input->get_post('ajax', TRUE) == 'Y') {
                    echo $this->parser->parse($this->otp_tpl, $this->viewData);
                    exit;
                } else {
                    $this->viewData['ContentPanel'] = 'front/otp_tpl';
                }
            } else {
                redirect(SITE_PATH);
            }
        } else if (RECORD_ID == '95') {

            $getUserData = $this->common_model->getUserData($user_id);
            if ($getUserData['chrMobileVerify'] == 'N') {
                $action = $this->common_model->getUrl("pages", "2", "94", '');
                redirect($action);
            }
            $DesingnationList = $this->Module_Model->getDesingnationList();
            $this->viewData['getDesingnationList'] = $DesingnationList;



            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->main_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/profile_tpl';
            }
        } else if (RECORD_ID == '108') {
            $getCompanydata = $this->Module_Model->getCompanyData($user_id);
//            print_R($getCompanydata);
            $this->viewData['getCompanydata'] = $getCompanydata;
            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->main_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/bank_info_tpl';
            }
        } else if (RECORD_ID == '109') {
//            $getCompanydata = $this->Module_Model->getCompanyData($user_id);
//            $this->viewData['getCompanydata'] = $getCompanydata;



            $event_id = $this->input->get_post('id', TRUE);
            if (!empty($event_id)) {
                $checkEvent = $this->Module_Model->checkevent($event_id, $user_id);
                $this->viewData['getCompanydata'] = $checkEvent;
                if (empty($checkEvent)) {
                    redirect($this->common_model->getUrl("pages", "2", "109", ''));
                }
            } else {
                $this->viewData['getCompanydata'] = array();
            }
            $CountriesList = $this->Module_Model->getCountriesList($getCompanydata['intCountry']);
            $this->viewData['getCountriesList'] = $CountriesList;
            $StateList = $this->Module_Model->getStateList($getCompanydata['intCountry'], $getCompanydata['intState']);
            $this->viewData['getStateList'] = $StateList;

            $CityList = $this->Module_Model->getCityList($getCompanydata['intState'], $getCompanydata['intCity']);
            $this->viewData['getCityList'] = $CityList;

            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->main_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/trade_shows_tpl';
            }
        } else if (RECORD_ID == '96') {



            $getUserProfile = $this->Module_Model->getUserProfile($user_id);
            $this->viewData['getUserProfile'] = $getUserProfile;

            $getCompanydata = $this->Module_Model->getCompanyData($user_id);
            $this->viewData['getCompanydata'] = $getCompanydata;

            $getBusinessType = $this->Module_Model->FrontBusinessTypeList($getCompanydata['varBusinessType']);
            $this->viewData['getBusinessType'] = $getBusinessType;

            $CompanyDesingnationList = $this->Module_Model->getCompanyDesingnationList($getCompanydata['intDesignation']);
            $this->viewData['getCompanyDesingnationList'] = $CompanyDesingnationList;


            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->main_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/company_info_tpl';
            }
        } else if (RECORD_ID == '111') {
            $getCompanydata = $this->Module_Model->getUserProfile($user_id);
//            print_R($getCompanydata);exit;
            $this->Module_Model->verifyEmailAddress($getCompanydata['varEmail']);


            $this->viewData['ContentPanel'] = 'front/verify_email_tpl';
        } else if (RECORD_ID == '98') {
//            $email=$this->input->get_post('email');

            $this->Module_Model->verifyEmail();

            $getCompanydata = $this->Module_Model->getCompanyData($user_id);
            $this->viewData['ContentPanel'] = 'front/verify_email_tpl';
        } else if (RECORD_ID == '97') {
            $getCompanydata = $this->Module_Model->getCompanyData($user_id);
            $this->viewData['getCompanyCertidata'] = $getCompanydata;

            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->main_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/company_certi_tpl';
            }
        } else if (RECORD_ID == '103') {

            $UserData = $this->common_model->getUserDataBySubDomain(SUBDOMAIN);
            $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");
            $this->viewData['getuserdata'] = $UserData;

            $this->viewData['Title'] = $CurrentPageData['varTitle'];
            $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
            $Seo_array['title'] = "Contact Us - " . $CurrentPageData['varMetaTitle'];
            $Seo_array['keywords'] = "Contact Us - " . $CurrentPageData['varMetaKeyword'];
            $Seo_array['description'] = "Contact Us - " . $CurrentPageData['varMetaDescription'];
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
            $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
            $this->viewData['ContentPanel'] = 'front/user/contact_tpl';
//            $this->load_view();
        } else if (RECORD_ID == '104') {
            $UserData = $this->common_model->getUserDataBySubDomain(SUBDOMAIN);
            $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");
            $this->viewData['getuserdata'] = $UserData;

            $this->viewData['Title'] = $CurrentPageData['varTitle'];
            $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
            $Seo_array['title'] = "Sell Offers - " . $CurrentPageData['varMetaTitle'];
            $Seo_array['keywords'] = "Sell Offers - " . $CurrentPageData['varMetaKeyword'];
            $Seo_array['description'] = "Sell Offers - " . $CurrentPageData['varMetaDescription'];
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
            $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
            $this->viewData['ContentPanel'] = 'front/user/sell_offers_tpl';
//            $this->load_view();
        } else if (RECORD_ID == '105') {
            $UserData = $this->common_model->getUserDataBySubDomain(SUBDOMAIN);
            $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");

            $this->viewData['getuserdata'] = $UserData;

            $this->viewData['Title'] = $CurrentPageData['varTitle'];
            $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
            $Seo_array['title'] = "Products - " . $CurrentPageData['varMetaTitle'];
            $Seo_array['keywords'] = "Products - " . $CurrentPageData['varMetaKeyword'];
            $Seo_array['description'] = "Products - " . $CurrentPageData['varMetaDescription'];
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
            $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
            $this->viewData['ContentPanel'] = 'front/user/products_tpl';
        } else if (RECORD_ID == '106') {
            $UserData = $this->common_model->getUserDataBySubDomain(SUBDOMAIN);
            $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");
            $userinfo = $this->common_model->getUserInformationData($UserData['int_id']);
            $this->viewData['getuserdata'] = $userinfo;
            $certiData = $this->Module_Model->getCompanyCertificateData($UserData['int_id']);
            $this->viewData['getCertiData'] = $certiData;
            $eventData = $this->Module_Model->getCompanyEventData($UserData['int_id']);
            $this->viewData['getEventData'] = $eventData;
            $this->viewData['Title'] = $CurrentPageData['varTitle'];
            $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
            $Seo_array['title'] = "Company Information - " . $CurrentPageData['varMetaTitle'];
            $Seo_array['keywords'] = "Company Information - " . $CurrentPageData['varMetaKeyword'];
            $Seo_array['description'] = "Company Information - " . $CurrentPageData['varMetaDescription'];
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
            $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
            $this->viewData['ContentPanel'] = 'front/user/company_tpl';
        } else {

            $this->session->set_userdata("pin_value_contact", md5(rand(2, 99999999)));
            $generated_pin = $this->mylibrary->generate_pin($this->session->userdata("pin_value_contact"));
            $this->viewData['generated_pin'] = $generated_pin;
            $this->session->set_userdata('pin_value_contact', $generated_pin);

            if ($user_id != '') {
                redirect(SITE_PATH);
            }
            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->main_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/buyer_seller_tpl';
            }
        }
        $this->load_view();
    }

    public function fblogin() {
//        print_R($_SESSION);
//        exit;
        $this->viewData['ContentPanel'] = 'front/fb_login_tpl';
        $this->load_view();
    }

    function refershcaptcha() {
//        echo "sad";exit;
        $this->session->set_userdata("pin_value_contact", md5(rand(2, 99999999)));
        $generated_pin = $this->mylibrary->generate_pin($this->session->userdata("pin_value_contact"));
        $this->viewData['generated_pin'] = $generated_pin;
        $this->session->set_userdata('pin_value_contact', $generated_pin);
        echo $this->mylibrary->show_pin_image($this->session->userdata("pin_value_contact"), $generated_pin) . '#' . $generated_pin;
        exit;
    }

    function handle_captcha() {

        $h_code = $this->input->get_post('captchaimage1', true);
        $sessionData = $this->session->userdata("pin_value_contact");
//echo $sessionData;exit;
        if ($sessionData == $h_code) {
            return TRUE;
        } else {
            $this->form_validation->set_message('handle_captcha', 'Please enter the captcha code exactly as mentioned in order to verify and continue.');
            return false;
        }
    }

    public function DesingnationList() {
        $intDesignation = $this->input->get_post('intDesignation', true);
        $DesingnationList = $this->Module_Model->getDesingnationList($intDesignation);
        echo $DesingnationList;
    }

    public function getcountrycode() {
        $Result = $this->Module_Model->getCountryCode();
        echo $Result;
    }

    public function getCertificate() {

        $Result = $this->Module_Model->getCertificate();
        if (!empty($Result)) {
            header("Content-type:application/json");
            echo json_encode($Result);
        } else {
            return 0;
        }
    }

    public function getTrademark() {

        $Result = $this->Module_Model->getTrademark();
        if (!empty($Result)) {
            header("Content-type:application/json");
            echo json_encode($Result);
        } else {
            return 0;
        }
    }

    public function contact($id) {
        $subdomain = $this->uri->segment(1);
        $UserData = $this->common_model->getUserDataBySubDomain($subdomain);
        $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");
        $this->viewData['getuserdata'] = $UserData;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = "Contact Us - " . $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = "Contact Us - " . $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = "Contact Us - " . $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
        $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
        $this->viewData['ContentPanel'] = 'front/user/contact_tpl';
        $this->load_view();
    }

    public function addfeedback() {
        $Result = $this->Module_Model->addfeedback();
        $website = $this->input->get_post('intWebsite', true);
        $product = $this->input->get_post('intProduct', true);
        if ($product != '') {
            $company_feedback = $this->common_model->getUrl("product", "140", $product, '');
        } else {
            $company_feedback = $this->common_model->getUrl("buyer_seller", "136", $website, '') . "/company#rating-slide";
        }
//        echo $company_feedback;exit;
        redirect($company_feedback);
    }

    public function addcontact() {
        $Result = $this->Module_Model->addcontact();
        $website = $this->input->get_post('intWebsite', true);
        $company_contact = $this->common_model->getUrl("buyer_seller", "136", $website, '') . "/contact?msg=1";
        redirect($company_contact);
    }

    public function add_partner() {

        $Result = $this->Module_Model->add_partner();
        if ($Result != '') {
            return 1;
        } else {
            return 0;
        }
    }

    public function add_bankinfo() {
        $this->form_validation->set_rules('intUser', 'Login', 'trim|required');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->add_bank_info();
            $tradeshows = $this->common_model->getUrl("pages", "2", "109", '');
            redirect($tradeshows);
        } else {
            $this->index();
        }
    }

    public function add_tradeshow() {

//        print_r($_REQUEST);exit;

        $next = $this->input->post('next', TRUE);
        $tradeshow = $this->input->post('varTradeShowName', TRUE);
        $this->form_validation->set_rules('intUser', 'Login', 'trim|required');

        if ($this->form_validation->run($this) == TRUE) {
            if ($tradeshow != '') {
                $Result = $this->Module_Model->add_tradeshow();
            }
            if ($next == 'Finish') {
                $msg = "?msg=1";
            } else {
                $msg = "";
            }
            $tradeshows = $this->common_model->getUrl("pages", "2", "109", '') . $msg;
            redirect($tradeshows);
        } else {
            $this->index();
        }
    }

    public function add_company_certificate() {
        $this->form_validation->set_rules('intUser', 'Login', 'trim|required');
        $this->form_validation->set_rules('varCertificateName', 'Certificate Name', 'trim|required');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->add_company_certificate();
        } else {
            $this->index();
        }
    }

    public function add_company_trademark() {
        $this->form_validation->set_rules('intTUser', 'Login', 'trim|required');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->add_company_trademark();
//            $company_certificate = $this->common_model->getUrl("pages", "2", "108", '');
//            redirect($company_certificate);
        } else {
            $this->index();
        }
    }

    public function add_companyinfo() {
        $this->form_validation->set_rules('intUser', 'Login', 'trim|required');
        $this->form_validation->set_rules('varCompany', 'Company', 'trim|required');
        $this->form_validation->set_rules('varCompanyEmail', 'Company Email', 'trim|required');
        $this->form_validation->set_rules('varCompanyPhone', 'Company Phone', 'trim|required');
//        $this->form_validation->set_rules('varCompanyAdv', 'Company Advantages', 'trim|required');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->add_companyinfo();
            $company_certi = $this->common_model->getUrl("pages", "2", "97", '');
            redirect($company_certi);
        } else {
            $this->index();
        }
    }

    public function get_partner() {

        $Result = $this->Module_Model->get_partner();
//        echo $Result;
        if (!empty($Result)) {
            header("Content-type:application/json");
            echo json_encode($Result);
        } else {
            return 0;
        }
    }

    public function delete_product() {

        $Result = $this->Module_Model->delete_product();
        if ($Result != '') {
            return 1;
        } else {
            return 0;
        }
    }

    public function delete_member() {

        $Result = $this->Module_Model->delete_member();
        if ($Result != '') {
            return 1;
        } else {
            return 0;
        }
    }

    public function DeleteEventdata() {

        $Result = $this->Module_Model->DeleteEventdata();
        if ($Result != '') {
            return 1;
        } else {
            return 0;
        }
    }

    public function DeleteTradeshowdata() {

        $Result = $this->Module_Model->DeleteTradeshowdata();
        if ($Result != '') {
            return 1;
        } else {
            return 0;
        }
    }

    public function DeleteTrademarkdata() {

        $Result = $this->Module_Model->DeleteTrademarkdata();
        if ($Result != '') {
            return 1;
        } else {
            return 0;
        }
    }

    public function delete_company_image() {

        $Result = $this->Module_Model->delete_company_image();
        return $Result;
    }

    public function delete_event_image() {

        $Result = $this->Module_Model->delete_event_image();
        return $Result;
    }

    public function registerUser() {


        $this->form_validation->set_rules('varRegisterEmail', 'Email Address', 'trim|required|valid_email|is_unique[users.varEmail]');
        $this->form_validation->set_rules('varRegisterPhone', 'Phone', 'regex_match[/^[0-9( )+]+.+$/]|is_unique[users.varPhone]');
        $this->form_validation->set_rules('varRegisterPassword', 'Password', 'trim|required|min_length[6]|matches[varRegisterConfirmPassword]|xss_clean');
        $this->form_validation->set_rules('varRegisterConfirmPassword', 'Confirm Password', 'trim|required|min_length[6]|xss_clean');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->registerUser();
            if ($Result == false) {
                $this->load->view('login');
            } else {
//                $gotoPath = $this->input->post('gotopath');
//                $LoginPath = (!empty($gotoPath)) ? $gotoPath : SITE_PATH;
//                redirect(urldecode($LoginPath));
//                $siteurl = SITE_PATH;
//                redirect("$siteurl");
                $siteurl = SITE_PATH;
                redirect($this->input->post('page_redirect', true));
            }
        } else {
//            $siteurl = SITE_PATH;
//            redirect("$siteurl");
            $siteurl = SITE_PATH;
            redirect($this->input->post('page_redirect', true));
        }
    }

    public function do_logout() {
        $this->session->unset_userdata(PREFIX);
        redirect(SITE_PATH);
    }

    public function send_email_password() {
        $Result = $this->Module_Model->checkEmailPassword();
        echo $Result;
    }

    public function forgot_password() {
        $Result = $this->Module_Model->forgot_password();
        echo $Result;
    }

    public function check_company_email_phone() {
        $Result = $this->Module_Model->check_company_email_phone();
        echo $Result;
    }

    public function Check_Email_Phone() {
        $Result = $this->Module_Model->Check_Email_Phone();
        echo $Result;
    }

    public function register_buyer() {

        $this->form_validation->set_rules('varName', 'Name', 'trim|required');
        $this->form_validation->set_rules('varEmail', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('varPassword', 'Password', 'trim|required');
        $this->form_validation->set_rules('varPhone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('varLocation', 'Location', 'trim|required');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->register_buyer();
            if ($Result == false) {

                $siteurl = $this->common_model->getUrl("pages", "2", "89", '');
                redirect("$siteurl");
            } else {
                $otpurl = $this->common_model->getUrl("pages", "2", "94", '');
                redirect($otpurl);
            }
        } else {
            $siteurl = SITE_PATH;
            redirect("$siteurl");
        }
    }

    public function send_otp() {
        echo $this->Module_Model->send_otp();
        exit;
    }

    public function resend_otp() {
        echo $this->Module_Model->resend_otp();
        exit;
    }

    public function update_verification() {
        $this->Module_Model->update_verification();
        $siteurl = SITE_PATH;
        redirect("$siteurl");
    }

    public function process() {

        $this->form_validation->set_rules('varLoginEmail', 'Email/Mobile', 'trim|required');
        $this->form_validation->set_rules('varLoginPassword', 'Password', 'trim|required');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->doLogin();
            if ($Result == false) {
                $siteurl = SITE_PATH;
                redirect("$siteurl");
            } else {
                $varPath = $this->input->post('varPath');
                $varLoginPath = $varPath;
                header("Location:$varLoginPath");
                exit;
//                redirect($varLoginPath);
            }
        } else {
            $siteurl = SITE_PATH;
            redirect("$siteurl");
        }
    }

    public function Check_Email() {
        echo $this->Module_Model->websiteCheck_Email();
        exit;
    }

    public function Check_UserPhone() {
        echo $this->Module_Model->websiteCheck_UserPhone();
        exit;
    }

    public function Check_User_Credentials() {
        echo $this->Module_Model->Check_User_Credentials();
        exit;
    }

//     public function contact() {
//         echo "hi";exit;
//     }


    public function company($id) {
        $subdomain = $this->uri->segment(1);
        $UserData = $this->common_model->getUserDataBySubDomain($subdomain);
        $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");
        $userinfo = $this->common_model->getUserInformationData($UserData['int_id']);
        $this->viewData['getuserdata'] = $userinfo;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];

        $Seo_array['title'] = "Company Information - " . $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = "Company Information - " . $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = "Company Information - " . $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
        $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
        $this->viewData['ContentPanel'] = 'front/user/company_tpl';
        $this->load_view();
    }

    public function products($id) {
        $subdomain = $this->uri->segment(1);
        $UserData = $this->common_model->getUserDataBySubDomain($subdomain);
        $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");
        $this->viewData['getuserdata'] = $UserData;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = "Products - " . $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = "Products - " . $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = "Products - " . $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
        $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
        $this->viewData['ContentPanel'] = 'front/user/products_tpl';
        $this->load_view();
    }

    public function selloffers($id) {
        $subdomain = $this->uri->segment(1);
        $UserData = $this->common_model->getUserDataBySubDomain($subdomain);
        $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");
        $this->viewData['getuserdata'] = $UserData;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = "Sell Offers - " . $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = "Sell Offers - " . $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = "Sell Offers - " . $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
        $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
        $this->viewData['ContentPanel'] = 'front/user/sell_offers_tpl';
        $this->load_view();
    }

    public function details($id) {
        $subdomain = $this->uri->segment(1);
        $UserData = $this->common_model->getUserDataBySubDomain($subdomain);
        if ($UserData['int_id'] == '') {
            redirect(SITE_PATH);
        }
        $CurrentPageData = $this->common_model->getPageData_Seo($UserData['int_id'], "users");
        $this->viewData['getuserdata'] = $CurrentPageData;
//        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "users");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['UserHeaderPanel'] = 'front/user/user_header_tpl';
        $this->viewData['UserFooterPanel'] = 'front/user/user_footer_tpl';
        $this->viewData['ContentPanel'] = 'front/user/home_tpl';

        $this->load_view();
    }

}

?>