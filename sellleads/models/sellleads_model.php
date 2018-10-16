<?php

class sellleads_model extends CI_Model {

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
    var $numofsellleads; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'b.int_id'; // Attribute of Deafult Order By
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
            'tablename' => DB_PREFIX . 'sellleads',
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

    function Select_All_sellleads_Record() {
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
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "sellleads b where  $whereclauseids group by b.varName $OrderBy");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        $this->db->select("b.int_id AS id, b.varName AS name,b.*,pc.varName as category_name,u.varName as customer_name,u.varCompany", false);
        $this->db->select('a.varAlias,a.int_id AS alias_id,a.intPageHits,a.intMobileHits', false);
        $this->db->from('sellleads AS b', false);
        $this->db->join('alias AS a', 'a.fk_Record = b.int_id', 'left', false);
        $this->db->join('product_category AS pc', 'pc.int_id = b.intParentCategory', 'left', false);
        $this->db->join('users AS u', 'u.int_id = b.intUser', 'left', false);
        $this->db->where($whereclauseids);
        $this->db->order_by("$this->OrderBy", $this->OrderType);
        $this->db->group_by('b.int_id');

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
        $rs = $this->db->count_all_results('sellleads');
        return $rs;
    }

    function Select_sellleads_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('T.chrDelete' => 'N', 'T.int_id' => $id);
        $this->db->select('T.*,a.varAlias,a.int_id as Alias_Id');
        $this->db->from('sellleads As T');
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

        $meta_data = $this->generate_seocontent_sellleads();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/sellleads/images/';
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


        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $reqDisplaydata = ($this->input->post('chrRequirement') == 'U') ? 'U' : 'D';
        if ($reqDisplaydata == 'D') {
            $days = $this->input->post('varDays');
        } else {
            $days = "";
        }



        $getproduct = $this->getProduct($this->input->post('varName', TRUE));
        if ($getproduct != '') {
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


        if ($this->input->post('intPaymentTerms') != '') {
            $PaymentTerms = implode(",", $this->input->post('intPaymentTerms'));
        } else {
            $PaymentTerms = $this->input->post('intPaymentTerms');
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
            'intPaymentTerms' => $PaymentTerms,
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varExpectedPrice' => $this->input->post('varExpectedPrice', TRUE),
            'intEUnit' => $this->input->post('intEUnit', TRUE),
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
        $query = $this->db->insert(DB_PREFIX . 'sellleads', $data);
        $id = $this->db->insert_id();

        $alias = $this->input->post('varAlias', TRUE);
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $alias);
        $this->common_model->Insert_Alias($Alias_Array);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'sellleads', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function update() {

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_sellleads();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/sellleads/images/';
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
        if ($reqDisplaydata == 'D') {
            $days = $this->input->post('varDays');
        } else {
            $days = "";
        }


        $getproduct = $this->getProduct($this->input->post('varName', TRUE));
//        print_R($getproduct);exit;
        if (!empty($getproduct)) {
            $product_id = $getproduct['int_id'];
        } else {
            $product_id = "";
        }
//        echo $product_id;exit;

        $ApproxOrderdata = ($this->input->post('chrApproxOrder') == 'on') ? 'Y' : 'N';
//        echo $ApproxOrderdata;exit;
        if ($ApproxOrderdata == 'Y') {
            $start = $this->input->post('varStartPrice', TRUE);
            $end = $this->input->post('varEndPrice', TRUE);
            $approx_currency = $this->input->post('varApproxCurrency', TRUE);
        } else {
            $start = "";
            $end = "";
            $approx_currency = "";
        }

//        echo $this->input->post('chrQuantity');exit;
        $QuantityDisplaydata = ($this->input->post('chrQuantity') == 'on') ? 'Y' : 'N';
        if ($QuantityDisplaydata == 'Y') {
            $quantity = $this->input->post('varQuantity', TRUE);
            $unit = $this->input->post('intUnit', TRUE);
        } else {
            $quantity = "";
            $unit = "";
        }
        if ($this->input->post('intPaymentTerms') != '') {
            $PaymentTerms = implode(",", $this->input->post('intPaymentTerms'));
        } else {
            $PaymentTerms = $this->input->post('intPaymentTerms');
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
            'intPaymentTerms' => $PaymentTerms,
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varExpectedPrice' => $this->input->post('varExpectedPrice', TRUE),
            'intEUnit' => $this->input->post('intEUnit', TRUE),
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
        $this->db->update(DB_PREFIX . 'sellleads', $data);

        $int_id = $this->input->get_post('ehintglcode');
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Update_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'sellleads', 'Name' => 'varName', 'ModuleintGlcode' => $int_id, 'Flag' => $opertion, 'Default' => 'int_id');
//        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'sellleads');
        $this->mylibrary->insertinlogmanager($ParaArray);
    }

    function insert_sellleads() {
//echo  "gu";exit;
        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/sellleads/images/';
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
//        echo $Imagesurl;exit;

        $reqDisplaydata = ($this->input->post('chrRequirement') == 'U') ? 'U' : 'D';
        if ($reqDisplaydata == 'D') {
            $days = $this->input->post('varDays');
        } else {
            $days = "";
        }


        $getproduct = $this->getProduct($this->input->post('varProduct', TRUE));
        if ($getproduct['int_id'] != '') {
            $product_id = $getproduct['int_id'];
        } else {
            $product_id = "";
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


        if ($this->input->post('intPaymentTerms') != '') {
            $PaymentTerms = implode(",", $this->input->post('intPaymentTerms'));
        } else {
            $PaymentTerms = '';
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
            'intPaymentTerms' => $PaymentTerms,
            'chrPublish' => 'N',
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
        
//        echo "<pre>";
//        print_R($data);exit;

        $query = $this->db->insert(DB_PREFIX . 'sellleads', $data);
        $id = $this->db->insert_id();


        $countfiles = count($_FILES['files']['name']);
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
            $uploads_dir = 'upimages/sellleads/file';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
            $data = array(
                'varTitle' => $var_title,
                'varFile' => $Filesurl,
                'chrFileFlag' => 'S',
                'intSellLeads' => $id,
                'dtCreateDate' => date('Y-m-d H-i-s'),
                'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                'PUserGlCode' => ADMIN_ID
            );
            $this->db->insert(DB_PREFIX . 'sellleads_docs', $data);
        }

        return $id;
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
        $fksellleads = $this->input->get_post('fksellleads');
        if (empty($fksellleads)) {
            $fksellleads = 0;
        }
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'sellleads', "");
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'sellleads');
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'sellleads';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d h-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'sellleads', 'Name' => 'varName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
            $this->mylibrary->insertinlogmanager($ParaArray);
            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'sellleads');
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

    function generate_seocontent_sellleads($fromajax = false) {
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

    function Select_Share_Page_Rows($id) {

        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "sellleads WHERE chrDelete='N' AND chrPublish='Y' AND int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result;
    }

    function get_publish_value($id) {
        $returnArry = array();
        $sql = "SELECT chrPublish FROM " . DB_PREFIX . "sellleads WHERE chrDelete='N' AND int_id='" . $id . "'";
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

    function CategoryFilter() {
//        echo "select pc.int_id AS id, pc.varName AS name from " . DB_PREFIX . "product as p left join " . DB_PREFIX . "productcategory as pc on pc.int_id = p.intSharePointCategory  where  p.chrDelete = 'N' group by pc.varName order by pc.intDisplayOrder asc";
        $query = $this->db->query("select pc.int_id AS id, pc.varName AS name from " . DB_PREFIX . "sellleads as p left join " . DB_PREFIX . "SharePointCategory as pc on pc.int_id = p.intSharePointCategory  where  p.chrDelete = 'N' group by pc.varName order by pc.int_id asc");
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
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "sellleads as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='124'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.int_id asc,N.int_id desc $limitby";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function SelectAll_detail_front_id($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "sellleads as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='124'  and N.chrPublish='Y' and N.chrDelete='N' and N.int_id!='" . $id . "' group by N.int_id order by N.int_id asc,N.int_id desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function CountRow_front() {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "sellleads as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='96' WHERE N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.int_id asc ";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
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

    function getIndustryList($id = '') {
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

    public function SelectAll_Detail_front($id) {
        $sql = " select * from " . DB_PREFIX . "sellleads where chrDelete='N' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getProduct($name) {
        $sql = " select int_id from " . DB_PREFIX . "product where chrDelete='N' and varName='" . $name . "'";
//        echo $sql;exit;
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

    function get_all_products() {
        $sql = "select varName,int_id,varImage from " . DB_PREFIX . "product where chrPublish='Y' and chrDelete='N' ORDER BY varName ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datass = array();
        foreach ($data as $row) {
            $imagename = $row['varImage'];
            $imagepath = 'upimages/product/listing_image/' . $imagename;
            $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);

            if ($imagename == '') {
                $image_detail_thumb = FRONT_MEDIA_URL . "images/no_img/ib_no_image.jpg";
            }
            $datas['CustomerID'] = $row['int_id'];
            $datas['ContactName'] = $row['varName'];
            $datas['CompanyImage'] = $image_detail_thumb;
            $datass[] = $datas;
        }
        return $datass;
    }

    function getPaymentTermsList($id = '') {
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
            $returnHtml .= '<span class="icheck-inline">
                                            <input ' . $selected . ' value="' . $row['int_id'] . '" type="checkbox" name="intPaymentTerms[]" id="intPaymentTerms' . $row['int_id'] . '" data-md-icheck />
                                            <label for="intPaymentTerms' . $row['int_id'] . '" class="inline-label">' . $row['varName'] . '</label>
                                        </span>';
        }
        return $returnHtml;
    }

    function getRequirementTypeFrontList($id = '') {
        $Result = array('Regular', 'One Time', 'Monthly');
        $returnHtml = '';
        $returnHtml .= "<select id=\"varReqType\"  onchange='return removereqtypeclass()' name=\"varReqType\" >";
        $returnHtml .= "<option value='' disabled selected>Requirement Type</option>";
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

    function getFrontUnitList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select onchange='return removeunitclass()' id=\"intUnit\" name=\"intUnit\" >";
        $returnHtml .= "<option value='' disabled selected>Measurement unit</option>";
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

    function FrontBindpageshierarchy($name, $selected_id, $class = 'listbox') {

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
            $display_output .= "<option value=" . $item['id'] . " " . (($item['id'] == $selected_id) ? 'selected' : '') . " " . $disabled . " >" . $item['treename'] . "</option>";
        }
        $display_output .= "</select>";
        return $display_output;
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

}

?>