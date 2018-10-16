<?php

class buyer_seller_model extends CI_Model {

    var $int_id;
    var $varName;
    var $chr_publish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dt_createdate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $numofpages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'P.int_id'; // Attribute of Deafult Order By
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
        $types = $this->input->get_post('types');
        if (!empty($Term)) {
            $SearchTxt = ($Type == 'autosearch') ? $Term : $SearchTxt;
        }
        $this->SearchByVal = (!empty($SearchByVal)) ? $SearchByVal : $this->SearchByVal;
        $this->SearchBy = (!empty($SearchBy)) ? urldecode($SearchBy) : '';
        $this->SearchTxt = (!empty($SearchTxt)) ? urldecode($SearchTxt) : '';
        $this->OrderBy = (!empty($OrderBy)) ? $OrderBy : $this->OrderBy;
        $this->OrderType = (!empty($OrderType)) ? $OrderType : $this->OrderType;
        $this->FilterBy = (!empty($FilterBy)) ? $FilterBy : $this->FilterBy;
        $this->types = (!empty($types)) ? $types : $this->types;
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
        $types = "&types=" . $this->types;
        $this->HUrlWithPara = $this->PageName . '&' . 'hPageSize=' . $this->PageSize . '&hNumOfRows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hOrderType=' . $this->OrderType . '&hSearchBy=' . $this->SearchBy . '&hSearchTxt=' . urlencode($this->SearchTxt) . '&hPageNumber=' . $this->PageNumber . '&hFilterBy=' . $this->FilterBy . '&history=T' . $types;
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . $types;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . $types;
        $this->UrlWithOutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . $types;
        $this->UrlWithOutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&FilterBy=' . $this->FilterBy . $types;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . $types;
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal . $types;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . $types;
        if ($flag == 'Y') {
            return $this;
        }
    }

    function generateParam($position = 'top') {
        $PageSize = $this->PageSize;
        return array(
            'pageurl' => MODULE_PAGE_NAME . '?',
            'heading' => 'Manage Team Members',
            'listImage' => 'add-new-users-icon.png',
            'tablename' => DB_PREFIX . 'users',
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
            'search' => array('searchArray' => array("varName" => "Name"),
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
        if ($this->types == 'f') {
            $whereclauseids .= " and chrPayment ='N' ";
        } else {
            $whereclauseids .= " and chrPayment ='Y' ";
        }
//        $whereclauseids = " chrDelete ='N' ";
        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes($this->SearchTxt) . "%' or varCompany like '%" . addslashes($this->SearchTxt) . "%' or varEmail like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%' or varEmail like '%" . addslashes($this->SearchTxt) . "%'";
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
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by int_id desc';
                $autoSearchQry = $this->db->query("select *,{$this->SearchByVal} as AutoVal  FROM " . DB_PREFIX . "users where $whereclauseids group by int_id order by int_id desc");
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }
        $whereclause .= (empty($this->SearchBy)) ? " AND (varCompany like '%" . addslashes($this->SearchTxt) . "%' or P.varName like '%" . addslashes($this->SearchTxt) . "%' or P.varEmail like '%" . addslashes($this->SearchTxt) . "%')" : " AND (P.$this->SearchBy like '%" . addslashes($this->SearchTxt) . "%' or P.varCompany like '%" . addslashes($this->SearchTxt) . "%' or P.varEmail like '%" . addslashes($this->SearchTxt) . "%') AND P.chrDelete='N'";
        $this->db->select('P.int_id,P.varName,P.*,M.varName as varPlan,U.varName as varPaymentBy', false);
        $this->db->from('users as P', false);
        $this->db->join('plans AS M', 'M.int_id = P.intPlan', 'left', false);
        $this->db->join('adminpanelusers AS U', 'U.int_id = P.intPaymentUser', 'left', false);
        if ($this->types == 'f') {
            $wheres = " and P.chrPayment ='N' ";
        } else {
            $wheres = " and P.chrPayment ='Y' ";
        }
        $this->db->where("P.chrDelete = 'N' and P.chrType='BS' $wheres $whereclause", NULL, FALSE);
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
        if ($_GET['type'] == 'f') {
            $wheres = " and chrPayment ='N' ";
        } else {
            $wheres = " and chrPayment ='Y' ";
        }
        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND (varCompany like '%" . addslashes($this->SearchTxt) . "%' or varName like '%" . addslashes($this->SearchTxt) . "%' or varEmail like '%" . addslashes($this->SearchTxt) . "%') " : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }
        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('users');
        return $rs;
    }

    function getUserProfiles($id) {
        $returnArry = array();
        $wherecondtion = array('u.chrDelete' => 'N', 'u.int_id' => $id);
        $this->db->select('u.*,u.varEmail as UserEmail,d.varName as DesignationName,ci.varTelephone, ci.*,p.varName as varPlanName,ci.varLocation as varCLocation', false);
        $this->db->from('users As u');
        $this->db->join('company_information AS ci', 'u.int_id = ci.intUser', 'left', false);
        $this->db->join('plans AS p', 'p.int_id = u.intPlan', 'left', false);
        $this->db->join('designation AS d', 'd.int_id = ci.intDesignation', 'left', false);
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Select_Rows($id) {
        $returnArry = array();
        $wherecondtion = array('P.chrDelete' => 'N', 'P.int_id' => $id);
        $this->db->select('P.*,a.varAlias', false);
        $this->db->from('users As P');
        $this->db->join('alias AS a', 'P.int_id = a.fk_Record AND a.fk_ModuleGlCode=' . MODULE_ID, 'left');
        $this->db->where($wherecondtion);
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $returnArry = $result->row_array();
        }
        return $returnArry;
    }

    function Insert($Files_Name = '') {
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'users WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/users/images/';
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
        $crypted_password = $this->mylibrary->cryptPass($this->input->post('varPassword', true));

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_buyer_seller();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'varPassword' => $crypted_password,
            'varOriginalPassword' => $this->input->post('varPassword', true),
            'varEmail' => $this->input->post('varEmail', TRUE),
            'varCompany' => $this->input->post('varCompany', TRUE),
            'varPhone' => $this->input->post('varPhone', TRUE),
            'varLocation' => $this->input->post('varLocation', TRUE),
            'varAddress1' => $this->input->post('varAddress1', TRUE),
//            'varAddress2' => $this->input->post('varAddress2', TRUE),
            'varLatitude' => $this->input->post('varLatitude', TRUE),
            'varLongitude' => $this->input->post('varLongitude', TRUE),
            'varCity' => $this->input->post('varCity', TRUE),
            'varState' => $this->input->post('varState', TRUE),
            'varZipcode' => $this->input->post('varZipcode', TRUE),
            'varCountry' => $this->input->post('varCountry', TRUE),
            'varImage' => $Imagesurl,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'chrDelete' => 'N',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
        $this->db->insert('users', $data);
        $id = $this->db->insert_id();
        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $id, 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Insert_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'users', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $id;
    }

    function add_company_certificate() {
        if ($_FILES['varCertificateImage']['name'] != '') {
            $config['upload_path'] = 'upimages/company/certificate/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varCertificateImage']['name'];
            $Certi_Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $Certi_Imagesurl = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varCertificateImage')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $Certi_Imagesurl = $this->input->post('hidd_company_certi', true);
        }

//        if ($_FILES['varTrademarkImage']['name'] != '') {
//            $config['upload_path'] = 'upimages/company/certificate/';
//            $config['allowed_types'] = 'gif|jpg|jpeg|png';
//            $config['max_size'] = '1000000';
//            $this->ImageName = $_FILES['varTrademarkImage']['name'];
//            $trade_Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
//            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
//            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
//            $trade_Imagesurl = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
//            $config['file_name'] = $this->ImageName;
//            $this->load->library('upload', $config);
//            $this->upload->initialize($config);
//            $this->upload->initialize($config);
//            if (!$this->upload->do_upload('varTrademarkImage')) {
//                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
//                echo $this->upload->display_errors();
//                exit;
//            }
//        } else {
//            $trade_Imagesurl = $this->input->post('hidd_company_trade_certi', true);
//        }
//        $login_user_session = $this->session->userdata(PREFIX);
//        $session_id = SESSION_PREFIX . "UserLoginUserId";
//        $user_id = $login_user_session[$session_id];

        $user_id = $this->input->post('intUser', true);
        $datas = array(
            'intUser' => $user_id,
            'varCertificateName' => $this->input->post('varCertificateName', true),
            'varCertificateRegistration' => $this->input->post('varCertificateRegistration', TRUE),
            'varCertificateIssue' => $this->input->post('varCertificateIssue', TRUE),
            'varCertificateStatus' => $this->input->post('varCertificateStatus', TRUE),
            'varCertificateIssueDate' => date("Y-m-d", strtotime($this->input->post('varCertificateIssueDate', TRUE))),
            'varCertificateExpiryDate' => date("Y-m-d", strtotime($this->input->post('varCertificateExpiryDate', TRUE))),
            'txtPersonalDetails' => nl2br($this->input->post('txtPersonalDetails', TRUE)),
//            'varTrademarkImage' => $trade_Imagesurl,
//            'varTrademarkName' => $this->input->post('varTrademarkName', TRUE),
//            'varRegistrationNo' => $this->input->post('varRegistrationNo', TRUE),
//            'varTrademarkStatus' => $this->input->post('varTrademarkStatus', TRUE),
//            'varTrademarkIssueDate' => date("Y-m-d", strtotime($this->input->post('varTrademarkIssueDate', TRUE))),
//            'varTrademarkExpiryDate' => date("Y-m-d", strtotime($this->input->post('varTrademarkExpiryDate', TRUE))),
//            'txtGoodsDescription' => nl2br($this->input->post('txtGoodsDescription', TRUE)),
//            'varClass' => $this->input->post('varClass', TRUE)
        );


        if ($Certi_Imagesurl != '') {
            $datas['varCertificateImage'] = $Certi_Imagesurl;
        }

        if ($this->input->post('intCertificate', TRUE) == '') {
            $this->db->insert('company_certificate', $datas);
            $id = $this->db->insert_id();
        } else {
            $this->db->where('int_id', $this->input->post('intCertificate'));
            $this->db->update('company_certificate', $datas);
            $id = $this->input->post('intCertificate');
        }
        return $user_id;
    }

    function add_company_trademark() {


        if ($_FILES['varTrademarkImage']['name'] != '') {
            $config['upload_path'] = 'upimages/company/certificate/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varTrademarkImage']['name'];
            $trade_Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $trade_Imagesurl = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varTrademarkImage')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $trade_Imagesurl = $this->input->post('hidd_company_trade_certi', true);
        }

        $user_id = $this->input->post('intTUser', true);
        $datas = array(
            'intUser' => $user_id,
            'varTrademarkName' => $this->input->post('varTrademarkName', TRUE),
            'varRegistrationNo' => $this->input->post('varRegistrationNo', TRUE),
            'varTrademarkStatus' => $this->input->post('varTrademarkStatus', TRUE),
            'varTrademarkIssueDate' => date("Y-m-d", strtotime($this->input->post('varTrademarkIssueDate', TRUE))),
            'varTrademarkExpiryDate' => date("Y-m-d", strtotime($this->input->post('varTrademarkExpiryDate', TRUE))),
            'txtGoodsDescription' => nl2br($this->input->post('txtGoodsDescription', TRUE)),
            'varClass' => $this->input->post('varClass', TRUE)
        );


        if ($trade_Imagesurl != '') {
            $datas['varTrademarkImage'] = $trade_Imagesurl;
        }

        if ($this->input->post('intTrademark', TRUE) == '') {
            $this->db->insert('company_trademark', $datas);
            $id = $this->db->insert_id();
        } else {
            $this->db->where('int_id', $this->input->post('intTrademark'));
            $this->db->update('company_trademark', $datas);
            $id = $this->input->post('intTrademark');
        }
        return $user_id;
    }

    function add_partner() {
        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/member/images/';
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
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varImage')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $Imagesurl = "";
        }

        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'intUser' => $this->input->post('intUser', true),
            'varEmail' => $this->input->post('varEmail', TRUE),
            'intDesignation' => $this->input->post('intDesignation', TRUE),
            'varPhone' => $this->input->post('varPhone', TRUE),
            'txtDescription' => $this->input->post('txtDescription', TRUE),
            'varBlog' => $this->input->post('varBlog', TRUE),
            'varAdharNumber' => $this->input->post('varAdharNumber', TRUE),
            'varLocation' => $this->input->post('varLocation', TRUE),
            'varStreetAddress1' => $this->input->post('varStreetAddress1', TRUE),
//            'varStreetAddress2' => $this->input->post('varStreetAddress2', TRUE),
            'varLatitude' => $this->input->post('varLatitude', TRUE),
            'varLongitude' => $this->input->post('varLongitude', TRUE),
            'varCity' => $this->input->post('varCity', TRUE),
            'varState' => $this->input->post('varState', TRUE),
            'varPincode' => $this->input->post('varPincode', TRUE),
            'varCountry' => $this->input->post('varCountry', TRUE),
            'chrPublish' => 'Y',
            'chrDelete' => 'N',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
        if ($Imagesurl != '') {
            $data['varImage'] = $Imagesurl;
        }

        if ($this->input->post('intPartner', TRUE) == '') {
            $this->db->insert('company_members', $data);
            $id = $this->db->insert_id();
        } else {
            $this->db->where('int_id', $this->input->post('intPartner'));
            $this->db->update('company_members', $data);
            $id = $this->input->post('intPartner');
        }



        return $id;
    }

    function addfeedback() {

        $data = array(
            'intRating' => $this->input->post('rating', TRUE),
            'intSupplier' => $this->input->post('intSupplier', true),
            'txtComment' => nl2br($this->input->post('txtComment', TRUE)),
            'intWebsite' => $this->input->post('intWebsite', TRUE),
            'chrPublish' => 'Y',
            'chrDelete' => 'N',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );

//        print_R($data);exit;
        $this->db->insert('rating_supplier', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function addcontact() {

        $data = array(
            'intWebsite' => $this->input->post('intWebsite', TRUE),
            'varName' => $this->input->post('varContactName', TRUE),
            'varEmail' => $this->input->post('varContactEmail', true),
            'varPhone' => $this->input->post('varContactPhone', TRUE),
            'txtMessage' => nl2br($this->input->post('txtContactMsg', TRUE)),
            'chrPublish' => 'Y',
            'chrDelete' => 'N',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );

//        print_R($data);exit;
        $this->db->insert('contact_supplier', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function add_companyinfo() {

        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];


        if ($_FILES['varCompanyLogo']['name'] != '') {
            $config['upload_path'] = 'upimages/users/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varCompanyLogo']['name'];
            $company_url = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $company_url = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varCompanyLogo')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $company_url = $this->input->post('hidd_company_logo', true);
        }

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
            $uploads_dir = 'upimages/company/brochure';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
        } else {
            $Filesurl = $this->input->post('hidd_varBrochure', true);
        }

        if ($_FILES['varVisitingCardFront']['name'] != '') {
            $config['upload_path'] = 'upimages/company/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varVisitingCardFront']['name'];
            $visiting_card_front_url = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $visiting_card_front_url = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varVisitingCardFront')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $visiting_card_front_url = $this->input->post('hidd_visiting_front', true);
        }

        if ($_FILES['varVisitingCardBack']['name'] != '') {
            $config['upload_path'] = 'upimages/company/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['varVisitingCardBack']['name'];
            $visiting_card_back_url = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $visiting_card_back_url = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('varVisitingCardBack')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $visiting_card_back_url = $this->input->post('hidd_visiting_back', true);
        }
        $business_type = $this->input->post('varBusinessType');
        if ($business_type != '') {
            $business_type = implode(",", $business_type);
        } else {
            $business_type = "";
        }


        $addemobcount = $this->input->post('addemobcount', TRUE);

        for ($j = 0; $j <= $addemobcount; $j++) {
            if ($this->input->get_post('varCompanyEmail' . $j, true) != '') {
                $varCompanyEmails[] = strip_tags($this->input->get_post('varCompanyEmail' . $j, true));
                $intCountryCodes[] = strip_tags($this->input->get_post('intCountryCode' . $j, true));
                $varCompanyPhones[] = strip_tags($this->input->get_post('varCompanyPhone' . $j, true));
            }
        }
//        print_R($varCompanyEmails);exit;
        if (empty($varCompanyEmails)) {
            $varCompanyEmail = "";
        } else {
            $varCompanyEmail = implode("__", $varCompanyEmails);
        }
        if (empty($intCountryCodes)) {
            $intCountryCode = "";
        } else {
            $intCountryCode = implode("__", $intCountryCodes);
        }
        if (empty($varCompanyPhones)) {
            $varCompanyPhone = "";
        } else {
            $varCompanyPhone = implode("__", $varCompanyPhones);
        }

        $taxationcount = $this->input->post('taxationcount', TRUE);

        for ($i = 1; $i <= $taxationcount; $i++) {
            if ($this->input->get_post('varTaxation' . $i, true) != '') {
                $varTaxation[] = strip_tags($this->input->get_post('varTaxation' . $i, true));
                $varTaxationAns[] = strip_tags($this->input->get_post('varTaxationAns' . $i, true));
            }
        }
        $varTax = implode("__", $varTaxation);
        $varTaxAns = implode("__", $varTaxationAns);

        if (empty($varTaxation)) {
            $varTax = "";
        }
        if (empty($varTaxationAns)) {
            $varTaxAns = "";
        }

        $data = array(
            'intUser' => $user_id,
            'varCompany' => $this->input->post('varCompany', true),
            'varCompanyAdv' => nl2br($this->input->post('varCompanyAdv', TRUE)),
            'varCompanyInfo' => nl2br($this->input->post('varCompanyInfo', TRUE)),
            'varTotalEmployees' => $this->input->post('varTotalEmployees', TRUE),
            'varQCStaff' => $this->input->post('varQCStaff', TRUE),
            'varRDStaff' => $this->input->post('varRDStaff', TRUE),
            'varProductionLine' => $this->input->post('varProductionLine', TRUE),
            'varWebsite' => $this->input->post('varWebsite', TRUE),
            'varCompanyEmail' => $this->input->post('varCompanyEmail', TRUE),
            'varRegistration' => $this->input->post('varRegistration', TRUE),
            'varCompanyPhone' => $this->input->post('varCompanyPhone', TRUE),
            'varCompanyMultiEmails' => $varCompanyEmail,
            'intCountryMultiCode' => $intCountryCode,
            'varCompanyMultiPhone' => $varCompanyPhone,
            'varTelephone' => $this->input->post('varTelephone', TRUE),
            'varTotalEmp' => $this->input->post('varTotalEmp', TRUE),
            'varOwnerType' => $this->input->post('varOwnerType', TRUE),
            'varCurrency' => $this->input->post('varCurrency', TRUE),
            'varAnnualTurnover' => $this->input->post('varAnnualTurnover', TRUE),
            'varBusinessType' => $business_type,
            'varLocation' => nl2br($this->input->post('varLocation', TRUE)),
            'varAddress1' => $this->input->post('varAddress1', TRUE),
//            'varAddress2' => $this->input->post('varAddress2', TRUE),
            'varCity' => $this->input->post('varCity', TRUE),
            'varState' => $this->input->post('varState', TRUE),
            'varCountry' => $this->input->post('varCountry', TRUE),
            'varPostCode' => $this->input->post('varPostCode', TRUE),
            'varLatitude' => $this->input->post('varLatitude', TRUE),
            'varLongitude' => $this->input->post('varLongitude', TRUE),
            'varFLocation' => $this->input->post('varFLocation', TRUE),
            'varFAddress1' => $this->input->post('varFAddress1', TRUE),
            'varFAddress2' => $this->input->post('varFAddress2', TRUE),
            'varFCity' => $this->input->post('varFCity', TRUE),
            'varFState' => $this->input->post('varFState', TRUE),
            'varFCountry' => $this->input->post('varFCountry', TRUE),
            'varFPostCode' => $this->input->post('varFPostCode', TRUE),
            'varFLatitude' => $this->input->post('varFLatitude', TRUE),
            'varFLongitude' => $this->input->post('varFLongitude', TRUE),
            'varBranchCompanyName' => $this->input->post('varBranchCompanyName', TRUE),
            'varBranchPersonName' => $this->input->post('varBranchPersonName', TRUE),
            'varBranchLocation' => $this->input->post('varBranchLocation', TRUE),
            'varBranchAddress' => $this->input->post('varBranchAddress', TRUE),
            'varBranchCity' => $this->input->post('varBranchCity', TRUE),
            'varBranchPostCode' => $this->input->post('varBranchPostCode', TRUE),
            'varBranchLatitude' => $this->input->post('varBranchLatitude', TRUE),
            'varBranchLongitude' => $this->input->post('varBranchLongitude', TRUE),
            'varBranchLocationEmail' => $this->input->post('varBranchLocationEmail', TRUE),
            'varBranchLocationPhone' => $this->input->post('varBranchLocationPhone', TRUE),
            'varBranchLocationTel' => $this->input->post('varBranchLocationTel', TRUE),
            'intDesignation' => $this->input->post('intDesignation', TRUE),
            'chrBranchFranchise' => $this->input->post('chrBranchFranchise', TRUE),
            'varBrochure' => $Filesurl,
            'varCompanyLogo' => $company_url,
            'varVisitingCardFront' => $visiting_card_front_url,
            'varVisitingCardBack' => $visiting_card_back_url,
            'varIndiaMarkets' => $this->input->post('varIndiaMarkets', TRUE),
            'varAsiaMarkets' => $this->input->post('varAsiaMarkets', TRUE),
            'varEuropeMarkets' => $this->input->post('varEuropeMarkets', TRUE),
            'varAfricaMarkets' => $this->input->post('varAfricaMarkets', TRUE),
            'varMiddleEastMarkets' => $this->input->post('varMiddleEastMarkets', TRUE),
            'varNorthAmericaMarkets' => $this->input->post('varNorthAmericaMarkets', TRUE),
            'varSouthAmericaMarkets' => $this->input->post('varSouthAmericaMarkets', TRUE),
            'varAustraliaMarkets' => $this->input->post('varAustraliaMarkets', TRUE),
            'varNewZealandMarkets' => $this->input->post('varNewZealandMarkets', TRUE),
            'varFacebook' => $this->input->post('varFacebook', TRUE),
            'varLinkedIn' => $this->input->post('varLinkedIn', TRUE),
            'varTwitter' => $this->input->post('varTwitter', TRUE),
            'varGoogle' => $this->input->post('varGoogle', TRUE),
            'varGST' => $this->input->post('varGST', TRUE),
            'varPanNo' => $this->input->post('varPanNo', TRUE),
            'varUdyogAadhaarNo' => $this->input->post('varUdyogAadhaarNo', TRUE),
            'varIECCode' => $this->input->post('varIECCode', TRUE),
            'varCINNo' => $this->input->post('varCINNo', TRUE),
            'varSSINo' => $this->input->post('varSSINo', TRUE),
            'varTANNo' => $this->input->post('varTANNo', TRUE),
            'varTaxFields' => $varTax,
            'varTaxAns' => $varTaxAns,
            'chrPublish' => 'Y',
            'chrDelete' => 'N',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
//        echo "<pre>";
//        print_R($data);
//        exit;

        $com_data = $this->getCompanyData($user_id);
        if ($com_data['varCompany'] != '') {
            $this->db->where('intUser', $user_id);
            $this->db->update('company_information', $data);

            $data1 = array(
                'varImage' => $company_url
            );
            $this->db->where('int_id', $user_id);
            $this->db->update('users', $data1);
        } else {
            $this->db->insert('company_information', $data);
            $id = $this->db->insert_id();
        }

//Branch Addresses

        $this->db->where('intUser', $user_id);
        $this->db->delete('branch_address');

        $brachcount = $this->input->post('brachcount', TRUE);
        for ($i = 1; $i <= $brachcount; $i++) {
            if ($this->input->get_post('varBranchCompanyName' . $i, true) != '') {
                $chrBranchFranchise = strip_tags($this->input->get_post('chrBranchFranchise' . $i, true));
                $varBranchCompanyName = strip_tags($this->input->get_post('varBranchCompanyName' . $i, true));
                $varBranchPersonName = strip_tags($this->input->get_post('varBranchPersonName' . $i, true));
                $varBranchLocation = strip_tags($this->input->get_post('varBranchLocation' . $i, true));
                $varBranchAddress = strip_tags($this->input->get_post('varBranchAddress' . $i, true));
                $varBranchCity = strip_tags($this->input->get_post('varBranchCity' . $i, true));
                $varBranchPostCode = strip_tags($this->input->get_post('varBranchPostCode' . $i, true));
//                $varBranchCountry = strip_tags($this->input->get_post('varBranchCountry' . $i, true));
                $varBranchDesignation = strip_tags($this->input->get_post('varBranchDesignation' . $i, true));
                $intBranchCountryCode = strip_tags($this->input->get_post('intBranchCountryCode' . $i, true));
                $varBranchLocationPhone = strip_tags($this->input->get_post('varBranchLocationPhone' . $i, true));
                $varBranchLocationEmail = strip_tags($this->input->get_post('varBranchLocationEmail' . $i, true));
                $varBranchLocationTel = strip_tags($this->input->get_post('varBranchLocationTel' . $i, true));

                $branch_data = array(
                    'intUser' => $user_id,
                    'chrBranchFranchise' => $chrBranchFranchise,
                    'varBranchCompanyName' => $varBranchCompanyName,
                    'varBranchPersonName' => $varBranchPersonName,
                    'varBranchLocation' => $varBranchLocation,
                    'varBranchAddress' => $varBranchAddress,
                    'varBranchCity' => $varBranchCity,
                    'varBranchPostCode' => $varBranchPostCode,
//                    'varBranchCountry' => $varBranchCountry,
                    'varBranchDesignation' => $varBranchDesignation,
                    'intBranchCountryCode' => $intBranchCountryCode,
                    'varBranchLocationPhone' => $varBranchLocationPhone,
                    'varBranchLocationEmail' => $varBranchLocationEmail,
                    'varBranchLocationTel' => $varBranchLocationTel
                );
                $this->db->insert(DB_PREFIX . 'branch_address', $branch_data);
            }
        }

//Company Photos..
        $count = count($_FILES['varCompanyImages']['name']);
        if ($this->input->post('companytmpimage', TRUE) != '') {
            $imgnames = rtrim($this->input->post('companytmpimage', TRUE), ",");
            $arrays = explode(",", $imgnames);
        } else {
            $imgnames = $this->input->post('varCompanyImages', TRUE);
            $arrays = array();
        }

        for ($i = 0; $i <= $count; $i++) {
            if (in_array($i, $arrays)) {
                
            } else {
                $sess = time();
                $img = basename($_FILES['varCompanyImages']['name'][$i]);
                if ($img != '') {
                    $photofile = preg_replace('/[^a-zA-Z0-9_ \[\]\.\(\)&-]/s', '', $img);
                    $_FILES['varCompanyImages']['name'][$i] = $photofile;
                    $image_title = basename($_FILES['varCompanyImages']['name'][$i]);
                    $fileexntension = substr(strrchr($image_title, '.'), 1);
                    $varName = str_replace('.' . $fileexntension, '', $image_title);
                    $maindir = 'upimages/company/companygallery/';
                    $var_main_file = $this->generate_image('varCompanyImages', $maindir, $i);
                    $file_photo = basename($var_main_file);
                    $uploadedfile = $maindir . $file_photo;
                    $this->thumb_width = PRODUCTGALLERY_WIDTH;
                    $this->thumb_height = PRODUCTGALLERY_HEIGHT;
                    image_thumb($maindir . $var_main_file, $this->thumb_width, $this->thumb_height);
                    $this->imagename = $var_main_file;
                    $imgname = explode('.', $this->imagename);
                    $image_name = $imgname['0'];
                    $c_date = date('Y-m-d H-i-s');

                    $company_img_data = array(
                        'varName' => $varName,
                        'intUser' => $user_id,
                        'varImage' => $this->imagename,
                        'dtCreateDate' => $c_date,
                        'varIpAddress' => $_SERVER['REMOTE_ADDR']
                    );
                    $this->db->insert(DB_PREFIX . 'companygallery', $company_img_data);
                }
            }
        }


        return $id;
    }

    function add_bank_info() {


        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];
        $data = array(
            'varAccountName' => $this->input->post('varAccountName', TRUE),
            'varBankName' => $this->input->post('varBankName', TRUE),
            'varAccountNo' => $this->input->post('varAccountNo', TRUE),
            'varIFSCCode' => $this->input->post('varIFSCCode', TRUE),
            'varAccountType' => $this->input->post('varAccountType', TRUE),
            'varMICRCode' => $this->input->post('varMICRCode', TRUE),
            'varBranchCode' => $this->input->post('varBranchCode', TRUE),
            'varIntAccountName' => $this->input->post('varIntAccountName', TRUE),
            'varIntBankName' => $this->input->post('varIntBankName', TRUE),
            'varIntAccountNo' => $this->input->post('varIntAccountNo', TRUE),
            'varIntIFSCCode' => $this->input->post('varIntIFSCCode', TRUE),
            'varIntAccountType' => $this->input->post('varIntAccountType', TRUE),
            'varIntMICRCode' => $this->input->post('varIntMICRCode', TRUE),
            'varIntBranchCode' => $this->input->post('varIntBranchCode', TRUE),
            'varIBANNo' => $this->input->post('varIBANNo', TRUE),
            'varRoutingCode' => $this->input->post('varRoutingCode', TRUE),
            'varSortCode' => $this->input->post('varSortCode', TRUE),
            'varABANo' => $this->input->post('varABANo', TRUE),
            'varRoutingCode' => $this->input->post('varRoutingCode', TRUE),
            'varSortCode' => $this->input->post('varSortCode', TRUE),
            'varABANo' => $this->input->post('varABANo', TRUE),
        );
        $this->db->where('intUser', $user_id);
        $this->db->update('company_information', $data);
    }

    function add_tradeshow() {


        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];
        $data = array(
            'varAttended' => $this->input->post('varAttended', TRUE),
            'intUser' => $user_id,
            'varTradeShowName' => $this->input->post('varTradeShowName', TRUE),
            'varOrganiser' => $this->input->post('varOrganiser', TRUE),
            'varStartDate' => date('Y-m-d', strtotime($this->input->post('varStartDate', TRUE))),
            'varEndDate' => date('Y-m-d', strtotime($this->input->post('varEndDate', TRUE))),
            'varEventLocation' => $this->input->post('varEventLocation', TRUE),
            'varEventAddress' => $this->input->post('varEventAddress', TRUE),
            'varEventCity' => $this->input->post('varEventCity', TRUE),
            'varEventState' => $this->input->post('varEventState', TRUE),
            'varEventCountry' => $this->input->post('varEventCountry', TRUE),
            'varEventPincode' => $this->input->post('varEventPincode', TRUE),
            'varEventLatitude' => $this->input->post('varEventLatitude', TRUE),
            'varEventLongitude' => $this->input->post('varEventLongitude', TRUE),
            'varInformation' => nl2br($this->input->post('varInformation', TRUE))
        );
//        $this->db->where('intUser', $user_id);
        $event_id = $this->input->post('intEvent', TRUE);
        if ($event_id == '') {
            $this->db->insert('tradeshow_events', $data);
            $id = $this->db->insert_id();
        } else {
            $this->db->where('int_id', $event_id);
            $this->db->update('company_information', $data);
            $id = $event_id;
        }



//Event Photos..
        $counts = count($_FILES['varEventImages']['name']);
        if ($this->input->post('eventtmpimage', TRUE) != '') {
            $imgnamesa = rtrim($this->input->post('eventtmpimage', TRUE), ",");
            $arraysa = explode(",", $imgnamesa);
        } else {
            $imgnamesa = $this->input->post('eventtmpimage', TRUE);
            $arraysa = array();
        }




//        print_R($imgnamesa);
//        print_R($arraysa);
//        exit;
        for ($j = 0; $j <= $counts; $j++) {
            if (in_array($j, $arraysa) && $imgnamesa != '') {
                
            } else {
                $sess = time();
                $img = basename($_FILES['varEventImages']['name'][$j]);
                if ($img != '') {
                    $photofile = preg_replace('/[^a-zA-Z0-9_ \[\]\.\(\)&-]/s', '', $img);
                    $_FILES['varEventImages']['name'][$j] = $photofile;
                    $image_title = basename($_FILES['varEventImages']['name'][$j]);
                    $fileexntension = substr(strrchr($image_title, '.'), 1);
                    $varName1 = str_replace('.' . $fileexntension, '', $image_title);
                    $maindir = 'upimages/company/eventgallery/';
                    $var_main_file = $this->generate_image('varEventImages', $maindir, $j);
                    $file_photo = basename($var_main_file);
                    $uploadedfile = $maindir . $file_photo;
                    $this->thumb_width = PRODUCTGALLERY_WIDTH;
                    $this->thumb_height = PRODUCTGALLERY_HEIGHT;
                    image_thumb($maindir . $var_main_file, $this->thumb_width, $this->thumb_height);
                    $this->imagename1 = $var_main_file;
                    $imgname = explode('.', $this->imagename1);
                    $image_name = $imgname['0'];
                    $c_date = date('Y-m-d H-i-s');

                    $event_data = array(
                        'varName' => $varName1,
                        'intUser' => $user_id,
                        'intEvent' => $id,
                        'varImage' => $this->imagename1,
                        'dtCreateDate' => $c_date,
                        'varIpAddress' => $_SERVER['REMOTE_ADDR']
                    );
                    $this->db->insert(DB_PREFIX . 'eventgallery', $event_data);
                }
            }
        }
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

    function register_buyer() {
//        $html_message = file_get_contents("front-media/emailtemplate/forgot_password_old.html");
//        echo $html_message;
//        exit;
        $email = $this->input->post('varEmail', TRUE);

        $crypted_password = $this->mylibrary->cryptPass($this->input->post('varPassword', true));
        $random_number = rand(100000, 999999);

        if ($_FILES['image']['name'] != '') {
            $config['upload_path'] = 'upimages/users/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '1000000';
            $this->ImageName = $_FILES['image']['name'];
            $Imagesurl = $this->ImageName = $this->common_model->Clean_String($this->ImageName);
            $FileExntension = substr(strrchr($this->ImageName, '.'), 1);
            $Var_Title = str_replace('.' . $FileExntension, '', $this->ImageName);
            $Imagesurl = $this->ImageName = $Var_Title . "_" . time() . "." . $FileExntension;
            $config['file_name'] = $this->ImageName;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('errorMsg', $this->upload->display_errors());
                echo $this->upload->display_errors();
                exit;
            }
        } else {
            $Imagesurl = "";
        }
        $phone = $this->input->post('varPhone', TRUE);
        file_get_contents('http://bhashsms.com/api/sendmsg.php?user=indibizz&pass=hello@123&sender=INDBIZ&phone=' . $phone . '&text=' . $random_number . '&priority=ndnd&stype=normal');

        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'varReferralNo' => $this->input->post('varReferralNo', TRUE),
            'varPassword' => $crypted_password,
            'varOriginalPassword' => $this->input->post('varPassword', true),
            'varEmail' => $email,
            'varCompany' => $this->input->post('varCompany', TRUE),
            'varTel' => $this->input->post('varTel', TRUE),
            'varPhone' => $phone,
            'intCountryCode' => $this->input->post('intCountryCode', TRUE),
            'varLocation' => $this->input->post('varLocation', TRUE),
            'varAddress1' => $this->input->post('varAddress1', TRUE),
//            'varAddress2' => $this->input->post('varAddress2', TRUE),
            'varLatitude' => $this->input->post('varLatitude', TRUE),
            'varLongitude' => $this->input->post('varLongitude', TRUE),
            'varCity' => $this->input->post('varCity', TRUE),
            'varState' => $this->input->post('varState', TRUE),
            'varZipcode' => $this->input->post('varZipcode', TRUE),
            'varCountry' => $this->input->post('varCountry', TRUE),
            'varOTP' => $random_number,
            'varImage' => $Imagesurl,
            'chrType' => 'BS',
            'chrPublish' => 'Y',
            'chrDelete' => 'N',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
//        print_R($data);
//        exit;
        $this->db->insert('users', $data);
        $id = $this->db->insert_id();

        $aliasname = strtolower($this->input->post('varCompany'));
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

        if (!empty($email)) {

            $logo = ADMIN_MEDIA_URL;
            $siteLogo = ADMIN_MEDIA_URL . "mailtemplates/images/IndiBizz Logo new.svg";


            $subject = 'Just one click and you are verified : ' . SITE_NAME;
            $body_admin = '';
            $content = '';
            $content .= "Action Needed!<br><br>";
            $content .= "You need to verify E-mail address. It's so easy! Just click to below link.  We are simply verifying your ownership for this E-mail address.<br>Without verification, you will not able to use best of our services. Your profile will be on hold.";

            $body .= ' <tr>
                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Link : </strong><a href=' . $fp_link . ' target="_blank" style="color:#337ab7; text-decoration:none;">' . $fp_link . '</a></td>
                                                                            </tr>';
            if (FACEBOOK_LINK != '') {
                $fbFollous = '<td style="padding: 0 5px;"><a href="' . FACEBOOK_LINK . '" target="_blank" class="circle fab fa-facebook-f"></a></td>';
            }
            if (TWITTER_LINK != '') {
                $twFollous = '<td style="padding: 0 5px;"><a href="' . TWITTER_LINK . '" target="_blank" class="circle fab fa-twitter"></a></td>';
            }
            if (GOOGLE_PLUS_LINK != '') {
                $gpFollous = '<td style="padding: 0 5px;"><a href="' . GOOGLE_PLUS_LINK . '" target="_blank" class="circle fab fa-google-plus-g"></a></td>';
            }
            if (LINKEDIN_LINK != '') {
                $liFollous = '<td style="padding: 0 5px;"><a href="' . LINKEDIN_LINK . '" target="_blank" class="circle fab fa-linkedin-in"></a></td>';
            }
            if (INSTAGRAM_LINK != '') {
                $igFollous = '<td style="padding: 0 5px;"><a href="' . INSTAGRAM_LINK . '" target="_blank" class="circle fab fa-instagram"></a></td>';
            }
            if (GITHUB_LINK != '') {
                $ghFollous = '<td style="padding: 0 5px;"><a href="' . GITHUB_LINK . '" target="_blank" class="circle fab fa-github"></a></td>';
            }
            $email_link = $logout_url = $this->common_model->getUrl("pages", "2", "98", '') . "?email=" . $email;
            $html_message = file_get_contents("front-media/emailtemplate/forgot_password.html");
            $html_message = str_replace("@VERIFY_EMAIL", $email_link, $html_message);
            $html_message = str_replace("@CONTENT", $content, $html_message);
            $html_message = str_replace("@MAIL_HEADER", $email_header, $html_message);
            $html_message = str_replace("@MAIL_FOOTER", $email_footer, $html_message);
            $html_message = str_replace("@FLOLLOW", $Follous, $html_message);
            $html_message = str_replace("@MAIL_LEFT", '', $html_message);
            $html_message = str_replace("@DETAILS", $body, $html_message);
            $html_message = str_replace("@YEAR", date('Y'), $html_message);
            $html_message = str_replace("@FACEBOOK", $fbFollous, $html_message);
            $html_message = str_replace("@TWITTER", $twFollous, $html_message);
            $html_message = str_replace("@YOUTUBE", $ytFollous, $html_message);
            $html_message = str_replace("@GOOGLE+", $gpFollous, $html_message);
            $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
            $html_message = str_replace("@INSTAGRAM", $igFollous, $html_message);
            $html_message = str_replace("@GITHUB", $ghFollous, $html_message);
            $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
            $html_message = str_replace("@NAME", "Hello " . $this->input->post('varName', TRUE), $html_message);
            $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
            $html_message = str_replace("@MEDIA_URL", SITE_PATH . "front-media/emailtemplate/", $html_message);
            $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);
            $html_message = str_replace("@LOGO", $siteLogo, $html_message);

            $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
            $headers .= "Reply-To: " . $email . "\r\n";
            $headers .= "Content-type: text/html\r\n";

            mail($email, $subject, $html_message, $headers);
//            echo $html_message;exit;
        }


        $conds = "int_id = '" . $id . "'";
        $this->db->where($conds);
        $query = $this->db->get('users');
        $row = $query->row();


        if (count($row) == 1) {

            $data = array(
                SESSION_PREFIX . 'UserLoginUserId' => $row->int_id,
                SESSION_PREFIX . 'UserLoginEmail' => $row->varEmail,
                SESSION_PREFIX . 'UserLoginName' => $row->varName,
                SESSION_PREFIX . 'UserLoginPhone' => $row->varPhone,
                SESSION_PREFIX . 'UserLoginType' => $row->chrType,
                SESSION_PREFIX . 'UserLoginIpAddress' => $_SERVER['REMOTE_ADDR']
            );
            $this->session->set_userdata(PREFIX, $data);
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

    function update($Files_Name = '') {
        $publish = $this->input->post('chrPublish', true);
        $chrPublish = ($publish != '') ? $publish : 'Y';
        if ($_FILES['varImage']['name'] != '') {
            $config['upload_path'] = 'upimages/users/images/';
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

        $meta_title = str_replace('"', '', $this->input->post('varMetaTitle', TRUE));
        $meta_keyword = str_replace('"', '', $this->input->post('varMetaKeyword', TRUE));
        $meta_description = str_replace('"', '', $this->input->post('varMetaDescription', TRUE));

        $meta_data = $this->generate_seocontent_buyer_seller();
        $meta_data_array = explode('*****', $meta_data);

        $meta_title = ($meta_title != '') ? $meta_title : $meta_data_array[0];
        $meta_keyword = ($meta_keyword != '') ? $meta_keyword : $meta_data_array[1];
        $meta_description = ($meta_description != '') ? $meta_description : $meta_data_array[2];

        $crypted_password = $this->mylibrary->cryptPass($this->input->post('varPassword', true));

        $data = array(
            'varName' => $this->input->post('varName', TRUE),
            'varPassword' => $crypted_password,
            'varOriginalPassword' => $this->input->post('varPassword', true),
            'varEmail' => $this->input->post('varEmail', TRUE),
            'varCompany' => $this->input->post('varCompany', TRUE),
            'varPhone' => $this->input->post('varPhone', TRUE),
            'varLocation' => $this->input->post('varLocation', TRUE),
            'varAddress1' => $this->input->post('varAddress1', TRUE),
//            'varAddress2' => $this->input->post('varAddress2', TRUE),
            'varLatitude' => $this->input->post('varLatitude', TRUE),
            'varLongitude' => $this->input->post('varLongitude', TRUE),
            'varCity' => $this->input->post('varCity', TRUE),
            'varState' => $this->input->post('varState', TRUE),
            'varZipcode' => $this->input->post('varZipcode', TRUE),
            'varCountry' => $this->input->post('varCountry', TRUE),
            'varImage' => $Imagesurl,
            'varMetaTitle' => $meta_title,
            'varMetaKeyword' => $meta_keyword,
            'varMetaDescription' => $meta_description,
            'chrPublish' => $chrPublish,
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
//        print_R($data);exit;
        $this->db->where('int_id', $this->input->get_post('ehintglcode'));
        $this->db->update('users', $data);
        $int_id = $this->input->get_post('ehintglcode');

        $Alias_Array = array('fk_ModuleGlCode' => MODULE_ID, 'fk_Record' => $this->input->get_post('ehintglcode'), 'varAlias' => $this->input->post('varAlias', TRUE));
        $this->common_model->Update_Alias($Alias_Array);

        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'users', 'Name' => 'varName', 'ModuleintGlcode' => $int_id, 'Flag' => 'U', 'Default' => 'int_id');
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'users');
        $this->mylibrary->insertinlogmanager($ParaArray);
    }

//    public function Upload_excel() {
////        echo "hgi";exit;
//        $repeated = array();
//        $issuelist = array();
//        $filename = $_FILES["varFileUpload"]["tmp_name"];
//        if ($_FILES["varFileUpload"]["size"] > 0) {
//            $file = fopen($filename, "r");
//            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
//
//                if ($emapData[1] != '') {
//
//
//                    $data = array(
//                        'varAddress1' => $emapData[0],
//                    );
//                    $this->db->where('varPhone', $emapData[1]);
//                    $this->db->update('users', $data);
//                } else {
//                    $repeated['name'] = $emapData[1];
//                    $repeated['issue'] = "Required Mobile Number";
//                    $repeated['solution'] = "Mobile Number required.";
//                    $issuelist[] = $repeated;
//                }
//            }
//        }
//        fclose($file);
//        return $issuelist;
//    }

    public function Upload_excel() {
//        echo "hgi";exit;
        $repeated = array();
        $issuelist = array();
        $filename = $_FILES["varFileUpload"]["tmp_name"];
        if ($_FILES["varFileUpload"]["size"] > 0) {
            $file = fopen($filename, "r");
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($emapData[3] != '') {
                    $checknamea = $this->checkId(stripslashes(quotes_to_entities($emapData[0])));
                    if ($checknamea == 0) {
                        $checkname = $this->checkEmailExist(stripslashes(quotes_to_entities($emapData[3])));
                        if ($checkname == 0) {
                            $checkname1 = $this->checkMobileExist(stripslashes(quotes_to_entities($emapData[7])));
                            if ($checkname1 == 0) {
                                if ($emapData[0] != '' && $emapData[2] != '' && $emapData[3] != '' && $emapData[4] != '' && $emapData[5] != '' && $emapData[7] != '' && $emapData[9] != '' && $emapData[26] != '') {
//                            if ($emapData[0] != '' && $emapData[2] != '' && $emapData[3] != '' && $emapData[4] != '' && $emapData[5] != '' && $emapData[9] != '' && $emapData[11] != '' && $emapData[12] != '' && $emapData[13] != '' && $emapData[14] != '' && $emapData[15] != '' && $emapData[16] != '' && $emapData[17] != '' && $emapData[18] != '' && $emapData[19] != '' && $emapData[26] != '' && $emapData[27] != '') {

                                    if ($emapData[20] == 'Y') {
                                        $payment = "Y";
                                        $payment_date = date('Y-m-d H:i:s');
                                        $payment_plan = "1";
                                    } else {
                                        $payment = "N";
                                        $payment_date = "";
                                        $payment_plan = "0";
                                    }

                                    $data = array(
                                        'int_id' => $emapData[0],
                                        'varReferralNo' => $emapData[1],
                                        'varName' => trim(str_replace('"', '', $emapData[2])),
                                        'varEmail' => $emapData[3],
                                        'varPassword' => $this->mylibrary->cryptPass($emapData[4]),
                                        'varOriginalPassword' => $emapData[4],
                                        'varCompany' => $emapData[5],
                                        'chrImageFlag' => 'S',
                                        'varExternalUrl' => '',
                                        'varImage' => $emapData[6],
                                        'varPhone' => $emapData[7],
                                        'varOTP' => $emapData[8],
                                        'chrMobileVerify' => $emapData[9],
                                        'varTel' => $emapData[10],
                                        'varLocation' => $emapData[11],
                                        'varAddress1' => $emapData[12],
//                                        'varAddress2' => $emapData[13],
                                        'varCity' => $emapData[14],
                                        'varState' => $emapData[15],
                                        'varZipcode' => $emapData[16],
                                        'varCountry' => $emapData[17],
                                        'varLatitude' => $emapData[18],
                                        'varLongitude' => $emapData[19],
                                        'chrPayment' => $payment,
                                        'varSubdomain' => $emapData[21],
                                        'intPaymentUser' => $emapData[22],
                                        'varPaymentDate' => $payment_date,
                                        'intPlan' => $payment_plan,
                                        'intPayment' => $emapData[25],
                                        'chrType' => $emapData[26],
                                        'dtCreateDate' => date('Y-m-d H:i:s'),
                                        'chrDelete' => "N",
                                        'chrPublish' => "Y",
                                        'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                                        'PUserGlCode' => ADMIN_ID,
                                    );
//                            print_r($data);exit;

                                    $this->db->insert('users', $data);
                                    $id = $this->db->insert_id();

                                    if ($emapData[21] != '') {
                                        $alias = $emapData[21];
                                    } else {
                                        $aliasname = strtolower($emapData[5]);
                                        $aliasname = stripslashes(quotes_to_entities($aliasname));
                                        $aliasname = str_replace(' ', '-', $aliasname);
                                        $aliasname = preg_replace('/[^A-Za-z0-9\-]/', '', $aliasname);
                                        $aliasname = str_replace('---', '-', $aliasname);
                                        $aliasname = str_replace('--', '-', $aliasname);
                                        $aliasname = strip_tags($aliasname);
                                        $aliasname = htmlentities($aliasname);
                                        $alias = $this->GetAlias($aliasname);
                                    }
                                    $aliasdata = array(
                                        'fk_ModuleGlCode' => MODULE_ID,
                                        'fk_Record' => $id,
                                        'varAlias' => $alias,
                                    );
                                    $this->db->insert('alias', $aliasdata);
                                } else {
                                    $repeated['id'] = $emapData[0];
                                    $repeated['name'] = $emapData[2];
                                    $repeated['issue'] = "Please fill Required fields.";
                                    $repeated['solution'] = "Please fill mendadory fields.";
                                    $issuelist[] = $repeated;
                                }
                            } else {
                                $repeated['id'] = $emapData[0];
                                $repeated['name'] = $emapData[2];
                                $repeated['issue'] = "Repeated Mobile Number";
                                $repeated['solution'] = "Mobile Number must be unique.";
                                $issuelist[] = $repeated;
                            }
                        } else {
                            $repeated['id'] = $emapData[0];
                            $repeated['name'] = $emapData[2];
                            $repeated['issue'] = "Repeated Email";
                            $repeated['solution'] = "Email must be unique.";
                            $issuelist[] = $repeated;
                        }
                    } else {
                        $repeated['id'] = $emapData[0];
                        $repeated['name'] = $emapData[2];
                        $repeated['issue'] = "Repeated ID";
                        $repeated['solution'] = "ID must be unique.";
                        $issuelist[] = $repeated;
                    }
                }
            }
            fclose($file);
            return $issuelist;
        }
    }

    public function getCountryCode() {
        $id = $this->input->get_post('country_id');
        $sql = "select country_code from " . DB_PREFIX . "countries where iso2='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return "+" . $data['country_code'];
    }

    public function checkEmailExist($email) {
        $sql = "select * from " . DB_PREFIX . "users where chrDelete='N' and varEmail='" . $email . "'";
        $query = $this->db->query($sql);
        $data = $query->num_rows();
        return $data;
    }

    public function checkId($id) {
        $sql = "select * from " . DB_PREFIX . "users where chrDelete='N' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->num_rows();
        return $data;
    }

    public function checkMobileExist($phone) {
        $sql = "select * from " . DB_PREFIX . "users where chrDelete='N' and varPhone='" . $phone . "'";
        $query = $this->db->query($sql);
        $data = $query->num_rows();
        return $data;
    }

    function sendpayment() {

        $plan_id = $this->input->post('intPlan', TRUE);
        $getPlanData = $this->payment_data($plan_id);

        $data = array(
            'varPaymentDate' => date('Y-m-d H:i:s', strtotime($this->input->post('varPaymentDate', TRUE))),
            'intPayment' => $this->input->post('intPayment', TRUE),
            'intPlan' => $plan_id,
            'intQuoteLeft' => $getPlanData['varBuylead'],
            'varSubdomain' => $this->input->post('varSubdomain', TRUE),
            'intPaymentUser' => ADMIN_ID,
            'chrPayment' => 'Y',
        );
//        print_R($data);exit;
        $this->db->where('int_id', $this->input->get_post('intUser'));
        $this->db->update('users', $data);
    }

    public function payment_data($id) {
        $sql = "select * from " . DB_PREFIX . "plans where chrDelete='N' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    function Select_Share_Page_Rows($id) {
//echo "Select_Share_Page_Rows";exit;
        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "users WHERE chrDelete='N' AND chrPublish='Y' AND int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
//        print_r($result);exit;
        return $result;
    }

    function getCertificateList($id) {
        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "company_certificate where intUser='" . $id . "' order by int_id asc";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function getTrademarkList($id) {
        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "company_trademark where intUser='" . $id . "' order by int_id asc";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function getTradeshowEventsList($id) {
        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "tradeshow_events where intUser='" . $id . "' order by int_id asc";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function getUserProductDatas($id) {
        $sql = "SELECT s.varName,a.varAlias,s.int_id,s.dtCreateDate,('product') as type,a.intPageHits,a.intMobileHits FROM " . DB_PREFIX . "product as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE s.intSupplier='" . $id . "' and a.fk_ModuleGlCode='140' and s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.dtCreateDate desc";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function getUserBuyLeads($id) {
        $sql = "SELECT s.varName,a.varAlias,s.int_id,s.dtCreateDate,('buylead') as type,a.intPageHits,a.intMobileHits FROM " . DB_PREFIX . "buyleads as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE s.intUser='" . $id . "' and a.fk_ModuleGlCode='147' and s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.dtCreateDate desc";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function delete_row() {
        $tablename = 'users';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['SERVER_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'users', 'Name' => 'varName', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id');
            $this->mylibrary->insertinlogmanager($ParaArray);
        }
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'users');
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
        $this->mylibrary->update_display_order_Ajax($uids, $neworder, $oldorder, '', 'users');
        $this->mylibrary->set_Int_DisplayOrder_sequence(DB_PREFIX . 'users');
    }

    function get_hits($id) {
        $this->db->cache_set_common_path("application/cache/db/common/users/");
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
//echo'Team';exit;
        $sql = "select * from " . DB_PREFIX . "users WHERE chrPublish='Y' and chrDelete='N' group by int_id $limitby ";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function getBusinessTypeList($id = '') {

        $ids = explode(",", $id);
        $returnHtml = '';
        foreach ($ids as $row) {
            $query = $this->db->query("select varName from " . DB_PREFIX . "business_type where int_id='" . $row . "' and chrDelete = 'N' order by varName asc");
            $Result = $query->row_array();

            $returnHtml .= $Result['varName'] . ", ";
        }
        $returnHtml = rtrim($returnHtml, ", ");
        return $returnHtml;
    }

    function getPaymentType($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "payment_types where chrDelete = 'N' order by int_id asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= '<option value="">Select Payment Type</option>';
        foreach ($Result as $row) {
            $returnHtml .= '<option value="' . $row['int_id'] . '">' . $row['varName'] . '</option>';
        }
        return $returnHtml;
    }

    function getAllPlans($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "plans where chrDelete = 'N' order by int_id asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= '<option value="">Select Membership Plan</option>';
        foreach ($Result as $row) {
            $returnHtml .= '<option value="' . $row['int_id'] . '">' . $row['varName'] . '</option>';
        }
        return $returnHtml;
    }

    function CheckDescription($id) {
        $sql = "SELECT chrDescriptionDisplay FROM " . DB_PREFIX . "pages where int_id=" . $id;
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function checkevent($id, $user_Id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "tradeshow_events where int_id='" . $id . "' and intUser='" . $user_Id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->row_array();
        return $result_query;
    }

    function verifyEmailAddress($email) {
        if (!empty($email)) {

            $logo = ADMIN_MEDIA_URL;
            $siteLogo = ADMIN_MEDIA_URL . "mailtemplates/images/IndiBizz Logo new.svg";


            $subject = 'Just one click and you are verified : ' . SITE_NAME;
            $body_admin = '';
            $content = '';
            $content .= "Action Needed!<br><br>";
            $content .= "You need to verify E-mail address. It's so easy! Just click to below link.  We are simply verifying your ownership for this E-mail address.<br>Without verification, you will not able to use best of our services. Your profile will be on hold.";

            $body .= ' <tr>
                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Link : </strong><a href=' . $fp_link . ' target="_blank" style="color:#337ab7; text-decoration:none;">' . $fp_link . '</a></td>
                                                                            </tr>';
            if (FACEBOOK_LINK != '') {
                $fbFollous = '<td style="padding: 0 5px;"><a href="' . FACEBOOK_LINK . '" target="_blank" class="circle fab fa-facebook-f"></a></td>';
            }
            if (TWITTER_LINK != '') {
                $twFollous = '<td style="padding: 0 5px;"><a href="' . TWITTER_LINK . '" target="_blank" class="circle fab fa-twitter"></a></td>';
            }
            if (GOOGLE_PLUS_LINK != '') {
                $gpFollous = '<td style="padding: 0 5px;"><a href="' . GOOGLE_PLUS_LINK . '" target="_blank" class="circle fab fa-google-plus-g"></a></td>';
            }
            if (LINKEDIN_LINK != '') {
                $liFollous = '<td style="padding: 0 5px;"><a href="' . LINKEDIN_LINK . '" target="_blank" class="circle fab fa-linkedin-in"></a></td>';
            }
            if (INSTAGRAM_LINK != '') {
                $igFollous = '<td style="padding: 0 5px;"><a href="' . INSTAGRAM_LINK . '" target="_blank" class="circle fab fa-instagram"></a></td>';
            }
            if (GITHUB_LINK != '') {
                $ghFollous = '<td style="padding: 0 5px;"><a href="' . GITHUB_LINK . '" target="_blank" class="circle fab fa-github"></a></td>';
            }
            $email_link = $logout_url = $this->common_model->getUrl("pages", "2", "98", '') . "?email=" . $email;
            $html_message = file_get_contents("front-media/emailtemplate/forgot_password.html");
            $html_message = str_replace("@VERIFY_EMAIL", $email_link, $html_message);
            $html_message = str_replace("@CONTENT", $content, $html_message);
            $html_message = str_replace("@MAIL_HEADER", $email_header, $html_message);
            $html_message = str_replace("@MAIL_FOOTER", $email_footer, $html_message);
            $html_message = str_replace("@FLOLLOW", $Follous, $html_message);
            $html_message = str_replace("@MAIL_LEFT", '', $html_message);
            $html_message = str_replace("@DETAILS", $body, $html_message);
            $html_message = str_replace("@YEAR", date('Y'), $html_message);
            $html_message = str_replace("@FACEBOOK", $fbFollous, $html_message);
            $html_message = str_replace("@TWITTER", $twFollous, $html_message);
            $html_message = str_replace("@YOUTUBE", $ytFollous, $html_message);
            $html_message = str_replace("@GOOGLE+", $gpFollous, $html_message);
            $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
            $html_message = str_replace("@INSTAGRAM", $igFollous, $html_message);
            $html_message = str_replace("@GITHUB", $ghFollous, $html_message);
            $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
            $html_message = str_replace("@NAME", "Hello", $html_message);
            $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
            $html_message = str_replace("@MEDIA_URL", SITE_PATH . "front-media/emailtemplate/", $html_message);
            $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);
            $html_message = str_replace("@LOGO", $siteLogo, $html_message);



            $headers = "";

            $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
            $headers .= "Reply-To: " . $email . "\r\n";
            $headers .= "Content-type: text/html\r\n";

            $ReplyTo = "noreply@indibizz.com";
            $this->mylibrary->send_mail($email, $subject, $html_message, "", $ReplyTo);


//            echo $html_message;exit;
        }
    }

    function verifyEmail() {
        $email = $this->input->get_post('email');
        $data = array(
            'chrEmailVerify' => "Y",
            'dtModifyDate' => date('Y-m-d H:i:s')
        );
        $this->db->where('varEmail', $email);
        $this->db->update('users', $data);
        return 1;
    }

    function send_otp() {
        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];

        $varOTP = $this->input->get_post('varOTP');
        $sql = "SELECT * FROM " . DB_PREFIX . "users where int_id='" . $user_id . "' and varOTP='" . $varOTP . "'";
//        echo $sql;exit;
        $data = $this->db->query($sql);
        if ($data->num_rows() > 0) {

            $data = array(
                'chrMobileVerify' => "Y",
                'dtModifyDate' => date('Y-m-d H:i:s')
            );
            $this->db->where('int_id', $user_id);
            $this->db->update('users', $data);
            return 1;
        } else {
            return 0;
        }
    }

    function resend_otp() {
        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];

        $sql = "SELECT varOTP,varPhone FROM " . DB_PREFIX . "users where int_id='" . $user_id . "'";
        $data = $this->db->query($sql);
        $data = $data->row_array();
        $phone = $data['varPhone'];
        $random_number = $data['varOTP'];
//        echo 'http://bhashsms.com/api/sendmsg.php?user=indibizz&pass=hello@123&sender=INDBIZ&phone=' . $phone . '&text=' . $random_number . '&priority=ndnd&stype=normal';exit;
        file_get_contents('http://bhashsms.com/api/sendmsg.php?user=indibizz&pass=hello@123&sender=INDBIZ&phone=' . $phone . '&text=' . $random_number . '&priority=ndnd&stype=normal');
    }

    function update_verification() {
        $login_user_session = $this->session->userdata(PREFIX);
        $session_id = SESSION_PREFIX . "UserLoginUserId";
        $user_id = $login_user_session[$session_id];

        $data = array(
            'chrMobileVerify' => "Y",
            'dtModifyDate' => date('Y-m-d H:i:s')
        );
        $this->db->where('int_id', $user_id);
        $this->db->update('users', $data);
        return true;
    }

    function delete_product() {
        $Eid = $this->input->get_post('int_id', FALSE);

        $data = array(
            'chrDelete' => "Y",
            'dtModifyDate' => date('Y-m-d H:i:s')
        );
        $this->db->where('int_id', $Eid);
        $this->db->update('product', $data);
        return true;
    }

    function delete_member() {
        $Eid = $this->input->get_post('int_id', FALSE);

        $data = array(
            'chrDelete' => "Y",
            'dtModifyDate' => date('Y-m-d H:i:s')
        );
        $this->db->where('int_id', $Eid);
        $this->db->update('company_members', $data);
        return true;
    }

    function DeleteEventdata() {
        $Eid = $this->input->get_post('int_id', FALSE);
        $this->db->where('int_id', $Eid);
        $this->db->delete('company_certificate');
        return true;
    }

    function DeleteTradeshowdata() {
        $Eid = $this->input->get_post('int_id', FALSE);
        $this->db->where('int_id', $Eid);
        $this->db->delete('tradeshow_events');

        $this->db->where('intEvent', $Eid);
        $this->db->delete('eventgallery');
        return true;
    }

    function DeleteTrademarkdata() {
        $Eid = $this->input->get_post('int_id', FALSE);
        $this->db->where('int_id', $Eid);
        $this->db->delete('company_trademark');
        return true;
    }

    function delete_company_image() {
        $id = $this->input->get_post('int_id', FALSE);

        $data = array(
            'chrDelete' => "Y",
            'dtModifyDate' => date('Y-m-d H:i:s')
        );
        $this->db->where('int_id', $id);
        $this->db->update('companygallery', $data);
        return true;
    }

    function delete_event_image() {
        $id = $this->input->get_post('int_id', FALSE);

        $data = array(
            'chrDelete' => "Y",
            'dtModifyDate' => date('Y-m-d H:i:s')
        );
        $this->db->where('int_id', $id);
        $this->db->update('eventgallery', $data);
        return true;
    }

    function Check_subdomain() {
        $Eid = $this->input->get_post('Eid', FALSE);
        if (!empty($Eid)) {
            $this->db->where_not_in('int_id', $Eid);
        }
        $this->db->where('varSubDomain', $this->input->get_post('varSubDomain', FALSE));
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function Check_Email_Phone() {
        $Eid = $this->input->get_post('Eid', FALSE);
        $email = $this->input->get_post('User_Email', FALSE);
        $phone = $this->input->get_post('User_Phone', FALSE);
        if ($email == '') {
            $query = $this->db->query("select * from  " . DB_PREFIX . "users where varEmail = '" . $email . "' and chrDelete='N'");
        } else if ($phone == '') {
            $query = $this->db->query("select * from  " . DB_PREFIX . "users where varPhone = '" . $phone . "' and chrDelete='N'");
        } else {
            $query = $this->db->query("select * from  " . DB_PREFIX . "users where (varEmail = '" . $email . "' or varPhone = '" . $phone . "') and chrDelete='N'");
        }

        $rows = $query->num_rows();
//        echo $rows;exit;
        if ($rows > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    function check_company_email_phone() {
        $Eid = $this->input->get_post('Eid', FALSE);
        $email = $this->input->get_post('User_Email', FALSE);
        $phone = $this->input->get_post('User_Phone', FALSE);
        if (!empty($Eid)) {
            $qu = " and int_id!= '" . $Eid . "'";
        }
        $query = $this->db->query("select * from  " . DB_PREFIX . "company_members where (varEmail = '" . $email . "' or varPhone = '" . $phone . "') and chrDelete='N' " . $qu . " ");
//        $this->db->or_where('varPhone', $this->input->get_post('User_Phone', FALSE));
//        $query = $this->db->get('users');
        $rows = $query->num_rows();
//        echo $rows;exit;
        if ($rows > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    function getBranchData($id) {
        $query = "select * from  " . DB_PREFIX . "branch_address where intUser='" . $id . "'";
        $query = $this->db->query($query);
        $Result = $query->result_array();
        return $Result;
    }

    function getCompanyMemberList($id) {
        $query = "select cm.*,d.varName as DesignationName from  " . DB_PREFIX . "company_members as cm left join " . DB_PREFIX . "designation as d on cm.intDesignation=d.int_id where cm.intUser='" . $id . "' and cm.chrPublish='Y' and cm.chrDelete='N' order by cm.int_id asc";
        $query = $this->db->query($query);
        $Result = $query->result_array();
        return $Result;
    }

    function get_partner() {
        $id = $this->input->get_post('int_id', FALSE);
        $query = "select * from  " . DB_PREFIX . "company_members where int_id='" . $id . "' and chrPublish='Y' and chrDelete='N'";
        $query = $this->db->query($query);
        $Result = $query->row_array();
        return $Result;
    }

    function getCertificate() {
        $id = $this->input->get_post('int_id', FALSE);
        $query = "select * from  " . DB_PREFIX . "company_certificate where int_id='" . $id . "'";
        $query = $this->db->query($query);
        $Result = $query->row_array();
        return $Result;
    }

    function getTrademark() {
        $id = $this->input->get_post('int_id', FALSE);
        $query = "select * from  " . DB_PREFIX . "company_trademark where int_id='" . $id . "'";
        $query = $this->db->query($query);
        $Result = $query->row_array();
        return $Result;
    }

    function getUserList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "adminpanelusers where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "";
        $returnHtml .= "<option value=''>--Select Unit --</option>";
        foreach ($Result as $row) {
            if (ADMIN_ID == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        return $returnHtml;
    }

    function getUserProfile($id) {

        $sql = "select * from " . DB_PREFIX . "users WHERE chrPublish='Y' and chrDelete='N' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $rowdata = $query->row_array();
        return $rowdata;
    }

    function getCompanyPhotos($id) {

        $sql = "select * from " . DB_PREFIX . "companygallery WHERE chrPublish='Y' and chrDelete='N' and intUser='" . $id . "'";
        $query = $this->db->query($sql);
        $rowdata = $query->result_array();
        return $rowdata;
    }

    function getWebsiteCompanyPhotos($id) {
        $sql = "select * from " . DB_PREFIX . "companygallery WHERE chrPublish='Y' and chrDelete='N' and intUser='" . $id . "' limit 10";
        $query = $this->db->query($sql);
        $rowdata = $query->result_array();
        return $rowdata;
    }

    function getWebsiteProductPhotos($id) {
        $sql = "select int_id from " . DB_PREFIX . "product WHERE chrPublish='Y' and chrDelete='N' and intSupplier='" . $id . "' limit 10";
        $query = $this->db->query($sql);
        $rowdata = $query->result_array();
        $imagedata = array();
        foreach ($rowdata as $pro) {
            $sqls = "select varImage from " . DB_PREFIX . "productgallery WHERE chrPublish='Y' and chrDelete='N' and fkProduct='" . $pro['int_id'] . "' limit 10";
            $querys = $this->db->query($sqls);
            $rows = $querys->row_array();
            if ($rows['varImage'] != '') {
                $imagedata[] = array(
                    'varImage' => $rows['varImage']
                );
            }
        }


        return $imagedata;
    }

    public function getCompanyProductsData($id) {
        $sql = "select E.*,A.varAlias,AU.varAlias as usersite,U.varCity,U.varCountry,U.varCompany from " . DB_PREFIX . "product E "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users U ON U.int_id=E.intSupplier "
                . "LEFT JOIN " . DB_PREFIX . "alias AU ON U.int_id=AU.fk_Record "
                . "WHERE U.chrType='BS' and E.chrPublish='Y' and E.intSupplier='" . $id . "' and A.fk_ModuleGlCode='140' and AU.fk_ModuleGlCode='136' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc limit 20";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getProductList($id, $type) {
        $where = "";
        if ($type == 'app') {
            $where .= " and P.chrPublish='Y' ";
        } else if ($type == 'pen') {
            $where .= " and P.chrApprove='P' and P.chrPublish='N' ";
        } else if ($type == 'rej') {
            $where .= " and P.chrApprove='N' and P.chrPublish='N' ";
        }

        $price = $this->input->get_post('price');
        if ($price != '') {
            $where .= " and P.varPrice!='0' and P.varPrice!='' ";
        }
        $sql = "select P.*,A.varAlias,um.varName as PriceUnit,u.chrPayment,uum.varName as PUnitName,umq.varName as MOQUnit from " . DB_PREFIX . "product as P "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON P.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users as u ON p.intSupplier=u.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON P.intPriceUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as uum ON P.intUnit=uum.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON P.intMOQUnit=umq.int_id "
                . "WHERE P.intSupplier='" . $id . "' and A.fk_ModuleGlCode='140' $where and P.chrDelete='N' group by P.int_id order by P.varName asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getProductFavList($id) {
        $where = "";
        $where .= " and P.chrPublish='Y' ";
        $sql = "select P.*,A.varAlias,um.varName as PriceUnit,uum.varName as PUnitName,umq.varName as MOQUnit "
                . "from " . DB_PREFIX . "favourite as F "
                . "LEFT JOIN " . DB_PREFIX . "product P ON P.int_id=F.intProduct "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON P.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as um ON P.intPriceUnit=um.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as uum ON P.intUnit=uum.int_id "
                . "LEFT JOIN " . DB_PREFIX . "unit_master as umq ON P.intMOQUnit=umq.int_id "
                . "WHERE P.intSupplier='" . $id . "' and A.fk_ModuleGlCode='140' $where and P.chrDelete='N' group by P.int_id order by P.int_id desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getProductListingImageData($id) {
        $sql = "select * from " . DB_PREFIX . "productgallery where chrDelete='N' and chrPublish='Y' and fkProduct='" . $id . "'  order by int_id asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function getEventPhotos($id = '') {
        if ($id != '') {
            $sql = "select * from " . DB_PREFIX . "eventgallery WHERE chrPublish='Y' and chrDelete='N' and intEvent='" . $id . "'";
            $query = $this->db->query($sql);
            $rowdata = $query->result_array();
        } else {
            $rowdata = array();
        }
        return $rowdata;
    }

    function getCompanyCertificateData($id = '') {
        if ($id != '') {
            $sql = "select * from " . DB_PREFIX . "company_certificate WHERE intUser='" . $id . "' order by int_id asc";
            $query = $this->db->query($sql);
            $rowdata = $query->result_array();
        } else {
            $rowdata = array();
        }
        return $rowdata;
    }

    function getCompanyEventData($id = '') {
        if ($id != '') {
            $sql = "select * from " . DB_PREFIX . "tradeshow_events WHERE intUser='" . $id . "' order by int_id asc";
            $query = $this->db->query($sql);
            $rowdata = $query->result_array();
        } else {
            $rowdata = array();
        }
        return $rowdata;
    }

    function getCompanyData($id) {
        $sql = "select * from " . DB_PREFIX . "company_information WHERE chrPublish='Y' and chrDelete='N' and intUser='" . $id . "'";
        $query = $this->db->query($sql);
        $rowdata = $query->row_array();
        return $rowdata;
    }

    public function checkEmailPassword() {
        $varLoginEmail = $this->security->xss_clean($this->input->post('varLoginEmail'));
        $varLoginPassword = $this->security->xss_clean($this->input->post('varLoginPassword'));


        $cond = "varEmail = '" . $varLoginEmail . "' AND varPassword = '" . $this->mylibrary->cryptPass($varLoginPassword) . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
        $this->db->where($cond);
        $query = $this->db->get('users');
        if ($query->num_rows == 1) {
            $row = $query->row();
        } else {
            $conds = "varPhone = '" . $varLoginEmail . "' AND varPassword = '" . $this->mylibrary->cryptPass($varLoginPassword) . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
            $this->db->where($conds);
            $query = $this->db->get('users');
            $row = $query->row();
        }
//echo $this->db->last_query();exit;
        if (count($row) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function forgot_password() {
        $varLoginEmail = $this->security->xss_clean($this->input->post('forgotEmail'));
//        $email = "ashish.virtualdedos@gmail.com";
//        if (!empty($email)) {
//            $token = $this->generate_token($email);
//            $query = $this->db->get_where('users', array('varEmail' => $email, 'chrDelete' => 'N'));
//            $row = $query->row();
//            $bullateLogo = ADMIN_MEDIA_URL . "mailtemplates/images/site_arrow.png";
//            $logo = ADMIN_MEDIA_URL;
//            $siteLogo = ADMIN_MEDIA_URL . "mailtemplates/images/IndiBizz Logo new.svg";
//            $socimg = SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/';
//            $fb = $socimg . 'fb.png';
//            $tw = $socimg . 'tw.png';
//            $in = $socimg . 'in.png';
//            $to = $userRow['varPersonalEmail'];
//            if (!empty($row->varLoginEmail)) {
//                $emails = $row->varLoginEmail;
//            }
//
//            $fp_link = SITE_PATH . 'login/resetpassword?token=' . $row->varToken;
//
//            $subject = 'Reset Password : ' . SITE_NAME;
//            $body_admin = '';
//
//            $content = "The following are your login credentials. Please maintain its confidentiality to ensure security of information.";
//
//            $body .= ' <tr>
//                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
//                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Link : </strong><a href=' . $fp_link . ' target="_blank" style="color:#337ab7; text-decoration:none;">' . $fp_link . '</a></td>
//                                                                            </tr>';
//            if (FACEBOOK_LINK != '') {
//                $fbFollous .= '<td align="center"><a href="' . FACEBOOK_LINK . '" style="border:none;" title="Facebook" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/fb.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
//            } if (GOOGLE_PLUS_LINK != '') {
//                $glFollous .= '<td align="center"><a href="' . GOOGLE_PLUS_LINK . '" style="border:none;" title="Google+" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/gplus.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
//            } if (LINKEDIN_LINK != '') {
//                $liFollous .= '<td align="center"><a href="' . LINKEDIN_LINK . '" style="border:none;" title="LinkIn" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/linkedin.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
//            } if (YOUTUBE_LINK != '') {
//                $ytFollous .= '<td align="center"><a href="' . YOUTUBE_LINK . '" style="border:none;" title="Youtube" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/ytube.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
//            }
//
////        }
//            $html_message = file_get_contents(FRONT_GLOBAL_MAILTEMPLATES_PATH . "forgotpassword.html");
//            $html_message = str_replace("@CONTENT", $content, $html_message);
//            $html_message = str_replace("@MAIL_HEADER", $email_header, $html_message);
//            $html_message = str_replace("@MAIL_FOOTER", $email_footer, $html_message);
//            $html_message = str_replace("@FLOLLOW", $Follous, $html_message);
//            $html_message = str_replace("@MAIL_LEFT", '', $html_message);
//            $html_message = str_replace("@DETAILS", $body, $html_message);
//            $html_message = str_replace("@YEAR", date('Y'), $html_message);
//            $html_message = str_replace("@FACEBOOK", $fbFollous, $html_message);
//            $html_message = str_replace("@TWITTER", $twFollous, $html_message);
//            $html_message = str_replace("@YOUTUBE", $ytFollous, $html_message);
//            $html_message = str_replace("@GOOGLE+", $glFollous, $html_message);
//            $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
//            $html_message = str_replace("@SKYPE", $skFollous, $html_message);
//            $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
//            $html_message = str_replace("@NAME", "User", $html_message);
//            $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
//            $html_message = str_replace("@MEDIA_URL", FRONT_GLOBAL_MAILTEMPLATES_PATH, $html_message);
//            $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);
//            $html_message = str_replace("@LOGO", $siteLogo, $html_message);
////            echo $html_message;
////            exit;
//
//            $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
//            $headers .= "Reply-To: " . $emails . "\r\n";
//            $headers .= "Content-type: text/html\r\n";
//
//            $resp = mail($emails, $subject, $html_message, $headers);
//            $data = array(
//                'chrReceiver_Type' => 'A',
//                'fk_EmailType' => '1',
//                'varFrom' => MAIL_FROM,
//                'txtTo' => $emails,
//                'txtSubject' => $subject,
//                'txtBody' => $html_message,
//                'chrDelete' => 'N',
//                'chrPublish' => 'Y',
//                'dtCreateDate' => date('Y-m-d H:i:s'),
//            );
//
//            $this->db->insert('emails', $data);
//
//            return true;
//        }

        $cond = "varEmail = '" . $varLoginEmail . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
        $this->db->where($cond);
        $query = $this->db->get('users');
        if ($query->num_rows == 1) {
            $row = $query->row();
        } else {
            $conds = "varPhone = '" . $varLoginEmail . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
            $this->db->where($conds);
            $query = $this->db->get('users');
            $row = $query->row();
        }
//echo count($row);exit;

        if (count($row) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function generate_token($email) {
        $token = md5(uniqid(rand(), true));
        $data = array(
            'varToken' => $token,
            'tokenTimestamp' => time(),
            'chrTokenDelete' => 'N'
        );

        $this->db->where('varEmail', $email);
        $this->db->update("users", $data);

        return $token;
    }

    public function doLogin() {
        $varLoginEmail = $this->security->xss_clean($this->input->post('varLoginEmail'));
        $varLoginPassword = $this->security->xss_clean($this->input->post('varLoginPassword'));


        $cond = "varEmail = '" . $varLoginEmail . "' AND varPassword = '" . $this->mylibrary->cryptPass($varLoginPassword) . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
        $this->db->where($cond);
        $query = $this->db->get('users');
//        echo $query->num_rows;exit;
        if ($query->num_rows >= 1) {
            $row = $query->row();
        } else {
            $conds = "varPhone = '" . $varLoginEmail . "' AND varPassword = '" . $this->mylibrary->cryptPass($varLoginPassword) . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
            $this->db->where($conds);
            $query = $this->db->get('users');
            $row = $query->row();
        }

        if (count($row) == 1) {

            $data = array(
                SESSION_PREFIX . 'UserLoginUserId' => $row->int_id,
                SESSION_PREFIX . 'UserLoginEmail' => $row->varEmail,
                SESSION_PREFIX . 'UserLoginName' => $row->varName,
                SESSION_PREFIX . 'UserLoginPhone' => $row->varPhone,
                SESSION_PREFIX . 'UserLoginType' => $row->chrType,
                SESSION_PREFIX . 'UserLoginIpAddress' => $_SERVER['REMOTE_ADDR']
            );
            $this->session->set_userdata(PREFIX, $data);

            if ($this->input->get_post("chkrememberme1") != "") {
                $OneYear = 365 * 24 * 3600; // one year's time.
                $Usercookie_Info = array('varLoginEmail' => $varLoginEmail, 'time' => time(), 'varLoginPassword' => $varLoginPassword, 'takemeto' => $takemeto, 'chkrememberme1' => '1');
                $this->mylibrary->requestSetCookie('tml_CookieLogin1', $Usercookie_Info, $OneYear);
            } else {
                $this->mylibrary->requestRemoveCookie('tml_CookieLogin1');
            }
            return true;
        } else {
            return false;
        }
    }

    function getDesingnationList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "designation where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select onchange='return remove_designation_class();' id=\"intDesignation\" name=\"intDesignation\" >";
        $returnHtml .= "<option  disabled selected value=''>Select Designation*</option>";
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        $returnHtml .= '<label for="intDesignation" class="stick-label">Designation</label>';
        return $returnHtml;
    }

    function getCompanyDesingnationList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "designation where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select id=\"intDesignation\" name=\"intDesignation\" >";
        $returnHtml .= "<option  disabled selected value=''>Select Designation</option>";
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

    function getCountriesList($id = '') {
        $query = $this->db->query("select * from " . DB_PREFIX . "countries order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select onchange='return getstates(this.value)' id=\"intCountry\" name=\"intCountry\" >";
        $returnHtml .= "<option disabled selected value=''>Select Country</option>";
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

    function getStateList($country_id = '', $state_id = '') {
        if ($country_id != '0') {
            $query = $this->db->query("select * from " . DB_PREFIX . "states where intCountry='" . $country_id . "' order by varName asc");
            $Result = $query->result_array();
        } else {
            $Result = array();
        }

        $returnHtml = '';
        $returnHtml .= "<select onchange='return getcities(this.value)' id=\"intState\" name=\"intState\" >";
        $returnHtml .= "<option disabled selected value=''>Select State</option>";
        foreach ($Result as $row) {
            if ($state_id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getCityList($state_id = '', $city_id = '') {
        if ($state_id != '0') {
            $query = $this->db->query("select * from " . DB_PREFIX . "cities where intState='" . $state_id . "' order by varName asc");
            $Result = $query->result_array();
        } else {
            $Result = array();
        }

        $returnHtml = '';
        $returnHtml .= "<select id=\"intCity\" name=\"intCity\" >";
        $returnHtml .= "<option disabled selected value=''>Select City</option>";
        foreach ($Result as $row) {
            if ($city_id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
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

    function generate_seocontent_buyer_seller($fromajax = false) {
        $PageName = $this->input->post('varCompany', true);
//        if ($fromajax) {
//            $description = html_entity_decode(strip_tags($this->input->get_post('description', true)));
//        } else {
        $description = strip_tags($this->input->post('varCompany', TRUE));
//        }
        $meta_title = $PageName;
        $meta_keyword = $PageName;
        $meta_description = substr($description, 0, 400);
        $seo_data = $meta_title . '*****' . $meta_keyword . '*****' . $meta_description;
        return $seo_data;
    }

}

?>