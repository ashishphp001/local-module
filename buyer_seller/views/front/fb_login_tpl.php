<?php
session_start();
// added in v4.0.0
require_once 'facebook/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

// init app with app id and secret
FacebookSession::setDefaultApplication('1785908014820880', '0cb06f8d9c93c35e5eb46ee2ceaaffd0');
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('https://www.indibizz.com/login/fblogin');
try {
    $session = $helper->getSessionFromRedirect();
} catch (FacebookRequestException $ex) {
    // When Facebook returns an error
} catch (Exception $ex) {
    // When validation fails or other local issues
}
// see if we have a session
if (isset($session)) {
    // graph api request for user data
    $request = new FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    // get response
    $graphObject = $response->getGraphObject();
    $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
    /* ---- Session Variables ----- */
    $_SESSION['FBID'] = $fbid;
    $_SESSION['FULLNAME'] = $fbfullname;
    $_SESSION['EMAIL'] = $femail;

    $this->common_model->getUserDataByEmail($femail);
    if (count($row) == 1) {

        $data = array(
            SESSION_PREFIX . 'UserLoginUserId' => $row->int_id,
            SESSION_PREFIX . 'UserLoginEmail' => $row->varEmail,
            SESSION_PREFIX . 'UserLoginName' => $row->varName,
            SESSION_PREFIX . 'UserLoginPhone' => $row->varPhone,
            SESSION_PREFIX . 'UserLoginType' => $row->chrType,
            SESSION_PREFIX . 'UserLoginIpAddress' => $_SERVER['REMOTE_ADDR']
        );
        $this->session->set_userdata(PREFIX, $data);
    }
    ?>
    <div class="container">
        <div class="hero-unit">
            <h1>Hello <?php echo $_SESSION['USERNAME']; ?></h1>
            <p>Welcome to "facebook login" tutorial</p>
        </div>
        <div class="span4">
            <ul class="nav nav-list">
                <li class="nav-header">Image</li>
                <li><img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture"></li>
                <li class="nav-header">Facebook ID</li>
                <li><?php echo $_SESSION['FBID']; ?></li>
                <li class="nav-header">Facebook fullname</li>
                <li><?php echo $_SESSION['FULLNAME']; ?></li>
                <li class="nav-header">Facebook Email</li>
                <li><?php echo $_SESSION['EMAIL']; ?></li>
                <div><a href="logout.php">Logout</a></div>
            </ul></div></div>

    <?php
} else {
    $loginUrl = $helper->getLoginUrl();
    header("Location: " . $loginUrl);
}
?>