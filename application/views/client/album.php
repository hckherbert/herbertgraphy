<?php ?>
<body class="<?php echo $class_main_color; ?>">
<?php $this->load->partials("client/templates/partials/page_loading"); ?>
<?php $this->load->partials("client/templates/partials/simple_loading"); ?>
<div class="wrapper">
	<div class="wrapperAlbum">
		 <?php $this->load->partials("client/templates/menu_info_panel"); ?>
		 <div class="gridPanel">
			<?php foreach($current_album_data["photo_data"] as $photo){ ?>
				<div class="grid"
					 data-filename="../assets/photos/<?php echo $current_album_data["album_details"]->label; ?>/<?php echo $photo["hash_filename"]; ?>"
					 data-file_zoom_size="<?php echo $photo["file_zoom_size"]; ?>"
					 <?php if ($photo["featured"] == "1"){ ?>data-featured="true"<?php } ?>
				>
					<img src="../assets/photos/<?php echo $current_album_data["album_details"]->label; ?>/<?php echo $photo["file_thumb_path"]; ?>">
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
<script language="javascript">

	var mPhotoOverlay = null;
	var mGridControl = null;
	var mWinWidth = $(window).width();

	$(document).ready
	(
		function()
		{
			mPhotoOverlay = new PhotoOverlay($(".photoZoomOverlay"));
			mPhotoOverlay.initBreakPoints(mBaseBreakPoint_array, mWideScreenBreakPoint_num);
			mGridControl = new GridControl($(".gridPanel"), mPhotoOverlay);
			mGridControl.initBreakPoints(mBaseBreakPoint_array, mWideScreenBreakPoint_num);

			if ($("body").hasClass("sMobile"))
			{
				mGridControl.updateDensity("low");
			}
			else if ($("body").hasClass("sDesktop"))
			{
				if ($(window).width() >= mWideScreenBreakPoint_num)
				{
					mGridControl.updateDensity("high");
				}
				else
				{
					mGridControl.updateDensity("medium");
				}
			}

			$(".btnMenuToggle").on("click", toggleMenu);
			$(window).on("resize", windowOnResized);
		}
	);
	
	function windowOnResized()
	{
		mPhotoOverlay.centerPhoto();

		//on tablets, scrolling will trigger resize events.. so
		//check window width has actually changed and it's not just iOS triggering a resize event on scroll

		if ($(window).width() != mWinWidth) {

			// Update the window width for next time
			mWinWidth = $(window).width();

			if (mWinWidth >= 0 && mWinWidth <= mBaseBreakPoint_array[1])
			{
				mGridControl.updateDensity("low");
				$(".menuContainer").removeClass("menuTransition");
				$(".albumTitle").css("height", $(".albumTitle h1").outerHeight() + "px");
				$(".menuContainer").css("top", $(".albumTitle").height() + "px");
				$(".infoPanel").css("height", "auto");
			}
			else if (mWinWidth > mBaseBreakPoint_array[1] && mWinWidth <= mWideScreenBreakPoint_num)
			{
				mGridControl.updateDensity("medium");
				$(".albumTitle").css("height", "auto");
			}
			else
			{
				mGridControl.updateDensity("high");
				$(".albumTitle").css("height", "auto");
			}
		}
		else
		{
			mGridControl.updateDensity("medium");
			$(".albumTitle").css("height", "auto");
		}


		mGridControl.positionGrids();

	}
	
</script>
</html>