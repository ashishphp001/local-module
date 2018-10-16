<?php

class blogs extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('blogs_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/blogs_tpl';
    }

    public function index() {
//        echo "hi";exit;
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
        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        } else {
            $this->viewData['ContentPanel'] = 'front/blogs_tpl';
        }
        $this->load_view();
    }

    public function details($id) {
//        echo "here";exit;
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "blogs");
        
        $Pages_Records = $this->Module_Model->SelectAll_Detail_front(RECORD_ID);
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['ContentPanel'] = 'front/blogs_detail_tpl';
        $this->viewData['SelectAlldetail'] = $SelectAlldetail;

        $Pages_Records = $this->Module_Model->SelectAll_detail_front_id(RECORD_ID);
        $this->viewData['Pages_Records1'] = $Pages_Records;
        $BusinessType = $this->Module_Model->getBusinessTypes();
        $this->viewData['getBusinessType'] = $BusinessType;
        $recentBlog = $this->Module_Model->SelectAll_RecentBlog(RECORD_ID);
        $this->viewData['getRecentBlogs'] = $recentBlog;
        $this->load_view();
    }

}

?>