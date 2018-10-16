<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */

class Adminpanel_trashmanager extends AdminPanel_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('trashmanager_model', 'module_model');     // MODULE MODEL
        $this->main_tpl = 'adminpanel/trashmanager_tpl';           // MODULE MAIN VIEW        
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
        $this->viewData['ajax'] = $this->input->get('ajax');
    }

    public function index() {
        $this->load_data();
        if ($this->input->get_post('ajax') == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        }
        $this->viewData['trashmanagerTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    public function load_data() {
        $query = $this->module_model->selectAll();

        $this->viewData['counttotal'] = $query->num_rows();
        $this->viewData['selectAll'] = $query->result();

        $tmpsetsortvar = trim('setsortimg' . $this->module_model->orderby);
        $tmpsetsortvar = str_replace(".", "_", $tmpsetsortvar);
        $this->viewData[$tmpsetsortvar] = $this->module_model->sortvar;
        $this->viewData['HeaderPanel'] = $this->module_model->HeaderPanel();

        $this->viewData['PagingTop'] = $this->module_model->PagingTop();
        $this->viewData['PagingBottom'] = $this->module_model->PagingBottom();

        $modulescombo = $this->module_model->getmodulesCombos();
        $this->viewData['ModulesCombo'] = $modulescombo;
    }

    public function delete() {

        $this->module_model->delete_row();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function restore() {
        $this->module_model->restore();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    function DeleteAllTrash() {
        $this->module_model->DeletAllTrashRecords();
        exit;
    }

}

?>