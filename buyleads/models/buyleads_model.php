<?php

class buyleads_model extends CI_Model {

    var $int_id;
    var $fk_ParentPageGlCode;
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
    var $numofbuyleads; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'b.int_id'; // Attribute of Deafult Order By
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
            'tablename' => DB_PREFIX . 'buyleads',
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
            'search' => array('searchArray' => array("varName" => "Title"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            )
        );
    }

    function Select_All_buyleads_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = "b.chrDelete ='N'"; //


        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
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
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by b.int_id asc';
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "buyleads b where  $whereclauseids group by b.varName $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select("b.int_id AS id, b.varName AS name,b.*,pc.varName as category_name,u.varName as customer_name,u.varCompany", false);
        $this->db->select('a.varAlias,a.int_id AS alias_id,a.intPageHits,a.intMobileHits', false);
        $this->db->from('buyleads AS b', false);
        $this->db->join('alias AS a', 'a.fk_Record = b.int_id', 'left', false);
        $this->db->join('product_category AS pc', 'pc.int_id = b.intParentCategory', 'left', false);
        $this->db->join('users AS u', 'u.int_id = b.intUser', 'left', false);
        $this->db->where($whereclauseids);
        $this->db->order_by("$this->OrderBy", $this->OrderType);
        $this->db->group_by('b.int_id');

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
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
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
        $rs = $this->db->count_all_results('buyleads');
        return $rs;
    }

    function Select_buyleads_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('T.chrDelete' => 'N', 'T.int_id' => $id);
        $this->db->select('T.*,a.varAlias,a.int_id as Alias_Id');
        $this->db->from('buyleads As T');
        $this->db->join('alias AS a', 'T.int_id = a.fk_Record AND a.fk_ModuleGlCode=' . MODULE_ID, 'left');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert() {
//echo "<pre>";
//print_r($_REQUEST);exit;
        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_buyleads();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/buyleads/images/';
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
        } else {
            $Imagesurl = "";
        }



        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $reqDisplaydata = ($this->input->post('chrRequirement') == 'U') ? 'U' : 'D';
        $Import = ($this->input->post('chrImport') == 'Y') ? 'Y' : 'N';
        if ($reqDisplaydata == 'D') {
            $days = $this->input->post('varDays');
        } else {
            $days = "";
        }

        $business_type = $this->input->post('varBusinessType');
        if ($business_type != '') {
            $business_type = implode(",", $business_type);
        } else {
            $business_type = "";
        }


        $getproduct = $this->getProduct($this->input->post('varName', TRUE));
        if ($getproduct != '') {
            $product_id = $getproduct['int_id'];
        }
        if ($product_id == '') {
            $product_id = '';
        }

        $ApproxOrderdata = ($this->input->post('chrApproxOrder') == 'on') ? 'Y' : 'N';
        if ($ApproxOrderdata == 'Y') {
            $start = $this->input->post('varStartPrice', TRUE);
            $end = $this->input->post('varEndPrice', TRUE);
            $approx_currency = $this->input->post('varApproxCurrency', TRUE);
        } else {
            $start = "";
            $end = "";
            $approx_currency = "";
        }

        $QuantityDisplaydata = ($this->input->post('chrQuantity') == 'on') ? 'Y' : 'N';
        if ($QuantityDisplaydata == 'Y') {
            $quantity = $this->input->post('varQuantity', TRUE);
            $unit = $this->input->post('intUnit', TRUE);
        } else {
            $quantity = "";
            $unit = "";
        }


        $data = array(
            'intUser' => $this->input->post('intUser', TRUE),
            'varName' => $this->input->post('varName', TRUE),
            'intProduct' => $product_id,
            'intParentCategory' => $this->input->post('intParentCategory', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'varReqType' => $this->input->post('varReqType', TRUE),
            'chrQuantity' => $QuantityDisplaydata,
            'varQuantity' => $quantity,
            'intUnit' => $unit,
            'chrApproxOrder' => $ApproxOrderdata,
            'varApproxCurrency' => $approx_currency,
            'varStartPrice' => $start,
            'varEndPrice' => $end,
            'chrRequirement' => $reqDisplaydata,
            'varDays' => $days,
            'chrImageFlag' => 'S',
            'varImage' => $Imagesurl,
            'varLocation' => $this->input->post('varLocation', TRUE),
            'varLocation2' => $this->input->post('varLocation2', TRUE),
            'varLocation3' => $this->input->post('varLocation3', TRUE),
            'varLatitude' => $this->input->post('varLatitude', TRUE),
            'varLongitude' => $this->input->post('varLongitude', TRUE),
            'varLatitude2' => $this->input->post('varLatitude2', TRUE),
            'varLongitude2' => $this->input->post('varLongitude2', TRUE),
            'varLatitude3' => $this->input->post('varLatitude3', TRUE),
            'varLongitude3' => $this->input->post('varLongitude3', TRUE),
            'varBusinessType' => $business_type,
            'varPackaging' => $this->input->post('varPackaging', TRUE),
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varExpectedPrice' => $this->input->post('varExpectedPrice', TRUE),
            'intEUnit' => $this->input->post('intEUnit', TRUE),
            'varDestination' => $this->input->post('varDestination', TRUE),
            'chrImport' => $Import,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
//        print_r($data);
//        exit;
        $query = $this->db->insert(DB_PREFIX . 'buyleads', $data);
        $id = $this->db->insert_id();


        $countfiles = count($_FILES['files']['name']);
        if ($countfiles > 0) {
            for ($i = 0; $i < $countfiles; $i++) {
                $filename = $_FILES['files']['name'][$i];

                $filename = preg_replace('/[\/:*?"&!@#$()+%^\'<>| ]/', '', $filename);
                $fileexntension = substr(strrchr($filename, '.'), 1);
                if ($fileexntension != '') {
                    $var_title = str_replace('.' . $fileexntension, '', $filename);
                    $filename = $var_title . "_" . time() . "." . $fileexntension;
                    $filename = str_replace(' ', "_", $filename);
                    $filename = str_replace('%', "_", $filename);
                    $Filesurl = $filename;
                    $tmp_name = $_FILES['files']['tmp_name'][$i];
                    $uploads_dir = 'upimages/buyleads/file';
                    move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
                    $data = array(
                        'varTitle' => $var_title,
                        'varFile' => $Filesurl,
                        'chrFileFlag' => 'S',
                        'intBuyLeads' => $id,
                        'dtCreateDate' => date('Y-m-d H-i-s'),
                        'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                        'PUserGlCode' => ADMIN_ID
                    );
                    $this->db->insert(DB_PREFIX . 'buylead_docs', $data);
                }
            }
        }
        $alias = $this->input->post('varAlias', TRUE);
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $alias);
        $this->common_model->Insert_Alias($Alias_Array);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'buyleads', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function insert_rfq() {
//        echo "<pre>";

        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/buyleads/images/';
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
        } else {
            $Imagesurl = "";
        }



        $reqDisplaydata = ($this->input->post('chrRequirement') == 'U') ? 'U' : 'D';
        $Import = ($this->input->post('chrImport') == 'Y') ? 'Y' : 'N';
        if ($reqDisplaydata == 'D') {
            $days = $this->input->post('varDays');
        } else {
            $days = "";
        }

        $business_type = $this->input->post('varBusinessType');
        if ($business_type != '') {
            $business_type = implode(",", $business_type);
        } else {
            $business_type = "";
        }


        $getproduct = $this->getProduct($this->input->post('varProduct', TRUE));
        if ($getproduct['int_id'] != '') {
            $product_id = $getproduct['int_id'];
        }

        if ($product_id == '') {
            $product_id = '';
        }


        $start = $this->input->post('varStartPrice', TRUE);
        $end = $this->input->post('varEndPrice', TRUE);
        $approx_currency = $this->input->post('varApproxCurrency', TRUE);


        $QuantityDisplaydata = 'Y';
        if ($QuantityDisplaydata == 'Y') {
            $quantity = $this->input->post('varQuantity', TRUE);
            $unit = $this->input->post('intUnit', TRUE);
        } else {
            $quantity = "";
            $unit = "";
        }


        $data = array(
            'intUser' => $this->input->post('intUser', TRUE),
            'varName' => $this->input->post('varProduct', TRUE),
            'intProduct' => $product_id,
            'intParentCategory' => $this->input->post('intParentCategory', TRUE),
            'txtDescription' => $this->input->post('txtDescription'),
            'varReqType' => $this->input->post('varReqType', TRUE),
            'chrQuantity' => $QuantityDisplaydata,
            'varQuantity' => $quantity,
            'intUnit' => $unit,
            'chrApproxOrder' => 'Y',
            'varApproxCurrency' => $approx_currency,
            'varStartPrice' => $start,
            'varEndPrice' => $end,
            'chrRequirement' => $reqDisplaydata,
            'varDays' => $days,
            'chrImageFlag' => 'S',
            'varImage' => $Imagesurl,
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varExpectedPrice' => $this->input->post('varExpectedPrice', TRUE),
            'intEUnit' => $this->input->post('intEUnit', TRUE),
            'varLocation' => $this->input->post('varLocation', TRUE),
            'varLocation2' => $this->input->post('varLocation2', TRUE),
            'varLocation3' => $this->input->post('varLocation3', TRUE),
            'varLatitude' => $this->input->post('varLatitude', TRUE),
            'varLongitude' => $this->input->post('varLongitude', TRUE),
            'varLatitude2' => $this->input->post('varLatitude2', TRUE),
            'varLongitude2' => $this->input->post('varLongitude2', TRUE),
            'varLatitude3' => $this->input->post('varLatitude3', TRUE),
            'varLongitude3' => $this->input->post('varLongitude3', TRUE),
            'varBusinessType' => $business_type,
            'varPackaging' => $this->input->post('varPackaging', TRUE),
            'varDestination' => $this->input->post('varDestination', TRUE),
            'chrImport' => $Import,
            'chrPublish' => 'N',
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );

        $query = $this->db->insert(DB_PREFIX . 'buyleads', $data);
        $id = $this->db->insert_id();


        if ($_FILES['files']['name'] != '') {
            $filename = $_FILES['files']['name'];
            $filename = preg_replace('/[\/:*?"&!@#$()+%^\'<>| ]/', '', $filename);
            $fileexntension = substr(strrchr($filename, '.'), 1);
            $var_title = str_replace('.' . $fileexntension, '', $filename);
            $filename = $var_title . "_" . time() . "." . $fileexntension;
            $filename = str_replace(' ', "_", $filename);
            $filename = str_replace('%', "_", $filename);
            $Filesurl = $filename;
            if ($fileexntension != '') {
                $tmp_name = $_FILES["files"]["tmp_name"];
                $uploads_dir = 'upimages/buyleads/file';
                move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);

                $data = array(
                    'varTitle' => $var_title,
                    'varFile' => $Filesurl,
                    'chrFileFlag' => 'S',
                    'intBuyLeads' => $id,
                    'dtCreateDate' => date('Y-m-d H-i-s'),
                    'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                    'PUserGlCode' => ADMIN_ID
                );
                $this->db->insert(DB_PREFIX . 'buylead_docs', $data);
            }
        }
        return $id;
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



                    $getproduct = $this->getProduct($emapData[2]);
                    if ($getproduct['int_id'] != '') {
                        $product_id = $getproduct['int_id'];
                    } else {
                        $product_id = "";
                    }

                    $data = array(
                        'int_id' => $emapData[0],
                        'intUser' => $emapData[1],
                        'varName' => $emapData[2],
                        'intProduct' => $product_id,
                        'intParentCategory' => $emapData[4],
                        'txtDescription' => $emapData[5],
                        'varReqType' => $emapData[6],
                        'chrQuantity' => $emapData[27],
                        'varQuantity' => $emapData[7],
                        'intUnit' => $emapData[8],
                        'chrApproxOrder' => $emapData[10],
                        'varApproxCurrency' => $emapData[9],
                        'varStartPrice' => $emapData[11],
                        'varEndPrice' => $emapData[12],
                        'chrRequirement' => $emapData[13],
                        'varDays' => $emapData[14],
                        'chrImageFlag' => 'S',
                        'varImage' => $emapData[15],
                        'varCurrency' => $emapData[28],
                        'varExpectedPrice' => $emapData[29],
                        'intEUnit' => $emapData[30],
                        'varLocation' => $emapData[16],
                        'varLocation2' => str_replace('"', '', $emapData[17]),
                        'varLocation3' => $emapData[18],
                        'varLatitude' => $emapData[19],
                        'varLongitude' => $emapData[20],
                        'varLatitude2' => $emapData[21],
                        'varLongitude2' => $emapData[22],
                        'varLatitude3' => $emapData[23],
                        'varLongitude3' => $emapData[24],
                        'varBusinessType' => $emapData[25],
                        'varPackaging' => $emapData[26],
                        'varDestination' => $emapData[31],
                        'chrImport' => $emapData[32],
                        'chrPublish' => 'Y',
                        'dtCreateDate' => date('Y-m-d H-i-s'),
                        'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                        'PUserGlCode' => ADMIN_ID
                    );
//                    print_R($data);exit;
                    $this->db->insert('buyleads', $data);
                    $id = $this->db->insert_id();


                    $aliasname = strtolower($emapData[2] . "-buylead");
                    $aliasname = stripslashes(quotes_to_entities($aliasname));
                    $aliasname = str_replace(' ', '-', $aliasname);
                    $aliasname = preg_replace('/[^A-Za-z0-9\-]/', '', $aliasname);
                    $aliasname = str_replace('---', '-', $aliasname);
                    $aliasname = str_replace('--', '-', $aliasname);
                    $aliasname = strip_tags($aliasname);
                    $aliasname = htmlentities($aliasname);
                    $alias = $this->GetAlias($aliasname);


                    $aliasdata = array(
                        'fk_ModuleGlCode' => MODULE_ID,
                        'fk_Record' => $id,
                        'varAlias' => $alias,
                    );
                    $this->db->insert('alias', $aliasdata);
                }
            }
            $issuelist = "";
            fclose($file);
            return $issuelist;
        }
    }

    function update() {

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_buyleads();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/buyleads/images/';
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


        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $reqDisplaydata = ($this->input->post('chrRequirement') == 'U') ? 'U' : 'D';
        $Import = ($this->input->post('chrImport') == 'Y') ? 'Y' : 'N';
        $luckyDrawDisplaydata = ($this->input->post('chrRequirement') == 'Y') ? 'Y' : 'N';
        if ($reqDisplaydata == 'D') {
            $days = $this->input->post('varDays');
        } else {
            $days = "";
        }
        $business_type = $this->input->post('varBusinessType');
        if ($business_type != '') {
            $business_type = implode(",", $business_type);
        } else {
            $business_type = "";
        }


        $getproduct = $this->getProduct($this->input->post('varName', TRUE));
        if (!empty($getproduct)) {
            $product_id = $getproduct['int_id'];
        } else {
            $product_id = "";
        }

        $ApproxOrderdata = ($this->input->post('chrApproxOrder') == 'on') ? 'Y' : 'N';

        if ($ApproxOrderdata == 'Y') {
            $start = $this->input->post('varStartPrice', TRUE);
            $end = $this->input->post('varEndPrice', TRUE);
            $approx_currency = $this->input->post('varApproxCurrency', TRUE);
        } else {
            $start = "";
            $end = "";
            $approx_currency = "";
        }

        $QuantityDisplaydata = ($this->input->post('chrQuantity') == 'on') ? 'Y' : 'N';
        if ($QuantityDisplaydata == 'Y') {
            $quantity = $this->input->post('varQuantity', TRUE);
            $unit = $this->input->post('intUnit', TRUE);
        } else {
            $quantity = "";
            $unit = "";
        }


        $data = array(
            'intUser' => $this->input->post('intUser', TRUE),
            'varName' => $this->input->post('varName', TRUE),
            'intProduct' => $product_id,
            'intParentCategory' => $this->input->post('intParentCategory', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'varReqType' => $this->input->post('varReqType', TRUE),
            'chrQuantity' => $QuantityDisplaydata,
            'varQuantity' => $quantity,
            'intUnit' => $unit,
            'varApproxCurrency' => $approx_currency,
            'chrApproxOrder' => $ApproxOrderdata,
            'varStartPrice' => $start,
            'varEndPrice' => $end,
            'chrRequirement' => $reqDisplaydata,
            'varDays' => $days,
            'chrImageFlag' => 'S',
            'varImage' => $Imagesurl,
            'varLocation' => $this->input->post('varLocation', TRUE),
            'varLocation2' => $this->input->post('varLocation2', TRUE),
            'varLocation3' => $this->input->post('varLocation3', TRUE),
            'varLatitude' => $this->input->post('varLatitude', TRUE),
            'varLongitude' => $this->input->post('varLongitude', TRUE),
            'varLatitude2' => $this->input->post('varLatitude2', TRUE),
            'varLongitude2' => $this->input->post('varLongitude2', TRUE),
            'varLatitude3' => $this->input->post('varLatitude3', TRUE),
            'varLongitude3' => $this->input->post('varLongitude3', TRUE),
            'varBusinessType' => $business_type,
            'varPackaging' => $this->input->post('varPackaging', TRUE),
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varExpectedPrice' => $this->input->post('varExpectedPrice', TRUE),
            'intEUnit' => $this->input->post('intEUnit', TRUE),
            'varDestination' => $this->input->post('varDestination', TRUE),
            'chrImport' => $Import,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
//        echo "<pre>";
//        print_R($data);
//        exit;
        $id = $this->db->insert_id();

        $opertion = 'U';
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update(DB_PREFIX . 'buyleads', $data);


        $countfiles = count($_FILES['files']['name']);
        if ($_FILES['files']['name'] != '')
            for ($i = 0; $i < $countfiles; $i++) {
                $filename = $_FILES['files']['name'][$i];

                $filename = preg_replace('/[\/:*?"&!@#$()+%^\'<>| ]/', '', $filename);
                $fileexntension = substr(strrchr($filename, '.'), 1);
                $var_title = str_replace('.' . $fileexntension, '', $filename);
                $filename = $var_title . "_" . time() . "." . $fileexntension;
                $filename = str_replace(' ', "_", $filename);
                $filename = str_replace('%', "_", $filename);
                $Filesurl = $filename;
                $tmp_name = $_FILES['files']['tmp_name'][$i];
                $uploads_dir = 'upimages/buyleads/file';
                if ($var_title != '' && $fileexntension != '') {
                    move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
                    $data = array(
                        'varTitle' => $var_title,
                        'varFile' => $Filesurl,
                        'chrFileFlag' => 'S',
                        'intBuyLeads' => $this->input->get_post('ehintglcode'),
                        'dtCreateDate' => date('Y-m-d H-i-s'),
                        'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                        'PUserGlCode' => ADMIN_ID
                    );
                    $this->db->insert(DB_PREFIX . 'buylead_docs', $data);
                }
            }


        $int_id = $this->input->get_post('ehintglcode');
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Update_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'buyleads', 'Name' => 'varName', 'ModuleintGlcode' => $int_id, 'Flag' => $opertion, 'Default' => 'int_id');
//        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'buyleads');
        $this->mylibrary->insertinlogmanager($ParaArray);
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
        $fkbuyleads = $this->input->get_post('fkbuyleads');
        if (empty($fkbuyleads)) {
            $fkbuyleads = 0;
        }
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'buyleads', "");
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'buyleads');
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'buyleads';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'buyleads', 'Name' => 'varName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
            $this->mylibrary->insertinlogmanager($ParaArray);
//            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'buyleads');
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

    function generate_seocontent_buyleads($fromajax = false) {
        $PageName = $this->input->post('varName', true);
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

        $this->db->where(array("fk_Record" => $id, "fk_ModuleGlCode" => "96"));
        $SQL = $this->db->get('alias');
        $RS = $SQL->Result();
        return $RS;
    }

    function getBuyLeadDoc($id) {

        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "buylead_docs WHERE chrDelete='N' AND chrPublish='Y' AND intBuyLeads='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function get_publish_value($id) {
        $returnArry = array();
        $sql = "SELECT chrPublish FROM " . DB_PREFIX . "buyleads WHERE chrDelete='N' AND int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result['chrPublish'];
    }

    function get_product_data() {
        $product = $this->input->get_post('intProduct');
        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "product WHERE chrDelete='N' AND int_id='" . $product . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

    public function SelectAll_front() {
        $flag = 'Y';
        $this->initialize($flag);
        $this->Generateurl($flag);
        $limitby = 'limit ' . $this->Start . ', ' . ABS($this->PageSize);
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "buyleads as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='124'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.int_id asc,N.int_id desc $limitby";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function SelectAll_detail_front_id($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "buyleads as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='124'  and N.chrPublish='Y' and N.chrDelete='N' and N.int_id!='" . $id . "' group by N.int_id order by N.int_id asc,N.int_id desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function getProductCatList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "product where chrDelete = 'N' and intParentCategory='0' order by int_id asc");
        $Result = $query->result();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input\" id=\"intParentCategory\" name=\"intParentCategory\" >";
        $returnHtml .= "<option value=''>--Select Product Category --</option>";
        foreach ($Result as $row) {
            $query1 = $this->db->query("select * from " . DB_PREFIX . "product_category where chrDelete = 'N' and intParentCategory='" . $row->int_id . "' order by int_id asc");
            $Result1 = $query1->result();

            if ($id == $row->int_id) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row->int_id . '" ' . $selected . '>' . $row->varName . '</option>';
            foreach ($Result1 as $row1) {
                $query2 = $this->db->query("select * from " . DB_PREFIX . "product_category where chrDelete = 'N' and intParentCategory='" . $row->int_id . "' order by int_id asc");
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

    function BusinessTypeList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "business_type where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select id=\"varBusinessType\" name=\"varBusinessType[]\" multiple=\"multiple\" data-placeholder=\"Select Preferred Supplier Type\" >";
//        $returnHtml .= "<option value=''>--Select Unit --</option>";
        foreach ($Result as $row) {

            $id_array = explode(",", $id);
            if (in_array($row['int_id'], $id_array)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

//            if ($id == $row['int_id']) {
//                $selected = 'selected="selected"';
//            } else {
//                $selected = '';
//            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function FrontBusinessTypeList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "business_type where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select id=\"varBusinessType\" name=\"varBusinessType[]\" multiple=\"multiple\">";
        $returnHtml .= "<option value=''  disabled >--Select Preffred Supplier Type --</option>";
        foreach ($Result as $row) {

            $id_array = explode(",", $id);
            if (in_array($row['int_id'], $id_array)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

//            if ($id == $row['int_id']) {
//                $selected = 'selected="selected"';
//            } else {
//                $selected = '';
//            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function allsuppliertype($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "business_type where chrDelete = 'N' order by varName asc");
        $data = $query->result_array();
        $datas = array();
        foreach ($data as $key => $row) {
            $datas[$row['varName']] = null;
        }
        return $datas;
    }

    public function SelectAll_Detail_front($id) {
        $where = " p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='147' and p.int_id='" . $id . "' ";
        $sql = "select p.*,c.varName as ProductCategory,A.varAlias,(select count(*) FROM " . DB_PREFIX . "buylead_docs WHERE p.int_id = bd.intBuyLeads) as filecount,u.varName as Username,u.varCompany as CompanyName,u.varEmail as UserEmail,u.varPhone as UserPhone,u.varSubdomain,u.varState,u.varTel as UserTel,u.varCity,u.varCountry,um.varName as PriceUnit,umq.varName as EUnit "
                . "from " . DB_PREFIX . "buyleads p "
                . "LEFT JOIN " . DB_PREFIX . "product_category as c ON c.int_id=p.intParentCategory "
                . "LEFT JOIN " . DB_PREFIX . "alias as A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users as u ON p.intUser=u.int_id "
                . "LEFT JOIN " . DB_PREFIX . "buylead_docs as bd ON bd.intBuyLeads=p.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON p.intUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON p.intEUnit=umq.int_id "
                . "WHERE " . $where . " group by p.int_id";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getProduct($name) {
        $name = stripslashes(quotes_to_entities($name));
        $sql = "select int_id,intParentCategory from " . DB_PREFIX . "product where chrDelete='N' and varName='" . $name . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
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
        $this->db->order_by('int_id', 'ASD');



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
        $display_output .= "<option value = \"\" " . (($selected_id == 0) ? $dipnopar : '') . ">Select Industry Type *</option>";
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

    function FrontBindpageshierarchy($name, $selected_id, $class = 'listbox') {

//        $NotShowString = array();

        $style = "style='display: none'";
        $dipnopar = "selected";

        $requesteid = $this->input->get_post('eid');
        $tempfk = "";
        $requesteid = !empty($requesteid) ? $requesteid : "";


//        $wherearray = array('chrDelete' => 'N', 'intParentCategory' => '0');
        $wherearray = array('chrDelete' => 'N');
        $this->db->select('int_id AS id, varName AS name, intParentCategory');
        $this->db->from('product_category');
        $this->db->where($wherearray);
        $this->db->order_by('int_id', 'ASC');
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
        $display_output = '<select onchange="return changeCategory(this.value);" name="' . $name . '" id="' . $name . '"  size="10">';
//        $display_output .= "<option value = ''>Select Category</option>";
//        if (USERTYPE == 'N') {
        $display_output .= "<option value = \"\" " . (($selected_id == 0) ? $dipnopar : '') . ">Select Industry Type *</option>";
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
//            if ($item['treename']) {
//            if (strpos($item['treename'], '3_') !== false) {
            $display_output .= "<option value=" . $item['id'] . " " . (($item['id'] == $selected_id) ? 'selected' : '') . " " . $disabled . " >" . $item['treename'] . "</option>";
//            }
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
//                    if($level + 1!=2){
                    $pre = '<sup>' . $level + 1 . '_</sup>&nbsp;';
                    $spacer = '.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//                    }
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

    function getCategoryNames($id = '') {
        $id = $this->input->get_post('intCategory');
        $fkstring = '';
        $html = "";
        $checkparent = $this->checkParent($id, $fkstring);

        $sql = "select varName from " . DB_PREFIX . "product_category where int_id IN($checkparent) group by int_id order by int_id asc";
        $rs = $this->db->query($sql);
        $countdata = $rs->num_rows();
        $resultdata1 = $rs->result_array($rs);
        foreach ($resultdata1 as $name) {
            $html .= $name['varName'] . " > ";
        }
        $html = substr($html, 0, -2);
        return $html;
    }

    function getCategoryNamesByProductName() {
        $name = $this->input->get_post('ProductName');
        $getProData = $this->getProduct($name);
        $id = $getProData['intParentCategory'];
        $fkstring = '';
        $html = "";
        $checkparent = $this->checkParent($id, $fkstring);

        $sql = "select varName from " . DB_PREFIX . "product_category where int_id IN($checkparent) group by int_id order by int_id asc";
        $rs = $this->db->query($sql);
        $countdata = $rs->num_rows();
        $resultdata1 = $rs->result_array($rs);
        foreach ($resultdata1 as $name) {
            $html .= $name['varName'] . " > ";
        }
        $html = substr($html, 0, -2);
        $htmls = array(
            'cat_list' => $html,
            'cat_id' => $id
        );
//        print_r($htmls);exit;
        return $htmls;
    }

    function getParentCategoryData() {

//        $NotShowString = array();

        $style = "style='display: none'";
        $dipnopar = "selected";

        $requesteid = $this->input->get_post('eid');
        $tempfk = "";
        $requesteid = !empty($requesteid) ? $requesteid : "";


        $wherearray = array('chrDelete' => 'N', 'chrPublish' => 'Y', 'intParentCategory' => '0');
        $this->db->select('int_id,varName,intParentCategory');
        $this->db->from('product_category');
        $this->db->where($wherearray);
        $this->db->order_by('varName', 'asc');
        $res_pages = $this->db->get();
        $data = $res_pages->result_array();

        $display_output = '<select onchange="return getSubCategory(this.value,0);">';
//        $display_output .= "<option value = ''>Select Category</option>";
        $display_output .= "<option selected disabled='disabled' value=''>Select Industry Type *</option>";
        foreach ($data as $row) {
            $display_output .= "<option value='" . $row['int_id'] . "'>" . $row['varName'] . "</option>";
        }
        $display_output .= '</select>';
        return $display_output;
    }

    function getSubCategoryData() {
        $id = $this->input->get_post('intCategory');
        $count = $this->input->get_post('count');
        $html = "";

        $sql = "select varName,int_id from " . DB_PREFIX . "product_category where chrDelete='N' and chrPublish='Y' group by int_id order by varName asc";
        $rs = $this->db->query($sql);
        $resultdata1 = $rs->result_array($rs);
        if (count($resultdata1) > 0) {
//            $html .= '<select  onchange="return getSubCategory(this.value,' . $count . ');">';
//            $html .= '<option>Select Category</option>';
            foreach ($resultdata1 as $name) {
                $html .= '<option  value="' . $name['int_id'] . '">' . $name['varName'] . '</option>';
            }
//            $html .= '</select>';
        }
        return $html;
    }

    function checkParent($id, $fkstring) {

        $sql = "select int_id,intParentCategory from " . DB_PREFIX . "product_category where int_id='" . $id . "'";
//       echo $sql;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $this->db->cache_off();
        $result = $query->row_array();
        if ($count > 0) {
            if ($result['intParentCategory'] != '0') {
                $fkstring .= $result['int_id'] . ',';
                return $this->checkParent($result['intParentCategory'], $fkstring);
            } else {
                $fkstring .= $result['int_id'];
                return $fkstring;
            }
        } else {
            return $fkstring;
        }
    }

    function CustomerList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "users where chrDelete = 'N' and chrPublish='Y' and chrType='BS' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input label-fixed\"  data-md-selectize data-md-selectize-bottom id=\"intUser\" name=\"intUser\" >";
        $returnHtml .= "<option value=''>--Select Customer --</option>";
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getRequirementTypeList($id = '') {
        $Result = array('Regular', 'One Time', 'Monthly');
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"varReqType\" name=\"varReqType\" >";
        $returnHtml .= "<option value=''>--Select Requirement Type --</option>";
        foreach ($Result as $row) {
            if ($id == $row) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row . '" ' . $selected . '>' . $row . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getRequirementTypeFrontList($id = '') {
        $Result = array('Regular', 'One Time', 'Monthly');
        $returnHtml = '';
        $returnHtml .= "<select id=\"varReqType\"  onchange='return removereqtypeclass()' name=\"varReqType\" >";
        $returnHtml .= "<option value='' disabled selected>Requirement Type *</option>";
        foreach ($Result as $row) {
            if ($id == $row) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row . '" ' . $selected . '>' . $row . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getUnitList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"intUnit\" name=\"intUnit\" >";
        $returnHtml .= "<option value=''>--Select Unit --</option>";
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getFrontPaymentTypeList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "payment_types where chrDelete = 'N' order by int_id asc");
        $Result = $query->result_array();
        $returnHtml = '';
        foreach ($Result as $row) {
            $id_array = explode(",", $id);
            if (in_array($row['int_id'], $id_array)) {
                $selected = 'checked';
            } else {
                $selected = '';
            }

            $photo_thumb = $row['varImage'];
            $thumb = 'upimages/payment_types/images/' . $photo_thumb;
            if (file_exists($thumb) && $photo_thumb != '') {
                $thumbphoto1 = image_thumb($thumb, 60, 30);
            } else {
                $thumbphoto1 = "";
            }
            $returnHtml .= '<div class="check-all col m3 s6">
               <div class="check-border">
                <label>
                                           <input ' . $selected . ' value="' . $row['int_id'] . '" type="checkbox" name="intPaymentType[]" id="intPaymentType' . $row['int_id'] . '" class="filled-in" />
                                           <span for="intPaymentType' . $row['int_id'] . '">' . $row['varName'] . '<img src="' . $thumbphoto1 . '"></span>
                </label>
                        </div>
                </div>';
        }
        return $returnHtml;
    }

    function getUserName($id = '') {
        $query = $this->db->query("select varCompany from " . DB_PREFIX . "users where int_id = '" . $id . "'");
        $Result = $query->row_array();
        return $Result['varCompany'];
    }

    function getFrontPaymentTermsList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "payment_terms where chrDelete = 'N' order by int_id asc");
        $Result = $query->result_array();
        $returnHtml = '';
        foreach ($Result as $row) {
            $id_array = explode(",", $id);
            if (in_array($row['int_id'], $id_array)) {
                $selected = 'checked';
            } else {
                $selected = '';
            }
            $returnHtml .= '<div class="check-all col m3 s6">
                <div class="check-border">
                <label>
                                           <input ' . $selected . ' value="' . $row['int_id'] . '" type="checkbox" name="intPaymentTerms[]" id="intPaymentTerms' . $row['int_id'] . '" class="filled-in" />
                                           <span for="intPaymentTerms' . $row['int_id'] . '">' . $row['varName'] . '</span>
                </label>
                        </div>
                </div>';
        }
        return $returnHtml;
    }

    function getFrontUnitList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select onchange='return removeunitclass(this.value)' id=\"intUnit\" name=\"intUnit\" >";
        $returnHtml .= "<option value='' disabled selected>Measurement Unit</option>";
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getEUnitList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"intEUnit\" name=\"intEUnit\" >";
        $returnHtml .= "<option value=''>--Select Unit Type --</option>";
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getFrontEUnitList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select id=\"intEUnit\" name=\"intEUnit\" >";
        $returnHtml .= "<option value=''>Select Unit Type</option>";
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function get_all_products() {
        $sql = "select varName,int_id,varImage from " . DB_PREFIX . "product where chrPublish='Y' and chrDelete='N' ORDER BY varName ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datass = array();
        foreach ($data as $row) {
            $imagename = $row['varImage'];
            $imagepath = 'upimages/product/listing_image/' . $imagename;
            $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);

            $datas['CustomerID'] = $row['int_id'];
            $datas['ContactName'] = $row['varName'];
            $datas['CompanyImage'] = $image_detail_thumb;
            $datass[] = $datas;
        }
        return $datass;
    }

    public function getProductCategories($id = 0) {
        $sql = "select pc.*,A.varAlias from " . DB_PREFIX . "product_category pc LEFT JOIN " . DB_PREFIX . "alias A ON pc.int_id=A.fk_Record WHERE pc.intParentCategory='" . $id . "' and pc.chrPublish='Y' and A.fk_ModuleGlCode='113' and pc.chrDelete='N' group by pc.int_id order by pc.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getRFQListingData() {
        $page = $this->input->get_post('page');
        if ($page == '') {
            $page = 1;
        }
        if (isset($page)) {
            $pageno = $page - 1;
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = DEFAULT_PAGESIZE;
        $offset = ($pageno) * $no_of_records_per_page;

        $limitby = 'limit ' . $offset . ', ' . $no_of_records_per_page;


        $where = " p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='147' ";
        $keyword = $this->input->get_post('keyword');
        if ($keyword != '') {
            $where .= " and p.varName like '%" . $keyword . "%'";
        }
        $business = $this->input->get_post('business');
        if ($business != '') {
            if ($business == '1') {
                $where .= " and p.varReqType='One Time'";
            } else if ($business == '2') {
                $where .= " and p.varReqType='Regular'";
            } else if ($business == '3') {
                $where .= " and p.varReqType='Monthly'";
            }
        }
        $category = $this->input->get_post('cat');
        if ($category != '') {
            $where .= " and p.intParentCategory='" . $category . "'";
        }
        $photo = $this->input->get_post('photo');
        if ($photo != '') {
            $where .= " and p.varImage!=''";
        }
        $requirement = $this->input->get_post('requirement');
        if ($requirement != '') {
            $where .= " and p.chrRequirement='U' ";
        }
        $time = $this->input->get_post('time');
        if ($time != '') {
            if ($time == '8h') {
                $where .= " and p.dtCreateDate >= DATE_SUB(NOW(),INTERVAL 8 HOUR) ";
            } else if ($time == '24h') {
                $where .= " and p.dtCreateDate >= NOW() - INTERVAL 1 DAY ";
            } else if ($time == '2d') {
                $where .= " and p.dtCreateDate >= NOW() - INTERVAL 2 DAY ";
            } else if ($time == '1w') {
                $where .= " and p.dtCreateDate >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND p.dtCreateDate < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY";
            } else if ($time == '1m') {
                $where .= " and p.dtCreateDate >= NOW() - INTERVAL 30 DAY";
            }
        }
        $attachment = $this->input->get_post('attachment');
        $sql = "";
        $sql = "select p.*,A.varAlias,(select count(*) FROM " . DB_PREFIX . "buylead_docs WHERE p.int_id = bd.intBuyLeads) as filecount,u.varName as CompanyName,u.varCity,u.varCountry,um.varName as PriceUnit,umq.varName as EUnit "
                . "from " . DB_PREFIX . "buyleads p "
                . "LEFT JOIN " . DB_PREFIX . "alias as A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users as u ON p.intUser=u.int_id "
                . "LEFT JOIN " . DB_PREFIX . "buylead_docs as bd ON bd.intBuyLeads=p.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON p.intUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON p.intEUnit=umq.int_id "
                . "WHERE " . $where . " group by p.int_id "
                . "order by CASE WHEN p.varName LIKE '$keyword%' THEN 1 WHEN p.varName LIKE '%$keyword' THEN 3 ELSE 2 END,p.dtCreateDate desc $limitby";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        $datasa = array();
        foreach ($data as $datas) {
            if ($attachment != '') {
                if ($datas['filecount'] > 0) {
                    $datasa[] = $datas;
                }
            } else {
                $datasa[] = $datas;
            }
        }
        return $datasa;
    }

    public function getCatRFQListing() {

        $where = " p.chrDelete='N' and p.chrPublish='Y'";
        $keyword = $this->input->get_post('keyword');
        if ($keyword != '') {
            $where .= " and p.varName like '" . $keyword . "'";
        }
        $sql = "";
        $sql = "select p.intParentCategory,u.varName "
                . "from " . DB_PREFIX . "buyleads p "
                . "LEFT JOIN " . DB_PREFIX . "product_category as u ON p.intParentCategory=u.int_id "
                . "WHERE " . $where . " group by p.intParentCategory "
                . "order by CASE WHEN p.varName LIKE '$keyword%' THEN 1 WHEN p.varName LIKE '%$keyword' THEN 3 ELSE 2 END,p.dtCreateDate desc limit 15";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        $htmls = "";
        $fkstring = '';
        foreach ($data as $row) {
            $datas = $this->getCategoryListNames($row['intParentCategory']);
            $action = $this->common_model->getUrl("pages", "2", "28", '') . "?cat=" . $datas[2]['int_id'];
            if ($datas[2]['name'] != '') {
                $htmls .= '<div class="post-req"><a href="javascript:;" style="padding: 5px 4px 5px 9px;font-size: 12px;border: 1px solid;"><i class="fas fa-caret-right"></i>  ' . $datas[0]['name'] . '</a>';

                $htmls .= '<a href="' . $action . '" style="padding: 5px 4px 5px 5px;font-size: 12px;border: 1px solid;">' . $datas[2]['name'] . '</a>';

                $htmls .= '</div><br>';
            }
        }
        return $htmls;
    }

    function getCategoryListNames($id = '') {
        $fkstring = '';
        $checkparent = $this->checkParents($id, $fkstring);
        $sql = "select varName,int_id from " . DB_PREFIX . "product_category where int_id IN($checkparent) group by int_id order by int_id asc";
        $rs = $this->db->query($sql);
        $countdata = $rs->num_rows();
        $resultdata1 = $rs->result_array($rs);
        foreach ($resultdata1 as $name) {
            $html[] = array(
                'name' => $name['varName'],
                'int_id' => $name['int_id']
            );
        }
        return $html;
    }

    function checkParents($id, $fkstring) {

        $sql = "select int_id,intParentCategory from " . DB_PREFIX . "product_category where int_id='" . $id . "'";
//       echo $sql;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $this->db->cache_off();
        $result = $query->row_array();
        if ($count > 0) {
            if ($result['intParentCategory'] != '0') {
                $fkstring .= $result['int_id'] . ', ';
                return $this->checkParents($result['intParentCategory'], $fkstring);
            } else {
                $fkstring .= $result['int_id'];
                return $fkstring;
            }
        } else {
            return $fkstring;
        }
    }

    function getcategoryfkarray($catid, $fkstring = '') {
        $sql = "select int_id,intParentCategory from " . DB_PREFIX . "product_category where int_id='" . $catid . "'";
//       echo $sql;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $this->db->cache_off();
        $result = $query->row_array();
        if ($count > 0) {
            if ($result['intParentCategory'] != '0') {
                $fkstring .= $result['int_id'] . ', ';
                return $this->getcategoryfkarray($result['intParentCategory'], $fkstring);
            } else {
                $fkstring .= $result['int_id'];
                return $fkstring;
            }
        } else {
            return $fkstring;
        }
    }

    function CountRow_front() {
        $where = " p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='147' ";
        $keyword = $this->input->get_post('keyword');
        if ($keyword != '') {
            $where .= " and p.varName like '%" . $keyword . "%'";
        }
        $business = $this->input->get_post('business');
        if ($business != '') {
            if ($business == '1') {
                $where .= " and p.varReqType='One Time'";
            } else if ($business == '2') {
                $where .= " and p.varReqType='Regular'";
            } else if ($business == '3') {
                $where .= " and p.varReqType='Monthly'";
            }
        }
        $category = $this->input->get_post('cat');
        if ($category != '') {
            $where .= " and p.intParentCategory='" . $category . "'";
        }
        $photo = $this->input->get_post('photo');
        if ($photo != '') {
            $where .= " and p.varImage!=''";
        }
        $requirement = $this->input->get_post('requirement');
        if ($requirement != '') {
            $where .= " and p.chrRequirement='U' ";
        }
        $time = $this->input->get_post('time');
        if ($time != '') {
            if ($time == '8h') {
                $where .= " and p.dtCreateDate >= DATE_SUB(NOW(),INTERVAL 8 HOUR) ";
            } else if ($time == '24h') {
                $where .= " and p.dtCreateDate >= NOW() - INTERVAL 1 DAY ";
            } else if ($time == '2d') {
                $where .= " and p.dtCreateDate >= NOW() - INTERVAL 2 DAY ";
            } else if ($time == '1w') {
                $where .= " and p.dtCreateDate >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND p.dtCreateDate < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY";
            } else if ($time == '1m') {
                $where .= " and p.dtCreateDate >= NOW() - INTERVAL 30 DAY";
            }
        }
        $attachment = $this->input->get_post('attachment');
        $sql = "";
        $sql = "select p.*,A.varAlias,(select count(*) FROM " . DB_PREFIX . "buylead_docs WHERE p.int_id = bd.intBuyLeads) as filecount,u.varName as CompanyName,u.varCity,u.varCountry,um.varName as PriceUnit,umq.varName as EUnit "
                . "from " . DB_PREFIX . "buyleads p "
                . "LEFT JOIN " . DB_PREFIX . "alias as A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users as u ON p.intUser=u.int_id "
                . "LEFT JOIN " . DB_PREFIX . "buylead_docs as bd ON bd.intBuyLeads=p.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON p.intUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON p.intEUnit=umq.int_id "
                . "WHERE " . $where . " group by p.int_id "
                . "order by CASE WHEN p.varName LIKE '$keyword%' THEN 1 WHEN p.varName LIKE '%$keyword' THEN 3 ELSE 2 END, u.chrPayment desc,u.intPayment desc,p.varName asc";
//        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "buyleads as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='96' WHERE N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.int_id asc ";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
//        echo $rowcount;
        return $rowcount;
    }

    function getSideSupplier($id) {
        if ($id == '0') {
            $where = " p.chrDelete='N' and p.chrPublish='Y' and p.int_id!='" . RECORD_ID . "' and A.fk_ModuleGlCode='147' ";
            $order = " RAND()";
        } else {
            $where = " p.chrDelete='N' and p.chrPublish='Y' and p.intProduct='" . $id . "' and p.int_id!='" . RECORD_ID . "' and A.fk_ModuleGlCode='147' ";
            $order = " p.int_id asc";
        }




        $sql = "";
        $sql = "select p.*,A.varAlias,u.varName as CompanyName,u.varCity,u.varCountry,um.varName as PriceUnit,umq.varName as EUnit "
                . "from " . DB_PREFIX . "buyleads p "
                . "LEFT JOIN " . DB_PREFIX . "alias as A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users as u ON p.intUser=u.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON p.intUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON p.intEUnit=umq.int_id "
                . "WHERE " . $where . " group by p.int_id order by $order limit 2";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function getBuyLeadData() {
        $id = $this->input->get_post('buylead');
        $where = " b.chrDelete='N' and b.chrPublish='Y' and b.int_id='" . $id . "'";

        $sql = "";
        $sql = "select b.*,p.varHSCode "
                . "from " . DB_PREFIX . "buyleads b "
                . "LEFT JOIN " . DB_PREFIX . "product as p ON b.intProduct=p.int_id "
                . "WHERE " . $where . "";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    function getFrontUnitList2($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select onchange='return remove_moq_unitclass(this.value);' id=\"intMOQUnit\" name=\"intMOQUnit\" >";
        $returnHtml .= "<option value='' disabled selected>Select Unit</option>";
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected = "selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value = "' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function downloadfiles($id = '') {
//        $id = $this->input->get_post('id', true);
        $sql = "select varTitle,varFile from " . DB_PREFIX . "buylead_docs WHERE chrPublish='Y' and chrDelete='N' and intBuyLeads='" . $id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function checkBuyLead($id = '') {
        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];

        $sql = "select * from " . DB_PREFIX . "quotenow_access WHERE intUser='" . $user_id . "' and chrPublish='Y' and chrDelete='N' and intBuylead='" . $id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->num_rows();
        return $result_query;
    }

    function getQuoatationData($id = '') {
//        $id = $this->input->get_post('id', true);
        $sql = "select u.varCompany,u.varCity,u.varCountry,q.dtCreateDate,u.varEmail,q.intResponse from " . DB_PREFIX . "quotenow as q left join " . DB_PREFIX . "users as u on q.intUser=u.int_id WHERE q.chrDelete='N' and q.intBuyLead='" . $id . "'";
//       echo $sql;exit;
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function generate_image($filefield, $path = '', $i) {
//        echo "SAd";exit;
        $max_file_size = MAX_FILE_SIZE;
        $sess = time();
        $des_file_photo = basename($_FILES[$filefield]['name'][$i]);
        $des_file_photo = str_replace(' & nbsp;
            ', '-', $des_file_photo);
        $des_file_photo = str_replace(' ', '-', $des_file_photo);
        $des_file_photo = str_replace('#', '-', $des_file_photo);
        $des_file_photo = str_replace('%', '-', $des_file_photo);
        $pieces = explode(".", $des_file_photo);
        $lastitem = end($pieces);
        unset($pieces[count($pieces) - 1]);
        $pieces = implode(".", $pieces);
        $des_file_photo = $pieces . $sess . '.' . $lastitem;
        if ($path == '') {
            $uploaddir = $this->configObj->currentModulePath . 'html/uploads/images/';
        } else {
            $uploaddir = $path;
        }
        $source_file = basename($_FILES[$filefield]['name'][$i]);
        $file = $uploaddir . $des_file_photo;
        $uploadedfile = $_FILES[$filefield]['tmp_name'][$i];
        $image_info = getimagesize($uploadedfile);
        $imageextension = $image_info['mime'];
        $file_size_MB = number_format($_FILES[$filefield]['size'][$i] / pow(1024, 2)); // file size in MB

        $img_upload = move_uploaded_file($_FILES[$filefield]['tmp_name'][$i], $file);
        return $des_file_photo;
    }

    function approve_buylead() {
        $approve = $this->input->get_post('chrPublish');
        $Eid = $this->input->get_post('Eid');

        $data = array('chrPublish' => $approve, 'dtModifyDate' => date('Y-m-d H-i-s'));
        $this->db->where('int_id', $Eid);
        $this->db->update('buyleads', $data);
    }

    function insert_quotenow() {

        if ($_FILES['varBrochure']['name'] != '') {
            $filename = $_FILES['varBrochure']['name'];
            $filename = preg_replace('/[\/:*?"&!@#$()+%^\'<>| ]/', '', $filename);
            $fileexntension = substr(strrchr($filename, '.'), 1);
            $var_title = str_replace('.' . $fileexntension, '', $filename);
            $filename = $var_title . "_" . time() . "." . $fileexntension;
            $filename = str_replace(' ', "_", $filename);
            $filename = str_replace('%', "_", $filename);
            $Filesurl = $filename;
            $tmp_name = $_FILES["varBrochure"]["tmp_name"];
            $uploads_dir = 'upimages/quotenow/brochure';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
        } else {
            $Filesurl = "";
        }


//        $TradeSecuritydata = ($this->input->post('chrTradeSecurity') == 'Y') ? 'Y' : 'N';
        $sampledata = ($this->input->post('chrSample') == 'on') ? 'Y' : 'N';
        $shippingdata = ($this->input->post('varShipping') == 'on') ? 'Y' : 'N';

        $counter = $this->input->get_post('file_hd', true);

        for ($i = 1; $i <= $counter; $i++) {
            if ($this->input->get_post('varSTitle' . $i, true) != '') {
                $varSTitle[] = strip_tags($this->input->get_post('varSTitle' . $i, true));
                $varSvalue[] = strip_tags($this->input->get_post('varSvalue' . $i, true));
            }
        }
        $varSTi = implode("__", $varSTitle);
        $varSva = implode("__", $varSvalue);

        if ($varSTitle == '') {
            $varSTi = "";
        }
        if ($varSvalue == '') {
            $varSva = "";
        }

        if ($this->input->post('intPaymentTerms') != '') {
            $PaymentTerms = implode(",", $this->input->post('intPaymentTerms'));
        } else {
            $PaymentTerms = $this->input->post('intPaymentTerms');
        }
        if ($this->input->post('intPaymentType') != '') {
            $PaymentType = implode(",", $this->input->post('intPaymentType'));
        } else {
            $PaymentType = $this->input->post('intPaymentType');
        }

//        $keyword = rtrim($this->input->post('varKeyword', TRUE), ",");
        $material = rtrim($this->input->post('varMaterial', TRUE), ",");

        $data = array(
            'intBuyLead' => $this->input->post('buylead', TRUE),
            'varName' => $this->input->post('varName', TRUE),
            'intUser' => $this->input->post('intUser', TRUE),
//            'varKeyword' => $keyword,
            'varHSCode' => $this->input->post('varHSCode', TRUE),
            'txtDescription' => $this->input->post('txtDescription'),
//            'chrTradeSecurity' => $TradeSecuritydata,
            'varSTitle' => $varSTi,
            'varSvalue' => $varSva,
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varPrice' => $this->input->post('varPrice', TRUE),
            'varMOQ' => $this->input->post('varMOQ', TRUE),
            'intMOQUnit' => $this->input->post('intMOQUnit', TRUE),
            'chrSample' => $sampledata,
            'varMaterial' => $material,
            'intUnit' => $this->input->post('intUnit', TRUE),
            'intDays' => $this->input->post('intDays', TRUE),
            'intTax' => $this->input->post('intTax', TRUE),
            'varArrangeBy' => $this->input->post('varArrangeBy', TRUE),
            'varPaidBy' => $this->input->post('varPaidBy', TRUE),
            'varShipping' => $shippingdata,
            'varSupplierDeliveryTime' => $this->input->post('varSupplierDeliveryTime', TRUE),
            'txtNote' => $this->input->post('txtNote', TRUE),
            'varTransportation' => $this->input->post('varTransportation', TRUE),
            'chrTransportation' => $this->input->post('chrTransportation', TRUE),
            'intPaymentType' => $PaymentType,
            'intPaymentTerms' => $PaymentTerms,
            'varBrochure' => $Filesurl,
            'chrDelete' => 'N',
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
        );
//        echo "<pre>";
//        print_R($data);exit;



        $query = $this->db->insert(DB_PREFIX . 'quotenow', $data);
        $id = $this->db->insert_id();


        $count = count($_FILES['varImages']['name']);
        if ($this->input->post('tmpimage', TRUE) != '') {
            $imgnames = rtrim($this->input->post('tmpimage', TRUE), ",");
            $arrays = explode(",", $imgnames);
        } else {
            $imgnames = $this->input->post('tmpimage', TRUE);
            $arrays = array();
        }


        if ($count > 0) {
            for ($i = 0; $i <= $count; $i++) {

                if (in_array($i, $arrays) && $imgnames != '') {
                    
                } else {

                    $sess = time();
                    $pdf = basename($_FILES['varImages']['name'][$i]);
                    if ($pdf != '') {
                        $photofile = preg_replace('/[^a-zA-Z0-9_ \[\]\.\(\)&-]/s', '', $pdf);
                        $_FILES['varImages']['name'][$i] = $photofile;
                        $image_title = basename($_FILES['varImages']['name'][$i]);
                        $fileexntension = substr(strrchr($image_title, '.'), 1);
                        $varName = str_replace('.' . $fileexntension, '', $image_title);
                        $maindir = 'upimages/quotenowgallery/images/';
                        $var_main_file = $this->generate_image('varImages', $maindir, $i);
                        $file_photo = basename($var_main_file);
                        $uploadedfile = $maindir . $file_photo;
                        $this->thumb_width = PRODUCTGALLERY_WIDTH;
                        $this->thumb_height = PRODUCTGALLERY_HEIGHT;
                        image_thumb($maindir . $var_main_file, $this->thumb_width, $this->thumb_height);
                        image_thumb($maindir . $var_main_file, HOME_PRODUCTGALLERY_WIDTH, HOME_PRODUCTGALLERY_HEIGHT);
                        image_thumb($maindir . $var_main_file, PRODUCTGALLERY_DETAIL_WIDTH, PRODUCTGALLERY_DETAIL_HEIGHT);
                        $this->imagename = $var_main_file;
                        $imgname = explode('.', $this->imagename);
                        $image_name = $imgname['0'];
                        $c_date = date('Y-m-d H-i-s');

                        $data = array(
                            'varName' => $varName,
                            'fkQuote' => $id,
                            'varImage' => $this->imagename,
                            'intDisplayOrder' => '1',
                            'dtCreateDate' => $c_date,
                            'dtModifyDate' => $c_date,
                        );
                        $this->db->insert(DB_PREFIX . 'quotenowgallery', $data);
                    }
                }
            }
        }
        return $id;
    }

    function getBusinessTypeName($id = '') {
        $ids = explode(",", $id);
        $returnHtml = "";
        foreach ($ids as $row) {
            $query = $this->db->query("select varName from " . DB_PREFIX . "business_type where int_id='" . $row . "' and chrDelete = 'N' order by varName asc");
            $Result = $query->row_array();
            $returnHtml .= $Result['varName'] . ", ";
        }
        $returnHtml = rtrim($returnHtml, ", ");
        return $returnHtml;
    }

}

?>