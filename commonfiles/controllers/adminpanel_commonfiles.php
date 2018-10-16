<?php

class Adminpanel_commonfiles extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('commonfiles_model', 'Module_Model');
        $this->main_tpl = 'adminpanel/commonfiles_tpl';
        $this->add_tpl = 'adminpanel/commonfiles_add_tpl';
        $this->module_url = MODULE_URL;
        $this->data = $this->Module_Model->general();
        $this->load->helper(array('form', 'url'));
        $this->viewData['commonfilesTab'] = true;
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
        $this->viewData['commonfilesTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    function add() {


        $this->Set_Message();
        $eid = $this->input->get_post('eid');
        if (!empty($eid)) {
            $this->viewData['eid'] = $eid;
            $Row_commonfiles = $this->Module_Model->Select_commonfiles_Rows($eid);
            if (empty($Row_commonfiles)) {
                redirect($this->module_url . 'add?' . $this->Module_Model->Appendfk_Country_Site);
            }
            $this->viewData['Row_commonfiles'] = $Row_commonfiles;
            $edit_record = true;
            if ($Row_commonfiles['chrStatus'] == 'L') {
                $edit_record = false;
                if (USERTYPE == 'N' || USERTYPE == 'C' || $this->Module_Model->permissionArry['Approve'] == 'Y') {
                    $edit_record = true;
                }
            }
            $alias_validation = true;
            $action = $this->module_url . 'update?' . $_SERVER['QUERY_STRING'];
        } else {
            $edit_record = true;
            $alias_validation = true;
            $PageSize = $this->input->get_post('PageSize', true);
            $action = $this->module_url . 'insert?&PageSize=' . $PageSize;
        }
        if ($this->input->get_post('ajax') == 'Y') {

            $this->viewData['hid'] = $this->input->get_post('id');
            $this->viewData['action'] = 'adminpanel/commonfiles/Insert_commonfiles';
            echo $this->parser->parse('adminpanel/popup_commonfiles_add_tpl', $this->viewData);
            exit;
        } else {
            $this->viewData['edit_record'] = $edit_record;
            $this->viewData['alias_validation'] = $alias_validation;
            $this->viewData['action'] = $action;
            $this->viewData['commonfilesAddTab'] = true;
            $this->viewData['adminContentPanel'] = $this->add_tpl;
            $this->load_view();
        }
    }

    public function Insert() {
        $this->form_validation->set_rules('varTitle', 'Title', 'trim|required');
//        $this->form_validation->set_rules('varShortDesc', 'Description', 'trim|required');
        $this->form_validation->set_rules('intDisplayOrder', 'display order', 'trim|required|greater_than[0]');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $id = $this->Module_Model->Insert($Files_Name);
            $this->Redirect_To_Page($id, 'add');
        }
    }

    public function update() {
        $this->form_validation->set_rules('varTitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('intDisplayOrder', 'display order', 'trim|required|greater_than[0]');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');

        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            if (isset($_FILES)) {
                $this->load->library('upload');
                $config['upload_path'] = 'upimages/commonfiles/';
                $config['allowed_types'] = 'doc|docx|pdf|rar|xls|xlsx|ppt|pptx|zip';
                $config['max_size'] = '1000000';
                $this->upload->initialize($config);

                $imageName = '';
                foreach ($_FILES as $field => $file) {
                    $imageName = '';
                    if (!empty($file['name'])) {
                        $imageName = str_replace(' ', '_', time() . $file['name']);
                        $imageName = preg_replace('/[^A-Za-z0-9\-.\']/', '', $imageName);
                        $_FILES[$field]['name'] = $imageName;
                        if ($file['error'] == 0) {
                            if (!$this->upload->do_upload($field)) {
                                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                                echo $this->upload->display_errors();
//                                exit;
                            }
                        }
                    } else {
                        $imageName = $this->input->get_post('Hid_' . $field);
                    }
                    $Images_Name[$field] = $imageName;
                }
            }
            $this->Module_Model->update($Images_Name);
            $this->Redirect_To_Page($this->input->get_post('ehintglcode'), 'edit');
        }
    }

    public function load_data() {
        $commonfiles_Records = $this->Module_Model->Select_All_commonfiles_Record();
        $this->viewData['ShowAllcommonfilesRecords'] = $commonfiles_Records;
        $tmpsetSortVar = trim('setsortimg' . $this->Module_Model->OrderBy);
        $tmpsetSortVar = str_replace(".", "_", $tmpsetSortVar);
        $this->viewData[$tmpsetSortVar] = $this->Module_Model->SortVar;
        $this->viewData['HeaderPanel'] = $this->Module_Model->HeaderPanel();
        $this->viewData['PagingTop'] = $this->Module_Model->PagingTop();
        $this->viewData['PagingBottom'] = $this->Module_Model->PagingBottom();
    }

    public function Set_Message() {
        $msg = $this->session->flashdata('msg');
        if (!empty($msg)) {
            if ($msg == 'add') {
                $this->viewData['messagebox'] = $this->mylibrary->Message("The record has been successfully saved.");
            } else if ($msg == 'edit') {
                $this->viewData['messagebox'] = $this->mylibrary->Message("The record has been successfully edited and saved.");
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

    public function orderupdate() {
        $this->Module_Model->updatedisplayorder();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function Insert_commonfiles() {
        $hid = $this->input->get_post('hid');
        $this->form_validation->set_rules('varTitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('varShortDesc', 'Description', 'trim|required');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $id = $this->Module_Model->Insert_commonfiles();
            $cmb = $this->Module_Model->add_commonfiles($id, $hid);
        }
        echo $cmb;
        exit;
    }

    function addAddons() {
        $this->add();
        exit;
    }

    public function updatepublish() {
        if ($this->input->get_post('tablename', true) == 'rf_Pages') {
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

    public function delete() {
        
//            if(!is_numeric($_REQUEST['dids']) || $_REQUEST['dids'] == ''){
//          redirect($this->module_url);  
//        }
        $this->Module_Model->delete_row();
        $this->load_data();
        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    
        
    }

    function cmsplugin() {
        $query = $this->Module_Model->selectAll_commonfiles();
        $this->viewData['counttotal'] = $query->num_rows();
        $this->viewData['selectAll'] = $query->result();
        echo $this->parser->parse('adminpanel/cmsplugin_tpl', $this->viewData);
        exit;
    }

    function updateread() {
        echo $this->Module_Model->updateread();
    }

    function set_msg() {
        $msg_type = $this->input->get_post('msg', $msg_type);
        $this->session->set_flashdata('msg', $msg_type);
        echo '<a href="' . ADMINPANEL_URL . 'commonfiles/get_msg">click</a>';
    }

    function get_msg() {
        $msg = $this->session->flashdata('msg');
        echo $msg;
    }

    function GetRecordHistory() {
        $intglcode = $this->input->get_post('intglcode');
        echo $this->Module_Model->GetRecordHistory($intglcode);
        exit;
    }

    function CheckRemoteFile() {
        $Uri = $this->input->get_post('Uri');
        $ch = curl_init($Uri);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        echo $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $retcode >= 400 -> not found, $retcode = 200, found.
        curl_close($ch);
        die;
    }

    public function download() {
        $file = $this->input->get_post('file');
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'upimages/commonfiles/' . $file);
        force_download($file, $data);
        exit;
    }

}

?>