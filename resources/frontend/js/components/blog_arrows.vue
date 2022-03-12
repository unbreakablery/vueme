<template>
  <!-- <div class="row" style="margin-bottom: 15px; min-height: 34px">
    <div v-if="fetched" class="col-md-6" style="text-align: left">
      <a
        v-if="prevSlug !== false"
        :href="prevSlug !== false ? '/blog/' + prevSlug : ''"
      >
        <v-icon color="#97999D" size="34">mdi-chevron-left</v-icon>
        <p style="color: #1f1e3499; display: inline; margin-left: 0px">Back</p>
      </a>
      <div v-else class="disabled-link">
        <v-icon color="#97999D" size="34">mdi-chevron-left</v-icon>
        <p style="color: #1f1e3499; display: inline; margin-left: 0px">Back</p>
      </div>
    </div>
    <div v-if="fetched" class="col-md-6" style="text-align: right">
      <a
        v-if="nextSlug !== false"
        :href="nextSlug !== false ? '/blog/' + nextSlug : ''"
      >
        <p style="color: #1f1e3499; display: inline; margin-right: 0px">Next</p>
        <v-icon color="#97999D" size="34">mdi-chevron-right</v-icon>
      </a>
      <div v-else class="disabled-link">
        <p style="color: #1f1e3499; display: inline; margin-right: 0px">Next</p>
        <v-icon color="#97999D" size="34">mdi-chevron-right</v-icon>
      </div>
    </div>
  </div> -->
  <div style="width: 100%; height: 40px; position: absolute; bottom: 0">
    <div class="row" style="height: 40px">
      <div class="col-6 d-flex align-center justify-content-start">
        <a
          class="d-flex align-center justify-content-end"
          style="text-decoration: none"
          :href="prevSlug !== false ? '/blog/' + prevSlug : '/blog'"
        >
          <img width="30" src="/images/site-images/Chevron_Blue_left.png" />
          <span style="color: #8ebef8; font-weight: 600" class="ml-3"
            >Back</span
          >
        </a>
      </div>
      <div class="col-6 d-flex align-center justify-content-end">
        <a
          class="d-flex align-center justify-content-end"
          style="text-decoration: none"
          v-if="nextSlug !== false"
          :href="nextSlug !== false ? '/blog/' + nextSlug : ''"
        >
          <span style="color: #8ebef8; font-weight: 600" class="mr-3"
            >Next</span
          >
          <img width="30" src="/images/site-images/Chevron_Blue_rigth.png" />
        </a>
      </div>
    </div>
  </div>
</template>  
<script>
export default {
  data: () => ({
    fetched: false,
    nextSlug: false,
    prevSlug: false,
  }),
  props: ["post"],
  methods: {
    get_next_and_prev_post() {
      axios
        .get("/api/v1/blog/get_post_next_and_prev?post_id=" + this.post.id)
        .then((response) => {
          this.nextSlug = response.data.next;
          this.prevSlug = response.data.prev;
          this.fetched = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.get_next_and_prev_post();
  },
};
</script>
<style>
.disabled-link {
  opacity: 0;
  text-decoration: none;
}
</style>