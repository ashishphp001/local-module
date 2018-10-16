<?php

class mylibrary {

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->helper('url', 'form');
        $this->ci->load->library('session');
        $this->ci->load->library('User_agent');
    }

    /* Module / User Access - Starts */

    function getAllmoduleAccess() {

        $MainAdminLogin = '';
//        if ($this->ci->session->userdata('UserType') == 'N' || $this->ci->session->userdata('UserType') == 'C') {
        if ($this->ci->session->userdata('UserType') == 'N') {
            $MainAdminLogin = "YES";
        }
        $query = "SELECT int_id AS moduleId, varTitle AS moduleName FROM " . DB_PREFIX . "modules WHERE chrAdminPanel='Y' ";
        $result = $this->ci->db->query($query);
        if ($MainAdminLogin != "YES") {
            $AlluseraccessModule = $this->getAlluseraccessModule();
        }
        $allAction = $this->getAllAction();
        $this->allAction = $allAction;
        $i = 0;
        foreach ($result->result_array() as $row) {
            foreach ($allAction as $Action) {
                $moduleaction = $row['moduleId'] . "-" . $Action['actionId'];
                if ($MainAdminLogin == "YES") {
                    $onlyforadmin_array = $this->retrieve_onlyadminmodulearray();
                    if ($this->ci->session->userdata('UserType') == 'C' && in_array($row['moduleId'], $onlyforadmin_array)) {
                        $moduleactionarray[$row['moduleName']][$Action['actionName']] = 'N';
                    } else {
                        $moduleactionarray[$row['moduleName']][$Action['actionName']] = 'Y';
                    }
                } else {
                    if (!empty($AlluseraccessModule) && in_array($moduleaction, $AlluseraccessModule)) {
                        $moduleactionarray[$row['moduleName']][$Action['actionName']] = 'Y';
                    } else {
                        $moduleactionarray[$row['moduleName']][$Action['actionName']] = 'N';
                    }
                }
            }
        }
        $assign_common_module = $this->assign_common_module();

        foreach ($assign_common_module as $row) {
            $dashboard = $moduleactionarray[$row];
            $moduleactionarray[$row] = array(
                "View" => 'Y',
                "Add" => 'Y',
                "Edit" => 'Y',
                "Delete" => 'Y',
                "Publish/Export" => 'Y',
                "Restore" => 'Y',
                "Approve" => 'Y'
            );
        }
//        echo "<pre>";
//        print_R($moduleactionarray);exit;
        return $moduleactionarray;
    }

    function assign_common_module() {
        $array = array('dashboard', 'settings');
        return $array;
    }

    function generate_thumb($source_filename, $thumb_x, $square = false, $border = false, $cache_output = null, $watermark = false, $watermark_text = null, $req_width, $req_height) {
        $image_info = getimagesize($source_filename);
        $image_width = $image_info[0];
        $image_height = $image_info[1];
        if ($req_width != '' || $req_height != '') {
            // workaround for v1.6.2 where the GIF images arent recognized.
            $img_create = 'ImageCreateFromJPEG';
            //print_r($image_info);exit;
            switch ($image_info['mime']) {
                case 'image/gif':
                    $img_create = 'ImageCreateFromGIF';
                    break;
                case 'image/jpeg':
                    $img_create = 'ImageCreateFromJPEG';
                    break;
                case 'image/png':
                    $img_create = 'ImageCreateFromPNG';
                    break;
                case 'image/bmp':
                    $img_create = 'ImageCreateFromBMP';
                    break;
            }
            if (($image_width >= $req_width ) && ($image_height >= $req_height)) {
                $pref_height = intval(($req_width / $image_width) * $image_height);
                $pref_width = intval(($req_height / $image_height) * $image_width);
                if ($pref_height >= $req_height) {
                    $size = $req_width . "*" . $pref_height;
                    //                    $shtWidth=$req_width;
                    //                    $shtHeight=$pref_height;
                    $shtWidth = $pref_width;
                    $shtHeight = $req_height;
                    $returnmsg = 'true';
                } else if ($pref_width >= $req_width) {
                    $size = $pref_width . "*" . $req_height;
                    //                    $shtWidth=$pref_width;
                    //                    $shtHeight=$req_height;
                    $shtWidth = $req_width;
                    $shtHeight = $pref_height;
                    //$returnmsg= 'true';
                    $returnmsg = 'true';
                }
            } else if (($image_width >= $req_width ) && ($image_height < $req_height)) {
                $pref_height = intval(($req_width * $image_height) / $image_width);
                $size = $pref_width . "*" . $req_height;
                $shtWidth = $req_width;
                $shtHeight = $pref_height;
                $returnmsg = 'INVALID';
            } else if (($image_height >= $req_height ) && ($image_width < $req_width)) {
                $pref_width = intval(($req_height * $image_width) / $image_height);
                $size = $pref_width . "*" . $req_height;
                $shtWidth = $pref_width;
                $shtHeight = $req_height;
                $returnmsg = 'INVALID';
            } else {
                $shtWidth = $image_width;
                $shtHeight = $image_height;
                $returnmsg = 'INVALID';
            }
            $start_x = 0;
            $start_y = 0;
            $thumb_input = @$img_create($source_filename);
            if (!$thumb_input) /* See if it failed */ {
                $thumb_input = imagecreate($thumb_x, $thumb_y); /* Create a blank image */
                $white_color = imagecolorallocate($thumb_input, 255, 255, 255);
                $black_color = imagecolorallocate($thumb_input, 0, 0, 0);
                imagefilledrectangle($thumb_input, 0, 0, 150, 30, $white_color);
                imagestring($thumb_input, 1, 5, 5, 'Error loading ' . $source_filename, $black_color); /* Output an errmsg */
                imagejpeg($thumb_input, '', 90);
                imagedestroy($thumb_input);
            } else {
                $thumb_output = $this->image_create_function($shtWidth, $shtHeight);
                $border_x = $thumb_x - 1;
                $border_y = $thumb_y - 1;
                $background_color = imagecolorallocate($thumb_output, 255, 255, 255);
                imagefill($thumb_output, 0, 0, $background_color);
                $this->image_copy_function($thumb_output, $thumb_input, $start_x, $start_y, 0, 0, $shtWidth, $shtHeight, $image_width, $image_height);
                if ($border) {
                    $border_color = imagecolorallocate($thumb_output, 0, 0, 0);
                    imagerectangle($thumb_output, 0, 0, $border_x, $border_y, $border_color);
                }
                if ($watermark) {
                    // Get identifier for white
                    $white = imagecolorallocate($thumb_output, 255, 255, 255);
                    // Add text to image
                    imagestring($thumb_output, 20, 5, $thumb_y - 20, $watermark_text, $white);
                }
                touch($cache_output);
                imagejpeg($thumb_output, $cache_output, 90);
                imagedestroy($thumb_output);
            }
        }
        return $returnmsg;
    }

    function getAlluseraccessModule() {
        $this->ci->db->select('fk_ModuleGlCode AS ModuleId, fk_UserActionGlCode AS ActionId', false);
        $this->ci->db->where(array("chrAssign" => 'Y', "PUserGlCode" => $this->ci->session->userdata('UserId')));
        $result = $this->ci->db->get('useraccess');
        foreach ($result->result_array() as $row) {
            $accessarray[] = $row['ModuleId'] . '-' . $row['ActionId'];
        }
        return $accessarray;
    }

    function getAllAction() {
        $sql = "SELECT GROUP_CONCAT(int_id) as action,GROUP_CONCAT(VarAction) AS actionName FROM " . DB_PREFIX . "useraction WHERE chrDelete='N'";
        $result = $this->ci->db->query($sql);
        $rs = $result->row();
        $tempAction = explode(",", $rs->action);
        $tempActionName = explode(",", $rs->actionName);
        for ($i = 0; $i < count($tempAction); $i++) {
            $action[$i]['actionId'] = $tempAction[$i];
            $action[$i]['actionName'] = $tempActionName[$i];
        }
        return $action;
    }

    /* Module / User Access - Ends */
    /* Generate Menu - Starts */

    function getMenuModules() {
        $menuModuleArry = array();
        $notValidForClientArry = $this->retrieve_onlyadminmodulearray();  // for admin
        if ($this->ci->session->userdata('UserType') == 'N') {
            $this->ci->db->select("PM.*,M.int_id as int_id, M.varModuleName AS varModuleName, M.fk_ModuleGlCode as ParentId, 'Y' as chrAssign", false);
            $this->ci->db->from("adminpanelmenus AS PM", false);
            $this->ci->db->join("modules AS M", 'PM.fk_ModuleGlCode = M.int_id', 'LEFT');
            $this->ci->db->where("M.chrAdminPanel = 'Y' AND PM.chrPublish='Y' AND M.chrPublish='Y' AND PM.chrDelete='N' AND M.chrMenu='Y'", NULL, FALSE);
            $this->ci->db->order_by("M.intDisplayOrder", "ASC");
            $query = $this->ci->db->get();
        } else if ($this->ci->session->userdata('UserType') == 'C') {
            $this->ci->db->select("PM.*,M.int_id as int_id, M.varModuleName AS varModuleName, M.fk_ModuleGlCode as ParentId, if(M.int_id IN (" . implode(',', $notValidForClientArry) . "),'N','Y') AS chrAssign", false);
            $this->ci->db->from("adminpanelmenus AS PM", false);
            $this->ci->db->join("modules AS M", 'PM.fk_ModuleGlCode = M.int_id', 'LEFT');
            $this->ci->db->where("M.chrAdminPanel = 'Y' AND PM.chrPublish='Y' AND PM.chrDelete='N' AND M.chrMenu='Y'", NULL, FALSE);
            $this->ci->db->order_by("M.intDisplayOrder", "ASC");
            $query = $this->ci->db->get();
        } else {
            $this->ci->db->select("PM.*,M.int_id as int_id, M.varModuleName AS varModuleName, M.fk_ModuleGlCode as ParentId, UA.chrAssign", false);
            $this->ci->db->from("adminpanelmenus AS PM", false);
            $this->ci->db->join("modules AS M", "PM.fk_ModuleGlCode = M.int_id", "LEFT");
            $this->ci->db->join("useraccess AS UA", "UA.fk_ModuleGlCode = M.int_id", "LEFT");
            $this->ci->db->where("M.chrAdminPanel = 'Y' AND PM.chrPublish='Y' AND PM.chrDelete='N' AND M.chrMenu='Y' AND UA.PUserGlCode = '" . $this->ci->session->userdata('UserId') . "'", NULL, FALSE);
            $this->ci->db->where("UA.fk_UserActionGlCode=1", NULL, FALSE);
            $this->ci->db->order_by("M.intDisplayOrder", "ASC");
            $query = $this->ci->db->get();
        }
        if ($query->num_rows() > 0) {
            $menuModuleArry = $query->result();
        }

        $assign_common_module = $this->assign_common_module();

        foreach ($assign_common_module as $row) {
            $moduleName = $row;
//echo $moduleName;
            $this->ci->db->select("PM.*,M.int_id as int_id, M.varModuleName AS varModuleName, M.fk_ModuleGlCode as ParentId, 'Y' as chrAssign", false);
            $this->ci->db->from("adminpanelmenus AS PM", false);
            $this->ci->db->join("modules AS M", 'PM.fk_ModuleGlCode = M.int_id', 'LEFT');
            $this->ci->db->where("M.chrAdminPanel = 'Y' AND PM.chrPublish='Y' AND M.chrPublish='Y' AND PM.chrDelete='N' AND M.chrMenu='Y' and M.varTitle='" . $moduleName . "'", NULL, FALSE);
            $this->ci->db->order_by("M.intDisplayOrder", "ASC");
            $query = $this->ci->db->get();
//            echo $this->db->
            if ($query->num_rows() > 0) {
                array_push($menuModuleArry, $query->row());
            }
        }

        $menuModuleArrys = array();
        $order = array();

        foreach ($menuModuleArry as $key => $row) {
            $order[$key] = $row->intDisplayOrder;
        }

        array_multisort($order, SORT_ASC, $menuModuleArry);
        return $menuModuleArry;
    }

    /* Generate Menu - Ends */
    /* Email header/footer - Starts */

    function get_email_header() {
        $header_str = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                            <title>Boulder Designs</title>
                            <style type="text/css">
                                body {
                                        line-height: 18px;
                                        margin: 0;
                                        color:#a2a2a2;
                                }
                                @media only screen and (min-width:768px) and (max-width:980px) {
                                .wrapper {
                                        width:100% !important;
                                }
                                }
                                @media only screen and (max-width:767px) {
                                .wrapper {
                                        width:100% !important;
                                }
                                }
                                </style>
                            </head>
                        <body>
                        <div class="wrapper" style="width:700px; margin:0 auto; background:#000;">
                        <table style="width:700px;margin:0 auto;border:8px solid #1566c1" cellspacing="0" cellpadding="0" align="center" bgcolor="#000" class="wrapper">
                        <tr>
                            <td align="left" valign="top">
                                <table style="margin:0 auto;background-color:#fff;" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#fff" width="100%">
                                    <tr>
                                        <td height="100" align="left" valign="middle" style="margin:0px; padding:0px;background:#fff;">
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom:4px solid #1566c1;">
                                                <tr style="text-align:center;">
                                                    <td valign="middle" style="padding:20px 0px">
                                                        <a href="' . SITE_PATH . '" title="' . SITE_NAME . '">
                                                            <img src="' . FRONT_MEDIA_URL . 'Themes/ThemeDefault/images/email/logo.jpg" alt="' . SITE_NAME . '"  style="border:0;" title="' . SITE_NAME . '"/>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>';
        return $header_str;
    }

    function get_email_left() {
        $left_str = '<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#fff" style="padding: 12px 8px;;background:#FFF">
                        <tr>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td height="30"><a href="' . SITE_NAME . '" style="font-size:14px;color:#666;text-decoration:none;display:inline-block"><img src="' . FRONT_MEDIA_URL . 'Themes/ThemeDefault/images/email/user.png" style="float:left;margin:-3px 5px 0 0" />Manage your account information</a></td>
                                    </tr>
                                    <tr>
                                        <td height="30"><a href="' . SITE_NAME . '" style="font-size:14px;color:#666;text-decoration:none;display:inline-block"><img src="' . FRONT_MEDIA_URL . 'Themes/ThemeDefault/images/email/review.png" style="float:left;margin:-3px 5px 0 0" />Sign up for Pre-Authorized Payment</a></td>
                                    </tr>
                                    <tr>
                                        <td height="30"><a href="' . SITE_NAME . '" style="font-size:14px;color:#666;text-decoration:none;display:inline-block"><img src="' . FRONT_MEDIA_URL . 'Themes/ThemeDefault/images/email/zoom.png" style="float:left;margin:-3px 5px 0 0" />See your bill online</a></td>
                                    </tr>
                                    <tr>
                                        <td height="30"><a href="' . SITE_NAME . '" style="font-size:14px;color:#666;text-decoration:none;display:inline-block"><img src="' . FRONT_MEDIA_URL . 'Themes/ThemeDefault/images/email/calc.png" style="float:left;margin:-3px 5px 0 0" />Access your previous bill</a></td>
                                    </tr>
                                    <tr>
                                        <td height="30"><a href="' . SITE_NAME . '" style="font-size:14px;color:#666;text-decoration:none;display:inline-block"><img src="' . FRONT_MEDIA_URL . 'Themes/ThemeDefault/images/email/chat.png" style="float:left;margin:-3px 5px 0 0" />Our Frequently Asked Questions</a></td>
                                    </tr>
                                </table>
                                <a href="' . SITE_NAME . '" title="Sign In"><img src="' . FRONT_MEDIA_URL . 'Themes/ThemeDefault/images/email/sign-in.png" /></a>
                            </td>
                        </tr>
                    </table>';
        return $left_str;
    }

    function get_email_footer() {
        $footer_str = '</table>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#fff" style="background-color:#fff;border-top:4px solid #1566c1;padding:10px 0 10px 0;">
                                    <tr>
                                        <td height="40" align="center" valign="middle" style="text-align:center;font-size:13px;color:#000;font-family:Arial, Helvetica, sans-serif;margin:0 auto 10px">
                                        Copyright &copy; ' . date('Y') . ' ' . SITE_NAME . ', All Rights Reserved.</td>
                                    </tr>
                            </table>
                            </td>
                        </tr>
                     </table>
                    </div>
                    </body>
                    </html>';
        return $footer_str;
    }

    /* Email header/footer - Ends */
    /* alias Related Functions - Starts */

    function auto_alias($title) {
        $pattern = "/[^a-zA-Z0-9]+/i";
        $alias_generated = preg_replace($pattern, '-', html_entity_decode(strtolower($title)));
        $alias_generated = preg_replace('/-$/', '', $alias_generated);
        $alias = $this->GetAlias($alias_generated, 'Y');
        return $alias;
    }

    function GetAlias($alias = '', $return = '') {
        $alias = $alias == '' ? $this->ci->input->get_post('alias') : $alias;
        $Fk_Modules = $this->ci->input->get_post('module_id', TRUE);
//        echo $Fk_Modules;exit;
        if ($Fk_Modules == 'MTQ3' || $Fk_Modules == '147') {
            $alias = $alias . "-buylead";
        }
        if ($Fk_Modules == 'MTUw' || $Fk_Modules == '150') {
            $alias = $alias . "-selllead";
        }

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
                echo $ralias;
                die;
            }
        } else {
            if ($return == 'Y') {
                return $alias;
            } else {
                echo $alias;
                die;
            }
        }
    }

    function IsSameAlias($flag = 'N', $alias = '') {
        $eid = $this->ci->input->get_post('eid', TRUE);
        $Fk_Modules = $this->ci->input->get_post('module_id', TRUE);
//echo $Fk_Modules;exit;
        if (!empty($eid)) {
            $Where = " AND int_id != (SELECT int_id FROM " . DB_PREFIX . "alias where fk_ModuleGlCode='" . $Fk_Modules . "' AND fk_Record='" . $eid . "')";
        }
        if ($alias == "") {
            $Alias = $this->ci->input->get_post("varAlias", TRUE);
        } else {
            $Alias = $alias;
        }

        $SQL = $this->ci->db->query("SELECT count(1) as total FROM " . DB_PREFIX . "alias where varAlias=@? $Where", strtolower($Alias));
        $Result = $SQL->Row();
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

    function CheckAlias($param = array()) {
        if (($this->ci->input->get_post('table')) != '') {
            $param['NRtable'] = base64_decode($this->ci->input->get_post('table'));
            if (!empty($param['NRfield'])) {
                $param['NRfield'] = base64_decode($param['NRfield']);
            } else {
                $param['NRfield'] = "int_id";
            }
        }
        if (empty($param['NRtable'])) {
            $param['NRtable'] = 'vis_Alias';
        }
        if (empty($param['NRfield'])) {
            $param['NRfield'] = 'int_id';
        }
        if (($this->ci->input->get_post('eid')) != '') {
            $param['NRid'] = $param['NRid'];
        }
        if (!empty($param)) {
            foreach ($param['tables'] as $key => $value) {
                if (empty($value)) {
                    if (!empty($param['defaultField'])) {
                        $value = $param['defaultField'];
                    } else {
                        $value = "varAlias";
                    }
                }
                if (!empty($param['NRtable']) && !empty($param['NRid']) && $param['NRtable'] == $key) {
                    $whereCondition = " AND NOT(" . $param['NRfield'] . "=" . $param['NRid'] . ")";
                } else {
                    $whereCondition = "";
                }
                $sql = "SELECT count(*) AS COUNTER FROM " . $key . " WHERE UPPER(" . $value . ")='" . strtoupper($param['alias']) . "'" . $whereCondition . " " . $appendsql;
                $rs = $this->ci->db->query($sql);
                $result = $rs->row_array();
                if ($result['COUNTER'] > 0) {
                    return 0;
                }
            }
            return 1;
        } else {
            return 0;
        }
    }

    /* Alias Related Functions - Ends */
    /* Display Order Related Functions - Starts */

    function Update_Display_Order1($uid, $neworder, $oldorder, $table, $whereClause = "") {
        $tablename = DB_PREFIX . $table;
        $updateSql = "UPDATE " . $tablename . " SET intDisplayOrder=intDisplayOrder - 1 WHERE intDisplayOrder >= " . $neworder . " and chrDelete = 'N' AND int_id!=$uid $whereClause";
        $this->ci->db->query($updateSql);
    }

    function Update_Display_Order($ids, $values, $oldvalues, $flag = '', $table, $whereClause = "") {
        $tablename = "" . DB_PREFIX . $table;
        for ($i = 0; $i < count($ids); $i++) {
            // Updation Of the Display Order
            if ($values[$i] != $oldvalues[$i]) {
                $query = $this->ci->db->query("SELECT count(1) as total FROM " . $tablename . " WHERE intDisplayOrder=" . $values[$i] . " and chrDelete = 'N' $whereClause");
                $rs = $query->row();
                if ($rs->total > 0) {
                    if ($values[$i] > $oldvalues[$i]) {
                        $updateSql = "UPDATE $tablename SET intDisplayOrder=intDisplayOrder - 1 WHERE intDisplayOrder > " . $oldvalues[$i] . " and  intDisplayOrder <= " . $values[$i] . " and chrDelete = 'N' $whereClause";
                        $this->ci->db->query($updateSql);
                    } else {
                        $updateSql = "UPDATE $tablename SET intDisplayOrder=intDisplayOrder + 1 WHERE intDisplayOrder >= " . $values[$i] . " and  intDisplayOrder < " . $oldvalues[$i] . " and chrDelete = 'N' $whereClause";
                        $this->ci->db->query($updateSql);
                    }
                }
                $updateSql = "UPDATE $tablename SET intDisplayOrder=$values[$i] WHERE int_id=" . $ids[$i] . " and chrDelete = 'N' $whereClause";
                $this->ci->db->query($updateSql);
            }
            // End of updation of Display Order
        }
        // End of updation of Display Order
    }

    function update_display_order_Ajax($uid, $neworder, $oldorder, $flag = '', $table, $whereClause = "", $where = "") {
        $tablename = "" . DB_PREFIX . $table;
        $query3 = $this->ci->db->query("SELECT count(int_id) as total FROM " . $tablename . " WHERE  chrDelete = 'N' $whereClause $where");
        $rs3 = $query3->row();
//        echo "SELECT int_id  FROM " . $tablename . " WHERE int_id='" . $uid . "' AND intDisplayOrder=" . $oldorder . " AND chrDelete = 'N' $whereClause $where";
        $query = $this->ci->db->query("SELECT int_id  FROM " . $tablename . " WHERE int_id='" . $uid . "' AND intDisplayOrder=" . $oldorder . " AND chrDelete = 'N' $whereClause $where");
        $rs = $query->row();
//        echo "ig";exit;
        $query2 = $this->ci->db->query("SELECT int_id  FROM " . $tablename . " WHERE intDisplayOrder='" . $neworder . "' AND chrDelete = 'N' $whereClause $where");
        $rs2 = $query2->row();
        if ($neworder == 0) {
            $neworder = 1;
        }
//        echo "hi"l;exit
        if ($neworder > $rs3->total) {
            $neworder = $rs3->total;
        }
        if (!empty($rs->int_id)) {
            $updateSql = "UPDATE $tablename SET intDisplayOrder='" . $neworder . "' WHERE int_id='" . $uid . "' and chrDelete = 'N' $whereClause $where";
            $this->ci->db->query($updateSql);
        }
        if (!empty($rs2->int_id)) {
            $updateSql2 = "UPDATE $tablename SET intDisplayOrder='" . $oldorder . "' WHERE int_id='" . $rs2->int_id . "' and chrDelete = 'N' $whereClause $where";
            $this->ci->db->query($updateSql2);
        }
    }

    function set_Int_DisplayOrder_sequence($tablename, $whereCond = "", $WhereClause = "") {
        $sql = 'SELECT int_id FROM ' . $tablename . ' WHERE chrDelete = "N"  ' . $whereCond . $WhereClause . ' ORDER BY intDisplayOrder asc';

        $query = $this->ci->db->query($sql);
        $total = $query->num_rows();
        $i = 0;
        if ($total > 0) {
            foreach ($query->result() as $row) {
                $i++;
                $ids[$i] = $row->int_id;
                $update_syntax .= " WHEN " . $row->int_id . " THEN $i ";
            }
        }
        if ($total > 0) {
            $sql = "UPDATE " . $tablename . " SET intDisplayOrder = (CASE int_id " . $update_syntax . " END) WHERE int_id BETWEEN " . min($ids) . " AND " . max($ids) . " and chrDelete = 'N' $whereCond $WhereClause";
            $this->ci->db->query($sql);
        }
    }

    function UpdateInt_DisplayOrder($tablename, $intdisplay, $whereClause = "") {
        $tablename = DB_PREFIX . $tablename;
        $updateSql = "UPDATE " . $tablename . " SET intDisplayOrder=intDisplayOrder + 1 WHERE intDisplayOrder >= " . $intdisplay . " and chrDelete = 'N' $whereClause";
        $this->ci->db->query($updateSql);
    }

    /* function update_Int_DisplayOrder($ids, $values, $oldvalues, $flag = '', $table, $whereClause = "") {
      $tablename = "" . DB_PREFIX . $table;
      for ($i = 0; $i < count($ids); $i++) {
      if ($values[$i] != $oldvalues[$i]) {
      $query = $this->ci->db->query("SELECT count(1) AS total FROM " . $tablename . " WHERE intDisplayOrder=" . $values[$i] . " AND chrDelete = 'N' $whereClause");
      $rs = $query->row();
      if ($rs->total > 0) {
      if ($values[$i] > $oldvalues[$i]) {
      $updateSql = "UPDATE $tablename SET intDisplayOrder=intDisplayOrder - 1 WHERE intDisplayOrder > " . $oldvalues[$i] . " AND  intDisplayOrder <= " . $values[$i] . " and chrDelete = 'N' $whereClause";
      $this->ci->db->query($updateSql);
      } else {
      $updateSql = "UPDATE $tablename SET intDisplayOrder=intDisplayOrder + 1 WHERE intDisplayOrder >= " . $values[$i] . " AND  intDisplayOrder < " . $oldvalues[$i] . " and chrDelete = 'N' $whereClause";
      $this->ci->db->query($updateSql);
      }
      }
      $updateSql = "UPDATE $tablename SET intDisplayOrder=$values[$i] WHERE int_id=" . $ids[$i] . " AND chrDelete = 'N' $whereClause";
      $this->ci->db->query($updateSql);
      }
      // End of updation of Display Order
      }
      // End of updation of Display Order
      }
      function update_Int_DisplayOrder1($uid, $neworder, $oldorder, $flag = '', $table, $whereClause = "") {
      $tablename = "" . DB_PREFIX . $table;
      $query3 = $this->ci->db->query("SELECT count(int_id) AS total FROM " . $tablename . " WHERE  chrDelete = 'N' $whereClause");
      $rs3 = $query3->row();
      $query = $this->ci->db->query("SELECT int_id  FROM " . $tablename . " WHERE int_id=" . $uid . " AND intDisplayOrder=" . $oldorder . " AND chrDelete = 'N' $whereClause");
      $rs = $query->row();
      $query2 = $this->ci->db->query("SELECT int_id  FROM " . $tablename . " WHERE intDisplayOrder=" . $neworder . " AND chrDelete = 'N' $whereClause");
      $rs2 = $query2->row();
      if ($neworder == 0) {
      $neworder = 1;
      }
      if ($neworder > $rs3->total) {
      $neworder = $rs3->total;
      }
      if (!empty($rs->int_id)) {
      $updateSql = "UPDATE $tablename SET intDisplayOrder=$neworder WHERE int_id=" . $uid . " AND chrDelete = 'N' $whereClause";
      echo $updateSql . '</br>';
      $this->ci->db->query($updateSql);
      }
      if (!empty($rs2->int_id)) {
      $updateSql2 = "UPDATE $tablename SET intDisplayOrder=$oldorder WHERE int_id=" . $rs2->int_id . " AND chrDelete = 'N' $whereClause";
      echo $updateSql2 . '</br>';
      $this->ci->db->query($updateSql2);
      }
      } */
    /* Display Order Related Functions - Ends */
    /* General Functions - Starts */

    function decryptPass($pass) {
        $key = ENC_KEY;
        $pos = (strlen($pass) / 3) % strlen($key);
        $decrypt = '';
        $t = 0;
        for ($i = 0; $i < strlen($pass) / 3; $i++) {
            $num = substr($pass, $i * 3, 3);
            if (substr($num, 0, 1) == 0) {
                $num = substr($num, 1, 2);
            }
            $t = $num ^ ord($key[($i + $pos) % strlen($pass)]);
            $decrypt .= chr($t);
        }
        return $decrypt;
    }

    function cryptPass($string) {
        $key = ENC_KEY;
        $pos = strlen($string) % strlen($key);
        $tmp = "";
        $x = "";
        for ($i = 0; $i < strlen($string); $i++) {
            $x = sprintf("%s", $string[$i] ^ $key[($i + $pos) % strlen($key)]);
            if (preg_match("/[^a-z]/", $string[$i])) {
                $min = 3 - strlen(ord($x));
                $z = str_repeat('0', $min) . ord($x);
            } else {
                $z = "0" . ord($x);
            }
            $tmp .= $z;
        }
        return $tmp;
    }

    function requestRemoveCookie($cookieName) {
        return @setcookie($cookieName, '', time() - 100000, '/', '', '', TRUE);
    }

    function requestGetCookie($cookieName, $devaultValue = '') {
        $value = $devaultValue;
        if (isset($_COOKIE) && array_key_exists($cookieName, $_COOKIE)) {
            $value = @unserialize(base64_decode($_COOKIE[$cookieName]));
        }
        return $value;
    }

    function requestSetCookie($cookieName, $cookieValue, $expiry = 0) {
        $value = @serialize($cookieValue);
        if ($value === false) {
            return false;
        }
        $expiry = intval(abs($expiry));
        if ($expiry != 0) {
            $expiry += time();
        }
        return @setcookie($cookieName, base64_encode($value), $expiry, '/', '', '', TRUE);
    }

    function generate_pin($pin_submitted) {
        return substr(md5($pin_submitted), 15, 4);
    }

    function show_pin_image($full_pin, $generated_pin, $image_url = '', $in_adminpanel = 'N') {
        include_once "DayyanConfirmImageClass.php";
        $DayyanConfirmImage = null;
        $full_pin = md5(rand(2, 99999999));
        $DayyanConfirmImage = new DayyanConfirmImage($generated_pin, $full_pin, $image_url);
//        echo CAPTCHA_IMAGE_PATH;exit; 
        $DayyanConfirmImage->imagepath = CAPTCHA_IMAGE_PATH;
        $output_img = $DayyanConfirmImage->ShowImage();
        return $output_img;
    }

    function send_mail($To, $Subject, $Message, $Attachment = "", $ReplyTo = "") {
        $query = $this->ci->db->get('generalsettings');
        foreach ($query->result() as $rowResult) {
            $result[$rowResult->varFieldName] = $rowResult->varFieldValue;
        }
        $configSMTP = array('protocol' => $result['varMailer'],
            'smtp_host' => $result['varSmtpServer'],
            'smtp_user' => $result['varSmtpUserName'],
            'smtp_pass' => $this->DeCryptPass($result['varSmtpPassword']),
            'smtp_port' => $result['varSmtpPort']);
        
        $this->ci->load->library('email', $configSMTP);
        if (!empty($ReplyTo)) {
            $this->ci->email->reply_to($ReplyTo);
        }
        $this->ci->email->from($result['varSenderEmail'], $result['varSenderName']);
        $this->ci->email->to($To);
        $this->ci->email->subject($Subject);
        $this->ci->email->message($Message);
        $this->ci->email->set_mailtype('html');
        if (!empty($Attachment)) {
//            foreach ($Attachment as $File) {
                $this->ci->email->attach($Attachment);
//            }
        }
        if (!$this->ci->email->send()) {
            return false;
        } else {
            return 'success';
        }
    }
    
      function generateHeaderPanel($params, $needactionImg = 'Yes') {
        $tot_recods = $rs->total;
        $this->permission = $this->ci->session->userdata('permissionArry');
        $this->permissionArry = $this->permission[MODULE_PATH];
        if ($this->permissionArry['Add'] == 'Y') {
//            $u_id = $_GET['c_id'];
//            if ($u_id != '') {
//                $newurl = "&c_id=" . $u_id;
//            } else {
//                $newurl = "";
//            }
//            if ($_GET['p'] == 'add') {
//                $url = "&p=add";
//            } else if ($_GET['p'] == 'spo') {
//                $url = "&p=spo";
//            } else if ($_GET['p'] == 'log') {
//                $url = "&p=log";
//            } else if ($_GET['p'] == 'gro') {
//                $url = "&p=gro";
//            } else if ($_GET['p'] == 'rol') {
//                $url = "&p=rol";
//            } else if ($_GET['p'] == 'fee') {
//                $url = "&p=fee";
//            } else {
//                $url = "";
//            }
            $actionUrl = $params['actionUrl'];
        } else {
            $actionUrl = "";
        }
        $exitButton = TRUE;
        $heading = $params['heading'];
        $pagename = $params['pageurl'];
        $actionImage = $params['actionImage'];
        $backbuttonurl = $params['backbuttonurl'];
        $backbuttonTxt = $params['backbuttonTxt'];
        $actionImageHover = $params['actionImageHover'];
        $listImage = $params['listImage'];
        $altActiontag = "Add New";
        $searcharray = $params['search']['searchArray'];
        $searchurl = $params['search']['SearchUrl'];
        $SearchBy = $params['search']['SearchBy'];
        $SearchTxt = $params['search']['SearchText'];
        $AdvanceSearch = $params['AdvanceSearch'];
        $searchurl_panel = $params['searchpanel']['searchUrl'];
        $searchby_panel = $params['searchpanel']['searchBy'];
        $searchtxt_panel_0 = $params['searchpanel']['searchText0'];
        $searchtxt_panel_1 = $params['searchpanel']['searchText1'];
        $searchtxt_panel_2 = $params['searchpanel']['searchText2'];
        $searchtxt_panel_3 = $params['searchpanel']['searchText3'];
        $searchtxt_panel4 = $params['searchpanel']['searchText4'];
        $searchtxt_panel5 = $params['searchpanel']['searchText5'];
        $serachtextarr = array($searchtxt_panel_0, $searchtxt_panel_1, $searchtxt_panel_2, $searchtxt_panel_3);
        if ($needactionImg == "no") {
            $actionImage = '';
            $actionImageHover = '';
            $actionUrl = '';
            $altActiontag = '';
        }
        if (!empty($searcharray)) {
            $strselbox = '';
            $selected = ($searchby_panel == '0') ? 'selected' : '';
            foreach ($searcharray as $key => $value) {
                $selected = ($key == $SearchBy) ? 'selected' : '';
                $strselbox .= "<option value=\"$key\" $selected>$value</option>";
            }
            $SearchTxt = htmlspecialchars_decode(htmlspecialchars($SearchTxt));
            $searchBox = "";
            if (count($searcharray) == 1) {
                $searchBox1 = "<div style=\"display:none;\"><select name=\"SearchBy\" id=\"SearchBy\" style=\"display:none;\">$strselbox	</select></div>";
            } else {
                $searchBox1 = "<select name=\"SearchBy\" id=\"SearchBy\">$strselbox</select>";
            }

            $searchBox = "<input name=\"SearchTxt1\" id=\"SearchTxt1\" type=\"text\" placeholder=\"Search\" class=\"md-input\" value='" . quotes_to_entities($SearchTxt) . "' onkeydown=\"onkeydown_search(event,'$searchurl')\"/>";
            $searchBox .= "<i class=\"material-icons\"  onClick=\"SendGridBindRequest('$searchurl','gridbody','S')\" id=\"search\" style='cursor: pointer;position: absolute;right: 0;top: 40%;font-size: 23px;'>search</i>";
//                                        $searchBox.="<button class=\"md-input\"  onClick=\"SendGridBindRequest('$searchurl','gridbody','S')\" id=\"search\" ></button>";
            if (!empty($SearchTxt)) {
                $searchBox .= "<i class=\"material-icons\" title=\"Clear Search\"  id=\"clearsearch\" onClick=\"$('#SearchTxt1').val('');SendGridBindRequest('$searchurl','gridbody','S')\"  style='cursor: pointer;position: absolute;right: 0;top: 40%;font-size: 23px;'>remove_circle</i>";
            }
        }
        $module = $this->ci->router->fetch_class();
        $module = $this->ci->router->fetch_class();
        if (!empty($backbuttonurl)) {
            $backButton = "<a href=\"$backbuttonurl\" class=\"fr Editable-btn mgr10\">
                      <span><b class=\"icon-caret-left\"></b> Back To $backbuttonTxt </span>
                    </a>";
        }
//        echo MODULE_ID;
//        if (!empty($actionUrl)) {
//
//            $addButton = '<div class="col-md-3 col-sm-3 col-xs-5 pull-right">
//       
//        
//            <a href="' . $actionUrl . '" class="pull-right btn btn_blue btn-primary">Add New</a>
//            
//        </div>';
//        }
        if (!empty($_REQUEST['modulecode'])) {
            $param = array(array($this->moduleArray[$_REQUEST['modulecode']] => 'Edit'));
        }
        /* add code for access control */
        if (!empty($this->groupAccess)) {
            $param = array(array($_REQUEST['module'] => "Add"));
            if ($this->checkAccess($param) == false) {
                $addButton = "";
            }
        }

        return "<div class=\"dt-uikit-header\">
                        <div class=\"uk-grid\">
                            <div class=\"uk-width-medium-3-10\"> $searchBox1</div>
                            <div class=\"uk-width-medium-7-10\"> $searchBox</div>
                           $autosearch
                        </div>
                    </div>";

//         return "<div class=\"spacer10\"></div>
//        <div class=\"combo-bg\">
//            
//            {$dispCmbStr}{$autosearch}{$typecmb}{$modcmb}{$actioncmb}{$filters}{$modulescombo}{$BannerFilter}{$SearchFilter} 
//                
//                    <div style=\"margin-left: 6px; margin-bottom: 1px;position:absolute;\" class=\"btn btn_blue btn-primary\"><a href=\"$pagename\" style=\"color:#fff;\">Refresh</a></div>
//                    <div class=\"clear\"></div>
//                 
//                </div>
//                {$AdvanceSearch}
//            {$pagingStr}
//            ";
//            return '<section class="content-header">
//     <h1>' . $heading . '</h1><ol class="breadcrumb">
//      <li><a href="' . ADMINPANEL_HOME_URL . '"><i class="fa fa-dashboard"></i> Home</a></li>
//      <li class="active">' . $heading . '</li>
//     </ol></section> <section class="content"><div class="page_wrapper">' . $searchBox . '' . $addButton . '' . $backButton . '</div>';
    }
    
    function generatePagingPannel($params) {
        $PageNumber = $params['paging']['PageNumber'];
        $numofpages = $params['paging']['NoOfPages'];
        $numofrows = $params['paging']['NumOfRows'];
        $pagingurl = $params['paging']['PagingUrl'];
        $pagename = $params['pageurl'];
        $AutoSearchUrl = $params['AutoSearchUrl'];
        $YearCombo = $params['YearCombo'];
        $MonthCombo = $params['MonthCombo'];
        $MenutypeCombo = $params['MenutypeCombo'];
        $AdvanceSearch = $params['AdvanceSearch'];
        $MonthDropDown = $params['MonthDropDown'];
        $ProCatFilter = $params['ProCatFilter'];
        $BannerFilter = $params['BannerFilter'];
        $ProjectsFilter = $params['ProjectsFilter'];
        $CategoryFilter = $params['CategoryFilter'];
        $SearchFilter = $params['SearchFilter'];
        $TestimonialsFilter = $params['TestimonialsFilter'];
        $ShayriesFilter = $params['ShayriesFilter'];
        $ServiceCombo = $params['fk_Service'];
        $filterby = $params['filter']['filterby'];
        $filterPosition = $params['filter']['filterposition'];
        $filterbystatusarray = $params['filterstatus']['filterarray'];
        $filterurl_sattus = $params['filterstatus']['filterurl'];
        $filterby_sattus = $params['filterstatus']['filterby'];
        $filterPosition_sattus = $params['filterstatus']['filterposition'];
        $Position_sattus = $params['filterstatus']['position'];
        $DispLimitArray = $params['display']['LimitArray'];
        $DisplayUrl = $params['display']['DisplayUrl'];
        $pagesize = $params['display']['PageSize'];
        $tablename = $params['tablename'];
        $position = $params['position'];
        $diplayPaging = $params['dispPaging'];
        if (!empty($filterarray)) {
            $strfilerbox = '';
            $selected = ($filterby == '') ? 'selected' : '';
            $strfilerbox .= "<option value=\"0\" $selected>-- Show all --</option>";
            foreach ($filterarray as $key => $value) {
                $selected = ($key == $filterby) ? 'selected' : '';
                $strfilerbox .= "<option value=\"$key\" $selected>$value</option>";
            }
            $filterCmb = "<div class=\"new-search-show-all\"><select name=\"filterby$position\" id=\"filterby$position\" style=\"width:auto;\" class=\"more-textarea\" onchange=\"SendGridBindRequest('$filterurl','gridbody','$filterPosition') \"> $strfilerbox  </select> </div>";
        }
        if (!empty($filterbystatusarray)) {
            $strfilerbox = '';
            $selected = ($filterby_sattus == '') ? 'selected' : '';
            $strfilerbox .= "<option value=\"0\" $selected>Select Status</option>";
            foreach ($filterbystatusarray as $key => $value) {
                $selected = ($key == $filterby_sattus) ? 'selected' : '';
                $strfilerbox .= "<option value=\"$key\" $selected>$value</option>";
            }
            $filterCmb .= "<div class=\"new-search-show-all\">$Position_sattus <select name=\"filterbystatus\" id=\"filterbystatus\" style=\"width:auto;\" class=\"more-textarea\" onchange=\"SendGridBindRequest('$filterurl_sattus','gridbody','$filterPosition_sattus') \"> $strfilerbox  </select> </div>";
        }
        if (!empty($params['typecmb'])) {
            $typecmb = $params['typecmb'];
        } else {
            $typecmb = '';
        }
        if (!empty($params['modcmb'])) {
            $modcmb = $params['modcmb'];
        } else {
            $modcmb = '';
        }
        if (!empty($params['actioncmb'])) {
            $actioncmb = $params['actioncmb'];
        } else {
            $actioncmb = '';
        }
        if (!empty($params['modulescombo'])) {
            $modulescombo = $params['modulescombo'];
        } else {
            $modulescombo = '';
        }
        if ($params['display']) {
            $dispStr = '';
            if (!empty($DispLimitArray)) {
                foreach ($DispLimitArray as $key => $value) {
                    $selected = ($value == $pagesize) ? 'selected' : '';
                    $dispStr .= "<option  value=\"$value\" $selected>Display - $value</option>";
                }
            } else {
                $dispStr = "<option value=\"20\">Display - 20</option><option value=\"30\">Display - 30</option><option value=\"40\">Display - 40</option><option value=\"50\">Display - 50</option>";
            }
            if ($_REQUEST['rid'] != '') {
                $dispCmbStr = " <select style=\"width: 122px;\" id=\"cmbdisplay$position\" name=\"cmbdisplay$position\" onchange=\"SendGridBindRequest('$DisplayUrl','gridbody','new_PS$position')\" class=\"md-input\"> $dispStr </select> ";
            } else {
                $dispCmbStr = " <select style=\"width: 122px;\" id=\"cmbdisplay$position\" name=\"cmbdisplay$position\" onchange=\"SendGridBindRequest('$DisplayUrl','gridbody','PS$position')\" class=\"md-input\"> $dispStr </select> ";
            }
        }
        $tdfirstpage = "";
        $tdlastpage = "";
        if ($PageNumber > 0) {
            $page = $PageNumber - 1;
            if ($PageNumber > 1) {
                $tdfirstpage = "<li><a href=\"javascript:;\" onclick=\"SendGridBindRequest('$pagingurl&amp;PageNumber=$page','gridbody','P','$page','')\" class=\"txt\"><i class=\"uk-icon-angle-double-left\"></i></a></li>";
            }
        }
        if ($PageNumber < $numofpages) {
            $page = $PageNumber + 1;
            $tdlastpage = "<li id='last'><a href=\"javascript:;\" title='Next' onclick=\"SendGridBindRequest('$pagingurl&amp;PageNumber=$page','gridbody','P','$page','')\" ><i class=\"uk-icon-angle-double-right\"></i></a></li>";

//            $tdlastpage = "<li class=\"uk-pagination-next\"><a href=\"javascript:;\" onclick=\"SendGridBindRequest('$pagingurl&amp;PageNumber=$page','gridbody','P','$page','')\" class=\"txt\"><span class=\"ar\"></span>Next</a></li>";
        }
        $pagestring = '';
        $loopcondtion = 0;
        $loopcondtion = $numofpages + 1;
        if ($numofpages > 5) {
            if ($PageNumber > 3 && $PageNumber != $numofpages && $PageNumber != $numofpages - 1) {
                $pagestart = $PageNumber - 2;
            } else if ($PageNumber > 3 && $PageNumber == $numofpages) {
                $pagestart = $PageNumber - 4;
            } else if ($PageNumber > 3 && $PageNumber == $numofpages - 1) {
                $pagestart = $PageNumber - 3;
            } else {
                $pagestart = 1;
            }
            $loopstart = $pagestart;
            $loopcondtion = $pagestart + 5;
        } else {
            $loopstart = 1;
            $loopcondtion = $numofpages + 1;
        }
        for ($i = $loopstart; $i < $loopcondtion; $i++) {
            if ($i == $PageNumber) {
                $pagestring .= "<li class=\"uk-active\"><a>" . $i . "</a></li>";
            } else {
                $pagestring .= "<li><a href=\"javascript:;\" onclick=\"SendGridBindRequest('$pagingurl&amp;PageNumber=$i','gridbody','P','$i')\">" . $i . "</a></li>";
            }
        }
        if ($numofpages > 0) {
            $num = $PageNumber;
        } else {
            $num = 0;
        }
        /* end */
        $pagingStr = "";

//        Total Records......
//        if ($diplayPaging != 'no') {
//            $pagingStr = "
//        <div class=\"totle-page\">" . $numofrows . " Total Results</div> 
//        <div class=\"paging mgr15\">
//            " . $tdlastpage . "
//            <div class=\"fr\">
//                <ul class='uk-pagination uk-margin-medium-top'>" . $pagestring . "</ul>
//            </div>
//            " . $tdfirstpage . "
//        </div>";
//            if ($pagesize != 'All') {
//                $pagingStr .= "<div class=\"pagecounter fr\">Page " . $num . " of " . $numofpages . " </div>";
//            }
//        }
        if ($diplayPaging != 'no') {
            $pagingStr = "
                <ul class='uk-pagination uk-margin-medium-top'>" . $tdfirstpage . $pagestring . $tdlastpage . "</ul>
            ";
            if ($pagesize != 'All') {
                $pagingStr .= "<div class=\"pagecounter fr\">Page " . $num . " of " . $numofpages . " </div>";
            }
        }
        if ($position == "top") {

            $autosearch = "<input type=\"hidden\" name=\"autosearchurl\" id=\"autosearchurl\" value=\"" . $AutoSearchUrl . "&ajax=Y\" />";
        }
        if (MODULE_ID == '104') {
            return "<div class=\"spacer10\"></div>
        <div class=\"combo-bg\">
            
            {$dispCmbStr}<div style=\"margin-left: 6px; margin-bottom: 1px;position:absolute;\" class=\"btn btn_blue btn-primary\"><a href=\"$pagename\" style=\"color:#fff;\">Refresh</a></div>{$autosearch}{$typecmb}{$modcmb}{$actioncmb}{$filters}{$modulescombo} {$ProjectsFilter}{$TestimonialsFilter}{$BlogFilter}{$ServiceCombo} {$MonthDropDown} {$MonthCombo} {$YearCombo}{$MenutypeCombo}{$ProCatFilter}{$CategoryFilter}{$SearchFilter} "
                    . "
                    <div class=\"clear\"></div>";
        } else {
            if ($position == "top") {
                return "<div class=\"spacer10\"></div>
        <div class=\"combo-bg\">
            
            {$dispCmbStr}{$autosearch}{$typecmb}{$modcmb}{$actioncmb}{$filters}{$modulescombo}{$BannerFilter}{$SearchFilter} 
                
                    <div style=\"margin-left: 6px; margin-bottom: 1px;position:absolute;\" class=\"btn btn_blue btn-primary\"><a href=\"$pagename\" style=\"color:#fff;\">Refresh</a></div>
                    <div class=\"clear\"></div>
                 
                </div>
                {$AdvanceSearch}
            {$pagingStr}
            ";
            } else {
                return " {$pagingStr}<div class=\"spacer10\"></div>
        <div class=\"combo-bg\">
            
            {$dispCmbStr}{$autosearch}{$typecmb}{$modcmb}{$actioncmb}{$filters}{$modulescombo}   
                <div style=\"margin-left: 6px; margin-bottom: 1px;\" class=\"btn btn_blue btn-primary\"><a href=\"$pagename\" style=\"color:#fff;\">Refresh</a></div>
                    
                    <div class=\"clear\"></div>
                 
                </div>
           
            ";
            }
        }
    }

    function Message($msg = '') {
        (string) $display_output = null;
        if ($msg != "") {
            $display_output .= '
                <div class="note-bg">
                    <div class="uk-text-success "> 
                        ' . $msg . '
                    </div>
                </div>';
        }
        return $display_output;
    }

    function seo_textdetails($param = array(), $display = 'Y', $url = '', $formname = '') {
        $seoDetail = "";
        $seoDetail .= '<div class="md-card-toolbar">
            <h3 style="float:left;">Search Engine Content</h3>
            <a class="md-btn md-btn-primary md-btn-wave-light" style="float:right;" onclick="generate_seocontent(\'' . $url . '\',\'' . $formname . '\');" href="javascript:;">Generate Search Engine Content</a></div>';
        $MTLabel = 'Meta Title';
        $MKLabel = 'Meta Description';
        $MDLabel = 'Meta Keyword';
        $metaTitleBoxString = "";
        $MTHidden = "";
        $MTCountBox = "";
        $TitleleftCountBoxdata = array('name' => 'metatitle_left',
            'id' => 'metatitle_left',
            'value' => (200 - strlen($param['varMetaTitle'])),
            'class' => 'md-input uk-form-width-mini label-fixed',
            'tabindex' => '-1',
            'readonly' => 'readonly'
        );
        $MTCountBox = form_input_ready($TitleleftCountBoxdata);
        $metaTitleBoxdata = array('name' => 'varMetaTitle',
            'id' => 'varMetaTitle',
            'value' => $param['varMetaTitle'],
            'maxlength' => '200',
            'class' => 'md-input uk-form-width-large label-fixed',
            'onKeyDown' => 'CountLeft(this.form.varMetaTitle,this.form.metatitle_left,200);',
            'onKeyUp' => 'CountLeft(this.form.varMetaTitle,this.form.metatitle_left,200);',
            'extraDataInTD' => $MTHidden
        );
        $metaTitleBoxString .= form_input_ready($metaTitleBoxdata);
        $metaKwdBoxString = "";
        $MKCountBox = "";
        $KwdleftCountBoxdata = array('name' => 'metakeyword_left',
            'id' => 'metakeyword_left',
            'value' => (400 - strlen($param['varMetaKeyword'])),
            'tabindex' => '-1',
            'class' => 'md-input uk-form-width-mini',
            'readonly' => 'readonly'
        );
        $MKCountBox .= form_input_ready($KwdleftCountBoxdata);
        $metaKwdBoxdata = array('name' => 'varMetaKeyword',
            'id' => 'varMetaKeyword',
            'value' => $param['varMetaKeyword'],
            'maxlength' => '500',
            'class' => 'md-input uk-form-width-large label-fixed',
            'onKeyDown' => 'CountLeft(this.form.varMetaKeyword,this.form.metakeyword_left,400);',
            'onKeyUp' => 'CountLeft(this.form.varMetaKeyword,this.form.metakeyword_left,400);',
//            'extraDataInTD' => $MKCountBox
        );
        $metaKwdBoxString .= form_input_ready($metaKwdBoxdata);
        $metaDescBoxString = "";
        $MDHidden = form_hidden('hidvarMetaDescription', $param['varMetaDescription'], '', 'id="hidvarMetaDescription"');
        $DescleftCountBoxdata = array('name' => 'metadescription_left',
            'id' => 'metadescription_left',
            'value' => (400 - strlen($param['varMetaDescription'])),
//            'style' => 'width:50px !important; text-align: center; display:inline !important;',
            'class' => 'md-input uk-form-width-mini label-fixed',
            'tabindex' => '-1',
            'readonly' => 'readonly'
        );
        $MDCountBox .= form_input_ready($DescleftCountBoxdata);
        $metaDescBoxdata = array('name' => 'varMetaDescription',
            'id' => 'varMetaDescription',
            'value' => $param['varMetaDescription'],
            'style' => 'overflow:visible;',
            'rows' => '4',
            'cols' => '160',
            'spellcheck' => 'true',
            'txt_gramm_id' => 'ae196ab8-0f26-be99-b026-ceebd4987f25',
            'class' => 'md-input uk-form-width-large label-fixed',
            'onKeyDown' => 'CountLeft(this.form.varMetaDescription,this.form.metadescription_left,400,500);',
            'onKeyUp' => 'CountLeft(this.form.varMetaDescription,this.form.metadescription_left,400,500);',
            'extraDataInTD' => $MDHidden
        );
        $metaDescBoxString .= form_input_ready($metaDescBoxdata, 'textarea');
//        $seoDetail .= '';
        $seoDetail .= ' 
             <div class="spacer10"></div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-form-row"><label>' . $MTLabel . '</label>  ' . $metaTitleBoxString . '</div>
                    <label></label><div class="uk-form-row">' . $MTCountBox . '</div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-form-row"><label>' . $MDLabel . '</label>  ' . $metaKwdBoxString . '</div>
                    <label></label><div class="uk-form-row">' . $MKCountBox . '</div>
                </div>
            </div>
            <div class="uk-form-row">
                 <div class="uk-grid" data-uk-grid-margin>
                         <div class="uk-form-row"> <label>' . $MKLabel . '</label>  ' . $metaDescBoxString . '</div>
                         <label></label><div class="uk-form-row">' . $MDCountBox . '</div>
                 </div>
             </div>';
//        $seoDetail .= ' </div>';
        $content = $seoDetail;
        return $content;
    }

    function GetAutoSearch($result) {
        $jsonStr = "";
        $jsonStr .= '[';
        $rs = $result->num_rows();
        if ($rs) {
            foreach ($result->result_array() as $row) {
                if (!empty($row['AutoVal'])) {
                    $finalsearch = htmlspecialchars_decode($row['AutoVal'], ENT_QUOTES);
                    $jsonStr .= '{"id": "' . str_replace('"', '\"', $finalsearch) . '", "value": "' . str_replace('"', '\"', $finalsearch) . '", "label": "' . str_replace('"', '\"', $finalsearch) . '"}, ';
                }
            }
            $jsonStr = substr($jsonStr, 0, -1);
        } else {
            $jsonStr .= '{"id": "", "value": "", "label": "No Record Found"}';
        }
        // remove last character , if exists
        if (substr($jsonStr, -1) == ',') {
            $jsonStr = substr($jsonStr, 0, -1);
        }
        $jsonStr .= ']';
        echo htmlspecialchars_decode($jsonStr, ENT_QUOTES);
        exit;
    }

    function date_convert($dt_date) {
//        echo DEFAULT_DATEFORMAT;exit;
        if (DEFAULT_DATEFORMAT == '%d/%m/%Y') {
            return $date = $this->dtConvertDMYtoYMD($dt_date);
        }
        if (DEFAULT_DATEFORMAT == '%m/%d/%Y') {
            return $date = $this->dtConvertMDYtoYMD($dt_date);
        }
        if (DEFAULT_DATEFORMAT == '%Y/%m/%d') {
            return $date = $this->dtConvertYMDtoYMD($dt_date);
        }
        if (DEFAULT_DATEFORMAT == '%Y/%d/%m') {
            return $date = $this->dtConvertYDMtoYMD($dt_date);
        }
        if (DEFAULT_DATEFORMAT == '%M %d %Y') {
            return $date = $this->dtConvertMMDYtoYMD($dt_date);
        }
    }

    function date_convert_front($dt_date) {
        if (DEFAULT_FRONT_DATEFORMAT == '%d/%m/%Y') {
            return $date = $this->dtConvertDMYtoYMD($dt_date);
        }
        if (DEFAULT_FRONT_DATEFORMAT == '%m/%d/%Y') {
            return $date = $this->dtConvertMDYtoYMD($dt_date);
        }
        if (DEFAULT_FRONT_DATEFORMAT == '%Y/%m/%d') {
            return $date = $this->dtConvertYMDtoYMD($dt_date);
        }
        if (DEFAULT_FRONT_DATEFORMAT == '%Y/%d/%m') {
            return $date = $this->dtConvertYDMtoYMD($dt_date);
        }
        if (DEFAULT_FRONT_DATEFORMAT == '%M/%d/%Y') {
            return $date = $this->dtConvertMMDYtoYMD($dt_date);
        }
    }

    function dtConvertDMYtoYMD($date) {
        if ($date != '' && $date != '00/00/0000') {
            $date = explode("/", $date);
            $day = $date[0];
            $month = $date[1];
            $year = $date[2];
            //$ymdarray =  array(trim($year),$month,$day);
            $ymdformat = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
        }
        return $ymdformat;
    }

    function dtConvertMDYtoYMD($date) {
        if ($date != '' && $date != '00/00/0000') {
            $date = explode("/", $date);
            $month = $date[0];
            $day = $date[1];
            $year = $date[2];
            $ymdformat = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
        }
        return $ymdformat;
    }

    function dtConvertMMDYtoYMD($date) {
//         echo $date;
        if ($date != '' && $date != '00/00/0000') {
//            echo "dsfdsf";exit;
            $date = explode(" ", $date);
            $month = $date[0];
            if ($month == 'Jan') {
                $intMonth = '01';
            } else if ($month == 'Feb') {
                $intMonth = '02';
            } else if ($month == 'Mar') {
                $intMonth = '03';
            } else if ($month == 'Apr') {
                $intMonth = '04';
            } else if ($month == 'May') {
                $intMonth = '05';
            } else if ($month == 'Jun') {
                $intMonth = '06';
            } else if ($month == 'Jul') {
                $intMonth = '07';
            } else if ($month == 'Aug') {
                $intMonth = '08';
            } else if ($month == 'Sep') {
                $intMonth = '09';
            } else if ($month == 'Oct') {
                $intMonth = '10';
            } else if ($month == 'Nov') {
                $intMonth = '11';
            } else if ($month == 'Dec') {
                $intMonth = '12';
            }
            $day = $date[1];
            $year = $date[2];
            $ymdformat = date('Y-m-d', mktime(0, 0, 0, $intMonth, $day, $year));
        }
//        echo $ymdformat;exit;
        return $ymdformat;
    }

    function dtConvertYMDtoYMD($date) {
        if ($date != '') {
            $date = explode("/", $date);
            $year = $date[0];
            $month = $date[1];
            $day = $date[2];
            $mdyarray = array($year, $month, $day);
            $mdyformat = implode("-", $mdyarray);
        }
        return $mdyformat;
    }

    function ConvertDateFormatdefault($date) {
        if (DEFAULT_DATEFORMAT == '%d/%m/%Y') {
            if ($date != '' && $date != '0000-00-00') {
                $date = explode("-", $date);
                $year = $date[0];
                $month = $date[1];
                $day = $date[2];
                $defaultformat = date('d/m/Y', mktime(0, 0, 0, $month, $day, $year));
            }
        }
        if (DEFAULT_DATEFORMAT == '%m/%d/%Y') {
            if ($date != '' && $date != '0000-00-00') {
                $date = explode("-", $date);
                $year = $date[0];
                $month = $date[1];
                $day = $date[2];
                $defaultformat = date('m/d/Y', mktime(0, 0, 0, $month, $day, $year));
            }
        }
        if (DEFAULT_DATEFORMAT == '%Y/%m/%d') {
            if ($date != '' && $date != '0000-00-00') {
                $date = explode("-", $date);
                $year = $date[0];
                $month = $date[1];
                $day = $date[2];
                $defaultformat = date('Y/m/d', mktime(0, 0, 0, $month, $day, $year));
            }
        }
        if (DEFAULT_DATEFORMAT == '%Y/%d/%m') {
            if ($date != '' && $date != '0000-00-00') {
                $date = explode("-", $date);
                $year = $date[0];
                $month = $date[1];
                $day = $date[2];
                $defaultformat = date('Y/d/m', mktime(0, 0, 0, $month, $day, $year));
            }
        }
        return $defaultformat;
    }

    function dtConvertYDMtoYMD($date) {
        if ($date != '' && $date != '00/00/0000') {
            $date = explode("/", $date);
            $year = $date[0];
            $day = $date[1];
            $month = $date[2];
            //$ymdarray =  array(trim($year),$month,$day);
            $ymdformat = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
        }
        return $ymdformat;
    }

    function Add_module_note($name = '', $modulename = '') {
        if ($modulename != '') {
            $modulename = $modulename;
        } else {
            $modulename = $name;
        }
        $note = ' <div class="spacer10"></div> 
                <div class="note-bg">
                    <div class="note"> 
                        <strong>Note:</strong> Adding ' . $name . ' are incremental, once you add a new ' . $modulename . ' it will display as first ' . $modulename . ' and previous ' . $name . ' will move down in the order.
                    </div>
                </div>';
        return $note;
    }

    function retrieve_onlyadminmodulearray() {
        $mod_arr = array('1', '13', '14', '19', '39', '37', '64', '65', '68');
        return $mod_arr;
    }

    /* General Functions - Ends */

    function Alias_Textbox($paramAlias = array(), $error_id = '') {
//        echo "gisadasd";
//        alert("ASd");
        if ($error_id != '') {
            $error_id = $error_id;
        } else {
            $error_id = 'aliaserror';
        }
        $aliasBoxString = "";
        $aliasContent = '';
        $cheackalish = '';
        $hiddenAias = form_hidden('alias_flag', 'A', '', 'id="alias_flag"');
        $width = (!empty($paramAlias['textbox_width'])) ? $paramAlias['textbox_width'] : '250px';
        $alishimges = "" . GLOBAL_ADMIN_IMAGES_PATH . "/help.png";
        $aliasnote = '<img width="16" style="padding-left:3px;" height="16" onmouseout="hidediv(\'dvhlpvarwebsite1\');" onmouseover="showDiv(event,\'dvhlpvarwebsite1\')" src="' . $alishimges . '">';
        $cheackalish = '' . $hiddenAias . '<a ' . $paramAlias['linkEvent'] . ' style=" cursor: pointer; padding-left:1px;" herf="javascript:;">Check alias</a>
                        <div id="aliasmsg"></div><label for="varAliasnote" class="error" id="' . $error_id . '"> </label>';
        $aliasBoxdata = array('name' => $paramAlias['name'],
            'id' => $paramAlias['name'],
            'value' => $paramAlias['value'],
            'class' => 'md-input',
            'maxlength' => '255',
            'required' => ""
        );
        $aliasBoxString .= " <div class=\"uk-width-mini\">
                        <div class=\"uk-form-row\">";
        $aliasBoxString .= form_input_ready($aliasBoxdata);
        $aliasBoxString .= "</div></div>";
        $style = empty($paramAlias['eid']) ? 'style="display:none;"' : 'style="display:block;"';
        $aliasContent .= '<div id="aliasurl" ' . $style . '>';
        $aliasContent .= '<div class="title-form fl"><label>Alias</label></div><span class="required"></span> ';
        $aliasContent .= '<div>';
        $alias_click_event = 'return quickedit(\'\');';
        $aliasContent .= '<span><span class="fl" >' . SITE_PATH . '<label style="text-decoration: underline;cursor: pointer;" id="aliaslink" title="A friendly URL is a web address that is readable to both a Visitor of the website and a search engine like Google, Bing etc." onclick="' . $alias_click_event . '">' . $paramAlias['value'] . '</label></span>
                        <span id="aliaslabel" style="display: none;" >
                            <input type="text" class="md-input" onkeypress="return KeycheckAlphaNumeric(event);" maxlength="255" style="width: 255px;" maxlength="100"  id="varAlias" value="' . $paramAlias['value'] . '" name="varAlias">
                        </span>';
        $aliasContent .= '<span id="edit_btn" style="cursor: pointer;" class="submit-btn" onclick="return quickedit(\'\');">
                            <a class="md-btn md-btn-primary md-btn-mini md-btn-wave-light" href="javascript:void(0)">Edit</a>
                        </span>';
        if (!empty($eid) && $row['chrPublish'] == 'Y') {
            $aliasContent .= '<span id="view_btn" style="cursor: pointer;" class="submit-btn" onclick="return quickedit(\'V\');">
                        <a href="javascript:void(0);" class="submit-btn">Open Link</a></span>';
        }
        $aliasContent .= '<div class="md-btn-group">
                            

                                <a href="javascript:void(0)" class="alias_btn submit-btn md-btn md-btn-wave" style="display: none;" id="update_btn" onclick="return quickedit(\'U\');">Update</a>
                                <a href="javascript:void(0)" class="alias_btn submit-btn md-btn md-btn-wave" style="display: none;" id="regen_btn" onclick="return quickedit(\'R\');">Regenerate</a>
                                <a href="javascript:void(0)" class="alias_btn submit-btn md-btn md-btn-wave" style="display: none;" id="cancel_btn" onclick="return quickedit(\'C\');">Cancel</a>
                              </div>
                    <label id="aliasnote" style="margin-top:3px;float:left;color:#F00"></label>';
        $aliasContent .= '</div>';
        $aliasContent .= '</div>';
        return $aliasContent;
    }

    function insertinlogmanager($ParaArray) {
        $sql = "select varModuleName from " . DB_PREFIX . "modules where int_id=" . $ParaArray['ModelId'];
        $row = $this->ci->db->query($sql);
        $rs = $row->row_array();
        $titlesql = "select " . $ParaArray['Name'] . " AS name from " . $ParaArray['TableName'] . " where int_id=" . $ParaArray['ModuleintGlcode'];
        $sql = $this->ci->db->query($titlesql);
        $trs = $sql->row_array();
        $sname = $trs['name'];
        $name = $sname;
        $data = array(
            'PUserGlCode' => ADMIN_ID,
            'varLoginName' => ADMIN_NAME,
            'Fk_ModuleGlCode' => $ParaArray['ModelId'],
            'varModuleName' => $rs['varModuleName'],
            'varTableName' => $ParaArray['TableName'],
            'varDisplayField' => $ParaArray['Name'],
            'varDefaultField' => $ParaArray['Default'],
            'intReferenceId' => $ParaArray['ModuleintGlcode'],
            'varName' => $name,
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'dtOperationDate' => date('Y-m-d H-i-s', time()),
            'varOperation' => $ParaArray['Flag'],
            'chrPublish' => 'Y',
            'chrDelete' => 'N',
        );
//        print_r($data); exit;
        $query = $this->ci->db->insert(DB_PREFIX . 'logmanager', $data);
        return true;
    }

    /* Get the site name for Lead exports */

    function Get_Site_Name($Site_id = '') {
        $wherearray = array('chrDelete' => 'N', 'chrPublish' => 'Y', 'int_id' => $Site_id);
        $this->ci->db->select('varTitle');
        $this->ci->db->from('SiteMst');
        $this->ci->db->where($wherearray);
        $res = $this->ci->db->get();
        $result = $res->row();
        return $result;
    }

    function delete_alias($recordid = '', $moduleid = '') {
        if (!empty($recordid) && !empty($moduleid)) {
            $this->ci->db->delete("alias", array('fk_ModuleGlCode' => $moduleid, 'fk_Record' => $recordid));
        }
    }

    function rem_special_chars($string) {
        $string = stripslashes($string);
        $string = eregi_replace("&", "&amp;", $string);
        $string = eregi_replace("'", "&#039;", $string);
        $string = eregi_replace('"', '&quot;', $string);
        $string = trim($string);
        return $string;
    }

    function Replace_Varible_with_Sitepath($content) {
        return str_replace("{{SITE_PATH}}", SITE_PATH, $content);
    }

    function Replace_Sitepath_with_Varible($content) {
        return str_replace(SITE_PATH, "{{SITE_PATH}}", $content);
    }

    function text2image($text, $configArray = array(), $filepath) {
        $text = trim($text);
        if (trim($text) == "")
            return "";
        $conf = array();
        $conf['color'] = isset($configArray['color']) ? $configArray['color'] : '#000000';
        $conf['font-size'] = isset($configArray['font-size']) ? $configArray['font-size'] : '10';
        $conf['font-file'] = isset($configArray['font-file']) ? $configArray['font-file'] : 'front-media/Themes/Common/css/fonts/ubuntu-light-webfont.ttf';
        $conf['params'] = isset($configArray['params']) ? $configArray['params'] : '';
        $str = $text;
        foreach ($conf as $key => $val) {
            $str .= $key . "=" . $val;
        }
        $hash = md5($str);
        $imagepath = $filepath . '/' . $hash . '.png';
        if (!file_exists($imagepath)) {
            $data = imagettfbbox($conf['font-size'], 0, $conf['font-file'], $text);
            $x = 0 - $data[6];
            $y = 0 - $data[7] - $data[3];
            $y *= 1.1;
            $res = imagecreatetruecolor($data[2] * 1.05, 2 * $data[3] + $y);
            imagealphablending($res, true);
            imagesavealpha($res, true);
            imagefill($res, 0, 0, 0x7fff0000);
            $r = hexdec(substr($conf['color'], 1, 2));
            $g = hexdec(substr($conf['color'], 3, 2));
            $b = hexdec(substr($conf['color'], 5, 2));
            $textcolor = imagecolorallocate($res, $r, $g, $b);
            imagettftext($res, $conf['font-size'], 0, 0, $conf['font-size'], $textcolor, $conf['font-file'], $text);
            imagepng($res, $imagepath);
        }
        return '<img  src="' . base_url() . $imagepath . '" alt="' . SITE_NAME . '"/>';
//        return '<img  src="' . base_url() . $imagepath . '" alt="'.SITE_NAME.'"/>';
    }

    function load_ckeditor($id, $data, $width1 = 'auto', $height1 = '', $toolbartype1 = 'Default') {
        $ckid = $id;
        $ckdata = $data;
        $width = $width1;
        $height = $height1;
        $toolbartype = $toolbartype1;
        include('ckeditor/ckeditor_load.php');
    }

    function load_ckeditor1($id, $data, $width1 = 'auto', $height1 = '500px', $toolbartype1 = 'Default') {
        $ckid = $id;
        $ckdata = $data;
        $width = $width1;
        $height = $height1;
        $toolbartype = $toolbartype1;
        include('application/third_party/ckeditor/ckeditor_load.php');
    }

    function GetAutosuggestionTag($term = '') {
        $SQL = $this->ci->db->query("SELECT * from " . DB_PREFIX . "tag where chrPublish='Y' and chrDelete='N' and varTagName like '%" . addslashes($term) . "%' order by intDisplayOrder asc ");
        $result = $SQL->Result();
        $tag_str .= "[";
        $i = 1;
        foreach ($result as $tag_data) {
            $append_comma = ($i == 1) ? '' : ',';
            $tag_str .= $append_comma . '{"id":"' . $tag_data->int_id . '", "label": "' . html_entity_decode($tag_data->var_tagname, ENT_QUOTES) . '", "value": "' . html_entity_decode($tag_data->varTagName, ENT_QUOTES) . '"}';
            $i++;
        }
        $tag_str .= "]";
        //$tag = '[ { "id": "Netta rufina", "label": "Red-crested Pochard", "value": "Red-crested Pochard" }, { "id": "Sterna sandvicensis", "label": "Sandwich Tern", "value": "Sandwich Tern" }, { "id": "Saxicola rubetra", "label": "Whinchat", "value": "Whinchat" }, { "id": "Saxicola rubicola", "label": "European Stonechat", "value": "European Stonechat" }, { "id": "Lanius senator", "label": "Woodchat Shrike", "value": "Woodchat Shrike" }, { "id": "Coccothraustes coccothraustes", "label": "Hawfinch", "value": "Hawfinch" }, { "id": "Ficedula hypoleuca", "label": "Eurasian Pied Flycatcher", "value": "Eurasian Pied Flycatcher" }, { "id": "Sitta europaea", "label": "Eurasian Nuthatch", "value": "Eurasian Nuthatch" }, { "id": "Pyrrhula pyrrhula", "label": "Eurasian Bullfinch", "value": "Eurasian Bullfinch" }, { "id": "Muscicapa striata", "label": "Spotted Flycatcher", "value": "Spotted Flycatcher" }, { "id": "Carduelis chloris", "label": "European Greenfinch", "value": "European Greenfinch" }, { "id": "Carduelis carduelis", "label": "European Goldfinch", "value": "European Goldfinch" } ]';
        return trim($tag_str);
    }

    function inserttag($moduleid = '', $id = '', $tag_data = '', $front_moduleid = '') {
//        echo "ds"; exit;
        //       print_r($tag_data); 
        if ($id != '' && $tag_data['fkTag'] != '' && $moduleid != '') {
            $tag_array = explode(',', $tag_data['fkTag']);
            //   print_r($tag_data); exit;
            foreach ($tag_array as $value) {
                $sql = "SELECT * from " . DB_PREFIX . "tag where varTagName='" . $value . "' and chrPublish='Y' and chrDelete='N' order by intDisplayOrder asc ";
                $result = $this->ci->db->query($sql);
                $count = count($result->result_array());
                if ($count > 0) {
                    foreach ($result->result_array() as $rs) {
                        $tag_sql = "select int_id from " . DB_PREFIX . "TagData where fkRecordId=" . $id . " and fkPPModuleId=" . $moduleid . "
                            and fkTagGlCode=" . $rs['int_id'] . " ";
                        $tag_result = $this->ci->db->query($tag_sql);
                        $count1 = count($tag_result->result_array());
                        if ($count1 == 0) {
                            $SQL_INSERT = "INSERT INTO " . DB_PREFIX . "TagData (fkTagGlCode,fkRecordId,fkFrontModuleId,fkPPModuleId) 
                            VALUES ('" . $rs['int_id'] . "','" . $id . "','" . $front_moduleid . "','" . $moduleid . "')";
                            $this->ci->db->query($SQL_INSERT);
                            $fk_tag_array_1[] = $this->ci->db->insert_id();
                        } else {
                            foreach ($tag_result->result_array() as $tag_rs) {
                                $fk_tag_array_1[] = $tag_rs['int_id'];
                            }
                        }
                    }
                } else {
                    $int_displayorder = '1';
                    $this->updatedisplay_order('tag', $int_displayorder);
                    $SQL_INSERT = "INSERT INTO " . DB_PREFIX . "tag (varTagName,intDisplayOrder,chrPublish,chrDelete ,dtCreateDate,dtModifyDate,varMetaTitle,varMetaKeyword,varMetaDescription) 
                        VALUES ('" . $value . "','" . $int_displayorder . "','Y','N',NOW(),NOW(),'" . $value . "','" . $value . "','" . $value . "')";
                    $this->ci->db->query($SQL_INSERT);
                    $tag_last_id = $this->ci->db->insert_id();
//                    $this->insertinlogmanager(TAG_MODULE_ID, DB_PREFIX . 'tag', 'varTagName', $tag_last_id, 'I', 'int_id');
                    $tag_alias = $this->auto_alias($value);
                    $this->updatealias($tag_last_id, $tag_alias);
                    $SQL_INSERT = "INSERT INTO " . DB_PREFIX . "TagData (fkTagGlCode,fkRecordId,fkFrontModuleId,fkPPModuleId) 
                        VALUES ('" . $tag_last_id . "','" . $id . "','" . $front_moduleid . "','" . $moduleid . "')";
                    $this->ci->db->query($SQL_INSERT);
                    $fk_tag_array_1[] = $this->ci->db->insert_id();
                }
            }
            $del_tag = "delete from " . DB_PREFIX . "TagData where int_id not in (" . implode(',', $fk_tag_array_1) . ") and fkRecordId=" . $id . " and fkPPModuleId=" . $moduleid . " ";
            $this->ci->db->query($del_tag);
        } else {
            $del_tag = "delete from " . DB_PREFIX . "TagData where  fkRecordId=" . $id . " and fkPPModuleId=" . $moduleid . " ";
            $this->ci->db->query($del_tag);
        }
    }

    function GetTag($recordid, $moduleid) {
        $tag_name = '';
        $sql = "select t.varTagName  from " . DB_PREFIX . "tag t
            left join " . DB_PREFIX . "TagData td on t.int_id=td.fkTagGlCode  
            where td.fkRecordId=" . $recordid . " and td.fkPPModuleId=" . $moduleid . "  ";
        $tag_rs = $this->ci->db->query($sql);
        foreach ($tag_rs->result_array() as $tag_row) {
            if ($tag_name == '')
                $tag_name .= html_entity_decode($tag_row['varTagName']);
            else
                $tag_name .= ', ' . html_entity_decode($tag_row['varTagName']);
        }
        return $tag_name;
    }

    function IsSameTagAlias($alias = '') {
        if ($alias == "") {
            $Alias = $this->ci->input->get_post("varAlias", TRUE);
        } else {
            $Alias = $alias;
        }
        $SQL = $this->ci->db->query("SELECT count(1) as total FROM " . DB_PREFIX . "alias where varAlias=@?", strtolower($Alias));
        $Result = $SQL->Row();
        if ($Result->total > 0) {
            $same = 0;
        } else {
            $same = 1;
        }
        return $same;
    }

    function updatealias($lastId, $alias) {
        $a = $this->IsSameTagAlias($alias);
        if ($a == 1) {
            $newalias = $alias;
        } else {
            $newalias = $alias . '-1';
        }
//         echo $newalias; exit;
        $SQL = $this->ci->db->query("INSERT INTO " . DB_PREFIX . "alias (fk_ModuleGlCode,fk_Record,varAlias) VALUES ('67','" . $lastId . "','" . $newalias . "')");
//                    SET varAlias='" . $alias . "' where int_id='" . $lastId . "'");
    }

    function updatedisplay_order($tablename, $intdisplay, $whereClause = "") {
        $tablename = DB_PREFIX . $tablename;
        $updateSql = "UPDATE " . $tablename . " SET intDisplayOrder=intDisplayOrder + 1 WHERE intDisplayOrder >= " . $intdisplay . " and chrDelete = 'N' $whereClause";
        $this->ci->db->query($updateSql);
    }

    function getcurrentPagesAlias($id, $table = "", $module_id = '2') {
        if ($table == '') {
            $table = 'alias';
        }
        /* Module alias */
        $sql = "SELECT a.varAlias from " . DB_PREFIX . "alias as a where a.fk_Record='" . $id . "' and a.fk_ModuleGlCode='" . $module_id . "'";
        $query = $this->ci->db->query($sql);
        $result = $query->row_array();
        return $result['varAlias'];
    }

    function get_email_regards() {
        $Email_regards = '<br/>
                        <span style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1566c1; font-weight:bold;">Regards,</span><br/>
                        <a style="text-decoration:none;" target="_blank" href="' . SITE_PATH . '"><span style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#1566c1; font-weight:bold;">The Auctus Funds Team</span></a></br>';
        return $Email_regards;
    }

    function generatepaging($dataObj, $position = 'Top') {
        $flag = 'Y';
        $init = $dataObj->Module_Model->initialize($flag);
        $genur = $dataObj->Module_Model->Generateurl($flag);
        $PageNumber = ABS($genur->PageNumber);
        $numofpages = $genur->NoOfPages;
        $numofrows = $genur->NumOfRows;
        $pagingurl = $genur->fronturlwithpara;
        $pagename = $genur->PageName;
        $numofrows1 = $dataObj->NumOfRows;
        if ($PageNumber > 1) {
            $page = $PageNumber - 1;
            $tdfirstpage = "<li class=\"waves-effect\"><a href=\"javascript:;\" title='Previous' aria-label=\"Previous\" onclick=\"SendpagingBindRequest('$pagingurl&amp;PageNumber=$page&amp;p=y','$pagename','P','','')\" ><i class=\"material-icons\">chevron_left</i></a></li>";
        }
        if ($PageNumber < $numofpages) {
            $page = $PageNumber + 1;
            $tdlastpage = "<li class=\"waves-effect\" id='last'><a href=\"javascript:;\" title='Next' onclick=\"SendpagingBindRequest('$pagingurl&amp;PageNumber=$page&amp;p=y','$pagename','P','','')\" ><i class=\"material-icons\">chevron_right</i></a></li>";
        }
        $start = ($PageNumber - 1) * $pagesize;
        $starting_no = $start + 1;
        if (($numofrows - $start) < $pagesize) {
            $end_count = $numofrows;
        } elseif (($numofrows - $start) >= $pagesize) {
            $end_count = $start + $pagesize;
        }
        $pagestring = '';
        $loopcondtion = 0;
        $loopcondtion = $noofpage + 1;
        if ($genur->NoOfPages > 6) {
            if ($init->PageNumber > 3 && $init->PageNumber != $genur->NoOfPages && $this->PageNumber != $genur->NoOfPages - 1) {
                $pagestart = $init->PageNumber - 2;
            } else if ($init->PageNumber > 3 && $init->PageNumber == $genur->NoOfPages) {
                $pagestart = $PageNumber - 4;
            } else if ($init->PageNumber > 3 && $init->PageNumber == $genur->NoOfPages - 1) {
                $pagestart = $init->PageNumber - 3;
            } else {
                $pagestart = 1;
            }
            $loopstart = $pagestart;
            $loopcondtion = $pagestart + 6;
        } else {
            $loopstart = 1;
            $loopcondtion = $genur->NoOfPages + 1;
        }
        for ($i = $loopstart; $i < $loopcondtion; $i++) {
            if ($i == $PageNumber) {
                $pagestring .= "<li class=\"active waves-effect\" title='" . $i . "'><a href='javascript:;'>" . $i . "</a></li>";
            } else {
                $pagestring .= "<li class=\"waves-effect\"><a href='javascript:;' href=\"javascript:;\" title='" . $i . "' onclick=\"SendpagingBindRequest('$pagingurl&amp;PageNumber=$i&amp;p=y','$pagename','P','$i','')\">" . $i . "</a></li>";
            }
        }
        if ($numofpages == 1) {
            
        } else {
            return $tdfirstpage . $pagestring . $tdlastpage;
        }
    }

    function shareOnFacebook($paramArr = array()) {
        include_once(APPPATH . 'libraries/facebook-php-sdk/src/facebook.php');
        $facebook = new Facebook(array(
            'appId' => trim($paramArr['APP_ID']),
            'secret' => trim($paramArr['APP_SECRET']),
            'cookie' => true
        ));
        Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
        Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
        $result = $facebook->api('/' . $paramArr['PAGE_ID'] . '/feed', 'POST', $paramArr['data']);
        return (!empty($result['id'])) ? 1 : 0;
    }

//    function shareOnTwitter($param = array()) {
//
////        include_once(APPPATH . 'libraries/twitteroauth.php');
//        include_once(APPPATH . 'libraries/twitter/TwitterAPIExchange1.php');
//        $connection = new TwitterOAuth($param['CONSUMER_KEY'], $param['CONSUMER_SECRET'], $param['OUATH_TOKEN'],$param['OUATH_TOKEN_SECRET']);
//      	
//		if(file_get_contents($param['data']['picture'])!=''){
//			$postfields = array(
//				'media[]' => file_get_contents($param['data']['picture']),
//				'status' => $param['data']['name']
//			);
//			$connection->post('statuses/update_with_media',$postfields,true);
//			
//		} else {
//			$postfields = array(
//				'status' => $param['data']['name']
//			);
//			$connection->post('statuses/update',$postfields);
//		}
//		
//        if (isset($response->error)) {
//            return "0";
//        } else {
//            return "1";
//        }
//    }
//    function shareOnTwitter($param = array()) {
//include_once(APPPATH . 'libraries/twitter/TwitterAPIExchange1.php');
//
//        /** Set access tokens here - see: https://dev.twitter.com/apps/ * */
//        $settings = array(
//            'oauth_access_token' => trim($param['OUATH_TOKEN']),
//            'oauth_access_token_secret' => trim($param['OUATH_TOKEN_SECRET']),
//            'consumer_key' => trim($param['CONSUMER_KEY']),
//            'consumer_secret' => trim($param['CONSUMER_SECRET'])
//        );
//
//        /** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ * */
//        $url = 'https://api.twitter.com/1.1/statuses/update.json';
//        $requestMethod = 'POST';
//
//        /** POST fields required by the URL above. See relevant docs as above * */
//        $postfields = array(
//            'status' => $param['data']['name'],
//        );
//
//        /** Perform a POST request and echo the response * */
//        $twitter = new TwitterAPIExchange($settings);
//
//        $twitter->buildOauth($url, $requestMethod)
//                ->setPostfields($postfields)
//                ->performRequest();
//
//        if (isset($response->error)) {
//            return "0";
//        } else {
//            return "1";
//        }
//    }
    function shareOnTwitter($param = array()) {
        include_once(APPPATH . 'libraries/twitteroauth.php');
        $connection = new TwitterOAuth($param['CONSUMER_KEY'], $param['CONSUMER_SECRET'], $param['OUATH_TOKEN'], $param['OUATH_TOKEN_SECRET']);
        if (file_get_contents($param['data']['picture']) != '') {
            $postfields = array(
                'media[]' => file_get_contents($param['data']['picture']),
                'status' => $param['data']['name']
            );
            $connection->post('statuses/update_with_media', $postfields, true);
        } else {
            $postfields = array(
                'status' => $param['data']['name']
            );
            $connection->post('statuses/update', $postfields);
        }
        if (isset($response->error)) {
            return "0";
        } else {
            return "1";
        }
    }

    function text2image1($text, $configArray = array(), $filepath) {
        $text = trim($text);
        if (trim($text) == "")
            return "";
        $conf = array();
        $conf['color'] = isset($configArray['color']) ? $configArray['color'] : '#a26b02';
        $conf['font-size'] = isset($configArray['font-size']) ? $configArray['font-size'] : '12';
        $conf['font-file'] = isset($configArray['font-file']) ? $configArray['font-file'] : 'front-media/Themes/ThemeDefault/css/fonts/OpenSans-Regular_0-webfont.ttf';
        $conf['params'] = isset($configArray['params']) ? $configArray['params'] : '';
//        echo $conf['font-file']; exit;
        $str = $text;
        foreach ($conf as $key => $val) {
            $str .= $key . "=" . $val;
        }
        $hash = md5($str);
        $imagepath = $filepath . '/' . $hash . '.png';
        if (!file_exists($imagepath)) {
            $data = imagettfbbox($conf['font-size'], 0, $conf['font-file'], $text);
            $x = 0 - $data[6];
            $y = 0 - $data[7] - $data[3];
            $y *= 1.1;
            $res = imagecreatetruecolor($data[2] * 1.05, 2 * $data[3] + $y);
            imagealphablending($res, true);
            imagesavealpha($res, true);
            imagefill($res, 0, 0, 0x7fff0000);
            $r = hexdec(substr($conf['color'], 1, 2));
            $g = hexdec(substr($conf['color'], 3, 2));
            $b = hexdec(substr($conf['color'], 5, 2));
            $textcolor = imagecolorallocate($res, $r, $g, $b);
            imagettftext($res, $conf['font-size'], 0, 0, $conf['font-size'], $textcolor, $conf['font-file'], $text);
            imagepng($res, $imagepath);
        }
        return '<img  src="' . base_url() . $imagepath . '" alt="' . SITE_NAME . '"/>';
//        return '<img  src="' . base_url() . $imagepath . '" alt="'.SITE_NAME.'"/>';
    }

}

?>