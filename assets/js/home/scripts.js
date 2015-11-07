(function ($) {
    "use strict";
    $(document).ready(function () {
        parallax_image();
        progress_bar($(this));
        mobile_nav($(this));
        owl_carousel($(this));
        one_page_scroll($(this));
        sticky_header($(this));
        bs_tooltip($(this));
        isotope_go($(this));
        app.init();
    });
    jQuery(window).load(function () {
        site_loader($(this));
        fullscreen_section($(this));
        parallax_image();
        isotope_go($(this));
        $('.section').each(function () {
            animate_start($(this));
        });
    });
    var flex_slider = function ($this) {
        $('.hero-slider').flexslider({
            animation: "fade",
            direction: "horizontal",
            animationSpeed: 1000,
            animationLoop: true,
            smoothHeight: true,
            directionNav: false,
            controlsContainer: ".hero-controls",
            controlNav: true,
            slideshow: true,
            useCSS: true,
            after: function (slider) {
                if ($('li.flex-active-slide').hasClass("dark-slider")) {
                    $('.header').addClass('white-header');
                }
                else {
                    $('.header').removeClass('white-header');
                }
                if ($('li.flex-active-slide').hasClass("white-slider")) {
                    $('.header').addClass('black-header');
                }
                else {
                    $('.header').removeClass('black-header');
                }
            },
            start: function (slider) {
                if ($('li.flex-active-slide').hasClass("dark-slider")) {
                    $('.header').addClass('inverse-header');
                }
                else {
                    $('.header').removeClass('inverse-header');
                }
                if ($('li.flex-active-slide').hasClass("white-slider")) {
                    $('.header').addClass('black-header');
                }
                else {
                    $('.header').removeClass('black-header');
                }
            }
        });
        $('.flexslider').flexslider({animation: "fade", controlNav: true, useCSS: true, directionNav: false});
    }
    var animate_start = function ($this) {
        $this.find('.animate').each(function (i) {
            var $item = jQuery(this);
            var animation = $item.data("animate");
            $item.waypoint(function (direction) {
                $item.css({
                    '-webkit-animation-delay': (i * 0.1) + "s",
                    '-moz-animation-delay': (i * 0.1) + "s",
                    '-ms-animation-delay': (i * 0.1) + "s",
                    '-o-animation-delay': (i * 0.1) + "s",
                    'animation-delay': (i * 0.1) + "s"
                });
                $item.removeClass('animate').addClass('animated ' + animation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    jQuery(this).removeClass(animation + ' animated');
                });
            }, {offset: '80%', triggerOnce: true});
        });
    };
    var parallax_image = function ($this) {
        //$.stellar({horizontalScrolling: false, responsive: true});
    }
    var fullscreen_section = function ($this) {
        $this.find('.fullscreen').each(function () {
            var $this = $(this);
            var resize_height = function () {
                $this.height($(window).height());
                fullscreenFix();
            }
            resize_height();
            $(window).resize(function () {
                resize_height();
            });
        });
    }

    function fullscreenFix() {
        var h = $(window).height();
        $(".fullscreen").children(".container").each(function (i) {
            var hc = $(this).innerHeight() + 270;
            if (hc >= h) {
                $(this).parent(".fullscreen").addClass("not-overflow");
            } else {
                $(this).parent(".fullscreen").removeClass("not-overflow");
            }
        });
    }

    var fix_height = function ($this) {
        var auto_height = function () {
            if ($(window).width() > 991) {
                $('.auto-height').each(function () {
                    var element = $(this);
                    var height = element.height();
                    var parent_height = element.parent().parent().height();
                    element.css('height', parent_height);
                });
            } else {
                $('.auto-height').each(function () {
                    var element = $(this);
                    element.css('height', 'auto');
                });
            }
        }
        auto_height();
        $(window).resize(function () {
            auto_height();
        });
    }
    var progress_bar = function ($this) {
        $this.find('.progress-bar').each(function () {
            var $this = $(this);
            $this.waypoint(function (direction) {
                $this.css('width', $this.attr('aria-valuenow') + '%');
            }, {offset: '80%', triggerOnce: true});
        });
    }
    var mobile_nav = function ($this) {

        $('.menu-toggle').on('click', function () {
            $(this).closest('header').toggleClass('menu-open');
            if ($(this).closest('header').hasClass('menu-3')) {
                $(this).toggleClass('active');
            }
        });
        var add_mm_class = function () {
            if ($(window).width() < 991) {
                $('.menu').addClass('mobile-menu')
            } else {
                $('.menu').removeClass('mobile-menu')
            }
        }
        add_mm_class();
        $(window).resize(function () {
            add_mm_class();
        });
    }
    var owl_carousel = function ($this) {
        $('.owl-carousel').each(function () {
            var $this = $(this);
            $this.owlCarousel({
                loop: true,
                margin: 0,
                responsiveClass: true,
                responsive: {
                    0: {items: 1, nav: true},
                    768: {items: $this.data('col-sm'), nav: false},
                    992: {items: $this.data('col-md'), nav: true, loop: false},
                    1200: {items: $this.data('col-lg'), nav: true, loop: false}
                }
            });
        });
    }
    var one_page_scroll = function ($this) {
        $(function () {
            var sections = jQuery('.section');
            var navigation_links = jQuery('.menu a, a.scroll-down');
            sections.waypoint({
                handler: function (direction) {
                    var active_section;
                    active_section = jQuery(this);
                    if (direction === "up")active_section = active_section.prev();
                    var active_link = jQuery('.menu a[href="#' + active_section.attr("id") + '"]');
                    navigation_links.removeClass("active");
                    active_link.addClass("active");
                    active_section.addClass("active-section");
                }, offset: '80%'
            });
        });
        $('.menu, .scroll-down').each(function () {
            var $this = $(this);
            $this.localScroll({offset: -30, duration: 500})
        });
        $('a.scroll-down').localScroll();
    }
    var site_loader = function ($this) {
        $('.loader').css('opacity', 0);
        setTimeout(function () {
            $('.loader').hide();
            $('body').addClass('loaded')
        }, 600);
    }
    var bs_tooltip = function ($this) {
        $('[data-toggle="tooltip"]').tooltip()
    }
    var sticky_header = function ($this) {
        $(window).scroll(function () {
            if (window.scrollY > 20 && !$('.mobile-toggle').is(":visible")) {
                $('#header').addClass('sticky');
            } else {
                $('#header').removeClass('sticky');
            }
        });
    }
    var isotope_go = function ($this) {
        var $container = $('.isotope-container');
        $container.isotope({
            itemSelector: '.isotope-item',
            filter: '*',
            resizable: false,
            animationOptions: {duration: 750, easing: 'linear', queue: false}
        });
        $('ul.portfolio-filter a').on('click', function () {
            var selector = $(this).attr('data-filter');
            $container.isotope({filter: selector, animationOptions: {duration: 750, easing: 'linear', queue: false}});
            return false;
        });
        var $optionSets = $('ul.portfolio-filter'), $optionLinks = $optionSets.find('a');
        $optionLinks.on('click', function () {
            var $this = $(this);
            if ($this.hasClass('selected')) {
                return false;
            }
            var $optionSet = $this.parents('ul.portfolio-filter');
            $optionSet.find('.selected').removeClass('selected');
            $this.addClass('selected');
        });
    }


    jconfirm.defaults = {
        container: 'body',
        theme: 'white git', //supervan
        animation: 'zoom',
        columnClass: 'col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3',
        animationSpeed: 200,
        animationBounce: 1,
        confirmButtonClass: 'btn-success',
        cancelButton: 'close',
        keyboardEnabled: true,
    }

    var app = {
        init: function () {
            this.login();
            this.signup();
            this.resetPassword();
            this.resetPasswordConfirmed();
            this.footerAlign();
            this.socialLogins();
            this.pageFeedback();
            this.stickyPage();

            $('.browser-screens').flexslider({
                animation: 'slide',
                slideshowSpeed: 10000,
                directionNav: false
            });
        },
        stickyPage: function () {
            $st = $('$st');
            $st.sticky({topSpacing: $st.data('top') || 0, bottomSpacing: $st.data('botom') || 0 });
        },
        pageFeedback: function () {
            var that = this;
            $('.page-feedback').click(function (e) {
                var $this = $(this);
                e.preventDefault();
                if ($this.data('type') == 0) {
                    $.confirm({
                        title: 'Sorry about that',
                        content: 'Please let us know what you were looking for, or how can we improve it?' +
                        '<textarea style="resize: none" placeholder="Write to us (optional)"></textarea>',
                        confirmButton: 'Send',
                        cancelButton: 'Dismiss',
                        keyboardEnabled: false,
                        confirm: function () {
                            var jc = this;
                            this.$btnc.find('button').prop('disabled', true);
                            this.$confirmButton.html('<i class="fa fa-spinner fa-spin"></i> Sending');
                            this.contentDiv.find('textarea').prop('disabled', true);
                            var pageid = $this.attr('data-page-id');
                            var type = $this.attr('data-type');
                            var message = jc.contentDiv.find('textarea').val();
                            that.sendfeedback(pageid, type, message, function () {
                                jc.close();
                            });
                            return false;
                        }
                    })
                } else {
                    var pageid = $this.attr('data-page-id');
                    var type = $this.attr('data-type');
                    var message = 'Page helpful';
                    that.sendfeedback(pageid, type, message);
                }
            });
        },
        sendfeedback: function (pageid, type, message, callback) {
            $.ajax({
                url: home_url + 'api/pagefeedback',
                data: {
                    pageid: pageid,
                    type: type,
                    message: message,
                },
                method: 'post',
                dataType: 'json'
            }).always(function () {
                if (typeof callback == 'function')
                    callback();

                $.alert({
                    title: false,
                    content: '<div class="space10"></div>' +
                    'Thanks for your feedback',
                    confirmButton: 'Close',
                });
            });
        },
        signup: function () {
            this.$signupform = $('#home-signup')
            if (!this.$signupform.length)
                return false;
            var EmailValid = false,
                UsernameValid = false,
                request = false,
                timer,
                timer2;

            this.$signupform.find('[name="username"]').on('keyup blur', function (e) {
                var $this = $(this);
                if ($this.valid()) {
                    if (request)
                        request.abort();

                    clearTimeout(timer2);

                    timer2 = setTimeout(function () {
                        request = $.ajax({
                            url: home_url + 'api/user/validate',
                            data: {
                                key: $this.val(),
                                type: 'username'
                            },
                            method: 'post',
                            dataType: 'json'
                        }).done(function (res) {
                            $('.usernamevalid').hide();
                            if (res.status) {
                                // the username is taken.
                                UsernameValid = false;
                                $('.usernamevalid').css('display', 'inline-block').html(res.reason);
                            } else {
                                UsernameValid = true;
                            }
                        });
                    }, 200);
                } else {
                    $('.usernamevalid').hide();
                }
            });
            this.$signupform.find('[name="email"]').on('keyup blur', function (e) {
                var $this = $(this);
                if ($this.valid()) {

                    if (request)
                        request.abort();

                    clearTimeout(timer);

                    timer = setTimeout(function () {
                        request = $.ajax({
                            url: home_url + 'api/user/validate',
                            data: {
                                key: $this.val(),
                                type: 'email'
                            },
                            method: 'post',
                            dataType: 'json'
                        }).done(function (res) {
                            $('.emailvalid').hide();
                            if (res.status) {
                                // the user is registered.
                                EmailValid = false;
                                $('.emailvalid').css('display', 'inline-block').html(res.reason);
                            } else {
                                EmailValid = true;
                            }
                        });
                    }, 200);
                } else {
                    $('.emailvalid').hide();
                }
            });
            this.$signupform.validate({
                submitHandler: function (form) {
                    var $form = $(form);
                    var data = $form.serializeArray();
                    if (!EmailValid) {
                        $.alert({
                            title: 'Validation',
                            icon: 'fa fa-info fa-fw orange',
                            content: 'Please enter a valid Email ID'
                        });
                        return false;
                    }
                    if (!UsernameValid) {
                        $.alert({
                            title: 'Validation',
                            icon: 'fa fa-icon fa-fw orange',
                            content: 'Please enter a valid Username'
                        });
                        return false;
                    }
                    $form.find(':input').attr('disabled', 'disabled');
                    $form.find('button').html('<i class="gf gf-loading"></i>');
                    $.ajax({
                        url: home_url + 'api/user/register',
                        method: 'post',
                        dataType: 'json',
                        data: data,
                    }).done(function (res) {
                        if (res.status) {
                            $.alert({
                                title: 'Welcome!',
                                content: 'You\'ve successfully registered with Gitftp.com, <br/> Please head to your Email account to activate your Gitftp account.',
                                confirmButton: 'Dismiss',
                                icon: 'fa fa-check green'
                            });
                            $form.find(':input').val('');
                        } else {
                            $.alert({
                                title: 'Problem',
                                content: res.reason,
                                confirmButton: 'Dismiss',
                                icon: 'fa fa-info blue'
                            });
                        }
                    }).fail(function () {
                        $.alert({
                            title: 'Something went wrong',
                            content: 'We experienced an issue and is being resolved. Please try again.',
                            confirmButton: 'Dismiss',
                            icon: 'fa fa-warning red'
                        });
                    }).always(function () {
                        $form.find(':input').removeAttr('disabled');
                        $form.find('button').html('<i class="fa fa-lock fa-fw" style=""></i> Signup');
                    });
                },
                rules: {
                    fullname: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    username: {
                        required: true,
                        minlength: 6,
                        maxlength: 18
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 18

                    }
                }
            })
        },
        login: function () {
            this.$loginform = $('#home-login')
            if (!this.$loginform.length)
                return false;

            this.$loginform.validate({
                debug: true,
                submitHandler: function (form) {
                    var $form = $(form);
                    var data = $form.serializeArray();
                    $form.find(':input').attr('disabled', 'disabled');
                    $form.find('button').html('<i class="gf gf-loading"></i>');

                    $.ajax({
                        url: base + 'api/user/login',
                        data: data,
                        method: 'post',
                        dataType: 'json',
                    }).done(function (data) {
                        console.log(data);
                        if (data.status) {
                            $.dialog({
                                title: '',
                                content: '<span class=""><i class="gf gf-loading"></i>&nbsp; Logged in, Redirecting... </span>',
                                closeIcon: false,
                                backgroundDismiss: false
                            });
                            if (getUrlParameter('ref')) {
                                window.location = decodeURIComponent(getUrlParameter('ref'));
                            } else {
                                window.location = data.redirect;
                            }
                        } else {
                            var o = {
                                title: 'Problem',
                                icon: 'fa fa-info orange fa-fw',
                                content: data.reason,
                                cancelButton: 'Dismiss',
                                cancelButtonClass: 'btn btn-default',
                                confirmButton: false,
                            };
                            if (/not activated/ig.test(data.reason)) {
                                o['confirmButton'] = 'Resend email';
                                o['confirm'] = function () {
                                    this.$confirmButton.html('<i class="gf gf-loading"></i> Resend email').prop('disabled', true);
                                    var email = $('#email').val();
                                    var jc = this;
                                    $.ajax({
                                        url: home_url + 'api/user/resendact',
                                        data: {
                                            email: email
                                        },
                                        dataType: "json",
                                        method: 'get',
                                    }).done(function (res) {
                                        if (res.status) {
                                            $.alert({
                                                title: 'Email sent',
                                                content: 'Please head to your Email account to activate your Gitftp account.',
                                                confirmButton: 'Dismiss',
                                                icon: 'fa fa-check green'
                                            });
                                        }
                                        jc.close();
                                    });
                                    return false;
                                };
                            }
                            $.confirm(o);
                        }
                    }).always(function (data) {
                        $form.find(':input').removeAttr('disabled');
                        $form.find('button').html('<i class="fa fa-lock fa-fw" style=""></i> Login');
                    });
                },
                rules: {
                    email: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: 'Please enter Username/Email'
                    },
                    password: {
                        required: 'Please enter Password'
                    }
                }
            })
        },
        resetPassword: function () {
            this.$loginform = $('#home-password-reset')
            if (!this.$loginform.length)
                return false;

            this.$loginform.validate({
                debug: true,
                submitHandler: function (form) {
                    var $form = $(form);
                    var data = $form.serializeArray();
                    $form.find(':input').attr('disabled', 'disabled');
                    $form.find('button').html('<i class="fa fa-spin fa-spinner"></i> Submit');

                    $.ajax({
                        url: base + 'api/user/forgotpassword',
                        data: data,
                        method: 'post',
                        dataType: 'json',
                    }).done(function (data) {
                        console.log(data);
                        if (data.status) {
                            $.alert({
                                title: 'Email sent!',
                                icon: 'fa fa-check green fa-fw',
                                content: 'We have sent you an Email with instructions to reset your password.',
                                closeIcon: false,
                                confirmButton: 'Dismiss',
                            });
                            $form.find(':input').val('');
                        } else {
                            $.alert({
                                title: 'Problem',
                                content: data.reason,
                                icon: 'fa fa-info orange fa-fw',
                                confirmButton: 'close',
                                confirmButtonClass: 'btn btn-default'
                            });
                        }
                    }).always(function (data) {
                        $form.find(':input').removeAttr('disabled');
                        $form.find('button').html('Submit');
                    });
                },
                rules: {
                    email: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: 'Please enter Username/Email'
                    }
                }
            })
        },
        resetPasswordConfirmed: function () {
            this.$loginform = $('#home-password-reset-confirmed')
            if (!this.$loginform.length)
                return false;

            this.$loginform.validate({
                debug: true,
                submitHandler: function (form) {
                    var $form = $(form);
                    var data = $form.serializeArray();
                    $form.find(':input').attr('disabled', 'disabled');
                    $form.find('button').html('<i class="fa fa-spin fa-spinner"></i> change password');

                    $.ajax({
                        url: base + 'api/user/forgotpasswordconfirmed',
                        data: data,
                        method: 'post',
                        dataType: 'json',
                    }).done(function (data) {
                        if (data.status) {
                            $.confirm({
                                title: 'Redirecting to dashboard',
                                content: data.message,
                                closeIcon: false,
                                confirmButton: 'Goto Dashboard',
                                confirm: function () {
                                    location.href = dash_url;
                                }
                            });

                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        } else {
                            $.alert({
                                title: 'Problem',
                                content: data.reason,
                                confirmButton: 'close',
                                confirmButtonClass: 'btn btn-default'
                            });
                        }
                    }).always(function (data) {
                        $form.find(':input').removeAttr('disabled');
                        $form.find('button').html('change password');
                    });
                },
                rules: {
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 11,
                    },
                    password2: {
                        required: true,
                        equalTo: '#password',
                        minlength: 6,
                        maxlength: 11,
                    }
                },
                messages: {
                    password: {
                        required: 'Please enter password'
                    },
                    password2: {
                        required: 'Please re-enter password'
                    }
                }
            })
        },
        footerAlign: function () {
            var $footer = $('#footer');
            var fh = $footer.outerHeight();
            var bh = $('.footercalc').offset().top;
            var wh = $(window).height();
            if (bh < wh) {
                $footer.css({
                    'margin-top': wh - bh - fh
                });
            } else {
                $footer.css({
                    'margin-top': 0
                });
            }
        },
        socialLogins: function () {
            $('.login-via').on('click', function (e) {
                e.preventDefault();
                var via = $(this).data('id');
                window.location.href = home_url + 'api/user/authorize/' + via;
            });
        }
    }
    $(window).resize(function () {
        app.footerAlign();
    });
})(jQuery);