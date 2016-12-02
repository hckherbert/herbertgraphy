GridControl.prototype.mAspectRatio_num = 1.5;
GridControl.prototype.mGridControl = null;
GridControl.prototype.mGridCount_num = 0;
GridControl.prototype.mColCount_num = 0;
GridControl.prototype.mGrid_array = null;
GridControl.prototype.mImageLoadedCount_num = 0;
GridControl.prototype.mIsOccupied_array = null;
GridControl.prototype.mGridstaggering = false;
GridControl.prototype.mGridstaggered = false;
GridControl.prototype.mPhotoOverlay = null;
GridControl.prototype.mActiveGridIndex_num = -1;
GridControl.prototype.mWinWidthBeforeOpen_num = 0;
GridControl.prototype.mWinWidthBeforeStaggered_num = 0;
GridControl.prototype.mOverlayPopSpeed_num = 0.5;
GridControl.prototype.mTimerReposition = null;
GridControl.prototype.mBaseBreakPoint_array = null;
GridControl.prototype.mWideScreenBreakPoint_num = null;
GridControl.prototype.mMediumBreakPoint_num = null;
GridControl.prototype.mDirectPhotoSlug = null;

function GridControl(pGridControl, pPhotoOverlay)
{
	var _self = this;
	this.mGrid_array = [];
	this.mIsOccupied_array = [];
	this.mGridControl = pGridControl;
	this.mPhotoOverlay = pPhotoOverlay;
	this.mPhotoOverlay.setOnHideStart(function(){_self.photoOverlayOnHideStart();});
	this.mGridCount_num = this.mGridControl.children(".grid").length;
	this.mDirectPhotoSlug  = $("body").data("direct_photo_slug");

	if (this.mDirectPhotoSlug && !$(".grid[data-slug='" + this.mDirectPhotoSlug + "']").length)
	{
		location.href= GLOBAL_SITE_URL + "not_found";
	}
	
	this.mGridControl.children(".grid").each
	(
		function(i,e)
		{
			var _grid = new Grid($(this));
			_grid.addEventListener("click", function() { _self.onClick(_grid);});
			_grid.setIndex(i);
			
			if ($(this).attr("data-featured") == "true")
			{
				_grid.setFeatured(true);
			}

			if ($(this).attr("data-highlighted") == "true")
			{
				_grid.setHighlighted(true);
			}
			
			var _imgObj = new Image();
			_imgObj.onload = function()
			{
				_self.imageOnLoaded(_imgObj);
			}
			
			_imgObj.src = $(this).find("img").attr("src") + "?r=" + Math.random() + "id=" + i;
			
			_self.mGrid_array.push(_grid);
			_self.mIsOccupied_array.push(false);
		}
	)

}

GridControl.prototype.initBreakPoints = function(pBaseBreakPoint_array, pMediumBreakPoint_num, pWideScreenBreakPoint_num)
{
	this.mBaseBreakPoint_array = pBaseBreakPoint_array;
	this.mMediumBreakPoint_num = pMediumBreakPoint_num;
	this.mWideScreenBreakPoint_num = pWideScreenBreakPoint_num;
}

GridControl.prototype.imageOnLoaded = function(pImgObj)
{
	var _id = pImgObj.src.split("id=")[1];
	
	this.mImageLoadedCount_num++;
	
	if (pImgObj.width > pImgObj.height)
	{
		this.mGridControl.find(".grid:eq(" + _id + ")").attr("data-orientation", "h");
		this.mGrid_array[_id].setOrientation("h");
	}
	else if (pImgObj.width < pImgObj.height)
	{
		this.mGridControl.find(".grid:eq(" + _id + ")").attr("data-orientation", "v");
		this.mGrid_array[_id].setOrientation("v");
	}

	if (this.mImageLoadedCount_num == this.mGridCount_num)
	{
		this.onAllImageLoaded();
	}
}

GridControl.prototype.onAllImageLoaded = function()
{
	var _self = this;
	this.mWinWidthBeforeStaggered_num = $(window).width();
	this.positionGrids();
}

GridControl.prototype.updateDensity = function(pDensity_str)
{
	if (pDensity_str == "low")
	{	
		this.mColCount_num = 3;
	}
	else if (pDensity_str == "medium")
	{
		this.mColCount_num = 4;
	}
	else if (pDensity_str == "higher")
	{
		this.mColCount_num = 5;
	}
	else if (pDensity_str == "high")
	{
		this.mColCount_num = 6;
	}
}


GridControl.prototype.resetOccupy = function(pAspectRatio_num)
{
	var _i = 0;
	
	while (_i < this.mIsOccupied_array.length)
	{
		this.mIsOccupied_array[_i] = false;
		_i++;
	}
}

GridControl.prototype.setFeaturedtOccupy = function()
{
	if (this.mGrid_array[0].getOrientation() == "h")
	{
		this.mIsOccupied_array[0] = true;
		this.mIsOccupied_array[1] = true;
		this.mIsOccupied_array[2] = true;
		
		this.mIsOccupied_array[this.mColCount_num] = true;
		this.mIsOccupied_array[this.mColCount_num+1] = true;
		this.mIsOccupied_array[this.mColCount_num+2] = true;

		this.mIsOccupied_array[this.mColCount_num*2] = true;
		this.mIsOccupied_array[this.mColCount_num*2+1] = true;
		this.mIsOccupied_array[this.mColCount_num*2+2] = true;

		if (this.mColCount_num > 3)
		{
			this.mIsOccupied_array[this.mColCount_num*3] = true;
			this.mIsOccupied_array[this.mColCount_num*3+1] = true;
			this.mIsOccupied_array[this.mColCount_num*3+2] = true;

			this.mIsOccupied_array[3] = true;
			this.mIsOccupied_array[this.mColCount_num+3] = true;
			this.mIsOccupied_array[this.mColCount_num*2+3] = true;
			this.mIsOccupied_array[this.mColCount_num*3+3] = true;
		}
		
	}
	else if (this.mGrid_array[0].getOrientation() == "v")
	{
		this.mIsOccupied_array[0] = true;
		this.mIsOccupied_array[1] = true;
		this.mIsOccupied_array[2] = true;
		
		this.mIsOccupied_array[this.mColCount_num] = true;
		this.mIsOccupied_array[this.mColCount_num+1] = true;
		this.mIsOccupied_array[this.mColCount_num+2] = true;
		
		this.mIsOccupied_array[this.mColCount_num*2] = true;
		this.mIsOccupied_array[this.mColCount_num*2+1] = true;
		this.mIsOccupied_array[this.mColCount_num*2+2] = true;
		
		this.mIsOccupied_array[this.mColCount_num*3] = true;
		this.mIsOccupied_array[this.mColCount_num*3+1] = true;
		this.mIsOccupied_array[this.mColCount_num*3+2] = true;
		
		this.mIsOccupied_array[this.mColCount_num*4] = true;
		this.mIsOccupied_array[this.mColCount_num*4+1] = true;
		this.mIsOccupied_array[this.mColCount_num*4+2] = true;
		
		this.mIsOccupied_array[this.mColCount_num*5] = true;
		this.mIsOccupied_array[this.mColCount_num*5+1] = true;
		this.mIsOccupied_array[this.mColCount_num*5+2] = true;
	}
}

GridControl.prototype.setHighlightedOccupy = function()
{

}

GridControl.prototype.rePositionGrid = function()
{
	clearTimeout(this.mTimerReposition);

	if ($(window).width()>=0 && $(window).width()<=this.mBaseBreakPoint_array[1])
	{
		this.updateDensity("low");
	}
	else if ($(window).width()>mBaseBreakPoint_array[1] && $(window).width()<=this.mMediumBreakPoint_num)
	{
		this.updateDensity("medium");
	}
	else if ($(window).width()>mBaseBreakPoint_array[1] && $(window).width()<=this.mWideScreenBreakPoint_num)
	{
		this.updateDensity("higher");
	}
	else
	{
		this.updateDensity("high");
	}	 
	
	this.positionGrids();
}

GridControl.prototype.positionGrids = function()
{	
	var _self = this;
	var _i = 0;
	var _j = 0;
	var _gridWidth_num = 0;
	var _gridHeight_num = 0;
	var _nextAvailableIndex_num = 0;
	var _widthFactor_num = 1;
	var _finalGridWidth_num = 0;
	var _finalGridHeight_num = 0;

	this.resetOccupy();

	for (_i = 0; _i< this.mGridCount_num; _i++)
	{
		var _nextAvailableFound = false;
		
		_j = _nextAvailableIndex_num;
		_widthFactor_num = 1;
		
		while (!_nextAvailableFound)
		{
			if (!this.mIsOccupied_array[_j])
			{
				_nextAvailableFound = true;
				_nextAvailableIndex_num = _j;
				this.mIsOccupied_array[_nextAvailableIndex_num] = true;	
			}
			
			_j++;
		}

		if (this.mGrid_array[_i].isFeatured())
		{
			this.setFeaturedtOccupy();
		}

		if (this.mGrid_array[_i].isHighlighted())
		{
			this.setHighlightedOccupy();
		}
		
		_gridWidth_num = Math.floor($(".gridPanel").width()/this.mColCount_num);
		
		console.log("grid panel offset: " + ($(".gridPanel").width() - (_gridWidth_num * this.mColCount_num)));
		_gridHeight_num = Math.round(_gridWidth_num / this.mAspectRatio_num);

		if (this.mGrid_array[_i].getOrientation() == "v")
		{
			this.mIsOccupied_array[_nextAvailableIndex_num+this.mColCount_num] = true;
			
		}
		
		if (this.mGrid_array[_i].isFeatured())
		{
			if (this.mGrid_array[_i].getOrientation() == "h")
			{
				_widthFactor_num = ($("body").hasClass("sDesktop")) ? 4 : 3;
				_finalGridWidth_num = _gridWidth_num*_widthFactor_num;
				_finalGridHeight_num = Math.round(_finalGridWidth_num / this.mAspectRatio_num);
			}
			else if (this.mGrid_array[_i].getOrientation() == "v")
			{
				_widthFactor_num = 3;
				_finalGridWidth_num = _gridWidth_num*_widthFactor_num;
				_finalGridHeight_num = _finalGridWidth_num  / this.mAspectRatio_num * 2;
			}
		}

		else
		{
			if (this.mGrid_array[_i].getOrientation() == "h")
			{
				_widthFactor_num = 1;
				_finalGridWidth_num = _gridWidth_num*_widthFactor_num;
				_finalGridHeight_num = Math.round(_finalGridWidth_num / this.mAspectRatio_num);
			}
			else
			{
				_widthFactor_num = 1;
				_finalGridWidth_num = _gridWidth_num*_widthFactor_num;
				_finalGridHeight_num = _finalGridWidth_num / this.mAspectRatio_num * 2;
			}
		}

		this.mGrid_array[_i].setSize(_finalGridWidth_num, _finalGridHeight_num);
		this.mGrid_array[_i].setPosition((_nextAvailableIndex_num % this.mColCount_num) *_gridWidth_num, Math.floor(_nextAvailableIndex_num / this.mColCount_num) * _gridHeight_num);
		
		if (this.mGrid_array[_i].getOrientation() == "v")
		{
			this.mGrid_array[_i].centerImageVertically(this.mAspectRatio_num);
		}
		
	}

	if ($("body").hasClass("sDesktop"))
	{
		if (this.mDirectPhotoSlug != null)
		{
			this.handleDirectPhotoLink();
			this.fadeOutPageLoadingElements();
			setTimeout(function ()
			{
				_self.transitLoadingAndAlbumStart();
				_self.onStaggeredAll();

			}, 400);
		}
		else
		{
			if (!this.mGridstaggered)
			{
				if (!this.mGridstaggering)
				{
					this.mGridstaggering = true;
					this.fadeOutPageLoadingElements();

					setTimeout(function ()
					{
						_self.transitLoadingAndAlbumStart();

						var _fromLeft =  Math.round(Math.random() * $(".gridPanel").width());
						var _fromTop = Math.round( $(window).height());

						_self.mGridTween = TweenMax.staggerFrom($(".grid"), 0.8, {
							opacity: 0.5,
							"left": _fromLeft + "px",
							"top": _fromTop + "px",
							ease: Back.easeInOut
						}, 0.8 / _self.mGridCount_num, function ()
						{
							_self.onStaggeredAll();
						});

					}, 400);

				}
			}
			else
			{
				this.updateGridInfoHeight();
			}
		}
	}
	else
	{
		this.fadeOutPageLoadingElements();

		setTimeout(function()
		{
			_self.transitLoadingAndAlbumStart();
			//_self.onStaggeredAll();
			_self.updateGridPanelAndWinScroll();

			if (_self.mDirectPhotoSlug!=null)
			{
				_self.handleDirectPhotoLink();
			}

		}, 400);

	}
}

GridControl.prototype.fadeOutPageLoadingElements = function()
{
	$(".loadingText").addClass("show");
	$(".camera").addClass("cameraZoom vaporizing");
	$(".blink").addClass("blinkInit");
}

GridControl.prototype.handleDirectPhotoLink = function()
{
	$(".grid[data-slug='" + this.mDirectPhotoSlug + "']").trigger("click");
}

GridControl.prototype.transitLoadingAndAlbumStart = function()
{
	$(".loadingText").addClass("down");

	$(".pageLoading").fadeTo(400, 0, function()
	{
		$(this).remove();
	});

	$(".wrapperAlbum").addClass("show");
	$(".footer").addClass("show");
}

GridControl.prototype.onStaggeredAll = function()
{
	var _self = this;
	
	console.log("staggered all!");
	console.log("before starggered: " + this.mWinWidthBeforeStaggered_num + " ; after staggered: " + $(window).width());
	this.mGridstaggered = true;

	if (this.mWinWidthBeforeStaggered_num  != $(window).width())
	{	
		console.log("go to reposition!");
		this.mTimerReposition = setTimeout
		( 
			function()
			{
				_self.rePositionGrid();
			},
			100
		)
	}

	this.updateGridInfoHeight();
}

GridControl.prototype.updateGridInfoHeight = function()
{
	if ($("body").hasClass("sDesktop"))
	{
		var _i = 0;
		var _maxLastGridHeight_num = 0;
		var _gridPanelHeight_num = this.mGrid_array[this.mGridCount_num-1].getPosition()["y"];
		console.log("_gridPanelHeight_num: " + _gridPanelHeight_num);
		var _startLastRowIndex = this.mGridCount_num - this.mColCount_num;

		if (_startLastRowIndex  > 0)
		{
			for (_i = _startLastRowIndex ; _i < this.mGridCount_num; _i++)
			{
				if (this.mGrid_array[_i].getSize()["height"] >= _maxLastGridHeight_num)
				{
					_maxLastGridHeight_num = this.mGrid_array[_i].getSize()["height"];
				}
			}

			_gridPanelHeight_num +=  _maxLastGridHeight_num;

			if (_gridPanelHeight_num < $(".infoPanel").height())
			{
				$(".infoPanel").css("height", "auto");
			}
		}
		else
		{
			$(".infoPanel").css("height", "auto");
		}
	}
	else
	{
		$(".infoPanel").css("height", "auto");
	}

	this.updateGridPanelAndWinScroll();
}

GridControl.prototype.updateGridPanelAndWinScroll = function()
{
	var _gridWidth_num = Math.floor($(".gridPanel").width()/this.mColCount_num);
	var _gridPanelWidth_num = Math.floor($(".gridPanel").width());
	var _offset_num = _gridWidth_num * this.mColCount_num - _gridPanelWidth_num;
	console.log("_offset_num: " + _offset_num);
	$(".gridPanel").css("right", _offset_num + "px");

	$("html").addClass("vScrollOn");
}
 
GridControl.prototype.onClick = function(pObj)
{
	$("html").css("overflow-y", "hidden");
	var _scrollTop = $(window).scrollTop();
	var _fromX_num = 0;
	var _fromY_num = 0;
	var _toX_num = 0;
	var _toY_num = 0;
	var _toWidth_num = 0;
	var _toHeight_num = 0;
	var _zoomFactor = 0;
	
	this.mActiveGridIndex_num = pObj.getIndex();
	console.log("active index on click: " +  pObj.getIndex());
	this.mWinWidthBeforeOpen_num = $(window).width();
	console.log("active index: " + this.mActiveGridIndex_num);
	 
	if (this.mColCount_num == 3)
	{
		_fromX_num = pObj.getPosition()["x"];
		_fromY_num = pObj.getPosition()["y"]- _scrollTop + $(".infoPanel").height();
	}
	else
	{
		_fromX_num = pObj.getPosition()["x"] + $(".infoPanel").width();
		_fromY_num = pObj.getPosition()["y"]- _scrollTop;
	}

	if ($("body").hasClass("sDesktop"))
	{
		if ( $(window).width() >= this.mWideScreenBreakPoint_num)
		{
			_zoomFactor = PhotoOverlay.zoomFactorDesktop;
		}
		else
		{
			_zoomFactor =PhotoOverlay.zoomFactorMobile;
		}
	}
	else
	{
		_zoomFactor =PhotoOverlay.zoomFactorMobile;
	}

	if ($(window).width() <= $(window).height())
	{
		_toWidth_num = Math.round($(window).width() * _zoomFactor );

		if (pObj.getOrientation() == "h")
		{
			_toHeight_num = Math.round(_toWidth_num / this.mAspectRatio_num);
		}
		else
		{
			_toHeight_num = Math.round(_toWidth_num * this.mAspectRatio_num);
		}
	}
	else
	{
		_toHeight_num = Math.round($(window).height() * _zoomFactor);

		if (pObj.getOrientation() == "h")
		{
			_toWidth_num = Math.round(_toHeight_num * this.mAspectRatio_num);
		}
		else
		{
			_toWidth_num = Math.round(_toHeight_num / this.mAspectRatio_num);
		}
	}
	_toX_num =  Math.round(0.5* (($(window).width() - _toWidth_num)));
	_toY_num =  0.5* (($(window).height() - _toHeight_num));

	TweenMax.fromTo(this.mPhotoOverlay.getPhotoContainer(), this.mOverlayPopSpeed_num, {left:_fromX_num, top:_fromY_num, width:pObj.getSize()["width"], height:pObj.getSize()["height"], ease:Back.easeOut}, {left:_toX_num, top:_toY_num, width: _toWidth_num, height: _toHeight_num, ease:Back.easeOut});
	
	this.mPhotoOverlay.setSizeData(pObj.getOrientation(), this.mAspectRatio_num);
	this.mPhotoOverlay.show(this.mOverlayPopSpeed_num*1000, pObj.getFileName(), pObj.getFileZoomSize(), pObj.getDesc(), pObj.getTitle());
}


GridControl.prototype.photoOverlayOnHideStart = function()
{
	$("html").css("overflow-y", "auto");
	
	var _self = this;
	var _activeGridTop_num = 0;
	var _scrollTop = $(window).scrollTop();
	var _fromX_num =  this.mPhotoOverlay.getPhotoPosition()["x"];
	var _fromY_num = this.mPhotoOverlay.getPhotoPosition()["y"];
	var _toX_num = this.mGrid_array[this.mActiveGridIndex_num].getPosition()["x"];
	var _toY_num = this.mGrid_array[this.mActiveGridIndex_num].getPosition()["y"];
	var _toWidth_num = this.mGrid_array[this.mActiveGridIndex_num].getSize()["width"];
	var _toHeight_num =  this.mGrid_array[this.mActiveGridIndex_num].getSize()["height"];
	
	this.mActiveGridIndex_num = this.mGrid_array[this.mActiveGridIndex_num].getIndex();
	 
	if (this.mColCount_num == 3)
	{
		_toX_num = this.mGrid_array[this.mActiveGridIndex_num].getPosition()["x"];
		_toY_num = this.mGrid_array[this.mActiveGridIndex_num].getPosition()["y"]- _scrollTop + $(".infoPanel").height();
		_activeGridTop_num =  this.mGrid_array[this.mActiveGridIndex_num].getPosition()["y"] + $(".infoPanel").height();
	}
	else
	{
		_toX_num = this.mGrid_array[this.mActiveGridIndex_num].getPosition()["x"] + $(".infoPanel").width();
		_toY_num = this.mGrid_array[this.mActiveGridIndex_num].getPosition()["y"]- _scrollTop;
		_activeGridTop_num =  this.mGrid_array[this.mActiveGridIndex_num].getPosition()["y"] 
	}
	
	_activeGridTop_num =  Math.round(_activeGridTop_num - 0.5 * Math.round($(window).height()));
 
	console.log(_activeGridTop_num);
	
	if (_activeGridTop_num < 0)
	{
		_activeGridTop_num = 0;
	}

	TweenMax.fromTo(this.mPhotoOverlay.getPhotoContainer(), this.mOverlayPopSpeed_num, {left:_fromX_num, top:_fromY_num, width:this.mPhotoOverlay.getPhotoContainer().width(), height:this.mPhotoOverlay.getPhotoContainer().height(), ease:Back.easeOut}, {left:_toX_num, top:_toY_num, width: _toWidth_num, height: _toHeight_num, ease:Back.easeOut});
	
	console.log(_self.mWinWidthBeforeOpen_num + " ; " + $(window).width());

	this.mPhotoOverlay.hide(function(){_self.onPhotoOverlayHidden(_activeGridTop_num);});
}

GridControl.prototype.onPhotoOverlayHidden = function(pActiveGridTop_num)
{
	console.log("onPhotoOverlayHidden; " + pActiveGridTop_num);

	if (this.mDirectPhotoSlug)
	{
		location.href= $("body").data("album_path");
		return;
	}

	this.mGrid_array[this.mActiveGridIndex_num].setOpacity(1);

	if (this.mWinWidthBeforeOpen_num!=$(window).width()) 
	{
		//$(window).scrollTop(pActiveGridTop_num);
		$("html, body").stop().animate({scrollTop:pActiveGridTop_num}, '50', 'swing');

	}


	$("html").css("overflow-y", "auto");
}