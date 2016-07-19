<?php ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="">
<meta name="keywords" content="">
<title></title>
<!-- ICON -->
<link href="apple-touch-icon.png" rel="apple-touch-icon" />
<link href="apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
<link href="apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
<link href="apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
<link href="apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />
<link href="android-icon-192x192.png" rel="icon" sizes="192x192" />
<link href="android-icon-128x128.png" rel="icon" sizes="128x128" />
<!-- CSS -->
<link rel="stylesheet" href="<?php echo base_url("assets/css/reset.css"); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url("assets/css/zindex.css"); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url("assets/css/main.css"); ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url("assets/css/jquery.jscrollpane.css"); ?>" type="text/css" />
<!-- FONT -->
<link href='https://fonts.googleapis.com/css?family=Catamaran:400,700,300,200' rel='stylesheet' type='text/css'>
<!-- Javascript -->
<?php if (get_instance()->agent->browser() == "Internet Explorer" && intval(get_instance()->agent->version()) == 8) { ?>
<script src="<?php echo base_url("assets/js/jquery-1.12.3.min.js"); ?>"></script>
<?php } else { ?>
<script src="<?php echo base_url("assets/js/jquery-3.1.0.min.js"); ?>"></script>
<?php } ?>
<script src="<?php echo base_url("assets/js/jquery-migrate-3.0.0.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery.jscrollpane.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery.mousewheel.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/greensock-js/TweenMax.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/greensock-js/TimelineLite.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/Responsive.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/PhotoOverlay.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/GridControl.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/Grid.js"); ?>"></script>

</head>
<body class="bgBrown">
<div class="wrapper wrapperAlbum">
	 <div class="infoPanel">
		<div class="menuMask"></div>
		 <div class="albumTitle bgBrown"><h1 class="bgBrown"><?php echo $current_album_data["album_details"]->name; ?></h1><a class="btnMenuToggle" href="javascript:void(0)"><img src="<?php echo base_url("assets/images/btnMenuToggle.png"); ?>"></a></div>
		<div class="menuContainer mainMenuClose">
			<?php if ($subalbum_data) { ?>
			<ul class="subAlbumMenus">
				<?php foreach ($subalbum_data as $subalbum) { ?>
					<li>
						<a href="<?php echo $subalbum["label"]; ?>" <?php if ($subalbum["label"] == $current_album_data["album_details"]->label) { ?>class="active"<?php } ?>>
						- <?php echo $subalbum["name"]?>
						</a>
					</li>
				<?php } ?>
			</ul>
			<?php } ?>
			<?php if ($all_other_albums_data) { ?>
			<ul class="otherAlbumMenus">
				<?php foreach ($all_other_albums_data as $other_albums) { ?>
					<li <?php if ($other_albums["siblings"]!==NULL) { ?> class="parent" <?php } ?>>
						<a href="<?php echo $other_albums["label"]; ?>"><?php echo $other_albums["name"]?>
						</a>
					</li>
					<?php if ($other_albums["siblings"]!==NULL) { ?>
						<?php foreach ($other_albums["siblings"] as $sibling) { ?>
						<li class="siblings<?php if (end($other_albums["siblings"]) == $sibling) {?> last<?php } ?><?php if ($sibling["name"] == $current_album_data["album_details"]->name) {?> current<?php } ?>">
							<a href="<?php echo $sibling["label"]; ?>">- <?php echo $sibling["name"]?>
							</a>
						</li>	
						<?php } ?>
					<?php }?>
				<?php } ?>
			</ul>
			<?php } ?>
			<ul class="menuLinks">
				<li><a href="javascript:void(0)">Why <em>Herbertgraphy</em></a></li>
				<li><a href="javascript:void(0)">Herbertbloggy</a></li>
			</ul>
		</div>
		<?php if ($current_album_data["album_details"]->intro) { ?>
		<div class="intro">
			<p><?php echo $current_album_data["album_details"]->intro; ?></p>
		</div>
		<?php } ?>
		<div class="clear"></div>
	 </div>
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
			mPhotoOverlay = new PhotoOverlay($(".photoZoomOverlay"));
			mGridControl = new GridControl($(".gridPanel"), mPhotoOverlay);

			
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