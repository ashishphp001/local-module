<?php

class emails_model extends CI_Model {

    var $dt_createdate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $numofpages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'dtCreateDate'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of Pagesize For Paging
    var $PageNumber = '1'; // Attribute of Page Number For Paging(
    var $UrlWithPara = ''; // Attribute of URL With parameters
    var $FilterBy = '0';
    var $UrlWithoutFilter = '';
    var $display_limit_array = array('5', '10', '15', '30', 'All');
    var $dateField;

    public function __construct() {
        $this->load->database();
        $this->load->library('mylibrary');
        $mylibraryObj = new mylibrary;
        $this->ajax = $this->input->get_post('ajax');

        $this->fk_Country = COUNTRY;
        $this->fk_Website = WEBSITE;
        $this->Appendfk_Country_Site = '';
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
        $modval = $this->input->get_post('modval');

        if (!empty($Term)) {
            $SearchTxt = ($Type == 'autosearch') ? $Term : $SearchTxt;
        }

        $this->SearchByVal = (!empty($SearchByVal)) ? $SearchByVal : $this->SearchByVal;
        $this->SearchBy = (!empty($SearchBy)) ? urldecode($SearchBy) : '';
        $this->SearchTxt = (!empty($SearchTxt)) ? urldecode($SearchTxt) : '';
        $this->OrderBy = (!empty($OrderBy)) ? $OrderBy : $this->OrderBy;
        $this->OrderType = (!empty($OrderType)) ? $OrderType : $this->OrderType;
        $this->FilterBy = (!empty($FilterBy)) ? $FilterBy : $this->FilterBy;
        $this->modval = (!empty($modval)) ? $modval : $this->modval;
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
        $this->DeletePageName = MODULE_PAGE_NAME . '/delete?';

        $this->DeleteCarrierName = MODULE_PAGE_NAME . '/delete?' . $this->Appendfk_Country_Site;
        $this->HUrlWithPara = $this->PageName . '&' . 'hPageSize=' . $this->PageSize . '&hNumOfRows=' . $this->NumOfRows . '&hOrderBy=' . $this->OrderBy . '&hOrderType=' . $this->OrderType . '&hSearchBy=' . $this->SearchBy . '&hSearchTxt=' . htmlspecialchars($this->SearchTxt) . '&hPageNumber=' . $this->PageNumber . '&hFilterBy=' . $this->FilterBy . '&history=T';
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval;
        $this->UrlWithpoutSearch = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval;
        $this->UrlWithOutSort = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval;
        $this->UrlWithOutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&modval=' . $this->modval;
        $this->AutoSearchUrl = $this->UrlWithPara . "&Type=autosearch&SearchByVal=" . $this->SearchByVal . $this->Appendfk_Country_Site . '&modval=' . $this->modval;
        $this->AddUrlWithPara = $this->AddPageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval;
    }

    function generateParam($position = 'top') {
        $PageSize = $this->PageSize;
        if ($position == 'top') {
            $modcmb = $this->emailtype();
        }

        return array(
            'pageurl' => MODULE_PAGE_NAME . '?' . $this->Appendfk_Country_Site,
            'heading' => 'Manage Emails',
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'emails',
            'position' => $position,
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
            'search' => array('searchArray' => array("varFrom" => "Title"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
            'modcmb' => $modcmb
        );
    }

    function Select_All_Emails_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = " E.chrDelete ='N'";
        if (!empty($this->modval)) {
            $whereclauseids .= " and E.fk_EmailType=" . $this->modval . "";
        }

//        if ($this->PageSize != 'All') {
//            $limitby = 'LIMIT ' . $this->Start . ', ' . $this->PageSize;
//        }

        $OrderBy = 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType;
        $this->db->select('E.*,Et.Var_Type as Var_Type', false);
        $this->db->from('emails AS E', false);
        $this->db->join('emailtype AS Et', 'E.fk_EmailType = Et.Int_Glcode', 'left', false);
        $this->db->where('DATE(E.dtCreateDate) = CURDATE()');
        $this->db->where("$whereclauseids $OrderBy", NULL, FALSE);
        $rs = $this->db->get();
        $row = $rs->result_array();
        return $row;
    }

    function Yes_Select_All_Emails_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = " E.chrDelete ='N'";
        if (!empty($this->modval)) {
            $whereclauseids .= " and E.fk_EmailType=" . $this->modval . "";
        }

//        if ($this->PageSize != 'All') {
//            $limitby = 'LIMIT ' . $this->Start . ', ' . $this->PageSize;
//        }

        $OrderBy = 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType;
        $this->db->select('E.*,Et.Var_Type as Var_Type', false);
        $this->db->from('emails AS E', false);
        $this->db->join('emailtype AS Et', 'E.fk_EmailType = Et.Int_Glcode', 'left', false);
        $this->db->where('DATE(E.dtCreateDate) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE(E.dtCreateDate) < CURDATE()');
        $this->db->where("$whereclauseids $OrderBy", NULL, FALSE);
        $rs = $this->db->get();
        $row = $rs->result_array();
        return $row;
    }

    function Old_Select_All_Emails_Record() {
        $this->initialize();
        $this->Generateurl();
        $whereclauseids = " E.chrDelete ='N'";
        if (!empty($this->modval)) {
            $whereclauseids .= " and E.fk_EmailType=" . $this->modval . "";
        }

//        if ($this->PageSize != 'All') {
//            $limitby = 'LIMIT ' . $this->Start . ', ' . $this->PageSize;
//        }

        $OrderBy = 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType;
        $this->db->select('E.*,Et.Var_Type as Var_Type', false);
        $this->db->from('emails AS E', false);
        $this->db->join('emailtype AS Et', 'E.fk_EmailType = Et.Int_Glcode', 'left', false);
        $this->db->where('DATE(E.dtCreateDate) < DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
        $this->db->where("$whereclauseids $OrderBy", NULL, FALSE);
        $rs = $this->db->get();
        $row = $rs->result_array();
        return $row;
    }

    function CountRows() {
        $whereclauseids = "chrDelete ='N'";
        if (!empty($this->modval)) {
            $whereclauseids .= " and fk_EmailType=" . $this->modval . "";
        }
        if ($this->SearchTxt != '') {
            $whereclauseids .= (empty($this->SearchBy)) ? " AND varFrom like '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy like '%" . addslashes($this->SearchTxt) . "%'";
        }
        if ($this->FilterBy != '0') {
            $filterarray = explode('-', $this->FilterBy);
            if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
            }
        }
        $this->db->where($whereclauseids, Null, FALSE);
        $rs = $this->db->count_all_results('emails');
        return $rs;
    }

    function delete_row() {
        $tablename = DB_PREFIX . 'emails';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
//print_R($totaldeletedrecords);exit;
        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H-i-s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['SERVER_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'emails', 'Name' => 'varFrom', 'ModuleintGlcode' => $deletearray[$i], 'Flag' => 'D', 'Default' => 'int_id', 'fk_Country' => $this->fk_Country, 'fk_Site' => $this->fk_Website);
//          print_r($ParaArray);exit;
            $this->mylibrary->insertinlogmanager($ParaArray);
        }
    }

    function get_all_emails() {
        $sql = "select varEmail from " . DB_PREFIX . "users where chrPublish='Y' and chrDelete='N' ORDER BY varEmail ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datas=array();
//        print_r($data);exit;
        foreach ($data as $row) {
            $datas[] = $row['varEmail'];
        }
//        print_R($datas);exit;
        return $datas;
    }

    function getFreeUserEmails() {
        $sql = "select varEmail from " . DB_PREFIX . "users where chrPayment='N' and chrPublish='Y' and chrDelete='N' ORDER BY varEmail ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datas = "";
        foreach ($data as $row) {
            $datas .= $row['varEmail'] . ",";
        }
        return $datas;
    }

    function getPaidUserEmails() {
        $sql = "select varEmail from " . DB_PREFIX . "users where chrPayment='Y' and chrPublish='Y' and chrDelete='N' ORDER BY varEmail ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datas = "";
        foreach ($data as $row) {
            $datas .= $row['varEmail'] . ",";
        }
        return $datas;
    }

    function getNewsLetterUserEmails() {
        $sql = "select varEmail from " . DB_PREFIX . "newsletterleads where chrPublish='Y' and chrDelete='N' ORDER BY varEmail ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datas = "";
        foreach ($data as $row) {
            $datas .= $row['varEmail'] . ",";
        }
        return $datas;
    }

    function emailtype() {
        $selected_array = $this->modval;
        $sql = "select Var_Type,Int_Glcode from " . DB_PREFIX . "emailtype where Chr_Publish='Y' ORDER BY Var_Type ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
//         print_r($data);exit;
        $display = "";
        $display .= "<select name=\"module\" id=\"module\" class=\"form-control\" style=\"width:170px;\" onchange=\"SendGridBindRequest('$this->UrlWithPara','gridbody','MVF')\">";
        $display .= "<option value=\"0\">-- Filter By Email Type --</option>";
        foreach ($data as $row) {
//            echo $row;exit;
            $p = ($row['Int_Glcode'] == $selected_array) ? 'selected' : '';
            $display .= "<option value='" . $row['Int_Glcode'] . "' " . $p . ">" . $row['Var_Type'] . "</option>";
        }

        return $display .= "</select>";
    }

    function getEmailDetails($id) {
        $sql = "select * from " . DB_PREFIX . "emails where int_id = " . $id . "";
        $query = $this->db->query($sql);
        $exec = $query->row_array();
        $to = explode(",", $exec['txtTo']);
        $to1 = '';
        for ($i = 0; $i < count($to); $i++) {
            $to1 .= $to[$i] . "<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        $body = '<table class="test"><tr><td align="left" ><strong>From: </strong>' . $exec['varFrom'] . ' </td></tr>
                  <tr><td align="left" ><strong>To: </strong>' . $to1 . ' </td></tr>
                  <tr><td align="left" ><strong>Subject: </strong>' . $exec['txtSubject'] . ' </td></tr>
                  <tr><td align="left" ><strong>Date: </strong>' . $exec['dtCreateDate'] . ' </td></tr>
                  <tr><td align="left" ><strong>Email Details: </strong>' . $exec['txtBody'] . ' </td></tr>';

        $html_message = file_get_contents('application/modules/emails/views/adminpanel/emails_poppup_tpl.php');
        $html_message = str_replace("@body", $body, $html_message);
        return $html_message;
    }

    public function send_emails() {
        if ($_FILES['varFile']['name'] != '') {
            $filename = $_FILES['varFile']['name'];
            $filename = preg_replace('/[\/:*?"&!@#$()+%^\'<>| ]/', '', $filename);
            $fileexntension = substr(strrchr($filename, '.'), 1);
            $var_title = str_replace('.' . $fileexntension, '', $filename);
            $filename = $var_title . "_" . time() . "." . $fileexntension;
            $filename = str_replace(' ', "_", $filename);
            $filename = str_replace('%', "_", $filename);
            $Filesurl = $filename;
            $tmp_name = $_FILES["varFile"]["tmp_name"];
            $uploads_dir = 'upimages/emails/images';
            move_uploaded_file($tmp_name, $uploads_dir . "/" . $Filesurl);
        }else{
            $uploads_dir="";
        }


//print_r($_POST);exit;

        $email = $_POST['varEmails'];
        $text = $_POST['txtDescription'];
        $sub = $_POST['varSubject'];
        $attachment = $Filesurl;
//        echo $attachment;exit;
//        if (!empty($email)) {

        $bullateLogo = ADMIN_MEDIA_URL . "mailtemplates/images/site_arrow.png";
        $logo = ADMIN_MEDIA_URL;
        $siteLogo = ADMIN_MEDIA_URL . "mailtemplates/images/logo.png";
        $socimg = SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/';
        $fb = $socimg . 'fb.png';
        $tw = $socimg . 'tw.png';
        $in = $socimg . 'in.png';




        //$subject = SITE_NAME.': Update';
        $subject = $sub;
        $body_admin = '';

        $content = "Please check below updates from " . SITE_NAME . " team.";
        $body = $text;

        if (FACEBOOK_LINK != '') {
            $fbFollous .= '<td align="center"><a href="' . FACEBOOK_LINK . '" style="border:none;" title="Facebook" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/fb.png" style="border:none;margin:0 10px 0 0;" alt="Facebook"></a></td>';
        }if (TWITTER_LINK != '') {
            $ytFollous .= '<td align="center"><a href="' . TWITTER_LINK . '" style="border:none;" title="Twitter" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/twit.png" style="border:none;margin:0 10px 0 0;" alt="Twitter"></a></td>';
        } if (GOOGLE_PLUS_LINK != '') {
            $glFollous .= '<td align="center"><a href="' . GOOGLE_PLUS_LINK . '" style="border:none;" title="Google+" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/gp.png" style="border:none;margin:0 10px 0 0;" alt="Google+"></a></td>';
        } if (LINKEDIN_LINK != '') {
            $liFollous .= '<td align="center"><a href="' . LINKEDIN_LINK . '" style="border:none;" title="LinkIn" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/linkdin.png" style="border:none;margin:0 10px 0 0;" alt="LinkedIn"></a></td>';
        } if (YOUTUBE_LINK != '') {
            $ytFollous .= '<td align="center"><a href="' . YOUTUBE_LINK . '" style="border:none;" title="Youtube" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/ytube.png" style="border:none;margin:0 10px 0 0;" alt="Youtube"></a></td>';
        }


        $html_message = file_get_contents(ADMIN_MEDIA_URL . "mailtemplates/send_mail.html");
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
        $html_message = str_replace("@GOOGLE+", $glFollous, $html_message);
        $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
        $html_message = str_replace("@SKYPE", $skFollous, $html_message);
        $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
        $html_message = str_replace("@NAME", "Administrator", $html_message);
        $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
        $html_message = str_replace("@MEDIA_URL", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH, $html_message);
        $html_message = str_replace("@BGLOGO", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/header_bg.png', $html_message);
        $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);
        $html_message = str_replace("@LOGO", $siteLogo, $html_message);
//echo $html_message;exit;
//        if ($_POST['chrUser'] == 'C') {
            $email = $email;
//        } else if ($_POST['chrUser'] == 'A') {
//            $getfreeemails = $this->getFreeUserEmails();
//            $getpaidemails = $this->getPaidUserEmails();
//            $newsletteremails = $this->getNewsLetterUserEmails();
//            $email = $getfreeemails . $getpaidemails . $newsletteremails;
//        } else if ($_POST['chrUser'] == 'F') {
//            $getallemails = $this->getFreeUserEmails();
//            $email = $getallemails;
//        } else if ($_POST['chrUser'] == 'P') {
//            $getallemails = $this->getPaidUserEmails();
//            $email = $getallemails;
//        } else if ($_POST['chrUser'] == 'N') {
//            $getallemails = $this->getNewsLetterUserEmails();
//            $email = $getallemails;
//        }
        $email = implode(',', array_unique(explode(',', $email)));

        if ($email != '') {
            $emails = explode(",", $email);
            foreach ($emails as $e) {
                if (trim($e) != '') {
                    $headers = "";

                    $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
                    $headers .= "Reply-To: " . $e . "\r\n";
                    $headers .= "Content-type: text/html\r\n";

                    if ($attachment != '') {
                        $attachments = "upimages/emails/images/" . $attachment;
                    } else {
                        $attachments = "";
                    }
                    $ReplyTo="noreply@indibizz.com";
                    $forgot_pass = $this->mylibrary->send_mail($e, $subject, $html_message, $attachments,$ReplyTo);
//                   echo $forgot_pass;exit;
                    $data = array(
                        'chrReceiver_Type' => 'U',
                        'fk_EmailType' => '3',
                        'varFrom' => MAIL_FROM,
                        'txtTo' => $e,
                        'txtSubject' => $subject,
                        'txtBody' => $html_message,
                        'varAttachFile' => $attachments,
                        'chrDelete' => 'N',
                        'chrPublish' => 'Y',
                        'dtCreateDate' => date('Y-m-d H:i:s'),
                    );
//                print_r($data);exit;

                    $this->db->insert('emails', $data);
                }
            }
        }
        return true;
//        }
    }

}

?>