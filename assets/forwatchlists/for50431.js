(self.webpackChunktradingview = self.webpackChunktradingview || []).push([[50431, 5069], {
    591800: (t,e,n)=>{
        "use strict";
        n.d(e, {
            Modifiers: ()=>i,
            hashFromEvent: ()=>a,
            hashShiftPlusEnter: ()=>c,
            humanReadableHash: ()=>u,
            humanReadableModifiers: ()=>h,
            isMacKeyboard: ()=>o,
            modifiersFromEvent: ()=>r
        });
        var s = n(167175);
        const o = s.isMac || s.isIOS;
        var i;
        function r(t) {
            let e = 0;
            return t.shiftKey && (e += 1024),
            t.altKey && (e += 512),
            t.ctrlKey && (e += 256),
            t.metaKey && (e += 2048),
            e
        }
        function a(t) {
            return r(t) | t.keyCode
        }
        !function(t) {
            t[t.None = 0] = "None",
            t[t.Alt = 512] = "Alt",
            t[t.Shift = 1024] = "Shift",
            t[t.Mod = o ? 2048 : 256] = "Mod",
            t[t.Control = 256] = "Control",
            t[t.Meta = 2048] = "Meta"
        }(i || (i = {}));
        const c = /^(25242|32026|99362)$/.test(n.j) ? 1037 : null;
        function h(t, e=!o) {
            let n = "";
            return 256 & t && (n += d(o ? "^" : "Ctrl", e)),
            512 & t && (n += d(o ? "⌥" : "Alt", e)),
            1024 & t && (n += d(o ? "⇧" : "Shift", e)),
            2048 & t && (n += d(o ? "⌘" : "Win", e)),
            n
        }
        const l = {
            9: "⇥",
            13: "↵",
            27: "Esc",
            8: o ? "⌫" : "Backspace",
            32: "Space",
            35: "End",
            36: "Home",
            37: "←",
            38: "↑",
            39: "→",
            40: "↓",
            45: "Ins",
            46: "Del",
            188: ",",
            191: "/"
        };
        for (let t = 1; t <= 16; t++)
            l[t + 111] = `F${t}`;
        function u(t) {
            let e = h(t);
            const n = 255 & t;
            return e += n in l ? l[n] : String.fromCharCode(n),
            e
        }
        function d(t, e) {
            return `${t}${e ? " + " : o ? " " : ""}`
        }
    }
    ,
    745269: (t,e,n)=>{
        "use strict";
        n.d(e, {
            CubicBezier: ()=>i,
            color: ()=>r,
            dur: ()=>s,
            easingFunc: ()=>o
        });
        const s = 350
          , o = {
            linear: t=>t,
            easeInQuad: t=>t * t,
            easeOutQuad: t=>t * (2 - t),
            easeInOutQuad: t=>t < .5 ? 2 * t * t : (4 - 2 * t) * t - 1,
            easeInCubic: t=>t * t * t,
            easeOutCubic: t=>--t * t * t + 1,
            easeInOutCubic: t=>t < .5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1,
            easeInQuart: t=>t * t * t * t,
            easeOutQuart: t=>1 - --t * t * t * t,
            easeInOutQuart: t=>t < .5 ? 8 * t * t * t * t : 1 - 8 * --t * t * t * t,
            easeInQuint: t=>t * t * t * t * t,
            easeOutQuint: t=>1 + --t * t * t * t * t,
            easeInOutQuint: t=>t < .5 ? 16 * t * t * t * t * t : 1 + 16 * --t * t * t * t * t
        };
        class i {
            constructor(t, e, n, s) {
                this._mX1 = t,
                this._mY1 = e,
                this._mX2 = n,
                this._mY2 = s
            }
            easingFunc(t) {
                return this._mX1 === this._mY1 && this._mX2 === this._mY2 ? t : this._calcBezier(this._getTForX(t))
            }
            _a(t, e) {
                return 1 - 3 * e + 3 * t
            }
            _b(t, e) {
                return 3 * e - 6 * t
            }
            _c(t) {
                return 3 * t
            }
            _calcBezier(t) {
                return ((this._a(this._mY1, this._mY2) * t + this._b(this._mY1, this._mY2)) * t + this._c(this._mY1)) * t
            }
            _getSlope(t) {
                return 3 * this._a(this._mX1, this._mX2) * t * t + 2 * this._b(this._mX1, this._mX2) * t + this._c(this._mX1)
            }
            _getTForX(t) {
                let e = t;
                for (let n = 0; n < 4; ++n) {
                    const n = this._getSlope(e);
                    if (0 === n)
                        return e;
                    e -= (this._calcBezier(e) - t) / n
                }
                return e
            }
        }
        const r = {
            black70: "#4A4A4A",
            black80: "#535353"
        }
    }
    ,
    223124: (t,e,n)=>{
        "use strict";
        n.d(e, {
            isCancelled: ()=>i,
            makeCancelable: ()=>o
        });
        class s extends Error {
            constructor() {
                super("CancelToken")
            }
        }
        function o(t) {
            let e = !1;
            return {
                promise: new Promise(((n,o)=>{
                    t.then((t=>e ? o(new s) : n(t))),
                    t.catch((t=>o(e ? new s : t)))
                }
                )),
                cancel() {
                    e = !0
                }
            }
        }
        function i(t) {
            return t instanceof s
        }
    }
    ,
    779527: (t,e,n)=>{
        "use strict";
        n.d(e, {
            getDataFromTarget: ()=>_,
            getTooltip: ()=>m,
            hideTooltip: ()=>v,
            setStyle: ()=>g,
            showTooltip: ()=>p,
            updateTooltipTextFromTarget: ()=>d
        });
        var s = n(529111)
          , o = n(499994)
          , i = n(604286)
          , r = n(571690)
          , a = n(31341)
          , c = (n(586463),
        n(777466))
          , h = n(678515)
          , l = n(638456)
          , u = n(668477);
        function d(t) {
            const e = t.hasAttribute("data-tooltip") ? t.getAttribute("data-tooltip") : t.getAttribute("title");
            return e && ((0,
            o.setTooltipData)(t, "text", e),
            t.removeAttribute("title")),
            (0,
            o.getTooltipData)(t, "text") || ""
        }
        function _(t) {
            const e = d(t)
              , n = t.getBoundingClientRect()
              , s = {
                h: n.height,
                w: n.width,
                x: n.left,
                y: n.top
            }
              , o = t.getAttribute("data-color-theme") || ""
              , i = t.classList.contains("common-tooltip-html")
              , r = parseInt(t.getAttribute("data-tooltip-delay") || "")
              , a = parseInt(t.getAttribute("data-tooltip-debounce") || "");
            let c = {
                type: "none"
            };
            return e && (c = {
                type: i ? "html" : "text",
                data: e
            }),
            {
                above: t.classList.contains("common-tooltip-above"),
                below: t.classList.contains("common-tooltip-below"),
                otl: t.classList.contains("common-tooltip-otl"),
                otr: t.classList.contains("common-tooltip-otr"),
                vertical: t.classList.contains("common-tooltip-vertical"),
                hotkey: t.getAttribute("data-tooltip-hotkey"),
                narrow: t.classList.contains("common-tooltip-narrow"),
                wide: t.classList.contains("common-tooltip-wide"),
                colorTheme: o,
                tooltipDelay: r,
                tooltipDebounce: a,
                rect: s,
                content: c,
                target: t
            }
        }
        function m(t) {
            const e = w.cloneNode(!0)
              , n = P(e)
              , {content: s} = t;
            switch (s.type) {
            case "element":
                n.innerHTML = "",
                n.appendChild(s.data);
                break;
            case "html":
                n.innerHTML = s.data;
                break;
            case "text":
                if (t.hotkey) {
                    const t = y.cloneNode(!0);
                    t.innerText = s.data,
                    n.appendChild(t)
                } else
                    n.innerText = s.data
            }
            if (t.hotkey) {
                const e = "none" !== s.type
                  , o = E.cloneNode(!0)
                  , r = (0,
                i.hotKeyDeserialize)(t.hotkey)
                  , a = r.keys.map((t=>`<span class="${u["common-tooltip__hotkey-button"]}">${t}</span>`));
                o.innerHTML = function(t, e) {
                    const n = /{\d}|{hotkey_\d}/gi;
                    return t.replace(n, (t=>{
                        const n = Number(t.match(/\d/));
                        return e[n]
                    }
                    ))
                }(r.text, a).replace(/\s\+\s/g, `<span class="${u["common-tooltip__plus-sign"]}">+</span>`),
                n.classList.add(u["common-tooltip__body--with-hotkey"]),
                e && o.classList.add(u["common-tooltip__hotkey-block--divider"]),
                n.appendChild(o)
            }
            return e.addEventListener("contextmenu", c.preventDefault),
            e
        }
        function g(t, e) {
            const n = e.rect;
            if (!n)
                return;
            (0,
            s.setTooltipColorTheme)(t, e.colorTheme || "default"),
            e.addClass && t.classList.add(e.addClass);
            const o = P(t)
              , i = t.querySelector(`.${u["common-tooltip__button-container"]}`);
            o.classList.toggle(u["common-tooltip__body--width_wide"], Boolean(e.wide)),
            o.classList.toggle(u["common-tooltip__body--no-padding"], Boolean(e.noPadding)),
            o.classList.toggle(u["common-tooltip__body--width_narrow"], Boolean(e.narrow)),
            o.classList.toggle(u["common-tooltip__body--no-buttons"], !0),
            o.style.left = f(0),
            o.style.width = f(o.clientWidth + (Boolean(e.noPadding) ? 0 : 2));
            const r = document.body.clientWidth
              , c = l.CheckMobile.iOS() || l.CheckMobile.Android() || (0,
            l.supportTouch)() && (0,
            l.isMac)() ? window.innerHeight : document.body.clientHeight
              , d = e.vertical
              , _ = e.extendMargin || d && n.w < 20 || !d && n.h < 20;
            t.classList.toggle(u["common-tooltip--farther"], _),
            t.classList.toggle(u["common-tooltip--vertical"], d),
            t.classList.toggle(u["common-tooltip--horizontal"], !d);
            const m = function(t) {
                return t.querySelector(`.${u["common-tooltip__ear-holder"]}`)
            }(t)
              , g = t.offsetHeight;
            if (d) {
                const s = 10
                  , l = c - 10
                  , d = 12
                  , _ = s + d
                  , p = l - d
                  , v = (0,
                h.clamp)(n.y + n.h / 2, _, p) - g / 2
                  , S = v + g;
                t.style.left = f(n.x + n.w),
                t.style.top = f(v),
                v < s ? o.style.top = i.style.top = f(s - v) : S > l && (o.style.top = i.style.top = f(l - S));
                const {right: b} = (t.querySelector(":last-child") || o).getBoundingClientRect()
                  , C = b + 10 > r;
                t.classList.toggle(u["common-tooltip--direction_reversed"], C),
                t.classList.toggle(u["common-tooltip--direction_normal"], !C);
                let w = C ? "after" : "before";
                (0,
                a.isRtl)() ? (w = e.otr ? "after" : w,
                w = e.otl ? "before" : w) : (w = e.otr ? "before" : w,
                w = e.otl ? "after" : w),
                m.classList.toggle(u["common-tooltip__ear-holder--before"], "before" === w),
                m.classList.toggle(u["common-tooltip__ear-holder--after"], "after" === w),
                "after" === w && (t.style.left = "auto",
                t.style.right = f(r - n.x))
            } else {
                const s = n.x - (o.offsetWidth - n.w) / 2
                  , a = r - 10 - t.offsetWidth
                  , h = Math.max(10, Math.min(s, a));
                t.style.left = f(h);
                const l = a < s;
                t.classList.toggle(u["common-tooltip--direction_reversed"], l),
                t.classList.toggle(u["common-tooltip--direction_normal"], !l);
                const d = function(t, e, n, s) {
                    if (t.above)
                        return T(e, s) ? "above" : "below";
                    if (t.below)
                        return function(t, e, n) {
                            return n.y + n.h + e + 10 < t
                        }(e, n, s) ? "below" : "above";
                    return T(n, s) ? "above" : "below"
                }(e, c, g, n);
                "above" === d ? t.style.bottom = f(c - n.y) : t.style.top = f(n.y + n.h),
                m.classList.add("above" === d ? u["common-tooltip__ear-holder--above"] : u["common-tooltip__ear-holder--below"]);
                const {left: _} = o.getBoundingClientRect();
                let p = Math.trunc(n.x + n.w / 2 - (_ + o.clientWidth / 2));
                t.style.left = f(h + p),
                t.style.width = f(o.clientWidth + i.clientWidth),
                p = l ? Math.max(0, p) : Math.min(0, p),
                i.style.left = f(-p),
                o.style.left = f(-p)
            }
        }
        function p(t) {
            t.classList.toggle(u["common-tooltip--hidden"], !1)
        }
        function v(t) {
            t.classList.toggle(u["common-tooltip--hidden"], !0)
        }
        function f(t) {
            return `${Math.floor(t)}px`
        }
        const S = `\n\t<div id="common-tooltip-wrapper" class="${u["common-tooltip"]}">\n\t\t<div class="${u["common-tooltip__ear-holder"]}" >\n\t\t\t<div class="${u["common-tooltip__body"]} js-tooltip-body"></div>\n\t\t</div>\n\t\t<div class="${u["common-tooltip__button-container"]}"></div>\n\t</div>\n`
          , b = `\n\t<div class="${u["common-tooltip__hotkey-block"]}"></div>\n`
          , C = `\n\t<div class="${u["common-tooltip__hotkey-text"]}"></div>\n`
          , w = (0,
        r.parseHtmlElement)(S)
          , E = (0,
        r.parseHtmlElement)(b)
          , y = (0,
        r.parseHtmlElement)(C);
        function P(t) {
            return t.querySelector(`.${u["common-tooltip__body"]}`)
        }
        function T(t, e) {
            return 10 + t < e.y
        }
    }
    ,
    673747: (t,e,n)=>{
        "use strict";
        n.r(e),
        n.d(e, {
            hide: ()=>S,
            show: ()=>m,
            showOnElement: ()=>_,
            tooltipClickHandler: ()=>p,
            updateTooltipText: ()=>g
        });
        var s = n(778785)
          , o = n(112539)
          , i = n(630112)
          , r = n(650151)
          , a = n(779527)
          , c = n(799786);
        let h = !1
          , l = null
          , u = null;
        s.mobiletouch || document.addEventListener("mouseover", (function(t) {
            var e;
            if (null === (e = t.sourceCapabilities) || void 0 === e ? void 0 : e.firesTouchEvents)
                return;
            const n = t.target
              , s = t.currentTarget
              , o = function(t, e, n) {
                const s = [];
                for (; t && t !== e; )
                    t.classList && t.classList.contains(n) && s.push(t),
                    t = t.parentElement || C(t.parentNode);
                return s
            }(n, s, "apply-common-tooltip")
              , i = ()=>{
                u && (u.destroy(),
                u = null)
            }
            ;
            for (const e of o) {
                if ("buttons"in t) {
                    if (1 & t.buttons)
                        continue
                } else if (1 === t.which)
                    continue;
                const n = ()=>_(e);
                if (n()) {
                    const t = t=>s(null, !0)
                      , s = (o,r=!1)=>{
                        e.removeEventListener("common-tooltip-update", n),
                        e.removeEventListener("mouseleave", s),
                        e.removeEventListener("mousedown", s),
                        document.removeEventListener("scroll", t, {
                            capture: !0
                        }),
                        i(),
                        S(r)
                    }
                    ;
                    e.addEventListener("common-tooltip-update", n),
                    e.addEventListener("mouseleave", s),
                    e.addEventListener("mousedown", s),
                    document.addEventListener("scroll", t, {
                        capture: !0
                    }),
                    null === u && (u = (0,
                    c.createGroup)({
                        desc: "Tooltip"
                    }),
                    u.add({
                        desc: "Hide",
                        hotkey: 27,
                        handler: s
                    }));
                    break
                }
            }
        }
        ), !0);
        const d = new MutationObserver((()=>{
            if (l && l.options.target) {
                let t;
                t = "isConnected"in l.options.target ? l.options.target.isConnected : document.body.contains(l.options.target),
                t || S()
            }
        }
        ))
          , _ = (t,e={})=>{
            const {content: n, ...s} = w(e)
              , o = a.getDataFromTarget(t)
              , i = Object.assign(o, s);
            return "none" !== n.type && (i.content = n),
            !("none" === i.content.type && !i.hotkey) && (i.target = t,
            m(i),
            !0)
        }
          , m = t=>{
            const e = w(t)
              , n = a.getTooltip(e);
            if (l = {
                options: e,
                element: n
            },
            (0,
            i.setTooltip)(n),
            (0,
            o.clearSchedule)(),
            !h)
                return a.hideTooltip(n),
                void (0,
                o.scheduleRender)((()=>b(n)), function(t) {
                    return "number" != typeof t.tooltipDelay || isNaN(t.tooltipDelay) ? 500 : t.tooltipDelay
                }(e));
            const {tooltipDebounce: s} = t;
            "number" != typeof s || isNaN(s) ? b(n) : (0,
            o.scheduleRender)((()=>b(n)), s)
        }
          , g = t=>a.updateTooltipTextFromTarget(t);
        function p(t) {
            var e;
            s.mobiletouch && (_(t.currentTarget, {
                tooltipDelay: 0
            }),
            document.addEventListener("scroll", v),
            document.addEventListener("touchstart", v),
            window.addEventListener("orientationchange", v),
            null === (e = window.screen.orientation) || void 0 === e || e.addEventListener("change", v))
        }
        function v() {
            var t;
            document.removeEventListener("scroll", v),
            document.removeEventListener("touchstart", v),
            window.removeEventListener("orientationchange", v),
            null === (t = window.screen.orientation) || void 0 === t || t.removeEventListener("change", v),
            S()
        }
        function f() {
            (0,
            i.empty)(),
            h = !1,
            l = null
        }
        const S = t=>{
            if ((0,
            o.clearSchedule)(),
            d.disconnect(),
            !l)
                return;
            if (!t && !h)
                return;
            const {element: e, options: n} = l
              , s = ()=>{
                e.removeEventListener("mouseleave", s),
                a.hideTooltip(e),
                t ? f() : (0,
                o.scheduleRemove)((()=>{
                    f()
                }
                ), 250)
            }
            ;
            n.tooltipHideDelay ? (0,
            o.scheduleHide)((()=>{
                e.querySelector(":hover") ? e.addEventListener("mouseleave", s) : s()
            }
            ), n.tooltipHideDelay) : s()
        }
        ;
        function b(t) {
            const {options: e} = (0,
            r.ensureNotNull)(l);
            if (a.setStyle(t, e),
            a.showTooltip(t),
            d.observe(document, {
                childList: !0,
                subtree: !0
            }),
            h = !0,
            e.forceHideOnMove) {
                const t = ()=>{
                    document.removeEventListener("mousemove", t),
                    document.removeEventListener("touchmove", t),
                    S()
                }
                ;
                document.addEventListener("mousemove", t),
                document.addEventListener("touchmove", t)
            }
        }
        function C(t) {
            return t && (t.nodeType === Node.ELEMENT_NODE ? t : null)
        }
        function w(t) {
            if (function(t) {
                return "content"in t
            }(t))
                return t;
            const {inner: e, html: n, text: s, ...o} = t;
            let i = {
                type: "none"
            };
            return e && (i = {
                type: "element",
                data: e
            }),
            s && (i = {
                type: n ? "html" : "text",
                data: s
            }),
            {
                content: i,
                ...o
            }
        }
    }
    ,
    347402: (t,e,n)=>{
        "use strict";
        n.d(e, {
            desktopVersionIsLess: ()=>r,
            lessThan: ()=>i
        });
        var s = n(638456);
        function o(t) {
            const e = t.match(/^(\d+).(\d+).(\d+)/);
            if (!e)
                return null;
            const [,n,s,o] = e;
            return [parseInt(n), parseInt(s), parseInt(o)]
        }
        function i(t, e) {
            const n = o(t)
              , s = o(e);
            if (!n || !s)
                return !1;
            const [i,r,a] = n
              , [c,h,l] = s;
            return i !== c ? i < c : r !== h ? r < h : a !== l && a < l
        }
        function r(t) {
            const e = (0,
            s.desktopAppVersion)();
            return !!e && i(e, t)
        }
    }
    ,
    799786: (t,e,n)=>{
        "use strict";
        n.r(e),
        n.d(e, {
            Modifiers: ()=>i.Modifiers,
            createGroup: ()=>s.createGroup,
            keyboardPressedKeysState: ()=>s.keyboardPressedKeysState,
            pressedKeys: ()=>s.pressedKeys,
            registerWindow: ()=>s.registerWindow,
            unregisterWindow: ()=>s.unregisterWindow
        });
        var s = n(129592)
          , o = n(764250)
          , i = n(591800)
          , r = n(345848);
        (0,
        s.registerWindow)(window),
        o.ActionGroup.setMatchedHotkeyHandler((t=>{
            (0,
            r.trackEvent)("Keyboard Shortcuts", (0,
            i.humanReadableHash)(t))
        }
        ))
    }
    ,
    470316: (t,e,n)=>{
        "use strict";
        n.r(e),
        n.d(e, {
            Modifiers: ()=>s.Modifiers,
            hashFromEvent: ()=>s.hashFromEvent,
            hashShiftPlusEnter: ()=>s.hashShiftPlusEnter,
            humanReadableHash: ()=>s.humanReadableHash,
            humanReadableModifiers: ()=>s.humanReadableModifiers,
            isMacKeyboard: ()=>s.isMacKeyboard,
            modifiersFromEvent: ()=>s.modifiersFromEvent
        });
        var s = n(591800)
    }
    ,
    405069: (t,e,n)=>{
        "use strict";
        n.r(e),
        n.d(e, {
            pushStreamMultiplexer: ()=>H
        });
        var s = n(226722)
          , o = n(345848)
          , i = n(49437)
          , r = n(944454)
          , a = n(175203)
          , c = n(201089)
          , h = n(650151)
          , l = n(368654)
          , u = n(440150);
        const d = (0,
        c.getLogger)("PersistentWebsocketTransport");
        class _ extends u.PersistentTransport {
            constructor(t, e) {
                super(t, d, e)
            }
            sendMessage(t) {
                this._connectionStatus.value() === r.ConnectionStatus.Open ? this._socket ? this._socket.send(t) : d.logError("Something went wrong - code 0x3") : d.logWarn("Attempt to send message but connection is not opened")
            }
            _createNativeTransport(t) {
            }
            _disconnectTransport() {
                if (null === this._socket)
                    return;
                this._socket.removeEventListener("error", this._socketErrorHandler),
                this._socket.removeEventListener("close", this._socketCloseHandler),
                this._socket.removeEventListener("open", this._socketOpenHandler),
                this._socket.removeEventListener("message", this._socketMessageHandler),
                this._removeOnOfflineListener();
                const t = this._socket;
                this._socket = null,
                this._connectionStatus.setValue(r.ConnectionStatus.Closed),
                t.readyState !== WebSocket.CLOSED && t.close()
            }
        }
        class m {
            constructor(t) {
                this._queue = [],
                this._isWorking = !1,
                this._onResolve = ()=>{
                    this._queue.length > 0 && this._createPromise(this._queue[0])
                }
                ,
                this._logger = t
            }
            enqueue(t) {
                this._logger.logNormal(`Adding channel in stack. Queue size: ${this._queue.length}`),
                this._isWorking || this._createPromise(t),
                this._queue.push(t)
            }
            _createPromise(t) {
                this._isWorking = !0,
                this._wrap(t).then(this._onResolve)
            }
            _wrap(t) {
                return new Promise((e=>{
                    t().catch((t=>this._logger.logNormal(`Error when trying handling channel: ${t.message}`))).finally((()=>{
                        this._isWorking = !1,
                        this._queue.shift(),
                        e()
                    }
                    ))
                }
                ))
            }
        }
        const g = "PushStream"
          , p = (0,
        c.getLogger)(g);
        var v;
        !function(t) {
            t[t.EventSource = 0] = "EventSource",
            t[t.WebSocket = 1] = "WebSocket"
        }(v || (v = {}));
        class f {
            constructor(t, e) {
                this._channels = [],
                this._queue = new m(p),
                this._transport = e.transportType === v.EventSource ? new l.PersistentEventSourceTransport(this._onPushStreamMessage.bind(this)) : new _(this._onPushStreamMessage.bind(this),this._onPushStreamClose.bind(this)),
                this._settings = e,
                this._messageHandler = t
            }
            addChannel(t) {
                this._queue.enqueue((()=>this._addChannel(t)))
            }
            removeChannel(t) {
                this._queue.enqueue((()=>this._removeChannel(t)))
            }
            getChannels() {
                return this._channels
            }
            hasChannel(t) {
                return -1 !== this._channels.indexOf(t)
            }
            connectionStatus() {
                return this._transport.connectionStatus()
            }
            reconnectEvent() {
                return this._transport.successReconnectReachedEvent()
            }
            connect() {
                (0,
                h.assert)(0 !== this._channels.length, "There is no channels"),
                this._transport.connect()
            }
            disconnect() {
                this._transport.disconnect()
            }
            getLogs(t) {
                return (0,
                c.getRawLogHistory)(t, g)
            }
            async _addChannel(t) {
                (0,
                h.assert)(!this.hasChannel(t), `Channel with name ${t} has already been subscribed`),
                p.logNormal(`Adding channel ${t}`),
                this._channels.push(t);
                const {maxSize: e} = this._settings;
                return void 0 !== e && this._channels.length > e && (this._channels = this._channels.slice(this._channels.length - e)),
                this._transport.setUrl(this._generateUrl())
            }
            async _removeChannel(t) {
                const e = this._channels.indexOf(t);
                return (0,
                h.assert)(-1 !== e, `There is no channel with name ${t}`),
                p.logNormal(`Removing channel ${t}`),
                this._channels.splice(e, 1),
                this._transport.setUrl(this._generateUrl())
            }
            _onPushStreamMessage(t) {
                if ("string" != typeof t)
                    throw new Error("Wrong message type, expected string");
                const e = JSON.parse(t)
                  , n = e.id
                  , s = e.channel;
                -2 === n ? p.logWarn("Received unexpected message: about removed the channel") : n > 0 && (p.logDebug(`Received message: id="${n}" channel="${s}"`),
                this._messageHandler(e.text, n, s))
            }
            _onPushStreamClose(t) {
                1005 === t.code && a.telemetry.sendChartReport("websocket_code_1005")
            }
            _generateUrl() {
                const t = this._channels.join("/");
                return p.logNormal(`Generate pushstream url - ${t}`),
                `${this._settings.url}/${this._settings.urlPath}/${t}`
            }
        }
        n(659863);
        class S {
            constructor() {
                this._handlers = {},
                this._specialHandlers = {}
            }
            on(t, e) {
                const n = this._isSpecialChannel(t) ? this._specialHandlers : this._handlers;
                n[t] || (n[t] = []),
                n[t].push(e)
            }
            off(t, e) {
                const n = this._isSpecialChannel(t) ? this._specialHandlers : this._handlers;
                if (!(t in n))
                    return;
                if (void 0 === e)
                    return void delete n[t];
                const s = n[t].indexOf(e);
                s >= 0 && n[t].splice(s, 1)
            }
            emit(t, e, n, s) {
                this._handlers[n] && this._handlers[n].forEach((o=>{
                    o(t, e, n, s)
                }
                ));
                for (const o of Object.keys(this._specialHandlers)) {
                    const i = "^" + o.replace(/\*/g, ".*?") + "$";
                    new RegExp(i).test(n) && this._specialHandlers[o].forEach((o=>{
                        o(t, e, n, s)
                    }
                    ))
                }
            }
            _isSpecialChannel(t) {
                return /\*/.test(t)
            }
        }
        var b = n(125226)
          , C = n(541558)
          , w = n(314802)
          , E = n(707957)
          , y = n(268222)
          , P = n(167175);
        function T() {
            return !P.isIOS && !P.isIPad && void 0 !== navigator.locks
        }
        class k {
            constructor() {
                this._id = (0,
                C.guid)(),
                this._state = {
                    [this._id]: {}
                },
                this._xEventPrefix = "multiplexer-state-",
                this._xEventCreateTab = this._xEventPrefix + "create-new-tab",
                this._xEventShareState = this._xEventPrefix + "share-state",
                this._lockName = "tab_destruction",
                this._stateChangeDelegate = new E.Delegate,
                this._createdLocks = {},
                this._lockEnabled = T(),
                this._lockPromise = (0,
                y.createDeferredPromise)(),
                this._onTabCreateCb = null,
                this._onTabCreate = t=>{
                    this._onTabCreateCb && this._onTabCreateCb();
                    const e = JSON.parse(t);
                    this._state[e] = {},
                    this._shareState(),
                    this._requestTabRemoveLock(e)
                }
                ,
                this._shareState = ()=>{
                    const t = JSON.stringify([this._id, this._state[this._id]]);
                    s.TVXWindowEvents.emit(this._xEventShareState, t)
                }
                ,
                this._requestTabRemoveLock = t=>{
                    !this._createdLocks[t] && this._lockEnabled && (this._createdLocks[t] = 1,
                    navigator.locks.request(`${this._lockName}_${t}`, (async()=>{
                        const e = this._state[t] || {};
                        this._compareTabState(t, {}, e, "add"),
                        this._compareTabState(t, e, {}, "remove"),
                        delete this._state[t],
                        delete this._createdLocks[t]
                    }
                    )))
                }
                ,
                this._onShareStateFromOther = t=>{
                    const [e,n] = JSON.parse(t)
                      , s = this._state[e] || {};
                    this._compareTabState(e, n, s, "add"),
                    this._compareTabState(e, s, n, "remove"),
                    this._state[e] = n,
                    this._requestTabRemoveLock(e)
                }
                ,
                this._removeChannel = (t,e)=>{
                    delete this._state[this._id][t][e],
                    this._isListenByAnotherTab(t, e) || this._stateChangeDelegate.fire("remove", t, e);
                    0 === Object.keys(this._state[this._id][t]).length && delete this._state[this._id][t]
                }
                ,
                s.TVXWindowEvents.on(this._xEventCreateTab, this._onTabCreate),
                s.TVXWindowEvents.on(this._xEventShareState, this._onShareStateFromOther),
                this._lockEnabled && navigator.locks.request(`${this._lockName}_${this._id}`, (async()=>(s.TVXWindowEvents.emit(this._xEventCreateTab, JSON.stringify(this._id)),
                window.addEventListener("beforeunload", (()=>this._lockPromise.resolve())),
                this._lockPromise.promise)))
            }
            addChannel(t, e) {
                this._isNotEmpty(t, e) ? this._state[this._id][t][e]++ : (this._state[this._id][t] || (this._state[this._id][t] = {}),
                this._state[this._id][t][e] = 1),
                this._isListenByAnotherTab(t, e) || this._stateChangeDelegate.fire("add", t, e),
                this._shareState()
            }
            removeChannel(t, e) {
                this._isExist(t, e) && (this._state[this._id][t][e]--,
                this._isNotEmpty(t, e) || this._removeChannel(t, e),
                this._shareState())
            }
            collectPushStreamChannels(t) {
                const e = new Set;
                return Object.keys(this._state).forEach((n=>{
                    const s = this._state[n][t];
                    this._state[n][t] && Object.keys(s).forEach((t=>e.add(t)))
                }
                )),
                Array.from(e)
            }
            onStateChange(t) {
                this._stateChangeDelegate.subscribe(null, t)
            }
            offStateChange(t) {
                this._stateChangeDelegate.unsubscribe(null, t)
            }
            onTabCreate(t) {
                this._onTabCreateCb = t
            }
            _isExist(t, e, n=this._id) {
                return void 0 !== this._state[n] && void 0 !== this._state[n][t] && void 0 !== this._state[n][t][e]
            }
            _isNotEmpty(t, e, n=this._id) {
                return this._isExist(t, e, n) && this._state[n][t][e] > 0
            }
            _compareTabState(t, e, n, s) {
                Object.keys(e).forEach((o=>{
                    Object.keys(e[o]).forEach((e=>{
                        this._isListenByAnotherTab(o, e, t) || n[o] && n[o][e] || this._stateChangeDelegate.fire(s, o, e)
                    }
                    ))
                }
                ))
            }
            _isListenByAnotherTab(t, e, n=this._id) {
                return Object.keys(this._state).some((s=>s !== n && this._isNotEmpty(t, e, s)))
            }
        }
        const L = (0,
        c.getLogger)(g)
          , x = {
            url: window.PUSHSTREAM_URL,
            urlPath: "message-pipe-ws",
            transportType: v.WebSocket
        }
          , R = {
            url: window.PUSHSTREAM_URL.replace("wss://", "https://"),
            urlPath: "message-pipe-es",
            transportType: v.EventSource
        };
        class O {
            constructor() {
                var t;
                this.guid = (0,
                C.guid)(),
                this._pushStreamPublic = null,
                this._pushStreamPrivate = null,
                this._statusHandlers = [],
                this._reconnectHandlers = [],
                this._userPrivateChannel = null,
                this._channelMultiplexer = new S,
                this._xEventPrefix = "multiplexer-bc-",
                this._storagePrefix = "pushStreamMultiplexerState.",
                this._userChannelPrefix = "private_",
                this._statusPublic = r.ConnectionStatus.Closed,
                this._statusPrivate = r.ConnectionStatus.Closed,
                this._xEventSend = this._xEventPrefix + "send",
                this._xEventConnectionStatus = this._xEventPrefix + "connectionStatus",
                this._xEventReconnectCommand = this._xEventPrefix + "reconnectCommand",
                this._xEventReconnectSuccess = this._xEventPrefix + "reconnectSuccess",
                this._xEventRequestLogs = this._xEventPrefix + "requestLogs",
                this._xEventShareLogs = this._xEventPrefix + "shareLogs",
                this._state = new k,
                this._shareLogsKey = this._storagePrefix + "shareLogs",
                this._lockName = "pushstream",
                this._lockPromise = (0,
                y.createDeferredPromise)(),
                this._dispatchReconnectSuccessCommandFromOther = t=>{
                    if (this.ownPushStream())
                        return;
                    const [e] = this._decodeParams(t);
                    this._callReconnectHandlers(e)
                }
                ,
                this._dispatchMessage = (t,e,n)=>{
                    this._dispatchMessageToOthers(t, e, n),
                    this._dispatchMessageToSelf(t, e, n, !1)
                }
                ,
                this._dispatchMessageFromOther = t=>{
                    if (this.ownPushStream())
                        return;
                    const [e,n,s] = this._decodeParams(t);
                    this._dispatchMessageToSelf(e, n, s, !0)
                }
                ,
                this._dispatchStatusChangeFromOther = t=>{
                    const e = this._decodeConnectionStatus(t)
                      , n = e[0]
                      , s = e[1];
                    this.ownPushStream() || this._dispatchStatusChangeToSelf(n, s)
                }
                ,
                this._dispatchReconnectCommandFromOther = ()=>{
                    this.ownPushStream() && this.forceConnect()
                }
                ,
                this._onRequestLogs = ()=>{
                    if (this.ownPushStream()) {
                        const t = this._getOwnLogs();
                        let e = "";
                        try {
                            e = JSON.stringify(t)
                        } catch (t) {
                            L.logError("Failed to stringify own pushstream logs")
                        }
                        i.TVLocalStorage.setItem(this._shareLogsKey, e),
                        s.TVXWindowEvents.emit(this._xEventShareLogs, e)
                    }
                }
                ,
                this._onStateChange = (t,e,n)=>{
                    const s = "private" === e ? this._pushStreamPrivate : this._pushStreamPublic;
                    "add" === t ? null == s || s.addChannel(n) : null == s || s.removeChannel(n)
                }
                ,
                this._onNewTabCreate = ()=>{
                    this._dispatchStatusChangeToOthers(this._statusPublic, this._statusPrivate)
                }
                ,
                T() ? navigator.locks.request(this._lockName, (async()=>(this._state.onStateChange(this._onStateChange),
                this._state.onTabCreate(this._onNewTabCreate),
                this._instantiatePushStream(),
                window.addEventListener("beforeunload", (()=>this._lockPromise.resolve())),
                this._lockPromise.promise))) : (this._state.onStateChange(this._onStateChange),
                this._instantiatePushStream()),
                s.TVXWindowEvents.on(this._xEventSend, this._dispatchMessageFromOther),
                s.TVXWindowEvents.on(this._xEventConnectionStatus, this._dispatchStatusChangeFromOther),
                s.TVXWindowEvents.on(this._xEventReconnectCommand, this._dispatchReconnectCommandFromOther),
                s.TVXWindowEvents.on(this._xEventReconnectSuccess, this._dispatchReconnectSuccessCommandFromOther),
                s.TVXWindowEvents.on(this._xEventRequestLogs, this._onRequestLogs),
                t = ()=>{
                    window.loginStateChange && window.loginStateChange.subscribe(this, this._changeLoginState)
                }
                ,
                "loading" !== document.readyState ? t() : document.addEventListener("DOMContentLoaded", t)
            }
            on(t, e) {
                this._channelMultiplexer.on(t, e)
            }
            off(t, e) {
                this._channelMultiplexer.off(t, e)
            }
            onStatus(t) {
                this._statusHandlers.push({
                    handler: t,
                    isPrivate: !1
                }),
                setTimeout((()=>t(this._statusPublic)), 0)
            }
            onPrivateStatus(t) {
                this._statusHandlers.push({
                    handler: t,
                    isPrivate: !0
                }),
                setTimeout((()=>t(this._statusPrivate)), 0)
            }
            onReconnect(t, e=!1) {
                this._reconnectHandlers.push({
                    handler: t,
                    isPrivate: e
                })
            }
            offReconnect(t) {
                this._reconnectHandlers = this._reconnectHandlers.filter((e=>e.handler !== t))
            }
            offStatus(t) {
                this._statusHandlers = this._statusHandlers.filter((e=>e.handler !== t))
            }
            forceConnect() {
                var t, e;
                L.logNormal(`Creating pushstream connection after force connect. Main tab: ${this.ownPushStream()}`),
                this.ownPushStream() ? (null === (t = this._pushStreamPublic) || void 0 === t || t.disconnect(),
                null === (e = this._pushStreamPrivate) || void 0 === e || e.disconnect(),
                this._instantiatePushStream()) : s.TVXWindowEvents.emit(this._xEventReconnectCommand)
            }
            disconnect() {
                this.ownPushStream() && this._destructPushStream()
            }
            getLogs(t) {
                return new Promise((e=>{
                    const n = setTimeout((()=>{
                        const t = i.TVLocalStorage.getItem(this._shareLogsKey);
                        e(null !== t ? JSON.parse(t) : [])
                    }
                    ), 1e3)
                      , o = t=>{
                        let i;
                        s.TVXWindowEvents.off(this._xEventShareLogs, o),
                        s.TVXWindowEvents.emit(this._xEventShareLogs, ""),
                        clearTimeout(n);
                        try {
                            i = JSON.parse(t)
                        } catch (t) {
                            i = [],
                            L.logError("Failed to parse logs received from master tab")
                        }
                        e(i)
                    }
                    ;
                    this.ownPushStream() ? e(this._getOwnLogs(t)) : (s.TVXWindowEvents.on(this._xEventShareLogs, o),
                    s.TVXWindowEvents.emit(this._xEventRequestLogs))
                }
                ))
            }
            ownPushStream() {
                return !!this._pushStreamPublic || !!this._pushStreamPrivate
            }
            pushStream() {
                if (!this.ownPushStream())
                    throw new Error("Not own PushStream");
                return this._pushStreamPublic
            }
            isConnected() {
                return this._statusPublic > 0
            }
            status() {
                var t;
                return null !== (t = this._statusPublic) && void 0 !== t ? t : r.ConnectionStatus.Closed
            }
            statusPrivate() {
                var t;
                return null !== (t = this._statusPrivate) && void 0 !== t ? t : r.ConnectionStatus.Closed
            }
            userChannel() {
                if (!this._userPrivateChannel)
                    throw new Error("No user channel");
                return this._userChannel(this._userPrivateChannel)
            }
            addChannel(t) {
                this._state.addChannel(t.startsWith(this._userChannelPrefix) ? "private" : "public", t)
            }
            removeChannel(t) {
                this._state.removeChannel(t.startsWith(this._userChannelPrefix) ? "private" : "public", t)
            }
            static getInstance() {
                return null === this._instance && (this._instance = new O),
                this._instance
            }
            _userChannel(t) {
                return this._userChannelPrefix + t
            }
            _codeParams(t) {
                const e = [...t];
                return e.push((new Date).getTime()),
                JSON.stringify(e)
            }
            _decodeParams(t) {
                const e = JSON.parse(t);
                return e.pop(),
                e
            }
            _instantiatePushStream() {
                this._pushStreamPublic && ((0,
                o.trackEvent)("PushstreamDoublePublic", window.user && window.user.username || "Guest", navigator.userAgent),
                this._pushStreamPublic.disconnect());
                const t = this._getPushStreamSettings();
                this._pushStreamPublic = new f(this._dispatchMessage,t),
                this._pushStreamPublic.connectionStatus().subscribe((t=>{
                    this._dispatchStatusChange(t, this._statusPrivate)
                }
                )),
                this._pushStreamPublic.reconnectEvent().subscribe(null, (()=>{
                    this._dispatchReconnectSuccessCommand()
                }
                )),
                this._pushStreamPrivate && ((0,
                o.trackEvent)("PushstreamDoublePrivate", window.user && window.user.username || "Guest", navigator.userAgent),
                this._pushStreamPrivate.disconnect()),
                this._pushStreamPrivate = new f(this._dispatchMessage,{
                    ...t,
                    maxSize: 1
                }),
                this._pushStreamPrivate.connectionStatus().subscribe((t=>{
                    this._dispatchStatusChange(this._statusPublic, t)
                }
                )),
                this._pushStreamPrivate.reconnectEvent().subscribe(null, (()=>{
                    this._dispatchReconnectSuccessCommand(!0)
                }
                )),
                this.on("pushstream_set_user_channel", (t=>{
                    this._setUserChannel(t)
                }
                )),
                this._connectChannels()
            }
            _destructPushStream() {
                const t = this._pushStreamPublic;
                this._pushStreamPublic = null,
                null == t || t.disconnect();
                const e = this._pushStreamPrivate;
                this._pushStreamPrivate = null,
                null == e || e.disconnect(),
                this._dispatchStatusChangeFromOther(this._codeParams([r.ConnectionStatus.Closed, r.ConnectionStatus.Closed]))
            }
            _connectChannels() {
                var t, e;
                null === (t = this._pushStreamPublic) || void 0 === t || t.addChannel("public");
                const n = this._state.collectPushStreamChannels("public");
                void 0 !== n && n.length > 0 && n.map((t=>{
                    var e;
                    return null === (e = this._pushStreamPublic) || void 0 === e ? void 0 : e.addChannel(t)
                }
                )),
                "is_authenticated"in window ? this._connectUserChannelInitial(!0) : window.loginStateChange && window.loginStateChange.subscribe(this, this._connectUserChannelInitial),
                this._isPublicPushstreamEnabled() && (null === (e = this._pushStreamPublic) || void 0 === e || e.connect())
            }
            _getPushStreamSettings() {
                return (0,
                w.isOnMobileAppPage)("any") ? (0,
                b.isFeatureEnabled)("enable_eventsource_pushstream_mobile") ? R : x : (0,
                b.isFeatureEnabled)("enable_eventsource_pushstream_transport") ? R : x
            }
            _isPublicPushstreamEnabled() {
                return (0,
                w.isOnMobileAppPage)("any") || !(0,
                b.isFeatureEnabled)("disable_pushstream_connections_for_anonymous_users") || window.is_authenticated || window.TradingView.onChartPage
            }
            _connectUserChannelInitial(t) {
                var e, n, s;
                t && (window.is_authenticated ? (this._userPrivateChannel = null !== (e = window.user.private_channel) && void 0 !== e ? e : null,
                null === (n = this._pushStreamPrivate) || void 0 === n || n.addChannel(this.userChannel()),
                null === (s = this._pushStreamPrivate) || void 0 === s || s.connect()) : this._userPrivateChannel = null)
            }
            _changeLoginState(t) {
                var e, n, s, o, i, r;
                t || (this._isPublicPushstreamEnabled() && (null === (e = this._pushStreamPublic) || void 0 === e || e.connect()),
                window.is_authenticated ? (this._userPrivateChannel = null !== (n = window.user.private_channel) && void 0 !== n ? n : null,
                this.ownPushStream() && (null === (s = this._pushStreamPrivate) || void 0 === s || s.addChannel(this.userChannel()),
                null === (o = this._pushStreamPrivate) || void 0 === o || o.connect())) : (this.ownPushStream() && (null === (i = this._pushStreamPrivate) || void 0 === i || i.removeChannel(this.userChannel()),
                null === (r = this._pushStreamPrivate) || void 0 === r || r.disconnect()),
                this._userPrivateChannel = null))
            }
            _setUserChannel(t) {
                var e, n;
                L.logNormal("Set user channel " + t),
                t !== this._userPrivateChannel && (this.ownPushStream() && this._userPrivateChannel && (null === (e = this._pushStreamPrivate) || void 0 === e || e.removeChannel(this.userChannel())),
                this._userPrivateChannel = t,
                this.ownPushStream() && this._userPrivateChannel && (null === (n = this._pushStreamPrivate) || void 0 === n || n.addChannel(this.userChannel())))
            }
            _dispatchStatusChange(t, e) {
                this._dispatchStatusChangeToOthers(t, e),
                this._dispatchStatusChangeToSelf(t, e)
            }
            _dispatchStatusChangeToSelf(t, e) {
                t !== this._statusPublic && (this._statusPublic = t,
                this._callStatusHandlers(t, !1)),
                e !== this._statusPrivate && (this._statusPrivate = e,
                this._callStatusHandlers(e, !0))
            }
            _callStatusHandlers(t, e) {
                L.logNormal("Connection status change: " + t + ", private " + e + ", is main tab " + this.ownPushStream()),
                a.telemetry.sendReport("site", "pushstream_status_change"),
                this._statusHandlers.forEach((n=>{
                    n.isPrivate === e && n.handler(t)
                }
                ))
            }
            _callReconnectHandlers(t) {
                L.logNormal("Reconnection has been made"),
                this._reconnectHandlers.forEach((e=>{
                    e.isPrivate === t && e.handler()
                }
                ))
            }
            _dispatchReconnectSuccessCommand(t=!1) {
                if (this.ownPushStream()) {
                    this._callReconnectHandlers(t);
                    const e = this._codeParams([t]);
                    s.TVXWindowEvents.emit(this._xEventReconnectSuccess, e)
                }
            }
            _decodeConnectionStatus(t) {
                const e = parseInt(t, 10);
                return isNaN(e) ? this._decodeParams(t) : [e, e]
            }
            _dispatchStatusChangeToOthers(t, e) {
                if (this.ownPushStream()) {
                    const n = this._codeParams([t, e]);
                    s.TVXWindowEvents.emit(this._xEventConnectionStatus, n)
                }
            }
            _dispatchMessageToSelf(t, e, n, s) {
                const o = t.channel
                  , i = t.content;
                this._emit(i, e, o, s)
            }
            _dispatchMessageToOthers(t, e, n) {
                const o = [t, e, n];
                s.TVXWindowEvents.emit(this._xEventSend, this._codeParams(o))
            }
            _emit(t, e, n, s) {
                this._channelMultiplexer.emit(t, e, n, s)
            }
            _getOwnLogs(t) {
                var e;
                if (this.ownPushStream()) {
                    const n = (0,
                    c.getRawLogHistory)(t, g)
                      , s = null === (e = this.pushStream()) || void 0 === e ? void 0 : e.getLogs();
                    return [].concat(n, null != s ? s : [])
                }
                return []
            }
        }
        O._instance = null;
        const H = O.getInstance()
    }
    ,
    86746: (t,e,n)=>{
        "use strict";
        n.r(e),
        n.d(e, {
            StdTheme: ()=>a.StdTheme,
            getStdChartTheme: ()=>l,
            getStdThemeNames: ()=>h,
            getThemeNameIfStdTheme: ()=>_,
            isStdTheme: ()=>d,
            translateThemeName: ()=>u
        });
        var s = n(444372)
          , o = n(724377)
          , i = n(979706)
          , r = n(746518)
          , a = n(61499);
        function c() {
            return {
                [a.StdTheme.Light]: JSON.parse(JSON.stringify(i)),
                [a.StdTheme.Dark]: JSON.parse(JSON.stringify(r))
            }
        }
        function h() {
            return [a.StdTheme.Light, a.StdTheme.Dark]
        }
        function l(t) {
            return c()[t]
        }
        function u(t) {
            return {
                [a.StdTheme.Light]: s.t(null, {
                    context: "colorThemeName"
                }, n(669841)),
                [a.StdTheme.Dark]: s.t(null, {
                    context: "colorThemeName"
                }, n(14642))
            }[t] || t
        }
        function d(t) {
            const e = c();
            return h().some((n=>m(e[n], t)))
        }
        function _(t) {
            const e = c()
              , n = h();
            for (const s of n)
                if (m(e[s], t))
                    return s;
            return null
        }
        function m(t, e) {
            let n = t.content === e.content;
            return function(t={}, e) {
                try {
                    g(t, [], e)
                } catch (t) {
                    return
                }
            }(t.content, ((t,s)=>{
                const i = function(t, e={}) {
                    let n = e;
                    for (let e = 0; e < t.length; e++) {
                        if (!n || "object" != typeof n)
                            return;
                        n = n[t[e]]
                    }
                    if ("string" == typeof n || "number" == typeof n)
                        return n;
                    return
                }(t, e.content);
                return n = function(t, e) {
                    if (t === e)
                        return !0;
                    if ("string" != typeof t || "string" != typeof e)
                        return !1;
                    try {
                        return function(t, e) {
                            return Math.hypot(t[3] * t[0] - e[3] * e[0], t[3] * t[1] - e[3] * e[1], t[3] * t[2] - e[3] * e[2], 255 * t[3] - 255 * e[3]) < 48
                        }((0,
                        o.parseRgba)(t), (0,
                        o.parseRgba)(e))
                    } catch (t) {}
                    return !1
                }(s, i),
                !n
            }
            )),
            n
        }
        function g(t, e, n) {
            for (const s in t)
                if (t.hasOwnProperty(s)) {
                    const o = e.concat(s);
                    if ("object" == typeof t[s])
                        g(t[s], o, n);
                    else if (n(o, t[s]))
                        throw new Error("exit")
                }
        }
    }
    ,
    439016: (t,e,n)=>{
        "use strict";
        n.d(e, {
            tradingService: ()=>i,
            waitTradingService: ()=>r
        });
        var s = n(564894);
        const o = {
            id: "TradingService"
        };
        function i() {
            return (0,
            s.hasService)(o) ? (0,
            s.service)(o) : null
        }
        function r() {
            return (0,
            s.waitServiceRegistered)(o)
        }
    }
    ,
    368654: (t,e,n)=>{
        "use strict";
        n.d(e, {
            PersistentEventSourceTransport: ()=>r
        });
        var s = n(944454)
          , o = n(440150);
        const i = (0,
        n(201089).getLogger)("PersistentWebsocketTransport");
        class r extends o.PersistentTransport {
            constructor(t) {
                super(t, i),
                this._specializedErrorHandlerBound = this._specializedErrorHandler.bind(this)
            }
            _createNativeTransport(t) {
                const e = new EventSource(t,{
                    withCredentials: !0
                });
                return e.addEventListener("error", this._specializedErrorHandlerBound),
                e.addEventListener("open", this._socketOpenHandler),
                e.addEventListener("message", this._socketMessageHandler),
                e
            }
            _disconnectTransport() {
                if (null === this._socket)
                    return;
                this._socket.removeEventListener("error", this._specializedErrorHandlerBound),
                this._socket.removeEventListener("open", this._socketOpenHandler),
                this._socket.removeEventListener("message", this._socketMessageHandler),
                this._removeOnOfflineListener();
                const t = this._socket;
                this._socket = null,
                this._connectionStatus.setValue(s.ConnectionStatus.Closed),
                t.readyState !== WebSocket.CLOSED && t.close()
            }
            _specializedErrorHandler(t) {
                t.eventPhase === EventSource.CLOSED ? this._socketCloseHandler(t) : this._socketErrorHandler()
            }
        }
    }
    ,
    440150: (t,e,n)=>{
        "use strict";
        n.d(e, {
            PersistentTransport: ()=>c
        });
        var s = n(944454)
          , o = n(978137)
          , i = n(401580)
          , r = n(707957)
          , a = n(266325);
        class c {
            constructor(t, e, n) {
                this._url = "",
                this._socket = null,
                this._reconnectCount = 0,
                this._onlineCancellationToken = null,
                this._connectionStatus = new i.WatchedValue(s.ConnectionStatus.Closed),
                this._socketCloseHandler = this._onCloseCallback.bind(this),
                this._socketErrorHandler = this._onErrorCallback.bind(this),
                this._socketOpenHandler = this._onOpenCallback.bind(this),
                this._socketMessageHandler = this._onMessageCallback.bind(this),
                this._maxReconnectReachedEventDelegate = new r.Delegate,
                this._successReconnectReachedEventDelegate = new r.Delegate,
                this._shouldReconnect = !0,
                this._maxReconnectCount = null,
                this._reconnectTimeoutId = 0,
                this._connectAbortController = null,
                this._tryReconnect = ()=>{
                    if (this._disconnect(),
                    this._shouldReconnect) {
                        const t = this._getReconnectTimeout();
                        this._logger.logNormal(`Sleeping some time before reconnect ${t}ms`),
                        this._reconnectTimeoutId = setTimeout(this._tryReconnectImpl.bind(this), t)
                    } else
                        this._logger.logNormal("Skip reconnecting because of shouldReconnect state")
                }
                ,
                this._onOfflineHandler = ()=>{
                    this._removeOnOfflineListener(),
                    this._logger.logInfo("Network status changed to offline - trying to reconnect"),
                    this._tryReconnect()
                }
                ,
                this._logger = e,
                this._messageHandler = t,
                this._closeHandler = n,
                window.addEventListener("unload", (()=>{
                    e.logNormal("Unload event comes - disconnecting without reconnect after that..."),
                    this._shouldReconnect = !1,
                    this._disconnect()
                }
                ), !1)
            }
            setUrl(t) {
                if (this._url === t)
                    return Promise.resolve();
                const e = this._connectionStatus.value() !== s.ConnectionStatus.Closed;
                return e && this._disconnect(),
                this._url = t,
                e ? this.connect() : Promise.resolve()
            }
            url() {
                return this._url
            }
            connect() {
                return this._connectImpl()
            }
            setMaxReconnectCount(t) {
                this._maxReconnectCount = t
            }
            connectionStatus() {
                return this._connectionStatus.readonly()
            }
            disconnect() {
                this._shouldReconnect = !1,
                this._disconnect()
            }
            maxReconnectReachedEvent() {
                return this._maxReconnectReachedEventDelegate
            }
            successReconnectReachedEvent() {
                return this._successReconnectReachedEventDelegate
            }
            async _prepareParamsForConnection(t) {}
            _disconnect() {
                var t;
                null === (t = this._connectAbortController) || void 0 === t || t.abort(),
                this._connectAbortController = null,
                clearTimeout(this._reconnectTimeoutId),
                this._reconnectTimeoutId = 0,
                this._connectionStatus.value() !== s.ConnectionStatus.Closed ? this._socket ? (this._logger.logNormal(`Closing connection to: ${this._socket.url}, currentStatus: ${s.ConnectionStatus[this._connectionStatus.value()]}`),
                this._disconnectTransport()) : this._logger.logNormal("Disconnecting without socket - probably within preparing, it should be already scheduled for aborting") : this._logger.logNormal("Attempt to close connection but it is closed already")
            }
            _onErrorCallback() {
                this._logger.logInfo("Connection is closed by error"),
                this._tryReconnect()
            }
            _onCloseCallback(t) {
                var e;
                this._logger.logInfo(`Connection is closed - code=${t.code} msg=${t.reason}`),
                null === (e = this._closeHandler) || void 0 === e || e.call(this, t),
                this._tryReconnect()
            }
            _tryReconnectImpl() {
                return null !== this._maxReconnectCount && this._reconnectCount === this._maxReconnectCount ? (this._logger.logWarn("Maximum attempts to reconnect to websocket reached"),
                void this._maxReconnectReachedEventDelegate.fire()) : (this._reconnectCount += 1,
                this._logger.logInfo(`Reconnecting count: ${this._reconnectCount}`),
                navigator.onLine ? (this._logger.logInfo("Network status: online - trying to connect"),
                void this.connect()) : (this._logger.logInfo("Network status: offline - wait until online"),
                void (this._onlineCancellationToken = (0,
                o.callWhenOnline)((()=>{
                    this._logger.logInfo("Network status changed to online - trying to connect"),
                    this.connect()
                }
                )))))
            }
            _onOpenCallback() {
                this._logger.logNormal("Connection opened"),
                this._reconnectCount > 0 && this._successReconnectReachedEventDelegate.fire(),
                this._reconnectCount = 0,
                this._connectionStatus.setValue(s.ConnectionStatus.Open)
            }
            _onMessageCallback(t) {
                this._messageHandler(t.data)
            }
            _getReconnectTimeout() {
                return this._reconnectCount < 5 ? 300 : 5e3
            }
            _setOnOfflineListener() {
                window.addEventListener("offline", this._onOfflineHandler)
            }
            _removeOnOfflineListener() {
                window.removeEventListener("offline", this._onOfflineHandler)
            }
            async _connectImpl() {
                if (this._connectionStatus.value() !== s.ConnectionStatus.Closed)
                    return void this._logger.logNormal("Attempt to open connection but it is not closed");
                this._socket && (this._logger.logError("Something went wrong - code 0x2"),
                this.disconnect()),
                this._onlineCancellationToken && (this._onlineCancellationToken(),
                this._onlineCancellationToken = null),
                this._logger.logNormal(`Connecting to ${this._url}`),
                this._shouldReconnect = !0,
                this._connectAbortController = new AbortController;
                const t = this._connectAbortController.signal;
                try {
                    if (this._connectionStatus.setValue(s.ConnectionStatus.Connecting),
                    await this._prepareParamsForConnection(t),
                    t.aborted)
                        throw (0,
                        a.createAbortError)();
                    this._socket = this._createNativeTransport(this._url),
                    this._setOnOfflineListener()
                } catch (t) {
                    this._connectionStatus.setValue(s.ConnectionStatus.Closed),
                    (0,
                    a.skipAbortError)(t)
                } finally {
                    this._connectAbortController = null
                }
            }
        }
    }
    ,
    81979: (t,e,n)=>{
        "use strict";
        n.r(e),
        n.d(e, {
            CubicBezier: ()=>s.CubicBezier,
            color: ()=>s.color,
            dur: ()=>s.dur,
            easingFunc: ()=>s.easingFunc
        });
        var s = n(745269)
    }
    ,
    924335: (t,e,n)=>{
        "use strict";
        n.d(e, {
            LastChanceType: ()=>i,
            OFFERS: ()=>s,
            OfferKind: ()=>o
        });
        const s = {
            trial: "trial",
            early_access: "early_access",
            black_friday: "black_friday",
            cyber_monday: "cyber_monday",
            custom_discount: "custom_discount",
            longer_cycle: "longer_cycle",
            upgrade: "upgrade",
            extend: "extend",
            last_chance: "last_chance",
            one_usd: "one_usd",
            three_months: "three_months",
            six_months: "six_months",
            coupon: "coupon"
        }
          , o = {
            early_access: "early_access",
            black_friday: "black_friday",
            last_chance: "last_chance",
            one_usd: "1 usd offer",
            three_months: "3 months offer",
            six_months: "six_months",
            custom_discount: "custom_discount"
        };
        var i;
        !function(t) {
            t.TwoWeeks = "LastChance_2w",
            t.TwoDays = "LastChance_2d",
            t.Hours = "LastChance_24h"
        }(i || (i = {}))
    }
    ,
    957879: (t,e,n)=>{
        const s = n(823127);
        t.exports = s,
        s(document).ajaxSend(((t,e,n)=>{
            n.crossDomain && !n.forceLanguageHeader || (window.locale ? e.setRequestHeader("X-Language", window.locale) : console.warn("window.locale is not defined"))
        }
        ))
    }
    ,
    978137: (t,e,n)=>{
        "use strict";
        if (n.d(e, {
            callWhenOnline: ()=>o,
            waitForOnline: ()=>i
        }),
        !/^4(5206|6485)$/.test(n.j))
            var s = n(266325);
        function o(t) {
            let e = t;
            const n = ()=>{
                window.removeEventListener("online", n),
                e && e()
            }
            ;
            return window.addEventListener("online", n),
            ()=>{
                e = null
            }
        }
        async function i(t=null) {
            return !0 === navigator.onLine || void 0 === navigator.onLine ? Promise.resolve() : (0,
            s.respectAbort)(t, new Promise((t=>{
                const e = ()=>{
                    window.removeEventListener("online", e),
                    t()
                }
                ;
                window.addEventListener("online", e)
            }
            )))
        }
    }
}]);
