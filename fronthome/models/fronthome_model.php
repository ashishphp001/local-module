<?php

class fronthome_model extends CI_Model {

    public function __construct() {
        $this->load->database();
        $this->load->helper(array('form', 'url'));
    }

    function getallproduct() {
        $sql = "select varName from " . DB_PREFIX . "product where chrPublish='Y' and chrDelete='N' ORDER BY varName ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datas = array();
//        print_r($data);exit;
        foreach ($data as $key => $row) {
            $datas[$row['varName']] = null;
        }
        return $datas;
    }


    function getuserproduct() {
        $user = $this->input->get_post('intUser');
        $sql = "select varName from " . DB_PREFIX . "product where chrPublish='Y' and intSupplier='" . $user . "' and chrDelete='N' ORDER BY varName ASC";
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datas = array();
        foreach ($data as $key => $row) {
            $datas[$row['varName']] = null;
        }
        return $datas;
    }

    function get_all_products() {
        $query = $this->input->get_post('query');
        $type = $this->input->get_post('type');
        if ($type == '2') {
            $sql = "select p.varName,p.int_id,a.varAlias from " . DB_PREFIX . "buyleads as p left join " . DB_PREFIX . "alias as a on a.fk_Record=p.int_id where a.fk_ModuleGlCode='147' and p.varName like '%" . $query . "%' and p.chrPublish='Y' and p.chrDelete='N' group by p.varName ORDER BY p.varName ASC limit 10";
        } else {
//            $sql = "select p.varName from " . DB_PREFIX . "product as p where p.varName like '%" . $query . "%' and p.chrPublish='Y' and p.chrDelete='N' group by p.varName ORDER BY p.varName ASC limit 10";
            $sql = "select p.varName,p.int_id,a.varAlias from " . DB_PREFIX . "product as p left join " . DB_PREFIX . "alias as a on a.fk_Record=p.int_id where a.fk_ModuleGlCode='140' and p.varName like '%" . $query . "%' and p.chrPublish='Y' and p.chrDelete='N' group by p.varName ORDER BY p.varName ASC limit 10";
        }
//       echo $sql;
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datass = array();
        $html = "";
        $html .= "<ul>";
        foreach ($data as $row) {
            if ($type == '2') {
                $url = $this->common_model->getUrl("pages", "2", "28", '') . "?keyword=" . $row['varName'] . "&type=2";
            } else {
                $url = $this->common_model->getUrl("pages", "2", "51", '') . "?keyword=" . $row['varName'] . "&type=1";
            }
            $html .= '<li><a href="' . $url . '">' . stripslashes(quotes_to_entities($row['varName'])) . '</a></li>';
        }
        $html .= "</ul>";
        return $html;
    }

    function get_all_user_products() {
        $query = $this->input->get_post('query');
        $user_id = $this->input->get_post('user_id');
        $sql = "select p.varName,p.int_id,a.varAlias from " . DB_PREFIX . "product as p left join " . DB_PREFIX . "alias as a on a.fk_Record=p.int_id where a.fk_ModuleGlCode='140' and p.varName like '%" . $query . "%' amd p.intSupplier='" . $user_id . "' and p.chrPublish='Y' and p.chrDelete='N' group by p.int_id ORDER BY p.varName ASC limit 10";
//       echo $sql;
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datass = array();
        $html = "";
        $html .= "<ul>";
        foreach ($data as $row) {
            $url = $this->common_model->getUrl("pages", "2", "28", '') . "?keyword=" . $row['varName'] . "&type=2";

            $html .= '<li><a href="' . $url . '">' . stripslashes(quotes_to_entities($row['varName'])) . '</a></li>';
        }
        $html .= "</ul>";
        return $html;
    }

    function get_all_suppliers() {
        $query = $this->input->get_post('query');
        $type = $this->input->get_post('type');
        $sql = "select u.varCompany as varName,u.int_id,a.varAlias from " . DB_PREFIX . "users as u left join " . DB_PREFIX . "alias as a on a.fk_Record=u.int_id where u.varCompany like '%" . $query . "%' and a.fk_ModuleGlCode='136' and u.chrPublish='Y' and u.chrDelete='N' group by u.int_id ORDER BY u.chrPayment desc,u.intPayment desc,u.varName asc limit 10";
//       echo $sql;
        $data1 = $this->db->query($sql);
        $data = $data1->result_array();
        $datass = array();
        $html = "";
        $html .= "<ul>";
        foreach ($data as $row) {
            $url = SITE_PATH . $row['varAlias'];
            $html .= '<li><a href="' . $url . '">' . stripslashes(quotes_to_entities($row['varName'])) . '</a></li>';
        }
        $html .= "</ul>";
        return $html;
    }

    public function getServiceRecords() {
        $sql = "SELECT * FROM " . DB_PREFIX . "service where chrDelete='N' and chrPublish='Y' order by intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function getStateData() {
        $id = $this->input->get_post('intCountry', true);
        $query = $this->db->query("select * from " . DB_PREFIX . "states where intCountry='" . $id . "' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select onchange='return getcities(this.value)' id=\"intState\" name=\"intState\" >";
        $returnHtml .= '<option value="" disabled selected>Select State<sup>*</sup></option>';
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    function getCitieslists() {
        $id = $this->input->get_post('intState', true);
        $query = $this->db->query("select * from " . DB_PREFIX . "cities where intState='" . $id . "' order by varName asc");
        $Result = $query->result_array();
        $returnHtml = '';
        $returnHtml .= "<select id=\"intCity\" name=\"intCity\" >";
        $returnHtml .= '<option value="" disabled selected>Select City<sup>*</sup></option>';
        foreach ($Result as $row) {
            if ($id == $row['int_id']) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $returnHtml .= '<option value="' . $row['int_id'] . '" ' . $selected . '>' . $row['varName'] . '</option>';
        }
        $returnHtml .= "</select>";
        return $returnHtml;
    }

    public function getTestimonialRecords() {
        $sql = "SELECT * FROM " . DB_PREFIX . "testimonial where chrDelete='N' and chrPublish='Y' order by intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getFeatureData() {
        $sql = "SELECT * FROM " . DB_PREFIX . "features where chrDelete='N' and chrPublish='Y' order by intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getPageData($id = '1') {
        $sql = " select txtDescription from " . DB_PREFIX . "pages where chrDelete='N' and intGlcode='1'";
        $query = $this->db->query($sql);
        $data = $query->row_array();
        return $data["txtDescription"];
    }

    public function getShowAllTechnologyRecords() {
        $sql = "select E.*,A.varAlias from " . DB_PREFIX . "technology E LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record WHERE E.chrPublish='Y' and A.fk_ModuleGlCode='110' and E.intProject!='0' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getWorksData() {
        $sql = "select E.*,A.varAlias from " . DB_PREFIX . "projects E LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record WHERE E.chrPublish='Y' and A.fk_ModuleGlCode='96' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc";
//      echo $sql;
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getShowAllARServiceRecords() {
        $sql = "select E.*,A.varAlias from " . DB_PREFIX . "services E LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record WHERE E.chrPublish='Y' and E.varCategory='AR' and A.fk_ModuleGlCode='105' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getShowAllBlogRecords() {
        $sql = "select E.*,A.varAlias from " . DB_PREFIX . "blogs E LEFT JOIN " . DB_PREFIX . "alias A ON E.int_id=A.fk_Record WHERE E.chrPublish='Y' and A.fk_ModuleGlCode='124' and E.chrDelete='N' group by E.int_id order by E.intDisplayOrder asc limit 0,4";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    function UpdateFav() {
        $product_id = $this->input->get_post('product_id', true);
        $user_id = $this->input->get_post('user_id', true);
        $check_favorite = $this->checkFavorite($product_id, $user_id);
        if ($check_favorite == 0) {
            $data = array(
                'intUser' => $user_id,
                'intProduct' => $product_id,
                'chrDelete' => 'N',
                'chrPublish' => 'Y',
                'dtCreateDate' => date('Y-m-d H:i:s'),
                'dtModifyDate' => date('Y-m-d H:i:s'),
                'varIpAddress' => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('favourite', $data);
            return 1;
        } else {
            $this->db->delete('favourite', array('intUser' => $user_id, 'intProduct' => $product_id));
            return 2;
        }
        return 0;
    }

    function UpdateFavBuyLead() {
        $buylead_id = $this->input->get_post('intBuylead', true);
        $user_id = $this->input->get_post('user_id', true);
        $check_favorite = $this->checkFavoriteBuylead($buylead_id, $user_id);
        if ($check_favorite == 0) {
            $data = array(
                'intUser' => $user_id,
                'intBuylead' => $buylead_id,
                'chrDelete' => 'N',
                'chrPublish' => 'Y',
                'dtCreateDate' => date('Y-m-d H:i:s'),
                'dtModifyDate' => date('Y-m-d H:i:s'),
                'varIpAddress' => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('favourite_buylead', $data);
            return 1;
        } else {
            $this->db->delete('favourite_buylead', array('intUser' => $user_id, 'intProduct' => $product_id));
            return 2;
        }
        return 0;
    }

    function checkFavoriteBuylead($buylead_id, $user_id) {
        $sql = "select * from " . DB_PREFIX . "favourite_buylead WHERE intBuylead='" . $buylead_id . "' and intUser='" . $user_id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->num_rows();
        return $result_query;
    }

    function checkFavorite($product_id, $user_id) {
        $sql = "select * from " . DB_PREFIX . "favourite WHERE intProduct='" . $product_id . "' and intUser='" . $user_id . "'";
//        echo $sql;exit;
        $data = $this->db->query($sql);
        $result_query = $data->num_rows();
        return $result_query;
    }

    function sendMailtoNewsletter() {
        $email = $this->input->get_post('varNewsEmail', true);
        $count_news_email = $this->getShowAllNewsletterleadsRecords($email);
        if ($count_news_email == 0) {
            $data = array(
                'varEmail' => $email,
                'chrDelete' => 'N',
                'chrPublish' => 'Y',
                'dtCreateDate' => date('Y-m-d H:i:s'),
                'dtModifyDate' => date('Y-m-d H:i:s'),
                'PUserGlCode' => "2",
                'varIpAddress' => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('newsletterleads', $data);
            $id = $this->db->insert_id();

            if (!empty($email)) {

                $logo = ADMIN_MEDIA_URL;
                $subject = 'Thankyou for being part of us and stay tuned with ' . SITE_NAME;
                $content = '';
                $content .= "Action Needed!<br><br>";
                $content .= "Thanks for subscribing our newsletters. We will send you trips and tricks to grow your business in newsletters and we promise you will not get unlimited promotional mails. At " . SITE_NAME . ", We are provide content which will help to grow your business.  So get ready for a success ride. Congratulations in advance!";

//                $body .= ' <tr>
//                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
//                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Link : </strong><a href=' . $fp_link . ' target="_blank" style="color:#337ab7; text-decoration:none;">' . $fp_link . '</a></td>
//                                                                            </tr>';
                if (FACEBOOK_LINK != '') {
                    $fbFollous .= '<td style="padding: 0 5px;"><a href="' . FACEBOOK_LINK . '" target="_blank" class="circle fab fa-facebook-f"></a></td>';
                }
                if (TWITTER_LINK != '') {
                    $twFollous .= '<td style="padding: 0 5px;"><a href="' . TWITTER_LINK . '" target="_blank" class="circle fab fa-twitter"></a></td>';
                }
                if (GOOGLE_PLUS_LINK != '') {
                    $gpFollous .= '<td style="padding: 0 5px;"><a href="' . GOOGLE_PLUS_LINK . '" target="_blank" class="circle fab fa-google-plus-g"></a></td>';
                }
                if (LINKEDIN_LINK != '') {
                    $liFollous .= '<td style="padding: 0 5px;"><a href="' . LINKEDIN_LINK . '" target="_blank" class="circle fab fa-linkedin-in"></a></td>';
                }
                if (INSTAGRAM_LINK != '') {
                    $igFollous .= '<td style="padding: 0 5px;"><a href="' . INSTAGRAM_LINK . '" target="_blank" class="circle fab fa-instagram"></a></td>';
                }
                if (GITHUB_LINK != '') {
                    $ghFollous .= '<td style="padding: 0 5px;"><a href="' . GITHUB_LINK . '" target="_blank" class="circle fab fa-github"></a></td>';
                }
                $email_link = $logout_url = $this->common_model->getUrl("pages", "2", "98", '') . "?email=" . $this->mylibrary->cryptPass($email);
                $html_message = file_get_contents(FRONT_GLOBAL_MAILTEMPLATES_PATH . "newsletter.html");
                $html_message = str_replace("@VERIFY_EMAIL", $email_link, $html_message);
                $html_message = str_replace("@CONTENT", $content, $html_message);
                $html_message = str_replace("@MAIL_HEADER", $email_header, $html_message);
                $html_message = str_replace("@MAIL_FOOTER", $email_footer, $html_message);
                $html_message = str_replace("@FLOLLOW", $Follous, $html_message);
                $html_message = str_replace("@MAIL_LEFT", '', $html_message);
                $html_message = str_replace("@DETAILS", $body, $html_message);
                $html_message = str_replace("@YEAR", date('Y'), $html_message);
                $html_message = str_replace("@FACEBOOK", $fbFollous, $html_message);
                $html_message = str_replace("@TWITTER", $twFollous, $html_message);
                $html_message = str_replace("@YOUTUBE", $ytFollous, $html_message);
                $html_message = str_replace("@GOOGLE+", $gpFollous, $html_message);
                $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
                $html_message = str_replace("@INSTAGRAM", $igFollous, $html_message);
                $html_message = str_replace("@GITHUB", $ghFollous, $html_message);
                $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
                $html_message = str_replace("@NAME", "Dear User", $html_message);
                $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
                $html_message = str_replace("@MEDIA_URL", FRONT_GLOBAL_MAILTEMPLATES_PATH, $html_message);
                $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);

                $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
                $headers .= "Reply-To: " . $email . "\r\n";
                $headers .= "Content-type: text/html\r\n";

                mail($email, $subject, $html_message, $headers);
            }


            return true;
        } else {
            return false;
        }
    }

    function getShowAllNewsletterleadsRecords($email) {
        $sql = "select * from " . DB_PREFIX . "newsletterleads WHERE varEmail='" . $email . "' and chrPublish='Y' and chrDelete='N'";
//       echo $sql;exit;
        $data = $this->db->query($sql);
        $result_query = $data->num_rows();
        return $result_query;
    }

    function process() {
        $name = $this->input->get_post('varName', true);
        $varEmailId = $this->input->get_post('varEmailId', true);
        $varPhone = $this->input->get_post('varPhone', true);
        $intProduct = $this->input->get_post('intProduct', true);
        $varCity = $this->input->get_post('varCity', true);
        $txtMessage = strip_tags($this->input->get_post('txtMessage', true));
        $data = array(
            'varName' => $name,
            'varEmailId' => $varEmailId,
            'varPhone' => $varPhone,
            'intProduct' => $intProduct,
            'txtMessage' => $txtMessage,
            'varCity' => $varCity,
            'chrDelete' => 'N',
            'chrPublish' => 'Y',
            'dtCreateDate' => date('Y-m-d H:i:s'),
            'dtModifyDate' => date('Y-m-d H:i:s'),
            'PUserGlCode' => "2",
            'varIpAddress' => $_SERVER['REMOTE_ADDR']
        );
//        print_R($data);exit;
        $this->db->insert('contactusleads', $data);
        $id = $this->db->insert_id();
        $this->send_contact_info();
        return true;
    }

    function send_contact_info() {
        $email_header = $this->mylibrary->get_email_header();
        $email_footer = $this->mylibrary->get_email_footer();
        $email_left = $this->mylibrary->get_email_left();
        $name = $this->input->get_post('varName', true);
        $varPhone = $this->input->get_post('varPhone', true);
        $varEmailId = $this->input->get_post('varEmailId', true);
        $varCity = $this->input->get_post('varCity', true);
        $varMessage = nl2br(strip_tags($this->input->get_post('txtMessage', true)));
        $subject = 'New Contact Enquiry Received';
        $body = '';

        $bullateLogo = ADMIN_MEDIA_URL . "mailtemplates/images/site_arrow.png";
        $logo = ADMIN_MEDIA_URL;
        $siteLogo = ADMIN_MEDIA_URL . "mailtemplates/images/websitelogo.svg";
        $socimg = SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/';

        $body .= '<tr>
                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">First Name: </strong>' . $name . '</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
                                                                                <td style="font-family:Arial, Helvetica, sans-serif; color:#081832; font-size:13px;" valign="middle" height="24" align="left"><strong style="color:#333333;">Email: </strong><a title="' . $varEmailId . '" href="mailto:' . $varEmailId . '" style="color:#337ab7; text-decoration:none;"> ' . $varEmailId . '</a></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:7px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Phone: </strong>' . $varPhone . '</td>
                                                                            </tr>';
        if ($varCity != '') {
            $body .= '<tr>
                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:6px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">City: </strong>' . $varCity . '</td>
                                                                            </tr>';
        }
        $body .= '<tr>
                                                                                <td width="20" valign="top" height="24" align="left"><img src="' . FRONT_MEDIA_URL . 'mail/email_bullat.png" style="margin:6px 0 0px 0;vertical-align: top;" alt="" width="9" vspace="7" height="13"></td>
                                                                                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#666" valign="middle" height="24" align="left"><strong style="color:#333333;">Message: </strong>' . $varMessage . '</td>
                                                                            </tr>';

        if (FACEBOOK_LINK != '') {
            $fbFollous .= '<td align="center"><a href="' . FACEBOOK_LINK . '" style="border:none;" title="Facebook" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/fb.png" style="border:none;margin:0 10px 0 0;" alt="Facebook"></a></td>';
        } if (GOOGLE_PLUS_LINK != '') {
            $glFollous .= '<td align="center"><a href="' . GOOGLE_PLUS_LINK . '" style="border:none;" title="Google+" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/gplus.png" style="border:none;margin:0 10px 0 0;" alt="Google +"></a></td>';
        } if (LINKEDIN_LINK != '') {
            $liFollous .= '<td align="center"><a href="' . LINKEDIN_LINK . '" style="border:none;" title="LinkIn" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/linkedin.png" style="border:none;margin:0 10px 0 0;" alt="Linked In"></a></td>';
        } if (YOUTUBE_LINK != '') {
            $ytFollous .= '<td align="center"><a href="' . YOUTUBE_LINK . '" style="border:none;" title="Youtube" target="_blank"><img src="' . SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/ytube.png" style="border:none;margin:0 10px 0 0;" alt="Youtube"></a></td>';
        }

        $content = "A new person has enquired in contact us, below are the details of that person.";
        $html_message = file_get_contents(ADMIN_MEDIA_URL . "mailtemplates/forgot_password.html");
        $html_message = str_replace("@CONTENT", $content, $html_message);
        $html_message = str_replace("@MAIL_HEADER", $email_header, $html_message);
        $html_message = str_replace("@MAIL_FOOTER", $email_footer, $html_message);
        $html_message = str_replace("@FLOLLOW", $Follous, $html_message);
        $html_message = str_replace("@MAIL_LEFT", '', $html_message);
        $html_message = str_replace("@DETAILS", $body, $html_message);
        $html_message = str_replace("@YEAR", date('Y'), $html_message);
        $html_message = str_replace("@FACEBOOK", $fbFollous, $html_message);
        $html_message = str_replace("@TWITTER", $twFollous, $html_message);
        $html_message = str_replace("@YOUTUBE", $ytFollous, $html_message);
        $html_message = str_replace("@GOOGLE+", $glFollous, $html_message);
        $html_message = str_replace("@LINKEDIN", $liFollous, $html_message);
        $html_message = str_replace("@SKYPE", $skFollous, $html_message);
        $html_message = str_replace("@SITE_NAME", SITE_NAME, $html_message);
        $html_message = str_replace("@NAME", "Administrator", $html_message);
        $html_message = str_replace("@SITE_PATH", SITE_PATH, $html_message);
        $html_message = str_replace("@MEDIA_URL", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH, $html_message);
        $html_message = str_replace("@BGLOGO", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/header_bg.png', $html_message);
        $html_message = str_replace("@LOGO", SITE_PATH . ADMINPANEL_MAIL_TEMPLATES_PATH . 'images/websitelogo.svg', $html_message);
        $html_message = str_replace("@SIGNATURE", EMAIL_SIGNATURE, $html_message);
        $html_message = str_replace("@LOGO", $siteLogo, $html_message);

//        echo $html_message;
//        exit;

        $recipients = explode(',', CONTACT_US_EMAILID); // your email address
        foreach ($recipients as $contact) {
            $resp = $this->mylibrary->send_mail($contact, $subject, $html_message);
            $headers = "From: " . SITE_NAME . " <" . MAIL_FROM . ">\r\n";
            $headers .= "Reply-To: " . $varEmailId . "\r\n";
            $headers .= "Content-type: text/html\r\n";
        }


        $data = array(
            'chrReceiver_Type' => 'C',
            'fk_EmailType' => '2',
            'varFrom' => MAIL_FROM,
            'txtTo' => CONTACT_US_EMAILID,
            'txtSubject' => $subject,
            'txtBody' => $html_message,
            'chrDelete' => 'N',
            'chrPublish' => 'Y',
            'dtCreateDate' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('emails', $data);
        return true;
//        } else {
//            return false;
//        }
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

    function downloadfiles($id = '') {
//        $id = $this->input->get_post('id', true);
        $sql = "select varTitle,varFile from " . DB_PREFIX . "buylead_docs WHERE chrPublish='Y' and chrDelete='N' and intBuyLeads='" . $id . "'";
        $data = $this->db->query($sql);
        $result_query = $data->result_array();
        return $result_query;
    }

    function getAllnewsfeedRecords() {
        $sql = "select N.*,N.int_id as id, N.dtCreateDate as CDate,N.varImage as varImage1, R.varImage as Profilepic,N.dtCreateDate as Date,R.* from " . DB_PREFIX . "NewsFeed N LEFT JOIN " . DB_PREFIX . "Registration as R on N.intUserId = R.int_id WHERE N.chrPublish='Y' and N.chrDelete='N' group by N.int_id order by N.dtCreateDate desc limit 0,3";
        $data = $this->db->query($sql);
        $result_query = $data->result();
        return $result_query;
    }

    function getNewsComments($id) {
//        $sql = "select* from " . DB_PREFIX . "NewsFeedComments WHERE chrPublish='Y' and chrDelete='N' and intFkNews='$id' order by dtCreateDate desc";
        $sql = "select N.*,N.dtCreateDate as Date, R.varImage as Profilepic,R.* from " . DB_PREFIX . "NewsFeedComments N LEFT JOIN " . DB_PREFIX . "Registration as R on N.intUserId = R.int_id WHERE N.chrPublish='Y' and N.chrDelete='N' and N.intFkNews='$id' group by N.int_id order by N.dtCreateDate desc";
        $data = $this->db->query($sql);
        $result_query = $data->result();
        return $result_query;
    }

    function CountNewsComments($id) {
//        $sql = "select* from " . DB_PREFIX . "NewsFeedComments WHERE chrPublish='Y' and chrDelete='N' and intFkNews='$id' order by dtCreateDate desc";
        $sql = "select N.*,N.dtCreateDate as Date, R.varImage as Profilepic,R.* from " . DB_PREFIX . "NewsFeedComments N LEFT JOIN " . DB_PREFIX . "Registration as R on N.intUserId = R.int_id WHERE N.chrPublish='Y' and N.chrDelete='N' and N.intFkNews='$id' group by N.int_id order by N.dtCreateDate desc";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;
    }

    function CountRows_front() {

        $sql = "select S.*,P.*,a.varAlias as alias from " . DB_PREFIX . "Services S LEFT JOIN " . DB_PREFIX . "ServiceAlbum as P on P.Fk_Photoalbum = S.int_id LEFT JOIN " . DB_PREFIX . "alias as a on a.fk_Record = S.int_id WHERE S.chrPublish='Y' and S.chrDelete='N' and a.fk_ModuleGlCode=99 and P.Chr_Defaultimage='Y' group by S.int_id order by S.intDisplayOrder asc";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        return $rowcount;


//        $Query = $this->db->query("select E.*,P.*,a.varAlias as alias from " . DB_PREFIX . "Services E LEFT JOIN " . DB_PREFIX . "ServiceAlbum as P on P.Fk_Photoalbum = E.int_id LEFT JOIN " . DB_PREFIX . "alias as a on a.fk_Record = E.int_id WHERE E.chrPublish='Y' and E.chrDelete='N' and a.fk_ModuleGlCode=99 and P.Chr_Defaultimage='Y' group by E.int_id order by E.intDisplayOrder asc");
//        $Count = $Query->num_rows();
//        echo $Count;
//        $this->numofrows = $Count;
//        return $Count;
    }

    public function get_blog_data() {
        $month = $this->input->get_post('month');
        $cat = $this->input->get_post('cat');
        if ($month != '') {
            $where = " and MONTH(N.dtBlogDate) = $month";
        } else if ($cat != '') {
            $where = " and N.varTitle like '%$cat%' ";
        } else {
            $where = "";
        }
        $sql = "select N.*,A.varAlias from " . DB_PREFIX . "blogs as N LEFT JOIN " . DB_PREFIX . "alias as A ON N.int_id=A.fk_Record WHERE  A.fk_ModuleGlCode='124'  and N.chrPublish='Y' and N.chrDelete='N' $where group by N.int_id order by N.dtBlogDate desc,N.int_id desc";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

//getMOQData
//getMOQData
}

?>
