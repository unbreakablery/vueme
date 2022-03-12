<template>
  <div>
    <v-card-title>
      <!-- <v-radio-group row v-model="firstChat">
        <v-radio label="Client first message" value="1"></v-radio>
        <v-radio label="Model first message response" value="2"></v-radio>
      </v-radio-group>-->
      <v-checkbox v-model="firstChat" label="First client message" value="1" hide-details></v-checkbox>
      <v-checkbox v-model="firstChat" label="First psychic response" value="2" hide-details></v-checkbox>
      <div class="flex-grow-1"></div>
      <v-text-field
        style="max-width: 300px"
        v-model="search"
        prepend-icon="mdi-magnify"
        clearable
        clear-icon="mdi-close "
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>

    <div id="scrollTarget" style="width: 100%; overflow-x: scroll">
      <div v-bind:style="{height: '1px', width: tableWidth}"></div>
    </div>
    <v-data-table
      id="chat-list"
      v-show="paginate.data && !loading"
      :headers="header"
      :items="paginate.data"
      :options.sync="options"
      :server-items-length="paginate.meta.total"
      class="elevation-1"
      :items-per-page="perPage"
      :footer-props="{
       itemsPerPageOptions: [25, 10, 35, 50, 100, -1]
    }"
    >
      <template v-slot:item="{item}" style="width: 50px">
        <tr>
          <td>{{item.created_at | formatDate}}</td>
          <td>
            <div class="d-inline" style="width: 100px">
              <v-avatar v-if="item.user_haedshot_path" size="90">
                <img class="pa-2" v-bind:src="item.user_haedshot_path" />
              </v-avatar>
              <div v-else class="pa-2">
                <v-avatar color="grey lighten-2" size="75">
                  <v-icon size="50" dark>mdi-account-circle</v-icon>
                </v-avatar>
              </div>
            </div>
            <a v-bind:href="'/'+ item.user_profile_link">{{item.user_username}}</a>
          </td>
          <td>
            <div class="d-inline" style="width: 100px">
              <v-avatar v-if="item.receiver_haedshot_path" size="90">
                <img class="pa-2" v-bind:src="item.receiver_haedshot_path" />
              </v-avatar>
              <div v-else class="pa-2">
                <v-avatar color="grey lighten-2" size="75">
                  <v-icon size="50" dark>mdi-account-circle</v-icon>
                </v-avatar>
              </div>
            </div>
            <a v-bind:href="'/'+ item.receiver_profile_link">{{item.receiver_username}}</a>
          </td>
          <td style="max-width: 30px">
            <v-btn text icon color="teal" @click="chat = item">
              <v-icon>mdi-forum</v-icon>
            </v-btn>
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-skeleton-loader v-if="!paginate.data || loading" type="table-tbody" class="mx-auto"></v-skeleton-loader>

    <v-dialog v-model="dialog" scrollable max-width="600px">
      <v-card>
        <v-card-title v-if="chat">
          <v-row>
            <v-col>
              {{chat.user_username}}
              <br />
              <span style="font-size:14px">
                <!-- {{chat.user_timezone}}  -->
                {{chat.user_ip}}
                <br />
                {{chat.user_id}}
              </span>
            </v-col>
            <v-col class="text-right">
              {{chat.receiver_username}}
              <br />
              <span style="font-size:14px">
                <!-- {{chat.receiver_timezone}}  -->
                {{chat.receiver_ip}}
                <br />
                {{chat.receiver_id}}
              </span>
            </v-col>
          </v-row>
        </v-card-title>
        <v-divider></v-divider>
        <v-progress-circular
          v-show="loadingMessages"
          indeterminate
          color="purple"
          style="position: absolute; left: 50%; margin-left: -16px; top: 50%;"
        ></v-progress-circular>
        <v-card-text
          v-bind:style="{'width': '600px', opacity: loadingMessages ? 0.5 : 1, overflow: 'hidden'}"
        >
          <div class="row">
            <div class="col-12" style="padding: 0px !important">
              <div class="pt-0" style="background-color: #e0e0e0;">
                <v-list id="chat_box" class="pt-0 chat_box" style="height: 61vh">
                  <div
                    class="px-3 py-0 messages"
                    v-for="(message, index) in messages"
                    :key="message.id"
                    :ref="'id'+message.id"
                  >
                    <date-component
                      v-if="index>0"
                      :datem="message"
                      :next="messages[index-1]"
                      :i="index"
                    ></date-component>

                    <div class="date_messages" v-if="index===0">{{ last_date }}</div>

                    <div
                      class="container_messages d-flex"
                      :style="[chat.user_id === message.user.id ? {'float': 'left'} :{},
                                          message.message ? {'max-width': '85%'} : {'max-width': '76%'},index===0? {'margin-top': '20px'}:{}]"
                    >
                      <div
                        v-if="chat.user_id === message.user.id"
                        class="pr-1"
                        style="position: relative;
                                        top: -10px;"
                      >
                        <div
                          class="user_avatar_chat mr-1"
                          :style="{ 'background-image': 'url(' + message.user.userProfile.haedshot_path  + ')' }"
                        ></div>
                      </div>

                      <div>
                        <div
                          v-if="message.message"
                          class="message_box"
                          :style="[chat.user_id == message.user.id ?
                                {'background': 'white'}:{'background': '#8dbdf8','color':'white'}]"
                        >
                          <div v-html="message.message"></div>
                        </div>

                        <div v-if="message.image" class style="position:relative;">
                          <img
                            v-if="message.type==='IMAGE'"
                            class="img"
                            @click="f_select_message_gallery(message)"
                            :src="message.image"
                          />

                          <i
                            v-if="message.type==='VIDEO'"
                            @click="f_select_message_gallery(message)"
                            class="fas fa-play-circle icon_play"
                          ></i>

                          <video
                            v-if="message.type==='VIDEO'"
                            class="video"
                            @click="f_select_message_gallery(message)"
                            v-bind:src="message.image"
                            muted
                            preload="metadata"
                          ></video>

                          <audio
                            v-if="message.type==='AUDIO'"
                            :src="message.image"
                            controls
                            controlslist="nodownload"
                          ></audio>
                          <!-- 
                          <div
                            class="progress"
                            v-if="(message.type==='IMAGEB' || message.type==='VIDEOB' || message.type === 'AUDIOB') && (file.active || file.progress !== '0.00')"
                          >
                            <div
                              class="progress-bar progress-bar-striped progress-bar-animated"
                              :class="{'bg-danger': file.error,}"
                              :style="{width: file.progress + '%'}"
                            >{{file.progress}}%</div>
                          </div>-->

                          <!--<div class="progress" v-if="(message.type==='IMAGEB' || message.type==='VIDEOB') && (file.active || file.progress !== '0.00')">
                                          <div :class="{'progress-bar': true, 'progress-bar-striped': true, 'bg-danger': file.error, 'progress-bar-animated': file.active}"   role="progressbar" :style="{width: file.progress + '%'}">{{file.progress}}%</div>
                          </div>-->

                          <img v-if="message.type==='IMAGEB'" class="img" :src="message.image" />
                          <video
                            v-if="message.type==='VIDEOB'"
                            class="video"
                            :src="message.image"
                            muted
                          ></video>
                          <audio
                            v-if="message.type==='AUDIOB'"
                            :src="message.image"
                            controls
                            controlslist="nodownload"
                          ></audio>
                        </div>

                        <div
                          style="font-size: 8px;"
                          :style="[chat.receiver_id === message.user.id ? {'text-align': 'right'} :{} ]"
                        >
                          {{ message.created_at | hour }}
                          <span v-if="message.user.role_id == 2">
                            <span
                              v-if="message.credit && message.credit !=0 "
                            >{{message.credit | money}}.</span>
                            <span v-else>Free.</span>
                          </span>
                        </div>
                      </div>

                      <div
                        v-if="chat.receiver_id === message.user.id"
                        class="pl-1"
                        style="position: relative; top: -10px;"
                      >
                        <div
                          class="user_avatar_chat mr-3 ml-1"
                          :style="{ 'background-image': 'url(' + message.user.userProfile.haedshot_path  + ')' }"
                        ></div>
                      </div>
                    </div>
                  </div>
                </v-list>
              </div>
              <div></div>
            </div>
          </div>
          <!-- <div v-for="item in messages" :key="item.id">
            <v-row v-if="item.user.id == chat.user_id" class="mb-2 px-3">
              <v-col class="d-flex p-0 align-center" style="max-width: 70px">
                <v-avatar v-if="chat.user_haedshot_path" size="60">
                  <img class="pa-2" v-bind:src="chat.user_haedshot_path" />
                </v-avatar>
                <div v-else class="pa-2">
                  <v-avatar color="grey lighten-2" size="60">
                    <v-icon size="60" dark>mdi-account-circle</v-icon>
                  </v-avatar>
                </div>
              </v-col>
              <v-col class="p-0" style="max-width: 290px;">
                <v-row v-if="item.image">
                  <v-col class="d-flex p-0 align-center">
                    <img width="200px" :src="item.image" />
                  </v-col>
                </v-row>
                <v-row class="h-100">
                  <v-col class="d-flex p-0 align-center">
                    <span v-html="item.message"></span>
                  </v-col>
                </v-row>
              </v-col>

              <v-col
                cols="12"
                style="color: gray; font-weight: bold; font-style: italic; font-size: 10px;"
              >
              <span v-if="item.credit && item.credit !=0 ">{{item.credit | money}}</span>
              <span v-else>Free</span> 
              {{item.created_at | formatDate}}
              </v-col>
            </v-row>

            <v-row v-else class="mb-2 px-3">
              <v-col class="p-0" style="max-width: 290px;">
                <v-row v-if="item.image">
                  <v-col class="d-flex p-0 justify-end align-center">
                    <img width="200px" :src="item.image" />
                  </v-col>
                </v-row>
                <v-row class="h-100">
                  <v-col class="d-flex p-0 justify-end align-center">
                    <span class="float-right d-block" v-html="item.message"></span>
                  </v-col>
                </v-row>
              </v-col>

              <v-col class="d-flex p-0 justify-end align-center" style="max-width: 70px">
                <v-avatar v-if="chat.receiver_haedshot_path" size="60">
                  <img class="pa-2" v-bind:src="chat.receiver_haedshot_path" />
                </v-avatar>
                <div v-else class="pa-2">
                  <v-avatar color="grey lighten-2" size="60">
                    <v-icon size="60" dark>mdi-account-circle</v-icon>
                  </v-avatar>
                </div>
              </v-col>
              <v-col
                cols="12"
                style="color: gray; font-weight: bold; font-style: italic;; font-size: 10px; text-align: right;"
              >
              {{item.created_at | formatDate}}
              </v-col>
            </v-row>
          </div>-->
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog style="inline-size: fit-content" v-model="gallery" max-width="65vw">
      <div class="card" style="background-color:black">
        <!-- The Close Button -->
        <span
          v-if="message_selected_gallery.type==='IMAGE'"
          @click="gallery=false;message_selected_gallery={}"
          class="close"
        >&times;</span>

        <!-- Modal Content (The Image) -->
        <img
          style="width: 100%; height: 100%"
          class="modal-content"
          v-if="message_selected_gallery.type==='IMAGE'"
          :src="message_selected_gallery.image"
        />

        <video
          style="width: 100%; height: 100%"
          v-if="message_selected_gallery.type==='VIDEO'"
          v-bind:src="message_selected_gallery.image"
          controls
          autoplay
          preload="auto"
        ></video>
      </div>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import { objectToGetParameters } from "../../util";
import dateComponent from "../../../backend/js/components/date_chat";

export default {
  components: { dateComponent },
  data() {
    return {
      y: 0,
      chat: null,
      messages: [],
      loadingMessages: false,
      chatPage: 1,
      dialog: false,
      role: 1,
      store: "chat",
      options: {},
      search: null,
      onSearch: false,
      sort: false,
      sortDesc: false,
      tableWidth: 0,
      message_selected_gallery: {},
      gallery: false,
      last_date: "",
      firstChat: null,
    };
  },
  methods: {
    f_show_date(date) {
      let diff = moment().diff(date.created_at, "days");

      if (diff === 1) {
        return "Today";
      } else if (diff === 2) {
        return "Yesterday";
      } else if (diff > 2 && diff < 8) {
        return moment(date.created_at).format("dddd");
      } else {
        return moment(date.created_at).format("MM/DD/YYYY");
      }
    },
    f_select_message_gallery(message) {
      this.message_selected_gallery = message;
      this.gallery = true;
    },
    getMessages() {
      this.loadingMessages = true;
      this.$store
        .dispatch(this.store + "/getChatData", {
          user_id: this.chat.user_id,
          receiver_id: this.chat.receiver_id,
          noLoading: true,
          page: this.chatPage++,
          per_page: 10,
          firstChat: this.firstChat
        })
        .then(() => {
          this.messages = this.chatData.data.reverse().concat(this.messages);
          // this.messages.push(...this.chatData.data);
          this.loadingMessages = false;

          if (this.chatData.data.length) {
            let to_scroll = this.chatData.data[this.chatData.data.length - 1];
            this.$nextTick(() => {
              let element = this.$refs["id" + to_scroll.id][0];
              document
                .getElementById("chat_box")
                .scrollTo(0, element.offsetTop);
              document
                .getElementById("chat_box")
                .addEventListener("scroll", this.onWrapperMessages);
            });
          }

          // document
          //   .getElementById("chat_box")
          //   .addEventListener("scroll", this.onWrapperMessages);
        });
    },
    onWrapperMessages(e) {
      let st = document.getElementById("chat_box").scrollTop;
      if (st === 0) {
        document
          .getElementById("chat_box")
          .removeEventListener("scroll", this.handleScroll);
        this.getMessages();
      }
      // if ( this.chatPage < this.chatData.meta.last_page &&
      //   !this.loadingMessages &&
      //   180 < e.currentTarget.scrollTop
      // ) {
      //   this.getMessages();
      // }
    },
    onScroll(e) {
      document.getElementsByClassName("v-data-table__wrapper")[0].scrollLeft =
        e.currentTarget.scrollLeft;
    },
    onScroll2(e) {
      document.getElementById("scrollTarget").scrollLeft =
        e.currentTarget.scrollLeft;
    },
    getQueryParam() {
      return {
        role: this.role,
        category: this.category,
        search: this.search,
        sort: this.sort,
        sortDesc: this.sortDesc,
      };
    },
  },
  filters: {
    hour: function (date) {
      return date ? moment(date).format("h:mm A") : "";
    },
    formatDate(date) {
      return moment(date).format("MM/DD/YYYY H:mm A");
    },
  },
  computed: {
    ...mapGetters({
      page: "chat/page",
      perPage: "chat/per_page",
      paginate: "chat/items",
      loading: "chat/loading",
      chatData: "chat/chatData",
    }),

    header: function () {
      return [
        { text: "Date", align: "left", value: "email", sortable: false },
        { text: "From", align: "left", sortable: false },
        { text: "To", align: "left", sortable: false },
        { value: "aux" },
      ];
    },
  },
  watch: {
    gallery: function (val) {
      if (val === false) {
        this.message_selected_gallery = {};
      }
    },
    dialog(val) {
      if (!val) {
        this.chat = null;
        this.messages = [];
        this.chatPage = 1;
        document
          .getElementById("chat_box")
          .removeEventListener("scroll", this.onWrapperMessages);
      }
    },
    chat(val) {
      if (val) {
        this.chat = val;
        this.dialog = true;
        this.getMessages();
      }
    },
    loading(val) {
      this.$store.dispatch("util/setLoading", val);
    },

    search(val) {
      if (!val) {
        this.onSearch = false;
        this.$store.dispatch(this.store + "/page", 1);
        this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
      }
      if (!this.onSearch) {
        this.$store.dispatch(this.store + "/page", 1);
        this.onSearch = true;
      }
      if (this.loading) return;

      clearTimeout(this.timeout);

      // Make a new timeout set to go off in 1000ms to wait stop write
      this.timeout = setTimeout(() => {
        if (val.length < 3) {
          return;
        }

        this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
      }, 1000);
    },
    options: {
      handler() {
        let reload = false;

        const { sortBy, sortDesc, page, itemsPerPage } = this.options;

        if (sortBy.length === 1 && sortDesc.length === 1) {
          if (this.sort != sortBy[0] || this.sortDesc != sortDesc[0]) {
            this.sort = sortBy[0];
            this.sortDesc = sortDesc[0];
            reload = true;
            this.$store.dispatch(this.store + "/page", 1);
          }
        } else if (this.sort) {
          this.sort = this.sortDesc = false;
          reload = true;
          this.$store.dispatch(this.store + "/page", 1);
        }

        if (this.page != page) {
          reload = true;
          this.$store.dispatch(this.store + "/page", this.options.page);
        }
        if (this.perPage != itemsPerPage) {
          reload = true;
          this.$store.dispatch(
            this.store + "/perPage",
            itemsPerPage == -1 ? this.paginate.meta.total : itemsPerPage
          );
        }
        if (reload)
          this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
      },
      deep: true,
    },
  },
  created() {
    if (!this.paginate.data || !this.paginate.data.length) {
      this.$store
        .dispatch(this.store + "/getItems", this.getQueryParam())
        .then(() => {
          let elmnt = document.getElementsByTagName("table");
          this.tableWidth = elmnt[0].offsetWidth + "px";
        });
    }
  },
  destroyed() {
    document
      .getElementById("scrollTarget")
      .removeEventListener("scroll", this.onScroll);
    document
      .getElementsByClassName("v-data-table__wrapper")[0]
      .removeEventListener("scroll", this.onScroll2);
  },
  mounted() {
    document
      .getElementById("scrollTarget")
      .addEventListener("scroll", this.onScroll);
    document
      .getElementsByClassName("v-data-table__wrapper")[0]
      .addEventListener("scroll", this.onScroll2);
  },
};
</script>


<style type="text/css" scoped>
th {
  white-space: nowrap;
}
.date_messages {
  font-size: 12px;
  text-align: center;
  width: fit-content;
  margin: auto;
  padding-bottom: 10px;
}

.container_messages {
  float: right;
  line-height: 130%;
}
.user_avatar_chat {
  backface-visibility: hidden;
  display: inline-block;
  overflow: hidden;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  background-size: cover;
  background-color: #8ebef8;
}
.message_box {
  border-radius: 4px;
  padding: 10px;
  font-weight: 400;
  font-size: 10px;
  box-shadow: rgba(0, 0, 0, 0.2) 0px 3px 1px -2px,
    rgba(0, 0, 0, 0.14) 0px 2px 2px 0px, rgba(0, 0, 0, 0.12) 0px 1px 5px 0px;
  white-space: -moz-pre-wrap !important;
  white-space: -webkit-pre-wrap;
  white-space: -pre-wrap;
  white-space: -o-pre-wrap;
  white-space: pre-wrap;
  word-wrap: break-word;
  /* word-break: break-all; */
  white-space: normal;
}
.icon_play {
  font-size: 36px;
  background-color: white;
  border-radius: 100%;
  position: absolute;
  transform: translate(256%, 132%);
}
.img {
  float: right;
  display: block;
  height: auto;
  vertical-align: middle;
  width: 220px;
  border-radius: 3px;
  cursor: pointer;
  padding: 0px;
}

.video {
  float: right;
  display: block;
  height: auto;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 3px;
  width: 220px;
}

.chat_box {
  background-color: #f7f7f7;
  overflow-y: scroll;

  align-items: end;
  overflow-x: hidden;
}
.messages {
  display: block;
  clear: both;
  float: left;
  width: 100%;
  max-width: 100%;
}
</style>
