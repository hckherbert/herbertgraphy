<?php ?>
<div class="footer<?php if (isset($is_base) && $is_base == true){ ?>  show<?php }?>">
    <div class="footerMenuWrapper">
        <a id="btn_home" class="hvr-pop"  href="<?php echo base_url(); ?>" title="Home"></a>
        <a id="btn_about_her" class="hvr-pop"  href="<?php echo base_url("bio"); ?>" title="Bio"></a>
        <a id="btn_texts" class="hvr-pop"  href="<?php echo base_url("texts"); ?>" title="Texts"></a>
    </div>
    <div class="bg"></div>
    <div class="text">&copy; <?php echo date("Y"); ?> HerbertGraphy</div>
</div>