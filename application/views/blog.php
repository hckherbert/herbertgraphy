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
<link href='https://fonts.googleapis.com/css?family=Catamaran:400,700,300,200' rel='stylesheet' type='text/css'>
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
<div class="wrapper wrapperBlog">
	 <div class="infoPanel">
		<div class="menuMask"></div>
		<h1>Title</h1>
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
		<a class="btnMenuToggle" href="javascript:void(0)"><img src="images/btnMenuToggle.png"></a>
	 </div>
	 <div class="blogContainer">	
		
	</div>
</body>
<script language="javascript">
	
	var mResponsive = null;
	var mPhotoOverlay = null;
	var mGridControl = null;
	var mWideScreenBreakPoint_num = 1680;
	var mIsReorderingWideScreen = false;
	var mPageCounter = 1;

	$(document).ready
	(
		function()
		{
			mResponsive = new Responsive();
			mResponsive.init(["sMobile", "sDesktop"], [0, 768], mWideScreenBreakPoint_num);
			
			connectWp(1);
			windowOnResized();
			
			$(".btnMenuToggle").on("click", toggleMenu);
			$(window).on("resize", windowOnResized);
			$(document).on("responsive", closeMenu);
			
			$("body").on("click", "#btnLoadMore", function() { connectWp(mPageCounter)});
		}
	);
	
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
	
	function windowOnResized()
	{	
		if ($("body").hasClass("sMobile"))
		{
			$(".infoPanel").css("height", "60px");
		}
		else
		{
			$(".infoPanel").css("height", $(document).height() + "px");
		}
	}
	
	function connectWp(pPage)
	{
		$("#btnLoadMore").remove();
	
	   jQuery.ajax( {
			url:  'http://blog.herbertgraphy.com?json=1&page=' + pPage,
			dataType:'jsonp',
			success: function( response ) {
				console.log(response);
				var _i = 0;
				var _allPostCount =  response.count_total;
				var _postCount = response.posts.length;
				var _blogRecordHTML = "";
				
				for (_i = 0; _i < _postCount; _i++)
				{
					_blogRecordHTML += "<div class='blogEntry'>";
					_blogRecordHTML += "<div class='title'>" + response.posts[_i].title + "</div>";
					_blogRecordHTML += "<div class='content'>" + response.posts[_i].content + "</div>";
					_blogRecordHTML += "</div>";
				}
				
				console.log("total" + _allPostCount);
				console.log("next " + pPage*response.posts.length);
				if (pPage*response.posts.length < _allPostCount)
				{
					_blogRecordHTML += "<a id='btnLoadMore' href='javascript:void(0)'>More...</a>";
				}
				
				$(".blogContainer").append(_blogRecordHTML);
				$(".blogEntry img").css("width", "100%");
				$(".blogEntry img").css("height", "auto");
				
				var _targetScrollToIndex = (pPage-1)*response.posts.length;
				
				$('html, body').animate({
					scrollTop: $(".blogEntry:eq(" + _targetScrollToIndex + ")").offset().top
				}, 200);
			 
				setTimeout(function()
				{
					if ($("body").hasClass("sMobile"))
					{
						$(".infoPanel").css("height", "60px");
					}
					else
					{
						$(".infoPanel").css("height", $(document).height() + "px");
					}
					
					mPageCounter++;
					
				}, 500);
				 
			}
		} );
	}
</script>
</html>