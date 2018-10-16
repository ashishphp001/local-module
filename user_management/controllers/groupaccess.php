<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
class groupaccess extends AdminPanel_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('groupaccess_model', 'module_model');            // MODULE MODEL

        $this->main_tpl = 'adminpanel/groupaccess/group_tpl';                 // MODULE MAIN VIEW
        $this->add_tpl = 'adminpanel/groupaccess/group_add_tpl';              // MODULE ADD  VIEW
        $this->module_url = MODULE_URL . 'groupaccess/';                   // MODULE URL
  $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
        
    }

    public function index() 
    {
        
        $this->set_message();
        $eid = $this->input->get_post('fk_Userid', true);
        
        $this->load_access($eid);
        
        $assigned_access = $this->module_model->GetAssignedAcces($eid);
        $sel_innerwebaction = $assigned_access['inner_web_array'];
        $this->viewData['assigned_access'] = $assigned_access;
        $this->viewData['sel_innerwebaction'] = $sel_innerwebaction;
        
        $action = $this->module_url . 'insert';
        $this->viewData['action'] = $action;

        $this->viewData['accesscontrolTab'] = true; 
        $this->viewData['adminContentPanel'] = $this->add_tpl;
        $this->load_view();
    }

    public function insert() 
    {
        $id = $this->module_model->Insert();
        $this->redirect_to_page($id, 'add');
    }

    public function update() {

        $this->module_model->update();
        $this->redirect_to_page($this->input->get_post('ehintglcode', true), 'edit');
    }

    public function GetAssignedAcces() {
        
        $user_id = $this->input->get_post('PUserGlCode', TRUE);
        $assigned_access = $this->module_model->GetAssignedAcces($user_id);
        
        $sel_innerwebaction = $assigned_access['inner_web_array'];
        $this->viewData['assigned_access'] = $assigned_access;
        $this->viewData['sel_innerwebaction'] = $sel_innerwebaction;
        
        $this->load_access($user_id);
        $action = $this->module_url . 'insert?fk_Userid='.$user_id;
        $this->viewData['action'] = $action;
        if ($this->input->get_post('ajax') == 'Y') {
            echo $this->parser->parse($this->add_tpl, $this->viewData);
            exit;
        }
    }

    public function load_access($id) {

        $ActionArray = $this->module_model->GetAllAction();
        $this->viewData['AllAction'] = $ActionArray;

        $UserDropDown = $this->module_model->getAllUsers($id);
        $this->viewData['UserDropDown'] = $UserDropDown;
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

    public function redirect_to_page($id, $msg_type) 
    {
        $this->module_model->initialize();
        $this->module_model->Generateurl();
        
        $this->session->set_flashdata('msg', $msg_type);
        $btnsaveandc_x = $this->input->get_post('btnsaveandc', true);
        
        if (!empty($btnsaveandc_x)) 
        {
            redirect($this->module_model->PageName.'&fk_Userid='.$id);
        }
        else 
        {
            redirect(MODULE_URL."accesscontrol?".$this->module_model->Appendfk_Country_Site);
        }
    }
    
    public function add() 
    {
       
        $this->set_message();
        $eid = $this->input->get_post('eid', true);
        if (!empty($eid)) 
        {
            $this->viewData['Eid'] = $eid;
            $row = $this->module_model->select($eid);
            if (empty($row)) 
            {
                redirect($this->Module_Url.'add');
            }
            
            $this->viewData['row'] = $row;
            $action = $this->Module_Url . 'update?'.$_SERVER['QUERY_STRING'];
        }
        else 
        {
            $PageSize = $this->input->get_post('PageSize', true);
            $action = $this->Module_Url.'insert?&PageSize='.$PageSize;
        }

        $this->viewData['action'] = $action;
        $this->viewData['accesscontrolAddTab'] = true;
        $this->viewData['adminContentPanel'] = $this->add_tpl;
        $this->load_view();
    }

    /*     * **************************************************************************** */
}

?>