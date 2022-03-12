<template>
  <div class="noROwM">
      <v-row v-if="mobile">
      <v-col cols="12" class="px-0 pt-0">
        <v-container class="mx-0">
          <v-card
            :class="mobile ? 'm-0' : 'm-1'"
            class="justify-content-between pl-0 pt-1 pb-1 pr-2"
          >

          <div class="form-row" style="margin-bottom:20px">
              <div class="subtitle-1 m-0 pl-0">
                <span class="col-12 pl-0">Referral Stats</span>
</div></div>

    
      
        <div class="row m-0">
          <v-col class="col-4 pl-0">
            <v-card
              class="mb-3 text-center pt-5 sfHeadersPayout"
              style="margin-inline-start: auto; width: 95px; height: 95px; background: #F4F4F4;"
            >
              <div>
                <div class="sfHeaderBalance">0</div>
                <div
                  class="sfHeaderTitle"
                  style="margin-bottom: 3px !important"
                >
                  Successful Referrals
                </div>
                <div class="sfHeaderPeriod"></div>
                <div class="sfHeaderIco">
                  <img src="/images/icons/invite_accepted.svg" />
                </div>
              </div>
            </v-card>
          </v-col>

          <v-col class="col-4 pl-2">
            <v-card
              class="mb-3 text-center pt-5 sfHeadersPayout"
              style="margin: auto; width: 95px; height: 95px; background: #F4F4F4;"
            >
              <div>
                <div class="sfHeaderBalance">0</div>
                <div
                  class="sfHeaderTitle"
                  style="margin-bottom: 3px !important"
                >
                  Cosmic Credits Balance
                </div>
                <div class="sfHeaderPeriod"></div>
                <div class="sfHeaderIco">
                  <img src="/images/icons/cosmic_credits.svg" />
                </div>
              </div>
            </v-card>
          </v-col>

          <v-col class="col-4 pr-0">
            <v-card
              class="mb-3 text-center pt-5 sfHeadersPayout"
              style="margin-inline-end: auto; width: 95px; height: 95px; background: #F4F4F4;"
            >
              <div>
                <div class="sfHeaderBalance">0</div>
                <div
                  class="sfHeaderTitle"
                  style="margin-bottom: 3px !important"
                >
                  Transactions Fee-Free
                </div>
                <div class="sfHeaderPeriod"></div>
                <div class="sfHeaderIco">
                  <img src="/images/icons/bag_ico.svg" />
                </div>
              </div>
            </v-card>
          </v-col>
        </div>
      
    
          </v-card>
        </v-container>
      </v-col>
    </v-row>
    
    <v-row>
      <v-col cols="12" class="px-0 pt-0">
        <v-container class="mx-0">
          <v-card
            :class="mobile ? 'm-0' : 'm-1'"
            class="justify-content-between pl-0 pt-1 pb-1 pr-2"
          >
            <div class="form-row mb-0">
              <div
                :class="mobile ? 'col-12' : 'col-6'"
                class="subtitle-1 m-0 pl-0"
                :style="!mobile ? 'padding-right: 30px !important' : ''"
              >
                <span class="col-12 pl-0">Recent Activity</span>
                <p
                  class="sfProfileText"
                  :style="mobile ? 'text-align: justify' : ''"
                  style="margin-top: 20px !important"
                >
                  When your referrals make a purchase, the Cosmic Credits you’ve
                  earned will be applied to your total balance.
                </p>
              
              <div v-for="referral in user.userReferral">
                <box-referral :user="referral" show="left"></box-referral>
              </div>
                


              </div>

              <div
                :class="mobile ? 'col-12' : 'col-6'"
                class="subtitle-1 m-0 pl-0 pr-0"
              >

              <div v-for="referral in user.userReferral">
                <box-referral :user="referral" show="right"></box-referral>
              </div>
                <!-- <div class="col-12 m-0 pl-0 pr-0">
                  <span class="col-12 pl-0">
                    <img
                      src="/images/icons/cosmic_credits.svg"
                      style="margin-right: 10px"
                    />
                    Cosmic Credits Earned
                  </span>

                  <div
                    class="col-12 pl-0"
                    :class="mobile ? 'pr-12' : 'pr-10'"
                    style="margin-top: 10px !important"
                  >
                    <p class="sfProfileText">
                      Justin Levine’s purchase earned you +150 Cosmic Credits!
                    </p>
                    <box-rewards
                      style="position: absolute; bottom: -6px; right: 0px"
                      status="on"
                      :value="150"
                    ></box-rewards>
                  </div>
                </div>

                <div
                  class="col-12 m-0 pl-0 pr-0"
                  style="margin-top: 20px !important"
                >
                  <span class="col-12 pl-0">
                    <img
                      src="/images/icons/cosmic_credits.svg"
                      style="margin-right: 10px"
                    />
                    Cosmic Credits Earned
                  </span>

                  <div
                    :class="mobile ? 'pr-12' : 'pr-10'"
                    class="col-12 pl-0"
                    style="margin-top: 10px !important"
                  >
                    <p class="sfProfileText">
                      Justin Levine’s purchase earned you +150 Cosmic Credits!
                    </p>
                    <box-rewards
                      class="subtitle-1"
                      style="position: absolute; bottom: -6px; right: 0px"
                      status="on"
                      :value="150"
                      positionbox="last"
                    ></box-rewards>
                  </div>
                </div> -->
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
      url_copy: "respectfully.com/join/" + this.user.userProfile.profile_link,
      emailSend: "",
    };
  },
  props: ["user"],

  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
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
  width: 100px;
  max-width: 100px;
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
