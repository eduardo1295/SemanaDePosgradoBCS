/*! grapesjs-blocks-basic - 0.1.8 */ ! function(e, t) {
    "object" == typeof exports && "object" == typeof module ? module.exports = t(require("grapesjs")) : "function" == typeof define && define.amd ? define(["grapesjs"], t) : "object" == typeof exports ? exports["grapesjs-blocks-basic"] = t(require("grapesjs")) : e["grapesjs-blocks-basic"] = t(e.grapesjs)
}(this, function(e) {
    return function(e) {
        function t(a) {
            if (n[a]) return n[a].exports;
            var l = n[a] = {
                i: a,
                l: !1,
                exports: {}
            };
            return e[a].call(l.exports, l, l.exports, t), l.l = !0, l.exports
        }
        var n = {};
        return t.m = e, t.c = n, t.d = function(e, n, a) {
            t.o(e, n) || Object.defineProperty(e, n, {
                configurable: !1,
                enumerable: !0,
                get: a
            })
        }, t.n = function(e) {
            var n = e && e.__esModule ? function() {
                return e.default
            } : function() {
                return e
            };
            return t.d(n, "a", n), n
        }, t.o = function(e, t) {
            return Object.prototype.hasOwnProperty.call(e, t)
        }, t.p = "", t(t.s = 0)
    }([function(e, t, n) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var a = Object.assign || function(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = arguments[t];
                    for (var a in n) Object.prototype.hasOwnProperty.call(n, a) && (e[a] = n[a])
                }
                return e
            },
            l = n(1),
            i = function(e) {
                return e && e.__esModule ? e : {
                    default: e
                }
            }(l);
        t.default = i.default.plugins.add("gjs-blocks-basic", function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {},
                l = a({
                    blocks: ["column1", "column2", "column3", "column3-7", "text", "link", "image", "video", "map"],
                    flexGrid: 0,
                    stylePrefix: "gjs-",
                    addBasicStyle: !0,
                    category: "Basic",
                    labelColumn1: "1 Columna",
                    labelColumn2: "2 Columnas",
                    labelColumn3: "3 Columnas",
                    labelColumn37: "2 Columns 3/7",
                    labelText: "Texto",
                    labelLink: "Link",
                    labelImage: "Imagen",
                    labelVideo: "Video",
                    labelMap: "Map"
                }, t);
            n(2).default(e, l)
        })
    }, function(t, n) {
        t.exports = e
    }, function(e, t, n) {
        "use strict";
        Object.defineProperty(t, "__esModule", {
            value: !0
        });
        var a = Object.assign || function(e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var a in n) Object.prototype.hasOwnProperty.call(n, a) && (e[a] = n[a])
            }
            return e
        };
        t.default = function(e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {},
                n = t,
                l = e.BlockManager,
                i = n.blocks,
                s = n.stylePrefix,
                o = n.flexGrid,
                r = n.addBasicStyle,
                c = s + "row",
                d = s + "cell",
                u = o ? "\n    ." + c + " {\n      width: 100%;\n      padding: 10px;\n    } \n    @media (max-width: 768px) {\n      ." + c + " {\n        flex-wrap: wrap;\n      }\n    }" : "\n    ." + c + " {\n      width: 100%;\n      padding: 10px;\n    }\n    @media (max-width: 768px) {\n      ." + s + "cell, ." + s + "cell30, ." + s + "cell70 {\n        display: inline-block;\n min-height: 25px; \n vertical-align:top;      }\n    }",
                b = o ? "\n    ." + d + " {\n     display: inline-block;\n min-height: 25px; \n vertical-align:top;      }" : "\n    ." + d + " {\n display: inline-block;\n min-height: 25px; \n vertical-align:top;    }",
                f = "\n  ." + s + "cell30 {\n    width: 70%;\n  }",
                g = "\n  ." + s + "cell70 {\n    width: 30%;\n  }",
                z = "\n  ." + s + "cell50 {\n    width: 49%;\n  }",
                x = "\n  ." + s + "cell33 {\n    width: 33%;\n  }",
                y = "\n  ." + s + "cell100 {\n    width: 100%;\n  }",
                p = {
                    tl: 0,
                    tc: 0,
                    tr: 0,
                    cl: 0,
                    cr: 0,
                    bl: 0,
                    br: 0,
                    minDim: 1
                },
                y = a({}, p, {
                    cr: 1,
                    bc: 0,
                    currentUnit: 1,
                    minDim: 1,
                    step: .2
                });
            o && (y.keyWidth = "flex-basis");
            var m = {
                    class: c,
                    "data-gjs-droppable": "." + d,
                    "data-gjs-resizable": p,
                    "data-gjs-name": "Row"
                },
                v = {
                    class: d,
                    "data-gjs-draggable": "." + c,
                    "data-gjs-resizable": y,
                    "data-gjs-name": "Cell"
                };
            o && (v["data-gjs-unstylable"] = ["width"], v["data-gjs-stylable-require"] = ["flex-basis"]);
            var x = ["." + c, "." + d];
            e.on("selector:add", function(e) {
                return x.indexOf(e.getFullName()) >= 0 && e.set("private", 1)
            });
            var j = function(e) {
                    var t = [];
                    for (var n in e) {
                        var a = e[n],
                            l = a instanceof Array || a instanceof Object;
                        a = l ? JSON.stringify(a) : a, t.push(n + "=" + (l ? "'" + a + "'" : '"' + a + '"'))
                    }
                    return t.length ? " " + t.join(" ") : ""
                },
                h = function(e) {
                    return i.indexOf(e) >= 0
                },
                w = j(m),
                k = j(v);
            h("column1") && l.add("column1", {
                label: n.labelColumn1,
                category: n.category,
                attributes: {
                    class: "gjs-fonts gjs-f-b1"
                },
                content: "<div " + w + ">\n        <div " + k + ' style="' + (o ? "flex-basis" : "width") + ': 100%;vertical-align: top;"></div>\n      </div>\n      ' + (r ? "<style >\n          " + u + "\n          " + b + "\n          " + y + "\n        </style>" : "")
            }), h("column2") && l.add("column2", {
                label: n.labelColumn2,
                attributes: {
                    class: "gjs-fonts gjs-f-b2"
                },
                category: n.category,
                content: "<div " + w + ">\n        <div " + k + ' style="' + (o ? "flex-basis" : "width") + ': 49%;vertical-align: top;"></div>\n        <div ' + k + ' style="' + (o ? "flex-basis" : "width") + ': 49%;vertical-align: top;"></div>\n      </div>\n      ' + (r ? "<style>\n          " + u + "\n          " + b + "\n          " + z + "\n        </style>" : "")
            }), h("column3") && l.add("column3", {
                label: n.labelColumn3,
                category: n.category,
                attributes: {
                    class: "gjs-fonts gjs-f-b3 hola"
                },
                content: "<div " + w + ">\n        <div " + k + ' style="' + (o ? "flex-basis" : "width") + ': 33%;vertical-align: top;"></div>\n        <div ' + k + ' style="' + (o ? "flex-basis" : "width") + ': 33%;vertical-align: top;"></div>\n        <div ' + k + ' style="' + (o ? "flex-basis" : "width") + ': 33%;vertical-align: top;"></div>\n      </div>\n      ' + (r ? "<style>\n          " + u + "\n          " + b + "\n    " + x + "\n       </style>" : "")
            }), h("column3-7") && l.add("column3-7", {
                label: n.labelColumn37,
                category: n.category,
                attributes: {
                    class: "gjs-fonts gjs-f-b37"
                },
                content: "<div " + w + ">\n        <div " + k + ' style="' + (o ? "flex-basis" : "width") + ': 30%;"></div>\n        <div ' + k + ' style="' + (o ? "flex-basis" : "width") + ': 70%;"></div>\n      </div>\n      ' + (r ? "<style>\n          " + u + "\n          " + b + "\n          " + f + "\n          " + g + "\n        </style>" : "")
            }), h("text") && l.add("text", {
                label: n.labelText,
                category: n.category,
                attributes: {
                    class: "gjs-fonts gjs-f-text"
                },
                content: {
                    type: "text",
                    content: "Inserta tu texto aquí",
                    style: {
                        padding: "10px"
                    },
                    activeOnRender: 1
                }
            }), h("link") && l.add("link", {
                label: n.labelLink,
                category: n.category,
                attributes: {
                    class: "fa fa-link"
                },
                content: {
                    type: "link",
                    content: "Link",
                    style: {
                        color: "#d983a6"
                    }
                }
            }), h("image") && l.add("image", {
                label: n.labelImage,
                category: n.category,
                attributes: {
                    class: "gjs-fonts gjs-f-image"
                },
                content: {
                    style: {
                        color: "black",
                        width: "130px",
                        height: "100px",
                        'vertical-align': "top"
                    },
                    type: "image",
                    activeOnRender: 1
                }
            }), h("video") && l.add("video", {
                label: n.labelVideo,
                category: n.category,
                attributes: {
                    class: "fa fa-youtube-play"
                },
                content: {
                    type: "video",
                    src: "img/video2.webm",
                    style: {
                        height: "350px",
                        width: "615px"
                    }
                }
            }), h("map") && l.add("map", {
                label: n.labelMap,
                category: n.category,
                attributes: {
                    class: "fa fa-map-o"
                },
                content: {
                    type: "map",
                    style: {
                        height: "350px"
                    }
                }
            })
        }
    }])
});