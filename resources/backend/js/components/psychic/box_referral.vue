<template>
  <div>
    <div v-if="show == 'right' && user.action == 'Invite Sent' || (show == 'right'  && user.action == 'Invite Resend')" class="col-12 m-0 pl-0 pr-0">
      <span class="col-12 pl-0">
        <img
          src="/images/icons/invite_accepted.svg"
          style="margin-right: 10px"
        />
        Invite Sent
      </span>

      <div
        class="col-12 pl-0"
        :class="mobile ? 'pr-12' : 'pr-13'"
        style="margin-top: 10px !important"
      >
        <p class="sfProfileText">
          You invited <b>{{ user.referral_email }}</b> to sign up. Tap the icon to send
          a reminder email.
        </p>

        <div v-if="user.action == 'Invite Resend' || email_true == true" style="position: absolute; bottom: -6px; right: 0px; cursor:pointer">
          <div  @click="sendEmail(user.referral_email,user.id)" class="boxRewards" style="background: #F4F4F4; box-shadow: 0px 3px 6px #0000000D; color: #43425D; opacity: .5">
            <div style="font-size: 18px; padding-top: 7px">@</div>
            <span style="opacity: 1">resent</span>
          </div>
        </div>


        <div v-if="user.action == 'Invite Sent' && email_true == false" style="position: absolute; bottom: -6px; right: 0px; cursor:pointer ">
          <div  @click="sendEmail(user.referral_email,user.id)" class="boxRewards" style="background: #c1dbfb">
            <div style="font-size: 18px; padding-top: 7px">@</div>
            <span style="opacity: 1">resend</span>
          </div>
        </div>
      </div>
    </div>

    <div v-if="show == 'left' && user.action == 'Invite Accepted'" class="col-12 m-0 pl-0 pr-0">
      <span class="col-12 pl-0">
        <img
          src="/images/icons/invite_accepted.svg"
          style="margin-right: 10px"
        />
        Invite Accepted
      </span>

      <div
        class="col-12 pl-0"
        :class="mobile ? 'pr-12' : 'pr-2'"
        style="margin-top: 10px !important"
      >
        <p class="sfProfileText">
          {{ user.user_referral.name ? user.user_referral.name : user.referral_email }} signed up with your link!
        </p>

      </div>
    </div>
  </div>
</template>
                              



<script>
import { mapGetters } from "vuex";

export default {
  data: function () {
    return {
      email_true: "",

    };
  },
  props: ["user","show"],
  mounted() {
      this.email_true = this.user.joined;


  },
    computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
    methods: {


 sendEmail(referral_email,line) {


   

      axios
        .post("/api/v1/user/referral/resend", "referral_email=" + referral_email+"&line="+line)
        .then((response) => {
          if (response.status == 200) {
            this.email_true = true;
            
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          }
        });



    },


    },
};
</script>

<style>
.boxRewards {
  width: 50px;
  height: 50px;
  box-shadow: 0px 3px 6px #0000000d;
  border-radius: 10px;
  background: #f4f4f4;
  text-align: center;
  margin: auto;
}
.boxRewards img {
  width: 27px;
  margin: auto 0;
  padding-top: 3px;
}
.boxRewards span {
  font-weight: 600 !important;
  letter-spacing: 0px;
  color: #43425d !important;

  text-align: center;
  font-size: 12px !important;
}
.boxRewardstitle {
  font-weight: 600;
  letter-spacing: 0px;
  color: #43425d;
  opacity: 0.5;
  font-size: 10px;
  line-height: 13px;
  text-align: center;
  margin-top: 15px;
}
</style>
