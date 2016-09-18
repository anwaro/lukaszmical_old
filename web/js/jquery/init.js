/*
 Miniport by HTML5 UP
 html5up.net | @n33co
 Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
 */

/* global skel, url, x */

(function ($) {

    skel.init({
        reset: 'full',
        breakpoints: {
//            'global': {range: '*', href: url + '/web/css/style.css'},
            'desktop': {range: '737-', href: url + '/web/css/style-desktop.css', containers: 1200, grid: {gutters: 25}},
            '1000px': {range: '737-1200', href: url + '/web/css/style-1000px.css', containers: 960, grid: {gutters: 25}, viewport: {width: 1080}},
            'mobile': {range: '-736', href: url + '/web/css/style-mobile.css', containers: '100%!', grid: {collapse: true, gutters: 15}, viewport: {scalable: false}}
        }
    });
    $(function () {
        var $window = $(window),
                $body = $('body');

        // Disable animations/transitions until the page has loaded.
        $body.addClass('is-loading');

        $window.on('load', function () {
            $body.removeClass('is-loading');
        });

        // Forms (IE<10).
        var $form = $('form');
        if ($form.length > 0) {

            if (skel.vars.IEVersion < 10) {
                $.fn.n33_formerize = function () {
                    var _fakes = new Array(), _form = $(this);
                    _form.find('input[type=text],textarea').each(function () {
                        var e = $(this);
                        if (e.val() == '' || e.val() == e.attr('placeholder')) {
                            e.addClass('formerize-placeholder');
                            e.val(e.attr('placeholder'));
                        }
                    }).blur(function () {
                        var e = $(this);
                        if (e.attr('name').match(/_fakeformerizefield$/))
                            return;
                        if (e.val() == '') {
                            e.addClass('formerize-placeholder');
                            e.val(e.attr('placeholder'));
                        }
                    }).focus(function () {
                        var e = $(this);
                        if (e.attr('name').match(/_fakeformerizefield$/))
                            return;
                        if (e.val() == e.attr('placeholder')) {
                            e.removeClass('formerize-placeholder');
                            e.val('');
                        }
                    });
                    _form.find('input[type=password]').each(function () {
                        var e = $(this);
                        var x = $($('<div>').append(e.clone()).remove().html().replace(/type="password"/i, 'type="text"').replace(/type=password/i, 'type=text'));
                        if (e.attr('id') != '')
                            x.attr('id', e.attr('id') + '_fakeformerizefield');
                        if (e.attr('name') != '')
                            x.attr('name', e.attr('name') + '_fakeformerizefield');
                        x.addClass('formerize-placeholder').val(x.attr('placeholder')).insertAfter(e);
                        if (e.val() == '')
                            e.hide();
                        else
                            x.hide();
                        e.blur(function (event) {
                            event.preventDefault();
                            var e = $(this);
                            var x = e.parent().find('input[name=' + e.attr('name') + '_fakeformerizefield]');
                            if (e.val() == '') {
                                e.hide();
                                x.show();
                            }
                        });
                        x.focus(function (event) {
                            event.preventDefault();
                            var x = $(this);
                            var e = x.parent().find('input[name=' + x.attr('name').replace('_fakeformerizefield', '') + ']');
                            x.hide();
                            e.show().focus();
                        });
                        x.keypress(function (event) {
                            event.preventDefault();
                            x.val('');
                        });
                    });
                    _form.submit(function () {
                        $(this).find('input[type=text],input[type=password],textarea').each(function (event) {
                            var e = $(this);
                            if (e.attr('name').match(/_fakeformerizefield$/))
                                e.attr('name', '');
                            if (e.val() == e.attr('placeholder')) {
                                e.removeClass('formerize-placeholder');
                                e.val('');
                            }
                        });
                    }).bind("reset", function (event) {
                        event.preventDefault();
                        $(this).find('select').val($('option:first').val());
                        $(this).find('input,textarea').each(function () {
                            var e = $(this);
                            var x;
                            e.removeClass('formerize-placeholder');
                            switch (this.type) {
                                case 'submit':
                                case 'reset':
                                    break;
                                case 'password':
                                    e.val(e.attr('defaultValue'));
                                    x = e.parent().find('input[name=' + e.attr('name') + '_fakeformerizefield]');
                                    if (e.val() == '') {
                                        e.hide();
                                        x.show();
                                    } else {
                                        e.show();
                                        x.hide();
                                    }
                                    break;
                                case 'checkbox':
                                case 'radio':
                                    e.attr('checked', e.attr('defaultValue'));
                                    break;
                                case 'text':
                                case 'textarea':
                                    e.val(e.attr('defaultValue'));
                                    if (e.val() == '') {
                                        e.addClass('formerize-placeholder');
                                        e.val(e.attr('placeholder'));
                                    }
                                    break;
                                default:
                                    e.val(e.attr('defaultValue'));
                                    break;
                            }
                        });
                        window.setTimeout(function () {
                            for (x in _fakes)
                                _fakes[x].trigger('formerize_sync');
                        }, 10);
                    });
                    return _form;
                };
                $form.n33_formerize();
            }

        }

        // CSS polyfills (IE<9).
        if (skel.vars.IEVersion < 9)
            $(':last-child').addClass('last-child');

        // Scrolly.
        $window.load(function () {

            var x = parseInt($('.wrapper').first().css('padding-top')) - 15;
            $('#nav a, .scrolly').scrolly(1000, x);

        });

        /*var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Phone/i.test(navigator.userAgent);
         
         if(isMobile &&$( window ).width( )<700){
         $('#nav').hide();
         $('#navMobile').show().css("left",(($( window ).width()-$('#navMobile').width())/2 )+ "px").click(function(e){
         e.stopPropagation();
         $("#navMobile ul").toggle()
         });
         $( document ).click(function(){if($('#navMobile ul').css('display') != 'none') $('#navMobile ul').fadeOut();})
         }*/
        $("#content-block").delay(200).animate({opacity:1});
        
        $( "a" ).click(function( event ) {
            if(event.currentTarget.target !== "_blank"
                && !/#/.test(event.currentTarget.href)){
            event.preventDefault();
            $("#content-block").animate(
                    {opacity:0}, 
                    400,
                    function(){
                        window.location.assign(event.currentTarget.href);
                        $("#content-block").delay(300).animate({opacity:1});
                    });
            
            }
        });
    });

})(jQuery);