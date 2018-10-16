<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminpanel_careerleads extends AdminPanel_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('careerleads_model', 'module_model');      // MODULE MODEL
        $this->main_tpl = 'adminpanel/careerleads_tpl';                 // MODULE MAIN VIEW  
        $this->module_url = base_url() . 'adminpanel/careerleads/';               // MODULE URL
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
    }

    public function index() {
        $this->Load_Data();
        if ($this->input->get_post('ajax') == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        }
        $this->viewData['careerleadsTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    public function Load_Data() {
        $query = $this->module_model->SelectAll();
        $this->viewData['counttotal'] = $query->num_rows();
        $this->viewData['selectAll'] = $query->result();
        $tmpsetsortvar = trim('setsortimg' . $this->module_model->OrderBy);
        $tmpsetsortvar = str_replace(".", "_", $tmpsetsortvar);
        $this->viewData[$tmpsetsortvar] = $this->module_model->SortVar;
        $this->viewData['HeaderPanel'] = $this->module_model->HeaderPanel();
        $this->viewData['PagingTop'] = $this->module_model->PagingTop();
        $this->viewData['PagingBottom'] = $this->module_model->PagingBottom();
    }

    public function Delete() {
        $this->module_model->Delete_Row();
        $this->Load_Data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function Export() {
        $this->module_model->Export();
    }

    public function download_pdf() {
        $file = $this->input->get_post('file');
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'upimages/careerleads/' . $file);
        force_download($file, $data);
        exit;
    }

}

?>