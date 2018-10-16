<?php

class Adminpanel_pages extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('pages_model', 'Module_Model');           // MODULE MODEL
        $this->main_tpl = 'adminpanel/page_tpl';                   // MODULE MAIN VIEW
        $this->add_tpl = 'adminpanel/pages_add_tpl';              // MODULE ADD  VIEW
        
        $this->LoginPopUp = 'adminpanel/templates/loginpopup_tpl';
        $this->module_url = MODULE_URL;                          // MODULE URL

        $this->data = $this->Module_Model->general();
        
        $this->load->helper(array('form', 'url'));
        $this->viewData['pagesTab'] = true;
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
        $this->Module_Model->permissionArry = $this->permission[MODULE_PATH];
       
    }

    function index() 
    {
        $this->Set_Message();
        $this->load_data();
        $this->db->cache_delete();
        $this->viewData['moduleurl'] = $this->module_url;
        if ($this->input->get_post('ajax') == 'Y') 
        {
            echo $this->parser->parse($this->main_tpl, $this->viewData); exit;
        }
        $this->viewData['pagesTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    function add() {
        $this->Set_Message();
        $eid = $this->input->get_post('eid');
        if (!empty($eid)) {
            $this->viewData['eid'] = $eid;
            $Row_Pages = $this->Module_Model->Select_Pages_Rows($eid);
            $CountChild = $this->Module_Model->Get_Child($eid);
            if (empty($Row_Pages)) {
                redirect($this->module_url . 'add');
            }
            $this->viewData['Row_Pages'] = $Row_Pages;
            $this->viewData['CountChild'] = $CountChild;

            $action = $this->module_url . 'update?' . $_SERVER['QUERY_STRING'];
            $data_module_comb = $this->Module_Model->GetEnableModules('fk_ModuleGlCode', $Row_Pages['fk_ModuleGlCode']);
        } else {

            $PageSize = $this->input->get_post('PageSize', true);
            $action = $this->module_url . 'insert?&PageSize=' . $PageSize;
            $data_module_comb = $this->Module_Model->GetEnableModules('fk_ModuleGlCode', '');
        }
        $this->viewData['action'] = $action;
        $data_page_comb = $this->Module_Model->Bindpageshierarchy('fk_ParentPageGlCode', (!empty($Row_Pages['fk_ParentPageGlCode']) ? $Row_Pages['fk_ParentPageGlCode'] : ''), 'add-new-user-textarea2', '1');
        $this->viewData['pagetree'] = $data_page_comb;
        $this->viewData['module_combo'] = $data_module_comb;
        $this->viewData['pagesAddTab'] = true;
        $this->viewData['alias_validation'] = true;
        $this->viewData['adminContentPanel'] = $this->add_tpl;
        $this->load_view();
    }

    function check_unique_alias() {
        $var_alias = $this->input->get_post('var_alias', true);
        $alias_id = $this->input->get_post('alias_id', true);
        if (strlen($var_alias) > 1) {
            $check_alias = $this->mylibrary->check_unique_alias($var_alias, $alias_id);
            if ($check_alias > 0) {
                $this->form_validation->Set_Message('check_unique_alias', COMMON_ALIAS_EXISTS_MSG);
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->Set_Message('check_unique_alias', 'Alias must be atleast 2 characters in length.');
            return FALSE;
        }
    }

    public function Insert() {
//        print_R($this->input->post());exit;
        $this->form_validation->set_rules('fk_ParentPageGlCode', 'Parent Page', 'required');
        $this->form_validation->set_rules('varTitle', 'Title', 'trim|required');
        $this->form_validation->set_rules('varAlias', 'Alias', 'trim|required');
        $this->form_validation->set_rules('intDisplayOrder', 'display order', 'trim|required|greater_than[0]');
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
          $this->form_validation->set_rules('varAlias', 'Alias', 'trim|required');
//            if ($this->input->post('varAlias') != $this->input->get_post('Hid_varAlias')) {
//                $Is_Unique = '|is_unique[Alias.varAlias]';
//            } else {
//                $Is_Unique = '';
//            }
//            $this->form_validation->set_rules('varAlias', 'Alias', 'trim|required'.$Is_Unique);

        if(RECORD_ID != 1){
        $this->form_validation->set_rules('intDisplayOrder', 'display order', 'trim|required|greater_than[0]');
        }
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
// echo "123";exit;
        if ($this->form_validation->run($this) == FALSE) {
           
            $this->add();
        } else {
//            echo "123";exit;
            $this->Module_Model->update();

            $this->Redirect_To_Page($this->input->get_post('ehintglcode'), 'edit');
        }
    }

    public function load_data() {
        $Pages_Records = $this->Module_Model->Select_All_pages_Record();
        $this->viewData['ShowAllPagesRecords'] = $Pages_Records;

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

    public function OrderUpdate() {
      
        $this->Module_Model->updatedisplayorder();
//          echo "hi";exit;
         $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . "pages"," AND fk_ParentPageGlCode='" . $this->input->post('fk_ParentPageGlCode') . "'");
        $this->load_data();

        echo $this->parser->parse($this->main_tpl, $this->viewData);
        exit;
    }

    public function delete() {
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

    function generate_seocontent() {
        echo $this->Module_Model->generate_seocontent_pages(true);
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

    function login_pop_detail() {
        echo $this->Module_Model->Validate();
        exit;
    }

    public function updatePublish() {
        echo $this->Module_Model->updatedisplay();
        exit;
    }

}

?>