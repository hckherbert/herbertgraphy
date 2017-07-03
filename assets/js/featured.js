/**
 * Created by herbert on 7/2/2017.
 */

var mActiveIndex = 7;
var mTweenDurationSliding = 0.7;
var mTweenDurationImgOpacity = 0.2;
var mWinWidthMidPoint = 0;
var mTotalSlide = 0;
var mIsSliding = false;

$(document).ready(
    function()
    {
        //desktop mode
        if ($("body").hasClass("sDesktop"))
        {
            mTotalSlide = $(".featuredList img").length;
            windowOnResized();
            $(window).on("resize", windowOnResized);

            $(".navigator .btn_prev").on("click", function(pEvent)
            {
               pEvent.preventDefault();
            });

            $(".navigator .btn_next").on("click", function(pEvent)
            {
                pEvent.preventDefault();

                if (mTotalSlide == mActiveIndex+1 || mIsSliding)
                {
                    return;
                }

                mIsSliding = true;

                var _timeLineCarousel = new TimelineLite();
                var _timeLineImageOpacity = new TimelineLite();

                var _currentItem = $(".featuredList img:eq(" + mActiveIndex + ")");
                var _nextItem = $(".featuredList img:eq(" + (mActiveIndex + 1) + ")");
                var _currentLeft = $(".featuredList").position().left;

                //shift half the currentItem width first
                var _nextItemToLeft = _currentLeft  - _currentItem.width()* 0.5;
                //The shift half the targetItem width
                var _targetLeftPos = _nextItemToLeft - _nextItem.width()* 0.5;

                _timeLineCarousel.to($(".featuredList"),mTweenDurationSliding,{css:{left:  _targetLeftPos + "px"},ease:Circ.easeOut, onComplete: onSlideComplete});
                _timeLineImageOpacity.to(_currentItem, mTweenDurationImgOpacity, {css:{opacity:0.3},ease:Circ.easeOut})
                         .to(_nextItem, mTweenDurationImgOpacity, {css:{opacity:1},ease:Circ.easeIn});

                mActiveIndex++;

                if (mTotalSlide == mActiveIndex+1)
                {
                    $(this).addClass("disable");
                }
                else
                {
                    $(this).removeClass("disable");
                }

            });


            $(".navigator .btn_prev").on("click", function(pEvent)
            {
                pEvent.preventDefault();

                if (mActiveIndex == 0 || mIsSliding)
                {
                    return;
                }

                mIsSliding = true;

                var _timeLineCarousel = new TimelineLite();
                var _timeLineImageOpacity = new TimelineLite();

                var _currentItem = $(".featuredList img:eq(" + mActiveIndex + ")");
                var _nextItem = $(".featuredList img:eq(" + (mActiveIndex - 1) + ")");
                var _currentLeft = $(".featuredList").position().left;

                //shift half the currentItem width first
                var _prevItemToLeft = _currentLeft  + _currentItem.width()* 0.5;
                //The shift half the targetItem width
                var _targetLeftPos = _prevItemToLeft + _nextItem.width()* 0.5;

                _timeLineCarousel.to($(".featuredList"),mTweenDurationSliding,{css:{left:  _targetLeftPos + "px"},ease:Circ.easeOut, onComplete: onSlideComplete});
                _timeLineImageOpacity.to(_currentItem, mTweenDurationImgOpacity, {css:{opacity:0.3},ease:Circ.easeOut})
                    .to(_nextItem, mTweenDurationImgOpacity, {css:{opacity:1},ease:Circ.easeIn});

                mActiveIndex--;

                if (mActiveIndex == 0)
                {
                    $(this).addClass("disable");
                }
                else
                {
                    $(this).removeClass("disable");
                }

            });
        }
    }
)

function windowOnResized()
{
    var _winHeight = $(window).height();
    var _accumulatedWidth = 0;

    mWinWidthMidPoint = $(window).width() * 0.5;

    $(".featuredList img").each(function (i, e)
    {
        if (i == 0)
        {
            $(e).css("left", "0");
        }
        else
        {
            $(e).css("left", _accumulatedWidth + "px");
        }

        var _currentWidth = Math.round(_winHeight * parseInt($(e).data("width")) / parseInt($(e).data("height")));

        if (i == mActiveIndex)
        {
            $(e).css("opacity", "1");

            var _expectedActiveLeftPos = mWinWidthMidPoint - _currentWidth * 0.5;
            var _diff = _expectedActiveLeftPos - _accumulatedWidth;
            $(".featuredList").css("left", _diff + "px");
        }

        _accumulatedWidth += _currentWidth;

    });
}

function onSlideComplete()
{
    mIsSliding = false;
}