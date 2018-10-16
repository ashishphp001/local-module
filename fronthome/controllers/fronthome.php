<?php

class fronthome extends Front_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('fronthome_model', 'module_model');
        $this->module_url = FRONT_MODULE_URL;                   // MODULE URL          
    }

    function do_logout() {
        $this->logout_log();
        $this->session->sess_destroy();
        redirect(SITE_PATH . 'adminpanel');
    }

    public function getallproduct() {
        $user = $this->module_model->getallproduct();
        header("Content-type:application/json");
        echo json_encode($user);
    }

   

    public function getuserproduct() {
        $user = $this->module_model->getuserproduct();
        header("Content-type:application/json");
        echo json_encode($user);
    }

    function logout_log() {
        $userid = $this->session->userdata('UserId');
        $usertype = $this->session->userdata('UserType');
        $login_log_id = $this->session->userdata('Login_Log_Id');
        $data = array(
            'dtLogOutDate' => date('Y-m-d H:i:s'),
        );
        $this->db->where('int_id', $login_log_id);
        $this->db->update('loginhistory', $data);
    }

    public function index() {
//        echo "hi";exit;
        $CurrentPageData = $this->common_model->getPageData_Seo(RECORD_ID, "pages");
        $Seo_array['title'] = $CurrentPageData['varMetaTitle'];
        $Seo_array['keywords'] = $CurrentPageData['varMetaKeyword'];
        $Seo_array['description'] = $CurrentPageData['varMetaDescription'];
        $this->common_model->get_metadata($Seo_array);

//        $subdomain = array_shift((explode('.', $_SERVER['HTTP_HOST'])));
        if (SUBDOMAIN == 'blog') {
            $Pages_Records = $this->module_model->get_blog_data();
            $this->viewData['ShowAllPagesRecords'] = $Pages_Records;

            $this->viewData['ContentPanel'] = 'front/blog_tpl';
        } else {
            $this->viewData['ContentPanel'] = 'front/home_tpl';
        }
        $this->load_view();
    }

    public function load_data() {

//         $this->viewData['Resultservice'] = $this->module_model->SelectAll_front();
//        $this->viewData['Count'] = $this->module_model->CountRows_front();
    }

    public function setMOQRfq() {
        $id = $this->input->get_post('intUnit1', true);
        $setMOQRfqdata = $this->module_model->getRfqMOQData($id);
        echo $setMOQRfqdata;
    }

    public function getStatelists() {
        $getStatedata = $this->module_model->getStateData();
        echo $getStatedata;
    }

    public function getCitieslists() {
        $getCitydata = $this->module_model->getCitieslists();
        echo $getCitydata;
    }

    public function addtofavourite() {
        $data = $this->module_model->UpdateFav();
        echo $data;
    }

    public function addtofavouritebuylead() {
        $data = $this->module_model->UpdateFavBuyLead();
        echo $data;
    }

    public function insertContactUsData() {
//        print_R($_POST);exit;
        if (!$this->input->post()) {
            redirect($this->redirect_url);
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('varName', 'Name', 'trim|required');
        $this->form_validation->set_rules('varPhone', 'varPhone', 'trim|required');
        $this->form_validation->set_rules('varEmailId', 'Email ID', 'trim|required|valid_varEmailId');
        $this->form_validation->set_rules('txtMessage', 'Message', 'trim|required');
        if ($this->form_validation->run($this) == FALSE) {
            $this->index();
        } else {
            $contact = $this->module_model->process();
            $this->session->set_userdata('Contact_Thankyou', 'success');
            redirect(SITE_PATH . "contact-us/success");
        }
    }

    function sendMailtoNewsletterEmail() {
//        echo 
        $ajax = $_POST['varNewsEmail'];
//        echo $ajax;exit;
        if (!empty($ajax)) {
            echo $this->module_model->sendMailtoNewsletter();
            exit;
        } else {
            show_404('page');
        }
    }

    function Set_Session() {

        $_SESSION["Accept"] = $this->input->get_post('acceptsession', true);
        return true;
    }

    public function get_all_products() {
        $product = $this->module_model->get_all_products();
        echo $product;
    }

     public function getallcategory() {
        $category = $this->module_model->getallcategory();
        echo $category;
    }
    
    public function get_all_suppliers() {
        $supplier = $this->module_model->get_all_suppliers();
        echo $supplier;
    }

    function downloadfiles() {
        $id = $this->input->get_post('id', true);
//          echo $id;exit;
        $getfiles = $this->module_model->downloadfiles($id);

//        if (count($getfiles) == 1) {
            foreach ($getfiles as $files) {
                $file = $files['varFile'];
                $this->load->helper('download');
                $data = file_get_contents(base_url() . 'upimages/buyleads/file/' . $file);
                force_download($file, $data);
                exit;
            }
//        } else {
//            foreach ($getfiles as $files) {
//                $data_files[] = "upimages/buyleads/file/" . $files['varFile'];
//            }
//            if ($files['varFile'] != '') {
//
//                $files = $data_files;
//                $zipname = time() . '.zip';
//                $zip = new ZipArchive;
//                $zip->open($zipname, ZipArchive::CREATE);
//                foreach ($files as $file) {
//                    $new_filename = substr($file, strrpos($file, '/') + 1);
//                    $zip->addFile($file, $new_filename);
//                }
//                $zip->close();
//
//                header('Content-Type: application/zip');
//                header('Content-disposition: attachment; filename=' . $zipname);
//                header('Content-Length: ' . filesize($zipname));
//                readfile($zipname);
//                unlink($zipname);
//            }
//        }
        exit;
    }

    function download($file) {
        
    }

    function check_email_address() {
        $emailid = $this->input->get_post('varEmail', true);
        echo $this->module_model->check_email_exit($emailid);
        exit;
    }

}

?>