// ------------------------------
// Sidebar Accordion Menu
// ------------------------------

$(function () {
    if($.cookie('admin_leftbar_collapse') === 'collapse-leftbar') {
        $('body').addClass('collapse-leftbar');
    } else {
        $('body').removeClass('collapse-leftbar');
    }

    $('body').on('click', 'ul.acc-menu a', function() {
        var LIs = $(this).closest('ul.acc-menu').children('li');
        $(this).closest('li').addClass('clicked');
        $.each( LIs, function(i) {
            if( $(LIs[i]).hasClass('clicked') ) {
                $(LIs[i]).removeClass('clicked');
                return true;
            }
            if($.cookie('admin_leftbar_collapse') !== 'collapse-leftbar' || $(this).parents('.acc-menu').length > 1) $(LIs[i]).find('ul.acc-menu:visible').slideToggle();
            $(LIs[i]).removeClass('open');
        });
        if($(this).siblings('ul.acc-menu:visible').length>0)
            $(this).closest('li').removeClass('open');
        else
            $(this).closest('li').addClass('open');
            if($.cookie('admin_leftbar_collapse') !== 'collapse-leftbar' || $(this).parents('.acc-menu').length > 1) $(this).siblings('ul.acc-menu').slideToggle({
                duration: 200,
                progress: function(){
                  checkpageheight();
                  if ($(this).closest('li').is(":last-child")) { //only scroll down if last-child
                      $("#sidebar").animate({ scrollTop: $("#sidebar").height()},0);
                  }
                },
                complete: function(){
                    $("#sidebar").getNiceScroll().resize();
                }
            });
    });

    var targetAnchor;
    $.each ($('ul.acc-menu a'), function() {
       //console.log(this.href);
        links = split_url_new(this.href);
        if( links === true ) {
            targetAnchor = this;
            return false;
        }else{
          nlinks = url_khusus();
          if( this.href == nlinks ){
            targetAnchor = this;
            return false;
          }
        }
    });

    var parent = $(targetAnchor).closest('li');
    while(true) {
        parent.addClass('active');
        parent.closest('ul.acc-menu').show().closest('li').addClass('open');
        parent = $(parent).parents('li').eq(0);
        if( $(parent).parents('ul.acc-menu').length <= 0 ) break;
    }

    var liHasUlChild = $('li').filter(function(){
        return $(this).find('ul.acc-menu').length;
    });
    $(liHasUlChild).addClass('hasChild');

    if($.cookie('admin_leftbar_collapse') === 'collapse-leftbar') {
        $('ul.acc-menu:first ul.acc-menu').css('visibility', 'hidden');
    }
    $('ul.acc-menu:first > li').hover(function() {
        if($.cookie('admin_leftbar_collapse') === 'collapse-leftbar')
            $(this).find('ul.acc-menu').css('visibility', '');
    }, function() {
        if($.cookie('admin_leftbar_collapse') === 'collapse-leftbar')
            $(this).find('ul.acc-menu').css('visibility', 'hidden');
    });


    // Reads Cookie for Collapsible Leftbar
    // if($.cookie('admin_leftbar_collapse') === 'collapse-leftbar')
    //     $("body").addClass("collapse-leftbar");

    //Make only visible area scrollable
    $("#widgetarea").css({"max-height":$("body").height()});
    //Bind widgetarea to nicescroll
    $("#widgetarea").niceScroll({horizrailenabled:false});

    // Toggle Buttons
    // ------------------------------

    //On click of left menu
    $("a#leftmenu-trigger").click(function () {
        if ((window.innerWidth)<768) {
            $("body").toggleClass("show-leftbar");
        } else {
            $("body").toggleClass("collapse-leftbar");

            //Sets Cookie for Toggle
            if($.cookie('admin_leftbar_collapse') === 'collapse-leftbar') {
                $.cookie('admin_leftbar_collapse', '');
                $('ul.acc-menu').css('visibility', '');

            } else {
                $.each($('.acc-menu'), function() {
                    if($(this).css('display') == 'none')
                        $(this).css('display', '');
                });

                $('ul.acc-menu:first ul.acc-menu').css('visibility', 'hidden');
                $.cookie('admin_leftbar_collapse', 'collapse-leftbar');
            }
        }
        checkpageheight();
        leftbarScrollShow();
    });

    // On click of right menu
    $("a#rightmenu-trigger").click(function () {
        $("body").toggleClass("show-rightbar");
        widgetheight();

        if($.cookie('admin_rightbar_show') === 'show-rightbar')
                $.cookie('admin_rightbar_show', '');
            else
                $.cookie('admin_rightbar_show', 'show-rightbar');
    });

    //set minimum height of page
    dh=($(window).height()-40);
    $("#page-content").css("min-height",dh+"px");
    //checkpageheight();
});

// Recalculate widget area on a widget being shown
$(".widget-body").on('shown.bs.collapse', function () {
    widgetheight();
});

// -------------------------------
// Sidebars Positionings
// -------------------------------

$(window).scroll(function(){
    $("#widgetarea").getNiceScroll().resize();
    $(".chathistory").getNiceScroll().resize();
    rightbarTopPos();
    leftbarTopPos();
});

$(window).resize(function(){
    widgetheight();

    rightbarRightPos();
    $("#sidebar").getNiceScroll().resize();
});
rightbarRightPos();


// -------------------------------
// Mobile Only - set sidebar as fixed position, slide
// -------------------------------

enquire.register("screen and (max-width: 767px)", {
    match : function() {
        // For less than 768px
        $(function() {

            //Bind sidebar to nicescroll
            $("#sidebar").niceScroll({horizrailenabled:false});
            leftbarScrollShow();

            //Click on body and hide leftbar
            $("#wrap").click(function(){
                if ($("body").hasClass("show-leftbar")) {
                    $("body").removeClass("show-leftbar");
                    leftbarScrollShow();
                }
            });

            //Fix a bug
            $('#sidebar ul.acc-menu').css('visibility', '');

            //open up leftbar
            $("body").removeClass("show-leftbar");
            $.removeCookie("admin_leftbar_collapse");

            $("body").removeClass("collapse-leftbar");

        });

        console.log("match");
    },
    unmatch : function() {

        //Remove nicescroll to clear up some memory
            $("#sidebar").niceScroll().remove();
            $("#sidebar").css("overflow","visible");

        console.log("unmatch");

        //hide leftbar
        $("body").removeClass("show-leftbar");

    }
});

//Helper functions
//---------------

//Fixing the show of scroll rails even when sidebar is hidden
function leftbarScrollShow () {
    if ($("body").hasClass("show-leftbar")) {
        $("#sidebar").getNiceScroll().show();
    } else {
        $("#sidebar").getNiceScroll().hide();
    }
    $("#sidebar").getNiceScroll().resize();
}

//set Top positions for changing between static and fixed header
function leftbarTopPos() {
    var scr=$('body.static-header').scrollTop();
    if (scr<41) {$('ul#sidebar').css('top',40-scr + 'px');} else {$('ul#sidebar').css('top',0);}
}

function rightbarTopPos() {
    var scr=$('body.static-header').scrollTop();
    if (scr<41) {$('#page-rightbar').css('top',40-scr + 'px');} else {$('#page-rightbar').css('top',0);}
}

//Set Right position for fixed layouts
function rightbarRightPos () {
    if ($('body').hasClass('fixed-layout')) {
        var $pc = $('#page-content');
        var ending_right = ($(window).width() - ($pc.offset().left + $pc.outerWidth()));
        if (ending_right<0) ending_right=0;
        $('#page-rightbar').css('right',ending_right);
    }
}

// Match page height with Sidebar Height
function checkpageheight() {
    sh=$("#page-leftbar").height();
    ch=$("#page-content").height();

    if (sh>ch)
      $("#page-content").css("min-height",sh+"px");
}

// Recalculate widget area to area visible
function widgetheight() {
    $("#widgetarea").css({"max-height":$("body").height()});
    $("#widgetarea").getNiceScroll().resize();
}

// -------------------------------
// Panel Collapses
// -------------------------------
$('a.panel-collapse').click(function() {
    $(this).children().toggleClass("fa-chevron-down fa-chevron-up");
    $(this).closest(".panel-heading").next().slideToggle({duration: 200});
    $(this).closest(".panel-heading").toggleClass('rounded-bottom');
    return false;
});

// -------------------------------
// Quick Start
// -------------------------------
$('#headerbardropdown').click(function() {
    $('#headerbar').css('top',0);
    return false;
});

$('#headerbardropdown').click(function(event) {
  $('html').one('click',function() {
    $('#headerbar').css('top','-1000px');
  });

  event.stopPropagation();
});

// -------------------------------
// Keep search open on click
// -------------------------------
$('#search>a').click(function () {
    $('#search').toggleClass('keep-open');
    $('#search>a i').toggleClass("opacity-control");
});

$('#search').click(function(event) {
  $('html').one('click',function() {
    $('#search').removeClass('keep-open');
    $('#search>a i').addClass("opacity-control");
  });

  event.stopPropagation();
});

//Presentational: set all panel-body with br0 if it has panel-footer
$(".panel-footer").prev().css("border-radius","0");

// base url
function base_url() {
    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost:8080') {
      var url = location.origin + '/' + pathparts[1].trim('/') + '/'; // http://localhost/myproject/
    }else{
      var url = location.origin + '/'; // http://stackoverflow.com
    }
    return url;
}

function split_url_new(url_menu)
{
  var url      = base_url();
  var new_link = window.location.href.split(url);
  var new_url  = new_link[1].split('/');

  if(url_menu == window.location)
    return true;
  else{
    var nlink = url + new_url[0] + '/' + new_url[1]; //nama module n control beda
    if(url_menu == nlink)
      return true;
    else
      return false;
  }
}

function url_khusus()
{
  var url      = base_url();
  var new_link = window.location.href.split(url);
  var new_url  = new_link[1].split('/');
  var nlink    = url + new_url[0];

  if(new_url[2] === "create" || new_url[2] === "update" || new_url[2] === "listview" || new_url[2] === "review") {
    return nlink;
  } else
    return nlink +'/'+ new_url[1];
}
