$(document).ready(
    function()
    {
        if ($("body").hasClass("sMobile"))
        {
            $("html").addClass("vScrollOn");
        }
        else
        {
            $("html").removeClass("vScrollOn");
        }

    }
)
