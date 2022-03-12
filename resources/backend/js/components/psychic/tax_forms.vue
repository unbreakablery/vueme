<template>
  <div class="model-tax-forms" style="max-width:100%">
    <h2 class="content-title">Tax Form 1099-NEC</h2>
    <div class="tax-desc-sm">
      To download a copy of your Tax Form 1099-K, select your tax year and complete the form with the same information you use to file your tax returns.
    </div>
    <v-row class="mb-3">
      <v-col
        md="6"
        sm="6"
        cols="12"
        class="pr-5"
      >
        <v-row>
          <v-col
            md="5"
            cols="5"
          >
            <v-select
              id="profile_country"
              label="Select Tax Year"
              background-color="#fff"
              filled
              dense
              solo
              flat
              hide-details
              item-value="code"
              item-text="name"
              class="checkRigth right-align"
              :menu-props="{ contentClass: 'checkList-lineBlue' }"
            ></v-select>
          </v-col>
        </v-row> 
      </v-col>
      <v-col
        md="6"
        sm="6"
        cols="12"
        class="pl-5 d-flex"
      >
        <v-row class="mt-minus-10">
          <v-col>
            <v-checkbox
              label="Individual"
              v-model="individual"
              @click="corporation=!corporation"
              :class="{ active: individual }"
              class="personal-list"
            ></v-checkbox>
          </v-col>
          <v-col>
            <v-checkbox
              label="Corporation"
              v-model="corporation"
              @click="individual=!individual"
              :class="{ active: corporation }"
              class="personal-list"
            ></v-checkbox>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
    <v-row>
      <v-col
        md="6"
        sm="6"
        cols="12"
        class="pr-5"
      >
        <v-row v-if="individual">
          <v-col
            md="12"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              label="Legal First Name"
              prepend-inner-icon="mdi-fingerprint"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row v-if="individual">
          <v-col
            md="12"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              prepend-inner-icon="mdi-fingerprint"
              type="text"
              label="Legal Last Name"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row v-if="corporation">
          <v-col
            md="12"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              prepend-inner-icon="mdi-briefcase-variant-outline"
              type="text"
              label="Legal Business Name"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row v-if="individual">
          <v-col
            md="12"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              label="Social Security Number"
              prepend-inner-icon="mdi-lock-open"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row v-if="corporation">
          <v-col
            md="12"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              label="Tax ID"
              prepend-inner-icon="mdi-lock-open"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row v-if="individual">
          <v-col
            md="12"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              prepend-inner-icon="mdi-map-marker-outline"
              label="Address"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row v-if="corporation">
          <v-col
            md="12"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              prepend-inner-icon="mdi-map-marker-outline"
              label="Address 1"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row v-if="corporation">
          <v-col
            md="12"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              prepend-inner-icon="mdi-map-marker-outline"
              label="Address 2"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col
            md="7"
            sm="7"
            cols="7"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              prepend-inner-icon="mdi-map-marker-outline"
              label="City"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
          <v-col
            md="5"
            sm="5"
            cols="5"
          >
            <v-select
              id="profile_country"
              label="State"
              background-color="#fff"
              filled
              dense
              solo
              flat
              hide-details
              item-value="code"
              item-text="name"
              class="checkRigth right-align"
              :menu-props="{ contentClass: 'checkList-lineBlue' }"
            ></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col
            md="7"
            sm="7"
            cols="7"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              prepend-inner-icon="mdi-map-marker-outline"
              type="text"
              label="Zip Code"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
          <v-col
            md="5"
            sm="5"
            cols="5"
          >
            <v-select
              id="profile_country"
              label="Country"
              background-color="#fff"
              filled
              dense
              solo
              flat
              hide-details
              item-value="code"
              item-text="name"
              class="checkRigth right-align"
              :menu-props="{ contentClass: 'checkList-lineBlue' }"
            ></v-select>
          </v-col>
        </v-row>
        <v-row>
          <v-col
            md="5"
            sm="5"
            cols="5"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              type="text"
              label="+1 (USA)"
              class="sfInputClassInactive sfInputClassLeft"          
              value=""
            ></v-text-field>
          </v-col>
          <v-col
            md="7"
            sm="7"
            cols="7"
          >
            <v-text-field
              id="bank_name"
              background-color="#fff"
              solo
              flat
              dense
              hide-details
              filled
              prepend-inner-icon="mdi-cellphone"
              type="text"
              label="555-555-5555"
              class="sfInputClassInactive sfInputClassLeft with-icon"          
              value=""
            ></v-text-field>
          </v-col>
        </v-row>
        
      </v-col>
      <v-col
        md="6"
        sm="6"
        cols="12"
        class="pl-5 checkbox-align"
      >
        <div class="tax-desc-md">
          To download a copy of your Tax Form 1099-K, select your tax year and complete the form with the same information you use to file your tax returns.
        </div>
        <h5 class="under-pernalties">Under penalties of perjury, I certify:</h5>
        <v-checkbox
          label="I am a US citizen or other U.S. person."
          value="true"
        ></v-checkbox>
        <v-checkbox
          label="The number shown on this form is my correct taxpayer identification number, or I am waiting for a tax ID to be assigned to me."
          value="true"
        ></v-checkbox>
        <v-checkbox
          label="I am not a subject to backup withholding becasue: [A] I am exempt from backup withholding, or [B] I have not been notified by the Internal Revenue Service that I am subject to backup withholding as a result of failure to report all interest and dividends, or [C] the Internal Revenue Service has notified me that I am no longer subject to backup withholding."
          value="true"
        ></v-checkbox>
  </v-col>
    </v-row>
    <div class="text-center mt-5">
      <v-btn
        style="min-width: auto !important; 
          background: linear-gradient(256deg, #7272FF 0%, #9759ff 100%);
          box-shadow: 0 2px 4px #9759FF4D!Important;
          border-radius: 12px;
          outline: none;
          padding: 0 50px;
          font-size: 12px!important;
          "
        depressed
        rounded
        color="primary"
        class="model-btn"
      >Submit</v-btn>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      individual: true,
      corporation: false,
    }
  }
}
</script>

<style lang="scss">
.v-select.v-text-field input{
  border:none;
}
.model-tax-forms {
  max-width: 770px;
  margin: 30px auto 0;
  padding: 17px 20px;
  background-color: white;
  box-shadow: 0px 10px 13px #0000001A!important;
  .personal-list {
    .v-input--selection-controls .v-input__slot > .v-label, .v-input--selection-controls .v-radio > .v-label {
      color: #949498!important;
    }
    &.active.v-input--selection-controls .v-input__slot > .v-label, .v-input--selection-controls .v-radio > .v-label {
      color: #43425D!important;
    }
  }
  .tax-desc-md, .tax-desc-sm {
    color: #656B72;
    font-size: 12px;
    line-height: 17px;
    padding-top: 24px;
    padding-bottom: 20px;
  }
  .tax-desc-sm {
    display: none;
  }
  @media (max-width: 500px) {
    .tax-desc-md {
      display: none;
    }
    .under-pernalties {
      padding-top: 20px;
    }
    .tax-desc-sm {
      display: block;
      padding-top: 0;
    }
  }
  .under-pernalties {
    font-size: 12px;
    color: #131220;;
    line-height: 17px;
    margin-bottom: 0;
  }
  .v-input--checkbox {
    margin-top: 0;
    display: inline-block;
    .v-messages {
      display: none;
    }
  }
  .mt-minus-10 {
    margin-top: -10px!important;
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
  .content-title {
    font-size: 18px;
    line-height: 26px;
    color: #131220;
    margin-bottom: 20px;
  }
  .row {
    margin-left: -5px!important;
    margin-right: -5px!important;
    >div {
      padding: 0px 5px!important;
      @media (min-width: 600px) {
        &.pr-5 {
          padding-right: 20px!important;
        }
        &.pl-5 {
          padding-left: 20px!important;
        }
      }
    }
  }
  .v-text-field.with-icon {
    .v-input__slot {
      position: relative;
      .v-input__prepend-inner {
        position: absolute;
        margin-top: -3px;
      }
      .v-icon {
        font-size: 20px;
      }
      .v-label {
        left: 25px!important;
      }
      input {
        padding-left: 25px!important;
      }
    }
  }
  .v-text-field {
    .v-label {
      left: 10px!important;
    }
  }
  .v-text-field--filled.v-input--dense.v-text-field--single-line .v-label, .v-text-field--full-width.v-input--dense.v-text-field--single-line .v-label {
    font-size: 12px;
    color: #CBCBCD!important;
  }
  .checkbox-align {
    .v-input--checkbox {
      .v-input__slot {
        align-items: end;
      }
    }
  }
}
</style>
