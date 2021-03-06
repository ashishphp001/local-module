<?php

class Adminpanel_shipping_type extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('shipping_type_model', 'Module_Model');           // MODULE MODEL
        $this->main_tpl = 'adminpanel/shipping_type_tpl';                   // MODULE MAIN VIEW
        $this->share_tpl = 'adminpanel/shareoption_tpl';
        $this->add_tpl = 'adminpanel/shipping_type_add_tpl';              // MODULE ADD  VIEW
        $this->module_url = base_url() . 'adminpanel/shipping_type/';                           // MODULE URL
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
        $this->db->cache_delete();
      
        $Pages_Records = $this->Module_Model->SelectAll();
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;
//      echo "here";exit;
        $tmpsetSortVar = trim('setsortimg' . $this->Module_Model->OrderBy);
        $tmpsetSortVar = str_replace(".", "_", $tmpsetSortVar);
        $this->viewData[$tmpsetSortVar] = $this->Module_Model->SortVar;

        $this->viewData['HeaderPanel'] = $this->Module_Model->HeaderPanel();
        $this->viewData['PagingTop'] = $this->Module_Model->PagingTop();
        $this->viewData['PagingBottom'] = $this->Module_Model->PagingBottom();
    }

    function add() {
        $this->Set_Message();
        $eid = $this->input->get_post('eid');
        if (!empty($eid)) {
            $this->viewData['eid'] = $eid;
            $Row = $this->Module_Model->Select_Rows($eid);
            if (empty($Row)) {
                redirect($this->module_url . 'add');
            }
            $this->viewData['Row'] = $Row;
            $action = $this->module_url . 'update?' . $_SERVER['QUERY_STRING'];
        } else {
            $PageSize = $this->input->get_post('PageSize', true);
            $action = $this->module_url . 'insert?&PageSize=' . $PageSize . $cat;
        }
        $this->viewData['action'] = $action;
        $this->viewData['pagesAddTab'] = true;
        $this->viewData['adminContentPanel'] = $this->add_tpl;
        $this->load_view();
    }

    public function Insert() {
        $this->form_validation->set_rules('varName', 'Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $id = $this->Module_Model->Insert();
            $this->Redirect_To_Page($id, 'add');
        }
    }

    public function update() {
        $this->form_validation->set_rules('varName', 'Name', 'trim|required');
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
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function OrderUpdate() {
        $this->Module_Model->updatedisplayorder();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function updatepublish() {
        if ($this->input->get_post('tablename', true) == DB_PREFIX . 'shipping_type') {
            $this->UpdatePublishPages();
        } else {
            echo $this->Module_Model->updatedisplay();
            exit;
        }
    }

    public function UpdatePublishPages() {
        $this->Module_Model->updatedisplay();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }
    
     public function sharedata() {

        if ($this->input->get_post('h_save') == 'T') {
            echo $this->Module_Model->shareonfacebook();
            exit;
        } else {
//            echo $_GET['e_id'];exit;
            $Row_Pages = $this->Module_Model->Select_Share_Page_Rows($_GET['e_id']);
            $this->viewData['rec'] = $Row_Pages;
//            print_r($this->viewData['rec']);exit;
            echo $this->parser->parse($this->share_tpl, $this->viewData);
            exit;
        }
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

    public function download() {
        $id = $this->input->get_post('id');
        if ($id != '') {
            $this->Module_Model->NoOfDownload($id);
            ;
        }
        $file = $this->input->get_post('file');
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'upimages/shipping_type/' . $file);
        force_download($file, $data);
        exit;
    }

}

?>