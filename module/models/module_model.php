<?php

class module_model extends CI_Model {

    var $Id;
    var $Fk_Pages;
    var $Var_PageName;
    var $Var_Alias;
    var $Text_Fulltext;
    var $Var_Metatitle;
    var $Var_Metakeyword;
    var $Var_Metadescription;
    var $intDisplayOrder;
    var $chrPublish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $Dt_CreateDate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $old_displayorder; // Attribute of Old Displayorder
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $NumOfPages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'intDisplayOrder'; // Attribute of Deafult Order By
    var $OrderType = 'asc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = 15; // Attribute of PageSize For Paging
    var $PageNumber = '1'; // Attribute of Page Number For Paging(
    var $lastinsertid; // Attribute of Last Inserid
    var $UrlWithPara = ''; // Attribute of URL With parameters
    var $UrlWithpoutSearch = ''; // Attribute of URL With parameters without searh
    var $UrlWithoutSort = ''; // Attribute of URL With parameters without sort
    var $UrlWithoutPaging = ''; // Attribute of URL With parameters without paging
    var $FilterBy = '0';
    var $UrlWithoutFilter = '';
    var $Display_Limit_Array = array('5', '10', '15', '30', 'All');
    var $DateField;
    var $NoOfPages;
    var $SearchByVal;
    var $AutoSearchUrl;
    var $SortVar = '';

    public function __construct() {
        $this->load->database();
        $this->ajax = $this->input->get_post('ajax');
        $this->load->helper(array('form', 'url'));

        if (USERTYPE != 'N') {
            redirect(ADMINPANEL_URL);
        }

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

    function initialize() {

        $term = $this->input->get_post('term');
        $SearchByVal = $this->input->get_post('SearchByVal');
        $SearchTxt = $this->input->get_post('SearchTxt');
        $SearchBy = $this->input->get_post('SearchBy');
        $type = $this->input->get_post('type');
        $OrderType = $this->input->get_post('OrderType');
        $FilterBy = $this->input->get_post('FilterBy');
        $PageSize = $this->input->get_post('PageSize');

        $PageNumber = $this->input->get_post('PageNumber');
        $OrderBy = $this->input->get_post('OrderBy');

        if (!empty($term)) {
            $SearchTxt = ($type == 'autosearch') ? $term : $SearchTxt;
        }
        $this->SearchByVal = (!empty($SearchByVal)) ? $SearchByVal : $this->SearchByVal;
        $this->SearchBy = (isset($SearchBy)) ? urldecode($SearchBy) : '';
        $this->SearchTxt = (!empty($SearchTxt)) ? urldecode($SearchTxt) : '';
        $this->OrderBy = (!empty($OrderBy)) ? $OrderBy : $this->OrderBy;
        $this->OrderType = (!empty($OrderType)) ? $OrderType : $this->OrderType;
        $this->FilterBy = (!empty($FilterBy)) ? $FilterBy : $this->FilterBy;

        if ($this->input->get_post('sorting') == 'Y') {
            if ($this->OrderType == "asc") {   // This is for sort image
                $this->OrderType = "desc";
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-down.png\" style=\"vertical-align:middle;\">";
            } else if ($this->OrderType == "desc") {   // This is for sort image
                $this->OrderType = "asc";
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-up.png\" style=\"vertical-align:middle;\">";
            }
        } else {
            if ($this->OrderType == "asc") {   // This is for sort image
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-up.png\" style=\"vertical-align:middle;\">";
            } else if ($this->OrderType == "desc") {   // This is for sort image
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-down.png\" style=\"vertical-align:middle;\">";
            }
        }

        $this->NumOfRows = $this->CountRows();
        $this->PageSize = (!empty($PageSize)) ? $PageSize : $this->PageSize;
        $this->PageNumber = (!empty($PageNumber)) ? $PageNumber : $this->PageNumber;
        $this->NoOfPages = intval($this->NumOfRows / $this->PageSize);
        $this->NoOfPages = (($this->NumOfRows % $this->PageSize) > 0) ? ($this->NoOfPages + 1) : ($this->NoOfPages);
        $this->Start = ($this->PageNumber - 1 ) * $this->PageSize;
    }

    function Generateurl() {
        $this->PageName = MODULE_PAGE_NAME;
        $this->AddPageName = MODULE_PAGE_NAME . '/add?';
        $this->DeletePageName = MODULE_PAGE_NAME . '/delete?';

        $this->hurlwithpara = $this->PageName . '?&' . 'hpagesize=' . $this->PageSize . '&hnumofrows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hordertype=' . $this->OrderType . '&hsearchby=' . $this->SearchBy . '&hsearchtxt=' . $this->SearchTxt . '&hpagenumber=' . $this->PageNumber . '&hfilterby=' . $this->FilterBy . '&history=T';
        $this->UrlWithPara = $this->PageName . '?&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '?&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutSort = $this->PageName . '?&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutPaging = $this->PageName . '?&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutFilter = $this->PageName . '?&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt;
        $this->AutoSearchUrl = $this->UrlWithPara . "&type=autosearch&SearchByVal=" . $this->SearchByVal;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
    }

    function generateParam($position = 'top') {
        return array(
            'pageurl' => MODULE_PAGE_NAME,
            'heading' => "Manage Modules",
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'modules',
            'position' => $position,
            'actionImage' => 'add-new-button-blue.gif',
            'actionImageHover' => 'add-new-button-blue-hover.gif',
            'actionUrl' => MODULE_PAGE_NAME . '/add',
            'dispPaging' => 'Yes',
            'AutoSearchUrl' => $this->AutoSearchUrl,
            'display' => array('DisplayUrl' => $this->UrlWithoutPaging,
                'PageSize' => $this->PageSize,
                'LimitArray' => $this->Display_Limit_Array,
            ),
            'paging' => array('PageNumber' => $this->PageNumber,
                'NoOfPages' => $this->NoOfPages,
                'NumOfRows' => $this->NumOfRows,
                'PagingUrl' => $this->UrlWithPara
            ),
            'search' => array('searchArray' => array("varModuleName" => "Title"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
        );
    }

    function GetAllModules() {

        $this->initialize();
        $this->Generateurl();
        $whereclauseids = '';
        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {
            if ($this->SearchTxt != '') {
                $whereclauseids .= (empty($this->SearchBy)) ? " and m.varTitle like '%" . addslashes($this->SearchTxt) . "%'" : " and $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
            }
            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  and  $filterarray[0] = '$filterarray[1]'";
                }
            }
        }

        $type = $this->input->get_post('type');
        if (!empty($type)) {
            if ($type == 'autosearch') {
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by intDisplayOrder asc';
                $SearchByVal = " like '%" . addslashes($this->SearchTxt) . "%'  and chrDelete = 'N' ";

                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
                    $this->SearchByVal = "varModuleName";
                }
                $autoSearchQry = "select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "modules where {$this->SearchByVal} $SearchByVal  group by intDisplayOrder order by intDisplayOrder asc";
                $auto_result = $this->db->query($autoSearchQry);
                $this->mylibrary->GetAutoSearch($auto_result);
            }
        }

//        if ($this->PageSize == 'All') {
//            $limitby = '';
//        } else {
//            $limitby = 'limit ' . $this->Start . ', ' . $this->PageSize;
//        }

        $OrderBy = 'order by ' . $this->OrderBy . ' ' . $this->OrderType;
        $query = $this->db->query("select m.*,me.intDisplayOrder as DisplayOrder,me.fk_ModuleGlCode as fk_ModuleGlCode,me.varActionListing as varActionListing,me.varActionAdd as varActionAdd,m.int_id as Id,me.intDisplayOrder as Int_DisplayOrderId,me.fk_ModuleGlCode as Module_Id from " . DB_PREFIX . "modules as m left join " . DB_PREFIX . "adminpanelmenus as me on m.int_id=me.fk_ModuleGlCode  where m.chrDelete = 'N' $whereclauseids $OrderBy $limitby");

        return $query;
    }

    function CountRows() {

        $whereclauseids = '';
        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {
            if ($this->SearchTxt != '') {
                $whereclauseids .= (empty($this->SearchBy)) ? " and m.varModuleName like '%" . addslashes($this->SearchTxt) . "%'" : " and $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
            }
            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  and  $filterarray[0] = '$filterarray[1]'";
                }
            }
        } else {
            $whereclauseids = '';
        }
        $sqlCountPages = "select m.*,me.fk_ModuleGlCode as fk_ModuleGlCode,me.varActionListing as varActionListing,me.varActionAdd as varActionAdd,m.int_id as Id,me.intDisplayOrder as Int_DisplayOrderId,me.fk_ModuleGlCode as Module_Id FROM " . DB_PREFIX . "modules as m left join " . DB_PREFIX . "adminpanelmenus as me on m.int_id=me.fk_ModuleGlCode where m.chrDelete='N'  $whereclauseids";
        $query = $this->db->query($sqlCountPages);
        $rs = $query->num_rows();
        return $rs;
    }

    function SelectRow($id) {


        $returnArry = array();

        $query = "select m.*,me.fk_ModuleGlCode as AdminPanelfk_ModuleGlCode,me.varActionListing as varActionListing,me.varActionAdd as varActionAdd,m.int_id as Id,me.intDisplayOrder as Int_DisplayOrderId,me.fk_ModuleGlCode as Module_Id from " . DB_PREFIX . "modules as m left join " . DB_PREFIX . "adminpanelmenus as me on m.int_id=me.fk_ModuleGlCode  where m.int_id=" . $id;
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }

        return $returnArry;
    }

    public function Insert() {

        $ModuleData = array(
            'fk_ModuleGlCode' => $this->input->get_post('fk_ModuleGlCode', TRUE),
            'varModuleName' => $this->input->get_post('varModuleName', TRUE),
            'varHeaderText' => $this->input->get_post('varHeaderText', TRUE),
            'varTitle' => $this->input->get_post('varTitle', TRUE),
            'varTableName' => $this->input->get_post('varTableName', TRUE),
            'chrPublish' => $this->input->get_post('chrPublish', TRUE),
            'chrAdminPanel' => $this->input->get_post('chrAdminPanel', TRUE),
            'chrFront' => $this->input->get_post('chrFront', TRUE),
            'chrDisplayTrash' => $this->input->get_post('chrDisplayTrash', TRUE),
            'chrDisplayPage' => $this->input->get_post('chrDisplayPage', TRUE),
            'chrDisplayAccess' => $this->input->get_post('chrDisplayAccess', TRUE),
            'varHeaderClass' => $this->input->get_post('varHeaderClass', TRUE),
            'chrMenu' => $this->input->get_post('chrMenu', TRUE),
            'intDisplayOrder' => $this->input->post('intDisplayOrder', TRUE),
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'chrDelete' => 'N',
        );
        $this->db->insert(DB_PREFIX . 'modules', $ModuleData);
        $LastId = $this->db->insert_id();

        $AdminPanelMenu = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'fk_ModuleGlCode' => $LastId,
            'varHeaderClass' => $this->input->get_post('varHeaderClass', TRUE),
            'varActionListing' => $this->input->post('varActionListing', TRUE),
            'varActionAdd' => $this->input->post('varActionAdd', TRUE),
            'intDisplayOrder' => $this->input->post('intDisplayOrder', TRUE),
            'chrDelete' => 'N',
            'chrPublish' => 'Y',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s')
        );
        $this->db->insert(DB_PREFIX . 'adminpanelmenus', $AdminPanelMenu);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'modules');

        return $LastId;
    }

    function Update() {

        if ($this->input->post('intDisplayOrder') != $this->input->post('old_displayorder')) {
            $this->mylibrary->Update_Display_Order($this->input->post('ehintglcode'), $this->input->post('intDisplayOrder'), $this->input->post('old_displayorder'), 'modules');
        }

        $ModuleData = array(
            'fk_ModuleGlCode' => $this->input->get_post('fk_ModuleGlCode', TRUE),
            'varModuleName' => $this->input->get_post('varModuleName', TRUE),
            'varHeaderText' => $this->input->get_post('varHeaderText', TRUE),
            'varTitle' => $this->input->get_post('varTitle', TRUE),
            'varTableName' => $this->input->get_post('varTableName', TRUE),
            'chrPublish' => $this->input->get_post('chrPublish', TRUE),
            'chrAdminPanel' => $this->input->get_post('chrAdminPanel', TRUE),
            'chrFront' => $this->input->get_post('chrFront', TRUE),
            'chrDisplayTrash' => $this->input->get_post('chrDisplayTrash', TRUE),
            'chrDisplayPage' => $this->input->get_post('chrDisplayPage', TRUE),
            'chrDisplayAccess' => $this->input->get_post('chrDisplayAccess', TRUE),
            'varHeaderClass' => $this->input->get_post('varHeaderClass', TRUE),
            'intDisplayOrder' => $this->input->post('intDisplayOrder', TRUE),
            'chrMenu' => $this->input->get_post('chrMenu', TRUE),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'chrDelete' => 'N',
        );

        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update('modules', $ModuleData);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'modules');

        $AdminPanelMenu = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'varHeaderClass' => $this->input->get_post('varHeaderClass', TRUE),
            'fk_ModuleGlCode' => $this->input->get_post('ehintglcode'),
            'varActionListing' => $this->input->post('varActionListing', TRUE),
            'varActionAdd' => $this->input->post('varActionAdd', TRUE),
            'intDisplayOrder' => $this->input->post('intDisplayOrder', TRUE),
            'chrDelete' => 'N',
            'chrPublish' => 'Y',
            'dtModifyDate' => date('Y-m-d H:i:s')
        );
        $this->db->where('fk_ModuleGlCode', $this->input->get_post('ehintglcode'));
        $this->db->update('adminpanelmenus', $AdminPanelMenu);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'adminpanelmenus', $DisplayOrderClause);
    }

    function updatedisplay() {
        $tablename = $this->input->get_post('tablename');
        $fieldname = $this->input->get_post('fieldname');
        $value = $this->input->get_post('value');
        $idname = $this->input->get_post('id');

        $updateSql = "UPDATE {$tablename} SET {$fieldname}='{$value}' WHERE  Id in ({$idname}) ";
        $res = mysql_query($updateSql) or die(mysql_error());
        echo ($res) ? "1" : "0";
        exit;
    }

    function updatedisplayorder() {

        $uids = $this->input->get_post('uid');
        $neworder = $this->input->get_post('neworder');
        $oldorder = $this->input->get_post('oldorder');
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'modules', '');
        $tablename = DB_PREFIX . 'modules';
        $this->mylibrary->set_Int_DisplayOrder_sequence($tablename);
    }

    function Delete_Row() {

        $tablename = DB_PREFIX . 'modules';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {

            $ModuleData = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'varIpAddress' => $_SERVER['SERVER_ADDR'], 'PUserGlCode' => ADMIN_ID);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $ModuleData);

            $AdminPanelData = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'));
            $this->db->where('fk_ModuleGlCode', $deletearray[$i]);
            $this->db->update("adminpanelmenus", $AdminPanelData);
        }
    }

    function Check_module_name($varTitle) {


        $eid = $this->input->get_post('eid');
        if (!empty($eid)) {
            $this->db->where_not_in('Id', $eid);
        }
        $this->db->where('chrDelete', 'N');

        $this->db->where('varTitle', $varTitle);
        $query = $this->db->get('modules');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function Check_moduledirectory_name($foldername) {

        $target = 'application/modules/' . $foldername;
        $scan = scandir($target);

        if ($scan) {
            return '1';
        } else {
            return '0';
        }
    }

    function SubMenuCmb($ids = '') {
        $this->db->order_by("varTitle");
        $SQL = $this->db->get_where("modules", array("chrDelete" => "N", "chrPublish" => "Y"));
        $selected_ids = Array();
        array_push($selected_ids, $ids);
        $otherString = ' id="fk_ModuleGlCode" class="form-control" "';
        $options = Array();
        $options[0] = 'No Parent';

        foreach ($SQL->Result() as $Menu) {
            $options[$Menu->int_id] = ucwords($Menu->varModuleName);
        }
        $moduleSelectBox = array('name' => 'fk_ModuleGlCode',
            'class' => 'form-control',
            'options' => $options,
            'otherString' => $otherString,
            'selected_ids' => $selected_ids,
            'tdoption' => Array('TDDisplay' => 'Y'),
        );
        $display_output = form_input_ready($moduleSelectBox, 'select');
        return $display_output;
    }

    function Get_DisplayOrder($ID = 0) {

        $SQL = $this->db->query("SELECT intDisplayOrder FROM " . DB_PREFIX . "adminpanelmenus WHERE chrDelete='N' and fk_ModuleGlCode=@?", $ID);
        $RS = $SQL->Row();
        return $RS->intDisplayOrder;
    }

    function site_sel_Cmb($Country_ids = "", $Site_ids = "") {

        $cnt_id_arr = explode(',', $Country_ids);
        $site_id_arr = explode(',', $Site_ids);

        $this->db->select('varTitle,int_id');
        $this->db->from('CountryMst');
        $this->db->where(array('chrPublish' => 'Y', 'chrDelete' => 'N'));
        $this->db->order_by('intDisplayOrder', 'asc');
        $country_query = $this->db->get();
        $Html = '<select name="fk_SiteGlCode[]" class="more-textarea fl" id="fk_SiteGlCode" multiple="multiple" style="width:305px" size="10">';

        foreach ($country_query->result() as $country_row) {

            $Html .= '<optgroup  label="' . $country_row->varTitle . '">';

            $this->db->select('varTitle,int_id');
            $this->db->from('SiteMst');
            $this->db->where(array('chrPublish' => 'Y', 'chrDelete' => 'N'));
            $this->db->where("FIND_IN_SET('" . $country_row->int_id . "', fk_CountryGlCode)");
            $this->db->order_by('intDisplayOrder', 'asc');
            $site_query = $this->db->get();

            foreach ($site_query->result() as $site_row) {
                $selected = '';
                if (in_array($site_row->int_id, $site_id_arr) && in_array($country_row->int_id, $cnt_id_arr)) {
                    $selected = 'selected="selected"';
                }
                $Html .= '<option ' . $selected . ' value="' . $country_row->int_id . '-' . $site_row->int_id . '">' . $site_row->varTitle . '</option>';
            }

            $Html .= '</optgroup>';
        }
        $Html .= '</select>';
        return $Html;
    }

}

?>