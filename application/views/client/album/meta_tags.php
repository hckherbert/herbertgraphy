<?php if (isset($direct_photo_path) && $direct_photo_path!=NULL) { ?>
    <meta property="og:image" content="<?php echo $direct_photo_path; ?>" />
<?php } else if (isset($featured_photo) && $featured_photo!=NULL) { ?>
    <meta property="og:image" content="<?php echo $featured_photo; ?>" />
<?php } ?>
<meta property="og:image:width" content="1280" />
<meta property="og:image:height" content="850" />
