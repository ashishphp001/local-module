<?php

class Adminpanel_banner extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('banner_model', 'Module_Model');           // MODULE MODEL
        $this->main_tpl = 'adminpanel/banner_tpl';                   // MODULE MAIN VIEW
        $this->add_tpl = 'adminpanel/banner_add_tpl';              // MODULE ADD  VIEW
        $this->module_url = MODULE_URL;                          // MODULE URL
        $this->load->helper(array('form', 'url'));
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
        $this->viewData['pagesTab'] = true;

        $this->viewData['adminContentPanel'] = $this->main_tpl;

        $this->load_view();
    }

    public function load_data() {

        $Pages_Records = $this->Module_Model->SelectAll();

        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;

        $tmpsetSortVar = trim('setsortimg' . $this->Module_Model->OrderBy);
        $tmpsetSortVar = str_replace(".", "_", $tmpsetSortVar);
        $this->viewData[$tmpsetSortVar] = $this->Module_Model->SortVar;
//echo "hello";exit;
        $this->viewData['HeaderPanel'] = $this->Module_Model->HeaderPanel();
        $this->viewData['PagingTop'] = $this->Module_Model->PagingTop();
        $this->viewData['PagingBottom'] = $this->Module_Model->PagingBottom();
    }

    function add() {
//        echo "123";exit;
        $this->Set_Message();
        $eid = $this->input->get_post('eid');

        if (!empty($eid)) {
            $this->viewData['eid'] = $eid;
//            echo "12";
            $Row = $this->Module_Model->Select_Rows($eid);
//            print_r($Row);
            if (empty($Row)) {
                redirect($this->module_url . 'add');
            }
            $this->viewData['Row'] = $Row;
            $action = $this->module_url . 'update?' . $_SERVER['QUERY_STRING'];
        } else {
            $PageSize = $this->input->get_post('PageSize', true);
            $action = $this->module_url . 'insert?&PageSize=' . $PageSize;
        }
        $this->viewData['action'] = $action;
        $this->viewData['pagesAddTab'] = true;
        $this->viewData['adminContentPanel'] = $this->add_tpl;
        $this->load_view();
    }

    public function Insert() {
        $this->form_validation->set_rules('varTitle', 'Title', 'trim|required');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $id = $this->Module_Model->Insert();
            $this->Redirect_To_Page($id, 'add');
        }
    }

    public function update() {
        $this->form_validation->set_rules('varTitle', 'Title', 'trim|required');
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
        $this->Module_Model->initialize();
        $this->Module_Model->Generateurl();

        $this->session->set_flashdata('msg', $msg_type);
        $btnsaveandc_x = $this->input->get_post('btnsaveandc');

        if (!empty($btnsaveandc_x)) {
            redirect($this->Module_Model->AddPageName . '&eid=' . $id);
        } else {
            redirect($this->Module_Model->UrlWithPara);
        }
    }

    public function delete() {
        $this->Module_Model->delete_row();
        $Chr_Banner_Type = $this->input->get_post('Fk_AllCatergory');
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . "banner", " AND Chr_Banner_Type ='" . $Chr_Banner_Type . "'");
        $this->load_data();

        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    function set_msg() {
        $msg_type = $this->input->get_post('msg', $msg_type);
        $this->session->set_flashdata('msg', $msg_type);
        echo '<a href="' . ADMINPANEL_URL . 'pages/get_msg">click</a>';
    }

    function get_msg() {
        $msg = $this->session->flashdata('msg');
        echo $msg;
    }

    function CheckRemoteFile() {
        $Uri = $this->input->get_post('Uri');
        $ch = curl_init($Uri);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        echo $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        die;
    }

    public function orderupdate() {
        $this->Module_Model->updatedisplayorder();
        $this->load_data();

        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

}

?>