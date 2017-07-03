/**
 * Created by herbert on 7/2/2017.
 */

var mActiveIndex = 7;
var mTweenDurationSliding = 0.7;
var mTweenDurationImgOpacity = 0.2;
var mWinWidthMidPoint = 0;
var mTotalSlide = 0;
var mIsSliding = false;
var wordArray = [];
var words = document.getElementsByClassName("title");
var currentWord = mActiveIndex -1;

$(document).ready(
    function()
    {
        //desktop mode
        if ($("body").hasClass("sDesktop"))
        {
           // animateText();

            mTotalSlide = $(".featuredList img").length;
            windowOnResized();
            animateText();

            $(window).on("resize", windowOnResized);

            $(".navigator .btn_prev").on("click", function(pEvent)
            {
               pEvent.preventDefault();
            });

            $(".navigator .btn_next").on("click", function(pEvent)
            {
                pEvent.preventDefault();

                if (mTotalSlide == mActiveIndex+1 || mIsSliding)
                {
                    return;
                }

                mIsSliding = true;

                var _timeLineCarousel = new TimelineLite();
                var _timeLineImageOpacity = new TimelineLite();
                var _timeLineTitle = new TimelineLite();

                var _currentItem = $(".featuredList img:eq(" + mActiveIndex + ")");
                var _nextItem = $(".featuredList img:eq(" + (mActiveIndex + 1) + ")");
                var _currentLeft = $(".featuredList").position().left;

                //shift half the currentItem width first
                var _nextItemToLeft = _currentLeft  - Math.round(_currentItem.width()* 0.5);
                //The shift half the targetItem width
                var _targetLeftPos = _nextItemToLeft - Math.round(_nextItem.width()* 0.5);

                _timeLineCarousel.to($(".featuredList"),mTweenDurationSliding,{css:{left:  _targetLeftPos + "px"},ease:Circ.easeOut, onComplete: onSlideComplete});
                _timeLineImageOpacity.to(_currentItem, mTweenDurationImgOpacity, {css:{opacity:0.3},ease:Circ.easeOut})
                         .to(_nextItem, mTweenDurationImgOpacity, {css:{opacity:1},ease:Circ.easeIn});

                _timeLineTitle.to($(".title:eq("  + mActiveIndex + ")"), 0.3, {css:{opacity:0},ease:Circ.easeIn});
               //     .to($(".title:eq("  + (mActiveIndex+1) + ")"), 0.3, {css:{opacity:1},ease:Circ.easeIn});


                mActiveIndex++;

                if (mTotalSlide == mActiveIndex+1)
                {
                    $(this).addClass("disable");
                }
                else
                {
                    $(this).removeClass("disable");
                }

            });


            $(".navigator .btn_prev").on("click", function(pEvent)
            {
                pEvent.preventDefault();

                if (mActiveIndex == 0 || mIsSliding)
                {
                    return;
                }

                mIsSliding = true;

                var _timeLineCarousel = new TimelineLite();
                var _timeLineImageOpacity = new TimelineLite();

                var _currentItem = $(".featuredList img:eq(" + mActiveIndex + ")");
                var _nextItem = $(".featuredList img:eq(" + (mActiveIndex - 1) + ")");
                var _currentLeft = $(".featuredList").position().left;

                //shift half the currentItem width first
                var _prevItemToLeft = _currentLeft  + _currentItem.width()* 0.5;
                //The shift half the targetItem width
                var _targetLeftPos = _prevItemToLeft + _nextItem.width()* 0.5;

                _timeLineCarousel.to($(".featuredList"),mTweenDurationSliding,{css:{left:  _targetLeftPos + "px"},ease:Circ.easeOut, onComplete: onSlideComplete});
                _timeLineImageOpacity.to(_currentItem, mTweenDurationImgOpacity, {css:{opacity:0.3},ease:Circ.easeOut})
                    .to(_nextItem, mTweenDurationImgOpacity, {css:{opacity:1},ease:Circ.easeIn});

                mActiveIndex--;

                if (mActiveIndex == 0)
                {
                    $(this).addClass("disable");
                }
                else
                {
                    $(this).removeClass("disable");
                }

            });
        }
    }
)

function windowOnResized()
{
    var _winHeight = $(window).height();
    var _accumulatedWidth = 0;

    mWinWidthMidPoint = $(window).width() * 0.5;

    $(".featuredList img").each(function (i, e)
    {
        if (i == 0)
        {
            $(e).css("left", "0");
            $(".title:eq(" + i + ")").css("left", "0");
        }
        else
        {
            $(e).css("left", _accumulatedWidth + "px");
            $(".title:eq(" + i + ")").css("left", _accumulatedWidth + "px");
        }

        var _currentWidth = Math.round(_winHeight * parseInt($(e).data("width")) / parseInt($(e).data("height")));

        $(".title:eq(" + i + ")").css("width", _currentWidth + "px");

        if (i == mActiveIndex)
        {
            $(e).css("opacity", "1");
            TweenMax.to( $(".title:eq(" + i + ")", 0.3, {css:{opacity:1},ease:Circ.easeIn}));

            var _expectedActiveLeftPos = mWinWidthMidPoint - Math.round(_currentWidth * 0.5);
            var _diff = _expectedActiveLeftPos - _accumulatedWidth;
            $(".featuredList").css("left", _diff + "px");


//            $(".title").css("width", _currentWidth + "px");
//            $(".title").css("margin-left", Math.round(-0.5 * _currentWidth) + "px");

        }

        _accumulatedWidth += _currentWidth;

    });
}

function onSlideComplete()
{
    mIsSliding = false;

    var _winHeight = $(window).height();
    var _currentWidth = Math.round(_winHeight * parseInt($(".featuredList img:eq(" + mActiveIndex + ")").data("width")) / parseInt($(".featuredList img:eq(" + mActiveIndex + ")").data("height")));

    currentWord++;
    changeWord();

    //TweenMax.to($(".title"), 0.2, {css:{opacity:1},ease:Circ.easeIn});
}


function animateText()
{
   // words[currentWord+1].style.opacity = 1;

    for (var i = 0; i < words.length; i++) {
        splitLetters(words[i]);
    }


    changeWord();
    //setInterval(changeWord, 4000);

}

function changeWord() {
    var cw = wordArray[currentWord];
    var nw = currentWord == words.length - 1 ? wordArray[0] : wordArray[currentWord + 1];

    for (var i = 0; i < cw.length; i++) {
        animateLetterOut(cw, i);
    }

    for (var i = 0; i < nw.length; i++) {
        nw[i].className = 'letter behind';
        //nw[0].parentElement.style.opacity = 1;

        //var _timeLine = new TimelineLite();
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
    }, 200 + (i * 50));
}

function splitLetters(word) {
    var content = word.innerHTML;
    word.innerHTML = '';
    var letters = [];
    for (var i = 0; i < content.length; i++) {
        var letter = document.createElement('span');
        letter.className = 'letter';
        letter.innerHTML = content.charAt(i);
        word.appendChild(letter);
        letters.push(letter);
    }

    wordArray.push(letters);
}

