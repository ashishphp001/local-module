<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class modcontrol extends AdminPanel_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('modcontrol_model', 'module_model');            // MODULE MODEL

        $this->main_tpl = 'adminpanel/modcontrol/modcontrol_add_tpl';                   // MODULE ADD  VIEW
        $this->module_url = MODULE_URL.'modcontrol/';                   // MODULE URL
    }

    
    public function index() {

        $this->load_access();
        
        $this->viewData['action'] = $this->module_url.'updateAssign';
       
        $this->viewData['modcontrolTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    public function updateAssign() {
        $this->module_model->UpdateAssignAction();
        redirect($this->module_url);
    }
 

    public function load_access() {

        $query = $this->module_model->getAllAction();
        $this->viewData['AllAction'] = $query;

        $query = $this->module_model->getallModule();
        $this->viewData['AllModule'] = $query;

        $query = $this->module_model->selectAllassignAction();
        $this->viewData['actionmodule'] = $query;

        $this->viewData['HeaderPanel'] = $this->module_model->HeaderPanel();
    }


    /*     * **************************************************************************** */
}

?>