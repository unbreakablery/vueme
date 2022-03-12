<template>
  <div>
    <v-row>
      <v-col cols="12" class="px-0 pt-0">
        <v-container class="mx-0 mt-0 pt-0 pr-0" style="padding-bottom: 20px;">
          <v-card class="justify-content-between  mt-0 pl-0 pt-1 pb-1 pr-0">
            <div class="form-row mb-0">
              <div class="col-12 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">Cosmic Rewards Referral Program</span>
                <p class="sfProfileText" style="margin-top: 20px !important">
                  Collect Cosmic Credits for every new client you refer to
                  Respectfully. Cash in your credits for rewards like “Top
                  Model” profile badges, a permanent featured position on the
                  homepage, or your own personal advertising campaign paid for
                  by Respectfully!
                </p>
              </div>
            </div>
            <div
              v-if="!mobile"
              class="form-row mb-0"
              style="margin-top: 20px !important"
            >
              <div class="col-6 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">Cosmic Rewards Referral Program</span>
                <p class="sfProfileText" style="margin-top: 20px !important">
                  You’ll earn Cosmic Credits each time a referral makes a
                  qualifying first purchase.
                </p>
              </div>
              <div class="col-6 subtitle-1 m-0 p-0" style="display: flex">
                <box-rewards
                  status="off"
                  :value="100"
                  positionbox="first"
                  :marginbox="15"
                  title="Referral Spends $35"
                ></box-rewards>
                <box-rewards
                  status="off"
                  :value="150"
                  positionbox="middle"
                  :marginbox="15"
                  title="Referral Spends $50"
                ></box-rewards>
                <box-rewards
                  status="off"
                  :value="200"
                  positionbox="middle"
                  :marginbox="15"
                  title="Referral Spends $75"
                ></box-rewards>
                <box-rewards
                  status="off"
                  :value="250"
                  positionbox="last"
                  :marginbox="15"
                  title="Referral Spends $100"
                ></box-rewards>
              </div>
            </div>
          </v-card>
        </v-container>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" class="px-0">
        <v-container class="mx-0 pt-0 pr-0 pb-0">
          <v-card class="justify-content-between m-0 pl-0 pt-1 pb-1 pr-0">
            <div class="form-row m-0">
              <div v-if="!mobile" class="col-12 subtitle-1 m-0 p-0">
                <div class="form-row m-0">
                  <span class="col-12 pl-0">How It Works</span>
                </div>
                <div class="form-row m-0" style="margin-top: 20px !important">
                  <div
                    :class="mobile ? 'col-12' : 'col-6'"
                    class="subtitle-1 m-0 p-0"
                    :style="
                      !mobile ? 'padding-right: 30px !important' : 'order: 0'
                    "
                  >
                    <span class="col-12 pl-0">
                      <img
                        src="/images/icons/email_square.svg"
                        style="margin-right: 10px"
                      />
                      Invite Clients
                    </span>

                    <p class="sfProfileText" style="margin-top: 10px">
                      Refer clients, friends and family to sign up through your
                      personal invite link.
                    </p>
                  </div>
                  <div
                    :class="mobile ? 'col-12' : 'col-6'"
                    class="col-6 subtitle-1 m-0 p-0"
                    :style="
                      !mobile ? 'padding-left: 30px !important' : 'order: 1'
                    "
                  >
                    <span class="col-12 pl-0">
                      <img
                        src="/images/icons/gift _card_square.svg"
                        style="margin-right: 10px"
                      />
                      Referral Perks
                    </span>

                    <p class="sfProfileText" style="margin-top: 10px">
                      Anyone who joins Respectfully using your link will receive
                      up to $10 free with first qualifying purchase!
                    </p>
                  </div>
                </div>

                <div class="col-12 subtitle-1 m-0 p-0">
                  <div
                    class="form-row m-0"
                    :style="!mobile ? 'margin-top: 20px !important' : ''"
                  >
                    <div
                      :class="mobile ? 'col-12' : 'col-6'"
                      class="subtitle-1 m-0 p-0"
                      :style="!mobile ? 'padding-right: 30px !important' : ''"
                    >
                      <span class="col-12 pl-0">
                        <img
                          src="/images/icons/promote_square.svg"
                          style="margin-right: 10px"
                        />
                        Share on Social
                      </span>

                      <p class="sfProfileText" style="margin-top: 10px">
                        Post your invite link on social media, websites, blogs,
                        or anywhere clients can find you.
                      </p>
                    </div>

                    <div
                      :class="mobile ? 'col-12' : 'col-6'"
                      class="subtitle-1 m-0 p-0"
                      :style="!mobile ? 'padding-left: 30px !important' : ''"
                    >
                      <span class="col-12 pl-0">
                        <img
                          src="/images/icons/money_square.svg"
                          style="margin-right: 10px"
                        />
                        Earn Fee-Free
                      </span>

                      <p class="sfProfileText" style="margin-top: 10px">
                        Keep 100% when your referrals spend with you for 30
                        days. That’s right, referral earnings are fee-free for
                        an entire month!
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-12 subtitle-1 m-0 p-0">
                  <div
                    class="form-row m-0"
                    :style="!mobile ? 'margin-top: 20px !important' : ''"
                  >
                    <div
                      :class="mobile ? 'col-12' : 'col-6'"
                      class="subtitle-1 m-0 p-0"
                      :style="!mobile ? 'padding-right: 30px !important' : ''"
                    >
                      <span class="col-12 pl-0">
                        <img
                          src="/images/icons/track_square.svg"
                          style="margin-right: 10px"
                        />
                        Track Progress
                      </span>

                      <p class="sfProfileText" style="margin-top: 10px">
                        Keep track of your signups and completed referrals right
                        from your referral dashboard.
                      </p>
                    </div>
                    <div
                      :class="mobile ? 'col-12' : 'col-6'"
                      class="subtitle-1 m-0 p-0"
                      :style="!mobile ? 'padding-left: 30px !important' : ''"
                    >
                      <span class="col-12 pl-0">
                        <img
                          src="/images/icons/credits_square.svg"
                          style="margin-right: 10px"
                        />
                        Collect Cosmic Credits
                      </span>

                      <p class="sfProfileText" style="margin-top: 10px">
                        You’ll get Cosmic Credits each time your referrals spend
                        on Respectfully. Cash in your accumulated credits for
                        big Cosmic Rewards!
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <div v-else class="col-12 subtitle-1 m-0 p-0">
                <div class="form-row m-0">
                  <span class="col-12 pl-0">How It Works</span>
                </div>
                <div class="form-row m-0" style="margin-top: 20px !important">
                  <div
                    :class="mobile ? 'col-12' : 'col-6'"
                    class="subtitle-1 m-0 p-0"
                    :style="
                      !mobile ? 'padding-right: 30px !important' : ''
                    "
                  >
                    <span class="col-12 pl-0">
                      <img
                        src="/images/icons/email_square.svg"
                        style="margin-right: 10px"
                      />
                      Invite Clients
                    </span>

                    <p class="sfProfileText" style="margin-top: 10px">
                      Refer clients, friends and family to sign up through your
                      personal invite link.
                    </p>
                  </div>
                  <div
                    :class="mobile ? 'col-12' : 'col-6'"
                    class="subtitle-1 m-0 p-0"
                    :style="!mobile ? 'padding-right: 30px !important' : ''"
                  >
                    <span class="col-12 pl-0">
                      <img
                        src="/images/icons/promote_square.svg"
                        style="margin-right: 10px"
                      />
                      Share on Social
                    </span>

                    <p class="sfProfileText" style="margin-top: 10px">
                      Post your invite link on social media, websites, blogs, or
                      anywhere clients can find you.
                    </p>
                  </div>

                  <div
                    :class="mobile ? 'col-12' : 'col-6'"
                    class="subtitle-1 m-0 p-0"
                    :style="!mobile ? 'padding-right: 30px !important' : ''"
                  >
                    <span class="col-12 pl-0">
                      <img
                        src="/images/icons/track_square.svg"
                        style="margin-right: 10px"
                      />
                      Track Progress
                    </span>

                    <p class="sfProfileText" style="margin-top: 10px">
                      Keep track of your signups and completed referrals right
                      from your referral dashboard.
                    </p>
                  </div>

                  <div
                    :class="mobile ? 'col-12' : 'col-6'"
                    class="col-6 subtitle-1 m-0 p-0"
                    :style="
                      !mobile ? 'padding-left: 30px !important' : ''
                    "
                  >
                    <span class="col-12 pl-0">
                      <img
                        src="/images/icons/gift _card_square.svg"
                        style="margin-right: 10px"
                      />
                      Referral Perks
                    </span>

                    <p class="sfProfileText" style="margin-top: 10px">
                      Anyone who joins Respectfully using your link will receive
                      up to $10 free with first qualifying purchase!
                    </p>
                  </div>

                  <div
                    :class="mobile ? 'col-12' : 'col-6'"
                    class="subtitle-1 m-0 p-0"
                    :style="!mobile ? 'padding-left: 30px !important' : ''"
                  >
                    <span class="col-12 pl-0">
                      <img
                        src="/images/icons/money_square.svg"
                        style="margin-right: 10px"
                      />
                      Earn Fee-Free
                    </span>

                    <p class="sfProfileText" style="margin-top: 10px">
                      Keep 100% when your referrals spend with you for 30 days.
                      That’s right, referral earnings are fee-free for an entire
                      month!
                    </p>
                  </div>
                  <div
                    :class="mobile ? 'col-12' : 'col-6'"
                    class="subtitle-1 m-0 p-0"
                    :style="!mobile ? 'padding-left: 30px !important' : ''"
                  >
                    <span class="col-12 pl-0">
                      <img
                        src="/images/icons/credits_square.svg"
                        style="margin-right: 10px"
                      />
                      Collect Cosmic Credits
                    </span>

                    <p class="sfProfileText" style="margin-top: 10px">
                      You’ll get Cosmic Credits each time your referrals spend
                      on Respectfully. Cash in your accumulated credits for big
                      Cosmic Rewards!
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </v-card>
        </v-container>
      </v-col>
    </v-row>

    <v-row v-if="mobile">
      <v-col cols="12" class="px-0 pt-0">
        <v-container class="mx-0 pt-0 pr-0 pt-0" style="padding-top: 20px !important">
          <v-card class="justify-content-between m-0 pl-0 pt-0 pb-0 pr-0">
            <div class="form-row mb-0">
              <div class="col-12 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">How To Earn Cosmic Credits</span>
                <p class="sfProfileText" style="margin-top: 20px !important">
                  You’ll earn Cosmic Credits each time a referral makes a
                  qualifying first purchase.
                </p>
              </div>
              <div class="col-12 subtitle-1 m-0 p-0" style="display: flex">
                <box-rewards
                  status="off"
                  :value="100"
                  positionbox="first"
                  :marginbox="15"
                  title="Referral Spends $35"
                ></box-rewards>
                <box-rewards
                  status="off"
                  :value="150"
                  positionbox="middle"
                  :marginbox="15"
                  title="Referral Spends $50"
                ></box-rewards>
                <box-rewards
                  status="off"
                  :value="200"
                  positionbox="middle"
                  :marginbox="15"
                  title="Referral Spends $75"
                ></box-rewards>
                <box-rewards
                  status="off"
                  :value="250"
                  positionbox="last"
                  :marginbox="15"
                  title="Referral Spends $100"
                ></box-rewards>
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
