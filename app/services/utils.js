"use strict";

angular.module('ServiceUtils', [
    'ngSanitize',
]).service('Utils', [
    '$rootScope',
    '$localStorage',
    '$ngConfirm',
    '$http',
    '$log',
    function ($rootScope, $localStorage, $ngConfirm, $http, $log) {
        var that = this;

        this.defaultTitle = 'Gitftp';
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

            text = text || false;

            this.previouslyShownError = $ngConfirm({
                title: 'Heads up',
                content: "Something went wrong" +
                "<div ng-show='errorMessage'>" +
                "<hr>" +
                "Error: <br>" +
                "<code>{{errorMessage}}</code></div>",
                buttons: {
                    ok: function () {

                    }
                },
                type: type || 'red',
                onOpen: function (scope) {
                    scope.errorMessage = text;
                }
            });

            return this.previouslyShownError;
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

        this.chunk_array = function (array, chunkSize) {
            return [].concat.apply([],
                array.map(function (elem, i) {
                    return i % chunkSize ? [] : [array.slice(i, i + chunkSize)];
                })
            );
        };
    }
]);