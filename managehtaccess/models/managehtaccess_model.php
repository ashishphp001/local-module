<?php

class managehtaccess_model extends CI_Model {

    public function __construct() {
        $this->load->library('mylibrary');
        $mylibraryObj = new mylibrary;
    }

    function save_file() {
        
            $file_path = '.htaccess';
            $file_content = $_REQUEST['file_content'];
            (string) $display_output = null;
        if (is_writable($file_path)) {
            $fp = fopen($file_path, 'wb');
            if (!$fp) {
                $display_output = 'Robot file is not able to open ' . ' [ ' . $file_path . ' ]';
            } else if (!fwrite($fp, $file_content)) {
                $display_output = 'Robot file is not able to edit file' . ' [ ' . $file_path . ' ]';
            } else {
                $display_output = 'File has been Successfully Edited.' . ' [ ' . $file_path . ' ]';
            }
            fclose($fp);
        } else {
            $display_output = 'File is not writable [ ' . $file_path . ' ]';
        }
        return $display_output;
    }
}
?>