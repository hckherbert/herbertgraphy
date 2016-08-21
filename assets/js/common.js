/**
 * Created by herbert on 8/6/2016.
 */

var mResponsive = null;
var mBaseBreakPoint_array  = [0,768];
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
        $(".btnMenuToggle").toggleClass("btnMenuToggleRotate");

        $(".menuContainer").addClass("menuTransition");

        $(".menuContainer").css("top", $(".albumTitle").height() + "px");

        $(".menuContainer").toggleClass("mainMenuClose");
        $(".menuMask").toggleClass("show");

    }
}

function closeMenu()
{
    $(".menuContainer").addClass("mainMenuClose");
    $(".menuMask").removeClass("show");
}
