<template>
  <div class="noROwM">
    <v-row>
      <v-col
        :cols="mobile ? 12 : 6"
        class="px-0 pt-0"
        :style="!mobile ? 'padding-right: 5px !important' : ''"
      >
        <v-container
          class="mx-0 pt-0 pr-0"
          :style="mobile ? 'padding-bottom: 20px !important' : ''"
        >
          <v-card class="justify-content-between pl-0 pt-1 pb-1 pr-0">
            <div class="form-row mb-0 ml-0 mr-0">
              <div class="col-12 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">Invite URL</span>
                <p
                  class="sfProfileLinkText"
                  style="margin-top: 20px !important"
                >
                  <v-text-field
                    background-color="#C1DBFB"
                    solo
                    flat
                    dense
                    disabled
                    filled
                    hide-details
                    class="sfInputClass blueLink"
                        style="max-width: 100% !important;"
                    v-model="url_copy"
                  ></v-text-field>
                </p>
                <p
                  class="col-12 pr-0 sfButtonAction"
                  @click="copyUrl()"
                  :style="'opacity:' + opacityCopy + ' !important;'"
                >
                  {{ copy_text
                  }}<i class="far fa-clone" style="margin-left: 10px"></i>
                </p>
              </div>
            </div>
          </v-card>
        </v-container>

        <v-container
          class="mx-0 pt-0 pr-0"
          :style="mobile ? 'padding-bottom: 20px !important' : ''"
        >
          <v-card class="justify-content-between pl-0 pt-0 pb-1 pr-2">
            <div class="form-row mb-0 ml-0 mr-0">
              <div class="col-12 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">Share Invite URL</span>
                <div
                  class="sfProfileText"
                  style="
                    margin-top: 20px !important;
                    margin-bottom: 20px !important;
                  "
                >
                  <div class="d-flex">
                    <v-tooltip bottom class="ml-2">
                      <template v-slot:activator="{ on }">
                        <a
                          v-on="on"
                          @click.stop="share('facebook')"
                          class="primary--text"
                        >
                          <i class="fab ico-profile-facebook"></i>
                        </a>
                      </template>
                      <span>Share on Facebook</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                      <template v-slot:activator="{ on }">
                        <a
                          v-on="on"
                          @click.stop="share('linkedin')"
                          class="primary--text"
                        >
                          <i class="fab ico-profile-linkedin-h ml-5"></i>
                        </a>
                      </template>
                      <span>Share on LinkedIn</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                      <template v-slot:activator="{ on }">
                        <a
                          v-on="on"
                          @click.stop="share('twitter')"
                          class="primary--text"
                        >
                          <i class="fab ico-profile-twitter ml-5"></i>
                        </a>
                      </template>
                      <span>Share on Twitter</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                      <template v-slot:activator="{ on }">
                        <a
                          v-on="on"
                          @click.stop="copyUrl()"
                          class="primary--text"
                        >
                          <i class="fas ico-profile-link ml-5"></i>
                        </a>
                      </template>
                      <span>Copy URL</span>
                    </v-tooltip>
                  </div>
                </div>
                <span class="col-12 pl-0" style="margin-top: 20px"
                  >Email Invite URL</span
                >

                <p class="sfProfileText" style="margin-top: 20px !important">
                  Invite clients, friends and family who are new to Respectfully
                  via email. We’ll even send them a reminder automatically.
                </p>
                <v-text-field
                  label="Email"
                  solo
                  flat
                  dense
                  filled
                  hide-details
                  v-model="referral_email"
                  class="sfInputClass"
                  style="max-width: 100% !important;"
                  prepend-icon="far fa-envelope ico-format"
                ></v-text-field>
                <span v-if="errors.referral_email" class="float-left text-danger small">
                  {{ errors.referral_email[0] }}
                </span>

                <p
                  class="col-12 pr-0 sfButtonAction"
                  style="margin-top: 11px"
                  @click="sendEmail()"
                  :style="'opacity:' + opacitySendEmail + ' !important;'"
                >
                  {{ sendEmail_text
                  }}<i class="far fa-envelope" style="margin-left: 10px"></i>
                </p>
              </div>
            </div>
          </v-card>
        </v-container>
      </v-col>
      <v-col
        :cols="mobile ? 12 : 6"
        class="px-0 pt-0"
        style="padding-left: 5px !important"
      >
        <v-container class="mx-0 pt-0 pl-0">
          <v-card class="justify-content-between pl-0 pt-1 pb-1 pr-2">
            <div class="form-row mb-0 ml-0 mr-0">
              <div class="col-12 subtitle-1 m-0 p-0">
                <span class="col-12 pl-0">Sharable Graphics Library</span>
                <p class="sfProfileText" style="margin-top: 20px !important">
                  Download your favorite images and post on social media with
                  your Invite URL. Be sure to tag @respectfully with your posts!
                </p>

                <p class="sfProfileTextSub">Instagram Graphics</p>
                <div class="form-row subtitle-1 m-0 p-0">
                  <box-download link=""></box-download>
                  <box-download link="" margin="0px 0px"></box-download>
                  <box-download link=""></box-download>
                </div>
                <p class="sfProfileTextSub">Facebook Graphics</p>
                <div class="form-row subtitle-1 m-0 p-0" style="display: flex">
                  <box-download link=""></box-download>
                  <box-download link="" margin="0px 0px"></box-download>
                  <box-download link=""></box-download>
                </div>
                <p class="sfProfileTextSub">Twitter Graphics</p>
                <div class="form-row subtitle-1 m-0 p-0" style="display: flex">
                  <box-download link=""></box-download>
                  <box-download link="" margin="0px 0px"></box-download>
                  <box-download link=""></box-download>
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
    return {
      url_copy: "respectfully.com/join/" + this.user.userProfile.profile_link,
      referral_email: "",
      copy_text: "Copy",
      opacityCopy: 1,
      sendEmail_text: "Send",
      opacitySendEmail: 1,
      errors: [],
    };
  },
  props: ["user"],

  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },

  methods: {
    copyUrl() {
      const str = "https://www." + this.url_copy;
      const el = document.createElement("textarea");
      el.value = str;
      document.body.appendChild(el);
      el.select();
      document.execCommand("copy");
      document.body.removeChild(el);
      this.copy_text = "Copied";
      this.opacityCopy = 0.5;
    },
    sendEmail() {
      axios
        .post("/api/v1/user/referral/send", "referral_email=" + this.referral_email)
        .then((response) => {
          if (response.status == 200) {
            this.sendEmail_text = "Sent";
            this.opacitySendEmail = 0.5;
            this.errors = "";
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });
    },
    share(type) {
      this.dialog = false;
      var top = window.screen.height - 400;
      top = top > 0 ? top / 2 : 0;

      var left = window.screen.width - 400;
      left = left > 0 ? left / 2 : 0;

      if (type == "facebook") {
        window.open(
          "https://www.facebook.com/sharer/sharer.php?u=https://dev." +
            this.url_copy,
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      } else if (type == "twitter") {
        window.open(
          "https://twitter.com/share?url=https://dev." + this.url_copy,
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      } else if (type == "linkedin") {
        window.open(
          "https://www.linkedin.com/shareArticle?mini=true&url=https://dev." +
            this.url_copy,
          "width=500,height=500,top=" + top + ",left=" + left + ""
        );
      }
    },
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
</style>
