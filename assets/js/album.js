var mPhotoOverlay = null;
var mGridControl = null;
var mWinWidth = $(window).width();

$(document).ready
(
    function()
    {
        mPhotoOverlay = new PhotoOverlay($(".photoZoomOverlay"));
        mPhotoOverlay.initBreakPoints(mBaseBreakPoint_array, mWideScreenBreakPoint_num);
        mGridControl = new GridControl($(".gridPanel"), mPhotoOverlay);
        mGridControl.initBreakPoints(mBaseBreakPoint_array, mWideScreenBreakPoint_num);

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
        }

        $(window).on("resize", windowOnResized);
    }
);

function windowOnResized() {
    mPhotoOverlay.centerPhoto();

    //on tablets, scrolling will trigger resize events.. so
    //check window width has actually changed and it's not just iOS triggering a resize event on scroll

    if ($(window).width() != mWinWidth) {

        // Update the window width for next time
        mWinWidth = $(window).width();

        if (mWinWidth >= 0 && mWinWidth <= mBaseBreakPoint_array[1]) {
            mGridControl.updateDensity("low");
            $(".menuContainer").removeClass("menuTransition");
            $(".albumTitle").css("height", $(".albumTitle h1").outerHeight() + "px");
            $(".menuContainer").css("top", $(".albumTitle").height() + "px");
            $(".infoPanel").css("height", "auto");
        }
        else if (mWinWidth > mBaseBreakPoint_array[1] && mWinWidth <= mWideScreenBreakPoint_num) {
            mGridControl.updateDensity("medium");
            $(".albumTitle").css("height", "auto");
        }
        else {
            mGridControl.updateDensity("high");
            $(".albumTitle").css("height", "auto");
        }
    }
    else {
        mGridControl.updateDensity("medium");
        $(".albumTitle").css("height", "auto");
    }


    mGridControl.positionGrids();

}
