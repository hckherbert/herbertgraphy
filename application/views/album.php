<?php 

	/*
	$albumLabel = $_GET["label"];
	
	$db="herbertgra_main";
	if ($_SERVER['SERVER_NAME'] == "www.herbertgraphy.com" || $_SERVER['SERVER_NAME'] == "herbertgraphy.com" )
	{
		$link = mysql_connect('localhost', 'herbertgra_main' , 'Zz363077');
	}
	
	else
	{
		$link = mysql_connect('localhost', 'root', '');
	}
	mysql_select_db($db , $link) or die("Select Error: ".mysql_error());
	if (! $link) die(mysql_error());
	
	$selectPhotoSql = "SELECT * FROM photos INNER JOIN album ON photos.albumId = album.id where album.label='$albumLabel' ORDER BY featured DESC ";
	$resultSelectPhoto=mysql_query($selectPhotoSql) or die("Insert Error: ".mysql_error());
	
	$albumData = mysql_fetch_assoc($resultSelectPhoto);
	$albmName  = $albumData['name'];
	$albumLabel = $albumData['label'];
	$albumIntro = $albumData['intro'];
	
	$selectAlbumSql = "SELECT * FROM album WHERE parentId IS NULL";
	$resultSelectAlbum=mysql_query($selectAlbumSql) or die("Insert Error: ".mysql_error());
	*/
	
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
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
<script src="<?php echo base_url("assets/js/jquery-1.11.3.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery-migrate-1.2.1.min.js"); ?>"></script>
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
		<h1>Ebook Test</h1>
		<div class="menuContainer mainMenuClose">
			<ul class="subMenus">
				<li class="active"><a href="javascript:void(0)">Sub-alubm 0</a></li>
				<li><a href="javascript:void(0)">Sub-alubm 1</a></li>
				<li><a href="javascript:void(0)">Sub-alubm 2</a></li>
				<li><a href="javascript:void(0)">Sub-alubm 3</a></li>
			</ul>
			<div class="menuHeading">Other album</div>
			<ul class="otherAlbumMenus">
				<li><a href="javascript:void(0)">Ohter Album 0</a></li>
				<li><a href="javascript:void(0)">Ohter Album 1</a></li>
				<li><a href="javascript:void(0)">Ohter Album 2</a></li>
				<li><a href="javascript:void(0)">Ohter Album 3</a></li>
				<li><a href="javascript:void(0)">Ohter Album 4</a></li>
			</ul>
			<ul class="menuLinks">
				<li><a href="javascript:void(0)">Links 0</a></li>
				<li><a href="javascript:void(0)">Links 1</a></li>
			</ul>
		</div>
		<a class="btnMenuToggle" href="javascript:void(0)"><img src="<?php echo base_url("assets/images/btnMenuToggle.png"); ?>"></a>
		<div class="intro">
			<p>The LRS is the heart of any Tin Can ecosystem, receiving, storing and returning data about learning experiences, achievements and job performance. You’ll need an LRS in order to do anything with Tin Can</p>
		</div>
	 </div>
	 <div class="gridPanel">

		<?php
		/*
		$rowCount = 0;
		while ($row = mysql_fetch_assoc($resultSelectPhoto)) { ?>
			
			<div class="grid" <?php if ($rowCount==0) { ?>data-highlight="true" <?php } ?> data-filename="photos/<?php echo $albumLabel; ?>/<?php echo $row['filename']; ?>">
				<img src="photos/<?php echo $albumLabel; ?>/thumb/<?php echo $row['filename']; ?>">
				<div class="titleOverlay">
					<div class="bg"></div>
					<div class="title"><?php echo $row['title']; ?></div>
					<span class="desc"><?php echo $row['desc']; ?></span>
				</div>
			</div>
		<?php  
		$rowCount++;
		}
		*/?>
		<div class="grid" data-highlight="true" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyHighlightH.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb1.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb2.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb3.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeV.jpg"><img src="<?php echo base_url("assets/images/dummyThumb4.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb5.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb6.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb7.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeV.jpg"><img src="<?php echo base_url("assets/images/dummyThumb8.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb9.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb10.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb11.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb12.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb13.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeV.jpg"><img src="<?php echo base_url("assets/images/dummyThumb14.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb15.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is a longer title two lines</div><span class="desc">This is description. It is longer. Do you see lines showing and display well?</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb16.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb17.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb18.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeV.jpg"><img src="<?php echo base_url("assets/images/dummyThumb19.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">Another lorem ipsum multilines, see it?</span></div></div>
		<div class="grid" data-filename="dummyLargeV.jpg"><img src="<?php echo base_url("assets/images/dummyThumb20.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeV.jpg"><img src="<?php echo base_url("assets/images/dummyThumb21.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb22.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb23.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeV.jpg"><img src="<?php echo base_url("assets/images/dummyThumb24.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeV.jpg"><img src="<?php echo base_url("assets/images/dummyThumb25.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb26.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb27.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb28.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
		<div class="grid" data-filename="dummyLargeH.jpg"><img src="<?php echo base_url("assets/images/dummyThumb29.jpg"); ?>"><div class="titleOverlay"><div class="bg"></div><div class="title">This is title</div><span class="desc">This is description.</span></div></div>
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
	var mWideScreenBreakPoint_num = 1680;
	var mIsReorderingWideScreen = false;

	$(document).ready
	(
		function()
		{
			mResponsive = new Responsive();
			mResponsive.init(["sMobile", "sDesktop"], [0, 768], mWideScreenBreakPoint_num);
			
			mPhotoOverlay = new PhotoOverlay($(".photoZoomOverlay"));
			
			mGridControl = new GridControl($(".gridPanel"), mPhotoOverlay);
			mGridControl.setAspectRatio(1.5);
			
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
				
				$(".infoPanel").css("height", $(window).height()+"px");
			 
			}
			
			$(".btnMenuToggle").on("click", toggleMenu);
			
			$(window).on("resize", windowOnResized);
			$(document).on("responsive", closeMenu);
		}
	);
	
	function windowOnResized()
	{
		mPhotoOverlay.centerPhoto();
		
		if ($(window).width()>=0 && $(window).width()<=768)
		{
			mGridControl.updateDensity("low");
		}
		else if ($(window).width()>768 && $(window).width()<=mWideScreenBreakPoint_num)
		{
			mGridControl.updateDensity("medium");
		}
		else
		{
			mGridControl.updateDensity("high");
		}
		
		mGridControl.positionGrids();
	}
	
	function toggleMenu()
	{
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