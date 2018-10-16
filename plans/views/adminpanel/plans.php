<?php

class plans extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('plans_model', 'Module_Model');
        $this->module_url = FRONT_MODULE_URL;
        $this->main_tpl = 'front/plans_tpl';
        $this->rfq_tpl = 'front/rfq_tpl';
        $this->quote_now_tpl = 'front/quote_now_tpl';
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


        $SelectAll_front = $this->Module_Model->SelectAll_front();
        $this->viewData['SelectAll_front'] = $SelectAll_front;

        if ($this->input->get_post('ajax', TRUE) == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        } else {
            $this->viewData['ContentPanel'] = 'front/plans_tpl';
        }
        $this->load_view();
    }

    public function getCategoryNames() {
        $getCategory = $this->Module_Model->getCategoryNames();
        echo $getCategory;
    }
    public function getPlanPrice() {
        $getPlanPrice = $this->Module_Model->getPlanPrice();
        echo $getPlanPrice;
    }

    public function failure() {
        $this->viewData['ContentPanel'] = 'front/failure_tpl';
        $this->load_view();
    }

    public function payment() {
        $buylead_id = $this->input->get_post('buylead');
        $plan_id = $this->input->get_post('plan');
//        echo USER_ID;exit;
        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];
        $userdata = $this->Module_Model->user_data($user_id);
        
//        echo $userdata['chrPayment'];exit;
        if ($userdata['chrPayment'] == 'Y') {
            $paymentlink = $this->common_model->getUrl("pages", "2", "44", '');
            redirect($paymentlink);
        }
        if ($plan_id == '' || $user_id == '') {
            $paymentlink = $this->common_model->getUrl("pages", "2", "44", '');
            redirect($paymentlink);
        }
        $getPlanData = $this->Module_Model->payment_data($plan_id);
     
        if (empty($getPlanData)) {
            $paymentlink = $this->common_model->getUrl("pages", "2", "44", '');
            redirect($paymentlink);
        }
        $this->viewData['buylead_id'] = $buylead_id;
        $this->viewData['plan_data'] = $getPlanData;
        $getUserData = $this->Module_Model->user_data($user_id);
        $this->viewData['user_data'] = $getUserData;

        $this->viewData['ContentPanel'] = 'front/payment_tpl';
        $this->load_view();
    }

    public function allsuppliertype() {
        $supplier = $this->Module_Model->allsuppliertype();
        header("Content-type:application/json");
        echo json_encode($supplier);
    }

    public function update_data() {
        $Result = $this->Module_Model->user_update();
        if ($Result != '') {
            $paymentlink = $this->common_model->getUrl("pages", "2", "44", '');
            redirect($paymentlink);
        } else {
            $this->index();
        }
    }

    public function update_subdomain() {
        $this->form_validation->set_rules('varSubdomain', 'Subdomain', 'trim|required');
        if ($this->form_validation->run($this) == TRUE) {
            $Result = $this->Module_Model->update_subdomain();
            if ($Result != '') {
                redirect(SITE_PATH);
            } else {
                $this->index();
            }
        }
    }

    public function insert_rfq() {


        $this->form_validation->set_rules('intUser', 'Login Required', 'trim|required');
        $this->form_validation->set_rules('varProduct', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('varReqType', 'Requirement Type', 'trim|required');
        $this->form_validation->set_rules('intParentCategory', 'Product Category', 'trim|required');
        $this->form_validation->set_rules('txtDescription', 'Description Name', 'trim|required');
        $this->form_validation->set_rules('varQuantity', 'Quantity', 'trim|required');
        $this->form_validation->set_rules('intUnit', 'Unit', 'trim|required');
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

    public function payment_success() {


        $status = $this->input->get_post('status');
        if ($status == 'success') {
            $Result = $this->Module_Model->update_payment();
        }
//        echo "<pre>";
//        print_R($this->input->get_post());
//        exit;

        $Seo_array['title'] = "Payment Success";
        $Seo_array['keywords'] = "Payment Success";
        $Seo_array['description'] = "Payment Success";
        $this->common_model->get_metadata($Seo_array);

        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];

        if ($user_id == '') {
            $paymentlink = $this->common_model->getUrl("pages", "2", "44", '');
            redirect($paymentlink);
        }

        $userdata = $this->Module_Model->user_data($user_id);
        $getPlanData = $this->Module_Model->payment_data($userdata['intPlan']);
        if (empty($getPlanData)) {
            $paymentlink = $this->common_model->getUrl("pages", "2", "44", '');
            redirect($paymentlink);
        }
        $this->viewData['plan_data'] = $getPlanData;
        $getUserData = $this->Module_Model->user_data($user_id);
        $this->viewData['user_data'] = $getUserData;


        $date1 = $userdata['varPaymentDate'];
        $date2 = date('Y-m-d H:i:s');

        $date1Timestamp = strtotime($date1);
        $date2Timestamp = strtotime($date2);

        $difference = $date2Timestamp - $date1Timestamp;

        if ($userdata['varSubdomain'] == '' && $userdata['chrPayment'] == 'Y') {
            if ($difference <= '100') {
                $Result = $this->Module_Model->update_payment();
            }
        } else {
            redirect(SITE_PATH);
        }
        $this->viewData['ContentPanel'] = 'front/payment_success_tpl';
        $this->load_view();
    }

    public function Check_subdomain() {
        $Result = $this->Module_Model->checksubdomain();
        echo $Result;
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
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "plans");
        $Pages_Records = $this->Module_Model->SelectAll_Detail_front(RECORD_ID);
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
        $this->viewData['Title'] = $CurrentPageData['varTitle'];
        $this->viewData['CmsData'] = $CurrentPageData['txtDescription'];
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);
        $this->viewData['ContentPanel'] = 'front/plans_detail_tpl';
        $this->viewData['SelectAlldetail'] = $SelectAlldetail;

        $Pages_Records = $this->Module_Model->SelectAll_detail_front_id(RECORD_ID);
        $this->viewData['Pages_Records1'] = $Pages_Records;
        $this->load_view();
    }

    public function download() {
        $file = $this->input->get_post('file');
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'upimages/plans/file/' . $file);
        force_download($file, $data);
        exit;
    }

}

?>