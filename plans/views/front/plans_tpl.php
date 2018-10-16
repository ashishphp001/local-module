<script>
    function strikevalue(id, type) {
//        alert("Asd");

        $.ajax({
            type: "POST",
            data: {"<?php echo $this->security->get_csrf_token_name(); ?>": csrfHash, 'id': id, 'type': type},
            url: "<?php echo $this->common_model->getUrl("pages", "2", "44", '') . "/getPlanPrice"; ?>",
            success: function (Data)
            {
                $("#saveprice" + id).html(Data);
            }
        });

//        
    }

    function paymentlink(id, link, path) {
        var payment_id = $('#intPlan' + id).val();
        var payment_link = '<?php echo $this->common_model->getUrl("pages", "2", "44", '') . "/payment?plan="; ?>' + id + '&type=' + payment_id;
//    alert(payment_link); return false;   
        if (path == 'Y') {
            document.getElementById('varPath').value = payment_link;
        } else {
            window.location.href = payment_link;
        }

    }
</script>
<?php
if (USER_ID != '') {
    $UserData = $this->common_model->getUserData(USER_ID);
//    print_R($UserData);
    if ($UserData['varPhone'] == '' || $UserData['varEmail'] == '') {
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $(document).ready(function () {
                    $('#invoice-thanks').modal({dismissible: false});
                    $('#invoice-thanks').modal('open');
                    document.getElementById('modal-close').style.display = 'none';
                });
            });
            $(document).ready(function () {
                $.validator.addMethod("phonenumber", function (value, element) {
                    var numberPattern = /\d+/g;
                    var newVal = value.replace(/\D/g, '');
                    if (parseInt(newVal) <= 0)
                    {
                        return false;
                    } else
                    {
                        return true;
                    }
                }, "Please enter a valid number.");
                $("#FrmMember").validate({
                    ignore: [],
                    rules: {
                        varPaymentPhone: {
                            minlength: 5,
                            required: true,
                            maxlength: 20,
                            phonenumber: {
                                depends: function () {
                                    if (($("#varPaymentPhone").val()) != '') {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        },
                        varPaymentEmail: {
                            email: true,
                            required: true
                        }
                    },
                    errorPlacement: function (error, element) {
                    },
                    submitHandler: function (form) {
                        var User_Email = $('#varPaymentEmail').val();
                        var User_Phone = $('#varPaymentPhone').val();
                        $.ajax({
                            type: "GET",
                            url: "<?php echo $this->common_model->getUrl("pages", "2", "89", ''); ?>/Check_Email_Phone?User_Email=" + User_Email + "&User_Phone=" + User_Phone,
                            success: function (Data)
                            {
                                if (Data == 1) {
                                    form.submit();
                                } else {
                                    M.toast({html: 'Email/mobile you entered is already registered with Indibzz.'});
                                    return false;
                                }
                            }
                        });
                    }
                });
            });
        </script>
        <div id="invoice-thanks" class="modal modal-fixed-footer get-quot-popup rfq-invoice-popp rfq-invoice-thanks live-change">
            <div class="modal-content mCustomScrollbar light" data-mcs-theme="minimal-dark">
                <div class="rfq-detail-access row">
                    <?php
                    $attributes = array('name' => 'FrmMember', 'id' => 'FrmMember', 'enctype' => 'multipart/form-data', 'method' => 'post');
                    $action = $this->common_model->getUrl("pages", "2", "44", '') . "/update_data";
                    echo form_open($action, $attributes);
                    ?>
                    <input type="hidden" id="intPaymentUser" name="intPaymentUser" value="<?php echo $UserData['int_id']; ?>">
                    <div class="col s12 m12 manage-field">
                        <?php if ($UserData['varEmail'] == '') { ?>
                            <div class="col m12 s12 ">
                                <div class="input-field field-custom">
                                    <input type="text" id="varPaymentEmail" autocomplete="off" name="varPaymentEmail" class="autocomplete">
                                    <label for="autocomplete-product-get">Email</label>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($UserData['varPhone'] == '') { ?>
                            <div class="col m12 s12 ">
                                <div class="input-field field-custom">
                                    <input type="text" id="varPaymentPhone" autocomplete="off" name="varPaymentPhone"  onkeypress="return KeycheckOnlyNumeric(event);" class="autocomplete">
                                    <label for="autocomplete-pop">Mobile Number</label>
                                </div>
                            </div>
                        <?php } ?>
                    </div> 
                    <input type="submit" class="uploaded-quots waves-effect waves-light btn" value="Update"> 
                    <?php
                    echo form_close();
                    ?>
                </div>
            </div>
            <div class="close-outside" id="modal-close"><a href="javascript:;" class="modal-close waves-effect waves-blue btn-flat"><i class="fas fa-times"></i></a></div>
        </div>
        <?php
    }
}
?>
<div class="pricing-images">
    <div class="pricin-img">
        <img src="<?php echo FRONT_MEDIA_URL; ?>images/pricing_Banner.jpg">
    </div>          
</div>
<div class="membership-style">
    <div class="container">
        <div class="row">
            <div class="prising-set">
                <div class="detail-price">
                    <div class="col s12 m12">
                        <?php
                        foreach ($SelectAll_front as $row) {
                            if ($_GET['buylead'] != '') {
                                $buyleadid = "&buylead=" . $_GET['buylead'];
                            } else {
                                $buyleadid = '';
                            }
                            $paymentlink = $this->common_model->getUrl("pages", "2", "44", '') . "/payment?plan=" . $row['int_id'] . $buyleadid;
                            ?>
                            <div class="card price-list">
                                <div class="col s12 m8">
                                    <div class="plan-img">
                                        <?php
                                        $imagename = $row['varImage'];
                                        $imagepath = 'upimages/plans/images/' . $imagename;
                                        if (file_exists($imagepath) && $row['varImage'] != '') {
                                            $image_detail_thumb = image_thumb($imagepath, ICON_SIZE_WIDTH, ICON_SIZE_HEIGHT);
                                            $image_thumb = image_thumb($imagepath, PLANS_WIDTH, PLANS_HEIGHT);
                                        }
                                        ?> 
                                        <img src="<?php echo $image_thumb; ?>">
                                    </div>
                                </div>
                                <div class="col s12 m4">
                                    <?php
                                    if ($row['int_id'] == 1) {
                                        $class = "ibase-demo";
                                    } else {
                                        $class = "istandard-demo";
                                    }
                                    ?>
                                    <div class="deatil-of-plan <?php echo $class; ?>">
                                        <div class="plan-head">
                                            <!-- <div class="plan-ic">
                                                 <img src="images/ibase.png">
                                            </div> -->
                                            <h5><?php echo $row['varName']; ?></h5>
                                        </div>
                                        <div class="list-plan">
                                            <?php echo $this->mylibrary->Replace_Varible_with_Sitepath($row['txtDescription']); ?>
                                        </div>
                                        <div class="drop-plan">
                                            <div class="col m12 s12 more-info padding">
                                                <div class="form-part">
                                                    <div class="input-field field-custom">
                                                        <!--  <label>Select Plan</label> -->
                                                        <div id="saveprice<?php echo $row['int_id']; ?>"><b>Original Price :</b> <strike> 
                                                                <?php
                                                                if ($row['intMonthlyOriginalPrice'] != '') {
                                                                    echo "&#8377;" . $row['intMonthlyOriginalPrice'];
                                                                } else {
                                                                    echo "&#8377;" . $row['intYearlyOriginalPrice'];
                                                                }
                                                                ?>
                                                            </strike>
                                                            <?php
                                                            if ($row['intMonthlyOriginalPrice'] != '') {
                                                                echo " / Month";
                                                            } else {
                                                                echo " / Year";
                                                            }
                                                            ?>
                                                        </div>
                                                        <select onchange="return strikevalue(<?php echo $row['int_id']; ?>, this.value)" id="intPlan<?php echo $row['int_id']; ?>" name="intPlan<?php echo $row['int_id']; ?>">
                                                            <option value="1"><?php echo "&#8377;" . $row['varPrice']; ?> / Month</option>
                                                            <option value="2"><?php echo "&#8377;" . $row['varYearlyPrice']; ?> / Year</option>
                                                            <?php if ($row['intOfferPrice'] != '0') { ?>
                                                                <option value="3"><?php echo "&#8377;" . $row['intOfferPrice']; ?> / <?php echo $row['intMonth']; ?> Months</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="purchase-button">
                                            <?php
                                            if (USER_ID == '') {
                                                if ($UserData['chrPayment'] == 'Y') {
                                                    $disable = "disable-payment";
                                                } else {
                                                    $disable = "";
                                                }
                                                ?>
                                                <a href="#home-login-popup" onclick="return paymentlink('<?php echo $row['int_id']; ?>', '<?php echo $paymentlink; ?>', 'Y')" class="big-button modal-trigger">Login & Purchase Now</a>
                                            <?php } else { ?>
                                                <a href="javascript:;" onclick="return paymentlink('<?php echo $row['int_id']; ?>', '<?php echo $paymentlink; ?>', 'N')" class="big-button <?php echo $disable; ?>">Purchase Now</a>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>
