<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Thumb()
 * A TimThumb-style function to generate image thumbnails on the fly.
 * 
 * @author Darren Craig
 * @param string $image_path
 * @param int $width
 * @param int $height
 * @return String
 * 
 */
function image_thumb($image_path, $width, $height, $mobile = "no") {

    // Get the CodeIgniter super object
    $CI = &get_instance();

    // get file extension
    $file = explode(".", $image_path);
    $ext = array_pop($file);
    $file_name = array_shift($file);
    $file_name = str_replace(dirname($image_path) . "/", "", $file_name);

    $directory_path = str_replace("upimages", "cache", dirname($image_path));
    if ($mobile == 'yes') {
        $directory_path = $directory_path . "/mobile";
        $quality = "50%";
        $directory_path = $directory_path . "/mobile/" . $width . '_' . $height;
    } else {
        $quality = "90%";
        $directory_path = $directory_path . "/" . $width . '_' . $height;
    }

    // Path to image thumbnail
    $image_thumb = $directory_path . '/' . $file_name . "." . $ext;


    if (!file_exists($image_thumb)) {

        $check_directory = explode("/", $directory_path);
        foreach ($check_directory as $value) {
            $dir .= $value . "/";
            if (!@is_dir($dir)) {
                if (!@mkdir($dir, DIR_WRITE_MODE)) {
                    return FALSE;
                }

                @chmod($dir, DIR_WRITE_MODE);
            }
        }
        // LOAD LIBRARY

        $vals = @getimagesize($image_path);

        if ($vals[0] < $width) {
            $width = $vals[0];
        }
        if ($vals[1] < $height) {
            $height = $vals[1];
        }

        $CI->load->library('image_lib');

        // CONFIGURE IMAGE LIBRARY
        $config['image_library'] = 'gd2';
        $config['source_image'] = $image_path;
        $config['new_image'] = $image_thumb;
        $config['maintain_ratio'] = false;
        $config['master_dim'] = "width";

        $config['quality'] = $quality;

        if ($height > $width) {
            $config['master_dim'] = "height";
        }

        $config['width'] = $width;
        $config['height'] = $height;


//        $config['wm_text'] = 'Copyright 2006 - John Doe';
//        $config['wm_type'] = 'text';
//        $config['wm_font_path'] = './Linearicons.ttf';
//        $config['wm_padding'] = '20';
        $config['rotation_angle'] = '90';


        $CI->image_lib->initialize($config);
//        $CI->image_lib->watermark();

//        if (!$CI->image_lib->watermark()) {
//            echo $CI->image_lib->display_errors();
//        } else {
//            echo base_url() . $image_thumb;
//        }


        $CI->image_lib->resize();
      
//        $CI->image_lib->clear();
    }

    return base_url() . $image_thumb;
}

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */
?>