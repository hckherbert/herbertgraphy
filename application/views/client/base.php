<?php ?>
<body class="bgBrown">
<?php $this->load->partials("client/templates/partials/page_loading"); ?>
<?php $this->load->partials("client/templates/partials/simple_loading"); ?>
<div class="wrapper">
	<div class="wrapperAlbum">
	<?php $this->load->partials("client/templates/menu_info_panel"); ?>
	<div class="gridPanel">
		<img src="<?php echo base_url("assets/test/sopot.jpg"); ?>" style="position:absolute;top:0;left:0;height:100%;">
		<p class="text_404">Oops! Herbert hasn't got related photographs</p>

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
<script language="javascript">
	
	var mResponsive = null;
	var mPhotoOverlay = null;
	var mGridControl = null;
	var mBaseBreakPoint_array  = [0,768];
	var mWideScreenBreakPoint_num = 1680;
	var mIsReorderingWideScreen = false;

	$(document).ready
	(
		function()
		{
			mResponsive = new Responsive();
			mResponsive.init(["sMobile", "sDesktop"], mBaseBreakPoint_array, mWideScreenBreakPoint_num);
			//mPhotoOverlay = new PhotoOverlay($(".photoZoomOverlay"));
			//mGridControl = new GridControl($(".gridPanel"), mPhotoOverlay);

			/*
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
			*/

			$(".btnMenuToggle").on("click", toggleMenu);
			//$(window).on("resize", windowOnResized);
			$(document).on("responsive", closeMenu);

			$(".pageLoading").remove();
			$(".wrapperAlbum").addClass("show");
			$(".wrapperAlbum").css("height", $(window).height() + "px");
			$(".infoPanel, .gridPanel").css("height", "100%");
			$(".infoPanel h1").text("Herbertgraphy");
			$(".gridPanel").css("background", "#eee0c4");
		}
	);
	
	function windowOnResized()
	{

		/*
		mPhotoOverlay.centerPhoto();

		if ($(window).width()>=0 && $(window).width()<=mBaseBreakPoint_array[1])
		{
			mGridControl.updateDensity("low");
			$(".menuContainer").removeClass("menuTransition");
			$(".albumTitle").css("height", $(".albumTitle h1").outerHeight() + "px");
			$(".menuContainer").css("top", $(".albumTitle").height() + "px");
		}
		else if ($(window).width()>mBaseBreakPoint_array[1] && $(window).width()<=mWideScreenBreakPoint_num)
		{
			mGridControl.updateDensity("medium");
			$(".albumTitle").css("height", "auto");
		}
		else
		{
			mGridControl.updateDensity("high");
			$(".albumTitle").css("height", "auto");
		}

		mGridControl.positionGrids();
		*/
	}
	
	function toggleMenu(pEvent)
	{
		pEvent.preventDefault();

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