<template>
  <div class="model-credit-logs">
    
    <div
      v-if="!Object.entries(card).length || edit"
      class="container container-gray-area elevation-0 model-payout-method py-3"
      style=" padding-top: 17px !important; padding-bottom: 28px; box-shadow: 0px 10px 13px #0000001a!important; margin:0 !important; max-width:100%"
    >
      <div class="subtitle-1 paymethod-title"><h2>Banking Info</h2></div>

      <v-row>
        <v-col
          md="6"
          sm="12"
          cols="12"
        >
          <div class="input" style="width: 100%">
            <h3>Bank Name<span> *</span></h3>
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              class="sfInputClassInactive sfInputClassLeft"          
              value=""
               v-model="obj_account.bank_name"
            ></v-text-field>

            <span
                      v-if="obj_error.bank_name"
                      class="float-left text-danger small"
                      >Bank Name is required</span>
          </div>
        </v-col>
        <v-col
          md="6"
          sm="12"
          cols="12"
        >
          <div class="input" style="width: 100%">
            <h3>Country<span> *</span></h3>
            <v-select
              id="profile_country"
              v-model="obj_account.address_country"
              :items="countries"
              
              label="Select"
              background-color="#fff"
              filled
              dense
              solo
              flat
              disabled
              hide-details
              item-text="name"
              item-value="code"
              class="checkRigth right-align profile_country"
              :menu-props="{ contentClass: 'checkList-lineBlue' }"
            ></v-select>

            <span
                      v-if="errors['address_country']"
                      class="float-left text-danger small"
                      >{{ errors["address_country"][0] }}</span>
            
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col
          md="6"
          sm="12"
          cols="12"
        >
          <div class="input" style="width: 100%">
            <h3>First Name<span> *</span></h3>
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              class="sfInputClassInactive sfInputClassLeft"          
              value=""
              v-model="obj_account.first_name"
            ></v-text-field>
            <span
                      v-if="obj_error.first_name"
                      class="float-left text-danger small"
                      >Account Holder’s First Name is required</span
                    >
          </div>
        </v-col>
        <v-col
          md="6"
          sm="12"
          cols="12"
        >
          <div class="input" style="width: 100%">
            <h3>Last Name<span> *</span></h3>
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              class="sfInputClassInactive sfInputClassLeft"          
              value=""
              v-model="obj_account.last_name"
            ></v-text-field>
            <span
                      v-if="obj_error.last_name"
                      class="float-left text-danger small"
                      >Account Holder’s Last Name is required</span>
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col
          md="12"
          sm="12"
          class="input type-account">
          <h3>Type of Account<span> *</span></h3>
          <div class="col-12 p-0" style="margin-bottom: 10px">
                    <div
                      class="custom-control custom-radio custom-control-inline"
                    >
                      <input
                        v-model="obj_account.account_type"
                        value="checking"
                        checked
                        type="radio"
                        id="checking"
                        name="account_type"
                        class="custom-control-input"
                      />
                      <label
                        :class="{
                          rselected: obj_account.account_type === 'checking',
                          runselected: obj_account.account_type !== 'checking',
                        }"
                        class="custom-control-label"
                        for="checking"
                        >Checking</label
                      >
                    </div>
                    <div
                      class="custom-control custom-radio custom-control-inline"
                    >
                      <input
                        v-model="obj_account.account_type"
                        value="savings"
                        type="radio"
                        id="savings"
                        name="account_type"
                        class="custom-control-input"
                      />
                      <label
                        :class="{
                          rselected: obj_account.account_type === 'savings',
                          runselected: obj_account.account_type !== 'savings',
                        }"
                        class="custom-control-label"
                        for="savings"
                        >Savings</label
                      >
                    </div>
                  </div>
        </v-col>
        <span
                    v-if="errors['account_type']"
                    class="float-left text-danger small"
                    >{{ errors["account_type"][0] }}</span
                  >
      </v-row>
      <v-row>
        <v-col
          md="6"
          sm="12"
          cols="12"
        >
          <div class="input" style="width: 100%">
            <h3>Account Number<span> *</span></h3>
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              class="sfInputClassInactive sfInputClassLeft"          
              value=""
              v-model="obj_account.account_number"
            ></v-text-field>

            <span
                      v-if="obj_error.account_number"
                      class="float-left text-danger small"
                      >Account Number is required</span>
                      <span
                      v-if="errors['account_number']"
                      class="float-left text-danger small"
                      >{{ errors["account_number"][0] }}</span>
          </div>
        </v-col>
        <v-col
          md="6"
          sm="12"
          cols="12"
        >
          <div class="input" style="width: 100%">
            <h3>Routing Number<span> *</span></h3>
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              class="sfInputClassInactive sfInputClassLeft"          
              value=""
              v-model="obj_account.routing_number"
            ></v-text-field>

            <span
                      v-if="obj_error.routing_number"
                      class="float-left text-danger small"
                      >Routing Number is required</span>
                    <span
                      v-if="errors['routing_number']"
                      class="float-left text-danger small"
                      >{{ errors["routing_number"][0] }}</span>
          </div>
        </v-col>
      </v-row>
      <div class="tab-content" id="nav-tabContent" style>
        <div
          class="tab-pane fade show active"
          id="nav-posts"
          role="tabpanel"
          aria-labelledby="nav-posts-tab"
        >
          <v-form class="form-dashboard">
            <v-btn
              style="min-width: auto !important; 
                background: linear-gradient(256deg, #7272FF 0%, #9759ff 100%);
                box-shadow: 0 2px 4px #9759FF4D!Important;
                border-radius: 12px;
                outline: none;
                "
              depressed
              @click="add_deposit_account()"
              :loading="loading"
              :disabled="loading"
              rounded
              color="primary"
              class="model-btn"
            >Save Information</v-btn>

            <v-btn v-if="edit" depressed @click="edit=false" rounded>Cancel</v-btn>
          </v-form>
        </div>
      </div>
    </div>
    <div v-if="Object.entries(card).length && !edit">
      <v-simple-table class="elevation-0 mt-3">
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">Account</th>
              <th class="text-center">Type</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr :key="card.id">
              <td>{{ card.account }}</td>
              <td class="text-center">{{ card.account_type }}</td>
              <td class="text-right">                
                <v-btn  depressed small text icon color="white" :loading="loading" @click="f_delete_deposit_account(card)">
                   <img src="/images/icons/delete-button.png"  />
                </v-btn>
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </div>
  </div>
</template>

<script>
function getData() {
  return {
    dialog_message: false,
    message: "",
    message_title: "",
    loading: false,
    tab_in_use: "payout_method",
    edit: false,

    obj_account: {
      method:
        Object.keys(this.cards).length > 0 ? this.cards.payment : "DEPOSIT",
      checkname: null,
      account_type: "checking",
      routing_number: null,
      account_number: null,
      address_country: "US",
      paypal_account: "",
    },

    sending_method: false,
    successfully_method_added: false,

    obj_error: {
      method: "DEPOSIT",
      checkname: null,
      account_type: "checking",
      routing_number: null,
      account_number: null,
      address_country: "",
      paypal_account: null,
    },
    errors: [],
    card: this.cards,
  };
}
export default {
  name: "payou_method",
  props: ["user", "countries", "cards"],
  data: getData,

  methods: {
    f_edit_deposit_account() {
      if (this.card.payment === "DEPOSIT") {
        this.obj_account.address_country = this.card.country;
        this.obj_account.checkname = this.card.account_name;
        this.obj_account.account_type = this.card.account_type;
        this.obj_account.routing_number = this.card.routing;
        this.obj_account.account_number = this.card.account;
        this.obj_account.method = this.card.payment;
      } else {
        this.obj_account.paypal_account = this.card.account;
        this.account_type = "";
        this.obj_account.account = this.card.account;
        this.obj_account.method = "PAYPAL";
      }
      this.edit = true;
    },
    f_delete_deposit_account(card) {
      if (this.obj_account.method.toUpperCase() === "PAYPAL") {
        this.f_delete_paypal_account();
        this.f_reset_data();
        this.card = [];
      } else {
        let type = "DEPOSIT";
        this.loading = true;
        axios
          .delete("/api/v1/user/account/card", {
            params: {
              card_type: type,
              biller: card.id,
            },
          })
          .then((response) => {
            this.f_reset_data();
            this.card = [];
            this.$root.$emit("open_dialog_message", {
              message: response.data.success,
              message_title: "SUCCESS",
            });
          })
          .catch((error) => {
            this.loading = false;

            if (error.response.status === 400) {
              this.message = error.response.data.error;
            } else {
              this.message = error.response.data.message;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
          });
      }
    },
    f_reset_data() {
      Object.assign(this.$data, this.$options.data.call(this));
    },
    getDepositAccount(type) {
      axios
        .get("/api/v1/user/account/cards", {
          params: {
            card_type: type,
          },
        })
        .then((response) => {
          this.card = response.data;
        })
        .catch((error) => {
          this.message = error;
        });
    },
    send_edit_deposit_account() {
      axios
        .put("/api/v1/user/account/payout", {
          checkname: this.obj_account.checkname,
          account_type: this.obj_account.account_type,
          routing_number: this.obj_account.routing_number,
          account_number: this.obj_account.account_number,
          address_country: this.obj_account.address_country,
          billing_id: this.card.id,
        })
        .then((response) => {
          this.loading = false;
          this.$root.$emit("open_dialog_message", {
            message: response.data.success,
            message_title: "SUCCESS",
          });
          this.f_reset_data();
          this.card = [];
          this.getDepositAccount("DEPOSIT");
        })
        .catch((error) => {
          this.loading = false;
          if (error.response.status === 400) {
            this.message = error.response.data.error;
          } else {
            this.message = "Please update your account details and try again";
          }
          this.$root.$emit("open_dialog_message", {
            message: this.message,
            message_title: "ERROR",
          });
        });
    },
    send_new_depossit_account() {
      this.loading = true;
      if (this.edit) {
        if (this.obj_account.method === "PAYPAL") {
          this.f_save_paypal_account();
        } else {
          this.send_edit_deposit_account();
        }
      } else {
      
      
    
        axios
          .post("/api/v1/user/account/depositAccount", {
            checkname:
              this.obj_account.first_name + " " + this.obj_account.last_name,
            account_type: this.obj_account.account_type,
            bank_name: this.obj_account.bank_name,
            routing_number: this.obj_account.routing_number,
            account_number: this.obj_account.account_number,
            address_country: this.obj_account.address_country,
          })
          .then((response) => {
            this.loading = false;
            this.$root.$emit("open_dialog_message", {
              message: response.data.success,
              message_title: "SUCCESS",
            });
            this.f_reset_data();
            this.card = [];
            this.getDepositAccount("DEPOSIT");
          })
          .catch((error) => {
            this.loading = false;
            if (error.response.status === 400) {
              this.message = error.response.data.error;
              this.errors = error.response.data.errors;
            } else {
              this.message = error.response.data.message;
              this.errors = error.response.data.errors;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
          });
      }
    },
    add_deposit_account(e) {
      
      if (this.obj_account.method === "DEPOSIT") {
        if (this.check_form(e)) {
          this.send_new_depossit_account();
        }
      } else {
        alert("3");
        this.obj_error.paypal_account = !this.obj_account.paypal_account;

        if (this.obj_error.paypal_account) {
          return;
        }
        this.f_save_paypal_account();
      }
    },
    f_save_paypal_account() {
      this.loading = true;
      axios
        .post("/api/v1/user/account/paypal", {
          email: this.obj_account.paypal_account,
        })
        .then((response) => {
          if (this.edit) {
            this.$root.$emit("open_dialog_message", {
              message: "Your PayPal account was updated",
              message_title: "SUCCESS",
            });
            this.card.account = this.obj_account.paypal_account;
            this.edit = false;
          } else {
            this.card.account = this.obj_account.paypal_account;
            this.card.account_type = "PAYPAL";
            this.$root.$emit("open_dialog_message", {
              message: response.data.success,
              message_title: "SUCCESS",
            });
          }

          this.loading = false;

          //EventBus.$emit('open_dialog_message',{});
        })
        .catch((error) => {
          this.loading = false;
          //this.edit =false;
          if (error.response.status === 400) {
            this.message = error.response.data.error;
          } else {
            this.message =
              "Your PayPal account could not be added. " +
              error.response.data.message;
          }
          this.$root.$emit("open_dialog_message", {
            message: this.message,
            message_title: "ERROR",
          });
          //EventBus.$emit('open_dialog_message',{});
        });
    },
    f_delete_paypal_account() {
      this.loading = true;
      axios
        .delete("/api/v1/user/account/paypal", {
          email: this.obj_account.paypal_account,
        })
        .then((response) => {
          this.loading = false;
          this.card = [];
          this.obj_account.method = "DEPOSIT";
          this.$root.$emit("open_dialog_message", {
            message: response.data.success,
            message_title: "SUCCESS",
          });
        })
        .catch((error) => {
          if (error.response.status === 400) {
            this.message = error.response.data.error;
          } else {
            this.message =
              "Your payment method could not be removed. ";
          }
          this.$root.$emit("open_dialog_message", {
            message: this.message,
            message_title: "ERROR",
          });
        });
    },
    checkField(e) {

      if(typeof(e.currentTarget) != "undefined"){
     
      
      switch (e.currentTarget.id) {
        case "address_country":
          if (e.currentTarget.value !== "United States") {
            this.obj_account.method = "PAYPAL";
          }
          
          this.obj_error.address_country = !this.obj_account.address_country;
          break;
        case "checkname":
          this.obj_error.checkname = !this.obj_account.checkname;
          break;
        case "routing_number":
          this.obj_error.routing_number = !this.obj_account.routing_number;
          break;
        case "account_number":
          this.obj_error.account_number = !this.obj_account.account_number;
          break;
        case "paypal_account":
          this.obj_error.paypal_account = !this.obj_account.paypal_account;
          break;

        default:
      }

      }else{

              console.log(e)
                if (e !== 232)
                this.obj_account.method = "PAYPAL";

                this.obj_error.address_country = !this.obj_account.address_country;
          
      }
    
    },
   check_form(e) {
      this.obj_error.address_country = !this.obj_account.address_country;
      this.obj_error.checkname = !this.obj_account.first_name;
      this.obj_error.bank_name = !this.obj_account.bank_name;
      this.obj_error.first_name = !this.obj_account.first_name;
      this.obj_error.last_name = !this.obj_account.last_name;
      this.obj_error.routing_number = !this.obj_account.routing_number;
      this.obj_error.account_number = !this.obj_account.account_number;
      this.obj_error.method = !this.obj_account.method;
      this.obj_error.account_type = !this.obj_account.account_type;
      if (
        this.obj_error.address_country ||
        this.obj_error.method ||
        this.obj_error.bank_name ||
        this.obj_error.checkname ||
        this.obj_error.first_name ||
        this.obj_error.last_name ||
        this.obj_error.account_type ||
        this.obj_error.routing_number ||
        this.obj_error.account_number
      ) {
        return false;
      }
      return true;
    },
  },

  created() {
    // this.getDepositAccount('DEPOSIT');
    //  this.finished = true;
  },
  mounted() {
    $('.payout-check .v-label').wrapInner("<h3></h3>")
  },
};
</script>

<style lang="scss">

.profile_country .v-select__selections input{
  border: 0!important;
}

.model-payout-method {
  margin-top: 30px;
  max-width: 860px;
  margin-left: auto;
  margin-right: auto;
  padding-left: 24px!important;
  padding-right: 24px!important;
  box-shadow: 0px 10px 13px #0000001A!important;
  .v-select .v-label {
    visibility: hidden;
  }
  .type-account {
    .v-input--checkbox {
      margin-top: 0;
      display: inline-block;
      .v-messages {
        display: none;
      }
    }
    .mdi-checkbox-marked::before {
      background: url("/images/checkbox-selected.svg");
      background-repeat: no-repeat;
      background-position: bottom 5px right;
    }
    .mdi-checkbox-blank-outline::before {
      background: url("/images/checkbox-unselected.svg");
      background-repeat: no-repeat;
      background-position: bottom 5px right;
    }
  }
  .row {
    margin-left: -12px!important;
    margin-right: -12px!important;
  }
  .payout-check.v-input {
    h3 {
      font-size: 16px;
      color: #949498;
      font-weight: 600;
      padding-bottom: 0;
    }
  }
  .input {
    h3 {
      font-size: 12px;
      color: #131220;
      padding-bottom: 5px;
      margin-bottom: 0;
      font-weight: 600;
      span {
        color: #E31616;
      }
    }
  }
  .paymethod-title {
    margin-bottom: 25px;
    h2 {
      margin-bottom: 0;
      color: rgba(0, 0, 0, .87);
      font-size: 18px!important;
      font-weight: 600;
      font-family: "Montserrat", sans-serif;
    }
  }
  .paymethod-label {
    font-size: 12px;
    color: #131220;
    letter-spacing: unset;
    font-weight: bold;
    margin-bottom: 8px;
  }
  .payment-input-text {
    background-color: white!important;
    border: 1px solid #13122066!important;
    height: 36px!important;
  }
  .country-select {
    .v-input__control {
      .v-input__slot {
        padding: 0px!important;
        .v-select__slot {
          height: 36px;
          //border: 1px solid #797885!important;
          padding-left: 0px!important;
          .v-select__selections {
            flex-flow: column;
            .v-select__selection {
              margin: auto 0px;
            }
            input {
              display: none;
            }
          }
        }
      }
    }
  }
  .payout-radio {
    .custom-control-label::before {
      top: 0px;
    }
    .custom-control-label::after {
      top: 0px;
    }
    .custom-control-input:checked ~ .custom-control-label::before {
      border-color: #42424D;
      background-color: white;
    }
    .custom-control-input:checked ~ .custom-control-label::after {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='-4 -4 8 8'%3e%3ccircle r='4' fill='%2342424D'/%3e%3c/svg%3e");
    }
    .custom-control-input:focus ~ .custom-control-label::before {
      box-shadow: unset;
    }
  }
  .model-btn {
    .v-btn__content {
      font-size: 12px;
      font-weight: 600;
    }
  }
}
@media (max-width: 769px) {
  .model-payout-method {
    padding-left: 24px;
    padding-right: 24px;
  }
}
</style>

<style type="text/css" scoped>
.custom-select:focus {
  /*   border-color: #9390DE; */
  outline: 0;
  box-shadow: none;
}
#address_country {
  text-align-last: left;
  text-align: left !important;
    min-height: 32px !important;
    color: #8e8d99 !important;
    font-size: 12px !important;
    background: #F0F0F7  url("/images/icons/sort.svg") no-repeat right;
    border: none !important;
    
}
#address_country option{

  padding: 10px !important;
  border-bottom: 1px solid #fff;

}

.rselected {
  filter: blur(0.5);
}
.runselected {
  color: #cfd5db !important;
}
.custom-control-input:checked ~ .custom-control-label::before {
  border-color: #9759FF;
  background-color: #9759FF;
}
.label_text {
  color: #1f1e34 !important;
}
.rselected:hover,
.runselected:hover,
input[type="radio"]:hover {
  cursor: pointer;
}
.btnSave {
  padding: 0.6rem 25px !important;
  border-radius: 22px !important;
  color: #1f1e34 !important;
}
.v-tabs .v-tab {
  font-size: 20px;
}



.tabs_xs {
  font-size: 18px !important;
}
.v-dialog__content--active {
    opacity: 1 !important;
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
}

</style>
