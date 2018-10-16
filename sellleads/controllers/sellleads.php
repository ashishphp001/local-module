<?php

class sellleads extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('sellleads_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/sellleads_tpl';
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
//        $Pages_Records = $this->Module_Model->SelectAll_front();
//        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;

        $getReqType = $this->Module_Model->getRequirementTypeFrontList();
        $this->viewData['getReqType'] = $getReqType;

        $UnitList = $this->Module_Model->getFrontUnitList($_REQUEST['intUnit']);
        $this->viewData['getUnitData'] = $UnitList;

        $ExpUnitList = $this->Module_Model->getFrontEUnitList();
        $this->viewData['getExpUnitData'] = $ExpUnitList;

        $data_page_comb = $this->Module_Model->FrontBindpageshierarchy('intParentCategory', '', 'add-new-user-textarea2', '1');
        $this->viewData['getParentCategory'] = $data_page_comb;

        $PaymentTermsList = $this->Module_Model->getFrontPaymentTermsList();
        $this->viewData['getPaymentTermsData'] = $PaymentTermsList;

        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        } else {
            $this->viewData['ContentPanel'] = 'front/sellleads_tpl';
        }
        $this->load_view();
    }

    public function getCategoryNames() {
        $getCategory = $this->Module_Model->getCategoryNames();
        echo $getCategory;
    }

    public function allsuppliertype() {
        $supplier = $this->Module_Model->allsuppliertype();
        header("Content-type:application/json");
        echo json_encode($supplier);
    }

    public function insert_sell_leads() {


        $this->form_validation->set_rules('intUser', 'Login Required', 'trim|required');
        $this->form_validation->set_rules('varProduct', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('varReqType', 'Requirement Type', 'trim|required');
        $this->form_validation->set_rules('intParentCategory', 'Product Category', 'trim|required');
        $this->form_validation->set_rules('txtDescription', 'Description Name', 'trim|required');
        $this->form_validation->set_rules('varQuantity', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('intUnit', 'Unit', 'trim|required');
        $action = $this->common_model->getUrl("pages", "2", "27", '');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->insert_sellleads();

            if ($Result != '') {
                $this->session->set_userdata('sell_Thankyou', 'success');
                redirect($action . "/success");
            } else {
                $this->index();
            }
        } else {
//            $siteurl = SITE_PATH;
//            redirect("$siteurl");
            $siteurl = $action;
            redirect($siteurl);
        }
    }

    public function success() {

        $flashdata = $this->session->userdata('sell_Thankyou');
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

    public function details($id) {
//        echo "here";exit;
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "sellleads");
        $Pages_Records = $this->Module_Model->SelectAll_Detail_front(RECORD_ID);
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['ContentPanel'] = 'front/sellleads_detail_tpl';
        $this->viewData['SelectAlldetail'] = $SelectAlldetail;

        $Pages_Records = $this->Module_Model->SelectAll_detail_front_id(RECORD_ID);
        $this->viewData['Pages_Records1'] = $Pages_Records;
        $this->load_view();
    }

}

?>