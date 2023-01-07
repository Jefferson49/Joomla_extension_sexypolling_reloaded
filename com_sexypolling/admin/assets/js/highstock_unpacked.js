/* Highstock JS v1.1.6 (2012-06-08) (c) 2009-2011 Torstein H?nsi License: www.highcharts.com/license*/
(function() {
    function z(a, b) {
        var c;
        a || (a = {});
        for (c in b) a[c] = b[c];
        return a
    }

    function ha() {
        for (var a = 0, b = arguments, c = b.length, d = {}; a < c; a++) d[b[a++]] = b[a];
        return d
    }

    function F(a, b) {
        return parseInt(a, b || 10)
    }

    function ya(a) {
        return typeof a === "string"
    }

    function ia(a) {
        return typeof a === "object"
    }

    function Va(a) {
        return Object.prototype.toString.call(a) === "[object Array]"
    }

    function Wa(a) {
        return typeof a === "number"
    }

    function ra(a) {
        return R.log(a) / R.LN10
    }

    function ja(a) {
        return R.pow(10, a)
    }

    function Ka(a, b) {
        for (var c = a.length; c--;)
            if (a[c] === b) {
                a.splice(c, 1);
                break
            }
    }

    function s(a) {
        return a !== v && a !== null
    }

    function G(a, b, c) {
        var d, e;
        if (ya(b)) s(c) ? a.setAttribute(b, c) : a && a.getAttribute && (e = a.getAttribute(b));
        else if (s(b) && ia(b))
            for (d in b) a.setAttribute(d, b[d]);
        return e
    }

    function la(a) {
        return Va(a) ? a : [a]
    }

    function p() {
        var a = arguments,
            b, c, d = a.length;
        for (b = 0; b < d; b++)
            if (c = a[b], typeof c !== "undefined" && c !== null) return c
    }

    function M(a, b) {
        if (Xa && b && b.opacity !== v) b.filter = "alpha(opacity=" + b.opacity * 100 + ")";
        z(a.style, b)
    }

    function V(a, b, c, d, e) {
        a = I.createElement(a);
        b && z(a, b);
        e && M(a, {
            padding: 0,
            border: da,
            margin: 0
        });
        c && M(a, c);
        d && d.appendChild(a);
        return a
    }

    function ca(a, b) {
        var c = function() {};
        c.prototype = new a;
        z(c.prototype, b);
        return c
    }

    function Ya(a, b, c, d) {
        var e = T.lang,
            f = a;
        b === -1 ? (b = (a || 0).toString(), a = b.indexOf(".") > -1 ? b.split(".")[1].length : 0) : a = isNaN(b = W(b)) ? 2 : b;
        var b = a,
            c = c === void 0 ? e.decimalPoint : c,
            d = d === void 0 ? e.thousandsSep : d,
            e = f < 0 ? "-" : "",
            a = String(F(f = W(+f || 0).toFixed(b))),
            g = a.length > 3 ? a.length % 3 : 0;
        return e + (g ? a.substr(0, g) + d : "") + a.substr(g).replace(/(\d{3})(?=\d)/g, "$1" + d) + (b ? c + W(f - a).toFixed(b).slice(2) : "")
    }

    function za(a, b) {
        return Array((b || 2) + 1 - String(a).length).join(0) + a
    }

    function pb(a, b, c, d) {
        var e, c = p(c, 1);
        e = a / c;
        b || (b = [1, 2, 2.5, 5, 10], d && d.allowDecimals === !1 && (c === 1 ? b = [1, 2, 5, 10] : c <= 0.1 && (b = [1 / c])));
        for (d = 0; d < b.length; d++)
            if (a = b[d], e <= (b[d] + (b[d + 1] || b[d])) / 2) break;
        a *= c;
        return a
    }

    function Cb(a, b) {
        var c = b || [
                [fb, [1, 2, 5, 10, 20, 25, 50, 100, 200, 500]],
                [Za, [1, 2, 5, 10, 15, 30]],
                [La, [1, 2, 5, 10, 15, 30]],
                [sa, [1, 2, 3, 4, 6, 8, 12]],
                [fa, [1, 2]],
                [Aa, [1, 2]],
                [Ba, [1, 2, 3, 4, 6]],
                [na, null]
            ],
            d = c[c.length - 1],
            e = E[d[0]],
            f = d[1],
            g;
        for (g = 0; g < c.length; g++)
            if (d = c[g], e = E[d[0]], f = d[1], c[g + 1] && a <= (e * f[f.length - 1] + E[c[g + 1][0]]) / 2) break;
        e === E[na] && a < 5 * e && (f = [1, 2, 5]);
        e === E[na] && a < 5 * e && (f = [1, 2, 5]);
        c = pb(a / e, f);
        return {
            unitRange: e,
            count: c,
            unitName: d[0]
        }
    }

    function gb(a, b, c, d) {
        var e = [],
            f = {},
            g = T.global.useUTC,
            h, k = new Date(b),
            b = a.unitRange,
            i = a.count;
        b >= E[Za] && (k.setMilliseconds(0), k.setSeconds(b >= E[La] ? 0 : i * $(k.getSeconds() / i)));
        if (b >= E[La]) k[Db](b >= E[sa] ? 0 : i * $(k[qb]() / i));
        if (b >= E[sa]) k[Eb](b >= E[fa] ? 0 : i * $(k[rb]() / i));
        if (b >= E[fa]) k[sb](b >= E[Ba] ? 1 : i * $(k[Ca]() / i));
        b >= E[Ba] && (k[Fb](b >= E[na] ? 0 : i * $(k[hb]() / i)), h = k[ib]());
        b >= E[na] && (h -= h % i, k[Gb](h));
        if (b === E[Aa]) k[sb](k[Ca]() - k[tb]() + p(d, 1));
        d = 1;
        h = k[ib]();
        for (var j = k.getTime(), l = k[hb](), m = k[Ca](), k = g ? 0 : (864E5 + k.getTimezoneOffset() * 6E4) % 864E5; j < c;) e.push(j), b === E[na] ? j = jb(h + d * i, 0) : b === E[Ba] ? j = jb(h, l + d * i) : !g && (b === E[fa] || b === E[Aa]) ? j = jb(h, l, m + d * i * (b === E[fa] ? 1 : 7)) : (j += b * i, b <= E[sa] && j % E[fa] === k && (f[j] = fa)), d++;
        e.push(j);
        e.info = z(a, {
            higherRanks: f,
            totalRange: b * i
        });
        return e
    }

    function Hb() {
        this.symbol = this.color = 0
    }

    function ac(a, b) {
        var c = a.length,
            d, e;
        for (e = 0; e < c; e++) a[e].ss_i = e;
        a.sort(function(a, c) {
            d = b(a, c);
            return d === 0 ? a.ss_i - c.ss_i : d
        });
        for (e = 0; e < c; e++) delete a[e].ss_i
    }

    function Ma(a) {
        for (var b = a.length, c = a[0]; b--;) a[b] < c && (c = a[b]);
        return c
    }

    function Da(a) {
        for (var b = a.length, c = a[0]; b--;) a[b] > c && (c = a[b]);
        return c
    }

    function ta(a, b) {
        for (var c in a) a[c] && a[c] !== b && a[c].destroy && a[c].destroy(), delete a[c]
    }

    function Na(a) {
        kb || (kb = V(oa));
        a && kb.appendChild(a);
        kb.innerHTML = ""
    }

    function ub(a, b) {
        var c = "Highcharts error #" + a + ": www.highcharts.com/errors/" + a;
        if (b) throw c;
        else Y.console && console.log(c)
    }

    function pa(a) {
        return parseFloat(a.toPrecision(14))
    }

    function Ea(a, b) {
        $a = p(a, b.animation)
    }

    function Ib() {
        var a = T.global.useUTC,
            b = a ? "getUTC" : "get",
            c = a ? "setUTC" : "set";
        jb = a ? Date.UTC : function(a, b, c, g, h, k) {
            return (new Date(a, b, p(c, 1), p(g, 0), p(h, 0), p(k, 0))).getTime()
        };
        qb = b + "Minutes";
        rb = b + "Hours";
        tb = b + "Day";
        Ca = b + "Date";
        hb = b + "Month";
        ib = b + "FullYear";
        Db = c + "Minutes";
        Eb = c + "Hours";
        sb = c + "Date";
        Fb = c + "Month";
        Gb = c + "FullYear"
    }

    function Fa() {}

    function ab(a, b, c) {
        this.axis = a;
        this.pos = b;
        this.type = c || "";
        this.isNew = !0;
        c || this.addLabel()
    }

    function vb(a, b) {
        this.axis = a;
        if (b) this.options = b, this.id = b.id;
        return this
    }

    function Jb(a, b, c, d, e) {
        var f = a.chart.inverted;
        this.axis = a;
        this.isNegative = c;
        this.options = b;
        this.x = d;
        this.stack = e;
        this.alignOptions = {
            align: b.align || (f ? c ? "left" : "right" : "center"),
            verticalAlign: b.verticalAlign || (f ? "middle" : c ? "bottom" : "top"),
            y: p(b.y, f ? 4 : c ? 14 : -6),
            x: p(b.x, f ? c ? -6 : 6 : 0)
        };
        this.textAlign = b.textAlign || (f ? c ? "right" : "left" : "center")
    }

    function bb() {
        this.init.apply(this, arguments)
    }

    function wb(a, b) {
        var c = b.borderWidth,
            d = b.style,
            e = b.shared,
            f = F(d.padding);
        this.chart = a;
        this.options = b;
        d.padding = 0;
        this.crosshairs = [];
        this.currentY = this.currentX = 0;
        this.tooltipIsHidden = !0;
        this.label = a.renderer.label("", 0, 0, null, null, null, b.useHTML, null, "tooltip").attr({
            padding: f,
            fill: b.backgroundColor,
            "stroke-width": c,
            r: b.borderRadius,
            zIndex: 8
        }).css(d).hide().add();
        ma || this.label.shadow(b.shadow);
        this.shared = e
    }

    function Kb(a, b) {
        var c = ma ? "" : b.chart.zoomType;
        this.zoomX = /x/.test(c);
        this.zoomY = /y/.test(c);
        this.options = b;
        this.chart = a;
        this.init(a, b.tooltip)
    }

    function xb(a) {
        this.init(a)
    }

    function cb(a, b) {
        var c, d = a.series;
        a.series = null;
        c = y(T, a);
        c.series = a.series = d;
        var d = c.chart,
            e = d.margin,
            e = ia(e) ? e : [e, e, e, e];
        this.optionsMarginTop = p(d.marginTop, e[0]);
        this.optionsMarginRight = p(d.marginRight, e[1]);
        this.optionsMarginBottom = p(d.marginBottom, e[2]);
        this.optionsMarginLeft = p(d.marginLeft, e[3]);
        this.runChartClick = (e = d.events) && !!e.click;
        this.callback = b;
        this.isResizing = 0;
        this.options = c;
        this.axes = [];
        this.series = [];
        this.hasCartesianSeries = d.showAxes;
        this.init(e)
    }

    function Lb(a) {
        var b = a.options,
            c = b.navigator,
            d = c.enabled,
            b = b.scrollbar,
            e = b.enabled,
            f = d ? c.height : 0,
            g = e ? b.height : 0,
            h = c.baseSeries;
        this.baseSeries = a.series[h] || typeof h === "string" && a.get(h) || a.series[0];
        this.handles = [];
        this.scrollbarButtons = [];
        this.elementsToDestroy = [];
        a.resetZoomEnabled = !1;
        this.chart = a;
        this.height = f;
        this.scrollbarHeight = g;
        this.scrollbarEnabled = e;
        this.navigatorEnabled = d;
        this.navigatorOptions = c;
        this.scrollbarOptions = b;
        this.outlineHeight = f + g;
        this.init()
    }

    function Mb(a) {
        a.resetZoomEnabled = !1;
        this.chart = a;
        this.buttons = [];
        this.boxSpanElements = {};
        this.init([{
            type: "month",
            count: 1,
            text: "1m"
        }, {
            type: "month",
            count: 3,
            text: "3m"
        }, {
            type: "month",
            count: 6,
            text: "6m"
        }, {
            type: "ytd",
            text: "YTD"
        }, {
            type: "year",
            count: 1,
            text: "1y"
        }, {
            type: "all",
            text: "All"
        }])
    }
    var v, I = document,
        Y = window,
        R = Math,
        u = R.round,
        $ = R.floor,
        Ga = R.ceil,
        t = R.max,
        O = R.min,
        W = R.abs,
        ga = R.cos,
        ka = R.sin,
        Ha = R.PI,
        Nb = Ha * 2 / 360,
        Ia = navigator.userAgent,
        Xa = /msie/i.test(Ia) && !Y.opera,
        Oa = I.documentMode === 8,
        Ob = /AppleWebKit/.test(Ia),
        Pb = /Firefox/.test(Ia),
        Pa = !!I.createElementNS && !!I.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect,
        bc = Pb && parseInt(Ia.split("Firefox/")[1], 10) < 4,
        ma = !Pa && !Xa && !!I.createElement("canvas").getContext,
        Qa, aa = I.documentElement.ontouchstart !== v,
        Qb = {},
        yb = 0,
        kb, T, ua, $a, db, E, Rb = function() {},
        oa = "div",
        da = "none",
        zb = "rgba(192,192,192," + (Pa ? 1.0E-6 : 0.0020) + ")",
        fb = "millisecond",
        Za = "second",
        La = "minute",
        sa = "hour",
        fa = "day",
        Aa = "week",
        Ba = "month",
        na = "year",
        jb, qb, rb, tb, Ca, hb, ib, Db, Eb, sb, Fb, Gb, U = {};
    Y.Highcharts = {};
    ua = function(a, b, c) {
        if (!s(b) || isNaN(b)) return "Invalid date";
        var a = p(a, "%Y-%m-%d %H:%M:%S"),
            d = new Date(b),
            e, f = d[rb](),
            g = d[tb](),
            h = d[Ca](),
            k = d[hb](),
            i = d[ib](),
            j = T.lang,
            l = j.weekdays,
            b = {
                a: l[g].substr(0, 3),
                A: l[g],
                d: za(h),
                e: h,
                b: j.shortMonths[k],
                B: j.months[k],
                m: za(k + 1),
                y: i.toString().substr(2, 2),
                Y: i,
                H: za(f),
                I: za(f % 12 || 12),
                l: f % 12 || 12,
                M: za(d[qb]()),
                p: f < 12 ? "AM" : "PM",
                P: f < 12 ? "am" : "pm",
                S: za(d.getSeconds()),
                L: za(u(b % 1E3), 3)
            };
        for (e in b) a = a.replace("%" + e, b[e]);
        return c ? a.substr(0, 1).toUpperCase() + a.substr(1) : a
    };
    Hb.prototype = {
        wrapColor: function(a) {
            if (this.color >= a) this.color = 0
        },
        wrapSymbol: function(a) {
            if (this.symbol >= a) this.symbol = 0
        }
    };
    E = ha(fb, 1, Za, 1E3, La, 6E4, sa, 36E5, fa, 864E5, Aa, 6048E5, Ba, 2592E6, na, 31556952E3);
    db = {
        init: function(a, b, c) {
            var b = b || "",
                d = a.shift,
                e = b.indexOf("C") > -1,
                f = e ? 7 : 3,
                g, b = b.split(" "),
                c = [].concat(c),
                h, k, i = function(a) {
                    for (g = a.length; g--;) a[g] === "M" && a.splice(g + 1, 0, a[g + 1], a[g + 2], a[g + 1], a[g + 2])
                };
            e && (i(b), i(c));
            a.isArea && (h = b.splice(b.length - 6, 6), k = c.splice(c.length - 6, 6));
            if (d <= c.length / f)
                for (; d--;) c = [].concat(c).splice(0, f).concat(c);
            a.shift = 0;
            if (b.length)
                for (a = c.length; b.length < a;) d = [].concat(b).splice(b.length - f, f), e && (d[f - 6] = d[f - 2], d[f - 5] = d[f - 1]), b = b.concat(d);
            h && (b = b.concat(h), c = c.concat(k));
            return [b, c]
        },
        step: function(a, b, c, d) {
            var e = [],
                f = a.length;
            if (c === 1) e = d;
            else if (f === b.length && c < 1)
                for (; f--;) d = parseFloat(a[f]), e[f] = isNaN(d) ? a[f] : c * parseFloat(b[f] - d) + d;
            else e = b;
            return e
        }
    };
    var P = Y.HighchartsAdapter,
        L = P || {},
        eb = L.adapterRun,
        Sb = L.getScript,
        n = L.each,
        Ab = L.grep,
        Tb = L.offset,
        va = L.map,
        y = L.merge,
        B = L.addEvent,
        Q = L.removeEvent,
        N = L.fireEvent,
        Ub = L.washMouseEvent,
        lb = L.animate,
        Ra = L.stop;
    P && P.init && P.init(db);
    if (!P && Y.jQuery) {
        var ba = jQuery,
            Sb = ba.getScript,
            eb = function(a, b) {
                return ba(a)[b]()
            },
            n = function(a, b) {
                for (var c = 0, d = a.length; c < d; c++)
                    if (b.call(a[c], a[c], c, a) === !1) return c
            },
            Ab = ba.grep,
            va = function(a, b) {
                for (var c = [], d = 0, e = a.length; d < e; d++) c[d] = b.call(a[d], a[d], d, a);
                return c
            },
            y = function() {
                var a = arguments;
                return ba.extend(!0, null, a[0], a[1], a[2], a[3])
            },
            Tb = function(a) {
                return ba(a).offset()
            },
            B = function(a, b, c) {
                ba(a).bind(b, c)
            },
            Q = function(a, b, c) {
                var d = I.removeEventListener ? "removeEventListener" : "detachEvent";
                I[d] && !a[d] && (a[d] = function() {});
                ba(a).unbind(b, c)
            },
            N = function(a, b, c, d) {
                var e = ba.Event(b),
                    f = "detached" + b,
                    g;
                !Xa && c && (delete c.layerX, delete c.layerY);
                z(e, c);
                a[b] && (a[f] = a[b], a[b] = null);
                n(["preventDefault", "stopPropagation"], function(a) {
                    var b = e[a];
                    e[a] = function() {
                        try {
                            b.call(e)
                        } catch (c) {
                            a === "preventDefault" && (g = !0)
                        }
                    }
                });
                ba(a).trigger(e);
                a[f] && (a[b] = a[f], a[f] = null);
                d && !e.isDefaultPrevented() && !g && d(e)
            },
            Ub = function(a) {
                return a
            },
            lb = function(a, b, c) {
                var d = ba(a);
                if (b.d) a.toD = b.d, b.d = 1;
                d.stop();
                d.animate(b, c)
            },
            Ra = function(a) {
                ba(a).stop()
            };
        ba.extend(ba.easing, {
            easeOutQuad: function(a, b, c, d, e) {
                return -d * (b /= e) * (b - 2) + c
            }
        });
        var Vb = ba.fx,
            Wb = Vb.step;
        n(["cur", "_default", "width", "height"], function(a, b) {
            var c = Wb,
                d, e;
            a === "cur" ? c = Vb.prototype : a === "_default" && ba.Tween && (c = ba.Tween.propHooks[a], a = "set");
            (d = c[a]) && (c[a] = function(c) {
                c = b ? c : this;
                e = c.elem;
                return e.attr ? e.attr(c.prop, a === "cur" ? v : c.now) : d.apply(this, arguments)
            })
        });
        Wb.d = function(a) {
            var b = a.elem;
            if (!a.started) {
                var c = db.init(b, b.d, b.toD);
                a.start = c[0];
                a.end = c[1];
                a.started = !0
            }
            b.attr("d", db.step(a.start, a.end, a.pos, b.toD))
        }
    }
    L = {
        enabled: !0,
        align: "center",
        x: 0,
        y: 15,
        style: {
            color: "#666",
            fontSize: "11px",
            lineHeight: "14px"
        }
    };
    T = {
        colors: "#4572A7,#AA4643,#89A54E,#80699B,#3D96AE,#DB843D,#92A8CD,#A47D7C,#B5CA92".split(","),
        symbols: ["circle", "diamond", "square", "triangle", "triangle-down"],
        lang: {
            loading: "Loading...",
            months: "January,February,March,April,May,June,July,August,September,October,November,December".split(","),
            shortMonths: "Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec".split(","),
            weekdays: "Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday".split(","),
            decimalPoint: ".",
            resetZoom: "Reset zoom",
            resetZoomTitle: "Reset zoom level 1:1",
            thousandsSep: ","
        },
        global: {
            useUTC: !0,
            canvasToolsURL: "http://code.highcharts.com/stock/1.1.6/modules/canvas-tools.js"
        },
        chart: {
            borderColor: "#4572A7",
            borderRadius: 5,
            defaultSeriesType: "line",
            ignoreHiddenSeries: !0,
            spacingTop: 10,
            spacingRight: 10,
            spacingBottom: 15,
            spacingLeft: 10,
            style: {
                fontFamily: '"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif',
                fontSize: "12px"
            },
            backgroundColor: "#FFFFFF",
            plotBorderColor: "#C0C0C0",
            resetZoomButton: {
                theme: {
                    zIndex: 20
                },
                position: {
                    align: "right",
                    x: -10,
                    y: 10
                }
            }
        },
        title: {
            text: "Chart title",
            align: "center",
            y: 15,
            style: {
                color: "#3E576F",
                fontSize: "16px"
            }
        },
        subtitle: {
            text: "",
            align: "center",
            y: 30,
            style: {
                color: "#6D869F"
            }
        },
        plotOptions: {
            line: {
                allowPointSelect: !1,
                showCheckbox: !1,
                animation: {
                    duration: 1E3
                },
                events: {},
                lineWidth: 2,
                shadow: !0,
                marker: {
                    enabled: !0,
                    lineWidth: 0,
                    radius: 4,
                    lineColor: "#FFFFFF",
                    states: {
                        hover: {},
                        select: {
                            fillColor: "#FFFFFF",
                            lineColor: "#000000",
                            lineWidth: 2
                        }
                    }
                },
                point: {
                    events: {}
                },
                dataLabels: y(L, {
                    enabled: !1,
                    y: -6,
                    formatter: function() {
                        return this.y
                    }
                }),
                cropThreshold: 300,
                pointRange: 0,
                showInLegend: !0,
                states: {
                    hover: {
                        marker: {}
                    },
                    select: {
                        marker: {}
                    }
                },
                stickyTracking: !0
            }
        },
        labels: {
            style: {
                position: "absolute",
                color: "#3E576F"
            }
        },
        legend: {
            enabled: !0,
            align: "center",
            layout: "horizontal",
            labelFormatter: function() {
                return this.name
            },
            borderWidth: 1,
            borderColor: "#909090",
            borderRadius: 5,
            navigation: {
                activeColor: "#3E576F",
                inactiveColor: "#CCC"
            },
            shadow: !1,
            itemStyle: {
                cursor: "pointer",
                color: "#3E576F",
                fontSize: "12px"
            },
            itemHoverStyle: {
                color: "#000"
            },
            itemHiddenStyle: {
                color: "#CCC"
            },
            itemCheckboxStyle: {
                position: "absolute",
                width: "13px",
                height: "13px"
            },
            symbolWidth: 16,
            symbolPadding: 5,
            verticalAlign: "bottom",
            x: 0,
            y: 0
        },
        loading: {
            labelStyle: {
                fontWeight: "bold",
                position: "relative",
                top: "1em"
            },
            style: {
                position: "absolute",
                backgroundColor: "white",
                opacity: 0.5,
                textAlign: "center"
            }
        },
        tooltip: {
            enabled: !0,
            backgroundColor: "rgba(255, 255, 255, .85)",
            borderWidth: 2,
            borderRadius: 5,
            dateTimeLabelFormats: {
                millisecond: "%A, %b %e, %H:%M:%S.%L",
                second: "%A, %b %e, %H:%M:%S",
                minute: "%A, %b %e, %H:%M",
                hour: "%A, %b %e, %H:%M",
                day: "%A, %b %e, %Y",
                week: "Week from %A, %b %e, %Y",
                month: "%B %Y",
                year: "%Y"
            },
            headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>',
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
            shadow: !0,
            shared: ma,
            snap: aa ? 25 : 10,
            style: {
                color: "#333333",
                fontSize: "12px",
                padding: "5px",
                whiteSpace: "nowrap"
            }
        },
        credits: {
            enabled: !0,
            text: "Highcharts.com",
            href: "http://www.highcharts.com",
            position: {
                align: "right",
                x: -10,
                verticalAlign: "bottom",
                y: -5
            },
            style: {
                cursor: "pointer",
                color: "#909090",
                fontSize: "10px"
            }
        }
    };
    var S = T.plotOptions,
        P = S.line;
    Ib();
    var wa = function(a) {
        var b = [],
            c;
        (function(a) {
            (c = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]?(?:\.[0-9]+)?)\s*\)/.exec(a)) ? b = [F(c[1]), F(c[2]), F(c[3]), parseFloat(c[4], 10)]: (c = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(a)) && (b = [F(c[1], 16), F(c[2], 16), F(c[3], 16), 1])
        })(a);
        return {
            get: function(c) {
                return b && !isNaN(b[0]) ? c === "rgb" ? "rgb(" + b[0] + "," + b[1] + "," + b[2] + ")" : c === "a" ? b[3] : "rgba(" + b.join(",") + ")" : a
            },
            brighten: function(a) {
                if (Wa(a) && a !== 0) {
                    var c;
                    for (c = 0; c < 3; c++) b[c] += F(a * 255), b[c] < 0 && (b[c] = 0), b[c] > 255 && (b[c] = 255)
                }
                return this
            },
            setOpacity: function(a) {
                b[3] = a;
                return this
            }
        }
    };
    Fa.prototype = {
        init: function(a, b) {
            this.element = b === "span" ? V(b) : I.createElementNS("http://www.w3.org/2000/svg", b);
            this.renderer = a;
            this.attrSetters = {}
        },
        animate: function(a, b, c) {
            b = p(b, $a, !0);
            Ra(this);
            if (b) {
                b = y(b);
                if (c) b.complete = c;
                lb(this, a, b)
            } else this.attr(a), c && c()
        },
        attr: function(a, b) {
            var c, d, e, f, g = this.element,
                h = g.nodeName,
                k = this.renderer,
                i, j = this.attrSetters,
                l = this.shadows,
                m, o, r = this;
            ya(a) && s(b) && (c = a, a = {}, a[c] = b);
            if (ya(a)) c = a, h === "circle" ? c = {
                x: "cx",
                y: "cy"
            } [c] || c : c === "strokeWidth" && (c = "stroke-width"), r = G(g, c) || this[c] || 0, c !== "d" && c !== "visibility" && (r = parseFloat(r));
            else
                for (c in a)
                    if (i = !1, d = a[c], e = j[c] && j[c](d, c), e !== !1) {
                        e !== v && (d = e);
                        if (c === "d") d && d.join && (d = d.join(" ")), /(NaN| {2}|^$)/.test(d) && (d = "M 0 0");
                        else if (c === "x" && h === "text") {
                            for (e = 0; e < g.childNodes.length; e++) f = g.childNodes[e], G(f, "x") === G(g, "x") && G(f, "x", d);
                            this.rotation && G(g, "transform", "rotate(" + this.rotation + " " + d + " " + F(a.y || G(g, "y")) + ")")
                        } else if (c === "fill") d = k.color(d, g, c);
                        else if (h === "circle" && (c === "x" || c === "y")) c = {
                            x: "cx",
                            y: "cy"
                        } [c] || c;
                        else if (h === "rect" && c === "r") G(g, {
                            rx: d,
                            ry: d
                        }), i = !0;
                        else if (c === "translateX" || c === "translateY" || c === "rotation" || c === "verticalAlign") i = o = !0;
                        else if (c === "stroke") d = k.color(d, g, c);
                        else if (c === "dashstyle")
                            if (c = "stroke-dasharray", d = d && d.toLowerCase(), d === "solid") d = da;
                            else {
                                if (d) {
                                    d = d.replace("shortdashdotdot", "3,1,1,1,1,1,").replace("shortdashdot", "3,1,1,1").replace("shortdot", "1,1,").replace("shortdash", "3,1,").replace("longdash", "8,3,").replace(/dot/g, "1,3,").replace("dash", "4,3,").replace(/,$/, "").split(",");
                                    for (e = d.length; e--;) d[e] = F(d[e]) * a["stroke-width"];
                                    d = d.join(",")
                                }
                            }
                        else if (c === "isTracker") this[c] = d;
                        else if (c === "width") d = F(d);
                        else if (c === "align") c = "text-anchor", d = {
                            left: "start",
                            center: "middle",
                            right: "end"
                        } [d];
                        else if (c === "title") e = g.getElementsByTagName("title")[0], e || (e = I.createElementNS("http://www.w3.org/2000/svg", "title"), g.appendChild(e)), e.textContent = d;
                        c === "strokeWidth" && (c = "stroke-width");
                        Ob && c === "stroke-width" && d === 0 && (d = 1.0E-6);
                        this.symbolName && /^(x|y|width|height|r|start|end|innerR|anchorX|anchorY)/.test(c) && (m || (this.symbolAttr(a), m = !0), i = !0);
                        if (l && /^(width|height|visibility|x|y|d|transform)$/.test(c))
                            for (e = l.length; e--;) G(l[e], c, c === "height" ? t(d - (l[e].cutHeight || 0), 0) : d);
                        if ((c === "width" || c === "height") && h === "rect" && d < 0) d = 0;
                        this[c] = d;
                        o && this.updateTransform();
                        c === "text" ? (this.textStr = d, this.added && k.buildText(this)) : i || G(g, c, d)
                    } if (Ob && /Chrome\/(18|19)/.test(Ia) && h === "text" && (a.x !== v || a.y !== v)) c = g.parentNode, d = g.nextSibling, c && (c.removeChild(g), d ? c.insertBefore(g, d) : c.appendChild(g));
            return r
        },
        symbolAttr: function(a) {
            var b = this;
            n("x,y,r,start,end,width,height,innerR,anchorX,anchorY".split(","), function(c) {
                b[c] = p(a[c], b[c])
            });
            b.attr({
                d: b.renderer.symbols[b.symbolName](b.x, b.y, b.width, b.height, b)
            })
        },
        clip: function(a) {
            return this.attr("clip-path", "url(" + this.renderer.url + "#" + a.id + ")")
        },
        crisp: function(a, b, c, d, e) {
            var f, g = {},
                h = {},
                k, a = a || this.strokeWidth || this.attr && this.attr("stroke-width") || 0;
            k = u(a) % 2 / 2;
            h.x = $(b || this.x || 0) + k;
            h.y = $(c || this.y || 0) + k;
            h.width = $((d || this.width || 0) - 2 * k);
            h.height = $((e || this.height || 0) - 2 * k);
            h.strokeWidth = a;
            for (f in h) this[f] !== h[f] && (this[f] = g[f] = h[f]);
            return g
        },
        css: function(a) {
            var b = this.element,
                b = a && a.width && b.nodeName === "text",
                c, d = "",
                e = function(a, b) {
                    return "-" + b.toLowerCase()
                };
            if (a && a.color) a.fill = a.color;
            this.styles = a = z(this.styles, a);
            if (Xa && !Pa) b && delete a.width, M(this.element, a);
            else {
                for (c in a) d += c.replace(/([A-Z])/g, e) + ":" + a[c] + ";";
                this.attr({
                    style: d
                })
            }
            b && this.added && this.renderer.buildText(this);
            return this
        },
        on: function(a, b) {
            var c = b;
            aa && a === "click" && (a = "touchstart", c = function(a) {
                a.preventDefault();
                b()
            });
            this.element["on" + a] = c;
            return this
        },
        setRadialReference: function(a) {
            this.element.radialReference = a;
            return this
        },
        translate: function(a, b) {
            return this.attr({
                translateX: a,
                translateY: b
            })
        },
        invert: function() {
            this.inverted = !0;
            this.updateTransform();
            return this
        },
        htmlCss: function(a) {
            var b = this.element;
            if (b = a && b.tagName === "SPAN" && a.width) delete a.width, this.textWidth = b, this.updateTransform();
            this.styles = z(this.styles, a);
            M(this.element, a);
            return this
        },
        htmlGetBBox: function(a) {
            var b = this.element,
                c = this.bBox;
            if (!c || a) {
                if (b.nodeName === "text") b.style.position = "absolute";
                c = this.bBox = {
                    x: b.offsetLeft,
                    y: b.offsetTop,
                    width: b.offsetWidth,
                    height: b.offsetHeight
                }
            }
            return c
        },
        htmlUpdateTransform: function() {
            if (this.added) {
                var a = this.renderer,
                    b = this.element,
                    c = this.translateX || 0,
                    d = this.translateY || 0,
                    e = this.x || 0,
                    f = this.y || 0,
                    g = this.textAlign || "left",
                    h = {
                        left: 0,
                        center: 0.5,
                        right: 1
                    } [g],
                    k = g && g !== "left",
                    i = this.shadows;
                if (c || d) M(b, {
                    marginLeft: c,
                    marginTop: d
                }), i && n(i, function(a) {
                    M(a, {
                        marginLeft: c + 1,
                        marginTop: d + 1
                    })
                });
                this.inverted && n(b.childNodes, function(c) {
                    a.invertChild(c, b)
                });
                if (b.tagName === "SPAN") {
                    var j, l, i = this.rotation,
                        m;
                    j = 0;
                    var o = 1,
                        r = 0,
                        A;
                    m = F(this.textWidth);
                    var q = this.xCorr || 0,
                        C = this.yCorr || 0,
                        J = [i, g, b.innerHTML, this.textWidth].join(",");
                    if (J !== this.cTT) s(i) && (j = i * Nb, o = ga(j), r = ka(j), M(b, {
                        filter: i ? ["progid:DXImageTransform.Microsoft.Matrix(M11=", o, ", M12=", -r, ", M21=", r, ", M22=", o, ", sizingMethod='auto expand')"].join("") : da
                    })), j = p(this.elemWidth, b.offsetWidth), l = p(this.elemHeight, b.offsetHeight), j > m && /[ \-]/.test(b.innerText) && (M(b, {
                        width: m + "px",
                        display: "block",
                        whiteSpace: "normal"
                    }), j = m), m = a.fontMetrics(b.style.fontSize).b, q = o < 0 && -j, C = r < 0 && -l, A = o * r < 0, q += r * m * (A ? 1 - h : h), C -= o * m * (i ? A ? h : 1 - h : 1), k && (q -= j * h * (o < 0 ? -1 : 1), i && (C -= l * h * (r < 0 ? -1 : 1)), M(b, {
                        textAlign: g
                    })), this.xCorr = q, this.yCorr = C;
                    M(b, {
                        left: e + q + "px",
                        top: f + C + "px"
                    });
                    this.cTT = J
                }
            } else this.alignOnAdd = !0
        },
        updateTransform: function() {
            var a = this.translateX || 0,
                b = this.translateY || 0,
                c = this.inverted,
                d = this.rotation,
                e = [];
            c && (a += this.attr("width"), b += this.attr("height"));
            (a || b) && e.push("translate(" + a + "," + b + ")");
            c ? e.push("rotate(90) scale(-1,1)") : d && e.push("rotate(" + d + " " + (this.x || 0) + " " + (this.y || 0) + ")");
            e.length && G(this.element, "transform", e.join(" "))
        },
        toFront: function() {
            var a = this.element;
            a.parentNode.appendChild(a);
            return this
        },
        align: function(a, b, c) {
            a ? (this.alignOptions = a, this.alignByTranslate = b, c || this.renderer.alignedObjects.push(this)) : (a = this.alignOptions, b = this.alignByTranslate);
            var c = p(c, this.renderer),
                d = a.align,
                e = a.verticalAlign,
                f = (c.x || 0) + (a.x || 0),
                g = (c.y || 0) + (a.y || 0),
                h = {};
            /^(right|center)$/.test(d) && (f += (c.width - (a.width || 0)) / {
                right: 1,
                center: 2
            } [d]);
            h[b ? "translateX" : "x"] = u(f);
            /^(bottom|middle)$/.test(e) && (g += (c.height - (a.height || 0)) / ({
                bottom: 1,
                middle: 2
            } [e] || 1));
            h[b ? "translateY" : "y"] = u(g);
            this[this.placed ? "animate" : "attr"](h);
            this.placed = !0;
            this.alignAttr = h;
            return this
        },
        getBBox: function(a) {
            var b, c, d = this.rotation;
            c = this.element;
            var e = d * Nb;
            if (c.namespaceURI === "http://www.w3.org/2000/svg" || this.renderer.forExport) {
                try {
                    b = c.getBBox ? z({}, c.getBBox()) : {
                        width: c.offsetWidth,
                        height: c.offsetHeight
                    }
                } catch (f) {}
                if (!b || b.width < 0) b = {
                    width: 0,
                    height: 0
                };
                a = b.width;
                c = b.height;
                if (d) b.width = W(c * ka(e)) + W(a * ga(e)), b.height = W(c * ga(e)) + W(a * ka(e))
            } else b = this.htmlGetBBox(a);
            return b
        },
        show: function() {
            return this.attr({
                visibility: "visible"
            })
        },
        hide: function() {
            return this.attr({
                visibility: "hidden"
            })
        },
        add: function(a) {
            var b = this.renderer,
                c = a || b,
                d = c.element || b.box,
                e = d.childNodes,
                f = this.element,
                g = G(f, "zIndex"),
                h;
            this.parentInverted = a && a.inverted;
            this.textStr !== void 0 && b.buildText(this);
            if (g) c.handleZ = !0, g = F(g);
            if (c.handleZ)
                for (c = 0; c < e.length; c++)
                    if (a = e[c], b = G(a, "zIndex"), a !== f && (F(b) > g || !s(g) && s(b))) {
                        d.insertBefore(f, a);
                        h = !0;
                        break
                    } h || d.appendChild(f);
            this.added = !0;
            N(this, "add");
            return this
        },
        safeRemoveChild: function(a) {
            var b = a.parentNode;
            b && b.removeChild(a)
        },
        destroy: function() {
            var a = this,
                b = a.element || {},
                c = a.shadows,
                d = a.box,
                e, f;
            b.onclick = b.onmouseout = b.onmouseover = b.onmousemove = null;
            Ra(a);
            if (a.clipPath) a.clipPath = a.clipPath.destroy();
            if (a.stops) {
                for (f = 0; f < a.stops.length; f++) a.stops[f] = a.stops[f].destroy();
                a.stops = null
            }
            a.safeRemoveChild(b);
            c && n(c, function(b) {
                a.safeRemoveChild(b)
            });
            d && d.destroy();
            Ka(a.renderer.alignedObjects, a);
            for (e in a) delete a[e];
            return null
        },
        empty: function() {
            for (var a = this.element, b = a.childNodes, c = b.length; c--;) a.removeChild(b[c])
        },
        shadow: function(a, b, c) {
            var d = [],
                e, f = this.element,
                g, h = this.parentInverted ? "(-1,-1)" : "(1,1)";
            if (a) {
                for (a = 1; a <= 3; a++) {
                    e = f.cloneNode(0);
                    g = 7 - 2 * a;
                    G(e, {
                        isShadow: "true",
                        stroke: "rgb(0, 0, 0)",
                        "stroke-opacity": 0.05 * a,
                        "stroke-width": g,
                        transform: "translate" + h,
                        fill: da
                    });
                    if (c) G(e, "height", t(G(e, "height") - g, 0)), e.cutHeight = g;
                    b ? b.element.appendChild(e) : f.parentNode.insertBefore(e, f);
                    d.push(e)
                }
                this.shadows = d
            }
            return this
        }
    };
    var qa = function() {
        this.init.apply(this, arguments)
    };
    qa.prototype = {
        Element: Fa,
        init: function(a, b, c, d) {
            var e = location,
                f;
            f = this.createElement("svg").attr({
                xmlns: "http://www.w3.org/2000/svg",
                version: "1.1"
            });
            a.appendChild(f.element);
            this.isSVG = !0;
            this.box = f.element;
            this.boxWrapper = f;
            this.alignedObjects = [];
            this.url = Xa ? "" : e.href.replace(/#.*?$/, "").replace(/([\('\)])/g, "\\$1");
            this.defs = this.createElement("defs").add();
            this.forExport = d;
            this.gradients = {};
            this.setSize(b, c, !1);
            var g;
            if (Pb && a.getBoundingClientRect) this.subPixelFix = b = function() {
                M(a, {
                    left: 0,
                    top: 0
                });
                g = a.getBoundingClientRect();
                M(a, {
                    left: Ga(g.left) - g.left + "px",
                    top: Ga(g.top) - g.top + "px"
                })
            }, b(), B(Y, "resize", b)
        },
        isHidden: function() {
            return !this.boxWrapper.getBBox().width
        },
        destroy: function() {
            var a = this.defs;
            this.box = null;
            this.boxWrapper = this.boxWrapper.destroy();
            ta(this.gradients || {});
            this.gradients = null;
            if (a) this.defs = a.destroy();
            this.subPixelFix && Q(Y, "resize", this.subPixelFix);
            return this.alignedObjects = null
        },
        createElement: function(a) {
            var b = new this.Element;
            b.init(this, a);
            return b
        },
        draw: function() {},
        buildText: function(a) {
            for (var b = a.element, c = p(a.textStr, "").toString().replace(/<(b|strong)>/g, '<span style="font-weight:bold">').replace(/<(i|em)>/g, '<span style="font-style:italic">').replace(/<a/g, "<span").replace(/<\/(b|strong|i|em|a)>/g, "</span>").split(/<br.*?>/g), d = b.childNodes, e = /style="([^"]+)"/, f = /href="([^"]+)"/, g = G(b, "x"), h = a.styles, k = h && F(h.width), i = h && h.lineHeight, j, h = d.length, l = []; h--;) b.removeChild(d[h]);
            k && !a.added && this.box.appendChild(b);
            c[c.length - 1] === "" && c.pop();
            n(c, function(c, d) {
                var h, A = 0,
                    q, c = c.replace(/<span/g, "|||<span").replace(/<\/span>/g, "</span>|||");
                h = c.split("|||");
                n(h, function(c) {
                    if (c !== "" || h.length === 1) {
                        var m = {},
                            n = I.createElementNS("http://www.w3.org/2000/svg", "tspan");
                        e.test(c) && G(n, "style", c.match(e)[1].replace(/(;| |^)color([ :])/, "$1fill$2"));
                        f.test(c) && (G(n, "onclick", 'location.href="' + c.match(f)[1] + '"'), M(n, {
                            cursor: "pointer"
                        }));
                        c = (c.replace(/<(.|\n)*?>/g, "") || " ").replace(/&lt;/g, "<").replace(/&gt;/g, ">");
                        n.appendChild(I.createTextNode(c));
                        A ? m.dx = 3 : m.x = g;
                        if (!A) {
                            if (d) {
                                !Pa && a.renderer.forExport && M(n, {
                                    display: "block"
                                });
                                q = Y.getComputedStyle && F(Y.getComputedStyle(j, null).getPropertyValue("line-height"));
                                if (!q || isNaN(q)) {
                                    var p;
                                    if (!(p = i))
                                        if (!(p = j.offsetHeight)) l[d] = b.getBBox().height, p = u(l[d] - (l[d - 1] || 0)) || 18;
                                    q = p
                                }
                                G(n, "dy", q)
                            }
                            j = n
                        }
                        G(n, m);
                        b.appendChild(n);
                        A++;
                        if (k)
                            for (var c = c.replace(/-/g, "- ").split(" "), D = []; c.length || D.length;) p = a.getBBox().width, m = p > k, !m || c.length === 1 ? (c = D, D = [], c.length && (n = I.createElementNS("http://www.w3.org/2000/svg", "tspan"), G(n, {
                                dy: i || 16,
                                x: g
                            }), b.appendChild(n), p > k && (k = p))) : (n.removeChild(n.firstChild), D.unshift(c.pop())), c.length && n.appendChild(I.createTextNode(c.join(" ").replace(/- /g, "-")))
                    }
                })
            })
        },
        button: function(a, b, c, d, e, f, g) {
            var h = this.label(a, b, c),
                k = 0,
                i, j, l, m, o, a = {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                e = y(ha("stroke-width", 1, "stroke", "#999", "fill", ha("linearGradient", a, "stops", [
                    [0, "#FFF"],
                    [1, "#DDD"]
                ]), "r", 3, "padding", 3, "style", ha("color", "black")), e);
            l = e.style;
            delete e.style;
            f = y(e, ha("stroke", "#68A", "fill", ha("linearGradient", a, "stops", [
                [0, "#FFF"],
                [1, "#ACF"]
            ])), f);
            m = f.style;
            delete f.style;
            g = y(e, ha("stroke", "#68A", "fill", ha("linearGradient", a, "stops", [
                [0, "#9BD"],
                [1, "#CDF"]
            ])), g);
            o = g.style;
            delete g.style;
            B(h.element, "mouseenter", function() {
                h.attr(f).css(m)
            });
            B(h.element, "mouseleave", function() {
                i = [e, f, g][k];
                j = [l, m, o][k];
                h.attr(i).css(j)
            });
            h.setState = function(a) {
                (k = a) ? a === 2 && h.attr(g).css(o): h.attr(e).css(l)
            };
            return h.on("click", function() {
                d.call(h)
            }).attr(e).css(z({
                cursor: "default"
            }, l))
        },
        crispLine: function(a, b) {
            a[1] === a[4] && (a[1] = a[4] = u(a[1]) + b % 2 / 2);
            a[2] === a[5] && (a[2] = a[5] = u(a[2]) + b % 2 / 2);
            return a
        },
        path: function(a) {
            var b = {
                fill: da
            };
            Va(a) ? b.d = a : ia(a) && z(b, a);
            return this.createElement("path").attr(b)
        },
        circle: function(a, b, c) {
            a = ia(a) ? a : {
                x: a,
                y: b,
                r: c
            };
            return this.createElement("circle").attr(a)
        },
        arc: function(a, b, c, d, e, f) {
            if (ia(a)) b = a.y, c = a.r, d = a.innerR, e = a.start, f = a.end, a = a.x;
            return this.symbol("arc", a || 0, b || 0, c || 0, c || 0, {
                innerR: d || 0,
                start: e || 0,
                end: f || 0
            })
        },
        rect: function(a, b, c, d, e, f) {
            e = ia(a) ? a.r : e;
            e = this.createElement("rect").attr({
                rx: e,
                ry: e,
                fill: da
            });
            return e.attr(ia(a) ? a : e.crisp(f, a, b, t(c, 0), t(d, 0)))
        },
        setSize: function(a, b, c) {
            var d = this.alignedObjects,
                e = d.length;
            this.width = a;
            this.height = b;
            for (this.boxWrapper[p(c, !0) ? "animate" : "attr"]({
                    width: a,
                    height: b
                }); e--;) d[e].align()
        },
        g: function(a) {
            var b = this.createElement("g");
            return s(a) ? b.attr({
                "class": "highcharts-" + a
            }) : b
        },
        image: function(a, b, c, d, e) {
            var f = {
                preserveAspectRatio: da
            };
            arguments.length > 1 && z(f, {
                x: b,
                y: c,
                width: d,
                height: e
            });
            f = this.createElement("image").attr(f);
            f.element.setAttributeNS ? f.element.setAttributeNS("http://www.w3.org/1999/xlink", "href", a) : f.element.setAttribute("hc-svg-href", a);
            return f
        },
        symbol: function(a, b, c, d, e, f) {
            var g, h = this.symbols[a],
                h = h && h(u(b), u(c), d, e, f),
                k = /^url\((.*?)\)$/,
                i, j;
            h ? (g = this.path(h), z(g, {
                symbolName: a,
                x: b,
                y: c,
                width: d,
                height: e
            }), f && z(g, f)) : k.test(a) && (j = function(a, b) {
                a.attr({
                    width: b[0],
                    height: b[1]
                });
                a.alignByTranslate || a.translate(-u(b[0] / 2), -u(b[1] / 2))
            }, i = a.match(k)[1], a = Qb[i], g = this.image(i).attr({
                x: b,
                y: c
            }), a ? j(g, a) : (g.attr({
                width: 0,
                height: 0
            }), V("img", {
                onload: function() {
                    j(g, Qb[i] = [this.width, this.height])
                },
                src: i
            })));
            return g
        },
        symbols: {
            circle: function(a, b, c, d) {
                var e = 0.166 * c;
                return ["M", a + c / 2, b, "C", a + c + e, b, a + c + e, b + d, a + c / 2, b + d, "C", a - e, b + d, a - e, b, a + c / 2, b, "Z"]
            },
            square: function(a, b, c, d) {
                return ["M", a, b, "L", a + c, b, a + c, b + d, a, b + d, "Z"]
            },
            triangle: function(a, b, c, d) {
                return ["M", a + c / 2, b, "L", a + c, b + d, a, b + d, "Z"]
            },
            "triangle-down": function(a, b, c, d) {
                return ["M", a, b, "L", a + c, b, a + c / 2, b + d, "Z"]
            },
            diamond: function(a, b, c, d) {
                return ["M", a + c / 2, b, "L", a + c, b + d / 2, a + c / 2, b + d, a, b + d / 2, "Z"]
            },
            arc: function(a, b, c, d, e) {
                var f = e.start,
                    c = e.r || c || d,
                    g = e.end - 1.0E-6,
                    d = e.innerR,
                    h = e.open,
                    k = ga(f),
                    i = ka(f),
                    j = ga(g),
                    g = ka(g),
                    e = e.end - f < Ha ? 0 : 1;
                return ["M", a + c * k, b + c * i, "A", c, c, 0, e, 1, a + c * j, b + c * g, h ? "M" : "L", a + d * j, b + d * g, "A", d, d, 0, e, 0, a + d * k, b + d * i, h ? "" : "Z"]
            }
        },
        clipRect: function(a, b, c, d) {
            var e = "highcharts-" + yb++,
                f = this.createElement("clipPath").attr({
                    id: e
                }).add(this.defs),
                a = this.rect(a, b, c, d, 0).add(f);
            a.id = e;
            a.clipPath = f;
            return a
        },
        color: function(a, b, c) {
            var d = this,
                e, f = /^rgba/,
                g;
            a && a.linearGradient ? g = "linearGradient" : a && a.radialGradient && (g = "radialGradient");
            if (g) {
                var c = a[g],
                    h = d.gradients,
                    k, i, j, b = b.radialReference;
                if (!c.id || !h[c.id]) Va(c) && (a[g] = c = {
                    x1: c[0],
                    y1: c[1],
                    x2: c[2],
                    y2: c[3],
                    gradientUnits: "userSpaceOnUse"
                }), g === "radialGradient" && b && !s(c.gradientUnits) && z(c, {
                    cx: b[0] - b[2] / 2 + c.cx * b[2],
                    cy: b[1] - b[2] / 2 + c.cy * b[2],
                    r: c.r * b[2],
                    gradientUnits: "userSpaceOnUse"
                }), c.id = "highcharts-" + yb++, h[c.id] = k = d.createElement(g).attr(c).add(d.defs), k.stops = [], n(a.stops, function(a) {
                    f.test(a[1]) ? (e = wa(a[1]), i = e.get("rgb"), j = e.get("a")) : (i = a[1], j = 1);
                    a = d.createElement("stop").attr({
                        offset: a[0],
                        "stop-color": i,
                        "stop-opacity": j
                    }).add(k);
                    k.stops.push(a)
                });
                return "url(" + d.url + "#" + c.id + ")"
            } else return f.test(a) ? (e = wa(a), G(b, c + "-opacity", e.get("a")), e.get("rgb")) : (b.removeAttribute(c + "-opacity"), a)
        },
        text: function(a, b, c, d) {
            var e = T.chart.style;
            if (d && !this.forExport) return this.html(a, b, c);
            b = u(p(b, 0));
            c = u(p(c, 0));
            a = this.createElement("text").attr({
                x: b,
                y: c,
                text: a
            }).css({
                fontFamily: e.fontFamily,
                fontSize: e.fontSize
            });
            a.x = b;
            a.y = c;
            return a
        },
        html: function(a, b, c) {
            var d = T.chart.style,
                e = this.createElement("span"),
                f = e.attrSetters,
                g = e.element,
                h = e.renderer;
            f.text = function(a) {
                g.innerHTML = a;
                return !1
            };
            f.x = f.y = f.align = function(a, b) {
                b === "align" && (b = "textAlign");
                e[b] = a;
                e.htmlUpdateTransform();
                return !1
            };
            e.attr({
                text: a,
                x: u(b),
                y: u(c)
            }).css({
                position: "absolute",
                whiteSpace: "nowrap",
                fontFamily: d.fontFamily,
                fontSize: d.fontSize
            });
            e.css = e.htmlCss;
            if (h.isSVG) e.add = function(a) {
                var b, c, d = h.box.parentNode;
                if (a) {
                    if (b = a.div, !b) b = a.div = V(oa, {
                        className: G(a.element, "class")
                    }, {
                        position: "absolute",
                        left: a.attr("translateX") + "px",
                        top: a.attr("translateY") + "px"
                    }, d), c = b.style, z(a.attrSetters, {
                        translateX: function(a) {
                            c.left = a + "px"
                        },
                        translateY: function(a) {
                            c.top = a + "px"
                        },
                        visibility: function(a, b) {
                            c[b] = a
                        }
                    })
                } else b = d;
                b.appendChild(g);
                e.added = !0;
                e.alignOnAdd && e.htmlUpdateTransform();
                return e
            };
            return e
        },
        fontMetrics: function(a) {
            var a = F(a || 11),
                a = a < 24 ? a + 4 : u(a * 1.2),
                b = u(a * 0.8);
            return {
                h: a,
                b: b
            }
        },
        label: function(a, b, c, d, e, f, g, h, k) {
            function i() {
                var a = o.styles,
                    a = a && a.textAlign,
                    b = J * (1 - p),
                    c;
                c = h ? 0 : Sa;
                if (s(w) && (a === "center" || a === "right")) b += {
                    center: 0.5,
                    right: 1
                } [a] * (w - q.width);
                (b !== r.x || c !== r.y) && r.attr({
                    x: b,
                    y: c
                });
                r.x = b;
                r.y = c
            }

            function j(a, b) {
                A ? A.attr(a, b) : t[a] = b
            }

            function l() {
                o.attr({
                    text: a,
                    x: b,
                    y: c
                });
                s(e) && o.attr({
                    anchorX: e,
                    anchorY: f
                })
            }
            var m = this,
                o = m.g(k),
                r = m.text("", 0, 0, g).attr({
                    zIndex: 1
                }).add(o),
                A, q, p = 0,
                J = 3,
                w, x, D, K, H = 0,
                t = {},
                Sa, g = o.attrSetters;
            B(o, "add", l);
            g.width = function(a) {
                w = a;
                return !1
            };
            g.height = function(a) {
                x = a;
                return !1
            };
            g.padding = function(a) {
                s(a) && a !== J && (J = a, i());
                return !1
            };
            g.align = function(a) {
                p = {
                    left: 0,
                    center: 0.5,
                    right: 1
                } [a];
                return !1
            };
            g.text = function(a, b) {
                r.attr(b, a);
                var c;
                c = r.element.style;
                q = (w === void 0 || x === void 0 || o.styles.textAlign) && r.getBBox(!0);
                o.width = (w || q.width || 0) + 2 * J;
                o.height = (x || q.height || 0) + 2 * J;
                Sa = J + m.fontMetrics(c && c.fontSize).b;
                if (!A) c = h ? -Sa : 0, o.box = A = d ? m.symbol(d, -p * J, c, o.width, o.height) : m.rect(-p * J, c, o.width, o.height, 0, t["stroke-width"]), A.add(o);
                A.attr(y({
                    width: o.width,
                    height: o.height
                }, t));
                t = null;
                i();
                return !1
            };
            g["stroke-width"] = function(a, b) {
                H = a % 2 / 2;
                j(b, a);
                return !1
            };
            g.stroke = g.fill = g.r = function(a, b) {
                j(b, a);
                return !1
            };
            g.anchorX = function(a, b) {
                e = a;
                j(b, a + H - D);
                return !1
            };
            g.anchorY = function(a, b) {
                f = a;
                j(b, a - K);
                return !1
            };
            g.x = function(a) {
                o.x = a;
                a -= p * ((w || q.width) + J);
                D = u(a);
                o.attr("translateX", D);
                return !1
            };
            g.y = function(a) {
                K = o.y = u(a);
                o.attr("translateY", a);
                return !1
            };
            var cc = o.css;
            return z(o, {
                css: function(a) {
                    if (a) {
                        var b = {},
                            a = y({}, a);
                        n("fontSize,fontWeight,fontFamily,color,lineHeight,width".split(","), function(c) {
                            a[c] !== v && (b[c] = a[c], delete a[c])
                        });
                        r.css(b)
                    }
                    return cc.call(o, a)
                },
                getBBox: function() {
                    return A.getBBox()
                },
                shadow: function(a) {
                    A.shadow(a);
                    return o
                },
                destroy: function() {
                    Q(o, "add", l);
                    Q(o.element, "mouseenter");
                    Q(o.element, "mouseleave");
                    r && (r = r.destroy());
                    Fa.prototype.destroy.call(o)
                }
            })
        }
    };
    Qa = qa;
    var Ja;
    if (!Pa && !ma) {
        var ea = {
                init: function(a, b) {
                    var c = ["<", b, ' filled="f" stroked="f"'],
                        d = ["position: ", "absolute", ";"];
                    (b === "shape" || b === oa) && d.push("left:0;top:0;width:1px;height:1px;");
                    Oa && d.push("visibility: ", b === oa ? "hidden" : "visible");
                    c.push(' style="', d.join(""), '"/>');
                    if (b) c = b === oa || b === "span" || b === "img" ? c.join("") : a.prepVML(c), this.element = V(c);
                    this.renderer = a;
                    this.attrSetters = {}
                },
                add: function(a) {
                    var b = this.renderer,
                        c = this.element,
                        d = b.box,
                        d = a ? a.element || a : d;
                    a && a.inverted && b.invertChild(c, d);
                    Oa && d.gVis === "hidden" && M(c, {
                        visibility: "hidden"
                    });
                    d.appendChild(c);
                    this.added = !0;
                    this.alignOnAdd && !this.deferUpdateTransform && this.updateTransform();
                    N(this, "add");
                    return this
                },
                toggleChildren: function(a, b) {
                    for (var c = a.childNodes, d = c.length; d--;) M(c[d], {
                        visibility: b
                    }), c[d].nodeName === "DIV" && this.toggleChildren(c[d], b)
                },
                updateTransform: Fa.prototype.htmlUpdateTransform,
                attr: function(a, b) {
                    var c, d, e, f = this.element || {},
                        g = f.style,
                        h = f.nodeName,
                        k = this.renderer,
                        i = this.symbolName,
                        j, l = this.shadows,
                        m, o = this.attrSetters,
                        r = this;
                    ya(a) && s(b) && (c = a, a = {}, a[c] = b);
                    if (ya(a)) c = a, r = c === "strokeWidth" || c === "stroke-width" ? this.strokeweight : this[c];
                    else
                        for (c in a)
                            if (d = a[c], m = !1, e = o[c] && o[c](d, c), e !== !1 && d !== null) {
                                e !== v && (d = e);
                                if (i && /^(x|y|r|start|end|width|height|innerR|anchorX|anchorY)/.test(c)) j || (this.symbolAttr(a), j = !0), m = !0;
                                else if (c === "d") {
                                    d = d || [];
                                    this.d = d.join(" ");
                                    e = d.length;
                                    for (m = []; e--;) m[e] = Wa(d[e]) ? u(d[e] * 10) - 5 : d[e] === "Z" ? "x" : d[e];
                                    d = m.join(" ") || "x";
                                    f.path = d;
                                    if (l)
                                        for (e = l.length; e--;) l[e].path = l[e].cutOff ? this.cutOffPath(d, l[e].cutOff) : d;
                                    m = !0
                                } else if (c === "zIndex" || c === "visibility") {
                                    if (Oa && c === "visibility" && h === "DIV") f.gVis = d, this.toggleChildren(f, d), d === "visible" && (d = null);
                                    d && (g[c] = d);
                                    m = !0
                                } else if (c === "width" || c === "height") d = t(0, d), this[c] = d, this.updateClipping ? (this[c] = d, this.updateClipping()) : g[c] = d, m = !0;
                                else if (c === "x" || c === "y") this[c] = d, g[{
                                    x: "left",
                                    y: "top"
                                } [c]] = d;
                                else if (c === "class") f.className = d;
                                else if (c === "stroke") d = k.color(d, f, c), c = "strokecolor";
                                else if (c === "stroke-width" || c === "strokeWidth") f.stroked = d ? !0 : !1, c = "strokeweight", this[c] = d, Wa(d) && (d += "px");
                                else if (c === "dashstyle")(f.getElementsByTagName("stroke")[0] || V(k.prepVML(["<stroke/>"]), null, null, f))[c] = d || "solid", this.dashstyle = d, m = !0;
                                else if (c === "fill") h === "SPAN" ? g.color = d : (f.filled = d !== da ? !0 : !1, d = k.color(d, f, c), c = "fillcolor");
                                else if (h === "shape" && c === "rotation") this[c] = d;
                                else if (c === "translateX" || c === "translateY" || c === "rotation") this[c] = d, this.updateTransform(), m = !0;
                                else if (c === "text") this.bBox = null, f.innerHTML = d, m = !0;
                                if (l && c === "visibility")
                                    for (e = l.length; e--;) l[e].style[c] = d;
                                m || (Oa ? f[c] = d : G(f, c, d))
                            } return r
                },
                clip: function(a) {
                    var b = this,
                        c = a.members,
                        d = b.element,
                        e = d.parentNode;
                    c.push(b);
                    b.destroyClip = function() {
                        Ka(c, b)
                    };
                    e && e.className === "highcharts-tracker" && !Oa && M(d, {
                        visibility: "hidden"
                    });
                    return b.css(a.getCSS(b))
                },
                css: Fa.prototype.htmlCss,
                safeRemoveChild: function(a) {
                    a.parentNode && Na(a)
                },
                destroy: function() {
                    this.destroyClip && this.destroyClip();
                    return Fa.prototype.destroy.apply(this)
                },
                empty: function() {
                    for (var a = this.element.childNodes, b = a.length, c; b--;) c = a[b], c.parentNode.removeChild(c)
                },
                on: function(a, b) {
                    this.element["on" + a] = function() {
                        var a = Y.event;
                        a.target = a.srcElement;
                        b(a)
                    };
                    return this
                },
                cutOffPath: function(a, b) {
                    var c, a = a.split(/[ ,]/);
                    c = a.length;
                    if (c === 9 || c === 11) a[c - 4] = a[c - 2] = F(a[c - 2]) - 10 * b;
                    return a.join(" ")
                },
                shadow: function(a, b, c) {
                    var d = [],
                        e = this.element,
                        f = this.renderer,
                        g, h = e.style,
                        k, i = e.path,
                        j, l;
                    i && typeof i.value !== "string" && (i = "x");
                    l = i;
                    if (a) {
                        for (a = 1; a <= 3; a++) {
                            j = 7 - 2 * a;
                            c && (l = this.cutOffPath(i.value, j + 0.5));
                            k = ['<shape isShadow="true" strokeweight="', 7 - 2 * a, '" filled="false" path="', l, '" coordsize="10 10" style="', e.style.cssText, '" />'];
                            g = V(f.prepVML(k), null, {
                                left: F(h.left) + 1,
                                top: F(h.top) + 1
                            });
                            if (c) g.cutOff = j + 1;
                            k = ['<stroke color="black" opacity="', 0.05 * a, '"/>'];
                            V(f.prepVML(k), null, null, g);
                            b ? b.element.appendChild(g) : e.parentNode.insertBefore(g, e);
                            d.push(g)
                        }
                        this.shadows = d
                    }
                    return this
                }
            },
            ea = ca(Fa, ea),
            ea = {
                Element: ea,
                isIE8: Ia.indexOf("MSIE 8.0") > -1,
                init: function(a, b, c) {
                    var d, e;
                    this.alignedObjects = [];
                    d = this.createElement(oa);
                    e = d.element;
                    e.style.position = "relative";
                    a.appendChild(d.element);
                    this.box = e;
                    this.boxWrapper = d;
                    this.setSize(b, c, !1);
                    if (!I.namespaces.hcv) I.namespaces.add("hcv", "urn:schemas-microsoft-com:vml"), I.createStyleSheet().cssText = "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } "
                },
                isHidden: function() {
                    return !this.box.offsetWidth
                },
                clipRect: function(a, b, c, d) {
                    var e = this.createElement();
                    return z(e, {
                        members: [],
                        left: a,
                        top: b,
                        width: c,
                        height: d,
                        getCSS: function(a) {
                            var b = a.inverted,
                                c = this.top,
                                d = this.left,
                                e = d + this.width,
                                j = c + this.height,
                                c = {
                                    clip: "rect(" + u(b ? d : c) + "px," + u(b ? j : e) + "px," + u(b ? e : j) + "px," + u(b ? c : d) + "px)"
                                };
                            !b && Oa && a.element.nodeName !== "IMG" && z(c, {
                                width: e + "px",
                                height: j + "px"
                            });
                            return c
                        },
                        updateClipping: function() {
                            n(e.members, function(a) {
                                a.css(e.getCSS(a))
                            })
                        }
                    })
                },
                color: function(a, b, c) {
                    var d, e = /^rgba/,
                        f, g = da;
                    a && a.linearGradient ? f = "gradient" : a && a.radialGradient && (f = "pattern");
                    if (f) {
                        var h, k, i = a.linearGradient || a.radialGradient,
                            j, l, m, o, r, A, q = "",
                            a = a.stops,
                            p, J = [];
                        l = a[0];
                        p = a[a.length - 1];
                        l[0] > 0 && a.unshift([0, l[1]]);
                        p[0] < 1 && a.push([1, p[1]]);
                        n(a, function(a, b) {
                            e.test(a[1]) ? (d = wa(a[1]), h = d.get("rgb"), k = d.get("a")) : (h = a[1], k = 1);
                            J.push(a[0] * 100 + "% " + h);
                            b ? (o = k, r = h) : (m = k, A = h)
                        });
                        f === "gradient" ? (j = i.x1 || i[0] || 0, a = i.y1 || i[1] || 0, l = i.x2 || i[2] || 0, i = i.y2 || i[3] || 0, j = 90 - R.atan((i - a) / (l - j)) * 180 / Ha) : (g = i.r * 2, q = 'src="http://code.highcharts.com/gfx/radial-gradient.png" size="' + g + "," + g + '" origin="0.5,0.5" position="' + i.cx + "," + i.cy + '" color2="' + A + '" ', g = r);
                        c === "fill" ? (c = ['<fill colors="' + J.join(",") + '" angle="', j, '" opacity="', o, '" o:opacity2="', m, '" type="', f, '" ', q, 'focus="100%" method="any" />'], V(this.prepVML(c), null, null, b)) : g = h
                    } else if (e.test(a) && b.tagName !== "IMG") d = wa(a), c = ["<", c, ' opacity="', d.get("a"), '"/>'], V(this.prepVML(c), null, null, b), g = d.get("rgb");
                    else {
                        b = b.getElementsByTagName(c);
                        if (b.length) b[0].opacity = 1;
                        g = a
                    }
                    return g
                },
                prepVML: function(a) {
                    var b = this.isIE8,
                        a = a.join("");
                    b ? (a = a.replace("/>", ' xmlns="urn:schemas-microsoft-com:vml" />'), a = a.indexOf('style="') === -1 ? a.replace("/>", ' style="display:inline-block;behavior:url(#default#VML);" />') : a.replace('style="', 'style="display:inline-block;behavior:url(#default#VML);')) : a = a.replace("<", "<hcv:");
                    return a
                },
                text: qa.prototype.html,
                path: function(a) {
                    var b = {
                        coordsize: "10 10"
                    };
                    Va(a) ? b.d = a : ia(a) && z(b, a);
                    return this.createElement("shape").attr(b)
                },
                circle: function(a, b, c) {
                    return this.symbol("circle").attr({
                        x: a - c,
                        y: b - c,
                        width: 2 * c,
                        height: 2 * c
                    })
                },
                g: function(a) {
                    var b;
                    a && (b = {
                        className: "highcharts-" + a,
                        "class": "highcharts-" + a
                    });
                    return this.createElement(oa).attr(b)
                },
                image: function(a, b, c, d, e) {
                    var f = this.createElement("img").attr({
                        src: a
                    });
                    arguments.length > 1 && f.css({
                        left: b,
                        top: c,
                        width: d,
                        height: e
                    });
                    return f
                },
                rect: function(a, b, c, d, e, f) {
                    if (ia(a)) b = a.y, c = a.width, d = a.height, f = a.strokeWidth, a = a.x;
                    var g = this.symbol("rect");
                    g.r = e;
                    return g.attr(g.crisp(f, a, b, t(c, 0), t(d, 0)))
                },
                invertChild: function(a, b) {
                    var c = b.style;
                    M(a, {
                        flip: "x",
                        left: F(c.width) - 1,
                        top: F(c.height) - 1,
                        rotation: -90
                    })
                },
                symbols: {
                    arc: function(a, b, c, d, e) {
                        var f = e.start,
                            g = e.end,
                            h = e.r || c || d,
                            c = ga(f),
                            d = ka(f),
                            k = ga(g),
                            i = ka(g),
                            j = e.innerR,
                            l = 0.08 / h,
                            m = j && 0.1 / j || 0;
                        if (g - f === 0) return ["x"];
                        else 2 * Ha - g + f < l ? k = -l : g - f < m && (k = ga(f + m));
                        f = ["wa", a - h, b - h, a + h, b + h, a + h * c, b + h * d, a + h * k, b + h * i];
                        e.open && f.push("M", a - j, b - j);
                        f.push("at", a - j, b - j, a + j, b + j, a + j * k, b + j * i, a + j * c, b + j * d, "x", "e");
                        return f
                    },
                    circle: function(a, b, c, d) {
                        return ["wa", a, b, a + c, b + d, a + c, b + d / 2, a + c, b + d / 2, "e"]
                    },
                    rect: function(a, b, c, d, e) {
                        var f = a + c,
                            g = b + d,
                            h;
                        !s(e) || !e.r ? f = qa.prototype.symbols.square.apply(0, arguments) : (h = O(e.r, c, d), f = ["M", a + h, b, "L", f - h, b, "wa", f - 2 * h, b, f, b + 2 * h, f - h, b, f, b + h, "L", f, g - h, "wa", f - 2 * h, g - 2 * h, f, g, f, g - h, f - h, g, "L", a + h, g, "wa", a, g - 2 * h, a + 2 * h, g, a + h, g, a, g - h, "L", a, b + h, "wa", a, b, a + 2 * h, b + 2 * h, a, b + h, a + h, b, "x", "e"]);
                        return f
                    }
                }
            };
        Ja = function() {
            this.init.apply(this, arguments)
        };
        Ja.prototype = y(qa.prototype, ea);
        Qa = Ja
    }
    var mb, Xb;
    if (ma) mb = function() {}, mb.prototype.symbols = {}, Xb = function() {
        function a() {
            var a = b.length,
                d;
            for (d = 0; d < a; d++) b[d]();
            b = []
        }
        var b = [];
        return {
            push: function(c, d) {
                b.length === 0 && Sb(d, a);
                b.push(c)
            }
        }
    }();
    Qa = Ja || mb || qa;
    ab.prototype = {
        addLabel: function() {
            var a = this.axis,
                b = a.options,
                c = a.chart,
                d = a.horiz,
                e = a.categories,
                f = this.pos,
                g = b.labels,
                h = a.tickPositions,
                d = e && d && e.length && !g.step && !g.staggerLines && !g.rotation && c.plotWidth / h.length || !d && c.plotWidth / 2,
                k = f === h[0],
                i = f === h[h.length - 1],
                j = e && s(e[f]) ? e[f] : f,
                e = this.label,
                h = h.info,
                l;
            a.isDatetimeAxis && h && (l = b.dateTimeLabelFormats[h.higherRanks[f] || h.unitName]);
            this.isFirst = k;
            this.isLast = i;
            b = a.labelFormatter.call({
                axis: a,
                chart: c,
                isFirst: k,
                isLast: i,
                dateTimeLabelFormat: l,
                value: a.isLog ? pa(ja(j)) : j
            });
            f = d && {
                width: t(1, u(d - 2 * (g.padding || 10))) + "px"
            };
            f = z(f, g.style);
            if (s(e)) e && e.attr({
                text: b
            }).css(f);
            else {
                d = {
                    align: g.align
                };
                if (Wa(g.rotation)) d.rotation = g.rotation;
                this.label = s(b) && g.enabled ? c.renderer.text(b, 0, 0, g.useHTML).attr(d).css(f).add(a.axisGroup) : null
            }
        },
        getLabelSize: function() {
            var a = this.label,
                b = this.axis;
            return a ? (this.labelBBox = a.getBBox(!0))[b.horiz ? "height" : "width"] : 0
        },
        getLabelSides: function() {
            var a = this.axis.options.labels,
                b = this.labelBBox.width,
                a = b * {
                    left: 0,
                    center: 0.5,
                    right: 1
                } [a.align] - a.x;
            return [-a, b - a]
        },
        handleOverflow: function(a, b) {
            var c = !0,
                d = this.axis,
                e = d.chart,
                f = this.isFirst,
                g = this.isLast,
                h = b.x,
                k = d.reversed,
                i = d.tickPositions;
            if (f || g) {
                var j = this.getLabelSides(),
                    l = j[0],
                    j = j[1],
                    e = e.plotLeft,
                    m = e + d.len,
                    i = (d = d.ticks[i[a + (f ? 1 : -1)]]) && d.label.xy.x + d.getLabelSides()[f ? 0 : 1];
                f && !k || g && k ? h + l < e && (h = e - l, d && h + j > i && (c = !1)) : h + j > m && (h = m - j, d && h + l < i && (c = !1));
                b.x = h
            }
            return c
        },
        getPosition: function(a, b, c, d) {
            var e = this.axis,
                f = e.chart,
                g = d && f.oldChartHeight || f.chartHeight;
            return {
                x: a ? e.translate(b + c, null, null, d) + e.transB : e.left + e.offset + (e.opposite ? (d && f.oldChartWidth || f.chartWidth) - e.right - e.left : 0),
                y: a ? g - e.bottom + e.offset - (e.opposite ? e.height : 0) : g - e.translate(b + c, null, null, d) - e.transB
            }
        },
        getLabelPosition: function(a, b, c, d, e, f, g, h) {
            var k = this.axis,
                i = k.transA,
                j = k.reversed,
                k = k.staggerLines,
                a = a + e.x - (f && d ? f * i * (j ? -1 : 1) : 0),
                b = b + e.y - (f && !d ? f * i * (j ? 1 : -1) : 0);
            s(e.y) || (b += F(c.styles.lineHeight) * 0.9 - c.getBBox().height / 2);
            k && (b += g / (h || 1) % k * 16);
            return {
                x: a,
                y: b
            }
        },
        getMarkPath: function(a, b, c, d, e, f) {
            return f.crispLine(["M", a, b, "L", a + (e ? 0 : -c), b + (e ? c : 0)], d)
        },
        render: function(a, b) {
            var c = this.axis,
                d = c.options,
                e = c.chart.renderer,
                f = c.horiz,
                g = this.type,
                h = this.label,
                k = this.pos,
                i = d.labels,
                j = this.gridLine,
                l = g ? g + "Grid" : "grid",
                m = g ? g + "Tick" : "tick",
                o = d[l + "LineWidth"],
                r = d[l + "LineColor"],
                A = d[l + "LineDashStyle"],
                q = d[m + "Length"],
                l = d[m + "Width"] || 0,
                n = d[m + "Color"],
                J = d[m + "Position"],
                m = this.mark,
                w = i.step,
                x = !0,
                D = d.categories && d.tickmarkPlacement === "between" ? 0.5 : 0,
                K = this.getPosition(f, k, D, b),
                H = K.x,
                K = K.y,
                s = c.staggerLines;
            if (o) {
                k = c.getPlotLinePath(k + D, o, b);
                if (j === v) {
                    j = {
                        stroke: r,
                        "stroke-width": o
                    };
                    if (A) j.dashstyle = A;
                    if (!g) j.zIndex = 1;
                    this.gridLine = j = o ? e.path(k).attr(j).add(c.gridGroup) : null
                }
                if (!b && j && k) j[this.isNew ? "attr" : "animate"]({
                    d: k
                })
            }
            if (l) J === "inside" && (q = -q), c.opposite && (q = -q), g = this.getMarkPath(H, K, q, l, f, e), m ? m.animate({
                d: g
            }) : this.mark = e.path(g).attr({
                stroke: n,
                "stroke-width": l
            }).add(c.axisGroup);
            if (h && !isNaN(H)) h.xy = K = this.getLabelPosition(H, K, h, f, i, D, a, w), this.isFirst && !p(d.showFirstLabel, 1) || this.isLast && !p(d.showLastLabel, 1) ? x = !1 : !s && f && i.overflow === "justify" && !this.handleOverflow(a, K) && (x = !1), w && a % w && (x = !1), x ? (h[this.isNew ? "attr" : "animate"](K), h.show(), this.isNew = !1) : h.hide()
        },
        destroy: function() {
            ta(this, this.axis)
        }
    };
    vb.prototype = {
        render: function() {
            var a = this,
                b = a.axis,
                c = b.horiz,
                d = (b.pointRange || 0) / 2,
                e = a.options,
                f = e.label,
                g = a.label,
                h = e.width,
                k = e.to,
                i = e.from,
                j = s(i) && s(k),
                l = e.value,
                m = e.dashStyle,
                o = a.svgElem,
                r = [],
                A, q = e.color,
                n = e.zIndex,
                J = e.events,
                w = b.chart.renderer;
            b.isLog && (i = ra(i), k = ra(k), l = ra(l));
            if (h) {
                if (r = b.getPlotLinePath(l, h), d = {
                        stroke: q,
                        "stroke-width": h
                    }, m) d.dashstyle = m
            } else if (j) {
                if (i = t(i, b.min - d), k = O(k, b.max + d), r = b.getPlotBandPath(i, k, e), d = {
                        fill: q
                    }, e.borderWidth) d.stroke = e.borderColor, d["stroke-width"] = e.borderWidth
            } else return;
            if (s(n)) d.zIndex = n;
            if (o) r ? o.animate({
                d: r
            }, null, o.onGetPath) : (o.hide(), o.onGetPath = function() {
                o.show()
            });
            else if (r && r.length && (a.svgElem = o = w.path(r).attr(d).add(), J))
                for (A in e = function(b) {
                        o.on(b, function(c) {
                            J[b].apply(a, [c])
                        })
                    }, J) e(A);
            if (f && s(f.text) && r && r.length && b.width > 0 && b.height > 0) {
                f = y({
                    align: c && j && "center",
                    x: c ? !j && 4 : 10,
                    verticalAlign: !c && j && "middle",
                    y: c ? j ? 16 : 10 : j ? 6 : -4,
                    rotation: c && !j && 90
                }, f);
                if (!g) a.label = g = w.text(f.text, 0, 0).attr({
                    align: f.textAlign || f.align,
                    rotation: f.rotation,
                    zIndex: n
                }).css(f.style).add();
                b = [r[1], r[4], p(r[6], r[1])];
                r = [r[2], r[5], p(r[7], r[2])];
                c = Ma(b);
                j = Ma(r);
                g.align(f, !1, {
                    x: c,
                    y: j,
                    width: Da(b) - c,
                    height: Da(r) - j
                });
                g.show()
            } else g && g.hide();
            return a
        },
        destroy: function() {
            Ka(this.axis.plotLinesAndBands, this);
            ta(this, this.axis)
        }
    };
    Jb.prototype = {
        destroy: function() {
            ta(this, this.axis)
        },
        setTotal: function(a) {
            this.cum = this.total = a
        },
        render: function(a) {
            var b = this.options.formatter.call(this);
            this.label ? this.label.attr({
                text: b,
                visibility: "hidden"
            }) : this.label = this.axis.chart.renderer.text(b, 0, 0).css(this.options.style).attr({
                align: this.textAlign,
                rotation: this.options.rotation,
                visibility: "hidden"
            }).add(a)
        },
        setOffset: function(a, b) {
            var c = this.axis,
                d = c.chart,
                e = d.inverted,
                f = this.isNegative,
                g = c.translate(this.total, 0, 0, 0, 1),
                c = c.translate(0),
                c = W(g - c),
                h = d.xAxis[0].translate(this.x) + a,
                d = d.plotHeight,
                e = {
                    x: e ? f ? g : g - c : h,
                    y: e ? d - h - b : f ? d - g - c : d - g,
                    width: e ? c : b,
                    height: e ? b : c
                };
            this.label && this.label.align(this.alignOptions, null, e).attr({
                visibility: "visible"
            })
        }
    };
    bb.prototype = {
        defaultOptions: {
            dateTimeLabelFormats: {
                millisecond: "%H:%M:%S.%L",
                second: "%H:%M:%S",
                minute: "%H:%M",
                hour: "%H:%M",
                day: "%e. %b",
                week: "%e. %b",
                month: "%b '%y",
                year: "%Y"
            },
            endOnTick: !1,
            gridLineColor: "#C0C0C0",
            labels: L,
            lineColor: "#C0D0E0",
            lineWidth: 1,
            minPadding: 0.01,
            maxPadding: 0.01,
            minorGridLineColor: "#E0E0E0",
            minorGridLineWidth: 1,
            minorTickColor: "#A0A0A0",
            minorTickLength: 2,
            minorTickPosition: "outside",
            startOfWeek: 1,
            startOnTick: !1,
            tickColor: "#C0D0E0",
            tickLength: 5,
            tickmarkPlacement: "between",
            tickPixelInterval: 100,
            tickPosition: "outside",
            tickWidth: 1,
            title: {
                align: "middle",
                style: {
                    color: "#6D869F",
                    fontWeight: "bold"
                }
            },
            type: "linear"
        },
        defaultYAxisOptions: {
            endOnTick: !0,
            gridLineWidth: 1,
            tickPixelInterval: 72,
            showLastLabel: !0,
            labels: {
                align: "right",
                x: -8,
                y: 3
            },
            lineWidth: 0,
            maxPadding: 0.05,
            minPadding: 0.05,
            startOnTick: !0,
            tickWidth: 0,
            title: {
                rotation: 270,
                text: "Y-values"
            },
            stackLabels: {
                enabled: !1,
                formatter: function() {
                    return this.total
                },
                style: L.style
            }
        },
        defaultLeftAxisOptions: {
            labels: {
                align: "right",
                x: -8,
                y: null
            },
            title: {
                rotation: 270
            }
        },
        defaultRightAxisOptions: {
            labels: {
                align: "left",
                x: 8,
                y: null
            },
            title: {
                rotation: 90
            }
        },
        defaultBottomAxisOptions: {
            labels: {
                align: "center",
                x: 0,
                y: 14
            },
            title: {
                rotation: 0
            }
        },
        defaultTopAxisOptions: {
            labels: {
                align: "center",
                x: 0,
                y: -5
            },
            title: {
                rotation: 0
            }
        },
        init: function(a, b) {
            var c = b.isX;
            this.horiz = a.inverted ? !c : c;
            this.xOrY = (this.isXAxis = c) ? "x" : "y";
            this.opposite = b.opposite;
            this.side = this.horiz ? this.opposite ? 0 : 2 : this.opposite ? 1 : 3;
            this.setOptions(b);
            var d = this.options,
                e = d.type,
                f = e === "datetime";
            this.labelFormatter = d.labels.formatter || this.defaultLabelFormatter;
            this.staggerLines = this.horiz && d.labels.staggerLines;
            this.userOptions = b;
            this.minPixelPadding = 0;
            this.chart = a;
            this.reversed = d.reversed;
            this.categories = d.categories;
            this.isLog = e === "logarithmic";
            this.isLinked = s(d.linkedTo);
            this.isDatetimeAxis = f;
            this.ticks = {};
            this.minorTicks = {};
            this.plotLinesAndBands = [];
            this.alternateBands = {};
            this.len = 0;
            this.minRange = this.userMinRange = d.minRange || d.maxZoom;
            this.range = d.range;
            this.offset = d.offset || 0;
            this.stacks = {};
            this.min = this.max = null;
            var g, d = this.options.events;
            a.axes.push(this);
            a[c ? "xAxis" : "yAxis"].push(this);
            this.series = [];
            if (a.inverted && c && this.reversed === v) this.reversed = !0;
            this.removePlotLine = this.removePlotBand = this.removePlotBandOrLine;
            this.addPlotLine = this.addPlotBand = this.addPlotBandOrLine;
            for (g in d) B(this, g, d[g]);
            if (this.isLog) this.val2lin = ra, this.lin2val = ja
        },
        setOptions: function(a) {
            this.options = y(this.defaultOptions, this.isXAxis ? {} : this.defaultYAxisOptions, [this.defaultTopAxisOptions, this.defaultRightAxisOptions, this.defaultBottomAxisOptions, this.defaultLeftAxisOptions][this.side], a)
        },
        defaultLabelFormatter: function() {
            var a = this.axis,
                b = this.value,
                c = a.tickInterval,
                d = this.dateTimeLabelFormat;
            return a.categories ? b : d ? ua(d, b) : c % 1E6 === 0 ? b / 1E6 + "M" : c % 1E3 === 0 ? b / 1E3 + "k" : b >= 1E3 ? Ya(b, 0) : Ya(b, -1)
        },
        getSeriesExtremes: function() {
            var a = this,
                b = a.chart,
                c = a.stacks,
                d = [],
                e = [],
                f;
            a.dataMin = a.dataMax = null;
            n(a.series, function(g) {
                if (g.visible || !b.options.chart.ignoreHiddenSeries) {
                    var h = g.options,
                        k, i, j, l, m, o, r, n, q, C = h.threshold,
                        J, w = [],
                        x = 0;
                    if (a.isLog && C <= 0) C = h.threshold = null;
                    if (a.isXAxis) {
                        if (h = g.xData, h.length) a.dataMin = O(p(a.dataMin, h[0]), Ma(h)), a.dataMax = t(p(a.dataMax, h[0]), Da(h))
                    } else {
                        var D, K, H, u = g.cropped,
                            Sa = g.xAxis.getExtremes(),
                            y = !!g.modifyValue;
                        k = h.stacking;
                        a.usePercentage = k === "percent";
                        if (k) m = h.stack, l = g.type + p(m, ""), o = "-" + l, g.stackKey = l, i = d[l] || [], d[l] = i, j = e[o] || [], e[o] = j;
                        if (a.usePercentage) a.dataMin = 0, a.dataMax = 99;
                        h = g.processedXData;
                        r = g.processedYData;
                        J = r.length;
                        for (f = 0; f < J; f++)
                            if (n = h[f], q = r[f], q !== null && q !== v && (k ? (K = (D = q < C) ? j : i, H = D ? o : l, q = K[n] = s(K[n]) ? K[n] + q : q, c[H] || (c[H] = {}), c[H][n] || (c[H][n] = new Jb(a, a.options.stackLabels, D, n, m)), c[H][n].setTotal(q)) : y && (q = g.modifyValue(q)), u || (h[f + 1] || n) >= Sa.min && (h[f - 1] || n) <= Sa.max))
                                if (n = q.length)
                                    for (; n--;) q[n] !== null && (w[x++] = q[n]);
                                else w[x++] = q;
                        if (!a.usePercentage && w.length) a.dataMin = O(p(a.dataMin, w[0]), Ma(w)), a.dataMax = t(p(a.dataMax, w[0]), Da(w));
                        if (s(C))
                            if (a.dataMin >= C) a.dataMin = C, a.ignoreMinPadding = !0;
                            else if (a.dataMax < C) a.dataMax = C, a.ignoreMaxPadding = !0
                    }
                }
            })
        },
        translate: function(a, b, c, d, e) {
            var f = this.len,
                g = 1,
                h = 0,
                k = d ? this.oldTransA : this.transA,
                d = d ? this.oldMin : this.min,
                e = this.options.ordinal || this.isLog && e;
            if (!k) k = this.transA;
            c && (g *= -1, h = f);
            this.reversed && (g *= -1, h -= g * f);
            b ? (this.reversed && (a = f - a), a = a / k + d, e && (a = this.lin2val(a))) : (e && (a = this.val2lin(a)), a = g * (a - d) * k + h + g * this.minPixelPadding);
            return a
        },
        getPlotLinePath: function(a, b, c) {
            var d = this.chart,
                e = this.left,
                f = this.top,
                g, h, k, a = this.translate(a, null, null, c),
                i = c && d.oldChartHeight || d.chartHeight,
                j = c && d.oldChartWidth || d.chartWidth,
                l;
            g = this.transB;
            c = h = u(a + g);
            g = k = u(i - a - g);
            if (isNaN(a)) l = !0;
            else if (this.horiz) {
                if (g = f, k = i - this.bottom, c < e || c > e + this.width) l = !0
            } else if (c = e, h = j - this.right, g < f || g > f + this.height) l = !0;
            return l ? null : d.renderer.crispLine(["M", c, g, "L", h, k], b || 0)
        },
        getPlotBandPath: function(a, b) {
            var c = this.getPlotLinePath(b),
                d = this.getPlotLinePath(a);
            d && c ? d.push(c[4], c[5], c[1], c[2]) : d = null;
            return d
        },
        getLinearTickPositions: function(a, b, c) {
            for (var d, b = pa($(b / a) * a), c = pa(Ga(c / a) * a), e = []; b <= c;) {
                e.push(b);
                b = pa(b + a);
                if (b === d) break;
                d = b
            }
            return e
        },
        getLogTickPositions: function(a, b, c, d) {
            var e = this.options,
                f = this.len,
                g = [];
            if (!d) this._minorAutoInterval = null;
            if (a >= 0.5) a = u(a), g = this.getLinearTickPositions(a, b, c);
            else if (a >= 0.08)
                for (var f = $(b), h, k, i, j, l, e = a > 0.3 ? [1, 2, 4] : a > 0.15 ? [1, 2, 4, 6, 8] : [1, 2, 3, 4, 5, 6, 7, 8, 9]; f < c + 1 && !l; f++) {
                    k = e.length;
                    for (h = 0; h < k && !l; h++) i = ra(ja(f) * e[h]), i > b && g.push(j), j > c && (l = !0), j = i
                } else if (b = ja(b), c = ja(c), a = e[d ? "minorTickInterval" : "tickInterval"], a = p(a === "auto" ? null : a, this._minorAutoInterval, (c - b) * (e.tickPixelInterval / (d ? 5 : 1)) / ((d ? f / this.tickPositions.length : f) || 1)), a = pb(a, null, R.pow(10, $(R.log(a) / R.LN10))), g = va(this.getLinearTickPositions(a, b, c), ra), !d) this._minorAutoInterval = a / 5;
            if (!d) this.tickInterval = a;
            return g
        },
        getMinorTickPositions: function() {
            var a = this.tickPositions,
                b = this.minorTickInterval,
                c = [],
                d, e;
            if (this.isLog) {
                e = a.length;
                for (d = 1; d < e; d++) c = c.concat(this.getLogTickPositions(b, a[d - 1], a[d], !0))
            } else
                for (a = this.min + (a[0] - this.min) % b; a <= this.max; a += b) c.push(a);
            return c
        },
        adjustForMinRange: function() {
            var a = this.options,
                b = this.min,
                c = this.max,
                d, e = this.dataMax - this.dataMin >= this.minRange,
                f, g, h, k, i;
            if (this.isXAxis && this.minRange === v && !this.isLog) s(a.min) || s(a.max) ? this.minRange = null : (n(this.series, function(a) {
                k = a.xData;
                for (g = i = a.xIncrement ? 1 : k.length - 1; g > 0; g--)
                    if (h = k[g] - k[g - 1], f === v || h < f) f = h
            }), this.minRange = O(f * 5, this.dataMax - this.dataMin));
            if (c - b < this.minRange) {
                var j = this.minRange;
                d = (j - c + b) / 2;
                d = [b - d, p(a.min, b - d)];
                if (e) d[2] = this.dataMin;
                b = Da(d);
                c = [b + j, p(a.max, b + j)];
                if (e) c[2] = this.dataMax;
                c = Ma(c);
                c - b < j && (d[0] = c - j, d[1] = p(a.min, c - j), b = Da(d))
            }
            this.min = b;
            this.max = c
        },
        setAxisTranslation: function() {
            var a = this.max - this.min,
                b = 0,
                c, d, e = this.transA;
            if (this.isXAxis) this.isLinked ? b = this.linkedParent.pointRange : n(this.series, function(a) {
                b = t(b, a.pointRange);
                d = a.closestPointRange;
                !a.noSharedTooltip && s(d) && (c = s(c) ? O(c, d) : d)
            }), this.pointRange = b, this.closestPointRange = c;
            this.oldTransA = e;
            this.translationSlope = this.transA = e = this.len / (a + b || 1);
            this.transB = this.horiz ? this.left : this.bottom;
            this.minPixelPadding = e * (b / 2)
        },
        setTickPositions: function(a) {
            var b = this,
                c = b.chart,
                d = b.options,
                e = b.isLog,
                f = b.isDatetimeAxis,
                g = b.isXAxis,
                h = b.isLinked,
                k = b.options.tickPositioner,
                i = d.maxPadding,
                j = d.minPadding,
                l = d.tickInterval,
                m = d.tickPixelInterval,
                o = b.categories;
            h ? (b.linkedParent = c[g ? "xAxis" : "yAxis"][d.linkedTo], c = b.linkedParent.getExtremes(), b.min = p(c.min, c.dataMin), b.max = p(c.max, c.dataMax), d.type !== b.linkedParent.options.type && ub(11, 1)) : (b.min = p(b.userMin, d.min, b.dataMin), b.max = p(b.userMax, d.max, b.dataMax));
            if (e) !a && O(b.min, p(b.dataMin, b.min)) <= 0 && ub(10, 1), b.min = pa(ra(b.min)), b.max = pa(ra(b.max));
            if (b.range && (b.userMin = b.min = t(b.min, b.max - b.range), b.userMax = b.max, a)) b.range = null;
            b.adjustForMinRange();
            if (!o && !b.usePercentage && !h && s(b.min) && s(b.max)) {
                c = b.max - b.min || 1;
                if (!s(d.min) && !s(b.userMin) && j && (b.dataMin < 0 || !b.ignoreMinPadding)) b.min -= c * j;
                if (!s(d.max) && !s(b.userMax) && i && (b.dataMax > 0 || !b.ignoreMaxPadding)) b.max += c * i
            }
            b.tickInterval = b.min === b.max || b.min === void 0 || b.max === void 0 ? 1 : h && !l && m === b.linkedParent.options.tickPixelInterval ? b.linkedParent.tickInterval : p(l, o ? 1 : (b.max - b.min) * m / (b.len || 1));
            g && !a && n(b.series, function(a) {
                a.processData(b.min !== b.oldMin || b.max !== b.oldMax)
            });
            b.setAxisTranslation();
            b.beforeSetTickPositions && b.beforeSetTickPositions();
            if (b.postProcessTickInterval) b.tickInterval = b.postProcessTickInterval(b.tickInterval);
            if (!f && !e && (a = R.pow(10, $(R.log(b.tickInterval) / R.LN10)), !s(d.tickInterval))) b.tickInterval = pb(b.tickInterval, null, a, d);
            b.minorTickInterval = d.minorTickInterval === "auto" && b.tickInterval ? b.tickInterval / 5 : d.minorTickInterval;
            b.tickPositions = k = d.tickPositions || k && k.apply(b, [b.min, b.max]);
            if (!k) k = f ? (b.getNonLinearTimeTicks || gb)(Cb(b.tickInterval, d.units), b.min, b.max, d.startOfWeek, b.ordinalPositions, b.closestPointRange, !0) : e ? b.getLogTickPositions(b.tickInterval, b.min, b.max) : b.getLinearTickPositions(b.tickInterval, b.min, b.max), b.tickPositions = k;
            if (!h) e = k[0], f = k[k.length - 1], d.startOnTick ? b.min = e : b.min > e && k.shift(), d.endOnTick ? b.max = f : b.max < f && k.pop()
        },
        setMaxTicks: function() {
            var a = this.chart,
                b = a.maxTicks,
                c = this.tickPositions,
                d = this.xOrY;
            b || (b = {
                x: 0,
                y: 0
            });
            if (!this.isLinked && !this.isDatetimeAxis && c.length > b[d] && this.options.alignTicks !== !1) b[d] = c.length;
            a.maxTicks = b
        },
        adjustTickAmount: function() {
            var a = this.xOrY,
                b = this.tickPositions,
                c = this.chart.maxTicks;
            if (c && c[a] && !this.isDatetimeAxis && !this.categories && !this.isLinked && this.options.alignTicks !== !1) {
                var d = this.tickAmount,
                    e = b.length;
                this.tickAmount = a = c[a];
                if (e < a) {
                    for (; b.length < a;) b.push(pa(b[b.length - 1] + this.tickInterval));
                    this.transA *= (e - 1) / (a - 1);
                    this.max = b[b.length - 1]
                }
                if (s(d) && a !== d) this.isDirty = !0
            }
        },
        setScale: function() {
            var a = this.stacks,
                b, c, d, e;
            this.oldMin = this.min;
            this.oldMax = this.max;
            this.oldAxisLength = this.len;
            this.setAxisSize();
            e = this.len !== this.oldAxisLength;
            n(this.series, function(a) {
                if (a.isDirtyData || a.isDirty || a.xAxis.isDirty) d = !0
            });
            if (e || d || this.isLinked || this.userMin !== this.oldUserMin || this.userMax !== this.oldUserMax)
                if (this.getSeriesExtremes(), this.setTickPositions(), this.oldUserMin = this.userMin, this.oldUserMax = this.userMax, !this.isDirty) this.isDirty = e || this.min !== this.oldMin || this.max !== this.oldMax;
            if (!this.isXAxis)
                for (b in a)
                    for (c in a[b]) a[b][c].cum = a[b][c].total;
            this.setMaxTicks()
        },
        setExtremes: function(a, b, c, d, e) {
            var f = this,
                g = f.chart,
                c = p(c, !0),
                e = z(e, {
                    min: a,
                    max: b
                });
            N(f, "setExtremes", e, function() {
                f.userMin = a;
                f.userMax = b;
                f.isDirtyExtremes = !0;
                c && g.redraw(d)
            })
        },
        setAxisSize: function() {
            var a = this.chart,
                b = this.options,
                c = b.offsetLeft || 0,
                d = b.offsetRight || 0;
            this.left = p(b.left, a.plotLeft + c);
            this.top = p(b.top, a.plotTop);
            this.width = p(b.width, a.plotWidth - c + d);
            this.height = p(b.height, a.plotHeight);
            this.bottom = a.chartHeight - this.height - this.top;
            this.right = a.chartWidth - this.width - this.left;
            this.len = t(this.horiz ? this.width : this.height, 0)
        },
        getExtremes: function() {
            var a = this.isLog;
            return {
                min: a ? pa(ja(this.min)) : this.min,
                max: a ? pa(ja(this.max)) : this.max,
                dataMin: this.dataMin,
                dataMax: this.dataMax,
                userMin: this.userMin,
                userMax: this.userMax
            }
        },
        getThreshold: function(a) {
            var b = this.isLog,
                c = b ? ja(this.min) : this.min,
                b = b ? ja(this.max) : this.max;
            c > a || a === null ? a = c : b < a && (a = b);
            return this.translate(a, 0, 1, 0, 1)
        },
        addPlotBandOrLine: function(a) {
            a = (new vb(this, a)).render();
            this.plotLinesAndBands.push(a);
            return a
        },
        getOffset: function() {
            var a = this,
                b = a.chart,
                c = b.renderer,
                d = a.options,
                e = a.tickPositions,
                f = a.ticks,
                g = a.horiz,
                h = a.side,
                k, i = 0,
                j, l = 0,
                m = d.title,
                o = d.labels,
                r = 0,
                A = b.axisOffset,
                q = [-1, 1, 1, -1][h],
                C;
            a.hasData = b = a.series.length && s(a.min) && s(a.max);
            a.showAxis = k = b || p(d.showEmpty, !0);
            if (!a.axisGroup) a.axisGroup = c.g("axis").attr({
                zIndex: d.zIndex || 7
            }).add(), a.gridGroup = c.g("grid").attr({
                zIndex: d.gridZIndex || 1
            }).add();
            if (b || a.isLinked) n(e, function(b) {
                f[b] ? f[b].addLabel() : f[b] = new ab(a, b)
            }), n(e, function(a) {
                if (h === 0 || h === 2 || {
                        1: "left",
                        3: "right"
                    } [h] === o.align) r = t(f[a].getLabelSize(), r)
            }), a.staggerLines && (r += (a.staggerLines - 1) * 16);
            else
                for (C in f) f[C].destroy(), delete f[C];
            if (m && m.text) {
                if (!a.axisTitle) a.axisTitle = c.text(m.text, 0, 0, m.useHTML).attr({
                    zIndex: 7,
                    rotation: m.rotation || 0,
                    align: m.textAlign || {
                        low: "left",
                        middle: "center",
                        high: "right"
                    } [m.align]
                }).css(m.style).add(a.axisGroup), a.axisTitle.isNew = !0;
                if (k) i = a.axisTitle.getBBox()[g ? "height" : "width"], l = p(m.margin, g ? 5 : 10), j = m.offset;
                a.axisTitle[k ? "show" : "hide"]()
            }
            a.offset = q * p(d.offset, A[h]);
            a.axisTitleMargin = p(j, r + l + (h !== 2 && r && q * d.labels[g ? "y" : "x"]));
            A[h] = t(A[h], a.axisTitleMargin + i + q * a.offset)
        },
        getLinePath: function(a) {
            var b = this.chart,
                c = this.opposite,
                d = this.offset,
                e = this.horiz,
                f = this.left + (c ? this.width : 0) + d,
                c = b.chartHeight - this.bottom - (c ? this.height : 0) + d;
            return b.renderer.crispLine(["M", e ? this.left : f, e ? c : this.top, "L", e ? b.chartWidth - this.right : f, e ? c : b.chartHeight - this.bottom], a)
        },
        getTitlePosition: function() {
            var a = this.horiz,
                b = this.left,
                c = this.top,
                d = this.len,
                e = this.options.title,
                f = a ? b : c,
                g = this.opposite,
                h = this.offset,
                k = F(e.style.fontSize || 12),
                d = {
                    low: f + (a ? 0 : d),
                    middle: f + d / 2,
                    high: f + (a ? d : 0)
                } [e.align],
                b = (a ? c + this.height : b) + (a ? 1 : -1) * (g ? -1 : 1) * this.axisTitleMargin + (this.side === 2 ? k : 0);
            return {
                x: a ? d : b + (g ? this.width : 0) + h + (e.x || 0),
                y: a ? b - (g ? this.height : 0) + h : d + (e.y || 0)
            }
        },
        render: function() {
            var a = this,
                b = a.chart,
                c = b.renderer,
                d = a.options,
                e = a.isLog,
                f = a.isLinked,
                g = a.tickPositions,
                h = a.axisTitle,
                k = a.stacks,
                i = a.ticks,
                j = a.minorTicks,
                l = a.alternateBands,
                m = d.stackLabels,
                o = d.alternateGridColor,
                r = d.lineWidth,
                p, q = b.hasRendered && s(a.oldMin) && !isNaN(a.oldMin),
                C = a.showAxis,
                J, w;
            if (a.hasData || f)
                if (a.minorTickInterval && !a.categories && n(a.getMinorTickPositions(), function(b) {
                        j[b] || (j[b] = new ab(a, b, "minor"));
                        q && j[b].isNew && j[b].render(null, !0);
                        j[b].isActive = !0;
                        j[b].render()
                    }), n(g.slice(1).concat([g[0]]), function(b, c) {
                        c = c === g.length - 1 ? 0 : c + 1;
                        if (!f || b >= a.min && b <= a.max) i[b] || (i[b] = new ab(a, b)), q && i[b].isNew && i[b].render(c, !0), i[b].isActive = !0, i[b].render(c)
                    }), o && n(g, function(b, c) {
                        if (c % 2 === 0 && b < a.max) l[b] || (l[b] = new vb(a)), J = b, w = g[c + 1] !== v ? g[c + 1] : a.max, l[b].options = {
                            from: e ? ja(J) : J,
                            to: e ? ja(w) : w,
                            color: o
                        }, l[b].render(), l[b].isActive = !0
                    }), !a._addedPlotLB) n((d.plotLines || []).concat(d.plotBands || []), function(b) {
                    a.addPlotBandOrLine(b)
                }), a._addedPlotLB = !0;
            n([i, j, l], function(a) {
                for (var b in a) a[b].isActive ? a[b].isActive = !1 : (a[b].destroy(), delete a[b])
            });
            if (r) p = a.getLinePath(r), a.axisLine ? a.axisLine.animate({
                d: p
            }) : a.axisLine = c.path(p).attr({
                stroke: d.lineColor,
                "stroke-width": r,
                zIndex: 7
            }).add(), a.axisLine[C ? "show" : "hide"]();
            if (h && C) h[h.isNew ? "attr" : "animate"](a.getTitlePosition()), h.isNew = !1;
            if (m && m.enabled) {
                var x, D, d = a.stackTotalGroup;
                if (!d) a.stackTotalGroup = d = c.g("stack-labels").attr({
                    visibility: "visible",
                    zIndex: 6
                }).add();
                d.translate(b.plotLeft, b.plotTop);
                for (x in k)
                    for (D in b = k[x], b) b[D].render(d)
            }
            a.isDirty = !1
        },
        removePlotBandOrLine: function(a) {
            for (var b = this.plotLinesAndBands, c = b.length; c--;) b[c].id === a && b[c].destroy()
        },
        setTitle: function(a, b) {
            var c = this.chart,
                d = this.options;
            d.title = y(d.title, a);
            this.axisTitle = void 0;
            this.isDirty = !0;
            p(b, !0) && c.redraw()
        },
        redraw: function() {
            var a = this.chart;
            a.tracker.resetTracker && a.tracker.resetTracker(!0);
            this.render();
            n(this.plotLinesAndBands, function(a) {
                a.render()
            });
            n(this.series, function(a) {
                a.isDirty = !0
            })
        },
        setCategories: function(a, b) {
            var c = this.chart;
            this.categories = this.userOptions.categories = a;
            n(this.series, function(a) {
                a.translate();
                a.setTooltipPoints(!0)
            });
            this.isDirty = !0;
            p(b, !0) && c.redraw()
        },
        destroy: function() {
            var a = this,
                b = a.stacks,
                c;
            Q(a);
            for (c in b) ta(b[c]), b[c] = null;
            n([a.ticks, a.minorTicks, a.alternateBands, a.plotLinesAndBands], function(a) {
                ta(a)
            });
            n(["stackTotalGroup", "axisLine", "axisGroup", "gridGroup", "axisTitle"], function(b) {
                a[b] && (a[b] = a[b].destroy())
            })
        }
    };
    wb.prototype = {
        destroy: function() {
            n(this.crosshairs, function(a) {
                a && a.destroy()
            });
            if (this.label) this.label = this.label.destroy()
        },
        move: function(a, b) {
            var c = this;
            c.currentX = c.tooltipIsHidden ? a : (2 * c.currentX + a) / 3;
            c.currentY = c.tooltipIsHidden ? b : (c.currentY + b) / 2;
            c.label.attr({
                x: c.currentX,
                y: c.currentY
            });
            c.tooltipTick = W(a - c.currentX) > 1 || W(b - c.currentY) > 1 ? function() {
                c.move(a, b)
            } : null
        },
        hide: function() {
            if (!this.tooltipIsHidden) {
                var a = this.chart.hoverPoints;
                this.label.hide();
                a && n(a, function(a) {
                    a.setState()
                });
                this.chart.hoverPoints = null;
                this.tooltipIsHidden = !0
            }
        },
        hideCrosshairs: function() {
            n(this.crosshairs, function(a) {
                a && a.hide()
            })
        },
        getAnchor: function(a, b) {
            var c, d = this.chart,
                e = d.inverted,
                f = 0,
                g = 0,
                a = la(a);
            c = a[0].tooltipPos;
            c || (n(a, function(a) {
                f += a.plotX;
                g += a.plotLow ? (a.plotLow + a.plotHigh) / 2 : a.plotY
            }), f /= a.length, g /= a.length, c = [e ? d.plotWidth - g : f, this.shared && !e && a.length > 1 && b ? b.chartY - d.plotTop : e ? d.plotHeight - f : g]);
            return va(c, u)
        },
        getPosition: function(a, b, c) {
            var d = this.chart,
                e = d.plotLeft,
                f = d.plotTop,
                g = d.plotWidth,
                h = d.plotHeight,
                k = p(this.options.distance, 12),
                i = c.plotX,
                c = c.plotY,
                d = i + e + (d.inverted ? k : -a - k),
                j = c - b + f + 15,
                l;
            d < 7 && (d = e + i + k);
            d + a > e + g && (d -= d + a - (e + g), j = c - b + f - k, l = !0);
            j < f + 5 && (j = f + 5, l && c >= j && c <= j + b && (j = c + f + k));
            j + b > f + h && (j = t(f, f + h - b - k));
            return {
                x: d,
                y: j
            }
        },
        refresh: function(a, b) {
            function c() {
                var a = this.points || la(this),
                    b = a[0].series,
                    c;
                c = [b.tooltipHeaderFormatter(a[0].key)];
                n(a, function(a) {
                    b = a.series;
                    c.push(b.tooltipFormatter && b.tooltipFormatter(a) || a.point.tooltipFormatter(b.tooltipOptions.pointFormat))
                });
                c.push(f.footerFormat || "");
                return c.join("")
            }
            var d = this.chart,
                e = this.label,
                f = this.options,
                g, h, k, i = {},
                j, l = [];
            j = f.formatter || c;
            var i = d.hoverPoints,
                m, o = f.crosshairs;
            k = this.shared;
            h = this.getAnchor(a, b);
            g = h[0];
            h = h[1];
            k && (!a.series || !a.series.noSharedTooltip) ? (i && n(i, function(a) {
                a.setState()
            }), d.hoverPoints = a, n(a, function(a) {
                a.setState("hover");
                l.push(a.getLabelConfig())
            }), i = {
                x: a[0].category,
                y: a[0].y
            }, i.points = l, a = a[0]) : i = a.getLabelConfig();
            j = j.call(i);
            i = a.series;
            k = k || !i.isCartesian || i.tooltipOutsidePlot || d.isInsidePlot(g, h);
            j === !1 || !k ? this.hide() : (this.tooltipIsHidden && e.show(), e.attr({
                text: j
            }), m = f.borderColor || a.color || i.color || "#606060", e.attr({
                stroke: m
            }), e = (f.positioner || this.getPosition).call(this, e.width, e.height, {
                plotX: g,
                plotY: h
            }), this.move(u(e.x), u(e.y)), this.tooltipIsHidden = !1);
            if (o) {
                o = la(o);
                for (e = o.length; e--;)
                    if (k = a.series[e ? "yAxis" : "xAxis"], o[e] && k)
                        if (k = k.getPlotLinePath(e ? p(a.stackY, a.y) : a.x, 1), this.crosshairs[e]) this.crosshairs[e].attr({
                            d: k,
                            visibility: "visible"
                        });
                        else {
                            i = {
                                "stroke-width": o[e].width || 1,
                                stroke: o[e].color || "#C0C0C0",
                                zIndex: o[e].zIndex || 2
                            };
                            if (o[e].dashStyle) i.dashstyle = o[e].dashStyle;
                            this.crosshairs[e] = d.renderer.path(k).attr(i).add()
                        }
            }
            N(d, "tooltipRefresh", {
                text: j,
                x: g + d.plotLeft,
                y: h + d.plotTop,
                borderColor: m
            })
        },
        tick: function() {
            this.tooltipTick && this.tooltipTick()
        }
    };
    Kb.prototype = {
        normalizeMouseEvent: function(a) {
            var b, c, d, a = a || Y.event;
            if (!a.target) a.target = a.srcElement;
            if (a.originalEvent) a = a.originalEvent;
            if (a.event) a = a.event;
            d = a.touches ? a.touches.item(0) : a;
            this.chartPosition = b = Tb(this.chart.container);
            d.pageX === v ? (c = a.x, b = a.y) : (c = d.pageX - b.left, b = d.pageY - b.top);
            return z(a, {
                chartX: u(c),
                chartY: u(b)
            })
        },
        getMouseCoordinates: function(a) {
            var b = {
                    xAxis: [],
                    yAxis: []
                },
                c = this.chart;
            n(c.axes, function(d) {
                var e = d.isXAxis;
                b[e ? "xAxis" : "yAxis"].push({
                    axis: d,
                    value: d.translate((c.inverted ? !e : e) ? a.chartX - c.plotLeft : c.plotHeight - a.chartY + c.plotTop, !0)
                })
            });
            return b
        },
        onmousemove: function(a) {
            var b = this.chart,
                c = b.series,
                d, e, f = b.hoverPoint,
                g = b.hoverSeries,
                h, k, i = b.chartWidth,
                j = b.inverted ? b.plotHeight + b.plotTop - a.chartY : a.chartX - b.plotLeft;
            if (b.tooltip && this.options.tooltip.shared && (!g || !g.noSharedTooltip)) {
                e = [];
                h = c.length;
                for (k = 0; k < h; k++)
                    if (c[k].visible && c[k].options.enableMouseTracking !== !1 && !c[k].noSharedTooltip && c[k].tooltipPoints.length) d = c[k].tooltipPoints[j], d._dist = W(j - d.plotX), i = O(i, d._dist), e.push(d);
                for (h = e.length; h--;) e[h]._dist > i && e.splice(h, 1);
                if (e.length && e[0].plotX !== this.hoverX) b.tooltip.refresh(e, a), this.hoverX = e[0].plotX
            }
            if (g && g.tracker && (d = g.tooltipPoints[j]) && d !== f) d.onMouseOver()
        },
        resetTracker: function(a) {
            var b = this.chart,
                c = b.hoverSeries,
                d = b.hoverPoint,
                e = b.hoverPoints || d,
                b = b.tooltip;
            (a = a && b && e) && la(e)[0].plotX === v && (a = !1);
            if (a) b.refresh(e);
            else {
                if (d) d.onMouseOut();
                if (c) c.onMouseOut();
                b && (b.hide(), b.hideCrosshairs());
                this.hoverX = null
            }
        },
        setDOMEvents: function() {
            function a() {
                if (b.selectionMarker) {
                    var f = {
                            xAxis: [],
                            yAxis: []
                        },
                        g = b.selectionMarker.getBBox(),
                        h = g.x - c.plotLeft,
                        l = g.y - c.plotTop,
                        m;
                    e && (n(c.axes, function(a) {
                        if (a.options.zoomEnabled !== !1) {
                            var b = a.isXAxis,
                                d = c.inverted ? !b : b,
                                e = a.translate(d ? h : c.plotHeight - l - g.height, !0, 0, 0, 1),
                                d = a.translate(d ? h + g.width : c.plotHeight - l, !0, 0, 0, 1);
                            !isNaN(e) && !isNaN(d) && (f[b ? "xAxis" : "yAxis"].push({
                                axis: a,
                                min: O(e, d),
                                max: t(e, d)
                            }), m = !0)
                        }
                    }), m && N(c, "selection", f, function(a) {
                        c.zoom(a)
                    }));
                    b.selectionMarker = b.selectionMarker.destroy()
                }
                if (c) M(d, {
                    cursor: "auto"
                }), c.cancelClick = e, c.mouseIsDown = e = !1;
                Q(I, aa ? "touchend" : "mouseup", a)
            }
            var b = this,
                c = b.chart,
                d = c.container,
                e, f = b.zoomX && !c.inverted || b.zoomY && c.inverted,
                g = b.zoomY && !c.inverted || b.zoomX && c.inverted;
            b.hideTooltipOnMouseMove = function(a) {
                Ub(a);
                b.chartPosition && c.hoverSeries && c.hoverSeries.isCartesian && !c.isInsidePlot(a.pageX - b.chartPosition.left - c.plotLeft, a.pageY - b.chartPosition.top - c.plotTop) && b.resetTracker()
            };
            b.hideTooltipOnMouseLeave = function() {
                b.resetTracker();
                b.chartPosition = null
            };
            d.onmousedown = function(d) {
                d = b.normalizeMouseEvent(d);
                !aa && d.preventDefault && d.preventDefault();
                c.mouseIsDown = !0;
                c.cancelClick = !1;
                c.mouseDownX = b.mouseDownX = d.chartX;
                b.mouseDownY = d.chartY;
                B(I, aa ? "touchend" : "mouseup", a)
            };
            var h = function(a) {
                if (!a || !(a.touches && a.touches.length > 1)) {
                    a = b.normalizeMouseEvent(a);
                    if (!aa) a.returnValue = !1;
                    var d = a.chartX,
                        h = a.chartY,
                        l = !c.isInsidePlot(d - c.plotLeft, h - c.plotTop);
                    aa && a.type === "touchstart" && (G(a.target, "isTracker") ? c.runTrackerClick || a.preventDefault() : !c.runChartClick && !l && a.preventDefault());
                    if (l) d < c.plotLeft ? d = c.plotLeft : d > c.plotLeft + c.plotWidth && (d = c.plotLeft + c.plotWidth), h < c.plotTop ? h = c.plotTop : h > c.plotTop + c.plotHeight && (h = c.plotTop + c.plotHeight);
                    if (c.mouseIsDown && a.type !== "touchstart") {
                        if (e = Math.sqrt(Math.pow(b.mouseDownX - d, 2) + Math.pow(b.mouseDownY - h, 2)), e > 10) {
                            a = c.isInsidePlot(b.mouseDownX - c.plotLeft, b.mouseDownY - c.plotTop);
                            if (c.hasCartesianSeries && (b.zoomX || b.zoomY) && a && !b.selectionMarker) b.selectionMarker = c.renderer.rect(c.plotLeft, c.plotTop, f ? 1 : c.plotWidth, g ? 1 : c.plotHeight, 0).attr({
                                fill: b.options.chart.selectionMarkerFill || "rgba(69,114,167,0.25)",
                                zIndex: 7
                            }).add();
                            if (b.selectionMarker && f) {
                                var m = d - b.mouseDownX;
                                b.selectionMarker.attr({
                                    width: W(m),
                                    x: (m > 0 ? 0 : m) + b.mouseDownX
                                })
                            }
                            b.selectionMarker && g && (h -= b.mouseDownY, b.selectionMarker.attr({
                                height: W(h),
                                y: (h > 0 ? 0 : h) + b.mouseDownY
                            }));
                            a && !b.selectionMarker && b.options.chart.panning && c.pan(d)
                        }
                    } else if (!l) b.onmousemove(a);
                    return l || !c.hasCartesianSeries
                }
            };
            d.onmousemove = h;
            B(d, "mouseleave", b.hideTooltipOnMouseLeave);
            B(I, "mousemove", b.hideTooltipOnMouseMove);
            d.ontouchstart = function(a) {
                if (b.zoomX || b.zoomY) d.onmousedown(a);
                h(a)
            };
            d.ontouchmove = h;
            d.ontouchend = function() {
                e && b.resetTracker()
            };
            d.onclick = function(a) {
                var d = c.hoverPoint,
                    e, f, a = b.normalizeMouseEvent(a);
                a.cancelBubble = !0;
                if (!c.cancelClick) d && (G(a.target, "isTracker") || G(a.target.parentNode, "isTracker")) ? (e = d.plotX, f = d.plotY, z(d, {
                    pageX: b.chartPosition.left + c.plotLeft + (c.inverted ? c.plotWidth - f : e),
                    pageY: b.chartPosition.top + c.plotTop + (c.inverted ? c.plotHeight - e : f)
                }), N(d.series, "click", z(a, {
                    point: d
                })), d.firePointEvent("click", a)) : (z(a, b.getMouseCoordinates(a)), c.isInsidePlot(a.chartX - c.plotLeft, a.chartY - c.plotTop) && N(c, "click", a))
            }
        },
        destroy: function() {
            var a = this.chart,
                b = a.container;
            if (a.trackerGroup) a.trackerGroup = a.trackerGroup.destroy();
            Q(b, "mouseleave", this.hideTooltipOnMouseLeave);
            Q(I, "mousemove", this.hideTooltipOnMouseMove);
            b.onclick = b.onmousedown = b.onmousemove = b.ontouchstart = b.ontouchend = b.ontouchmove = null;
            clearInterval(this.tooltipInterval)
        },
        init: function(a, b) {
            if (!a.trackerGroup) a.trackerGroup = a.renderer.g("tracker").attr({
                zIndex: 9
            }).add();
            if (b.enabled) a.tooltip = new wb(a, b), this.tooltipInterval = setInterval(function() {
                a.tooltip.tick()
            }, 32);
            this.setDOMEvents()
        }
    };
    xb.prototype = {
        init: function(a) {
            var b = this,
                c = b.options = a.options.legend;
            if (c.enabled) {
                var d = c.itemStyle,
                    e = p(c.padding, 8),
                    f = c.itemMarginTop || 0;
                b.baseline = F(d.fontSize) + 3 + f;
                b.itemStyle = d;
                b.itemHiddenStyle = y(d, c.itemHiddenStyle);
                b.itemMarginTop = f;
                b.padding = e;
                b.initialItemX = e;
                b.initialItemY = e - 5;
                b.maxItemWidth = 0;
                b.chart = a;
                b.itemHeight = 0;
                b.lastLineHeight = 0;
                b.render();
                B(b.chart, "endResize", function() {
                    b.positionCheckboxes()
                })
            }
        },
        colorizeItem: function(a, b) {
            var c = this.options,
                d = a.legendItem,
                e = a.legendLine,
                f = a.legendSymbol,
                g = this.itemHiddenStyle.color,
                c = b ? c.itemStyle.color : g,
                g = b ? a.color : g;
            d && d.css({
                fill: c
            });
            e && e.attr({
                stroke: g
            });
            f && f.attr({
                stroke: g,
                fill: g
            })
        },
        positionItem: function(a) {
            var b = this.options,
                c = b.symbolPadding,
                b = !b.rtl,
                d = a._legendItemPos,
                e = d[0],
                d = d[1],
                f = a.checkbox;
            a.legendGroup && a.legendGroup.translate(b ? e : this.legendWidth - e - 2 * c - 4, d);
            if (f) f.x = e, f.y = d
        },
        destroyItem: function(a) {
            var b = a.checkbox;
            n(["legendItem", "legendLine", "legendSymbol", "legendGroup"], function(b) {
                a[b] && a[b].destroy()
            });
            b && Na(a.checkbox)
        },
        destroy: function() {
            var a = this.group,
                b = this.box;
            if (b) this.box = b.destroy();
            if (a) this.group = a.destroy()
        },
        positionCheckboxes: function() {
            var a = this;
            n(a.allItems, function(b) {
                var c = b.checkbox,
                    d = a.group.alignAttr;
                c && M(c, {
                    left: d.translateX + b.legendItemWidth + c.x - 20 + "px",
                    top: d.translateY + c.y + 3 + "px"
                })
            })
        },
        renderItem: function(a) {
            var x;
            var b = this,
                c = b.chart,
                d = c.renderer,
                e = b.options,
                f = e.layout === "horizontal",
                g = e.symbolWidth,
                h = e.symbolPadding,
                k = b.itemStyle,
                i = b.itemHiddenStyle,
                j = b.padding,
                l = !e.rtl,
                m = e.width,
                o = e.itemMarginBottom || 0,
                r = b.itemMarginTop,
                n = b.initialItemX,
                q = a.legendItem,
                p = a.series || a,
                s = p.options,
                w = s.showCheckbox;
            if (!q && (a.legendGroup = d.g("legend-item").attr({
                    zIndex: 1
                }).add(b.scrollGroup), p.drawLegendSymbol(b, a), a.legendItem = q = d.text(e.labelFormatter.call(a), l ? g + h : -h, b.baseline, e.useHTML).css(y(a.visible ? k : i)).attr({
                    align: l ? "left" : "right",
                    zIndex: 2
                }).add(a.legendGroup), a.legendGroup.on("mouseover", function() {
                    a.setState("hover");
                    q.css(b.options.itemHoverStyle)
                }).on("mouseout", function() {
                    q.css(a.visible ? k : i);
                    a.setState()
                }).on("click", function(b) {
                    var c = function() {
                            a.setVisible()
                        },
                        b = {
                            browserEvent: b
                        };
                    a.firePointEvent ? a.firePointEvent("legendItemClick", b, c) : N(a, "legendItemClick", b, c)
                }), b.colorizeItem(a, a.visible), s && w)) a.checkbox = V("input", {
                type: "checkbox",
                checked: a.selected,
                defaultChecked: a.selected
            }, e.itemCheckboxStyle, c.container), B(a.checkbox, "click", function(b) {
                N(a, "checkboxClick", {
                    checked: b.target.checked
                }, function() {
                    a.select()
                })
            });
            d = q.getBBox();
            x = a.legendItemWidth = e.itemWidth || g + h + d.width + j + (w ? 20 : 0), e = x;
            b.itemHeight = g = d.height;
            if (f && b.itemX - n + e > (m || c.chartWidth - 2 * j - n)) b.itemX = n, b.itemY += r + b.lastLineHeight + o, b.lastLineHeight = 0;
            b.maxItemWidth = t(b.maxItemWidth, e);
            b.lastItemY = r + b.itemY + o;
            b.lastLineHeight = t(g, b.lastLineHeight);
            a._legendItemPos = [b.itemX, b.itemY];
            f ? b.itemX += e : (b.itemY += r + g + o, b.lastLineHeight = g);
            b.offsetWidth = m || t(f ? b.itemX - n : e, b.offsetWidth)
        },
        render: function() {
            var a = this,
                b = a.chart,
                c = b.renderer,
                d = a.group,
                e, f, g, h, k = a.box,
                i = a.options,
                j = a.padding,
                l = i.borderWidth,
                m = i.backgroundColor;
            a.itemX = a.initialItemX;
            a.itemY = a.initialItemY;
            a.offsetWidth = 0;
            a.lastItemY = 0;
            if (!d) a.group = d = c.g("legend").attr({
                zIndex: 7
            }).add(), a.contentGroup = c.g().attr({
                zIndex: 1
            }).add(d), a.scrollGroup = c.g().add(a.contentGroup), a.clipRect = c.clipRect(0, 0, 9999, b.chartHeight), a.contentGroup.clip(a.clipRect);
            e = [];
            n(b.series, function(a) {
                var b = a.options;
                b.showInLegend && (e = e.concat(a.legendItems || (b.legendType === "point" ? a.data : a)))
            });
            ac(e, function(a, b) {
                return (a.options.legendIndex || 0) - (b.options.legendIndex || 0)
            });
            i.reversed && e.reverse();
            a.allItems = e;
            a.display = f = !!e.length;
            n(e, function(b) {
                a.renderItem(b)
            });
            g = i.width || a.offsetWidth;
            h = a.lastItemY + a.lastLineHeight;
            h = a.handleOverflow(h);
            if (l || m) {
                g += j;
                h += j;
                if (k) {
                    if (g > 0 && h > 0) k[k.isNew ? "attr" : "animate"](k.crisp(null, null, null, g, h)), k.isNew = !1
                } else a.box = k = c.rect(0, 0, g, h, i.borderRadius, l || 0).attr({
                    stroke: i.borderColor,
                    "stroke-width": l || 0,
                    fill: m || da
                }).add(d).shadow(i.shadow), k.isNew = !0;
                k[f ? "show" : "hide"]()
            }
            a.legendWidth = g;
            a.legendHeight = h;
            n(e, function(b) {
                a.positionItem(b)
            });
            f && d.align(z({
                width: g,
                height: h
            }, i), !0, b.spacingBox);
            b.isResizing || this.positionCheckboxes()
        },
        handleOverflow: function(a) {
            var b = this,
                c = this.chart,
                d = c.renderer,
                e = this.options,
                f = e.y,
                f = c.spacingBox.height + (e.verticalAlign === "top" ? -f : f) - this.padding,
                g = e.maxHeight,
                h = this.clipRect,
                k = e.navigation,
                i = p(k.animation, !0),
                j = k.arrowSize || 12,
                l = this.nav;
            e.layout === "horizontal" && (f /= 2);
            g && (f = O(f, g));
            if (a > f) {
                this.clipHeight = c = f - 20;
                this.pageCount = Ga(a / c);
                this.currentPage = p(this.currentPage, 1);
                this.fullHeight = a;
                h.attr({
                    height: c
                });
                if (!l) this.nav = l = d.g().attr({
                    zIndex: 1
                }).add(this.group), this.up = d.symbol("triangle", 0, 0, j, j).on("click", function() {
                    b.scroll(-1, i)
                }).add(l), this.pager = d.text("", 15, 10).css(k.style).add(l), this.down = d.symbol("triangle-down", 0, 0, j, j).on("click", function() {
                    b.scroll(1, i)
                }).add(l);
                b.scroll(0);
                a = f
            } else l && (h.attr({
                height: c.chartHeight
            }), l.hide(), this.scrollGroup.attr({
                translateY: 1
            }));
            return a
        },
        scroll: function(a, b) {
            var c = this.pageCount,
                d = this.currentPage + a,
                e = this.clipHeight,
                f = this.options.navigation,
                g = f.activeColor,
                f = f.inactiveColor,
                h = this.pager,
                k = this.padding;
            d > c && (d = c);
            if (d > 0) b !== v && Ea(b, this.chart), this.nav.attr({
                translateX: k,
                translateY: e + 7,
                visibility: "visible"
            }), this.up.attr({
                fill: d === 1 ? f : g
            }).css({
                cursor: d === 1 ? "default" : "pointer"
            }), h.attr({
                text: d + "/" + this.pageCount
            }), this.down.attr({
                x: 18 + this.pager.getBBox().width,
                fill: d === c ? f : g
            }).css({
                cursor: d === c ? "default" : "pointer"
            }), this.scrollGroup.animate({
                translateY: -O(e * (d - 1), this.fullHeight - e + k) + 1
            }), h.attr({
                text: d + "/" + c
            }), this.currentPage = d
        }
    };
    cb.prototype = {
        initSeries: function(a) {
            var b = this.options.chart,
                b = new U[a.type || b.type || b.defaultSeriesType];
            b.init(this, a);
            return b
        },
        addSeries: function(a, b, c) {
            var d = this;
            a && (Ea(c, d), b = p(b, !0), N(d, "addSeries", {
                options: a
            }, function() {
                d.initSeries(a);
                d.isDirtyLegend = !0;
                b && d.redraw()
            }))
        },
        isInsidePlot: function(a, b) {
            return a >= 0 && a <= this.plotWidth && b >= 0 && b <= this.plotHeight
        },
        adjustTickAmounts: function() {
            this.options.chart.alignTicks !== !1 && n(this.axes, function(a) {
                a.adjustTickAmount()
            });
            this.maxTicks = null
        },
        redraw: function(a) {
            var b = this.axes,
                c = this.series,
                d = this.tracker,
                e = this.legend,
                f = this.isDirtyLegend,
                g, h = this.isDirtyBox,
                k = c.length,
                i = k,
                j = this.clipRect,
                l = this.renderer,
                m = l.isHidden();
            Ea(a, this);
            for (m && this.cloneRenderTo(); i--;)
                if (a = c[i], a.isDirty && a.options.stacking) {
                    g = !0;
                    break
                } if (g)
                for (i = k; i--;)
                    if (a = c[i], a.options.stacking) a.isDirty = !0;
            n(c, function(a) {
                a.isDirty && a.options.legendType === "point" && (f = !0)
            });
            if (f && e.options.enabled) e.render(), this.isDirtyLegend = !1;
            if (this.hasCartesianSeries) {
                if (!this.isResizing) this.maxTicks = null, n(b, function(a) {
                    a.setScale()
                });
                this.adjustTickAmounts();
                this.getMargins();
                n(b, function(a) {
                    if (a.isDirtyExtremes) a.isDirtyExtremes = !1, N(a, "afterSetExtremes", a.getExtremes());
                    if (a.isDirty || h || g) a.redraw(), h = !0
                })
            }
            h && (this.drawChartBox(), j && (Ra(j), j.animate({
                width: this.plotSizeX,
                height: this.plotSizeY + 1
            })));
            n(c, function(a) {
                a.isDirty && a.visible && (!a.isCartesian || a.xAxis) && a.redraw()
            });
            d && d.resetTracker && d.resetTracker(!0);
            l.draw();
            N(this, "redraw");
            m && this.cloneRenderTo(!0)
        },
        showLoading: function(a) {
            var b = this.options,
                c = this.loadingDiv,
                d = b.loading;
            if (!c) this.loadingDiv = c = V(oa, {
                className: "highcharts-loading"
            }, z(d.style, {
                left: this.plotLeft + "px",
                top: this.plotTop + "px",
                width: this.plotWidth + "px",
                height: this.plotHeight + "px",
                zIndex: 10,
                display: da
            }), this.container), this.loadingSpan = V("span", null, d.labelStyle, c);
            this.loadingSpan.innerHTML = a || b.lang.loading;
            if (!this.loadingShown) M(c, {
                opacity: 0,
                display: ""
            }), lb(c, {
                opacity: d.style.opacity
            }, {
                duration: d.showDuration || 0
            }), this.loadingShown = !0
        },
        hideLoading: function() {
            var a = this.options,
                b = this.loadingDiv;
            b && lb(b, {
                opacity: 0
            }, {
                duration: a.loading.hideDuration || 100,
                complete: function() {
                    M(b, {
                        display: da
                    })
                }
            });
            this.loadingShown = !1
        },
        get: function(a) {
            var b = this.axes,
                c = this.series,
                d, e;
            for (d = 0; d < b.length; d++)
                if (b[d].options.id === a) return b[d];
            for (d = 0; d < c.length; d++)
                if (c[d].options.id === a) return c[d];
            for (d = 0; d < c.length; d++) {
                e = c[d].points || [];
                for (b = 0; b < e.length; b++)
                    if (e[b].id === a) return e[b]
            }
            return null
        },
        getAxes: function() {
            var a = this,
                b = this.options,
                c = b.xAxis || {},
                b = b.yAxis || {},
                c = la(c);
            n(c, function(a, b) {
                a.index = b;
                a.isX = !0
            });
            b = la(b);
            n(b, function(a, b) {
                a.index = b
            });
            c = c.concat(b);
            n(c, function(b) {
                new bb(a, b)
            });
            a.adjustTickAmounts()
        },
        getSelectedPoints: function() {
            var a = [];
            n(this.series, function(b) {
                a = a.concat(Ab(b.points, function(a) {
                    return a.selected
                }))
            });
            return a
        },
        getSelectedSeries: function() {
            return Ab(this.series, function(a) {
                return a.selected
            })
        },
        showResetZoom: function() {
            var a = this,
                b = T.lang,
                c = a.options.chart.resetZoomButton,
                d = c.theme,
                e = d.states,
                f = c.relativeTo === "chart" ? null : {
                    x: a.plotLeft,
                    y: a.plotTop,
                    width: a.plotWidth,
                    height: a.plotHeight
                };
            this.resetZoomButton = a.renderer.button(b.resetZoom, null, null, function() {
                a.zoomOut()
            }, d, e && e.hover).attr({
                align: c.position.align,
                title: b.resetZoomTitle
            }).add().align(c.position, !1, f)
        },
        zoomOut: function() {
            var a = this,
                b = a.resetZoomButton;
            N(a, "selection", {
                resetSelection: !0
            }, function() {
                a.zoom()
            });
            if (b) a.resetZoomButton = b.destroy()
        },
        zoom: function(a) {
            var b = this,
                c = b.options.chart,
                d;
            b.resetZoomEnabled !== !1 && !b.resetZoomButton && b.showResetZoom();
            !a || a.resetSelection ? n(b.axes, function(a) {
                a.options.zoomEnabled !== !1 && (a.setExtremes(null, null, !1), d = !0)
            }) : n(a.xAxis.concat(a.yAxis), function(a) {
                var c = a.axis;
                if (b.tracker[c.isXAxis ? "zoomX" : "zoomY"]) c.setExtremes(a.min, a.max, !1), d = !0
            });
            d && b.redraw(p(c.animation, b.pointCount < 100))
        },
        pan: function(a) {
            var b = this.xAxis[0],
                c = this.mouseDownX,
                d = b.pointRange / 2,
                e = b.getExtremes(),
                f = b.translate(c - a, !0) + d,
                c = b.translate(c + this.plotWidth - a, !0) - d;
            (d = this.hoverPoints) && n(d, function(a) {
                a.setState()
            });
            b.series.length && f > O(e.dataMin, e.min) && c < t(e.dataMax, e.max) && b.setExtremes(f, c, !0, !1);
            this.mouseDownX = a;
            M(this.container, {
                cursor: "move"
            })
        },
        setTitle: function(a, b) {
            var c = this,
                d = c.options,
                e;
            c.chartTitleOptions = e = y(d.title, a);
            c.chartSubtitleOptions = d = y(d.subtitle, b);
            n([
                ["title", a, e],
                ["subtitle", b, d]
            ], function(a) {
                var b = a[0],
                    d = c[b],
                    e = a[1],
                    a = a[2];
                d && e && (d = d.destroy());
                a && a.text && !d && (c[b] = c.renderer.text(a.text, 0, 0, a.useHTML).attr({
                    align: a.align,
                    "class": "highcharts-" + b,
                    zIndex: a.zIndex || 4
                }).css(a.style).add().align(a, !1, c.spacingBox))
            })
        },
        getChartSize: function() {
            var a = this.options.chart,
                b = this.renderToClone || this.renderTo;
            this.containerWidth = eb(b, "width");
            this.containerHeight = eb(b, "height");
            this.chartWidth = a.width || this.containerWidth || 600;
            this.chartHeight = a.height || (this.containerHeight > 19 ? this.containerHeight : 400)
        },
        cloneRenderTo: function(a) {
            var b = this.renderToClone,
                c = this.container;
            a ? b && (this.renderTo.appendChild(c), Na(b), delete this.renderToClone) : (c && this.renderTo.removeChild(c), this.renderToClone = b = this.renderTo.cloneNode(0), M(b, {
                position: "absolute",
                top: "-9999px",
                display: "block"
            }), I.body.appendChild(b), c && b.appendChild(c))
        },
        getContainer: function() {
            var a, b = this.options.chart,
                c, d, e;
            this.renderTo = a = b.renderTo;
            e = "highcharts-" + yb++;
            if (ya(a)) this.renderTo = a = I.getElementById(a);
            a || ub(13, !0);
            a.innerHTML = "";
            a.offsetWidth || this.cloneRenderTo();
            this.getChartSize();
            c = this.chartWidth;
            d = this.chartHeight;
            this.container = a = V(oa, {
                className: "highcharts-container" + (b.className ? " " + b.className : ""),
                id: e
            }, z({
                position: "relative",
                overflow: "hidden",
                width: c + "px",
                height: d + "px",
                textAlign: "left",
                lineHeight: "normal"
            }, b.style), this.renderToClone || a);
            this.renderer = b.forExport ? new qa(a, c, d, !0) : new Qa(a, c, d);
            ma && this.renderer.create(this, a, c, d)
        },
        getMargins: function() {
            var a = this.options.chart,
                b = a.spacingTop,
                c = a.spacingRight,
                d = a.spacingBottom,
                a = a.spacingLeft,
                e, f = this.legend,
                g = this.optionsMarginTop,
                h = this.optionsMarginLeft,
                k = this.optionsMarginRight,
                i = this.optionsMarginBottom,
                j = this.chartTitleOptions,
                l = this.chartSubtitleOptions,
                m = this.options.legend,
                o = p(m.margin, 10),
                r = m.x,
                A = m.y,
                q = m.align,
                C = m.verticalAlign;
            this.resetMargins();
            e = this.axisOffset;
            if ((this.title || this.subtitle) && !s(this.optionsMarginTop))
                if (l = t(this.title && !j.floating && !j.verticalAlign && j.y || 0, this.subtitle && !l.floating && !l.verticalAlign && l.y || 0)) this.plotTop = t(this.plotTop, l + p(j.margin, 15) + b);
            if (f.display && !m.floating)
                if (q === "right") {
                    if (!s(k)) this.marginRight = t(this.marginRight, f.legendWidth - r + o + c)
                } else if (q === "left") {
                if (!s(h)) this.plotLeft = t(this.plotLeft, f.legendWidth + r + o + a)
            } else if (C === "top") {
                if (!s(g)) this.plotTop = t(this.plotTop, f.legendHeight + A + o + b)
            } else if (C === "bottom" && !s(i)) this.marginBottom = t(this.marginBottom, f.legendHeight - A + o + d);
            this.extraBottomMargin && (this.marginBottom += this.extraBottomMargin);
            this.extraTopMargin && (this.plotTop += this.extraTopMargin);
            this.hasCartesianSeries && n(this.axes, function(a) {
                a.getOffset()
            });
            s(h) || (this.plotLeft += e[3]);
            s(g) || (this.plotTop += e[0]);
            s(i) || (this.marginBottom += e[2]);
            s(k) || (this.marginRight += e[1]);
            this.setChartSize()
        },
        initReflow: function() {
            function a(a) {
                var g = c.width || eb(d, "width"),
                    h = c.height || eb(d, "height"),
                    a = a ? a.target : Y;
                if (g && h && (a === Y || a === I)) {
                    if (g !== b.containerWidth || h !== b.containerHeight) clearTimeout(e), e = setTimeout(function() {
                        b.resize(g, h, !1)
                    }, 100);
                    b.containerWidth = g;
                    b.containerHeight = h
                }
            }
            var b = this,
                c = b.options.chart,
                d = b.renderTo,
                e;
            B(Y, "resize", a);
            B(b, "destroy", function() {
                Q(Y, "resize", a)
            })
        },
        fireEndResize: function() {
            var a = this;
            a && N(a, "endResize", null, function() {
                a.isResizing -= 1
            })
        },
        resize: function(a, b, c) {
            var d, e, f = this.title,
                g = this.subtitle;
            this.isResizing += 1;
            Ea(c, this);
            this.oldChartHeight = this.chartHeight;
            this.oldChartWidth = this.chartWidth;
            if (s(a)) this.chartWidth = d = u(a);
            if (s(b)) this.chartHeight = e = u(b);
            M(this.container, {
                width: d + "px",
                height: e + "px"
            });
            this.renderer.setSize(d, e, c);
            this.plotWidth = d - this.plotLeft - this.marginRight;
            this.plotHeight = e - this.plotTop - this.marginBottom;
            this.maxTicks = null;
            n(this.axes, function(a) {
                a.isDirty = !0;
                a.setScale()
            });
            n(this.series, function(a) {
                a.isDirty = !0
            });
            this.isDirtyBox = this.isDirtyLegend = !0;
            this.getMargins();
            a = this.spacingBox;
            f && f.align(null, null, a);
            g && g.align(null, null, a);
            this.redraw(c);
            this.oldChartHeight = null;
            N(this, "resize");
            $a === !1 ? this.fireEndResize() : setTimeout(this.fireEndResize, $a && $a.duration || 500)
        },
        setChartSize: function() {
            var a = this.inverted,
                b = this.chartWidth,
                c = this.chartHeight,
                d = this.options.chart,
                e = d.spacingTop,
                f = d.spacingRight,
                g = d.spacingBottom,
                d = d.spacingLeft;
            this.plotLeft = u(this.plotLeft);
            this.plotTop = u(this.plotTop);
            this.plotWidth = u(b - this.plotLeft - this.marginRight);
            this.plotHeight = u(c - this.plotTop - this.marginBottom);
            this.plotSizeX = a ? this.plotHeight : this.plotWidth;
            this.plotSizeY = a ? this.plotWidth : this.plotHeight;
            this.spacingBox = {
                x: d,
                y: e,
                width: b - d - f,
                height: c - e - g
            };
            n(this.axes, function(a) {
                a.setAxisSize();
                a.setAxisTranslation()
            })
        },
        resetMargins: function() {
            var a = this.options.chart,
                b = a.spacingRight,
                c = a.spacingBottom,
                d = a.spacingLeft;
            this.plotTop = p(this.optionsMarginTop, a.spacingTop);
            this.marginRight = p(this.optionsMarginRight, b);
            this.marginBottom = p(this.optionsMarginBottom, c);
            this.plotLeft = p(this.optionsMarginLeft, d);
            this.axisOffset = [0, 0, 0, 0]
        },
        drawChartBox: function() {
            var a = this.options.chart,
                b = this.renderer,
                c = this.chartWidth,
                d = this.chartHeight,
                e = this.chartBackground,
                f = this.plotBackground,
                g = this.plotBorder,
                h = this.plotBGImage,
                k = a.borderWidth || 0,
                i = a.backgroundColor,
                j = a.plotBackgroundColor,
                l = a.plotBackgroundImage,
                m, o = {
                    x: this.plotLeft,
                    y: this.plotTop,
                    width: this.plotWidth,
                    height: this.plotHeight
                };
            m = k + (a.shadow ? 8 : 0);
            if (k || i)
                if (e) e.animate(e.crisp(null, null, null, c - m, d - m));
                else {
                    e = {
                        fill: i || da
                    };
                    if (k) e.stroke = a.borderColor, e["stroke-width"] = k;
                    this.chartBackground = b.rect(m / 2, m / 2, c - m, d - m, a.borderRadius, k).attr(e).add().shadow(a.shadow)
                } if (j) f ? f.animate(o) : this.plotBackground = b.rect(this.plotLeft, this.plotTop, this.plotWidth, this.plotHeight, 0).attr({
                fill: j
            }).add().shadow(a.plotShadow);
            if (l) h ? h.animate(o) : this.plotBGImage = b.image(l, this.plotLeft, this.plotTop, this.plotWidth, this.plotHeight).add();
            if (a.plotBorderWidth) g ? g.animate(g.crisp(null, this.plotLeft, this.plotTop, this.plotWidth, this.plotHeight)) : this.plotBorder = b.rect(this.plotLeft, this.plotTop, this.plotWidth, this.plotHeight, 0, a.plotBorderWidth).attr({
                stroke: a.plotBorderColor,
                "stroke-width": a.plotBorderWidth,
                zIndex: 4
            }).add();
            this.isDirtyBox = !1
        },
        propFromSeries: function() {
            var a = this,
                b = a.options.chart,
                c, d = a.options.series,
                e, f;
            n(["inverted", "angular", "polar"], function(g) {
                c = U[b.type || b.defaultSeriesType];
                f = a[g] || b[g] || c && c.prototype[g];
                for (e = d && d.length; !f && e--;)(c = U[d[e].type]) && c.prototype[g] && (f = !0);
                a[g] = f
            })
        },
        render: function() {
            var a = this,
                b = a.axes,
                c = a.renderer,
                d = a.options,
                e = d.labels,
                d = d.credits,
                f;
            a.setTitle();
            a.legend = new xb(a);
            n(b, function(a) {
                a.setScale()
            });
            a.getMargins();
            a.maxTicks = null;
            n(b, function(a) {
                a.setTickPositions(!0);
                a.setMaxTicks()
            });
            a.adjustTickAmounts();
            a.getMargins();
            a.drawChartBox();
            a.hasCartesianSeries && n(b, function(a) {
                a.render()
            });
            if (!a.seriesGroup) a.seriesGroup = c.g("series-group").attr({
                zIndex: 3
            }).add();
            n(a.series, function(a) {
                a.translate();
                a.setTooltipPoints();
                a.render()
            });
            e.items && n(e.items, function() {
                var b = z(e.style, this.style),
                    d = F(b.left) + a.plotLeft,
                    f = F(b.top) + a.plotTop + 12;
                delete b.left;
                delete b.top;
                c.text(this.html, d, f).attr({
                    zIndex: 2
                }).css(b).add()
            });
            if (d.enabled && !a.credits) f = d.href, a.credits = c.text(d.text, 0, 0).on("click", function() {
                if (f) location.href = f
            }).attr({
                align: d.position.align,
                zIndex: 8
            }).css(d.style).add().align(d.position);
            a.hasRendered = !0
        },
        destroy: function() {
            var a = this,
                b = a.axes,
                c = a.series,
                d = a.container,
                e, f = d && d.parentNode;
            if (a !== null) {
                N(a, "destroy");
                Q(a);
                for (e = b.length; e--;) b[e] = b[e].destroy();
                for (e = c.length; e--;) c[e] = c[e].destroy();
                n("title,subtitle,chartBackground,plotBackground,plotBGImage,plotBorder,seriesGroup,clipRect,credits,tracker,scroller,rangeSelector,legend,resetZoomButton,tooltip,renderer".split(","), function(b) {
                    var c = a[b];
                    c && (a[b] = c.destroy())
                });
                if (d) d.innerHTML = "", Q(d), f && Na(d), d = null;
                for (e in a) delete a[e];
                a = a.options = null
            }
        },
        firstRender: function() {
            var a = this,
                b = a.options,
                c = a.callback;
            if (!Pa && Y == Y.top && I.readyState !== "complete" || ma && !Y.canvg) ma ? Xb.push(function() {
                a.firstRender()
            }, b.global.canvasToolsURL) : I.attachEvent("onreadystatechange", function() {
                I.detachEvent("onreadystatechange", a.firstRender);
                I.readyState === "complete" && a.firstRender()
            });
            else {
                a.getContainer();
                N(a, "init");
                if (Highcharts.RangeSelector && b.rangeSelector.enabled) a.rangeSelector = new Highcharts.RangeSelector(a);
                a.resetMargins();
                a.setChartSize();
                a.propFromSeries();
                a.getAxes();
                n(b.series || [], function(b) {
                    a.initSeries(b)
                });
                if (Highcharts.Scroller && (b.navigator.enabled || b.scrollbar.enabled)) a.scroller = new Highcharts.Scroller(a);
                a.tracker = new Kb(a, b);
                a.render();
                a.renderer.draw();
                c && c.apply(a, [a]);
                n(a.callbacks, function(b) {
                    b.apply(a, [a])
                });
                a.cloneRenderTo(!0);
                N(a, "load")
            }
        },
        init: function(a) {
            var b = this.options.chart,
                c;
            b.reflow !== !1 && B(this, "load", this.initReflow);
            if (a)
                for (c in a) B(this, c, a[c]);
            this.xAxis = [];
            this.yAxis = [];
            this.animation = ma ? !1 : p(b.animation, !0);
            this.setSize = this.resize;
            this.pointCount = 0;
            this.counters = new Hb;
            this.firstRender()
        }
    };
    cb.prototype.callbacks = [];
    var xa = function() {};
    xa.prototype = {
        init: function(a, b, c) {
            var d = a.chart.counters;
            this.series = a;
            this.applyOptions(b, c);
            this.pointAttr = {};
            if (a.options.colorByPoint) {
                b = a.chart.options.colors;
                if (!this.options) this.options = {};
                this.color = this.options.color = this.color || b[d.color++];
                d.wrapColor(b.length)
            }
            a.chart.pointCount++;
            return this
        },
        applyOptions: function(a, b) {
            var c = this.series,
                d = typeof a;
            this.config = a;
            if (d === "number" || a === null) this.y = a;
            else if (typeof a[0] === "number") this.x = a[0], this.y = a[1];
            else if (d === "object" && typeof a.length !== "number") {
                if (z(this, a), this.options = a, a.dataLabels) c._hasPointLabels = !0
            } else if (typeof a[0] === "string") this.name = a[0], this.y = a[1];
            if (this.x === v) this.x = b === v ? c.autoIncrement() : b
        },
        destroy: function() {
            var a = this.series.chart,
                b = a.hoverPoints,
                c;
            a.pointCount--;
            if (b && (this.setState(), Ka(b, this), !b.length)) a.hoverPoints = null;
            if (this === a.hoverPoint) this.onMouseOut();
            if (this.graphic || this.dataLabel) Q(this), this.destroyElements();
            this.legendItem && a.legend.destroyItem(this);
            for (c in this) this[c] = null
        },
        destroyElements: function() {
            for (var a = "graphic,tracker,dataLabel,group,connector,shadowGroup".split(","), b, c = 6; c--;) b = a[c], this[b] && (this[b] = this[b].destroy())
        },
        getLabelConfig: function() {
            return {
                x: this.category,
                y: this.y,
                key: this.name || this.category,
                series: this.series,
                point: this,
                percentage: this.percentage,
                total: this.total || this.stackTotal
            }
        },
        select: function(a, b) {
            var c = this,
                d = c.series.chart,
                a = p(a, !c.selected);
            c.firePointEvent(a ? "select" : "unselect", {
                accumulate: b
            }, function() {
                c.selected = a;
                c.setState(a && "select");
                b || n(d.getSelectedPoints(), function(a) {
                    if (a.selected && a !== c) a.selected = !1, a.setState(""), a.firePointEvent("unselect")
                })
            })
        },
        onMouseOver: function() {
            var a = this.series,
                b = a.chart,
                c = b.tooltip,
                d = b.hoverPoint;
            if (d && d !== this) d.onMouseOut();
            this.firePointEvent("mouseOver");
            c && (!c.shared || a.noSharedTooltip) && c.refresh(this);
            this.setState("hover");
            b.hoverPoint = this
        },
        onMouseOut: function() {
            this.firePointEvent("mouseOut");
            this.setState();
            this.series.chart.hoverPoint = null
        },
        tooltipFormatter: function(a) {
            var b = this.series,
                c = b.tooltipOptions,
                d = a.match(/\{(series|point)\.[a-zA-Z]+\}/g),
                e = /[{\.}]/,
                f, g, h, k, i = {
                    y: 0,
                    open: 0,
                    high: 0,
                    low: 0,
                    close: 0,
                    percentage: 1,
                    total: 1
                };
            c.valuePrefix = c.valuePrefix || c.yPrefix;
            c.valueDecimals = c.valueDecimals || c.yDecimals;
            c.valueSuffix = c.valueSuffix || c.ySuffix;
            for (k in d) g = d[k], ya(g) && g !== a && (h = (" " + g).split(e), f = {
                point: this,
                series: b
            } [h[1]], h = h[2], f === this && i.hasOwnProperty(h) ? (f = i[h] ? h : "value", f = (c[f + "Prefix"] || "") + Ya(this[h], p(c[f + "Decimals"], -1)) + (c[f + "Suffix"] || "")) : f = f[h], a = a.replace(g, f));
            return a
        },
        update: function(a, b, c) {
            var d = this,
                e = d.series,
                f = d.graphic,
                g, h = e.data,
                k = h.length,
                i = e.chart,
                b = p(b, !0);
            d.firePointEvent("update", {
                options: a
            }, function() {
                d.applyOptions(a);
                ia(a) && (e.getAttribs(), f && f.attr(d.pointAttr[e.state]));
                for (g = 0; g < k; g++)
                    if (h[g] === d) {
                        e.xData[g] = d.x;
                        e.yData[g] = d.y;
                        e.options.data[g] = a;
                        break
                    } e.isDirty = !0;
                e.isDirtyData = !0;
                b && i.redraw(c)
            })
        },
        remove: function(a, b) {
            var c = this,
                d = c.series,
                e = d.chart,
                f, g = d.data,
                h = g.length;
            Ea(b, e);
            a = p(a, !0);
            c.firePointEvent("remove", null, function() {
                for (f = 0; f < h; f++)
                    if (g[f] === c) {
                        g.splice(f, 1);
                        d.options.data.splice(f, 1);
                        d.xData.splice(f, 1);
                        d.yData.splice(f, 1);
                        break
                    } c.destroy();
                d.isDirty = !0;
                d.isDirtyData = !0;
                a && e.redraw()
            })
        },
        firePointEvent: function(a, b, c) {
            var d = this,
                e = this.series.options;
            (e.point.events[a] || d.options && d.options.events && d.options.events[a]) && this.importEvents();
            a === "click" && e.allowPointSelect && (c = function(a) {
                d.select(null, a.ctrlKey || a.metaKey || a.shiftKey)
            });
            N(this, a, b, c)
        },
        importEvents: function() {
            if (!this.hasImportedEvents) {
                var a = y(this.series.options.point, this.options).events,
                    b;
                this.events = a;
                for (b in a) B(this, b, a[b]);
                this.hasImportedEvents = !0
            }
        },
        setState: function(a) {
            var b = this.plotX,
                c = this.plotY,
                d = this.series,
                e = d.options.states,
                f = S[d.type].marker && d.options.marker,
                g = f && !f.enabled,
                h = f && f.states[a],
                k = h && h.enabled === !1,
                i = d.stateMarkerGraphic,
                j = d.chart,
                l = this.pointAttr,
                a = a || "";
            if (!(a === this.state || this.selected && a !== "select" || e[a] && e[a].enabled === !1 || a && (k || g && !h.enabled))) {
                if (this.graphic) e = f && this.graphic.symbolName && l[a].r, this.graphic.attr(y(l[a], e ? {
                    x: b - e,
                    y: c - e,
                    width: 2 * e,
                    height: 2 * e
                } : {}));
                else {
                    if (a && h) {
                        if (!i) e = h.radius, d.stateMarkerGraphic = i = j.renderer.symbol(d.symbol, -e, -e, 2 * e, 2 * e).attr(l[a]).add(d.group);
                        i.translate(b, c)
                    }
                    if (i) i[a ? "show" : "hide"]()
                }
                this.state = a
            }
        }
    };
    var Z = function() {};
    Z.prototype = {
        isCartesian: !0,
        type: "line",
        pointClass: xa,
        sorted: !0,
        pointAttrToOptions: {
            stroke: "lineColor",
            "stroke-width": "lineWidth",
            fill: "fillColor",
            r: "radius"
        },
        init: function(a, b) {
            var c, d;
            d = a.series.length;
            this.chart = a;
            this.options = b = this.setOptions(b);
            this.bindAxes();
            z(this, {
                index: d,
                name: b.name || "Series " + (d + 1),
                state: "",
                pointAttr: {},
                visible: b.visible !== !1,
                selected: b.selected === !0
            });
            if (ma) b.animation = !1;
            d = b.events;
            for (c in d) B(this, c, d[c]);
            if (d && d.click || b.point && b.point.events && b.point.events.click || b.allowPointSelect) a.runTrackerClick = !0;
            this.getColor();
            this.getSymbol();
            this.setData(b.data, !1);
            if (this.isCartesian) a.hasCartesianSeries = !0;
            a.series.push(this)
        },
        bindAxes: function() {
            var a = this,
                b = a.options,
                c = a.chart,
                d;
            a.isCartesian && n(["xAxis", "yAxis"], function(e) {
                n(c[e], function(c) {
                    d = c.options;
                    if (b[e] === d.index || b[e] === v && d.index === 0) c.series.push(a), a[e] = c, c.isDirty = !0
                })
            })
        },
        autoIncrement: function() {
            var a = this.options,
                b = this.xIncrement,
                b = p(b, a.pointStart, 0);
            this.pointInterval = p(this.pointInterval, a.pointInterval, 1);
            this.xIncrement = b + this.pointInterval;
            return b
        },
        getSegments: function() {
            var a = -1,
                b = [],
                c, d = this.points,
                e = d.length;
            if (e)
                if (this.options.connectNulls) {
                    for (c = e; c--;) d[c].y === null && d.splice(c, 1);
                    d.length && (b = [d])
                } else n(d, function(c, g) {
                    c.y === null ? (g > a + 1 && b.push(d.slice(a + 1, g)), a = g) : g === e - 1 && b.push(d.slice(a + 1, g + 1))
                });
            this.segments = b
        },
        setOptions: function(a) {
            var b = this.chart.options,
                c = b.plotOptions,
                d = a.data;
            a.data = null;
            c = y(c[this.type], c.series, a);
            c.data = a.data = d;
            this.tooltipOptions = y(b.tooltip, c.tooltip);
            return c
        },
        getColor: function() {
            var a = this.options,
                b = this.chart.options.colors,
                c = this.chart.counters;
            this.color = a.color || !a.colorByPoint && b[c.color++] || "gray";
            c.wrapColor(b.length)
        },
        getSymbol: function() {
            var a = this.options.marker,
                b = this.chart,
                c = b.options.symbols,
                b = b.counters;
            this.symbol = a.symbol || c[b.symbol++];
            if (/^url/.test(this.symbol)) a.radius = 0;
            b.wrapSymbol(c.length)
        },
        drawLegendSymbol: function(a) {
            var b = this.options,
                c = b.marker,
                d = a.options.symbolWidth,
                e = this.chart.renderer,
                f = this.legendGroup,
                a = a.baseline,
                g;
            if (b.lineWidth) {
                g = {
                    "stroke-width": b.lineWidth
                };
                if (b.dashStyle) g.dashstyle = b.dashStyle;
                this.legendLine = e.path(["M", 0, a - 4, "L", d, a - 4]).attr(g).add(f)
            }
            if (c && c.enabled) b = c.radius, this.legendSymbol = e.symbol(this.symbol, d / 2 - b, a - 4 - b, 2 * b, 2 * b).attr(this.pointAttr[""]).add(f)
        },
        addPoint: function(a, b, c, d) {
            var e = this.data,
                f = this.graph,
                g = this.area,
                h = this.chart,
                k = this.xData,
                i = this.yData,
                j = f && f.shift || 0,
                l = this.options.data;
            Ea(d, h);
            if (f && c) f.shift = j + 1;
            if (g) {
                if (c) g.shift = j + 1;
                g.isArea = !0
            }
            b = p(b, !0);
            d = {
                series: this
            };
            this.pointClass.prototype.applyOptions.apply(d, [a]);
            k.push(d.x);
            i.push(this.valueCount === 4 ? [d.open, d.high, d.low, d.close] : d.y);
            l.push(a);
            c && (e[0] && e[0].remove ? e[0].remove(!1) : (e.shift(), k.shift(), i.shift(), l.shift()));
            this.getAttribs();
            this.isDirtyData = this.isDirty = !0;
            b && h.redraw()
        },
        setData: function(a, b) {
            var c = this.points,
                d = this.options,
                e = this.initialColor,
                f = this.chart,
                g = null,
                h = this.xAxis,
                k = this.pointClass.prototype;
            this.xIncrement = null;
            this.pointRange = h && h.categories && 1 || d.pointRange;
            if (s(e)) f.counters.color = e;
            var i = [],
                j = [],
                l = a ? a.length : [],
                m = this.valueCount;
            if (l > (d.turboThreshold || 1E3)) {
                for (e = 0; g === null && e < l;) g = a[e], e++;
                if (Wa(g)) {
                    k = p(d.pointStart, 0);
                    d = p(d.pointInterval, 1);
                    for (e = 0; e < l; e++) i[e] = k, j[e] = a[e], k += d;
                    this.xIncrement = k
                } else if (Va(g))
                    if (m)
                        for (e = 0; e < l; e++) d = a[e], i[e] = d[0], j[e] = d.slice(1, m + 1);
                    else
                        for (e = 0; e < l; e++) d = a[e], i[e] = d[0], j[e] = d[1]
            } else
                for (e = 0; e < l; e++) d = {
                    series: this
                }, k.applyOptions.apply(d, [a[e]]), i[e] = d.x, j[e] = k.toYData ? k.toYData.apply(d) : d.y;
            this.data = [];
            this.options.data = a;
            this.xData = i;
            this.yData = j;
            for (e = c && c.length || 0; e--;) c[e] && c[e].destroy && c[e].destroy();
            if (h) h.minRange = h.userMinRange;
            this.isDirty = this.isDirtyData = f.isDirtyBox = !0;
            p(b, !0) && f.redraw(!1)
        },
        remove: function(a, b) {
            var c = this,
                d = c.chart,
                a = p(a, !0);
            if (!c.isRemoving) c.isRemoving = !0, N(c, "remove", null, function() {
                c.destroy();
                d.isDirtyLegend = d.isDirtyBox = !0;
                a && d.redraw(b)
            });
            c.isRemoving = !1
        },
        processData: function(a) {
            var b = this.xData,
                c = this.yData,
                d = b.length,
                e = 0,
                f = d,
                g, h, k = this.xAxis,
                i = this.options,
                j = i.cropThreshold,
                l = this.isCartesian;
            if (l && !this.isDirty && !k.isDirty && !this.yAxis.isDirty && !a) return !1;
            if (l && this.sorted && (!j || d > j || this.forceCrop))
                if (a = k.getExtremes(), k = a.min, j = a.max, b[d - 1] < k || b[0] > j) b = [], c = [];
                else if (b[0] < k || b[d - 1] > j) {
                for (a = 0; a < d; a++)
                    if (b[a] >= k) {
                        e = t(0, a - 1);
                        break
                    } for (; a < d; a++)
                    if (b[a] > j) {
                        f = a + 1;
                        break
                    } b = b.slice(e, f);
                c = c.slice(e, f);
                g = !0
            }
            for (a = b.length - 1; a > 0; a--)
                if (d = b[a] - b[a - 1], d > 0 && (h === v || d < h)) h = d;
            this.cropped = g;
            this.cropStart = e;
            this.processedXData = b;
            this.processedYData = c;
            if (i.pointRange === null) this.pointRange = h || 1;
            this.closestPointRange = h
        },
        generatePoints: function() {
            var a = this.options.data,
                b = this.data,
                c, d = this.processedXData,
                e = this.processedYData,
                f = this.pointClass,
                g = d.length,
                h = this.cropStart || 0,
                k, i = this.hasGroupedData,
                j, l = [],
                m;
            if (!b && !i) b = [], b.length = a.length, b = this.data = b;
            for (m = 0; m < g; m++) k = h + m, i ? l[m] = (new f).init(this, [d[m]].concat(la(e[m]))) : (b[k] ? j = b[k] : a[k] !== v && (b[k] = j = (new f).init(this, a[k], d[m])), l[m] = j);
            if (b && (g !== (c = b.length) || i))
                for (m = 0; m < c; m++)
                    if (m === h && !i && (m += g), b[m]) b[m].destroyElements(), b[m].plotX = v;
            this.data = b;
            this.points = l
        },
        translate: function() {
            this.processedXData || this.processData();
            this.generatePoints();
            for (var a = this.chart, b = this.options, c = b.stacking, d = this.xAxis, e = d.categories, f = this.yAxis, g = this.points, h = g.length, k = !!this.modifyValue, i, j = f.series, l = j.length; l--;)
                if (j[l].visible) {
                    l === this.index && (i = !0);
                    break
                } for (l = 0; l < h; l++) {
                var j = g[l],
                    m = j.x,
                    o = j.y,
                    r = j.low,
                    n = f.stacks[(o < b.threshold ? "-" : "") + this.stackKey];
                j.plotX = d.translate(m, 0, 0, 0, 1);
                if (c && this.visible && n && n[m]) {
                    r = n[m];
                    m = r.total;
                    r.cum = r = r.cum - o;
                    o = r + o;
                    if (i) r = b.threshold;
                    c === "percent" && (r = m ? r * 100 / m : 0, o = m ? o * 100 / m : 0);
                    j.percentage = m ? j.y * 100 / m : 0;
                    j.stackTotal = m;
                    j.stackY = o
                }
                j.yBottom = s(r) ? f.translate(r, 0, 1, 0, 1) : null;
                k && (o = this.modifyValue(o, j));
                j.plotY = typeof o === "number" ? u(f.translate(o, 0, 1, 0, 1) * 10) / 10 : v;
                j.clientX = a.inverted ? a.plotHeight - j.plotX : j.plotX;
                j.category = e && e[j.x] !== v ? e[j.x] : j.x
            }
            this.getSegments()
        },
        setTooltipPoints: function(a) {
            var b = [],
                c = this.chart.plotSizeX,
                d, e;
            d = this.xAxis;
            var f, g, h = [];
            if (this.options.enableMouseTracking !== !1) {
                if (a) this.tooltipPoints = null;
                n(this.segments || this.points, function(a) {
                    b = b.concat(a)
                });
                d && d.reversed && (b = b.reverse());
                a = b.length;
                for (g = 0; g < a; g++) {
                    f = b[g];
                    d = b[g - 1] ? b[g - 1]._high + 1 : 0;
                    for (f._high = e = b[g + 1] ? t(0, $((f.plotX + (b[g + 1] ? b[g + 1].plotX : c)) / 2)) : c; d >= 0 && d <= e;) h[d++] = f
                }
                this.tooltipPoints = h
            }
        },
        tooltipHeaderFormatter: function(a) {
            var b = this.tooltipOptions,
                c = b.xDateFormat,
                d = this.xAxis,
                e = d && d.options.type === "datetime",
                f;
            if (e && !c)
                for (f in E)
                    if (E[f] >= d.closestPointRange) {
                        c = b.dateTimeLabelFormats[f];
                        break
                    } return b.headerFormat.replace("{point.key}", e ? ua(c, a) : a).replace("{series.name}", this.name).replace("{series.color}", this.color)
        },
        onMouseOver: function() {
            var a = this.chart,
                b = a.hoverSeries;
            if (aa || !a.mouseIsDown) {
                if (b && b !== this) b.onMouseOut();
                this.options.events.mouseOver && N(this, "mouseOver");
                this.setState("hover");
                a.hoverSeries = this
            }
        },
        onMouseOut: function() {
            var a = this.options,
                b = this.chart,
                c = b.tooltip,
                d = b.hoverPoint;
            if (d) d.onMouseOut();
            this && a.events.mouseOut && N(this, "mouseOut");
            c && !a.stickyTracking && !c.shared && c.hide();
            this.setState();
            b.hoverSeries = null
        },
        animate: function(a) {
            var b = this.chart,
                c = this.clipRect,
                d = this.options.animation;
            d && !ia(d) && (d = {});
            if (a) {
                if (!c.isAnimating) c.attr("width", 0), c.isAnimating = !0
            } else c.animate({
                width: b.plotSizeX
            }, d), this.animate = null
        },
        drawPoints: function() {
            var a, b = this.points,
                c = this.chart,
                d, e, f, g, h, k, i, j;
            if (this.options.marker.enabled)
                for (f = b.length; f--;)
                    if (g = b[f], d = g.plotX, e = g.plotY, j = g.graphic, e !== v && !isNaN(e))
                        if (a = g.pointAttr[g.selected ? "select" : ""], h = a.r, k = p(g.marker && g.marker.symbol, this.symbol), i = k.indexOf("url") === 0, j) j.animate(z({
                            x: d - h,
                            y: e - h
                        }, j.symbolName ? {
                            width: 2 * h,
                            height: 2 * h
                        } : {}));
                        else if (h > 0 || i) g.graphic = c.renderer.symbol(k, d - h, e - h, 2 * h, 2 * h).attr(a).add(this.group)
        },
        convertAttribs: function(a, b, c, d) {
            var e = this.pointAttrToOptions,
                f, g, h = {},
                a = a || {},
                b = b || {},
                c = c || {},
                d = d || {};
            for (f in e) g = e[f], h[f] = p(a[g], b[f], c[f], d[f]);
            return h
        },
        getAttribs: function() {
            var a = this,
                b = S[a.type].marker ? a.options.marker : a.options,
                c = b.states,
                d = c.hover,
                e, f = a.color,
                g = {
                    stroke: f,
                    fill: f
                },
                h = a.points || [],
                k = [],
                i, j = a.pointAttrToOptions,
                l;
            a.options.marker ? (d.radius = d.radius || b.radius + 2, d.lineWidth = d.lineWidth || b.lineWidth + 1) : d.color = d.color || wa(d.color || f).brighten(d.brightness).get();
            k[""] = a.convertAttribs(b, g);
            n(["hover", "select"], function(b) {
                k[b] = a.convertAttribs(c[b], k[""])
            });
            a.pointAttr = k;
            for (f = h.length; f--;) {
                g = h[f];
                if ((b = g.options && g.options.marker || g.options) && b.enabled === !1) b.radius = 0;
                e = !1;
                if (g.options)
                    for (l in j) s(b[j[l]]) && (e = !0);
                if (e) {
                    i = [];
                    c = b.states || {};
                    e = c.hover = c.hover || {};
                    if (!a.options.marker) e.color = wa(e.color || g.options.color).brighten(e.brightness || d.brightness).get();
                    i[""] = a.convertAttribs(b, k[""]);
                    i.hover = a.convertAttribs(c.hover, k.hover, i[""]);
                    i.select = a.convertAttribs(c.select, k.select, i[""])
                } else i = k;
                g.pointAttr = i
            }
        },
        destroy: function() {
            var a = this,
                b = a.chart,
                c = a.clipRect,
                d = /AppleWebKit\/533/.test(Ia),
                e, f, g = a.data || [],
                h, k, i;
            N(a, "destroy");
            Q(a);
            n(["xAxis", "yAxis"], function(b) {
                if (i = a[b]) Ka(i.series, a), i.isDirty = !0
            });
            a.legendItem && a.chart.legend.destroyItem(a);
            for (f = g.length; f--;)(h = g[f]) && h.destroy && h.destroy();
            a.points = null;
            if (c && c !== b.clipRect) a.clipRect = c.destroy();
            n("area,graph,dataLabelsGroup,group,tracker,trackerGroup".split(","), function(b) {
                a[b] && (e = d && b === "group" ? "hide" : "destroy", a[b][e]())
            });
            if (b.hoverSeries === a) b.hoverSeries = null;
            Ka(b.series, a);
            for (k in a) delete a[k]
        },
        drawDataLabels: function() {
            var a = this,
                b = a.options,
                c = b.dataLabels;
            if (c.enabled || a._hasPointLabels) {
                var d, e, f = a.points,
                    g, h, k, i = a.dataLabelsGroup,
                    j = a.chart,
                    l = a.xAxis,
                    l = l ? l.left : j.plotLeft,
                    m = a.yAxis,
                    m = m ? m.top : j.plotTop,
                    o = j.renderer,
                    r = j.inverted,
                    A = a.type,
                    q = b.stacking,
                    C = A === "column" || A === "bar",
                    J = c.verticalAlign === null,
                    w = c.y === null,
                    x = o.fontMetrics(c.style.fontSize),
                    D = x.h,
                    K = x.b,
                    H, t;
                C && (x = {
                    top: K,
                    middle: K - D / 2,
                    bottom: -D + K
                }, q ? (J && (c = y(c, {
                    verticalAlign: "middle"
                })), w && (c = y(c, {
                    y: x[c.verticalAlign]
                }))) : J ? c = y(c, {
                    verticalAlign: "top"
                }) : w && (c = y(c, {
                    y: x[c.verticalAlign]
                })));
                i ? i.translate(l, m) : i = a.dataLabelsGroup = o.g("data-labels").attr({
                    visibility: a.visible ? "visible" : "hidden",
                    zIndex: 6
                }).translate(l, m).add();
                h = c;
                n(f, function(f) {
                    H = f.dataLabel;
                    c = h;
                    (g = f.options) && g.dataLabels && (c = y(c, g.dataLabels));
                    if (t = c.enabled) {
                        var l = f.barX && f.barX + f.barW / 2 || p(f.plotX, -999),
                            m = p(f.plotY, -999),
                            n = c.y === null ? f.y >= b.threshold ? -D + K : K : c.y;
                        d = (r ? j.plotWidth - m : l) + c.x;
                        e = u((r ? j.plotHeight - l : m) + n)
                    }
                    if (H && a.isCartesian && (!j.isInsidePlot(d, e) || !t)) f.dataLabel = H.destroy();
                    else if (t) {
                        var l = c.align,
                            w;
                        k = c.formatter.call(f.getLabelConfig(), c);
                        A === "column" && (d += {
                            left: -1,
                            right: 1
                        } [l] * f.barW / 2 || 0);
                        !q && r && f.y < 0 && (l = "right", d -= 10);
                        c.style.color = p(c.color, c.style.color, a.color, "black");
                        if (H) H.attr({
                            text: k
                        }).animate({
                            x: d,
                            y: e
                        });
                        else if (s(k)) {
                            l = {
                                align: l,
                                fill: c.backgroundColor,
                                stroke: c.borderColor,
                                "stroke-width": c.borderWidth,
                                r: c.borderRadius || 0,
                                rotation: c.rotation,
                                padding: c.padding,
                                zIndex: 1
                            };
                            for (w in l) l[w] === v && delete l[w];
                            H = f.dataLabel = o[c.rotation ? "text" : "label"](k, d, e, null, null, null, c.useHTML, !0).attr(l).css(c.style).add(i).shadow(c.shadow)
                        }
                        if (C && b.stacking && H) w = f.barX, l = f.barY, m = f.barW, f = f.barH, H.align(c, null, {
                            x: r ? j.plotWidth - l - f : w,
                            y: r ? j.plotHeight - w - m : l,
                            width: r ? f : m,
                            height: r ? m : f
                        })
                    }
                })
            }
        },
        getSegmentPath: function(a) {
            var b = this,
                c = [];
            n(a, function(d, e) {
                b.getPointSpline ? c.push.apply(c, b.getPointSpline(a, d, e)) : (c.push(e ? "L" : "M"), e && b.options.step && c.push(d.plotX, a[e - 1].plotY), c.push(d.plotX, d.plotY))
            });
            return c
        },
        drawGraph: function() {
            var a = this,
                b = a.options,
                c = a.graph,
                d = [],
                e = a.group,
                f = b.lineColor || a.color,
                g = b.lineWidth,
                h = b.dashStyle,
                k, i = a.chart.renderer,
                j = [];
            n(a.segments, function(b) {
                k = a.getSegmentPath(b);
                b.length > 1 ? d = d.concat(k) : j.push(b[0])
            });
            a.graphPath = d;
            a.singlePoints = j;
            if (c) Ra(c), c.animate({
                d: d
            });
            else if (g) {
                c = {
                    stroke: f,
                    "stroke-width": g
                };
                if (h) c.dashstyle = h;
                a.graph = i.path(d).attr(c).add(e).shadow(b.shadow)
            }
        },
        invertGroups: function() {
            function a() {
                var a = {
                    width: b.yAxis.len,
                    height: b.xAxis.len
                };
                c.attr(a).invert();
                d && d.attr(a).invert()
            }
            var b = this,
                c = b.group,
                d = b.trackerGroup,
                e = b.chart;
            B(e, "resize", a);
            B(b, "destroy", function() {
                Q(e, "resize", a)
            });
            a();
            b.invertGroups = a
        },
        createGroup: function() {
            var a = this.chart;
            (this.group = a.renderer.g("series")).attr({
                visibility: this.visible ? "visible" : "hidden",
                zIndex: this.options.zIndex
            }).translate(this.xAxis.left, this.yAxis.top).add(a.seriesGroup);
            this.createGroup = Rb
        },
        render: function() {
            var a = this,
                b = a.chart,
                c, d = a.options,
                e = d.clip !== !1,
                f = d.animation,
                f = (d = f && a.animate) ? f && f.duration || 500 : 0,
                g = a.clipRect,
                h = b.renderer;
            if (!g && (g = a.clipRect = !b.hasRendered && b.clipRect ? b.clipRect : h.clipRect(0, 0, b.plotSizeX, b.plotSizeY + 1), !b.clipRect)) b.clipRect = g;
            a.createGroup();
            c = a.group;
            a.drawDataLabels();
            d && a.animate(!0);
            a.getAttribs();
            a.drawGraph && a.drawGraph();
            a.drawPoints();
            a.options.enableMouseTracking !== !1 && a.drawTracker();
            b.inverted && a.invertGroups();
            e && !a.hasRendered && (c.clip(g), a.trackerGroup && a.trackerGroup.clip(b.clipRect));
            d && a.animate();
            setTimeout(function() {
                g.isAnimating = !1;
                if ((c = a.group) && g !== b.clipRect && g.renderer) {
                    if (e) c.clip(a.clipRect = b.clipRect);
                    g.destroy()
                }
            }, f);
            a.isDirty = a.isDirtyData = !1;
            a.hasRendered = !0
        },
        redraw: function() {
            var a = this.chart,
                b = this.isDirtyData,
                c = this.group;
            c && (a.inverted && c.attr({
                width: a.plotWidth,
                height: a.plotHeight
            }), c.animate({
                translateX: this.xAxis.left,
                translateY: this.yAxis.top
            }));
            this.translate();
            this.setTooltipPoints(!0);
            this.render();
            b && N(this, "updatedData")
        },
        setState: function(a) {
            var b = this.options,
                c = this.graph,
                d = b.states,
                b = b.lineWidth,
                a = a || "";
            if (this.state !== a) this.state = a, d[a] && d[a].enabled === !1 || (a && (b = d[a].lineWidth || b + 1), c && !c.dashstyle && c.attr({
                "stroke-width": b
            }, a ? 0 : 500))
        },
        setVisible: function(a, b) {
            var c = this.chart,
                d = this.legendItem,
                e = this.group,
                f = this.tracker,
                g = this.dataLabelsGroup,
                h, k = this.points,
                i = c.options.chart.ignoreHiddenSeries;
            h = this.visible;
            h = (this.visible = a = a === v ? !h : a) ? "show" : "hide";
            if (e) e[h]();
            if (f) f[h]();
            else if (k)
                for (e = k.length; e--;)
                    if (f = k[e], f.tracker) f.tracker[h]();
            if (g) g[h]();
            d && c.legend.colorizeItem(this, a);
            this.isDirty = !0;
            this.options.stacking && n(c.series, function(a) {
                if (a.options.stacking && a.visible) a.isDirty = !0
            });
            if (i) c.isDirtyBox = !0;
            b !== !1 && c.redraw();
            N(this, h)
        },
        show: function() {
            this.setVisible(!0)
        },
        hide: function() {
            this.setVisible(!1)
        },
        select: function(a) {
            this.selected = a = a === v ? !this.selected : a;
            if (this.checkbox) this.checkbox.checked = a;
            N(this, a ? "select" : "unselect")
        },
        drawTrackerGroup: function() {
            var a = this.trackerGroup,
                b = this.chart;
            if (this.isCartesian) {
                if (!a) this.trackerGroup = a = b.renderer.g().attr({
                    zIndex: this.options.zIndex || 1
                }).add(b.trackerGroup);
                a.translate(this.xAxis.left, this.yAxis.top)
            }
            return a
        },
        drawTracker: function() {
            var a = this,
                b = a.options,
                c = b.trackByArea,
                d = [].concat(c ? a.areaPath : a.graphPath),
                e = d.length,
                f = a.chart,
                g = f.renderer,
                h = f.options.tooltip.snap,
                k = a.tracker,
                i = b.cursor,
                i = i && {
                    cursor: i
                },
                j = a.singlePoints,
                l = a.drawTrackerGroup(),
                m;
            if (e && !c)
                for (m = e + 1; m--;) d[m] === "M" && d.splice(m + 1, 0, d[m + 1] - h, d[m + 2], "L"), (m && d[m] === "M" || m === e) && d.splice(m, 0, "L", d[m - 2] + h, d[m - 1]);
            for (m = 0; m < j.length; m++) e = j[m], d.push("M", e.plotX - h, e.plotY, "L", e.plotX + h, e.plotY);
            k ? k.attr({
                d: d
            }) : a.tracker = g.path(d).attr({
                isTracker: !0,
                "stroke-linejoin": "bevel",
                visibility: a.visible ? "visible" : "hidden",
                stroke: zb,
                fill: c ? zb : da,
                "stroke-width": b.lineWidth + (c ? 0 : 2 * h)
            }).on(aa ? "touchstart" : "mouseover", function() {
                if (f.hoverSeries !== a) a.onMouseOver()
            }).on("mouseout", function() {
                if (!b.stickyTracking) a.onMouseOut()
            }).css(i).add(l)
        }
    };
    L = ca(Z);
    U.line = L;
    S.area = y(P, {
        threshold: 0
    });
    L = ca(Z, {
        type: "area",
        getSegmentPath: function(a) {
            var b = Z.prototype.getSegmentPath.call(this, a),
                c = [].concat(b),
                d, e = this.options;
            d = b.length;
            var f = this.yAxis.getThreshold(e.threshold);
            d === 3 && c.push("L", b[1], b[2]);
            if (e.stacking && this.type !== "areaspline")
                for (d = a.length - 1; d >= 0; d--) d < a.length - 1 && e.step && c.push(a[d + 1].plotX, a[d].yBottom), c.push(a[d].plotX, a[d].yBottom);
            else c.push("L", a[a.length - 1].plotX, f, "L", a[0].plotX, f);
            this.areaPath = this.areaPath.concat(c);
            return b
        },
        drawGraph: function() {
            this.areaPath = [];
            Z.prototype.drawGraph.apply(this);
            var a = this.areaPath,
                b = this.options,
                c = this.area;
            c ? c.animate({
                d: a
            }) : this.area = this.chart.renderer.path(a).attr({
                fill: p(b.fillColor, wa(this.color).setOpacity(b.fillOpacity || 0.75).get())
            }).add(this.group)
        },
        drawLegendSymbol: function(a, b) {
            b.legendSymbol = this.chart.renderer.rect(0, a.baseline - 11, a.options.symbolWidth, 12, 2).attr({
                zIndex: 3
            }).add(b.legendGroup)
        }
    });
    U.area = L;
    S.spline = y(P);
    ea = ca(Z, {
        type: "spline",
        getPointSpline: function(a, b, c) {
            var d = b.plotX,
                e = b.plotY,
                f = a[c - 1],
                g = a[c + 1],
                h, k, i, j;
            if (c && c < a.length - 1) {
                a = f.plotY;
                i = g.plotX;
                var g = g.plotY,
                    l;
                h = (1.5 * d + f.plotX) / 2.5;
                k = (1.5 * e + a) / 2.5;
                i = (1.5 * d + i) / 2.5;
                j = (1.5 * e + g) / 2.5;
                l = (j - k) * (i - d) / (i - h) + e - j;
                k += l;
                j += l;
                k > a && k > e ? (k = t(a, e), j = 2 * e - k) : k < a && k < e && (k = O(a, e), j = 2 * e - k);
                j > g && j > e ? (j = t(g, e), k = 2 * e - j) : j < g && j < e && (j = O(g, e), k = 2 * e - j);
                b.rightContX = i;
                b.rightContY = j
            }
            c ? (b = ["C", f.rightContX || f.plotX, f.rightContY || f.plotY, h || d, k || e, d, e], f.rightContX = f.rightContY = null) : b = ["M", d, e];
            return b
        }
    });
    U.spline = ea;
    S.areaspline = y(S.area);
    var Ta = L.prototype,
        ea = ca(ea, {
            type: "areaspline",
            getSegmentPath: Ta.getSegmentPath,
            drawGraph: Ta.drawGraph
        });
    U.areaspline = ea;
    S.column = y(P, {
        borderColor: "#FFFFFF",
        borderWidth: 1,
        borderRadius: 0,
        groupPadding: 0.2,
        marker: null,
        pointPadding: 0.1,
        minPointLength: 0,
        cropThreshold: 50,
        pointRange: null,
        states: {
            hover: {
                brightness: 0.1,
                shadow: !1
            },
            select: {
                color: "#C0C0C0",
                borderColor: "#000000",
                shadow: !1
            }
        },
        dataLabels: {
            y: null,
            verticalAlign: null
        },
        threshold: 0
    });
    ea = ca(Z, {
        type: "column",
        tooltipOutsidePlot: !0,
        pointAttrToOptions: {
            stroke: "borderColor",
            "stroke-width": "borderWidth",
            fill: "color",
            r: "borderRadius"
        },
        init: function() {
            Z.prototype.init.apply(this, arguments);
            var a = this,
                b = a.chart;
            b.hasRendered && n(b.series, function(b) {
                if (b.type === a.type) b.isDirty = !0
            })
        },
        translate: function() {
            var a = this,
                b = a.chart,
                c = a.options,
                d = c.stacking,
                e = c.borderWidth,
                f = 0,
                g = a.xAxis,
                h = g.reversed,
                k = {},
                i, j;
            Z.prototype.translate.apply(a);
            n(b.series, function(b) {
                if (b.type === a.type && b.visible && a.options.group === b.options.group) b.options.stacking ? (i = b.stackKey, k[i] === v && (k[i] = f++), j = k[i]) : j = f++, b.columnIndex = j
            });
            var l = a.points,
                g = W(g.transA) * (g.ordinalSlope || c.pointRange || g.closestPointRange || 1),
                m = g * c.groupPadding,
                o = (g - 2 * m) / f,
                r = c.pointWidth,
                A = s(r) ? (o - r) / 2 : o * c.pointPadding,
                q = p(r, o - 2 * A),
                C = Ga(t(q, 1 + 2 * e)),
                u = A + (m + ((h ? f - a.columnIndex : a.columnIndex) || 0) * o - g / 2) * (h ? -1 : 1),
                w = a.yAxis.getThreshold(c.threshold),
                x = p(c.minPointLength, 5);
            n(l, function(c) {
                var f = c.plotY,
                    g = p(c.yBottom, w),
                    h = c.plotX + u,
                    i = Ga(O(f, g)),
                    k = Ga(t(f, g) - i),
                    j = a.yAxis.stacks[(c.y < 0 ? "-" : "") + a.stackKey];
                d && a.visible && j && j[c.x] && j[c.x].setOffset(u, C);
                W(k) < x && x && (k = x, i = W(i - w) > x ? g - x : w - (f <= w ? x : 0));
                z(c, {
                    barX: h,
                    barY: i,
                    barW: C,
                    barH: k,
                    pointWidth: q
                });
                c.shapeType = "rect";
                c.shapeArgs = f = b.renderer.Element.prototype.crisp.call(0, e, h, i, C, k);
                e % 2 && (f.y -= 1, f.height += 1);
                c.trackerArgs = W(k) < 3 && y(c.shapeArgs, {
                    height: 6,
                    y: i - 3
                })
            })
        },
        getSymbol: function() {},
        drawLegendSymbol: L.prototype.drawLegendSymbol,
        drawGraph: function() {},
        drawPoints: function() {
            var a = this,
                b = a.options,
                c = a.chart.renderer,
                d, e;
            n(a.points, function(f) {
                var g = f.plotY;
                if (g !== v && !isNaN(g) && f.y !== null) d = f.graphic, e = f.shapeArgs, d ? (Ra(d), d.animate(y(e))) : f.graphic = d = c[f.shapeType](e).attr(f.pointAttr[f.selected ? "select" : ""]).add(a.group).shadow(b.shadow, null, b.stacking && !b.borderRadius)
            })
        },
        drawTracker: function() {
            var a = this,
                b = a.chart,
                c = b.renderer,
                d, e, f = +new Date,
                g = a.options,
                h = g.cursor,
                k = h && {
                    cursor: h
                },
                i = a.drawTrackerGroup(),
                j, l, m;
            n(a.points, function(h) {
                e = h.tracker;
                d = h.trackerArgs || h.shapeArgs;
                l = h.plotY;
                m = !a.isCartesian || l !== v && !isNaN(l);
                delete d.strokeWidth;
                if (h.y !== null && m) e ? e.attr(d) : h.tracker = c[h.shapeType](d).attr({
                    isTracker: f,
                    fill: zb,
                    visibility: a.visible ? "visible" : "hidden"
                }).on(aa ? "touchstart" : "mouseover", function(c) {
                    j = c.relatedTarget || c.fromElement;
                    if (b.hoverSeries !== a && G(j, "isTracker") !== f) a.onMouseOver();
                    h.onMouseOver()
                }).on("mouseout", function(b) {
                    if (!g.stickyTracking && (j = b.relatedTarget || b.toElement, G(j, "isTracker") !== f)) a.onMouseOut()
                }).css(k).add(h.group || i)
            })
        },
        animate: function(a) {
            var b = this,
                c = b.points,
                d = b.options;
            if (!a) n(c, function(a) {
                var c = a.graphic,
                    a = a.shapeArgs,
                    g = b.yAxis,
                    h = d.threshold;
                c && (c.attr({
                    height: 0,
                    y: s(h) ? g.getThreshold(h) : g.translate(g.getExtremes().min, 0, 1, 0, 1)
                }), c.animate({
                    height: a.height,
                    y: a.y
                }, d.animation))
            }), b.animate = null
        },
        remove: function() {
            var a = this,
                b = a.chart;
            b.hasRendered && n(b.series, function(b) {
                if (b.type === a.type) b.isDirty = !0
            });
            Z.prototype.remove.apply(a, arguments)
        }
    });
    U.column = ea;
    S.bar = y(S.column, {
        dataLabels: {
            align: "left",
            x: 5,
            y: null,
            verticalAlign: "middle"
        }
    });
    Ta = ca(ea, {
        type: "bar",
        inverted: !0
    });
    U.bar = Ta;
    S.scatter = y(P, {
        lineWidth: 0,
        states: {
            hover: {
                lineWidth: 0
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size: 10px; color:{series.color}">{series.name}</span><br/>',
            pointFormat: "x: <b>{point.x}</b><br/>y: <b>{point.y}</b><br/>"
        }
    });
    Ta = ca(Z, {
        type: "scatter",
        sorted: !1,
        translate: function() {
            var a = this;
            Z.prototype.translate.apply(a);
            n(a.points, function(b) {
                b.shapeType = "circle";
                b.shapeArgs = {
                    x: b.plotX,
                    y: b.plotY,
                    r: a.chart.options.tooltip.snap
                }
            })
        },
        drawTracker: function() {
            for (var a = this, b = a.options.cursor, b = b && {
                    cursor: b
                }, c = a.points, d = c.length, e; d--;)
                if (e = c[d].graphic) e.element._i = d;
            a._hasTracking ? a._hasTracking = !0 : a.group.attr({
                isTracker: !0
            }).on(aa ? "touchstart" : "mouseover", function(b) {
                a.onMouseOver();
                if (b.target._i !== v) c[b.target._i].onMouseOver()
            }).on("mouseout", function() {
                if (!a.options.stickyTracking) a.onMouseOut()
            }).css(b)
        }
    });
    U.scatter = Ta;
    S.pie = y(P, {
        borderColor: "#FFFFFF",
        borderWidth: 1,
        center: ["50%", "50%"],
        colorByPoint: !0,
        dataLabels: {
            distance: 30,
            enabled: !0,
            formatter: function() {
                return this.point.name
            },
            y: 5
        },
        legendType: "point",
        marker: null,
        size: "75%",
        showInLegend: !1,
        slicedOffset: 10,
        states: {
            hover: {
                brightness: 0.1,
                shadow: !1
            }
        }
    });
    P = {
        type: "pie",
        isCartesian: !1,
        pointClass: ca(xa, {
            init: function() {
                xa.prototype.init.apply(this, arguments);
                var a = this,
                    b;
                z(a, {
                    visible: a.visible !== !1,
                    name: p(a.name, "Slice")
                });
                b = function() {
                    a.slice()
                };
                B(a, "select", b);
                B(a, "unselect", b);
                return a
            },
            setVisible: function(a) {
                var b = this.series.chart,
                    c = this.tracker,
                    d = this.dataLabel,
                    e = this.connector,
                    f = this.shadowGroup,
                    g;
                g = (this.visible = a = a === v ? !this.visible : a) ? "show" : "hide";
                this.group[g]();
                if (c) c[g]();
                if (d) d[g]();
                if (e) e[g]();
                if (f) f[g]();
                this.legendItem && b.legend.colorizeItem(this, a)
            },
            slice: function(a, b, c) {
                var d = this.series.chart,
                    e = this.slicedTranslation;
                Ea(c, d);
                p(b, !0);
                a = this.sliced = s(a) ? a : !this.sliced;
                a = {
                    translateX: a ? e[0] : d.plotLeft,
                    translateY: a ? e[1] : d.plotTop
                };
                this.group.animate(a);
                this.shadowGroup && this.shadowGroup.animate(a)
            }
        }),
        pointAttrToOptions: {
            stroke: "borderColor",
            "stroke-width": "borderWidth",
            fill: "color"
        },
        getColor: function() {
            this.initialColor = this.chart.counters.color
        },
        animate: function() {
            var a = this;
            n(a.points, function(b) {
                var c = b.graphic,
                    b = b.shapeArgs,
                    d = -Ha / 2;
                c && (c.attr({
                    r: 0,
                    start: d,
                    end: d
                }), c.animate({
                    r: b.r,
                    start: b.start,
                    end: b.end
                }, a.options.animation))
            });
            a.animate = null
        },
        setData: function(a, b) {
            Z.prototype.setData.call(this, a, !1);
            this.processData();
            this.generatePoints();
            p(b, !0) && this.chart.redraw()
        },
        getCenter: function() {
            var a = this.options,
                b = this.chart,
                c = b.plotWidth,
                d = b.plotHeight,
                a = a.center.concat([a.size, a.innerSize || 0]),
                e = O(c, d),
                f;
            return va(a, function(a, b) {
                return (f = /%$/.test(a)) ? [c, d, e, e][b] * F(a) / 100 : a
            })
        },
        translate: function() {
            this.generatePoints();
            var a = 0,
                b = -0.25,
                c = this.options,
                d = c.slicedOffset,
                e = d + c.borderWidth,
                f, g = this.chart,
                h, k, i, j = this.points,
                l = 2 * Ha,
                m, o, r, p = c.dataLabels.distance;
            this.center = f = this.getCenter();
            this.getX = function(a, b) {
                i = R.asin((a - f[1]) / (f[2] / 2 + p));
                return f[0] + (b ? -1 : 1) * ga(i) * (f[2] / 2 + p)
            };
            n(j, function(b) {
                a += b.y
            });
            n(j, function(c) {
                m = a ? c.y / a : 0;
                h = u(b * l * 1E3) / 1E3;
                b += m;
                k = u(b * l * 1E3) / 1E3;
                c.shapeType = "arc";
                c.shapeArgs = {
                    x: f[0],
                    y: f[1],
                    r: f[2] / 2,
                    innerR: f[3] / 2,
                    start: h,
                    end: k
                };
                i = (k + h) / 2;
                c.slicedTranslation = va([ga(i) * d + g.plotLeft, ka(i) * d + g.plotTop], u);
                o = ga(i) * f[2] / 2;
                r = ka(i) * f[2] / 2;
                c.tooltipPos = [f[0] + o * 0.7, f[1] + r * 0.7];
                c.labelPos = [f[0] + o + ga(i) * p, f[1] + r + ka(i) * p, f[0] + o + ga(i) * e, f[1] + r + ka(i) * e, f[0] + o, f[1] + r, p < 0 ? "center" : i < l / 4 ? "left" : "right", i];
                c.percentage = m * 100;
                c.total = a
            });
            this.setTooltipPoints()
        },
        render: function() {
            this.getAttribs();
            this.drawPoints();
            this.options.enableMouseTracking !== !1 && this.drawTracker();
            this.drawDataLabels();
            this.options.animation && this.animate && this.animate();
            this.isDirty = !1
        },
        drawPoints: function() {
            var a = this,
                b = a.chart,
                c = b.renderer,
                d, e, f, g = a.options.shadow,
                h, k;
            n(a.points, function(i) {
                e = i.graphic;
                k = i.shapeArgs;
                f = i.group;
                h = i.shadowGroup;
                if (g && !h) h = i.shadowGroup = c.g("shadow").attr({
                    zIndex: 4
                }).add();
                if (!f) f = i.group = c.g("point").attr({
                    zIndex: 5
                }).add();
                d = i.sliced ? i.slicedTranslation : [b.plotLeft, b.plotTop];
                f.translate(d[0], d[1]);
                h && h.translate(d[0], d[1]);
                e ? e.animate(k) : i.graphic = e = c.arc(k).setRadialReference(a.center).attr(z(i.pointAttr[""], {
                    "stroke-linejoin": "round"
                })).add(i.group).shadow(g, h);
                i.visible === !1 && i.setVisible(!1)
            })
        },
        drawDataLabels: function() {
            var a = this.data,
                b, c = this.chart,
                d = this.options.dataLabels,
                e = p(d.connectorPadding, 10),
                f = p(d.connectorWidth, 1),
                g, h, k = p(d.softConnector, !0),
                i = d.distance,
                j = this.center,
                l = j[2] / 2,
                m = j[1],
                o = i > 0,
                r = [
                    [],
                    []
                ],
                A, q, C, s, w = 2,
                x;
            if (d.enabled) {
                Z.prototype.drawDataLabels.apply(this);
                n(a, function(a) {
                    a.dataLabel && r[a.labelPos[7] < Ha / 2 ? 0 : 1].push(a)
                });
                r[1].reverse();
                s = function(a, b) {
                    return b.y - a.y
                };
                for (a = r[0][0] && r[0][0].dataLabel && (r[0][0].dataLabel.getBBox().height || 21); w--;) {
                    var D = [],
                        u = [],
                        H = r[w],
                        v = H.length,
                        t;
                    if (i > 0) {
                        for (x = m - l - i; x <= m + l + i; x += a) D.push(x);
                        C = D.length;
                        if (v > C) {
                            h = [].concat(H);
                            h.sort(s);
                            for (x = v; x--;) h[x].rank = x;
                            for (x = v; x--;) H[x].rank >= C && H.splice(x, 1);
                            v = H.length
                        }
                        for (x = 0; x < v; x++) {
                            b = H[x];
                            h = b.labelPos;
                            b = 9999;
                            for (q = 0; q < C; q++) g = W(D[q] - h[1]), g < b && (b = g, t = q);
                            if (t < x && D[x] !== null) t = x;
                            else
                                for (C < v - x + t && D[x] !== null && (t = C - v + x); D[t] === null;) t++;
                            u.push({
                                i: t,
                                y: D[t]
                            });
                            D[t] = null
                        }
                        u.sort(s)
                    }
                    for (x = 0; x < v; x++) {
                        b = H[x];
                        h = b.labelPos;
                        g = b.dataLabel;
                        C = b.visible === !1 ? "hidden" : "visible";
                        A = h[1];
                        if (i > 0) {
                            if (q = u.pop(), t = q.i, q = q.y, A > q && D[t + 1] !== null || A < q && D[t - 1] !== null) q = A
                        } else q = A;
                        A = d.justify ? j[0] + (w ? -1 : 1) * (l + i) : this.getX(t === 0 || t === D.length - 1 ? A : q, w);
                        g.attr({
                            visibility: C,
                            align: h[6]
                        })[g.moved ? "animate" : "attr"]({
                            x: A + d.x + ({
                                left: e,
                                right: -e
                            } [h[6]] || 0),
                            y: q + d.y
                        });
                        g.moved = !0;
                        if (o && f) g = b.connector, h = k ? ["M", A + (h[6] === "left" ? 5 : -5), q, "C", A, q, 2 * h[2] - h[4], 2 * h[3] - h[5], h[2], h[3], "L", h[4], h[5]] : ["M", A + (h[6] === "left" ? 5 : -5), q, "L", h[2], h[3], "L", h[4], h[5]], g ? (g.animate({
                            d: h
                        }), g.attr("visibility", C)) : b.connector = g = this.chart.renderer.path(h).attr({
                            "stroke-width": f,
                            stroke: d.connectorColor || b.color || "#606060",
                            visibility: C,
                            zIndex: 3
                        }).translate(c.plotLeft, c.plotTop).add()
                    }
                }
            }
        },
        drawTracker: ea.prototype.drawTracker,
        drawLegendSymbol: L.prototype.drawLegendSymbol,
        getSymbol: function() {}
    };
    P = ca(Z, P);
    U.pie = P;
    var X = Z.prototype,
        dc = X.processData,
        ec = X.generatePoints,
        fc = X.destroy,
        gc = X.tooltipHeaderFormatter,
        P = {
            approximation: "average",
            groupPixelWidth: 2,
            dateTimeLabelFormats: ha(fb, ["%A, %b %e, %H:%M:%S.%L", "%A, %b %e, %H:%M:%S.%L", "-%H:%M:%S.%L"], Za, ["%A, %b %e, %H:%M:%S", "%A, %b %e, %H:%M:%S", "-%H:%M:%S"], La, ["%A, %b %e, %H:%M", "%A, %b %e, %H:%M", "-%H:%M"], sa, ["%A, %b %e, %H:%M", "%A, %b %e, %H:%M", "-%H:%M"], fa, ["%A, %b %e, %Y", "%A, %b %e", "-%A, %b %e, %Y"], Aa, ["Week from %A, %b %e, %Y", "%A, %b %e", "-%A, %b %e, %Y"], Ba, ["%B %Y", "%B", "-%B %Y"], na, ["%Y", "%Y", "-%Y"])
        },
        Yb = [
            [fb, [1, 2, 5, 10, 20, 25, 50, 100, 200, 500]],
            [Za, [1, 2, 5, 10, 15, 30]],
            [La, [1, 2, 5, 10, 15, 30]],
            [sa, [1, 2, 3, 4, 6, 8, 12]],
            [fa, [1]],
            [Aa, [1]],
            [Ba, [1, 3, 6]],
            [na, null]
        ],
        Ua = {
            sum: function(a) {
                var b = a.length,
                    c;
                if (!b && a.hasNulls) c = null;
                else if (b)
                    for (c = 0; b--;) c += a[b];
                return c
            },
            average: function(a) {
                var b = a.length,
                    a = Ua.sum(a);
                typeof a === "number" && b && (a /= b);
                return a
            },
            open: function(a) {
                return a.length ? a[0] : a.hasNulls ? null : v
            },
            high: function(a) {
                return a.length ? Da(a) : a.hasNulls ? null : v
            },
            low: function(a) {
                return a.length ? Ma(a) : a.hasNulls ? null : v
            },
            close: function(a) {
                return a.length ? a[a.length - 1] : a.hasNulls ? null : v
            },
            ohlc: function(a, b, c, d) {
                a = Ua.open(a);
                b = Ua.high(b);
                c = Ua.low(c);
                d = Ua.close(d);
                if (typeof a === "number" || typeof b === "number" || typeof c === "number" || typeof d === "number") return [a, b, c, d]
            }
        };
    X.groupData = function(a, b, c, d) {
        var e = this.data,
            f = this.options.data,
            g = [],
            h = [],
            k = a.length,
            i, j, l = !!b;
        j = [];
        var m = [],
            o = [],
            n = [],
            p = typeof d === "function" ? d : Ua[d],
            q;
        for (q = 0; q <= k; q++) {
            for (; c[1] !== v && a[q] >= c[1] || q === k;)
                if (i = c.shift(), j = p(j, m, o, n), j !== v && (g.push(i), h.push(j)), j = [], m = [], o = [], n = [], q === k) break;
            if (q === k) break;
            i = l ? b[q] : null;
            if (d === "ohlc") {
                i = this.cropStart + q;
                var t = e && e[i] || this.pointClass.prototype.applyOptions.apply({}, [f[i]]);
                i = t.open;
                var s = t.high,
                    w = t.low,
                    t = t.close;
                if (typeof i === "number") j.push(i);
                else if (i === null) j.hasNulls = !0;
                if (typeof s === "number") m.push(s);
                else if (s === null) m.hasNulls = !0;
                if (typeof w === "number") o.push(w);
                else if (w === null) o.hasNulls = !0;
                if (typeof t === "number") n.push(t);
                else if (t === null) n.hasNulls = !0
            } else if (typeof i === "number") j.push(i);
            else if (i === null) j.hasNulls = !0
        }
        return [g, h]
    };
    X.processData = function() {
        var a = this.options,
            b = a.dataGrouping,
            c = b && b.enabled,
            d;
        this.forceCrop = c;
        if (dc.apply(this, arguments) !== !1 && c) {
            this.destroyGroupedData();
            var e;
            e = this.chart;
            var c = this.processedXData,
                f = this.processedYData,
                g = e.plotSizeX,
                h = this.xAxis,
                k = p(h.groupPixelWidth, b.groupPixelWidth),
                i = c.length,
                j = e.series,
                l = this.pointRange;
            if (!h.groupPixelWidth) {
                for (e = j.length; e--;) j[e].xAxis === h && j[e].options.dataGrouping && (k = t(k, j[e].options.dataGrouping.groupPixelWidth));
                h.groupPixelWidth = k
            }
            if (i > g / k || i && b.forced) {
                d = !0;
                this.points = null;
                e = h.getExtremes();
                i = e.min;
                j = e.max;
                e = h.getGroupIntervalFactor && h.getGroupIntervalFactor(i, j, c) || 1;
                g = k * (j - i) / g * e;
                h = (h.getNonLinearTimeTicks || gb)(Cb(g, b.units || Yb), i, j, null, c, this.closestPointRange);
                f = X.groupData.apply(this, [c, f, h, b.approximation]);
                c = f[0];
                f = f[1];
                if (b.smoothed) {
                    e = c.length - 1;
                    for (c[e] = j; e-- && e > 0;) c[e] += g / 2;
                    c[0] = i
                }
                this.currentDataGrouping = h.info;
                if (a.pointRange === null) this.pointRange = h.info.totalRange;
                this.closestPointRange = h.info.totalRange;
                this.processedXData = c;
                this.processedYData = f
            } else this.currentDataGrouping = null, this.pointRange = l;
            this.hasGroupedData = d
        }
    };
    X.destroyGroupedData = function() {
        var a = this.groupedData;
        n(a || [], function(b, c) {
            b && (a[c] = b.destroy ? b.destroy() : null)
        });
        this.groupedData = null
    };
    X.generatePoints = function() {
        ec.apply(this);
        this.destroyGroupedData();
        this.groupedData = this.hasGroupedData ? this.points : null
    };
    X.tooltipHeaderFormatter = function(a) {
        var b = this.tooltipOptions,
            c = this.options.dataGrouping,
            d = b.xDateFormat,
            e, f = this.xAxis,
            g, h;
        if (f && f.options.type === "datetime" && c) {
            g = this.currentDataGrouping;
            c = c.dateTimeLabelFormats;
            if (g) f = c[g.unitName], g.count === 1 ? d = f[0] : (d = f[1], e = f[2]);
            else if (!d)
                for (h in E)
                    if (E[h] >= f.closestPointRange) {
                        d = c[h][0];
                        break
                    } d = ua(d, a);
            e && (d += ua(e, a + g.totalRange - 1));
            a = b.headerFormat.replace("{point.key}", d)
        } else a = gc.apply(this, [a]);
        return a
    };
    X.destroy = function() {
        for (var a = this.groupedData || [], b = a.length; b--;) a[b] && a[b].destroy();
        fc.apply(this)
    };
    S.line.dataGrouping = S.spline.dataGrouping = S.area.dataGrouping = S.areaspline.dataGrouping = P;
    S.column.dataGrouping = y(P, {
        approximation: "sum",
        groupPixelWidth: 10
    });
    S.ohlc = y(S.column, {
        lineWidth: 1,
        dataGrouping: {
            approximation: "ohlc",
            enabled: !0,
            groupPixelWidth: 5
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>Open: {point.open}<br/>High: {point.high}<br/>Low: {point.low}<br/>Close: {point.close}<br/>'
        },
        states: {
            hover: {
                lineWidth: 3
            }
        },
        threshold: null
    });
    var P = ca(xa, {
            applyOptions: function(a) {
                var b = this.series,
                    c = 0;
                if (typeof a === "object" && typeof a.length !== "number") z(this, a), this.options = a;
                else if (a.length) {
                    if (a.length === 5) {
                        if (typeof a[0] === "string") this.name = a[0];
                        else if (typeof a[0] === "number") this.x = a[0];
                        c++
                    }
                    this.open = a[c++];
                    this.high = a[c++];
                    this.low = a[c++];
                    this.close = a[c++]
                }
                this.y = this.high;
                if (this.x === v && b) this.x = b.autoIncrement();
                return this
            },
            tooltipFormatter: function() {
                var a = this.series;
                return ['<span style="color:' + a.color + ';font-weight:bold">', this.name || a.name, "</span><br/>Open: ", this.open, "<br/>High: ", this.high, "<br/>Low: ", this.low, "<br/>Close: ", this.close, "<br/>"].join("")
            },
            toYData: function() {
                return [this.open, this.high, this.low, this.close]
            }
        }),
        Bb = ca(U.column, {
            type: "ohlc",
            valueCount: 4,
            pointClass: P,
            pointAttrToOptions: {
                stroke: "color",
                "stroke-width": "lineWidth"
            },
            translate: function() {
                var a = this.yAxis;
                U.column.prototype.translate.apply(this);
                n(this.points, function(b) {
                    if (b.open !== null) b.plotOpen = a.translate(b.open, 0, 1, 0, 1);
                    if (b.close !== null) b.plotClose = a.translate(b.close, 0, 1, 0, 1)
                })
            },
            drawPoints: function() {
                var a = this,
                    b = a.chart,
                    c, d, e, f, g, h, k, i;
                n(a.points, function(j) {
                    if (j.plotY !== v) k = j.graphic, c = j.pointAttr[j.selected ? "selected" : ""], f = c["stroke-width"] % 2 / 2, i = u(j.plotX) + f, g = u(j.barW / 2), h = ["M", i, u(j.yBottom), "L", i, u(j.plotY)], j.open !== null && (d = u(j.plotOpen) + f, h.push("M", i, d, "L", i - g, d)), j.close !== null && (e = u(j.plotClose) + f, h.push("M", i, e, "L", i + g, e)), k ? k.animate({
                        d: h
                    }) : j.graphic = b.renderer.path(h).attr(c).add(a.group)
                })
            },
            animate: null
        });
    U.ohlc = Bb;
    S.candlestick = y(S.column, {
        dataGrouping: {
            approximation: "ohlc",
            enabled: !0
        },
        lineColor: "black",
        lineWidth: 1,
        states: {
            hover: {
                lineWidth: 2
            }
        },
        tooltip: S.ohlc.tooltip,
        threshold: null,
        upColor: "white"
    });
    P = ca(Bb, {
        type: "candlestick",
        pointAttrToOptions: {
            fill: "color",
            stroke: "lineColor",
            "stroke-width": "lineWidth"
        },
        getAttribs: function() {
            Bb.prototype.getAttribs.apply(this, arguments);
            var a = this.options,
                b = a.states,
                a = a.upColor,
                c = y(this.pointAttr);
            c[""].fill = a;
            c.hover.fill = b.hover.upColor || a;
            c.select.fill = b.select.upColor || a;
            n(this.points, function(a) {
                if (a.open < a.close) a.pointAttr = c
            })
        },
        drawPoints: function() {
            var a = this,
                b = a.chart,
                c, d, e, f, g, h, k, i, j, l;
            n(a.points, function(m) {
                i = m.graphic;
                if (m.plotY !== v) c = m.pointAttr[m.selected ? "selected" : ""], h = c["stroke-width"] % 2 / 2, k = u(m.plotX) + h, d = u(m.plotOpen) + h, e = u(m.plotClose) + h, f = R.min(d, e), g = R.max(d, e), l = u(m.barW / 2), j = ["M", k - l, g, "L", k - l, f, "L", k + l, f, "L", k + l, g, "L", k - l, g, "M", k, g, "L", k, u(m.yBottom), "M", k, f, "L", k, u(m.plotY), "Z"], i ? i.animate({
                    d: j
                }) : m.graphic = b.renderer.path(j).attr(c).add(a.group)
            })
        }
    });
    U.candlestick = P;
    var nb = qa.prototype.symbols;
    S.flags = y(S.column, {
        dataGrouping: null,
        fillColor: "white",
        lineWidth: 1,
        pointRange: 0,
        shape: "flag",
        stackDistance: 7,
        states: {
            hover: {
                lineColor: "black",
                fillColor: "#FCFFC5"
            }
        },
        style: {
            fontSize: "11px",
            fontWeight: "bold",
            textAlign: "center"
        },
        threshold: null,
        y: -30
    });
    U.flags = ca(U.column, {
        type: "flags",
        sorted: !1,
        noSharedTooltip: !0,
        forceCrop: !0,
        init: Z.prototype.init,
        pointAttrToOptions: {
            fill: "fillColor",
            stroke: "color",
            "stroke-width": "lineWidth",
            r: "radius"
        },
        translate: function() {
            U.column.prototype.translate.apply(this);
            var a = this.chart,
                b = this.points,
                c = b.length - 1,
                d, e, f = this.options.onSeries,
                f = (d = f && a.get(f)) && d.options.step,
                g = d && d.points,
                h = g && g.length,
                k = this.xAxis.getExtremes(),
                i, j, l;
            if (d && d.visible && h) {
                j = g[h - 1].x;
                for (b.sort(function(a, b) {
                        return a.x - b.x
                    }); h-- && b[c];)
                    if (d = b[c], i = g[h], i.x <= d.x && i.plotY !== v) {
                        if (d.x <= j) d.plotY = i.plotY, i.x < d.x && !f && (l = g[h + 1]) && l.plotY !== v && (d.plotY += (d.x - i.x) / (l.x - i.x) * (l.plotY - i.plotY));
                        c--;
                        h++;
                        if (c < 0) break
                    }
            }
            n(b, function(c, d) {
                if (c.plotY === v) c.x >= k.min && c.x <= k.max ? c.plotY = a.plotHeight : c.shapeArgs = {};
                if ((e = b[d - 1]) && e.plotX === c.plotX) {
                    if (e.stackIndex === v) e.stackIndex = 0;
                    c.stackIndex = e.stackIndex + 1
                }
            })
        },
        drawPoints: function() {
            var a, b = this.points,
                c = this.chart.renderer,
                d, e, f = this.options,
                g = f.y,
                h = f.shape,
                k, i, j, l, m = f.lineWidth % 2 / 2,
                o;
            for (j = b.length; j--;)
                if (l = b[j], d = l.plotX + m, i = l.stackIndex, e = l.plotY, e !== v && (e = l.plotY + g + m - (i !== v && i * f.stackDistance)), k = i ? v : l.plotX + m, o = i ? v : l.plotY, i = l.graphic, a = l.tracker, e !== v) a = l.pointAttr[l.selected ? "select" : ""], i ? i.attr({
                    x: d,
                    y: e,
                    r: a.r,
                    anchorX: k,
                    anchorY: o
                }) : i = l.graphic = c.label(l.options.title || f.title || "A", d, e, h, k, o).css(y(f.style, l.style)).attr(a).attr({
                    align: h === "flag" ? "left" : "center",
                    width: f.width,
                    height: f.height
                }).add(this.group).shadow(f.shadow), k = i.box, i = k.getBBox(), l.shapeArgs = z(i, {
                    x: d - (h === "flag" ? 0 : k.attr("width") / 2),
                    y: e
                });
                else if (i) l.graphic = i.destroy(), a && a.attr("y", -9999)
        },
        drawTracker: function() {
            U.column.prototype.drawTracker.apply(this);
            n(this.points, function(a) {
                B(a.tracker.element, "mouseover", function() {
                    a.graphic.toFront()
                })
            })
        },
        tooltipFormatter: function(a) {
            return a.point.text
        },
        animate: function() {}
    });
    nb.flag = function(a, b, c, d, e) {
        var f = e && e.anchorX || a,
            e = e && e.anchorY || b;
        return ["M", f, e, "L", a, b + d, a, b, a + c, b, a + c, b + d, a, b + d, "M", f, e, "Z"]
    };
    n(["circle", "square"], function(a) {
        nb[a + "pin"] = function(b, c, d, e, f) {
            var g = f && f.anchorX,
                f = f && f.anchorY,
                b = nb[a](b, c, d, e);
            g && f && b.push("M", g, c + e, "L", g, f);
            return b
        }
    });
    Qa === Ja && n(["flag", "circlepin", "squarepin"], function(a) {
        Ja.prototype.symbols[a] = nb[a]
    });
    var ob = aa ? "touchstart" : "mousedown",
        Zb = aa ? "touchmove" : "mousemove",
        $b = aa ? "touchend" : "mouseup",
        P = ha("linearGradient", {
            x1: 0,
            y1: 0,
            x2: 0,
            y2: 1
        }, "stops", [
            [0, "#FFF"],
            [1, "#CCC"]
        ]),
        L = [].concat(Yb);
    L[4] = [fa, [1, 2, 3, 4]];
    L[5] = [Aa, [1, 2, 3]];
    z(T, {
        navigator: {
            handles: {
                backgroundColor: "#FFF",
                borderColor: "#666"
            },
            height: 40,
            margin: 10,
            maskFill: "rgba(255, 255, 255, 0.75)",
            outlineColor: "#444",
            outlineWidth: 1,
            series: {
                type: "areaspline",
                color: "#4572A7",
                compare: null,
                fillOpacity: 0.4,
                dataGrouping: {
                    approximation: "average",
                    groupPixelWidth: 2,
                    smoothed: !0,
                    units: L
                },
                dataLabels: {
                    enabled: !1
                },
                id: "highcharts-navigator-series",
                lineColor: "#4572A7",
                lineWidth: 1,
                marker: {
                    enabled: !1
                },
                pointRange: 0,
                shadow: !1
            },
            xAxis: {
                tickWidth: 0,
                lineWidth: 0,
                gridLineWidth: 1,
                tickPixelInterval: 200,
                labels: {
                    align: "left",
                    x: 3,
                    y: -4
                }
            },
            yAxis: {
                gridLineWidth: 0,
                startOnTick: !1,
                endOnTick: !1,
                minPadding: 0.1,
                maxPadding: 0.1,
                labels: {
                    enabled: !1
                },
                title: {
                    text: null
                },
                tickWidth: 0
            }
        },
        scrollbar: {
            height: aa ? 20 : 14,
            barBackgroundColor: P,
            barBorderRadius: 2,
            barBorderWidth: 1,
            barBorderColor: "#666",
            buttonArrowColor: "#666",
            buttonBackgroundColor: P,
            buttonBorderColor: "#666",
            buttonBorderRadius: 2,
            buttonBorderWidth: 1,
            rifleColor: "#666",
            trackBackgroundColor: ha("linearGradient", {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 1
            }, "stops", [
                [0, "#EEE"],
                [1, "#FFF"]
            ]),
            trackBorderColor: "#CCC",
            trackBorderWidth: 1
        }
    });
    Lb.prototype = {
        getAxisTop: function(a) {
            return this.navigatorOptions.top || a - this.height - this.scrollbarHeight - this.chart.options.chart.spacingBottom
        },
        drawHandle: function(a, b) {
            var c = this.chart.renderer,
                d = this.elementsToDestroy,
                e = this.handles,
                f = this.navigatorOptions.handles,
                f = {
                    fill: f.backgroundColor,
                    stroke: f.borderColor,
                    "stroke-width": 1
                },
                g;
            this.rendered || (e[b] = c.g().css({
                cursor: "e-resize"
            }).attr({
                zIndex: 4 - b
            }).add(), g = c.rect(-4.5, 0, 9, 16, 3, 1).attr(f).add(e[b]), d.push(g), g = c.path(["M", -1.5, 4, "L", -1.5, 12, "M", 0.5, 4, "L", 0.5, 12]).attr(f).add(e[b]), d.push(g));
            e[b].translate(this.scrollerLeft + this.scrollbarHeight + parseInt(a, 10), this.top + this.height / 2 - 8)
        },
        drawScrollbarButton: function(a) {
            var b = this.chart.renderer,
                c = this.elementsToDestroy,
                d = this.scrollbarButtons,
                e = this.scrollbarHeight,
                f = this.scrollbarOptions,
                g;
            this.rendered || (d[a] = b.g().add(this.scrollbarGroup), g = b.rect(-0.5, -0.5, e + 1, e + 1, f.buttonBorderRadius, f.buttonBorderWidth).attr({
                stroke: f.buttonBorderColor,
                "stroke-width": f.buttonBorderWidth,
                fill: f.buttonBackgroundColor
            }).add(d[a]), c.push(g), g = b.path(["M", e / 2 + (a ? -1 : 1), e / 2 - 3, "L", e / 2 + (a ? -1 : 1), e / 2 + 3, e / 2 + (a ? 2 : -2), e / 2]).attr({
                fill: f.buttonArrowColor
            }).add(d[a]), c.push(g));
            a && d[a].attr({
                translateX: this.scrollerWidth - e
            })
        },
        render: function(a, b, c, d) {
            var e = this.chart,
                f = e.renderer,
                g, h, k, i, j = this.scrollbarGroup,
                l = this.scrollbar,
                m = this.xAxis,
                o = this.scrollbarTrack,
                n = this.scrollbarHeight,
                A = this.scrollbarEnabled,
                q = this.navigatorOptions,
                s = this.scrollbarOptions,
                v = this.height,
                w = this.top,
                x = this.navigatorEnabled,
                D = q.outlineWidth,
                K = D / 2,
                H = this.outlineHeight,
                y = s.barBorderRadius,
                z = s.barBorderWidth,
                B = w + K;
            if (!isNaN(a)) {
                this.navigatorLeft = g = p(m.left, e.plotLeft + n);
                this.navigatorWidth = h = p(m.len, e.plotWidth - 2 * n);
                this.scrollerLeft = k = g - n;
                this.scrollerWidth = i = i = h + 2 * n;
                if (m.getExtremes) {
                    var E = e.xAxis[0].getExtremes(),
                        e = E.dataMin === null,
                        G = m.getExtremes(),
                        I = O(E.dataMin, G.dataMin),
                        E = t(E.dataMax, G.dataMax);
                    !e && (I !== G.min || E !== G.max) && m.setExtremes(I, E, !0, !1)
                }
                c = p(c, m.translate(a));
                d = p(d, m.translate(b));
                this.zoomedMin = a = F(O(c, d));
                this.zoomedMax = d = F(t(c, d));
                this.range = c = d - a;
                if (!this.rendered) {
                    if (x) this.leftShade = f.rect().attr({
                        fill: q.maskFill,
                        zIndex: 3
                    }).add(), this.rightShade = f.rect().attr({
                        fill: q.maskFill,
                        zIndex: 3
                    }).add(), this.outline = f.path().attr({
                        "stroke-width": D,
                        stroke: q.outlineColor,
                        zIndex: 3
                    }).add();
                    if (A) this.scrollbarGroup = j = f.g().add(), l = s.trackBorderWidth, this.scrollbarTrack = o = f.rect().attr({
                        y: -l % 2 / 2,
                        fill: s.trackBackgroundColor,
                        stroke: s.trackBorderColor,
                        "stroke-width": l,
                        r: s.trackBorderRadius || 0,
                        height: n
                    }).add(j), this.scrollbar = l = f.rect().attr({
                        y: -z % 2 / 2,
                        height: n,
                        fill: s.barBackgroundColor,
                        stroke: s.barBorderColor,
                        "stroke-width": z,
                        r: y
                    }).add(j), this.scrollbarRifles = f.path().attr({
                        stroke: s.rifleColor,
                        "stroke-width": 1
                    }).add(j)
                }
                x && (this.leftShade.attr({
                    x: g,
                    y: w,
                    width: a,
                    height: v
                }), this.rightShade.attr({
                    x: g + d,
                    y: w,
                    width: h - d,
                    height: v
                }), this.outline.attr({
                    d: ["M", k, B, "L", g + a + K, B, g + a + K, B + H - n, "M", g + d - K, B + H - n, "L", g + d - K, B, k + i, B]
                }), this.drawHandle(a + K, 0), this.drawHandle(d + K, 1));
                A && (this.drawScrollbarButton(0), this.drawScrollbarButton(1), j.translate(k, u(B + v)), o.attr({
                    width: i
                }), l.attr({
                    x: u(n + a) + z % 2 / 2,
                    width: c - z
                }), f = n + a + c / 2 - 0.5, this.scrollbarRifles.attr({
                    d: ["M", f - 3, n / 4, "L", f - 3, 2 * n / 3, "M", f, n / 4, "L", f, 2 * n / 3, "M", f + 3, n / 4, "L", f + 3, 2 * n / 3],
                    visibility: c > 12 ? "visible" : "hidden"
                }));
                this.rendered = !0
            }
        },
        addEvents: function() {
            var a = this.chart;
            B(a.container, ob, this.mouseDownHandler);
            B(a.container, Zb, this.mouseMoveHandler);
            B(document, $b, this.mouseUpHandler)
        },
        removeEvents: function() {
            var a = this.chart;
            Q(a.container, ob, this.mouseDownHandler);
            Q(a.container, Zb, this.mouseMoveHandler);
            Q(document, $b, this.mouseUpHandler);
            this.navigatorEnabled && Q(this.baseSeries, "updatedData", this.updatedDataHandler)
        },
        init: function() {
            var a = this,
                b = a.chart,
                c, d, e = a.scrollbarHeight,
                f = a.navigatorOptions,
                g = a.height,
                h = a.top,
                k, i, j, l = document.body.style,
                m, o = a.baseSeries,
                n;
            a.mouseDownHandler = function(d) {
                var d = b.tracker.normalizeMouseEvent(d),
                    e = a.zoomedMin,
                    f = a.zoomedMax,
                    h = a.top,
                    k = a.scrollbarHeight,
                    j = a.scrollerLeft,
                    o = a.scrollerWidth,
                    n = a.navigatorLeft,
                    p = a.navigatorWidth,
                    r = a.range,
                    q = d.chartX,
                    s = d.chartY,
                    d = aa ? 10 : 7;
                if (s > h && s < h + g + k)(h = !a.scrollbarEnabled || s < h + g) && R.abs(q - e - n) < d ? (a.grabbedLeft = !0, a.otherHandlePos = f) : h && R.abs(q - f - n) < d ? (a.grabbedRight = !0, a.otherHandlePos = e) : q > n + e && q < n + f ? (a.grabbedCenter = q, m = l.cursor, l.cursor = "ew-resize", i = q - e) : q > j && q < j + o && (f = h ? q - n - r / 2 : q < n ? e - O(10, r) : q > j + o - k ? e + O(10, r) : q < n + e ? e - r : f, f < 0 ? f = 0 : f + r > p && (f = p - r), f !== e && b.xAxis[0].setExtremes(c.translate(f, !0), c.translate(f + r, !0), !0, !1))
            };
            a.mouseMoveHandler = function(c) {
                var d = a.scrollbarHeight,
                    e = a.navigatorLeft,
                    f = a.navigatorWidth,
                    g = a.scrollerLeft,
                    h = a.scrollerWidth,
                    k = a.range,
                    c = b.tracker.normalizeMouseEvent(c),
                    c = c.chartX;
                c < e ? c = e : c > g + h - d && (c = g + h - d);
                a.grabbedLeft ? (j = !0, a.render(0, 0, c - e, a.otherHandlePos)) : a.grabbedRight ? (j = !0, a.render(0, 0, a.otherHandlePos, c - e)) : a.grabbedCenter && (j = !0, c < i ? c = i : c > f + i - k && (c = f + i - k), a.render(0, 0, c - i, c - i + k))
            };
            a.mouseUpHandler = function() {
                var d = a.zoomedMin,
                    e = a.zoomedMax;
                j && b.xAxis[0].setExtremes(c.translate(d, !0), c.translate(e, !0), !0, !1);
                a.grabbedLeft = a.grabbedRight = a.grabbedCenter = j = i = null;
                l.cursor = m
            };
            a.updatedDataHandler = function() {
                var c = o.xAxis,
                    d = c.getExtremes(),
                    e = d.min,
                    f = d.max,
                    g = d.dataMin,
                    d = d.dataMax,
                    h = f - e,
                    i, j, l, m, q;
                i = k.xData;
                var p = !!c.setExtremes;
                j = f >= i[i.length - 1];
                i = e <= g;
                if (!n) k.options.pointStart = o.xData[0], k.setData(o.options.data, !1), q = !0;
                i && (m = g, l = m + h);
                j && (l = d, i || (m = t(l - h, k.xData[0])));
                p && (i || j) ? c.setExtremes(m, l, !0, !1) : (q && b.redraw(!1), a.render(t(e, g), O(f, d)))
            };
            var p = b.xAxis.length,
                q = b.yAxis.length,
                s = b.setSize;
            b.extraBottomMargin = a.outlineHeight + f.margin;
            a.top = h = a.getAxisTop(b.chartHeight);
            if (a.navigatorEnabled) {
                var v = o.options,
                    w = v.data,
                    u = f.series;
                n = u.data;
                v.data = u.data = null;
                a.xAxis = c = new bb(b, y({
                    ordinal: o.xAxis.options.ordinal
                }, f.xAxis, {
                    isX: !0,
                    type: "datetime",
                    index: p,
                    height: g,
                    top: h,
                    offset: 0,
                    offsetLeft: e,
                    offsetRight: -e,
                    startOnTick: !1,
                    endOnTick: !1,
                    minPadding: 0,
                    maxPadding: 0,
                    zoomEnabled: !1
                }));
                a.yAxis = d = new bb(b, y(f.yAxis, {
                    alignTicks: !1,
                    height: g,
                    top: h,
                    offset: 0,
                    index: q,
                    zoomEnabled: !1
                }));
                f = y(o.options, u, {
                    threshold: null,
                    clip: !1,
                    enableMouseTracking: !1,
                    group: "nav",
                    padXAxis: !1,
                    xAxis: p,
                    yAxis: q,
                    name: "Navigator",
                    showInLegend: !1,
                    isInternal: !0,
                    visible: !0
                });
                v.data = w;
                u.data = n;
                f.data = n || w;
                k = b.initSeries(f);
                B(o, "updatedData", a.updatedDataHandler)
            } else a.xAxis = c = {
                translate: function(a, c) {
                    var d = b.xAxis[0].getExtremes(),
                        f = b.plotWidth - 2 * e,
                        g = d.dataMin,
                        d = d.dataMax - g;
                    return c ? a * d / f + g : f * (a - g) / d
                }
            };
            a.series = k;
            b.setSize = function(e, f, g) {
                a.top = h = a.getAxisTop(f);
                if (c && d) c.options.top = d.options.top = h;
                s.call(b, e, f, g)
            };
            a.addEvents()
        },
        destroy: function() {
            this.removeEvents();
            n([this.xAxis, this.yAxis, this.leftShade, this.rightShade, this.outline, this.scrollbarTrack, this.scrollbarRifles, this.scrollbarGroup, this.scrollbar], function(a) {
                a && a.destroy && a.destroy()
            });
            this.xAxis = this.yAxis = this.leftShade = this.rightShade = this.outline = this.scrollbarTrack = this.scrollbarRifles = this.scrollbarGroup = this.scrollbar = null;
            n([this.scrollbarButtons, this.handles, this.elementsToDestroy], function(a) {
                ta(a)
            })
        }
    };
    Highcharts.Scroller = Lb;
    z(T, {
        rangeSelector: {
            buttonTheme: {
                width: 28,
                height: 16,
                padding: 1,
                r: 0,
                zIndex: 7
            }
        }
    });
    T.lang = y(T.lang, {
        rangeSelectorZoom: "Zoom",
        rangeSelectorFrom: "From:",
        rangeSelectorTo: "To:"
    });
    Mb.prototype = {
        clickButton: function(a, b, c) {
            var d = this,
                e = d.chart,
                f = d.buttons,
                g = e.xAxis[0],
                h = g && g.getExtremes(),
                k = e.scroller && e.scroller.xAxis,
                i = (k = k && k.getExtremes && k.getExtremes()) && k.dataMax,
                j = h && h.dataMin,
                l = h && h.dataMax,
                k = O(j, p(k && k.dataMin, j)),
                i = t(l, p(i, l)),
                m, n = g && O(h.max, i),
                h = new Date(n),
                l = b.type,
                j = b.count,
                r, s, q = {
                    millisecond: 1,
                    second: 1E3,
                    minute: 6E4,
                    hour: 36E5,
                    day: 864E5,
                    week: 6048E5
                };
            if (!(k === null || i === null || a === d.selected)) q[l] ? (r = q[l] * j, m = t(n - r, k)) : l === "month" ? (h.setMonth(h.getMonth() - j), m = t(h.getTime(), k), r = 2592E6 * j) : l === "ytd" ? (h = new Date(0), l = new Date(i), s = l.getFullYear(), h.setFullYear(s), String(s) !== ua("%Y", h) && h.setFullYear(s - 1), m = s = t(k || 0, h.getTime()), l = l.getTime(), n = O(i || l, l)) : l === "year" ? (h.setFullYear(h.getFullYear() - j), m = t(k, h.getTime()), r = 31536E6 * j) : l === "all" && g && (m = k, n = i), f[a] && f[a].setState(2), g ? setTimeout(function() {
                g.setExtremes(m, n, p(c, 1), 0, {
                    rangeSelectorButton: b
                });
                d.selected = a
            }, 1) : (e = e.options.xAxis, e[0] = y(e[0], {
                range: r,
                min: s
            }), d.selected = a)
        },
        init: function(a) {
            var b = this,
                c = b.chart,
                d = c.options.rangeSelector,
                a = d.buttons || a,
                e = b.buttons,
                f = b.leftBox,
                g = b.rightBox,
                d = d.selected;
            c.extraTopMargin = 25;
            b.buttonOptions = a;
            b.mouseDownHandler = function() {
                f && f.blur();
                g && g.blur()
            };
            B(c.container, ob, b.mouseDownHandler);
            d !== v && a[d] && this.clickButton(d, a[d], !1);
            B(c, "load", function() {
                B(c.xAxis[0], "afterSetExtremes", function() {
                    e[b.selected] && !c.renderer.forExport && e[b.selected].setState(0);
                    b.selected = null
                })
            })
        },
        setInputValue: function(a, b) {
            var c = this.chart.options.rangeSelector,
                c = a.hasFocus ? c.inputEditDateFormat || "%Y-%m-%d" : c.inputDateFormat || "%b %e, %Y";
            if (b) a.HCTime = b;
            a.value = ua(c, a.HCTime)
        },
        drawInput: function(a) {
            var b = this,
                c = b.chart,
                d = c.options.rangeSelector,
                e = b.div,
                f = a === "min",
                g;
            b.boxSpanElements[a] = V("span", {
                innerHTML: T.lang[f ? "rangeSelectorFrom" : "rangeSelectorTo"]
            }, d.labelStyle, e);
            g = V("input", {
                name: a,
                className: "highcharts-range-selector",
                type: "text"
            }, z({
                width: "80px",
                height: "16px",
                border: "1px solid silver",
                marginLeft: "5px",
                marginRight: f ? "5px" : "0",
                textAlign: "center"
            }, d.inputStyle), e);
            g.onfocus = g.onblur = function(a) {
                a = a || window.event || {};
                g.hasFocus = a.type === "focus";
                b.setInputValue(g)
            };
            g.onchange = function() {
                var a = g.value,
                    d = Date.parse(a),
                    e = c.xAxis[0].getExtremes();
                isNaN(d) && (d = a.split("-"), d = Date.UTC(F(d[0]), F(d[1]) - 1, F(d[2])));
                if (!isNaN(d) && (f && d >= e.dataMin && d <= b.rightBox.HCTime || !f && d <= e.dataMax && d >= b.leftBox.HCTime)) c.xAxis[0].setExtremes(f ? d : e.min, f ? e.max : d)
            };
            return g
        },
        render: function(a, b) {
            var c = this,
                d = c.chart,
                e = d.renderer,
                f = d.container,
                g = d.options.rangeSelector,
                h = c.buttons,
                k = T.lang,
                i = c.div,
                i = d.options.chart.style,
                j = g.buttonTheme,
                l = g.inputEnabled !== !1,
                m = j && j.states,
                o = d.plotLeft,
                p;
            if (!c.rendered && (c.zoomText = e.text(k.rangeSelectorZoom, o, d.plotTop - 10).css(g.labelStyle).add(), p = o + c.zoomText.getBBox().width + 5, n(c.buttonOptions, function(a, b) {
                    h[b] = e.button(a.text, p, d.plotTop - 25, function() {
                        c.clickButton(b, a);
                        c.isActive = !0
                    }, j, m && m.hover, m && m.select).css({
                        textAlign: "center"
                    }).add();
                    p += h[b].width + (g.buttonSpacing || 0);
                    c.selected === b && h[b].setState(2)
                }), l)) c.divRelative = i = V("div", null, {
                position: "relative",
                height: 0,
                fontFamily: i.fontFamily,
                fontSize: i.fontSize,
                zIndex: 1
            }), f.parentNode.insertBefore(i, f), c.divAbsolute = c.div = i = V("div", null, z({
                position: "absolute",
                top: d.plotTop - 25 + "px",
                right: d.chartWidth - d.plotLeft - d.plotWidth + "px"
            }, g.inputBoxStyle), i), c.leftBox = c.drawInput("min"), c.rightBox = c.drawInput("max");
            l && (c.setInputValue(c.leftBox, a), c.setInputValue(c.rightBox, b));
            c.rendered = !0
        },
        destroy: function() {
            var a = this.leftBox,
                b = this.rightBox,
                c = this.boxSpanElements,
                d = this.divRelative,
                e = this.divAbsolute,
                f = this.zoomText;
            Q(this.chart.container, ob, this.mouseDownHandler);
            n([this.buttons], function(a) {
                ta(a)
            });
            if (f) this.zoomText = f.destroy();
            if (a) a.onfocus = a.onblur = a.onchange = null;
            if (b) b.onfocus = b.onblur = b.onchange = null;
            n([a, b, c.min, c.max, e, d], function(a) {
                Na(a)
            });
            this.leftBox = this.rightBox = this.boxSpanElements = this.div = this.divAbsolute = this.divRelative = null
        }
    };
    Highcharts.RangeSelector = Mb;
    cb.prototype.callbacks.push(function(a) {
        function b() {
            f = a.xAxis[0].getExtremes();
            g.render(t(f.min, f.dataMin), O(f.max, f.dataMax))
        }

        function c() {
            f = a.xAxis[0].getExtremes();
            h.render(f.min, f.max)
        }

        function d(a) {
            g.render(a.min, a.max)
        }

        function e(a) {
            h.render(a.min, a.max)
        }
        var f, g = a.scroller,
            h = a.rangeSelector;
        g && (B(a.xAxis[0], "afterSetExtremes", d), B(a, "resize", b), b());
        h && (B(a.xAxis[0], "afterSetExtremes", e), B(a, "resize", c), c());
        B(a, "destroy", function() {
            g && (Q(a, "resize", b), Q(a.xAxis[0], "afterSetExtremes", d));
            h && (Q(a, "resize", c), Q(a.xAxis[0], "afterSetExtremes", e))
        })
    });
    Highcharts.StockChart = function(a, b) {
        var c = a.series,
            d, e = {
                marker: {
                    enabled: !1,
                    states: {
                        hover: {
                            enabled: !0,
                            radius: 5
                        }
                    }
                },
                shadow: !1,
                states: {
                    hover: {
                        lineWidth: 2
                    }
                },
                dataGrouping: {
                    enabled: !0
                }
            };
        a.xAxis = va(la(a.xAxis || {}), function(a) {
            return y({
                minPadding: 0,
                maxPadding: 0,
                ordinal: !0,
                title: {
                    text: null
                },
                labels: {
                    overflow: "justify"
                },
                showLastLabel: !0
            }, a, {
                type: "datetime",
                categories: null
            })
        });
        a.yAxis = va(la(a.yAxis || {}), function(a) {
            d = a.opposite;
            return y({
                labels: {
                    align: d ? "right" : "left",
                    x: d ? -2 : 2,
                    y: -2
                },
                showLastLabel: !1,
                title: {
                    text: null
                }
            }, a)
        });
        a.series = null;
        a = y({
            chart: {
                panning: !0
            },
            navigator: {
                enabled: !0
            },
            scrollbar: {
                enabled: !0
            },
            rangeSelector: {
                enabled: !0
            },
            title: {
                text: null
            },
            tooltip: {
                shared: !0,
                crosshairs: !0
            },
            legend: {
                enabled: !1
            },
            plotOptions: {
                line: e,
                spline: e,
                area: e,
                areaspline: e,
                column: {
                    shadow: !1,
                    borderWidth: 0,
                    dataGrouping: {
                        enabled: !0
                    }
                }
            }
        }, a, {
            chart: {
                inverted: !1
            }
        });
        a.series = c;
        return new cb(a, b)
    };
    var hc = X.init,
        ic = X.processData,
        jc = xa.prototype.tooltipFormatter;
    X.init = function() {
        hc.apply(this, arguments);
        var a = this.options.compare;
        if (a) this.modifyValue = function(b, c) {
            var d = this.compareValue,
                b = a === "value" ? b - d : b = 100 * (b / d) - 100;
            if (c) c.change = b;
            return b
        }
    };
    X.processData = function() {
        ic.apply(this, arguments);
        if (this.options.compare)
            for (var a = 0, b = this.processedXData, c = this.processedYData, d = c.length, e = this.xAxis.getExtremes().min; a < d; a++)
                if (typeof c[a] === "number" && b[a] >= e) {
                    this.compareValue = c[a];
                    break
                }
    };
    xa.prototype.tooltipFormatter = function(a) {
        a = a.replace("{point.change}", (this.change > 0 ? "+" : "") + Ya(this.change, this.series.tooltipOptions.changeDecimals || 2));
        return jc.apply(this, [a])
    };
    (function() {
        var a = X.init,
            b = X.getSegments;
        X.init = function() {
            var b, d;
            a.apply(this, arguments);
            b = this.chart;
            (d = this.xAxis) && d.options.ordinal && B(this, "updatedData", function() {
                delete d.ordinalIndex
            });
            if (d && d.options.ordinal && !d.hasOrdinalExtension) {
                d.hasOrdinalExtension = !0;
                d.beforeSetTickPositions = function() {
                    var a, b = [],
                        c = !1,
                        e, i = this.getExtremes(),
                        j = i.min,
                        i = i.max,
                        l;
                    if (this.options.ordinal) {
                        n(this.series, function(c, d) {
                            if (c.visible !== !1 && (b = b.concat(c.processedXData), a = b.length, d && a)) {
                                b.sort(function(a, b) {
                                    return a - b
                                });
                                for (d = a - 1; d--;) b[d] === b[d + 1] && b.splice(d, 1)
                            }
                        });
                        a = b.length;
                        if (a > 2) {
                            e = b[1] - b[0];
                            for (l = a - 1; l-- && !c;) b[l + 1] - b[l] !== e && (c = !0)
                        }
                        c ? (this.ordinalPositions = b, c = d.val2lin(j, !0), e = d.val2lin(i, !0), this.ordinalSlope = i = (i - j) / (e - c), this.ordinalOffset = j - c * i) : this.ordinalPositions = this.ordinalSlope = this.ordinalOffset = v
                    }
                };
                d.val2lin = function(a, b) {
                    var c = this.ordinalPositions;
                    if (c) {
                        var d = c.length,
                            e, j;
                        for (e = d; e--;)
                            if (c[e] === a) {
                                j = e;
                                break
                            } for (e = d - 1; e--;)
                            if (a > c[e] || e === 0) {
                                c = (a - c[e]) / (c[e + 1] - c[e]);
                                j = e + c;
                                break
                            } return b ? j : this.ordinalSlope * (j || 0) + this.ordinalOffset
                    } else return a
                };
                d.lin2val = function(a, b) {
                    var c = this.ordinalPositions;
                    if (c) {
                        var d = this.ordinalSlope,
                            e = this.ordinalOffset,
                            j = c.length - 1,
                            l, m;
                        if (b) a < 0 ? a = c[0] : a > j ? a = c[j] : (j = $(a), m = a - j);
                        else
                            for (; j--;)
                                if (l = d * j + e, a >= l) {
                                    d = d * (j + 1) + e;
                                    m = (a - l) / (d - l);
                                    break
                                } return m !== v && c[j] !== v ? c[j] + (m ? m * (c[j + 1] - c[j]) : 0) : a
                    } else return a
                };
                d.getExtendedPositions = function() {
                    var a = d.series[0].currentDataGrouping,
                        e = d.ordinalIndex,
                        h = a ? a.count + a.unitName : "raw",
                        k = d.getExtremes(),
                        i, j;
                    if (!e) e = d.ordinalIndex = {};
                    if (!e[h]) i = {
                        series: [],
                        getExtremes: function() {
                            return {
                                min: k.dataMin,
                                max: k.dataMax
                            }
                        },
                        options: {
                            ordinal: !0
                        }
                    }, n(d.series, function(d) {
                        j = {
                            xAxis: i,
                            xData: d.xData,
                            chart: b,
                            destroyGroupedData: Rb
                        };
                        j.options = {
                            dataGrouping: a ? {
                                enabled: !0,
                                forced: !0,
                                approximation: "open",
                                units: [
                                    [a.unitName, [a.count]]
                                ]
                            } : {
                                enabled: !1
                            }
                        };
                        d.processData.apply(j);
                        i.series.push(j)
                    }), d.beforeSetTickPositions.apply(i), e[h] = i.ordinalPositions;
                    return e[h]
                };
                d.getGroupIntervalFactor = function(a, b, c) {
                    for (var d = 0, e = c.length, j = []; d < e - 1; d++) j[d] = c[d + 1] - c[d];
                    j.sort(function(a, b) {
                        return a - b
                    });
                    c = j[$(e / 2)];
                    return e * c / (b - a)
                };
                d.postProcessTickInterval = function(a) {
                    var b = this.ordinalSlope;
                    return b ? a / (b / d.closestPointRange) : a
                };
                d.getNonLinearTimeTicks = function(a, b, c, e, i, j, l) {
                    var m = 0,
                        n = 0,
                        p, t = {},
                        q, u, y, w = [],
                        x = d.options.tickPixelInterval;
                    if (!i || b === v) return gb(a, b, c, e);
                    for (u = i.length; n < u; n++) {
                        y = n && i[n - 1] > c;
                        i[n] < b && (m = n);
                        if (n === u - 1 || i[n + 1] - i[n] > j * 5 || y) p = gb(a, i[m], i[n], e), w = w.concat(p), m = n + 1;
                        if (y) break
                    }
                    a = p.info;
                    if (l && a.unitRange <= E[sa]) {
                        n = w.length - 1;
                        for (m = 1; m < n; m++)(new Date(w[m]))[Ca]() !== (new Date(w[m - 1]))[Ca]() && (t[w[m]] = fa, q = !0);
                        q && (t[w[0]] = fa);
                        a.higherRanks = t
                    }
                    w.info = a;
                    if (l && s(x)) {
                        var l = a = w.length,
                            n = [],
                            z;
                        for (q = []; l--;) m = d.translate(w[l]), z && (q[l] = z - m), n[l] = z = m;
                        q.sort();
                        q = q[$(q.length / 2)];
                        q < x * 0.6 && (q = null);
                        l = w[a - 1] > c ? a - 1 : a;
                        for (z = void 0; l--;) m = n[l], c = z - m, z && c < x * 0.8 && (q === null || c < q * 0.8) ? (t[w[l]] && !t[w[l + 1]] ? (c = l + 1, z = m) : c = l, w.splice(c, 1)) : z = m
                    }
                    return w
                };
                var e = b.pan;
                b.pan = function(a) {
                    var d = b.xAxis[0],
                        h = !1;
                    if (d.options.ordinal && d.series.length) {
                        var k = b.mouseDownX,
                            i = d.getExtremes(),
                            j = i.dataMax,
                            l = i.min,
                            m = i.max,
                            o;
                        o = b.hoverPoints;
                        var p = d.closestPointRange,
                            k = (k - a) / (d.translationSlope * (d.ordinalSlope || p)),
                            s = {
                                ordinalPositions: d.getExtendedPositions()
                            },
                            q, p = d.lin2val,
                            u = d.val2lin;
                        if (s.ordinalPositions) {
                            if (W(k) > 1) o && n(o, function(a) {
                                a.setState()
                            }), k < 0 ? (o = s, s = d.ordinalPositions ? d : s) : o = d.ordinalPositions ? d : s, q = s.ordinalPositions, j > q[q.length - 1] && q.push(j), o = p.apply(o, [u.apply(o, [l, !0]) + k, !0]), k = p.apply(s, [u.apply(s, [m, !0]) + k, !0]), o > O(i.dataMin, l) && k < t(j, m) && d.setExtremes(o, k, !0, !1), b.mouseDownX = a, M(b.container, {
                                cursor: "move"
                            })
                        } else h = !0
                    } else h = !0;
                    h && e.apply(b, arguments)
                }
            }
        };
        X.getSegments = function() {
            var a = this,
                d, e = a.options.gapSize;
            b.apply(a);
            if (e) d = a.segments, n(d, function(b, g) {
                for (var h = b.length - 1; h--;) b[h + 1].x - b[h].x > a.xAxis.closestPointRange * e && d.splice(g + 1, 0, b.splice(h + 1, b.length - h))
            })
        }
    })();
    z(Highcharts, {
        Axis: bb,
        CanVGRenderer: mb,
        Chart: cb,
        Color: wa,
        Legend: xb,
        Point: xa,
        Tick: ab,
        Tooltip: wb,
        Renderer: Qa,
        Series: Z,
        SVGRenderer: qa,
        VMLRenderer: Ja,
        dateFormat: ua,
        pathAnim: db,
        getOptions: function() {
            return T
        },
        hasBidiBug: bc,
        numberFormat: Ya,
        seriesTypes: U,
        setOptions: function(a) {
            T = y(T, a);
            Ib();
            return T
        },
        addEvent: B,
        removeEvent: Q,
        createElement: V,
        discardElement: Na,
        css: M,
        each: n,
        extend: z,
        map: va,
        merge: y,
        pick: p,
        splat: la,
        extendClass: ca,
        pInt: F,
        product: "Highstock",
        version: "1.1.6"
    })
})();