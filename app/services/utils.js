"use strict";

angular.module('ServiceUtils', [
    'ngSanitize',
]).service('Utils', [
    '$rootScope',
    '$localStorage',
    '$ngConfirm',
    '$http',
    '$log',
    'Const',
    function ($rootScope, $localStorage, $ngConfirm, $http, $log, Const) {
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
        this.error = function (text, type, retryCallback) {
            if (this.previouslyShownError && this.previouslyShownError.isOpen())
                return false;

            text = text || false;

            var buttons = {
                ok: function () {

                },
            };

            if (retryCallback)
                buttons['retry'] = retryCallback;

            this.previouslyShownError = $ngConfirm({
                title: 'Heads up',
                content: "Something went wrong" +
                "<div ng-show='errorMessage'>" +
                "<hr>" +
                "Error: <br>" +
                "<code>{{errorMessage}}</code></div>",
                buttons: buttons,
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

        this.hash = function (string) {
            string = string.toString();
            var hash = 0;
            if (string.length == 0) return hash;
            for (var i = 0; i < string.length; i++) {
                var char = string.charCodeAt(i);
                hash = ((hash << 5) - hash) + char;
                hash = hash & hash; // Convert to 32bit integer
            }
            return hash;
        };

        this.cloneState = function (state) {
            if (state == Const.clone_state_cloned)
                return 'Cloned';
            else if (state == Const.clone_state_cloning)
                return 'Cloning';
            else if (state == Const.clone_state_not_cloned)
                return 'Not cloned';
            else
                return state;
        };

        this.recordStatus = function (state) {
            switch (state) {
                case Const.record_status_failed:
                    return 'Failed';
                case Const.record_status_in_progress:
                    return 'In progress';
                case Const.record_status_new:
                    return 'New';
                case Const.record_status_success:
                    return 'Success';
                default:
                    return state;
            }
        };

        this.recordType = function (state) {
            switch (state) {
                case Const.record_type_clone:
                    return 'Clone';
                case Const.record_type_update:
                    return 'Update';
                case Const.record_type_re_upload:
                    return 'Re-upload';
                default:
                    return state;
            }
        };
    }
]);