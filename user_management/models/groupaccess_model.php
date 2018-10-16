<?php

class groupaccess_model extends CI_Model {

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
    var $OrderBy = 'intDisplayOrder'; // Attribute of Deafult Order By
    var $OrderType = 'asc'; // Attribute of Deafult Order By
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

        $this->module_url = MODULE_URL . 'groupaccess/';
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
    }

    function Generateurl() {
        $append_url = "&fk_Userid=" . $this->userid;
        $this->PageName = $this->module_url . '?';
        $this->AddPageName = $this->module_url . 'add?';
        $this->DeletePageName = $this->module_url . 'Delete?';

        $this->hUrlWithPara = $this->PageName . '&' . 'hpagesize=' . $this->PageSize . '&hnumofrows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hordertype=' . $this->OrderType . '&hsearchby=' . $this->SearchBy . '&hsearchtxt=' . $this->SearchTxt . '&hpagenumber=' . $this->PageNumber . '&hfilterby=' . $this->FilterBy . '&history=T';
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt;
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
    }

    function GetAllActionCode() {

        $this->db->select("int_id");
        $SQL = $this->db->get('useraction');
        $RS = $SQL->Result();

        $ActionCodeArray = array();
        foreach ($RS as $ActionCode) {
            $ActionCodeArray[] = $ActionCode->int_id;
        }
        return $ActionCodeArray;
    }

    function Insert() {

        $user_id = $this->input->get_post('fk_UserGlCode', TRUE);
        $this->userid = $user_id;

        if ($this->Remove_Existing_Access($user_id)) {

            foreach ($this->input->post('access', true) as $Access) {
                $AccessArray = explode("-", $Access);
                $ModuleArray[$AccessArray[0]][] = $AccessArray[1];
            }

            foreach ($ModuleArray as $Key => $modulesAccess) {
                $this->updateAccessToUser($user_id, $modulesAccess, $Key);
            }


            return $user_id;
        }
    }

    function Remove_Existing_Access($user_id) {
        if (!empty($user_id)) {
            $this->db->where(array('PUserGlCode' => $user_id));
            $this->db->delete('useraccess');
            return true;
        }
    }

    function update() {

        /* Delete Old entries */
        /* insert New entries */
    }

    /*     * ******************************************************************************************************************************* */

    function updateAccessToUser($UserGlCode, $AccessArray, $ModuleId) {

        $ActionArray = $this->GetAllActionCode();

        $Result = array_diff($ActionArray, $AccessArray);

        if (!empty($Result)) {
            foreach ($Result as $RemainAction) {
                $AccessArray[] = $RemainAction . "-N";
            }
        }


        foreach ($AccessArray as $Action) {
            $ActionArray = explode("-", $Action);
            if ($ActionArray[1] == 'N') {
                $chrAssign = "N";
            } else {
                $chrAssign = "Y";
            }
            $DataArray = array('PUserGlCode' => $UserGlCode,
                'fk_useractionGlCode' => $ActionArray[0],
                'fk_ModuleGlCode' => $ModuleId,
                'chrAssign' => $chrAssign,
                'dtModifyDate' => 'now()'
            );
            $this->db->Insert("useraccess", $DataArray);
        }
    }

    function updatedisplay() {
        $tablename = $this->input->get_post('tablename', true);
        $fieldname = $this->input->get_post('fieldname', true);
        $value = $this->input->get_post('value', true);
        $idname = $this->input->get_post('id', true);

        $updateSql = "UPDATE {$tablename} SET {$fieldname}='{$value}' WHERE  int_glcode in ({$idname}) ";
        $res = mysql_query($updateSql) or die(mysql_error());
        echo ($res) ? "1" : "0";
        exit;
    }

    function selectAllassignAction($id) {

        $actionassign = array();

        $query = "select mu.int_glcode
                ,mu.fk_modules
                ,mu.fk_useraction
                ,mu.chr_delete as chrdelete
                ,ua.chr_assign 
                FROM " . DB_PREFIX . "module_useraction mu left join " . DB_PREFIX . "useraccess ua 
                ON mu.int_glcode = ua.fk_module_useraction
                AND ua.chr_delete='N' AND ua.fk_groups = '$id'";

        $result = $this->db->query($query);

        foreach ($result->result_array() as $row) {

            $actionmodule[$row['fk_modules']][$row['fk_useraction']] = $row['int_glcode'];
            $actionassign[$row['fk_modules']][$row['fk_useraction']] = $row['chr_assign'];
            $actiondisable[$row['fk_modules']][$row['fk_useraction']] = $row['chrdelete'];
        }
        $this->actiondisable = $actiondisable;
        $this->actionassign = $actionassign;
        return $actionmodule;
    }

    function getAllAction() {

        $SQL = $this->db->query("select GROUP_CONCAT(int_id) as Action,GROUP_CONCAT(varAction) as ActionName from " . DB_PREFIX . "useraction where chrDelete='N'");
        $RS = $SQL->row();
        $TempAction = explode(",", $RS->Action);
        $TempActionName = explode(",", $RS->ActionName);

        for ($i = 0; $i < count($TempAction); $i++) {

            $ActionArray[$i]['ActionId'] = $TempAction[$i];
            $ActionArray[$i]['ActionName'] = $TempActionName[$i];
        }
        return $ActionArray;
    }

    function GetallModule() {

        $ModuleArray = array();

        $SQL = $this->db->query("select int_id as ModuleId
                ,varModuleName as ModuleName
                ,varModuleName as orderField
                ,varTitle
                FROM " . DB_PREFIX . "modules where chrAdminPanel='Y' and chrDisplayAccess = 'Y' 
                ORDER BY ModuleId");
//echo $this->db->last_query();die;
        foreach ($SQL->result_array() as $Row) {

            $Temp['ModuleId'] = $Row['ModuleId'];
            $Temp['varModuleName'] = $Row['ModuleName'];
            $Temp['Module'] = $Row['varTitle'];
            array_push($ModuleArray, $Temp);
        }
        return $ModuleArray;
    }

    function getAllUserAccess($id) {
        $sql_select = "select GROUP_CONCAT(fk_module_useraction) as userAccess from " . DB_PREFIX . "useraccess where fk_groups='" . $id . "' and chr_assign='Y' and chr_delete='N'";
        $result = $this->db->query($sql_select);
        $rs = $result->row();
        $userAccess = explode(",", $rs->userAccess);

        return $userAccess;
    }

    function getAllUsers($user_id) {

        if (USERTYPE == 'N') {
            $this->db->where_not_in("int_id", '1');
        } else if (USERTYPE == 'C') {
            $this->db->where_not_in("int_id", array('1', '2'));
        }
        $this->db->select('int_id, varName');
        $this->db->where(array("chrDelete" => 'N'));
        $SQL = $this->db->get("adminpanelusers");
        $RS = $SQL->Result();
        $UserDropDownHtml = "";
        $UserDropDownHtml .= "<select onchange='window.location.href=\"".ADMINPANEL_URL."user_management/groupaccess?fk_Userid=\"+this.value' name='fk_UserGlCode' class='md-input'  width='200px' id='fk_UserGlCode'><option value=''>Please Select User</option>";
        foreach ($RS as $User) {
            $selected = '';
            if (!empty($user_id) && $user_id == $User->int_id) {
                $selected = "selected";
            }
            $UserDropDownHtml .= "<option value='" . $User->int_id . "' $selected>" . $User->varName . "</option>";
        }
        $UserDropDownHtml .= "</select>";
        return $UserDropDownHtml;
    }

    function GetAssignedAcces($user_fk) {
        if (!empty($user_fk)) {
            $this->db->select("PUserGlCode, fk_ModuleGlCode, fk_useractionGlCode, chrAssign");
            $this->db->where(array("PUserGlCode" => $user_fk));
            $sql = $this->db->get("useraccess");
            $mainarray = array();
            $Result = $sql->Result();
            $i = 0;
            foreach ($Result as $row) {
                $mainarray[] = $row;
                $inner_web_arr[$row->fk_ModuleGlCode][$row->fk_useractionGlCode] = $row->chrAssign;
                $i++;
            }

            $return_array = array();
            $return_array['mainarray'] = $mainarray;
            $return_array['inner_web_array'] = $inner_web_arr;
            return $return_array;
        }
    }

}

?>
