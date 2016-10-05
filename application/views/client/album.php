<?php ?>
<body
	class="<?php echo $class_main_color; ?>"
	<?php if (isset($direct_photo_slug) && $direct_photo_slug!=NULL) { ?>
		data-direct_photo_slug = "<?php echo $direct_photo_slug; ?>"
		data-album_path = "<?php echo $album_path; ?>"
	<?php } ?>
>
<?php $this->load->partials("client/templates/analyticstracking"); ?>
<?php $this->load->partials("client/templates/partials/page_loading"); ?>
<?php $this->load->partials("client/templates/partials/simple_loading"); ?>
<div class="wrapper">
	<div class="wrapperAlbum">
		 <?php $this->load->partials("client/templates/menu_info_panel"); ?>
		 <div class="gridPanel">
			<?php foreach($current_album_data["photo_data"] as $photo){ ?>
				<div class="grid"
					 data-filename = "<?php echo base_url("assets/photos/".$current_album_data["album_details"]->label."/".$photo["hash_filename"]); ?>"
					 data-file_zoom_size = "<?php echo $photo["file_zoom_size"]; ?>"
					 data-slug = "<?php echo $photo["slug_filename"]; ?>"
					 <?php if ($photo["featured"] == "1"){ ?>data-featured="true"<?php } ?>
				>
					<img src="<?php echo base_url("assets/photos/".$current_album_data["album_details"]->label); ?>/<?php echo $photo["file_thumb_path"]; ?>">
					<div class="titleOverlay">
						<div class="bg"></div>
						<div class="title"><?php echo $photo['title']; ?></div>
						<span class="desc"><?php echo $photo['desc']; ?></span>
					</div>
				</div>
			<?php } ?>
		 </div>
	</div>
</div>
<div class="photoZoomOverlay">
	<div class="bg"></div>
	<div class="photoContainer">	
		<!--<img class="photo" src="images/dummyLargeH.jpg">-->
		<div class="descContainer">
			<div class="bg"></div>
			<span class="title"></span>
			<span class="desc"></span>
			<div class="clear"></div>
		</div>
		<a class="btnClose" href="javascript:void(0)"></a>
	</div>
</div>
</body>
</html>