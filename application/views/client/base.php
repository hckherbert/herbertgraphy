<body class="bgBrown">
<?php $this->load->partials("client/templates/partials/page_loading"); ?>
<?php $this->load->partials("client/templates/partials/simple_loading"); ?>
<div class="wrapper">
	<div class="wrapperBase">
	<?php $this->load->partials("client/templates/menu_info_panel"); ?>
	<div class="mainPanel">
		<?php if (isset($main_content_path)) { ?>
		<?php $this->load->partials($main_content_path); ?>
		<?php } ?>
	</div>
</div>
</body>
<script>
	$(window).load(function()
	{
		$(".pageLoading").hide();
	})
</script>
</html>