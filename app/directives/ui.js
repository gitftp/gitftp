"use strict";

angular.module('UI.directives', [
    'ngAnimate',
]).directive('topHeader', [
    '$rootScope',
    function ($rootScope) {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/partials/topheader.html',
            link: function (scope, element) {
                scope.tawk_api_loaded = false;
                scope.open_chat = function () {
                    Tawk_API.toggle();
                };

                Tawk_API = Tawk_API || {};
                Tawk_API.onLoad = function () {
                    scope.tawk_api_loaded = true;
                    if ($rootScope.user) {
                        Tawk_API.visitor = {
                            name: $rootScope.user.username,
                            email: $rootScope.user.email,
                        };
                        Tawk_API.setAttributes({
                            'circle': $rootScope.user.circle,
                            'mobile': $rootScope.user.mobile,
                        }, function (error) {});
                    }
                    scope.$apply();
                };

            }
        }
    }
]).directive('header', [
    '$location',
    '$rootScope',
    '$routeParams',
    '$window',
    '$lastSearches',
    '$timeout',
    function ($location, $rootScope, $routeParams, $window, $lastSearches, $timeout) {
        if ($location.search().not_a_customer == 1) {
            $.alert({
                title: false,
                content: '<div class="space10"></div>' +
                'Your account is associated with admin privileges, please click on the link below to login: <br>' +
                '<a href="' + admin_url + '">ADMIN LOGIN</a>'
            }).$el.css('z-index', 999999999999);
        }

        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/partials/header.html',
            link: function ($scope, $element, $attr) {
                $scope.uni_search_term_f = '';

                $scope.$location = $location;
                $scope.$watch('$location.path()', function (locationPath) {
                    $window.ga('send', 'pageview', {page: $location.url()});

                    var l = locationPath.substring(1, locationPath.length);
                    l = (l == '') ? 'home' : l;
                    if (angular.isDefined($scope.titles[l])) {
                        $scope.utils.setTitle($scope.titles[l], true);
                    } else {
                        $scope.utils.setTitle('Prepaid | Postpaid | MNP | DTH | Recharge');
                    }

                    var term = locationPath.split('/');
                    term = term[1];

                    if (locationPath == '/home') {
                        $scope.collapse = false;
                    } else {
                        if (term == 'prepaid' || term == 'postpaid' || term == 'ready-to-port-numbers')
                            $rootScope.page_category = term;

                        $scope.collapse = true;
                    }

                    if (typeof $rootScope.page_category == 'undefined')
                        $rootScope.page_category = 'prepaid';

                    if ($rootScope.page_category != 'prepaid' && $rootScope.page_category != 'postpaid')
                        $rootScope.menu_category = 'prepaid';
                    else
                        $rootScope.menu_category = $rootScope.page_category;
                });

                $scope.isActive = function (link) {
                    return $scope.$location.path() == link;
                };

                $scope.uni_search_term_error = '';
                $scope.uni_form_disabled = false;

                $scope.show_recent = false;
                $scope.uni_recents = [];

                $scope.uni_recent_s = function (term) {
                    $scope.uni_search_term = term;
                    $scope.uni_search();
                };

                $scope.uni_blur = function () {
                    $timeout(function () {
                        $scope.show_recent = false
                    }, 50);
                };

                $scope.uni_focus = function () {
                    var list = $lastSearches.last_searches().reverse();
                    if (list.length == 0)
                        return false;

                    $scope.show_recent = true;
                    if (list.length > 15) {
                        list.splice(15, list.length - 15);
                    }
                    $scope.uni_recents = list;
                };

                $scope.uni_search = function () {
                    $scope.uni_search_term_f = $scope.uni_search_term;
                    if ($location.path() == '/search')
                        $rootScope.$broadcast('uni-search');
                    $location.path('search').search('q', $scope.uni_search_term);
                    $scope.show_recent = false;
                };

                $scope.uni_e = function () {
                    $scope.uni_search_term = $scope.uni_search_term || '';
                    var t = $scope.uni_search_term.toString();
                    $scope.uni_search_term = t.replace(/\D/ig, '');

                    $scope.uni_search_term_error = '';
                    $scope.uni_form_disabled = false;

                    if (t.length == 10) {
                        var a = t.substring(2, 7);
                        var b = t.substring(5, 10);
                        $scope.uni_search_term_error = 'A full mobile number match is hard to find, try ' + a + ', ' + b + ' instead';
                    }
                    if (t.length > 10) {
                        $scope.uni_form_disabled = true;
                        $scope.uni_search_term_error = 'Please enter a search pattern below 10 digits';
                    }
                    if (t.length > 15) {
                        $scope.uni_search_term_error = 'This is not a mobile number for sure.';
                    }
                    if (t.length > 19) {
                        $scope.uni_search_term_error = 'As if you\'re gonna remember this.';
                    }
                };
            }
        }
    }
]).directive('footer', [
    '$location',
    '$window',
    function ($location, $window) {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/partials/footer.html',
            link: function ($scope, $element, $attr) {
                $scope.gt_path = function (path) {
                    $location.path(path);
                };
                $scope.isActive = function (link) {
                    return $scope.$location.path() == link;
                };
                $scope.gt = function () {
                    angular.element(window).scrollTop(0);
                };
            }
        }
    }
]).directive('loginModal', [
    'AuthService',
    '$http',
    '$timeout',
    '$ngConfirm',
    '$interval',
    '$rootScope',
    function (AuthService, $http, $timeout, $ngConfirm, $interval, $rootScope) {
        return {
            restrict: 'A',
            replace: true,
            templateUrl: 'app/partials/login.html',
            link: function ($scope, $element, $attr) {
                var lm = $scope.lm = $scope.loginModal = {};
                $scope.open_login = false;
                $scope.open_signup = false;
                $scope.open_forgotpassword = false;
                lm.callback = false;
                $scope.oauth_window = null;
                $scope.oauth_post_p = null

                lm.ask_circle_mobile = function () {
                    if (AuthService.isAuthenticated() && $scope.user.mobile_verified == 0) {
                        if ($scope.oauth_post_p)
                            return false;

                        $timeout(function () {
                            $scope.oauth_post_p = $ngConfirm({
                                title: false,
                                closeIcon: false,
                                backgroundDismiss: false,
                                contentUrl: '/app/partials/post_oauth.html',
                                onOpen: function (scope) {
                                    scope.error = false;
                                    scope.p = false;
                                    scope.sent = false;
                                    scope.auth = {
                                        circle: $rootScope.user.circle,
                                        mobile: $rootScope.user.mobile,
                                    };
                                    scope.submit = function () {
                                        var c = scope.auth.circle;
                                        var m = scope.auth.mobile;
                                        var otp = scope.auth.otp;
                                        scope.p = true;
                                        scope.error = false;
                                        var post_data;
                                        if (otp) {
                                            post_data = {
                                                'circle': c,
                                                'mobile': m,
                                                'otp': otp,
                                            };
                                        } else {
                                            scope.sent = false;
                                            post_data = {
                                                'circle': c,
                                                'mobile': m,
                                                'otp': otp,
                                            };
                                        }

                                        $http.post(home_url + 'api/sec/user/update', post_data).then(function (res) {
                                            scope.p = false;
                                            if (res.data.status) {
                                                if (otp) {
                                                    scope.sent = true;
                                                    AuthService.updateUser();
                                                    $scope.oauth_post_p.close();
                                                } else {
                                                    scope.sent = true;
                                                    $timeout(function () {
                                                        angular.element('.eotp').focus();
                                                    }, 100);
                                                }
                                            } else {
                                                if (!otp)
                                                    scope.sent = false;
                                                scope.error = res.data.reason;
                                            }
                                        });
                                    };
                                    scope.otpChange = function () {
                                        if (scope.auth.otp.toString().length != 4)
                                            return false;

                                        scope.submit();
                                    };
                                },
                                // theme: 'modern',
                            });
                        }, 1000);
                    }
                };

                $rootScope.$on('user-login', function () {
                    lm.ask_circle_mobile();
                });
                lm.ask_circle_mobile();

                lm.login = function (callback) {
                    if (typeof callback == 'function') {
                        lm.callback = callback;
                    }

                    lm.closeAll();
                    $scope.open_login = true;
                    $timeout(function () {
                        angular.element('.l-m-c').focus();
                    }, 300);
                };
                lm.closeAll = function () {
                    $scope.open_login = false;
                    $scope.open_signup = false;
                    $scope.open_forgotpassword = false;
                    lm.cancel_otp();
                    $scope.form_login.$setPristine();
                    $scope.form_login.$setUntouched();
                    $scope.form_signup.$setPristine();
                    $scope.form_signup.$setUntouched();
                    $scope.form_forgotpassword.$setPristine();
                    $scope.form_forgotpassword.$setUntouched();
                };
                lm.signup = function () {
                    lm.closeAll();
                    $scope.open_signup = true;
                    $timeout(function () {
                        angular.element('.s-m-c').focus();
                    }, 300);
                };

                lm.cancel_otp = function () {
                    lm.signup_token = false;
                    lm.otp = null;
                    lm.loadingSP = false;
                    lm.loadingS = false;
                    lm.otp_error = false;
                };
                lm.forgotpassword = function () {
                    lm.closeAll();
                    $scope.open_forgotpassword = true;
                    $timeout(function () {
                        angular.element('.f-m-c').focus();
                    }, 300);
                };

                lm.close = function () {
                    lm.closeAll();
                    if (lm.callback)
                        lm.callback = false;
                    if ($scope.watchPopupTimer)
                        $interval.cancel($scope.watchPopupTimer);
                };

                lm.clear = function () {
                    $scope.login = {};
                    $scope.signup = {};
                    $scope.forgotpassword = {};
                };
                lm.clear();

                // signup step1.
                lm.loadingSP = false;
                lm.signup_token = false;
                lm.signup_error = false;

                lm.signup_proceed = function () {
                    lm.loadingSP = true;
                    lm.signup_error = false;
                    AuthService.signup($scope.signup).then(function (res) {
                        lm.signup_token = res.data.token;
                        lm.loadingSP = false;
                        lm.start_otp_timer();
                    }, function (res) {
                        lm.signup_error = res.data.reason;
                        lm.loadingSP = false;
                    });
                };
                // end signup step1.

                // signup step2
                lm.otp = null;
                lm.loadingS = false;
                lm.otp_change = function () {
                    var otp = parseInt(lm.otp);
                    if (otp.toString().length != 4)
                        return;

                    lm.doSignup();
                };

                lm.login_via_mobile = false;
                lm.login_via_c = function () {
                    var a = $scope.login.email;
                    lm.login_via_mobile = !(/\D/.test(a));
                };
                lm.otp_error = false;
                lm.otp_send_time = 10; // 10 seconds.
                lm.start_otp_timer = function () {
                    if (lm.timer)
                        $interval.cancel(lm.timer);
                    lm.timer = $interval(function () {
                        lm.otp_send_time -= 1;
                        if (lm.otp_send_time <= 0)
                            $interval.cancel(lm.timer);
                    }, 1000);
                };
                lm.resending_sms = false;
                lm.resend_sms = function () {
                    if (lm.resending_sms)
                        return false;

                    lm.resending_sms = true;
                    AuthService.resend_signup_otp(lm.signup_token).then(function (r) {
                        lm.resending_sms = false;
                    }, function (r) {
                        lm.resending_sms = false;
                        alert(r.data.reason);
                    })
                };
                lm.doSignup = function () {
                    lm.loadingS = true;
                    lm.otp_error = false;
                    AuthService.signup({
                        token: lm.signup_token,
                        otp: lm.otp,
                    }).then(function (res) {
                        $ngConfirm({
                            title: 'Welcome!',
                            content: 'You\'re account has been successfully created. We have sent you an activation email, please head on to your email id and follow instructions.'
                        });
                        lm.clear();
                        lm.close();
                        lm.loadingS = false;
                    }, function (res) {
                        lm.otp_error = res.data.reason;
                        lm.loadingS = false;
                    })
                };

                lm.loadingLogin = false;
                lm.doLogin = function () {
                    lm.loadingLogin = true;
                    AuthService.login($scope.login).then(function (res) {
                        if (lm.callback)
                            lm.callback();

                        lm.clear();
                        lm.close();
                        lm.loadingLogin = false;
                    }, function (res) {
                        $.alert({
                            title: false,
                            content: '<div class="space10"></div>' + res.data.reason,
                        }).$el.css('z-index', 999999999999);
                        lm.loadingLogin = false;
                    })
                };

                lm.loadingFP = false;
                lm.doFp = function () {
                    lm.loadingFP = true;
                    AuthService.forgotpassword($scope.forgotpassword).then(function (res) {
                        lm.clear();
                        lm.close();
                        $.alert({
                            title: 'Sent!',
                            content: 'We\'ve sent you an email. Please go to your inbox and follow the instructions.'
                        }).$el.css('z-index', 999999999999);
                        lm.loadingFP = false;
                    }, function (res) {
                        $.alert({
                            title: false,
                            content: '<div class="space10"></div>' + res.data.reason
                        }).$el.css('z-index', 999999999999);
                        lm.loadingFP = false;
                    })
                };
                lm.resend_v_e = function () {
                    if (angular.isUndefined($rootScope.user.email_verified) || $rootScope.user.email_verified == 1)
                        return;

                    $ngConfirm({
                        title: 'E-mail verification',
                        scope: $rootScope,
                        content: '{{user.email}} is not verified, if you\'ve not received the e-mail yet check the spam folder or try resending the e-mail.',
                        buttons: {
                            resend: {
                                text: 'send e-mail',
                                btnClass: 'btn-green',
                                action: function (scope) {
                                    AuthService.resend_signup_email($rootScope.user.id).then(function (r) {
                                        $ngConfirm({
                                            title: 'E-mail sent!',
                                            content: 'A verification e-mail has been sent to {{user.email}}. ' +
                                            'Please go to your email account and follow the instructions in the mail',
                                            closeIcon: false,
                                            buttons: {
                                                close: function () {},
                                            },
                                            scope: $rootScope,
                                            onOpen: function (scope2) {
                                            }
                                        });
                                    }, function (r) {
                                        $ngConfirm(r);
                                    });
                                }
                            },
                            later: function () {

                            }
                        }
                    });
                };
                lm.logout = function () {
                    AuthService.logout().then(function (res) {
                        lm.clear();
                        lm.close();
                    }, function (res) {
                        $.alert({
                            title: false,
                            content: '<div class="space10"></div>' + res.data.reason,
                        }).$el.css('z-index', 999999999999);
                    })
                };

                lm.facebook = function () {
                    if ($scope.oauth_window == null || $scope.oauth_window.closed) {
                        $scope.oauth_window = window.open(home_url + 'user/authenticate/facebook', 'Facebook login', 'width=600px,height=500px,resizable');
                        $scope.watchPopupModel();
                        $scope.loadMessageShow = 'Waiting for login';
                    } else {
                        $scope.oauth_window.focus();
                    }
                };
                lm.google = function () {
                    if ($scope.oauth_window == null || $scope.oauth_window.closed) {
                        $scope.oauth_window = window.open(home_url + 'user/authenticate/google', 'Google login', 'width=600px,height=500px,resizable');
                        $scope.watchPopupModel();
                        $scope.loadMessageShow = 'Waiting for login';
                    } else {
                        $scope.oauth_window.focus();
                    }
                };
                $scope.watchPopupModel = function () {
                    $scope.watchPopupTimer = $interval(function () {
                        if ($scope.oauth_window.closed) {
                            $scope.loadMessageShow = 'Setting up right now';

                            AuthService.updateUser(function (res) {
                                if (res.data.status) {
                                    if (lm.callback)
                                        lm.callback();

                                    lm.clear();
                                    lm.close();
                                } else {
                                    lm.clear();
                                    lm.close();

                                    $ngConfirm({
                                        title: false,
                                        content: 'Sorry, something went wrong while login. ' +
                                        '<br>Please try again later.',
                                    });
                                }
                                $scope.loadMessageShow = false;
                            });
                            $interval.cancel($scope.watchPopupTimer);
                        }
                    }, 1000);
                };
            }
        }
    }
]);