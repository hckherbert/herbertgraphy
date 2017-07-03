/**
 * Created by herbert on 7/2/2017.
 */
$(document).ready(
    function()
    {
        //desktop mode
        if ($("body").hasClass("sDesktop"))
        {
            windowOnResized();
            $(window).on("resize", windowOnResized);
        }
    }
)

function windowOnResized()
{
    var _winHeight = $(window).height();
    var _accumulatedWidth = 0;
    var _activeIndex = 7;
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

        if (i == _activeIndex)
        {
            $(e).css("opacity", "1");

            var _expectedActiveLeftPos = _winWidthMidPoint - _currentWidth * 0.5;
            var _diff = _expectedActiveLeftPos - _accumulatedWidth;
            $(".featuredList").css("left", _diff + "px");
        }

        _accumulatedWidth += _currentWidth;

    });
}