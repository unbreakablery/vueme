<template>
  <v-container class="px-0 noROwM" :class="mobile ? 'pt-0' : ''">
    <div class="mb-4">
      <form
        :style="!mobile ? 'max-width: 770px' : ''"
        class="form-dashboard sfFormProfile"
        :class="mobile ? 'sfVtabProfile' : ''"
      >
        <v-row class="mb-3" v-if="!mobile">
          <v-col class="subtitle-1">Cosmic Rewards</v-col>
        </v-row>
        <v-row class="sfHeaderProfile m-0">
          <v-col :cols="mobile ? 12 : 4">
            <div class="donut-chart-block block">
              <div class="donut-chart" :style="mobile ? 'margin: auto' : ''">
                <div id="part1" class="recorte">
                  <div class="cake ios" data-rel="33"></div>
                </div>
                <div id="porcion2" class="recorte">
                  <div class="cake mac" data-rel="33"></div>
                </div>
                <div id="porcionFin" class="recorte">
                  <div class="cake linux" data-rel="34"></div>
                </div>

                <p class="center-date">
                  <img
                    src="/images/icons/rewards.svg"
                    style="margin-bottom: 10px"
                  /><br />
                  Earn Cosmic Rewards
                </p>
              </div>
            </div>
          </v-col>
          <v-col
            v-if="!mobile"
            cols="8"
            style="padding-top: 46px !important; padding-left: 60px !important"
          >
            <div class="row m-0">
              <v-col class="col-4 col-sm-4 p-0 sfColsAd">
                <v-card
                  class="mb-3 text-center pt-5 sfHeadersPayout"
                  style="margin-inline-start: auto; width: 95px; height: 95px"
                >
                  <div>
                    <div class="sfHeaderBalance">{{counterReferral}}</div>
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

              <v-col class="col-4 col-sm-4 p-0 sfColsAd">
                <v-card
                  class="mb-3 text-center pt-5 sfHeadersPayout"
                  style="margin: auto; width: 95px; height: 95px"
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

              <v-col class="col-4 col-sm-4 p-0 sfColsAd">
                <v-card
                  class="mb-3 text-center pt-5 sfHeadersPayout"
                  style="margin-inline-end: auto; width: 95px; height: 95px"
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
          </v-col>
        </v-row>
        <v-tabs
          slider-size="0"
          align-with-title
          centered
          grow
          v-model="active_tab"
        >
          <v-tabs-slider></v-tabs-slider>

          <v-tab
            tabindex="0"
            :class="mobile ? 'pr-0 pl-0' : ''"
            style="margin-left: 0px"
            >Overview</v-tab
          >
          <v-tab-item class="mb-5" :style="!mobile ? 'margin-top: 20px' :'' ">
            <rewards-overview></rewards-overview>
            <div
              v-if="mobile"
              style="text-align: center"
              class="sfNextabProfile"
            >
              <v-btn
                style="margin: auto"
                height="38"
                @click="
                  active_tab = 1;
                  windowScrollTo();
                "
                >Next <v-img src="/images/icons/chevron-r.svg"></v-img>
              </v-btn>
            </div>
          </v-tab-item>
          <v-tab tabindex="1" :class="mobile ? 'pr-0 pl-0' : ''">Invite</v-tab>
          <v-tab-item class="mt-5" style="margin-top: 20px">
            <rewards-invite :user="user"></rewards-invite>
             <div
              v-if="mobile"
              style="text-align: center"
              class="sfNextabProfile"
            >
              <v-btn
                style="margin: auto"
                height="38"
                @click="
                  active_tab = 2;
                  windowScrollTo();
                "
                >Next <v-img src="/images/icons/chevron-r.svg"></v-img>
              </v-btn>
            </div>
          </v-tab-item>
          <v-tab
            tabindex="2"
            style="margin-right: 0px; padding-right: 0px"
            :class="mobile ? 'pr-0 pl-0' : ''"
            >Referrals</v-tab
          >

          <v-tab-item style="margin-top: 10px">
            <rewards-referrals :user="user"></rewards-referrals>
            <div
              v-if="mobile"
              style="text-align: center"
              class="sfNextabProfile"
            >
              <v-btn
                style="margin: auto"
                height="38"
                @click="
                  active_tab = 3;
                  windowScrollTo();
                "
                >Next <v-img src="/images/icons/chevron-r.svg"></v-img>
              </v-btn>
            </div>
          </v-tab-item>
          <v-tab
            tabindex="3"
            style="margin-right: 0px; padding-right: 0px"
            :class="mobile ? 'pr-0 pl-0' : ''"
            >Rewards</v-tab
          >
          <v-tab-item style="margin-top: 10px">
            <rewards-resume :user="user"></rewards-resume>
          </v-tab-item>
        </v-tabs>
      </form>
    </div>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      active_tab: 0,
      counterReferral: 0,
    };
  },
  props: ["user"],
  mounted() {

          var i=0;
          for (i = 0; i < this.user.userReferral.length; i++) {
            

            if(this.user.userReferral[i].user_referral)
            this.counterReferral++;
      
          }


  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },

  methods: {
    windowScrollTo() {
      window.scrollTo(0, 0);
    },
  },
};
</script>

<style>
.sfVtabProfile
  .v-tabs:not(.v-tabs--vertical):not(.v-tabs--right)
  > .v-slide-group--is-overflowing.v-tabs-bar--is-mobile:not(.v-slide-group--has-affixes)
  .v-slide-group__prev {
  display: none;
  visibility: hidden;
}

.sfVtabProfile .v-tab {
  min-width: 84px !important;
}

.sfNextabProfile
  .theme--light.v-btn:not(.v-btn--flat):not(.v-btn--text):not(.v-btn--outlined) {
  background-color: transparent !important;
  font-weight: 600;
  letter-spacing: 0.28px;
  color: #a2a2a2;
  opacity: 1;
  font-size: 14px;
}

.sfColsAd {
  margin: 0px 20px !important;
  max-width: 95px !important;
}

.donut-chart {
  position: relative;
  width: 190px;
  height: 190px;
  border-radius: 100%;
}
p.center-date {
  background: #ffffff;
  box-shadow: 0px 3px 6px #0000000d;
  position: absolute;
  text-align: center;
  font-size: 14px;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 145px;
  height: 145px;
  margin: auto;
  border-radius: 50%;

  padding: 15% 0 0;
  font-weight: 500;
  letter-spacing: 0.28px;
  color: #43425d;
  opacity: 1;
}
.center-date span.scnd-font-color {
  line-height: 0;
}
.recorte {
  border-radius: 50%;
  clip: rect(0px, 0px, 0px);
  height: 100%;
  position: absolute;
  width: 100%;
}
.cake {
  border-radius: 50%;
  clip: rect(0px, 200px, 100px, 0px);
  height: 100%;
  position: absolute;
  width: 100%;
  font-family: monospace;
  font-size: 1.5rem;
}
#part1 {
  transform: rotate(0deg);
}

#part1 .cake {
  background-color: #ebf4fd;
  transform: rotate(76deg);
}
#porcion2 {
  transform: rotate(76deg);
}
#porcion2 .cake {
  background-color: #c1dbfb;
  transform: rotate(180deg);
}

#porcionFin {
  transform: rotate(180deg);
}
#porcionFin .cake {
  background-color: #43425d;
  transform: rotate(180deg);
}
.nota-final {
  clear: both;
  color: #4fc4f6;
  font-size: 1rem;
  padding: 2rem 0;
}
.nota-final strong {
  color: #e64c65;
}
.nota-final a {
  color: #fcb150;
  font-size: inherit;
}

.noROwM .row{
    margin-right: 0px !important;
    margin-left: 0px !important;
}
.noROwM .container{
  padding-left: 0px !important;
   padding-right: 0px !important;
}


</style>