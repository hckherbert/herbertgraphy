/**
 * Created by herbert on 8/6/2016.
 */

var mResponsive = null;
var mBaseBreakPoint_array  = [0,768];
var mMediumBreakPoint_num = 1440;
var mWideScreenBreakPoint_num = 1680;

$(document).ready(
    function()
    {
        commonSetUpResponsive();
        commonBindUIEvents();
    }
);

function commonSetUpResponsive()
{
    mResponsive = new Responsive();
    mResponsive.init(["sMobile", "sDesktop"], mBaseBreakPoint_array, mWideScreenBreakPoint_num);
}

function commonBindUIEvents()
{
    $(".sMobile .mainMenuClose").css("top", -1 * $(".menuContainer").outerHeight() + "px");
    $(".btnMenuToggle").on("click", toggleMenu);
    $(document).on("responsive", closeMenu);
}

function toggleMenu(pEvent)
{
    pEvent.preventDefault();

    if ($("body").hasClass("sDesktop"))
    {
       $(".albumTitle").css("height", "auto");
    }
    else
    {

        $(".menuContainer").addClass("menuTransition");

        $(".menuContainer").css("top", $(".albumTitle").height() + "px");

        $(".menuContainer").toggleClass("mainMenuClose");

        if ($(".menuContainer").hasClass("mainMenuClose"))
        {
            $(".menuContainer").css("top", -1 * $(".menuContainer").height() + "px");
            $(".btnMenuToggle").removeClass("hvr-grow-rotate");
        }
        else
        {
            $(".btnMenuToggle").addClass("hvr-grow-rotate");
        }

        $(".menuMask").toggleClass("show");

    }
}

function closeMenu()
{
    $(".menuContainer").addClass("mainMenuClose");
    $(".menuMask").removeClass("show");
}
