<?php

class blogs_model extends CI_Model {

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
    var $numofblogs; // Attribute of Num Of Pagues In Result
    var $OrderBy = 't.dtBlogDate'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
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
            $this->PageSize = (!empty($PageSize)) ? $PageSize : 15;
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
            'tablename' => DB_PREFIX . 'blogs',
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
            )
        );
    }

    function Select_All_blogs_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = "t.chrDelete ='N'"; //


        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varTitle like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
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
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "blogs t where  $whereclauseids group by t.varTitle $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select("t.int_id AS id, t.varTitle AS name,t.*", false);
//        $this->db->select('a.varAlias,a.int_id AS alias_id,a.intPageHits,a.intMobileHits', false);

        $this->db->from('blogs AS t', false);
//        $this->db->join('alias AS a', 'a.fk_Record = t.int_id', 'left', false);
        $this->db->where($whereclauseids);
        $this->db->order_by("$this->OrderBy", $this->OrderType);
        $this->db->group_by('t.int_id');

//        if ($this->PageSize != 'All') {
//            $this->db->limit($this->PageSize, $this->Start);
//        }

        $rs = $this->db->get();
        $row = $rs->result_array();
        return $row;
    }

    function CountRows() {
        $whereclauseids = "chrDelete ='N'";

        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varTitle like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }

        if ($this->CategoryFilter != '') {
            $whereclauseids .= " AND intSharePointCategory = $this->CategoryFilter ";
        }

        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('blogs');
        return $rs;
    }

    function Select_blogs_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('T.chrDelete' => 'N', 'T.int_id' => $id);
        $this->db->select('T.*,a.varAlias,a.int_id as Alias_Id');
        $this->db->from('blogs As T');
        $this->db->join('alias AS a', 'T.int_id = a.fk_Record AND a.fk_ModuleGlCode=' . MODULE_ID, 'left');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert($Images_Name = '') {
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'blogs WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_blogs();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/blogs/images/';
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

        if ($_FILES['varImage1']['name'] != '') {
            $config['upload_path'] = 'upimages/blogs/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varImage1']['name'];
            $Imagesurl1 = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $Imagesurl1 = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varImage1')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        }
        if ($tot_recods >= $this->input->post('intDisplayOrder')) {
            $this->mylibrary->UpdateInt_DisplayOrder('blogs', $this->input->post('intDisplayOrder'), $DisplayOrderClause);
            $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        } else {
            $Int_DisplayOrder = $tot_recods + 1;
        }

        $dtBlogDate1 = $this->input->post('dtBlogDate');
        $dtBlogDate = date("Y-m-d", strtotime($dtBlogDate1));



        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';


        $data = array(
            'varAuthor' => $this->input->post('varAuthor', TRUE),
            'varType' => $this->input->post('varType', TRUE),
            'varTitle' => $this->input->post('varTitle', TRUE),
            'chrImageFlag' => 'S',
            'chrImageFlag1' => 'S',
            'varImage' => $Imagesurl,
            'varImage1' => $Imagesurl1,
            'dtBlogDate' => $dtBlogDate,
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'varShortDesc' => $this->input->post('varShortDesc', TRUE),
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'intDisplayOrder' => $Int_DisplayOrder,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
//        print_r($data);
//        exit;
        $query = $this->db->insert(DB_PREFIX . 'blogs', $data);
        $id = $this->db->insert_id();
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Insert_Alias($Alias_Array);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'blogs', 'Name' => 'varTitle', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update() {



        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_blogs();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];




        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/blogs/images/';
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

        if ($_FILES['varImage1']['name'] != '') {
            $config['upload_path'] = 'upimages/blogs/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName1 = $_FILES['varImage1']['name'];
            $Imagesurl1 = $this->ImageName = $this->common_model->Clean_String($this->ImageName1);
            $FileExntension1 = substr(strrchr($this->ImageName1, '.'), 1);
            $Var_Title1 = str_replace('.' . $FileExntension1, '', $this->ImageName1);
            $Imagesurl1 = $this->ImageName1 = $Var_Title1 . "_" . time() . "." . $FileExntension1;
            $config['file_name'] = $this->ImageName1;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('varImage1')) {
                
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            $Imagesurl1 = $this->input->post('hidd_VarImage1');
        }

        $old_flag1 = $this->input->post('hidd_ImageFlag1');
        if ($flag1 != $old_flag1) {
            if ($flag1 == 'S' && $_FILES['varImage1']['name'] == '') {
                $Imagesurl1 = '';
            } else {
                $Imagesurl1 = $Imagesurl1;
            }
        }

        $dtBlogDate1 = $this->input->post('dtBlogDate');
        $dtBlogDate = date("Y-m-d", strtotime($dtBlogDate1));

        if (date('Y', strtotime($dtBlogDate)) == '1970') {
            $dtBlogDates1 = $this->input->post('dtBlogDate1');
            $dtBlogDate = date("Y-m-d", strtotime($dtBlogDates1));
        }

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        $data = array(
            'varAuthor' => $this->input->post('varAuthor', TRUE),
            'varType' => $this->input->post('varType', TRUE),
            'varTitle' => $this->input->post('varTitle', TRUE),
            'chrImageFlag' => 'S',
            'varImage' => $Imagesurl,
            'chrImageFlag1' => 'S',
            'varImage1' => $Imagesurl1,
            'dtBlogDate' => $dtBlogDate,
            'varShortDesc' => $this->input->post('varShortDesc', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
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
        $id = $this->db->insert_id();

        $opertion = 'U';
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update(DB_PREFIX . 'blogs', $data);

        $int_id = $this->input->get_post('ehintglcode');
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Update_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'blogs', 'Name' => 'varTitle', 'ModuleintGlcode' => $int_id, 'Flag' => $opertion, 'Default' => 'int_id');
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'blogs');
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
        $uids = $this->input->get_post('uid');
        $neworder = $this->input->get_post('neworder');
        $oldorder = $this->input->get_post('oldorder');
        $fkblogs = $this->input->get_post('fkblogs');
        if (empty($fkblogs)) {
            $fkblogs = 0;
        }
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'blogs', "");
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'blogs');
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'blogs';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d h-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'blogs', 'Name' => 'varTitle', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
            $this->mylibrary->insertinlogmanager($ParaArray);
            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'blogs');
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

    function generate_seocontent_blogs($fromajax = false) {
        $PageName = $this->input->post('varTitle', true);
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

    function Select_Share_Page_Rows($id) {

        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "blogs WHERE chrDelete='N' AND chrPublish='Y' AND int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

    function shareonfacebook() {
        $status = 0;
        $fb = $this->input->get_post('fb');

        $tw = $this->input->get_post('tw');
        if (!empty($fb) || !empty($tw)) {
            $param = $this->get_Post_data($this->input->get_post('eid'));
//            print_r($param);exit;
            if (!empty($fb)) {
                $param["APP_ID"] = FB_APP_ID;
                $param["APP_SECRET"] = FB_APP_SECRET;
                $param["PAGE_ID"] = FB_PAGE_ID;
                $param['data']["access_token"] = FB_ACCESS_TOKEN;
                if ($this->mylibrary->shareOnFacebook($param) == 1) {
                    $status = 1;
                }
            }

            if (!empty($tw)) {

                $param['CONSUMER_KEY'] = TW_CONSUMER_KEY;
                $param['CONSUMER_SECRET'] = TW_CONSUMER_SECRET;
                $param['OUATH_TOKEN'] = TW_OUATH_TOKEN;
                $param['OUATH_TOKEN_SECRET'] = TW_OUATH_TOKEN_SECRET;
                $param['status'] = "";

                $param['data']['name'] = strlen($param['data']['name']) > 130 ? substr($param['data']['name'], 0, 110) . "..." : $param['data']['name'];

                if (((strlen($param['data']['link']) + (strlen($param['data']['name'])))) < 130) {
                    $param['data']['name'] .= "\n" . $param['data']['link'];
                }

                if ($this->mylibrary->shareOnTwitter($param) == 1) {
                    $status = 1;
                }
            }
        }
        return $status;
    }

    function get_Post_data($id) {

        $sql = "SELECT p.varTitle as varTitle,a.varAlias as varAlias,p.txtDescription as txtDescription,p.varImage as varImage  FROM " . DB_PREFIX . "blogs as p
                LEFT JOIN " . DB_PREFIX . "alias as a ON a.fk_ModuleGlCode='104' AND a.fk_Record=p.int_id 
                WHERE p.chrDelete='N' AND p.chrPublish='Y' AND p.int_id='" . $id . "'";
        $qry = $this->db->query($sql);
        $result = $qry->row_array();
        $paramArr['int_id'] = $id;
        $packagelink = SITE_PATH . $result["varAlias"];
        $paramArr['data']['name'] = $this->input->get_post('varTitle');
        $paramArr["data"]["actions"] = array("name" => SITE_NAME, "link" => SITE_PATH);
        $paramArr['data']['link'] = $packagelink;

        $Short_Desc = htmlspecialchars($this->input->get_post('txtDescription'));
        $image = SITE_PATH . 'upimages/blogs/' . $result['varImage'];
        $paramArr['data']['picture'] = $image;
        if (strlen($Short_Desc) > 100) {
            $Short_Desc = substr($Short_Desc, 0, 100) . "...";
        }
        $paramArr['data']['description'] = $Short_Desc;
        return $paramArr;
    }

    function get_publish_value($id) {
        $returnArry = array();
        $sql = "SELECT chrPublish FROM " . DB_PREFIX . "blogs WHERE chrDelete='N' AND int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result['chrPublish'];
    }

    function CategoryFilter() {
//        echo "select pc.int_id AS id, pc.varTitle AS name from " . DB_PREFIX . "product as p left join " . DB_PREFIX . "productcategory as pc on pc.int_id = p.intSharePointCategory  where  p.chrDelete = 'N' group by pc.varTitle order by pc.intDisplayOrder asc";
        $query = $this->db->query("select pc.int_id AS id, pc.varTitle AS name from " . DB_PREFIX . "blogs as p left join " . DB_PREFIX . "SharePointCategory as pc on pc.int_id = p.intSharePointCategory  where  p.chrDelete = 'N' group by pc.varTitle order by pc.intDisplayOrder asc");
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

    public function getDeptname($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "SharePointCategory as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='96' WHERE N.chrPublish='Y' and N.int_id='" . $id . "' and N.chrDelete='N' group by N.int_id";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function SelectAll_front() {
        $flag = 'Y';
        $this->initialize($flag);
        $this->Generateurl($flag);
        $limitby = 'limit ' . $this->Start . ', ' . ABS($this->PageSize);

        $month = $this->input->get_post('month');
        $cat = $this->input->get_post('cat');
        if ($month != '') {
            $where = " and MONTH(N.dtBlogDate) = $month";
        } else if ($cat != '') {
            $where = " and N.varTitle like '%$cat%' ";
        } else {
            $where = "";
        }
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "blogs as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='124'  and N.chrPublish='Y' and N.chrDelete='N' $where group by N.int_id order by N.dtBlogDate desc,N.int_id desc $limitby";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function CountRow_front() {
        $month = $this->input->get_post('month');
        $cat = $this->input->get_post('cat');
        if ($month != '') {
            $where = " and MONTH(N.dtBlogDate) = $month";
        } else if ($cat != '') {
            $where = " and N.varTitle like '%$cat%' ";
        } else {
            $where = "";
        }
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "blogs as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='96' WHERE N.chrPublish='Y' and N.chrDelete='N' $where group by N.int_id order by N.intDisplayOrder asc ";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function SelectAll_RecentBlog($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "blogs as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='124' and N.int_id!='" . $id . "' and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.dtBlogDate desc,N.int_id desc limit 5";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function SelectAll_detail_front_id($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "blogs as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='124'  and N.chrPublish='Y' and N.chrDelete='N' and N.int_id!='" . $id . "' group by N.int_id order by N.intDisplayOrder desc,N.int_id desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function time_ago($date) {
        if (empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();

        $unix_date = strtotime($date);

        // check validity of date

        if (empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date

        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

    public function SelectAll_Detail_front($id) {
        $sql = " select * from " . DB_PREFIX . "blogs where chrDelete='N' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getBusinessTypes() {
        $sql = "select varType from " . DB_PREFIX . "blogs where chrDelete='N' and chrPublish='Y'";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        $typedata = '';
        foreach ($data as $tp) {
            $tp_seperate = explode(",", $tp['varType']);
            foreach ($tp_seperate as $sep) {
                if ($sep != '') {
                    $typedata .= $sep . ",";
                }
            }
        }
        $typedata = str_replace(",,", ",", $typedata);
        $types = array();
        $types = explode(",", $typedata);
        $typess = array_unique($types);

        $typessa = array_filter($typess);
        $numbers = range(0, count($typessa));
        shuffle($numbers);
        $typesss = array();
        foreach ($numbers as $number) {
            $typesss[] = $typess[$number];
        }
        $typesssas = array_slice($typesss, 0, 8);
        return $typesssas;
    }

}

?>