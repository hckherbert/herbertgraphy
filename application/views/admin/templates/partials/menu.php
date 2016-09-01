<?php if (isset($is_invalid_user) && $is_invalid_user == true) { ?>
    <p>Invalid user. Please verify the credentials. Attempt again <a href="<?php echo base_url("admin/album_control/logout"); ?>">here</a>.</p>
<?php } else if (isset($authUrl)) { ?>
    <p>Please <a href="<?php echo $authUrl; ?>">sign in</a> to continue.</p>
<?php } else { ?>
<div class="adminHeader">
    <a class='menu_link' href='<?php echo base_url("admin/album_control/logout"); ?>'>Logout</a>
    <?php if (isset($album_details) && $album_details) { ?>
        <a class="menu_link" href="<?php echo site_url("admin/album_control"); ?>">Back to album list</a>
    <?php if ($album_details->parentId !== NULL) { ?>
        <a class="menu_link" href="<?php echo site_url("admin/album_control/album_details/$album_details->parentId"); ?>">Back to parent album (<?php echo $album_details->parentName; ?>)</a>
    <?php } ?>
    <?php } ?>
</div>
<div class="section">
    <h1 class="pageHeading">Admin account info</h1>
    <?php
    echo "<p><b> First Name : </b>" . $userData->given_name . "</p>";
    echo "<p><b> Last Name : </b>" . $userData->family_name . "</p>";
    echo "<p><b>Email : </b>" . $userData->email . "</p>";
    ?>
</div>
<?php } ?>
