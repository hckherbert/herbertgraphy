<?php ?>
<body class="bgBrown">
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
	
	var mResponsive = null;
	var mPhotoOverlay = null;
	var mGridControl = null;
	var mBaseBreakPoint_array  = [0,768];
	var mWideScreenBreakPoint_num = 1680;
	var mIsReorderingWideScreen = false;
	var mWinWidth = $(window).width();

	$(document).ready
	(
		function()
		{
			var windowWidth = $(window).width(),
			mResponsive = new Responsive();
			mResponsive.init(["sMobile", "sDesktop"], mBaseBreakPoint_array, mWideScreenBreakPoint_num);
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
			$(document).on("responsive", closeMenu);

		}
	);
	
	function windowOnResized()
	{
		mPhotoOverlay.centerPhoto();


		if ($(window).width() != windowWidth) {

			// Update the window width for next time
			mWinWidth = $(window).width();
		}
		else
		{
			if ($(window).width() >= 0 && $(window).width() <= mBaseBreakPoint_array[1])
			{
				mGridControl.updateDensity("low");
				$(".menuContainer").removeClass("menuTransition");
				$(".albumTitle").css("height", $(".albumTitle h1").outerHeight() + "px");
				$(".menuContainer").css("top", $(".albumTitle").height() + "px");
				$(".infoPanel").css("height", "auto");
			}
			else if ($(window).width() > mBaseBreakPoint_array[1] && $(window).width() <= mWideScreenBreakPoint_num)
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
		mGridControl.positionGrids();
	}
	
	function toggleMenu(pEvent)
	{
		pEvent.preventDefault();
		$(".btnMenuToggle").toggleClass("btnMenuToggleRotate");

		$(".menuContainer").addClass("menuTransition");
		$(".albumTitle").css("height", $(".albumTitle h1").outerHeight() + "px");
		$(".menuContainer").css("top", $(".albumTitle").height() + "px");

		$(".menuContainer").toggleClass("mainMenuClose");
		$(".menuMask").toggleClass("show");
	}
	
	function closeMenu()
	{
		$(".menuContainer").addClass("mainMenuClose");
		$(".menuMask").removeClass("show");
	}
</script>
</html>