<!DOCTYPE html>
<html>
<head>
    <?php
     if (isset($current_album_data) && $current_album_data!=NULL)
     {
         $title =  $current_album_data["album_details"]->name;
     }
     else if (isset($main_title) && $main_title !=NULL)
     {
         $title =  $main_title;
     }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="description" content="HerbertGraphy - Herbert Ho's photography showcase">
    <meta name="keywords" content="HerbertGraphy<?php  if (isset($title) && $title !=NULL) { echo " - ".$title;} ?>">
    <meta property="og:url" content="<?php echo site_url(); ?>" />
    <meta property="og:description" content="HerbertGraphy - Herbert Ho's photography showcase" />
    <meta property="og:title" content="HerbertGraphy<?php if (isset($title) && $title !=NULL) { echo " - ".$title;} ?>" />
    <meta name="twitter:description" content="HerbertGraphy - Herbert Ho's photography showcase" />
    <meta name="twitter:title" content="HerbertGraphy<?php if (isset($title) && $title !=NULL) { echo " - ".$title;} ?>" />
    <?php if (isset($meta_tags)){
        $this->load->view($meta_tags);
    } ?>
    <title>HerbertGraphy<?php if (isset($main_title) && $main_title !=NULL) { echo " - ".$main_title;} ?></title>
    <!-- ICON -->
    <link href="<?php echo base_url("assets/images/apple-touch-icon.png"); ?>" rel="apple-touch-icon" />
    <link href="<?php echo base_url("assets/images/apple-touch-icon-76x76.png"); ?>" rel="apple-touch-icon" sizes="76x76" />
    <link href="<?php echo base_url("assets/images/apple-touch-icon-120x120.png"); ?>" rel="apple-touch-icon" sizes="120x120" />
    <link href="<?php echo base_url("assets/images/apple-touch-icon-152x152.png"); ?>" rel="apple-touch-icon" sizes="152x152" />
    <link href="<?php echo base_url("assets/images/apple-touch-icon-180x180.png"); ?>" rel="apple-touch-icon" sizes="180x180" />
    <link href="<?php echo base_url("assets/images/android-icon-192x192.png"); ?>" rel="icon" sizes="192x192" />
    <link href="<?php echo base_url("assets/images/android-icon-128x128.png"); ?>" rel="icon" sizes="128x128" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/reset.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/zindex.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/page_loading.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css"); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/jquery.jscrollpane.css"); ?>" type="text/css" />
    <?php
        if (isset($css_includes))
        {
            foreach ($css_includes as $css_path)
            {
    ?>
                <link rel="stylesheet" href="<?php echo base_url("assets/css/" . $css_path); ?>" type="text/css"/>
    <?php   }
        }
    ?>

    <!-- FONT -->
    <link href='https://fonts.googleapis.com/css?family=Catamaran:400,700,300,200' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700" rel="stylesheet">
    <!-- Javascript -->
    <script src="<?php echo base_url("assets/js/jquery-3.1.0.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/jquery-migrate-3.0.0.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/jquery.jscrollpane.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/jquery.mousewheel.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/greensock-js/TweenMax.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/greensock-js/TimelineLite.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/Responsive.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/common.js"); ?>"></script>
    <?php
        if (isset($js_includes))
        {
             foreach ($js_includes as $js_path)
             {
    ?>

            <script src="<?php echo base_url("assets/js/".$js_path); ?>"></script>
    <?php
         }
    }
    ?>
</head>