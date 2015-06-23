// JavaScript Document
$(document).ready( function () {
    $('.nav-controller').click( function(e) {
        e.preventDefault();
        $('body').toggleClass('navigating');
    });

    $('#nav a').focus(function() {
        $(this).parents('li').addClass('infocus');
    });
    $('#nav a').blur(function() {
        $(this).parents('li').removeClass('infocus');
    });
    $('.null-instagram-feed > ul').addClass('clearfix');
    
    if (!Modernizr.svg) {
        var src = $('#logo').attr('src');
        if (src.indexOf('.svg') > -1) {
            // svg but no support - fallback to png
            var fbSrc = src.replace('.svg', '.png');
            $('#logo').attr('src', fbSrc);
            alert('yap');
        }
    }
    
    
    
    /* accessibility bonus: clearer outlines */
    $('head').append('<style id="behave" />');
    $('body').bind('mousedown', function(e) {
        $('html').removeClass('tabbing');
        mouseFriendly();
    });
    $('body').bind('keydown', function(e) {
        $('html').addClass('tabbing');
        if (e.keyCode === 9) {
            keyFriendly();
        }
    });
    
    // Aria roles + labels for navigation
    $('#nav').attr('role','navigation');
    $('#nav').attr('aria-label','Main navigation');
    $('#nav > ul').attr('role','menubar');
    $('#nav li').attr('role','menuitem');
    $(window).resize(function() {
        try {
            if (window.matchMedia('(min-width: 1080px)').matches) {
                $('#nav li.menu-item-has-children').attr('aria-haspopup','true');
                $('#nav ul.sub-menu').attr('aria-hidden','true');
            }
        } catch (err) {}
    });
});
function keyFriendly() {
    try { 
        document.getElementById("behave").innerHTML="a:focus, input:focus, button:focus, select:focus { outline:thin dotted; outline:3px solid #1f98f6; }"; 
    } catch (err) {}
}
function mouseFriendly() {
    try { 
        document.getElementById("behave").innerHTML="a, a:focus, input:focus, select:focus { outline:none !important; }"; 
    } catch (err) {}
}