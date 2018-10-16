<?php

class newsletterleads_model extends CI_Model {

    var $int_id;
    var $ParentPage_Id;
    var $varTitle;
    var $Var_Alias;
    var $Text_Fulltext;
    var $varMetaTitle;
    var $varMetaKeyword;
    var $varMetaDescription;
    var $intDisplayOrder;
    var $chrPublish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dtCreateDate;   // (normal Attribute)
    var $dtModifyDate;   // (normal Attribute)
    var $oldInt_DisplayOrder; // Attribute of Old Displayorder
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $NumOfPages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'dtCreateDate'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 0; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of PageSize For Paging
    var $PageNumber = '1'; // Attribute of Page Number For Paging(
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
    var $SortVar;

    public function __construct() {
        $this->ajax = $this->input->get_post('ajax');
        $this->ser_id = $this->input->get_post('ser_id');
        $this->load->helper(array('form', 'url'));
        $this->module_url = MODULE_URL;
    }

    function HeaderPanel() {
        $content['headerpanel'] = $this->mylibrary->generateHeaderPanel($this->generateParam(), 'no');
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
        $this->SearchBy = (!empty($SearchBy)) ? urldecode($SearchBy) : '';
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
        $this->AddPageName = MODULE_PAGE_NAME . '/add';
        $this->DeletePageName = MODULE_PAGE_NAME . '/Delete?';
        $ser_id = '&ser_id=' . $this->ser_id;
        $this->hurlwithpara = $this->PageName . '?' . 'hpagesize=' . $this->PageSize . '&hnumofrows=' . $this->NumOfRows . '&horderby=' . $this->OrderBy . '&hordertype=' . $this->OrderType . '&hsearchby=' . $this->SearchBy . '&hsearchtxt=' . htmlspecialchars($this->SearchTxt) . '&hpagenumber=' . $this->PageNumber . '&hfilterby=' . $this->FilterBy . '&history=T' . '&mainmodule=' . 'newsletterleads';
        $this->UrlWithPara = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'newsletterleads';
        $this->UrlWithoutSort = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars_decode(urlencode($this->SearchTxt)) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'newsletterleads';
        $this->UrlWithoutPaging = $this->PageName . '?OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'newsletterleads';
        $this->UrlWithoutFilter = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&mainmodule=' . 'newsletterleads';
        $this->AutoSearchUrl = $this->UrlWithPara . "&type=autosearch&SearchByVal=" . $this->SearchByVal . $this->Appendfk_Country_Site . '&mainmodule=' . 'newsletterleads';
        $this->AddUrlWithpara = $this->AddPageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . $this->Appendfk_Country_Site . '&mainmodule=' . 'newsletterleads';
    }

    function generateParam($position = 'top') {

        $PageSize = $this->PageSize;



        return array('PageUrl' => MODULE_PAGE_NAME,
            'heading' => 'Manage News Letter Subscribers',
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'newsletterleads',
            'position' => $position,
            'actionImage' => 'add-new-button-blue.gif',
            'actionImageHover' => 'add-new-button-blue-hover.gif',
//            'actionUrl' => MODULE_PAGE_NAME . '/add?&PageSize=' . $PageSize . '&fk_Service=' . $_REQUEST['fk_Service'],
            'dispPaging' => 'Yes',
            'AutoSearchUrl' => $this->AutoSearchUrl,
            'display' => array('DisplayUrl' => $this->UrlWithoutPaging,
                'PageSize' => $this->PageSize,
                'LimitArray' => $this->Display_Limit_Array,
            ),
            'paging' => array(
                'PageNumber' => $this->PageNumber,
                'NoOfPages' => $this->NoOfPages,
                'NumOfRows' => $this->NumOfRows,
                'PagingUrl' => $this->UrlWithPara
            ),
            'search' => array('searchArray' => array("varEmail" => "Email ID"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
            'fk_Service' => $fk_Service,
        );
    }

    function SelectAll() {
        $this->initialize();
        $this->Generateurl();
        $OrderBy = (isset($this->OrderBy)) ? 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType : 'ORDER BY intDisplayOrder ASC';
        $whereclauseids = "chrDelete = 'N'";

        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {

            $whereclauseids .= (empty($this->SearchBy)) ? " AND varEmail LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";

            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
                }
            }
        }
        $type = $this->input->get_post('type');
        if (!empty($type)) {
            if ($type == 'autosearch') {
                $OrderBy = (isset($this->OrderBy)) ? 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType : 'ORDER BY intDisplayOrder ASC';

                $SearchByVal = " LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'  AND chrDelete = 'N'";
                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
                    $this->SearchByVal = "varEmail";
                }
                $this->db->select("*,$this->SearchByVal AS AutoVal");
                $this->db->from('newsletterleads', false);
                $this->db->where("$this->SearchByVal $SearchByVal", null, FALSE);
                $this->db->group_by("varEmail $OrderBy");
                $autoSearchQry = $this->db->get();
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }
        $this->db->select('*,DATE_FORMAT(dtCreateDate, "' . DEFAULT_TIMEFORMAT . '") AS Date', false);
        $this->db->from('newsletterleads', false);
        $this->db->where("$whereclauseids $whereclauseids1", NULL, FALSE);
        $this->db->order_by($this->OrderBy, $this->OrderType);
        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }
        $rs = $this->db->get();
        return $rs;
    }

    function CountRows() {

        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {
            if ($this->SearchTxt != '') {
                $whereclauseids .= (empty($this->SearchBy)) ? " AND varEmail LIKE '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes($this->SearchTxt) . "%'";
            }
            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  and  $filterarray[0] = '$filterarray[1]'";
                }
            }
        }

        $this->db->where(" chrDelete='N' $whereclauseids $whereclauseids1", Null, FALSE);
        $rs = $this->db->count_all_results('newsletterleads');
        return $rs;
    }

    function Delete_Row() {
        $tablename = DB_PREFIX . 'newsletterleads';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $ModuleData = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $ModuleData);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'newsletterleads', 'Name' => 'varEmail', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => D, 'Default' => int_id, 'fk_Site' => $SiteSelected);
            $this->mylibrary->insertinlogmanager($ParaArray);
        }
    }

    function Export() {
        $this->load->helper('csv');
        $selectids = $this->input->get_post('chkids');
        $selectarray = explode(',', $selectids);
        $totaldeletedrecords = count($selectarray);
        $exportarry = array();
        $whereclauses = '';
        if ($this->input->get_post('searchtxt_ids', TRUE) != '') {
            $searchdata .= $this->input->get_post('searchtxt_ids', TRUE);
            $whereclauses .= " AND varEmail LIKE'%" . $this->db->escape_like_str($searchdata) . "%'";
        } else {
            $whereclauses .= "";
        }
        if ($this->input->get_post('orderby') != '' && $this->input->get_post('ordertype') != '') {
            $type = "";
            if ($this->input->get_post('ordertype') == 'ASC' || $this->input->get_post('ordertype') == 'asc') {
                $type = " DESC";
            }
            if ($this->input->get_post('ordertype') == 'DESC' || $this->input->get_post('ordertype') == 'desc') {
                $type = " ASC";
            }
            $orderby = $this->input->get_post('orderby');
        } else {
            $orderby = 'dtCreateDate';
            $type = " DESC";
        }
        if (DEFAULT_DATEFORMAT == '%M/%d/%Y') {
            $dateformat = "%b/%d/%Y";
        } else {
            $dateformat = DEFAULT_DATEFORMAT;
        }
        if ($this->ser_id != '') {
            $whereclauseids = " and ser_id='" . $this->ser_id . "'";
        } else {
            $whereclauseids = "";
        }


        $this->db->select('*,DATE_FORMAT(dtCreateDate, "' . DEFAULT_TIMEFORMAT . '") AS Time', false);
        $this->db->from('newsletterleads', false);
        $this->db->where("chrDelete = 'N' $whereclauseids $whereclauses");
        if ($selectids != '') {
            $this->db->where("int_id IN($selectids)");
        }
        $this->db->order_by($this->OrderBy, $this->OrderType);
        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }
        $rs = $this->db->get();
        $query = $rs->result_array();
        $site_name = str_replace(' ', '_', SITE_NAME);
        $filename = $site_name . "_newsletterleads_" . date("dmy-h:i") . ".xls";
        $fileprefix = "newsletterleads";
        $gridbind = "<table border=1>";
        $gridbind .= "<tr width=100><b><center>" . $fileprefix . "</center></b></tr>";
        $gridbind .= "<tr>";
        $gridbind .= "<th>Email ID</th>";
        $gridbind .= "<th>Date</th>";
        $gridbind .= "<th>Time</th>";
        $gridbind .= "</tr>";
        foreach ($query as $row) {
            $rowcount = 0;
            $gridbind .= "<tr>";
            $gridbind .= "<td valign='top'>" . $row["varEmail"] . "</td>";
            $gridbind .= "<td valign='top'>" . date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($row['dtCreateDate'])) . "</td>";
            $gridbind .= "<td valign='top'>" . $row['Time'] . "</td>";
            $gridbind .= "</tr>";
            $rowcount_a++;
        }
        if ($leadlistid != "") {
            $leadlistid .= ",";
        }
        $leadlistid .= $row['int_id'];
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename . "");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $gridbind;
        exit;
    }

    function ContactLeadsData() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('newsletterleads');
        $this->db->where($wherecondtion);
        $this->db->limit(5, 0);
        $Query = $this->db->get();
        return $Query;
    }

}

?>