/* /themes/horoshop_default/layout/js/vendor/jquery.selectBoxIt.custom.js */

/*! jquery.selectBoxIt - v3.8.1 - 2013-10-17
* http://www.selectboxit.com
* Copyright (c) 2013 Greg Franko; Licensed MIT*/
;(function(selectBoxIt) {
    "use strict";
    selectBoxIt(window.jQuery, window, document)
}(function($, window, document, undefined) {
    "use strict";
    $.widget("selectBox.selectBoxIt", {
        VERSION: "3.8.2",
        options: {
            "showEffect": "none",
            "showEffectOptions": {},
            "showEffectSpeed": "medium",
            "hideEffect": "none",
            "hideEffectOptions": {},
            "hideEffectSpeed": "medium",
            "showFirstOption": !0,
            "defaultText": "",
            "defaultIcon": "",
            "downArrowIcon": "",
            "theme": "default",
            "keydownOpen": !0,
            "isMobile": function() {
                var ua = navigator.userAgent || navigator.vendor || window.opera;
                return (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua)
            },
            "native": !1,
            "aggressiveChange": !1,
            "selectWhenHidden": !0,
            "viewport": $(window),
            "similarSearch": !1,
            "copyAttributes": ["title", "rel"],
            "dontCopyAttributes": ["data-reactid"],
            "copyClasses": "button",
            "nativeMousedown": !1,
            "customShowHideEvent": !1,
            "autoWidth": !0,
            "html": !0,
            "populate": "",
            "dynamicPositioning": !0,
            "hideCurrent": !1,
            "numSearchCharacters": "auto"
        },
        "getThemes": function() {
            var self = this
              , theme = $(self.element).attr("data-theme") || "c";
            return {
                "bootstrap": {
                    "focus": "active",
                    "hover": "",
                    "enabled": "enabled",
                    "disabled": "disabled",
                    "arrow": "caret",
                    "button": "btn",
                    "list": "dropdown-menu",
                    "container": "bootstrap",
                    "open": "open"
                },
                "jqueryui": {
                    "focus": "ui-state-focus",
                    "hover": "ui-state-hover",
                    "enabled": "ui-state-enabled",
                    "disabled": "ui-state-disabled",
                    "arrow": "ui-icon ui-icon-triangle-1-s",
                    "button": "ui-widget ui-state-default",
                    "list": "ui-widget ui-widget-content",
                    "container": "jqueryui",
                    "open": "selectboxit-open"
                },
                "jquerymobile": {
                    "focus": "ui-btn-down-" + theme,
                    "hover": "ui-btn-hover-" + theme,
                    "enabled": "ui-enabled",
                    "disabled": "ui-disabled",
                    "arrow": "ui-icon ui-icon-arrow-d ui-icon-shadow",
                    "button": "ui-btn ui-btn-icon-right ui-btn-corner-all ui-shadow ui-btn-up-" + theme,
                    "list": "ui-btn ui-btn-icon-right ui-btn-corner-all ui-shadow ui-btn-up-" + theme,
                    "container": "jquerymobile",
                    "open": "selectboxit-open"
                },
                "default": {
                    "focus": "selectboxit-focus",
                    "hover": "selectboxit-hover",
                    "enabled": "selectboxit-enabled",
                    "disabled": "selectboxit-disabled",
                    "arrow": "selectboxit-default-arrow",
                    "button": "selectboxit-btn",
                    "list": "selectboxit-list",
                    "container": "selectboxit-container",
                    "open": "selectboxit-open"
                }
            }
        },
        isDeferred: function(def) {
            return $.isPlainObject(def) && def.promise && def.done
        },
        _create: function(internal) {
            var self = this
              , populateOption = self.options.populate
              , userTheme = self.options.theme;
            if (!self.element.is("select")) {
                return
            }
            self.widgetProto = $.Widget.prototype;
            self.originalElem = self.element[0];
            self.selectBox = self.element;
            if (self.options.populate && self.add && !internal) {
                self.add(populateOption)
            }
            self.selectItems = self.element.find("option");
            self.firstSelectItem = self.selectItems.slice(0, 1);
            self.documentHeight = $(document).height();
            self.theme = $.isPlainObject(userTheme) ? $.extend({}, self.getThemes()["default"], userTheme) : self.getThemes()[userTheme] ? self.getThemes()[userTheme] : self.getThemes()["default"];
            self.currentFocus = 0;
            self.blur = !0;
            self.textArray = [];
            self.currentIndex = 0;
            self.currentText = "";
            self.flipped = !1;
            if (!internal) {
                self.selectBoxStyles = self.selectBox.attr("style")
            }
            self._createDropdownButton()._createUnorderedList()._copyAttributes()._replaceSelectBox()._addClasses(self.theme)._eventHandlers();
            if (self.originalElem.disabled && self.disable) {
                self.disable()
            }
            if (self._ariaAccessibility) {
                self._ariaAccessibility()
            }
            self.isMobile = self.options.isMobile();
            if (self._mobile) {
                self._mobile()
            }
            if (self.options["native"]) {
                this._applyNativeSelect()
            }
            self.triggerEvent("create");
            return self
        },
        _createDropdownButton: function() {
            var self = this
              , originalElemId = self.originalElemId = self.originalElem.id || ""
              , originalElemValue = self.originalElemValue = self.originalElem.value || ""
              , originalElemName = self.originalElemName = self.originalElem.name || ""
              , copyClasses = self.options.copyClasses
              , selectboxClasses = self.selectBox.attr("class") || "";
            self.dropdownText = $("<span/>", {
                "id": originalElemId && originalElemId + "SelectBoxItText",
                "class": "selectboxit-text",
                "unselectable": "on",
                "text": self.firstSelectItem.text()
            }).attr("data-val", self.htmlEscape(originalElemValue));
            self.dropdownImageContainer = $("<span/>", {
                "class": "selectboxit-option-icon-container"
            });
            self.dropdownImage = $("<i/>", {
                "id": originalElemId && originalElemId + "SelectBoxItDefaultIcon",
                "class": "selectboxit-default-icon",
                "unselectable": "on"
            });
            self.dropdown = $("<span/>", {
                "id": originalElemId && originalElemId + "SelectBoxIt",
                "class": "selectboxit " + (copyClasses === "button" ? selectboxClasses : "") + " " + (self.selectBox.prop("disabled") ? self.theme.disabled : self.theme.enabled),
                "name": originalElemName,
                "tabindex": self.selectBox.attr("tabindex") || "0",
                "unselectable": "on"
            }).append(self.dropdownImageContainer.append(self.dropdownImage)).append(self.dropdownText);
            self.dropdownContainer = $("<span/>", {
                "id": originalElemId && originalElemId + "SelectBoxItContainer",
                "class": 'selectboxit-container ' + self.theme.container + ' ' + (copyClasses === "container" ? selectboxClasses : "")
            }).append(self.dropdown);
            return self
        },
        _createUnorderedList: function() {
            var self = this, dataDisabled, optgroupClass, optgroupElement, iconClass, iconUrl, iconUrlClass, iconUrlStyle, currentItem = "", originalElemId = self.originalElemId || "", createdList = $("<ul/>", {
                "id": originalElemId && originalElemId + "SelectBoxItOptions",
                "class": "selectboxit-options",
                "tabindex": -1
            }), currentDataSelectedText, currentDataText, currentDataSearch, currentText, currentOption, parent;
            if (!self.options.showFirstOption) {
                self.selectItems.first().attr("disabled", "disabled");
                self.selectItems = self.selectBox.find("option").slice(1)
            }
            self.selectItems.each(function(index) {
                currentOption = $(this);
                optgroupClass = "";
                optgroupElement = "";
                dataDisabled = currentOption.prop("disabled");
                iconClass = currentOption.attr("data-icon") || "";
                iconUrl = currentOption.attr("data-iconurl") || "";
                iconUrlClass = iconUrl ? "selectboxit-option-icon-url" : "";
                iconUrlStyle = iconUrl ? 'style="background-image:url(\'' + iconUrl + '\');"' : "";
                currentDataSelectedText = currentOption.attr("data-selectedtext");
                currentDataText = currentOption.attr("data-text");
                currentText = currentDataText ? currentDataText : currentOption.text();
                parent = currentOption.parent();
                if (parent.is("optgroup")) {
                    optgroupClass = "selectboxit-optgroup-option";
                    if (currentOption.index() === 0) {
                        optgroupElement = '<span class="selectboxit-optgroup-header ' + parent.first().attr("class") + '"data-disabled="true">' + parent.first().attr("label") + '</span>'
                    }
                }
                currentOption.attr("value", this.value);
                currentItem += optgroupElement + '<li data-id="' + index + '" data-val="' + self.htmlEscape(this.value) + '" data-disabled="' + dataDisabled + '" class="' + optgroupClass + " selectboxit-option " + ($(this).attr("class") || "") + '"><a class="selectboxit-option-anchor"><span class="selectboxit-option-icon-container"><i class="selectboxit-option-icon ' + iconClass + ' ' + (iconUrlClass || self.theme.container) + '"' + iconUrlStyle + '></i></span>' + (self.options.html ? currentText : self.htmlEscape(currentText)) + '</a></li>';
                currentDataSearch = currentOption.attr("data-search");
                self.textArray[index] = dataDisabled ? "" : currentDataSearch ? currentDataSearch : currentText;
                if (this.selected) {
                    self._setText(self.dropdownText, currentDataSelectedText || currentText);
                    self.currentFocus = index
                }
            });
            if ((self.options.defaultText || self.selectBox.attr("data-text"))) {
                var defaultedText = self.options.defaultText || self.selectBox.attr("data-text");
                self._setText(self.dropdownText, defaultedText);
                self.options.defaultText = defaultedText
            }
            createdList.append(currentItem);
            self.list = createdList;
            self.dropdownContainer.append(self.list);
            self.listItems = self.list.children("li");
            self.listAnchors = self.list.find("a");
            self.listItems.first().addClass("selectboxit-option-first");
            self.listItems.last().addClass("selectboxit-option-last");
            self.list.find("li[data-disabled='true']").not(".optgroupHeader").addClass(self.theme.disabled);
            self.dropdownImage.addClass(self.selectBox.attr("data-icon") || self.options.defaultIcon || self.listItems.eq(self.currentFocus).find("i").attr("class"));
            self.dropdownImage.attr("style", self.listItems.eq(self.currentFocus).find("i").attr("style"));
            return self
        },
        _replaceSelectBox: function() {
            var self = this, height, originalElemId = self.originalElem.id || "", size = self.selectBox.attr("data-size"), listSize = self.listSize = size === undefined ? "auto" : size === "0" || "size" === "auto" ? "auto" : +size, downArrowContainerWidth, dropdownImageWidth;
            self.selectBox.css("display", "none").after(self.dropdownContainer);
            self.dropdownContainer.appendTo('body').addClass('selectboxit-rendering');
            height = self.dropdown.height();
            self.downArrow = $("<i/>", {
                "id": originalElemId && originalElemId + "SelectBoxItArrow",
                "class": "selectboxit-arrow",
                "unselectable": "on"
            });
            self.downArrowContainer = $("<span/>", {
                "id": originalElemId && originalElemId + "SelectBoxItArrowContainer",
                "class": "selectboxit-arrow-container",
                "unselectable": "on"
            }).append(self.downArrow);
            self.dropdown.append(self.downArrowContainer);
            self.listItems.removeClass("selectboxit-selected").eq(self.currentFocus).addClass("selectboxit-selected");
            downArrowContainerWidth = self.downArrowContainer.outerWidth(!0);
            dropdownImageWidth = self.dropdownImage.outerWidth(!0);
            if (self.options.autoWidth) {
                self.dropdown.css({
                    "width": "auto"
                }).css({
                    "width": self.list.outerWidth(!0) + downArrowContainerWidth + dropdownImageWidth
                });
                self.list.css({
                    "min-width": self.dropdown.width()
                })
            }
            self.selectBox.after(self.dropdownContainer);
            self.dropdownContainer.removeClass('selectboxit-rendering');
            self.dropdownText.css({});
            if ($.type(listSize) === "number") {
                self.maxHeight = self.listAnchors.outerHeight(!0) * listSize
            }
            return self
        },
        _scrollToView: function(type) {
            var self = this, currentOption = self.listItems.eq(self.currentFocus), listScrollTop = self.list.scrollTop(), currentItemHeight = currentOption.height(), currentTopPosition = currentOption.position().top, absCurrentTopPosition = Math.abs(currentTopPosition), listHeight = self.list.height(), currentText;
            if (type === "search") {
                if (listHeight - currentTopPosition < currentItemHeight) {
                    self.list.scrollTop(listScrollTop + (currentTopPosition - (listHeight - currentItemHeight)))
                } else if (currentTopPosition < -1) {
                    self.list.scrollTop(currentTopPosition - currentItemHeight)
                }
            } else if (type === "up") {
                if (currentTopPosition < -1) {
                    self.list.scrollTop(listScrollTop - absCurrentTopPosition)
                }
            } else if (type === "down") {
                if (listHeight - currentTopPosition < currentItemHeight) {
                    self.list.scrollTop((listScrollTop + (absCurrentTopPosition - listHeight + currentItemHeight)))
                }
            }
            return self
        },
        _callbackSupport: function(callback) {
            var self = this;
            if ($.isFunction(callback)) {
                callback.call(self, self.dropdown)
            }
            return self
        },
        _setText: function(elem, currentText) {
            var self = this;
            if (self.options.html) {
                elem.html(currentText)
            } else {
                elem.text(currentText)
            }
            return self
        },
        open: function(callback) {
            var self = this
              , showEffect = self.options.showEffect
              , showEffectSpeed = self.options.showEffectSpeed
              , showEffectOptions = self.options.showEffectOptions
              , isNative = self.options["native"]
              , isMobile = self.isMobile;
            if (!self.listItems.length || self.dropdown.hasClass(self.theme.disabled)) {
                return self
            }
            if ((!isNative && !isMobile) && !this.list.is(":visible")) {
                self.triggerEvent("open");
                if (self._dynamicPositioning && self.options.dynamicPositioning) {
                    self._dynamicPositioning()
                }
                if (showEffect === "none") {
                    self.list.show()
                } else if (showEffect === "show" || showEffect === "slideDown" || showEffect === "fadeIn") {
                    self.list[showEffect](showEffectSpeed)
                } else {
                    self.list.show(showEffect, showEffectOptions, showEffectSpeed)
                }
                self.list.promise().done(function() {
                    self._scrollToView("search");
                    self.triggerEvent("opened")
                })
            }
            self._callbackSupport(callback);
            return self
        },
        close: function(callback) {
            var self = this
              , hideEffect = self.options.hideEffect
              , hideEffectSpeed = self.options.hideEffectSpeed
              , hideEffectOptions = self.options.hideEffectOptions
              , isNative = self.options["native"]
              , isMobile = self.isMobile;
            if ((!isNative && !isMobile) && self.list.is(":visible")) {
                self.triggerEvent("close");
                if (hideEffect === "none") {
                    self.list.hide()
                } else if (hideEffect === "hide" || hideEffect === "slideUp" || hideEffect === "fadeOut") {
                    self.list[hideEffect](hideEffectSpeed)
                } else {
                    self.list.hide(hideEffect, hideEffectOptions, hideEffectSpeed)
                }
                self.list.promise().done(function() {
                    self.triggerEvent("closed")
                })
            }
            self._callbackSupport(callback);
            return self
        },
        toggle: function() {
            var self = this
              , listIsVisible = self.list.is(":visible");
            if (listIsVisible) {
                self.close()
            } else if (!listIsVisible) {
                self.open()
            }
        },
        _keyMappings: {
            "38": "up",
            "40": "down",
            "13": "enter",
            "8": "backspace",
            "9": "tab",
            "32": "space",
            "27": "esc"
        },
        _keydownMethods: function() {
            var self = this
              , moveToOption = self.list.is(":visible") || !self.options.keydownOpen;
            return {
                "down": function() {
                    if (self.moveDown && moveToOption) {
                        self.moveDown()
                    }
                },
                "up": function() {
                    if (self.moveUp && moveToOption) {
                        self.moveUp()
                    }
                },
                "enter": function() {
                    var activeElem = self.listItems.eq(self.currentFocus);
                    self._update(activeElem);
                    if (activeElem.attr("data-preventclose") !== "true") {
                        self.close()
                    }
                    self.triggerEvent("enter")
                },
                "tab": function() {
                    self.triggerEvent("tab-blur");
                    self.close()
                },
                "backspace": function() {
                    self.triggerEvent("backspace")
                },
                "esc": function() {
                    self.close()
                }
            }
        },
        _eventHandlers: function() {
            var self = this, nativeMousedown = self.options.nativeMousedown, customShowHideEvent = self.options.customShowHideEvent, currentDataText, currentText, focusClass = self.focusClass, hoverClass = self.hoverClass, openClass = self.openClass;
            this.dropdown.on({
                "click.selectBoxIt": function() {
                    self.dropdown.trigger("focus", !0);
                    if (!self.originalElem.disabled) {
                        self.triggerEvent("click");
                        if (!nativeMousedown && !customShowHideEvent) {
                            self.toggle()
                        }
                    }
                },
                "mousedown.selectBoxIt": function() {
                    $(this).data("mdown", !0);
                    self.triggerEvent("mousedown");
                    if (nativeMousedown && !customShowHideEvent) {
                        self.toggle()
                    }
                },
                "mouseup.selectBoxIt": function() {
                    self.triggerEvent("mouseup")
                },
                "blur.selectBoxIt": function() {
                    if (self.blur) {
                        self.triggerEvent("blur");
                        self.close();
                        $(this).removeClass(focusClass)
                    }
                },
                "focus.selectBoxIt": function(event, internal) {
                    var mdown = $(this).data("mdown");
                    $(this).removeData("mdown");
                    if (!mdown && !internal) {
                        setTimeout(function() {
                            self.triggerEvent("tab-focus")
                        }, 0)
                    }
                    if (!internal) {
                        if (!$(this).hasClass(self.theme.disabled)) {
                            $(this).addClass(focusClass)
                        }
                        self.triggerEvent("focus")
                    }
                },
                "keydown.selectBoxIt": function(e) {
                    var currentKey = self._keyMappings[e.keyCode]
                      , keydownMethod = self._keydownMethods()[currentKey];
                    if (keydownMethod) {
                        keydownMethod();
                        if (self.options.keydownOpen && (currentKey === "up" || currentKey === "down")) {
                            self.open()
                        }
                    }
                    if (keydownMethod && currentKey !== "tab") {
                        e.preventDefault()
                    }
                },
                "keypress.selectBoxIt": function(e) {
                    if (!self.originalElem.disabled) {
                        var currentKey = e.charCode || e.keyCode
                          , key = self._keyMappings[e.charCode || e.keyCode]
                          , alphaNumericKey = String.fromCharCode(currentKey);
                        if (self.search && (!key || (key && key === "space"))) {
                            self.search(alphaNumericKey, !0, !0)
                        }
                        if (key === "space") {
                            e.preventDefault()
                        }
                    }
                },
                "mouseenter.selectBoxIt": function() {
                    self.triggerEvent("mouseenter")
                },
                "mouseleave.selectBoxIt": function() {
                    self.triggerEvent("mouseleave")
                }
            });
            self.list.on({
                "mouseover.selectBoxIt": function() {
                    self.blur = !1
                },
                "mouseout.selectBoxIt": function() {
                    self.blur = !0
                },
                "focusin.selectBoxIt": function() {
                    self.dropdown.trigger("focus", !0)
                }
            });
            self.list.on({
                "mousedown.selectBoxIt": function() {
                    self._update($(this));
                    self.triggerEvent("option-click");
                    if ($(this).attr("data-disabled") === "false" && $(this).attr("data-preventclose") !== "true") {
                        self.close()
                    }
                    setTimeout(function() {
                        self.dropdown.trigger('focus', !0)
                    }, 0)
                },
                "focusin.selectBoxIt": function() {
                    self.listItems.not($(this)).removeAttr("data-active");
                    $(this).attr("data-active", "");
                    var listIsHidden = self.list.is(":hidden");
                    if ((self.options.searchWhenHidden && listIsHidden) || self.options.aggressiveChange || (listIsHidden && self.options.selectWhenHidden)) {
                        self._update($(this))
                    }
                    $(this).addClass(focusClass)
                },
                "mouseup.selectBoxIt": function() {
                    if (nativeMousedown && !customShowHideEvent) {
                        self._update($(this));
                        self.triggerEvent("option-mouseup");
                        if ($(this).attr("data-disabled") === "false" && $(this).attr("data-preventclose") !== "true") {
                            self.close()
                        }
                    }
                },
                "mouseenter.selectBoxIt": function() {
                    if ($(this).attr("data-disabled") === "false") {
                        self.listItems.removeAttr("data-active");
                        $(this).addClass(focusClass).attr("data-active", "");
                        self.listItems.not($(this)).removeClass(focusClass);
                        $(this).addClass(focusClass);
                        self.currentFocus = +$(this).attr("data-id")
                    }
                },
                "mouseleave.selectBoxIt": function() {
                    if ($(this).attr("data-disabled") === "false") {
                        self.listItems.not($(this)).removeClass(focusClass).removeAttr("data-active");
                        $(this).addClass(focusClass);
                        self.currentFocus = +$(this).attr("data-id")
                    }
                },
                "blur.selectBoxIt": function() {
                    $(this).removeClass(focusClass)
                }
            }, ".selectboxit-option");
            self.list.on({
                "click.selectBoxIt": function(ev) {
                    ev.preventDefault()
                }
            }, "a");
            self.selectBox.on({
                "change.selectBoxIt, internal-change.selectBoxIt": function(event, internal) {
                    var currentOption, currentDataSelectedText;
                    if (!internal) {
                        currentOption = self.list.find('li[data-val="' + self.originalElem.value + '"]');
                        if (currentOption.length) {
                            self.listItems.eq(self.currentFocus).removeClass(self.focusClass);
                            self.currentFocus = +currentOption.attr("data-id")
                        }
                    }
                    currentOption = self.listItems.eq(self.currentFocus);
                    currentDataSelectedText = currentOption.attr("data-selectedtext");
                    currentDataText = currentOption.attr("data-text");
                    currentText = currentDataText ? currentDataText : currentOption.find("a").text();
                    self._setText(self.dropdownText, currentDataSelectedText || currentText);
                    self.dropdownText.attr("data-val", self.originalElem.value);
                    if (currentOption.find("i").attr("class")) {
                        self.dropdownImage.attr("class", currentOption.find("i").attr("class")).addClass("selectboxit-default-icon");
                        self.dropdownImage.attr("style", currentOption.find("i").attr("style"))
                    }
                    self.triggerEvent("changed")
                },
                "disable.selectBoxIt": function() {
                    self.dropdown.addClass(self.theme.disabled)
                },
                "enable.selectBoxIt": function() {
                    self.dropdown.removeClass(self.theme.disabled)
                },
                "open.selectBoxIt": function() {
                    var currentElem = self.list.find("li[data-val='" + self.dropdownText.attr("data-val") + "']"), activeElem;
                    if (!currentElem.length) {
                        currentElem = self.listItems.not("[data-disabled=true]").first()
                    }
                    self.currentFocus = +currentElem.attr("data-id");
                    activeElem = self.listItems.eq(self.currentFocus);
                    self.dropdown.addClass(openClass).removeClass(hoverClass).addClass(focusClass);
                    self.listItems.removeClass(self.selectedClass).removeAttr("data-active").not(activeElem).removeClass(focusClass);
                    activeElem.addClass(self.selectedClass).addClass(focusClass);
                    if (self.options.hideCurrent) {
                        activeElem.hide().promise().done(function() {
                            self.listItems.show()
                        })
                    }
                },
                "close.selectBoxIt": function() {
                    self.dropdown.removeClass(openClass)
                },
                "blur.selectBoxIt": function() {
                    self.dropdown.removeClass(focusClass)
                },
                "mouseenter.selectBoxIt": function() {
                    if (!$(this).hasClass(self.theme.disabled)) {
                        self.dropdown.addClass(hoverClass)
                    }
                },
                "mouseleave.selectBoxIt": function() {
                    self.dropdown.removeClass(hoverClass)
                },
                "destroy": function(ev) {
                    ev.preventDefault();
                    ev.stopPropagation()
                }
            });
            return self
        },
        _update: function(elem) {
            var self = this, currentDataSelectedText, currentDataText, currentText, defaultText = self.options.defaultText || self.selectBox.attr("data-text"), currentElem = self.listItems.eq(self.currentFocus);
            if (elem.attr("data-disabled") === "false") {
                currentDataSelectedText = self.listItems.eq(self.currentFocus).attr("data-selectedtext");
                currentDataText = currentElem.attr("data-text");
                currentText = currentDataText ? currentDataText : currentElem.text();
                if ((defaultText && self.options.html ? self.dropdownText.html() === defaultText : self.dropdownText.text() === defaultText) && self.selectBox.val() === elem.attr("data-val")) {
                    self.triggerEvent("change")
                } else {
                    self.selectBox.val(elem.attr("data-val"));
                    self.currentFocus = +elem.attr("data-id");
                    if (self.originalElem.value !== self.dropdownText.attr("data-val")) {
                        self.triggerEvent("change")
                    }
                }
            }
        },
        _addClasses: function(obj) {
            var self = this
              , focusClass = self.focusClass = obj.focus
              , hoverClass = self.hoverClass = obj.hover
              , buttonClass = obj.button
              , listClass = obj.list
              , arrowClass = obj.arrow
              , containerClass = obj.container
              , openClass = self.openClass = obj.open;
            self.selectedClass = "selectboxit-selected";
            self.downArrow.addClass(self.selectBox.attr("data-downarrow") || self.options.downArrowIcon || arrowClass);
            self.dropdownContainer.addClass(containerClass);
            self.dropdown.addClass(buttonClass);
            self.list.addClass(listClass);
            return self
        },
        refresh: function(callback, internal) {
            var self = this;
            self._destroySelectBoxIt()._create(!0);
            if (!internal) {
                self.triggerEvent("refresh")
            }
            self._callbackSupport(callback);
            return self
        },
        htmlEscape: function(str) {
            return String(str).replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/'/g, "&#39;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
        },
        triggerEvent: function(eventName) {
            var self = this
              , currentIndex = self.options.showFirstOption ? self.currentFocus : ((self.currentFocus - 1) >= 0 ? self.currentFocus : 0);
            self.selectBox.triggerHandler(eventName, {
                "selectbox": self.selectBox,
                "selectboxOption": self.selectItems.eq(currentIndex),
                "dropdown": self.dropdown,
                "dropdownOption": self.listItems.eq(self.currentFocus)
            });
            return self
        },
        _copyAttributes: function() {
            var self = this;
            if (self._addSelectBoxAttributes) {
                self._addSelectBoxAttributes()
            }
            return self
        },
        _realOuterWidth: function(elem) {
            if (elem.is(":visible")) {
                return elem.outerWidth(!0)
            }
            var self = this, clonedElem = elem.clone(), outerWidth;
            clonedElem.css({
                "visibility": "hidden",
                "display": "block",
                "position": "absolute"
            }).appendTo("body");
            outerWidth = clonedElem.outerWidth(!0);
            clonedElem.remove();
            return outerWidth
        }
    });
    var selectBoxIt = $.selectBox.selectBoxIt.prototype;
    selectBoxIt._ariaAccessibility = function() {
        var self = this
          , dropdownLabel = $("label[for='" + self.originalElem.id + "']");
        self.dropdownContainer.attr({
            "role": "combobox",
            "aria-haspopup": "true",
            "aria-expanded": "false",
            "aria-owns": self.list[0].id
        });
        self.dropdownText.attr({
            "aria-live": "polite"
        });
        self.dropdown.on({
            "disable.selectBoxIt": function() {
                self.dropdownContainer.attr("aria-disabled", "true")
            },
            "enable.selectBoxIt": function() {
                self.dropdownContainer.attr("aria-disabled", "false")
            }
        });
        if (dropdownLabel.length) {
            self.dropdownContainer.attr("aria-labelledby", dropdownLabel[0].id)
        }
        self.list.attr({
            "role": "listbox",
            "aria-hidden": "true"
        });
        self.listItems.attr({
            "role": "option"
        });
        self.selectBox.on({
            "open.selectBoxIt": function() {
                self.list.attr("aria-hidden", "false");
                self.dropdownContainer.attr("aria-expanded", "true")
            },
            "close.selectBoxIt": function() {
                self.list.attr("aria-hidden", "true");
                self.dropdownContainer.attr("aria-expanded", "false")
            }
        });
        return self
    }
    ;
    selectBoxIt._addSelectBoxAttributes = function() {
        var self = this;
        self._addAttributes(self.selectBox.prop("attributes"), self.dropdown);
        self.selectItems.each(function(iterator) {
            self._addAttributes($(this).prop("attributes"), self.listItems.eq(iterator))
        });
        return self
    }
    ;
    selectBoxIt._addAttributes = function(arr, elem) {
        var self = this
          , whitelist = self.options.copyAttributes
          , blacklist = self.options.dontCopyAttributes;
        if (arr.length) {
            $.each(arr, function(iterator, property) {
                var propName = (property.name).toLowerCase()
                  , propValue = property.value;
                if ($.inArray(propName, blacklist) !== -1) {
                    return
                }
                if (propValue !== "null" && ($.inArray(propName, whitelist) !== -1 || propName.indexOf("data") !== -1)) {
                    elem.attr(propName, propValue)
                }
            })
        }
        return self
    }
    ;
    selectBoxIt.destroy = function(callback) {
        var self = this;
        self._destroySelectBoxIt();
        self.widgetProto.destroy.call(self);
        self._callbackSupport(callback);
        return self
    }
    ;
    selectBoxIt._destroySelectBoxIt = function() {
        var self = this;
        self.dropdown.off(".selectBoxIt");
        if ($.contains(self.dropdownContainer[0], self.originalElem)) {
            self.dropdownContainer.before(self.selectBox)
        }
        self.dropdownContainer.remove();
        self.selectBox.removeAttr("style").attr("style", self.selectBoxStyles);
        self.triggerEvent("destroy");
        return self
    }
    ;
    selectBoxIt.disable = function(callback) {
        var self = this;
        if (!self.options.disabled) {
            self.close();
            self.selectBox.attr("disabled", "disabled");
            self.dropdown.removeAttr("tabindex").removeClass(self.theme.enabled).addClass(self.theme.disabled);
            self._setOption("disabled", !0);
            self.triggerEvent("disable")
        }
        self._callbackSupport(callback);
        return self
    }
    ;
    selectBoxIt.disableOption = function(index, callback) {
        var self = this, currentSelectBoxOption, hasNextEnabled, hasPreviousEnabled, type = $.type(index);
        if (type === "number") {
            self.close();
            currentSelectBoxOption = self.selectBox.find("option").eq(index);
            self.triggerEvent("disable-option");
            currentSelectBoxOption.attr("disabled", "disabled");
            self.listItems.eq(index).attr("data-disabled", "true").addClass(self.theme.disabled);
            if (self.currentFocus === index) {
                hasNextEnabled = self.listItems.eq(self.currentFocus).nextAll("li").not("[data-disabled='true']").first().length;
                hasPreviousEnabled = self.listItems.eq(self.currentFocus).prevAll("li").not("[data-disabled='true']").first().length;
                if (hasNextEnabled) {
                    self.moveDown()
                } else if (hasPreviousEnabled) {
                    self.moveUp()
                } else {
                    self.disable()
                }
            }
        }
        self._callbackSupport(callback);
        return self
    }
    ;
    selectBoxIt._isDisabled = function(callback) {
        var self = this;
        if (self.originalElem.disabled) {
            self.disable()
        }
        return self
    }
    ;
    selectBoxIt._dynamicPositioning = function() {
        var self = this;
        var openUpClassName = 'selectboxit-open-up';
        var openDownClassName = 'selectboxit-open-down';
        if ($.type(self.listSize) === "number") {
            self.list.css("max-height", self.maxHeight || "none")
        } else {
            var listOffsetTop = self.dropdown.offset().top
              , listHeight = self.list.data("max-height") || self.list.outerHeight()
              , selectBoxHeight = self.dropdown.outerHeight()
              , viewport = self.options.viewport
              , viewportHeight = viewport.height()
              , viewportScrollTop = $.isWindow(viewport.get(0)) ? viewport.scrollTop() : viewport.offset().top
              , topToBottom = (listOffsetTop + selectBoxHeight + listHeight <= viewportHeight + viewportScrollTop)
              , bottomReached = !topToBottom;
            if (!self.list.data("max-height")) {
                self.list.data("max-height", self.list.outerHeight())
            }
            if (!bottomReached) {
                self.list.css("max-height", listHeight);
                self.list.css("top", "auto");
                self.dropdown.addClass(openDownClassName)
            } else if ((self.dropdown.offset().top - viewportScrollTop) >= listHeight) {
                self.list.css("max-height", listHeight);
                self.list.css("top", (self.dropdown.position().top - self.list.outerHeight()));
                self.dropdown.addClass(openUpClassName)
            } else {
                var outsideBottomViewport = Math.abs((listOffsetTop + selectBoxHeight + listHeight) - (viewportHeight + viewportScrollTop))
                  , outsideTopViewport = Math.abs((self.dropdown.offset().top - viewportScrollTop) - listHeight);
                if (outsideBottomViewport < outsideTopViewport) {
                    self.list.css("max-height", listHeight - outsideBottomViewport - (selectBoxHeight / 2));
                    self.list.css("top", "auto");
                    self.dropdown.addClass(openDownClassName)
                } else {
                    self.list.css("max-height", listHeight - outsideTopViewport - (selectBoxHeight / 2));
                    self.list.css("top", (self.dropdown.position().top - self.list.outerHeight()));
                    self.dropdown.addClass(openUpClassName)
                }
            }
        }
        return self
    }
    ;
    selectBoxIt.enable = function(callback) {
        var self = this;
        if (self.options.disabled) {
            self.triggerEvent("enable");
            self.selectBox.removeAttr("disabled");
            self.dropdown.attr("tabindex", 0).removeClass(self.theme.disabled).addClass(self.theme.enabled);
            self._setOption("disabled", !1);
            self._callbackSupport(callback)
        }
        return self
    }
    ;
    selectBoxIt.enableOption = function(index, callback) {
        var self = this, currentSelectBoxOption, currentIndex = 0, hasNextEnabled, hasPreviousEnabled, type = $.type(index);
        if (type === "number") {
            currentSelectBoxOption = self.selectBox.find("option").eq(index);
            self.triggerEvent("enable-option");
            currentSelectBoxOption.removeAttr("disabled");
            self.listItems.eq(index).attr("data-disabled", "false").removeClass(self.theme.disabled)
        }
        self._callbackSupport(callback);
        return self
    }
    ;
    selectBoxIt.moveDown = function(callback) {
        var self = this;
        self.currentFocus += 1;
        var disabled = self.listItems.eq(self.currentFocus).attr("data-disabled") === "true" ? true : !1
          , hasNextEnabled = self.listItems.eq(self.currentFocus).nextAll("li").not("[data-disabled='true']").first().length;
        if (self.currentFocus === self.listItems.length) {
            self.currentFocus -= 1
        } else if (disabled && hasNextEnabled) {
            self.listItems.eq(self.currentFocus - 1).blur();
            self.moveDown();
            return
        } else if (disabled && !hasNextEnabled) {
            self.currentFocus -= 1
        } else {
            self.listItems.eq(self.currentFocus - 1).blur().end().eq(self.currentFocus).focusin();
            self._scrollToView("down");
            self.triggerEvent("moveDown")
        }
        self._callbackSupport(callback);
        return self
    }
    ;
    selectBoxIt.moveUp = function(callback) {
        var self = this;
        self.currentFocus -= 1;
        var disabled = self.listItems.eq(self.currentFocus).attr("data-disabled") === "true" ? true : !1
          , hasPreviousEnabled = self.listItems.eq(self.currentFocus).prevAll("li").not("[data-disabled='true']").first().length;
        if (self.currentFocus === -1) {
            self.currentFocus += 1
        } else if (disabled && hasPreviousEnabled) {
            self.listItems.eq(self.currentFocus + 1).blur();
            self.moveUp();
            return
        } else if (disabled && !hasPreviousEnabled) {
            self.currentFocus += 1
        } else {
            self.listItems.eq(this.currentFocus + 1).blur().end().eq(self.currentFocus).focusin();
            self._scrollToView("up");
            self.triggerEvent("moveUp")
        }
        self._callbackSupport(callback);
        return self
    }
    ;
    selectBoxIt._setCurrentSearchOption = function(currentOption) {
        var self = this;
        if ((self.options.aggressiveChange || self.options.selectWhenHidden || self.listItems.eq(currentOption).is(":visible")) && self.listItems.eq(currentOption).data("disabled") !== !0) {
            self.listItems.eq(self.currentFocus).blur();
            self.currentIndex = currentOption;
            self.currentFocus = currentOption;
            self.listItems.eq(self.currentFocus).focusin();
            self._scrollToView("search");
            self.triggerEvent("search")
        }
        return self
    }
    ;
    selectBoxIt._searchAlgorithm = function(currentIndex, alphaNumeric) {
        var self = this, options = self.options, matchExists = !1, x, y, arrayLength, currentSearch, textArray = self.textArray, currentText = self.currentText, numSearchCharacters = $.type(options.numSearchCharacters) === 'number' ? options.numSearchCharacters : 3;
        for (x = currentIndex,
        arrayLength = textArray.length; x < arrayLength; x += 1) {
            currentSearch = textArray[x];
            for (y = 0; y < arrayLength; y += 1) {
                if (textArray[y].search(alphaNumeric) !== -1) {
                    matchExists = !0;
                    y = arrayLength
                }
            }
            if (!matchExists) {
                self.currentText = self.currentText.charAt(self.currentText.length - 1).replace(/[|()\[{.+*?$\\]/g, "\\$0");
                currentText = self.currentText
            }
            alphaNumeric = new RegExp(currentText,"gi");
            if (currentText.length < numSearchCharacters) {
                alphaNumeric = new RegExp(currentText.charAt(0),"gi");
                if ((currentSearch.charAt(0).search(alphaNumeric) !== -1)) {
                    self._setCurrentSearchOption(x);
                    if ((currentSearch.substring(0, currentText.length).toLowerCase() !== currentText.toLowerCase()) || self.options.similarSearch) {
                        self.currentIndex += 1
                    }
                    return !1
                }
            } else {
                if ((currentSearch.search(alphaNumeric) !== -1)) {
                    self._setCurrentSearchOption(x);
                    return !1
                }
            }
            if (currentSearch.toLowerCase() === self.currentText.toLowerCase()) {
                self._setCurrentSearchOption(x);
                self.currentText = "";
                return !1
            }
        }
        return !0
    }
    ;
    selectBoxIt.search = function(alphaNumericKey, callback, rememberPreviousSearch) {
        var self = this;
        if (rememberPreviousSearch) {
            self.currentText += alphaNumericKey.replace(/[|()\[{.+*?$\\]/g, "\\$0")
        } else {
            self.currentText = alphaNumericKey.replace(/[|()\[{.+*?$\\]/g, "\\$0")
        }
        var searchResults = self._searchAlgorithm(self.currentIndex, new RegExp(self.currentText,"gi"));
        if (searchResults) {
            self._searchAlgorithm(0, self.currentText)
        }
        self._callbackSupport(callback);
        return self
    }
    ;
    selectBoxIt._updateMobileText = function() {
        var self = this, currentOption, currentDataText, currentText;
        currentOption = self.selectBox.find("option").filter(":selected");
        currentDataText = currentOption.attr("data-text");
        currentText = currentDataText ? currentDataText : currentOption.text();
        self._setText(self.dropdownText, currentText);
        if (self.list.find('li[data-val="' + currentOption.val() + '"]').find("i").attr("class")) {
            self.dropdownImage.attr("class", self.list.find('li[data-val="' + currentOption.val() + '"]').find("i").attr("class")).addClass("selectboxit-default-icon")
        }
    }
    ;
    selectBoxIt._applyNativeSelect = function() {
        var self = this;
        self.dropdownContainer.append(self.selectBox);
        self.dropdown.attr("tabindex", "-1");
        self.selectBox.css({
            "display": "block",
            "visibility": "visible",
            "width": self._realOuterWidth(self.dropdown),
            "height": self.dropdown.outerHeight(),
            "opacity": "0",
            "position": "absolute",
            "top": "0",
            "left": "0",
            "cursor": "pointer",
            "z-index": "999999",
            "margin": self.dropdown.css("margin"),
            "padding": "0",
            "-webkit-appearance": "menulist-button"
        });
        if (self.originalElem.disabled) {
            self.triggerEvent("disable")
        }
        return this
    }
    ;
    selectBoxIt._mobileEvents = function() {
        var self = this;
        self.selectBox.on({
            "changed.selectBoxIt": function() {
                self.hasChanged = !0;
                self._updateMobileText();
                self.triggerEvent("option-click")
            },
            "mousedown.selectBoxIt": function() {
                if (!self.hasChanged && self.options.defaultText && !self.originalElem.disabled) {
                    self._updateMobileText();
                    self.triggerEvent("option-click")
                }
            },
            "enable.selectBoxIt": function() {
                self.selectBox.removeClass('selectboxit-rendering')
            },
            "disable.selectBoxIt": function() {
                self.selectBox.addClass('selectboxit-rendering')
            },
            "destroy.selectBoxIt": function() {
                self.selectBox.removeClass('selectboxit-rendering')
            }
        })
    }
    ;
    selectBoxIt._mobile = function(callback) {
        var self = this;
        if (self.isMobile) {
            self._applyNativeSelect();
            self._mobileEvents()
        }
        return this
    }
    ;
    selectBoxIt.selectOption = function(val, callback) {
        var self = this
          , type = $.type(val);
        if (type === "number") {
            self.selectBox.val(self.selectItems.eq(val).val()).change()
        } else if (type === "string") {
            self.selectBox.val(val).change()
        }
        self._callbackSupport(callback);
        return self
    }
    ;
    selectBoxIt.setOption = function(key, value, callback) {
        var self = this;
        if ($.type(key) === "string") {
            self.options[key] = value
        }
        self.refresh(function() {
            self._callbackSupport(callback)
        }, !0);
        return self
    }
    ;
    selectBoxIt.setOptions = function(newOptions, callback) {
        var self = this;
        if ($.isPlainObject(newOptions)) {
            self.options = $.extend({}, self.options, newOptions)
        }
        self.refresh(function() {
            self._callbackSupport(callback)
        }, !0);
        return self
    }
    ;
    selectBoxIt.wait = function(time, callback) {
        var self = this;
        self.widgetProto._delay.call(self, callback, time);
        return self
    }
    ;
    selectBoxIt.add = function(data, callback) {
        this._populate(data, function(data) {
            var self = this, dataType = $.type(data), value, x = 0, dataLength, elems = [], isJSON = self._isJSON(data), parsedJSON = isJSON && self._parseJSON(data);
            if (data && (dataType === "array" || (isJSON && parsedJSON.data && $.type(parsedJSON.data) === "array")) || (dataType === "object" && data.data && $.type(data.data) === "array")) {
                if (self._isJSON(data)) {
                    data = parsedJSON
                }
                if (data.data) {
                    data = data.data
                }
                for (dataLength = data.length; x <= dataLength - 1; x += 1) {
                    value = data[x];
                    if ($.isPlainObject(value)) {
                        elems.push($("<option/>", value))
                    } else if ($.type(value) === "string") {
                        elems.push($("<option/>", {
                            text: value,
                            value: value
                        }))
                    }
                }
                self.selectBox.append(elems)
            } else if (data && dataType === "string" && !self._isJSON(data)) {
                self.selectBox.append(data)
            } else if (data && dataType === "object") {
                self.selectBox.append($("<option/>", data))
            } else if (data && self._isJSON(data) && $.isPlainObject(self._parseJSON(data))) {
                self.selectBox.append($("<option/>", self._parseJSON(data)))
            }
            if (self.dropdown) {
                self.refresh(function() {
                    self._callbackSupport(callback)
                }, !0)
            } else {
                self._callbackSupport(callback)
            }
            return self
        })
    }
    ;
    selectBoxIt._parseJSON = function(data) {
        return (JSON && JSON.parse && JSON.parse(data)) || $.parseJSON(data)
    }
    ;
    selectBoxIt._isJSON = function(data) {
        var self = this, json;
        try {
            json = self._parseJSON(data);
            return !0
        } catch (e) {
            return !1
        }
    }
    ;
    selectBoxIt._populate = function(data, callback) {
        var self = this;
        data = $.isFunction(data) ? data.call() : data;
        if (self.isDeferred(data)) {
            data.done(function(returnedData) {
                callback.call(self, returnedData)
            })
        } else {
            callback.call(self, data)
        }
        return self
    }
    ;
    selectBoxIt.remove = function(indexes, callback) {
        var self = this, dataType = $.type(indexes), value, x = 0, dataLength, elems = "";
        if (dataType === "array") {
            for (dataLength = indexes.length; x <= dataLength - 1; x += 1) {
                value = indexes[x];
                if ($.type(value) === "number") {
                    if (elems.length) {
                        elems += ", option:eq(" + value + ")"
                    } else {
                        elems += "option:eq(" + value + ")"
                    }
                }
            }
            self.selectBox.find(elems).remove()
        } else if (dataType === "number") {
            self.selectBox.find("option").eq(indexes).remove()
        } else {
            self.selectBox.find("option").remove()
        }
        if (self.dropdown) {
            self.refresh(function() {
                self._callbackSupport(callback)
            }, !0)
        } else {
            self._callbackSupport(callback)
        }
        return self
    }
}));
/* /themes/horoshop_default/layout/js/vendor/imagesloaded.pkgd.js */
/*!
 * imagesLoaded PACKAGED v4.1.4
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
(function(global, factory) {
    if (typeof define == 'function' && define.amd) {
        define('ev-emitter/ev-emitter', factory)
    } else if (typeof module == 'object' && module.exports) {
        module.exports = factory()
    } else {
        global.EvEmitter = factory()
    }
}(typeof window != 'undefined' ? window : this, function() {
    function EvEmitter() {}
    var proto = EvEmitter.prototype;
    proto.on = function(eventName, listener) {
        if (!eventName || !listener) {
            return
        }
        var events = this._events = this._events || {};
        var listeners = events[eventName] = events[eventName] || [];
        if (listeners.indexOf(listener) == -1) {
            listeners.push(listener)
        }
        return this
    }
    ;
    proto.once = function(eventName, listener) {
        if (!eventName || !listener) {
            return
        }
        this.on(eventName, listener);
        var onceEvents = this._onceEvents = this._onceEvents || {};
        var onceListeners = onceEvents[eventName] = onceEvents[eventName] || {};
        onceListeners[listener] = !0;
        return this
    }
    ;
    proto.off = function(eventName, listener) {
        var listeners = this._events && this._events[eventName];
        if (!listeners || !listeners.length) {
            return
        }
        var index = listeners.indexOf(listener);
        if (index != -1) {
            listeners.splice(index, 1)
        }
        return this
    }
    ;
    proto.emitEvent = function(eventName, args) {
        var listeners = this._events && this._events[eventName];
        if (!listeners || !listeners.length) {
            return
        }
        listeners = listeners.slice(0);
        args = args || [];
        var onceListeners = this._onceEvents && this._onceEvents[eventName];
        for (var i = 0; i < listeners.length; i++) {
            var listener = listeners[i]
            var isOnce = onceListeners && onceListeners[listener];
            if (isOnce) {
                this.off(eventName, listener);
                delete onceListeners[listener]
            }
            listener.apply(this, args)
        }
        return this
    }
    ;
    proto.allOff = function() {
        delete this._events;
        delete this._onceEvents
    }
    ;
    return EvEmitter
}));
/*!
 * imagesLoaded v4.1.4
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
(function(window, factory) {
    'use strict';
    if (typeof define == 'function' && define.amd) {
        define(['ev-emitter/ev-emitter'], function(EvEmitter) {
            return factory(window, EvEmitter)
        })
    } else if (typeof module == 'object' && module.exports) {
        module.exports = factory(window, require('ev-emitter'))
    } else {
        window.imagesLoaded = factory(window, window.EvEmitter)
    }
}
)(typeof window !== 'undefined' ? window : this, function factory(window, EvEmitter) {
    var $ = window.jQuery;
    var console = window.console;
    function extend(a, b) {
        for (var prop in b) {
            a[prop] = b[prop]
        }
        return a
    }
    var arraySlice = Array.prototype.slice;
    function makeArray(obj) {
        if (Array.isArray(obj)) {
            return obj
        }
        var isArrayLike = typeof obj == 'object' && typeof obj.length == 'number';
        if (isArrayLike) {
            return arraySlice.call(obj)
        }
        return [obj]
    }
    function ImagesLoaded(elem, options, onAlways) {
        if (!(this instanceof ImagesLoaded)) {
            return new ImagesLoaded(elem,options,onAlways)
        }
        var queryElem = elem;
        if (typeof elem == 'string') {
            queryElem = document.querySelectorAll(elem)
        }
        if (!queryElem) {
            console.error('Bad element for imagesLoaded ' + (queryElem || elem));
            return
        }
        this.elements = makeArray(queryElem);
        this.options = extend({}, this.options);
        if (typeof options == 'function') {
            onAlways = options
        } else {
            extend(this.options, options)
        }
        if (onAlways) {
            this.on('always', onAlways)
        }
        this.getImages();
        if ($) {
            this.jqDeferred = new $.Deferred()
        }
        setTimeout(this.check.bind(this))
    }
    ImagesLoaded.prototype = Object.create(EvEmitter.prototype);
    ImagesLoaded.prototype.options = {};
    ImagesLoaded.prototype.getImages = function() {
        this.images = [];
        this.elements.forEach(this.addElementImages, this)
    }
    ;
    ImagesLoaded.prototype.addElementImages = function(elem) {
        if (elem.nodeName == 'IMG') {
            this.addImage(elem)
        }
        if (this.options.background === !0) {
            this.addElementBackgroundImages(elem)
        }
        var nodeType = elem.nodeType;
        if (!nodeType || !elementNodeTypes[nodeType]) {
            return
        }
        var childImgs = elem.querySelectorAll('img');
        for (var i = 0; i < childImgs.length; i++) {
            var img = childImgs[i];
            this.addImage(img)
        }
        if (typeof this.options.background == 'string') {
            var children = elem.querySelectorAll(this.options.background);
            for (i = 0; i < children.length; i++) {
                var child = children[i];
                this.addElementBackgroundImages(child)
            }
        }
    }
    ;
    var elementNodeTypes = {
        1: !0,
        9: !0,
        11: !0
    };
    ImagesLoaded.prototype.addElementBackgroundImages = function(elem) {
        var style = getComputedStyle(elem);
        if (!style) {
            return
        }
        var reURL = /url\((['"])?(.*?)\1\)/gi;
        var matches = reURL.exec(style.backgroundImage);
        while (matches !== null) {
            var url = matches && matches[2];
            if (url) {
                this.addBackground(url, elem)
            }
            matches = reURL.exec(style.backgroundImage)
        }
    }
    ;
    ImagesLoaded.prototype.addImage = function(img) {
        var loadingImage = new LoadingImage(img);
        this.images.push(loadingImage)
    }
    ;
    ImagesLoaded.prototype.addBackground = function(url, elem) {
        var background = new Background(url,elem);
        this.images.push(background)
    }
    ;
    ImagesLoaded.prototype.check = function() {
        var _this = this;
        this.progressedCount = 0;
        this.hasAnyBroken = !1;
        if (!this.images.length) {
            this.complete();
            return
        }
        function onProgress(image, elem, message) {
            setTimeout(function() {
                _this.progress(image, elem, message)
            })
        }
        this.images.forEach(function(loadingImage) {
            loadingImage.once('progress', onProgress);
            loadingImage.check()
        })
    }
    ;
    ImagesLoaded.prototype.progress = function(image, elem, message) {
        this.progressedCount++;
        this.hasAnyBroken = this.hasAnyBroken || !image.isLoaded;
        this.emitEvent('progress', [this, image, elem]);
        if (this.jqDeferred && this.jqDeferred.notify) {
            this.jqDeferred.notify(this, image)
        }
        if (this.progressedCount == this.images.length) {
            this.complete()
        }
        if (this.options.debug && console) {
            console.log('progress: ' + message, image, elem)
        }
    }
    ;
    ImagesLoaded.prototype.complete = function() {
        var eventName = this.hasAnyBroken ? 'fail' : 'done';
        this.isComplete = !0;
        this.emitEvent(eventName, [this]);
        this.emitEvent('always', [this]);
        if (this.jqDeferred) {
            var jqMethod = this.hasAnyBroken ? 'reject' : 'resolve';
            this.jqDeferred[jqMethod](this)
        }
    }
    ;
    function LoadingImage(img) {
        this.img = img
    }
    LoadingImage.prototype = Object.create(EvEmitter.prototype);
    LoadingImage.prototype.check = function() {
        var isComplete = this.getIsImageComplete();
        if (isComplete) {
            this.confirm(this.img.naturalWidth !== 0, 'naturalWidth');
            return
        }
        this.proxyImage = new Image();
        this.proxyImage.addEventListener('load', this);
        this.proxyImage.addEventListener('error', this);
        this.img.addEventListener('load', this);
        this.img.addEventListener('error', this);
        this.proxyImage.src = this.img.src
    }
    ;
    LoadingImage.prototype.getIsImageComplete = function() {
        return this.img.complete && this.img.naturalWidth
    }
    ;
    LoadingImage.prototype.confirm = function(isLoaded, message) {
        this.isLoaded = isLoaded;
        this.emitEvent('progress', [this, this.img, message])
    }
    ;
    LoadingImage.prototype.handleEvent = function(event) {
        var method = 'on' + event.type;
        if (this[method]) {
            this[method](event)
        }
    }
    ;
    LoadingImage.prototype.onload = function() {
        this.confirm(!0, 'onload');
        this.unbindEvents()
    }
    ;
    LoadingImage.prototype.onerror = function() {
        this.confirm(!1, 'onerror');
        this.unbindEvents()
    }
    ;
    LoadingImage.prototype.unbindEvents = function() {
        this.proxyImage.removeEventListener('load', this);
        this.proxyImage.removeEventListener('error', this);
        this.img.removeEventListener('load', this);
        this.img.removeEventListener('error', this)
    }
    ;
    function Background(url, element) {
        this.url = url;
        this.element = element;
        this.img = new Image()
    }
    Background.prototype = Object.create(LoadingImage.prototype);
    Background.prototype.check = function() {
        this.img.addEventListener('load', this);
        this.img.addEventListener('error', this);
        this.img.src = this.url;
        var isComplete = this.getIsImageComplete();
        if (isComplete) {
            this.confirm(this.img.naturalWidth !== 0, 'naturalWidth');
            this.unbindEvents()
        }
    }
    ;
    Background.prototype.unbindEvents = function() {
        this.img.removeEventListener('load', this);
        this.img.removeEventListener('error', this)
    }
    ;
    Background.prototype.confirm = function(isLoaded, message) {
        this.isLoaded = isLoaded;
        this.emitEvent('progress', [this, this.element, message])
    }
    ;
    ImagesLoaded.makeJQueryPlugin = function(jQuery) {
        jQuery = jQuery || window.jQuery;
        if (!jQuery) {
            return
        }
        $ = jQuery;
        $.fn.imagesLoaded = function(options, callback) {
            var instance = new ImagesLoaded(this,options,callback);
            return instance.jqDeferred.promise($(this))
        }
    }
    ;
    ImagesLoaded.makeJQueryPlugin();
    return ImagesLoaded
});
/* /themes/horoshop_default/layout/js/vendor/jquery.mousewheel.js */
/*!
 * jQuery Mousewheel 3.1.12
 *
 * Copyright 2014 jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory)
    } else if (typeof exports === 'object') {
        module.exports = factory
    } else {
        factory(jQuery)
    }
}(function($) {
    var toFix = ['wheel', 'mousewheel', 'DOMMouseScroll', 'MozMousePixelScroll'], toBind = ('onwheel'in document || document.documentMode >= 9) ? ['wheel'] : ['mousewheel', 'DomMouseScroll', 'MozMousePixelScroll'], slice = Array.prototype.slice, nullLowestDeltaTimeout, lowestDelta;
    if ($.event.fixHooks) {
        for (var i = toFix.length; i; ) {
            $.event.fixHooks[toFix[--i]] = $.event.mouseHooks
        }
    }
    var special = $.event.special.mousewheel = {
        version: '3.1.12',
        setup: function() {
            if (this.addEventListener) {
                for (var i = toBind.length; i; ) {
                    this.addEventListener(toBind[--i], handler, !1)
                }
            } else {
                this.onmousewheel = handler
            }
            $.data(this, 'mousewheel-line-height', special.getLineHeight(this));
            $.data(this, 'mousewheel-page-height', special.getPageHeight(this))
        },
        teardown: function() {
            if (this.removeEventListener) {
                for (var i = toBind.length; i; ) {
                    this.removeEventListener(toBind[--i], handler, !1)
                }
            } else {
                this.onmousewheel = null
            }
            $.removeData(this, 'mousewheel-line-height');
            $.removeData(this, 'mousewheel-page-height')
        },
        getLineHeight: function(elem) {
            var $elem = $(elem)
              , $parent = $elem['offsetParent'in $.fn ? 'offsetParent' : 'parent']();
            if (!$parent.length) {
                $parent = $('body')
            }
            return parseInt($parent.css('fontSize'), 10) || parseInt($elem.css('fontSize'), 10) || 16
        },
        getPageHeight: function(elem) {
            return $(elem).height()
        },
        settings: {
            adjustOldDeltas: !0,
            normalizeOffset: !0
        }
    };
    $.fn.extend({
        mousewheel: function(fn) {
            return fn ? this.bind('mousewheel', fn) : this.trigger('mousewheel')
        },
        unmousewheel: function(fn) {
            return this.unbind('mousewheel', fn)
        }
    });
    function handler(event) {
        var orgEvent = event || window.event
          , args = slice.call(arguments, 1)
          , delta = 0
          , deltaX = 0
          , deltaY = 0
          , absDelta = 0
          , offsetX = 0
          , offsetY = 0;
        event = $.event.fix(orgEvent);
        event.type = 'mousewheel';
        if ('detail'in orgEvent) {
            deltaY = orgEvent.detail * -1
        }
        if ('wheelDelta'in orgEvent) {
            deltaY = orgEvent.wheelDelta
        }
        if ('wheelDeltaY'in orgEvent) {
            deltaY = orgEvent.wheelDeltaY
        }
        if ('wheelDeltaX'in orgEvent) {
            deltaX = orgEvent.wheelDeltaX * -1
        }
        if ('axis'in orgEvent && orgEvent.axis === orgEvent.HORIZONTAL_AXIS) {
            deltaX = deltaY * -1;
            deltaY = 0
        }
        delta = deltaY === 0 ? deltaX : deltaY;
        if ('deltaY'in orgEvent) {
            deltaY = orgEvent.deltaY * -1;
            delta = deltaY
        }
        if ('deltaX'in orgEvent) {
            deltaX = orgEvent.deltaX;
            if (deltaY === 0) {
                delta = deltaX * -1
            }
        }
        if (deltaY === 0 && deltaX === 0) {
            return
        }
        if (orgEvent.deltaMode === 1) {
            var lineHeight = $.data(this, 'mousewheel-line-height');
            delta *= lineHeight;
            deltaY *= lineHeight;
            deltaX *= lineHeight
        } else if (orgEvent.deltaMode === 2) {
            var pageHeight = $.data(this, 'mousewheel-page-height');
            delta *= pageHeight;
            deltaY *= pageHeight;
            deltaX *= pageHeight
        }
        absDelta = Math.max(Math.abs(deltaY), Math.abs(deltaX));
        if (!lowestDelta || absDelta < lowestDelta) {
            lowestDelta = absDelta;
            if (shouldAdjustOldDeltas(orgEvent, absDelta)) {
                lowestDelta /= 40
            }
        }
        if (shouldAdjustOldDeltas(orgEvent, absDelta)) {
            delta /= 40;
            deltaX /= 40;
            deltaY /= 40
        }
        delta = Math[delta >= 1 ? 'floor' : 'ceil'](delta / lowestDelta);
        deltaX = Math[deltaX >= 1 ? 'floor' : 'ceil'](deltaX / lowestDelta);
        deltaY = Math[deltaY >= 1 ? 'floor' : 'ceil'](deltaY / lowestDelta);
        if (special.settings.normalizeOffset && this.getBoundingClientRect) {
            var boundingRect = this.getBoundingClientRect();
            offsetX = event.clientX - boundingRect.left;
            offsetY = event.clientY - boundingRect.top
        }
        event.deltaX = deltaX;
        event.deltaY = deltaY;
        event.deltaFactor = lowestDelta;
        event.offsetX = offsetX;
        event.offsetY = offsetY;
        event.deltaMode = 0;
        args.unshift(event, delta, deltaX, deltaY);
        if (nullLowestDeltaTimeout) {
            clearTimeout(nullLowestDeltaTimeout)
        }
        nullLowestDeltaTimeout = setTimeout(nullLowestDelta, 200);
        return ($.event.dispatch || $.event.handle).apply(this, args)
    }
    function nullLowestDelta() {
        lowestDelta = null
    }
    function shouldAdjustOldDeltas(orgEvent, absDelta) {
        return special.settings.adjustOldDeltas && orgEvent.type === 'mousewheel' && absDelta % 120 === 0
    }
}));
/* /themes/horoshop_default/layout/js/vendor/jquery.jscrollpane.js */
/*!
 * jScrollPane - v2.0.22 - 2015-04-25
 * http://jscrollpane.kelvinluck.com/
 *
 * Copyright (c) 2014 Kelvin Luck
 * Dual licensed under the MIT or GPL licenses.
 */
(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory)
    } else if (typeof exports === 'object') {
        module.exports = factory(require('jquery'))
    } else {
        factory(jQuery)
    }
}(function($) {
    $.fn.jScrollPane = function(settings) {
        function JScrollPane(elem, s) {
            var settings, jsp = this, pane, paneWidth, paneHeight, container, contentWidth, contentHeight, percentInViewH, percentInViewV, isScrollableV, isScrollableH, verticalDrag, dragMaxY, verticalDragPosition, horizontalDrag, dragMaxX, horizontalDragPosition, verticalBar, verticalTrack, scrollbarWidth, verticalTrackHeight, verticalDragHeight, arrowUp, arrowDown, horizontalBar, horizontalTrack, horizontalTrackWidth, horizontalDragWidth, arrowLeft, arrowRight, reinitialiseInterval, originalPadding, originalPaddingTotalWidth, previousContentWidth, wasAtTop = !0, wasAtLeft = !0, wasAtBottom = !1, wasAtRight = !1, originalElement = elem.clone(!0, !1).empty(), mwEvent = $.fn.mwheelIntent ? 'mwheelIntent.jsp' : 'mousewheel.jsp';
            if (elem.css('box-sizing') === 'border-box') {
                originalPadding = 0;
                originalPaddingTotalWidth = 0
            } else {
                originalPadding = elem.css('paddingTop') + ' ' + elem.css('paddingRight') + ' ' + elem.css('paddingBottom') + ' ' + elem.css('paddingLeft');
                originalPaddingTotalWidth = (parseInt(elem.css('paddingLeft'), 10) || 0) + (parseInt(elem.css('paddingRight'), 10) || 0)
            }
            function initialise(s) {
                var isMaintainingPositon, lastContentX, lastContentY, hasContainingSpaceChanged, originalScrollTop, originalScrollLeft, maintainAtBottom = !1, maintainAtRight = !1;
                settings = s;
                if (pane === undefined) {
                    originalScrollTop = elem.scrollTop();
                    originalScrollLeft = elem.scrollLeft();
                    elem.css({
                        overflow: 'hidden',
                        padding: 0
                    });
                    paneWidth = elem.innerWidth() + originalPaddingTotalWidth;
                    paneHeight = elem.innerHeight();
                    elem.width(paneWidth);
                    pane = $('<div class="jspPane" />').css('padding', originalPadding).append(elem.children());
                    container = $('<div class="jspContainer" />').css({
                        'width': paneWidth + 'px',
                        'height': paneHeight + 'px'
                    }).append(pane).appendTo(elem)
                } else {
                    elem.css('width', '');
                    maintainAtBottom = settings.stickToBottom && isCloseToBottom();
                    maintainAtRight = settings.stickToRight && isCloseToRight();
                    hasContainingSpaceChanged = elem.innerWidth() + originalPaddingTotalWidth != paneWidth || elem.outerHeight() != paneHeight;
                    if (hasContainingSpaceChanged) {
                        paneWidth = elem.innerWidth() + originalPaddingTotalWidth;
                        paneHeight = elem.innerHeight();
                        container.css({
                            width: paneWidth + 'px',
                            height: paneHeight + 'px'
                        })
                    }
                    if (!hasContainingSpaceChanged && previousContentWidth == contentWidth && pane.outerHeight() == contentHeight) {
                        elem.width(paneWidth);
                        return
                    }
                    previousContentWidth = contentWidth;
                    pane.css('width', '');
                    elem.width(paneWidth);
                    container.find('>.jspVerticalBar,>.jspHorizontalBar').remove().end()
                }
                pane.css('overflow', 'auto');
                if (s.contentWidth) {
                    contentWidth = s.contentWidth
                } else {
                    contentWidth = pane[0].scrollWidth
                }
                contentHeight = pane[0].scrollHeight;
                pane.css('overflow', '');
                percentInViewH = contentWidth / paneWidth;
                percentInViewV = contentHeight / paneHeight;
                isScrollableV = percentInViewV > 1;
                isScrollableH = percentInViewH > 1;
                if (!(isScrollableH || isScrollableV)) {
                    elem.removeClass('jspScrollable');
                    pane.css({
                        top: 0,
                        left: 0,
                        width: container.width() - originalPaddingTotalWidth
                    });
                    removeMousewheel();
                    removeFocusHandler();
                    removeKeyboardNav();
                    removeClickOnTrack()
                } else {
                    elem.addClass('jspScrollable');
                    isMaintainingPositon = settings.maintainPosition && (verticalDragPosition || horizontalDragPosition);
                    if (isMaintainingPositon) {
                        lastContentX = contentPositionX();
                        lastContentY = contentPositionY()
                    }
                    initialiseVerticalScroll();
                    initialiseHorizontalScroll();
                    resizeScrollbars();
                    if (isMaintainingPositon) {
                        scrollToX(maintainAtRight ? (contentWidth - paneWidth) : lastContentX, !1);
                        scrollToY(maintainAtBottom ? (contentHeight - paneHeight) : lastContentY, !1)
                    }
                    initFocusHandler();
                    initMousewheel();
                    initTouch();
                    if (settings.enableKeyboardNavigation) {
                        initKeyboardNav()
                    }
                    if (settings.clickOnTrack) {
                        initClickOnTrack()
                    }
                    observeHash();
                    if (settings.hijackInternalLinks) {
                        hijackInternalLinks()
                    }
                }
                if (settings.autoReinitialise && !reinitialiseInterval) {
                    reinitialiseInterval = setInterval(function() {
                        initialise(settings)
                    }, settings.autoReinitialiseDelay)
                } else if (!settings.autoReinitialise && reinitialiseInterval) {
                    clearInterval(reinitialiseInterval)
                }
                originalScrollTop && elem.scrollTop(0) && scrollToY(originalScrollTop, !1);
                originalScrollLeft && elem.scrollLeft(0) && scrollToX(originalScrollLeft, !1);
                elem.trigger('jsp-initialised', [isScrollableH || isScrollableV])
            }
            function initialiseVerticalScroll() {
                if (isScrollableV) {
                    container.append($('<div class="jspVerticalBar" />').append($('<div class="jspCap jspCapTop" />'), $('<div class="jspTrack" />').append($('<div class="jspDrag" />').append($('<div class="jspDragTop" />'), $('<div class="jspDragBottom" />'))), $('<div class="jspCap jspCapBottom" />')));
                    verticalBar = container.find('>.jspVerticalBar');
                    verticalTrack = verticalBar.find('>.jspTrack');
                    verticalDrag = verticalTrack.find('>.jspDrag');
                    if (settings.showArrows) {
                        arrowUp = $('<a class="jspArrow jspArrowUp" />').bind('mousedown.jsp', getArrowScroll(0, -1)).bind('click.jsp', nil);
                        arrowDown = $('<a class="jspArrow jspArrowDown" />').bind('mousedown.jsp', getArrowScroll(0, 1)).bind('click.jsp', nil);
                        if (settings.arrowScrollOnHover) {
                            arrowUp.bind('mouseover.jsp', getArrowScroll(0, -1, arrowUp));
                            arrowDown.bind('mouseover.jsp', getArrowScroll(0, 1, arrowDown))
                        }
                        appendArrows(verticalTrack, settings.verticalArrowPositions, arrowUp, arrowDown)
                    }
                    verticalTrackHeight = paneHeight;
                    container.find('>.jspVerticalBar>.jspCap:visible,>.jspVerticalBar>.jspArrow').each(function() {
                        verticalTrackHeight -= $(this).outerHeight()
                    });
                    verticalDrag.hover(function() {
                        verticalDrag.addClass('jspHover')
                    }, function() {
                        verticalDrag.removeClass('jspHover')
                    }).bind('mousedown.jsp', function(e) {
                        $('html').bind('dragstart.jsp selectstart.jsp', nil);
                        verticalDrag.addClass('jspActive');
                        var startY = e.pageY - verticalDrag.position().top;
                        $('html').bind('mousemove.jsp', function(e) {
                            positionDragY(e.pageY - startY, !1)
                        }).bind('mouseup.jsp mouseleave.jsp', cancelDrag);
                        return !1
                    });
                    sizeVerticalScrollbar()
                }
            }
            function sizeVerticalScrollbar() {
                verticalTrack.height(verticalTrackHeight + 'px');
                verticalDragPosition = 0;
                scrollbarWidth = settings.verticalGutter + verticalTrack.outerWidth();
                pane.width(paneWidth - scrollbarWidth - originalPaddingTotalWidth);
                try {
                    if (verticalBar.position().left === 0) {
                        pane.css('margin-left', scrollbarWidth + 'px')
                    }
                } catch (err) {}
            }
            function initialiseHorizontalScroll() {
                if (isScrollableH) {
                    container.addClass('jspContainer--horizontal').append($('<div class="jspHorizontalBar" />').append($('<div class="jspCap jspCapLeft" />'), $('<div class="jspTrack" />').append($('<div class="jspDrag" />').append($('<div class="jspDragLeft" />'), $('<div class="jspDragRight" />'))), $('<div class="jspCap jspCapRight" />')));
                    horizontalBar = container.find('>.jspHorizontalBar');
                    horizontalTrack = horizontalBar.find('>.jspTrack');
                    horizontalDrag = horizontalTrack.find('>.jspDrag');
                    if (settings.showArrows) {
                        arrowLeft = $('<a class="jspArrow jspArrowLeft" />').bind('mousedown.jsp', getArrowScroll(-1, 0)).bind('click.jsp', nil);
                        arrowRight = $('<a class="jspArrow jspArrowRight" />').bind('mousedown.jsp', getArrowScroll(1, 0)).bind('click.jsp', nil);
                        if (settings.arrowScrollOnHover) {
                            arrowLeft.bind('mouseover.jsp', getArrowScroll(-1, 0, arrowLeft));
                            arrowRight.bind('mouseover.jsp', getArrowScroll(1, 0, arrowRight))
                        }
                        appendArrows(horizontalTrack, settings.horizontalArrowPositions, arrowLeft, arrowRight)
                    }
                    horizontalDrag.hover(function() {
                        horizontalDrag.addClass('jspHover')
                    }, function() {
                        horizontalDrag.removeClass('jspHover')
                    }).bind('mousedown.jsp', function(e) {
                        $('html').bind('dragstart.jsp selectstart.jsp', nil);
                        horizontalDrag.addClass('jspActive');
                        var startX = e.pageX - horizontalDrag.position().left;
                        $('html').bind('mousemove.jsp', function(e) {
                            positionDragX(e.pageX - startX, !1)
                        }).bind('mouseup.jsp mouseleave.jsp', cancelDrag);
                        return !1
                    });
                    horizontalTrackWidth = container.innerWidth();
                    sizeHorizontalScrollbar()
                }
            }
            function sizeHorizontalScrollbar() {
                container.find('>.jspHorizontalBar>.jspCap:visible,>.jspHorizontalBar>.jspArrow').each(function() {
                    horizontalTrackWidth -= $(this).outerWidth()
                });
                horizontalTrack.width(horizontalTrackWidth + 'px');
                horizontalDragPosition = 0
            }
            function resizeScrollbars() {
                if (isScrollableH && isScrollableV) {
                    var horizontalTrackHeight = horizontalTrack.outerHeight()
                      , verticalTrackWidth = verticalTrack.outerWidth();
                    verticalTrackHeight -= horizontalTrackHeight;
                    $(horizontalBar).find('>.jspCap:visible,>.jspArrow').each(function() {
                        horizontalTrackWidth += $(this).outerWidth()
                    });
                    horizontalTrackWidth -= verticalTrackWidth;
                    paneHeight -= verticalTrackWidth;
                    paneWidth -= horizontalTrackHeight;
                    horizontalTrack.parent().append($('<div class="jspCorner" />').css('width', horizontalTrackHeight + 'px'));
                    sizeVerticalScrollbar();
                    sizeHorizontalScrollbar()
                }
                if (isScrollableH) {
                    pane.width((container.outerWidth() - originalPaddingTotalWidth) + 'px')
                }
                contentHeight = pane.outerHeight();
                percentInViewV = contentHeight / paneHeight;
                if (isScrollableH) {
                    horizontalDragWidth = Math.ceil(1 / percentInViewH * horizontalTrackWidth);
                    if (horizontalDragWidth > settings.horizontalDragMaxWidth) {
                        horizontalDragWidth = settings.horizontalDragMaxWidth
                    } else if (horizontalDragWidth < settings.horizontalDragMinWidth) {
                        horizontalDragWidth = settings.horizontalDragMinWidth
                    }
                    horizontalDrag.width(horizontalDragWidth + 'px');
                    dragMaxX = horizontalTrackWidth - horizontalDragWidth;
                    _positionDragX(horizontalDragPosition)
                }
                if (isScrollableV) {
                    verticalDragHeight = Math.ceil(1 / percentInViewV * verticalTrackHeight);
                    if (verticalDragHeight > settings.verticalDragMaxHeight) {
                        verticalDragHeight = settings.verticalDragMaxHeight
                    } else if (verticalDragHeight < settings.verticalDragMinHeight) {
                        verticalDragHeight = settings.verticalDragMinHeight
                    }
                    verticalDrag.height(verticalDragHeight + 'px');
                    dragMaxY = verticalTrackHeight - verticalDragHeight;
                    _positionDragY(verticalDragPosition)
                }
            }
            function appendArrows(ele, p, a1, a2) {
                var p1 = "before", p2 = "after", aTemp;
                if (p == "os") {
                    p = /Mac/.test(navigator.platform) ? "after" : "split"
                }
                if (p == p1) {
                    p2 = p
                } else if (p == p2) {
                    p1 = p;
                    aTemp = a1;
                    a1 = a2;
                    a2 = aTemp
                }
                ele[p1](a1)[p2](a2)
            }
            function getArrowScroll(dirX, dirY, ele) {
                return function() {
                    arrowScroll(dirX, dirY, this, ele);
                    this.blur();
                    return !1
                }
            }
            function arrowScroll(dirX, dirY, arrow, ele) {
                arrow = $(arrow).addClass('jspActive');
                var eve, scrollTimeout, isFirst = !0, doScroll = function() {
                    if (dirX !== 0) {
                        jsp.scrollByX(dirX * settings.arrowButtonSpeed)
                    }
                    if (dirY !== 0) {
                        jsp.scrollByY(dirY * settings.arrowButtonSpeed)
                    }
                    scrollTimeout = setTimeout(doScroll, isFirst ? settings.initialDelay : settings.arrowRepeatFreq);
                    isFirst = !1
                };
                doScroll();
                eve = ele ? 'mouseout.jsp' : 'mouseup.jsp';
                ele = ele || $('html');
                ele.bind(eve, function() {
                    arrow.removeClass('jspActive');
                    scrollTimeout && clearTimeout(scrollTimeout);
                    scrollTimeout = null;
                    ele.unbind(eve)
                })
            }
            function initClickOnTrack() {
                removeClickOnTrack();
                if (isScrollableV) {
                    verticalTrack.bind('mousedown.jsp', function(e) {
                        if (e.originalTarget === undefined || e.originalTarget == e.currentTarget) {
                            var clickedTrack = $(this), offset = clickedTrack.offset(), direction = e.pageY - offset.top - verticalDragPosition, scrollTimeout, isFirst = !0, doScroll = function() {
                                var offset = clickedTrack.offset()
                                  , pos = e.pageY - offset.top - verticalDragHeight / 2
                                  , contentDragY = paneHeight * settings.scrollPagePercent
                                  , dragY = dragMaxY * contentDragY / (contentHeight - paneHeight);
                                if (direction < 0) {
                                    if (verticalDragPosition - dragY > pos) {
                                        jsp.scrollByY(-contentDragY)
                                    } else {
                                        positionDragY(pos)
                                    }
                                } else if (direction > 0) {
                                    if (verticalDragPosition + dragY < pos) {
                                        jsp.scrollByY(contentDragY)
                                    } else {
                                        positionDragY(pos)
                                    }
                                } else {
                                    cancelClick();
                                    return
                                }
                                scrollTimeout = setTimeout(doScroll, isFirst ? settings.initialDelay : settings.trackClickRepeatFreq);
                                isFirst = !1
                            }, cancelClick = function() {
                                scrollTimeout && clearTimeout(scrollTimeout);
                                scrollTimeout = null;
                                $(document).unbind('mouseup.jsp', cancelClick)
                            };
                            doScroll();
                            $(document).bind('mouseup.jsp', cancelClick);
                            return !1
                        }
                    })
                }
                if (isScrollableH) {
                    horizontalTrack.bind('mousedown.jsp', function(e) {
                        if (e.originalTarget === undefined || e.originalTarget == e.currentTarget) {
                            var clickedTrack = $(this), offset = clickedTrack.offset(), direction = e.pageX - offset.left - horizontalDragPosition, scrollTimeout, isFirst = !0, doScroll = function() {
                                var offset = clickedTrack.offset()
                                  , pos = e.pageX - offset.left - horizontalDragWidth / 2
                                  , contentDragX = paneWidth * settings.scrollPagePercent
                                  , dragX = dragMaxX * contentDragX / (contentWidth - paneWidth);
                                if (direction < 0) {
                                    if (horizontalDragPosition - dragX > pos) {
                                        jsp.scrollByX(-contentDragX)
                                    } else {
                                        positionDragX(pos)
                                    }
                                } else if (direction > 0) {
                                    if (horizontalDragPosition + dragX < pos) {
                                        jsp.scrollByX(contentDragX)
                                    } else {
                                        positionDragX(pos)
                                    }
                                } else {
                                    cancelClick();
                                    return
                                }
                                scrollTimeout = setTimeout(doScroll, isFirst ? settings.initialDelay : settings.trackClickRepeatFreq);
                                isFirst = !1
                            }, cancelClick = function() {
                                scrollTimeout && clearTimeout(scrollTimeout);
                                scrollTimeout = null;
                                $(document).unbind('mouseup.jsp', cancelClick)
                            };
                            doScroll();
                            $(document).bind('mouseup.jsp', cancelClick);
                            return !1
                        }
                    })
                }
            }
            function removeClickOnTrack() {
                if (horizontalTrack) {
                    horizontalTrack.unbind('mousedown.jsp')
                }
                if (verticalTrack) {
                    verticalTrack.unbind('mousedown.jsp')
                }
            }
            function cancelDrag() {
                $('html').unbind('dragstart.jsp selectstart.jsp mousemove.jsp mouseup.jsp mouseleave.jsp');
                if (verticalDrag) {
                    verticalDrag.removeClass('jspActive')
                }
                if (horizontalDrag) {
                    horizontalDrag.removeClass('jspActive')
                }
            }
            function positionDragY(destY, animate) {
                if (!isScrollableV) {
                    return
                }
                if (destY < 0) {
                    destY = 0
                } else if (destY > dragMaxY) {
                    destY = dragMaxY
                }
                if (animate === undefined) {
                    animate = settings.animateScroll
                }
                if (animate) {
                    jsp.animate(verticalDrag, 'top', destY, _positionDragY)
                } else {
                    verticalDrag.css('top', destY);
                    _positionDragY(destY)
                }
            }
            function _positionDragY(destY) {
                if (destY === undefined) {
                    destY = verticalDrag.position().top
                }
                container.scrollTop(0);
                verticalDragPosition = destY || 0;
                var isAtTop = verticalDragPosition === 0
                  , isAtBottom = verticalDragPosition == dragMaxY
                  , percentScrolled = destY / dragMaxY
                  , destTop = -percentScrolled * (contentHeight - paneHeight);
                if (wasAtTop != isAtTop || wasAtBottom != isAtBottom) {
                    wasAtTop = isAtTop;
                    wasAtBottom = isAtBottom;
                    elem.trigger('jsp-arrow-change', [wasAtTop, wasAtBottom, wasAtLeft, wasAtRight])
                }
                updateVerticalArrows(isAtTop, isAtBottom);
                pane.css('top', destTop);
                elem.trigger('jsp-scroll-y', [-destTop, isAtTop, isAtBottom]).trigger('scroll')
            }
            function positionDragX(destX, animate) {
                if (!isScrollableH) {
                    return
                }
                if (destX < 0) {
                    destX = 0
                } else if (destX > dragMaxX) {
                    destX = dragMaxX
                }
                if (animate === undefined) {
                    animate = settings.animateScroll
                }
                if (animate) {
                    jsp.animate(horizontalDrag, 'left', destX, _positionDragX)
                } else {
                    horizontalDrag.css('left', destX);
                    _positionDragX(destX)
                }
            }
            function _positionDragX(destX) {
                if (destX === undefined) {
                    destX = horizontalDrag.position().left
                }
                container.scrollTop(0);
                horizontalDragPosition = destX || 0;
                var isAtLeft = horizontalDragPosition === 0
                  , isAtRight = horizontalDragPosition == dragMaxX
                  , percentScrolled = destX / dragMaxX
                  , destLeft = -percentScrolled * (contentWidth - paneWidth);
                if (wasAtLeft != isAtLeft || wasAtRight != isAtRight) {
                    wasAtLeft = isAtLeft;
                    wasAtRight = isAtRight;
                    elem.trigger('jsp-arrow-change', [wasAtTop, wasAtBottom, wasAtLeft, wasAtRight])
                }
                updateHorizontalArrows(isAtLeft, isAtRight);
                pane.css('left', destLeft);
                elem.trigger('jsp-scroll-x', [-destLeft, isAtLeft, isAtRight]).trigger('scroll')
            }
            function updateVerticalArrows(isAtTop, isAtBottom) {
                if (settings.showArrows) {
                    arrowUp[isAtTop ? 'addClass' : 'removeClass']('jspDisabled');
                    arrowDown[isAtBottom ? 'addClass' : 'removeClass']('jspDisabled')
                }
            }
            function updateHorizontalArrows(isAtLeft, isAtRight) {
                if (settings.showArrows) {
                    arrowLeft[isAtLeft ? 'addClass' : 'removeClass']('jspDisabled');
                    arrowRight[isAtRight ? 'addClass' : 'removeClass']('jspDisabled')
                }
            }
            function scrollToY(destY, animate) {
                var percentScrolled = destY / (contentHeight - paneHeight);
                positionDragY(percentScrolled * dragMaxY, animate)
            }
            function scrollToX(destX, animate) {
                var percentScrolled = destX / (contentWidth - paneWidth);
                positionDragX(percentScrolled * dragMaxX, animate)
            }
            function scrollToElement(ele, stickToTop, animate) {
                var e, eleHeight, eleWidth, eleTop = 0, eleLeft = 0, viewportTop, viewportLeft, maxVisibleEleTop, maxVisibleEleLeft, destY, destX;
                try {
                    e = $(ele)
                } catch (err) {
                    return
                }
                eleHeight = e.outerHeight();
                eleWidth = e.outerWidth();
                container.scrollTop(0);
                container.scrollLeft(0);
                while (!e.is('.jspPane')) {
                    eleTop += e.position().top;
                    eleLeft += e.position().left;
                    e = e.offsetParent();
                    if (/^body|html$/i.test(e[0].nodeName)) {
                        return
                    }
                }
                viewportTop = contentPositionY();
                maxVisibleEleTop = viewportTop + paneHeight;
                if (eleTop < viewportTop || stickToTop) {
                    destY = eleTop - settings.horizontalGutter
                } else if (eleTop + eleHeight > maxVisibleEleTop) {
                    destY = eleTop - paneHeight + eleHeight + settings.horizontalGutter
                }
                if (!isNaN(destY)) {
                    scrollToY(destY, animate)
                }
                viewportLeft = contentPositionX();
                maxVisibleEleLeft = viewportLeft + paneWidth;
                if (eleLeft < viewportLeft || stickToTop) {
                    destX = eleLeft - settings.horizontalGutter
                } else if (eleLeft + eleWidth > maxVisibleEleLeft) {
                    destX = eleLeft - paneWidth + eleWidth + settings.horizontalGutter
                }
                if (!isNaN(destX)) {
                    scrollToX(destX, animate)
                }
            }
            function contentPositionX() {
                return -pane.position().left
            }
            function contentPositionY() {
                return -pane.position().top
            }
            function isCloseToBottom() {
                var scrollableHeight = contentHeight - paneHeight;
                return (scrollableHeight > 20) && (scrollableHeight - contentPositionY() < 10)
            }
            function isCloseToRight() {
                var scrollableWidth = contentWidth - paneWidth;
                return (scrollableWidth > 20) && (scrollableWidth - contentPositionX() < 10)
            }
            function initMousewheel() {
                container.unbind(mwEvent).bind(mwEvent, function(event, delta, deltaX, deltaY) {
                    if (!horizontalDragPosition)
                        horizontalDragPosition = 0;
                    if (!verticalDragPosition)
                        verticalDragPosition = 0;
                    var dX = horizontalDragPosition
                      , dY = verticalDragPosition
                      , factor = event.deltaFactor || settings.mouseWheelSpeed;
                    jsp.scrollBy(deltaX * factor, -deltaY * factor, !1);
                    return dX == horizontalDragPosition && dY == verticalDragPosition
                })
            }
            function removeMousewheel() {
                container.unbind(mwEvent)
            }
            function nil() {
                return !1
            }
            function initFocusHandler() {
                pane.find(':input,a').unbind('focus.jsp').bind('focus.jsp', function(e) {
                    scrollToElement(e.target, !1)
                })
            }
            function removeFocusHandler() {
                pane.find(':input,a').unbind('focus.jsp')
            }
            function initKeyboardNav() {
                var keyDown, elementHasScrolled, validParents = [];
                isScrollableH && validParents.push(horizontalBar[0]);
                isScrollableV && validParents.push(verticalBar[0]);
                pane.bind('focus.jsp', function() {
                    elem.focus()
                });
                elem.attr('tabindex', 0).unbind('keydown.jsp keypress.jsp').bind('keydown.jsp', function(e) {
                    if (e.target !== this && !(validParents.length && $(e.target).closest(validParents).length)) {
                        return
                    }
                    var dX = horizontalDragPosition
                      , dY = verticalDragPosition;
                    switch (e.keyCode) {
                    case 40:
                    case 38:
                    case 34:
                    case 32:
                    case 33:
                    case 39:
                    case 37:
                        keyDown = e.keyCode;
                        keyDownHandler();
                        break;
                    case 35:
                        scrollToY(contentHeight - paneHeight);
                        keyDown = null;
                        break;
                    case 36:
                        scrollToY(0);
                        keyDown = null;
                        break
                    }
                    elementHasScrolled = e.keyCode == keyDown && dX != horizontalDragPosition || dY != verticalDragPosition;
                    return !elementHasScrolled
                }).bind('keypress.jsp', function(e) {
                    if (e.keyCode == keyDown) {
                        keyDownHandler()
                    }
                    return !elementHasScrolled
                });
                if (settings.hideFocus) {
                    elem.css('outline', 'none');
                    if ('hideFocus'in container[0]) {
                        elem.attr('hideFocus', !0)
                    }
                } else {
                    elem.css('outline', '');
                    if ('hideFocus'in container[0]) {
                        elem.attr('hideFocus', !1)
                    }
                }
                function keyDownHandler() {
                    var dX = horizontalDragPosition
                      , dY = verticalDragPosition;
                    switch (keyDown) {
                    case 40:
                        jsp.scrollByY(settings.keyboardSpeed, !1);
                        break;
                    case 38:
                        jsp.scrollByY(-settings.keyboardSpeed, !1);
                        break;
                    case 34:
                    case 32:
                        jsp.scrollByY(paneHeight * settings.scrollPagePercent, !1);
                        break;
                    case 33:
                        jsp.scrollByY(-paneHeight * settings.scrollPagePercent, !1);
                        break;
                    case 39:
                        jsp.scrollByX(settings.keyboardSpeed, !1);
                        break;
                    case 37:
                        jsp.scrollByX(-settings.keyboardSpeed, !1);
                        break
                    }
                    elementHasScrolled = dX != horizontalDragPosition || dY != verticalDragPosition;
                    return elementHasScrolled
                }
            }
            function removeKeyboardNav() {
                elem.attr('tabindex', '-1').removeAttr('tabindex').unbind('keydown.jsp keypress.jsp');
                pane.unbind('.jsp')
            }
            function observeHash() {
                if (location.hash && location.hash.length > 1) {
                    var e, retryInt, hash = escape(location.hash.substr(1));
                    try {
                        e = $('#' + hash + ', a[name="' + hash + '"]')
                    } catch (err) {
                        return
                    }
                    if (e.length && pane.find(hash)) {
                        if (container.scrollTop() === 0) {
                            retryInt = setInterval(function() {
                                if (container.scrollTop() > 0) {
                                    scrollToElement(e, !0);
                                    $(document).scrollTop(container.position().top);
                                    clearInterval(retryInt)
                                }
                            }, 50)
                        } else {
                            scrollToElement(e, !0);
                            $(document).scrollTop(container.position().top)
                        }
                    }
                }
            }
            function hijackInternalLinks() {
                if ($(document.body).data('jspHijack')) {
                    return
                }
                $(document.body).data('jspHijack', !0);
                $(document.body).delegate('a[href*=#]', 'click', function(event) {
                    var href = this.href.substr(0, this.href.indexOf('#')), locationHref = location.href, hash, element, container, jsp, scrollTop, elementTop;
                    if (location.href.indexOf('#') !== -1) {
                        locationHref = location.href.substr(0, location.href.indexOf('#'))
                    }
                    if (href !== locationHref) {
                        return
                    }
                    hash = escape(this.href.substr(this.href.indexOf('#') + 1));
                    element;
                    try {
                        element = $('#' + hash + ', a[name="' + hash + '"]')
                    } catch (e) {
                        return
                    }
                    if (!element.length) {
                        return
                    }
                    container = element.closest('.jspScrollable');
                    jsp = container.data('jsp');
                    jsp.scrollToElement(element, !0);
                    if (container[0].scrollIntoView) {
                        scrollTop = $(window).scrollTop();
                        elementTop = element.offset().top;
                        if (elementTop < scrollTop || elementTop > scrollTop + $(window).height()) {
                            container[0].scrollIntoView()
                        }
                    }
                    event.preventDefault()
                })
            }
            function initTouch() {
                var startX, startY, touchStartX, touchStartY, moved, moving = !1;
                container.unbind('touchstart.jsp touchmove.jsp touchend.jsp click.jsp-touchclick').bind('touchstart.jsp', function(e) {
                    var touch = e.originalEvent.touches[0];
                    startX = contentPositionX();
                    startY = contentPositionY();
                    touchStartX = touch.pageX;
                    touchStartY = touch.pageY;
                    moved = !1;
                    moving = !0
                }).bind('touchmove.jsp', function(ev) {
                    if (!moving) {
                        return
                    }
                    var touchPos = ev.originalEvent.touches[0]
                      , dX = horizontalDragPosition
                      , dY = verticalDragPosition;
                    jsp.scrollTo(startX + touchStartX - touchPos.pageX, startY + touchStartY - touchPos.pageY);
                    moved = moved || Math.abs(touchStartX - touchPos.pageX) > 5 || Math.abs(touchStartY - touchPos.pageY) > 5;
                    return dX == horizontalDragPosition && dY == verticalDragPosition
                }).bind('touchend.jsp', function(e) {
                    moving = !1
                }).bind('click.jsp-touchclick', function(e) {
                    if (moved) {
                        moved = !1;
                        return !1
                    }
                })
            }
            function destroy() {
                var currentY = contentPositionY()
                  , currentX = contentPositionX();
                elem.removeClass('jspScrollable').unbind('.jsp');
                pane.unbind('.jsp');
                elem.replaceWith(originalElement.append(pane.children()));
                originalElement.scrollTop(currentY);
                originalElement.scrollLeft(currentX);
                if (reinitialiseInterval) {
                    clearInterval(reinitialiseInterval)
                }
            }
            $.extend(jsp, {
                reinitialise: function(s) {
                    s = $.extend({}, settings, s);
                    initialise(s)
                },
                scrollToElement: function(ele, stickToTop, animate) {
                    scrollToElement(ele, stickToTop, animate)
                },
                scrollTo: function(destX, destY, animate) {
                    scrollToX(destX, animate);
                    scrollToY(destY, animate)
                },
                scrollToX: function(destX, animate) {
                    scrollToX(destX, animate)
                },
                scrollToY: function(destY, animate) {
                    scrollToY(destY, animate)
                },
                scrollToPercentX: function(destPercentX, animate) {
                    scrollToX(destPercentX * (contentWidth - paneWidth), animate)
                },
                scrollToPercentY: function(destPercentY, animate) {
                    scrollToY(destPercentY * (contentHeight - paneHeight), animate)
                },
                scrollBy: function(deltaX, deltaY, animate) {
                    jsp.scrollByX(deltaX, animate);
                    jsp.scrollByY(deltaY, animate)
                },
                scrollByX: function(deltaX, animate) {
                    var destX = contentPositionX() + Math[deltaX < 0 ? 'floor' : 'ceil'](deltaX)
                      , percentScrolled = destX / (contentWidth - paneWidth);
                    positionDragX(percentScrolled * dragMaxX, animate)
                },
                scrollByY: function(deltaY, animate) {
                    var destY = contentPositionY() + Math[deltaY < 0 ? 'floor' : 'ceil'](deltaY)
                      , percentScrolled = destY / (contentHeight - paneHeight);
                    positionDragY(percentScrolled * dragMaxY, animate)
                },
                positionDragX: function(x, animate) {
                    positionDragX(x, animate)
                },
                positionDragY: function(y, animate) {
                    positionDragY(y, animate)
                },
                animate: function(ele, prop, value, stepCallback) {
                    var params = {};
                    params[prop] = value;
                    ele.animate(params, {
                        'duration': settings.animateDuration,
                        'easing': settings.animateEase,
                        'queue': !1,
                        'step': stepCallback
                    })
                },
                getContentPositionX: function() {
                    return contentPositionX()
                },
                getContentPositionY: function() {
                    return contentPositionY()
                },
                getContentWidth: function() {
                    return contentWidth
                },
                getContentHeight: function() {
                    return contentHeight
                },
                getPercentScrolledX: function() {
                    return contentPositionX() / (contentWidth - paneWidth)
                },
                getPercentScrolledY: function() {
                    return contentPositionY() / (contentHeight - paneHeight)
                },
                getIsScrollableH: function() {
                    return isScrollableH
                },
                getIsScrollableV: function() {
                    return isScrollableV
                },
                getContentPane: function() {
                    return pane
                },
                scrollToBottom: function(animate) {
                    positionDragY(dragMaxY, animate)
                },
                hijackInternalLinks: $.noop,
                destroy: function() {
                    destroy()
                }
            });
            initialise(s)
        }
        settings = $.extend({}, $.fn.jScrollPane.defaults, settings);
        $.each(['arrowButtonSpeed', 'trackClickSpeed', 'keyboardSpeed'], function() {
            settings[this] = settings[this] || settings.speed
        });
        return this.each(function() {
            var elem = $(this)
              , jspApi = elem.data('jsp');
            if (jspApi) {
                jspApi.reinitialise(settings)
            } else {
                $("script", elem).filter('[type="text/javascript"],:not([type])').remove();
                jspApi = new JScrollPane(elem,settings);
                elem.data('jsp', jspApi)
            }
        })
    }
    ;
    $.fn.jScrollPane.defaults = {
        showArrows: !1,
        maintainPosition: !0,
        stickToBottom: !1,
        stickToRight: !1,
        clickOnTrack: !0,
        autoReinitialise: !1,
        autoReinitialiseDelay: 500,
        verticalDragMinHeight: 0,
        verticalDragMaxHeight: 99999,
        horizontalDragMinWidth: 0,
        horizontalDragMaxWidth: 99999,
        contentWidth: undefined,
        animateScroll: !1,
        animateDuration: 300,
        animateEase: 'linear',
        hijackInternalLinks: !1,
        verticalGutter: 4,
        horizontalGutter: 4,
        mouseWheelSpeed: 3,
        arrowButtonSpeed: 0,
        arrowRepeatFreq: 50,
        arrowScrollOnHover: !1,
        trackClickSpeed: 0,
        trackClickRepeatFreq: 70,
        verticalArrowPositions: 'split',
        horizontalArrowPositions: 'split',
        enableKeyboardNavigation: !0,
        hideFocus: !1,
        keyboardSpeed: 0,
        initialDelay: 300,
        speed: 30,
        scrollPagePercent: .8
    }
}));
/* /themes/horoshop_default/layout/js/vendor/jquery.menu-aim.js */
(function($) {
    $.MenuAim = function(opts, element) {
        this.init(opts, element)
    }
    ;
    $.fn.menuAim = function(opts) {
        var instance = $.data(this, 'MenuAim');
        if (!instance) {
            this.each(function() {
                $.data(this, 'MenuAim', new $.MenuAim(opts,this))
            })
        }
        return this
    }
    ;
    $.MenuAim.defaults = {
        rowSelector: "> li",
        submenuSelector: "*",
        submenuDirection: "right",
        tolerance: 75,
        closeDelay: 1000,
        enter: $.noop,
        exit: $.noop,
        activate: $.noop,
        deactivate: $.noop,
        exitMenu: $.noop
    };
    $.MenuAim.prototype.init = function(opts, element) {
        this.options = $.extend(!0, {}, $.MenuAim.defaults, opts);
        var $menu = $(element)
          , activeRow = null
          , mouseLocs = []
          , lastDelayLoc = null
          , timeoutId = null
          , t = null
          , options = this.options;
        var MOUSE_LOCS_TRACKED = 3
          , DELAY = 300;
        var mousemoveDocument = function(e) {
            mouseLocs.push({
                x: e.pageX,
                y: e.pageY
            });
            if (mouseLocs.length > MOUSE_LOCS_TRACKED) {
                mouseLocs.shift()
            }
        };
        var mouseleaveMenu = function() {
            if (timeoutId) {
                clearTimeout(timeoutId)
            }
            if (options.exitMenu(this)) {
                if (activeRow) {
                    t = setTimeout(function() {
                        options.deactivate(activeRow);
                        activeRow = null
                    }, options.closeDelay)
                }
            }
        };
        var mouseBack = function() {
            if (t) {
                clearTimeout(t)
            }
        }
        var mouseenterRow = function() {
            if (timeoutId) {
                clearTimeout(timeoutId)
            }
            options.enter(this);
            possiblyActivate(this)
        }
          , mouseleaveRow = function() {
            options.exit(this)
        };
        var clickRow = function() {
            activate(this)
        };
        var activate = function(row) {
            if (row == activeRow) {
                return
            }
            if (activeRow) {
                options.deactivate(activeRow)
            }
            options.activate(row);
            activeRow = row
        };
        var possiblyActivate = function(row) {
            var delay = activationDelay();
            if (delay) {
                timeoutId = setTimeout(function() {
                    possiblyActivate(row)
                }, delay)
            } else {
                activate(row)
            }
        };
        var activationDelay = function() {
            if (!activeRow || !$(activeRow).is(options.submenuSelector)) {
                return 0
            }
            var offset = $menu.offset()
              , upperLeft = {
                x: offset.left,
                y: offset.top - options.tolerance
            }
              , upperRight = {
                x: offset.left + $menu.outerWidth(),
                y: upperLeft.y
            }
              , lowerLeft = {
                x: offset.left,
                y: offset.top + $menu.outerHeight() + options.tolerance
            }
              , lowerRight = {
                x: offset.left + $menu.outerWidth(),
                y: lowerLeft.y
            }
              , loc = mouseLocs[mouseLocs.length - 1]
              , prevLoc = mouseLocs[0];
            if (!loc) {
                return 0
            }
            if (!prevLoc) {
                prevLoc = loc
            }
            if (prevLoc.x < offset.left || prevLoc.x > lowerRight.x || prevLoc.y < offset.top || prevLoc.y > lowerRight.y) {
                return 0
            }
            if (lastDelayLoc && loc.x == lastDelayLoc.x && loc.y == lastDelayLoc.y) {
                return 0
            }
            function slope(a, b) {
                return (b.y - a.y) / (b.x - a.x)
            }
            ;var decreasingCorner = upperRight
              , increasingCorner = lowerRight;
            if (options.submenuDirection == "left") {
                decreasingCorner = lowerLeft;
                increasingCorner = upperLeft
            } else if (options.submenuDirection == "below") {
                decreasingCorner = lowerRight;
                increasingCorner = lowerLeft
            } else if (options.submenuDirection == "above") {
                decreasingCorner = upperLeft;
                increasingCorner = upperRight
            }
            var decreasingSlope = slope(loc, decreasingCorner)
              , increasingSlope = slope(loc, increasingCorner)
              , prevDecreasingSlope = slope(prevLoc, decreasingCorner)
              , prevIncreasingSlope = slope(prevLoc, increasingCorner);
            if (decreasingSlope < prevDecreasingSlope && increasingSlope > prevIncreasingSlope) {
                lastDelayLoc = loc;
                return DELAY
            }
            lastDelayLoc = null;
            return 0
        };
        $menu.mouseleave(mouseleaveMenu).mouseenter(mouseBack).find(options.rowSelector).mouseenter(mouseenterRow).mouseleave(mouseleaveRow).click(clickRow);
        $(document).mousemove(mousemoveDocument)
    }
    ;
    $.MenuAim.prototype.setOption = function(option, value) {
        this.options[option] = value
    }
}
)(jQuery);
/* /themes/horoshop_default/layout/js/vendor/popper.min.js */
/*
 Copyright (C) Federico Zivolo 2017
 Distributed under the MIT License (license terms are at http://opensource.org/licenses/MIT).
 */
(function(e, t) {
    'object' == typeof exports && 'undefined' != typeof module ? module.exports = t() : 'function' == typeof define && define.amd ? define(t) : e.Popper = t()
}
)(this, function() {
    'use strict';
    function e(e) {
        return e && '[object Function]' === {}.toString.call(e)
    }
    function t(e, t) {
        if (1 !== e.nodeType)
            return [];
        var o = window.getComputedStyle(e, null);
        return t ? o[t] : o
    }
    function o(e) {
        return 'HTML' === e.nodeName ? e : e.parentNode || e.host
    }
    function n(e) {
        if (!e)
            return window.document.body;
        switch (e.nodeName) {
        case 'HTML':
        case 'BODY':
            return e.ownerDocument.body;
        case '#document':
            return e.body;
        }
        var i = t(e)
          , r = i.overflow
          , p = i.overflowX
          , s = i.overflowY;
        return /(auto|scroll)/.test(r + s + p) ? e : n(o(e))
    }
    function r(e) {
        var o = e && e.offsetParent
          , i = o && o.nodeName;
        return i && 'BODY' !== i && 'HTML' !== i ? -1 !== ['TD', 'TABLE'].indexOf(o.nodeName) && 'static' === t(o, 'position') ? r(o) : o : e ? e.ownerDocument.documentElement : window.document.documentElement
    }
    function p(e) {
        var t = e.nodeName;
        return 'BODY' !== t && ('HTML' === t || r(e.firstElementChild) === e)
    }
    function s(e) {
        return null === e.parentNode ? e : s(e.parentNode)
    }
    function d(e, t) {
        if (!e || !e.nodeType || !t || !t.nodeType)
            return window.document.documentElement;
        var o = e.compareDocumentPosition(t) & Node.DOCUMENT_POSITION_FOLLOWING
          , i = o ? e : t
          , n = o ? t : e
          , a = document.createRange();
        a.setStart(i, 0),
        a.setEnd(n, 0);
        var l = a.commonAncestorContainer;
        if (e !== l && t !== l || i.contains(n))
            return p(l) ? l : r(l);
        var f = s(e);
        return f.host ? d(f.host, t) : d(e, s(t).host)
    }
    function a(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 'top'
          , o = 'top' === t ? 'scrollTop' : 'scrollLeft'
          , i = e.nodeName;
        if ('BODY' === i || 'HTML' === i) {
            var n = e.ownerDocument.documentElement
              , r = e.ownerDocument.scrollingElement || n;
            return r[o]
        }
        return e[o]
    }
    function l(e, t) {
        var o = 2 < arguments.length && void 0 !== arguments[2] && arguments[2]
          , i = a(t, 'top')
          , n = a(t, 'left')
          , r = o ? -1 : 1;
        return e.top += i * r,
        e.bottom += i * r,
        e.left += n * r,
        e.right += n * r,
        e
    }
    function f(e, t) {
        var o = 'x' === t ? 'Left' : 'Top'
          , i = 'Left' == o ? 'Right' : 'Bottom';
        return +e['border' + o + 'Width'].split('px')[0] + +e['border' + i + 'Width'].split('px')[0]
    }
    function m(e, t, o, i) {
        return J(t['offset' + e], t['scroll' + e], o['client' + e], o['offset' + e], o['scroll' + e], ie() ? o['offset' + e] + i['margin' + ('Height' === e ? 'Top' : 'Left')] + i['margin' + ('Height' === e ? 'Bottom' : 'Right')] : 0)
    }
    function c() {
        var e = window.document.body
          , t = window.document.documentElement
          , o = ie() && window.getComputedStyle(t);
        return {
            height: m('Height', e, t, o),
            width: m('Width', e, t, o)
        }
    }
    function h(e) {
        return se({}, e, {
            right: e.left + e.width,
            bottom: e.top + e.height
        })
    }
    function u(e) {
        var o = {};
        if (ie())
            try {
                o = e.getBoundingClientRect();
                var i = a(e, 'top')
                  , n = a(e, 'left');
                o.top += i,
                o.left += n,
                o.bottom += i,
                o.right += n
            } catch (e) {}
        else
            o = e.getBoundingClientRect();
        var r = {
            left: o.left,
            top: o.top,
            width: o.right - o.left,
            height: o.bottom - o.top
        }
          , p = 'HTML' === e.nodeName ? c() : {}
          , s = p.width || e.clientWidth || r.right - r.left
          , d = p.height || e.clientHeight || r.bottom - r.top
          , l = e.offsetWidth - s
          , m = e.offsetHeight - d;
        if (l || m) {
            var u = t(e);
            l -= f(u, 'x'),
            m -= f(u, 'y'),
            r.width -= l,
            r.height -= m
        }
        return h(r)
    }
    function g(e, o) {
        var i = ie()
          , r = 'HTML' === o.nodeName
          , p = u(e)
          , s = u(o)
          , d = n(e)
          , a = t(o)
          , f = +a.borderTopWidth.split('px')[0]
          , m = +a.borderLeftWidth.split('px')[0]
          , c = h({
            top: p.top - s.top - f,
            left: p.left - s.left - m,
            width: p.width,
            height: p.height
        });
        if (c.marginTop = 0,
        c.marginLeft = 0,
        !i && r) {
            var g = +a.marginTop.split('px')[0]
              , b = +a.marginLeft.split('px')[0];
            c.top -= f - g,
            c.bottom -= f - g,
            c.left -= m - b,
            c.right -= m - b,
            c.marginTop = g,
            c.marginLeft = b
        }
        return (i ? o.contains(d) : o === d && 'BODY' !== d.nodeName) && (c = l(c, o)),
        c
    }
    function b(e) {
        var t = e.ownerDocument.documentElement
          , o = g(e, t)
          , i = J(t.clientWidth, window.innerWidth || 0)
          , n = J(t.clientHeight, window.innerHeight || 0)
          , r = a(t)
          , p = a(t, 'left')
          , s = {
            top: r - o.top + o.marginTop,
            left: p - o.left + o.marginLeft,
            width: i,
            height: n
        };
        return h(s)
    }
    function y(e) {
        var i = e.nodeName;
        return 'BODY' === i || 'HTML' === i ? !1 : 'fixed' === t(e, 'position') || y(o(e))
    }
    function w(e, t, i, r) {
        var p = {
            top: 0,
            left: 0
        }
          , s = d(e, t);
        if ('viewport' === r)
            p = b(s);
        else {
            var a;
            'scrollParent' === r ? (a = n(o(e)),
            'BODY' === a.nodeName && (a = e.ownerDocument.documentElement)) : 'window' === r ? a = e.ownerDocument.documentElement : a = r;
            var l = g(a, s);
            if ('HTML' === a.nodeName && !y(s)) {
                var f = c()
                  , m = f.height
                  , h = f.width;
                p.top += l.top - l.marginTop,
                p.bottom = m + l.top,
                p.left += l.left - l.marginLeft,
                p.right = h + l.left
            } else
                p = l
        }
        return p.left += i,
        p.top += i,
        p.right -= i,
        p.bottom -= i,
        p
    }
    function E(e) {
        var t = e.width
          , o = e.height;
        return t * o
    }
    function v(e, t, o, i, n) {
        var r = 5 < arguments.length && void 0 !== arguments[5] ? arguments[5] : 0;
        if (-1 === e.indexOf('auto'))
            return e;
        var p = w(o, i, r, n)
          , s = {
            top: {
                width: p.width,
                height: t.top - p.top
            },
            right: {
                width: p.right - t.right,
                height: p.height
            },
            bottom: {
                width: p.width,
                height: p.bottom - t.bottom
            },
            left: {
                width: t.left - p.left,
                height: p.height
            }
        }
          , d = Object.keys(s).map(function(e) {
            return se({
                key: e
            }, s[e], {
                area: E(s[e])
            })
        }).sort(function(e, t) {
            return t.area - e.area
        })
          , a = d.filter(function(e) {
            var t = e.width
              , i = e.height;
            return t >= o.clientWidth && i >= o.clientHeight
        })
          , l = 0 < a.length ? a[0].key : d[0].key
          , f = e.split('-')[1];
        return l + (f ? '-' + f : '')
    }
    function x(e, t, o) {
        var i = d(t, o);
        return g(o, i)
    }
    function O(e) {
        var t = window.getComputedStyle(e)
          , o = parseFloat(t.marginTop) + parseFloat(t.marginBottom)
          , i = parseFloat(t.marginLeft) + parseFloat(t.marginRight)
          , n = {
            width: e.offsetWidth + i,
            height: e.offsetHeight + o
        };
        return n
    }
    function L(e) {
        var t = {
            left: 'right',
            right: 'left',
            bottom: 'top',
            top: 'bottom'
        };
        return e.replace(/left|right|bottom|top/g, function(e) {
            return t[e]
        })
    }
    function S(e, t, o) {
        o = o.split('-')[0];
        var i = O(e)
          , n = {
            width: i.width,
            height: i.height
        }
          , r = -1 !== ['right', 'left'].indexOf(o)
          , p = r ? 'top' : 'left'
          , s = r ? 'left' : 'top'
          , d = r ? 'height' : 'width'
          , a = r ? 'width' : 'height';
        return n[p] = t[p] + t[d] / 2 - i[d] / 2,
        n[s] = o === s ? t[s] - i[a] : t[L(s)],
        n
    }
    function T(e, t) {
        return Array.prototype.find ? e.find(t) : e.filter(t)[0]
    }
    function C(e, t, o) {
        if (Array.prototype.findIndex)
            return e.findIndex(function(e) {
                return e[t] === o
            });
        var i = T(e, function(e) {
            return e[t] === o
        });
        return e.indexOf(i)
    }
    function D(t, o, i) {
        var n = void 0 === i ? t : t.slice(0, C(t, 'name', i));
        return n.forEach(function(t) {
            t['function'] && console.warn('`modifier.function` is deprecated, use `modifier.fn`!');
            var i = t['function'] || t.fn;
            t.enabled && e(i) && (o.offsets.popper = h(o.offsets.popper),
            o.offsets.reference = h(o.offsets.reference),
            o = i(o, t))
        }),
        o
    }
    function N() {
        if (!this.state.isDestroyed) {
            var e = {
                instance: this,
                styles: {},
                arrowStyles: {},
                attributes: {},
                flipped: !1,
                offsets: {}
            };
            e.offsets.reference = x(this.state, this.popper, this.reference),
            e.placement = v(this.options.placement, e.offsets.reference, this.popper, this.reference, this.options.modifiers.flip.boundariesElement, this.options.modifiers.flip.padding),
            e.originalPlacement = e.placement,
            e.offsets.popper = S(this.popper, e.offsets.reference, e.placement),
            e.offsets.popper.position = 'absolute',
            e = D(this.modifiers, e),
            this.state.isCreated ? this.options.onUpdate(e) : (this.state.isCreated = !0,
            this.options.onCreate(e))
        }
    }
    function k(e, t) {
        return e.some(function(e) {
            var o = e.name
              , i = e.enabled;
            return i && o === t
        })
    }
    function W(e) {
        for (var t = [!1, 'ms', 'Webkit', 'Moz', 'O'], o = e.charAt(0).toUpperCase() + e.slice(1), n = 0; n < t.length - 1; n++) {
            var i = t[n]
              , r = i ? '' + i + o : e;
            if ('undefined' != typeof window.document.body.style[r])
                return r
        }
        return null
    }
    function P() {
        return this.state.isDestroyed = !0,
        k(this.modifiers, 'applyStyle') && (this.popper.removeAttribute('x-placement'),
        this.popper.style.left = '',
        this.popper.style.position = '',
        this.popper.style.top = '',
        this.popper.style[W('transform')] = ''),
        this.disableEventListeners(),
        this.options.removeOnDestroy && this.popper.parentNode.removeChild(this.popper),
        this
    }
    function B(e) {
        var t = e.ownerDocument;
        return t ? t.defaultView : window
    }
    function H(e, t, o, i) {
        var r = 'BODY' === e.nodeName
          , p = r ? e.ownerDocument.defaultView : e;
        p.addEventListener(t, o, {
            passive: !0
        }),
        r || H(n(p.parentNode), t, o, i),
        i.push(p)
    }
    function A(e, t, o, i) {
        o.updateBound = i,
        B(e).addEventListener('resize', o.updateBound, {
            passive: !0
        });
        var r = n(e);
        return H(r, 'scroll', o.updateBound, o.scrollParents),
        o.scrollElement = r,
        o.eventsEnabled = !0,
        o
    }
    function I() {
        this.state.eventsEnabled || (this.state = A(this.reference, this.options, this.state, this.scheduleUpdate))
    }
    function M(e, t) {
        return B(e).removeEventListener('resize', t.updateBound),
        t.scrollParents.forEach(function(e) {
            e.removeEventListener('scroll', t.updateBound)
        }),
        t.updateBound = null,
        t.scrollParents = [],
        t.scrollElement = null,
        t.eventsEnabled = !1,
        t
    }
    function R() {
        this.state.eventsEnabled && (window.cancelAnimationFrame(this.scheduleUpdate),
        this.state = M(this.reference, this.state))
    }
    function U(e) {
        return '' !== e && !isNaN(parseFloat(e)) && isFinite(e)
    }
    function Y(e, t) {
        Object.keys(t).forEach(function(o) {
            var i = '';
            -1 !== ['width', 'height', 'top', 'right', 'bottom', 'left'].indexOf(o) && U(t[o]) && (i = 'px'),
            e.style[o] = t[o] + i
        })
    }
    function F(e, t) {
        Object.keys(t).forEach(function(o) {
            var i = t[o];
            !1 === i ? e.removeAttribute(o) : e.setAttribute(o, t[o])
        })
    }
    function j(e, t, o) {
        var i = T(e, function(e) {
            var o = e.name;
            return o === t
        })
          , n = !!i && e.some(function(e) {
            return e.name === o && e.enabled && e.order < i.order
        });
        if (!n) {
            var r = '`' + t + '`';
            console.warn('`' + o + '`' + ' modifier is required by ' + r + ' modifier in order to work, be sure to include it before ' + r + '!')
        }
        return n
    }
    function K(e) {
        return 'end' === e ? 'start' : 'start' === e ? 'end' : e
    }
    function q(e) {
        var t = 1 < arguments.length && void 0 !== arguments[1] && arguments[1]
          , o = ae.indexOf(e)
          , i = ae.slice(o + 1).concat(ae.slice(0, o));
        return t ? i.reverse() : i
    }
    function V(e, t, o, i) {
        var n = e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/)
          , r = +n[1]
          , p = n[2];
        if (!r)
            return e;
        if (0 === p.indexOf('%')) {
            var s;
            switch (p) {
            case '%p':
                s = o;
                break;
            case '%':
            case '%r':
            default:
                s = i;
            }
            var d = h(s);
            return d[t] / 100 * r
        }
        if ('vh' === p || 'vw' === p) {
            var a;
            return a = 'vh' === p ? J(document.documentElement.clientHeight, window.innerHeight || 0) : J(document.documentElement.clientWidth, window.innerWidth || 0),
            a / 100 * r
        }
        return r
    }
    function z(e, t, o, i) {
        var n = [0, 0]
          , r = -1 !== ['right', 'left'].indexOf(i)
          , p = e.split(/(\+|\-)/).map(function(e) {
            return e.trim()
        })
          , s = p.indexOf(T(p, function(e) {
            return -1 !== e.search(/,|\s/)
        }));
        p[s] && -1 === p[s].indexOf(',') && console.warn('Offsets separated by white space(s) are deprecated, use a comma (,) instead.');
        var d = /\s*,\s*|\s+/
          , a = -1 === s ? [p] : [p.slice(0, s).concat([p[s].split(d)[0]]), [p[s].split(d)[1]].concat(p.slice(s + 1))];
        return a = a.map(function(e, i) {
            var n = (1 === i ? !r : r) ? 'height' : 'width'
              , p = !1;
            return e.reduce(function(e, t) {
                return '' === e[e.length - 1] && -1 !== ['+', '-'].indexOf(t) ? (e[e.length - 1] = t,
                p = !0,
                e) : p ? (e[e.length - 1] += t,
                p = !1,
                e) : e.concat(t)
            }, []).map(function(e) {
                return V(e, n, t, o)
            })
        }),
        a.forEach(function(e, t) {
            e.forEach(function(o, i) {
                U(o) && (n[t] += o * ('-' === e[i - 1] ? -1 : 1))
            })
        }),
        n
    }
    function G(e, t) {
        var o, i = t.offset, n = e.placement, r = e.offsets, p = r.popper, s = r.reference, d = n.split('-')[0];
        return o = U(+i) ? [+i, 0] : z(i, p, s, d),
        'left' === d ? (p.top += o[0],
        p.left -= o[1]) : 'right' === d ? (p.top += o[0],
        p.left += o[1]) : 'top' === d ? (p.left += o[0],
        p.top -= o[1]) : 'bottom' === d && (p.left += o[0],
        p.top += o[1]),
        e.popper = p,
        e
    }
    for (var _ = Math.min, X = Math.floor, J = Math.max, Q = 'undefined' != typeof window && 'undefined' != typeof window.document, Z = ['Edge', 'Trident', 'Firefox'], $ = 0, ee = 0; ee < Z.length; ee += 1)
        if (Q && 0 <= navigator.userAgent.indexOf(Z[ee])) {
            $ = 1;
            break
        }
    var i, te = Q && window.Promise, oe = te ? function(e) {
        var t = !1;
        return function() {
            t || (t = !0,
            Promise.resolve().then(function() {
                t = !1,
                e()
            }))
        }
    }
    : function(e) {
        var t = !1;
        return function() {
            t || (t = !0,
            setTimeout(function() {
                t = !1,
                e()
            }, $))
        }
    }
    , ie = function() {
        return void 0 == i && (i = -1 !== navigator.appVersion.indexOf('MSIE 10')),
        i
    }, ne = function(e, t) {
        if (!(e instanceof t))
            throw new TypeError('Cannot call a class as a function')
    }, re = function() {
        function e(e, t) {
            for (var o, n = 0; n < t.length; n++)
                o = t[n],
                o.enumerable = o.enumerable || !1,
                o.configurable = !0,
                'value'in o && (o.writable = !0),
                Object.defineProperty(e, o.key, o)
        }
        return function(t, o, i) {
            return o && e(t.prototype, o),
            i && e(t, i),
            t
        }
    }(), pe = function(e, t, o) {
        return t in e ? Object.defineProperty(e, t, {
            value: o,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = o,
        e
    }, se = Object.assign || function(e) {
        for (var t, o = 1; o < arguments.length; o++)
            for (var i in t = arguments[o],
            t)
                Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i]);
        return e
    }
    , de = ['auto-start', 'auto', 'auto-end', 'top-start', 'top', 'top-end', 'right-start', 'right', 'right-end', 'bottom-end', 'bottom', 'bottom-start', 'left-end', 'left', 'left-start'], ae = de.slice(3), le = {
        FLIP: 'flip',
        CLOCKWISE: 'clockwise',
        COUNTERCLOCKWISE: 'counterclockwise'
    }, fe = function() {
        function t(o, i) {
            var n = this
              , r = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : {};
            ne(this, t),
            this.scheduleUpdate = function() {
                return requestAnimationFrame(n.update)
            }
            ,
            this.update = oe(this.update.bind(this)),
            this.options = se({}, t.Defaults, r),
            this.state = {
                isDestroyed: !1,
                isCreated: !1,
                scrollParents: []
            },
            this.reference = o && o.jquery ? o[0] : o,
            this.popper = i && i.jquery ? i[0] : i,
            this.options.modifiers = {},
            Object.keys(se({}, t.Defaults.modifiers, r.modifiers)).forEach(function(e) {
                n.options.modifiers[e] = se({}, t.Defaults.modifiers[e] || {}, r.modifiers ? r.modifiers[e] : {})
            }),
            this.modifiers = Object.keys(this.options.modifiers).map(function(e) {
                return se({
                    name: e
                }, n.options.modifiers[e])
            }).sort(function(e, t) {
                return e.order - t.order
            }),
            this.modifiers.forEach(function(t) {
                t.enabled && e(t.onLoad) && t.onLoad(n.reference, n.popper, n.options, t, n.state)
            }),
            this.update();
            var p = this.options.eventsEnabled;
            p && this.enableEventListeners(),
            this.state.eventsEnabled = p
        }
        return re(t, [{
            key: 'update',
            value: function() {
                return N.call(this)
            }
        }, {
            key: 'destroy',
            value: function() {
                return P.call(this)
            }
        }, {
            key: 'enableEventListeners',
            value: function() {
                return I.call(this)
            }
        }, {
            key: 'disableEventListeners',
            value: function() {
                return R.call(this)
            }
        }]),
        t
    }();
    return fe.Utils = ('undefined' == typeof window ? global : window).PopperUtils,
    fe.placements = de,
    fe.Defaults = {
        placement: 'bottom',
        eventsEnabled: !0,
        removeOnDestroy: !1,
        onCreate: function() {},
        onUpdate: function() {},
        modifiers: {
            shift: {
                order: 100,
                enabled: !0,
                fn: function(e) {
                    var t = e.placement
                      , o = t.split('-')[0]
                      , i = t.split('-')[1];
                    if (i) {
                        var n = e.offsets
                          , r = n.reference
                          , p = n.popper
                          , s = -1 !== ['bottom', 'top'].indexOf(o)
                          , d = s ? 'left' : 'top'
                          , a = s ? 'width' : 'height'
                          , l = {
                            start: pe({}, d, r[d]),
                            end: pe({}, d, r[d] + r[a] - p[a])
                        };
                        e.offsets.popper = se({}, p, l[i])
                    }
                    return e
                }
            },
            offset: {
                order: 200,
                enabled: !0,
                fn: G,
                offset: 0
            },
            preventOverflow: {
                order: 300,
                enabled: !0,
                fn: function(e, t) {
                    var o = t.boundariesElement || r(e.instance.popper);
                    e.instance.reference === o && (o = r(o));
                    var i = w(e.instance.popper, e.instance.reference, t.padding, o);
                    t.boundaries = i;
                    var n = t.priority
                      , p = e.offsets.popper
                      , s = {
                        primary: function(e) {
                            var o = p[e];
                            return p[e] < i[e] && !t.escapeWithReference && (o = J(p[e], i[e])),
                            pe({}, e, o)
                        },
                        secondary: function(e) {
                            var o = 'right' === e ? 'left' : 'top'
                              , n = p[o];
                            return p[e] > i[e] && !t.escapeWithReference && (n = _(p[o], i[e] - ('right' === e ? p.width : p.height))),
                            pe({}, o, n)
                        }
                    };
                    return n.forEach(function(e) {
                        var t = -1 === ['left', 'top'].indexOf(e) ? 'secondary' : 'primary';
                        p = se({}, p, s[t](e))
                    }),
                    e.offsets.popper = p,
                    e
                },
                priority: ['left', 'right', 'top', 'bottom'],
                padding: 5,
                boundariesElement: 'scrollParent'
            },
            keepTogether: {
                order: 400,
                enabled: !0,
                fn: function(e) {
                    var t = e.offsets
                      , o = t.popper
                      , i = t.reference
                      , n = e.placement.split('-')[0]
                      , r = X
                      , p = -1 !== ['top', 'bottom'].indexOf(n)
                      , s = p ? 'right' : 'bottom'
                      , d = p ? 'left' : 'top'
                      , a = p ? 'width' : 'height';
                    return o[s] < r(i[d]) && (e.offsets.popper[d] = r(i[d]) - o[a]),
                    o[d] > r(i[s]) && (e.offsets.popper[d] = r(i[s])),
                    e
                }
            },
            arrow: {
                order: 500,
                enabled: !0,
                fn: function(e, o) {
                    if (!j(e.instance.modifiers, 'arrow', 'keepTogether'))
                        return e;
                    var i = o.element;
                    if ('string' == typeof i) {
                        if (i = e.instance.popper.querySelector(i),
                        !i)
                            return e;
                    } else if (!e.instance.popper.contains(i))
                        return console.warn('WARNING: `arrow.element` must be child of its popper element!'),
                        e;
                    var n = e.placement.split('-')[0]
                      , r = e.offsets
                      , p = r.popper
                      , s = r.reference
                      , d = -1 !== ['left', 'right'].indexOf(n)
                      , a = d ? 'height' : 'width'
                      , l = d ? 'Top' : 'Left'
                      , f = l.toLowerCase()
                      , m = d ? 'left' : 'top'
                      , c = d ? 'bottom' : 'right'
                      , u = O(i)[a];
                    s[c] - u < p[f] && (e.offsets.popper[f] -= p[f] - (s[c] - u)),
                    s[f] + u > p[c] && (e.offsets.popper[f] += s[f] + u - p[c]);
                    var g = s[f] + s[a] / 2 - u / 2
                      , b = t(e.instance.popper, 'margin' + l).replace('px', '')
                      , y = g - h(e.offsets.popper)[f] - b;
                    return y = J(_(p[a] - u, y), 0),
                    e.arrowElement = i,
                    e.offsets.arrow = {},
                    e.offsets.arrow[f] = Math.round(y),
                    e.offsets.arrow[m] = '',
                    e
                },
                element: '[x-arrow]'
            },
            flip: {
                order: 600,
                enabled: !0,
                fn: function(e, t) {
                    if (k(e.instance.modifiers, 'inner'))
                        return e;
                    if (e.flipped && e.placement === e.originalPlacement)
                        return e;
                    var o = w(e.instance.popper, e.instance.reference, t.padding, t.boundariesElement)
                      , i = e.placement.split('-')[0]
                      , n = L(i)
                      , r = e.placement.split('-')[1] || ''
                      , p = [];
                    switch (t.behavior) {
                    case le.FLIP:
                        p = [i, n];
                        break;
                    case le.CLOCKWISE:
                        p = q(i);
                        break;
                    case le.COUNTERCLOCKWISE:
                        p = q(i, !0);
                        break;
                    default:
                        p = t.behavior;
                    }
                    return p.forEach(function(s, d) {
                        if (i !== s || p.length === d + 1)
                            return e;
                        i = e.placement.split('-')[0],
                        n = L(i);
                        var a = e.offsets.popper
                          , l = e.offsets.reference
                          , f = X
                          , m = 'left' === i && f(a.right) > f(l.left) || 'right' === i && f(a.left) < f(l.right) || 'top' === i && f(a.bottom) > f(l.top) || 'bottom' === i && f(a.top) < f(l.bottom)
                          , c = f(a.left) < f(o.left)
                          , h = f(a.right) > f(o.right)
                          , u = f(a.top) < f(o.top)
                          , g = f(a.bottom) > f(o.bottom)
                          , b = 'left' === i && c || 'right' === i && h || 'top' === i && u || 'bottom' === i && g
                          , y = -1 !== ['top', 'bottom'].indexOf(i)
                          , w = !!t.flipVariations && (y && 'start' === r && c || y && 'end' === r && h || !y && 'start' === r && u || !y && 'end' === r && g);
                        (m || b || w) && (e.flipped = !0,
                        (m || b) && (i = p[d + 1]),
                        w && (r = K(r)),
                        e.placement = i + (r ? '-' + r : ''),
                        e.offsets.popper = se({}, e.offsets.popper, S(e.instance.popper, e.offsets.reference, e.placement)),
                        e = D(e.instance.modifiers, e, 'flip'))
                    }),
                    e
                },
                behavior: 'flip',
                padding: 5,
                boundariesElement: 'viewport'
            },
            inner: {
                order: 700,
                enabled: !1,
                fn: function(e) {
                    var t = e.placement
                      , o = t.split('-')[0]
                      , i = e.offsets
                      , n = i.popper
                      , r = i.reference
                      , p = -1 !== ['left', 'right'].indexOf(o)
                      , s = -1 === ['top', 'left'].indexOf(o);
                    return n[p ? 'left' : 'top'] = r[o] - (s ? n[p ? 'width' : 'height'] : 0),
                    e.placement = L(t),
                    e.offsets.popper = h(n),
                    e
                }
            },
            hide: {
                order: 800,
                enabled: !0,
                fn: function(e) {
                    if (!j(e.instance.modifiers, 'hide', 'preventOverflow'))
                        return e;
                    var t = e.offsets.reference
                      , o = T(e.instance.modifiers, function(e) {
                        return 'preventOverflow' === e.name
                    }).boundaries;
                    if (t.bottom < o.top || t.left > o.right || t.top > o.bottom || t.right < o.left) {
                        if (!0 === e.hide)
                            return e;
                        e.hide = !0,
                        e.attributes['x-out-of-boundaries'] = ''
                    } else {
                        if (!1 === e.hide)
                            return e;
                        e.hide = !1,
                        e.attributes['x-out-of-boundaries'] = !1
                    }
                    return e
                }
            },
            computeStyle: {
                order: 850,
                enabled: !0,
                fn: function(e, t) {
                    var o = t.x
                      , i = t.y
                      , n = e.offsets.popper
                      , p = T(e.instance.modifiers, function(e) {
                        return 'applyStyle' === e.name
                    }).gpuAcceleration;
                    void 0 !== p && console.warn('WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!');
                    var s, d, a = void 0 === p ? t.gpuAcceleration : p, l = r(e.instance.popper), f = u(l), m = {
                        position: n.position
                    }, c = {
                        left: X(n.left),
                        top: X(n.top),
                        bottom: X(n.bottom),
                        right: X(n.right)
                    }, h = 'bottom' === o ? 'top' : 'bottom', g = 'right' === i ? 'left' : 'right', b = W('transform');
                    if (d = 'bottom' == h ? -f.height + c.bottom : c.top,
                    s = 'right' == g ? -f.width + c.right : c.left,
                    a && b)
                        m[b] = 'translate3d(' + s + 'px, ' + d + 'px, 0)',
                        m[h] = 0,
                        m[g] = 0,
                        m.willChange = 'transform';
                    else {
                        var y = 'bottom' == h ? -1 : 1
                          , w = 'right' == g ? -1 : 1;
                        m[h] = d * y,
                        m[g] = s * w,
                        m.willChange = h + ', ' + g
                    }
                    var E = {
                        "x-placement": e.placement
                    };
                    return e.attributes = se({}, E, e.attributes),
                    e.styles = se({}, m, e.styles),
                    e.arrowStyles = se({}, e.offsets.arrow, e.arrowStyles),
                    e
                },
                gpuAcceleration: !0,
                x: 'bottom',
                y: 'right'
            },
            applyStyle: {
                order: 900,
                enabled: !0,
                fn: function(e) {
                    return Y(e.instance.popper, e.styles),
                    F(e.instance.popper, e.attributes),
                    e.arrowElement && Object.keys(e.arrowStyles).length && Y(e.arrowElement, e.arrowStyles),
                    e
                },
                onLoad: function(e, t, o, i, n) {
                    var r = x(n, t, e)
                      , p = v(o.placement, r, t, e, o.modifiers.flip.boundariesElement, o.modifiers.flip.padding);
                    return t.setAttribute('x-placement', p),
                    Y(t, {
                        position: 'absolute'
                    }),
                    o
                },
                gpuAcceleration: void 0
            }
        }
    },
    fe
});
//# sourceMappingURL=popper.min.js.map

/* /themes/horoshop_default/layout/js/vendor/likely.js */
!function(t, e) {
    "object" == typeof exports && "object" == typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define([], e) : "object" == typeof exports ? exports.likely = e() : t.likely = e()
}(this, function() {
    return function(t) {
        function e(i) {
            if (n[i])
                return n[i].exports;
            var r = n[i] = {
                i: i,
                l: !1,
                exports: {}
            };
            return t[i].call(r.exports, r, r.exports, e),
            r.l = !0,
            r.exports
        }
        var n = {};
        return e.m = t,
        e.c = n,
        e.i = function(t) {
            return t
        }
        ,
        e.d = function(t, n, i) {
            e.o(t, n) || Object.defineProperty(t, n, {
                configurable: !1,
                enumerable: !0,
                get: i
            })
        }
        ,
        e.n = function(t) {
            var n = t && t.__esModule ? function() {
                return t.default
            }
            : function() {
                return t
            }
            ;
            return e.d(n, "a", n),
            n
        }
        ,
        e.o = function(t, e) {
            return Object.prototype.hasOwnProperty.call(t, e)
        }
        ,
        e.p = "",
        e(e.s = 24)
    }([function(t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {
            value: !0
        }),
        n.d(e, "each", function() {
            return o
        }),
        n.d(e, "toArray", function() {
            return u
        }),
        n.d(e, "merge", function() {
            return c
        }),
        n.d(e, "extend", function() {
            return a
        }),
        n.d(e, "getDataset", function() {
            return s
        }),
        n.d(e, "bools", function() {
            return l
        }),
        n.d(e, "template", function() {
            return p
        }),
        n.d(e, "makeUrl", function() {
            return f
        }),
        n.d(e, "query", function() {
            return d
        }),
        n.d(e, "set", function() {
            return h
        }),
        n.d(e, "getDefaultUrl", function() {
            return v
        }),
        n.d(e, "isBrowserEnv", function() {
            return m
        });
        var i = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
            return typeof t
        }
        : function(t) {
            return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
        }
          , r = {
            yes: !0,
            no: !1
        }
          , o = function(t, e) {
            for (var n in t)
                t.hasOwnProperty(n) && e(t[n], n)
        }
          , u = function(t) {
            return Array.prototype.slice.call(t)
        }
          , c = function() {
            for (var t = {}, e = Array.prototype.slice.call(arguments), n = 0; n < e.length; n++) {
                var i = e[n];
                if (i)
                    for (var r in i)
                        i.hasOwnProperty(r) && (t[r] = i[r])
            }
            return t
        }
          , a = function(t, e) {
            for (var n in e)
                e.hasOwnProperty(n) && (t[n] = e[n]);
            return t
        }
          , s = function(t) {
            if ("object" === i(t.dataset))
                return t.dataset;
            var e = void 0
              , n = {}
              , r = t.attributes
              , o = void 0
              , u = void 0
              , c = function(t) {
                return t.charAt(1).toUpperCase()
            };
            for (e = r.length - 1; e >= 0; e--)
                (o = r[e]) && o.name && /^data-\w[\w\-]*$/.test(o.name) && (u = o.name.substr(5).replace(/-./g, c),
                n[u] = o.value);
            return n
        }
          , l = function(t) {
            var e = {}
              , n = s(t);
            for (var i in n)
                if (n.hasOwnProperty(i)) {
                    var o = n[i];
                    e[i] = r[o] || o
                }
            return e
        }
          , p = function(t, e) {
            return t ? t.replace(/\{([^\}]+)\}/g, function(t, n) {
                return n in e ? e[n] : t
            }) : ""
        }
          , f = function(t, e) {
            for (var n in e)
                e.hasOwnProperty(n) && (e[n] = encodeURIComponent(e[n]));
            return p(t, e)
        }
          , d = function(t) {
            var e = encodeURIComponent
              , n = [];
            for (var r in t)
                "object" !== i(t[r]) && n.push(e(r) + "=" + e(t[r]));
            return n.join("&")
        }
          , h = function(t, e, n) {
            var i = e.split(".")
              , r = null;
            i.forEach(function(e, n) {
                void 0 === t[e] && (t[e] = {}),
                n !== i.length - 1 && (t = t[e]),
                r = e
            }),
            t[r] = n
        }
          , v = function() {
            var t = document.querySelector('link[rel="canonical"]');
            return t ? t.href : window.location.href.replace(window.location.hash, "")
        }
          , m = "undefined" != typeof window && "undefined" != typeof document && document.createElement
    }
    , function(t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {
            value: !0
        }),
        n.d(e, "global", function() {
            return o
        }),
        n.d(e, "wrapSVG", function() {
            return a
        }),
        n.d(e, "createNode", function() {
            return s
        }),
        n.d(e, "getScript", function() {
            return l
        }),
        n.d(e, "getJSON", function() {
            return p
        }),
        n.d(e, "find", function() {
            return f
        }),
        n.d(e, "findAll", function() {
            return d
        }),
        n.d(e, "openPopup", function() {
            return h
        }),
        n.d(e, "createTempLink", function() {
            return v
        });
        var i = n(0)
          , r = {}
          , o = i.isBrowserEnv ? window : r
          , u = i.isBrowserEnv ? document.createElement("div") : {}
          , c = 0;
        o.__likelyCallbacks = {};
        var a = function(t) {
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path d="M' + t + 'z"/></svg>'
        }
          , s = function(t) {
            return u.innerHTML = t,
            u.children[0]
        }
          , l = function(t) {
            var e = document.createElement("script")
              , n = document.head;
            e.type = "text/javascript",
            e.src = t,
            n.appendChild(e),
            n.removeChild(e)
        }
          , p = function(t, e) {
            var n = encodeURIComponent("random_fun_" + ++c)
              , i = t.replace(/callback=(\?)/, "callback=__likelyCallbacks." + n);
            o.__likelyCallbacks[n] = e,
            l(i)
        }
          , f = function(t, e) {
            return (e || document).querySelector(t)
        }
          , d = function(t, e) {
            return Array.prototype.slice.call((e || document).querySelectorAll(t))
        }
          , h = function(t, e, n, i) {
            var r = Math.round(screen.width / 2 - n / 2)
              , o = 0;
            screen.height > i && (o = Math.round(screen.height / 3 - i / 2));
            var u = "left=" + r + ",top=" + o + ",width=" + n + ",height=" + i + ",personalbar=0,toolbar=0,scrollbars=1,resizable=1"
              , c = window.open(t, e, u);
            return c ? (c.focus(),
            c) : (location.href = t,
            null)
        }
          , v = function(t) {
            var e = document.createElement("a");
            e.href = t,
            e.style = "display: none",
            document.body.appendChild(e),
            setTimeout(function() {
                e.click(),
                document.body.removeChild(e)
            })
        }
    }
    , function(t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {
            value: !0
        }),
        e.default = {
            name: "likely",
            prefix: "likely__"
        }
    }
    , function(t, e, n) {
        "use strict";
        var i = n(9)
          , r = n(0)
          , o = n(10)
          , u = n(11)
          , c = n(12)
          , a = n(14)
          , s = n(15)
          , l = n(17)
          , p = n(18)
          , f = n(20)
          , d = n(21)
          , h = n(19)
          , v = n(16)
          , m = n(13)
          , y = {
            facebook: o.a,
            gplus: u.a,
            linkedin: c.a,
            odnoklassniki: a.a,
            pinterest: s.a,
            telegram: l.a,
            twitter: p.a,
            vkontakte: f.a,
            whatsapp: d.a,
            viber: h.a,
            skype: v.a,
            messenger: m.a
        };
        n.i(r.each)(y, function(t, e) {
            n.i(i.a)(t),
            t.name = e
        }),
        e.a = y
    }
    , function(t, e, n) {
        function i(t, e) {
            if (!(t instanceof e))
                throw new TypeError("Cannot call a class as a function")
        }
        var r = function() {
            function t(t, e) {
                for (var n = 0; n < e.length; n++) {
                    var i = e[n];
                    i.enumerable = i.enumerable || !1,
                    i.configurable = !0,
                    "value"in i && (i.writable = !0),
                    Object.defineProperty(t, i.key, i)
                }
            }
            return function(e, n, i) {
                return n && t(e.prototype, n),
                i && t(e, i),
                e
            }
        }()
          , o = n(0)
          , u = o.bools
          , c = o.getDefaultUrl
          , a = o.merge
          , s = n(22).default
          , l = n(2).default
          , p = n(1)
          , f = p.findAll
          , d = n(8).default;
        n(23);
        var h = function(t, e) {
            var n = e || {}
              , i = {
                counters: !0,
                timeout: 1e3,
                zeroes: !1,
                title: document.title,
                wait: 500,
                url: c()
            }
              , r = t[l.name]
              , o = a({}, i, n, u(t));
            return r ? r.update(o) : t[l.name] = new s(t,o),
            r
        }
          , v = function() {
            function t() {
                return i(this, t),
                console.warn("likely function is DEPRECATED and will be removed in 3.0. Use likely.initiate instead."),
                t.initiate.apply(t, arguments)
            }
            return r(t, null, [{
                key: "initate",
                value: function() {
                    return console.warn("likely.initate function is DEPRECATED and will be removed in 3.0. Use likely.initiate instead."),
                    t.initiate.apply(t, arguments)
                }
            }, {
                key: "initiate",
                value: function(t, e) {
                    function n() {
                        i.forEach(function(t) {
                            h(t, r)
                        })
                    }
                    var i = void 0
                      , r = void 0;
                    Array.isArray(t) ? (i = t,
                    r = e) : t instanceof Node ? (i = [t],
                    r = e) : (i = f("." + l.name),
                    r = t),
                    n(),
                    d.onUrlChange(n)
                }
            }]),
            t
        }();
        t.exports = v
    }
    , function(t, e, n) {
        "use strict";
        function i(t, e) {
            if (!(t instanceof e))
                throw new TypeError("Cannot call a class as a function")
        }
        var r = n(1)
          , o = n(0)
          , u = n(2)
          , c = n(7)
          , a = n(3)
          , s = function() {
            function t(t, e) {
                for (var n = 0; n < e.length; n++) {
                    var i = e[n];
                    i.enumerable = i.enumerable || !1,
                    i.configurable = !0,
                    "value"in i && (i.writable = !0),
                    Object.defineProperty(t, i.key, i)
                }
            }
            return function(e, n, i) {
                return n && t(e.prototype, n),
                i && t(e, i),
                e
            }
        }()
          , l = '<span class="{className}">{content}</span>'
          , p = function() {
            function t(e, r, u) {
                i(this, t),
                this.widget = e,
                this.likely = r,
                this.options = n.i(o.merge)(u),
                this.init()
            }
            return s(t, [{
                key: "init",
                value: function() {
                    this.detectService(),
                    this.detectParams(),
                    this.service && (this.initHtml(),
                    setTimeout(this.initCounter.bind(this), 0))
                }
            }, {
                key: "update",
                value: function(t) {
                    var e = "." + u.default.prefix + "counter"
                      , i = n.i(r.findAll)(e, this.widget);
                    n.i(o.extend)(this.options, n.i(o.merge)({
                        forceUpdate: !1
                    }, t)),
                    i.forEach(function(t) {
                        t.parentNode.removeChild(t)
                    }),
                    this.initCounter()
                }
            }, {
                key: "detectService",
                value: function() {
                    var t = this.widget
                      , e = n.i(o.getDataset)(t).service;
                    e || (e = Object.keys(a.a).filter(function(e) {
                        return t.classList.contains(e)
                    })[0]),
                    e && (this.service = e,
                    n.i(o.extend)(this.options, a.a[e]))
                }
            }, {
                key: "detectParams",
                value: function() {
                    var t = this.options
                      , e = n.i(o.getDataset)(this.widget);
                    if (e.counter) {
                        var i = parseInt(e.counter, 10);
                        isNaN(i) ? t.counterUrl = e.counter : t.counterNumber = i
                    }
                    t.title = e.title || t.title,
                    t.url = e.url || t.url
                }
            }, {
                key: "initHtml",
                value: function() {
                    var t = this.options
                      , e = this.widget
                      , i = e.innerHTML;
                    e.addEventListener("click", this.click.bind(this)),
                    e.classList.remove(this.service),
                    e.className += " " + this.className("widget");
                    var u = n.i(o.template)(l, {
                        className: this.className("button"),
                        content: i
                    })
                      , c = n.i(o.template)(l, {
                        className: this.className("icon"),
                        content: n.i(r.wrapSVG)(t.svgIconPath)
                    });
                    e.innerHTML = c + u
                }
            }, {
                key: "initCounter",
                value: function() {
                    var t = this.options;
                    t.counters && t.counterNumber ? this.updateCounter(t.counterNumber) : t.counterUrl && n.i(c.a)(this.service, t.url, t)(this.updateCounter.bind(this))
                }
            }, {
                key: "className",
                value: function(t) {
                    var e = u.default.prefix + t;
                    return e + " " + e + "_" + this.service
                }
            }, {
                key: "updateCounter",
                value: function(t) {
                    var e = parseInt(t, 10) || 0
                      , i = n.i(r.find)("." + u.default.name + "__counter", this.widget);
                    i && i.parentNode.removeChild(i);
                    var c = {
                        className: this.className("counter"),
                        content: e
                    };
                    e || this.options.zeroes || (c.className += " " + u.default.prefix + "counter_empty",
                    c.content = ""),
                    this.widget.appendChild(n.i(r.createNode)(n.i(o.template)(l, c))),
                    this.likely.updateCounter(this.service, e)
                }
            }, {
                key: "click",
                value: function() {
                    var t = this.options;
                    if (t.click.call(this)) {
                        var e = n.i(o.makeUrl)(t.popupUrl, {
                            url: t.url,
                            title: t.title
                        });
                        if (!1 === t.openPopup)
                            return n.i(r.createTempLink)(this.addAdditionalParamsToUrl(e)),
                            !1;
                        n.i(r.openPopup)(this.addAdditionalParamsToUrl(e), u.default.prefix + this.service, t.popupWidth, t.popupHeight)
                    }
                    return !1
                }
            }, {
                key: "addAdditionalParamsToUrl",
                value: function(t) {
                    var e = n.i(o.query)(n.i(o.merge)(this.widget.dataset, this.options.data))
                      , i = -1 === t.indexOf("?") ? "?" : "&";
                    return "" === e ? t : t + i + e
                }
            }]),
            t
        }();
        e.a = p
    }
    , function(t, e, n) {
        "use strict";
        var i = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
            return typeof t
        }
        : function(t) {
            return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
        }
        ;
        e.a = function(t) {
            var e = [];
            return function(n) {
                var r = void 0 === n ? "undefined" : i(n);
                if ("undefined" === r)
                    return t;
                "function" === r ? e.push(n) : (t = n,
                e.forEach(function(t) {
                    t(n)
                }))
            }
        }
    }
    , function(t, e, n) {
        "use strict";
        var i = n(6)
          , r = n(0)
          , o = n(3)
          , u = {};
        e.a = function(t, e, c) {
            u[t] || (u[t] = {});
            var a = u[t]
              , s = a[e];
            if (!c.forceUpdate && s)
                return s;
            s = n.i(i.a)();
            var l = n.i(r.makeUrl)(c.counterUrl, {
                url: e
            });
            return o.a[t].counter(l, s, e),
            a[e] = s,
            s
        }
    }
    , function(t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = []
          , r = function() {
            i.forEach(function(t) {
                t()
            })
        }
          , o = function() {
            var t = window.history.pushState;
            window.history.pushState = function() {
                return setTimeout(r, 0),
                t.apply(window.history, arguments)
            }
            ;
            var e = window.history.replaceState;
            window.history.replaceState = function() {
                return setTimeout(r, 0),
                e.apply(window.history, arguments)
            }
            ,
            window.addEventListener("popstate", r)
        }
          , u = !1
          , c = {
            onUrlChange: function(t) {
                u || (o(),
                u = !0),
                i.push(t)
            }
        };
        e.default = c
    }
    , function(t, e, n) {
        "use strict";
        var i = n(1)
          , r = function(t, e) {
            var r = this;
            n.i(i.getJSON)(t, function(t) {
                try {
                    var n = "function" == typeof r.convertNumber ? r.convertNumber(t) : t;
                    e(n)
                } catch (t) {}
            })
        };
        e.a = function(t) {
            t.counter = i.global.__likelyCounterMock || t.counter || r,
            t.click = t.click || function() {
                return !0
            }
        }
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            counterUrl: "https://graph.facebook.com/?id={url}&callback=?",
            convertNumber: function(t) {
                return t.share.share_count
            },
            popupUrl: "https://www.facebook.com/sharer/sharer.php?u={url}",
            popupWidth: 600,
            popupHeight: 500,
            svgIconPath: "15.117 0H.883C.395 0 0 .395 0 .883v14.234c0 .488.395.883.883.883h7.663V9.804H6.46V7.39h2.086V5.607c0-2.066 1.262-3.19 3.106-3.19.883 0 1.642.064 1.863.094v2.16h-1.28c-1 0-1.195.48-1.195 1.18v1.54h2.39l-.31 2.42h-2.08V16h4.077c.488 0 .883-.395.883-.883V.883C16 .395 15.605 0 15.117 0"
        }
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            counterUrl: "https://clients6.google.com/rpc",
            counter: function(t, e, n) {
                var i = new XMLHttpRequest;
                i.open("POST", t),
                i.setRequestHeader("Content-Type", "application/json"),
                i.addEventListener("load", function() {
                    var t = JSON.parse(i.responseText)[0].result.metadata.globalCounts.count;
                    e(t)
                }),
                i.send(JSON.stringify([{
                    method: "pos.plusones.get",
                    id: "p",
                    params: {
                        nolog: !0,
                        id: n,
                        source: "widget",
                        userId: "@viewer",
                        groupId: "@self"
                    },
                    jsonrpc: "2.0",
                    key: "p",
                    apiVersion: "v1"
                }]))
            },
            popupUrl: "https://plus.google.com/share?url={url}",
            popupWidth: 700,
            popupHeight: 500,
            svgIconPath: "8,6.5v3h4.291c-0.526,2.01-2.093,3.476-4.315,3.476C5.228,12.976,3,10.748,3,8c0-2.748,2.228-4.976,4.976-4.976c1.442,0,2.606,0.623,3.397,1.603L13.52,2.48C12.192,0.955,10.276,0,8,0C3.582,0,0,3.582,0,8s3.582,8,8,8s7.5-3.582,7.5-8V6.5H8"
        }
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            counterUrl: "https://www.linkedin.com/countserv/count/share?url={url}&format=jsonp&callback=?",
            convertNumber: function(t) {
                return t.count
            },
            popupUrl: "https://www.linkedin.com/shareArticle?mini=true&url={url}&title={title}",
            popupWidth: 600,
            popupHeight: 500,
            svgIconPath: "2.4,6h2.4v7.6H2.4V6z M3.6,2.2c0.8,0,1.4,0.6,1.4,1.4C4.9,4.3,4.3,5,3.6,5C2.8,5,2.2,4.3,2.2,3.6C2.2,2.8,2.8,2.2,3.6,2.2C3.6,2.2,3.6,2.2,3.6,2.2 M6.2,6h2.3v1h0C9,6.2,9.9,5.8,10.8,5.8c2.4,0,2.8,1.6,2.8,3.6v4.2h-2.4V9.9c0-0.9,0-2-1.2-2c-1.2,0-1.4,1-1.4,2v3.8H6.2V6z M13,0H3C1,0,0,1,0,3v10c0,2,1,3,3,3h10c2,0,3-1,3-3V3C16,1,15,0,13,0z"
        }
    }
    , function(t, e, n) {
        "use strict";
        var i = n(1);
        e.a = {
            popupUrl: "",
            openPopup: !1,
            click: function() {
                return void 0 !== i.global.FB && i.global.FB.ui({
                    method: "send",
                    link: this.options.url
                }),
                !1
            },
            svgIconPath: "8.8 10l-2-2.2-4 2.2 4.4-4.6 2.1 2.2 3.9-2.2L8.8 10zM8 0C3.6 0 0 3.3 0 7.4c0 2.3 1.2 4.4 3 5.8V16l2.7-1.5c.7.2 1.5.3 2.3.3 4.4 0 8-3.3 8-7.4S12.4 0 8 0z"
        }
    }
    , function(t, e, n) {
        "use strict";
        var i = n(1)
          , r = n(0)
          , o = {
            counterUrl: "https://connect.ok.ru/dk?st.cmd=extLike&ref={url}&uid={index}",
            counter: function(t, e) {
                this.promises.push(e),
                n.i(i.getScript)(n.i(r.makeUrl)(t, {
                    index: this.promises.length - 1
                }))
            },
            promises: [],
            popupUrl: "https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&service=odnoklassniki&st.shareUrl={url}",
            popupWidth: 640,
            popupHeight: 400,
            svgIconPath: "8 6.107c.888 0 1.607-.72 1.607-1.607 0-.888-.72-1.607-1.607-1.607s-1.607.72-1.607 1.607c0 .888.72 1.607 1.607 1.607zM13 0H3C1 0 0 1 0 3v10c0 2 1 3 3 3h10c2 0 3-1 3-3V3c0-2-1-3-3-3zM8 .75c2.07 0 3.75 1.68 3.75 3.75 0 2.07-1.68 3.75-3.75 3.75S4.25 6.57 4.25 4.5C4.25 2.43 5.93.75 8 .75zm3.826 12.634c.42.42.42 1.097 0 1.515-.21.208-.483.313-.758.313-.274 0-.548-.105-.758-.314L8 12.59 5.69 14.9c-.42.418-1.098.418-1.516 0s-.42-1.098 0-1.516L6.357 11.2c-1.303-.386-2.288-1.073-2.337-1.11-.473-.354-.57-1.025-.214-1.5.354-.47 1.022-.567 1.496-.216.03.022 1.4.946 2.698.946 1.31 0 2.682-.934 2.693-.943.474-.355 1.146-.258 1.5.213.355.474.26 1.146-.214 1.5-.05.036-1.035.723-2.338 1.11l2.184 2.184"
        };
        n.i(r.set)(i.global, "ODKL.updateCount", function(t, e) {
            o.promises[t](e)
        }),
        e.a = o
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            counterUrl: "https://api.pinterest.com/v1/urls/count.json?url={url}&callback=?",
            convertNumber: function(t) {
                return t.count
            },
            popupUrl: "https://pinterest.com/pin/create/button/?url={url}&description={title}",
            popupWidth: 630,
            popupHeight: 270,
            svgIconPath: "7.99 0c-4.417 0-8 3.582-8 8 0 3.39 2.11 6.284 5.086 7.45-.07-.633-.133-1.604.028-2.295.145-.624.938-3.977.938-3.977s-.24-.48-.24-1.188c0-1.112.645-1.943 1.448-1.943.683 0 1.012.512 1.012 1.127 0 .686-.437 1.713-.663 2.664-.19.796.398 1.446 1.184 1.446 1.422 0 2.515-1.5 2.515-3.664 0-1.915-1.377-3.255-3.343-3.255-2.276 0-3.612 1.707-3.612 3.472 0 .688.265 1.425.595 1.826.065.08.075.15.055.23-.06.252-.195.796-.222.907-.035.146-.116.177-.268.107-1-.465-1.624-1.926-1.624-3.1 0-2.523 1.835-4.84 5.287-4.84 2.775 0 4.932 1.977 4.932 4.62 0 2.757-1.74 4.976-4.152 4.976-.81 0-1.573-.42-1.834-.92l-.498 1.903c-.18.695-.668 1.566-.994 2.097.75.232 1.544.357 2.37.357 4.417 0 8-3.582 8-8s-3.583-8-8-8"
        }
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            popupUrl: "",
            click: function() {
                return !1
            },
            openPopup: !1,
            svgIconPath: "15.2 9.1c.1-.4.1-.8.1-1.1C15.3 3.9 12 .6 7.9.6c-.4 0-.7 0-1.1.1C6.1.2 5.4 0 4.5 0 2 0 0 2 0 4.5c0 .8.2 1.5.6 2.2-.1.4-.1.8-.1 1.2 0 4.1 3.3 7.4 7.4 7.4.3 0 .6 0 .9-.1.7.5 1.6.8 2.5.8 2.5 0 4.5-2 4.5-4.5.1-.9-.2-1.8-.6-2.4zm-4.9 2.2c-.6.5-1.4.7-2.5.7s-1.9-.2-2.6-.7c-.5-.3-.8-.8-.8-1.3 0-.2.1-.4.2-.6.2-.1.4-.1.6-.1.3 0 .5.1.7.4.3.4.5.6.6.7.3.3.7.4 1.3.4.5 0 .8-.1 1.1-.3.3-.2.4-.4.4-.7 0-.4-.3-.7-.8-.8l-2.1-.7c-1.3-.3-2-1.1-2-2.2 0-.8.3-1.5 1-1.9.6-.4 1.4-.6 2.3-.6.8 0 1.5.2 2.1.5.7.4 1 .8 1 1.3 0 .2-.1.4-.2.5-.2.1-.4.2-.6.2-.2 0-.4-.1-.6-.3-.4-.2-.6-.4-.7-.5C8.4 5.1 8 5 7.5 5c-.4 0-.7.1-1 .3-.2.2-.3.4-.3.7 0 .4.4.7 1.3.9l1.5.3c1.4.3 2.1 1.1 2.1 2.3 0 .8-.3 1.4-.8 1.8z"
        }
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            popupUrl: "https://telegram.me/share/url?url={url}",
            popupWidth: 600,
            popupHeight: 500,
            svgIconPath: "6,11.960784l-1,-3l11,-8l-15.378,5.914c0,0 -0.672,0.23 -0.619,0.655c0.053,0.425 0.602,0.619 0.602,0.619l3.575,1.203l1.62,5.154l2.742,-2.411l-0.007,-0.005l3.607,2.766c0.973,0.425 1.327,-0.46 1.327,-0.46l2.531,-13.435l-10,11z"
        }
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            popupUrl: "https://twitter.com/intent/tweet?url={url}&text={title}",
            popupWidth: 600,
            popupHeight: 450,
            click: function() {
                return /[\.\?:\-–—]\s*$/.test(this.options.title) || (this.options.title += ":"),
                !0
            },
            svgIconPath: "15.969,3.058c-0.586,0.26-1.217,0.436-1.878,0.515c0.675-0.405,1.194-1.045,1.438-1.809c-0.632,0.375-1.332,0.647-2.076,0.793c-0.596-0.636-1.446-1.033-2.387-1.033c-1.806,0-3.27,1.464-3.27,3.27 c0,0.256,0.029,0.506,0.085,0.745C5.163,5.404,2.753,4.102,1.14,2.124C0.859,2.607,0.698,3.168,0.698,3.767 c0,1.134,0.577,2.135,1.455,2.722C1.616,6.472,1.112,6.325,0.671,6.08c0,0.014,0,0.027,0,0.041c0,1.584,1.127,2.906,2.623,3.206 C3.02,9.402,2.731,9.442,2.433,9.442c-0.211,0-0.416-0.021-0.615-0.059c0.416,1.299,1.624,2.245,3.055,2.271 c-1.119,0.877-2.529,1.4-4.061,1.4c-0.264,0-0.524-0.015-0.78-0.046c1.447,0.928,3.166,1.469,5.013,1.469 c6.015,0,9.304-4.983,9.304-9.304c0-0.142-0.003-0.283-0.009-0.423C14.976,4.29,15.531,3.714,15.969,3.058"
        }
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            popupUrl: 'https://3p3x.adj.st/?adjust_t=u783g1_kw9yml&adjust_fallback=https%3A%2F%2Fwww.viber.com%2F%3Futm_source%3DPartner%26utm_medium%3DSharebutton%26utm_campaign%3DDefualt&adjust_campaign=Sharebutton&adjust_deeplink=" + encodeURIComponent("viber://forward?text=" + encodeURIComponent({text} + " " + window.location.href)))',
            openPopup: !1,
            svgIconPath: "8 0C4.1 0 0 .5 0 6.9c0 3.4 1.2 5.5 3.6 6.3v1.6c0 .6.5 1.1 1.1 1.1.3 0 .6-.1.8-.4l1.6-1.8H8c3.9 0 8-.5 8-6.9S11.9 0 8 0zm0 5.1c.8 0 1.5.7 1.5 1.5 0 .2-.2.4-.4.4s-.4-.3-.4-.5c0-.4-.3-.7-.7-.7-.2 0-.4-.2-.4-.4s.2-.3.4-.3zM7.6 4c0-.2.2-.4.4-.4 1.6 0 2.9 1.3 2.9 2.9 0 .2-.2.4-.4.4s-.4-.2-.4-.4c0-1.2-1-2.2-2.2-2.2-.1.1-.3-.1-.3-.3zm4 5.8c-.2 1.1-1.1 1.8-2.2 1.8s-3.3-1.4-4.3-2.3c-.8-.9-2.2-3.1-2.2-4.2s.8-2 1.8-2.2h.7c.1 0 .3.1.3.2 0 0 .4.9.7 1.5s-.2 1.3-.5 1.7c.2.5.5 1 .9 1.5.4.4.9.7 1.5.9.3-.4.8-.7 1.3-.8.1 0 .3.1.4.1l1.5.7c.1.1.2.2.2.3l-.1.8zm.4-2.9c-.2 0-.4-.2-.4-.4 0-2-1.6-3.6-3.6-3.6-.2 0-.4-.2-.4-.4s.2-.3.4-.3c2.4 0 4.4 2 4.4 4.4 0 .1-.2.3-.4.3z"
        }
    }
    , function(t, e, n) {
        "use strict";
        var i = n(1)
          , r = n(0)
          , o = {
            counterUrl: "https://vk.com/share.php?act=count&url={url}&index={index}",
            counter: function(t, e) {
                this.promises.push(e),
                n.i(i.getScript)(n.i(r.makeUrl)(t, {
                    index: this.promises.length - 1
                }))
            },
            promises: [],
            popupUrl: "https://vk.com/share.php?url={url}&title={title}",
            popupWidth: 550,
            popupHeight: 330,
            svgIconPath: "7.828 12.526h.957s.288-.032.436-.19c.14-.147.14-.42.14-.42s-.02-1.284.58-1.473c.59-.187 1.34 1.24 2.14 1.788.61.42 1.07.33 1.07.33l2.14-.03s1.12-.07.59-.95c-.04-.07-.3-.65-1.58-1.84-1.34-1.24-1.16-1.04.45-3.19.98-1.31 1.38-2.11 1.25-2.45-.11-.32-.84-.24-.84-.24l-2.4.02s-.18-.02-.31.06-.21.26-.21.26-.38 1.02-.89 1.88C10.27 7.9 9.84 8 9.67 7.88c-.403-.26-.3-1.053-.3-1.62 0-1.76.27-2.5-.52-2.69-.26-.06-.454-.1-1.123-.11-.86-.01-1.585.006-1.996.207-.27.135-.48.434-.36.45.16.02.52.098.71.358.25.337.24 1.09.24 1.09s.14 2.077-.33 2.335c-.33.174-.77-.187-1.73-1.837-.49-.84-.86-1.78-.86-1.78s-.07-.17-.2-.27c-.15-.11-.37-.15-.37-.15l-2.29.02s-.34.01-.46.16c-.11.13-.01.41-.01.41s1.79 4.19 3.82 6.3c1.86 1.935 3.97 1.81 3.97 1.81"
        };
        n.i(r.set)(i.global, "VK.Share.count", function(t, e) {
            o.promises[t](e)
        }),
        e.a = o
    }
    , function(t, e, n) {
        "use strict";
        e.a = {
            popupUrl: "whatsapp://send?text={title}%0D%0A%0D%0A{url}",
            openPopup: !1,
            svgIconPath: "8.0292969 0 C 3.6412969 0 0.06940625 3.5557344 0.06640625 7.9277344 C 0.06640625 9.3247344 0.43385936 10.688578 1.1308594 11.892578 L 0 16 L 4.2226562 14.898438 C 5.3866562 15.528438 6.6962969 15.862281 8.0292969 15.863281 L 8.0332031 15.863281 C 12.423199 15.863281 15.998 12.306594 16 7.9335938 C 16 5.8165938 15.172922 3.8222186 13.669922 2.3242188 L 13.679688 2.3007812 C 12.159653 0.8307817 10.159297 -2.9605947e-016 8.0292969 0 z M 4.4589844 3.2382812 C 4.6263665 3.2382813 4.7936277 3.2373139 4.9394531 3.25 C 5.095423 3.25 5.306878 3.189055 5.5097656 3.6835938 C 5.7202615 4.1781321 6.2237071 5.418117 6.2871094 5.5449219 C 6.3505124 5.6717267 6.3922846 5.8107546 6.3085938 5.9882812 C 6.2223663 6.1531272 6.1809093 6.2560375 6.0566406 6.4082031 C 5.9298358 6.560369 5.7918587 6.7393913 5.6777344 6.8535156 C 5.5509298 6.9803204 5.4193132 7.1174841 5.5664062 7.3710938 C 5.7147679 7.6247032 6.220019 8.4490288 6.9707031 9.1210938 C 7.9344191 9.9833661 8.7483437 10.250149 9.0019531 10.376953 C 9.2530266 10.491078 9.3997816 10.477349 9.546875 10.3125 C 9.6939686 10.145117 10.178322 9.5818366 10.345703 9.3320312 C 10.514354 9.0784218 10.683278 9.1181658 10.914062 9.203125 C 11.146116 9.286816 12.383111 9.8946797 12.636719 10.021484 L 12.646484 9.9589844 C 12.900093 10.073108 13.06355 10.137829 13.126953 10.251953 C 13.190353 10.366078 13.192128 10.859096 12.976562 11.455078 C 12.766067 12.05106 11.759099 12.584074 11.273438 12.660156 C 10.838496 12.723556 10.287183 12.74881 9.6835938 12.558594 C 9.3158512 12.431788 8.8457781 12.280954 8.2421875 12.027344 C 5.7111649 10.936823 4.0584453 8.3992212 3.9316406 8.234375 C 3.8061039 8.0568483 2.9023438 6.8647716 2.9023438 5.6347656 C 2.9023438 4.4047596 3.5524185 3.7946251 3.7832031 3.5410156 C 4.0139878 3.3000865 4.2890659 3.2382812 4.4589844 3.2382812"
        }
    }
    , function(t, e, n) {
        "use strict";
        function i(t, e) {
            if (!(t instanceof e))
                throw new TypeError("Cannot call a class as a function")
        }
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(5)
          , o = n(2)
          , u = n(0)
          , c = function() {
            function t(t, e) {
                for (var n = 0; n < e.length; n++) {
                    var i = e[n];
                    i.enumerable = i.enumerable || !1,
                    i.configurable = !0,
                    "value"in i && (i.writable = !0),
                    Object.defineProperty(t, i.key, i)
                }
            }
            return function(e, n, i) {
                return n && t(e.prototype, n),
                i && t(e, i),
                e
            }
        }()
          , a = function() {
            function t(e, n) {
                i(this, t),
                this.container = e,
                this.options = n,
                this.countersLeft = 0,
                this.buttons = [],
                this.number = 0,
                this.init()
            }
            return c(t, [{
                key: "init",
                value: function() {
                    n.i(u.toArray)(this.container.children).forEach(this.addButton.bind(this)),
                    this.options.counters ? (this.timer = setTimeout(this.appear.bind(this), this.options.wait),
                    this.timeout = setTimeout(this.ready.bind(this), this.options.timeout)) : this.appear()
                }
            }, {
                key: "addButton",
                value: function(t) {
                    var e = new r.a(t,this,this.options);
                    this.buttons.push(e),
                    e.options.counterUrl && this.countersLeft++
                }
            }, {
                key: "update",
                value: function(t) {
                    (t.forceUpdate || t.url && t.url !== this.options.url) && (this.countersLeft = this.buttons.length,
                    this.number = 0,
                    this.buttons.forEach(function(e) {
                        e.update(t)
                    }))
                }
            }, {
                key: "updateCounter",
                value: function(t, e) {
                    e && (this.number += e),
                    0 === --this.countersLeft && (this.appear(),
                    this.ready())
                }
            }, {
                key: "appear",
                value: function() {
                    this.container.classList.add(o.default.name + "_visible")
                }
            }, {
                key: "ready",
                value: function() {
                    this.timeout && (clearTimeout(this.timeout),
                    this.container.classList.add(o.default.name + "_ready"))
                }
            }]),
            t
        }();
        e.default = a
    }
    , function(t, e) {}
    , function(t, e, n) {
        var i = n(4);
        window.addEventListener("load", function() {
            i.initiate()
        }),
        t.exports = i
    }
    ])
});
/* /vendor/helpers/GAHelper.js */
(function(w) {
    var GAHelper = function(settings) {
        this.setSettings(settings);
        this.init()
    };
    GAHelper.prototype = {
        originalSendHitTask: null,
        payloadRefLimit: 2048,
        preparedToSendProducts: [],
        remainingProducts: [],
        offset: 0,
        isValidOffset: !1,
        partsWasSent: 0,
        errors: [],
        setSettings: function(settings) {
            this.products = settings.products ? settings.products : this.addError('products');
            this.hit = settings.hit ? settings.hit : this.addError('hit');
            this.eventCategory = settings.eventCategory ? settings.eventCategory : this.addError('eventCategory');
            this.eventAction = settings.eventAction ? settings.eventAction : this.addError('eventAction');
            this.fieldSetter = settings.fieldSetter ? settings.fieldSetter : this.addError('fieldSetter')
        },
        init: function() {
            if (this.errors.length) {
                this.showErrors();
                return !1
            }
            this.remainingProducts = this.products;
            this.attachEvents();
            this.performDefaultEvent()
        },
        addError: function(errorName) {
            this.errors.push(errorName);
            return null
        },
        showErrors: function() {
            this.errors.forEach(function(errorName) {
                console.log('В конструктор не передано обязательное свойство ' + errorName)
            })
        },
        performDefaultEvent: function() {
            this.fieldSetter(this.hit, this.products)
        },
        attachEvents: function() {
            var self = this;
            ga(function(tracker) {
                self.originalSendHitTask = tracker.get('sendHitTask');
                tracker.set('sendHitTask', function(model) {
                    if (self.isValidPayloadSize(model.get('hitPayload'))) {
                        self.originalSendHitTask(model);
                        tracker.set('sendHitTask', self.originalSendHitTask);
                        self.isDefaultEventSentOut = self.isDefaultEventSentOut === !1
                    } else {
                        setTimeout(function() {
                            self.initSender()
                        }, 100)
                    }
                })
            })
        },
        isValidPayloadSize: function(hitPayload) {
            return this.payloadRefLimit > encodeURI(hitPayload).split(/%..|./).length - 1
        },
        initSender: function() {
            this.attachSenderEvents();
            this.runSender()
        },
        attachSenderEvents: function() {
            var self = this;
            ga(function(tracker) {
                tracker.set('sendHitTask', function(model) {
                    if (self.isValidPayloadSize(model.get('hitPayload'))) {
                        self.originalSendHitTask(model);
                        self.preparedToSendProducts = [];
                        self.remainingProducts = self.remainingProducts.slice(self.offset);
                        self.isValidOffset = !0;
                        ++self.partsWasSent
                    } else {
                        self.isValidOffset = !1
                    }
                    if (!self.isValidOffset && self.offset === 1) {
                        self.setDefaultSendHitTask();
                        self.send()
                    } else {
                        setTimeout(function() {
                            self.runSender()
                        }, 100)
                    }
                })
            })
        },
        runSender: function() {
            this.updateProducts();
            if (this.preparedToSendProducts.length || this.remainingProducts.length) {
                this.performEvent(this.hit, this.preparedToSendProducts);
                this.send()
            } else {
                this.setDefaultSendHitTask()
            }
        },
        updateProducts: function() {
            var tmpProducts = this.preparedToSendProducts.length ? this.preparedToSendProducts : this.remainingProducts;
            this.offset = this.isValidOffset ? this.offset : Math.ceil(tmpProducts.length / 2);
            this.preparedToSendProducts = tmpProducts.slice(0, this.offset)
        },
        performEvent: function(eventName, products) {
            this.fieldSetter(eventName, products)
        },
        send: function() {
            if (this.isFirstPart()) {
                ga('send', 'pageview')
            } else {
                ga('ec:setAction', this.eventAction);
                ga('send', 'event', this.eventCategory, this.eventAction)
            }
        },
        isFirstPart: function() {
            return this.partsWasSent === 0
        },
        setDefaultSendHitTask: function() {
            var self = this;
            ga(function(tracker) {
                tracker.set('sendHitTask', self.originalSendHitTask)
            })
        }
    };
    w.GAHelper = GAHelper
}
)(window);
/* /vendor/helpers/FakeHrefDirector.js */
(function(window) {
    var FakeHrefDirector = {
        DATA_ATTR_NAME: 'data-fake-href',
        FAKE_LINK_LIFE_TIME: 25000,
        links: [],
        init: function() {
            this.setLinks();
            this.setListeners();
            setTimeout(this.modifyAllLinks.bind(this), this.FAKE_LINK_LIFE_TIME)
        },
        setLinks: function() {
            this.links = document.querySelectorAll('[' + this.DATA_ATTR_NAME + ']')
        },
        setListeners: function() {
            for (var i = 0, l = this.links.length; i < l; ++i) {
                this.links[i].addEventListener('mouseover', this.onHover())
            }
        },
        onHover: function() {
            var self = this;
            return function(event) {
                self.modifyFakeToVeritableLink.call(self, this)
            }
        },
        modifyFakeToVeritableLink: function(link) {
            var href = link.getAttribute(this.DATA_ATTR_NAME);
            if (href) {
                link.setAttribute('href', href);
                link.removeAttribute(this.DATA_ATTR_NAME)
            }
        },
        modifyAllLinks: function() {
            for (var i = 0, l = this.links.length; i < l; ++i) {
                this.modifyFakeToVeritableLink(this.links[i])
            }
        },
    };
    window.FakeHrefDirector = FakeHrefDirector
}
)(window);
/* /themes/horoshop_default/layout/js/frontend/filterToggle.js */
(function($, window, document, undefined) {
    var pluginName = 'FilterToggle';
    function FilterToggle(element, options) {
        this._name = pluginName;
        this._defaults = $.fn.FilterToggle.defaults;
        this.element = element;
        this.isOpen = !1;
        this.timer = 0;
        this.options = $.extend({}, this._defaults, options);
        this.init()
    }
    $.extend(FilterToggle.prototype, {
        init: function() {
            var self = this;
            this.buildCache();
            this.bindEvents()
        },
        destroy: function() {
            this.unbindEvents();
            this.$element.remove();
            this.$dropdown.remove()
        },
        buildCache: function() {
            this.$element = $(this.element);
            this.$btn = $(this.element).find('.selectboxit-btn');
            this.$dropdown = this.$element.find('.filter-float')
        },
        bindEvents: function() {
            var self = this;
            this.$btn.on('click' + '.' + self._name, function() {
                self.toggle()
            });
            this.$dropdown.on('mouseleave', function() {
                if (self.isOpen) {
                    clearTimeout(self.timer);
                    self.timer = setTimeout(function() {
                        self.close()
                    }, 1000)
                }
            }).on('mouseenter', function() {
                clearTimeout(self.timer)
            });
            $('html').on('click' + '.' + self._name, function() {
                self.close()
            });
            this.$dropdown.add(self.$element).on('click' + '.' + self._name, function(e) {
                e.stopPropagation()
            })
        },
        unbindEvents: function() {
            this.$element.off('.' + this._name)
        },
        toggle: function() {
            this.isOpen ? this.close() : this.open()
        },
        open: function() {
            var self = this;
            clearTimeout(this.timer);
            this.$element.addClass(this.options.hoverClass);
            this.$element.addClass(this.options.activeClass);
            this.$dropdown.addClass(this.options.visibleClass);
            this.$dropdown.appendTo(this.options.parentNode).css({
                'position': 'absolute',
                'display': 'block',
                'width': this.$element.width(),
                'top': this.$element.offset().top + this.$element.outerHeight(),
                'left': this.$element.offset().left
            });
            self.isOpen = !0;
            this.callback()
        },
        close: function() {
            var self = this;
            this.$element.removeClass(this.options.hoverClass);
            this.$element.removeClass(this.options.activeClass);
            this.$dropdown.removeClass(this.options.visibleClass);
            self.$dropdown.detach();
            self.isOpen = !1;
            clearTimeout(this.timer)
        },
        callback: function() {
            var onComplete = this.options.onComplete;
            if (typeof onComplete === 'function') {
                onComplete.call(this.element)
            }
        }
    });
    $.fn.FilterToggle = function(options) {
        this.each(function() {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new FilterToggle(this,options))
            }
        });
        return this
    }
    ;
    $.fn.FilterToggle.defaults = {
        parentNode: $('body'),
        visibleClass: '__visible',
        activeClass: '__active',
        hoverClass: '__hover',
        speed: 10,
        onComplete: null
    }
}
)(jQuery, window, document);
/* /themes/horoshop_default/layout/js/frontend/flowType.js */
(function($) {
    $.fn.flowtype = function(options) {
        var settings = $.extend({
            parent: !1,
            maximum: 9999,
            minimum: 1,
            maxFont: 9999,
            minFont: 1,
            fontRatio: 35
        }, options)
          , changes = function(el) {
            var $el = $(el)
              , elw = settings.parent ? settings.parent.width() : $el.width()
              , width = elw > settings.maximum ? settings.maximum : elw < settings.minimum ? settings.minimum : elw
              , fontBase = width / settings.fontRatio
              , fontSize = fontBase > settings.maxFont ? settings.maxFont : fontBase < settings.minFont ? settings.minFont : fontBase;
            $el.css('font-size', fontSize + 'px')
        };
        return this.each(function() {
            var that = this;
            $(window).resize(function() {
                changes(that)
            });
            changes(this)
        })
    }
}(jQuery));
$('.bannerMagic-txt').each(function() {
    var fz = Math.round(parseFloat($(this).css('font-size')));
    var minFont = 18
      , maxFont = 44
      , fontRatio = 10;
    if (fz > 44) {
        minFont = fz - 10;
        maxFont = fz + 10;
        fontRatio = 12
    } else if (fz > 36 && fz <= 44) {
        minFont = fz - 8;
        maxFont = fz + 8;
        fontRatio = 15
    } else if (fz > 28 && fz <= 36) {
        minFont = fz - 5;
        maxFont = fz + 5;
        fontRatio = 18
    } else if (fz > 18 && fz <= 28) {
        minFont = fz - 4;
        maxFont = fz + 4;
        fontRatio = 20
    } else if (fz <= 18) {
        minFont = fz - 3;
        maxFont = fz + 3;
        fontRatio = 22
    }
    $(this).flowtype({
        parent: $(this).parents('.bannerMagic-column'),
        minFont: minFont,
        maxFont: maxFont,
        fontRatio: fontRatio
    })
});
/* /themes/horoshop_default/layout/js/frontend/jquery.path.js */
(function($) {
    $.path = {};
    var V = {
        rotate: function(p, degrees) {
            var radians = degrees * Math.PI / 180
              , c = Math.cos(radians)
              , s = Math.sin(radians);
            return [c * p[0] - s * p[1], s * p[0] + c * p[1]]
        },
        scale: function(p, n) {
            return [n * p[0], n * p[1]]
        },
        add: function(a, b) {
            return [a[0] + b[0], a[1] + b[1]]
        },
        minus: function(a, b) {
            return [a[0] - b[0], a[1] - b[1]]
        }
    };
    $.path.bezier = function(params, rotate) {
        params.start = $.extend({
            angle: 0,
            length: 0.3333
        }, params.start);
        params.end = $.extend({
            angle: 0,
            length: 0.3333
        }, params.end);
        this.p1 = [params.start.x, params.start.y];
        this.p4 = [params.end.x, params.end.y];
        var v14 = V.minus(this.p4, this.p1)
          , v12 = V.scale(v14, params.start.length)
          , v41 = V.scale(v14, -1)
          , v43 = V.scale(v41, params.end.length);
        v12 = V.rotate(v12, params.start.angle);
        this.p2 = V.add(this.p1, v12);
        v43 = V.rotate(v43, params.end.angle);
        this.p3 = V.add(this.p4, v43);
        this.f1 = function(t) {
            return (t * t * t)
        }
        ;
        this.f2 = function(t) {
            return (3 * t * t * (1 - t))
        }
        ;
        this.f3 = function(t) {
            return (3 * t * (1 - t) * (1 - t))
        }
        ;
        this.f4 = function(t) {
            return ((1 - t) * (1 - t) * (1 - t))
        }
        ;
        this.css = function(p) {
            var f1 = this.f1(p)
              , f2 = this.f2(p)
              , f3 = this.f3(p)
              , f4 = this.f4(p)
              , css = {};
            if (rotate) {
                css.prevX = this.x;
                css.prevY = this.y
            }
            css.x = this.x = (this.p1[0] * f1 + this.p2[0] * f2 + this.p3[0] * f3 + this.p4[0] * f4 + .5) | 0;
            css.y = this.y = (this.p1[1] * f1 + this.p2[1] * f2 + this.p3[1] * f3 + this.p4[1] * f4 + .5) | 0;
            css.left = css.x + "px";
            css.top = css.y + "px";
            return css
        }
    }
    ;
    $.path.arc = function(params, rotate) {
        for (var i in params) {
            this[i] = params[i]
        }
        this.dir = this.dir || 1;
        while (this.start > this.end && this.dir > 0) {
            this.start -= 360
        }
        while (this.start < this.end && this.dir < 0) {
            this.start += 360
        }
        this.css = function(p) {
            var a = (this.start * (p) + this.end * (1 - (p))) * Math.PI / 180
              , css = {};
            if (rotate) {
                css.prevX = this.x;
                css.prevY = this.y
            }
            css.x = this.x = (Math.sin(a) * this.radius + this.center[0] + .5) | 0;
            css.y = this.y = (Math.cos(a) * this.radius + this.center[1] + .5) | 0;
            css.left = css.x + "px";
            css.top = css.y + "px";
            return css
        }
    }
    ;
    $.fx.step.path = function(fx) {
        var css = fx.end.css(1 - fx.pos);
        if (css.prevX != null) {
            $.cssHooks.transform.set(fx.elem, "rotate(" + Math.atan2(css.prevY - css.y, css.prevX - css.x) + ")")
        }
        fx.elem.style.top = css.top;
        fx.elem.style.left = css.left
    }
}
)(jQuery);
/* /themes/horoshop_default/layout/js/frontend/dropdown.js */
(function() {
    'use strict';
    $.widget('hs.dropdown', {
        options: {
            trigger: null,
            event: 'hover',
            parentNode: $('body > .container'),
            siblingsClassName: null,
            visibleClass: '__visible',
            hoverClass: '__hover',
            closeOnClick: !1,
            center: !0,
            speed: 150
        },
        isOpen: !1,
        _create: function() {
            this.$dropdown = this.element;
            this.$trigger = $(this.options.trigger);
            this.speed = this.options.speed;
            this.$parentNode = this.options.parentNode;
            this.siblingsClassName = this.options.siblingsClassName;
            this.hoverClass = this.options.hoverClass;
            this.visibleClass = this.options.visibleClass;
            this.isVisible = !1;
            this.timerOut;
            if (!this.$dropdown.length)
                return;
            if (this.$parentNode && this.$parentNode.length) {
                this.$dropdown.appendTo(this.$parentNode)
            }
            this.bindEvents()
        },
        bindEvents: function() {
            var self = this
              , triggerHref = this.$trigger.attr('href')
              , siblingsTarget = !1;
            if (this.options.event === 'hover') {
                this.$trigger.off('mouseenter.dropdown mouseleave.dropdown').on('mouseenter.dropdown', function(e) {
                    var trigger = this;
                    clearTimeout(self.timerOut);
                    siblingsTarget = $(e.relatedTarget).hasClass(self.siblingsClassName);
                    self.timerOut = setTimeout(function() {
                        self.open(trigger)
                    }, siblingsTarget ? 0 : 50)
                }).add(this.$dropdown).on('mouseleave.dropdown', function(e) {
                    siblingsTarget = $(e.relatedTarget).hasClass(self.siblingsClassName);
                    clearTimeout(self.timerOut);
                    self.timerOut = setTimeout(function() {
                        self.close()
                    }, siblingsTarget ? 0 : 200)
                });
                this.$dropdown.off('mouseenter.dropdown').on('mouseenter.dropdown', function() {
                    clearTimeout(self.timerOut)
                })
            } else {}
            if (!triggerHref || triggerHref === '#') {
                this.$trigger.off('click.dropdown').on('click.dropdown', function(e) {
                    if (!self.isVisible) {
                        self.open(this)
                    } else {
                        self.close()
                    }
                    e.preventDefault()
                })
            }
            if (this.options.closeOnClick) {
                this.$dropdown.click(function(e) {
                    e.stopPropagation()
                });
                if (!triggerHref || triggerHref === '#') {
                    this.$trigger.click(function(e) {
                        e.stopPropagation()
                    })
                }
            }
        },
        open: function(trigger) {
            var self = this
              , $trigger = $(trigger)
              , triggerOffset = $trigger.offset()
              , triggerHeight = $trigger.outerHeight();
            clearTimeout(this.timerOut);
            if (this.$parentNode && this.$parentNode.length) {
                this.$dropdown.css({
                    'top': triggerOffset.top + triggerHeight,
                    'left': this.options.center ? triggerOffset.left - (this.$dropdown.outerWidth() - $trigger.outerWidth()) / 2 : triggerOffset.left
                })
            }
            $trigger.addClass(this.hoverClass);
            setTimeout(function() {
                self.$dropdown.addClass(self.visibleClass)
            }, 1);
            this.isOpen = !0;
            setTimeout($.proxy(function() {
                this.isVisible = !0
            }, this), this.speed);
            this._on(this.document, this._documentClick)
        },
        close: function() {
            if (!this.isOpen) {
                return
            }
            this.$trigger.removeClass(this.hoverClass);
            this.$dropdown.removeClass(this.visibleClass);
            setTimeout($.proxy(function() {
                this.isVisible = !1;
                this.isOpen = !1
            }, this), this.speed);
            this._off(this.document);
            clearTimeout(this.timerOut)
        },
        _documentClick: {
            mousedown: function(event) {
                if (!$(event.target).closest(this.$dropdown).length) {
                    this.close()
                }
            }
        },
        _destroy: function() {}
    })
}
)();
/* /themes/horoshop_default/layout/js/frontend/tooltip2.js */
(function($) {
    'use strict';
    $.widget('hs.tooltip', {
        reference: null,
        _isOpen: !1,
        _tooltipNode: null,
        _events: [],
        options: {
            container: !1,
            delay: 300,
            html: !1,
            placement: 'top',
            title: '',
            content: null,
            tooltipClass: 'tooltip',
            arrowClass: 'tooltip__arrow',
            wrapperClass: 'tooltip__wrap',
            trigger: 'hover focus',
            offset: 0,
            hideOnClick: !1,
            popperOptions: {
                modifiers: {
                    preventOverflow: {
                        boundariesElement: 'window',
                        padding: parseFloat($('.wrapper').css('padding-left'))
                    }
                }
            }
        },
        _create: function() {
            var events = typeof this.options.trigger === 'string' ? this.options.trigger.split(' ').filter(function(trigger) {
                return ['click', 'hover', 'focus'].indexOf(trigger) !== -1
            }) : [];
            this._isOpen = !1;
            this._setEventListeners(this.element, events, this.options)
        },
        _destroy: function() {
            var _this = this;
            this._events.forEach(function(_ref) {
                var func = _ref.func
                  , event = _ref.event;
                _this.element.off(event, func)
            });
            this._events = [];
            if (this._tooltipNode) {
                this._hide();
                this.popperInstance.destroy();
                if (!this.popperInstance.options.removeOnDestroy) {
                    this._tooltipNode.remove();
                    this._tooltipNode = null
                }
            }
            return this
        },
        _show: function(reference, options, callback) {
            if (this._isOpen) {
                return this
            }
            this._isOpen = !0;
            if (this._tooltipNode) {
                this._tooltipNode.addClass('is-visible');
                this._tooltipNode.attr('aria-hidden', 'false');
                this.popperInstance.update();
                return this
            }
            var tooltipNode = this._createNode();
            var container = this._findContainer(options.container, reference);
            container.append(tooltipNode);
            var popperOptions = $.extend({}, options.popperOptions, {
                placement: options.placement
            });
            popperOptions.modifiers = $.extend({}, popperOptions.modifiers, {
                arrow: {
                    element: '.' + this.options.arrowClass
                }
            });
            if (options.boundariesElement) {
                popperOptions.modifiers.preventOverflow = {
                    boundariesElement: options.boundariesElement
                }
            }
            this.popperInstance = new window.Popper(reference,tooltipNode,popperOptions);
            this._tooltipNode = tooltipNode;
            tooltipNode.addClass('is-visible');
            if (typeof callback === 'function') {
                callback()
            }
            return this
        },
        _hide: function() {
            if (!this._isOpen) {
                return this
            }
            this._isOpen = !1;
            this._tooltipNode.removeClass('is-visible');
            this._tooltipNode.attr('aria-hidden', 'true');
            return this
        },
        _createNode: function() {
            var tooltipNode = $(this.options.content);
            if (tooltipNode[0].nodeType === 3) {
                tooltipNode.wrap(this.options.tooltipClass)
            } else if (!tooltipNode.hasClass(this.options.tooltipClass)) {
                tooltipNode.addClass(this.options.tooltipClass)
            }
            tooltipNode.attr('id', 'tooltip_' + Math.random().toString(36).substr(2, 10));
            tooltipNode.attr('aria-hidden', 'false');
            if (tooltipNode.find('.' + this.options.wrapperClass).length === 0) {
                tooltipNode.wrapInner('<div class="' + this.options.wrapperClass + '">')
            }
            if (tooltipNode.find('.' + this.options.arrowClass).length === 0) {
                tooltipNode.append('<div class="' + this.options.arrowClass + '">')
            }
            if (tooltipNode.is(':hidden')) {
                tooltipNode.show()
            }
            return tooltipNode
        },
        _findContainer: function(container, reference) {
            if (typeof container === 'string') {
                container = $(container)
            } else if (container === !1) {
                container = reference.parent()
            }
            return container
        },
        _setEventListeners: function(reference, events, options) {
            var _this = this;
            var directEvents = [];
            var oppositeEvents = [];
            events.forEach(function(event) {
                switch (event) {
                case 'hover':
                    directEvents.push('mouseenter');
                    oppositeEvents.push('mouseleave');
                    break;
                case 'focus':
                    directEvents.push('focus');
                    oppositeEvents.push('blur');
                    break;
                case 'click':
                    directEvents.push('click');
                    oppositeEvents.push('click');
                    break
                }
            });
            directEvents.forEach(function(event) {
                var func = function(evt) {
                    evt.preventDefault();
                    if (_this._isOpen === !0) {
                        return
                    }
                    evt.usedByTooltip = !0;
                    _this._scheduleShow(reference, options.delay, options, evt)
                };
                _this._events.push({
                    event: event,
                    func: func
                });
                reference[0].addEventListener(event, func)
            });
            oppositeEvents.forEach(function(event) {
                var t = null;
                var func = function(evt) {
                    if (evt.usedByTooltip === !0) {
                        return
                    }
                    _this._scheduleHide(reference, options.delay, options, evt)
                };
                _this._events.push({
                    event: event,
                    func: func
                });
                reference[0].addEventListener(event, func)
            });
            if (this.options.hideOnClick) {
                var func = function(evt) {
                    var target = evt.target;
                    if (_this._contains(reference, target)) {
                        return
                    }
                    _this._scheduleHide(reference, options.delay, options, evt)
                };
                document.body.addEventListener('click', func)
            }
        },
        _scheduleShow: function(reference, delay, options, evt) {
            var _this = this;
            var computedDelay = delay && delay.show || delay || 0;
            window.setTimeout(function() {
                if (evt.type === 'mouseenter') {
                    var relatedreference = document.querySelectorAll(":hover");
                    if (!_this._contains(_this.element, relatedreference)) {
                        return
                    }
                }
                _this._show(reference, options)
            }, computedDelay)
        },
        _scheduleHide: function(reference, delay, options, evt, t) {
            var _this = this;
            var computedDelay = delay && delay.hide || delay || 0;
            window.setTimeout(function() {
                if (_this._isOpen === !1) {
                    return
                }
                if (!$('body').find(_this._tooltipNode).length) {
                    return
                }
                if (evt.type === 'mouseleave') {
                    var relatedreference = document.querySelectorAll(":hover");
                    var isSet = _this._setTooltipNodeEvent(evt, reference, relatedreference, delay, options);
                    if (isSet || _this._contains(_this.element, relatedreference)) {
                        return
                    }
                }
                if (evt.type === 'click' && _this.options.hideOnClick) {
                    if (_this._contains(_this._tooltipNode, evt.target)) {
                        return
                    }
                }
                _this._hide(reference, options)
            }, computedDelay)
        },
        _setTooltipNodeEvent: function(evt, reference, relatedreference, delay, options) {
            var _this = this;
            var callback = function callback(evt2) {
                _this._tooltipNode[0].removeEventListener(evt.type, callback);
                _this._scheduleHide(reference, options.delay, options, evt2)
            };
            if (_this._contains(_this._tooltipNode, relatedreference)) {
                _this._tooltipNode[0].addEventListener(evt.type, callback);
                return !0
            }
            return !1
        },
        _contains: function(container, contained) {
            return container.find(contained).length || container.is(contained)
        },
        show: function() {
            this._show(this.element, this.options)
        },
        hide: function() {
            this._hide()
        }
    })
}
)(jQuery);
/* /themes/horoshop_default/layout/js/frontend/siteMenuDropdown.js */
(function() {
    'use strict';
    $.widget('hs.siteMenuDropdown', {
        options: {
            items: null,
            wrapper: null,
            siblings: null,
            buttonText: '...',
            buttonClassName: 'site-menu__link-text',
            buttonArrowHTML: '<i class="icon-arrowDown"></i>'
        },
        _create: function() {
            this.$menu = this.element;
            this.$menuItems = this.options.items || this.$menu.children();
            this.$wrapper = this.options.wrapper && this.$menu.parents(this.options.wrapper).length ? this.$menu.parents(this.options.wrapper).first() : this.$menu.parent();
            this.$siblings = this.options.siblings && this.$wrapper.find(this.options.siblings).length && this.$wrapper.find(this.options.siblings);
            this.$submenu = null;
            this.submenuLength = 0;
            this.menuItemsWidth = [];
            this.freeWidth = 0;
            this.$dropdownToggle = null;
            this.menuFullWidth = 0;
            var self = this;
            this.$menuItems.each(function() {
                var $this = $(this)
                  , elementStyle = getComputedStyle($this[0])
                  , currentWidth = $this[0].getBoundingClientRect().width + parseFloat(elementStyle.marginLeft) + parseFloat(elementStyle.marginRight);
                self.menuFullWidth += currentWidth;
                self.menuItemsWidth.push(currentWidth)
            });
            this.buildHtml();
            $(window).on('resize.siteMenuDropdown', this.buildHtml.bind(this))
        },
        buildHtml: function() {
            var self = this
              , wrapperStyle = getComputedStyle(this.$wrapper[0]);
            this.freeWidth = this.$wrapper[0].getBoundingClientRect().width - parseFloat(wrapperStyle.paddingLeft) - parseFloat(wrapperStyle.paddingRight);
            if (this.$siblings) {
                this.$siblings.each(function() {
                    if (!$(this).find(self.$menu).length) {
                        self.freeWidth -= ($(this).outerWidth(!0))
                    } else {
                        var currentStyle = getComputedStyle(this);
                        self.freeWidth -= parseFloat(currentStyle.marginLeft) + parseFloat(currentStyle.marginRight)
                    }
                })
            }
            if (this.menuFullWidth < this.freeWidth && this.$submenu) {
                if (this.$dropdownToggle.length) {
                    this.$dropdownToggle.detach()
                }
                this.submenuLength = 0
            }
            this.addMenuItems(this.$menuItems.length);
            if (this.menuFullWidth > this.freeWidth) {
                var menuLength = this.$menuItems.length
                  , menuNewWidth = this.menuFullWidth
                  , submenuContent = [];
                if (!this.$submenu) {
                    this.$submenu = $('<ul class="submenu" />')
                } else {
                    this.$submenu.children().remove()
                }
                if (!this.$dropdownToggle) {
                    this.$dropdownToggle = this.$menuItems.last().clone().appendTo(this.$menu);
                    this.$dropdownToggle.find('a').attr('href', '#').html('<span class="' + this.options.buttonClassName + '">' + this.options.buttonText + '</span>' + this.options.buttonArrowHTML);
                    this._initDropdown()
                }
                if (!this.$menu.find(this.$dropdownToggle).length) {
                    this.$dropdownToggle.appendTo(this.$menu)
                }
                this.freeWidth -= this.$dropdownToggle.outerWidth(!0);
                for (var i = menuLength - 1; i > 0; i--) {
                    if (menuNewWidth <= this.freeWidth) {
                        break
                    }
                    menuNewWidth -= this.menuItemsWidth[i];
                    submenuContent.unshift(this.$menuItems.eq(i).children().clone());
                    this.submenuLength++
                }
                $.each(submenuContent, function(i, val) {
                    self.$menuItems.eq(-i - 1).remove();
                    $('<li class="submenu-i" />').append(val.removeAttr('class')).appendTo(self.$submenu)
                })
            }
        },
        _initDropdown: function() {
            this.$submenu.appendTo(this.$dropdownToggle).dropdown({
                trigger: this.$dropdownToggle.children('a')
            })
        },
        addMenuItems: function(num) {
            var self = this;
            this.$menuItems.each(function(i) {
                if ($(this).parent(self.$menu).length === 0 && i <= num - 1) {
                    $(this).insertAfter(self.$menu.children().eq(i - 1))
                }
            })
        }
    })
}());
/* /themes/horoshop_default/layout/js/frontend/productsMenu.js */
$.widget('hs.productsMenu', {
    menu: $('.j-products-menu'),
    menuItem: $('.j-submenu-item'),
    itemTitle: $('.j-products-menu-title'),
    tabs: $('.productsMenu-tabs'),
    tabsContent: $('.productsMenu-tabs-content'),
    tabsList: $('.productsMenu-tabs-list'),
    options: {
        submenuSelector: null,
        submenuWrapSelector: null,
        menuActiveClassName: 'is-active',
        parent: null,
        fadeTimeIn: 150
    },
    _create: function() {
        $(window).resize($.proxy(function() {
            this._init()
        }, this))
    },
    _init: function() {
        this._initMenuAim();
        this._calculateWidth();
        this._attachEventHandlers()
    },
    _calculateWidth: function() {
        var menuWidth = this.options.parent ? this.options.parent.width() : this.menu.width();
        var leftOffset = this.menu.offset().left - this.options.parent.offset().left;
        var rightOffset = menuWidth - leftOffset - this.menu.width();
        var self = this;
        this.menuItem.each(function() {
            var $this = $(this)
              , itemPos = $this.position().left + leftOffset
              , itemWidth = $this.width()
              , submenu = self.options.submenuSelector ? $this.find(self.options.submenuSelector) : $this.find('.productsMenu-submenu')
              , submenuTabs = $this.find('.productsMenu-tabs')
              , submenuTabsList = $this.find('.productsMenu-tabs-list')
              , submenuWrap = self.options.submenuWrapSelector ? $this.find(self.options.submenuWrapSelector) : $this.find('.productsMenu-submenu-w')
              , submenuWidth = submenu.width()
              , submenuAvailableWidth = 0;
            if (submenuTabs.length) {
                if ((itemPos + itemWidth / 2) <= menuWidth / 2) {
                    submenuAvailableWidth = menuWidth - itemPos
                } else {
                    submenuAvailableWidth = itemPos + itemWidth
                }
            } else {
                submenuAvailableWidth = menuWidth
            }
            submenuWrap.each(function(i) {
                var $this = $(this);
                if (!$this.parents('.productsMenu-submenu').hasClass('__fluidGrid'))
                    return;
                var columnWidth = self._getColumnWidth($this), submenuPaddings = parseFloat($this.css('padding-left')) + parseFloat($this.css('padding-right')), columnsWidth, fullSubmenuWidth = 0, totalHeight = 0, columnsNumber, columnGap = 20, columnMinHeight = 300, columnMaxHeight = 0;
                $this.show().find('.productsMenu-submenu-i').each(function() {
                    var _height = $(this).outerHeight(!0);
                    if (_height > columnMaxHeight) {
                        columnMaxHeight = _height
                    }
                    totalHeight += _height
                });
                $this.removeAttr('style');
                if (columnMaxHeight > columnMinHeight) {
                    columnsNumber = Math.ceil(totalHeight / columnMaxHeight)
                } else {
                    columnsNumber = Math.ceil(totalHeight / columnMinHeight)
                }
                columnsWidth = columnsNumber * columnWidth + (columnsNumber - 1) * columnGap;
                if (submenuTabs.length > 0) {
                    fullSubmenuWidth = columnsWidth + submenuTabsList.width() + submenuPaddings
                } else {
                    fullSubmenuWidth = columnsWidth + submenuPaddings
                }
                if (fullSubmenuWidth < submenuAvailableWidth) {
                    if (submenuTabs.length > 0) {
                        $this.width(columnsWidth);
                        submenuWidth = itemWidth
                    } else {
                        if (fullSubmenuWidth < itemWidth) {
                            submenu.width(itemWidth);
                            $this.width('auto');
                            submenuWidth = itemWidth
                        } else {
                            submenu.width('auto');
                            $this.width(columnsWidth);
                            submenuWidth = $this.outerWidth()
                        }
                    }
                } else {
                    if (submenuTabs.length > 0) {
                        var _columnsNumber = Math.floor((submenuAvailableWidth - submenuTabsList.width() + columnGap) / (columnWidth + columnGap));
                        var _columnsWidth = _columnsNumber * columnWidth + (_columnsNumber - 1) * columnGap;
                        $this.width(_columnsWidth)
                    } else {
                        $this.width('auto');
                        submenuWidth = menuWidth;
                        submenu.width(menuWidth)
                    }
                }
            });
            submenu.css('top', $this.position().top + $this.height());
            if (submenuTabs.length) {
                submenu.addClass('__hasTabs __pos_left');
                submenuTabsList.data('MenuAim').setOption('submenuDirection', 'right');
                if ((itemPos + itemWidth / 2) <= menuWidth / 2) {
                    submenu.css('left', itemPos - leftOffset)
                } else {
                    submenu.removeClass('__pos_left').addClass('__pos_right');
                    submenuTabsList.data('MenuAim').setOption('submenuDirection', 'left');
                    submenu.css({
                        'right': self.menu.width() - $this.position().left - $this.width(),
                        'left': 'auto'
                    })
                }
            } else {
                if (submenuWidth === menuWidth) {
                    submenu.css({
                        'left': -leftOffset,
                        'right': -rightOffset
                    })
                } else if ((itemPos + itemWidth / 2) < submenuWidth / 2) {
                    submenu.css({
                        'left': -leftOffset,
                        'right': 'auto'
                    })
                } else if (submenuAvailableWidth - (itemPos + itemWidth / 2) < submenuWidth / 2) {
                    submenu.css({
                        'left': 'auto',
                        'right': -rightOffset
                    })
                } else {
                    submenu.css({
                        'left': itemPos - leftOffset + itemWidth / 2 - submenuWidth / 2,
                        'right': 'auto'
                    })
                }
            }
        })
    },
    _attachEventHandlers: function() {
        var self = this, showTimer, changeTimerOn, changeTimerOff, hideTimer, menuTimer, onMenu;
        this.menuItem.off('mouseenter.productsMenu').on('mouseenter.productsMenu', function() {
            var $this = $(this);
            clearTimeout(changeTimerOn);
            clearTimeout(changeTimerOff);
            clearTimeout(hideTimer);
            clearTimeout(menuTimer);
            if (onMenu && $this.find('.productsMenu-submenu').index() > 0) {
                changeTimerOn = setTimeout(function() {
                    self.menu.find('.productsMenu-submenu').removeClass('__visible');
                    $this.find('.productsMenu-submenu').addClass('__visible')
                }, 50);
                self.menuItem.removeClass('__hover');
                $this.addClass('__hover')
            } else if (!onMenu && $this.find('.productsMenu-submenu').index() > 0) {
                showTimer = setTimeout(function() {
                    $this.find('.productsMenu-submenu').addClass('__visible');
                    $this.addClass('__hover');
                    onMenu = !0
                }, 50);
                setTimeout(function() {
                    self.menu.addClass(self.options.menuActiveClassName)
                }, self.options.fadeTimeIn)
            } else {
                self.menuItem.find('.productsMenu-submenu').removeClass('__visible');
                self.menuItem.not($this).removeClass('__hover');
                $this.addClass('__hover');
                onMenu = !1
            }
            self._trigger('onHover', null, $this)
        }).off('mouseleave.productsMenu').on('mouseleave.productsMenu', function() {
            var $this = $(this);
            if ($this.find('.productsMenu-submenu').index() > 0) {
                hideTimer = setTimeout(function() {
                    self.menuItem.find('.productsMenu-submenu').removeClass('__visible');
                    $this.removeClass('__hover');
                    onMenu = !1
                }, 200)
            } else if ($this.find('.productsMenu-submenu').index() < 0) {
                $this.removeClass('__hover');
                self.menuItem.find('.productsMenu-submenu').removeClass('__visible')
            }
            clearTimeout(showTimer)
        });
        $('.productsMenu-submenu').hover(function() {
            clearTimeout(showTimer);
            clearTimeout(changeTimerOff)
        });
        self.menu.mouseleave(function() {
            menuTimer = setTimeout(function() {
                self.menu.removeClass(self.options.menuActiveClassName)
            }, 200)
        });
        $('.j-productsMenu-toggleButton').on('click', function(e) {
            var $this = $(this);
            if ($this.attr('href') === undefined) {
                e.preventDefault()
            }
            if ($('.productsMenu-submenu').hasClass('__visible')) {
                $this.trigger('mouseleave')
            } else {
                $this.trigger('mouseenter')
            }
        });
        var submenuNav = $('.productsMenu-submenu-nav')
          , submenuContent = $('.productsMenu-submenu');
        submenuNav.each(function() {
            $(this).find('a').eq(0).addClass('__hover')
        });
        submenuContent.each(function() {
            $(this).find('.productsMenu-submenu-content').eq(0).show()
        });
        submenuNav.find('a').mouseenter(function() {
            var $this = $(this);
            var index = $this.index();
            $this.siblings().removeClass('__hover');
            $this.addClass('__hover');
            $this.parent().siblings('.productsMenu-submenu-content').hide().eq(index).show()
        })
    },
    _toggleTabs: function(row) {
        var $row = $(row)
          , target_id = $row.find('a').attr('data-target');
        if (typeof target_id === 'undefined' || target_id.length == 0)
            return !1;
        var tab = this.tabsContent.find('[id="' + target_id + '"]');
        if (tab.length == 0)
            return !1;
        return tab
    },
    _initMenuAim: function() {
        var self = this;
        this.tabsList.menuAim({
            closeDelay: 1000,
            activate: function(row) {
                var tab = self._toggleTabs(row)
                  , $row = $(row);
                if (!tab) {
                    $row.parents('.productsMenu-tabs').find('[id^="menu-tab-"]').removeClass('__visible');
                    return !1
                }
                $row.parents('.productsMenu-tabs').find('[id^="menu-tab-"]').removeClass('__visible');
                $row.addClass('__hover');
                tab.addClass('__visible')
            },
            deactivate: function(row, exitMenu) {
                $(row).removeClass('__hover')
            },
            enter: function(row) {},
            exit: function(row) {},
            exitMenu: function($row) {
                return !1
            },
            rowSelector: ".productsMenu-tabs-list__tab",
            submenuSelector: "*",
            submenuDirection: "left"
        })
    },
    _getColumnWidth: function($el) {
        var computedStyle = getComputedStyle($el[0])
          , columnWithProp = 'columnWidth'in computedStyle
          , columnWith = 0;
        if (columnWithProp) {
            columnWith = parseFloat(computedStyle.columnWidth)
        } else {
            $el.show();
            columnWith = $el.children().outerWidth(!0);
            $el.css('display', '')
        }
        return columnWith
    }
});
/* /themes/horoshop_default/layout/js/frontend/brandInfoCollapse.js */
$.widget('hs.brandInfoCollapse', {
    options: {
        $button: null,
        buttonText: {
            expand: 'Expand',
            collapse: 'Collapse'
        },
        collapsedClass: 'is-collapsed',
        visibleClass: 'is-visible',
        onAfterAction: function() {}
    },
    _create: function() {
        var self = this;
        this.$content = this.element;
        this.$button = this.options.$button;
        this.collapsedHeight = this.$content.height();
        this.expandedHeight = this.$content.children().height();
        if (this.expandedHeight > this.collapsedHeight) {
            this.$content.css({
                'height': this.collapsedHeight,
                'max-height': 'none'
            }).addClass(this.options.collapsedClass).data('collapsed', !0);
            this.$button.addClass(this.options.visibleClass).off('click.brandInfoCollapse').on('click.brandInfoCollapse', function(e) {
                if (self.$content.data('collapsed')) {
                    self.expand()
                } else {
                    self.collapse()
                }
                e.preventDefault()
            })
        }
    },
    expand: function() {
        var self = this;
        this.$content.data('collapsed', !1).removeClass(self.options.collapsedClass).animate({
            'height': this.expandedHeight
        }, 200, function() {
            self.$button.text(self.options.buttonText.collapse);
            if (typeof self.options.onAfterAction === 'function') {
                self.options.onAfterAction()
            }
        })
    },
    collapse: function() {
        var self = this;
        this.$content.addClass(self.options.collapsedClass).data('collapsed', !0).animate({
            'height': this.collapsedHeight
        }, 200, function() {
            self.$button.text(self.options.buttonText.expand);
            if (typeof self.options.onAfterAction === 'function') {
                self.options.onAfterAction()
            }
        })
    }
});
/* /themes/horoshop_default/layout/js/frontend/filter-collapse.js */
(function(w) {
    var FilterCollapse = function(selector, options) {
        this.$container = document.querySelector(selector);
        this.defaults = {
            mode: 'scroll',
            visibleItemsNumber: 10,
            showText: '',
            hideText: ''
        };
        this.options = Object.assign({}, this.defaults, options);
        this.$list = null;
        this.$items = null;
        this.init()
    };
    FilterCollapse.prototype = {
        selectors: {
            list: '.j-filter-list',
            item: '.j-filter-item',
            toggleButton: '.j-filter-toggle-button'
        },
        init: function() {
            this.$items = this.$container.querySelectorAll(this.selectors.item);
            this.$list = this.$container.querySelector(this.selectors.list);
            switch (this.options.mode) {
            case 'scroll':
                this.initScroll();
                break;
            case 'toggle':
                this.initToggle();
                break;
            default:
                console.log('Wrong mode option')
            }
        },
        initScroll: function() {
            var visibleHeight = this.options.visibleItemsNumber * this.$items[0].offsetHeight;
            if (this.$list.offsetHeight < visibleHeight) {
                return
            }
            this.$list.style.height = visibleHeight + 'px';
            this.$list.classList.add('has-scrollbar');
            $(this.$list).jScrollPane({
                horizontalGutter: 0
            })
        },
        initToggle: function() {
            var self = this
              , initialHeight = this.$list.offsetHeight
              , visibleHeight = 0
              , hiddenItemsNumber = this.$items.length - this.options.visibleItemsNumber
              , button = this.$container.querySelector(this.selectors.toggleButton)
              , opened = !1;
            if (this.$items.length < this.options.visibleItemsNumber + 1) {
                return
            }
            this.$items.forEach(function(elem, i) {
                if (i > self.options.visibleItemsNumber - 1) {
                    return
                }
                visibleHeight += elem.offsetHeight
            });
            button.parentNode.classList.add('is-visible');
            button.innerHTML = this.options.showText + ' ' + hiddenItemsNumber;
            this.$list.classList.add('has-toggle');
            this.$list.style.maxHeight = visibleHeight + 'px';
            button.addEventListener('click', function() {
                if (opened) {
                    self.$list.style.maxHeight = visibleHeight + 'px';
                    button.innerHTML = self.options.showText + ' ' + hiddenItemsNumber;
                    opened = !1
                } else {
                    self.$list.style.maxHeight = initialHeight + 'px';
                    button.innerHTML = self.options.hideText;
                    opened = !0
                }
            })
        }
    };
    w.FilterCollapse = FilterCollapse
}
)(window);
/* /vendor/widgets/BuyButtonCounter.js */
$(function() {
    window.BuyButtonCounter = {
        containerSelector: '.j-buy-button-counter',
        inputSelector: '.j-buy-button-counter-input',
        addSelector: '.j-buy-button-counter-add',
        removeSelector: '.j-buy-button-counter-remove',
        namespace: 'BuyButtonCounter',
        addedProducts: null,
        ajaxCart: AjaxCart.getInstance(),
        init: function(products) {
            if (products) {
                this.addedProducts = products
            }
            this.initButtons()
        },
        initButtons: function() {
            var self = this;
            $(this.containerSelector).each(function() {
                self.initCounterEvents($(this))
            })
        },
        initCounterEvents: function($counter) {
            var self = this, $add = $counter.find(self.addSelector), $remove = $counter.find(self.removeSelector), $input = $counter.find(self.inputSelector), minQuantity = Number($input.data('min')), maxQuantity = Number($input.data('max')), step = Number($input.data('step')), quantity = Number($input.val()), addTimer;
            $add.off('click.' + self.namespace).on('click.' + self.namespace, function() {
                var id = $counter.data('id');
                if (!$add.hasClass('__disabled') || quantity < maxQuantity) {
                    quantity += step;
                    if (quantity > maxQuantity) {
                        quantity = maxQuantity
                    } else if (quantity < minQuantity) {
                        quantity = minQuantity
                    }
                    $input.val(quantity);
                    if (quantity === maxQuantity) {
                        $add.addClass('__disabled')
                    }
                    $counter.addClass('is-visible');
                    $remove.removeClass('__disabled');
                    clearTimeout(addTimer);
                    addTimer = setTimeout(function() {
                        self.setQuantity(id, quantity)
                    }, 500)
                }
            });
            $remove.off('click.' + self.namespace).on('click.' + self.namespace, function() {
                var id = $counter.data('id');
                if (!$remove.hasClass('__disabled') && quantity > 0) {
                    quantity -= step;
                    if (quantity < minQuantity) {
                        quantity = 0
                    }
                    $input.val(quantity);
                    if (quantity === 0) {
                        $remove.addClass('__disabled');
                        $counter.removeClass('is-visible')
                    }
                    $add.removeClass('__disabled');
                    clearTimeout(addTimer);
                    addTimer = setTimeout(function() {
                        self.setQuantity(id, quantity)
                    }, 500)
                }
            });
            $input.numberMask({
                type: 'int'
            }).off('change.' + self.namespace).on('change.' + self.namespace, function() {
                var id = $counter.data('id');
                quantity = $input.val() * 1;
                if (quantity === 0) {
                    $input.val(0);
                    $remove.addClass('__disabled');
                    $add.removeClass('__disabled');
                    $counter.removeClass('is-visible');
                    self.removeProduct(id)
                } else {
                    if (quantity < minQuantity) {
                        quantity = minQuantity
                    } else if (quantity >= maxQuantity) {
                        $input.val(maxQuantity);
                        quantity = maxQuantity;
                        $add.addClass('__disabled')
                    } else if (quantity % step !== 0) {
                        quantity = (quantity - quantity % step) + step;
                        $input.val(quantity)
                    }
                    $remove.removeClass('__disabled');
                    $counter.addClass('is-visible');
                    self.setQuantity(id, quantity)
                }
            }).off('focus.' + self.namespace).on('focus.' + self.namespace, function() {
                $counter.addClass('is-visible')
            }).off('blur.' + self.namespace).on('blur.' + self.namespace, function() {
                if ($input.val() * 1 === 0) {
                    $counter.removeClass('is-visible')
                }
            })
        },
        updateButton: function(product, quantity) {
            var $counter = $('#j-buy-button-counter-' + product.id)
              , $input = $counter.find(this.inputSelector)
              , $add = $counter.find(this.addSelector)
              , $remove = $counter.find(this.removeSelector);
            if (quantity) {
                $input.val(quantity);
                $counter.addClass('is-visible');
                $remove.removeClass('__disabled');
                if (product.quantity === product.max_quantity) {
                    $add.addClass('__disabled')
                } else {
                    $add.removeClass('__disabled')
                }
            } else {
                $input.val(0);
                $counter.removeClass('is-visible');
                $remove.addClass('__disabled')
            }
            this.initCounterEvents($counter)
        },
        setQuantity: function(id, quantity) {
            var product = this.ajaxCart.getProductById(id);
            if (quantity === 0) {
                this.removeProduct(id);
                return
            }
            if (product) {
                this.ajaxCart.Cart.setProductQuantityByHash(product.hash, quantity);
                this.trigger('onChange', product, quantity)
            } else {
                this.addProduct(id, quantity)
            }
        },
        addProduct: function(id, quantity) {
            var gift = $('#j-buy-button-counter-' + id).data('gift') * 1;
            var related = null;
            var product = {
                type: 'product',
                quantity: quantity,
                id: id
            };
            if (gift) {
                related = [{
                    type: 'gift',
                    quantity: 1,
                    id: gift
                }];
                product.type = 'gift_parent'
            }
            if (this.trigger('onBeforeAdd', product, related) !== !1) {
                AjaxCart.openCartOnAdd = !1;
                this.ajaxCart.appendProduct(product, related);
                this.trigger('onChange', product, quantity);
                this.trigger('onAfterAdd', product, related)
            }
        },
        removeProduct: function(id) {
            var product = this.ajaxCart.getProductById(id);
            if (product) {
                this.ajaxCart.Cart.removeProductByHash(product.hash);
                this.trigger('onChange', product)
            }
        },
        updateOrderSum: function(product, quantity) {
            var $product = $('.j-product-row[data-id="' + product.id + '"]');
            var $orderSum = $product.find('.j-product-order-sum');
            if (quantity) {
                $orderSum.html(priceFormat(quantity * $product.data('price')));
                $product.addClass('__inCart')
            } else {
                $orderSum.empty();
                $product.removeClass('__inCart')
            }
        }
    };
    AjaxCart.getInstance().attachEventHandlers({
        onInit: function() {
            BuyButtonCounter.init(this.products)
        },
        onProductChange: function(hash, quantity) {
            var product = this.getProductByHash(hash);
            BuyButtonCounter.updateButton(product, quantity);
            BuyButtonCounter.updateOrderSum(product, quantity)
        },
        onProductAdd: function(id, product) {
            BuyButtonCounter.updateButton(product, product.quantity);
            BuyButtonCounter.updateOrderSum(product, product.quantity)
        }
    });
    CatalogBuilder.attachEventHandlers({
        onChange: function() {
            BuyButtonCounter.init()
        },
        onAdditionalDataLoaded: function() {
            BuyButtonCounter.init()
        }
    });
    $.extend(BuyButtonCounter, TMEvents);
    BuyButtonCounter.attachEventHandler('onChange', function(product, quantity) {
        BuyButtonCounter.updateOrderSum(product, quantity)
    })
});
/* /vendor/widgets/associated-products.js */
(function(w) {
    var AssociatedProducts = function(id, widgetLink, requestData) {
        this.id = id;
        this.widgetLink = widgetLink;
        this.requestData = requestData
    }
    AssociatedProducts.instances = {};
    AssociatedProducts.getInstance = function(id, widgetLink, requestData) {
        if (this.instances[id]) {
            return this.instances[id]
        } else {
            this.instances[id] = new this(id,widgetLink,requestData);
            return this.instances[id]
        }
    }
    ;
    AssociatedProducts.prototype = {
        init: function() {
            var self = this;
            this.$container = $('#' + this.id);
            if (!this.$container.length) {
                return
            }
            self.trigger('onBeforeAjax');
            sendAjax(this.widgetLink, this.requestData, function(status, response) {
                self.trigger('onAfterAjax')
                if (status === 'OK') {
                    var html = $(response.html);
                    html.insertAfter(self.$container);
                    self.trigger('onAfterAppendHtml')
                }
                self.$container.remove()
            })
        }
    }
    Object.assign(AssociatedProducts.prototype, TMEvents);
    w.AssociatedProducts = AssociatedProducts
}
)(window);
/* /vendor/widgets/price-list.js */
(function(w) {
    var PriceList = function(options={}) {
        this.selectors = Object.assign({
            container: '.j-price-list',
            generate: '.j-price-list-generate',
            copyLink: '.j-price-list-link'
        }, options.selectors || {});
        this.cls = Object.assign({
            loading: 'is-loading',
        }, options.cls || {});
        this.container = document.querySelector(this.selectors.container);
        this.ajaxUrl = window.GLOBAL.URI_PREFIX + '_widget/price_list/downloadPriceList';
        this.inProcess = !1;
        PriceList.instance = this
    }
    PriceList.getInstance = function(options) {
        if (this.instance === undefined) {
            return new PriceList(options)
        }
        return this.instance
    }
    ;
    PriceList.prototype = {
        initGenerateButton: function() {
            const self = this;
            self.buttonGenerate = self.container.querySelector(this.selectors.generate);
            self.buttonGenerate.addEventListener('click', function(e) {
                e.preventDefault();
                if (self.inProcess) {
                    return
                }
                self.inProcess = !0;
                self.buttonGenerate.classList.add(self.cls.loading);
                self.generateFile(function(response) {
                    self.inProcess = !1;
                    setInnerHTML(self.container, response.html)
                    self.buttonGenerate.classList.remove(self.cls.loading)
                })
            })
        },
        initCopyLinkButton: function() {
            const self = this;
            self.buttonCopyLink = self.container.querySelector(this.selectors.copyLink);
            self.buttonCopyLink.addEventListener('click', function(e) {
                e.preventDefault();
                const link = self.buttonCopyLink.getAttribute('href');
                if (link) {
                    self.copyTextToClipboard(link)
                }
            })
        },
        generateFile: function(successCallback) {
            const self = this;
            self.trigger('beforeAjax');
            sendAjax(self.ajaxUrl, function(status, response) {
                if (status === 'OK') {
                    if (typeof successCallback === 'function') {
                        successCallback(response);
                        self.trigger('successAjax')
                    }
                } else {
                    self.trigger('errorAjax', response)
                }
                self.trigger('afterAjax')
            })
        },
        showLoader: function(button) {
            button.classList.add(this.cls.loading)
        },
        hideLoader: function(button) {
            button.classList.remove(this.cls.loading)
        },
        copyTextToClipboard: function(text) {
            this.trigger('beforeCopy');
            if (!navigator.clipboard) {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.top = '0';
                textArea.style.left = '0';
                textArea.style.position = 'fixed';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    if (document.execCommand('copy')) {
                        this.trigger('afterCopy')
                    } else {
                        this.trigger('copyError', 'Command not supported')
                    }
                } catch (err) {
                    this.trigger('copyError', err)
                }
                document.body.removeChild(textArea);
                return
            }
            const self = this;
            navigator.clipboard.writeText(text).then(function() {
                self.trigger('afterCopy')
            }, function(err) {
                self.trigger('copyError', err)
            })
        },
    }
    Object.assign(PriceList.prototype, TMEvents);
    w.PriceList = PriceList
}
)(window);
/* /themes/horoshop_default/layout/js/frontend/face.js */
if (typeof window.Face === 'undefined') {
    window.Face = {}
}
Face.BREAKPOINT_S = 1000;
Face.BREAKPOINT_M = 1260;
Face.BREAKPOINT_L = 1441;
Face.$BODY = $('body');
Face.$WINDOW = $(window);
Face.$DOCUMENT = $(document);
Face.windowWidth = Face.$WINDOW.outerWidth();
Face.$WINDOW.on('resize', function() {
    Face.windowWidth = Face.$WINDOW.outerWidth()
});
$.extend(Face, TMEvents);
Face.checkWindowWidth = function() {
    var w = window.innerWidth;
    if (w >= Face.BREAKPOINT_L) {
        return 'large'
    } else if (w >= Face.BREAKPOINT_M) {
        return 'middle'
    } else {
        return 'small'
    }
}
;
Face.getTransitionDuration = function(obj) {
    var el = obj instanceof jQuery ? obj[0] : obj
      , duration = window.getComputedStyle(el).transitionDuration;
    return duration.indexOf('ms') > -1 ? parseFloat(duration) : parseFloat(duration) * 1000
}
;
windowResizeHandler(function() {
    var size = Face.checkWindowWidth();
    Face.trigger('onWindowResize');
    switch (size) {
    case 'large':
        Face.trigger('onWindowLargeWidth');
        break;
    case 'middle':
        Face.trigger('onWindowMiddleWidth');
        break;
    case 'small':
        Face.trigger('onWindowSmallWidth');
        break
    }
}, 'window');
$(function() {
    var $counter = $('.counter-field');
    $counter.focus(function() {
        $(this).parents('.counter').addClass('__focused')
    });
    $counter.focusout(function() {
        $(this).parents('.counter').removeClass('__focused')
    })
});
if ($.fn.selectBoxIt) {
    $('select.select').selectBoxIt({
        autoWidth: !1,
        copyClasses: "container"
    });
    $('.j-catalog-card-select').each(function() {
        var $select = $(this);
        $select.selectBoxIt({
            autoWidth: !1,
            copyClasses: "container",
            viewport: $select.parents('.j-catalog-card')
        })
    })
}
if ($.fn.FilterToggle) {
    $('.js-filter__box').FilterToggle()
}
(function() {
    var PromoSlider = function(selector) {
        this.selector = selector;
        this.$container = $(selector);
        this.hasSidebar = $('.layout-aside').length ? !0 : !1;
        this.visibleItems = 0;
        this.visibleItemsOptions = {
            'large': this.hasSidebar ? 5 : 6,
            'middle': this.hasSidebar ? 4 : 5,
            'small': this.hasSidebar ? 3 : 4
        };
        this.$container.each(function() {
            $(this).init()
        });
        this.init()
    };
    PromoSlider.prototype = {
        init: function() {
            if (!this.$container.length)
                return;
            this.$container.data('promoSlider', this);
            this.$container[0].promoSlider = this;
            this.initSwiper()
        },
        setVisibleItems: function() {
            switch (Face.checkWindowWidth()) {
            case 'large':
                this.visibleItems = this.visibleItemsOptions.large;
                break;
            case 'middle':
                this.visibleItems = this.visibleItemsOptions.middle;
                break;
            case 'small':
                this.visibleItems = this.visibleItemsOptions.small;
                break
            }
        },
        setButtonsPosition: function($buttons) {
            var prevPosition;
            var position;
            if (!$buttons.length)
                return;
            prevPosition = parseFloat($buttons.css('top'));
            position = (this.$container.find('.catalogCard-image').eq(0).outerHeight() / 2) - $buttons.eq(0).outerHeight() / 2;
            if (prevPosition === position)
                return;
            $buttons.css({
                top: position,
                'margin-top': 0
            })
        },
        update: function() {
            this.$container = $(this.selector);
            this.init()
        },
        initSwiper: function() {
            var self = this;
            self.$container.each(function() {
                var $this = $(this);
                $this.swiper({
                    wrapperClass: 'promo-slider-list',
                    slideClass: 'promo-slider-i',
                    slidesPerView: 'auto',
                    slidesPerGroup: 2,
                    speed: 400,
                    preventClicks: !1,
                    preventClicksPropagation: !1,
                    nextButton: $this.siblings('.slideCarousel-nav-btn.__slideRight'),
                    prevButton: $this.siblings('.slideCarousel-nav-btn.__slideLeft'),
                    buttonDisabledClass: '__disabled',
                    simulateTouch: !0,
                    roundLengths: !0,
                    observer: !1,
                    onInit: function(swiper) {
                        var $container = swiper.container;
                        var $navigation = $container.siblings('.slideCarousel-nav-btn');
                        self.setButtonsPosition($navigation);
                        Face.attachEventHandler('onWindowResize', function() {
                            if (swiper.virtualSize > swiper.width) {
                                swiper.container.siblings('.slideCarousel-nav-btn').show()
                            } else {
                                swiper.container.siblings('.slideCarousel-nav-btn').hide()
                            }
                            self.setButtonsPosition($navigation);
                            for (var i = 0, l = swiper.slidesGrid.length; i < l; i++) {
                                if (swiper.slidesGrid[i] < swiper.width) {
                                    self.visibleItems = i + 1
                                } else {
                                    break
                                }
                            }
                            swiper.slides.removeClass('__visible').slice(swiper.activeIndex, self.visibleItems + swiper.activeIndex).addClass('__visible')
                        });
                        windowResizeHandler(function() {
                            Face.trigger('onWindowResize')
                        }, '_promo-slider', 100);
                        Face.trigger('onWindowResize')
                    },
                    onSlideChangeStart: function(swiper) {
                        swiper.slides.slice(swiper.activeIndex, self.visibleItems + swiper.activeIndex).addClass('__visible');
                        swiper.container.addClass('is-moving')
                    },
                    onSlideChangeEnd: function(swiper) {
                        swiper.slides.removeClass('__visible').slice(swiper.activeIndex, self.visibleItems + swiper.activeIndex).addClass('__visible');
                        swiper.container.removeClass('is-moving')
                    }
                })
            })
        }
    };
    Face.PromoSlider = PromoSlider;
    Face.promoSlider = function(selector) {
        return $(selector).each(function() {
            if (!$.data(this, "Face.PromoSlider")) {
                $.data(this, "Face.PromoSlider", new Face.PromoSlider(this))
            }
        })
    }
    ;
    Face.promoSlider('.promo-slider');
    Face.promoSliderCardHover = function() {
        var $promoContainer = $('.promo')
          , lug = 0
          , mouseOver = !1;
        if ($promoContainer.length) {
            var $currentCatalogCard;
            $($promoContainer).on('mouseenter', '.catalogCard', function() {
                $currentCatalogCard = $(this);
                lug = getLug();
                lugFix(lug);
                mouseOver = !0
            }).on('mouseleave', '.catalogCard', function() {
                lugFix();
                mouseOver = !1
            });
            var lugFix = function(lug) {
                if (lug) {
                    $promoContainer.find('.slideCarousel-screen').css({
                        'padding': '20px ' + lug.right + 'px ' + lug.bottom + 'px ' + lug.left + 'px',
                        'margin': '-20px -' + lug.right + 'px -' + lug.bottom + 'px -' + lug.left + 'px'
                    })
                } else {
                    $promoContainer.find('.slideCarousel-screen').css({
                        'padding': '',
                        'margin': ''
                    })
                }
            };
            var getLug = function() {
                var lug = {};
                lug.top = 8;
                lug.bottom = $currentCatalogCard.find('.catalogCard-extra').outerHeight() + 22;
                var hLugLeftMax = $('.promo-section').offset().left - $('body > .container').offset().left;
                lug.left = hLugLeftMax > 40 ? 40 : hLugLeftMax;
                var hLugRightMax = $('body > .container').width() - ($('.promo-section').offset().left + $('.promo-section').width());
                lug.right = hLugRightMax > 40 ? 40 : hLugRightMax;
                return lug
            };
            CatalogBuilder.attachEventHandlers({
                'onAdditionalDataLoaded': function() {
                    if (mouseOver && $currentCatalogCard) {
                        lug = getLug();
                        lugFix(lug)
                    }
                }
            })
        }
    }
    ;
    Face.promoSliderCardHover()
}
)();
$('.banners-slider').each(function() {
    var $this = $(this);
    $this.swiper({
        wrapperClass: 'banners-slider-wrapper',
        slideClass: 'banners-slider-i',
        effect: 'fade',
        speed: 700,
        autoplay: 5000,
        preventClicks: !1,
        preventClicksPropagation: !1,
        pagination: $('.slider-bullets-wrp', $this),
        bulletClass: 'slider-bullet',
        bulletActiveClass: '__active',
        paginationClickable: !0,
        simulateTouch: !1,
        observer: !1,
        onInit: function(swiper) {
            if (swiper.slides.length < 2)
                swiper.paginationContainer.parent().remove()
        }
    })
});
$('.banners__slider').each(function() {
    var $this = $(this);
    if ($('.banners__slider-i', $this).length === 1) {
        $('.banners__slider-i', $this).addClass('is-visible')
    } else {
        $this.swiper({
            wrapperClass: 'banners__slider-wrapper',
            slideClass: 'banners__slider-i',
            effect: 'fade',
            speed: 700,
            autoplay: 5000,
            preventClicks: !1,
            loop: !0,
            preventClicksPropagation: !1,
            prevButton: $this.find('.j-banners-arrow-prev'),
            nextButton: $this.find('.j-banners-arrow-next'),
            pagination: $this.find('.j-banners-pagination'),
            bulletClass: 'banners-pagination__bullet',
            bulletActiveClass: 'is-active',
            paginationClickable: !0,
            simulateTouch: !1,
            observer: !1
        })
    }
});
(function() {
    $('banners-slider-i:eq(0)', '.banners-container').imagesLoaded({
        background: '.bannerMagic-layout'
    }, function() {
        $('.banners-container').addClass('__visible')
    })
}
)();
(function() {
    var defaults = {};
    var Dropdown = function(dropdown, options) {
        options = $.extend(Dropdown.defaults, options);
        this.$dropdown = $(dropdown);
        this.$trigger = $(options.trigger);
        this.event = options.event;
        this.visibleClass = options.visibleClass;
        this.animationDuration = Face.getTransitionDuration(this.$dropdown) || 300;
        this.init()
    };
    Dropdown.prototype = {
        init: function() {
            this.bindEvents()
        },
        bindEvents: function() {
            var self = this;
            if (this.event === 'hover') {
                var timerOut;
                this.$trigger.off('mouseenter.dropdown mouseleave.dropdown').on('mouseenter.dropdown', function() {
                    clearTimeout(timerOut);
                    self.show($(this))
                }).add(this.$dropdown).on('mouseleave.dropdown', function() {
                    clearTimeout(timerOut);
                    timerOut = setTimeout(function() {
                        self.hide()
                    }, 500)
                });
                this.$dropdown.off('mouseenter.dropdown').on('mouseenter.dropdown', function() {
                    clearTimeout(timerOut)
                });
                $('html').off('click.dropdown').on('click.dropdown', function() {
                    self.hide();
                    clearTimeout(timerOut)
                });
                this.$dropdown.click(function(e) {
                    e.stopPropagation()
                })
            }
        },
        show: function($trigger) {
            var self = this
              , triggerOffset = $trigger.offset()
              , triggerHeight = $trigger.outerHeight();
            this.$dropdown.appendTo(Face.$BODY).css({
                top: triggerOffset.top + triggerHeight,
                left: triggerOffset.left
            });
            setTimeout(function() {
                self.$dropdown.addClass(self.visibleClass)
            }, 1)
        },
        hide: function() {
            var self = this;
            this.$dropdown.removeClass(this.visibleClass);
            setTimeout(function() {
                self.$dropdown.detach()
            }, this.animationDuration)
        }
    };
    Dropdown.defaults = {
        trigger: null,
        event: 'hover',
        visibleClass: 'is-visible'
    }
}
)();
Face.userDiscountDropdown = function() {
    $('.user-discount-details').dropdown({
        trigger: '.js-user-discount-dropdown',
        visibleClass: 'is-visible',
        center: !1
    })
}
;
Face.userDiscountDropdown();
function init_sizes_table() {
    var $link = $('.productCard-size-all')
      , $sizesBox = $('.product-sizes');
    $link.click(function(e) {
        $sizesBox.fadeToggle(150);
        $link.toggleClass('__active');
        e.preventDefault()
    });
    $('html').click(function() {
        $sizesBox.fadeOut(150)
    });
    $sizesBox.add($link).click(function(e) {
        e.stopPropagation()
    })
}
init_sizes_table();
(function() {
    var $link = $('.productCard-markets-link')
      , $popup = $('.productCard-markets-popup');
    $link.click(function(e) {
        $popup.fadeToggle(150);
        e.preventDefault()
    });
    $('html').click(function() {
        $popup.fadeOut(150)
    });
    $popup.add($link).click(function(e) {
        e.stopPropagation()
    })
}
)();
(function() {
    var $toggle = $('.catalog-brand-toggle')
      , $text = $('.catalog-brand-txt')
      , textCollapsedHeight = 132
      , speed = 300;
    if ($text.height() > textCollapsedHeight) {
        $text.addClass('hb').data('collapsed', !0);
        $text.css('height', textCollapsedHeight);
        $text.next($toggle).show();
        $toggle.find('.js-hide-txt').hide();
        $toggle.click(function() {
            if ($text.data('collapsed')) {
                $text.animate({
                    'height': $text.find('.text').height()
                }, speed, function() {
                    $toggle.find('.js-hide-txt').show();
                    $toggle.find('.js-show-txt').hide()
                });
                $text.addClass('__open').data('collapsed', !1)
            } else {
                $text.animate({
                    'height': textCollapsedHeight
                }, speed, function() {
                    $text.data('collapsed', !0);
                    $toggle.find('.js-hide-txt').hide();
                    $toggle.find('.js-show-txt').show()
                });
                $text.removeClass('__open')
            }
            return !1
        })
    }
}
)();
(function($, window, document, undefined) {
    var pluginName = 'seoBlockToggle';
    function seoBlockToggle(element, options) {
        this._name = pluginName;
        this._defaults = $.fn.seoBlockToggle.defaults;
        this.element = element;
        this.isOpen = !1;
        this.options = $.extend({}, this._defaults, options);
        this.init()
    }
    $.extend(seoBlockToggle.prototype, {
        init: function() {
            var self = this;
            if (this.checkClass()) {
                $(this.element).removeClass(this.options.clipClass);
                this.isOpen = !0;
                return !1
            }
            this.buildCache();
            this.bindEvents()
        },
        destroy: function() {
            this.unbindEvents();
            this.$element.removeData()
        },
        buildCache: function() {
            var self = this;
            this.$element = $(this.element);
            this.$children = this.$element.children();
            this.$btn = this.$element.siblings('.' + this.options.btnClass);
            this.btnText = this.$element.data('toggle-text') || this.options.toggleText;
            this.clipHeight = this.$element.height();
            this.fullHeight = this.$children.height();
            this.lineHeight = parseFloat(this.$element.css('line-height'));
            this.$element.find('img').imagesLoaded(function() {
                self.fullHeight = self.$children.height()
            });
            if (!this.checkNumberOfParagraph()) {
                this.$btn = $(this.options.btnNode).text(this.btnText.show).insertAfter(this.$element)
            }
        },
        bindEvents: function() {
            var self = this;
            if (this.checkNumberOfParagraph()) {
                this.$element.removeClass(this.options.clipClass);
                this.isOpen = !0
            } else {
                this.$btn.on('click' + '.' + this._name, function(e) {
                    self.toggle();
                    if (typeof self.options.onToggle == 'function' && self.options.onToggle) {
                        self.options.onToggle(self)
                    }
                    e.preventDefault()
                })
            }
        },
        unbindEvents: function() {
            this.$element.off('.' + this._name)
        },
        toggle: function() {
            this.isOpen ? this.close() : this.open()
        },
        checkClass: function() {
            return $(this.element).hasClass(this.options.showClass)
        },
        checkNumberOfParagraph: function() {
            return (this.fullHeight - this.clipHeight) / this.lineHeight < this.options.numberOfParagraph
        },
        open: function() {
            this.$element.css({
                'max-height': this.fullHeight
            }).removeClass(this.options.clipClass);
            this.$btn.text(this.btnText.hide);
            this.isOpen = !0;
            this.callback()
        },
        close: function() {
            this.$element.css({
                'max-height': this.clipHeight
            }).addClass(this.options.clipClass);
            this.$btn.text(this.btnText.show);
            this.isOpen = !1;
            $(window).off('resize')
        },
        callback: function() {
            var self = this;
            var onComplete = this.options.onComplete;
            self.$element = $(self.element);
            self.$children = self.$element.children();
            if (this.isOpen === !0) {
                $(window).on('resize', function() {
                    self.fullHeight = self.$children.height();
                    self.$element.css({
                        'max-height': self.fullHeight
                    })
                })
            }
            if (typeof onComplete === 'function') {
                onComplete.call(this.element)
            }
        }
    });
    $.fn.seoBlockToggle = function(options) {
        this.each(function() {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new seoBlockToggle(this,options))
            }
        });
        return this
    }
    ;
    $.fn.seoBlockToggle.defaults = {
        parentNode: $('body'),
        btnNode: '<a href="#" class="a a--pseudo js-toggle-button" />',
        btnClass: 'js-toggle-button',
        toggleText: {
            show: 'Развернуть',
            hide: 'Свернуть'
        },
        clipClass: '__clip',
        showClass: '__show',
        numberOfParagraph: 3,
        speed: 10,
        onToggle: null,
        onComplete: null
    }
}
)(jQuery, window, document);
(function() {
    var $seoText = $('.j-seo-text-expander');
    if ($.fn.seoBlockToggle && $seoText.length > 0) {
        $seoText.seoBlockToggle()
    }
}());
var checkbox = $('input[type="checkbox"]');
checkbox.each(function() {
    if ($(this).prop('checked')) {
        $(this).parent('.checkbox').addClass('__checked')
    }
});
checkbox.click(function() {
    var $this = $(this);
    if ($this.is(':checked')) {
        $this.parent('.checkbox').addClass('__checked')
    } else {
        $this.parent('.checkbox').removeClass('__checked')
    }
});
$('input[type="radio"]').click(function() {
    var form = $(this).parents('form:first');
    if (form.length === 0) {
        $('*:not(form) input[type="radio"]').filter('[name="' + $(this).attr('name') + '"]').parent('.radio').removeClass('__checked')
    } else {
        form.find('input[type="radio"]').filter('[name="' + $(this).attr('name') + '"]').parent('.radio').removeClass('__checked')
    }
    $(this).parent('.radio').addClass('__checked')
});
function initUserMenu() {
    var $user = $('.user');
    if ($user.is('.__logged')) {
        var timerOut;
        $user.off('mouseenter mouseleave click').on('mouseenter', function() {
            clearTimeout(timerOut);
            $(this).addClass('__hovered').find('.user-menu').fadeIn(150)
        }).on('mouseleave', function() {
            var $this = $(this);
            clearTimeout(timerOut);
            timerOut = setTimeout(function() {
                $this.removeClass('__hovered').find('.user-menu').fadeOut(150)
            }, 500)
        });
        $('html').off('click.usermenu').on('click.usermenu', function() {
            $('.user-menu').fadeOut(150);
            clearTimeout(timerOut)
        });
        $user.click(function(e) {
            e.stopPropagation()
        })
    }
}
(initUserMenu)();
function initCommentsRating() {
    var rate = $('.productRating');
    rate.each(function() {
        var $this = $(this);
        var rateInput = $this.find('.productRating-input');
        if (rateInput.length > 0) {
            var rateBox = $this.find('.productRating-select');
            var stars = rateBox.find('.productRating-star')
              , currentRate = '';
            stars.off('mouseenter').on('mouseenter', function() {
                var $this = $(this)
                  , prevStars = $this.prevAll();
                stars.removeClass('__active');
                $this.add(prevStars).addClass('__hover')
            }).off('mouseleave').on('mouseleave', function() {
                if (currentRate !== '') {
                    stars.eq(currentRate).addClass('__active').prevAll().addClass('__active')
                }
                stars.removeClass('__hover')
            }).off('click').on('click', function() {
                var $this = $(this)
                  , prevStars = $this.prevAll();
                $this.add(prevStars).addClass('__active');
                stars.removeClass('__hover');
                currentRate = $this.index();
                rateInput.attr('value', currentRate + 1)
            })
        }
    })
}
initCommentsRating();
(function() {
    var menu = $('.productsMenu'), menuItem = $('.productsMenu-i, .j-submenu-item'), tabs = $('.productsMenu-tabs'), tabsContent = $('.productsMenu-tabs-content'), tabsList = $('.productsMenu-tabs-list'), submeniItemWidth = $('.productsMenu-submenu-i ').eq(0).outerWidth(!0), onMenu = !1, fadeTimeIn = 150, showTimer, changeTimerOn, changeTimerOff, hideTimer, menuTimer;
    if (!menu.length)
        return;
    var menuAim = tabsList.menuAim({
        closeDelay: 1000,
        activate: function(row) {
            var tab = toggleTabs(row)
              , $row = $(row);
            if (!tab) {
                $row.parents('.productsMenu-tabs').find('[id^="menu-tab-"]').removeClass('__visible');
                return !1
            }
            $row.parents('.productsMenu-tabs').find('[id^="menu-tab-"]').removeClass('__visible');
            $row.addClass('__hover');
            tab.addClass('__visible')
        },
        deactivate: function(row, exitMenu) {
            $(row).removeClass('__hover')
        },
        enter: function(row) {},
        exit: function(row) {},
        exitMenu: function($row) {
            return !1
        },
        rowSelector: ".productsMenu-tabs-list__tab",
        submenuSelector: "*",
        submenuDirection: "left"
    });
    function getSubmenuWidth() {
        var menuWidth = menu.width();
        menuItem.each(function() {
            var $this = $(this), itemPos = $this.position().left, itemWidth = $this.width(), submenu = $this.find('.productsMenu-submenu'), submenuTabs = $this.find('.productsMenu-tabs'), submenuTabsPos, submenuTabsList = $this.find('.productsMenu-tabs-list'), submenuItem = $this.find('.productsMenu-submenu-i'), submenuWrap = $this.find('.productsMenu-submenu-w'), submenuWidth = submenu.width(), submenuAvailableWidth = menuWidth;
            if (submenu.length > 0) {
                if (submenuTabsList.length && menu.length) {
                    submenu.addClass('__hasTabs');
                    if ((itemPos + itemWidth / 2) < menuWidth / 2) {
                        submenu.addClass('__pos_left');
                        submenuTabsList.data('MenuAim').setOption('submenuDirection', 'right');
                        submenu.css('left', itemPos);
                        submenuAvailableWidth = menuWidth - itemPos
                    } else {
                        submenu.addClass('__pos_right');
                        submenuTabsList.data('MenuAim').setOption('submenuDirection', 'left');
                        submenu.css({
                            'right': menuWidth - $this.position().left - $this.width(),
                            'left': 'auto'
                        });
                        submenuAvailableWidth = itemPos + itemWidth
                    }
                } else if (submenuTabsList.length && $('.products-menu').length) {
                    submenu.addClass('__hasTabs');
                    submenu.addClass('__pos_left');
                    submenuTabsList.data('MenuAim').setOption('submenuDirection', 'right');
                    submenu.css('left', itemPos);
                    submenuAvailableWidth = $('.header__wrapper').width()
                }
            }
            submenuWrap.each(function(i) {
                var $this = $(this);
                if (!$this.parents('.productsMenu-submenu').hasClass('__fluidGrid'))
                    return;
                var columnWidth = submeniItemWidth, submenuPaddings = parseFloat($this.css('padding-left')) + parseFloat($this.css('padding-right')), columnsWidth = 0, tabsWidth = 0, fullSubmenuWidth = 0, totalWidth = 0, totalHeight = 0, columnsNumber, columnGap = 20, columnMinHeight = 300, columnMaxHeight = 0;
                $this.show().find('.productsMenu-submenu-i').each(function() {
                    var _height = $(this).outerHeight(!0);
                    if (_height > columnMaxHeight) {
                        columnMaxHeight = _height
                    }
                    totalHeight += _height
                });
                $this.removeAttr('style');
                if (columnMaxHeight > columnMinHeight) {
                    columnsNumber = Math.ceil(totalHeight / columnMaxHeight)
                } else {
                    columnsNumber = Math.ceil(totalHeight / columnMinHeight)
                }
                columnsWidth = columnsNumber * columnWidth + (columnsNumber - 1) * columnGap;
                if (submenuTabs.length > 0) {
                    fullSubmenuWidth = columnsWidth + submenuTabsList.width() + submenuPaddings
                } else {
                    fullSubmenuWidth = columnsWidth + submenuPaddings
                }
                if (fullSubmenuWidth < submenuAvailableWidth) {
                    if (submenuTabs.length > 0) {
                        $this.width(columnsWidth);
                        submenuWidth = itemWidth
                    } else {
                        if (fullSubmenuWidth < itemWidth) {
                            submenu.width(itemWidth);
                            $this.width('auto');
                            submenuWidth = itemWidth
                        } else {
                            submenu.width('auto');
                            $this.width(columnsWidth);
                            submenuWidth = $this.outerWidth()
                        }
                    }
                } else {
                    if (submenuTabs.length > 0) {
                        var _columnsNumber = Math.floor((submenuAvailableWidth - submenuTabsList.width() + columnGap) / (columnWidth + columnGap));
                        var _columnsWidth = _columnsNumber * columnWidth + (_columnsNumber - 1) * columnGap;
                        $this.width(_columnsWidth)
                    } else {
                        $this.width('auto');
                        submenuWidth = menuWidth;
                        submenu.width(menuWidth)
                    }
                }
            });
            if (submenuTabsList.length === 0 && submenu.length > 0) {
                if ((itemPos + itemWidth / 2) < submenuWidth / 2) {
                    submenu.css('left', 0)
                } else if (menuWidth - (itemPos + itemWidth / 2) < submenuWidth / 2) {
                    submenu.css({
                        'right': 0,
                        'left': 'auto'
                    })
                } else {
                    submenu.css('left', itemPos + itemWidth / 2 - submenuWidth / 2)
                }
            }
        })
    }
    getSubmenuWidth();
    windowResizeHandler(getSubmenuWidth, 'productMenu');
    function getCellHeight() {
        var $items = $('.productsMenu-title')
          , menuHeight = 0;
        $items.height('auto');
        setTimeout(function() {
            menuHeight = $('.productsMenu').height();
            $items.each(function(i) {
                var $this = $(this);
                if ($this.height() < menuHeight) {
                    $this.height(menuHeight)
                }
            })
        }, 1)
    }
    getCellHeight();
    windowResizeHandler(getCellHeight, 'productsMenu-title', 1);
    function toggleTabs(row) {
        var $row = $(row)
          , target_id = $row.find('a').attr('data-target');
        if (typeof target_id === 'undefined' || target_id.length == 0)
            return !1;
        var tab = tabsContent.find('[id^="' + target_id + '"]');
        if (tab.length == 0)
            return !1;
        return tab
    }
    menuItem.mouseenter(function() {
        var $this = $(this);
        clearTimeout(changeTimerOn);
        clearTimeout(changeTimerOff);
        clearTimeout(hideTimer);
        clearTimeout(menuTimer);
        if (onMenu && $this.find('.productsMenu-submenu').index() > 0) {
            changeTimerOn = setTimeout(function() {
                menu.find('.productsMenu-submenu').removeClass('__visible');
                $this.find('.productsMenu-submenu').addClass('__visible')
            }, 50);
            menuItem.removeClass('__hover');
            $this.addClass('__hover')
        } else if (!onMenu && $this.find('.productsMenu-submenu').index() > 0) {
            showTimer = setTimeout(function() {
                $this.find('.productsMenu-submenu').addClass('__visible');
                $this.addClass('__hover');
                onMenu = !0
            }, 50);
            setTimeout(function() {
                menu.addClass('__onMenu')
            }, fadeTimeIn)
        } else {
            menuItem.find('.productsMenu-submenu').removeClass('__visible');
            menuItem.not($this).removeClass('__hover');
            $this.addClass('__hover');
            onMenu = !1
        }
    }).mouseleave(function() {
        var $this = $(this);
        if ($this.find('.productsMenu-submenu').index() > 0) {
            hideTimer = setTimeout(function() {
                menuItem.find('.productsMenu-submenu').removeClass('__visible');
                $this.removeClass('__hover');
                onMenu = !1
            }, 200)
        } else if ($this.find('.productsMenu-submenu').index() < 0) {
            $this.removeClass('__hover');
            menuItem.find('.productsMenu-submenu').removeClass('__visible')
        }
        clearTimeout(showTimer)
    });
    $('.productsMenu-submenu').hover(function() {
        clearTimeout(showTimer);
        clearTimeout(changeTimerOff)
    });
    menu.mouseleave(function() {
        menuTimer = setTimeout(function() {
            menu.removeClass('__onMenu')
        }, 200)
    });
    $('.j-productsMenu-toggleButton').on('click', function(e) {
        var $this = $(this);
        if ($('.productsMenu-submenu').hasClass('__visible')) {
            $this.trigger('mouseleave')
        } else {
            $this.trigger('mouseenter')
        }
        e.preventDefault()
    });
    var submenuNav = $('.productsMenu-submenu-nav')
      , submenuContent = $('.productsMenu-submenu');
    submenuNav.each(function() {
        $(this).find('a').eq(0).addClass('__hover')
    });
    submenuContent.each(function() {
        $(this).find('.productsMenu-submenu-content').eq(0).show()
    });
    submenuNav.find('a').mouseenter(function() {
        var $this = $(this);
        var index = $this.index();
        $this.siblings().removeClass('__hover');
        $this.addClass('__hover');
        $this.parent().siblings('.productsMenu-submenu-content').hide().eq(index).show()
    })
}
)();
(function() {
    var onMenu = !1
      , timeoutId = null;
    var $menu = $('.sideNav-list')
      , $parent = $('.sideNav-lv')
      , menu_height = $('#sideNav').outerHeight();
    $menu.menuAim({
        closeDelay: 1000,
        activate: function(row) {
            var $row = $(row)
              , category_id = $row.data('category-id')
              , height = $menu.outerHeight()
              , width = $menu.outerWidth()
              , $target_id = $row.find('[data-target-id=\"' + category_id + '\"]')
              , target_height = height - (parseFloat($target_id.css('padding-top')) + parseFloat($target_id.css('padding-bottom'))) - ((parseFloat($target_id.css('border-top-width')) + parseFloat($target_id.css('border-bottom-width'))));
            if (typeof category_id === 'undefined' || $target_id.length === 0)
                return !1;
            $row.addClass('__hover');
            var offset = $row.parents('.sideNav-list').hasClass('sideNav-lv') ? parseInt($row.parents('.sideNav-list').css('padding-top')) : 0;
            if ($target_id.outerHeight(!0) > $menu.outerHeight(!0) || !$('#sideNav').hasClass('sideNav-list--smart')) {
                $target_id.addClass('__visible').css({
                    'top': 0,
                    'height': 'auto',
                    'min-height': target_height
                })
            } else {
                if ($target_id.outerHeight(!0) > $row.parents('.sideNav-list').outerHeight(!0)) {
                    $target_id.addClass('__visible').css({
                        'top': 0,
                        'height': 'auto',
                        'min-height': $target_id.height()
                    })
                } else if ($row.parents('.sideNav-list').outerHeight(!0) - $row.position().top > $target_id.outerHeight(!0)) {
                    $target_id.addClass('__visible').css({
                        'height': 'auto',
                        'top': $row.position().top - offset
                    })
                } else {
                    $target_id.addClass('__visible').css({
                        'height': 'auto',
                        'top': 'auto',
                        'bottom': 0
                    })
                }
            }
            if ($target_id.outerHeight(!0) < $row.outerHeight(!0)) {
                $target_id.outerHeight($row.height())
            }
        },
        deactivate: function(row, exitMenu) {
            var $row = $(row)
              , category_id = $row.data('category-id');
            if (typeof category_id === 'undefined')
                return !1;
            function hide(e) {
                $row.removeClass('__hover');
                $row.find('[data-target-id=\"' + category_id + '\"]').removeClass('__visible')
            }
            hide()
        },
        enter: function(row) {},
        exit: function(row) {},
        exitMenu: function($row) {
            return !0
        },
        rowSelector: "> li",
        submenuSelector: "*",
        submenuDirection: "right"
    })
}
)();
(function() {
    var brands = $('.frontBrands-container')
      , brandsList = $('.frontBrands-list')
      , blockHeight = brandsList.height()
      , items = $('.frontBrands-i')
      , button = $('.frontBrands-expander').find('.btn')
      , isClosed = !0;
    if (!brands.length || !button.length) {
        return
    }
    brandsList.addClass('__toggle');
    button.on('click', function(e) {
        if (isClosed) {
            showMore()
        } else {
            hideMore()
        }
        e.preventDefault()
    });
    function showMore() {
        var curH = brandsList.height();
        var newH = brandsList.css('height', 'auto').height();
        brandsList.height(curH);
        brandsList.animate({
            'height': newH
        });
        button.children().text(button.data('button-text').hide);
        isClosed = !1
    }
    function hideMore() {
        brandsList.animate({
            'height': blockHeight
        });
        button.children().text(button.data('button-text').show);
        isClosed = !0
    }
    function brandsView() {
        var totalWidth = 0;
        items.each(function() {
            totalWidth += $(this).width()
        });
        if (brandsList.outerWidth() < totalWidth) {
            button.show()
        } else {
            button.hide();
            hideMore()
        }
    }
    brandsView();
    windowResizeHandler(brandsView, 'brands')
}
)();
(function() {
    var $user = $('.user');
    if ($user.is('.__logged')) {
        var timerOut;
        $user.on('mouseenter', function() {
            clearTimeout(timerOut);
            $(this).addClass('__hovered').find('.user-menu').fadeIn(150)
        }).on('mouseleave', function() {
            var $this = $(this);
            clearTimeout(timerOut);
            timerOut = setTimeout(function() {
                $this.removeClass('__hovered').find('.user-menu').fadeOut(150)
            }, 500)
        });
        $('html').click(function() {
            $('.user-menu').fadeOut(150);
            clearTimeout(timerOut)
        });
        $user.click(function(e) {
            e.stopPropagation()
        })
    }
}
)();
function initFrontendSwipers() {
    var thumbsSwiper = new Swiper('.gallery-thumbnails-swipe',{
        slideClass: 'gallery-thumb',
        wrapperClass: 'gallery-thumbnails-list',
        slidesPerView: 'auto',
        speed: 400,
        direction: 'vertical',
        preventClicks: !0,
        preventClicksPropagation: !0,
        mousewheelControl: !0,
        freeMode: !0,
        freeModeMomentumRatio: 0.25,
        roundLengths: !0
    });
    $('.productSet-container').each(function() {
        var $this = $(this);
        if ($('.productSet-list-i', $this).length < 2)
            return;
        $this.swiper({
            wrapperClass: 'productSet-list',
            slideClass: 'productSet-list-i',
            loop: !0,
            speed: 400,
            preventClicks: !1,
            preventClicksPropagation: !1,
            pagination: '.productSet-pagination',
            bulletClass: 'productSet-pagination-bullet',
            bulletActiveClass: '__active',
            paginationClickable: !0,
            prevButton: $this.siblings('.j-carousel-btn-prev'),
            nextButton: $this.siblings('.j-carousel-btn-next'),
            buttonDisabledClass: '__disabled',
            simulateTouch: !1,
            roundLengths: !0,
            onInit: function(swiper) {
                var blockMaxHeight = 0;
                $('.productSet-content').each(function() {
                    var $this = $(this);
                    if ($this.height() > blockMaxHeight) {
                        blockMaxHeight = $this.height()
                    }
                }).height(blockMaxHeight)
            }
        })
    });
    $('.entries-container').each(function() {
        var $this = $(this);
        $this.swiper({
            wrapperClass: 'entries-list',
            slideClass: 'entries-i',
            slidesPerGroup: 1,
            slidesPerView: 'auto',
            speed: 400,
            preventClicks: !1,
            preventClicksPropagation: !1,
            prevButton: $this.siblings('.j-carousel-btn-prev'),
            nextButton: $this.siblings('.j-carousel-btn-next'),
            buttonDisabledClass: 'is-disabled',
            simulateTouch: !1,
            roundLengths: !0,
            onInit: function(swiper) {
                var $container = swiper.container;
                var $navigation = $container.siblings('.carousel-btn');
                var posButtonImage = $container.find('.entries-i-image');
                $(window).on('resize', function() {
                    if ($navigation && posButtonImage.length) {
                        $navigation.css({
                            top: (posButtonImage.outerHeight() / 2) - $navigation.first().height() / 2,
                            'margin-top': 0
                        })
                    }
                    if (swiper.virtualSize > swiper.width) {
                        $navigation.show()
                    } else {
                        $navigation.hide()
                    }
                }).resize()
            }
        })
    })
}
initFrontendSwipers();
$('.j-carousel').each(function() {
    var $this = $(this), $container = $('.j-carousel-container', $this), params = $this.data('swiperParams') || {}, defaults = {
        wrapperClass: 'j-carousel-wrapper',
        slideClass: 'j-carousel-item',
        slidesPerGroup: 1,
        slidesPerView: 'auto',
        speed: 400,
        preventClicks: !1,
        preventClicksPropagation: !1,
        prevButton: $('.j-carousel-btn-prev', $this),
        nextButton: $('.j-carousel-btn-next', $this),
        buttonDisabledClass: 'is-disabled',
        simulateTouch: !1,
        roundLengths: !0
    }, swiperInstance;
    params = $.extend(!0, {}, defaults, params);
    swiperInstance = $container.swiper(params);
    if (swiperInstance.snapGrid.length > 1) {
        swiperInstance.prevButton.show();
        swiperInstance.nextButton.show()
    }
});
function initProductSwipers() {
    $('.similarProducts .productsSlider-container, .product__related .productsSlider-container').each(function() {
        var $this = $(this);
        $this.swiper({
            wrapperClass: 'productsSlider-wrapper',
            slideClass: 'productsSlider-i',
            slidesPerGroup: 2,
            slidesPerView: 'auto',
            speed: 400,
            spaceBetween: 0,
            preventClicks: !1,
            preventClicksPropagation: !1,
            nextButton: $this.siblings('.slideCarousel-nav-btn.__slideRight'),
            prevButton: $this.siblings('.slideCarousel-nav-btn.__slideLeft'),
            buttonDisabledClass: '__disabled',
            simulateTouch: !1,
            roundLengths: !0,
            onInit: function(swiper) {
                var $container = swiper.container;
                var $navigation = $container.siblings('.slideCarousel-nav-btn');
                var posButtonImage = $container.find('.productsSlider-image');
                if ($navigation && posButtonImage.length) {
                    $navigation.css({
                        top: (posButtonImage.height() / 2) - $navigation.first().height() / 2,
                        'margin-top': 0
                    })
                }
                $(window).on('resize', function() {
                    if (swiper.virtualSize > swiper.width) {
                        swiper.container.addClass('__hr');
                        $navigation.show()
                    } else {
                        $navigation.hide()
                    }
                }).resize()
            },
            onSlideChangeStart: function(swiper) {
                if (swiper.isEnd) {
                    swiper.container.removeClass('__hr')
                } else {
                    swiper.container.addClass('__hr')
                }
                if (swiper.isBeginning) {
                    swiper.container.removeClass('__hl')
                } else {
                    swiper.container.addClass('__hl')
                }
            }
        })
    })
}
initProductSwipers();
function initCartSwipers() {
    $('.cart-recommended .productsSlider-container').each(function() {
        var $this = $(this);
        $this.swiper({
            wrapperClass: 'productsSlider-wrapper',
            slideClass: 'productsSlider-i',
            slidesPerGroup: 2,
            slidesPerView: 'auto',
            speed: 400,
            spaceBetween: 15,
            preventClicks: !1,
            preventClicksPropagation: !1,
            nextButton: $this.siblings('.slideCarousel-nav-btn.__slideRight'),
            prevButton: $this.siblings('.slideCarousel-nav-btn.__slideLeft'),
            buttonDisabledClass: '__disabled',
            simulateTouch: !1,
            roundLengths: !0,
            onInit: function(swiper) {
                var $container = swiper.container;
                var $navigation = $container.siblings('.slideCarousel-nav-btn');
                var posButtonImage = $container.find('.productsSlider-image');
                if ($navigation && posButtonImage.length) {
                    $navigation.css({
                        top: (posButtonImage.height() / 2) - $navigation.first().height() / 2,
                        'margin-top': 0
                    })
                }
                if (swiper.virtualSize > swiper.width) {
                    swiper.container.addClass('__hr');
                    $navigation.show()
                } else {
                    $navigation.hide()
                }
            },
            onSlideChangeStart: function(swiper) {
                if (swiper.isEnd) {
                    swiper.container.removeClass('__hr')
                } else {
                    swiper.container.addClass('__hr')
                }
                if (swiper.isBeginning) {
                    swiper.container.removeClass('__hl')
                } else {
                    swiper.container.addClass('__hl')
                }
            }
        })
    })
}
function initRecentProductsSwiper() {
    var $this = $('.recentProducts-container');
    $this.swiper({
        wrapperClass: 'recentProducts-wrapper',
        slideClass: 'recentProducts-i',
        slidesPerGroup: 2,
        slidesPerView: 'auto',
        speed: 400,
        spaceBetween: 0,
        preventClicks: !1,
        preventClicksPropagation: !1,
        nextButton: $this.siblings('.slideCarousel-nav-btn.__slideRight'),
        prevButton: $this.siblings('.slideCarousel-nav-btn.__slideLeft'),
        buttonDisabledClass: '__disabled',
        simulateTouch: !1,
        roundLengths: !0,
        onInit: function(swiper) {
            var $container = swiper.container;
            var $navigation = $container.siblings('.slideCarousel-nav-btn');
            var posButtonImage = $container.find('.recentProducts-image');
            if ($navigation && posButtonImage.length) {
                $navigation.css({
                    top: (posButtonImage.height() / 2) - $navigation.first().height() / 2,
                    'margin-top': 0
                })
            }
            $(window).on('resize', function() {
                if (swiper.virtualSize > swiper.width) {
                    swiper.container.addClass('__hr');
                    $navigation.show()
                } else {
                    $navigation.hide()
                }
            }).resize()
        },
        onSlideChangeStart: function(swiper) {
            if (swiper.isEnd) {
                swiper.container.removeClass('__hr')
            } else {
                swiper.container.addClass('__hr')
            }
            if (swiper.isBeginning) {
                swiper.container.removeClass('__hl')
            } else {
                swiper.container.addClass('__hl')
            }
        }
    })
}
function initCategoriesSwiper() {
    var $this = $('.frontCategories-wrapper');
    $this.swiper({
        wrapperClass: 'frontCategories-list',
        slideClass: 'frontCategories-i',
        slidesPerGroup: 2,
        slidesPerView: 'auto',
        speed: 400,
        spaceBetween: 0,
        preventClicks: !1,
        preventClicksPropagation: !1,
        nextButton: $this.siblings('.slideCarousel-nav-btn.__slideRight'),
        prevButton: $this.siblings('.slideCarousel-nav-btn.__slideLeft'),
        buttonDisabledClass: '__disabled',
        simulateTouch: !1,
        roundLengths: !0,
        onInit: function(swiper) {
            var $container = swiper.container;
            var $navigation = $container.siblings('.slideCarousel-nav-btn');
            var posButtonImage = $container.find('.frontCategories-image');
            if ($navigation && posButtonImage.length) {
                $navigation.css({
                    top: (posButtonImage.height() / 2) - $navigation.first().height() / 2,
                    'margin-top': 0
                })
            }
            $(window).on('resize', function() {
                if (swiper.virtualSize > swiper.width) {
                    $navigation.show()
                } else {
                    $navigation.hide()
                }
            }).resize()
        }
    })
}
initCategoriesSwiper();
function windowResizeHandler(func, namespace, delay, onload) {
    delay = delay || 300;
    onload = onload || !1;
    var timer;
    $(window).off('resize.' + namespace).on('resize.' + namespace, function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            func()
        }, delay)
    });
    if (onload) {
        func()
    }
}
(function() {
    $('.form-item-opener').click(function() {
        $(this).hide().siblings('.field').show()
    })
}
)();
function filterScrollInit() {
    var $filter = $('.filter');
    if ($filter.length < 1)
        return;
    if ($filter.hasClass('__listScroll')) {
        var visibleItems = $('.filter').data('scroll-visible');
        $('.j-filter-list').each(function(i) {
            var $this = $(this)
              , $listItems = $this.find('.filter-lv1-i')
              , isClosed = $this.parents('.filter-section').hasClass('__closed') || !1
              , visibleHeight = 0;
            if (isClosed) {
                $this.removeClass('is-hidden')
            }
            visibleHeight = visibleItems * $listItems.eq(0).outerHeight(!0) - parseFloat($listItems.eq(0).css('margin-bottom'));
            $listItems.each(function(i) {
                var _$this = $(this);
                if (_$this.find('.filter-multi-lv .filter-check.__active').length) {
                    $('.filter-multi-lv', _$this).addClass('__visible').show();
                    $('.filter-multi', _$this).find('.checkbox').addClass('__indeterminate');
                    if ($this.find('.filter-multi-lv .filter-check.__active').length === _$this.find('.filter-multi-lv-i').length) {
                        $('.filter-multi', _$this).find('.checkbox').removeClass('__indeterminate')
                    }
                }
            });
            var openedFilters = $('.filter-lv1-i', this).length + $('.filter-multi-lv.__visible .filter-multi-lv-i').length;
            $this.off('click.filterToggle').on('click.filterToggle', '.filter-multi-toggle', function(e) {
                var _$this = $(this)
                  , $list = _$this.parents('.filter-multi').siblings('.filter-multi-lv')
                  , $parent = _$this.parents('.j-filter-list');
                $list.stop(!0, !0).slideToggle(200, function() {
                    $list.trigger('filter.animationDone')
                }).toggleClass('__visible');
                if ($list.hasClass('__visible')) {
                    openedFilters += $list.find('.filter-multi-lv-i').length;
                    if (openedFilters > visibleItems && typeof $parent.data('jsp') === 'undefined') {
                        $parent.height(visibleHeight).addClass('__jsp').jScrollPane()
                    }
                } else {
                    openedFilters -= $list.find('.filter-multi-lv-i').length
                }
                $list.off('filter.animationDone').on('filter.animationDone', function() {
                    if (!$parent.data('jsp'))
                        return;
                    if ($list.hasClass('__visible')) {
                        $parent.data('jsp').reinitialise()
                    } else {
                        if (openedFilters > visibleItems) {
                            $parent.data('jsp').reinitialise()
                        } else {
                            $parent.data('jsp').destroy();
                            $this.height('auto').removeClass('__jsp')
                        }
                    }
                });
                e.preventDefault()
            });
            if ($this.height() > visibleHeight) {
                $this.height(visibleHeight);
                $this.jScrollPane()
            }
            if (isClosed) {
                $this.addClass('is-hidden')
            }
        });
        $('.j-filter-color').each(function(i) {
            var $this = $(this)
              , $listItems = $this.find('.filter-color-i')
              , isClosed = $this.parents('.filter-section').hasClass('__closed') || !1
              , visibleHeight = 0;
            if (isClosed) {
                $this.removeClass('is-hidden')
            }
            visibleHeight = visibleItems * $listItems.eq(0).outerHeight(!0);
            if ($this.height() > visibleHeight) {
                $this.height(visibleHeight);
                $this.jScrollPane()
            }
            if (isClosed) {
                $this.addClass('is-hidden')
            }
        })
    }
    if ($filter.hasClass('__listToggle')) {
        var visibleItems = $filter.data('toggle-visible')
          , $showText = $filter.data('toggle-text').show
          , $hideText = $filter.data('toggle-text').hide;
        $('.filter-lv1').each(function() {
            var $this = $(this)
              , $listItems = $this.find('.filter-lv1-i')
              , $showTextLocal = $showText
              , listItemsLength = $listItems.length
              , isClosed = $this.parents('.filter-section').hasClass('__closed') || !1
              , visibleHeight = 0;
            if (isClosed) {
                $this.parent().removeClass('is-hidden')
            }
            $listItems.each(function(i) {
                if (i > visibleItems - 1)
                    return;
                visibleHeight += $(this).outerHeight(!0)
            });
            if (listItemsLength > visibleItems + 1) {
                var initialHeight = $this.height()
                  , hiddenItemsLength = listItemsLength - visibleItems
                  , opened = !1
                  , animationSpeed = 200;
                $showTextLocal += ' ' + hiddenItemsLength;
                $this.height(visibleHeight).addClass('__toggle');
                var $toggleLink = $('<a class="filter-toggle a-pseudo" />').html($showTextLocal).off('click').click(function() {
                    if (opened) {
                        $this.animate({
                            height: visibleHeight
                        }, animationSpeed);
                        $toggleLink.html($showTextLocal);
                        opened = !1
                    } else {
                        $this.animate({
                            height: initialHeight
                        }, animationSpeed);
                        $toggleLink.html($hideText);
                        opened = !0
                    }
                });
                if ($this.parents(".filter-section:eq(0)").find('.filter-toggle.a-pseudo').length === 0) {
                    $this.after($toggleLink)
                }
            }
            if (isClosed) {
                $this.parent().addClass('is-hidden')
            }
            $this.off('click.filterToggle').on('click.filterToggle', '.filter-multi-toggle', function(e) {
                var _$this = $(this)
                  , $list = _$this.parents('.filter-multi').siblings('.filter-multi-lv')
                  , listHeight = $list.outerHeight()
                  , $parentList = _$this.parents('.filter-lv1');
                if ($list.is(':hidden')) {
                    $list.show();
                    listHeight = $list.outerHeight();
                    $list.hide();
                    $parentList.animate({
                        'height': $parentList.height() + listHeight
                    }, 200);
                    if (_$this.parents('.filter-lv1-i').index < visibleItems) {
                        visibleHeight += listHeight
                    }
                    initialHeight += listHeight
                } else {
                    $parentList.animate({
                        'height': $parentList.height() - listHeight
                    }, 200);
                    if (_$this.parents('.filter-lv1-i').index < visibleItems) {
                        visibleHeight -= listHeight
                    }
                    initialHeight -= listHeight
                }
                $list.stop(!0, !0).slideToggle(200, function() {
                    $list.trigger('filter.animationDone')
                }).toggleClass('__visible');
                e.preventDefault()
            })
        });
        $('.filter-color-list').each(function() {
            var $this = $(this)
              , $listItems = $this.find('.filter-color-i')
              , $showTextLocal = $showText
              , listItemsLength = $listItems.length
              , isClosed = $this.parents('.filter-section').hasClass('__closed') || !1
              , itemsInRow = 0
              , visibleHeight = 0;
            if (isClosed) {
                $this.parent().removeClass('is-hidden')
            }
            itemsInRow = Math.floor($this.width() / $listItems.eq(0).outerWidth(!0));
            $listItems.each(function(i) {
                if (i > visibleItems - 1)
                    return;
                visibleHeight += $(this).outerHeight(!0)
            });
            if (listItemsLength > itemsInRow * visibleItems) {
                var initialHeight = $this.height()
                  , hiddenItemsLength = listItemsLength - itemsInRow * visibleItems
                  , opened = !1
                  , animationSpeed = 200;
                $showTextLocal += ' ' + hiddenItemsLength;
                $this.height(visibleHeight).addClass('__toggle');
                var $toggleLink = $('<a class="filter-toggle a-pseudo" />').html($showTextLocal).off('click').click(function() {
                    if (opened) {
                        $this.animate({
                            height: visibleHeight
                        }, animationSpeed);
                        $toggleLink.html($showTextLocal);
                        opened = !1
                    } else {
                        $this.animate({
                            height: initialHeight
                        }, animationSpeed);
                        $toggleLink.html($hideText);
                        opened = !0
                    }
                });
                if ($this.parents(".filter-section:eq(0)").find('.filter-toggle.a-pseudo').length === 0) {
                    $this.after($toggleLink)
                }
            }
            if (isClosed) {
                $this.parent().addClass('is-hidden')
            }
        })
    }
    var initFilterDropList = function() {
        $('.j-filter-collapse-trigger').off('click.filterCollapse').on('click.filterCollapse', function(e) {
            var $this = $(this)
              , $section = $this.parents('.filter-section');
            if ($section.hasClass('__closed')) {
                $section.find('.j-filter-list, .j-filter-color').slideDown(150, function() {
                    $(this).removeClass('is-hidden').css('display', '');
                    $section.trigger('opened')
                });
                $section.removeClass('__closed')
            } else {
                $section.find('.j-filter-list, .j-filter-color').slideUp(150, function() {
                    $(this).addClass('is-hidden').css('display', '');
                    $section.trigger('closed')
                });
                $section.addClass('__closed')
            }
            e.preventDefault()
        })
    };
    if ($('.j-filter-collapsing').length) {
        initFilterDropList()
    }
}
filterScrollInit();
(function() {
    var filtersState = [];
    var setFiltersState = function(selector, index) {
        if (typeof index === 'undefined') {
            $(selector).each(function() {
                if ($(this).hasClass('__closed')) {
                    filtersState.push('closed')
                } else {
                    filtersState.push('opened')
                }
            })
        } else {
            filtersState[index] = $(selector).eq(index).hasClass('__closed') ? 'closed' : 'opened'
        }
    };
    setFiltersState('.j-filter-collapsing');
    var statesEventsInit = function() {
        $('.j-filter-collapsing').on('opened', function() {
            var self = this;
            var $this = $(this);
            sendAjax(GLOBAL.URI_PREFIX + '_widget/catalog_filter/setExpandedState/', {
                'filterId': $this.data('filter-id'),
                'expand': 1
            }, function(status, response) {});
            setFiltersState('.j-filter-collapsing', $('.j-filter-collapsing').index(self))
        }).on('closed', function() {
            var $this = $(this);
            var self = this;
            sendAjax('/_widget/catalog_filter/setExpandedState/', {
                'filterId': $this.data('filter-id'),
                'expand': 0
            }, function(status, response) {});
            setFiltersState('.j-filter-collapsing', $('.j-filter-collapsing').index(self))
        })
    };
    statesEventsInit();
    CatalogBuilder.attachEventHandler('onChange', statesEventsInit);
    CatalogBuilder.attachEventHandler('onAfterCache', function() {
        $('.j-filter-collapsing').each(function(i) {
            var $this = $(this);
            if (filtersState[i] === 'closed') {
                $this.addClass('__closed __no-transition').find('.j-filter-list').addClass('is-hidden');
                setTimeout(function() {
                    $this.removeClass('__no-transition')
                }, 1)
            } else {
                $this.addClass('__no-transition').removeClass('__closed').find('.j-filter-list').removeClass('is-hidden');
                setTimeout(function() {
                    $this.removeClass('__no-transition')
                }, 1)
            }
        })
    })
}
)();
function filterItemScrollInit() {
    var $filter = $('.filter--checkbox');
    if ($filter.length < 1)
        return;
    if ($filter.hasClass('__listFilterScroll')) {
        $filter.addClass('__jsp').jScrollPane({
            autoReinitialise: !0
        })
    } else {
        $filter.addClass('__jsp').jScrollPane()
    }
}
filterItemScrollInit();
(function() {
    var windowWidth = $(window).width();
    $(window).on('resize', function() {
        var $filter = $('.filter--checkbox');
        if ($filter.length < 1 || windowWidth === $(window).width())
            return;
        if ($filter.data('jsp')) {
            $filter.data('jsp').destroy()
        }
        windowWidth = $(window).width();
        setTimeout(function() {
            filterItemScrollInit()
        }, 300)
    })
}
)();
(function(Face) {
    Face.productTooltip = function() {
        var $hint = $('.product-hint, .j-product-hint');
        $hint.each(function() {
            var $this = $(this), $btn = $this.find('.product-hint-btn'), $tooltip = $this.find('.product-tooltip'), $box = $this.find('.product-tooltip-box'), visible = !1, position = $(this).data('position'), timer1;
            if ($tooltip.length === 0)
                return;
            function showTooltip() {
                $hint.css('z-index', 901);
                var css = {};
                switch (position) {
                case 'left':
                    css = {
                        'left': -$this.position().left - parseFloat($this.css('margin-left')) - 1
                    };
                    break;
                case 'right':
                    css = {
                        'left': $this.position().left + parseFloat($this.css('margin-left')) + $tooltip.width() - $box.width() + 10
                    };
                    break;
                default:
                    css = {
                        'left': -$this.position().left - parseFloat($this.css('margin-left')) - 1
                    }
                }
                $box.css(css);
                $tooltip.addClass('__visible');
                visible = !0;
                if ($tooltip.offset().top < $(window).scrollTop()) {
                    $('body, html').animate({
                        scrollTop: $tooltip.offset().top
                    }, 200)
                }
            }
            function hideTooltip() {
                $this.css('z-index', 0);
                $tooltip.removeClass('__visible');
                clearTimeout(timer1);
                visible = !1
            }
            $(document).on('click', function(e) {
                if (!$(e.target).closest($this).length && visible) {
                    hideTooltip()
                }
            });
            $btn.on('click', function() {
                if (!visible) {
                    showTooltip()
                } else {
                    hideTooltip()
                }
            })
        })
    }
}
)(window.Face = window.Face || {});
Face.productTooltip();
$(function() {
    AjaxCart.getInstance().attachEventHandlers({
        'onReloadHtml': Face.productTooltip,
        'onInit': Face.productTooltip
    });
    window.CheckoutModule && CheckoutModule.getInstance().attachEventHandlers({
        'afterAjax': Face.productTooltip
    })
});
(function(Face, w, d) {
    var Popover = function(elem, options) {
        if (!(this instanceof Popover)) {
            return new Popover(elem,options)
        }
        this.$elem = $(elem);
        if (!this.$elem.length)
            return;
        if (!$(this.$elem).data('face_popover')) {
            $(this.$elem).data('face_popover', this)
        }
        this.options = $.extend(options, Popover.defaults);
        this.trigger = this.options.trigger;
        this.$trigger = $(this.trigger);
        this.init()
    };
    Popover.prototype = {
        visible: !1,
        cache: {},
        $activePopover: null,
        $button: null,
        init: function() {
            this.cacheItems();
            this.bindEvents()
        },
        cacheItems: function() {
            var self = this;
            this.$elem.each(function() {
                var $this = $(this);
                self.cache[$this.attr('id')] = $this;
                $this.appendTo(Face.$BODY);
                if ($this.find('img').length) {
                    $this.imagesLoaded(function() {
                        self.cache[$this.attr('id')].height = $this.outerHeight();
                        setTimeout(function() {
                            self.$elem.detach()
                        })
                    })
                } else {
                    self.cache[$this.attr('id')].height = $this.outerHeight();
                    self.$elem.detach()
                }
            })
        },
        bindEvents: function() {
            var self = this, timer, $trigger;
            $(d).off('click.popover').on('click.popover', this.trigger, function(e) {
                var $this = $(this);
                var dataAttr = /(\[data-)/.test(self.trigger) && self.trigger.replace(/(data-)/, '').slice(1, -1);
                var id = dataAttr && $this.data(dataAttr) !== '' ? $this.data(dataAttr) : $this.attr('href').substring(1);
                self.$button = $trigger = $this;
                if (!self.visible) {
                    self.setPosition($this, id);
                    self.show(id);
                    $this.data('active', !0)
                } else {
                    self.hide();
                    if ($(e.target).closest(self.$trigger).length && !$this.data('active')) {
                        self.setPosition($this, id);
                        self.show(id)
                    }
                    $this.data('active', !1)
                }
                e.preventDefault()
            });
            this.$elem.on('mouseleave', function() {
                timer = setTimeout(function() {
                    if (this.visible) {
                        self.hide()
                    }
                }, 1500)
            });
            this.$elem.on('mouseover', function() {
                clearTimeout(timer)
            });
            $(window).off('click.popover').on('click.popover', function(e) {
                if (!$(e.target).closest(self.$trigger).length && self.visible) {
                    self.hide()
                }
            });
            $(document).scroll(function() {
                if (!self.visible)
                    return;
                self.setPosition($trigger, self.$activePopover.attr('id'))
            })
        },
        setPosition: function(trigger, id) {
            var self = this
              , $popover = $(self.cache[id]);
            $popover.css({
                top: trigger.offset().top - this.cache[id].height - 10,
                left: trigger.offset().left - 30
            });
            if ($popover.find('img').length) {
                $popover.imagesLoaded(function() {
                    self.cache[id].height = $popover.outerHeight();
                    $popover.css({
                        top: trigger.offset().top - self.cache[id].height - 10,
                        left: trigger.offset().left - 30
                    })
                })
            }
        },
        show: function(id) {
            $(this.cache[id]).appendTo(Face.$BODY).addClass('is-visible');
            this.$activePopover = $(this.cache[id]);
            this.visible = !0
        },
        hide: function() {
            this.$activePopover.removeClass('is-visible').detach();
            this.visible = !1
        },
        updatePosition: function(id) {
            var self = this
              , $button = $('[data-popover="' + id + '"]')
              , $popover = $(this.cache[id]);
            self.cache[id].height = $popover.outerHeight();
            $popover.css({
                top: $button.offset().top - this.cache[id].height - 10,
                left: $button.offset().left - 30
            });
            if ($popover.find('img').length) {
                $popover.imagesLoaded(function() {
                    self.cache[id].height = $popover.outerHeight();
                    $popover.css({
                        top: $button.offset().top - self.cache[id].height - 10,
                        left: $button.offset().left - 30
                    })
                })
            }
        }
    };
    Popover.defaults = {
        'trigger': '[data-popover]'
    };
    Face.Popover = Popover
}
)(window.Face = window.Face || {}, window, document);
Face.filterTooltip = function() {
    Face.Popover('.filter .js-popover')
}
;
Face.filterTooltip();
$.fn.dropdownToggle = function(options) {
    var defaults = {
        parentNode: $('body'),
        visibleClass: '__visible',
        hoverClass: '__hover',
        speed: 150
    };
    var options = $.extend(defaults, options);
    $(this).each(function() {
        var $menu = $(this), $toggle = $menu.siblings('a'), speed = options.speed, $parentNode = options.parentNode, hoverClass = options.hoverClass, visibleClass = options.visibleClass, isVisible = !1, timerOut;
        if ($menu.length !== 0 && !$menu.is(':hidden')) {
            $menu.detach()
        }
        $toggle.on('click', function(e) {
            if (!isVisible) {
                showMenu()
            } else {
                hideMenu()
            }
            e.preventDefault()
        });
        $menu.add($toggle).on('mouseleave', function() {
            if (isVisible) {
                clearTimeout(timerOut);
                timerOut = setTimeout(function() {
                    hideMenu()
                }, 1000)
            }
        }).on('mouseenter', function() {
            clearTimeout(timerOut)
        });
        $('html').click(function() {
            hideMenu()
        });
        $menu.add($toggle).click(function(e) {
            e.stopPropagation()
        });
        function showMenu() {
            clearTimeout(timerOut);
            $toggle.addClass(hoverClass);
            $menu.addClass(visibleClass);
            $menu.appendTo($parentNode);
            $menu.css({
                'top': $toggle.offset().top + $toggle.outerHeight(),
                'left': $toggle.offset().left - ($menu.width() - $toggle.width()) / 2
            });
            setTimeout(function() {
                isVisible = !0
            }, speed)
        }
        function hideMenu() {
            $toggle.removeClass(hoverClass);
            $menu.removeClass(visibleClass);
            setTimeout(function() {
                $menu.detach();
                isVisible = !1
            }, speed);
            clearTimeout(timerOut)
        }
    });
    return this
}
;
$('.currencySelect-dropdown').dropdownToggle();
function topMenuDropdown(menu) {
    $(menu).each(function() {
        var $menu = $(this)
          , menuWidth = 0
          , $menuItems = $('.header-menu-i', $menu)
          , menuItemsWidth = []
          , siblingsWidth = 0
          , freeWidth = 0
          , $dropdownToggle = null
          , menuItemsNum = 0
          , menuFullWidth = 0;
        $menuItems.each(function() {
            menuFullWidth += $(this).outerWidth(!0);
            menuItemsWidth.push($(this).outerWidth(!0))
        });
        $menu.siblings().each(function() {
            if ($(this).is(':hidden'))
                return;
            siblingsWidth += $(this).outerWidth(!0)
        });
        var $submenu = null;
        function submenuInit() {
            menuWidth = $menu.width();
            freeWidth = $menu.parent().width() - siblingsWidth - parseFloat($menu.css('padding-left'));
            if (menuFullWidth < freeWidth && $submenu) {
                if ($dropdownToggle) {
                    $dropdownToggle.remove();
                    $dropdownToggle = null
                }
                addMenuItems($menuItems.length);
                menuWidth = $menu.width();
                $menu.removeClass('__full')
            }
            if (menuFullWidth > freeWidth) {
                var menuLength = $menuItems.length
                  , submenuItemsNum = 0
                  , menuNewWidth = menuFullWidth
                  , submenuContent = [];
                if (!$submenu) {
                    $submenu = $('<ul class="submenu" />')
                } else {
                    $submenu.children().remove()
                }
                $menu.addClass('__full');
                if (!$dropdownToggle) {
                    $dropdownToggle = $menuItems.last().clone().css({
                        'position': 'relative'
                    }).appendTo($menu);
                    $dropdownToggle.find('a').addClass('a-toggle').html('<span class="a-pseudo">' + $menu.data('submenu-toggle') + '<i class="icon-arrowDown"></i></span>')
                }
                freeWidth -= $dropdownToggle.outerWidth(!0);
                for (var i = menuLength - 1; i > 0; i--) {
                    if (menuNewWidth <= freeWidth) {
                        break
                    }
                    menuNewWidth -= menuItemsWidth[i];
                    submenuContent.unshift($menuItems.eq(i).html());
                    submenuItemsNum++
                }
                menuItemsNum = menuLength - submenuItemsNum;
                $.each(submenuContent, function(i, val) {
                    $menuItems.eq(-i - 1).remove();
                    $submenu.append('<li class="submenu-i">' + val + '</li>')
                });
                $submenu.appendTo($dropdownToggle).dropdownToggle();
                addMenuItems(menuItemsNum)
            } else {
                $menu.addClass('__full')
            }
        }
        function addMenuItems(num) {
            $menuItems.each(function(i) {
                if ($(this).parent($menu).length === 0 && i <= num - 1) {
                    $(this).insertAfter($menu.children().eq(i - 1))
                }
            })
        }
        function submenuUpdate() {
            menuWidth = $menu.width();
            if (menuFullWidth > menuWidth) {
                if (sumbmenuOn) {}
            }
        }
        submenuInit();
        windowResizeHandler(submenuInit, 'headerMenu', 300)
    })
}
topMenuDropdown('.header-menu');
(function(Face) {
    'use strict';
    Face.compareLayout = {
        container: '.compare-container',
        scrollScreen: '.compare-window',
        header: '.compare-header',
        body: '.compare-body',
        table: '.compare-table',
        sidebar: '.compare-sidebar',
        init: function() {
            var $container = $(this.container)
              , $header = $(this.header)
              , $body = $(this.body)
              , $table = $(this.table)
              , $window = $(this.scrollScreen)
              , $sidebar = $(this.sidebar);
            if ($container.length === 0)
                return;
            $body.css('padding-top', $header.outerHeight());
            $table.parent().width($table.width());
            var $tableClone = $table.clone().appendTo($sidebar);
            var sidebarTop = $header.outerHeight();
            var scrollbarWidth = this.getScrollWidth();
            $sidebar.css({
                'width': $table.find('td:first-child').innerWidth(),
                'top': sidebarTop,
                'bottom': scrollbarWidth
            });
            var lastScrollLeft = 0;
            $window.scroll(function() {
                $sidebar.css('top', sidebarTop - $window.scrollTop());
                var $topShadow = $('.compare-topShadow', $body).length ? $('.compare-topShadow', $body) : $('<div class="compare-topShadow" />').appendTo($body).css({
                    'top': sidebarTop,
                    'right': scrollbarWidth
                });
                if ($window.scrollTop() === 0) {
                    $topShadow.remove()
                }
                var documentScrollLeft = $window.scrollLeft();
                if (lastScrollLeft != documentScrollLeft) {
                    var $sideShadow = $('.compare-sideShadow', $body).length ? $('.compare-sideShadow', $body) : $('<div class="compare-sideShadow" />').appendTo($body);
                    if (documentScrollLeft === 0) {
                        $sideShadow.remove()
                    }
                    lastScrollLeft = documentScrollLeft
                }
            });
            $table.add($tableClone).find('tbody tr').hover(function() {
                var hoverRowIndex = $(this).index();
                $table.add($tableClone).find('tr').removeClass('is-hover');
                $tableClone.find('tbody tr').eq(hoverRowIndex).addClass('is-hover');
                $table.find('tbody tr').eq(hoverRowIndex).addClass('is-hover')
            }, function() {
                $table.add($tableClone).find('tr').removeClass('is-hover')
            })
        },
        getScrollWidth: function() {
            var parent, child, width;
            if (width === undefined) {
                parent = $('<div style="position:absolute;top:0;left:0;visibility: hidden;width:50px;height:50px;overflow:auto"><div/></div>').appendTo('body');
                child = parent.children();
                width = child.innerWidth() - child.height(99).innerWidth();
                parent.remove()
            }
            return width
        }
    }
}
)(window.Face = window.Face || {});
Face.compareLayout.init();
(function(Face) {
    'use strict'
}
)(window.Face = window.Face || {});
(function() {
    if (Modernizr.objectfit)
        return;
    $('.banner-image.__cover').each(function() {
        var $this = $(this);
        var $img = $this.find('img.banner-img');
        $img.imagesLoaded().done(function() {
            $this.css('background-image', 'url(' + $img.attr('src') + ')');
            $img.remove()
        })
    })
}
)();
$(function() {
    var $upButton = $('#upButton')
      , offset = 350;
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > offset) {
            $upButton.stop().animate({
                bottom: '0'
            }, 300)
        } else {
            $upButton.stop().animate({
                bottom: -$upButton.height()
            }, 300)
        }
    }).scroll();
    $upButton.on('click', function(e) {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 300, function() {
            $upButton.stop().animate({
                bottom: -$upButton.height()
            }, 300)
        });
        return !1
    })
});
(function() {
    Face.animateToBasket = function(selector) {
        var cart = $('.j-basket-icon')
          , imgtodrag = $(selector).parents('.catalogCard').find('.catalogCard-img').eq(0)
          , imgWidth = imgtodrag.width()
          , imgHeight = imgtodrag.height();
        if (cart.length && imgtodrag.length) {
            var bezier_params = {
                start: {
                    x: imgtodrag.offset().left,
                    y: imgtodrag.offset().top,
                    angle: -90
                },
                end: {
                    x: cart.offset().left,
                    y: cart.offset().top - 20,
                    angle: 120,
                    length: 0.2
                }
            };
            var scale = +(cart.width() / imgWidth).toFixed(2);
            var imgclone = imgtodrag.clone().appendTo(Face.$BODY).css({
                position: 'absolute',
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left,
                width: imgWidth,
                height: imgHeight,
                opacity: 0.5,
                zIndex: 10000
            }).animate({
                path: new $.path.bezier(bezier_params),
                width: imgWidth * scale,
                height: imgHeight * scale
            }, 600, function() {
                imgclone.fadeOut(150, function() {
                    $(this).remove()
                })
            })
        }
    }
    ;
    if (GLOBAL.cart_animation) {
        BuyButton.attachEventHandler('onBeforeAdd', function() {
            Face.animateToBasket(this.clickedButton)
        })
    }
    if ($(location).attr('hash') == '#comment-form') {
        $("[rel='#comments']").trigger('click')
    }
}
)();
if (CatalogBuilder) {
    CatalogBuilder.attachEventHandler('onPaginationClick', function(button) {
        button.addClass('__loading is-loading').append('<div class="loader" />')
    });
    CatalogBuilder.attachEventHandler('onSortingClick', function(button) {
        button.addClass('__loading is-loading').append('<div class="loader" />')
    });
    CatalogBuilder.attachEventHandler('onLayoutToggleClick', function(button) {
        button.addClass('__loading is-loading').append('<div class="loader" />')
    })
}
(function() {
    Face.catalogListImages = function() {
        var $catalogList = $('.productsTable'), $currentImage = null, currentImageWidth, mouseOnTable = !1, catalogIsLoading = !1;
        if ($catalogList.length < 0)
            return;
        $catalogList.on('mouseenter.catalogListImages', 'tr', function(e) {
            var $this = $(this)
              , $image = $this.find('.productsTable-image');
            if ($image.length === 0 || $(e.target).hasClass('__buy') || $(e.target).parents('.productsTable-cell').hasClass('__buy'))
                return;
            $currentImage = $image.clone().appendTo(Face.$BODY);
            if (mouseOnTable) {
                $currentImage.show()
            } else {
                $currentImage.fadeIn(150);
                mouseOnTable = !0
            }
            currentImageWidth = $currentImage.outerWidth();
            $this.trigger('mousemove', e)
        }).on('mousemove.catalogListImages', 'tr', function(e, customE) {
            if (!$currentImage)
                return;
            if (customE != undefined) {
                e = customE
            }
            $currentImage.css({
                top: e.pageY + 15,
                left: (e.pageX + currentImageWidth + 35 > Face.windowWidth) ? Face.windowWidth - currentImageWidth - 20 : e.pageX + 15
            })
        }).on('mouseleave.catalogListImages', 'tr', function(e) {
            if (!$currentImage)
                return;
            if ($(e.relatedTarget).parents('.productsTable').length) {
                if (!mouseOnTable)
                    return;
                $currentImage.remove();
                $currentImage = null
            } else {
                $currentImage.fadeOut(150, function() {
                    if (!$currentImage || catalogIsLoading)
                        return;
                    $currentImage.remove();
                    $currentImage = null
                });
                mouseOnTable = !1
            }
        });
        $catalogList.on('mouseenter.catalogListImages', 'td.__buy', function(e) {
            if (!$currentImage || catalogIsLoading)
                return;
            $currentImage.fadeOut(150, function() {
                if (!$currentImage)
                    return;
                $currentImage.remove();
                $currentImage = null;
                mouseOnTable = !1
            })
        }).on('mouseleave.catalogListImages', 'td.__buy', function(e) {
            if ($(e.relatedTarget).parents('.productsTable').length && !catalogIsLoading) {
                $(this).parent().trigger('mouseenter')
            }
        });
        CatalogBuilder.attachEventHandler('onBeforeFollowLink', function() {
            catalogIsLoading = !0;
            $catalogList.off('mouseenter.catalogListImages mouseleave.catalogListImages')
        });
        CatalogBuilder.attachEventHandler('onChange', function() {
            catalogIsLoading = !1
        })
    }
    ;
    Face.catalogListImages()
}
)();
(function() {
    if (GLOBAL.content_copy_protection) {
        $(document).on("contextmenu", function(e) {
            if (!$(e.target).parents('.header, .footer, .contacts-content').length && !$(e.target).parents('.contacts-content').length)
                return !1
        });
        $(document).on('keydown', function(e) {
            if (e.keyCode == 67 && e.ctrlKey && !$(getSelectionParentElement()).parents('.header, .footer, .contacts-content').length) {
                return !1
            }
        });
        function getSelectionParentElement() {
            var parentEl = null, sel;
            if (window.getSelection) {
                sel = window.getSelection();
                if (sel.rangeCount) {
                    parentEl = sel.getRangeAt(0).commonAncestorContainer;
                    if (parentEl.nodeType != 1) {
                        parentEl = parentEl.parentNode
                    }
                }
            } else if ((sel = document.selection) && sel.type != "Control") {
                parentEl = sel.createRange().parentElement()
            }
            return parentEl
        }
    }
}
)();
(function(w) {
    if (/Android/.test(navigator.appVersion)) {
        w.addEventListener("resize", function() {
            if (w.document.activeElement.tagName === "INPUT" || document.activeElement.tagName === "TEXTAREA") {
                w.setTimeout(function() {
                    w.document.activeElement.scrollIntoViewIfNeeded()
                }, 0)
            }
        })
    }
}
)(window);
(function() {
    Face.showModificationLoader = function(instance, changedProp, caller) {
        var prop = instance.form.find('[name="param[' + changedProp + ']"]');
        prop.parents('.modification').find('.selectboxit').addClass('is-loading').after('<div class="loader">');
        prop.parents('.modification').find('.modification__button').filter(function() {
            return String($(this).data('value')) === prop.val()
        }).addClass('is-disabled').append('<div class="loader">');
        if ($(caller).hasClass('j-color-modification-change')) {
            $(caller).addClass('is-loading').append('<div class="loader">')
        }
    }
}
)();
(function() {
    $('.j-ribbon-banner-close').click(function(e) {
        var $this = $(this)
          , $banner = $this.parents('.j-ribbon-banner')
          , id = $banner.attr('data-id');
        $banner.remove();
        sendAjax('/_widget/horoshop_banners_widget/closeBanner', {
            'id': id
        });
        e.preventDefault();
        e.stopPropagation()
    })
}
)();
(()=>{
    document.querySelectorAll('.text table').forEach((item)=>{
        const parentTable = item.parentElement;
        if (!parentTable.classList.contains('table')) {
            const elTable = document.createElement('div');
            elTable.classList.add('table');
            parentTable.insertBefore(elTable, item);
            elTable.append(item)
        }
    }
    )
}
)();
/* /themes/horoshop_default/layout/js/frontend/catalog-builder-events.js */
(function($, CatalogBuilder) {
    if (CatalogBuilder.initialized) {
        var initEvents = function() {
            $('.j-catalog-sorting-button').off('.CatalogBuilder').on('click.CatalogBuilder', function(e) {
                var $this = $(this);
                if ($this.hasClass('is-active')) {
                    return
                }
                $this.siblings().removeClass('is-active');
                CatalogBuilder.trigger('onSortingClick', $this);
                CatalogBuilder.followLink($this.attr('data-sort-href'), !0, function() {
                    $this.addClass('is-active')
                });
                e.preventDefault()
            });
            $('.j-layout-toggle-button').off('.CatalogBuilder').on('click.CatalogBuilder', function(e) {
                var $this = $(this);
                if ($this.hasClass('is-active')) {
                    return
                }
                $this.siblings().removeClass('is-active');
                CatalogBuilder.trigger('onLayoutToggleClick', $this);
                CatalogBuilder.followLink($this.attr('data-layout-href'), !0, function() {
                    $this.addClass('is-active')
                });
                e.preventDefault()
            });
            $('.j-catalog-pagination-btn').off('.CatalogBuilder').on('click.CatalogBuilder', function(e) {
                var $this = $(this);
                if (!$this.is('.is-active') && !$this.is('.is-disabled')) {
                    CatalogBuilder.trigger('onPaginationClick', $this);
                    CatalogBuilder.followLink($(this).attr('href'), !0, function() {})
                }
                e.preventDefault()
            });
            $('.filter').find('a[href^="/"], a[' + window.FakeHrefDirector.DATA_ATTR_NAME + ']').not('.j-ignore').off('click.CatalogBuilder').on('click.CatalogBuilder', function(e) {
                var me = $(this);
                if (me.find('.checkbox').length) {
                    me.toggleClass('__active').find('.checkbox').toggleClass('__checked')
                }
                CatalogBuilder.trigger('onFilterLinkClick', me);
                CatalogBuilder.followLink(me.attr('href'));
                e.preventDefault()
            });
            CatalogBuilder.initAdditionalDataLoading();
            CatalogBuilder.trigger('onAfterInit')
        };
        initEvents();
        CatalogBuilder.attachEventHandler('onChange', initEvents)
    }
}
)(jQuery, CatalogBuilder);
