<?php

class email_templates_model extends CI_Model {

    public function __construct() {
        $this->load->library('mylibrary');
        $mylibraryObj = new mylibrary;
    }

    function save_file() {
        if ($this->input->post('chrPublish') == 'Y') {
            $publish = 'Y';
        } else {
            $publish = 'N';
        }

        $data = array('chrPublish' => $publish, 'varSubject' => $this->input->post('varSubject'));
        $this->db->where('intGlcode', $this->input->post('eid'));
        $this->db->update(DB_PREFIX . 'mailtemplate', $data);

        if ($this->input->post('type') == "PP") {
            if (file_exists(ADMINPANEL_MAIL_TEMPLATES_PATH . $this->input->post('file_name'))) {
                $file_path = ADMINPANEL_MAIL_TEMPLATES_PATH . $this->input->post('file_name');
            }
        } else if ($this->input->get_post('type') == "FF") {
            if (file_exists(FRONT_GLOBAL_MAILTEMPLATES_PATH . $this->input->post('file_name'))) {
                $file_path = FRONT_GLOBAL_MAILTEMPLATES_PATH . $this->input->post('file_name');
            }
        }
        $file_content = $_REQUEST['var_description'];

        (string) $display_output = null;
        if (is_writable($file_path)) {
            $fp = fopen($file_path, 'w');
            if (!$fp) {
                $display_output = 'System is not able to open';
            } else if (!fwrite($fp, $file_content)) {
                $display_output = 'System is not able to edit file';
            } else {
                $display_output = 'Email Template has been Successfully Edited';
            }
            fclose($fp);
        } else {
            $display_output = 'File is not writable';
        }
        return $display_output;
    }

    function getAllTemplate($flag, $type) {

        $sql = "select * from " . DB_PREFIX . "mailtemplate where chrFlag='" . $flag . "'";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();

        foreach ($data as $file) {
            if ($type == 'PP') {
                $file_path = ADMINPANEL_MAIL_TEMPLATES_PATH . $file['varFileName'];
            } else if ($type == 'FF') {
                $file_path = FRONT_GLOBAL_MAILTEMPLATES_PATH . $file['varFileName'];
//                    echo $file_path;exit;
            }
//                echo $file_path;exit;
            if (file_exists($file_path)) {
                $background = ($counter++ % 2) ? 'grid-list-inner-table-text' : 'grid-bg';
                $file_title = substr($file['varFileName'], 0, -5);
                if ($file_title != '') {
                    $email_files_list .= '<tr class="' . $background . '"> ' .
                            '	<td height="20" style="padding-left:20px; padding-bottom:3px;"> <img style="padding-right:3px;" src="' . ADMIN_MEDIA_URL_DEFAULT . 'images/a.gif" align="absmiddle"> <a style="color:#000000; font-size:12px;" href="' . MODULE_URL . 'add?&type=' . $type . '&eid=' . $file['intGlcode'] . '">' . $file_title . '</a></td> ' .
                            '</tr>';
                }
            }
        }
        return $email_files_list;
    }

    function getTemplateName($id) {
        $sql = "select * from " . DB_PREFIX . "mailtemplate where intGlcode = " . $id . "";
        $query = $this->db->query($sql);
        $exec = $query->row_array();
        return $exec;
    }

}

?>
