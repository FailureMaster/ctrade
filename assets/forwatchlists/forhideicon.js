"use strict";
(self.webpackChunktradingview = self.webpackChunktradingview || []).push([[8107, 61865], {
    229534: (e,t,n)=>{
        async function i(e) {
            return (await Promise.all([n.e(76592), n.e(63987), n.e(1888), n.e(35213), n.e(63830), n.e(33371), n.e(54712), n.e(96114), n.e(25977), n.e(5091), n.e(88913), n.e(37757)]).then(n.bind(n, 173403))).createDialog(e)
        }
        function r(e) {
            i(e).then((e=>e.open()))
        }
        n.d(t, {
            createErrorDialog: ()=>i,
            showErrorDialog: ()=>r
        })
    }
    ,
    125226: (e,t,n)=>{
        var i = n(49437).TVLocalStorage
          , r = n(707957).Delegate
          , o = n(855385);
        n(638456);
        var s = new r;
        TradingView.FeatureToggle = {
            force_prefix: "forcefeaturetoggle.",
            onChanged: new r,
            enableFeature: function(e) {
                i.setItem(this.force_prefix + e, "true"),
                s.fire(e)
            },
            disableFeature: function(e) {
                i.setItem(this.force_prefix + e, "false"),
                s.fire(e)
            },
            resetFeature: function(e) {
                i.removeItem(this.force_prefix + e),
                s.fire(e)
            },
            onFeaturesStateChanged: function() {
                return s
            }
        },
        TradingView.isFeatureEnabled = function(e) {
            var t = "featuretoggle_seed";
            function r(e) {
                try {
                    var n = o(e + function() {
                        if (window.user && window.user.id)
                            return window.user.id;
                        var e = i.getItem(t);
                        return null !== e || (e = Math.floor(1e6 * Math.random()),
                        i.setItem(t, e)),
                        e
                    }());
                    return new DataView(n).getUint32(0, !0) / 4294967296
                } catch (e) {
                    return .5
                }
            }
            function a(t) {
                return !("local" !== window.environment || !function(e) {
                    var t = ["skip_navigation_on_chart", "tick_intervals", "broker_TRADESTATION", "broker_TRADOVATE_dev", "black_friday_mainpage", "black_friday_popup", "datawindow", "trading-fast-renew-oauth-token", "switching_year_to_month_disabled", "default_year_billing_cycle_switcher", "marketing-analytics", "visible_address_fields_by_default", "slow-support-warning", "hide-trading-floating-toolbar", "save-short-streams", "details_disable_bid_ask", "vat_disabled", "disable_recaptcha_on_signup", "braintree-gopro-in-order-dialog", "braintree-apple-pay", "braintree-google-pay-uk", "braintree-apple-pay-trial", "braintree-google-pay-trial-uk", "braintree-3ds-enabled", "remove_order_ticket_cancel_button", "trial_increased_monthly_discounts", "razorpay-card-tvcoins", "razorpay-card-subscriptions", "razorpay-upi-tvcoins", "razorpay-upi-subscriptions", "razorpay-use-recurring-billing-scheduler", "dlocal-payments", "hide_gopro_popup_upgrade_button", "tradestation_use_sync_mapper", "broker_id_session", "disable_retry_load_linetools_from_storage", "modular_broker_use_sync_mapper", "do_not_save_shared_line_tools_to_charts", "save_shared_line_tools", "multichart_replay", "oanda-european-accounts-warning", "mobile_show_bottom_panel", "disable_save_settings", "ignore_mobile_apps_distinguish_pro_full_name", "desktop_version_notification_enabled", "favorites-in-broker-dropdown", "enable_toggle_streams_rtmp_url", "hide_ecomonic_events", "mobile_trading_web", "mobile_trading_ios", "mobile_trading_android", "hide_real_brokers_on_mobile", "disable_tradestation_country_block", "enable_trading_server_logger", "hide_ranges_label_colors", "disable_user_specific_encryption", "minds_widget_enabled", "self-replacing-advanced-chart-widget", "disable-calendar-advanced-chart-widget", "disable-lse-data-screener-heatmap-widgets", "paper_competition_banner", "paper_competition_started_dialog", "disable_pushstream_connections_for_anonymous_users", "use_staging_verifier", "account_verifier_maintenance", "ally_use_new_sso_url", "ibkr_use_new_init_session_api", "tradestation_account_data_streaming", "enable_eventsource_pushstream_transport", "enable_eventsource_pushstream_mobile", "performance_test_mode", "ftx_request_server_logger", "ibkr_request_server_logger", "disallow_concurrent_sessions", "check_ibkr_side_maintenance", "tradestation_request_server_logger", "trading_request_server_logger", "hide_tweet_drawingtool", "RU_SF_disable", "RU_VOR_disable", "enable_diff_decorations", "disable_pine_v4", "enable_profiler", "add_to_chart_from_detach", "enable_new_custom_public_chats", "bottom_panel_track_events", "ibkr_ws_account_summary", "continuous_front_contract_trading", "vertex-tax-included", "enable_traded_context_linking", "order_context_validation_in_instant_mode", "show_data_problems_in_help_center", "chart_storage_hibernation_delay_60min", "chart_storage_hibernation_delay_10min", "chart_storage_hibernation_delay_5min", "force_disable_jsx_menu_items_rendering", "enable_sign_in_popup_with_evercookie", "start_replay_right_after_point_selection", "switching_raf_toast", "order_size_calculator", "order_type_specific_settings_saving", "hide_position_trade_value", "paper_force_connect_pushstream", "use_broker_logos_from_single_source", "alerts-editor-use-facade", "alerts-crosshair-plus-use-facade", "alerts-chart-use-facade", "alerts-facade-use-permission-proxy", "alerts-controller-use-permission-proxy", "alerts-use-pricealerts-pushstream-for-notifications", "alerts-start-christmas", "forexcom_session_v2", "fxcm_server_logger", "minds_comments_enable_for_free_users", "fxcm_trailing_stop_bracket", "mock_tweet_data_for_tests", "replay_result_sharing", "ibkr_ws_server_logger", "options_strategy_analyzer_tab", "options_details_widget", "options_overlay", "options_product_page", "ibkr_subscribe_to_order_updates_first", "rest_logout_on_429", "amp_oauth_authorization", "blueline_oauth_authorization", "dorman_oauth_authorization", "cqg_oauth_authorization", "ironbeam_oauth_authorization", "optimus_oauth_authorization", "stonex_oauth_authorization", "tickmill_oauth_authorization", "ibkr_ws_account_ledger", "force_max_allowed_pulling_intervals", "fxcm_password_authorization_type", "change_password_suggestion_popup", "ibkr_disable_ws_connect_timeout", "oanda_rest_api", "launch-oanda-country-group-1", "launch-oanda-country-group-2", "launch-oanda-country-group-3", "news_enable_streaming", "news_enable_streaming_hibernation", "news_streaming_hibernation_delay_60min", "news_streaming_hibernation_delay_10min", "news_streaming_hibernation_delay_5min", "replay_trading_brackets", "cqg-realtime-bandwidth-limit", "cityindex_spreadbetting", "do_not_wait_meta_info", "paper_use_new_auth", "stack_trace_clickable", "oauth2_code_flow_provider_server_logger", "turn_off_ai", "enable_binanceapis_base_url"]
                      , n = "[A-Z]+[a-zA-Z0-9_]+"
                      , i = new RegExp(`broker_${n}_dev`,"g")
                      , r = new RegExp(`hide_${n}_on_ios`,"g")
                      , o = new RegExp(`hide_${n}_on_android`,"g")
                      , s = new RegExp(`hide_${n}_on_mobile_web`,"g");
                    return -1 === t.indexOf(e) && -1 === e.indexOf("-maintenance") && !1 === i.test(e) && !1 === r.test(e) && !1 === o.test(e) && !1 === s.test(e)
                }(t)) || (!e[t] || -1 !== e[t]) && (!!("true" === i.getItem(TradingView.FeatureToggle.force_prefix + t) || window.is_authenticated && "undefined" != typeof user && user.settings && "true" === user.settings[TradingView.FeatureToggle.force_prefix + t]) || !("false" === i.getItem(TradingView.FeatureToggle.force_prefix + t) || window.is_authenticated && "undefined" != typeof user && user.settings && "false" === user.settings[TradingView.FeatureToggle.force_prefix + t]) && (!!e[t] && (1 === e[t] || r(t) <= e[t])))
            }
            return TradingView.onWidget() || Promise.all([n.e(5069), n.e(34604)]).then(n.bind(n, 405069)).then((t=>{
                t.pushStreamMultiplexer.on("featuretoggle", (function(t) {
                    var n = a(t.name);
                    e[t.name] = t.state,
                    n !== a(t.name) && s.fire(t.name)
                }
                ))
            }
            )),
            a
        }(window.featureToggleState || {}),
        t.FeatureToggle = TradingView.FeatureToggle,
        t.isFeatureEnabled = TradingView.isFeatureEnabled,
        t.onFeaturesStateChanged = TradingView.FeatureToggle.onFeaturesStateChanged.bind(TradingView.FeatureToggle)
    }
    ,
    251954: (e,t,n)=>{
        n.r(t),
        n.d(t, {
            emit: ()=>c,
            emitOnce: ()=>h,
            on: ()=>l,
            subscribe: ()=>u,
            subscribeToAll: ()=>d,
            unsubscribe: ()=>a
        });
        var i = n(707957);
        const r = {}
          , o = []
          , s = {};
        function a(e, t, n) {
            r[e].unsubscribe(n, t)
        }
        function l(e, t, n) {
            u(e, t, n)
        }
        function u(e, t, n, o) {
            r.hasOwnProperty(e) || (r[e] = new i.Delegate),
            s[e] ? t.call(n) : r[e].subscribe(n, t, o)
        }
        function d(e) {
            o.push(e)
        }
        function c(e, ...t) {
            const n = [e].concat(t);
            o.forEach((e=>{
                e.apply(null, n)
            }
            )),
            r.hasOwnProperty(e) && r[e].fire.apply(r[e], t)
        }
        function h(e) {
            s[e] && console.warn(`Something went wrong: emitOnce called multiple times with same event (${e})`),
            s[e] = !0,
            c.apply(null, arguments)
        }
    }
    ,
    588948: (e,t,n)=>{
        n.d(t, {
            deleteField: ()=>u,
            getFreshInitData: ()=>l,
            getInitData: ()=>a,
            updateInitData: ()=>s
        });
        var i = n(650151);
        const r = (0,
        n(201089).getLogger)("Common.InitData")
          , o = window.initData || {};
        function s() {
            window.initData && window.initData !== o && (Object.assign(o, window.initData),
            window.initData = o);
            const e = document.querySelectorAll('script[type="application/prs.init-data+json"]');
            for (let t = 0; t < e.length; t++) {
                const n = e[t];
                try {
                    const e = JSON.parse((0,
                    i.ensureNotNull)(n.textContent));
                    Object.assign(o, e)
                } catch (e) {
                    r.logWarn(`Failed to parse initData element. ${e}`)
                } finally {
                    (0,
                    i.ensureNotNull)(n.parentNode).removeChild(n)
                }
            }
        }
        function a() {
            return o
        }
        function l() {
            return s(),
            o
        }
        function u(e) {
            delete o[e]
        }
    }
    ,
    971417: (e,t,n)=>{
        function i(e) {
            return e === r(e)
        }
        function r(e) {
            const t = e.indexOf("$")
              , n = e.indexOf("@");
            return t < 0 && n >= 0 ? null : e.substring(Math.max(t + 1, 0), n >= 0 ? n : e.length)
        }
        function o(e) {
            return e.startsWith("PUB;")
        }
        function s(e) {
            return e.startsWith("USER;")
        }
        function a(e) {
            return e.startsWith("STD;")
        }
        function l(e) {
            return e.includes("Candlestick%1Pattern%1")
        }
        function u(e) {
            return e.startsWith("EDGR_")
        }
        n.d(t, {
            extractPineId: ()=>r,
            isCandleStickId: ()=>l,
            isCustomPineId: ()=>s,
            isEdgrPineId: ()=>u,
            isPineIdString: ()=>i,
            isPublishedPineId: ()=>o,
            isStandardPineId: ()=>a
        })
    }
    ,
    754105: (e,t,n)=>{
        function i(e) {
            return "scriptTitle"in e && "modified"in e
        }
        function r(e) {
            return "userId"in e && "scriptAccess"in e
        }
        function o(e) {
            return "strategy" === e.kind
        }
        function s(e) {
            return "library" === e.kind
        }
        n.d(t, {
            isPubPineInfo: ()=>r,
            isSavedPineInfo: ()=>i,
            isScriptLibrary: ()=>s,
            isScriptStrategy: ()=>o
        })
    }
    ,
    520533: (e,t,n)=>{
        n.d(t, {
            deletePine: ()=>v,
            getPineFacadeUrl: ()=>o.getPineFacadeUrl,
            getPineSourceCode: ()=>g,
            isAuthToGetPineSourceCode: ()=>m,
            isPubPineInfo: ()=>u.isPubPineInfo,
            isSavedPineInfo: ()=>u.isSavedPineInfo,
            isScriptLibrary: ()=>u.isScriptLibrary,
            isScriptStrategy: ()=>u.isScriptStrategy,
            requestBuiltinScripts: ()=>f,
            requestUserScripts: ()=>_,
            translateScriptAsync2: ()=>p
        });
        var i = n(345848)
          , r = n(427233)
          , o = n(881992)
          , s = n(971417)
          , a = n(294142)
          , l = (n(791488),
        n(197677))
          , u = n(754105);
        n(129586);
        const d = new r.RequestCache
          , c = new r.RequestCache
          , h = new r.SingleRequestCache;
        async function p(e, t) {
            (0,
            i.trackEvent)("Pine", "ScriptLib.translateScript");
            const n = {};
            (0,
            s.isCustomPineId)(e) || (n.user_name = (0,
            o.getUserName)());
            try {
                const i = await (0,
                l.pineFacadeFetch)({
                    urlPath: `translate/${e}/${t}`,
                    urlParams: n
                })
                  , r = (0,
                o.handleTranslateResult)(i);
                return +t < 0 && (d.delete(e),
                c.delete(e),
                h.clear(),
                (0,
                o.onLegacyScriptProceed)(r.metaInfo)),
                r
            } catch (e) {
                throw e
            }
        }
        function m(e, t) {
            const n = d.get(e);
            if (n)
                return n;
            (0,
            i.trackEvent)("Pine", "ScriptLib.isAuthToGetPineSourceCode");
            const r = (0,
            l.pineFacadeFetch)({
                urlPath: `is_auth_to_get/${e}/${t}`
            });
            return d.set(e, r),
            r
        }
        function g(e, t, n) {
            return (0,
            i.trackEvent)("Pine", "ScriptLib.getPineSourceCode"),
            (0,
            l.pineFacadeFetch)({
                urlPath: `get/${e}/${t}`,
                urlParams: {
                    no_4xx: n
                }
            })
        }
        function _() {
            if ((0,
            i.trackEvent)("Pine", "ScriptLib.requestUserScripts"),
            !window.is_authenticated)
                return Promise.resolve([]);
            const e = h.get();
            if (e)
                return e;
            const t = (0,
            l.pineFacadeFetch)({
                urlPath: "list",
                urlParams: {
                    filter: "saved"
                }
            });
            return h.reset(t),
            t
        }
        async function f() {
            (0,
            i.trackEvent)("Pine", "ScriptLib.requestBuiltinScripts");
            try {
                a.log.logNormal("Request built-in scripts");
                const e = await (0,
                l.pineFacadeFetch)({
                    urlPath: "list",
                    urlParams: {
                        filter: "standard"
                    },
                    withoutCredentials: !0
                });
                return a.log.logNormal("Request built-in scripts finished"),
                e
            } catch (e) {
                throw a.log.logWarn("Request built-in scripts finished with fail"),
                e
            }
        }
        function v(e) {
            return (0,
            i.trackEvent)("Pine", "ScriptLib.deletePine"),
            (0,
            l.pineFacadeFetch)({
                method: "POST",
                urlPath: `delete/${e}`,
                urlParams: {
                    user_name: (0,
                    o.getUserName)()
                }
            }).then((t=>(d.delete(e),
            c.delete(e),
            h.clear(),
            (0,
            o.onDeleteScript)(e),
            t)))
        }
        (0,
        o.applyGlobalScriptListeners)(d, c, h)
    }
    ,
    881992: (e,t,n)=>{
        n.d(t, {
            applyGlobalScriptListeners: ()=>p,
            getPineFacadeUrl: ()=>l,
            getUserName: ()=>a,
            handleTranslateResult: ()=>d,
            onDeleteScript: ()=>c,
            onLegacyScriptProceed: ()=>h,
            safetyGetReason: ()=>u
        });
        var i = n(251954)
          , r = n(226722)
          , o = n(791488)
          , s = n(129586);
        function a() {
            return window.user && window.user.username
        }
        function l() {
            const e = new URL(window.PINE_URL,location.origin);
            return e.pathname.endsWith("/") || (e.pathname += "/"),
            e.href
        }
        function u(e) {
            if ("object" == typeof e.reason)
                return e.reason;
            if (e.reason2)
                return e.reason2;
            const t = {
                errors: [],
                warnings: []
            };
            if ((0,
            s.hasMetaInfo)(e.result)) {
                const n = e.result && e.result.metaInfo;
                n && void 0 !== n.warnings && n.warnings.forEach((e=>t.warnings.push({
                    message: e
                })))
            }
            if (e.reason) {
                (Array.isArray(e.reason) ? e.reason : e.reason.split("\n")).forEach((e=>{
                    const n = e.match(o.RE_MESSAGE_LINE_WITH_DIGITS)
                      , i = n && n.length && Number(n[1])
                      , r = {
                        message: e
                    };
                    if ("number" == typeof i) {
                        r.start = {
                            line: i,
                            column: 0
                        };
                        const e = r.message.split(": ");
                        e.shift(),
                        r.message = e.join(": ")
                    }
                    t.errors.push(r)
                }
                ))
            }
            return t
        }
        function d(e) {
            if (e.success)
                return {
                    success: e.success,
                    metaInfo: e.result.metaInfo,
                    compileErrors: u(e)
                };
            if (e.error)
                throw e.error;
            throw u(e)
        }
        function c(e) {
            const t = {
                scriptIdPart: e
            };
            r.TVXWindowEvents.emit(o.TV_SCRIPT_DELETED, JSON.stringify(t)),
            i.emit(o.TV_SCRIPT_DELETED, t),
            setTimeout((()=>{
                var e;
                null === (e = window.scriptUpdater) || void 0 === e || e.onTVScriptDeleted({
                    ...t,
                    isSelfCall: !0
                })
            }
            ))
        }
        function h(e) {
            const t = {
                scriptMetaInfo: e
            };
            r.TVXWindowEvents.emit(o.TV_SCRIPT_LEGACY_PINE_PROCESSED, JSON.stringify(t)),
            i.emit(o.TV_SCRIPT_LEGACY_PINE_PROCESSED, t),
            setTimeout((()=>{
                var e;
                null === (e = window.scriptUpdater) || void 0 === e || e.onTVScriptLegacyPineProcessed(t)
            }
            ))
        }
        function p(e, t, n) {
            r.TVXWindowEvents.on(o.TV_SCRIPT_MODIFICATION_ACTIVE, (e=>{
                var t;
                null === (t = window.scriptUpdater) || void 0 === t || t.onModifyScriptActiveChanged(JSON.parse(e))
            }
            )),
            r.TVXWindowEvents.on(o.TV_SCRIPT_MODIFIED, (e=>{
                var t;
                n.clear(),
                null === (t = window.scriptUpdater) || void 0 === t || t.onTVScriptModified(JSON.parse(e))
            }
            )),
            r.TVXWindowEvents.on(o.TV_SCRIPT_DELETED, (i=>{
                var r;
                e.clear(),
                t.clear(),
                n.clear(),
                null === (r = window.scriptUpdater) || void 0 === r || r.onTVScriptDeleted(JSON.parse(i))
            }
            )),
            r.TVXWindowEvents.on(o.TV_SCRIPT_RENAMED, (e=>{
                var t;
                n.clear(),
                null === (t = window.scriptUpdater) || void 0 === t || t.onTVScriptRenamed(JSON.parse(e))
            }
            )),
            r.TVXWindowEvents.on(o.TV_SCRIPT_LEGACY_PINE_PROCESSED, (e=>{
                var t;
                n.clear(),
                null === (t = window.scriptUpdater) || void 0 === t || t.onTVScriptLegacyPineProcessed(JSON.parse(e))
            }
            ))
        }
    }
    ,
    887357: (e,t,n)=>{
        var i, r;
        n.d(t, {
            NewsItemPermission: ()=>i,
            NewsWidgetPlacement: ()=>r
        }),
        function(e) {
            e.Headline = "headline",
            e.Preview = "preview",
            e.Provider = "provider"
        }(i || (i = {})),
        function(e) {
            e.WidgetBar = "widgetbar",
            e.Main = "main",
            e.Chart = "chart"
        }(r || (r = {}))
    }
    ,
    564894: (e,t,n)=>{
        n.d(t, {
            hasService: ()=>l,
            registerService: ()=>s,
            service: ()=>u,
            unregisterService: ()=>a,
            waitServiceRegistered: ()=>d
        });
        var i = n(268222);
        const r = {}
          , o = new Map;
        function s(e, t) {
            if (l(e))
                throw new Error("Service already registered");
            r[e.id] = t;
            const n = o.get(e.id);
            void 0 !== n && (o.delete(e.id),
            n.resolve(t))
        }
        function a(e) {
            if (!l(e))
                throw new Error("Service not found");
            r[e.id] = void 0
        }
        function l(e) {
            return void 0 !== r[e.id]
        }
        function u(e) {
            const t = r[e.id];
            if (void 0 === t)
                throw new Error("ServiceLocator: Service " + e.id + " not found");
            return t
        }
        function d(e) {
            if (l(e))
                return Promise.resolve(u(e));
            let t = o.get(e.id);
            return void 0 === t && (t = (0,
            i.createDeferredPromise)(),
            o.set(e.id, t)),
            t.promise
        }
    }
    ,
    331633: (e,t,n)=>{
        n.d(t, {
            setTheme: ()=>s,
            watchedTheme: ()=>o
        });
        var i = n(401580)
          , r = n(626333);
        const o = new i.WatchedValue;
        function s(e) {
            o.setValue(e)
        }
        o.subscribe((e=>{
            (0,
            r.applyTheme)(e, window)
        }
        ))
    }
    ,
    530254: (e,t,n)=>{
        n.d(t, {
            format: ()=>c,
            getFractionalDigitsNumber: ()=>p,
            getMetricPrefix: ()=>h
        });
        var i = n(650151)
          , r = n(960521)
          , o = n(182436)
          , s = n(943994)
          , a = n(425755)
          , l = n(31341);
        const u = new Map;
        let d = null;
        function c(e, t, n=2) {
            return Math.abs(e) >= 1e100 ? "—" : "volume" === t ? function(e) {
                d || (d = new s.VolumeFormatter);
                return d.format(e)
            }(e) : "percents" === t ? (0,
            l.forceLTRStrSsr)(function(e, t) {
                let n = "";
                e < 0 && (n = "−",
                e = -e);
                return n + function(e) {
                    if (u.has(e))
                        return (0,
                        i.ensureDefined)(u.get(e));
                    const t = new o.NumericFormatter(e);
                    return u.set(e, t),
                    t
                }(t).format(e)
            }(e, n) + "%") : (0,
            l.forceLTRStrSsr)(function(e) {
                return (new a.FinancialsFormatter).format(e)
            }(e))
        }
        function h(e) {
            const t = Math.abs(e);
            return t < 995 ? {
                symbol: "",
                multiplier: 1
            } : t < 999995 ? {
                symbol: "K",
                multiplier: 1e3
            } : t < 999999995 ? {
                symbol: "M",
                multiplier: 1e6
            } : t < 999999999995 ? {
                symbol: "B",
                multiplier: 1e9
            } : {
                symbol: "T",
                multiplier: 1e12
            }
        }
        function p(e) {
            const t = (0,
            r.Big)(e);
            return Math.max(t.c.length - t.e - 1, 0)
        }
    }
    ,
    199687: (e,t,n)=>{
        n.d(t, {
            DEFAULT_PERIOD: ()=>u,
            PERIODS: ()=>l,
            PageId: ()=>i,
            getFinancialsPages: ()=>s,
            getStatementsCategories: ()=>a
        });
        var i, r = n(444372), o = n(610203);
        function s() {
            return [{
                id: i.Overview,
                children: r.t(null, void 0, n(37260))
            }, {
                id: i.Statements,
                children: r.t(null, void 0, n(861589))
            }, {
                id: i.Statistics,
                children: r.t(null, void 0, n(751706))
            }, {
                id: i.Dividends,
                children: r.t(null, void 0, n(634135))
            }, {
                id: i.Earnings,
                children: r.t(null, void 0, n(783851))
            }, {
                id: i.Revenue,
                children: r.t(null, void 0, n(259285))
            }]
        }
        function a() {
            return [{
                id: "income statements",
                children: r.t(null, void 0, n(676712))
            }, {
                id: "balance sheet",
                children: r.t(null, void 0, n(342134))
            }, {
                id: "cash flow",
                children: r.t(null, void 0, n(638237))
            }]
        }
        !function(e) {
            e.Overview = "overview",
            e.Statements = "statements",
            e.Statistics = "statistics",
            e.Dividends = "dividends",
            e.Earnings = "earnings",
            e.Revenue = "revenue"
        }(i || (i = {}));
        const l = (e=o.PeriodId.Quarter)=>[{
            id: o.PeriodId.Year,
            title: r.t(null, void 0, n(34314))
        }, {
            id: e,
            title: e === o.PeriodId.HalfYear ? r.t(null, void 0, n(512421)) : r.t(null, void 0, n(908831))
        }]
          , u = e=>l(e)[1].id
    }
    ,
    261309: (e,t,n)=>{
        n.d(t, {
            SYMBOL_LIST_REPOSITORY_BACKEND_SERVICE: ()=>i
        });
        const i = {
            id: "SymbolListRepositoryBackend"
        }
    }
    ,
    738600: (e,t,n)=>{
        n.d(t, {
            logger: ()=>i
        });
        const i = (0,
        n(201089).getLogger)("Platform.Model.Watchlist")
    }
    ,
    876332: (e,t,n)=>{
        n.r(t),
        n.d(t, {
            destroyQuoteSessions: ()=>u,
            getQuoteSessionInstance: ()=>s,
            getQuoteSessionNoEnsure: ()=>l,
            setQuoteSessionInstance: ()=>a
        });
        var i = n(11228)
          , r = n.n(i);
        const o = {};
        function s(e="full") {
            return o[e] || a(e, new (r())(e)),
            o[e]
        }
        function a(e="full", t) {
            o[e] = t
        }
        function l(e="full") {
            return o[e]
        }
        function u() {
            for (const e in o)
                if (o.hasOwnProperty(e)) {
                    const t = o[e];
                    void 0 !== t && t.destroy(),
                    delete o[e]
                }
        }
    }
    ,
    66732: (e,t,n)=>{
        n.d(t, {
            combine: ()=>s,
            combineWithFilteredUpdate: ()=>o
        });
        var i = n(401580);
        function r(e, t, ...n) {
            const r = (...t)=>e(...t.map((e=>e.value())))
              , o = new i.WatchedValue(r(...n))
              , s = ()=>{
                t(...n.map((e=>e.value()))) && o.setValue(r(...n))
            }
              , a = n.map((e=>e.spawn()));
            for (const e of a)
                e.subscribe(s);
            return o.readonly().spawn((()=>{
                a.forEach((e=>e.destroy())),
                n.forEach((e=>e.release()))
            }
            ))
        }
        function o(e, t, ...n) {
            return r(e, t, ...n)
        }
        function s(e, ...t) {
            return r(e, (()=>!0), ...t)
        }
    }
    ,
    678515: (e,t,n)=>{
        function i(e, t) {
            return e <= t
        }
        function r(e, t) {
            return e >= t
        }
        function o(e, t, n) {
            return Math.min(Math.max(e, t), n)
        }
        function s(e) {
            return e < 0 ? -1 : e > 0 ? 1 : 0
        }
        function a(e) {
            if (e < 0)
                return !1;
            if (e > 1e18)
                return !0;
            for (let t = e; t > 1; t /= 10)
                if (t % 10 != 0)
                    return !1;
            return !0
        }
        function l(e, t, n) {
            return t - e <= n
        }
        function u(e, t, n) {
            return Math.abs(e - t) < n
        }
        function d(e) {
            return e <= 0 ? NaN : Math.log(e) / Math.log(10)
        }
        function c(e, t) {
            return e < t ? -1 : e > t ? 1 : 0
        }
        function h(e, t=c) {
            if (e.length < 1)
                throw Error("array is empty");
            let n = e[0];
            for (let i = 0; i < e.length; ++i)
                t(e[i], n) < 0 && (n = e[i]);
            return n
        }
        function p(e, t=c) {
            if (e.length < 1)
                throw Error("array is empty");
            let n = e[0];
            for (let i = 0; i < e.length; ++i)
                t(e[i], n) > 0 && (n = e[i]);
            return n
        }
        function m(e) {
            const t = Math.ceil(e);
            return t % 2 != 0 ? t - 1 : t
        }
        function g(e) {
            return e > 0 ? Math.floor(e) : Math.ceil(e)
        }
        n.r(t),
        n.d(t, {
            ceiledEven: ()=>m,
            clamp: ()=>o,
            defComparator: ()=>c,
            equal: ()=>u,
            greaterOrEqual: ()=>l,
            greaterThan: ()=>r,
            isBaseDecimal: ()=>a,
            lessThan: ()=>i,
            log10: ()=>d,
            max: ()=>p,
            min: ()=>h,
            sign: ()=>s,
            toInt: ()=>g
        })
    }
    ,
    618820: (e,t,n)=>{
        n.d(t, {
            isDrawingToolbarVisible: ()=>l
        });
        var i = n(62802)
          , r = n(244842)
          , o = n(401580);
        const s = !r.enabled("hide_left_toolbar_by_default")
          , a = i.getBool("ChartDrawingToolbarWidget.visible", s)
          , l = new o.WatchedValue(a)
    }
    ,
    342395: (e,t,n)=>{
        n.d(t, {
            makeSnapshotRequest: ()=>u,
            takeChartSnapshot: ()=>l,
            takeChartSnapshotPromise: ()=>a
        });
        n(586463);
        var i = n(444372)
          , r = n(244842)
          , o = n(229534)
          , s = n(120780);
        function a(e, t={}) {
            return new Promise(((n,i)=>{
                l(e, n, i, t)
            }
            ))
        }
        async function l(e, t, n, i={}) {
            var r;
            const o = new FormData;
            if (void 0 !== i.previews)
                for (const e of i.previews)
                    o.append("previews[]", e);
            void 0 !== i.cme && o.append("cme", String(i.cme)),
            void 0 !== i.wl && o.append("wl", String(i.wl)),
            void 0 !== i.onWidget && o.append("onWidget", String(i.onWidget)),
            i.isReport && o.append("isReport", String(i.isReport)),
            i.asyncSave && o.append("asyncSave", String(i.asyncSave));
            const s = window.urlParams;
            s && s.locale && o.append("language", s.locale);
            const a = e.activeChartWidget.value()
              , l = a.widgetCustomer();
            void 0 !== l && o.append("customer", l);
            let d = a.properties().childs().timezone.value();
            "exchange" === d && (d = (null === (r = a.model().mainSeries().symbolInfo()) || void 0 === r ? void 0 : r.timezone) || d),
            o.append("timezone", d),
            o.append("symbol", a.model().mainSeries().symbol());
            const c = await e.clientSnapshot({
                showHeaderMainSymbol: i.showHeaderMainSymbol
            })
              , h = await new Promise((e=>c.toBlob(e)));
            null !== h && o.append("preparedImage", h),
            u(o, t, n, i)
        }
        async function u(e, t, a, l={}) {
            const u = r.enabled("charting_library_base") ? l.snapshotUrl || "https://www.tradingview.com/snapshot/" : "/snapshot/";
            try {
                const r = await (0,
                s.fetch)(u, {
                    body: e,
                    method: "POST",
                    credentials: "same-origin"
                })
                  , d = await r.text();
                if (r.ok)
                    t(d);
                else {
                    if ("suspicious_chart_snapshots_error" === d) {
                        const e = i.t(null, void 0, n(347362)).format({
                            start_link: '<a class="tv-dialog__link js-send-report-link" href="#" data-issue-type="other">',
                            end_link: "</a>"
                        });
                        l.onInvalidSnapshotImage && l.onInvalidSnapshotImage();
                        return (0,
                        o.createErrorDialog)({
                            title: i.t(null, void 0, n(567137)),
                            content: e,
                            btnType: "danger"
                        }).then((e=>{
                            e.on("afterOpen", (()=>{
                                n.e(1484).then(n.bind(n, 601042)).then((({bugDialogCreationHandler: t})=>{
                                    t(),
                                    e.$el.find(".js-send-report-link").click((()=>{
                                        e.close()
                                    }
                                    ))
                                }
                                ))
                            }
                            )),
                            e.open()
                        }
                        ))
                    }
                    a()
                }
            } catch (e) {
                a()
            }
        }
    }
    ,
    242558: (e,t,n)=>{
        n.d(t, {
            createDwmAligner: ()=>u,
            createTimeToBarTimeAligner: ()=>c
        });
        var i = n(988124)
          , r = n(244842)
          , o = n(223699)
          , s = n(995310)
          , a = n(547944);
        const l = new s.SessionInfo("Etc/UTC","0000-0000:1234567");
        function u(e, t) {
            if (!d() || !o.Interval.isDWM(e))
                return null;
            const n = new s.SessionInfo(t.timezone,t.session,t.session_holidays,t.corrections)
              , r = (0,
            a.newBarBuilder)(e, n, l);
            return {
                timeToSessionStart: e=>r.tradingDayToSessionStart(e),
                timeToExchangeTradingDay: e=>{
                    const t = i.utc_to_cal(n.timezone, e)
                      , r = n.spec.correctTradingDay(t);
                    return i.set_hms(r, 0, 0, 0, 0, i.get_timezone("Etc/UTC")),
                    r.getTime()
                }
            }
        }
        function d() {
            return !r.enabled("disable_resolution_rebuild")
        }
        function c(e, t) {
            if (!d())
                return e=>e;
            const n = new s.SessionInfo(t.timezone,t.session,t.session_holidays,t.corrections)
              , i = (0,
            a.newBarBuilder)(e, n, n, !1);
            return e=>i.alignTimeIfPossible(e)
        }
    }
    ,
    987571: (e,t,n)=>{
        var i;
        n.d(t, {
            SessionStage: ()=>i
        }),
        function(e) {
            e[e.PRE_SESSION = -1] = "PRE_SESSION",
            e[e.POST_SESSION = -2] = "POST_SESSION",
            e[e.LASTBAR_SESSION = -3] = "LASTBAR_SESSION"
        }(i || (i = {}))
    }
    ,
    919892: (e,t,n)=>{
        n.d(t, {
            DEFAULT_ADJUSTMENT: ()=>r,
            DEFAULT_SESSION: ()=>i,
            DEFAULT_SETTLEMENT_AS_CLOSE: ()=>o,
            compareSymbols: ()=>g,
            decodeExtendedSymbol: ()=>h,
            encodeExtendedSymbolOrGetSimpleSymbolString: ()=>d,
            isEncodedExtendedSymbol: ()=>c,
            isReplaySymbol: ()=>u,
            isStudySymbol: ()=>l,
            unwrapSimpleSymbol: ()=>p
        });
        const i = "regular"
          , r = "splits"
          , o = !0;
        function s(e) {
            return "=" + JSON.stringify(a(e))
        }
        function a(e) {
            return Object.keys(e).sort().reduce(((t,n)=>("[object Object]" === Object.prototype.toString.call(e[n]) ? t[n] = a(e[n]) : t[n] = e[n],
            t)), {})
        }
        function l(e) {
            return Boolean(e.inputs)
        }
        function u(e) {
            return Boolean(e.replay)
        }
        function d(e) {
            return l(e) || u(e) || e.session || e.adjustment || e["currency-id"] || e["unit-id"] ? s(e) : e.symbol
        }
        function c(e) {
            return "=" === e[0]
        }
        function h(e) {
            if (!c(e))
                return {
                    symbol: e
                };
            try {
                return JSON.parse(e.slice(1))
            } catch (t) {
                return {
                    symbol: e
                }
            }
        }
        function p(e) {
            return "string" == typeof e ? e : p(e.symbol)
        }
        const m = ["symbol", "session", "unit-id", "currency-id", "adjustment", "backadjustment", "settlement-as-close"];
        function g(e, t) {
            return m.every((n=>e[n] === t[n]))
        }
    }
    ,
    157954: (e,t,n)=>{
        n.d(t, {
            DateFormatter: ()=>o
        });
        var i = n(551775)
          , r = n(958067);
        class o {
            constructor(e="yyyy-MM-dd", t=!1) {
                this._dateFormatFunc = t ? (0,
                r.getDateFormatWithWeekday)(e) : r.dateFormatFunctions[e]
            }
            format(e) {
                return i.customFormatters && i.customFormatters.dateFormatter ? i.customFormatters.dateFormatter.format(e) : this._dateFormatFunc(e, !1)
            }
            formatLocal(e) {
                return i.customFormatters.dateFormatter ? i.customFormatters.dateFormatter.formatLocal ? i.customFormatters.dateFormatter.formatLocal(e) : i.customFormatters.dateFormatter.format(e) : this._dateFormatFunc(e, !0)
            }
            parse(e) {
                if ("" === e)
                    return {
                        res: !1
                    };
                let t = e;
                return i.customFormatters && i.customFormatters.dateFormatter && !i.customFormatters.dateFormatter.parse && console.warn("You need to provide a `parse` function as part of `dateFormatter`"),
                i.customFormatters && i.customFormatters.dateFormatter && i.customFormatters.dateFormatter.parse && (t = String(i.customFormatters.dateFormatter.parse(e))),
                {
                    res: !0,
                    value: t
                }
            }
        }
    }
    ,
    425755: (e,t,n)=>{
        n.d(t, {
            FINANCIALS_FORMATTER_MAX_VALUE: ()=>o,
            FinancialsFormatter: ()=>s
        });
        var i = n(444372)
          , r = n(31341);
        const o = 1e100;
        class s {
            constructor(e=2, t) {
                this._formatter = new Intl.NumberFormat("en-US",{
                    notation: "compact",
                    minimumFractionDigits: null != t ? t : e,
                    maximumFractionDigits: e
                })
            }
            format(e) {
                if (Math.abs(e) >= o)
                    return i.t(null, void 0, n(343088));
                let t = this._formatter.format(Math.abs(e));
                e < 0 && 0 !== Number(t) && (t = "−" + t);
                const s = t[t.length - 1];
                return isNaN(Number(s)) ? (0,
                r.forceLTRStrSsr)(`${t.slice(0, t.length - 1)} ${s}`) : t
            }
        }
    }
    ,
    182436: (e,t,n)=>{
        n.d(t, {
            NumericFormatter: ()=>o
        });
        var i = n(960521)
          , r = n(702053);
        class o {
            constructor(e) {
                this._precision = e
            }
            format(e) {
                return (void 0 !== this._precision ? e.toFixed(this._precision) : o.formatNoE(e)).replace(".", r.formatterOptions.decimalSign)
            }
            parse(e) {
                const t = e.replace(r.formatterOptions.decimalSign, ".");
                let n = parseFloat(t);
                return this._precision && (n = +n.toFixed(this._precision)),
                n
            }
            static formatNoE(e) {
                if (!Number.isFinite(e))
                    return String(e);
                const t = new i.Big(e);
                return t.lt(1) ? t.toFixed() : t.toString()
            }
        }
    }
    ,
    223699: (e,t,n)=>{
        n.d(t, {
            Interval: ()=>d,
            ResolutionKind: ()=>o,
            SpecialResolutionKind: ()=>s,
            isHour: ()=>h
        });
        const i = /^(\d*)([TSHDWMR])$/
          , r = /^(\d+)$/;
        var o, s;
        !function(e) {
            e.Ticks = "ticks",
            e.Seconds = "seconds",
            e.Minutes = "minutes",
            e.Days = "days",
            e.Weeks = "weeks",
            e.Months = "months",
            e.Range = "range",
            e.Invalid = "invalid"
        }(o || (o = {})),
        function(e) {
            e.Hours = "hours"
        }(s || (s = {}));
        const a = {};
        a[o.Ticks] = 1e3,
        a[o.Seconds] = 1e3,
        a[o.Minutes] = 60 * a[o.Seconds],
        a[o.Days] = 1440 * a[o.Minutes],
        a[o.Weeks] = 7 * a[o.Days];
        const l = {
            T: o.Ticks,
            S: o.Seconds,
            D: o.Days,
            W: o.Weeks,
            M: o.Months,
            R: o.Range
        }
          , u = new Set([o.Ticks, o.Seconds, o.Minutes]);
        class d {
            constructor(e, t) {
                this._kind = o.Invalid,
                this._multiplier = 0,
                e !== o.Invalid && t > 0 && (this._kind = e,
                this._multiplier = t)
            }
            kind() {
                return this._kind
            }
            multiplier() {
                return this._multiplier
            }
            isValid() {
                return this.kind() !== o.Invalid && this.multiplier() > 0
            }
            isDWM() {
                return this.isValid() && !this.isRange() && !this.isIntraday() && !this.isTicks()
            }
            isIntraday() {
                const e = u.has(this.kind());
                return this.isValid() && e
            }
            isSeconds() {
                return this.kind() === o.Seconds
            }
            isMinutes() {
                return this.kind() === o.Minutes
            }
            isMinuteHours() {
                return this.kind() === o.Minutes && h(this.multiplier())
            }
            isDays() {
                return this.kind() === o.Days
            }
            isWeeks() {
                return this.kind() === o.Weeks
            }
            isMonths() {
                return this.kind() === o.Months
            }
            isRange() {
                return this.kind() === o.Range
            }
            isTicks() {
                return this.kind() === o.Ticks
            }
            isTimeBased() {
                return !this.isRange()
            }
            letter() {
                return this.isValid() && this.kind() !== o.Minutes ? this.kind()[0].toUpperCase() : ""
            }
            value() {
                return this.isValid() ? this.kind() === o.Minutes ? this.multiplier() + "" : this.multiplier() + this.letter() : ""
            }
            isEqualTo(e) {
                if (!(e instanceof d))
                    throw new Error("Argument is not an Interval");
                return !(!this.isValid() || !e.isValid()) && (this.kind() === e.kind() && this.multiplier() === e.multiplier())
            }
            inMilliseconds(e=Date.now()) {
                if (!this.isValid() || this.isRange())
                    return NaN;
                if (this.isMonths()) {
                    const t = new Date(e);
                    t.setUTCMonth(t.getUTCMonth() + (this.multiplier() || 1));
                    return +t - e
                }
                const t = this.multiplier();
                return a[this.kind()] * t
            }
            static isEqual(e, t) {
                return e === t || d.parse(e).isEqualTo(d.parse(t))
            }
            static parseExt(e) {
                e = (e + "").toUpperCase().split(",")[0];
                let t = i.exec(e);
                return null !== t ? "H" === t[2] ? {
                    interval: new d(o.Minutes,60 * c(t[1])),
                    guiResolutionKind: s.Hours
                } : {
                    interval: new d(l[t[2]],c(t[1])),
                    guiResolutionKind: l[t[2]]
                } : (t = r.exec(e),
                null !== t ? {
                    interval: new d(o.Minutes,c(t[1])),
                    guiResolutionKind: o.Minutes
                } : {
                    interval: new d(o.Invalid,0),
                    guiResolutionKind: o.Invalid
                })
            }
            static parse(e) {
                return d.parseExt(e).interval
            }
            static kind(e) {
                return d.parse(e).kind()
            }
            static isValid(e) {
                return d.parse(e).isValid()
            }
            static isDWM(e) {
                return d.parse(e).isDWM()
            }
            static isIntraday(e) {
                return d.parse(e).isIntraday()
            }
            static isSeconds(e) {
                return d.parse(e).isSeconds()
            }
            static isMinutes(e) {
                return d.parse(e).isMinutes()
            }
            static isMinuteHours(e) {
                return d.parse(e).isMinuteHours()
            }
            static isDays(e) {
                return d.parse(e).isDays()
            }
            static isWeeks(e) {
                return d.parse(e).isWeeks()
            }
            static isMonths(e) {
                return d.parse(e).isMonths()
            }
            static isRange(e) {
                return d.parse(e).isRange()
            }
            static isTicks(e) {
                return d.parse(e).isTicks()
            }
            static isTimeBased(e) {
                return d.parse(e).isTimeBased()
            }
            static normalize(e) {
                const t = d.parse(e);
                return t.isValid() ? t.value() : null
            }
        }
        function c(e) {
            return 0 === e.length ? 1 : parseInt(e, 10)
        }
        function h(e) {
            return e >= 60 && !(e % 60)
        }
    }
    ,
    31712: (e,t,n)=>{
        n.r(t),
        n.d(t, {
            LineToolCollectedProperty: ()=>u,
            LineToolColorsProperty: ()=>c,
            LineToolMultiplePropertyBaseImpl: ()=>l,
            LineToolWidthsProperty: ()=>d,
            MultipleLineColorsProperty: ()=>m,
            MultipleLineWidthsProperty: ()=>p
        });
        var i = n(201089)
          , r = n(707957)
          , o = n(428123);
        const s = (0,
        i.getLogger)("Chart.LineToolCollectedProperty");
        class a {
            applyValue(e, t) {
                e.setValue(t)
            }
        }
        class l {
            constructor(e, t) {
                this._onChange = new r.Delegate,
                this._properties = e,
                e.forEach(((e,t)=>e.subscribe(this, ((e,n)=>{
                    this._onChange.fire(this, `${t}.${n}`)
                }
                )))),
                this._showIfProperty = t
            }
            visible() {
                var e;
                return !this._showIfProperty || (null === (e = this._showIfProperty) || void 0 === e ? void 0 : e.value())
            }
            value() {
                if (0 === this._properties.length)
                    return s.logError("Incorrect call, should not request value of 0 properties"),
                    "mixed";
                const e = this._properties[0].value();
                return 1 === this._properties.length || this._properties.every((t=>t.value() === e)) ? e : "mixed"
            }
            state() {}
            merge() {}
            destroy() {
                this._properties.forEach((e=>e.unsubscribeAll(this))),
                this._onChange.destroy()
            }
            subscribe(e, t) {
                this._onChange.subscribe(e, t)
            }
            unsubscribe(e, t) {
                this._onChange.unsubscribe(e, t)
            }
            unsubscribeAll(e) {
                this._onChange.unsubscribeAll(e)
            }
            storeStateIfUndefined() {
                return !0
            }
            weakReference() {
                return (0,
                o.weakReference)(this)
            }
            ownership() {
                return (0,
                o.ownership)(this)
            }
        }
        class u extends l {
            setValue(e, t, n) {
                if ("mixed" === e)
                    return;
                const i = null != n ? n : new a;
                this._properties.forEach((t=>i.applyValue(t, e)))
            }
        }
        class d extends u {
        }
        class c extends u {
            firstColor() {
                return this._properties[0].value()
            }
        }
        class h extends l {
            setValue(e, t, n) {
                if ("mixed" === e)
                    return;
                const i = null != n ? n : new a;
                this._properties.forEach((t=>t.setValue(e, void 0, i)))
            }
        }
        class p extends h {
        }
        class m extends h {
        }
    }
    ,
    918208: (e,t,n)=>{
        n.d(t, {
            lineToolsLocalizedNames: ()=>r
        });
        var i = n(444372);
        const r = {
            LineTool5PointsPattern: i.t(null, void 0, n(566527)),
            LineToolABCD: i.t(null, void 0, n(532852)),
            LineToolArc: i.t(null, void 0, n(745104)),
            LineToolArrow: i.t(null, void 0, n(696237)),
            LineToolArrowMarkDown: i.t(null, void 0, n(908738)),
            LineToolArrowMarkLeft: i.t(null, void 0, n(835062)),
            LineToolArrowMarkRight: i.t(null, void 0, n(192163)),
            LineToolArrowMarkUp: i.t(null, void 0, n(633196)),
            LineToolBalloon: i.t(null, void 0, n(40664)),
            LineToolComment: i.t(null, void 0, n(119372)),
            LineToolBarsPattern: i.t(null, void 0, n(98838)),
            LineToolBezierCubic: i.t(null, void 0, n(59368)),
            LineToolBezierQuadro: i.t(null, void 0, n(517206)),
            LineToolBrush: i.t(null, void 0, n(530251)),
            LineToolCallout: i.t(null, void 0, n(764149)),
            LineToolCircleLines: i.t(null, void 0, n(587761)),
            LineToolCypherPattern: i.t(null, void 0, n(927891)),
            LineToolDateAndPriceRange: i.t(null, void 0, n(379859)),
            LineToolDateRange: i.t(null, void 0, n(660222)),
            LineToolDisjointAngle: i.t(null, void 0, n(603556)),
            LineToolElliottCorrection: i.t(null, void 0, n(291215)),
            LineToolElliottDoubleCombo: i.t(null, void 0, n(180983)),
            LineToolElliottImpulse: i.t(null, void 0, n(674118)),
            LineToolElliottTriangle: i.t(null, void 0, n(95840)),
            LineToolElliottTripleCombo: i.t(null, void 0, n(866637)),
            LineToolEllipse: i.t(null, void 0, n(469418)),
            LineToolExtended: i.t(null, void 0, n(302578)),
            LineToolFibChannel: i.t(null, void 0, n(482719)),
            LineToolFibCircles: i.t(null, void 0, n(464192)),
            LineToolFibRetracement: i.t(null, void 0, n(463835)),
            LineToolFibSpeedResistanceArcs: i.t(null, void 0, n(418072)),
            LineToolFibSpeedResistanceFan: i.t(null, void 0, n(220877)),
            LineToolFibSpiral: i.t(null, void 0, n(476783)),
            LineToolFibTimeZone: i.t(null, void 0, n(489037)),
            LineToolFibWedge: i.t(null, void 0, n(472489)),
            LineToolFlagMark: i.t(null, void 0, n(155678)),
            LineToolImage: i.t(null, void 0, n(223450)),
            LineToolFlatBottom: i.t(null, void 0, n(829230)),
            LineToolAnchoredVWAP: i.t(null, void 0, n(961704)),
            LineToolGannComplex: i.t(null, void 0, n(366321)),
            LineToolGannFixed: i.t(null, void 0, n(887107)),
            LineToolGannFan: i.t(null, void 0, n(168102)),
            LineToolGannSquare: i.t(null, void 0, n(981180)),
            LineToolHeadAndShoulders: i.t(null, void 0, n(742616)),
            LineToolHorzLine: i.t(null, void 0, n(160049)),
            LineToolHorzRay: i.t(null, void 0, n(76604)),
            LineToolIcon: i.t(null, void 0, n(326579)),
            LineToolEmoji: i.t(null, void 0, n(285223)),
            LineToolSticker: i.t(null, void 0, n(184573)),
            LineToolInsidePitchfork: i.t(null, void 0, n(312354)),
            LineToolNote: i.t(null, void 0, n(275549)),
            LineToolNoteAbsolute: i.t(null, void 0, n(366828)),
            LineToolSignpost: i.t(null, void 0, n(368161)),
            LineToolParallelChannel: i.t(null, void 0, n(670394)),
            LineToolPitchfan: i.t(null, void 0, n(422293)),
            LineToolPitchfork: i.t(null, void 0, n(143852)),
            LineToolPolyline: i.t(null, void 0, n(953047)),
            LineToolPath: i.t(null, void 0, n(234402)),
            LineToolPrediction: i.t(null, void 0, n(436972)),
            LineToolPriceLabel: i.t(null, void 0, n(495921)),
            LineToolArrowMarker: i.t(null, void 0, n(982473)),
            LineToolPriceRange: i.t(null, void 0, n(102032)),
            LineToolProjection: i.t(null, void 0, n(187086)),
            LineToolRay: i.t(null, void 0, n(50470)),
            LineToolRectangle: i.t(null, void 0, n(200328)),
            LineToolCircle: i.t(null, void 0, n(490068)),
            LineToolRegressionTrend: i.t(null, void 0, n(435001)),
            LineToolRiskRewardLong: i.t(null, void 0, n(844604)),
            LineToolRiskRewardShort: i.t(null, void 0, n(937819)),
            LineToolFixedRangeVolumeProfile: i.t(null, {
                context: "study"
            }, n(40434)),
            LineToolAnchoredVolumeProfile: i.t(null, {
                context: "study"
            }, n(59791)),
            LineToolRotatedRectangle: i.t(null, void 0, n(409998)),
            LineToolSchiffPitchfork: i.t(null, void 0, n(518559)),
            LineToolSchiffPitchfork2: i.t(null, void 0, n(298114)),
            LineToolSineLine: i.t(null, void 0, n(369502)),
            LineToolText: i.t(null, {
                context: "tool"
            }, n(20936)),
            LineToolTextAbsolute: i.t(null, void 0, n(694782)),
            LineToolThreeDrivers: i.t(null, void 0, n(298538)),
            LineToolTimeCycles: i.t(null, void 0, n(395005)),
            LineToolTrendAngle: i.t(null, void 0, n(294770)),
            LineToolTrendBasedFibExtension: i.t(null, void 0, n(715501)),
            LineToolTrendBasedFibTime: i.t(null, void 0, n(931196)),
            LineToolTrendLine: i.t(null, void 0, n(423104)),
            LineToolInfoLine: i.t(null, void 0, n(627677)),
            LineToolTriangle: i.t(null, void 0, n(729245)),
            LineToolTrianglePattern: i.t(null, void 0, n(112390)),
            LineToolVertLine: i.t(null, void 0, n(156211)),
            LineToolCrossLine: i.t(null, void 0, n(260997)),
            LineToolHighlighter: i.t(null, void 0, n(831895)),
            LineToolPriceNote: i.t(null, void 0, n(328625)),
            LineToolVbPFixed: i.t(null, void 0, n(518426)),
            LineToolGhostFeed: i.t(null, void 0, n(807914))
        };
        r.LineToolTweet = i.t(null, void 0, n(100970)),
        r.LineToolIdea = i.t(null, void 0, n(241246))
    }
    ,
    713473: (e,t,n)=>{
        var i;
        n.r(t),
        n.d(t, {
            cloneLineTool: ()=>B,
            createLineTool: ()=>x,
            createLineToolProperties: ()=>F,
            createStudyLineToolProperties: ()=>A,
            getNewToolProperties: ()=>E,
            initAllLineToolsFromContent: ()=>C,
            initLineTool: ()=>R,
            isEditableTextLineTool: ()=>N,
            isLineTool: ()=>V,
            isStudyLineTool: ()=>M,
            isTrading: ()=>O,
            lineToolByLinkKey: ()=>U,
            prepareLineToolPropertiesByOwnerSource: ()=>k,
            setNewToolProperties: ()=>L,
            supportsPhantomMode: ()=>D,
            tryFindStudyLineToolNameByStudyId: ()=>W,
            unsetNewToolProperties: ()=>P
        });
        var r = n(650151)
          , o = n(86441)
          , s = n(395098)
          , a = n(2122)
          , l = n(821979)
          , u = n(968361)
          , d = n(44004)
          , c = n(928890)
          , h = n(224153)
          , p = n(975630)
          , m = n(484775)
          , g = n(364615)
          , _ = n(477227)
          , f = n(444331)
          , v = n(616117)
          , y = n(347710)
          , b = n(138886);
        function w(e) {
            for (const t of Object.keys(e))
                TradingView[t] = e[t]
        }
        w(i || (i = n.t(u, 2))),
        w({
            LineToolRegressionTrend: d.LineToolRegressionTrend,
            LineToolVbPFixed: h.LineToolVbPFixed,
            LineToolFixedRangeVolumeProfile: c.LineToolFixedRangeVolumeProfile,
            LineToolAnchoredVWAP: p.LineToolAnchoredVWAP
        }),
        w(m),
        w({
            LineToolAnchoredVolumeProfile: g.LineToolAnchoredVolumeProfile
        });
        const S = {};
        Object.assign(S, i || (i = n.t(u, 2)));
        let T = null;
        function L(e, t, n) {
            return null !== T && T.tool === e && T.toolData === t || (T = {
                properties: F(e, void 0, n),
                tool: e,
                toolData: t
            }),
            T.properties
        }
        function P() {
            T = null
        }
        function E(e) {
            return null !== T && T.tool === e ? T.properties : null
        }
        const I = new Map([["LineToolPriceNote", async()=>(await Promise.all([n.e(96461), n.e(30154), n.e(82375), n.e(50736), n.e(380)]).then(n.bind(n, 82618))).LineToolPriceNote], ["LineToolFibSpiral", async()=>(await Promise.all([n.e(96461), n.e(30154), n.e(82375), n.e(50736), n.e(78090)]).then(n.bind(n, 154628))).LineToolFibSpiral], ["LineToolCircleLines", async()=>(await Promise.all([n.e(96461), n.e(30154), n.e(82375), n.e(59445)]).then(n.bind(n, 869523))).LineToolCyclicLines]]);
        async function R(e) {
            if (M(e) && await (0,
            y.studyMetaInfoRepository)().findAllJavaStudies(),
            S[e])
                return;
            if (!S.hasOwnProperty(e))
                return;
            const t = (0,
            r.ensureDefined)(I.get(e));
            S[e] = await t()
        }
        async function C(e) {
            if (!e)
                return;
            const t = new Set;
            ("charts"in e ? e.charts : [e]).forEach((e=>{
                e.panes.forEach((e=>{
                    e.sources.forEach((e=>{
                        (0,
                        v.isLineToolName)(e.type) && t.add(e.type)
                    }
                    ))
                }
                ))
            }
            )),
            await Promise.all(Array.from(t).map((e=>R(e))))
        }
        function x(e, t, n, i, o, s) {
            let a;
            if ((0,
            r.assert)((0,
            v.isLineToolName)(e), "Unknown line tool: " + e),
            o || n || (n = E(e) || void 0),
            "LineToolVbPFixed" === e)
                a = new h.LineToolVbPFixed(t,n,(0,
                r.ensureDefined)(i),o,s);
            else if ("LineToolAnchoredVolumeProfile" === e)
                a = new g.LineToolAnchoredVolumeProfile(t,n,(0,
                r.ensureDefined)(i),o,s);
            else if ("LineToolFixedRangeVolumeProfile" === e)
                a = new c.LineToolFixedRangeVolumeProfile(t,n,(0,
                r.ensureDefined)(i),o,s);
            else if ("LineToolRegressionTrend" === e)
                a = new d.LineToolRegressionTrend(t,n,(0,
                r.ensureDefined)(i),o,s);
            else if ("LineToolAnchoredVWAP" === e)
                a = new p.LineToolAnchoredVWAP(t,n,(0,
                r.ensureDefined)(i),o,s);
            else if (e in m) {
                a = new ((0,
                r.ensureDefined)(m[e]))(t,n,(0,
                r.ensureDefined)(i),o,s)
            } else {
                a = new ((0,
                r.ensureDefined)(S[e]))(t,n,o,s)
            }
            return a.toolname = e,
            P(),
            a
        }
        function k(e, t) {
            const n = (0,
            r.ensureNotNull)(t.symbolSource())
              , i = n.symbolInfo()
              , o = i ? (0,
            f.extractLineToolSymbolFromSymbolInfo)(i, n.symbol()) : n.symbol();
            e.childs().symbol.setValue(o),
            n.model().currencyConversionEnabled() && n.isConvertedToOtherCurrency() && e.childs().currencyId.setValue(n.currency()),
            n.model().unitConversionEnabled() && n.isConvertedToOtherUnit() && e.childs().unitId.setValue(n.unit()),
            e.childs().symbolStateVersion.setValue(2),
            e.childs().zOrderVersion.setValue(2)
        }
        function F(e, t, n, i) {
            if ((0,
            r.assert)((0,
            v.isLineToolName)(e), `${e} should be name of the line tool`),
            "LineToolVbPFixed" === e)
                return h.LineToolVbPFixed.createProperties(n, t);
            if ("LineToolAnchoredVolumeProfile" === e)
                return g.LineToolAnchoredVolumeProfile.createProperties(n, t);
            if ("LineToolFixedRangeVolumeProfile" === e)
                return c.LineToolFixedRangeVolumeProfile.createProperties(n, t);
            if ("LineToolRegressionTrend" === e)
                return d.LineToolRegressionTrend.createProperties(n, t);
            if ("LineToolAnchoredVWAP" === e)
                return p.LineToolAnchoredVWAP.createProperties(n, t);
            if (e in m) {
                return (0,
                r.ensureDefined)(m[e]).createProperties(t)
            }
            return (0,
            r.ensureDefined)(S[e]).createProperties(t, i)
        }
        function A(e, t, n, i, o) {
            if ((0,
            r.assert)((0,
            v.isStudyLineToolName)(e), `${e} should be name of the study line tool`),
            "LineToolVbPFixed" === e)
                return h.LineToolVbPFixed.createPropertiesFromStudyMetaInfoAndState(t, n, i, o);
            if ("LineToolAnchoredVolumeProfile" === e)
                return g.LineToolAnchoredVolumeProfile.createPropertiesFromStudyMetaInfoAndState(t, n, i, o);
            if ("LineToolFixedRangeVolumeProfile" === e)
                return c.LineToolFixedRangeVolumeProfile.createPropertiesFromStudyMetaInfoAndState(t, n, i, o);
            if ("LineToolRegressionTrend" === e)
                return d.LineToolRegressionTrend.createRegressionTrendPropertiesFromStudyMetaInfoAndState(t, n, i, o);
            if ("LineToolAnchoredVWAP" === e)
                return p.LineToolAnchoredVWAP.createPropertiesFromStudyMetaInfoAndState(t, n, i, o);
            if (e in m) {
                return (0,
                r.ensureDefined)(m[e]).createPropertiesFromStudyMetaInfoAndState(t, n, i, o)
            }
            throw new Error(`Property creation is not implemented for study line tool ${e}`)
        }
        function D(e) {
            (0,
            r.assert)((0,
            v.isLineToolName)(e), `${e} should be name of the line tool`);
            const t = (i || (i = n.t(u, 2)))[e];
            return void 0 !== t && Boolean(t.supportPhantomMode)
        }
        function V(e) {
            return e instanceof l.LineDataSource
        }
        function M(e) {
            return e instanceof a.StudyLineDataSource
        }
        function O(e) {
            return e instanceof _.LineToolTrading
        }
        function N(e) {
            return e instanceof b.InplaceTextLineDataSource
        }
        function W(e) {
            let t = null;
            if (e === d.LineToolRegressionTrend.studyId() ? t = "LineToolRegressionTrend" : e === h.LineToolVbPFixed.studyId() ? t = "LineToolVbPFixed" : e === c.LineToolFixedRangeVolumeProfile.studyId() && (t = "LineToolFixedRangeVolumeProfile"),
            null === t)
                for (const t in m)
                    if (m[t].studyId() === e)
                        return t;
            return t
        }
        function B(e, t, n, i) {
            const a = t.toolname
              , l = t.properties().state();
            l.intervalsVisibilities = (0,
            s.mergeIntervalVisibilitiesDefaults)(null == l ? void 0 : l.intervalsVisibilities);
            const u = F(t.toolname, l, e);
            u.childs().visible.setValue(!0);
            const d = (0,
            r.ensureNotNull)(t.ownerSource())
              , c = x(a, e, u);
            void 0 !== i && c.setId(i),
            c.setOwnerSource(d),
            c.toolname = a;
            const h = c.clonePositionOffset();
            if (t.isFixed()) {
                const e = (0,
                r.ensureDefined)(t.fixedPoint())
                  , i = n ? e.add(new o.Point(h.xCoordOffset,h.yCoordOffset)) : e;
                c.addFixedPoint(i)
            }
            const p = t.normalizedPoints()
              , m = n ? function(e, t, n) {
                const i = (0,
                r.ensureNotNull)(t.priceScale())
                  , o = (0,
                r.ensureNotNull)(t.firstValue());
                return e.map((e=>{
                    const t = e.price
                      , r = i.priceToCoordinate(t, o) + n.yCoordOffset
                      , s = i.coordinateToPrice(r, o);
                    return {
                        time_t: e.time_t,
                        price: s,
                        offset: e.offset + n.barOffset
                    }
                }
                ))
            }(p, d, h) : p
              , g = t.points();
            return c.restorePoints(m, g),
            c.cloneData && c.cloneData(t),
            c.recalculateStateByData && c.recalculateStateByData(),
            c
        }
        function U(e, t) {
            var n;
            return null !== (n = e.dataSources().find((e=>V(e) && e.linkKey().value() === t))) && void 0 !== n ? n : null
        }
    }
    ,
    147354: (e,t,n)=>{
        var i;
        n.d(t, {
            PaneCursorType: ()=>i
        }),
        function(e) {
            e[e.Default = 0] = "Default",
            e[e.Pointer = 1] = "Pointer",
            e[e.Eraser = 2] = "Eraser",
            e[e.Dot = 3] = "Dot",
            e[e.Grabbing = 4] = "Grabbing",
            e[e.ZoomIn = 5] = "ZoomIn",
            e[e.VerticalResize = 6] = "VerticalResize",
            e[e.HorizontalResize = 7] = "HorizontalResize",
            e[e.DiagonalNeSwResize = 8] = "DiagonalNeSwResize",
            e[e.DiagonalNwSeResize = 9] = "DiagonalNwSeResize"
        }(i || (i = {}))
    }
    ,
    731042: (e,t,n)=>{
        n.d(t, {
            compareResolutions: ()=>A,
            convertResolutionsFromSettings: ()=>C,
            getApplicableIntervalForFrequency: ()=>L,
            getDefaultResolution: ()=>S,
            getMaxResolutionValue: ()=>R,
            getResolutionByChartStyle: ()=>T,
            getServerInterval: ()=>P,
            getTranslatedResolution: ()=>D,
            getTranslatedResolutionModel: ()=>V,
            intervalIsSupported: ()=>U,
            isAvailable: ()=>b,
            isIntervalEnabled: ()=>W,
            isResolutionMultiplierValid: ()=>E,
            isSecondsEnabled: ()=>O,
            isTicksEnabled: ()=>N,
            mergeResolutions: ()=>x,
            normalizeIntervalString: ()=>y,
            parseIntervalValue: ()=>B,
            setLastUsedResolution: ()=>w,
            sortResolutions: ()=>k
        });
        var i = n(444372)
          , r = n(223699)
          , o = n(444331)
          , s = n(62802)
          , a = n(583912)
          , l = n(337779)
          , u = n(638456)
          , d = n(125226)
          , c = n(389137)
          , h = n(244842);
        const p = [1, 5, 10, 15, 30]
          , m = [1, 10, 100, 1e3]
          , g = (0,
        d.isFeatureEnabled)("tick_intervals") && !(0,
        u.onWidget)()
          , _ = {
            [r.ResolutionKind.Ticks]: 1,
            [r.ResolutionKind.Seconds]: 60,
            [r.ResolutionKind.Minutes]: 1440,
            [r.SpecialResolutionKind.Hours]: 24,
            [r.ResolutionKind.Days]: 365,
            [r.ResolutionKind.Weeks]: 52,
            [r.ResolutionKind.Months]: 12,
            [r.ResolutionKind.Range]: 1e6,
            [r.ResolutionKind.Invalid]: NaN
        }
          , f = {
            [r.ResolutionKind.Ticks]: 0,
            [r.ResolutionKind.Seconds]: 1,
            [r.ResolutionKind.Minutes]: 2,
            [r.SpecialResolutionKind.Hours]: 3,
            [r.ResolutionKind.Days]: 4,
            [r.ResolutionKind.Weeks]: 5,
            [r.ResolutionKind.Months]: 6,
            [r.ResolutionKind.Range]: 7,
            [r.ResolutionKind.Invalid]: 8
        }
          , v = {
            [r.ResolutionKind.Invalid]: "",
            [r.ResolutionKind.Ticks]: i.t(null, {
                context: "interval_short"
            }, n(959231)),
            [r.ResolutionKind.Seconds]: i.t(null, {
                context: "interval_short"
            }, n(2949)),
            [r.ResolutionKind.Minutes]: i.t(null, {
                context: "interval_short"
            }, n(806791)),
            [r.SpecialResolutionKind.Hours]: i.t(null, {
                context: "interval_short"
            }, n(113994)),
            [r.ResolutionKind.Days]: i.t(null, {
                context: "interval_short"
            }, n(713395)),
            [r.ResolutionKind.Weeks]: i.t(null, {
                context: "interval_short"
            }, n(185521)),
            [r.ResolutionKind.Months]: i.t(null, {
                context: "interval_short"
            }, n(137720)),
            [r.ResolutionKind.Range]: i.t(null, {
                context: "interval_short"
            }, n(269838))
        };
        function y(e) {
            return r.Interval.parse(e).value()
        }
        function b(e) {
            const t = r.Interval.parse(e);
            if (t.isRange())
                return a.linking.range.value();
            if (!N() && t.isTicks())
                return !1;
            const n = t.value()
              , i = a.linking.dataFrequencyResolution.value();
            if (void 0 !== i && A(n, i) < 0)
                return !1;
            const o = a.linking.supportedResolutions.value();
            return void 0 !== o ? void 0 !== o.find((e=>y(e) === n)) : t.isTicks() ? Boolean(a.linking.ticks.value()) : t.isIntraday() ? Boolean(a.linking.intraday.value()) : t.isDWM()
        }
        function w(e) {
            r.Interval.isValid(e) && (r.Interval.isRange(e) ? s.setValue("chart.lastUsedRangeResolution", e) : s.setValue("chart.lastUsedTimeBasedResolution", e))
        }
        function S(e) {
            return e ? "100R" : "1D"
        }
        function T(e, t, n) {
            const i = o.isRangeStyle(e)
              , a = r.Interval.isRange(t);
            return !i && a ? function(e) {
                const t = s.getValue("chart.lastUsedTimeBasedResolution");
                if (void 0 !== t && r.Interval.isTimeBased(t))
                    return t;
                let n = "1D";
                for (const t of e) {
                    const e = r.Interval.parse(t);
                    if (e.isTimeBased()) {
                        const t = e.value();
                        if ("1D" === t)
                            return t;
                        n = t
                    }
                }
                return n
            }(n) : i && !a ? function(e) {
                const t = s.getValue("chart.lastUsedRangeResolution");
                if (void 0 !== t && r.Interval.isRange(t))
                    return t;
                let n = "100R";
                for (const t of e) {
                    const e = r.Interval.parse(t);
                    if (e.isRange()) {
                        const t = e.value();
                        if ("100R" === t)
                            return t;
                        n = t
                    }
                }
                return n
            }(n) : t
        }
        function L(e, t) {
            return A(t, e) >= 0 ? t : e
        }
        function P(e) {
            return r.Interval.isRange(e) ? "1" : e
        }
        function E(e) {
            const {interval: t, guiResolutionKind: n} = r.Interval.parseExt(e);
            if (!t.isValid())
                return !1;
            const i = t.multiplier();
            if (n === r.ResolutionKind.Seconds)
                return p.includes(i);
            if (g && n === r.ResolutionKind.Ticks)
                return m.includes(i);
            return (n === r.SpecialResolutionKind.Hours ? i / 60 : i) <= I(n)
        }
        function I(e) {
            const t = _[e];
            return Number.isNaN(t) ? 1 : t
        }
        function R(e) {
            return I(r.Interval.parseExt(e).guiResolutionKind)
        }
        function C(e) {
            return Array.isArray(e) ? e : Object.keys(e).map(r.Interval.normalize).filter(c.notNull)
        }
        function x(...e) {
            let t = [].concat(...e);
            return t = (0,
            l.uniq)(t.filter(E).map(y)),
            k(t)
        }
        function k(e) {
            return e.sort(A)
        }
        function F(e) {
            const t = r.Interval.parse(e)
              , n = t.multiplier() || 1;
            return t.isMinuteHours() ? [r.SpecialResolutionKind.Hours, n / 60] : [t.kind(), n]
        }
        function A(e, t) {
            if (e === t)
                return 0;
            const [n,i] = F(e)
              , [r,o] = F(t);
            return n !== r ? f[n] - f[r] : i - o
        }
        function D(e) {
            const {multiplier: t, shortKind: n} = V(e);
            return `${t}${n}`
        }
        function V(e, t) {
            const n = r.Interval.parse(e);
            let i = n.multiplier()
              , o = n.kind();
            if (!n.isValid()) {
                if (t)
                    return null;
                throw new TypeError("Can't translate invalid interval")
            }
            return n.isMinuteHours() && (i = Math.floor(i / 60),
            o = r.SpecialResolutionKind.Hours),
            {
                multiplier: i.toString(),
                shortKind: M(o),
                hint: `${i} ${M(o, i)}`,
                mayOmitMultiplier: n.isDWM() && 1 === i,
                mayOmitShortKind: n.isMinutes() && !n.isMinuteHours()
            }
        }
        function M(e, t) {
            if (!t)
                return v[e];
            switch (e) {
            case r.ResolutionKind.Ticks:
                return i.t(null, {
                    plural: "ticks",
                    count: t
                }, n(699136));
            case r.ResolutionKind.Days:
                return i.t(null, {
                    plural: "days",
                    count: t
                }, n(730572));
            case r.ResolutionKind.Weeks:
                return i.t(null, {
                    plural: "weeks",
                    count: t
                }, n(947966));
            case r.ResolutionKind.Months:
                return i.t(null, {
                    plural: "months",
                    count: t
                }, n(99062));
            case r.ResolutionKind.Seconds:
                return i.t(null, {
                    plural: "seconds",
                    count: t
                }, n(671787));
            case r.ResolutionKind.Minutes:
                return i.t(null, {
                    plural: "minutes",
                    count: t
                }, n(569143));
            case r.SpecialResolutionKind.Hours:
                return i.t(null, {
                    plural: "hours",
                    count: t
                }, n(52254));
            case r.ResolutionKind.Range:
                return i.t(null, {
                    plural: "ranges",
                    count: t
                }, n(682797));
            default:
                return e
            }
        }
        function O() {
            return !0
        }
        function N() {
            return g
        }
        function W(e) {
            const t = r.Interval.parse(e);
            return !(!N() && t.isTicks())
        }
        function B(e) {
            let t;
            t = g ? /^[,\s]*(^[1-9][0-9]*)?\s*([hdwmsrt]?)\s*$/i : /^[,\s]*(^[1-9][0-9]*)?\s*([hdwmsr]?)\s*$/i;
            const n = t.exec(e) || []
              , i = ~~n[1]
              , r = n[2] && n[2].toUpperCase() || null
              , o = {
                qty: !i && r ? 1 : i,
                unit: r
            };
            return o.error = !i && !r,
            o.intraday = !(o.error || o.unit && "H" !== o.unit && "S" !== o.unit && "T" !== o.unit),
            o.ticks = "T" === o.unit,
            o.range = "R" === o.unit,
            o
        }
        function U(e) {
            if (h.enabled("allow_supported_resolutions_set_only")) {
                const t = r.Interval.normalize(e);
                return null !== t && b(t)
            }
            {
                const t = B(e);
                if (t.error)
                    return !1;
                if (!h.enabled("custom_resolutions")) {
                    const t = r.Interval.normalize(e)
                      , n = window.ChartApiInstance.defaultResolutions().filter(W);
                    if (!t || -1 === n.indexOf(t))
                        return !1
                }
                const n = a.linking.dataFrequencyResolution.value();
                if (void 0 !== n && null !== t.unit && L(n, t.unit) !== t.unit)
                    return !1;
                if (t.range)
                    return a.linking.range.value();
                if (t.ticks)
                    return a.linking.ticks.value();
                if (t.intraday)
                    return a.linking.intraday.value();
                {
                    const e = a.linking.supportedResolutions.value();
                    return !e || null !== t.unit && !!~e.indexOf(t.unit)
                }
            }
        }
    }
    ,
    444331: (e,t,n)=>{
        n.r(t),
        n.d(t, {
            actualSymbol: ()=>fe,
            chartStyleStudyId: ()=>z,
            createSeriesFormatter: ()=>G,
            displayedSymbolExchange: ()=>_e,
            displayedSymbolName: ()=>ge,
            extractLineToolSymbolFromSymbolInfo: ()=>de,
            extractSymbolNameFromSymbolInfo: ()=>ue,
            getChartStyleByResolution: ()=>U,
            getDefaultStyle: ()=>B,
            getLastUsedRawDataStyle: ()=>W,
            getLastUsedSingleValueBasedStyle: ()=>N,
            getLastUsedStyle: ()=>O,
            getSeriesDisplayErrorWV: ()=>Re,
            getSeriesPriceFormattingState: ()=>q,
            getSourceForEconomySymbol: ()=>pe,
            getSymbolExchange: ()=>Pe,
            getTranslatedChartStyleName: ()=>E,
            hasProjection: ()=>j,
            hasVolume: ()=>Te,
            isCloseBasedSymbol: ()=>be,
            isConvertedToOtherCurrency: ()=>Q,
            isConvertedToOtherUnit: ()=>ie,
            isEconomicSymbol: ()=>Le,
            isFutureContinuousSymbolWithBackajustment: ()=>Ee,
            isFuturesContractSymbol: ()=>Ie,
            isMeasureUnitSymbol: ()=>we,
            isPriceSourceStyle: ()=>K,
            isRangeBasedStyle: ()=>R,
            isRangeStyle: ()=>x,
            isRawDataStyle: ()=>D,
            isRegularSessionId: ()=>ye,
            isRequiringRestartSeriesStyles: ()=>I,
            isSingleValueBasedStyle: ()=>A,
            isTimeBasedStyle: ()=>k,
            isValidStyle: ()=>F,
            measureUnitId: ()=>Se,
            preparePriceAxisProperties: ()=>$,
            proSymbol: ()=>ve,
            setLastUsedRawDataStyle: ()=>M,
            setLastUsedStyle: ()=>V,
            styleChangeRequiresRestart: ()=>C,
            symbolBaseCurrency: ()=>Z,
            symbolCurrency: ()=>X,
            symbolCurrencyConvertible: ()=>J,
            symbolCurrentContract: ()=>oe,
            symbolHasEconomicEvents: ()=>le,
            symbolHasPreOrPostMarket: ()=>se,
            symbolHasSeveralSessions: ()=>ae,
            symbolOriginalCurrency: ()=>Y,
            symbolOriginalUnit: ()=>ne,
            symbolTitle: ()=>me,
            symbolTitleSeparator: ()=>he,
            symbolToSaveInState: ()=>ce,
            symbolUnit: ()=>te,
            symbolUnitConvertible: ()=>ee,
            symbolUnitConvertibleGroupsIfExist: ()=>re
        });
        var i = n(444372)
          , r = n(62802)
          , o = n(638456)
          , s = n(519073)
          , a = n(339315)
          , l = n(223699)
          , u = n(624444)
          , d = n(244842)
          , c = n(943994)
          , h = n(541346)
          , p = n(181728)
          , m = n(66732)
          , g = n(824837)
          , _ = n(529426);
        const f = d.enabled("pay_attention_to_ticker_not_symbol")
          , v = d.enabled("uppercase_instrument_names")
          , y = d.enabled("charting_library_single_symbol_request")
          , b = d.enabled("use_ticker_on_symbol_info_update")
          , w = d.enabled("hide_object_tree_and_price_scale_exchange_label")
          , S = [4, 5, 6, 7, 8]
          , T = [4, 5, 6, 7, 11]
          , L = [0, 1, 9, 2, 14, 15, 3, 16, 10, 8, 12, 13, 18]
          , P = [2, 14, 15, 10, 3, 13, 18];
        function E(e) {
            return {
                0: i.t(null, void 0, n(16812)),
                1: i.t(null, void 0, n(463528)),
                2: i.t(null, void 0, n(301277)),
                14: i.t(null, void 0, n(938397)),
                15: i.t(null, void 0, n(79511)),
                3: i.t(null, void 0, n(542097)),
                16: i.t(null, void 0, n(134911)),
                9: i.t(null, void 0, n(661582)),
                10: i.t(null, void 0, n(117712)),
                12: i.t(null, void 0, n(631994)),
                13: i.t(null, void 0, n(636018)),
                4: i.t(null, void 0, n(20801)),
                7: i.t(null, void 0, n(563492)),
                5: i.t(null, void 0, n(292901)),
                6: i.t(null, void 0, n(99969)),
                11: i.t(null, void 0, n(490357)),
                8: i.t(null, void 0, n(240530)),
                17: i.t(null, void 0, n(178560)),
                18: i.t(null, void 0, n(132975)),
                19: i.t(null, void 0, n(712894))
            }[e]
        }
        function I(e) {
            return -1 !== S.indexOf(e)
        }
        function R(e) {
            return -1 !== T.indexOf(e)
        }
        function C(e, t) {
            return !x(e) && !x(t) && !(e === t || !I(e) && !I(t))
        }
        function x(e) {
            return 11 === e
        }
        function k(e) {
            return -1 !== L.indexOf(e)
        }
        function F(e) {
            return R(e) || k(e)
        }
        function A(e) {
            switch (e) {
            case 3:
            case 10:
            case 2:
            case 14:
            case 15:
            case 13:
            case 18:
                return !0;
            default:
                return !1
            }
        }
        function D(e) {
            return !a.SYMBOL_STRING_DATA[e]
        }
        function V(e, t) {
            F(e) && (11 !== e && r.setValue("chart.lastUsedStyle", e),
            D(e) && M(e),
            be(t) && A(e) && r.setValue("chart.lastUsedSingleValueBasedStyle", e))
        }
        function M(e) {
            r.setValue("chart.rawDataStyle", e)
        }
        function O() {
            const e = r.getInt("chart.lastUsedStyle");
            return void 0 === e ? 1 : e
        }
        function N() {
            const e = r.getInt("chart.lastUsedSingleValueBasedStyle");
            return void 0 === e ? 14 : e
        }
        function W() {
            return r.getInt("chart.rawDataStyle", 1)
        }
        function B(e) {
            return e ? 11 : 1
        }
        function U(e, t) {
            const n = x(t)
              , i = l.Interval.isRange(e);
            return !n && i ? B(!0) : n && !i ? B(!1) : t
        }
        function z(e, t) {
            const n = a.SYMBOL_STRING_DATA[e];
            return void 0 === n ? null : t ? `${n.type}-${n.basicStudyVersion}` : n.type
        }
        function $(e) {
            const t = e.priceAxisProperties
              , n = t.lockScale.value()
              , i = 6 === e.style.value();
            (i || n) && (t.log.setValue(!1),
            t.percentage.setValue(!1)),
            t.logDisabled.setValue(!(!i && !n)),
            t.percentageDisabled.setValue(!(!i && !n))
        }
        const H = [4, 7, 5, 6];
        function j(e) {
            return -1 !== H.indexOf(e)
        }
        function K(e) {
            return P.includes(e)
        }
        function q(e, t="default", n=!1) {
            let i, r, o, s = 100, a = 1;
            if ("default" === t)
                null != e && (({pricescale: s, minmov: a, minmove2: r, fractional: i} = e),
                o = e.variable_tick_size || void 0);
            else {
                let e = t.split(",");
                3 !== e.length && (e = ["100", "1", "false"]),
                s = parseInt(e[0]),
                a = parseInt(e[1]),
                i = "true" === e[2]
            }
            return n && (a = 1),
            {
                priceScale: s,
                minMove: a,
                fractional: i,
                minMove2: r,
                variableMinTick: o,
                ignoreMinMove: n
            }
        }
        function G(e, t, n=!1) {
            if ("default" === t && null != e) {
                const t = e.formatter || e.format;
                if ("volume" === t)
                    return new c.VolumeFormatter(2);
                if ("percent" === t)
                    return new h.PercentageFormatter(e.pricescale)
            }
            const {priceScale: i, minMove: r, fractional: o, minMove2: s, variableMinTick: a} = q(e, t, n);
            return new u.PriceFormatter(i,r,o,s,a,n)
        }
        function J(e) {
            return null !== e && "spread" !== e.type
        }
        function X(e, t, n) {
            if (null === e)
                return null;
            const i = !t || n ? e.currency_id : e.currency_code;
            return void 0 === i || "" === i || "pct" === i ? null : i
        }
        function Y(e, t) {
            const n = t ? e.original_currency_code : e.original_currency_id;
            return "pct" === n ? null : null != n ? n : X(e, t)
        }
        function Z(e) {
            return e.base_currency_id || null
        }
        function Q(e) {
            if (null === e || !J(e))
                return !1;
            const t = Y(e);
            return null !== t && t !== X(e)
        }
        function ee(e, t) {
            return t && null !== e && "spread" !== e.type
        }
        function te(e, t) {
            if (null === e || !t)
                return null;
            const n = e.unit_id;
            return void 0 === n || "" === n ? null : n
        }
        function ne(e, t) {
            return t ? e.original_unit_id || te(e, t) : null
        }
        function ie(e, t) {
            return !(null === e || !ee(e, t)) && (void 0 !== e.original_unit_id && e.original_unit_id !== e.unit_id)
        }
        function re(e, t) {
            return null !== e && ee(e, t) ? e.unit_conversion_types || null : []
        }
        function oe(e) {
            return "futures" === e.type && e.front_contract || null
        }
        function se(e) {
            return null !== e && void 0 !== e.subsessions && e.subsessions.some((e=>"premarket" === e.id || "postmarket" === e.id))
        }
        function ae(e) {
            return null !== e && void 0 !== e.subsessions && e.subsessions.filter((e=>!e.private)).length > 1
        }
        function le(e) {
            return null !== e && ("forex" === e.type || (0,
            p.isCFDSymbol)(e.type, e.typespecs) || (0,
            s.hasCryptoTypespec)(e.typespecs || []))
        }
        function ue(e, t, n, i) {
            let r = e && (n && e.pro_name || e.full_name || e.name);
            return y && t ? r = t : (b || !i && f) && e && e.ticker && (r = e.ticker),
            v && r && (r = r.toUpperCase()),
            r
        }
        function de(e, t) {
            return ue(e, null, !0, !0) || t
        }
        function ce(e, t) {
            var n, i;
            return e && null !== (i = null !== (n = e.ticker) && void 0 !== n ? n : e.pro_name) && void 0 !== i ? i : t
        }
        const he = "·";
        function pe(e, t) {
            var n, i;
            return Le(e) && null !== (i = null === (n = e.source2) || void 0 === n ? void 0 : n.description) && void 0 !== i ? i : null
        }
        function me(e, t, n="exchange") {
            var i;
            const r = null !== (i = pe(e)) && void 0 !== i ? i : e[n];
            return t || w ? e.name : `${e.name} ${he} ${r}`
        }
        function ge(e) {
            let t = e && (oe(e) || e.name) || "";
            return t.length > 40 && (t = t.substring(0, 37) + "..."),
            t.trim()
        }
        function _e(e) {
            const t = e ? e.exchange : "";
            return v ? t.toUpperCase() : t
        }
        function fe(e, t) {
            return null !== e ? e.full_name : t
        }
        function ve(e, t) {
            var n;
            return null !== (n = null == e ? void 0 : e.pro_name) && void 0 !== n ? n : t
        }
        function ye(e) {
            return "regular" === e || "us_regular" === e
        }
        function be(e) {
            return "c" === (null == e ? void 0 : e.visible_plots_set)
        }
        function we(e) {
            return null !== e && ("unit" === e.measure && null !== Se(e))
        }
        function Se(e) {
            var t;
            return null !== (t = null == e ? void 0 : e.value_unit_id) && void 0 !== t ? t : null
        }
        function Te(e) {
            return void 0 !== e.visible_plots_set && "ohlcv" === e.visible_plots_set
        }
        function Le(e) {
            return null !== e && "economic" === e.type
        }
        function Pe(e) {
            const t = pe(e);
            if (null !== t)
                return t;
            return (0,
            o.onWidget)() || "forex" === e.type ? e.exchange : (0,
            _.redefineExchangeName)(e.listed_exchange)
        }
        function Ee(e) {
            var t;
            return null !== e && "futures" === e.type && Boolean(e.has_backadjustment && (null === (t = e.typespecs) || void 0 === t ? void 0 : t.includes("continuous")))
        }
        function Ie(e) {
            var t;
            return null !== e && "futures" === e.type && !Boolean(null === (t = e.typespecs) || void 0 === t ? void 0 : t.includes("continuous"))
        }
        function Re(e) {
            return (0,
            m.combine)(((t,n)=>{
                switch (t) {
                case 4:
                    {
                        const t = e.seriesErrorMessage();
                        return null !== t && ("resolution_not_entitled" === t || "custom_resolution" === t || "seconds_not_entitled" === t || "ticks_not_entitled" === t || t.startsWith("study_not_auth:")) ? null : "invalid_symbol"
                    }
                case 1:
                case 2:
                    return null;
                default:
                    if (n)
                        return "no_data"
                }
                return null
            }
            ), e.statusVW().weakReference(), (0,
            g.createWVFromGetterAndSubscription)((()=>!e.bars().size() && !e.isInReplay()), e.dataEvents().dataUpdated()).ownership(), (0,
            g.createWVFromGetterAndSubscription)((()=>({})), e.model().onChartThemeLoaded()).ownership())
        }
    }
    ,
    440617: (e,t,n)=>{
        TradingView.TIME_PLOT = 0,
        TradingView.OPEN_PLOT = 1,
        TradingView.HIGH_PLOT = 2,
        TradingView.LOW_PLOT = 3,
        TradingView.CLOSE_PLOT = 4,
        TradingView.ADT_PLOT = 6;
        var i = n(116667).SeriesBase
          , r = n(339315);
        class o extends i {
        }
        Object.assign(o, r),
        TradingView.Series = o,
        t.Series = o,
        t.isSeries = function(e) {
            return e instanceof o
        }
    }
    ,
    29469: (e,t,n)=>{
        n.d(t, {
            generateSplitTitleForGui: ()=>a,
            generateTitleForGui: ()=>l
        });
        var i = n(650151)
          , r = n(444372)
          , o = n(168883);
        function s(e, t) {
            return (Math.round(e * Math.pow(10, t)) / Math.pow(10, t)).toString() || ""
        }
        function a(e) {
            const t = "QUANDL" === (e = e || {}).exchange
              , a = {
                title: "",
                description: "",
                interval: "",
                exchange: "",
                provider: "",
                chartStyle: "",
                sessionDescription: "",
                priceSource: ""
            };
            let l = "";
            if (e.description && t)
                if (2 === e.description.split("/").length)
                    l = e.description.split("/")[1];
                else {
                    e.description.split("'").filter((e=>e.length)).forEach((e=>{
                        let t = [];
                        t = e && ("/" === e[0] || /\d+\/\(?/.test(e)) ? [e] : e.split("/").filter((e=>e.length)),
                        l += t[2 === t.length ? 1 : 0]
                    }
                    ))
                }
            else
                l = e.description ? e.description : e.symbol;
            if (e.ticker ? (a.title = e.ticker,
            a.description = u(l)) : a.title = u(l),
            e.interval && (a.interval = (0,
            o.translatedIntervalString)(e.interval)),
            t && e.description) {
                const t = /[\w_]+\/[\w_]+/.exec(e.description);
                t && t[0] ? a.provider = u(t[0].split("/")[0]) : a.provider = u(e.description.split("/")[0])
            }
            return e.exchange && (a.exchange = u(e.exchange)),
            a.chartStyle = u(function(e) {
                const t = e.inputs;
                switch (e.style) {
                case 4:
                    const o = t.style + ("ATR" === t.style ? `(${t.atrLength})` : "")
                      , a = (0,
                    i.ensureDefined)(e.boxSize || t.boxSize);
                    return `${r.t(null, void 0, n(20801))} [${o}, ${s(a, 4)}]`;
                case 7:
                    return `${r.t(null, void 0, n(717558))} [${t.lb}]`;
                case 5:
                    const l = t.style + ("ATR" === t.style ? `(${t.atrLength})` : "")
                      , u = e.reversalAmount || t.reversalAmount
                      , d = void 0 !== u ? `, ${s(u, 8)}` : "";
                    return `${r.t(null, void 0, n(292901))} [${l}${d}]`;
                case 6:
                    const c = `${t.style}${"ATR" === t.style ? "(" + t.atrLength + ")" : ""}`
                      , h = e.boxSize || t.boxSize;
                    return `${r.t(null, void 0, n(145113))} [${c}, ${s((0,
                    i.ensureDefined)(h), 8)}, ${t.reversalAmount}]`;
                case 18:
                    return `${r.t(null, void 0, n(494690))} [${t.periodsNum}, ${t.period}, ${t.blockSize}, ${t.ticksPerRow}]`
                }
                return 11 === e.style ? r.t(null, void 0, n(490357)) : 8 === e.style ? r.t(null, void 0, n(240530)) : ""
            }(e)),
            e.sessionDescription && (a.sessionDescription = u(e.sessionDescription)),
            void 0 !== e.priceSource && (a.priceSource = u(e.priceSource)),
            a
        }
        function l(e) {
            const t = a(e);
            return (e.ticker ? t.description : t.title) + (t.interval ? ", " + t.interval : "") + function(e, t=", ") {
                return (e.provider ? `${t}${e.provider}` : "") + (e.exchange ? `${t}${e.exchange}` : "") + (e.chartStyle ? `${t}${e.chartStyle}` : "") + (e.branding ? `${t}${e.branding}` : "") + (e.sessionDescription ? `${t}${e.sessionDescription}` : "") + (e.priceSource ? `${t}${e.priceSource}` : "")
            }(t)
        }
        function u(e) {
            return e.replace(/'/g, "")
        }
    }
    ,
    379048: (e,t,n)=>{
        var i, r, o, s;
        n.r(t),
        n.d(t, {
            HAlign: ()=>r,
            LineStyle: ()=>s,
            MarkLocation: ()=>i,
            VAlign: ()=>o
        }),
        function(e) {
            e.AboveBar = "AboveBar",
            e.BelowBar = "BelowBar",
            e.Top = "Top",
            e.Bottom = "Bottom",
            e.Right = "Right",
            e.Left = "Left",
            e.Absolute = "Absolute",
            e.AbsoluteUp = "AbsoluteUp",
            e.AbsoluteDown = "AbsoluteDown"
        }(i || (i = {})),
        function(e) {
            e.Left = "left",
            e.Center = "center",
            e.Right = "right"
        }(r || (r = {})),
        function(e) {
            e.Top = "top",
            e.Middle = "middle",
            e.Bottom = "bottom"
        }(o || (o = {})),
        function(e) {
            e[e.Solid = 0] = "Solid",
            e[e.Dotted = 1] = "Dotted",
            e[e.Dashed = 2] = "Dashed"
        }(s || (s = {}))
    }
    ,
    405721: (e,t,n)=>{
        n.r(t),
        n.d(t, {
            StudyDataSource: ()=>p
        });
        var i = n(650151)
          , r = n(707957)
          , o = n(195447)
          , s = n(459685)
          , a = n(173220)
          , l = n(989709)
          , u = n(700534)
          , d = n(799567);
        const c = (0,
        n(201089).getLogger)("Chart.StudyDataSource");
        var h;
        !function(e) {
            e[e.Idle = 0] = "Idle",
            e[e.AwaitingConnection = 1] = "AwaitingConnection",
            e[e.AwaitingParent = 2] = "AwaitingParent",
            e[e.AwaitingFirstDataUpdate = 3] = "AwaitingFirstDataUpdate",
            e[e.Active = 4] = "Active"
        }(h || (h = {}));
        class p {
            constructor(e, t, n, i) {
                this._inputs = null,
                this._status = h.Idle,
                this._studyId = null,
                this._turnaroundCounter = 1,
                this._studyStatus = {
                    type: d.StudyStatusType.Undefined
                },
                this._studyStatusChanged = new r.Delegate,
                this._dataCleared = new r.Delegate,
                this._dataUpdated = new r.Delegate,
                this._boundOnGatewayIsConnectedChanged = this._onGatewayIsConnectedChanged.bind(this),
                this._ongoingDataUpdate = Promise.resolve(),
                this._gateway = e,
                this._metaInfo = i,
                this._seriesSource = t,
                this._turnaroundPrefix = n,
                this._plots = new o.PlotList((0,
                l.studyPlotFunctionMap)(i),l.studyEmptyPlotValuePredicate),
                this._gateway.isConnected().subscribe(this._boundOnGatewayIsConnectedChanged),
                this._graphics = new u.LiveStudyGraphics(i.graphics)
            }
            destroy() {
                this.stop(),
                this._gateway.isConnected().unsubscribe(this._boundOnGatewayIsConnectedChanged),
                this._seriesSource.dataEvents().created().unsubscribeAll(this)
            }
            metaInfo() {
                return this._metaInfo
            }
            inputs() {
                return this._inputs
            }
            setInputs(e) {
                this._inputs = e,
                null !== this._studyId && (this._turnaroundCounter++,
                this._onStudyStatusChangedTo({
                    type: d.StudyStatusType.Undefined
                }),
                this._gateway.modifyStudy(this._studyId, this._turnaround(), e, this._onMessage.bind(this)),
                this._status === h.Active && this._changeStatusTo(h.AwaitingFirstDataUpdate))
            }
            isStarted() {
                return this._status !== h.Idle
            }
            isActive() {
                return this._status === h.Active
            }
            start() {
                this.isStarted() ? c.logNormal("start: data source is already started, nothing to do") : ((0,
                i.assert)(null !== this._inputs, "Inputs should be defined when starting a study data source"),
                this._gateway.isConnected().value() ? this._createStudy() : this._changeStatusTo(h.AwaitingConnection))
            }
            stop() {
                this.isStarted() ? (null !== this._studyId && (this._gateway.removeStudy(this._studyId),
                this._studyId = null,
                this._onStudyStatusChangedTo({
                    type: d.StudyStatusType.Undefined
                })),
                this._changeStatusTo(h.Idle)) : c.logNormal("stop: data source is already stopped, nothing to do")
            }
            studyId() {
                return this._studyId
            }
            studyStatus() {
                return this._studyStatus
            }
            studyStatusChanged() {
                return this._studyStatusChanged
            }
            plots() {
                return this._plots
            }
            graphics() {
                return this._graphics
            }
            clearData() {
                this._plots.clear(),
                this._graphics.clear(),
                this._dataCleared.fire()
            }
            stopAndStealData() {
                (0,
                i.assert)(this._status === h.Active, "Couldn't steal data from non-active data source"),
                this.stop();
                const e = this._plots
                  , t = this._graphics.extract();
                return this._plots = new o.PlotList((0,
                l.studyPlotFunctionMap)(this._metaInfo),l.studyEmptyPlotValuePredicate),
                {
                    plots: e,
                    graphics: t
                }
            }
            dataCleared() {
                return this._dataCleared
            }
            dataUpdated() {
                return this._dataUpdated
            }
            moveData(e) {
                this._ongoingDataUpdate = this._ongoingDataUpdate.then((()=>{
                    this._plots.move(e)
                }
                ))
            }
            pendingUpdatesReady() {
                return this._ongoingDataUpdate
            }
            _createStudyError(e) {
                return {
                    type: d.StudyStatusType.Error,
                    errorDescription: this._getStudyErrorDescription(e)
                }
            }
            _getStudyErrorDescription(e) {
                return "string" == typeof e ? {
                    error: e.split(":", 2)[0]
                } : e
            }
            _changeStatusTo(e) {
                (0,
                i.assert)(this._status !== e, "Source and destination status should be distinct"),
                c.logNormal(`Status changed from ${h[this._status]} to ${h[e]}`),
                this._status = e
            }
            _createStudy() {
                const e = this._seriesSource.instanceId();
                null !== e ? this._createStudyUsingParentId(e) : (this._changeStatusTo(h.AwaitingParent),
                this._seriesSource.dataEvents().created().subscribe(this, this._onSeriesCreated, !0))
            }
            _createStudyUsingParentId(e) {
                (0,
                i.assert)(this._status !== h.Active, 'Status should not be "Active" when creating a study'),
                (0,
                i.assert)(this._studyStatus.type === d.StudyStatusType.Undefined, 'Study status should be "Undefined" when creating a study'),
                (0,
                i.assert)(null === this._studyId, "Study id should be empty when creating a study"),
                this._studyId = (0,
                a.makeNextStudyId)(),
                this._gateway.createStudy(this._studyId, this._turnaround(), e, this._metaInfo.fullId + ("tv-basicstudies" === this._metaInfo.packageId ? "" : "!"), (0,
                i.ensureNotNull)(this._inputs), this._onMessage.bind(this), {
                    id: this._metaInfo.id
                }),
                this._changeStatusTo(h.AwaitingFirstDataUpdate)
            }
            _onGatewayIsConnectedChanged(e) {
                e ? this._onGatewayConnected() : this._onGatewayDisconnected()
            }
            _onGatewayConnected() {
                this._status === h.AwaitingConnection && this._createStudy()
            }
            _onGatewayDisconnected() {
                this._status !== h.Idle && this._status !== h.AwaitingConnection && (this._studyId = null,
                this._changeStatusTo(h.AwaitingConnection),
                this._studyStatus.type !== d.StudyStatusType.Undefined && this._onStudyStatusChangedTo({
                    type: d.StudyStatusType.Undefined
                })),
                this._turnaroundCounter = 1
            }
            _onSeriesCreated() {
                this._status === h.AwaitingParent && this._createStudyUsingParentId((0,
                i.ensure)(this._seriesSource.instanceId()))
            }
            _onStudyStatusChangedTo(e) {
                const t = this._studyStatus;
                this._studyStatus = e,
                c.logNormal(`Study status type changed from ${d.StudyStatusType[t.type]} to ${d.StudyStatusType[e.type]}`),
                this._studyStatusChanged.fire(t, e)
            }
            _onMessage(e) {
                if ("data_update" === e.method) {
                    const {customId: t, turnaround: n, plots: r, nonseries: o} = e.params;
                    t === this._studyId && this._checkTurnaround(n) && this._onDataUpdate(r, (0,
                    i.ensureDefined)(o))
                } else if ("study_loading" === e.method) {
                    const [t,n,i] = e.params;
                    t === this._studyId && this._checkTurnaround(n) && this._onStudyLoading(i)
                } else if ("study_completed" === e.method) {
                    const [t,n,i] = e.params;
                    t === this._studyId && this._checkTurnaround(n) && this._onStudyCompleted(i)
                } else if ("study_error" === e.method) {
                    const [t,n,i,r,o] = e.params;
                    t === this._studyId && this._checkTurnaround(n) && this._onStudyError(i, r, o)
                } else
                    "clear_data" === e.method && this._checkTurnaround(e.params.turnaround) && this.clearData()
            }
            _onDataUpdate(e, t) {
                const n = (0,
                s.unpackNonSeriesData)(t.d);
                return this._ongoingDataUpdate = this._ongoingDataUpdate.then((()=>n), (()=>n)).then(this._onDataUnpacked.bind(this, e, t.indexes)),
                this._ongoingDataUpdate
            }
            _onDataUnpacked(e, t, n) {
                this._status !== h.Idle && (this._status === h.AwaitingFirstDataUpdate && (this._changeStatusTo(h.Active),
                this.clearData()),
                this._mergePlots(e),
                null !== n && (n.indexes_replace ? ((0,
                i.assert)("nochange" !== t),
                this._graphics.replaceIndexesTo(t)) : ("nochange" !== t && this._graphics.replaceIndexesTo(t),
                void 0 !== n.graphicsCmds && this._graphics.processCommands(n.graphicsCmds))),
                this._dataUpdated.fire(e, n, t))
            }
            _onStudyLoading(e) {
                this._onStudyStatusChangedTo({
                    type: d.StudyStatusType.Loading,
                    startTime: Date.now()
                })
            }
            _onStudyError(e, t, n) {
                this.clearData(),
                this._onStudyStatusChangedTo(this._createStudyError(e))
            }
            _onStudyCompleted(e) {
                this._onStudyStatusChangedTo({
                    type: d.StudyStatusType.Completed
                })
            }
            _mergePlots(e) {
                this._plots.merge(e)
            }
            _turnaround() {
                return `${this._turnaroundPrefix}${this._turnaroundCounter}`
            }
            _checkTurnaround(e) {
                const t = this._turnaround();
                return e === t || e === this._seriesSource.turnaround() || e === `${this._seriesSource.turnaround()}_${t}`
            }
        }
    }
    ,
    626240: (e,t,n)=>{
        var i = n(854798).Version
          , r = n(201089).getLogger("Chart.StudyMigration");
        function o(e) {
            this._studyId = e,
            this._maxToVers = i.ZERO,
            this._maxFromVers = i.ZERO,
            this._migrs = []
        }
        o.prototype.addMigration = function(e, t, n) {
            var r = i.parse(e)
              , o = i.parse(t);
            r.isGreater(this._maxFromVers) && (this._maxFromVers = r),
            o.isGreater(this._maxToVers) && (this._maxToVers = o),
            this._migrs.push({
                fromVers: r,
                toVers: o,
                rules: n
            })
        }
        ,
        o.prototype.updateInputs = function(e, t, n) {
            if (!n)
                return n;
            for (var i = TradingView.clone(n), o = e; o.isLess(t); ) {
                var s = this._findMigration(o);
                if (null == s)
                    break;
                if (r.logNormal("Migrating study inputs from " + s.fromVers + " to " + s.toVers + " version, studyId: " + this._studyId + ", migration: " + JSON.stringify(s) + ", inputs: " + JSON.stringify(n)),
                i = this._applyMigration(i, s),
                !o.isLess(s.toVers))
                    throw new Error("Problems in study migration process... Possible infinite cycle has been detected and stopped.");
                o = s.toVers
            }
            return o > e && r.logNormal("Study inputs migration is done, studyId: " + this._studyId + ", inputs: " + JSON.stringify(i)),
            i
        }
        ,
        o.prototype._findMigration = function(e) {
            for (var t = -1, n = this._maxFromVers, i = 0; i < this._migrs.length; i++) {
                var r = this._migrs[i];
                r.fromVers.isLess(e) || r.fromVers.isLessOrEqual(n) && (n = r.fromVers,
                t = i)
            }
            return t < 0 ? null : this._migrs[t]
        }
        ,
        o.prototype._applyMigration = function(e, t) {
            for (var n = e, i = 0; i < t.rules.length; i++) {
                var r = t.rules[i];
                n = this._getApplyRuleFun(r.type)(n, r)
            }
            return n
        }
        ,
        o.prototype._getApplyRuleFun = function(e) {
            if ("inputRemoved" === e)
                return o._applyInputRemovedRule;
            if ("inputChangedType" === e)
                return o._applyInputChangedTypeRule;
            if ("inputChangedMinMax" === e)
                return o._applyInputChangedMinMaxRule;
            if ("inputChangedOptions" === e)
                return o._applyInputChangedOptionsRule;
            throw new Error("Unknown migration rule type: " + e)
        }
        ,
        o._applyInputRemovedRule = function(e, t) {
            if (!(t.inputId in e))
                return e;
            if ("removeVal" !== t.action)
                throw new Error("Unexpected rule.action=" + t.action + " in rule.type=" + t.type);
            var n = e[t.inputId];
            return delete e[t.inputId],
            r.logNormal("Input " + t.inputId + "=" + n + " removed"),
            e
        }
        ,
        o._applyInputChangedTypeRule = function(e, t) {
            var n = e[t.inputId];
            if ("resetToDefVal" === t.action)
                return e[t.inputId] = t.defVal,
                r.logNormal("Input " + t.inputId + "=" + n + " reset to default value " + t.defVal),
                e;
            if ("convertVal" === t.action) {
                if (null == n)
                    return e;
                if ("float" === t.inputTypeFrom && "integer" === t.inputType)
                    return e[t.inputId] = Math.round(e[t.inputId]),
                    r.logNormal("Input " + t.inputId + "=" + n + " converted to value " + e[t.inputId]),
                    e;
                if ("integer" === t.inputTypeFrom && "float" === t.inputType)
                    return e;
                if ("text" === t.inputTypeFrom && "source" === t.inputType)
                    return o._isValidSource(n, t.options) || (e[t.inputId] = t.defVal),
                    e;
                throw new Error("Cannot convertVal from " + t.inputTypeFrom + " to " + t.inputType)
            }
            throw new Error("Unknown action " + t.action + " for rule with type " + t.type)
        }
        ,
        o._isValidSource = function(e, t) {
            return e.indexOf("$") >= 0 || t.indexOf(e) >= 0
        }
        ,
        o._applyInputChangedMinMaxRule = function(e, t) {
            if ("adjustValIfNeeded" !== t.action)
                throw new Error("Unknown action " + t.action + " for rule with type " + t.type);
            var n = e[t.inputId];
            return n < t.minVal ? e[t.inputId] = t.minVal : n > t.maxVal && (e[t.inputId] = t.maxVal),
            r.logNormal("Input " + t.inputId + "=" + n + " adjusted to value " + e[t.inputId]),
            e
        }
        ,
        o._applyInputChangedOptionsRule = function(e, t) {
            if (!(["text"].indexOf(t.inputType) >= 0 && "resetToDefValIfNeeded" === t.action))
                throw new Error("Unexpected rule.inputType=" + t.inputType + " in rule.action=" + t.action);
            var n = e[t.inputId];
            return t.options.indexOf(n) < 0 && (e[t.inputId] = t.defVal,
            r.logNormal("Input " + t.inputId + "=" + n + " reset to default value " + t.defVal)),
            e
        }
        ,
        e.exports = o
    }
    ,
    309858: (e,t,n)=>{
        window.TradingView = window.TradingView || {},
        n(922651),
        n(778785).setClasses(),
        n(30285),
        n(128327).install(),
        n(638456),
        n(389137),
        n(586463),
        n(730128),
        n(327034),
        n(934440),
        n(529366),
        n(125226),
        n(49437),
        n(461794),
        n(151874),
        n(62802)
    }
    ,
    377993: (e,t,n)=>{
        n(309858);
        var i = n(650151)
          , r = n(62802)
          , o = n.n(r)
          , s = n(244842);
        s.enabled("use_localstorage_for_settings") && o().sync(void 0);
        var a = n(444372)
          , l = n(42292)
          , u = n(325050)
          , d = n.n(u)
          , c = n(342395)
          , h = n(318172)
          , p = n(199639)
          , m = n(583912)
          , g = n(59171)
          , _ = n.n(g)
          , f = n(934440)
          , v = n.n(f)
          , y = n(876332)
          , b = n(444331)
          , w = n(223699)
          , S = n(731042);
        function T() {
            return Promise.all([n.e(987), n.e(45702)]).then(n.bind(n, 577602))
        }
        var L = n(401580);
        class P {
            constructor(e, t) {
                this._visibility = new L.WatchedValue(!1),
                this._dialogPromise = null,
                this._dialog = null,
                this._chartWidgetCollection = e,
                this._options = t
            }
            visible() {
                return this._visibility.readonly()
            }
            show(e, t, n) {
                var i, r, o;
                const s = Array.isArray(e) ? e : []
                  , a = Array.isArray(e) ? void 0 : e;
                null === this._dialog && this._requestDialog(null != s ? s : [], t, n, a),
                null === (i = this._dialog) || void 0 === i || i.open(null != s ? s : [], null === (o = null === (r = this._options) || void 0 === r ? void 0 : r.indicatorsPreloader) || void 0 === o ? void 0 : o.getIndicatorPromises(), t, n, a)
            }
            hide() {
                var e;
                null === (e = this._dialog) || void 0 === e || e.hide()
            }
            getDialog() {
                return this._dialog
            }
            resetAllPages() {
                var e;
                null === (e = this._dialog) || void 0 === e || e.resetAllStudies()
            }
            _requestDialog(e, t, i, r) {
                var o;
                if (null === this._dialogPromise) {
                    let s;
                    s = (null === (o = this._options) || void 0 === o ? void 0 : o.onWidget) ? Promise.all([n.e(57078), n.e(62253), n.e(22666), n.e(92108), n.e(5993), n.e(92191), n.e(32109), n.e(9817), n.e(4015), n.e(53842), n.e(38669), n.e(5145), n.e(35649), n.e(25190), n.e(88548), n.e(91033), n.e(90684), n.e(40866), n.e(6744), n.e(36842), n.e(36752), n.e(34186), n.e(35542), n.e(92175), n.e(24510), n.e(73353), n.e(63616), n.e(91244), n.e(50690), n.e(30979), n.e(19359), n.e(83784), n.e(6456)]).then(n.bind(n, 4748)).then((e=>new e.IndicatorsLibraryContainer(this._chartWidgetCollection,this._options))) : Promise.all([n.e(57078), n.e(62253), n.e(22666), n.e(92108), n.e(5993), n.e(92191), n.e(32109), n.e(9817), n.e(4015), n.e(53842), n.e(38669), n.e(5145), n.e(35649), n.e(25190), n.e(88548), n.e(91033), n.e(90684), n.e(40866), n.e(6744), n.e(36842), n.e(36752), n.e(34186), n.e(35542), n.e(92175), n.e(24510), n.e(73353), n.e(63616), n.e(91244), n.e(50690), n.e(30979), n.e(19359), n.e(83784), n.e(6456)]).then(n.bind(n, 518828)).then((e=>new e.IndicatorsContainer(this._chartWidgetCollection))),
                    this._dialogPromise = s.then((n=>{
                        var o, s;
                        this._dialog = n,
                        this._dialog.visible().subscribe((e=>{
                            this._visibility.setValue(e)
                        }
                        )),
                        this._dialog.open(e, null === (s = null === (o = this._options) || void 0 === o ? void 0 : o.indicatorsPreloader) || void 0 === s ? void 0 : s.getIndicatorPromises(), t, i, r)
                    }
                    ))
                }
                return this._dialogPromise
            }
        }
        var E = n(618820)
          , I = n(429874)
          , R = n(331633)
          , C = n(778785)
          , x = n(606311);
        const k = {
            8: [x.timeFrames.ytd, x.timeFrames["12m"], x.timeFrames["60m"], x.timeFrames.all],
            3: [x.timeFrames["1d"], x.timeFrames["5d"], x.timeFrames["1m"], x.timeFrames["3m"], x.timeFrames["6m"], x.timeFrames.ytd, x.timeFrames["12m"], x.timeFrames["60m"], x.timeFrames.all]
        };
        function F(e, t) {
            return 9 === t && (t = 3),
            6 === t && (t = 8),
            k[t] || []
        }
        function A(e, t, n) {
            const i = {
                name: e,
                frameElementId: t,
                data: n
            };
            window.parent.postMessage(i, "*")
        }
        function D(e, t) {
            function n(n) {
                n.data && n.data.name && n.data.name === e && t(n.data.data)
            }
            return window.addEventListener("message", n, !1),
            ()=>{
                window.removeEventListener("message", n, !1)
            }
        }
        var V, M;
        function O(e) {
            return "seekingalpha" === e || "smartlab-custom" === e ? Promise.all([n.e(78596), n.e(11165), n.e(13898), n.e(22666), n.e(5993), n.e(4015), n.e(53842), n.e(66639), n.e(30006), n.e(35649), n.e(46036), n.e(91033), n.e(58056), n.e(49205), n.e(67080), n.e(15518), n.e(98149), n.e(12494), n.e(36752), n.e(96025), n.e(45166), n.e(56949), n.e(10102), n.e(92175), n.e(59185), n.e(33939), n.e(10524), n.e(85685), n.e(64619), n.e(50690), n.e(32046), n.e(33950), n.e(2190), n.e(25192), n.e(61309)]).then(n.bind(n, 461309)) : "cme" === e ? Promise.all([n.e(78596), n.e(11165), n.e(13898), n.e(22666), n.e(5993), n.e(4015), n.e(53842), n.e(66639), n.e(30006), n.e(35649), n.e(46036), n.e(91033), n.e(58056), n.e(49205), n.e(67080), n.e(15518), n.e(98149), n.e(12494), n.e(36752), n.e(96025), n.e(45166), n.e(56949), n.e(10102), n.e(92175), n.e(59185), n.e(33939), n.e(10524), n.e(85685), n.e(50690), n.e(32046), n.e(33950), n.e(2190), n.e(25192), n.e(66660)]).then(n.bind(n, 666660)) : Promise.all([n.e(78596), n.e(11165), n.e(13898), n.e(22666), n.e(5993), n.e(4015), n.e(53842), n.e(66639), n.e(30006), n.e(35649), n.e(46036), n.e(91033), n.e(58056), n.e(49205), n.e(67080), n.e(15518), n.e(98149), n.e(12494), n.e(36752), n.e(96025), n.e(45166), n.e(56949), n.e(10102), n.e(92175), n.e(59185), n.e(33939), n.e(10524), n.e(85685), n.e(50690), n.e(32046), n.e(33950), n.e(2190), n.e(25192), n.e(99304)]).then(n.bind(n, 399304))
        }
        !function(e) {
            let t;
            !function(e) {
                e.SetSymbol = "set-symbol",
                e.SetInterval = "set-interval"
            }(t = e.Names || (e.Names = {}))
        }(V || (V = {})),
        function(e) {
            let t;
            !function(e) {
                e.SymbolClick = "tv-widget-symbol-click",
                e.WidgetLoad = "tv-widget-load",
                e.WidgetReady = "tv-widget-ready",
                e.ResizeIframe = "tv-widget-resize-iframe",
                e.NoData = "tv-widget-no-data"
            }(t = e.Names || (e.Names = {}))
        }(M || (M = {}));
        var N = n(885482)
          , W = n(616117)
          , B = n(638456)
          , U = n(470316);
        const z = ["LineToolTrendLine", "LineToolRay", "LineToolInfoLine", "LineToolExtended", "LineToolRegressionTrend", "LineToolRotatedRectangle", "LineToolParallelChannel", "LineToolFlatBottom", "LineToolDisjointAngle", "LineToolPitchfork", "LineToolSchiffPitchfork", "LineToolSchiffPitchfork2", "LineToolInsidePitchfork", "LineToolVertLine", "LineToolCrossLine", "LineToolHorzLine", "LineToolHorzRay", "LineToolTrendAngle"];
        function $(e, t=!1, o=!1) {
            if (!s.enabled("popup_hints"))
                return;
            const l = e.getContainer();
            let u = null
              , d = null
              , c = null;
            function h(e, t) {
                if (d)
                    d.show(e, m.bind(null, t));
                else {
                    const i = N.tool.value();
                    Promise.all([n.e(9817), n.e(93280), n.e(50690), n.e(26166)]).then(n.bind(n, 410837)).then((n=>{
                        d = new n.ChartEventHintRenderer(l),
                        i === N.tool.value() && d.show(e, m.bind(null, t))
                    }
                    ))
                }
            }
            function p(e) {
                return !Boolean(r.getBool(e))
            }
            function m(e) {
                r.setValue(e, !0, {
                    forceFlush: !0
                }),
                (0,
                i.ensureNotNull)(d).destroy(),
                null !== c && c(),
                d = null
            }
            N.tool.subscribe((function() {
                const t = N.tool.value()
                  , i = B.CheckMobile.any();
                if (null == u || u.hide(),
                o && i && function(e) {
                    return z.includes(e)
                }(t))
                    return void async function(t) {
                        {
                            const i = ()=>(0,
                            N.resetToCursor)(!0);
                            if (u)
                                u.show(t, i);
                            else {
                                const {DrawingHintsRenderer: r} = await Promise.all([n.e(88548), n.e(96567), n.e(50690), n.e(35858)]).then(n.bind(n, 953745));
                                u = new r(e),
                                t === N.tool.value() && u.show(t, i)
                            }
                        }
                    }(t);
                if (!p("hint.touchPainting"))
                    return;
                const r = (0,
                W.isLineToolDrawWithoutPoints)(t);
                !(0,
                W.isStudyLineToolName)(t) || "LineToolRegressionTrend" === t || r || i ? (0,
                W.isLineToolName)(t) && !(0,
                W.isLineDrawnWithPressedButton)(t) && !r && i ? h(a.t(null, void 0, n(967861)), "hint.touchPainting") : d && d.hide() : h(a.t(null, void 0, n(632234)), "hint.touchPainting")
            }
            )),
            N.createdLineTool.subscribe(null, (function() {
                const e = N.tool.value();
                "LineToolPath" === e && p("hint.finishBuildPathByDblClick") ? h(a.t(null, void 0, n(605828)), "hint.finishBuildPathByDblClick") : "LineToolPolyline" === e && p("hint.finishBuildPolylineByDblClick") && h(a.t(null, void 0, n(763898)), "hint.finishBuildPolylineByDblClick")
            }
            )),
            N.finishedLineTool.subscribe(null, (function() {
                if (d) {
                    const e = N.tool.value();
                    "LineToolPath" === e ? m("hint.finishBuildPathByDblClick") : "LineToolPolyline" === e && m("hint.finishBuildPolylineByDblClick")
                }
            }
            )),
            e.layoutSizesChanged().subscribe((function() {
                if (!p("hint.startResizingChartInLayout"))
                    return;
                h(a.t(null, void 0, n(135273)), "hint.startResizingChartInLayout")
            }
            )),
            t || B.CheckMobile.any() || !p("hint.startFocusedZoom") || (c = function(e, t) {
                let n = !1;
                const i = r=>{
                    r ? (n && t(r),
                    e.onZoom().unsubscribe(null, i)) : n || (t(r),
                    n = !0)
                }
                ;
                return e.onZoom().subscribe(null, i),
                ()=>e.onZoom().unsubscribe(null, i)
            }(e, (function(e) {
                if (!p("hint.startFocusedZoom"))
                    return;
                if (e)
                    d && (c = null,
                    m("hint.startFocusedZoom"));
                else {
                    const e = U.isMacKeyboard ? "⌘" : "Ctrl";
                    h(a.t(null, void 0, n(35963)).format({
                        key: e
                    }), "hint.startFocusedZoom")
                }
            }
            )))
        }
        var H = n(251954);
        function j(e, t) {
            const r = a.t(null, void 0, n(678104)).format({
                emoji: "👍"
            })
              , o = a.t(null, void 0, n(812011)).format({
                emoji: "👍"
            })
              , s = a.t(null, void 0, n(979393)).format({
                emoji: "👍"
            });
            H.on("onServerScreenshotCopiedToClipboard", (()=>d(r)), null),
            H.on("onClientScreenshotCopiedToClipboard", (()=>d(o)), null),
            H.on("onServerScreenshotEmbedCodeCopiedToClipboard", (()=>d(s)), null);
            let l = null;
            const u = e.getContainer();
            function d(e) {
                l ? l.show(e) : Promise.all([n.e(32109), n.e(6209), n.e(40719), n.e(50690), n.e(30092)]).then(n.bind(n, 798090)).then((n=>{
                    l || (l = new n.ChartScreenshotHintRenderer((0,
                    i.ensureNotNull)(u),{
                        bottomPadding: t.seriesControlBarEnabled
                    }),
                    l.show(e))
                }
                ))
            }
        }
        var K = n(261309)
          , q = n(564894);
        class G {
            constructor(e=[]) {
                this._list = {
                    id: "DEFAULT_SINGLE_WATCHLIST",
                    type: "custom",
                    name: a.t(null, void 0, n(213402)),
                    description: null,
                    symbols: [...e],
                    shared: !1
                }
            }
            getCustomWatchLists() {
                return Promise.resolve([this._list])
            }
            getSymbols(e) {
                return Promise.resolve(this._list.symbols)
            }
            createWatchList(e) {
                throw new Error("not implemented")
            }
            putWatchList(e) {
                throw new Error("not implemented")
            }
            removeWatchList(e) {
                throw new Error("not implemented")
            }
            renameWatchList(e, t) {
                return Promise.resolve(t)
            }
            replaceSymbols(e, t) {
                return this._list.symbols = [...t],
                Promise.resolve(this._list)
            }
            addSymbols(e, t) {
                return this._list.symbols.push(...t),
                Promise.resolve(this._list.symbols)
            }
            removeSymbols(e, t) {
                return this._list.symbols = this._list.symbols.filter((e=>!t.includes(e))),
                Promise.resolve(this._list.symbols)
            }
            setActive(e) {
                return Promise.resolve(this._list)
            }
            getActive() {
                return Promise.resolve(this._list)
            }
            changeDescription(e, t) {
                throw new Error("not implemented")
            }
            getCustomWatchlist(e) {
                throw new Error("not implemented")
            }
            renameSeparator(e, t, n) {
                return Promise.resolve()
            }
        }
        var J = n(541558)
          , X = n(707957);
        const Y = new X.Delegate
          , Z = new X.Delegate
          , Q = new X.Delegate
          , ee = new X.Delegate
          , te = new X.Delegate;
        class ne {
            constructor(e=[], t=r) {
                if (this._lists = {},
                this._activeListSettingsKey = "widgetbar.widget.watchlist",
                s.enabled("trading_terminal") && (this._activeListSettingsKey += "terminal"),
                this._settings = t,
                this._settings.onSync.subscribe(this, this._updateLists),
                this._updateLists(),
                0 === Object.keys(this._lists).length) {
                    const t = this._createList({
                        title: this._pickTitle(),
                        symbols: [...e]
                    });
                    this.setActive(t.id)
                }
            }
            destroy() {
                this._settings.onSync.unsubscribeAll(this)
            }
            getCustomWatchLists() {
                this._updateLists();
                const e = [];
                return Object.keys(this._lists).forEach((t=>{
                    const n = this._getList(t);
                    n && e.push(this._toSymbolList(n))
                }
                )),
                Promise.resolve(e)
            }
            createWatchList(e) {
                const t = this._createList({
                    id: e.id,
                    title: e.name || this._pickTitle(),
                    symbols: e.symbols || []
                });
                return Q.fire(t.id, [...t.symbols]),
                Promise.resolve(this._toSymbolList(t))
            }
            putWatchList(e) {
                this._updateLists();
                const t = this._getList(e.id)
                  , n = null == t ? void 0 : t.title
                  , i = e.name;
                return this.saveList({
                    id: e.id,
                    symbols: e.symbols,
                    title: e.name
                }),
                void 0 !== n && n !== i && te.fire(e.id, n, i),
                null !== t ? Y.fire(e.id) : Q.fire(e.id, e.symbols),
                Promise.resolve(e)
            }
            removeWatchList(e) {
                const {id: t} = e;
                return this._settings.remove(`savedwatch.${t}`, {
                    forceFlush: !0
                }),
                delete this._lists[t],
                ee.fire(t),
                Promise.resolve()
            }
            renameWatchList(e, t) {
                this._updateLists();
                const {name: n} = e;
                return e.name = t,
                this.saveList({
                    id: e.id,
                    symbols: e.symbols,
                    title: t
                }),
                te.fire(e.id, n, t),
                Promise.resolve(t)
            }
            replaceSymbols(e, t) {
                const n = this._getList(e.id);
                return null === n || (n.symbols = [...t],
                this.saveList(n),
                Y.fire(e.id)),
                Promise.resolve()
            }
            addSymbols(e, t) {
                const n = this._getList(e.id);
                return null === n ? Promise.resolve([]) : (n.symbols.push(...t),
                this.saveList(n),
                Y.fire(e.id),
                Promise.resolve([...n.symbols]))
            }
            removeSymbols(e, t) {
                const n = this._getList(e.id);
                return null === n ? Promise.resolve([]) : (n.symbols = n.symbols.filter((e=>!t.includes(e))),
                this.saveList(n),
                Y.fire(e.id),
                Promise.resolve([...n.symbols]))
            }
            setActive(e) {
                return this._settings.setValue(this._activeListSettingsKey, e),
                Z.fire(),
                Promise.resolve()
            }
            getActive() {
                const e = this._getActive();
                return Promise.resolve(this._toSymbolList(e))
            }
            changeDescription(e, t) {
                throw new Error("not implemented")
            }
            renameSeparator(e, t, n) {
                this._updateLists();
                const i = this._getList(e);
                if (null === i)
                    return Promise.resolve();
                const r = i.symbols.findIndex((e=>e === t));
                return i.symbols[r] = n,
                this.saveList(i),
                Y.fire(e),
                Promise.resolve()
            }
            saveList(e) {
                const t = {
                    symbols: e.symbols,
                    title: String(e.title)
                };
                this._settings.setJSON(`savedwatch.${e.id}`, t, {
                    forceFlush: !0
                }),
                this._lists[e.id] = t
            }
            getCustomWatchlist(e) {
                throw new Error("not implemented")
            }
            _createList(e) {
                var t;
                const n = {
                    id: null !== (t = e.id) && void 0 !== t ? t : (0,
                    J.randomHash)(),
                    symbols: e.symbols,
                    title: e.title
                };
                return this.saveList(n),
                n
            }
            _getList(e) {
                if (this._updateLists(),
                this._lists.hasOwnProperty(e)) {
                    const t = this._lists[e];
                    return {
                        id: e,
                        symbols: t.symbols.slice(),
                        title: t.title
                    }
                }
                return null
            }
            _toSymbolList(e) {
                return {
                    type: "custom",
                    id: e.id,
                    name: e.title,
                    description: null,
                    symbols: e.symbols,
                    shared: !1
                }
            }
            _updateLists() {
                this._lists = {};
                this._settings.keys().forEach((e=>{
                    const t = /^savedwatch\.(.*)$/.exec(e);
                    if (!t)
                        return;
                    const n = t[1]
                      , i = this._settings.getJSON(e, null);
                    i && (i.symbols || (i.symbols = []),
                    this._lists[n] = i)
                }
                ))
            }
            _getActive() {
                const e = this._settings.getValue(this._activeListSettingsKey)
                  , [t,n] = Object.entries(this._lists)[0]
                  , i = {
                    id: t,
                    ...n
                };
                return void 0 !== e && this._getList(e) || i
            }
            _pickTitle() {
                this._updateLists();
                const e = Object.keys(this._lists).map((e=>this._lists[e].title));
                for (let t = 1; ; t++) {
                    const i = a.t(null, void 0, n(213402)) + (t > 1 ? ` (${t})` : "");
                    if (-1 === e.indexOf(i))
                        return i
                }
            }
        }
        var ie = n(581996);
        class re {
            constructor(e) {
                this._document = e,
                this.isFullscreen = new L.WatchedValue;
                const t = ()=>{
                    const e = ["fullscreenElement", "webkitFullscreenElement", "mozFullscreenElement", "mozFullScreenElement", "msFullscreenElement"];
                    for (let t = 0; t < e.length; t++) {
                        const n = e[t];
                        if (n in this._document) {
                            this.isFullscreen.setValue(!!this._document[n]);
                            break
                        }
                    }
                }
                ;
                t();
                for (const n of ["fullscreenchange", "webkitfullscreenchange", "mozfullscreenchange", "MSFullscreenChange"])
                    e.addEventListener(n, t, !1)
            }
            enter() {
                const e = this._document.documentElement;
                for (const t of ["requestFullscreen", "mozRequestFullScreen", "webkitRequestFullscreen", "msRequestFullscreen"])
                    if ("function" == typeof e[t]) {
                        e[t]();
                        break
                    }
                this.isFullscreen.setValue(!0)
            }
            exit() {
                const e = this._document;
                for (const t of ["exitFullscreen", "mozCancelFullScreen", "mozExitFullscreen", "webkitExitFullscreen", "msExitFullscreen"])
                    if ("function" == typeof e[t]) {
                        e[t]();
                        break
                    }
                this.isFullscreen.setValue(!1)
            }
        }
        class oe {
            constructor(e) {
                this.isFullscreen = new L.WatchedValue,
                this._handleExit = e=>{
                    27 !== (0,
                    U.hashFromEvent)(e) || e.defaultPrevented || (e.preventDefault(),
                    this.exit())
                }
                ,
                this._element = e
            }
            enter() {
                this.isFullscreen.setValue(!0),
                H.emit("onInternalFullscreenShow"),
                this._element.addEventListener("keydown", this._handleExit)
            }
            exit() {
                this.isFullscreen.setValue(!1),
                H.emit("onInternalFullscreenHide"),
                this._element.removeEventListener("keydown", this._handleExit)
            }
        }
        var se = n(554433)
          , ae = n(314802);
        function le(e, t) {
            let n = 0;
            for (const {min: i, max: r} of t) {
                if (e < i || r < i)
                    continue;
                const t = Math.min(e, r);
                if (n = Math.max(n, t),
                e === n)
                    break
            }
            return n
        }
        function ue(e) {
            const t = [];
            if (void 0 === e)
                return [];
            Array.isArray(e) || (e = [e]);
            for (const n of e) {
                let e, i;
                isFinite(n) ? e = i = Number(n) : (e = +n.min,
                i = +n.max),
                (e < 0 || isNaN(e)) && (e = 0),
                isNaN(i) && (i = 1 / 0),
                e <= i && i > 0 && t.push({
                    min: e,
                    max: i
                })
            }
            return t.sort(((e,t)=>e.min - t.min || e.max - t.max)),
            t
        }
        function de(e, t) {
            if (e.length !== t.length)
                return !1;
            for (let n = e.length; n--; ) {
                if (e[n].min !== t[n].min)
                    return !1;
                if (e[n].max !== t[n].max)
                    return !1
            }
            return !0
        }
        const ce = s.enabled("no_min_chart_width")
          , he = s.enabled("bypass_chart_height_check");
        function pe(e) {
            const t = s.enabled("side_toolbar_in_fullscreen_mode")
              , n = s.enabled("header_in_fullscreen_mode");
            return "center" === e || "left" === e && t || "top" === e && n
        }
        const me = [...F(0, 3)];
        me.splice(7, 0, x.timeFrames["24m"]);
        var ge = n(971417)
          , _e = n(792795)
          , fe = n(466931);
        const ve = {
            whitelabel: !0,
            permissionOverrides: !0
        };
        var ye, be, we, Se, Te;
        const Le = (0,
        n(125226).isFeatureEnabled)("disable-calendar-advanced-chart-widget")
          , Pe = window.initData
          , Ee = window.initData.widgetDefaults
          , Ie = function(e, t=[], n) {
            return function(e, t, n, i=[], r) {
                const o = n.slice(1)
                  , s = decodeURIComponent(o);
                let a = {};
                try {
                    "" !== s && (a = JSON.parse(s),
                    void 0 !== r && r(e, a),
                    Object.keys(a).forEach((e=>{
                        (ve[e] || i.includes(e)) && delete a[e]
                    }
                    )))
                } catch (e) {
                    a = {},
                    console.warn("Hash params parsing error! Hash params ignored.")
                }
                const l = t.slice(1)
                  , u = decodeURIComponent(l);
                let d = {};
                try {
                    "" !== u && (u.split("&").map((e=>{
                        const t = e.indexOf("=");
                        return [e.slice(0, t), e.slice(t + 1)]
                    }
                    )).forEach((e=>{
                        const [t,n] = e;
                        i.includes(t) || (d[t] = n)
                    }
                    )),
                    void 0 !== r && r(e, d))
                } catch (e) {
                    d = {},
                    console.warn("Search query params parsing error! Search query params ignored.")
                }
                return Object.assign({}, e, a, d)
            }(e, location.search, location.hash, t, n)
        }(Ee);
        Le && (Ie.calendar = !1);
        const Re = void 0 !== Ie.extended_hours ? rt(Ie.extended_hours) ? "extended" : "regular" : void 0 !== Ee.def_extended_hours ? rt(Ee.def_extended_hours) ? "extended" : "regular" : Ee.def_session_id;
        const Ce = Ee.customer
          , xe = Ee.customerReadableName
          , ke = Ie.range || Ee.def_range
          , Fe = rt(null !== (ye = Ie.withdateranges) && void 0 !== ye ? ye : Ee.def_withdateranges)
          , Ae = rt(null !== (be = Ie.save_image) && void 0 !== be ? be : Pe.def_save_image, !0);
        let De;
        (void 0 === Ie.allow_symbol_change ? rt(Ee.def_hide_symbol_edit) : !rt(Ie.allow_symbol_change)) && s.setEnabled("header_symbol_search", !1),
        s.setEnabled("header_screenshot", Boolean(Ae)),
        "bovespa" === Ce && (s.disable("header_settings"),
        De = [{
            symbol: "IBOV",
            title: "Bovespa Index"
        }, {
            symbol: "IBXX",
            title: "Brazil 100 Index"
        }, {
            symbol: "IBXL",
            title: "Brazil 50 Index"
        }, {
            symbol: "IBRA",
            title: "Brazil Broad-Based Index"
        }, {
            symbol: "IGCX",
            title: "Special Corporate Governance Stock Index"
        }, {
            symbol: "ITAG",
            title: "Special Tag-Along Stock Index"
        }, {
            symbol: "IGNM",
            title: "Novo Mercado Corporate Governance Equity Index"
        }]),
        window.pro = new h.Pro(window.shopConf);
        let Ve = Ie.symbol || Ee.def_symbol || window.DEFAULT_SYMBOL;
        "cme" === Ie.symbology && (Ve = (e=>{
            var t;
            const n = new (_().SymbolToken)(e);
            if (!n.root())
                return e;
            const i = p.CMEToTVSymbologyAdapter.convertSymbolDataToTV(n.root(), n.exchange(), null !== (t = Ie.venue) && void 0 !== t ? t : "");
            return "ok" !== i.status ? e : (i.data.symbol && n.root(i.data.symbol),
            i.data.exchange && n.exchange(i.data.exchange),
            n.toString())
        }
        )(Ve));
        const Me = v()(parent)
          , Oe = [];
        let Ne, We = [];
        if (Ie.watchlist && (We = (Array.isArray(Ie.watchlist) ? Ie.watchlist : Ie.watchlist.split(/\x1f/)).map((e=>e.trim())).filter(Boolean)),
        We.length || Ie.editablewatchlist) {
            const e = {
                type: "watchlist",
                properties: {
                    list: We
                }
            };
            Ie.editablewatchlist ? (e.readonly = !1,
            e.data = {
                hideTitleButton: !0
            },
            e.settingsKey = "onwidget.watchlist",
            e.unAuthEditable = !0,
            function(e) {
                const t = new ne(e);
                (0,
                q.registerService)(K.SYMBOL_LIST_REPOSITORY_BACKEND_SERVICE, t)
            }(We)) : function(e) {
                const t = new G(e);
                (0,
                q.registerService)(K.SYMBOL_LIST_REPOSITORY_BACKEND_SERVICE, t)
            }(We),
            Oe.push(e)
        }
        rt(Ie.details) && Oe.push({
            type: "detail"
        }),
        void 0 !== Ie.widgetbar_width && (Ne = +Ie.widgetbar_width),
        (!Ne || !isFinite(Ne) || Ne < 200) && (Ne = 200);
        const Be = Oe.length ? [{
            name: "base",
            title: a.t(null, void 0, n(744843)),
            icon: "base",
            widgets: Oe.map((e=>e))
        }] : [];
        Ie.hotlist && Be.push({
            name: "hotlist",
            title: a.t(null, void 0, n(225669)),
            icon: "hotlists",
            widgets: [{
                type: "hotlist",
                properties: {
                    exchangeByLocale: {
                        default: window.COUNTRY_CODE_TO_DEFAULT_EXCHANGE.en
                    },
                    groupByLocale: {
                        default: "volume_gainers"
                    }
                }
            }, {
                type: "hotlist",
                properties: {
                    exchangeByLocale: {
                        default: window.COUNTRY_CODE_TO_DEFAULT_EXCHANGE.en
                    },
                    groupByLocale: {
                        default: "percent_change_gainers"
                    }
                }
            }, {
                type: "hotlist",
                properties: {
                    exchangeByLocale: {
                        default: window.COUNTRY_CODE_TO_DEFAULT_EXCHANGE.en
                    },
                    groupByLocale: {
                        default: "percent_change_loosers"
                    }
                }
            }]
        }),
        Ie.calendar && Be.push({
            name: "calendar",
            title: a.t(null, void 0, n(825034)),
            icon: "calendar",
            widgets: [{
                type: "reuters_calendar",
                properties: {}
            }, {
                type: "earnings_calendar",
                properties: {}
            }]
        });
        const Ue = new class {
            constructor(e, t) {
                this._updateDocumentHeight = e=>{
                    "visual" === this._viewportType && this._window.document.documentElement.style.setProperty("height", `${e}px`, "important")
                }
                ,
                this._window = e,
                this._fullscreenApi = t ? new oe(e.document.body) : new re(e.document),
                this._viewportType = B.CheckMobile.iOS() && !(0,
                ae.isOnMobileAppPage)("any") && this._window.visualViewport ? "visual" : "quirks",
                "visual" === this._viewportType ? this._viewport = (0,
                i.ensure)(this._window.visualViewport) : this._viewport = this._window;
                const n = this._layoutSizeSensor = this._window.document.createElement("div");
                n.id = "layout-size-sensor",
                n.style.position = "fixed",
                n.style.top = "0",
                n.style.left = "0",
                n.style.right = "0",
                n.style.bottom = "0",
                n.style.pointerEvents = "none",
                n.style.visibility = "hidden",
                this._initFullscreen()
            }
            allocate() {
                this.free();
                const e = this._window.document
                  , t = e.createElement("div");
                t.classList.add("js-rootresizer__contents"),
                t.style.position = "relative",
                t.style.width = "100%",
                t.style.height = "100%",
                e.body.insertAdjacentElement("afterbegin", t),
                e.body.insertAdjacentElement("afterbegin", this._layoutSizeSensor),
                this._visibilityApi = new se.VisibilityApi(this._window.document);
                const n = {
                    alive: new L.WatchedValue(!0),
                    fullscreenable: new L.WatchedValue(!0),
                    container: new L.WatchedValue(t),
                    width: new L.WatchedValue,
                    height: new L.WatchedValue,
                    availWidth: new L.WatchedValue,
                    availHeight: new L.WatchedValue,
                    visible: this._visibilityApi.isVisible,
                    fullscreen: this._fullscreenApi.isFullscreen,
                    remove: ()=>{
                        n.alive.setValue(!1)
                    }
                    ,
                    attach: ()=>{
                        n.alive.setValue(!1),
                        this._window.close()
                    }
                    ,
                    requestFullscreen: ()=>{
                        this._requestFullscreen()
                    }
                    ,
                    exitFullscreen: ()=>{
                        this._exitFullscreen()
                    }
                };
                return n.alive.subscribe((e=>{
                    e || n !== this._area || this.free()
                }
                )),
                this._area = n,
                this._resizeHandler = ()=>{
                    const e = this._width(n) || 800
                      , t = this._height(n) || 600;
                    n.availHeight.setValue(t),
                    n.availWidth.setValue(e),
                    n.height.setValue(t),
                    n.width.setValue(e)
                }
                ,
                this._area.height.subscribe(this._updateDocumentHeight, {
                    callWithLast: !0
                }),
                this._resizeHandler(),
                this._viewport.addEventListener("resize", this._resizeHandler),
                new ie.ResizerDetacherState(n).bridge()
            }
            free() {
                if (this._resizeHandler && (this._viewport.removeEventListener("resize", this._resizeHandler),
                this._resizeHandler = void 0),
                this._visibilityApi && (this._visibilityApi.destroy(),
                this._visibilityApi = void 0),
                this._area) {
                    const e = this._area;
                    this._area = void 0,
                    e.height.unsubscribe(this._updateDocumentHeight),
                    e.alive.setValue(!1);
                    const t = e.container.value()
                      , n = null == t ? void 0 : t.parentElement;
                    n && (n.removeChild(t),
                    n.removeChild(this._layoutSizeSensor))
                }
            }
            _height(e) {
                if ("visual" === this._viewportType)
                    return this._layoutSizeSensor.clientHeight;
                return e.container.value().clientHeight
            }
            _width(e) {
                return e.container.value().clientWidth
            }
            _requestFullscreen() {
                this._fullscreenApi.enter()
            }
            _exitFullscreen() {
                this._fullscreenApi.exit()
            }
            _initFullscreen() {
                this._fullscreenApi.isFullscreen.subscribe((e=>{
                    this._resizeHandler && this._resizeHandler()
                }
                ))
            }
        }
        (window)
          , ze = new class {
            constructor(e) {
                this._processVisibility = e=>{
                    const t = e.container.value();
                    return this.affectsLayout(e.name) ? (t && t.classList.toggle("js-hidden", !1),
                    !0) : (t && t.classList.toggle("js-hidden", !0),
                    !1)
                }
                ,
                this._setWidth = (e,t,n)=>{
                    let i = n;
                    this._fullscreenArea !== e.name && (e.availWidth.setValue(n),
                    e.canNegotiate.width && (i = le(n, e.negotiations.width))),
                    t || (i = 0);
                    const r = e.container.value();
                    return r && t && (r.style.width = i + "px"),
                    e.width.setValue(i),
                    i
                }
                ,
                this._setHeight = (e,t,n)=>{
                    let i = n;
                    this._fullscreenArea !== e.name && (e.availHeight.setValue(n),
                    e.canNegotiate.height && (i = le(n, e.negotiations.height))),
                    t || (i = 0);
                    const r = e.container.value();
                    return r && t && (r.style.height = i + "px"),
                    e.height.setValue(i),
                    i
                }
                ;
                const t = e.container.value();
                if (!t)
                    throw new Error("bridge.container.value() must be an element");
                this._container = t,
                this._availableAreas = ["left", "tradingpanel", "right", "top", "bottom", "center", "topleft", "extratop"],
                this._areas = {},
                this._bridge = e,
                this._width = e.width,
                this._height = e.height,
                this._width.subscribe((()=>this.recalculate())),
                this._height.subscribe((()=>this.recalculate())),
                this._bridge.visible.subscribe((()=>this._updateVisibility())),
                this._bridge.fullscreen.subscribe((()=>this._onParentFullscreenChange())),
                this.recalculate()
            }
            allocate(e) {
                const t = e && e.areaName;
                if (-1 === this._availableAreas.indexOf(t))
                    throw new Error("unknown options.areaName");
                this.free(t);
                const n = this._createDOM(t)
                  , i = {
                    name: t,
                    canNegotiate: {
                        width: "left" === t || "right" === t || "tradingpanel" === t || "topleft" === t,
                        height: "top" === t || "bottom" === t || "topleft" === t || "extratop" === t
                    },
                    negotiations: {
                        width: [],
                        height: []
                    },
                    remove: ()=>{
                        for (const e in this._areas)
                            this._areas[e] === i && this.free(e)
                    }
                    ,
                    negotiateWidth: e=>{
                        if (!i.canNegotiate.width)
                            return;
                        const t = ue(e);
                        de(i.negotiations.width, t) || (i.negotiations.width = t,
                        this.recalculate())
                    }
                    ,
                    negotiateHeight: e=>{
                        if (!i.canNegotiate.height)
                            return;
                        const t = ue(e);
                        de(i.negotiations.height, t) || (i.negotiations.height = t,
                        this.recalculate())
                    }
                    ,
                    requestFullscreen: ()=>{
                        this._fullscreenArea || ("right" !== t && "center" !== t || (this._fullscreenArea = t),
                        "center" === t && this._bridge.requestFullscreen(),
                        this._updateFullscreen())
                    }
                    ,
                    exitFullscreen: ()=>{
                        t === this._fullscreenArea && (this._fullscreenArea = void 0,
                        "center" === t && this._bridge.exitFullscreen(),
                        this._updateFullscreen())
                    }
                    ,
                    width: new L.WatchedValue,
                    height: new L.WatchedValue,
                    availWidth: new L.WatchedValue,
                    availHeight: new L.WatchedValue,
                    alive: new L.WatchedValue(!0),
                    container: new L.WatchedValue(n),
                    visible: new L.WatchedValue(!0),
                    fullscreen: new L.WatchedValue(!1),
                    fullscreenable: new L.WatchedValue("right" === t || "center" === t),
                    rdState: new ie.ResizerDetacherState
                };
                return i.rdState.pushOwner(i),
                this._areas[t] = i,
                i.rdState.owner.subscribe((e=>{
                    const n = i.container.value();
                    if (e !== i)
                        n && (n.innerHTML = "",
                        n.parentElement && n.parentElement.removeChild(n));
                    else {
                        let e = null;
                        for (let n = this._availableAreas.indexOf(t); n--; ) {
                            const t = this._availableAreas[n];
                            if (this.affectsLayout(t)) {
                                e = this._areas[t].container.value();
                                break
                            }
                        }
                        n && (e && n.parentElement ? n.insertAdjacentElement("afterend", e) : this._container.appendChild(n))
                    }
                    this.recalculate()
                }
                ), {
                    callWithLast: !0
                }),
                i.rdState.bridge()
            }
            free(e) {
                const t = this._areas[e];
                if (!t)
                    return;
                this._areas[e] = void 0;
                const n = t.container.value();
                n && n.parentElement && n.parentElement.removeChild(n),
                t.alive.setValue(!1)
            }
            recalculate() {
                const e = {};
                this._recalcSingleRunToken = e;
                const t = this._areas.topleft
                  , n = this._areas.left
                  , i = this._areas.tradingpanel
                  , r = this._areas.right
                  , o = this._areas.top
                  , s = this._areas.bottom
                  , a = this._areas.center
                  , l = this._areas.extratop
                  , u = this._width.value()
                  , d = this._height.value();
                let c = 0
                  , h = 0
                  , p = 0
                  , m = 0
                  , g = 0
                  , _ = 0
                  , f = 0
                  , v = 0;
                if (e === this._recalcSingleRunToken && l) {
                    const e = this._processVisibility(l);
                    v = this._setHeight(l, e, d),
                    this._setWidth(l, e, u)
                }
                if (e === this._recalcSingleRunToken && t) {
                    const e = this._processVisibility(t);
                    f = this._setHeight(t, e, d),
                    _ = this._setWidth(t, e, u);
                    const n = t.container.value();
                    e && n && (n.style.top = v + "px")
                }
                let y = 0;
                if (e === this._recalcSingleRunToken && o) {
                    const e = this._processVisibility(o)
                      , t = o.container.value();
                    e && t && (t.style.left = _ + "px",
                    t.style.top = v + "px");
                    const n = u - _;
                    this._setWidth(o, e, n),
                    c = this._setHeight(o, e, d),
                    c && (y = 1)
                }
                if (e === this._recalcSingleRunToken && n) {
                    const e = this._processVisibility(n)
                      , t = Math.max(f, c);
                    p = this._setWidth(n, e, u),
                    p && (p += 4),
                    p && 1 === y && (y = 4);
                    const i = n.container.value();
                    e && i && (i.style.top = t + v + y + "px"),
                    this._setHeight(n, e, d - t - v)
                }
                if (e === this._recalcSingleRunToken && i) {
                    const e = this._processVisibility(i);
                    let t = u - p;
                    ce || (t -= 300),
                    g = this._setWidth(i, e, t),
                    g && 1 === y && (y = 4),
                    this._setHeight(i, e, d - v - c - y)
                }
                if (e === this._recalcSingleRunToken && r) {
                    const e = this._processVisibility(r);
                    let t = u - p - g;
                    ce || (t -= 300),
                    m = this._setWidth(r, e, t),
                    m && 1 === y && (y = 4),
                    this._setHeight(r, e, d - v - c - y);
                    const n = r.container.value();
                    e && n && (n.style.top = c + v + y + "px")
                }
                const b = g + m;
                let w = 0
                  , S = u - p - g - m - (b ? 4 : 0);
                const T = Boolean(g || !b);
                if (!m && g && (S += 4),
                e === this._recalcSingleRunToken && s) {
                    const e = this._processVisibility(s)
                      , t = s.container.value();
                    e && t && (t.style.left = p + "px",
                    t.classList.toggle("no-border-top-left-radius", !p),
                    t.classList.toggle("no-border-top-right-radius", T)),
                    this._setWidth(s, e, S);
                    const n = d - v;
                    w = Math.min(300, n - 0),
                    h = this._setHeight(s, e, n) + 4
                }
                const L = Boolean(c && (p || b));
                if (this._container.classList.toggle("layout-with-border-radius", L),
                e === this._recalcSingleRunToken && a) {
                    const e = this._processVisibility(a)
                      , t = a.container.value();
                    e && t && (t.style.left = p + "px",
                    t.style.top = c + v + y + "px",
                    t.classList.toggle("no-border-bottom-left-radius", !h || !p),
                    t.classList.toggle("no-border-bottom-right-radius", T || !h),
                    t.classList.toggle("no-border-top-left-radius", Boolean(!p && b)),
                    t.classList.toggle("no-border-top-right-radius", T)),
                    this._setWidth(a, e, S);
                    const n = d - c - h - v - y;
                    this._setHeight(a, e, Math.max(n, w))
                }
                if (e === this._recalcSingleRunToken && i && this.affectsLayout("tradingpanel")) {
                    const e = i.container.value();
                    e && (e.style.right = g && m ? `${m + 4}px` : `${m}px`,
                    e.style.top = v + c + y + "px",
                    e.style.borderTopRightRadius = L && m ? "4px" : "0px")
                }
                e === this._recalcSingleRunToken && this._updateVisibility()
            }
            affectsLayout(e) {
                const t = this._areas[e];
                if (!t)
                    return !1;
                if (t.rdState.owner.value() !== t)
                    return !1;
                if (this._fullscreenArea && this._fullscreenArea !== e)
                    return pe(e);
                if (this._width.value() <= 567 || this._height.value() <= 445 && !he) {
                    if (!["center", "top", "left", "topleft", "extratop"].includes(e))
                        return !1
                }
                return !0
            }
            _updateVisibility() {
                const e = this._bridge.visible.value();
                for (let t = 0; t < this._availableAreas.length; t++) {
                    const n = this._availableAreas[t]
                      , i = this._areas[n];
                    i && (e && this.affectsLayout(n) ? i.visible.setValue(!0) : i.visible.setValue(!1))
                }
            }
            _onParentFullscreenChange() {
                this._bridge.fullscreen.value() || (this._fullscreenArea = void 0,
                this._updateFullscreen())
            }
            _updateFullscreen() {
                const e = void 0 !== this._fullscreenArea;
                for (let t = 0; t < this._availableAreas.length; t++) {
                    const n = this._availableAreas[t]
                      , i = this._areas[n];
                    if (!i)
                        continue;
                    if (n === this._fullscreenArea) {
                        i.fullscreen.setValue(!0);
                        continue
                    }
                    i.fullscreen.setValue(!1);
                    const r = i.container.value();
                    r && r.classList.toggle("js-hidden", e && !pe(n))
                }
                this._updateVisibility(),
                this.recalculate()
            }
            _createDOM(e) {
                const t = document.createElement("div");
                return t.classList.add("layout__area--" + e),
                t.style.position = "absolute",
                "tradingpanel" === e && (t.style.borderTopRightRadius = "4px"),
                "bottom" === e ? t.style.bottom = "0" : t.style.top = "0",
                "right" === e || "tradingpanel" === e ? t.style.right = "0" : t.style.left = "0",
                t
            }
        }
        (Ue.allocate())
          , $e = rt(Ie.hide_top_toolbar) ? null : ze.allocate({
            areaName: "top"
        })
          , He = void 0 === Ie.hide_side_toolbar || +Ie.hide_side_toolbar ? null : ze.allocate({
            areaName: "left"
        })
          , je = ze.allocate({
            areaName: "center"
        })
          , Ke = Be.length ? ze.allocate({
            areaName: "right"
        }) : null;
        if ((0,
        fe.setSupportPortalProblemsHost)(null !== (we = Ie.support_host) && void 0 !== we ? we : ""),
        ke) {
            const e = (qe = ke,
            me.find((e=>e.value.value === qe)));
            e && (Ie.range = ke,
            Ie.interval = e.targetResolution)
        }
        var qe;
        let Ge, Je;
        Ge = void 0 === Ie.interval ? void 0 === Ie.style ? null !== (Se = Ee.def_interval) && void 0 !== Se ? Se : "1" : (0,
        S.getDefaultResolution)((0,
        b.isRangeStyle)(parseInt(Ie.style))) : Ie.interval,
        Je = void 0 === Ie.style ? void 0 === Ie.interval ? null !== (Te = Ee.def_style) && void 0 !== Te ? Te : 1 : (0,
        b.getDefaultStyle)(w.Interval.isRange(Ie.interval)) : parseInt(Ie.style);
        const Xe = window.chartWidgetCollection = new (d())({
            resizerBridge: je,
            padding: 5,
            edge: Number(Ie.padding) || 0,
            publishedChartsEnabled: !1,
            saveChartEnabled: !1,
            widgetOptions: {
                onWidget: !0,
                useUserChartPreferences: !rt(Ie.doNotStoreSettings, !1),
                addToWatchlistEnabled: !1,
                propertyPagesEnabled: !1,
                chartEventsEnabled: !Le,
                newsNotificationsEnabled: !1,
                esdEnabled: s.enabled("esdonwidget"),
                sourceStatusesWidget: {
                    errorSolution: !1
                },
                marketStatusWidgetEnabled: !0,
                chartWarningWidget: {
                    subscriptionFullInfo: !1
                },
                widgetCustomer: Ce,
                customerReadableName: xe,
                hideIdeas: !0,
                controlBarEnabled: !0,
                addVolume: !rt(Ie.hide_volume),
                muteSessionErrors: !s.enabled("referral_program_for_widget_owners"),
                defSymbol: Ve,
                defInterval: Ge,
                defStyle: Je,
                defSessionId: Re,
                timezone: Ie.timezone || Ee.def_timezone,
                defTimeframe: ke,
                isDrawingToolbarVisible: E.isDrawingToolbarVisible,
                watermarkEnabled: !0,
                paneContextMenuEnabled: !1,
                compareSymbols: De,
                timeScaleWidget: {
                    contextMenuEnabled: !1,
                    timezoneMenuEnabled: !1
                },
                timeScale: {
                    preserveBarSpacing: !0,
                    lockVisibleTimeRangeOnResize: !1
                },
                legendWidgetEnabled: !rt(Ie.hide_legend),
                legendWidget: {
                    contextMenu: {
                        settings: !1,
                        fundamentals: !1,
                        showOpenMarketStatus: !0
                    }
                },
                goToDateEnabled: !1,
                handleScroll: {
                    vertTouchDrag: rt(Ie.verttouchdrag),
                    horzTouchDrag: rt(Ie.horztouchdrag, !0)
                },
                handleScale: {
                    mouseWheel: "investopedia" !== Ce && "eurex" !== Ce
                },
                currencyConversionEnabled: !0,
                unitConversionEnabled: !0
            },
            seriesControlBarEnabled: !!Fe,
            seriesControlBar: {
                timeFramesWidgetEnabled: !0,
                timeFramesWidget: {
                    goToDateEnabled: !1,
                    availableTimeFrames: F
                },
                timeWidgetEnabled: !0,
                timeWidget: {
                    timezoneMenuEnabled: !1
                },
                adjustForDividendsButtonEnabled: !0,
                sessionIdButtonEnabled: Boolean(Re),
                backAdjustmentButtonEnabled: !1,
                settlementAsCloseButtonEnabled: !1,
                percentageScaleButtonEnabled: !1,
                logScaleButtonEnabled: !1,
                autoScaleButtonEnabled: !1,
                fullscreenButtonEnabled: !0,
                mobileChangeLayoutEnabled: !1
            },
            mobileForceChartMaximizeEnabled: !1
        });
        let Ye = !1;
        Xe.onAboutToBeDestroyed.subscribe(null, (()=>{
            Ye = !0
        }
        ), !0),
        Ie.studies_overrides && Xe.applyStudiesOverrides(JSON.parse(Ie.studies_overrides)),
        Promise.all([n.e(27351), n.e(30187)]).then(n.bind(n, 532989)).then((e=>{
        }
        ));
        const Ze = Xe.activeChartWidget.value();
        let Qe;
        if (window.chartWidget = Ze,
        Xe.readOnly() || (window.studyMarket = new P(Xe,{
            onWidget: !0
        })),
        m.linking.bindToChartWidgetCollection(Xe),
        A(M.Names.WidgetLoad, Ie.frameElementId || null, void 0),
        Ie.theme) {
            const e = Ie.theme.toLowerCase()
              , t = I.themes[e];
            if (t && ((0,
            R.setTheme)(e),
            !t.noChartTheme)) {
                const e = Ie.theme && Ie.theme.toLowerCase()
                  , t = I.getStdTheme(e);
                t && t.content && (Qe = t.content,
                Ie.style && (Qe.mainSourceProperties.style = parseInt(Ie.style)),
                (0,
                l.applyDefaultsOverrides)(Qe, {
                    mainSeriesProperties: "mainSourceProperties"
                }, !0))
            }
        }
        let et = !1
          , tt = !1;
        function nt(e) {
            return (0,
            ge.isPineIdString)(e) ? {
                type: "pine",
                pineId: e
            } : {
                type: "java",
                studyId: e
            }
        }
        function it() {
            document.querySelectorAll(".loading-indicator").forEach((e=>{
                e instanceof HTMLElement && (e.style.display = "none")
            }
            ))
        }
        function rt(e, t=!1) {
            return !1 === e || !0 === e ? e : "1" === e || 1 === e || "true" === e || "0" !== e && 0 !== e && "false" !== e && t
        }
        Ze.withModel(null, (function() {
            const e = Ze.model().mainSeries();
            Ze.applyOverrides({
                "mainSeriesProperties.showCountdown": !1
            }),
            Qe && Ze.model().model().restoreTheme(Qe, !1),
            Ie.backgroundColor && Ze.applyOverrides({
                "paneProperties.background": Ie.backgroundColor,
                "paneProperties.backgroundType": _e.ColorType.Solid
            }),
            Ie.gridColor && Ze.applyOverrides({
                "paneProperties.vertGridProperties.color": Ie.gridColor,
                "paneProperties.horzGridProperties.color": Ie.gridColor
            }),
            e.dataEvents().symbolResolved().subscribe(e, (()=>{
                !function(e, t) {
                    if (!t)
                        return;
                    const n = e.model().model();
                    try {
                        JSON.parse(decodeURIComponent(t)).forEach((e=>{
                            const t = n.createStudyInserter(nt(e.id));
                            t.setForceOverlay(e.overlay),
                            t.insert((()=>Promise.resolve({
                                inputs: e.inputs,
                                parentSources: []
                            })))
                        }
                        ))
                    } catch (e) {
                        ((Array.isArray(t) ? t : t.split(/\x1f/)) || []).forEach((e=>{
                            n.createStudyInserter(nt(e)).insert()
                        }
                        ))
                    }
                }(window.chartWidget, Ie.studies)
            }
            ), !0),
            e.dataEvents().completed().subscribe(this, (()=>{
                Qe && it(),
                $ && !et && ($(Xe, !0),
                et = !0),
                j && !tt && (j(Xe, {
                    seriesControlBarEnabled: !!Fe
                }),
                tt = !0)
            }
            )),
            e.dataEvents().symbolError().subscribe(null, (()=>{
                A(M.Names.NoData, Ie.frameElementId || null, void 0)
            }
            ))
        }
        )),
        He ? (async()=>{
            const [e,t,{DrawingToolbar: i},{default: r}] = await Promise.all([Promise.all([n.e(7538), n.e(22666), n.e(5993), n.e(92191), n.e(9817), n.e(4015), n.e(53842), n.e(93502), n.e(66639), n.e(30006), n.e(35649), n.e(46036), n.e(91033), n.e(58056), n.e(67080), n.e(54712), n.e(15518), n.e(99916), n.e(36956), n.e(98149), n.e(36752), n.e(45166), n.e(22333), n.e(15886), n.e(10102), n.e(18182), n.e(24534), n.e(54690), n.e(33939), n.e(47341), n.e(3982), n.e(93370), n.e(21847), n.e(50690), n.e(30979), n.e(29594), n.e(99518), n.e(51408), n.e(2190), n.e(91890), n.e(21065), n.e(73558)]).then(n.t.bind(n, 50959, 19)), Promise.all([n.e(7538), n.e(22666), n.e(5993), n.e(92191), n.e(9817), n.e(4015), n.e(53842), n.e(93502), n.e(66639), n.e(30006), n.e(35649), n.e(46036), n.e(91033), n.e(58056), n.e(67080), n.e(54712), n.e(15518), n.e(99916), n.e(36956), n.e(98149), n.e(36752), n.e(45166), n.e(22333), n.e(15886), n.e(10102), n.e(18182), n.e(24534), n.e(54690), n.e(33939), n.e(47341), n.e(3982), n.e(93370), n.e(21847), n.e(50690), n.e(30979), n.e(29594), n.e(99518), n.e(51408), n.e(2190), n.e(91890), n.e(21065), n.e(73558)]).then(n.t.bind(n, 500962, 19)), Promise.all([n.e(7538), n.e(22666), n.e(5993), n.e(92191), n.e(9817), n.e(4015), n.e(53842), n.e(93502), n.e(66639), n.e(30006), n.e(35649), n.e(46036), n.e(91033), n.e(58056), n.e(67080), n.e(54712), n.e(15518), n.e(99916), n.e(36956), n.e(98149), n.e(36752), n.e(45166), n.e(22333), n.e(15886), n.e(10102), n.e(18182), n.e(24534), n.e(54690), n.e(33939), n.e(47341), n.e(3982), n.e(93370), n.e(21847), n.e(50690), n.e(30979), n.e(29594), n.e(99518), n.e(51408), n.e(2190), n.e(91890), n.e(21065), n.e(73558)]).then(n.bind(n, 672521)), Promise.all([n.e(7538), n.e(22666), n.e(5993), n.e(92191), n.e(9817), n.e(4015), n.e(53842), n.e(93502), n.e(66639), n.e(30006), n.e(35649), n.e(46036), n.e(91033), n.e(58056), n.e(67080), n.e(54712), n.e(15518), n.e(99916), n.e(36956), n.e(98149), n.e(36752), n.e(45166), n.e(22333), n.e(15886), n.e(10102), n.e(18182), n.e(24534), n.e(54690), n.e(33939), n.e(47341), n.e(3982), n.e(93370), n.e(21847), n.e(50690), n.e(30979), n.e(29594), n.e(99518), n.e(51408), n.e(2190), n.e(91890), n.e(21065), n.e(73558)]).then(n.t.bind(n, 49649, 23))]);
            Ye || (t.render(e.createElement(i, {
                chartWidgetCollection: Xe,
                resizerBridge: He,
                screenshotButton: "cme" === Ce
            }), He.container.value()),
            window.lineToolPropertiesToolbar = new r(Xe))
        }
        )() : document.querySelectorAll(".tv-side-toolbar").forEach((e=>{
            e.classList.add("js-hidden")
        }
        )),
        $e && (async()=>{
            const [e,t,i,{HeaderToolbar: r}] = await Promise.all([O(Ce), Promise.all([n.e(7242), n.e(93370), n.e(6237), n.e(50690), n.e(59255), n.e(79022)]).then(n.t.bind(n, 50959, 19)), Promise.all([n.e(7242), n.e(93370), n.e(6237), n.e(50690), n.e(59255), n.e(79022)]).then(n.t.bind(n, 500962, 19)), Promise.all([n.e(7242), n.e(93370), n.e(6237), n.e(50690), n.e(59255), n.e(79022)]).then(n.bind(n, 158539))])
              , o = await e.getToolSet()
              , s = C.mobiletouch ? ["full"] : void 0;
            i.render(t.createElement(r, {
                tools: o,
                chartApiInstance: window.ChartApiInstance,
                availableTimeFrames: F,
                chartWidgetCollection: Xe,
                ideas: !1,
                resizerBridge: $e,
                popupButton: rt(Ie.show_popup_button),
                studyMarket: window.studyMarket,
                windowMessageService: Me,
                isFundamental: !1,
                allowedModes: s
            }), $e.container.value())
        }
        )(),
        Ke && (async()=>{
            const [{WidgetBar: e},{configuration: t}] = await Promise.all([Promise.all([n.e(78596), n.e(65454), n.e(92438), n.e(72035), n.e(48333), n.e(92191), n.e(32109), n.e(9817), n.e(4015), n.e(76592), n.e(72639), n.e(89842), n.e(88548), n.e(13423), n.e(63987), n.e(58056), n.e(33371), n.e(54712), n.e(6744), n.e(42244), n.e(58666), n.e(54234), n.e(80345), n.e(46987), n.e(58961), n.e(96821), n.e(15697), n.e(3436), n.e(54690), n.e(42254), n.e(40639), n.e(45932), n.e(47341), n.e(52681), n.e(5662), n.e(28273), n.e(40153), n.e(13415), n.e(50690), n.e(88087), n.e(24951), n.e(61536), n.e(30877), n.e(49769), n.e(87566), n.e(66446), n.e(6925), n.e(24327), n.e(82614), n.e(95737), n.e(54876)]).then(n.bind(n, 639454)), Promise.all([n.e(78596), n.e(65454), n.e(92438), n.e(72035), n.e(48333), n.e(92191), n.e(32109), n.e(9817), n.e(4015), n.e(76592), n.e(72639), n.e(89842), n.e(88548), n.e(13423), n.e(63987), n.e(58056), n.e(33371), n.e(54712), n.e(6744), n.e(42244), n.e(58666), n.e(54234), n.e(80345), n.e(46987), n.e(58961), n.e(96821), n.e(15697), n.e(3436), n.e(54690), n.e(42254), n.e(40639), n.e(45932), n.e(47341), n.e(52681), n.e(5662), n.e(28273), n.e(40153), n.e(13415), n.e(50690), n.e(88087), n.e(24951), n.e(61536), n.e(30877), n.e(49769), n.e(87566), n.e(66446), n.e(6925), n.e(24327), n.e(82614), n.e(95737), n.e(54876)]).then(n.bind(n, 667232))]);
            Be.forEach((e=>{
                var t;
                e.widgets = null === (t = e.widgets) || void 0 === t ? void 0 : t.filter((e=>!(void 0 !== e.isEnabled && !e.isEnabled)))
            }
            ));
            window.widgetbar = new e({
                resizerBridge: Ke,
                affectsLayout: ()=>ze.affectsLayout("right"),
                readonly: !0,
                state: {
                    width: Ne,
                    pages: Be
                },
                showCloseButton: !0,
                configuration: ()=>t({
                    chartApiInstance: window.ChartApiInstance
                })
            })
        }
        )(),
        Ze.onDisconnected().subscribe(null, (e=>{
            var t;
            it(),
            e && (t = ()=>{
                window.ChartApiInstance.disconnect(),
                setTimeout((()=>{
                    window.ChartApiInstance.connect(),
                    Ze.reconnect()
                }
                ), 500)
            }
            ,
            T().then((e=>e.showCriticalErrorMessage(t))))
        }
        )),
        Ze.onReconnectBailout().subscribe(null, (()=>{
            var e;
            e = ()=>{
                setTimeout((()=>{
                    window.ChartApiInstance.connect()
                }
                ), 0)
            }
            ,
            T().then((t=>t.showDisconnectedMessage(e)))
        }
        )),
        document.querySelectorAll(".tv-content").forEach((e=>{
            e.addEventListener("contextmenu", (e=>{
                e.target instanceof Element && e.target.matches("input, textarea") || e.preventDefault()
            }
            ))
        }
        )),
        Ie.whotrades && s.setEnabled("whotrades_auth_only", !0),
        document.querySelectorAll(".loading-indicator").forEach((e=>{
            e.remove()
        }
        )),
        (()=>{
            let e;
            const t = t=>{
                void 0 !== e && (0,
                y.getQuoteSessionInstance)("simple").unsubscribe("widgetQuoteListener", e),
                e = t,
                (0,
                y.getQuoteSessionInstance)("simple").subscribe("widgetQuoteListener", t, (e=>{
                    const t = e.values
                      , n = ["change", "change_percent", "last_price", "original_name", "short_name", "exchange", "description", "volume"]
                      , i = {};
                    for (let e = 0; e < n.length; e++) {
                        const r = n[e];
                        if (!t.hasOwnProperty(r))
                            return;
                        i[r] = t[r]
                    }
                    i.volume = 1e100 === t.volume ? void 0 : t.volume,
                    Me.post(parent, "quoteUpdate", i)
                }
                ))
            }
            ;
            Ze.withModel(null, (()=>{
                const e = Ze.model().mainSeries();
                e.properties().childs().symbol.subscribe(e, (e=>{
                    t(e.value())
                }
                ))
            }
            )),
            Me.on("quoteSubscribe", (()=>{
                const e = Ze.model().mainSeries().properties().childs().symbol.value();
                t(e)
            }
            )),
            Me.on("imageURL", ((e,t)=>{
                var n;
                (0,
                c.takeChartSnapshot)(Xe, (e=>{
                    t(e)
                }
                ), (()=>{
                    t("")
                }
                ), {
                    wl: rt(null === (n = Ee.logo) || void 0 === n ? void 0 : n.whitelabel),
                    cme: Ee.cme_widget
                })
            }
            )),
            Me.on("symbolInfo", ((e,t)=>{
                const n = (0,
                i.ensureNotNull)(Ze.model().mainSeries().symbolInfo())
                  , r = Ze.model().mainSeries().properties().childs().interval.value();
                t({
                    name: n.name,
                    exchange: n.exchange,
                    description: n.description,
                    type: n.type,
                    interval: r
                })
            }
            )),
            Me.on("widgetReady", ((e,t)=>{
                Ze.withModel(null, (()=>{
                    let e;
                    Ze.model().mainSeries().symbolInfo() ? t() : (e = ()=>{
                        t(),
                        Ze.model().mainSeries().dataEvents().symbolResolved().unsubscribe(null, e)
                    }
                    ,
                    Ze.model().mainSeries().dataEvents().symbolResolved().subscribe(null, e))
                }
                ))
            }
            )),
            D(V.Names.SetSymbol, (e=>{
                e && e.symbol && Xe.setSymbol(e.symbol)
            }
            )),
            D(V.Names.SetInterval, (e=>{
                e && e.interval && Xe.setResolution(e.interval)
            }
            ))
        }
        )(),
        window.applyStudiesOverrides = e=>{
            e && window.chartWidgetCollection.applyStudiesOverrides(e)
        }
    }
    ,
    944454: (e,t,n)=>{
        var i;
        n.d(t, {
            ConnectionStatus: ()=>i
        }),
        function(e) {
            e[e.Closed = 0] = "Closed",
            e[e.Connecting = 1] = "Connecting",
            e[e.Open = 2] = "Open"
        }(i || (i = {}))
    }
    ,
    31341: (e,t,n)=>{
        n.r(t),
        n.d(t, {
            detectAutoDirection: ()=>_,
            forceLTRStr: ()=>u,
            forceLTRStrSsr: ()=>d,
            forceRTLStr: ()=>c,
            getLTRScrollLeft: ()=>h,
            getLTRScrollLeftOffset: ()=>p,
            isRtl: ()=>r,
            startWithLTR: ()=>l,
            stripLTRMarks: ()=>a
        });
        var i = n(64531);
        const r = ()=>"rtl" === window.document.dir
          , o = "‬"
          , s = new RegExp("‎|‪|‫|‬","g");
        function a(e) {
            return "" !== e && r() && null != e ? e.replace(s, "") : e
        }
        function l(e) {
            return "" !== e && r() && null != e ? "‎" + e : e
        }
        function u(e) {
            return "" !== e && r() && null != e ? "‪" + e + o : e
        }
        function d(e) {
            return "‪" + e + o
        }
        function c(e) {
            return "" !== e && r() && null != e ? "‫" + e + o : e
        }
        function h(e) {
            return (0,
            i.getNormalizedScrollLeft)(e, "rtl")
        }
        function p(e, t) {
            const n = (0,
            i.detectScrollType)();
            if ("indeterminate" === n)
                return 0;
            switch (n) {
            case "negative":
                t = e.clientWidth - e.scrollWidth + t;
                break;
            case "reverse":
                t = e.scrollWidth - e.clientWidth - t
            }
            return t
        }
        const m = /[^\u0000-\u0040\u005B-\u0060\u007B-\u00BF\u00D7\u00F7\u02B9-\u02FF\u2000-\u200E\u2010-\u2029\u202C\u202F-\u2BFF]/
          , g = /[\u0590-\u07FF\u200F\u202B\u202E\uFB1D-\uFDFD\uFE70-\uFEFC]/;
        function _(e) {
            const t = m.exec(e);
            return t ? g.test(t[0]) ? "rtl" : "ltr" : ""
        }
    }
    ,
    167222: (e,t,n)=>{
        n.d(t, {
            runOrSigninWithFeature: ()=>s
        });
        var i = n(392896)
          , r = n(847754)
          , o = n(314802);
        const s = (e,t)=>{
            {
                if ((0,
                o.isOnMobileAppPage)("any"))
                    return void window.runOrSignIn(e, t);
                const n = [];
                if (t.paidAccountCheck && n.push((()=>(0,
                i.paidAccountCheck)({
                    successButtonText: t.paidAccountSuccessButtonText
                }))),
                window.is_authenticated)
                    n.reduce(((e,t)=>e.then(t)), Promise.resolve()).then(e).catch((()=>{}
                    ));
                else {
                    const n = {
                        source: t.source,
                        sourceMeta: t.sourceMeta,
                        feature: t.feature,
                        mode: t.mode,
                        startTrial: t.startTrial
                    };
                    (0,
                    r.createRunOrSigniWithFeatureDialog)({
                        signInSuccess: e,
                        options: n
                    })
                }
            }
        }
    }
    ,
    526698: (e,t,n)=>{
        n.d(t, {
            AggregateError: ()=>f,
            ApiError: ()=>_,
            accumulateErrors: ()=>o,
            checkPhoneCode: ()=>u,
            fetchPost: ()=>s,
            firstLoginData: ()=>a,
            firstLoginDataUrl: ()=>r,
            recoverPassword: ()=>y,
            recoverPasswordUrl: ()=>v,
            recoveryPassword: ()=>d,
            resendLink: ()=>l,
            signin: ()=>p,
            signinUrl: ()=>c,
            signup: ()=>g,
            signupUrl: ()=>m,
            socialAuth: ()=>w
        });
        var i = n(120780);
        const r = "/accounts/first_login_data/";
        function o(e, t) {
            return Object.entries(e).map((e=>new _(e[1].join("\n"),t,e[0])))
        }
        function s(e, t) {
            return (0,
            i.fetch)(e, {
                method: "POST",
                credentials: "include",
                mode: "same-origin",
                body: t
            })
        }
        function a(e) {
            return s(r, e).then((e=>e.ok ? e.json() : e.json().then((t=>{
                throw new f(o(t.errors, e.status))
            }
            ))))
        }
        function l() {
            return s("/api/v1/users/anon/change-email/resend/").then((e=>e.ok ? e.json() : e.json().then((e=>{
                throw Error(e.error)
            }
            ))))
        }
        function u(e) {
            return s("/api/v1/recover_password/check_phone_code/", e).then((e=>e.ok ? e.json() : e.json().then((e=>{
                throw Error(e.error)
            }
            ))))
        }
        function d(e) {
            return s("/api/v1/recover_password/", e).then((e=>e))
        }
        const c = "/accounts/signin/";
        function h(e) {
            return e.json().then((t=>{
                if ("error"in t && "" !== t.error || "code"in t || !e.ok)
                    throw new _(t.error || t.detail,e.status,t.code,t.two_factor_types);
                return t
            }
            ))
        }
        function p(e) {
            return s(c, e).then(h)
        }
        const m = "/accounts/signup/";
        function g(e) {
            return s(m, e).then((e=>e.json().then((t=>{
                if ("errors"in t && "" !== t.errors)
                    throw new f(o(t.errors, e.status))
            }
            ))))
        }
        class _ extends Error {
            constructor(e, t, n, i) {
                super(e),
                this.type = n,
                this.status = t,
                this.secondFactorTypes = i
            }
        }
        class f extends Error {
            constructor(e) {
                super(e.map((e=>e.message)).join("\n")),
                this.errors = [],
                this.errors = e
            }
        }
        const v = "/api/v1/recover_password/search/";
        function y(e) {
            return s(v, e).then(h)
        }
        const b = {
            headers: {
                Accept: "application/json"
            }
        };
        function w(e, t={}) {
            const n = new URL(window.origin + "/accounts/complete/android-jwt/");
            return n.searchParams.append("token", e),
            Object.keys(t).forEach((e=>n.searchParams.append(e, t[e]))),
            (0,
            i.fetch)(n.href, b).then(h)
        }
    }
    ,
    290576: (e,t,n)=>{
        n.d(t, {
            getProPlanDetailsForUser: ()=>p,
            isExpertFeature: ()=>h
        });
        var i = n(822122)
          , r = n(778016)
          , o = n(255453)
          , s = n(120780)
          , a = n(526698);
        function l(e) {
            return window.pro ? e === i.ProPlans.Free ? -1 : window.pro.getProduct((0,
            o.getProductForTrial)(e)).upgrade_weight : 0
        }
        function u(e) {
            return window.pro ? window.pro.getProduct((0,
            o.getProductForTrial)(e)).upgrade_weight : 0
        }
        function d(e) {
            return function(e) {
                return e.sort(((e,t)=>l(e) - l(t)))
            }((0,
            r.getProPlansWithFeature)(e).filter((e=>!(0,
            o.isTrialProduct)(e))))[0] || null
        }
        function c(e) {
            return function(e) {
                return e.sort(((e,t)=>u(e) - u(t)))
            }((0,
            r.getExpertPlansWithFeature)(e))[0] || null
        }
        function h(e) {
            const t = c(e)
              , n = d(e);
            return Boolean(t) && !Boolean(n)
        }
        async function p() {
            const e = await (0,
            s.fetch)("/pro-plans/profile/")
              , t = await e.json();
            if (e.ok)
                return t;
            if (403 === e.status) {
                const n = t;
                throw new a.ApiError(n.detail,e.status,n.code)
            }
            throw new Error(`Unable to handle unexpected response: ${String(e.text())}`)
        }
    }
    ,
    199639: e=>{
        var t = {}
          , n = {
            XCBT: "CBOT",
            XNYM: "NYMEX",
            XCME: "CME",
            XCEC: "COMEX"
        };
        t.convertSymbolDataToTV = function(e, t, i) {
            return i = 2 === i || "floor" === i || "pit" === i ? "PIT" : "GBX",
            t && n[t] ? {
                status: "ok",
                data: {
                    symbol: e,
                    exchange: n[t] + "_" + i
                }
            } : {
                status: "error",
                data: "Exchange `" + t + "` is not supported"
            }
        }
        ,
        e.exports = t
    }
    ,
    603706: (e,t,n)=>{
        n.d(t, {
            getTimeFrames: ()=>o
        });
        var i = n(444372)
          , r = n(146585);
        function o() {
            return {
                "1d": {
                    text: i.t(null, void 0, n(932120)),
                    value: {
                        value: "1D",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1"),
                    description: (0,
                    r.daysStringLiteral)(1)
                },
                "5d": {
                    text: i.t(null, void 0, n(905486)),
                    value: {
                        value: "5D",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("5"),
                    description: (0,
                    r.daysStringLiteral)(5)
                },
                "1w": {
                    text: i.t(null, void 0, n(234880)),
                    value: {
                        value: "7D",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("15"),
                    description: (0,
                    r.weeksStringLiteral)(1)
                },
                "1m": {
                    text: i.t(null, void 0, n(460356)),
                    value: {
                        value: "1M",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("30"),
                    description: (0,
                    r.monthsStringLiteral)(1)
                },
                "3m": {
                    text: i.t(null, void 0, n(440675)),
                    value: {
                        value: "3M",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("60"),
                    description: (0,
                    r.monthsStringLiteral)(3)
                },
                "6m": {
                    text: i.t(null, void 0, n(281788)),
                    value: {
                        value: "6M",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("120"),
                    description: (0,
                    r.monthsStringLiteral)(6)
                },
                "12m": {
                    text: i.t(null, void 0, n(254790)),
                    value: {
                        value: "12M",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1D"),
                    description: (0,
                    r.yearsStringLiteral)(1)
                },
                "24m": {
                    text: i.t(null, void 0, n(440956)),
                    value: {
                        value: "24M",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1W"),
                    description: (0,
                    r.yearsStringLiteral)(2)
                },
                "36m": {
                    text: i.t(null, void 0, n(996053)),
                    value: {
                        value: "36M",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1W"),
                    description: (0,
                    r.yearsStringLiteral)(3)
                },
                "60m": {
                    text: i.t(null, void 0, n(320013)),
                    value: {
                        value: "60M",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1W"),
                    description: (0,
                    r.yearsStringLiteral)(5)
                },
                "120m": {
                    text: i.t(null, void 0, n(377628)),
                    value: {
                        value: "120M",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1M"),
                    description: (0,
                    r.yearsStringLiteral)(10)
                },
                ytd: {
                    text: i.t(null, void 0, n(989013)),
                    value: {
                        value: "YTD",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1D"),
                    description: i.t(null, void 0, n(388996))
                },
                all: {
                    text: i.t(null, void 0, n(695271)),
                    value: {
                        value: "ALL",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1M")
                },
                lastsession: {
                    text: i.t(null, void 0, n(932120)),
                    value: {
                        value: "LASTSESSION",
                        type: "period-back"
                    },
                    targetResolution: (0,
                    r.stringAsResolution)("1"),
                    description: (0,
                    r.daysStringLiteral)(1)
                }
            }
        }
    }
    ,
    146585: (e,t,n)=>{
        n.d(t, {
            daysStringLiteral: ()=>s,
            hoursStringLiteral: ()=>o,
            minutesStringLiteral: ()=>r,
            monthsStringLiteral: ()=>l,
            stringAsResolution: ()=>d,
            weeksStringLiteral: ()=>a,
            yearsStringLiteral: ()=>u
        });
        var i = n(444372);
        const r = e=>i.t(null, {
            plural: "{str} minutes",
            count: e,
            replace: {
                str: `${e}`
            }
        }, n(860144))
          , o = e=>i.t(null, {
            plural: "{str} hours",
            count: e,
            replace: {
                str: `${e}`
            }
        }, n(217174))
          , s = e=>i.t(null, {
            plural: "{str} days",
            count: e,
            replace: {
                str: `${e}`
            }
        }, n(774262))
          , a = e=>i.t(null, {
            plural: "{str} weeks",
            count: e,
            replace: {
                str: `${e}`
            }
        }, n(14074))
          , l = e=>i.t(null, {
            plural: "{str} months",
            count: e,
            replace: {
                str: `${e}`
            }
        }, n(128039))
          , u = e=>i.t(null, {
            plural: "{str} years",
            count: e,
            replace: {
                str: `${e}`
            }
        }, n(408222))
          , d = e=>e
    }
    ,
    606311: (e,t,n)=>{
        n.d(t, {
            timeFrames: ()=>i
        });
        const i = (0,
        n(603706).getTimeFrames)()
    }
    ,
    665570: (e,t,n)=>{
        n.d(t, {
            getTranslatedSymbolDescription: ()=>o
        });
        var i = n(444372);
        function r(e) {
            const t = `#${e}-symbol-description`
              , r = i.t(t, void 0, n(118562));
            return r === t ? null : r
        }
        function o(e) {
            if (void 0 !== e.pro_name) {
                const t = r(e.pro_name);
                if (null !== t)
                    return t;
                if (void 0 !== e.short_name) {
                    const t = r(e.short_name);
                    if (null !== t)
                        return t
                }
            }
            return "en" !== e.language && void 0 !== e.local_description && e.language === window.language || "en" === e.language && void 0 !== e.local_description && e.language === window.language ? e.local_description : e.description || ""
        }
    }
    ,
    97948: (e,t,n)=>{
        function i(e, t) {
            t || (t = {}),
            "function" == typeof t && (t = {
                cmp: t
            });
            var n = t.space || "";
            "number" == typeof n && (n = Array(n + 1).join(" "));
            var i, s = "boolean" == typeof t.cycles && t.cycles, a = t.replacer || function(e, t) {
                return t
            }
            , l = t.cmp && (i = t.cmp,
            function(e) {
                return function(t, n) {
                    var r = {
                        key: t,
                        value: e[t]
                    }
                      , o = {
                        key: n,
                        value: e[n]
                    };
                    return i(r, o)
                }
            }
            ), u = [];
            return function e(t, i, d, c) {
                var h = n ? "\n" + new Array(c + 1).join(n) : ""
                  , p = n ? ": " : ":";
                if (d && d.toJSON && "function" == typeof d.toJSON && (d = d.toJSON()),
                void 0 !== (d = a.call(t, i, d))) {
                    if ("object" != typeof d || null === d)
                        return JSON.stringify(d);
                    if (r(d)) {
                        for (var m = [], g = 0; g < d.length; g++) {
                            var _ = e(d, g, d[g], c + 1) || JSON.stringify(null);
                            m.push(h + n + _)
                        }
                        return "[" + m.join(",") + h + "]"
                    }
                    if (-1 !== u.indexOf(d)) {
                        if (s)
                            return JSON.stringify("__cycle__");
                        throw new TypeError("Converting circular structure to JSON")
                    }
                    u.push(d);
                    var f = o(d).sort(l && l(d));
                    for (m = [],
                    g = 0; g < f.length; g++) {
                        var v = e(d, i = f[g], d[i], c + 1);
                        if (v) {
                            var y = JSON.stringify(i) + p + v;
                            m.push(h + n + y)
                        }
                    }
                    return u.splice(u.indexOf(d), 1),
                    "{" + m.join(",") + h + "}"
                }
            }({
                "": e
            }, "", e, 0)
        }
        n.d(t, {
            sortedStringify: ()=>i
        });
        var r = Array.isArray || function(e) {
            return "[object Array]" === {}.toString.call(e)
        }
          , o = Object.keys || function(e) {
            var t = Object.prototype.hasOwnProperty || function() {
                return !0
            }
              , n = [];
            for (var i in e)
                t.call(e, i) && n.push(i);
            return n
        }
    }
    ,
    586240: e=>{
        e.exports = JSON.parse('{"size-header-height":"64px","size-sticky-symbol-header-height":"64px","size-dialog-fixed-header-height":"72px","media-phone":"screen and (max-width: 767px)","media-phone-vertical":"screen and (max-width: 479px)","media-mf-phone-vertical":"screen and (min-width: 320px)","media-mf-phone-landscape":"screen and (min-width: 568px)","media-mf-tablet-vertical":"screen and (min-width: 768px)","media-mf-tablet-landscape":"screen and (min-width: 1024px)","media-mf-laptop":"screen and (min-width: 1280px)","media-mf-desktop-medium":"screen and (min-width: 1440px)","media-mf-desktop-large":"screen and (min-width: 1920px)","media-mf-desktop-extra-large":"screen and (min-width: 2560px)"}')
    }
}, e=>{
    e.O(0, [18562, 68716, 93193, 32327, 36876, 5209, 16650, 63628, 60302, 85447, 82866, 76592, 92483, 50293, 67103, 73151, 24028, 64094, 98098, 4173, 63025, 23127, 24951, 43716, 60521, 11843, 90153, 71335, 42292, 41611, 83433, 30128, 32679, 95011, 42700, 48834, 84266, 81274, 56381, 96969, 93900, 50431, 63240, 48108, 44082, 77165, 62994], (()=>{
        return t = 377993,
        e(e.s = t);
        var t
    }
    ));
    e.O()
}
]);
