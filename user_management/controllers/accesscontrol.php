<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class accesscontrol extends AdminPanel_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('accesscontrol_model', 'module_model');              // MODULE MODEL
        $this->main_tpl = 'adminpanel/accesscontrol/accesscontrol_tpl';         // MODULE MAIN VIEW
        $this->add_tpl = 'adminpanel/accesscontrol/accesscontrol_add_tpl';      // MODULE ADD  VIEW
        $this->Module_Url = MODULE_URL . 'accesscontrol/';                      // MODULE URL
        $this->viewData['ajax'] = $this->input->get('ajax');
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
    }

    public function index() {

        $this->set_message();
        $this->load_data();
        $this->viewData['moduleurl'] = $this->Module_Url;

        if ($this->input->get_post('ajax') == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        }

        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    public function add() {

        $this->set_message();
        $eid = $this->input->get_post('eid', true);
        if (!empty($eid)) {
            $this->viewData['Eid'] = $eid;
            $row = $this->module_model->select($eid);
            if (empty($row)) {
                redirect($this->Module_Url . 'add');
            }

            $this->viewData['row'] = $row;
            $action = $this->Module_Url . 'update?' . $_SERVER['QUERY_STRING'];

            $StateName = $this->module_model->getStateName($row['varState']);
            $DistrictName = $this->module_model->getDistrictName($row['varState']);
        } else {
            $PageSize = $this->input->get_post('PageSize', true);
            $action = $this->Module_Url . 'insert?&PageSize=' . $PageSize;
            $StateName = $this->module_model->getStateName();
            $DistrictName = $this->module_model->getDistrictName();
        }

        $this->viewData['getStateName'] = $StateName;
        $this->viewData['getDistrictName'] = $DistrictName;
        $this->viewData['action'] = $action;
        $this->viewData['accesscontrolAddTab'] = true;
        $this->viewData['adminContentPanel'] = $this->add_tpl;
        $this->load_view();
    }

    public function getStates() {
        $stateName = $this->module_model->getStatesName();
        echo $stateName;
    }
    public function getDisctricts() {
        $DistrictName = $this->module_model->getDisctrictsName();
        echo $DistrictName;
    }

    public function insert() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('varName', 'Name', 'trim|required');
        $this->form_validation->set_rules('varLoginEmail', 'Login Email Id', 'trim|required|valid_email|is_unique[adminpanelusers.varLoginEmail]');
//        $this->form_validation->set_rules('varPersonalEmail', 'Personal Email Id', 'trim|required|valid_email');
        $this->form_validation->set_rules('varPassword', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('varConfPassword', 'Confirm Password', 'trim|required|matches[varPassword]|min_length[6]');
        // $this->form_validation->set_rules('intDisplayOrder', 'Display Order', 'trim|required|greater_than[0]');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');

        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $id = $this->module_model->insert();
            $this->redirect_to_page($id, 'add');
        }
    }

    public function update() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('varName', 'Name', 'trim|required');
        if ($this->input->post('varLoginEmail') != $this->input->get_post('Hid_varLoginEmail')) {
            $Is_Unique = '|is_unique[adminpanelusers.varLoginEmail]';
        } else {
            $Is_Unique = '';
        }

        $this->form_validation->set_rules('varLoginEmail', 'Login ID', 'trim|required|valid_email|' . $Is_Unique);
//        $this->form_validation->set_rules('varPersonalEmail', 'Personal Email Id', 'trim|required|valid_email');
        $this->form_validation->set_rules('varPassword', 'Password', 'min_length[6]|max_length[20]');
        $this->form_validation->set_rules('varConfPassword', 'Confirm Password', 'matches[varPassword]|min_length[6]|max_length[20]');
        //   $this->form_validation->set_rules('intDisplayOrder', 'Display Order', 'trim|required|greater_than[0]');

        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $this->module_model->update();
            $this->redirect_to_page($this->input->get_post('ehintglcode', true), 'edit');
        }
    }

    public function load_data() {
        $query = $this->module_model->selectAll();
        $this->viewData['counttotal'] = $query->num_rows();
        $this->viewData['selectAll'] = $query->result();

        $tmpsetSortVar = trim('setsortimg' . $this->module_model->OrderBy);
        $this->viewData[$tmpsetSortVar] = $this->module_model->SortVar;

        $this->viewData['HeaderPanel'] = $this->module_model->HeaderPanel();
        $this->viewData['PagingTop'] = $this->module_model->PagingTop();
        $this->viewData['PagingBottom'] = $this->module_model->PagingBottom();
    }

    public function set_message() {
        $msg = $this->session->flashdata('msg');

        if (!empty($msg)) {
            if ($msg == 'add') {
                $this->viewData['messagebox'] = $this->mylibrary->message(GLOBAL_SAVE_SUCCESS_MSG);
            } else if ($msg == 'edit') {
                $this->viewData['messagebox'] = $this->mylibrary->message(GLOBAL_EDIT_SUCCESS_MSG);
            }
        }
    }

    public function redirect_to_page($id, $msg_type) {
        $this->module_model->initialize();
        $this->module_model->Generateurl();
        $this->session->set_flashdata('msg', $msg_type);
        $btnsaveandc_x = $this->input->get_post('btnsaveandc', true);
        $btnsaveandc_y = $this->input->get_post('btnsaveande', true);

        if (!empty($btnsaveandc_x)) {
            redirect($this->module_model->AddPageName . '&eid=' . $id);
        } else if (!empty($btnsaveandc_y)) {
            redirect(ADMINPANEL_URL . 'user_management/groupaccess?fk_Userid=' . $id);
        } else {
            redirect($this->module_model->UrlWithPara);
        }
    }

    public function OrderUpdate() {
        $this->module_model->updatedisplayorder();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function delete() {
        $this->module_model->delete_row();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function Check_Email() {
        echo $this->module_model->Check_Email();
        exit;
    }

}

?>