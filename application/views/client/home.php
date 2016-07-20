<?php 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" class="vScrollOn">
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
<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/zindex.css" type="text/css" />
<link rel="stylesheet" href="css/main.css" type="text/css" />
<link rel="stylesheet" href="css/jquery.jscrollpane.css" type="text/css" />
<!-- FONT -->
<link href='https://fonts.googleapis.com/css?family=Josefin+Sans:400,300,700,400italic' rel='stylesheet' type='text/css'>
<!-- Javascript -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="js/greensock-js/TweenMax.min.js"></script>
<script type="text/javascript" src="js/greensock-js/TimelineLite.min.js"></script>
<script type="text/javascript" src="js/Responsive.js"></script>
</head>
<body>
<div class="wrapper wrapperHome">
	<div class="header">
		<img class="sMobile banner" src="images/header_750.jpg">
		<img class="sDesktop banner" src="images/header_1920.jpg">
	</div>
	<div class="claer"></div>
	<div class="homeGridContainer">
		<div class="grid" id="grid0">
			<img class="gridCover" src="images/homeGrid0_768.jpg">
			<div style="position:absolute; font-size:12px;">Travel</div>
		</div>
		<div class="grid" id="grid1">
			<img class="gridCover" src="images/homeGrid1_768.jpg">
			<div style="position:absolute; font-size:12px;">Sunset</div>
		</div>
		<div class="grid" id="grid2">
			<img class="gridCover" src="images/homeGrid2_768.jpg">
			<div style="position:absolute; font-size:12px;">Portrait</div>
		</div>
		<div class="grid" id="grid3">
			<div class="grid" id="grid3a">Collections</div>
			<div class="grid" id="grid3b">Lego</div>
			<div class="clear"></div>
			<div class="grid" id="grid3c">Misc</div>
			<div class="grid" id="grid3d">Themes</div>
			<div class="claer"></div>
		</div>
	</div>
	<div class="claer"></div>
	<div class="sectionInfoTop">
		<div class="boxAbout">About
		</div><!--
	 --><div class="boxBlog">Blog
		</div><!-- 
	 --><div class="boxEvents">Events
		</div>
	</div>
	<div class="claer"></div>
	<div class="sectionInfoBottom">
		<div class="boxFeaturedPhoto">Featured foto
		</div><!-- 
	 --><div class="boxContact">Ask Her
		</div>
	</div>
</div>
</body>
<script language="javascript">
	
	var mResponsive = null;

	$(document).ready
	(
		function()
		{
			mResponsive = new Responsive();
			mResponsive.init(["sMobile", "sDesktop"], [0, 768], 1680);
			$(document).on("responsive", onResponsive);
		}
	);
	
	function onResponsive(pEvent)
	{
		 
	}
</script>
</html>