Grid.prototype.mGrid = null;
Grid.prototype.mIndex_num = -1;
Grid.prototype.mOrientation_str = "";
Grid.prototype.mIsHighlight = false;
Grid.prototype.mDesc_str = null;
 

function Grid(pGrid)
{
	this.mGrid = pGrid;
}

Grid.prototype.setSize = function(pWidth_num, pHeight_num)
{
	var _self = this;
	
	this.mGrid.css("width", pWidth_num + "px");
	this.mGrid.css("height", pHeight_num + "px");	
	
	this.mDesc_str =  $(".desc", this.mGrid).text();
	
	this.mGrid.on("mouseover", function() { _self.onMouseOver();});
	this.mGrid.on("mouseout", function() { _self.onMouseOut();});
}

Grid.prototype.getSize = function()
{
	var _width = this.mGrid.width();
	var _height = this.mGrid.height();
	return {"width": _width, "height": _height};
}

Grid.prototype.setPosition = function(pLeft_num, pTop_num)
{
	this.mGrid.css("left", pLeft_num + "px");
	this.mGrid.css("top", pTop_num + "px");
}

Grid.prototype.getPosition = function()
{
	var _x = this.mGrid.position().left;
	var _y = this.mGrid.position().top;
	return {"x": _x, "y": _y};
}

Grid.prototype.getFileName = function()
{
	console.log("getFileName: "  + this.mGrid.attr("data-filename"));
	return this.mGrid.attr("data-filename");
}

Grid.prototype.centerImageVertically = function()
{
	this.mGrid.find("img").css("top", -0.5 * (this.mGrid.find("img").height() - this.mGrid.height()) + "px");

}

Grid.prototype.getElement = function()
{
	return this.mGrid;
}

Grid.prototype.setIndex = function(pIndex_num)
{
	this.mIndex_num = pIndex_num;
}

Grid.prototype.getIndex = function()
{
	return this.mIndex_num;
}

Grid.prototype.setOrientation =  function(pOrientation_str)
{
	this.mOrientation_str = pOrientation_str;
}

Grid.prototype.getOrientation =  function()
{
	return this.mOrientation_str;
}

Grid.prototype.setHighlight =  function(pIsHighlight)
{
	this.mIsHighlight = pIsHighlight
}

Grid.prototype.isHighlight =  function()
{
	return this.mIsHighlight;
}

Grid.prototype.getDesc = function()
{
	return this.mDesc_str;
}

Grid.prototype.addEventListener =  function(pEvent_str, pCallBack_fn)
{
	var _self = this;
	this.mGrid.on(pEvent_str, function() { _self.mGrid.css("opacity", 0.5); pCallBack_fn.apply(null)});
}

Grid.prototype.onMouseOver = function()
{
	$(".titleOverlay", this.mGrid).addClass("titleOverlayShow");
	$(".title",  this.mGrid).css("width",   this.mGrid.width() - 20 + "px");
}

Grid.prototype.onMouseOut = function()
{
	$(".titleOverlay", this.mGrid).removeClass("titleOverlayShow");
}
 


 