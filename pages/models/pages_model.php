<?php

class pages_model extends CI_Model {

    var $int_id;
    var $fk_ParentPageGlCode;
    var $varTitle;
    var $varAlias;
    var $text_fulltext;
    var $varMetaTitle;
    var $varMetaKeyword;
    var $varMetaDescription;
    var $intDisplayOrder;
    var $chr_access = 'P';
    var $chr_publish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dt_createdate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $chr_star;
    var $chr_read;   // (normal Attribute)
    var $oldintDisplayOrder; // Attribute of Old Displayorder
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $numofpages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'intDisplayOrder'; // Attribute of Deafult Order By
    var $OrderType = 'asc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of Pagesize For Paging
    var $rPageSize = RIGHT_PANEL_PAGESIZE;
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

    public function __construct() {
        $this->load->database();
        $this->load->library('mylibrary');
        $mylibraryObj = new mylibrary;
        $this->ajax = $this->input->get_post('ajax');
        $this->module_url = MODULE_URL;
    }

    function general() {
        $data['base'] = $this->config->item('base_url');
        $data['css'] = $this->config->item('css');
        $data['img'] = $this->config->item('images');
        return $data;
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
        $this->NumOfRows = $this->CountRows();
        $this->PageSize = (!empty($PageSize)) ? $PageSize : $this->PageSize;
        $this->PageNumber = (!empty($PageNumber)) ? $PageNumber : $this->PageNumber;
        $this->NoOfPages = intval($this->NumOfRows / $this->PageSize);
        $this->NoOfPages = (($this->NumOfRows % $this->PageSize) > 0) ? ($this->NoOfPages + 1) : ($this->NoOfPages);
        $this->Start = ($this->PageNumber - 1 ) * $this->PageSize;
    }

    function Generateurl() {
        $this->PageName = MODULE_PAGE_NAME . '?';
        $this->AddPageName = MODULE_PAGE_NAME . '/add?';

        $this->DeletePageName = MODULE_PAGE_NAME . '/delete?';
        $this->HUrlWithPara = $this->PageName . '&' . 'hPageSize=' . $this->PageSize . '&hNumOfRows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hOrderType=' . $this->OrderType . '&hSearchBy=' . $this->SearchBy . '&hSearchTxt=' . urlencode($this->SearchTxt) . '&hPageNumber=' . $this->PageNumber . '&PageSize=' . $this->PageSize . '&hFilterBy=' . $this->FilterBy . '&history=T';
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&PageSize=' . $this->PageSize . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithOutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&PageSize=' . $this->PageSize . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithOutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt);
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&PageSize=' . $this->PageSize . '&FilterBy=' . $this->FilterBy;
    }

    function generateParam($position = 'top') {
        $PageSize = $this->PageSize;
        return array(
            'pageurl' => MODULE_PAGE_NAME . '?',
            'heading' => 'Manage' . ' ' . MODULE_TITLE,
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'pages',
            'position' => $position,
            'actionImage' => 'add-new-button-blue.gif',
            'actionImageHover' => 'add-new-button-blue-hover.gif',
            'actionUrl' => MODULE_PAGE_NAME . '/add?&PageSize=' . $PageSize . $this->Appendfk_Country_Site,
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
            'search' => array('searchArray' => array("varTitle" => "Title"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
        );
    }

    function Select_All_pages_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = ' chrDelete="N"';
        if (ADMIN_ID == '2') {
            $whereclauseids = ' int_id not in (18) and chrDelete="N"';
        }
        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varTitle like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }

        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }

        $Type = $this->input->get_post('Type');
        if (!empty($Type)) {
            if ($Type == 'autosearch') {
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by intDisplayOrder asc';
                $SearchByVal = " like '%" . addslashes($this->SearchTxt) . "%'";
                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
                    $this->SearchByVal = "varTitle";
                }
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "pages where $whereclauseids group by varTitle $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select('int_id,fk_ParentPageGlCode');
        $this->db->where($whereclauseids, NULL, FALSE);
        $this->db->from('pages');
        $this->db->where("chrDelete = 'N'", NULL, FALSE);
        $rsmatchedpagesids = $this->db->get();
        $pages = array();
        foreach ($rsmatchedpagesids->result_array() as $row) {
            $pages[] = $row['int_id'];
            $pages[] = $row['fk_ParentPageGlCode'];
            if ($this->SearchTxt != '') {
                while ($row['fk_ParentPageGlCode'] != '0') {
                    $sqlquery = "select int_id,fk_ParentPageGlCode FROM " . DB_PREFIX . "pages where chrDelete='N' AND int_id='" . $row['fk_ParentPageGlCode'] . "'";
                    $res = $this->db->query($sqlquery);
                    $row = $res->row_array();
                    $pages[] = $row['fk_ParentPageGlCode'];
                }
            }
        }

        $pages = array_unique($pages);
        $whereclause = '';
        if (count($pages) > 0) {
            $strinds = implode(',', $pages);
            $whereclause .= " AND p.int_id IN ($strinds)";
        } else {
            $whereclause .= " AND p.int_id IN (0)";
        }

        $this->db->select('p.int_id AS id, p.varTitle AS name, p.fk_ParentPageGlCode, p.*', false);
        $this->db->select('m.varModuleName,m.varTitle AS module,m.chrAdminPanel, a.varAlias,a.int_id AS alias_id,a.intPageHits', false);
        $this->db->select("(SELECT count(1) AS pagecount FROM " . DB_PREFIX . "pages AS p1 WHERE p1.fk_ParentPageGlCode=p.fk_ParentPageGlCode) AS pagecount", false);
        $this->db->select("(SELECT count(1) AS total from " . DB_PREFIX . "pages AS p2 WHERE p2.fk_ParentPageGlCode=p.int_id AND p2.chrDelete='N') AS Noofrows", false);

        $this->db->from('pages AS p', false);
        $this->db->join('modules AS m', 'm.int_id = p.fk_ModuleGlCode', 'left', false);
        $this->db->join('alias AS a', 'a.fk_Record = p.int_id', 'left', false);
        $this->db->where("p.chrDelete = 'N' $whereclause", NULL, FALSE);

        if (ADMIN_ID == '2') {
            $Int_Glcode = array('18');
            $this->db->where_not_in('p.int_id', $Int_Glcode);
        }

        $this->db->order_by("$this->OrderBy", $this->OrderType);
        $rs = $this->db->get();

        $children = array();
        $pitems = array();
        foreach ($rs->result_array() as $row) {
            $pitems[] = $row;
        }

        if ($pitems) {
            foreach ($pitems as $p) {
                $fk_dbprefix_pages = 'fk_ParentPageGlCode';
                $pt = $p[$fk_dbprefix_pages];
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $p);
                $children[$pt] = $list;
            }
        }

        $id = 0;
        $list = array();
        if ($id == 0) {
            $list = $this->treerecurse($id, '', array(), $children, 10, 0);
        } else {
            foreach ($children as $key => $val) {
                $list = $this->treerecurse($key, '&nbsp;&nbsp;&nbsp;', array(), $children, 10, 0);
            }
        }

//        if ($this->PageSize != 'All') {
//            $list = array_slice($list, $this->Start, $this->PageSize);
//        }
        return $list;
    }

    function CountRows() {
        $whereclauseids = "chrDelete ='N' ";
//if (ADMIN_ID == '2') {
//            $whereclauseids = ' int_id not in (18) and chrDelete="N"';
//        }
        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varTitle like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }
        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('pages');
        return $rs;
    }

    function Select_Pages_Rows($id) {
        $this->db->cache_set_common_path("application/cache/db/common/pages/");
        $this->db->cache_delete();

        $returnArry = array();
        $wherecondtion = array('p.chrDelete' => 'N', 'p.int_id' => $id);
        $this->db->select('p.*,a.varAlias,a.int_id as Alias_Id');
        $this->db->from('pages As p');
        $this->db->join('alias AS a', 'p.int_id = a.fk_Record AND a.fk_ModuleGlCode=' . MODULE_ID, 'left');
        $this->db->where($wherecondtion);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Get_Child($id) {
        $wherecondition = array('chrDelete' => 'N', 'fk_ParentPageGlCode' => $id);
        $this->db->select('*');
        $this->db->from('pages');
        $this->db->where($wherecondition);
        $result = $this->db->get();
        $returnArray = $result->num_rows();

        return $returnArray;
    }

    function GetTotalEntry() {
        $sql_total_entry = "SELECT * FROM " . DB_PREFIX . "pages where chrDelete='N'";
        $data_total_entry = $this->db->query($sql_total_entry);
        $rs_total_entry = $data_total_entry->num_rows();
        return $rs_total_entry;
    }

    function Select_footermenudata() {
        $sql_total_entry = "SELECT *,COUNT(DISTINCT chrFooterDisplay) as footercounter FROM " . DB_PREFIX . "pages where chrDelete='N' and chrPublish='Y' and chrFooterDisplay='Y'";
        $data_total_entry = $this->db->query($sql_total_entry);
        $rs_total_entry = $data_total_entry->num_rows();
        return $rs_total_entry['footercounter'];
    }

    function Insert() {
        $this->db->cache_set_common_path("application/cache/db/common/pages/");
        $this->db->cache_delete();

        $DisplayOrderClause = " AND fk_ParentPageGlCode='" . $this->input->post('fk_ParentPageGlCode') . "'";
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'pages WHERE chrDelete = "N" ' . $DisplayOrderClause . ' ');
        $rs = $query->row();
        $tot_recods = $rs->total;

        if ($tot_recods >= $this->input->post('int_displayorder')) {
            $this->mylibrary->UpdateInt_DisplayOrder('pages', $this->input->post('intDisplayOrder'), $DisplayOrderClause);
            $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        } else {
            $Int_DisplayOrder = $tot_recods + 1;
        }

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_pages();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $menudisplaydata = ($this->input->post('chrMenuDisplay') == 'on') ? 'Y' : 'N';
        $Discdisplaydata = ($this->input->post('chrDiscDisplay') == 'on') ? 'Y' : 'N';
        $chrDescriptionDisplay = ($this->input->post('chrDescriptionDisplay') == 'on') ? 'Y' : 'N';
        $FooterDisplaydata = ($this->input->post('chrFooterDisplay') == 'on') ? 'Y' : 'N';

        $data = array(
            'fk_ModuleGlCode' => $this->input->post('fk_ModuleGlCode', TRUE),
            'fk_ParentPageGlCode' => $this->input->post('fk_ParentPageGlCode', TRUE),
            'varTitle' => $this->input->post('varTitle', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'chrMenuDisplay' => $menudisplaydata,
            'chrFooterDisplay' => $FooterDisplaydata,
            'chrDescriptionDisplay' => $chrDescriptionDisplay,
            'chrDiscriptionDisplay' => $Discdisplaydata,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'intDisplayOrder' => $Int_DisplayOrder,
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
//print_R($data);exit;
        $query = $this->db->insert(DB_PREFIX . 'pages', $data);
        $id = $this->db->insert_id();
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $this->input->post('varAlias', TRUE));

        $this->common_model->Insert_Alias($Alias_Array);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'pages', $DisplayOrderClause);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'pages', 'Name' => 'varTitle', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update() {
//        echo "<pre>";
//        print_R($this->input->post());exit;
//       echo "123";exit;
        $this->db->cache_set_common_path("application/cache/db/common/pages/");
        $this->db->cache_delete();

        $DisplayOrderClause = " AND fk_ParentPageGlCode='" . $this->input->post('fk_ParentPageGlCode') . "'";
        if ($this->input->post('intDisplayOrder') != $this->input->post('Old_DisplayOrder')) {

            $this->mylibrary->update_display_order_Ajax($this->input->post('ehintglcode'), $this->input->post('intDisplayOrder'), $this->input->post('Old_DisplayOrder'), '', 'pages', $DisplayOrderClause);
        }

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_pages();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';


        $menudisplaydata = ($this->input->post('chrMenuDisplay') == 'on') ? 'Y' : 'N';
        $Discdisplaydata = ($this->input->post('chrDiscDisplay') == 'on') ? 'Y' : 'N';
        $chrDescriptionDisplay = ($this->input->post('chrDescriptionDisplay') == 'on') ? 'Y' : 'N';
        $FooterDisplaydata = ($this->input->post('chrFooterDisplay') == 'on') ? 'Y' : 'N';

        $data = array(
            'fk_ModuleGlCode' => $this->input->post('fk_ModuleGlCode', TRUE),
            'fk_ParentPageGlCode' => $this->input->post('fk_ParentPageGlCode', TRUE),
            'varTitle' => $this->input->post('varTitle', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post(htmlspecialchars_decode('txtDescription'))),
            'chrMenuDisplay' => $menudisplaydata,
            'chrFooterDisplay' => $FooterDisplaydata,
            'chrDescriptionDisplay' => $chrDescriptionDisplay,
            'chrDiscriptionDisplay' => $Discdisplaydata,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'intDisplayOrder' => $this->input->post('intDisplayOrder', TRUE)
        );
//        echo "<pre>";
//print_r($data);exit;
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update(DB_PREFIX . 'pages', $data);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'pages', $DisplayOrderClause);

        $int_id = $this->input->get_post('ehintglcode');
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));

        $this->common_model->Update_Alias($Alias_Array);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'pages', 'Name' => 'varTitle', 'ModuleintGlcode' => $int_id, 'Flag' => 'U', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
    }

    function updatedisplayorder() {
        $this->db->cache_set_common_path("application/cache/db/common/pages/");
        $this->db->cache_delete();

        $uids = $this->input->get_post('uid');
        $neworder = $this->input->get_post('neworder');
        $oldorder = $this->input->get_post('oldorder');
        $fkpages = $this->input->get_post('pageid');
//echo $oldorder;exit;updatedisplayorder
        if (empty($fkpages)) {
            $fkpages = 0;
        }

        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'pages', " AND fk_ParentPageGlCode='" . $fkpages . "'");
// echo "hi";exit;    
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'pages', " AND fk_ParentPageGlCode='" . $fkpages . "'");
    }

    function delete_row() {
        $this->db->cache_set_common_path("application/cache/db/common/pages/");
        $this->db->cache_delete();

        $tablename = DB_PREFIX . 'pages';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['SERVER_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);

            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'pages', 'Name' => 'varTitle', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id');

            $this->mylibrary->insertinlogmanager($ParaArray);

            $this->db->select('fk_ParentPageGlCode,intDisplayOrder');
            $this->db->from('pages');
            $this->db->where('int_id', $deletearray[$i]);
            $result = $this->db->get();
            foreach ($result->result_array() as $row) {
                $parent = $row['fk_ParentPageGlCode'];
                $intDisplayOrder = $row['intDisplayOrder'];
            }

            $sql = "UPDATE " . $tablename . " SET intDisplayOrder = (intDisplayOrder-1) where intDisplayOrder > " . $intDisplayOrder . " and chrDelete='N' and fk_ParentPageGlCode='" . $parent . "' order by intDisplayOrder";
            $this->db->query($sql);
        }
    }

    public function getParentRecord() {

        $sqlCountPages = "select * FROM " . DB_PREFIX . "pages where chrDelete='N' and chrPublish='Y' and fk_ParentPageGlCode=0";
        $query = $this->db->query($sqlCountPages);
        $rs = $query->num_rows();
        return $rs;
    }

    function Bindpageshierarchy($name, $selected_id, $class = 'listbox') {

        $NotShowString = array('1');

        $style = "style='display: none'";
        $dipnopar = "selected";

        $requesteid = $this->input->get_post('eid');
        $tempfk = "";
        $requesteid = !empty($requesteid) ? $requesteid : "";


        $wherearray = array('chrDelete' => 'N');
        $this->db->select('int_id AS id, varTitle AS name, fk_ParentPageGlCode');
        $this->db->from('pages');
        $this->db->where($wherearray);

        $this->db->where_not_in('int_id', $NotShowString);
        $this->db->order_by('intDisplayOrder', 'ASD');



        $res_pages = $this->db->get();

        $children = array();
        $pitems = array();

        foreach ($res_pages->result_array() as $row) {
            $pitems[] = $row;
        }

        if ($pitems) {
            foreach ($pitems as $p) {
                $pt = $p['fk_ParentPageGlCode'];
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $p);
                $children[$pt] = $list;
            }
        }

        $list = $this->treerecurse(0, '&nbsp;&nbsp;&nbsp;', array(), $children, 10, 0, 0);
        $display_output = '<select class="md-input" name="' . $name . '" id="' . $name . '"  size="10">';

//        if (USERTYPE == 'N') {
        $display_output .= "<option value=\"0\" " . (($selected_id == 0) ? $dipnopar : '') . ">No parent</option>";
//        }
        $temp1 = "";
        $temp = "";

        foreach ($list as $item) {
            if ($item['id'] == $_REQUEST['eid'] || $item['fk_ParentPageGlCode'] == $_REQUEST['eid']) {
                $disabled = " disabled='disabled' ";
                $temp1 = $item['id'];
            } else if ($item['fk_ParentPageGlCode'] == $temp || $item['fk_ParentPageGlCode'] == $temp1 || $tempfk == $item['fk_ParentPageGlCode']) {
                $disabled = " disabled='disabled' ";
                $temp = $item['id'];
                $tempfk = $item['fk_ParentPageGlCode'];
            } else {
                $disabled = "";
            }
            $display_output .= "<option value=" . $item['id'] . " " . (($item['id'] == $selected_id) ? 'selected' : '') . " " . $disabled . " >" . $item['treename'] . "</option>";
        }
        $display_output .= "</select>";
        return $display_output;
    }

    function treerecurse($id, $indent, $list = Array(), $children = Array(), $maxlevel = '10', $level = 0, $Type = 1, $Order = '') {
        $c = "";

        if ($children[$id] && $level <= $maxlevel) {
            foreach ($children[$id] as $c) {
                $id = $c['id'];

                if ($Type) {
                    $pre = '<sup>|_</sup>&nbsp;';
                    $spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $parent_order = $Order;
                } else {
                    $pre = '|_ ';
                    $spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }

                if ($c['fk_ParentPageGlCode'] == 0) {
                    $txt = $c['name'];
                    $Orderparent = $c['intDisplayOrder'];
                } else {
                    $txt = $pre . $c['name'];
                    $Orderparent = " . " . $c['intDisplayOrder'];
                }
                $pt = $c['fk_ParentPageGlCode'];
                $list[$id] = $c;
                $list[$id]['treename'] = "$indent$txt";
                $list[$id]['children'] = count($children[$id]);
                $list[$id]['DisplayOrder'] = $Order . $Orderparent;
                $list = $this->treerecurse($id, $indent . $spacer, $list, $children, $maxlevel, $level + 1, $Type, $parent_order . $Orderparent);
            }
        }
        return $list;
    }

    function GetEnableModules($id, $selected = '') {
        $wherearray = array('chrDelete' => 'N', 'chrFront' => 'Y');
        $this->db->select('varModuleName,int_id');
        $this->db->from('modules');
        $this->db->where($wherearray);
        $this->db->order_by('varModuleName', 'asc');
        $result = $this->db->get();
        $data = $result->result_array();

        $otherString = ' id="' . $id . '" class="md-input"';
        $selected_ids = Array();
        if (!empty($selected)) {
            $selected = $selected;
        } else {
            $selected = '2';
        }

        array_push($selected_ids, $selected);
        $options = Array();
        foreach ($result->result_array() as $row) {
            $options[$row['int_id']] = ucwords($row['varModuleName']);
        }
        $display_output = form_dropdown($id, $options, $selected_ids, 'id="' . $id . '" class="md-input"');
        return $display_output;
    }

    function updateread() {
        $this->db->cache_set_common_path("application/cache/db/common/pages/");
        $this->db->cache_delete();

        $tablename = $_REQUEST['tablename'];
        $fieldname = $_REQUEST['fieldname'];
        $value = $_REQUEST['value'];
        $id = $_REQUEST['id'];

        $id_ARRAY = explode(",", $id);
        foreach ($id_ARRAY as $id_value) {
            $query = "update " . $tablename . " set " . $fieldname . "='" . $value . "' where int_id='" . $id_value . "'";
            $result = $this->db->query($query);
        }

        return 1;
    }

    function generate_seocontent_pages($fromajax = false) {
        $PageName = $this->input->post('varTitle', true);
        if ($fromajax) {
            $description = html_entity_decode(strip_tags($this->input->get_post('description', true)));
        } else {
            $description = strip_tags($this->input->post('txtDescription', TRUE));
        }
        $meta_title = $PageName;
        $meta_keyword = $PageName;
        $meta_description = substr($description, 0, 400);
        $seo_data = $meta_title . '*****' . $meta_keyword . '*****' . $meta_description;
        return $seo_data;
    }

    public function Validate() {
        $UserName = $this->security->xss_clean($this->input->post('varLoginEmail'));
        $Password = $this->security->xss_clean($this->input->post('varPassword'));

        $cond = "varLoginEmail = '" . $UserName . "' AND varPassword = '" . $this->mylibrary->cryptPass($Password) . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
        $this->db->where($cond);
        $query = $this->db->get('AdminPanelUsers');

        if ($query->num_rows == 1) {
            $row = $query->row();
            $Data = array(
                'UserId' => $row->int_id,
                'UserLoginEmail' => $row->varLoginEmail,
                'UserName' => $row->varName,
                'UserType' => $row->varUserType,
                'Login_Log_Id' => $id,
                'Validated' => true
            );
            $this->session->set_userdata($Data);
            if ($this->input->get_post("chkrememberme") != "") {
                $OneYear = 365 * 24 * 3600; // one year's time.
                $Usercookie_Info = array('user' => $UserName, 'time' => time(), 'pwd' => $Password, 'takemeto' => $takemeto, 'chkrememberme' => '1');
                $this->mylibrary->requestSetCookie('tml_CookieLogin', $Usercookie_Info, $OneYear);
            } else {
                $this->mylibrary->requestRemoveCookie('tml_CookieLogin');
            }
            return true;
        }
        return false;
    }

    function get_hits($id) {
        $this->db->cache_set_common_path("application/cache/db/common/pages/");
        $this->db->cache_delete();

        $this->db->where(array("fk_Record" => $id, "fk_ModuleGlCode" => "2"));
        $SQL = $this->db->get('alias');

        $RS = $SQL->Result();
        return $RS;
    }

    function Select_Fooeter_Rows($id) {
        $returnArry = array();
        $sql = "SELECT *,count(chrFooterDisplay) FROM " . DB_PREFIX . "pages WHERE chrDelete='N' and chrPublish='Y' and chrFooterDisplay='Y'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

    function selectAll_commonfiles() {
        $query = "select * from " . DB_PREFIX . "commonfiles where chrDelete = 'N' and chrPublish='Y'";
        $result = $this->db->query($query);
        return $result;
    }

}

?>