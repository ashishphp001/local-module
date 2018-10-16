<?php

class pages extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pages_model', 'module_model');
        $this->module_url = FRONT_MODULE_URL;
    }

    public function index() {
        $this->load_data();
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "pages");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['DisplayContent'] = $CurrentPageData['chrDiscriptionDisplay'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['ContentPanel'] = 'front/pages_tpl';

        $this->load_view();
    }

    public function load_data() {

//        $fk_str = $this->frontlibrary->getfkarray(RECORD_ID);
//        $fk_array = explode(',', $fk_str); 
//        $fk_array = array_reverse($fk_array);
//        $count = count($fk_array);
//        foreach($fk_array as $value)
//        { 
//            $contentArry = $this->common_model->getpagedata($value);  
//            if($count == '1')
//            {
//                $bredcumsubstr .= "<li class='active' title='" . $contentArry['varAlias'] . "'>".$contentArry['varTitle']."</li>";
//            }
//            else
//            {
//                $link = $this->common_model->getUrl('pages', 2, $value);   
//                $Page_title = str_replace('&', '&amp;', $contentArry['varTitle']);
//                        $title = str_replace("'", '', $Page_title);
//                $bredcumsubstr .= "<li><a href='" . $link . "'  title='" . $title . "'>".$contentArry['varTitle']."</a></li>";
//            }
//            $count--;
//        }
//        $this->viewData['Breadcrumb_string'] = $this->common_model->setbreadcrum($bredcumsubstr);
        $this->viewData['Page_Title'] = $this->common_model->getpagedata(RECORD_ID);
    }

}

?>