/**
 * Created by herbert on 7/2/2017.
 */

var mActiveIndex = 7;
var mTweenDurationSliding = 0.7;
var mTweenDurationImgOpacity = 0.2;

$(document).ready(
    function()
    {
        //desktop mode
        if ($("body").hasClass("sDesktop"))
        {
            windowOnResized();
            $(window).on("resize", windowOnResized);

            $(".navigator .btn_prev").on("click", function(pEvent)
            {
               pEvent.preventDefault();
            });

            $(".navigator .btn_next").on("click", function(pEvent)
            {
                pEvent.preventDefault();

                var _timeLineCarousel = new TimelineLite();
                var _timeLineImageOpacity = new TimelineLite();

                var _currentItem = $(".featuredList img:eq(" + mActiveIndex + ")");
                var _nextItem =  $(".featuredList img:eq(" + (mActiveIndex+1) + ")");
                var _moveDistance = Math.round(_nextItem.width());
                var _currentLeft = $(".featuredList").position().left;
                _timeLineCarousel.to($(".featuredList"),mTweenDurationSliding,{css:{left: (_currentLeft - _moveDistance) + "px"},ease:Circ.easeOut});
                _timeLineImageOpacity.to(_currentItem, mTweenDurationImgOpacity, {css:{opacity:0.3},ease:Circ.easeOut})
                         .to(_nextItem, mTweenDurationImgOpacity, {css:{opacity:1},ease:Circ.easeIn});

                mActiveIndex++;

            });
        }
    }
)

function windowOnResized()
{
    var _winHeight = $(window).height();
    var _accumulatedWidth = 0;

    var _winWidthMidPoint = $(window).width() * 0.5;

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

            var _expectedActiveLeftPos = _winWidthMidPoint - _currentWidth * 0.5;
            var _diff = _expectedActiveLeftPos - _accumulatedWidth;
            $(".featuredList").css("left", _diff + "px");
        }

        _accumulatedWidth += _currentWidth;

    });
}