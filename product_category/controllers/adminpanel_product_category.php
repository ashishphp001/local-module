<?php

class Adminpanel_product_category extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_category_model', 'Module_Model');           // MODULE MODEL
        $this->main_tpl = 'adminpanel/product_category_tpl';                   // MODULE MAIN VIEW
        $this->add_tpl = 'adminpanel/product_category_add_tpl';              // MODULE ADD  VIEW
        $this->module_url = MODULE_URL;                          // MODULE URL
        $this->data = $this->Module_Model->general();
        $this->load->helper(array('form', 'url'));
        $this->viewData['product_categoryTab'] = true;
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

        $data_page_comb = $this->Module_Model->Bindpageshierarchy1('intParentCategory', '', 'add-new-user-textarea2', '1');
        $this->viewData['pagetrees'] = $data_page_comb;
        $this->viewData['product_categoryTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    function add() {
        $this->Set_Message();
        $eid = $this->input->get_post('eid');
        if (!empty($eid)) {
            $this->viewData['eid'] = $eid;
            $Row_product_category = $this->Module_Model->Select_product_category_Rows($eid);
            if (empty($Row_product_category)) {
                redirect($this->module_url . 'add?' . $this->Module_Model->Appendfk_Country_Site);
            }
            $this->viewData['Row_product_category'] = $Row_product_category;
            $edit_record = true;
//            if ($Row_product_category['chrStatus'] == 'L') {
            $edit_record = false;
            if (USERTYPE == 'N' || USERTYPE == 'C' || $this->Module_Model->permissionArry['Approve'] == 'Y') {
                $edit_record = true;
            }
//            }

            $alias_validation = true;
            $action = $this->module_url . 'update?' . $_SERVER['QUERY_STRING'];


            $ProductCatList = $this->Module_Model->getProductCatList($Row_product_category['intParentCategory'], $eid);
            $this->viewData['ProductCatList'] = $ProductCatList;
        } else {
            $edit_record = true;
            $alias_validation = true;
            $PageSize = $this->input->get_post('PageSize', true);
            $action = $this->module_url . 'insert?&PageSize=' . $PageSize;

            $ProductCatList = $this->Module_Model->getProductCatList();
            $this->viewData['ProductCatList'] = $ProductCatList;
        }

        $this->viewData['edit_record'] = $edit_record;
        $this->viewData['alias_validation'] = $alias_validation;
        $this->viewData['action'] = $action;
        $data_page_comb = $this->Module_Model->Bindpageshierarchy('intParentCategory', (!empty($Row_product_category['intParentCategory']) ? $Row_product_category['intParentCategory'] : ''), 'add-new-user-textarea2', '1');
        $this->viewData['pagetree'] = $data_page_comb;


        $this->viewData['product_categoryAddTab'] = true;
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

    public function approve_product_category() {
        $this->Module_Model->approve_product_category();
        echo "Y";
    }
    
    public function Insert() {
        $this->form_validation->set_rules('varName', 'Title', 'trim|required');
        $this->form_validation->set_rules('varAlias', 'Alias', 'trim|required');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');

        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $id = $this->Module_Model->Insert();
            $this->Redirect_To_Page($id, 'add');
        }
    }

    public function update() {
        $this->form_validation->set_rules('varName', 'Title', 'trim|required');
        $this->form_validation->set_rules('varAlias', 'Alias', 'trim|required');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');
        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {

            $this->Module_Model->update();
            $this->Redirect_To_Page($this->input->get_post('ehintglcode'), 'edit');
        }
    }

    function IsSameAlias() {

        $this->mylibrary->IsSameAlias();
    }

    function GetAlias() {
        $this->mylibrary->GetAlias();
    }

    function getSubcateHTML() {
        echo $this->Module_Model->getSubcateHTML();
    }

    public function load_data() {
        $product_category_Records = $this->Module_Model->Select_All_product_category_Record();
//        echo $product_category_Records;exit;
        $this->viewData['ShowAllproduct_categoryRecords'] = $product_category_Records;

        $tmpsetSortVar = trim('setsortimg' . $this->Module_Model->OrderBy);
        $tmpsetSortVar = str_replace(".", "_", $tmpsetSortVar);
        $this->viewData[$tmpsetSortVar] = $this->Module_Model->SortVar;

        $this->viewData['HeaderPanel'] = $this->Module_Model->HeaderPanel();
        $this->viewData['PagingTop'] = $this->Module_Model->PagingTop();
        $this->viewData['PagingBottom'] = $this->Module_Model->PagingBottom();
    }

    public function Export() {
        $this->Module_Model->Export();
    }

    public function excel_upload() {
        $data = "";
//        $insert = $this->Module_Model->UploadProductImage();
        $insert = $this->Module_Model->UploadMeta_excel();
        if (!empty($insert)) {
            header("Content-Type: application/vnd.ms-excel");
            echo 'ID' . "\t" . 'Category Name' . "\t" . 'Issue' . "\t" . 'Solution' . "\n";
            foreach ($insert as $row) {
                echo $row['id'] . "\t" . $row['name'] . "\t" . $row['issue'] . "\t" . $row['solution'] . "\n";
            }
        } else {
            echo "Success";
        }
    }
//    public function excel_upload() {
//        $data = "";
//        $insert = $this->Module_Model->Upload_excel();
//        if (!empty($insert)) {
//            header("Content-Type: application/vnd.ms-excel");
//            echo 'ID' . "\t" . 'Category Name' . "\t" . 'Issue' . "\t" . 'Solution' . "\n";
//            foreach ($insert as $row) {
//                echo $row['id'] . "\t" . $row['name'] . "\t" . $row['issue'] . "\t" . $row['solution'] . "\n";
//            }
//        } else {
//            echo "Success";
//        }
//    }

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
//        echo "<pre>";
//        print_R($_REQUEST);exit;
        $this->Module_Model->updatedisplayorder();
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . "product_category", " AND intParentCategory='" . $this->input->post('intParentCategory') . "'");
        $this->load_data();

        echo $this->parser->parse($this->main_tpl, $this->viewData);
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
        echo $this->Module_Model->generate_seocontent_product_category(true);
        exit;
    }

    function set_msg() {
        $msg_type = $this->input->get_post('msg', $msg_type);
        $this->session->set_flashdata('msg', $msg_type);
        echo '<a href="' . ADMINPANEL_URL . 'product_category/get_msg">click</a>';
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

        curl_close($ch);
        die;
    }

    public function sharedata() {

        if ($this->input->get_post('h_save') == 'T') {
            echo $this->Module_Model->shareonfacebook();
            exit;
        } else {
            $Row_Pages = $this->Module_Model->Select_Share_Page_Rows($_GET['e_id']);
            $this->viewData['rec'] = $Row_Pages;
            echo $this->parser->parse($this->share_tpl, $this->viewData);
            exit;
        }
    }

    public function get_publish() {
        echo $this->Module_Model->get_publish_value($this->input->get_post('pub_id'));
        exit;
    }

}

?>