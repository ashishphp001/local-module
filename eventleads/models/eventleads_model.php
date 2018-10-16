<?php

class eventleads_model extends CI_Model {

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
    var $OrderBy = 'dtCreateDate'; // Attribute of Deafult Order By
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
        $this->hurlwithpara = $this->PageName . '?' . 'hpagesize=' . $this->PageSize . '&hnumofrows=' . $this->NumOfRows . '&horderby=' . $this->OrderBy . '&hordertype=' . $this->OrderType . '&hsearchby=' . $this->SearchBy . '&hsearchtxt=' . htmlspecialchars($this->SearchTxt) . '&hpagenumber=' . $this->PageNumber . '&hfilterby=' . $this->FilterBy . '&history=T' . '&mainmodule=' . 'eventleads';
        $this->UrlWithPara = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
        $this->UrlWithpoutSearch = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'eventleads';
        $this->UrlWithoutSort = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars_decode(urlencode($this->SearchTxt)) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'eventleads';
        $this->UrlWithoutPaging = $this->PageName . '?OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&FilterBy=' . $this->FilterBy . '&mainmodule=' . 'eventleads';
        $this->UrlWithoutFilter = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . $this->SearchTxt . '&mainmodule=' . 'eventleads';
        $this->AutoSearchUrl = $this->UrlWithPara . "&type=autosearch&SearchByVal=" . $this->SearchByVal . $this->Appendfk_Country_Site . '&mainmodule=' . 'eventleads';
        $this->AddUrlWithpara = $this->AddPageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . $this->Appendfk_Country_Site . '&mainmodule=' . 'eventleads';
    }

    function generateParam($position = 'top') {

        $PageSize = $this->PageSize;



        return array('PageUrl' => MODULE_PAGE_NAME,
            'heading' => 'Manage Event Leads',
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'eventleads',
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
            'search' => array('searchArray' => array("varName" => "Name", "varEmailId" => "Email ID"),
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
        $OrderBy = (isset($this->OrderBy)) ? 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType : 'ORDER BY intDisplayOrder ASC';
        $whereclauseids = "chrDelete = 'N'";

        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {
            if ($this->SearchTxt != '') {
                $whereclauseids .= (empty($this->SearchBy)) ? " AND varName LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
            } else {
                $whereclauseids .= (empty($this->SearchBy)) ? " AND varEmailId LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
            }
            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
                }
            }
        }
        $type = $this->input->get_post('type');
        if (!empty($type)) {
            if ($type == 'autosearch') {
                $OrderBy = (isset($this->OrderBy)) ? 'ORDER BY ' . $this->OrderBy . ' ' . $this->OrderType : 'ORDER BY intDisplayOrder ASC';

                $SearchByVal = " LIKE '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'  AND chrDelete = 'N'";
                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
                    $this->SearchByVal = "varName";
                    $this->SearchByVal = "varEmailId";
                }
                $this->db->select("*,$this->SearchByVal AS AutoVal");
                $this->db->from('eventleads', false);
                $this->db->where("$this->SearchByVal $SearchByVal", null, FALSE);
                $this->db->group_by("varName $OrderBy");
                $autoSearchQry = $this->db->get();
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }
        $this->db->select('*,DATE_FORMAT(dtCreateDate, "' . DEFAULT_TIMEFORMAT . '") AS Date', false);
        $this->db->from('eventleads', false);
        $this->db->where("$whereclauseids $whereclauseids1", NULL, FALSE);
        $this->db->order_by($this->OrderBy, $this->OrderType);
        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }
        $rs = $this->db->get();
        return $rs;
    }

    function CountRows() {

        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {
            if ($this->SearchTxt != '') {
                $whereclauseids .= (empty($this->SearchBy)) ? " AND varEmailId LIKE '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes($this->SearchTxt) . "%'";
                $whereclauseids .= (empty($this->SearchBy)) ? " AND varName LIKE '%" . addslashes($this->SearchTxt) . "%'" : " AND $this->SearchBy LIKE '%" . addslashes($this->SearchTxt) . "%'";
            }
            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  and  $filterarray[0] = '$filterarray[1]'";
                }
            }
        }

        $this->db->where(" chrDelete='N' $whereclauseids $whereclauseids1", Null, FALSE);
        $rs = $this->db->count_all_results('eventleads');
        return $rs;
    }

    function Delete_Row() {
        $tablename = DB_PREFIX . 'eventleads';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;
        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $ModuleData = array('chrDelete' => 'Y', 'dtModifyDate' => date('Y-m-d H:i:s'), 'PUserGlCode' => ADMIN_ID, 'varIpAddress' => $_SERVER['REMOTE_ADDR']);
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $ModuleData);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'eventleads', 'Name' => varName, 'ModuleintGlcode' => $deletearray[$i], 'Flag' => D, 'Default' => int_id, 'fk_Site' => $SiteSelected);
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
                $whereclauses .= " AND varEmailId LIKE'%" . $this->db->escape_like_str($searchdata) . "%'";
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
        if ($this->ser_id != '') {
            $whereclauseids = " and ser_id='" . $this->ser_id . "'";
        } else {
            $whereclauseids = "";
        }


        $this->db->select('*,DATE_FORMAT(dtCreateDate, "' . DEFAULT_TIMEFORMAT . '") AS Time', false);
        $this->db->from('eventleads', false);
        $this->db->where("chrDelete = 'N' $whereclauseids $whereclauses");
        if ($selectids != '') {
            $this->db->where("int_id IN($selectids)");
        }
        $this->db->order_by($this->OrderBy, $this->OrderType);
        if ($this->PageSize != 'All') {
            $this->db->limit($this->PageSize, $this->Start);
        }
        $rs = $this->db->get();
        $query = $rs->result_array();
        $site_name = str_replace(' ', '_', SITE_NAME);
        $filename = $site_name . "_eventleads_" . date("dmy-h:i") . ".xls";
        $fileprefix = "eventleads";
        $gridbind = "<table border=1>";
        $gridbind .= "<tr width=100><b><center>" . $fileprefix . "</center></b></tr>";
        $gridbind .= "<tr>";
        $gridbind .= "<th width=150>Name</th>";
        $gridbind .= "<th>Email ID</th>";
        $gridbind .= "<th>Phone</th>";
        $gridbind .= "<th>City</th>";
        $gridbind .= "<th>Remark</th>";
        $gridbind .= "<th>Date</th>";
        $gridbind .= "<th>Time</th>";
        $gridbind .= "</tr>";
        foreach ($query as $row) {
            $rowcount = 0;
            $gridbind .= "<tr>";
            $gridbind .= "<td valign='top'>" . $row["varName"] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["varEmailId"] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["varPhone"] . "</td>";

            if ($row["varCityName"] != '') {
                $gridbind .= "<td valign='top'>" . $row["varCityName"] . "</td>";
            } else {
                $gridbind .= "<td valign='top'>N/A</td>";
            }

            if ($row["txtMessage"] != '') {
                $gridbind .= "<td valign='top'>" . $row["txtMessage"] . "</td>";
            } else {
                $gridbind .= "<td valign='top'>N/A</td>";
            }

            $gridbind .= "<td valign='top'>" . date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($row['dtCreateDate'])) . "</td>";
            $gridbind .= "<td valign='top'>" . $row['Time'] . "</td>";
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
        $this->db->from('eventleads');
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
        $varCityName = $this->input->get_post('varCityName', true);
        $txtMessage = $this->input->get_post('txtMessage', true);
        $varPhone = $this->input->get_post('varPhone', true);
        $int_icr = $this->input->get_post('int_icr', true);

        if ($_FILES['varImage']['name'] != '') {


            $config['upload_path'] = 'upimages/event/images/';
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

        $brands = $this->input->get_post('brands', true);
        if ($brands == '') {
            $brands = "";
        } else {
            $brands = implode(",", $brands);
        }
        $data = array(
            'varName' => $name,
            'varEmailId' => $varEmailId,
            'varPhone' => $varPhone,
            'varImage' => $Imagesurl,
            'int_icr' => $int_icr,
            'var_brands' => $brands,
            'varCityName' => $varCityName,
            'txtMessage' => nl2br($txtMessage),
            'chrDelete' => 'N',
            'chrPublish' => 'Y',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'PUserGlCode' => "2",
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
//        print_R($data);
//        exit;
        $this->db->insert('eventleads', $data);
        $id = $this->db->insert_id();

//        $link = "https://play.google.com/store/apps/details?id=com.versatiletechno.colourbook.drawing.forkids";
        $msg = urlencode('Thanks for visiting our booth at LED Expo. For more information related to Sensors and Lights visit www.sensinova.in  /  www.steinelindia.com / www.euroliteindia.com. Or mail us at info@sensinova.in');
        $url = "http://dnd.bestvote.in/sendsms.aspx?mobile=9825033626&pass=RULCA&senderid=SENSOR&to=" . $varPhone . "&msg=" . $msg;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $this->send_contact_info($Imagesurl);
        return true;
    }

    function send_contact_info($Imagesurl = "") {
        $email_header = $this->mylibrary->get_email_header();
        $email_footer = $this->mylibrary->get_email_footer();
        $email_left = $this->mylibrary->get_email_left();
        $name = $this->input->get_post('varName', true);
        $varEmailId = $this->input->get_post('varEmailId', true);
        $varPhone = $this->input->get_post('varPhone', true);
        $subject = 'Thank you for visiting at sensinova stall';
        $body = '';


//        $body .= ' <tr>
//                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
//                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">First Name: </strong>' . $name . '</td>
//                                                                            </tr>
//                                                                            <tr>
//                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
//                                                                                <td style="font-family:Arial, Helvetica, sans-serif; color:#081832; font-size:13px;" valign="middle" height="24" align="left"><strong style="color:#333333;">Email: </strong><a title="' . $varEmailId . '" href="mailto:' . $varEmailId . '" style="color:#da2137; text-decoration:none;"> ' . $varEmailId . '</a></td>
//                                                                            </tr>
//                                                                             <tr>
//                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
//                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Phone: </strong>' . $varPhone . '</td>
//                                                                            </tr>';
        if ($Imagesurl != '') {
            $imagepath = 'upimages/event/images/' . $Imagesurl;
            $image_detail_thumb = image_thumb($imagepath, 400, 400);
//            $image_detail_thumb =     $image_detail_thumb;
            $body .= ' <tr><td><center><img src="' . $image_detail_thumb . '" ></center></td></tr>';
        }

        if (FACEBOOK_LINK != '') {
            $fbFollous = '<td align="center"><a href="' . FACEBOOK_LINK . '" style="border:none;" title="Facebook" target="_blank"><img src="' . FRONT_MEDIA_URL . 'mail/facebook.png" style="border:none;margin:0 10px 0 0;" alt="Facebook"></a></td>';
        }
        if (TWITTER_LINK != '') {
            $twFollous = '<td align="center"><a href="' . TWITTER_LINK . '" style="border:none;" title="Twitter" target="_blank"><img src="' . FRONT_MEDIA_URL . 'mail/twitter.png" style="border:none;margin:0 10px 0 0;" alt="Twitter"></a></td>';
        }
        if (GOOGLE_PLUS_LINK != '') {
            $glFollous = '<td align="center"><a href="' . GOOGLE_PLUS_LINK . '" style="border:none;" title="Google+" target="_blank"><img src="' . FRONT_MEDIA_URL . 'mail/google+.png" style="border:none;margin:0 10px 0 0;" alt="Google+"></a></td>';
        }
        $catalog = "";
        $catalog .= '<tr>
                                                                              <td style="font-family:Arial, Helvetica, sans-serif;margin:7px 0 0px 0;vertical-align: top;" valign="middle" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:3px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13">
                                                                                <strong style="color:#333333;"></strong><a target="_blank" title="Sensinova Download Catalog" href="https://www.sensinova.in/upimages/commonfiles/sensinova_1505712246.pdf" style="color:#da2137; text-decoration:none;"><strong>Sensinova</strong> Download Catalog</a></td>
                                                                            </tr>';
        $catalog .= '<tr>
                                                                              <td style="font-family:Arial, Helvetica, sans-serif;margin:7px 0 0px 0;vertical-align: top;" valign="middle" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:3px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13">
                                                                                <strong style="color:#333333;"></strong><a target="_blank" title="Steinel India Download Catalog" href="http://steinelindia.com/pdf/Steinel brochure for Exhibition.pdf" style="color:#da2137; text-decoration:none;"> <strong>Steinel India</strong> Download Catalog</a></td>
                                                                            </tr>';
//        $catalog .= "<td><a href='https://www.sensinova.in/upimages/commonfiles/sensinova_1505712246.pdf' target='_blank' style='color:#da2137; text-decoration:none;'>Sensinova Download Catalog</a>";
//        $catalog .= "<a href='http://steinelindia.com/pdf/Steinel brochure for Exhibition.pdf' target='_blank' style='color:#da2137; text-decoration:none;margin-left: 20px'>Steinel India Download Catalog</a></td>";

        $html_message = file_get_contents(FRONT_MEDIA_URL . "mail/event.html");
        $html_message = str_replace("@MAIL_HEADER", $email_header, $html_message);
        $html_message = str_replace("@MAIL_FOOTER", $email_footer, $html_message);
        $html_message = str_replace("@FLOLLOW", $Follous, $html_message);
        $html_message = str_replace("@MAIL_LEFT", '', $html_message);
        $html_message = str_replace("@DETAILS", $body, $html_message);
        $html_message = str_replace("@ADMIN", $name, $html_message);
        $html_message = str_replace("@YEAR", date('Y'), $html_message);
        $html_message = str_replace("@CATALOG", $catalog, $html_message);
        $html_message = str_replace("@FACEBOOK", $fbFollous, $html_message);
        $html_message = str_replace("@TWITTER", $twFollous, $html_message);
        $html_message = str_replace("@YOUTUBE", $ytFollous, $html_message);
        $html_message = str_replace("@GOOGLE+", $glFollous, $html_message);
        $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
        $html_message = str_replace("@SKYPE", $skFollous, $html_message);
        $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
        $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
        $html_message = str_replace("@MEDIA_URL", FRONT_MEDIA_URL, $html_message);
        $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);

        $html_message = str_replace("@LOGO", $siteLogo, $html_message);
//        echo $html_message;
//        exit;
//        $recipients = explode(',', CONTACT_US_EMAILID); // your email address
//        foreach ($recipients as $contact) {
        $resp = $this->mylibrary->send_mail($varEmailId, $subject, $html_message);
        $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
        $headers .= "Reply-To: " . $varEmailId . "\r\n";
        $headers .= "Content-type: text/html\r\n";
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

    function getCitiesRecords() {
        $this->db->select('*');
        $this->db->from('sn_cities');
        $this->db->order_by('city_name', 'ASD');
        $res_pages = $this->db->get();
        $display_output = '<select class="form-control" name="varCityName" id="varCityName" style="height: 40px;">';
        $display_output .= "<option value=''>Select City</option>";
        foreach ($res_pages->result_array() as $row) {
            $cityname = str_replace('"', "", $row['city_name']);
            $cityname = trim($cityname);
            $display_output .= "<option value='" . $cityname . "'>" . $cityname . "</option>";
        }
        $display_output .= "</select>";
        return $display_output;
    }

}

?>