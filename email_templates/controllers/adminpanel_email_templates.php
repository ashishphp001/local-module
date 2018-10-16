<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminpanel_email_templates extends AdminPanel_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('email_templates_model', 'module_model');        // MODULE MODEL

        $this->main_tpl = 'adminpanel/email_templates_tpl';                 // MODULE MAIN VIEW
        $this->add_tpl = 'adminpanel/email_templates_add_tpl';              // MODULE ADD  VIEW
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

    public function add() {

        $this->set_message();
        $eid = $this->input->get_post('eid');
        if (!empty($eid)) {
            $FileName=$this->module_model->getTemplateName($eid);
            $action = $this->module_url . 'update';
            $file_content = '';
            if ($this->input->get_post('type') == "PP") {
                if (file_exists(ADMINPANEL_MAIL_TEMPLATES_PATH . $FileName['varFileName'])) {
                    $fp = fopen(ADMINPANEL_MAIL_TEMPLATES_PATH . $FileName['varFileName'], "r");
                    while (!feof($fp)) {
                        $file_content .= fgets($fp,4096);
                    }
                    fclose($fp);
                }
              $this->viewData['type'] = 'adminpanel';
            } else if ($this->input->get_post('type') == "FF") {
                if (file_exists(FRONT_GLOBAL_MAILTEMPLATES_PATH . $FileName['varFileName'])) {
                    $fp = fopen(FRONT_GLOBAL_MAILTEMPLATES_PATH . $FileName['varFileName'], "r");
                    $this->viewData['type'] = 'front';
                    while (!feof($fp)) {
                        $file_content .= fgets($fp,4096);
                    }
                    fclose($fp);
                }
            }
            $file_content = str_replace("@LOGO_PATH", FRONT_MEDIA_URL.'email-template/images/logo.png', $file_content);
            $this->viewData['type'] = $this->input->get_post('type');
            $this->viewData['file_name'] = $FileName['varFileName'];
            $this->viewData['name'] = $FileName['varFileName'];
            $this->viewData['subject'] = $FileName['varSubject'];
            $this->viewData['publish'] = $FileName['chrPublish'];
            $this->viewData['eid'] = $eid;
            $this->viewData['content'] = $file_content;
            $this->viewData['action'] = $action;
        } else {
            redirect($this->module_url);
        }
        $this->viewData['adminContentPanel'] = $this->add_tpl;
        $this->load_view();
    }

    public function update() {

        //    echo "<pre>";print_r($_POST);die;

        $msg = $this->module_model->save_file($this->mylibrary->rem_special_chars($this->input->post('var_description')));

        $this->session->set_flashdata('msg', $msg);
        $btnsaveandc_x = $this->input->get_post('btnsaveandc_x');

        if (!empty($btnsaveandc_x)) {
            redirect($this->module_url . '/add?type=' . $this->input->post('type') . '&eid=' . $this->input->post('file_name'));
        } else {
            redirect($this->module_url);
        }
    }

    /*******************************************************************************/

    public function load_data() {
        $Front_Template=$this->module_model->getAllTemplate('F','FF');
        $this->viewData['frontMailTemaplatesArry'] = $Front_Template;  
        
        $Adminpanel_Template=$this->module_model->getAllTemplate('P','PP');
        $this->viewData['MailTemaplatesArry'] = $Adminpanel_Template;
    }

    public function set_message() {

        $msg = $this->session->flashdata('msg');

        if (!empty($msg)) {
            $this->viewData['messagebox'] = $this->mylibrary->message($msg);
        }
    }

    /*     * *********************************************************************** */
}

?>