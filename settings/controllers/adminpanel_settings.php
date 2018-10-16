<?php

class Adminpanel_settings extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('settings_model', 'Module_Model');                                      // MODULE MODELa
        $this->ChangeProfile_tpl = 'adminpanel/changeprofile_tpl';               // MODULE CHANGE PROFILE VIEW
        $this->viewChangeProfile_tpl = 'adminpanel/view_changeprofile';               // MODULE CHANGE PROFILE VIEW
        $this->SystemSetting_Url = 'adminpanel/systemsettings_tpl';             // MODULE SYESTEM SETTING VIEW
        $this->Logmanager_Url = 'adminpanel/logmanager_tpl';                 // MODULE LOG MANAGER VIEW
        $this->load->library('encrypt');
    }

    public function index() {
        $this->Set_Message();
        $this->viewData['changeprofileTab'] = true;
        $Get_Gensett_Data = $this->Module_Model->Get_Gensettings_Data();
        $GetData = $this->Module_Model->Get_ChangeProfile_Data();
        $this->viewData['ProfileData'] = $GetData;
        $this->viewData['SettingsData'] = $Get_Gensett_Data;
        $this->viewData['adminContentPanel'] = $this->ChangeProfile_tpl;
        $this->load_view();
    }

    public function Insert_ChangeProfile() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('varName', 'Full Name', 'trim|required');
        if ($this->input->post('varLoginEmail') != $this->input->get_post('Hid_varLoginEmail')) {
            $Is_Unique = '|is_unique[adminpanelusers.varLoginEmail]';
        } else {
            $Is_Unique = '';
        }
        $this->form_validation->set_rules('varLoginEmail', 'Login ID', 'trim|required|valid_email|' . $Is_Unique);
        $this->form_validation->set_rules('varPersonalEmail', 'Personal Email ID', 'trim|required|valid_email');
        if ($this->input->post('varPassword') != '') {
            $this->form_validation->set_rules('varPassword', 'New Password', 'trim|required|min_length[8]|max_length[20]|matches[PwdConfirmPassword]|xss_clean');
            $this->form_validation->set_rules('PwdConfirmPassword', 'Confirm Password', 'trim|required|min_length[8]|max_length[20]|xss_clean');
        }
        if ($this->session->userdata('UserId') == 1 || $this->session->userdata('UserId') == 2) {
            $this->form_validation->set_rules('varcontactusleadMailid', 'Contact Us Lead Email ID', 'trim|required|valid_emails');
//            $this->form_validation->set_rules('varServiceLeadMailid', 'Service Inquery Lead Email ID', 'trim|required|valid_emails');
        }

        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
        if ($this->form_validation->run($this) == FALSE) {
            $this->index();
        } else {
            $this->Module_Model->Insert_ChangeProfile();
            $this->Redirect_To_Page($this->input->get_post('ehintglcode'), 'edit');
        }
    }

    function Valid_Url($str) {
        if (!empty($str)) {
            $pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
            if (!preg_match($pattern, $str)) {
                $this->form_validation->set_message('Valid_Url', 'Please enter the valid link of social media.');
                return FALSE;
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }

    function savesystemsettings() {
        if ($this->input->get_post('h_save', true) == 'T') {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');

            if ($this->input->get_post('p') == 'gen') {
                $this->form_validation->set_rules('varSiteName', 'Site Name', 'trim|required');
                $this->form_validation->set_rules('varSitePath', 'Site Path', 'trim|required');
                $this->form_validation->set_rules('varAdminpanelPagesize', 'AdminPanel page size', 'trim|required');
                $this->form_validation->set_rules('varFrontPagesize', 'Front page size', 'trim|required');
//                if($this->input->get_post('chrDropboxBeta')== 'Y')
//                {
                $this->form_validation->set_rules('varDropboxBetaSk', 'Dropbox serial key for beta', 'trim|required');
//                }
//                else
//                {
                    $this->form_validation->set_rules('varDropboxLiveSk', 'Dropbox serial key for live ', 'trim|required');
//                }
            } else if ($this->input->get_post('p') == 'ser') {
                $this->form_validation->set_rules('varMailer', 'mailer', 'trim|required');
                $this->form_validation->set_rules('varSmtpServer', 'SMTP Server Name', 'trim|required');
                $this->form_validation->set_rules('varSmtpUserName', 'SMTP User Name', 'trim|required|valid_email');
                $this->form_validation->set_rules('varSmtpPassword', 'SMTP Password', 'trim|required|min_length[5]');
                $this->form_validation->set_rules('varSmtpPort', 'Smtp Port', 'trim|required|integer');
                $this->form_validation->set_rules('varSenderName', 'Sender Name', 'trim|required');
                $this->form_validation->set_rules('varSenderEmail', 'Sender Email Id', 'trim|required|valid_email');
            } else if ($this->input->get_post('p') == 'fac') {
                $this->form_validation->set_rules('varFACMId', 'FAC Merchant Id', 'trim|required');
                $this->form_validation->set_rules('varFACPassKey', 'FAC Pass Key', 'trim|required');
                $this->form_validation->set_rules('varFACAcquirerId', 'FAC Acquire Id', 'trim|required');
                $this->form_validation->set_rules('intFACKYDCurrencyCode', 'FAC KYD Currency Code', 'trim|required');
                $this->form_validation->set_rules('intFACUSDCurrencyCode', 'FAC USD Currency Code', 'trim|required');
                $this->form_validation->set_rules('intCItoUSConversionRate', 'CI to USD Conversion Rate', 'trim|required');
                $this->form_validation->set_rules('intUStoCIConversionRate', 'USD to CI Conversion Rate', 'trim|required');
            } else if ($this->input->get_post('p') == 'soc') {
                $this->form_validation->set_rules('varFacebookLink', 'Facebook link', 'callback_Valid_Url');
                $this->form_validation->set_rules('varTwitterLink', 'Twitter link', 'callback_Valid_Url');
                $this->form_validation->set_rules('varLinkedInLink', 'LinkedIn link', 'callback_Valid_Url');
//                $this->form_validation->set_rules('varInstagramLink', 'Skype link', 'callback_Valid_Url');
                $this->form_validation->set_rules('varGithubLink', 'Github link', 'callback_Valid_Url');
                $this->form_validation->set_rules('varGooglePlusLink', 'Google Plus link', 'callback_Valid_Url');
            } else if ($this->input->get_post('p') == 'seo') {
                $this->form_validation->set_rules('VarMetaTitle', 'Meta Title', 'trim|required');
                $this->form_validation->set_rules('VarMetaKeyword', 'Meta Keyword', 'trim|required');
                $this->form_validation->set_rules('VarMetaDescription', 'Meta Description', 'trim|required');
            } else if ($this->input->get_post('p') == 'thumb') {
                $this->form_validation->set_rules('varHomeBannerThumb', 'Home Banner Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varInnerBannerThumb', 'Inner Banner Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varBlogThumb', 'Blog Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varBlogDetailThumb', 'Blog Detail Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varCareerThumb', 'Career Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varProductCategoryThumb', 'Product Category Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varProductThumb', 'Product Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varPlanThumb', 'Plan Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varBuyLeadThumb', 'Buy Lead Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varSellLeadThumb', 'Sell Lead Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varServiceThumb', 'Service Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varUserThumb', 'User Thumb Size', 'trim|required');
                $this->form_validation->set_rules('varTestimonialsThumb', 'Testimonial Thumb Size', 'trim|required');
            } else if ($this->input->get_post('p') == 'uman') {
                $this->Set_Message();
                $this->Module_Model->Edit_SystemSettings();
                $this->Redirect_To_Page($this->input->get_post('p'), 'edit');
            }

            $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');

            if ($this->form_validation->run($this) == FALSE) {
                $this->systemsettings();
            } else {
                $this->Set_Message();
                $this->Module_Model->Edit_SystemSettings();
                $this->Redirect_To_Page($this->input->get_post('p'), 'edit');
            }
        } else {
            $this->systemsettings();
        }
    }

    public function systemsettings() {
        $this->Set_Message();
        if ($this->session->userdata('UserId') != 1) {
            redirect(ADMINPANEL_HOME_URL);
        }
        $this->Module_Model->GenerateUrl();
        $this->viewData['settingsTab'] = true;
        $this->viewData['Row'] = $this->Module_Model->SelectAll_SystemSettings();

        $GridTabArray = array(array("General", ADMINPANEL_URL . "settings/systemsettings?p=gen", "gen"),
            array("Mail", ADMINPANEL_URL . "settings/systemsettings?p=ser", "ser"),
            array("Social", ADMINPANEL_URL . "settings/systemsettings?p=soc", "soc"),
            array("SEO", ADMINPANEL_URL . "settings/systemsettings?p=seo", "seo"),
            array("Thumb", ADMINPANEL_URL . "settings/systemsettings?p=thumb", "thumb")
//            array("Cron", ADMINPANEL_URL . "settings/systemsettings?p=cron", "cron"),
        );

        $Request_p = $this->input->get_post('p');
        if (!empty($Request_p)) {
            $p = $Request_p;
        } else {
            $p = 'gen';
        }
        $this->viewData['Gridtabs'] = $this->Module_Model->GetGridTabs($GridTabArray, $p, true);
        $this->viewData['adminContentPanel'] = $this->SystemSetting_Url;
        $this->load_view();
    }

    function logmanager() {
        $this->Load_Data();
        if ($this->input->get_post('ajax') == 'Y') {
            echo $this->parser->parse($this->Logmanager_Url, $this->viewData);
            exit;
        }
        $this->viewData['logmanagerTab'] = true;
        $this->viewData['adminContentPanel'] = $this->Logmanager_Url;
        $this->load_view();
    }

    public function Load_Data() {
        $Query = $this->Module_Model->SelectAll_Logmanager();
        $this->viewData['CountTotal'] = $Query->num_Rows();
        $this->viewData['SelectAll'] = $Query->result();

        $tmpsetsortvar = trim('SetSorImg' . $this->Module_Model->OrderBy);
        $tmpsetsortvar = str_replace(".", "_", $tmpsetsortvar);
        $this->viewData[$tmpsetsortvar] = $this->Module_Model->SortVar;

        $this->viewData['HeaderPanel'] = $this->Module_Model->HeaderPanel();
        $this->viewData['PagingTop'] = $this->Module_Model->PagingTop();
        $this->viewData['PagingBottom'] = $this->Module_Model->PagingBottom();
    }

    public function Export() {
        $this->Module_Model->Export();
    }

    public function Delete() {
        $this->Module_Model->Delete_Row();
        $this->load_data();
        echo $this->parser->parse($this->Logmanager_Url, $this->viewData);
        exit;
    }

    public function Set_Message() {
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)) {
            if ($msg == 'add') {
                $this->viewData['Messagebox'] = $this->mylibrary->message("Congrats! The record has been successfully saved.");
            } else if ($msg == 'edit') {
                $this->viewData['Messagebox'] = $this->mylibrary->message("Congrats! The record has been successfully edited and saved.");
            }
        }
    }

    public function Redirect_To_Page($id, $msg_type) {
        $this->Module_Model->Initialize();
        $this->Module_Model->GenerateUrl();

        $this->session->set_flashdata('msg', $msg_type);
        $btnsaveandc_x = $this->input->get_post('btnsaveandc_x');

        if (!empty($btnsaveandc_x)) {

            redirect($this->Module_Model->AddPageName . 'eid=' . $id);
        } else {

            redirect($this->Module_Model->UrlWithPara);
        }
    }

    public function Check_Email() {
        echo $this->Module_Model->Check_Email();
        exit;
    }

    function LogsDelete() {
        echo $this->Module_Model->DeleteAllLogs();
        exit;
    }

    function HitDelete() {
        echo $this->Module_Model->DeleteHits();
        exit;
    }

}

?>