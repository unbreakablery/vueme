<?php
/*
Copyright (c) 2015-17 Devendra Katariya (bylancer.com)
*/
require_once('app/config.php');
require_once('app/setting.php');

if(!isset($sesId)) {
    header("Location: login.php");
    exit;
}

$query1 = "SELECT * FROM `".$config['db']['pre']."userdata` where id = '".$sesId."'";
$result1 = $con->query($query1);
$row1 = mysqli_fetch_assoc($result1);
$string = $row1['username'];
$picname = $row1['picname'];

$ses_picname = ($picname == "")? "avatar_default.png" : $picname;

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>Gmail - Facebook Style AJAX Chat Demo - Zechat</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="php chat script, php ajax Chat,facebook similar chat, php mysql chat, chat script, facebook style chat script, gmail style chat script. fbchat, gmail chat, facebook style message inbox, facebook similar inbox, facebook like chat" />
    <meta name="description"  content="This jQuery chat module easily to integrate Gmail/Facebook style chat into your existing website." />
    <meta name="author" content="Zechat - Codentheme.com">
    <link rel="icon" href="img/favicon.png" type="image/png" sizes="16x16">
    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
    <!-- Bootstrap CSS - Not Necessary if already exist in your site. -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap CSS - Not Necessary if already exist in your site. -->
    <style>
        /*Loader start*/
        .hidden {  display: none!important;  visibility: hidden!important;  }
        .text-center {  text-align: center;  }
        .Dboot-preloader {  background-color: #fff;  display: block;  width: 100%;  height: 100%;  position: fixed;  z-index: 999999999999999;  }
        /*Loader end*/
    </style>
</head>
<body>

<!--/*Loader start*/-->
<div class="Dboot-preloader text-center">
    <img src="assets/img/loader.gif" width="400"/>
</div>

<div class="entry-board J_entryBoard">
    <div class="container">
        <ul class="external-entries">
            <li class="entry"><a href="index.php" target="_self">My Profile</a></li>
        </ul>

        <div class="account-info ">
            <div class="sign-entries" id="J_signEntries" style="display: block;">
                <ul>
                    <li class="entry">
                        <a href="https://codecanyon.net/item/wchat-fully-responsive-phpajax-chat/18047319" target="_blank">Facebook Like Inbox Messaging</a>
                    </li>
                    <li class="entry">
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div align="center" style="color: #fff; background-color: #778492; padding: 5px;">
    <div class="container"><span style="text-align: center;">Note: Please load the following links in different browsers with2 different USERID For Testing:</span></div>
</div>
<!--/*Loader END*/-->


<!-- ******HEADER****** -->
<header class="header">
    <div class="container">
        <div class="profile-picture medium-profile-picture mpp XxGreen pull-left">
            <img width="169px" style="min-height:170px;" src="storage/user_image/<?php echo $ses_picname; ?>" alt="<?php echo $_SESSION['username'];?>">
        </div>

        <div class="profile-content pull-left">
            <h1 class="name"><?php echo $row1['name'];?></h1>
            <h2 class="desc">#<?php echo $_SESSION['username'];?></h2>
            <ul class="social list-inline">
                <?php if(!empty($row1['facebook'])){?>
                    <li><a href="<?php echo $row1['facebook'];?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <?php } ?>
                <?php if(!empty($row1['twitter'])){?>
                    <li><a href="<?php echo $row1['twitter'];?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <?php } ?>
                <?php if(!empty($row1['googleplus'])){?>
                    <li><a href="<?php echo $row1['googleplus'];?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                <?php } ?>
                <?php if(!empty($row1['instagram'])){?>
                    <li><a href="<?php echo $row1['instagram'];?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <?php } ?>
            </ul>
        </div><!--//profile-->
        <a class="btn btn-cta-primary pull-right" href="edit_profile.php"><i class="fa fa-paper-plane"></i> Edit Profile</a>
    </div><!--//container-->
</header><!--//header-->






<div class="container sections-wrapper">
    <div class="row">
        <div class="primary col-md-8 col-sm-12 col-xs-12">
            <section class="about section">
                <div class="section-inner">
                    <h2 class="heading">About Me</h2>
                    <div class="content">
                        <?php echo $row1['about'];?>

                    </div><!--//content-->
                </div><!--//section-inner-->
            </section><!--//section-->

        </div><!--//primary-->
        <div class="secondary col-md-4 col-sm-12 col-xs-12">
            <aside class="info aside section">
                <div class="section-inner">
                    <h2 class="heading sr-only">Basic Information</h2>
                    <div class="content">
                        <ul class="list-unstyled">
                            <?php
                            if(!empty($row1['sex']))
                            {
                                if($row1['sex'] == "male")
                                {
                                    ?><li><i class="fa fa-mars"></i><span class="sr-only">Sex:</span>Male</li><?php
                                }
                                else{
                                    ?><li><i class="fa fa-venus"></i><span class="sr-only">Sex:</span>Female</li><?php
                                }
                            }
                            ?>


                            <li><i class="fa fa-birthday-cake"></i><span class="sr-only">DOB:</span><?php echo $row1['dob'];?></li>
                            <li><i class="fa fa-map-marker"></i><span class="sr-only">Location:</span><?php echo $row1['country'];?></li>
                            <li><i class="fa fa-envelope-o"></i><span class="sr-only">Email:</span><a href="#"><?php echo $row1['email'];?></a></li>
                            <li><i class="fa fa-skype"></i><span class="sr-only">Skype ID:</span><a href="#"><?php echo $row1['skype'];?></a></li>
                        </ul>
                    </div><!--//content-->
                </div><!--//section-inner-->
            </aside><!--//aside-->



        </div><!--//secondary-->
    </div><!--//row-->
</div><!--//masonry-->

<!-- ******FOOTER****** -->
<footer class="footer">
    <div class="container text-center">
        <!--/* This template is released under the Creative Commons Attribution 3.0 License. Please keep the attribution link below when using for your own project. Thank you for your support. :) If you'd like to use the template without the attribution, you can check out other license options via our website: themes.3rdwavemedia.com */-->
        <small class="copyright">Developed with <i class="fa fa-heart"></i> by <a href="http://www.byweb.online" target="_blank">Deven Katariya</a> for developers</small>
    </div><!--//container-->
</footer><!--//footer-->


<!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
<script>
    var siteurl = '<?php echo $config['site_url']; ?>';
    var session_uname = '<?php echo $sesUsername; ?>';
    var session_img = '<?php echo $ses_picname; ?>';
</script>

<!--ZeChat Box CSS-->
<link type="text/css" rel="stylesheet" media="all" href="app/includes/chatcss/chat.css" />
<!--ZeChat Box CSS-->

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- Media Uploader -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<!-- Zechat js -->
<script type="text/javascript" src="app/plugins/smiley/js/emojione.min.js"></script>
<script type="text/javascript" src="app/plugins/smiley/smiley.js"></script>
<script type="text/javascript" src="app/includes/chatjs/lightbox.js"></script>
<script type="text/javascript" src="app/includes/chatjs/chat.js"></script>
<script type="text/javascript" src="app/includes/chatjs/custom.js"></script>


<script type="text/javascript" src="app/plugins/uploader/plupload.full.min.js"></script>
<script type="text/javascript" src="app/plugins/uploader/jquery.ui.plupload/jquery.ui.plupload.js"></script>

<?php require_once('contact-list.php');?>


<!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->

<script>
    $(window).load(function() {
        $('.Dboot-preloader').addClass('hidden');
    });
</script>
</body>
</html>

