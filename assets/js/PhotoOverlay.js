PhotoOverlay.prototype.mPhotoOverlay = null;
PhotoOverlay.prototype.mPhotoContainer = null;
PhotoOverlay.prototype.mOrientation_str = null;
PhotoOverlay.prototype.mAspectRatio_num = null;
PhotoOverlay.prototype.mOnHideStart_fn = null;

function PhotoOverlay(pPhotoOverlay)
{
	var _self = this;
	this.mPhotoOverlay = pPhotoOverlay;
	this.mPhotoContainer = $(".photoContainer", this.mPhotoOverlay);

	$(".btnClose , this.mPhotoOverlay").on("click", function(){_self.readyHide();});
	$(".bg", this.mPhotoOverlay).on("click", function(){_self.readyHide();});
}

PhotoOverlay.prototype.show = function(pSpeed_num, pFileName_str, pDesc_str)
{
	var _self =  this;
	//REMARK: ADD ON LOAD CALLBACK...
	$(".photo", this.mPhotoContainer).remove();
	$(".desc", this.mPhotoOverlay).text(pDesc_str);
	this.mPhotoContainer.prepend("<img class='photo' src='" + pFileName_str + "' >");
	
	console.log("overlay show");
	
	this.mPhotoOverlay.show();
	this.mPhotoOverlay.addClass("show");
	
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

	if (this.mOrientation_str == "h")
	{	
		this.mPhotoContainer.css("width", Math.round($(window).width()*0.7) + "px");
		this.mPhotoContainer.css("top", Math.round(0.5* ($(window).height() -  Math.round(this.mPhotoContainer.width() / this.mAspectRatio_num))) + "px");
	}
	else if (this.mOrientation_str == "v")
	{
		this.mPhotoContainer.css("height", Math.round($(window).height()*0.7) + "px");
		this.mPhotoContainer.css("width", this.mPhotoContainer.height()/ this.mAspectRatio_num +  "px");
		this.mPhotoContainer.css("top", Math.round(0.5* ($(window).height() - this.mPhotoContainer.height())) + "px");
	}
	
	this.mPhotoContainer.css("left", Math.round(0.5* ($(window).width() - this.mPhotoContainer.width())) + "px");
	
	$(".descContainer", this.mPhotoOverlay).css("height", $(".desc", this.mPhotoOverlay).outerHeight() + "px");
	$(".descContainer", this.mPhotoOverlay).css("top", $(".photo", this.mPhotoContainer).height() - $(".descContainer", this.mPhotoOverlay).height() + "px");
	
}