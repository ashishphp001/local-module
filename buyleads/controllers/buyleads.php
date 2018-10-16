<?php

class buyleads extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('buyleads_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/buyleads_tpl';
        $this->buyleads1_tpl = 'front/buyleads1_tpl';
        $this->rfq_tpl = 'front/rfq_tpl';
        $this->quote_now_tpl = 'front/quote_now_tpl';
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

        if (RECORD_ID == '100') {
//            $getRFQListing = $this->Module_Model->getRFQListingData();
//            $this->viewData['getRFQListing'] = $getRFQListing;
            $buylead = $this->input->get_post('buylead', TRUE);



            if ($buylead == '') {
                redirect($this->common_model->getUrl("pages", "2", "28", ""));
            }

            $checkbuyLead = $this->Module_Model->checkBuyLead($buylead);
            if ($checkbuyLead == '0') {
                $buyleadurl = $this->common_model->getUrl("buyleads", "147", $buylead, "");
                redirect($buyleadurl);
            }

            $this->session->set_userdata("pin_value_contact", md5(rand(2, 99999999)));
            $generated_pin = $this->mylibrary->generate_pin($this->session->userdata("pin_value_contact"));
            $this->viewData['generated_pin'] = $generated_pin;
            $this->session->set_userdata('pin_value_contact', $generated_pin);

            $UnitList2 = $this->Module_Model->getFrontUnitList();
            $this->viewData['getMOQUnitData'] = $UnitList2;

            $UnitList = $this->Module_Model->getFrontUnitList2();
            $this->viewData['getPriceUnitData'] = $UnitList;

            $PaymentTypeList = $this->Module_Model->getFrontPaymentTypeList();
            $this->viewData['getPaymentTypeData'] = $PaymentTypeList;

            $PaymentTermsList = $this->Module_Model->getFrontPaymentTermsList();
            $this->viewData['getPaymentTermsData'] = $PaymentTermsList;

            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->quote_now_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/quote_now_tpl';
            }
        } else if (RECORD_ID == '28') {
            $getCountBuyLeadsListing = $this->Module_Model->CountRow_front();
            $this->viewData['getCountBuyLeadsListing'] = $getCountBuyLeadsListing;
            $getRFQListing = $this->Module_Model->getRFQListingData();
            $this->viewData['getRFQListing'] = $getRFQListing;

            $getCatRFQListing = $this->Module_Model->getCatRFQListing();
            $this->viewData['getCatRFQListing'] = $getCatRFQListing;

            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->buyleads1_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/rfq_tpl';
            }
        } else {


            $this->session->set_userdata("pin_value_contact", md5(rand(2, 99999999)));
            $generated_pin = $this->mylibrary->generate_pin($this->session->userdata("pin_value_contact"));
            $this->viewData['generated_pin'] = $generated_pin;
            $this->session->set_userdata('pin_value_contact', $generated_pin);

            $getReqType = $this->Module_Model->getRequirementTypeFrontList();
            $this->viewData['getReqType'] = $getReqType;

            $getBusinessType = $this->Module_Model->FrontBusinessTypeList();
            $this->viewData['getBusinessType'] = $getBusinessType;

            $UnitList = $this->Module_Model->getFrontUnitList($_REQUEST['intUnit']);
            $this->viewData['getUnitData'] = $UnitList;

            $ExpUnitList = $this->Module_Model->getFrontEUnitList();
            $this->viewData['getExpUnitData'] = $ExpUnitList;

            $data_page_comb = $this->Module_Model->FrontBindpageshierarchy('intParentCategory', '', 'add-new-user-textarea2', '1');
//            $data_page_comb = $this->Module_Model->getParentCategoryData();
            $this->viewData['getParentCategory'] = $data_page_comb;
//            $data_page_comb = $this->Module_Model->getParentCategoryData();
//            $this->viewData['getParentCategory'] = $data_page_comb;



            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->main_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/buyleads_tpl';
            }
        }
        $this->load_view();
    }

    function refershcaptcha() {
        $this->session->set_userdata("pin_value_contact", md5(rand(2, 99999999)));
        $generated_pin = $this->mylibrary->generate_pin($this->session->userdata("pin_value_contact"));
        $this->viewData['generated_pin'] = $generated_pin;
        $this->session->set_userdata('pin_value_contact', $generated_pin);
        echo $this->mylibrary->show_pin_image($this->session->userdata("pin_value_contact"), $generated_pin) . '#' . $generated_pin;
        exit;
    }

    function handle_captcha() {

        $h_code = $this->input->get_post('captchaimage1', true);
        $sessionData = $this->session->userdata("pin_value_contact");
//echo $sessionData;exit;
        if ($sessionData == $h_code) {
            return TRUE;
        } else {
            $this->form_validation->set_message('handle_captcha', 'Please enter the captcha code exactly as mentioned in order to verify and continue.');
            return false;
        }
    }

    public function insert_quotenow() {
        $this->form_validation->set_rules('buylead', 'BuyLead Required', 'trim|required');
        $this->form_validation->set_rules('intUser', 'Login Required', 'trim|required');
        $this->form_validation->set_rules('varName', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('varPrice', 'Price', 'trim|required');
        $this->form_validation->set_rules('varMOQ', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('intUnit', 'Unit', 'trim|required');
        $this->form_validation->set_rules('intMOQUnit', 'MOQ Unit', 'trim|required');

        if ($this->form_validation->run($this) == TRUE) {


            $Result = $this->Module_Model->insert_quotenow();
            $action = $this->common_model->getUrl("pages", "2", "100", '');
            if ($Result != '') {
                $this->session->set_userdata('QuoteNow_Thankyou', 'success');
                redirect($action . "/success_quote");
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
    }

    public function success_quote() {

        $flashdata = $this->session->userdata('QuoteNow_Thankyou');
        if ($flashdata != "success") {
            redirect(SITE_PATH);
            $Seo_array['title'] = "Thank you";
            $Seo_array['keywords'] = "Thank you";
            $Seo_array['description'] = "Thank you";
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['ContentPanel'] = 'front/thankyou_quote_tpl';
            $this->load_view();
        } else {
            $Seo_array['title'] = "Thank you";
            $Seo_array['keywords'] = "Thank you";
            $Seo_array['description'] = "Thank you";
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['ContentPanel'] = 'front/thankyou_quote_tpl';
            $this->load_view();
        }
    }

    public function getCategoryNames() {
        $getCategory = $this->Module_Model->getCategoryNames();
        echo $getCategory;
    }

    public function getCategoryNamesByProductName() {
        $getCategory = $this->Module_Model->getCategoryNamesByProductName();
        header("Content-type:application/json");
        echo json_encode($getCategory);
//        echo $getCategory;
    }

    public function getSubCategoryData() {
//        $data_page_comb = $this->Module_Model->FrontBindpageshierarchy('intParentCategory', '', 'add-new-user-textarea2', '1');
        $getCategory = $this->Module_Model->getSubCategoryData();
        echo $getCategory;
    }

    public function allsuppliertype() {
        $supplier = $this->Module_Model->allsuppliertype();
        header("Content-type:application/json");
        echo json_encode($supplier);
    }

    public function insert_rfq() {


        $this->form_validation->set_rules('intUser', 'Login Required', 'trim|required');
        $this->form_validation->set_rules('varProduct', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('varReqType', 'Requirement Type', 'trim|required');
//        $this->form_validation->set_rules('intParentCategory', 'Product Category', 'trim|required');
//        $this->form_validation->set_rules('txtDescription', 'Description Name', 'trim|required');
//        $this->form_validation->set_rules('varQuantity', 'Quantity', 'trim|required');
//        $this->form_validation->set_rules('intUnit', 'Unit', 'trim|required');
        $action = $this->common_model->getUrl("pages", "2", "52", '');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->insert_rfq();

            if ($Result != '') {
                $this->session->set_userdata('Rfq_Thankyou', 'success');
                redirect($action . "/success");
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
    }

    public function success() {

        $flashdata = $this->session->userdata('Rfq_Thankyou');
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
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "buyleads");
        $Pages_Records = $this->Module_Model->SelectAll_Detail_front(RECORD_ID);
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['ContentPanel'] = 'front/buyleads_detail_tpl';
        $this->viewData['SelectAlldetail'] = $SelectAlldetail;

        $Pages_Records = $this->Module_Model->SelectAll_detail_front_id(RECORD_ID);
        $this->viewData['Pages_Records1'] = $Pages_Records;
        $this->load_view();
    }

    public function download() {
        $file = $this->input->get_post('file');
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'upimages/buyleads/file/' . $file);
        force_download($file, $data);
        exit;
    }

}

?>