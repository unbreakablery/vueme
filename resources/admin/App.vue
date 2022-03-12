<template>
  <v-app v-resize="onResize">
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list dense>
        <template v-for="item in items">
          <template v-if="$can('list', item.link ? item.link : item.text)">
            <v-list-group
              value="true"
              v-if="item.children"
              :key="item.text"
              :v-model="item.model == 'email' ? email : analytic"
              :prepend-icon="item.icon"
            >
              <template v-slot:activator>
                <v-list-item-content>
                  <v-list-item-title>{{ item.text }}</v-list-item-title>
                </v-list-item-content>
              </template>
              <v-list-item
                v-for="(child, i) in item.children"
                v-if="$can('manage', child.link)"
                :key="i"
                link
                :href="child.href ? host + '/' + child.href : ''"
                @click="menuClick(child.link, child.id, child.params)"
                :id="child.id"
                class="pl-7"
              >
                <v-list-item-action v-if="child.icon">
                  <v-icon>{{ child.icon }}</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                  <v-list-item-title>{{ child.text }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-group>
            <v-list-item
              v-else
              :key="item.text"
              link
              :href="item.href ? host + '/' + item.href : ''"
              @click="menuClick(item.link, item.id)"
              :id="item.id"
            >
              <v-list-item-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>{{ item.text }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </template>
        </template>
        <v-list-item
          link
          @click="downloadExcel"
          v-if="$can('export', 'marketing')"
        >
          <v-list-item-action>
            <v-icon>mdi-file-excel</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Marketing Report</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="purple"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span class="hidden-sm-and-down">
          <a :href="host">
            <v-img
              src="/images/site-images/logo.png"
              max-width="60%"
              contain
            ></v-img>
          </a>
        </span>
      </v-toolbar-title>
      <v-spacer />
      <div class="d-inline user-avatar" icon large>
        <v-menu offset-y v-if="user">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark v-on="on">
              <v-avatar size="32px" item>
                <v-img :src="user.photo" alt="Vuetify" />
              </v-avatar>
              <div class="d-inline ml-2">{{ user.display_name }}</div>
              <v-icon right>mdi-menu-down</v-icon>
            </v-btn>
          </template>
          <v-list>
            <v-list-item>
              <v-list-item-title
                class="cursor-pointer"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
              >
                <v-icon>mdi-logout</v-icon>Log out
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-app-bar>

    <v-main>
      <div>
        <v-progress-linear
          v-show="loading"
          style="position: fixed; z-index: 100"
          indeterminate
          color="purple"
          height="6"
        ></v-progress-linear>
        <transition name="fade">
          <router-view></router-view>
        </transition>
      </div>
    </v-main>
  </v-app>
</template>

<script>
import { getImage } from "./util";
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      analytic: true,
      email: false,
      drawer: true,
      items: [
        {
          icon: "mdi-google-analytics",
          text: "Analytics",
          children: [
            {
              icon: "mdi-account-group",
              text: "Users",
              link: "analytic",
              id: "analytic/users",
              params: { section: "users" },
            },
            {
              icon: "mdi-format-list-checkbox",
              text: "Services",
              link: "analytic",
              id: "analytic/services",
              params: { section: "services" },
            },
            {
              icon: "mdi-bank-transfer",
              text: "Transactions",
              link: "analytic",
              id: "analytic/transactions",
              params: { section: "transactions" },
            },
            {
              icon: "mdi-currency-usd",
              text: "Payouts",
              link: "analytic",
              id: "analytic/payouts",
              params: { section: "payouts" },
            },
            {
              icon: "mdi-database-check",
              text: "LTV",
              link: "analytic",
              id: "analytic/ltv",
              params: { section: "ltv" },
            },
          ],
        },
        {
          icon: "mdi-account-group",
          text: "Users",
          link: "users",
          id: "users",
        },
        {
          icon: "mdi-email",
          text: "Horoscope",
          model: "HoroscopeSing",
          link: "HoroscopeSing",
          children: [
            {
              icon: "mdi-email-edit",
              text: "Week Horoscope",
              link: "HoroscopeSing",
              id: "HoroscopeSing/sing",
            },
            {
              icon: "mdi-email-edit",
              text: "User Horoscope",
              link: "UserHoroscope",
              id: "HoroscopeSing/user",
            }
          ],
        },

        {
          icon: "mdi-format-list-bulleted-type",
          text: "Specialties",
          link: "specialties",
          id: "specialties",
        },
        {
          icon: "mdi-format-list-checkbox",
          text: "Services",
          link: "services",
          id: "services",
        },
        {
          icon: "mdi-currency-usd",
          text: "Payouts",
          link: "payout",
          id: "payout",
        },
        {
          icon: "mdi-bank-transfer",
          text: "Transactions",
          link: "transaction",
          id: "transaction",
        },
        {
          icon: "mdi-message-draw",
          text: "Reviews",
          link: "review",
          id: "review",
        },
        {
          icon: "mdi-chat-outline",
          text: "Chat",
          link: "chat",
          id: "chat",
        },
        {
          icon: "mdi-gift-outline",
          text: "Promo",
          link: "promo",
          id: "promo",
        },
        {
          icon: "mdi-email",
          text: "Emails",
          model: "email",
          link: "email",
          children: [
            {
              icon: "mdi-email-edit",
              text: "Horoscope",
              link: "horoscope",
              id: "email/horoscope",
            },
            {
              icon: "mdi-email-edit",
              text: "Top Rated",
              link: "top-rated",
              id: "email/top-rated",
            },
            {
              icon: "mdi-email-edit",
              text: "Featured Model",
              link: "featured-psychic",
              id: "email/featured-psychic",
            },
          ],
        },
        {
          icon: "mdi-blogger",
          text: "Blog Admin",
          href: "blog_admin",
          id: "blog_admin",
          link: "blog"
        },
      ],
    };
  },
  computed: {
    ...mapGetters({
      loading: "util/loading",
      user: "user/view",
      host: "util/entrypoint",
    }),
  },
  async mounted() {
    this.onResize();

    await this.$store.dispatch("user/getItem", authUser);

    route = Object.values(JSON.parse(route));

    if (!this.$can("list", "all")) {
      if (this.is(this.user, "horoscope") || this.is(this.user, "blog")) /////this.selectMenuLink("email/horoscope");
       this.menuClick('HoroscopeSing', 'HoroscopeSing/sing');
      else this.selectMenuLink("users");
    } else if (typeof route != typeof undefined && route.length)
      this.$nextTick(function () {
        if (route.length == 1) {
          this.analytic = false;
          this.$router.push({ name: route[0] }, () => {});
          this.selectMenuLink(route[0]);
        } else if (route.length == 2) {
          if (route[0] == "analytic") {
            this.analytic = true;
            this.$router.push(
              { name: route[0], params: { section: route[1] } },
              () => {}
            );
          }
          if (route[0] == "email") {
            this.email = true;
            this.$router.push({ name: route[1] }, () => {});
          }

          this.selectMenuLink(route[0] + "/" + route[1]);
        }
      });
    else {
      this.$router.push(
        { name: "analytic", params: { section: "users" } },
        () => {}
      );
      this.selectMenuLink("analytic/users");
    }
  },
  methods: {
    downloadExcel() {
      window.open("/admin/marketing-cvs");
    },
    getImage: getImage,

    menuClick(link, id, params) {
      if (params) this.$router.push({ name: link, params }, () => {});
      else {
        this.analytic = false;
        this.$router.push({ name: link }, () => {});
      }
      this.selectMenuLink(id);
    },

    selectMenuLink(id) {
      let element = document.getElementsByClassName("section-active");
      if (element.length) {
        [].forEach.call(element, function (el) {
          el.classList.remove("section-active");
        });
      }
      element = document.getElementById(id);
      element.classList.add("section-active");
    },

    onResize() {
      this.$store.dispatch("util/setMobile");
    },
  },
};
</script>
<style scoped>
.v-navigation-drawer {
  z-index: 101;
}
</style>