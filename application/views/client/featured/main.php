<div class="featuredContainer <?php echo $class_main_color; ?>">
    <div class="featuredList">
        <?php foreach ($image_list_data as $key=>$image_data) { ?>
            <img data-width="<?php echo $image_data["width"]; ?>" data-height="<?php echo $image_data["height"]; ?>" src="<?php echo base_url("assets/images/featured/".$key.".jpg"); ?>">
        <?php } ?>
    </div>
    <div class="navigator">
        <a class="btn_prev" href="javascript:void(0)"><span><</span></a>
        <a class="btn_next" href="javascript:void(0)"><span>></span></a>
    </div>
</div>