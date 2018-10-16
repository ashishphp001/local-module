<?php

class Adminpanel_contact_info extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('contact_info_model', 'Module_Model');           // MODULE MODEL
        $this->main_tpl = 'adminpanel/contactinfo_tpl';                   // MODULE MAIN VIEW
        $this->module_url = MODULE_URL;                          // MODULE URL
        $this->load->helper(array('form', 'url'));
        $this->viewData['contact_infoTab'] = true;
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
        $this->Module_Model->permissionArry = $this->permission[MODULE_PATH];
    }

    public function add() {

        $this->db->cache_delete();
        $this->set_message();

        $eid = $this->input->get_post('eid');

        if (!empty($eid)) {

            $this->viewData['eid'] = $eid;

            $Row = $this->Module_Model->select($eid);
//            echo "123";exit;
            if (empty($Row)) {

                redirect(base_url() . 'adminpanel/contact_info/add?' . 'eid=' . '1');
            }

            $this->viewData['Row'] = $Row;
            $action = $this->module_url . 'update?' . $_SERVER['QUERY_STRING'];
            $this->viewData['action'] = $action;
            $this->viewData['adminContentPanel'] = $this->main_tpl;
            $this->load_view();
        } else {
            redirect(base_url() . 'adminpanel/contact_info/add?' . 'eid=' . '1');
        }
    }

    function index() {
        $this->db->cache_delete();
        $this->add();
    }

    public function update() {
        $this->form_validation->set_rules('varEmail', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('varPhone', 'Phone', 'regex_match[/^[0-9( )+]+.+$/]');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $this->Module_Model->update();
            $this->Redirect_To_Page($this->input->get_post('ehintglcode'), 'edit');
        }
    }

    public function Set_Message() {
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)) {
            if ($msg == 'add') {
                $this->viewData['messagebox'] = $this->mylibrary->Message("Congrats! The record has been successfully saved.");
            } else if ($msg == 'edit') {
                $this->viewData['messagebox'] = $this->mylibrary->Message("Congrats! The record has been successfully edited and saved.");
            }
        }
    }

    public function Redirect_To_Page($id, $msg_type) {

        $this->session->set_flashdata('msg', $msg_type);

        $btnsaveandc_x = $this->input->get_post('btnsaveandc');

        if (!empty($btnsaveandc_x)) {

            redirect(base_url() . 'adminpanel/contact_info/add?' . 'eid=' . $id);
        } else {

            $flag = $this->input->get_post('flg=Y');
            if ($flag != 'Y') {
                redirect(SITE_PATH . 'adminpanel/pages');
            } else {
                redirect(base_url() . 'adminpanel/contact_info');
            }
        }
    }

}

?>