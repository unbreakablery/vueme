<template>
    <div min-width="320">
        <v-list class="p-0" style="background-color: #F0F0F7;">
          <v-list-item class="py-0 " dense>
            <v-list-item-title class="header_notifications mb-4">Notifications</v-list-item-title>
          </v-list-item>



             <v-list-item class="px-5" v-if="!notifications.length">               
               
                
                <div style="min-height: 120px;background-color: #F4F4F4;width: 100%;" class="mb-4 shadow">
                           
                            <div class="row mx-0">                              
                             
                                <v-list-item-content class="" style="display: inline-block;width: 335px;padding-top: 40px;padding-left: 40px;">
                               <img :src="get_full_url('/images/icons/notifications/noNotifications.svg')" />
                               <div style="display:inline-flex;color: #C7C7C7;font-size: 14px;padding-left: 15px;">Currently Empty</div>  
                                </v-list-item-content>
                                     
                            </div>
                
                </div>
            </v-list-item>




          <v-list-item class="px-5"   v-for="(notification, index) in notifications" :key="notification.id">               
               
                
                <div style="min-height: 120px;" :style="[notification.color == 'color_blue'?{'background-color': '#EBF4FD'}:{'background-color': 'white'}]" class="mb-4 shadow">
                            <div v-if="notification.close" class="mb-2" style="position: absolute;right: 25px;top: 5px;z-index: 5;">
                              <v-icon class="text-right" @click="checkNotification(notification,'close')">mdi-close</v-icon>
                            </div>
                            <div class="row mx-0">
                              


                               <v-badge v-if="user.role_id == 2"  :color="notification.online ? 'green mb-4 mr-8 dot_border_users' : 'grey mb-4 mr-8 dot_border_users'" dot  bordered bottom >
                                 <template class="" v-slot:badge>{{''}}</template>
                                  <div class="user_avatar_list" style="margin: 15px 15px 0px;" :style="{ 'background-image': 'url(' + notification.profile_headshot_url  + ')' }">

                                  </div>
                                </v-badge>
                            

                                 <div v-else class="user_avatar_list" style="margin: 15px 15px 0px;" :style="{ 'background-image': 'url(' + notification.profile_headshot_url  + ')' }">
                                </div>

                       <v-list-item-content style="padding-top: 15px !important;padding-bottom: 5px;">
                              
                              <v-list-item-title style="font-size: 15px;font-weight: 600;color: #1F1E34;"> 
                                  {{ show_name(notification.from) }}
                              </v-list-item-title>
                              <v-list-item-subtitle class="mt-1" style="font-size: 12px;color: #656B72;">
                              {{notification.action_description}}
                            </v-list-item-subtitle>

                            <v-list-item-subtitle v-if="notification.action_description_2" class="mt-1" style="font-size: 12px;color: #656B72;">
                              {{notification.action_description_2}}
                            </v-list-item-subtitle>

                              <v-list-item-subtitle v-if="notification.request_description" class="mt-1" style="font-size: 12px;font-weight: 500 !important;color: #656B72;">
                              {{notification.request_description}}
                            </v-list-item-subtitle> 
                            <div class="text_button d-flex">
                              <div class="mr-3" @click="checkNotification(notification,'first')"><img :src="get_full_url(notification.first_image)" />{{notification.first_text}}</div> 
                              <div @click="checkNotification(notification,'second')"><img v-if="notification.second_image" :src="get_full_url(notification.second_image)" />{{notification.second_text}}</div>
                            </div>
                        </v-list-item-content>                   
                      </div>
               
                </div>
            </v-list-item>

        </v-list>

        
      </div>
</template>

<script>
import {mapGetters} from 'vuex';
    export default {

        data(){
            return{
             
                modelChatRequests:[],
                userChatRequests:[],
                userNotifications:[] 

            };
        },
        props:['user'],
      
        computed:{
           notifications() {   
               
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

        watch:{
          
        },
        created(){

          if(!this.mobile){
              window.open('/dashboard','_self');
          }  
          this.f_get_notifications();  
          this.$root.$on('update_notifications', (data) => { 
            
                this.modelChatRequests = data.modelChatRequests;
                this.userChatRequests = data.userChatRequests;
                this.userNotifications = data.userNotifications;  
             
           });
        },
        mounted(){
        
        },
          methods: {
        f_get_notifications() {
            if (this.user != null) {
                this.modelChatRequests = this.user.modelChatRequests;
                this.userChatRequests = this.user.userChatRequests;
                this.userNotifications = this.user.userNotifications;
            }      
            },            
        get_full_url(path){                         
                return window.location.origin+path;             
            },    
        checkNotification(notification,button_clicked){
            
             this.$root.$emit("checkNotification", {notification:notification,button_clicked:button_clicked});
             
          },
          show_name(name){
            return name.length > 30 ? name.substring(0, 30)+'...' : name;           
          } 
        
          }
        
    }
</script>

<style  scoped>






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
 >>> .dot_border_users{
       border-color: #fff !important;
    min-width: 18px;
    height: 18px;
    top: 50px !important;
    left: 50px !important;
    border-radius: 7.5px;
    }
 >>> .shadow{
  box-shadow: 0px 3px 6px #0000000D !important;
}   

</style>