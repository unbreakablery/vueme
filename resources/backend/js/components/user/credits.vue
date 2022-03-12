<template>
  <div>
    <div style="display: inline-flex">
      <!-- <v-btn style="margin-right: 5px;margin-top: 2px;"
      x-small class="credit_icon" color="white--text" @click="dialog_select_credit = true">$</v-btn>-->
      <span
        class="credits"
        :style="{ color: color }"
        @click="dialog_select_credit = true"
        >{{ currency }}{{ parseFloat(user_credits).toFixed(2) }}</span
      >
      <!-- <v-btn text small class="credits" color="white&#45;&#45;text"
                   @click="dialog_select_credit = true">
                {{ user.credits }}
      </v-btn>-->
    </div>

    <v-dialog v-model="dialog_select_credit" max-width="336px">
      <v-card class="transaction-dialog" height="100%">
        <v-list-item style="background-color: #fff; padding: 20px!important">
          <v-list-item-title>
            <v-icon
              v-if="dialog_new_card === true"
              class="d-block text-left mt-3"
              style="position: absolute; left: 15px; top: 0"
              @click="dialog_new_card = false"
              >mdi-arrow-left</v-icon
            >
            <v-icon
              class="d-block text-right mt-2"
              style="position: absolute; right: 15px; top: 0"
              @click="dialog_select_credit = false"
              >mdi-close</v-icon
            >
            <form class="payment_form">
              <div class="text-center" v-show="!dialog_new_card">
                <h2
                  class="h4 black--text text mt-9 mb-5"
                  style="font-size: 18px; font-weight: 600; color: #131220"
                  >Add Funds</h2
                >
              </div>
              <div class="text-center" v-show="dialog_new_card">
                <h2
                  class="h4 black--text text mt-9 mb-3"
                  style="font-size: 18px; font-weight: 600; color: #131220"
                  >Payment Information</h2
                >
              </div>
              <div class="justify-content-between credit-cards mb-5" v-show="!dialog_new_card">
                <img src="/images/cards/vs-image.jpg" alt="card"/>
                <img src="/images/cards/mc-image.jpg" alt="card"/>
                <img src="/images/cards/ds-image.jpg" alt="card"/>
                <img src="/images/cards/jc-image.jpg" alt="card"/>
                <img src="/images/cards/dc-image.jpg" alt="card"/>
              </div>
              <div class="form-row" v-show="!dialog_new_card">
                <div class="col-md-5 col-5 text-center wordwrap guarantee">
                  <img src="/images/icons/guarantee.png" style="margin-bottom: 8.2px" />
                  <a class="small" style="text-decoration: underline" href="#" @click.prevent="g_modal = true"
                    >Guarantee Terms</a
                  >
                </div>
                <div class="col-md-7 col-7 wordwrap px-0">
                  <div
                    class="h4 black--text mb-2 mt-2 txt-guarantee"
                  >
                    100% Response Guarantee
                  </div>
                  <div class="small txt-response">
                    You will get a response or you will not be charged.
                  </div>
                </div>
              </div>
              <div class="form-row card-purchase" v-show="!dialog_new_card">
                Please enter the amount you wish to purchase:
              </div>

              <div style="margin-bottom: 30px" v-show="!dialog_new_card">
                <v-menu center offset-y>
                  <template v-slot:activator="{ on }">
                    <label class="d-block text-left select-amount"
                      >SELECT AMOUNT{{' '}}<span style="color:#E31616">*</span></label
                    >
                    <v-btn
                      v-if="credits.value === 'Select Amount'"
                      depressed
                      class="select_credits"
                      tile
                      outlined
                      v-on="on"
                    >
                      {{ credits.value }}
                      <!-- <v-icon right>keyboard_arrow_down</v-icon> -->
                      <v-icon style="position: absolute; right: 0px" size="20"
                        >mdi-chevron-down-circle-outline</v-icon
                      >
                      <!-- <i class="fas fa-chevron-circle-down" style="position: absolute; right: 0px;"></i> -->
                    </v-btn>

                    <v-btn
                      v-else
                      class="select_credits"
                      depressed
                      tile
                      outlined
                      v-on="on"
                    >
                      <span style="color: #131220; font-weight: 600; font-size: 12px">{{ currency }}{{ credits.value }}</span>
                      <!-- <v-icon right>keyboard_arrow_down</v-icon> -->
                      <v-icon style="position: absolute; right: 0px" size="20"
                        >mdi-chevron-down-circle-outline</v-icon
                      >
                      <!-- <i class="fas fa-chevron-circle-down" style="position: absolute; right: 0px;"></i> -->
                    </v-btn>
                  </template>

                  <v-list style="padding: 0">
                    <v-list-item
                      v-for="(item, index) in credits_amount"
                      :key="index"
                      @click="f_get_cards()"
                    >
                      <v-list-item-title
                        style="text-align: center; height: 48px; padding: 15px"
                        @click="credits = item"
                      >
                        <!-- <v-btn x-small class="credit_icon ml-4 text--white" style="margin-bottom: 4px;">$</v-btn> -->
                        <!-- <span class="pr-3"
                        style="font-weight: 600; font-size:12px">{{currency}}{{item.value}}</span>-->
                        <!-- <span>|</span> -->
                        <span class="pl-3">{{ item.title }}</span>
                      </v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-menu>
              </div>
              <!--  <v-btn type="button" class="btn btn-primary"
                                   depressed
                                   :class="{color_inactive:credits.value==='Select Credit Amount'}"
                                   @click="f_get_cards"
                                   :loading="loading"
                                   :disabled="loading">Checkout
              </v-btn>-->

              <div v-show="dialog">
                <!-- <v-card-title >Checkout</v-card-title> -->

                <!-- <v-subheader class="text_add_card">Payment Method</v-subheader> -->

                <div class v-show="!dialog_new_card">
                  <v-menu offset-y bottom>
                    <template v-slot:activator="{ on }">
                      <label class="d-block text-left font-weight-normal select-amount"
                        >PAYMENT METHOD{{' '}}<span style="color:red">*</span></label
                      >
                      <v-btn
                        depressed
                        outlined
                        class="btn_select_payment_method pl-0"
                        v-on="on"
                      >
                        <!-- <v-icon left>credit_card</v-icon> -->
                        <!-- <i class="far fa-credit-card mr-2"></i> -->
                        {{ card.title }}
                        <!-- <v-icon right>keyboard_arrow_down</v-icon> -->
                        <v-icon style="position: absolute; right: 0px" size="20"
                          >mdi-chevron-down-circle-outline</v-icon
                        >
                        <!-- <i class="fas fa-angle-down" style="position: absolute; right: 0px;"></i> -->
                      </v-btn>
                    </template>
                    <v-list>
                      <v-list-item
                        style="
                          font-weight: 600;
                          font-size: 13px;
                          color: #3d3c3c;
                        "
                        v-for="(item, index) in cards"
                        :key="index"
                      >
                        <!-- <v-list-item-avatar class="mr-0"> -->
                          <!-- <v-icon>credit_card</v-icon> -->
                          <!-- <i class="far fa-credit-card"></i>
                        </v-list-item-avatar> -->
                        <v-list-item-title @click="f_select_card(item)"><h5 class="card-type">{{
                          item[0]
                        }}</h5></v-list-item-title>
                      </v-list-item>

                      <v-list-item @click="addNewCard()">
                        <v-list-item-title><h5 class="card-type">Add New Card</h5></v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </div>

                <div v-show="dialog_new_card">
                  <div class="form-group my-2 text-left small wordwrap">
                    <span style="color: #000000de; font-size: 11.2px; font-weight: 400">Today's charge is {{ credits.title }} (non-recurring) to
                      www.sexy1on1.com</span>
                  </div>
                  <div
                    class="form-row"
                    style="margin-right: -15px; margin-left: -15px"
                  >
                    <div class="col-md-6 pr-md-2">
                      <label
                        for="first_name"
                        class="text_subtitle_credit"
                        style="float: left"
                        ><h4>First Name{{' '}}<span class="color: #E31616">*</span></h4></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.first_name"
                        class="form-control form-control-style margin-b10"
                        :class="{ invalid: card_error_selected.first_name }"
                        @change="this.f_check_field"
                        id="first_name"
                        placeholder="First Name"
                      />
                    </div>
                    <div class="col-md-6 pl-md-2">
                      <label
                        for="last_name"
                        class="text_subtitle_credit"
                        style="float: left"
                        ><h4>Last Name{{' '}}<span class="color: #E31616">*</span></h4></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.last_name"
                        class="form-control form-control-style margin-b10"
                        :class="{ invalid: card_error_selected.last_name }"
                        @change="this.f_check_field"
                        id="last_name"
                        placeholder="Last Name"
                      />
                    </div>
                  </div>
                  <div
                    class="form-row"
                    style="margin-right: -15px; margin-left: -15px"
                  >
                    <div class="col-md-12">
                      <label
                        for="cc_number"
                        class="text_subtitle_credit"
                        style="float: left"
                        ><h4>Card Number{{' '}}<span class="color: #E31616">*</span></h4></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.cc_number"
                        class="form-control form-control-style margin-b10"
                        :class="{ invalid: card_error_selected.cc_number }"
                        @change="this.f_check_field"
                        @keyup="validateAMEX()"
                        id="cc_number"
                        placeholder="Card Number"
                        v-mask="'#### #### #### ####'"
                      />
                      <span
                        v-if="card_error_selected.cc_number"
                        class="d-flex text-danger h6"
                        >{{ card_error_selected.cc_number[0] }}</span
                      >
                    </div>
                  </div>

                  <div
                    class="form-row"
                    style="margin-right: -15px; margin-left: -15px"
                  >
                    <div class="col-md-6 pr-md-2">
                      <label
                        for="cc_exp"
                        class="text_subtitle_credit"
                        style="float: left"
                        ><h4>EXP{{' '}}<span class="color: #E31616">*</span></h4></label
                      >
                      <input
                        type="text"
                        :maxlength="5" 
                        v-model="card_selected.cc_exp"
                        class="form-control form-control-style margin-b10"
                        :class="{ invalid: card_error_selected.cc_cvv }"
                        @change="this.f_check_field"
                        id="cc_exp"
                        v-mask="'##/##'"
                        placeholder="MM/YY"
                      />
                      <span
                        v-if="card_error_selected.cc_cvv"
                        class="float-left text-danger h6"
                        >{{ card_error_selected.cc_cvv[0] }}</span
                      >
                    </div>
                    <div class="col-md-6 pl-md-2">
                      <label
                        for="cc_cvv"
                        class="text_subtitle_credit"
                        style="float: left"
                        ><h4>CVV{{' '}}<span class="color: #E31616">*</span></h4></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.cc_cvv"
                        class="form-control form-control-style margin-b10"
                        :class="{ invalid: card_error_selected.cc_cvv }"
                        @change="this.f_check_field"
                        id="cc_cvv"
                        placeholder="XXX"
                      />
                      <span
                        v-if="card_error_selected.cc_cvv"
                        class="float-left text-danger h6"
                        >{{ card_error_selected.cc_cvv[0] }}</span
                      >
                    </div>
                  </div>

                  <div>
                    <label
                      for="cc_zip"
                      class="text_subtitle_credit"
                      style="float: left"
                      ><h4>Zip Code{{' '}}<span class="color: #E31616">*</span></h4></label
                    >
                    <input
                      type="text"
                      v-model="card_selected.cc_zip"
                      class="form-control form-control-style margin-b10"
                      id="cc_zip"
                      :class="{ invalid: card_error_selected.cc_zip }"
                      @change="this.f_check_field"
                      placeholder="XXXXX"
                    />
                    <span
                      v-if="card_error_selected.cc_zip"
                      class="float-left text-danger h6"
                      >{{ card_error_selected.cc_zip[0] }}</span
                    >
                  </div>
                </div>
                <div class="form-group" style="margin-top: 10px" v-show="dialog_new_card">
                  <div class="col-12 text-left px-0 mt-2 mb-4">
                    <h5 class="small wordwrap" style="font-size: 10px; color: #131220"
                      >By tapping *COMPLETE PURCHASE* you agree to our
                      <br v-if="$vuetify.breakpoint.xsOnly" /><a
                        href="/terms"
                        target="__blank"
                        style="color: #9759FF!important"
                        >Terms & Conditions</a
                      >. Charges will appear on your credit card statement as
                      1on1.com
                    </h5>
                  </div>
                  <div class="col-12 text-center px-0" style="color: #131220; font-size: 13px; font-weight: 600">
                    Total: ${{ credits.value }}</div>
                </div>
                <div class="form-group" style="margin: 26px 0 20px">
                  <v-btn
                    type="submit"
                    class="complete-purchase"
                    style="color: #fff !important"
                    depressed
                    rounded
                    v-bind:class="
                      !card.value && !dialog_new_card ? 'color_inactive' : ''
                    "
                    @click="f_pay_credits"
                    :disabled="loading"
                    :loading="loading"
                    >Complete</v-btn
                  >
                </div>
                <div class="form-group text-left" style="margin-bottom: 30px" v-show="dialog_new_card">
                  <img
                    width="50"
                    src="/images/payment/vs-image.jpg"
                    class="mr-1"
                  />
                  <img
                    width="50"
                    src="/images/payment/mc-image.jpg"
                    class="mr-1"
                  />
                  <img
                    width="50"
                    src="/images/payment/dc-image.jpg"
                    class="mr-1"
                  />
                  <img
                    width="50"
                    src="/images/payment/jc-image.jpg"
                    class="mr-1"
                  />
                  <img
                    width="50"
                    src="/images/payment/ma-image.jpg"
                    class="mr-1"
                  />
                </div>
              </div>
            </form>
          </v-list-item-title>
        </v-list-item>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog_subscription" max-width="350px">
      <v-card height="100%">
        <v-list-item style="background-color: #fff">
          <v-list-item-title>
            <form class="py-3 payment_form">
              <div v-if="Object.keys(model).length !== 0">
                <v-icon
                  color="#A1A0A6"
                  v-if="dialog_new_card_subscription === true"
                  class="d-block text-left"
                  style="position: fixed"
                  @click="dialog_new_card_subscription = false"
                  >mdi-arrow-left</v-icon
                >
                <v-btn
                  icon
                  light
                  @click="dialog_subscription = false"
                  style="position: absolute; right: 0px; top: 0px"
                >
                  <v-icon color="#A1A0A6" size="25">mdi-window-close</v-icon>
                </v-btn>

                <div
                  class="row m-0 py-3"
                  v-show="!dialog_new_card_subscription"
                >
                  <div
                    class="col-12 text-center mt-5"
                    style="font-size: 18px; color: #131220; font-weight: 600"
                  >
                    Join VIP Club
                  </div>
                  <div class="col-12 text-center">
                    <div
                      class="user_avatar_list"
                      :style="{
                        'background-image':
                          'url(' + model.profile.profile_headshot_url + ')',
                      }"
                    ></div>
                    <div class="subtitle-1">
                      {{ model.profile.display_name }}
                    </div>
                  </div>

                  <div class="col-12 mt-5">
                    <div
                      style="color: #949498; font-size: 11px; font-weight: 600"
                      class="text-center"
                    >
                      Subscription Benefits
                    </div>

                    <div
                      class="text-left mt-4"
                      style="
                        font-family: Montserrat;
                        font-size: 14px;
                        font-weight: 500;
                        color: #1f1e34;
                      "
                    >
                      <i class="fas fa-check mr-4" style="color: #f77f98"></i
                      >Gain full access to premium content
                    </div>

                    <div
                      class="text-left mt-3"
                      style="
                        font-family: Montserrat;
                        font-size: 14px;
                        font-weight: 500;
                      "
                    >
                      <i class="fas fa-check mr-4" style="color: #f77f98"></i
                      >Receive exclusive DM’s
                    </div>

                    <div
                      class="text-left mt-3"
                      style="
                        font-family: Montserrat;
                        font-size: 14px;
                        font-weight: 500;
                      "
                    >
                      <i class="fas fa-check mr-4" style="color: #f77f98"></i
                      >Cancel at any time
                    </div>
                  </div>

                  <div class="col-12 text-left mt-5">
                    <span
                      style="
                        color: #131220;
                        font-size: 12px;
                        font-weight: 600;
                        margin-left: 30px;
                      "
                    >
                      {{ currency }}{{ subscription.price }} per month
                    </span>
                  </div>
                  <div class="col-12 text-left mt-3">
                    <div
                      style="
                        color: #131220;
                        font-size: 12px;
                        font-weight: 500;
                        margin-left: 30px;
                      "
                    >
                      Your next monthly charge will occur on
                      <br />
                      {{ next_renew_subscription }}
                    </div>
                  </div>
                </div>
              </div>
              <div>
                <div v-if="!dialog_new_card_subscription">
                  <div
                    class="text-center mt-3"
                    style="color: #131220; font-size: 18px; font-weight: 600"
                  >
                    Payment Method
                  </div>

                  <div class="d-flex justify-center mb-4 mt-5">
                    <img
                      width="35"
                      src="/images/payment/vs-image.jpg"
                      class="mr-1"
                    />
                    <img
                      width="35"
                      src="/images/payment/mc-image.jpg"
                      class="mr-1"
                    />
                    <img
                      width="35"
                      src="/images/payment/dc-image.jpg"
                      class="mr-1"
                    />
                    <img
                      width="35"
                      src="/images/payment/jc-image.jpg"
                      class="mr-1"
                    />
                    <img
                      width="35"
                      src="/images/payment/ma-image.jpg"
                      class="mr-1"
                    />
                  </div>

                  <div class v-show="!dialog_new_card_subscription">
                    <v-menu offset-y bottom>
                      <template v-slot:activator="{ on }">
                        <v-btn
                          depressed
                          outlined
                          class="btn_select_payment_method"
                          v-on="on"
                        >
                          <!-- <v-icon left>credit_card</v-icon> -->
                          <span
                            style="
                              color: #131220;
                              opacity: 0.5;
                              font-weight: 500;
                            "
                            >{{ card.title }}</span
                          >
                          <v-icon
                            style="position: absolute; right: 0px"
                            size="45"
                            >mdi-menu-down</v-icon
                          >
                        </v-btn>
                      </template>
                      <v-list>
                        <v-list-item
                          style="font-weight: 600"
                          v-for="(item, index) in cards"
                          :key="index"
                          @click
                        >
                          <!-- <v-list-item-avatar class="mr-0"> -->
                          <!-- <v-icon>credit_card</v-icon> -->
                          <!-- </v-list-item-avatar> -->
                          <v-list-item-title
                            class="my-4"
                            @click="f_select_card(item)"
                            >{{ item[0] }}</v-list-item-title
                          >
                        </v-list-item>

                        <v-list-item @click="addNewCardSubscription()">
                          <v-list-item-title>Add New Card</v-list-item-title>
                        </v-list-item>
                      </v-list>
                    </v-menu>
                  </div>
                </div>

                <div class="text-left" v-else>
                  <div
                    class="text-center mt-5"
                    style="color: #131220; font-size: 18px; font-weight: 600"
                  >
                    Payment Information
                  </div>

                  <div class="form-row mt-5">
                    <div class="form-group col-md-6 pr-md-2">
                      <label for="first_name"
                        >First Name <span style="color: #e31616">*</span></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.first_name"
                        class="form-control"
                        :class="{ invalid: card_error_selected.first_name }"
                        @change="this.f_check_field"
                        id="first_name"
                      />
                    </div>
                    <div class="form-group col-md-6 pl-md-2">
                      <label for="last_name" style="float: left"
                        >Last Name <span style="color: #e31616">*</span></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.last_name"
                        class="form-control"
                        :class="{ invalid: card_error_selected.last_name }"
                        @change="this.f_check_field"
                        id="last_name"
                      />
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-12">
                      <label for="cc_number" style="float: left"
                        >Card Number
                        <span style="color: #e31616">*</span></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.cc_number"
                        class="form-control"
                        :class="{ invalid: card_error_selected.cc_number }"
                        @change="this.f_check_field"
                        @keyup="validateAMEX()"
                        id="cc_number"
                        v-mask="'#### #### #### #### #### ####'"
                      />

                      <span
                        v-if="card_error_selected.cc_number"
                        class="d-flex text-danger h6"
                        >{{ card_error_selected.cc_number[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-6 pr-md-2">
                      <label>EXP <span style="color: #e31616">*</span></label>
                      <input
                        type="text"
                        v-model="card_selected.cc_exp"
                        class="form-control"
                        :class="{ invalid: card_error_selected.first_name }"
                        v-mask="'##/##'"
                      />
                    </div>

                    <div class="form-group col-md-6 pl-md-2">
                      <label
                        for="cc_cvv"
                        class="text_subtitle_credit"
                        style="float: left"
                        >CCV <span style="color: #e31616">*</span></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.cc_cvv"
                        class="form-control"
                        :class="{ invalid: card_error_selected.cc_cvv }"
                        @change="this.f_check_field"
                        v-mask="'###'"
                      />
                      <span
                        v-if="card_error_selected.cc_cvv"
                        class="float-left text-danger h6"
                        >{{ card_error_selected.cc_cvv[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col-12">
                      <label
                        for="cc_zip"
                        class="text_subtitle_credit"
                        style="float: left"
                        >Zip Code <span style="color: #e31616">*</span></label
                      >
                      <input
                        type="text"
                        v-model="card_selected.cc_zip"
                        class="form-control"
                        id="cc_zip"
                        :class="{ invalid: card_error_selected.cc_zip }"
                        @change="this.f_check_field"
                      />
                    </div>
                  </div>
                </div>

                <div class="form-row mt-2">
                  <div class="form-group col-12">
                    <div class="col-12 text-left px-0">
                      <span
                        class="small wordwrap"
                        style="
                          font-size: 12px;
                          color: #131220;
                          font-weight: 500;
                        "
                        >By tapping *COMPLETE PURCHASE* you agree to our <a
                          href="/terms"
                          target="__blank"
                          >Terms & Conditions</a
                        >. Charges will appear on your credit card statement as 1on1.com</span>
                    </div>
                  </div>
                </div>

                <div
                  class="col-12 text-center mb-5"
                  v-if="dialog_new_card_subscription"
                >
                  <span
                    style="color: #131220; font-size: 13px; font-weight: 600"
                  >
                    Total: {{ currency }}{{ subscription.price }} / month
                  </span>
                </div>

                <div class="form-group">
                  <div class="text-center mb-2">
                    <v-btn
                      class="btn-custom"
                      style="
                        color: #ffffff !important;
                        border-radius: 12px !important;
                      "
                      depressed
                      v-bind:class="
                        !card.value && !dialog_new_card_subscription
                          ? 'color_inactive'
                          : ''
                      "
                      @click="f_subscribe"
                      :disabled="loading"
                      :loading="loading"
                      width="155"
                    >
                      <span style="font-size: 12px; font-weight: 600">{{
                        !dialog_new_card_subscription ? "Confirm" : "Complete"
                      }}</span></v-btn
                    >
                  </div>
                </div>

                <div class="row mt-3" v-if="dialog_new_card_subscription">
                  <div class="col-12">
                    <div class="d-flex justify-center mb-4">
                      <img
                        width="35"
                        src="/images/payment/vs-image.jpg"
                        class="mr-1"
                      />
                      <img
                        width="35"
                        src="/images/payment/mc-image.jpg"
                        class="mr-1"
                      />
                      <img
                        width="35"
                        src="/images/payment/dc-image.jpg"
                        class="mr-1"
                      />
                      <img
                        width="35"
                        src="/images/payment/jc-image.jpg"
                        class="mr-1"
                      />
                      <img
                        width="35"
                        src="/images/payment/ma-image.jpg"
                        class="mr-1"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </v-list-item-title>
        </v-list-item>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogTipModel" max-width="350px">
      <v-card height="100%">
        <div class="text-right mb-2">
          <v-btn icon light @click="dialogTipModel = false" class="right">
            <i class="fas fa-times"></i>
          </v-btn>
        </div>
        <div style="background-color: #fff" class="py-5">
          <form class="tip-modal">
            <div class="form-group px-4" v-if="Object.keys(model).length !== 0">
              <div class="row m-0">
                <div v-if="!sentTip" style="font-size:18px;font-weight:600;" class="col-12 h4 black--text text-center pb-3">
                  Tip Me
                </div>
                <div class="col-12 text-center">
            <v-row>
                    <v-col align="center" justify="center">
                  <div
                    class="profile_avatar"
                    style="background-size:contain;"
                    :style="{
                      'background-image':
                        'url(' + model.profile.profile_headshot_url + ')',
                    }"
                  ></div>
                      </v-col>
                  </v-row>
                  <div v-if="!sentTip" class="subtitle-1">
                    <b
                      style="
                        color: #1f1e34;
                        font-family: 'Montserrat', sans-serif !important;
                        font-weight: 600;
                      "
                      >{{ model.profile.display_name }}</b
                    >
                  </div>
                </div>
              </div>
            </div>

            <div v-if="!sentTip">             
             <v-row align="center" justify="center">
              <v-col cols="5">
               <div class="my-tip-input pt-2 pb-6">
               <v-text-field               
                  class="centered-input"  
                  height:="49px"
                  width:="180px"
                  v-model="tip"
                  prefix="$"
                  type="number"
                  id="tipammount"
                  suffix=""
                  style="color:#0F0F0F;padding-left:10px !important;padding-right:10px !important;font-size:40px;font-weight:500;max-height: 49px !important;text-align:center;"
                >
                </v-text-field>
                </div>
              </v-col>
              </v-row>
              <div class="text-center mb-2 px-4 py-4">
                <v-btn
                  class="primary"
                  style="color: #fff !important;width:175px;height:40px;border-radius:12px;"
                  depressed
                  rounded
                  @click="sendTip"
                  :disabled="loading"
                  :loading="loading"
                  >Send Tip</v-btn
                >
              </div>
            </div>
            <div v-else>
              <p
                class="title px-4 text-center"
                style="
                  color: #1f1e34;
                  font-family: 'Montserrat', sans-serif !important;
                  font-weight: 500;
                "
              >
                Thank you for the tip!
              </p>

              <div class="text-center my-5 px-4">
                <v-btn
                  class="primary"
                  style="color: #fff !important;width:80px;height:40px;border-radius:12px;"
                  depressed
                  rounded
                  @click="dialogTipModel = false"
                  >Done</v-btn
                >
              </div>
            </div>
          </form>
          <!-- </v-list-item-title> -->
        </div>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="tripping_modal_not_e_credits"
      width="420px"
      :fullscreen="$vuetify.breakpoint.xsOnly"
    >
      <v-card color="#fff">
        <v-card-text style="padding: 15px 20px">
          <div class="text-right mb-2">
            <v-btn
              icon
              light
              @click="tripping_modal_not_e_credits = false"
              class="right"
            >
              <i class="fas fa-times"></i>
            </v-btn>
          </div>

          <div class="text-danger text-center my-3">
            <v-subheader
              class="mb-7"
              style="display: block"
              v-if="model.profile"
              >You do not have enough credits to tip
              {{ model.profile.display_name }}</v-subheader
            >

            <v-btn
              class="primary"
              style="color: #fff !important"
              depressed
              rounded
              @click="add_credits()"
              >Reload Wallet</v-btn
            >
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="g_modal" width="320px">
      <v-card color="#fff">
        <v-card-text style="padding: 15px 20px">
          <div
            class="text-left mb-2"
            style="
              font-family: Montserrat;
              font-size: 18px;
              font-weight: 600;
              color: #1f1e34;
            "
          >
            Guarantee Terms
            <v-icon
              class="float-right"
              style="position: absolute; right: 15px; top: 0"
              @click="g_modal = false"
              >mdi-close</v-icon
            >
          </div>
          <div class="text-left mb-2 small">
            If your chat message is not responded to within 8hrs, the funds for
            those messages will automatically be credited back to your account.
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogSnapchat" max-width="400px">
      <v-card height="100%">
        <v-list-item style="background-color: #fff">
          <form class="px-3 py-3 payment_form">
            <div v-if="Object.keys(model).length !== 0">
              <v-icon
                v-if="
                  !snapchatSubscribed &&
                  !snapchat_username &&
                  !dialog_new_card_subscription
                "
                class="d-block text-left"
                style="position: fixed; margin-left: -20px"
                @click="snapchat_username = true"
                >mdi-arrow-left</v-icon
              >
              <v-icon
                v-if="
                  !snapchatSubscribed && dialog_new_card_subscription === true
                "
                class="d-block text-left"
                style="position: fixed; margin-left: -20px"
                @click="dialog_new_card_subscription = false"
                >mdi-arrow-left</v-icon
              >
              <v-btn
                icon
                light
                @click="dialogSnapchat = false"
                style="position: absolute; right: 0px; top: 0px"
              >
                <i class="fas fa-times"></i>
              </v-btn>
              <div class="row m-0 py-3" v-show="!dialog_new_card_subscription">
                <div
                  v-if="!snapchatSubscribed"
                  class="col-12 h4 black--text text-center mt-5"
                >
                  Snapchat Subscription
                </div>
                <div class="col-12 text-center">
                  <div
                    class="profile_avatar"
                    :style="{
                      'background-image':
                        'url(' + model.profile.profile_headshot_url + ')',
                      overflow: 'visible',
                      width: '80px',
                      height: '80px',
                    }"
                  >
                    <img src="/images/icons/snapchat.svg" class="float-right" />
                  </div>
                  <div v-if="!snapchatSubscribed" class="subtitle-1">
                    <b
                      style="
                        color: #1f1e34;
                        font-family: 'Montserrat', sans-serif !important;
                        font-weight: 500;
                      "
                      >{{ model.profile.display_name }}</b
                    >
                  </div>
                </div>

                <div v-if="!snapchatSubscribed" class="col-12 pl-0 mt-1">
                  <div
                    style="color: rgba(16, 18, 21, 0.25)"
                    class="text-center"
                  >
                    Subscription Benefits
                  </div>

                  <div
                    class="text-left mt-3"
                    style="
                      font-family: Montserrat;
                      font-size: 14px;
                      font-weight: 500;
                      color: #1f1e34;
                    "
                  >
                    <i class="fas fa-check mr-2" style="color: #f77f98"></i
                    >You’ll be added to her premium Snapchat
                  </div>

                  <div
                    class="text-left mt-3"
                    style="
                      font-family: Montserrat;
                      font-size: 14px;
                      font-weight: 500;
                      color: #1f1e34;
                    "
                  >
                    <i class="fas fa-check mr-2" style="color: #f77f98"></i
                    >Cancel at any time
                  </div>
                </div>

                <div
                  v-if="!snapchatSubscribed"
                  class="col-12 text-left mt-8 px-0"
                >
                  <span>
                    <b
                      style="
                        color: #1f1e34;
                        font-family: 'Montserrat', sans-serif !important;
                        font-weight: 500;
                      "
                      >{{ currency }}{{ subscription.price }} per month</b
                    >
                  </span>
                </div>
                <div
                  v-if="!snapchatSubscribed"
                  class="col-12 text-left px-0 mt-2"
                >
                  <div class="grey--text small">
                    Your next monthly charge will occur on
                    <br />
                    {{ next_renew_subscription }}
                  </div>
                </div>
              </div>
            </div>

            <div v-if="snapchat_username && !snapchatSubscribed">
              <div class="row mx-0">
                <div class="col-12 px-0">
                  <div class="form-group w-100">
                    <p
                      class="mb-3"
                      style="
                        color: #1f1e34;
                        font-size: 12px;
                        font-weight: 600;
                        text-align: left;
                      "
                    >
                      Your Snapchat Username
                    </p>
                    <input
                      type="text"
                      v-model="snapchat.username"
                      class="form-control"
                    />
                  </div>

                  <div class="form-group w-100">
                    <p
                      class="mb-3 mt-5"
                      style="
                        color: #1f1e34;
                        font-size: 12px;
                        font-weight: 600;
                        text-align: left;
                      "
                    >
                      Confirm Snapchat Username
                    </p>
                    <input
                      type="text"
                      v-model="snapchat.username2"
                      class="form-control"
                    />
                  </div>
                </div>
              </div>

              <div class="row mx-0" v-if="snapchat_username_error">
                <div
                  class="col-12 px-0"
                  style="text-align: left; font-size: 12px; color: #b71c1c"
                >
                  {{ snapchat_username_error }}
                </div>
              </div>

              <div class="text-center mb-2 px-4">
                <v-btn
                  class="primary"
                  style="color: #fff !important"
                  depressed
                  rounded
                  @click="nextSnapchatSubscribe(2)"
                  >Next</v-btn
                >
              </div>
            </div>

            <div v-if="!snapchat_username && !snapchatSubscribed">
              <v-subheader
                v-show="!dialog_new_card_subscription"
                class="text_add_card"
                >PAYMENT METHOD</v-subheader
              >

              <div class v-show="!dialog_new_card_subscription">
                <v-menu offset-y bottom>
                  <template v-slot:activator="{ on }">
                    <v-btn
                      depressed
                      outlined
                      class="btn_select_payment_method"
                      v-on="on"
                    >
                      <v-icon left>credit_card</v-icon>
                      {{ card.title }}
                      <v-icon style="position: absolute; right: 0px" size="20"
                        >mdi-chevron-down-circle-outline</v-icon
                      >
                    </v-btn>
                  </template>
                  <v-list>
                    <v-list-item
                      style="font-weight: 600"
                      v-for="(item, index) in cards"
                      :key="index"
                    >
                      <v-list-item-avatar class="mr-0">
                        <v-icon>credit_card</v-icon>
                      </v-list-item-avatar>
                      <v-list-item-title @click="f_select_card(item)">{{
                        item[0]
                      }}</v-list-item-title>
                    </v-list-item>

                    <v-list-item @click="addNewCardSubscription()">
                      <v-list-item-title>Add New Card</v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-menu>
              </div>

              <div v-show="dialog_new_card_subscription">
                <div class="form-group pt-2 mt-10 text-left small wordwrap">
                  <span
                    >Today's charge is {{ currency
                    }}{{ subscription.price }} (reoccuring) to
                    www.sexy1on1.com</span
                  >
                </div>

                <div class="form-group pt-2 text-left mb-7">
                  <img
                    width="50"
                    src="/images/payment/vs-image.jpg"
                    class="mr-1"
                  />
                  <img
                    width="50"
                    src="/images/payment/mc-image.jpg"
                    class="mr-1"
                  />
                  <img
                    width="50"
                    src="/images/payment/dc-image.jpg"
                    class="mr-1"
                  />
                  <img
                    width="50"
                    src="/images/payment/jc-image.jpg"
                    class="mr-1"
                  />
                  <img
                    width="50"
                    src="/images/payment/ma-image.jpg"
                    class="mr-1"
                  />
                </div>

                <div
                  class="form-row"
                  style="margin-right: -15px; margin-left: -15px"
                >
                  <div class="form-group col-md-6 pr-md-2">
                    <label
                      for="first_name"
                      class="text_subtitle_credit"
                      style="float: left"
                      >First Name</label
                    >
                    <input
                      type="text"
                      v-model="card_selected.first_name"
                      class="form-control"
                      :class="{ invalid: card_error_selected.first_name }"
                      @change="this.f_check_field"
                      id="first_name"
                      placeholder="First Name"
                    />
                  </div>
                  <div class="form-group col-md-6 pl-md-2">
                    <label
                      for="last_name"
                      class="text_subtitle_credit"
                      style="float: left"
                      >Last Name</label
                    >
                    <input
                      type="text"
                      v-model="card_selected.last_name"
                      class="form-control"
                      :class="{ invalid: card_error_selected.last_name }"
                      @change="this.f_check_field"
                      id="last_name"
                      placeholder="Last Name"
                    />
                  </div>
                </div>
                <div
                  class="form-row"
                  style="margin-right: -15px; margin-left: -15px"
                >
                  <div class="form-group col-md-8 pr-md-2">
                    <label
                      for="cc_number"
                      class="text_subtitle_credit"
                      style="float: left"
                      >Card Number</label
                    >
                    <input
                      type="text"
                      v-model="card_selected.cc_number"
                      class="form-control"
                      :class="{ invalid: card_error_selected.cc_number }"
                      @change="this.f_check_field"
                      @keyup="validateAMEX()"
                      id="cc_number"
                      placeholder="Card Number"
                      v-mask="'#### #### #### #### #### ####'"
                    />

                    <span
                      v-if="card_error_selected.cc_number"
                      class="d-flex text-danger h6"
                      >{{ card_error_selected.cc_number[0] }}</span
                    >
                  </div>

                  <div class="form-group col-md-4 pl-md-2">
                    <label
                      for="cc_cvv"
                      class="text_subtitle_credit"
                      style="float: left"
                      >CVV2/CVC2</label
                    >
                    <input
                      type="text"
                      v-model="card_selected.cc_cvv"
                      class="form-control"
                      :class="{ invalid: card_error_selected.cc_cvv }"
                      @change="this.f_check_field"
                      id="cc_cvv"
                      placeholder="XXX"
                    />
                    <span
                      v-if="card_error_selected.cc_cvv"
                      class="float-left text-danger h6"
                      >{{ card_error_selected.cc_cvv[0] }}</span
                    >
                  </div>
                </div>

                <div
                  class="form-row"
                  style="margin-right: -15px; margin-left: -15px"
                >
                  <div class="form-group col-12 mb-0">
                    <label class="text_subtitle_credit" style="float: left"
                      >Expiration</label
                    >
                  </div>
                  <div class="form-group col-md-8 pr-md-2">
                    <v-select
                      :id="'cc_exp_month'"
                      :items="months"
                      v-model="card_selected.cc_exp_month"
                      class="form-control"
                      flat
                      full-width
                      item-text="text"
                      item-value="value"
                      outlined
                      dense
                      :class="{ invalid: card_error_selected.cc_exp_month }"
                    ></v-select>
                    <span
                      v-if="card_error_selected.cc_exp_month"
                      class="float-left text-danger h6"
                      >{{ card_error_selected.cc_exp_month[0] }}</span
                    >
                  </div>
                  <div class="form-group col-md-4 pl-md-2">
                    <v-select
                      :id="'cc_exp_year'"
                      :items="years"
                      item-text="text"
                      item-value="value"
                      class="form-control"
                      v-model="card_selected.cc_exp_year"
                      flat
                      full-width
                      outlined
                      dense
                      :class="{ invalid: card_error_selected.cc_exp_year }"
                    ></v-select>
                    <span
                      v-if="card_error_selected.cc_exp_year"
                      class="float-left text-danger h6"
                      >{{ card_error_selected.cc_exp_year[0] }}</span
                    >
                  </div>
                </div>

                <div class="form-group">
                  <label
                    for="cc_zip"
                    class="text_subtitle_credit"
                    style="float: left"
                    >ZIP/Postal Code</label
                  >
                  <input
                    type="text"
                    v-model="card_selected.cc_zip"
                    class="form-control"
                    id="cc_zip"
                    :class="{ invalid: card_error_selected.cc_zip }"
                    @change="this.f_check_field"
                    placeholder="XXXXX"
                  />
                </div>
              </div>
              <!-- <v-divider></v-divider> -->
              <div class="form-group">
                <div class="col-12 text-left px-0 mt-2">
                  <span class="small wordwrap" style="font-size: 10px"
                    >By tapping *COMPLETE PURCHASE* you agree to our
                    <br v-if="$vuetify.breakpoint.xsOnly" /><a
                      href="/terms"
                      target="__blank"
                      >Terms & Conditions</a
                    >. Charges will appear on your credit card statement as
                    1on1.com</span
                  >
                </div>
              </div>
              <div class="form-group">
                <div class="text-center mb-2">
                  <v-btn
                    class="primary"
                    style="color: #fff !important"
                    depressed
                    rounded
                    v-bind:class="
                      !card.value && !dialog_new_card_subscription
                        ? 'color_inactive'
                        : ''
                    "
                    @click="f_subscribe"
                    :disabled="loading"
                    :loading="loading"
                    >Complete</v-btn
                  >
                </div>
              </div>
            </div>

            <div v-if="snapchatSubscribed">
              <div class="px-0 wordwrap" style="color: #1f1e34">
                <p
                  style="font-size: 18px; margin-bottom: 0px; font-weight: 600"
                >
                  You are now subscribed to {{ model.profile.display_name }}’s
                  premium Snapchat.
                </p>
                <p style="font-size: 12px; font-weight: 500">
                  Please wait for 24 - 48 hours for the model to add you to her
                  premium Snapchat.
                </p>
              </div>
            </div>
          </form>
        </v-list-item>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog_message" max-width="350px">
      <v-card height="100%" class="px-3">
        <v-btn
          icon
          light
          @click="dialog_message = false"
          style="position: absolute; right: 5px; top: 5px"
        >
          <v-icon color="#A1A0A6" size="25">mdi-window-close</v-icon>
        </v-btn>
        <div class="row m-0 py-3">
          <div
            class="col-12 text-center mt-10"
            style="font-size: 18px; color: #131220; font-weight: 600"
          >
            Thank You For Your Purchase
          </div>
          <div class="col-12 mt-3">
            <div
              style="color: #131220; font-size: 14px; font-weight: 500"
              class="text-center"
            >
              You have purchased to join VIP Club. Records of your
              purchases are in the Transactions tab of your dashboard.
              Recordings are in your Replays tab.
            </div>
          </div>
          <div class="col-12 my-5 text-center">
            <v-btn
              class="btn-custom"
              style="color: #ffffff !important; border-radius: 12px !important"
              depressed
              width="155"
              @click="dialog_message = false"
            >
              <span style="font-size: 12px; font-weight: 600">Ok</span></v-btn
            >
          </div>
        </div>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
function getData() {
  return {
    g_modal: false,
    mask: "####-####-####-####",
    value: "",
    message: "",
    message_title: "",
    next_renew_subscription: moment(moment().add(1, "month")).format(
      "MM-DD-YYYY"
    ),
    loading: false,
    dialog: false,
    dialog_new_card: false,
    dialog_new_card_subscription: false,
    dialog_select_credit: false,
    dialog_subscription: false,
    dialog_message: false,
    credits: {
      title: "Select Amount",
      value: "Select Amount",
    },
    months: [
      { text: "January", value: "01" },
      { text: "February", value: "02" },
      { text: "March", value: "03" },
      { text: "April", value: "04" },
      { text: "May", value: "05" },
      { text: "June", value: "06" },
      { text: "July", value: "07" },
      { text: "August", value: "08" },
      { text: "September", value: "09" },
      { text: "October", value: "10" },
      { text: "November", value: "11" },
      { text: "December", value: "12" },
    ],
    years: [
      { text: "2019", value: "19" },
      { text: "2020", value: "20" },
      { text: "2021", value: "21" },
      { text: "2022", value: "22" },
      { text: "2023", value: "23" },
      { text: "2024", value: "24" },
      { text: "2025", value: "25" },
      { text: "2026", value: "26" },
      { text: "2027", value: "27" },
      { text: "2028", value: "28" },
      { text: "2029", value: "29" },
    ],
    credits_amount: [
      { value: 20, title: "$20" },
      { value: 35, title: "$35" },
      { value: 50, title: "$50" },
      { value: 75, title: "$75" },
      { value: 100, title: "$100" },
      { value: 250, title: "$250" },
      { value: 500, title: "$500" },
      { value: 750, title: "$750" },
      { value: 1000, title: "$1000" },
    ],
    card: {
      title: "Select Payment Option",
      value: false,
    },
    card_error: {
      title: false,
      value: false,
      credits: false,
    },
    card_selected: {
      last_four: null,
      type: null,
      first_name: null,
      last_name: null,
      cc_number: null,
      cc_exp: null,
      cc_cvv: null,
      cc_zip: null,
    },
    card_error_selected: {
      last_four: null,
      type: null,
      first_name: null,
      last_name: null,
      cc_number: null,
      cc_exp: null,
      cc_cvv: null,
      cc_zip: null,
    },
    cards: {},
    model: {},
    subscription: {},
    source: "",
    user_credits: this.user.credits,
    mdefault: false,
    arenew: false,
    currency: "$",

    dialogTipModel: false,
    tip: 10,
    sentTip: false,
    notipError: true,
    tipErrorMsg: "The maximum tip amount is $200",

    tripping_modal_not_e_credits: false,

    dialogSnapchat: false,
    snapchat: {},
    snapchatError: false,
    snapchatPaid: false,
    snapchatStep: 1,
    snapchat_username: true,
    snapchat_username_error: false,
    snapchatSubscribed: false,
  };
}
import moment from "moment";
import { mapGetters } from "vuex";
import Vue from "vue";
import { mask } from "vue-the-mask";
export default {
  directives: { mask },
  name: "credits",
  props: ["user", "color"],
  data: getData,
  watch: {
    dialog_select_credit: function (newVal, oldVal) {
      if (!newVal) {
        //this.f_reset_data();
      }
    },

    dialogTipModel(val) {
      if (!val) {
        this.tip = null;
        this.sentTip = false;
      }
    },
    dialogSnapchat(val) {
      this.card = {
        title: "Select Payment Option",
        value: false,
      };
      this.dialog_new_card_subscription = false;
      this.snapchat = {};
    },
  },
  mounted() {
    this.$root.$on("open_credits_too", () => {
      this.dialog_select_credit = true;
    });
    this.$root.$on("chat_subtract_credits-" + this.user.id, (data) => {
      this.f_remove_credits_user_text_message(data.user.credits);
    });
    this.$root.$on(
      "chat_subtract_from_model_credits-" + this.user.id,
      (data) => {
        this.f_remove_credits_user_text_message(data.user_receiver_credits);
      }
    );
    EventBus.$on("open-credits", () => {
      this.dialog_select_credit = true;
    });
 
    EventBus.$on("open-subscription", (payload) =>
      {this.openSubscription(payload)}
    );

    EventBus.$on("update_credits", () => {
      this.updateCredits();
    });

    EventBus.$on("open-send-tip", (payload) => this.openSendTip(payload));

    EventBus.$on("open-snapchat", (payload) => this.openSnapchat(payload));
  },


  methods: {
    validateAMEX() {
      const text = this.card_selected.cc_number.trim().substring(0, 2);
      if (text == 37 || text == 34) {
        //this.card_selected.cc_number = "";
        this.card_error_selected.cc_number = ["American Express not accepted"];
      } else {
        this.card_error_selected.cc_number = null;
      }
    },
    addNewCard() {
      this.reset_card();
      this.dialog_new_card = true;
    },
    addNewCardSubscription() {
      this.reset_card();
      this.dialog_new_card_subscription = true;
    },
    updateCredits() {
      this.loading = true;
      axios
        .get("/api/v1/user/get/credits", {
          id: this.user.id,
        })
        .then((response) => {
          this.f_remove_credits_user_text_message(response.data.credits);
        })
        .catch((error) => {
          this.loading = false;
          if (error.response.status == 422) {
            this.card_error_selected = error.response.data.errors;
          } else {
            if (error.response.status === 400) {
              this.message = error.response.data.message;
            } else {
              this.message =
                "Transaction declined. " + error.response.data.message;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
          }
        });
    },
    reset_card() {
      this.card_error = {
        title: false,
        value: false,
        credits: false,
      };
      this.card_selected = {
        last_four: null,
        type: null,
        first_name: null,
        last_name: null,
        cc_number: null,
        cc_exp: null,
        cc_cvv: null,
        cc_zip: null,
      };
      this.card_error_selected = {
        last_four: null,
        type: null,
        first_name: null,
        last_name: null,
        cc_number: null,
        cc_exp: null,
        cc_cvv: null,
        cc_zip: null,
      };
    },
    f_check_field(e) {
      switch (e.currentTarget.id) {
        case "first_name":
          this.card_error_selected.first_name = !this.card_selected.first_name;
          break;
        case "last_name":
          this.card_error_selected.last_name = !this.card_selected.last_name;
          break;
        case "cc_number":
          this.card_error_selected.cc_number = !this.card_selected.cc_number;
          break;
        case "cc_exp":
          this.card_error_selected.cc_exp = !this.card_selected.cc_exp;
          break;
        case "cc_cvv":
          this.card_error_selected.cc_cvv = !this.card_selected.cc_cvv;
          break;
        case "cc_zip":
          this.card_error_selected.cc_zip = !this.card_selected.cc_zip;
          break;

        default:
      }
    },
    f_reset_data() {
      Object.assign(this.$data, this.$options.data.call(this));
    },

    f_remove_credits_from_user() {
      var credits = this.user.credits - this.subscription.price;
      this.user_credits = credits;
      Vue.set(this.user, "credits", credits);
    },

    f_pay_credits() {
      if (this.dialog_new_card) {
        this.f_add_card_and_buy_credits();
      } else {
        this.f_buy_credits();
      }
    },
    f_subscribe() {
      if (this.dialog_new_card_subscription) {
        this.f_add_card_and_subscribe();
      } else {
        this.f_pay_and_subscribe();
      }
    },
    f_validate_form_card() {
      this.card_error_selected.cc_number = !this.card_selected.cc_number;
      /*this.card_error_selected.cc_exp_month = !this.card_selected.cc_exp_month;*/
      this.card_error_selected.cc_exp = !this.card_selected.cc_exp;
      this.card_error_selected.cc_zip = !this.card_selected.cc_zip;
      this.card_error_selected.cc_cvv = !this.card_selected.cc_cvv;
      this.card_error_selected.first_name = !this.card_selected.first_name;
      this.card_error_selected.last_name = !this.card_selected.last_name;

      if (
        !this.card_error_selected.cc_number &&
        !this.card_error_selected.cc_zip &&
        !this.card_error_selected.cc_cvv &&
        !this.card_error_selected.first_name &&
        !this.card_error_selected.last_name
      ) {
        return true;
      }
      return false;
    },
    f_add_card_and_buy_credits() {
      if (this.f_validate_form_card()) {
        this.loading = true;
        axios
          .post("/api/v1/user/account/cardPayment", {
            cc_number: this.card_selected.cc_number.replace(/\s+/g, ""),
            credits: this.credits.value,
            cc_exp: this.card_selected.cc_exp,
            cc_zip: this.card_selected.cc_zip,
            cc_cvv: this.card_selected.cc_cvv,
            first_name: this.card_selected.first_name,
            last_name: this.card_selected.last_name,
          })
          .then((response) => {
            this.loading = false;
            this.f_add_credits_to_user(this.credits.value);
            this.$root.$emit("on_chat_remove_user_no_credit_box", {});
            this.dialog = false;
            this.dialog_select_credit = false;

            if (
              this.source == "subscription" &&
              this.user_credits >= this.subscription.price
            ) {
              this.reset_card();
              this.openSubscriptionFromCredits();
            } else {
              this.message = response.data.msg;

              this.$root.$emit("open_dialog_message", {
                message: this.message,
                message_title: "PURCHASE",
                purchase: response.data.purchase,
              });
            }
          })
          .catch((error) => {
            this.loading = false;
            if (error.response.status === 422) {
              this.card_error_selected = error.response.data.errors;
            } else {
              if (error.response.status === 400) {
                this.message = error.response.data.error.message;
              } else {
                this.message =
                  "Your payment method could not be added. Please contact support@sexy1on1.com for more info.";
              }
              this.$root.$emit("open_dialog_message", {
                message: this.message,
                message_title: "ERROR",
              });
            }
          });
      }
    },
    f_add_credits_to_user(credits) {
      this.user_credits = parseFloat(this.user.credits) + parseFloat(credits);
      Vue.set(this.user, "credits", this.user_credits);
    },
    f_remove_credits_user_text_message(credits) {
      this.user_credits = credits;
      Vue.set(this.user, "credits", credits);
    },
    f_buy_credits() {
      if (!this.card.value) {
        this.card_error.value = true;
      }
      if (this.card.title === "Select Payment Option") {
        this.card_error.title = true;
      }
      if (
        this.credits.value <= 0 &&
        this.credits.value === "Select Payment Option"
      ) {
        this.card_error.credits = true;
      }
      if (
        !this.card_error.value &&
        !this.card_error.title &&
        !this.card_error.credits
      ) {
        this.loading = true;
        axios
          .post("/api/v1/user/account/credits", {
            credits: this.credits.value,
            biller: this.card.value,
          })
          .then((response) => {
            this.loading = false;
            this.f_add_credits_to_user(this.credits.value);
            this.$root.$emit("on_chat_remove_user_no_credit_box", {});
            this.dialog_select_credit = false;

            if (
              this.source === "subscription" &&
              this.user_credits >= this.subscription.price
            ) {
              this.openSubscriptionFromCredits();
            } else {
              this.message = response.data.msg;

              this.$root.$emit("open_dialog_message", {
                message: this.message,
                message_title: "PURCHASE",
                purchase: response.data.purchase,
              });
            }
          })
          .catch((error) => {
            this.loading = false;
            this.dialog_select_credit = false;
            if (error.response.status === 400) {
              this.message = error.response.data.error.message;
            } else {
              this.message =
                "Transaction declined. " + error.response.data.message;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
          });
      }
    },
    f_get_cards() {
      if (
        !this.card.value &&
        this.credits.title !== this.credits.value &&
        !this.dialog_new_card
      ) {
        this.loading = true;
        axios
          .get("/api/v1/user/account/cards", {})
          .then((response) => {
            this.loading = false;
            this.cards = response.data;
            if (this.cards.length > 0) {
              this.f_select_card(this.cards[0]);
            }
            this.dialog = true;
            this.dialog_new_card =
              this.cards.length === 0 || this.dialog_new_card;
          })
          .catch((error) => {
            this.loading = false;
            this.dialog = true;
          });
      } else {
        this.dialog = true;
        //this.dialog_new_card = this.cards.length === 0 || this.dialog_new_card ;
      }
    },

    f_get_user_cards() {
      this.loading = true;
      axios
        .get("/api/v1/user/account/cards", {})
        .then((response) => {
          this.loading = false;
          this.cards = response.data;
          if (this.cards.length > 0) {
            this.f_select_card(this.cards[0]);
          }
          //this.dialog_new_card_subscription = this.cards.length === 0 || this.dialog_new_card_subscription;
        })
        .catch((error) => {
          this.loading = false;
        });
    },
    f_select_card(item) {
      this.card.title = item[0];
      this.card.value = item[3];
    },
    openSubscription(payload) {
      this.f_reset_data();
      this.f_get_user_cards();
      this.model = payload.model;
      this.subscription = payload.subscription;
      this.dialog_subscription = true;
    },
    openSubscriptionFromCredits() {
      this.dialog_new_card_subscription = false;
      this.source = "";
      this.dialog_subscription = true;
      this.f_get_user_cards();
    },
    openAddCreditDialog() {
      this.dialog_select_credit = true;
    },
    f_add_card_and_subscribe() {
      if (this.f_validate_form_card()) {
        this.loading = true;
        const endpoint = this.dialogSnapchat
          ? "save_card_snapchat_subscribe"
          : "cardSubscribe";
        axios
          .post("/api/v1/user/account/" + endpoint, {
            cc_number: this.card_selected.cc_number.replace(/\s+/g, ""),
            subscription: this.subscription.id,
            cc_exp: this.card_selected.cc_exp,
            cc_zip: this.card_selected.cc_zip,
            cc_cvv: this.card_selected.cc_cvv,
            first_name: this.card_selected.first_name,
            last_name: this.card_selected.last_name,
            snapchat_id: this.dialogSnapchat ? this.snapchat.username : null,
          })
          .then((response) => {
            this.loading = false;
            this.dialog = false;
            if (this.dialogSnapchat) {
              this.snapchatSubscribed = true;
              EventBus.$emit("user_subscribed_snapchat", {});
            } else {
              this.dialog_subscription = false;
              this.model.user_subscribed = true;

              //this.f_remove_credits_from_user();
              //this.message = response.data;
              // this.message = response.data.msg;
              // this.$root.$emit(
              //   "open_dialog_message",
              //   {
              //     message: this.message,
              //     message_title: "PURCHASE",
              //     purchase: response.data.purchase,
              //   },
              //   this.model
              // );

              // EventBus.$emit("user_subscribed", {});
            }
            this.dialog_message = true;
          })
          .catch((error) => {
            this.loading = false;
            //this.dialog_subscription = false;
            this.message_title = "ERROR";
            if (error.response.status === 422) {
              this.card_error_selected = error.response.data.errors;
            } else if (error.response.status === 400) {
              this.message = error.response.data.error.message;
              this.dialog_subscription = false;
            } else {
              this.message =
                "Your payment method could not be added. " +
                error.response.data.message;
              this.dialog_subscription = false;
            }
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
            /* Event.$emit('open_dialog_message',{});*/
          });
      }
    },
    f_pay_and_subscribe() {
      if (!this.card.value) {
        this.card_error.value = true;
      }
      if (this.card.title === "Select Payment Option") {
        this.card_error.title = true;
      }
      if (
        this.credits.value <= 0 &&
        this.credits.value === "Select Payment Option"
      ) {
        this.card_error.credits = true;
      }
      if (
        !this.card_error.value &&
        !this.card_error.title &&
        !this.card_error.credits
      ) {
        this.loading = true;
        const endpoint = this.dialogSnapchat
          ? "snapchatSubscribe"
          : "subscribe";
        axios
          .post("/api/v1/user/account/" + endpoint, {
            subscription: this.subscription.id,
            biller: this.card.value,
            snapchat_id: this.dialogSnapchat ? this.snapchat.username : null,
          })
          .then((response) => {
            const message = response.data.success.msg;
            this.loading = false;
            if (this.dialogSnapchat) {
              this.snapchatSubscribed = true;
              EventBus.$emit("user_subscribed_snapchat", {});
            } else {
              this.dialog_subscription = false;
              // this.$root.$emit(
              //   "open_dialog_message",
              //   {
              //     message: message,
              //     message_title: "PURCHASE",
              //     purchase: response.data.success.purchase,
              //   },
              //   this.model
              // );
              this.model.user_subscribed = true;
              // EventBus.$emit("user_subscribed", {});
            }
            this.dialog_message = true;
          })
          .catch((error) => {
            this.loading = false;
            this.dialog_subscription = false;
            this.message = error.response.data.error.message;
            this.$root.$emit("open_dialog_message", {
              message: this.message,
              message_title: "ERROR",
            });
            /*  Event.$emit('open_dialog_message',{});*/
          });
      }
    },
    openSendTip(payload) {
      this.model = payload.model;
      this.dialogTipModel = true;
    },
    openSnapchat(payload) {
      this.f_reset_data();
      this.f_get_user_cards();
      this.model = payload.model;
      this.subscription = this.model.subscriptions.filter(
        (i) => i.type == "SNAPCHAT"
      )[0];
      this.dialogSnapchat = true;
    },

    nextSnapchatSubscribe(step) {
      if (step == 2) {
        if (this.snapchat.username == "" || this.snapchat.username2 == "") {
          this.snapchat_username_error = "Username is require.";
          return;
        }
        if (this.snapchat.username != this.snapchat.username2) {
          this.snapchat_username_error = "Usernames do not match.";
          return;
        }
        this.snapchat_username = false;
      }
    },

    sendTip() {
      if (this.tip) {
        if (this.tip > 200) {
          this.notipError = false;
          this.tipErrorMsg = "The maximum tip amount is $200";
          return;
        } else if (this.tip < 5) {
          this.notipError = false;
          this.tipErrorMsg = "The minimum tip amount is $5";
          return;
        }
        this.loading = true;
        axios
          .post("/api/v1/send-tip", {
            credits: this.tip,
            model_id: this.model.id,
          })
          .then((response) => {
            this.loading = false;
            if (
              response.data.error &&
              response.data.error[1].message == "Not enough credits"
            ) {
              this.dialogTipModel = false;
              this.tripping_modal_not_e_credits = true;
            } else {
              this.sentTip = true;
              this.$root.$emit("add_tip_to_chat_messages_box", {
                chat: response.data[1],
              });
              this.$root.$emit("chat_subtract_credits-" + this.user.id, {
                user: { credits: this.user.credits - this.tip },
              });
            }
          })
          .catch(function (error) {
            this.loading = false;
            if (
              error.response &&
              (error.response.status === 401 || error.response.status === 419)
            ) {
              window.location = "/login";
            } else console.log(error);
          });
      }
    },
    add_credits() {
      this.modal_not_e_credits = false;
      this.tripping_modal_not_e_credits = false;

      EventBus.$emit("open-credits", {});
    },
  },
};
</script>
<style>
.form-control-style {
  border: 1px solid #13122066!important;
  border-radius: 4px!important;
  box-shadow: none!important;
}
.tip-modal input::-webkit-outer-spin-button,
.tip-modal input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
.tip-modal input[type="number"] {
  -moz-appearance: textfield;
}

.tip-input .v-messages__message {
  color: red;
  font-weight: bold;
}
</style>
<style scoped>
.margin-b10 {
  margin-bottom: 10px!important;
}
.v-list-item {
  min-height: 39px!important;
}
.card-type {
  margin: 0;
  font-size: 12px!important;
  color: #131220!important;
  font-weight: 500!important;
  opacity: 0.5;
}
.complete-purchase {
  background: transparent linear-gradient(254deg, #7272FF 0%, var(--unnamed-color-9759ff) 100%) 0% 0% no-repeat padding-box;
  background: transparent linear-gradient(254deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
  box-shadow: 0px 2px 4px #9759FF4D;
  border-radius: 12px;
  opacity: 1;
  width: 138px;
  height: 40px!important;
  color: #fff!important;
  font-size: 12px!important;
  font-weight: 600!important;
}
.select-amount {
  color: #131220;
  font-size: 14px;
  font-weight: 600!important;
  letter-spacing: 0!important;
}
.card-purchase {
    font-weight: 600;
    color: #949498;
    font-size: 16px;
    width: 275px;
    margin: 20px auto 10px auto;
    text-align: center;
    white-space: initial;
}
.txt-response {
   font-size: 12px!important; 
   font-weight: 500!important; 
   white-space: inline!important; 
   color: #131220!important; 
   white-space: initial!important;
   line-height: 17px;
}
.wordwrap {
  white-space: initial!important;
}
.small {
  color: #9759FF;
  font-size: 10px!important;
  font-weight: 500!important;
}
.txt-guarantee {
  font-size: 16px!important; 
  font-weight: 600!important; 
  white-space: inline!important; 
  color: #1F1E34!important; 
  white-space: initial!important;
  line-height: 20px;
}
.guarantee {
  width: 104px!important;
}
.transaction-dialog {
  background: #FFFEFF 0% 0% no-repeat padding-box;
  box-shadow: 0px 3px 6px #00000029;
  border-radius: 10px !important;
  opacity: 1;
}
.credit-cards {
  width: 200px;
  height: 19.47px;
  margin: auto;
  display: flex;
}
.credit-cards img {
  height: 100%;
}
.tip-input .v-messages__message {
  color: red;
  font-weight: bold;
}
.credit_icon {
  background-color: #8ebef8 !important;
  font-size: 10px !important;
  font-weight: 700;
  padding: initial !important;
  min-width: 18px !important;
  height: 18px !important;
  color: white;
  border-radius: 100%;
}

.credits {
  color: white;
  /*margin-right: 15px;*/
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
}

.text_title {
  font-size: 15px;
  font-weight: 600;
  color: #1f1e34;
}

.text_subtitle_credit {
  font-size: 12px;
  font-weight: 500;
  color: #8d8fa4 !important;
  margin-bottom: 3px;
}
.text_subtitle_credit h4 {
  font-size: 12px;
  font-weight: 600;
  color: #131220 !important;
  margin: 0;
  line-height: 12px!important;
}
.text_subtitle_credit >>> label {
  font-size: 12px;
  font-weight: 500;
  color: #8d8fa4 !important;
  margin-bottom: 3px;
}

.form-control {
  display: block;
  width: 100%;
  padding: 0.375rem 0.75rem;
  font-size: 12px;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.select_credits {
  letter-spacing: 0px;
  font-size: 16px;
  font-weight: 600;
  text-transform: capitalize;
  width: 100%;
  border: 1px solid #13122066!important;
  border-radius: 4px;
  height: 36px!important;
}

.v-card__title {
  text-align: center !important;
  display: block !important;
  padding-top: 10px !important;
  font-size: 20px !important;
  font-weight: 600 !important;
  color: #1f1e34 !important;
}

.text_add_card {
  font-size: 10px;
  font-weight: 500;
  text-transform: uppercase;
  padding-left: 0px;
  /* height: 60px;*/
  color: #80818b;
}

.v-list-item {
  text-align: center;
  border: 1px solid #e7e7f0;
}

.btn_select_payment_method {
  height: 36px!important;
  font-size: 16px;
  font-weight: 600;
  text-transform: capitalize;
  background-color: transparent !important;
  width: 100%;
  color: #131220;
  font-size: 12px!important;
  font-weight: 600!important;
  border: 1px solid #13122066!important;
  margin-bottom: 18px!important;
  justify-content: left!important;
  padding-left: 10px!important;
}

.btn-custom {
  background: transparent linear-gradient(256deg, #7272ff 0%, #9759ff 100%) 0%
    0% no-repeat padding-box;
  box-shadow: 0px 2px 4px #9759ff4d !important;
}

.color_inactive,
.color_inactive.primary {
  background: #eff0f1 !important;
  pointer-events: none;
}

.invalid {
  border-color: #e3342f !important;
  box-shadow: 0 0 0 0.2rem rgba(227, 52, 47, 0.25);
}
.v-card label {
  font-size: 12px !important;
  color: #131220 !important;
  font-weight: 600;
  margin-bottom: 10px;
}
.v-input--selection-controls.v-input .v-label {
  font-size: 12px !important;
  color: #6b7d7d !important;
}

.btn_select_payment_method span {
  font-size: 13px;
  color: #1f1e34;
}
.h6 {
  font-size: 12px !important;
}
.wordwrap {
  white-space: pre-wrap;
  white-space: -moz-pre-wrap;
  white-space: -pre-wrap;
  white-space: -o-pre-wrap;
  word-wrap: break-word;
}
.user_avatar_list {
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  display: inline-block;
  overflow: hidden;
  border-radius: 50%;
  width: 150px;
  height: 150px;
  background-size: cover;
  background-color: #8ebef8;
  margin-top: 20px;
}
.subtitle-1 {
  font-size: 18px !important;
  font-weight: 600;
  color: #1f1e34;
  margin-top: 10px;
}
.profile_avatar{
  width:120px;
  height:120px;
  border:2px solid #b02b30;
  border-radius: 50%;
}
.centered-input >>> input {
  text-align: center;
}
</style>
<style>
      #tipammount{
        max-height: 49px !important;
        height: 49px !important;
        font-size: 40px !important;
      }
      .my-tip-input .v-text-field__prefix {
        line-height: 49px !important;
        font-size: 40px !important;
        color:#A1A0A6;
      }
      .my-tip-input input[type="number"]::-webkit-inner-spin-button {
        display: none;
        -webkit-appearance: none;
      }
</style>