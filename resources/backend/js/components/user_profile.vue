<template>
  <div v-if="!loading" class="fan-edit-profile">
    <form class="form-dashboard" @submit="updateProfile">
      <div class="row">
        <div class="col-12 photo-margin">


          <div class="fan-image-input">
            <div id="profile-pic" class="overlay-upload-btn d-flex align-center">

              <div
                :aria-label="user.profile.display_name"
                class="user_avatar"
                :style="{ 'background-image': 'url(' + image  + ')' }"
              >
                <div class="hover">
                  <div class="btn-upload-wrapper">
                    <!--<input type="file" name="headshot_img" accept='image/*' @change="processFile($event)" data-img="profile-headshot-img" style="max-width: 100%;"/>-->
                    <input
                      data-img="profile-headshot-img"
                      accept="image/*"
                      type="file"
                      ref="input_img"
                      v-on:change="onFileChange"
                      id="file_upload"
                      style="max-width: 100%; width: 100%; height: 100%"
                    />
                    <br />
                    <i class="fas fa-camera"></i>
                    <br />Change
                  </div>
                </div>
              </div>

              <div v-if="!this.saveImage" @click="$refs.input_img.click()" class="fan-image-font"><h4 class="ml-6 mb-0" style="font-size: 14px; font-weight: 600; color: #F77F98;">Change/Edit</h4></div>

              <div style="margin-left: 20px;">
                <v-btn
                  v-if="this.saveImage"
                  color="primary"
                  :loading="savingImage"
                  :disabled="savingImage"
                  depressed
                  small
                  @click.prevent="upload"
                >Save</v-btn>
                <span class="text-success">{{message_upload}}</span>
              </div>

            </div>

          </div>

          

          <!-- <div class="fan-image-input">
            <div id="profile-pic" class="overlay-upload-btn d-flex align-center">
              <div
                :aria-label="user.profile.display_name"
                class="user_avatar"
                :style="{ 'background-image': 'url(' + image  + ')' }"
              >
                <div class="hover">
                  <div class="btn-upload-wrapper">
                    <input
                      data-img="profile-headshot-img"
                      accept="image/*"
                      type="file"
                      v-on:change="onFileChange"
                      id="file_upload"
                      style="max-width: 100%; width: 100%; height: 100%"
                    />
                    <br />
                    <i class="fas fa-camera"></i>
                    <br />Changeasd
                  </div>
                </div>
              </div>

              <div class="fan-image-font"><h4 class="ml-6 mb-0" style="font-size: 14px; font-weight: 600; color: #F77F98;">Chanhjgjge/Edit..</h4></div>
            </div>
          </div> -->
        </div>
      </div>

      <div class="mt-sm-5 mobile-margin">
        
        <div class="row">
          
          <div class="col-6 form-group">
            <label style="margin-bottom: 10px; width:100%"><h4 class="profile-input">First Name</h4></label>
            <v-text-field
              id="profile_name"
              outlined
              color="#13122066"
              v-model="user.profile.name"
              height="36"
              class="inputBlueClass"
            ></v-text-field>
            <span
              v-if="errors['profile.name']"
              class="float-left text-danger small"
            >{{ errors['profile.name'][0] }}</span>
          </div>
          <div class="col-6 form-group">
            <label style="margin-bottom: 10px; width:100%"><h4 class="profile-input">Last Name</h4></label>
            <v-text-field
              id="profile_last_name"
              outlined
              color="#13122066"
              v-model="user.profile.last_name"
              height="36"
              class="inputBlueClass"
            ></v-text-field>
            <span
              v-if="errors['profile.last_name']"
              class="float-left text-danger small"
            >{{ errors['profile.last_name'][0] }}</span>
          </div>
        </div>
      </div>

      <div class="row mt-sm-5 mobile-margin" style="margin-top:10px !important">
        <div class="col-sm-3 col-6 form-group">
          <label style="margin-bottom: 10px">
            <h4 class="profile-input">Country Code&nbsp;<span style="color: #E31616">*</span></h4>
          </label>
          <v-select
            id="phone_numbers_0_code2"
            :items="country_all"
            class="checkListDisabled"
            outlined
            color="#13122066"
            item-text="prefix"
            item-value="code2"
            autocomplete
            v-model="user.phone_numbers[0].code2"
            append-icon="ico-sort-arrows"
            :menu-props="{contentClass: 'checkList'}"
            height="36"
          >
            <template slot="selection" slot-scope="data">
              <!-- // HTML that describe how select should render selected items -->
              {{ data.item.country }}({{data.item.prefix}})
            </template>
            <template slot="item" slot-scope="data">
              <!-- // HTML that describe how select should render items when the select is open -->
              {{ data.item.country }}({{data.item.prefix}})
            </template>
          </v-select>
          <span
            v-if="errors['phone_numbers.0.code2']"
            class="float-left text-danger small"
          >{{ errors['phone_numbers.0.code2'][0] }}</span>
        </div>

        <div class="col-sm-3 col-6 form-group">
          <label style="margin-bottom: 10px"><h4 class="profile-input">Mobile&nbsp;<span style="color: #E31616">*</span></h4></label>
          <v-text-field
            id="phone_numbers_0_number"
            outlined
            color="#13122066"
            height="36"
            type="tel"
            v-model="user.phone_numbers[0].number"
            class="inputFontDisabled"
          ></v-text-field>
         
          <span
            v-if="errors['phone_numbers.0.number']"
            class="float-left text-danger small"
          >{{ errors['phone_numbers.0.number'][0] }}</span>
        </div>
        

        
       <div  class="col-sm-12 col-12 form-group email-description-mobile">
      <h5 style="color: #1F1E34;
    font-size: 12px;
    letter-spacing: 0;
    font-weight: 500;
    margin-bottom: 5px;
    padding-right: 10px;">* Your number will only be used to let you know when a fan is trying to reach you.</h5>
        </div>


        <div class="col-sm-6 col-12 form-group">
          <label style="margin-bottom: 10px"><h4 class="profile-input">Email&nbsp;<span style="color: #E31616">*</span></h4></label>
          <v-text-field
            id="email"
            outlined
            color="#13122066"
            height="36"
            v-model="user.email"
            class="inputFontDisabled"
          ></v-text-field>
          <span v-if="errors.email" class="float-left text-danger small">{{ errors.email[0] }}</span>
        </div>
      </div>

       <div class="col-sm-12 col-12 form-group email-description">
      <h5 style="color: #1F1E34;
    font-size: 12px;
    letter-spacing: 0;
    font-weight: 500;
    margin-bottom: 5px;
    padding-right: 10px;">* Your number will only be used to let you know when a fan is trying to reach you.</h5>
        </div>


        <v-col   cols="12" sm="6" style="padding-left:0 !important; padding-right:0 !important">
            <div class="input input_general_desing form-group" style="width: 100%">
             <label style="margin-bottom: 10px"><h4 class="profile-input">Timezone&nbsp;<span style="color: #E31616">*</span></h4></label>
              <v-select
                :items="timezonesSelect"
                style="border: solid 1px rgba(0, 0, 0, 0.38);"
                label="Select"
                class="checkRigth right-align"
                filled
                flat
                background-color="#fff"
                hide-details
                dense
                solo
                auto
                autocomplete
                v-model="user.profile.timezone"
                :menu-props="{ contentClass: 'checkList-lineBlue' }"
              ></v-select>
            </div>
          </v-col>




      <div class="form-group mt-5 save-btn-mobile">
        <!-- <button type="submit" class="btn btn-pink">Save</button> -->

        <v-btn
          type="submit"
          color="primary"
          width="160"
          class="profile-save"
          :loading="savingProfile"
        ><span class="text">Save Information</span></v-btn>

        <span style="color: #01BF16; font-size: 75%;" v-if="profileSaved">Successfully Saved.</span>
      </div>
    </form>
  </div>
</template>

<script>
import moment from "moment";
import image_cropper_label from "./psychic/image_cropper_labeltext";
const csrf = $('meta[name="csrf-token"]').attr("content");
export default {
  props: ["countries", "states", "timezones", "country_all"],
  data() {
    return {
      datepicker_menu: false,
      loading: true,
      savingProfile: false,
      profileSaved: false,
      user: { phone_numbers: [{ number: "" }] },
      profileObj: {},
      profile: {},
      errors: [],
      message: "",
      message_upload: "",
      gender: ["Male", "Female", { text: "Prefer Not to Say", value: null }],
      saveImage: false,
      savingImage: false,
      fileUploadFormData: new FormData(),
      image: "",
      edit_specialties: false,
      files: [],
      filesAudio: [],
      fileAudio: {},
      token: csrf,
      video: "",
      audio: "",
      upload_is_active: false,
      message_blob: {
        image: "",
        type: "",
      },
      edit_video: false,
      edit_audio: false,
      timezonesok: [],
      timezonesSelect: [],
    };
  },
  watch: {
    datepicker_menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
    },
  },
  computed: {
    years() {
      var years = [];
      var currentYear = new Date().getFullYear();
      for (var i = 1940; i <= currentYear; i++) {
        years.push(i);
      }
      return years.reverse();
    },
    computedDateOfBirth() {
      return this.user.profile.birth_date
        ? moment(this.user.profile.birth_date).format("MM-DD-YYYY")
        : "";
    },
  },

  methods: {
    save(date) {
      this.$refs.datepicker_menu.save(date);
    },
    f_get_mime(type) {
      return type.includes("image") ? "IMAGEB" : "VIDEOB";
    },
    updatetValue(value) {
      this.file = value[value.length - 1];
    },
    updateValueAudio(value) {
      this.fileAudio = value[value.length - 1];
    },
    upload() {
      /* var data = new FormData();
                 data.append('image', this.image);*/
      this.savingImage = true;
      axios
        .post("/api/v1/user/profile/images/save", this.fileUploadFormData)
        .then((response) => {

          this.message_upload = response.data.success.message;
          document.querySelector("#profile .v-image__image--cover").style.backgroundImage = "url('" + response.data.success.url + "')";
          // document.querySelector(
          //   ".row-top-bar .user_avatar_sm"
          // ).style.backgroundImage = "url('" + response.data.success.url + "')";
          // setTimeout(() => {
          //   this.message_upload = "";
          // }, 2000);

          this.errors = [];
          this.savingImage = false;
          this.saveImage = false;
          // EventBus.$emit('profile_upload', response.data.path);
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

          this.message = "";
          this.savingImage = false;
          this.saveImage = false;
        });
    },
    /**
     * Prepare the component.
     */
    getProfile() {
      axios
        .get("/api/v1/user/profile")
        .then((response) => {
          this.user = response.data.success.profile;
          // this.profile = response.data.success.profile.profile;
          this.image = this.user.profile.profile_headshot_url;

          this.loading = false;

          //this.setupDragDrop();
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
    updateProfile(e) {
      e.preventDefault();

      this.savingProfile = true;

      var input = this.user;

      axios
        .post("/api/v1/basicuser/profile/save", input)
        .then((response) => {
          setTimeout(() => {
            this.savingProfile = false;
            this.profileSaved = true;
            if (response.data && response.data.success) {
              /*document.querySelector("#sidebar #profile img").src =
                response.data.success.profile.profile_headshot_url;
              document.querySelector("#mobile-profile").src =
                response.data.profile.success.profile_headshot_url;*/
            }

            setTimeout(() => {
              this.profileSaved = false;
            }, 2000);
          }, 1000);

          this.message = response.data.message;
          this.errors = [];
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
            var key = Object.keys(this.errors)[0];
            var str = key.replace(/\./g, "_");

            $("html, body").animate(
              {
                scrollTop: $("#" + str).offset().top - 100,
              },
              1000
            );
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.savingProfile = false;
          this.message = "";
        });
    },

    processFile(event) {
      var reader = new FileReader();

      reader.onload = function (e) {
        document
          .getElementById(event.target.getAttribute("data-img"))
          .setAttribute("src", e.target.result);
      };

      reader.readAsDataURL(event.target.files[0]);
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
      this.fileUploadFormData.delete("headshot");
      this.fileUploadFormData.append("headshot", files[0]);
      this.saveImage = true;
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    addCredential() {
      this.user.credentials.push({
        id: null,
        institution_name: "",
        from_year: null,
        to_year: null,
        degree: "",
        area_of_study: "",
        description: "",
      });
    },
  }
  /**
   * Prepare the component (Vue 2.x).
   */,
  mounted() {
    this.getProfile();
    var entries = Object.entries(this.timezones);
    entries.forEach((the_s) => {
      this.timezonesSelect.push({
        text: the_s[0],
        value: the_s[1],
      });
    });
  },
};
</script>
<style>
.checkListDisabled .v-input__append-inner {
  margin-top: 7px!important;
}

.v-text-field.v-text-field--solo .v-input__control {
    min-height: 34px!important;
}

#app .v-menu__content .v-select-list {
    background-color: #fff !important;
}
#app .v-menu__content .v-list-item {
    padding-left: 8px !important;
}

</style>
