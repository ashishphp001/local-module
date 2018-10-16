<?php

class projects_model extends CI_Model {

    var $int_id;
    var $intProject;
    var $varShortName;
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
    var $numofprojects; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'intDisplayOrder'; // Attribute of Deafult Order By
    var $OrderType = 'asc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of Org_calendarize For Paging
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
            $this->NumOfRows = $this->CountRow_front();
            $this->PageSize = (!empty($PageSize)) ? $PageSize : 12;
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
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt);
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal . $this->Appendfk_Country_Site;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        if ($flag == 'Y') {
            return $this;
        }
    }

    function generateParam($position = 'top') {

        $PageSize = $this->PageSize;
        return array(
            'PageUrl' => MODULE_PAGE_NAME,
            'heading' => 'Manage ' . MODULE_TITLE,
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'projects',
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
            'search' => array('searchArray' => array("varShortName" => "Title"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            )
        );
    }

//    function Select_All_projects_Record() {
//        $this->initialize();
//        $this->Generateurl();
//        $whereclauseids = ' chrDelete="N"';
//
//        if ($this->SearchTxt != '') {
//            $whereclauseids .= (empty($this->SearchBy)) ? " AND varShortName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
//        }
//
//        if ($this->FilterBy != '0') {
//            $filterarray = explode('-', $this->FilterBy);
//            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
//                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
//            }
//        }
//
//        $Type = $this->input->get_post('Type');
//        if (!empty($Type)) {
//            if ($Type == 'autosearch') {
//                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by p.intDisplayOrder asc';
//                $SearchByVal = " like '%" . addslashes($this->SearchTxt) . "%'";
//                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
//                    $this->SearchByVal = "varShortName";
//                }
//                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "projects as p where $whereclauseids group by varShortName $OrderBy");
//                $this->mylibrary->GetAutoSearch($autoSearchQry);
//            }
//        }
//
//        $this->db->select('int_id,intProject');
//        $this->db->where($whereclauseids, NULL, FALSE);
//        $this->db->from('projects');
//        $this->db->where("chrDelete = 'N'", NULL, FALSE);
//        $rsmatchedpagesids = $this->db->get();
////         echo $this->db->last_query();exit;
//        $pages = array();
//        foreach ($rsmatchedpagesids->result_array() as $row) {
//            $pages[] = $row['int_id'];
//            $pages[] = $row['intProject'];
//            if ($this->SearchTxt != '') {
//                while ($row['intProject'] != '0') {
//                    $sqlquery = "select int_id,intProject FROM " . DB_PREFIX . "projects where chrDelete='N' AND int_id='" . $row['intProject'] . "'";
//                    $res = $this->db->query($sqlquery);
//                    $row = $res->row_array();
//                    $pages[] = $row['intProject'];
//                }
//            }
//        }
//
//        $pages = array_unique($pages);
////        print_r($pages);exit;
//        $whereclause = '';
//        if (count($pages) > 0) {
//            $strinds = implode(',', $pages);
//            $whereclause .= " AND p.int_id IN ($strinds)";
//        } else {
//            $whereclause .= " AND p.int_id IN (0)";
//        }
//
//        $this->db->select('p.int_id AS id, p.varShortName AS name, p.intProject, p.*', false);
//        $this->db->select("(SELECT count(1) AS pagecount FROM " . DB_PREFIX . "projects AS p1 WHERE p1.intProject=p.intProject) AS pagecount", false);
//        $this->db->select("(SELECT count(1) AS total from " . DB_PREFIX . "projects AS p2 WHERE p2.intProject=p.int_id AND p2.chrDelete='N') AS Noofrows", false);
//        $this->db->select("(select count(0) as total from " . DB_PREFIX . "photogallery AS pg where pg.chrDelete='N' AND p.int_id=pg.fkProject) as totalPhotos", false);
//
//        $this->db->from('projects AS p', false);
//        $this->db->where("p.chrDelete = 'N' $whereclause", NULL, FALSE);
//
//        $this->db->order_by("p.intDisplayOrder", $this->OrderType);
//        $rs = $this->db->get();
//// echo $this->db->last_query();exit;
//
//        $children = array();
//        $pitems = array();
//        foreach ($rs->result_array() as $row) {
//            $pitems[] = $row;
//        }
//
//        if ($pitems) {
//            foreach ($pitems as $p) {
//                $fk_dbprefix_pages = 'intProject';
//                $pt = $p[$fk_dbprefix_pages];
//                $list = @$children[$pt] ? $children[$pt] : array();
//                array_push($list, $p);
//                $children[$pt] = $list;
//            }
//        }
//
//        $id = 0;
//        $list = array();
//        if ($id == 0) {
//            $list = $this->treerecurse($id, '', array(), $children, 10, 0);
//        } else {
//            foreach ($children as $key => $val) {
//                $list = $this->treerecurse($key, '&nbsp;&nbsp;&nbsp;', array(), $children, 10, 0);
//            }
//        }
//
//        if ($this->PageSize != 'All') {
//            $list = array_slice($list, $this->Start, $this->PageSize);
//        }
////        print_r($list);exit;
//        return $list;
//    }

    function Select_All_projects_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = "t.chrDelete ='N'"; //


        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varShortName like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
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
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by t.intDisplayOrder desc';
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "projects t where  $whereclauseids group by t.varShortName $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select("t.int_id AS id, t.varShortName AS name,t.*", false);
//        $this->db->select("(SELECT count(1) AS total from " . DB_PREFIX . "projects AS p2 WHERE p2.intProject=p.int_id AND p2.chrDelete='N') AS Noofrows", false);
//        $this->db->select('a.varAlias,a.int_id AS alias_id,a.intPageHits,a.intMobileHits', false);
//        $this->db->select("(select count(0) as total from " . DB_PREFIX . "photogallery AS pg where pg.chrDelete='N' AND t.int_id=pg.fkProject) as totalPhotos", false);
        $this->db->from('projects AS t', false);
//        $this->db->join('alias AS a', 'a.fk_Record = t.int_id', 'left', false);
        $this->db->where($whereclauseids);
        $this->db->order_by("$this->OrderBy", $this->OrderType);
        $this->db->group_by('t.int_id');

        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }

        $rs = $this->db->get();
        $row = $rs->result_array();
        return $row;
    }

    function CountRows() {
        $whereclauseids = "chrDelete ='N'";

        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varShortName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }

        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('projects');
        return $rs;
    }

    function Select_projects_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('T.chrDelete' => 'N', 'T.int_id' => $id);
        $this->db->select('T.*,a.varAlias,a.int_id as Alias_Id');
        $this->db->from('projects As T');
        $this->db->join('alias AS a', 'T.int_id = a.fk_Record AND a.fk_ModuleGlCode=' . MODULE_ID, 'left');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert($Images_Name = '') {
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'projects WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_projects();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/projects/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varImage']['name'];
            $Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $Imagesurl = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;

            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varImage')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        }


        $DisplayOrderClause = " AND intProject='" . $this->input->post('intProject') . "'";
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'projects WHERE chrDelete = "N" ' . $DisplayOrderClause . ' ');
        $rs = $query->row();
        $tot_recods = $rs->total;

        if ($tot_recods >= $this->input->post('int_displayorder')) {
            $this->mylibrary->UpdateInt_DisplayOrder('projects', $this->input->post('intDisplayOrder'), $DisplayOrderClause);
            $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        } else {
            $Int_DisplayOrder = $tot_recods + 1;
        }

//        $menudisplaydata = ($this->input->post('chrMenuDisplay') == 'Y') ? 'Y' : 'N';

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';



        $counter = $this->input->get_post('file_hd', true);

        for ($i = 1; $i <= $counter; $i++) {
            $varSTitle[] = strip_tags($this->input->get_post('varSTitle' . $i, true));
            $varSvalue[] = strip_tags($this->input->get_post('varSvalue' . $i, true));
        }
        $varSTi = implode("__", $varSTitle);
        $varSva = implode("__", $varSvalue);


        $tech = $this->input->post('intTechnology');
        if ($tech == '') {
            $technology = "";
        } else {
            $technology = implode(",", $tech);
            // $size = $size1;
        }


        $data = array(
            'varShortName' => $this->input->post('varShortName', TRUE),
//            'chrMenuDisplay' => $menudisplaydata,
            'intProject' => $this->input->post('intProject', TRUE),
            'varAndroidName' => $this->input->post('varAndroidName'),
            'varIOSName' => $this->input->post('varIOSName'),
            'varWebsiteName' => $this->input->post('varWebsiteName'),
            'intTechnology' => $technology,
            'chrImageFlag' => 'S',
            'varImage' => $Imagesurl,
            'varSTitle' => $varSTi,
            'varSvalue' => $varSva,
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'txtSpecification' => $this->input->post('txtSpecification', TRUE),
            'varShortDesc' => $this->input->post('varShortDesc', TRUE),
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'intDisplayOrder' => $Int_DisplayOrder,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
        );
//        print_r($data);
//        exit;
        $query = $this->db->insert(DB_PREFIX . 'projects', $data);
        $id = $this->db->insert_id();
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Insert_Alias($Alias_Array);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'projects', $DisplayOrderClause);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'projects', 'Name' => 'varShortName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update() {

//echo "hi";exit;
        $DisplayOrderClause = " AND intProject='" . $this->input->post('intProject') . "'";
        if ($this->input->post('intDisplayOrder') != $this->input->post('Old_DisplayOrder')) {

            $this->mylibrary->update_display_order_Ajax($this->input->post('ehintglcode'), $this->input->post('intDisplayOrder'), $this->input->post('Old_DisplayOrder'), '', 'pages', $DisplayOrderClause);
        }

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_projects();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];


        $tech = $this->input->post('intTechnology');
        if ($tech == '') {
            $technology = "";
        } else {
            $technology = implode(",", $tech);
            // $size = $size1;
        }

        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/projects/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varImage']['name'];
            $Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $Imagesurl = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('varImage')) {
                
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $Imagesurl = $this->input->post('hidd_VarImage');
        }


        $old_flag = $this->input->post('hidd_ImageFlag');
        if ($flag != $old_flag) {
            if ($flag == 'S' && $_FILES['varImage']['name'] == '') {
                $Imagesurl = '';
            } else {
                $Imagesurl = $Imagesurl;
            }
        }
//        $menudisplaydata = ($this->input->post('chrMenuDisplay') == 'Y') ? 'Y' : 'N';
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        $counter = $this->input->get_post('file_hd', true);


        for ($i = 1; $i <= $counter; $i++) {
            if (strip_tags($this->input->get_post('varSTitle' . $i, true)) != "" || strip_tags($this->input->get_post('varSvalue' . $i, true)) != "") {
                $varSTitle[] = strip_tags($this->input->get_post('varSTitle' . $i, true));
                $varSvalue[] = strip_tags($this->input->get_post('varSvalue' . $i, true));
            }
        }
        $varSTi = implode("__", $varSTitle);
        $varSva = implode("__", $varSvalue);


        $data = array(
            'varShortName' => $this->input->post('varShortName', TRUE),
//            'chrMenuDisplay' => $menudisplaydata,
            'intProject' => $this->input->post('intProject', TRUE),
            'varAndroidName' => $this->input->post('varAndroidName'),
            'varIOSName' => $this->input->post('varIOSName'),
            'varWebsiteName' => $this->input->post('varWebsiteName'),
            'intTechnology' => $technology,
            'chrImageFlag' => 'S',
            'varImage' => $Imagesurl,
            'varSTitle' => $varSTi,
            'varSvalue' => $varSva,
            'varShortDesc' => $this->input->post('varShortDesc', TRUE),
            'txtSpecification' => $this->input->post('txtSpecification', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'intDisplayOrder' => $Int_DisplayOrder,
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
//        print_r($data);exit;
        $id = $this->db->insert_id();

        $opertion = 'U';
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update(DB_PREFIX . 'projects', $data);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'projects', $DisplayOrderClause);

        $int_id = $this->input->get_post('ehintglcode');
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Update_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'projects', 'Name' => 'varShortName', 'ModuleintGlcode' => $int_id, 'Flag' => $opertion, 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
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

    function updatedisplayorder() {
        $this->db->cache_set_common_path("application/cache/db/common/projects/");
        $this->db->cache_delete();

        $uids = $this->input->get_post('uid');
        $neworder = $this->input->get_post('neworder');
        $oldorder = $this->input->get_post('oldorder');
        $fkpages = $this->input->get_post('pageid');

        if (empty($fkpages)) {
            $fkpages = 0;
        }

        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'projects', " AND intProject='" . $fkpages . "'");
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'projects', " AND intProject='" . $fkpages . "'");
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'projects';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d h-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'projects', 'Name' => 'varShortName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
            $this->mylibrary->insertinlogmanager($ParaArray);
            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'projects');
        }
    }

    function updateread() {
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

    function generate_seocontent_projects($fromajax = false) {
        $PageName = $this->input->post('varShortName', true);
        if ($fromajax) {
            $description = html_entity_decode(strip_tags($this->input->get_post('description', true)));
        } else {
            $description = strip_tags($this->input->post('varShortDesc', TRUE));
        }
        $meta_title = $PageName;
        $meta_keyword = $PageName;
        $meta_description = substr($description, 0, 400);
        $seo_data = $meta_title . '*****' . $meta_keyword . '*****' . $meta_description;
        return $seo_data;
    }

    function get_hits($id) {

        $this->db->where(array("fk_Record" => $id, "fk_ModuleGlCode" => "96"));
        $SQL = $this->db->get('alias');
        $RS = $SQL->Result();
        return $RS;
    }

    function get_Post_data($id) {

        $sql = "SELECT p.varShortName as varShortName,a.varAlias as varAlias,p.txtDescription as txtDescription,p.varImage as varImage  FROM " . DB_PREFIX . "projects as p
                LEFT JOIN " . DB_PREFIX . "alias as a ON a.fk_ModuleGlCode='104' AND a.fk_Record=p.int_id 
                WHERE p.chrDelete='N' AND p.chrPublish='Y' AND p.int_id='" . $id . "'";
        $qry = $this->db->query($sql);
        $result = $qry->row_array();
        $paramArr['int_id'] = $id;
        $packagelink = SITE_PATH . $result["varAlias"];
        $paramArr['data']['name'] = $this->input->get_post('varShortName');
        $paramArr["data"]["actions"] = array("name" => SITE_NAME, "link" => SITE_PATH);
        $paramArr['data']['link'] = $packagelink;

        $Short_Desc = htmlspecialchars($this->input->get_post('txtDescription'));
        $image = SITE_PATH . 'upimages/projects/' . $result['varImage'];
        $paramArr['data']['picture'] = $image;
        if (strlen($Short_Desc) > 100) {
            $Short_Desc = substr($Short_Desc, 0, 100) . "...";
        }
        $paramArr['data']['description'] = $Short_Desc;
        return $paramArr;
    }

    function get_publish_value($id) {
        $returnArry = array();
        $sql = "SELECT chrPublish FROM " . DB_PREFIX . "projects WHERE chrDelete='N' AND int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result['chrPublish'];
    }

    function getPhotoGallery($id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "photogallery WHERE chrDelete='N' and chrPublish='Y'  AND fkProject='" . $id . "' order by intDisplayOrder asc";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function CategoryFilter() {
//        echo "select pc.int_id AS id, pc.varShortName AS name from " . DB_PREFIX . "product as p left join " . DB_PREFIX . "productcategory as pc on pc.int_id = p.intSharePointCategory  where  p.chrDelete = 'N' group by pc.varShortName order by pc.intDisplayOrder asc";
        $query = $this->db->query("select pc.int_id AS id, pc.varShortName AS name from " . DB_PREFIX . "projects as p left join " . DB_PREFIX . "SharePointCategory as pc on pc.int_id = p.intSharePointCategory  where  p.chrDelete = 'N' group by pc.varShortName order by pc.intDisplayOrder asc");
        $returnHtml = "";
        $returnHtml .= "<select class=\"more-textarea \" style=\"float:left;margin-left:10px;\" id=\"CategoryFilter\" name=\"CategoryFilter\" onchange=\"SendGridBindRequest('$this->UrlWithPara&filtering=Y&PageNumber=1','gridbody','CATEGORY_FILTER');\">";
        $returnHtml .= "<option value=''>--Select Sharepoint  Category--</option>";
        foreach ($query->result() as $row) {
//            echo $row->id;
//            print_r($row);
            if ($row->id == $this->CategoryFilter) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row->id . '" ' . $selected . '>' . $row->name . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    public function SelectAll_front() {
        $flag = 'Y';
        $this->initialize($flag);
        $this->Generateurl($flag);
        $limitby = 'limit ' . $this->Start . ', ' . ABS($this->PageSize);
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "projects as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE A.fk_ModuleGlCode='96'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.intDisplayOrder asc $limitby";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function SelectAll_detail_front_id($id, $project) {
        $sqls = "select * from " . DB_PREFIX . "projects where chrDelete='N' and int_id='" . $id . "'";
        $querys = $this->db->query($sqls);
        $datas = $querys->row_array();

        if ($datas['intTechnology'] != '') {
            $as = explode(",", $datas['intTechnology']);
            foreach ($as as $row) {
                $sql = "select N.*,A.varAlias from " . DB_PREFIX . "projects as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='96' and FIND_IN_SET('" . $row . "',N.intTechnology) >0 and N.intProject='" . $project . "' and N.chrPublish='Y' and N.chrDelete='N' and N.int_id!='" . $id . "' group by N.int_id order by N.intDisplayOrder desc,N.int_id asc";
            }
        } else {
            $sql = "select N.*,A.varAlias from " . DB_PREFIX . "projects as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='96' and N.intProject='" . $project . "' and N.chrPublish='Y' and N.chrDelete='N' and N.int_id!='" . $id . "' group by N.int_id order by N.intDisplayOrder desc,N.int_id asc";
        }
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function CountRow_front() {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "projects as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='96'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.intDisplayOrder desc,N.int_id desc";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
//        echo $rowcount;
        return $rowcount;
    }

//    function getProjectList($id = '', $id1 = '') {
//        $query = $this->db->query("select * from " . DB_PREFIX . "projects where chrDelete = 'N' and intProject='0' order by intDisplayOrder asc");
//        $Result = $query->result();
//        $returnHtml = '';
//        $returnHtml .= "<select class=\"form-control\" id=\"intProject\" name=\"intProject\" >";
//        $returnHtml .= "<option value=''>--Select Project --</option>";
//        foreach ($Result as $row) {
//            if ($id == $row->int_id) {
//                $selected = 'selected="selected"';
//            } else {
//                $selected = '';
//            }
//            if ($row->int_id != $id1) {
//                $returnHtml .= '<option value="' . $row->int_id . '" ' . $selected . '>' . $row->varShortName . '</option>';
//            }
//        }
//        $returnHtml .= "</select>";
//        return $returnHtml;
//    }

    public function SelectAll_Detail_front($id) {
        $sql = "select * from " . DB_PREFIX . "projects where chrDelete='N' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getProjectData($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "projects as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE N.intProject='" . $id . "' and A.fk_ModuleGlCode='96'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.intDisplayOrder desc,N.int_id asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function Bindpageshierarchy($name, $selected_id, $class = 'listbox') {
//echo "here";
//        $NotShowString = array('1');

        $style = "style='display: none'";
        $dipnopar = "selected";

        $requesteid = $this->input->get_post('eid');
        $tempfk = "";
        $requesteid = !empty($requesteid) ? $requesteid : "";


        $wherearray = array('chrDelete' => 'N');
        $this->db->select('int_id AS id, varShortName AS name, intProject');
        $this->db->from('projects');
        $this->db->where($wherearray);

//        $this->db->where_not_in('int_id', $NotShowString);
        $this->db->order_by('intDisplayOrder', 'ASD');



        $res_pages = $this->db->get();
//echo $this->db->last_query();
        $children = array();
        $pitems = array();

        foreach ($res_pages->result_array() as $row) {
            $pitems[] = $row;
        }

        if ($pitems) {
            foreach ($pitems as $p) {
                $pt = $p['intProject'];
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $p);
                $children[$pt] = $list;
            }
        }

        $list = $this->treerecurse(0, '&nbsp;&nbsp;&nbsp;', array(), $children, 10, 0, 0);
        $display_output = '<select class="form-control" name="' . $name . '" id="' . $name . '"  size="10">';

//        if (USERTYPE == 'N') {
        $display_output .= "<option value=\"0\" " . (($selected_id == 0) ? $dipnopar : '') . ">No parent</option>";
//        }
        $temp1 = "";
        $temp = "";

        foreach ($list as $item) {
            if ($item['id'] == $_REQUEST['eid'] || $item['intProject'] == $_REQUEST['eid']) {
                $disabled = " disabled='disabled' ";
                $temp1 = $item['id'];
            } else if ($item['intProject'] == $temp || $item['intProject'] == $temp1 || $tempfk == $item['intProject']) {
                $disabled = " disabled='disabled' ";
                $temp = $item['id'];
                $tempfk = $item['intProject'];
            } else {
                $disabled = "";
            }
            $display_output .= "<option value=" . $item['id'] . " " . (($item['id'] == $selected_id) ? 'selected' : '') . " " . $disabled . " >" . $item['treename'] . "</option>";
        }
        $display_output .= "</select>";
        return $display_output;
    }

    function getTechnologyList($selected = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "technology where chrDelete = 'N' and intProject='0' order by intDisplayOrder asc");
        $Result = $query->result();
//        print_R($Result);exit;
        $returnHtml = '';
        $returnHtml .= "<select class=\"form-control\" id=\"intTechnology[]\" name=\"intTechnology[]\" multiple size='5'>";
        $returnHtml .= "<option value=''>--Select Technology --</option>";
        $sel = explode(",", $selected);
        foreach ($Result as $row) {
            $query1 = $this->db->query("select * from " . DB_PREFIX . "technology where chrDelete = 'N' and intProject='" . $row->int_id . "' order by intDisplayOrder asc");
            $Result1 = $query1->result();

//            if ($id == $row->int_id) {
            if (in_array($row->int_id, $sel)) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row->int_id . '" ' . $selected . '>' . $row->varName . '</option>';
            foreach ($Result1 as $row1) {
                $query2 = $this->db->query("select * from " . DB_PREFIX . "technology where chrDelete = 'N' and intProject='" . $row->int_id . "' order by intDisplayOrder asc");
                $Result2 = $query2->result();

                if (in_array($row1->int_id, $sel)) {
                    $selected1 = 'selected="selected"';
                } else {
                    $selected1 = '';
                }
                $returnHtml .= '<option value="' . $row1->int_id . '" ' . $selected1 . '>&nbsp;&nbsp; |_ ' . $row1->varName . '</option>';
            }
        }
        $returnHtml .= "</select>";
        return $returnHtml;
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

                if ($c['intProject'] == 0) {
                    $txt = $c['name'];
                    $Orderparent = $c['intDisplayOrder'];
                } else {
                    $txt = $pre . $c['name'];
                    $Orderparent = " . " . $c['intDisplayOrder'];
                }
                $pt = $c['intProject'];
                $list[$id] = $c;
                $list[$id]['treename'] = "$indent$txt";
                $list[$id]['children'] = count($children[$id]);
                $list[$id]['DisplayOrder'] = $Order . $Orderparent;
                $list = $this->treerecurse($id, $indent . $spacer, $list, $children, $maxlevel, $level + 1, $Type, $parent_order . $Orderparent);
            }
        }
        return $list;
    }

}

?>