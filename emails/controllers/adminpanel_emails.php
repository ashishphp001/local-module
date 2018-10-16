<?php

class Adminpanel_emails extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('emails_model', 'Module_Model');           // MODULE MODEL
        $this->main_tpl = 'adminpanel/emails_tpl';                   // MODULE MAIN VIEW
        $this->module_url = MODULE_URL;                          // MODULE URL
        $this->popup_url = 'adminpanel/popup_tpl';
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
        $this->Module_Model->permissionArry = $this->permission[MODULE_PATH];
    }

    function index() {

        $this->Set_Message();
        $this->load_data();
        $this->viewData['moduleurl'] = $this->module_url;
        if ($this->input->get_post('ajax') == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        }
        $this->viewData['carrierTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    public function load_data() {

        $this->db->cache_delete();
        $Emails_Records = $this->Module_Model->Select_All_Emails_Record();
        $this->viewData['ShowAllEmailsRecords'] = $Emails_Records;
        $yesEmails_Records = $this->Module_Model->Yes_Select_All_Emails_Record();
        $this->viewData['YesShowAllEmailsRecords'] = $yesEmails_Records;
        $oldEmails_Records = $this->Module_Model->Old_Select_All_Emails_Record();
        $this->viewData['OldShowAllEmailsRecords'] = $oldEmails_Records;

        $tmpsetSortVar = trim('setsortimg' . $this->Module_Model->OrderBy);
        $tmpsetSortVar = str_replace(".", "_", $tmpsetSortVar);
        $this->viewData[$tmpsetSortVar] = $this->Module_Model->SortVar;

        $this->viewData['HeaderPanel'] = $this->Module_Model->HeaderPanel();
//         echo "132";exit;
        $this->viewData['PagingTop'] = $this->Module_Model->PagingTop();
        $this->viewData['PagingBottom'] = $this->Module_Model->PagingBottom();
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

    public function get_all_emails() {
        $user = $this->Module_Model->get_all_emails();
//        print_R($user);exit;
        header("Content-type:application/json");
        echo json_encode($user);
//        echo $data;
//       echo $user;
    }

    public function delete() {
        $this->Module_Model->delete_row();
        $this->load_data();

        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function send_emails() {
//        print_R($_POST);exit;
//        $this->form_validation->set_rules('varEmails', 'Email', 'trim|required');
//        $this->form_validation->set_rules('varSubject', 'Subject', 'trim|required');
//        $this->form_validation->set_rules('txtDescription', 'Description', 'trim|required');
//        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
//        if ($this->form_validation->run($this) == FALSE) {
//            echo "g";exit;
            $this->Module_Model->send_emails();
//          redirect(MODULE_URL);
//          echo $this->parser->parse($this->main_tpl, $this->viewData);
            $this->viewData['carrierTab'] = true;
            $this->viewData['adminContentPanel'] = $this->main_tpl;
            $Emails_Records = $this->Module_Model->Select_All_Emails_Record();
            $this->viewData['ShowAllEmailsRecords'] = $Emails_Records;
            $this->load_view();
//        } else {
//            $id = $this->Module_Model->Insert();
//        redirect(MODULE_URL);
//        }
    }

    public function reply_send_emails() {
//        print_R($_POST);exit;
//        $this->form_validation->set_rules('varEmails', 'Email', 'trim|required');
//        $this->form_validation->set_rules('varSubject', 'Subject', 'trim|required');
//        $this->form_validation->set_rules('txtDescription', 'Description', 'trim|required');
//        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
//        if ($this->form_validation->run($this) == FALSE) {
        $this->Module_Model->send_emails();
//            redirect(MODULE_URL);
//            echo $this->parser->parse($this->main_tpl, $this->viewData);
        $this->viewData['carrierTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $Emails_Records = $this->Module_Model->Select_All_Emails_Record();
        $this->viewData['ShowAllEmailsRecords'] = $Emails_Records;
        $this->load_view();
          redirect(MODULE_URL);
//        } else {
//            $id = $this->Module_Model->Insert();
//            $this->Redirect_To_Page($id, 'add');
//        }
    }

    function set_msg() {
        $msg_type = $this->input->get_post('msg', $msg_type);
        $this->session->set_flashdata('msg', $msg_type);
    }

    function get_msg() {
        $msg = $this->session->flashdata('msg');
        echo $msg;
    }

    function GetEmailContent($ID) {
        $this->viewData['RecordID'] = $ID;
        echo $this->Module_Model->getEmailDetails($ID);
        exit;
    }

}

?>