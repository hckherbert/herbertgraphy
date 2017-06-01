<?php $timestamp = time();?>
<?php $token = md5("unique_salt" . $timestamp);?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>
        <?php if (ENVIRONMENT != "dev_cp") { ?>
        HerbertGraphy Admin Control - Album List
        <?php } else {?>
        Admin control demo
        <?php } ?>
    </title>
    <!-- ICON -->
    <link href="<?php echo assets_image("apple-touch-icon.png", false); ?>" rel="apple-touch-icon" />
    <link href="<?php echo assets_image("apple-touch-icon-76x76.png", false); ?>" rel="apple-touch-icon" sizes="76x76" />
    <link href="<?php echo assets_image("apple-touch-icon-120x120.png", false); ?>" rel="apple-touch-icon" sizes="120x120" />
    <link href="<?php echo assets_image("apple-touch-icon-152x152.png", false); ?>" rel="apple-touch-icon" sizes="152x152" />
    <link href="<?php echo assets_image("apple-touch-icon-180x180.png", false); ?>" rel="apple-touch-icon" sizes="180x180" />
    <link href="<?php echo assets_image("android-icon-192x192.png", false); ?>" rel="icon" sizes="192x192" />
    <link href="<?php echo assets_image("android-icon-128x128.png", false); ?>" rel="icon" sizes="128x128" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo css("admin_main.css"); ?>"  type="text/css" >
    <!-- FONT -->
    <link href='https://fonts.googleapis.com/css?family=Catamaran:400,700,300,200' rel='stylesheet' type='text/css'>
    <!-- Javascript -->
    <script>
        GLOBAL_SITE_URL = "<?php echo site_url(); ?>";
        CONFIG_FILE_SIZE_LIMIT = "<?php echo $this->config->item("photo_upload_file_size_limit"); ?>";
        CONFIG_FILE_NAME_REGEX = "<?php echo $this->config->item("photo_file_name_regex"); ?>";
        var mTimeStamp = "<?php echo $timestamp;?>";
        var mToken = "<?php echo md5('unique_salt' . $timestamp);?>";
    </script>
    <script src="<?php echo js("admin_main.js"); ?>"></script>
</head>