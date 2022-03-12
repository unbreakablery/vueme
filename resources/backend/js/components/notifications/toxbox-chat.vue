<template>
  <div class="mx-2 mt-0">
    <v-menu
      style="width: 375px !important;"
      offset-y
      v-model="menu_opened"
      left
      nudge-right="25"
      z-index="301"
      :content-class="(header === 'header2') ? 'tokbox-notifications my-menu height-100 tokbox-notifications-model' : 'tokbox-notifications my-menu height-100'"
      :close-on-content-click="false"
    >
      <template v-slot:activator="{ on }">
        <a v-on="on" style="position: relative;">
          <!-- <i :style="{color: color, fontSize: size}" class="far fa-bell fa-2x"></i> -->
          <!-- <div  v-if="text_chat_notifications" class="text_notifications" >{{text_chat_notifications}}</div>-->
          <!-- <span
            v-if="video_notifications"
            style="position: absolute; right: -11px; top: -7px"
            class="badge badge-blue badge-pill text_notifications"
          >{{ video_notifications }}</span> -->
          <div class="notification-image">
                 <!-- <img v-if="text_chat_notifications" src="images/icons/Bell_Notification.svg" />
                 <img v-else src="images/icons/Bell_Inactive_white.svg" />
                </div>
                <div class="d-none d-md-inline">
                <img v-if="video_notifications" src="images/icons/Bell_Notification.svg" />
                <img v-else src="images/icons/Bell_Inactive.svg" /> -->
                 <img :src='get_full_url("icon_notification_desktop")' />
          </div>

        </a>
      </template>

      <v-card width="375" style="border-radius: 5px !important;" class="height-100">
        <v-list class="px-5 height-100" style="background-color: #F9F9F9;" :style="[all_notifications.length > 4 ? {'overflow-y': 'auto','height': '77vh'} :{}]">
          <v-list-item class="py-0 " dense>
            <v-list-item-title class="header_notifications mb-5 mt-5 d-sm-block">Notifications</v-list-item-title>
          </v-list-item>



             <v-list-item class="px-0 " v-if="!all_notifications.length">


                <div style="min-height: 126px;" class="mb-4 shadow d-flex justify-content-center align-items-center">

                            <div class="row mx-0">

                                <v-list-item-content class="d-block" style="width: 335px;">
                                  <div style="width: fit-content; margin-left: 40px">
                                    <img :src="get_full_url('/images/icons/notifications/noNotifications.svg')" />
                                    <div style="display:inline-flex;color: #C7C7C7;font-size: 14px;padding-left: 15px;">Currently Empty</div>
                                  </div>
                                </v-list-item-content>

                            </div>

                </div>
            </v-list-item>




          <v-list-item class="px-5"   v-for="(notification, index) in all_notifications" :key="notification.id">


                <div  style="min-height: 126px;" :style="[notification.color == 'color_blue'?{'background-color': '#fff'}:{'background-color': 'white'}]" class="mb-4 shadow">
                            <!-- <div v-if="notification.close" class="mb-2" style="position: absolute;right: 25px;top: 5px;z-index: 5;">
                              <v-icon class="text-right" @click="checkNotification(notification,'close')">mdi-close</v-icon>
                            </div> -->
                            <div class="row mx-0">

                             
                                  <div class="user_avatar_list" style="width: 56px; height: 56px; margin: 16px!important" :style="{ 'background-image': 'url(' + notification.profile_headshot_url  + ')' }">

                                  </div>
                             



                       <v-list-item-content style="padding-top: 16px !important;padding-bottom: 5px;">

                              <v-list-item-title>
                                  {{show_name(notification.from)}}
                              </v-list-item-title>
                              <v-list-item-subtitle style="font-size: 11px;font-weight: 600;color: #949498 !important;margin-top: 3px;margin-bottom:0">
                              <!-- {{notification.action_description}} -->
                              Replay Available
                            </v-list-item-subtitle>

                            <v-list-item-subtitle v-if="notification.action_description_2" style="font-size: 11px;font-weight: 600;color: #949498 !important;margin-top: 3px;margin-bottom:0">
                              {{notification.action_description_2}}
                            </v-list-item-subtitle>

                              <v-list-item-subtitle v-if="notification.request_description" style="font-size: 12px;font-weight: 500;color: #131220 !important;margin-top: 3px;margin-bottom:0">
                              {{notification.request_description}}
                            </v-list-item-subtitle>
                            <div class="text_button d-flex mt-3">
                              <!-- <div class="mr-3" @click="checkNotification(notification,'first')"><img :src="get_full_url(notification.first_image)" />{{notification.first_text}}</div>
                              <div @click="checkNotification(notification,'second')"><img v-if="notification.second_image" :src="get_full_url(notification.second_image)" />{{notification.second_text}}</div> -->
                              <div style="margin-right: 30px" @click="checkNotification(notification,'second')"><img src="/images/icons/notifications/purchase.png" style="width: 37px; margin-right: 8px" />Purchase</div>
                              <div @click="checkNotification(notification,'first')"><img src="/images/icons/notifications/decline.svg" />Decline</div>
                            </div>
                        </v-list-item-content>
                </div>
                </div>
            </v-list-item>

        </v-list>
      </v-card>
    </v-menu>




    <v-dialog  v-model="user_tokbox" width="100%" :persistent="true" :fullscreen="true" content-class="tokbox-overlay">
      <v-card color="#000000"  style="height:100%">
        <v-card-text class="p-0" style="background-color: rgb(0,0,0);height:100%">


          <div   v-if="$vuetify.breakpoint.xsOnly" id="tokbox-timer" style="color: #fff; text-align: right;position:absolute;z-index:20;top: 24px;right: 24px;background: rgba(0, 0, 0, 0.4);padding: 2px 14px;border-radius: 7px;">{{ display_timer }}</div>

          <div id="tokbox-videos">

            <div id="tokbox-subscriber"></div>
            <div v-show="user_alert.service_id == 3" id="tokbox-publisher"></div>
          </div>

          <div id="tokbox-buttons" class="mt-3" style="text-align: center;">
            <img src="/images/icons/muted.png" class="mr-4" v-if="!publisherAudio" @click="setPublisherAudio()"  style="cursor: pointer;width:56px;height:56px" />
                    <img src="/images/icons/mute.png" class="mr-4" v-else @click="setPublisherAudio()"  style="cursor: pointer;width:56px;height:56px" />

                    &nbsp;
                    &nbsp;
                    &nbsp;

            <img src="/images/icons/phone_red.png"
              style="cursor: pointer;width:56px;height:56px"
              @click="user_end_video_call()"
            />
             <span   v-if="$vuetify.breakpoint.smAndUp" id="tokbox-timer" style="color: #fff; position: absolute; right: 20%;margin-top: 15px;">{{ display_timer }}</span>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="model_tokbox"
      width="100%"
      :persistent="true"
      :fullscreen="true"
      content-class="tokbox-overlay"
    >
      <v-card color="#000000" style="height:100%">
        <v-card-text class="p-0" style="background-color: rgb(0,0,0);height:100%">

          <div v-if="$vuetify.breakpoint.xsOnly" id="tokbox-timer" style="color: #fff; text-align: right;position:absolute;z-index:20;top: 24px;right: 24px;background: rgba(0, 0, 0, 0.4);padding: 2px 14px;border-radius: 7px;">{{ display_timer }}</div>

          <div id="tokbox-videos">
            <div v-if="the_other_user && requestSate == 'WAITING'" style="color: white; position: absolute; top: 50%; margin-top: -50px; padding: 15px;left:0;right:0">
                    <div class="text-center" style="font-family: 'Montserrat', sans-serif !important; font-weight: 500; font-size:24px; margin-top:16px;">
                     Waiting for {{the_other_user.profile.name}} to join…
                    </div>
                    </div>
            <div v-else-if="the_other_user" style="color: white; position: absolute; left: 50%; top: 50%; margin-left: -100px; margin-top: -150px;">
                        <div class="text-center">
                    <div
                     class="profile_avatar"
                     :style="{ 'background-image': 'url(' + the_other_user.profile.profile_headshot_url + ')', overflow: 'visible', width: '200px', height: '200px' }"
                     >
                     </div>
                    <div style="font-family: 'Montserrat', sans-serif !important; font-weight: 600; font-size:24px; margin-top:16px;max-width: 200px">
                     {{the_other_user.profile.name}}
                    </div>
                  </div>
                    </div>
            <div   id="tokbox-subscriber"></div>
            <div v-show="(!the_other_user || requestSate != 'WAITING' ) && model_alert.service_id == 3" id="tokbox-publisher"></div>
          </div>

          <div id="tokbox-buttons" class="mt-3" style="text-align: center;">
            <img src="/images/icons/muted.png"  class="mr-4" v-if="!publisherAudio" @click="setPublisherAudio()"  style="cursor: pointer;width:56px;height:56px" />
                    <img src="/images/icons/mute.png" class="mr-4" v-else @click="setPublisherAudio()"  style="cursor: pointer;width:56px;height:56px" />

                    &nbsp;
                    &nbsp;
                    &nbsp;

            <img src="/images/icons/phone_red.png"
              style="cursor: pointer;width:56px;height:56px"
              @click="end_video_call()"
            />
             <span   v-if="$vuetify.breakpoint.smAndUp" id="tokbox-timer" style="color: #fff; position: absolute; right: 20%;margin-top: 15px;">{{ display_timer }}</span>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>


      <!--- Model received request tokbox -->

     <!---- new --->
       <!-- <v-dialog v-if="request_dialog" v-model="request_dialog" max-width="360px">
          <v-card>

              <v-card-text class="text-center pt-10">
                  <div
                          class="profile_avatar"
                          :style="{ 'background-image': 'url(' + model_alert.user.profile.profile_headshot_url + ')' }"
                  ></div>

                  <h5 style="margin-top: 20px; margin-bottom: 15px;color:black;">
                      {{ model_alert.user.profile.name }} wants to <span v-if="model_alert.service_id == 1">call you</span> <span v-else-if="model_alert.service_id == 3">video chat</span>.
                  </h5>

                     <div class="d-flex" style="margin-top:60px">
                                        <div class="col-6 text-center">
                        <v-btn
                        :loading="acceptLoading" :disabled="acceptLoading"
                        @click="denyVChatRequest(model_alert.id)"
                        class="m-auto" height="80px" width="80px" color="#e75647cc" elevation="0" fab x-large>
                        <v-icon  style="color:white !important" size="38">mdi-close</v-icon>
                        </v-btn>
                        <label class="mt-2 d-block" style="color:#e75647cc !important;font-weight: 600 !important;"> Deny</label>
                    </div>
                    <div class="col-6 text-center">
                        <v-btn
                        :loading="acceptLoading" :disabled="acceptLoading"
                        @click="acceptVChatRequest(model_alert.id)"
                        class="m-auto" height="80px" width="80px" color="#2CC05F" elevation="0" fab x-large >
                        <v-icon v-if="model_alert.service_id == 1" size="40" color="white">mdi-phone</v-icon>
                        <v-icon v-if="model_alert.service_id == 3" size="40" color="white">mdi-video</v-icon>
                        </v-btn>
                        <label style="color:#2CC05F !important;font-weight: 600 !important;" class="mt-2 d-block"> Accept</label>
                    </div>


                        </div>
              </v-card-text>
          </v-card>
      </v-dialog> -->
     <!-- end new ----->

     <!--- Model received request tokbox -->
    <v-dialog v-if="request_dialog" v-model="request_dialog" width="335px">
      <v-card  color="#F0F0F8">
         <v-card-text class="text-center">


                                 <div class="user_avatar_list" style="margin: 50px 15px 20px;width: 100px;height: 100px;" :style="{ 'background-image': 'url(' + model_alert.user.profile.profile_headshot_url  + ')' }">
                                </div>

                            <v-list-item-content class="py-0">
                              <v-list-item-title style="font-size: 18px !important;font-weight: 600;color: #1F1E34 !important;">
                                  {{model_alert.user.profile.name}}
                              </v-list-item-title>
                              <v-list-item-subtitle class="mt-1" style="font-size: 14px;color: #1F1E34 !important;font-weight: 500;">
                              {{model_alert.request_description}}
                            </v-list-item-subtitle>

                              <v-list-item-subtitle v-if="!model_alert.schedule" class="mt-5" style="font-size: 16px;color: #FFAC3B !important;font-weight: 500;">Requested: Now</v-list-item-subtitle>
                              <v-list-item-subtitle v-if="model_alert.schedule" class="mt-5" style="font-size: 16px;color: #1F1E34 !important;font-weight: 500;">Begin Scheduled Reading</v-list-item-subtitle>
                        </v-list-item-content>

                    <div class="d-flex" style="margin: 30px 0px 27px">
                                        <div class="col-6 text-center">
                        <v-btn  height="40px" width="40px"
                        :loading="acceptLoading" :disabled="acceptLoading"
                        @click="denyVChatRequest(model_alert.id)"
                        class="m-auto"  elevation="0" fab>
                        <!-- <v-icon  style="color:white !important" size="38">mdi-close</v-icon> -->
                        <img :src="get_full_url('/images/icons/notifications/decline_50x50.svg')" />
                        </v-btn>
                        <label class="d-block text_button_desktop mt-3" style=""> Decline</label>
                    </div>
                        <div class="col-6 text-center">
                        <v-btn height="40px" width="40px"
                        :loading="acceptLoading" :disabled="acceptLoading"
                        @click="acceptVChatRequest(model_alert.id)"
                        class="m-auto" elevation="0" fab >
                         <img v-if="model_alert.service_id == 3"  :src="get_full_url('/images/icons/notifications/video_start_50x50.svg')" />
                         <img v-if="model_alert.service_id == 1"  :src="get_full_url('/images/icons/notifications/call_start_50x50.svg')" />

                        </v-btn>
                        <label class="d-block text_button_desktop mt-3"> Start</label>
                       </div>

                        </div>
        </v-card-text>
      </v-card>
    </v-dialog>

     <!--- End Model received request tokbox -->



     <!--- User received model accepted  request tokbox -->

      <v-dialog v-if="join_dialog" v-model="join_dialog" width="335px">
      <v-card color="#F0F0F8">
         <v-card-text class="text-center">


                          <v-badge  style="margin: 50px 15px 20px;"  :color="user_alert.model.online ? 'green mb-4 mr-8 dot_border_users_desktop' : 'grey mb-4 mr-8 dot_border_users_desktop'" dot  bordered bottom >
                                 <template  class="" v-slot:badge>{{''}}</template>
                                  <div class="user_avatar_list" style="width: 100px;height: 100px;" :style="{ 'background-image': 'url(' + user_alert.model.profile.profile_headshot_url  + ')' }">

                                  </div>
                                </v-badge>

                                 <!-- <div class="user_avatar_list" style="margin: 50px 15px 15px;width: 100px;height: 100px;" :style="{ 'background-image': 'url(' + model_alert.user.profile.profile_headshot_url  + ')' }">
                                </div> -->

                            <v-list-item-content class="py-0">
                              <v-list-item-title style="font-size: 18px !important;font-weight: 600;color: #1F1E34 !important;">
                                  {{user_alert.model.profile.display_name}}
                              </v-list-item-title>
                              <v-list-item-subtitle class="mt-1" style="font-size: 14px;color: #1F1E34 !important;">
                              {{user_alert.request_description}}
                            </v-list-item-subtitle>

                              <v-list-item-subtitle v-if="!user_alert.schedule" class="mt-5" style="font-size: 16px;color: #3B86FF !important;font-weight: 500;">Accepted, Join Reading</v-list-item-subtitle>
                              <v-list-item-subtitle v-if="user_alert.schedule" class="mt-5" style="font-size: 16px;color: #1F1E34 !important;font-weight: 500;">Join Scheduled Reading</v-list-item-subtitle>
                        </v-list-item-content>

                    <div class="d-flex" style="margin: 30px 0px 27px;">
                                        <div class="col-6 text-center">
                        <v-btn  height="40px" width="40px"
                        :loading="loadingCancel" :disabled="loadingCancel"
                        @click="cancelVChatRequest(user_alert)"
                        class="m-auto"  elevation="0" fab>
                        <!-- <v-icon  style="color:white !important" size="38">mdi-close</v-icon> -->
                        <img :src="get_full_url('/images/icons/notifications/decline_50x50.svg')" />
                        </v-btn>
                        <label class="d-block text_button_desktop mt-3"> Cancel</label>
                    </div>
                        <div class="col-6 text-center">
                        <v-btn height="40px" width="40px"
                        :loading="acceptLoading" :disabled="acceptLoading"
                        @click="joinVideoChat(user_alert)"
                        class="m-auto" elevation="0" fab >
                         <img v-if="user_alert.service_id == 3"  :src="get_full_url('/images/icons/notifications/video_start_50x50.svg')" />
                         <img v-if="user_alert.service_id == 1"  :src="get_full_url('/images/icons/notifications/call_start_50x50.svg')" />

                        </v-btn>
                        <label  class="d-block text_button_desktop mt-3"> Join</label>
                       </div>

                        </div>
        </v-card-text>
      </v-card>
    </v-dialog>
     <!--- End User received model accepted  request tokbox -->



    <!-- <v-dialog v-if="join_dialog" v-model="join_dialog" max-width="360px">
      <v-card color="#eff6ff">
        <div class="text-right mb-2">
          <v-btn icon light @click="join_dialog = false;" class="right">
            <i class="fas fa-times"></i>
          </v-btn>
        </div>
        <v-card-text class="text-center">
          <div
            class="user_avatar_2x"
            :style="{ 'background-image': 'url(' + user_alert.model.profile.profile_headshot_url + ')' }"
          ></div>

          <div style="margin-top: 30px; margin-bottom: 25px;font-size:20px">
            {{ user_alert.model.profile.display_name }} is ready
            <span
              v-if="user_alert.service_id == 1"
            >to call you</span>
            <span v-else-if="user_alert.service_id == 3">to video chat</span>.
          </div>

          <v-btn
            depressed
            rounded
            color="#8fbef8"
            class="white--text"
            @click="joinVideoChat(user_alert)"
          >Begin Reading</v-btn>
        </v-card-text>
      </v-card>
    </v-dialog> -->

    <v-dialog v-if="denied_dialog" v-model="denied_dialog" max-width="360px">
      <v-card>
        <div class="text-right mb-2">
          <!-- <v-btn icon light @click="denied_dialog = false;" class="right">
            <i class="fas fa-times"></i>
          </v-btn> -->
        </div>
        <v-card-text class="text-center">
          <a :href="'/'+user_alert.model.profile.profile_link">
            <div
              class="profile_avatar"
              :style="{ 'background-image': 'url(' + user_alert.model.profile.profile_headshot_url + ')' }"
            ></div>
          </a>

          <h5 style="margin-top: 30px; margin-bottom: 15px;">
            Your
            <span v-if="user_alert.service_id == 1">call</span>
            <span v-else-if="user_alert.service_id == 3">video chat</span>
            with
            {{ user_alert.model.profile.display_name }} was canceled.
          </h5>

          <v-btn
            class="btn-primary"
            style="color: #000 !important;"
            depressed
            rounded
            @click="denied_dialog = false"
          >Close</v-btn>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="end_of_vhcat_alert"
      width="420px"
      style="z-index: 405;"
    >
      <v-card color="#F0F0F7">
        <v-card-text style="padding: 30px 20px;">

          <div class="text-center">
            <h3>Your reading is complete.</h3>

            <p>
              For questions please contact
              <a
                href="mailto:support@respectfully.com"
              >support@respectfully.com</a>
            </p>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="low_credits_alert" width="420px">
      <v-card color="#eff6ff">
        <v-card-text style="padding: 15px 20px;">
          <div class="text-right mb-2">
            <v-btn icon light @click="low_credits_alert = false" class="right">
              <i class="fas fa-times"></i>
            </v-btn>
          </div>

          <div class="text-center">
            <div style="font-size: 20px">You are running out of funds.</div>

            <p>
              <v-btn
                depressed
                rounded
                color="primary"
                class="white--text mt-5"
                @click="add_credits()"
              >Reload Wallet</v-btn>
            </p>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>







       <!--- Model received new scheduled appointment -->
    <v-dialog v-if="new_scheduled_appointment" v-model="new_scheduled_appointment" width="335px">
      <v-card color="#F0F0F8">
         <v-card-text class="text-center">


                                 <div class="user_avatar_list" style="margin: 50px 15px 15px;width: 100px;height: 100px;" :style="{ 'background-image': 'url(' + scheduled_appointment.profile_headshot_url  + ')' }">
                                </div>

                            <v-list-item-content class="py-0">
                              <v-list-item-title style="font-size: 18px !important;font-weight: 600;color: #1F1E34 !important;">
                                  {{scheduled_appointment.from}}
                              </v-list-item-title>
                              <v-list-item-subtitle class="mt-1" style="font-size: 14px;font-weight: 500 !important;color: #1F1E34 !important;">
                              {{scheduled_appointment.request_description}}
                            </v-list-item-subtitle>

                              <v-list-item-subtitle class="mt-5" style="font-size: 16px;font-weight: 500 !important;color: #FFAC3B !important;">
                              {{scheduled_appointment.action_description}}
                            </v-list-item-subtitle>
                        </v-list-item-content>

                    <div class="d-flex" style="margin: 30px 0px;">
                                        <div class="col-6 text-center">
                        <v-btn  height="40px" width="40px"
                        :loading="loadingUpdate" :disabled="loadingUpdate"
                        @click="checkNotification(scheduled_appointment,'second')"
                        class="m-auto"  elevation="0" fab>
                        <!-- <v-icon  style="color:white !important" size="38">mdi-close</v-icon> -->
                        <img :src="get_full_url(scheduled_appointment.second_image_50)" />
                        </v-btn>
                        <label class="d-block text_button_desktop mt-3" style=""> {{scheduled_appointment.second_text}}</label>
                    </div>
                        <div class="col-6 text-center">
                        <v-btn height="40px" width="40px"
                        :loading="loadingUpdate" :disabled="loadingUpdate"
                        @click="checkNotification(scheduled_appointment,'first')"
                        class="m-auto" elevation="0" fab >
                            <img :src="get_full_url(scheduled_appointment.first_image_50)" />

                        </v-btn>
                        <label class="d-block text_button_desktop mt-3"> {{scheduled_appointment.first_text}}</label>
                       </div>

                        </div>
        </v-card-text>
      </v-card>
    </v-dialog>

      <!--- End Model received new scheduled appointment -->

    <!-- <v-dialog
      v-if="new_scheduled_appointment"
      v-model="new_scheduled_appointment"
      max-width="550px"
    >
      <v-card color="#eff6ff">
        <div class="text-right mb-2">
          <v-btn icon light @click="new_scheduled_appointment = false;" class="right">
            <i class="fas fa-times"></i>
          </v-btn>
        </div>
        <v-card-text class="py-md-3 px-md-10">
          <div
            style="margin-top: 15px; margin-bottom: 25px;font-size:20px"
            class="text-center"
          >{{scheduled_appointment.client_name}} requested a reading</div>
          <div class="row my-10">
            <div class="col-6 box_field_dialog">
              Service
              <div class="text_field_dialog">{{scheduled_appointment.service_name}}</div>
            </div>
            <div class="col-6 box_field_dialog">
              Date
              <div class="text_field_dialog">{{scheduled_appointment.date | formatDate }}</div>
            </div>
            <div class="col-12 box_field_dialog mt-7">
              Time & Duration
              <div class="text_field_dialog">
                {{scheduled_appointment.start | formatDate("h:mm a")}}
                <span style="color:grey">for</span>
                {{scheduled_appointment.duration}}
              </div>
            </div>
          </div>
          <div class="row my-5">
            <div class="col-12 text-center">
              <v-btn
                style="background-color:white"
                depressed
                large
                rounded
                outlined
                color="#8fbef8"
                class="mr-4"
                @click="updateAppointmentStatus(scheduled_appointment, 'Cancelled')"
                :loading="loadingUpdate"
              >Deny</v-btn>

              <v-btn
                depressed
                rounded
                large
                color="#8fbef8"
                class="white--text ml-4"
                @click="updateAppointmentStatus(scheduled_appointment, 'Confirmed')"
                :loading="loadingUpdate"
              >Confirm</v-btn>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog> -->

    <v-dialog v-model="dialogPermission" max-width="335px">
      <v-card>
        <div class="text-right">
          <!-- <v-btn icon light @click="dialogPermission = false;" class="right">
            <i class="fas fa-times"></i>
          </v-btn> -->
        </div>
        <v-card-text class="pb-4 pt-12 px-md-10 text-center" style="color: #1f1e34 !important; font-size:13px">
          <div
            style="margin-top: 0px;font-size:20px"
            class="font-weight-bold"
          ><i class="fa fa-exclamation" aria-hidden="true" style="color: #EB4F59; border: 3px solid #EB4F59; padding: 10px 16px; border-radius: 50%;"></i></div>
          <div
            style="margin-top: 15px; margin-bottom: 25px;font-size:16px"
            class="font-weight-bold"
          >Enable Mic & Camera</div>
          <div class="row my-5">
            <div class="col-12" style="font-size:14px">
                Be sure you configure your browser settings to allow
              <span class="font-weight-bold">Microphone</span> and
              <span class="font-weight-bold">Camera</span>.
            </div>
          </div>

          <div class="row my-5">
            <div class="col-12" style="color: rgba(0, 0, 0, 0.25); cursor: pointer">
              <div v-if="!seeMore" @click="seeMore = true">
                <span style="text-decoration: underline">Additional Help</span>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </div>
              <div v-else @click="seeMore = false">
                <span style="text-decoration: underline">Hide</span>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </div>
            </div>
          </div>

          <div class="row my-5" v-show="seeMore">
            <div
              class="col-12"
            >Chrome & Firefox: go to browser settings > site settings > set mic and camera to “allow”</div>
            <div class="col-12 mt-5"
            >Safari: go to settings > Safari > set mic and camera to "allow"</div>


          </div>

          <div class="row mt-5">
            <div class="col-12 text-center">

              <v-btn
                depressed
                rounded
                large
                color="primary"
                class="white--text"
                @click="continueBtn"
              >Continue</v-btn>
            </div>
          </div>

          <div class="row mt-0">
            <div
              class="col-12 d-flex justify-center"
            >
            <v-checkbox v-model="noDisplayAgain" color="primary" >
               <template v-slot:label>
                 <div style="color: rgba(0, 0, 0, 0.25); font-size:13px">
                  Don’t display again
                 </div>
               </template>
            </v-checkbox>

            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogBrowser" max-width="335px">
      <v-card color="#F0F0F7">
        <div class="text-right">
         <v-btn color="#A2A2A2" icon light @click="dialogBrowser = false;" class="right">
            <i class="fas fa-times"></i>
          </v-btn>
        </div>
        <v-card-text class="pb-10 pt-5 px-md-3 text-center" style="color: #1f1e34 !important; font-size:13px">
          <div
            style="margin-top: 0px;font-size:20px"
            class="font-weight-bold"
          ><i class="fa fa-exclamation" aria-hidden="true" style="color: #EB4F59; border: 3px solid #EB4F59; padding: 10px 16px; border-radius: 50%;"></i></div>
          <div v-if="user.browserSupported && user.browserSupported[0] != 'SUPPORTED'"
            style="margin-top: 15px; margin-bottom: 15px;font-size:16px"
            class="font-weight-bold"
          >{{user.browserSupported[1]}}</div>
          <div class="row my-5">
            <div class="col-12" style="font-size:14px">

            </div>
          </div>


          <div class="row mt-3" v-if="user.browserSupported && user.browserSupported[0] == 'DOWNLOAD'">
            <div class="col-12 text-center">

              <v-btn
                depressed
                rounded
                color="primary"
                class="white--text"
                :href="user.browserSupported[3]"
              >{{user.browserSupported[2]}}</v-btn>
            </div>
          </div>
          <div class="row mt-3" v-else-if="user.browserSupported && user.browserSupported[0] == 'ADVICE'">
            <div class="col-12 text-center">

              <v-btn
                depressed
                rounded
                color="primary"
                class="white--text"
                @click="continueBtn1"
              >{{user.browserSupported[2]}}</v-btn>
            </div>
          </div>


        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment from "moment";
import {mapGetters} from 'vuex';
// import DetectRTC from "detectrtc";
export default {
  props: ["user", "color", "size", "header"],
  data: function() {
    return {
      low_credits_alert: false,
      video_notifications: 0,
      userChatRequests: [],
      modelChatRequests: [],
      userNotifications:[],
      current_notification:{},
      acceptLoading: false,
      menu_opened:false,
      request_message: "",



      tokbox_notes_menu: false,
      model_tokbox: false,
      user_tokbox: false,
      the_other_user: false,
      requestSate: false,
      publisherAudio: true,
      end_of_vhcat_alert: false,
      join_dialog: false,
      denied_dialog: false,
      cancelDialog: false,
      request_dialog: false,

      tokbox_session: {},
      tokbox_subscriber: {},
      tokbox_caster: {},
      chat_service_id: 0,
      model_chat_room_id: 0,
      chat_request_id: 0,

      other_user_joined_at: new Date(),
      display_timer: "00:00:00",
      timer_loop: {},
      user_alert: {},
      model_alert: {},
      loadingCancel: false,
      new_scheduled_appointment: false,
      loadingUpdate: false,
      scheduled_appointment: {},

      dialogPermission: false,
      dialogBrowser: false,
      seeMore: false,
      noDisplayAgain: false,
      joinVideoChatAux: false,
      acceptVChatRequestAux: false,
      joinVideoChatAux1: false,
      acceptVChatRequestAux1: false,
      browserAux: true,

    };
  },
  computed:{
    all_notifications() {


                 const all_notifications_aux = this.modelChatRequests.filter((notification2) => {

                     if(notification2.state == 'WAITING'){
                         return false;
                     }
                     return true;
                     })

                let all_notifications = this.userChatRequests.concat(this.userNotifications,all_notifications_aux);

                all_notifications.sort((a, b) => {
                        let first =new Date(a.updated);
                        let second =new Date(b.updated);

                     return second - first;

                  });
              return all_notifications;

    },
    ...mapGetters({
        mobile: 'util/mobile'
    }),
  },
  mounted() {




  },
  created() {
    /* Chat notifications*/
    this.f_get_notifications();
    //this.get_notifications_in_app();
    Echo.private("privatevideo." + this.user.id)
      .listen("VideoPrivateSent", data => {
        console.log("start1");
        this.model_alert = data.request.request;
        this.request_dialog = true;
        this.get_notifications_in_app();


      })
      .listen("NotificationsInAppEvent", data => {

        this.get_notifications_in_app();
        if(data.data.action == 'model_canceled_request' || data.data.action == 'expired_request'){
         this.$root.$emit("canceled_or_expired_request", {});
         this.$root.$emit("close_standard_dialog");
        }
        if(data.data.action == 'schedule_appointment'){

          if(!this.new_scheduled_appointment){
             this.scheduled_appointment = data.data;
             this.new_scheduled_appointment = true;
          }
        }
        if( data.data.action == 'to_psychic_user_canceled_request') {
          if((this.request_dialog || this.model_tokbox) && this.model_alert.id == data.data.key){

            this.request_dialog = false;
            this.model_tokbox =false;
            this.model_alert = {};
          }

        }

        if(data.data.action == 'to_psychic_schedule_appointment_cancelled'){
          if(this.new_scheduled_appointment && this.scheduled_appointment.key == data.data.key){
            this.new_scheduled_appointment = false;
            this.scheduled_appointment = {};
          }

        }


      })
      .listen("ModelAcceptTokboxChat", data => {
        console.log("start2");
        this.$root.$emit("close_standard_dialog");
        this.user_alert = data.request;
        this.join_dialog = true;
         this.get_notifications_in_app();

      })
      .listen("ModelCancelsTokboxChat", data => {
        this.join_dialog = false;
        this.get_notifications_in_app();

      })
      .listen("FanCancelsTokboxChat", data => {
        console.log("start5");
        this.request_dialog = false;

        // var index_maybe = this.modelChatRequests
        //   .map(p => {
        //     return p.id;
        //   })
        //   .indexOf(data.request.id);
        // console.log("start6");
        // console.log(index_maybe);

        // this.$delete(this.modelChatRequests, index_maybe);

         this.get_notifications_in_app();
      });
    /* End Chat notifications*/

    EventBus.$on("new_chat_request", chat_request => {
      this.addNotification(chat_request);
    });
    EventBus.$on("cancel_chat_request", chat_request => {
      this.show_dialog_after_video_call_end();
      this.removeNotification(chat_request);
    });
    this.$root.$on('canceled_or_expired_appointment', (data) => {
            this.denyVChatRequest(data.id)
    });

    this.$root.$on('join_video_chat', (chat_request) => {
            this.joinVideoChat(chat_request)
    });


    this.$root.$on('checkNotification', (data) => {
        this.checkNotification(data.notification,data.button_clicked);
    });


    //$("iframe[title='chat widget']").first().parent().css("cssText", "z-index:10!important;display:block!important");
    //$("iframe[title='chat widget']").first().css("cssText", "z-index:10!important;display:block!important");
    //$("iframe[title='chat widget']").first().parent().addClass('tawkchat-container');

  },
  watch: {
    new_scheduled_appointment(value){
      if(!value){
        this.scheduled_appointment = {};
      }
    },
    dialogPermission(val){
      if(!val)this.joinVideoChatAux = this.acceptVChatRequestAux = false;
    },
    dialogBrowser(val){
      if(!val)this.joinVideoChatAux1 = this.acceptVChatRequestAux1 = false;
    },
    noDisplayAgain(val){
      if(val){
        document.cookie = "noCameraMicroValidation=true";
      }
      else{
        document.cookie = "noCameraMicroValidation=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      }
    },
    'userChatRequests': function() {

      this.video_notifications =
        this.modelChatRequests.length + this.userChatRequests.length + this.userNotifications.length;
    },
    'modelChatRequests': function() {
      this.video_notifications =
        this.modelChatRequests.length + this.userChatRequests.length + this.userNotifications.length;
    },
    'userNotifications': function() {
      this.video_notifications =
        this.modelChatRequests.length + this.userChatRequests.length + this.userNotifications.length;
    },
    // model_alert(value){
    //   console.log(value)
    //   if(value.hasOwnProperty('id')){
    //     console.log('entro')
    //     let index_notification = this.all_notifications.map(item => item.id).indexOf(value.id); // find index of your object

    //     this.current_notification = this.all_notifications[index_notification];
    //   }
    // },
  },
  filters: {
    alertMessage(status, alert) {
      var status_filtered = status;

      if (status == "ENQUEUED") {
        status_filtered =
          "Waiting for " + alert.model.profile.display_name + " to accept.";
      } else if (status == "WAITING") {
        status_filtered =
          alert.model.profile.display_name +
          " accepted your request. Join now!";
      } else if (status == "LIVE") {
        status_filtered = alert.model.profile.display_name + "You are live.";
      }
      return status_filtered;
    },
    alertModelMessage(status, alert) {
      var status_filtered = status;
      if (status == "ENQUEUED") {
        status_filtered =
          alert.user.profile.name +
          " requested a " +
          (alert.service_id == 3 ? "video chat" : "call") +
          ". Start now.";
      }
      if (status == "WAITING") {
        status_filtered =
          "Waiting for " + alert.user.profile.name + " to join.";
      } else if (status == "LIVE") {
        status_filtered = "You are live.";
      }
      return status_filtered;
    },
    formatDate(date, format = "MM/DD/YYYY") {
      return moment(date).format(format);
    }
  },

  methods: {
    setPublisherAudio(){
                if(!this.tokbox_caster)return;
               this.publisherAudio = !this.publisherAudio;
               this.tokbox_caster.publishAudio(this.publisherAudio);
            },
    continueBtn(){
      if(this.joinVideoChatAux){
       this.joinVideoChat(this.joinVideoChatAux);
       this.joinVideoChatAux = false;
      }
      else if(this.acceptVChatRequestAux){
       this.acceptVChatRequest(this.acceptVChatRequestAux);
       this.acceptVChatRequestAux = false;
      }
    },
       continueBtn1(){
      if(this.joinVideoChatAux1){
       this.joinVideoChat(this.joinVideoChatAux1);
       this.browserAux = false;
      }
      else if(this.acceptVChatRequestAux1){
       this.acceptVChatRequest(this.acceptVChatRequestAux1);
       this.browserAux = false;
      }
    },
    add_credits() {
      this.low_credits_alert = false;
      EventBus.$emit("open-credits", {});
    },
    goToModel(alert) {
      window.open("/" + alert.model.profile.profile_link, "_self");
    },
    addNotification(chat_request) {
      let double_check_index = this.userChatRequests
        .map(request => {
          return request.id;
        })
        .indexOf(chat_request.id);

      if (double_check_index == -1) {
        this.userChatRequests.push(chat_request);
      }
    },
    removeNotification(chat_request) {

      let i = this.userChatRequests
        .map(item => item.id)
        .indexOf(chat_request.id); // find index of your object
        this.userChatRequests.splice(i, 1);


    },

    f_get_notifications() {
      if (this.user != null) {
         this.modelChatRequests = this.user.modelChatRequests;
         this.userChatRequests = this.user.userChatRequests;
         this.userNotifications = this.user.userNotifications;


      var url = new URL(window.location.href);
      var request_to_join = url.searchParams.get("r");
      if(request_to_join){

        if(this.user.role_id == 1){
               let notif = this.modelChatRequests.find(obj => obj.id == request_to_join);
               if(notif){
                 this.model_alert = notif;
                   setTimeout(x => {
                 this.request_dialog = true;
                   }, 1000);
               }
        }
        if(this.user.role_id == 2){
               let notif = this.userChatRequests.find(obj => obj.id == request_to_join);
               if(notif && notif.action !== 'to_user_scheduled_reading_start'){
                 this.user_alert = notif;
                   setTimeout(x => {
                 this.join_dialog = true;
                  }, 1000);
               }
        }

        var url =window.location.href.split("?");
        window.history.replaceState("r", "Title", url[0]);
      }


      var appointmentUrl = new URL(window.location.href);
      var new_appointment = appointmentUrl.searchParams.get("a");
        if(new_appointment){
            let app = this.userNotifications.find(obj => obj.key == new_appointment);
            console.log(app)
               if(app){
                 this.scheduled_appointment = app;
                 setTimeout(x => {
                       this.new_scheduled_appointment = true;
                  }, 1000);

               }
                  var url =window.location.href.split("?");
                window.history.replaceState("r", "Title", url[0]);
        }


      }
    },
    f_display_name(user) {
      return user.profile.display_name
        ? user.profile.display_name
        : user.profile.name;
    },



    acceptVChatRequest(id) {
     var self = this;
      //this.tokbox_session = OT.initSession('46445262');

      if(document.cookie.replace(/(?:(?:^|.*;\s*)noCameraMicroValidation\s*\=\s*([^;]*).*$)|^.*$/, "$1"))
       this.noDisplayAgain = true;

          if (this.user.browserSupported[0] != "SUPPORTED" && !this.dialogBrowser && !this.acceptVChatRequestAux1 && this.browserAux) {
                          this.dialogBrowser = true;
                          this.acceptVChatRequestAux1 = id;
                          //this.tokbox_session.disconnect();
                          return;
                        } else if(this.dialogBrowser){
                          //this.tokbox_session.disconnect();
                            this.dialogBrowser = false;
                        }

      if (!this.dialogPermission && !this.noDisplayAgain /*&& this.tokbox_session.capabilities.publish != 1*/) {
                          this.dialogPermission = true;
                          this.acceptVChatRequestAux = id;
                          //this.tokbox_session.disconnect();
                          return;
                        } else if(this.dialogPermission){
                          //this.tokbox_session.disconnect();
                            this.dialogPermission = false;
                        }

      this.chat_request_id = id;
      this.acceptLoading = true;
      axios
        .get("/api/v1/model/vchat/start/" + id + "/")
        .then(response => {
          //console.log(response.data.success.session_id);
          this.tokbox_session = OT.initSession('46445262', response.data.success.session_id);

          this.request_dialog = false;
          this.request_message = response.data.success.message;
          //this.requestDialog = true;
          this.acceptLoading = false;
          let i = this.modelChatRequests.map(item => item.id).indexOf(id); // find index of your object
          this.$set(this.modelChatRequests[i], "state", "WAITING");
          var subscriber_image = this.modelChatRequests[i].user.profile
            .profile_headshot_url;
          this.the_other_user = this.modelChatRequests[i].user;
          this.requestSate = 'WAITING';
          this.model_tokbox = true;
          console.log("start7");
          //console.log(response.data.success.session_id);
          this.chat_service_id = response.data.success.service_id;
          this.model_chat_room_id = response.data.success.model_chat_room_id;

          this.tokbox_notes_menu = false;

            this.tokbox_session.on('streamCreated', function streamCreated(event) {

            self.the_other_user = self.requestSate = false;
            self.other_user_joined_at = new Date();
            self.timer_loop = setInterval(() => {
              var time_now = new Date();

              var diff =
                time_now.getTime() - self.other_user_joined_at.getTime();

              self.display_timer = new Date(diff).toISOString().substr(11, 8);
            }, 1000);


                var subscriberOptions = {
                    insertMode: "append",
                    width: "100%",
                    height: "100%",
                    showControls: true,
                    fitMode: "cover",
                    preferredResolution: { width: 1280, height: 720 }
                };

              if (self.chat_service_id === 1) {
                    subscriberOptions.name = self.modelChatRequests[i].user.profile.name + " " +self.modelChatRequests[i].user.profile.last_name;
                    subscriberOptions.style = {nameDisplayMode: "on" ,  audioLevelDisplayMode: "off"};
              }

                self.tokbox_subscriber = self.tokbox_session.subscribe(event.stream, 'tokbox-subscriber', subscriberOptions, error => {console.log(error);});

                if (self.chat_service_id === 1) {
                  self.tokbox_subscriber.setStyle(
                    "backgroundImageURI",
                    subscriber_image
                  );
                }

            });

          /*this.tokbox_session.on("streamCreated", event => {
            this.the_other_user = this.requestSate = false;
            this.other_user_joined_at = new Date();
            this.timer_loop = setInterval(() => {
              var time_now = new Date();

              var diff =
                time_now.getTime() - this.other_user_joined_at.getTime();

              this.display_timer = new Date(diff).toISOString().substr(11, 8);
            }, 1000);

            var options = {
              insertMode: "append",
              width: "100%",
              height: "100%",
              showControls: true,
              fitMode: "cover",
              preferredResolution: { width: 1280, height: 720 }
            };

            if (this.chat_service_id === 1) {
              options.subscribeToAudio = true;
              options.subscribeToVideo = false;

              options.name =
                this.modelChatRequests[i].user.profile.name +
                " " +
                this.modelChatRequests[i].user.profile.last_name;
              options.style = { nameDisplayMode: "on" ,  audioLevelDisplayMode: "off"};
            }

            this.tokbox_subscriber = this.tokbox_session.subscribe(
              event.stream,
              "tokbox-subscriber",
              options,
              error => {
                console.log("start8");
                console.log(error);

                if (this.tokbox_subscriber.stream.hasVideo) {
                  var imgData = this.tokbox_subscriber.getImgData();
                  this.tokbox_subscriber.setStyle(
                    "backgroundImageURI",
                    imgData
                  );
                } else {
                  this.tokbox_subscriber.setStyle(
                    "backgroundImageURI",
                    subscriber_image
                  );
                }
              }
            );
          });*/

          this.tokbox_session.on("streamDestroyed", event => {
            console.log("start9");
            console.log(event);

            this.model_tokbox = false;
            this.end_of_vhcat_alert = true;

            this.tokbox_session.disconnect();
            this.$delete(
              this.modelChatRequests,
              this.modelChatRequests
                .map(p => {
                  return p.id;
                })
                .indexOf(this.chat_request_id)
            );

            clearInterval(this.timer_loop);
            this.display_timer = "00:00:00";
          });

          this.tokbox_session.on("sessionDisconnected", event => {
            console.log("start10");
            console.log(event);
          });

            // initialize the publisher
                var publisherOptions = {
                    insertMode: 'append',
                    width: '100%',
                    height: '100%',
                    showControls: true,
                    fitMode: "cover",
                    preferredResolution: { width: 1280, height: 720 }
                };

            //var publisher = OT.initPublisher('tokbox-publisher', publisherOptions, self.handleError);

            // Connect to the session
                this.tokbox_session.connect(response.data.success.token, function callback(error) {
                    if (error) {
                    self.handleError(error);
                    //console.log(error);
                    } else {

                     if (self.chat_service_id === 1) {
                      publisherOptions.videoSource = null;
                      publisherOptions.name = self.modelChatRequests[i].model.profile.display_name;
                      publisherOptions.style = { nameDisplayMode: "on" ,  audioLevelDisplayMode: "off"};
                    }
                    // If the connection is successful, publish the publisher to the session
                   self.tokbox_caster = self.tokbox_session.publish(OT.initPublisher('tokbox-publisher', publisherOptions, self.handleError), self.handleError);
                    }
                });

          /*this.tokbox_session.connect(response.data.success.token, error => {
            // If the connection is successful, publish to the session
            if (error) {
              //console.log(response.data.success.token);
              console.log("start11");
              console.log(error);
            } else {
              var options = {
                insertMode: "append",
                width: "100%",
                height: "100%",
                showControls: true,
                fitMode: "cover",
                preferredResolution: { width: 1280, height: 720 }
              };

              if (this.chat_service_id === 1) {
                console.log("truely truely truely");
                options.videoSource = null;

                options.name = this.modelChatRequests[
                  i
                ].model.profile.display_name;
                options.style = { nameDisplayMode: "on" ,  audioLevelDisplayMode: "off"};
              }

              this.tokbox_caster = this.tokbox_session.publish(
                OT.initPublisher("tokbox-publisher", options, error => {
                  if (error) {
                    console.log("start12");
                    console.log(error);
                  } else {
                    console.log("start13");
                    console.log("Publisher initialized.");
                  }
                }),

                error => {
                  console.log("start14");
                  console.log(error);

                  if (this.tokbox_caster.stream.hasVideo) {
                    var imgData = this.tokbox_caster.getImgData();

                    this.tokbox_caster.setStyle("backgroundImageURI", imgData);
                  } else {
                    this.tokbox_caster.setStyle(
                      "backgroundImageURI",
                      this.user.userProfile.haedshot_path
                    );
                  }
                }
              );
            }
          });*/
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    denyVChatRequest(id) {
      this.acceptLoading = true;
      axios
        .get("/api/v1/model/vchat/request_cancel/" + id + "/")
        .then(response => {
          this.request_dialog = false;
          this.request_message = response.data.message;
          //this.requestDialog = true;
          this.acceptLoading = false;

          let i = this.modelChatRequests.map(item => item.id).indexOf(id); // find index of your object
          this.$set(this.modelChatRequests[i], "state", "INCOMPLETE");
          this.$delete(this.modelChatRequests, i);

          this.chat_request_id = 0;
        })
        .catch(function(error) {
           this.join_dialog =false;
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },

    endVChatRequest() {
      this.acceptLoading = true;
      axios
        .get("/api/v1/model/vchat/end/" + this.model_chat_room_id + "/")
        .then(response => {
          console.log("start15");
          //console.log(response.data);

          this.request_message = response.data.message;
          //this.requestDialog = true;
          this.acceptLoading = false;
          /*let i = this.modelChatRequests.map(item => item.id).indexOf(id); // find index of your object
                        this.$set(this.modelChatRequests[i], 'state', 'INCOMPLETE');
                        */

          this.chat_request_id = 0;
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },

    end_video_call() {
      this.model_tokbox = false;
      this.end_of_vhcat_alert = true;
      EventBus.$emit("cancel_chat_request", this.user_alert);
      EventBus.$emit("update_credits");

      this.tokbox_session.disconnect();
      this.endVChatRequest();

      clearInterval(this.timer_loop);
      this.display_timer = "00:00:00";

      this.$delete(
        this.modelChatRequests,
        this.modelChatRequests
          .map(p => {
            return p.id;
          })
          .indexOf(this.chat_request_id)
      );
    },
    joinVideoChat(alert) {

      //this.tokbox_session = OT.initSession('46445262');

      if(document.cookie.replace(/(?:(?:^|.*;\s*)noCameraMicroValidation\s*\=\s*([^;]*).*$)|^.*$/, "$1"))
       this.noDisplayAgain = true;

               if (this.user.browserSupported[0] != "SUPPORTED" && !this.dialogBrowser && !this.joinVideoChatAux1 && this.browserAux) {
                          this.dialogBrowser = true;
                          this.joinVideoChatAux1 = alert;
                          //this.tokbox_session.disconnect();
                          return;
                        } else if(this.dialogBrowser){
                          //this.tokbox_session.disconnect();
                            this.dialogBrowser = false;
                        }

      if (!this.dialogPermission && !this.noDisplayAgain /*&& this.tokbox_session.capabilities.publish != 1*/) {
                          this.dialogPermission = true;
                          this.joinVideoChatAux = alert;
                          //this.tokbox_session.disconnect();
                          return;
                        } else if(this.dialogPermission){
                            this.dialogPermission = false;
                            //this.tokbox_session.disconnect();
                        }


      this.loadingCancel = true;
      axios
        .get("/api/v1/user/vchat/available")
        .then(response => {
          this.loadingCancel = false;


      this.tokbox_session = OT.initSession(
        "46445262",
        response.data.success[0].session_id
      );



          this.user_chat_room_id = response.data.success[0].user_chat_room_id;
          this.connectTokBox(alert, response.data.success[0]);
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    connectTokBox(alert, response_from_available) {
      var self = this;
      this.join_dialog = false;
      this.service_id = alert.service_id;
      this.the_other_user = alert.model;

      this.user_tokbox = true;

       this.tokbox_session.on('streamCreated', function streamCreated(event) {

                  self.the_other_user = self.requestSate = false;
                  self.other_user_joined_at = new Date();
                  self.timer_loop = setInterval(() => {
                    var time_now = new Date();

                    var diff = time_now.getTime() - self.other_user_joined_at.getTime();

                    self.display_timer = new Date(diff).toISOString().substr(11, 8);
                  }, 1000);


                var subscriberOptions = {
                    insertMode: "append",
                    width: "100%",
                    height: "100%",
                    showControls: true,
                    fitMode: "cover",
                    preferredResolution: { width: 1280, height: 720 }
                };

                 if (alert.service_id == 1) {
                  subscriberOptions.name = alert.model.profile.display_name;
                  subscriberOptions.style = { nameDisplayMode: "on",  audioLevelDisplayMode: "off"};

                }

                self.tokbox_subscriber = self.tokbox_session.subscribe(event.stream, 'tokbox-subscriber', subscriberOptions, error => {console.log(error);});

                if (alert.service_id == 1) {
                    self.tokbox_subscriber.setStyle(
                    "backgroundImageURI",
                    alert.model.profile.profile_headshot_url
                  );
                 }

            });


      /*this.tokbox_session.on("streamCreated", event => {
        this.the_other_user = this.requestSate = false;
        this.other_user_joined_at = new Date();
        this.timer_loop = setInterval(() => {
          var time_now = new Date();

          var diff = time_now.getTime() - this.other_user_joined_at.getTime();

          this.display_timer = new Date(diff).toISOString().substr(11, 8);
        }, 1000);

        var options = {
          insertMode: "append",
          width: "100%",
          height: "100%",
          showControls: true,
          fitMode: "cover",
          preferredResolution: { width: 1280, height: 720 }
        };

        if (alert.service_id == 1) {
          options.name = alert.model.profile.display_name;
            options.style = { nameDisplayMode: "on",  audioLevelDisplayMode: "off"};
          options.subscribeToAudio = true;
          options.subscribeToVideo = false;
        }

        this.tokbox_subscriber = this.tokbox_session.subscribe(
          event.stream,
          "tokbox-subscriber",
          options,
          error => {
            console.log("sprofile6");
            console.log(error);

            if (this.tokbox_subscriber.stream.hasVideo) {
              var imgData = this.tokbox_subscriber.getImgData();
              this.tokbox_subscriber.setStyle("backgroundImageURI", imgData);
            } else {
              this.tokbox_subscriber.setStyle(
                "backgroundImageURI",
                alert.model.profile.profile_headshot_url
              );
            }
          }
        );
      });*/
      this.tokbox_session.on("streamDestroyed", event => {
        console.log("sprofile7");
        console.log(event);
        this.user_tokbox = false;
        //this.end_of_vhcat_alert = true;
        this.user_alert = {};
        this.tokbox_session.disconnect();
        //let i = this.item.services.map(item => item.service.id).indexOf(this.service_id); // find index of your object
        //var cancelled_service = this.item.services.map((item) => item.id === this.cancelled_service_id);
        EventBus.$emit("cancel_chat_request", alert);
        EventBus.$emit("update_credits");
        //this.$set(service, "chat_request", null);
        self.service_id = "";
        //this.getModel(); // still has chat_request in there.... make join btn show after ended...

        clearInterval(self.timer_loop);
        self.display_timer = "00:00:00";
      });
      this.tokbox_session.on("sessionDisconnected", event => {
        console.log("sprofile8");
        console.log(event);
      });

      this.tokbox_session.on("signal", event => {
         console.log(event);
        if (event.type === "signal:collide_server") {
          // back end signals
          if (event.data) {
            var eventDataObj = JSON.parse(event.data);
             console.log(eventDataObj);
            if (eventDataObj.action) {
              if (eventDataObj.action === "TERMINATE") {
                var terminateMessage = "";
                if (eventDataObj.message) {
                  if (eventDataObj.message === "Not enough credits") {
                    this.user_tokbox = false;
                    this.user_alert = {};
                    this.choosenService = {};
                    this.tokbox_session.disconnect();
                    //let i = this.item.services.map(item => item.service.id).indexOf(this.service_id); // find index of your object
                    //var cancelled_service = this.item.services.map((item) => item.id === this.cancelled_service_id);
                    //this.$set(service, "chat_request", null);
                    self.service_id = "";
                    //this.getModel(); // still has chat_request in there.... make join btn show after ended...

                    clearInterval(self.timer_loop);
                    self.display_timer = "00:00:00";
                    EventBus.$emit("cancel_chat_request", alert);
                    EventBus.$emit("update_credits");
                  }
                }
              } else if (eventDataObj.action === "WARNING") {
                var terminateMessage = "";
                if (eventDataObj.message) {
                  if (eventDataObj.message === "LOW CREDITS") {
                    EventBus.$emit("update_credits");
                    self.low_credits_alert = true;
                  }
                }
              }
            }
          }
        }
      });


      // initialize the publisher
                var publisherOptions = {
                    insertMode: 'append',
                    width: '100%',
                    height: '100%',
                    showControls: true,
                    fitMode: "cover",
                    preferredResolution: { width: 1280, height: 720 }
                };

            //var publisher = OT.initPublisher('tokbox-publisher', publisherOptions, self.handleError);


             // Connect to the session
                this.tokbox_session.connect(response_from_available.token, function callback(error) {
                    if (error) {
                    self.handleError(error);
                    } else {
                      if (alert.service_id == 1) {
                      publisherOptions.name = alert.user.profile.name + " " + alert.user.profile.last_name;
                      publisherOptions.style = { nameDisplayMode: "on" ,  audioLevelDisplayMode: "off"};
                      publisherOptions.videoSource = null;
                    }
                    // If the connection is successful, publish the publisher to the session
                   self.tokbox_caster = self.tokbox_session.publish(OT.initPublisher('tokbox-publisher', publisherOptions, self.handleError), self.handleError);
                    }
                });

      // Connect to the session
      /*this.tokbox_session.connect(response_from_available.token, error => {
        // If the connection is successful, publish to the session
        if (error) {
          console.log("sprofile9");
          console.log(error);
        } else {
          var options = {
            insertMode: "append",
            width: "100%",
            height: "100%",
            showControls: true,
            fitMode: "cover",
            preferredResolution: { width: 1280, height: 720 }
          };
          if (alert.service_id == 1) {
            options.name =
              alert.user.profile.name + " " + alert.user.profile.last_name;
            options.style = { nameDisplayMode: "on" ,  audioLevelDisplayMode: "off"};
            options.videoSource = null;
          }

          this.tokbox_caster = this.tokbox_session.publish(
            OT.initPublisher("tokbox-publisher", options, error => {
              console.log(error);
            }),
            error => {
              console.log("sprofile11");
              console.log(error);
              console.log("sprofile12");

              if (this.tokbox_caster.stream.hasVideo) {
                var imgData = this.tokbox_caster.getImgData();

                this.tokbox_caster.setStyle("backgroundImageURI", imgData);
              } else {
                this.tokbox_caster.setStyle(
                  "backgroundImageURI",
                  this.user.userProfile.haedshot_path
                );
              }
            }
          );
        }
      });*/
    },
     show_dialog_after_video_call_end(){
          if(this.user.role_id == 2){
            this.$root.$emit("open_standard_dialog",
            {
              title:'How was the session?',
              review:true,
              room: this.user_chat_room_id
            });
          }
          if(this.user.role_id == 1){
            this.end_of_vhcat_alert = true;
          }

     },
    user_end_video_call() {
      EventBus.$emit("cancel_chat_request", this.user_alert);
      EventBus.$emit("update_credits");

      this.user_tokbox = false;
      this.end_of_vhcat_alert = true;
      this.user_alert = {};
      this.model_alert = {};
      this.tokbox_session.disconnect();
      this.user_endVChatRequest();
      clearInterval(this.timer_loop);
      this.display_timer = "00:00:00";
      //this.getModel();
    },
     cancelVChatRequest(notification) {
      this.loadingCancel = true;
      axios
        .get("/api/v1/user/vchat/request_cancel/" + notification.model.id + "/")
        .then(response => {
               this.loadingCancel = false;
               this.join_dialog = false;
               setTimeout(x => {
                       this.$root.$emit("canceled_or_expired_request", {});
                       this.get_notifications_in_app();
                  }, 300);
        })
        .catch(function(error) {
          this.join_dialog = false;
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },

    user_endVChatRequest() {
      this.loadingCancel = true;
      axios
        .get("/api/v1/user/vchat/end/" + this.user_chat_room_id + "/")
        .then(response => {
          this.request_message = response.data.message;
          //this.cancelDialog = false;
          //this.requestDialog = true;
          this.loadingCancel = false;
          // find index of your object
          //var cancelled_service = this.model.services.map((item) => item.id === this.cancelled_service_id);
          //EventBus.$emit('cancel_chat_request',  this.model.services[i].chat_request);
          //this.$set(this.model.services[i], "chat_request", null);
          this.service_id = "";
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
     updateUserAppointmentStatus(appointment, status) {
                //this.loadingUpdate = true;
                var input = {'id': appointment.key, 'status': status};
                axios.post('/api/v1/user/appointment/update/status', input)
                    .then(response => {
                        //this.remove_notification(appointment);
                        this.getAppointmentsIfPath();
                    })
                    .catch(function(error) {
                        if (error.response && (error.response.status === 401 || error.response.status === 419)) {
                            location.reload();
                        }
                    });

            },
    updateAppointmentStatus(appointment, status) {

      this.loadingUpdate = true;
      var input = { id: appointment.key, status: status };
      axios
        .post("/api/v1/psychic/appointment/update/status", input)
        .then(response => {
          this.remove_notification(appointment);
          this.getAppointmentsIfPath();

          this.loadingUpdate = false;
          this.new_scheduled_appointment = false;
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    getAppointmentsIfPath() {
      if (window.location.pathname == "/dashboard") {
        this.$root.$emit("update_appointments", {});
      }
    },
    getNotificationsIfPath() {

      if (window.location.pathname == "/dashboard/notifications") {
        this.$root.$emit("update_notifications", {
           modelChatRequests: this.modelChatRequests,
           userChatRequests: this.userChatRequests,
           userNotifications: this.userNotifications
        });
      }
    },

     checkNotification(notification,button_clicked){

        switch(notification.action){
           case 'to_model_request_now_received':
                   if(button_clicked == 'first'){
                      this.acceptVChatRequest(notification.id);
                   }else{
                       this.denyVChatRequest(notification.id);
                   }

             break;
            case 'to_user_request_now_sent':

              this.cancelVChatRequest(notification);
               setTimeout(x => {
                       this.$root.$emit("canceled_or_expired_request", {});
                       this.get_notifications_in_app();
                  }, 300);
              break;

          case 'to_psychic_user_canceled_request':
                  this.remove_notification(notification);
            break;

          case 'to_user_request_now_accepted':

             if(button_clicked == 'first'){
                 this.joinVideoChat(notification);
             }else{
                this.cancelVChatRequest(notification);
                setTimeout(x => {
                       this.$root.$emit("canceled_or_expired_request", {});
                       this.get_notifications_in_app();
                  }, 300);
             }

            break;

           case 'schedule_appointment':
              if(button_clicked == 'first'){
                    this.updateAppointmentStatus(notification, 'Confirmed');
              }else{
               this.updateAppointmentStatus(notification, 'Cancelled');
              }
              break;

          case 'user_schedule_appointment_pending':
              this.updateUserAppointmentStatus(notification, 'Cancelled');
                let x = this.userNotifications.map(item => item.id).indexOf(notification.id); // find index of your object
                                 this.userNotifications.splice(x, 1);
              break;

          case 'to_psychic_schedule_appointment_cancelled':
              this.remove_notification(notification);

             break;

          case 'to_user_model_confirm_appointment':

              if(button_clicked == 'close'){
                 this.remove_notification(notification);
              }else{
                this.updateUserAppointmentStatus(notification, 'Cancelled');
                  let x1 = this.userNotifications.map(item => item.id).indexOf(notification.id); // find index of your object
                                 this.userNotifications.splice(x1, 1);
              }

            break;
          case 'to_user_scheduled_reading_start':
            this.cancelVChatRequest(notification);
               setTimeout(x => {
                       this.$root.$emit("canceled_or_expired_request", {});
                       this.get_notifications_in_app();
                  }, 300);
            break;
          case 'to_psychic_scheduled_reading_start':
             if(button_clicked == 'first'){
                      this.acceptVChatRequest(notification.id);
                   }else{
                       this.denyVChatRequest(notification.id);
                   }
            break;
          case 'expired_request':

             this.remove_notification(notification);
                if(button_clicked !== 'close'){
                   setTimeout(x => {
                      window.open(notification.link,'_self');
                  }, 300);
                }
            break;

          case 'to_psychic_request_expired':

             this.remove_notification(notification,'_blank');

            break;
          case 'to_psychic_online_rules':
                this.remove_notification(notification);
                   setTimeout(x => {
                      window.open(notification.link);
                  }, 300);

            break;


            case 'to_all_announcement':
                this.remove_notification(notification);
                   setTimeout(x => {
                      window.open(notification.link);
                  }, 300);

            break;

           case 'model_canceled_request':


                this.remove_notification(notification);
                if(button_clicked !== 'close'){
                   setTimeout(x => {
                      window.open(notification.link,'_self');
                  }, 300);
                }


                break;
           case 'model_canceled_appointment':
              this.remove_notification(notification);
                  if(button_clicked !== 'close'){
                   setTimeout(x => {
                      window.open(notification.link,'_self');
                  }, 300);
                }

             break;


              default:
              break;
        }
     },

             remove_notification(notification) {

                axios
                    .put("/api/v1/notifications/remove",{type:notification.action, notification_id: notification.key })
                    .then(response => {
                         let x = this.userNotifications.map(item => item.id).indexOf(notification.id); // find index of your object
                                 this.userNotifications.splice(x, 1);
                    })
                    .catch(error => {
                    this.loading = false;
                    if (error.response.status === 419 || error.response.status === 401) {
                        location.reload();
                    }

                    console.log(error);
                    });
            },
            show_name(name){
            return name.length > 25 ? name.substring(0, 25)+'...' : name;
            },
            get_notifications_in_app(){
                    axios
                    .get("/api/v1/notifications")
                    .then(response => {
                       this.userNotifications = response.data.userNotifications;
                        this.userChatRequests = response.data.userChatNotifications;
                         this.modelChatRequests = response.data.psychicChatNotifications;


                    })
                    .catch(error => {
                    this.loading = false;
                    if (error.response.status === 419 || error.response.status === 401) {
                        location.reload();
                    }

                    console.log(error);
                    });
            },

            handleError(error) {
              if (error) {
                console.log(error.message);
                  //alert(error.message);
              }
           },

            //  getAppointment(notification) {

            //     axios
            //         .get("/api/v1/psychic/appointment/"+notification.key)
            //         .then(response => {
            //             this.scheduled_appointment = response.data.data;
            //             this.new_scheduled_appointment = true;

            //         })
            //         .catch(error => {
            //         this.loading = false;
            //         if (error.response.status === 419 || error.response.status === 401) {
            //             location.reload();
            //         }

            //         console.log(error);
            //         });
            // },
            get_full_url(path){
              if(path == 'icon_notification'){
                  this.getNotificationsIfPath();

                if(this.all_notifications.length > 0){
                  if(window.location.pathname == "/dashboard/notifications"){
                    return  window.location.origin+"/images/icons/notification-current-on-circle-purple.svg"
                  }
                  return  window.location.origin+"/images/icons/notification-on.svg"
                }else{
                     if(window.location.pathname == "/dashboard/notifications"){
                    return  window.location.origin+"/images/icons/w-notification.png"
                  }

                  return  window.location.origin+"/images/icons/notification.svg"
                }
              }else if(path == 'icon_notification_desktop'){


                  if(this.all_notifications.length > 0){
                    if(this.menu_opened){
                       if(this.color == 'white'){
                            return  window.location.origin+"/images/icons/notification-current-on-circle-purple.svg"
                       }
                       return  window.location.origin+"/images/icons/notification.png"


                     }
                     else if(this.color == 'white'){

                        return  window.location.origin+"/images/icons/notification-on.svg"
                     }
                        return  window.location.origin+"/images/icons/notification.png"


                }else{

                     if(this.menu_opened){
                       return  window.location.origin+"/images/icons/w-notification.png"
                     }
                    else if(this.color == 'white'){
                         return  window.location.origin+"/images/icons/notification.svg"
                    }
                    return  window.location.origin+"/images/icons/w-notification.png"
                  }




                //     <!-- <img v-if="text_chat_notifications" src="images/icons/Bell_Notification.svg" />
                //  <img v-else src="images/icons/Bell_Inactive_white.svg" />
                // </div>
                // <div class="d-none d-md-inline">
                // <img v-if="video_notifications" src="images/icons/Bell_Notification.svg" />
                // <img v-else src="images/icons/Bell_Inactive.svg" /> -->
              }
              else{
                return window.location.origin+path;
              }
            }
  }
};
</script>

<style scoped>
.tokbox-overlay{
  z-index: 20000000000 !important;
}
.tokbox-notifications .v-list-item__title {
  white-space: normal !important;
}
.badge-blue {
  color: #fff;
  background-color: #3490dc;
}
.text_field_dialog {
  background-color: white;
  color: black;
  padding: 8px;
  margin-top: 5px;
  border-radius: 5px;
}
.box_field_dialog {
  color: purple;
  font-weight: 600;
}
.wrap-text {
  word-wrap: break-word;
}
.header_notifications{
    font-size: 14px !important;
    font-weight: 600;
    margin-top: 30px;
    color: #1F1E34;
}
.user_avatar_list{
    backface-visibility: hidden;
    display: inline-block;
    overflow: hidden;
    border-radius: 50%;
    width: 52px;
    height: 52px;
    background-size: cover;

    }
    .v-btn--fab.v-size--x-small {
    height: 30px;
    width: 30px;
}
.text_button{
    font-size: 12px;
    font-weight: 600;
    color: #1F1E34;
    cursor: pointer;
}
.dot_border_users{
  border-color: #fff !important;
  min-width: 15px;
  height: 15px;
  top: 50px !important;
  left: 55px !important;
  border-radius: 7.5px;
  background-color: #2CC05F !important;
}
.dot_border_users_desktop{
  border-color: #fff !important;
  min-width: 24px;
  height: 24px;
  top: 75px !important;
  left: 75px !important;
  border-radius: 20px;
  background-color: #2CC05F !important;
  border-width: 4px !important;
}
/* >>> .shadow{
  box-shadow: 0px 3px 6px #0000000D !important;
} */
.v-menu__content {
  border-radius:  7px !important;
}
.tokbox-notifications-model {
  margin-top: 0 !important;
}
@media only screen and (max-width: 375px){
  .my-menu {
    left: 0!important;
  }
  .height-100 {
    border-radius: 0!important;
    height: 100%!important;
  }
}
.v-sheet.v-card:not(.v-sheet--outlined) {
    box-shadow: none !important;
}
.shadow{
  box-shadow: 0px 1px 2px #00000040!important;
  background-color: #fff;
}
.text_button_desktop{
   font-size: 14px !important;
    font-weight: 600 !important;
    color: #1F1E34 !important;
    cursor: pointer !important;
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
  background: #8EBEF8;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #ffffff;
}


@media only screen and (max-width: 450px){

  .v-dialog__content--active {
    opacity: 1 !important;
    backdrop-filter: blur(10px);
  }
}
.v-dialog__content--active {
    opacity: 1 !important;
    -webkit-backdrop-filter: blur(10px);
    backdrop-filter: blur(10px);
}
.notification-image {
  width: 24px;
  height: 24px;
}
.notification-image img {
  width: 24px;
  height: 24px;
}
</style>