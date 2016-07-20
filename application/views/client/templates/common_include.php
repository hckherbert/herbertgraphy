<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title></title>
    <!-- ICON -->
    <link href="apple-touch-icon.png" rel="apple-touch-icon" />
    <link href="apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
    <link href="apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
    <link href="apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
    <link href="apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="android-icon-192x192.png" rel="icon" sizes="192x192" />
    <link href="android-icon-128x128.png" rel="icon" sizes="128x128" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/reset.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/zindex.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/page_loading.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/jquery.jscrollpane.css"); ?>" type="text/css" />
    <!-- FONT -->
    <link href='https://fonts.googleapis.com/css?family=Catamaran:400,700,300,200' rel='stylesheet' type='text/css'>
    <!-- Javascript -->
    <?php if (get_instance()->agent->browser() == "Internet Explorer" && intval(get_instance()->agent->version()) == 8) { ?>
        <script src="<?php echo base_url("assets/js/jquery-1.12.3.min.js"); ?>"></script>
    <?php } else { ?>
        <script src="<?php echo base_url("assets/js/jquery-3.1.0.min.js"); ?>"></script>
    <?php } ?>
    <script src="<?php echo base_url("assets/js/jquery-migrate-3.0.0.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/jquery.jscrollpane.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/jquery.mousewheel.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/greensock-js/TweenMax.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/greensock-js/TimelineLite.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/Responsive.js"); ?>"></script>
</head>