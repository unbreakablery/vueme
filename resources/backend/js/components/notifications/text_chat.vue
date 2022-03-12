<template>
  <v-menu offset-y left>
    <template v-slot:activator="{ on }">
      <a v-if="!mobile" style="position: relative;" :href="get_full_url('/chat')">
        <!-- <i :style="{color: color, fontSize: size, lineHeight: 1,}" class="far fa-comments"></i>
               
                <span v-if="text_chat_notifications" style="position: absolute;
                  margin-left: -15px;"
        class="badge badge-blue badge-pill text_notifications">{{ text_chat_notifications }}</span>-->

        <div>
          <img :src="get_full_url('icon_notification_desktop')" />
        </div>
      </a>
      <!-- 
              <v-btn v-on="on" v-if="!mobile" style="position: relative;" :href='get_full_url("/chat")'>
                  <img :src="get_full_url('icon_notification_desktop')" />
      </v-btn>-->

      <v-btn v-else text icon color="white" :href="get_full_url('/chat')">
        <img :src="get_full_url('icon_notification_mobile')" />
      </v-btn>
    </template>
    <!-- <v-card style="max-height: 50vh;">
            <v-list dense>
                
                <v-list-item class="d-flex justify-center">
                    <a href="/chat" class="text--black" style="color: black" >View All</a>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item @click="f_load_chat(user_nottification.id)" dense v-for="(user_nottification, index) in users_notifications" :key="user_nottification.id"
                >

                    <div class="user_avatar_sm" :style="{ 'background-image': 'url(' + user_nottification.profile_headshot_url  + ')' }">

                    </div>
                    <div class="px-3">{{user_nottification.show_name}}</div>
                    <span v-if="user_nottification.unread_messages > 0"
                          class="badge badge-blue badge-pill">{{ user_nottification.unread_messages }}</span>


                </v-list-item>

            </v-list>
    </v-card>-->
  </v-menu>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["user", "color", "size"],
  data: function () {
    return {
      text_chat_notifications: 0,
      on_chat: false,
      users_notifications: [],
    };
  },
  mounted() {
    this.$root.$on(
      "header_remove_notification_user-" + this.user.id,
      (data) => {
        const index = this.users_notifications.findIndex(
          (e) => e.id === data.id
        );
        if (index !== -1) {
          this.users_notifications.splice(index, 1);
        }
      }
    );
    this.$root.$on("on_chat-" + this.user.id, (data) => {
      this.on_chat = data.on_chat;
    });
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  created() {
    /* Chat notifications*/
    this.f_get_notifications();
    Echo.private("privatechat." + this.user.id)
      .listen("MessageChatAddNotifications", (data) => {
        if (!this.on_chat) {
          const index = this.users_notifications.findIndex(
            (e) => e.id === data.user.id
          );
          let user = data.user;
          if (index === -1) {
            user.unread_messages = 1;
            this.users_notifications.push(user);
          } else {
            user.unread_messages =
              this.users_notifications[index].unread_messages + 1;
            this.users_notifications.splice(index, 1, user);
          }
        }
        this.on_chat = false;
        //this.$refs.audioElm.play();
      })
      .listen("MessageChatRemoveNotifications", (data) => {
        //this.text_chat_notifications = data.notifications;
        this.on_chat = false;
      });
    /* End Chat notifications*/
  },
  watch: {
    users_notifications: function () {
      this.f_get_total_notifications();
    },
  },
  methods: {
    f_load_chat(id) {
      location.href = "/chat?user=" + id;
    },
    f_get_total_notifications() {
      this.text_chat_notifications = 0;
      for (let i = 0; i < this.users_notifications.length; i++) {
        this.text_chat_notifications += this.users_notifications[
          i
        ].unread_messages;
      }
    },

    f_get_notifications() {
      axios.get("/api/v1/user/chat/notifications").then((res) => {
        this.users_notifications = res.data.data;
      });
    },
    get_full_url(path) {
      if (path == "icon_notification_mobile") {
        if (this.text_chat_notifications > 0) {
          if (window.location.pathname == "/chat") {
            return window.location.origin + "/images/icons/chat-current-on.svg";
          }
          return window.location.origin + "/images/icons/chat-white-on.svg";
        } else {
          if (window.location.pathname == "/chat") {
            return window.location.origin + "/images/icons/chat-current.svg";
          }

          return window.location.origin + "/images/icons/chat.svg";
        }
      } else if (path == "icon_notification_desktop") {
        switch (window.location.pathname) {
          case "/chat":
            if (this.text_chat_notifications > 0) {
              return (
                window.location.origin + "/images/icons/chat-current-on.svg"
              );
            }
            return window.location.origin + "/images/icons/chat-current.svg";

            break;

          default:
            if (this.color == "white") {
              if (this.text_chat_notifications > 0) {
                return (
                  window.location.origin + "/images/icons/chat-white-on.svg"
                );
              }
              return window.location.origin + "/images/icons/chat.svg";
            } else {
              if (this.text_chat_notifications > 0) {
                return (
                  window.location.origin + "/images/icons/chat-purple-on.svg"
                );
              }
              return window.location.origin + "/images/icons/chat-purple.svg";
            }
            break;
        }
        //   if(this.text_chat_notifications > 0){
        //      if(this.color == 'white'){
        //         return  window.location.origin+"/images/icons/chat-on.svg"
        //      }
        //         return  window.location.origin+"/images/icons/chat-white-on.svg"

        // }else{
        //     if(window.location.pathname == "/chat"){
        //         if(this.color == 'white'){
        //          return  window.location.origin+"/images/icons/chat.svg"
        //         }
        //     }

        //     return  window.location.origin+"/images/icons/w-notification.svg"
        //   }

        //     <!-- <img v-if="text_chat_notifications" src="images/icons/Bell_Notification.svg" />
        //  <img v-else src="images/icons/Bell_Inactive_white.svg" />
        // </div>
        // <div class="d-none d-md-inline">
        // <img v-if="video_notifications" src="images/icons/Bell_Notification.svg" />
        // <img v-else src="images/icons/Bell_Inactive.svg" /> -->
      } else {
        return window.location.origin + path;
      }
    },
  },
};
</script>

<style scoped>
.badge-blue {
  color: #fff;
  background-color: #3490dc;
}
</style>