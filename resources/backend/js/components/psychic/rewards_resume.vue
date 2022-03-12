<template>
  <div>
    <v-row>
      <v-col
        :cols="mobile ? 12 : 6"
        class="px-0 pt-0"
        :style="mobile ? '' : 'padding-right: 5px !important'"
      >
        <v-container class="mx-0 pt-0 pr-0">
          <v-card class="justify-content-between m-0 pl-0 pt-1 pb-1 pr-2">
            <div class="form-row mb-0 ml-0 mr-0">
              <div class="col-12 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">My Badges</span>
              </div>

              <div
                class="col-12 m-0 p-0 d-flex"
                style="margin-top: 20px !important"
              >
                <div class="MyBadges">
                  <div>
                    <img src="/images/icons/award-regular.svg" />
                  </div>
                  <div class="MyBadgesText">Featured</div>
                </div>
                <div class="MyBadges" style="margin: 0 10px">
                  <div>
                    <img src="/images/icons/medal-regular.svg" />
                  </div>
                  <div class="MyBadgesText">Preferred</div>
                </div>
                <div class="MyBadges">
                  <div>
                    <img
                      style="margin-left: 23px"
                      src="/images/icons/trophy-alt-regular.svg"
                    />
                  </div>
                  <div class="MyBadgesText">Top</div>
                </div>
              </div>
            </div>
          </v-card>
        </v-container>

        <v-container class="mx-0 pt-0 pr-0">
          <v-card class="justify-content-between m-0 pl-0 pt-0 pb-1 pr-2">
            <div class="form-row mb-0 ml-0 mr-0">
              <div class="col-12 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">Unlocked Achievements</span>
                <div
                  class="col-12 subtitle-1 m-0 p-0"
                  style="
                    padding-right: 30px !important;
                    margin-top: 20px !important;
                  "
                >
                  <span class="col-12 pl-0">
                    <img
                      src="/images/icons/featured_psychic.svg"
                      style="margin-right: 10px"
                    />
                    Featured Model Rewards
                  </span>
                </div>

                <p class="sfProfileText" style="margin-top: 10px !important">
                  500 Cosmic Credits earns you a “featured psychic” spot right
                  on Respectfully homepage for a month!
                </p>

                <p class="sfProfileTextSub">Achieved: February 5th, 2021</p>
                <div class="d-flex UnlockedAchievements">
                  <div class="ini"><font class="col">100</font></div>
                  <div class="middle"><font>200</font></div>
                  <div class="middle"><font>300</font></div>
                  <div class="middle"><font>400</font></div>
                  <div class="end">
                    <img src="/images/icons/rewards.svg" style="opacity: 0.5; width: 27px;">
                    <font>500</font>
                    </div>
                </div>
              </div>
            </div>
          </v-card>
        </v-container>
      </v-col>
      <v-col
        :cols="mobile ? 12 : 6"
        class="px-0 pt-0"
        :style="mobile ? '' : 'padding-left: 5px !important'"
      >
        <v-container class="mx-0 pt-0 pl-0">
          <v-card class="justify-content-between m-0 pl-0 pt-1 pb-1 pr-2">
            <div class="form-row mb-0 ml-0 mr-0">
              <div class="col-12 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">Goals In Progress</span>

                <div
                  class="col-12 subtitle-1 m-0 p-0"
                  style="
                    padding-right: 30px !important;
                    margin-top: 20px !important;
                  "
                >
                  <span class="col-12 pl-0">
                    <img
                      src="/images/icons/preferred_psychic.svg"
                      style="margin-right: 10px"
                    />
                    Preferred Model Rewards
                  </span>
                </div>

                <p class="sfProfileText" style="margin-top: 10px !important">
                  1,000 Cosmic Credits earns you the “preferred psychic” badge
                  on your profile and you’ll be featured in an email blast to
                  all Respectfully clients!
                </p>

                <div class="d-flex UnlockedAchievements">
                  <div class="ini"><font class="col">600</font></div>
                  <div class="middle"><font>700</font></div>
                  <div class="middle"><font>800</font></div>
                  <div class="middle"><font>900</font></div>
                  <div class="end">
                    <img src="/images/icons/rewards.svg" style="opacity: 0.5; width: 27px;">
                    <font>1,000</font>
                    </div>
                </div>
                <div
                  class="col-12 subtitle-1 m-0 p-0"
                  style="
                    padding-right: 30px !important;
                    margin-top: 30px !important;
                  "
                >
                  <span class="col-12 pl-0">
                    <img
                      src="/images/icons/top_psychic.svg"
                      style="margin-right: 10px"
                    />
                    Top Model Rewards
                  </span>
                </div>

                <p class="sfProfileText" style="margin-top: 10px !important">
                  5,000 Cosmic Credits earns you “Top Model” status including
                  a shiny new profile badge and a permanent position on the
                  homepage. You’ll also get a dedicated blog article written
                  about you, special features on all @respectfully social media
                  and a personalized advertising campaign paid for by
                  Respectfully!
                </p>
                <div class="d-flex UnlockedAchievements">
                  <div class="ini"><font class="col">1,500</font></div>
                  <div class="middle"><font>2,500</font></div>
                  <div class="middle"><font>3,500</font></div>
                  <div class="middle"><font>4,500</font></div>
                  <div class="end">
                    <img src="/images/icons/rewards.svg" style="opacity: 0.5; width: 27px;">
                    <font>5,000</font>
                    </div>
                </div>
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
    return {};
  },
  props: ["user"],

  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },

  methods: {},
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

.sfProfileLinkText {
  letter-spacing: 0px;
  color: #c1dbfb;
  opacity: 1;
  font-weight: 500;
  font-size: 12px;
  line-height: 18px;
}

.sfInputClass.blueLink,
.sfInputClass.blueLink input,
.sfInputClass.blueLink .v-text-field__prefix,
.sfInputClass.blueLink .v-input__control,
.sfInputClass.blueLink .v-text-field__slot,
.sfInputClass.blueLink
  .v-text-field.v-text-field--enclosed.v-text-field--single-line
  .v-text-field__prefix,
.sfInputClass.blueLink
  .v-text-field.v-text-field--enclosed.v-text-field--single-line
  .v-text-field__suffix {
  background: #c1dbfb !important;
  text-align: left !important;
  font-size: 14px !important;
  letter-spacing: 0px !important;
  color: #43425d !important;
  opacity: 1 !important;
  font-weight: 500;
}

.sfInputClass.blueLink .v-text-field__slot {
  padding-left: 10px !important;
}

.sfButtonAction {
  text-align: right !important;
  cursor: pointer !important;
  font-size: 14px !important;
  letter-spacing: 0.28px !important;
  line-height: 18px !important;
  color: #43425d !important;
  opacity: 1 !important;
  font-weight: 500 !important;
}
.sfButtonAction i {
  font-size: 16px;
}
.sfProfileTextSub {
  margin-top: 20px !important;
  font-size: 12px;
  letter-spacing: 0px;
  line-height: 18px;
  text-align: left;
  opacity: 0.5;
  color: #43425d;
  font-weight: 600;
}

.MyBadges {
  width: 105px;
  height: 50px;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 10px;
  background: #f4f4f4;
}
.MyBadges div {
  float: left;
}

.MyBadges img {
  opacity: 0.5;
  margin: 13px 10px 13px 10px;
}

.MyBadgesText {
  text-align: left;
  font-weight: 600;
  font-size: 12px;
  letter-spacing: 0px;
  color: #43425d;
  opacity: 0.5;
  margin-top: 17px;
}

.UnlockedAchievements {
  height: 32px;
  width: 340px;
  margin: 0 auto;
      margin-bottom: 10px;
}
.UnlockedAchievements .ini {
  background: #f4f4f4;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 18px 0px 0px 18px;
  opacity: 1;
  height: 32px;
  width: 72.5px;
      padding-top: 8px;
      text-align: center;
}
.UnlockedAchievements .middle {
  height: 32px;
  width:  72.5px;
  box-shadow: 0px 3px 6px #0000000d;
  background: #f4f4f4;
      padding-top: 8px;
      text-align: center;
}
.UnlockedAchievements .end {
  width: 50px;
  height: 50px;
  box-shadow: 0px 3px 6px #0000000D;
border-radius: 10px;
  background: #f4f4f4;
  text-align: center;
  margin-top: -10px;
      line-height: 12px;
          padding-top: 4px;
}
.UnlockedAchievements font {
  text-align: left;
  font-weight: 600;
  letter-spacing: 0px;
  color: #43425d;
  opacity: 0.5;
  font-size: 10px;
}
</style>
