/*!
 * angular-confirm v1.0.1 (http://craftpip.github.io/angular-confirm/)
 * Author: Boniface Pereira
 * Website: www.craftpip.com
 * Contact: hey@craftpip.com
 *
 * Copyright 2016-2016 angular-confirm
 * Licensed under MIT (https://github.com/craftpip/angular-confirm/blob/master/LICENSE)
 */

"use strict";

if (typeof jQuery === 'undefined')
    throw new Error('angular-confirm requires jQuery');
if (typeof angular === 'undefined')
    throw new Error('angular-confirm requires Angular');

try {
    angular.module('ngSanitize')
} catch (e) {
    throw new Error('angular-confirm requires ngSanitize: https://docs.angularjs.org/api/ngSanitize');
}

try {
    angular.module('ngAnimate')
} catch (e) {
    throw new Error('angular-confirm requires ngAnimate: https://docs.angularjs.org/api/ngSanitize');
}

angular.module('cp.ngConfirm', [
    'ngSanitize',
])
    .service('$ngConfirmTemplate', function () {
        var template = '<div class="ng-confirm">' +
            '<div class="ng-confirm-bg ng-confirm-bg-h" data-ng-style="ngc.styleBg"></div>' +
            '<div class="ng-confirm-scrollpane" data-ng-click="ngc._scrollPaneClick()">' +
            '<div class="ng-bs3-container">' +
            '<div class="ng-bs3-row">' +
            '<div class="ng-confirm-box" data-ng-click="ngc._ngBoxClick()" data-ng-class="[{\'ng-confirm-hilight\': ngc.hiLight}]" role="dialog" aria-labelledby="labelled" tabindex="-1">' +
            '<div class="ng-confirm-closeIcon" data-ng-show="ngc.closeIcon" data-ng-click="ngc._closeClick()"><span data-ng-if="!ngc.closeIconClass">&times;</span><i data-ng-class="ngc.closeIconClass" data-ng-if="ngc.closeIconClass"></i></div>' +
            '<div class="ng-confirm-title-c" ng-if="ngc.icon || ngc.title">' +
            '<span class="ng-confirm-icon-c" data-ng-if="ngc.icon"><i data-ng-class="ngc.icon"></i></span>' +
            '<span class="ng-confirm-title" data-ng-show="ngc.title">{{ngc.title}}</span>' +
            '</div>' +
            '<div class="ng-confirm-content-pane" data-ng-style="ngc.styleContentPane">' +
            '<div class="ng-confirm-content" data-ng-style="ngc.styleContent"></div>' +
            '</div>' +
            '<div class="ng-confirm-buttons">' +
            '<button type="button" data-ng-repeat="(key, button) in ngc.buttons" data-ng-click="ngc._buttonClick(key)" class="btn" data-ng-class="button.btnClass" ng-show="button.show" ng-disabled="button.disabled">{{button.text}}<span data-ng-show="button.timer"> ({{button.timer}})</span></button>' +
            '</div>' +
            '<div class="ng-confirm-clear">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '';

        return {'default': template};
    })
    .service('$ngConfirmDefaults', function () {
        return {
            title: 'Hello',
            titleClass: '',
            type: 'default',
            typeAnimated: true,
            content: 'Are you sure to continue?',
            contentUrl: false,
            defaultButtons: {
                ok: function () {

                },
            },
            icon: '',
            theme: 'white',
            bgOpacity: null,
            animation: 'zoom',
            closeAnimation: 'scale',
            animationSpeed: 400,
            animationBounce: 1.2,
            scope: false,
            escapeKey: false,
            rtl: false,
            buttons: {},
            container: 'body',
            containerFluid: false,
            backgroundDismiss: false,
            backgroundDismissAnimation: 'shake',
            alignMiddle: true,
            offsetTop: 50,
            offsetBottom: 50,
            autoClose: false,
            closeIcon: null,
            closeIconClass: false,
            watchInterval: 100,
            columnClass: 'small',
            boxWidth: '50%',
            useBootstrap: true,
            bootstrapClasses: {
                container: 'container',
                containerFluid: 'container-fluid',
                row: 'row',
            },
            onReady: function () {

            },
            onOpenBefore: function () {

            },
            onOpen: function () {

            },
            onClose: function () {

            },
            onDestroy: function () {

            },
            onAction: function () {

            }

        };
    })
    .service('$ngConfirmGlobal', [
        function () {
            var instances = [];
            return {
                instances: instances,
                closeAll: function () {
                    angular.forEach(instances, function (obj) {
                        if (!obj.isClosed())
                            obj.close();
                    });
                },
            }
        }
    ])
    .factory('$ngConfirm', [
        '$rootScope',
        '$ngConfirmDefaults',
        '$ngConfirmBase',
        '$ngConfirmGlobal',
        function ($rootScope, $ngConfirmDefaults, $ngConfirmBase, $ngConfirmGlobal) {
            var $ = jQuery; // using jquery.

            var ngConfirm = function (options, options2, option3) {
                if (typeof options == 'string') {
                    options = {
                        content: options,
                        buttons: $ngConfirmDefaults.defaultButtons
                    };
                    if (typeof options2 == 'string')
                        options['title'] = options2 || false;
                    else
                        options['title'] = false;
                    if (typeof options2 == 'object')
                        options['scope'] = options2;
                    if (typeof option3 == 'object')
                        options['scope'] = option3;
                }

                if (typeof options === 'undefined') options = {};

                /*
                 * merge options with plugin defaults.
                 */
                options = angular.extend({}, $ngConfirmDefaults, options);

                var obj = new $ngConfirmBase(options);
                $ngConfirmGlobal.instances.push(obj);
                return obj;
            };

            return ngConfirm;
        }
    ])
    .factory('$ngConfirmBase', [
        '$rootScope',
        '$ngConfirmDefaults',
        '$timeout',
        '$compile',
        '$ngConfirmTemplate',
        '$interval',
        '$templateRequest',
        '$log',
        '$q',
        function ($rootScope, $ngConfirmDefaults, $timeout, $compile, $ngConfirmTemplate, $interval, $templateRequest, $log, $q) {
            var ngConfirmBase = function (options) {
                /*
                 Merge up the options with the object !
                 */
                angular.extend(this, options);
                this._init();
            };

            ngConfirmBase.prototype = {
                _init: function () {
                    var that = this;

                    this._lastFocused = angular.element('body').find(':focus');
                    this._id = Math.round(Math.random() * 999999);
                    $timeout(function () {
                        that.open();
                    }, 0);
                },
                _prepare: function () {
                    var that = this;

                    // This is angular-confirm's scope. this is destroyed on close.
                    this._scope = $rootScope.$new();
                    this.$el = $compile($ngConfirmTemplate['default'])(this._scope);
                    this._scope.ngc = this;

                    // This is the scope that the user provided, the content is to be bind to this scope.
                    if (!that.scope)
                        that.scope = $rootScope.$new();
                    that.scope.ngc = this;

                    this._parseAnimation(this.animation, 'o');
                    this._parseAnimation(this.closeAnimation, 'c');
                    this._parseBgDismissAnimation(this.backgroundDismissAnimation);
                    this._parseTheme(this.theme);
                    this._parseButtons();
                    this._parseType(this.type);
                    this._parseColumnClass(this.columnClass);

                    this.$confirmBox = this.$el.find('.ng-confirm-box');
                    this.$titleContainer = this.$el.find('.ng-confirm-title-c');
                    this.$content = this.$el.find('.ng-confirm-content');
                    this.$confirmBg = this.$el.find('.ng-confirm-bg');
                    this.$contentPane = this.$el.find('.ng-confirm-content-pane');
                    this.$confirmContainer = this.$el.find('.ng-confirm-box-container');

                    this.$confirmBox.addClass(this.animationParsed).addClass(this.backgroundDismissAnimationParsed);
                    this.$el.addClass(this.typeParsed);
                    if (this.typeAnimated)
                        this.$confirmBox.addClass('ng-confirm-type-animated');

                    if (this.useBootstrap) {
                        this.$el.find('.ng-bs3-row').addClass(this.bootstrapClasses.row);
                        this.$confirmBox.addClass(this.columnClassParsed);
                        if (this.containerFluid)
                            this.$el.find('.ng-bs3-container').addClass(this.bootstrapClasses.containerFluid);
                        else
                            this.$el.find('.ng-bs3-container').addClass(this.bootstrapClasses.container);
                    } else {
                        this.$confirmBox.css('width', this.boxWidth).css('margin-left', 'auto').css('margin-right', 'auto');
                    }

                    if (this.titleClass)
                        this.$titleContainer.addClass(this.titleClass);

                    this.$el.addClass(this.themeParsed);

                    var ariaLabel = 'ng-confirm-box' + this._id;
                    this.$confirmBox.attr('aria-labelledby', ariaLabel);
                    this.$content.attr('id', ariaLabel);

                    if (this.bgOpacity != null)
                        this.$confirmBg.css('opacity', this.bgOpacity);

                    if (this.rtl)
                        this.$el.addClass('ng-confirm-rtl');

                    this._contentReady = $q.defer();
                    this._modalReady = $q.defer();

                    $q.all([this._contentReady.promise, this._modalReady.promise]).then(function () {
                        if (that.isAjax) {
                            that.setContent(that.content);
                            that.loading(false);
                        }
                        if(typeof that.onReady == 'function'){
                            that.onReady.apply(that, [that.scope]);
                        }
                    });

                    if (that.contentUrl) {
                        that.loading(true);
                        that.isAjax = true;
                        var contentUrl = that.contentUrl;
                        if (typeof that.contentUrl == 'function')
                            contentUrl = that.contentUrl();

                        that.loading(true);
                        that.isAjaxLoading = true;
                        $templateRequest(contentUrl).then(function (html) {
                            that.content = html;
                            that._contentReady.resolve();
                            that.isAjaxLoading = false;
                        }, function () {
                            that.content = '';
                            that._contentReady.resolve();
                            that.isAjaxLoading = false;
                        });
                    } else {
                        var content = that.content;
                        if (typeof that.content == 'function')
                            content = that.content();

                        that.content = content;
                        that.setContent(that.content);
                        that._contentReady.resolve();
                    }


                    this._watchContent();

                    if (this.animation == 'none') {
                        this.animationSpeed = 1;
                        this.animationBounce = 1;
                    }

                    this.$confirmBg.css(this._getCSS(this.animationSpeed, 1));
                },
                isAjax: false,
                isAjaxLoading: false,
                isLoading: false,
                loading: function (show) {
                    this.isLoading = show;
                    if (show)
                        this.$confirmBox.addClass('ng-confirm-loading');
                    else
                        this.$confirmBox.removeClass('ng-confirm-loading');
                },
                setContent: function (contentHtml) {
                    if (!this.$content) {
                        console.error('Attempted to set content before $content is defined');
                        return;
                    }
                    contentHtml = "<div>" + contentHtml + "</div>";
                    var compiledHtml = $compile(contentHtml)(this.scope);
                    this.$content.append(compiledHtml);
                },
                _typeList: ['default', 'blue', 'green', 'red', 'orange', 'purple', 'dark'],
                _typePrefix: 'ng-confirm-type-',
                typeParsed: '',
                _parseType: function (type) {
                    if (this._typeList.indexOf(type.toLowerCase()) == -1) {
                        console.warn('Invalid dialog type: ' + type);
                    } else {
                        this.typeParsed = this._typePrefix + type;
                    }
                },
                columnClassParsed: '',
                _parseColumnClass: function (colClass) {
                    colClass = colClass.toLowerCase();
                    var p;
                    switch (colClass) {
                        case 'xl':
                        case 'xlarge':
                            p = 'col-md-12';
                            break;
                        case 'l':
                        case 'large':
                            p = 'col-md-8 col-md-offset-2';
                            break;
                        case 'm':
                        case 'medium':
                            p = 'col-md-6 col-md-offset-3';
                            break;
                        case 's':
                        case 'small':
                            p = 'col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1';
                            break;
                        case 'xs':
                        case 'xsmall':
                            p = 'col-md-2 col-md-offset-5';
                            break;
                        default:
                            p = colClass;
                    }

                    this.columnClassParsed = p;
                },
                animationParsed: '',
                closeAnimationParsed: '',
                _animationPrefix: 'ng-confirm-animation-',
                _parseAnimation: function (animation, which) { // ready
                    which = which || 'o';
                    var animations = animation.split(',');
                    var that = this;
                    angular.forEach(animations, function (a, k) {
                        if (a.indexOf(that._animationPrefix) == -1)
                            animations[k] = that._animationPrefix + a.trim();
                    })
                    var a_string = animations.join(' ').toLowerCase();
                    if (which == 'o')
                        this.animationParsed = a_string;
                    else
                        this.closeAnimationParsed = a_string;

                    return a_string;
                },
                backgroundDismissAnimationParsed: '',
                _bgDismissPrefix: 'ng-confirm-hilight-',
                _parseBgDismissAnimation: function (bgDismissAnimation) { // ready
                    var animation = bgDismissAnimation.split(',');
                    var that = this;
                    angular.forEach(animation, function (a, k) {
                        if (a.indexOf(that._bgDismissPrefix) == -1)
                            animation[k] = that._bgDismissPrefix + a.trim();
                    });
                    this.backgroundDismissAnimationParsed = animation.join(' ').toLowerCase();
                },
                _parseButtons: function () { // ready
                    var that = this;

                    if (typeof this.buttons != 'object')
                        this.buttons = {};

                    angular.forEach(this.buttons, function (button, key) {
                        if (typeof button === 'function') {
                            that.buttons[key] = button = {
                                action: button
                            };
                        }

                        that.buttons[key].text = button.text || key;
                        that.buttons[key].btnClass = button.btnClass || 'btn-default';
                        that.buttons[key].action = button.action || angular.noop;
                        that.buttons[key].keys = button.keys || [];
                        that.buttons[key].disabled = button.disabled || false;
                        if (typeof button.show == 'undefined')
                            button.show = true;
                        that.buttons[key].show = button.show;

                        angular.forEach(that.buttons[key].keys, function (a, i) {
                            that.buttons[key].keys[i] = a.toLowerCase();
                        });
                    });

                    if (Object.keys(this.buttons).length == 0 && this.closeIcon === null)
                        this.closeIcon = true;
                },
                _themePrefix: 'ng-confirm-',
                themeParsed: '',
                _parseTheme: function (theme) { // done
                    var that = this;
                    var themes = theme.split(',');
                    angular.forEach(themes, function (theme, i) {
                        if (theme.indexOf(that._themePrefix) == -1)
                            themes[i] = that._themePrefix + theme.trim();
                    });
                    this.themeParsed = themes.join(' ').toLowerCase();
                },
                _cubic_bezier: '0.36, 0.55, 0.19',
                _getCSS: function (speed, bounce) {
                    return {
                        '-webkit-transition-duration': speed / 1000 + 's',
                        'transition-duration': speed / 1000 + 's',
                        '-webkit-transition-timing-function': 'cubic-bezier(' + this._cubic_bezier + ', ' + bounce + ')',
                        'transition-timing-function': 'cubic-bezier(' + this._cubic_bezier + ', ' + bounce + ')'
                    }
                },
                _hash: function (hash) {
                    return btoa((encodeURIComponent(hash)));
                },
                _watchContent: function () {
                    var that = this;

                    that._contentHash = this._hash(angular.element('<div>').append(that.$el.clone()).html());
                    that._contentHeight = this.$content.height();

                    if (this._watchTimer) clearInterval(this._watchTimer);
                    this._watchTimer = $interval(function () {
                        var now = that._hash(angular.element('<div>').append(that.$el.clone()).html());
                        var nowHeight = that.$content.height();
                        if (that._contentHash != now || that._contentHeight != nowHeight) {
                            that._contentHash = now;
                            that._contentHeight = nowHeight;
                            that.setDialogCenter('watchContent');
                        }
                    }, this.watchInterval);
                },
                _unwatchContent: function () {
                    clearInterval(this._watchTimer);
                },
                _bindEvents: function () {
                    var that = this;
                    this._scope.$watch('[ngc.alignMiddle, ngc.offsetTop, ngc.offsetBottom]', function () {
                        that.setDialogCenter('bindEvents');
                    });
                    var previousType = null;
                    this._scope.$watch('ngc.type', function () {
                        that._parseType(that.type);
                        if (previousType != null)
                            that.$el.removeClass(previousType);
                        that.$el.addClass(that.typeParsed);
                        previousType = that.typeParsed;
                    });
                    this._scope.$watch('ngc.typeAnimated', function () {
                        if (that.typeAnimated)
                            that.$el.addClass('ng-confirm-type-animated');
                        else
                            that.$el.removeClass('ng-confirm-type-animated');
                    });

                    this._scope.$watch('ngc.rtl', function () {
                        if (that.rtl)
                            that.$el.addClass('ng-confirm-rtl');
                        else
                            that.$el.removeClass('ng-confirm-rtl');
                    });

                    var previousTheme = null;
                    this._scope.$watch('ngc.theme', function () {
                        that._parseTheme(that.theme);
                        if (previousType != null)
                            that.$el.removeClass(previousTheme);
                        that.$el.addClass(that.themeParsed);
                        previousTheme = that.themeParsed;
                        that.setDialogCenter('bindEvents:theme');
                    });

                    if (this.useBootstrap) {
                        this._scope.$watch('ngc.columnClass', function () {
                            var pCol = that.columnClassParsed;
                            that._parseColumnClass(that.columnClass);
                            if (pCol != null)
                                that.$confirmBox.removeClass(pCol);
                            that.$confirmBox.addClass(that.columnClassParsed);
                        });
                    } else {
                        this._scope.$watch('ngc.boxWidth', function () {
                            that.$confirmBox.css('width', that.boxWidth);
                        });
                    }
                    angular.element(window).on('resize.' + that._id, function () {
                        that.setDialogCenter('Window Resize');
                    });
                    angular.element(window).on('keyup.' + that._id, function (e) {
                        that._reactOnKey(e);
                    });
                },
                _unBindEvents: function () {
                    angular.element(window).off('resize.' + this._id);
                    angular.element(window).off('keyup.' + this._id);
                },
                _reactOnKey: function (e) {
                    var that = this;

                    var openedModals = angular.element('.ng-confirm');
                    if (openedModals.eq(openedModals.length - 1)[0] !== this.$el[0])
                        return false;

                    var key = e.which;

                    if ($(this.$el).find(':input').is(':focus') && /13|32/.test(key)) {
                        return;
                    }

                    var keyChar = this._getKey(key);

                    if (keyChar === 'esc' && this.escapeKey) {
                        if (this.escapeKey == true) {
                            this._scrollPaneClick();
                        }
                        else if (typeof this.escapeKey == 'string' || typeof this.escapeKey == 'function') {
                            var buttonName = false;
                            if (typeof this.escapeKey == 'function') {
                                buttonName = this.escapeKey();
                            } else {
                                buttonName = this.escapeKey;
                            }

                            if (buttonName) {
                                if (!angular.isDefined(this.buttons[buttonName])) {
                                    console.warn('Invalid escapeKey, no buttons found with name ' + buttonName);
                                } else {
                                    this._buttonClick(buttonName);
                                }
                            }
                        }
                    }

                    angular.forEach(this.buttons, function (button, key) {
                        if (button.keys.indexOf(keyChar) != -1)
                            that._buttonClick(key);
                    })
                },
                _ngBoxClick: function () {
                    this.boxClicked = true;
                },
                _scrollPaneClick: function () {
                    if (this.boxClicked) {
                        this.boxClicked = false;
                        return false;
                    }


                    var buttonName = false;
                    var shouldClose = false;
                    var str;


                    if (typeof this.backgroundDismiss == 'function')
                        str = this.backgroundDismiss();
                    else
                        str = this.backgroundDismiss;

                    if (typeof str == 'string' && angular.isDefined(this.buttons[str])) {
                        buttonName = str;
                        shouldClose = false;
                    } else if (typeof str == 'undefined' || !!(str) == true) {
                        shouldClose = true;
                    } else {
                        shouldClose = false;
                    }

                    if (buttonName) {
                        var btnResponse = this.buttons[buttonName].action.apply(this, [this.scope, this.buttons[buttonName]]);
                        shouldClose = (typeof btnResponse == 'undefined') || !!(btnResponse);
                    }

                    if (shouldClose)
                        this.close();
                    else
                        this._hiLightModal();
                },
                _closeClick: function () {
                    var buttonName = false;
                    var shouldClose = false;
                    var str;

                    if (typeof this.closeIcon == 'function') {
                        str = this.closeIcon();
                    } else {
                        str = this.closeIcon;
                    }

                    if (typeof str == 'string' && angular.isDefined(this.buttons[str])) {
                        buttonName = str;
                        shouldClose = false;
                    } else if (typeof str == 'undefined' || !!(str) == true) {
                        shouldClose = true;
                    } else {
                        shouldClose = false;
                    }

                    if (buttonName) {
                        var btnResponse = this.buttons[buttonName].action.apply(this, [this.scope, this.buttons[buttonName]]);
                        shouldClose = (typeof btnResponse == 'undefined' || !!(btnResponse) == true);
                    }
                    if (shouldClose) {
                        this.close();
                    }
                },
                _hilightAnimating: false,
                _hiLightModal: function () {
                    var that = this;
                    if (this.hiLight)
                        return;

                    this.hiLight = true;
                    $timeout(function () {
                        that.hiLight = false;
                    }, 800);
                },
                _buttonClick: function (buttonKey) {
                    var res = this.buttons[buttonKey].action.apply(this, [this.scope, this.buttons[buttonKey]]);
                    if (typeof this.onAction === 'function')
                        this.onAction.apply(this, [this.scope, buttonKey]);

                    if (typeof res === 'undefined' || res)
                        this.close();

                    return res;
                },
                triggerButton: function (buttonKey) {
                    return this._buttonClick(buttonKey);
                },
                setDialogCenter: function (where) {
                    where = where || 'n/a';
                    var $content = this.$content;
                    var contentHeight = $content.outerHeight();
                    var contentPaneHeight = this.$contentPane.outerHeight();

                    var children = $content.children();
                    if (children.length != 0) {
                        // angular jq css will only return inline css.
                        var marginTopChild = parseInt(children.eq(0).css('margin-top'));
                        if (marginTopChild)
                            contentHeight += marginTopChild;
                    }

                    var windowHeight = angular.element(window).height();

                    var confirmBoxHeight = this.$confirmBox.outerHeight();
                    if (confirmBoxHeight == 0) {
                        // console.log(where, confirmBoxHeight);
                        return;
                    }
                    var boxHeight = (confirmBoxHeight - contentPaneHeight) + contentHeight;
                    var totalOffset = (this.offsetTop) + this.offsetBottom;
                    var style;
                    if (boxHeight > (windowHeight - totalOffset) || !this.alignMiddle) {
                        style = {
                            'margin-top': this.offsetTop,
                            'margin-bottom': this.offsetBottom,
                        };
                        angular.element('body').addClass('ng-confirm-no-scroll-' + this._id);
                    } else {
                        style = {
                            'margin-top': (windowHeight - boxHeight) / 2,
                            'margin-bottom': 0,
                        };
                        angular.element('body').removeClass('ng-confirm-no-scroll-' + this._id);
                    }

                    this.$contentPane.css({
                        'height': contentHeight,
                    }).scrollTop(0);
                    this.$confirmBox.css(style);
                },
                _getKey: function (key) {
                    // very necessary keys.
                    switch (key) {
                        case 192:
                            return 'tilde';
                        case 13:
                            return 'enter';
                        case 16:
                            return 'shift';
                        case 9:
                            return 'tab';
                        case 20:
                            return 'capslock';
                        case 17:
                            return 'ctrl';
                        case 91:
                            return 'win';
                        case 18:
                            return 'alt';
                        case 27:
                            return 'esc';
                    }

                    // only trust alphabets with this.
                    var initial = String.fromCharCode(key);
                    if (/^[A-z0-9]+$/.test(initial))
                        return initial.toLowerCase();
                    else
                        return false;
                },
                open: function () {
                    var that = this;
                    this._prepare();
                    $timeout(function () {
                        that._open();
                    }, 100);

                    return true;
                },
                _open: function () {
                    var that = this;

                    if (typeof that.onOpenBefore == 'function')
                        that.onOpenBefore.apply(that, [that.scope]);

                    // console.log(that.$el.html());
                    angular.element(that.container).append(that.$el);
                    that.setDialogCenter('_open');

                    $timeout(function () {
                        // console.log(that.$el.html());
                        that.$contentPane.css(that._getCSS(that.animationSpeed, 1));
                        that.$confirmBox.css(that._getCSS(that.animationSpeed, that.animationBounce));
                        that.$confirmBox.removeClass(that.animationParsed);
                        that.$confirmBg.removeClass('ng-confirm-bg-h');
                        that.$confirmBox.focus();
                        $timeout(function () {
                            that._bindEvents();
                            that.$confirmBox.css(that._getCSS(that.animationSpeed, 1));
                            that._modalReady.resolve();
                            if (typeof that.onOpen === 'function')
                                that.onOpen.apply(that, [that.scope]);

                            that._startCountDown();
                        }, that.animationSpeed);
                    }, 100);
                },
                _startCountDown: function () {
                    var that = this;
                    if (typeof this.autoClose != 'string') return;
                    var opt = this.autoClose.split('|');
                    if (opt.length != 2) {
                        $log.error('Invalid option for autoClose. example \'close|10000\'');
                        return;
                    }
                    this.autoCloseKey = opt[0];
                    var time = opt[1];
                    var sec = time / 1000;

                    if (!angular.isDefined(this.buttons[this.autoCloseKey])) {
                        $log.error('Auto close button "' + that.autoCloseKey + '" not defined.');
                        return;
                    }

                    that.buttons[that.autoCloseKey].timer = sec;
                    this.autoCloseInterval = $interval(function () {
                        that.buttons[that.autoCloseKey].timer = --sec;
                        if (sec < 1) {
                            that._stopCountDown();
                            that._buttonClick(that.autoCloseKey);
                        }
                    }, 1000);
                },
                _stopCountDown: function () {
                    if (angular.isDefined(this.autoCloseInterval)) {
                        $interval.cancel(this.autoCloseInterval);
                        this.autoCloseInterval = undefined;
                        this.buttons[this.autoCloseKey].timer = false;
                    }
                },
                closed: false,
                isClosed: function () {
                    return this.closed;
                },
                isOpen: function () {
                    return !this.closed;
                },
                close: function () {
                    var that = this;
                    if (typeof this.onClose === 'function')
                        this.onClose.apply(this, [this.scope]);

                    this._unwatchContent();
                    this._unBindEvents();
                    this._stopCountDown();

                    this.$confirmBox.addClass(this.closeAnimationParsed);
                    this.$confirmBg.addClass('ng-confirm-bg-h');
                    var closeTimer = this.animationSpeed * .4;

                    $timeout(function () {
                        that._lastFocused.focus();
                        that.closed = true;
                        that.$el.remove();
                        that._scope.$destroy();

                        if (typeof that.onDestroy == 'function')
                            that.onDestroy.apply(that, [that.scope]);

                        angular.element('body').removeClass('ng-confirm-no-scroll-' + that._id);
                    }, closeTimer);

                    return true;
                }
            };

            return ngConfirmBase;
        }
    ]);