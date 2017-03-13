<div class="infoPanel">
    <div class="menuMask"></div>
    <div class="albumTitle <?php echo $class_main_color; ?>">
        <h1>
            <?php if (isset($current_album_data) && $current_album_data!=NULL) {echo $current_album_data["album_details"]->name;} else ?>
            <?php if (isset($main_title) && $main_title !=NULL) { echo $main_title; } ?>
        </h1>
        <a class="btnMenuToggle hvr-grow-rotate" href="javascript:void(0)"><img src="<?php echo assets_image("btnMenuToggle.png"); ?>"></a>
    </div>
    <div class="menuContainer mainMenuClose">
        <?php if (isset($subalbum_data) && $subalbum_data!=NULL) { ?>
            <ul class="subAlbumMenus">
                <?php foreach ($subalbum_data as $subalbum) { ?>
                    <li>
                        <a href="<?php echo $subalbum["label"]; ?>" <?php if ($subalbum["label"] == $current_album_data["album_details"]->label) { ?>class="active"<?php } ?>>
                            - <?php echo $subalbum["name"]?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if (isset($all_other_albums_data) && $all_other_albums_data!=NULL) { ?>
            <ul class="otherAlbumMenus">
                <?php foreach ($all_other_albums_data as $other_albums) { ?>
                    <li <?php if ($other_albums["siblings"]!==NULL) { ?> class="parent" <?php } ?>>
                        <a href="<?php echo $other_albums["label"]; ?>"><?php echo $other_albums["name"]?>
                        </a>
                    </li>
                    <?php if ($other_albums["siblings"]!==NULL) { ?>
                        <?php foreach ($other_albums["siblings"] as $sibling) { ?>
                            <li class="siblings<?php if (end($other_albums["siblings"]) == $sibling) {?> last<?php } ?><?php if ($sibling["name"] == $current_album_data["album_details"]->name) {?> current<?php } ?>">
                                <a href="<?php echo $sibling["label"]; ?>">- <?php echo $sibling["name"]?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php }?>
                <?php } ?>
            </ul>
        <?php } ?>
        <?php if (isset($all_parent_albums) && $all_parent_albums!=NULL) { ?>
            <ul class="otherAlbumMenus">
            <?php foreach ($all_parent_albums as $album) { ?>
                <li>
                    <a href="album/<?php echo $album["label"]; ?>"><?php echo $album["name"]?>
                    </a>
                </li>
            <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <?php if (isset($current_album_data["album_details"]->intro) && $current_album_data["album_details"]->intro!=NULL) { ?>
        <div class="intro">
            <p><?php echo $current_album_data["album_details"]->intro; ?></p>
        </div>
    <?php } ?>
    <div id="home_canvas"><img src="assets/images/canvas.png"></div>
    <div class="clear"></div>
</div>