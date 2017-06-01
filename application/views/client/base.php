<body class="<?php echo $class_main_color; ?> <?php if (isset($section) && $section==="section_about") { echo "vScrollOff"; } ?>">
<?php $this->load->partials("client/templates/analyticstracking"); ?>
<?php $this->load->partials("client/templates/partials/page_loading"); ?>
<?php $this->load->partials("client/templates/partials/simple_loading"); ?>
<div class="wrapper">
	<div class="wrapperBase<?php if (isset($section)) {echo " ".$section; } ?>">
	<?php $this->load->partials("client/templates/menu_info_panel"); ?>
	<div class="mainPanel bgBase">
		<?php if (isset($main_content_path)) { ?>
		<?php $this->load->partials($main_content_path); ?>
		<?php } ?>
	</div>
</div>
</body>
</html>