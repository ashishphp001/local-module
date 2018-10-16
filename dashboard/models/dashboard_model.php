<?php

class dashboard_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    function updatedisplay() {
//        $this->db->cache_set_common_path("application/cache/db/common/productleads/");
//        $this->db->cache_delete();

        $tablename = $this->input->get_post('tablename');
        $fieldname = $this->input->get_post('fieldname');
        $value = $this->input->get_post('value');
        $idname = $this->input->get_post('id');

        $updateSql = "UPDATE {$tablename} SET {$fieldname}='{$value}' WHERE  int_id in ({$idname}) ";
        $res = $this->db->query($updateSql) or die(mysql_error());
        return ($res) ? "1" : "0";
    }

    function addEvent() {

        $date = $this->input->get_post('date');
        $title = $this->input->get_post('title');
        $url = $this->input->get_post('url');
        $timeStart = $this->input->get_post('timeStart');
        $timeEnd = $this->input->get_post('timeEnd');

        $data = array(
            'dtEventDate' => date('Y-m-d', strtotime($date)),
            'varTitle' => $title,
            'varURL' => $url,
            'varStartTime' => $timeStart,
            'varEndTime' => $timeEnd,
            'intUser' => ADMIN_ID,
            'chrDelete' => 'N',
            'chrPublish' => 'Y',
            'dtCreateDate' => date('Y-m-d H-i-s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'PUserGlCode' => ADMIN_ID
        );
        $this->db->insert(DB_PREFIX . 'events', $data);
    }

    function pagesData() {

        $wherecondtion = ('P.chrDelete="N" and P.chrPublish="Y" and A.fk_ModuleGlCode = "2"');
        $this->db->select('P.*,A.intPageHits as PagesHits,A.intMobileHits as MobileHits', false);
        $this->db->from('alias as A', false);
        $this->db->join('pages as P', 'P.int_id = A.fk_Record', 'left');
        $this->db->where("$wherecondtion", NULL, FALSE);
        $this->db->limit(5, 0);
        $this->db->group_by('P.int_id', false);
        $this->db->order_by('A.intPageHits Desc');
        $Query = $this->db->get();
        return $Query;
    }

    function getEvents() {


        $this->db->select("e.dtEventDate as date,e.varTitle as title,e.varURL as url,e.varStartTime as timeStart,e.varEndTime as timeEnd", false);
        $this->db->from('events as e', false);
        $this->db->where('e.intUser', ADMIN_ID);
        $this->db->order_by('e.dtEventDate', "asc");
        $rs = $this->db->get();
        $row = $rs->result_array();
        $data = json_encode($row);
//        echo $data;exit;
        return $data;
    }

    function time_ago($date) {
        if (empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();

        $unix_date = strtotime($date);

        // check validity of date

        if (empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date

        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

//    function pagesData() {
//        $wherecondtion = ('P.chrDelete="N" and P.chrPublish="Y"');
//        $this->db->select('P.*,A.intPageHits as PagesHits,A.intMobileHits as MobileHits', false);
//        $this->db->from('pages as P', false);
//        $this->db->join('alias as A', 'P.int_id = A.fk_Record', 'left');
//        $this->db->where("$wherecondtion", NULL, FALSE);
//        $this->db->limit(5, 0);
//        $this->db->group_by('P.int_id', false);
//        $this->db->order_by('A.intPageHits Desc');
//
//        $Query = $this->db->get();
//
//        return $Query;
//    }

    function pagesCount() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('pages');
        $this->db->where($wherecondtion);
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function getSellLead_Record() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('sellleads');
        $this->db->where($wherecondtion);
        $this->db->where("DATE(`dtCreateDate`) = CURDATE()");
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function getBuyLead_Record() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('buyleads');
        $this->db->where($wherecondtion);
        $this->db->where("DATE(`dtCreateDate`) = CURDATE()");
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function getUser_Record() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($wherecondtion);
        $this->db->where("DATE(`dtCreateDate`) = CURDATE()");
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function getContactUs_Record() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('contactusleads');
        $this->db->where($wherecondtion);
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function getTodaysContactUs_Record() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('contactusleads');
        $this->db->where($wherecondtion);
        $this->db->where("DATE(`dtCreateDate`) = CURDATE()");
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function count_contact() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('contactusleads');
        $this->db->where($wherecondtion);
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function count_newsletter() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('newsletterleads');
        $this->db->where($wherecondtion);
        $Query = $this->db->get();
//        echo $this->db->last_query();exit;
        $pagescount = $Query->num_rows();

        return $pagescount;
    }

    function count_hireusleads() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('hireusleads');
        $this->db->where($wherecondtion);
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function count_career() {
        $wherecondtion = array("chrDelete" => 'N');
        $this->db->select('*');
        $this->db->from('careerleads');
        $this->db->where($wherecondtion);
        $Query = $this->db->get();
        $pagescount = $Query->num_rows();
        return $pagescount;
    }

    function get_hits($id) {
        $this->db->select('*');
        $this->db->from('alias');
        $this->db->where(array("fk_Record" => $id, "fk_ModuleGlCode" => "2"));
        $SQL = $this->db->get();
        $RS = $SQL->Result();
        return $RS;
    }

}

?>