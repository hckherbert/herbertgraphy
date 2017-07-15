/**
 * Created by herbert on 7/2/2017.
 */

var mActiveIndex = 6; //Note now mActiveIndex is ONE based, not ZERO based for text animation
var mTweenDurationSliding = 0.6;
var mTweenDurationImgOpacity = 0.2;
var mTweenDurationTitle = 0.2;
var mTweenStoryContent = 0.3;
var mWinWidthMidPoint = 0;
var mTotalSlide = 0;
var mIsSliding = false;
var wordArray = [];
var words = document.getElementsByClassName("title");
var currentWord =  (mActiveIndex > 0) ? mActiveIndex -1 : 0;
var mSlideDirection = "";
var mTimeLineStoryContent = null;
var mContentHeightAtAbsolutePos = 0;
var mFeaturedListHeightOnMobile = 0;

$(document).ready(
    function()
    {
        //desktop mode
        if ($("body").hasClass("sDesktop"))
        {

            $(".navigator .btn_next").on("click", function(pEvent)
            {
                pEvent.preventDefault();

                if (mTotalSlide == mActiveIndex || mIsSliding)
                {
                    return;
                }

                mIsSliding = true;
                mSlideDirection = "next";

                var _timeLineCarousel = new TimelineLite();
                var _timeLineImageOpacity = new TimelineLite();
                var _timeLineTitle = new TimelineLite();

                var _currentItem = $(".featuredList .imgItem:eq(" + (mActiveIndex -1 ) + ")");
                var _nextItem = $(".featuredList .imgItem:eq(" + mActiveIndex + ")");

                var _accumulatedWidth = 0;
                var _winHeight = $(window).height();
                var _diff = 0;

                $(".featuredList .imgItem").each(function (i, e)
                {
                    var _currentWidth = Math.round(_winHeight * parseInt($(e).find("img").data("width")) / parseInt($(e).find("img").data("height")));

                    if (i == mActiveIndex)
                    {
                        var _expectedActiveLeftPos = mWinWidthMidPoint - Math.round(_currentWidth * 0.5);
                        _diff = _expectedActiveLeftPos - _accumulatedWidth;
                        return;
                    }

                    _accumulatedWidth += _currentWidth;

                });

                _timeLineCarousel.to($(".featuredList"), mTweenDurationSliding,{css:{left:  _diff + "px"},ease:Circ.easeOut, onComplete: onSlideComplete});
                _timeLineImageOpacity.to(_currentItem, mTweenDurationImgOpacity, {css:{opacity:0.3},ease:Circ.easeOut})
                         .to(_nextItem, mTweenDurationImgOpacity, {css:{opacity:1},ease:Circ.easeIn});

                _timeLineTitle.to($(".title:eq("  + mActiveIndex + ")"), mTweenDurationTitle, {css:{opacity:0},ease:Circ.easeIn});
                mTimeLineStoryContent = TweenMax.to($(".content"), mTweenStoryContent, {css:{left:"-400px", opacity:0},ease: Expo.easeInOut});
                TweenLite.delayedCall(0.3, reverseStoryContentTween);

                mActiveIndex++;

                if (mTotalSlide == mActiveIndex)
                {
                    $(this).addClass("disable");
                }
                else
                {
                    $(this).removeClass("disable");
                }

                $(".navigator .btn_prev").removeClass("disable");

            });


            $(".navigator .btn_prev").on("click", function(pEvent)
            {
                pEvent.preventDefault();

                if (mActiveIndex == 1 || mIsSliding)
                {
                    return;
                }

                mIsSliding = true;
                mSlideDirection = "prev";

                var _timeLineCarousel = new TimelineLite();
                var _timeLineImageOpacity = new TimelineLite();
                var _timeLineTitle = new TimelineLite();

                var _currentItem = $(".featuredList .imgItem:eq(" + (mActiveIndex -1) + ")");
                var _nextItem = $(".featuredList .imgItem:eq(" + (mActiveIndex -2) + ")");

                var _accumulatedWidth = 0;
                var _winHeight = $(window).height();
                var _diff = 0;

                $(".featuredList .imgItem").each(function (i, e)
                {
                    var _currentWidth = Math.round(_winHeight * parseInt($(e).find("img").data("width")) / parseInt($(e).find("img").data("height")));

                    if (i == mActiveIndex-2)
                    {
                        var _expectedActiveLeftPos = mWinWidthMidPoint - Math.round(_currentWidth * 0.5);
                        _diff = _expectedActiveLeftPos - _accumulatedWidth;
                        return;
                    }

                    _accumulatedWidth += _currentWidth;

                });

                _timeLineCarousel.to($(".featuredList"),mTweenDurationSliding,{css:{left:  _diff + "px"},ease:Circ.easeOut, onComplete: onSlideComplete});
                _timeLineImageOpacity.to(_currentItem, mTweenDurationImgOpacity, {css:{opacity:0.3},ease:Circ.easeOut})
                    .to(_nextItem, mTweenDurationImgOpacity, {css:{opacity:1},ease:Circ.easeIn});

                _timeLineTitle.to($(".title:eq("  + mActiveIndex + ")"), mTweenDurationTitle, {css:{opacity:0},ease:Circ.easeIn});
                mTimeLineStoryContent = TweenMax.to($(".content"), mTweenStoryContent, {css:{left:"-400px", opacity:0},ease: Expo.easeOut});
                TweenLite.delayedCall(0.3, reverseStoryContentTween);

                mActiveIndex--;

                if (mActiveIndex == 1)
                {
                    $(this).addClass("disable");
                }
                else
                {
                    $(this).removeClass("disable");
                }

                $(".navigator .btn_next").removeClass("disable");

            });

            if (mActiveIndex == mTotalSlide)
            {
                $(".navigator .btn_next").addClass("disable");
            }
            else if (mActiveIndex == 1)
            {
                $(".navigator .btn_prev").addClass("disable");
            }
        }
        //Mobile mode
        else
        {
            $(".featuredList").css("height", $(window).height()*0.7);
        }

        mTotalSlide = $(".featuredList .imgItem").length;
        windowOnResized();
        $(window).on("resize", windowOnResized);
        animateText();


    }
)

function windowOnResized()
{
    var _winHeight = $(window).height();
    var _accumulatedWidth = 0;

    mWinWidthMidPoint = $(window).width() * 0.5;

    if ($("body").hasClass("sDesktop"))
    {
        $(".featuredList .imgItem").each(function (i, e)
        {
            if (i == 0)
            {
                $(e).css("left", "0");
                $(".title:eq(" + (i + 1) + ")").css("left", "0");
            }
            else
            {
                $(e).css("left", _accumulatedWidth + "px");
                $(".title:eq(" + (i + 1) + ")").css("left", _accumulatedWidth + "px");
            }

            var _currentWidth = Math.round(_winHeight * parseInt($(e).find("img").data("width")) / parseInt($(e).find("img").data("height")));

            $(".title:eq(" + (i + 1) + ")").css("width", _currentWidth + "px");

            if (i == mActiveIndex - 1)
            {
                $(e).css("opacity", "1");
                TweenMax.to($(".title:eq(" + i + ")", mTweenDurationTitle, {
                    css: {opacity: 1},
                    ease: Circ.easeIn,
                    onComplete: animateText
                }));
                var _expectedActiveLeftPos = mWinWidthMidPoint - Math.round(_currentWidth * 0.5);
                var _diff = _expectedActiveLeftPos - _accumulatedWidth;
                $(".featuredList").css("left", _diff + "px");
                $(".story:eq(" + mActiveIndex + ")").removeClass("hide");

                //Set it init step only! We'll use this value for responsiveness!
                if (!mContentHeightAtAbsolutePos)
                {
                    mContentHeightAtAbsolutePos = $(".content").outerHeight() + ($(".content").outerHeight() * 0.5);
                }

            }

            _accumulatedWidth += _currentWidth;

        });
    }
    else
    {
        mFeaturedListHeightOnMobile = $(window).height();

        $(".featuredList .imgItem").each(function (i, e)
        {
            if (i == 0)
            {
                $(e).css("left", "0");
                $(".title:eq(" + (i + 1) + ")").css("left", "0");
            }
            else
            {
                $(e).css("left", _accumulatedWidth + "px");
                $(".title:eq(" + (i + 1) + ")").css("left", _accumulatedWidth + "px");
            }

            //var _currentWidth = Math.round(mFeaturedListHeightOnMobile * parseInt($(e).data("width")) / parseInt($(e).data("height")));
            var _currentWidth = $(window).width();

            $(".title:eq(" + (i + 1) + ")").css("width", _currentWidth + "px");

            if (i == mActiveIndex - 1)
            {
                $(e).css("opacity", "1");
                TweenMax.to($(".title:eq(" + i + ")", mTweenDurationTitle, {
                    css: {opacity: 1},
                    ease: Circ.easeIn,
                    onComplete: animateText
                }));
                var _expectedActiveLeftPos = mWinWidthMidPoint - Math.round(_currentWidth * 0.5);
                var _diff = _expectedActiveLeftPos - _accumulatedWidth;
                $(".featuredList").css("left", _diff + "px");
                $(".story:eq(" + mActiveIndex + ")").removeClass("hide");

                //Set it init step only! We'll use this value for responsiveness!
                if (!mContentHeightAtAbsolutePos)
                {
                    mContentHeightAtAbsolutePos = $(".content").outerHeight() + ($(".content").outerHeight() * 0.5);
                }

            }

            _accumulatedWidth += _currentWidth;

        });
    }

    adjustContentPosition();

}

function onSlideComplete()
{

    mIsSliding = false;

    if (mSlideDirection == "prev")
    {
        currentWord--;
    }
    else if (mSlideDirection == "next")
    {
        currentWord++;
    }

    changeWord();
    mSlideDirection = "";
}


function animateText()
{
   //words[currentWord+1].style.opacity = 1;

     
    for (var i = 0; i < words.length; i++) {
        splitLetters(words[i]);
    }

    changeWord();
    //setInterval(changeWord, 4000);
}

function changeWord()
{
    var cw = wordArray[currentWord];
    var nw = currentWord == words.length - 1 ? wordArray[0] : wordArray[currentWord + 1];

    for (var i = 0; i < cw.length; i++) {
        animateLetterOut(cw, i);
    }

    for (var i = 0; i < nw.length; i++) {
        nw[i].className = 'letter behind';
        //nw[0].parentElement.style.opacity = 1;
        TweenMax.to(nw[0].parentElement, 0.3, {css:{opacity:1},ease:Circ.easeIn});
        animateLetterIn(nw, i);
    }

    //currentWord = (currentWord == wordArray.length - 1) ? 0 : currentWord + 1;
}

function animateLetterOut(cw, i) {
    setTimeout(function() {
        cw[i].className = 'letter out';
    }, i * 50);
}

function animateLetterIn(nw, i) {
    setTimeout(function() {
        nw[i].className = 'letter in';
    }, 100 + (i * 50));

}

function splitLetters(word) {
    var content = word.innerHTML;
    word.innerHTML = '';
    var letters = [];
    for (var i = 0; i < content.length; i++) {
        var letter = document.createElement('span');
        letter.className = 'letter';

        if (content.charAt(i) == " ")
        {
            letter.innerHTML = "&nbsp;"
        }
        else
        {
            letter.innerHTML = content.charAt(i);
        }

        word.appendChild(letter);
        letters.push(letter);
    }

    wordArray.push(letters);
}


function reverseStoryContentTween()
{

    if (mSlideDirection == "next") {
        $(".story:eq(" + mActiveIndex + ")").removeClass("hide");
        $(".story:eq(" + (mActiveIndex - 1) + ")").addClass("hide");
    }
    else if (mSlideDirection == "prev") {
        $(".story:eq(" + mActiveIndex + ")").removeClass("hide");
        $(".story:eq(" + (mActiveIndex + 1) + ")").addClass("hide");
    }

    $(".content").css("position", "absolute");
    $(".content").css("top", "30%");
    $(".content").css("width", "400px");
    $(".content").css("margin-bottom", "0");
    $("html").css("overflow-y", "hidden");

    //We need the content Height at ABSOLUTE position so the result can be obtained correctly when window is being resized.
    mContentHeightAtAbsolutePos = $(".content").outerHeight() + ($(".content").outerHeight() * 0.5);

    adjustContentPosition();

    mTimeLineStoryContent.reverse();
}

function adjustContentPosition()
{

    if ( mContentHeightAtAbsolutePos > $(window).height())
    {
        $(".content").css("position", "relative");
        $(".content").css("top", "0");
        $(".content").css("width", "100%");
        $(".content").css("margin-bottom", "24px"); //prevent footer from hiding some parts of the last line
        $("html").css("overflow-y", "auto");
    }
    else
    {
        $(".content").css("position", "absolute");
        $(".content").css("top", "30%");
        $(".content").css("width", "400px");
        $(".content").css("margin-bottom", "0");
        $("html").css("overflow-y", "hidden");
    }
}