"use strict";

angular.module('Service.utils', [
    'ngStorage',
    'cp.ngConfirm',
    'ngSanitize',
]).service('Utils', [
    '$rootScope',
    '$localStorage',
    '$ngConfirm',
    '$http',
    'CATEGORY',
    'CATEGORY_TYPE',
    '$log',
    function ($rootScope, $localStorage, $ngConfirm, $http, CATEGORY, CATEGORY_TYPE, $log) {
        var that = this;

        this.defaultTitle = 'Numberbazaar.com';
        $rootScope.$storage = $localStorage;
        this.en = function (s) {
            return encodeURIComponent(btoa(btoa(s << 100)))
        };
        this.de = function (s) {
            return atob(atob(decodeURIComponent(s))) >> 100;
        };

        this.previouslyShownError = false;
        this.error = function (text, type) {
            if (this.previouslyShownError && this.previouslyShownError.isOpen())
                return false;

            this.previouslyShownError = $ngConfirm({
                title: 'Heads up',
                content: text || 'Something went wrong, Try again',
                buttons: {
                    ok: function () {

                    }
                },
                type: type || 'red',
            });

            return this.previouslyShownError;
        };
        this.validNumber = function (number, length) {

            if (typeof number != 'string' && typeof number != 'number')
                return false;

            number = number.toString();

            var l = true;
            if (length)
                l = length == number.length;

            return (!/[^\d]/.test(number)) && l;
        };

        this.setTitle = function (title, full) {
            full = full || false;
            that.title = title;
            if (!full)
                document.title = that.title + ' | ' + that.defaultTitle;
            else
                document.title = that.title;
            return document.title;
        };
        this.isEmpty = function (a) {
            return jQuery.isEmptyObject(a);
        };
        this.operatorSlug = function (operatorName) {
            if (typeof operatorName == 'undefined')
                return '';
            return operatorName.replace(/ /ig, '-').toLowerCase();
        };

        this.chunk_array = function (array, chunkSize) {
            return [].concat.apply([],
                array.map(function (elem, i) {
                    return i % chunkSize ? [] : [array.slice(i, i + chunkSize)];
                })
            );
        };

        this.help = function (helpUrl) {
            var content = "<span ng-bind-html='contentHere'></span><span ng-if='!contentHere'>Loading, please wait..</span>";
            $ngConfirm({
                title: 'Help topic',
                content: content,
                columnClass: 's',
                onReady: function (scope) {
                    var that = this;
                    $http.get(home_url + 'api/etc/help/' + helpUrl).then(function (res) {
                        that.title = res.data.data.title;
                        scope.contentHere = res.data.data.content;
                    });
                }
            });
        };
        this.categoryName = function (category_id) {
            var fname = '';
            angular.forEach(CATEGORY, function (id, name) {
                if (id == category_id)
                    fname = name;
            });
            return fname;
        };
        this.categoryTypeName = function (category_type_id) {
            var fname = '';
            angular.forEach(CATEGORY_TYPE, function (id, name) {
                if (id == category_type_id)
                    fname = name.substring(name.lastIndexOf('_') + 1, name.length);

                if(category_type_id == CATEGORY_TYPE.ON_DEMAND)
                    fname = 'on ' + fname;
            });
            return fname;
        };
        this.categoryTypeName2 = function (category_type_id) {
            var fname = '';
            angular.forEach(CATEGORY_TYPE, function (id, name) {
                if (id == category_type_id)
                    fname = name.replace(/_/, ' ');
            });
            return fname;
        };
        this.operatorName = function (operator_id) {
            var operator = $rootScope.operatorL.filter(function (a) {
                return a.id == operator_id;
            });
            if (angular.isDefined(operator[0]))
                return operator[0]['name'] || '';
            else
                return '';
        };
        this.circleName = function (circle_id) {
            var circle_names = {};
            angular.forEach($rootScope.circles, function (circle) {
                circle_names[circle.id] = circle.name;
            });
            return circle_names[circle_id];
        };
        this.docName = function (doc_id) {
            var doc = $rootScope.documents.filter(function (r) {
                return r.id == doc_id;
            });

            return (doc.length) ? doc[0]['name'] : false;
        };
        this.bundleName = function (bundle_id, bundles) {
            if (!angular.isDefined($rootScope.bundles) && typeof bundles == 'undefined')
                return '';

            if (typeof bundle_id == 'undefined')
                return '';

            if (typeof bundles != 'undefined')
                var bundles_a = bundles;
            else
                var bundles_a = angular.copy($rootScope.bundles);

            var bundle_name = false;
            angular.forEach(bundles_a, function (a) {
                if (a.id == bundle_id)
                    bundle_name = a.bundle_name;
            });
            return bundle_name;
        };
    }
]);