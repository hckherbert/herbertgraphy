<?php ?>
<body class="bgBrown">
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
<div class="photoZoomOverlay">
	<div class="bg"></div>
	<div class="photoContainer">
		<!--<img class="photo" src="images/dummyLargeH.jpg">-->
		<div class="descContainer">
			<div class="bg"></div>
			<span class="desc"></span>
		</div>
		<a class="btnClose" href="javascript:void(0)"></a>
	</div>
</div>
</body>
</html>