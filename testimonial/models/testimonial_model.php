<?php

class testimonial_model extends CI_Model {

    var $int_id;
    var $varName;
    var $chr_publish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dt_createdate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $numofpages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'P.intDisplayOrder'; // Attribute of Deafult Order By
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
            $this->NumOfRows = $this->CountServices();
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
            'heading' => 'Manage Testimonials',
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'testimonial',
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
            'search' => array('searchArray' => array("varName" => "Title"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
        );
    }

    function SelectAll() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = '';
        $whereclauseids = " chrDelete ='N' ";
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
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by intDisplayOrder desc';
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "testimonial where $whereclauseids group by varName order by intDisplayOrder desc");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }
        $whereclause .= (empty($this->SearchBy)) ? " AND P.varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND P.$this->SearchBy like '%" . addslashes($this->SearchTxt) . "%' AND P.chrDelete='N'";
        $this->db->select('P.int_id,P.varName,P.*', false);
        $this->db->from('testimonial as P', false);
        $this->db->where("P.chrDelete = 'N' $whereclause", NULL, FALSE);
        $this->db->group_by("P.int_id");
        $this->db->order_by($this->OrderBy, $this->OrderType);
        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }
        $rs = $this->db->get();
        $res = $rs->result_array();
        return $res;
    }

    function CountRows() {
        $whereclauseids = "chrDelete ='N'";
        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }
        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('testimonial');
        return $rs;
    }

    function Select_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('P.chrDelete' => 'N', 'P.int_id' => $id);
        $this->db->select('P.*', false);
        $this->db->from('testimonial As P');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert($Files_Name = '') {
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'testimonial WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/testimonial/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varImage']['name'];
            $Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varImage')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $Imagesurl = "";
        }
        if ($tot_recods >= $this->input->post('intDisplayOrder')) {
            $this->mylibrary->UpdateInt_DisplayOrder('testimonial', $this->input->post('intDisplayOrder'), $DisplayOrderClause);
            $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        } else {
            $Int_DisplayOrder = $tot_recods + 1;
        }
        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'varDesignation' => $this->input->post('varDesignation', TRUE),
            'varShortDesc' => $this->input->post('varShortDesc', TRUE),
            'varImage' => $Imagesurl,
            'chrPublish' => $chrPublish,
            'chrDelete' => 'N',
            'intDisplayOrder' => $Int_DisplayOrder,
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
        $this->db->insert('testimonial', $data);
        $id = $this->db->insert_id();
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'testimonial', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update($Files_Name = '') {
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/testimonial/images/';
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
        $Int_DisplayOrder = $this->input->post('intDisplayOrder');
        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'varDesignation' => $this->input->post('varDesignation', TRUE),
            'varShortDesc' => $this->input->post('varShortDesc', TRUE),
            'varImage' => $Imagesurl,
            'chrPublish' => $chrPublish,
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'intDisplayOrder' => $Int_DisplayOrder
        );
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update('testimonial', $data);
        $int_id = $this->input->get_post('ehintglcode');
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'testimonial', 'Name' => 'varName', 'ModuleintGlcode' => $int_id, 'Flag' => 'U', 'Default' => 'int_id');
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'testimonial');
        $this->mylibrary->insertinlogmanager($ParaArray);
    }

    function Select_Share_Page_Rows($id) {
//echo "Select_Share_Page_Rows";exit;
        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "testimonial WHERE chrDelete='N' AND chrPublish='Y' AND int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
//        print_r($result);exit;
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
        $sql = "SELECT p.varName as varName,a.varAlias as varAlias,p.txtDescription as txtDescription,p.varImage as images  FROM " . DB_PREFIX . "testimonial as p
                LEFT JOIN " . DB_PREFIX . "Alias as a ON a.fk_ModuleGlCode='103' AND a.fk_Record=p.int_id 
                WHERE p.chrDelete='N' AND p.chrPublish='Y' AND p.int_id='" . $id . "'";
        $qry = $this->db->query($sql);
        $result = $qry->row_array();
        $paramArr['int_id'] = $id;
        $packagelink = SITE_PATH . $result["varAlias"];
        $paramArr['data']['name'] = $this->input->get_post('varName');
        $paramArr["data"]["actions"] = array("name" => SITE_NAME, "link" => SITE_PATH);
        $paramArr['data']['link'] = $packagelink;
        $Short_Desc = htmlspecialchars($this->input->get_post('txtDescription'));
        $image = SITE_PATH . 'upimages/testimonial/' . $result['images'];
        $paramArr['data']['picture'] = $image;
        if (strlen($Short_Desc) > 100) {
            $Short_Desc = substr($Short_Desc, 0, 100) . "...";
        }
        $paramArr['data']['description'] = $Short_Desc;
        return $paramArr;
    }

    function delete_row() {
        $tablename = 'testimonial';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['SERVER_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'testimonial', 'Name' => 'varName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id');
            $this->mylibrary->insertinlogmanager($ParaArray);
        }
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'testimonial');
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
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'testimonial');
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'testimonial');
    }

    function get_hits($id) {
        $this->db->cache_set_common_path("application/cache/db/common/testimonial/");
        $this->db->cache_delete();
        $this->db->where(array("fk_Record" => $id, "fk_ModuleGlCode" => "97"));
        $SQL = $this->db->get('Alias');
        $RS = $SQL->Result();
        return $RS;
    }

    function SelectAll_front() {
        $flag = 'Y';
        $this->initialize($flag);
        $this->Generateurl($flag);
        $limitby = 'limit ' . $this->Start . ', ' . ABS($this->PageSize);
//echo'Testimonial';exit;
        $sql = "select * from " . DB_PREFIX . "testimonial WHERE chrPublish='Y' and chrDelete='N' and intDisplayOrder<= CURDATE() group by int_id order by intDisplayOrder desc $limitby ";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function CheckDescription($id) {
        $sql = "SELECT chrDescriptionDisplay FROM " . DB_PREFIX . "Pages where int_id=" . $id;
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function CountServices() {

        $sql = "select * from " . DB_PREFIX . "testimonial WHERE chrPublish='Y' and chrDelete='N' group by int_id order by intDisplayOrder desc ";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

}

?>