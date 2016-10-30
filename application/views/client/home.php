<?php ?>
<body class="bgBrown">
<?php $this->load->partials("client/templates/analyticstracking"); ?>
<?php $this->load->partials("client/templates/partials/page_loading"); ?>
<?php $this->load->partials("client/templates/partials/simple_loading"); ?>
<div class="wrapper">
	<div class="wrapperBase">
		<?php $this->load->partials("client/templates/menu_info_panel"); ?>
		<div class="mainPanel">
			<img id="cover" src="<?php echo base_url("assets/test/sopot.jpg"); ?>" style="position:absolute;top:0;left:0;width:100%;">
		</div>
	</div>
</div>
</body>
</html>