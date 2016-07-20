<div class="adminHeader">
    <a class="menu_link" href="<?php echo site_url("admin/album_control"); ?>">Back to album list</a>
    <?php if ($album_details->parentId !== NULL) { ?>
        <a class="menu_link" href="<?php echo site_url("admin/album_control/album_details/$album_details->parentId"); ?>">Back to parent album (<?php echo $album_details->parentName; ?>)</a>
    <?php } else { ?>
        <!--<a class="menu_link" href="<?php echo site_url("admin/album_control/album_details/$album_details->id"); ?>">Back to parent album (<?php echo $album_details->name; ?>)</a>-->
    <?php } ?>
</div>

