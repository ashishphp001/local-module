<?php

class Adminpanel_sticky_notes extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('sticky_notes_model', 'Module_Model');           // MODULE MODEL
        $this->main_tpl = 'adminpanel/sticky_notes_tpl';                   // MODULE MAIN VIEW
        $this->module_url = MODULE_URL;                          // MODULE URL
        $this->load->helper(array('form', 'url'));
        $this->viewData['sticky_notesTab'] = true;
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
        $this->Module_Model->permissionArry = $this->permission[MODULE_PATH];
    }

    public function add() {

        $this->db->cache_delete();
        $this->set_message();
        $this->viewData['eid'] = $eid;

        $Row = $this->Module_Model->select();

        $this->viewData['Row'] = $Row;
        $action = $this->module_url . 'update?' . $_SERVER['QUERY_STRING'];
        $this->viewData['action'] = $action;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    public function getdata() {

        $this->db->cache_delete();
        $this->set_message();
        $Row = $this->Module_Model->select();
        $data = [];
        foreach ($Row as $abc) {
            $phparr = json_decode($abc['labels']);
            $checklists = json_decode($abc['checklists']);
            $time = $abc['dtCreateDate'];
//            $time = (int)$abc['time'];
//              $output= json_encode($phparr);
            $abc['time'] = $time;
            $abc['labels'] = $phparr;
            $abc['checklist'] = $checklists;
            $data[] = $abc;
        }
//        echo "<pre>";
//        print_R($data);exit;
        header("Content-type:application/json");
        echo json_encode($data);
    }

    public function add_new() {
        $getpostdata = $this->input->get_post();
//         echo "<pre>";
//         print_r($getpostdata);exit;
        $this->db->cache_delete();
        $this->set_message();

//        if (!empty($getpostdata)) {
            $this->Module_Model->add();
//        }
    }

    function index() {
        $this->db->cache_delete();
        $this->add();
    }
    function remove_sticky() {
        $this->Module_Model->remove_sticky();
        return true;
    }

    public function update() {
        $this->form_validation->set_rules('varEmail', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('varPhone1', 'Phone', 'regex_match[/^[0-9( )+]+.+$/]');
        $this->form_validation->set_rules('varPhone2', 'Phone', 'regex_match[/^[0-9( )+]+.+$/]');
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

            redirect(base_url() . 'adminpanel/sticky_notes/add?' . 'eid=' . $id);
        } else {

            $flag = $this->input->get_post('flg=Y');
            if ($flag != 'Y') {
                redirect(SITE_PATH . 'adminpanel/pages');
            } else {
                redirect(base_url() . 'adminpanel/sticky_notes');
            }
        }
    }

}

?>