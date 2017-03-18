var mPhotoOverlay = null;
var mGridControl = null;
var mWinWidth = 0;

$(document).ready
(
    function()
    {

        mPhotoOverlay = new PhotoOverlay($(".photoZoomOverlay"));
        mPhotoOverlay.initBreakPoints(mBaseBreakPoint_array, mMediumBreakPoint_num,mWideScreenBreakPoint_num);
        mGridControl = new GridControl($(".gridPanel"), mPhotoOverlay);
        mGridControl.initBreakPoints(mBaseBreakPoint_array, mMediumBreakPoint_num, mWideScreenBreakPoint_num);

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
            else if ($(window).width() >= mMediumBreakPoint_num)
            {
                mGridControl.updateDensity("higher");
            }
            else
            {
                mGridControl.updateDensity("medium");
            }
        }

        renderIntro();

        $(window).on("resize", windowOnResized);
    }
);

function windowOnResized()
{

    mPhotoOverlay.centerPhoto();

    //on tablets, scrolling will trigger resize events.. so
    //check window width has actually changed and it's not just iOS triggering a resize event on scroll
    if ($(window).width() != mWinWidth )
    {
        // Update the window width for next time
        mWinWidth = $(window).width();

        if (mWinWidth >= 0 && mWinWidth < mBaseBreakPoint_array[1]) {
            mGridControl.updateDensity("low");
            $(".menuContainer").removeClass("menuTransition");
            $(".albumTitle").css("height", $(".albumTitle h1").outerHeight() + "px");
            $(".menuContainer").css("top", $(".albumTitle").height() + "px");
            $(".infoPanel").css("height", "auto");
        }
        else if (mWinWidth <= mMediumBreakPoint_num) {
            mGridControl.updateDensity("medium");
            $(".albumTitle").css("height", "auto");
        }
        else if ( mWinWidth <= mWideScreenBreakPoint_num) {
            mGridControl.updateDensity("higher");
            $(".albumTitle").css("height", "auto");
        }
        else {
            mGridControl.updateDensity("high");
            $(".albumTitle").css("height", "auto");
        }
    }
    
    mGridControl.positionGrids();

}

function renderIntro()
{
    if ($(".infoPanel p").text().length >= 100)
    {
        $(".infoPanel .intro p").addClass("hasInitialCap");
    }

}
