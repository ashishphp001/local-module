<?php

class product_category_model extends CI_Model {

    var $int_id;
    var $intParentCategory;
    var $varName;
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
    var $numofproduct_category; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'pc.int_id'; // Attribute of Deafult Order By
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
            'tablename' => DB_PREFIX . 'product_category',
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
            'search' => array('searchArray' => array("varName" => "Name"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            )
        );
    }

//    function Select_All_product_category_Record() {
//        $this->initialize();
//        $this->Generateurl();
//        $whereclauseids = "pc.chrDelete ='N'";
//        $intParentCategory = $this->input->get_post('intParentCategory');
////        if ($intParentCategory != '') {
////            $whereclauseids .= " and pc.intParentCategory ='" . $intParentCategory . "'";
////        } else {
////            $whereclauseids .= " and pc.intParentCategory ='0'";
////        }
//
//        if ($this->SearchTxt != '') {
//            $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
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
//                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by pc.int_id asc';
//                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "product_category t where  $whereclauseids group by pc.varName $OrderBy");
//                $this->mylibrary->GetAutoSearch($autoSearchQry);
//            }
//        }
//
//        $this->db->select("pc.*", false);
////        $this->db->select('a.varAlias,a.int_id AS alias_id,a.intPageHits,a.intMobileHits', false);
//
//        $this->db->from('product_category AS pc', false);
////        $this->db->join('alias AS a', 'a.fk_Record = pc.int_id', 'left', false);
//        $this->db->where($whereclauseids);
//        $this->db->order_by("$this->OrderBy", $this->OrderType);
//        $this->db->group_by('pc.int_id');
//
////        if ($this->PageSize != 'All') {
////            $this->db->limit(6000, $this->Start);
////        }
//
//        $rs = $this->db->get();
//        $row = $rs->result_array();
////        echo "<pre>";
////        print_R($row);exit;
//        return $row;
//    }

    function Select_All_product_category_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = ' chrDelete="N"';

        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
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
                $OrderBy = 'order by intDisplayOrder asc';
                $SearchByVal = " like '%" . addslashes($this->SearchTxt) . "%'";
                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
                    $this->SearchByVal = "varName";
                }
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "product_category where $whereclauseids group by varName $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select('int_id,intParentCategory');
        $this->db->where($whereclauseids, NULL, FALSE);
        $this->db->from('product_category');
        if (ADMIN_ID != '2') {
            $this->db->where("intParentCategory = '0'", NULL, FALSE);
        }
        $rsmatchedpagesids = $this->db->get();
//         echo $this->db->last_query();exit;
        $product_category = array();
        foreach ($rsmatchedpagesids->result_array() as $row) {
            $product_category[] = $row['int_id'];
            $product_category[] = $row['intParentCategory'];
            if ($this->SearchTxt != '') {
                while ($row['intParentCategory'] != '0') {
                    $sqlquery = "select int_id,intParentCategory FROM " . DB_PREFIX . "product_category where chrDelete='N' AND int_id='" . $row['intParentCategory'] . "'";
                    $res = $this->db->query($sqlquery);
                    $row = $res->row_array();
                    $product_category[] = $row['intParentCategory'];
                }
            }
        }

        $product_category = array_unique($product_category);
        $whereclause = '';
        if (count($product_category) > 0) {
            $strinds = implode(',', $product_category);
            $whereclause .= " AND pc.int_id IN ($strinds)";
        } else {
            $whereclause .= " AND pc.int_id IN (0)";
        }

        $this->db->select('pc.int_id AS id,pc.varName as name, pc.varName, pc.intParentCategory,pc.varImage,pc.int_id', false);
        $this->db->from('product_category AS pc', false);
        $intParentCategory = $this->input->get_post('intParentCategory');
//        echo $intParentCategory;exit;
//        if ($intParentCategory != '') {
//            $this->db->where("pc.intParentCategory = '" . $intParentCategory . "'", NULL, FALSE);
//        } else {
//            $this->db->where("pc.intParentCategory = '0'", NULL, FALSE);
//        }
        $this->db->where("pc.chrDelete = 'N' $whereclause", NULL, FALSE);
//intParentCategory
        $this->db->order_by("$this->OrderBy", $this->OrderType);

//        if ($this->PageSize != 'All') {
//            $this->db->limit($this->PageSize, $this->Start);
//        }
        $rs = $this->db->get();
// echo $this->db->last_query();exit;

        $children = array();
        $pitems = array();
        foreach ($rs->result_array() as $row) {
            $pitems[] = $row;
        }

        if ($pitems) {
            foreach ($pitems as $p) {
                $fk_dbprefix_pages = 'intParentCategory';
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
        $whereclauseids = "chrDelete ='N'";

        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }

//        if ($this->CategoryFilter != '') {
//            $whereclauseids .= " AND intSharePointCategory = $this->CategoryFilter ";
//        }

        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('product_category');
        return $rs;
    }

    function Select_product_category_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('T.chrDelete' => 'N', 'T.int_id' => $id);
        $this->db->select('T.*,a.varAlias');
        $this->db->from('product_category As T');
        $this->db->join('alias AS a', 'T.int_id = a.fk_Record AND a.fk_ModuleGlCode=' . MODULE_ID, 'left');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert() {
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'product_category WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;



        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_product_category();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($this->input->post('chrImageFlag') == 'S' && $_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/product_category/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varImage']['name'];
            $this->ImageName = str_replace(' ', '_', $this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varImage')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
            }
        } else if ($this->input->post('chrImageFlag') == 'B' && $this->input->post('VarDropboxImage') != '') {
            $this->ImageName = $this->input->post('VarDropboxImage');
            $this->ImageName = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $this->ImageName);
            $Path_Parts = pathinfo($this->ImageName);

            $extension = explode('?', $Path_Parts['basename']);
            $this->File_Photo = $this->common_model->Clean_String($extension[count($extension) - 2]);
            $FileExntension = substr(strrchr($this->File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->File_Photo);
            $this->File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
            $NewFile = 'upimages/product_category/images/' . $this->File_Photo;
            $Imagesurl = $this->File_Photo;
            $this->ExternalUrl = $this->ImageName;
            if (copy($this->ImageName, $NewFile)) {
                
            } else {
                echo "Upload failed.";
            }
        } else if ($this->input->post('chrImageFlag') == 'E') {
            $this->Image = $this->input->post('varExternalUrl');
            $Path_Parts = pathinfo($this->Image);
            $this->Des_File_Photo = $Path_Parts['basename'];
            $this->Des_File_Photo = $this->common_model->Clean_String($this->Des_File_Photo);
            $FileExntension = substr(strrchr($this->Des_File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->Des_File_Photo);
            $this->Des_File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
            $newfile = 'upimages/product_category/images/' . $this->Des_File_Photo;
            $newimagethumb = $this->Des_File_Photo;
            if (copy($this->Image, $newfile)) {
                $this->Images = glob("upload/*.pdf") + glob("upload/*.pdf");
                $this->Images = array_combine($this->Files, array_map("filemtime", $this->Images));
                arsort($this->Images);
                $Imagesurl = $this->ImageName = $newimagethumb;
            } else {
                echo "Upload failed.";
            }
        }

        $this->ExternalUrl = "";
        if ($this->input->post('chrImageFlag') == 'E') {
            $this->ExternalUrl = $this->input->post('varExternalUrl');
        }

        if ($Imagesurl == '') {
            $Imagesurl = '';
        }

        $DisplayOrderClause = " AND intParentCategory='" . $this->input->post('intParentCategory') . "'";
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'product_category WHERE chrDelete = "N" ' . $DisplayOrderClause . ' ');
        $rs = $query->row();
        $tot_recods = $rs->total;

        if ($tot_recods >= $this->input->post('int_displayorder')) {
            $this->mylibrary->UpdateInt_DisplayOrder('product_category', $this->input->post('intDisplayOrder'), $DisplayOrderClause);
            $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        } else {
            $Int_DisplayOrder = $tot_recods + 1;
        }

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'intParentCategory' => $this->input->post('intParentCategory', TRUE),
            'chrImageFlag' => $this->input->post('chrImageFlag', TRUE),
            'varExternalUrl' => $this->ExternalUrl,
            'varImage' => $Imagesurl,
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
        $query = $this->db->insert(DB_PREFIX . 'product_category', $data);
        $id = $this->db->insert_id();
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Insert_Alias($Alias_Array);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'product_category', $DisplayOrderClause);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'product_category', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update() {


        $DisplayOrderClause = " AND intParentCategory='" . $this->input->post('intParentCategory') . "'";
        if ($this->input->post('intDisplayOrder') != $this->input->post('Old_DisplayOrder')) {

            $this->mylibrary->update_display_order_Ajax($this->input->post('ehintglcode'), $this->input->post('intDisplayOrder'), $this->input->post('Old_DisplayOrder'), '', 'product_category', $DisplayOrderClause);
        }


        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_product_category();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];


        if ($this->input->post('chrImageFlag') == 'S') {
            if ($_FILES['varImage']['name'] != '') {
                $config['upload_path'] = 'upimages/product_category/images/';
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
                    /* echo "file upload success"; */
                } else {
                    echo $this->upload->display_errors();
                    exit;
                }
            } else {
                $Imagesurl = $this->input->post('hidd_VarImage');
            }
        } else if ($this->input->post('chrImageFlag') == 'B') {
            $this->ImageName = $this->input->post('VarDropboxImage');
            if ($this->ImageName != '') {
                $this->ImageName = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $this->ImageName);
                $Path_Parts = pathinfo($this->ImageName);
                $extension = explode('?', $Path_Parts['basename']);
                $this->File_Photo = $this->common_model->Clean_String($extension[count($extension) - 2]);
                $FileExntension = substr(strrchr($this->File_Photo, '.'), 1);
                $Var_Title = str_replace('.' . $FileExntension, '', $this->File_Photo);
                $this->File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
                $NewFile = 'upimages/product_category/images/' . $this->File_Photo;
                $Imagesurl = $this->File_Photo;
                $this->ExternalUrl = $this->ImageName;
                if (copy($this->ImageName, $NewFile)) {
                    
                } else {
                    echo "Upload failed.";
                }
            } else {
                $Imagesurl = $this->input->post('hidd_VarImage');
            }
        } else if ($this->input->post('chrImageFlag') == 'E') {
            $this->Image = $this->input->post('varExternalUrl');
            $Path_Parts = pathinfo($this->Image);
            $this->Des_File_Photo = $Path_Parts['basename'];
            $this->Des_File_Photo = $this->common_model->Clean_String($this->Des_File_Photo);
            $FileExntension = substr(strrchr($this->Des_File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->Des_File_Photo);
            $this->Des_File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
            $newfile = 'upimages/product_category/images/' . $this->Des_File_Photo;
            $newimagethumb = $this->Des_File_Photo;
            if (copy($this->Image, $newfile)) {
                $this->Images = glob("upload/*.pdf") + glob("upload/*.pdf");
                $this->Images = array_combine($this->Files, array_map("filemtime", $this->Images));
                arsort($this->Images);
                $Imagesurl = $this->ImageName = $newimagethumb;
            } else {
                echo "Upload failed.";
            }
        }

        $this->ExternalUrl = "";
        if ($this->input->post('chrImageFlag') == 'E') {
            $this->ExternalUrl = $this->input->post('varExternalUrl');
        }

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        $Int_DisplayOrder = $this->input->post('intDisplayOrder');



        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'intParentCategory' => $this->input->post('intParentCategory', TRUE),
            'chrImageFlag' => $this->input->post('chrImageFlag', TRUE),
            'varExternalUrl' => $this->ExternalUrl,
            'varImage' => $Imagesurl,
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
//        print_R($data);exit;
        $id = $this->db->insert_id();

        $opertion = 'U';
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update(DB_PREFIX . 'product_category', $data);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'product_category', $DisplayOrderClause);
        $int_id = $this->input->get_post('ehintglcode');
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Update_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'product_category', 'Name' => 'varName', 'ModuleintGlcode' => $int_id, 'Flag' => $opertion, 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
    }

    function getProductCategoryPage($id = '') {
        $query = $this->db->get_where('product_category', array('intParentCategory' => $id));
        $row = $query->num_rows();
        return $row;
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
        $this->db->cache_set_common_path("application/cache/db/common/product_category/");
        $this->db->cache_delete();

        $uids = $this->input->get_post('uid');
        $neworder = $this->input->get_post('neworder');
        $oldorder = $this->input->get_post('oldorder');
        $fkpages = $this->input->get_post('pageid');

        if (empty($fkpages)) {
            $fkpages = 0;
        }

        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'product_category', " AND intParentCategory='" . $fkpages . "'");
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'product_category', " AND intParentCategory='" . $fkpages . "'");
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'product_category';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d h-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'product_category', 'Name' => 'varName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
            $this->mylibrary->insertinlogmanager($ParaArray);
            $cat = $this->get_cat($deletearray[$i]);
            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'product_category', " AND intParentCategory ='" . $cat . "'");
        }
    }

    function get_cat($id = '') {
        $query = $this->db->get_where('product_category', array('int_id' => $id));
        $row = $query->row_array();
        return $row['intParentCategory'];
    }

    function getSubcateHTML() {
        $id = $this->input->get_post('intParentCategory');
        $query = $this->db->get_where('product_category', array('intParentCategory' => $id, 'chrDelete' => 'N', 'chrPublish' => 'Y'));
        $data = $query->result_array();
        $html = "";
        $html .= ' <table class="uk-table" cellspacing="0" width="100%"><thead>     
                            <tr>                                          
                                <th class="uk-width-1-10 uk-text-center small_col">
                                <input onclick="checkall(\'chkgrow\')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th>Main Category</th>                  
                                <th>Sub Categories</th>                  
                                <th>Image</th>
                                    <th>Publish</th>   
                                    <th>Edit</th> 
                            </tr>   
                        </thead> <tbody>';
        foreach ($data as $row) {

            $html .= '<tr>';
            $getSubProduct = $this->getProductCategoryPage($row['int_id']);
            if ($getSubProduct > 0) {
                $data = '<a data-uk-modal="{target:\'#modal_full1\'}" onclick="return getSubcategoryHTML(' . $row['int_id'] . ');" style="color:#00326A;font-weight: 500;" href="javascript:;"> View (' . $getSubProduct . ')</a>';
                $data = '<a onclick="return getSubcategoryHTML(' . $row['int_id'] . ');" style="color:#00326A;font-weight: 500;" href="javascript:;"> Views & Add (' . $getSubProduct . ')</a>';
            } else {
                $data = "-";
            }
            $html .= '<td><input type="checkbox" value="' . $row['int_id'] . '" id="chkgrow" name="chkgrow"></td>';
            $html .= '<td>' . $row['varName'] . '</td>';
            $html .= '<td>' . $data . '</td>';
            $html .= '<td>N/A</td>';
            $html .= '<td>-</td>';
            $html .= '<td><a target="_blank" href="' . MODULE_PATH . '/add?eid=' . $row['int_id'] . '"  title="Click here to edit."> <i class="md-icon material-icons">&#xE254;</i></a></td>';
            $html .= '</tr> ';
        }
        $html .= "</tbody></table>";
        $html .= '<a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>';
        $html .= '<div class="spacer10"></div>';
        return $html;
    }

    function getProductPage($id = '') {
//        $query = $this->db->get_where('product_category', array('int_id' => $id));
        $query = $this->db->query("select * from " . DB_PREFIX . "product_category where chrDelete = 'N' and intParentCategory='" . $id . "'");
        $row = $query->num_rows();
        return $row;
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

    function generate_seocontent_product_category($fromajax = false) {
        $PageName = $this->input->post('varName', true);
//        if ($fromajax) {
//            $description = html_entity_decode(strip_tags($this->input->get_post('description', true)));
//        } else {
        $description = strip_tags($this->input->post('varName', TRUE));
//        }
        $meta_title = $PageName;
        $meta_keyword = $PageName;
        $meta_description = substr($description, 0, 400);
        $seo_data = $meta_title . '*****' . $meta_keyword . '*****' . $meta_description;
        return $seo_data;
    }

//    function CategoryFilter() {
//        $query = $this->db->query("select pc.int_id AS id, pc.varName AS name from " . DB_PREFIX . "product_category as p left join " . DB_PREFIX . "SharePointCategory as pc on pc.int_id = pc.intSharePointCategory  where  pc.chrDelete = 'N' group by pc.varName order by pc.intDisplayOrder asc");
//        $returnHtml = "";
//        $returnHtml .= "<select class=\"more-textarea \" style=\"float:left;margin-left:10px;\" id=\"CategoryFilter\" name=\"CategoryFilter\" onchange=\"SendGridBindRequest('$this->UrlWithPara&filtering=Y&PageNumber=1','gridbody','CATEGORY_FILTER');\">";
//        $returnHtml .= "<option value=''>--Select Sharepoint  Category--</option>";
//        foreach ($query->result() as $row) {
//            if ($row->id == $this->CategoryFilter) {
//                $selected = 'selected="selected"';
//            } else {
//                $selected = '';
//            }
//            $returnHtml .= '<option value="' . $row->id . '" ' . $selected . '>' . $row->name . '</option>';
//        }
//        $returnHtml .= "</select>";
//        return $returnHtml;
//    }

    public function SelectAll_front() {
        $flag = 'Y';
        $this->initialize($flag);
        $this->Generateurl($flag);
        $limitby = 'limit ' . $this->Start . ', ' . ABS($this->PageSize);
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "product_category as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE N.intParentCategory='0' and A.fk_ModuleGlCode='96'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.intDisplayOrder desc,N.int_id desc $limitby";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function Export() {
        $this->load->helper('csv');
        $selectids = $this->input->get_post('chkids');
        $selectarray = explode(',', $selectids);
        $totaldeletedrecords = count($selectarray);
        $exportarry = array();
        $whereclauses = '';

        $this->db->select('*', false);
        $this->db->from('product_category', false);
        $this->db->where("chrDelete = 'N'");
//        $this->db->order_by(, $this->OrderType);
        $rs = $this->db->get();
        $query = $rs->result_array();
        $site_name = str_replace(' ', '_', SITE_NAME);
        $filename = $site_name . "_product_category_" . date("dmy-h:i") . ".xls";
        $gridbind = "<table border=1>";
        foreach ($query as $row) {
            $rowcount = 0;
            $gridbind .= "<tr>";
            $gridbind .= "<td valign='top'>" . $row["int_id"] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["varName"] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["intParentCategory"] . "</td>";
            $gridbind .= "</tr>";
            $rowcount_a++;
        }
        $gridbind .= "</table>";
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

    public function SelectAll_detail_front_id($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "product_category as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='96'  and N.chrPublish='Y' and N.chrDelete='N' and N.int_id!='" . $id . "' group by N.int_id order by N.intDisplayOrder desc,N.int_id desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function approve_product_category() {
        $approve = $this->input->get_post('chrApprove');
        $Eid = $this->input->get_post('Eid');

        $data = array('chrApprove' => $approve, 'dtModifyDate' => date('Y-m-d H-i-s'));
        $this->db->where('int_id', $Eid);
        $this->db->update('product_category', $data);
    }

    function CountRow_front() {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "product_category as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='96'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.intDisplayOrder desc,N.int_id desc";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    function getProductCatList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "product_category where chrDelete = 'N' and intParentCategory='0' order by intDisplayOrder asc");
        $Result = $query->result();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input\" id=\"intParentCategory\" name=\"intParentCategory\" >";
        $returnHtml .= "<option value=''>--Select Product Category --</option>";
        foreach ($Result as $row) {
            $query1 = $this->db->query("select * from " . DB_PREFIX . "product_category where chrDelete = 'N' and intParentCategory='" . $row->int_id . "' order by intDisplayOrder asc");
            $Result1 = $query1->result();

            if ($id == $row->int_id) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row->int_id . '" ' . $selected . '>' . $row->varName . '</option>';
            foreach ($Result1 as $row1) {
                $query2 = $this->db->query("select * from " . DB_PREFIX . "product_category where chrDelete = 'N' and intParentCategory='" . $row->int_id . "' order by intDisplayOrder asc");
                $Result2 = $query2->result();

                if ($row1->int_id == $id) {
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

    function getCategorySearch() {
        $search = $this->input->get_post('varSearch');
        $category = $this->input->get_post('intCategory');
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "product_category as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE N.intParentCategory='" . $category . "' and N.varName like '%" . $search . "%' and A.fk_ModuleGlCode='113' and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id";
        $query = $this->db->query($sql);
        $Result = $query->result_array();
        $returnHtml = '';
        foreach ($Result as $row) {
            $returnHtml .= '<li><a href="' . SITE_PATH . $row['varAlias'] . '"  class="waves-effect waves-light btn">' . $row['varName'] . '</a></li>';
        }
        if (empty($Result)) {
            $returnHtml .= "<li><a href='javascript:;' class=\"waves-effect waves-light btn\">No Category found.</a></li>";
        }
        return $returnHtml;
    }

    public function SelectAll_Detail_front($id) {
        $sql = "select * from " . DB_PREFIX . "product_category where chrDelete='N' and chrPublish='Y' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function SelectAll_detail_front_id1($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "product_category as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='86'  and N.chrPublish='Y' and N.chrDelete='N' and N.int_id='" . $id . "' group by N.int_id";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getProductCategories($id = 0) {
//        $this->db->select("(SELECT count(1) AS pagecount FROM " . DB_PREFIX . "pages AS p1 WHERE p1.fk_ParentPageGlCode=p.fk_ParentPageGlCode) AS pagecount", false);
        $sql = "select pc.*,A.varAlias,(SELECT count(1) AS pagecount FROM " . DB_PREFIX . "product_category AS p1 WHERE p1.intParentCategory=pc.int_id) AS childcount from " . DB_PREFIX . "product_category pc LEFT JOIN " . DB_PREFIX . "alias A ON pc.int_id=A.fk_Record WHERE pc.intParentCategory='" . $id . "' and pc.chrPublish='Y' and A.fk_ModuleGlCode='113' and pc.chrDelete='N' group by pc.int_id order by pc.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getFirstCategories() {
        $sql = "select int_id from " . DB_PREFIX . "product_category where chrDelete='N' and chrPublish='Y' limit 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data['int_id'];
    }

    public function getProductCategory($id) {
        $sql = "select intParentCategory from " . DB_PREFIX . "product_category where chrDelete='N' and int_id='" . $id . "' and chrPublish='Y' limit 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data['intParentCategory'];
    }

//    public function getFirstCategories() {
//        $sql = "select int_id from " . DB_PREFIX . "product_category where chrDelete='N' and chrPublish='Y' limit 1";
//        $query = $this->db->query($sql);
//        $data = $query->row_array();
//        return $data['int_id'];
//    }

    public function getHomePageSubProductCategory($id) {
        $sql = "select pc.*,A.varAlias from " . DB_PREFIX . "product_category pc LEFT JOIN " . DB_PREFIX . "alias A ON pc.int_id=A.fk_Record WHERE pc.intParentCategory='" . $id . "' and pc.chrPublish='Y' and A.fk_ModuleGlCode='113' and pc.chrDelete='N' group by pc.int_id order by pc.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getproductData($id) {
        $sql = "select p.*,A.varAlias as alias from " . DB_PREFIX . "product p "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "product_category pc ON p.fkintCategory=pc.int_id"
                . " WHERE p.chrPublish='Y' and A.fk_ModuleGlCode='96' and p.fkintCategory='" . $id . "' and p.chrDelete='N' group by p.int_id order by p.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function UploadMeta_excel() {
        $repeated = array();
        $issuelist = array();
        $filename = $_FILES["varFileUpload"]["tmp_name"];
        if ($_FILES["varFileUpload"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($emapData[0] != '') {
                    $data = array(
                        'varMetaTitle' => trim($emapData[2]),
                        'varMetaKeyword' => trim($emapData[3]),
                        'varMetaDescription' => trim($emapData[4])
                    );
                    $this->db->where('int_id', $emapData[0]);
                    $this->db->update(DB_PREFIX . 'product', $data);
                } else {
                    $repeated['id'] = $emapData[0];
                    $repeated['name'] = $emapData[1];
                    $repeated['issue'] = "Category ID required.";
                    $repeated['solution'] = "Category ID required.";
                    $issuelist[] = $repeated;
                }
            }
        }
    }
    public function UploadProductImage() {
        $repeated = array();
        $issuelist = array();
        $filename = $_FILES["varFileUpload"]["tmp_name"];
        if ($_FILES["varFileUpload"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($emapData[0] != '') {
                    $data = array(
                        'fkProduct' => $emapData[0],
                        'varName' => $emapData[1],
                        'varImage' => $emapData[1],
                        'chrDefaultimage' => 'N',
                        'intDisplayOrder' => '1',
                        'chrDelete' => 'N',
                        'dtCreateDate' => date('Y-m-d H:i:s')
                    );
//                    $this->db->where('int_id', $emapData[0]);
                    $this->db->insert(DB_PREFIX . 'productgallery', $data);
                } else {
                    $repeated['id'] = $emapData[0];
                    $repeated['name'] = $emapData[1];
                    $repeated['issue'] = "Category ID required.";
                    $repeated['solution'] = "Category ID required.";
                    $issuelist[] = $repeated;
                }
            }
        }
    }

    public function Upload_excel() {
//        echo "hgi";exit;
        $repeated = array();
        $issuelist = array();
        $filename = $_FILES["varFileUpload"]["tmp_name"];
        if ($_FILES["varFileUpload"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($emapData[1] != '') {
                    $checkname = $this->checkNameExist(stripslashes(quotes_to_entities($emapData[1])));
                    if ($checkname == 0) {
                        $aliasname = strtolower($emapData[1]);
                        $aliasname = stripslashes(quotes_to_entities($aliasname));
                        $aliasname = str_replace(' ', '-', $aliasname);
                        $aliasname = preg_replace('/[^A-Za-z0-9\-]/', '', $aliasname);
                        $aliasname = str_replace('---', '-', $aliasname);
                        $aliasname = str_replace('--', '-', $aliasname);
                        $aliasname = strip_tags($aliasname);
                        $aliasname = htmlentities($aliasname);
                        $alias = $this->GetAlias($aliasname);

                        $productname = $emapData[1];
                        $productname = strtolower($productname);
                        $productname = ucfirst($productname);
                        $productname = strip_tags($productname);
                        $productname = trim($productname);
                        $productname = trim($productname);
                        $productname = stripslashes(quotes_to_entities($productname));
                        $data = array(
                            'int_id' => $emapData[0],
                            'varName' => $productname,
                            'intParentCategory' => $emapData[2],
                            'chrImageFlag' => "S",
                            'varExternalUrl' => "",
                            'varImage' => "",
                            'varMetaTitle' => $productname,
                            'varMetaKeyword' => $productname,
                            'varMetaDescription' => $productname,
                            'intDisplayOrder' => "0",
                            'chrDelete' => "N",
                            'chrPublish' => "Y",
                            'dtCreateDate' => date('Y-m-d H:i:s'),
                            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                            'PUserGlCode' => ADMIN_ID,
                        );
                        $this->db->insert('product_category', $data);
                        $id = $this->db->insert_id();
                        $aliasdata = array(
                            'fk_ModuleGlCode' => MODULE_ID,
                            'fk_Record' => $id,
                            'varAlias' => $alias,
                        );
                        $this->db->insert('alias', $aliasdata);
                    } else {
                        $repeated['id'] = $emapData[0];
                        $repeated['name'] = $emapData[1];
                        $repeated['issue'] = "Repeated Category";
                        $repeated['solution'] = "Category name must be unique.";
                        $issuelist[] = $repeated;
                    }
                }
            }
            fclose($file);
            return $issuelist;
        }
    }

    function GetAlias($alias = '', $return = '') {
        $alias = $alias == '' ? $this->input->get_post('alias') : $alias;
        $flag = 'Y';
        $res = $this->IsSameAlias($flag, $alias);
        if ($res == 0) {
            $i = 1;
            while ($i <= 100) {
                $ralias = $alias . "-" . $i;
                $res = $this->IsSameAlias('Y', $ralias);
                if ($res == 1) {
                    break;
                }
                $i++;
            }
            if ($return == 'Y') {
                return $ralias;
            } else {
                return $ralias;
            }
        } else {
            if ($return == 'Y') {
                return $alias;
            } else {
                return $alias;
            }
        }
    }

    function IsSameAlias($flag = 'N', $alias = '') {
        $eid = $this->input->get_post('eid', TRUE);
        $Fk_Modules = MODULE_ID;
        if (!empty($eid)) {
            $Where = " AND int_id != (SELECT int_id FROM " . DB_PREFIX . "alias where fk_ModuleGlCode='" . $Fk_Modules . "' AND fk_Record='" . $eid . "')";
        }
        if ($alias == "") {
            $Alias = $this->input->get_post("varAlias", TRUE);
        } else {
            $Alias = $alias;
        }
//        $SQL = $this->db->query("SELECT count(1) as total FROM " . DB_PREFIX . "product_category1 where varAlias=@? $Where", strtolower($Alias));
        $SQL = $this->db->query("SELECT count(1) as total FROM " . DB_PREFIX . "alias where varAlias=@? $Where", strtolower($Alias));
        $Result = $SQL->row();
        if ($Result->total > 0) {
            $same = 0;
        } else {
            $same = 1;
        }
        if ($flag == 'Y') {
            return $same;
        } else {
            echo $same;
            exit();
        }
    }

    public function checkNameExist($product_name) {
        $sql = "select * from " . DB_PREFIX . "product_category where chrDelete='N' and chrPublish='Y' and varName Like '" . $product_name . "'";
        $query = $this->db->query($sql);
        $data = $query->num_rows();
        return $data;
    }

    public function getProductImageData($id) {
        $sql = "select * from " . DB_PREFIX . "productgallery where chrDelete='N' and chrPublish='Y' and fkProduct= '$id'  order by intDisplayOrder desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function Bindpageshierarchy1($name, $selected_id, $class = 'listbox') {

//        $NotShowString = array();

        $style = "style='display: none'";
        $dipnopar = "selected";

        $requesteid = $this->input->get_post('eid');
        $tempfk = "";
        $requesteid = !empty($requesteid) ? $requesteid : "";


        $wherearray = array('chrDelete' => 'N');
        $this->db->select('int_id AS id, varName AS name, intParentCategory');
        $this->db->from('product_category');
        $this->db->where($wherearray);
        $this->db->order_by('varName', 'ASD');



        $res_pages = $this->db->get();

        $children = array();
        $pitems = array();

        foreach ($res_pages->result_array() as $row) {
            $pitems[] = $row;
        }

        if ($pitems) {
            foreach ($pitems as $p) {
                $pt = $p['intParentCategory'];
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $p);
                $children[$pt] = $list;
            }
        }

        $list = $this->treerecurse(0, '&nbsp;&nbsp;&nbsp;', array(), $children, 10, 0, 0);
        $display_output = '<select class="md-input"  data-md-selectize data-md-selectize-bottom name="' . $name . '" id="' . $name . '"  size="10">';
//        $display_output .= "<option value = ''>Select Category</option>";
//        if (USERTYPE == 'N') {
        $display_output .= "<option value = \"\" " . (($selected_id == 0) ? $dipnopar : '') . ">No parent</option>";
//        }
        $temp1 = "";
        $temp = "";

        foreach ($list as $item) {
//            if ($item['id'] == $_REQUEST['eid'] || $item['intParentCategory'] == $_REQUEST['eid']) {
//                $disabled = "";
//                $temp1 = $item['id'];
//            } else if ($item['intParentCategory'] == $temp || $item['intParentCategory'] == $temp1 || $tempfk == $item['intParentCategory']) {
//                $disabled = "";
//                $temp = $item['id'];
//                $tempfk = $item['intParentCategory'];
//            } else {
            $disabled = "";
//            }
            $display_output .= "<option value=" . $item['id'] . " " . (($item['id'] == $selected_id) ? 'selected' : '') . " " . $disabled . " >" . $item['treename'] . "</option>";
        }
        $display_output .= "</select>";
        return $display_output;
    }

    function Bindpageshierarchy($name, $selected_id, $class = 'listbox') {

//        $NotShowString = array();

        $style = "style='display: none'";
        $dipnopar = "selected";

        $requesteid = $this->input->get_post('eid');
        $tempfk = "";
        $requesteid = !empty($requesteid) ? $requesteid : "";


        $wherearray = array('chrDelete' => 'N');
        $this->db->select('int_id AS id, varName AS name, intParentCategory');
        $this->db->from('product_category');
        $this->db->where($wherearray);

//        $this->db->where_not_in('int_id', $NotShowString);
        $this->db->order_by('varName', 'ASD');



        $res_pages = $this->db->get();

        $children = array();
        $pitems = array();

        foreach ($res_pages->result_array() as $row) {
            $pitems[] = $row;
        }

        if ($pitems) {
            foreach ($pitems as $p) {
                $pt = $p['intParentCategory'];
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $p);
                $children[$pt] = $list;
            }
        }

        $list = $this->treerecurse(0, '&nbsp;&nbsp;&nbsp;', array(), $children, 10, 0, 0);
        $display_output = '<select class="md-input"  data-md-selectize data-md-selectize-bottom name="' . $name . '" id="' . $name . '"  size="10">';
//        $display_output .= "<option value = ''>Select Category</option>";
//        if (USERTYPE == 'N') {
        $display_output .= "<option value = \"\" " . (($selected_id == 0) ? $dipnopar : '') . ">No parent</option>";
//        }
        $temp1 = "";
        $temp = "";

        foreach ($list as $item) {
            if ($item['id'] == $_REQUEST['eid'] || $item['intParentCategory'] == $_REQUEST['eid']) {
                $disabled = " disabled='disabled' ";
                $temp1 = $item['id'];
            } else if ($item['intParentCategory'] == $temp || $item['intParentCategory'] == $temp1 || $tempfk == $item['intParentCategory']) {
                $disabled = " disabled='disabled' ";
                $temp = $item['id'];
                $tempfk = $item['intParentCategory'];
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
                    $pre = '<sup>' . $level + 1 . '_</sup>&nbsp;';
                    $spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $parent_order = $Order;
                } else {
                    $pre = '' . $level + 1 . '_ ';
                    $spacer = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }

                if ($c['intParentCategory'] == 0) {
                    $txt = $c['name'];
                    $Orderparent = $c['intDisplayOrder'];
                } else {
                    $txt = $pre . $c['name'];
                    $Orderparent = " . " . $c['intDisplayOrder'];
                }
                $pt = $c['intParentCategory'];
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