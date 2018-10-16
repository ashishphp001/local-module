<?php  

class sitemap extends Front_Controller {

    function __construct() { 
        parent::__construct();
        
        $this->load->model('sitemap_model', 'module_model');
        $this->module_url = FRONT_MODULE_URL;                   // MODULE URL          
        $this->main_tpl = 'front/sitemap_tpl'; 
    }

    public function index() {
//        $this->load_data(); 
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "pages");
//        $fk_str = $this->frontlibrary->getfkarray(RECORD_ID);
//        $fk_array = explode(',', $fk_str); 
//        $fk_array = array_reverse($fk_array);
//        $count = count($fk_array);
//        foreach($fk_array as $value)
//        { 
//            $contentArry = $this->common_model->getpagedata($value);  
//            if($count == '1')
//            {
//                $bredcumsubstr .= "<li class='active' title='" . $contentArry['varTitle'] . "'>".$contentArry['varTitle']."</li>";
//            }
//            else
//            {
//                $link = $this->common_model->getUrl('pages', 2, $value);   
//                $bredcumsubstr .= "<li><a href='" . $link . "'  title='" . $contentArry['varTitle'] . "'>".$contentArry['varTitle']."</a></li>";
//            }
//            $count--;
//        }
//        $this->viewData['Breadcrumb_string'] = $this->common_model->setbreadcrum($bredcumsubstr);
        $this->viewData['Page_Title'] = $this->common_model->getpagedata(RECORD_ID);
        $sitemapdata = $this->module_model->GetSiteMapData();
        $this->viewData['SiteMapData'] = $sitemapdata;
        $PortfolioSiteMapData = $this->module_model->get_portfolio_data();
        $this->viewData['PortfolioSiteMapData'] = $PortfolioSiteMapData;
        $BlogSiteMapData = $this->module_model->get_blog_data();
        $this->viewData['BlogSiteMapData'] = $BlogSiteMapData;
        $SocialData = $this->module_model->get_SocialData();
        $this->viewData['SocialData'] = $SocialData;
        $ServiceSiteMapData = $this->module_model->get_ServiceData();
        $this->viewData['ServiceSiteMapData'] = $ServiceSiteMapData;
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['ContentPanel'] = 'front/sitemap_tpl';
        $this->load_view();
    }
}

?>