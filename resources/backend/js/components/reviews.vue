<template>
  <div class="fan-subscriptions">
    <v-row v-if="!loadingFavorite" no-gutters class="favorites">
      <v-col
        :class="$vuetify.breakpoint.smAndDown ? 'col col-12 pa-3 pa-md-4 pt-0' : 'p-0 m-0 col col-12'"
       >
       <v-hover
         v-for="item,index in favorites" :key="index" >
               <v-card
                v-if="!item.loading"
                class="mx-auto list_card"
                style="box-shadow: none!important;"
              >
                <div class="py-3">
                  <v-row class="m-0">
                    <div
                      v-if="item.online" color="#E31616"
                      :aria-label="item.profile.display_name"
                      class="user_avatar_lg"
                      :class="[item.online ?  'online' : 'offline']"
                      :style="{ 'background-image': 'url(' + item.profile.profile_headshot_url  + ')'}"
                    ></div>

                    <div
                      v-else color="grey"
                      :aria-label="item.profile.display_name"
                      class="user_avatar_lg"
                      :class="[item.online ?  'online' : 'offline']"
                      :style="{ 'background-image': 'url(' + item.profile.profile_headshot_url  + ')'}"
                    ></div>

                    <v-card-title class="justify_between d-flex p-0">
                      <div class="flex-row" style="position: relative">
                        <div class="col-12 pr-0 pl-2 pl-lg-3"
                          :style="{'font-size': !$vuetify.breakpoint.xsOnly ? '15px' : '14px',
                          'color':'#43425D',
                          'line-height': '1.5',
                          'word-break': 'break-word',
                          'overflow': 'hidden !important'}"
                        >
                          <h4 class="profile-display-name">{{ item.profile.display_name }}</h4>
                        </div>

                        <div
                          class="review-me pr-0 pl-2 pl-lg-3"
                          style="line-height: 1.5;"
                        >
                          <h6 class="profile-brunette">Brunette</h6>
                        </div>
                        <div class="pr-0 pl-1 pl-lg-2">
                          <v-badge v-if="item.online" style="z-index:10;" color="green" inline left>
                            <template v-slot:badge>{{''}}</template><span class="d-flex align-items-center online-status">ONLINE NOW</span>
                          </v-badge>
                        </div>
                      </div>
                      <div class="btn-set" >
                        <v-btn id="follow" type="submit" outlined color="#f77f98" rounded>Subscribed</v-btn>
                        <v-btn id="unfollow"  outlined color="#949498" rounded>Unsubscribe</v-btn>
                      </div>
                    </v-card-title>
                  </v-row>
                </div>
              </v-card>
              <v-sheet v-else color="grey lighten-4" style="min-height: 240px; background-color: #EBF4FD !important;">
                <v-row>
                  <v-col class="d-flex justify-start big-avatar align-center">
                    <v-skeleton-loader type="avatar"></v-skeleton-loader>
                    <v-skeleton-loader width="50%" type="text" class="ml-3"></v-skeleton-loader>
                  </v-col>
                </v-row>
                <div style="background-color: white !important;" class="pb-3 pt-2">
                  <v-row class="mt-10">
                  <v-col class="d-flex justify-start">
                    <v-skeleton-loader width="50%" type="text" class="ml-2"></v-skeleton-loader>
                  </v-col>
                </v-row>
                <v-row class="mt-4">
                  <v-col class="d-flex justify-end">
                    <v-skeleton-loader class="ml-3" type="button" style="border-radius: 10%; width: 90px" width="90"></v-skeleton-loader>
                  </v-col>
                </v-row>
                </div>
              </v-sheet>

      </v-hover>
      </v-col>
      <!-- <v-col cols="12" v-if="!favorites.length">
        <v-alert type="success">There are no favorites</v-alert>
      </v-col> -->
    </v-row>
    <v-row v-else>
      <v-col cols="12" class="mb-5" v-for="index in 4" :key="index">
        <v-sheet color="grey lighten-4" class="skeleton_sheet">
          <div class="skeleton_image">
            <v-col class="big-avatar">
              <v-skeleton-loader style="margin-top: -60px" type="avatar"></v-skeleton-loader>
            </v-col>
          </div>
          <div class="skeleton_text">
              <v-col cols-4>
                <v-skeleton-loader width="100%" type="text"></v-skeleton-loader>
              </v-col>
              <v-col cols-4 style="margin: 7px 0;">
                <v-skeleton-loader width="100%" type="text"></v-skeleton-loader>
              </v-col>
              <v-col cols-4>
                <v-skeleton-loader width="100%" type="text"></v-skeleton-loader>
              </v-col>
          </div>
          <div class="d-flex justify-between" style="width: 25%; align-items: center">
            <v-col>
              <v-skeleton-loader type="button"></v-skeleton-loader>
            </v-col>
            <v-col>
              <v-skeleton-loader type="button"></v-skeleton-loader>
            </v-col>
          </div>
        </v-sheet>
      </v-col>
    </v-row>
    <v-dialog
      content-class="videoAudioDialog"
      elevation="0"
      class="video-audio"
      v-model="videoAudioDialog"
    >
      <v-card
        style="max-width: 700px; max-height: 500px; background-color: transparent"
        @mouseover="hover = true"
        @mouseleave="hover = false"
      >
        <v-card-text class="pa-0">
          <v-icon v-show="!audio && (hover || mobile)" @click="videoAudioDialog = false">mdi-close</v-icon>
          <div class="w-100 d-flex align-center justify-center">
            <video
              controls
              controlslist="nodownload"
              v-if="video"
              style="max-width: 700px; max-height: 500px"
            >
              <source v-bind:src="item.profile.intro_video_path" type="video/mp4" />
              <source v-bind:src="item.profile.intro_video_path" type="video/ogg" />Your browser does not support HTML5 video.
            </video>

            <audio controls controlslist="nodownload" v-if="audio" style="max-width: 700px">
              <source v-bind:src="item.profile.intro_audio_path" />Your browser does not support the audio element.
            </audio>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      favorites: [],
      hover: false,
      videoAudioDialog: false,
      video: false,
      audio: false,
      item: {},
    };
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      items: "favorite/items",
      loadingFavorite: "favorite/loading",
    }),
  },
  watch: {
    videoAudioDialog(val) {
      if (!val) {
        this.audio = this.video = this.videoAudioDialog = false;
        this.item = {};
      }
    },
  },
  methods: {
    openVideoAudioDialog(item, video) {
      if (item.profile.intro_video_path || item.profile.intro_audio_path) {
        if (video) this.video = true;
        else this.audio = true;
        this.item = item;
        this.videoAudioDialog = true;
      }
    },
    getCategories(item) {
      let html = "";
      let categories = item.categories;
      for (let i = 0; i < categories.length; i++) {
        html =
          html +
          `<a class="cursor-pointer" href="${categories[i].url}" style="text-decoration: none; color:#8EBEF8!important"> ${categories[i].name} </a>`;
        break;
      }

      if (categories.length >= 1)
        html =
          html +
          `<a class="cursor-pointer" href="/${item.profile.profile_link}"
                            style="text-decoration: none; color: #8EBEF8!important"
                          ><span> • </span> +${categories.length - 1} more</a>`;
      //`<span> • </span> +${categories.length - 2} more`;

      return html;
    },
    saveFavorite(item) {
      if (!this.loadingFavorite)
        this.$store
          .dispatch("favorite/saveFavorite", { id: item.id, type: "remove" })
          .then(() => {
            this.favorites.splice(this.favorites.indexOf(item), 1);
          });
    },
  },
  created() {
    this.$store.dispatch("favorite/getItems").then(() => {
      this.favorites = this.items;
    });
  },
};
</script>

<style >
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}
.icon-close {
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 5px;
  margin-top: 5px;
}
.videoAudioDialog {
  width: auto;
  height: auto;
  max-width: 700px;
  max-height: 500px;
}

.videoAudioDialog .v-card__title {
  height: 30px;
  background-color: black;
  padding: 0px !important;
}

.videoAudioDialog .mdi-close {
  position: absolute !important;
  font-size: 30px;
  cursor: pointer !important;
  color: white;
  z-index: 100;
  position: absolute;
  margin-right: 5px;
  margin-top: 5px;
  right: 0px;
}

/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* .v-window__next,
.v-window__prev {
  background: transparent !important;
  border: 2px solid #a163c1;
  margin: 0 -4px !important;
}

.v-window__next,
.v-window__prev {
  margin: 0 -4px !important;
} */

.big-avatar .v-skeleton-loader__avatar {
  width: 120px;
  height: 120px;
}
.tagline--text {
    color: #656b72;
    font-weight: 600;
}
.review-me {
  letter-spacing: 0.2px;
  color: #949498;
  opacity: 1;
  font-weight: 600;
  font-size: 10px;
}
.justify_between {
  justify-content: space-between;
  flex: 1 1;
	flex-wrap: nowrap!important;
}

.skeleton_sheet {
  display: flex;
  justify-content: space-between;
  height: 120px;
}
.skeleton_image {
  width: fit-content;
  margin-top: 60px
}
.skeleton_text {
  width: 50%;
  display: flex;
  flex-direction: column;
  align-self: center;
}
</style>

