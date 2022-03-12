<template>
  <div :style="styleDiv">
    <div
      class="boxRewards"
      :style="status == 'on' ? 'background: #C1DBFB' : 'background: #f4f4f4'"
    >
      <img
        :style="status == 'on' ? 'opacity: 1' : 'opacity: 0.5'"
        src="/images/icons/rewards.svg"
      />
      <span :style="status == 'on' ? 'opacity: 1' : 'opacity: 0.5'"
        >+{{ value }}</span
      >
    </div>
    <p class="boxRewardstitle" v-if="title">{{ title }}</p>
  </div>
</template>
                              



<script>
import { mapGetters } from "vuex";

export default {
  data: function () {
    return {
      styleDiv: "",
      margin: "margin: 0px " + this.marginbox + "px;",
    };
  },
  props: ["value", "marginbox", "positionbox", "status", "title"],
  mounted() {
    if (this.positionbox == "first")
      this.margin = " margin:0px " + this.marginbox + "px 0px 0px;";
    if (this.positionbox == "last")
      this.margin = " margin: 0px 0px 0px " + this.marginbox + "px;";

    this.styleDiv = this.margin;
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
