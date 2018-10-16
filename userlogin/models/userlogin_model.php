<?php

class userlogin_model extends CI_Model {

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
    var $numofuserlogin; // Attribute of Num Of Pagues In Result
    var $OrderBy = 't.dtStartDate'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of Blogize For Paging
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
            $this->PageSize = (!empty($PageSize)) ? $PageSize : 6;
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
            'tablename' => DB_PREFIX . 'Blog',
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

    function Select_All_userlogin_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = "t.chrDelete ='N'"; //


        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varTitle like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
        }

        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .="  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }

        $Type = $this->input->get_post('Type');
        if (!empty($Type)) {
            if ($Type == 'autosearch') {
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by t.dtStartDate desc';
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "Blog t where  $whereclauseids group by t.varTitle $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select("t.int_id AS id, t.varTitle AS name,t.*", false);
        $this->db->select('a.varAlias,a.int_id AS alias_id,a.intPageHits,a.intMobileHits', false);

        $this->db->from('Blog AS t', false);
        $this->db->join('Alias AS a', 'a.fk_Record = t.int_id', 'left', false);
        $this->db->where($whereclauseids);
        $this->db->order_by("$this->OrderBy", $this->OrderType);
        $this->db->order_by("t.dtStartDate,t.int_id", "desc");
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
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varTitle like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }

        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .="  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('Blog');
        return $rs;
    }

    function Select_userlogin_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('T.chrDelete' => 'N', 'T.int_id' => $id);
        $this->db->select('T.*,a.varAlias,a.int_id as Alias_Id');
        $this->db->from('Blog As T');
        $this->db->join('Alias AS a', 'T.int_id = a.fk_Record AND a.fk_ModuleGlCode=' . MODULE_ID, 'left');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert($Images_Name = '') {
        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_userlogin();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($this->input->post('chrImageFlag') == 'S') {
            if (!empty($_FILES['varImage']['name'])) {
                $config['upload_path'] = 'upimages/userlogin/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = '1000000';
                $this->ImageName = $_FILES['varImage']['name'];
                $this->ImageName = str_replace(' ', '_', time() . $this->ImageName);
                $this->ImageName = $this->common_model->Clean_String($this->ImageName);
                $config['file_name'] = $this->ImageName;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('varImage')) {
                    $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                    echo $this->upload->display_errors();
                    exit;
                }
            }
        } else if ($this->input->post('chrImageFlag') == 'E') {
            $this->ImageNameFile = $this->input->post('varExternalUrl');
            $Path_Parts = pathinfo($this->ImageNameFile);
            $this->File_Photo = $Path_Parts['basename'];
            $this->File_Photo = $this->common_model->Clean_String($this->File_Photo);
            $FileExntension = substr(strrchr($this->File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->File_Photo);
            $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $newfile = 'upimages/userlogin/' . $this->File_Photo;
            $newimagethumb = $this->File_Photo;
            if (copy($this->ImageNameFile, $newfile)) {
                $this->Images = glob("upload/*.pdf") + glob("upload/*.pdf");
                $this->Images = array_combine($this->Files, array_map("filemtime", $this->Images));
                arsort($this->Images);
                $this->ImageName = $newimagethumb;
            } else {
                
            }
        }
        if ($this->ImageName == '') {
            $this->ImageName = $this->input->get_post('hidvar_image');
        }
        $this->ExternalUrl = "";
        if ($this->input->post('chrImageFlag') == 'E') {
            $this->ExternalUrl = $this->input->post('varExternalUrl');
        }
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $dtStartDate1 = $this->input->post('dtStartDate');
        $dtStartDate = date("Y-m-d", strtotime($dtStartDate1));
        $endDate = $this->mylibrary->date_convert($this->input->get_post('dtEndDate', true));
        $dtEndDate1 = $this->input->post('dtEndDate');
        $endDate = date("Y-m-d", strtotime($dtEndDate1));
        $endDateExpiry = $this->input->get_post('dt_enddate_expiry', true);
        if (empty($endDateExpiry)) {
            $ChrExpiry = 'Y';
        } else {
            $ChrExpiry = 'N';
            $endDate = '0000-00-00';
        }
        $data = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'varImage' => $this->ImageName,
            'varExternalUrl' => $this->ExternalUrl,
            'chrImageFlag' => $this->input->post('chrImageFlag', true),
            'varShortDesc' => $this->input->post('varShortDesc', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'dtStartDate' => $dtStartDate,
            'chrExpiryDate' => $ChrExpiry,
            'dtEndDate' => $endDate,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
        );

        $query = $this->db->insert(DB_PREFIX . 'Blog', $data);
        $id = $this->db->insert_id();
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Insert_Alias($Alias_Array);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'Blog', 'Name' => 'varTitle', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update($Images_Name = '') {


        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_userlogin();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($this->input->post('chrImageFlag') == 'S') {
            if ($_FILES['varImage']['name'] != '') {
                $config['upload_path'] = 'upimages/userlogin/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = '1000000';
                $this->ImageName = $_FILES['varImage']['name'];
                $Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('varImage')) {
                    
                } else {
                    echo $this->upload->display_errors();
                }
            } else {
                $Imagesurl = $this->input->post('varImageHidden');
            }
        } else if ($this->input->post('chrImageFlag') == 'E') {
            $this->Image = $this->input->post('varExternalUrl');
            $Path_Parts = pathinfo($this->Image);
            $this->Des_File_Photo = $Path_Parts['basename'];
            $this->Des_File_Photo = $this->common_model->Clean_String($this->Des_File_Photo);
            $FileExntension = substr(strrchr($this->Des_File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->Des_File_Photo);
            $this->Des_File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
            $newfile = 'upimages/userlogin/' . $this->Des_File_Photo;
            $newimagethumb = $this->Des_File_Photo;
            if (copy($this->Image, $newfile)) {
                $this->Images = glob("upload/*.pdf") + glob("upload/*.pdf");
                $this->Images = array_combine($this->Files, array_map("filemtime", $this->Images));
                arsort($this->Images);
                $Imagesurl = $this->ImageName = $newimagethumb;
            } else {
                
            }
        }
        $this->ExternalUrl = "";
        if ($this->input->post('chrImageFlag') == 'E') {
            $this->ExternalUrl = $this->input->post('varExternalUrl');
        }
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $dtStartDate1 = $this->input->post('dtStartDate');
        $dtStartDate = date("Y-m-d", strtotime($dtStartDate1));
        $endDate = $this->mylibrary->date_convert($this->input->get_post('dtEndDate', true));
        $dtEndDate1 = $this->input->post('dtEndDate');
        $endDate = date("Y-m-d", strtotime($dtEndDate1));
        $endDateExpiry = $this->input->get_post('dt_enddate_expiry', true);
        if (empty($endDateExpiry)) {
            $ChrExpiry = 'Y';
        } else {
            $ChrExpiry = 'N';
            $endDate = '0000-00-00';
        }
        $data = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'varImage' => $Imagesurl,
            'varExternalUrl' => $this->ExternalUrl,
            'chrImageFlag' => $this->input->post('chrImageFlag', true),
            'varShortDesc' => $this->input->post('varShortDesc', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'dtStartDate' => $dtStartDate,
            'chrExpiryDate' => $ChrExpiry,
            'dtEndDate' => $endDate,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
        $id = $this->db->insert_id();


        $opertion = 'U';
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update(DB_PREFIX . 'Blog', $data);

        $int_id = $this->input->get_post('ehintglcode');
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Update_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'Blog', 'Name' => 'varTitle', 'ModuleintGlcode' => $int_id, 'Flag' => $opertion, 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
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
        $fkuserlogin = $this->input->get_post('fkuserlogin');
        if (empty($fkuserlogin)) {
            $fkuserlogin = 0;
        }
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'Blog', "");
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'Blog');
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'Blog';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d h-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'Blog', 'Name' => 'varTitle', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
            $this->mylibrary->insertinlogmanager($ParaArray);
            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'Blog');
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

    function generate_seocontent_userlogin($fromajax = false) {
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

    function get_hits($id) {

        $this->db->where(array("fk_Record" => $id, "fk_ModuleGlCode" => "104"));
        $SQL = $this->db->get('Alias');
        $RS = $SQL->Result();
        return $RS;
    }

    function Select_Share_Page_Rows($id) {

        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "Blog WHERE chrDelete='N' AND chrPublish='Y' AND int_id='" . $id . "'";
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
                    $param['data']['name'].="\n" . $param['data']['link'];
                }

                if ($this->mylibrary->shareOnTwitter($param) == 1) {
                    $status = 1;
                }
            }
        }
        return $status;
    }

    function get_Post_data($id) {

        $sql = "SELECT p.varTitle as varTitle,a.varAlias as varAlias,p.txtDescription as txtDescription,p.varImage as varImage  FROM " . DB_PREFIX . "Blog as p
                LEFT JOIN " . DB_PREFIX . "Alias as a ON a.fk_ModuleGlCode='104' AND a.fk_Record=p.int_id 
                WHERE p.chrDelete='N' AND p.chrPublish='Y' AND p.int_id='" . $id . "'";
        $qry = $this->db->query($sql);
        $result = $qry->row_array();
        $paramArr['int_id'] = $id;
        $packagelink = SITE_PATH . $result["varAlias"];
        $paramArr['data']['name'] = $this->input->get_post('varTitle');
        $paramArr["data"]["actions"] = array("name" => SITE_NAME, "link" => SITE_PATH);
        $paramArr['data']['link'] = $packagelink;

        $Short_Desc = htmlspecialchars($this->input->get_post('txtDescription'));
        $image = SITE_PATH . 'upimages/userlogin/' . $result['varImage'];
        $paramArr['data']['picture'] = $image;
        if (strlen($Short_Desc) > 100) {
            $Short_Desc = substr($Short_Desc, 0, 100) . "...";
        }
        $paramArr['data']['description'] = $Short_Desc;
        return $paramArr;
    }

    function get_publish_value($id) {
        $returnArry = array();
        $sql = "SELECT chrPublish FROM " . DB_PREFIX . "Blog WHERE chrDelete='N' AND int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result['chrPublish'];
    }

    function SendPassword() {
        $email_header = $this->mylibrary->get_email_header();
        $email_footer = $this->mylibrary->get_email_footer();
        $email_Regards = $this->mylibrary->get_email_regards();

        $email_left = $this->mylibrary->get_email_left();

        $logo = FRONT_MEDIA_URL;
        $siteLogo = FRONT_MEDIA_URL . "Email-Templates/images/logo.png";
        $bgLogo = FRONT_MEDIA_URL . "Email-Templates/images/login_bg.jpg";
        $bullateLogo = FRONT_MEDIA_URL . "Email-Templates/images/site_arrow.png";

        $Email = $this->input->get_post('varEmail', true);
        $user_details = $this->getUserDetails($Email);
        $name = strip_tags($user_details['varName']);

        $varPassword = $user_details['varPassword'];


        $subject = 'Forgot Password: Login details of ' . SITE_NAME;
        $body_admin = '';

        $content = "The following are your login credentials. Please maintain its confidentiality to ensure security of information.";

        $body_admin.= '
                      <tr>
                        <td width="15" height="24" align="left" valign="top"><img src="images/site_arrow.png" style="margin:4px 0 0;padding-right: 8px;vertical-align: top;" alt="" /></td>
                        <td height="24" style="font-family:Arial, Helvetica, sans-serif; color:#636363; font-size:14px;text-align:left;vertical-align:top;"><strong style="color:#252525;">Email Id: </strong><a title="'.$Email.'" href="mailto:'.$Email.'" style="color:#000; text-decoration:none;">'.$Email.'</a></td>
                      </tr>
                      <tr>
                        <td width="15" height="24" align="left" valign="top"><img src="images/site_arrow.png" style="margin:4px 0 0;padding-right: 8px;vertical-align: top;" alt=""/></td>
                        <td height="24" style="font-family:Arial, Helvetica, sans-serif; color:#636363; font-size:14px;text-align:left;vertical-align:top;"><strong style="color:#252525;">Password:</strong> ' . $this->mylibrary->decryptPass($varPassword) . '</td>
                      </tr>';
        
        
//         <a href="#" target="_blank" style="border:none;" rel="nofollow"><img src="images/fb.png" style="border:none;margin-right:10px;" title="Facebook" alt=""  /></a>
//                      <a href="#" target="_blank" style="border:none;" rel="nofollow"><img src="images/twitter.png" style="border:none;margin-right:10px;" title="Twitter" alt=""  /></a>
//                      <a href="#" target="_blank" style="border:none;" rel="nofollow"><img src="images/gplus.png" style="border:none;margin-right:10px;" title="Google Plus" alt=""  /></a>
//                      <a href="#" target="_blank" style="border:none;" rel="nofollow"><img src="images/ytube.png" style="border:none;margin-right:10px;" title="YouTube" alt=""  /></a>
                 
                 
        if (FACEBOOK_LINK != '') {
            $Follow_Usfb .='<a href="'.FACEBOOK_LINK.'" target="_blank" style="border:none;" rel="nofollow"><img src="' . $logo . 'Email-Templates/images/fb.png" style="border:none;margin-right:10px;" title="Facebook" alt="Facebook"  /></a>';
//            $Follow_Usfb .='<a href = "' . FACEBOOK_LINK . '" target = "_blank" style = "border:none;" ><img src = "' . $logo . 'mailtemplates/images/fb.png" style = "border:none;margin-right:10px;" title = "Facebook" alt = "Facebook" /></a>';
        }
        if (TWITTER_LINK != '') {
//            $Follow_Usli .='<a href = "' . TWITTER_LINK . '" target = "_blank" style = "border:none;" ><img src = "' . $logo . 'mailtemplates/images/twitter.png" style = "border:none;margin-right:10px;" title = "Twitter" alt = "Twitter" /></a>';
            $Follow_Usli .='<a href="'.TWITTER_LINK.'" target="_blank" style="border:none;" rel="nofollow"><img src="' . $logo . 'Email-Templates/images/twitter.png" style="border:none;margin-right:10px;" title="Twitter" alt="Twitter"  /></a>';
        }
        if (PINTEREST_LINK != '') {
            $Follow_uspi .='<a href="'.PINTEREST_LINK.'" target="_blank" style="border:none;" rel="nofollow"><img src="' . $logo . 'Email-Templates/images/pintrest.png" style="border:none;margin-right:10px;" title="Pinterest" alt="Pinterest"  /></a>';
        }
        if (GOOGLE_PLUS_LINK != '') {
            $Follow_Usgp .='<a href="'.GOOGLE_PLUS_LINK.'" target="_blank" style="border:none;" rel="nofollow"><img src="' . $logo . 'Email-Templates/images/gplus.png" style="border:none;margin-right:10px;" title="Google Plus" alt="Google Plus"  /></a>';
        }

        $html_message = file_get_contents(FRONT_MEDIA_URL . "Email-Templates/forgot_password.html");

//        $name = $userRow['varName'];

        $html_message = str_replace("@NAME", $name, $html_message);
        $html_message = str_replace("@EMAIL_ID", $_POST['ss_username'], $html_message);
        $html_message = str_replace("@LOGO", $siteLogo, $html_message);
        $html_message = str_replace("@BGLOGO", $bgLogo, $html_message);
        $html_message = str_replace("@DEAR", 'Dear', $html_message);
        $html_message = str_replace("@ADMIN", 'Dear Administrator', $html_message);
        $html_message = str_replace("@CONTENT", $content, $html_message);
        $html_message = str_replace("@DETAILS", $body_admin, $html_message);
        $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
        $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
        $html_message = str_replace("@MEDIA_URL", ADMIN_MEDIA_URL, $html_message);
        $html_message = str_replace("@SITE_URL", SITE_NAME, $html_message);
        $html_message = str_replace("@SITE_NAME", 'Best Regards, ', $html_message);
        $html_message = str_replace("@YEAR", date('Y'), $html_message);
        $html_message = str_replace("@FACEBOOK", $Follow_Usfb, $html_message);
        $html_message = str_replace("@TWITTER", $Follow_Usli, $html_message);
        $html_message = str_replace("@PINTREST", $Follow_uspi, $html_message);
        $html_message = str_replace("@GOOGLE", $Follow_Usgp, $html_message);
//        echo $html_message;
//        exit;
        $forgot_pass = $this->mylibrary->send_mail($Email, $subject, $html_message);
//        if ($forgot_pass == 'success') {
            $data = array(
                'chrReceiver_Type' => 'U',
                'fk_EmailType' => '4',
                'varFrom' => MAIL_FROM,
                'txtTo' => $Email,
                'txtSubject' => $subject,
                'txtBody' => $html_message,
                'chrDelete' => 'N',
                'chrPublish' => 'Y',
                'dtCreateDate' => date('Y-m-d H:i:s'),
            );

            $this->db->insert('Emails', $data);

            return true;
//        } else {
//            return false;
//        }
    }

    function SelectAll_front() {
        $flag = 'Y';
        $this->initialize($flag);
        $this->Generateurl($flag);
        $limitby = 'limit ' . $this->Start . ', ' . ABS($this->PageSize);
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "Blog as N LEFT JOIN " . DB_PREFIX . "Alias as A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='104' WHERE N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.dtStartDate desc,N.int_id desc $limitby";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function CountRow_front() {

        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "Blog as N LEFT JOIN " . DB_PREFIX . "Alias as A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='104' WHERE N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.dtStartDate asc ";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    public function SelectAll_Detail_front($id) {
        $sql = " select * from " . DB_PREFIX . "Blog where chrDelete='N' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getUserDetails($email) {
//        $pass = $this->mylibrary->cryptPass($pass1);
        $sql = "select * from " . DB_PREFIX . "Registration where varEmail='" . $email . "' and chrDelete='N' and chrPublish='Y'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
        ;
    }

    public function checkuseraccess($email, $pass1) {
        $pass = $this->mylibrary->cryptPass($pass1);
        $sql = "select * from " . DB_PREFIX . "Registration where varEmail='" . $email . "' and varPassword='" . $pass . "' and chrDelete='N' and chrPublish='Y'";
//        echo $sql;
//        exit;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        return $count;
    }

    public function checkuseraccess1($email) {
        $pass = $this->mylibrary->cryptPass($pass1);
        $sql = "select * from " . DB_PREFIX . "Registration where varEmail='" . $email . "' and chrDelete='N' and chrPublish='Y'";
//        echo $sql;
//        exit;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        return $count;
    }

    function setsession($email, $pass1) {

        $pass = $this->mylibrary->cryptPass($pass1);
        $sql = "select * from " . DB_PREFIX . "Registration where varEmail='" . $email . "' and varPassword='" . $pass . "' and chrDelete='N' and chrPublish='Y'";
        $query = $this->db->query($sql);

        if ($query->num_rows == 1) {
            $row = $query->row();

            $Data = array(
                'int_id' => $row->int_id,
                'varName' => $row->varName,
                'varEmail' => $row->varEmail,
                'varImage' => $row->varImage
            );
            $this->session->sess_expiration = '14400'; // expires in 4 hours
//            $this->session->sess_expiration = '32140800'; //~ one year
            $this->session->set_userdata($Data);


            return true;
        }
    }

    public function Check_forgotpassword() {
//        $Eid = $this->input->get_post('Eid', FALSE);
//        if (!empty($Eid)) {
//            $this->db->where_not_in('int_id', $Eid);
//        }
        $this->db->where('varEmail', $this->input->get_post('User_Email', FALSE));
        $query = $this->db->get('Registration');
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function Check_Email1() {
//        $Eid = $this->input->get_post('Eid', FALSE);
//        if (!empty($Eid)) {
//            $this->db->where_not_in('int_id', $Eid);
//        }
        $this->db->where('varEmail', $this->input->get_post('User_Email', FALSE));
        $query = $this->db->get('Registration');
        if ($query->num_rows() >= 1) {
            return false;
        } else {
            return true;
        }
    }

    function getBlogdetail($id) {

        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "Blog as N LEFT JOIN " . DB_PREFIX . "Alias as A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='101' WHERE N.chrPublish='Y' and N.chrDelete='N' AND N.int_id='$id'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

}

?>