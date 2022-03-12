<template>
  <div>
    <v-card-title>
      <div class="flex-grow-1"></div>
    </v-card-title>
    <div style="padding: 16px 16px 8px">
      <List />
    </div>
  </div>
</template>

<script>
import List from "../components/Service/List";

export default {
  data() {
    return {
      store: "service",
      item: null
    };
  },
  components: {
    List
  },
};
</script>
