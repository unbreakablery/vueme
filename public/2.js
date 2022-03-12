(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vuetify-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/admin/components/Email/TopRated.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vuetify-loader/lib/loader.js??ref--12-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/admin/components/Email/TopRated.vue?vue&type=script&lang=js& ***!
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
      usersSelected: [],
      search: null
    };
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
  watch: {
    usersSelected: function usersSelected(val, old) {
      if (val.length && !val[val.length - 1].review) val[val.length - 1].review = val[val.length - 1].reviews[0];
    }
  },
  methods: {
    // allowedDates: (val) => {
    //   return moment(val).day() == 1;
    // },
    changeReview: function changeReview(item, index, review) {
      var item2 = Object.assign({}, item);
      item2.review = review;
      this.$set(this.usersSelected, index, item2);
    },
    remove: function remove(item) {
      var index;

      for (var i = 0; i < this.usersSelected.length; i++) {
        if (this.usersSelected[i].id == item.id) {
          index = i;
          break;
        }
      }

      if (index >= 0) this.usersSelected.splice(index, 1);
    },
    customFilter: function customFilter(item, queryText, itemText) {
      var textOne = item.profile.display_name.toLowerCase(); // const textTwo = item.email.toLowerCase();

      var searchText = queryText.toLowerCase();
      return textOne.indexOf(searchText) > -1 // || textTwo.indexOf(searchText) > -1
      ;
    },
    sendEmail: function sendEmail() {
      var _this = this;

      if (this.config.emails && confirm("Are you ready to send to ".concat(this.config.emails, " clients?"))) {
        this.save().then(function () {
          _this.loading = true;
          axios__WEBPACK_IMPORTED_MODULE_3___default.a.post("/api/admin/email/send/top-rate").then(function (response) {})["catch"](function (error) {})["finally"](function () {
            return _this.loading = false;
          });
        });
      }
    },
    save: function save() {
      var _this2 = this;

      if (!this.$refs.config.validate()) return;
      this.loading = true;
      this.config.users = this.usersSelected.map(function (i) {
        return {
          id: i.id,
          review: i.review.id
        };
      });
      return axios__WEBPACK_IMPORTED_MODULE_3___default.a.post("/api/admin/email/save/top-rate-config", this.config).then(function (response) {})["catch"](function (error) {})["finally"](function () {
        return _this2.loading = false;
      });
    }
  },
  created: function created() {
    var _this3 = this;

    axios__WEBPACK_IMPORTED_MODULE_3___default.a.get("/api/admin/email/top-rate-config").then(function (response) {
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
              var review = i.reviews.filter(function (r) {
                return r.id == item[0].review;
              });

              if (review.length) {
                item = Object.assign({}, i);
                item.review = Object.assign({}, review[0]);

                _this3.usersSelected.push(item);
              }
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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vuetify-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/admin/components/Email/TopRated.vue?vue&type=template&id=55caf85a&":
/*!***************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vuetify-loader/lib/loader.js??ref--12-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/admin/components/Email/TopRated.vue?vue&type=template&id=55caf85a& ***!
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
                              multiple: "",
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
                                              return _vm.remove(data.item)
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
                                          _c("v-list-item-avatar", [
                                            _c("img", {
                                              attrs: {
                                                src:
                                                  data.item.profile
                                                    .profile_headshot_url
                                              }
                                            })
                                          ]),
                                          _vm._v(" "),
                                          _c(
                                            "v-list-item-content",
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
                                          )
                                        ]
                                  ]
                                }
                              }
                            ]),
                            model: {
                              value: _vm.usersSelected,
                              callback: function($$v) {
                                _vm.usersSelected = $$v
                              },
                              expression: "usersSelected"
                            }
                          })
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _vm.usersSelected
                    ? _c(
                        "v-row",
                        _vm._l(_vm.usersSelected, function(item, index) {
                          return _c(
                            "v-col",
                            {
                              key: index,
                              staticClass: "pa-3",
                              attrs: { cols: "12", md: "6", lg: "4" }
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
                                      return _vm.remove(item)
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
                                      { key: index },
                                      [
                                        _c(
                                          "v-list-item-avatar",
                                          { attrs: { size: "60" } },
                                          [
                                            _c("v-img", {
                                              attrs: {
                                                src:
                                                  item.profile
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
                                                      item.profile.display_name
                                                    )
                                                  )
                                                ]
                                              ),
                                              _vm._v(" "),
                                              _c(
                                                "div",
                                                {
                                                  staticStyle: {
                                                    color: "#43425D",
                                                    "font-size": "14px",
                                                    opacity: "50%"
                                                  }
                                                },
                                                [
                                                  _vm._v(
                                                    _vm._s(
                                                      item.reviews.length
                                                    ) + " Reviews"
                                                  )
                                                ]
                                              )
                                            ]),
                                            _vm._v(" "),
                                            _c(
                                              "v-list-item-subtitle",
                                              [
                                                _c(
                                                  "v-row",
                                                  [
                                                    _c(
                                                      "v-col",
                                                      {
                                                        staticClass: "pa-2",
                                                        staticStyle: {
                                                          "z-index": "3"
                                                        }
                                                      },
                                                      [
                                                        _c(
                                                          "v-menu",
                                                          {
                                                            attrs: {
                                                              top: "",
                                                              "close-on-content-click":
                                                                "",
                                                              "z-index": "11"
                                                            },
                                                            scopedSlots: _vm._u(
                                                              [
                                                                {
                                                                  key:
                                                                    "activator",
                                                                  fn: function(
                                                                    ref
                                                                  ) {
                                                                    var on =
                                                                      ref.on
                                                                    var attrs =
                                                                      ref.attrs
                                                                    return [
                                                                      _c(
                                                                        "v-icon",
                                                                        _vm._g(
                                                                          _vm._b(
                                                                            {
                                                                              staticStyle: {
                                                                                position:
                                                                                  "absolute",
                                                                                right:
                                                                                  "20px",
                                                                                cursor:
                                                                                  "pointer"
                                                                              },
                                                                              attrs: {
                                                                                color:
                                                                                  "teal",
                                                                                size:
                                                                                  "20"
                                                                              }
                                                                            },
                                                                            "v-icon",
                                                                            attrs,
                                                                            false
                                                                          ),
                                                                          on
                                                                        ),
                                                                        [
                                                                          _vm._v(
                                                                            "mdi-pencil"
                                                                          )
                                                                        ]
                                                                      )
                                                                    ]
                                                                  }
                                                                }
                                                              ],
                                                              null,
                                                              true
                                                            )
                                                          },
                                                          [
                                                            _vm._v(" "),
                                                            _c(
                                                              "v-list",
                                                              {
                                                                staticClass:
                                                                  "pa-3"
                                                              },
                                                              _vm._l(
                                                                item.reviews,
                                                                function(
                                                                  item2,
                                                                  index2
                                                                ) {
                                                                  return _c(
                                                                    "v-list-item",
                                                                    {
                                                                      key: index2,
                                                                      staticClass:
                                                                        "d-block",
                                                                      on: {
                                                                        click: function(
                                                                          $event
                                                                        ) {
                                                                          return _vm.changeReview(
                                                                            item,
                                                                            index,
                                                                            item2
                                                                          )
                                                                        }
                                                                      }
                                                                    },
                                                                    [
                                                                      _c(
                                                                        "div",
                                                                        {
                                                                          staticClass:
                                                                            "px-2",
                                                                          style: {
                                                                            backgroundColor:
                                                                              item2.id ==
                                                                              item
                                                                                .review
                                                                                .id
                                                                                ? "#E0E0E0"
                                                                                : ""
                                                                          }
                                                                        },
                                                                        [
                                                                          _c(
                                                                            "v-row",
                                                                            [
                                                                              _c(
                                                                                "v-col",
                                                                                {
                                                                                  staticClass:
                                                                                    "d-flex pb-0"
                                                                                },
                                                                                [
                                                                                  _c(
                                                                                    "span",
                                                                                    {
                                                                                      staticClass:
                                                                                        "d-flex align-center",
                                                                                      staticStyle: {
                                                                                        color:
                                                                                          "#43425D",
                                                                                        "font-size":
                                                                                          "16px",
                                                                                        "font-weight":
                                                                                          "600"
                                                                                      }
                                                                                    },
                                                                                    [
                                                                                      _vm._v(
                                                                                        _vm._s(
                                                                                          item2.title
                                                                                        )
                                                                                      )
                                                                                    ]
                                                                                  ),
                                                                                  _vm._v(
                                                                                    " "
                                                                                  ),
                                                                                  _c(
                                                                                    "v-rating",
                                                                                    {
                                                                                      staticClass:
                                                                                        "ml-3",
                                                                                      attrs: {
                                                                                        value:
                                                                                          item2.rating,
                                                                                        dense:
                                                                                          "",
                                                                                        size:
                                                                                          "18",
                                                                                        color:
                                                                                          "#F5C250"
                                                                                      }
                                                                                    }
                                                                                  )
                                                                                ],
                                                                                1
                                                                              )
                                                                            ],
                                                                            1
                                                                          ),
                                                                          _vm._v(
                                                                            " "
                                                                          ),
                                                                          _c(
                                                                            "v-row",
                                                                            [
                                                                              _c(
                                                                                "v-col",
                                                                                {
                                                                                  staticClass:
                                                                                    "d-flex py-0",
                                                                                  staticStyle: {
                                                                                    color:
                                                                                      "#656B72",
                                                                                    "font-size":
                                                                                      "12px"
                                                                                  }
                                                                                },
                                                                                [
                                                                                  _vm._v(
                                                                                    _vm._s(
                                                                                      item2.text
                                                                                    )
                                                                                  )
                                                                                ]
                                                                              )
                                                                            ],
                                                                            1
                                                                          )
                                                                        ],
                                                                        1
                                                                      )
                                                                    ]
                                                                  )
                                                                }
                                                              ),
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
                                                  "v-row",
                                                  [
                                                    _c(
                                                      "v-col",
                                                      {
                                                        staticClass:
                                                          "d-flex pb-0",
                                                        staticStyle: {
                                                          "z-index": "2"
                                                        }
                                                      },
                                                      [
                                                        _c(
                                                          "span",
                                                          {
                                                            staticClass:
                                                              "d-flex align-center",
                                                            staticStyle: {
                                                              color: "#43425D",
                                                              "font-size":
                                                                "16px",
                                                              "font-weight":
                                                                "600"
                                                            }
                                                          },
                                                          [
                                                            _vm._v(
                                                              _vm._s(
                                                                item.review
                                                                  .title
                                                              )
                                                            )
                                                          ]
                                                        ),
                                                        _vm._v(" "),
                                                        _c("v-rating", {
                                                          staticClass: "ml-3",
                                                          attrs: {
                                                            value:
                                                              item.review
                                                                .rating,
                                                            dense: "",
                                                            size: "18",
                                                            color: "#F5C250"
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
                                                            item.review.text
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
                                                          "d-flex justify-end"
                                                      },
                                                      [
                                                        _c(
                                                          "a",
                                                          {
                                                            attrs: {
                                                              target: "_blank",
                                                              href:
                                                                "/" +
                                                                item.profile
                                                                  .profile_link
                                                            }
                                                          },
                                                          [
                                                            _c(
                                                              "v-btn",
                                                              {
                                                                attrs: {
                                                                  rounded: "",
                                                                  color:
                                                                    "#8EBEF8",
                                                                  dark: ""
                                                                }
                                                              },
                                                              [
                                                                _c(
                                                                  "span",
                                                                  {
                                                                    staticStyle: {
                                                                      "font-size":
                                                                        "12px",
                                                                      "font-weight":
                                                                        "600",
                                                                      "text-transform":
                                                                        "capitalize"
                                                                    }
                                                                  },
                                                                  [
                                                                    _vm._v(
                                                                      "Profile"
                                                                    )
                                                                  ]
                                                                )
                                                              ]
                                                            )
                                                          ],
                                                          1
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
                        }),
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

/***/ "./resources/admin/components/Email/TopRated.vue":
/*!*******************************************************!*\
  !*** ./resources/admin/components/Email/TopRated.vue ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TopRated_vue_vue_type_template_id_55caf85a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TopRated.vue?vue&type=template&id=55caf85a& */ "./resources/admin/components/Email/TopRated.vue?vue&type=template&id=55caf85a&");
/* harmony import */ var _TopRated_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TopRated.vue?vue&type=script&lang=js& */ "./resources/admin/components/Email/TopRated.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vuetify-loader/lib/runtime/installComponents.js */ "./node_modules/vuetify-loader/lib/runtime/installComponents.js");
/* harmony import */ var _node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var vuetify_lib_components_VAutocomplete__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuetify/lib/components/VAutocomplete */ "./node_modules/vuetify/lib/components/VAutocomplete/index.js");
/* harmony import */ var vuetify_lib_components_VAvatar__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! vuetify/lib/components/VAvatar */ "./node_modules/vuetify/lib/components/VAvatar/index.js");
/* harmony import */ var vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vuetify/lib/components/VBtn */ "./node_modules/vuetify/lib/components/VBtn/index.js");
/* harmony import */ var vuetify_lib_components_VChip__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vuetify/lib/components/VChip */ "./node_modules/vuetify/lib/components/VChip/index.js");
/* harmony import */ var vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! vuetify/lib/components/VGrid */ "./node_modules/vuetify/lib/components/VGrid/index.js");
/* harmony import */ var vuetify_lib_components_VDatePicker__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! vuetify/lib/components/VDatePicker */ "./node_modules/vuetify/lib/components/VDatePicker/index.js");
/* harmony import */ var vuetify_lib_components_VForm__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! vuetify/lib/components/VForm */ "./node_modules/vuetify/lib/components/VForm/index.js");
/* harmony import */ var vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! vuetify/lib/components/VIcon */ "./node_modules/vuetify/lib/components/VIcon/index.js");
/* harmony import */ var vuetify_lib_components_VImg__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! vuetify/lib/components/VImg */ "./node_modules/vuetify/lib/components/VImg/index.js");
/* harmony import */ var vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! vuetify/lib/components/VList */ "./node_modules/vuetify/lib/components/VList/index.js");
/* harmony import */ var vuetify_lib_components_VMenu__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! vuetify/lib/components/VMenu */ "./node_modules/vuetify/lib/components/VMenu/index.js");
/* harmony import */ var vuetify_lib_components_VRating__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! vuetify/lib/components/VRating */ "./node_modules/vuetify/lib/components/VRating/index.js");
/* harmony import */ var vuetify_lib_components_VTextField__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! vuetify/lib/components/VTextField */ "./node_modules/vuetify/lib/components/VTextField/index.js");
/* harmony import */ var vuetify_lib_components_VTimePicker__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! vuetify/lib/components/VTimePicker */ "./node_modules/vuetify/lib/components/VTimePicker/index.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _TopRated_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TopRated_vue_vue_type_template_id_55caf85a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TopRated_vue_vue_type_template_id_55caf85a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* vuetify-loader */






















_node_modules_vuetify_loader_lib_runtime_installComponents_js__WEBPACK_IMPORTED_MODULE_3___default()(component, {VAutocomplete: vuetify_lib_components_VAutocomplete__WEBPACK_IMPORTED_MODULE_4__["VAutocomplete"],VAvatar: vuetify_lib_components_VAvatar__WEBPACK_IMPORTED_MODULE_5__["VAvatar"],VBtn: vuetify_lib_components_VBtn__WEBPACK_IMPORTED_MODULE_6__["VBtn"],VChip: vuetify_lib_components_VChip__WEBPACK_IMPORTED_MODULE_7__["VChip"],VCol: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_8__["VCol"],VContainer: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_8__["VContainer"],VDatePicker: vuetify_lib_components_VDatePicker__WEBPACK_IMPORTED_MODULE_9__["VDatePicker"],VForm: vuetify_lib_components_VForm__WEBPACK_IMPORTED_MODULE_10__["VForm"],VIcon: vuetify_lib_components_VIcon__WEBPACK_IMPORTED_MODULE_11__["VIcon"],VImg: vuetify_lib_components_VImg__WEBPACK_IMPORTED_MODULE_12__["VImg"],VList: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_13__["VList"],VListItem: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_13__["VListItem"],VListItemAvatar: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_13__["VListItemAvatar"],VListItemContent: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_13__["VListItemContent"],VListItemSubtitle: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_13__["VListItemSubtitle"],VListItemTitle: vuetify_lib_components_VList__WEBPACK_IMPORTED_MODULE_13__["VListItemTitle"],VMenu: vuetify_lib_components_VMenu__WEBPACK_IMPORTED_MODULE_14__["VMenu"],VRating: vuetify_lib_components_VRating__WEBPACK_IMPORTED_MODULE_15__["VRating"],VRow: vuetify_lib_components_VGrid__WEBPACK_IMPORTED_MODULE_8__["VRow"],VTextField: vuetify_lib_components_VTextField__WEBPACK_IMPORTED_MODULE_16__["VTextField"],VTimePicker: vuetify_lib_components_VTimePicker__WEBPACK_IMPORTED_MODULE_17__["VTimePicker"]})


/* hot reload */
if (false) { var api; }
component.options.__file = "resources/admin/components/Email/TopRated.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/admin/components/Email/TopRated.vue?vue&type=script&lang=js&":
/*!********************************************************************************!*\
  !*** ./resources/admin/components/Email/TopRated.vue?vue&type=script&lang=js& ***!
  \********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopRated_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vuetify-loader/lib/loader.js??ref--12-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./TopRated.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vuetify-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/admin/components/Email/TopRated.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopRated_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/admin/components/Email/TopRated.vue?vue&type=template&id=55caf85a&":
/*!**************************************************************************************!*\
  !*** ./resources/admin/components/Email/TopRated.vue?vue&type=template&id=55caf85a& ***!
  \**************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopRated_vue_vue_type_template_id_55caf85a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vuetify-loader/lib/loader.js??ref--12-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./TopRated.vue?vue&type=template&id=55caf85a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vuetify-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/admin/components/Email/TopRated.vue?vue&type=template&id=55caf85a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopRated_vue_vue_type_template_id_55caf85a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vuetify_loader_lib_loader_js_ref_12_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TopRated_vue_vue_type_template_id_55caf85a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);