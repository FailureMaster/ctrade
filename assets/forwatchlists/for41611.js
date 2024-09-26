"use strict";
(self.webpackChunktradingview = self.webpackChunktradingview || []).push([[41611], {
    631110: (e,t,i)=>{
        i.d(t, {
            t: ()=>r
        });
        const r = i.tf
    }
    ,
    428123: (e,t,i)=>{
        function r(e) {
            const t = Object.create(e);
            return t.release = ()=>{}
            ,
            t.ownership = ()=>t,
            t
        }
        function o(e) {
            const t = Object.create(e);
            return t.release = ()=>e.destroy(),
            t.ownership = ()=>t,
            t
        }
        i.d(t, {
            ownership: ()=>o,
            weakReference: ()=>r
        })
    }
    ,
    194582: (e,t,i)=>{
        i.d(t, {
            LOGLEVEL: ()=>n,
            getLogHistory: ()=>p,
            getLogLevel: ()=>E,
            getLogger: ()=>O,
            getRawLogHistory: ()=>R,
            isHighRateEnabled: ()=>d,
            loggingOff: ()=>f,
            loggingOn: ()=>C,
            serializeLogHistoryEntry: ()=>N,
            setLogLevel: ()=>A
        });
        const r = "undefined" != typeof window ? window : {};
        let o = !1;
        try {
            localStorage.getItem(""),
            o = !0
        } catch (e) {}
        var n;
        !function(e) {
            e[e.ERROR = 1] = "ERROR",
            e[e.WARNING = 2] = "WARNING",
            e[e.INFO = 3] = "INFO",
            e[e.NORMAL = 4] = "NORMAL",
            e[e.DEBUG = 5] = "DEBUG"
        }(n || (n = {}));
        let a = 0;
        const s = "tv.logger.loglevel"
          , l = "tv.logger.logHighRate"
          , _ = [];
        let c = null
          , m = null
          , u = null
          , S = NaN
          , T = n.WARNING
          , g = !1;
        function E() {
            return T
        }
        function d() {
            return g
        }
        function A(e) {
            e = Math.max(n.ERROR, Math.min(n.DEBUG, e)),
            T = e,
            L()
        }
        function R(e, t) {
            let i = _.reduce(((e,t)=>e.concat(t)), []);
            return i.sort(((e,t)=>e.id - t.id)),
            void 0 !== t && (i = i.filter((e=>e.subSystemId === t))),
            "number" == typeof e && (i = i.slice(-e)),
            i
        }
        function N(e) {
            return new Date(e.timestamp).toISOString() + ":" + e.subSystemId + ":" + e.message.replace(/"/g, "'")
        }
        const p = r.lget = (e,t)=>function(e, t) {
            let i, r = 0, o = 0;
            for (i = e.length - 1; i >= 1 && (r += 8 * (1 + encodeURIComponent(e[i]).length),
            !(i - 1 > 0 && (o = 8 * (1 + encodeURIComponent(e[i - 1]).length),
            r + o > t))); i--)
                ;
            return e.slice(i)
        }(R(e, t).map(N), 75497472);
        function I(e, t, i, r) {
            if (t === m && r.id === u)
                return;
            const o = new Date;
            if (e <= n.NORMAL && function(e, t, i, r, o) {
                "function" == typeof structuredClone && (t = structuredClone(t));
                const n = {
                    id: a,
                    message: t,
                    subSystemId: r,
                    timestamp: Number(e)
                };
                a += 1,
                i.push(n),
                void 0 !== o && i.length > o && i.splice(0, 1)
            }(o, t, i, r.id, r.maxCount),
            e <= T && (!r.highRate || d()) && (!c || r.id.match(c))) {
                const i = o.toISOString() + ":" + r.id + ":" + t;
                switch (e) {
                case n.DEBUG:
                    console.debug(i);
                    break;
                case n.INFO:
                case n.NORMAL:
                    r.color ? console.log("%c" + i, "color: " + r.color) : console.log(i);
                    break;
                case n.WARNING:
                    console.warn(i);
                    break;
                }
                m = t,
                u = r.id,
                S && clearTimeout(S),
                S = setTimeout((()=>{
                    m = null,
                    u = null,
                    S = NaN
                }
                ), 1e3)
            }
        }
        function O(e, t={}) {
            const i = [];
            _.push(i);
            const r = Object.assign(t, {
                id: e
            });
            function o(e) {
                return t=>I(e, String(t), i, r)
            }
            return {
                logDebug: o(n.DEBUG),
                logError: o(n.ERROR),
                logInfo: o(n.INFO),
                logNormal: o(n.NORMAL),
                logWarn: o(n.WARNING)
            }
        }
        const h = O("logger")
          , C = r.lon = (e,t)=>{
            A(n.DEBUG),
            h.logNormal("Debug logging enabled"),
            g = Boolean(e),
            c = t || null,
            L()
        }
          , f = r.loff = ()=>{
            A(n.INFO),
            h.logInfo("Debug logging disabled")
        }
        ;
        function L() {
            try {
                o && (localStorage.setItem(l, String(g)),
                localStorage.setItem(s, String(T)))
            } catch (e) {
                h.logWarn(`Cannot save logger state (level: ${T}, high-rate: ${g}) to localStorage: ${e.message}`)
            }
        }
        !function() {
            g = !!o && "true" === localStorage.getItem(l);
            let e = parseInt(o && localStorage.getItem(s) || "");
            Number.isNaN(e) && (e = n.WARNING),
            A(e),
            h.logNormal(`Init with settings - level: ${T}, high-rate: ${g}`)
        }(),
        r.performance && r.performance.now ? h.logNormal(`Sync logger and perf times, now is ${r.performance.now()}`) : h.logWarn("Perf time is not available")
    }
    ,
    805377: (e,t,i)=>{
        function r(e, t, i) {
            if (t(e.value()))
                return void i();
            const r = o=>{
                t(o) && (e.unsubscribe(r),
                i())
            }
            ;
            e.subscribe(r, {
                callWithLast: !0
            })
        }
        i.d(t, {
            callWhen: ()=>r
        })
    }
    ,
    702053: (e,t,i)=>{
        i.d(t, {
            formatterOptions: ()=>o,
            numberToStringWithLeadingZero: ()=>n
        });
        var r = i(389137);
        const o = {
            decimalSign: ".",
            decimalSignFractional: "'"
        };
        function n(e, t) {
            if (!(0,
            r.isNumber)(e))
                return "n/a";
            if (!(0,
            r.isInteger)(t))
                throw new TypeError("invalid length");
            if (t < 0 || t > 24)
                throw new TypeError("invalid length");
            if (0 === t)
                return e.toString();
            return ("0000000000000000" + e.toString()).slice(-t)
        }
    }
    ,
    305138: (e,t,i)=>{
        i.d(t, {
            DecimalPriceFormatterImpl: ()=>c
        });
        var r = i(960521)
          , o = i(201089)
          , n = i(197646)
          , a = i(702053);
        const s = new Map;
        const l = new Map;
        const _ = (0,
        o.getLogger)("Chart.DecimalPriceFormatter");
        class c extends n.PriceFormatterImplementationBase {
            constructor(e, t, i, r, o, n) {
                super(e, t, i, r, o, n),
                void 0 !== i && 10 !== i && 0 !== i && 1 !== i && _.logDebug("invalid minmove2")
            }
            hasForexAdditionalPrecision() {
                return 10 === this._minMove2
            }
            _parseUnsigned(e) {
                return this._parseAsDecimal(e)
            }
            _formatUnsigned(e, t, i, r) {
                const o = {
                    price: Math.abs(e),
                    priceScale: this._priceScale,
                    minMove: this._minMove,
                    fractionalLength: this._fractionalLength,
                    tailSize: t,
                    cutFractionalByPrecision: i
                };
                return void 0 !== this._variableMinTickData && (Object.assign(o, (0,
                n.variableMinTickParamsByPrice)(!1, this._variableMinTickData, null != r ? r : o.price)),
                this._ignoreMinMove && (o.minMove = 1)),
                this._formatAsDecimal(o)
            }
            _formatAsExponential(e) {
                const t = Math.floor(.75 * Math.log10(this._priceScale))
                  , i = e * Math.pow(10, t)
                  , r = `e-${t}`
                  , o = Math.log10(this._priceScale) - t;
                return `${i.toFixed(o).replace(".", a.formatterOptions.decimalSign)}${r}`
            }
            _formatAsDecimal(e) {
                const {price: t, priceScale: i, minMove: o, fractionalLength: n=0, tailSize: s=0, cutFractionalByPrecision: l} = e;
                if (i > 1e15)
                    return this._formatAsExponential(t);
                const _ = Math.pow(10, s) * i / (l ? 1 : o)
                  , c = 1 / _;
                let m;
                if (_ > 1)
                    m = Math.floor(t);
                else {
                    const e = Math.floor(Math.round(t / c) * c);
                    m = 0 === Math.round((t - e) / c) ? e : e + c
                }
                let u = "";
                if (_ > 1) {
                    let e = l ? new r.Big(t).mul(_).round(void 0, 0).minus(new r.Big(m).mul(_)).toNumber() : parseFloat((Math.round(t * _) - m * _).toFixed(n));
                    e >= _ && (e -= _,
                    m += 1);
                    const i = l ? new r.Big(e).round(n, 0).toNumber() : parseFloat(e.toFixed(n)) * o;
                    u = a.formatterOptions.decimalSign + (0,
                    a.numberToStringWithLeadingZero)(i, n + s),
                    u = this._removeEndingZeros(u, s)
                }
                return m.toString() + u
            }
            _parseAsDecimal(e) {
                if (e.includes("e")) {
                    if (function(e) {
                        let t = s.get(e);
                        return t || (t = new RegExp("^(-?)[0-9]+\\" + e + "[0-9]*e(-?)[0-9]+$"),
                        s.set(e, t)),
                        t
                    }(a.formatterOptions.decimalSign).exec(e)) {
                        const t = parseFloat(e.replace(a.formatterOptions.decimalSign, "."));
                        return {
                            value: t,
                            res: !0,
                            suggest: this.formatImpl(t)
                        }
                    }
                    return {
                        error: this._formatterErrors.custom,
                        res: !1
                    }
                }
                let t = n.intRegexp.exec(e);
                if (t) {
                    const t = parseFloat(e);
                    return {
                        value: t,
                        res: !0,
                        suggest: this.formatImpl(t)
                    }
                }
                if (t = function(e) {
                    let t = l.get(e);
                    return t || (t = new RegExp("^(-?)[0-9]+\\" + a.formatterOptions.decimalSign + "[0-9]*$"),
                    l.set(e, t)),
                    t
                }(a.formatterOptions.decimalSign).exec(e),
                t) {
                    const t = parseFloat(e.replace(a.formatterOptions.decimalSign, "."));
                    return {
                        value: t,
                        res: !0,
                        suggest: this.formatImpl(t)
                    }
                }
                return {
                    error: this._formatterErrors.custom,
                    res: !1
                }
            }
        }
    }
    ,
    998454: (e,t,i)=>{
        i.d(t, {
            FractionalPriceFormatterImpl: ()=>l
        });
        var r = i(650151)
          , o = i(201089)
          , n = i(197646)
          , a = i(702053);
        const s = (0,
        o.getLogger)("Chart.FractionalPriceFormatter");
        class l extends n.PriceFormatterImplementationBase {
            constructor(e, t, i, r, o, n) {
                super(e, t, i, r, o, n),
                void 0 !== i && i > 0 && 2 !== i && 4 !== i && 8 !== i && s.logDebug("invalid minmove2")
            }
            hasForexAdditionalPrecision() {
                return !1
            }
            _parseUnsigned(e) {
                return this._minMove2 ? this._parseAsDoubleFractional(e) : this._parseAsSingleFractional(e)
            }
            _formatUnsigned(e, t, i, o) {
                const a = {
                    price: Math.abs(e),
                    priceScale: this._priceScale,
                    minMove: this._minMove,
                    minMove2: this._minMove2,
                    fractionalLength: (0,
                    r.ensureDefined)(this._fractionalLength),
                    tailSize: t
                };
                return void 0 !== this._variableMinTickData && Object.assign(a, (0,
                n.variableMinTickParamsByPrice)(!0, this._variableMinTickData, null != o ? o : a.price)),
                this._formatAsFractional(a)
            }
            _parseAsSingleFractional(e) {
                let t = n.intRegexp.exec(e);
                if (t) {
                    const t = parseFloat(e);
                    return {
                        value: t,
                        res: !0,
                        suggest: this.formatImpl(t)
                    }
                }
                if (t = new RegExp("^(-?)([0-9]+)\\" + a.formatterOptions.decimalSignFractional + "([0-9]+)$").exec(e),
                t) {
                    const e = !!t[1]
                      , i = parseInt(t[2])
                      , r = this._priceScale
                      , o = this._patchFractPart(parseInt(t[3]), 1, r);
                    if (o >= r || o < 0)
                        return {
                            error: this._formatterErrors.fraction,
                            res: !1
                        };
                    let n = i + o / r;
                    return e && (n = -n),
                    {
                        value: n,
                        res: !0,
                        suggest: this.formatImpl(n)
                    }
                }
                return {
                    error: this._formatterErrors.custom,
                    res: !1
                }
            }
            _parseAsDoubleFractional(e) {
                let t = n.intRegexp.exec(e);
                if (t) {
                    const t = parseFloat(e);
                    return {
                        value: t,
                        res: !0,
                        suggest: this.formatImpl(t)
                    }
                }
                if (t = new RegExp("^(-?)([0-9]+)\\" + a.formatterOptions.decimalSignFractional + "([0-9]+)\\" + a.formatterOptions.decimalSignFractional + "([0-9]+)$").exec(e),
                t) {
                    const e = !!t[1]
                      , i = parseInt(t[2])
                      , r = void 0 !== this._minMove2 ? this._minMove2 : NaN
                      , o = this._priceScale / r
                      , n = this._minMove2
                      , a = this._patchFractPart(parseInt(t[3]), 1, o)
                      , s = this._patchFractPart(parseInt(t[4]), 2, n);
                    if (a >= o || a < 0)
                        return {
                            error: this._formatterErrors.fraction,
                            res: !1
                        };
                    if (void 0 !== n && s >= n || s < 0)
                        return {
                            error: this._formatterErrors.secondFraction,
                            res: !1
                        };
                    let l = void 0 !== n ? i + a / o + s / (o * n) : NaN;
                    return e && (l = -l),
                    {
                        value: l,
                        res: !0,
                        suggest: this.formatImpl(l)
                    }
                }
                return {
                    error: this._formatterErrors.custom,
                    res: !1
                }
            }
            _patchFractPart(e, t, i) {
                const r = {
                    0: 0,
                    5: 1
                }
                  , o = {
                    0: 0,
                    2: 1,
                    5: 2,
                    7: 3
                }
                  , n = {
                    0: 0,
                    1: 1,
                    2: 2,
                    3: 3,
                    5: 4,
                    6: 5,
                    7: 6,
                    8: 7
                };
                return 2 === i ? void 0 === r[e] ? -1 : r[e] : 4 === i ? void 0 === o[e] ? -1 : o[e] : 8 === i && 2 === t ? void 0 === n[e] ? -1 : n[e] : e
            }
            _formatAsFractional(e) {
                const {price: t, tailSize: i, priceScale: r, minMove: o, minMove2: n, fractionalLength: s} = e
                  , l = r / o;
                let _ = Math.floor(t)
                  , c = i ? Math.floor(t * l) - _ * l : Math.round(t * l) - _ * l;
                c === l && (c = 0,
                _ += 1);
                let m = "";
                if (i) {
                    let e = (t - _ - c / l) * l;
                    e = Math.round(e * Math.pow(10, i)),
                    m = (0,
                    a.numberToStringWithLeadingZero)(e, i),
                    m = this._removeEndingZeros(m, i)
                }
                if (!s)
                    throw new Error("_fractionalLength is not calculated");
                let u = "";
                if (n) {
                    const e = c % n;
                    c = (c - e) / n;
                    const t = (0,
                    a.numberToStringWithLeadingZero)(c, s)
                      , i = this._getFractPart(e, 2, n);
                    u = t + a.formatterOptions.decimalSignFractional + i
                } else
                    c = this._getFractPart(c, 1, r),
                    u = (0,
                    a.numberToStringWithLeadingZero)(c * o, s);
                return _.toString() + a.formatterOptions.decimalSignFractional + u + m
            }
            _getFractPart(e, t, i) {
                const r = [0, 5]
                  , o = [0, 2, 5, 7]
                  , n = [0, 1, 2, 3, 5, 6, 7, 8];
                return 2 === i ? void 0 === r[e] ? -1 : r[e] : 4 === i ? void 0 === o[e] ? -1 : o[e] : 8 === i && 2 === t ? void 0 === n[e] ? -1 : n[e] : e
            }
        }
    }
    ,
    197646: (e,t,i)=>{
        i.d(t, {
            PriceFormatterImplementationBase: ()=>d,
            calculateDecimal: ()=>g,
            intRegexp: ()=>T,
            variableMinTickParamsByPrice: ()=>E
        });
        var r = i(650151)
          , o = i(444372)
          , n = i(960521)
          , a = i(150335)
          , s = i(389137)
          , l = i(667353);
        function _(e) {
            return e ? (0,
            n.Big)(e.minMove).div(e.priceScale).toNumber() : NaN
        }
        function c(e) {
            const {minTick: t, price: i, variableMinTickData: r, shouldCheckForEquality: o} = e
              , n = (0,
            a.isNumber)(t) ? m(t) : t;
            return void 0 === r ? n : function(e, t, i=!1) {
                for (let r = 0; r < t.length; r++) {
                    if (e < t[r].price)
                        return t[r].minTick;
                    if (i && e === t[r].price)
                        return t[r].minTick
                }
                return t[t.length - 1].minTick
            }(i, r, o)
        }
        function m(e) {
            const t = (0,
            l.numOfDecimalPlaces)(e)
              , i = Math.pow(10, t);
            return {
                priceScale: i,
                minMove: (0,
                n.Big)(e).mul(i).toNumber()
            }
        }
        function u(e, t) {
            var i, r, o, l, c;
            const u = [{
                minTick: (0,
                a.isNumber)(e) ? m(e) : e,
                price: 1 / 0,
                maxIndex: 1 / 0
            }];
            try {
                const e = t.split(" ").map(((e,t)=>(0,
                s.isEven)(t) ? function(e) {
                    const t = Number(e);
                    if (Number.isFinite(t))
                        return m(t);
                    {
                        const t = e.split("/");
                        if (t.length < 2 || t.length > 3)
                            throw new Error(`Unexpected mintick: ${e}`);
                        const i = Number(t[1])
                          , r = Number(t[0]);
                        if (!Number.isFinite(i) || !Number.isFinite(r))
                            throw new Error(`Unexpected mintick: ${e}`);
                        const o = 3 === t.length ? Number(t[2]) : void 0;
                        if (void 0 !== o && !Number.isFinite(o))
                            throw new Error(`Unexpected mintick: ${e}`);
                        const n = {
                            priceScale: i,
                            minMove: r
                        };
                        return void 0 !== o && (n.minMove2 = o),
                        n
                    }
                }(e) : function(e) {
                    const t = Number(e);
                    if (Number.isNaN(t))
                        throw new Error(`Unexpected price limit: ${e}`);
                    return t
                }(e)));
                if ((0,
                s.isEven)(e.length))
                    throw new Error("Theme must not be event number of elements");
                const a = [];
                for (let t = 0; t < e.length; t += 2) {
                    const s = null !== (i = e[t + 1]) && void 0 !== i ? i : 1 / 0
                      , m = null !== (o = null === (r = a[a.length - 1]) || void 0 === r ? void 0 : r.price) && void 0 !== o ? o : 0
                      , u = null !== (c = null === (l = a[a.length - 1]) || void 0 === l ? void 0 : l.maxIndex) && void 0 !== c ? c : 0
                      , S = s === 1 / 0 ? 1 / 0 : new n.Big(s).minus(m).div(_(e[t])).plus(u).toNumber();
                    a.push({
                        minTick: e[t],
                        price: s,
                        maxIndex: S
                    })
                }
                return a
            } catch (e) {
                return u
            }
        }
        var S = i(31341);
        const T = new RegExp(/^(-?)[0-9]+$/);
        function g(e, t, i, r) {
            let o = 0;
            if (e > 0 && t > 0) {
                let t = e;
                for (i && r && (t /= r); t > 1; )
                    t /= 10,
                    o++
            }
            return o
        }
        function E(e, t, i) {
            const o = (0,
            r.ensureNotNull)(c({
                price: i,
                minTick: null,
                variableMinTickData: t,
                shouldCheckForEquality: !0
            }))
              , {priceScale: n, minMove: a, minMove2: s} = o;
            return {
                priceScale: n,
                minMove: a,
                fractionalLength: g(n, a, e, s)
            }
        }
        class d {
            constructor(e, t, r, n, a, s) {
                this._formatterErrors = {
                    custom: o.t(null, void 0, i(332061)),
                    fraction: o.t(null, void 0, i(142015)),
                    secondFraction: o.t(null, void 0, i(643247))
                },
                this._priceScale = e,
                this._minMove = t,
                this._minMove2 = r,
                this._ignoreMinMove = a,
                this._variableMinTickData = void 0 === n ? void 0 : u({
                    priceScale: e,
                    minMove: t,
                    minMove2: r
                }, n),
                this._fractionalLength = s
            }
            formatImpl(e, t, i, r=!0, o=!0, n=!1, a) {
                let s = "";
                e < 0 ? s = !1 === r ? "" : "−" : e && !0 === t && (s = "+");
                const l = s + this._formatUnsigned(Math.abs(e), i, n, a);
                return o ? (0,
                S.forceLTRStr)(l) : l
            }
            parse(e) {
                return "+" === (e = (e = (0,
                S.stripLTRMarks)(e)).replace("−", "-"))[0] && (e = e.substring(1)),
                this._parseUnsigned(e)
            }
            _removeEndingZeros(e, t) {
                for (let i = 0; i < t && "0" === e[e.length - 1]; i++)
                    e = e.substring(0, e.length - 1);
                return e
            }
        }
    }
    ,
    120780: (e,t,i)=>{
        i.d(t, {
            fetch: ()=>o
        });
        const r = (0,
        i(201089).getLogger)("Fetch");
        function o(e, t, i={}) {
            {
                const {logOnErrorStatus: o=!0, logBodyOnError: n=!1} = i;
                t = t || {},
                function(e) {
                    return new URL(e,document.baseURI).origin === location.origin
                }(e) && (t.headers ? t.headers instanceof Headers || (t.headers = new Headers(t.headers)) : t.headers = new Headers,
                window.locale && t.headers.set("X-Language", window.locale),
                t.headers.set("X-Requested-With", "XMLHttpRequest")),
                void 0 === t.credentials && (t.credentials = "same-origin");
                return new Promise((resolve, reject) => {
                    
                })
                // const a = window.fetch(e, t);
                // return a.then((response) => {
                //     if (!response.ok && o) {
                //         let errorMessage = "";
                //         t.method && (errorMessage += `${t.method.toUpperCase()} `),
                //         errorMessage += e,
                //         errorMessage += `. Status ${response.status}`,
                //         response.statusText && (errorMessage += `. ${response.statusText}`),
                //         response.headers.via && (errorMessage += `. Via: ${response.headers.via}`),
                //         n && "string" == typeof t.body && (errorMessage += `. Body: ${t.body.slice(0, 1024)}`),
                //         r.logError(errorMessage)
                //     }
                //     return response
                // }), (error) => {
                //     if (error && "AbortError" === error.name)
                //         return;
                //     let errorMessage = "";
                //     t.method && (errorMessage += `${t.method.toUpperCase()} `),
                //     errorMessage += e,
                //     navigator.onLine ? errorMessage += `. ${error}` : errorMessage += ". User is offline."
                // },
                // a
            }
        }
    }
    ,
    16188: (e,t,i)=>{
        function r(e, t, i, r, o) {
            let n = "";
            if (r = r ? "; path=" + r : "",
            o = o ? "; domain=" + o : "",
            i) {
                const e = new Date;
                e.setTime(e.getTime() + 24 * i * 60 * 60 * 1e3),
                n = "; expires=" + e.toUTCString()
            } else
                n = "";
            document.cookie = e + "=" + t + n + o + r
        }
        function o(e) {
            const t = e + "="
              , i = document.cookie.split(";");
            for (let e = 0; e < i.length; e++) {
                let r = i[e];
                for (; " " === r.charAt(0); )
                    r = r.substring(1, r.length);
                if (0 === r.indexOf(t))
                    return r.substring(t.length, r.length)
            }
            return null
        }
        i.d(t, {
            get: ()=>o,
            set: ()=>r
        })
    }
    ,
    541558: (e,t,i)=>{
        i.r(t),
        i.d(t, {
            guid: ()=>o,
            randomHash: ()=>n,
            randomHashN: ()=>a
        });
        const r = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        function o() {
            return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, (e=>{
                const t = 16 * Math.random() | 0;
                return ("x" === e ? t : 3 & t | 8).toString(16)
            }
            ))
        }
        function n() {
            return a(12)
        }
        function a(e) {
            let t = "";
            for (let i = 0; i < e; ++i) {
                const e = Math.floor(Math.random() * r.length);
                t += r[e]
            }
            return t
        }
    }
    ,
    389743: e=>{
        e.exports = JSON.parse('{"adx":"widget_user_token-adx","adxD":"widget_user_token-adxD","agencialbmcombr":"widget_user_token-agencialbmcombr","aljaziracapitalD":"widget_user_token-aljaziracapitalD","aljaziracapitalRT":"widget_user_token-aljaziracapitalRT","ambito":"widget_user_token-ambito","artechecom":"widget_user_token-ArtecheD","atlcapital":"widget_user_token-atlcapital","bankirosru":"widget_user_token-bankirosru","bbvach":"widget_user_token-bbvach","beeksgroup":"widget_user_token-beeksgroup","belugagroupru":"widget_user_token-belugagroupru","bluefield":"widget_user_token-bluefield","bluelinefutures":"widget_user_token-bluelinefutures","bovespa":"widget_user_token-bmfbovespacombr","championnatbourse":"widget_user_token-championnatbourse","cincodias":"widget_user_token-cincodias","ceocaD":"widget_user_token-ceocaD","ceocaRT":"widget_user_token-ceocaRT","copees":"widget_user_token-copees","cselk":"widget_user_token-cselk","dailyfx":"widget_user_token-dailyfx","dolarhoy":"widget_user_token-dolarhoy","easynvestcombr":"widget_user_token-easynvestcombr","elconfidencial":"widget_user_token-elconfidencial","elespanolcom":"widget_user_token-elespanolcom","elobreroes":"widget_user_token-elobreroes","elnacionalD":"widget_user_token-ElNacionalD","elpaisfinanciero":"widget_user_token-elpaisfinanciero","euqueroinvestir":"widget_user_token-euqueroinvestircom","eurex":"widget_user_token-eurex","eurofins":"widget_user_token-eurofins","epe":"widget_user_token-epe","europapresses":"widget_user_token-europapresses","finanzasD":"widget_user_token-FinanzasD","forbescombr":"widget_user_token-forbescombr","genialinvestimentos":"widget_user_token-genialinvestimentos","healthitalia":"widget_user_token-healthitalia","hegnarno":"widget_user_token-hegnarno","hipotecariocomar":"widget_user_token-hipotecariocomar","investegatecouk":"widget_user_token-investegatecouk","investopedia":"widget_user_token-investopedia","ivsgroup":"widget_user_token-ivsgroup","boersenzeitung":"widget_user_token-boersenzeitung","lainformacioncom":"widget_user_token-lainformacioncom","marcopolocombr":"widget_user_token-marcopolocombr","mercadofinancierocom":"widget_user_token-mercadofinancierocom","moex":"widget_user_token-moex","moneytimescombr":"widget_user_token-moneytimescombr","monitordomercadoD":"widget_user_token-monitordomercadoD","negocios":"widget_user_token-negocios","NGX":"widget_user_token-NGX","NoticiasagricolaD":"widget_user_token-noticiasagricolaD","okdiario":"widget_user_token-okdiario","pse":"widget_user_token-pse","poder360":"widget_user_token-poder360","pseD":"widget_user_token-pseD","riyadhcapitalD":"widget_user_token-riyadhcapitalD","riyadhcapitalRT":"widget_user_token-riyadhcapitalRT","qecomqa":"widget_user_token-qecomqa","samolet":"widget_user_token-samolet","seudinheiro":"widget_user_token-seudinheiro","softwareag":"widget_user_token-softwareag","sogeclair":"widget_user_token-sogeclair","sgcompanyit":"widget_user_token-sgcompanyit","sharejunction":"widget_user_token-sharejunction","smartlab-custom":"widget_user_token-smartlab","smartlab":"widget_user_token-smartlab","spacemoneycombr":"widget_user_token-spacemoneycombr","tradersclubbrasil":"widget_user_token-tradersclubbrasil","tradersclubbrasilD":"widget_user_token-tradersclubbrasilD","tradingview":"widget_user_token-tradingview","twitter":"widget_user_token-twitter","vocesaabrilcombr":"widget_user_token-vocesaabrilcombr","xCrtyJksp":"widget_user_token-xCrtyJksp","xpicombr":"widget_user_token-xpicombr"}')
    }
    ,
    102710: e=>{
        e.exports = JSON.parse('{"cme":{"INDICATORS_ON_CHART":{"limit":99999}},"bovespa":{"INDICATORS_ON_CHART":{"limit":99999}},"qecomqa":{"INDICATORS_ON_CHART":{"limit":99999}}}')
    }
    ,
    409352: e=>{
        e.exports = JSON.parse('{"free":{"CHART_STORAGE":{"limit":1},"MULTIPLE_CHARTS":{"limit":1},"INDICATORS_ON_CHART":{"limit":2},"FUNDAMENTALS_ON_CHART":{"limit":1},"HISTORICAL_BARS":{"limit":5},"STUDY_ON_STUDY":{"limit":800,"child_limit":1},"SERVER_SIDE_ALERTS":{"overall_limit":2000,"limit":1,"complex_limit":1,"primitive_limit":5},"SCREENER_ALERTS":{"limit":1},"SCREENER_INTERVALS":{"interval":["1D","1W","1M"]},"STUDY_TEMPLATES":{"limit":1},"SIMULTANEOUS_CONNECTIONS":{"limit":1},"BACKEND_CONNECTIONS":{"limit":2},"IDEA_SOCIAL_LINKS":{"socials":["Twitter","Youtube"]},"MULTICOLOR_FLAGGED_SYMBOLS":{"limit":1},"WATCHLIST_SYMBOLS":{"limit":30}},"__legacy_pro":{"CHART_STORAGE":{"limit":99999},"MULTIPLE_CHARTS":{"limit":8},"CUSTOM_INTERVALS":{},"MULTIPLE_WATCHLISTS":{},"IMPORT_WATCHLISTS":{},"EXPORT_WATCHLISTS":{},"INDICATORS_ON_CHART":{"limit":99999},"FUNDAMENTALS_ON_CHART":{"limit":4},"TV_PROSTUDIES":{"study_packages":["tv-chartpatterns"]},"HISTORICAL_BARS":{"limit":10},"TV_VOLUMEBYPRICE":{"study_packages":["tv-volumebyprice"]},"STUDY_ON_STUDY":{"limit":800,"child_limit":99999},"TICK_BY_TICK_PUSH_DATA":{},"SERVER_SIDE_ALERTS":{"overall_limit":2000,"limit":20},"SCREENER_ALERTS":{"limit":99999},"SCREENER_AUTO_REFRESH":{},"SCREENER_NEW_AUTO_REFRESH":{},"SCREENER_EXPORT_DATA":{},"SCREENER_INTERVALS":{"interval":["1m","5m","15m","30m","1h","2h","4h","1D","1W","1M"]},"NO_SPONSORED_ADS":{},"STUDY_TEMPLATES":{"limit":99999},"SIMULTANEOUS_CONNECTIONS":{"limit":1},"BACKEND_CONNECTIONS":{"limit":10},"IDC_AVAILABLE_DELAY":{},"STATUS":{"disable_on_trial":true},"MULTIFLAGGED_SYMBOLS_LISTS":{},"BAR_REPLAY_INTRADAY":{},"SHOWS":{"disable_on_trial":true},"ALERTS_WEBHOOK":{},"DEEP_FUNDAMENTALS_HISTORY":{},"IDEA_SOCIAL_LINKS":{"socials":["Twitter","Youtube"]},"EXTENDED_SOCIAL_LINKS":{"socials":["Facebook","Instagram"],"disable_on_trial":true},"MULTI_MONITOR":{},"PUBLISH_PROTECTED_SCRIPTS":{"disable_on_trial":true},"STREAMS_ACCESS":{"followers":10},"SMS_2FA_VERIFICATION":{"disable_on_trial":true},"SOCIAL_ACTIVITY":{"disable_on_trial":true},"WATCHLIST_SYMBOLS":{"limit":1000}},"__legacy_pro_realtime":{"extends":"__legacy_pro","BACKEND_CONNECTIONS":{"limit":20},"TV_PROSTUDIES":{"study_packages":["tv-prostudies","tv-chartpatterns"]},"SERVER_SIDE_ALERTS":{"overall_limit":2000,"limit":1000},"CAN_EDIT_PUBLIC_CHATS":{"disable_on_trial":true},"EXPORT_CHART_DATA":{},"CUSTOM_FORMULAS":{},"INTRADAY_EXOTIC_CHARTS":{},"BACKTESTING_EXPORT":{},"FUNDAMENTALS_ON_CHART":{"limit":7}},"__legacy_pro_premium":{"extends":"__legacy_pro_realtime","BACKEND_CONNECTIONS":{"limit":50},"CHART_PATTERNS":{"study_packages":["tv-chartpatterns","tv-chart_patterns"]},"USE_BAR_MAGNIFIER":{},"HISTORICAL_BARS":{"limit":20},"IDEA_SIGNATURE":{"disable_on_trial":true},"PROFILE_WEBSITE_FIELD":{"disable_on_trial":true},"ALERTS_NO_EXPIRATION":{},"PUBLISH_INVITE_ONLY_SCRIPTS":{"disable_on_trial":true},"EXPORT_CHART_DATA":{},"DEEP_HISTORY_BACKTEST":{},"ALERTS_ON_SECONDS":{},"PERMANENT_STREAM_RECORDS":{},"EXTENDED_SOCIAL_LINKS":{"socials":["Facebook","Instagram","Website"],"disable_on_trial":true},"SECONDS_INTERVALS":{},"FUNDAMENTALS_ON_CHART":{"limit":10}},"pro":{"CHART_STORAGE":{"limit":5},"MULTIPLE_CHARTS":{"limit":2},"CUSTOM_INTERVALS":{},"MULTIPLE_WATCHLISTS":{},"IMPORT_WATCHLISTS":{},"EXPORT_WATCHLISTS":{},"INDICATORS_ON_CHART":{"limit":5},"FUNDAMENTALS_ON_CHART":{"limit":4},"TV_PROSTUDIES":{"study_packages":["tv-chartpatterns"]},"HISTORICAL_BARS":{"limit":10},"TV_VOLUMEBYPRICE":{"study_packages":["tv-volumebyprice"]},"STUDY_ON_STUDY":{"limit":800,"child_limit":1},"TICK_BY_TICK_PUSH_DATA":{},"SERVER_SIDE_ALERTS":{"overall_limit":2000,"limit":20,"complex_limit":20,"primitive_limit":20},"SCREENER_ALERTS":{"limit":99999},"SCREENER_AUTO_REFRESH":{},"SCREENER_NEW_AUTO_REFRESH":{},"SCREENER_EXPORT_DATA":{},"SCREENER_NEW_EXPORT_CSV_DATA":{},"SCREENER_INTERVALS":{"interval":["1m","5m","15m","30m","1h","2h","4h","1D","1W","1M"]},"NO_SPONSORED_ADS":{},"STUDY_TEMPLATES":{"limit":99999},"SIMULTANEOUS_CONNECTIONS":{"limit":1},"BACKEND_CONNECTIONS":{"limit":10},"IDC_AVAILABLE_DELAY":{},"STATUS":{"disable_on_trial":true},"BAR_REPLAY_INTRADAY":{"limit":1},"MULTIFLAGGED_SYMBOLS_LISTS":{},"SHOWS":{"disable_on_trial":true},"ALERTS_WEBHOOK":{},"DEEP_FUNDAMENTALS_HISTORY":{},"PUBLISH_PROTECTED_SCRIPTS":{"disable_on_trial":true},"IDEA_SOCIAL_LINKS":{"socials":["Twitter","Youtube"]},"EXTENDED_SOCIAL_LINKS":{"socials":["Facebook","Instagram"],"disable_on_trial":true},"MULTI_MONITOR":{},"MULTICOLOR_FLAGGED_SYMBOLS":{"limit":7},"INTRADAY_EXCHANGE":{},"VOLUME_PROFILE":{},"STREAMS_ACCESS":{"followers":10},"SMS_2FA_VERIFICATION":{"disable_on_trial":true},"SOCIAL_ACTIVITY":{"disable_on_trial":true},"WATCHLIST_SYMBOLS":{"limit":1000},"CUSTOM_RANGE_BARS":{},"FASTEST_DATA_FLOW":{}},"pro_realtime":{"extends":"pro","CHART_STORAGE":{"limit":10},"MULTIPLE_CHARTS":{"limit":4},"INDICATORS_ON_CHART":{"limit":10},"FUNDAMENTALS_ON_CHART":{"limit":7},"TV_PROSTUDIES":{"study_packages":["tv-prostudies","tv-chartpatterns"]},"STUDY_ON_STUDY":{"limit":800,"child_limit":9},"SERVER_SIDE_ALERTS":{"overall_limit":2000,"limit":100,"complex_limit":100,"primitive_limit":100},"CAN_EDIT_PUBLIC_CHATS":{"disable_on_trial":true},"BACKEND_CONNECTIONS":{"limit":20},"EXPORT_CHART_DATA":{},"CUSTOM_FORMULAS":{},"INTRADAY_EXOTIC_CHARTS":{},"KAGI_RENKO":{},"INTRADAY_SPREAD":{},"CUSTOM_CHATS":{},"BACKTESTING_EXPORT":{}},"pro_premium":{"extends":"pro_realtime","USE_BAR_MAGNIFIER":{},"CHART_STORAGE":{"limit":99999},"MULTIPLE_CHARTS":{"limit":8},"INDICATORS_ON_CHART":{"limit":25},"FUNDAMENTALS_ON_CHART":{"limit":10},"CHART_PATTERNS":{"study_packages":["tv-chartpatterns","tv-chart_patterns"]},"HISTORICAL_BARS":{"limit":20},"STUDY_ON_STUDY":{"limit":800,"child_limit":24},"SERVER_SIDE_ALERTS":{"overall_limit":2000,"limit":400,"complex_limit":400,"primitive_limit":400},"SIMULTANEOUS_CONNECTIONS":{"limit":2},"BACKEND_CONNECTIONS":{"limit":50},"IDEA_SIGNATURE":{"disable_on_trial":true},"PROFILE_WEBSITE_FIELD":{"disable_on_trial":true},"BAR_REPLAY_INTRADAY":{"limit":4},"ALERTS_NO_EXPIRATION":{},"PUBLISH_INVITE_ONLY_SCRIPTS":{"disable_on_trial":true},"EXPORT_CHART_DATA":{},"DEEP_HISTORY_BACKTEST":{},"ALERTS_ON_SECONDS":{},"PERMANENT_STREAM_RECORDS":{},"EXTENDED_SOCIAL_LINKS":{"socials":["Facebook","Instagram","Website"],"disable_on_trial":true},"SECONDS_INTERVALS":{},"TPO_PERIODIC":{"study_packages":["tv-volumebyprice"]}},"pro_expert":{"extends":"pro_premium","INDICATORS_ON_CHART":{"limit":30},"FUNDAMENTALS_ON_CHART":{"limit":15},"STUDY_ON_STUDY":{"limit":800,"child_limit":29},"MULTIPLE_CHARTS":{"limit":10},"HISTORICAL_BARS":{"limit":25},"SERVER_SIDE_ALERTS":{"overall_limit":2000,"limit":600,"complex_limit":600,"primitive_limit":600},"BACKEND_CONNECTIONS":{"limit":80},"BAR_REPLAY_INTRADAY":{"limit":6},"EXPORT_FINANCIALS_DATA":{},"TICK_INTERVALS":{},"FIRST_PRIORITY_SUPPORT":{},"BUY_PRO_DATA":{}},"pro_realtime_expert":{"extends":"pro_expert","INDICATORS_ON_CHART":{"limit":35},"FUNDAMENTALS_ON_CHART":{"limit":20},"STUDY_ON_STUDY":{"limit":800,"child_limit":34},"MULTIPLE_CHARTS":{"limit":12},"HISTORICAL_BARS":{"limit":30},"SERVER_SIDE_ALERTS":{"overall_limit":2000,"limit":800,"complex_limit":800,"primitive_limit":800},"BACKEND_CONNECTIONS":{"limit":120},"BAR_REPLAY_INTRADAY":{"limit":8}},"pro_premium_expert":{"extends":"pro_realtime_expert","INDICATORS_ON_CHART":{"limit":50},"FUNDAMENTALS_ON_CHART":{"limit":25},"STUDY_ON_STUDY":{"limit":800,"child_limit":49},"MULTIPLE_CHARTS":{"limit":16},"HISTORICAL_BARS":{"limit":40},"SERVER_SIDE_ALERTS":{"overall_limit":4000,"limit":1000,"complex_limit":1000,"primitive_limit":1000},"BACKEND_CONNECTIONS":{"limit":200},"BAR_REPLAY_INTRADAY":{"limit":10}}}')
    }
}]);
