PhotoOverlay.prototype.mPhotoOverlay = null;
PhotoOverlay.prototype.mPhotoContainer = null;
PhotoOverlay.prototype.mOrientation_str = null;
PhotoOverlay.prototype.mAspectRatio_num = null;
PhotoOverlay.prototype.mOnHideStart_fn = null;
PhotoOverlay.zoomFactor = 0.85;

function PhotoOverlay(pPhotoOverlay)
{
	var _self = this;
	this.mPhotoOverlay = pPhotoOverlay;
	this.mPhotoContainer = $(".photoContainer", this.mPhotoOverlay);

	$(".btnClose , this.mPhotoOverlay").on("click", function(){_self.readyHide();});
	$(".bg", this.mPhotoOverlay).on("click", function(){_self.readyHide();})

	$(window).on("resize", function()
	{
		_self.centerPhoto();
	});
}

PhotoOverlay.prototype.show = function(pSpeed_num, pFileName_str, pFileZoomSize, pDesc_str)
{
	var _self =  this;
	//REMARK: ADD ON LOAD CALLBACK...
	$(".photo", this.mPhotoContainer).remove();
	$(".desc", this.mPhotoOverlay).text(pDesc_str);
	this.mPhotoContainer.prepend("<img class='photo' src='" + pFileName_str + "_" + pFileZoomSize + ".jpg' >");
	
	console.log("overlay show");
	
	this.mPhotoOverlay.show();
	this.mPhotoOverlay.addClass("show");
	this.centerPhoto();
	
	setTimeout
	( 
		function()
		{
			var _toHeight_num =  $(".desc", _self.mPhotoOverlay).outerHeight() ;
			
			$(".btnClose , this.mPhotoOverlay").show();
			$(".descContainer", _self.mPhotoOverlay).show();
			$(".descContainer", _self.mPhotoOverlay).css("height", $(".desc", _self.mPhotoOverlay).outerHeight() + "px");
			$(".descContainer", _self.mPhotoOverlay).css("top", $(".photo", _self.mPhotoContainer).height() - $(".descContainer", _self.mPhotoOverlay).height() + "px");
		},
		500
	);

}

PhotoOverlay.prototype.readyHide = function()
{	
	$(".btnClose , this.mPhotoOverlay").hide();
	$(".descContainer", this.mPhotoOverlay).hide();
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
			_self.mPhotoOverlay.hide();
			pCallBack_fn.apply(null);
		},
		500
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
	var _toWidth_num;
	var _toHeight_num;

	if ($(window).width() <= $(window).height())
	{
		_toWidth_num = Math.round($(window).width() * PhotoOverlay.zoomFactor);

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
		_toHeight_num = Math.round($(window).height() * PhotoOverlay.zoomFactor);


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
	this.mPhotoContainer.css("top", Math.round(0.5* ($(window).height() - this.mPhotoContainer.height())) + "px");
	this.mPhotoContainer.css("left", Math.round(0.5* ($(window).width() - this.mPhotoContainer.width())) + "px");
	
	$(".descContainer", this.mPhotoOverlay).css("height", $(".desc", this.mPhotoOverlay).outerHeight() + "px");
	$(".descContainer", this.mPhotoOverlay).css("top", $(".photo", this.mPhotoContainer).height() - $(".descContainer", this.mPhotoOverlay).height() + "px");
	
}