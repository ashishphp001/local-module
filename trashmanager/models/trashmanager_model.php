<?php

class trashmanager_model extends CI_Model {

    var $int_id;
    var $fk_ParentPageGlCode;
    var $varTitle;
    var $varalias;
    var $text_fulltext;
    var $varMetaTitle;
    var $varMetaKeyword;
    var $varMetaDescription;
    var $intDisplayOrder;
    var $chr_access = 'P';
    var $chrPublish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dt_createdate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $chr_star;
    var $chr_read;   // (normal Attribute)
    var $oldintDisplayOrder; // Attribute of Old Displayorder
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $numofpages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'dtModifyDate'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of Pagesize For Paging
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
        $this->sortvar = '';
//        echo $this->input->get_post('view', true);exit;
        if ($this->input->get_post('view', true) == 'listing/listing?') {
            $MLSLINK = $this->input->get_post('view', true);
            $CHRAPI = $_REQUEST['chrapi'];
            $this->mlslistinglink = $MLSLISTINGLINK = $MLSLINK . '&chrapi=' . $CHRAPI;
//            echo $this->mlslistinglink;exit;
        }
    }

    function HeaderPanel() {
        $content['headerpanel'] = $this->mylibrary->generateHeaderPanel($this->generateParam(), 'no');
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
        $auto = $this->input->get_post('auto', true);
        $view = $this->input->get_post('view', true);
        $modval = $this->input->get_post('modval', true);
        if (!empty($Term)) {
            $SearchTxt = ($Type == 'autosearch') ? $Term : $SearchTxt;
        }
        $this->SearchByVal = (!empty($SearchByVal)) ? $SearchByVal : $this->SearchByVal;
        $this->SearchBy = (!empty($SearchBy)) ? urldecode($SearchBy) : '';
        $this->SearchTxt = (!empty($SearchTxt)) ? urldecode($SearchTxt) : '';
        $this->OrderBy = (!empty($OrderBy)) ? $OrderBy : $this->OrderBy;
        $this->OrderType = (!empty($OrderType)) ? $OrderType : $this->OrderType;
        $this->FilterBy = (!empty($FilterBy)) ? $FilterBy : $this->FilterBy;

        if (empty($modval)) {
            $this->modval = $modval ? $modval : '';
        }
        $this->view = ($view != '') ? $view : 'pages';

        $SearchTxt = ($type == 'autosearch' || !empty($auto)) ? $term : $SearchTxt;

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

        $this->DeletePageName = MODULE_PAGE_NAME . '/delete?';
        $this->HUrlWithPara = $this->PageName . '&' . 'hPageSize=' . $this->PageSize . '&hNumOfRows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hOrderType=' . $this->OrderType . '&hSearchBy=' . $this->SearchBy . '&hSearchTxt=' . htmlspecialchars($this->SearchTxt) . '&hPageNumber=' . $this->PageNumber . '&hFilterBy=' . $this->FilterBy . '&history=T' . '&view=' . $this->view . '&modval=' . $this->modval;
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . '&view=' . $this->view . '&modval=' . $this->modval;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&view=' . $this->view . '&modval=' . $this->modval;
        $this->UrlWithOutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&view=' . $this->view . '&modval=' . $this->modval;
        $this->UrlWithOutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&FilterBy=' . $this->FilterBy . '&view=' . $this->view . '&modval=' . $this->modval;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&view=' . $this->view . '&modval=' . $this->modval;
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal . '&view=' . $this->view . '&modval=' . $this->modval;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . '&view=' . $this->view . '&modval=' . $this->modval;
    }

    function generateParam($position = '') {

        $view = $this->input->get_post('view', true);
        // print_r($view);
//        if ($position == 'top') {
//            $modulescombo = $this->getmodulesCombo($position);
//        }
        if (!empty($view)) {
            $query_new = $this->getProModuleName($view);
            foreach ($query_new->result() as $row) {
                $mod_name = $row->varActionListing;
            }
            $heading = 'Trash Manager - ' . $mod_name;
        } else {
            $heading = 'Trash Manager - Pages';
        }
        return array
            ('PageUrl' => MODULE_PAGE_NAME,
            'heading' => $heading,
            'listImage' => 'add-new-user-icon.png',
            'tablename' => $this->tablename,
            'position' => $position,
            'actionImage' => 'add-new-button-blue.gif',
            'actionImageHover' => 'add-new-button-blue-hover.gif',
            'actionUrl' => MODULE_PAGE_NAME,
            'dispPaging' => 'Yes',
            'AutoSearchUrl' => $this->AutoSearchUrl,
            'display' => array('displayurl' => MODULE_PAGE_NAME,
                'PageSize' => $this->PageSize,
                'LimitArray' => $this->display_limit_array,
            ),
            'paging' => array('PageNumber' => $this->PageNumber,
                'NoOfPages' => $this->NoOfPages,
                'NumOfRows' => $this->NumOfRows,
                'PagingUrl' => $this->UrlWithPara
            ),
            'search' => array('searchArray' => array($searchArray),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
            'modulescombo' => $modulescombo,
        );
    }

    function selectall() {

        $view = $this->input->get_post('view', true);
//        echo $view;exit;
        $this->initialize();
        $this->Generateurl();
        if ($view == '') {
            $view = 'pages';
        } else {
            $view;
        }
        $whereclauseids = '';
        $this->tablename;
        if ($this->tablename = '') {
            $this->tablename = 'pages';
            $this->SearchBy = 'varTitle';
        }
        if ($this->input->get_post('view', true) == 'pages/contactinfo') {
            $this->tablename = DB_PREFIX . 'contactinfo';
            $this->SearchBy = 'varTitle';
        } else if ($this->input->get_post('view', true) == 'contactusleads') {
            $this->tablename = DB_PREFIX . 'contactusleads';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'newsletterleads') {
            $this->tablename = DB_PREFIX . 'newsletterleads';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'banner') {
            $this->tablename = DB_PREFIX . 'banner';
            $this->SearchBy = 'varTitle';
        } else if ($this->input->get_post('view', true) == 'emails') {
            $this->tablename = DB_PREFIX . 'emails';
            $this->SearchBy = 'varFrom';
        } else if ($this->input->get_post('view', true) == 'testimonial') {
            $this->tablename = DB_PREFIX . 'testimonial';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'careers') {
            $this->tablename = DB_PREFIX . 'careers';
            $this->SearchBy = 'varTitle';
        } else if ($this->input->get_post('view', true) == 'employees') {
            $this->tablename = DB_PREFIX . 'users';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'employers') {
            $whereclauseids .= " and chrType='ER'";
            $this->tablename = DB_PREFIX . 'users';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'faqs') {
            $this->tablename = DB_PREFIX . 'faqs';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'commonfiles') {
            $this->tablename = DB_PREFIX . 'commonfiles';
            $this->SearchBy = 'varTitle';
        } else if ($this->input->get_post('view', true) == 'delivery_terms') {
            $this->tablename = DB_PREFIX . 'delivery_terms';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'features') {
            $this->tablename = DB_PREFIX . 'features';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'blogs') {
            $this->tablename = DB_PREFIX . 'blogs';
            $this->SearchBy = 'varTitle';
        } else if ($this->input->get_post('view', true) == 'buyer_seller') {
            $whereclauseids .= " and chrType='BS'";
            $this->tablename = DB_PREFIX . 'users';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'plans') {
            $this->tablename = DB_PREFIX . 'plans';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'payment_terms') {
            $this->tablename = DB_PREFIX . 'payment_terms';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'payment_types') {
            $this->tablename = DB_PREFIX . 'payment_types';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'inspection') {
            $whereclauseids .= " and chrType='I'";
            $this->tablename = DB_PREFIX . 'users';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'product') {
            $this->tablename = DB_PREFIX . 'product';
            $this->SearchBy = 'varTitle';
        } else if ($this->input->get_post('view', true) == 'product_category') {
            $this->tablename = DB_PREFIX . 'product_category';
            $this->SearchBy = 'varTitle';
        } else if ($this->input->get_post('view', true) == 'unit_master') {
            $this->tablename = DB_PREFIX . 'unit_master';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'sticky_notes') {
            $this->tablename = DB_PREFIX . 'sticky_notes';
            $this->SearchBy = 'title';
        } else if ($this->input->get_post('view', true) == 'logistic') {
            $whereclauseids .= " and chrType='L'";
            $this->tablename = DB_PREFIX . 'users';
            $this->SearchBy = 'varName';
        } else if ($this->input->get_post('view', true) == 'event') {
            $this->tablename = DB_PREFIX . 'event';
            $this->SearchBy = 'varTitle';
        } else {
            $this->tablename = DB_PREFIX . 'pages';
            $this->SearchBy = 'varTitle';
        }







        $type = $this->input->get_post('Type', true);

        if ($type == 'autosearch') {

            $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by int_id';
            $SearchByVal = " like '%" . $this->db->escape_like_str($this->SearchTxt) . "%'  and chrDelete = 'Y'";
            $autoSearchQry = $this->db->query("select *,{$this->SearchBy} as AutoVal FROM {$this->tablename} where {$this->SearchBy} $SearchByVal $whereclauseids group by  $this->SearchBy $OrderBy");

            $this->mylibrary->GetAutoSearch($autoSearchQry);
        }

        $OrderBy = 'order by ' . $this->OrderBy . ' ' . $this->OrderType;

        $sql_trash = "select {$this->tablename}.*,p.varName as Username,DATE_FORMAT({$this->tablename}.dtModifyDate, '" . DEFAULT_TIMEFORMAT . "') as Time from {$this->tablename} 
         LEFT JOIN " . DB_PREFIX . "adminpanelusers p on {$this->tablename}.PUserGlCode = p.int_id    
        where {$this->tablename}.chrDelete = 'Y' $whereclauseids $OrderBy";
//        echo $sql_trash;exit;
        $query = $this->db->query($sql_trash);

        return $query;
    }

    function CountRows() {

        $view = $this->input->get_post('view', true);
        $whereclauseids = '';
        if (!empty($view)) {
            if ($this->input->get_post('view', true) == 'pages/contactinfo') {
                $this->tablename = DB_PREFIX . 'pages';
                $this->SearchBy = 'varTitle';
            } else if ($this->input->get_post('view', true) == 'contactusleads') {
                $this->tablename = DB_PREFIX . 'contactusleads';
                $this->SearchBy = "varName";
            } else if ($this->input->get_post('view', true) == 'newsletterleads') {
                $this->tablename = DB_PREFIX . 'newsletterleads';
                $this->SearchBy = "varName";
            } else if ($this->input->get_post('view', true) == 'payment_types') {
                $this->tablename = DB_PREFIX . 'payment_types';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'testimonial') {
                $this->tablename = DB_PREFIX . 'testimonial';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'unit_master') {
                $this->tablename = DB_PREFIX . 'unit_master';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'coursescategory') {
                $this->tablename = DB_PREFIX . 'coursescategory';
                $this->SearchBy = 'varTitle';
            } else if ($this->input->get_post('view', true) == 'product_category') {
                $this->tablename = DB_PREFIX . 'product_category';
                $this->SearchBy = 'varTitle';
            } else if ($this->input->get_post('view', true) == 'payment_terms') {
                $this->tablename = DB_PREFIX . 'payment_terms';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'inspection') {
                $whereclauseids .= " and chrType='I'";
                $this->tablename = DB_PREFIX . 'users';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'logistic') {
                $whereclauseids .= " and chrType='L'";
                $this->tablename = DB_PREFIX . 'users';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'sticky_notes') {
                $this->tablename = DB_PREFIX . 'sticky_notes';
                $this->SearchBy = 'title';
            } else if ($this->input->get_post('view', true) == 'buyer_seller') {
                $this->tablename = DB_PREFIX . 'users';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'employers') {
                $this->tablename = DB_PREFIX . 'users';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'faqs') {
                $this->tablename = DB_PREFIX . 'faqs';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'features') {
                $this->tablename = DB_PREFIX . 'features';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'plans') {
                $this->tablename = DB_PREFIX . 'plans';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'employees') {
                $this->tablename = DB_PREFIX . 'users';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'commonfiles') {
                $this->tablename = DB_PREFIX . 'commonfiles';
                $this->SearchBy = 'varTitle';
            } else if ($this->input->get_post('view', true) == 'delivery_terms') {
                $this->tablename = DB_PREFIX . 'delivery_terms';
                $this->SearchBy = 'varName';
            } else if ($this->input->get_post('view', true) == 'banner') {
                $this->tablename = DB_PREFIX . 'banner';
                $this->SearchBy = 'varTitle';
            } else if ($this->input->get_post('view', true) == 'emails') {
                $this->tablename = DB_PREFIX . 'emails';
                $this->SearchBy = 'varFrom';
            } else if ($this->input->get_post('view', true) == 'blogs') {
                $this->tablename = DB_PREFIX . 'blogs';
                $this->SearchBy = 'varTitle';
            } else if ($this->input->get_post('view', true) == 'product') {
                $this->tablename = DB_PREFIX . 'product';
                $this->SearchBy = 'varTitle';
            } else if ($this->input->get_post('view', true) == 'careers') {
                $this->tablename = DB_PREFIX . 'careers';
                $this->SearchBy = 'varTitle';
            } else if ($this->input->get_post('view', true) == 'event') {
                $this->tablename = DB_PREFIX . 'event';
                $this->SearchBy = 'varTitle';
            } else {
                $this->tablename = DB_PREFIX . 'pages';
                $this->SearchBy = 'varTitle';
            }
        } else {
            $this->tablename = DB_PREFIX . 'pages';
        }



        $sqlCountPages = "select * FROM {$this->tablename} where chrDelete='Y' $whereclauseids";
        $res = $this->db->query($sqlCountPages);
        $rs = $res->num_rows();
        return $rs;
    }

    function delete_row() {

        $tablename = $this->input->get_post('tablename', true);
        $deleteids = $this->input->get_post('dids', true);
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
        $view = $this->input->get_post('view', true);

//        echo $view; exit;


        if ($view != '') {
            $view = $view;
        } else {
            $view = 'pages';
        }
        $sqldata = "select int_id from " . DB_PREFIX . "modules where varTitle='" . $view . "'";
        $query = $this->db->query($sqldata);
        $result = $query->row();
        $MODULE_ID = $result->int_id;






        for ($i = 0; $i < $totaldeletedrecords; $i++) {

            $aliasdata = "select int_id from " . DB_PREFIX . "alias where fk_ModuleGlCode='" . $MODULE_ID . "' and fk_Record='" . $deletearray[$i] . "'";
            $aliasquery = $this->db->query($aliasdata);
            foreach ($aliasquery->result() as $value) {
                $this->db->where('int_id', $value->int_id);
                $this->db->delete('alias');
            }




            $sql = "delete from " . $tablename . " where int_id='$deletearray[$i]' $whereclauseids ";
            $this->db->query($sql);
        }
    }

    /*     * ************************** RESTORE MODULE DATA ************************* */

    function paernt_pagerestore($id = '') {
        $this->db->select("int_id,fk_ParentPageGlCode ,varTitle", FALSE);
        $this->db->from("Pages");
        $this->db->where("chrDelete", 'Y');
        $this->db->where("int_id", $id);
        $query = $this->db->get();
        $rs = $query->row_array();
        return $rs;
    }

    function restore() {

        $view_request = $this->input->get_post('view');

        if (!empty($view_request)) {
            $tablename = $this->input->get_post('tablename');
            $restoreids = $this->input->get_post('rids');
            $restorearray = explode(',', $restoreids);
            $totalrestorerecords = count($restorearray);



            for ($i = 0; $i < $totalrestorerecords; $i++) {
                $sql = "Update " . $tablename . " set chrDelete='N' where int_id='$restorearray[$i]'";
                $this->db->query($sql);
//                  echo $tablename; die;
                if (($tablename != DB_PREFIX . 'pages') && ($tablename != DB_PREFIX . 'emails') && ($tablename != DB_PREFIX . 'sticky_notes')) { //condition for modules whose tables doesnot have int_displayorder field.                   
                    $this->mylibrary->set_Int_DisplayOrder_sequence($tablename, '', '');
                }
            }
        }
    }

    /*     * *************************** GENERATE MODULE COMBO********************** */

    function getmodulesCombos() {
        $view = $this->input->get_post('view', true);
        if (!empty($_REQUEST)) {
            if ($view == '') {
                $view = 'pages';
            } else {
                $view = $view;
            }
        } else {
            $view = 'pages';
        }
        $type = "MT";
        if ($this->session->userdata('userid') == '2') {
            $show_in_trashmanager = " and chrAdminPanel='Y'";
        } else {
            $show_in_trashmanager = '';
        }
        if ($this->fk_Country != '') {
            $whereclauseids .= " AND FIND_IN_SET('$this->fk_Country', fk_CountryGlCode)";
        }
        if ($this->fk_Website != '') {
            $whereclauseids .= " AND FIND_IN_SET('$this->fk_Website', fk_SiteGlCode)";
        }
        $module = "select * from " . DB_PREFIX . "modules where chrDelete='N' and chrPublish='Y' and chrDisplayTrash='Y' $show_in_trashmanager $whereclauseids order by varTitle asc";
        $rs1 = $this->db->query($module);
        //  echo $this->db->last_query();

        $display = "<div class=\"new-search-show-all\">";
        $display .= "<select id=\"cmbmodulestop\" name=\"cmbmodulestop\" onchange=\"newSendGridBindRequesta() \" class=\"md-input\">";
        foreach ($rs1->result() as $row) {
            if ($row->varTitle == 'productcategory') {
                $modulename = 'Product Category';
            } else {
                $modulename = $row->varModuleName;
            }
            $p = ($row->varTitle == $view) ? 'selected' : '';
            $display .= "<option value=" . $row->varTitle . " " . $p . ">" . $modulename . "</option>";
        }
        $display .= "</select></div>";
        return $display;
    }

    function getProModuleName($name) {
        $sql = "select varActionListing from " . DB_PREFIX . "adminpanelmenus where varTitle = '$name'";
        $records = $this->db->query($sql);
        return $records;
    }

    function DeletAllTrashRecords() {

        $NotINAaary = array('1', '19');
        $this->db->select('varTableName,int_id');
        $this->db->from("modules");
        $this->db->where_not_in("int_id", $NotINAaary);
        $SQL = $this->db->get();
        $TableArray = $SQL->result_array();
        foreach ($TableArray as $TableName) {
            if (!empty($TableName['varTableName'])) {

                /* For the ALias Delete */
                $this->db->select("GROUP_CONCAT(distinct int_id) as RecordIds");
                $this->db->from($TableName['varTableName']);
                $this->db->where(array("chrDelete" => "Y"));
                $Row = $this->db->get();
                $Result = $Row->row();
                $this->db->last_query();
                if (!empty($Result->RecordIds)) {
                    $IdsArray = explode(",", $Result->RecordIds);
                    $this->db->where_in('fk_Record', $IdsArray);
                    $this->db->delete("alias", array("fk_ModuleGlCode" => $TableName['int_id']));
                }
                /* alias Delete End */
                $this->db->delete($TableName['varTableName'], array("chrDelete" => "Y"));
                echo $this->db->last_query() . "<br/>";
            }
        }
        die;
    }

}

?>
