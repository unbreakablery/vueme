<template>
  <div class="model-referrals">
    <h1 class="title mb-2">Referrals</h1>
    <p class="desc mb-10">You receive 5% commission on all income earned by any user who joins Respectfully via your referral URL.</p>
    <div class="referral-card">
      <div class="referral-earnings">
        <h2>Current Referral Earnings</h2>
        <!--<h2>$1,232.00</h2>-->
        <h2>$0.00</h2>
      </div>
      <div class="referral-url">
        <div class="personal-url">
          <h4>Your Personal Referral URL</h4>
          <span class="copy">Copy</span>
        </div>
        <!--<p class="url">https://respectfully.com/?ref=828192</p>-->
        <p class="url"></p>
      </div>
    </div>
    <h2 class="mb-5">Referral Earnings Statement</h2>
    <p class="mb-0">Referral earnings will be added to your weekly earnings total under <span>Money > Payout History</span>.</p>
    <p-referral-earnings></p-referral-earnings>
    <h2 class="mb-0 mt-5">Your Referrals</h2>
    <p-your-referrals class="mb-8"></p-your-referrals>
  </div>
</template>

<style lang="scss">
.model-referrals {
  padding: 48px 38px;
  max-width: 861px;
  .title {
    font-size: 24px!important;
    color: #42424D;
    line-height: 26px;
    font-weight: 500;
    font-family: "Montserrat", sans-serif!important;
    @media(max-width: 500px) {
      font-size: 20px!important;
    }
  }
  .desc {
    font-size: 14px;
    color: #131220;
    font-weight: 500;
    line-height: 20px;
  }
  .referral-card {
    border: 1px solid #DADADA;
    border-radius: 6px;
    margin-bottom: 43px;
    @media(max-width: 500px) {
      margin-bottom: 25px;
    }
    .referral-earnings {
      display: flex;
      justify-content: space-between;
      padding: 20px 16px;
      background-color: rgba(247, 127, 152, .4);
      border-top-left-radius: 6px;
      border-top-right-radius: 6px;

      h2 {
        font-size: 18px;
        font-weight: 600;
        color: #131220;
        line-height: 26px;
        margin-bottom: 0px;
        @media(max-width: 500px) {
          font-size: 16px!important;
        }
      }
    }
    .referral-url {
      padding: 16px;
      background-color: #FFFFFF;
      border-bottom-left-radius: 6px;
      border-bottom-right-radius: 6px;
      .personal-url {
        display: flex;
        justify-content: space-between;
        margin-bottom: 14px;
        h4 {
          font-size: 12px;
          font-weight: 600;
          color: #131220;
          margin-bottom: 0;
          line-height: 26px;
        }
        .copy {
          font-size: 14px;
          font-weight: 700;
          color: #F77F98;
          line-height: 18px;
          cursor: pointer;
        }
      }
      .url {
        line-height: 18px;
        font-size: 14px;
        color: #1F1E34;
        font-weight: 500;
        margin-bottom: 0;
      }
    }
  }
  h2 {
    font-size: 18px !important;
    color: #131220;
    line-height: 26px;
    font-weight: 600;
    @media(max-width: 500px) {
      font-size: 16px!important;
    }
  }
  p {
    font-size: 14px;
    color: #1F1E34;
    font-weight: 500;
    line-height: 24px;
    span {
      color: #F77F98;
    }
  }
  @media(max-width: 500px) {
    padding: 20px;
  }
}
</style>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {

    };
  },
  props: ["user"],
  mounted() {

  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },

  methods: {
  },
};
</script>