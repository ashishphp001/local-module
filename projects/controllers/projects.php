<?php

class projects extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('projects_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/projects_tpl';
    }

    public function index() {
//            echo "hi";exit;
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "pages");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['DisplayContent'] = $CurrentPageData['chrDiscriptionDisplay'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $this->viewData['PagingTop'] = $this->mylibrary->generatepaging($this);
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $Pages_Records = $this->Module_Model->SelectAll_front();
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        
//        $getMainCategory = $this->Module_Model->getMainCategory();
//        $this->viewData['getMainCategory'] = $getMainCategory;
        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        } else {
            $this->viewData['ContentPanel'] = 'front/projects_tpl';
        }
        $this->load_view();
    }

    public function details($id) {
//        echo "here";exit;
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "projects");
        $Pages_Records = $this->Module_Model->SelectAll_Detail_front(RECORD_ID);
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['ContentPanel'] = 'front/projects_detail_tpl';
        $this->viewData['SelectAlldetail'] = $SelectAlldetail;

     
//        $this->viewData['Pages_Records1'] = $Pages_Records;
        $this->load_view();
    }

 public function download() {
        $file = $this->input->get_post('file');
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'upimages/projects/' . $file);
        force_download($file, $data);
        exit;
    }

}

?>
