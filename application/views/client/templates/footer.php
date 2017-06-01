<?php ?>
<div class="footer<?php if (isset($is_base) && $is_base == true){ ?>  show<?php }?>">
    <div class="footerMenuWrapper">
        <a id="btn_home" class="hvr-pop"  href="<?php echo base_url(); ?>" title="Home"></a>
        <a id="btn_about_her" class="hvr-pop"  href="<?php echo base_url("about"); ?>" title="What's HerbertGraphy"></a>
    </div>
    <div class="bg"></div>
    <div class="text">&copy; <?php echo date("Y"); ?> HerbertGraphy</div>
</div>