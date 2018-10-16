<?php

class contact_info_model extends CI_Model {

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
        $this->db->from('contactinfo', false);
        $this->db->order_by('int_id');
        $row = $this->db->get();
        $returnArry = $row->row();

        return $returnArry;
    }

    function select($id) {

        $this->db->select("*");
        $this->db->from('contactinfo', false);
        $this->db->where('int_id', $id);
        $row = $this->db->get();
        $Row = $row->row();
//        echo $this->db->last_query();exit;
        return $Row;
    }

    function update() {

        $varMessenger = $this->input->post('varMessenger', true);
        $varPhone = $this->input->post('varPhone', true);
        $varAddress = $this->input->post('varAddress');
        $Data1 = array(
            'varEmail' => $this->input->post('varEmail', true),
            'varMessenger' => $varMessenger,
            'varPhone' => $varPhone,
            'varAddress' => $varAddress
        );

        $eid = $this->input->get_post('eid', true);

        $this->db->where('int_id', $eid);
        $this->db->update('contactinfo', $Data1);
    }

}

?>