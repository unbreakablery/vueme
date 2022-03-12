<template>
  <v-container>
    <v-row>
          <v-col col="12" class="promos">
            <v-data-table
              style="padding: 10px"
              :disable-pagination="true"
              hide-default-footer
              :headers="[
              {
            text: 'Code',
            align: 'start',
            sortable: false, value: 'code'},
            {
            text: 'Credit (Purchase-Extra)',
            align: 'start',
            sortable: false, value: 'credits'},
            {
            text: 'Active',
            align: 'start',
            sortable: false, value: 'active'},
            {
            text: 'Users',
            align: 'start',
            sortable: false, value: 'users'},
            { text: '', value: 'actions', sortable: false }
            ]"
              :items="promos"
              class="elevation-1"
            >
              <template v-slot:top>
                <v-toolbar flat>
                  <div>
                    $5 Free Promo Usage:
                    <div>New users: {{newUsers}}</div>
                    <div>Old users: {{oldUsers}}</div>
                  </div>
                  <v-spacer></v-spacer>
                  <v-btn class small fab dark color="primary" @click="dialog = true">
                    <v-icon dark>mdi-plus</v-icon>
                  </v-btn>
                </v-toolbar>
              </template>
              <template v-slot:item.credits="{ item }">
                <v-row v-for="(credit,index) in item.credits" :key="index" style="max-width: 200px">
                  <v-col class="py-0">
                    <v-text-field v-model="credit.purchase" disabled></v-text-field>
                  </v-col>
                  <v-col class="py-0">
                    <v-text-field v-model="credit.extra" disabled></v-text-field>
                  </v-col>
                </v-row>
              </template>
              <template v-slot:item.active="{ item }">
                <v-checkbox v-model="item.active" @change="setPromoStatus(item)" label="Active"></v-checkbox>
              </template>
              <template v-slot:item.actions="{ item }">
                <td style="max-width:200px">
                  <v-btn icon>
                    <v-icon color="teal" class="mr-2" @click="editItem = item">mdi-pencil</v-icon>
                  </v-btn>
                  <v-btn icon>
                    <v-icon color="red" class="mr-2" @click="remove(item)">mdi-delete</v-icon>
                  </v-btn>
                </td>
              </template>
            </v-data-table>
          </v-col>
        </v-row>

    <v-dialog v-model="dialog" max-width="700px">
      <v-card>
        <v-card-title>
          <span class="headline">{{editItem.id ? 'Edit' : 'Create'}} Promo</span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-form ref="promos">
              <v-row>
                <v-col cols="8">
                  <v-text-field v-model="editItem.code" label="Code" :rules="nameRules" required></v-text-field>
                </v-col>
                <v-col cols="4">
                  <v-checkbox v-model="editItem.active" label="Active"></v-checkbox>
                </v-col>
              </v-row>
            </v-form>
            <v-form ref="credits" v-if="editItem && editItem.credits">
              <v-row>
                <v-col cols="12" class="pb-0">Assign Credit</v-col>
                <v-col cols="5" md="3" class="pt-0">
                  <v-text-field
                    v-model="editItem.credits[0].purchase"
                    type="number"
                    label="Purchase"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="5" md="3" class="pt-0">
                  <v-text-field
                    v-model="editItem.credits[0].extra"
                    type="number"
                    label="Extra"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                </v-col>
                <!-- <v-col cols="2" class="d-flex align-center pt-0">
                  <v-btn class x-small fab dark color="primary" @click="addCredit">
                    <v-icon dark>mdi-plus</v-icon>
                  </v-btn>
                </v-col> -->
              </v-row>
            </v-form>
            <!-- <v-row v-for="(credit,index) in credits" :key="index">
              <v-col cols="5" md="3" class="pt-0">
                <v-text-field v-model="credit.purchase" disabled></v-text-field>
              </v-col>
              <v-col cols="5" md="3" class="pt-0">
                <v-text-field v-model="credit.extra" disabled></v-text-field>
              </v-col>
              <v-col cols="2" class="d-flex align-center pt-0">
                <v-btn class icon dark @click="credits.splice(index, 1)">
                  <v-icon dark color="red">mdi-delete</v-icon>
                </v-btn>
              </v-col>
            </v-row> -->
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="save()" :loading="loading">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";
import { requireField } from "../util";
import axios from "axios";

export default {
  data() {
    return {
      valid: true,
      nameRules: requireField,
      loading: false,
      promos: [],
      dialog: false,
      editItem: {},
      purchase: null,
      extra: null,
      credits: [],
      newUsers: 0,
      oldUsers: 0
    };
  },
  watch: {
    editItem(val) {
      if (val.id) {
        this.dialog = true;        
        // this.credits = this.editItem.credits;
        if(!this.editItem.credits)
         this.editItem.credits = [{purchase: null, extra: null}];
      }
      
    },
    dialog(val) {
      if (!val) {
        this.editItem = {};
        // this.credits = [];
        // this.purchase = this.extra = null;
      }
      else if(!this.editItem.credits)
         this.editItem.credits = [{purchase: null, extra: null}];
    },
  },
  methods: {
    remove(item) {
      axios
        .delete("/api/admin/promo/" + item.id)
        .then((response) => {
          this.promos = response.data.promos;
        })
        .catch(function (error) {})
        .finally(() => (this.loading = false));
    },
    setPromoStatus(item) {
      axios
        .post("/api/admin/promo", { id: item.id, active: item.active })
        .then((response) => {})
        .catch(function (error) {})
        .finally(() => (this.loading = false));
    },
    addCredit() {
      if (!this.$refs.credits.validate()) return;
      if (
        Number.isInteger(parseInt(this.purchase)) &&
        Number.isInteger(parseInt(this.extra))
      ) {
        this.credits.push({ purchase: this.purchase, extra: this.extra });
        this.credits.sort((a, b) => {
          if (a.purchase > b.purchase) return 1;
          else return -1;
          return 0;
        });
        this.$refs.credits.reset();
      }
    },
    save() {
      if (!this.$refs.promos.validate()) return;

      this.loading = true;

      // this.editItem.credits = this.credits;

      axios
        .post("/api/admin/promo", this.editItem)
        .then((response) => {
          this.promos = response.data.promos;
          this.dialog = false;
        })
        .catch(function (error) {})
        .finally(() => (this.loading = false));
    },
  },
  created() {
    axios
      .get("/api/admin/promos")
      .then((response) => {
        this.promos = response.data.promos;
        this.newUsers = response.data.new;
        this.oldUsers = response.data.old;
      })
      .catch(function (error) {});
  },
};
</script>

<style>
.promos table td {
  padding: 15px 8px !important;
}
</style>
