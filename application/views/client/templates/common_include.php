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
    <meta property="og:url" content="<?php echo current_url(); ?>" />
    <meta property="og:description" content="HerbertGraphy - Herbert Ho's photography showcase" />
    <meta property="og:title" content="HerbertGraphy<?php if (isset($title) && $title !=NULL) { echo " - ".$title;} ?>" />
    <?php if (isset($meta_tags)){
        $this->load->view($meta_tags);
    } ?>
    <meta name="twitter:description" content="HerbertGraphy - Herbert Ho's photography showcase" />
    <meta name="twitter:title" content="HerbertGraphy<?php if (isset($title) && $title !=NULL) { echo " - ".$title;} ?>" />
    <title>
        <?php if (ENVIRONMENT != "dev_cp") { ?>
            <?php if (isset($home_title) && $home_title !=NULL) { ?>
            HerbertGraphy<?php echo " - ".$home_title;?>
            <?php } else { ?>
            HerbertGraphy<?php if (isset($main_title) && $main_title !=NULL) { echo " - ".$main_title;} ?>
            <?php } ?>
        <?php } else {?>
            demo
        <?php } ?>
    </title>
    <!-- ICON -->
    <link href="<?php echo assets_image("apple-touch-icon.png"); ?>" rel="apple-touch-icon" />
    <link href="<?php echo assets_image("apple-touch-icon-76x76.png"); ?>" rel="apple-touch-icon" sizes="76x76" />
    <link href="<?php echo assets_image("apple-touch-icon-120x120.png"); ?>" rel="apple-touch-icon" sizes="120x120" />
    <link href="<?php echo assets_image("apple-touch-icon-152x152.png"); ?>" rel="apple-touch-icon" sizes="152x152" />
    <link href="<?php echo assets_image("apple-touch-icon-180x180.png"); ?>" rel="apple-touch-icon" sizes="180x180" />
    <link href="<?php echo assets_image("android-icon-192x192.png"); ?>" rel="icon" sizes="192x192" />
    <link href="<?php echo assets_image("android-icon-128x128.png"); ?>" rel="icon" sizes="128x128" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo css("client_main.css"); ?>" type="text/css" />
    <?php
        if (isset($css_includes))
        {
            foreach ($css_includes as $css_path)
            {
    ?>
                <link rel="stylesheet" href="<?php echo css($css_path); ?>" type="text/css"/>
    <?php   }
        }
    ?>

    <!-- FONT -->
    <link href='https://fonts.googleapis.com/css?family=Catamaran:400,700,300,200' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700" rel="stylesheet">
    <!-- Javascript -->
    <script>
        GLOBAL_SITE_URL = "<?php echo site_url(); ?>";
    </script>
    <script src="<?php echo js("client_main.js"); ?>"></script>
    <?php
        if (isset($js_includes))
        {
             foreach ($js_includes as $js_path)
             {
    ?>

            <script src="<?php echo js($js_path); ?>"></script>
    <?php
         }
    }
    ?>
</head>