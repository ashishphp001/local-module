<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminpanel_user_management extends AdminPanel_Controller {
    
    function __construct() {
        
        parent::__construct();
    }
    
    public function index(){
        
        redirect(MODULE_URL.'accesscontrol');
    }

    public function accesscontrol($method='index'){
        
        echo Modules::run('user_management/accesscontrol/'.$method);
        
    }
    
    public function modcontrol($method='index'){
        echo Modules::run('user_management/modcontrol/'.$method);
    }
    
    public function groupaccess($method='index'){
        echo Modules::run('user_management/groupaccess/'.$method);
    }
    
    public function siteuser($method='index'){
        echo Modules::run('user_management/siteuser/'.$method);
    }
}

?>