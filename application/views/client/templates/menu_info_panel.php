<div class="infoPanel">
    <div class="menuMask"></div>
    <div class="albumTitle bgBrown"><h1 class="bgBrown"><?php if (isset($current_album_data)) {echo $current_album_data["album_details"]->name;} ?></h1><a class="btnMenuToggle" href="javascript:void(0)"><img src="<?php echo base_url("assets/images/btnMenuToggle.png"); ?>"></a></div>
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
        <ul class="menuLinks">
            <li><a href="javascript:void(0)">Why <em>Herbertgraphy</em></a></li>
            <li><a href="javascript:void(0)">Herbertbloggy</a></li>
        </ul>
    </div>
    <?php if (isset($current_album_data["album_details"]->intro) && $current_album_data["album_details"]->intro!=NULL) { ?>
        <div class="intro">
            <p><?php echo $current_album_data["album_details"]->intro; ?></p>
        </div>
    <?php } ?>
    <div class="clear"></div>
</div>