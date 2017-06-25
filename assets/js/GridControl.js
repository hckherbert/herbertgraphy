GridControl.prototype.mAspectRatio_num = null;
GridControl.prototype.mGridControl = null;
GridControl.prototype.mGridCount_num = 0;
GridControl.prototype.mColCount_num = 0;
GridControl.prototype.mGrid_array = null;
GridControl.prototype.mImageLoadedCount_num = 0;
GridControl.prototype.mIsOccupied_array = null;
GridControl.prototype.mGridstaggering = false;
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
GridControl.prototype.mNextAvailableIndex_num = 0;
GridControl.prototype.mIsDirectPhotoLinkInit = false;
GridControl.prototype.mHistState_obj = null;
GridControl.prototype.mGridTween  = null;
GridControl.prototype.mStaggerTimeout = 0;

function GridControl(pGridControl, pPhotoOverlay)
{
	var _self = this;
	this.mGrid_array = [];
	this.mIsOccupied_array = [];
	this.mHistState_obj = {};
	this.mGridControl = pGridControl;
	this.mPhotoOverlay = pPhotoOverlay;
	this.mPhotoOverlay.setOnHideStart(function(){_self.photoOverlayOnHideStart();});
	this.mGridCount_num = this.mGridControl.children(".grid").length;
	this.mDirectPhotoSlug  = $("body").data("direct_photo_slug");
	this.mAspectRatio_num = parseFloat($("body").data("aspect_ratio"));

	if (this.mDirectPhotoSlug && !$(".grid[data-slug='" + this.mDirectPhotoSlug + "']").length)
	{
		location.href= GLOBAL_SITE_URL + "not_found";
	}

	var _isOccupiedSetLength = this.mGridCount_num * 4; //give some values large enough to detect if occupied

	for (var _i=0; _i<_isOccupiedSetLength; _i++)
	{
		this.mIsOccupied_array.push(false);
	}

	$(window).scrollTop(0);

}

GridControl.prototype.initGrid = function()
{
	var _self = this;

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

			var _width =  parseInt($(this).data("width"));
			var _height =  parseInt($(this).data("height"));

			if (_width >= _height)
			{
				_grid.setOrientation("h");
			}
			else
			{
				_grid.setOrientation("v");
			}

			_self.mGrid_array.push(_grid);
		}
	)

	this.mWinWidthBeforeStaggered_num = $(window).width();
	this.positionGrids();

}

GridControl.prototype.initBreakPoints = function(pBaseBreakPoint_array, pMediumBreakPoint_num, pWideScreenBreakPoint_num)
{
	this.mBaseBreakPoint_array = pBaseBreakPoint_array;
	this.mMediumBreakPoint_num = pMediumBreakPoint_num;
	this.mWideScreenBreakPoint_num = pWideScreenBreakPoint_num;
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


GridControl.prototype.resetOccupy = function()
{
	var _i = 0;

	while (_i < this.mIsOccupied_array.length)
	{
		this.mIsOccupied_array[_i] = false;
		_i++;
	}
}

GridControl.prototype.setFeaturedOccupy = function()
{
	if (this.mAspectRatio_num == 1)
	{
		this.mIsOccupied_array[0] = true;
		this.mIsOccupied_array[1] = true;
		this.mIsOccupied_array[2] = true;

		this.mIsOccupied_array[this.mColCount_num] = true;
		this.mIsOccupied_array[this.mColCount_num + 1] = true;
		this.mIsOccupied_array[this.mColCount_num + 2] = true;

		this.mIsOccupied_array[this.mColCount_num * 2] = true;
		this.mIsOccupied_array[this.mColCount_num * 2 + 1] = true;
		this.mIsOccupied_array[this.mColCount_num * 2 + 2] = true;

		this.mIsOccupied_array[this.mColCount_num * 3] = true;
		this.mIsOccupied_array[this.mColCount_num * 3 + 1] = true;
		this.mIsOccupied_array[this.mColCount_num * 3 + 2] = true;
	}
	else
	{
		if (this.mGrid_array[0].getOrientation() == "h" && this.mColCount_num>3)
		{
			this.mIsOccupied_array[0] = true;
			this.mIsOccupied_array[1] = true;
			this.mIsOccupied_array[2] = true;
			this.mIsOccupied_array[3] = true;

			this.mIsOccupied_array[this.mColCount_num] = true;
			this.mIsOccupied_array[this.mColCount_num + 1] = true;
			this.mIsOccupied_array[this.mColCount_num + 2] = true;
			this.mIsOccupied_array[this.mColCount_num + 3] = true;

			this.mIsOccupied_array[this.mColCount_num * 2] = true;
			this.mIsOccupied_array[this.mColCount_num * 2 + 1] = true;
			this.mIsOccupied_array[this.mColCount_num * 2 + 2] = true;
			this.mIsOccupied_array[this.mColCount_num * 2 + 3] = true;

			this.mIsOccupied_array[this.mColCount_num * 3] = true;
			this.mIsOccupied_array[this.mColCount_num * 3 + 1] = true;
			this.mIsOccupied_array[this.mColCount_num * 3 + 2] = true;
			this.mIsOccupied_array[this.mColCount_num * 3 + 3] = true;

		}
		else if (this.mGrid_array[0].getOrientation() == "v")
		{
			this.mIsOccupied_array[0] = true;
			this.mIsOccupied_array[1] = true;
			this.mIsOccupied_array[2] = true;

			this.mIsOccupied_array[this.mColCount_num] = true;
			this.mIsOccupied_array[this.mColCount_num + 1] = true;
			this.mIsOccupied_array[this.mColCount_num + 2] = true;

			this.mIsOccupied_array[this.mColCount_num * 2] = true;
			this.mIsOccupied_array[this.mColCount_num * 2 + 1] = true;
			this.mIsOccupied_array[this.mColCount_num * 2 + 2] = true;

			this.mIsOccupied_array[this.mColCount_num * 3] = true;
			this.mIsOccupied_array[this.mColCount_num * 3 + 1] = true;
			this.mIsOccupied_array[this.mColCount_num * 3 + 2] = true;

			this.mIsOccupied_array[this.mColCount_num * 4] = true;
			this.mIsOccupied_array[this.mColCount_num * 4 + 1] = true;
			this.mIsOccupied_array[this.mColCount_num * 4 + 2] = true;

			this.mIsOccupied_array[this.mColCount_num * 5] = true;
			this.mIsOccupied_array[this.mColCount_num * 5 + 1] = true;
			this.mIsOccupied_array[this.mColCount_num * 5 + 2] = true;
		}
		else if (this.mGrid_array[0].getOrientation() == "h")
		{
			for (var _i=0; _i<=8; _i++)
			{
				this.mIsOccupied_array[_i] = true;
			}
		}
	}
}

GridControl.prototype.setHighlightedOccupy = function(pGridIndex, pTargetIndex)
{
	var _i = 0;
	var _j = 0;
	var _isLastRow = pGridIndex>= this.mColCount_num*(Math.ceil(pGridIndex/this.mColCount_num)-1);

	if (this.mGrid_array[pGridIndex].getOrientation() == "h")
	{
		var _occupyIndex0 = pTargetIndex;
		var _occupyIndex1 = pTargetIndex + 1;
		var _occupyIndex2 = pTargetIndex + this.mColCount_num;
		var _occupyIndex3 = pTargetIndex + this.mColCount_num + 1;

		//case 1 if index is not at the last column
		if ((pTargetIndex+1)  % this.mColCount_num != 0)
		{
			//simply set highlighted if the target positions are all not occupied, set them to occupied
			if
			(
				this.mIsOccupied_array[_occupyIndex0] &&
				!this.mIsOccupied_array[_occupyIndex1] &&
				!this.mIsOccupied_array[_occupyIndex2] &&
				!this.mIsOccupied_array[_occupyIndex3] &&
				!_isLastRow
			)
			{
				this.mIsOccupied_array[_occupyIndex0] = true;
				this.mIsOccupied_array[_occupyIndex1] = true;
				this.mIsOccupied_array[_occupyIndex2] = true;
				this.mIsOccupied_array[_occupyIndex3] = true;
				this.mNextAvailableIndex_num = pTargetIndex;
			}
			else
			{
				_j = pTargetIndex+1;

				for (_i=_j; _i < this.mIsOccupied_array.length; _i++)
				{
					if
					(
						!this.mIsOccupied_array[_i]  &&
						!this.mIsOccupied_array[_i+1] &&
						!this.mIsOccupied_array[_i+ this.mColCount_num] &&
						!this.mIsOccupied_array[_i+this.mColCount_num + 1] &&
						(_i+1) % this.mColCount_num != 0
					)
					{
						this.mIsOccupied_array[_i] = true;
						this.mIsOccupied_array[_i+1] = true;
						this.mIsOccupied_array[_i+ this.mColCount_num] = true;
						this.mIsOccupied_array[_i+this.mColCount_num + 1] = true;

						///the nextAvailableIndex is now updated , set it to false;
						this.mIsOccupied_array[pTargetIndex]= false;
						this.mNextAvailableIndex_num = _i;
						break;
					}
				}
			}
		}
		//case 2 if index is at the last column
		else
		{
			_occupyIndex0 = _occupyIndex0 + 1;
			_occupyIndex1 = _occupyIndex0 + 1;
			_occupyIndex2 = _occupyIndex0 + this.mColCount_num;
			_occupyIndex3 = _occupyIndex0 + this.mColCount_num + 1;

			//if the next target indices in the next 2 rows are not occupied, set them to occupied
			if
			(
				this.mIsOccupied_array[_occupyIndex0] &&
				!this.mIsOccupied_array[_occupyIndex1] &&
				!this.mIsOccupied_array[_occupyIndex2] &&
				!this.mIsOccupied_array[_occupyIndex3] &&
				!_isLastRow
			)
			{

				//the nextAvailableIndex is now shifted to the first column of the next row, so , set it to false;
				this.mIsOccupied_array[pTargetIndex] = false;
				this.mIsOccupied_array[_occupyIndex0] = true;
				this.mIsOccupied_array[_occupyIndex1] = true;
				this.mIsOccupied_array[_occupyIndex2] = true;
				this.mIsOccupied_array[_occupyIndex3] = true;
				this.mNextAvailableIndex_num = _occupyIndex0;

			}
			else
			{
				_j = pTargetIndex+1;

				for (_i=_j; _i < this.mIsOccupied_array.length; _i++)
				{
					if
					(
						!this.mIsOccupied_array[_i]  &&
						!this.mIsOccupied_array[_i+1] &&
						!this.mIsOccupied_array[_i+ this.mColCount_num] &&
						!this.mIsOccupied_array[_i+this.mColCount_num + 1] &&
						(_i+1) % this.mColCount_num != 0
					)
					{
						this.mIsOccupied_array[_i] = true;
						this.mIsOccupied_array[_i+1] = true;
						this.mIsOccupied_array[_i+ this.mColCount_num] = true;
						this.mIsOccupied_array[_i+this.mColCount_num + 1] = true;

						///the nextAvailableIndex is now updated , set it to false;
						this.mIsOccupied_array[pTargetIndex]= false;
						this.mNextAvailableIndex_num =  _i;
						break;
					}
				}
			}
		}
	}
	else if (this.mGrid_array[pGridIndex].getOrientation() == "v")
	{
		var _occupyIndex0 = pTargetIndex;
		var _occupyIndex1 = pTargetIndex + 1;
		var _occupyIndex2 = pTargetIndex + this.mColCount_num;
		var _occupyIndex3 = pTargetIndex + this.mColCount_num + 1;
		var _occupyIndex4 = pTargetIndex + this.mColCount_num * 2;
		var _occupyIndex5 = pTargetIndex + this.mColCount_num * 2 + 1;
		var _occupyIndex6 = pTargetIndex + this.mColCount_num * 3;
		var _occupyIndex7 = pTargetIndex + this.mColCount_num * 3 + 1;

		//case 1 if index is not at the last column
		if ((pTargetIndex + 1) % this.mColCount_num != 0)
		{
			//simply set highlighted if the target positions are all not occupied, set them to occupied
			if
			(
				this.mIsOccupied_array[_occupyIndex0] &&
				!this.mIsOccupied_array[_occupyIndex1] &&
				!this.mIsOccupied_array[_occupyIndex2] &&
				!this.mIsOccupied_array[_occupyIndex3] &&
				!this.mIsOccupied_array[_occupyIndex4] &&
				!this.mIsOccupied_array[_occupyIndex5] &&
				!this.mIsOccupied_array[_occupyIndex6] &&
				!this.mIsOccupied_array[_occupyIndex7] &&
				!_isLastRow
			)
			{
				this.mIsOccupied_array[_occupyIndex0] = true;
				this.mIsOccupied_array[_occupyIndex1] = true;
				this.mIsOccupied_array[_occupyIndex2] = true;
				this.mIsOccupied_array[_occupyIndex3] = true;
				this.mIsOccupied_array[_occupyIndex4] = true;
				this.mIsOccupied_array[_occupyIndex5] = true;
				this.mIsOccupied_array[_occupyIndex6] = true;
				this.mIsOccupied_array[_occupyIndex7] = true;
				this.mNextAvailableIndex_num = pTargetIndex;
			}
			else
			{
				_j = pTargetIndex+1;

				for (_i=_j; _i < this.mIsOccupied_array.length; _i++)
				{
					if
					(
						!this.mIsOccupied_array[_i]  &&
						!this.mIsOccupied_array[_i+1] &&
						!this.mIsOccupied_array[_i+ this.mColCount_num] &&
						!this.mIsOccupied_array[_i+this.mColCount_num + 1] &&
						!this.mIsOccupied_array[_i+ this.mColCount_num * 2] &&
						!this.mIsOccupied_array[_i+this.mColCount_num * 2 + 1] &&
						!this.mIsOccupied_array[_i+ this.mColCount_num * 3] &&
						!this.mIsOccupied_array[_i+this.mColCount_num * 3 + 1] &&
						(_i+1) % this.mColCount_num != 0
					)
					{
						this.mIsOccupied_array[_i] = true;
						this.mIsOccupied_array[_i+1] = true;
						this.mIsOccupied_array[_i+ this.mColCount_num] = true;
						this.mIsOccupied_array[_i+this.mColCount_num + 1] = true;
						this.mIsOccupied_array[_i+ this.mColCount_num * 2] = true;
						this.mIsOccupied_array[_i+this.mColCount_num *2  + 1] = true;
						this.mIsOccupied_array[_i+ this.mColCount_num * 3] = true;
						this.mIsOccupied_array[_i+this.mColCount_num * 3 + 1] = true;

						///the nextAvailableIndex is now updated , set it to false;
						this.mIsOccupied_array[pTargetIndex]= false;
						this.mNextAvailableIndex_num = _i;
						break;
					}
				}
			}
		}
		else
		{
			_occupyIndex0 = _occupyIndex0 + 1;
			_occupyIndex1 = _occupyIndex0 + 1;
			_occupyIndex2 = _occupyIndex0 + this.mColCount_num;
			_occupyIndex3 = _occupyIndex0 + this.mColCount_num + 1;
			_occupyIndex4 = _occupyIndex0 + this.mColCount_num * 2;
			_occupyIndex5 = _occupyIndex0 + this.mColCount_num * 2 + 1;
			_occupyIndex6 = _occupyIndex0 + this.mColCount_num * 3;
			_occupyIndex7 = _occupyIndex0 + this.mColCount_num * 3+ 1;

			//if the next target indices in the next 2 rows are not occupied, set them to occupied
			if
			(
				this.mIsOccupied_array[_occupyIndex0] &&
				!this.mIsOccupied_array[_occupyIndex1] &&
				!this.mIsOccupied_array[_occupyIndex2] &&
				!this.mIsOccupied_array[_occupyIndex3] &&
				!this.mIsOccupied_array[_occupyIndex4] &&
				!this.mIsOccupied_array[_occupyIndex5] &&
				!this.mIsOccupied_array[_occupyIndex6] &&
				!this.mIsOccupied_array[_occupyIndex7] &&
				!_isLastRow
			)
			{

				//the nextAvailableIndex is now shifted to the first column of the next row, so , set it to false;
				this.mIsOccupied_array[pTargetIndex] = false;

				this.mIsOccupied_array[_occupyIndex0] = true;
				this.mIsOccupied_array[_occupyIndex1] = true;
				this.mIsOccupied_array[_occupyIndex2] = true;
				this.mIsOccupied_array[_occupyIndex3] = true;
				this.mIsOccupied_array[_occupyIndex4] = true;
				this.mIsOccupied_array[_occupyIndex5] = true;
				this.mIsOccupied_array[_occupyIndex6] = true;
				this.mIsOccupied_array[_occupyIndex7] = true;
				this.mNextAvailableIndex_num = _occupyIndex0;

			}
			else
			{
				_j = pTargetIndex+1;

				for (_i=_j; _i < this.mIsOccupied_array.length; _i++)
				{
					if
					(
						!this.mIsOccupied_array[_i]  &&
						!this.mIsOccupied_array[_i+1] &&
						!this.mIsOccupied_array[_i+ this.mColCount_num] &&
						!this.mIsOccupied_array[_i+this.mColCount_num + 1] &&
						!this.mIsOccupied_array[_i+ this.mColCount_num * 2] &&
						!this.mIsOccupied_array[_i+this.mColCount_num * 2 + 1] &&
						!this.mIsOccupied_array[_i+ this.mColCount_num * 3] &&
						!this.mIsOccupied_array[_i+this.mColCount_num * 3 + 1] &&
						(_i+1) % this.mColCount_num != 0
					)
					{
						this.mIsOccupied_array[_i] = true;
						this.mIsOccupied_array[_i+1] = true;
						this.mIsOccupied_array[_i+ this.mColCount_num] = true;
						this.mIsOccupied_array[_i+this.mColCount_num + 1] = true;
						this.mIsOccupied_array[_i+ this.mColCount_num * 2] = true;
						this.mIsOccupied_array[_i+this.mColCount_num *2  + 1] = true;
						this.mIsOccupied_array[_i+ this.mColCount_num * 3] = true;
						this.mIsOccupied_array[_i+this.mColCount_num * 3 + 1] = true;

						///the nextAvailableIndex is now updated , set it to false;
						this.mIsOccupied_array[pTargetIndex]= false;
						this.mNextAvailableIndex_num = _i;
						break;
					}
				}
			}
		}
	}
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
	var _widthFactor_num = 1;
	var _finalGridWidth_num = 0;
	var _finalGridHeight_num = 0;

	this.resetOccupy();

	for (_i = 0; _i< this.mGridCount_num; _i++)
	{
		var _nextAvailableFound = false;

		_j = 0;
		_widthFactor_num = 1;

		//Rearrange the last two rows to avoid 'holes'!
		if (_i == (Math.floor(this.mGridCount_num / this.mColCount_num) - 1) * this.mColCount_num -1 )
		{
			var _mTempGrid_array = [];

			for (var _k=_i+1; _k < this.mGridCount_num; _k++ )
			{
				_mTempGrid_array.push(this.mGrid_array[_k]);
			}

			_mTempGrid_array = this.sortByHighlight(_mTempGrid_array);

			for (_k = 0; _k < _mTempGrid_array.length; _k++)
			{
				this.mGrid_array[_k+ (_i+1)] =  _mTempGrid_array[_k];
			}

			while (_mTempGrid_array.length > 0)
			{
				_mTempGrid_array.splice(0,1);
			}
		}


		while (!_nextAvailableFound)
		{
			if (!this.mIsOccupied_array[_j])
			{
				_nextAvailableFound = true;
				this.mNextAvailableIndex_num = _j;
				this.mIsOccupied_array[this.mNextAvailableIndex_num] = true;
				break;
			}

			_j++;
		}

		if (_i==0 && this.mGrid_array[0].isFeatured())
		{
			this.setFeaturedOccupy();
		}

		if (this.mGrid_array[_i].isHighlighted())
		{
			this.setHighlightedOccupy(_i, this.mNextAvailableIndex_num);
		}

		_gridWidth_num = Math.floor($(".gridPanel").width() / this.mColCount_num);
		_gridHeight_num = Math.round(_gridWidth_num / this.mAspectRatio_num);

		if (this.mGrid_array[_i].getOrientation() == "v" && !this.mGrid_array[_i].isHighlighted() && !this.mGrid_array[_i].isFeatured())
		{
			_nextAvailableFound = false;
			_j = this.mNextAvailableIndex_num;

			while (!_nextAvailableFound)
			{
				if (!this.mIsOccupied_array[_j] && !this.mIsOccupied_array[_j + this.mColCount_num])
				{
					_nextAvailableFound = true;

					this.mIsOccupied_array[this.mNextAvailableIndex_num] = false;
					this.mIsOccupied_array[_j] = true;
					this.mIsOccupied_array[_j + this.mColCount_num] = true;
					this.mNextAvailableIndex_num = _j;
					break;
				}

				_j++;
			}
		}



		if (this.mGrid_array[_i].isFeatured())
		{
			if (this.mGrid_array[_i].getOrientation() == "h")
			{
				_widthFactor_num = ($("body").hasClass("sDesktop")) ? 4 : 3;
				_finalGridWidth_num = _gridWidth_num * _widthFactor_num;
				_finalGridHeight_num = Math.round(_finalGridWidth_num / this.mAspectRatio_num);
			}
			else if (this.mGrid_array[_i].getOrientation() == "v")
			{
				_widthFactor_num = 3;
				_finalGridWidth_num = _gridWidth_num * _widthFactor_num;
				_finalGridHeight_num = _finalGridWidth_num / this.mAspectRatio_num * 2;
			}
		}
		else if (this.mGrid_array[_i].isHighlighted())
		{
			if (this.mGrid_array[_i].getOrientation() == "h")
			{
				_widthFactor_num = 2;
				_finalGridWidth_num = _gridWidth_num*_widthFactor_num;
				_finalGridHeight_num = Math.round(_finalGridWidth_num / this.mAspectRatio_num);
			}
			else
			{
				_widthFactor_num = 2;
				_finalGridWidth_num = _gridWidth_num*_widthFactor_num;
				_finalGridHeight_num = _finalGridWidth_num / this.mAspectRatio_num * 2;
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
		this.mGrid_array[_i].setPosition((this.mNextAvailableIndex_num  % this.mColCount_num) *_gridWidth_num, Math.floor(this.mNextAvailableIndex_num  / this.mColCount_num) * _gridHeight_num);

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
			if (!this.mGridstaggering)
			{
				this.mGridstaggering = true;
				this.fadeOutPageLoadingElements();

				var  _staggerHeightOffset = $(window).height() + 400;
				var _gridPanelWidth  = $(".gridPanel").width();

				_self.mStaggerTimeout = setTimeout(function ()
				{
					_self.transitLoadingAndAlbumStart();

					//Important: scroll to top to avoid grids overlapping at the window bottom!
					$(window).scrollTop(0);

					_self.mGridTween = TweenMax.staggerFrom($(".grid"), 0.8, {
						opacity: 0.5,
						"left":  Math.round(Math.random() * _gridPanelWidth) + "px",
						"top":  _staggerHeightOffset + "px",
						ease: Back.easeInOut
					}, 0.8 / _self.mGridCount_num, function ()
					{
						_self.onStaggeredAll();

					});
				}, 400);
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
			_self.updateGridPanelAndWinScroll();

			if (_self.mDirectPhotoSlug!=null)
			{
				_self.handleDirectPhotoLink();
			}

		}, 400);
	}
}

/*We want to assign those highlight first*/
GridControl.prototype.sortByHighlight = function(array) {
	return array.sort(function(a, b) {
		var x = a.isHighlighted(); var y = b.isHighlighted();
		return ((x > y) ? -1 : ((x < y) ? 1 : 0));
	});
}


GridControl.prototype.fadeOutPageLoadingElements = function()
{
	$(".loadingText").addClass("show");
	$(".camera").addClass("cameraZoom vaporizing");
	$(".blink").addClass("blinkInit");
}

GridControl.prototype.handleDirectPhotoLink = function()
{
	if (!this.mIsDirectPhotoLinkInit)
	{
		this.mIsDirectPhotoLinkInit = true;
		$(".grid[data-slug='" + this.mDirectPhotoSlug + "']").trigger("click");
	}
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

	clearTimeout(_self.mStaggerTimeout);

	if (this.mWinWidthBeforeStaggered_num  != $(window).width())
	{
		this.mTimerReposition = setTimeout
		(
			function()
			{
				_self.rePositionGrid();
			},
			100
		)
	}

	TweenMax.killChildTweensOf($(".grid"));
	_self.mGridTween = null;

	this.updateGridInfoHeight();
}

GridControl.prototype.updateGridInfoHeight = function()
{
	if ($("body").hasClass("sDesktop"))
	{
		var _i = 0;
		var _maxLastGridHeight_num = 0;
		var _gridPanelHeight_num = this.mGrid_array[this.mGridCount_num-1].getPosition()["y"];
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
	$(".gridPanel").css("right", _offset_num + "px");

	$("html").addClass("vScrollOn");
}

GridControl.prototype.onClick = function(pObj)
{
	$("html").css("overflow-y", "hidden");

	var _history_state_href = $("body").data("album_path") + "/" + pObj.getSlug();
	var _scrollTop = $(window).scrollTop();
	var _fromX_num = 0;
	var _fromY_num = 0;
	var _toX_num = 0;
	var _toY_num = 0;
	var _toWidth_num = 0;
	var _toHeight_num = 0;
	var _zoomFactor = 0;

	this.mActiveGridIndex_num = pObj.getIndex();
	this.mWinWidthBeforeOpen_num = $(window).width();

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
		_toWidth_num = Math.round($(window).width() * _zoomFactor);

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

	history.pushState(this.mHistState_obj, $(".albumTitle h1").text(), _history_state_href);
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

	if (_activeGridTop_num < 0)
	{
		_activeGridTop_num = 0;
	}

	TweenMax.fromTo(this.mPhotoOverlay.getPhotoContainer(), this.mOverlayPopSpeed_num, {left:_fromX_num, top:_fromY_num, width:this.mPhotoOverlay.getPhotoContainer().width(), height:this.mPhotoOverlay.getPhotoContainer().height(), ease:Back.easeOut}, {left:_toX_num, top:_toY_num, width: _toWidth_num, height: _toHeight_num, ease:Back.easeOut});
	this.mPhotoOverlay.hide(function(){_self.onPhotoOverlayHidden(_activeGridTop_num);});
}

GridControl.prototype.onPhotoOverlayHidden = function(pActiveGridTop_num)
{

	this.mGrid_array[this.mActiveGridIndex_num].setOpacity(1);

	if (this.mWinWidthBeforeOpen_num!=$(window).width())
	{
		//$(window).scrollTop(pActiveGridTop_num);
		$("html, body").stop().animate({scrollTop:pActiveGridTop_num}, '50', 'swing');

	}

	history.pushState(this.mHistState_obj, $(".albumTitle h1").text(), $("body").data("album_path"));
	$("html").css("overflow-y", "auto");
}