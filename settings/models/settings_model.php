<?php

class settings_model extends CI_Model {

    var $int_id;
    var $Fk_Pages;
    var $Var_PageName;
    var $Var_Alias;
    var $Text_Fulltext;
    var $Var_Metatitle;
    var $Var_Metakeyword;
    var $Var_Metadescription;
    var $intDisplayOrder;
    var $chr_access = 'P';
    var $dtCreateDate;   // (normal Attribute)
    var $dtOperationDate;   // (normal Attribute)
    var $oldInt_DisplayOrder; // Attribute of Old Displayorder
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $NumOfPages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'dtOperationDate'; // Attribute of Deafult Order By
    var $OrderType = 'desc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of PageSize For Paging
    var $PageNumber = '1'; // Attribute of Page Number For Paging(
    var $lastinsertid; // Attribute of Last Inserid
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
    var $modval = 0;
    var $chr_action = '';

    public function __construct() {
        $this->load->database();
        $this->load->library('mylibrary');
        $mylibraryObj = new mylibrary;

        /* Declare it in every module */
        $this->module_url = MODULE_URL;
    }

    function PagingTop() {
        $content['pagingtop'] = $this->mylibrary->generatePagingPannel($this->generateParam('top'));
        return $content['pagingtop'];
    }

    function PagingBottom() {
        $content['pagingbottom'] = $this->mylibrary->generatePagingPannel($this->generateParam('bottom'));
        return $content['pagingbottom'];
    }

    function Initialize() {
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
        $modval = $this->input->get_post('modval');
//        echo $modval;
        if (!empty($term)) {
            $SearchTxt = ($type == 'autosearch') ? $term : $SearchTxt;
        }
        $this->SearchByVal = (!empty($SearchByVal)) ? $SearchByVal : $this->SearchByVal;
        $this->SearchBy = (!empty($SearchBy)) ? urldecode($SearchBy) : '';
        $this->SearchTxt = (!empty($SearchTxt)) ? urldecode($SearchTxt) : '';
        $this->OrderBy = (!empty($OrderBy)) ? $OrderBy : $this->OrderBy;
        $this->OrderType = (!empty($OrderType)) ? $OrderType : $this->OrderType;
        $this->FilterBy = (!empty($FilterBy)) ? $FilterBy : $this->FilterBy;
        $this->modval = (!empty($modval)) ? $modval : $this->modval;



        if ($this->input->get_post('sorting') == 'Y') {
            if ($this->OrderType == "asc") { // This is for sort image
                $this->OrderType = "desc";
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-down.png\" style=\"vertical-align:middle;\">";
            } else if ($this->OrderType == "desc") { // This is for sort image
                $this->OrderType = "asc";
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-up.png\" style=\"vertical-align:middle;\">";
            }
        } else {
            if ($this->OrderType == "asc") { // This is for sort image
                $this->SortVar = "<img alt=\"sorting\" src=\"" . ADMIN_MEDIA_URL_DEFAULT . "images/arrow-up.png\" style=\"vertical-align:middle;\">";
            } else if ($this->OrderType == "desc") {  // This is for sort image
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

    function GenerateUrl() {
        $view_request = $this->input->get_post('view');
        $modval_request = $this->input->get_post('modval');

        if (!empty($view_request)) {
            $view = '&view=' . $_REQUEST['view'];
        } else {
            $view = 0;
        }

        if (!empty($modval_request)) {
            $this->modval = $modval_request;
        } else {
            $this->modval = $this->modval;
        }

        $this->PageName = MODULE_PAGE_NAME . '?';
        $this->AddPageName = MODULE_PAGE_NAME . '/systemsettings?';
        $this->DeletePageName = MODULE_URL . 'Delete?';
        $this->UrlWithPara = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . '&chr_action=' . $this->chr_action . $view . '&modval=' . $this->modval;
        $this->UrlWithLogPara = MODULE_URL . 'logmanager?' . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&modval=' . $this->modval . '&FilterBy=' . $this->FilterBy . '&chr_action=' . $this->chr_action . $view;
        $this->HurlWithPara = $this->PageName . '&' . 'hpagesize=' . $this->PageSize . '&hnumofrows=' . $this->NumOfRows . '&horderby=' . $this->OrderBy . '&hordertype=' . $this->OrderType . '&hsearchby=' . $this->SearchBy . '&hsearchtxt=' . urlencode($this->SearchTxt) . '&hpagenumber=' . $this->PageNumber . '&modval=' . $this->modval . '&hfilterby=' . $this->FilterBy . '&history=T' . '&chr_action=' . $this->chr_action . $view;
        $this->UrlWithpoutSearch = MODULE_URL . 'logmanager?' . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval . '&chr_action=' . $this->chr_action . '&' . $view;
        $this->UrlWithoutSort = MODULE_URL . 'logmanager?' . '&' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&OrderType=' . $this->OrderType . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval . '&chr_action=' . $this->chr_action . $view;
        $this->UrlWithoutPaging = $this->PageName . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval . '&chr_action=' . $this->chr_action . $view;
        $this->UrlWithoutFilter = $this->PageName . '&' . 'PageSize=' . $this->PageSize . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&modval=' . $this->modval . '&chr_action=' . $this->chr_action . $view;
        $this->UrlWithoutModuleid = $this->PageName . '&PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&chr_action=' . $this->chr_action . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval . '&chr_action=' . $this->chr_action . $view;
        $this->AutoSearchUrl = $this->UrlWithLogPara . "&type=autosearch&SearchByVal=" . $this->SearchByVal . '&chr_action=' . $this->chr_action . $view;
        $this->AutoSearchUrl = $this->UrlWithLogPara . "&type=autosearch&SearchByVal=" . $this->SearchByVal;
        $this->UrlWithoutModuleid = ADMINPANEL_URL . 'settings/systemsettings?' . '&PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy . '&modval=' . $this->modval . $view;
        $this->UrlSearchWithPagging = '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . urlencode($this->SearchTxt);
    }

    function generateParam($position = 'top') {
        if ($position == 'top') {
            $modcmb = $this->BindModule();
        }

        $segment = $this->uri->segment(3);
        if (!empty($segment)) {
            if ($segment == 'delete') {
                $pagename = MODULE_PAGE_NAME . '/logmanager?';
            } else {
                $pagename = MODULE_PAGE_NAME . '/' . $this->uri->segment(3) . '?';
            }
        } else {
            $pagename = MODULE_PAGE_NAME;
        }

        return array(
            'PageUrl' => MODULE_URL . 'logmanager',
            'heading' => 'Log Manager',
            'listImage' => 'add-new-user-icon.png',
            'tablename' => DB_PREFIX . 'logmanager',
            'position' => $position,
            'actionImage' => 'add-new-button-blue.gif',
            'actionImageHover' => 'add-new-button-blue-hover.gif',
            'actionUrl' => MODULE_PAGE_NAME,
            'dispPaging' => 'Yes',
            'AutoSearchUrl' => $this->AutoSearchUrl,
            'display' => array('DisplayUrl' => $pagename . '&modval=' . $this->modval,
                'PageSize' => $this->PageSize,
                'LimitArray' => $this->Display_Limit_Array,
            ),
            'paging' => array('PageNumber' => $this->PageNumber,
                'NoOfPages' => $this->NoOfPages,
                'NumOfRows' => $this->NumOfRows,
                'PagingUrl' => $this->UrlWithLogPara
            ),
            'search' => array('searchArray' => array("varModuleName" => "Module Name", "varName" => "Title", "varIpAddress" => "Ip Address"),
                'SearchBy' => $this->SearchBy,
                'SearchText' => $this->SearchTxt,
                'SearchUrl' => $this->UrlWithpoutSearch
            ),
            'modcmb' => $modcmb,
        );
    }

    function HeaderPanel() {
        $content['headerpanel'] = $this->mylibrary->generateHeaderPanel($this->generateParam(), 'no');
        return $content['headerpanel'];
    }

    function Edit_SystemSettings() {
        $this->db->cache_set_common_path("application/cache/db/common/constants/");
        $this->db->cache_delete();

        if ($this->input->get_post('p') == "gen") {
            $Data = array(
                'varSiteName' => $this->input->get_post('varSiteName', TRUE),
                'varSitePath' => $this->input->get_post('varSitePath', TRUE),
                'varAdminpanelPagesize' => $this->input->get_post('varAdminpanelPagesize', TRUE),
                'varFrontPagesize' => $this->input->get_post('varFrontPagesize', TRUE),
                'varAdminpanelDateFormat' => $this->input->get_post('varAdminpanelDateFormat'),
                'varAdminpanelTimeFormat' => $this->input->get_post('varAdminpanelTimeFormat'),
                'varFrontDateFormat' => $this->input->get_post('varFrontDateFormat'),
                'varFrontDateFormat' => $this->input->get_post('varFrontDateFormat'),
                'chrDropboxBeta' => $this->input->get_post('chrDropboxBeta'),
                'varClientSignIn' => $this->input->get_post('varClientSignIn', TRUE),
                'varAgentSignIn' => $this->input->get_post('varAgentSignIn', TRUE),
                'varDropboxBetaSk' => $this->input->get_post('varDropboxBetaSk', TRUE),
                'varDropboxLiveSk' => $this->input->get_post('varDropboxLiveSk', TRUE)
            );

            foreach ($Data as $Key => $Value) {
                $ParaArray = array('Data' => $Data, 'Value' => $Value, 'Key' => $Key);
                $this->Update_GeneralSettings($ParaArray);
            }
        }

        if ($this->input->get_post('p') == "ser") {

            $CryptPwd = $this->mylibrary->cryptPass($this->input->get_post('varSmtpPassword', TRUE));
            $Data = array(
                'varSmtpServer' => $this->input->get_post('varSmtpServer', TRUE),
                'varSmtpUserName' => $this->input->get_post('varSmtpUserName', TRUE),
                'varSmtpPassword' => $CryptPwd,
                'chrSmtpAuthentication' => $this->input->get_post('chrSmtpAuthentication', TRUE),
                'varSmtpPort' => $this->input->get_post('varSmtpPort', TRUE),
                'varSenderName' => $this->input->get_post('varSenderName', TRUE),
                'varMailer' => $this->input->get_post('varMailer', TRUE),
                'varSenderEmail' => $this->input->get_post('varSenderEmail', TRUE),
                'varEmailSignature' => $this->input->get_post('varEmailSignature'),
            );

            foreach ($Data as $Key => $Value) {
                $ParaArray = array('Data' => $Data, 'Value' => $Value, 'Key' => $Key);
                $this->Update_GeneralSettings($ParaArray);
            }
        }
        if ($this->input->get_post('p') == "soc") {
            $Data = array('varFacebookLink' => $this->input->get_post('varFacebookLink', TRUE),
                'varGithubLink' => $this->input->get_post('varGithubLink', TRUE),
                'varInstagramLink' => $this->input->get_post('varInstagramLink', TRUE),
                'varTwitterLink' => $this->input->get_post('varTwitterLink', TRUE),
                'varGooglePlusLink' => $this->input->get_post('varGooglePlusLink', TRUE),
                'varLinkedInLink' => $this->input->get_post('varLinkedInLink', TRUE));

            foreach ($Data as $Key => $Value) {
                $ParaArray = array('Data' => $Data, 'Value' => $Value, 'Key' => $Key);
                $this->Update_GeneralSettings($ParaArray);
            }
        }


        if ($this->input->get_post('p') == "seo") {
            $Data = array(
                'varGoogleanAlyticcode' => $this->input->get_post('varGoogleanAlyticcode'),
                'VarMetaTitle' => $this->input->get_post('VarMetaTitle', TRUE),
                'VarMetaKeyword' => $this->input->get_post('VarMetaKeyword', TRUE),
                'VarMetaDescription' => $this->input->get_post('VarMetaDescription', TRUE),
                'varCommonMetatags' => $this->input->get_post('varCommonMetatags'),
            );

            foreach ($Data as $Key => $Value) {
                $ParaArray = array('Data' => $Data, 'Value' => $Value, 'Key' => $Key);
                $this->Update_GeneralSettings($ParaArray);
            }
        }

        if ($this->input->get_post('p') == "fac") {

            $varFACMId = $this->input->get_post('varFACMId', TRUE);
            $varFACPassKey = $this->input->get_post('varFACPassKey', TRUE);
            $varFACAcquirerId = $this->input->get_post('varFACAcquirerId', TRUE);

            $Data = array(
                'chrFacTestMode' => $this->input->get_post('chrFacTestMode', true) == 'Y' ? 'Y' : 'N',
                'varFACMId' => $this->encrypt->encode($varFACMId, API_KEY),
                'varFACPassKey' => $this->encrypt->encode($varFACPassKey, API_KEY),
                'varFACAcquirerId' => $this->encrypt->encode($varFACAcquirerId, API_KEY),
                'intFACKYDCurrencyCode' => $this->input->get_post('intFACKYDCurrencyCode', TRUE),
                'intFACUSDCurrencyCode' => $this->input->get_post('intFACUSDCurrencyCode', TRUE),
                'intCItoUSConversionRate' => $this->input->get_post('intCItoUSConversionRate', TRUE),
                'intUStoCIConversionRate' => $this->input->get_post('intUStoCIConversionRate', TRUE),
            );


            foreach ($Data as $Key => $Value) {
                $ParaArray = array('Data' => $Data, 'Value' => $Value, 'Key' => $Key);
                $this->Update_GeneralSettings($ParaArray);
            }
        }
        if ($this->input->get_post('p') == "thumb") {
            $Data = array(
                'varHomeBannerThumb' => $this->input->get_post('varHomeBannerThumb', TRUE),
                'varInnerBannerThumb' => $this->input->get_post('varInnerBannerThumb', TRUE),
                'varBlogThumb' => $this->input->get_post('varBlogThumb', TRUE),
                'varBlogDetailThumb' => $this->input->get_post('varBlogDetailThumb', TRUE),
                'varCareerThumb' => $this->input->get_post('varCareerThumb', TRUE),
                'varProductCategoryThumb' => $this->input->get_post('varProductCategoryThumb', TRUE),
                'varProductThumb' => $this->input->get_post('varProductThumb', TRUE),
                'varPlanThumb' => $this->input->get_post('varPlanThumb', TRUE),
                'varBuyLeadThumb' => $this->input->get_post('varBuyLeadThumb', TRUE),
                'varSellLeadThumb' => $this->input->get_post('varSellLeadThumb', TRUE),
                'varServiceThumb' => $this->input->get_post('varServiceThumb', TRUE),
                'varUserThumb' => $this->input->get_post('varUserThumb', TRUE),
                'varTestimonialsThumb' => $this->input->get_post('varTestimonialsThumb', TRUE),
            );

            foreach ($Data as $Key => $Value) {
                $ParaArray = array('Data' => $Data, 'Value' => $Value, 'Key' => $Key);
                $this->Update_GeneralSettings($ParaArray);
            }
        }

        redirect(base_url() . 'adminpanel/settings/systemsettings?p=' . $this->input->get_post('p') . '&action=edit&msg=edit');
    }

    function Update_GeneralSettings($ParaArray) {
        $UpdData = array('varFieldValue' => $ParaArray['Value']);
        $this->db->where('varFieldName', $ParaArray['Key']);

        $query = $this->db->get('generalsettings');

        if ($query->num_rows() > 0) {
            $this->db->where('varFieldName', $ParaArray['Key']);

            $this->db->update('generalsettings', $UpdData);
        } else {

            $Insert_array = array('varFieldName' => $ParaArray['Key'], 'varFieldValue' => $ParaArray['Value']);
            $this->db->insert('generalsettings', $Insert_array);
        }
    }

    function SelectAll_SystemSettings() {

        $query = $this->db->get('generalsettings');
        foreach ($query->result() as $rowResult) {
            $row[$rowResult->varFieldName] = $rowResult->varFieldValue;
        }
        return $row;
    }

    function GetGridTabs($arrtab, $activeident, $display = true, $FilterByuser = '') {
        if (!$display)
            return "";
        $str = "<div class='tab-system uk-active'>";
        foreach ($arrtab as $arr) {
            $abarray = array('SEO', '.Htaccess', 'Maintenance');
            if (USERTYPE == 'A' && in_array($arr[0], $abarray)) {
                $flag = 'false';
            } else {
                $flag = 'true';
            }

            if ($flag == 'true') {
                if ($arr[2] == $activeident) {
                    if ($arr[0] == 'Module Type') {
                        $str .= "<a id='" . $arr[2] . "' href=\"$arr[1]\" onclick=\"$sendGridFunction\" class='user_heading' >" . $arr[0] . "</a>";
                    } else {
                        $str .= "<a id='" . $arr[2] . "' href=\"$arr[1]\" onclick=\"$sendGridFunction\"  class='user_heading'>" . $arr[0] . "</a>";
                    }
                } else {
                    if ($arr[0] == 'Module Type') {
                        $str .= "<a id='" . $arr[2] . "' href=\"$arr[1]\" onclick=\"$sendGridFunction\">" . $arr[0] . "</a>";
                    } else {
                        $str .= "<a id='" . $arr[2] . "' href=\"$arr[1]\" onclick=\"$sendGridFunction\">" . $arr[0] . "</a>";
                    }
                }
            }
        }
        $str .= "</div>";
        if ($FilterByuser != '') {
            $str .= "<div class=\"tab-system uk-active\">$FilterByuser</div>";
        }

        return $str;
    }

    function SelectAll_Logmanager() {
        $this->Initialize();
        $this->GenerateUrl();

        $whereclause = "";
        $whereclauseids = "";

        if (ADMIN_ID == 2) {
            $whereclauseids .= ' AND PUserGlCode != 1 ';
        }

        if (ADMIN_ID != 1 && ADMIN_ID != 2) {
            $whereclauseids .= ' AND PUserGlCode ="' . ADMIN_ID . '" ';
        }

        $modval = $this->input->get_post('modval');
        $chr_action = $this->input->get_post('chr_action');

        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {
            if ($this->SearchTxt != '') {
                $whereclauseids .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
            }

            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclauseids .= "  AND  $filterarray[0] = '$filterarray[1]'";
                }
            }
        }

        if (!empty($modval)) {
            $filtermodule = explode('-', $modval);
            if ($filtermodule[1] == 'm') {
                $whereclause .= " AND FIND_IN_SET('" . $filtermodule[0] . "',Fk_ModuleGlCode) and chrDelete='N'";
            } else {
                $whereclause .= " AND FIND_IN_SET('" . $filtermodule[0] . "',Fk_ModuleGlCode) and chrDelete='Y'";
            }
        }

        if (!empty($chr_action)) {
            $whereclause .= " AND  varOperation ='" . $chr_action . "'";
        }

        $modval1 = $this->input->get_post('modval');
        $filtermodule1 = explode('-', $modval1);
        $type = $this->input->get_post('type');
        if (!empty($type)) {
            if ($type == 'autosearch') {
                $OrderBy = (isset($this->OrderBy)) ? 'order by ' . $this->OrderBy . ' ' . $this->OrderType : 'order by dtOperationDate desc';
                $SearchByVal = " like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%' AND chrPublish = 'Y' AND chrDelete = 'N' ";
                if ($this->SearchByVal == '0' || $this->SearchByVal == '') {
                    $this->SearchByVal = "varName";
                }

                if ($this->modval != '') {
                    $whereclauseids1 .= "and  Module_Id='" . $this->modval . "'";
                }

                if (ADMIN_ID == 2) {
                    $whereclauseids11 .= ' AND PUserGlCode != 1 ';
                }

                if ($filtermodule1[0] != '' && $filtermodule1[0] != '0') {
                    $whereclauseids11 .= " and FIND_IN_SET('" . $filtermodule1[0] . "',Fk_ModuleGlCode)";
                }

                $this->db->select("*,$this->SearchByVal AS AutoVal");
                $this->db->from('logmanager', false);
                $this->db->where("$this->SearchByVal $SearchByVal $whereclauseids11");
                $this->db->group_by("$this->SearchByVal $OrderBy");
                $autoSearchQry = $this->db->get();
                $this->mylibrary->GetAutoSearch($autoSearchQry);
            }
        }

        if ($filtermodule1[0] != '' && $filtermodule1[0] != '0') {
            $whereclauseids11 .= " and FIND_IN_SET('" . $filtermodule1[0] . "',Fk_ModuleGlCode)";
        }

        $this->db->select('*,DATE_FORMAT(dtOperationDate, "' . DEFAULT_TIMEFORMAT . '") AS Time', FALSE);
        $this->db->from('logmanager');
        $this->db->where("chrDelete='N' AND chrPublish='Y' $whereclause  $whereclauseids $whereclauseids11 ", NULL, FALSE);

//        if ($this->PageSize != 'All') {
//            $this->db->limit($this->PageSize, $this->Start);
//        }
        $this->db->order_by($this->OrderBy, $this->OrderType);

        $res = $this->db->get();
//           echo $this->db->last_query();exit;
        return $res;
    }

    function Insert_ChangeProfile() {

        if ($this->input->post('varPassword') != '') {
            $Data = array(
                'varName' => $this->input->post('varName', TRUE),
                'varLoginEmail' => $this->input->post('varLoginEmail', TRUE),
                'varPersonalEmail' => $this->input->post('varPersonalEmail', TRUE),
                'varPassword' => $this->mylibrary->cryptPass($this->input->post('varPassword', TRUE)),
                'varPhoneNo' => $this->input->post('varPhoneNo', true),
//                'varAddress' => $this->input->post('varAddress', true),
//                'varCity' => $this->input->post('varCity', true),
            );
        } else {
            $Data = array(
                'varName' => $this->input->post('varName', TRUE),
                'varLoginEmail' => $this->input->post('varLoginEmail', TRUE),
                'varPersonalEmail' => $this->input->post('varPersonalEmail', TRUE),
                'varPhoneNo' => $this->input->post('varPhoneNo', true),
//                'varAddress' => $this->input->post('varAddress', true),
//                'varCity' => $this->input->post('varCity', true),
            );
        }

        $this->db->where('int_id', ADMIN_ID);

        $Id = $this->db->update('adminpanelusers', $Data);


        if (ADMIN_ID == '1' || ADMIN_ID == '2') {
            $Data1 = array(
//                'varDefaultMailid' => $this->input->post('varDefaultMailid', TRUE),
                'varcontactusleadMailid' => $this->input->post('varcontactusleadMailid', TRUE),
//                'varServiceLeadMailid' => $this->input->post('varServiceLeadMailid', TRUE),
//                'varProductLeadMailid2' => $this->input->post('varProductLeadMailid2', TRUE),
            );

            foreach ($Data1 as $Key => $Value) {
                $ParaArray = array('Data' => $Data1, 'Value' => $Value, 'Key' => $Key);
                $this->Update_GeneralSettings($ParaArray);
            }
        }
        return $Id;
    }

    function Get_ChangeProfile_Data() {
        $wherearray = array('chrDelete' => 'N', 'chrPublish' => 'Y', 'int_id' => ADMIN_ID);
        $this->db->select('*');
        $this->db->from('adminpanelusers');
        $this->db->where($wherearray);
        $res = $this->db->get();
        $result = $res->row();
        return $result;
    }

    function Get_Gensettings_Data() {
        $this->db->cache_delete();
        $query = $this->db->get('generalsettings');
        foreach ($query->result() as $rowResult) {
            $row[$rowResult->varFieldName] = $rowResult->varFieldValue;
        }
        return $row;
    }

    function CountRows() {

//        echo ADMIN_ID; 

        $whereclause = '';
        $whereclauseids = '';
        $whereclauseids_mod = '';

        if (ADMIN_ID == 2) {
            $whereclauseids .= ' AND PUserGlCode != 1 ';
        }

        if (ADMIN_ID != 1 && ADMIN_ID != 2) {
            $whereclauseids .= ' AND PUserGlCode ="' . ADMIN_ID . '" ';
        }



        $modval = $this->input->get_post('modval');
        $chr_action = $this->input->get_post('chr_action');

        if (!empty($modval)) {
            $filtermodule = explode('-', $modval);
            if ($filtermodule[1] == 'm') {
                $whereclause .= " AND FIND_IN_SET('" . $filtermodule[0] . "',Fk_ModuleGlCode) and chrDelete = 'N' ";
            } else {
                $whereclause .= " AND FIND_IN_SET('" . $filtermodule[0] . "',Fk_ModuleGlCode) and chrDelete = 'Y' ";
            }
        }

        if (!empty($chr_action)) {
            $whereclause .= " varOperation ='" . $chr_action . "'";
        }

        if (trim($this->SearchTxt) != '' || $this->FilterBy != '0') {
            if ($this->SearchTxt != '') {
                $whereclause .= (empty($this->SearchBy)) ? " AND varName like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'" : " AND $this->SearchBy like '%" . addslashes(htmlspecialchars_decode($this->SearchTxt)) . "%'";
            }

            if ($this->FilterBy != '0') {
                $filterarray = explode('-', $this->FilterBy);
                if (!empty($filterarray[0]) && !empty($filterarray[1])) {
                    $whereclause .= "  AND  $filterarray[0] = '$filterarray[1]'";
                }
            }
        } else {
            $whereclauseids .= '';
        }
        $modval1 = $this->input->get_post('modval');
//   echo $modval1;
        $filtermodule1 = explode('-', $modval1);
        if ($filtermodule1[0] != '' && $filtermodule1[0] != '0') {
            $whereclauseids11 .= " and FIND_IN_SET('" . $filtermodule1[0] . "',Fk_ModuleGlCode)";
        }
        $this->db->where("chrDelete = 'N' AND  chrPublish='Y' $whereclause $whereclauseids $whereclauseids11", Null, FALSE);
        $rs = $this->db->count_all_results('logmanager');
        return $rs;
    }

    function GetAllData() {
        $this->Initialize();
        $this->GenerateUrl();
        $modval = $this->input->get_post('modval', TRUE);
        $checkedids = $this->input->get_post('chkids', TRUE);
        $whereclause = "";
        if (ADMIN_ID == 2) {
            $whereclause .= ' AND PUserGlCode != 1 ';
        }

        if (ADMIN_ID != 1 && ADMIN_ID != 2) {
            $whereclause .= ' AND PUserGlCode ="' . ADMIN_ID . '" ';
        }

        if ($this->input->get_post('searchbytxt', TRUE) == 'varName') {
            $searchdata = $this->input->get_post('SearchTxt_ids', TRUE);
            $whereclause .= " AND varName LIKE '%" . addslashes($searchdata) . "%'";
        }
        if ($this->input->get_post('searchbytxt', TRUE) == 'varModuleName') {
            $searchdata = $this->input->get_post('SearchTxt_ids', TRUE);
            $whereclause .= " AND varModuleName LIKE '%" . addslashes($searchdata) . "%'";
        }
        if ($this->input->get_post('searchbytxt', TRUE) == 'varLoginName') {
            $searchdata = $this->input->get_post('SearchTxt_ids', TRUE);
            $whereclause .= " AND varLoginName LIKE '%" . addslashes($searchdata) . "%'";
        }
        if ($this->input->get_post('searchbytxt', TRUE) == 'varIpAddress') {
            $searchdata = $this->input->get_post('SearchTxt_ids', TRUE);
            $whereclause .= " AND varIpAddress LIKE '%" . addslashes($searchdata) . "%'";
        }

        if ($this->input->get_post('PageNumber', TRUE) == 'varName') {
            $searchdata = $this->input->get_post('PageNumber_ids', TRUE);

            $whereclause1 .= " AND varName LIKE '%" . addslashes($searchdata) . "%'";
        }
        if (trim($this->SearchTxt) != '') {
            $whereclause .= ($this->SearchBy == '0') ? " and($this->searchbyVal like '%" . $this->addSlashes($this->SearchTxt) . "%') " : " and $this->SearchBy like '%" . $this->addSlashes($this->SearchTxt) . "%'";
        }


        if (!empty($checkedids)) {
            $whereclause .= "AND int_id IN ($checkedids)";
        }

        if (!empty($modval)) {
            $this->modval = $modval;
        }

        if ($this->modval != '0' && $this->modval != '') {
            $filtermodule = explode('-', $this->modval);

            if ($filtermodule[1] == 'm') {
                $whereclause .= " AND FIND_IN_SET('" . $filtermodule[0] . "',Fk_ModuleGlCode)";
            } else {
                $whereclause .= " AND FIND_IN_SET('" . $filtermodule[0] . "',Fk_ModuleGlCode)";
            }
        }
        if (DEFAULT_DATEFORMAT == '%M/%d/%Y') {
            $dateformat = "%b/%d/%Y";
        } else {
            $dateformat = DEFAULT_DATEFORMAT;
        }
        $this->db->select('*,DATE_FORMAT(dtOperationDate, "' . DEFAULT_TIMEFORMAT . '") AS Date,DATE_FORMAT(dtOperationDate, "' . DEFAULT_TIMEFORMAT . '") AS Time', false);
        $this->db->from('logmanager', false);
        $this->db->where("chrDelete = 'N' $whereclause $whereclause1");
        $this->db->order_by($this->OrderBy, $this->OrderType);
//        if ($this->PageSize != 'All') {
//            $this->db->limit($this->PageSize, $this->Start);
//        }
        $rs = $this->db->get();
        $query = $rs->result_array();



        $site_name = str_replace(' ', '_', SITE_NAME);
        $filename = $site_name . "_LogManager_" . date("dmy-h:i") . ".xls";
        $fileprefix = "logmanager";
        $gridbind = "<table border=1>";
        $gridbind .= "<tr><b><center>" . $fileprefix . "</center></b></tr>";
        $gridbind .= "<tr>";
        $gridbind .= "<th>Module Name</th>";
        $gridbind .= "<th>Title</th>";
        $gridbind .= "<th>UserName</th>";
        $gridbind .= "<th>Date</th>";
        $gridbind .= "<th>Time</th>";
        $gridbind .= "<th>Ip Address</th>";
        $gridbind .= "<th>Operation</th>";
        $gridbind .= "</tr>";

        foreach ($query as $row) {
            $public = "select P.Fk_Photoalbum from  " . DB_PREFIX . "Photogallery P," . DB_PREFIX . "logmanager L  where L.Fk_ModuleGlCode='96' and P.int_id=" . $row['intReferenceId'] . "";
            $row5 = mysql_query($public);

            $row5 = mysql_fetch_array($row5);

            $id5 = $row5[0];

            $id5;
            $page_qry5 = "select varTitle from  " . DB_PREFIX . "photoalbum where int_id=" . $id5;
            $res5 = mysql_query($page_qry5);
            $rec5 = mysql_fetch_array($res5);

            $page_name5 = $rec5[0];

            if (!(empty($page_name5))) {
                $str5 = " ( " . $page_name5 . " )";
            } else {
                $str5 = '';
            }
            $rowcount = 0;

            $banner_qry1 = "select B.Chr_Banner_Type from  " . DB_PREFIX . "banner B," . DB_PREFIX . "logmanager L  where L.Fk_ModuleGlCode='93' and B.int_id=" . $Row->intReferenceId . "";
            $res1 = mysql_query($banner_qry1);
            $rec1 = mysql_fetch_array($res1);
            $id1 = $rec1['Chr_Banner_Type'];
            if ($id1 == 'H') {
                $banner = 'Home banner';
            } else {
                $banner = 'Inner banner';
            }
            if (!(empty($banner))) {
                $str = " ( " . $banner . " )";
            } else {
                $str = '';
            }

            $gridbind .= "<tr>";
            $gridbind .= "<td valign='top'>" . $row["varModuleName"] . "</td>";
            if ($row['Fk_ModuleGlCode'] == 96) {
                $gridbind .= "<td valign='top'>" . $row["varName"] . $str5 . "</td>";
            } else if ($row['Fk_ModuleGlCode'] == 93) {
                $gridbind .= "<td valign='top'>" . $row["varName"] . $str . "</td>";
            } else {
                $gridbind .= "<td valign='top'>" . $row["varName"] . "</td>";
            }
            $gridbind .= "<td valign='top'>" . $row["varLoginName"] . "</td>";
            $gridbind .= "<td valign='top'>" . date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($row['dtOperationDate'])) . "</td>";
            $gridbind .= "<td valign='top'>" . $row["Time"] . "</td>";
            $gridbind .= "<td valign='top'>" . $row["varIpAddress"] . "</td>";
            if ($row['varOperation'] == 'I') {
                $operation = "Insert";
            } else if ($row['varOperation'] == 'D') {
                $operation = "Delete";
            } else if ($row['varOperation'] == 'U') {
                $operation = "Update";
            } else if ($row['varOperation'] == 'S') {
                $Operation = "Certificate Featured Status";
            }
            $gridbind .= "<td valign='top'>" . $operation . "</td>";
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

    function Delete_Row() {
        $this->db->cache_delete();
        $tablename = DB_PREFIX . 'logmanager';
        $deleteids = $this->input->get_post('dids');
        $deletearray = explode(',', $deleteids);
        $totaldeletedrecords = count($deletearray);
        $is_assigned = 0;
        $delcount = 0;

        for ($i = 0; $i < $totaldeletedrecords; $i++) {
            $data = array('chrDelete' => 'Y');
            $this->db->where('int_id', $deletearray[$i]);
            $this->db->update($tablename, $data);
        }
    }

    function BindModule() {
        $modval = $this->input->get_post('modval');
        if (!empty($modval)) {
            $selected_array = $modval;
        } else {
            $selected_array = 0;
        }

        $wherearray = array('chrDelete' => 'N', 'chrPublish' => 'Y', 'chrAdminPanel' => 'Y', 'chrDisplayTrash' => 'Y');
        $this->db->select('varHeaderText,int_id');
        $this->db->from('modules');
        $this->db->where($wherearray);
        if (ADMIN_ID != 1) {
            $this->db->where('int_id !=', 37);
            $this->db->where('int_id !=', 65);
        }
        $this->db->order_by('varModuleName', 'asc');
        $result = $this->db->get();
//        echo $this->db->last_query();exit;
//        $display = "<div class=\"new-search-show-all\">";
        $display .= "<select name=\"module\" id=\"module\" class=\"form-control\" style=\"width:180px;margin-left:10px;\" onchange=\"SendGridBindRequest('$this->UrlWithLogPara&PageNumber=1','gridbody','MVF')\">";
        $display .= "<option value=\"0\">-- Filter By Module --</option>";
        foreach ($result->result_array() as $row) {

            $module_name = $row['varHeaderText'];
            $p = ($row['int_id'] . '-m' == $selected_array) ? 'selected' : '';
            $display .= "<option value=" . $row['int_id'] . '-m' . " " . $p . ">" . $module_name . "</option>";
        }
        $display .= "</select>";
        return $display;
    }

    function Check_Email() {
        $Eid = $this->input->get_post('Eid', FALSE);
        if (!empty($Eid)) {
            $this->db->where_not_in('int_id', $Eid);
        }
        $this->db->where('varLoginEmail', $this->input->get_post('User_Email', FALSE));
        $query = $this->db->get('adminpanelusers');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function Export() {
        $this->load->helper('csv');
        $xlsSQL = $this->GetAllData();
        $query = $this->db->query($xlsSQL);
        query_to_csv($query, TRUE, SITE_NAME . "_Logmanager_" . date("dmy-h:i") . ".csv", "Log Manager");
    }

    function DeleteAllLogs() {
        $this->db->cache_delete();
        $tablename = DB_PREFIX . 'logmanager';
        $Data = array("chrDelete" => 'Y');
        $this->db->update($tablename, $Data);
    }

    function DeleteHits() {
        $tablename = DB_PREFIX . 'alias';
        $deleteids = $this->input->get_post('hitsid');
        if ($deleteids == 'A') {
            $Data = array("intPageHits" => 0,
                "intMobileHits" => 0);
        } else if ($deleteids == 'W') {

            $Data = array("intPageHits" => 0);
        } else if ($deleteids == 'M') {
            $Data = array("intMobileHits" => 0);
        } else {
            
        }
        $this->db->update($tablename, $Data);
    }

}

?>