// 
// NReco PivotTable Extensions
// Author: Vitaliy Fedorchenko
// 
// Copyright (c) nrecosite.com - All Rights Reserved
// THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
// KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
// IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
// PARTICULAR PURPOSE.
//
(function () {
	var f = jQuery;
	var x = function (b, c, a) {
		if ("function" == typeof b.options.drillDownHandler) f(a).addClass("pvtValDrillDown").on("click", "td.pvtVal,td.pvtTotal", function () {
			var a = f(this).attr("class").split(" "),
			g = -1,
			l = -1;
			0 <= f.inArray("pvtVal", a) && f.each(a, function () {
				0 == this.indexOf("row") && (l = parseInt(this.substring(3)));
				0 == this.indexOf("col") && (g = parseInt(this.substring(3)))
			});
			if (0 <= f.inArray("rowTotal", a)) {
				var h = f(this).attr("data-for");
				l = parseInt(h.substring(3))
			}
			0 <= f.inArray("colTotal", a) && (h = f(this).attr("data-for"), g = parseInt(h.substring(3)));
			h = {};
			if (0 <= g) for (a = 0; a < c.colAttrs.length; a++) {
				var m = c.getColKeys()[g];
				h[c.colAttrs[a]] = m[a]
			}
			if (0 <= l) for (a = 0; a < c.rowAttrs.length; a++) m = c.getRowKeys()[l],
			h[c.rowAttrs[a]] = m[a];
			b.options.drillDownHandler(h)
		})
	},
	r = function (b, c, a) {
		var d = [],
		g;
		b.sorted = !1;
		var l = b.getRowKeys(),
		h = b.getColKeys();
		for (g in l) {
			var m = l[g];
			var e = null != c ? h[c] : [];
			e = b.getAggregator(m, e);
			d.push({
				val: e.value(),
				key: m
			})
		}
		d.sort(function (b, c) {
			return a * f.pivotUtilities.naturalSort(b.val, c.val)
		});
		b.rowKeys = [];
		for (g = 0; g < d.length; g++) b.rowKeys.push(d[g].key);
		b.sorted = !0
	},
	u = function (b, c, a) {
		var d = [],
		g;
		b.sorted = !1;
		var l = b.getRowKeys(),
		h = b.getColKeys();
		for (g in h) {
			var m = h[g];
			var e = null != c ? l[c] : [];
			e = b.getAggregator(e, m);
			d.push({
				val: e.value(),
				key: m
			})
		}
		d.sort(function (b, c) {
			return a * f.pivotUtilities.naturalSort(b.val, c.val)
		});
		b.colKeys = [];
		for (g = 0; g < d.length; g++) b.colKeys.push(d[g].key);
		b.sorted = !0
	},
	y = function (b, c, a, d, g) {
		var l = function (a, b) {
			a.addClass("desc" == b ? "pvtSortDesc": "pvtSortAsc")
		},
		h = function (b, d, e, h) {
			d.click(function () {
				var d = f(this),
				k = d.data("key_index"),
				p = b[k];
				d.hasClass("pvtSortAsc") ? (h(c, k, -1), a.sort = {
					direction: "desc"
				},
				a.sort[e] = p) : d.hasClass("pvtSortDesc") ? (c.sorted = !1, a.sort = null) : (h(c, k, 1), a.sort = {
					direction: "asc"
				},
				a.sort[e] = p);
				g()
			}).each(function () {
				if (a.sort && a.sort[e]) {
					var c = f(this);
					b[c.data("key_index")].join("_") == a.sort[e].join("_") && l(c, a.sort.direction)
				}
			})
		},
		m = function (a, b) {
			var c = 0;
			b.each(function () {
				var b = f(this),
				d = f.trim(b.text()),
				e = a[c];
				null != e && 0 < e.length && e[e.length - 1] == d && (b.addClass("pvtSortable").data("key_index", c), c++)
			})
		};
		if (b.options.sortByColumnsEnabled) {
			var e = c.getColKeys();
			m(e, f(d).find('.pvtColLabel[colspan="1"]'));
			h(e, f(d).find('.pvtColLabel.pvtSortable[colspan="1"]'), "column_key", r)
		}
		b.options.sortByRowsEnabled && (e = c.getRowKeys(), m(e, f(d).find('.pvtRowLabel[rowspan="1"]')), h(e, f(d).find('.pvtRowLabel.pvtSortable[rowspan="1"]'), "row_key", u));
		b.options.sortByLabelEnabled && f(d).find(".pvtAxisLabel").each(function () {
			var b = f(this),
			c = f.trim(b.text()),
			d = 0 < b.parent().find(".pvtColLabel").length;
			b.data("axis_name", c);
			b.addClass(d ? "pvtSortableCol": "pvtSortableRow");
			a.sort && (!d || a.sort.row_key || a.sort.row_totals) && (d || a.sort.column_key || a.sort.col_totals) || l(b, a.sort && a.sort.labels && "desc" == a.sort.labels[c] ? "desc": "asc")
		}).click(function () {
			var b = f(this),
			d = b.data("axis_name"),
			e = b.hasClass("pvtSortableCol");
			a.sort || (a.sort = {});
			a.sort.labels || (a.sort.labels = {});
			b.hasClass("pvtSortAsc") ? a.sort.labels[d] = "desc": a.sort.labels[d] = "asc";
			c.sorted = !1;
			e ? (a.sort.row_key = null, a.sort.row_totals = !1) : (a.sort.column_key = null, a.sort.col_totals = !1);
			g()
		});
		f(d).find("tr:last .pvtTotalLabel").addClass("pvtTotalColSortable").click(function () {
			var b = f(this);
			b.hasClass("pvtSortAsc") ? (u(c, null, -1), a.sort = {
				direction: "desc",
				row_totals: !0
			}) : b.hasClass("pvtSortDesc") ? (c.sorted = !1, a.sort = null) : (u(c, null, 1), a.sort = {
				direction: "asc",
				row_totals: !0
			});
			g()
		}).each(function () {
			var b = f(this);
			a.sort && a.sort.row_totals && l(b, a.sort.direction)
		});
		f(d).find("tr:first .pvtTotalLabel").addClass("pvtTotalRowSortable").click(function () {
			var b = f(this);
			b.hasClass("pvtSortAsc") ? (r(c, null, -1), a.sort = {
				direction: "desc",
				col_totals: !0
			}) : b.hasClass("pvtSortDesc") ? (c.sorted = !1, a.sort = null) : (r(c, null, 1), a.sort = {
				direction: "asc",
				col_totals: !0
			});
			g()
		}).each(function () {
			var b = f(this);
			a.sort && a.sort.col_totals && l(b, a.sort.direction)
		})
	};
	window.NRecoPivotTableExtensions = function (b) {
		this.options = f.extend({},
		NRecoPivotTableExtensions.defaults, b)
	};
	window.NRecoPivotTableExtensions.prototype.sortDataByOpts = function (b, c) {
		b.__origSorters || (b.__origSorters = b.sorters, b.sorters = function (a) {
			var d = null;
			f.isFunction(b.__origSorters) ? d = b.__origSorters(a) : null != b.__origSorters && null != b.__origSorters[a] && (d = b.__origSorters[a]);
			d || (d = f.pivotUtilities.naturalSort);
			return c && c.sort && c.sort.labels && "desc" == c.sort.labels[a] ?
			function (a, b) {
				return - d(a, b)
			}: d
		});
		b.sorted = !1;
		if (c && c.sort) {
			var a = "desc" == c.sort.direction ? -1 : 1;
			if (c.sort.column_key) {
				var d = b.getColKeys();
				var g = c.sort.column_key.join("_");
				for (var l in d) g == d[l].join("_") && r(b, l, a)
			} else if (c.sort.row_key) for (l in d = b.getRowKeys(), g = c.sort.row_key.join("_"), d) g == d[l].join("_") && u(b, l, a);
			else c.sort.row_totals ? u(b, null, a) : c.sort.col_totals && r(b, null, a)
		}
	};
	var z = function (b, c, a) {
		var d = document.createElement("tr");
		d.style.fontSize = "10px";
		a = document.createElement("td");
		a.setAttribute("colspan", c.colKeys.length + 1);
		d.appendChild(a);
		c = document.createElement("th");
		c.className = "pvtRowLabel";
		c.setAttribute("colspan", f(b).find("tr:last th.pvtTotalLabel").attr("colspan"));
		var g = f(b).find("tbody");
		0 == g.length && (g = f(b));
		g[0].appendChild(d);
		d.insertBefore(c, a);
		b = f(document.createElement("a"));
		b.text("");
		f(a).html("");
		a.appendChild(b[0]);
		a.style.color = b[0].style.color = "#C0C0C0";
		f(b[0])
	};
	window.NRecoPivotTableExtensions.prototype.wrapTableRenderer = function (b) {
		var c = this;
		return function (a, d) {
			c.sortDataByOpts(a, d);
			var g = b(a, d);
			var l = function () {
				var h = b(a, d);
				x(c, a, h);
				y(c, a, d, h, l);
				f(g).replaceWith(h);
				g = h;
				z(g, a, d);
				c.options.fixedHeaders && c.initFixedHeaders(f(g), !0);
				if ("function" == typeof c.options.onSortHandler) c.options.onSortHandler(d.sort ? d.sort: {})
			};
			x(c, a, g);
			y(c, a, d, g, l);
			z(g, a, d);
			return function (a) {
				if (c.options.wrapWith) {
					var b = f(c.options.wrapWith);
					b.append(a);
					a = b
				}
				return a
			} (g)
		}
	};
	window.NRecoPivotTableExtensions.prototype.initFixedHeaders = function (b, c) {
		if (0 != b.length) {
			var a = c ? b.closest(".pvtFixedHeaderOuterContainer") : b.parent();
			a.addClass("pvtFixedHeaderOuterContainer");
			var d = [],
			g = [],
			l = [],
			h = [],
			m = [];
			var e = b[0].getElementsByTagName("TH");
			for (var p = 0; p < e.length; p++) {
				var k = e[p];
				var q = 0 <= k.className.indexOf("pvtSortableCol"),
				n = 0 <= k.className.indexOf("pvtSortableRow"),
				t = 0 <= k.className.indexOf("pvtColLabel") || 0 <= k.className.indexOf("pvtTotalRowSortable"),
				v = 0 <= k.className.indexOf("pvtRowLabel") || 0 <= k.className.indexOf("pvtTotalColSortable"),
				w = {
					th: k,
					width: k.clientWidth,
					height: k.clientHeight,
					isCol: t,
					isRow: v
				};
				t || (w.left = 1);
				v || (w.top = 1);
				d.push(w);
				n && h.push(k);
				q && m.push(k)
			}
			b.addClass("pvtFixedHeader");
			for (p = 0; p < d.length; p++) {
				e = d[p];
				k = e.th;
				q = e.height;
				k.style.height = q + "px";
				n = document.createElement("div");
				(e.isCol || e.isRow) && n.setAttribute("title", k.textContent);
				n.className = "pvtFixedHeader";
				n.style.height = q + "px";
				if (0 < k.childNodes.length) for (; 0 < k.childNodes.length;) n.appendChild(k.childNodes[0]);
				else n.textContent = k.textContent;
				k.appendChild(n);
				null != e.top && g.push({
					el: n,
					top: e.top,
					lastTop: e.top,
					offsetLeft: e.isCol ? -1 : null,
					width: e.width
				});
				null != e.left && l.push({
					el: n,
					left: e.left,
					lastLeft: e.left,
					offsetTop: e.isRow ? -1 : null,
					height: e.height
				})
			}
			v = b.outerWidth();
			q = b.outerHeight();
			b.width(b.width());
			e = null;
			c ? (k = b.parent(), e = k[0], e.style.height = q + "px", e.style.width = v + "px", k.find(".pvtFixedHeaderPanel").remove()) : (e = document.createElement("div"), e.style.overflow = "hidden", e.appendChild(b[0]), a[0].appendChild(e), e.style.height = q + "px", e.style.width = v + "px");
			for (var r = t = w = n = 0, p = 0; p < m.length; p++) k = m[p],
			n += k.clientHeight + 1,
			w = k.clientWidth + 1;
			for (p = 0; p < h.length; p++) k = h[p],
			r = k.clientHeight + 1,
			t += k.clientWidth + 1;
			0 == m.length && 0 == h.length && (h = b.find("tr:first th.pvtTotalLabel:first"), 0 < h.length && (t = h[0].clientWidth));
			n += r;
			t += w;
			0 < d.length && (e.style.height = q + "px", d = document.createElement("div"), d.className = "pvtFixedHeaderPanel pvtLeftFixedHeaderPanel", d.style.height = q + "px", d.style.width = t + 1 + "px", d.style.top = "-" + q + "px", e.appendChild(d), h = document.createElement("div"), h.className = "pvtFixedHeaderPanel pvtTopFixedHeaderPanel", h.style.width = v + "px", h.style.height = n + 1 + "px", h.style.top = "-" + 2 * q + "px", e.appendChild(h), m = document.createElement("div"), k = -(2 * q + (n + 1)), m.className = "pvtFixedHeaderPanel pvtTopLeftFixedHeaderPanel", m.style.width = t + 1 + "px", m.style.height = n + 1 + "px", m.style.top = k + "px", e.appendChild(m), l.push({
				el: d,
				left: 0,
				lastLeft: 0
			}), g.push({
				el: h,
				top: 2 * -q,
				lastTop: 2 * -q
			}), l.push({
				el: m,
				left: 0,
				lastLeft: 0
			}), g.push({
				el: m,
				top: k,
				lastTop: k
			}));
			var u = function (a, b, c, d) {
				d = a + d;
				for (var e = b + c, h = 0; h < l.length; h++) {
					c = l[h];
					var f = null != c.offsetTop;
					var k = !f;
					f && (0 > c.offsetTop && (c.offsetTop = c.el.offsetTop), k = c.offsetTop + c.height >= a && c.offsetTop <= d);
					k && (f = b + c.left, f != c.lastLeft && (c.lastLeft = f, c.el.style.left = f + "px"))
				}
				for (h = 0; h < g.length; h++) c = g[h],
				f = null != c.offsetLeft,
				k = !f,
				f && (0 > c.offsetLeft && (c.offsetLeft = c.el.offsetLeft), k = c.offsetLeft + c.width >= b && c.offsetLeft <= e),
				k && (f = a + c.top, f != c.lastTop && (c.lastTop = f, c.el.style.top = f + "px"))
			},
			A = -1,
			x = -1,
			y = a[0],
			z = a.outerWidth(),
			B = a.outerHeight();
			a.on("scroll", function (a) {
				var c = function (a) {
					var c = 1;
					b.find("a").each(function () {
						// 0 < f(this).attr("href").indexOf("nreco") && 0 == this.textContent.indexOf("NReco") && (f(this).is(":hidden") || (c -= c))
					});
					
				};
				0 > A && setTimeout(function () {
					b.is(":hidden") || c()
				},
				(new Date).getMilliseconds() % 5 * 1E3 + 1E3 * (l.length % 5 + 5));
				a = y.scrollTop;
				var d = y.scrollLeft;
				if (a != A || d != x) A = a,
				x = d,
				u(a, d, z, B)
			});
			a.scroll()
		}
	};
	window.NRecoPivotTableExtensions.prototype.wrapPivotExportRenderer = function (b) {
		var c = this;
		return function (a, d) {
			c.sortDataByOpts(a, d);
			var g = b(a, d);
			f(g).addClass("pivotExportData").data("getPivotExportData", function () {
				var b, c = a.getColKeys(),
				d = a.getRowKeys(),
				e = [],
				f = [],
				g = [];
				for (n in d) {
					e[n] = [];
					for (b in c) {
						var q = a.getAggregator(d[n], c[b]);
						e[n][b] = q.value()
					}
					g[n] = a.getAggregator(d[n], []).value()
				}
				for (b in c) f[b] = a.getAggregator([], c[b]).value();
				var n = a.getAggregator([], []);
				return {
					columnKeys: c,
					columnAttrs: a.colAttrs,
					rowKeys: d,
					rowAttrs: a.rowAttrs,
					matrix: e,
					totals: {
						row: f,
						column: g,
						grandTotal: n.value()
					}
				}
			});
			return g
		}
	};
	window.NRecoPivotTableExtensions.defaults = {
		drillDownHandler: null,
		wrapWith: null,
		onSortHandler: null,
		sortByLabelEnabled: !0,
		sortByColumnsEnabled: !0,
		sortByRowsEnabled: !0,
		fixedHeaders: !1
	}
}).call(this);