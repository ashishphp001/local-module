<?php

class commonfiles_model extends CI_Model {

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
    var $numofcommonfiles; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'intDisplayOrder'; // Attribute of Deafult Order By
    var $OrderType = 'asc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of CommonFilesize For Paging
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

        /* Declare it in every module */
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
        $this->PageName = MODULE_PAGE_NAME . '?' . $this->Appendfk_Country_Site;
        $this->AddPageName = MODULE_PAGE_NAME . '/add?' . $this->Appendfk_Country_Site;
        $this->DeletePageName = MODULE_PAGE_NAME . '/delete?' . $this->Appendfk_Country_Site;
        $this->HUrlWithPara = $this->PageName . '&' . 'hPageSize=' . $this->PageSize . '&hNumOfRows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hOrderType=' . $this->OrderType . '&hSearchBy=' . $this->SearchBy . '&hSearchTxt=' . urlencode($this->SearchTxt) . '&hPageNumber=' . $this->PageNumber . '&hFilterBy=' . $this->FilterBy . '&history=T';
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithOutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . urlencode($this->OrderType) . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithOutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt);
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal . $this->Appendfk_Country_Site;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
    }

    function generateParam($position = 'top') {

        $PageSize = $this->PageSize;
        return array(
            'PageUrl' => MODULE_PAGE_NAME,
            'heading' => 'Manage Common Files',
            'listFile' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'commonfiles',
            'position' => $position,
            'actionFile' => 'add-new-button-blue.gif',
            'actionFileHover' => 'add-new-button-blue-hover.gif',
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
            'search' => array('searchArray' => array("C.varTitle" => "Title"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
        );
    }

    function Select_All_commonfiles_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = "C.chrDelete ='N'"; //

        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND C.varTitle like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
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
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by C.intDisplayOrder asc';
                $autoSearchQry = $this->db->query("select C.*,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "commonfiles C  where  $whereclauseids group by C.varTitle $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select("C.*", false);
        $this->db->from('commonfiles as C', false);
        $this->db->where($whereclauseids);
        $this->db->group_by('C.int_id');
        $this->db->order_by($this->OrderBy, $this->OrderType);
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
            $whereclauseids1 .= (empty($this->SearchBy)) ? " AND varTitle like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }
        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .="  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('commonfiles');
        return $rs;
    }

    function Select_commonfiles_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('chrDelete' => 'N', 'int_id' => $id);
        $this->db->select('*');
        $this->db->from('commonfiles');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert($Files_Name = '') {
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'commonfiles WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;
        if ($this->permissionArry['Approve'] == 'Y') {
            if ($tot_recods >= $this->input->post('int_displayorder')) {
                $this->mylibrary->UpdateInt_DisplayOrder('commonfiles', $this->input->post('intDisplayOrder'), '');
                $Int_DisplayOrder = $this->input->post('intDisplayOrder');
            } else {
                $Int_DisplayOrder = $tot_recods + 1;
            }
        }

        if ($this->input->post('chrFileFlag') == 'S') {

            $filename = $_FILES['varFile']['name'];
            $filename = preg_replace('/[\/:*?"&!@#$()+%^\'<>| ]/', '', $filename);
            $fileexntension = substr(strrchr($filename, '.'), 1);
            $var_title = str_replace('.' . $fileexntension, '', $filename);
            $filename = $var_title . "_" . time() . "." . $fileexntension;
            $filename = str_replace(' ', "_", $filename);
            $filename = str_replace('%', "_", $filename);
            $Filesurl = $filename;
            $tmp_name = $_FILES["varFile"]["tmp_name"];
            $uploads_dir = 'upimages/commonfiles';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
        } else if ($this->input->post('chrFileFlag') == 'B') {
            $this->FileName = $this->input->post('VarDropboxFile');
            if ($this->FileName != '') {
                $this->FileName = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $this->FileName);
                $Path_Parts = pathinfo($this->FileName);
                $extension = explode('?', $Path_Parts['basename']);
                $this->File_Photo = $this->common_model->Clean_String($extension[count($extension) - 2]);
                $FileExntension = substr(strrchr($this->File_Photo, '.'), 1);
                $Var_Title = str_replace('.' . $FileExntension, '', $this->File_Photo);
                $this->File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
                $NewFile = 'upimages/commonfiles/' . $this->File_Photo;
                $Filesurl = $this->File_Photo;
                $this->ExternalUrlFile = $this->FileName;
                if (copy($this->FileName, $NewFile)) {
                    
                } else {
                    echo "Upload failed.";
                }
            } else {
                $Filesurl = $this->input->post('varFileHidden');
            }
        } else if ($this->input->post('chrFileFlag') == 'E') {
            $this->File = $this->input->post('varExternalUrl');
            $Path_Parts = pathinfo($this->File);
            $this->Des_File_Photo = $Path_Parts['basename'];
            $this->Des_File_Photo = $this->common_model->Clean_String($this->Des_File_Photo);
            $FileExntension = substr(strrchr($this->Des_File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->Des_File_Photo);
            $this->Des_File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
            $newfile = 'upimages/commonfiles/' . $this->Des_File_Photo;
            $newimagethumb = $this->Des_File_Photo;
            if (copy($this->File, $newfile)) {
                $this->Files = glob("upload/*.pdf") + glob("upload/*.pdf");
                $this->Files = array_combine($this->Files, array_map("filemtime", $this->Files));
                arsort($this->Files);
                $Filesurl = $this->FileName = $newimagethumb;
            } else {
                echo "Upload failed.";
            }
        }
        $this->ExternalUrlFile = "";
        if ($this->input->post('chrFileFlag') == 'E') {
            $this->ExternalUrlFile = $this->input->post('varExternalUrl');
        }
        
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        $data = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'varFile' => $Filesurl,
            'varExternalUrl' => $this->ExternalUrlFile,
            'chrFileFlag' => $this->input->post('chrFileFlag', TRUE),
            'chrPublish' => $chrPublish,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'intDisplayOrder' => $Int_DisplayOrder,
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
//        echo '<pre/>';
//        print_r($data);
//        die;
        $query = $this->db->insert(DB_PREFIX . 'commonfiles', $data);
        $id = $this->db->insert_id();
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'commonfiles');
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'commonfiles', 'Name' => 'varTitle', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function Insert_commonfiles() {

        if (!empty($_FILES['varFile']['name'])) {
            $config['upload_path'] = 'upimages/commonfiles/';
            $config['allowed_types'] = 'doc|docx|pdf|rar|xls|xlsx|ppt|pptx|zip|rtf';
            $config['max_size'] = '1000000';
            $this->FileName = $_FILES['varFile']['name'];
            $this->FileName = str_replace(' ', '_', time() . $this->FileName);
            $this->FileName = $this->common_model->Clean_String($this->FileName);
            $config['file_name'] = $this->FileName;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('varFile')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
//                exit;
            }
        }

        if ($this->FileName == '') {
            $this->FileName = $this->input->get_post('hidvar_image');
        }

        $chrPublish = 'Y';
        $data = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'varFile' => $this->FileName,
            'chrFileFlag' => 'S',
            'chrPublish' => $chrPublish,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'intDisplayOrder' => 1,
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );

        $query = $this->db->insert(DB_PREFIX . 'commonfiles', $data);
        $id = $this->db->insert_id();
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'commonfiles');
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'commonfiles', 'Name' => 'varTitle', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update($Files_Name = '') {
        if ($this->input->post('intDisplayOrder') != $this->input->post('Old_DisplayOrder')) {
            $this->mylibrary->Update_Display_Order($this->input->post('ehintglcode'), $this->input->post('intDisplayOrder'), $this->input->post('Old_DisplayOrder'), '', 'commonfiles');
        }

        if ($this->input->post('chrFileFlag') == 'S') {
            $filename = $_FILES['varFile']['name'];
            if(!empty($filename)){
            $filename = preg_replace('/[\/:*?"&!@#$()+%^\'<>| ]/', '', $filename);
            $fileexntension = substr(strrchr($filename, '.'), 1);
            $var_title = str_replace('.' . $fileexntension, '', $filename);
            $filename = $var_title . "_" . time() . "." . $fileexntension;
            $filename = str_replace(' ', "_", $filename);
            $filename = str_replace('%', "_", $filename);
            $Filesurl = $filename;
            $tmp_name = $_FILES["varFile"]["tmp_name"];
            $uploads_dir = 'upimages/commonfiles';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
            } else {
                $Filesurl = $this->input->post('varFileHidden');
            }
        } else if ($this->input->post('chrFileFlag') == 'B') {
            $this->FileName = $this->input->post('VarDropboxFile');
            if ($this->FileName != '') {
                $this->FileName = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $this->FileName);
                $Path_Parts = pathinfo($this->FileName);
                $extension = explode('?', $Path_Parts['basename']);
                $this->File_Photo = $this->common_model->Clean_String($extension[count($extension) - 2]);
                $FileExntension = substr(strrchr($this->File_Photo, '.'), 1);
                $Var_Title = str_replace('.' . $FileExntension, '', $this->File_Photo);
                $this->File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
                $NewFile = 'upimages/commonfiles/' . $this->File_Photo;
                $Filesurl = $this->File_Photo;
                $this->ExternalUrl = $this->FileName;
                if (copy($this->FileName, $NewFile)) {
                    
                } else {
                    echo "Upload failed.";
                }
            } else {
                $Filesurl = $this->input->post('varFileHidden');
            }
        } else if ($this->input->post('chrFileFlag') == 'E') {
            $this->File = $this->input->post('varExternalUrl');
            $Path_Parts = pathinfo($this->File);
            $this->Des_File_Photo = $Path_Parts['basename'];
            $this->Des_File_Photo = $this->common_model->Clean_String($this->Des_File_Photo);
            $FileExntension = substr(strrchr($this->Des_File_Photo, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->Des_File_Photo);
            $this->Des_File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
            $newfile = 'upimages/commonfiles/' . $this->Des_File_Photo;
            $newimagethumb = $this->Des_File_Photo;
            if (copy($this->File, $newfile)) {
                $this->Files = glob("upload/*.pdf") + glob("upload/*.pdf");
                $this->Files = array_combine($this->Files, array_map("filemtime", $this->Files));
                arsort($this->Files);
                $Filesurl = $this->FileName = $newimagethumb;
            } else {
                echo "Upload failed.";
            }
        }
        $this->ExternalUrl = "";
        if ($this->input->post('chrFileFlag') == 'E') {
            $this->ExternalUrl = $this->input->post('varExternalUrl');
        }
//        if ($this->input->post('chrFileFlag') == 'S') {
//
//            $filename = $_FILES['varFile']['name'];
//             
//            $filename = preg_replace('/[\/:*?"&!@#$()+%^\'<>| ]/', '', $filename);
//            $fileexntension = substr(strrchr($filename, '.'), 1);
//            $var_title = str_replace('.' . $fileexntension, '', $filename);
//            if ($_FILES['varFile']['name'] == '') {
//                $filename = '';
//            } else {
//                $filename = $var_title . "_" . time() . "." . $fileexntension;
//            }
//            $filename = str_replace(' ', "_", $filename);
//            $filename = str_replace('%', "_", $filename);
//            $Filesurl = $filename;
//            $tmp_name = $_FILES["varFile"]["tmp_name"];
//            $uploads_dir = 'upimages/commonfiles';
//            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
//        } else if ($this->input->post('chrFileFlag') == 'B') {
//            $this->FileName = $this->input->post('VarDropboxFile');
//            if ($this->FileName != '') {
//                $this->FileName = str_replace('www.dropbox.com', 'dl.dropboxusercontent.com', $this->FileName);
//                $Path_Parts = pathinfo($this->FileName);
//                $extension = explode('?', $Path_Parts['basename']);
//                $this->File_Photo = $this->common_model->Clean_String($extension[count($extension) - 2]);
//                $FileExntension = substr(strrchr($this->File_Photo, '.'), 1);
//                $Var_Title = str_replace('.' . $FileExntension, '', $this->File_Photo);
//                $this->File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
//                $NewFile = 'upimages/commonfiles/' . $this->File_Photo;
//                $Filesurl = $this->File_Photo;
//                $this->ExternalUrlFile = $this->FileName;
//                if (copy($this->FileName, $NewFile)) {
//                    
//                } else {
//                    echo "Upload failed.";
//                }
//            } else {
//                $Filesurl = $this->input->post('varFileHidden');
//            }
//        } else if ($this->input->post('chrFileFlag') == 'E') {
//            $this->File = $this->input->post('varExternalUrl');
//            $Path_Parts = pathinfo($this->File);
//            $this->Des_File_Photo = $Path_Parts['basename'];
//            $this->Des_File_Photo = $this->common_model->Clean_String($this->Des_File_Photo);
//            $FileExntension = substr(strrchr($this->Des_File_Photo, '.'), 1);
//            $Var_Title = str_replace('.' . $FileExntension, '', $this->Des_File_Photo);
//            $this->Des_File_Photo = $Var_Title . "_" . time() . "." . $FileExntension;
//            $newfile = 'upimages/commonfiles/' . $this->Des_File_Photo;
//            $newimagethumb = $this->Des_File_Photo;
//            if (copy($this->File, $newfile)) {
//                $this->Files = glob("upload/*.pdf") + glob("upload/*.pdf");
//                $this->Files = array_combine($this->Files, array_map("filemtime", $this->Files));
//                arsort($this->Files);
//                $Filesurl = $this->FileName = $newimagethumb;
//            } else {
//                echo "Upload failed.";
//            }
//        }
//        if ($this->input->post('varFileHidden') != '') {
//            $Filesurl = $this->input->post('varFileHidden');
//        }
//        $this->ExternalUrlFile = "";
//        if ($this->input->post('chrFileFlag') == 'E') {
//            $this->ExternalUrlFile = $this->input->post('varExternalUrl');
//        }
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        $data = array(
            'varTitle' => $this->input->post('varTitle', TRUE),
            'varFile' => $Filesurl,
            'varExternalUrl' => $this->ExternalUrl,
            'chrFileFlag' => $this->input->post('chrFileFlag', true),
            //'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'chrPublish' => $chrPublish,
            'intDisplayOrder' => $this->input->post('intDisplayOrder', TRUE),
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
     
//            $data['intDisplayOrder'] = $this->input->get_post('Old_DisplayOrder');
        //$this->db->insert(DB_PREFIX . 'commonfiles', $data);
        $id = $this->db->insert_id();

        $int_id = $id;
        $opertion = 'U';
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update(DB_PREFIX . 'commonfiles', $data);

        $int_id = $this->input->get_post('ehintglcode');
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'commonfiles', 'Name' => 'varTitle', 'ModuleintGlcode' => $int_id, 'Flag' => $opertion, 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'commonfiles');
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
        $fkcommonfiles = $this->input->get_post('fkcommonfiles');
        if (empty($fkcommonfiles)) {
            $fkcommonfiles = 0;
        }
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'commonfiles', "");
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'commonfiles');
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'commonfiles';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'commonfiles', 'Name' => 'varTitle', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id');
            $this->mylibrary->insertinlogmanager($ParaArray);
            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'commonfiles');
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



    function addCommonFiles($data54) {

        $select_tag = "select * from " . DB_PREFIX . "tag where var_tagname='" . $data54['var_tagname'] . "' and chr_publish='Y' and chr_delete='N'";
        $records_tag = $this->db->query($select_tag);
        $round_tag = $records_tag->result();
        if (count($round_tag) > 0) {
            echo "NO" . "*#*";
        } else {

            $select_tag1 = "select * from " . DB_PREFIX . "tag order by int_glcode desc";
            $records_tag1 = $this->db->query($select_tag1);
            $round_tag1 = $records_tag1->result_array();

            $display_order = $round_tag1[0]['int_displayorder'] + 1;
            $data1 = array(
                'var_tagname' => $data54['var_tagname'],
                'int_displayorder' => $display_order,
                'chr_publish' => 'Y',
                'chr_delete' => 'N',
            );

//       print_r($data);

            $this->db->insert(DB_PREFIX . 'tag', $data1);

            $id1 = $this->db->insert_id();
//        $this->tagcombo('', $id1);
            $this->mylibrary->insertinlogmanager(MODULE_ID, DB_PREFIX . 'tag', 'var_tagname', $id1, 'I', 'int_glcode');
            echo $id1 . "*#*";
        }
    }

    function add_commonfiles($value, $hid) {

        $sql = "select * from " . DB_PREFIX . "commonfiles where chrDelete='N' and chrPublish='Y' order by intDisplayOrder ";
        $records = $this->db->query($sql);
        $selected_ids = Array();

        if ($hid == 1) {
            $name = 'varOnBoard[]';
            $id = 'varOnBoard';
        } else {
            $name = 'varOptionalEquipment[]';
            $id = 'varOptionalEquipment';
        }
        $otherString = ' id="' . $id . '" class="more-textarea fl" style="width:420px;" size="5" multiple=multiple  get_width_height(this.value)  "';
        $options = Array();

        foreach ($records->result() as $row) {
            $options[$row->int_id] = ucwords($row->varTitle);
        }

        $moduleSelectBox = array('name' => $name,
            'style' => 'class:more-textarea;',
            'options' => $options,
            'otherString' => $otherString,
            'selected_ids' => $value,
            'tdoption' => Array('TDDisplay' => 'Y'),
        );
        $display_output = form_input_ready($moduleSelectBox, 'select');
        return $display_output;
    }


}

?>