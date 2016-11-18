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
    if ($("#cover").length)
    {
        if ($("body").hasClass("sDesktop"))
        {
            $("#cover").css("position", "absolute");

            if ($("#cover").width() < $(".mainPanel").width()) {
                $("#cover").css("width", "100%");
                $("#cover").css("height", "auto");
            }
            if ($("#cover").height() < $(".mainPanel").height()) {
                $("#cover").css("height", "100%");
                $("#cover").css("width", "auto");
            }
        }
        else
        {
            $("#cover").css("height", "auto");
            $("#cover").css("width", "100%");
            $("#cover").css("position", "relative");
        }
    }

    if ($(".albumTitle:visible").outerHeight() + $(".menuContainer:visible").outerHeight() +  $(".footer").height() > $(window).height())
    {
        $("html").addClass("vScrollOn");

        if ($("body").hasClass("sDesktop"))
        {
            $(".mainPanel").css("position", "fixed");
            $(".mainPanel").css("left", "35%");
        }
        else
        {
            $(".mainPanel").css("position", "relative");
            $(".mainPanel").css("left", "0");
        }

    }

    if (!$(".section_about ").length)
    {
        if ($("body").hasClass("sMobile")) {
            $(".sMobile .mainMenuClose").css("top", -1 * $(".menuContainer").outerHeight() + "px");
            $("html").addClass("vScrollOn");
        }
        else {
            $("html").removeClass("vScrollOn");
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