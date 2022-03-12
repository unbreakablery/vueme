<template>
  <div>
    <v-card-title>
      Payouts
      <div class="flex-grow-1"></div>
      <v-menu
        v-model="menu"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        min-width="290px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            clearable
            style="max-width: 160px"
            v-model="computedMomentDate"
            label="Period start"
            prepend-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker :max="today" :allowed-dates="allowedDates" v-model="date" @input="menu = false"></v-date-picker>
      </v-menu>
      <v-text-field
        style="max-width: 150px"
        v-model="date2"
        disabled
        label="Period end"
        prepend-icon="mdi-calendar"
        readonly
      ></v-text-field>
      <v-btn icon :disabled="!date" @click="downloadExcel">
        <v-icon color="purple" large class="cursor-pointer" >mdi-file-excel</v-icon>
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
import Form from "../components/Payout/Form";
import List from "../components/Payout/List";
import moment from "moment";

export default {
  data() {
    return {
      store: "payout",
      item: null,
      date: null,
      date2: null,
      menu: null,
      today: new Date().toISOString().substr(0, 10),
    };
  },
  components: {
    List,
    Form
  },
  computed: {
    ...mapGetters({
      categories: "category/items"
    }),
    computedMomentDate: {
      get() {
        if (this.date) {
          this.date2 = moment(this.date)
            .add(6, "days")
            .format("MM/DD/Y");
          return moment(this.date).format("MM/DD/Y");
        }
        return null;
      },
      set(val) {
        if (!val) this.date = this.date2 = null;
      }
    }
  },
  methods: {
    downloadExcel() {
        window.open(`/admin/payout-cvs?date=${this.date}`);
    },
    allowedDates: val => {
      return moment(val).day() == 1;
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
