<?php
// Include FB config file && User class
require_once '../../config.php';
require_once '../function.php';
require_once 'fbConfig.php';

/*error_reporting(1);
error_reporting(E_WARNING | E_PARSE);*/


if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;

        // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }

    // Redirect the user back to the same page if url has "code" parameter in query string
    if(isset($_GET['code'])){
        header('Location: ./');
    }

    // Getting user facebook profile info
    try {
        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,picture');
        $fbUserProfile = $profileRequest->getGraphNode()->asArray();
    } catch(FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        header("Location: ./");
        exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    // Initialize User class
    //$user = new User();
    if(isset($fbUserProfile['email'])){
        // Insert or update user data to the database
        $fbUserData = array(
            'oauth_provider'=> 'facebook',
            'oauth_uid' 	=> $fbUserProfile['id'],
            'first_name' 	=> $fbUserProfile['first_name'],
            'last_name' 	=> $fbUserProfile['last_name'],
            'email' 		=> $fbUserProfile['email'],
            'gender' 		=> $fbUserProfile['gender'],
            'picture' 		=> $fbUserProfile['picture']['url'],
            'link' 			=> $fbUserProfile['link']
        );

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $flargePic = file_get_contents('https://graph.facebook.com/'.$fbUserProfile['id'].'/picture?type=normal', false, stream_context_create($arrContextOptions));
        $upOne = realpath(dirname(__FILE__) . '/../../..');

        $picname = $fbUserProfile['id'].'.jpg';
        $lfile = $upOne.'/storage/user_image/'.$picname;
        file_put_contents($lfile, $flargePic);

    }


    if($fbUserData['email'] == "")
    {
        $error = "Please add email id in facebook account later try again";
        echo "<script type='text/javascript'>alert('$error');</script>";
        redirect_parent($config['site_url'] ."logout.php",true);
        exit();
    }

echo $fbUserData['email'];
    /* ---- Session Variables -----*/
    $userData = array();
    $userData = checkSocialUser($con,$config,$fbUserData,$picname);

    if(!is_array($userData))
    {
        $error = "Email address not exist";
        echo "<script type='text/javascript'>alert('$error');</script>";
        redirect_parent($config['site_url'] ."logout.php",true);
        exit();
    }
    elseif($userData['status'] == 2)
    {
        $error = "Your account banned by admin";
        echo "<script type='text/javascript'>alert('$error');</script>";
        redirect_parent($config['site_url'] ."logout.php",true);
        exit();
    }
    else
    {
        $_SESSION['username'] = $userData['username'];
        $_SESSION['id'] = $userData['id'];
        $_SESSION['email'] = $userData['email'];

        redirect_parent($config['site_url'] ."login.php",true);
    }

    // Get logout url
    $logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'logout.php');

    // Render facebook profile data
    if(!empty($userData)){
        $output  = '<h1>Facebook Profile Details </h1>';
        $output .= '<img src="'.$userData['picture'].'">';
        $output .= '<br/>Facebook ID : ' . $userData['oauth_uid'];
        $output .= '<img src="'.$config['site_url'].'/storage/profile/'.$picname.'">';
        $output .= '<br/>Picname : ' . $picname;
        $output .= '<br/>Name : ' . $userData['first_name'].' '.$userData['last_name'];
        $output .= '<br/>Email : ' . $userData['email'];
        $output .= '<br/>Gender : ' . $userData['gender'];
        $output .= '<br/>Logged in with : Facebook';
        $output .= '<br/><a href="'.$userData['link'].'" target="_blank">Click to Visit Facebook Page</a>';
        $output .= '<br/>Logout from <a href="'.$logoutURL.'">Facebook</a>';
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }

}
else{
    // Get login url
    $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);

    // Render facebook login button
    //$output = '<a href="'.htmlspecialchars($loginURL).'"><img src="images/fblogin-btn.png"></a>';

    echo "<script type='text/javascript'>window.location.href='$loginURL'</script>";
}
?>

<?php echo $output; ?>