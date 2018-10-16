<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminpanel_dashboard extends AdminPanel_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('dashboard_model', 'module_model');
        $this->main_tpl = 'adminpanel/dashboard_tpl';
    }

    public function index() {

        $this->viewData['adminContentPanel'] = 'adminpanel/dashboard_tpl';
        $this->pages();


        $sell_leads_Records = $this->module_model->getSellLead_Record();
        $this->viewData['CountSellleadsRecords'] = $sell_leads_Records;

        $buy_leads_Records = $this->module_model->getBuyLead_Record();
        $this->viewData['CountBuyleadsRecords'] = $buy_leads_Records;

        $users_Records = $this->module_model->getUser_Record();
        $this->viewData['CountUsersRecords'] = $users_Records;

        $user_Records = $this->module_model->getContactUs_Record();
        $this->viewData['CountContactUsRecords'] = $user_Records;
        
        $event_Records = $this->module_model->getEvents();
        $this->viewData['getEvents'] = $event_Records;
        
        $todayscontactusleads_Records = $this->module_model->getTodaysContactUs_Record();
        $this->viewData['CountTodayContactRecords'] = $todayscontactusleads_Records;

        $this->load_view();
    }

    public function do_logout() {
//         echo "123";exit;
        $this->logout_log();
       
        $this->session->sess_destroy();
        redirect(SITE_PATH . 'adminpanel');
    }

    function logout_log() {
        $userid = $this->session->userdata('UserId');
        $usertype = $this->session->userdata('UserType');
        $login_log_id = $this->session->userdata('Login_Log_Id');
        $data = array(
            'dtLogOutDate' => date('Y-m-d H:i:s'),
        );
        $this->db->where('int_id', $login_log_id);
        $this->db->update('loginhistory', $data);
    }

    function GetAlias() {
//        print_R(MODULE_ID);exit;
//        echo "here";exit;
        $this->mylibrary->GetAlias();
    }

    function addEvent() {
        $this->module_model->addEvent();
    }
    function IsSameAlias() {
        $this->mylibrary->IsSameAlias();
    }

    public function updatePublish() {
//        echo "here";exit;
        echo $this->module_model->updatedisplay();
        exit;
    }

    function pages() {
        $query = $this->module_model->pagesData();
        $return['pagesArray'] = $query->result();
        $return['pagesRecord'] = $query->num_rows();
        $this->viewData['pagesCount'] = $this->module_model->pagesCount();
        $this->viewData['pages'] = $return;
    }

}

?>