<template>
<div style="background-color:#fffeff" class="container-fluid px-0 px-md-3">
  <div class="row d-none d-md-block" style="height:60px;"></div> 
  <div class="row" style="text-align:left;">
    <div class="col-md-9 px-0">
       <div class="row">
             <div class="badge" v-if="ready"><span>LIVE</span></div>
       <div class="badge2" v-if="ready"><v-icon class="p-0" color="white" x-small left>mdi-eye </v-icon><span>{{rtm.users}}</span></div>
       <div id="remote-playerlist" class="col-12 px-0" v-if="user.role_id == 2" style="width: 100%;height: calc(100vh - 155px);background-color: black;"></div>
       <div id="local-player" class="col-12 px-0" v-if="user.role_id == 1" style="width: 100%; height: calc(100vh - 155px);background-color: black;">
                 
       </div>
       </div>
   
      <!-- <div><video
        id="my-video"
        class="video-js vjs-fluid"
        controls
        preload="auto"
        data-setup="{}"
      >
        <source :src="'https://dev.respectfully.com/hls/'+ this.streaming_key+'.m3u8'" type="application/x-mpegURL" res="9999" label="auto" />
        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
      </video></div> -->
      <div class="row pt-3 px-0 px-md-5">      
        <div v-if="user.role_id == 2" class="col-2 col-md-1">
             <img width="60" height="60" style="border-radius: 50%;" :src="model.profile.profile_headshot_url" alt=""/>
        </div>
        <div v-if="user.role_id == 2" class="col-10 col-md-7 px-0 pl-3">
            <div class="width:100%">
                <div class="row">
                  <div class="col-8 col-md-4 px-0">
                  <p style="font-size:18px;color:#131220;font-weight:600;">{{model.profile.display_name}}</p>
                  </div>
                  <div class="col-4 px-0">                    
                    <a style="font-size:14px;color:#a26bff;font-weight:600;"><img :src="user1.user1_src4" alt=""/> Wish List</a>
                  </div>
                </div>
            </div>
         <div class="mt-n4" style="width:100%;font-size:14px;color:#131220;font-weight:500;"><p>{{model.profile.tagline}}</p></div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
          <div class="row row mt-0 mt-md-6">
            <div class="col-6 text-right" style="align-self: center;">
               <p class="mt-5" style="color: #56595f;font-size:14px;display:inline;font-weight:600;">
                    <font class="mr-n1" style="font-weight:700;height:14px;font-size:16px;line-height:1px;display:inline;color:#e64f4f;" >·</font>
                    {{
                      /*get_time_unit("h") +
                      ":" +*/
                      get_time_unit("m") +
                      ":" +
                      get_time_unit("s")
                    }}
                  </p>
            </div>
            <div  v-if="user.role_id == 1" class="col-6">
              <v-btn             
              :loading="loading"
              :disabled="loading"
              style="color:#E31616;border: 2px solid #E31616 !important;height:28px !important;min-width: 64px !important;" class="py-0"
              type="button"
              >
              <span @click="end_live_strem" style="font-size: 12px;">End</span>
            </v-btn></div>
            <div class="col-md-6 mt-n7" v-if="user && user.role_id == 2">
              <v-row>
                <v-col  align="right" justify="right">
              <v-btn style="min-width:160px !important;" class="py-0 btn-action"
              type="button"
              >
              <span style="font-size: 12px;">Schedule Private</span>
              </v-btn>
              </v-col>
              </v-row>
              <v-row>
                <v-col  align="right" justify="right">
              <v-btn      
              @click="sendTip();"       
               style="color:#9759ff;border: 2px solid #9759ff !important;height:40px !important;min-width:160px !important;" class="py-0 mt-2"
              type="button"
              >
              <span style="font-size: 12px;">Send Tip</span>
              </v-btn>
              </v-col>
              </v-row>
            </div>
            <div id="log"></div>
          </div>
        </div>        
      </div>
    </div>
    <div class="col-md-3">
        <div style="border:1px solid #efeeef;">
         <div  style="width:100%;text-align:center;border:1px solid #efeeef;">
         <div class="pt-3" style="width:100%;text-align:center;border-bottom:1px solid #efeeef;"><p style="color:#1F1E34;font-size:12px;font-weight:600;">Chat</p></div>
        </div>
        <div class="row pt-2" v-for="n in 5" v-bind:key="n">
        <div class="col-md-2">
             <img :src="user1.user1_src3" alt=""/>
        </div>
        <div class="col-md-10">
            <div class="width:100%">
                <p style="font-size:14px;color:#131220;font-weight:600;">johnnyfan92</p>
            </div>
         <div class="mt-n2" style="width:100%;font-size:14px;color:#131220;font-weight:500;"><p>I just subscribed to you, can't wait to see what's in store. Excited to share this journey with you</p></div>
        </div>
        </div>
        </div>
    </div>
  </div>
</div>
</template>
<script>
    
import AgoraRTC from "agora-rtc-sdk-ng"
import AgoraRTM from 'agora-rtm-sdk'
export default {
  props: ['streaming_key', 'link','user','token','token_rtm','channel','model'],
  data: function () {
    return {
      hours: 0,
      minutes: 0,
      seconds: 0,
      timer: null,
      paused: false,
      num: [1, 2],
      user1: {
        user1_src1: "/images/model-dashboard/user1.png",
        user1_src2: "/images/model-dashboard/user1_2.png",
        user1_src3: "/images/model-dashboard/user1_3.jpg",
        user1_src4: "/images/model-dashboard/gift.png",
      },
      rtc: {
        // For the local client.
        client: null,
        // For the local audio and video tracks.
        localAudioTrack: null,
        localVideoTrack: null,
      },
      rtm: {
        client: null,
        channel: null,
        users: 0
      },
      options: {
        // Pass your app ID here.
        appid: "0e8db726de66470eb775e0140eff49d4",
        // Set the channel name.
        channel: this.channel,
        // Pass a token if your project enables the App Certificate.
        token: this.token,
          // Set the user role in the channel.
        role: this.user.role_id == 1 ? "host" : "audience",
        uid: this.user.id.toString(),
        audienceLatency: 2
      },
      localTracks:{
        videoTrack: null,
        audioTrack: null
      },
      remoteUsers:[],
      ready:false,
      loading:false,
      leftModel:null,
      leftUser: null,


      
    };
  },
   
    beforeDestroy() {
     clearInterval(this.timer);
    },
  mounted() {
      this.createClient()
      this.timer = setInterval(() => {
      this.increase_time_unit("s");
     }, 1000); 

     Echo.join(`stream.${this.channel}`)
    .here((users) => {
        console.log('here((users)',users);
    })
    .joining((user) => {
        console.log('  .joining((user) => {',user);
    })
    .leaving((user) => {
        console.log('.leaving((user) => {',user);
    })
   
   },
    methods:{

          sendTip(){
            EventBus.$emit("open-send-tip", {
              model: this.model
              });
           },

          end_live_strem(){
            
           
  //              this.rtc.client.getSessionStats((stats) => {
  //   console.log(`Current Session Duration: ${stats.Duration}`);
  //   console.log(`Current Session UserCount: ${stats.UserCount}`);
  //   console.log(`Current Session SendBytes: ${stats.SendBytes}`);
  //   console.log(`Current Session RecvBytes: ${stats.RecvBytes}`);
  //   console.log(`Current Session SendBitrate: ${stats.SendBitrate}`);
  //   console.log(`Current Session RecvBitrate: ${stats.RecvBitrate}`);
  // });
           
               this.loading = true;
                 this.rtm.channel.getMembers().then((collect)=>{ 
              axios.put("/api/v1/specialist/channel/"+this.channel+"/end",{collect})
                .then((res) => {         
                  console.log("res",res); 
                  if(res.data.success){
                    window.location.href = "/dashboard"   
                  }                      
                  
                }).catch((error) => {
                  console.log('Error',error);
                })
                .finally(() => {
                  this.loading = false;
                });
          })}, 
          async createClient(){

            console.log('token',this.token);
            console.log('channel',this.channel);
         
          // If Safari 12.1 or earlier is involved in the call, set codec as "h264"
          var client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });

          this.rtc.client = client
         
           if (this.options.role === "audience") {
                this.rtc.client.setClientRole(this.options.role, {level: this.options.audienceLatency});
                
                // add event listener to play remote tracks when remote user publishs.
                this.rtc.client.on("user-left", this.handleUserLeft);
            }
            else{
                this.rtc.client.setClientRole(this.options.role);
               
            }
           
       // join the channel
        this.options.uid = await this.rtc.client.join(this.options.appid, this.options.channel, this.options.token || null, this.options.uid || null); 
         this.rtc.client.on("user-published", this.handleUserPublished);
        this.rtc.client.on("user-unpublished", this.handleUserUnpublished);
         //this.rtc.client.on("peer-online", this.handleUserJoin);
          this.rtc.client.on("user-joined", this.handleUserJoin);
        
          
            // this.rtc.client.on("stream-removed", this.handleUserSteamRemoved);
        
        
         if (this.options.role === "host") {
          
        // create local audio and video tracks
        this.localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
        this.localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();
        // play local video track
        this.ready = true
        this.localTracks.videoTrack.play("local-player");
        // $("#publicher").text(`localTrack(${this.options.uid})`);
        // publish local tracks to channel
        await this.rtc.client.publish(Object.values(this.localTracks));
      

        console.log("publish success");
    }

    await this.createRTM();
    if (this.options.role === "host"){
       this.initCreditProccess();
    }
   

    

    },
  async createRTM(){
    const client = AgoraRTM.createInstance(this.options.appid)

              // Client Event listeners
          // Display messages from peer
          const self = this
          client.on('MessageFromPeer', function (message, peerId) {

              document.getElementById("log").appendChild(document.createElement('div')).append("Message from: " + peerId + " Message: " + message)
          })
          // Display connection state changes
          client.on('ConnectionStateChanged', function (state, reason) {

              document.getElementById("log").appendChild(document.createElement('div')).append("State changed To: " + state + " Reason: " + reason)

          })
          self.rtm.client = client;
          let channel = client.createChannel(this.options.channel)
  
          channel.on('ChannelMessage', function (message, memberId) {

              document.getElementById("log").appendChild(document.createElement('div')).append("Message received from: " + memberId + " Message: " + message)

          })
          // Display channel member stats
          channel.on('MemberJoined', function (memberId) {
               clearInterval(this.leftUser)
               self.rtm.users++;
              document.getElementById("log").appendChild(document.createElement('div')).append(memberId + " joined the channel")


          })
          // Display channel member stats
          channel.on('MemberLeft', function (memberId) {
             self.rtm.users--;
             this.leftUser = setInterval(this.collectUsers([memberId]), 5000); 
              document.getElementById("log").appendChild(document.createElement('div')).append(memberId + " left the channel")

          })
         console.log('this.options',this.options);
         await client.login({uid:this.options.uid,token:this.token_rtm})
         channel.join().then(()=>{
           document.getElementById("log").appendChild(document.createElement('div')).append("You have successfully joined channel " + channel.channelId)
         
         })
           let channels = await this.rtm.client.getChannelMemberCount([self.options.channel]);
           console.log('channels',channels);
           this.rtm.users = channels[self.options.channel]
           this.rtm.channel = channel
          
           
      

  },
    initCreditProccess(){
       var refreshIntervalId = setInterval(this.creditProccess, 60000);


    /* later */
    //clearInterval(refreshIntervalId);
    },
    creditProccess(){
        this.rtm.channel.getMembers().then((users)=>{
             console.log("send paymeny",users);
              this.collectUsers(users);
        })
      
    },
    collectUsers(users){
        axios.put("/api/v1/specialist/channel/"+this.channel+"/collect",{collect:users})
                .then((res) => {         
                  console.log("res",res); 
                  
                }).catch((error) => {
                  console.log('Error',error);
                })
                .finally(() => {
                  this.loading = false;
                });
    },
     creditProccessUser(){      
            
               axios.put("/api/v1/user/channel/"+this.channel+"/collect")
                .then((res) => {         
                  console.log("res",res); 
                  
                }).catch((error) => {
                  console.log('Error',error);
                })
                .finally(() => {
                  this.loading = false;
                  clearInterval(this.leftModel);
                });
    },

    handleUserSteamRemoved(){
      console.log('handleUserSteamRemoved');
    },
    handleUserJoin(){
     console.log('handleUserJoin'); 
     clearInterval(this.leftModel);
    },
    handleUserLeft(){
      this.leftModel = setInterval(this.creditProccessUser, 5000); 
      console.log('handleUserLeft');    
    },


  async leave() {
    for (trackName in this.localTracks) {
        var track = this.localTracks[trackName];
        if (track) {
            track.stop();
            track.close();
            this.localTracks[trackName] = undefined;
        }
    }

    // remove remote users and player views
    this.remoteUsers = [];
    $("#remote-playerlist").html("");

    // leave the channel
    await this.rtc.client?.leave();

    $("#local-player-name").text("");
    $("#host-join").attr("disabled", false);
    $("#audience-join").attr("disabled", false);
    $("#leave").attr("disabled", true);
    console.log("client leaves channel success");
},

async subscribe(user, mediaType) {
    const uid = user.uid;
    // subscribe to a remote user
    await this.rtc.client.subscribe(user, mediaType);
    console.log("subscribe success");
    if (mediaType === 'video') {
        const playerOld = $(`
      <div id="player-wrapper-${uid}">
        <p class="player-name">remoteUser(${uid})</p>
        <div id="player-${uid}" style="width: 1165px;height: 550px;" class="player"></div>
      </div>
    `);

      const player = $(`       
        <div id="player-${uid}" style="width: 100%;height: calc(100vh - 155px);" class="player"></div>     
    `);
        $("#remote-playerlist").append(player);
        user.videoTrack.play(`player-${uid}`);
    }
    if (mediaType === 'audio') {
        user.audioTrack.play();
    }
},

 handleUserPublished(user, mediaType) {

  
    this.subscribe(user, mediaType);
    console.log('handleUserPublished');
    const id = user.uid;
    this.remoteUsers[id] = user;
    console.log('this.remoteUsers',this.remoteUsers);
},

 handleUserUnpublished(user) {   
    
    const id = user.uid;
    delete this.remoteUsers[id];
    console.log('handleUserUnpublished',this.remoteUsers);
    $(`#player-wrapper-${id}`).remove();
},
    get_time_unit(tunit) {
      if (tunit == "s") {
        return this.seconds > 9 ? this.seconds : "0" + this.seconds;
      } else if (tunit == "m") {
        return this.minutes > 9 ? this.minutes : "0" + this.minutes;
      } else if (tunit == "h") {
        return this.hours;
      }
    },
    increase_time_unit(tunit) {
      if (!this.paused) {
        if (tunit == "s") {
          this.seconds < 59 ? this.seconds++ : (this.seconds = 0);
          if (this.seconds == 0) this.increase_time_unit("m");
        } else if (tunit == "m") {
          this.minutes < 59 ? this.minutes++ : (this.minutes = 0);
          if (this.minutes == 0) {
            this.increase_time_unit("h");
          }
        } else if (tunit == "h") {
          this.hours++;
        }
      }
    },
    },
};
</script>
<style scoped>
      .badge {
            position: absolute;
    left: 20px;
    width: 50px;
    top: 24px;
    background-color: #fb5858;
    padding: 5px 9px;  
    border-radius: 5px;
    font-size: 14px;
    color: white;
    font-weight: 500;
    z-index: 2;
      }
      .badge2 {
        position: absolute;
        left:80px;
        width: 62px;
        top: 24px;
        background-color: #463e31;
        padding: 2.5px 5px;
        border-radius: 5px;
        font-size: 14px;
        color: white;
        font-weight: 500;
        z-index: 2;
        max-height: 24px;
      }
</style>

