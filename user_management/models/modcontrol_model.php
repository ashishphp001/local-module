<?php

class modcontrol_model extends CI_Model {

    var $int_glcode;
    var $fk_pages;
    var $var_pagename;
    var $var_alias;
    var $text_fulltext;
    var $var_metatitle;
    var $var_metakeyword;
    var $var_metadescription;
    var $int_displayorder;
    var $chr_access = 'P';
    var $chr_publish = 'Y';   // (normal Attribute)
    var $chr_delete = 'N';   // (normal Attribute)
    var $dt_createdate;   // (normal Attribute)
    var $dt_modifydate;   // (normal Attribute)
    var $chr_star;
    var $chr_read;   // (normal Attribute)
    var $oldint_displayorder; // Attribute of Old Displayorder
    var $pagename = ''; // Attribute of Page Name
    var $numofrows; // Attribute of Num Of Rows In Result
    var $numofpages; // Attribute of Num Of Pagues In Result
    var $orderby = 'dt_createdate'; // Attribute of Deafult Order By
    var $ordertype = 'desc'; // Attribute of Deafult Order By
    var $searchby = '0'; // Attribute of Search By
    var $searchtxt; // Attribute of Search Text
    var $start = 1; // Attribute of Start For Paging
    var $pagesize = '30'; // Attribute of Pagesize For Paging
    var $pagenumber = '1'; // Attribute of Page Number For Paging(
    var $lastinsertid; // Attribute of Last Inserid
    var $urlwithpara = ''; // Attribute of URL With parameters
    var $urlwithpoutsearch = ''; // Attribute of URL With parameters without searh
    var $urlwithoutsort = ''; // Attribute of URL With parameters without sort
    var $urlwithoutpaging = ''; // Attribute of URL With parameters without paging
    var $filterby = '0';
    var $urlwithoutfilter = '';
    var $display_limit_array = array('5', '10', '15', '30');
    var $dateField;
    var $searchtxtjs;
    var $noofpages;
    var $searchbyVal;
    var $AutoSearchUrl;

    public function __construct() 
    {
        $this->load->database();
        $this->load->library('mylibrary');
        $mylibraryObj = new mylibrary;
        $this->sortvar = '';
    }

    function HeaderPanel() 
    {
        $content['headerpanel'] = $this->mylibrary->generateHeaderPanel($this->generateParam());
        return $content['headerpanel'];
    }
    
    function PagingTop() 
    {
        $content['pagingtop'] = $this->mylibrary->generatePagingPannel($this->generateParam('top'));
        return $content['pagingtop'];
    }

    function PagingBottom() {
        $content['pagingbottom'] = $this->mylibrary->generatePagingPannel($this->generateParam('bottom'));
        return $content['pagingbottom'];
    }

    function Generateurl() {

        $this->pagename = MODULE_PAGE_NAME . '?';
        
        $this->urlwithpara = $this->pagename . '&' . 'pagesize=' . $this->pagesize . '&numofrows=' . $this->numofrows . '&orderby=' . $this->orderby . '&ordertype=' . $this->ordertype . '&searchby=' . $this->searchby . '&searchtxt=' . $this->searchtxt . '&pagenumber=' . $this->pagenumber . '&filterby=' . $this->filterby;
    }

    function generateParam($position = 'top') {
        return array('pageurl' => MODULE_PAGE_NAME,
            'heading' => 'Manage Group Access'
        );
    }

    function UpdateAssignAction() {
      
        $sql_update = "update " . DB_PREFIX . "module_useraction set chr_delete='Y'";
        $this->db->query($sql_update);
        
        $sql = "select CONCAT(fk_modules,'-',fk_useraction,'-',chr_custom) as actionName,int_glcode from " . DB_PREFIX . "module_useraction";
        $rs = $this->db->query($sql);
        
        $tempAction = array();
        $update_id = array();
        
        foreach ($rs->result_array() as $row) {
            
            $tempAction[] = $row['actionName'];
            $update_id[] = $row['int_glcode'];
        }
        
        
        foreach ($tempAction as $key => $value) {
            $updatearrayids[$value] = $update_id[$key];
        }

        
        $Update_ids = "";
        $insert_values = "";
        
        $chkaccess = $this->input->get_post('chkaccess',true);
        if (!empty($chkaccess)) {
            foreach ($chkaccess as $access) {

                if (in_array($access, $tempAction) && !empty($tempAction)) {
                    $Update_ids .= $updatearrayids[$access] . ",";
                } else {
                    list($fk_module, $fk_action, $chr_custon) = explode("-", $access);
                    $insert_values .= "('" . $fk_module . "','" . $fk_action . "','" . $chr_custon . "','N',NOW()),";
                }
            }
        }
        
            $Update_ids = substr($Update_ids, 0, -1);
            $insert_values = substr($insert_values, 0, -1);
            
            if (!empty($Update_ids)) {
                $sql_updates = "update " . DB_PREFIX . "module_useraction set chr_delete='N' where int_glcode IN($Update_ids)";
                $this->db->query($sql_updates);
                $return = "true";
            }
            if (!empty($insert_values)) {
                $sql_insert = "insert into " . DB_PREFIX . "module_useraction(fk_modules,fk_useraction,chr_custom,chr_delete,dt_modifydate) values $insert_values";
                $this->db->query($sql_insert);
                $return = "true";
            }
            return $return;
        }

        function selectAllassignAction() {
            $sql = "select fk_modules,fk_useraction,chr_custom from " . DB_PREFIX . "module_useraction where chr_delete='N'";
            $result = $this->db->query($sql);
            foreach ($result->result_array() as $row) {

                $actionmodule[$row[fk_modules]][$row[fk_useraction]][$row['chr_custom']] = $row['fk_modules'] . '-' . $row['fk_useraction'] . '-' . $row['chr_custom'];
            }
            return $actionmodule;
        }

        function getAllAction() {

            $query_action = "select GROUP_CONCAT(int_glcode) as action,GROUP_CONCAT(var_action) as actionName from " . DB_PREFIX . "useraction where chr_delete='N'";
            $result = $this->db->query($query_action);
            $rs = $result->row();
            $tempAction = explode(",", $rs->action);
            $tempActionName = explode(",", $rs->actionName);

            for ($i = 0; $i < count($tempAction); $i++) {

                $action[$i]['actionId'] = $tempAction[$i];
                $action[$i]['actionName'] = $tempActionName[$i];
            }
            return $action;
        }

        function getallModule() {

            $module = array();

            $query_module = "select int_glcode as moduleId
                ,var_modulename as moduleName
                ,chr_pro_modulename
                ,'N' as chrcustom
                ,var_modulename as orderfield
                FROM " . DB_PREFIX . "modules where chr_adminpanel_module='Y' 
                ORDER BY moduleId";

            $result = $this->db->query($query_module);

            foreach ($result->result_array() as $row) {

                $temp['moduleId'] = $row['moduleId'];
                $temp['moduleName'] = $row['moduleName'];
                $temp['chr_pro_modulename'] = $row['chr_pro_modulename'];
                $temp['chrcustom'] = $row['chrcustom'];
                array_push($module, $temp);
            }
            return $module;
        }

    }

?>
