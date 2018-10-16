<?php

class accesscontrol_model extends CI_Model {

    var $int_id;
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
    var $dtModifyDate;   // (normal Attribute)
    var $old_displayorder; // Attribute of Old Displayorder
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $NumOfPages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'dtModifyDate'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of PageSize For Paging
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

        /* Declare it in every module */

        $this->Module_Url = MODULE_URL . 'accesscontrol/';
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

    function Initialize() {
        $term = $this->input->get_post('term');
        $SearchByVal = $this->input->get_post('SearchByVal');
        $SearchTxt = $this->input->get_post('SearchTxt');
        $SearchBy = $this->input->get_post('SearchBy');
        $type = $this->input->get_post('Type');
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
        $this->PageName = MODULE_PAGE_NAME . '?';
        $this->AddPageName = $this->Module_Url . 'add?';
        $this->DeletePageName = $this->Module_Url . 'Delete?';

        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt;
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
    }

    function generateParam($position = 'top') {
        return array(
            'PageUrl' => $this->Module_Url,
            'heading' => "Manage Users",
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'adminpanelusers',
            'position' => $position,
            'actionImage' => 'add-new-button-blue.gif',
            'actionImageHover' => 'add-new-button-blue-hover.gif',
            'actionUrl' => $this->Module_Url . 'add',
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
            'search' => array('searchArray' => array("varName" => "Name", "varLoginEmail" => "Email Id"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
        );
    }

    function selectAll() {
        $this->Initialize();
        $this->Generateurl();
        $whereclauseids = '';
        $own_access = '';
        $brokeragentArray = array();

        if (USERTYPE != 'N') {
            $own_access .= " AND varUserType = 'S' ";
        }

        if (trim($this->SearchTxt) != '') {
            if ($this->SearchTxt != '') {
                $searchBy = $this->SearchBy;
                if ($this->SearchBy == '') {
                    $searchBy = "varName";
                } else {
                    $searchBy = $this->SearchBy;
                }
                $whereclauseids .= (empty($this->SearchBy)) ? " and varName like '%" . addslashes($this->SearchTxt) . "%'" : " and $searchBy like '%" . addslashes($this->SearchTxt) . "%'";
            }

            if ($this->Filterby != '0') {
                $filterarray = explode('-', $this->Filterby);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  and  $filterarray[0] = '$filterarray[1]'";
                }
            }
        }

        $Type = $this->input->get_post('Type', true);
        if (!empty($Type)) {
            if ($Type == 'autosearch') {
                $OrderBy = (isset($this->OrderBy)) ? $this->OrderBy : 'dtModifyDate';
                $Ordertype = (isset($this->OrderType)) ? $this->OrderType : 'asc';
                $SearchByVal = " like '%" . addslashes($this->SearchTxt) . "%'  and chrDelete = 'N'";

                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
                    $this->SearchByVal = "varName";
                } else {
                    $this->SearchByVal = $this->SearchByVal;
                }

                $this->db->select("*,{$this->SearchByVal} as AutoVal", false);
                $this->db->from('adminpanelusers', false);
                $this->db->where("{$this->SearchByVal} $SearchByVal $whereclues $own_access", null, false);
                $this->db->order_by("$OrderBy", "$Ordertype");
                $autoSearchQry = $this->db->get();
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select('*', false);
        $this->db->where("chrDelete = 'N' $own_access $whereclauseids", NULL, FALSE);
        $this->db->from('adminpanelusers');
        $this->db->order_by($this->OrderBy, $this->OrderType);
        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }
        $query = $this->db->get();

        return $query;
    }

    function CountRows() {
        $whereclauseids = '';
        if (trim($this->SearchTxt) != '' || $this->Filterby != '0') {
            if ($this->SearchTxt != '') {
                $searchBy = $this->SearchBy;
                if ($this->SearchBy == 'varName') {
                    $searchBy = "varName";
                }
                $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $searchBy LIKE '%" . addslashes($this->SearchTxt) . "%'";
            }

            if ($this->Filterby != '0') {
                $filterarray = explode('-', $this->Filterby);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
                }
            }
        } else {
            $whereclauseids = '';
        }

        $own_access = '';
        if (USERTYPE != 'N') {
            $own_access .= " AND varUserType = 'S' ";
        }
        $brokeragentArray = array();
        $this->db->where("chrDelete = 'N' $own_access $whereclauseids", NULL, FALSE);
        $rs = $this->db->count_all_results('adminpanelusers');
        return $rs;
    }

    function select($id) {
        $returnArry = array();
        $this->db->select('*');
        $this->db->from('adminpanelusers');
        $this->db->where('chrDelete', 'N');
        $this->db->where('int_id', $id);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function insert($photoname = '') {

        $this->db->where(array('chrDelete' => 'N'));
        $tot_recods = $this->db->count_all_results('adminpanelusers');
        //  $intdisplayorder = $this->input->post('intDisplayOrder',true); 
        $loginemail = $this->input->post('varLoginEmail', true);
//        $permitmail = $this->input->post('varPersonalEmail', true);

        $varPhoneNo = $this->input->post('varPhoneNo', true);
        $gender = $this->input->post('chrGender');
        $token_val = md5(uniqid(rand(), true));
        $data = array(
            'varName' => $this->input->post('varName', true),
            'varLoginEmail' => trim($loginemail),
            'varPersonalEmail' => trim($loginemail),
            'varUserType' => $this->input->post('varUserType', TRUE),
            'varAadharCard' => $this->input->post('varAadharCard', TRUE),
            'varState' => $this->input->post('varState', TRUE),
            'varDistrict' => $this->input->post('varDistrict', TRUE),
            'varPassword' => $this->mylibrary->cryptPass($this->input->post('varPassword', true)),
            'varPhoneNo' => $varPhoneNo,
            'chrGender' => $gender,
            'dtCreateDate' => date('Y-m-d-h-i-s'),
            'dtModifyDate' => date('Y-m-d-h-i-s'),
            // 'intDisplayOrder' => $intdisplayorder,
            'chrPublish' => $this->input->post('chrPublish', true),
            'chrDelete' => 'N',
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'varToken' => $token_val
        );

        $this->db->insert('adminpanelusers', $data);
        $id = $this->db->insert_id();
//        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'adminpanelusers');
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'adminpanelusers', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update($photoname = '') {
//        if ($this->input->post('intDisplayOrder', true) != $this->input->post('old_displayorder', true)) 
//        {
//            $this->mylibrary->update_display_order($this->input->post('ehintglcode', true), $this->input->post('intDisplayOrder', true), $this->input->post('old_displayorder', true), '', 'adminpanelusers');
//        }
        $varPhoneNo = $this->input->post('varPhoneNo', true);
        $gender = $this->input->post('chrGender');

        $state = $this->input->post('varStates', true);
        $utype = $this->input->post('varUserType', true);
        if ($utype == 'D') {
            $sel_state = $state;
            $sel_district = $this->input->post('varDistrict', TRUE);
        } else {
            $sel_state = $this->input->post('varState', TRUE);
            $sel_district = "";
        }
        $data = array(
            'varName' => $this->input->post('varName', true),
            'varLoginEmail' => $this->input->post('varLoginEmail', true),
            'varPersonalEmail' => $this->input->post('varLoginEmail', true),
            'varUserType' => $this->input->post('varUserType', TRUE),
            'varAadharCard' => $this->input->post('varAadharCard', TRUE),
            'varState' => $sel_state,
            'varDistrict' => $sel_district,
            'varPhoneNo' => $varPhoneNo,
            'chrGender' => $gender,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            //   'intDisplayOrder' => $this->input->post('intDisplayOrder', true),
            'chrPublish' => $this->input->post('chrPublish', true),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
        );
//print_r($data);exit;
        $password = $this->input->post('varPassword', true);
        if (!empty($password)) {
            $data['varPassword'] = $this->mylibrary->cryptPass($password);
        }
        $this->db->where('int_id', $this->input->get_post('ehintglcode', true));
        $this->db->update('adminpanelusers', $data);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'adminpanelusers', 'Name' => 'varName', 'ModuleintGlcode' => $this->input->get_post('ehintglcode', true), 'Flag' => 'U', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
        $this->mylibrary->insertinlogmanager($ParaArray);
    }

    function delete_row() {
        $tablename = 'adminpanelusers';
        $deleteids = $this->input->get_post('dids', true);
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d h-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR'], 'PUserGlCode' => ADMIN_ID);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $this->mylibrary->delete_alias($deletearray[$i], MODULE_ID);

            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'adminpanelusers', 'Name' => 'varName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
            $this->mylibrary->insertinlogmanager($ParaArray);
        }
    }

    function updatedisplayorder() {
        $uids = $this->input->get_post('uid');
        $neworder = $this->input->get_post('neworder');
        $oldorder = $this->input->get_post('oldorder');

        $this->mylibrary->Update_Display_Order($uids, $neworder, $oldorder, 'adminpanelusers');
        $tablename = DB_PREFIX . 'adminpanelusers';
        //    $this->mylibrary->set_Int_DisplayOrder_sequence($tablename);
    }

    function Check_Email() {
        $Eid = $this->input->get_post('Eid', FALSE);
        if (!empty($Eid)) {
            $this->db->where_not_in('int_id', $Eid);
        }
        $this->db->where('varLoginEmail', $this->input->get_post('User_Email', FALSE));
        $query = $this->db->get('adminpanelusers');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getStateName($stateId = "") {
        $query = $this->db->query("select * from " . DB_PREFIX . "areas group by varState order by varState asc ");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"varStates\" name=\"varStates\" >";
        $returnHtml .= "<option value=''>--Select State --</option>";
        foreach ($Result as $row) {
            if ($stateId == $row['varState']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['varState'] . '" ' . $selected . '>' . $row['varState'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getStatesName($stateId = "") {
        $state = $this->input->get_post('varState');
        if ($state != '') {
            $query = $this->db->query("select * from " . DB_PREFIX . "areas where varState='" . $state . "' group by varState order by varState asc ");
        } else {
            $query = $this->db->query("select * from " . DB_PREFIX . "areas group by varState order by varState asc ");
        }
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<label> State *</label>";
        $returnHtml .= "<select onchange='return getDistricts(this.value)' class=\"md-input label-fixed\" id=\"varState\" name=\"varState\" >";
        $returnHtml .= "<option value=''>--Select State --</option>";
        foreach ($Result as $row) {
            if ($stateId == $row['varState']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['varState'] . '" ' . $selected . '>' . $row['varState'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getDistrictName($districtId = "") {
        $query = $this->db->query("select * from " . DB_PREFIX . "areas group by varDistrict order by varDistrict asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<label> District *</label>";
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"varDistrict\" name=\"varDistrict\" >";
        $returnHtml .= "<option value=''>--Select District --</option>";
        foreach ($Result as $row) {
            if ($districtId == $row['varDistrict']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['varDistrict'] . '" ' . $selected . '>' . $row['varDistrict'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getDisctrictsName($state_id = "", $districtId = '') {
        if ($state_id == '') {
            $state_id = $this->input->get_post('varState');
        }
        if ($state_id != '') {
            $query = $this->db->query("select * from " . DB_PREFIX . "areas where varState='" . $state_id . "' group by varDistrict order by varDistrict asc");
        } else {
            $query = $this->db->query("select * from " . DB_PREFIX . "areas group by varDistrict order by varDistrict asc");
        }
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<label> District *</label>";
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"varDistrict\" name=\"varDistrict\" >";
        $returnHtml .= "<option value=''>--Select District --</option>";
        foreach ($Result as $row) {
            if ($districtId == $row['varDistrict']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['varDistrict'] . '" ' . $selected . '>' . $row['varDistrict'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

}

?>