<?php

class payments_model extends CI_Model {

    var $int_id;
    var $ParentPage_Id;
    var $varTitle;
    var $Var_Alias;
    var $Text_Fulltext;
    var $varMetaTitle;
    var $varMetaKeyword;
    var $varMetaDescription;
    var $intDisplayOrder;
    var $chrPublish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dtCreateDate;   // (normal Attribute)
    var $dtModifyDate;   // (normal Attribute)
    var $oldInt_DisplayOrder; // Attribute of Old Displayorder
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $NumOfPages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'u.dtCreateDate'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 0; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of PageSize For Paging
    var $PageNumber = '1'; // Attribute of Page Number For Paging(
    var $UrlWithPara = ''; // Attribute of URL With parameters
    var $UrlWithpoutSearch = ''; // Attribute of URL With parameters without searh
    var $UrlWithoutSort = ''; // Attribute of URL With parameters without sort
    var $UrlWithoutPaging = ''; // Attribute of URL With parameters without paging
    var $FilterBy = '0';
    var $UrlWithoutFilter = '';
    var $Display_Limit_Array = array('5', '10', '15', '30', 'All');
    var $DateField;
    var $NoOfPages;
    var $SearchByVal;
    var $AutoSearchUrl;
    var $SortVar;

    public function __construct() {
        $this->ajax = $this->input->get_post('ajax');
        $this->ser_id = $this->input->get_post('ser_id');
        $this->load->helper(array('form', 'url'));
        $this->module_url = MODULE_URL;
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
        $term = $this->input->get_post('term');
        $SearchByVal = $this->input->get_post('SearchByVal');
        $SearchTxt = $this->input->get_post('SearchTxt');
        $SearchBy = $this->input->get_post('SearchBy');
        $type = $this->input->get_post('type');
        $OrderType = $this->input->get_post('OrderType');
        $FilterBy = $this->input->get_post('FilterBy');
        $PageSize = $this->input->get_post('PageSize');
        $PageNumber = $this->input->get_post('PageNumber');
        $OrderBy = $this->input->get_post('OrderBy');
        if (!empty($term)) {
            $SearchTxt = ($type == 'autosearch') ? $term : $SearchTxt;
        }
        $this->SearchByVal = (!empty($SearchByVal)) ? $SearchByVal : $this->SearchByVal;
        $this->SearchBy = (!empty($SearchBy)) ? urldecode($SearchBy) : '';
        $this->SearchTxt = (!empty($SearchTxt)) ? urldecode($SearchTxt) : '';
        $this->OrderBy = (!empty($OrderBy)) ? $OrderBy : $this->OrderBy;
        $this->OrderType = (!empty($OrderType)) ? $OrderType : $this->OrderType;
        $this->FilterBy = (!empty($FilterBy)) ? $FilterBy : $this->FilterBy;
        if ($this->input->get_post('sorting') == 'Y') {
            if ($this->OrderType == "asc") {   // This is for sort image
                $this->OrderType = "desc";
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-down.png\" style=\"vertical-align:middle;\">";
            } else if ($this->OrderType == "desc") {   // This is for sort image
                $this->OrderType = "asc";
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-up.png\" style=\"vertical-align:middle;\">";
            }
        } else {
            if ($this->OrderType == "asc") {   // This is for sort image
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-up.png\" style=\"vertical-align:middle;\">";
            } else if ($this->OrderType == "desc") {   // This is for sort image
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
        $this->PageName = MODULE_PAGE_NAME;
        $this->AddPageName = MODULE_PAGE_NAME . '/add';
        $this->DeletePageName = MODULE_PAGE_NAME . '/Delete?';
        $ser_id = '&ser_id=' . $this->ser_id;
        $this->hurlwithpara = $this->PageName . '?' . 'hpagesize=' . $this->PageSize . '&hnumofrows=' . $this->NumOfRows . '&horderby=' . $this->OrderBy . '&hordertype=' . $this->OrderType . '&hsearchby=' . $this->SearchBy . '&hsearchtxt=' . htmlspecialchars($this->SearchTxt) . '&hpagenumber=' . $this->PageNumber . '&hfilterby=' . $this->FilterBy . '&history=T' . '&mainmodule=' . 'payments';
        $this->UrlWithPara = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'payments';
        $this->UrlWithoutSort = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars_decode(urlencode($this->SearchTxt)) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'payments';
        $this->UrlWithoutPaging = $this->PageName . '?OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'payments';
        $this->UrlWithoutFilter = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&mainmodule=' . 'payments';
        $this->AutoSearchUrl = $this->UrlWithPara . "&type=autosearch&SearchByVal=" . $this->SearchByVal . $this->Appendfk_Country_Site . '&mainmodule=' . 'payments';
        $this->AddUrlWithpara = $this->AddPageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . $this->Appendfk_Country_Site . '&mainmodule=' . 'payments';
    }

    function generateParam($position = 'top') {

        $PageSize = $this->PageSize;



        return array('PageUrl' => MODULE_PAGE_NAME,
            'heading' => 'Manage Contact Inquiry Leads',
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'users',
            'position' => $position,
            'actionImage' => 'add-new-button-blue.gif',
            'actionImageHover' => 'add-new-button-blue-hover.gif',
//            'actionUrl' => MODULE_PAGE_NAME . '/add?&PageSize=' . $PageSize . '&fk_Service=' . $_REQUEST['fk_Service'],
            'dispPaging' => 'Yes',
            'AutoSearchUrl' => $this->AutoSearchUrl,
            'display' => array('DisplayUrl' => $this->UrlWithoutPaging,
                'PageSize' => $this->PageSize,
                'LimitArray' => $this->Display_Limit_Array,
            ),
            'paging' => array(
                'PageNumber' => $this->PageNumber,
                'NoOfPages' => $this->NoOfPages,
                'NumOfRows' => $this->NumOfRows,
                'PagingUrl' => $this->UrlWithPara
            ),
            'search' => array('searchArray' => array("varName" => "Name"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
            'fk_Service' => $fk_Service,
        );
    }

    function SelectAll() {
        $this->initialize();
        $this->Generateurl();
        $OrderBy = (isset($this->OrderBy)) ? 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType : 'ORDER BY u.dtCreateDate ASC';
        $whereclauseids = "u.chrDelete = 'N' and u.chrPayment='Y'";


        $this->db->select('*,u.varName as UserName,pu.varName as PaymentUser,pt.varName as PaymentType,p.varName as PlanName,p.varName as PlanName,DATE_FORMAT(u.dtCreateDate, "' . DEFAULT_TIMEFORMAT . '") AS Date,DATE_FORMAT(u.varPaymentDate, "' . DEFAULT_TIMEFORMAT . '") AS Time', false);
        $this->db->from('users as u', false);
        $this->db->join('plans AS p', 'p.int_id = u.intPlan', 'left', false);
        $this->db->join('payment_types AS pt', 'pt.int_id = u.intPayment', 'left', false);
        $this->db->join('adminpanelusers AS pu', 'pu.int_id = u.intPaymentUser', 'left', false);
        $this->db->where("$whereclauseids", NULL, FALSE);
        $this->db->order_by($this->OrderBy, $this->OrderType);
        $rs = $this->db->get();
        return $rs;
    }

    function CountRows() {

        $this->db->where(" chrDelete='N'", Null, FALSE);
        $rs = $this->db->count_all_results('users');
        return $rs;
    }

    function Delete_Row() {
        $tablename = DB_PREFIX . 'users';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $ModuleData = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $ModuleData);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'users', 'Name' => varName, 'ModuleintGlcode' => $deletearray[$i], 'Flag' => D, 'Default' => int_id, 'fk_Site' => $SiteSelected);
            $this->mylibrary->insertinlogmanager($ParaArray);
        }
    }

    function Export() {

        $this->load->helper('csv');
        $selectids = $this->input->get_post('chkids');
        $selectarray = explode(',', $selectids);
        $totaldeletedrecords = count($selectarray);
        $exportarry = array();
        $whereclauses = '';
        if ($this->input->get_post('searchtxt_ids', TRUE) != '') {
            $searchdata .= $this->input->get_post('searchtxt_ids', TRUE);
            if ($this->input->get_post('SearchBy', TRUE) == 'varName') {
                $whereclauses .= " AND varName LIKE'%" . $this->db->escape_like_str($searchdata) . "%'";
            } else {
                $whereclauses .= " AND varEmail LIKE'%" . $this->db->escape_like_str($searchdata) . "%'";
            }
        } else {
            $whereclauses .= "";
        }
        if ($this->input->get_post('orderby') != '' && $this->input->get_post('ordertype') != '') {
            $type = "";
            if ($this->input->get_post('ordertype') == 'ASC' || $this->input->get_post('ordertype') == 'asc') {
                $type = " DESC";
            }
            if ($this->input->get_post('ordertype') == 'DESC' || $this->input->get_post('ordertype') == 'desc') {
                $type = " ASC";
            }
            $orderby = $this->input->get_post('orderby');
        } else {
            $orderby = 'dtCreateDate';
            $type = " DESC";
        }
        if (DEFAULT_DATEFORMAT == '%M/%d/%Y') {
            $dateformat = "%b/%d/%Y";
        } else {
            $dateformat = DEFAULT_DATEFORMAT;
        }


        $whereclauseids = "u.chrDelete = 'N' and u.chrPayment='Y'";


        $this->db->select('*,u.varName as UserName,pu.varName as PaymentUser,pt.varName as PaymentType,p.varName as PlanName,p.varName as PlanName,DATE_FORMAT(u.dtCreateDate, "' . DEFAULT_TIMEFORMAT . '") AS Date,DATE_FORMAT(u.varPaymentDate, "' . DEFAULT_TIMEFORMAT . '") AS Time', false);
        $this->db->from('users as u', false);
        $this->db->join('plans AS p', 'p.int_id = u.intPlan', 'left', false);
        $this->db->join('payment_types AS pt', 'pt.int_id = u.intPayment', 'left', false);
        $this->db->join('adminpanelusers AS pu', 'pu.int_id = u.intPaymentUser', 'left', false);
        $this->db->where("$whereclauseids", NULL, FALSE);
        if ($selectids != '') {
            $this->db->where("int_id IN($selectids)");
        }
        $this->db->order_by($this->OrderBy, $this->OrderType);
        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }
        $rs = $this->db->get();
//        echo $this->db->last_query();
//        exit;
        $query = $rs->result_array();
        $site_name = str_replace(' ', '_', SITE_NAME);
        $filename = $site_name . "_payment_users_" . date("dmy-h:i") . ".xls";
        $fileprefix = "users";
        $gridbind = "<table border=1>";
        $gridbind .= "<tr width=100><b><center>" . $fileprefix . "</center></b></tr>";
        $gridbind .= "<tr>";
        $gridbind .= "<th width=150>Name</th>";
        $gridbind .= "<th>Referral No</th>";
        $gridbind .= "<th>Payment Date</th>";
        $gridbind .= "<th>Payment Type</th>";
        $gridbind .= "<th>Payment By</th>";
        $gridbind .= "<th>Company Name</th>";
        $gridbind .= "<th>Email ID</th>";
        $gridbind .= "<th>Phone</th>";
        $gridbind .= "<th>Message</th>";
        $gridbind .= "<th>Date</th>";
        $gridbind .= "<th>Time</th>";
        $gridbind .= "</tr>";
        foreach ($query as $row) {
            $rowcount = 0;
            $gridbind .= "<tr>";
            $gridbind .= "<td valign='top'>" . $row["varName"] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["varReferralNo"] . "</td>";
            $gridbind .= "<td valign='top'>" . date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($row['varPaymentDate'])) . ' ' . $row['Time'] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["PaymentType"] . "</td>";

            if ($row['PaymentUser'] != '0') {
                $gridbind .= "<td valign='top'>" . $row['PaymentUser'] . "</td>";
            } else {
                $gridbind .= "<td valign='top'>Website</td>";
            }
            $gridbind .= "<td valign='top'>" . $row["varCompany"] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["varEmail"] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["varPhone"] . "</td>";


            if ($row["txtMessage"] != '') {
                $gridbind .= "<td valign='top'>" . $row["txtMessage"] . "</td>";
            } else {
                $gridbind .= "<td valign='top'>N/A</td>";
            }

            $gridbind .= "<td valign='top'>" . date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($row['dtCreateDate'])) . "</td>";
            $gridbind .= "<td valign='top'>" . date(str_replace('%', '', DEFAULT_TIMEFORMAT), strtotime($row['dtCreateDate'])) . "</td>";
            $gridbind .= "</tr>";
            $rowcount_a++;
        }
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

    function ContactLeadsData() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($wherecondtion);
        $this->db->limit(5, 0);
        $Query = $this->db->get();
        return $Query;
    }

    function getProductName() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('varShortName');
        $this->db->from('products');
        $this->db->where($wherecondtion);
        $Query = $this->db->get();
        $data = $Query->row_array();
        return $data;
    }

    function process() {
        $name = $this->input->get_post('varName', true);
        $varEmailId = $this->input->get_post('varEmailId', true);
        $varPhone = $this->input->get_post('varPhone', true);
        $varSkype = $this->input->get_post('varSkype', true);
        $txtMessage = strip_tags($this->input->get_post('txtMessage', true));
        $data = array(
            'varName' => $name,
            'varEmailId' => $varEmailId,
            'varPhone' => $varPhone,
            'txtMessage' => $txtMessage,
            'varSkype' => $varSkype,
            'chrDelete' => 'N',
            'chrPublish' => 'Y',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'PUserGlCode' => "2",
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
//        print_R($data);exit;
        $this->db->insert('users', $data);
        $id = $this->db->insert_id();
//        $this->send_contact_info();
        return true;
    }

    function send_contact_info() {
//        $email_header = $this->mylibrary->get_email_header();
//        $email_footer = $this->mylibrary->get_email_footer();
//        $email_left = $this->mylibrary->get_email_left();
        $name = $this->input->get_post('varName', true);
        $varEmailId = $this->input->get_post('varEmailId', true);
        $varPhone = $this->input->get_post('varPhone', true);
        $varSkype = $this->input->get_post('varSkype', true);
        $varMessage = nl2br(strip_tags($this->input->get_post('txtMessage', true)));
        $subject = 'New Contact Inquiry Received';
        $body = '';

        $bullateLogo = ADMIN_MEDIA_URL . "mailtemplates/images/site_arrow.png";
        $logo = ADMIN_MEDIA_URL;
        $siteLogo = ADMIN_MEDIA_URL . "mailtemplates/images/kepl-logo.png";
        $socimg = SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/';

        $body .= ' <tr>
    <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">First Name: </strong>' . $name . '</td>
</tr>
<tr>
    <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
    <td style="font-family:Arial, Helvetica, sans-serif; color:#081832; font-size:13px;" valign="middle" height="24" align="left"><strong style="color:#333333;">Email: </strong><a title="' . $varEmailId . '" href="mailto:' . $varEmailId . '" style="color:#da2137; text-decoration:none;"> ' . $varEmailId . '</a></td>
</tr>
<tr>
    <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Phone: </strong>' . $varPhone . '</td>
</tr>';
        if ($varSkype != '') {
            $body .= '<tr>
    <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:6px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">City: </strong>' . $varSkype . '</td>
</tr>';
        }

        $body .= '<tr>
    <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:6px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Message: </strong>' . $varMessage . '</td>
</tr>';




        if (FACEBOOK_LINK != '') {
            $fbFollous = '<td align="center"><a href="' . FACEBOOK_LINK . '" style="border:none;" title="Facebook" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/fb.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
        }
//        if (GOOGLE_PLUS_LINK != '') {
//            $glFollous .= '<td align="center"><a href="' . GOOGLE_PLUS_LINK . '" style="border:none;" title="Google+" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/gplus.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
//            $glFollous = "";
//        } if (LINKEDIN_LINK != '') {
//            $liFollous .= '<td align="center"><a href="' . LINKEDIN_LINK . '" style="border:none;" title="LinkIn" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/linkedin.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
//        } if (YOUTUBE_LINK != '') {
        $ytFollous = "";
//            $ytFollous .= '<td align="center"><a href="' . YOUTUBE_LINK . '" style="border:none;" title="Youtube" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/ytube.png" style="border:none;margin:0 10px 0 0;" alt="Blogger"></a></td>';
//        }

        $content = "A new person has enquired in contact us, below are the details of that person.";
        $html_message = file_get_contents(ADMIN_MEDIA_URL . "mailtemplates/forgot_password.html");
        $html_message = str_replace("@CONTENT", $content, $html_message);
        $html_message = str_replace("@MAIL_HEADER", $email_header, $html_message);
        $html_message = str_replace("@MAIL_FOOTER", $email_footer, $html_message);
        $html_message = str_replace("@FLOLLOW", $Follous, $html_message);
        $html_message = str_replace("@MAIL_LEFT", '', $html_message);
        $html_message = str_replace("@DETAILS", $body, $html_message);
        $html_message = str_replace("@YEAR", date('Y'), $html_message);
        $html_message = str_replace("@FACEBOOK", $fbFollous, $html_message);
//        $html_message = str_replace("@TWITTER", $twFollous, $html_message);
//        $html_message = str_replace("@YOUTUBE", $ytFollous, $html_message);
//        $html_message = str_replace("@GOOGLE+", $glFollous, $html_message);
//        $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
        $html_message = str_replace("@SKYPE", $skFollous, $html_message);
        $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
        $html_message = str_replace("@NAME", "Administrator", $html_message);
        $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
        $html_message = str_replace("@MEDIA_URL", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH, $html_message);
        $html_message = str_replace("@BGLOGO", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/header_bg.png', $html_message);
        $html_message = str_replace("@LOGO", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/logo.png', $html_message);
        $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);
        $html_message = str_replace("@LOGO", $siteLogo, $html_message);

//        echo CONTACT_US_EMAILID;
//        echo $html_message;
//        exit;
//        $recipients = explode(',', CONTACT_US_EMAILID); // your email address
//        foreach ($recipients as $contact) {
//        $headers = 'From: ' . SITE_NAME . "\r\n" .
//                'Reply-To: ' . MAIL_FROM . "\r\n" .
//                'X-Mailer: PHP/' . phpversion();
//        $headers .= "Content-type: text/html\r\n";
//
//        $resp = mail(CONTACT_US_EMAILID, $subject, $html_message, $headers);
//        if ($resp)
//            echo "yes";
//        else
//            echo "no";
//        echo $html_message;
//        exit;
        $emailaa = CONTACT_US_EMAILID;
        $resp = $this->mylibrary->send_mail($emailaa, $subject, $html_message);
//        $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
//        $headers .= "Reply-To: " . $varEmailId . "\r\n";
//        $headers .= "Content-type: text/html\r\n";
//        echo $resp;
//        if ($resp)
//            echo "yes";
//        else
//            echo "no";
//        echo $html_message;
//        exit;
//        }
        if ($resp == 'success') {
            $data = array(
                'chrReceiver_Type' => 'C',
                'fk_EmailType' => '2',
                'varFrom' => MAIL_FROM,
                'txtTo' => CONTACT_US_EMAILID,
                'txtSubject' => $subject,
                'txtBody' => $html_message,
                'chrDelete' => 'N',
                'chrPublish' => 'Y',
                'dtCreateDate' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('emails', $data);
            return true;
//             echo "yes";
        } else {
            return false;
//            echo "no";
        }
//        exit;
    }

}
?>