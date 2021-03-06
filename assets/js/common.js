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

    if ($(window).width() < mBaseBreakPoint_array[1])
    {
        $(".btnMenuToggle").on("mouseover", function()
        {
            $(this).addClass("hvr-grow-rotated");
        }).on("mouseout", function()
        {
            $(this).removeClass("hvr-grow-rotated");
        })
    }


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
            $(".btnMenuToggle").removeClass("hvr-grow-rotated");
            $(".homeSubTitle_b, .homeSubTitle_a").css("z-index", 1);


            if ($(".section_about").length)
            {
                $(".aboutContainer").removeClass("inactive");
                $(".bg").removeClass("inactive");
            }
        }
        else
        {
            $(".btnMenuToggle").addClass("hvr-grow-rotated");
            $(".homeSubTitle_b, .homeSubTitle_a").css("z-index", 0);

            if ($(".section_about").length)
            {
                $(".aboutContainer").addClass("inactive");
                $(".bg").addClass("inactive");
            }
        }

        $(".menuMask").toggleClass("show");

    }
}

function closeMenu()
{
    $(".menuContainer").addClass("mainMenuClose");
    $(".menuMask").removeClass("show");
    $(".bg").removeClass("inactive");
    $(".aboutContainer").removeClass("inactive");
}


function  whichTransitionEvent(){
    var t,
        el = document.createElement("fakeelement");

    var transitions = {
        "transition"      : "transitionend",
        "OTransition"     : "oTransitionEnd",
        "MozTransition"   : "transitionend",
        "WebkitTransition": "webkitTransitionEnd"
    }

    for (t in transitions){
        if (el.style[t] !== undefined){
            return transitions[t];
        }
    }
}
