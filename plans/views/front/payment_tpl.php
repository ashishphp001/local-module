
<?php
$MERCHANT_KEY = MERCHANT_KEY;
$SALT = SALT;
//$MERCHANT_KEY = "bpVBBIPy";
//$SALT = "bjucL4afGr";
// Merchant Key and Salt as provided by Payu.

$PAYU_BASE_URL = "https://secure.payu.in";
//$PAYU_BASE_URL = "https://sandboxsecure.payu.in";  // For Sandbox Mode
//$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = '';

$posted = array();
if (!empty($_POST)) {
    //print_r($_POST);
    foreach ($_POST as $key => $value) {
        $posted[$key] = $value;
    }
}


$formError = 0;

if (empty($posted['txnid'])) {
    // Generate random transaction id
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
//    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
    $txnid = $posted['txnid'];
}
$hash = '';

// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if (empty($posted['hash']) && sizeof($posted) > 0) {
    if (
            empty($posted['key']) || empty($posted['txnid']) || empty($posted['amount']) || empty($posted['firstname']) || empty($posted['email']) || empty($posted['phone']) || empty($posted['productinfo']) || empty($posted['surl']) || empty($posted['furl']) || empty($posted['service_provider'])
    ) {
        $formError = 1;
    } else {
//        $posted['productinfo'] = json_encode(json_decode('[{"name":"Ashish","description":"","value":"10","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach ($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string .= $SALT;


        $hash = strtolower(hash('sha512', $hash_string));
        $action = $PAYU_BASE_URL . '/_payment';
    }
} else if (!empty($posted['hash'])) {
    $hash = $posted['hash'];
    $action = $PAYU_BASE_URL . '/_payment';
}

//echo $action;exit;
?>
<html>
    <head>
        <script>
            var hash = '<?php echo $hash ?>';
            function submitPayuForm() {
                if (hash == '') {
                    return;
                } else {
                    var payuForm = document.forms.payuForm;
                    payuForm.submit();
                }
            }
        </script>
    </head>
    <body onload="submitPayuForm()" style="display: none;">
        <!--<body>-->
        <h2>Indibizz Membership</h2>
        <br/>

        <form action="<?php echo $action; ?>" method="post" name="payuForm" >
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
            <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
            <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />

            <table>
                <tr>
                    <td><b>Mandatory Parameters</b></td>
                </tr>
                <?php
                if ($_GET['type'] == '2') {
                    $plan_price = $plan_data['varYearlyPrice'];
                } else if ($_GET['type'] == '3') {
                    $plan_price = $plan_data['intOfferPrice'];
                } else {
                    $plan_price = $plan_data['varPrice'];
                }
                ?>
                <tr>
                    <td>Amount: </td>
                    <td><input name="amount" value="<?php echo $plan_price; ?>" /></td>
                    <td>First Name: </td>
                    <td><input name="firstname" id="firstname" value="<?php echo $user_data['varName']; ?>" /></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td><input name="email" id="email" value="<?php echo $user_data['varEmail']; ?>" /></td>
                    <td>Phone: </td>
                    <td><input name="phone" value="<?php echo (empty($user_data['varPhone'])) ? $user_data['varTel'] : $user_data['varPhone']; ?>" /></td>
                </tr>
                <tr>
                    <td>Product Info: </td>
                    <td colspan="3"><textarea name="productinfo"><?php echo (empty($plan_data['varName'])) ? 'iBase plan - The lowest rate B2B plan in India' : $plan_data['varName'] ?></textarea></td>
                </tr>
                <?php
                $paymentlink = $this->common_model->getUrl("pages", "2", "44", '');
                $spaymentlink = $this->common_model->getUrl("pages", "2", "44", '') . "/payment_success";
//                $spaymentlink = SITE_PATH . "payment_bluff.php";
                ?>
                <tr>
                    <td>Success URI: </td>
                    <td colspan="3"><input name="surl" value="<?php echo (empty($posted['surl'])) ? $spaymentlink : $posted['surl'] ?>"/></td>
                </tr>
                <tr>
                    <td>Failure URI: </td>
                    <td colspan="3"><input name="furl" value="<?php echo (empty($posted['furl'])) ? $paymentlink . "/failure" : $posted['furl'] ?>"/></td>
                </tr>

                <tr>
                    <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" /></td>
                </tr>
                <tr>
                    <?php if (!$hash) { ?>
                        <td colspan="4"><input type="submit" value="Submit" /></td>
                    <?php } ?>
                </tr>
            </table>
            <input type="text" name="udf1" value="<?php echo $user_data['int_id']; ?>" />
            <input type="text" name="udf2" value="<?php echo $plan_data['int_id']; ?>" />
            <input type="text" name="udf3" value="<?php echo $_GET['type']; ?>" />
        </form>
    </body>
</html>
<?php
//echo print_R($_REQUEST);exit;
//if ($_REQUEST['service_provider'] != '') {
?>
<script>
    window.onload = function () {
        document.forms['payuForm'].submit();
    }
</script>
<?php
// } ?>