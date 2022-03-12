(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vuetify-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/admin/components/Email/Featured.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vuetify-loader/lib/loader.js??ref--12-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/admin/components/Email/Featured.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _util__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../util */ "./resources/admin/util.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_3__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      valid: true,
      nameRules: _util__WEBPACK_IMPORTED_MODULE_2__["requireField"],
      config: {},
      timezones: [],
      date: null,
      datepicker_menu: null,
      time: null,
      menu2: false,
      loading: false,
      users: [],
      userSelected: null,
      search: null,
      dialog: false,
      description: null
    };
  },
  watch: {
    dialog: function dialog(val) {
      if (val) {
        this.description = this.userSelected.profile.description;
      }
    }
  },
  computed: {
    computedDateFormatted: {
      set: function set(v) {
        return v;
      },
      get: function get() {
        if (this.config.date) return moment__WEBPACK_IMPORTED_MODULE_1___default()(this.config.date).format("MM/DD/YYYY");
      }
    },
    today: function today() {
      var d = new Date();
      return d.toISOString().substr(0, 10);
    }
  },
  methods: {
    saveDescription: function saveDescription() {
      this.userSelected.profile.description = this.description;
      this.dialog = false;
    },
    getCategories: function getCategories(categories) {
      if (!categories) return "";
      var html = "";

      for (var i = 0; i < categories.length; i++) {
        if (i > 0) html = html + " \u2022 ".concat(categories[i].name);else html = "".concat(categories[i].name);
      }

      return html;
    },
    ratingAvg: function ratingAvg(reviews) {
      if (!reviews || reviews.length == 0) return 0;
      return reviews.reduce(function (a, b) {
        return a.rating ? a.rating + b.rating : a + b.rating;
      }) / reviews.length;
    },
    customFilter: function customFilter(item, queryText) {
      var textOne = item.profile.display_name.toLowerCase();
      var searchText = queryText.toLowerCase();
      console.log(textOne.indexOf(searchText) > -1);
      return textOne.indexOf(searchText) > -1;
    },
    sendEmail: function sendEmail() {
      var _this = this;

      if (this.config.emails && confirm("Are you ready to send to ".concat(this.config.emails, " clients?"))) {
        this.save().then(function () {
          _this.loading = true;
          axios__WEBPACK_IMPORTED_MODULE_3___default.a.post("/api/admin/email/send/featured").then(function (response) {})["catch"](function (error) {})["finally"](function () {
            return _this.loading = false;
          });
        });
      }
    },
    save: function save() {
      var _this2 = this;

      if (!this.$refs.config.validate()) return;
      this.loading = true;
      this.config.users = this.userSelected ? [this.userSelected].map(function (i) {
        return {
          id: i.id,
          description: i.profile.description
        };
      }) : null;
      return axios__WEBPACK_IMPORTED_MODULE_3___default.a.post("/api/admin/email/save/featured-config", this.config).then(function (response) {})["catch"](function (error) {})["finally"](function () {
        return _this2.loading = false;
      });
    }
  },
  created: function created() {
    var _this3 = this;

    axios__WEBPACK_IMPORTED_MODULE_3___default.a.get("/api/admin/email/featured-config").then(function (response) {
      _this3.timezones = response.data.timezones;
      _this3.users = response.data.users;

      if (response.data.config) {
        _this3.config = response.data.config;

        if (_this3.config.users) {
          _this3.users.forEach(function (i) {
            var item = _this3.config.users.filter(function (i2) {
              return i2.id == i.id;
            });

            if (item.length) {
              i.profile.description = item[0].description;
              item = Object.assign({}, i);
              _this3.userSelected = item;
            }
          });
        }

        if (_this3.config.date) {
          _this3.config.time = _this3.config.date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(_this3.config.date).format("HH:mm") : null;
          _this3.config.date = _this3.config.date ? moment__WEBPACK_IMPORTED_MODULE_1___default()(_this3.config.date).format("YYYY-MM-DD") : null;
        }
      }
    })["catch"](function (error) {});
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vuetify-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/admin/components/Email/Featured.vue?vue&type=template&id=a5eeb55c&":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vuetify-loader/lib/loader.js??ref--12-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/admin/components/Email/Featured.vue?vue&type=template&id=a5eeb55c& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-row",
    [
      _c(
        "v-col",
        { attrs: { col: "12" } },
        [
          _c(
            "v-form",
            { ref: "config" },
            [
              _c(
                "v-container",
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12" } },
                        [
                          _c("v-text-field", {
                            attrs: {
                              label: "Send Test Email (separate by comman)"
                            },
                            model: {
                              value: _vm.config.emails,
                              callback: function($$v) {
                                _vm.$set(_vm.config, "emails", $$v)
                              },
                              expression: "config.emails"
                            }
                          }),
                          _vm._v(" "),
                          _c(
                            "v-btn",
                            {
                              attrs: {
                                color: "purple",
                                dark: "",
                                loading: _vm.loading
                              },
                              on: { click: _vm.sendEmail }
                            },
                            [_vm._v("Send Test")]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "6" } },
                        [
                          _c("v-text-field", {
                            attrs: { label: "Subject" },
                            model: {
                              value: _vm.config.subject,
                              callback: function($$v) {
                                _vm.$set(_vm.config, "subject", $$v)
                              },
                              expression: "config.subject"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "4" } },
                        [
                          _c(
                            "v-menu",
                            {
                              attrs: {
                                "close-on-content-click": false,
                                "nudge-right": -184,
                                transition: "scale-transition",
                                "offset-y": "",
                                "min-width": "336",
                                width: "336"
                              },
                              scopedSlots: _vm._u([
                                {
                                  key: "activator",
                                  fn: function(ref) {
                                    var on = ref.on
                                    return [
                                      _c(
                                        "v-text-field",
                                        _vm._g(
                                          {
                                            attrs: {
                                              clearable: "",
                                              "hide-details": "",
                                              label: "Pick date",
                                              "prepend-inner-icon":
                                                "mdi-calendar-month"
                                            },
                                            on: {
                                              "click:append": function($event) {
                                                _vm.datepicker_menu = true
                                              }
                                            },
                                            model: {
                                              value: _vm.computedDateFormatted,
                                              callback: function($$v) {
                                                _vm.computedDateFormatted = $$v
                                              },
                                              expression:
                                                "computedDateFormatted"
                                            }
                                          },
                                          on
                                        )
                                      )
                                    ]
                                  }
                                }
                              ]),
                              model: {
                                value: _vm.datepicker_menu,
                                callback: function($$v) {
                                  _vm.datepicker_menu = $$v
                                },
                                expression: "datepicker_menu"
                              }
                            },
                            [
                              _vm._v(" "),
                              _c("v-date-picker", {
                                staticClass: "appointment-picker",
                                attrs: {
                                  "show-current": _vm.today,
                                  min: _vm.today,
                                  width: "336",
                                  "no-title": ""
                                },
                                on: {
                                  input: function($event) {
                                    _vm.datepicker_menu = false
                                  }
                                },
                                model: {
                                  value: _vm.config.date,
                                  callback: function($$v) {
                                    _vm.$set(_vm.config, "date", $$v)
                                  },
                                  expression: "config.date"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "4" } },
                        [
                          _c(
                            "v-menu",
                            {
                              ref: "menu",
                              attrs: {
                                "close-on-content-click": false,
                                "nudge-right": 40,
                                "return-value": _vm.config.time,
                                transition: "scale-transition",
                                "offset-y": "",
                                "max-width": "290px",
                                "min-width": "290px"
                              },
                              on: {
                                "update:returnValue": function($event) {
                                  return _vm.$set(_vm.config, "time", $event)
                                },
                                "update:return-value": function($event) {
                                  return _vm.$set(_vm.config, "time", $event)
                                }
                              },
                              scopedSlots: _vm._u([
                                {
                                  key: "activator",
                                  fn: function(ref) {
                                    var on = ref.on
                                    var attrs = ref.attrs
                                    return [
                                      _c(
                                        "v-text-field",
                                        _vm._g(
                                          _vm._b(
                                            {
                                              attrs: {
                                                clearable: "",
                                                label: "Pick time",
                                                "prepend-inner-icon":
                                                  "mdi-clock-outline",
                                                readonly: ""
                                              },
                                              model: {
                                                value: _vm.config.time,
                                                callback: function($$v) {
                                                  _vm.$set(
                                                    _vm.config,
                                                    "time",
                                                    $$v
                                                  )
                                                },
                                                expression: "config.time"
                                              }
                                            },
                                            "v-text-field",
                                            attrs,
                                            false
                                          ),
                                          on
                                        )
                                      )
                                    ]
                                  }
                                }
                              ]),
                              model: {
                                value: _vm.menu2,
                                callback: function($$v) {
                                  _vm.menu2 = $$v
                                },
                                expression: "menu2"
                              }
                            },
                            [
                              _vm._v(" "),
                              _vm.menu2
                                ? _c("v-time-picker", {
                                    attrs: {
                                      "ampm-in-title": "",
                                      "full-width": ""
                                    },
                                    on: {
                                      "click:minute": function($event) {
                                        return _vm.$refs.menu.save(
                                          _vm.config.time
                                        )
                                      }
                                    },
                                    model: {
                                      value: _vm.config.time,
                                      callback: function($$v) {
                                        _vm.$set(_vm.config, "time", $$v)
                                      },
                                      expression: "config.time"
                                    }
                                  })
                                : _vm._e()
                            ],
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "6" } },
                        [
                          _c("v-autocomplete", {
                            attrs: {
                              items: _vm.timezones,
                              "hide-no-data": "",
                              "hide-selected": "",
                              label: "Timezones",
                              placeholder:
                                "Start typing to Search. Default is PST",
                              "return-object": "",
                              clearable: ""
                            },
                            model: {
                              value: _vm.config.timezone,
                              callback: function($$v) {
                                _vm.$set(_vm.config, "timezone", $$v)
                              },
                              expression: "config.timezone"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12", md: "6" } },
                        [
                          _c("v-autocomplete", {
                            attrs: {
                              items: _vm.users,
                              "hide-no-data": "",
                              "hide-selected": "",
                              label: "Select psychics",
                              placeholder: "Start typing to Search",
                              "return-object": "",
                              clearable: "",
                              filter: _vm.customFilter,
                              "search-input": _vm.search,
                              "item-value": "id"
                            },
                            on: {
                              "update:searchInput": function($event) {
                                _vm.search = $event
                              },
                              "update:search-input": function($event) {
                                _vm.search = $event
                              }
                            },
                            scopedSlots: _vm._u([
                              {
                                key: "no-data",
                                fn: function() {
                                  return [
                                    _c(
                                      "v-list-item",
                                      [
                                        _c("v-list-item-title", [
                                          _vm._v(
                                            "Escribe nombre o correo del usuario"
                                          )
                                        ])
                                      ],
                                      1
                                    )
                                  ]
                                },
                                proxy: true
                              },
                              {
                                key: "selection",
                                fn: function(data) {
                                  return [
                                    _c(
                                      "v-chip",
                                      _vm._b(
                                        {
                                          attrs: {
                                            "input-value": data.selected,
                                            close: ""
                                          },
                                          on: {
                                            click: data.select,
                                            "click:close": function($event) {
                                              _vm.userSelected = null
                                            }
                                          }
                                        },
                                        "v-chip",
                                        data.attrs,
                                        false
                                      ),
                                      [
                                        _c(
                                          "v-avatar",
                                          { attrs: { left: "" } },
                                          [
                                            _c("img", {
                                              attrs: {
                                                src:
                                                  data.item.profile
                                                    .profile_headshot_url
                                              }
                                            })
                                          ]
                                        ),
                                        _vm._v(
                                          "\n                  " +
                                            _vm._s(
                                              data.item.profile.display_name
                                            ) +
                                            "\n                "
                                        )
                                      ],
                                      1
                                    )
                                  ]
                                }
                              },
                              {
                                key: "item",
                                fn: function(data) {
                                  return [
                                    typeof data.item !== "object"
                                      ? [
                                          _c("v-list-item-content", {
                                            domProps: {
                                              textContent: _vm._s(data.item)
                                            }
                                          })
                                        ]
                                      : [
                                          _c("img", {
                                            staticStyle: {
                                              position: "absolute",
                                              top: "14px",
                                              "border-radius": "50%"
                                            },
                                            attrs: {
                                              src:
                                                data.item.profile
                                                  .profile_headshot_url,
                                              height: "40",
                                              width: "40"
                                            }
                                          }),
                                          _vm._v(" "),
                                          _c(
                                            "v-list-item-content",
                                            {
                                              staticStyle: {
                                                "max-width": "400px",
                                                "margin-left": "50px"
                                              }
                                            },
                                            [
                                              _c(
                                                "v-row",
                                                [
                                                  _c(
                                                    "v-col",
                                                    {
                                                      staticClass: "py-0",
                                                      attrs: { cols: "12" }
                                                    },
                                                    [
                                                      _c("v-list-item-title", {
                                                        domProps: {
                                                          innerHTML: _vm._s(
                                                            data.item.profile
                                                              .display_name
                                                          )
                                                        }
                                                      })
                                                    ],
                                                    1
                                                  ),
                                                  _vm._v(" "),
                                                  data.item.reviews
                                                    ? _c(
                                                        "v-col",
                                                        {
                                                          staticClass: "py-0",
                                                          attrs: { cols: "12" }
                                                        },
                                                        [
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "d-inline-block"
                                                            },
                                                            [
                                                              _c("v-rating", {
                                                                attrs: {
                                                                  value: _vm.ratingAvg(
                                                                    data.item
                                                                      .reviews
                                                                  ),
                                                                  dense: "",
                                                                  size: "18",
                                                                  color:
                                                                    "#F5C250"
                                                                }
                                                              })
                                                            ],
                                                            1
                                                          ),
                                                          _vm._v(" "),
                                                          data.item.reviews
                                                            ? _c(
                                                                "span",
                                                                {
                                                                  staticStyle: {
                                                                    color:
                                                                      "#43425D",
                                                                    "font-size":
                                                                      "14px",
                                                                    opacity:
                                                                      "50%"
                                                                  }
                                                                },
                                                                [
                                                                  _vm._v(
                                                                    _vm._s(
                                                                      data.item
                                                                        .reviews
                                                                        .length
                                                                    ) +
                                                                      " Reviews"
                                                                  )
                                                                ]
                                                              )
                                                            : _vm._e(),
                                                          _vm._v(" "),
                                                          _c(
                                                            "div",
                                                            {
                                                              staticClass:
                                                                "mt-2",
                                                              staticStyle: {
                                                                color: "#43425D"
                                                              }
                                                            },
                                                            [
                                                              _vm._v(
                                                                _vm._s(
                                                                  _vm.getCategories(
                                                                    data.item
                                                                      .categories
                                                                  )
                                                                )
                                                              )
                                                            ]
                                                          ),
                                                          _vm._v(" "),
                                                          data.item.profile
                                                            .description
                                                            ? _c(
                                                                "div",
                                                                {
                                                                  staticClass:
                                                                    "mt-2",
                                                                  staticStyle: {
                                                                    color:
                                                                      "#43425D"
                                                                  }
                                                                },
                                                                [
                                                                  _vm._v(
                                                                    _vm._s(
                                                                      data.item
                                                                        .profile
                                                                        .description
                                                                        .length >
                                                                        200
                                                                        ? data.item.profile.description.substring(
                                                                            1,
                                                                            200
                                                                          ) +
                                                                            "..."
                                                                        : data
                                                                            .item
                                                                            .profile
                                                                            .description
                                                                    )
                                                                  )
                                                                ]
                                                              )
                                                            : _vm._e()
                                                        ]
                                                      )
                                                    : _vm._e()
                                                ],
                                                1
                                              ),
                                              _vm._v(" "),
                                              _c("v-divider")
                                            ],
                                            1
                                          )
                                        ]
                                  ]
                                }
                              }
                            ]),
                            model: {
                              value: _vm.userSelected,
                              callback: function($$v) {
                                _vm.userSelected = $$v
                              },
                              expression: "userSelected"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _vm.userSelected
                    ? _c(
                        "v-row",
                        [
                          _c(
                            "v-col",
                            {
                              staticClass: "pa-3",
                              attrs: { cols: "12", md: "6" }
                            },
                            [
                              _c(
                                "v-icon",
                                {
                                  staticStyle: {
                                    "z-index": "3",
                                    position: "absolute",
                                    right: "20px",
                                    "margin-top": "6px",
                                    "font-size": "20px",
                                    cursor: "pointer",
                                    width: "20px",
                                    height: "20px"
                                  },
                                  on: {
                                    click: function($event) {
                                      _vm.userSelected = null
                                    }
                                  }
                                },
                                [_vm._v("mdi-close")]
                              ),
                              _vm._v(" "),
                              _c(
                                "v-list",
                                {
                                  staticStyle: { "z-index": "2" },
                                  attrs: { "three-line": "" }
                                },
                                [
                                  [
                                    _c(
                                      "v-list-item",
                                      [
                                        _c(
                                          "v-list-item-avatar",
                                          { attrs: { size: "60" } },
                                          [
                                            _c("v-img", {
                                              attrs: {
                                                src:
                                                  _vm.userSelected.profile
                                                    .profile_headshot_url
                                              }
                                            })
                                          ],
                                          1
                                        ),
                                        _vm._v(" "),
                                        _c(
                                          "v-list-item-content",
                                          [
                                            _c("v-list-item-title", [
                                              _c(
                                                "div",
                                                {
                                                  staticStyle: {
                                                    color: "#43425D",
                                                    "font-size": "16px",
                                                    "font-weight": "600"
                                                  }
                                                },
                                                [
                                                  _vm._v(
                                                    _vm._s(
                                                      _vm.userSelected.profile
                                                        .display_name
                                                    )
                                                  )
                                                ]
                                              ),
                                              _vm._v(" "),
                                              _vm.userSelected.reviews
                                                ? _c(
                                                    "div",
                                                    {
                                                      staticClass:
                                                        "d-flex align-center",
                                                      staticStyle: {
                                                        color: "#43425D",
                                                        "font-size": "14px"
                                                      }
                                                    },
                                                    [
                                                      _c("v-rating", {
                                                        attrs: {
                                                          value: _vm.ratingAvg(
                                                            _vm.userSelected
                                                              .reviews
                                                          ),
                                                          dense: "",
                                                          size: "18",
                                                          color: "#F5C250"
                                                        }
                                                      }),
                                                      _vm._v(" "),
                                                      _c(
                                                        "span",
                                                        {
                                                          staticClass: "ml-3",
                                                          staticStyle: {
                                                            opacity: "50%"
                                                          }
                                                        },
                                                        [
                                                          _vm._v(
                                                            _vm._s(
                                                              _vm.userSelected
                                                                .reviews.length
                                                            ) + " Reviews"
                                                          )
                                                        ]
                                                      )
                                                    ],
                                                    1
                                                  )
                                                : _vm._e()
                                            ]),
                                            _vm._v(" "),
                                            _c(
                                              "v-list-item-subtitle",
                                              [
                                                _c(
                                                  "v-row",
                                                  [
                                                    _c("v-col", {
                                                      staticClass:
                                                        "d-flex pb-0",
                                                      staticStyle: {
                                                        "z-index": "2"
                                                      }
                                                    })
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "v-row",
                                                  [
                                                    _c(
                                                      "v-col",
                                                      {
                                                        staticClass:
                                                          "d-flex py-0",
                                                        staticStyle: {
                                                          color: "#656B72",
                                                          "font-size": "12px"
                                                        }
                                                      },
                                                      [
                                                        _vm._v(
                                                          _vm._s(
                                                            _vm.getCategories(
                                                              _vm.userSelected
                                                                .categories
                                                            )
                                                          )
                                                        )
                                                      ]
                                                    )
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "v-row",
                                                  [
                                                    _c(
                                                      "v-col",
                                                      {
                                                        staticClass:
                                                          "d-flex justify-end py-0"
                                                      },
                                                      [
                                                        _c(
                                                          "v-icon",
                                                          {
                                                            staticStyle: {
                                                              cursor: "pointer"
                                                            },
                                                            attrs: {
                                                              color: "teal",
                                                              size: "20"
                                                            },
                                                            on: {
                                                              click: function(
                                                                $event
                                                              ) {
                                                                _vm.dialog = true
                                                              }
                                                            }
                                                          },
                                                          [_vm._v("mdi-pencil")]
                                                        )
                                                      ],
                                                      1
                                                    )
                                                  ],
                                                  1
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "v-row",
                                                  [
                                                    _c(
                                                      "v-col",
                                                      { staticClass: "d-flex" },
                                                      [
                                                        _vm._v(
                                                          "\n                         " +
                                                            _vm._s(
                                                              _vm.userSelected
                                                                .profile
                                                                .description
                                                            ) +
                                                            "\n                        "
                                                        )
                                                      ]
                                                    )
                                                  ],
                                                  1
                                                )
                                              ],
                                              1
                                            )
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  ]
                                ],
                                2
                              )
                            ],
                            1
                          )
                        ],
                        1
                      )
                    : _vm._e(),
                  _vm._v(" "),
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        {
                          staticClass: "d-flex justify-end",
                          attrs: { cols: "12" }
                        },
                        [
                          _c(
                            "v-btn",
                            {
                              staticClass: "mr-3",
                              attrs: {
                                color: "purple",
                                dark: "",
                                loading: _vm.loading
                              },
                              on: { click: _vm.save }
                            },
                            [_vm._v("save")]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-dialog",
            {
              attrs: { "max-width": "700px" },
              model: {
                value: _vm.dialog,
                callback: function($$v) {
                  _vm.dialog = $$v
                },
                expression: "dialog"
              }
            },
            [
              _c(
                "v-card",
                [
                  _c(
                    "v-card-text",
                    [
                      _c(
                        "v-container",
                        { staticClass: "pb-0" },
                        [
                          _c(
                            "v-form",
                            { ref: "sign" },
                            [
                              _c(
                                "v-row",
                                [
                                  _c(
                                    "v-col",
                                    {
                                      staticClass: "py-0 pt-5",
                                      attrs: { cols: "12" }
                                    },
                                    [
                                      _c("v-textarea", {
                                        attrs: {
                                          rules: _vm.nameRules,
                                          required: "",
                                          outlined: "",
                                          name: "input-7-5",
                                          label: "Description"
                                        },
                                        model: {
                                          value: _vm.description,
                                          callback: function($$v) {
                                            _vm.description = $$v
                                          },
                                          expression: "description"
                                        }
                                      })
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-card-actions",
                    [
                      _c("v-spacer"),
                      _vm._v(" "),
                      _c(
                        "v-btn",
                        {
                          attrs: { color: "blue darken-1", text: "" },
                          on: {
                            click: function($event) {
                              _vm.dialog = false
                            }
                          }
                        },
                        [_vm._v("Cancel")]
                      ),
                      _vm._v(" "),
                      _c(
                        "v-btn",
                        {
                          attrs: { color: "blue darken-1", text: "" },
                          on: {
                            click: function($event) {
                              return _vm.saveDescription()
                            }
                          }
                        },
                        [_vm._v("Save")]
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/admin/components/Email/Featured.vue":
/*!*******************************************************!*\
  !*** ./resources/admin/components/Email/Featured.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Featured_vue_vue_type_template_id_a5eeb55c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Featured.vue?vue&type=template&id=a5eeb55c& */ "./resources/admin/components/Email/Featured.vue?vue&type=template&id=a5eeb55c&");
/* harmony import */ var _Featured_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Featured.vue?vue&type=script&lang=js& */ "./resources/admin/components/Email/Featured.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vuetify-loader/lib/runtime/installComponents.js */ "./node_modules/vuetify-loader/lib/runtime/installComponents.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuetify_lib_components_VAutocomplete__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuetify/lib/components/VAutocomplete */ "./node_modules/vuetify/lib/components/VAutocomplete/index.js");
/* harmony import */ var vuetify_lib_components_VAvatar__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuetify/lib/components/VAvatar */ "./node_modules/vuetify/lib/components/VAvatar/index.js");
/* harmony import */ var vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuetify/lib/components/VBtn */ "./node_modules/vuetify/lib/components/VBtn/index.js");
/* harmony import */ var vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vuetify/lib/components/VCard */ "./node_modules/vuetify/lib/components/VCard/index.js");
/* harmony import */ var vuetify_lib_components_VChip__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! vuetify/lib/components/VChip */ "./node_modules/vuetify/lib/components/VChip/index.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/index.js");
/* harmony import */ var vuetify_lib_components_VDatePicker__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! vuetify/lib/components/VDatePicker */ "./node_modules/vuetify/lib/components/VDatePicker/index.js");
/* harmony import */ var vuetify_lib_components_VDialog__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! vuetify/lib/components/VDialog */ "./node_modules/vuetify/lib/components/VDialog/index.js");
/* harmony import */ var vuetify_lib_components_VDivider__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! vuetify/lib/components/VDivider */ "./node_modules/vuetify/lib/components/VDivider/index.js");
/* harmony import */ var vuetify_lib_components_VForm__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! vuetify/lib/components/VForm */ "./node_modules/vuetify/lib/components/VForm/index.js");
/* harmony import */ var vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! vuetify/lib/components/VIcon */ "./node_modules/vuetify/lib/components/VIcon/index.js");
/* harmony import */ var vuetify_lib_components_VImg__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! vuetify/lib/components/VImg */ "./node_modules/vuetify/lib/components/VImg/index.js");
/* harmony import */ var vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! vuetify/lib/components/VList */ "./node_modules/vuetify/lib/components/VList/index.js");
/* harmony import */ var vuetify_lib_components_VMenu__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! vuetify/lib/components/VMenu */ "./node_modules/vuetify/lib/components/VMenu/index.js");
/* harmony import */ var vuetify_lib_components_VRating__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! vuetify/lib/components/VRating */ "./node_modules/vuetify/lib/components/VRating/index.js");
/* harmony import */ var vuetify_lib_components_VTextField__WEBPACK_IMPORTED_MODULE_19__ = __webpack_require__(/*! vuetify/lib/components/VTextField */ "./node_modules/vuetify/lib/components/VTextField/index.js");
/* harmony import */ var vuetify_lib_components_VTextarea__WEBPACK_IMPORTED_MODULE_20__ = __webpack_require__(/*! vuetify/lib/components/VTextarea */ "./node_modules/vuetify/lib/components/VTextarea/index.js");
/* harmony import */ var vuetify_lib_components_VTimePicker__WEBPACK_IMPORTED_MODULE_21__ = __webpack_require__(/*! vuetify/lib/components/VTimePicker */ "./node_modules/vuetify/lib/components/VTimePicker/index.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Featured_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Featured_vue_vue_type_template_id_a5eeb55c___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Featured_vue_vue_type_template_id_a5eeb55c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* vuetify-loader */





























_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default()(component, {VAutocomplete: vuetify_lib_components_VAutocomplete__WEBPACK_IMPORTED_MODULE_4__["VAutocomplete"],VAvatar: vuetify_lib_components_VAvatar__WEBPACK_IMPORTED_MODULE_5__["VAvatar"],VBtn: vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_6__["VBtn"],VCard: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_7__["VCard"],VCardActions: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_7__["VCardActions"],VCardText: vuetify_lib_components_VCard__WEBPACK_IMPORTED_MODULE_7__["VCardText"],VChip: vuetify_lib_components_VChip__WEBPACK_IMPORTED_MODULE_8__["VChip"],VCol: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_9__["VCol"],VContainer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_9__["VContainer"],VDatePicker: vuetify_lib_components_VDatePicker__WEBPACK_IMPORTED_MODULE_10__["VDatePicker"],VDialog: vuetify_lib_components_VDialog__WEBPACK_IMPORTED_MODULE_11__["VDialog"],VDivider: vuetify_lib_components_VDivider__WEBPACK_IMPORTED_MODULE_12__["VDivider"],VForm: vuetify_lib_components_VForm__WEBPACK_IMPORTED_MODULE_13__["VForm"],VIcon: vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_14__["VIcon"],VImg: vuetify_lib_components_VImg__WEBPACK_IMPORTED_MODULE_15__["VImg"],VList: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_16__["VList"],VListItem: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_16__["VListItem"],VListItemAvatar: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_16__["VListItemAvatar"],VListItemContent: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_16__["VListItemContent"],VListItemSubtitle: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_16__["VListItemSubtitle"],VListItemTitle: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_16__["VListItemTitle"],VMenu: vuetify_lib_components_VMenu__WEBPACK_IMPORTED_MODULE_17__["VMenu"],VRating: vuetify_lib_components_VRating__WEBPACK_IMPORTED_MODULE_18__["VRating"],VRow: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_9__["VRow"],VSpacer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_9__["VSpacer"],VTextField: vuetify_lib_components_VTextField__WEBPACK_IMPORTED_MODULE_19__["VTextField"],VTextarea: vuetify_lib_components_VTextarea__WEBPACK_IMPORTED_MODULE_20__["VTextarea"],VTimePicker: vuetify_lib_components_VTimePicker__WEBPACK_IMPORTED_MODULE_21__["VTimePicker"]})


/* hot reload */
if (false) { var api; }
component.options.__file = "resources/admin/components/Email/Featured.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/admin/components/Email/Featured.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/admin/components/Email/Featured.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Featured_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vuetify-loader/lib/loader.js??ref--12-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Featured.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vuetify-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/admin/components/Email/Featured.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Featured_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/admin/components/Email/Featured.vue?vue&type=template&id=a5eeb55c&":
/*!**************************************************************************************!*\
  !*** ./resources/admin/components/Email/Featured.vue?vue&type=template&id=a5eeb55c& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Featured_vue_vue_type_template_id_a5eeb55c___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vuetify-loader/lib/loader.js??ref--12-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Featured.vue?vue&type=template&id=a5eeb55c& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vuetify-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/admin/components/Email/Featured.vue?vue&type=template&id=a5eeb55c&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Featured_vue_vue_type_template_id_a5eeb55c___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Featured_vue_vue_type_template_id_a5eeb55c___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);