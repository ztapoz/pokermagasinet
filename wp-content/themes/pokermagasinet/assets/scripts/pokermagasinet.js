'use strict';

var isDevice = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
    isAndroid = /Android/i.test(navigator.userAgent),
    isIos = /iPhone|iPad|iPod/i.test(navigator.userAgent),
    isMobile = $(window).width() < 768,
    mobileWidth = 767,
    deviceWidth = 1024;

var isMobileScreen = function() {
    return document.body.clientWidth < 768;
};
var isTabletAndMobile = function() {
    return document.body.clientWidth < 1024;
};
var isMobileMenuBreakpoint = function() {
    return document.body.clientWidth < 1200;
};

var    isIE11 = !!(navigator.userAgent.match(/Trident/) && navigator.userAgent.match(/rv[ :]11/));
var FE = {
    global: {
        equalHeightByRow: function (obj, notRunMobile) {
            var widthTarget = 0;
            if ($(obj).length) {
                $(obj).height('auto');
                widthTarget = notRunMobile === true ? 768 : 0;
                if ($(window).width() >= widthTarget) {
                    var currentTallest = 0,
                        currentRowStart = 0,
                        rowDivs = [],
                        currentDiv = 0,
                        $el,
                        topPosition = 0;
                    $(obj).each(function () {
                        if ($(this).is(':visible') === true) {
                            $el = $(this);
                            topPosition = $el.offset().top;
                            if (currentRowStart !== topPosition) {
                                for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                                    rowDivs[currentDiv].innerHeight(currentTallest);
                                }
                                rowDivs = [];
                                currentRowStart = topPosition;
                                currentTallest = $el.innerHeight();
                                rowDivs.push($el);
                            } else {
                                rowDivs.push($el);
                                currentTallest = currentTallest < $el.innerHeight() ? $el.innerHeight() : currentTallest;
                            }
                            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                                rowDivs[currentDiv].innerHeight(currentTallest);
                            }
                        }
                    });
                }
            }
        },
        detectDevices: function() {
            var a = isDevice === true ? ' device' : ' pc',
                b = isAndroid === true ? ' android' : ' not-android',
                c = isIos === true ? ' ios' : ' not-ios',
                d = isMobile ? ' mobile' : ' desktop',
                e = isIE11 ? ' ie11' : ' ',
                htmlClass = a + b + c + d + e;
            $('html').addClass(htmlClass);
        },
        replaceImgToBackground: function(img) {
            $(img).each(function () {
                if ($(this).css('visibility') == 'visible') {
                    $(this).css({'visibility':'hidden','opacity':'0'});
                    $(this).closest('.bg-container').addClass('container-background').css('background-image', 'url(' + $(this).attr('src') + ')');
                };
            });
        },
        pageSlider: function() {
            $('.base-prefix-page-slider').slick({
                dots: true,
                  infinite: true,
                  speed: 500,
                  fade: true,
                  arrows: false,
                  cssEase: 'linear',
                   autoplay: true,
                    autoplaySpeed: 2000,
            });
        },
        
        stickyHeader: function() {
            $('#base-prefix-header').sticky({topSpacing:0});
        },
        menuDropdowMobile: function(){
             $('.navbar-nav .menu-item-has-children').each(function(index,value){
                    $(value).on('click',function(){               
                            if($(this).hasClass('open')) {
                                $(this).removeClass('open');
                            } else {
                                $('.navbar-nav li').removeClass('open');
                                $(this).addClass('open');
                             
                            }
                            
                      });
                 })
        },
        validateForm: function() {
         /*    $('.base-prefix-contact-form .form-control').each(function(){
                var attr = $(this).attr('placeholder');
                $(this).attr('placeholder',"").wrap( "<div class='form-group' ></div>" ).before("<label class='label-control'>"+ attr + "</label>");

            });*/
            $( '.base-prefix-contact-form form' ).validate( {
                  rules: {
                    name: {
                      required: true
                    },
                    email: {
                      required: true,
                      email: true
                    },
                    
                    subject : {
                         required: true
                     },
                    message : {
                        required: true
                    }
                  },
                  messages: {
                    name: 'This field is required',
                    subject: 'This field is required',
                    email: {
                        required: 'This field is required',
                        email: 'This field is invalid',
                    },
                    message: 'This field is required'
                  },
                  invalidHandler: function(form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        $('#submitButton').attr('disabled',false);
                    }
                }
                } );
        },

        init: function() {
          
            //FE.global.stickyHeader();
            //FE.global.replaceImgToBackground('.feature-image');
            FE.global.menuDropdowMobile();
            FE.global.validateForm();
            //FE.global.pageSlider();
        },
        loaded: function() {
        },
        resize: function() {

        },
        scroll: function() {
            
        }
    }
};

$(function () {
    FE.global.init();
});

$(window).load(function () {
   FE.global.loaded();
});

// Window resize
var width = $(window).width();
var resize = 0;
$(window).resize(function () {
    var _self = $(undefined);

   // FE.global.stickyHeader();
    
    resize++;
    setTimeout(function () {
        resize--;
        if (resize === 0) {
            // Done resize ... 
            if (_self.width() !== width) {
                width = _self.width();
               
            }
        }
    }, 100);
}); 

$(window).scroll(function () {
   FE.global.scroll();
});