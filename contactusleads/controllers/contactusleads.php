<?php

class contactusleads extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('contactusleads_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/contactusleads_tpl';
    }

    public function index() {
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "pages");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['DisplayContent'] = $CurrentPageData['chrDiscriptionDisplay'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $this->viewData['PagingTop'] = $this->mylibrary->generatepaging($this);
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);

        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        } else {
            $this->viewData['ContentPanel'] = 'front/contactusleads_tpl';
        }
        $this->load_view();
    }

    public function insert() {
        if (!$this->input->post()) {
            redirect($this->redirect_url);
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('varName', 'Name', 'trim|required');
        $this->form_validation->set_rules('varEmailId', 'Email ID', 'trim|required|valid_email');
        $this->form_validation->set_rules('txtMessage', 'Message', 'trim|required');

        if ($this->form_validation->run($this) == FALSE) {
            $this->index();
        } else {
            $contact = $this->Module_Model->process();
            $this->session->set_userdata('Contact_Thankyou', 'success');
            redirect(SITE_PATH . "contact-us/success");
        }
    }

    public function success() {

        $flashdata = $this->session->userdata('Contact_Thankyou');
        if ($flashdata != "success") {
            redirect(SITE_PATH);
            $Seo_array['title'] = "Thank you";
            $Seo_array['keywords'] = "Thank you";
            $Seo_array['description'] = "Thank you";
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['ContentPanel'] = 'front/thankyou_tpl';
            $this->load_view();
        } else {
            $Seo_array['title'] = "Thank you";
            $Seo_array['keywords'] = "Thank you";
            $Seo_array['description'] = "Thank you";
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['ContentPanel'] = 'front/thankyou_tpl';
            $this->load_view();
        }
    }

}

?>