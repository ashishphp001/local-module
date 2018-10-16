<?php

class product extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('product_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/product_tpl';
        $this->listing_tpl = 'front/product_listing_tpl';
        $this->supplier_tpl = 'front/supplier_listing_tpl';
        $this->listing1_tpl = 'front/product_listing1_tpl';
        $this->supplier1_tpl = 'front/supplier_listing1_tpl';
        $this->load->library('session');
        $this->load->library('mylibrary');
        $this->load->helper('cookie');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index() {

        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "pages");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['DisplayContent'] = $CurrentPageData['chrDiscriptionDisplay'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->viewData['PagingTop'] = $this->mylibrary->generatepaging($this);
        $this->common_model->get_metadata($Seo_array);


        if (RECORD_ID == '51') {

            $keyword = $this->input->get_post('keyword', TRUE);
            if ($keyword != '') {
                $this->Module_Model->cookiesProduct();
            }
            $getProductSearch = $this->Module_Model->getProductSearch();
            $this->viewData['getProductSearch'] = $getProductSearch;

            $getCategoryNames = $this->Module_Model->getCategoryNames();
            $this->viewData['getCategoryNames'] = $getCategoryNames;

            $getProductListing = $this->Module_Model->getProductLisitngData();
            $this->viewData['getProductListing'] = $getProductListing;

            $getCountProductListing = $this->Module_Model->CountRow_front();
            $this->viewData['getCountProductListing'] = $getCountProductListing;

            $BusinessList = $this->Module_Model->getBusinessTypeList();
            $this->viewData['getBusinessType'] = $BusinessList;

            $CityList = $this->Module_Model->getCityFilter();
            $this->viewData['getCityFilter'] = $CityList;

            $PlanList = $this->Module_Model->getPlanList();
            $this->viewData['getPlanList'] = $PlanList;

            $SupplierList = $this->Module_Model->getSupplierList();
            $this->viewData['getSupplierData'] = $SupplierList;

            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->listing1_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/product_listing_tpl';
            }
        } else if (RECORD_ID == '99') {
            $keyword = $this->input->get_post('keyword', TRUE);
            if ($keyword != '') {
                $this->Module_Model->cookiesProduct();
            }

            $CityList = $this->Module_Model->getCityFilter();
            $this->viewData['getCityFilter'] = $CityList;

            $getCategoryNames = $this->Module_Model->getCategoryNames();
            $this->viewData['getCategoryNames'] = $getCategoryNames;

            $getProductListing = $this->Module_Model->getProductLisitngData();
            $this->viewData['getProductListing'] = $getProductListing;

            $getCountProductListing = $this->Module_Model->CountRow_front();
            $this->viewData['getCountProductListing'] = $getCountProductListing;
            $BusinessList = $this->Module_Model->getBusinessTypeList();
            $this->viewData['getBusinessType'] = $BusinessList;
            $PlanList = $this->Module_Model->getPlanList();
            $this->viewData['getPlanList'] = $PlanList;
            $SupplierList = $this->Module_Model->getSupplierList();
            $this->viewData['getSupplierData'] = $SupplierList;

            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->supplier1_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/supplier_listing_tpl';
            }
        } else {

            $this->session->set_userdata("pin_value_contact", md5(rand(2, 99999999)));
            $generated_pin = $this->mylibrary->generate_pin($this->session->userdata("pin_value_contact"));
            $this->viewData['generated_pin'] = $generated_pin;
            $this->session->set_userdata('pin_value_contact', $generated_pin);

            $id = $this->input->get_post('product');
            $this->viewData['product'] = $id;
            if ($id != '') {
                $product_id = $this->mylibrary->decryptPass($id);
                $checkuserproduct = $this->Module_Model->checkUserProduct($product_id);
                if ($checkuserproduct == 0) {
                    $getproductUrl = $this->common_model->getUrl("pages", "2", "50", '');
                    redirect($getproductUrl);
                }
                $Row_product = $this->Module_Model->Select_product_Rows($product_id);
                $this->viewData['Row_product'] = $Row_product;



                $UnitList1 = $this->Module_Model->getFrontUnitList1($Row_product['intPriceUnit']);
                $this->viewData['getPriceUnitData'] = $UnitList1;

                $UnitList2 = $this->Module_Model->getFrontUnitList2($Row_product['intMOQUnit']);
                $this->viewData['getMOQUnitData'] = $UnitList2;

                $UnitList = $this->Module_Model->getFrontUnitList($Row_product['intUnit']);
                $this->viewData['getUnitData'] = $UnitList;

                $TimeList = $this->Module_Model->getFrontTimeList($Row_product['intTime']);
                $this->viewData['getTimeData'] = $TimeList;


                $DeliveryTermsList = $this->Module_Model->getFrontDeliveryTermsList($Row_product['intDeliveryTerms']);
                $this->viewData['getDeliveryTermsData'] = $DeliveryTermsList;

                $PaymentTermsList = $this->Module_Model->getFrontPaymentTermsList($Row_product['intPaymentTerms']);
                $this->viewData['getPaymentTermsData'] = $PaymentTermsList;

                $PaymentTypeList = $this->Module_Model->getFrontPaymentTypeList($Row_product['intPaymentType']);
                $this->viewData['getPaymentTypeData'] = $PaymentTypeList;

//                $data_page_comb = $this->Module_Model->FrontBindpageshierarchy('intParentCategory', $Row_product['intParentCategory'], 'add-new-user-textarea2', '1');
//                $this->viewData['getParentCategory'] = $data_page_comb;
            } else {

                $UnitList1 = $this->Module_Model->getFrontUnitList1();
                $this->viewData['getPriceUnitData'] = $UnitList1;

                $UnitList2 = $this->Module_Model->getFrontUnitList2();
                $this->viewData['getMOQUnitData'] = $UnitList2;

                $UnitList = $this->Module_Model->getFrontUnitList();
                $this->viewData['getUnitData'] = $UnitList;

                $TimeList = $this->Module_Model->getFrontTimeList();
                $this->viewData['getTimeData'] = $TimeList;


                $DeliveryTermsList = $this->Module_Model->getFrontDeliveryTermsList();
                $this->viewData['getDeliveryTermsData'] = $DeliveryTermsList;

                $PaymentTermsList = $this->Module_Model->getFrontPaymentTermsList();
                $this->viewData['getPaymentTermsData'] = $PaymentTermsList;

                $PaymentTypeList = $this->Module_Model->getFrontPaymentTypeList();
                $this->viewData['getPaymentTypeData'] = $PaymentTypeList;

//                $data_page_comb = $this->Module_Model->FrontBindpageshierarchy('intParentCategory', '', 'add-new-user-textarea2', '1');
//                $data_page_comb = $this->FrontBindpageshierarchy();
//                $this->viewData['getParentCategory'] = $data_page_comb;
            }
            if ($this->input->get_post('ajax', TRUE) == 'Y') {
                echo $this->parser->parse($this->main_tpl, $this->viewData);
                exit;
            } else {
                $this->viewData['ContentPanel'] = 'front/product_tpl';
            }
        }

        $this->load_view();
    }

    public function FrontBindpageshierarchy() {
        $data = $this->Module_Model->FrontBindpageshierarchy('intParentCategory', '', 'add-new-user-textarea2', '1');
        header("Content-type:application/json");
        echo json_encode($data);
//        echo $data;
    }

    public function delete_image_by_name() {
        $this->Module_Model->delete_image_by_name();
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

    public function get_page_products() {
        $getProductListing = "";
        $getProductListings = $this->Module_Model->getProductLisitngData();
//        print_R($getProductListing);
        $this->viewData['getProductListings'] = $getProductListings;
        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->listing1_tpl, $this->viewData);
            exit;
        } else {
            
        }
    }

    public function contact_supplier() {

        $this->form_validation->set_rules('intProduct', 'Product', 'trim|required');
        $this->form_validation->set_rules('varQty', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('intMOQUnit', 'MOQ', 'trim|required');

        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->insert_contact_supplier();
            $action = $this->common_model->getUrl("pages", "2", RECORD_ID, '');
            if ($Result != '') {
                $this->session->set_userdata('ContactSupplier_Thankyou', 'success');
                redirect($action . "/contact_supplier_success");
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
    }

    public function insert_product() {
        $this->form_validation->set_rules('intUser', 'Login Required', 'trim|required');
        $this->form_validation->set_rules('intParentCategory', 'Product Category', 'trim|required');
        $this->form_validation->set_rules('varName', 'Product Name', 'trim|required');
//        $this->form_validation->set_rules('varPrice', 'Price', 'trim|required');
//        $this->form_validation->set_rules('intPriceUnit', 'Unit Price', 'trim|required');
        $this->form_validation->set_rules('varMOQ', 'MOQ', 'trim|required');
        $this->form_validation->set_rules('intMOQUnit', 'MOQ Unit', 'trim|required');

        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->insert_product();
            $action = $this->common_model->getUrl("pages", "2", "50", '');
            if ($Result != '') {
                $this->session->set_userdata('Product_Thankyou', 'success');
                redirect($action . "/success");
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
    }

    public function clear_cookies() {
        $this->Module_Model->clear_cookies();
    }

    public function contact_supplier_success() {

        $flashdata = $this->session->userdata('ContactSupplier_Thankyou');
        if ($flashdata != "success") {
            redirect(SITE_PATH);
            $Seo_array['title'] = "Thank you";
            $Seo_array['keywords'] = "Thank you";
            $Seo_array['description'] = "Thank you";
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['ContentPanel'] = 'front/contact_supplier_thankyou_tpl';
            $this->load_view();
        } else {
            $Seo_array['title'] = "Thank you";
            $Seo_array['keywords'] = "Thank you";
            $Seo_array['description'] = "Thank you";
            $this->common_model->get_metadata($Seo_array);
            $this->viewData['ContentPanel'] = 'front/contact_supplier_thankyou_tpl';
            $this->load_view();
        }
    }

    public function success() {

        $flashdata = $this->session->userdata('Product_Thankyou');
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

        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "product");
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);

        $UnitList2 = $this->Module_Model->getFrontUnitList2();
        $this->viewData['getMOQUnitData'] = $UnitList2;

        $UnitList1 = $this->Module_Model->getFrontUnitList1();
        $this->viewData['getPriceUnitData'] = $UnitList1;

        $Pages_Records = $this->Module_Model->SelectAll_Detail_front(RECORD_ID);
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        $this->viewData['ContentPanel'] = 'front/product_detail_tpl';

        $this->load_view();
    }

    public function download() {
        $file = $this->input->get_post('file');
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'upimages/product/brochure/' . $file);
        force_download($file, $data);
        exit;
    }

}

?>