"use strict";

angular.module('Service.service', [
        'ngStorage',
        'cp.ngConfirm',
        'ngSanitize',
        'Service.utils',
        'Service.auth',
    ])
    .factory('$lastSearches', [
        '$rootScope',
        '$localStorage',
        '$interval',
        '$http',
        'AuthService',
        function ($rootScope, $localStorage, $interval, $http, AuthService) {
            var parseAuthUserSearches = function (searches) {
                var b = [];
                angular.forEach(searches, function (a) {
                    if (a) {
                        b.push({term: a});
                    }
                });
                return b;
            };

            var $ls = $localStorage;
            $ls.last_searches = $ls.last_searches || [];
            var current = JSON.stringify($ls.last_searches);

            $rootScope.$on('user-logout', function () {
                $ls.last_searches = [];
            });
            $rootScope.$on('user-login', function () {
                if (angular.isDefined($rootScope.user.profile_fields.last_searches) && typeof $rootScope.user.profile_fields.last_searches == 'object') {
                    $ls.last_searches = parseAuthUserSearches($rootScope.user.profile_fields.last_searches);
                    current = JSON.stringify($ls.last_searches);
                }
            });

            $interval(function () {
                if (!AuthService.isAuthenticated())
                    return false;

                var most_current = JSON.stringify($ls.last_searches);
                if (current != most_current) {
                    $http.post(home_url + 'api/sec/user/uls', {
                        s: $ls.last_searches
                    });
                    current = most_current;
                }
            }, 10000);

            return {
                last_searches: function () {
                    return angular.copy($ls.last_searches || []);
                },
                get_last: function () {
                    if (typeof $ls.last_searches === 'object' && $ls.last_searches.length)
                        return $ls.last_searches[$ls.last_searches.length - 1];
                    else
                        return false;
                },
                add: function (term) {
                    angular.forEach($ls.last_searches, function (a, i) {
                        if (term == a.term || a.term == '' || !a.term)
                            $ls.last_searches.splice(i, 1);
                    });

                    var length = $ls.last_searches.push({
                        'term': term.toString(),
                    });

                    return length - 1;
                },
                update: function (index, set) {
                    var updated = angular.extend({}, $ls.last_searches[index], set);
                    $ls.last_searches[index] = updated;
                }
            }
        }
    ])
    .factory('$numberService', [
        '$rootScope',
        '$localStorage',
        '$ngConfirm',
        '$http',
        'CATEGORY',
        'CATEGORY_TYPE',
        '$log',
        '$q',
        'Utils',
        'AuthService',
        '$location',
        function ($rootScope, $localStorage, $ngConfirm, $http, CATEGORY, CATEGORY_TYPE, $log, $q, Utils, AuthService, $location) {

            var r = {
                fetchNumberOwner: function () {
                    var that = this;
                    $http.post('/api/numbers/go', {
                        id: that.pop.id,
                    }).then(function (res) {
                        that.pop.owner_name = res.data.data.owner_name;
                        that.pop.number_age = res.data.data.number_age;
                    });
                },
                pincode: {},
                /**
                 * The init function
                 * @param number
                 */
                viewPlan: function (number) {
                    var that = this;
                    this.submitting = false;
                    this.renderedPlans = [];
                    this.pop = angular.copy(number);
                    this.loadingPlans = false;

                    this.pincode = {
                        valid: false,
                        available: false,
                        checking: false,
                    };
                    this.c = $ngConfirm({
                        title: false,
                        contentUrl: '/app/partials/plan-details/common.html',
                        onOpen: function (scope) {
                            scope.pop = that.pop;
                            scope.o = that;
                        }
                    });
                    if (number.category_type == CATEGORY_TYPE.CATEGORY_TYPE_RTP)
                        this.fetchNumberOwner();

                    this.checkAvailability();

                    if (number.category_type == CATEGORY_TYPE.CATEGORY_TYPE_ONDEMAND && number.category == CATEGORY.PREPAID)
                        this.loadOnDemandPlans();
                    else if (number.category == CATEGORY.PREPAID && number.category_type != CATEGORY_TYPE.CATEGORY_TYPE_RTP)
                        this.loadNumberDetailPlans();

                    if (this.pop.category_type == CATEGORY_TYPE.POSTPAID_FANCY ||
                        (this.pop.category_type == CATEGORY_TYPE.CATEGORY_TYPE_ONDEMAND && this.pop.category == CATEGORY.PREPAID)) {
                        this.isPlanInclusive = true;
                    } else {
                        this.isPlanInclusive = false;
                    }
                },
                selectPlan: function (plan) {
                    console.log(plan);
                    this.pop.selectedPlan = plan;
                    if (this.pop.category_type == CATEGORY_TYPE.POSTPAID_GENERAL) {
                        this.pop.value = plan.value;
                    }
                },
                loadNumberDetailPlans: function () {
                    var that = this;
                    this.loadingPlans = true;
                    $http.get('/api/numbers/plans/' + this.pop.id).then(function (res) {
                        if (res.data.status) {
                            that.renderedPlans = res.data.data;
                            if (that.renderedPlans.length == 1) {
                                that.selectPlan(that.renderedPlans[0]);
                            }
                        } else {
                            $.alert({content: res.data.reason});
                            that.c.close();
                        }
                        that.loadingPlans = false;
                    }, function () {
                        that.loadingPlans = false;
                    });
                },
                loadOnDemandPlans: function () {
                    var that = this;
                    this.loadingPlans = true;
                    $http.get('/api/numbers/plans_od/' + this.pop.circle_id + '/' + this.pop.operator_id).then(function (res) {
                        if (res.data.status) {
                            that.renderedPlans = res.data.data;
                            if (that.renderedPlans.length == 1) {
                                that.pop.selectedPlan = that.renderedPlans[0];
                            }
                        } else {
                            $.alert({content: res.data.reason});
                            that.c.close();
                        }
                        that.loadingPlans = false;
                    }, function () {
                        that.loadingPlans = false;
                    });
                },
                checkAvailability: function () {
                    var that = this;
                    var pincode = $localStorage.userPincode;
                    pincode = (pincode) ? pincode : '';

                    if (pincode.toString().split('').length != 6) {
                        this.pincode.valid = false;
                        return false;
                    }

                    this.pincode.valid = true;

                    $localStorage.userPincode = pincode;

                    if (this.defer)
                        this.defer.resolve();

                    this.defer = $q.defer();

                    this.pincode.available = false;
                    this.pincode.checking = true;

                    $http.post('/api/etc/service_available', {
                        pincode: pincode,
                        item_id: this.pop.id,
                        item_cat_type: this.pop.category_type,
                    }, {
                        timeout: this.defer.promise
                    }).then(function (res) {
                        that.pincode.checking = false;

                        that.pincode.available = res.data.status;

                        if (!that.pincode.available) {
                            that.pincode.reason = res.data.reason;
                        }
                    });
                },
                isDisabled: function () {
                    if (this.pop.category_type != '15' && this.pop.category == 1 && !this.pop.selectedPlan)
                        return true;

                    if (this.submitting)
                        return true;

                    if (this.pop.category_type == '15' && this.pincode.valid && !this.pincode.checking && $rootScope.rtp_f_r_b == '1')
                        return false;

                    if (this.pop.category_type != '15' && this.pincode.valid && !this.pincode.checking && this.pincode.available)
                        return false;

                    return true;
                },
                isAction: function () {
                    if (this.pop.category == CATEGORY.PREPAID && this.pop.category_type != CATEGORY_TYPE.CATEGORY_TYPE_RTP) return 'Add to cart';
                    else return 'Proceed';
                },
                bookNumber: function () {
                    var that = this;
                    this.submitting = true;
                    if (this.isAction() == 'Proceed') {
                        var i = Utils.en(this.pop.id);
                        if (AuthService.isAuthenticated()) {
                            if (this.pop.category == CATEGORY.POSTPAID)
                                $location.url('/booking/postpaid/' + this.pop.id + '/' + this.pop.category_type);
                            else
                                $location.url('/product/i/' + i); // rtp
                        } else {
                            $rootScope.loginModal.login(function () {
                                if (that.pop.category == CATEGORY.POSTPAID)
                                    $location.url('/booking/postpaid/' + that.pop.id + '/' + that.pop.category_type);
                                else
                                    $location.url('/product/i/' + i);
                            });
                        }
                        this.submitting = false;
                        this.c.close();
                    } else {
                        var number = angular.copy(that.pop);
                        number.pincode = $localStorage.userPincode;

                        if (AuthService.isAuthenticated()) {
                            $rootScope.cart.add('number', number, function (res) {
                                that.afterAddingToCart(res);
                                that.submitting = false;
                            }, function () {
                                that.submitting = false;
                                Utils.error();
                            });
                        } else {
                            $rootScope.loginModal.login(function () {
                                $rootScope.cart.add('number', number, function (res) {
                                    that.afterAddingToCart(res);
                                    that.submitting = false;
                                }, function () {
                                    that.submitting = false;
                                });
                            });
                        }
                    }
                },
                afterAddingToCart: function (res) {
                    if (res.data.status) {
                        this.c.close();
                        $ngConfirm({
                            title: false,
                            content: '<div class="space10 hide"></div>' +
                            'Awesome!, Successfully added to your cart.',
                            buttons: {
                                viewCart: {
                                    text: 'view cart',
                                    action: function () {
                                        $location.path('/cart');
                                    }
                                },
                                close: function () {

                                }
                            }
                        });
                    } else {
                        Utils.error(res.data.reason, 'red');
                    }
                },
            };

            return r;
        }
    ]);