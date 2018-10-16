<script type="text/javascript">


    function newSendGridBindRequesta() {
//        alert("asd");
        var appendurl;
        var ExtraSearch;
        var view;
        var url;
//        if (ChkObjects('cmbmodulestop')) {
        view = document.getElementById('cmbmodulestop').value;
//        } else {
//            view = "";
//        }
//
//alert(view);
        if (view != '') {
            ExtraSearch = "?view=" + view;
        } else {
            ExtraSearch = "";
        }
        appendurl = ExtraSearch;
        url = encodeURI('<?php echo MODULE_PAGE_NAME; ?>' + appendurl);
//         alert(url);
        window.location.href = url;
    }


    function verify() {
        var CheckedLength = $("input[type='checkbox'][name='chkgrow']:checked").length;
        if (CheckedLength == 0) {
            UIkit.modal.alert('Please select atleast one record to be deleted.');
            return false;
        }
        UIkit.modal.confirm('Caution! The selected records will be deleted. Press OK to confirm.', function () {
            var tablename = document.getElementById('h_tablename').value;
            var view = document.getElementById('h_view').value;
            if (CheckedLength > 0) {
                SendGridBindRequestTrashmanager('<?php echo MODULE_PAGE_NAME ?>', 'gridbody', 'D', 'chkgrow', view, tablename);
            }
        });
    }

    function restore()
    {

        UIkit.modal.confirm('Caution! The selected records will be restored. Press OK to confirm.', function () {
            var tablename = document.getElementById('h_tablename').value;
            var view = document.getElementById('h_view').value;
            SendGridBindRequestTrashmanager('<?php echo MODULE_PAGE_NAME ?>', 'gridbody', 'R', 'chkgrow', view, tablename);
        });
    }

    function DeleteAllRecords() {
        UIkit.modal.confirm('Caution! All trash records will be deleted. Press OK to confirm.', function () {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>adminpanel/trashmanager/DeleteAllTrash?",
                data: {
                    "csrf_indibizz": csrfHash
                },
                async: true,
                success: function () {
                    location.reload();
                    UIkit.modal.alert("Congratulation all records are deleted successfully.");
                    return false;
                }
            });
        });
    }
</script>
<?php if ($ajax != 'Y') { ?>
    <div id="gridbody">
    <?php } ?>    
    <div id="page_content">
        <div id="page_content_inner">
            <div id="top_bar">
                <ul id="breadcrumbs">
                    <li><a href="<?php echo ADMINPANEL_HOME_URL; ?>">Home</a></li>
                    <li><span>Manage Trash Manager</span></li>
                </ul>
            </div>

            <?php
            $view_request = $this->input->get_post('view', true);
            if (!empty($view_request)) {
                $view_request = $view_request;
            } else {
                $view_request = 'pages';
            }
//        echo $mlslistinglink;
            if (!empty($view_request)) {
                if ($this->input->get_post('view') == 'pages/contactinfo') {
                    $this->view = '';
                    $searchArray = array("varTitle" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'pages';
                    $this->displayfield1 = "varTitle";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Title";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'pages/contactinfo';
                    $view1 = 'Trash Manager - ContactInfo';
                } else if ($this->input->get_post('view') == 'contactusleads') {
                    $this->view = '';
                    $searchArray = array("varName" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'contactusleads';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "varEmailId";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "Email";
                    $this->view = 'contactusleads';
                    $view1 = 'Trash Manager - ContactUs Leads';
                } else if ($this->input->get_post('view') == 'newsletterleads') {
                    $this->view = '';
                    $searchArray = array("varName" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'newsletterleads';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "varEmailId";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "Email";
                    $this->view = 'newsletterleads';
                    $view1 = 'Trash Manager - Newsletter Leads';
                } else if ($this->input->get_post('view') == 'emails') {
                    $this->view = '';
                    $searchArray = array("varFrom" => "From", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'emails';
                    $this->displayfield1 = "varFrom";
                    $this->displayfield2 = "fk_EmailType";
                    $this->displayfieldtitle1 = "emails";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'emails';
                    $view1 = 'Trash Manager - Emails';
                } else if ($this->input->get_post('view') == 'banner') {
                    $this->view = '';
                    $searchArray = array("varTitle" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'banner';
                    $this->displayfield1 = "varTitle";
                    $this->displayfield2 = "Chr_Banner_Type";
                    $this->displayfieldtitle1 = "Title";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'banner';
                    $view1 = 'Trash Manager - Banner';
                } else if ($this->input->get_post('view') == 'blogs') {
                    $this->view = '';
                    $searchArray = array("varTitle" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'blogs';
                    $this->displayfield1 = "varTitle";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Title";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'blogs';
                    $view1 = 'Trash Manager - Blogs';
                } else if ($this->input->get_post('view') == 'commonfiles') {
                    $this->view = '';
                    $searchArray = array("varTitle" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'commonfiles';
                    $this->displayfield1 = "varTitle";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "File Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'commonfiles';
                    $view1 = 'Trash Manager - Common Files';
                } else if ($this->input->get_post('view') == 'delivery_terms') {
                    $this->view = '';
                    $searchArray = array("varName" => "Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'delivery_terms';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'delivery_terms';
                    $view1 = 'Trash Manager - Delivery Terms';
                } else if ($this->input->get_post('view') == 'unit_master') {
                    $this->view = '';
                    $searchArray = array("varName" => "Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'unit_master';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'unit_master';
                    $view1 = 'Trash Manager - Unit Master';
                }else if ($this->input->get_post('view') == 'testimonial') {
                    $this->view = '';
                    $searchArray = array("varName" => "Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'testimonial';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'testimonial';
                    $view1 = 'Trash Manager - Testimonial';
                }else if ($this->input->get_post('view') == 'careers') {
                    $this->view = '';
                    $searchArray = array("varTitle" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'careers';
                    $this->displayfield1 = "varTitle";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Title";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'careers';
                    $view1 = 'Trash Manager - Careers';
                } else if ($this->input->get_post('view') == 'buyer_seller') {
                    $this->view = '';
                    $searchArray = array("varName" => "User", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'users';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "User Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'users';
                    $view1 = 'Trash Manager - Buyer / Seller';
                } else if ($this->input->get_post('view') == 'employees') {
                    $this->view = '';
                    $searchArray = array("varName" => "User", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'users';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "User Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'users';
                    $view1 = 'Trash Manager - Employees';
                } else if ($this->input->get_post('view') == 'employers') {
                    $this->view = '';
                    $searchArray = array("varName" => "User", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'users';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "User Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'users';
                    $view1 = 'Trash Manager - Employers';
                } else if ($this->input->get_post('view') == 'faqs') {
                    $this->view = '';
                    $searchArray = array("varName" => "Question", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'faqs';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Question";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'faqs';
                    $view1 = 'Trash Manager - FAQ\'s';
                } else if ($this->input->get_post('view') == 'features') {
                    $this->view = '';
                    $searchArray = array("varName" => "User", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'features';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'features';
                    $view1 = 'Trash Manager - Features';
                } else if ($this->input->get_post('view') == 'inspection') {
                    $this->view = '';
                    $searchArray = array("varName" => "User Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'users';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "User Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'users';
                    $view1 = 'Trash Manager - Inspection Service Providers';
                } else if ($this->input->get_post('view') == 'logistic') {
                    $this->view = '';
                    $searchArray = array("varName" => "User Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'logistic';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "User Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'users';
                    $view1 = 'Trash Manager - Inspection Service Providers';
                } else if ($this->input->get_post('view') == 'payment_terms') {
                    $this->view = '';
                    $searchArray = array("varName" => "Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'payment_terms';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'payment_terms';
                    $view1 = 'Trash Manager - Payment Terms';
                } else if ($this->input->get_post('view') == 'payment_types') {
                    $this->view = '';
                    $searchArray = array("varName" => "Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'payment_types';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'payment_types';
                    $view1 = 'Trash Manager - Payment Types';
                } else if ($this->input->get_post('view') == 'plans') {
                    $this->view = '';
                    $searchArray = array("varName" => "Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'plans';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'plans';
                    $view1 = 'Trash Manager - Plans';
                } else if ($this->input->get_post('view') == 'product') {
                    $this->view = '';
                    $searchArray = array("varName" => "Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'product';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'product';
                    $view1 = 'Trash Manager - Products';
                } else if ($this->input->get_post('view') == 'product_category') {
                    $this->view = '';
                    $searchArray = array("varName" => "Name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'product_category';
                    $this->displayfield1 = "varName";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'product_category';
                    $view1 = 'Trash Manager - Products Category';
                } else if ($this->input->get_post('view') == 'sticky_notes') {
                    $this->view = '';
                    $searchArray = array("title" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'sticky_notes';
                    $this->displayfield1 = "title";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "title";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'sticky_notes';
                    $view1 = 'Trash Manager - Sticky Notes';
                } else if ($this->input->get_post('view') == 'event') {
                    $this->view = '';
                    $searchArray = array("varTitle" => "Title", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'event';
                    $this->displayfield1 = "varTitle";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Title";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'event';
                    $view1 = 'Trash Manager - Event';
                } else {
                    $this->view = '';
                    $searchArray = array("varTitle" => "Page name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                    $this->tablename = DB_PREFIX . 'pages';
                    $this->displayfield1 = "varTitle";
                    $this->displayfield2 = "";
                    $this->displayfieldtitle1 = "Page Name";
                    $this->displayfieldtitle2 = "";
                    $this->view = 'pages';
                    $view1 = 'Trash Manager - Pages';
                }
            } else {
                $this->view = '';
                $searchArray = array("varTitle" => "Page name", "PUserGlCode" => "User Name", "varIpAddress" => "Ip Address");
                $this->tablename = DB_PREFIX . 'pages';
                $this->displayfield1 = "varTitle";
                $this->displayfield2 = "";
                $this->displayfieldtitle1 = "Page Name";
                $this->displayfieldtitle2 = "";
                $this->view = 'pages';
                $view1 = 'Trash Manager - Pages';
            }
            ?>

            <h3 class="heading_b uk-margin-bottom"><?php echo $view1; ?></h3>
            <?php // echo $FilterPanel; ?>
            <?php // echo $PagingTop; ?>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <div class="uk-form-row">
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <?php echo $ModulesCombo; ?>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <input name="h_tablename" type="hidden" id="h_tablename" value="<?php echo $this->tablename ?>" />
            <input name="h_view" type="hidden" id="h_view" value="<?php echo $this->view ?>" />
            <input name="trname" type="hidden" id="trname" value="pages" />
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><input onclick="checkall('chkgrow')" id="chkall" name="chkall" type="checkbox" value=""></th>
                                <th><?php echo $this->displayfieldtitle1 ?><?php echo $this->module_model->sortvar; ?></th>
                                <th>User Name</th>
                                <th>IP Address</th>
                                <th>Deleted Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $rowcount = 0;
                            if ($counttotal > 0) {
                                foreach ($selectAll as $row) {
                                    ?>
                                <input type="hidden" name="fk_hdpages" id="fk_hdpages_<?php echo $row->int_id ?>" value="<?= $row->fk_pages ?>" />
                                <tr>
                                    <td>
                                        <input name="chkgrow" id="chkgrow" type="checkbox" value="<?php echo $row->int_id ?>" />
                                    </td>


                                    <td>
                                        <?php
                                        $disp_as = $this->displayfield1;
                                        $char = substr($row->$disp_as, 0, 25);
                                        if (strlen($row->$disp_as) > 25) {
                                            $char .= '...';
                                        }

                                        if ($this->input->get_post('view') == 'banner') {
                                            $disp_as1 = $this->displayfield2;

                                            $char1 = substr($row->$disp_as1, 0, 25);
                                            if (strlen($row->$disp_as1) > 25) {
                                                $char1 .= '...';
                                            }
                                        }
                                        if ($this->input->get_post('view') == 'emails') {
                                            $disp_as11 = $this->displayfield2;
                                            $char11 = substr($row->$disp_as11, 0, 25);
                                            if (strlen($row->$disp_as11) > 25) {
                                                $char11 .= '...';
                                            }
                                        }
                                        if ($this->input->get_post('view') == 'courses') {
                                            $disp_as1 = $this->displayfield2;
                                            $char2 = substr($row->$disp_as1, 0, 25);
                                            if (strlen($row->$disp_as1) > 25) {
                                                $char2 .= '...';
                                            }
                                        }
                                        if ($this->input->get_post('view') == 'banner') {
                                            $select1 = "select Chr_Banner_Type from " . DB_PREFIX . "banner where Chr_Banner_Type='" . $char1 . "'";
                                            $result = $this->db->query($select1);
                                            $row111 = $result->row_array();
                                            if ($row111['Chr_Banner_Type'] == 'H') {
                                                $banner = 'Home Banner';
                                            } else {
                                                $banner = 'Inner Banner';
                                            }
                                            echo $char . "(" . $banner . ")";
                                        } else if ($this->input->get_post('view') == 'emails') {
                                            $select11 = "select fk_EmailType from " . DB_PREFIX . "emails where fk_EmailType='" . $char11 . "'";
                                            $val11 = $this->db->query($select11);
                                            $row1111 = $val11->row_array();
                                            if ($row1111['fk_EmailType'] == '1') {
                                                $title = 'Forgot Password';
                                            } else if ($row1111['fk_EmailType'] == '2') {
                                                $title = 'Contact Us Leads';
                                            } else if ($row1111['fk_EmailType'] == '3') {
                                                $title = 'Admin Emails';
                                            } else if ($row1111['fk_EmailType'] == '4') {
                                                $title = 'NewsLetters leads';
                                            }
                                            ?>
                                            <span><?php echo $char . " (" . $title . ")"; ?></span>
                                            <?php
                                        } else {
                                            ?>         
                                            <span><?php echo $char; ?></span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $row->Username; ?> </td>
                                    <td><?php echo $row->varIpAddress; ?></td>

                                    <td><?php echo date(str_replace('%', '', DEFAULT_DATEFORMAT), strtotime($row->dtModifyDate)) . ' ' . $row->Time; ?></td>
                                </tr>
                                <?php
                                $rowcount++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" align="center"><strong><?php echo NO_RECORDS ?></strong></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>		  
                    <input type="hidden" name="ptrecords" id="ptrecords" value="<?php echo $rowcount ?>">

                    <div class="spacer10"></div> 
                    <?php
                    if ($permissionArry['Delete'] == 'Y') {
                        if ($counttotal > 0) {
                            ?> 
                            <a href="javascript:;"  onclick="return verify();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete</a>
                            <?php
                        }
                    }
                    ?>        
                    <?php if (USERTYPE == 'N') { ?>        
                        <a href="javascript:;"  onclick="return DeleteAllRecords();" class="md-btn md-btn-primary md-btn-wave-light md-btn-icon"> <i class="material-icons">delete</i>Delete All Trash Records</a>
                    <?php } ?>  
                    <?php
                    if ($permissionArry['Restore'] == 'Y') {
                        if ($counttotal > 0) {
                            ?>
                            <a href="javascript:;"  onclick="return restore();" class="md-btn md-btn-success md-btn-wave-light md-btn-icon"> <i class="material-icons">restore</i>Restore</a>
                                <!--<a href="javascript:;" onclick="return restore();" class="fl"><span class="btn-green-ic"><b class="icon-external-link"></b>Restore</span></a>-->
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($ajax != 'Y') { ?>    
    </div>
<?php } ?>