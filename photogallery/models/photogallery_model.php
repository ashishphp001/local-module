<?php

class photogallery_model extends CI_Model {

    var $int_id;
    var $Fk_Pages;
    var $Var_Pagename;
    var $Var_Alias;
    var $Text_FullText;
    var $Var_MetaTitle;
    var $Var_MetaKeyword;
    var $Var_MetaDescription;
    var $intDisplayOrder;
    var $Chr_Access = 'P';
    var $chrPublish = 'Y';   // (normal Attribute)
    var $chrDelete = 'N';   // (normal Attribute)
    var $dtCreateDate;   // (normal Attribute)
    var $dtModifyDate;   // (normal Attribute)
    var $Chr_Star;
    var $Chr_Read;   // (normal Attribute)
    var $Oldint_DisplayOrder; // Attribute of Old Displayorder
    var $PageName = ''; // Attribute of Page Name
    var $NumOfRows; // Attribute of Num Of Rows In Result
    var $NumOfPages; // Attribute of Num Of Pagues In Result
    var $OrderBy = 'intDisplayOrder'; // Attribute of Deafult Order By
    var $OrderType = 'asc'; // Attribute of Deafult Order By
    var $SearchBy = '0'; // Attribute of Search By
    var $SearchTxt; // Attribute of Search Text
    var $Start = 1; // Attribute of Start For Paging
    var $PageSize = DEFAULT_PAGESIZE; // Attribute of Pagesize For Paging
    var $PageNumber = '1'; // Attribute of Page Number For Paging(
    var $LastInsertint_id; // Attribute of Last Inserid
    var $UrlWithPara = ''; // Attribute of URL With parameters
    var $Vcard = ''; // Attribute of URL With parameters
    var $UrlWithPoutSearch = ''; // Attribute of URL With parameters without searh
    var $UrlWithoutSort = ''; // Attribute of URL With parameters without sort
    var $UrlWithoutpaging = ''; // Attribute of URL With parameters without paging
    var $FilterBy = '0';
    var $ImageName = '';
    var $UrlWithoutFilter = '';
    var $Display_Limit_Array = array('5', '10', '15', '30');
    var $DateField;
    var $NoOfPages;
    var $SearchByVal;
    var $AutoSearchUrl;
    var $SortVar = '';

    public function __construct() {
        $this->load->database();
        $this->load->helper(array('form', 'url'));
    }

    function insert_photo() {
//        echo "here";exit;
        $query = $this->db->query('SELECT count(1) as total FROM ' . DB_PREFIX . 'photogallery WHERE chrDelete = "N"');
        $rs = $query->row();
        $tot_recods = $rs->total;
        if ($tot_recods >= 1) {
            $this->mylibrary->updatedisplay_order('photogallery', '1');
            $int_displayorder = '1';
        } else {
            $int_displayorder = $tot_recods + 1;
        }
//        echo $int_displayorder;exit;
        $count = count($_FILES['varImage']['name']);
        for ($i = 0; $i < $count; $i++) {
            $sess = time();
            $pdf = basename($_FILES['varImage']['name'][$i]);
//            echo $pdf;exit;
            $photofile = preg_replace('/[^a-zA-Z0-9_ \[\]\.\(\)&-]/s', '', $pdf);
            $_FILES['varImage']['name'][$i] = $photofile;
            $image_title = basename($_FILES['varImage']['name'][$i]);
            $fileexntension = substr(strrchr($image_title, '.'), 1);
            $varName = str_replace('.' . $fileexntension, '', $image_title);
            $maindir = 'upimages/photogallery/images/';
            $var_main_file = $this->generate_image('varImage', $maindir, $i);
            $file_photo = basename($var_main_file);
            $uploadedfile = $maindir . $file_photo;
            $this->thumb_width = PRODUCTGALLERY_WIDTH;
            $this->thumb_height = PRODUCTGALLERY_HEIGHT;
            image_thumb($maindir . $var_main_file, $this->thumb_width, $this->thumb_height);
            image_thumb($maindir . $var_main_file, HOME_PRODUCTGALLERY_WIDTH, HOME_PRODUCTGALLERY_HEIGHT);
            image_thumb($maindir . $var_main_file, PRODUCTGALLERY_DETAIL_WIDTH, PRODUCTGALLERY_DETAIL_HEIGHT);
            $this->imagename = $var_main_file;
            $fk_aid = $this->input->get_post('intProject');
            $imgname = explode('.', $this->imagename);
            $image_name = $imgname['0'];
//            =======================================================
            $fk_aid = $this->input->get_post('intProject');
//            $imgname = explode('.', $this->imagename);
//            $image_name = $imgname['0'];
            $c_date = date('Y-m-d-h-i-s');
            $did = $this->input->get_post('intProject');
//            echo $did;exit;
            $check_album_cover = "select * from " . DB_PREFIX . "photogallery where fkProject  = '" . $did . "' and chrDelete = 'N' and chrDefaultimage='Y'";
            $res_album_cover = $this->db->query($check_album_cover);
            $rowcount = $res_album_cover->num_rows();
//echo $rowcount;
//            exit;
            if ($rowcount <= 0) {
                $chr_cover = 'Y';
            } else {
                $chr_cover = 'N';
            }
            $data = array(
                'varName' => $varName,
                'fkProject ' => $fk_aid,
                'varImage' => $this->imagename,
                'chrDefaultimage' => $chr_cover,
                'intDisplayOrder' => $int_displayorder,
                'dtCreateDate' => $c_date,
                'dtModifyDate' => $c_date,
            );
//            print_r($data);exit;
            $this->db->insert(DB_PREFIX . 'photogallery', $data);
//            $id = mysql_insert_id();
//            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'photogallery', 'Name' => 'varName', 'ModuleintGlcode' => $id, 'Flag' => 'I', 'Default' => 'int_id');
//            $this->mylibrary->insertinlogmanager($ParaArray);
        }
        return true;
    }

    function update_photo() {
        $count = count($_FILES['file']['name']);
        for ($i = 0; $i < $count; $i++) {
            $sess = time();
            $pdf = basename($_FILES['file']['name']);
//            echo $pdf;exit;
            $photofile = preg_replace('/[^a-zA-Z0-9_ \[\]\.\(\)&-]/s', '', $pdf);
            $_FILES['file']['name'] = $photofile;
            $image_title = basename($_FILES['file']['name']);
            $photofile = preg_replace('/[^a-zA-Z0-9_ \[\]\.\(\)&-]/s', '', $pdf);
//            $phototitle = explode('.', $photofile);
//            $varName = $phototitle[0];
            $_FILES['file']['name'][$i] = $photofile;
            $image_title = basename($_FILES['file']['name']);
            $fileexntension = substr(strrchr($image_title, '.'), 1);
            $varName = str_replace('.' . $fileexntension, '', $image_title);
//echo $varName;exit;
            $maindir = 'upimages/photogallery/images/';
            $var_main_file = $this->generate_image1('file', $maindir);
//            echo $var_main_file;exit;
            $file_photo = basename($var_main_file);
            $uploadedfile = $maindir . $file_photo;
            $this->thumb_width = PRODUCTGALLERY_WIDTH;
            $this->thumb_height = PRODUCTGALLERY_HEIGHT;
            image_thumb($maindir . $var_main_file, $this->thumb_width, $this->thumb_height);
            image_thumb($maindir . $var_main_file, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
//            image_thumb($maindir . $var_main_file, PRODUCTGALLERY_WIDTH, PRODUCTGALLERY_HEIGHT);
            $this->imagename = $var_main_file;
//            echo $uploadedfile;exit;
            $fk_aid = $this->input->get_post('fk_updatealbum');
            $imgname = explode('.', $this->imagename);
            $image_name = $imgname['0'];
            $c_date = date('Y-m-d-h-i-s');
            $did = $_REQUEST['fk_updatealbum'];
            $image_id = $_REQUEST['fk_updateid'];
            $check_album_cover = "select * from " . DB_PREFIX . "photogallery where fkProject  = '" . $did . "' and int_id = '" . $image_id . "' and  chrDelete = 'N' and chrDefaultimage = 'Y'";
            $res_album_cover = mysql_query($check_album_cover);
            if (mysql_num_rows($res_album_cover) == 1) {
                $chr_cover = 'Y';
            } else {
                $chr_cover = 'N';
            }
            $fk_updatealbum = $_REQUEST['fk_updatealbum'];
            $fk_updateid = $_REQUEST['fk_updateid'];
            $title = $_REQUEST['title'];
            $data = array(
                'varName' => $title,
                'fkProject ' => $fk_updatealbum,
                'varImage' => $this->imagename,
                'chrDefaultimage' => $chr_cover,
                'dtCreateDate' => $c_date,
                'dtModifyDate' => $c_date,
            );
            $this->db->where('int_id', $fk_updateid);
            $this->db->update('photogallery', $data);
            if ($this->imagename != '') {
                return 1;
            } else {
                return 0;
            }
        }
    }

    function generate_image1($filefield, $path = '') {
        $max_file_size = MAX_FILE_SIZE;
        $sess = time();
        $des_file_photo = basename($_FILES[$filefield]['name']);
        $des_file_photo = str_replace('&nbsp;', '-', $des_file_photo);
        $des_file_photo = str_replace(' ', '-', $des_file_photo);
        $des_file_photo = str_replace('#', '-', $des_file_photo);
        $des_file_photo = str_replace('%', '-', $des_file_photo);
        $pieces = explode(".", $des_file_photo);
        $lastitem = end($pieces);
        unset($pieces[count($pieces) - 1]);
        $pieces = implode(".", $pieces);
        $des_file_photo = $pieces . $sess . '.' . $lastitem;
        if ($path == '') {
            $uploaddir = $this->configObj->currentModulePath . 'html/uploads/images/';
        } else {
            $uploaddir = $path;
        }
        $source_file = basename($_FILES[$filefield]['name']);
        $file = $uploaddir . $des_file_photo;
        $uploadedfile = $_FILES[$filefield]['tmp_name'];
        $image_info = getimagesize($uploadedfile);
        $imageextension = $image_info['mime'];
        $file_size_MB = number_format($_FILES[$filefield]['size'] / pow(1024, 2)); // file size in MB
        if ($size < $file_size_MB) {
            if ($imageextension == "image/pjpeg" || $imageextension == "image/jpeg" || $imageextension == "image/jpeg" || $imageextension == "image/JPG" || $imageextension == "image/jpg") {
                $src = imagecreatefromjpeg($uploadedfile);
            } else if ($imageextension == "image/gif" || $imageextension == "image/GIF") {
                $src = imagecreatefromgif($uploadedfile);
            } else if ($imageextension == "image/bmp" || $imageextension == "image/BMP") {
                $src = imagecreatefromwbmp($uploadedfile);
            } else if ($imageextension == "image/x-ms-bmp") {
                $src = $this->imagecreatefrombmp($uploadedfile);
            } else if ($imageextension == "image/X-PNG" || $imageextension == "image/PNG" || $imageextension == "image/png" || $imageextension == "image/x-png") {
                $src = imagecreatefrompng($uploadedfile);
            }
            list($width, $height) = getimagesize($uploadedfile);
            if ($width >= height && $width >= 1000) {
                $newwidth = 950;
                $newheight = intval(($newwidth * $height) / $width);
            } else if ($height >= width && $height >= 750) {
                $newheight = 700;
                $newwidth = intval(($newheight * $width) / $height);
            } else {
                $newwidth = $width;
                $newheight = $height;
            }
            $tmp = imagecreatetruecolor($newwidth, $newheight);
            if ($image_info['mime'] == "image/gif" || $image_info['mime'] == "image/png") {
                imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 255, 0, 0, 127));
                imagealphablending($tmp, false);
                imagesavealpha($tmp, true);
            }
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            // preserve transparency
            if ($imageextension == "image/gif" || $imageextension == "image/GIF" || $imageextension == "image/png" || $imageextension == "image/X-PNG" || $imageextension == "image/PNG" || $imageextension == "image/x-png") {
                $background_color = imagecolorallocate($tmp, 255, 255, 255);
                imagefill($tmp, 0, 0, $background_color);
            }
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            if ($imageextension == "image/pjpeg" || $imageextension == "image/x-ms-bmp" || $imageextension == "image/jpeg" || $imageextension == "image/jpeg" || $imageextension == "image/JPG" || $imageextension == "image/jpg") {
                imagejpeg($tmp, $file, 80);
            } else if ($imageextension == "image/gif" || $imageextension == "image/GIF") {
                imagegif($tmp, $file);
            } else if ($imageextension == "image/bmp" || $imageextension == "image/BMP") {
                imagewbmp($tmp, $file);
            }
//            else if($imageextension == "image/x-ms-bmp")
//            {
//                imagewbmp($tmp,$file);
//            }
            else if ($imageextension == "image/bmp" || $imageextension == "image/BMP") {
                imagewbmp($tmp, $file);
            } else if ($imageextension == "image/X-PNG" || $imageextension == "image/PNG" || $imageextension == "image/png" || $imageextension == "image/x-png") {
                imagepng($tmp, $file);
            }
            imagedestroy($src);
            imagedestroy($tmp);
            // NOTE: PHP will clean up the temp file it created when the request  // has completed.
        } else {
            $img_upload = move_uploaded_file($_FILES[$filefield]['tmp_name'], $file);
        }
        return $des_file_photo;
    }

    function generate_image($filefield, $path = '', $i) {
//        echo "SAd";exit;
        $max_file_size = MAX_FILE_SIZE;
        $sess = time();
        $des_file_photo = basename($_FILES[$filefield]['name'][$i]);
        $des_file_photo = str_replace('&nbsp;', '-', $des_file_photo);
        $des_file_photo = str_replace(' ', '-', $des_file_photo);
        $des_file_photo = str_replace('#', '-', $des_file_photo);
        $des_file_photo = str_replace('%', '-', $des_file_photo);
        $pieces = explode(".", $des_file_photo);
        $lastitem = end($pieces);
        unset($pieces[count($pieces) - 1]);
        $pieces = implode(".", $pieces);
        $des_file_photo = $pieces . $sess . '.' . $lastitem;
        if ($path == '') {
            $uploaddir = $this->configObj->currentModulePath . 'html/uploads/images/';
        } else {
            $uploaddir = $path;
        }
        $source_file = basename($_FILES[$filefield]['name'][$i]);
        $file = $uploaddir . $des_file_photo;
        $uploadedfile = $_FILES[$filefield]['tmp_name'][$i];
        $image_info = getimagesize($uploadedfile);
        $imageextension = $image_info['mime'];
        $file_size_MB = number_format($_FILES[$filefield]['size'][$i] / pow(1024, 2)); // file size in MB
//        if ($size < $file_size_MB) {
//            
//            if ($imageextension == "image/pjpeg" || $imageextension == "image/jpeg" || $imageextension == "image/jpeg" || $imageextension == "image/JPG" || $imageextension == "image/jpg") {
//                
//                $src = imagecreatefromjpeg($uploadedfile);
//            } else if ($imageextension == "image/gif" || $imageextension == "image/GIF") {
//                $src = imagecreatefromgif($uploadedfile);
//            } else if ($imageextension == "image/bmp" || $imageextension == "image/BMP") {
//                $src = imagecreatefromwbmp($uploadedfile);
//            } else if ($imageextension == "image/x-ms-bmp") {
//                $src = $this->imagecreatefrombmp($uploadedfile);
//            } else if ($imageextension == "image/X-PNG" || $imageextension == "image/PNG" || $imageextension == "image/png" || $imageextension == "image/x-png") {
//                $src = imagecreatefrompng($uploadedfile);
//            }
//            
////            echo $src;exit;
//            
//            list($width, $height) = getimagesize($uploadedfile);
//            if ($width >= height && $width >= 1000) {
//                $newwidth = 950;
//                $newheight = intval(($newwidth * $height) / $width);
//            } else if ($height >= width && $height >= 750) {
//                $newheight = 700;
//                $newwidth = intval(($newheight * $width) / $height);
//            } else {
//                $newwidth = $width;
//                $newheight = $height;
//            }
//            $tmp = imagecreatetruecolor($newwidth, $newheight);
//            if ($image_info['mime'] == "image/gif" || $image_info['mime'] == "image/png") {
//                imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 255, 0, 0, 127));
//                imagealphablending($tmp, false);
//                imagesavealpha($tmp, true);
//            }
//            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//            // preserve transparency
//            if ($imageextension == "image/gif" || $imageextension == "image/GIF" || $imageextension == "image/png" || $imageextension == "image/X-PNG" || $imageextension == "image/PNG" || $imageextension == "image/x-png") {
//                $background_color = imagecolorallocate($tmp, 255, 255, 255);
//                imagefill($tmp, 0, 0, $background_color);
//            }
//            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//            if ($imageextension == "image/pjpeg" || $imageextension == "image/x-ms-bmp" || $imageextension == "image/jpeg" || $imageextension == "image/jpeg" || $imageextension == "image/JPG" || $imageextension == "image/jpg") {
//                imagejpeg($tmp, $file, 80);
//            } else if ($imageextension == "image/gif" || $imageextension == "image/GIF") {
//                imagegif($tmp, $file);
//            } else if ($imageextension == "image/bmp" || $imageextension == "image/BMP") {
//                imagewbmp($tmp, $file);
//            } else if ($imageextension == "image/bmp" || $imageextension == "image/BMP") {
//                imagewbmp($tmp, $file);
//            } else if ($imageextension == "image/X-PNG" || $imageextension == "image/PNG" || $imageextension == "image/png" || $imageextension == "image/x-png") {
//                imagepng($tmp, $file);
//            }
//            imagedestroy($src);
//            imagedestroy($tmp);
//            // NOTE: PHP will clean up the temp file it created when the request  // has completed.
//        } else {
        $img_upload = move_uploaded_file($_FILES[$filefield]['tmp_name'][$i], $file);
//        }
//        
//        echo $des_file_photo;exit;
        return $des_file_photo;
    }

    function upload_image($filefield, $thumb_width, $thumb_height, $prefix, $sess, $large_width, $large_height, $prefix2 = '', $i = '1') {
        $file_photo = basename($_FILES[$filefield]['name'][$i]);
        $imagename = $sess . $file_photo;
        $uploaddir = 'upimages/photogallery/images/';
        $file_photo = $sess . basename($_FILES[$filefield]['name'][$i]);
        $file = $uploaddir . $file_photo;
        $tmp = $_FILES[$filefield]['tmp_name'][$i];
        $uploadedfile = $_FILES[$filefield]['tmp_name'][$i];
        // Create an Image from it so we can do the resize
        $image_info = getimagesize($uploadedfile);
        switch ($image_info['mime']) {
            case 'image/gif':
                $img_create = 'ImageCreateFromGIF';
                break;
            case 'image/jpeg':
                $img_create = 'ImageCreateFromJPEG';
                break;
            case 'image/png':
                $img_create = 'ImageCreateFromPNG';
                break;
            case 'image/bmp':
                $img_create = 'ImageCreateFromBMP';
                break;
        }
        // $src = imagecreatefromjpeg($uploadedfile);
        $src = @$img_create($uploadedfile);
        // Capture the original size of the uploaded image
        list($width, $height) = getimagesize($uploadedfile);
        $newwidth = $width;
        $newheight = $height;
        $tmp = imagecreatetruecolor($newwidth, $newheight);
        $background_color = imagecolorallocate($tmp, 255, 255, 255);
        imagefill($tmp, 0, 0, $background_color);
        // this line actually does the image resizing, copying from the original // image into the $tmp image
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        // now write the resized image to disk.
        imagejpeg($tmp, $file, 90);
        imagedestroy($src);
        imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request  // has completed.
        $source1 = $uploaddir . $file_photo;
        $thumbfilename = $prefix . $sess . $file_photo;
        $target1 = $uploaddir . $prefix . $file_photo;
        $target2 = $uploaddir . $prefix2 . $file_photo;
        if ($large_width > 0) {
            $returnthumbmsg1 = $this->mylibrary->generate_thumb($source1, $thumb_width, false, false, $target1, false, null, $thumb_width, $thumb_height);
        }
        if ($returnthumbmsg1 == 'INVALID' || $returnthumbmsg2 == 'INVALID') {
            $this->chr_validthumb = 'N';
            $this->chr_validthumbdetail = 'N';
        } else {
            $this->chr_validthumb = 'Y';
            $this->chr_validthumbdetail = 'Y';
        }
        return $imagename;
    }

    function getPhotosByAlbum($id = '') {
        $pid = $this->input->get_post('intProject');
         echo $id;exit;
        $photoArry = array();
        $sql = "select *   FROM " . DB_PREFIX . "photogallery where chrDelete='N' AND fkProject  ='" . $id . "' order by intDisplayOrder";
        $rs = $this->db->query($sql);
        $row = $rs->result_array();
        return $row;
    }

    function set_photo_displayorder($albumID, $photoint_id) {
        if (!empty($photoint_id)) {
            $int_idArry = explode(",", $photoint_id);
            $i = 1;
            foreach ($int_idArry as $glcode) {
                $data = array(
                    'intDisplayOrder' => $i,
                    'dtModifyDate' => 'NOW()'
                );
                $intProject = $this->input->get_post('intProject');
                $this->db->where('int_id =' . $glcode . ' AND fkProject  =' . $albumID);
                $this->db->update(DB_PREFIX . 'photogallery', $data);
                $i++;
            }
            return true;
        }
    }

    function delete_photo($photoID) {
        $this->db->select('varImage');
        $query = $this->db->get_where(DB_PREFIX . 'photogallery', array('int_id' => $photoID));
        $row = $query->row_array();
        if (!empty($row)) {
            $data = array(
                'varIpAddress' => $_SERVER['REMOTE_ADDR'],
                'PUserGlCode' => ADMIN_NAME,
                'chrDelete' => 'Y',
            );
            $this->db->where('int_id =' . $photoID);
            $this->db->update(DB_PREFIX . 'photogallery', $data);
            $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'photogallery', 'Name' => 'varName', 'ModuleintGlcode' => $photoID, 'Flag' => 'D', 'Default' => 'int_id');
            $this->mylibrary->insertinlogmanager($ParaArray);
            return $photoID;
        }
        return $rs;
    }

    function change_photo_title($photoID, $photocaption) {
        $data = array(
            'varName' => $photocaption,
            'dtModifyDate' => 'NOW()'
        );
        $intProject = $this->input->get_post('intProject');
        $this->db->where('int_id =' . $photoID);
        $this->db->update(DB_PREFIX . 'photogallery', $data);
        $ParaArray = array('ModelId' => MODULE_ID, 'TableName' => DB_PREFIX . 'photogallery', 'Name' => 'varName', 'ModuleintGlcode' => $photoID, 'Flag' => 'U', 'Default' => 'int_id');
        $this->mylibrary->insertinlogmanager($ParaArray);
        return $photoID;
        return true;
    }

    function set_primary_photo($photoID, $albumID) {
        $data = array(
            'chrDefaultimage' => 'Y',
            'chrPublish' => 'Y',
            'dtModifyDate' => date('Y-m-d h-i-s'),
        );
        $where = "int_id = " . $photoID . " and fkProject  = " . $albumID;
        $this->db->where($where);
        if ($this->db->update(DB_PREFIX . 'photogallery', $data)) {
            $data2 = array(
                'chrDefaultimage' => 'N',
                'dtModifyDate' => date('Y-m-d h-i-s'),
            );
            $where = "int_id != " . $photoID . " and fkProject  = " . $albumID;
            $this->db->where($where);
            $this->db->update(DB_PREFIX . 'photogallery', $data2);
        } else {
            return false;
        }
        return true;
    }

    function set_publish($photoID, $albumID, $publish) {
        if ($publish == 'N') {
            $publish = 'Y';
        } else {
            $publish = 'N';
        }
        $data = array(
            'chrPublish' => $publish,
            'dtModifyDate' => 'NOW()'
        );
        $intProject = $this->input->get_post('intProject');
        $this->db->where('int_id =' . $photoID);
        $this->db->update(DB_PREFIX . 'photogallery', $data);
        return true;
    }

    function gallerycmbo($id = '') {
        $id1 = $this->input->get_post('intProject');
        $sql = "select * from " . DB_PREFIX . "projects where chrDelete='N' ORDER BY intDisplayOrder asc";
        $records = $this->db->query($sql);
        $selected_ids = Array();
        array_push($selected_ids, $id1);
//        $url="SendGridBindRequest('". $this->urlwithpara ."','gridbody','photo');";        
        $otherString = ' id="fk_photo" class="form-control" style="" get_width_height(this.value)"  onchange="window.location.href=\'photogallery?intProject=\'+this.value">';
        $options = Array();
//        $options[''] = 'Select Photo Album';
        foreach ($records->result() as $row) {
            $options[$row->int_id] = ucwords($row->varName);
        }
        $moduleSelectBox = array('name' => 'varName',
            'style' => 'width:350px;class:more-textarea;',
            'options' => $options,
            'otherString' => $otherString,
            'selected_ids' => $selected_ids,
//            'tdoption' => Array('TDDisplay' => 'Y'),
        );
        $display_output = form_input_ready($moduleSelectBox, 'select');
        return $display_output;
    }

    function name($id, $intProject) {
        $title = "select varName from  " . DB_PREFIX . "photogallery where int_id = '" . $id . "' and fkProject  = '" . $intProject . "'";
        $sql = $this->db->query($title);
        $rs = $sql->result_array();
        return $rs;
    }

    function edit_photo() {
//        echo $_REQUEST['fk_updateid'];
//       print_r($_FILES['file']['name']);
//        echo "name".$_REQUEST['fk_updateid'];
//        echo $_FILES['file'.$_REQUEST['fk_updateid']]["name"];exit;
//        $count = count($_FILES['file'.$_REQUEST['fk_updateid']]["name"]);
////        echo $count;
//        for ($i = 0; $i < $count; $i++) {
        $sess = time();
        $pdf = basename($_FILES['file' . $_REQUEST['fk_updateid']]['name']);
        $photofile = preg_replace('/[^a-zA-Z0-9_ \[\]\.\(\)&-]/s', '', $pdf);
        $_FILES['file']['name'] = $photofile;
        $image_title = basename($_FILES['file']['name']);
        $fileexntension = substr(strrchr($image_title, '.'), 1);
        $varName = str_replace('.' . $fileexntension, '', $image_title);
        $maindir = 'upimages/photogallery/images/';
        $var_main_file = $this->generate_image1('file' . $_REQUEST['fk_updateid'], $maindir);
        $file_photo = basename($var_main_file);
        $uploadedfile = $maindir . $file_photo;
        $this->thumb_width = PRODUCTGALLERY_DETAIL_WIDTH;
        $this->thumb_height = PRODUCTGALLERY_DETAIL_HEIGHT;
        image_thumb($maindir . $var_main_file, $this->thumb_width, $this->thumb_height);
        $this->imagename = $var_main_file;
        $fk_aid = $this->input->get_post('fk_updatealbum');
        $imgname = explode('.', $this->imagename);
        $image_name = $imgname['0'];
        $c_date = date('Y-m-d-h-i-s');
        $did = $_REQUEST['fk_updatealbum'];
        $image_id = $_REQUEST['fk_updateid'];
        $check_album_cover = "select * from " . DB_PREFIX . "photogallery where fkProject  = '" . $did . "' and int_id = '" . $image_id . "' and chrDelete = 'N' and chrDefaultimage = 'Y'";
        $res_album_cover = mysql_query($check_album_cover);
        if (mysql_num_rows($res_album_cover) == 1) {
            $chr_cover = 'Y';
        } else {
            $chr_cover = 'N';
        }
        $fk_updatealbum = $_REQUEST['fk_updatealbum'];
        $fk_updateid = $_REQUEST['fk_updateid'];
        $title = $_REQUEST['title' . $_REQUEST['fk_updateid']];
        $data = array(
            'varName' => $title,
            'fkProject ' => $fk_updatealbum,
            'varImage' => $this->imagename,
            'chrDefaultimage' => $chr_cover,
            'dtCreateDate' => $c_date,
            'dtModifyDate' => $c_date,
        );
        $this->db->where('int_id', $fk_updateid);
        $this->db->update('photogallery', $data);
        if ($this->imagename != '') {
            return 1;
        } else {
            return 0;
        }
    }

    function SelectAll_front() {
//        $flag = 'Y';
//       
//        $this->initialize($flag);
//        $this->Generateurl($flag);
//         $limitby = 'limit ' . $this->Start . ', ' . ABS($this->PageSize);
        $sql = "select N.*,A.varAlias,P.varImage from " . DB_PREFIX . "photogallery N left join " . DB_PREFIX . "our_work P on P.fkProject  = N.int_id LEFT JOIN " . DB_PREFIX . "alias A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='95' WHERE   P.chrDefaultimage = 'Y'  and N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.intDisplayOrder asc";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function CountRow_front() {
        $sql = "select N.*,A.varAlias,P.varImage from " . DB_PREFIX . "photogallery N left join " . DB_PREFIX . "our_work P on N.int_id = P.fkProject  LEFT JOIN " . DB_PREFIX . "alias A ON N.int_id=A.fk_Record AND A.fk_ModuleGlCode='95' WHERE N.chrPublish='Y' and N.chrDelete='N' group by N.int_id";
        $query = $this->db->query($sql);
//        echo $this->db->last_query();exit();
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    function SelectAll_Detail($id) {
        $sql = "select * from " . DB_PREFIX . "our_work  WHERE chrPublish='Y' and 	chrDelete='N' and fkProject  = '" . $id . "'  order by intDisplayOrder asc";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function CheckDescription($id) {
        $sql = "SELECT chrDiscriptionDisplay FROM " . DB_PREFIX . "pages where int_id=" . $id;
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

}
