/**
 * Created by HerbertHo on 8/16/2016.
 */
$(document).ready
(
    function()
    {
        //TODO: probably move loading stuff to common

        $(window).on("resize", windowOnResized);
        windowOnResized();
    }
);

function windowOnResized()
{
    if ($("#cover").width() < $(".mainPanel").width())
    {
        $("#cover").css("width", "100%");
        $("#cover").css("height", "auto");
    }

    if ($("#cover").height()  < $(".mainPanel").height())
    {
        $("#cover").css("height", "100%");
        $("#cover").css("width", "auto");
    }
}

