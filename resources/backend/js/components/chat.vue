<template>
  <div>
    <div
      style="position: absolute;padding: 15px 30px;font-size: 14px;font-weight: 600;"
      class="d-none d-sm-block"
    >Messages</div>
    <div style="" :style="[ !mobile ? {'padding': '60px 30px 0px 30px'}:{}]">
      <div
        class="row bg-white px-0 mx-0"
        :style="[$vuetify.breakpoint.xsOnly && !show_users ?{'background-color': '#f0f0f8 !important'}:{'background-color': 'white'}]"
        :class="$vuetify.breakpoint.smAndDown ? 'mobileChat' : 'desktopChat'"
      >
        <!-------------Title Chat Messages User typing---------------->

        <div
          v-show="!isMobil() || show_users"
          :style="[mobile ?{'align-items': 'flex-end','background-color': 'transparent !important','padding':'0px 20px !important'}:{'padding':'0px 20px !important','width': '291px !important'}]"
          class="col-sm-5 bg-white"
        >
          <v-text-field
            class="magnifyInput"
            :style="[mobile ?{'min-width': '100% !important'}:{'width': '291px !important'}]"
            v-model="search_user"
            prepend-inner-icon="mdi-magnify"
            clearable
            background-color="#F4F4F4"
            dense
            filled
            flat
            solo
            :hide-details="true"
            label="Search"
            @input="isTyping = true"
          ></v-text-field>
        </div>

        <div class="col-sm-7" v-show="!show_users">
          <div
            v-show="isMobil() && !show_users"
            style="position: absolute;font-size: 25px;left: 25px;"
          >
            <img
              style="cursor: pointer;width: 10px;"
              v-on:click="showUsers"
              src="/images/icons/chevron-left-solid-2x.png"
            />
            <!-- <i style="cursor: pointer" v-on:click="showUsers" class="fas fa-angle-left"></i> -->
          </div>
          <div class="row" style="display: block;text-align: center;">
            <div class="messages_title" v-if="typingFriend.id!==user_selected.id ">
              <!-- <v-btn v-if="user.role_id == 2" text @click="goToProfile(user_selected)">
                            <span style="font-size: 16px;font-weight: 600;color: #1F1E34;">{{user_selected.show_name}}</span>                           
              </v-btn>-->
              <span
                v-if="user.role_id == 2"
                @click="goToProfile(user_selected)"
                style="font-size: 16px;font-weight: 600;color: #1F1E34;cursor: pointer;"
              >{{user_selected.show_name | truncate(20, '...')}}</span>
              <span 
                v-else
                style="font-size: 16px;font-weight: 600;color: #1F1E34;"
              >{{user_selected.show_name | truncate(20, '...')}}</span>
            </div>
            <div class="messages_title" v-else>
              <!-- <v-btn v-if="user.role_id == 2" text @click="goToProfile(user_selected)">
                            <span  style="font-size: 15px;font-weight: 600;color: #1F1E34;">{{user_selected.show_name}} is Typing...</span>                           
              </v-btn>-->

              <span
                v-if="user.role_id == 2"
                @click="goToProfile(user_selected)"
                style="font-size: 15px;font-weight: 600;color: #1F1E34;cursor: pointer;"
              >{{user_selected.show_name | truncate(20, '...')}} is Typing...</span>
              <span
                v-else
                style="font-size: 15px;font-weight: 600;color: #1F1E34;"
              >{{user_selected.show_name | truncate(20, '...')}} is Typing...</span>
            </div>
          </div>
        </div>
      </div>

      <div
        class="row"
        style="margin: auto;"
        :style="[user_selected.id === false && !mobile?{'border-right': '7px white solid',
    'border-bottom': '75px white solid'}:{}]"
      >
        <!-------------Chat Users---------------->

        <!-- \
        :style="[
                 mobile  ?
                 {'height':'calc(100vh - 237px) !important'} :
        {'height': 'calc(100vh - 273px) !important'}]"
        
        -->
        <div class="col-sm-5 user_btn_search" v-show="!isMobil() || show_users">
          <v-list class="users_list" id="users_list"
          
          :style="[
                 mobile  ?
                 {'':''} :
                 {'height': 'calc(100vh - 193px - '+space_header+'px !important'}]"
          
          >
            <v-list-item
              class="py-0 px-3 users_chat"
              style="min-height: 79px !important;"
              v-for="(friend, index) in friends"
              :key="index"
              @click="f_select_user(friend)"
              :class="[user_selected.id===friend.id ? 'active_item' : 'inactive_item',friend.unread_messages + f_unread_messages(friend) > 0 ? 'unread_messages':'']"
              tile
            >
              <v-badge
                v-if="friend.view_profile"
                :color="friend.online ? 'green mb-4 mr-8 dot_border_users' : 'grey mb-4 mr-8 dot_border_users'"
                dot
                bordered
                bottom
              >
                <template class v-slot:badge>{{''}}</template>
                <div
                  class="user_avatar_list mr-3"
                  :style="{ 'background-image': 'url(' + friend.profile_headshot_url  + ')' }"
                ></div>
              </v-badge>
              <div
                v-else
                class="user_avatar_list mr-3"
                :style="{ 'background-image': 'url(' + friend.profile_headshot_url  + ')' }"
              ></div>

              <v-list-item-content class="pl-1" style="display: grid;">
                <v-list-item-title
                  style="font-size: 15px;font-weight: 600;color: #1F1E34 !important;"
                  class="mb-1"
                  :class="{'active':user_selected.id===friend.id}"
                >
                  <!-- style="[writers.find(user=>user.id===friend.id) || 
                  friend.unread_messages > 0 ? {'font-weight':'600'} : {'font-weight':'500'}]"-->
                  {{friend.show_name}}
                  <!-- <span v-if="friend.unread_messages + f_unread_messages(friend) > 0"
                  class="badge badge-blue badge-pill">{{ friend.unread_messages + f_unread_messages(friend) }}</span>-->
                </v-list-item-title>
                <v-list-item-subtitle
                  style="font-size: 13px;font-weight: 500;color: #656B72;"
                  class="users_subtitle"
                  v-if="friend.last_chat.message"
                >{{friend.last_chat.message}}</v-list-item-subtitle>
                <v-list-item-subtitle
                  style="font-size: 12px;font-weight: 500;color: #656B72;"
                  class="users_subtitle"
                  v-else-if="friend.last_chat.type === 'IMAGE'"
                >
                  <i class="fas fa-image mr-2"></i>Photo
                </v-list-item-subtitle>
                <v-list-item-subtitle
                  style="font-size: 12px;font-weight: 500;color: #656B72;"
                  class="users_subtitle"
                  v-else-if="friend.last_chat.type === 'VIDEO'"
                >
                  <i class="fas fa-video mr-2"></i> Video
                </v-list-item-subtitle>
              </v-list-item-content>

              <div
                class="user_hour"
                v-if="friend.last_chat"
              >{{ friend.last_chat.created_at | moment2}}</div>
            </v-list-item>

            <!-- Chat search found -->
            <v-list-item
              v-show="messages_search_found.length"
              color="white"
              class="title_messages_found"
            >
              <div style="color:white !important">MESSAGES</div>
            </v-list-item>
            <v-list-item
              class="py-0 px-3 users_chat"
              style="min-height:79px !important;"
              v-for="(message_found, index) in messages_search_found"
              :key="'m_found_'+index"
              @click="f_select_message(message_found)"
              :class="Object.keys(message_selected).length>0 && message_selected.id===message_found.id ? 'active_item' : 'inactive_item'"
              tile
            >
              <div
                class="user_avatar_list mr-3"
                :style="{ 'background-image': 'url(' + message_found.receiver_haedshot_path  + ')' }"
              ></div>

              <v-list-item-content class="pl-1" style="display: grid;">
                <v-list-item-title
                  style="font-size: 14px;font-weight: 600;color: #1F1E34 !important; "
                  class="mb-1 text-primary"
                >{{message_found.user.show_name}}</v-list-item-title>
                <v-list-item-subtitle
                  style="font-size: 12px;font-weight: 500;color: #656B72;"
                  class="users_subtitle"
                  v-if="message_found.message"
                >
                  <!-- <div v-if="f_check_string(message_found.message)"  class="d-inline text-light bg-secondary font-weight-light">{{search_user}}</div> -->
                  <div v-html="f_show_message_found_style(message_found.message)"></div>
                </v-list-item-subtitle>
              </v-list-item-content>

              <div class="user_hour">{{ message_found.created_at | moment2}}</div>
            </v-list-item>

            <!-- End Chat search found -->
          </v-list>
        </div>

        <!-------------Chat Messages---------------->
        <div class="col-sm-7 col-xs-12" v-show="!show_users" style="padding: 0px !important;">
          <div class="pt-0">
            <v-list
              id="chat_box"
              class="pt-0 chat_box"
              :class="{'no_message_user_chat':show_no_message_with_user}"
              
              :style="[
                 mobile  ?
                 {'':'',  } :
                 {'height': 'calc(100vh - 193px - '+space_header+'px !important'}]"
            >
              <div class="spinner-border text-primary" v-if="loading"></div>
              <div
                class="px-3 py-3 messages"
                v-for="(message, index) in privateMessages"
                :key="message.id"
                :ref="'id'+message.id"
              >
                <div
                  class="container_messages d-flex"
                  :style="[user.id === message.receiver_id ? {'float': 'left'} :{},
                                          message.message ? {'max-width': '85%'} : {'max-width': '76%'},index===0? {'margin-top': '20px'}:{}]"
                >
                  <div>
                    <div
                      v-if="message.message"
                      class="message_box"
                      :style="[user.id === message.receiver_id ?
                                {'background': 'white','color':'#656B72'}:{'background': '#8dbdf8','color':'white'}]"
                    >
                      <div v-html="f_show_message_found_style(message.message)"></div>
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

                      <div
                        class="progress"
                        v-if="(message.type==='IMAGEB' || message.type==='VIDEOB' || message.type === 'AUDIOB') && (file.active || file.progress !== '0.00')"
                      >
                        <div
                          class="progress-bar progress-bar-striped progress-bar-animated"
                          :class="{'bg-danger': file.error,}"
                          :style="{width: file.progress + '%'}"
                        >{{file.progress}}%</div>
                      </div>

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
                      style="font-size: 10px;color: #656B72;"
                      :style="[user.id === message.user_id ? {'text-align': 'right'} :{} ]"
                    >{{f_show_date(message)}} {{ message.created_at | hour }}</div>

                    <div
                      v-if="message.status === 'DUPLICATED' && user.id === message.user_id"
                      class="message_box mt-1 mb-2"
                      style="color:#484847; background: #e4e4e4"
                    >
                      <i class="fas fa-info-circle fa-2x"></i>
                      <div
                        v-html="user.role_id === 2 ?user_duplicated_message : psychic_duplicated_message"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Message System Response---->

              <div
                class="px-3 py-3 messages"
                v-if="privateMessages.length > 0 &&  privateMessages[privateMessages.length-1].user_id == user.id && user.role_id === 2"
              >
                <div class="container_messages d-flex" style="max-width: 60%;float:left">
                  <div>
                    <div
                      class="message_box"
                      style="color:#656B72; background: white"
                    >{{get_system_message(privateMessages[privateMessages.length-1])}}</div>
                    <div
                      style="font-size: 10px;color: #656B72;text-align: left;"
                    >{{f_show_date(privateMessages[privateMessages.length-1])}} {{ privateMessages[privateMessages.length-1].created_at | hour }}</div>
                  </div>

                  <!-- <v-badge class="ml-5"  :color="privateMessages[privateMessages.length-1].receiver_online ? 'green mb-4 mr-8 dot_border_users' : 'grey mb-4 mr-8 dot_border_users'" dot  bordered bottom >
                                        <template class="" v-slot:badge>{{''}}</template>
                                    <div class="user_avatar_list" :style="{ 'background-image': 'url(' + privateMessages[privateMessages.length-1].receiver_profile  + ')' }">

                                    </div>
                  </v-badge>-->
                </div>
              </div>

              <!-- End Message System Response---->

              <!--------Show_no_message_with_user  ------------->

              <div
                class="mx-auto text-center"
                v-if="user.role_id === 2 && show_no_message_with_user"
              >
                <v-badge
                  :color="user_selected.online ? 'green mb-7 mr-7 dot_border' : 'grey mb-7 mr-7 dot_border'"
                  dot
                  bordered
                  bottom
                >
                  <template class v-slot:badge>{{''}}</template>
                  <div
                    style="width: 150px;height: 150px;margin-bottom: 0px !important;"
                    class="user_avatar_list"
                    :style="{ 'background-image': 'url(' + user_selected.profile_headshot_url  + ')' }"
                  ></div>
                </v-badge>
                <h4 class="mt-3 mb-1 text-dark font-weight-bold">{{user_selected.show_name}}</h4>
                <div
                  class="text-secondary"
                  style="padding:0px 90px; font-size: 14px;font-weight: 500;"
                >Send me a message to get started!</div>
              </div>

              <!------- Show_no_message_with_user -------------->
            </v-list>
          </div>

          <div>
            <v-footer
              style="width: 100%;
                    background-color: white;
                    padding: 15px 16px;
                    bottom: 0px;
                    " id="v-footer"
                    :style="[ $vuetify.breakpoint.xsOnly ? {'position': 'inherit '}:{}]"
            >
              <v-layout>
                <div class="row">
                  <div class="col-10 col-lg-11 px-5">
                    <v-textarea
                      style="font-size: 14px;"
                      auto-grow
                      flat
                      placeholder="Chat here..."
                      solo
                      dense
                      hide-details
                      color="blue"
                      @focus="change_size_chat_box"                     
                      @blur="change_size_chat_box"

                      append-icon="fa fa-send-o"
                      @click:append="f_send_message"
                      v-model="message"
                      @keydown="onTyping"
                      background-color="#F4F4F4"
                      @keyup="notTyping"
                      rows="1"
                      ref="message"
                      id="id_input"
                      @keyup.enter="f_send_message"
                      v-bind:disabled="upload_is_active"
                    ></v-textarea>
                  </div>
                  <!-- <div   class="col-2 col-lg-1 text-center px-0"                                                          
                                 >
                                  <v-btn class="mx-2" fab small
                                    @click="f_send_message"
                                     style="cursor:pointer ;height:35px; width: 35px;"   
                                    v-bind:disabled="upload_is_active"
                                    depressed
                                     color="primary">
                                       <i style="font-size: 18px;" class="fas fa-arrow-up fas-lg"></i>
                                     </v-btn>
                                       
                  </div>-->
                  <div class="col-2 col-lg-1 text-center pl-0">
                    <file-upload
                      :post-action="'/api/v1/user/chat/message?receiver='+user_selected.id"
                      ref="upload"
                      v-model="files"
                      :drop="!upload_is_active"
                      :disabled="upload_is_active || show_no_message_with_user"
                      @input-filter="inputFilter"
                      @input="updatetValue"
                      @input-file="inputFile"
                      :headers="{'X-CSRF-TOKEN': token }"
                    >
                      <img src="/images/icons/AttachMedia.png" />
                      
                    </file-upload>                    
                  </div>
                </div>
              </v-layout>
            </v-footer>
          </div>
        </div>
      </div>

      <template>
        <v-row justify="center">
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
        </v-row>
      </template>



     <v-dialog v-model="dialog_message" width="420px">
      <v-card color="#fff">
        <v-card-text style="padding: 15px 20px;">
            <div class="text-right">
                <v-icon class="text-right" @click="dialog_message=false">mdi-close</v-icon>
              </div>

          <div class="text-danger text-center my-3">
            <v-subheader
              class="message my-10"
              v-if="buyCreditOpcion == 1"
            >Get $5 free with your first purchase!</v-subheader>

            <v-subheader
              class="message my-10"
              v-else-if="buyCreditOpcion == 2"
            >Get $5 free with your next purchase!</v-subheader>
            
            <v-subheader
              class="message my-10"
              v-else
            >You do not have enough funds to request service with {{ user_selected.show_name }}.</v-subheader>

            <v-btn
              color="primary"
              depressed
              style="color: #fff !important;"
              rounded
              @click="f_open_popup_credits();"
            >
            <span v-if="buyCreditOpcion == 1">Start Now</span>
            <span v-else-if="buyCreditOpcion == 2">Add Now</span>
            <span v-else>Reload Wallet</span>
            </v-btn>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
    

    </div>
  </div>
</template>


<script>
import moment from "moment";
import dateComponent from "../components/date_chat";
import { mapGetters } from "vuex";
const csrf = $('meta[name="csrf-token"]').attr("content");

export default {
  name: "chat",
  components: { dateComponent },
  props: ["user", "user_to_select", "users_height", "messages_height"],
  data() {
    return {
      privateMessages: [],
      message: "",
      message_error: "",
      users: [],
      writers: [],
      user_selected: {
        id: false,
        profile: {
          name: "",
          display_name: "",
        },
      },
      message_selected: {},
      result: [],
      typingFriend: {},
      resHeight: 0,
      resListHeight: 0,
      vfooterHeight: 77,
      fixedHeight: 118,
      isSafari : /^((?!chrome|android).)*safari/i.test(navigator.userAgent),
      typingClock: null,
      onlineFriends: [],
      token: csrf,
      files: [], 

      message_selected_gallery: {},
      gallery: false,
      message_blob: {
        image: "",
        type: "",
        user_id: this.user.id,
        message: "",
      },
      file: {},
      upload_is_active: false,
      page: 1,
      pagination_meta: {},
      pagination_links: {},
      offset: 0,
      last_message: {},
      search_user: "",
      search_friends: [],
      loading: false,

      noModels: "",
      show_users: true,
      dialog_message: false,
      dialog_title: "",
      isTyping: false,
      messages_search_found: [],
      from_user: true,
      message_popup: "",
      height_textarea: 30,
      user_duplicated_message:
        "Duplicate message detected. For your benefit we have blocked the repeat message, and you were only charged once",
      psychic_duplicated_message:
        "Duplicate message detected, we have blocked the second message.",
      show_no_message_with_user: false,
      change_css_search: false,
      buyCreditOpcion: -1,        
    };
  },
  watch: {

    space_header:function(newVal,oldVal){
     if(this.mobile){
     this.change_size_chat_box();
     
     }
    },
    show_users: function(newVal, oldVal){
        
         if(!newVal){  
         this.change_size_chat_box();       
         }
    
      
    },
    message: function (val, old) {
     
         if(this.mobile){

           this.change_size_chat_box();           

           let chat_box = document.getElementById("chat_box");
           if(chat_box.scrollTop == chat_box.scrollHeight - chat_box.clientHeight){              
              setTimeout(this.scrollToEnd, 500);
           }
           
         }
          
            
    },
    user_selected: function (val, old) {
      if (this.from_user) {
        this.privateMessages = [];
        this.message = "";
        this.show_users = false;
        this.f_get_messages(val.id);
        this.result = this.writers.filter(function (obj) {
          return obj.id !== val.id;
        });

        this.$root.$emit("header_remove_notification_user-" + this.user.id, {
          id: val.id,
        });
        this.writers = this.result;
        this.offset = 0;
        this.page = 1;
      }
    },
    message_selected: function (val, oldVal) {
      for (var i = 0; i < this.users.length; i++) {
        if (
          this.user.id === val.user_id &&
          this.users[i].id === val.receiver_id
        ) {
          this.user_selected = this.users[i];
          break;
        }

        if (
          this.user.id === val.receiver_id &&
          this.users[i].id === val.user_id
        ) {
          this.user_selected = this.users[i];
          break;
        }
      }
      this.privateMessages = [];
      this.show_users = false;
      this.f_get_messages_user_from_found(val.id);
    },
    privateMessages: function (val, old) {
      if (val.length) {
        this.show_no_message_with_user = false;
        this.last_message = val[val.length - 1];
      }
    },
    gallery: function (val, old) {
      if (val === false) {
        this.message_selected_gallery = {};
      }
    },
    search_user: _.debounce(function () {
      this.isTyping = false;
    }, 600),
    isTyping: function (value) {
      if (!value) {
        if (this.search_user) {
          this.f_get_messages_search();
        } else {
          this.messages_search_found = [];
        }
      }
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      space_header: "util/space"
    }),
    
    friends() {
      const friendsFiltered = this.users.filter((user2) => {
        if (this.user.role_id === 1 && user2.last_chat.created_at === "") {
          return false;
        }
        let name = user2.show_name;
        if (
          this.user.id !== user2.id &&
          (this.search_user === null ||
            name.toLowerCase().indexOf(this.search_user.toLowerCase()) !== -1)
        ) {
          return true;
        }
      });

      friendsFiltered.sort((a, b) => {
        let first = new Date(a.last_chat.created_at);
        let second = new Date(b.last_chat.created_at);

        return (
          (a.last_chat.created_at === "") - (b.last_chat.created_at === "") ||
          -(first > second) ||
          +(first < second)
        );
      });

      return friendsFiltered;
    },
  },
  mounted() {
    
      document.getElementById("chat_box").addEventListener("scroll", this.handleScroll);
      let remove_space_header = 65 + this.space_header;
      document.getElementById("users_list").style.height =  "calc(" + innerHeight + "px - " + remove_space_header + "px)";
      window.addEventListener("resize", this.change_size_chat_box);
     

  },
  beforeDestroy() {
    document
      .getElementById("chat_box")
      .removeEventListener("scroll", this.handleScroll);
  },

  created() {
    this.f_get_users(); 
    Echo.private("privatechat." + this.user.id)
      .listen("MessageChatPrivateSent", (data) => {
        let on_chat = false;
        let message = data.chat;

        let index = this.friends.findIndex((x) => x.id === message.user_id);
        
        if (index == -1) {
          message.user.last_chat = message;
          this.users.push(message.user);
        } else {
          this.friends[index].last_chat = message;
        }

        if (message.user_id === this.user_selected.id) {
          on_chat = true;
          this.privateMessages.push(message);
          this.f_mark_read_menssage(message);

          this.typingFriend = {};
        } else {
          this.writers.push(message.user);
        }
        this.$root.$emit("on_chat-" + message.receiver_id, {
          on_chat: on_chat,
          message: message,
        });
        setTimeout(this.scrollToEnd, 500);
      })
      .listenForWhisper("typing", (e) => {
        let _this = this;
        if (e.user.id === this.user_selected.id) {
          this.typingFriend = e.user;
          setTimeout(function () {
            _this.typingFriend = {};
          }, 3000);
        }
      });
  },
  filters: {
    hour: function (date) {
      return date ? moment(date).format("h:mm a") : "";
    },
    moment: function (date) {
      let a = moment();

      let b = moment(date);

      let diff = a.diff(b, "days");
      if (diff > 0) {
        return diff + "d";
      }

      diff = a.diff(b, "hours");
      if (diff > 0) {
        return diff + "h";
      }

      diff = a.diff(b, "minutes");
      if (diff > 0) {
        return diff + "m";
      }
      diff = a.diff(b, "seconds");
      if (diff > 0) {
        return diff + "s";
      } else {
        return "1s";
      }
    },
    moment2: function (date) {
      let a = moment();

      let b = moment(date);

      let diff = a.diff(b, "days");
      if (diff > 0) {
        if (diff === 1) {
          return diff + " day ago";
        } else {
          return diff + " days ago";
        }
      }

      diff = a.diff(b, "hours");
      if (diff > 0) {
        if (diff === 1) {
          return diff + " hour ago";
        } else {
          return diff + " hours ago";
        }
      }

      diff = a.diff(b, "minutes");
      if (diff > 0) {
        if (diff === 1) {
          return diff + " min ago";
        } else {
          return diff + " mins ago";
        }
      }
      diff = a.diff(b, "seconds");
      if (diff > 0) {
        return diff + "s";
      } else {
        return "";
      }
    },
  },

  methods: {   
  
    change_size_chat_box(){
       if(this.mobile){
         
      setTimeout((x) => {
          let remove_space_header = 65 + this.space_header;
          document.getElementById("users_list").style.height =  "calc(" + innerHeight + "px - " + remove_space_header + "px)";
          let pix = innerHeight - document.getElementById("v-footer").offsetHeight - remove_space_header;
          document.getElementById("chat_box").style.height = "calc(" + pix + "px )";
          if(!this.isSafari){
             document.getElementById("users_list").style.height =  "calc(" + innerHeight + "px - " + remove_space_header + "px)";
          }
         
          
          
      },50)
       } 
    },
 
    mobilecheck() {
      let check = false;
      (function (a) {
        if (
          /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(
            a
          ) ||
          /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
            a.substr(0, 4)
          )
        )
          check = true;
      })(navigator.userAgent || navigator.vendor || window.opera);
      return check;
    },
    isMobil() {
      if (this.mobilecheck()) {
        return true;
      } else {
        return false;
      }
    },
    showUsers() {
      this.show_users = !this.show_users;
    },
    f_show_users_focus() {
      if (!this.search_user && this.isMobil()) {
        this.show_users = true;
      }
    },
    f_moment(date) {
      return moment(date).format("h:mm A");
    },
    f_show_date(date) {
      let date_created = moment(date.created_at).format("MM/DD/YY");
      let today = moment();
      let diff = today.diff(date_created, "days");

      if (diff == 0) {
        return "";
      } else if (diff === 1) {
        return "Yesterday,";
      }
      //else if(diff > 2 && diff < 8){
      //     return moment(date.created_at).format('dddd');
      // }
      else {
        return date_created + ",";
      }
    },
    sizeHeight() {

      // if (this.isSafari) {

      // var newSize = parseInt(this.fixedHeight) + parseInt(this.vfooterHeight) + parseInt(outerHeight - innerHeight);
      // this.resHeight = newSize;

      // var newListSize = parseInt(this.fixedHeight) + parseInt(outerHeight - innerHeight);
      // this.resListHeight = newListSize;
      
      // }

      // document.getElementById("chat_box").style.height =
      //   "calc(" + outerHeight + "px - " + this.resHeight + "px)";

      // document.getElementById("users_list").style.height =
      // "calc(" + outerHeight + "px - " + this.resListHeight + "px)";
      
    },

    notTyping() {

      // this.typingFriend = {};


      // this.vfooterHeight = document.getElementById("v-footer").offsetHeight;


      //  if (!this.isSafari) {
      
      //       var newSize = parseInt(this.fixedHeight) + parseInt(this.vfooterHeight) + parseInt(outerHeight - innerHeight);
      //       document.getElementById("chat_box").style.height =  "calc(" + outerHeight + "px - " + newSize + "px)";
      //       this.scrollToEnd();

      //  }else{

      //       var newSize = parseInt(this.fixedHeight) + parseInt(this.vfooterHeight);
      //       // document.getElementById("chat_box").style.height =  "calc(" + outerHeight + "px - " + newSize + "px)";
      //       this.scrollToEnd();

      //  }

      
     
      
    },
    onTyping() {
      let channel = Echo.private("privatechat." + this.user_selected.id);
      channel.whisper("typing", {
        user: { id: this.user.id },
      });

    },
    f_open_popup_credits() {
      this.dialog_message = false;
      this.$root.$emit("open_credits_too", {});
    },
    f_get_messages_search() {
      axios
        .get("/api/v1/user/chat/smessages?text=" + this.search_user, {})
        .then((response) => {
          this.messages_search_found = response.data.data;
        })
        .catch((error) => {
          this.message_error = error;
        });
    },
    f_get_messages_user_from_found(id) {
      this.loading = true;

      axios
        .get("/api/v1/user/chat/messages?id=" + id, {})
        .then((response) => {
          this.loading = false;
          this.privateMessages = response.data.data.reverse();

          this.$nextTick(() => {
            let element = this.$refs["id" + id][0];
            document.getElementById("chat_box").scrollTo(0, element.offsetTop);
          });
        })
        .catch((error) => {
          this.message_error = error;
        });
    },
    f_show_message_found_style(message) {
      if (!this.search_user) {
        return message;
      }
      return message.replace(new RegExp(this.search_user, "gi"), (match) => {
        return (
          '<span class="bg-dark text-light font-weight-light ">' +
          match +
          "</span>"
        );
      });
    },
    f_get_messages(id) {
      this.loading = true;

      axios
        .get("/api/v1/user/chat/message/" + id + "?page=1&offset=0", {})
        .then((response) => {
          this.loading = false;
          this.privateMessages = response.data.data.reverse();
          this.pagination_meta = response.data.meta;
          this.pagination_links = response.data.links;

          if (this.privateMessages.length == 0) {
            this.show_no_message_with_user = true;
          }
          setTimeout(this.scrollToEnd, 500);
          this.friends[
            this.friends.findIndex((x) => x.id === this.user_selected.id)
          ].unread_messages = 0;
        })
        .catch((error) => {
          this.message_error = error;
        });
    },
    f_get_more_messages() {
      if (this.page < this.pagination_meta.last_page) {
        this.loading = true;
        this.page++;
        axios
          .get(
            "/api/v1/user/chat/message/" +
              this.user_selected.id +
              "?page=" +
              this.page +
              "&offset=" +
              this.offset,
            {}
          )
          .then((response) => {
            this.loading = false;
            if (this.offset === 0) {
              this.pagination_meta = response.data.meta;
              this.pagination_links = response.data.links;
            }

            this.privateMessages = response.data.data
              .reverse()
              .concat(this.privateMessages);

            if (response.data.data.length) {
              let to_scroll = this.privateMessages[
                response.data.data.length - 1
              ];
              this.$nextTick(() => {
                let element = this.$refs["id" + to_scroll.id][0];
                document
                  .getElementById("chat_box")
                  .scrollTo(0, element.offsetTop);
                document
                  .getElementById("chat_box")
                  .addEventListener("scroll", this.handleScroll);
              });
            }
          })
          .catch(function (error) {
            if (
              error.response &&
              (error.response.status === 401 || error.response.status === 419)
            ) {
              location.reload();
            }
          });
      }
    },
    f_get_users() {
      window.history.replaceState(
        "object or string",
        "Title",
        "/" +
          window.location.href
            .substring(window.location.href.lastIndexOf("/") + 1)
            .split("?")[0]
      );
      axios
        .get("/api/v1/user/chat/active")
        .then((response) => {
          this.users = response.data.data;
          if (this.friends.length > 0) {
            const object = this.friends.find(
              (e) => e.id === parseInt(this.user_to_select)
            );
            if (!object) {
              if (!this.$vuetify.breakpoint.xsOnly) {
                this.user_selected = this.friends[0];
              }
            } else {
              this.user_selected = object;
            }
          }
        })
        .catch((error) => {
          this.message_error = error;
        });
    },
    f_send_message() {
      if (this.message.replace(/\s+/g, "")) {
        this.upload_is_active = true;
        let text_to_send = this.message;
        this.message = "";

        axios
          .post("/api/v1/user/chat/message", {
            text: text_to_send,
            receiver: this.user_selected.id,
          })
          .then((response) => {
            this.upload_is_active = false;
            let msg = response.data.data;

            if (response.data[0] == "first_chat") {
              msg = response.data[1];
            }

            if (msg.status === "DUPLICATED") {
              this.privateMessages.splice(
                this.privateMessages.length - 1,
                1,
                msg
              );
            } else {
              this.offset++;
              if (msg.message) {
                this.friends[
                  this.friends.findIndex((x) => x.id === msg.receiver_id)
                ].last_chat = msg;
                this.privateMessages.push(msg);
              }

              this.$root.$emit("chat_subtract_credits-" + this.user.id, msg);
            }
            setTimeout(this.scrollToEnd, 200);
            setTimeout((x) => {
              this.$nextTick(() => this.$refs.message.focus()); // this works great, just watch out with going to fast !!!
            }, 500);
          })
          .catch((error) => {
            this.upload_is_active = false;
            if (error.response.status === 400) {
              if (error.response.data.error === "buy credits") {

                  this.buyCreditOpcion = error.response.data.buyCreditOpcion;
                // this.message_popup =
                //   "You do not have enough credits to message " +
                //   this.user_selected.show_name;
                  this.dialog_message = true;
              } else {
                this.$root.$emit("open_dialog_message", {
                  message: error.response.data.error,
                  message_title: "ERROR",
                });
              }
            }
            if (
              error.response.status === 419 ||
              error.response.status === 401
            ) {
              location.reload();
            }
            this.message_error = error;
          });
      } else {
        this.message = "";
        this.$refs.message.focus();
      }
    },
    f_mark_read_menssage(chat) {
      axios
        .put("/api/v1/user/chat/message/" + chat.id, {})
        .then((response) => {})
        .catch((error) => {
          //alert('Something was wrong');
          location.reload();
          this.message_error = error;
        });
    },
    scrollToEnd() {
      document

        .getElementById("chat_box")
        .removeEventListener("scroll", this.handleScroll);
      let objDiv = document.getElementById("chat_box");
      document.getElementById("chat_box").scrollTo(0, objDiv.scrollHeight);
      document
        .getElementById("chat_box")
        .addEventListener("scroll", this.handleScroll);
    },
    f_unread_messages(friend) {
      return this.writers.reduce(function (n, writer) {
        return n + (writer.id === friend.id);
      }, 0);
    },
    f_select_message_gallery(message) {
      this.message_selected_gallery = message;
      this.gallery = true;
    },
    f_get_mime(type) {
      if (type.includes("image")) {
        return "IMAGEB";
      } else {
        return type.includes("audio") ? "AUDIOB" : "VIDEOB";
      }
    },
    f_user_leave_chat(user) {
      axios
        .put("/api/v1/user/chat/" + user.id, {})
        .then((response) => {})
        .catch((error) => {
          this.message_error = error;
        });
    },

    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Add file

        // Filter non-image file
        // Will not be added to files
        if (
          !/\.(jpeg|jpe|jpg|gif|png|webp|mp4|mov|m4v|webm|wmv|avi|3gp|ts|m3u8|flv|ogv|mpg|wav|aiff|aif|aifc|flac|m4a|caf|mp3|aac|wma|ogg)$/i.test(
            newFile.name
          )
        ) {
                    
          this.$root.$emit("open_dialog_message", {
            message: "File type not supported",
            message_title: "ERROR",
          });
          return prevent();
        }

        // Create the 'blob' field for thumbnail preview
        newFile.blob = "";
        let URL = window.URL || window.webkitURL;
        if (URL && URL.createObjectURL) {
          newFile.blob = URL.createObjectURL(newFile.file);
          this.message_blob.image = newFile.blob;
          this.message_blob.type = this.f_get_mime(newFile.file.type);
          this.privateMessages.push(this.message_blob);
          setTimeout(this.scrollToEnd, 500);
        }
      }
    },
    updatetValue(value) {
      this.file = value[value.length - 1];
    },
    inputFile: function (newFile, oldFile) {
      this.$refs.upload.active = true;
      this.upload_is_active = true;

      if (newFile && oldFile && !newFile.active && oldFile.active) {
        this.upload_is_active = false;
        // Get response data
        if (newFile.xhr) {
          //  Get the response status code
          if (newFile.xhr.status === 201) {
            this.$root.$emit(
              "chat_subtract_credits-" + this.user.id,
              newFile.response.data
            );
            this.privateMessages[this.privateMessages.length - 1] =
              newFile.response.data;
            this.offset++;
            setTimeout(this.scrollToEnd, 500);
          }
          if (newFile.xhr.status === 400) {
            let obj = JSON.parse(newFile.xhr.response);
            if (obj.error === "buy credits") {
              this.message_popup =
                "You do not have enough credits to message " +
                this.user_selected.show_name;
              this.dialog_message = true;
            } else {
              this.$root.$emit("open_dialog_message", {
                message: obj.error,
                message_title: "ERROR",
              });
            }

            this.privateMessages.pop();
          }
        }
      }
    },
    handleScroll() {
      var st = document.getElementById("chat_box").scrollTop;

      if (st === 0) {
        document
          .getElementById("chat_box")
          .removeEventListener("scroll", this.handleScroll);
        this.f_get_more_messages();
      }
    },

    f_select_message(message) {
      if (this.message_selected.id === message.id) {
        let element = this.$refs["id" + message.id][0];
        document.getElementById("chat_box").scrollTo(0, element.offsetTop);
      }
      this.message_selected = message;
      this.show_users = false;
      this.from_user = false;
    },
    f_select_user(user) {
      this.user_selected = user;
      this.show_users = false;
      this.from_user = true;
    },
    f_show_name(user) {
      return user.role_id === 1 ? user.display_name : user.name;
    },
    goToProfile(user) {
      if (user.view_profile) {
        window.open("/" + user.profile_link, "_self");
      } else {
      }
    },
    f_show_date_2(date) {
      let messageOld = moment(date.created_at);
      let new_date = moment(next.created_at).format("YYYY-MM-DD");
      if (messageOld.format("YYYY-MM-DD") !== new_date) {
        let messageNew = new Date(new_date);
        let diff = moment().diff(messageNew, "days");

        if (diff === 1) {
          return "Today";
        } else if (diff === 2) {
          return "Yesterday";
        } else if (diff > 2 && diff < 8) {
          return moment(messageOld).format("dddd");
        } else {
          return moment(messageOld).format("MM/DD/YYYY");
        }
      } else {
        {
          return "";
        }
      }
    },
    get_system_message(last_message) {
      
      if ((last_message.min_to_expire == 30) || (last_message.receiver_online)) {
        return "Thanks for your message! I will be with you shortly.";
      } else if (last_message.min_to_expire == 120) {
        return "I ‘m picking up on your energy! I’m finishing up a reading and will be with you soon.";
      } else {
        return "Hi there, I’m unavailable at the moment but you’ll have my full attention when I’m back online!";
      }
    },
  },
};
</script>

<style type="text/css" scoped>
.date_messages {
  font-size: 12px;
  text-align: center;
  width: fit-content;
  margin: auto;
  padding-bottom: 10px;
}
.chat_box {
  background-color: #f0f0f8;
  overflow-y: scroll;

  align-items: end;
  overflow-x: hidden;
}
.messages_title {
  font-size: 15px;
  font-weight: 500;
  padding-top: 7px;
  /* margin-top: 8px; */
}
.messages_subtitle {
  font-size: 12px;
  font-weight: 500;
  color: hsla(0, 0%, 0%, 0.38);
}
.user_btn_search {
  background-color: white;
  padding-left: 0px !important;
  padding-right: 0px !important;
}
.users_list {
  overflow-y: scroll;
  align-items: end;
  overflow-x: hidden;
}
.users_subtitle {
  font-weight: 600;
  color: black;
}
.user_hour {
  position: absolute;
  top: 4px;
  right: 10px;
  font-size: 10px;
  font-weight: 400;
  color: #656b72;
  opacity: 1;
}

.active {
  color: green;
}

.wrote {
  font-weight: bold;
}

.v-list {
  padding: 0 0;
}

.tittle_message {
  font-size: 20px;
  font-weight: 500;
  margin-top: 7px;
}

.margin {
  margin-bottom: 100px !important;
}

.online_users {
  color: #9759FF !important;
  font-size: 12px;
}

.upload-image {
  font-size: 23px;
  color: #847f7f8a;
  margin-top: 7px;
  cursor: pointer;
}

.card {
  cursor: pointer;
}

.messages {
  display: block;
  clear: both;
  float: left;
  width: 100%;
  max-width: 100%;
  
}

.container_messages {
  float: right;

  line-height: 130%;
}
.message_box {
  border-radius: 9px;
  padding: 6px 10px;
  font-weight: 400;
  font-size: 14px;
  /* box-shadow: rgba(0, 0, 0, 0.2) 0px 3px 1px -2px, rgba(0, 0, 0, 0.14) 0px 2px 2px 0px, rgba(0, 0, 0, 0.12) 0px 1px 5px 0px; */
  white-space: -moz-pre-wrap !important;
  white-space: -webkit-pre-wrap;
  white-space: -pre-wrap;
  white-space: -o-pre-wrap;
  white-space: pre-wrap;
  word-wrap: break-word;
  /* word-break: break-all; */
  white-space: normal;
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

.icon_play {
  font-size: 36px;
  background-color: white;
  border-radius: 100%;
  position: absolute;
  transform: translate(256%, 132%);
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

/* modal image*/
/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

@keyframes zoom {
  from {
    transform: scale(0);
  }
  to {
    transform: scale(1);
  }
}

/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px) {
  .modal-content {
    width: 100%;
  }
}
>>> i.fa-search {
  font-size: 16px !important;
}

.spinner-border {
  position: absolute;
  right: 48%;
  top: 10px;
  border-radius: 100%;
  color: #8ebef8 !important;
}
.badge-blue {
  color: #fff;
  background-color: #3490dc;
}
.inactive_item {
  border-left: 5px solid white;
}
.active_item {
  border-left: 5px solid #8ebef8;
  background-color: #ebf4fd;
}
.unread_messages {
  border-left: 5px solid #8ebef8;
}
.users_chat {
  min-height: 79px !important;
  border-bottom: 1px solid #e7e8e8ad;
}

>>> .custom-placeholer-color input::placeholder {
  font-size: 14px;
  color: #c7c7c7;
  opacity: 1;
}

>>> .custom-label-color .v-label {
  color: #c7c7c7 !important;
  font-size: 14px !important;
}
>>> .custom-icon .v-input__control .v-input__slot {
  min-height: 35px !important;
}
>>> .custom-icon .v-input__control {
  min-height: 35px !important;
}
>>> .custom-icon i.fa-search {
  font-size: 14px !important;
}
>>> .custom-icon i.mdi-close {
  color: #c7c7c7 !important;
}

>>> .dot_border {
  border-color: #fff !important;
  border-width: 2px !important;
  border-style: solid !important;
  min-width: 25px;
  height: 25px;
  top: 105px !important;
  right: 0px !important;
  left: 125px !important;
  bottom: 0px !important;
  border-radius: 18px;
}
>>> .dot_border_users {
  border-color: #fff !important;
  border-width: 2px !important;
  border-style: solid !important;
  min-width: 15px;
  height: 15px;
  top: 35px !important;
  right: 0px !important;
  left: 35px !important;
  bottom: 0px !important;
  border-radius: 6.5px;
}

::placeholder {
  /* Chrome, Firefox, Opera, Safari 10.1+ */
  font-size: 14px;
  color: #c7c7c7;
  opacity: 1; /* Firefox */
}

:-ms-input-placeholder {
  /* Internet Explorer 10-11 */
  font-size: 14px;
  color: #c7c7c7;
  opacity: 1;
}

::-ms-input-placeholder {
  /* Microsoft Edge */
  font-size: 14px;
  color: #c7c7c7;
  opacity: 1;
}
.title_messages_found {
  background-color: #8ebef8;
  font-size: 12px;
  color: white !important;
  min-height: 30px;
}

.highlightText {
  background: yellow !important;
}
.user_avatar_list {
  backface-visibility: hidden;
  display: inline-block;
  overflow: hidden;
  border-radius: 50%;
  width: 52px;
  height: 52px;
  background-size: cover;    
}
.user_avatar_chat {
  backface-visibility: hidden;
  display: inline-block;
  overflow: hidden;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  background-size: cover;
}
.message {  
    display: block;
    text-align: center;
    font-size: 16px;
    color: #1F1E34 !important;
    font-weight: 600;
}
.no_message_user_chat {
  -webkit-box-align: center !important;
  align-items: center !important;
  align-self: center !important;
  display: -webkit-box !important;
  display: flex !important;
}

::-webkit-scrollbar-track {
  background: white;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px #ffffff;
}

::-webkit-scrollbar {
  width: 7px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #8ebef8;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #ffffff;
}
>>> .v-textarea.v-text-field--solo .v-input__append-inner {
  margin-top: 7px !important;
  margin-right: 4px !important;
}
>>> .v-textarea.v-text-field--enclosed .v-text-field__slot textarea {
  margin-top: 4px;
}
/* >>>.theme--light.v-icon {
    color:#847f7f8a;
} */
>>> .v-text-field.v-input--dense:not(.v-text-field--outlined) input {
  margin-top: 1px !important;
  padding-top: 0px !important;
}
>>> #icon_search_blur {
  background-image: url("/images/icons/search.png");
  background-repeat: no-repeat;
  background-position: left;
  padding-left: 25px;
}
>>> #icon_search_focus {
  background-image: url("/images/icons/search_focus.png");
  background-repeat: no-repeat;
  background-position: left;
  font-size: 14px;
  padding-left: 25px;
}
>>> #icon_send_blur {
  background-image: url("/images/icons/search.png");
  background-repeat: no-repeat;
  background-position: left;
  padding-left: 25px;
}
>>> #icon_send_focus {
  background-image: url("/images/icons/search_focus.png");
  background-repeat: no-repeat;
  background-position: left;
  font-size: 14px;
  padding-left: 25px;
}
>>> .theme--light.v-icon {
  font-size: 20px !important;
  color: #847f7f8a !important;
}
>>> .fa.fa.fa.fa-send-o.theme--light.blue--text {
  color: #64b5f6 !important;
}

>>> .textList,
.v-input,
.v-input::before,
.v-input::after,
.v-label:hover,
.v-label::before,
.v-label::after {
  font-size: 14px !important;
}
.users_chat span {
  display: flex;
}

>>> .v-text-field.v-input--dense:not(.v-text-field--outlined) input {
  padding: 0px;
}

>>> .magnifyInput,
.magnifyInput .v-input__slot {
  min-height: 35px !important;
  height: 35px !important;
}

.magnifyInput .v-icon.v-icon {
  margin-top: 0px !important;
}

.mobileChat {
  padding: 15px 0px 15px 0px !important;
  height: 65px !important;
  
  
}

.desktopChat {
  padding: 13px 0px 12px 0px !important;
  height: 60px !important;
}
>>>textarea{
  line-height: 1.5 !important;
}
>>>.v-textarea--auto-grow  .v-text-field__slot{
   max-height: 80px;
    overflow-y: scroll;
}
.v-dialog__content--active {
    opacity: 1 !important;
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
}

</style>