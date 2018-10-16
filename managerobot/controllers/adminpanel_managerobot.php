<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class adminpanel_managerobot extends AdminPanel_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('managerobot_model', 'module_model');        // MODULE MODEL
        $this->main_tpl = 'adminpanel/managerobot_add_tpl';                 // MODULE MAIN VIEW
        $this->add_tpl = 'adminpanel/managerobot_add_tpl';              // MODULE ADD  VIEW
        $this->module_url = MODULE_URL;    // MODULE URL
    }

    public function index() {

        $this->set_message();
        $this->load_data();

        if ($this->input->get_post('ajax') == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        }
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    public function update() {
         $this->set_message();   
        $msg = $this->module_model->save_file();
        if (!empty($_POST['btnsaveande'])) {
            redirect($this->module_url,'update');
        }
    }

    public function load_data() {
        $action = $this->module_url . 'update?&file_name=constants.php';
        $this->viewData['action'] = $action;
        $file_name= 'robots.txt';
         $fp = fopen($file_name, "r");
                    while (!feof($fp)) {
                        $file_content .= fgets($fp);
                    }
          fclose($fp);
        $this->viewData['content'] = $file_content;
    }

    public function set_message() {
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)) {
             if ($msg == 'update') {
                $this->viewData['messagebox'] = $this->mylibrary->Message("Congrats! The record has been successfully saved.");
            } else if ($msg == 'edit') {
                $this->viewData['messagebox'] = $this->mylibrary->Message("Congrats! The record has been successfully edited and saved.");
            }
        }
    }

}

?>