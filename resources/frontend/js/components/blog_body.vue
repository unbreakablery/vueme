<template>
  <div>
    <div class="row">
      <div class="col-lg-12 col-12" v-if="!full">
        <div style="margin-bottom: 5px">
          <div
            v-if="post.post_body.length > 100"
            v-html="post.post_body.substring(0, 100)"
          ></div>
          <div v-else v-html="post.post_body"></div>
        </div>
        <a
          class="cursor-pointer"
          style="color: #3b3952; font-weight: 600; font-size: 12px"
          v-bind:href="'/blog/' + post.slug"
          >...read more</a
        >
      </div>
      <div class="col-lg-12 col-12" v-else>
        <div v-html="post.post_body"></div>
      </div>
    </div>
    <!-- <span>{{post.post_body}}</span>-->
  </div>
</template>

<script>
export default {
  props: ["post", "full"],
};
</script>


