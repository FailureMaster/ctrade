(self.webpackChunktradingview = self.webpackChunktradingview || []).push([[3229], {
    618299: t=>{
        t.exports = {}
    }
    ,
    849960: t=>{
        t.exports = {
            "css-value-copyright-transition-params": ".6s 0s cubic-bezier(.4, .01, .22, 1)",
            "css-value-copyright-transition-params-half-time": ".3s 0s cubic-bezier(.4, .01, .22, 1)",
            label: "label-dzbd7lyV",
            logoWrap: "logoWrap-dzbd7lyV",
            expandedWithTransition: "expandedWithTransition-dzbd7lyV",
            expandedByClick: "expandedByClick-dzbd7lyV",
            start: "start-dzbd7lyV",
            end: "end-dzbd7lyV",
            snap: "snap-dzbd7lyV",
            top: "top-dzbd7lyV",
            bottom: "bottom-dzbd7lyV",
            large: "large-dzbd7lyV",
            expanded: "expanded-dzbd7lyV",
            label__link: "label__link-dzbd7lyV"
        }
    }
    ,
    62889: (t,e,s)=>{
        "use strict";
        s.d(e, {
            copyrightLabel: ()=>r
        });
        var i, o = s(497754), a = s(995683), n = s(389137), l = s(849960);
        function r({svgText: t, icon: e, theme: s, url: r, mode: h, verticalPosition: c=i.Vertical.Bottom, horizontalPosition: d=i.Horizontal.End, snapToEdge: g=!0, isExpanded: u=!1, className: p}) {
            let m;
            switch (h) {
            case "new":
            case "with_border":
            case "large_trade":
                m = (0,
                n.clone)(s);
                break;
            default:
                m = (0,
                a.mergeThemes)((0,
                n.clone)(l), s)
            }
            const b = document.createElement("span");
            let w;
            r && (w = document.createElement("a"),
            w.classList.add(...m.label__link.split(/\s/)),
            w.href = r,
            w.target = "_top",
            w.rel = "noopener noreferrer",
            w.setAttribute("data-target-type", "copyright"),
            b.append(w)),
            b.className = o(m.label, d === i.Horizontal.Start && m.start, d === i.Horizontal.End && m.end, c === i.Vertical.Top && m.top, c === i.Vertical.Bottom && m.bottom, g && "large_trade" !== h && m.snap, "large_old" === h && m.large, (u || "large_trade" === h) && m.expanded, p, "js-copyright-label"),
            b.addEventListener("click", (()=>{
                function t() {
                    b.classList.remove(m.expandedByClick),
                    b.removeEventListener("mouseleave", t)
                }
                b.classList.contains(m.expandedWithTransition) || b.classList.contains(m.expanded) || (b.classList.contains(m.expandedByClick) ? r || t() : (b.classList.add(m.expandedByClick),
                b.addEventListener("mouseleave", t)))
            }
            ));
            const _ = document.createElement("span");
            _.className = m.logoWrap,
            _.innerHTML = e;
            const f = document.createElement("span");
            return f.className = m.svgTextWrap,
            f.innerHTML = t,
            b.append(_, f),
            [b, m]
        }
        !function(t) {
            let e, s;
            !function(t) {
                t[t.Bottom = 0] = "Bottom",
                t[t.Top = 1] = "Top"
            }(e = t.Vertical || (t.Vertical = {})),
            function(t) {
                t[t.Start = 0] = "Start",
                t[t.End = 1] = "End"
            }(s = t.Horizontal || (t.Horizontal = {}))
        }(i || (i = {}))
    }
    ,
    351079: (t,e,s)=>{
        "use strict";
        s.d(e, {
            createCopyrightLabel: ()=>n
        });
        var i = s(497754)
          , o = s(62889)
          , a = s(952598);
        function n({sheriffOptions: t, ...e}) {
            const [s,n] = (0,
            o.copyrightLabel)(e)
              , l = t && t.includes(a.KnownAction.Expand)
              , r = t && t.includes(a.KnownAction.LargeTradeLogo);
            return s.className = i(s.className, (l || r) && n.expandedWithTransition),
            s
        }
    }
    ,
    952598: (t,e,s)=>{
        "use strict";
        var i;
        s.d(e, {
            KnownAction: ()=>i,
            widgetSheriffActions: ()=>o
        }),
        function(t) {
            t.Expand = "expand-logo",
            t.LargeTradeLogo = "large-trade-logo"
        }(i || (i = {}));
        const o = new Set([i.Expand, i.LargeTradeLogo])
    }
    ,
    778785: (t,e,s)=>{
        "use strict";
        s.d(e, {
            mobiletouch: ()=>o,
            setClasses: ()=>a
        });
        var i = s(167175);
        const o = i.mobiletouch;
        i.touch;
        function a() {
            document.documentElement.classList.add(i.touch ? "feature-touch" : "feature-no-touch", i.mobiletouch ? "feature-mobiletouch" : "feature-no-mobiletouch")
        }
    }
    ,
    406103: (t,e,s)=>{
        "use strict";
        s.d(e, {
            isIDCExchange: ()=>o
        });
        var i = s(403009);
        function o(t, e=!1) {
            var s, o, a;
            if (t && t.startsWith("exchange-"))
                return function(t, e=!1) {
                    var s;
                    const o = null === (s = window.pro) || void 0 === s ? void 0 : s.getProduct(t);
                    return !(void 0 === o || !(0,
                    i.isProductDefined)(o) || (e ? !o.idc_service_codes_delay : !o.idc_service_codes))
                }(t, e);
            const n = (t || "").toLowerCase();
            return null !== (a = null === (o = null === (s = window.pro) || void 0 === s ? void 0 : s.getIDCExchanges(e)) || void 0 === o ? void 0 : o.includes(n)) && void 0 !== a && a
        }
    }
    ,
    59171: (t,e,s)=>{
        "use strict";
        var i = s(244842)
          , o = [{
            d: "E-Mini S&P 500",
            t: "ES"
        }, {
            d: "E-Mini Nasdaq 100",
            t: "NQ"
        }, {
            d: "Gold",
            t: "GC"
        }, {
            d: "Silver",
            t: "SI"
        }, {
            d: "Crude Oil WTI",
            t: "CL"
        }, {
            d: "Natural Gas",
            t: "NG"
        }, {
            d: "Australian Dollar",
            t: "6A"
        }, {
            d: "Australian Dollar (Floor)",
            t: "AD"
        }, {
            d: "Euro FX",
            t: "6E"
        }, {
            d: "Euro FX (Floor)",
            t: "EC"
        }, {
            d: "Corn",
            t: "ZC"
        }, {
            d: "Corn (Floor)",
            t: "C"
        }, {
            d: "Eurodollar",
            t: "GE"
        }, {
            d: "Eurodollar (Floor)",
            t: "ED"
        }]
          , a = function() {
            var t = [{
                pattern: "(",
                ctor: n
            }, {
                pattern: ")",
                ctor: l
            }, {
                pattern: "+",
                ctor: h
            }, {
                pattern: "-",
                ctor: c
            }, {
                pattern: "*",
                ctor: d
            }, {
                pattern: "/",
                ctor: g
            }, {
                pattern: "^",
                ctor: u
            }, {
                pattern: /\d+(?:\.\d*|(?![a-zA-Z0-9_!:.&]))|\.\d+/,
                ctor: w
            }, {
                pattern: /\./,
                ctor: C
            }, {
                pattern: i.enabled("charting_library_base") ? /[a-zA-Z0-9_\u0370-\u1FFF_\u2E80-\uFFFF^][a-zA-Z0-9_\u0020\u0370-\u1FFF_\u2E80-\uFFFF_!:.&]*|'.+?'/ : /[a-zA-Z0-9_\u0370-\u1FFF_\u2E80-\uFFFF][a-zA-Z0-9_\u0020\u0370-\u1FFF_\u2E80-\uFFFF_!|:.&]*|'.+?'/,
                ctor: b
            }, {
                pattern: /'[^']*/,
                ctor: f
            }, {
                pattern: /[\0-\x20\s]+/,
                ctor: a
            }];
            function e(t, e) {
                var s = function() {};
                return s.prototype = e.prototype,
                t.prototype = new s,
                t
            }
            function s() {}
            function a(t) {
                this.value = t
            }
            function n() {}
            function l() {}
            function r() {}
            function h() {}
            function c() {}
            function d() {}
            function g() {}
            function u() {}
            s.prototype.toString = function() {
                return this.value
            }
            ,
            e(a, s),
            e(n, s),
            n.prototype.value = "(",
            e(l, s),
            l.prototype.value = ")",
            e(r, s),
            e(h, r),
            h.prototype.value = "+",
            h.prototype.precedence = 0,
            h.prototype.commutative = !0,
            e(c, r),
            c.prototype.value = "-",
            c.prototype.precedence = 0,
            c.prototype.commutative = !1,
            e(d, r),
            d.prototype.value = "*",
            d.prototype.precedence = 1,
            d.prototype.commutative = !0,
            e(g, r),
            g.prototype.value = "/",
            g.prototype.precedence = 1,
            g.prototype.commutative = !1,
            e(u, r),
            u.prototype.value = "^",
            u.prototype.precedence = 2,
            u.prototype.commutative = !1;
            var p = /^'?(?:([A-Z0-9_]+):)?(.*?)'?$/i
              , m = /[+\-/*]/;
            function b(t) {
                this.value = t
            }
            function w(t) {
                this.value = t
            }
            function _(t) {
                this.value = t
            }
            function f() {
                b.apply(this, arguments)
            }
            function C() {
                w.apply(this, arguments)
            }
            e(b, s),
            b.prototype.toString = function() {
                if (this.hasOwnProperty("_ticker")) {
                    var t = m.test(this._ticker) ? "'" : "";
                    return t + (this._exchange ? this._exchange + ":" : "") + this._ticker + t
                }
                return this.value
            }
            ,
            b.prototype.parse = function() {
                var t = p.exec(this.value);
                t[1] && (this._exchange = t[1]),
                this._ticker = t[2]
            }
            ,
            b.prototype.parseAsFutures = function() {
                this.hasOwnProperty("_ticker") || this.parse();
                for (var t = function(t) {
                    return o.some((function(e) {
                        return e.t === t
                    }
                    ))
                }, e = 2; e >= 1; --e) {
                    var s = this._ticker.slice(0, e);
                    if (t(s)) {
                        this._root = s,
                        this._contract = this._ticker.slice(e);
                        break
                    }
                }
            }
            ,
            b.prototype.exchange = function(t) {
                if (this.hasOwnProperty("_ticker") || this.parse(),
                !(arguments.length > 0))
                    return this._exchange;
                null == t ? delete this._exchange : this._exchange = t + ""
            }
            ,
            b.prototype.ticker = function(t) {
                if (this.hasOwnProperty("_ticker") || this.parse(),
                !(arguments.length > 0))
                    return this._ticker;
                null == t ? delete this._ticker : this._ticker = t + "",
                delete this._root,
                delete this._contract
            }
            ,
            b.prototype.root = function(t) {
                if (this.hasOwnProperty("_root") || this.parseAsFutures(),
                !(arguments.length > 0))
                    return this._root;
                null == t ? delete this._root : (this._root = t + "",
                this._root && (this._ticker = this._root + (this._contract || "")))
            }
            ,
            b.prototype.contract = function(t) {
                if (this.hasOwnProperty("_contract") || this.parseAsFutures(),
                !(arguments.length > 0))
                    return this._root;
                null == t ? delete this._contract : (this._contract = t + "",
                this._root && (this._ticker = this._root + this._contract))
            }
            ,
            e(w, s),
            w.prototype.toString = function() {
                return this.hasOwnProperty("_normalizedValue") ? this._normalizedValue : this.value
            }
            ,
            w.prototype.parse = function() {
                this._normalizedValue = this.value.replace(/^0+|\.0*$/g, "").replace(/(\.\d*?)0+$/, "$1").replace(/^(\.|$)/, "0$1")
            }
            ,
            _.prototype.toString = function() {
                return this.value
            }
            ,
            e(f, b),
            f.prototype.isIncomplete = !0,
            f.prototype.incompleteSuggest = function() {
                if ("'" !== this.value)
                    return String("'")
            }
            ,
            e(C, w),
            C.prototype.isIncomplete = !0;
            var v = new RegExp(t.map((function(t) {
                return "(" + ("string" == typeof t.pattern ? t.pattern.replace(/[\^$()[\]{}*+?|\\]/g, "\\$&") : t.pattern.source) + ")"
            }
            )).concat(".").join("|"),"g");
            function y(e, s) {
                var i, o = [];
                t: for (; i = v.exec(e); ) {
                    for (var n = t.length; n--; )
                        if (i[n + 1]) {
                            if (t[n].ctor) {
                                var l = new t[n].ctor(i[n + 1]);
                                l._offset = i.index,
                                o.push(l)
                            }
                            continue t
                        }
                    var r = new _(i[0]);
                    r._offset = i.index,
                    o.push(r)
                }
                if (s && s.recover) {
                    var h;
                    for (n = o.length; n--; ) {
                        var c = o[n];
                        if (c instanceof w || c instanceof b) {
                            if (void 0 !== h) {
                                var d = new b("")
                                  , g = o.splice(n, h - n + 1, d);
                                d.value = g.map((function(t) {
                                    return t.value
                                }
                                )).join("")
                            }
                            h = n
                        } else
                            c instanceof a || (h = void 0)
                    }
                }
                return o
            }
            function k(t) {
                for (var e = [], s = 0; s < t.length; s++)
                    t[s]instanceof a || e.push(t[s]);
                return e
            }
            function L(t) {
                t = k(t);
                for (var e, s = [], i = [], o = 0; o < t.length; o++) {
                    var a = t[o];
                    if (a instanceof r)
                        i.length && i[i.length - 1].minPrecedence > a.precedence && (i[i.length - 1].minPrecedence = a.precedence);
                    else if (a instanceof n)
                        i.push(e = {
                            minPrecedence: 1 / 0,
                            openBraceIndex: o
                        });
                    else if (a instanceof l) {
                        var h = t[(e = i.pop()).openBraceIndex - 1]
                          , c = t[o + 1];
                        c instanceof r && !(c.precedence <= e.minPrecedence) || !(!(h instanceof r) || h.precedence < e.minPrecedence || h.precedence === e.minPrecedence && h.commutative) || (s.unshift(e.openBraceIndex),
                        s.push(o),
                        i.length && i[i.length - 1].minPrecedence > e.minPrecedence && (i[i.length - 1].minPrecedence = e.minPrecedence))
                    }
                }
                for (o = s.length; o--; )
                    t.splice(s[o], 1);
                return t
            }
            function S(t) {
                if ("string" != typeof t)
                    throw new TypeError("expression must be a string");
                return (t = y(t)).filter((function(t) {
                    return t instanceof b
                }
                )).map((function(t) {
                    return t.exchange()
                }
                )).filter((function(t) {
                    return t
                }
                ))
            }
            function T(t) {
                return 1 !== (t = S(t)).length ? null : t[0]
            }
            function F(t, e) {
                return (t = S(t)).some((function(t) {
                    return e.includes((t || "").toUpperCase())
                }
                ))
            }
            function P(t) {
                return t.join("")
            }
            return {
                tokenize: y,
                validate: function(t) {
                    if (i.enabled("charting_library_base"))
                        return {
                            currentState: "var"
                        };
                    for (var e = "init", s = "var", o = e, h = {
                        warnings: [],
                        errors: [],
                        isEmpty: !0
                    }, c = [], d = 0; d < t.length; d++) {
                        if (!((u = t[d])instanceof a)) {
                            if (delete h.isEmpty,
                            u.isIncomplete) {
                                var g = {
                                    status: "incomplete",
                                    reason: "incomplete_token",
                                    offset: u._offset,
                                    token: u
                                };
                                if (u.incompleteSuggest && (g.recover = {
                                    append: u.incompleteSuggest()
                                }),
                                h.warnings.push(g),
                                d !== t.length - 1) {
                                    g.status = "error";
                                    continue
                                }
                            }
                            if (u instanceof b || u instanceof w) {
                                if (o === s) {
                                    h.errors.push({
                                        status: "error",
                                        reason: "unexpected_token",
                                        offset: u._offset,
                                        token: u
                                    });
                                    continue
                                }
                                o = s
                            } else if (u instanceof r) {
                                if (o !== s) {
                                    h.errors.push({
                                        status: "error",
                                        reason: "unexpected_token",
                                        offset: u._offset,
                                        token: u
                                    });
                                    continue
                                }
                                o = "operator"
                            } else if (u instanceof n) {
                                if (o === s) {
                                    h.errors.push({
                                        status: "error",
                                        reason: "unexpected_token",
                                        offset: u._offset,
                                        token: u
                                    });
                                    continue
                                }
                                c.push(u),
                                o = e
                            } else if (u instanceof l) {
                                if (o !== s) {
                                    h.errors.push({
                                        status: "error",
                                        reason: "unexpected_token",
                                        offset: u._offset,
                                        token: u
                                    });
                                    continue
                                }
                                c.pop() || h.errors.push({
                                    status: "error",
                                    reason: "unbalanced_brace",
                                    offset: u._offset,
                                    token: u,
                                    recover: {
                                        prepend: new n
                                    }
                                }),
                                o = s
                            } else
                                u instanceof _ && h.errors.push({
                                    status: "error",
                                    reason: "unparsed_entity",
                                    offset: u._offset,
                                    token: u
                                })
                        }
                    }
                    for (h.braceBalance = c.length,
                    o !== s && h.warnings.push({
                        status: "incomplete"
                    }); c.length; ) {
                        var u;
                        g = {
                            status: "incomplete",
                            reason: "unbalanced_brace",
                            offset: (u = c.pop())._offset,
                            token: u
                        };
                        o === s && (g.recover = {
                            append: new l
                        }),
                        h.warnings.push(g)
                    }
                    return h.currentState = o,
                    0 === h.warnings.length && delete h.warnings,
                    0 === h.errors.length && delete h.errors,
                    h
                },
                factorOutBraces: L,
                normalizeTokens: function(t) {
                    for (var e = 0; e < t.length; e++)
                        t[e].parse && t[e].parse();
                    return t
                },
                flip: function(t) {
                    var e = function(t) {
                        for (var e, s = 0, i = 1, o = 2, h = 3, c = s, d = 0, u = 0; u < t.length; u++) {
                            var p = t[u];
                            if (!(p instanceof a))
                                switch (c) {
                                case s:
                                    if (!(p instanceof w && 1 == +p.value))
                                        return !1;
                                    c = i;
                                    break;
                                case i:
                                    if (!(c === i && p instanceof g))
                                        return !1;
                                    c = o,
                                    e = u + 1;
                                    break;
                                case o:
                                    if (p instanceof n)
                                        c = h,
                                        d = 1;
                                    else if (p instanceof r)
                                        return !1;
                                    break;
                                case h:
                                    p instanceof n ? d++ : p instanceof l && --d <= 0 && (c = o)
                                }
                        }
                        return t.slice(e)
                    }(t);
                    return L(e || [new w("1"), new g, new n].concat(t).concat(new l))
                },
                hasBatsSymbols: function(t) {
                    return F(t, ["BATS"])
                },
                hasEodSymbols: function(t) {
                    return (t = T(t)) && -1 !== t.toUpperCase().indexOf("_EOD")
                },
                hasChxjpySymbols: function(t) {
                    return F(t, ["CHXJPY"])
                },
                hasFreeDelaySymbols: function(t) {
                    return F(t, pro.getProductsByType(pro.PRODUCT_TYPES.exchange).map((function(t) {
                        return t.exchange.toUpperCase() + "_DLY"
                    }
                    )))
                },
                getExchange: T,
                getExchanges: S,
                isExchange: function(t, e) {
                    return !!(t = T(t)) && t.substring(0, e.length) === e
                },
                SymbolToken: b,
                IncompleteSymbolToken: f,
                NumberToken: w,
                BinaryOperatorToken: r,
                OpenBraceToken: n,
                CloseBraceToken: l,
                ticker: function(t) {
                    return new b(t).ticker()
                },
                shortName: function(t) {
                    if ("string" != typeof t)
                        throw new TypeError("expression must be a string");
                    var e = L(k(y(t)));
                    return e.forEach((function(t) {
                        t instanceof b && t.exchange(null)
                    }
                    )),
                    P(e)
                },
                normalize: function(t) {
                    if ("string" != typeof t)
                        throw new TypeError("expression must be a string");
                    return P(L(k(y(t))))
                }
            }
        }();
        t.exports = a
    }
    ,
    824837: (t,e,s)=>{
        "use strict";
        s(401580)
    }
    ,
    854734: (t,e,s)=>{
        "use strict";
        s(9757);
        var i = s(650151)
          , o = s(12481)
          , a = (s(730128),
        s(192780))
          , n = s(901107)
          , l = s(185515)
          , r = s(242907)
          , h = s(410899)
          , c = s(596080)
          , d = s(798218)
          , g = s(453290)
          , u = (s(618299),
        s(135617),
        s(567752),
        s(497754))
          , p = s.n(u)
          , m = (s(957879),
        s(213398),
        s(790188))
          , b = s(724377)
          , w = s(745269)
          , _ = s(17966)
          , f = s(607546)
          , C = s(599612)
          , v = s(630440)
          , y = s(246733)
          , k = s(503344)
          , L = s(208817)
          , S = s(541558)
          , T = s(668616)
          , F = s(327034)
          , P = s(600303)
          , x = s(719240)
          , E = s(401580)
          , j = s(606311)
          , M = s(62802)
          , D = s(201089)
          , $ = s(960116)
          , B = s(951004)
          , N = s(39654)
          , W = (s(490361),
        s(383906),
        s(957879))
          , A = s(213398);
        const U = (0,
        D.getLogger)("WidgetWatchlist")
          , q = ["symbolActiveColor", "symbolShortNameColor", "symbolDescriptionColor", "symbolSeparatorColor", "tabActiveColor", "tabInactiveColor", "tabSliderColor", "changeUpColor", "changeDownColor", "changeNeutralColor", "lastColor", "lastGrowingFlashColor", "lastFallingFlashColor"]
          , H = ["plotLineColor", "plotLineColorGrowing", "plotLineColorFalling", "gridLineColor", "scaleFontColor", "belowLineFillColorGrowing", "belowLineFillColorFalling", "belowLineFillColorGrowingBottom", "belowLineFillColorFallingBottom", "lastPriceLineColor", "lastPriceLineColorGrowing", "lastPriceLineColorFalling"];
        class O {
            constructor(t, e) {
                if (this._symbols = [],
                this._chart = null,
                this._symbol = null,
                this._started = !1,
                this._hasDataPromise = null,
                t && t.length || (U.logError("`$el` is required"),
                (0,
                i.assert)(Boolean(t && t.length), "`$el` is required")),
                this.$el = t,
                this.$chart = t.find(".js-chart").eq(0),
                this.$symbolsWrapper = t.find(".js-symbols-wrapper").eq(0),
                this.hasChart = !!this.$chart.length,
                this.settings = this.transferSettings(e),
                this.showDataMode = !(!1 === this.settings.showDataMode),
                this.showMarketStatus = !(!1 === this.settings.showMarketStatus),
                this.chartColorMap = this.settings.chartColorMap,
                this.widgetColorClassMap = this.settings.widgetColorClassMap,
                "hotlists" === this.settings.widgetName || this.settings.isEmbedWidget) {
                    this._symbols = this.$el.data("symbols");
                    this.$el.find(".js-symbols-wrapper").find(".js-symbols-body").append(this._renderPage())
                }
                this.settings.isEmbedWidget && this.adjustToAvailableSizes(),
                this.start()
            }
            transferSettings(t) {
                const e = t.utmInfo ? W.param(t.utmInfo) : void 0;
                let s;
                if (t.largeChartUrl) {
                    s = t.largeChartUrl;
                    s.match(/^https?:\/\//) || (s = "http://" + s)
                }
                return {
                    chartColorMap: Object.assign({}, this.defaultChartColors, t.chartColorMap),
                    customer: t.customer,
                    dateRange: t.dateRange,
                    dateRangeOptions: t.dateRangeOptions,
                    disableLastFallingFlash: Boolean(t.disableLastFallingFlash),
                    disableLastGrowingFlash: Boolean(t.disableLastGrowingFlash),
                    hideAbsoluteChange: Boolean(t.hideAbsoluteChange),
                    indexNameBold: t.indexNameBold,
                    indexNonClickable: t.indexNonClickable,
                    isEmbedWidget: t.isEmbedWidget,
                    largeChartUrl: s,
                    noLinks: t.noLinks,
                    onlyDescription: t.onlyDescription,
                    paintLastWithChangeColors: Boolean(t.paintLastWithChangeColors),
                    showDataMode: t.showDataMode,
                    showMarketStatus: t.showMarketStatus,
                    showTitles: t.showTitles,
                    tradingviewBaseUrl: t.tradingviewBaseUrl,
                    utmStringified: e,
                    valueBold: t.valueBold,
                    valueTitleMarked: t.valueTitleMarked,
                    widgetColorClassMap: Object.assign({}, t.widgetColorClassMap),
                    widgetName: t.widgetName,
                    showSymbolLogo: t.showSymbolLogo,
                    locale: t.locale,
                    showFloatingTooltip: t.showFloatingTooltip,
                    colorTheme: t.colorTheme
                }
            }
            get $symbols() {
                return this.$el.find(".js-quote-ticker")
            }
            set symbols(t) {
                let e, s;
                const i = this._symbols.map((t=>t.s))
                  , o = t.map((t=>t.s))
                  , a = (t,s)=>W(s).data("symbol") === e;
                if (i && i.toString() !== o.toString()) {
                    const n = {}
                      , l = []
                      , r = [];
                    for (let t = 0; t < i.length; t++) {
                        e = i[t];
                        const r = o.indexOf(e)
                          , h = t
                          , c = this.$symbols.filter(a);
                        r !== h && l.push(e),
                        -1 === r ? (this._stopSymbolRow(c),
                        this._symbol === e && (s = o[h])) : n[e] = c.detach()
                    }
                    const h = this.$el.find(".js-symbols-wrapper").find(".js-symbols-body");
                    h.empty(),
                    this.settings.showTitles && h.append(this._renderTitle()),
                    o.forEach((t=>{
                        t in n ? h.append(n[t]) : (l.push(t),
                        r.push(t),
                        this._renderSymbol({
                            s: t
                        })),
                        s && s === t && (this.symbol = s)
                    }
                    )),
                    this._symbols = t,
                    this.$symbols.each(((t,e)=>{
                        const s = W(e)
                          , i = s.data("symbol");
                        -1 !== l.indexOf(i) && (s.addClass("tv-site-table__row--updated"),
                        setTimeout((()=>s.removeClass("tv-site-table__row--updated")), 2 * w.dur)),
                        -1 !== r.indexOf(i) && this._startSymbolRow(s)
                    }
                    ))
                }
            }
            get defaultChartColors() {
                return {
                    gridLineColor: (0,
                    y.generateColor)(m.colorsPalette["color-widget-border"], 100),
                    scaleFontColor: (0,
                    y.generateColor)(m.colorsPalette["color-text-secondary"]),
                    plotLineColor: (0,
                    y.generateColor)(m.colorsPalette["color-brand"]),
                    plotLineColorGrowing: void 0,
                    plotLineColorFalling: void 0,
                    belowLineFillColorGrowing: (0,
                    y.generateColor)(m.colorsPalette["color-tv-blue-500"], 82),
                    belowLineFillColorFalling: (0,
                    y.generateColor)(m.colorsPalette["color-tv-blue-500"], 82),
                    belowLineFillColorGrowingBottom: (0,
                    y.generateColor)(m.colorsPalette["color-tv-blue-500"], 100),
                    belowLineFillColorFallingBottom: (0,
                    y.generateColor)(m.colorsPalette["color-tv-blue-500"], 100),
                    lastPriceLineColor: (0,
                    y.generateColor)(m.colorsPalette["color-brand"], 50),
                    lastPriceLineColorGrowing: void 0,
                    lastPriceLineColorFalling: void 0
                }
            }
            get pageTemplates() {
                return {
                    page: "\n\t\t\t\t{{#showTitles}}\n\t\t\t\t\t{{>title}}\n\t\t\t\t{{/showTitles}}\n\t\t\t\t{{#symbols}}\n\t\t\t\t\t{{>symbol}}\n\t\t\t\t{{/symbols}}",
                    symbol: `\n\t\t\t\t<div class="tv-widget-watch-list__row js-quote-ticker tv-site-table__row {{#showChart}} tv-site-table__row--interactive tv-widget-watch-list__row--interactive{{/showChart}}{{#updated}} tv-site-table__row--updated{{/updated}}" data-symbol="{{ s }}" data-description="{{ description }}">\n\t\t\t\t\t<div class="tv-site-table__column tv-widget-watch-list__main-column{{#symbolColumnClass}} {{symbolColumnClass}}{{/symbolColumnClass}}">\n\t\t\t\t\t\t<div class="tv-widget-watch-list__icon js-symbol-logo">\n\t\t\t\t\t\t\t${this.settings.showSymbolLogo && (0,
                    _.getCircleLogoAnyHtml)({
                        logoUrls: [],
                        size: "medium"
                    })}\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class="tv-widget-watch-list__name">\n\t\t\t\t\t\t\t<div class="tv-widget-watch-list__ticker">\n\t\t\t\t\t\t\t\t{{^noLinks}}\n\t\t\t\t\t\t\t\t\t<a\n\t\t\t\t\t\t\t\t\t\thref="{{^largeChartUrl}}{{ symbolUrl }}{{/largeChartUrl}}{{#largeChartUrl}}{{ largeChartUrl }}{{/largeChartUrl}}"\n\t\t\t\t\t\t\t\t\t\t{{#isEmbedWidget}}target="_top"{{/isEmbedWidget}}\n\t\t\t\t\t\t\t\t{{/noLinks}}\n\t\t\t\t\t\t\t\t{{#noLinks}}\n\t\t\t\t\t\t\t\t\t<span\n\t\t\t\t\t\t\t\t{{/noLinks}}\n\t\t\t\t\t\t\t\t\t\tdata-symbol="{{ s }}"\n\t\t\t\t\t\t\t\t\t\tclass="\n\t\t\t\t\t\t\t\t\t\t\ttv-widget-watch-list__short-name\n\t\t\t\t\t\t\t\t\t\t\tapply-overflow-tooltip\n\t\t\t\t\t\t\t\t\t\t\tjs-symbol-link\n\t\t\t\t\t\t\t\t\t\t\t{{#indexNameBold}}tv-widget-watch-list__short-name--bold{{/indexNameBold}}\n\t\t\t\t\t\t\t\t\t\t\t{{#noLinks}}tv-widget-watch-list__short-name--not-clickable{{/noLinks}}\n\t\t\t\t\t\t\t\t\t\t\t{{#onlyDescription}}\n\t\t\t\t\t\t\t\t\t\t\t\ttv-widget-watch-list__short-name--whole-height\n\t\t\t\t\t\t\t\t\t\t\t\t{{^description}}js-symbol-description-name{{/description}}\n\t\t\t\t\t\t\t\t\t\t\t\t{{#descriptionClass}}{{descriptionClass}}{{/descriptionClass}}\n\t\t\t\t\t\t\t\t\t\t\t{{/onlyDescription}}\n\t\t\t\t\t\t\t\t\t\t\t{{^onlyDescription}}\n\t\t\t\t\t\t\t\t\t\t\t\t{{#shortNameClass}}{{shortNameClass}}{{/shortNameClass}}\n\t\t\t\t\t\t\t\t\t\t\t{{/onlyDescription}}\n\t\t\t\t\t\t\t\t\t\t"\n\t\t\t\t\t\t\t\t\t>\n\t\t\t\t\t\t\t\t\t\t{{^onlyDescription}}{{ shortName }}{{/onlyDescription}}\n\t\t\t\t\t\t\t\t\t\t{{#onlyDescription}}\n\t\t\t\t\t\t\t\t\t\t\t{{#description}}{{ description }}{{/description}}\n\t\t\t\t\t\t\t\t\t\t{{/onlyDescription}}\n\t\t\t\t\t\t\t\t{{^noLinks}}\n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t{{/noLinks}}\n\t\t\t\t\t\t\t\t{{#noLinks}}\n\t\t\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t\t{{/noLinks}}\n\t\t\t\t\t\t\t\t{{#showDataMode}}\n\t\t\t\t\t\t\t\t\t<span class="tv-data-mode--watch-list js-data-mode"></span>\n\t\t\t\t\t\t\t\t{{/showDataMode}}\n\t\t\t\t\t\t\t\t{{#showMarketStatus}}\n\t\t\t\t\t\t\t\t\t<span class="tv-market-status--watch-list js-market-status"></span>\n\t\t\t\t\t\t\t\t{{/showMarketStatus}}\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t{{^onlyDescription}}\n\t\t\t\t\t\t\t<div>\n\t\t\t\t\t\t\t\t<span class="tv-widget-watch-list__description{{^isEmbedWidget}} tv-widget-watch-list__description--uppercase{{/isEmbedWidget}} apply-overflow-tooltip{{^description}} js-symbol-description-name{{/description}}{{#descriptionClass}} {{descriptionClass}}{{/descriptionClass}}">\n\t\t\t\t\t\t\t\t\t{{#description}}{{ description }}{{/description}}{{^description}}&nbsp;{{/description}}\n\t\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t{{/onlyDescription}}\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class="tv-widget-watch-list__quote-column tv-site-table__column tv-site-table__column--align_right tv-site-table__column--last-phone-vertical{{#symbolColumnClass}} {{symbolColumnClass}}{{/symbolColumnClass}}">\n\t\t\t\t\t\t<div class="tv-widget-watch-list__last-wrap">\n\t\t\t\t\t\t\t<div class="tv-widget-watch-list__last{{#valueBold}} tv-widget-watch-list__last--bold{{/valueBold}}{{#lastClass}} {{lastClass}}{{/lastClass}}{{#lastDirection}} js-symbol-change-direction{{/lastDirection}} js-symbol-last apply-overflow-tooltip">\n\t\t\t\t\t\t\t\t{{#last}}{{ last }}{{/last}}{{^last}}&nbsp;{{/last}}\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class="tv-widget-watch-list__change{{#hideAbsoluteChange}} tv-widget-watch-list__change--whole-height{{/hideAbsoluteChange}} apply-overflow-tooltip js-symbol-change-direction">\n\t\t\t\t\t\t\t<span class="tv-widget-watch-list__change-inline{{#hideAbsoluteChange}} tv-widget-watch-list__change-inline--whole-height{{/hideAbsoluteChange}} js-symbol-change-pt">\n\t\t\t\t\t\t\t\t{{#change_pt}}{{ change_pt }}{{/change_pt}}{{^change_pt}}&nbsp;{{/change_pt}}\n\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t{{^hideAbsoluteChange}}\n\t\t\t\t\t\t\t<span class="tv-widget-watch-list__change-inline js-symbol-change">\n\t\t\t\t\t\t\t\t{{#change}}{{ change }}{{/change}}{{^change}}&nbsp;{{/change}}\n\t\t\t\t\t\t\t</span>\n\t\t\t\t\t\t\t{{/hideAbsoluteChange}}\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t</div>`,
                    title: '\n\t\t\t\t<div class="tv-site-table__row js-symbols-titles">\n\t\t\t\t\t<div class="tv-site-table__column tv-widget-watch-list__main-column tv-widget-watch-list__main-column--title">\n\t\t\t\t\t\t<div class="tv-widget-watch-list__name">\n\t\t\t\t\t\t\t<span class="tv-widget-watch-list__title tv-widget-watch-list__short-name--whole-height apply-overflow-tooltip">Index</span>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class="tv-widget-watch-list__quote-column tv-widget-watch-list__quote-column--title tv-site-table__column tv-site-table__column--align_right tv-site-table__column--last-phone-vertical">\n\t\t\t\t\t\t<div class="tv-widget-watch-list__last apply-overflow-tooltip tv-widget-watch-list__title">\n\t\t\t\t\t\t\tValue{{#valueTitleMarked}}*{{/valueTitleMarked}}\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class="tv-widget-watch-list__change tv-widget-watch-list__title apply-overflow-tooltip">\n\t\t\t\t\t\t\t<span class="tv-widget-watch-list__change-inline">Change</span>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t</div>'
                }
            }
            set symbol(t) {
                if (this._symbol = t,
                this._chart && this._chart.changeSymbol(t, this._getSeriesOptions()),
                this.hasChart) {
                    const e = p()("tv-site-table__row--highlighted tv-widget-watch-list__row--highlighted", this.widgetColorClassMap.symbolActiveColor);
                    this.$symbols.removeClass(e).filter(((e,s)=>W(s).data("symbol") === t)).addClass(e)
                } else
                    this.$symbols.filter(((e,s)=>W(s).data("symbol") === t))
            }
            get symbol() {
                return this._symbol || ""
            }
            start() {
                this._started || (this.symbol || (this.symbol = this.$symbols.eq(0).data("symbol")),
                this.hasChart && (this._bindSymbolClick(),
                this._startChart()),
                this._startSymbolRows(),
                this._started = !0)
            }
            stop() {
                this._started && (this._unbindSymbolClick(),
                this._stopChart(),
                this._stopSymbolRows(),
                this._started = !1)
            }
            hasData() {
                if (null === this._hasDataPromise) {
                    const t = [];
                    this.$symbols.each(((e,s)=>{
                        const i = W(s).data("watchlist-widget__symbol-row");
                        t.push(i.hasData())
                    }
                    )),
                    this._hasDataPromise = Promise.all(t).then((t=>t.some((t=>t))))
                }
                return this._hasDataPromise
            }
            adjustToAvailableSizes() {
                var t;
                const e = (0,
                i.ensureNotNull)(document.querySelector(".js-watchlist-widget"))
                  , s = (0,
                i.ensureNotNull)(document.querySelector(".js-quote-ticker"));
                let o = (0,
                i.ensureNotNull)(e.parentElement).offsetHeight - e.offsetHeight
                  , a = this.hasChart ? this.$chart[0].offsetHeight : 0
                  , n = this.$symbolsWrapper[0].offsetHeight
                  , l = this.$symbolsWrapper[0].scrollHeight - n;
                if (0 === o && 0 === l)
                    return;
                const r = s.offsetHeight;
                let h = 0;
                o > 0 && l > 0 ? h = Math.min(l, o / 2) : o < 0 && (h = this.hasChart ? Math.max(Math.floor(o / 2), r - n) : o),
                n += h,
                l -= h,
                o -= h,
                this.hasChart && (a += o,
                o = 0),
                this.hasChart && l > 0 && l < Math.floor(a / 4) && (a -= l,
                n += l),
                this.hasChart && a < 100 && (n -= 100 - a,
                a = 100),
                this.$symbolsWrapper[0].style.height = n + "px",
                this.hasChart && (this.$chart[0].style.height = a + "px",
                null === (t = this._chart) || void 0 === t || t.resizeByContainer())
            }
            _bindSymbolClick() {
                this.$el.on("click", ".js-quote-ticker", (t=>{
                    this.symbol = W(t.currentTarget).data("symbol")
                }
                ))
            }
            _unbindSymbolClick() {
                this.$el.off("click", ".js-quote-ticker")
            }
            _getSymbolDataToRender(t) {
                const [e,s] = t.s.split(":")
                  , i = t.t || s
                  , o = this.settings.largeChartUrl && (0,
                k.makeTemplateSymbolUrl)(this.settings.largeChartUrl, {
                    shortName: s,
                    exchange: e
                }) || ""
                  , a = (0,
                k.makeSymbolPageUrl)({
                    shortName: s,
                    exchange: e
                }, this.settings.utmInfo)
                  , n = t.d;
                return {
                    s: t.s,
                    description: n,
                    exchange: e,
                    shortName: i,
                    symbolUrl: a,
                    showChart: this.hasChart,
                    onlyDescription: this.settings.onlyDescription,
                    isEmbedWidget: this.settings.isEmbedWidget,
                    utmStringified: this.settings.utmStringified,
                    largeChartUrl: o,
                    tradingviewBaseUrl: this.settings.tradingviewBaseUrl,
                    showDataMode: this.showDataMode,
                    showMarketStatus: this.showMarketStatus,
                    indexNameBold: this.settings.indexNameBold,
                    valueBold: this.settings.valueBold,
                    shortNameClass: this.widgetColorClassMap.symbolShortNameColor,
                    descriptionClass: this.widgetColorClassMap.symbolDescriptionColor,
                    symbolColumnClass: this.widgetColorClassMap.symbolSeparatorColor,
                    lastClass: this.widgetColorClassMap.lastColor,
                    lastDirection: this.settings.paintLastWithChangeColors,
                    hideAbsoluteChange: this.settings.hideAbsoluteChange,
                    noLinks: this.settings.noLinks
                }
            }
            _renderSymbol(t) {
                return A.render(this.pageTemplates.symbol, this._getSymbolDataToRender(t))
            }
            _renderPage() {
                const t = [];
                return this._symbols.forEach((e=>t.push(this._getSymbolDataToRender(e)))),
                A.render(this.pageTemplates.page, {
                    symbols: t,
                    showTitles: this.settings.showTitles,
                    showDataMode: this.showDataMode,
                    showMarketStatus: this.showMarketStatus,
                    valueTitleMarked: this.settings.valueTitleMarked
                }, this.pageTemplates)
            }
            _renderTitle() {
                return A.render(this.pageTemplates.title, {
                    valueTitleMarked: this.settings.valueTitleMarked
                })
            }
            _startChart() {
                if (this._chart)
                    return void this._chart.enable();
                if (!this.symbol)
                    return;
                const t = this.settings.showFloatingTooltip
                  , e = this._getSeriesOptions();
                let s;
                if (t) {
                    const t = "dark" === this.settings.colorTheme ? m.colorsPalette["color-cold-gray-700"] : m.colorsPalette["color-cold-gray-200"];
                    s = {
                        vertLine: {
                            visible: !0,
                            style: B.LineStyle.Solid,
                            width: 1,
                            color: t
                        },
                        mode: B.CrosshairMode.Magnet
                    }
                }
                const i = (0,
                L.getMiniTimeFrameOptions)().filter((t=>!this.settings.dateRangeOptions || this.settings.dateRangeOptions.includes(t.value.value)));
                this._chart = new T.LightweightMiniChart({
                    symbol: this.symbol
                },this.$chart.get(0),null,{
                    timeframe: {
                        visible: !0,
                        container: this.$el.find(".js-timeframes").get(0),
                        value: this.settings.dateRange,
                        options: i,
                        size: "xsmall"
                    },
                    valuesTracking: t ? "1" : "0",
                    chartOptions: {
                        minWidth: this.$chart.width(),
                        minHeight: this.$chart.height(),
                        chart: {
                            grid: {
                                horzLines: {
                                    visible: !0,
                                    color: this.chartColorMap.gridLineColor,
                                    style: B.LineStyle.Dotted
                                }
                            },
                            crosshair: s,
                            layout: {
                                textColor: this.chartColorMap.scaleFontColor,
                                fontSize: 12
                            },
                            localization: {
                                locale: (0,
                                N.getIsoLanguageCodeFromLanguage)(this.settings.locale)
                            },
                            rightPriceScale: {
                                visible: !1
                            }
                        },
                        series: e,
                        loading: {
                            spinner: {
                                visible: !0
                            }
                        }
                    }
                })
            }
            _stopChart() {
                this._chart && this._chart.disable()
            }
            _getSeriesOptions() {
                return {
                    chartType: "area",
                    lineColor: this.chartColorMap.plotLineColor,
                    growingLineColor: this.chartColorMap.plotLineColorGrowing,
                    fallingLineColor: this.chartColorMap.plotLineColorFalling,
                    lineWidth: 2,
                    growingTopColor: this.chartColorMap.belowLineFillColorGrowing,
                    fallingTopColor: this.chartColorMap.belowLineFillColorFalling,
                    growingBottomColor: this.chartColorMap.belowLineFillColorGrowingBottom,
                    fallingBottomColor: this.chartColorMap.belowLineFillColorFallingBottom,
                    crosshairMarkerVisible: this.settings.showFloatingTooltip,
                    crosshairMarkerRadius: 3.5,
                    crosshairMarkerBorderColor: "dark" === this.settings.colorTheme ? m.colorsPalette["color-cold-gray-850"] : m.colorsPalette["color-white"],
                    scaleMargins: {
                        top: .01,
                        bottom: .05
                    }
                }
            }
            _startSymbolRows() {
                this.$symbols.each(((t,e)=>{
                    this._startSymbolRow(W(e))
                }
                ))
            }
            _startSymbolRow(t) {
                const e = t.data("watchlist-widget__symbol-row");
                e ? e.start() : t.data("watchlist-widget__symbol-row", new z(t,{
                    tradingviewBaseUrl: this.settings.tradingviewBaseUrl,
                    largeChartUrl: this.settings.largeChartUrl,
                    isEmbedWidget: this.settings.isEmbedWidget,
                    directionUpClass: this.widgetColorClassMap.changeUpColor,
                    directionDownClass: this.widgetColorClassMap.changeDownColor,
                    directionNeutralClass: this.widgetColorClassMap.changeNeutralColor,
                    lastGrowingClass: this.settings.disableLastGrowingFlash ? null : this.widgetColorClassMap.lastGrowingFlashColor,
                    lastFallingClass: this.settings.disableLastFallingFlash ? null : this.widgetColorClassMap.lastFallingFlashColor,
                    noLinks: this.settings.noLinks,
                    showSymbolLogo: this.settings.showSymbolLogo
                }))
            }
            _stopSymbolRows() {
                this.$symbols.each(((t,e)=>{
                    this._stopSymbolRow(W(e))
                }
                ))
            }
            _stopSymbolRow(t) {
                const e = t.data("watchlist-widget__symbol-row");
                e && e.stop()
            }
        }
        class z {
            constructor(t, e) {
                this._hasData = new E.WatchedValue,
                this._setSymbolLinkCompleted = !1,
                t && t.length || (U.logError("`$el` is required"),
                (0,
                i.assert)(Boolean(t && t.length), "`$el` is required")),
                this.$el = t,
                this.symbol = t.data("symbol"),
                this.description = t.data("description"),
                this.start(),
                this._largeChartUrl = e.largeChartUrl || "",
                this._utmInfo = e.utmInfo || {},
                this._isEmbedWidget = !!e.isEmbedWidget,
                this._noLinks = e.noLinks,
                this._showSymbolLogo = e.showSymbolLogo;
                const s = (0,
                r.pickFields)(e, ["directionUpClass", "directionDownClass", "directionNeutralClass", "lastGrowingClass", "lastFallingClass"]);
                this._directionUpClass = s.directionUpClass,
                this._directionDownClass = s.directionDownClass,
                this._directionNeutralClass = s.directionNeutralClass,
                this._lastGrowingClass = s.lastGrowingClass,
                this._lastFallingClass = s.lastFallingClass,
                this._setSymbolLogo = (0,
                f.getLogoUrlsHook)((t=>{
                    const e = this.symbol.split(":")[1]
                      , s = (this.description || e || "")[0];
                    (0,
                    i.ensureNotNull)(this.$el[0].querySelector(".js-symbol-logo")).innerHTML = (0,
                    _.getCircleLogoAnyHtml)({
                        logoUrls: t,
                        size: "medium",
                        placeholderLetter: s
                    })
                }
                ))
            }
            start() {
                this._startQuoteTicker().then((()=>{
                    this._startMarketStatus()
                }
                )).catch((t=>U.logError(`${t.exchange} ${t.reason}`)))
            }
            stop() {
                this._stopQuoteTicker(),
                this._stopMarketStatus()
            }
            hasData() {
                return void 0 === this._hasData.value() ? new Promise((t=>{
                    this._hasData.subscribe(t, {
                        once: !0
                    })
                }
                )) : Promise.resolve(this._hasData.value())
            }
            _startMarketStatus() {
                if (this.$el.find(".js-market-status")[0]) {
                    const t = new P.MarketStatusIndicator({
                        classSuffix: "--for-watch-list",
                        el: this.$el.find(".js-market-status")[0],
                        short: !0,
                        symbol: this.symbol
                    });
                    t.start(),
                    this.$el.data("market-status", t)
                }
                const t = this.$el.find(".js-data-mode")[0];
                if (t) {
                    const e = new x.DataModeIndicator({
                        classSuffix: "--for-watch-list",
                        el: t,
                        short: !0,
                        symbol: this.symbol
                    });
                    e.start(),
                    this.$el.data("data-mode", e)
                }
            }
            _stopMarketStatus() {
                const t = this.$el.data("market-status")
                  , e = this.$el.data("data-mode");
                t && t.stop(),
                e && e.stop()
            }
            _showSFWarning() {
                var t;
                const e = this.$el.get(0);
                if (e.getElementsByClassName("js-exclamationed-symbol").length)
                    return;
                const s = document.createElement("span");
                s.classList.add("tv-widget-watch-list__symbol-exclamation-mark", "js-exclamationed-symbol", "apply-common-tooltip"),
                s.setAttribute("title", (0,
                v.getWarningTextForFreeUsers)());
                const o = e.getElementsByClassName("js-symbol-link").item(0);
                o && (o.appendChild(s),
                null === (t = window.loginStateChange) || void 0 === t || t.subscribe(null, (()=>{
                    if (window.is_authenticated) {
                        const t = e.getElementsByClassName("js-exclamationed-symbol");
                        for (; t.length > 0; )
                            (0,
                            i.ensureNotNull)(t[0].parentNode).removeChild(t[0])
                    }
                }
                )))
            }
            _startQuoteTicker() {
                let t = this.$el.data("quote-ticker");
                if (t)
                    return t.enable(),
                    Promise.resolve(t);
                const e = this._showSFWarning.bind(this)
                  , s = (t,e,s)=>{
                    this._setSymbolLinkCompleted || this._noLinks || this._setSymbolLink(t),
                    this._showSymbolLogo && this._setSymbolLogo(t, e, s)
                }
                ;
                return new Promise(((i,o)=>{
                    (0,
                    C.check)(this.symbol, !1).then((o=>{
                        const a = {
                            dontDyePrice: !0,
                            addDescriptionTitle: !1,
                            signPositive: !0,
                            changePercentInBrackets: !1,
                            setStateHook: s,
                            changeDirectionUpClass: this._directionUpClass || void 0,
                            changeDirectionDownClass: this._directionDownClass || void 0,
                            changeDirectionNeutralClass: this._directionNeutralClass || void 0,
                            lastGrowingClass: this._lastGrowingClass || void 0,
                            lastFallingClass: this._lastFallingClass || void 0,
                            initedHook: ()=>{
                                this._hasData.setValue(!0)
                            }
                            ,
                            noSuchSymbolHook: ()=>{
                                this._hasData.setValue(!1)
                            }
                            ,
                            permissionDeniedHook: ()=>{
                                this._hasData.setValue(!1),
                                e()
                            }
                        };
                        t = new F.QuoteTicker(o,this.$el.get(0),a),
                        this.$el.data("quote-ticker", t),
                        i(t)
                    }
                    )).catch((t=>{
                        this._hasData.setValue(!1),
                        e(),
                        o(t)
                    }
                    ))
                }
                ))
            }
            _setSymbolLink(t) {
                const e = t.short_name
                  , s = t.exchange
                  , i = t.pro_name
                  , o = t.type;
                if (!(e && s && i && o))
                    return;
                const a = this.$el[0].getElementsByClassName("js-symbol-link")[0]
                  , n = this._largeChartUrl && this._isEmbedWidget
                  , l = {
                    shortName: e,
                    exchange: s,
                    proName: i,
                    type: o
                };
                a.href = n ? (0,
                k.makeTemplateSymbolUrl)(this._largeChartUrl, l) : (0,
                k.makeSymbolPageUrl)(l, this._utmInfo),
                this._setSymbolLinkCompleted = !0
            }
            _stopQuoteTicker() {
                const t = this.$el.data("quote-ticker");
                t && t.disable()
            }
        }
        const R = Object.assign({}, window.initData.widget_defaults);
        R.whitelabel = Boolean(window.initData.widgetDefaults.whitelabel),
        R.noLinks = Boolean(window.initData.widgetDefaults.noLinks);
        const G = (0,
        a.parseUrlHashParams)()
          , I = Object.assign({}, R);
        "showChart"in G && (I.show_chart = G.showChart),
        I.customer = window.TradingView.widgetCustomer,
        "showSymbolLogo"in G && (I.showSymbolLogo = Boolean(G.showSymbolLogo)),
        "showFloatingTooltip"in G && (I.showFloatingTooltip = Boolean(G.showFloatingTooltip)),
        I.dateRange = (0,
        g.getActualTimeFrame)(G.dateRange || window.initData.widgetDefaults.dateRange),
        G.dateRangeOptions && (I.dateRangeOptions = G.dateRangeOptions.map(g.getActualTimeFrame));
        const V = window.locale || R.locale || "en";
        I.locale = V;
        const Z = window.locale_domains[V] ? window.locale_domains[V] : window.locale_domains.en;
        I.tradingviewBaseUrl = Z ? document.location.protocol + "//" + Z : "",
        I.largeChartUrl = G.largeChartUrl;
        const K = G.isTransparent;
        G.tabs && (I.tabs = G.tabs),
        I.show_chart && (Object.assign(I, (0,
        r.pickFields)(G, H)),
        void 0 === I.belowLineFillColorFallingBottom && I.belowLineFillColorFalling && (I.belowLineFillColorFallingBottom = I.belowLineFillColorFalling),
        void 0 === I.belowLineFillColorGrowingBottom && I.belowLineFillColorGrowing && (I.belowLineFillColorGrowingBottom = I.belowLineFillColorGrowing)),
        I.colorTheme = G.colorTheme,
        Object.assign(I, (0,
        r.pickFields)(G, q)),
        G.tickerColorGrowing && G.tickerColorFalling && (I.paintLastWithChangeColors = !0,
        I.disableLastGrowingFlash = !0,
        I.disableLastFallingFlash = !0,
        I.changeUpColor = G.tickerColorGrowing,
        I.changeDownColor = G.tickerColorFalling),
        I.indexNameBold = Y("indexNameBold", G, I),
        I.valueBold = Y("valueBold", G, I),
        I.valueTitleMarked = Y("valueTitleMarked", G, I),
        I.paintLastWithChangeColors = Y("paintLastWithChangeColors", G, I),
        I.onlyDescription = Y("onlyDescription", G, I),
        I.hideAbsoluteChange = Y("hideAbsoluteChange", G, I);
        const Q = (0,
        l.filterUtmInfo)(G)
          , X = (0,
        i.ensureNotNull)(document.querySelector("#widget-market-overview-container"));
        K && (X.style.backgroundColor = "transparent"),
        (0,
        n.createEmbedWidgetWrapper)(X, "market-overview", Q, {
            isWhiteLabel: I.whitelabel,
            locale: V,
            customer: I.customer
        }),
        X.classList.add("tv-site-widget"),
        X.classList.add("tv-site-widget--bg_none"),
        X.innerHTML = '<div class="tv-widget-watch-list__head-embed js-widget-head">\n\t\t<div class="tv-site-widget__tabs\n\t\t\ttv-widget-watch-list__tabs\n\t\t\tjs-tabs\n\t\t"></div>\n\t</div>\n\t<div class="tv-widget-watch-list__body-embed js-widget-body">\n\t\t<div class="js-pages"></div>\n\t</div>',
        Object.assign(I, {
            utmInfo: Q
        }),
        I.onActivePageLoaded = t=>{
            t || (0,
            h.dispatchEventToParent)(c.IFrameEvents.Names.NoData, d.frameElementId, void 0)
        }
        ;
        const J = new class {
            constructor(t, e={}) {
                this._stopPageTimeouts = {},
                this._activePageLoadedPromise = null,
                this._destroyTabLabels = null,
                t || (U.logError("`el` is required"),
                (0,
                i.assert)(Boolean(t), "`el` is required")),
                this.$el = W(t),
                this.settings = this._prepareSettings(e),
                this._activePageLoadedPromise = null,
                this.tabsLabels = this.settings.tabs.map((t=>t.title || t.title_raw));
                const s = (0,
                r.pickFields)(this.settings, q);
                this.widgetColorClassMap = function(t) {
                    const e = (0,
                    S.randomHashN)(4);
                    return t.reduce(((t,s)=>{
                        const i = s.replace(/[A-Z]/g, (t=>`-${t.toLowerCase()}`));
                        return t[s] = `${i}--${e}`,
                        t
                    }
                    ), {})
                }(Object.keys(s)),
                t.appendChild(function(t, e, s) {
                    const i = (t,e)=>`.${t}, .${t}:hover, .${t}:active { color: ${e} }`
                      , o = {
                        symbolActiveColor: (t,e)=>`.${t} { background: ${e} }`,
                        symbolSeparatorColor: (t,e)=>`.${t}:after { background: ${e} }`,
                        tabSliderColor: (t,e)=>`.${t} { background: ${e} }`
                    }
                      , a = document.createElement("style")
                      , n = [];
                    for (const a of t) {
                        const t = s[a]
                          , l = e[a];
                        if (!t || !l || null === (0,
                        b.tryParseRgb)(l))
                            continue;
                        const r = o[a];
                        n.push(r ? r(t, l) : i(t, l))
                    }
                    return a.textContent = n.join(" "),
                    a
                }(q, s, this.widgetColorClassMap)),
                this.settings.isEmbedWidget || "hotlists" === this.widgetName ? (1 === this.settings.tabs.length && this.$el.find(".js-widget-head").addClass("i-hidden"),
                this.renderContent().then((()=>{
                    this._initPages(),
                    this.setAutoUpdate()
                }
                ), (t=>{
                    console.log("WidgetWatchlist constructor error", t)
                }
                ))) : this._initPages()
            }
            setAutoUpdate() {}
            get widgetName() {
                return "marketoverview"
            }
            get settingsKey() {
                return "watchlist__summary.properties"
            }
            get userSettings() {
                return {}
            }
            get templates() {
                return {
                    tab: '\n\t\t\t\t<div class="tv-widget-watch-list__blank-tab js-widget-tab" data-content="{{ title_raw }}">{{ title }}\n\t\t\t\t</div>',
                    tabContent: `\n\t\t\t\t<div class="tv-widget-watch-list{{^firstTab}} i-hidden{{/firstTab}}{{#firstTab}}{{#hotlistsSelectEnabled}} i-loading{{/hotlistsSelectEnabled}}{{/firstTab}}"{{#group}} data-tab-group="{{ group }}"{{/group}}>\n\t\t\t\t\t{{#showChart}}\n\t\t\t\t\t\t<div class="js-chart tv-widget-watch-list__chart"></div>\n\t\t\t\t\t\t<div class="js-timeframes tv-widget-watch-list__timeframe"></div>\n\t\t\t\t\t{{/showChart}}\n\t\t\t\t\t<div class="{{#isEmbedWidget}}tv-widget-watch-list__symbols-wrapper {{/isEmbedWidget}}js-symbols-wrapper"\n\t\t\t\t\t\t {{#minTableHeight}} style="min-height: {{ minTableHeight }}" {{/minTableHeight}}\n\t\t\t\t\t>\n\t\t\t\t\t\t<div class="tv-site-table tv-widget-watch-list__table\n\t\t\t\t\t\t\t{{#isEmbedWidget}} tv-site-table--start-border {{/isEmbedWidget}}\n\t\t\t\t\t\t\t{{^showChart}} tv-site-table--no-start-border {{/showChart}}\n\t\t\t\t\t\t\t{{#forceEndBorder}} tv-site-table--with-end-border {{/forceEndBorder}}\n\t\t\t\t\t\t\t js-symbols-body">\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t\t{{^isEmbedWidget}}\n\t\t\t\t\t\t{{#quickLink}}\n\t\t\t\t\t\t\t<div class="js-quick-link-wrapper tv-feed-widget__quick-link-wrap tv-feed-widget__padded">\n\t\t\t\t\t\t\t\t<a class="tv-feed-widget__quick-link" href="{{ quickLink.href }}">{{ quickLink.title }}${s(108999)}</a>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t{{/quickLink}}\n\t\t\t\t\t{{/isEmbedWidget}}\n\t\t\t\t</div>`,
                    tabContentSkin: '\n\t\t\t\t<div class="tv-widget-watch-list{{^firstTab}} i-hidden{{/firstTab}}{{#firstTab}}{{#hotlistsSelectEnabled}} i-loading{{/hotlistsSelectEnabled}}{{/firstTab}}"{{#group}} data-tab-group="{{ group }}"{{/group}}>\n\t\t\t\t</div>'
                }
            }
            renderContent() {
                const t = this.settings.tabs.map((t=>{
                    const e = W(A.render(this.templates.tabContent, {
                        showChart: this.settings.show_chart,
                        isEmbedWidget: this.settings.isEmbedWidget,
                        group: t.group,
                        firstTab: t === this.settings.tabs[0],
                        forceEndBorder: this.settings.force_end_border
                    }, this.templates));
                    return e.data("symbols", t.symbols.map((t=>Object({
                        s: t.s,
                        d: t.d,
                        t: t.t
                    })))),
                    this.$el.find(".js-pages").append(e),
                    !0
                }
                ));
                return new Promise((e=>{
                    Promise.all(t).then(e)
                }
                ))
            }
            saveToTVSettings(t) {
                const e = window.locale;
                let s = (0,
                M.getJSON)(this.settingsKey);
                s || (s = {}),
                s[e] = t,
                (0,
                M.setJSON)(this.settingsKey, s)
            }
            destroy() {
                this.$pagesContainer && (this.$pagesContainer.children().each(((t,e)=>{
                    this._stopPage(W(e))
                }
                )),
                this._destroyTabLabels && this._destroyTabLabels())
            }
            resetCaches() {
                this.$pagesContainer && this.$pagesContainer.children().each(((t,e)=>{
                    const s = W(e);
                    this._getCachedWidgetPage(s) && this._cacheWidgetPage(s, this._createWidgetWatchlistPage(s))
                }
                ))
            }
            adjustToAvailableSizes() {
                this.$pagesContainer.children().each(((t,e)=>{
                    if (!e.classList.contains("i-hidden")) {
                        const t = this._getCachedWidgetPage(W(e));
                        null == t || t.adjustToAvailableSizes()
                    }
                }
                ))
            }
            _startPage(t) {
                let e = this._getCachedWidgetPage(t);
                if (e ? (this._deleteStopTimeout(t),
                e.start()) : (e = this._createWidgetWatchlistPage(t),
                this._cacheWidgetPage(t, e)),
                "function" == typeof this.settings.onActivePageLoaded) {
                    const t = this._activePageLoadedPromise = e.hasData().then((e=>{
                        t === this._activePageLoadedPromise && this.settings.onActivePageLoaded && this.settings.onActivePageLoaded(e)
                    }
                    ))
                }
            }
            _getCachedWidgetPage(t) {
                return t.data("watchlist-widget-page")
            }
            _initPages() {
                const t = this.$el.find(".js-tabs").eq(0)
                  , e = this.$el.find(".js-pages").eq(0)
                  , s = 1 === e.children().length;
                this.settings.fixedChartHeight && (this._normalizeSymbolListHeight(),
                setTimeout((()=>this._adjustSymbolsListHeight()), 0)),
                s ? this._startPage(e.children().eq(0)) : (this._initTabs(t, e),
                !this.settings.fixedChartHeight && this.settings.adjust_widget_height && e.find(".js-chart").length && this._adjustChartHeight(e, this.settings.adjust_widget_height)),
                this.$pagesContainer = e
            }
            _getPagesArray(t) {
                return t ? Array.prototype.slice.call(t.children) : []
            }
            _prepareSettings(t) {
                let e;
                const s = this.$el.data("widget-data");
                if (s)
                    if (s.is_embed_widget)
                        e = Object.assign({}, s, t);
                    else {
                        const i = this.userSettings;
                        (!1 === s.hotlists_select_enabled || s.override_user_exchange) && delete i.exchange,
                        e = Object.assign({}, s, t, i)
                    }
                else
                    this.$el.data("widget-data", t),
                    e = t;
                return void 0 !== e.is_embed_widget && (e.isEmbedWidget = e.is_embed_widget),
                e.is_embed_widget = void 0,
                e
            }
            _initTabs(t, e) {
                const s = this._getPagesArray(e.get(0));
                (0,
                $.createTabLabels)("watchlist-widget-tab-labels", this.tabsLabels, t.get(0), s, this._onActivePageChanged.bind(this)).then((t=>this._destroyTabLabels = t)),
                this._startPage(W((0,
                i.ensureNotNull)(this._getActivePage(s))))
            }
            _adjustChartHeight(t, e) {
                const s = t.children()
                  , o = document.querySelector(".js-quote-ticker")
                  , a = document.querySelector(".js-chart");
                if (o && a) {
                    const t = o.offsetHeight
                      , n = a.offsetHeight;
                    for (let o = 0; o < s.length; o++) {
                        let a = e - s[o].querySelectorAll(".js-quote-ticker").length;
                        if (a === e && (a = 1),
                        a < e) {
                            const e = s[o].querySelector(".js-chart");
                            (0,
                            i.ensureNotNull)(e).style.height = `${n + t * a}px`
                        }
                    }
                }
            }
            _normalizeSymbolListHeight() {
                const t = (0,
                i.ensureNotNull)(this.$el[0].firstElementChild)
                  , e = t.querySelector(".js-pages");
                if (!e)
                    return;
                let s = 0;
                if (e) {
                    let i = 0;
                    for (let t = 0; t < e.children.length; t++) {
                        const o = e.children[t];
                        if (i = Math.max(o.querySelectorAll(".js-quote-ticker").length, i),
                        !o.classList.contains("i-hidden")) {
                            const t = o.querySelector(".js-quote-ticker");
                            t && (s = t.offsetHeight)
                        }
                    }
                    const o = t.querySelectorAll(".js-symbols-wrapper");
                    for (let t = 0; t < o.length; t++) {
                        o[t].style.minHeight = s * i + "px"
                    }
                }
            }
            _adjustSymbolsListHeight() {
                const t = this.$el[0].firstElementChild
                  , e = getComputedStyle(t)
                  , s = t.offsetHeight - parseInt(e.paddingTop) - parseInt(e.paddingBottom)
                  , i = t.querySelector(".js-widget-head");
                let o = 0;
                if (i) {
                    const t = getComputedStyle(i);
                    o = i.offsetHeight + parseInt(t.marginTop) + parseInt(t.marginBottom)
                }
                const a = t.querySelector(".js-pages");
                if (!a)
                    return;
                let n = 0
                  , l = 0
                  , r = 0;
                for (let t = 0; t < a.children.length; t++) {
                    const e = a.children[t];
                    if (!e.classList.contains("i-hidden")) {
                        const t = e.querySelector(".js-chart");
                        t && (n = t.offsetHeight);
                        const s = e.querySelector(".js-timeframes");
                        if (s) {
                            const t = getComputedStyle(s);
                            l = s.offsetHeight + parseInt(t.marginTop) + parseInt(t.marginBottom)
                        }
                        const i = e.querySelector(".js-quick-link-wrapper");
                        i && (r = i.offsetHeight);
                        break
                    }
                }
                const h = s - o - (n + l + r)
                  , c = a.querySelectorAll(".js-symbols-wrapper");
                for (let t = 0; t < c.length; t++) {
                    c[t].style.minHeight = `${h}px`
                }
            }
            _createWidgetWatchlistPage(t) {
                return new O(t,{
                    chartColorMap: (0,
                    r.pickFields)(this.settings, H),
                    dateRange: this.settings.dateRange || j.timeFrames["12m"].value.value,
                    dateRangeOptions: this.settings.dateRangeOptions,
                    disableLastFallingFlash: this.settings.disableLastFallingFlash,
                    disableLastGrowingFlash: this.settings.disableLastGrowingFlash,
                    hideAbsoluteChange: this.settings.hideAbsoluteChange,
                    indexNameBold: this.settings.indexNameBold,
                    indexNonClickable: this.settings.indexNonClickable,
                    isEmbedWidget: this.settings.isEmbedWidget,
                    largeChartUrl: this.settings.largeChartUrl,
                    noLinks: this.settings.noLinks,
                    onlyDescription: this.settings.onlyDescription,
                    paintLastWithChangeColors: this.settings.paintLastWithChangeColors,
                    showDataMode: this.settings.showDataMode,
                    showMarketStatus: this.settings.showMarketStatus,
                    showTitles: this.settings.showTitles,
                    tradingviewBaseUrl: this.settings.tradingviewBaseUrl,
                    utmInfo: this.settings.utmInfo,
                    valueBold: this.settings.valueBold,
                    valueTitleMarked: this.settings.valueTitleMarked,
                    widgetColorClassMap: this.widgetColorClassMap,
                    widgetName: this.widgetName,
                    showSymbolLogo: this.settings.showSymbolLogo,
                    locale: this.settings.locale,
                    showFloatingTooltip: this.settings.showFloatingTooltip,
                    colorTheme: this.settings.colorTheme
                })
            }
            _stopPage(t, e) {
                const s = this._getCachedWidgetPage(t);
                s && (e ? this._setStopTimeout(t) : s.stop())
            }
            _onActivePageChanged(t, e) {
                e.forEach(((e,s)=>{
                    if (t === s) {
                        if (this._startPage(W(e)),
                        this.settings.isEmbedWidget) {
                            const t = this._getCachedWidgetPage(W(e));
                            null == t || t.adjustToAvailableSizes()
                        }
                    } else
                        this._stopPage(W(e))
                }
                ))
            }
            _getActivePage(t) {
                for (const e of t)
                    if (!e.classList.contains("i-hidden"))
                        return e;
                return null
            }
            _cacheWidgetPage(t, e) {
                t.data("watchlist-widget-page", e)
            }
            _setStopTimeout(t) {
                this._stopPageTimeouts[t.index()] = setTimeout(this._stopPage.bind(this, t))
            }
            _deleteStopTimeout(t) {
                const e = this._stopPageTimeouts[t.index()];
                e && (clearTimeout(e),
                delete this._stopPageTimeouts[t.index()])
            }
        }
        (X,I);
        if (I.isEmbedWidget && !I.fixedChartHeight && !I.adjust_widget_height) {
            const t = (0,
            i.ensureNotNull)(document.querySelector(".js-embed-widget-body"));
            new ResizeObserver((0,
            o.default)((function(t) {
                const e = t[0].contentRect;
                e.width > 0 && e.height > 0 && J.adjustToAvailableSizes()
            }
            ), 200)).observe(t)
        }
        function Y(t, e, s) {
            return t in e ? "false" !== e[t] : s[t]
        }
    }
    ,
    957879: (t,e,s)=>{
        const i = s(823127);
        t.exports = i,
        i(document).ajaxSend(((t,e,s)=>{
            s.crossDomain && !s.forceLanguageHeader || (window.locale ? e.setRequestHeader("X-Language", window.locale) : console.warn("window.locale is not defined"))
        }
        ))
    }
}, t=>{
    t.O(0, [18562, 37506, 53658, 4015, 76592, 89842, 39855, 92483, 37124, 50293, 67103, 8545, 63391, 92436, 49981, 4173, 63025, 23127, 87061, 43716, 98126, 41611, 30128, 76332, 52589, 74889, 69840, 17048, 82275, 11242, 29569, 51712], (()=>{
        return e = 854734,
        t(t.s = e);
        var e
    }
    ));
    t.O()
}
]);
