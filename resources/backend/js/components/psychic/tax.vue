



<template>
  <div>
    <v-row>
      <v-col cols="12" class="px-0">
        <v-container class="mx-0">
          <v-card class="justify-content-between m-1 pl-0 pt-1 pb-1 pr-2">
            <div class="form-row mb-0 mt-0">
              <div class="col-6 subtitle-1 m-0 p-0">
                <div class="row" style="margin-bottom: 20px">
                  <span class="col-6">Tax Form 1099-K</span>
                  <div></div>
                </div>
                <div class="col-12 pl-0" style="margin-bottom: 10px">
                  <div class="row sfTypeForm">
                    <div class="col-6">
                      <input
                        name="typeform[]"
                        type="checkbox"
                        id="individual"
                        true-value="1"
                        false-value="2"
                        v-model="picked"
                      />
                      <label
                        for="individual"
                        :style="[
                          picked == 1
                            ? { opacity: '1 !important' }
                            : { opacity: '0.5' },
                        ]"
                        >Individual</label
                      >
                    </div>
                    <div class="col-6">
                      <input
                        name="typeform[]"
                        type="checkbox"
                        id="corporation"
                        true-value="2"
                        false-value="1"
                        v-model="picked"
                      />
                      <label
                        for="corporation"
                        :style="[
                          picked == 2
                            ? { opacity: '1  !important' }
                            : { opacity: '0.5' },
                        ]"
                        >Corporation</label
                      >
                    </div>
                  </div>
                </div>
                <div
                  v-if="picked == 1"
                  class="col-12 pl-0"
                  style="margin-bottom: 10px"
                >
                  <v-text-field
                    id="first_name"
                    placeholder="Legal First Name"
                    solo
                    dense
                    hide-details
                    filled
                    flat
                    class="sfInputClass"
                    prepend-icon="ico-profile-finger"
                    v-model="user_form[0].first_name"
                  ></v-text-field>

                  <span
                    v-if="errors['first_name']"
                    class="float-left text-danger small"
                    >{{ errors["first_name"][0] }}</span
                  >
                </div>

                <div
                  v-if="picked == 2"
                  class="col-12 pl-0"
                  style="margin-bottom: 10px"
                >
                  <v-text-field
                    id="business_name"
                    placeholder="Legal Business Name"
                    solo
                    dense
                    hide-details
                    filled
                    flat
                    class="sfInputClass"
                    prepend-icon="ico-profile-business"
                    v-model="user_form[0].business_name"
                  ></v-text-field>

                  <span
                    v-if="errors['business_name']"
                    class="float-left text-danger small"
                    >{{ errors["business_name"][0] }}</span
                  >
                </div>
                <div
                  v-if="picked == 1"
                  class="col-12 pl-0"
                  style="margin-bottom: 10px"
                >
                  <v-text-field
                    id="last_name"
                    placeholder="Legal Last Name"
                    solo
                    dense
                    hide-details
                    filled
                    flat
                    class="sfInputClass"
                    prepend-icon="ico-profile-finger"
                    v-model="user_form[0].last_name"
                  ></v-text-field>

                  <span
                    v-if="errors['last_name']"
                    class="float-left text-danger small"
                    >{{ errors["last_name"][0] }}</span
                  >
                </div>

                <div
                  v-if="picked == 2"
                  class="col-12 pl-0"
                  style="margin-bottom: 10px"
                >
                  <v-text-field
                    id="tax_id"
                    placeholder="Tax ID"
                    solo
                    dense
                    hide-details
                    filled
                    flat
                    class="sfInputClass"
                    prepend-icon="ico-profile-inactive"
                    v-model="user_form[0].tax_id"
                  ></v-text-field>

                  <span
                    v-if="errors['tax_id']"
                    class="float-left text-danger small"
                    >{{ errors["tax_id"][0] }}</span
                  >
                </div>
                <div
                  v-if="picked == 1"
                  class="col-12 pl-0"
                  style="margin-bottom: 10px"
                >
                  <v-text-field
                    id="ssn"
                    placeholder="Social Security Number"
                    solo
                    dense
                    hide-details
                    filled
                    flat
                    class="sfInputClass"
                    prepend-icon="ico-profile-inactive"
                    v-model="user_form[0].ssn"
                  ></v-text-field>

                  <span
                    v-if="errors['ssn']"
                    class="float-left text-danger small"
                    >{{ errors["ssn"][0] }}</span
                  >
                </div>
                <div class="col-12 pl-0" style="margin-bottom: 10px">
                  <v-text-field
                    id="address"
                    placeholder="Address"
                    solo
                    dense
                    hide-details
                    filled
                    flat
                    class="sfInputClass"
                    prepend-icon="ico-profile-city"
                    v-model="user_form[0].address"
                  ></v-text-field>

                  <span
                    v-if="errors['address']"
                    class="float-left text-danger small"
                    >{{ errors["address"][0] }}</span
                  >
                </div>
                <div
                  v-if="picked == 2"
                  class="col-12 pl-0"
                  style="margin-bottom: 10px"
                >
                  <v-text-field
                    id="address_2"
                    placeholder="Address 2"
                    solo
                    dense
                    hide-details
                    filled
                    flat
                    class="sfInputClass"
                    prepend-icon="ico-profile-city"
                    v-model="user_form[0].address_2"
                  ></v-text-field>

                  <span
                    v-if="errors['address_2']"
                    class="float-left text-danger small"
                    >{{ errors["address_2"][0] }}</span
                  >
                </div>
                <div
                  class="col-lg-12 col-md-12 p-0 m-0"
                  style="margin-top: 14px !important"
                >
                  <div class="row">
                    <div class="col-6 pr-0">
                      <v-text-field
                        id="city"
                        label="City"
                        style="max-width: 171px"
                        solo
                        flat
                        dense
                        hide-details
                        filled
                        type="tel"
                        class="sfInputClass"
                        prepend-icon="ico-profile-city"
                        v-model="user_form[0].city"
                      ></v-text-field>
                      <span
                        v-if="errors['city']"
                        class="float-left text-danger small"
                        >{{ errors["city"][0] }}</span
                      >
                    </div>

                    <div class="col-5">
                      <v-select
                        id="state"
                        :items="states"
                        label="State"
                        filled
                        dense
                        flat
                        hide-details
                        item-value="code"
                        item-text="name"
                        solo
                        append-icon="ico-sort-arrows"
                        v-model="user_form[0].state"
                        class="checkRigth"
                        :menu-props="{ contentClass: 'checkList-line' }"
                      >
                      </v-select>
                      <span
                        v-if="errors['state']"
                        class="float-left text-danger small"
                        >{{ errors["state"][0] }}</span
                      >
                    </div>
                  </div>
                </div>

                <div
                  class="col-lg-12 col-md-12 p-0 m-0"
                  style="margin-top: 14px !important"
                >
                  <div class="row">
                    <div class="col-6 pr-0">
                      <v-text-field
                        id="zip"
                        label="Zip Code"
                        style="max-width: 171px"
                        solo
                        flat
                        dense
                        hide-details
                        filled
                        class="sfInputClass"
                        prepend-icon="ico-profile-city"
                        v-model="user_form[0].zip"
                      ></v-text-field>
                      <span
                        v-if="errors['zip']"
                        class="float-left text-danger small"
                        >{{ errors["zip"][0] }}</span
                      >
                    </div>

                    <div class="col-5">
                      <v-select
                        id="country"
                        :items="countries"
                        label="Country"
                        filled
                        dense
                        flat
                        hide-details
                        item-value="code"
                        item-text="name"
                        solo
                        append-icon="ico-sort-arrows"
                        v-model="user_form[0].country"
                        class="checkRigth"
                        :menu-props="{ contentClass: 'checkList-line' }"
                      >
                      </v-select>
                      <span
                        v-if="errors['country']"
                        class="float-left text-danger small"
                        >{{ errors["country"][0] }}</span
                      >
                    </div>
                  </div>
                </div>

                <div
                  class="col-lg-12 col-md-12 p-0 m-0"
                  style="margin-top: 14px !important"
                >
                  <div class="row">
                    <div class="col-6 pr-0">
                      <v-select
                        id="phone_number_code"
                        :items="country_all"
                        label="Select"
                        class="checkRigth checkLeftS right-left"
                        filled
                        flat
                        item-text="prefix"
                        item-value="code2"
                        hide-details
                        disabled
                        dense
                        solo
                        auto
                        autocomplete
                        v-model="user_form[0].phone_number_code"
                        :menu-props="{ contentClass: 'checkList-lineBlue' }"
                      >
                        <template slot="selection" slot-scope="data">
                          <!-- // HTML that describe how select should render selected items -->
                          +{{ data.item.prefix }} - {{ data.item.code3 }}
                        </template>
                        <template slot="item" slot-scope="data">
                          <!-- // HTML that describe how select should render items when the select is open -->
                          +{{ data.item.prefix }} - {{ data.item.code3 }}
                        </template>
                      </v-select>
                      <span
                        v-if="errors['phone_number_code']"
                        class="float-left text-danger small"
                        >{{ errors["phone_number_code"][0] }}</span
                      >
                    </div>
                    <div class="col-5" style="padding-right: 10px !important;">
                      <v-text-field
                        id="phone_number"
                        label="5555555555"
                        solo
                        flat
                        dense
                        hide-details
                        filled
                        type="tel"
                        class="sfInputClass"
                        prepend-icon="ico-profile-phone"
                        v-model="user_form[0].phone_number"
                      ></v-text-field>
                      <span
                        v-if="errors['phone_number']"
                        class="float-left text-danger small"
                        >{{ errors["phone_number"][0] }}</span
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6 m-0 p-0">
                <p class="sfProfileText" style="margin-top: 35px">
                  To generate and download your 1099-K from the previous year,
                  complete the form with the same information you use to file
                  your tax returns.
                </p>
                <p class="sfProfileText" style="margin-top: 20px; opacity: 1">
                  Under penalties of perjury, I certify:
                </p>
                <p
                  class="sfProfileText"
                  style="margin-top: 18px; display: flex"
                >
                  <input type="checkbox" id="citizen" v-model="citizen" />
                  <label for="citizen" class="mb-0"
                    >I am a US citizen or other U.S. person.</label
                  >
                </p>
                <p
                  class="sfProfileText"
                  style="margin-bottom: 15px; display: flex"
                >
                  <input
                    type="checkbox"
                    id="number_shown "
                    v-model="number_shown"
                  />
                  <label for="number_shown" class="mb-0"
                    >The number shown on this form is my correct taxpayer
                    identification number, or I am waiting for a tax ID to be
                    assigned to me.</label
                  >
                </p>
                <p class="sfProfileText" style="display: flex">
                  <input
                    type="checkbox"
                    id="withholding"
                    v-model="withholding"
                  />
                  <label for="withholding" class="mb-0"
                    >I am not subject to backup withholding because:<br />
                    [A] I am exempt from backup withholding, or <br />[B] I have
                    not been notified by the Internal Revenue Service that I am
                    subject to backup withholding as a result of failure to
                    report all interest and dividends, or <br />[C] the Internal
                    Revenue Service has notified me that I am no longer subject
                    to backup withholding.</label
                  >
                </p>
              </div>
            </div>
            <div class="form-row mb-0 mt-10">
              <div class="col-12" style="text-align: center">
                <v-btn
                  class="mb-0 btn-block"
                  @click="generateForm"
                  color="#8EbEF8"
                  depressed
                  rounded
                  max-width="114"
                >
                  <span style="color: #ffffff">Download</span>
                </v-btn>
              </div>
            </div>
          </v-card>
        </v-container>
      </v-col>
    </v-row>
  </div>
</template>
                              



<script>
import { mapGetters } from "vuex";

export default {
  data: function () {
    return {
      user_form: [
        {phone_number: '',phone_number_code: ''},
      ],
      errors: [],
      citizen: 0,
      number_shown: 0,
      withholding: 0,
      picked: 1,
      typeform: [],
    };
  },
  props: ["user","countries", "states", "country_all"],
  mounted() {
        this.user_form[0].phone_number = this.user.userMobile.number;
        this.user_form[0].phone_number_code = this.user.userMobile.code2;
  },
 
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  methods: {
    generateForm() {},
  },
};
</script>

<style>
.sfProfileText input {
  /* margin-right: 19px; */
  margin-top: 2px;
}

.sfProfileText label {
  font-size: 12px !important;
  line-height: 18px;
  letter-spacing: 0px;
  color: #43425d !important;
  opacity: 1;
  padding-left: 19px;
}

.checkLeftS,
.checkLeftS select,
.checkLeftS .v-input__control,
.checkLeftS .v-select__slot,
.checkLeftS .v-input__slot {
  width: 171px;
  max-width: 171px;
  min-height: 40px !important;
  max-height: 40px;
  height: 40px;
  min-height: 40px;
  background: #f4f4f4 !important;
  border-radius: 5px !important;
  padding: 0px !important;
  opacity: 1 !important;
}

.sfTypeForm label {
  font-size: 12px !important;
  text-align: left;
  line-height: 18px;
  letter-spacing: 0px;
  color: #43425d !important;
  opacity: 0.5;
  padding-left: 10px;
  vertical-align: middle;
}
</style>
