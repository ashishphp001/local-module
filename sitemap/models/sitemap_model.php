<?php

class sitemap_model extends CI_Model {

    var $ulcount = 1;

    function __construct() {
        
    }

    function GetSiteMapData($pageId) {
        $this->menuString = "";
        $sql = "select p.int_id,p.fk_ParentPageGlCode,p.fk_ModuleGlCode,p.varTitle,a.varAlias,m.varModuleName,case p.fk_ModuleGlCode WHEN 0 THEN CONCAT('" . SITE_PATH . "',a.varAlias) ELSE CONCAT('" . SITE_PATH . "',a.varAlias) end as link
                from " . DB_PREFIX . "pages p left join " . DB_PREFIX . "alias as a on a.fk_Record = p.int_id left join " . DB_PREFIX . "modules m on m.int_id = p.fk_ModuleGlCode 
		 where p.chrPublish='Y' AND a.fk_ModuleGlCode='2' and p.chrDelete='N' and p.int_id NOT IN (1,85,47,48,107,94,103,106,104,105,98,95,97,96,109) order by p.chrFooterDisplay desc,p.intDisplayOrder asc";
//        echo $sql;
//        die;
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
//            $this->menuString .= '<li class="post-meta inset-left-20"><span class="icon icon-xxs text-middle mdi mdi-file-document"></span> <span class="text-middle"><a title="Home" href="' . SITE_PATH . '">Home</a></span></li>';

            $j = 1;
            $k = 1;
            $otherdata = array();
            foreach ($children[0] as $record) {
                if (array_key_exists($record['int_id'], $children)) {

                    $link = $record['varAlias'];

                    $Page_title = str_replace('&', '&amp;', $record['varTitle']);
                    $this->menuString .= '<div class="col s12 m4 top-padding">';
                    $this->menuString .= '<div class="footer-title f-links">' . $Page_title . '</div>';
                    $this->menuString .= '<ul class="footer-link">';
                    $this->menuString .= $this->getChildMenu($record['int_id'], $children, $selectarray_header_menu);
                    $this->menuString .= "</ul>";
                    $this->menuString .= "</div>";
                    if ($j % 3 == 0) {
                        $this->menuString .= '<div class="clearfix"></div>';
                    }
                } else {
                    $link = $record['varAlias'];
                    if ($k <= 7) {
                        $otherdata[] = array(
                            'varAlias' => $record['varAlias'],
                            'varTitle' => $record['varTitle']
                        );
                    } else {
                        $otherdata1[] = array(
                            'varAlias' => $record['varAlias'],
                            'varTitle' => $record['varTitle']
                        );
                    }
                    $k++;

//                    $Page_title = str_replace('&', '&amp;', $record['varTitle']);
//                    $this->menuString .= '<li><a title="' . htmlspecialchars($Page_title) . '" href="' . $link . '"><i class="fab fa-digital-ocean"></i>' . $Page_title . '</a></li>';
                }
                $i++;
                $j++;
            }

            $this->menuString .= '<div class="col s12 m4 top-padding">';
            $this->menuString .= '<div class="footer-title f-links">Other Links</div>';
            $this->menuString .= '<ul class="footer-link">';
            foreach ($otherdata as $other) {
                $this->menuString .= '<li><a title="' . htmlspecialchars($other['varTitle']) . '" href="' . $other['varAlias'] . '"><i class="fab fa-digital-ocean"></i>' . $other['varTitle'] . '</a></li>';
            }
            $this->menuString .= '</ul></div>';

            $this->menuString .= '<div class="col s12 m4 top-padding">';
            $this->menuString .= '<div class="footer-title f-links">&nbsp;</div>';
            $this->menuString .= '<ul class="footer-link">';
            foreach ($otherdata1 as $other) {
                $this->menuString .= '<li><a title="' . htmlspecialchars($other['varTitle']) . '" href="' . $other['varAlias'] . '"><i class="fab fa-digital-ocean"></i>' . $other['varTitle'] . '</a></li>';
            }
            $this->menuString .= '<li><a href="' . SITE_PATH . 'sitemap.xml" target="_blank" ><i class="fab fa-digital-ocean"></i>XML Sitemap</li>';
            $this->menuString .= '</ul></div>';
        }


        return $this->menuString;
    }

    function getChildMenu($id, $children, $selectarray) {


        if ($children[$id]) {
            foreach ($children[$id] as $subrecord) {
                $link = $subrecord['link'];
                if (array_key_exists($subrecord['int_id'], $children)) {
                    $this->menuString .= '<li><a href="' . $link . '" title="' . htmlspecialchars($subrecord['varTitle']) . '"><i class="fab fa-digital-ocean"></i>' . $subrecord['varTitle'] . '</a></li>';
                } else {
                    $this->menuString .= '<li><a href="' . $link . '" title="' . htmlspecialchars($subrecord['varTitle']) . '"><i class="fab fa-digital-ocean"></i>' . $subrecord['varTitle'] . '</a></li>';
                }

                if (array_key_exists($subrecord['int_id'], $children)) {
                    $this->menuString .= "<ul class=\"footer-link\">";
                    $this->menuString .= $this->getChildMenu($subrecord['int_id'], $children, $selectarray);
                    $this->menuString .= "</ul></li>";
                }
            }
        }
    }

    function get_portfolio_data() {
        $sql = "select E.*,a.varAlias as alias from " . DB_PREFIX . "projects E LEFT JOIN " . DB_PREFIX . "alias as a on a.fk_Record = E.int_id WHERE E.chrPublish='Y' and E.chrDelete='N' and a.fk_ModuleGlCode=96 group by E.int_id order by E.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        $Services = '';

        foreach ($data as $value) {
            $Services .= '<li class="post-meta inset-left-20"><span class="icon icon-xxs text-middle mdi mdi-bulletin-board"></span> <span class="text-middle"><a href="' . SITE_PATH . $value["alias"] . '" title="' . $value["varShortName"] . '" class="' . $Class . '">' . $value["varShortName"] . '</a></span></li>';
        }
        return $Services;
    }

    function get_blog_data() {
        $sql = "select E.*,a.varAlias as alias from " . DB_PREFIX . "blogs E LEFT JOIN " . DB_PREFIX . "alias as a on a.fk_Record = E.int_id WHERE E.chrPublish='Y' and E.chrDelete='N' and a.fk_ModuleGlCode=124 group by E.int_id order by E.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        $blog = '';

        foreach ($data as $value) {
            $blog .= '<li class="post-meta inset-left-20"><span class="icon icon-xxs text-middle mdi mdi-arrange-send-to-back"></span> <span class="text-middle"><a href="' . SITE_PATH . $value["alias"] . '" title="' . $value["varShortName"] . '" class="' . $Class . '">' . $value["varShortName"] . '</a></span></li>';
        }
        return $blog;
    }

    function get_ServiceData() {
        $sql = "select E.*,a.varAlias as alias from " . DB_PREFIX . "technology E LEFT JOIN " . DB_PREFIX . "alias as a on a.fk_Record = E.int_id WHERE E.chrPublish='Y' and E.chrDelete='N' and a.fk_ModuleGlCode=110 and E.intProject='0' group by E.int_id order by E.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        $service = '';

        foreach ($data as $value) {

            $service .= '<ul class="list list-unstyled">'
                    . '<li class="post-meta inset-left-20"><i class="fas fa-globe"></i> <span class="text-middle">&nbsp;&nbsp;<a href="' . SITE_PATH . $value["alias"] . '" title="' . $value["varName"] . '" class="' . $Class . '">' . $value["varName"] . '</a></span>';
            $sqls = "select E.*,a.varAlias as alias from " . DB_PREFIX . "technology E LEFT JOIN " . DB_PREFIX . "alias as a on a.fk_Record = E.int_id WHERE E.chrPublish='Y' and E.chrDelete='N' and a.fk_ModuleGlCode=110 and E.intProject='" . $value['int_id'] . "' group by E.int_id order by E.intDisplayOrder asc";
            $querys = $this->db->query($sqls);
            $datas = $querys->result_array();
            if (count($datas) > 0) {
                $service .= '<ul class="list list-unstyled">';
                foreach ($datas as $values) {
                    $service .= '<li class="post-meta inset-left-20"><span class="icon icon-xxs text-middle mdi mdi-briefcase"></span> <span class="text-middle"><a href="' . SITE_PATH . $values["alias"] . '" title="' . $values["varName"] . '" class="' . $Class . '">' . $values["varName"] . '</a></span></li>';
                }
                $service .= '</ul>';
            }
            $service .= '</li></ul>';
        }
        return $service;
    }

    function get_SocialData() {
        $sql = "select E.*,a.varAlias as alias from " . DB_PREFIX . "blogs E LEFT JOIN " . DB_PREFIX . "alias as a on a.fk_Record = E.int_id WHERE E.chrPublish='Y' and E.chrDelete='N' and a.fk_ModuleGlCode=124 group by E.int_id order by E.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        $social = '';

        foreach ($data as $value) {
            $social .= '<li class="post-meta inset-left-20"><span class="icon icon-xxs text-middle mdi mdi-arrange-send-to-back"></span> <span class="text-middle"><a href="' . SITE_PATH . $value["alias"] . '" title="' . $value["varShortName"] . '" class="' . $Class . '">' . $value["varShortName"] . '</a></span></li>';
        }
        return $social;
    }

}

?>
