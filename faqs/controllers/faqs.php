<?php

class faqs extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('faqs_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/faqs_tpl';
    }

    public function index() {
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "pages");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['DisplayContent'] = $CurrentPageData['chrDiscriptionDisplay'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $Pages_Records = $this->Module_Model->SelectAll_front();
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        } else {
            $this->viewData['ContentPanel'] = 'front/faqs_tpl';
        }
        $this->load_view();
    }


}

?>