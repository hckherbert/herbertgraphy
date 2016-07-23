PhotoOverlay.prototype.mPhotoOverlay = null;
PhotoOverlay.prototype.mPhotoContainer = null;
PhotoOverlay.prototype.mOrientation_str = null;
PhotoOverlay.prototype.mAspectRatio_num = null;
PhotoOverlay.prototype.mOnHideStart_fn = null;
PhotoOverlay.prototype.mBaseBreakPoint_array = null;
PhotoOverlay.prototype.mWideScreenBreakPoint_num = null;
PhotoOverlay.zoomFactorDesktop = 0.85;
PhotoOverlay.zoomFactorMobile = 0.7;

function PhotoOverlay(pPhotoOverlay)
{
	var _self = this;
	this.mPhotoOverlay = pPhotoOverlay;
	this.mPhotoContainer = $(".photoContainer", this.mPhotoOverlay);

	$(".btnClose" , this.mPhotoOverlay).on("click", function(){_self.readyHide();});
	$(".bg", this.mPhotoOverlay).on("click", function(){_self.readyHide();})
}

PhotoOverlay.prototype.initBreakPoints = function(pBaseBreakPoint_array, pWideScreenBreakPoint_num)
{
	this.mBaseBreakPoint_array = pBaseBreakPoint_array;
	this.mWideScreenBreakPoint_num = pWideScreenBreakPoint_num;
}

PhotoOverlay.prototype.show = function(pSpeed_num, pFileName_str, pFileZoomSize, pDesc_str, pTitle_str)
{
	var _self =  this;
	//REMARK: ADD ON LOAD CALLBACK...
	$(".photo", this.mPhotoContainer).remove();
	$(".desc", this.mPhotoOverlay).text(pDesc_str);
	$(".title", this.mPhotoOverlay).text(pTitle_str);

	if (pDesc_str == "")
	{
		$(".title", this.mPhotoOverlay).addClass("titleOnly");
		$(".desc", this.mPhotoOverlay).addClass("hide");
	}
	else
	{
		$(".title", this.mPhotoOverlay).removeClass("titleOnly");
		$(".desc", this.mPhotoOverlay).removeClass("hide");
	}

	if (pTitle_str == "")
	{
		$(".title", this.mPhotoOverlay).addClass("hide");
	}
	else
	{
		$(".title", this.mPhotoOverlay).removeClass("hide");
	}

	this.mPhotoContainer.prepend("<img class='photo' src='" + pFileName_str + "_" + pFileZoomSize + ".jpg' >");
	this.mPhotoOverlay.show();
	this.mPhotoOverlay.addClass("show");
	this.centerPhoto();

	setTimeout
	( 
		function()
		{
			$(".btnClose" , _self.mPhotoOverlay).show();
			if (pDesc_str!="" || pTitle_str!="")
			{
				$(".descContainer", _self.mPhotoOverlay).addClass("show");
			}

			$(".photoContainer").css("top", 0.5*($(window).height() - ($(".photoContainer .photo").height() + $(".descContainer", _self.mPhotoOverlay).height())))
		},
		500
	);


}

PhotoOverlay.prototype.readyHide = function()
{	
	$(".btnClose" , this.mPhotoOverlay).hide();
	//$(".descContainer", this.mPhotoOverlay).hide();
	this.mOnHideStart_fn.apply(null);
}

PhotoOverlay.prototype.hide = function(pCallBack_fn)
{	
	var _self = this;
	
	this.mPhotoOverlay.removeClass("show");
	
	setTimeout
	(
		function()
		{
			$(".descContainer", _self.mPhotoOverlay).removeClass("show");
			_self.mPhotoOverlay.hide();
			pCallBack_fn.apply(null);
		},
		150
	)

}

PhotoOverlay.prototype.setSizeData = function(pOrientation_str, pAspectRatio_num)
{
	this.mOrientation_str = pOrientation_str;
	this.mAspectRatio_num = pAspectRatio_num;
}

PhotoOverlay.prototype.setOnHideStart = function(pOnHideStart_fn)
{
	this.mOnHideStart_fn = pOnHideStart_fn;
}


PhotoOverlay.prototype.getPhotoPosition = function()
{
	var _x = this.mPhotoContainer.position().left;
	var _y = this.mPhotoContainer.position().top;
	return {"x": _x, "y": _y};
}

PhotoOverlay.prototype.getPhotoContainer = function()
{
	return this.mPhotoContainer;
}

PhotoOverlay.prototype.centerPhoto = function()
{
	var _toWidth_num = 0;
	var _toHeight_num = 0;
	var _zoomFactor = 0;

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

		if (this.mOrientation_str == "h")
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

		if (this.mOrientation_str == "h")
		{
			_toWidth_num = Math.round(_toHeight_num * this.mAspectRatio_num);
		}
		else
		{
			_toWidth_num = Math.round(_toHeight_num / this.mAspectRatio_num);
		}
	}
	this.mPhotoContainer.css("width", _toWidth_num + "px");
	this.mPhotoContainer.css("height", _toHeight_num + "px");
	this.mPhotoContainer.css("left", Math.round(0.5* ($(window).width() - this.mPhotoContainer.width())) + "px");
	this.mPhotoContainer.css("top", 0.5*($(window).height() - ($(".photoContainer .photo").height() + $(".descContainer", this.mPhotoOverlay).height())));
	
}