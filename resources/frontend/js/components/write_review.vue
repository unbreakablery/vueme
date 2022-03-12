<template>
  <div v-if="Object.keys(appointment).length > 0" class="container">
    <v-card-text class="pt-10">
      <v-row no-gutters>
        <v-col cols="12">
          <div
            :aria-label="appointment.psychic.profile.display_name"
            class="user_avatar mr-3"
            :style="{ 'background-image': 'url(' + appointment.psychic.profile.profile_headshot_url  + ')' }"
          ></div>
          <div class="primary--text h4 pt-3">
            <b>{{appointment.psychic.profile.display_name}}</b>
          </div>
        </v-col>

        <v-col class="mt-6" cols="6">
          <div>
            <b>Select your rating</b>
          </div>
          <div>
            <v-rating
              class="float-left starBtn"
              v-model="new_review.rating"
              background-color="#cccccc"
              color="amber"
              dense
            ></v-rating>
            <span v-if="new_review_errors.rating" class="float-left text-danger small">Select rating</span>
          </div>
        </v-col>
        <v-col class="mt-6 text-right" cols="6">
          <div>
            <b>Date</b>
          </div>
          <div>{{appointment.date | formatDate}}</div>
        </v-col>
        <v-col class="mt-6" cols="6">
          <div>
            <b>Service</b>
          </div>
          <div>{{appointment.service.name}}</div>
        </v-col>
        <v-col class="mt-6 text-right" cols="6">
          <div>
            <b>Reading</b>
          </div>
          <div>{{appointment.category.description}}</div>
        </v-col>
        <v-col cols="12" class="mt-5">
          <div class="mb-1">
            <b>Headline</b>
          </div>
          <v-text-field
            v-model="new_review.headline"
            label
            background-color="#F4F4F4"
            filled
            dense
            solo
            hide-details
          ></v-text-field>
          <span
            v-if="new_review_errors.headline"
            class="float-left text-danger small"
          >The headline field is required.</span>
        </v-col>
        <v-col cols="12" class="mt-5">
          <div class="mb-1">
            <b>Write a review</b>
          </div>
          <v-textarea
            v-model="new_review.text"
            solo
            dense
            background-color="#F4F4F4"
            filled
            hide-details
            placeholder
          ></v-textarea>
          <span
            v-if="new_review_errors.text"
            class="float-left text-danger small"
          >The text field is required</span>
        </v-col>
        <v-col class="mt-5 text-right">
          <v-btn
            color="primary"
            @click="submitReview"
            :loading="updatingReview"
            :disabled="updatingReview"
          >Submit</v-btn>
        </v-col>
      </v-row>
    </v-card-text>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import moment from "moment";
export default {
  data() {
    return {
      new_review: {
        token: this.appointment.token,
        rating: 0,
        headline: "",
        text: "",
        appointment: "",
      },
      new_review_errors: {
        rating: false,
        headline: false,
        text: false,
        appointment: "",
      },

      updatingReview: false,
    };
  },
  props: ["appointment"],
  components: {},
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
    review_text() {
      return this.new_review.text;
    },
    review_rating() {
      return this.new_review.rating;
    },
    review_title() {
      return this.new_review.headline;
    },
  },
  watch: {},
  methods: {
    submitReview() {
      this.setNewReview();
      if (
        !this.new_review_errors.rating &&
        !this.new_review_errors.headline &&
        !this.new_review_errors.text
      ) {
        this.updatingReview = true;
        axios
          .post("/api/v1/review/email/create", this.new_review)
          .then((response) => {
            console.log(response);
            this.$root.$emit("open_dialog_message", {
              message: "Review sent",
              message_title: "",
            });

            setTimeout(function () {
              location.href = "/";
            }, 1500);
          })
          .catch((error) => {
            this.$root.$emit("open_dialog_message", {
              message: "Something went wrong. Please try again.",
              message_title: "",
            });
            setTimeout(function () {
              location.href = "/";
            }, 2000);
          });
      }
    },
    setNewReview() {
      this.new_review.appointment = this.appointment.id;
      this.new_review.token = this.appointment.token;
      this.new_review_errors.rating = this.new_review.rating ? false : true;
      this.new_review_errors.headline = this.new_review.headline ? false : true;
      this.new_review_errors.text = this.new_review.text ? false : true;
    },
    f_checkReviewValidation(review_property) {
      switch (review_property) {
        case "text":
          this.new_review_errors.text = !this.new_review.text.replace(
            /\s+/g,
            ""
          );
          break;
        case "title":
          this.new_review_errors.headline = !this.new_review.headline.replace(
            /\s+/g,
            ""
          );
          break;
        case "rating":
          this.new_review_errors.rating = !this.new_review.rating;
          break;
        default:
          this.new_review_errors.rating = !this.new_review.rating;
          this.new_review_errors.headline = !this.new_review.headline.replace(
            /\s+/g,
            ""
          );
          this.new_review_errors.text = !this.new_review.text.replace(
            /\s+/g,
            ""
          );
      }
    },
  },
  created() {},
  watch: {
    review_text() {
      this.f_checkReviewValidation("text");
    },
    review_title() {
      this.f_checkReviewValidation("title");
    },
    review_rating() {
      this.f_checkReviewValidation("rating");
    },
  },
  filters: {
    formatDate(date, format = "MM/DD/YYYY") {
      return moment(date).format(format);
    },
  },
};
</script>
<style>
</style>