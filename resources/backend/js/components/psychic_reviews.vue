<template>
  <div :style="{ height: height }">
    <v-container class="row-gray-area p-0 ml-0">
      <v-row no-gutters>
        <v-col class="m-0 p-0">
          <div class="mb-1 mt-4 ml-4 subtitleDiv">Reviews</div>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="!loading">
      <v-row class="pt-0 mb-0 justify-space-between" no-gutters>
        <v-col
          :lg="4"
          :md="4"
          :sm="6"
          cols="6"
          class="text-lg-left text-center pb-0 pl-0"
        >
          <v-select
            v-model="date_filter"
            :items="date_filter_list"
            item-text="name"
            item-value="key"
            label="All Time"
            filled
            background-color="white"
            dense
            solo
            :height="32"
            class="widthSelect"
            :menu-props="{ contentClass: 'checkList-line' }"
            v-on:change="filterReviews"
            solo-inverted
            :style="[
              !$vuetify.breakpoint.smAndDown
                ? { width: '135px !important' }
                : { width: '135px !important', float: 'left' },
            ]"
          ></v-select>
        </v-col>
        <v-col
          :lg="4"
          :md="4"
          :sm="6"
          cols="6"
          class="text-lg-right text-right pb-0 pr-0"
        >
          <v-select
            v-model="status"
            :items="status_list"
            label="All Reviews"
            item-text="name"
            item-value="key"
            background-color="white"
            multiple
            filled
            dense
            solo
            class="widthSelect float-right"
            :menu-props="{ contentClass: 'checkList' }"
            v-on:change="filterReviews"
            :style="[
              !$vuetify.breakpoint.smAndDown
                ? { width: '135px !important' }
                : { width: '135px !important', float: 'right' },
            ]"
          >
            <template v-slot:selection="{ item, index }">
              <div v-if="status.length <= 1" class>{{ item.name }}</div>
              <span v-if="index === 1">Show Filtered</span>
            </template>
          </v-select>
        </v-col>
      </v-row>
      <v-container
        v-bind:id="mobile ? '' : 'scroll-target'"
        v-bind:class="[
          mobile ? 'm-0 p-0 overflow-y-scroll' : 'overflow-y-auto m-0 p-0',
        ]"
        v-bind:style="[mobile ? { height: newHeight } : '']"
      >
        <v-container
          v-if="reviews.length > 0"
          class="m-0 p-0"
          v-bind:style="[mobile ? '' : { height: newHeight }]"
          style="height: 100%"
        >
          <v-row
            v-for="review in reviews"
            :key="review.id"
            no-gutters
            class="pt-0"
          >
            <v-card
              class="mb-0 pt-0 pb-0 pl-0"
              width="100%"
              style="margin-bottom: 20px !important"
            >
              <v-col class="pl-0 listReviews">
                <div
                  :aria-label="review.user.profile.display_name"
                  class="user_avatar_rw badgeUser p-0 m-0"
                  :style="{
                    'background-image':
                      'url(' + review.user.profile.profile_headshot_url + ')',
                  }"
                ></div>

                <div class="reviews_info pl-0 ml-0 pl-0 pt-0">
                  <div class="h2Title pt-0 pb-0 pb-reviews">
                    {{ review.user.profile.name }}
                  </div>
                  <div
                    v-if="review.category"
                    class="textList subList pt-0 pb-0 pb-reviews"
                  >
                    {{ review.category.name }}
                  </div>
                  <div v-else class="textList subList pt-0 pb-0 pb-reviews">
                    Other
                  </div>
                  <div class="textList servList pt-0 pb-0">
                    {{ review.created_at | formatDate }}
                  </div>
                </div>

                <div class="reviews_msn pb-0">
                  <div
                    class="textList mb-0 d-flex"
                    style="padding-bottom: 10px !important"
                  >
                    <div class="float-left pr-3 pt-0 pb-0">
                      <b>{{ review.title }}</b>
                    </div>

                    <v-rating
                      class="float-left textRating starBtn"
                      v-model="review.rating"
                      background-color="#bcbec9"
                      color="amber"
                      readonly
                      dense
                    ></v-rating>
                  </div>
                  <div class="textList subList text-muted pb-lg-0 pb-3">
                    "{{ review.text }}"
                  </div>
                </div>

                <div
                  class="statusMsn textList"
                  v-bind:style="{
                    color: status_color(review.status) + ' !important',
                  }"
                >
                  {{ review.status }}
                </div>

                <!-- <v-chip :text-color="status_color(review.status)" color="white">{{
              review.status
                }}</v-chip>-->
              </v-col>

              <v-col
                v-if="review.replies.length > 0"
                cols="12"
                v-for="(reply, index) in review.replies"
                :key="reply.id"
                justify="end"
                class="m-0 mt-5"
              >
                <v-row>
                  <v-col
                    class="small text-muted pb-lg-0 pb-3 ml-auto"
                    :lg="8"
                    :md="8"
                    :sm="12"
                    cols="12"
                    >{{ reply.text }}</v-col
                  >
                  <v-col :lg="2" :md="2" :sm="12" cols="12" class="pt-2">
                    <div
                      :aria-label="reply.psychic.profile.display_name"
                      class="user_avatar mr-3"
                      :style="{
                        'background-image':
                          'url(' +
                          reply.psychic.profile.profile_headshot_url +
                          ')',
                      }"
                    ></div>
                  </v-col>
                </v-row>
              </v-col>
            </v-card>
          </v-row>
        </v-container>
      </v-container>
      <v-row
        v-if="!loading && reviews.length == 0"
        class="p-10 mb-0 justify-space-between white"
        no-gutters
      >
        <v-col class="p-10" style="padding: 20px !important"
          >There are no reviews</v-col
        >
      </v-row>
    </v-container>

    <v-dialog v-model="dialog" width="500">
      <v-card v-if="Object.keys(selectedReview).length > 0">
        <v-card-text class="pt-4">
          <v-row no-gutters>
            <v-col :lg="2" :md="2" :sm="12" cols="12">
              <div
                :aria-label="selectedReview.user.profile.display_name"
                class="user_avatar mr-3"
                :style="{
                  'background-image':
                    'url(' +
                    selectedReview.user.profile.profile_headshot_url +
                    ')',
                }"
              ></div>
            </v-col>
            <v-col>
              <div>
                <b>{{ selectedReview.title }}</b>
              </div>
              <div>
                <v-rating
                  class="float-left starBtn"
                  v-model="selectedReview.rating"
                  background-color="#bcbec9"
                  color="amber"
                  readonly
                  dense
                ></v-rating>
              </div>
            </v-col>
            <v-col cols="12" class="mt-5">
              <v-textarea
                v-model="reply_text"
                solo
                background-color="#F4F4F4"
                filled
                hide-details
                placeholder="Enter you reply"
              ></v-textarea>
            </v-col>
            <v-col class="mt-5 text-right">
              <v-btn
                color="primary"
                @click="submitReply"
                :loading="updating"
                :disabled="updating"
                >Submit</v-btn
              >
              <v-btn
                color="secondary"
                text
                @click="dialog = false"
                :disabled="updating"
                >Close</v-btn
              >
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment from "moment";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      height: window.innerHeight + "px",
      newHeight: window.innerHeight - 110 + "px",
      updating: false,
      reply_text: "",
      savingUserServices: false,
      usSaved: false,
      loading: true,
      reviews: [],
      dialog: false,
      selectedReview: {},
      errors: {
        user_services: [],
      },
      date_filter_list: [
        { name: "Last 6 months", key: 6 },
        { name: "Last 3 months", key: 3 },
        { name: "Last 2 months", key: 2 },
        { name: "All Time", key: "All" },
      ],
      status_list: [
        { name: "All Reviews", key: "All" },
        { name: "Posted", key: "Posted" },
        { name: "Pending", key: "Pending" },
        { name: "Unapproved", key: "Removed" },
      ],
      status: ["All"],
      date_filter: "All",
      message: "",
    };
  },

  filters: {
    formatDate(date) {
      return moment(date).format("MM/DD/YYYY");
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  methods: {
    /**
     * Prepare the component.
     */
    getReviews() {
      axios
        .get(
          "/api/v1/psychic/reviews?status=" +
            this.status +
            "&date_filter=" +
            this.date_filter
        )
        .then((response) => {
          this.reviews = response.data.data;
          this.reviews.forEach((review) => {
            if (review.status === "Removed") {
              review.status = "Unapproved";
            }
          });
          console.log(this.reviews);
          this.loading = false;
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

    submitReply() {
      this.updating = true;
      var input = { id: this.selectedReview.id, text: this.reply_text };
      axios
        .post("/api/v1/psychic/reviews/reply/save", input)
        .then((response) => {
          this.selectedReview.replies.push(response.data.reply);
          this.updating = false;
          this.selectedReview = {};
          this.dialog = false;
          this.reply_text = "";
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.updating = false;
        });
    },

    status_color(status) {
      var color = "";
      if (status == "Pending") {
        color = "#ffac3b";
      } else if (status == "Posted") {
        color = "#2cc05f";
      } else if (status == "Unapproved") {
        color = "#E85D4ECC";
      }
      return color;
    },
    filterReviews() {
      if (
        (this.status.length > 1) &
        this.status.includes("All") &
        (this.status[0] != "All")
      ) {
        this.status = ["All"];
        this.getReviews();
      } else if ((this.status.length > 1) & (this.status[0] == "All")) {
        this.status.shift();
        this.getReviews();
      } else if (this.status.length === 3) {
        this.status = ["All"];
        this.getReviews();
      } else {
        this.getReviews();
      }
    },
    openReplyDialog(review) {
      this.selectedReview = review;
      this.dialog = true;
    },
  },
  /**
   * Prepare the component (Vue 2.x).
   */ mounted() {
    this.getReviews();
  },
};
</script>
<style>
.v-list.v-select-list {
  overflow: hidden !important;
}

.icon-close {
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 5px;
  margin-top: 5px;
}

.badgeUser {
  padding: 0px 0px !important;
}

.pb-date {
  margin-bottom: 10px !important;
}

.user_avatar_rw {
  backface-visibility: hidden;
  display: inline-block;
  overflow: hidden;
  border-radius: 50%;
  width: 50px !important;
  height: 50px !important;
  background-size: cover;  
  margin: 0px 14px !important;
  padding: 0px !important;
}
#scroll-target::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
#scroll-target {
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}
.overflow-y-scroll {
  overflow-y: scroll;
}
</style>
