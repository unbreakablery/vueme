<template>
  <section class="pageBanner splash-top-section">
    <div class="container">
      <div class="row">
        <div class="bannerOverContainer">
          <div class="row">
            <div class="leftCol col-lg-5 col-12 text-center text-lg-left p-0">
              <h1>Respectfully™</h1>
              <p class="col-lg-11 px-0" >
                Welcome to a brand new platform that connects paying clients to
                the world’s best models and content creators.
              </p>
              <v-list-item class="col-lg-11 px-0 pl-lg-0 top_list_item">
                <v-list-item-avatar class="item-icon" style="border-radius: 10px !important;" size="80" tile>
                  <img src="images/icons/1112.svg" width="40" />
                </v-list-item-avatar>
                <v-card-text class="py-1">
                  <p class="font-12">Stream and engage with a limitless number of fans and monthly subscribers through our live-streaming platform as well as 1 on 1 Live chatting.</p>
                </v-card-text >
              </v-list-item>
              <v-list-item class="col-lg-11 px-0 pl-lg-0 top_list_item">
                <v-list-item-avatar class="item-icon" style="border-radius: 10px !important;" size="80" tile>
                  <img src="images/icons/1113.svg" width="40" />
                </v-list-item-avatar>
                <v-card-text class="py-1">
                  <p class="font-12">
                    Control when you want to livestream by scheduling one in advance. Notifications will be sent to all of your fans to save the date!
                  </p>
                </v-card-text>
              </v-list-item>
              <v-list-item class="col-lg-11 px-0 pl-lg-0 top_list_item">
                <v-list-item-avatar class="item-icon" style="border-radius: 10px !important;" size="80" tile>
                  <img src="images/icons/1114.svg" width="40" />
                </v-list-item-avatar>
                <v-card-text class="py-1"
                  ><p class="font-12">
                    You’ll never miss or forget to livestream with our state of the art notification system to remind you via text when a scheduled stream is coming up.
                  </p></v-card-text
                >
              </v-list-item>
              <a  class="btn-action mt-5" 
                href="javascript:void(0)"
                @click="openSignUpPopUp()"
              >
                Apply Now
              </a>
            </div>
            <div class="rightCol col-lg-7 col-12 text-center p-0">
              <img
                src="images/Banner-imgs/banner-phone.png"
                alt="Models"
                style="max-width: 100%; padding-top: 50px;"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  props: ["user", "guest"],
  data: function () {
    return {
      loading: true,
      errors: [],
      signupDialog: false,
    };
  },
  mounted() {
    this.loadUser();
  },
  ready() {
    this.loadUser();
  },

  methods: {
    openSignUpPopUp() {
      EventBus.$emit("open_sign_up", {});
    },
    loadUser() {},
  },
};
</script>
<style scoped>
.bannerOverContainer {
  margin-top: 40px;
}
.v-avatar img, .v-avatar svg, .v-avatar .v-icon, .v-avatar .v-image, .v-avatar .v-responsive__content{
  width: 40px;
  height: 40px;
}

.splash-top-section .btn-action {
  color: #fff !important;
  display: inline-block !important;
  padding: 12px 46px;
  border-radius: 9px;
  font-size: 12px;
  font-weight: 600;
  line-height: 16px; background: transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box; 
}
</style>