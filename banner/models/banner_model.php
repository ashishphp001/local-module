<?php

class banner_model extends CI_Model {

    var $int_id;
    var $varTitle;
    var $chr_publish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dt_createdate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $numofpages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'intDisplayOrder'; // Attribute of Deafult Order By
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

    public function __construct() {
        $this->ajax = $this->input->get_post('ajax');

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
        $BannerFilter = $this->input->get_post('BannerFilter');


        if (!empty($Term)) {
            $SearchTxt = ($Type == 'autosearch') ? $Term : $SearchTxt;
        }
        $this->SearchByVal = (!empty($SearchByVal)) ? $SearchByVal : $this->SearchByVal;
        $this->SearchBy = (!empty($SearchBy)) ? urldecode($SearchBy) : '';
        $this->SearchTxt = (!empty($SearchTxt)) ? urldecode($SearchTxt) : '';
        $this->OrderBy = (!empty($OrderBy)) ? $OrderBy : $this->OrderBy;
        $this->OrderType = (!empty($OrderType)) ? $OrderType : $this->OrderType;
        $this->FilterBy = (!empty($FilterBy)) ? $FilterBy : $this->FilterBy;
        $this->BannerFilter = (!empty($BannerFilter)) ? $BannerFilter : $this->BannerFilter;

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

        $BannerFilter = "&BannerFilter=" . $this->BannerFilter;

        $this->HUrlWithPara = $this->PageName . '&' . 'hPageSize=' . $this->PageSize . '&hNumOfRows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hOrderType=' . $this->OrderType . '&hSearchBy=' . $this->SearchBy . '&hSearchTxt=' . urlencode($this->SearchTxt) . '&hPageNumber=' . $this->PageNumber . '&hFilterBy=' . $this->FilterBy . '&history=T' . '&BannerFilter=' . $this->BannerFilter;
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&BannerFilter=' . $this->BannerFilter . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&BannerFilter=' . $this->BannerFilter . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithOutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&BannerFilter=' . $this->BannerFilter . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithOutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&BannerFilter=' . $this->BannerFilter . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&BannerFilter=' . $this->BannerFilter . '&SearchTxt=' . urlencode($this->SearchTxt);
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&PageNumber=' . $this->PageNumber . '&BannerFilter=' . $this->BannerFilter . '&FilterBy=' . $this->FilterBy;
    }

    function generateParam($position = 'top') {
        if ($position == 'top') {

            $BannerFilter = $this->BannerFilter1();
        }

        $PageSize = $this->PageSize;
        return array(
            'pageurl' => MODULE_PAGE_NAME,
            'heading' => "Manage Banners",
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'banner',
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
            'search' => array('searchArray' => array("varTitle" => "Title"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
            'BannerFilter' => $BannerFilter,
        );
    }

    function SelectAll() {
        $this->db->cache_delete();
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = " chrDelete ='N' ";



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

                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by Chr_Banner_Type,intDisplayOrder asc';
                if ($this->BannerFilter != '') {
                    $whereclauseids .= " AND Chr_Banner_Type = '" . $this->BannerFilter . "' ";
                }
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "banner where  $whereclauseids group by varTitle $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        if ($this->BannerFilter != '') {
            $whereclauseids .= " AND Chr_Banner_Type = '" . $this->BannerFilter . "' ";
        }
        $this->db->select('*');
        $this->db->from('banner');
        $this->db->order_by("intDisplayOrder", $this->OrderType);
//        if ($this->PageSize != 'All') {
//            $this->db->limit($this->PageSize, $this->Start);
//        }

        $this->db->where("$whereclauseids ", NULL, FALSE);
        $rs = $this->db->get();
        $res = $rs->result_array();

        return $res;
    }

    function CountRows() {
        $whereclauseids = "chrDelete ='N' ";

        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varTitle like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }
        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }

        if ($this->BannerFilter != '') {
            $whereclauseids .= " AND Chr_Banner_Type = '" . $this->BannerFilter . "' ";
        }

        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('banner');
        return $rs;
    }

    function Select_Rows($id) {

//        $this->db->cache_set_common_path("application/cache/db/common/banner/");
//        $this->db->cache_delete();

        $returnArry = array();
        $wherecondtion = array('P.chrDelete' => 'N', 'P.int_id' => $id);
        $this->db->select('P.*');
        $this->db->from('banner As P');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }

//        echo $this->db->last_query();exit;
        return $returnArry;
    }

    function Insert() {

        $this->db->cache_set_common_path("application/cache/db/common/banner/");
        $this->db->cache_delete();

        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'banner WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;

        if ($tot_recods >= $this->input->post('intDisplayOrder')) {
            $Bannertype = $this->input->get_post('Chr_Banner_Type', TRUE);
            $this->mylibrary->UpdateInt_DisplayOrder('banner', $this->input->post('intDisplayOrder'), $where);
            $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        } else {
            $Int_DisplayOrder = $tot_recods + 1;
        }
        if ($this->input->post('chrImageFlag') == 'S' && $_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/banner/images/';
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
        } else if ($this->input->post('chrImageFlag') == 'E') {
            $this->Image = $this->input->post('varExternalUrl');
            $Path_Parts = pathinfo($this->Image);
            $this->Des_File_Photo = $Path_Parts['basename'];
            $this->Des_File_Photo = $this->common_model->Clean_String($this->Des_File_Photo);
            $FileExntension = substr(strrchr($this->Des_File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->Des_File_Photo);
            $this->Des_File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
            $newfile = 'upimages/banner/images/' . $this->Des_File_Photo;
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

        $Bannertype = $this->input->post('Chr_Banner_Type', true);


//        for ($i = 0; $i < count($pages); $i++) {
        $data = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'Chr_Banner_Type' => $Bannertype,
            'chrImageFlag' => $this->input->post('chrImageFlag', TRUE),
            'varExternalUrl' => $this->ExternalUrl,
            'varImage' => $Imagesurl,
            'chrPublish' => $chrPublish,
            'intDisplayOrder' => $Int_DisplayOrder,
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
        $this->db->insert('banner', $data);
        $id = $this->db->insert_id();
        $Bannertype = $this->input->get_post('Chr_Banner_Type', TRUE);
        $where = " and Chr_Banner_Type='" . $Bannertype . "'";
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'banner', $where);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'banner', 'Name' => 'varTitle', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
//        }
        return $id;
    }

    function update() {

//       print_r($_REQUEST);exit;
        $this->db->cache_set_common_path("application/cache/db/common/banner/");
        $this->db->cache_delete();

        if ($this->input->post('intDisplayOrder') != $this->input->post('Old_DisplayOrder')) {
            $Bannertype = $this->input->get_post('Chr_Banner_Type', TRUE);
            $where = " and Chr_Banner_Type='" . $Bannertype . "'";
            $this->mylibrary->Update_Display_Order($this->input->post('ehintglcode'), $this->input->post('intDisplayOrder'), $this->input->post('Old_DisplayOrder'), '', 'banner', $where);
        }

        if ($this->input->post('intDisplayOrder') != $this->input->post('Old_DisplayOrder')) {
            $Bannertype1 = $this->input->get_post('Chr_Banner_Type', TRUE);
            $where1 = " and Chr_Banner_Type='" . $Bannertype1 . "'";
            $this->mylibrary->Update_Display_Order($this->input->post('ehintglcode'), $this->input->post('intDisplayOrder'), $this->input->post('Old_DisplayOrder'), '', 'banner', $where1);
        }

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        if ($this->input->post('chrImageFlag') == 'S') {
            if ($_FILES['varImage']['name'] != '') {
                $config['upload_path'] = 'upimages/banner/images/';
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
        } else if ($this->input->post('chrImageFlag') == 'E') {
            $this->Image = $this->input->post('varExternalUrl');
            $Path_Parts = pathinfo($this->Image);
            $this->Des_File_Photo = $Path_Parts['basename'];
            $this->Des_File_Photo = $this->common_model->Clean_String($this->Des_File_Photo);
            $FileExntension = substr(strrchr($this->Des_File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->Des_File_Photo);
            $this->Des_File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
            $newfile = 'upimages/banner/images/' . $this->Des_File_Photo;
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

        $Bannertype = $this->input->get_post('Chr_Banner_Type', TRUE);
        $data = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'Chr_Banner_Type' => $Bannertype,
            'chrImageFlag' => $this->input->post('chrImageFlag', TRUE),
            'varExternalUrl' => $this->ExternalUrl,
            'varImage' => $Imagesurl,
            'chrPublish' => $chrPublish,
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'intDisplayOrder' => $this->input->post('intDisplayOrder', TRUE)
        );
//        echo "<pre>";
//        print_R($data);exit;
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update('banner', $data);
        if ($this->input->get_post('Chr_Banner_Type', TRUE) == 'I') {
            $Bannertype = "I";
        } else {
            $Bannertype = "H";
        }
        $where = " and Chr_Banner_Type='" . $Bannertype . "'";
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'banner', $where);

        if ($this->input->get_post('Chr_Banner_Type', TRUE) != 'I') {
            $Bannertype1 = "I";
        } else {
            $Bannertype1 = "H";
        }
        $where1 = " and Chr_Banner_Type='" . $Bannertype1 . "'";
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'banner', $where1);


        $int_id = $this->input->get_post('ehintglcode');
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'banner', 'Name' => 'varTitle', 'ModuleintGlcode' => $int_id, 'Flag' => 'U', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
    }

    function delete_row() {
        $tablename = 'banner';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $Chr_Banner_Type = $this->input->get_post('Chr_Banner_Type');
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['SERVER_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'banner', 'Name' => 'varTitle', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id');
            $this->mylibrary->insertinlogmanager($ParaArray);
            $banner = $this->get_banner($deletearray[$i]);
            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'banner', " AND Chr_Banner_Type ='" . $banner . "'");
        }
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
        $fk_banner = $this->input->get_post('Chr_Banner_Type');

        if ($fk_banner != '') {

            $where = " and Chr_Banner_Type='" . $this->input->post('Chr_Banner_Type') . "'";
        } else {

            $where = '';
        }
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'banner', '', $where);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'banner', '', $where);
    }

    function updateread() {
        $this->db->cache_set_common_path("application/cache/db/common/banner/");
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

    public function get_homebanner_count() {

        $SQL = $this->db->query("SELECT int_id FROM " . DB_PREFIX . "banner where chrDelete='N' and Chr_Banner_Type='H'");
        $RS = $SQL->num_rows();
        return $RS;
    }

    function getpagesname($id = '') {
        $wherecondtion = array('int_id' => $id);
        $this->db->select('varTitle');
        $this->db->from('pages');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        $row = $result->row_array();
        return $row['varTitle'];
    }

    function BannerFilter1() {

        $sel .= "<select id='BannerFilter' class='md-input' name='BannerFilter' onchange=\"SendGridBindRequest('$this->UrlWithPara&filtering=Y&PageNumber=1','gridbody','BANNER_FILTER');\">";
        $sel .= "<option value=''>--Select Banner Type--</option>";
        if ($this->BannerFilter == 'H') {
            $selected_one = "selected";
        } else {
            $selected_one = '';
        }
        if ($this->BannerFilter == 'I') {
            $selected_two = "selected";
        } else {
            $selected_two = '';
        }

        $sel .= '<option value="H" ' . $selected_one . '>Home Banner</option>';
        $sel .= '<option value="I" ' . $selected_two . '>Inner Banner</option>';

        $sel .= "</select>";
        return $sel;
    }

    function get_banner($id = '') {
        $query = $this->db->get_where('banner', array('int_id' => $id));
        $row = $query->row_array();
        return $row['Chr_Banner_Type'];
    }

    function Homebannercount() {

        $this->db->cache_set_common_path("application/cache/db/common/banner/");
        $this->db->cache_delete();

        $returnArry = array();
        $wherecondtion = array('P.chrDelete' => 'N', 'P.Chr_Banner_Type' => 'H', 'P.chrPublish' => 'Y');
        $this->db->select('P.*');
        $this->db->from('banner As P');
        $this->db->where($wherecondtion);
        $result = $this->db->count_all_results();
        return $result;
    }

}

?>