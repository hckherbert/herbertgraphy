Responsive.prototype.mLayoutLabel_array = null;
Responsive.prototype.mLayoutBreakPoints_array = null;
Responsive.prototype.mEventResponsive = null;
Responsive.prototype.mEventWideScreenBreak = null;
Responsive.prototype.mWideScreenPoint_num = 1680;

function Responsive()
{

}

Responsive.prototype.init = function(pLalayoutLabel_array, pLayoutBreakPoints_array, pWideScreenPoint_num)
{
	var _self = this;
	
	this.mEventResponsive = jQuery.Event("responsive");
	this.mEventWideScreenBreak = jQuery.Event("wideScreenBreak");
	this.mLayoutLabel_array = pLalayoutLabel_array;
	this.mLayoutBreakPoints_array = pLayoutBreakPoints_array;
	this.mWideScreenPoint_num = pWideScreenPoint_num;
	
	$(window).on
	(	
		"resize", 
		function()
		{
			_self.windowOnResized();
		}
	);
	
	this.windowOnResized();
}


Responsive.prototype.windowOnResized = function()
{
	this.updateClass();
	
	if ($(window).width() >= this.mWideScreenPoint_num)
	{
		this.mEventWideScreenBreak.isWideScreen = true;
	}
	else
	{
		this.mEventWideScreenBreak.isWideScreen = false;
	}
	
	$(document).trigger(this.mEventWideScreenBreak);
}

Responsive.prototype.updateClass = function()
{
	var _currentLayout_str = this.mLayoutLabel_array[0];
 
	var _i = 0;
	var _j = 0;
	
	for (_i = 0; _i < this.mLayoutLabel_array.length; _i++)
	{
		if (this.mLayoutBreakPoints_array[_i] > $(window).width()) {
			break;
		} else {
			_currentLayout_str = this.mLayoutLabel_array[_i];
		}
	}
	
	if (!$("body").hasClass(_currentLayout_str))
	{
		for (_j = 0; _j < this.mLayoutLabel_array.length; _j++) 
		{
			$("body").removeClass(this.mLayoutLabel_array[_j]);
			$("body").find("." + this.mLayoutLabel_array[_j]).addClass("hide");
		}
		
		$("." + _currentLayout_str).removeClass("hide");
		$("body").addClass(_currentLayout_str);
		
		this.mEventResponsive.layout = _currentLayout_str;
		$(document).trigger(this.mEventResponsive);
	}
}


