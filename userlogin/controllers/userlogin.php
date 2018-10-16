<?php

class userlogin extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('userlogin_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/userlogin_tpl';
    }

    public function index() {
//        echo "123";exit;
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "Pages");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['DisplayContent'] = $CurrentPageData['chrDiscriptionDisplay'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
//        $this->viewData['PagingTop'] = $this->mylibrary->generatepaging($this);
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
//        $Pages_Records = $this->Module_Model->SelectAll_front();
//        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        } else {
            $this->viewData['ContentPanel'] = 'front/userlogin_tpl';
        }
        $this->load_view();
    }

    public function Check_Email1() {
        echo $this->Module_Model->Check_Email1();
        exit;
    }

    public function Check_forgotpassword() {
        echo $this->Module_Model->Check_forgotpassword();
        exit;
    }

    public function dologout() {

        $this->session->unset_userdata('int_id');
        $this->session->unset_userdata('varName');
        $this->session->unset_userdata('varEmail');
        $this->session->unset_userdata('varImage');
        
        redirect(SITE_PATH . "login");
    }

    public function checkuser() {
        if (!$this->input->post()) {
            redirect(SITE_PATH . "login");
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('varEmail', 'Email', 'trim|required|valid_varEmail');
        $this->form_validation->set_rules('varPassword', 'Password', 'trim|required');

//        print_r($this->input->post());exit;
        if ($this->form_validation->run($this) == FALSE) {
//            $this->index();
            $this->viewData['ContentPanel'] = 'front/login_tpl';
        } else {
            $email = $this->input->post('varEmail');
            $pass1 = $this->input->post('varPassword');
//            echo $email;exit;
            $checkaccess = $this->Module_Model->checkuseraccess($email, $pass1);
//            echo $checkaccess;exit;
            if ($checkaccess <= 0) {
                echo "<script> alert('Please enter valid email address or password.'); </script>";
                echo "<script> window.location='" . SITE_PATH . "login';</script>";
            } else {
                $checkuser = $this->Module_Model->setsession($email, $pass1);
//                echo "<script> alert('You are Logged in Successfully.'); </script>";
                echo "<script> window.location='" . SITE_PATH . "';</script>";
            }
        }

        echo $this->Module_Model->Check_Email1();
        exit;
    }

    public function sendpassword() {
//        echo "123";exit;
        if (!$this->input->post()) {
            redirect(SITE_PATH . "forgot-password");
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('varEmail', 'Email', 'trim|required|valid_varEmail');

        if ($this->form_validation->run($this) == FALSE) {
            $this->viewData['ContentPanel'] = 'front/forgotpassword_tpl';
        } else {
            $email = $this->input->post('varEmail');
//            echo $email;exit;
            $checkaccess1= $this->Module_Model->checkuseraccess1($email);
            if ($checkaccess1 <= 0) {
                echo "<script> alert('Please enter valid email address'); </script>";
                echo "<script> window.location='" . SITE_PATH . "forgot-password';</script>";
            } else {
                $checkuser = $this->Module_Model->SendPassword($email);
//                echo "<script> alert('You are Logged in Successfully.'); </script>";
                echo "<script> window.location='" . SITE_PATH . "';</script>";
            }
        }

       if (!$this->input->post()) {
            redirect(SITE_PATH . "forgot-password");
        }
    }

    public function details($id) {
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "Blog");
        $Pages_Records = $this->Module_Model->SelectAll_Detail_front(RECORD_ID);
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['ContentPanel'] = 'front/userlogin_detail_tpl';
        $this->viewData['GetData_details'] = $GetData_details;
        $this->viewData['ContentPanel'] = 'front/userlogin_detail_tpl';
        $this->viewData['SelectAlldetail'] = $SelectAlldetail;
        $this->load_view();
    }

}

?>