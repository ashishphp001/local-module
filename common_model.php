<?php

class common_model extends CI_Model {

    var $PagesAliasArray;
    var $ModuleArray;

    public function __construct() {
        $this->getAllModuleName();
        $this->getAllPagesAlias();
    }

    function ContentPanel() {
        $returnArry = array();
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where('chrDelete', 'N');
        $this->db->where('chrPublish', 'Y');
        $this->db->where('int_id', '1');
//        $this->db->order_by('int_displayorder');
        $query = $this->db->get(DB_PREFIX . "pages");
//        echo $query;
        foreach ($query->result_array() as $row) {
            $returnArry = $row['txtDescription'];
        }
        return $returnArry;
    }

    function getContent($id = 1) {
        $returnArry = array();
        $this->db->select('txtDescription');
        $this->db->from('pages');
        $this->db->where('chrDelete', 'N');
        $this->db->where('chrPublish', 'Y');
        $this->db->where('int_id', $id);
        $query = $this->db->get();
        $data = $query->row_array();
        $returnArry = $data['txtDescription'];
        $desc = $this->mylibrary->Replace_Varible_with_Sitepath($returnArry);
        return $desc;
    }

    public function getAllModuleName() {
//$this->db->cache_set_common_path("application/cache/db/common/module/");
//$this->db->cache_on();
        $ModuleArray = array();
        $query = $this->db->get('modules');
//$this->db->cache_off();
        foreach ($query->result() as $row) {
            $ModuleArray[$row->varModuleName] = $row;
            $ModuleArray[$row->int_id] = $row;
        }
        $this->ModuleArray = $ModuleArray;
    }

    public function getUserDataByEmail($varLoginEmail = '') {
        $cond = "varEmail = '" . $varLoginEmail . "' AND chrDelete = 'N' and chrPublish = 'Y' ";
        $this->db->where($cond);
        $query = $this->db->get('users');
        $row = $query->row();

        return $row;
    }

    public function getAllPagesAlias() {
//$this->db->cache_set_common_path("application/cache/db/common/pages/");
//$this->db->cache_on();   
        $PagesAliasArray = array();
        $this->db->select('p.fk_ModuleGlCode ,p.int_id,a.varAlias');
        $this->db->from('pages As p');
        $this->db->join('alias AS a', 'p.int_id = a.fk_Record AND a.fk_ModuleGlCode="2"', 'left');
        $this->db->where('p.chrDelete', 'N');
        $query = $this->db->get();
//echo $row->var_pagetype. " " .$row->int_id;exit;
        foreach ($query->result() as $row) {
//echo '<pre>';print_r($row);
            $PagesAliasArray['var_pagetype'][$row->fk_ModuleGlCode] = $row;
            $PagesAliasArray['int_id'][$row->int_id] = $row;
        }
        $this->PagesAliasArray = $PagesAliasArray;
    }

    public function getModuleName($modulename) {
        $row = $this->ModuleArray[$modulename];
        if (empty($row)) {
            $query = $this->db->get_where('modules', array('varTitle' => $modulename));
            return $query->row();
        } else {
            return $row;
        }
    }

    function set_page_hits($alias) {
//$this->db->cache_set_common_path("application/cache/db/common/pages/");
//$this->db->cache_delete();
        if (DEVICE == 'pc') {
            $this->db->set('intPageHits', 'intPageHits+1', FALSE);
        } else {
            $this->db->set('intMobileHits', 'intMobileHits+1', FALSE);
        }
        $this->db->where('varAlias', $alias);
        $this->db->update("alias");
    }

    public function getUserData($id = '') {
        if ($id != '') {
            $sql = "select u.*,ci.varCompanyEmail,ci.varCompanyPhone,ci.varBusinessType from " . DB_PREFIX . "users as u left join " . DB_PREFIX . "company_information as ci on ci.intUser=u.int_id where u.chrDelete='N' and u.chrPublish='Y' and u.int_id='" . $id . "' group by u.int_id";
            $query = $this->db->query($sql);
            $data = $query->row_array();
            return $data;
        }
    }

    public function getUserDataBySubDomain($subdomain = '') {
//        echo $subdomain;
        $data = array();
        if ($subdomain != '') {
            $sql = "select u.*,ci.varCompanyEmail,ci.varCompanyPhone from " . DB_PREFIX . "users as u left join " . DB_PREFIX . "company_information as ci on ci.intUser=u.int_id where u.chrDelete='N' and u.chrPublish='Y' and u.varSubdomain='" . $subdomain . "' group by u.int_id";
            $query = $this->db->query($sql);
            $data = $query->row_array();
            if ($data['int_id'] == '') {
                $sql = "select u.*,ci.varCompanyEmail,ci.varCompanyPhone,a.fk_Record from " . DB_PREFIX . "users as u left join " . DB_PREFIX . "company_information as ci on ci.intUser=u.int_id left join " . DB_PREFIX . "alias as a on a.fk_Record=u.int_id where u.chrDelete='N' and u.chrPublish='Y' and a.varAlias='" . $subdomain . "' group by u.int_id";
                $query = $this->db->query($sql);
                $data = $query->row_array();
            }
        }
        return $data;
    }

    public function getUserInformationData($id = '') {
        if ($id != '') {
            $sql = "select u.*,ci.*,u.int_id,u.varCompany as varCompanyName,d.varName as varBranchDesignationName from " . DB_PREFIX . "users as u left join " . DB_PREFIX . "company_information as ci on ci.intUser=u.int_id left join " . DB_PREFIX . "designation as d on ci.intDesignation=d.int_id where u.chrDelete='N' and u.chrPublish='Y' and u.int_id='" . $id . "' group by u.int_id";
            $query = $this->db->query($sql);
            $data = $query->row_array();
            return $data;
        }
    }

    public function getPageData_Seo($id = '1', $table_name = 'pages') {
        $sql = "select * from " . DB_PREFIX . $table_name . " where chrDelete='N' and chrPublish='Y' and int_id='" . $id . "'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    function set_metadatanew() {
        $title = $this->metaArray['title'];
        $keyword = $this->metaArray['keyword'];
        $description = $this->metaArray['description'];
        if ($title == '' || $keyword == '' || $description == '') {
            $pages_data = $this->glMetaArray();
            if ($title == '')
                $title = $pages_data['var_metatitle'];
            if ($keyword == '')
                $keyword = $pages_data['var_metakeywords'];
            if ($description == '')
                $description = $pages_data['var_metadescription'];
        }
        $metadata['title'] = $title;
        $metadata['keywords'] = $keyword;
        $metadata['description'] = $description;
        return $metadata;
    }

    function get_metadata($array = "", $table_name = "pages", $id = 1) {
//        echo $table_name;exit;
        if (empty($array) && !empty($table_name)) {
            $seo_query = "SELECT int_id,varMetaTitle,varMetaKeyword,varMetaDescription FROM " . DB_PREFIX . $table_name . "  WHERE int_id='" . $id . "'";
            $seo_result = $this->db->query($seo_query);
            if ($seo_result->num_rows > 0) {
                $pages_data = $seo_result->row_array();
                $array['title'] = $pages_data['varMetaTitle'];
                $array['keywords'] = $pages_data['varMetaKeyword'];
                $array['description'] = $pages_data['varMetaDescription'];
            }
        }
        if ($array['title'] == '' || $array['keywords'] == '' || $array['description'] == '') {
            $pages_data = $this->glMetaArray();
            if ($array['title'] == '')
                $array['title'] = $pages_data['var_metatitle'];
            if ($array['keywords'] == '')
                $array['keywords'] = $pages_data['var_metakeywords'];
            if ($array['description'] == '')
                $array['description'] = $pages_data['var_metadescription'];
        }
        $this->metaArray = $array;
        return $array;
    }

    function set_metadata() {
        $table_name = SEO_TABLE;
        if (empty($table_name)) {
            $table_name = 'pages';
        } else {
            $table_name = SEO_TABLE;
        }
        $seo_query = "SELECT varMetaTitle,varMetaKeyword,varMetaDescription FROM " . DB_PREFIX . $table_name . "  WHERE int_id='" . RECORD_ID . "'";
        $seo_result = $this->db->query($seo_query);
        if ($seo_result->num_rows > 0) {
            $pages_data = $seo_result->row_array();
            $title = $pages_data['varMetaTitle'];
            $keyword = $pages_data['varMetaKeyword'];
            $description = $pages_data['varMetaDescription'];
        }
        if ($title == '' || $keyword == '' || $description == '') {
            $seo_query = "SELECT varMetaTitle,varMetaKeyword,varMetaDescription FROM " . DB_PREFIX . "generalsettings";
            $seo_result = $this->db->query($seo_query);
            $pages_data = $seo_result->row_array();
            if ($title == '')
                $title = $pages_data['varMetaTitle'];
            if ($keyword == '')
                $keyword = $pages_data['varMetaKeyword'];
            if ($description == '')
                $description = $pages_data['varMetaDescription'];
        }
        $metadata['title'] = $title;
        $metadata['keywords'] = $keyword;
        $metadata['description'] = $description;
        return $metadata;
    }

    function glMetaArray() {
        $seo_query = "SELECT int_id,varFieldName,varFieldValue FROM " . DB_PREFIX . "generalsettings WHERE varFieldName IN ('VarMetaTitle','VarMetaKeyword','VarMetaDescription','varCommonMetatags','varGoogleanAlyticcode')";
//$this->db->cache_set_common_path("application/cache/db/common/settings/");
//$this->db->cache_on();
        $seo_result = $this->db->query($seo_query);
        $seodata = $seo_result->result_array();
//$this->db->cache_off();
//        echo $this->db->last_query();
        $seo_data = array();
        if (!empty($seodata)) {
            foreach ($seodata as $data) {
                $seo_data[$data['varFieldName']] = $data['varFieldValue'];
            }
        }
        return $seo_data;
    }

    function getseodata() {
        $table_array = array("pages");
        $alias1 = $this->uri->segment(1);
        if (!empty($table_array)) {
            foreach ($table_array as $table_name) {
                $queryalias = "select * from " . DB_PREFIX . $table_name . " WHERE chr_delete='N' AND chr_publish='Y' and  var_alias='" . $alias1 . "'";
                $resultalias = $this->db->query($queryalias);
                $countalias = $resultalias->num_rows();
                if ($countalias > 0) {
                    break;
                }
            }
        }
        return $countalias;
    }

    function GetHomeBannerData($id) {
        if ($id == '1') {
            $banner_type = "H";
        } else {
            $banner_type = "S";
        }
        $returnArry = array();
        $sql = "SELECT * FROM " . DB_PREFIX . "banner WHERE chrDelete = 'N' AND chrPublish = 'Y' and Chr_Banner_Type='" . $banner_type . "' ORDER BY intDisplayOrder";
        $query = $this->db->query($sql);
        $returnArry = $query->result_array();
        return $returnArry;
    }

    function getServiceData() {
        $returnArry = array();
//        $sql = "SELECT * FROM " . DB_PREFIX . "banner WHERE chrDelete = 'N' AND chrPublish = 'Y' and Chr_Banner_Type='H' ORDER BY intDisplayOrder limit 0,1";
        $sql = "SELECT * FROM " . DB_PREFIX . "services WHERE chrDelete = 'N' AND chrPublish = 'Y' ORDER BY chrMenuDisplay desc,intDisplayOrder asc limit 3";
        $query = $this->db->query($sql);
        $returnArry = $query->result_array();
        return $returnArry;
    }

    function getpagedata($id = '', $tablename = 'pages') {
        if ($id != '' && $tablename != '') {
            $alias_sql = "SELECT * FROM " . DB_PREFIX . $tablename . " WHERE int_id = '" . $id . "' and chrPublish='Y' and chrDelete='N'";
            $alias_result = $this->db->query($alias_sql);
            return $alias_result->row_array();
        } else {
            return false;
        }
    }

    function getUrl($tableName = 'pages', $moduleID = 2, $recordID = 0, $alias = '', $action = '') {
        $URL = "#";
        if (SITE_SEO == "N") {
            $res = $this->ModuleArray[$modulename];
            if (empty($res)) {
                $this->db->select('varModuleName');
                $this->db->where('int_id', $moduleID);
                $query = $this->db->get('modules');
                $res = $query->row();
                $URL = base_url() . $res->varModuleName;
            } else {
                $URL = base_url() . $res->varModuleName;
            }
            if (!empty($action)) {
                $URL = $URL . '/' . $action;
            }
            if ($tableName == 'pages' && $moduleID != 2) {
                
            } else {
                if (!empty($recordID)) {
                    $URL = $URL . '/' . $recordID;
                }
            }
        } else {
            if (!empty($alias)) {
                $URL = base_url() . $alias;
            } else {
                if ($moduleID != 2 && !empty($recordID)) {
//                    $res = $this->PagesAliasArray['var_pagetype'][$moduleID];
//                    if (empty($res)) {
                    $this->db->select('int_id,varAlias');
                    $this->db->where('fk_ModuleGlCode', $moduleID);
                    $this->db->where('fk_Record', $recordID);

                    $query = $this->db->get('alias');
                    if ($query->num_rows() > 0) {
                        $res = $query->row();
                        $URL = base_url() . $res->varAlias;
                    }
//                    } else {
//                        $URL = base_url() . $res->varAlias;
//                    }
                } else {
                    $res = $this->PagesAliasArray['int_id'][$recordID];
                    if (empty($res)) {
                        $this->db->select('alias.varAlias');
                        $this->db->where($tableName . '.int_id', $recordID);
                        $this->db->join('alias', 'alias.fk_ModuleGlCode = ' . $tableName . '.fk_ModuleGlCode');
                        $query = $this->db->get($tableName);
                        $res = $query->row();
                        $URL = base_url() . $res->varAlias;
                    } else {
                        $URL = base_url() . $res->varAlias;
                    }
                }
            }
        }
        return $URL;
    }

    function getMasters($tablename) {
        $returnArry = array();
        $this->db->select('*');
        $this->db->from($tablename);
        $this->db->where('chr_delete', 'N');
        $this->db->where('chr_publish', 'Y');
        $this->db->order_by('int_displayorder');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $returnArry[$row['int_id']] = $row;
        }
        return $returnArry;
    }

    function check_user_agent($type = NULL) {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if ($type == 'bot') {
// matches popular bots
            if (preg_match("/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent)) {
                return true;
// watchmouse|pingdom\.com are "uptime services"
            }
        } else if ($type == 'browser') {
// matches core browser types
            if (preg_match("/mozilla\/|opera\//", $user_agent)) {
                return true;
            }
        } else if ($type == 'mobile') {
// matches popular mobile devices that have small screens and/or touch inputs
// mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
// detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
            if (preg_match("/phone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent)) {
// these are the most common
                return true;
            } else if (preg_match("/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent)) {
// these are less common, and might not be worth checking
                return true;
            }
        } elseif ($type == 'iphone') {
            if (preg_match("/iphone/", $user_agent)) {
                return true;
            }
        }
        return false;
    }

    function GetCategoryData($pageId) {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString = "";
        if (RECORD_ID == '28' && MODULE_ID == '147') {
            $this->menuString .= '<li>
                                <form class="cd-search">
                                    <input onkeyup="getCategorySearch()" id="varSearch" type="search" placeholder="Search...">
                                </form>
                            </li>';
        }
        $this->menuString .= '<ul class="cd-dropdown-content" id="varCategoryResult">';


        $pageId = $pageId;
//echo MODUE_ID;
//        if (MODULE_ID == 110) {
//            $pageId = 2;
//        }


        $selectstring = $this->getfkarray($pageId, $fkstring);
        $selectarray = explode(",", $selectstring);
        $length = '10';
        $sql = "select p.int_id,p.intParentCategory,p.varName,a.varAlias,CONCAT('" . SITE_PATH . "',a.varAlias) as link from " . DB_PREFIX . "product_category p left join " . DB_PREFIX . "alias as a on a.fk_Record = p.int_id where p.chrPublish='Y' AND a.fk_ModuleGlCode='113' and p.chrDelete='N' order by a.intPageHits desc";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $i = 0;
        if ($count > 0) {
            foreach ($query->result_array() as $result) {
                $pitems[] = $result;
            }
            if ($pitems) {
                foreach ($pitems as $p) {
                    $pt = $p['intParentCategory'];
                    $list = @$children[$pt] ? $children[$pt] : array();
                    array_push($list, $p);
                    $children[$pt] = $list;
                }
            }

            foreach ($children[0] as $record) {
                if ($i < $length && $record['intParentCategory'] == 0) {
                    $uriseg = $this->uri->rsegments;
                    $link = $record['link'];
                    if (array_key_exists($record['int_id'], $children)) {
                        $Page_title = stripslashes(quotes_to_entities($record['varName']));
                        $this->menuString .= '<li class="has-children"><a href="' . $link . '" title="' . $Page_title . '"  class="waves-effect waves-light btn">' . $Page_title . '</a>';
                        $this->menuString .= '<ul class="cd-secondary-dropdown is-hidden">';
                        $this->menuString .= '<li class="go-back"><a href="javascript:;">Back</a></li>';
                        $this->menuString .= ' <li class="title-hub-responsive"><a href="' . $link . '">' . $Page_title . '</a></li>';
                        $this->menuString .= $this->getChildCategoryMenu($record['int_id'], $children, $selectarray);
                        $this->menuString .= "</ul>";
                        $this->menuString .= "</li>";
                    } else {
                        $title = stripslashes(quotes_to_entities($record['varName']));
                        $this->menuString .= '<li><a class="waves-effect waves-light btn" href="' . $link . '" title="' . $title . '">' . $title . '</a></li>';
                    }

                    $i++;
                }
            }
        }
        $Get_product_category_Url = $this->getUrl("2", "2", "53", '');
        $this->menuString .= '<li class="view-btn"><a href="' . $Get_product_category_Url . '" class="waves-effect waves-light btn">All Categories</a></li>';
        if (RECORD_ID == '28' && MODULE_ID == '147') {
            $this->menuString .= "<li id='notcategory' style='display:none;'><a class='waves-effect waves-light btn' href='javascript:;'>No Category found.</a></li>";
        }
        $this->menuString .= '</ul>';
        return $this->menuString;
    }

    function getChildCategoryMenu($id, $children, $selectarray) {
        $i = 1;
        foreach ($children[$id] as $subrecord) {
            if ($i <= 8) {
                $link = $subrecord['link'];
                $Page_title = stripslashes(quotes_to_entities($subrecord['varName']));
                if (array_key_exists($subrecord['int_id'], $children)) {
//                    $this->menuString .= '<li><a class="dropdown-toggle" data-toggle="dropdown" href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a><li>';
                } else {
                    $this->menuString .= '<li><a  href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                }
                if (array_key_exists($subrecord['int_id'], $children)) {
                    $this->menuString .= '<li  class="has-children"><a href="' . $link . '">' . $Page_title . '</a>
                             <ul class="is-hidden"><li class="go-back"><a href="javascript:;">Back</a></li>';
                    $this->menuString .= ' <li class="title-hub-responsive"><a href="' . $link . '">' . $Page_title . '</a></li>';
                    $this->menuString .= $this->getChildSubCategoryMenu($subrecord['int_id'], $children, $selectarray);
                    $this->menuString .= '<li class="see-all"><a href="' . $link . '">View All</a></li>';
                    $this->menuString .= "</ul></li>";
                }
                $i++;
            }
        }
        if ($i > 8) {
            $Get_category_Url = $this->getUrl("product_category", "113", $id, '');
            $this->menuString .= '<div class="view-category-all"><a href="' . $Get_category_Url . '" class="waves-effect waves-light btn view-category-main">View More</a></div>';
        }
    }

    function getChildSubCategoryMenu($id, $children, $selectarray) {
        $data = array_slice($children[$id], 0, 4);
        if ($data) {
            $i = 1;
            foreach ($data as $subrecord) {
                $link = $subrecord['link'];
                $Page_title = stripslashes(quotes_to_entities($subrecord['varName']));
                if (array_key_exists($subrecord['int_id'], $children)) {
                    $product_url = $this->common_model->getUrl("pages", "2", "51", '') . "?cat=" . $subrecord['int_id'];
                    $this->menuString .= '<li><a href="' . $product_url . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                } else {
                    $product_url = $this->common_model->getUrl("pages", "2", "51", '') . "?cat=" . $subrecord['int_id'];
                    $this->menuString .= '<li><a href="' . $product_url . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                }
                $i++;
            }
        }
    }

//RFQ Categories
    function GetRFQCategoryData($pageId) {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString = "";
        if (RECORD_ID == '28' && MODULE_ID == '147') {
//            $this->menuString .= '<li>
//                                <form class="cd-search">
//                                    <input onkeyup="getCategorySearch()" id="varSearch" type="search" placeholder="Search...">
//                                </form>
//                            </li>';
        }
        $this->menuString .= '<ul class="cd-dropdown-content" id="varCategoryResult">';


        $pageId = $pageId;
        $selectstring = $this->getfkarray($pageId, $fkstring);
        $selectarray = explode(",", $selectstring);
        if (RECORD_ID == '23') {
            $length = "10";
        } else {
            $length = '15';
        }
        $sql = "select p.int_id,p.intParentCategory,p.varName,a.varAlias,CONCAT('" . SITE_PATH . "',a.varAlias) as link from " . DB_PREFIX . "product_category p left join " . DB_PREFIX . "alias as a on a.fk_Record = p.int_id where p.chrPublish='Y' AND a.fk_ModuleGlCode='113' and p.chrDelete='N' order by a.intPageHits desc";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $i = 0;
        if ($count > 0) {
            foreach ($query->result_array() as $result) {
                $pitems[] = $result;
            }
            if ($pitems) {
                foreach ($pitems as $p) {
                    $pt = $p['intParentCategory'];
                    $list = @$children[$pt] ? $children[$pt] : array();
                    array_push($list, $p);
                    $children[$pt] = $list;
                }
            }

            foreach ($children[0] as $record) {
                if ($i < $length && $record['intParentCategory'] == 0) {
                    $uriseg = $this->uri->rsegments;
                    $link = $record['link'] . "?type=rfq";
                    if (array_key_exists($record['int_id'], $children)) {
                        $Page_title = stripslashes(quotes_to_entities($record['varName']));
                        $this->menuString .= '<li class="has-children"><a href="' . $link . '" title="' . $Page_title . '"  class="waves-effect waves-light btn">' . $Page_title . '</a>';
                        $this->menuString .= '<ul class="cd-secondary-dropdown is-hidden">';
                        $this->menuString .= '<li class="go-back"><a href="javascript:;">Back</a></li>';
                        $this->menuString .= ' <li class="title-hub-responsive"><a href="' . $link . '">' . $Page_title . '</a></li>';
                        $this->menuString .= $this->getChildRFQCategoryMenu($record['int_id'], $children, $selectarray);
                        $this->menuString .= "</ul>";
                        $this->menuString .= "</li>";
                    } else {
                        $title = stripslashes(quotes_to_entities($record['varName']));
                        $this->menuString .= '<li><a class="waves-effect waves-light btn" href="' . $link . '" title="' . $title . '">' . $title . '</a></li>';
                    }

                    $i++;
                }
            }
        }
        $Get_product_category_Url = $this->getUrl("2", "2", "53", '') . "?type=rfq";
        $this->menuString .= '<li class="view-btn"><a href="' . $Get_product_category_Url . '" class="waves-effect waves-light btn">All Categories</a></li>';
        if (RECORD_ID == '28' && MODULE_ID == '147') {
            $this->menuString .= "<li id='notcategory' style='display:none;'><a class='waves-effect waves-light btn' href='javascript:;'>No Category found.</a></li>";
        }
        $this->menuString .= '</ul>';
        return $this->menuString;
    }

    function getChildRFQCategoryMenu($id, $children, $selectarray) {
        $i = 1;
        foreach ($children[$id] as $subrecord) {
            if ($i <= 8) {
                $link = $subrecord['link'] . "?type=rfq";
                $Page_title = stripslashes(quotes_to_entities($subrecord['varName']));
                if (array_key_exists($subrecord['int_id'], $children)) {
//                    $this->menuString .= '<li><a class="dropdown-toggle" data-toggle="dropdown" href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a><li>';
                } else {
                    $this->menuString .= '<li><a  href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                }
                if (array_key_exists($subrecord['int_id'], $children)) {
                    $this->menuString .= '<li  class="has-children"><a href="' . $link . '">' . $Page_title . '</a>
                             <ul class="is-hidden"><li class="go-back"><a href="javascript:;">Back</a></li>';
                    $this->menuString .= ' <li class="title-hub-responsive"><a href="' . $link . '">' . $Page_title . '</a></li>';
                    $this->menuString .= $this->getChildRFQSubCategoryMenu($subrecord['int_id'], $children, $selectarray);
                    $this->menuString .= '<li class="see-all"><a href="' . $link . '">View All</a></li>';
                    $this->menuString .= "</ul></li>";
                }
                $i++;
            }
        }
        if ($i > 8) {
            $Get_category_Url = $this->getUrl("product_category", "113", $id, '') . "?type=rfq";
            $this->menuString .= '<div class="view-category-all"><a href="' . $Get_category_Url . '" class="waves-effect waves-light btn view-category-main">View More</a></div>';
        }
    }

    function getChildRFQSubCategoryMenu($id, $children, $selectarray) {
        $data = array_slice($children[$id], 0, 4);
        if ($data) {
            $i = 1;
            foreach ($data as $subrecord) {
                $link = $subrecord['link'] . "?type=rfq";
                $Page_title = stripslashes(quotes_to_entities($subrecord['varName']));
                if (array_key_exists($subrecord['int_id'], $children)) {

                    $this->menuString .= '<li><a href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                } else {
                    if (RECORD_ID == '23') {
                        $rfq_url = $this->common_model->getUrl("pages", "2", "51", '') . "?type=rfq";
                        $this->menuString .= '<li><a href="' . $rfq_url . '&cat=' . $subrecord['int_id'] . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                    } else {
                        $this->menuString .= '<li><a href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                    }
                }
                $i++;
            }
        }
    }

    function GetHeaderMenuData($pageId) {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString = "";
        $this->menuString .= '<ul>';
        $pageId = $pageId;
//echo MODUE_ID;
//        if (MODULE_ID == 110) {
//            $pageId = 2;
//        }


        $selectstring = $this->getfkarray($pageId, $fkstring);
        $selectarray = explode(",", $selectstring);
        $length = '8';
        $sql = "select p.int_id,p.fk_ParentPageGlCode,p.fk_ModuleGlCode,p.varTitle,a.varAlias,m.varModuleName,case p.fk_ModuleGlCode WHEN 0 THEN CONCAT('" . SITE_PATH . "',a.varAlias) ELSE CONCAT('" . SITE_PATH . "',a.varAlias) end as link from " . DB_PREFIX . "pages p left join " . DB_PREFIX . "alias as a on a.fk_Record = p.int_id left join " . DB_PREFIX . "modules m on m.int_id = p.fk_ModuleGlCode where p.int_id !=1 and p.chrPublish='Y' AND a.fk_ModuleGlCode='2' and p.chrDelete='N' and p.chrMenuDisplay='Y' order by p.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $i = 0;
        if ($count > 0) {
            foreach ($query->result_array() as $result) {
                $pitems[] = $result;
            }
            if ($pitems) {
                foreach ($pitems as $p) {
                    $pt = $p['fk_ParentPageGlCode'];
                    $list = @$children[$pt] ? $children[$pt] : array();
                    array_push($list, $p);
                    $children[$pt] = $list;
                }
            }

            foreach ($children[0] as $record) {
                if ($i < $length && $record['fk_ParentPageGlCode'] == 0) {
                    $uriseg = $this->uri->rsegments;
                    $link = $record['link'];
                    if (MODULE_ID == 2) {
                        if ($record['int_id'] == RECORD_ID) {
                            $sclass = "class='active'";
                        } else {
                            $sclass = " ";
                        }
                    } else if ($record['fk_ModuleGlCode'] == MODULE_ID) {
                        $sclass = "class='active'";
                    } else {
                        $sclass = "";
                    }
                    if (in_array($record['int_id'], $selectarray)) {
                        $sclass = "class='active'";
                    } else {
                        $sclass = "";
                    }
                    if (array_key_exists($record['int_id'], $children)) {

                        $Page_title = stripslashes(quotes_to_entities($record['varTitle']));
                        $this->menuString .= '<li class="has-sub"><a ' . $sclass . ' href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a>';
                        $this->menuString .= '<ul>';
                        $this->menuString .= $this->getChildMenu($record['int_id'], $children, $selectarray);
                        $this->menuString .= "</ul>";
                        $this->menuString .= "</li>";
                    } else {
                        $title = stripslashes(quotes_to_entities($record['varTitle']));
                        $this->menuString .= '<li><a ' . $sclass . ' href="' . $link . '" title="' . $title . '"><span>' . $title . '</span></a></li>';
                    }

                    $i++;
                }
            }
        }
        $this->menuString .= '</ul>';
        return $this->menuString;
    }

    function GetMobileHeaderMenuData($pageId) {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString = "";
        $this->menuString .= '<ul class="nav__list">';
        $pageId = $pageId;
//echo MODUE_ID;
//        if (MODULE_ID == 110) {
//            $pageId = 2;
//        }


        $selectstring = $this->getfkarray($pageId, $fkstring);
        $selectarray = explode(",", $selectstring);
        $length = '15';
        $sql = "select p.int_id,p.fk_ParentPageGlCode,p.fk_ModuleGlCode,p.varTitle,a.varAlias,m.varModuleName,case p.fk_ModuleGlCode WHEN 0 THEN CONCAT('" . SITE_PATH . "',a.varAlias) ELSE CONCAT('" . SITE_PATH . "',a.varAlias) end as link from " . DB_PREFIX . "pages p left join " . DB_PREFIX . "alias as a on a.fk_Record = p.int_id left join " . DB_PREFIX . "modules m on m.int_id = p.fk_ModuleGlCode where p.int_id !=1 and p.chrPublish='Y' AND a.fk_ModuleGlCode='2' and p.chrDelete='N' and p.chrMenuDisplay='Y' order by p.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $i = 0;
        if ($count > 0) {
            foreach ($query->result_array() as $result) {
                $pitems[] = $result;
            }
            if ($pitems) {
                foreach ($pitems as $p) {
                    $pt = $p['fk_ParentPageGlCode'];
                    $list = @$children[$pt] ? $children[$pt] : array();
                    array_push($list, $p);
                    $children[$pt] = $list;
                }
            }

            foreach ($children[0] as $record) {
                if ($i < $length && $record['fk_ParentPageGlCode'] == 0) {
                    $uriseg = $this->uri->rsegments;
                    $link = $record['link'];
                    if (MODULE_ID == 2) {
                        if ($record['int_id'] == RECORD_ID) {
                            $sclass = "class='waves-effect active'";
                        } else {
                            $sclass = "class='waves-effect'";
                        }
                    } else if ($record['fk_ModuleGlCode'] == MODULE_ID) {
                        $sclass = "class='waves-effect active'";
                    } else {
                        $sclass = "class='waves-effect'";
                    }
                    if (in_array($record['int_id'], $selectarray)) {
                        $sclass = "class='waves-effect active'";
                    } else {
                        $sclass = "class='waves-effect'";
                    }
                    if (array_key_exists($record['int_id'], $children)) {

                        $Page_title = stripslashes(quotes_to_entities($record['varTitle']));
                        $this->menuString .= '<li><a ' . $sclass . ' href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a><i class="fas fa-angle-right"></i>';
                        $this->menuString .= '<ul class="group-list">';
                        $this->menuString .= $this->getMobileChildMenu($record['int_id'], $children, $selectarray);
                        $this->menuString .= "</ul>";
                        $this->menuString .= "</li>";
                    } else {
                        $title = stripslashes(quotes_to_entities($record['varTitle']));
                        $this->menuString .= '<li><a ' . $sclass . ' href="' . $link . '" title="' . $title . '"><span>' . $title . '</span></a></li>';
                    }

                    $i++;
                }
            }
        }
        $this->menuString .= '</ul>';
        return $this->menuString;
    }

    function getMobileChildMenu($id, $children, $selectarray) {
        if ($children[$id]) {
            foreach ($children[$id] as $subrecord) {
                if (in_array($subrecord['int_id'], $selectarray)) {
                    $subSelclass = "waves-effect active";
                } else {
                    $subSelclass = 'waves-effect';
                }
                $link = $subrecord['link'];
                $Page_title = stripslashes(quotes_to_entities($subrecord['varTitle']));
                if (array_key_exists($subrecord['int_id'], $children)) {
//                    $this->menuString .= '<li><a class="dropdown-toggle" data-toggle="dropdown" href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a><li>';
                } else {
                    $this->menuString .= '<li><a class="' . $subSelclass . '" href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                }
                if (array_key_exists($subrecord['int_id'], $children)) {
                    $this->menuString .= '<li><a class="' . $subSelclass . '" href="#">' . $Page_title . '</a>
                            <ul class="group-list">';
                    $this->menuString .= $this->getMobileChildMenu($subrecord['int_id'], $children, $selectarray);
                    $this->menuString .= "</ul></li>";
                }
            }
        }
    }

    function getTechnologyMenu() {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString2 = "";
        $sql = "SELECT s.*,a.varAlias FROM " . DB_PREFIX . "technology as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE a.fk_ModuleGlCode='110' and s.intProject='0' and s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $i = 0;
        if ($count > 0) {
            foreach ($query->result_array() as $record) {
                $title_tag = stripslashes(quotes_to_entities($record['varName']));
                $link = SITE_PATH . $record['varAlias'];
                $count = $this->common_model->getcountsubtechMenu($record['int_id']);
                if ($count > 0) {

                    $this->menuString2 .= '<li>';
                    $this->menuString2 .= '<a href="' . $link . '" title="' . $title_tag . '"><span class="text-middle">' . $title_tag . '</span></a>';
                    $this->menuString2 .= '<ul class="rd-navbar-dropdown">';
                    $this->menuString2 .= $this->common_model->getsubTechMenu($record['int_id']);
                    $this->menuString2 .= "</ul>";
                    $this->menuString2 .= "</li>";
                } else {

                    $this->menuString2 .= "<li><a href='" . $link . "' title=\"$title_tag\">" . $title_tag . "</a></li>";
                }
            }
        }
        return $this->menuString2;
    }

    function getcountsubtechMenu($id) {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $sql = "SELECT s.*,a.varAlias FROM " . DB_PREFIX . "technology as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE s.intProject='" . $id . "' and a.fk_ModuleGlCode='110' and s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $count = $query->num_rows;

        return $count;
    }

    function GetFirstFooterMenuData($pageId) {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString = "";

        $pageId = $pageId;
        $selectstring = $this->getfkarray($pageId, $fkstring);
        $selectarray = explode(",", $selectstring);
        $length = '6';
        $sql = "select p.int_id,p.fk_ParentPageGlCode,p.fk_ModuleGlCode,p.varTitle,a.varAlias,m.varModuleName,case p.fk_ModuleGlCode WHEN 0 THEN CONCAT('" . SITE_PATH . "',a.varAlias) ELSE CONCAT('" . SITE_PATH . "',a.varAlias) end as link from " . DB_PREFIX . "pages p left join " . DB_PREFIX . "alias as a on a.fk_Record = p.int_id left join " . DB_PREFIX . "modules m on m.int_id = p.fk_ModuleGlCode where p.int_id not in (1) and p.chrPublish='Y' AND (a.fk_ModuleGlCode='2') and p.fk_ParentPageGlCode='0' and p.chrDelete='N' and p.chrDelete='N' and p.chrFooterDisplay='Y' order by p.intDisplayOrder asc limit 6";
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $i = 0;
        if ($count > 0) {
            $j = 1;
            foreach ($query->result_array() as $record) {
                if ($i <= $length) {
                    $title_tag = strtoupper(stripslashes(quotes_to_entities($record['varTitle'])));
                    $this->menuString .= '<div class="col s6 m2 top-padding">';
                    $this->menuString .= "<div class=\"footer-title f-links\"> " . $title_tag . "</div>";
                    $this->menuString .= $this->getchildFooterRecord($record['int_id'], $pageId);
                    $this->menuString .= "</div>";
                    if ($j % 2 == 0) {
                        $this->menuString .= "<div class=\"clearfix\"></div>";
                    }
                }
                $i++;
                $j++;
            }
        }
        return $this->menuString;
    }

    function getchildFooterRecord($perentId, $pageId) {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';

        $pageId = $pageId;
        $selectstring = $this->getfkarray($pageId, $fkstring);
        $selectarray = explode(",", $selectstring);
        $length = '7';
        $sql = "select p.int_id,p.fk_ParentPageGlCode,p.fk_ModuleGlCode,p.varTitle,a.varAlias,m.varModuleName,case p.fk_ModuleGlCode WHEN 0 THEN CONCAT('" . SITE_PATH . "',a.varAlias) ELSE CONCAT('" . SITE_PATH . "',a.varAlias) end as link from " . DB_PREFIX . "pages p left join " . DB_PREFIX . "alias as a on a.fk_Record = p.int_id left join " . DB_PREFIX . "modules m on m.int_id = p.fk_ModuleGlCode where p.int_id not in (1) and p.chrPublish='Y' AND (a.fk_ModuleGlCode='2') and p.fk_ParentPageGlCode='" . $perentId . "' and p.chrDelete='N' and p.chrDelete='N' and p.chrFooterDisplay='Y' order by p.intDisplayOrder asc";
//echo $sql;exit;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $this->menuString1 = "";
        $i = 0;
        if ($count > 0) {
            $this->menuString1 .= '<ul class="footer-link">';
            foreach ($query->result_array() as $result) {
                $pitems[] = $result;
            }
            foreach ($query->result_array() as $record) {
                if ($i < $length) {



                    if (MODULE_ID == 2) {
                        if ($record['int_id'] == RECORD_ID) {
                            $sclass = "class='active'";
                        } else {
                            $sclass = " ";
                        }
                    } else if ($record['fk_ModuleGlCode'] == MODULE_ID) {
                        $sclass = "class='active'";
                    } else {
                        $sclass = "";
                    }
                    if (in_array($record['int_id'], $selectarray)) {
                        $sclass = "class='active'";
                    }
                    $link = $record['link'];
                    if (array_key_exists($record['int_id'], $children)) {
                        
                    } else {
                        $title_tag = stripslashes(quotes_to_entities($record['varTitle']));
                        $this->menuString1 .= "<li $sclass><a title=\"$title_tag\" href=\"$link\"> " . $title_tag . "</a></li>";
                    }
                    $i++;
                }
            }
            $this->menuString1 .= "</ul>";
        }
        return $this->menuString1;
    }

    function GetFooterServiceData() {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString = "";

        $length = '8';
        $sql = "SELECT s.*,a.varAlias FROM " . DB_PREFIX . "services as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE a.fk_ModuleGlCode='105' AND s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.intDisplayOrder asc";
//        $sql = "select * from " . DB_PREFIX . "services where chrDelete='N' and chrPublish='Y' order by intDisplayOrder asc";
//echo $sql;exit;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $i = 0;
        if ($count > 0) {
            foreach ($query->result_array() as $result) {
                $pitems[] = $result;
            }
            foreach ($query->result_array() as $record) {
                if ($i < $length) {
                    if (MODULE_ID == 2) {
                        if ($record['int_id'] == RECORD_ID) {
                            $sclass = "class='active'";
                        } else {
                            $sclass = " ";
                        }
                    } else {
                        $sclass = "";
                    }
                    if (in_array($record['int_id'], $selectarray)) {
                        $sclass = "class='active'";
                    } else {
                        $sclass = "";
                    }
                    $link = SITE_PATH . $record['varAlias'];
                    if (array_key_exists($record['int_id'], $children)) {
                        
                    } else {
                        $title_tag = str_replace('&', '&amp;', $record['varShortName']);
                        $this->menuString .= "<li $sclass><a title=\"$title_tag\" href=\"$link\"> " . $title_tag . "</a></li>";
                    }
                    $i++;
                }
            }
//            $this->menuString.="</ul>";
        }
        return $this->menuString;
    }

    function getChildMenu($id, $children, $selectarray) {
        if ($children[$id]) {
            foreach ($children[$id] as $subrecord) {
                if (in_array($subrecord['int_id'], $selectarray)) {
                    $subSelclass = "active";
                } else {
                    $subSelclass = '';
                }
                $link = $subrecord['link'];
                $Page_title = stripslashes(quotes_to_entities($subrecord['varTitle']));
                if (array_key_exists($subrecord['int_id'], $children)) {
//                    $this->menuString .= '<li><a class="dropdown-toggle" data-toggle="dropdown" href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a><li>';
                } else {
                    $this->menuString .= '<li><a class="' . $subSelclass . '" href="' . $link . '" title="' . $Page_title . '">' . $Page_title . '</a></li>';
                }
                if (array_key_exists($subrecord['int_id'], $children)) {
                    $this->menuString .= '<li><a class="' . $subSelclass . '" href="#">' . $Page_title . '</a>
                            <ul>';
                    $this->menuString .= $this->getChildMenu($subrecord['int_id'], $children, $selectarray);
                    $this->menuString .= "</ul></li>";
                }
            }
        }
    }

    function getProductMenu1() {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString1 = "";
        $sql = "SELECT s.*,a.varAlias FROM " . DB_PREFIX . "products as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE a.fk_ModuleGlCode='96' and s.intProduct='0' and s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.intDisplayOrder asc";
//       echo $sql;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        if ($count > 0) {
            foreach ($query->result_array() as $record) {
                $title_tag = stripslashes(quotes_to_entities($record['varShortName']));
                $link = SITE_PATH . $record['varAlias'];
                $this->menuString1 .= "<li><a href='" . $link . "' title=\"$title_tag\">" . $title_tag . "</a></li>";
//                $this->menuString1 .= "<li><a href='" . $link . "' title=\"$title_tag\">" . $title_tag . "</a></li>";
            }
        }
        return $this->menuString1;
    }

    function getsubTechMenu($id) {
        $Segments = $this->uri->rsegment_array();
        $fkstring = '';
        $this->menuString3 = "";
        $sql = "SELECT s.*,a.varAlias FROM " . DB_PREFIX . "technology as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE s.intProject='" . $id . "' and a.fk_ModuleGlCode='110' and s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.intDisplayOrder asc";
//       echo $sql;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $i = 0;
        if ($count > 0) {
            foreach ($query->result_array() as $record) {
                $title_tag = stripslashes(quotes_to_entities($record['varName']));
                $link = SITE_PATH . $record['varAlias'];
                $this->menuString3 .= "<li><a href='" . $link . "' title=\"$title_tag\"><span class=\"text-middle\">" . $title_tag . "</span></a></li>";
            }
        }
        return $this->menuString3;
    }

    function getUserProducts($id) {
        $sql = "SELECT s.*,a.varAlias FROM " . DB_PREFIX . "product as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE s.intSupplier='" . $id . "' and a.fk_ModuleGlCode='140' and s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        return $count;
    }

    function getUserBuyLeads($id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "buyleads WHERE intUser='" . $id . "' and chrDelete='N'";
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        return $count;
    }

    function getfkarray($pageid, $fkstring = '') {
//$this->db->cache_set_common_path("application/cache/db/common/pages/");
//$this->db->cache_on();
        $sql = "select int_id,fk_ParentPageGlCode from " . DB_PREFIX . "pages where int_id='" . $pageid . "'";
        $query = $this->db->query($sql);
        $count = $query->num_rows;
//$this->db->cache_off();
        $result = $query->row_array();
        if ($count > 0) {
            if ($result['fk_ParentPageGlCode'] != '0') {
                $fkstring .= $result['int_id'] . ',';
                return $this->getfkarray($result['fk_ParentPageGlCode'], $fkstring);
            } else {
                $fkstring .= $result['int_id'];
                return $fkstring;
            }
        } else {
            return $fkstring;
        }
    }

    function getcategoryfkarray($pageid, $fkstring = '') {
        $this->db->cache_set_common_path("application/cache/db/common/pages/");
        $this->db->cache_on();
        $sql = "select int_id,intParentCategory from " . DB_PREFIX . "product_category where int_id='" . $pageid . "'";
//       echo $sql;
        $query = $this->db->query($sql);
        $count = $query->num_rows;
        $this->db->cache_off();
        $result = $query->row_array();
        if ($count > 0) {
            if ($result['intParentCategory'] != '0') {
                $fkstring .= $result['int_id'] . ',';
                return $this->getcategoryfkarray($result['intParentCategory'], $fkstring);
            } else {
                $fkstring .= $result['int_id'];
                return $fkstring;
            }
        } else {
            return $fkstring;
        }
    }

    function generate_random_number() {
        $chars = "0123456789";
        $res = "";
        for ($i = 0; $i < 15; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $res;
    }

    function get_breadcrumdata() {
        $SegmentedArray = $this->uri->rsegment_array();
        if ($SegmentedArray[1] == 'products') {
            $pageId = 60;
        } else {
            $pageId = RECORD_ID;
        }
        $this->breadcrumArray = array();
        $this->get_fkpage_array($pageId, $SegmentedArray);
        $this->breadcrumArray = array_reverse($this->breadcrumArray);
    }

    function get_page_title($id) {
        $sql = "SELECT varTitle FROM " . DB_PREFIX . "pages where int_id='" . $id . "'";
        $result = $this->db->query($sql);
        $res = $result->row_array();
        return $res['varTitle'];
    }

    function get_page_data($id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "pages where int_id='" . $id . "'";
        $result = $this->db->query($sql);
        $res = $result->row_array();
        return $res;
    }

    function get_fkpage_array($page_id, $SegmentedArray) {
        $page_sql = "SELECT p.int_id,p.fk_ParentPageGlCode,p.varTitle,a.varAlias FROM " . DB_PREFIX . "pages p LEFT JOIN " . DB_PREFIX . "alias as a on a.fk_Record = p.int_id  LEFT JOIN " . DB_PREFIX . "modules m ON p.fk_ModuleGlCode=m.fk_ModuleGlCode WHERE p.int_id='" . $page_id . "' AND p.chrDelete='N' AND p.chrPublish='Y' AND a.fk_ModuleGlCode=2";
        $page_result = $this->db->query($page_sql);
        $page_data = $page_result->row();
        $page_array = array();
        $page_array['int_id'] = $page_data->int_id;
        $page_array['varTitle'] = $page_data->varTitle;
        $page_array['var_alias'] = $page_data->varAlias;
        $check_subpage = "SELECT * FROM " . DB_PREFIX . "pages WHERE int_id='" . $page_array['int_id'] . "' AND chrDelete='N' AND chrPublish='Y'";
//            echo $this->db->last_query();
        $subpage_result = $this->db->query($check_subpage);
        if ($subpage_result->num_rows() > 0)
            $page_array['link'] = SITE_PATH . $page_data->varAlias;
        else
            $page_array['link'] = SITE_PATH . $page_data->varAlias;
//print_R($page_array);exit;
        if (!empty($page_array)) {
            $this->breadcrumArray[] = $page_array;
            if ($page_data->fk_ParentPageGlCode != 0 && $page_data->fk_ParentPageGlCode != '')
                $this->get_fkpage_array($page_data->fk_ParentPageGlCode);
        }
    }

    function get_socialmedia_data() {
        $socialmedia_sql = "SELECT varFieldName,varFieldValue FROM " . DB_PREFIX . "generalsettings WHERE chrDelete='N' AND varFieldName IN ('varFacebookLink','varTwitterLink','varLinkedinLink','varPinterestLink') ";
        $socialmedia_result = $this->db->query($socialmedia_sql);
        return $socialmedia_result->row_array();
    }

    function checkValidUrl() {
//        echo "hgiu";exit;
//        echo $_SERVER["HTTPS"];exit;
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
//        echo $_SERVER["SERVER_PORT"];exit;
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
//        echo $pageURL;exit;
        $pageURL = urldecode($pageURL);
        $urlregex = "^(http?|ftp)\:\/\/([a-zA-Z0-9+!*(),;?&=\$_.-]+(\:[a-zA-Z0-9+!*(),;?&=\$_.-]+)?@)?[a-zA-Z0-9+\$_-]+(\.[a-zA-Z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-zA-Z0-9+\$_-]\.?)+)*\/?(\?[a-zA-Z+&\$_.-][a-zA-Z0-9;:@/&%=+\$_.-]*)?(#[a-zA-Z_.-][a-zA-Z0-9+\$_.-]*)?\$^";
        if (preg_match($urlregex, $pageURL)) {
            return true;
        } else {
            return false;
        }
    }

    function get_breadcrumdataService() {
        $SegmentedArray = $this->uri->rsegment_array();
        if (RECORD_ID != "")
            $pageId = RECORD_ID;
        else
            $pageId = $SegmentedArray[3];
        $this->breadcrumArrayService = array();
// $this->get_fkpage_array_services($pageId);
        $this->breadcrumArrayService = array_reverse($this->breadcrumArrayService);
    }

    function get_fkpage_array_services($page_id, $i = 0) {
//     echo $i;
        $page_sql = "SELECT int_id,fk_service,var_title,var_alias FROM " . DB_PREFIX . "service WHERE int_id='" . $page_id . "' AND chr_delete='N' AND chr_publish='Y'";
        $page_result = $this->db->query($page_sql);
        $page_data = $page_result->row();
        $page_array = array();
        $page_array['int_id'] = $page_data->int_id;
        $page_array['var_title'] = $page_data->var_title;
        if ($i != 0) {
            if (SITE_SEO == "Y") {
                $page_array['link'] = SITE_PATH . $page_data->var_alias;
            } else {
                $page_array['link'] = SITE_PATH . "service/details/" . $page_data->int_id;
            }
        }
        if (!empty($page_array)) {
            $this->breadcrumArrayService[] = $page_array;
            if ($page_data->fk_service > 0) {
                $i++;
                $this->get_fkpage_array_services($page_data->fk_service, $i);
            }
        }
    }

    function set_next_prev_url($cur_url = '', $pagenumber = '', $noofpages = '') {
        if ($cur_url != '' && $pagenumber != '' && $noofpages > 1 && $pagenumber <= $noofpages) {
            $prev_url = '';
            $next_url = '';
            $prev_page = $pagenumber - 1;
            $next_page = $pagenumber + 1;
            $prev_href = SITE_PATH . $cur_url . "/" . 'page-' . $prev_page;
            $next_href = SITE_PATH . $cur_url . "/" . 'page-' . $next_page;
            if ($pagenumber == '1') {
                $next_url = '<link rel="next" href="' . $next_href . '">';
            } else if ($pagenumber == $noofpages) {
                $prev_url = '<link rel="prev" href="' . $prev_href . '">';
            } else {
                if ($prev_page == 1) {
                    $prev_url = '<link rel="prev" href="' . SITE_PATH . $cur_url . '">';
                } else {
                    $prev_url = '<link rel="prev" href="' . $prev_href . '">';
                }
                $next_url = '<link rel="next" href="' . $next_href . '">';
            }
            $return_url = $prev_url . $next_url;
            $this->next_prev_url = $return_url;
        }
    }

    function Insert_Alias($Alias_Array) {
        $data = array("fk_ModuleGlCode" => $Alias_Array['fk_ModuleGlCode'],
            "fk_Record" => $Alias_Array['fk_Record'],
            "varAlias" => $Alias_Array['varAlias'],
        );
        $this->db->insert("alias", $data);
    }

    function Update_Alias($Alias_Array) {
        $this->db->select('int_id');
        $this->db->from('alias');
        $this->db->where('fk_ModuleGlCode', $Alias_Array['fk_ModuleGlCode']);
        $this->db->where('fk_Record', $Alias_Array['fk_Record']);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        if ($rowcount == 0) {
            $this->Insert_Alias($Alias_Array);
        } else {
            $data = array("varAlias" => $Alias_Array['varAlias']);
            $this->db->where('fk_ModuleGlCode', $Alias_Array['fk_ModuleGlCode']);
            $this->db->where('fk_Record', $Alias_Array['fk_Record']);
            $this->db->update('alias', $data);
        }
    }

    function Delete_Alias($fk_ModuleGlCode, $fk_Record) {
        $this->db->where('fk_ModuleGlCode', $fk_ModuleGlCode);
        $this->db->where_in('fk_Record', $fk_Record);
        $this->db->delete('alias');
    }

    function get_alias_value($fk_ModuleGlCode, $fk_Record) {
        $Alias = $this->db->get_where('alias', array('fk_ModuleGlCode' => $fk_ModuleGlCode, "fk_Record" => $fk_Record));
        $Rs = $Alias->Row();
        return $Rs->varAlias;
    }

    function Clean_String($String) {
        $String = str_replace(' ', '_', $String);
        return preg_replace('/[^A-Za-z0-9.\-]/', '', $String);
    }

// This function called from MY_Controller.php
    function isMobile() {
        $returndevice = "mobile";
        $returnbrowser = "pc";
// Check the server headers to see if they're mobile friendly
        if (isset($_SERVER["HTTP_X_WAP_PROFILE"])) {
            return $returndevice;
        }
// If the http_accept header supports wap then it's a mobile too
        if (preg_match("/wap\.|\.wap/i", $_SERVER["HTTP_ACCEPT"])) {
            return $returndevice;
        }
        if (preg_match("/iPad/i", $_SERVER["HTTP_USER_AGENT"])) {
            return $returnbrowser;
        }
// Let's NOT return "mobile" if it's an iPhone, because the iPhone can render normal pages quite well.
        if (preg_match("/iphone/i", $_SERVER["HTTP_USER_AGENT"])) {
            return $returndevice;
        }
// Still no luck? Let's have a look at the user agent on the browser. If it contains
// any of the following, it's probably a mobile device. Kappow!
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $user_agents = array("midp", "j2me", "avantg", "docomo", "novarra", "palmos", "palmsource", "240x320", "opwv", "chtml", "pda", "windows\ ce", "mmp\/", "blackberry", "mib\/", "symbian", "wireless", "nokia", "hand", "mobi", "phone", "cdm", "up\.b", "audio", "SIE\-", "SEC\-", "samsung", "HTC", "mot\-", "mitsu", "sagem", "sony", "alcatel", "lg", "erics", "vx", "NEC", "philips", "mmm", "xx", "panasonic", "sharp", "wap", "sch", "rover", "pocket", "benq", "java", "pt", "pg", "vox", "amoi", "bird", "compal", "kg", "voda", "sany", "kdd", "dbt", "sendo", "sgh", "gradi", "jb", "\d\d\di", "moto");
            foreach ($user_agents as $user_string) {
                if (preg_match("/" . $user_string . "/i", $_SERVER["HTTP_USER_AGENT"])) {
                    return $returndevice;
                }
            }
        }
// None of the above? Then it's probably not a mobile device.
        return $returnbrowser;
    }

    public function ChekRecordExist($TableName, $File = "") {
        $this->db->where('varPdfFile', $File);
        $this->db->where(array("chrDelete" => "N", "chrPublish" => "Y"));
        $SQL = $this->db->get($TableName);
        if ($SQL->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_banner($Record_id) {
        $Chr_banner_Type = '';
        if ($Record_id == '1') {
            $Chr_banner_Type = 'H';
        } else {
            $Chr_banner_Type = 'I';
        }
        $returnArry = array();
        $this->db->where(array("chrDelete" => "N", "chrPublish" => "Y", "Chr_Banner_Type" => $Chr_banner_Type));
        if (RECORD_ID != 1) {
            $this->db->where(array("Fk_Pages_Inner" => RECORD_ID));
        } //if not home page then load inner banner. 
        $this->db->order_by("intDisplayOrder", "asc");
        $query = $this->db->get('Banner');
        if ($query->num_rows() > 0) {
            $returnArry = $query->result();
        }
        return $returnArry;
    }

    function GetImageNameOnly($ImageNameString) {
        $ImageNameArray = explode(".", $ImageNameString);
        $NewArray = array_pop($ImageNameArray);
        $ImageName = implode(".", $ImageNameArray);
        return $ImageName;
    }

    public function getContactInfo() {
        $this->db->where(array("chrDelete" => "N", "chrPublish" => "Y"));
        $SQL = $this->db->get('contactinfo');
        if ($SQL->num_rows() > 0) {
            return $SQL->row_array();
        } else {
            return false;
        }
    }

    function get_contactusdata() {
        $sql = "select * from " . DB_PREFIX . "contactinfo where chrDelete='N' and chrPublish='Y' and int_id=1";
        $query = $this->db->query($sql);
        $result = $query->row_array();
//        $email1 = $this->generate_contactus_mail_image($result['varEmail']);
        define('MESSENGER_LINK', $result['varMessenger']);
        define('CONTACT_PHONE', $result['varPhone']);
        define('EMAIL_ADD', $result['varEmail']);
        define('ADDRESS_ADD', $result['varAddress']);
    }

    function generateCaptcha($Capthtitle) {
        $this->session->set_userdata($Capthtitle . "_pin_value", md5(rand(2, 99999999)));
        $generated_pin = $this->mylibrary->generate_pin($this->session->userdata($Capthtitle . "_pin_value"));
        $this->generated_pin = $generated_pin;
        $this->session->set_userdata($Capthtitle . '_generated_pin', $generated_pin);
        $pin_image_output = $this->mylibrary->show_pin_image($this->session->userdata($Capthtitle . "_pin_value"), $generated_pin);
        $this->pin_image_output = $pin_image_output;
    }

    public function refershcaptcha($refCapthtitle) {
        $this->session->set_userdata($refCapthtitle . "_pin_value", md5(rand(2, 99999999)));
        $generated_pin = $this->mylibrary->generate_pin($this->session->userdata($refCapthtitle . "_pin_value"));
        $this->generated_pin = $generated_pin;
        $this->session->set_userdata($refCapthtitle . '_generated_pin', $generated_pin);
        echo $this->mylibrary->show_pin_image($this->session->userdata($refCapthtitle . "_pin_value"), $generated_pin) . '#' . $generated_pin;
        exit;
    }

    function handle_captcha() {
        $h_code = $this->input->get_post('cptimage1', true);
        $sessionData = $this->session->userdata("generated_pin_contactus");
        if ($sessionData != $h_code) {
            $this->form_validation->set_message('handle_captcha', 'Please enter the captcha code exactly as mentioned in order to verify and continue.');
            return false;
        } else {
            return true;
        }
    }

    function getbreadcrumdata($id, $pageId) {
        $uriseg = $this->uri->rsegments;
        $pageId = $pageId;
        $currPageId = array($pageId);
        $selectarray = $currPageId;
        $id = $this->input->get_post('Id');
        $fkstring = '';
        $result = $this->getfkarray($pageId, $fkstring);
        $fkarray = explode(',', $result);
        $revfkarray = array_reverse($fkarray);
        $revfkarray = implode(',', $revfkarray);
        $revfkarray = trim($revfkarray, ',');
        if (MODULE == 'product' && $uriseg[2] == 'details') {
            $eventssql = "select varName as title from " . DB_PREFIX . "product WHERE int_id='" . RECORD_ID . "'";
            $eventsdetail = $this->db->query($eventssql);
            $eventsrow = $eventsdetail->row_array();
        } else if (MODULE == 'product_category' && $uriseg[2] == 'details') {

            $fkstring = '';
            $result = $this->getcategoryfkarray($pageId, $fkstring);
            $fkarray = explode(',', $result);
            $revfkarray1 = array_reverse($fkarray);
            $revfkarray1 = implode(',', $revfkarray1);
            $revfkarray1 = trim($revfkarray1, ',');

            $sql = "select p.int_id,p.intParentCategory,a.varAlias,p.varName as varTitle,a.fk_ModuleGlCode,
                     CONCAT('" . SITE_PATH . "',a.varAlias) as link
                      from " . DB_PREFIX . "product_category p left join " . DB_PREFIX . "alias as a on a.fk_Record  = p.int_id  where  a.fk_ModuleGlCode='" . MODULE_ID . "' and p.int_id IN($revfkarray1) group by p.int_id order by p.int_id asc";
            $rs = $this->db->query($sql);
            $countdata = $rs->num_rows();
            $resultdata1 = $rs->result_array($rs);
            $resultdata = array_reverse($resultdata1);
        } else {
            $sql = "select p.int_id,p.fk_ParentPageGlCode,a.varAlias,p.varTitle,m.varTitle as modulename,p.fk_ModuleGlCode,
                      case p.fk_ModuleGlCode  WHEN 0 THEN CONCAT('" . SITE_PATH . "',a.varAlias)
                      ELSE CONCAT('" . SITE_PATH . "',a.varAlias) end as link
                      from " . DB_PREFIX . "pages p left join " . DB_PREFIX . "modules m on m.int_id=p.fk_ModuleGlCode  left join " . DB_PREFIX . "alias as a on a.fk_Record  = p.int_id  where  a.fk_ModuleGlCode='" . MODULE_ID . "' and p.int_id IN($revfkarray) group by p.int_id order by p.int_id asc";
//            echo $sql;
            $rs = $this->db->query($sql);
            $countdata = $rs->num_rows();
            $resultdata1 = $rs->result_array($rs);
            $resultdata = array_reverse($resultdata1);
        }
        if ($countdata > 0) {

            $i = 1;
            foreach ($resultdata as $row) {
                $brd_link = $row["link"];
                if ($_GET['type'] == 'rfq') {
                    $brd_link = $brd_link . "?type=rfq";
                }
                $m = (RECORD_ID != $row['int_id']) ? '<li><a class="waves-effect waves-light btn" title="' . $row['varTitle'] . '" href="' . $brd_link . '" >' . $row['varTitle'] . '</a></li>' : '<li class="active waves-effect waves-light btn">' . $row['varTitle'] . '  </li>';
                $pagetitle = $row['varTitle'];
                $data .= $m;
                $i++;
            }
        }

//        if (MODULE == 'product' && $uriseg[2] == 'details') {
//            $sql_events = "select varName from " . DB_PREFIX . "product where chrDelete='N' and chrPublish='Y' and int_id=$uriseg[3]";
//            $query_events = $this->db->query($sql_events);
//            $data_events = $query_events->row_array();
//            $Get_events_Url = $this->getUrl("pages", "2", "51", '');
//            $events = $eventsrow['title'];
//            $sql = "select varName from " . DB_PREFIX . "pages where fk_ModuleGlCode=" . MODULE_ID;
//            $query = $this->db->query($sql);
//            $result = $query->row_array();
//            $innerpagetitle .= '<li><a class="waves-effect waves-light btn" title="Product Categories" href="' . $category_link . '" >Product Categories</a></li>';
//        }

        if (MODULE == 'product' && $uriseg[2] == 'details') {
            $Get_product_Url = $this->getUrl("pages", "2", "51", '');
            $innerpagetitle .= '<li><a class="waves-effect waves-light btn" title="Products" href="' . $Get_product_Url . '" >Products</a></li>';
        }

        if ($innerpagetitle != '') {
            $data .= $innerpagetitle;
        }
        $category_link = $this->getUrl("pages", "2", "53", '');
//        echo MODULE_ID;
        if (RECORD_ID != '53' && MODULE_ID == '113') {
            if ($_GET['type'] == 'rfq') {
                $category_link = $category_link . "?type=rfq";
            }
            $data .= '<li><a class="waves-effect waves-light btn" title="Product Categories" href="' . $category_link . '" >Product Categories</a></li>';
        }
        $data .= '<li><a href="' . SITE_PATH . '" class="waves-effect waves-light btn"><i class="fa fa-home"></i></a></li>';
        return $data;
    }

    function setbreadcrum($breadcrumdata) {
        $activeData = $this->getpagedata(RECORD_ID);
//        print_r($activeData);exit;
        $link = SITE_PATH_ALTER;
        $breadcrum = '';
        $breadcrum .= '
<li><a href="' . $link . '" title="Home">Home</a></li>';
        $breadcrum .= $breadcrumdata;
        return $breadcrum;
    }

    function setbreadcrumcontact($breadcrumdata) {
        $activeData = $this->getpagedata(RECORD_ID);
//        print_r($activeData);exit;
        $link = SITE_PATH_ALTER;
        $breadcrum = '';
        $breadcrum .= '<div class="top-bg">
<div class="container">
<div class="breadcrumb">
<ol>
<li><a href="' . $link . '" title="Home" >Home</a></li>';
        $breadcrum .= $breadcrumdata . '</ol></div>';
        return $breadcrum;
    }

// This function called from MY_Controller.php
    function checkiosversion() {
        if (preg_match("/iphone/i", $_SERVER["HTTP_USER_AGENT"])) {
            $version = preg_replace("/(.*) OS ([0-9]*)_(.*)/", "$2", $_SERVER['HTTP_USER_AGENT']);
            return $version;
        }
    }

    public function select_Products() {
        $sql = "select P.*,A.varAlias as alias,A.fk_Record AS FkRecord, A.fk_ModuleGlCode as Module_Id from " . DB_PREFIX . "pages as P left join " . DB_PREFIX . "alias as A on A.fk_Record=P.int_id where P.int_id in (24,25,26,27) and P.chrDelete='N' and P.chrPublish='Y' group by P.int_id order by P.intDisplayOrder";
//       echo $sql;exit; 
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
//print_r($result_query);
        return $result_query;
    }

    public function GetFooterMenuPagesData($pageId) {
        $sql = "select P.*,A.varAlias as Alias from " . DB_PREFIX . "pages as P left join " . DB_PREFIX . "alias as A on A.fk_Record=P.int_id and A.fk_ModuleGlCode =2 where P.chrDelete='N' and P.chrPublish='Y' group by P.int_id order by P.intDisplayOrder";
//       echo $sql;exit; 
        $result = $this->db->query($sql);
        $data = $result->result_array();
        return $data;
    }

    function get_page_name($id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "pages where chrDelete='N' AND chrPublish='Y' and int_id=" . $id . " ";
        $result = $this->db->query($sql);
        $res = $result->row_array();
        return $res['varTitle'];
    }

    function get_page_link($id) {
        $sql = "SELECT * FROM " . DB_PREFIX . "alias where fk_Record=" . $id;
        $result = $this->db->query($sql);
        $res = $result->row_array();
        return $res['varAlias'];
    }

    public function select_social() {
        $sql = "select * from " . DB_PREFIX . "generalsettings where chrDelete='N'";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
//print_r($result_query);
        return $result_query;
    }

    public function getProductCategory($id = '1', $table_name = 'product_category', $uriseg) {
        $sql = "select varName from " . DB_PREFIX . $table_name . " where chrDelete='N' and chrPublish='Y' and int_id=" . $id . "";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getProduct($id = '1', $table_name = 'product', $uriseg) {
        $sql = "select varName from " . DB_PREFIX . $table_name . " where chrDelete='N' and chrPublish='Y' and int_id=" . $id . "";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    public function getProductss($id = '1', $table_name = 'products', $uriseg) {
//        $sql = "select varShortName,intProduct from " . DB_PREFIX . $table_name . " where chrDelete='N' and chrPublish='Y' and int_id=" . $id . "";
        $sql = "SELECT s.*,a.varAlias FROM " . DB_PREFIX . "products as s left join " . DB_PREFIX . "alias as a on a.fk_Record=s.int_id WHERE s.int_id='$id' and a.fk_ModuleGlCode='96' and s.chrDelete='N' AND s.chrPublish='Y' group by s.int_id order by s.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    function SelectUser($id) {
        $sql = "select * from " . DB_PREFIX . "members WHERE chrPublish='Y' and chrDelete='N' and int_id='" . $id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function checkProductFav($id, $user_id = '') {
        if ($user_id == '') {
            $user_id = 1;
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "favourite where intProduct='" . $id . "' and intUser='" . $user_id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->num_rows();
        return $result_query;
    }

    function checkProductFavBuyLead($id, $user_id = '') {
        if ($user_id == '') {
            $user_id = 1;
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "favourite_buylead where intBuylead='" . $id . "' and intUser='" . $user_id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->num_rows();
        return $result_query;
    }

    function CheckPublish($chk_id) {
        $sql = "SELECT chrPublish,chrDelete FROM " . DB_PREFIX . "pages where int_id= $chk_id";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    public function GetgetLoginCount() {
        $sql = "select count(*) as countlogin from " . DB_PREFIX . "loginhistory where PUserGlCode='" . ADMIN_ID . "'";
//       echo $sql;
        $query = $this->db->query($sql);
        $data = $query->row_array();
//        return $data;
        if ($data['countlogin'] == '1') {
            $sqls = "select count(*) as countlogin from " . DB_PREFIX . "loginhistory where dtLoginDate > (now() - INTERVAL 10 SECOND) and PUserGlCode='" . ADMIN_ID . "'";
//           echo $sqls;
            $querys = $this->db->query($sqls);
            $dataa = $querys->row_array();
            return $dataa;
        } else {
            return $data;
        }
//        echo $this->db->last_query();exit;
//        echo $data;exit;
    }

    function getShowAllServiceRecords() {
        $sql = "SELECT * FROM " . DB_PREFIX . "services where chrDelete='N' and chrPublish='Y' order by intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getTradeShowRecords() {
        $sql = "select E.*,A.varAlias from " . DB_PREFIX . "trade_events E LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record WHERE E.chrPublish='Y' and E.dtEventDate > CURDATE() and A.fk_ModuleGlCode='154' and E.chrDelete='N' group by E.int_id order by E.dtEventDate asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getShowAllBuyLeadsRecords() {
        $sql = "select E.*,A.varAlias,P.varName as productname,U.varName as varMOQUnit from " . DB_PREFIX . "buyleads E LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record LEFT JOIN " . DB_PREFIX . "product P ON P.int_id=E.intProduct LEFT JOIN " . DB_PREFIX . "unit_master U ON U.int_id=E.intEUnit WHERE E.chrPublish='Y' and A.fk_ModuleGlCode='147' and E.chrDelete='N' group by E.int_id order by E.int_id desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getSupplierRecords() {
        $sql = "SELECT varName,varCompany,varCity,varCountry,varImage,int_id,varSubdomain FROM " . DB_PREFIX . "users where chrDelete='N' and chrType='BS' and chrPublish='Y' and chrPayment='Y' order by varPaymentDate desc limit 30";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getShowAllProductRecords() {
        $sql = "select E.varName,E.int_id,E.varImage,A.varAlias,U.chrPayment,U.varSubdomain,U.varCity,U.varCountry,U.varCompany from " . DB_PREFIX . "product E "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users U ON U.int_id=E.intSupplier  WHERE U.chrType='BS' and E.chrPublish='Y' and A.fk_ModuleGlCode='140' and E.chrDelete='N' group by E.int_id order by U.chrPayment desc,U.intPlan desc limit 30";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getUserProductRecords($id) {
        $sql = "select E.*,A.varAlias,AU.varAlias as usersite,U.varSubdomain,U.varCity,U.varCountry,U.varCompany from " . DB_PREFIX . "product E LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record LEFT JOIN " . DB_PREFIX . "users U ON U.int_id=E.intSupplier LEFT JOIN " . DB_PREFIX . "alias AU ON U.int_id=AU.fk_Record WHERE U.chrType='BS' and E.chrPublish='Y' and A.fk_ModuleGlCode='140' and AU.fk_ModuleGlCode='136' and E.intSupplier='" . $id . "' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc";
//        echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function getMOQData() {
        $query = $this->db->query("select * from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select  id=\"intUnit\" name=\"intUnit\" >";
        $returnHtml .= '<option value="" disabled selected>MOQ Units<sup>*</sup></option>';
        foreach ($Result as $row) {
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

    function getRfqMOQData($id = "") {
        $query = $this->db->query("select int_id,varName from " . DB_PREFIX . "unit_master where chrDelete = 'N' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select  id=\"intUnit\" name=\"intUnit\" >";
        $returnHtml .= '<option value="" disabled selected>MOQ Units<sup>*</sup></option>';
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

    public function getDefaultImg($id) {
        $sql = " select varImage from " . DB_PREFIX . "productgallery where chrDelete='N' and fkProduct='" . $id . "' order by int_id asc limit 1";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data["varImage"];
    }

    function checkUniqueSupplierFeedback($user_id, $website = '') {
        if ($website == '') {
            $website = RECORD_ID;
        }
        // exit;
        $this->db->select('*');
        $this->db->from('rating_supplier');
        $this->db->where('intSupplier', $user_id);
        $this->db->where('intWebsite', $website);
        $query = $this->db->get();
//  echo $this->db->last_query();exit;
        return $query->num_rows();
    }

    function getSupplierFeedback($user_id) {
        $this->db->select('r.*,u.varName as Username,u.varCompany');
        $this->db->from('rating_supplier as r');
        $this->db->join('users AS u', 'u.int_id = r.intSupplier', 'left', false);
        $this->db->where('r.intWebsite', $user_id);
        $this->db->group_by('r.int_id');
        $this->db->order_by('r.int_id', 'desc');
        $this->db->limit('10');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getAvgFeedback($user_id) {
        $this->db->select('*');
        $this->db->from('rating_supplier as r');
//        $this->db->join('users AS u', 'u.int_id = r.intSupplier', 'left', false);
        $this->db->where('r.intWebsite', $user_id);
        $this->db->group_by('r.int_id');
        $query = $this->db->get();
        return $query->result_array();
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
//        echo $sql;
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
        $sql = "select E.*,A.varAlias,AU.varAlias as usersite,U.varCity,U.varCountry,U.varCompany,U.chrPayment,U.varSubdomain from " . DB_PREFIX . "product E "
                . "LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record "
                . "LEFT JOIN " . DB_PREFIX . "users U ON U.int_id=E.intSupplier "
                . "LEFT JOIN " . DB_PREFIX . "alias AU ON U.int_id=AU.fk_Record "
                . "WHERE U.chrType='BS' and E.chrPublish='Y' and E.intSupplier='" . $id . "' and A.fk_ModuleGlCode='140' and AU.fk_ModuleGlCode='136' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc limit 20";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getBlog($id = '1', $table_name = 'blogs', $uriseg) {
        $sql = "select * from " . DB_PREFIX . $table_name . " where chrDelete='N' and chrPublish='Y' and int_id=" . $id . "";
//        $sql = "select varTitle,varImage,varShortDesc from " . DB_PREFIX . $table_name . " where chrDelete='N' and chrPublish='Y' and int_id=" . $id . "";
//       echo $sql;exit;
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data;
    }

    function updatequote_now_leads($id, $user_id = '') {
        if ($user_id == '') {
            $user_id = 1;
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "quotenow_access where intBuylead='" . $id . "' and intUser='" . $user_id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->num_rows();
        if ($result_query == 0) {
            $datas = array(
                'intUser' => $user_id,
                'intBuylead' => $id,
                'chrDelete' => 'N',
                'chrPublish' => 'Y',
                'dtCreateDate' => date('Y-m-d H:i:s'),
                'varIpAddress' => $_SERVER['REMOTE_ADDR']
            );
            $query = $this->db->insert(DB_PREFIX . 'quotenow_access', $datas);
            $id = $this->db->insert_id();

            $this->db->set('intQuoteLeft', 'intQuoteLeft-1', FALSE);
            $this->db->where('int_id', $user_id);
            $this->db->update('users');
        }
        return $result_query;
    }

    function checkQuote_now_leads($id, $user_id = '') {
        if ($user_id == '') {
            $user_id = 1;
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "quotenow_access where intBuylead='" . $id . "' and intUser='" . $user_id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->num_rows();
        return $result_query;
    }
    function getPlanData($id) {
        if ($id == '') {
            $id = 1;
        }
        $sql = "SELECT * FROM " . DB_PREFIX . "plans where int_id='" . $id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->row_array();
        return $result_query;
    }

}

?>
