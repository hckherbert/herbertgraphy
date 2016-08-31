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
    <title>HerbertGraphy Admin Control - Album List</title>
    <!-- ICON -->
    <link href="<?php echo base_url("assets/images/apple-touch-icon.png"); ?>" rel="apple-touch-icon" />
    <link href="<?php echo base_url("assets/images/apple-touch-icon-76x76.png"); ?>" rel="apple-touch-icon" sizes="76x76" />
    <link href="<?php echo base_url("assets/images/apple-touch-icon-120x120.png"); ?>" rel="apple-touch-icon" sizes="120x120" />
    <link href="<?php echo base_url("assets/images/apple-touch-icon-152x152.png"); ?>" rel="apple-touch-icon" sizes="152x152" />
    <link href="<?php echo base_url("assets/images/apple-touch-icon-180x180.png"); ?>" rel="apple-touch-icon" sizes="180x180" />
    <link href="<?php echo base_url("assets/images/android-icon-192x192.png"); ?>" rel="icon" sizes="192x192" />
    <link href="<?php echo base_url("assets/images/android-icon-128x128.png"); ?>" rel="icon" sizes="128x128" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.jscrollpane.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/uploadifive.css'); ?>"  type="text/css" >
    <link rel="stylesheet" href="<?php echo base_url('assets/css/reset.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/zindex.css'); ?>" type="text/css" />
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
    <script src="<?php echo base_url('assets/js/jquery-3.1.0.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-migrate-3.0.0.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.jscrollpane.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.mousewheel.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/album_control/jquery.uploadifive.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/album_control/OriginalPhotoData.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/album_control/Album_control.js'); ?>"></script>
</head>