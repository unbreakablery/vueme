<template>
  <div>
    <v-card-title>
      Users
      <div class="flex-grow-1"></div>
    </v-card-title>
    <div style="padding: 16px 16px 8px">
      <List v-show="!item" :edit-item="editItem" :delete-item="deleteItem" :key="refreshList" />
      <Form
        v-if="item"
        :item="item"
        :submit="submit"
        :cancel="cancel"
        :country_all="country_all"
      />
    </div>

    <v-snackbar color="warning" top v-model="snackbar">
      {{ snackbarText }}
    </v-snackbar>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Form from "../components/User/Form";
import List from "../components/User/List";
import axios from "axios";

export default {
  data() {
    return {
      store: "user",
      item: null,
      snackbarText: null,
      snackbar: null,
      refreshList: false
    };
  },
  components: {
    List,
    Form,
  },
  computed: {
    ...mapGetters({
      categories: "category/items",
    }),
  },
  methods: {
    editItem(item) {
      this.item = item;
    },
    deleteItem(item) {
      if (confirm("Are you sure want to delete")) {
        this.$store
          .dispatch(this.store + "/delete", item.id)
          .then((response) => {

            if (response.data == "deleted") {
              this.snackbarText =
                "User deleted.";
              this.snackbar = true;
              this.refreshList = !this.refreshList;
            }
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
        .then((response) => {
          if (response.data.profile_link) {
            this.snackbarText =
              "The profile link is in use. Please choose another.";
            this.snackbar = true;
            return;
          }
          if (response.data == "ok")
            this.$store.dispatch(this.store + "/getItems");
          this.item = null;
        });
    },
    cancel() {
      this.item = null;
    },
  },
  created() {
    axios
      .get("/api/admin/countries")
      .then((response) => {
        this.country_all = response.data;
      })
      .catch((e) => {
        console.log(e);
      });
  },
};
</script>
