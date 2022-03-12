<template>
  <div>
    <v-card-title>
      Specialties
      <v-btn
        v-show="!item"
        class="mx-2"
        fab
        dark
        small
        color="primary"
        @click="item = {}"
      >
        <v-icon dark>mdi-plus</v-icon>
      </v-btn>
      <div class="flex-grow-1"></div>
    </v-card-title>
    <div style="padding: 16px 16px 8px">
      <List v-if="!item" :delete-item="deleteItem" :edit="edit" />

      <div v-else>
        <div>
          <v-row>
            <v-col>
              <v-form ref="form" lazy-validation>
                <div class="row">
                  <div
                    class="col col-md-1 d-flex align-center"
                    style="max-width: 100px"
                  >
                    <input
                      id="input-143"
                      type="color"
                      v-model="item.color"
                      style="width: 100%; height: 45px; cursor: pointer"
                    />
                  </div>
                  <div class="col col-md-4">
                    <v-text-field
                      v-model="item.name"
                      label="Name"
                      single-line
                    ></v-text-field>
                  </div>
                  <div class="col-12">
                    <v-textarea
                      outlined
                      v-model="item.description"
                      label="Description"
                    ></v-textarea>
                  </div>
                </div>
              </v-form>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="d-flex justify-end">
              <v-btn color="primary" @click="item = null"
                >Back to the list</v-btn
              >
              <v-btn class="ml-3" color="primary" @click="save()">save</v-btn>
            </v-col>
          </v-row>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import List from "../components/Category/List";

import { requireField } from "../util";
import axios from "axios";

import { mapGetters } from "vuex";

export default {
  data() {
    return {
      store: "category",
      item: null,
      nameRules: requireField,
      loadingOrderUpdate: false,
    };
  },
  components: {
    List,
  },
  computed: {
    ...mapGetters({
      items: "category/items",
    }),
  },
  methods: {
    // resetOrder(){
    //   axios
    //     .post("/api/admin/category", { order: true, category: this.item.id })
    // },
    deleteItem(item) {
      if (confirm("Are you sure want to delete")) {
        this.$store
          .dispatch(this.store + "/delete", {
            id: item.id,
            delete: true,
          })
          .then((response) => {
            this.$store.dispatch(this.store + "/getItems"); 
          });
      }
    },

    edit(item) {
      this.item = item;
    },
    save() {
      console.log(this.item);
      if (!this.$refs.form.validate()) return;
      this.$store
        .dispatch(this.store + "/update", {
          id: this.item.id || "",
          name: this.item.name,
          description: this.item.description,
          color: this.item.color,
        })
        .then((response) => {
          this.$store.dispatch(this.store + "/getItems");
          item = null;
        });
    },
    // order(item, order = 'up') {
    //   if(this.loadingOrderUpdate) return;

    //   this.loadingOrderUpdate = true;

    //     axios
    //     .post("/api/admin/category", {
    //       id: item.id,
    //       order: order == 'up' ? item.order - 1 : item.order + 1
    //     })
    //     .then(() => {

    //       const index = this.item.categories.indexOf(item), index2 = order == 'up' ? index - 1 : index + 1;

    //       const item2 = this.item.categories[ index2 ];

    //       item.order = order == 'up' ? item.order - 1 : item.order + 1
    //       item2.order = order == 'up' ? item.order + 1 : item.order - 1;

    //       this.$set(this.item.categories, index2, item);
    //       this.$set(this.item.categories, index, item2);

    //     }).finally(() => this.loadingOrderUpdate = false);
    // },
  },
};
</script>
