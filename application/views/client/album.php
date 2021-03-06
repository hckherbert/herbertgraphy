<?php ?>

<body
	class="<?php echo $class_main_color; ?>"
	<?php if (isset($direct_photo_slug) && $direct_photo_slug!=NULL) { ?>
		data-direct_photo_slug = "<?php echo $direct_photo_slug; ?>"
	<?php } ?>
	data-album_path = "<?php echo $album_path; ?>"
	data-aspect_ratio = "<?php echo $current_album_data["album_details"]->aspect_ratio; ?>"
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
					 data-width = "<?php echo $photo["width"]; ?>"
					 data-height = "<?php echo $photo["height"]; ?>"
					 <?php if ($photo["featured"] == "1"){ ?>data-featured="true"<?php } ?>
					 <?php if ($photo["highlighted"] == "1"){ ?>data-highlighted="true"<?php } ?>
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
		<a class="btnClose hvr-grow" href="javascript:void(0)"></a>
	</div>
</div>
</body>
</html>