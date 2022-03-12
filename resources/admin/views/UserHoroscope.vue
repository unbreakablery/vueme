<template>
  <div>
    <v-card-title>
      User Horoscope
     
      <div class="flex-grow-1"></div>
    </v-card-title>
    <div style="padding: 16px 16px 8px">
      <List v-if="!item" :delete-item="deleteItem" />
    </div>

  </div>
</template>

<script>
import List from "../components/Horoscopesing/ListUser";

export default {
  data() {
    return {
      store: "horoscopesign",
      item: null,
      deleteItem: null,
      errors: [],
      loading: false,
    };
  },
  components: {
    List,
  },
  
};
</script>
