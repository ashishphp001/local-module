<?php

class sticky_notes_model extends CI_Model {

    public function __construct() {

        $this->module_url = MODULE_URL;
    }

    function general() {
        $data['base'] = $this->config->item('base_url');
        $data['css'] = $this->config->item('css');
        $data['img'] = $this->config->item('images');
        return $data;
    }

    function Generateurl() {
        $this->PageName = MODULE_PAGE_NAME;
        $this->UrlWithPara = $this->PageName . '?' . 'PageSize=' . $this->PageSize . '&NumOfRows=' . $this->NumOfRows . '&OrderBy=' . $this->OrderBy . '&OrderType=' . $this->OrderType . '&SearchBy=' . $this->SearchBy . '&SearchTxt=' . htmlspecialchars($this->SearchTxt) . '&PageNumber=' . $this->PageNumber . '&FilterBy=' . $this->FilterBy;
    }

    function GetContactInfoData() {

        $this->db->select("*");
        $this->db->from('sticky_notes', false);
        $this->db->order_by('int_id');
        $row = $this->db->get();
        $returnArry = $row->row();

        return $returnArry;
    }

    function select() {

        $this->db->select("*");
        $this->db->from('sticky_notes', false);
        $this->db->where('intUser', ADMIN_ID);
        $this->db->where('chrDelete', 'N');
        $this->db->order_by('int_id', 'desc');
        $row = $this->db->get();
        $Row = $row->result_array();
        return $Row;
    }

    function remove_sticky() {
        $id = $this->input->post('id', true);

        $Data1 = array(
            'chrDelete' => 'Y',
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'PUserGlCode' => ADMIN_ID,
        );
        $this->db->where('int_id', $id);
        $this->db->update('sticky_notes', $Data1);

        return true;
    }

    function update() {

        $varCity = $this->input->post('varCity', true);
        $varPhone = $this->input->post('varPhone', true);
        $varAddress = $this->input->post('varAddress');
        $Data1 = array(
            'varEmail' => $this->input->post('varEmail', true),
            'varCity' => $this->input->post('varCity', true),
            'varPhone' => $varPhone,
            'varAddress' => $varAddress,
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'PUserGlCode' => ADMIN_ID,
        );

        $eid = $this->input->get_post('eid', true);

        $this->db->where('int_id', $eid);
        $this->db->update('sticky_notes', $Data1);
    }

    function add() {

        $time = $this->input->get_post('time', true);
        $color = $this->input->get_post('color', true);
        $title = $this->input->get_post('title', true);
        $content = $this->input->get_post('content', true);
        $labels = $this->input->get_post('labels', true);
        $checklists = $this->input->get_post('checklists', true);
        $Data1 = array(
            'time' => $time,
            'color' => $color,
            'title' => $title,
            'content' => $content,
            'labels' => $labels,
            'checklists' => $checklists,
            'chrDelete' => 'N',
            'chrPublish' => 'Y',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'varIpAddress' => $_SERVER['REMOTE_ADDR'],
            'dtModifyDate' => date('Y-m-d H-i-s'),
            'PUserGlCode' => ADMIN_ID,
        );
        $this->db->insert(DB_PREFIX . 'sticky_notes', $Data1);
        return true;
    }

}

?>