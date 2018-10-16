<?php

class delivery_terms_model extends CI_Model {

    var $int_id;
    var $varName;
    var $chr_publish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dt_createdate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $numofpages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'F.varName'; // Attribute of Deafult Order By
    var $OrderType = 'asc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of Pagesize For Paging
    var $PageNumber = '1'; // Attribute of Page Number For Paging(
    var $lastinsertid; // Attribute of Last Inserid
    var $UrlWithPara = ''; // Attribute of URL With parameters
    var $UrlWithpoutSearch = ''; // Attribute of URL With parameters without searh
    var $UrlWithOutSort = ''; // Attribute of URL With parameters without sort
    var $UrlWithOutPaging = ''; // Attribute of URL With parameters without paging
    var $FilterBy = '0';
    var $UrlWithoutFilter = '';
    var $display_limit_array = array('5', '10', '15', '30', 'All');
    var $dateField;
    var $NoOfPages;
    var $SearchByVal;
    var $AutoSearchUrl;
    var $SortVar;
    var $ProCat;

    public function __construct() {
        $this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->library('mylibrary');
        $mylibraryObj = new mylibrary;
        $this->SortVar = '';
        $this->module_url = MODULE_URL;
    }

    function HeaderPanel() {
        $content['headerpanel'] = $this->mylibrary->generateHeaderPanel($this->generateParam());
        return $content['headerpanel'];
    }

    function PagingTop() {
        $content['pagingtop'] = $this->mylibrary->generatePagingPannel($this->generateParam('top'));
        return $content['pagingtop'];
    }

    function PagingBottom() {
        $content['pagingbottom'] = $this->mylibrary->generatePagingPannel($this->generateParam('bottom'));
        return $content['pagingbottom'];
    }

    function initialize($flag = '') {
        $Term = $this->input->get_post('term');
        $SearchByVal = $this->input->get_post('SearchByVal');
        $SearchTxt = $this->input->get_post('SearchTxt');
        $SearchBy = $this->input->get_post('SearchBy');
        $Type = $this->input->get_post('Type');
        $OrderType = $this->input->get_post('OrderType');
        $FilterBy = $this->input->get_post('FilterBy');
        $PageSize = $this->input->get_post('PageSize');
        $PageNumber = $this->input->get_post('PageNumber');
        $OrderBy = $this->input->get_post('OrderBy');
        if (!empty($Term)) {
            $SearchTxt = ($Type == 'autosearch') ? $Term : $SearchTxt;
        }
        $this->SearchByVal = (!empty($SearchByVal)) ? $SearchByVal : $this->SearchByVal;
        $this->SearchBy = (!empty($SearchBy)) ? urldecode($SearchBy) : '';
        $this->SearchTxt = (!empty($SearchTxt)) ? urldecode($SearchTxt) : '';
        $this->OrderBy = (!empty($OrderBy)) ? $OrderBy : $this->OrderBy;
        $this->OrderType = (!empty($OrderType)) ? $OrderType : $this->OrderType;
        $this->FilterBy = (!empty($FilterBy)) ? $FilterBy : $this->FilterBy;
        if ($this->input->get_post('sorting') == 'Y') {
            if ($this->OrderType == "asc") {
                $this->OrderType = "desc";
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-down.png\" style=\"vertical-align:middle;\">";
            } else if ($this->OrderType == "desc") {
                $this->OrderType = "asc";
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-up.png\" style=\"vertical-align:middle;\">";
            }
        } else {
            if ($this->OrderType == "asc") {
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-up.png\" style=\"vertical-align:middle;\">";
            } else if ($this->OrderType == "desc") {
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-down.png\" style=\"vertical-align:middle;\">";
            }
        }
        if ($flag == 'Y') {
            $this->NumOfRows = $this->Countdelivery_terms();
            $this->PageSize = (!empty($PageSize)) ? $PageSize : 5;
            $this->PageNumber = (!empty($PageNumber)) ? $PageNumber : $this->PageNumber;
            $this->NoOfPages = intval($this->NumOfRows / $this->PageSize);
            $this->NoOfPages = (($this->NumOfRows % $this->PageSize) > 0) ? ($this->NoOfPages + 1) : ($this->NoOfPages);
            $this->Start = ($this->PageNumber - 1 ) * $this->PageSize;
        } else {
            $this->NumOfRows = $this->CountRows();
            $this->PageSize = (!empty($PageSize)) ? $PageSize : $this->PageSize;
            $this->PageNumber = (!empty($PageNumber)) ? $PageNumber : $this->PageNumber;
            $this->NoOfPages = intval($this->NumOfRows / $this->PageSize);
            $this->NoOfPages = (($this->NumOfRows % $this->PageSize) > 0) ? ($this->NoOfPages + 1) : ($this->NoOfPages);
            $this->Start = ($this->PageNumber - 1 ) * $this->PageSize;
        }
    }

    function Generateurl($flag = '') {
        if ($flag == 'Y') {
            $this->PageName = '';
        } else {
            $this->PageName = MODULE_PAGE_NAME . '?';
        }
        $this->AddPageName = MODULE_PAGE_NAME . '/add?';
        $this->DeletePageName = MODULE_PAGE_NAME . '/delete?';
        $this->HUrlWithPara = $this->PageName . '&' . 'hPageSize=' . $this->PageSize . '&hNumOfRows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hOrderType=' . $this->OrderType . '&hSearchBy=' . $this->SearchBy . '&hSearchTxt=' . urlencode($this->SearchTxt) . '&hPageNumber=' . $this->PageNumber . '&hFilterBy=' . $this->FilterBy . '&history=T';
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithOutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithOutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt);
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        if ($flag == 'Y') {
            return $this;
        }
    }

    function generateParam($position = 'top') {
        $PageSize = $this->PageSize;
        return array(
            'pageurl' => MODULE_PAGE_NAME . '?',
            'heading' => "Manage Units Master",
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'delivery_terms',
            'position' => $position,
            'actionImage' => 'add-new-button-blue.gif',
            'actionImageHover' => 'add-new-button-blue-hover.gif',
            'actionUrl' => MODULE_PAGE_NAME . '/add?&PageSize=' . $PageSize,
            'dispPaging' => 'Yes',
            'AutoSearchUrl' => $this->AutoSearchUrl,
            'display' => array('DisplayUrl' => $this->UrlWithOutPaging,
                'PageSize' => $this->PageSize,
                'LimitArray' => $this->display_limit_array,
            ),
            'paging' => array('PageNumber' => $this->PageNumber,
                'NoOfPages' => $this->NoOfPages,
                'NumOfRows' => $this->NumOfRows,
                'PagingUrl' => $this->UrlWithPara
            ),
            'search' => array('searchArray' => array(),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
        );
    }

    function SelectAll() {
        $this->initialize();
        $this->Generateurl();
        $this->db->select('F.int_id,F.varName,F.*', false);
        $this->db->from('delivery_terms as F', false);
        $this->db->where("F.chrDelete = 'N'", NULL, FALSE);
        $this->db->group_by("F.int_id");
        $this->db->order_by($this->OrderBy, $this->OrderType);
        $rs = $this->db->get();
        $res = $rs->result_array();
        return $res;
    }

    function CountRows() {
        $whereclauseids = "chrDelete ='N'";
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('delivery_terms');
        return $rs;
    }

    function Select_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('F.chrDelete' => 'N', 'F.int_id' => $id);
        $this->db->select('F.*', false);
        $this->db->from('delivery_terms As F');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert($Files_Name = '') {
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'chrPublish' => $chrPublish,
            'chrDelete' => 'N',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
        $this->db->insert('delivery_terms', $data);
        $id = $this->db->insert_id();
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'delivery_terms', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update($Files_Name = '') {
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $Int_DisplayOrder = $this->input->post('varName');
        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'chrPublish' => $chrPublish,
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update('delivery_terms', $data);
        $int_id = $this->input->get_post('ehintglcode');
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'delivery_terms', 'Name' => 'varName', 'ModuleintGlcode' => $int_id, 'Flag' => 'U', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
    }

    function delete_row() {
        $tablename = 'delivery_terms';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['SERVER_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'delivery_terms', 'Name' => 'varName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id');
            $this->mylibrary->insertinlogmanager($ParaArray);
        }
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'delivery_terms');
    }

    function updatedisplay() {
        $tablename = $this->input->get_post('tablename');
        $fieldname = $this->input->get_post('fieldname');
        $value = $this->input->get_post('value');
        $idname = $this->input->get_post('id');
        $updateSql = "UPDATE {$tablename} SET {$fieldname}='{$value}' WHERE  int_id in ({$idname}) ";
        $res = mysql_query($updateSql) or die(mysql_error());
        return ($res) ? "1" : "0";
    }


}

?>