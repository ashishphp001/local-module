<?php

class Adminpanel_product extends AdminPanel_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model', 'Module_Model');           // MODULE MODEL
        $this->main_tpl = 'adminpanel/product_tpl';                   // MODULE MAIN VIEW
        $this->add_tpl = 'adminpanel/product_add_tpl';              // MODULE ADD  VIEW
        $this->module_url = MODULE_URL;                          // MODULE URL
        $this->data = $this->Module_Model->general();
        $this->load->helper(array('form', 'url'));
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
        $this->Module_Model->permissionArry = $this->permission[MODULE_PATH];
        $this->main_photos_tpl = 'adminpanel/photos_listing_tpl';
    }

    function upload() {
        if ($_FILES['varImages'] != '') {
            if ($this->Module_Model->insert_photo()) {
                $fk_aid = $this->input->get_post('fkProduct');
                redirect('adminpanel/product/add?fkProduct=' . $fk_aid);
            }
        }
    }

    public function excel_upload() {
        $data = "";
        $insert = $this->Module_Model->Upload_excel();
        if (!empty($insert)) {
            header("Content-Type: application/vnd.ms-excel");
            echo 'ID' . "\t" . 'Product Name' . "\t" . 'Category Name' . "\t" . 'Issue' . "\t" . 'Solution' . "\n";
            foreach ($insert as $row) {
                echo $row['id'] . "\t" . $row['name'] . "\t" . $row['cat_name'] . "\t" . $row['issue'] . "\t" . $row['solution'] . "\n";
            }
        } else {
            echo "Success";
        }
    }

    function delete_photo($photoID, $albumID) {
        $this->Module_Model->delete_photo($photoID);
        echo "1";
        exit;
    }

    public function select_all_photos($fkProduct) {
        if ($fkProduct == '') {
            $fkProduct = "0";
        }
        $photos = $this->Module_Model->getPhotosByAlbum($fkProduct);
        $this->viewData['photosArr'] = $photos;
        $this->viewData['fkProduct'] = $fkProduct;
        echo $this->parser->parse($this->main_photos_tpl, $this->viewData);
        exit;
    }

    function index() {
        $this->Set_Message();
        $this->load_data();
        $this->viewData['moduleurl'] = $this->module_url;
        if ($this->input->get_post('ajax') == 'Y') {
            echo $this->parser->parse($this->main_tpl, $this->viewData);
            exit;
        }
        $this->viewData['productTab'] = true;
        $this->viewData['adminContentPanel'] = $this->main_tpl;
        $this->load_view();
    }

    function add() {

        $this->Module_Model->delete_images_onload();

        $this->Set_Message();
        $eid = $this->input->get_post('eid');
        if (!empty($eid)) {
            $this->viewData['eid'] = $eid;
            $Row_product = $this->Module_Model->Select_product_Rows($eid);
            if (empty($Row_product)) {
                redirect($this->module_url . 'add?' . $this->Module_Model->Appendfk_Country_Site);
            }
            $this->viewData['Row_product'] = $Row_product;
            $edit_record = true;
//            if ($Row_product['chrStatus'] == 'L') {
            $edit_record = false;
            if (USERTYPE == 'N' || USERTYPE == 'C' || $this->Module_Model->permissionArry['Approve'] == 'Y') {
                $edit_record = true;
            }
//            }

            $alias_validation = true;
            $action = $this->module_url . 'update?' . $_SERVER['QUERY_STRING'];


            $ProductCatList = $this->Module_Model->getProductCatList($Row_product['intParentCategory'], $eid);
            $this->viewData['ProductCatList'] = $ProductCatList;
            $UnitList = $this->Module_Model->getUnitList($Row_product['intUnit']);
            $this->viewData['getUnitData'] = $UnitList;
            $SupplierList = $this->Module_Model->getSupplerList($Row_product['intSupplier']);
            $this->viewData['getSupplierList'] = $SupplierList;
            $UnitList1 = $this->Module_Model->getUnitList1($Row_product['intPriceUnit']);
            $this->viewData['getPriceUnitData'] = $UnitList1;
            $UnitList2 = $this->Module_Model->getUnitList2($Row_product['intMOQUnit']);
            $this->viewData['getMOQUnitData'] = $UnitList2;
            $TimeList = $this->Module_Model->getTimeList($Row_product['intTime']);
            $this->viewData['getTimeData'] = $TimeList;
            $DeliveryTermsList = $this->Module_Model->getDeliveryTermsList($Row_product['intDeliveryTerms']);
            $this->viewData['getDeliveryTermsData'] = $DeliveryTermsList;
            $PaymentTermsList = $this->Module_Model->getPaymentTermsList($Row_product['intPaymentTerms']);
            $this->viewData['getPaymentTermsData'] = $PaymentTermsList;
            $PaymentTypeList = $this->Module_Model->getPaymentTypeList($Row_product['intPaymentType']);
            $this->viewData['getPaymentTypeData'] = $PaymentTypeList;
        } else {
            $edit_record = true;
            $alias_validation = true;
            $PageSize = $this->input->get_post('PageSize', true);
            $action = $this->module_url . 'insert?&PageSize=' . $PageSize;

            $ProductCatList = $this->Module_Model->getProductCatList();
            $this->viewData['ProductCatList'] = $ProductCatList;
            $UnitList = $this->Module_Model->getUnitList();
            $this->viewData['getUnitData'] = $UnitList;
            $SupplierList = $this->Module_Model->getSupplerList();
            $this->viewData['getSupplierList'] = $SupplierList;

            $UnitList1 = $this->Module_Model->getUnitList1();
            $this->viewData['getPriceUnitData'] = $UnitList1;
            $UnitList2 = $this->Module_Model->getUnitList2();
            $this->viewData['getMOQUnitData'] = $UnitList2;

            $TimeList = $this->Module_Model->getTimeList();
            $this->viewData['getTimeData'] = $TimeList;
            $DeliveryTermsList = $this->Module_Model->getDeliveryTermsList();
            $this->viewData['getDeliveryTermsData'] = $DeliveryTermsList;
            $PaymentTermsList = $this->Module_Model->getPaymentTermsList();
            $this->viewData['getPaymentTermsData'] = $PaymentTermsList;
            $PaymentTypeList = $this->Module_Model->getPaymentTypeList();
            $this->viewData['getPaymentTypeData'] = $PaymentTypeList;
        }

        $this->viewData['edit_record'] = $edit_record;
        $this->viewData['alias_validation'] = $alias_validation;
        $this->viewData['action'] = $action;
        $data_page_comb = $this->Module_Model->Bindpageshierarchy('intParentCategory', (!empty($Row_product['intParentCategory']) ? $Row_product['intParentCategory'] : ''), 'add-new-user-textarea2', '1');
        $this->viewData['pagetree'] = $data_page_comb;


        $this->viewData['productAddTab'] = true;
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

    public function insert_product_images() {

        $FileExntension = substr(strrchr($_FILES['file']['name'], '.'), 1);
        $id = $this->Module_Model->insert_photo();
    }

    public function approve_product() {
        $this->Module_Model->approve_product();
        echo "Y";
    }

    public function get_product_images($eid = '') {

        $id = $this->Module_Model->get_product_images($eid);
    }

    public function delete_image($image) {
        $this->Module_Model->delete_image($image);
    }

    public function delete_image_by_name() {
        $this->Module_Model->delete_image_by_name();
    }

    public function Insert() {
        $this->form_validation->set_rules('intParentCategory', 'Product Category', 'trim|required');
        $this->form_validation->set_rules('varName', 'Title', 'trim|required');
        $this->form_validation->set_rules('varAlias', 'Alias', 'trim|required');
//        $this->form_validation->set_rules('varKeyword', 'Keyword', 'trim|required');
//        $this->form_validation->set_rules('varPrice', 'Price', 'trim|required');
//        $this->form_validation->set_rules('intPriceUnit', 'Unit Price', 'trim|required');
//        $this->form_validation->set_rules('varMOQ', 'MOQ', 'trim|required');
//        $this->form_validation->set_rules('intMOQUnit', 'MOQ Unit', 'trim|required');
        $this->form_validation->set_error_delimiters('<li class="Alertconfirmation-div">', '</li>');

        if ($this->form_validation->run($this) == FALSE) {
            $this->add();
        } else {
            $id = $this->Module_Model->Insert();
            $this->Redirect_To_Page($id, 'add');
        }
    }

    public function update() {
        $this->form_validation->set_rules('intParentCategory', 'Product Category', 'trim|required');
        $this->form_validation->set_rules('varName', 'Title', 'trim|required');
        $this->form_validation->set_rules('varAlias', 'Alias', 'trim|required');
//        $this->form_validation->set_rules('varKeyword', 'Keyword', 'trim|required');
//        $this->form_validation->set_rules('varPrice', 'Price', 'trim|required');
//        $this->form_validation->set_rules('intPriceUnit', 'Unit Price', 'trim|required');
//        $this->form_validation->set_rules('varMOQ', 'MOQ', 'trim|required');
//        $this->form_validation->set_rules('intMOQUnit', 'MOQ Unit', 'trim|required');
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

    public function load_data() {
        $product_Records = $this->Module_Model->Select_All_product_Record();
        $this->viewData['ShowAllproductRecords'] = $product_Records;

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
//        echo "<pre>";
//        print_R($_REQUEST);exit;
        $this->Module_Model->updatedisplayorder();
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . "product", " AND intParentCategory='" . $this->input->post('intParentCategory') . "'");
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
        echo $this->Module_Model->generate_seocontent_product(true);
        exit;
    }

    function set_msg() {
        $msg_type = $this->input->get_post('msg', $msg_type);
        $this->session->set_flashdata('msg', $msg_type);
        echo '<a href="' . ADMINPANEL_URL . 'product/get_msg">click</a>';
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

    public function download() {
        $file = $this->input->get_post('file');
        $this->load->helper('download');
        $data = file_get_contents(base_url() . 'upimages/product/brochure/' . $file);
        force_download($file, $data);
        exit;
    }

}

?>