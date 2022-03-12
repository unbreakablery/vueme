<template>
  <div>
    
    <div style="padding: 16px 16px 8px">
      <List v-if="!item" :delete-item="deleteItem" />
    </div>
  </div>
</template>

<script>
import List from "../components/Horoscopesing/List";

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
  methods: {
    
 
  },
  created() {

  },
};
</script>
