<?php

class product_model extends CI_Model {

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
    var $numofproduct; // Attribute of Num Of Pagues In Result
    var $OrderBy = 't.int_id'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = 30; // Attribute of Org_calendarize For Paging
//    var $rPageSize = RIGHT_PANEL_PAGESIZE;
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
            $this->PageSize = (!empty($PageSize)) ? $PageSize : 20;
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
            'tablename' => DB_PREFIX . 'product',
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
            'search' => array('searchArray' => array("t.varName" => "Product Name", "u.varCompany" => "Company Name"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            )
        );
    }

    function Select_All_product_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = "t.chrDelete ='N'"; //
//        if ($this->SearchTxt != '') {
//            $whereclauseids .= (empty($this->SearchBy)) ? " AND t.varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
//        }
//        if ($this->FilterBy != '0') {
//            $filterarray = explode('-', $this->FilterBy);
//            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
//                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
//            }
//        }
        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {
            if ($this->SearchTxt != '') {
                $whereclauseids .= (empty($this->SearchBy)) ? " AND t.varName LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
            } else {
                $whereclauseids .= (empty($this->SearchBy)) ? " AND u.varCompany LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
            }
            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
                }
            }
        }
        $Type = $this->input->get_post('Type');
        if (!empty($type)) {
            if ($type == 'autosearch') {
                $OrderBy = (isset($this->OrderBy)) ? 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType : 'ORDER BY intDisplayOrder ASC';

                $SearchByVal = " LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'  AND chrDelete = 'N'";
                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
                    $this->SearchByVal = "t.varName";
                    $this->SearchByVal = "u.varCompany";
                }
                $this->db->select("t.*,$this->SearchByVal AS AutoVal");
                $this->db->from('product as t', false);

                $this->db->join('users AS u', 'u.int_id = t.intSupplier', 'left', false);
                $this->db->where("$this->SearchByVal $SearchByVal", null, FALSE);
                $this->db->group_by("t.varName $OrderBy");
                $autoSearchQry = $this->db->get();
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }
        $whereclause .= (empty($this->SearchBy)) ? " AND t.varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND t.$this->SearchBy like '%" . addslashes($this->SearchTxt) . "%' AND t.chrDelete='N'";


        $this->db->select("t.*,pc.varName as ParentCategoryName,u.varName as CustoName,u.varCompany", false);
        $this->db->from('product AS t', false);
        $this->db->join('product_category AS pc', 'pc.int_id = t.intParentCategory', 'left', false);
        $this->db->join('users AS u', 'u.int_id = t.intSupplier', 'left', false);
        $this->db->where($whereclauseids);
        $this->db->group_by('t.int_id');
        $this->db->order_by("$this->OrderBy", $this->OrderType);
        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }
        $rs = $this->db->get();
        $row = $rs->result_array();
        return $row;
    }

    function CountRows() {
//        $this->initialize();
//        $this->Generateurl();
        $whereclauseids = "t.chrDelete ='N'"; //
        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND t.varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
            $whereclauseids .= (empty($this->SearchBy)) ? " AND u.varCompany LIKE '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes($this->SearchTxt) . "%'";
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
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by varName asc';
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "product where $whereclauseids group by varName order by varName desc");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }
        $whereclause .= (empty($this->SearchBy)) ? " AND t.varName like '%" . addslashes($this->SearchTxt) . "%'" : " AND t.$this->SearchBy like '%" . addslashes($this->SearchTxt) . "%' AND t.chrDelete='N'";


        $this->db->select("t.*,pc.varName as ParentCategoryName,u.varName as CustoName,u.varCompany", false);
        $this->db->from('product AS t', false);
        $this->db->join('product_category AS pc', 'pc.int_id = t.intParentCategory', 'left', false);
        $this->db->join('users AS u', 'u.int_id = t.intSupplier', 'left', false);
        $this->db->where($whereclauseids);
        $this->db->group_by('t.int_id');
//        $this->db->order_by("$this->OrderBy", $this->OrderType);
        $rs = $this->db->get();
        $row = $rs->num_rows();
        return $row;
    }

    function Select_product_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('T.chrDelete' => 'N', 'T.int_id' => $id);
        $this->db->select('T.*,a.varAlias');
        $this->db->from('product As T');
        $this->db->join('alias AS a', 'T.int_id = a.fk_Record AND a.fk_ModuleGlCode=' . MODULE_ID, 'left');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function checkParent($pageid) {
        $sql = "select int_id from " . DB_PREFIX . "product_category where intParentCategory='" . $pageid . "'";
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        if ($count == 0) {
            $check = "Ok";
        } else {
            $check = "Change";
        }
        return $check;
    }

    function Insert() {

//        echo "<pre>";
//        print_r($_REQUEST);
//        exit;

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_product();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];


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
            $uploads_dir = 'upimages/product/brochure';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
        } else {
            $Filesurl = "";
        }

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';

        $TradeSecuritydata = ($this->input->post('chrTradeSecurity') == 'Y') ? 'Y' : 'N';
        $sampledata = ($this->input->post('chrSample') == 'Y') ? 'Y' : 'N';
        $FeaturesDisplaydata = ($this->input->post('chrFeaturesDisplay') == 'on') ? 'Y' : 'N';

        $counter = $this->input->get_post('file_hd', true);

        for ($i = 0; $i <= $counter; $i++) {
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

        if ($this->input->post('intDeliveryTerms') != '') {
            $DeliveryTerms = implode(",", $this->input->post('intDeliveryTerms'));
        } else {
            $DeliveryTerms = $this->input->post('intDeliveryTerms');
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

        $keyword = $this->input->post('varKeyword', TRUE);
        $material = $this->input->post('varMaterial', TRUE);

        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'intSupplier' => $this->input->post('intSupplier', TRUE),
            'intParentCategory' => $this->input->post('intParentCategory', TRUE),
            'varKeyword' => $keyword,
            'varHSCode' => $this->input->post('varHSCode', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'chrTradeSecurity' => $TradeSecuritydata,
            'chrFeaturesDisplay' => $FeaturesDisplaydata,
            'varSTitle' => $varSTi,
            'varSvalue' => $varSva,
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varPrice' => $this->input->post('varPrice', TRUE),
            'intPriceUnit' => $this->input->post('intPriceUnit', TRUE),
            'varMOQ' => $this->input->post('varMOQ', TRUE),
            'intMOQUnit' => $this->input->post('intMOQUnit', TRUE),
            'chrSample' => $sampledata,
            'varModelNo' => $this->input->post('varModelNo', TRUE),
            'varBrand' => $this->input->post('varBrand', TRUE),
            'varMaterial' => $material,
            'varUse' => $this->input->post('varUse', TRUE),
            'varProduction' => $this->input->post('varProduction', TRUE),
            'intUnit' => $this->input->post('intUnit', TRUE),
            'intTime' => $this->input->post('intTime', TRUE),
            'varPacking' => $this->input->post('varPacking', TRUE),
            'varService' => $this->input->post('varService', TRUE),
            'intPaymentType' => $PaymentType,
            'intDeliveryTerms' => $DeliveryTerms,
            'intPaymentTerms' => $PaymentTerms,
            'varBrochure' => $Filesurl,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'intDisplayOrder' => '1',
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );

        $query = $this->db->insert(DB_PREFIX . 'product', $data);
        $id = $this->db->insert_id();

        $count = count($_FILES['varImages']['name']);
        if ($this->input->post('tmpimage', TRUE) != '') {
            $imgnames = rtrim($this->input->post('tmpimage', TRUE), ",");
            $arrays = explode(",", $imgnames);
        } else {
            $imgnames = $this->input->post('tmpimage', TRUE);
            $arrays = array();
        }



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
                    $maindir = 'upimages/productgallery/images/';
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
                        'fkProduct' => $id,
                        'varImage' => $this->imagename,
                        'chrDefaultimage' => 'N',
                        'intDisplayOrder' => '1',
                        'dtCreateDate' => $c_date,
                        'dtModifyDate' => $c_date,
                    );
                    $this->db->insert(DB_PREFIX . 'productgallery', $data);
                }
            }
        }



        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Insert_Alias($Alias_Array);
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'product', $DisplayOrderClause);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'product', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function insert_contact_supplier() {

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
            $uploads_dir = 'upimages/contact_supplier/brochure';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
        } else {
            $Filesurl = "";
        }

        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];

        $matching = ($this->input->post('chrMatching') == 'on') ? 'Y' : 'N';
        $product_name = $this->input->post('varUProduct', TRUE);
        if ($matching == 'Y') {
            $getSameProductData = $this->getSameProductData($product_name);
//            echo "<pre>";
//            print_R($getSameProductData);exit;
            foreach ($getSameProductData as $rows) {
                $data = array(
                    'intProduct' => $rows['int_id'],
                    'intSupplier' => $user_id,
                    'varBrochure' => $Filesurl,
                    'txtUDescription' => $this->input->post('txtUDescription', TRUE),
                    'varQty' => $this->input->post('varQty', TRUE),
                    'intMOQUnit' => $this->input->post('intMOQUnit', TRUE),
                    'intPriceUnit' => $this->input->post('intPriceUnit', TRUE),
                    'varPrice' => $this->input->post('varPrice', TRUE),
                    'varCurrency' => $this->input->post('varCurrency', TRUE),
                    'chrMatching' => $matching,
                    'dtCreateDate' => date('Y-m-d H-i-s'),
                    'dtModifyDate' => date('Y-m-d H-i-s'),
                    'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                );
                $this->db->insert(DB_PREFIX . 'contact_product_supplier', $data);
                $id = $this->db->insert_id();
            }
        } else {
            $data = array(
                'intProduct' => $this->input->post('intProduct', TRUE),
                'intSupplier' => $user_id,
                'varBrochure' => $Filesurl,
                'txtUDescription' => $this->input->post('txtUDescription', TRUE),
                'varQty' => $this->input->post('varQty', TRUE),
                'intMOQUnit' => $this->input->post('intMOQUnit', TRUE),
                'intPriceUnit' => $this->input->post('intPriceUnit', TRUE),
                'varPrice' => $this->input->post('varPrice', TRUE),
                'varCurrency' => $this->input->post('varCurrency', TRUE),
                'chrMatching' => $matching,
                'dtCreateDate' => date('Y-m-d H-i-s'),
                'dtModifyDate' => date('Y-m-d H-i-s'),
                'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            );
            $this->db->insert(DB_PREFIX . 'contact_product_supplier', $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }

    function insert_product() {

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
            $uploads_dir = 'upimages/product/brochure';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
        } else {
            $Filesurl = $this->input->post('varhidd_Brochure');
        }


        $TradeSecuritydata = ($this->input->post('chrTradeSecurity') == 'Y') ? 'Y' : 'N';
        $sampledata = ($this->input->post('chrSample') == 'Y') ? 'Y' : 'N';
//        $FeaturesDisplaydata = $this->input->post('chrFeaturesDisplay');
//        if ($FeaturesDisplaydata == 'Y') {
        $counter = $this->input->get_post('file_hd', true);

        for ($i = 0; $i <= $counter; $i++) {
            if ($this->input->get_post('varSTitle' . $i, true) != '') {
                $varSTitle[] = strip_tags($this->input->get_post('varSTitle' . $i, true));
                $varSvalue[] = strip_tags($this->input->get_post('varSvalue' . $i, true));
            }
        }
        $varSTi = implode("__", $varSTitle);
        $varSva = implode("__", $varSvalue);
//        }
        if ($varSTitle == '') {
            $varSTi = "";
        }
        if ($varSvalue == '') {
            $varSva = "";
        }

        if ($this->input->post('intDeliveryTerms') != '') {
            $DeliveryTerms = implode(",", $this->input->post('intDeliveryTerms'));
        } else {
            $DeliveryTerms = $this->input->post('intDeliveryTerms');
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

        $keyword = rtrim($this->input->post('varKeyword', TRUE), ",");
        $material = rtrim($this->input->post('varMaterial', TRUE), ",");

//        $chrothers = $this->input->post('chrOther', TRUE);
//        $chrother = ($chrothers != '') ? $chrothers : 'Y';
        $chrother = ($this->input->post('chrOther') == 'on') ? 'Y' : 'N';

        if ($chrother == 'Y') {
            $other = $this->input->post('varOther', TRUE);
        } else {
            $other = '';
        }

        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'chrApprove' => 'P',
            'intSupplier' => $this->input->post('intUser', TRUE),
            'intParentCategory' => $this->input->post('intParentCategory', TRUE),
            'varKeyword' => $keyword,
            'varHSCode' => $this->input->post('varHSCode', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'chrTradeSecurity' => $TradeSecuritydata,
            'chrFeaturesDisplay' => 'Y',
            'varSTitle' => $varSTi,
            'varSvalue' => $varSva,
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varPrice' => $this->input->post('varPrice', TRUE),
            'intPriceUnit' => $this->input->post('intPriceUnit', TRUE),
            'varMOQ' => $this->input->post('varMOQ', TRUE),
            'intMOQUnit' => $this->input->post('intMOQUnit', TRUE),
            'chrSample' => $sampledata,
            'varModelNo' => $this->input->post('varModelNo', TRUE),
            'varBrand' => $this->input->post('varBrand', TRUE),
            'varMaterial' => $material,
            'varUse' => $this->input->post('varUse', TRUE),
            'varProduction' => $this->input->post('varProduction', TRUE),
            'intUnit' => $this->input->post('intUnit', TRUE),
            'intTime' => $this->input->post('intTime', TRUE),
            'varDays' => $this->input->post('varDays', TRUE),
            'varPort' => $this->input->post('varPort', TRUE),
            'varPacking' => $this->input->post('varPacking', TRUE),
            'varService' => $this->input->post('varService', TRUE),
            'chrOther' => $chrother,
            'varOther' => $other,
            'intPaymentType' => $PaymentType,
            'intDeliveryTerms' => $DeliveryTerms,
            'intPaymentTerms' => $PaymentTerms,
            'varBrochure' => $Filesurl,
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
        );




        $id = $this->input->post('product', TRUE);
        if ($id == '') {
            $data['chrPublish'] = "N";
            $data['dtCreateDate'] = date('Y-m-d H-i-s');
            $query = $this->db->insert(DB_PREFIX . 'product', $data);
            $id = $this->db->insert_id();
        } else {

            $pid = $this->mylibrary->decryptPass($id);
            $data['dtCreateDate'] = date('Y-m-d H-i-s');


            $this->db->where('int_id', $pid);
            $this->db->update(DB_PREFIX . 'product', $data);
        }
        $aliasname = strtolower($this->input->post('varName'));
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


        $count = count($_FILES['varImages']['name']);
        if ($this->input->post('tmpimage', TRUE) != '') {
            $imgnames = rtrim($this->input->post('tmpimage', TRUE), ",");
            $arrays = explode(",", $imgnames);
        } else {
            $imgnames = $this->input->post('tmpimage', TRUE);
            $arrays = array();
        }



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
                    $maindir = 'upimages/productgallery/images/';
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
                        'fkProduct' => $id,
                        'varImage' => $this->imagename,
                        'chrDefaultimage' => 'N',
                        'intDisplayOrder' => '1',
                        'dtCreateDate' => $c_date,
                        'dtModifyDate' => $c_date,
                    );
                    $this->db->insert(DB_PREFIX . 'productgallery', $data);
                }
            }
        }

        return $id;
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

    function update() {
//echo "<pre>";
//print_R($_REQUEST);exit;
//        $filename = ;
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
            $uploads_dir = 'upimages/product/brochure';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
        } else {
            $Filesurl = $this->input->post('hidd_VarBrochure');
        }



        $TradeSecuritydata = ($this->input->post('chrTradeSecurity') == 'Y') ? 'Y' : 'N';
        $sampledata = ($this->input->post('chrSample') == 'Y') ? 'Y' : 'N';
        $FeaturesDisplaydata = ($this->input->post('chrFeaturesDisplay') == 'on') ? 'Y' : 'N';

        $counter = $this->input->get_post('file_hd', true);

        for ($i = 0; $i <= $counter; $i++) {
            if ($this->input->get_post('varSTitle' . $i, true) != '') {
                $varSTitle[] = strip_tags($this->input->get_post('varSTitle' . $i, true));
                $varSvalue[] = strip_tags($this->input->get_post('varSvalue' . $i, true));
            }
        }
        if ($varSTitle != '') {
            $varSTi = "";
        }
        if ($varSvalue != '') {
            $varSva = "";
        }
        $varSTi = implode("__", $varSTitle);
        $varSva = implode("__", $varSvalue);

        if ($this->input->post('intDeliveryTerms') != '') {
            $DeliveryTerms = implode(",", $this->input->post('intDeliveryTerms'));
        } else {
            $DeliveryTerms = $this->input->post('intDeliveryTerms');
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

        $keyword = $this->input->post('varKeyword', TRUE);
        $material = $this->input->post('varMaterial', TRUE);


        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_product();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        $Int_DisplayOrder = $this->input->post('intDisplayOrder');



        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'intParentCategory' => $this->input->post('intParentCategory', TRUE),
            'intSupplier' => $this->input->post('intSupplier', TRUE),
            'varKeyword' => $keyword,
            'varHSCode' => $this->input->post('varHSCode', TRUE),
            'txtDescription' => $this->mylibrary->Replace_Sitepath_with_Varible($this->input->post('txtDescription')),
            'chrTradeSecurity' => $TradeSecuritydata,
            'chrFeaturesDisplay' => $FeaturesDisplaydata,
            'varSTitle' => $varSTi,
            'varSvalue' => $varSva,
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varPrice' => $this->input->post('varPrice', TRUE),
            'intPriceUnit' => $this->input->post('intPriceUnit', TRUE),
            'varMOQ' => $this->input->post('varMOQ', TRUE),
            'intMOQUnit' => $this->input->post('intMOQUnit', TRUE),
            'chrSample' => $sampledata,
            'varModelNo' => $this->input->post('varModelNo', TRUE),
            'varBrand' => $this->input->post('varBrand', TRUE),
            'varMaterial' => $material,
            'varUse' => $this->input->post('varUse', TRUE),
            'varProduction' => $this->input->post('varProduction', TRUE),
            'intUnit' => $this->input->post('intUnit', TRUE),
            'intTime' => $this->input->post('intTime', TRUE),
            'varPacking' => $this->input->post('varPacking', TRUE),
            'varService' => $this->input->post('varService', TRUE),
            'intPaymentType' => $PaymentType,
            'intDeliveryTerms' => $DeliveryTerms,
            'intPaymentTerms' => $PaymentTerms,
            'varBrochure' => $Filesurl,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'intDisplayOrder' => $Int_DisplayOrder,
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );

//        print_r($data);exit;

        $id = $this->db->insert_id();

        $opertion = 'U';
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update(DB_PREFIX . 'product', $data);





        $count = count($_FILES['varImages']['name']);
        if ($this->input->post('tmpimage', TRUE) != '') {
            $imgnames = rtrim($this->input->post('tmpimage', TRUE), ",");
            $arrays = explode(",", $imgnames);
        } else {
            $imgnames = $this->input->post('varImages', TRUE);
            $arrays = array();
        }


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
                    $maindir = 'upimages/productgallery/images/';
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
                        'fkProduct' => $this->input->get_post('ehintglcode'),
                        'varImage' => $this->imagename,
                        'chrDefaultimage' => 'N',
                        'intDisplayOrder' => '1',
                        'dtCreateDate' => $c_date,
                        'dtModifyDate' => $c_date,
                    );
                    $this->db->insert(DB_PREFIX . 'productgallery', $data);
                }
            }
        }

        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'product', $DisplayOrderClause);
        $int_id = $this->input->get_post('ehintglcode');
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Update_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'product', 'Name' => 'varName', 'ModuleintGlcode' => $int_id, 'Flag' => $opertion, 'Default' => 'int_id');
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
        $this->db->cache_set_common_path("application/cache/db/common/product/");
        $this->db->cache_delete();

        $uids = $this->input->get_post('uid');
        $neworder = $this->input->get_post('neworder');
        $oldorder = $this->input->get_post('oldorder');
        $fkpages = $this->input->get_post('pageid');

        if (empty($fkpages)) {
            $fkpages = 0;
        }

        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'product', " AND intParentCategory='" . $fkpages . "'");
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'product', " AND intParentCategory='" . $fkpages . "'");
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'product';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d h-i-s'), 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'product', 'Name' => 'varName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
            $this->mylibrary->insertinlogmanager($ParaArray);
            $cat = $this->get_cat($deletearray[$i]);
            $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'product', " AND intParentCategory ='" . $cat . "'");
        }
    }

    function approve_product() {
        $approve = $this->input->get_post('chrPublish');
        $Eid = $this->input->get_post('Eid');

//        if ($approve == 'N') {
//            $data = array('chrApprove' => 'N', 'chrPublish' => $approve, 'dtModifyDate' => date('Y-m-d H-i-s'));
//        } else {
        $data = array('chrApprove' => $approve, 'chrPublish' => $approve, 'dtModifyDate' => date('Y-m-d H-i-s'));
//        }

        $this->db->where('int_id', $Eid);
        $this->db->update('product', $data);
    }

    function get_cat($id = '') {
        $query = $this->db->get_where('product', array('int_id' => $id));
        $row = $query->row_array();
        return $row['intParentCategory'];
    }

    function getProductPage($id = '') {
//        $query = $this->db->get_where('product', array('int_id' => $id));
        $query = $this->db->query("select * from " . DB_PREFIX . "product where chrDelete = 'N' and intParentCategory='" . $id . "'");
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

    function generate_seocontent_product($fromajax = false) {
        $PageName = $this->input->post('varName', true);
        if ($fromajax) {
            $description = html_entity_decode(strip_tags($this->input->get_post('description', true)));
        } else {
            $description = strip_tags($this->input->post('varName', TRUE));
        }
        $meta_title = $PageName;
        $meta_keyword = $PageName;
        $meta_description = substr($description, 0, 400);
        $seo_data = $meta_title . '*****' . $meta_keyword . '*****' . $meta_description;
        return $seo_data;
    }

//    function CategoryFilter() {
//        $query = $this->db->query("select pc.int_id AS id, pc.varName AS name from " . DB_PREFIX . "product as p left join " . DB_PREFIX . "SharePointCategory as pc on pc.int_id = pc.intSharePointCategory  where  pc.chrDelete = 'N' group by pc.varName order by pc.intDisplayOrder asc");
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
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "product as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE N.intParentCategory='0' and A.fk_ModuleGlCode='96'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.intDisplayOrder desc,N.int_id desc $limitby";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function SelectAll_detail_front_id($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "product as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='96'  and N.chrPublish='Y' and N.chrDelete='N' and N.int_id!='" . $id . "' group by N.int_id order by N.intDisplayOrder desc,N.int_id desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function getProductCatList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "product where chrDelete = 'N' and intParentCategory='0' order by intDisplayOrder asc");
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

    function getDeliveryTermsList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "delivery_terms where chrDelete = 'N' order by varName asc");
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
                                            <input ' . $selected . ' value="' . $row['int_id'] . '" type="checkbox" name="intDeliveryTerms[]" id="intDeliveryTerms' . $row['int_id'] . '" data-md-icheck />
                                            <label for="intDeliveryTerms' . $row['int_id'] . '" class="inline-label">' . $row['varName'] . '</label>
                                        </span>';
        }
        return $returnHtml;
    }

    function getDeliveryTermsLists($id) {
        $id_array = explode(",", $id);
        $returnHtml = '';

        foreach ($id_array as $row) {
            $query = $this->db->query("select * from " . DB_PREFIX . "delivery_terms where int_id='" . $row . "' and chrDelete = 'N' order by varName asc");
            $Result = $query->row_array();

            $returnHtml .= $Result['varName'] . ", ";
        }
        return rtrim($returnHtml, ", ");
    }

    function getPaymentTypeLists($id) {
        $id_array = explode(",", $id);
        $returnHtml = '';

        foreach ($id_array as $row) {
            $query = $this->db->query("select * from " . DB_PREFIX . "payment_types where int_id='" . $row . "' and chrDelete = 'N' order by varName asc");
            $Result = $query->row_array();

            $returnHtml .= $Result['varName'] . ", ";
        }
        return rtrim($returnHtml, ", ");
    }

    function getPaymentTermsLists($id) {
        $id_array = explode(",", $id);
        $returnHtml = '';

        foreach ($id_array as $row) {
            $query = $this->db->query("select * from " . DB_PREFIX . "payment_terms where int_id='" . $row . "' and chrDelete = 'N' order by varName asc");
            $Result = $query->row_array();

            $returnHtml .= $Result['varName'] . ", ";
        }
        return rtrim($returnHtml, ", ");
    }

    function getFrontDeliveryTermsList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "delivery_terms where chrDelete = 'N' order by varName asc");
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
                                           <input ' . $selected . ' value="' . $row['int_id'] . '" type="checkbox" name="intDeliveryTerms[]" id="intDeliveryTerms' . $row['int_id'] . '" class="filled-in" />
                                           <span for="intDeliveryTerms' . $row['int_id'] . '">' . $row['varName'] . '</span>
                </label>
                        </div>
                </div>';
        }
        return $returnHtml;
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
        $returnHtml .= '<div class="check-all col m3 s6">
                <div class="check-border">
                <label>
                                           <input type="checkbox" onclick="otherdiv()" name="chrOther" id="chrOther" class="filled-in" />
                                           <span for="chrOther">Other</span>
                </label>
                        </div>
                </div>';
        return $returnHtml;
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

    function getPaymentTypeList($id = '') {
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
            $returnHtml .= '<span class="icheck-inline">
                                            <input ' . $selected . ' value="' . $row['int_id'] . '"  type="checkbox" name="intPaymentType[]" id="intPaymentType' . $row['int_id'] . '" data-md-icheck />
                                            <label for="intPaymentType' . $row['int_id'] . '" class="inline-label">' . $row['varName'] . '</label>
                                        </span>';
        }
        return $returnHtml;
    }

//    function insert_photo() {
//
//
//        if ($_FILES['file']['name'] != '') {
//
//            $config['upload_path'] = 'upimages/product/images/';
//            $config['allowed_types'] = 'gif|jpg|jpeg|png';
//            $config['max_size'] = '1000000';
////            $FileExntension = substr(strrchr($_FILES['file']['name'], '.'), 1);
////            $this->ImageName = $_FILES['file']['name'] . "_" . time() . $FileExntension;
//
//            $this->ImageName = $_FILES['file']['name'];
//            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
//            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
//            $Imagesurl = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
//
//
////            $Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
//            $config['file_name'] = $this->ImageName;
//            $this->load->library('upload', $config);
//            $this->upload->initialize($config);
//            if (!$this->upload->do_upload('file')) {
//                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
//                echo $this->upload->display_errors();
//                exit;
//            }
//        }
//        $image_title = basename($_FILES['file']['name']);
//        $fileexntension = substr(strrchr($image_title, '.'), 1);
//        $varName = str_replace('.' . $fileexntension, '', $image_title);
//
//        $data = array(
//            'varName' => $varName,
//            'fkProduct ' => '',
//            'varImage' => $Imagesurl,
//            'chrDefaultimage' => 'N',
//            'chrDelete' => 'Y',
//            'dtCreateDate' => date('Y-m-d H:i:s'),
//            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
//            'PUserGlCode' => ADMIN_ID
//        );
//        $this->db->insert(DB_PREFIX . 'productgallery', $data);
//        return true;
//    }

    function insert_product_images() {
        $user_id = "1";
//        $user_id = $this->input->post('product_id');
        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];
            $fileName = time() . $_FILES['file']['name'];
            $targetPath = 'upimages/product/images/';
            $targetFile = $targetPath . $fileName;
            move_uploaded_file($tempFile, $targetFile);

            $image_title = basename($fileName);
            $fileexntension = substr(strrchr($image_title, '.'), 1);
            $varName = str_replace('.' . $fileexntension, '', $image_title);

            $data = array(
                'varName' => $varName,
                'file' => $fileName,
                'fkProduct' => $user_id,
                'chrPublish' => 'Y',
                'intDisplayOrder' => $Int_DisplayOrder,
                'dtCreateDate' => date('Y-m-d H-i-s'),
                'dtModifyDate' => date('Y-m-d H-i-s'),
                'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                'PUserGlCode' => ADMIN_ID
            );
            $query = $this->db->insert(DB_PREFIX . 'productgallery', $data);
        }
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

    function getFrontUnitList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select id=\"intUnit\" name=\"intUnit\" >";
        $returnHtml .= "<option  disabled selected value=''>Select Unit</option>";
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

    function getUnitList1($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"intPriceUnit\" name=\"intPriceUnit\" >";
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

    function getFrontUnitList1($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select onchange='return removeunitclass();' id=\"intPriceUnit\" name=\"intPriceUnit\" >";
        $returnHtml .= "<option value='' disabled selected>Select Unit</option>";
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

    function getSupplerList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "users where chrDelete = 'N' and chrType='BS' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input\" size='10'  data-md-selectize data-md-selectize-bottom  id=\"intSupplier\" name=\"intSupplier\" >";
        $returnHtml .= "<option value=''>--Select Supplier --</option>";
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varCompany'] . " (" . $row['varName'] . ')</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getUnitList2($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"intMOQUnit\" name=\"intMOQUnit\" >";
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

    function getFrontUnitList2($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select onchange='return remove_moq_unitclass();' id=\"intMOQUnit\" name=\"intMOQUnit\" >";
        $returnHtml .= "<option value='' disabled selected>Select MOQ Unit*</option>";
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

    function getTimeList($id = '') {
//        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
//        $Result = $query->result_array();
        $Result = array('Day', 'Quater', 'Week', 'Month', 'Year');
        $returnHtml = '';
        $returnHtml .= "<select class=\"md-input label-fixed\" id=\"intTime\" name=\"intTime\" >";
        $returnHtml .= "<option value=''>--Select Time --</option>";
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

    function getFrontTimeList($id = '') {
//        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
//        $Result = $query->result_array();
        $Result = array('Day', 'Quater', 'Week', 'Month', 'Year');
        $returnHtml = '';
        $returnHtml .= "<select id=\"intTime\" name=\"intTime\" >";
        $returnHtml .= "<option value='' disabled selected>Select Time</option>";
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

    public function SelectAll_Detail_front($id) {
        $sql = "select p.*,A.varAlias,au.varAlias as usersite,u.varCompany as CompanyName,u.intPlan,u.ftResponseRate,ci.varOwnerType,ci.varTotalEmployees,ci.varRegistration,u.varCity,u.varCountry,ci.varBusinessType,um.varName as PriceUnit,uum.varName as PUnitName,umq.varName as MOQUnit "
                . "from " . DB_PREFIX . "product p "
                . "LEFT JOIN " . DB_PREFIX . "alias as A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users as u ON p.intSupplier=u.int_id "
                . "LEFT JOIN " . DB_PREFIX . "alias as au ON p.intSupplier=au.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "company_information as ci ON ci.intUser=p.intSupplier "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON p.intPriceUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as uum ON p.intUnit=uum.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON p.intMOQUnit=umq.int_id "
                . "WHERE p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='140' and au.fk_ModuleGlCode='136' and p.int_id='" . $id . "' group by p.int_id";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function get_product_images($eid = '') {
//        print_R($_REQUEST);
        $id = ADMIN_ID;

        if ($eid != '') {
            $sql = "select * from " . DB_PREFIX . "productgallery where chrDelete='N' and chrPublish='Y' and fkProduct='" . $eid . "'";
        } else {
            $sql = "select * from " . DB_PREFIX . "productgallery where chrDelete='Y' and chrPublish='Y' and PUserGlCode='" . $id . "' and fkProduct='0'";
        }
        $query = $this->db->query($sql);
        $project = $query->result_array();

//        return $data;
//        $project = $this->DataModel->getbyid('productgallery', array('fkProduct' => '1'));
        foreach ($project as $image) {
            if (!empty($image['varImage'])) {
                $obj['name'] = $image['varImage']; //get the filename in array
                $obj['image_id'] = $image['int_id']; //get the filename in array
                $obj['size'] = filesize("upimages/product/images/" . $image['varImage']); //get the file size in array
                $result[] = $obj; // copy it to another array
            }
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function delete_image($id) {


        $sql = "select * from " . DB_PREFIX . "productgallery where int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $project = $query->row_array();

        $path = 'upimages/product/images/' . $project['varImage'];
        unlink($path);
        $this->db->where('int_id', $id);
        $this->db->limit('1');
        $this->db->delete(DB_PREFIX . 'productgallery');
        return true;
    }

    public function delete_images_onload() {

        $sql = "select * from " . DB_PREFIX . "productgallery where chrDelete='Y' and chrPublish='Y' and PUserGlCode='" . ADMIN_ID . "' and fkProduct='0'";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        foreach ($data as $project) {
            $path = 'upimages/product/images/' . $project['varImage'];
            unlink($path);
            $this->db->where('int_id', $project['int_id']);
            $this->db->limit('1');
            $this->db->delete(DB_PREFIX . 'productgallery');
        }
        return true;
    }

    public function delete_image_by_name() {
        $imagename = $this->input->get_post('imgname');
        $image_title = basename($imagename);
        $fileexntension = substr(strrchr($image_title, '.'), 1);
        $imagename = str_replace('.' . $fileexntension, '', $image_title);

        $sql = "select * from " . DB_PREFIX . "productgallery where varName='" . $imagename . "' and (PUserGlCode='" . ADMIN_ID . "' or PUserGlCode='1') order by int_id desc";
        $query = $this->db->query($sql);
        $project = $query->row_array();

        $path = 'upimages/product/images/' . $project['varImage'];
        unlink($path);
        $this->db->where('varName', $imagename);
        $this->db->delete(DB_PREFIX . 'productgallery');
        return true;
    }

    public function SelectAll_detail_front_id1($id) {
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "product as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='86'  and N.chrPublish='Y' and N.chrDelete='N' and N.int_id='" . $id . "' group by N.int_id";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getHomePageSubProductCategory($id) {
        $sql = "select pc.*,A.varAlias from " . DB_PREFIX . "product pc LEFT JOIN " . DB_PREFIX . "alias A ON pc.int_id=A.fk_Record WHERE pc.intParentCategory='" . $id . "' and pc.chrPublish='Y' and A.fk_ModuleGlCode='86' and pc.chrDelete='N' group by pc.int_id order by pc.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getproductData($id) {
        $sql = "select p.*,A.varAlias as alias from " . DB_PREFIX . "product p "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "product pc ON p.fkintCategory=pc.int_id"
                . " WHERE p.chrPublish='Y' and A.fk_ModuleGlCode='96' and p.fkintCategory='" . $id . "' and p.chrDelete='N' group by p.int_id order by p.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getCategoryProductsData($id = '') {
        $sql = "select E.*,A.varAlias,AU.varAlias as usersite,U.varCity,U.varCountry,U.varCompany,U.varSubdomain,um.varName as PriceUnit,uum.varName as PUnitName,umq.varName as MOQUnit from " . DB_PREFIX . "product E "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users U ON U.int_id=E.intSupplier "
                . "LEFT JOIN " . DB_PREFIX . "alias AU ON U.int_id=AU.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON E.intPriceUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as uum ON E.intUnit=uum.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON E.intMOQUnit=umq.int_id "
                . "WHERE E.int_id!='" . RECORD_ID . "' and U.chrType='BS' and E.chrPublish='Y' and E.intParentCategory='" . $id . "' and A.fk_ModuleGlCode='140' and AU.fk_ModuleGlCode='136' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc limit 20";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getCompanyProductsData($id) {
        $sql = "select E.*,A.varAlias,AU.varAlias as usersite,U.varCity,U.varCountry,U.varCompany,U.varSubdomain,um.varName as PriceUnit,uum.varName as PUnitName,umq.varName as MOQUnit from " . DB_PREFIX . "product E "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users U ON U.int_id=E.intSupplier "
                . "LEFT JOIN " . DB_PREFIX . "alias AU ON U.int_id=AU.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON E.intPriceUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as uum ON E.intUnit=uum.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON E.intMOQUnit=umq.int_id "
                . "WHERE E.int_id!='" . RECORD_ID . "' and U.chrType='BS' and E.chrPublish='Y' and E.intSupplier='" . $id . "' and A.fk_ModuleGlCode='140' and AU.fk_ModuleGlCode='136' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc limit 20";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getProductLisitngData() {
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
        $where = " p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='140' ";
//        $where = " p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='140' and u.varCompany!='' ";


        $type = $this->input->get_post('type');
        $keyword = trim($this->input->get_post('keyword'));
        if ($keyword != '') {
//            $multikeys = explode(" ", $keyword);
//            foreach ($multikeys as $keye) {
//                $where .= " p.varKeyword like '%" . $keye . "%' or  ";
//            }
            if ($type == '3') {
                $where .= " and u.varCompany like '%" . $keyword . "%'";
            } else {

                $multikeys = explode(" ", $keyword);
                if (count($multikeys) > 0) {
                    $where .= " and (";
                    foreach ($multikeys as $keye) {
                        $where .= " p.varKeyword like '%" . $keye . "%' or";
                    }
                    $where = rtrim($where, "or");
                    $where .= " ) ";
                }
//                $where .= " and p.varName like '%" . $keyword . "%'";
            }
        }
        $security = $this->input->get_post('security');
        if ($security != '') {
            $where .= " and p.chrTradeSecurity='Y'";
        }
        $sample = $this->input->get_post('sample');
        if ($sample != '') {
            $where .= " and p.chrSample='Y'";
        }

        $city = $this->input->get_post('city');
        $city = rtrim($city, ",");
        if ($city != '') {
            $where .= " and FIND_IN_SET(u.varCity, '" . $city . "') ";
        }
        $bussiness = $this->input->get_post('business');
        $bussiness = rtrim($bussiness, ",");
        if ($bussiness != '') {
            $bussiness_type = explode(",", $bussiness);
            $bussiness_types = implode("|", $bussiness_type);
            $bussiness_types = rtrim($bussiness_types, "|");
            if (!empty($bussiness_type)) {
                $where .= ' and CONCAT(",", ci.varBusinessType, ",") REGEXP (' . $bussiness_types . ')';
            }
        }
        $category = $this->input->get_post('cat');
        if ($category != '') {
            $where .= " and p.intParentCategory='" . $category . "'";
        }
        $rating = $this->input->get_post('rating');
        if ($rating != '') {
            $where .= " and u.intRating='" . $rating . "'";
        }

        $response = $this->input->get_post('response');
        if ($response != '') {
            if ($response == 4) {
                $where .= " and u.ftResponseRate>='76' and u.ftResponseRate<='100' ";
            } else if ($response == 3) {
                $where .= " and u.ftResponseRate>='51' and u.ftResponseRate<='75' ";
            } else if ($response == 2) {
                $where .= " and u.ftResponseRate>='26' and u.ftResponseRate<='50' ";
            } else if ($response == 1) {
                $where .= " and u.ftResponseRate>='0' and u.ftResponseRate<='25' ";
            }
        }


//        $type = $this->input->get_post('type');
        if (RECORD_ID == '99') {
            $group = " p.intSupplier";
        } else {
            $group = " p.int_id";
        }

        $plans = $this->input->get_post('plans');
        $plans = rtrim($plans, ",");
        if ($plans != '') {
            $plan_type = explode(",", $plans);
            $plan_type = array_unique($plan_type);
            $plan_type = implode(",", $plan_type);
            if (!empty($plan_type)) {
                $where .= " and FIND_IN_SET (u.intPlan,'" . $plan_type . "') ";
            }
        }
        $data = array();
        $sql = "";
        $sql = "select p.*,A.varAlias,u.varCompany as CompanyName,u.chrPayment,u.ftResponseRate,u.intPlan,u.varSubdomain,u.varCity,u.varCountry,ci.varBusinessType,ci.varRegistration,um.varName as PriceUnit,umq.varName as MOQUnit "
                . "from " . DB_PREFIX . "product p "
                . "LEFT JOIN " . DB_PREFIX . "alias as A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users as u ON p.intSupplier=u.int_id "
//                . "LEFT JOIN " . DB_PREFIX . "alias as au ON p.intSupplier=au.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "company_information as ci ON ci.intUser=p.intSupplier "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON p.intPriceUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON p.intMOQUnit=umq.int_id "
                . "WHERE " . $where . " group by $group "
                . "order by CASE WHEN p.varName LIKE '$keyword%' THEN 1 WHEN p.varName LIKE '%$keyword' THEN 3 ELSE 2 END, u.chrPayment desc,u.intPayment desc,p.varName asc $limitby";
//       echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function getCategoryNames() {
        $html = "";
        $data = array();
        $sql = "";
        $keyword = trim($this->input->get_post('keyword'));
        $where = " p.chrDelete='N' and p.chrPublish='Y' ";
        if ($keyword != '') {
            $where .= " and p.varName like '%" . $keyword . "%'";
        }
        $sql = "select pc.varName as CategoryName,pc.int_id "
                . "from " . DB_PREFIX . "product p "
                . "LEFT JOIN " . DB_PREFIX . "product_category as pc ON p.intParentCategory=pc.int_id "
                . "WHERE " . $where . " group by p.intParentCategory "
                . "order by CASE WHEN p.varName LIKE '$keyword%' THEN 1 WHEN p.varName LIKE '%$keyword' THEN 3 ELSE 2 END, p.varName asc limit 20";
//       echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->result_array();

        $perentcat = array();
//        print_R($data);
        $catredata = array();
        foreach ($data as $catname) {
            $getParentCategoryId = $this->getParentCatId($catname['int_id']);

            if (!in_array($getParentCategoryId['intParentCategory'], $catredata)) {
                $perentcat[] = array(
                    'intPerentCategoryId' => $getParentCategoryId['int_id'],
                    'intPerentCategoryPId' => $getParentCategoryId['intParentCategory'],
                    'intPerentCategoryName' => $getParentCategoryId['varName']
                );
                $catredata[] = $getParentCategoryId['intParentCategory'];
            }
        }
//        echo "<pre>";
//        print_R($perentcat);
//        echo "</pre>";
        $i = 1;
        foreach ($perentcat as $cats) {
            $getSubParentCategoryData = array();
            $getSubParentCategoryData = $this->getSubCatData($cats['intPerentCategoryPId']);
            if (count($getSubParentCategoryData) > 0) {
                if ($i >= '3') {
                    $cl = 'class="see-more-menu"';
                } else {
                    $cl = '';
                }
                $html .= '<ul ' . $cl . '>
                                                <li class="sub-cat-sub">
                                                    <a href="javascript:;" class="sub-sub-cat">' . $cats['intPerentCategoryName'] . '&nbsp;</a>
                                                    <ul>';
                foreach ($getSubParentCategoryData as $scdata) {
                    $countcat = $this->getProductCount($scdata['int_id']);
                    if ($countcat > 0) {
                        $html .= '<li><a href="javascript:;" onclick=\'return updatefilter("cat", "' . $scdata['int_id'] . '")\'>' . $scdata['CategoryName'] . '<strong>(' . $countcat . ')</strong></a></li>';
                    }
                }
                $html .= '</ul>
                                                </li>
                                            </ul>';
                $i++;
            }
        }
        $htmls = array();
        $htmls['html'] = $html;
        $htmls['count'] = $i;
        return $htmls;
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
                $fkstring .= $result['int_id'] . ',';
                return $this->checkParents($result['intParentCategory'], $fkstring);
            } else {
                $fkstring .= $result['int_id'];
                return $fkstring;
            }
        } else {
            return $fkstring;
        }
    }

    function getCategoryListNames($id = '') {
        if ($id == '') {
            $id = $this->input->get_post('intCategory');
        }
        $fkstring = '';
        $html = "";
        $checkparent = $this->checkParents($id, $fkstring);

        $sql = "select varName from " . DB_PREFIX . "product_category where int_id IN($checkparent) group by int_id order by int_id asc";
//       echo $sql;exit;
        $rs = $this->db->query($sql);
        $countdata = $rs->num_rows();
        $resultdata1 = $rs->result_array($rs);
        foreach ($resultdata1 as $name) {
            $html .= $name['varName'] . " > ";
        }
        $html = substr($html, 0, -2);
        return $html;
    }

    function getProductCount($id) {
        $keyword = trim($this->input->get_post('keyword'));
        $where = " p.chrDelete='N' and p.chrPublish='Y' ";
        if ($keyword != '') {
            $where .= " and p.varName like '%" . $keyword . "%' ";
        }
        $where .= " and p.intParentCategory='" . $id . "'";
        $sql = "select count(p.int_id) as count "
                . "from " . DB_PREFIX . "product p "
                . "LEFT JOIN " . DB_PREFIX . "product_category as pc ON p.intParentCategory=pc.int_id WHERE " . $where . "";
//      echo $sql;
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data['count'];
    }

    function getParentCatId($id) {
        $sql = "select intParentCategory,varName,int_id from " . DB_PREFIX . "product_category  WHERE int_id='" . $id . "' and chrDelete='N' and chrPublish='Y'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    function getSubCatData($id) {
        $keyword = trim($this->input->get_post('keyword'));
        $where = " p.chrDelete='N' and p.chrPublish='Y' ";
//        if ($keyword != '') {
//            $where .= " and p.varName like '%" . $keyword . "%' ";
//        }
        $where .= " and pc.intParentCategory='" . $id . "'";
        $sql = "select pc.varName as CategoryName,pc.int_id "
                . "from " . DB_PREFIX . "product p "
                . "LEFT JOIN " . DB_PREFIX . "product_category as pc ON p.intParentCategory=pc.int_id "
                . "WHERE " . $where . " group by pc.varName "
                . "order by p.varName asc limit 2";
//      echo $sql;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function CountRow_front() {

        $where = " p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='140' ";
//        $where = " p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='140' and u.varCompany!='' ";
        $keyword = trim($this->input->get_post('keyword'));
        if ($keyword != '') {
            $multikeys = explode(" ", $keyword);
            if (count($multikeys) > 0) {
                $where .= " and (";
                foreach ($multikeys as $keye) {
                    $where .= " p.varKeyword like '%" . $keye . "%' or";
                }
                $where = rtrim($where, "or");
                $where .= " ) ";
            }
        }
        $security = $this->input->get_post('security');
        if ($security != '') {
            $where .= " and p.chrTradeSecurity='Y'";
        }
        $sample = $this->input->get_post('sample');
        if ($sample != '') {
            $where .= " and p.chrSample='Y'";
        }

        $city = $this->input->get_post('city');
        $city = rtrim($city, ",");
        if ($city != '') {
            $where .= " and FIND_IN_SET(u.varCity, '" . $city . "') ";
        }

        $bussiness = $this->input->get_post('business');
        $bussiness = rtrim($bussiness, ",");
        if ($bussiness != '') {
            $bussiness_type = explode(",", $bussiness);
            $bussiness_types = implode("|", $bussiness_type);
            $bussiness_types = rtrim($bussiness_types, "|");
            if (!empty($bussiness_type)) {
                $where .= ' and CONCAT(",", ci.varBusinessType, ",") REGEXP (' . $bussiness_types . ')';
            }
        }
        $category = $this->input->get_post('cat');
        if ($category != '') {
            $where .= " and p.intParentCategory='" . $category . "'";
        }

        $rating = $this->input->get_post('rating');
        if ($rating != '') {
            $where .= " and u.intRating='" . $rating . "'";
        }
        $response = $this->input->get_post('response');
        if ($response != '') {
            if ($response == 4) {
                $where .= " and u.ftResponseRate>='76' and u.ftResponseRate<='100' ";
            } else if ($response == 3) {
                $where .= " and u.ftResponseRate>='51' and u.ftResponseRate<='75' ";
            } else if ($response == 2) {
                $where .= " and u.ftResponseRate>='26' and u.ftResponseRate<='50' ";
            } else if ($response == 1) {
                $where .= " and u.ftResponseRate>='0' and u.ftResponseRate<='25' ";
            }
        }

//        $type = $this->input->get_post('type');
        if (RECORD_ID == '99') {
            $group = " p.intSupplier";
        } else {
            $group = " p.int_id";
        }

        $plans = $this->input->get_post('plans');
        $plans = rtrim($plans, ",");
        if ($plans != '') {
            $plan_type = explode(",", $plans);
            $plan_type = array_unique($plan_type);
            $plan_type = implode(",", $plan_type);
            if (!empty($plan_type)) {
                $where .= " and FIND_IN_SET (u.intPlan,'" . $plan_type . "') ";
            }
        }
        $data = array();
        $sql = "";
        $sql = "select p.*,A.varAlias,u.varCompany as CompanyName,u.varCity,u.varCountry,ci.varBusinessType,ci.varRegistration,um.varName as PriceUnit,umq.varName as MOQUnit "
                . "from " . DB_PREFIX . "product p "
                . "LEFT JOIN " . DB_PREFIX . "alias as A ON p.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users as u ON p.intSupplier=u.int_id "
                . "LEFT JOIN " . DB_PREFIX . "company_information as ci ON ci.int_id=p.intSupplier "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON p.intPriceUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON p.intMOQUnit=umq.int_id "
                . "WHERE " . $where . " group by $group "
                . "order by CASE WHEN p.varName LIKE '$keyword%' THEN 1 WHEN p.varName LIKE '%$keyword' THEN 3 ELSE 2 END, u.chrPayment desc,u.intPayment desc,p.varName asc";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    function getCityFilter($id = '') {

        $keyword = trim($this->input->get_post('keyword'));
        $city = $this->input->get_post('city');
        $where = " p.chrDelete='N' and p.chrPublish='Y' and u.chrDelete = 'N' ";
//        $where = " p.chrDelete='N' and p.chrPublish='Y' and A.fk_ModuleGlCode='140' and u.varCompany!='' ";

        if ($keyword != '') {
            $multikeys = explode(" ", $keyword);
            if (count($multikeys) > 0) {
                $where .= " and (";
                foreach ($multikeys as $keye) {
                    $where .= " p.varKeyword like '%" . $keye . "%' or";
                }
                $where = rtrim($where, "or");
                $where .= " ) ";
            }
        }


        $city_type = explode(",", $city);
        $query = $this->db->query("select  u.varCity,COUNT(u.varCity) AS city_name  from " . DB_PREFIX . "users as u left join " . DB_PREFIX . "product as p on p.intSupplier=u.int_id where $where  GROUP BY u.varCity order by city_name desc limit 10");
        $Result = $query->result_array();
        $returnHtml = '';
        $i = 0;
        foreach ($Result as $row) {
            if ($row['varCity'] != '') {
                if (in_array($row['varCity'], $city_type)) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }
                if ($i == 4) {
                    $returnHtml .= '<div class="see-more-menu1">';
                }
                $returnHtml .= '<div class="check-filter">
                                            <label>
                                                <input ' . $checked . ' type="checkbox" value="' . $row['varCity'] . '" type="checkbox" onclick=\'return updatefilter("city","' . $row['varCity'] . '")\' name="varCity[]" id="varCity' . $row['varCity'] . '" class="filled-in"  />
                                                <span>' . $row['varCity'] . '</span>
                                            </label>
                                        </div>';
                $i++;
            }
        }
        if ($i >= 5) {
            $returnHtml .= "</div>";
        }
        return $returnHtml;
    }

    public function getProductImageData($id) {
        $sql = "select * from " . DB_PREFIX . "productgallery where chrDelete='N' and chrPublish='Y' and fkProduct='" . $id . "'  order by dtCreateDate asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getProductImages($id) {
        $type = $this->input->get_post('type');
        $keyword = trim($this->input->get_post('keyword'));
        if ($keyword != '') {
            $order = " CASE WHEN p.varName LIKE '$keyword%' THEN 1 WHEN p.varName LIKE '%$keyword' THEN 3 ELSE 2 END,";
        } else {
            $order = "";
        }

        $security = $this->input->get_post('security');
        if ($security != '') {
            $where .= " and p.chrTradeSecurity='Y'";
        }
        $sample = $this->input->get_post('sample');
        if ($sample != '') {
            $where .= " and p.chrSample='Y'";
        }

//        if ($type == '1') {

        $productgallery = array();
        $sql = "select p.int_id,p.varName,a.varAlias from " . DB_PREFIX . "product as p LEFT JOIN " . DB_PREFIX . "alias as a ON p.int_id=a.fk_Record where a.fk_ModuleGlCode='140' and p.chrDelete='N' and p.chrPublish='Y' and p.intSupplier='" . $id . "' $where order by $order p.int_id asc limit 4";
//           echo $sql;exit;
        $query = $this->db->query($sql);
        $pdata = $query->result_array();
        foreach ($pdata as $pro) {
            $sqls = "select * from " . DB_PREFIX . "productgallery where chrDelete='N' and chrPublish='Y' and fkProduct='" . $pro['int_id'] . "' order by int_id asc";
            $querys = $this->db->query($sqls);
            $datas = $querys->row_array();

            $productgallery[] = array(
                'intProduct' => $pro['int_id'],
                'varAlias' => $pro['varAlias'],
                'varName' => $pro['varName'],
                'varImage' => $datas['varImage']
            );
        }
        return $productgallery;
//        }
    }

    public function getProductSearch() {
        $type = $this->input->get_post('type');
        $keywords = trim($this->input->get_post('keyword'));
        $keyword1 = explode(" ", $keywords);

        $keyword = $keyword1[0];
        if ($keywords != '') {
            $order = " CASE WHEN p.varName LIKE '$keyword%' THEN 1 WHEN p.varName LIKE '%$keyword' THEN 3 ELSE 2 END,";
        } else {
            $order = "";
        }

        $sql = "select p.int_id,p.varName from " . DB_PREFIX . "product as p where p.varName like '%" . $keyword . "%' and p.chrDelete='N' and p.chrPublish='Y' order by $order RAND(),p.int_id asc limit 3";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $pdata = $query->result_array();
        return $pdata;
    }

    public function getProductListingImageData($id) {
        $sql = "select * from " . DB_PREFIX . "productgallery where chrDelete='N' and chrPublish='Y' and fkProduct='" . $id . "'  order by int_id asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getProductImage($id) {
        $sql = "select * from " . DB_PREFIX . "productgallery where chrDelete='N' and chrPublish='Y' and fkProduct='" . $id . "'  order by int_id asc limit 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
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

        $list = $this->treerecurse1(0, '', array(), $children, 10, 0, 0);
        $display_output = array();
//        $display_output = '<select onchange="return changeCategory(this.value);" name="' . $name . '" id="' . $name . '"  size="10">';
//        $display_output .= "<option value = ''>Select Category</option>";
//        if (USERTYPE == 'N') {
//        $display_output .= "<option value = \"\" " . (($selected_id == 0) ? $dipnopar : '') . ">Select Industry Type *</option>";
//        }
        $temp1 = "";
        $temp = "";

        foreach ($list as $item) {
            if ($item['id'] == $_REQUEST['eid'] || $item['intParentCategory'] == $_REQUEST['eid']) {
//                $disabled = " disabled='disabled' ";
                $temp1 = $item['id'];
            } else if ($item['intParentCategory'] == $temp || $item['intParentCategory'] == $temp1 || $tempfk == $item['intParentCategory']) {
//                $disabled = " disabled='disabled' ";
                $temp = $item['id'];
                $tempfk = $item['intParentCategory'];
            } else {
//                $disabled = "";
            }
            $display_output[] = array(
                'id' => $item['id'],
                'treename' => $item['treename']
            );
        }
//        $display_output .= "</select>";
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
        $this->db->order_by('intDisplayOrder', 'ASD');



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

        $list = $this->treerecurse(0, '      ', array(), $children, 10, 0, 0);

        $display_output = '<select class="md-input"  data-md-selectize data-md-selectize-bottom name="' . $name . '" id="' . $name . '"  size="10">';
        $display_output .= "<option value = \"\" " . (($selected_id == 0) ? $dipnopar : '') . ">Select Product Category</option>";
        $temp1 = "";
        $temp = "";

        foreach ($list as $item) {
            if ($item['id'] == $requesteid || $item['intParentCategory'] == $_REQUEST['eid']) {
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

    function treerecurse1($id, $indent, $list = Array(), $children = Array(), $maxlevel = '10', $level = 0, $Type = 1, $Order = '') {
        $c = "";

        if ($children[$id] && $level <= $maxlevel) {
            foreach ($children[$id] as $c) {
                $id = $c['id'];

                if ($Type) {
                    $pre = '<sup></sup>';
                    $spacer = '.....';
                    $parent_order = $Order;
                } else {
                    $pre = '.....';
                    $spacer = '.....';
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
                $list = $this->treerecurse1($id, $indent . $spacer, $list, $children, $maxlevel, $level + 1, $Type, $parent_order . $Orderparent);
            }
        }
        return $list;
    }

    function getPhotosByAlbum($id = '') {
        $photoArry = array();
        $sql = "select * FROM " . DB_PREFIX . "productgallery where chrDelete='N' AND fkProduct  ='" . $id . "' order by int_id desc";
        $rs = $this->db->query($sql);
        $row = $rs->result_array();
        return $row;
    }

    function getBusinessType($dat = '') {
        $html = "";
        $data = explode(",", $dat);
        foreach ($data as $id) {
            $sql = "select varName FROM " . DB_PREFIX . "business_type where chrDelete='N' AND int_id='" . $id . "'";
            $rs = $this->db->query($sql);
            $row = $rs->row_array();
            $html .= $row['varName'] . ", ";
        }
        return $html;
    }

    function getBusinessTypeList($id = '') {
        $bussiness = $this->input->get_post('business');
        $bussiness_type = explode(",", $bussiness);
        $query = $this->db->query("select * from " . DB_PREFIX . "business_type where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $i = 0;
        foreach ($Result as $row) {
            if (in_array($row['int_id'], $bussiness_type)) {
                $checked = "checked";
            } else {
                $checked = "";
            }
            if ($i == 4) {
                $returnHtml .= '<div class="see-more-menu1">';
            }
            $returnHtml .= '<div class="check-filter">
                                            <label>
                                                <input ' . $checked . ' type="checkbox"  value="' . $row['int_id'] . '" type="checkbox" onclick=\'return updatefilter("business",' . $row['int_id'] . ')\' name="intBusinessType[]" id="intBusinessType' . $row['int_id'] . '" class="filled-in"  />
                                                <span>' . $row['varName'] . '</span>
                                            </label>
                                        </div>';
            $i++;
        }
        if ($i >= 4) {
            $returnHtml .= "</div>";
        }
        return $returnHtml;
    }

    function getPlanList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "plans where chrDelete = 'N' and chrPublish='Y' order by varPrice desc");
        $Result = $query->result_array();
        return $Result;
    }

    function getSameProductData($name = '') {
        $query = $this->db->query("select p.int_id from " . DB_PREFIX . "product as p left join " . DB_PREFIX . "users as u on u.int_id=p.intSupplier where p.varName='" . $name . "' and p.chrDelete = 'N' and p.chrPublish='Y' order by u.chrPayment desc,u.intPlan desc,u.dtCreateDate limit 10");
        $Result = $query->result_array();
        return $Result;
    }

    function getSupplierList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "users where varImage!='' and chrDelete = 'N' and chrPublish='Y' and chrPayment='Y' order by intPlan desc,RAND() limit 4");
        $Result = $query->result_array();
        return $Result;
    }

    function insert_photo() {
//        echo "here";exit;
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'productgallery WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;
        $int_displayorder = '1';
//        echo $int_displayorder;exit;
        $count = count($_FILES['varImages']['name']);
        for ($i = 0; $i < $count; $i++) {
            $sess = time();
            $pdf = basename($_FILES['varImages']['name'][$i]);
//            echo $pdf;exit;
            $photofile = preg_replace('/[^a-zA-Z0-9_ \[\]\.\(\)&-]/s', '', $pdf);
            $_FILES['varImages']['name'][$i] = $photofile;
            $image_title = basename($_FILES['varImages']['name'][$i]);
            $fileexntension = substr(strrchr($image_title, '.'), 1);
            $varName = str_replace('.' . $fileexntension, '', $image_title);
            $maindir = 'upimages/productgallery/images/';
            $var_main_file = $this->generate_image('varImages', $maindir, $i);
            $file_photo = basename($var_main_file);
            $uploadedfile = $maindir . $file_photo;
            $this->thumb_width = PRODUCTGALLERY_WIDTH;
            $this->thumb_height = PRODUCTGALLERY_HEIGHT;
            image_thumb($maindir . $var_main_file, $this->thumb_width, $this->thumb_height);
            image_thumb($maindir . $var_main_file, HOME_PRODUCTGALLERY_WIDTH, HOME_PRODUCTGALLERY_HEIGHT);
            image_thumb($maindir . $var_main_file, PRODUCTGALLERY_DETAIL_WIDTH, PRODUCTGALLERY_DETAIL_HEIGHT);
            $this->imagename = $var_main_file;
            $fk_aid = $this->input->get_post('fkProduct');
            $imgname = explode('.', $this->imagename);
            $image_name = $imgname['0'];
//            =======================================================
            $fk_aid = $this->input->get_post('fkProduct');
            $c_date = date('Y-m-d-h-i-s');
            $did = $this->input->get_post('fkProduct');
//            echo $did;exit;
            $check_album_cover = "select * from " . DB_PREFIX . "productgallery where fkProduct  = '" . $did . "' and chrDelete = 'N' and chrDefaultimage='Y'";
            $res_album_cover = $this->db->query($check_album_cover);
            $rowcount = $res_album_cover->num_rows();
//echo $rowcount;
//            exit;
            if ($rowcount <= 0) {
                $chr_cover = 'Y';
            } else {
                $chr_cover = 'N';
            }
            $data = array(
                'varName' => $varName,
                'fkProduct ' => $fk_aid,
                'varImage' => $this->imagename,
                'chrDefaultimage' => $chr_cover,
                'intDisplayOrder' => $int_displayorder,
                'dtCreateDate' => $c_date,
                'dtModifyDate' => $c_date,
            );
            $this->db->insert(DB_PREFIX . 'productgallery', $data);
        }
        return true;
    }

    function generate_image($filefield, $path = '', $i) {
//        echo "SAd";exit;
        $max_file_size = MAX_FILE_SIZE;
        $sess = time();
        $des_file_photo = basename($_FILES[$filefield]['name'][$i]);
        $des_file_photo = str_replace('&nbsp;', '-', $des_file_photo);
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

    function clear_cookies() {
        $OneYear = 365 * 24 * 3600; // one year's time.
        $this->mylibrary->requestSetCookie('cookies_search_products', "", $OneYear);
    }

    function cookiesProduct() {
        $keyword = $this->input->get_post('keyword', TRUE);
        $OneYear = 365 * 24 * 3600; // one year's time.
        $cookiesProducts = $this->mylibrary->requestGetCookie('cookies_search_products');
        $getProductss = explode(",", $cookiesProducts);
        $getProducts = array_reverse($getProductss);
        $count = count($getProducts);
        if (in_array($keyword, $getProducts)) {
            
        } else {
            if ($getProducts == '') {
                $search_keyword = $keyword;
            } else {
                $search_keyword = $cookiesProducts . "," . $keyword;
            }

            $this->mylibrary->requestSetCookie('cookies_search_products', $search_keyword, $OneYear);
        }
    }

    function delete_photo($photoID) {
        $this->db->select('varImage');
        $query = $this->db->get_where(DB_PREFIX . 'productgallery', array('int_id' => $photoID));
        $row = $query->row_array();
        if (!empty($row)) {
            $photo_thumb = $row['varImage'];
            $thumb = 'upimages/productgallery/images/' . $photo_thumb;
            unlink($thumb);
            $this->db->where('int_id', $photoID);
            $this->db->delete(DB_PREFIX . 'productgallery');
            return $photoID;
        }
        return $rs;
    }

    public function checkNameExist($product_name = '') {
        if ($product_name != '') {
            $sql = "select int_id from " . DB_PREFIX . "product_category where chrDelete='N' and varName Like '" . $product_name . "'";
            $query = $this->db->query($sql);
            $data = $query->row_array();
            return $data;
        }
    }

    public function checkUserProduct($id = '') {
        if ($id != '') {

            $login_user_session = $this->session->userdata(PREFIX);
            $session_id = SESSION_PREFIX . "UserLoginUserId";
            $user_id = $login_user_session[$session_id];

            $sql = "select int_id from " . DB_PREFIX . "product where chrDelete='N' and int_id like '" . $id . "' and intSupplier='" . $user_id . "'";
//           echo $sql;
            $query = $this->db->query($sql);
            $data = $query->num_rows();
            return $data;
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
                if ($emapData[3] != '') {
                    $category_id = $this->checkNameExist(stripslashes(quotes_to_entities($emapData[4])));
                    if ($category_id['int_id'] != '') {


                        $productname = $emapData[3];
                        $productname = strtolower($productname);
                        $productname = ucfirst($productname);
                        $productname = strip_tags($productname);
                        $productname = trim($productname);
                        $productname = trim($productname);
                        $productname = stripslashes(quotes_to_entities($productname));
                        $data = array(
                            'varName' => $emapData[3],
                            'intSupplier' => $emapData[1],
                            'intParentCategory' => $category_id['int_id'],
                            'varKeyword' => $emapData[5],
                            'varHSCode' => $emapData[6],
                            'txtDescription' => $emapData[7],
                            'chrTradeSecurity' => $emapData[8],
                            'chrFeaturesDisplay' => $emapData[9],
                            'varCurrency' => '1',
                            'varPrice' => $emapData[13],
                            'intPriceUnit' => $emapData[14],
                            'varMOQ' => $emapData[15],
                            'intMOQUnit' => $emapData[16],
                            'chrSample' => $emapData[17],
                            'varModelNo' => $emapData[18],
                            'varBrand' => $emapData[19],
                            'varMaterial' => $emapData[20],
                            'varUse' => $emapData[21],
                            'varProduction' => $emapData[22],
                            'intUnit' => $emapData[23],
                            'intTime' => $emapData[24],
                            'varPacking' => $emapData[25],
                            'varService' => $emapData[26],
                            'intPaymentType' => $emapData[27],
                            'intDeliveryTerms' => $emapData[28],
                            'intPaymentTerms' => $emapData[29],
                            'varBrochure' => $emapData[30],
                            'varMetaTitle' => $emapData[31],
                            'varMetaKeyword' => $emapData[32],
                            'varMetaDescription' => $emapData[33],
                            'chrPublish' => 'Y',
                            'intDisplayOrder' => '1',
                            'dtCreateDate' => date('Y-m-d H-i-s'),
                            'dtModifyDate' => date('Y-m-d H-i-s'),
                            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                            'PUserGlCode' => ADMIN_ID
                        );
                        $this->db->insert('product', $data);
                        $id = $this->db->insert_id();

                        $aliasname = strtolower($emapData[3]);
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
                    } else {
                        $repeated['id'] = $emapData[0];
                        $repeated['name'] = $emapData[3];
                        $repeated['cat_name'] = $emapData[4];
                        $repeated['issue'] = "Category not Found";
                        $repeated['solution'] = "Category must be as per sheet.";
                        $issuelist[] = $repeated;
                    }
                }
            }
            fclose($file);
            return $issuelist;
        }
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

        $sql = "select varName,int_id from " . DB_PREFIX . "product_category where intParentCategory='" . $id . "' and chrDelete='N' and chrPublish='Y' group by int_id order by varName asc";
        $rs = $this->db->query($sql);
        $resultdata1 = $rs->result_array($rs);
        if (count($resultdata1) > 0) {
            $html .= '<select  onchange="return getSubCategory(this.value,' . $count . ');">';
            $html .= '<option>Select Category</option>';
            foreach ($resultdata1 as $name) {
                $html .= '<option  value="' . $name['int_id'] . '">' . $name['varName'] . '</option>';
            }
            $html .= '</select>';
        }
        return $html;
    }

}

?>