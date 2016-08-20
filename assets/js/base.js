$(document).ready
(
    function()
    {
        //TODO: probably move loading stuff to common

        $(window).on("resize", windowOnResized);
        windowOnResized();


        if ($("body").hasClass("sMobile"))
        {
            $("html").addClass("vScrollOn");
        }
        else
        {
            $("html").removeClass("vScrollOn");
        }


    }
);

function windowOnResized()
{
    if ($("#cover").length)
    {
        if ($("#cover").width() < $(".mainPanel").width())
        {
            $("#cover").css("width", "100%");
            $("#cover").css("height", "auto");
        }

        if ($("#cover").height() < $(".mainPanel").height())
        {
            $("#cover").css("height", "100%");
            $("#cover").css("width", "auto");
        }
    }
}


$(window).load(function()
{
    $(".pageLoading").fadeOut(400, function()
    {
        $(".wrapperBase").addClass("show");
    });

})