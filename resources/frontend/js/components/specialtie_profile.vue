<template>
  <div class="credit-container model-view-container">
    <div v-if="model != null" class="d-sm-flex d-block">
      <div class="model-profile">
        <div class="justify-content-between d-flex w-100 px-6">
          <v-tooltip v-model="showPopupClipboard" top>
            <template v-slot:activator="{ on }" :open-on-hover="false">
              <div class="pointer" @click="copyClipboard">
                <i class="fa fa-share-square"></i>
              </div>
            </template>
            <span>Link copied to clipboard</span>
          </v-tooltip>
          <div class="text-center">
            <div class="model-avatar" style="margin: 0 auto 5px auto;">
              <img
                :style="{
                  border: model.is_streaming_live ? '2px solid red;' : '0px',
                }"
                :src="model.profile.profile_headshot_url"
                :alt="model.profile.display_name"
              />
              <div v-if="model.is_streaming_live" class="badge">LIVE</div>
            </div>
            <h4 class="name text-center titleUser">{{ model.profile.display_name}}</h4>
            <p v-show="top10" class="rating">TOP 10% MODEL</p>
          </div>

          <v-tooltip top>
            <template v-slot:activator="{ on }">
              <div v-on="on" @click="setFavorite()" class="pointer">
                <i
                  class="fa"
                  :class="{
                    'fa-user-plus': !favorite,
                    'fa-user-minus': favorite,
                  }"
                  :style="{ color: favorite ? '#6537B1' : '#212121' }"
                ></i>
              </div>
            </template>
            <span>{{ !favorite ? "Follow" : "Stop Following " }}</span>
          </v-tooltip>
        </div>
        <div class="rsvp" v-show="livestream !== ''">
          <div class="text-center text-livestream">
            <i class="fas fa-broadcast-tower icon-size"></i
            ><span class="livestream">Livestream @ {{ livestream }}.</span>
          </div>
        </div>
        <div class="px-6 pb-5">



          <p
            class="description"
            style="line-break: anywhere; overflow-wrap: break-word"
          >
            {{ model.profile.description }}
          </p>
          <div class="mt-5 mb-5">
            <h5
              class="link"
              v-if="model.profile.intro_video_path"
              @click.prevent="
                video = true;
                videoAudioDialog = true;
              "
            >
              <a href=""
                ><i class="fas fa-video"></i
                ><span class="ml-1 link">Video Intro</span></a
              >
            </h5>



            

            <h5 class="link" v-if="model.profile.social_link_one">
              <a target="_blank" :href="model.profile.social_link_one"
                ><img src="/images/icons/link.svg" style="width: 18px"/>
                <span class="ml-1 link">{{
                  model.profile.social_link_one
                }}</span></a
              >
            </h5>
            <h5 class="link" v-if="model.profile.social_link_two">
              <a target="_blank" :href="model.profile.social_link_two"
                ><img src="/images/icons/link.svg" style="width: 18px"/>
                <span class="ml-1 link">{{
                  model.profile.social_link_two
                }}</span></a
              >
            </h5>
            
            <h5 class="link" v-if="model.profile.social_link_three">
                <a target="_blank" :href="model.profile.social_link_three">
                  <img src="/images/icons/gift.svg" style="width: 18px"/>
                  <span class="ml-1 link">Wishlist</span></a>
            </h5>
          </div>
          <v-btn
            :href="model.streaming_live"
            target="_blank"
            v-if="model.is_streaming_live"
            :class="[
              'py-5',
              'px-16',
              'btn-second',
              'mt-2',
              user && user.role_id == 1 ? 'disabled-button' : 'join-ls-button',
            ]"
            type="button"
            >Join Livestream
          </v-btn>
          <v-btn
            :class="[
              'py-5',
              'px-16',
              'btn-primary',
              'mt-2',
              user && user.role_id == 1 ? 'disabled-button' : '',
            ]"
            type="button"
            @click="privateRequest('schedule')"
            :disabled="user && user.role_id == 1"
          >
            <span style="font-size: 12px; font-weight: 600"
              >Schedule Private</span
            >
          </v-btn>
          <v-btn
            v-if="!model.user_subscribed"
            @click="
              subscribe(model.subscriptions.filter((i) => i.type == 'MEDIA')[0])
            "
            :class="[
              'py-5',
              'px-16',
              'btn-second',
              'mt-2',
              user && user.role_id == 1 ? 'disabled-button' : '',
            ]"
            type="button"
          >
            <span
              style="font-size: 12px; font-weight: 600"
              :class="[user && user.role_id == 1 ? '' : 'vip-club-color']"
              >VIP Club</span
            >
          </v-btn>
        </div>
      </div>

      <div class="w-100 view-profile">
        
        <div v-if="streams.lenght">
          <h3 class="text-center mb-3 recent-streams">Recent Streams</h3>
          <div class="flex justify-content-between">
            <div class="data_container" v-for="number in num" :key="number">
              <img class="user" :src="user1.user1_src2" alt="" />
              <p class="user_data">
                Laying in bed all alone tonight, care to lay down with me?
              </p>
              <div class="model-iconbar">
                <p><i class="fa fa-heart"></i>323</p>
                <p style="flex-grow: 1"><i class="fa fa-comment"></i>13</p>
                <i class="fa fa-share-square"></i>
              </div>
              <div class="fan-bar">
                <div style="userlist" class="d-flex">
                  <div><img :src="user1.user1_src3" alt="" /></div>
                  <div class="pl-5">
                    <p class="user2name">johnnyfan92</p>
                    <p class="user2content">
                      I just subscribed to you, can't wait to see what's in
                      store. Excited to share this journey with you
                    </p>
                    <div style="display: flex; place-content: flex-start">
                      <div class="iconbar">
                        <p><i class="fa fa-heart"></i>323</p>
                        <p><i class="fa fa-comment"></i>13</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div style="userlist" class="d-flex">
                  <div><img :src="user1.user1_src3" alt="" /></div>
                  <div class="pl-5">
                    <p class="user2name">johnnyfan92</p>
                    <p class="user2content">
                      I just subscribed to you, can't wait to see what's in
                      store. Excited to share this journey with you
                    </p>
                    <div style="display: flex; place-content: flex-start">
                      <div class="iconbar">
                        <p><i class="fa fa-heart"></i>323</p>
                        <p><i class="fa fa-comment"></i>13</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div style="text-align: center">
                <div v-if="number == 1" class="border"></div>
                <a class="load-more" href="javascript:void(0)"
                  >Load more comments</a
                >
              </div>
            </div>
          </div>
        </div>
        <div class="w-100 view-profile" v-else>
          <h3 class="text-center mb-3 recent-streams">No Livestreams Yet!</h3>
        </div>
      </div>
    </div>

    <v-dialog
      content-class="videoAudioDialog"
      elevation="0"
      class="video-audio"
      v-model="videoAudioDialog"
    >
      <v-card
        style="
          margin: auto;
          width: 100%;
          max-width: 700px;
          background-color: transparent;
        "
        @mouseover="hover = true"
        @mouseleave="hover = true"
      >
        <v-icon
          class="w-100 d-flex justify-end pb-2"
          style="color: #ffffff"
          @click="videoAudioDialog = false"
          >mdi-close-circle-outline</v-icon
        >
        <v-card-text class="pa-0">
          <div class="w-100 d-flex align-center justify-center">
            <video
              controls
              controlslist="nodownload"
              v-if="video"
              style="max-width: 700px; max-height: 500px"
              :poster="model.profile.intro_video_thumbnail"
            >
              <source
                v-bind:src="model.profile.intro_video_path"
                type="video/mp4"
              />
              <source
                v-bind:src="model.profile.intro_video_path"
                type="video/ogg"
              />
              Your browser does not support HTML5 video.
            </video>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["model", "user"],
  data: function () {
    return {
      num: [1, 2],
      user1: {
        user1_src2: "/images/model-dashboard/user1_2.png",
        user1_src3: "/images/model-dashboard/user1_3.jpg",
      },

      videoAudioDialog: false,
      video: false,
      top10: false, //change to show 10% top sign under profile picture
      livestream: "", //change to set livestream time Ex: 8PM EST
      showPopupClipboard: false,
      favorite: false,
      streams: [],
      disableStartNow: false,
    };
  },
  watch: {
    videoAudioDialog(val) {
      if (!val) {
        this.video = "";
      }
    },
  },
  methods: {
    privateRequest(type) {
      if (!this.user) {
        EventBus.$emit("open_login", { same_page_login: true });
        return;
      }
      EventBus.$emit("openrequestPrivate", {
        requestPrivate: type,
        model: this.model,
      });
    },

    subscribe(subscription) {
      if (!this.user) EventBus.$emit("open_login", { same_page_login: true });
      else {
        if (this.user.role_id == 1) return;
        EventBus.$emit("open-subscription", {
          subscription: subscription,
          model: this.model,
        });
      }
    },
    setFavorite() {
      if (!this.user) EventBus.$emit("open_login", { same_page_login: true });
      else {
        axios
          .post("favorite/saveFavorite", {
            id: this.model.id,
            type: this.favorite ? "remove" : "save",
          })
          .then((response) => {
            this.favorite = !this.favorite;
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
    copyClipboard() {
      this.showPopupClipboard = true;
      setTimeout(() => {
        this.showPopupClipboard = false;
      }, 2000);

      let textArea = document.createElement("textarea");
      textArea.value = window.location.href;
      document.body.appendChild(textArea);
      textArea.select();
      document.execCommand("copy");
      document.body.removeChild(textArea);
    },
    createLiveStream() {
      axios
        .post("/api/v1/specialist/channel")
        .then((response) => {
          if (response.data.status) {
            window.location.href = response.data.channel;
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
    },
  },
  created() {
    this.favorite = this.model.favorite;
  },
};
</script>

<style lang="scss" scoped>
.interested {
  font-size: 16px;
  color: #42424d;
  font-weight: 600;
  letter-spacing: 0;
  line-height: 1;
}
.text-livestream {
  padding: 10px 5px;
}
.icon-size {
  font-size: 15px;
}
.rsvp-btn {
  font-size: 12px;
  font-weight: 600;
  color: #42424d !important;
  text-align: center;
  letter-spacing: 0px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100px;
  height: 40px;
  text-align: center;
  border-radius: 12px;
  border: 2px solid #42424d;
  line-height: 40px;
  cursor: pointer;
  margin: auto;
}
.livestream {
  padding-left: 9px;
  font-size: 16px;
  color: #42424d;
  font-weight: 600;
  letter-spacing: 0;
  line-height: 1;
}
.rsvp {
  margin-bottom: 34px;
  text-align: center;
  background: transparent linear-gradient(250deg, #fcb6c9 0%, #82bef8 100%) 0%
    0% no-repeat padding-box;
  opacity: 1;
}
.border {
  display: none;
}
.model-view-container {
  max-width: 1280px;
  margin: auto;
  padding: 70px 0px 0px 0px;
  font-family: montserrat;
}
.model-profile {
  width: 355px;
  margin: 40px 0px 20px;
  padding-top: 30px;
  background: #fdfdfd 0% 0% no-repeat padding-box;
  box-shadow: 0px 4px 12px #0000001a;
  .model-avatar {
    min-width: 160px;
    width: 160px;
    position: relative;
    margin: 0 auto 20px auto;
    img {
      width: 100%;
      padding: 2px;
      border-radius: 100px;
      border: 2px solid red;
    }
    .badge {
      position: absolute;
      left: calc(50% - 25px);
      width: 50px;
      bottom: -10px;
      background-color: #fb5858;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 14px;
      color: white;
      font-weight: 500;
    }
  }
  p {
    font-weight: 500;
    color: #131220;
  }
  .name {
    font-size: 16px;
    font-weight: 600;
    color: #131220 !important;
  }
  .rating {
    font-size: 12px;
    color: #131220;
  }
  .description {
    font-size: 14px;
  }
  .link {
    color: #131220;
    font-size: 12px;
    margin-bottom: 10px !important;
    font-weight: 500;
  }
  .btn-primary {
    width: 100%;
    background: linear-gradient(256deg, #7272ff 0%, #9759ff 100%);
    box-shadow: 0 2px 4px #9759ff4d !important;
    border-radius: 12px !important;
    outline: none;
  }
  .btn-second {
    width: 100%;
    border: 2px solid #9759ff;
    border-radius: 12px;
    outline: none;
  }
}
@media (max-width: 450px) {
  .model-profile {
    margin: auto;
    margin-top: 20px;
    margin-bottom: 20px;
  }
  .view-profile {
    padding: 0 10px !important;
  }
  .load-more {
    display: none;
  }
}
</style>

<style scoped>
.join-ls-button {
  color: #e31616;
  border: 2px solid #e31616 !important;
}
.vip-club-color {
  color: #9759ff;
}
.disabled-button {
  opacity: 0.5;
}
.recent-streams {
  font-size: 18px;
  color: #6537b1;
  letter-spacing: 0;
  line-height: 22px;
  font-weight: 600;
  margin-top: 58px;
  margin-bottom: 20px !important;
}
@media screen and (max-width: 450px) {
  .recent-streams {
    /* display: none; */
  }
  .border {
    display: block;
    border-top: 1px solid #0000001a !important;
    padding: 0 10px 20px;
  }
}
.dolor {
  width: 265px;
  height: 86px;
  padding: 18px 0 0 16px;
  color: #1f1e34;
  font-family: montserrat;
  background: white;
  margin: 10px;
}
.dolor-text {
  opacity: 0.8;
  font-size: 14px;
  font-weight: 500;
}
.dolor-value {
  font-size: 20px;
  font-weight: 800;
}
.flex {
  display: flex;
}
.dolorbar {
  display: none;
}
.load-more {
  margin-bottom: 30px;
  color: #6537b1;
  font-size: 12px;
  font-weight: 600;
  text-decoration: none;
}
.data_container > img {
  max-width: 390px !important;
}
@media screen and (max-width: 992px) {
  .credit-container {
    padding: 30px 0px 0;
  }
}
@media screen and (max-width: 576px) {
  .flex {
    flex-direction: column;
    display: grid;
  }
  .insight {
    display: flex !important;
  }
  .m-mr-26 {
    margin: 0;
  }
  .dolorbar {
    display: flex;
  }
  p.text-center {
    color: #131220;
    font-size: 16px;
  }

  .data_container {
    margin-right: 0;
  }
  .user_data {
    font-size: 14px;
  }
  .iconbar {
    margin-bottom: 0 !important;
  }
  .fan-bar {
    display: none;
  }
  p.text-center {
    display: none;
  }
}
.fan-bar img {
  border-radius: 50%;
}
.view-profile {
  padding-bottom: 40px;
  padding-left: 19px;
  max-width: 823px;
}
.data_container {
  max-width: 390px;
  font-family: montserrat;
  font-weight: 600;
}
img.user {
  width: 100%;
  border-radius: 35px;
}
.user_data {
  color: #131220;
  margin: 19px 0 7px 0;
  line-height: 26px;
  font-size: 16px;
}
.iconbar {
  padding-left: 20px;
  justify-content: space-between;
  display: flex;
  font-family: montserrat;
  margin-bottom: 0px;
  font-size: 12px;
}
.model-iconbar {
  padding-left: 10px;
  justify-content: space-between;
  display: flex;
  font-family: montserrat;
  margin-bottom: 0px;
  font-size: 12px;
}
.iconbar i,
.model-iconbar i {
  color: #42424d;
  font-size: 16px;
}
.iconbar i.fa-heart,
.model-iconbar i.fa-heart {
  padding: 0 6px 0 3px;
  color: #9759ff;
}
.iconbar i.fa-comment,
.model-iconbar i.fa-comment {
  padding: 0 5px 0 13px;
  color: #42424d;
}
p.text-center {
  margin-bottom: 30px;
  color: #6537b1;
  font-size: 12px;
}
.userlist {
  display: flex;
  place-content: flex-start;
}
.userlist img {
  max-width: 40px;
  max-height: 40px;
  margin-right: 20px;
  border-radius: 50%;
}
.user2name {
  color: #131220;
  font-size: 14px;
  font-weight: 600;
  font-family: montserrat;
}
.user2content {
  color: #949498;
  font-size: 14px;
  font-family: montserrat;
  font-weight: 500;
  margin-bottom: 10px;
}
.insight {
  padding: 10px 0;
  display: none;
  font-size: 14px;
  font-weight: 600;
  color: #1f1e34;
  justify-content: space-between;
}
.insight i {
  font-size: 16px;
  opacity: 0.8;
  margin-right: 5px;
  color: #1f1e34;
}
</style>
