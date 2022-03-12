<template>
  <div>
    <v-card-title>
      Transactions
      
      <div class="flex-grow-1"></div>
      Marketing Reports
      <v-btn icon @click="downloadExcel">
        <v-icon color="purple" large class="cursor-pointer">mdi-file-excel</v-icon>
      </v-btn>
    </v-card-title>
    <div style="padding: 16px 16px 8px">
      <List v-if="!item" :edit-item="editItem" :delete-item="deleteItem" />
      <Form v-else :item="item" :submit="submit" :cancel="cancel" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Form from "../components/Transaction/Form";
import List from "../components/Transaction/List";

export default {
  data() {
    return {
      store: "transaction",
      item: null
    };
  },
  components: {
    List,
    Form
  },
  computed: {
    ...mapGetters({
      categories: "category/items"
    })
  },
  methods: {
    downloadExcel() {
      window.open(
        "/admin/transaction-cvs"
      );
    },
    editItem(item) {
      this.item = item;
    },
    deleteItem(item) {
      if (confirm("Are you sure want to delete")) {
        return;
        this.$store.dispatch(this.store + "/delete", item.id).then(response => {
          item.categories = item.categories.map(
            item =>
              this.categories.filter(
                item2 => item == item2.id || item.id == item2.id
              )[0]
          );
          if (response.data == "ok")
            this.$store.dispatch(this.store + "/getItems");
          this.item = null;
        });
      }
    },
    submit(item) {
      this.$store
        .dispatch(
          typeof item.id == typeof undefined
            ? this.store + "/store"
            : this.store + "/update",
          this.item
        )
        .then(response => {
          if (response.data == "ok")
            this.$store.dispatch(this.store + "/getItems");
          this.item = null;
        });
    },
    cancel() {
      this.item = null;
    }
  }
};
</script>
