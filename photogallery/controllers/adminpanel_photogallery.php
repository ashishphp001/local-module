<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminpanel_photogallery extends AdminPanel_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('photogallery_model', 'module_model');
        $this->main_tpl = 'adminpanel/photogallery_tpl';
        $this->main_photos_tpl = 'adminpanel/photos_listing_tpl';
        $this->form_tpl = 'adminpanel/windowform_tpl';
        $this->viewData['adminContentPanel'] = $this->main_tpl;

        $this->viewData['module_path'] = SITE_PATH . 'adminpanel/photogallery/';
        $this->viewData['thumb_url'] = SITE_PATH . 'upimages/photogallery/thumbnails/';
        $this->viewData['image_url'] = SITE_PATH . 'upimages/photogallery/';
        $this->viewData['image_relative_path'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/upimages/photogallery/';
        $this->load->library('parser');
        $this->load->helper(array('form', 'url'));
        $this->permission = $this->session->userdata('permissionArry');
        $this->viewData['permissionArry'] = $this->permission[MODULE_PATH];
        $this->Module_Model->permissionArry = $this->permission[MODULE_PATH];
    }

// public function updatephoto() {
//
//        echo $this->parser->parse($this->form_tpl, $this->viewData);
//        exit;
//    }
    public function edit_photo() {
        echo $this->parser->parse($this->form_tpl, $this->viewData);
        exit;
    }

    public function index() {
//echo "12";exit;
        $this->load_view();
    }

    public function select_all_photos($intProject) {
        if ($intProject != '') {
            $intProject = "0";
        }
        $photos = $this->module_model->getPhotosByAlbum($intProject);
        $this->viewData['photosArr'] = $photos;
        $this->viewData['intProject'] = $intProject;
        echo $this->parser->parse($this->main_photos_tpl, $this->viewData);
        exit;
    }

    function set_photo_displayorder($albumID, $photoint_id) {
        if ($this->module_model->set_photo_displayorder($albumID, $photoint_id)) {
            echo "1";
        } else {
            echo "0";
        }
        exit;
    }

    function delete_photo($photoID, $albumID) {
        $this->module_model->delete_photo($photoID);
        echo "1";
        exit;
    }

    function change_photo_title($photoID, $albumID) {
        $photocaption = $this->input->get_post('photocaption');
//echo $photocaption;exit;
        if ($this->module_model->change_photo_title($photoID, $photocaption)) {
            echo "1";
        } else {
            echo "0";
        }
        exit;
    }

    function set_publish($albumID, $photoID, $publish) {
        if ($this->module_model->set_publish($photoID, $albumID, $publish)) {
            echo "1";
        } else {
            echo "0";
        }
        exit;
    }

    public function set_primary() {
        $photoID = $this->input->get_post('photoID');
        $albumID = $this->input->get_post('albumID');
        if ($this->module_model->set_primary_photo($photoID, $albumID)) {
            echo "1";
        } else {
            echo "0";
        }
        exit;
    }

//     function update_data() {
//
//        $this->module_model->update();
//    }

    function upload() {
//       print_R($_FILES['varImage']);exit;
        if ($_FILES['varImage'] != '') {
            if ($this->module_model->insert_photo()) {
                $fk_aid = $this->input->get_post('intProject');
                redirect('adminpanel/photogallery?intProject=' . $fk_aid);
            }
        }
    }

    function update() {
//       print_r($_REQUEST);exit;
        $Data = $this->module_model->edit_photo();
        if ($Data == 1) {
            redirect('adminpanel/photogallery?intProject=' . $_REQUEST['fk_updatealbum']);
        }
    }

}

?>