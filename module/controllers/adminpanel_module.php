<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminpanel_module extends AdminPanel_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('module_model', 'module_model');
        
        $this->main_tpl = 'adminpanel/module_tpl';
        $this->add_tpl = 'adminpanel/module_add_tpl';
        $this->module_url = SITE_PATH . 'adminpanel/module/';
    }

    public function index() 
    {
        $this->db->cache_delete();
        $this->set_message();
        $this->load_data();
        
        if ($this->input->get_post('ajax') == 'Y') 
        {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        }
        $this->viewData['module'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    public function load_data() 
    {
         $this->viewData['moduleurl'] = $this->module_model->module_url;
        $Query = $this->module_model->GetAllModules();
        
        $this->viewData['CountAllModules'] = $Query->num_rows();
        $this->viewData['ModuleArray'] = $Query->Result();
        
        $tmpsetSortVar = trim('setsortimg' . $this->module_model->OrderBy);
        $tmpsetSortVar = str_replace(".", "_", $tmpsetSortVar);
        
        $this->viewData[$tmpsetSortVar] = $this->module_model->SortVar;
        
        $this->viewData['HeaderPanel'] = $this->module_model->HeaderPanel();
        $this->viewData['PagingTop'] = $this->module_model->PagingTop();
        $this->viewData['PagingBottom'] = $this->module_model->PagingBottom();
    }

    public function add() 
    {
        $this->set_message();
        
        $eid = $this->input->get_post('eid');

        if (!empty($eid)) 
        {
            $this->viewData['eid'] = $eid;
            $Row = $this->module_model->SelectRow($eid);
            if (empty($Row)) 
            {
                redirect($this->module_url . 'add'. $this->module_model->Appendfk_Country_Site);
            }
            $this->viewData['Row'] = $Row;
            $action = $this->module_url . 'Update?' . $_SERVER['QUERY_STRING'];
        }
        else 
        {
            $action = $this->module_url . 'insert?&PageSize=' . $PageSize . $this->module_model->Appendfk_Country_Site;
        }
        $this->viewData['action'] = $action;
        
        $SubMenuType = $this->module_model->SubMenuCmb($Row['fk_ModuleGlCode']);
        $this->viewData['SubMenuType'] = $SubMenuType;
        
        $this->viewData['moduleADD'] = true;
        $this->viewData['adminContentPanel'] = $this->add_tpl;
        $this->load_view();
    }

    public function Insert() 
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('varModuleName', 'module title', 'trim|required');
        $this->form_validation->set_rules('varTitle', 'module name', 'trim|required');
        $this->form_validation->set_rules('varHeaderText', 'header text name', 'trim|required');
        $this->form_validation->set_rules('intDisplayOrder', 'display order', 'trim|required|greater_than[0]');

        if ($this->form_validation->run($this) == FALSE) 
        {
            $this->add();
        }
        else 
        {
            $id = $this->module_model->Insert();
            $this->redirect_to_page($id, 'add');
        }
    }

    public function Update() {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('varModuleName', 'module title', 'trim|required');
        $this->form_validation->set_rules('varTitle', 'module name', 'trim|required');
        $this->form_validation->set_rules('varHeaderText', 'header text name', 'trim|required');
        $this->form_validation->set_rules('intDisplayOrder', 'display order', 'trim|required|greater_than[0]');

        if ($this->form_validation->run($this) == FALSE) {

            $this->add();
        } else {

            $this->module_model->Update();
            $this->redirect_to_page($this->input->get_post('ehintglcode'), 'edit');
        }
    }

    public function set_message() {

        $msg = $this->session->flashdata('msg');

        if (!empty($msg)) {
            if ($msg == 'add') {
                $this->viewData['messagebox'] = $this->mylibrary->message("Congrats! The record has been successfully saved.");
            } else if ($msg == 'edit') {
                $this->viewData['messagebox'] = $this->mylibrary->message("Congrats! The record has been successfully edited and saved.");
            }
        }
    }

    public function redirect_to_page($id, $msg_type) {

        $this->module_model->initialize();
        $this->module_model->Generateurl();

        $this->session->set_flashdata('msg', $msg_type);
        $btnsaveandc = $this->input->get_post('btnsaveandc');

        if (!empty($btnsaveandc)) {
            redirect($this->module_model->AddPageName . 'eid=' . $id);
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

    public function Delete() {

        $this->module_model->Delete_Row();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function Check_module_name() { // check if email address all ready exits or not.
        echo $this->module_model->Check_module_name($this->input->get_post('Var_Title'));
        exit;
    }

    public function Check_directory_name() { // check if email address all ready exits or not.
        echo $this->module_model->Check_moduledirectory_name($this->input->get_post('foldername'));
        exit;
    }

    public function UpdatePublish() {

        $this->module_model->updatedisplay();
    }

}

?>