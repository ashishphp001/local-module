<?php

class eventleads extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('eventleads_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/eventleads_tpl';
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

        $cities_Records = $this->Module_Model->getCitiesRecords();
        $this->viewData['ShowAllcitiesRecords'] = $cities_Records;

        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        } else {
            $this->viewData['ContentPanel'] = 'front/eventleads_tpl';
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
        $this->form_validation->set_rules('varEmailId', 'Email ID', 'trim|required|valid_varEmailId');

        if ($this->form_validation->run($this) == FALSE) {
            $this->index();
        } else {
            $contact = $this->Module_Model->process();
            $this->session->set_userdata('Event_Thankyou', 'success');
            redirect(SITE_PATH . "event-form?msg=thankyou");
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