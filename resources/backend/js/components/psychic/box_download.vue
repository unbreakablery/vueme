<template>
  <div class="col-4 p-0 m-0">
    <div class="boxDownload" :style="'margin:' + margin">
      <div class="boxDownloadTitle"></div>
      <div class="boxDownloadTitleText">Download</div>
    </div>
  </div>
</template>
                              



<script>
import { mapGetters } from "vuex";

export default {
  data: function () {
    return {};
  },
  props: ["link", "margin"],
  mounted() {},
};
</script>

<style>
.boxDownload {
  width: 105px;
  height: 105px;
  background: #c1dbfb;
  border-radius: 5px;
  opacity: 1;
}
.boxDownloadTitle {
  background: #43425d;
  opacity: 0.5;
  height: 45px;
  bottom: 0px;
  position: absolute;
  width: 105px;
  border-radius: 0px 0px 5px 5px;
}
.boxDownloadTitleText {
  text-align: center;
  font-size: 14px;
  letter-spacing: 0.28px;
  color: #f4f4f4;
  opacity: 1;
  bottom: 6px;
  position: absolute;
  width: 105px;
  font-weight: 500;
}
</style>
